<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MnPayment extends CI_Controller
{

    public $data;
    private $ceh;
    public $session;
    public $load;
    public $menu;

    function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
        $this->load->model("MBBank_model", "mb");
        $this->data['menus'] = $this->menu->getMenu();
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
                if ($method == md5($smethod)) {
                    $this->$smethod();
                    break;
                }
            }
        }
    }
      public function poMbbank()
    {
        $this->data['title'] = 'Quản lý QR thanh toán';
        $this->load->view('header', $this->data);  
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action === 'fetch_page') {
                $page = $this->input->post('page') ? $this->input->post('page') : 1;
                $resuilt = $this->mb->getListQrPayment($page);
                echo json_encode(array(
                    'status' => 'success',
                    'data' => $resuilt['data'],
                    'totalPages' => $resuilt['total_rows'],
                ));
            exit;
        }
        elseif($action === 'detail-eir') {
            $eir = $this->input->post('eir') ? $this->input->post('eir') : null;
            if(!$eir) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'EIR is required.'
                ));
                exit;
            }
            $Invs_Draft = $this->mb->getInv($eir) ?: $this->mb->getInvSrv($eir) ?: $this->mb->getInvFromDraft($eir);
            if(!empty($Invs_Draft)) {
                    $DFTS = [];
                    $Draft_Inv = $this->mb->getDraftFromInv($Invs_Draft[0]['InvNo']);
                    foreach($Draft_Inv as $key => $value) {
                        $draftNo = $value['DRAFT_INV_NO'] ?? null;
                        if ($draftNo && !in_array($draftNo, $DFTS)) {
                            $DFTS[] = $draftNo; // chỉ thêm nếu chưa có
                        }
                    }
                    if (!empty($DFTS)) {
                        $resuilt = $this->mb->getDraftInvDetail($DFTS);
                        echo json_encode(array(
                            'success' => true,
                            'data' => $resuilt,
                            ));
                    }
                    else {
                            echo json_encode(array(
                            'success' => false,
                            'message' => 'Dữ liệu đầu vào không hợp lệ',
                            ));
                    }
                    exit;
            }
            else {
                    echo json_encode(array(
                            'success' => false,
                            'message' => 'Không tìm thấy dữ liệu',
                            ));
                exit;
            }
        }
        $resuilt = $this->mb->getListQrPayment();
        $this->data['litspayment'] = $resuilt['data'];
        $this->data['allItem'] = $resuilt['total_rows'];
        $this->load->view('MnPayment/poMbbank', $this->data);
        $this->load->view('footer');
    }
     public function rpMbbank()
    {
        $this->data['title'] = 'Báo cáo doanh thu';
        $this->load->view('header', $this->data);  

        if($action === 'view') {
                // $page = $this->input->post('page') ? $this->input->post('page') : 1;
                // $resuilt = $this->mb->getListQrPayment($page);
                echo json_encode(array(
                    'status' => 'success',
                    'data' => '123',
                    'totalPages' => '123'
                ));
            exit;
        }
        elseif($action === 'detail-eir') {
            $eir = $this->input->post('eir') ? $this->input->post('eir') : null;
            if(!$eir) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'EIR is required.'
                ));
                exit;
            }
            $Invs_Draft = $this->mb->getInv($eir) ?: $this->mb->getInvSrv($eir) ?: $this->mb->getInvFromDraft($eir);
            if(!empty($Invs_Draft)) {
                    $DFTS = [];
                    $Draft_Inv = $this->mb->getDraftFromInv($Invs_Draft[0]['InvNo']);
                    foreach($Draft_Inv as $key => $value) {
                        $draftNo = $value['DRAFT_INV_NO'] ?? null;
                        if ($draftNo && !in_array($draftNo, $DFTS)) {
                            $DFTS[] = $draftNo; // chỉ thêm nếu chưa có
                        }
                    }
                    if (!empty($DFTS)) {
                        $resuilt = $this->mb->getDraftInvDetail($DFTS);
                        echo json_encode(array(
                            'success' => true,
                            'data' => $resuilt,
                            ));
                    }
                    else {
                            echo json_encode(array(
                            'success' => false,
                            'message' => 'Dữ liệu đầu vào không hợp lệ',
                            ));
                    }
                    exit;
            }
            else {
                    echo json_encode(array(
                            'success' => false,
                            'message' => 'Không tìm thấy dữ liệu',
                            ));
                exit;
            }
        }
        $this->load->view('MnPayment/DashBoard', $this->data);

        $this->load->view('footer');
    }
    public function rpMbbankApi(){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
          if($data['action'] === 'view') {
            if($data['act'] === 'loadData') {
                $result = $this->mb->getStatisticMbbank();
                if(!empty($result)) {
                    echo json_encode(array(
                        'status' => true,
                        'data' =>  $result,
                    ));
                    exit;
                }
                else {
                    echo json_encode(array(
                        'status' => false,
                    ));
                exit;
                }
            }
            else if($data['act'] === 'loadHis') {
                $result = $this->mb->getHistoryPayment($data['Id']);
                  if(!empty($result)) {
                    echo json_encode(array(
                        'status' => true,
                        'data' =>  $result,
                    ));
                    exit;
                }
                else {
                    echo json_encode(array(
                        'status' => false,
                    ));
                exit;
                }
            }
        }
    }
}
