<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportRPT extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        $this->load->model("task_model", "mdltask");
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function _remap($method) {
        $methods = get_class_methods($this);

        $skip = array("_remap", "__construct", "get_instance");
        $a_methods = array();

        if(($method == 'index')) {
            $method = md5('index');
        }

        foreach($methods as $smethod) {
            if (!in_array($smethod, $skip)) {
                $a_methods[] = md5($smethod);
                if($method == md5($smethod) || $method == $smethod) {
                    $this->$smethod();
                    break;
                }
            }
        }

        if(!in_array($method, $a_methods)) {
            show_404();
        }
    }

    public function viewDraftPDF()
    {
        $draftDetails = $this->input->post('draftDetails') ? json_decode( $this->input->post('draftDetails'), true ) : array();
        $draftNo = $this->input->post('draftNo') ? $this->input->post('draftNo')
                  : ( $this->input->get('draftNo') ? $this->input->get('draftNo') : '' );

        if( count( $draftDetails ) == 0 ){
            $draftDetails = $this->mdltask->getInvDFT4ViewPDF( $draftNo );
        }

        if( count( $draftDetails ) == 0 ){
            echo "<div style='width: 100%;text-align: center;margin: -8px 0 0 -8px;font-weight: 600;font-size: 27px;color: white;background-color:#614040;line-height: 2;'>KHÔNG CÓ DỮ LIỆU ĐỂ XUẤT PHIẾU!</div>";
            exit();
        }
        
        $day = date("d");
        $month = date("m");
        $year = date("Y");

        $newarray = array();
        foreach ( $draftDetails as $key => $val ) {
            $newarray[ $val["DRAFT_INV_NO"] ][ $key ] = $val;
        }

        $strBody = <<<EOT
        <div style="padding:40px;">
           <table style="width: 100%;">
              <tbody>
                 <tr>
                    <td style="width: 35.0788%; text-align: center;">LOGO</td>
                    <td style="width: 60.9212%; font-size: 12px;"><strong>CÔNG TY CP VT & TM QUỐC TẾ (ITC)</strong><br />Địa chỉ: Đường 990, Phường Phú Hữu, Quận 9, Tp. Hồ Chí Minh<br />MST: 0313206513<br />Điện thoại: (84.8) 3731 5050<br />Website: www.sp-itc.com.vn</td>
                 </tr>
              </tbody>
           </table>
           <table style="width: 100%; margin-top: 5px;">
              <tbody>
                 <tr>
                    <td style="width: 30%;">&nbsp;</td>
                    <td style="text-align: center;">
                       <span style="color: #ff0000; font-size: 20px;"><strong>PHIẾU TÍNH CƯỚC</strong></span><br />
                       <div style="font-size: 12px; margin-top: 5px;"><em>ng&agrave;y DR_DAY th&aacute;ng DR_MONTH năm DR_YEAR</em></div>
                    </td>
                    <td style="width: 30%;">&nbsp;Số: <span style="color: #ff0000; font-size: 15px;"><strong>DR_NO</strong></span></td>
                 </tr>
              </tbody>
           </table>
           <table style="width: 100%; margin-top: 10px;">
              <tbody>
                 <tr style="height: 22px;">
                    <td style="width: 63.218%; font-size: 12px; height: 22px;">&nbsp;Kh&aacute;ch h&agrave;ng: PAYER_NAME</td>
                    <td style="width: 33.782%; font-size: 12px; height: 22px;">&nbsp;Điện thoại:</td>
                 </tr>
              </tbody>
           </table>
           <table style="width: 100%; border-color: #ccc;" border="1" cellspacing="0" cellpadding="0">
              <tbody>
                 <tr style="height: 41px;">
                    <td style="width: 5%; text-align: center; font-size: 13px; height: 41px;"><strong>STT</strong></td>
                    <td style="width: 30%; text-align: center; font-size: 13px; height: 41px;"><strong>NỘI DUNG</strong></td>
                    <td style="width: 10%; text-align: center; font-size: 13px; height: 41px;"><strong>ĐVT</strong></td>
                    <td style="width: 15%; text-align: center; font-size: 13px; height: 41px;"><strong>SỐ LƯỢNG</strong></td>
                    <td style="width: 20%; text-align: center; font-size: 13px; height: 41px;"><strong>ĐƠN GI&Aacute;</strong></td>
                    <td style="width: 20%; text-align: center; font-size: 13px; height: 41px;"><strong>TH&Agrave;NH TIỀN</strong></td>
                 </tr>
                 ROW_CONTENT_DRAFT
                 <tr style="height: 41px;">
                    <td style="text-align: center;" colspan="5">&nbsp;<strong>TỔNG CỘNG</strong></td>
                    <td style="text-align: right;">TOTAL_AMOUNT&nbsp;</td>
                 </tr>
              </tbody>
           </table>
           <p style="font-size: 12px;">Tổng tiền bằng chữ:
              <span style="font-style: italic"> IN_WORDS ./.</span>
           </p>
           <div style="float: right; font-size: 12px;">
              <p>Tp. HCM, ngày $day tháng $month năm $year</p>
              <p style='margin-left: 60px'>Người lập phiếu </p>
           </div>
        </div>
EOT;
        $strTableContent = <<<EOT
        <tr style="height: 41px; font-size: 12px">
            <td style="text-align: center;">SOTHUTU</td>
            <td>&nbsp;TRF_DESC</td>
            <td style="text-align: center;">INV_UNIT</td>
            <td style="text-align: center;">QTY</td>
            <td style="text-align: right;">standard_rate &nbsp;</td>
            <td style="text-align: right;">TAMOUNT &nbsp;</td>
        </tr>
EOT;
        $strAllBody = "";
        foreach ( $newarray as $key => $draft ) {
            $i = 1;

            $sumAmount = 0;
            $strContentDraft = "";

            foreach ( $draft as $drDetail ) {
                $sumAmount += $drDetail["TAMOUNT"];

                $drDetail["SOTHUTU"] = $i++;

                $drDetail["QTY"] = intval( $drDetail["QTY"] );
                $drDetail["standard_rate"] = number_format( $drDetail["standard_rate"] );
                $drDetail["TAMOUNT"] = number_format( $drDetail["TAMOUNT"] );
                
                $strContentDraft .= $this->funcs->strReplaceAssoc( $drDetail, $strTableContent );
            }

            $temp = array_values( $draft );
            $tempFirst = array_shift( $temp );
            $draftDate = $tempFirst["DRAFT_INV_DATE"];
            $payerName = $tempFirst["PAYER_NAME"];

            $arrBody = array(
                "DR_NO" => $key,
                "DR_DAY" => date( 'd', strtotime( $draftDate ) ),
                "DR_MONTH" => date( 'm', strtotime( $draftDate ) ),
                "DR_YEAR" => date( 'Y', strtotime( $draftDate ) ),
                "ROW_CONTENT_DRAFT" => $strContentDraft,
                "TOTAL_AMOUNT" => number_format( $sumAmount ),
                "IN_WORDS" => $this->funcs->convert_number_to_words( $sumAmount ),
                "PAYER_NAME" => $payerName
            );

            $strAllBody .= "<body>".$this->funcs->strReplaceAssoc( $arrBody, $strBody )."</body>";
        }

        $content = <<<EOT
        <html>
           <head>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
              <style>
                 body { font-family: DejaVu Sans, sans-serif }
              </style>
              <title>Phiếu tính cước</title>
              $strAllBody
           </head>
        </html>
EOT;
        $this->load->helper('dompdf');
        pdf_render($content, 'Draft');

        exit(0);
    }

    public function viewPDFOrderByList()
    {
        $pinCode = $this->input->get('fkey') ? $this->input->get('fkey') : '';
        $orderData = $this->mdltask->getOrder4ViewPDFByList( $pinCode );

        if( count( $orderData ) == 0 ){
            echo "Không có dữ liệu để xuất phiếu!";
            exit();
        }

        $day = date("d");
        $month = date("m");
        $year = date("Y");

        $orderNo = mb_strtoupper( $orderData[0]["OrderNo"] );
        $blbkNo = $orderData[0]["BLNo"] !== null ? $orderData[0]["BLNo"] : ( $orderData[0]["BookingNo"] !== null ? $orderData[0]["BookingNo"] : "" );
        $expDate = $orderData[0]["ExpDate"] !== null ? date( "d/m/Y H:i:s", strtotime($orderData[0]["ExpDate"]) ) : "";
        $shipperName = $orderData[0]["SHIPPER_NAME"];
        $nameDD = $orderData[0]["NameDD"];
        $personalID = $orderData[0]["PersonalID"];
        $shipID = $orderData[0]["ShipID"];
        $imVoy = $orderData[0]["ImVoy"];
        $exVoy = $orderData[0]["ExVoy"];
        $cusName = $orderData[0]["CusName"];
        $note = $orderData[0]["Note"];

        $expPlugDate = "";

        $invNo = $orderData[0]["InvNo"] !== null ? $orderData[0]["InvNo"] : "";

        $strRowTemp = <<<EOT
        <tr style="height: 41px; font-size: 12px">
            <td style="text-align: center;">SOTHUTU</td>
            <td style="text-align: center;">CntrNo</td>
            <td style="text-align: center;">OprID</td>
            <td style="text-align: center;">ISO_SZTP</td>
            <td style="text-align: center;">Status</td>
            <td style="text-align: center;">CJModeName</td>
            <td style="text-align: center;">DMethod_CD</td>
        </tr>
EOT;

        $strRowContent = '';
        $i = 1;
        foreach ( $orderData as $item ) {
            $row = array(
                "SOTHUTU" => $i++,
                "BLNo" => $item["BLNo"] !== null ? $item["BLNo"] : ( $item["BookingNo"] !== null ? $item["BookingNo"] : "" ),
                "CntrNo" => $item["CntrNo"],
                "OprID" => $item["OprID"],
                "ISO_SZTP" => $item["ISO_SZTP"],
                "Status" => $item["Status"] == "F" ? "Hàng" : "Rỗng",
                "CJModeName" => $item["CJModeName"],
                "DMethod_CD" => $item["DMethod_CD"]
            );
            
            $strRowContent .= $this->funcs->strReplaceAssoc( $row, $strRowTemp );
        }

        $logo = '<img style="width:69px;height:40px" src="'.base_url('assets/img/logos/logo-itc.png').'" alt="logo" />';

        $pngAbsoluteFilePath = FCPATH."assets/img/qrcode_gen/".$pinCode.".png";

        $qrCodeImg = '';
        if( file_exists( $pngAbsoluteFilePath ) ){
            $qrCodeImg = '<img style="width:90px;height:90px" src="'.base_url('assets/img/qrcode_gen/'.$pinCode.'.png').'" alt="logo" />';
        }

        $jsUrl = base_url('assets/js/html2pdf.js');

        $content = <<<EOT
        <div id="print-content" style="padding:0;margin:0;">
           <table style="width: 100%;">
              <tbody>
                 <tr>
                    <td style="width: 15%; font-size: 12px; text-align:right" >
                      $logo
                    </td>
                    <td style="width: 70%; font-size: 12px; color: navy" >
                      <strong style="font-size: 16px;">CẢNG CONTAINER QUỐC TẾ SP-ITC</strong>
                            <br />SP-ITC INTERNATIONAL CONTAINER TERMINAL
                    </td>
                    <td rowspan="2" style="width: 15%;">$qrCodeImg</td>
                 </tr>
                 <tr>
                    <td style="width: 10%;">&nbsp;</td>
                    <td style="text-align: center;">
                       <span style="color: navy; font-size: 20px;"><strong>LỆNH TỔNG</strong></span><br />
                    </td>
                 </tr>
              </tbody>
           </table>
           <table style="width:100%;margin-top:5px;padding:5px">
              <tbody>
                  <tr style="height: 22px;">
                    <td style="width: 28%; font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Số PIN: </strong></span>
                        <span>$pinCode</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(PIN Code)</em></span>
                    </td> 
                    <td style="width: 34%; font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Số hóa đơn: </strong></span>
                        <span>$invNo</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(Invoice/Deposit No.)</em></span>
                    </td>
                    <td style="width: 38%; font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Ngày hết hạn: </strong></span>
                        <span>$expDate</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(Expired Date)</em></span>
                    </td>
                 </tr>
                 <tr style="height: 22px;">
                    <td colspan="2" style="font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Số Vận Đơn/Booking: </strong></span>
                        <span>$blbkNo</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(BL/Booking No)</em></span>
                    </td>
                    <td style="font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Hạn điện: </strong></span>
                        <span>$expPlugDate</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(Plugin Expired Date)</em></span>
                    </td>
                 </tr>
                 <tr style="height: 22px;">
                    <td colspan="3" style="font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Khách hàng: </strong></span>
                        <span>$cusName</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(Customer)</em></span>
                    </td>
                 </tr>
                 <tr style="height: 22px;">
                    <td style="font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Đại diện bởi: </strong></span>
                        <span>$nameDD</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(Representative)</em></span>
                    </td>
                    <td style="font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>CMND/Điện thoại: </strong></span>
                        <span>$personalID</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(ID/Tel.)</em></span>
                    </td>
                    <td style="font-size: 12px; height: 22px;">
                        <span style="color:navy"><strong>Tàu chuyến: </strong></span>
                        <span>$shipID / $imVoy / $exVoy</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(Vessel Voyage)</em></span>
                    </td>
                 </tr>
                 <tr style="height: 22px">
                    <td colspan=3 style="font-size: 12px; height: 22px;padding-top:5px">
                        <span style="color:navy"><strong>Ghi chú: </strong></span>
                        <span>$note</span>
                        <br/>
                        <span style="color:navy; font-size:10px"><em>(Note)</em></span>
                    </td>
                 </tr>
              </tbody>
           </table>
           <table id="detail-table" style="width: 100%;border: 1px solid #bbb; border-width: 0 0 1px 1px" cellspacing="0">
              <tbody>
                 <tr style="height: 41px;">
                    <td style="width: 8%; text-align: center; font-size: 12px; height: 41px;color:navy">
                      <strong>STT</strong>
                      <br/><span style="font-size:10px"><em>(Seq.)</em></span>
                    </td>
                    <td style="width: 20%; text-align: center; font-size: 12px; height: 41px;color:navy">
                      <strong>Số Container</strong>
                      <br/><span style="font-size:10px"><em>(Container No)</em></span>
                    </td>
                    <td style="width: 10%; text-align: center; font-size: 12px; height: 41px;color:navy">
                      <strong>Hãng KT</strong>
                      <br/><span style="font-size:10px"><em>(CO)</em></span>
                    </td>
                    <td style="width: 10%; text-align: center; font-size: 12px; height: 41px;color:navy">
                      <strong>KC ISO</strong>
                      <br/><span style="font-size:10px"><em>(ISO Size)</em></span>
                    </td>
                    <td style="width: 15%; text-align: center; font-size: 12px; height: 41px;color:navy">
                      <strong>Hàng/Rỗng</strong>
                      <br/><span style="font-size:10px"><em>(Status)</em></span>
                    </td>
                    <td style="width: 20%; text-align: center; font-size: 12px; height: 41px;color:navy">
                      <strong>Phương Án</strong>
                      <br/><span style="font-size:10px"><em>(Transaction Mode)</em></span>
                    </td>
                    <td style="width: 12%; text-align: center; font-size: 12px; height: 41px;color:navy">
                      <strong>PTGN</strong>
                      <br/><span style="font-size:10px"><em>(Method)</em></span>
                    </td>
                 </tr>
                 $strRowContent
              </tbody>
           </table>
           <table style="width: 100%; margin-top: 5px;">
              <tbody>
                  <tr style="height: 22px;">
                    <td style="width: 62%; font-size: 12px; height: 22px">
                    </td>
                    <td style="width: 38%; font-size: 12px; height: 22px;text-align:center">
                        <p>Tp. HCM, ngày $day tháng $month năm $year</p>
                        <p>Người lập lệnh</p>
                    </td>
                 </tr>
              </tbody>
           </table>
        </div>
EOT;
        
        $this->data["title"] = "Lệnh tổng";
        $this->data["htmlString"] = $content;
        $this->load->view( "print_file/viewPDF", $this->data );

    }

}
