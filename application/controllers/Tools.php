<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {

    public $data;
    private $ceh;
	private $curlSync = "http://syncvls.sp-itc.com.vn/";

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("invoice_model", "mdlInv");
        $this->load->model("task_model", "mdltask");
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

    public function tlCancelEntries()
    {
        $access = $this->user->access('tlCancelEntries');
        if ($access === false) {
            show_404();
        }

        if (strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = "Hủy hoá đơn - phiếu tính cước";

        if ($action == 'view') {
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if ($act == 'load_payer') {
                $this->data['payers'] = $this->mdlInv->getPayers();
                echo json_encode($this->data);
                exit;
            }

            if ($act == "search_inv") {
                $fromDate = $this->input->post('fromDate') ? $this->funcs->dbDateTime($this->input->post('fromDate', TRUE)) : '';
                $toDate = $this->input->post('toDate') ? $this->funcs->dbDateTime($this->input->post('toDate', TRUE)) : '';
                $tyeOfDate = $this->input->post('typeOfDate') ? $this->input->post('typeOfDate', TRUE) : '';
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID', TRUE) : '';
                $searchVal = $this->input->post('searchVal') ? $this->input->post('searchVal', TRUE) : '';
                $paymentStatus = $this->input->post('paymentStatus') ? $this->input->post('paymentStatus') : array();
                $paymentType = $this->input->post('paymentType') ? $this->input->post('paymentType') : array();
                $sys = $this->input->post('sys') ? $this->input->post('sys') : '';

                $operator = $sys == "VSL" ? "=" : "!=";

                if ($tyeOfDate == "PTC") {
                    $args = array(
                        "searchVal" => $searchVal,
                        "dft.PAYER" => $cusID,
                        "dft.PAYMENT_STATUS" => $paymentStatus,
                        "dft.INV_TYPE" => $paymentType,
                        "DRAFT_INV_DATE >=" => $fromDate,
                        "DRAFT_INV_DATE <=" => $toDate,
                        "LEFT(dft.DRAFT_INV_NO,2) " . $operator => 'TT',
                        // "LEFT(iv.PinCode,1) " . $operator => 'A'
                    );

                    $this->data["invs"] = $this->mdlInv->loadDraftForCancel($args);
                } else {
                    $args = array(
                        "searchVal" => $searchVal,
                        "iv.PAYER" => $cusID,
                        "iv.PAYMENT_STATUS" => $paymentStatus,
                        "iv.INV_TYPE" => $paymentType,
                        "INV_DATE >=" => $fromDate,
                        "INV_DATE <=" => $toDate,
                        "LEFT(dft.DRAFT_INV_NO,2) " . $operator => 'TT',
                        // "LEFT(iv.PinCode,1) " . $operator => 'A'
                        "sys" => $sys
                    );

                    $this->data["invs"] = $this->mdlInv->loadInvForCancel($args);
                }

                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit') {
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if ($act == "cancelLocalInv") {

                $invNo = $this->input->post('invNo', TRUE) ? $this->input->post('invNo', TRUE) : '';
                $draftNo = $this->input->post('draftNo', TRUE) ? $this->input->post('draftNo', TRUE) : '';
                $cancelReason = $this->input->post('cancelReason', TRUE) ? $this->input->post('cancelReason', TRUE) : '';
                $isRemoveOrder = $this->input->post('removeOrder', TRUE) ? $this->input->post('removeOrder', TRUE) : '0';

                $outputMsg = '';
//die($isRemoveOrder.'?'.'!'.$draftNo);
                $isSuccessCancelInv = $this->mdlInv->cancelLocalInv($invNo, $cancelReason, $outputMsg);

                if (!$isSuccessCancelInv) {
                    $this->data["error"] = $outputMsg;
                    echo json_encode($this->data);
                    exit();
                }

                if ($draftNo != '' && $isSuccessCancelInv) {

                    $isCancelDraft = $this->mdlInv->cancelDraft($draftNo, $cancelReason, $isRemoveOrder, $outputMsg);

                    if (!$isCancelDraft) {
                        $this->data["error"] = $outputMsg;
                        echo json_encode($this->data);
                        exit();
                    }
                }

                echo json_encode($this->data);
                exit();
            }

            if ($act == "cancelDraft") {
                $dftNo = $this->input->post('draftNo', TRUE) ? $this->input->post('draftNo', TRUE) : '';
                $reason = $this->input->post('cancelReason', TRUE) ? $this->input->post('cancelReason', TRUE) : '';
                $isRemoveOrder = $this->input->post('removeOrder', TRUE) ? $this->input->post('removeOrder', TRUE) : '0';

                $outmsg = '';
                $isCancelDraft = $this->mdlInv->cancelDraft($dftNo, $reason, $isRemoveOrder, $outmsg);

                if (!$isCancelDraft) {
                    $this->data["error"] = $outmsg;
                }

                echo json_encode($this->data);
                exit();
            }

            echo json_encode($this->data);
            exit;
        }

        $this->load->view('header', $this->data);
        $this->load->view('tools/entries_cancel', $this->data);
        $this->load->view('footer');
    }

    public function tlReprint()
    {
        $access = $this->user->access('tlReprint');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = "In lại chứng từ";

        if( $action == 'view' )
        {
            $ordNo = $this->input->post('ordNo') ? $this->input->post('ordNo') : '';
            $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
            $pinCode = $this->input->post('pinCode') ? $this->input->post('pinCode') : '';
            $invNo = $this->input->post('invNo') ? $this->input->post('invNo') : '';
            $ordType = $this->input->post('ordType') ? $this->input->post('ordType') : '';
            
            $w = array(
                "PinCode" => $pinCode,
                "OrderNo" => $ordNo,
                "CntrNo" => $cntrNo,
                "InvNo" => $invNo,
                "OrderType" => $ordType
            );

            $this->load->model("task_model");
            $this->data["list"] = $this->task_model->getOrder4RePrint( $w );
            echo json_encode($this->data);
            exit;
        }

        $this->load->view('header', $this->data);
        $this->load->view('tools/reprint', $this->data);
        $this->load->view('footer');
    }

    public function tlManualInvoice()
    {
        $access = $this->user->access('tlManualInvoice');
        if ($access === false) {
            show_404();
        }

        if (strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->load->model("task_model", "mdltask");
        $this->load->model("Credit_model", "mdlcre");

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if ($action == "view") {
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if ($act == 'load_payer') {
                $this->data['payers'] = $this->mdltask->getPayers();
                echo json_encode($this->data);
                exit;
            }

            if ($act == 'search_ship') {
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            if ($act == 'load_tariff') {
                $invTemp = $this->input->post('invTemp') ? $this->input->post('invTemp') : '';
                $this->data['results'] = $this->mdltask->loadTariffByTemplate($invTemp);
                echo json_encode($this->data);
                exit;
            }
        }

    if ($action == "save") {
            $args = $this->input->post('args') ? $this->input->post('args') : [];
            $act = $this->input->post('act') ? $this->input->post('act') : '';
             if($act == "save_qr_payment") {
                $InvDraftNo = $this->input->post('draftNo') ? $this->input->post('draftNo') : null;
                $invInfo = $this->input->post('invInfo') ? $this->input->post('invInfo') : [];
                if($InvDraftNo == null) {
                    $this->data['error'] = "Chưa có số phiếu tính cước!";
                    echo json_encode($this->data);
                    exit;
                }
                $args = [];
                $args['pubType'] = 'e-inv';
                $args['draft_total'] = $this->mdlInv->getInvDraft($InvDraftNo)[0];
                $args['draft_detail'] = $this->mdlInv->getInvDTLDraft($InvDraftNo);
                if(count($invInfo) > 0) {
                    $args['invInfo'] = $invInfo;
                }
                $outInfo = [];
                $mailTo = null;
                $args['DraftNo'] = $InvDraftNo; 
                if(empty($args['draft_total'])) {
                    $this->data['error'] = "Không tìm thấy hóa đơn tay!";
                    echo json_encode($this->data);
                    exit;
                }
                $this->data['message'] = $this->mdlInv->saveDraft_MANUAL($args, $outInfo, 'qr', $mailTo);
                if (isset($args['invInfo'])) {
                    $this->data['invInfo'] = $args['invInfo'];
                } else {
                    if (isset($args["pubType"])) {
                        if ($args["pubType"] == "m-inv") {
                            $this->data['invInfo'] = $data['invInfo'] = $outInfo;
                            $outInfo = [];
                        } else if ($args["pubType"] == "dft") {
                            $this->data['dftInfo'] = $outInfo;
                        }
                    }
                }
                // /create data for send mail
                if ($mailTo != null && $args['pubType'] == 'e-inv' && count($args['invInfo']) > 0) {
                    $pinCode = (isset($args['invInfo']['fkey']) ? $args['invInfo']['fkey'] : "");
                    if ($pinCode != '') {
                        $itemMail = array(
                            "mailTo" => str_replace(';', ',', $mailTo)
                        );

                        if (isset($args['invInfo']) && count($args['invInfo']) > 0) {
                            $itemMail["inv"] = $args['invInfo']['serial'] . substr("0000000" . $args['invInfo']['invno'], -7);
                        }

                        $itemMail["pinCode"] = $pinCode;
                        $this->funcs->generateQRCode($pinCode);

                        // log_message( "error", $this->sendmail( $itemMail ));m
                        $this->sendmail($itemMail);
                    }
                }

                echo json_encode($this->data);
                exit;
            }
            if ($act == 'use_manual_Inv') {
                $useInvData = $this->input->post('useInvData') ? $this->input->post('useInvData') : array();

                if (count($useInvData) > 0) {
                    $useInvData['serial'] = trim($useInvData['serial']);
                    $useInvData['invno'] = trim($useInvData['invno']);

                    $checkInvNo = $this->mdltask->checkInvNo($useInvData['serial'], $useInvData['invno']);

                    if ($checkInvNo) {
                        $this->data["isDup"] = true;
                        echo json_encode($this->data);
                        exit;
                    }

                    $this->session->set_userdata("invInfo", json_encode($useInvData));
                }

                echo true;
                exit;
            }

            if (($this->session->userdata("invInfo") === null || count(json_decode($this->session->userdata("invInfo"), true)) == 0)
                && isset($data["pubType"]) && $data["pubType"] == "m-inv"
            ) {
                $this->data["non_invInfo"] = "Chưa cấu hình hóa đơn!";
                echo json_encode($this->data);
                exit();
            }

            $manualInvInfo = json_decode($this->session->userdata("invInfo"), true);
            $checkInvNo = $this->mdltask->checkInvNo($manualInvInfo['serial'], $manualInvInfo['invno']);

            if ($checkInvNo) {
                $this->data["isDup"] = true;
                echo json_encode($this->data);
                exit();
            }

            $outInfo = [];
            $this->data['message'] = $this->mdlInv->saveDraft_MANUAL($args, $outInfo);

            if (isset($args['invInfo'])) {
                $this->data['invInfo'] = $args['invInfo'];
            } else {
                if (isset($args["pubType"])) {
                    if ($args["pubType"] == "m-inv") {
                        $this->data['invInfo'] = $data['invInfo'] = $outInfo;
                        $outInfo = [];
                    } else if ($args["pubType"] == "dft") {
                        $this->data['dftInfo'] = $outInfo;
                    }
                }
            }

            // /create data for send mail
            $mailTo = $this->input->post('mailTo') ? $this->input->post('mailTo') : '';

            if ($mailTo != '' && $args['pubType'] == 'e-inv' && count($args['invInfo']) > 0) {
                $pinCode = (isset($args['invInfo']['fkey']) ? $args['invInfo']['fkey'] : "");
                if ($pinCode != '') {
                    $itemMail = array(
                        "mailTo" => str_replace(';', ',', $mailTo)
                    );

                    if (isset($args['invInfo']) && count($args['invInfo']) > 0) {
                        $itemMail["inv"] = $args['invInfo']['serial'] . substr("0000000" . $args['invInfo']['invno'], -7);
                    }

                    $itemMail["pinCode"] = $pinCode;
                    $this->funcs->generateQRCode($pinCode);

                    // log_message( "error", $this->sendmail( $itemMail ));m
                    $this->sendmail($itemMail);
                }
            }

            echo json_encode($this->data);
            exit;
        }
        if($action == "save_draft") {
            $args = $this->input->post('args') ? $this->input->post('args') : [];
            $this->data['DraftNoInDB'] = $this->mdlInv->saveDraft_MANUAL_DRAFT($args);
            echo json_encode($this->data);
            exit;
        }
        $this->data['title'] = "Tạo hoá đơn tay";

        $this->load->view('header', $this->data);

        $this->data['dmethods'] = $this->mdlcre->getDMethods();
        $this->data['transits'] = $this->mdlcre->getTransits();
        $this->data['invTemps'] = $this->mdlcre->getInvTemp();
        $this->data['cargoTypes'] = $this->mdltask->getCargoTypes();
        $this->data["cntrClass"] = $this->mdlInv->loadCntrClass();
        $ssInvInfo = json_decode($this->session->userdata("invInfo"), true);

        $this->data["ssInvInfo"] = $ssInvInfo;
        $this->data["isDup"] = false;
        
        // *lỗi: ssInvInfo là null thì không thể truy cập kiểu mảng.
        if ($ssInvInfo && isset($ssInvInfo['serial']) && isset($ssInvInfo['invno'])) {
            $this->data["isDup"] = $this->mdltask->checkInvNo($ssInvInfo['serial'], $ssInvInfo['invno']);
        }

        $this->load->view('tools/manual_inv', $this->data);
        $this->load->view('footer');
    }
	
	public function syncInvoice(){
        $access = $this->user->access('syncInvoice');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
		$this->load->model("tools_model", "tm");

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $todate = $this->input->post('todate') ? $this->input->post('todate') : '';
            $jmode = $this->input->post('jmode') ? $this->input->post('jmode') : '*';
            $paymentType = $this->input->post('paymentType') ? $this->input->post('paymentType') : '*';
            $currency = $this->input->post('currency') ? $this->input->post('currency') : '*';
			$sts = $this->input->post('sts') ? $this->input->post('sts') : '';

            $this->data['results'] = $this->tm->rptReleasedInv($fromdate, $todate, $jmode, $paymentType, $currency, $sts);
            echo json_encode($this->data);
            exit;
        }
		
		if($action == "reSync") {
			$hoadon = $this->input->post('hoadon') ? $this->input->post('hoadon') : null;
			
			$tmp = implode("','", $hoadon);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->curlSync . "index.php/be24e9507641df3922d139b399728128/d2067d5d1c5cecd9981b849e9db21621");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "inv=" . $tmp);

			// In real life you should use something like:
			// curl_setopt($ch, CURLOPT_POSTFIELDS, 
			//          http_build_query(array('postvar1' => 'value1')));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);

			curl_close ($ch);

			// Further processing ...
			if ($server_output == "OK") { 
				echo "1111";
				exit;
			} else { 
				echo '2222';
				exit;
			}
			
		}

        $this->data['title'] = "Đồng bộ hóa đơn đến VLS";

        $this->load->view('header', $this->data);
        $this->load->view('tools/syncInv', $this->data);
        $this->load->view('footer');
    }

	public function tlAdjustInvoice()
    {
        $access = $this->user->access('tlAdjustInvoice');
        if ($access === false) {
            show_404();
        }

        if (strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if ($action == "view") {
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if ($act == 'load_payer') {
                $this->data['payers'] = $this->mdltask->getPayers();
                echo json_encode($this->data);
                exit;
            }

            if ($act == 'search_ship') {
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }

            if ($act == 'load_data') {
                $args = $this->input->post('args') ? $this->input->post('args') : [];
                $result = $this->mdlInv->loadInvoiceForAdjust($args);
                $this->data['results'] = $result;
                echo json_encode($this->data);
                exit;
            }

            if ($act == 'load_tariff') {
                $invTemp = $this->input->post('invTemp') ? $this->input->post('invTemp') : '';
                $this->data['results'] = $this->mdltask->loadTariffByTemplate($invTemp);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == "save") {
            $args = $this->input->post('args') ? $this->input->post('args') : [];
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            //them moi hd thu sau
            $paymentType = $args['draft_total']['PAYMENT_TYPE'];
            $outInfo = [];
            $this->data['message'] = $this->mdlInv->saveDraft_MANUAL($args, $outInfo);

            if (isset($args['invInfo'])) {
                $this->data['invInfo'] = $args['invInfo'];
            } else {
                if (isset($args["pubType"])) {
                    if ($args["pubType"] == "m-inv") {
                        $outInfo['type'] = $paymentType; //them moi hd thu sau
                        $this->data['invInfo'] = $data['invInfo'] = $outInfo;
                        $outInfo = [];
                    } else if ($args["pubType"] == "dft") {
                        $this->data['dftInfo'] = $outInfo;
                    }
                }
            }

            // /create data for send mail
            $mailTo = $this->input->post('mailTo') ? $this->input->post('mailTo') : '';

            if ($mailTo != '' && $args['pubType'] == 'e-inv' && count($args['invInfo']) > 0) {
                $pinCode = (isset($args['invInfo']['fkey']) ? $args['invInfo']['fkey'] : "");
                if ($pinCode != '') {
                    $itemMail = array(
                        "mailTo" => str_replace(';', ',', $mailTo)
                    );

                    if (isset($args['invInfo']) && count($args['invInfo']) > 0) {
                        $itemMail["inv"] = $args['invInfo']['serial'] . substr("0000000" . $args['invInfo']['invno'], -7);
                    }

                    $itemMail["pinCode"] = $pinCode;
                    $this->funcs->generateQRCode($pinCode);

                    // log_message( "error", $this->sendmail( $itemMail ));m
                    $this->sendmail($itemMail);
                }
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Điều chỉnh / thay thế hóa đơn";

        $this->load->view('header', $this->data);

        // $inv_cre = $this->config->item('INV_CRE');
        $this->data['pattern_serials'] = [
            'CAS' => [
                'PATTERN' => $this->config->item('INV_PATTERN'),
                'SERIAL' => $this->config->item('INV_SERIAL')
            ]
            // 'CRE' => [
                // 'PATTERN' => $inv_cre['INV_PATTERN'],
                // 'SERIAL' => $inv_cre['INV_SERIAL']
            // ]
        ];

        $this->load->model("Credit_model", "mdlcre");
        $this->data['dmethods'] = $this->mdlcre->getDMethods();
        $this->data['transits'] = $this->mdlcre->getTransits();
        $this->data['invTemps'] = $this->mdlcre->getInvTemp();
        $this->data['cargoTypes'] = $this->mdltask->getCargoTypes();
        $this->data['paymentMethod'] = $this->mdlInv->getPaymentMethod();
        $this->data["cntrClass"] = $this->mdlInv->loadCntrClass();

        $ssInvInfo = json_decode($this->session->userdata("invInfo"), true);

        $this->data["ssInvInfo"] = $ssInvInfo;
        $this->data["isDup"] = false; //them moi hd thu sau

        $this->load->view('tools/adjust_inv', $this->data);
        $this->load->view('footer');
    }

    private function sendmail( $args )
    {
        $pinCode = $args["pinCode"];
        $orderNo = isset( $args["orderNo"] ) ? "<li>Số lệnh: <b>".$args["orderNo"]."</b></li>" : "";
        $amount = isset( $args["amount"] ) ? "<li>Số tiền: <b>".$args["amount"]."</b></li>" : "";

        if( isset( $args["inv"] ) ){
            $inv = $args["inv"];
            $invNo = substr( $inv, -7 );
            $invPrefix = substr( $inv, 0, strlen( $inv ) - 7 );

            $invContent = "<li>Ký hiệu hóa đơn: <b>".$invPrefix."</b></li><li>Số hóa đơn: <b>".$invNo."</b></li>";

            // $searchUrl = site_url( md5("InvoiceManagement") . '/' . md5("downloadInvPDF") ) . "?fkey=". $pinCode;
            $searchUrl = "eport.sp-itc.com.vn/index.php/" . md5("InvoiceManagement") . '/' . md5("downloadInvPDF") . ".xc?fkey=". $pinCode;

            $invButtonInquiry = '<a href="'.$searchUrl.'" style="font-family:Tahoma,serif;background-color:#3f00ff;color:#ffffff;font-weight:500;padding:10px 50px 10px 50px;border-radius:4px;border-style:none;text-decoration:none" target="_blank" >XEM HÓA ĐƠN</a>';
        }else{
            $invContent = "<li><b>THU SAU</b></li>";
            $invButtonInquiry = "";
        }

        $draftNo = isset( $args["draftNo"] ) ? "<li>Số phiếu tính cước: <b>".$args["draftNo"]."</b></li>" : "";
        $printOrderUrl = site_url( md5("ExportRPT") . '/' . md5("viewPDFOrderByList") ) . "?fkey=". $pinCode;

        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => $this->config->item('SYS_MAIL_HOST'),
            'smtp_port' => $this->config->item('SYS_MAIL_PORT'),
            'smtp_user' => $this->config->item('SYS_MAIL_ADDR'),
            'smtp_pass' => $this->config->item('SYS_MAIL_PASS'),
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'crlf' => "\r\n",
            'newline' => "\r\n",
            'mailtype'=>'html'
        );

        $this->email->initialize( $config );

        $this->email->clear(TRUE);

        $this->email->from( $config['smtp_user'], "SP-ITC Mail Center" );
        $this->email->to( $args["mailTo"] );
        $this->email->cc( 'fospitc@gmail.com' );
        $this->email->subject('[Thông báo] Thanh toán lệnh & phát hành hóa đơn điện tử!');

        $pngAbsoluteFilePath = FCPATH."assets/img/qrcode_gen/".$pinCode.".png";
        $embedQRCode = "";
        if( file_exists( $pngAbsoluteFilePath ) ){
            $this->email->attach($pngAbsoluteFilePath);

            $cid = $this->email->attachment_cid( $pngAbsoluteFilePath );

            if( $cid !== FALSE ){
                $embedQRCode = '<img style="width:95px;height:95px" src="cid:'.$cid.'" alt="'.$pinCode.'" />';
            }
        }

        $mailContent = <<<EOT
            <body>
                <div style="padding: 40px;">
                    <div style="background-color:#f10f0f;border-top-left-radius:4px;border-top-right-radius:4px;height:60px;padding-top:30px">
                        <span style="margin-top:20px;margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff">CTY CP VT & TM QUỐC TẾ (SP-ITC) thông báo Phát hành lệnh và Xuất hóa đơn điện tử</span>
                    </div>
                    <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
                        <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px">
                            <b>Kính gửi: Quý khách hàng</b>
                            <br>
                            <span>CTY CP VT & TM QUỐC TẾ (SP-ITC) xin gửi cho Quý khách hóa đơn điện tử với các thông tin như sau: </span>
                        </div>
                        <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                            <ul style="margin-left:25px;list-style:disc;">
                                $orderNo
                                $draftNo
                                <li>Mã tra cứu: <b>$pinCode</b></li>
                                $invContent
                                $amount
                            </ul>
                            <div style="margin:auto;padding-top:10px">
                                $embedQRCode
                            </div>
                        </div>

                        <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
                            <br>
                            <div style="display:inline-flex">
                                <a href="$printOrderUrl" style="margin-right:20px;font-family:Tahoma,serif;background-color:#ff9600;color:#ffffff;font-weight:500;padding:10px 50px 10px 50px;border-radius:4px;border-style:none;text-decoration:none" target="_blank" >TRA CỨU LỆNH</a>

                                $invButtonInquiry
                            </div>
                            <br><br>
                            <span>Link tra cứu hoá đơn: <a href="eport.sp-itc.com.vn" style="font-weight: bold;" target="_blank" >eport.sp-itc.com.vn</a></span>
                        </div>
                        <div style="padding:30px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
                            <span>Trân trọng!</span>
                            <br>
                            <span><b>CTY CP VT & TM QUỐC TẾ (SP-ITC)</b></span>
                        </div>
                    </div>
                </div>
            </body>
EOT;

        $this->email->message($mailContent);

        return $this->email->send() ? 'sent' : $this->email->print_debugger();
    }

}
