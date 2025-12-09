<?php
defined('BASEPATH') OR exit('');

class Api_model extends CI_Model {
    // private $UC = 'UNICODE';
    private $iYARD = "ITC";

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
        // $this->his = $this->load->database('mssqlsvr', TRUE);   
    }
	
	public function checkMNR_API_loadData($arrs) {
		$this->ceh->select("T0.insert_time, T0.TableName, T0.Method, T0.JsonString, ISNULL(T1.ResponseString, T0.ResponseString) ResponseString, ISNULL(T1.isSuccess, T0.isSuccess) isSuccess, T0.rowguid");
		$this->ceh->from("MNR_API T0 WITH(NOLOCK)");
		$this->ceh->join("MNR_API_COMPLETE T1 WITH(NOLOCK)", "T0.rowguid = T1.rowguid", "LEFT");
	
        $this->ceh->where('T0.insert_time >=', $arrs['FormDate'])
                 ->where('T0.insert_time <=', $arrs['ToDate']);
        if ($arrs['Method'] && $arrs['Method'] != "*") {
            $this->ceh->where('T0.Method', $arrs['Method']);
        }
        // if ($arrs['TableName'] && $arrs['TableName'] != "*") {
        //     $this->ceh->where('T0.TableName', $arrs['TableName']);
        // }
        if ($arrs['isSuccess'] && $arrs['isSuccess'] != "*") {
            $this->ceh->where('COALESCE(T1.isSuccess, T1.isSuccess)', $arrs['isSuccess']);
        }
        if ($arrs['SearchText'] && $arrs['SearchText'] != "") {
            $this->ceh->like('T0.JsonString', $arrs['SearchText']);
        }
		$abcdef = $this->ceh->order_by('T0.insert_time', 'desc')->get();
        return  $abcdef->result_array();
    }

    public function checkHIS_API_loadData($arrs) {
	// public function checkHIS_API_loadData($arrs, $searchTable) {
		// $iQuery = "SELECT T0.insert_time, T0.TableName, T0.Method, T0.JsonString, ISNULL(T1.ResponseString, T0.ResponseString) ResponseString, ISNULL(T1.isSuccess, T0.isSuccess) isSuccess, T0.rowguid
		// 		FROM HIS_API T0 WITH(NOLOCK)
		// 		LEFT JOIN HIS_API_COMPLETE T1 WITH(NOLOCK) ON T0.rowguid = T1.rowguid
		// 		WHERE 1=1 AND T0.insert_time >= ? AND T0.insert_time <= ? ";
		
		
		
		$this->ceh->select("T0.insert_time, T0.TableName, T0.Method, T0.JsonString, ISNULL(T1.ResponseString, T0.ResponseString) ResponseString, ISNULL(T1.isSuccess, T0.isSuccess) isSuccess, T0.rowguid");
		$this->ceh->from("HIS_API T0 WITH(NOLOCK)");
		$this->ceh->join("HIS_API_COMPLETE T1 WITH(NOLOCK)", "T0.rowguid = T1.rowguid", "LEFT");
		// $this->ceh->from( $searchTable . " T0 WITH(NOLOCK)");
		// $this->ceh->join( $searchTable . "_COMPLETE T1 WITH(NOLOCK)", "T0.rowguid = T1.rowguid", "LEFT");
		
        $this->ceh->where('T0.insert_time >=', $arrs['FormDate'])
                 ->where('T0.insert_time <=', $arrs['ToDate']);
        if ($arrs['Method'] && $arrs['Method'] != "*") {
            $this->ceh->where('T0.Method', $arrs['Method']);
        }
        if ($arrs['TableName'] && $arrs['TableName'] != "*") {
            $this->ceh->where('T0.TableName', $arrs['TableName']);
        }
        if ($arrs['isSuccess'] && $arrs['isSuccess'] != "*") {
            $this->ceh->where('COALESCE(T1.isSuccess, T1.isSuccess)', $arrs['isSuccess']);
        }
        if ($arrs['SearchText'] && $arrs['SearchText'] != "") {
            $this->ceh->like('T0.JsonString', $arrs['SearchText']);
        }
		$abcdef = $this->ceh->order_by('T0.insert_time', 'desc')->get();
		// $lastquery = $this->ceh->last_query();
		// log_message('error', $lastquery);
        return  $abcdef->result_array();
    }

    public function checkHIS_API_saveData($arrs) {
        if (!empty($arrs)) {    
            $iSQL = "EXEC dbo.SaveHIS_API @pRowguid=?";
            $xyzt = $this->ceh->query($iSQL, array( $arrs ));
            $dataReturn = $xyzt->row_array();
            if ( intval($dataReturn['ErrorNumber']) < 0) {
                $result['iStatus'] = 'Fail';
            }
            else {
                $result['iStatus'] = 'Success';
            }
            $result['iMess'] = $dataReturn['Error_Msg'];
            return $result;


            // $this->ceh->trans_begin();
            // $this->ceh->trans_strict(FALSE);
            // foreach ($arrs as $key => $item) { 
            //     if(isset($itemX)) unset($itemX);
            //     $itemX = $this->ceh->where('rowguid', $item['rowguid'])->get("HIS_API")->row_array();
            //     if (is_array($itemX) && count($itemX) > 0) { 
            //         $arrayUpdate = array (
            //             'insert_time' => date('Y-m-d H:i:s'),
            //             'JsonString' => $item['JsonString'],
            //             'SoLanGui' => 0,
            //         );
            //         $this->ceh->where('rowguid', $itemX['rowguid'])->update("HIS_API", $arrayUpdate);
            //     }
            // }
            // $this->ceh->trans_complete();
            // if ($this->ceh->trans_status() === FALSE) {
            //     $this->ceh->trans_rollback();
            //     $result['iStatus'] = 'Fail';
            //     $result['iMess'] = 'Phát sinh lỗi khi cập nhật!';
            // } 
            // else {
            //     $this->ceh->trans_commit();
            //     $result['iStatus'] = 'Success';
            //     $result['iMess'] = 'Cập nhật thành công!';
            // }
            // return $result;
        }
    }
}
