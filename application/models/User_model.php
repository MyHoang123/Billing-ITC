<?php
defined('BASEPATH') OR exit('');

class user_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = "";
    private $app_id = "";

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item("YARD_ID");
        $this->app_id = $this->config->item("APP_ID");
    }

    public function validate_user($data) {
        $where = array(
            'UserID'    => $data['UserID'],
            'Pwd'       => $this->Encrypt($data['password']),
            "YARD_ID" => $this->yard_id
        );

        $stmt = $this->ceh->where($where)
                            ->where_in("AppID", array($this->app_id, '*'))
                            ->limit(1)->get('SA_USERS');

        $result = $stmt->row_array();
        return $result;
    }
    public function check_exist_login_user($UserID){
        $count_user = $this->ceh->select('COUNT(UserID) CountUser')
                                    ->where('UserID', $UserID)
                                    ->where("YARD_ID", $this->yard_id)
                                    ->where_in("AppID", array($this->app_id, '*'))
                                    ->limit(1)
                                    ->get('SA_USERS');

        return $count_user->row_array();
    }

    public function Encrypt($string = '') {
        return md5(md5($this->config->item('encryption_key')) . md5($string));
    }

    public function access($method = '') {
        $where = array(
            'p.UserGroupID' => $this->session->userdata('UserGroupID'),
            'p.AppID' => $this->app_id
        );

        $this->ceh->select('count(*) AS c');
        $this->ceh->join('SA_ACCESSRIGHT AS p', 'p.MenuID = m.MenuID AND p.AppID = m.AppID', 'inner');
        $this->ceh->where($where);
        $stmt = $this->ceh->get('SA_MENU AS m'); 

        $mnu = $stmt->row_array();
        if ($mnu['c'] > 0) {
            $where = array(
                'p.UserGroupID'  => $this->session->userdata('UserGroupID'),
                'm.MenuID' => $method,
                'p.AppID' => $this->app_id
            );
            $this->ceh->select('m.*, p.IsAddNew, p.IsModify, p.IsDelete');
            $this->ceh->join('SA_ACCESSRIGHT AS p', 'p.MenuID = m.MenuID AND p.AppID = m.AppID', 'inner');
            $this->ceh->where($where);
            $this->ceh->limit(1);
            $stmt = $this->ceh->get('SA_MENU AS m');

            $fmenu = $stmt->row_array();
        } else {
            $where = array(
                'p.UserGroupID'  => $this->session->userdata('UserGroupID'),
                'm.MenuID' => $method,
                'p.AppID' => $this->app_id
            );
            $this->ceh->select('m.*, p.IsAddNew, p.IsModify, p.IsDelete');
            $this->ceh->join('SA_ACCESSRIGHT AS p', 'p.MenuID = m.MenuID AND p.AppID = m.AppID', 'inner');
            $this->ceh->where($where);
            $this->ceh->limit(1);
            $stmt = $this->ceh->get('SA_MENU AS m');
            $fmenu = $stmt->row_array();
        }

        if ( $this->session->userdata('UserGroupID') != 'GroupAdmin' ) {
            if(count($fmenu) == 0) {
                return false;
            } else {
                $action = $this->input->post('action') ? strtolower($this->input->post('action')) : 'view';

                if( $action == 'save' || $action == 'save_draft' ){
                    $action = 'edit';
                }
                
                $access = array();
                if($fmenu['IsAddNew'] == 1)
                {
                    array_push($access, "add");
                }
                if($fmenu['IsModify'] == 1)
                {
                    array_push($access, "edit");
                }
                if($fmenu['IsDelete'] == 1)
                {
                    array_push($access, "delete");
                }
                if(count($access) == 0) {
                    if($action != 'view') {
                        return "Bạn không được cấp phép thực hiện chức năng này!";
                    }
                } else {
                    if(!in_array($action, $access) && $action != 'view') {
                        return "Bạn không được cấp phép thực hiện chức năng này!";
                    } else {
                        return true;
                    }
                }
            }
        } else {
            return true;
        }
    }

    public function allGroups() {
        $result = $this->ceh->where("YARD_ID", $this->yard_id)
                            ->get('SA_USERGROUPS');

        return $result->result_array();
    }
    public function saveGroups($grID, $grName) {
        $item = array(
            'UserGroupName' => UNICODE.$grName,
            'ModifiedBy' => $this->session->userdata("UserID"),
            'update_time' => date('Y-m-d H:i:s')
        );

        if( $grID != '' ){
            //check exist
            $exist = $this->ceh->select("rowguid")->where('UserGroupID', $grID)
                                                    ->where('YARD_ID', $this->yard_id)
                                                    ->limit(1)->get("SA_USERGROUPS")->row_array();

            if( count( $exist ) > 0 ){
                $this->ceh->where("rowguid", $exist["rowguid"])->update("SA_USERGROUPS", $item);
            }else{
                $item["UserGroupID"] = $grID;
                $item["AppID"] = $this->app_id;
                $item["YARD_ID"] = $this->yard_id;

                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('SA_USERGROUPS', $item);
            }
        }else{
            //insert database
            $item["UserGroupID"] = $grID;
            $item["AppID"] = $this->app_id;
            $item["YARD_ID"] = $this->yard_id;

            $item['CreatedBy'] = $item['ModifiedBy'];
            $this->ceh->insert('SA_USERGROUPS', $item);
        }
    }

    public function allUsers() {

        $this->ceh->select('u.*, g.UserGroupName');
        $this->ceh->join('SA_USERGROUPS AS g', 'g.UserGroupID = u.UserGroupID AND g.YARD_ID = u.YARD_ID', 'inner');

        $this->ceh->where("u.YARD_ID", $this->yard_id);

        $this->ceh->order_by('u.UserID', 'ASC');
        $stmt = $this->ceh->get('SA_USERS AS u');

        return $stmt->result_array();
    }

    public function byUserGroupID($gId) {
        $stmt = $this->ceh->where('UserGroupID', $gId)
                            ->where('YARD_ID', $this->yard_id)
                            ->get('SA_USERS');

        return $stmt->result_array();
    }

    public function byId($userId) {

        $this->ceh->select('u.*, g.UserGroupName');
        $this->ceh->join('SA_USERGROUPS AS g', 'g.UserGroupID = u.UserGroupID AND g.YARD_ID = u.YARD_ID', 'inner');

        $this->ceh->where("u.YARD_ID", $this->yard_id);
        $this->ceh->where('u.UserID', $userId);

        $this->ceh->order_by('u.UserID', 'ASC');
        $stmt = $this->ceh->get('SA_USERS AS u');

        return $stmt->row_array();
    }

    public function byRowguid($rowguid) {
        $this->ceh->select('u.*, g.UserGroupName');
        $this->ceh->join('SA_USERGROUPS AS g', 'g.UserGroupID = u.UserGroupID AND g.YARD_ID = u.YARD_ID', 'inner');

        $this->ceh->where("u.YARD_ID", $this->yard_id);
        $this->ceh->where('u.rowguid', $rowguid);

        $this->ceh->order_by('u.UserID', 'ASC');
        $stmt = $this->ceh->get('SA_USERS AS u');

        return $stmt->row_array();
    }
//
//    public function countOnline() {
//        $munit = time() - 900;
//
//        $sql = "SELECT s.*, u.user_name, g.group_name FROM sessions s INNER JOIN SA_USERS u ON u.user_id = s.user_id INNER JOIN SA_ACCESSRIGHT g ON u.group_id = g.group_id WHERE s.start_time > ? ORDER BY s.start_time DESC";
//
//        return $this->functions->query_my($sql, array($munit));
//    }

    public function getCustomers(){
        $this->ceh->select('CusID, VAT_CD, CusType, Address, CusName');
//        $this->ceh->where('IsOpr', 1);
        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }
}