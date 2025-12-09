<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_Tariff extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("Contracttrf_model", "mdlctf");
        $this->load->model("common_model", "mdlCommon");
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
            //show_404();
           $this->show_developing();
        }
    }

    private function show_developing(){
        $this->data['title'] = "Ohhhh";

        $this->load->view('header', $this->data);
        
        $this->load->view('errors/html/error_developing');
        $this->load->view('footer');
    }

    public function ctDiscountRates()
    {
        $access = $this->user->access('ctDiscountRates');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlctf->saveTRFCode($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('TRF_CODES');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tỉ lệ giảm giá";

        $this->load->view('header', $this->data);
        
        $this->load->view('contract_tariff/discount_rate', $this->data);
        $this->load->view('footer');
    }

    public function ctTRFCode()
    {
        $access = $this->user->access('ctTRFCode');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlctf->saveTRFCode($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('TRF_CODES');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Mã biểu cước";

        $this->load->view('header', $this->data);

        $this->data["unitCodes"] = $this->mdlCommon->loadUnitCodes();
        $this->data["trfCodes"] = $this->mdlctf->loadTariffCodes();
        
        $this->load->view('contract_tariff/tariff_code', $this->data);
        $this->load->view('footer');
    }

    public function ctTariff_Standard()
    {
        $access = $this->user->access('ctTariff_Standard');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view')
        {
            $temp = $this->input->post('temp') ? $this->input->post('temp') : '';

            $this->data['list'] = $this->mdlctf->loadTariffStandard($temp);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            $applyDate = $this->input->post('applyDate') ? $this->input->post('applyDate') : '';
            $expireDate = $this->input->post('expireDate') ? $this->input->post('expireDate') : '';
            $ref_mark = $this->input->post('ref_mrk') ? $this->input->post('ref_mrk') : '';
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlctf->saveTariffSTD($saveData, $applyDate, $expireDate, $ref_mark);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('TRF_STD');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Biểu cước chuẩn";

        $this->load->view('header', $this->data);
        $this->data['temp'] = $this->mdlctf->tarrifTemplate();
        $this->data["unitCodes"] = $this->mdlCommon->loadUnitCodes();
        $this->data["cargoTypes"] = $this->mdlCommon->loadCargoType();
        $this->data["trfCodes"] = $this->mdlctf->loadTRFSource();

        $this->data["cjModes"] = $this->mdlCommon->loadDeliveryMode();
        $this->data["dmethods"] = $this->mdlCommon->loadDMethod();
        $this->data["cntrClass"] = $this->mdlCommon->loadCntrClass();
        $this->data["alljob"] = $this->mdlCommon->loadAllJob();
        $this->data["transits"] = $this->mdlCommon->loadTransits();

        $this->load->view('contract_tariff/tariff_standard', $this->data);
        $this->load->view('footer');
    }

    public function ctContract()
    {
        $access = $this->user->access('ctContract');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view')
        {
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == "load_dis" ){
                $temp = $this->input->post('temp') ? $this->input->post('temp') : '';
                $this->data['list'] = $this->mdlctf->loadContract($temp);
                echo json_encode($this->data);
                exit;
            }

            if( $act == "load_opr" ){
                $this->data['oprs'] = $this->mdlctf->getOpr();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdlctf->getPayers();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlctf->searchShipLane($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            echo true; exit();
            
        }

        if( $action == 'add' || $action == 'edit' ){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            
            $applyDate = $this->input->post('applyDate') ? $this->input->post('applyDate') : '*';
            $expireDate = $this->input->post('expireDate') ? $this->input->post('expireDate') : '';
            $ref_mark = $this->input->post('ref_mrk') ? $this->input->post('ref_mrk') : '';

            $nickName = $this->input->post('nickName') ? $this->input->post('nickName') : '';
            $oprID = $this->input->post('oprID') ? $this->input->post('oprID') : '';
            $payer = $this->input->post('payer') ? $this->input->post('payer') : '';
            $payerType = $this->input->post('payerType') ? $this->input->post('payerType') : '';
            $paymentType = $this->input->post('paymentType') ? $this->input->post('paymentType') : '';

            $lane = $this->input->post('lane') ? $this->input->post('lane') : '*';

            $commons = [
                'OPR' => $oprID,
                'LANE' => $lane,
                'PAYER' => $payer,
                'PAYER_TYPE' => $payerType,
                'PAYMENT_TYPE' => $paymentType,
                'NICK_NAME' => UNICODE.$nickName,
                'REF_RMK' => UNICODE.$ref_mark,
                'APPLY_DATE' =>  $applyDate,
                'EXPIRE_DATE' => $expireDate == '' ? NULL : $this->funcs->dbDateTime($expireDate)
            ];

            if( count( $saveData ) > 0 ){
                $this->data['result'] = $this->mdlctf->saveDisTariff($saveData, $commons);
                echo json_encode($this->data);
                exit;
            }

            echo true;
            exit;
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('TRF_DIS');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Hợp đồng (CKTP)";

        $this->load->view('header', $this->data);
        $this->data['temp'] = $this->mdlctf->contractTemplate();

        $this->data["unitCodes"] = $this->mdlCommon->loadUnitCodes();
        $this->data["cargoTypes"] = $this->mdlCommon->loadCargoType();
        $this->data["trfCodes"] = $this->mdlctf->loadTRFSource();

        $this->data["cjModes"] = $this->mdlCommon->loadDeliveryMode();
        $this->data["dmethods"] = $this->mdlCommon->loadDMethod();
        $this->data["cntrClass"] = $this->mdlCommon->loadCntrClass();
        $this->data["alljob"] = $this->mdlCommon->loadAllJob();
        $this->data["transits"] = $this->mdlCommon->loadTransits();

        $this->load->view('contract_tariff/contract', $this->data);
        $this->load->view('footer');
    }

    public function ctTRFFreeDay()
    {
        $access = $this->user->access('ctTRFFreeDay');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Biểu cước lưu bãi";

        $this->load->view('header', $this->data);
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->data['payers'] = $this->mdlCommon->getPayers();
        
        $this->load->view('contract_tariff/tariff_free_day', $this->data);
        $this->load->view('footer');
    }

    public function ctTariff_Template()
    {
        $access = $this->user->access('ctTariff_Template');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == 'view')
        {
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            
            if( $act == 'load_inv_tplt' ){
                $this->data['templates'] = $this->mdlCommon->loadInvTemplate();
            }

            if( $act == 'load_tariff' ){
                $temp = $this->input->post('temp') ? $this->input->post('temp') : '';
                $this->data['list'] = $this->mdlctf->loadTRF_DTD_InvTPLT($temp);
            }

            echo json_encode($this->data);
            exit;
        }

        if( $action == 'edit' ){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            $onlyUpdate = $this->input->post('only_update') ? $this->input->post('only_update') : false;
            if(count( $saveData ) > 0){
                $outputMsgs = array();
                $this->data['result'] = $this->mdlctf->saveInvTemplate( $saveData, $onlyUpdate, $outputMsgs );
                $this->data["error"] = $outputMsgs;
                echo json_encode($this->data);
                exit;
            }else{
                $this->data['nothing'] = "nothing";
                echo json_encode($this->data['nothing'] );
                exit();
            }
        }

        if($action == 'delete')
        {
            $delRowguid = $this->input->post('data') ? $this->input->post('data') : "";
            if( $delRowguid != "" )
            {
                $outMsg = '';
                $this->data['result'] = $this->mdlctf->deleteInvTemplate($delRowguid, $outMsg);
                $this->data["error"] = $outMsg;
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Mẫu biểu cước";

        $this->load->view('header', $this->data);

        $this->data['temp'] = $this->mdlctf->tarrifTemplate();

        $this->load->view('contract_tariff/tariff_template', $this->data);
        $this->load->view('footer');
    }

    public function ctTRFExtra() //phu phi nang ha + luu bai bac thang
    {
        $access = $this->user->access('ctTRFExtra');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view')
        {
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == "load_trf" ){
                $levelCode = $this->input->post('temp') ? $this->input->post('temp') : '';
                $this->data['list'] = $this->mdlctf->loadTariffExtra($levelCode);
                echo json_encode($this->data);
                exit;
            }

            if( $act == "load_opr" ){
                $this->data['oprs'] = $this->mdlctf->getOpr();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdlctf->getPayers();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlctf->searchShipLane($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            echo true; exit();
            
        }

        if( $action == 'add' || $action == 'edit' ){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            $levelCode = $this->input->post('levelCode') ? $this->input->post('levelCode') : '';
            $levelName = $this->input->post('levelName') ? $this->input->post('levelName') : '';
            $applyDate = $this->input->post('applyDate') ? $this->input->post('applyDate') : '*';
            $expireDate = $this->input->post('expireDate') ? $this->input->post('expireDate') : '';
            $ref_mark = $this->input->post('ref_mrk') ? $this->input->post('ref_mrk') : '';
            $oprID = $this->input->post('oprID') ? $this->input->post('oprID') : '';
            $payer = $this->input->post('payer') ? $this->input->post('payer') : '';
            $payerType = $this->input->post('payerType') ? $this->input->post('payerType') : '';
            $paymentType = $this->input->post('paymentType') ? $this->input->post('paymentType') : '';
            $lane = $this->input->post('lane') ? $this->input->post('lane') : '*';

            $commons = [
                'OPR' => $oprID,
                'LaneID' => $lane,
                'PAYER' => $payer,
                'PAYER_TYPE' => $payerType,
                'PAYMENT_TYPE' => $paymentType,
                'LevelCode' => $levelCode,
                'LevelName' => $levelName,
                'REF_RMK' => $ref_mark,
                'APPLY_DATE' =>  $applyDate,
                'EXPIRE_DATE' => $expireDate == '' ? NULL : $this->funcs->dbDateTime($expireDate)
            ];

            if( count( $saveData ) > 0 ){
                $this->data['result'] = $this->mdlctf->saveExtraTariff($saveData, $commons);
                echo json_encode($this->data);
                exit;
            }

            echo true;
            exit;
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('TRF_LEVEL');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Phụ phí nâng hạ & lưu bãi bậc thang";

        $this->load->view('header', $this->data);
        $this->data['temp'] = $this->mdlctf->trfExtraTemplate();

        $this->data["unitCodes"] = $this->mdlCommon->loadUnitCodes();
        $this->data["cargoTypes"] = $this->mdlCommon->loadCargoType();
        $this->data["trfCodes"] = $this->mdlctf->loadTRFSource();

        $this->data["cjModes"] = $this->mdlCommon->loadDeliveryMode();
        $this->data["dmethods"] = $this->mdlCommon->loadDMethod();
        $this->data["cntrClass"] = $this->mdlCommon->loadCntrClass();
        $this->data["alljob"] = $this->mdlCommon->loadAllJob();
        $this->data["transits"] = $this->mdlCommon->loadTransits();

        $this->load->view('contract_tariff/tariff_extra', $this->data);
        $this->load->view('footer');
    }

    public function downloadTariffStandardTemp(){
        $this->load->library('excel');

        $inputFileName = FCPATH.'/download/bieu-cuoc-chuan.xlsx';

        /*check point*/

        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->setActiveSheetIndex(0);

        // set source 
        // $objPHPExcel->getActiveSheet()
        //             ->setCellValue('A10', 'EDITED Last Name')
        //             ->setCellValue('B11', 'EDITED First Name')
        //             ->setCellValue('C12', 'EDITED Age')
        //             ->setCellValue('D13', 'EDITED Sex')
        //             ->setCellValue('E14', 'EDITED Location');


        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="bieu-cuoc.xlsx"');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}
