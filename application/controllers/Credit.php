<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("Credit_model", "mdlcre");
        $this->load->model("task_model", "mdltask");
        $this->load->model("common_model", "mdlcommon");
        $this->load->model("user_model", "user");

        $this->ceh = $this->load->database('mssql', TRUE);
        $this->data['menus'] = $this->menu->getMenu();
    }

    public function _remap($method) {
        $methods = get_class_methods($this);

        $skip = array("_remap", "__construct", "get_instance");
        $a_methods = [];

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

    public function crePaymentCredit()
    {
        $access = $this->user->access('crePaymentCredit');
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
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }

            if( $act == 'search_ship' ){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlcre->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : [];
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tính cước thu sau";

        $this->load->view('header', $this->data);
        $this->load->view('credit/payment_credit', $this->data);
        $this->load->view('footer');
    }

    public function creShipTotal()
    {
        $access = $this->user->access('creShipTotal');
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

            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }

            if( $act == "load_opr" ){
                $this->data['oprs'] = $this->mdlcre->getOpr();
                echo json_encode($this->data);
                exit;
            }

            if( $act == 'search_ship' ){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlcre->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_data'){
                $args = $this->input->post('args') ? $this->input->post('args') : [];

                $out = $this->mdlcre->loadShipTotal( $args );

                $this->data['results'] = $out["DETAIL"];
                $this->data['totals'] = $out["SUM"];
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $invTemp = $this->input->post('invTemp') ? $this->input->post('invTemp') : '';
                $this->calculate_payment( $list, $cusID, $invTemp );
                exit;
            }

        }

        if( $action == "save" ) {
            $args = $this->input->post('args') ? $this->input->post('args') : [];
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == 'use_manual_Inv' ){
                $useInvData = $this->input->post('useInvData') ? $this->input->post('useInvData') : array();

                if( count( $useInvData ) > 0 ){
                    $useInvData['serial'] = trim( $useInvData['serial'] );
                    $useInvData['invno'] = trim( $useInvData['invno'] );

                    $checkInvNo = $this->mdltask->checkInvNo( $useInvData['serial'], $useInvData['invno'] );

                    if( $checkInvNo ){
                        $this->data["isDup"] = true;
                        echo json_encode( $this->data );
                        exit;
                    }

                    $this->session->set_userdata("invInfo", json_encode( $useInvData ));
                }

                echo true;
                exit;
            }

            if( ( $this->session->userdata("invInfo") === null || count( json_decode($this->session->userdata("invInfo"), true) ) == 0 ) 
                        && isset( $data["pubType"] ) && $data["pubType"] == "m-inv" ){
                $this->data["non_invInfo"] = "Chưa cấu hình hóa đơn!";
                echo json_encode( $this->data );
                exit();
            }

            $manualInvInfo = json_decode($this->session->userdata("invInfo"), true);
            $checkInvNo = $this->mdltask->checkInvNo( $manualInvInfo['serial'], $manualInvInfo['invno'] );

            if( $checkInvNo ){
                $this->data["isDup"] = true;
                echo json_encode( $this->data );
                exit();
            }

            $outInfo = [];
            $this->data['message'] = $this->mdlcre->save_draft_invoice( 'QUAYJOB', $args, $outInfo );
            
            if( isset( $args['invInfo'] ) )
            {
                $this->data['invInfo'] = $args['invInfo'];
            }else{
                if( isset( $args["pubType"] ) ){
                    if( $args["pubType"] == "m-inv" )
                    {
                        $this->data['invInfo'] = $data['invInfo'] = $outInfo[0];
                        $outInfo = [];
                    }
                    else if( $args["pubType"] == "dft" )
                    {
                        $this->data['dftInfo'] = $outInfo;
                    }
                }
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tập hợp xếp dỡ tàu";

        
        $this->load->view('header', $this->data);

        $this->data['dmethods'] = $this->mdlcre->getDMethods();
        $this->data['transits'] = $this->mdlcre->getTransits();
        $this->data['invTemps'] = $this->mdlcre->getInvTemp();

        $ssInvInfo = json_decode($this->session->userdata("invInfo"), true);

        $this->data["ssInvInfo"] = $ssInvInfo;
        $this->data["isDup"] = $this->mdltask->checkInvNo( $ssInvInfo['serial'], $ssInvInfo['invno'] );

        $this->load->view('credit/ship_total', $this->data);
        $this->load->view('footer');
    }

    public function creContLiftTotal()
    {
        $access = $this->user->access('creContLiftTotal');
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
            
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdlcre->getPayers();
                echo json_encode($this->data);
                exit;
            }
            
            if( $act == 'search_ship' ){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlcre->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            if( $act == "load_opr" ){
                $this->data['oprs'] = $this->mdlcre->getOpr();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_data'){
                $args = $this->input->post('args') ? $this->input->post('args') : [];

                $out = $this->mdlcre->loadContLiftTotal( $args );

                $this->data['results'] = $out["DETAIL"];
                $this->data['totals'] = $out["SUM"];
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $invTemp = $this->input->post('invTemp') ? $this->input->post('invTemp') : '';
                $this->calculate_payment( $list, $cusID, $invTemp );
                exit;
            }
        }
        
        if( $action == "save" ) {
            $args = $this->input->post('args') ? $this->input->post('args') : [];
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == 'use_manual_Inv' ){
                $useInvData = $this->input->post('useInvData') ? $this->input->post('useInvData') : array();

                if( count( $useInvData ) > 0 ){
                    $useInvData['serial'] = trim( $useInvData['serial'] );
                    $useInvData['invno'] = trim( $useInvData['invno'] );

                    $checkInvNo = $this->mdltask->checkInvNo( $useInvData['serial'], $useInvData['invno'] );

                    if( $checkInvNo ){
                        $this->data["isDup"] = true;
                        echo json_encode( $this->data );
                        exit;
                    }

                    $this->session->set_userdata("invInfo", json_encode( $useInvData ));
                }

                echo true;
                exit;
            }

            if( ( $this->session->userdata("invInfo") === null || count( json_decode($this->session->userdata("invInfo"), true) ) == 0 ) 
                        && isset( $data["pubType"] ) && $data["pubType"] == "m-inv" ){
                $this->data["non_invInfo"] = "Chưa cấu hình hóa đơn!";
                echo json_encode( $this->data );
                exit();
            }

            $manualInvInfo = json_decode($this->session->userdata("invInfo"), true);
            $checkInvNo = $this->mdltask->checkInvNo( $manualInvInfo['serial'], $manualInvInfo['invno'] );

            if( $checkInvNo ){
                $this->data["isDup"] = true;
                echo json_encode( $this->data );
                exit();
            }

            $outInfo = [];
            $this->data['message'] = $this->mdlcre->save_draft_invoice( 'GATE_MONITOR', $args, $outInfo );
            
            if( isset( $args['invInfo'] ) )
            {
                $this->data['invInfo'] = $args['invInfo'];
            }else{
                if( isset( $args["pubType"] ) ){
                    if( $args["pubType"] == "m-inv" )
                    {
                        $this->data['invInfo'] = $data['invInfo'] = $outInfo[0];
                        $outInfo = [];
                    }
                    else if( $args["pubType"] == "dft" )
                    {
                        $this->data['dftInfo'] = $outInfo;
                    }
                }
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tập hợp nâng hạ container";

        $this->load->view('header', $this->data);

        $this->data['dmethods'] = $this->mdlcre->getDMethods();
        $this->data['transits'] = $this->mdlcre->getTransits();
        $this->data['invTemps'] = $this->mdlcre->getInvTemp();

        $ssInvInfo = json_decode($this->session->userdata("invInfo"), true);

        $this->data["ssInvInfo"] = $ssInvInfo;
        $this->data["isDup"] = $this->mdltask->checkInvNo( $ssInvInfo['serial'], $ssInvInfo['invno'] );

        $this->load->view('credit/cont_lift_total', $this->data);
        $this->load->view('footer');
    }

    public function creYardServiceTotal()
    {
        $access = $this->user->access('creYardServiceTotal');
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
            
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdlcre->getPayers();
                echo json_encode($this->data);
                exit;
            }
            
            if( $act == 'search_ship' ){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlcre->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            if( $act == "load_opr" ){
                $this->data['oprs'] = $this->mdlcre->getOpr();
                echo json_encode($this->data);
                exit;
            }

            if( $act == "load_cjmode" ){
                $this->data['yardJobs'] = $this->mdlcre->getYardJobs();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_data'){
                $args = $this->input->post('args') ? $this->input->post('args') : [];

                $out = $this->mdlcre->loadYardServiceTotal( $args );

                $this->data['results'] = $out["DETAIL"];
                $this->data['totals'] = $out["SUM"];
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $invTemp = $this->input->post('invTemp') ? $this->input->post('invTemp') : '';
                $this->calculate_payment( $list, $cusID, $invTemp );
                exit;
            }
        }

        if( $action == "save" ) {
            $args = $this->input->post('args') ? $this->input->post('args') : [];
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == 'use_manual_Inv' ){
                $useInvData = $this->input->post('useInvData') ? $this->input->post('useInvData') : array();

                if( count( $useInvData ) > 0 ){
                    $useInvData['serial'] = trim( $useInvData['serial'] );
                    $useInvData['invno'] = trim( $useInvData['invno'] );

                    $checkInvNo = $this->mdltask->checkInvNo( $useInvData['serial'], $useInvData['invno'] );

                    if( $checkInvNo ){
                        $this->data["isDup"] = true;
                        echo json_encode( $this->data );
                        exit;
                    }

                    $this->session->set_userdata("invInfo", json_encode( $useInvData ));
                }

                echo true;
                exit;
            }

            if( ( $this->session->userdata("invInfo") === null || count( json_decode($this->session->userdata("invInfo"), true) ) == 0 ) 
                        && isset( $data["pubType"] ) && $data["pubType"] == "m-inv" ){
                $this->data["non_invInfo"] = "Chưa cấu hình hóa đơn!";
                echo json_encode( $this->data );
                exit();
            }

            $manualInvInfo = json_decode($this->session->userdata("invInfo"), true);
            $checkInvNo = $this->mdltask->checkInvNo( $manualInvInfo['serial'], $manualInvInfo['invno'] );

            if( $checkInvNo ){
                $this->data["isDup"] = true;
                echo json_encode( $this->data );
                exit();
            }

            $outInfo = [];
            $this->data['message'] = $this->mdlcre->save_draft_invoice( 'SRV_ODR', $args, $outInfo );
            
            if( isset( $args['invInfo'] ) )
            {
                $this->data['invInfo'] = $args['invInfo'];
            }else{
                if( isset( $args["pubType"] ) ){
                    if( $args["pubType"] == "m-inv" )
                    {
                        $this->data['invInfo'] = $data['invInfo'] = $outInfo[0];
                        $outInfo = [];
                    }
                    else if( $args["pubType"] == "dft" )
                    {
                        $this->data['dftInfo'] = $outInfo;
                    }
                }
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tập hợp dịch vụ bãi";

        $this->load->view('header', $this->data);

        $this->data['dmethods'] = $this->mdlcre->getDMethods();
        $this->data['transits'] = $this->mdlcre->getTransits();
        $this->data['class'] = $this->mdlcre->getCntrClass();
        $this->data['invTemps'] = $this->mdlcre->getInvTemp();

        $ssInvInfo = json_decode($this->session->userdata("invInfo"), true);

        $this->data["ssInvInfo"] = $ssInvInfo;
        $this->data["isDup"] = $this->mdltask->checkInvNo( $ssInvInfo['serial'], $ssInvInfo['invno'] );

        $this->load->view('credit/yard_service_total', $this->data);
        $this->load->view('footer');
    }

    public function creContStackingTotal()
    {
        $this->show_developing();
        return;

        $access = $this->user->access('creContStackingTotal');
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
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : [];
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tập hợp Container lưu bãi";

        $this->load->view('header', $this->data);
        $this->load->view('credit/cont_stacking_total', $this->data);
        $this->load->view('footer');
    }

    public function creContPlugTotal()
    {
        $access = $this->user->access('creContPlugTotal');
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

            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }

            if( $act == "load_opr" ){
                $this->data['oprs'] = $this->mdlcre->getOpr();
                echo json_encode($this->data);
                exit;
            }

            if( $act == 'search_ship' ){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdlcre->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_data'){
                $args = $this->input->post('args') ? $this->input->post('args') : [];
                $out = $this->mdlcre->loadPlugTotal( $args );
                $this->data['results'] = $out;
                echo json_encode($this->data);
                exit;
            }

            if( $act == 'load_payment' ){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $invTemp = $this->input->post('invTemp') ? $this->input->post('invTemp') : '';

                if( $cusID == '' ){
                    array_push( $this->data["no_payer"], "Vui lòng chọn lại đối tượng thanh toán!");
                    json_encode( $this->data );
                    exit;
                }

                $totalPluginHour = 0;
                $seq = 1;
                $this->data["error_plugin"] = array();

                foreach ( $list as $key => $value )
                {
                    // get plugin from
                    $pluginInRF_ONOFF = $this->funcs->dbDateTime( $value["DatePlugIn"] );

                    if( $pluginInRF_ONOFF == '' ){
                        //không thể lấy được ngày cắm điện của cont này => unset $list để k phải tính tiền cont điện lạnh này
                        unset( $list[$key] );

                        array_push( $this->data["error_plugin"] , "Container [".$value["CntrNo"]."] - không có thời gian cắm điện!");
                        continue;
                    }

                    $pluginFrom = strtotime( $pluginInRF_ONOFF );

                    //get plugin to
                    $pluginTo = strtotime( $this->funcs->dbDateTime( $value["DatePlugOut"] ) );

                    if( $pluginFrom > $pluginTo ){
                        //thời gian tính tiền cắm điện không hợp lý
                        unset( $list[$key] );

                        array_push( $this->data["error_plugin"] , "Container [".$value["CntrNo"]."] - Hạn điện phải lớn hơn (>) thời gian cắm điện!");
                        continue;
                    }

                    $plHour = $this->calcTimePlugin( $value["OprID"], $pluginFrom, $pluginTo );
                    if( !$plHour ){
                        //không có cấu hình
                        unset( $list[$key] );
                        array_push( $this->data["error_plugin"] , "Hãng khai thác [".$value["OprID"]."] chưa được cấu hình tính điện lạnh!");
                        continue;
                    }

                    $totalPluginHour += $plHour; //round( ( $pluginTo - $pluginFrom ) / ( 60 * 60 ) ); 
                    
                    $list[$key]["PTI_Hour"] = "0";
                    $list[$key]["DMethod_CD"] = NULL;

                    $strNote = sprintf("Điện lạnh container <b>%s</b><br><br>Từ <b>%s</b> - đến <b>%s</b><br>Tổng thời gian: <b>%s</b> giờ"
                                                        , $value["CntrNo"]
                                                        , $this->funcs->clientDateTime( $pluginInRF_ONOFF )
                                                        , $value["DatePlugOut"]
                                                        , $plHour );

                    $this->data["ps_notify"] = isset( $this->data["ps_notify"] ) 
                                                ? $this->data["ps_notify"]."<br/><hr/>".$strNote
                                                : $strNote;
                    
                    $list[$key]["EIR_SEQ"] = $seq++;
                }

                $this->calculate_payment( $list, $cusID, $invTemp, array( "Quantity" => array( "SDD" => $totalPluginHour ) ) );
                exit;
            }
        }

        if($action == "save") {
            $args = $this->input->post('args') ? $this->input->post('args') : [];
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == 'use_manual_Inv' ){
                $useInvData = $this->input->post('useInvData') ? $this->input->post('useInvData') : array();

                if( count( $useInvData ) > 0 ){
                    $useInvData['serial'] = trim( $useInvData['serial'] );
                    $useInvData['invno'] = trim( $useInvData['invno'] );

                    $checkInvNo = $this->mdltask->checkInvNo( $useInvData['serial'], $useInvData['invno'] );

                    if( $checkInvNo ){
                        $this->data["isDup"] = true;
                        echo json_encode( $this->data );
                        exit;
                    }

                    $this->session->set_userdata("invInfo", json_encode( $useInvData ));
                }

                echo true;
                exit;
            }

            if( ( $this->session->userdata("invInfo") === null || count( json_decode($this->session->userdata("invInfo"), true) ) == 0 ) 
                        && isset( $data["pubType"] ) && $data["pubType"] == "m-inv" ){
                $this->data["non_invInfo"] = "Chưa cấu hình hóa đơn!";
                echo json_encode( $this->data );
                exit();
            }

            $manualInvInfo = json_decode($this->session->userdata("invInfo"), true);
            $checkInvNo = $this->mdltask->checkInvNo( $manualInvInfo['serial'], $manualInvInfo['invno'] );

            if( $checkInvNo ){
                $this->data["isDup"] = true;
                echo json_encode( $this->data );
                exit();
            }

            $outInfo = [];
            $this->data['message'] = $this->mdlcre->save_draft_invoice( 'RF_ONOFF', $args, $outInfo );
            
            if( isset( $args['invInfo'] ) )
            {
                $this->data['invInfo'] = $args['invInfo'];
            }else{
                if( isset( $args["pubType"] ) ){
                    if( $args["pubType"] == "m-inv" )
                    {
                        $this->data['invInfo'] = $data['invInfo'] = $outInfo[0];
                        $outInfo = [];
                    }
                    else if( $args["pubType"] == "dft" )
                    {
                        $this->data['dftInfo'] = $outInfo;
                    }
                }
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tập hợp điện lạnh";

        $this->load->view('header', $this->data);

        $this->data['class'] = $this->mdlcre->getCntrClass();
        $this->data['invTemps'] = $this->mdlcre->getInvTemp();

        $ssInvInfo = json_decode($this->session->userdata("invInfo"), true);

        $this->data["ssInvInfo"] = $ssInvInfo;
        $this->data["isDup"] = $this->mdltask->checkInvNo( $ssInvInfo['serial'], $ssInvInfo['invno'] );

        $this->load->view('credit/plug_total', $this->data);
        $this->load->view('footer');
    }

    public function creShipService()
    {
        $this->show_developing();
        return;

        $access = $this->user->access('creShipService');
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
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : [];
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Dịch vụ tàu";

        $this->load->view('header', $this->data);
        $this->load->view('credit/ship_service', $this->data);
        $this->load->view('footer');
    }

    public function creConfirmPayment()
    {
        $access = $this->user->access('creConfirmPayment');
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
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : [];
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : [];
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Xác nhận thanh toán";

        $this->load->view('header', $this->data);
        $this->load->view('task/ship_total', $this->data);
        $this->load->view('footer');
    }

    public function payment_success()
    {
        if( !isset( $_SERVER['HTTP_REFERER'] ) )
        {
            redirect(md5('home'));
        }

        $invInfo = $this->input->post('invInfo') ? (array)json_decode($this->input->post('invInfo'), true) : []; //$this->data['invInfo']

        $pinCode = '';
        if( count( $invInfo ) > 0 )
        {
            $pinCode = $invInfo["fkey"];
            $this->data['invInfo'] = $invInfo;
        }else{
            redirect(md5('home'));
        }

        if( $pinCode == '' ){
            $this->data['error'] = "Phát sinh sự cố !";
        }
        
        $pngAbsoluteFilePath = FCPATH."assets/img/qrcode_gen/".$pinCode.".png";

        if( file_exists( $pngAbsoluteFilePath ) ){
            $qrCodeData = base64_encode( file_get_contents( $pngAbsoluteFilePath ) );
            $this->data['qr'] = 'data: '.mime_content_type( $pngAbsoluteFilePath ).';base64,'.$qrCodeData;
        }else{
            $this->funcs->generateQRCode( $pinCode );
            $qrCodeData = base64_encode( file_get_contents( $pngAbsoluteFilePath ) );
            $this->data['qr'] = 'data: '.mime_content_type( $pngAbsoluteFilePath ).';base64,'.$qrCodeData;
        }

        $this->data['title'] = "Giao dịch thành công!";

        $this->data['menus'] = $this->menu->getMenu();
        $this->load->view('header', $this->data);
        $this->load->view('credit/payment_success', $this->data);
        $this->load->view('footer');
    }

    public function draft_success()
    {
        if( !isset( $_SERVER['HTTP_REFERER'] ) )
        {
            redirect(md5('home'));
        }

        $dftInfo = $this->input->post('dftInfo') ? (array)json_decode($this->input->post('dftInfo'), true) : [];

        if( count( $dftInfo ) > 0 )
        {
            $this->data['dftInfo'] = $dftInfo;
        }else{
            redirect(md5('home'));
        }

        $results = [];
        $pinCode = $dftInfo[0]["PinCode"];

        $pngAbsoluteFilePath = FCPATH."assets/img/qrcode_gen/".$pinCode.".png";

        if( file_exists( $pngAbsoluteFilePath ) ){
            $qrCodeData = base64_encode( file_get_contents( $pngAbsoluteFilePath ) );
            $qr = 'data: '.mime_content_type( $pngAbsoluteFilePath ).';base64,'.$qrCodeData;
        }else{
            $this->funcs->generateQRCode( $pinCode );
            $qrCodeData = base64_encode( file_get_contents( $pngAbsoluteFilePath ) );
            $qr = 'data: '.mime_content_type( $pngAbsoluteFilePath ).';base64,'.$qrCodeData;
        }

        $this->data["qr"] = $qr;
        $this->data["pinCode"] = $pinCode;
        $this->data["draftNos"] = array_column( $dftInfo, "DRAFT_NO" );

        $this->data['title'] = "Giao dịch thành công!";

        $this->data['menus'] = $this->menu->getMenu();
        $this->load->view('header', $this->data);
        $this->load->view('credit/draft_success', $this->data);
        $this->load->view('footer');
    }

    private function getContSize($sztype){
        switch(substr($sztype,0,1)){
            case "2":
                return 20;
            case "4":
                return 40;
            case "L":
            case "M":
            case "9":
                return 45;
        }
        return "0";
    }

    private function calculate_payment( $list, $cusID, $invTemp, $addInfo = [] ){
        
        $trf_stds = $this->mdlcre->loadTariffSTD( $list, $invTemp );

        if(count($trf_stds) == 0) {
            $this->data['results'] = [];
            echo json_encode($this->data);
            return;
        }

        $newarray = [];
        $calc_arr = [];
        $sumAMT = 0; $sumVAT_AMT = 0; $sumSub_AMT = 0; $sumDIS_AMT = 0;

        $err = [];
        foreach ( $trf_stds as $key => $val ) {
            if( !is_array( $val ) ){
                array_push($err, $val);
                continue;
            }

            $newKey = $val['ISO_SZTP']."-".$val["FE"]."-".$val["CARGO_TYPE"]."-".$val["IsLocal"];

            $newarray[$newKey][$key] = $val;
        }

        foreach($newarray as $newkey => $newitem){
            $cont_count_in_tariff = count($newitem);
            foreach ($newitem as $ka=>$kv) {
                $check_continue = false;
                if(count($calc_arr) > 0 ){
                    foreach ($calc_arr as $idx => $tr) {
                        $prefix_compare = $tr['ISO_SZTP']."-".$tr['FE']."-".$tr['Cargotype']."-".$tr['IsLocal'];

                        if( $kv['TRF_CODE'] == $tr['TariffCode'] && $newkey == $prefix_compare ){
                            $check_continue = true;
                            continue;
                        }
                    }
                }

                if($check_continue) continue;

                $cont_ISO_SIZE = $this->getContSize(explode( "-" ,$newkey)[0]);

                $rs = array(
                    'DraftInvoice'=>'',
                    // 'OrderNo'=> $kv['OrderNo'],
                    'TariffCode'=>$kv['TRF_CODE'],
                    'TariffDescription'=>$kv['TRF_STD_DESC'],
                    'Unit'=> '',
                    'JobMode'=>$kv['JOB_KIND'],
                    'DeliveryMethod'=>$kv['DMETHOD_CD'],
                    'Cargotype'=>$kv['CARGO_TYPE'],
                    'ISO_SZTP'=>$kv['ISO_SZTP'],
                    'FE'=>$kv['FE'],
                    'IsLocal'=>$kv['IsLocal'],
                    'Quantity'=> 0,
                    'StandardTariff'=> $kv['AMT_'.$kv['FE'].$cont_ISO_SIZE],
                    'DiscountTariff'=> 0,
                    'DiscountedTariff'=>0,
                    'Amount'=> 0,
                    'VatRate'=>$kv['VAT'],
                    'VATAmount'=>0,
                    'SubAmount'=>0,
                    'Currency'=>$kv['CURRENCYID'],
                    'SIZE' => $cont_ISO_SIZE,
                    'CNTR_JOB_TYPE' => $kv['CJMode_CD'],
                    'IX_CD' => $kv['IX_CD'],
                    'VAT_CHK' => $kv['INCLUDE_VAT']
                );

                // if( $rs["Currency"] === "USD" ){
                //     $rate = $this->mdltask->getExchangeRate( "USD" );
                //     $rs["StandardTariff"] = $rs["StandardTariff"]*$rate;
                //     $rs["Currency"] = "VND";
                // }

                $rs['Unit'] = $this->mdltask->getTRF_unitCode( $kv['TRF_CODE'] );

                if( isset( $addInfo["Quantity"][ $kv["CJMode_CD"] ] ) ){
                    $rs["Quantity"] = $addInfo["Quantity"][ $kv["CJMode_CD"] ];
                }else{
                    $rs['Quantity'] = $cont_count_in_tariff;
                }

                //get discount for tariff
                $wheres = array(
                    $this->funcs->dbDateTime($kv['IssueDate']),
                    $this->funcs->dbDateTime($kv['IssueDate']),
                    $this->funcs->dbDateTime($kv['IssueDate']),
                    $kv['TRF_CODE'],
                    $kv['OprID'],
                    $cusID,
                    $kv['CARGO_TYPE'],
                    $kv['IX_CD'],
                    $kv['DMETHOD_CD'],
                    $kv['JOB_KIND'],
                    $kv['CNTR_JOB_TYPE'],
                    $kv['CURRENCYID'],
                    $kv['IsLocal'],
                );

                $rs['DiscountTariff'] = ($rs['Quantity'] === null || $rs['Quantity'] == 0) 
                                        ? 0 : $this->mdltask->getDiscount($cont_ISO_SIZE, $rs['FE'], $wheres);

                $rs['DiscountedTariff'] = $kv['INCLUDE_VAT'] === "1" 
                                            ? ($rs['StandardTariff'] + $rs['DiscountTariff'])/(((int)$kv['VAT']/100)+1)
                                            : ($rs['StandardTariff'] + $rs['DiscountTariff']);

                $rs['Amount'] = ($rs['Quantity'] * $rs['DiscountedTariff']);
                $rs['VATAmount'] = ($rs['Amount'] * ($rs['VatRate']/100));
                $rs['SubAmount'] = ($rs['Amount'] + $rs['VATAmount']);

                $sumAMT += $rs['Amount'];
                $sumVAT_AMT += $rs['VATAmount'];
                $sumSub_AMT += $rs['SubAmount'];

                $sumDIS_AMT += $rs['DiscountTariff'];

                array_push($calc_arr, $rs);
            }
        }

        if(count($err) > 0){
            $this->data['error'] = $err;
        }

        $this->data['results'] = $calc_arr;
        $this->data['SUM_AMT'] = $sumAMT;
        $this->data['SUM_VAT_AMT'] = $sumVAT_AMT;
        $this->data['SUM_SUB_AMT'] = $sumSub_AMT;
        $this->data['SUM_DIS_AMT'] = $sumDIS_AMT;

        echo json_encode($this->data);
        //exit;
    }

    private function calcTimePlugin( $oprID, $plugFrom, $plugTo )
    {
        $rounding = $this->mdlcommon->getPlugConfig( $oprID );
        if( $rounding == NULL ){ 
            return false;
        }

        $minutes = round(( $plugTo - $plugFrom )/60);
        
        $hr = round($minutes / 60);
        $minute = $minutes % 60;

        $extraHour = 0;
        switch ($rounding) {
            case 'R1':
                $extraHour = $minute <= 30 ? 0.5 : 1;
                break;
            case 'R2':
                $extraHour = $minute > 0 ? 1 : 0;
                break;
        }
        
        return $hr + $extraHour;
    }
}
