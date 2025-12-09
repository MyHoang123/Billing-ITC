<?php
defined('BASEPATH') OR exit('');

class menu_model extends CI_Model
{
    private $ceh;
    private $AppID;
    function __construct() {
        parent::__construct();

        $this->load->helper(array('form','url'));
        $this->load->library(array('session'));
        $this->ceh = $this->load->database('mssql', TRUE);
        $this->AppID = $this->config->item('APP_ID');
        $this->yard_id = $this->config->item('YARD_ID');
    }

    public function getMenu() {
        $stmt = $this->ceh->where('ParentID IS NULL')
                            ->where('AppID', $this->AppID)
                            ->where('IsVisible', '1')
                            ->order_by('OrderBy', 'ASC')
                            ->get('SA_MENU');

        $results = $stmt->result_array();
        $menu_r = array();

        foreach($results as $result) {
            $menu_r[$result['MenuID']]['MenuID'] = $result['MenuID'];
            $menu_r[$result['MenuID']]['MenuName'] = $result['MenuName'];
            $menu_r[$result['MenuID']]['MenuID'] = $result['MenuID'];
            $menu_r[$result['MenuID']]['MenuIcon'] = $result['MenuIcon'];
            $submenu = $this->getSubMenu($result['MenuID']);
            $menu_r[$result['MenuID']]['submenu'] = $submenu;
            foreach ($submenu as $val) {
                $subsubmenu = $this->getSubMenu($val['MenuID']);
                $menu_r[$result['MenuID']]['submenu'][$val['MenuID']]['MenuID'] = $val['MenuID'];
                $menu_r[$result['MenuID']]['submenu'][$val['MenuID']]['MenuName'] = $val['MenuName'];
                $menu_r[$result['MenuID']]['submenu'][$val['MenuID']]['MenuID'] = $val['MenuID'];
                $menu_r[$result['MenuID']]['submenu'][$val['MenuID']]['MenuIcon'] = $val['MenuIcon'];
                $menu_r[$result['MenuID']]['submenu'][$val['MenuID']]['subsubmenu'] = $subsubmenu;
            }
        }
        return $menu_r;
    }
    public function getMenuAct($menuAct) {
        $stmt = $this->ceh->where('MenuID', $menuAct)
                            ->where('AppID', $this->AppID)
                            ->order_by('OrderBy', 'ASC')
                            ->get('SA_MENU');

        $results = $stmt->result_array();
        $menu_r = array();

        foreach($results as $result) {
            $menu_r[$result['MenuID']]['MenuID'] = $result['MenuID'];
            $menu_r[$result['MenuID']]['MenuID'] = $result['MenuID'];
            $menu_r[$result['MenuID']]['MenuName'] = $result['MenuName'];
            $menu_r[$result['MenuID']]['MenuIcon'] = $result['MenuIcon'];
            $menu_r[$result['MenuID']]['submenu'] = $this->getSubMenu($result['MenuID']);
        }
        return $menu_r;
    }

    public function getSubMenu($pMenu) {
        $submenu_r = array();
        if ($this->session->userdata('UserGroupID') == 'GroupAdmin') {
            
            $this->ceh->where('AppID', $this->AppID)->where("YARD_ID", $this->yard_id)->get('SA_MENU');

            $stmt = $this->ceh->where('ParentID', $pMenu)
                                ->where('YARD_ID', $this->yard_id)
                                ->where('AppID', $this->AppID)
                                ->order_by('OrderBy', 'ASC')
                                ->get('SA_MENU');

            $menus = $stmt->result_array();
        } else {
            $where = array(
                'p.UserGroupID' => $this->session->userdata('UserGroupID'),
                'p.IsView'  => '1'
            );
            $this->ceh->select('count(*) AS c');
            $this->ceh->join('SA_ACCESSRIGHT AS p', 'p.MenuID = m.MenuID AND p.AppID = m.AppID', 'inner');
            $this->ceh->where($where);
            $this->ceh->where('m.YARD_ID', $this->yard_id);
            $this->ceh->where('m.AppID', $this->AppID);
            $stmt = $this->ceh->get('SA_MENU AS m');

            $mnu = $stmt->row_array();
            if ($mnu['c'] > 0) {
                $where = array(
                    'p.UserGroupID'  => $this->session->userdata('UserGroupID'),
                    'p.IsView'  => '1',
                    'm.ParentID' => $pMenu,
                    'm.YARD_ID' => $this->yard_id,
                    'm.AppID' => $this->AppID
                );
                
                $this->ceh->select('m.*');
                $this->ceh->join('SA_ACCESSRIGHT AS p', 'p.MenuID = m.MenuID AND p.AppID = m.AppID', 'inner');
                $this->ceh->where($where);
                $this->ceh->order_by('m.OrderBy', 'ASC');
                $stmt = $this->ceh->get('SA_MENU AS m');

            } else {
                $where = array(
                    'm.ParentID' => $pMenu,
                    'm.YARD_ID' => $this->yard_id,
                    'm.AppID' => $this->AppID,
                    'p.UserGroupID'    => $this->session->userdata('UserGroupID'),
                    'p.IsView'  => '1'
                );
                $this->ceh->select('m.*');
                $this->ceh->join('SA_ACCESSRIGHT AS p', 'p.MenuID = m.MenuID AND p.AppID = m.AppID', 'inner');
                $this->ceh->where($where);
                $this->ceh->order_by('m.OrderBy', 'ASC');
                $stmt = $this->ceh->get('SA_MENU AS m');
            }
            $menus = $stmt->result_array();
        }

        foreach($menus as $menu) {
            $submenu_r[$menu['MenuID']]['MenuID'] = $menu['MenuID'];
            $submenu_r[$menu['MenuID']]['MenuName'] = $menu['MenuName'];
            $submenu_r[$menu['MenuID']]['MenuID'] = $menu['MenuID'];
            $submenu_r[$menu['MenuID']]['MenuIcon'] = $menu['MenuIcon'];
        }
        return $submenu_r;
    }

    public function getAllMenus() {
        $stmt = $this->ceh->where('ParentID IS NULL')
                            ->where('AppID', $this->AppID)
                            ->order_by('OrderBy', 'ASC')
                            ->get('SA_MENU');

        $results = $stmt->result_array();
        $menu_r = array();

        foreach($results as $result) {
            $menu_r[$result['MenuID']]['MenuID'] = $result['MenuID'];
            $menu_r[$result['MenuID']]['MenuName'] = $result['MenuName'];
            $menu_r[$result['MenuID']]['MenuID'] = $result['MenuID'];
            $menu_r[$result['MenuID']]['submenu'] = $this->getSubMenu($result['MenuID']);
        }
        return $menu_r;
    }

    public function getAllSubs($p_id) {

        $submenu_r = array();

        $this->ceh->get('SA_MENU');

        $stmt = $this->ceh->where('ParentID', $p_id)
                            ->where('AppID', $this->AppID)
                            ->order_by('OrderBy', 'ASC')
                            ->get('SA_MENU');

        $menus = $stmt->result_array();

        foreach($menus as $menu) {
            $submenu_r[$menu['MenuID']]['MenuID'] = $menu['MenuID'];
            $submenu_r[$menu['MenuID']]['MenuID'] = $menu['MenuID'];
            $submenu_r[$menu['MenuID']]['MenuName'] = $menu['MenuName'];
            $submenu_r[$menu['MenuID']]['MenuIcon'] = $menu['MenuIcon'];
        }
        return $submenu_r;
    }
}