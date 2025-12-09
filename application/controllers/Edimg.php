<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edimg extends CI_Controller {

    private $data;

    function __construct() {
        parent::__construct();

        
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
	
	public function index() {
        
	}

	public function api_edi()
	{		
		$link = $this->input->post('linkfile') ? $this->input->post('linkfile') : '';
		
		if(preg_match('/home/', $link)) {
			$link = str_replace('/home', "", $link);
		}
		
		$tmp = explode('/', $link);

        // Đường dẫn trên server WEB EDO
		
		$content = file_get_contents($_FILES['edifiles']['tmp_name']);
		
		if(preg_match('/COREOR/', $content)) {
			$diretory = APPPATH . 'EDI/' . $tmp[1] . '/' . 'COREOR/';
		} elseif (preg_match('/COPARN/', $link)) {
			$diretory = APPPATH . 'EDI/' . $tmp[1] . '/' . 'COPARN/';
		} else {
			$diretory = APPPATH . 'EDI/' . $tmp[1] . '/' . 'OTHERS/';
		}
		
		
		
		$this->session->set_userdata(array("oprid" => $tmp[1]));
		
		$this->load->model('edimg_model', 'edi');
        
        // Nếu chưa có thư mục, thì PHP tự tạo
        if(!is_dir($diretory)){
            mkdir($diretory, 0755, true);
        }
		
		$config['upload_path']          = $diretory;
		$config['allowed_types']        = 'txt|edi|TXT|EDI|xls|xlsx';
		
		//log_message('error', $content);
		
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('edifiles'))
		{
			echo $this->upload->display_errors();
			exit;
		}
        
        $localFile = $this->upload->data('full_path');
		
        //$localFile = APPPATH . 'MAEU.VNSGNIT.COREOR.2.198474509673311219.edi';

        preg_match('/COREOR|COPARN/', $localFile, $action);

        if(!isset($action[0])) {
            exit;
        }

        switch($action[0]){
            case 'COREOR':
                $this->edi->rCOREOR($localFile);
                break;
            case 'COPARN':
				$this->edi->rCOPARN($localFile);
                break;
            default:
                break;
        }            

		//$lines = explode("'",$content);
    }
	
	public function api_edi_modify()
	{	        
        $localFile = APPPATH . 'COPARN1.EDI'; //COPARN.EDI	Sample_COPARN_APL.edi
		$this->load->model('edimg_model', 'edi');

        preg_match('/COPARN/', $localFile, $action);

        if(!isset($action[0])) {
            exit;
        }

        switch($action[0]){
            case 'COREOR':
                $this->edi->rCOREOR($localFile);
                break;
            case 'COPARN':
				$this->edi->rCOPARN($localFile);
                break;
            default:
                break;
        }            

		//$lines = explode("'",$content);
    }
}
