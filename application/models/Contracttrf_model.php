<?php
defined('BASEPATH') OR exit('');

class Contracttrf_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
        $this->yard_id = $this->config->item('YARD_ID');
    }

    public function getOpr( $args = array() ){
        $this->ceh->select( "CusID, CusName" );
        $this->ceh->where( "IsOpr", 1 );
        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function getPayers($user = ''){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther ');
        if($user != '' && $user != 'Admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function searchShipLane($arrStatus = '', $year = '', $name = ''){
        $this->ceh->select('vs.ShipKey, vv.ShipName, vs.ShipID, vs.ImVoy, vs.ExVoy, vs.ETB, vs.LaneID, lane.LaneName');
        $this->ceh->join('VESSELS vv', 'vv.ShipID = vs.ShipID AND vv.YARD_ID = vs.YARD_ID');
        $this->ceh->join('LANE lane', 'vs.LaneID = lane.LaneID AND vs.YARD_ID = lane.YARD_ID');
        $this->ceh->where('vv.VESSEL_TYPE', 'V');
        $this->ceh->where('vs.YARD_ID', $this->yard_id);
        $this->ceh->where('vs.LaneID IS NOT NULL');

        if($arrStatus != ''){
            $pre = (int)$arrStatus == 1 ? " !=" : "";
            $this->ceh->where('vs.ShipArrStatus'.$pre, 2);
        }

        if($year != ''){
            $this->ceh->where('vs.ShipYear', $year);
        }

        if($name != ''){
            $this->ceh->like('vv.ShipName', $name);
        }
        
        $this->ceh->order_by('vs.ETB', 'DESC');
        $stmt = $this->ceh->get('VESSEL_SCHEDULE vs');
        return $stmt->result_array();
    }

    public function contractTemplate(){
        $this->ceh->select('NICK_NAME, LANE, OPR, PAYER, APPLY_DATE, EXPIRE_DATE, PAYMENT_TYPE, REF_RMK');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('NICK_NAME', 'ASC');
        $stmt = $this->ceh->get('TRF_DIS');
        $stmt = $stmt->result_array();
        $result = array();
        foreach ($stmt as $item) {
            $ptemp = '';
            if(is_array($item)){
                foreach ($item as $k => $n) {
                    if( $k == 'EXPIRE_DATE' ){
                        $n = explode(' ', $this->funcs->clientDateTime( $n, '/' ) )[0];
                    }

                    $ptemp .= ($n === null) ? ":" : "$n:";
                }
            }

            array_push($result, substr($ptemp, 0, -1));

        }
        return array_unique($result);
    }

    public function trfExtraTemplate()
    {
        $this->ceh->distinct();
        $this->ceh->select('LevelCode');
        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->order_by('LevelCode', 'ASC');
        $stmt = $this->ceh->get('TRF_LEVEL');
        $stmt = $stmt->result_array();
        return array_column($stmt, 'LevelCode');
    }

    public function loadTRFSource(){
        return $this->ceh->select("TRF_CODE, TRF_DESC")
                            ->where('YARD_ID', $this->yard_id)
                            ->get("TRF_CODES")->result_array();
    }

    public function loadTariffCodes(){
        return $this->ceh->where('YARD_ID', $this->yard_id)
                            ->get("TRF_CODES")
                            ->result_array();
    }

    public function tarrifTemplate(){
        $this->ceh->select('FROM_DATE, TO_DATE, NOTE');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('FROM_DATE', 'DESC');
        $stmt = $this->ceh->get('TRF_STD');
        $stmt = $stmt->result_array();
        $result = array();
        foreach ($stmt as $item) {
            $ptemp = '';
            if(is_array($item)){
                foreach ($item as $n) {
                    $ptemp .= ($n === null) ? "-" : "$n-";
                }
            }
            array_push($result, substr($ptemp, 0, -1));

        }
        return array_unique($result);
    }

    public function loadTRF_DTD_InvTPLT( $tariffTemp ){
        $this->ceh->select('ts.rowguid, ts.TRANSIT_CD, tm.Transit_Name, DMETHOD_CD , TRF_CODE ,IX_CD, CLASS_Name, TRF_STD_DESC
                            , CARGO_TYPE , Description, JOB_KIND, CNTR_JOB_TYPE, dm.CJModeName, ts.CURRENCYID, ts.IsLocal
                            , ISNULL( jt.NameGate, ISNULL( jt.NameYard, jt.NameQuay ) ) AS JobName');
        $this->ceh->join('DELIVERY_MODE dm','dm.CJMode_CD = ts.CNTR_JOB_TYPE AND dm.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CLASS_Mode cl','cl.CLASS_Code = ts.IX_CD AND cl.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CARGO_TYPE ct','ct.Code = ts.CARGO_TYPE AND ct.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('ALLJOB_TYPE jt','jt.Code = ts.JOB_KIND AND jt.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('Transit_Mode tm','tm.Transit_CD = ts.TRANSIT_CD AND tm.YARD_ID = ts.YARD_ID', 'left');

        $result = array();
        if( $tariffTemp == '' ){
            return $result;
        }

        $temp = explode("-", $tariffTemp);
        $fwhere = array(
            "FROM_DATE" => $temp[0] == "" ? null : $temp[0],
            "TO_DATE" => $temp[1] == "" ? null : $temp[1]
        );

        $stmt = $this->ceh->where( $fwhere )
                            ->where("ts.YARD_ID", $this->yard_id)
                            ->order_by("TRF_CODE", "ASC")
                            ->get('TRF_STD ts');

        $result = $stmt->result_array();

        return $result;
    }

    public function loadTariffStandard( $tariffTemp = '' ){
        $this->ceh->select('ts.rowguid, ts.TRANSIT_CD, tm.Transit_Name, DMETHOD_CD , TRF_CODE ,IX_CD, CLASS_Name
                            , CARGO_TYPE , Description, JOB_KIND, CNTR_JOB_TYPE, dm.CJModeName, CURRENCYID
                            , IsLocal, AMT_F20 ,AMT_E20, AMT_F40 ,AMT_E40, AMT_F45 ,AMT_E45 ,AMT_NCNTR ,VAT ,TRF_STD_DESC ,FROM_DATE
                            , TO_DATE, NOTE ,INCLUDE_VAT, FROM_DATE, TO_DATE
                            , ISNULL( jt.NameGate, ISNULL( jt.NameYard, jt.NameQuay ) ) AS JobName');
        // $this->ceh->join('TRF_CODES t','t.TRF_CODE = ts.TRF_CODE');
        $this->ceh->join('DELIVERY_MODE dm','dm.CJMode_CD = ts.CNTR_JOB_TYPE AND dm.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CLASS_Mode cl','cl.CLASS_Code = ts.IX_CD AND cl.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CARGO_TYPE ct','ct.Code = ts.CARGO_TYPE AND ct.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('ALLJOB_TYPE jt','jt.Code = ts.JOB_KIND AND jt.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('Transit_Mode tm','tm.Transit_CD = ts.TRANSIT_CD AND tm.YARD_ID = ts.YARD_ID', 'left');

        $temp = explode("-", $tariffTemp);
        $fwhere = array(
            "FROM_DATE" => $temp[0] == "" ? null : $temp[0],
            "TO_DATE" => $temp[1] == "" ? null : $temp[1]
        );

        $stmt = $this->ceh->where( $fwhere )
                            ->where("ts.YARD_ID", $this->yard_id)->get('TRF_STD ts');

        return $stmt->result_array();
    }

    public function loadContract($contractTemp){
        //NICK_NAME, LANE, OPR, PAYER, APPLY_DATE, EXPIRE_DATE, PAYMENT_TYPE, REF_RMK

        $this->ceh->select('OPR, PAYER_TYPE, PAYER, NICK_NAME, PAYMENT_TYPE
                            , ts.rowguid, ts.TRANSIT_CD, tm.Transit_Name, DMETHOD_CD , TRF_CODE ,IX_CD, CLASS_Name
                            , CARGO_TYPE , Description, JOB_KIND, CNTR_JOB_TYPE, dm.CJModeName, CURRENCYID
                            , IsLocal, AMT_F20 ,AMT_E20, AMT_F40 ,AMT_E40, AMT_F45 ,AMT_E45 ,AMT_NCNTR ,VAT ,TRF_STD_DESC
                            , REF_RMK ,INCLUDE_VAT, APPLY_DATE, EXPIRE_DATE
                            , ISNULL( jt.NameGate, ISNULL( jt.NameYard, jt.NameQuay ) ) AS JobName');
        // $this->ceh->join('TRF_CODES t','t.TRF_CODE = ts.TRF_CODE');
        $this->ceh->join('DELIVERY_MODE dm','dm.CJMode_CD = ts.CNTR_JOB_TYPE AND dm.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CLASS_Mode cl','cl.CLASS_Code = ts.IX_CD AND cl.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CARGO_TYPE ct','ct.Code = ts.CARGO_TYPE AND ct.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('ALLJOB_TYPE jt','jt.Code = ts.JOB_KIND AND jt.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('Transit_Mode tm','tm.Transit_CD = ts.TRANSIT_CD AND tm.YARD_ID = ts.YARD_ID', 'left');

        $temp = explode(":", $contractTemp);
        $fwhere = array(
            "NICK_NAME" => $temp[0] == "" ? null : $temp[0],
            "LANE" => $temp[1],
            "OPR" => $temp[2],
            "PAYER" => $temp[3],
            "APPLY_DATE" => $temp[4],
            "EXPIRE_DATE" => $this->funcs->dbDateTime( $temp[5] ),
            "PAYMENT_TYPE" => $temp[6],
            "REF_RMK" => $temp[7] == "" ? null : $temp[7],
            "ts.YARD_ID" => $this->yard_id
        );
        
        $stmt = $this->ceh->where($fwhere)->get('TRF_DIS ts');
        $stmt = $stmt->result_array();

        return $stmt;
    }


    //SAVE TRF_CODE
    public function saveTRFCode($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $existItem = array();

            if(isset($item['TRF_DESC'])){
                $item['TRF_DESC'] = UNICODE.$item['TRF_DESC'];
            }

            if($rguid != ''){
                $stmt =  $this->ceh->where('rowguid', $rguid)
                                    ->where('YARD_ID', $this->yard_id)
                                    ->get('TRF_CODES');

                $existItem = $stmt->row_array();
            }

            $item['YARD_ID'] = $this->yard_id;

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if(count($existItem) > 0)
            {
                //update database
                $this->ceh->where('rowguid', $rguid)->limit(1)->update('TRF_CODES', $item);
            }
            else
            {
                $checkitem = $this->ceh->select("rowguid")
                                        ->where('TRF_CODE', $item['TRF_CODE'])
                                        ->where('YARD_ID', $item["YARD_ID"])
                                        ->limit(1)
                                        ->get('TRF_CODES')->result_array();

                if(count($checkitem) > 0){
                    $this->ceh->where('rowguid', $checkitem["rowguid"])->update('TRF_CODES', $checkitem);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('TRF_CODES', $item);
                }
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    //SAVE TRF_STD
    public function saveTariffSTD($datas, $applyDate, $expireDate, $ref_mark){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $existItem = array();

            if(isset($item['TRF_STD_DESC'])){
                $item['TRF_STD_DESC'] = UNICODE.$item['TRF_STD_DESC'];
            }

            $item['YARD_ID'] = $this->yard_id;

            $where = array(
                "TRF_CODE" => $item["TRF_CODE"],
                "DMETHOD_CD" => $item["DMETHOD_CD"],
                "IX_CD" => $item["IX_CD"],
                "CARGO_TYPE" => $item["CARGO_TYPE"],
                "JOB_KIND" => $item["JOB_KIND"],
                "CNTR_JOB_TYPE" => $item["CNTR_JOB_TYPE"],
                "TRANSIT_CD" => $item["TRANSIT_CD"],
                "IsLocal" => $item["IsLocal"],
                "CURRENCYID" => $item["CURRENCYID"],
                "FROM_DATE" => $applyDate,
                "TO_DATE" => $expireDate,

                "YARD_ID" => $item["YARD_ID"]
            );

            $existsTRF = $this->ceh->select("COUNT(*) COUNT_TRF")->where($where)->get("TRF_STD")->row_array();

            $item["FROM_DATE"] = $applyDate;
            $item["TO_DATE"] = $expireDate;
            $item['NOTE'] = UNICODE.$ref_mark;
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if($existsTRF["COUNT_TRF"] > 0)
            {
                //update database
                $this->ceh->where($where)->update('TRF_STD', $item);
            }
            else
            {
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('TRF_STD', $item);
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    public function saveInvTemplate($datas, $onlyUpdateTemp, &$outputMsg )
    {
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ( $datas as $key => $item ) {
            $itemRowguid = $item["rowguid"];
            $itemSelectMark = isset( $item["Select"] ) ? $item["Select"] : FALSE;
            $hasUpdate = isset( $item["hasUpdate"] ) ? $item["hasUpdate"] : FALSE;

            unset( $item["rowguid"], $item["Select"], $item["hasUpdate"] );

            if( isset( $item["TPLT_DESC"] ) ){
                $item["TPLT_DESC"] = UNICODE.$item["TPLT_DESC"];
            }

            if( isset( $item["TRF_STD_DESC"] ) ){
                $item["TRF_STD_DESC"] = UNICODE.$item["TRF_STD_DESC"];
            }
    
            $item['YARD_ID'] = $this->yard_id;

            if( empty( $itemRowguid ) ){
                goto _insertMarker;
            }

            $getTPLT_NMsql = $this->ceh->select("TPLT_NM")
                                                ->where("rowguid", $itemRowguid)
                                                ->limit(1)
                                                ->get_compiled_select("INV_TPLT", TRUE);

            $guid_retrieve_sql = $this->ceh->select("rowguid")
                                            ->where("TPLT_NM = (".$getTPLT_NMsql.")")
                                            ->get_compiled_select("INV_TPLT", TRUE);

            $renameCancel = false;
            
            $tpltNM = $this->ceh->query( $getTPLT_NMsql )->row_array();

            if( $hasUpdate === true || $onlyUpdateTemp === true ){

                $itemUpdate = array(
                    "TPLT_DESC" => $item["TPLT_DESC"],
                    "update_time" => date('Y-m-d H:i:s')
                );

                $checkInvDraft = $this->ceh->select("DRAFT_INV_NO")->where( "TPLT_NM", $tpltNM["TPLT_NM"] )
                                                                    ->where("YARD_ID", $this->yard_id)
                                                                    ->limit(1)
                                                                    ->get("INV_DFT")->row_array();
                if( count( $checkInvDraft ) > 0 ){
                    $renameCancel = true;
                }

                if( !$renameCancel ){
                    $itemUpdate["TPLT_NM"] = $item["TPLT_NM"];
                    $itemUpdate["CURRENCYID"] = $item["CURRENCYID"];
                }

                $this->ceh->where("TPLT_NM = (".$getTPLT_NMsql.")")->where("YARD_ID", $this->yard_id)->update( "INV_TPLT", $itemUpdate );
            }

            if( $renameCancel === true && $hasUpdate === true ){

                if( count( $tpltNM ) > 0 ){
                    $item["TPLT_NM"] = $tpltNM["TPLT_NM"];
                    array_push( $outputMsg , "Mẫu cước [".$item['TPLT_NM']."] đã được sử dụng! Bạn chỉ có thể thay đổi tên mẫu!");
                }
            }

            if( $onlyUpdateTemp === true ){
                goto _xxx;
            }

_insertMarker:

            if( $itemSelectMark == "1" )
            {
                if( empty( $itemRowguid ) ){
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'] = $this->session->userdata("UserID");
                    $item['insert_time'] = $item['update_time'] = date('Y-m-d H:i:s');
                    $this->ceh->insert('INV_TPLT', $item );
                }else
                {
                    $checkExistItem = $this->ceh->select("rowguid")
                                                ->where( "STD_ROW_ID", $item["STD_ROW_ID"] )
                                                ->where("rowguid IN(".$guid_retrieve_sql.")")
                                                ->limit(1)
                                                ->get("INV_TPLT")->row_array();
                    
                    if( count( $checkExistItem ) > 0 ){
                        $item['ModifiedBy'] = $this->session->userdata("UserID");
                        $item['update_time'] = date('Y-m-d H:i:s');
                        $this->ceh->where( "rowguid", $checkExistItem["rowguid"] )
                                    ->update( "INV_TPLT", $item );
                    }else{
                        $item['CreatedBy'] = $item['ModifiedBy'] = $this->session->userdata("UserID");;
                        $item['insert_time'] = $item['update_time'] = date('Y-m-d H:i:s');

                        $this->ceh->insert('INV_TPLT', $item );
                    }
                }
            }
            else
            {
                $check = $this->ceh->join("INV_DFT_DTL ivd", "ivd.DRAFT_INV_NO = iv.DRAFT_INV_NO and ivd.YARD_ID = iv.YARD_ID", "left")
                                    ->where( "TPLT_NM", $item["TPLT_NM"] )
                                    ->where("TRF_CODE", $item["TRF_CODE"])
                                    ->limit(1)
                                    ->get("INV_DFT iv")->row_array();

                if( count( $check ) > 0 ){
                    array_push( $outputMsg , "[Biểu cước/Mẫu cước] [".$item['TRF_CODE']."/".$item["TPLT_NM"]."] đã được sử dụng! Không thể xóa!");
                }else{
                    $this->ceh->where( "STD_ROW_ID", $item["STD_ROW_ID"] )
                                    ->where("rowguid IN(".$guid_retrieve_sql.")")
                                    ->delete("INV_TPLT");
                }
            }
        }

_xxx:
        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            array_push( $outputMsg , $this->ceh->_error_message() );
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function deleteInvTemplate( $rowguid, &$outMsg )
    {
        $getTPLT_NMsql = $this->ceh->select("TPLT_NM")
                                            ->where("rowguid", $rowguid)
                                            ->limit(1)
                                            ->get_compiled_select("INV_TPLT", TRUE);

        $checkInvDraft = $this->ceh->select("TPLT_NM, DRAFT_INV_NO")->where("TPLT_NM = (".$getTPLT_NMsql.")")
                                    ->where("YARD_ID", $this->yard_id)
                                                    ->limit(1)
                                                    ->get("INV_DFT")->row_array();
        if( count($checkInvDraft) > 0 ){
            $outMsg = "Mẫu cước [".$checkInvDraft["TPLT_NM"]."] đã được sử dụng ( PTC: ".$checkInvDraft['DRAFT_INV_NO']." )";
            return FALSE;
        }

        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where("TPLT_NM = (".$getTPLT_NMsql.")")
                    ->where("YARD_ID", $this->yard_id)
                    ->delete("INV_TPLT");

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            $outMsg = $this->ceh->_error_message();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    //SAVE TRF_DIS
    public function saveDisTariff( $datas, $commons ){ //commons chứa những thuộc tính chung của 1 list biểu cước (TÊN, Hãng KT, ...)
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ( $datas as $key => $item ) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $existItem = array();

            if(isset($item['TRF_STD_DESC'])){
                $item['TRF_STD_DESC'] = UNICODE.$item['TRF_STD_DESC'];
            }

            $item['YARD_ID'] = $this->yard_id;

            $where = array(
                "OPR" => $commons['OPR'],
                "PAYER" => $commons['PAYER'],
                "PAYMENT_TYPE" => $commons['PAYMENT_TYPE'],
                "TRF_CODE" => $item["TRF_CODE"],
                "DMETHOD_CD" => $item["DMETHOD_CD"],
                "IX_CD" => $item["IX_CD"],
                "CARGO_TYPE" => $item["CARGO_TYPE"],
                "JOB_KIND" => $item["JOB_KIND"],
                "CNTR_JOB_TYPE" => $item["CNTR_JOB_TYPE"],
                "TRANSIT_CD" => $item["TRANSIT_CD"],
                "IsLocal" => $item["IsLocal"],
                "CURRENCYID" => $item["CURRENCYID"],
                "APPLY_DATE" => $commons['APPLY_DATE'],
                "EXPIRE_DATE" => $commons['EXPIRE_DATE'],
                "LANE" => $commons['LANE'],

                "YARD_ID" => $item["YARD_ID"]
            );

            $existsTRF = $this->ceh->select("COUNT(*) COUNT_TRF")->where($where)->get("TRF_DIS")->row_array();

            $item["APPLY_DATE"] = $commons['APPLY_DATE'];
            $item["EXPIRE_DATE"] = $commons['EXPIRE_DATE'];
            $item['REF_RMK'] = $commons['REF_RMK'];

            $item['NICK_NAME'] = $commons['NICK_NAME'];
            $item['OPR'] = $commons['OPR'];
            $item['PAYER'] = $commons['PAYER'];
            $item['PAYER_TYPE'] = $commons['PAYER_TYPE'];
            $item['PAYMENT_TYPE'] = $commons['PAYMENT_TYPE'];
            $item['LANE'] = '*';
            $item['EQU_TYPE'] = '*';

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if($existsTRF["COUNT_TRF"] > 0)
            {
                //update database
                $this->ceh->where($where)->update('TRF_DIS', $item);
            }
            else
            {
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('TRF_DIS', $item);
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    //LOAD TRF_LEVEL
    public function loadTariffExtra($levelCode)
    {
        //LevelName, LaneID, OPR, PAYER, APPLY_DATE, EXPIRE_DATE, PAYMENT_TYPE, REF_RMK
        $this->ceh->select('OPR, PAYER_TYPE, PAYER, LevelName, PAYMENT_TYPE
                            , ts.rowguid, ts.TRANSIT_CD, tm.Transit_Name, DMETHOD_CD , TRF_CODE ,IX_CD, CLASS_Name
                            , CARGO_TYPE , Description, JOB_KIND, CNTR_JOB_TYPE, dm.CJModeName, CURRENCYID, UnitCode, ts.DayLevel
                            , IsLocal, AMT_F20 ,AMT_E20, AMT_F40 ,AMT_E40, AMT_F45 ,AMT_E45 ,AMT_NCNTR ,VAT ,TRF_STD_DESC
                            , REF_RMK ,INCLUDE_VAT, APPLY_DATE, EXPIRE_DATE
                            , ISNULL( jt.NameGate, ISNULL( jt.NameYard, jt.NameQuay ) ) AS JobName');
        // $this->ceh->join('TRF_CODES t','t.TRF_CODE = ts.TRF_CODE');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = ts.CNTR_JOB_TYPE AND dm.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CLASS_Mode cl', 'cl.CLASS_Code = ts.IX_CD AND cl.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('CARGO_TYPE ct', 'ct.Code = ts.CARGO_TYPE AND ct.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('ALLJOB_TYPE jt', 'jt.Code = ts.JOB_KIND AND jt.YARD_ID = ts.YARD_ID', 'left');
        $this->ceh->join('Transit_Mode tm', 'tm.Transit_CD = ts.TRANSIT_CD AND tm.YARD_ID = ts.YARD_ID', 'left');

        $stmt = $this->ceh->where('ts.LevelCode', $levelCode)->get('TRF_LEVEL ts');
        $stmt = $stmt->result_array();

        return $stmt;
    }

    //SAVE TRF_LEVEL
    public function saveExtraTariff($datas, $commons)
    { //commons chứa những thuộc tính chung của 1 list biểu cước (TÊN, Hãng KT, ...)
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $existItem = array();

            if (isset($item['TRF_STD_DESC'])) {
                $item['TRF_STD_DESC'] = UNICODE . $item['TRF_STD_DESC'];
            }

            $item['YARD_ID'] = $this->yard_id;

            $where = array(
                "DayLevel" => $item['DayLevel'],
                "OPR" => $commons['OPR'],
                "PAYER" => $commons['PAYER'],
                "PAYMENT_TYPE" => $commons['PAYMENT_TYPE'],
                "TRF_CODE" => $item["TRF_CODE"],
                "DMETHOD_CD" => $item["DMETHOD_CD"],
                "IX_CD" => $item["IX_CD"],
                "CARGO_TYPE" => $item["CARGO_TYPE"],
                "JOB_KIND" => $item["JOB_KIND"],
                "CNTR_JOB_TYPE" => $item["CNTR_JOB_TYPE"],
                "TRANSIT_CD" => $item["TRANSIT_CD"],
                "IsLocal" => $item["IsLocal"],
                "CURRENCYID" => $item["CURRENCYID"],
                "APPLY_DATE" => $commons['APPLY_DATE'],
                "EXPIRE_DATE" => $commons['EXPIRE_DATE'],
                "LaneID" => $commons['LaneID'],
                "YARD_ID" => $item["YARD_ID"]
            );

            $existsTRF = $this->ceh->select("COUNT(*) COUNT_TRF")->where($where)->get("TRF_LEVEL")->row_array();

            $item["APPLY_DATE"] = $commons['APPLY_DATE'];
            $item["EXPIRE_DATE"] = $commons['EXPIRE_DATE'];
            $item['REF_RMK'] = UNICODE.$commons['REF_RMK'];

            $item['LevelCode'] = $commons['LevelCode'];
            $item['LevelName'] = UNICODE.$commons['LevelName'];

            $item['OPR'] = $commons['OPR'];
            $item['PAYER'] = $commons['PAYER'];
            $item['PAYER_TYPE'] = $commons['PAYER_TYPE'];
            $item['PAYMENT_TYPE'] = $commons['PAYMENT_TYPE'];
            $item['LaneID'] = empty($commons['LaneID']) ? '*' : $commons['LaneID'];

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['ModifiedTime'] = date('Y-m-d H:i:s');

            if ($existsTRF["COUNT_TRF"] > 0) {
                //update database
                $this->ceh->where($where)->update('TRF_LEVEL', $item);
            } else {
                //insert database
                $item['CreatedTime'] = date('Y-m-d H:i:s');
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('TRF_LEVEL', $item);
            }
        }

        $this->ceh->trans_complete();

        if ($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        } else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return TRUE;
    }
}