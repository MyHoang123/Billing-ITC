<?php
defined('BASEPATH') OR exit('');

class invoice_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item('YARD_ID');
    }

    public function generate_PinCode($digits = 8){
        $chk = array();

        $query = <<<EOT
        SELECT COUNT(rowguid) COUNTA FROM EIR
            WHERE PinCode = '?' AND YARD_ID = '?'
        union
        SELECT COUNT(rowguid) COUNTA FROM SRV_ODR
            WHERE PinCode = '?' AND YARD_ID = '?'
EOT;
        do{
            $nb = rand(1, pow(10, $digits)-1);
            $nb = substr("0000000".$nb, -8);
            
            $chk = $this->ceh->query( $query, array($nb, $this->yard_id, $nb, $this->yard_id) )->result_array();
        }while( array_sum( array_column($chk, 'COUNTA') ) > 0 );

        return $nb;
    }

    public function generatePinCode($prefix = '', $digits = 5)
    {
        if( $prefix == '' ){
            $prefix = $this->config->item('PIN_PREFIX')['BL_CAS'];
        }
        
        $yearmonth = date('ym');
        $file = APPPATH . "/cache/pins_billing_$prefix" . date('Y') . ".txt";
        $fp = fopen($file, "a+");

        do {
            $getLock = flock($fp, LOCK_EX | LOCK_NB);
            if ($getLock) {
                $filesz = filesize($file);
                $content = $filesz > 0 ? fread($fp, $filesz) : $this->retrieveInMonthPinCodes($prefix, $yearmonth, $digits);
                $temps = !empty($content) ? explode(':', $content) : array();
                $isDuplicate = true;
                do {
                    $randomNum = rand(1, pow(10, $digits) - 1);
                    if (count($temps) > 0 && $temps[0] == $yearmonth) { //trong ngay
                        $checkpins = array();
                        if (isset($temps[1]) && !empty($temps[1]) && $temps[1] !== '') {
                            $listOfPin = explode('|', $temps[1]);
                            $checkpins = array_filter($listOfPin, function ($p) {
                                return !empty($p) && $p !== '';
                            });
                        }

                        $duplicatePin = array_filter($checkpins, function ($p) use ($randomNum) {
                            return (int)trim($p) === (int)$randomNum;
                        });
                        $isDuplicate = count($duplicatePin) > 0;
                    } else { //sang ngay moi
                        $content = "$yearmonth:";
                        $isDuplicate = false;
                    }
                } while ($isDuplicate);

                $content .= "$randomNum|";
                //truncate file
                ftruncate($fp, 0);
                //save to file
                fwrite($fp, $content);
                //unlock file
                flock($fp, LOCK_UN);
            }
        } while (!$getLock);

        fclose($fp);

        $result = "$prefix$yearmonth" . substr("00000000000000" . $randomNum, -$digits);
        return $result;
    }

    public function retrieveInMonthPinCodes($prefix, $yearmonth, $digits)
    {
        //[ITC1][2106][00000]
        $lenOfYearMonth = strlen($yearmonth);
        $lenOfPrefix = strlen($prefix);
        $startSubStrPin =  $lenOfPrefix + $lenOfYearMonth + 1;
        $startSubStrYM = $lenOfPrefix + 1;

        $query = <<<EOT
        select substring(pincode, $startSubStrPin, $digits) AS PIN from eir
            where substring(pincode, 1, $lenOfPrefix) = ?
            and substring(pincode, $startSubStrYM, $lenOfYearMonth) = ?
            and right(pincode, 3) = '001' and yard_id = ?
        union
        select substring(pincode, $startSubStrPin, $digits) AS PIN from srv_odr
            where substring(pincode, 1, $lenOfPrefix) = ?
            and substring(pincode, $startSubStrYM, $lenOfYearMonth) = ?
            and right(pincode, 3) = '001' and yard_id = ?
EOT;
        $params = array(
            $prefix, $yearmonth, $this->yard_id,
            $prefix, $yearmonth, $this->yard_id
        );

        $temp = $this->ceh->query($query, $params)->result_array();
        if (count($temp) == 0) {
            return '';
        }

        $pinStr = implode('|', array_unique(array_column($temp, 'PIN')));
        return $yearmonth . ":$pinStr|";
    }

    public function checkInvNo( $inv_prefix, $invNo ){
        $this->ceh->select('INV_NO_PRE');

        $this->ceh->where('INV_PREFIX', $inv_prefix);
        $this->ceh->where('INV_NO_PRE', $invNo);
        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->limit(1);
        $this->ceh->order_by( "INV_NO_PRE", "DESC" );
        $stmt = $this->ceh->get('INV_VAT')->row_array();

        return $stmt !== null && count( $stmt ) > 0;
    }

    public function loadCntrClass()
    {
        $this->ceh->select('CLASS_Code, CLASS_Name');
        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->order_by('CLASS_Code', 'ASC');
        $stmt = $this->ceh->get('CLASS_MODE');
        return $stmt->result_array();
    }

	public function getPaymentMethod($type = '')
    {
        $this->ceh->select('rowguid, ACC_CD, ACC_NO, ACC_TYPE, ACC_NAME')->where('YARD_ID', $this->yard_id);
        if( $type != '' ) {
            $this->ceh->where('ACC_TYPE', $type);
        }

        $stmt = $this->ceh->get('ACCOUNTS');
        return $stmt->result_array();
    }

	public function loadInvoiceForAdjust($args = array())
    {
        $this->ceh->select("iv.rowguid AS rowguid_inv, iv.INV_NO, iv.PinCode, iv.ShipKey, iv.ShipID, iv.ShipYear, iv.ShipVoy, iv.PAYER, iv.PAYER_TYPE
                            , iv.ACC_CD, iv.RATE, iv.AMOUNT AS IV_AMOUNT, iv.VAT AS IV_VAT, iv.DIS_AMT as IV_DIS_AMT, iv.TAMOUNT as IV_TAMOUNT
                            , iv.CURRENCYID, iv.INV_TYPE, iv.TPLT_NM, iv.INV_PREFIX, iv.INV_NO_PRE, iv.CreatedBy

                            , dft.rowguid AS rowguid_draft, dft.DRAFT_INV_NO, dft.REF_NO, dft.LOCAL_INV AS PAYMENT_FOR
                            , dtl.rowguid, dtl.TRF_DESC_MORE, dtl.INV_UNIT
                            , dtl.IX_CD, dtl.CARGO_TYPE, dtl.FE, dtl.SZ, dtl.JOB_KIND, dtl.CNTR_JOB_TYPE, dtl.IsLocal, dtl.DMETHOD_CD, dtl.EQU_TYPE
                            , dtl.TRF_CODE, dtl.TRF_DESC, dtl.QTY, dtl.standard_rate, dtl.UNIT_RATE, dtl.AMOUNT, dtl.VAT_RATE, dtl.VAT, dtl.TAMOUNT, dtl.Remark
                            , vs.ImVoy, vs.ExVoy, vv.ShipName");
        $this->ceh->join("INV_DFT dft", "dft.INV_NO = iv.INV_NO AND dft.YARD_ID = iv.YARD_ID", "left");
        $this->ceh->join("INV_DFT_DTL dtl", "dtl.DRAFT_INV_NO = dft.DRAFT_INV_NO AND dtl.YARD_ID = dft.YARD_ID", "left");
        $this->ceh->join("VESSEL_SCHEDULE vs", "vs.ShipKey = iv.ShipKey AND vs.YARD_ID = iv.YARD_ID", "left");
        $this->ceh->join("VESSELS vv", "vv.ShipID = iv.ShipID AND vv.YARD_ID = iv.YARD_ID", "left");
        $this->ceh->where('iv.PAYMENT_STATUS', 'Y');
        if (count($args) > 0) {
            $this->ceh->where('iv.INV_TYPE', $args['paymentType']);
            $this->ceh->where("iv." . $args['searchCol'], $args['searchVal']);
        }

        $this->ceh->where("iv.YARD_ID", $this->yard_id);
        $this->ceh->order_by("iv.INV_DATE", 'DESC');

        $tmp = $this->ceh->get("INV_VAT iv");
        $tmp = $tmp->result_array();

        return $tmp;
    }

    public function loadDraft( $args = array() )
    {
        $this->ceh->select( "dft.REF_NO, dft.ShipID, dft.ShipKey, dft.ShipYear, dft.ShipVoy, dft.DRAFT_INV_NO, dft.DRAFT_INV_DATE
                            , dft.PAYER, dft.AMOUNT, dft.VAT, dft.TAMOUNT, dft.CURRENCYID, dft.INV_TYPE, dft.OPR, dft.PAYER_TYPE, dft.PAYMENT_STATUS
                            , dft.REF_NO, cm.CusName, invd.DRAFT_INV_NO_PRO" );
        $this->ceh->join( "CUSTOMERS cm", "cm.CusID = dft.PAYER AND cm.YARD_ID = dft.YARD_ID", "left" );
        $this->ceh->join( "INV_DFT_DRAFT invd", "invd.DRAFT_INV_NO_PRO = dft.DRAFT_INV_NO", "left" );
        $this->ceh->where( "dft.DRAFT_INV_DATE >=", $args["FromDate"] );
        $this->ceh->where( "dft.DRAFT_INV_DATE <=", $args["ToDate"] );
        $this->ceh->where( "dft.PAYMENT_STATUS IN('Y', 'U') ");
        $this->ceh->where( "dft.INV_NO IS NULL" );
        $this->ceh->where( "dft.YARD_ID", $this->yard_id );

        if( $args["PaymentType"] != '' ){
            $this->ceh->where( "dft.INV_TYPE", $args["PaymentType"] );
        }

        if( $args["CurrencyID"] != '' ){
            $this->ceh->where( "dft.CURRENCYID", $args["CurrencyID"] );
        }

        $tmp = $this->ceh->order_by("DRAFT_INV_DATE", "ASC")->get( "INV_DFT dft" );
        $tmp = $tmp->result_array();
        return $tmp;
    }

    public function loadInvForCancel( $args = array() )
    {
        $this->ceh->select( "dft.rowguid, dft.DRAFT_INV_NO, iv.INV_NO, DRAFT_INV_DATE, dft.REF_NO, dft.OPR, dft.PAYER
                            , dft.PAYMENT_STATUS DRAFT_PAY_STATUS, iv.PAYMENT_STATUS INV_PAY_STATUS
                            , iv.CancelBy, iv.CancelDate, iv.CancelRemark, iv.YARD_ID
                            , cm.CusName, dft.AMOUNT, dft.VAT , dft.DIS_AMT, dft.TAMOUNT, dft.CURRENCYID, iv.PinCode" );
        $this->ceh->join( "CUSTOMERS cm", "cm.CusID = iv.PAYER AND cm.YARD_ID = iv.YARD_ID", "left" );
        $this->ceh->join( "INV_DFT dft", "dft.INV_NO = iv.INV_NO AND dft.YARD_ID = iv.YARD_ID", "left" );

        if( count( $args ) > 0 ){
            $VSLPrefix = $this->config->item("PIN_PREFIX")['VSL'];

            foreach ($args as $key => $value) {
                if( is_array( $value ) ){
                    if( count( $value ) > 0 ){
                        $this->ceh->where_in( $key, $value );
                    }
                    continue;
                }

                if( $value != "" ){
                    if ($key == 'searchVal') {
                        $this->ceh->group_start();
                        $this->ceh->like('dft.REF_NO', $value);
                        $this->ceh->or_where('iv.PinCode', $value);
                        $this->ceh->or_where('iv.INV_NO', $value);
                        $this->ceh->or_where('dft.DRAFT_INV_NO', $value);
                        $this->ceh->group_end();
                    } elseif ($key == 'sys') {
                        if($value == "VSL") {
                            $this->ceh->where("(LEFT(dft.DRAFT_INV_NO, ". strlen($VSLPrefix) .") = '$VSLPrefix' OR LEFT(iv.PinCode, 1) = 'A')");
                        }
                        else {
                            $this->ceh->where("(LEFT(dft.DRAFT_INV_NO, ". strlen($VSLPrefix) .") != '$VSLPrefix' AND LEFT(iv.PinCode, 1) != 'A')");
                        }
                    } else {
                        $this->ceh->where($key, $value);
                    }
                }
            }
        }

        // $this->ceh->where( "dft.PAYMENT_STATUS", "U" );
        $this->ceh->where( "iv.YARD_ID", $this->yard_id );

        $tmp = $this->ceh->get( "INV_VAT iv" );
        $tmp = $tmp->result_array();

        foreach( $tmp as $k => $v ){
            $refs = $v["REF_NO"] !== null ? explode(",", $v["REF_NO"]) : [];
            if( count( $refs ) > 0 ){
                $countEir = $this->ceh->select("EIRNo")->where_in( "EIRNo", $refs )
                                                    ->where("YARD_ID", $v["YARD_ID"])
                                                    ->where("bXNVC", "1")
                                                    ->limit(1)->get("EIR")->row_array();
                if( is_array( $countEir ) && count( $countEir ) > 0 ){
                    $tmp[$k]["ORD_NO"] =  $countEir['EIRNo'];
                }
                else{
                    $countSrv = $this->ceh->select("SSOderNo")->where_in( "SSOderNo", $refs )
                                                    ->where("YARD_ID", $v["YARD_ID"])
                                                    ->where("FDate IS NOT NULL")
                                                    ->limit(1)->get("SRV_ODR")->row_array();

                    $tmp[$k]["ORD_NO"] = (is_array( $countSrv ) && count( $countSrv ) > 0) ? $countEir['SSOderNo'] : NULL;
                }
            }
        }

        return $tmp;
    }

    public function loadDraftForCancel($args = array())
    {
        $this->ceh->select("dft.rowguid, dft.DRAFT_INV_NO, dft.INV_NO, DRAFT_INV_DATE, dft.REF_NO, dft.OPR, dft.PAYER
                            , dft.PAYMENT_STATUS DRAFT_PAY_STATUS, iv.PAYMENT_STATUS INV_PAY_STATUS
                            , ISNULL(iv.CancelBy, CASE WHEN dft.PAYMENT_STATUS = 'C' THEN dft.ModifiedBy ELSE NULL END) AS CancelBy
                            , ISNULL(iv.CancelDate, CASE WHEN dft.PAYMENT_STATUS = 'C' THEN dft.Update_Time ELSE NULL END) AS CancelDate
                            , ISNULL(iv.CancelRemark, CASE WHEN dft.PAYMENT_STATUS = 'C' THEN dft.REMARK ELSE NULL END) AS CancelRemark
                            , iv.YARD_ID
                            , cm.CusName, dft.AMOUNT, dft.VAT , dft.DIS_AMT, dft.TAMOUNT, dft.CURRENCYID, iv.PinCode");
        $this->ceh->join("CUSTOMERS cm", "cm.CusID = dft.PAYER AND cm.YARD_ID = dft.YARD_ID", "left");
        $this->ceh->join("INV_VAT iv", "iv.INV_NO = dft.INV_NO AND iv.YARD_ID = dft.YARD_ID", "left");

        if (count($args) > 0) {
            foreach ($args as $key => $value) {
                if (is_array($value)) {
                    if (count($value) > 0) {
                        $this->ceh->where_in($key, $value);
                    }
                    continue;
                }

                if ($value != "") {
                    if ($key == 'searchVal') {
                        $this->ceh->group_start();
                        $this->ceh->like('dft.REF_NO', $value);
                        $this->ceh->or_where('iv.PinCode', $value);
                        $this->ceh->or_where('iv.INV_NO', $value);
                        $this->ceh->or_where('dft.DRAFT_INV_NO', $value);
                        $this->ceh->group_end();
                    } else {
                        $this->ceh->where($key, $value);
                    }
                }
            }
        }

        // $this->ceh->where( "dft.PAYMENT_STATUS", "U" );
        $this->ceh->where("dft.YARD_ID", $this->yard_id);
        $this->ceh->order_by("dft.DRAFT_INV_DATE", 'DESC');

        $tmp = $this->ceh->get("INV_DFT dft");
        $tmp = $tmp->result_array();

        foreach ($tmp as $k => $v) {
            $tempz = $v["REF_NO"] !== null ? explode(",", $v["REF_NO"]) : [];
            $refs = array_map(function ($item) {
                return trim($item);
            }, $tempz);

            if (count($refs) > 0) {
                $countEir = $this->ceh->select("EIRNo")->where_in("EIRNo", $refs)
                    ->where("YARD_ID", $v["YARD_ID"])
                    ->where("bXNVC", "1")
                    ->limit(1)->get("EIR")->row_array();
                if (is_array($countEir) && count($countEir) > 0) {
                    $tmp[$k]["ORD_NO"] =  $countEir['EIRNo'];
                } else {
                    $countSrv = $this->ceh->select("SSOderNo")->where_in("SSOderNo", $refs)
                        ->where("YARD_ID", $v["YARD_ID"])
                        ->where("FDate IS NOT NULL")
                        ->limit(1)->get("SRV_ODR")->row_array();

                    $tmp[$k]["ORD_NO"] = (is_array($countSrv) && count($countSrv) > 0) ? $countEir['SSOderNo'] : NULL;
                }
            }
        }

        return $tmp;
    }

    public function loadDraftDetails( $args = array() )
    {

        $this->ceh->select( "DRAFT_INV_NO" );

        $this->ceh->where( "DRAFT_INV_DATE >=", $args["FromDate"] );
        $this->ceh->where( "DRAFT_INV_DATE <=", $args["ToDate"] );
        $this->ceh->where( "PAYMENT_STATUS IN('Y', 'U')");
        $this->ceh->where( "YARD_ID", $this->yard_id );

        if( $args["PaymentType"] != '' ){
            $this->ceh->where( "INV_TYPE", $args["PaymentType"] );
        }

        if( $args["CurrencyID"] != '' ){
            $this->ceh->where( "CURRENCYID", $args["CurrencyID"] );
        }

        $byDraftNoQry = $this->ceh->get_compiled_select( "INV_DFT", TRUE );

        $tmp = $this->ceh->select( "DRAFT_INV_NO, TRF_CODE, TRF_DESC, INV_UNIT, ct.description CARGO_TYPE, SZ, FE, IsLocal, QTY, standard_rate, DIS_RATE, extra_rate, UNIT_RATE, DIS_AMT, AMOUNT, VAT_RATE, VAT, TAMOUNT, Remark" )
                    ->join( "CARGO_TYPE ct", "dtl.CARGO_TYPE = ct.Code", "LEFT" )
                    ->where( "dtl.DRAFT_INV_NO IN ( ".$byDraftNoQry." )")
                    ->where( "dtl.YARD_ID", $this->yard_id )
                    ->where( "ct.YARD_ID", $this->yard_id )
                    ->get( "INV_DFT_DTL dtl" );

        $tmp = $tmp->result_array();
        return $tmp;
    }

    public function loadInvPrefix( $fromDate, $toDate )
    {
        $tmp = $this->ceh->select( "rowguid, PCODE, INV_PREFIX, PTYPE, FROM_INV_NO, TO_INV_NO, USEAGE, DATE_INVOICE, INV_NO, INV_PAGE_SIZE" )
                    ->where( "DATE_INVOICE >=", $fromDate )
                    ->where( "DATE_INVOICE <=", $toDate )
                    ->where( "YARD_ID", $this->yard_id )
                    ->order_by( "DATE_INVOICE", 'desc' )
                    ->get( "INV_PREFIX" );
        $tmp = $tmp->result_array();
        return $tmp;
    }

    public function getPayers($user = ''){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther, Email, EMAIL_DD');
        if($user != '' && $user != 'Admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function getInv4Print( $pinCode ){
        $this->ceh->select( "iv.INV_NO, iv.INV_DATE, iv.PAYER, iv.AMOUNT AS SUB_AMOUNT, iv.VAT, iv.TAMOUNT, iv.CURRENCYID
                            , cm.CusName, cm.Address, us.UserName
                            , un.UNIT_NM, idd.TRF_CODE, idd.TRF_DESC + ' ' + idd.SZ + idd.FE + ' - ' + idd.CARGO_TYPE AS TRF_DESC
                            , idd.QTY, idd.UNIT_RATE, idd.AMOUNT, idd.VAT_RATE" );
        $this->ceh->join("INV_DFT id", "id.INV_NO = iv.INV_NO AND id.YARD_ID = iv.YARD_ID");
        $this->ceh->join("INV_DFT_DTL idd", 'idd.DRAFT_INV_NO = id.DRAFT_INV_NO AND idd.YARD_ID = id.YARD_ID', 'left');
        $this->ceh->join("CUSTOMERS cm", 'cm.CusID = iv.PAYER AND cm.YARD_ID = cm.YARD_ID');
        $this->ceh->join("UNIT_CODES un", 'un.UNIT_CODE = idd.INV_UNIT AND un.YARD_ID = idd.YARD_ID', 'left');
        $this->ceh->join( "SA_USERS us", "us.UserID = iv.CreatedBy AND us.YARD_ID = iv.YARD_ID", 'left' );

         //edit_pin_for_cont
        $this->ceh->like("iv.PinCode", $pinCode, 'after');
        return $this->ceh->get("INV_VAT iv")->result_array();
    }

    // payment method save data function
    public function saveInvPrefix($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rowguid = "";

            if( isset( $item['rowguid'] ) ){
                $rowguid = $item['rowguid'];
                unset( $item['rowguid'] );
            }

            if( isset( $item['DATE_INVOICE'] ) ){
                $item['DATE_INVOICE'] = $this->funcs->dbDateTime( $item['DATE_INVOICE'] );
            }

            if( isset( $item['USEAGE'] ) ){
                $item['USEAGE'] = 0;
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if( $rowguid != "" ){
                $this->ceh->where('rowguid', $rowguid )->update('INV_PREFIX', $item);
            }else{
                //insert database

                $item["INV_PREFIX_ID"] = $this->funcs->newGuid();
                $item["YARD_ID"] = $this->yard_id;

                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('INV_PREFIX', $item);

                $ssInvInfo = json_decode($this->session->userdata("invInfo"), true);
                if( $item["INV_PREFIX"] == $ssInvInfo["serial"]
                        && $item["FROM_INV_NO"] == $ssInvInfo["fromNo"]
                        && $item["TO_INV_NO"] == $ssInvInfo["toNo"] )
                {
                    $ssInvInfo["invno"] = $item["INV_NO"];
                    $this->session->set_userdata("invInfo", json_encode( $ssInvInfo ));
                }
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    } // ------------end payment method save data function

    // payment method delete function
    public function deleteInvPrefix($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                        ->limit(1)
                                                        ->where('ACC_CD', $item)
                                                        ->get('INV_VAT')->row_array();
            if ($checkInv['COUNTEXIST'] == 0) {
                $this->ceh->where('ACC_CD', $item)
                            ->delete('ACCOUNTS');

                array_push($result['success'], 'Xóa thành công:'.$item);
            }else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh hóa đơn:'.$item);
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

    public function saveInvoiceVat( $args, &$outInfo )
    {
         //get invoice info
        $invPrefix = $args['invInfo']['serial'];
        $invNoPre =  substr("00000000".$args['invInfo']['invno'], -8);
        $pincode = $args['invInfo']['fkey'];
        $invDate = $args['invInfo']['INV_DATE'];
        $invRemark = $args['invInfo']['REMARK'];
        //get draft data
        $draftData = $args['draftData'];
        //get draft Total
        $draftTotal = $args['draftTotal'];
        $payer = $args['payer'];
        $currencyId = $args['currencyId'];

        //get inv VAT
        $inv_vat = array(
            "INV_NO" => $invPrefix.$invNoPre,
            "INV_DATE" => $this->funcs->dbDateTime( $invDate ),

            //??? nếu chọn nhiều draft của nhiều hãng thì lưu hãng nào, tương tự với thông tin tàu
            //2 hướng xử lý . 1. chỉ đc phép chọn draft cùng hãng kt, 2. lấy thằng opr của draft đầu tiên để lưu
            //truyền các số inv_draft_no được chọn xuống, truy vấn vào db, load lên lại cột ref_no + thông tin tàu
            //hoặc lấy lên cùng lúc khi load data, sau đó đẩy xún lại
            "REF_NO" => $draftData[0]["REF_NO"],
            "ShipKey" => $draftData[0]['ShipKey'],
            "ShipID" => $draftData[0]['ShipID'],
            "ShipYear" => $draftData[0]['ShipYear'],
            "ShipVoy" => $draftData[0]['ShipVoy'],
            "OPR" => $draftData[0]['OPR'],

            //payer + payertype theo payer được chọn trên gdien
            "PAYER_TYPE" => $draftData[0]['PAYER_TYPE'],
            "PAYER" => $payer,
            "PAYMENT_STATUS" => "Y",
            "INV_TYPE" => $draftData[0]['INV_TYPE'],
            "ACC_CD" => $draftData[0]['ACC_CD'],

            //đẩy từ gdien xuống: amount + vat + dis_amt
            "AMOUNT" => (float)str_replace(',', '', $draftTotal['AMOUNT']),
            "VAT" => (float)str_replace(',', '', $draftTotal['VAT']),
            "DIS_AMT" => (float)str_replace(',', '', $draftTotal['DIS_AMT']),
            //đẩy từ gdien xuống
            "TAMOUNT" => (float)str_replace(',', '', $draftTotal['TAMOUNT']),

            "REF_TYPE" => "A",
			"isPosted" => 0,

            //theo loại hóa đơn đc chọn
            "CURRENCYID" => $currencyId,
            "RATE" => 1,

            "isDFT_to_INV" => "1",
            "INV_TYPE_2" => "L",
            "TPLT_NM" => "EB",
            "PRINT_CHECK" => 0,
            
            "INV_PREFIX" => $invPrefix,
            "INV_NO_PRE" => $invNoPre,
            "PinCode" => $pincode,
            "REMARK" => UNICODE.$invRemark,

            "YARD_ID" => $this->yard_id,
            "CreatedBy" => $this->session->userdata("UserID"),
            "ModifiedBy" => $this->session->userdata("UserID"),
            "update_time" => date('Y-m-d H:i:s')
        );

        $this->ceh->insert('INV_VAT', $inv_vat);
        if($this->ceh->affected_rows() != 1)
        {
            return $this->ceh->_error_message();
        }

        if( $this->session->userdata("invInfo") !== null && $args["pubType"] == 'm-inv' ){
            $session_inv_info = json_decode( $this->session->userdata("invInfo"), TRUE );

            //nếu đã đến số cuối cùng thì remove invInfo để user tự set lại
            if( $session_inv_info["invno"] == $session_inv_info["toNo"] ){
                $this->session->unset_userdata('invInfo');
            }else{
                //set laij soo hóa đơn tay tăng lên 1
                $session_inv_info["invno"] = substr('00000000'.( intval( $session_inv_info["invno"] ) + 1 ), -8);
                $this->session->set_userdata("invInfo", json_encode( $session_inv_info ));
            }
        }

        $draftNos = array_column( $draftData, "DRAFT_INV_NO" );
        $this->ceh->where_in( "DRAFT_INV_NO", $draftNos )->update( "INV_DFT", array("INV_NO" => $inv_vat["INV_NO"], "PAYER" => $payer));

        $eirSql = $this->ceh->select("1 AS FLAG, rowguid, EIRNo AS OrderNo, PersonalID, NameDD, Mail, PinCode")
                                ->where_in("DRAFT_INV_NO", $draftNos)
                                ->get_compiled_select( "EIR", TRUE );
        $srvSql = $this->ceh->select("2 AS FLAG, rowguid, SSOderNo AS OrderNo, PersonalID, NameDD, Mail, PinCode")
                                ->where_in("DRAFT_INV_NO", $draftNos)
                                ->get_compiled_select( "SRV_ODR", TRUE );

        $outInfo = $this->ceh->query( $eirSql." UNION ".$srvSql );
        $outInfo = $outInfo->result_array();

        if ( count( $outInfo ) > 0 )
        {
            $updInfo = array(
                "InvNo" => $invPrefix . $invNoPre,
                "PinCode" => $pincode,
                "CusID" => $payer,
                "update_time" => date("Y-m-d H:i:s"),
                "ModifiedBy" => $this->session->userdata("UserID")
            );

            foreach( $outInfo as $k => $v ){
                $orderNoColName = intval( $v["FLAG"] ) == 1 ? "EIRNo" : "SSOderNo";
                $updTbl = intval( $v["FLAG"] ) == 1 ? "EIR" : "SRV_ODR";

                //bo sung
                $tempN = explode('-', $v["PinCode"]);
                if (count($tempN) > 1) {
                    $updInfo['PinCode'] = $pincode . "-" . $tempN[1];
                }
                $this->ceh->where($orderNoColName, $v["OrderNo"])->where('rowguid', $v['rowguid'])->update($updTbl, $updInfo);
            }
        }
    //Delete INV_DRAFT nếu có
        if($draftData[0]['ACC_CD'] === 'CK') {
                $code = preg_replace("/[^a-zA-Z0-9]/", "", $draftData[0]['DRAFT_INV_NO'] ?? '');
                $this->ceh
                    ->where("REPLACE(DRAFT_INV_NO, '/', '') =", $code)
                    ->delete('INV_DFT_DRAFT');
                // Xóa trong INV_DFT_DTL_DRAFT
                $this->ceh
                    ->where("REPLACE(DRAFT_INV_NO, '/', '') =", $code)
                    ->delete('INV_DFT_DTL_DRAFT');
        }
        return 'success';
    }

    public function cancelLocalInv($invNo, $cancelReason, $outputMsg)
    {
        //add draft no to cancelremark
        $drafts = $this->ceh->select('DRAFT_INV_NO')->where("INV_NO", $invNo)->get('INV_DFT')->result_array();
        if (count($drafts) > 0) {
            $cancelReason .= "(" . implode(', ', array_column($drafts, 'DRAFT_INV_NO')) . ")";
        }

        $updateInv = array(
            "INV_NO" => $invNo,
            "PAYMENT_STATUS" => 'C',
            "CancelDate" => date("Y-m-d H:i:s"),
            "CancelRemark" => UNICODE . $cancelReason,
            "CancelBy" => $this->session->userdata("UserID"),
            "update_time" => date("Y-m-d H:i:s"),
            "ModifiedBy" => $this->session->userdata("UserID")
        );

        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where("INV_NO", $invNo)->update("INV_VAT", $updateInv);

        $this->ceh->trans_complete();

        if ($this->ceh->trans_status() === FALSE) {
            $outputMsg = $this->ceh->_error_message();
            $this->ceh->trans_rollback();
            return FALSE;
        }

        $this->ceh->where("INV_NO", $invNo)->update("INV_DFT", array("INV_NO" => NULL));

        $this->ceh->trans_commit();
        return TRUE;
    }

    public function cancelDraft($draftNo, $cancelReason, $isRemoveOrder, $outputMsg)
    {
        $updateDraft = array(
            "PAYMENT_STATUS" => 'C',
            "REMARK" => UNICODE . $cancelReason,
            "update_time" => date("Y-m-d H:i:s"),
            "ModifiedBy" => $this->session->userdata("UserID")
        );
        $isRemoveOrder=$isRemoveOrder.'';//
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where("DRAFT_INV_NO", $draftNo)->update("INV_DFT", $updateDraft);

        $eirRowguids = $this->ceh->select("rowguid, EIRNo, BookingNo, OprID, ISO_SZTP")
            ->where("DRAFT_INV_NO", $draftNo)
            ->get("EIR")->result_array();

        if (count($eirRowguids) > 0) {
            //print_r($isRemoveOrder);
                //print_r(array_column($eirRowguids, "rowguid"));die();
            if ($isRemoveOrder == "1") {
                $this->ceh->where_in("rowguid", array_column($eirRowguids, "rowguid"))->delete("EIR");
            }

            $new = array_filter($eirRowguids, function ($var) {
                return ($var['BookingNo'] !== NULL);
            });

            if (count($new) > 0) {
                foreach ($new as $key => $value) {
                    $this->ceh->set("StackingAmount", "StackingAmount - 1", FALSE);
                    $this->ceh->where("BookingNo", $value["BookingNo"]);
                    $this->ceh->where("OprID", $value["OprID"]);
                    $this->ceh->where("ISO_SZTP", $value["ISO_SZTP"]);
                    $this->ceh->where("YARD_ID", $this->yard_id);
                    $this->ceh->update("EMP_BOOK");
                }
            }

            if ($isRemoveOrder == "1") {
                //remove eir no in cntr details
                $updateCntrDetails = array(
                    "EIRNo" => NULL,
                    "update_time" => date("Y-m-d H:i:s"),
                    "ModifiedBy" => $this->session->userdata("UserID")
                );

                $this->ceh->where_in("EIRNo", array_column($eirRowguids, "EIRNo"))->update("CNTR_DETAILS", $updateCntrDetails);
            }
        }

        $srvRowguids = $this->ceh->select("rowguid, SSOderNo, BookingNo, OprID, ISO_SZTP")
            ->where("DRAFT_INV_NO", $draftNo)
            ->get("SRV_ODR")->result_array();

        if (count($srvRowguids) > 0) {
            if ($isRemoveOrder == "1") {
                $this->ceh->where_in("rowguid", array_column($srvRowguids, "rowguid"))->delete("SRV_ODR");
            }

            $new2 = array_filter($srvRowguids, function ($var) {
                return ($var['BookingNo'] !== NULL);
            });

            if (count($new2) > 0) {
                foreach ($new2 as $key => $value) {
                    $this->ceh->set("StackingAmount", "StackingAmount - 1", FALSE);
                    $this->ceh->where("BookingNo", $value["BookingNo"]);
                    $this->ceh->where("OprID", $value["OprID"]);
                    $this->ceh->where("ISO_SZTP", $value["ISO_SZTP"]);
                    $this->ceh->where("YARD_ID", $this->yard_id);
                    $this->ceh->update("EMP_BOOK");
                }
            }

            if ($isRemoveOrder == "1") {
                //remove ssoder no in cntr details
                $updateCntrDetails = array(
                    "SSOderNo" => NULL,
                    "update_time" => date("Y-m-d H:i:s"),
                    "ModifiedBy" => $this->session->userdata("UserID")
                );

                $this->ceh->where_in("SSOderNo", array_column($srvRowguids, "SSOderNo"))->update("CNTR_DETAILS", $updateCntrDetails);
            }
        }

        if ($this->ceh->trans_status() === FALSE) {
            $outputMsg = $this->ceh->_error_message();
            $this->ceh->trans_rollback();
            return FALSE;
        } else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function saveDraft_MANUAL($args, &$outInfo, $action = null, &$mailTo = null)
    {
        if (!is_array($args) || count($args) == 0) return true;

        $draft_details = array();
        if (isset($args['draft_detail']) && count($args['draft_detail'])) {
            $draft_details = $args['draft_detail'];
        }

        $draft_total = array();
        if (isset($args['draft_total']) && count($args['draft_total'])) {
            $draft_total = $args['draft_total'];
        }
        $mailTo = isset($draft_total['Mail']) ? $draft_total['Mail'] : null;
        $pubType = $args['pubType'];
        $draftNo = isset($args['DraftNo']) ? $args['DraftNo'] : $this->generateDraftNo();
        $outInfo["DRAFT_NO"] = $draftNo;

        if ($args["pubType"] == 'm-inv') // trường hợp xuất hóa đơn tay
        {
            $session_inv_info = json_decode($this->session->userdata("invInfo"), TRUE); // lấy thông tin hóa đơn đc lưu trữ trong biến session

            $draft_total["PinCode"] = $outInfo['fkey'] = $this->generatePinCode();
            $draft_total["INV_NO_PRE"] = $outInfo['invno'] = $session_inv_info['invno'];
            $draft_total["INV_PREFIX"] = $outInfo['serial'] = $session_inv_info['serial'];

            //them moi hd thu sau
            $draft_total["INV_DATE"] = $draft_total['PAYMENT_TYPE'] == 'C' ? $this->funcs->dbDateTime($draft_total["INV_DATE"]) : '';

            $this->saveInvoice_MANUAL($draft_total, $pubType);
        }

        if ($args["pubType"] == 'e-inv') // trường hợp xuất hóa đơn tay
        {
            $invInfo = $args["invInfo"];
            $draft_total["PinCode"] = $invInfo['fkey'];
            $draft_total["INV_NO_PRE"] = substr("00000000" . $invInfo['invno'], -8);
            $draft_total["INV_PREFIX"] = $invInfo['serial'];

            //them moi hd thu sau
            $draft_total["INV_DATE"] = '';

            $this->saveInvoice_MANUAL($draft_total, $pubType);
        }

        $inv_draft = array(
            "DRAFT_INV_NO" => $draftNo,
            "REF_NO" => isset($draft_total['REF_NO']) ? $draft_total['REF_NO'] : NULL,
            "INV_NO" => isset($draft_total["INV_NO_PRE"]) ? $draft_total["INV_PREFIX"] . $draft_total["INV_NO_PRE"] : NULL,
            "DRAFT_INV_DATE" => $draft_total["INV_DATE"] != '' ? $draft_total["INV_DATE"] : date('Y-m-d H:i:s'), //them moi hd thu sau
            "ShipKey" => isset($draft_total['ShipKey']) ? $draft_total['ShipKey'] : NULL,
            "ShipID" => isset($draft_total['ShipID']) ? $draft_total['ShipID'] : NULL,
            "ShipYear" => isset($draft_total['ShipYear']) ? $draft_total['ShipYear'] : NULL,
            "ShipVoy" => isset($draft_total['ShipVoy']) ? $draft_total['ShipVoy'] : NULL,
            "PAYER_TYPE" => $draft_total['PAYER_TYPE'],
            "PAYER" => $draft_total['CusID'],
            "AMOUNT" => $draft_total["AMOUNT"],
            "VAT" => $draft_total["VAT"],
            "DIS_AMT" => $draft_total["DIS_AMT"],
            "PAYMENT_STATUS" => 'Y',
            "REF_TYPE" => "A",
            "CURRENCYID" => $draft_total["CURRENCYID"],
            "IS_MANUAL_INV" => 1,
            "RATE" => (float)str_replace(',', '', $draft_total['RATE']),
            "INV_TYPE" => $draft_total['PAYMENT_TYPE'] == "C" ? "CRE" : "CAS",
            "INV_TYPE_2" => "L",
            "TPLT_NM" => $draft_total["TPLT_NM"],
            "TAMOUNT" => $draft_total["TAMOUNT"],
            "YARD_ID" => $this->yard_id,
            "ModifiedBy" => $this->session->userdata("UserID"),
            "update_time" => date('Y-m-d H:i:s'),
            "CreatedBy" => $this->session->userdata("UserID")
        );

        //get inv draft details
        $inv_draft_details = array();
        foreach ($draft_details as $idx => $dd) {
            $dd['DRAFT_INV_NO'] = $draftNo;
            $dd['SEQ'] = $idx;
            $dd['QTY'] = (float)str_replace(',', '', $dd['QTY']);
            $dd['DIS_AMT'] = 0;
            $dd['standard_rate'] = (float)str_replace(',', '', $dd['standard_rate']);
            $dd['DIS_RATE'] = 0;
            $dd['extra_rate'] = 0;
            $dd['UNIT_RATE'] = (float)str_replace(',', '', $dd['UNIT_RATE']);
            $dd['AMOUNT'] = (float)str_replace(',', '', $dd['AMOUNT']);

            $dd['VAT_RATE'] = $dd['VAT_RATE'] == '' ? NULL : (float)str_replace(',', '', $dd['VAT_RATE']);
            $dd['VAT'] = $dd['VAT_RATE'] == '' ? NULL : (float)str_replace(',', '', $dd['VAT']);

            $dd['TAMOUNT'] = (float)str_replace(',', '', $dd['TAMOUNT']);

            $dd['TRF_DESC'] = UNICODE . $dd['TRF_DESC'];
            $dd['Remark'] = UNICODE . (isset($dd['Remark']) ? $dd['Remark'] : '');

            $dd['GRT'] = 1;
            $dd['SOGIO'] = 1;

            $dd['YARD_ID'] = $this->yard_id;
            $dd['ModifiedBy'] = $this->session->userdata("UserID");
            $dd['CreatedBy'] = $this->session->userdata("UserID");
            $dd['update_time'] = date('Y-m-d H:i:s');

            unset($dd['rowguid']);
            array_push($inv_draft_details, $dd);
        }
        //get inv Cont
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $this->ceh->insert('INV_DFT', $inv_draft);
        $this->ceh->insert_batch('INV_DFT_DTL', $inv_draft_details);
       if ($action == 'qr') {
                $cleanDraft = preg_replace("/[^a-zA-Z0-9]/", "", $draftNo ?? '');
                $this->ceh
                    ->where("REPLACE(DRAFT_INV_NO, '/', '') =", $cleanDraft)
                    ->delete('INV_DFT_DRAFT');
                $this->ceh
                    ->where("REPLACE(DRAFT_INV_NO, '/', '') =", $cleanDraft)
                    ->delete('INV_DFT_DTL_DRAFT');
            }
        $this->ceh->trans_complete();

        if ($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        } else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }
    // Save INV_DRAFT 
        public function saveDraft_MANUAL_DRAFT($args)
        {
        if (!is_array($args) || count($args) == 0) return true;
        
        $draft_details = array();
        if (isset($args['draft_detail']) && count($args['draft_detail'])) {
            $draft_details = $args['draft_detail'];
        }

        $draft_total = array();
        if (isset($args['draft_total']) && count($args['draft_total'])) {
            $draft_total = $args['draft_total'];
        }

        $draftNo = isset($draft_total[0]['DRAFT_INV_NO']) ? $draft_total[0]['DRAFT_INV_NO'] : $this->generateDraftNo();
        $outInfo["DRAFT_NO"] = $draftNo;
        $inv_draft = [];
        foreach($draft_total as $ixd => $dt) {
            if(isset($dt['DRAFT_INV_NO'])) {
                $check = $this->checkInvDraft($dt['DRAFT_INV_NO']);
            if($check) {
                return ["Status" => false, "Message" => 'Đơn hàng '.$dt['DRAFT_INV_NO'].' đã tồn tại, Chờ thanh toán!'];
            }
            }
            $data = array(
                "DRAFT_INV_NO" => $draftNo,
                "REF_NO" => isset($dt['REF_NO']) ? $dt['REF_NO'] : NULL,
                "INV_NO" => isset($dt["INV_NO_PRE"]) ? $dt["INV_PREFIX"] . $dt["INV_NO_PRE"] : NULL,
                "DRAFT_INV_DATE" => $dt["INV_DATE"] != '' ? $dt["INV_DATE"] : date('Y-m-d H:i:s'), //them moi hd thu sau
                "ShipKey" => isset($dt['ShipKey']) ? $dt['ShipKey'] : NULL,
                "ShipID" => isset($dt['ShipID']) ? $dt['ShipID'] : NULL,
                "ShipYear" => isset($dt['ShipYear']) ? $dt['ShipYear'] : NULL,
                "ShipVoy" => isset($dt['ShipVoy']) ? $dt['ShipVoy'] : NULL,
                "PAYER_TYPE" => $dt['PAYER_TYPE'],
                "PAYER" => $dt['CusID'],
                "AMOUNT" => (float)str_replace(',', '', $dt["AMOUNT"]),
                "VAT" => (float)str_replace(',', '', $dt["VAT"]),
                "DIS_AMT" => (float)str_replace(',', '', $dt["DIS_AMT"] ?? 0),
                "CusID" => $dt["CusID"],
                "PAYMENT_TYPE" => $dt["PAYMENT_TYPE"] ?? NULL,
                "REMARK" => $dt["REMARK"] ?? NULL,
                "OPR" => $dt["OPR"] ?? NULL,
                "ACC_CD" => $dt["ACC_CD"] ?? 'CK',
                "PAYMENT_STATUS" => 'Y',
                "REF_TYPE" => "A",
                "CURRENCYID" => $dt["CURRENCYID"],
                "IS_MANUAL_INV" => 1,
                "RATE" => (float)str_replace(',', '', $dt['RATE'] ?? 0),
                "INV_TYPE" => $dt['INV_TYPE'] ?? NULL,
                "INV_TYPE_2" => "L",
                "TPLT_NM" => $dt["TPLT_NM"] ?? NULL,
                "TAMOUNT" => (float)str_replace(',', '',$dt["TAMOUNT"]),
                "YARD_ID" => $this->yard_id,
                "ModifiedBy" => $this->session->userdata("UserID"),
                "update_time" => date('Y-m-d H:i:s'),
                "CreatedBy" => $this->session->userdata("UserID"),
                "DRAFT_INV_NO_PRO" => isset($dt['DRAFT_INV_NO']) ? $dt['DRAFT_INV_NO'] : NULL,
                "Mail" => isset($dt['Mail']) ? $dt['Mail'] : NULL,
                "is_eport" => isset($dt['is_eport']) ? $dt['is_eport'] : NULL,
            );
            array_push($inv_draft,$data);
        }
        //get inv draft details
        $inv_draft_details = array();
        foreach ($draft_details as $idx => $dd) {
            $dd['DRAFT_INV_NO'] = $draftNo;
            $dd['SEQ'] = $idx;
            $dd['QTY'] = (float)str_replace(',', '', $dd['QTY']);
            $dd['DIS_AMT'] = 0;
            $dd['standard_rate'] = (float)str_replace(',', '', $dd['standard_rate']);
            $dd['DIS_RATE'] = 0;
            $dd['extra_rate'] = 0;
            $dd['UNIT_RATE'] = (float)str_replace(',', '', $dd['UNIT_RATE']);
            $dd['AMOUNT'] = (float)str_replace(',', '', $dd['AMOUNT']);

            $dd['VAT_RATE'] = $dd['VAT_RATE'] == '' ? NULL : (float)str_replace(',', '', $dd['VAT_RATE']);
            $dd['VAT'] = $dd['VAT_RATE'] == '' ? NULL : (float)str_replace(',', '', $dd['VAT']);

            $dd['TAMOUNT'] = (float)str_replace(',', '', $dd['TAMOUNT']);

            $dd['TRF_DESC'] = UNICODE . $dd['TRF_DESC'];
            $dd['Remark'] = UNICODE . (isset($dd['Remark']) ? $dd['Remark'] : '');

            $dd['GRT'] = 1;
            $dd['SOGIO'] = 1;

            $dd['YARD_ID'] = $this->yard_id;
            $dd['ModifiedBy'] = $this->session->userdata("UserID");
            $dd['CreatedBy'] = $this->session->userdata("UserID");
            $dd['update_time'] = date('Y-m-d H:i:s');

            unset($dd['rowguid']);
            unset($dd['STT']);
            array_push($inv_draft_details, $dd);
        }
        
        //get inv Cont
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->insert_batch('INV_DFT_DRAFT', $inv_draft);
        $this->ceh->insert_batch('INV_DFT_DTL_DRAFT', $inv_draft_details);

        $this->ceh->trans_complete();

        if ($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        } else {
            $this->ceh->trans_commit();
            return ['Status' => true, 'DraftNo' => $draftNo];
        }
    }
    // Get INV_DRAFT 
    public function getInvDraft($DraftNo){
        $this->ceh->select("*"); 
        $this->ceh->from("INV_DFT_DRAFT");
        $this->ceh->where("REPLACE(DRAFT_INV_NO, '/', '') =", $DraftNo);
        $this->ceh->limit(1);                         
        return $this->ceh->get()->result_array();
    }
        // checkInvDraft
        public function checkInvDraft($DraftNo)
        {
            $this->ceh->select("*"); 
            $this->ceh->from("INV_DFT_DRAFT");
            $this->ceh->where("REPLACE(DRAFT_INV_NO, '/', '') =", $DraftNo);
            $result = $this->ceh->get()->result_array();

            return count($result) > 0;
        }

    // Get INV_DTL_DRAFT 
    public function getInvDTLDraft($DraftNo){
        $this->ceh->select("*"); 
        $this->ceh->from("INV_DFT_DTL_DRAFT");
          $this->ceh->where("REPLACE(DRAFT_INV_NO, '/', '') =", $DraftNo);
        return $this->ceh->get()->result_array();
    }
    public function saveInvoice_MANUAL($draftTotal, $pubType)
    {
        //get inv VAT
        $inv_vat = array(
            "INV_NO" => $draftTotal["INV_PREFIX"] . $draftTotal["INV_NO_PRE"],
            "REF_NO" => isset($draftTotal['REF_NO']) ? $draftTotal['REF_NO'] : NULL,
            "INV_DATE" => $draftTotal["INV_DATE"] != '' ? $draftTotal["INV_DATE"] : date('Y-m-d H:i:s'), //them moi hd thu sau
            "ShipKey" => isset($draftTotal['ShipKey']) ? $draftTotal['ShipKey'] : NULL,
            "ShipID" => isset($draftTotal['ShipID']) ? $draftTotal['ShipID'] : NULL,
            "ShipYear" => isset($draftTotal['ShipYear']) ? $draftTotal['ShipYear'] : NULL,
            "ShipVoy" => isset($draftTotal['ShipVoy']) ? $draftTotal['ShipVoy'] : NULL,

            //payer + payertype theo payer được chọn trên gdien
            "PAYER_TYPE" => $draftTotal['PAYER_TYPE'],
            "PAYER" => $draftTotal['CusID'],
            "PAYMENT_STATUS" => "Y",
            "INV_TYPE" => $draftTotal['PAYMENT_TYPE'] == "C" ? "CRE" : "CAS",
            "ACC_CD" => isset($draftTotal['ACC_CD']) ? $draftTotal['ACC_CD'] : 'TM/CK',

            "AMOUNT" => (float)str_replace(',', '', $draftTotal['AMOUNT']),
            "VAT" => (float)str_replace(',', '', $draftTotal['VAT']),
            "DIS_AMT" => (float)str_replace(',', '', $draftTotal['DIS_AMT']),
            "TAMOUNT" => (float)str_replace(',', '', $draftTotal['TAMOUNT']),
            "REF_TYPE" => "A",
            //theo loại hóa đơn đc chọn
            "CURRENCYID" => $draftTotal['CURRENCYID'],
            "RATE" => (float)str_replace(',', '', $draftTotal['RATE']),

            "INV_TYPE_2" => "L",
            "TPLT_NM" => $draftTotal['TPLT_NM'],
            "PRINT_CHECK" => 0,

            "INV_PREFIX" => $draftTotal["INV_PREFIX"],
            "INV_NO_PRE" => $draftTotal["INV_NO_PRE"],
            "PinCode" => $draftTotal["PinCode"],
            "LOCAL_INV" => "1",
            "isPosted" => 0,

            "YARD_ID" => $this->yard_id,
            "CreatedBy" => $this->session->userdata("UserID"),
            "ModifiedBy" => $this->session->userdata("UserID"),
            "update_time" => date('Y-m-d H:i:s')
        );

		if( !empty($draftTotal["AdjustInvNo"]) ) {
            $inv_vat['AdjustInvNo'] = $draftTotal["AdjustInvNo"];
            $inv_vat['AdjustType'] = $draftTotal["AdjustType"];
            $inv_vat['AdjustRemark'] = UNICODE . $this->session->userdata("UserID") . " :: " . $draftTotal["AdjustRemark"];
        }

        $this->ceh->insert('INV_VAT', $inv_vat);
        if ($this->ceh->affected_rows() != 1) {
            return $this->ceh->_error_message();
        }

        if ($this->session->userdata("invInfo") !== null && $pubType == 'm-inv') {
            $session_inv_info = json_decode($this->session->userdata("invInfo"), TRUE);

            //nếu đã đến số cuối cùng thì remove invInfo để user tự set lại
            if ($session_inv_info["invno"] == $session_inv_info["toNo"]) {
                $this->session->unset_userdata('invInfo');
            } else {
                //set laij soo hóa đơn tay tăng lên 1
                $session_inv_info["invno"] = substr('00000000' . (intval($session_inv_info["invno"]) + 1), -8);
                $this->session->set_userdata("invInfo", json_encode($session_inv_info));
            }
        }

        return TRUE;
    }

    public function generateDraftNo(){
        $year = date('Y');
        $file = APPPATH . '/cache/draft_temp'.$year.'.txt';
        $fp = fopen($file, "a+");

        do {
            $getLock = flock($fp, LOCK_EX | LOCK_NB);
            if ( $getLock ) {
                $filesz = filesize( $file );
                if( $filesz == 0 ){
                    $out = $this->getMaxDraftInDB();
                }else{
                    $dftNo = fread( $fp, $filesz );
                    $out = intval($dftNo) + 1;
                }
                
                ftruncate($fp, 0);
                fwrite($fp, $out);
                flock($fp, LOCK_UN);
            }
        } while( !$getLock );

        fclose($fp);
        
        return 'DR/'.$year.'/'.substr('0000000'.$out, -7);
    }

    public function getMaxDraftInDB(){
        $this->ceh->select('MAX( CONVERT( bigint, SUBSTRING(DRAFT_INV_NO,9, 6)) ) AS DRAFT_NO');
        $this->ceh->where("SUBSTRING(DRAFT_INV_NO,4, 4) = ", date('Y'));
        $this->ceh->where("YARD_ID", $this->yard_id);
        $stmt = $this->ceh->limit(1)->get('INV_DFT');
        $stmt = $stmt->row_array();
        
        return $stmt['DRAFT_NO'] === null ? 1 : (int)$stmt['DRAFT_NO'] + 1;
    }
    public function checkDraft($arr){
        $this->ceh->select('DRAFT_INV_NO');
        $this->ceh->where_in("DRAFT_INV_NO_PRO", $arr);
        $stmt = $this->ceh->get('INV_DFT_DRAFT');
        $stmt = $stmt->row_array();
        return $stmt === null ? true : false;
    }
}