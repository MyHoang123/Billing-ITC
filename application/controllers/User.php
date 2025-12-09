<?php
defined('BASEPATH') OR exit('');

class User extends CI_Controller
{
    public $data;
    private $ceh;
    private $yard_id = "";

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->load->model("user_model", "user");
        $this->data['allgroup'] = $this->user->allGroups();

        $this->yard_id = $this->config->item("YARD_ID");
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

    public function login() {
        if(!empty($this->session->userdata("UserID"))) {
            redirect(md5('home'));
        }

        $data_req['UserID'] = $this->input->post("UserID", true);
        $data_req['password'] = $this->input->post("password", true);
        $data_req['rememberme'] = $this->input->post("rememberme", true);

        $this->form_validation->set_rules('UserID', 'Tên đăng nhập', 'trim|required|alpha|min_length[3]|max_length[30]', array(
            'required'      => '%s không được để trống.',
            'min_length'    => '%s phải lớn hơn 3 ký tự',
            'max_length'    => '%s phải nhỏ hơn 30 ký tự'
        ));
        $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required', array(
            'required'      => '%s không được để trống.',
        ));
//        if(preg_match('/[^A-Za-z0-9_\.]/' , $data_req['UserID'], $matchs)){
//            $this->data['error'] = "Tên đăng nhập không được chứa khoảng trắng hoặc kí tự đặc biệt";
//            $this->load->view('user/login', $this->data);
//            return;
//        }

        if($this->input->post("check_duplicate") == "1"){
            $this->data['error'] = "Người dùng này đã đăng nhập!";
            $this->load->view('user/login', $this->data);
        }else{
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('user/login');
            } else {
                $result = $this->user->validate_user($data_req);
                if(!empty($result)) {
                    if($result['IsActive'] == '0') {
                        $this->data['error'] = "Người dùng chưa được kích hoạt";
                        $this->load->view('user/login', $this->data);
                    } else { //HTTP_X_FORWARDED_FOR
                        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                            $remoteAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        } else {
                            $remoteAddr = $_SERVER['REMOTE_ADDR'];
                        }

                        $this->data = [
                            'session_id'=> session_id(),
                            'ip_address'=> $remoteAddr,
                            'start_time'=> time(),
                            'UserID' => $result['UserID'],
                            'UserGroupID' => $result['UserGroupID'],
                            'UserName' => $result['UserName']
                        ];

//                        $set = array(
//                            'UserID'    => $result['UserID'],
//                            'IP'        => $remoteAddr,
//                            'UserAgent' => $_SERVER['HTTP_USER_AGENT']
//                        );
//                        $this->ceh->insert('SYS_LOGIN_HISTORY', $set);

                        $this->session->set_userdata($this->data);
                        if($data_req['rememberme']){
                            setcookie("abc", base64_encode($data_req['UserID']), time() + (60*60*24*30) );
                            setcookie("xyz", base64_encode($data_req['password']), time() + (60*60*24*30) );
                        }else{
                            unset($_COOKIE['abc']);
                            unset($_COOKIE['xyz']);
                        }
                        redirect(md5('home'));
                    }

                } else {
                    if($this->user->check_exist_login_user($data_req['UserID'])){
                        $this->data['error'] = "Người dùng này không tồn tại!";
                    }else{
                        $this->data['error'] = "Tên đăng nhập hoặc Mật khẩu không đúng!";
                    }
                    $this->load->view('user/login', $this->data);
                }
            }
        }
    }

    public function register(){
        $data_req['UserID'] = $this->input->post("UserID", true);
        $data_req['password'] = $this->input->post("password", true);
        $data_req['UserName'] = $this->input->post("UserName", true);
        $data_req['email'] = $this->input->post("email", true);
        $data_req['cmnd'] = $this->input->post("cmnd", true);
        $data_req['enterprisename'] = $this->input->post("enterprisename", true);
        $data_req['address'] = $this->input->post("address", true);
        $data_req['phone'] = $this->input->post("phone", true);
        $data_req['taxcodes'] = $this->input->post("taxcode-list", true);

        $data_req['recaptcha'] = $this->input->post("recaptcha", true);

        if($data_req['recaptcha']){
            $this->createCaptcha();
            echo json_encode($this->data);
            exit;
        }

        if(preg_match('/[^A-Za-z0-9_\.]/' , $data_req['UserID'], $matchs)){
            $this->data['error'] = "Tên đăng nhập không được chứa khoảng trắng hoặc kí tự đặc biệt";
            $this->createCaptcha();
            $this->load->view('user/register', $this->data);
            return;
        }

        if(!empty($data_req['UserID'])){
            $postcc = $this->input->post("captcha", true);
            if($postcc != $this->session->userdata('ccword')){
                $this->data['error'] = 'Nhập sai mã xác nhận!';
                $this->createCaptcha();
                $this->load->view('user/register', $this->data);
                return;
            }

            $exists = $this->ceh->where(array('UserID' => $data_req['UserID']))->limit(1)->get('SYS_USERS')->row_array();
            if(count($exists) > 0){
                $this->data['error'] = 'Người dùng này đã tồn tại!';
                $this->createCaptcha();
                $this->load->view('user/register', $this->data);
                return;
            }

            $values = array(
                'UserID'  => $data_req['UserID'],
                'Password'  => $this->user->Encrypt($data_req['password']),
                'UserName'  => UNICODE.$data_req['UserName'],
                'Email'     => $data_req['email'],
                'PersonalID'=> $data_req['cmnd'],
                'Tel' =>    $data_req['phone'],
                'CusName' => UNICODE.$data_req['enterprisename'],
                'CusID' =>  explode(",", $data_req['taxcodes'])[0],
                'Address'   => UNICODE.$data_req['address'],
                'UserGroupID'   => 2,
                'IsActive'  => 0
            );

            //MULTI YARD - hao
            $values["YARD_ID"] = $this->yard_id;

            $this->ceh->insert('SYS_USERS', $values);
            if($this->ceh->affected_rows() > 0)
            {
                $this->ceh->where_in('CusID', explode(",", $data_req['taxcodes']))->update('CUSTOMERS', array('NameDD' => $data_req['UserID'], 'UpdateTime' => date('Y-m-d H:i:s')));
                header("Location:".md5('register_success'));
            }else{
                $this->data['error'] = 'Đăng ký thất bại! Vui lòng thử lại sau!';
                $this->createCaptcha();
                $this->load->view('user/register', $this->data);
            }
            return;
        }

        $this->data['customers'] = json_encode($this->user->getCustomers());
        $this->createCaptcha();
        $this->load->view('user/register', $this->data);
    }

    private function createCaptcha($length = 6){
        $this->load->helper('captcha');
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $streamkey = '';
        for ($i = 0; $i < $length; $i++) {
            $streamkey .= $characters[rand(0, $charactersLength - 1)];
        }

        $vals = array(
            'word'          => $streamkey,
            'img_path'      => $_SERVER["DOCUMENT_ROOT"] . '/assets/img/captcha/',
            'img_url'       => base_url('assets/img/captcha/'),
            'font_path'     => $_SERVER["DOCUMENT_ROOT"] . '/system/fonts/texb.ttf',
            'img_width'     => '150',
                'img_height'    => 37.7,
            'expiration'    => 7200,
            'font_size'     => 18,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(10, 40, 40)
            )
        );

        $cc = create_captcha($vals);
        $this->data['captcha'] = $cc['image'];
        $this->session->set_userdata(array('ccword' => $cc['word']));
    }

    public function register_success(){
        $this->load->view('user/register_success', $this->data);
    }
    public function changepass() {
        $this->data['title'] = 'Thay đổi mật khẩu';

        $data_req['UserID'] = $this->input->post("UserID");
        $data_req['oldpassword'] = $this->input->post("oldpassword");
        $data_req['newpassword'] = $this->input->post("newpassword");
        $data_req['cpassword'] = $this->input->post("cpassword");

        $this->form_validation->set_rules('UserID', 'Tên đăng nhập', 'trim|required');
        $this->form_validation->set_rules('oldpassword', 'Mật khẩu củ', 'trim|required');
        $this->form_validation->set_rules('newpassword', 'Mật khẩu mới', 'trim|matches[cpassword]|required');
        $this->form_validation->set_rules('cpassword', 'Nhập lại mật khẩu mới', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user/changepass');
        } else {
            if($data_req['newpassword'] != $data_req['cpassword']) {
                $this->data['error'] = '"Mật khẩu mới" và "Nhập lại mật khẩu mới" không khớp';
                $this->load->view('user/changepass', $this->data);
            }

            $UserID = $data_req['UserID'];
            $password = $this->user->Encrypt($data_req['oldpassword']);
            $newpassword = $this->user->Encrypt($data_req['newpassword']);

            $stmt = $this->ceh->where(array('Password' => $password, 'UserID' => $UserID))->get('USERS');
            $result = $stmt->result_array();
            if(count($result) > 0) {
                $this->ceh->set('Password', $newpassword);
                $this->ceh->where('UserID', $UserID);
                $this->ceh->update('USERS');
                //$this->funcs->insertlog("Thay đổi mật khẩu");
                $this->funcs->page_transfer("Thay đổi mật khẩu thành công.",site_url('home/index'));
            } else {
                $this->data['error'] = "Mật khẩu cũ không đúng!";
                $this->load->view('user/changepass', $this->data);
            }
        }
    }

    public function groups() {
        $access = $this->user->access('groups');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        if($this->input->post('id')) {
            $id = $this->input->post('id', true);
            $sql = "SELECT * FROM groups where group_id = ?";
            $result = $this->funcs->query_my($sql, array($id));

            echo json_encode($result);
            exit;
        } elseif ($this->input->post('edit_id', true) && $this->input->post('save') == 'save') {
            $id = $this->input->post('edit_id', true);
            $gname = $this->input->post('nhom', true);
            $sql = "UPDATE groups SET group_name = ? WHERE group_id = ?";
            $this->funcs->udi_my($sql, array($gname, $id));

            redirect(md5('user') . '/' . md5('groups'));
        } elseif ($this->input->post('del_id')) {
            $id = $this->input->post('del_id');

            $this->funcs->udi_my("DELETE FROM groups WHERE group_id = ? AND YARD_ID = ?", array($id, $this->yard_id));
            redirect(md5('user') . '/' . md5('groups'));
        } elseif($this->input->post('insert') == 'insert') {
            $gname = $this->input->post('nhom', true);
            $sql = "INSERT INTO groups (group_name) VALUES (?)";
            $this->funcs->udi_my($sql, array($gname));
            redirect(md5('user') . '/' . md5('groups'));
        } else {
            $this->data['results'] = $this->user->allGroups();
            $this->data['menus'] = $this->menu->getMenu();
            $this->data['title'] = "Quản lý nhóm";
        }

        $this->load->view('header', $this->data);
        $this->load->view('user/groups', $this->data);
        $this->load->view('footer');

    }

    public function users() {
        $access = $this->user->access('users');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['message'] = '';
        $this->data['userid'] = $this->input->post('userid') ? $this->input->post('userid') : '';
        $this->data['UserID'] = $this->input->post('UserID') ? $this->input->post('UserID') : '';
        $this->data['UserName'] = $this->input->post('UserName') ? $this->input->post('UserName') : '';
        $this->data['password'] = $this->input->post('password') ? $this->input->post('password') : '';
        $this->data['email'] = $this->input->post('email') ? $this->input->post('email') : 'none';
        $this->data['telephone'] = $this->input->post('telephone') ? $this->input->post('telephone') : 'none';
        $this->data['address'] = $this->input->post('address') ? $this->input->post('address') : 'none';
        $this->data['birthday'] = $this->input->post('birthday') ? $this->input->post('birthday') : '';
        $this->data['isactive'] = $this->input->post('isactive') ? $this->input->post('isactive') : '1';
        $this->data['UserGroupID'] = $this->input->post('UserGroupID') ? $this->input->post('UserGroupID') : '';
        $this->data['groupname'] = $this->input->post('groupname') ? $this->input->post('groupname') : '';
        $this->data['action'] = $this->input->post('action') ? $this->input->post('action') : '';
        $this->data['type'] = $this->input->post('type') ? $this->input->post('type') : ''; //type for add or edit group

        $this->data['userava'] = $this->input->post('userava') ? $this->input->post('userava') : ''; //image base64

        if($this->data['type'] == 'grp'){
            $this->user->saveGroups($this->data['UserGroupID'], $this->data['groupname']);
            $this->data['message'] = "success";

            echo json_encode($this->data);
            exit;
        }
        if($this->data['type'] == 'delGrp'){
            $this->ceh->where("YARD_ID", $this->yard_id)
                        ->where('UserGroupID', $this->data['UserGroupID'])
                        ->delete('GROUPS');
                        
            $this->data['message'] = "success";

            echo json_encode($this->data);
            exit;
        }

        if($this->data['action'] == 'add') {
            if($this->data['UserID']) {
                $exists = $this->ceh->where(array('UserID' => $this->data['UserID']))->limit(1)->get('USERS')->row_array();
                if(count($exists) > 0){
                    $this->data['duplicated'] = 'Người dùng này đã tồn tại!';
                    echo json_encode($this->data);
                    exit;
                }

                $values = array(
                    'UserID'  => $this->data['UserID'],
                    'Password'  => $this->user->Encrypt($this->data['password']),
                    'UserName'  => UNICODE.$this->data['UserName'],
                    'Email'     => $this->data['email'],
                    'Telephone' => $this->data['telephone'],
                    'Address'   => UNICODE.$this->data['address'],
                    'BirthDay'  => $this->data['birthday'],
                    'UserGroupID'   => $this->data['UserGroupID'],
                    'IsActive'  => $this->data['isactive']
                );

                $this->ceh->insert('USERS', $values);
                $this->data['message'] = "Thêm mới người dùng thành công.";

                if($this->data['userava'] != ''){
                    $imgcontent = explode(',', $this->data['userava']);
                    if(count($imgcontent) > 1){
                        $img_data = base64_decode($imgcontent[1]);
                        file_put_contents(ASSETSPATH."images".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR.$this->data['UserID'].".jpg", $img_data);
                    }
                }

                echo json_encode($this->data);
                exit;
            }
        }

        if($this->data['action'] == 'edit') {
            if($this->data['UserID']) {
                if($this->data['password']) {
                    $set = array(
                        'UserID'  => $this->data['UserID'],
                        'Password'  => $this->user->Encrypt($this->data['password']),
                        'UserName'  => UNICODE.$this->data['UserName'],
                        'Email'     => $this->data['email'],
                        'Telephone' => $this->data['telephone'],
                        'Address'   => UNICODE.$this->data['address'],
                        'BirthDay'  => $this->data['birthday'],
                        'UserGroupID'   => $this->data['UserGroupID']
                    );
                } else {
                    $set = array(
                        'UserID'  => $this->data['UserID'],
                        'UserName'  => UNICODE.$this->data['UserName'],
                        'Email'     => $this->data['email'],
                        'Telephone' => $this->data['telephone'],
                        'Address'   => UNICODE.$this->data['address'],
                        'BirthDay'  => $this->data['birthday'],
                        'UserGroupID'   => $this->data['UserGroupID']
                    );
                }

                $this->ceh->set($set);
                $this->ceh->where('UserID', $this->data['UserID']);
                $this->ceh->update('USERS');

                if($this->data['userava'] != ''){
                    $imgcontent = explode(',', $this->data['userava']);
                    if(count($imgcontent) > 1){
                        $img_data = base64_decode($imgcontent[1]);
                        file_put_contents(ASSETSPATH."images".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR.$this->data['UserID'].".jpg", $img_data);
                    }
                }

                $this->data['message'] = "Cập nhật người dùng thành công.";
                echo json_encode($this->data);
                exit;
            }

            if($this->data['userid'] && $this->input->post('update') == 'status') {
                $this->data['isactive'] = $this->data['isactive'] == 'true' ? '1' : '0';
                $this->ceh->set('IsActive', $this->data['isactive']);
                $this->ceh->where('UserID', $this->data['userid']);
                $this->ceh->update('USERS');
                if($this->data['isactive'] == '1') {
                    $this->data['success'] = "Người dùng đã kích hoạt";
                } else {
                    $this->data['success'] = "Người dùng đã huỷ kích hoạt";
                }
                echo json_encode($this->data);
                exit;
            }

            if($this->data['userid']) {
                $result = $this->user->byId($this->data['userid']);
                echo json_encode($result);
                exit;
            }

            if($this->data['type'] == 'grp'){
                $this->user->saveGroups($this->data['UserGroupID'], $this->data['groupname']);
            }
        }

        if($this->data['action'] == 'delete') {
            if($this->data['userid']) {
                $this->ceh->where('UserID', $this->data['userid']);
                $this->ceh->delete('LOGIN_HISTORY');

                $this->ceh->where('UserID', $this->data['userid']);
                $this->ceh->delete('PERMISSION');

                $this->ceh->where('UserID', $this->data['userid']);
                $this->ceh->delete('USERS');

                unlink(ASSETSPATH."images".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR.$this->data['UserID'].".jpg");

                $this->data['message'] = "Xoá người dùng thành công.";
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['users'] = $this->user->allUsers();
        $this->data['groups'] = $this->user->allGroups();
        $this->data['menus'] = $this->menu->getMenu();
        $this->data['title'] = "Quản lý người dùng";
        $this->load->view('header', $this->data);
        $this->load->view('user/users', $this->data);
        $this->load->view('footer');

    }

    public function permission() {
        $access = $this->user->access('permission');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['userid'] = $this->input->post('userid') ? $this->input->post('userid') : '';
        $this->data['UserGroupID'] = $this->input->post('UserGroupID') ? $this->input->post('UserGroupID') : '';
        $this->data['actions'] = $this->input->post('actions') ? $this->input->post('actions') : '';


        if($this->data['actions'] == 'searchUsers' && $this->data['UserGroupID']) {
            echo json_encode($this->user->byUserGroupID($this->data['UserGroupID']));
            exit;
        }

        if($this->data['actions'] == 'searchPermiss' && ($this->data['UserGroupID'] || $this->data['userid'])) {
            if($this->data['UserGroupID']) {
                $stmt = $this->ceh->where('UserGroupID', $this->data['UserGroupID'])->get('PERMISSION');
            } else {
                $stmt = $this->ceh->where('UserID', $this->data['userid'])->get('PERMISSION');
            }

            echo json_encode($stmt->result_array());
            exit;
        }

        if($this->data['actions'] == 'acceptAllPermiss' && ($this->data['UserGroupID'] || $this->data['userid'])) {
            $this->data['permiss'] = $this->input->post('permiss') ? $this->input->post('permiss') : '';
            $this->data['checkall'] = $this->input->post('checkall') ? $this->input->post('checkall') : '';
            $per_detail = '';
            if($this->data['UserGroupID'] && empty($this->data['userid'])) {
                $this->ceh->where('UserGroupID', $this->data['UserGroupID']);
                $this->ceh->delete('PERMISSION');

                if(count($this->data['permiss']) > 0 && $this->data['permiss'] != '') {
                    if($this->data['checkall'] == 'checkall') {
                        $per_detail = array('add', 'edit', 'delete', 'sendmsg');
                    }
                    foreach($this->data['permiss'] as $menuid) {
                        $set = array(
                            'UserGroupID'   => $this->data['UserGroupID'],
                            'PerDetail' => $per_detail != '' ? json_encode($per_detail) : '',
                            'MenuID'    => $menuid
                        );
                        $this->ceh->insert('PERMISSION', $set);
                    }
                }
            } else {
                $this->ceh->where('UserID', $this->data['userid']);
                $this->ceh->delete('PERMISSION');

                if(count($this->data['permiss']) > 0 && $this->data['permiss'] != '') {
                    if($this->data['checkall'] == 'checkall') {
                        $per_detail = array('add', 'edit', 'delete', 'sendmsg');
                    }
                    foreach($this->data['permiss'] as $menuid) {
                        $set = array(
                            'UserID'   => $this->data['userid'],
                            'PerDetail' => $per_detail != '' ? json_encode($per_detail) : '',
                            'MenuID'    => $menuid
                        );
                        $this->ceh->insert('PERMISSION', $set);
                    }
                }
            }

            $this->data['success'] = "Phân quyền người dùng thành công.";
            echo json_encode($this->data);
            exit;
        }

        if($this->data['actions'] == 'selectpermiss' && ($this->data['UserGroupID'] || $this->data['userid'])) {
            $this->data['menuid'] = $this->input->post('menuid') ? $this->input->post('menuid') : '0';

            if($this->data['UserGroupID'] && empty($this->data['userid'])) {
                $where = array(
                    'UserGroupID'   => $this->data['UserGroupID'],
                    'MenuID'    => $this->data['menuid']
                );
                $stmt = $this->ceh->where($where)->get('PERMISSION');
                $result = $stmt->row_array();
            } else {
                $where = array(
                    'UserID'   => $this->data['userid'],
                    'MenuID'    => $this->data['menuid']
                );
                $stmt = $this->ceh->where($where)->get('PERMISSION');
                $result = $stmt->row_array();
            }

            echo json_encode($result);
            exit;
        }

        if($this->data['actions'] == 'acceptPermiss' && ($this->data['UserGroupID'] || $this->data['userid'])) {
            $this->data['per_detail'] = $this->input->post('per_detail') ? $this->input->post('per_detail') : '';
            $this->data['menuid'] = $this->input->post('menuid') ? $this->input->post('menuid') : '0';

            if($this->data['UserGroupID'] && empty($this->data['userid'])) {
                $where = array(
                    'UserGroupID'   => $this->data['UserGroupID'],
                    'MenuID'    => $this->data['menuid']
                );
                $stmt = $this->ceh->where($where)->get('PERMISSION');
                $result = $stmt->result_array();
                if(count($result) > 0) {
                    if(count($this->data['per_detail']) > 0 && $this->data['per_detail'] != '') {
                        $this->ceh->set('PerDetail', json_encode($this->data['per_detail']));
                        $this->ceh->where($where);
                        $this->ceh->update('PERMISSION');
                    } else {
                        $this->ceh->set('PerDetail', $this->data['per_detail']);
                        $this->ceh->where($where);
                        $this->ceh->update('PERMISSION');
                    }
                } else {
                    $set = array(
                        'UserGroupID'   => $this->data['UserGroupID'],
                        'PerDetail' => json_encode($this->data['per_detail']),
                        'MenuID'    => $this->data['menuid']
                    );
                    $this->ceh->insert('PERMISSION', $set);
                }
            } else {
                $where = array(
                    'UserID'   => $this->data['userid'],
                    'MenuID'    => $this->data['menuid']
                );
                $stmt = $this->ceh->where($where)->get('PERMISSION');
                $result = $stmt->result_array();
                if(count($result) > 0) {
                    if(count($this->data['per_detail']) > 0 && $this->data['per_detail'] != '') {
                        $this->ceh->set('PerDetail', json_encode($this->data['per_detail']));
                        $this->ceh->where($where);
                        $this->ceh->update('PERMISSION');
                    } else {
                        $this->ceh->set('PerDetail', $this->data['per_detail']);
                        $this->ceh->where($where);
                        $this->ceh->update('PERMISSION');
                    }
                } else {
                    $set = array(
                        'UserID'   => $this->data['userid'],
                        'PerDetail' => json_encode($this->data['per_detail']),
                        'MenuID'    => $this->data['menuid']
                    );
                    $this->ceh->insert('PERMISSION', $set);
                }
            }

            $this->data['success'] = "Phân quyền người dùng thành công.";
            echo json_encode($this->data);
            exit;
        }

        $this->data['allMenus'] = $this->menu->getAllMenus();
        $this->data['groups'] = $this->user->allGroups();
        $this->data['menus'] = $this->menu->getMenu();
        $this->data['title'] = "Phân quyền người dùng";
        $this->load->view('header', $this->data);
        $this->load->view('user/permission', $this->data);
        $this->load->view('footer');
    }

    public function logout() {
        $this->session->unset_userdata('UserID');
        unset($_COOKIE['abc']);
        unset($_COOKIE['xyz']);
        $this->remove_eir_seq();
        $this->session->sess_destroy();

        redirect(md5('user') . '/' . md5('login'));
    }
	
	public function sendMailTest() {
		$this->load->library('email');
		$timeOld = '2017-11-29 07:00:00.000';
        $timeNow = '2017-12-31 23:59:59.999';
		
        $config['useragent'] = "";
        $config['protocol'] = 'smtp';
        $config['newline'] = "\r\n";
        $config['smtp_host'] = 'mail24419.maychuemail.com';
        $config['smtp_user'] = 'sgptos-noreply@tanthuanport.vn';
        $config['smtp_pass'] = 'Tanthuan@2023';
        $config['smtp_port'] = '465';
		$config['smtp_crypto'] = 'ssl';
        $config['wordwrap'] = TRUE;
        $config['charset'] = 'utf-8';
        $this->email->initialize($config);

        $this->email->from('sgptos-noreply@tanthuanport.vn', 'Tan Thuan');
        $this->email->to('vuhao12dtk@gmail.com, ducdv@sp-itc.com.vn');

        $this->email->subject("Báo cáo tự động từ $timeOld đến $timeNow");

        $this->email->message("- Thống kê Containers Ra / Vào cảng từ $timeOld đến $timeNow \r\n
- Thống kê Containers tồn bãi ngày $timeNow");

        $this->email->send();
        echo $this->email->print_debugger();
    }
	
    private function remove_eir_seq(){
        $arrckname = array_keys($_COOKIE);
        foreach ($arrckname as $k => $v ) {
            unset($_COOKIE[$v]);
//            $pattern = '/(.*)eirno'.session_id().'/';
//            if(preg_match($pattern, $v, $r)){
//                if(isset($r)){
//                    $eir = $_COOKIE[$v];
//                    unset($_COOKIE[$v]);
//                    $eirqueue = $this->config->item('EIR_NO_QUEUE');
//                    str_replace(",".$eir, "", $eirqueue);
//
//                    $file_path = APPPATH.'config/config_site.php';
//                    if(file_exists($file_path))
//                    {
//                        $content = file_get_contents($file_path);
//                        $content = preg_replace("/.*EIR_NO_QUEUE.*=.*;/","$"."config['EIR_NO_QUEUE'] = '".implode(',', $eirqueue)."';", $content);
//                        file_put_contents($file_path,$content);
//                    }
//                }
//            }
        }
    }
}