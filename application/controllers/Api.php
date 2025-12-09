<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();
        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("user_model", "user");
        $this->data['menus'] = $this->menu->getMenu();
        // $this->data['parentMenuList'] = $this->menu->getParentMenu();
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
                if($method == md5($smethod)) {
                    $this->$smethod();
                    break;
                }
            }
        }

        if(!in_array($method, $a_methods)) {
            show_404();
        }
    }

    public function tHIS_API() {
        $action = $this->input->post('iAction') ? $this->input->post('iAction') : '';
        $this->load->model('Api_model', "mAPI");
        switch($action){
            case "loadData":
                $formData = $this->input->post('DATA_FORM') ? $this->input->post('DATA_FORM') : array();
                $searchTable = $this->input->post('searchTable') ? $this->input->post('searchTable') : '';
				if ($searchTable == "MNR_API") {
					$data_ret = $this->mAPI->checkMNR_API_loadData($formData);
				}
				else {
					$data_ret = $this->mAPI->checkHIS_API_loadData($formData);
				}
                // $data_ret = $this->mAPI->checkHIS_API_loadData($formData);
                echo json_encode($data_ret);
                exit();
                break;
            case "saveDATA":
                $rowguid = $this->input->post('rowguid') ? $this->input->post('rowguid') : array();
                $data_ret = $this->mAPI->checkHIS_API_saveData($rowguid);
                echo json_encode($data_ret);
                exit();
                break;
            default: break;
        };
        $this->data['title'] = "LỊCH SỬ GỬI LẠI API VTOS";
        $this->load->view('header', $this->data);   
        $this->load->view('api/checkHIS_API', $this->data);
        $this->load->view('footer');
    }
} 