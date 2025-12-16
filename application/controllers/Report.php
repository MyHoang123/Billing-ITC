<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("report_model", "mdlRpt");
        $this->load->model("user_model", "user");

        $this->ceh = $this->load->database('mssql', TRUE);
        $this->data['menus'] = $this->menu->getMenu();
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
                if($method == md5($smethod)) {
                    $this->$smethod();
                    break;
                }
            }
        }

        if(!in_array($method, $a_methods)) {
            // show_404();
            $this->show_developing();
        }
    }

    private function show_developing(){
        $this->data['title'] = "Ohhhh";

        $this->load->view('header', $this->data);
        
        $this->load->view('errors/html/error_developing');
        $this->load->view('footer');
    }

    public function rptRevenue(){
        $access = $this->user->access('rptRevenue');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $todate = $this->input->post('todate') ? $this->input->post('todate') : '';
            $jmode = $this->input->post('jmode') ? $this->input->post('jmode') : '';
            $sys = $this->input->post('sys') ? $this->input->post('sys') : '';

            $this->data['results'] = $this->mdlRpt->rptRevenue($fromdate, $todate, $jmode, $sys);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tổng hợp doanh thu";

        $this->load->view('header', $this->data);
        $this->load->view('report/revenue', $this->data);
        $this->load->view('footer');
        }
        
    public function rptReleasedInv(){
        $access = $this->user->access('rptReleasedInv');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $todate = $this->input->post('todate') ? $this->input->post('todate') : '';
            $jmode = $this->input->post('jmode') ? $this->input->post('jmode') : '*';
            $paymentType = $this->input->post('paymentType') ? $this->input->post('paymentType') : '*';
            $currency = $this->input->post('currency') ? $this->input->post('currency') : '*';
            $adjust_type = $this->input->post('adjust_type');
            $sys = $this->input->post('sys', TRUE);

            $this->data['results'] = $this->mdlRpt->rptReleasedInv($fromdate, $todate, $jmode, $paymentType, $currency, $sys, $adjust_type);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Báo cáo phát hành hóa đơn";

        $this->load->view('header', $this->data);
        $this->load->view('report/releasedInv', $this->data);
        $this->load->view('footer');
    }

    public function rptRevenueByInvoices(){
        $access = $this->user->access('rptRevenueByInvoices');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlRpt->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdlRpt->getPayers();
                echo json_encode($this->data);
                exit;
            }

            $args = [
                "fromDate" => $this->input->post('fromDate') ? $this->input->post('fromDate') : ''
                , "toDate" => $this->input->post('toDate') ? $this->input->post('toDate') : ''
                , "shipKey" => $this->input->post('shipKey') ? $this->input->post('shipKey') : ''
                , "createdBy" => $this->input->post('createdBy') ? $this->input->post('createdBy') : ''
                , "currencyId" => $this->input->post('currencyId') ? $this->input->post('currencyId') : ''
                , "payment_type" => $this->input->post('payment_type') ? $this->input->post('payment_type') : ''
                , "adjust_type" => $this->input->post('adjust_type')
                , "sys" => $this->input->post('sys') ? $this->input->post('sys') : ''
            ];

            $this->data['results'] = $this->mdlRpt->rptRevenueByInvoices( $args );
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Báo cáo doanh thu hoá đơn thu ngay";

        $this->load->view('header', $this->data);
        $this->data['userIds'] = $this->mdlRpt->getUserId();
        $this->load->view('report/revenue_byInvoices', $this->data);
        $this->load->view('footer');
    }

    public function rptCancelInv(){
        $access = $this->user->access('rptCancelInv');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            $args = [
                "fromDate" => $this->input->post('fromDate') ? $this->input->post('fromDate') : ''
                , "toDate" => $this->input->post('toDate') ? $this->input->post('toDate') : ''
                , "paymentType" => $this->input->post('paymentType')
                , "sys" => $this->input->post('sys')
            ];

            $this->data['results'] = $this->mdlRpt->rptCancelInvoices( $args );
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Thống kê hoá đơn huỷ";

        $this->load->view('header', $this->data);
        $this->data['userIds'] = $this->mdlRpt->getUserId();
        $this->load->view('report/inv_cancel_summary', $this->data);
        $this->load->view('footer');
    }

    public function export_revenue() {
        $datajson = $this->input->post('exportdata') ? $this->input->post('exportdata') : '';
        $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
        $todate = $this->input->post('todate') ? $this->input->post('todate') : '';

        $args = json_decode($datajson, true);

        $this->load->library('excel');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, "Excel2007");
        ob_end_clean();

        $this->excel->getDefaultStyle()->getFont()->setName('Times New Roman');
        $this->excel->getDefaultStyle()->getFont()->setSize(12);

        $objSheet0 = $this->excel->getActiveSheet();

        //row header
        $objSheet0->mergeCells('B2:K2');
        $objSheet0->getStyle('B2:K2')->getFont()->setBold(true)->setSize(20);
        $objSheet0->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        , 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getCell('B2')->setValue("BÁO CÁO PHÁT HÀNH HÓA ĐƠN");
        $objSheet0->getRowDimension('2')->setRowHeight(35);
        $objSheet0->getStyle('B')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));


//        //tu ngay, den ngay
        $objSheet0->getStyle('C4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('C4')->setValue("Từ Ngày");
        $objSheet0->getStyle('C4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('D4:E4');
        $objSheet0->getStyle('D4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('D4')->setValue($fromdate);
        $objSheet0->getStyle('D4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getStyle('F4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('F4')->setValue("Đến Ngày");
        $objSheet0->getStyle('F4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('G4:H4');
        $objSheet0->getStyle('G4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('G4')->setValue($todate);
        $objSheet0->getStyle('G4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getRowDimension('4')->setRowHeight(25);

//      sheet name
        $objSheet0->setTitle('Issued Invoice');
//
//        //header
        $objSheet0->getStyle('B6:J6')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getStyle('B6:J6')->getFont()->setBold(true)->setSize(12);
        $objSheet0->getStyle('B6:J6')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'BDDCEF'))));

        $objSheet0->getCell('B6')->setValue('STT');
        $objSheet0->getCell('C6')->setValue('SỐ PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('D6')->setValue('NGÀY PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('E6')->setValue('QUYỂN HÓA ĐƠN');
        $objSheet0->getCell('F6')->setValue('SỐ HÓA ĐƠN');
        $objSheet0->getCell('G6')->setValue('NGÀY HÓA ĐƠN');
        $objSheet0->getCell('H6')->setValue('THÀNH TIỀN');
        $objSheet0->getCell('I6')->setValue('THUẾ VAT');
        $objSheet0->getCell('J6')->setValue('TỔNG TIỀN');
        $objSheet0->getRowDimension('6')->setRowHeight(50);

        $a=6;
        $grID = ""; $j = 0;
        if($args === null) goto xxx;
        foreach($args as $arg) {
            $a++;
            $j++;
            $objSheet0->getCell('B' . $a)->setValue($j);
            $objSheet0->getCell('C' . $a)->setValue($arg['DRAFT_INV_NO']);
            $objSheet0->getCell('D' . $a)->setValue($arg['DRAFT_INV_DATE']);
            $objSheet0->getCell('E' . $a)->setValue($arg['INV_PREFIX']);
            $objSheet0->getCell('F' . $a)->setValue($arg['INV_NO']);
            $objSheet0->getCell('G' . $a)->setValue($arg['INV_DATE']);
            $objSheet0->getCell('H' . $a)->setValue($arg['AMOUNT']);
            $objSheet0->getCell('I' . $a)->setValue($arg['VAT']);
            $objSheet0->getCell('J' . $a)->setValue($arg['TAMOUNT']);
            $objSheet0->getRowDimension($a)->setRowHeight(20);
        }

        xxx:
//        $objSheet0->getStyle('C9:C' . $a)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getStyle('H7:J' . $a)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getStyle('H7:J' . $a)->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* ""_);_(@_)');

        $objSheet0->getStyle('B6:K' . $a)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '9EBAE0')))));

        $objSheet0->getColumnDimension('B')->setWidth(6);
        $objSheet0->getColumnDimension('C')->setWidth(40);
        $objSheet0->getColumnDimension('D')->setWidth(12);
        $objSheet0->getColumnDimension('E')->setWidth(12);
        $objSheet0->getColumnDimension('F')->setWidth(12);
        $objSheet0->getColumnDimension('G')->setWidth(12);
        $objSheet0->getColumnDimension('H')->setWidth(12);
        $objSheet0->getColumnDimension('I')->setWidth(12);
        $objSheet0->getColumnDimension('J')->setWidth(12);
        $objSheet0->getColumnDimension('K')->setWidth(12);
        $objSheet0->setShowGridlines(false);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ThongKeSanLuong.xls"');
        $objWriter->save('php://output');
    }

    public function export_releaseInv() {
        $datajson = $this->input->post('exportdata') ? $this->input->post('exportdata') : '';
        $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
        $todate = $this->input->post('todate') ? $this->input->post('todate') : '';

        $args = json_decode($datajson, true);

        $this->load->library('excel');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, "Excel2007");
        ob_end_clean();

        $this->excel->getDefaultStyle()->getFont()->setName('Times New Roman');
        $this->excel->getDefaultStyle()->getFont()->setSize(12);

        $objSheet0 = $this->excel->getActiveSheet();

        //row header
        $objSheet0->mergeCells('B2:J2');
        $objSheet0->getStyle('B2:J2')->getFont()->setBold(true)->setSize(20);
        $objSheet0->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        , 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getCell('B2')->setValue("BÁO CÁO PHÁT HÀNH HÓA ĐƠN");
        $objSheet0->getRowDimension('2')->setRowHeight(35);
        $objSheet0->getStyle('B')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));


//        //tu ngay, den ngay
        $objSheet0->getStyle('C4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('C4')->setValue("Từ Ngày");
        $objSheet0->getStyle('C4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('D4:E4');
        $objSheet0->getStyle('D4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('D4')->setValue($fromdate);
        $objSheet0->getStyle('D4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getStyle('F4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('F4')->setValue("Đến Ngày");
        $objSheet0->getStyle('F4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('G4:H4');
        $objSheet0->getStyle('G4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('G4')->setValue($todate);
        $objSheet0->getStyle('G4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getRowDimension('4')->setRowHeight(25);

//      sheet name
        $objSheet0->setTitle('Issued Invoice');
//
//        //header
        $objSheet0->getStyle('B6:J6')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                                                                            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                                                            , 'wrap' => true));

        $objSheet0->getStyle('B6:J6')->getFont()->setBold(true)->setSize(12);
        $objSheet0->getStyle('B6:J6')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'BDDCEF'))));

        $objSheet0->getCell('B6')->setValue('STT');
        $objSheet0->getCell('C6')->setValue('SỐ PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('D6')->setValue('NGÀY PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('E6')->setValue('QUYỂN HÓA ĐƠN');
        $objSheet0->getCell('F6')->setValue('SỐ HÓA ĐƠN');
        $objSheet0->getCell('G6')->setValue('NGÀY HÓA ĐƠN');
        $objSheet0->getCell('H6')->setValue('THÀNH TIỀN');
        $objSheet0->getCell('I6')->setValue('THUẾ VAT');
        $objSheet0->getCell('J6')->setValue('TỔNG TIỀN');
        $objSheet0->getRowDimension('6')->setRowHeight(50);

        $a=6;
        $grID = ""; $j = 0;
        if($args === null) goto xxx;

        $amt = 0;
        $vat = 0;
        $totalAMT = 0;
        foreach($args as $arg) {
            $a++;
            $j++;
            $objSheet0->getCell('B' . $a)->setValue( $j );
            $objSheet0->getCell('C' . $a)->setValue( $arg['DRAFT_INV_NO'] );
            $objSheet0->getCell('D' . $a)->setValue( $this->funcs->clientDateTime( $arg['DRAFT_INV_DATE'], '/' ) );
            $objSheet0->getCell('E' . $a)->setValue( $arg['INV_PREFIX'] );
            $objSheet0->getCell('F' . $a)->setValue( $arg['INV_NO'] );
            $objSheet0->getCell('G' . $a)->setValue( $this->funcs->clientDateTime( $arg['INV_DATE'], '/' ) );
            $objSheet0->getCell('H' . $a)->setValue( $arg['AMOUNT'] );
            $objSheet0->getCell('I' . $a)->setValue( $arg['VAT'] );
            $objSheet0->getCell('J' . $a)->setValue( $arg['TAMOUNT'] );
            $objSheet0->getRowDimension($a)->setRowHeight(20);

            $amt += floatval($arg['AMOUNT']);
            $vat += floatval($arg['VAT']);
            $totalAMT += floatval($arg['TAMOUNT']);
        }

        xxx:

        //canh giữa các thông tin trừ số tiền
        $objSheet0->getStyle('C7:G' . $a)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        //for total row
        $a += 1;
        $objSheet0->mergeCells('B'.$a.':G'.$a);
        //text color
        $objSheet0->getStyle('B'.$a.':J'.$a)->applyFromArray(array('font' => array('size' => 13,'bold' => true,'color' => array('rgb' => 'ff0000'))));
        //bg color
        $objSheet0->getStyle('B'.$a.':J'.$a)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'fffee2'))));
        //aligment
        $objSheet0->getStyle('B'.$a)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getCell('B' . $a)->setValue("TỔNG CỘNG");
        $objSheet0->getCell('H' . $a)->setValue( $amt );
        $objSheet0->getCell('I' . $a)->setValue( $vat );
        $objSheet0->getCell('J' . $a)->setValue( $totalAMT );
        $objSheet0->getRowDimension($a)->setRowHeight(30);
        //for total row


        $objSheet0->getStyle('H7:J' . $a)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getStyle('H7:J' . $a)->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* ""_);_(@_)');

        $objSheet0->getStyle('B6:J' . $a)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '9EBAE0')))));

        $objSheet0->getColumnDimension('B')->setWidth(8);
        $objSheet0->getColumnDimension('C')->setWidth(20);
        $objSheet0->getColumnDimension('D')->setWidth(22);
        $objSheet0->getColumnDimension('E')->setWidth(12);
        $objSheet0->getColumnDimension('F')->setWidth(16);
        $objSheet0->getColumnDimension('G')->setWidth(22);
        $objSheet0->getColumnDimension('H')->setWidth(20);
        $objSheet0->getColumnDimension('I')->setWidth(18);
        $objSheet0->getColumnDimension('J')->setWidth(22);
        $objSheet0->setShowGridlines(false);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="HoaDonPhatHanh.xlsx"');
        $objWriter->save('php://output');
    }
}
