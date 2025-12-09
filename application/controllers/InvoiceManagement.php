<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InvoiceManagement extends CI_Controller
{

    public $data;
    private $ceh;
    private $_responseXML = '';

    function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('UserID')) && strpos($this->uri->uri_string(), md5('downloadInvPDF')) === false) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->model("task_model", "mdltask");

        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function _remap($method)
    {
        $methods = get_class_methods($this);

        $skip = array("_remap", "__construct", "get_instance");
        $a_methods = array();

        if (($method == 'index')) {
            $method = md5('index');
        }

        foreach ($methods as $smethod) {
            if (!in_array($smethod, $skip)) {
                $a_methods[] = md5($smethod);
                if ($method == md5($smethod) || $method == $smethod) {
                    $this->$smethod();
                    break;
                }
            }
        }

        if (!in_array($method, $a_methods)) {
            show_404();
        }
    }

    private function strReplaceAssoc(array $replace, $subject)
    {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }

    private function newGuid()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function ccurl($funcname, $servicename, $xmlbody)
    {
        try {
            $subdomain = $this->config->item("SUB_DOMAIN");
            $headers = array(
                "Content-Type:application/soap+xml;charset=UTF-8",
                'SOAPAction:  "http://tempuri.org/' . $funcname . '"',
                "Host: $subdomain.vnpt-invoice.com.vn"
            );

            $xml12 = $this->config->item('xmlv1.2');
            //            $xmlfomart = htmlentities($xml);
            $xmlsend = str_replace('XML_BODY', $xmlbody, $xml12);

            $curlOptions = array(
                CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
                CURLOPT_TIMEOUT => 120, // timeout on response
                CURLOPT_URL => "https://$subdomain.vnpt-invoice.com.vn/$servicename.asmx",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => 0, // Skip SSL Verification
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $xmlsend
            );

            $curl = curl_init();
            curl_setopt_array($curl, $curlOptions);
            $this->_responseXML = curl_exec($curl); //??? -> _responseXML = false??

            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ((int)$http_code != 200 || !$this->_responseXML) {
                $this->data['error'] = 'Thất bại: Giao dịch với Hệ Thống Hóa Đơn Điện Tử!';
                return false;
            }

            // if (!curl_errno($curl)) {
            //     $info = curl_getinfo($curl);
            //     log_message('error', $info['total_time'].' seconds to send a request to '.$info['url']."\n");
            // }

        } catch (Exception $e) {
            $this->data['error'] = $e->getMessage();
        }
        return true;
    }

    public function importAndPublish()
    {
        $is_eport = $this->input->post('is_eport') ? $this->input->post('is_eport') : "0";
        $datas = $this->input->post('datas') ? $this->input->post('datas') : array();
        $cusTaxCode = $this->input->post('cusTaxCode') ? $this->input->post('cusTaxCode') : '';
        $cusAddr = $this->input->post('cusAddr') ? htmlspecialchars($this->input->post('cusAddr')) : '';
        $cusName = $this->input->post('cusName') ? htmlspecialchars($this->input->post('cusName')) : '';
        $sum_amount = $this->input->post('sum_amount') != '' ? (float)str_replace(",", "", $this->input->post('sum_amount')) : '';
        $vat_amount = $this->input->post('vat_amount') != '' ? (float)str_replace(",", "", $this->input->post('vat_amount')) : '';
        $total_amount = $this->input->post('total_amount') != '' ? (float)str_replace(",", "", $this->input->post('total_amount')) : '';

        $inv_type = $this->input->post('inv_type') ? $this->input->post('inv_type') : 'VND';
        $currencyInDetails = isset($datas[0]["CURRENCYID"]) ? $datas[0]["CURRENCYID"] : "VND";
        $exchange_rate = $this->input->post('exchange_rate') != '' ? (float)str_replace(",", "", $this->input->post('exchange_rate')) : 1;
        $vatRate = isset($datas[0]["VAT_RATE"]) && $datas[0]["VAT_RATE"] != ""  ? (float)str_replace(",", "", $datas[0]["VAT_RATE"]) : "";

        $paymentMethod = $this->input->post('paymentMethod') ? $this->input->post('paymentMethod') : 'TM/CK';
        $shipInfo = $this->input->post('shipInfo') ? $this->input->post('shipInfo') : '';
        $note = $this->input->post('note') ? $this->input->post('note') : '';
        $roundNum = $this->config->item('ROUND_NUM') !== NULL ? $this->config->item('ROUND_NUM')[$inv_type] : 0; //ROUND_NUM_QTY_UNIT

        $pinPrefix = $this->config->item("PIN_PREFIX");
        $prefix = $is_eport ? $pinPrefix['EPORT'] : $pinPrefix['BL_CAS'];
        $pincode = $this->mdltask->generatePinCode($prefix);

        //view exchange rate
        $view_exchange_rate = '';
        if ($exchange_rate != 1) {
            $view_exchange_rate = $exchange_rate;
        }

        // if ($inv_type == $currencyInDetails) {
        //     $exchange_rate = 1;
        // }

        $sum_amount = round($sum_amount * $exchange_rate, $roundNum);
        $total_amount = round($total_amount * $exchange_rate, $roundNum);
        $vat_amount = round($vat_amount * $exchange_rate, $roundNum);

        $amount_in_words = $this->funcs->convert_number_to_words($total_amount, $inv_type); //doc tien usd - chinh laij ham doc tien
        $amount_in_words = htmlspecialchars(ucfirst($amount_in_words));

        $cusCode = trim($cusTaxCode);
        // $checkTaxCode = str_replace('-', '', $cusCode);
        // if (!in_array(strlen($checkTaxCode), array(10, 13)) || !is_numeric($checkTaxCode)) {
        //     $cusTaxCode = '';
        // }

        if ($vatRate === '') {
            $vatRate = "-1";
            $vat_amount = "";
        }

        $cusName = preg_replace("/[\n\r]/", "", $cusName);
        $cusAddr = preg_replace("/[\n\r]/", "", $cusAddr);

        //Thêm VAT8% ngày 2025-08-18
        $keyOfGross = "";
        $vatByRate = $vat_amount;
        $stringGross = "";
        switch ($vatRate) {
            case -1:
                $keyOfGross = "NONE";
                $stringGross = "<GrossValue_NonTax>$sum_amount</GrossValue_NonTax>";
                break;
            case 0:
            case 5:
            case 8:
                $keyOfGross = $vatRate;
                $stringGross = "<GrossValue$vatRate>$sum_amount</GrossValue$vatRate>
                                <VatAmount$vatRate>$vatByRate</VatAmount$vatRate>";
                break;
            case 10:
                $keyOfGross = $vatRate;
                $stringGross = "<GrossValue$vatRate>$sum_amount</GrossValue$vatRate>
                                <VatAmount$vatRate>$vatByRate</VatAmount$vatRate>";
                break;
            default:
                $keyOfGross = "KHAC";
                $stringGross = "<GrossValueOther>$sum_amount</GrossValueOther>
                                <VatAmountOther>$vatByRate</VatAmountOther>";
                break;
        }
        //
        $invData = <<<EOT
                <Inv>
                    <key>$pincode</key>
                    <Invoice>
                        <CusCode>$cusCode</CusCode>
                        <CusName>$cusName</CusName>
                        <CusAddress>$cusAddr</CusAddress>
                        <CusPhone></CusPhone>
                        <CusTaxCode>$cusTaxCode</CusTaxCode>
                        <PaymentMethod>$paymentMethod</PaymentMethod>
                        <CurrencyUnit>$currencyInDetails</CurrencyUnit>
                        <ExchangeRate>$exchange_rate</ExchangeRate>
                        <Products>
                            PRODUCT_CONTENT
                        </Products>
                        <Total>$sum_amount</Total>
                        <VATRate>$vatRate</VATRate>
                        <VATAmount>$vat_amount</VATAmount>
                        <Amount>$total_amount</Amount>
                        <AmountInWords>$amount_in_words</AmountInWords>
                        <Extra>$note</Extra>
                        <Extra1>$inv_type</Extra1>
                        <Extra2>$view_exchange_rate</Extra2>
                        <Extra6>$cusTaxCode</Extra6>
                        $stringGross
                    </Invoice>
                </Inv>
EOT;

        $product_content = <<<EOT
                <Product>
                    <Code>TRF_CODE</Code>
                    <ProdName>TRF_DESC</ProdName>
                    <ProdUnit>INV_UNIT</ProdUnit>
                    <ProdQuantity>QTY</ProdQuantity>
                    <ProdPrice>UNIT_RATE</ProdPrice>
                    <Total>AMT</Total>
                    <IsSum>0</IsSum>
                </Product>
EOT;
        // <IsSum>0</IsSum>
        // <!-- Tính chất * (0-Hàng hóa, dịch vụ; 1-Khuyến mại; 2-Chiết khấu thương mại (trong trường hợp muốn thể hiện thông tin chiết khấu theo dòng); 4-Ghi chú/diễn giải) -->
        $strFinal = '';
        $roundNumQty_Unit = $this->config->item('ROUND_NUM_QTY_UNIT') !== NULL ? $this->config->item('ROUND_NUM_QTY_UNIT') : 0;
        foreach ($datas as $item) { //UNIT_AMT
            if (is_array($item)) {
                $temp = $item['TRF_DESC'];

                $sz = isset($item["ISO_SZTP"]) ? $this->getContSize($item["ISO_SZTP"]) : (isset($item["SZ"]) ? $item["SZ"] : '');

                if ($sz != '') {
                    $temp .= " (" . $sz . $item['FE'] . ")";
                }

                //encode content of TRF_DESC because it contain <,> ..
                $item['TRF_DESC'] = htmlspecialchars(preg_replace("/[\n\r]/", "", $temp));
                $item['INV_UNIT'] = htmlspecialchars($this->mdltask->getUnitName($item['INV_UNIT']));

                //them moi lam tron so
                $urate = (float)str_replace(",", "", $item['UNIT_RATE']);
                $i_amt = (float)str_replace(",", "", $item['AMOUNT']);

                $item['QTY'] = round($item['QTY'], $roundNumQty_Unit); //lam tron so luong+don gia theo yeu cau KT
                $item['UNIT_RATE'] = round($urate * $exchange_rate, $roundNumQty_Unit); //lam tron so luong+don gia theo yeu cau KT
                $item['AMT'] = round($i_amt * $exchange_rate, $roundNum);

                unset($item['AMOUNT']);
                unset($item['SZ']);
                $strFinal .= $this->strReplaceAssoc($item, $product_content);
            }
        }

        if ($strFinal == '') {
            $this->data['results'] = "nothing to publish";
            echo json_encode($this->data);
            exit;
        }

        $xmlInvData = "<![CDATA[<Invoices>" . str_replace("PRODUCT_CONTENT", $strFinal, $invData) . "</Invoices>]]>";

        $p_acc = $this->config->item('VNPT_PUBLISH_INV_ID');
        $p_pwd = $this->config->item('VNPT_PUBLISH_INV_PWD');

        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        $inv_pattern = $this->config->item('INV_PATTERN');
        $inv_serial = $this->config->item('INV_SERIAL');

        $xmlphrase = <<<EOT
                <ImportAndPublishInv xmlns="http://tempuri.org/">
                    <Account>$p_acc</Account>
                    <ACpass>$p_pwd</ACpass>
                    <xmlInvData>INV_CONTENT</xmlInvData>
                    <username>$srv_acc</username>
                    <password>$srv_pwd</password>
                    <pattern>$inv_pattern</pattern>
                    <serial>$inv_serial</serial>
                    <convert>0</convert>
                </ImportAndPublishInv>
EOT;

        $xmlbody = str_replace("INV_CONTENT", $xmlInvData, $xmlphrase);
        //remove all space between tag
        $xmlbody = preg_replace('/(\>)(\s)+(\<)/', '$1$3', $xmlbody);

        log_message('error', 'importAndPublish.xmlbody: ' . $xmlbody);
        // log_message('error', $xmlbody);

        $isSuccess = $this->ccurl("ImportAndPublishInv", "PublishService", $xmlbody);

        if ($isSuccess) {
            $responseContent = $this->getResultData("ImportAndPublishInv");
            $responses = explode(":", $responseContent);
            if (count($responses) > 0) {
                if ($responses[0] == "ERR") {
                    $this->data['error'] = $this->getERR_ImportAndPublish($responses[1]);
                } elseif ($responses[0] == "OK") {
                    $invinfo = explode(";", $responses[1]);

                    if (count($invinfo) > 0) {
                        $this->data['pattern'] = $invinfo[0];
                        $this->data['serial'] = explode("-", $invinfo[1])[0];
                        $this->data['fkey'] = $pincode;
                        $this->data['invno'] = explode("_", $invinfo[1])[1];
                        // if ($this->data['fkey']) {
                        //     $this->confirmPaymentFkey($this->data['fkey']);
                        // }
                    } else {
                        $this->data['error'] = "nothing receive: $responseContent";
                    }
                } else {
                    $this->data['error'] = $responseContent;
                }
            } else {
                $this->data['error'] = $responseContent;
            }
        }

        echo json_encode($this->data);
        exit;
    }

    //business
    public function adjustInvoice()
    {
        $datas = $this->input->post('datas') ? $this->input->post('datas') : array();
        $cusTaxCode = $this->input->post('cusTaxCode') ? $this->input->post('cusTaxCode') : "";
        $cusAddr = $this->input->post('cusAddr') ? htmlspecialchars($this->input->post('cusAddr')) : "";
        $cusName = $this->input->post('cusName') ? htmlspecialchars($this->input->post('cusName')) : "";
        $inv_type = $this->input->post('inv_type') ? $this->input->post('inv_type') : 'VND';
        $roundNum = $this->config->item('ROUND_NUM')[$inv_type]; //ROUND_NUM_QTY_UNIT

        $sum_amount = $this->input->post('sum_amount') != "" ? (float)str_replace(",", "", $this->input->post('sum_amount')) : "";
        $vat_amount = $this->input->post('vat_amount') != "" ? (float)str_replace(",", "", $this->input->post('vat_amount')) : "";
        $total_amount = $this->input->post('total_amount') != "" ? (float)str_replace(",", "", $this->input->post('total_amount')) : "";
        $exchange_rate = $this->input->post('exchange_rate') != "" ? (float)str_replace(",", "", $this->input->post('exchange_rate')) : 1;
        $had_exchange = $this->input->post('had_exchange') ? (int)$this->input->post('had_exchange') : 0;

        $currencyInDetails = isset($datas[0]["CURRENCYID"]) ? $datas[0]["CURRENCYID"] : "VND";
        $paymentMethod = $this->input->post('paymentMethod') ? $this->input->post('paymentMethod') : 'TM/CK';
        $shipInfo = $this->input->post('shipInfo') ? $this->input->post('shipInfo') : "";
        $vat_rate = isset($datas[0]["VAT_RATE"]) && $datas[0]["VAT_RATE"] != ""  ? (float)str_replace(",", "", $datas[0]["VAT_RATE"]) : "";

        $old_pincode = $this->input->post('old_pincode');
        $isCredit = $this->input->post('isCredit') ? $this->input->post('isCredit') : '0';
        $adjust_type = $this->input->post('adjust_type');
        $adjust_note = $this->input->post('note');
        $isViewDraft = $this->input->post('isViewDraft') == '1';

        $view_exchange_rate = "";
        if ($exchange_rate != 1) {
            $view_exchange_rate = $exchange_rate;
        }

        if ($inv_type == $currencyInDetails || $had_exchange == 1) {
            $exchange_rate = 1;
        }

        $sum_amount = round($sum_amount * $exchange_rate, $roundNum);
        $total_amount = round($total_amount * $exchange_rate, $roundNum);
        $vat_amount = round($vat_amount * $exchange_rate, $roundNum);

        $display_amount_inwords = abs((float)$total_amount);
        $amount_in_words = $this->funcs->convert_number_to_words($display_amount_inwords, $inv_type); //doc tien usd
        $amount_in_words = htmlspecialchars($amount_in_words);

        $pincode = $this->mdltask->generatePinCode();

        $cusCode = trim($cusTaxCode);
        if ($vat_rate === "") {
            $vat_rate = "-1";
            $vat_amount = "0";
        }

        $cusName = preg_replace("/[\n\r]/", "", $cusName);
        $cusAddr = preg_replace("/[\n\r]/", "", $cusAddr);

        $keyOfGross = "";
        $vatByRate = $vat_amount;
        $stringGross = "";
        switch ($vat_rate) {
            case -1:
                $keyOfGross = "NONE";
                $stringGross = "<GrossValue_NonTax>$sum_amount</GrossValue_NonTax>";
                break;
            case 0:
            case 5:
            case 8:
                $keyOfGross = $vat_rate;
                $stringGross = "<GrossValue$vat_rate>$sum_amount</GrossValue$vat_rate>
                                <VatAmount$vat_rate>$vatByRate</VatAmount$vat_rate>";
                break;
            case 10:
                $keyOfGross = $vat_rate;
                $stringGross = "<GrossValue$vat_rate>$sum_amount</GrossValue$vat_rate>
                                <VatAmount$vat_rate>$vatByRate</VatAmount$vat_rate>";
                break;
            default:
                $keyOfGross = "KHAC";
                $stringGross = "<GrossValueOther>$sum_amount</GrossValueOther>
                                <VatAmountOther>$vatByRate</VatAmountOther>";
                break;
        }

        if ($adjust_type == '1') {
            $type = "";
            $mainTagXML = 'ReplaceInv';
            $function = $isViewDraft ? 'ReplaceInvoiceNoPublish' : 'ReplaceInvoiceAction';
        } else {
            $type = "<Type>$adjust_type</Type>";
            $mainTagXML = 'AdjustInv';
            $function = $isViewDraft ? 'AdjustInvoiceNoPublish' : 'AdjustInvoiceAction';
        }

        $invData = <<<EOT
            <$mainTagXML>
                <key>$pincode</key>
                <CusCode>$cusCode</CusCode>
                <CusName>$cusName</CusName>
                <CusAddress>$cusAddr</CusAddress>
                <CusPhone></CusPhone>
                <CusTaxCode>$cusTaxCode</CusTaxCode>
                <PaymentMethod>$paymentMethod</PaymentMethod>
                <KindOfService></KindOfService>
                <ShipName>$shipInfo</ShipName>
                <Products>
                    PRODUCT_CONTENT
                </Products>
                <Total>$sum_amount</Total>
                <VATRate>$vat_rate</VATRate>
                <VATAmount>$vat_amount</VATAmount>
                <Amount>$total_amount</Amount>
                <AmountInWords>$amount_in_words</AmountInWords>
                <CurrencyUnit>$inv_type</CurrencyUnit>
                <Extra>$adjust_note</Extra>
                <Extra1>$inv_type</Extra1>
                <ExchangeRate>$view_exchange_rate</ExchangeRate>
                <Note>$adjust_note</Note>
				$stringGross
                $type
            </$mainTagXML>
EOT;

        $product_content = <<<EOT
            <Product>
                <ProdName>TRF_DESC</ProdName>
                <ProdUnit>INV_UNIT</ProdUnit>
                <ProdQuantity>QTY</ProdQuantity>
                <ProdPrice>UNIT_RATE</ProdPrice>
                <Total>AMT</Total>
				<VATAmount>DTL_VAAT_AMOUNT</VATAmount>
            </Product>
EOT;
        // <Total>AMT</Total>

        //lam tron so luong+don gia theo yeu cau KT
        $roundNumQty_Unit = $this->config->item('ROUND_NUM_QTY_UNIT');
        $strFinal = "";
        foreach ($datas as $item) { //UNIT_AMT
            if (is_array($item)) {
                $temp = $item['TRF_DESC'];

                $sz = isset($item["ISO_SZTP"]) ? $this->getContSize($item["ISO_SZTP"]) : (isset($item["SZ"]) ? $item["SZ"] : '');

                if ($sz != '') {
                    $temp .= " (" . $sz . $item['FE'] . ")";
                }

                //encode content of TRF_DESC because it contain <,> ..
                $item['TRF_DESC'] = htmlspecialchars(preg_replace("/[\n\r]/", "", $temp));
                $item['INV_UNIT'] = htmlspecialchars($this->mdltask->getUnitName($item['INV_UNIT']));

                //them moi lam tron so
                $urate = (float)str_replace(",", "", $item['UNIT_RATE']);
                $i_amt = (float)str_replace(",", "", $item['AMOUNT']);

                $item['QTY'] = round($item['QTY'], $roundNumQty_Unit); //lam tron so luong+don gia theo yeu cau KT
                $item['UNIT_RATE'] = round($urate * $exchange_rate, $roundNumQty_Unit); //lam tron so luong+don gia theo yeu cau KT

                $item['AMT'] = round($i_amt * $exchange_rate, $roundNum);
                //Them tien thue vao detail trong truong hop hd co thue suat khac
                $item['DTL_VAAT_AMOUNT'] = $keyOfGross === "KHAC" ? $vatByRate : "";

                unset($item['AMOUNT']);
                unset($item['VAT']);
                unset($item['SZ']);
                $strFinal .= $this->strReplaceAssoc($item, $product_content);
            }
        }

        if ($strFinal == "") {
            $this->data['results'] = "nothing to adjust";
            echo json_encode($this->data);
            exit;
        }

        $xmlInvData = "<![CDATA[" . str_replace("PRODUCT_CONTENT", $strFinal, $invData) . "]]>";

        $p_acc = $this->config->item('VNPT_PUBLISH_INV_ID');
        $p_pwd = $this->config->item('VNPT_PUBLISH_INV_PWD');

        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        if ($isCredit == '1') {
            $configInvCre = $this->config->item('INV_CRE');
            $inv_pattern = $configInvCre['INV_PATTERN'];
            $inv_serial = $configInvCre['INV_SERIAL'];
        } else {
            $inv_pattern = $this->config->item('INV_PATTERN');
            $inv_serial = $this->config->item('INV_SERIAL');
        }

        $xmlphrase = <<<EOT
            <$function xmlns="http://tempuri.org/">
                <Account>$p_acc</Account>
                <ACpass>$p_pwd</ACpass>
                <xmlInvData>INV_CONTENT</xmlInvData>
                <username>$srv_acc</username>
                <pass>$srv_pwd</pass>
                <fkey>$old_pincode</fkey>
                <convert>0</convert>
                <pattern>$inv_pattern</pattern>
                <serial>$inv_serial</serial>
            </$function>
EOT;

        $xmlbody = str_replace("INV_CONTENT", $xmlInvData, $xmlphrase);
        //remove all space between tag
        $xmlbody = preg_replace('/(\>)(\s)+(\<)/', '$1$3', $xmlbody);

        log_message('error', 'adjustInvoice.xmlbody: ' . $xmlbody);
        $isSuccess = $this->ccurl($function, "BusinessService", $xmlbody);

        if ($isSuccess) {
            $responseContent = $this->getResultData($function, "s");
            $checkError = explode(" ", $responseContent);
            $errorInfo = $checkError[0];

            if (strpos($errorInfo, "ERR:") !== FALSE) {
                $moreInfo = isset($checkError[1]) ? $checkError[1] : "";
                $errorMsg = $this->getERR_AdjustInvoice(explode(":", $errorInfo)[1]);
                $this->data['error'] = $errorMsg . (!empty($moreInfo) ? "  >> " . $moreInfo : "");
                echo json_encode($this->data);
                exit;
            }

            if ($isViewDraft) {
                echo (json_encode([
                    'success' => true,
                    'html' => html_entity_decode($responseContent)
                ]));
                exit;
            }

            $responses = explode(":", $responseContent);
            if (count($responses) > 0 && $responses[0] == "OK") {
                $invinfo = explode(";", $responses[1]);

                if (count($invinfo) > 0) {
                    //1/002;C22TIN;TOS22122612499_277
                    $this->data['pattern'] = $invinfo[0];
                    $this->data['serial'] = $invinfo[1];
                    $this->data['fkey'] = $pincode;
                    $this->data['invno'] = explode("_", $invinfo[2])[1];
                    $this->data['hddt'] = 1; //them moi hd thu sau
                }
            } else {
                $this->data['error'] = $responseContent;
            }
        }

        echo json_encode($this->data);
        exit;
    }

    public function downloadInvPDF()
    {
        $portalURL = $this->config->item('VNPT_PORTAL_URL');
        $pattern = $this->input->get('pattern') ? $this->input->get('pattern') : '';
        $serial = $this->input->get('serial') ? $this->input->get('serial') : '';
        $number = $this->input->get('number') ? $this->input->get('number') : '';
        $fkey = $this->input->get('fkey') ? $this->input->get('fkey') : '';

        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        $funcName = $fkey != "" ? "downloadInvPDFFkeyNoPay" : "downloadInvPDFFkeyNoPay";
        $tagFindingInfo = $fkey != "" ? "<fkey>$fkey</fkey>" : "<token>$pattern;$serial;$number</token>";
        $xmlcontent = <<<EOT
        <$funcName xmlns="http://tempuri.org/">
          $tagFindingInfo
          <userName>$srv_acc</userName>
          <userPass>$srv_pwd</userPass>
        </$funcName>
EOT;
        $isSuccess = $this->ccurl($funcName, "PortalService", $xmlcontent);
        if ($isSuccess) {
            $responseContent = $this->getResultData($funcName);

            $errContent = '';
            switch ($responseContent) {
                case 'ERR:1':
                    $errContent = "Tài khoản đăng nhập sai!";
                    break;
                case 'ERR:6':
                    $errContent = "Không tìm thấy hóa đơn";
                    break;
                case 'ERR:7':
                    $errContent = "User name không phù hợp, không tìm thấy company tương ứng cho user.";
                    break;
                case 'ERR:11':
                    $errContent = "Hóa đơn chưa thanh toán nên không xem được";
                    break;
                case 'ERR:12':
                    $errContent = "Do lỗi đường truyền hóa đơn chưa được cấp mã cơ quan thuế (CQT), quý khách vui lòng truy cập sau để nhận hóa đơn hoặc truy cập link <a>$portalURL</a> để xem trước hóa đơn chưa có mã";
                    break;
                case 'ERR:':
                    $errContent = "Lỗi khác!";
                    break;
            }

            if ($errContent != '') {
                echo "<div style='width: 100vw;text-align: center;margin: -8px 0 0 -8px;font-weight: 600;font-size: 27px;color: white;background-color:#614040;line-height: 2;'>" . $errContent . "</div>";
                exit();
            }

            $name = $fkey != "" ? "$fkey.pdf" : "$number.pdf";
            $content = base64_decode($responseContent);
            header('Content-Type: application/pdf');
            header('Content-Length: ' . strlen($content));
            header('Content-disposition: inline; filename="' . $name . '"');
            echo $content;
        } else {
            echo $this->_responseXML;
        }
    }

    public function confirmPayment()
    {
        $fkeys = $this->input->post('fkeys') ? $this->input->post('fkeys') : '';
        $this->confirmPaymentFkey($fkeys);

        echo json_encode($this->data);
        exit;
    }

    public function cancelInv()
    {
        $fkey = $this->input->post('fkey') ? $this->input->post('fkey') : '';

        $p_acc = $this->config->item('VNPT_PUBLISH_INV_ID');
        $p_pwd = $this->config->item('VNPT_PUBLISH_INV_PWD');
        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        // bỏ gạch nợ hóa đơn trước khi hủy hóa đơn đó
        $isUnConfirm = $this->unConfirmPaymentFkey($fkey, $srv_acc, $srv_pwd);
        if (!$isUnConfirm) {
            echo json_encode($this->data);
            exit;
        }

        $xmlcontent = <<<EOT
        <cancelInv xmlns="http://tempuri.org/">
            <Account>$p_acc</Account>
            <ACpass>$p_pwd</ACpass>
            <fkey>$fkey</fkey>
            <userName>$srv_acc</userName>
            <userPass>$srv_pwd</userPass>
        </cancelInv>
EOT;
        $isSuccess = $this->ccurl("cancelInv", "BusinessService", $xmlcontent);

        if ($isSuccess) {
            $responseContent = $this->getResultData("cancelInv");
            $responses = explode(":", $responseContent);

            if (count($responses) > 0) {
                if ($responses[0] == "ERR") {
                    $this->data['error'] = $this->getERR_CancelInv($responses[1]);
                } else {
                    $this->data['success'] = true;
                }
            } else {
                $this->data['error'] = $responseContent;
            }
        }

        echo json_encode($this->data);
        exit;
    }

    public function confirmPaymentFkey($fkeys)
    {
        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        $strfkey = is_array($fkeys) ? implode("_", $fkeys) : $fkeys;
        $xmlphrase = <<<EOT
                <confirmPaymentFkey xmlns="http://tempuri.org/">
                  <lstFkey>$strfkey</lstFkey>
                  <userName>$srv_acc</userName>
                  <userPass>$srv_pwd</userPass>
                </confirmPaymentFkey>
EOT;
        $isSuccess = $this->ccurl("confirmPaymentFkey", "BusinessService", $xmlphrase);
        if ($isSuccess) {
            $responseContent = $this->getResultData("confirmPaymentFkey");
            if (strpos($responseContent, 'ERR') != false) {
                $this->data['error'] = $this->getERR_ConfirmPaymentFkey(explode(":", $responseContent)[1]);
            } elseif (strpos($responseContent, 'OK') != false) {
                $this->data['error'] = $responseContent;
            }
        }
    }

    private function unConfirmPaymentFkey($fkeys, $srv_acc, $srv_pwd)
    {
        $strfkey = is_array($fkeys) ? implode("_", $fkeys) : $fkeys;
        $xmlphrase = <<<EOT
                <UnConfirmPaymentFkey xmlns="http://tempuri.org/">
                  <lstFkey>$strfkey</lstFkey>
                  <userName>$srv_acc</userName>
                  <userPass>$srv_pwd</userPass>
                </UnConfirmPaymentFkey>
EOT;
        $isSuccess = $this->ccurl("UnConfirmPaymentFkey", "BusinessService", $xmlphrase);

        $errContent = '';
        if ($isSuccess) {
            $responseContent = $this->getResultData("UnConfirmPaymentFkey");
            switch ($responseContent) {
                case "ERR:1":
                    $errContent = "Tài khoản đăng nhập sai";
                    break;
                case "ERR:6":
                    $errContent = "Không tìm thấy hóa đơn tương ứng chuỗi đưa vào";
                    break;
                case "ERR:13":
                    $errContent = "";
                    break;
                case "ERR:7":
                    $errContent = "Không bỏ gạch nợ được";
                    break;
                default:
                    $errContent = $responseContent;
                    break;
            }
        }

        if ($errContent != '') {
            $this->data["error"] = $errContent;
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function getResultData($funcname, $regType = "")
    {
        if (!$this->_responseXML || $this->_responseXML == "") {
            return "";
        }
        $funcresult = $funcname . "Result";
        $regx = <<<EOT
        /\<$funcresult\>(.*)\<\/$funcresult\>/$regType
EOT;

        preg_match($regx, $this->_responseXML, $result);
        return count($result) > 1 ? $result[1] : "";
    }
    private function getERR_ImportAndPublish($errnumber)
    {
        $result = '';
        switch ($errnumber) {
            case "1":
                $result = "Tài khoản đăng nhập sai hoặc không có quyền thêm khách hàng";
                break;
            case "3":
                $result = "Dữ liệu xml đầu vào không đúng quy định";
                break;
            case "7":
                $result = "User name không phù hợp, không tìm thấy company tương ứng cho user.";
                break;
            case "20":
                $result = "Pattern và serial không phù hợp, hoặc không tồn tại hóa đơn đã đăng kí có sử dụng Pattern và serial truyền vào";
                break;
            case "5":
                $result = "Không phát hành được hóa đơn.";
                break;
            case "10":
                $result = "Lô có số hóa đơn vượt quá max cho phép";
                break;
            default:
                $result = "Lỗi phát hành hoá đơn, mã lỗi: " . $errnumber;
                break;
        }
        return $result;
    }

    private function getERR_ConfirmPaymentFkey($errnumber)
    {
        $result = '';
        switch ($errnumber) {
            case "1":
                $result = "Tài khoản đăng nhập sai";
                break;
            case "6":
                $result = "Không tìm thấy hóa đơn tương ứng chuỗi đưa vào";
                break;
            case "7":
                $result = "Không gạch nợ được";
                break;
            case "13":
                $result = "Hóa đơn đã được gạch nợ";
                break;
            default:
                $result = "[$errnumber] Unknown error";
                break;
        }
        return $result;
    }

    private function getERR_AdjustInvoice($errnumber)
    {
        $result = "";
        switch ($errnumber) {
            case "1":
                $result = "Tài khoản đăng nhập sai hoặc không có quyền thêm khách hàng";
                break;
            case "2":
                $result = "Hóa đơn cần điều chỉnh không tồn tại";
                break;
            case "3":
                $result = "Dữ liệu xml đầu vào không đúng quy định";
                break;
            case "5":
                $result = "Không phát hành được hóa đơn";
                break;
            case "6":
                $result = "Dải hóa đơn cũ đã hết";
                break;
            case "7":
                $result = "User name không phù hợp, không tìm thấy company tương ứng cho user.";
                break;
            case "8":
                $result = "Hóa đơn cần điều chỉnh đã bị thay thế. Không thể điều chỉnh được nữa.";
                break;
            case "9":
                $result = "Trạng thái hóa đơn không được điều chỉnh";
                break;
            case "13":
                $result = "Fkey của hóa đơn mới đã tồn tại trên hệ thống";
                break;
            case "14":
                $result = "Lỗi trong quá trình thực hiện cấp số hóa đơn";
                break;
            case "15":
                $result = "Lỗi khi thực hiện Deserialize chuỗi hóa đơn đầu vào";
                break;
            case "19":
                $result = "Pattern truyền vào không giống với hóa đơn cần điều chỉnh";
                break;
            case "20":
                $result = "Dải hóa đơn hết, User/Account không có quyền với Serial/Pattern và serial không phù hợp";
                break;
            case "29":
                $result = "Lỗi chứng thư hết hạn";
                break;
            case "30":
                $result = "Danh sách hóa đơn tồn tại ngày hóa đơn nhỏ hơn ngày hóa đơn đã phát hành";
                break;
            default:
                $result = "Lỗi phát hành hoá đơn, mã lỗi: " . $errnumber;
                break;
        }
        return $result;
    }

    private function getERR_CancelInv($errnumber)
    {
        $result = '';

        switch ($errnumber) {
            case "1":
                $result = "Tài khoản đăng nhập sai";
                break;
            case "2":
                $result = "Không tồn tại hóa đơn cần hủy";
                break;
            case "8":
                $result = "Hóa đơn đã được thay thế rồi, hủy rồi";
                break;
            case "9":
                $result = "Trạng thái hóa đơn ko được hủy";
                break;
            default:
                $result = "[$errnumber] Unknown error";
                break;
        }

        return $result;
    }

    private function getContSize($sztype)
    {
        if (!isset($sztype)) {
            return "";
        }

        switch (substr($sztype, 0, 1)) {
            case "2":
                return 20;
            case "4":
                return 40;
            case "L":
            case "M":
            case "9":
                return 45;
            default:
                return "";
        }

        return "";
    }
}
