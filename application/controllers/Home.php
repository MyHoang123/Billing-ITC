<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("user_model", "mdlUsers");
        $this->load->model("common_model", "mdlCommon");

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

    public function index()
    {
        $this->data['title'] = "Billing";
//        $this->data['title'] = "Tracking";

        $this->data['count'] = 0;
        $opt = $this->input->post('opt') ? $this->input->post('opt') : '';
        $checkval = $this->input->post('checkval') ? $this->input->post('checkval') : '';
        if($opt == "cont") {
            $results = array();
            if (preg_match('/^[a-zA-Z]{4}[0-9]{7}$/', $checkval)) {
                $results = $this->mdlCommon->tracking('CntrNo', $checkval);
            }
            $this->data['results'] = $results;
            echo json_encode($this->data);
            exit;
        }

        if($opt == "bill") {
            $this->data['results'] = $this->mdlCommon->tracking('BLNo', $checkval);
            echo json_encode($this->data);
            exit;
        }

        if($opt == "booking") {
            $this->data['results'] = $this->mdlCommon->tracking('BookingNo', $checkval);
            echo json_encode($this->data);
            exit;
        }

        $this->data['menus'] = $this->menu->getMenu();
        $this->load->view('header', $this->data);
        $this->load->view('tracking', $this->data);
        $this->load->view('footer');
    }
}
