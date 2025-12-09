<?php
defined('BASEPATH') OR exit('');

class common_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item('YARD_ID');
    }

    public function freeDayConfigTemplate()
    {
        $this->ceh->select('PTNR_CODE, SHIPPER, IsLocal, APPLY_DATE
                            , CONVERT(varchar(17), EXPIRE_DATE, 103) AS EXPIRE_DATE, PAYMENT_TYPE');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('APPLY_DATE', 'DESC');
        $stmt = $this->ceh->get('FREE_DAYS');
        $stmt = $stmt->result_array();
        $result = array();
        foreach ($stmt as $item) {
            $ptemp = '';
            if (is_array($item)) {
                foreach ($item as $n) {
                    $ptemp .= ($n === null) ? "__" : $n . "__";
                }
            }
            array_push($result, substr($ptemp, 0, -2));
        }
        return array_unique($result);
    }

    public function loadFreeDayConfig($temp){
        $this->ceh->select('*');
        $temp = explode("__", $temp);
        $fwhere = array(
            "PTNR_CODE" => $temp[0] == "" ? null : $temp[0],
            "SHIPPER" => $temp[1],
            "IsLocal" => $temp[2],
            "APPLY_DATE" => $temp[3],
            "EXPIRE_DATE" => $temp[4] == '' ? null : $this->funcs->dbDateTime( $temp[4] ),
            "PAYMENT_TYPE" => $temp[5],
        );
        
        $stmt = $this->ceh->where($fwhere)->get('FREE_DAYS');
        $stmt = $stmt->result_array();

        return $stmt;
    }

    public function deleteFreeDayConfig($temp){
        $this->ceh->select('*');
        $temp = explode("__", $temp);
        $fwhere = array(
            "PTNR_CODE" => $temp[0] == "" ? null : $temp[0],
            "SHIPPER" => $temp[1],
            "IsLocal" => $temp[2],
            "APPLY_DATE" => $temp[3],
            "EXPIRE_DATE" => $temp[4] == '' ? null : $this->funcs->dbDateTime( $temp[4] ),
            "PAYMENT_TYPE" => $temp[5],
        );
        
        $stmt = $this->ceh->where($fwhere)->delete('FREE_DAYS');

        return TRUE;
    }

    public function saveFreeDayConfig($datas, $commons)
    { //commons chứa những thuộc tính chung của 1 list caau hinh (Hãng KT, kHACH HANG...)
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $item['YARD_ID'] = $this->yard_id;

            $where = array(
                "PTNR_CODE" => $commons['PTNR_CODE'],
                "SHIPPER" => $commons['SHIPPER'],
                "IsLocal" => $commons["IsLocal"],
                "APPLY_DATE" => $commons["APPLY_DATE"],
                "EXPIRE_DATE" => $commons["EXPIRE_DATE"] == "" ? null : $this->funcs->dbDateTime($commons["EXPIRE_DATE"]),
                "PAYMENT_TYPE" => $commons["PAYMENT_TYPE"],
                "CntrClass" => $item["CntrClass"],
                "FE" => $item["FE"],
                "CARGO_TYPE" => $item["CARGO_TYPE"],
                "YARD_ID" => $item["YARD_ID"]
            );

            $existsConfig = $this->ceh->select("COUNT(*) COUNT_CONFIG")->where($where)->get("FREE_DAYS")->row_array();

            foreach ($where as $k => $d) {
                $item[$k] = $d;
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if ($existsConfig["COUNT_CONFIG"] > 0) {
                //update database
                $this->ceh->where($where)->update('FREE_DAYS', $item);
            } else {
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('FREE_DAYS', $item);
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

        return $result;
    }

    public function tracking($col, $val){
        $this->ceh->select('cd.*, v.ShipName, dm.CJModeName, ISNULL(cd.cBlock,\'\')+\'-\'+ISNULL(cd.cBay,\'\')+\'-\'+ISNULL(cd.cRow,\'\')+\'-\'+ISNULL(cd.cTier,\'\') cLocation
                            , CASE WHEN cd.cTLHQ = 1 THEN N\'Thanh lý hải quan\' ELSE N\'Chưa thanh lý hải quan\' END AS cTLHQ
                            , ISNULL( CONVERT( varchar(10), CLASS) , \'\')+\'-\'+ISNULL(UNNO,\'\') AS ClassUno
                            , v.ShipName+\' / \'+cd.ImVoy+\' / \'+cd.ExVoy AS ShipInfo
                            , dm1.CJModeName AS CJModeNameOut, vs.ETB, vs.ETD
                            , cd.ImVoy+\'/\'+cd.ExVoy AS imexvoy');
        $this->ceh->join('DELIVERY_MODE AS dm', 'cd.CJMode_CD = dm.CJMode_CD AND cd.YARD_ID = dm.YARD_ID', 'left');
        $this->ceh->join('DELIVERY_MODE AS dm1', 'cd.CJMode_OUT_CD = dm1.CJMode_CD AND cd.YARD_ID = dm1.YARD_ID', 'left');
        $this->ceh->join('VESSELS as v', 'cd.ShipID = v.ShipID AND cd.YARD_ID = v.YARD_ID', 'left');
        $this->ceh->join('VESSEL_SCHEDULE as vs', 'cd.ShipKey = vs.ShipKey AND cd.YARD_ID = vs.YARD_ID', 'left');
        if($col == "CntrNo"){
            $this->ceh->where('cd.'.$col, $val);
            $this->ceh->order_by('cd.DateIn', 'DESC');
        }
        if($col == "BLNo"){
            $this->ceh->where_in('cd.CntrClass', array('1','4'));
            $this->ceh->where_in('cd.CMStatus', array('B','I','S','D'));
            $this->ceh->where('cd.BLNo', $val);
        }
        if($col == "BookingNo"){
            $this->ceh->where_in('cd.CntrClass', array('3','5'));
            $this->ceh->where_in('cd.CMStatus', array('B','I','S','O','D'));
            $this->ceh->where('cd.BookingNo', $val);
        }

        $this->ceh->where('cd.YARD_ID', $this->yard_id);

        $stmt = $this->ceh->get('CNTR_DETAILS AS cd');
        return $stmt->result_array();
    }

    //get function code
    public function getTariff(){
        $this->ceh->select('TRF_CODE ID, TRF_DESC NAME');
        $this->ceh->order_by('TRF_DESC', 'ASC');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $stmt = $this->ceh->get('TRF_CODES');
        return $stmt->result_array();
    }

    public function getOprs(){
        $inWhere = $this->ceh->select("OprID")->get_compiled_select("CNTR_SZTP_MAP", TRUE);
        
        $this->ceh->select('CusID, CusName');
        $this->ceh->where('IsOpr', 1);
        $this->ceh->where("CusID IN ($inWhere)");

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function getPayers( $user = '' ){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther ');
        if($user != '' && $user != 'Admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('IsOwner', 1);
        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }
    
    public function getSizeType( $opr = '' ){
        $this->ceh->select('OprID, LocalSZPT, ISO_SZTP');
        
        if($opr != ''){
            $this->ceh->where('OprID', $opr);
        }

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('LocalSZPT', 'ASC');
        $stmt = $this->ceh->get('CNTR_SZTP_MAP');
        return $stmt->result_array();
    }

    public function getShipKey_ID($ShipName = '', $ImVoy = '', $ExVoy = '') {
        $this->ceh->select('vs.ShipKey, vs.ShipID');
        $this->ceh->join('VESSELS As v', 'v.ShipID = vs.ShipID', 'left');
        $this->ceh->where('vs.ImVoy', $ImVoy)->where('vs.ExVoy', $ExVoy)->where('v.ShipName', $ShipName);
        $tmp = $this->ceh->get('VESSEL_SCHEDULE As vs')->row_array();
        return $tmp;
    }

    public function getPayers_Inv(){
        $this->ceh->distinct();
        $this->ceh->select('PAYER ID, CusName NAME');
        $this->ceh->join('CUSTOMERS c', 'c.CusID = i.PAYER');
        $this->ceh->where('PAYER IS NOT NULL');

        $this->ceh->where('i.YARD_ID', $this->yard_id);

        $this->ceh->order_by('c.CusName', 'ASC');
        $stmt = $this->ceh->get('INV_VAT i');
        return $stmt->result_array();
    }
    public function getPayers_InvDFT(){
        $this->ceh->distinct();
        $this->ceh->select('PAYER, CusName');
        $this->ceh->join('CUSTOMERS c', 'c.CusID = i.PAYER');
        $this->ceh->where('PAYER IS NOT NULL');

        $this->ceh->where('i.YARD_ID', $this->yard_id);

        $this->ceh->order_by('c.CusName', 'ASC');
        $stmt = $this->ceh->get('INV_DFT i');
        return $stmt->result_array();
    }

    public function getPlugConfig( $oprID ){
        $this->ceh->select('ROUNDING');

        $this->ceh->where('PTNR_CODE', $oprID );
        $this->ceh->where('YARD_ID', $this->yard_id );

        $stmt = $this->ceh->get('RF_TPLT')->row_array();
        return (is_array($stmt) && count($stmt) > 0) ? $stmt["ROUNDING"] : NULL;
    }

    public function searchShip($arrStatus = '', $year = '', $name = ''){
        $this->ceh->select('vs.ShipKey, vv.ShipName, vs.ShipID, vs.ShipYear, vs.ShipVoy, vs.ImVoy, vs.ExVoy, vs.ETB, vs.ETD, vs.BerthDate');
        $this->ceh->join('VESSELS vv', 'vv.ShipID = vs.ShipID');
        $this->ceh->where('vv.VESSEL_TYPE', 'V');
        $this->ceh->where('vs.YARD_ID', $this->yard_id);

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

    //load data
    public function loadVesselSchedule($fromdate = '', $todate = ''){
        $this->ceh->select('vv.ShipID, ShipName, ShipYear, ShipVoy, Opr_CD, CALL_NO, BERTH_NO, ALONGSIDE, ImVoy, ExVoy, ETA, ETB, ETW, ETD, ATA, ATW, ATD');
        $this->ceh->join('VESSELS vv','vs.ShipID = vv.ShipID');
        if($fromdate != '')
            $this->ceh->where('ETB >=', $fromdate);
        if($todate != '')
            $this->ceh->where('ETB <=', $todate);
        $this->ceh->order_by('ETB', 'DESC');

        $this->ceh->where('vs.YARD_ID', $this->yard_id);

        $stmt = $this->ceh->get('VESSEL_SCHEDULE vs');
        return $stmt->result_array();
    }

    public function loadCustomers($type = '', $id = '', $name = '', $taxcode = ''){
        $this->ceh->select('rowguid, CusID, CusName, SHORT_NAME, Address, VAT_CD, Tel, Fax, Email, EMAIL_DD, CusStatus
                            , IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther, IsActive, cHTTT_CHK, CusType');
        if($type != '')
            $this->ceh->where($type, 1);
        if($id != '')
            $this->ceh->where('CusID', $id);
        if($name != '')
            $this->ceh->like('CusName', $id);
        if($taxcode != '')
            $this->ceh->like('VAT_CD', $taxcode);

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function loadSizeTypeMapping($oprs = ''){
        if($oprs != '')
            $this->ceh->where('OprID', $oprs);

        $this->ceh->order_by('OprID', 'ASC');
        $stmt = $this->ceh->get('CNTR_SZTP_MAP');
        return $stmt->result_array();
    }

    public function loadCargoType(){
        $this->ceh->order_by('Code', 'ASC');
        $this->ceh->where('YARD_ID', $this->yard_id);
        $stmt = $this->ceh->get('CARGO_TYPE');
        return $stmt->result_array();
    }

    public function loadUnitCodes(){
        $this->ceh->order_by('UNIT_CODE', 'ASC');
        $this->ceh->where('YARD_ID', $this->yard_id);
        $stmt = $this->ceh->get('UNIT_CODES');
        return $stmt->result_array();
    }

    public function loadPaymentMethod(){
        $this->ceh->select('rowguid, ACC_CD, ACC_NO, ACC_TYPE, ACC_NAME');

        $stmt = $this->ceh->get('ACCOUNTS');
        return $stmt->result_array();
    }

    public function loadDeliveryMode(){
        $this->ceh->select("cl.CLASS_Name, dm.CntrClass, dm.CJMode_CD, dm.CJModeName, dm.isLoLo, dm.ischkCFS, dm.IsShipSRV, dm.IsYardSRV, dm.IsNonContSRV, dm.isClean, dm.ExtraMode");
        $this->ceh->join("CLASS_MODE cl", "cl.CLASS_Code = dm.CntrClass AND cl.YARD_ID = dm.YARD_ID", 'left');
        $this->ceh->where('dm.YARD_ID', $this->yard_id);

        $this->ceh->order_by('dm.CJMode_CD', 'ASC');

        $stmt = $this->ceh->get('DELIVERY_MODE dm');
        return $stmt->result_array();
    }

    public function loadExchangeRate(){
        $this->ceh->select('CURRENCYID, DATEOFRATE, RATE');

        $this->ceh->order_by('CURRENCYID', 'ASC');
        $stmt = $this->ceh->get('EXCHANGE_RATE');
        return $stmt->result_array();
    }

    public function loadMethodMode(){
        $this->ceh->select('MAPA_Code, MAPA_Name');

        $this->ceh->order_by('MAPA_Code', 'ASC');
        $stmt = $this->ceh->get('MENTHOD_MODE');
        return $stmt->result_array();
    }

    public function loadCntrClass(){
        $this->ceh->select('CLASS_Code, CLASS_Name');
        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->order_by('CLASS_Code', 'ASC');
        $stmt = $this->ceh->get('CLASS_MODE');
        return $stmt->result_array();
    }

    public function loadAllJob(){
        $this->ceh->select("Code, ISNULL(NameGate, '') + ISNULL(' / ' + NameYard, '') + ISNULL( ' / ' + NameQuay, '') AS Name");
        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->order_by('Code', 'ASC');
        $stmt = $this->ceh->get('ALLJOB_TYPE');
        return $stmt->result_array();
    }

    public function loadDMethod(){
        $this->ceh->select('DMethod_CD, DMethod_Name');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('DMethod_CD', 'ASC');

        $stmt = $this->ceh->get('DELIVERY_METHODS');
        return $stmt->result_array();
    }

    public function loadTransits(){
        $this->ceh->select('Transit_CD, Transit_Name');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('Transit_CD', 'ASC');

        $stmt = $this->ceh->get('Transit_Mode');
        return $stmt->result_array();
    }

    public function loadDMethodInServices(){
        $this->ceh->select('CJMode_CD, CJModeName, isLoLo, ischkCFS, IsYardSRV');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->group_start();
        $this->ceh->where('isLoLo', 1);
        $this->ceh->or_where('IsYardSRV', 1);
        $this->ceh->or_where('ischkCFS !=', 0);
        $this->ceh->group_end();

        $this->ceh->order_by('CJMode_CD', 'ASC');

        $stmt = $this->ceh->get('DELIVERY_MODE');
        return $stmt->result_array();
    }

    public function loadServiceMore(){
        $this->ceh->select('ORD_TYPE, CjMode_CD, chkPrint');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $stmt = $this->ceh->get('SRVMORE');
        return $stmt->result_array();
    }

    public function loadServiceForAttach(){
        $this->ceh->select('CJMode_CD, CJModeName');
        
        $this->ceh->group_start();
        $this->ceh->where('IsYardSRV', '1');
        $this->ceh->or_where('IsCFSSRV', '1');
        $this->ceh->or_where('IsNonContSRV', '1');
        $this->ceh->group_end();

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CJMode_CD', 'ASC');

        $stmt = $this->ceh->get('DELIVERY_MODE');
        return $stmt->result_array();
    }

    public function loadServiceTemplate(){
        $getOrdType = $this->ceh->select("ORD_TYPE")->where("TPLT_NM = i.TPLT_NM")
                                                    ->where( "YARD_ID", $this->yard_id )
                                                    ->limit(1)
                                                    ->get_compiled_select("ORD_TPLT", TRUE);

        $this->ceh->distinct();
        $this->ceh->select("i.TPLT_NM, i.TPLT_DESC, ($getOrdType) AS ORD_TYPE, i.CURRENCYID");

        $this->ceh->where('i.YARD_ID', $this->yard_id);

        $stmt = $this->ceh->get("INV_TPLT i");
        return $stmt->result_array();
    }

    public function loadInvTemplate(){
        $this->ceh->select("rowguid, TPLT_NM, TPLT_DESC, TRF_CODE, IX_CD, CARGO_TYPE, DMETHOD_CD, CNTR_JOB_TYPE, JOB_KIND, STD_ROW_ID, CURRENCYID");

        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->order_by( "TPLT_NM", "ASC" );
        $stmt = $this->ceh->get("INV_TPLT");
        return $stmt->result_array();
    }

    public function loadRFTplt(){
        $this->ceh->select("rowguid, PTNR_CODE, ROUNDING, PAYMENT_TYPE");

        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->order_by( "PTNR_CODE", "ASC" );
        $stmt = $this->ceh->get("RF_TPLT");
        return $stmt->result_array();
    }

    public function loadEir($oprs = array()){
        $this->ceh->select('CntrNo, EIRNo, IssueDate, ExpDate, ExpPluginDate, bXNVC, OprID, LocalSZPT, ISO_SZTP, CARGO_TYPE, Status, ShipID, ImVoy, ExVoy
                            , CJMode_CD, DMethod_CD, TruckNo, CMDWeight, BLNo, BookingNo, SealNo, SealNo1, SealNo2, RetLocation, IsLocal, CusName, Note, CreatedBy
                            , DRAFT_INV_NO, InvNo');
        if($oprs['FROM_DATE'] != '')
            $this->ceh->where('IssueDate >=', $oprs['FROM_DATE']);
        if($oprs['TO_DATE'] != '')
            $this->ceh->where('IssueDate <=', $oprs['TO_DATE']);
        if($oprs['OprID'] != '')
            $this->ceh->where('OprID', $oprs['OprID']);
        if($oprs['PAYMENT_TYPE'] != '')
            $this->ceh->where('PAYMENT_TYPE', $oprs['PAYMENT_TYPE']);
        if($oprs['CntrNo'] != '')
            $this->ceh->like('CntrNo', $oprs['CntrNo']);
        if($oprs['ShipKey'] != '')
            $this->ceh->where('ShipKey', $oprs['ShipKey']);
        if($oprs['bXNVC'] != '')
            $this->ceh->where('bXNVC <= ', $oprs['bXNVC']);
        if(isset($oprs['CJMode_CD']) && count($oprs['CJMode_CD']) > 0)
            $this->ceh->where_in('CJMode_CD', $oprs['CJMode_CD']);

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('IssueDate', 'DESC');
        $stmt = $this->ceh->get('EIR');
        return $stmt->result_array();
    }

    public function loadInvDraff($wheres = array()){
        $this->ceh->distinct();
        $this->ceh->select('inv_dtl.rowguid, inv.INV_DATE, inv.ShipID, inv.ShipYear, inv.ShipVoy, cc.Opr_CD as VSL_OWNER, inv.INV_NO, inv.OPR, inv.PAYER, m.CusName, inv_dft.REF_NO
				                , inv_dtl.DRAFT_INV_NO, inv_dtl.TRF_CODE, inv_dtl.TRF_DESC, inv_dtl.CARGO_TYPE, inv_dtl.FE, inv_dtl.SZ, inv_dtl.QTY, inv_dtl.Remark
		                        , inv_dtl.AMOUNT as AMOUNT , inv_dtl.VAT_RATE as VAT_RATE,inv_dtl.VAT as VAT, inv.DISCOUNT_AMT, inv.DISCOUNT_VAT, inv_dtl.TAMOUNT AS TAMOUNT');
        $this->ceh->join('VESSEL_SCHEDULE cc', 'inv.ShipKey=cc.ShipKey', 'left');
        $this->ceh->join('CUSTOMERS m', 'inv.payer=m.CusID', 'left');
        $this->ceh->join('INV_DFT inv_dft', 'inv.INV_NO=inv_dft.INV_NO', 'left');
        $this->ceh->join('INV_DFT_DTL inv_dtl', 'inv_dft.DRAFT_INV_NO=inv_dtl.DRAFT_INV_NO', 'left');
        $this->ceh->where('inv_dtl.DRAFT_INV_NO IS NOT NULL');

        if($wheres['FROM_DATE'] != '')
            $this->ceh->where('inv.INV_DATE >=', $wheres['FROM_DATE']);

        if($wheres['TO_DATE'] != '')
            $this->ceh->where('inv.INV_DATE <=', $wheres['TO_DATE']);

        if($wheres['OprID'] != '')
            $this->ceh->where('inv.OPR', $wheres['OprID']);

        if(isset($wheres['PAYMENT_STATUS']) && count($wheres['PAYMENT_STATUS']) > 0)
            $this->ceh->where_in('inv.PAYMENT_STATUS', $wheres['PAYMENT_STATUS']);

        if($wheres['CreatedBy'] != '')
            $this->ceh->like('inv.CreatedBy', $wheres['CreatedBy']);

        if($wheres['CusID'] != '')
            $this->ceh->where('inv.PAYER', $wheres['CusID']);

        if(isset($wheres['INV_TYPE']) && count($wheres['INV_TYPE']) > 0)
            $this->ceh->where_in('inv.INV_TYPE', $wheres['INV_TYPE']);

        if(isset($wheres['CURRENCYID']) && count($wheres['CURRENCYID']) > 0)
            $this->ceh->where_in('inv.CURRENCYID', $wheres['CURRENCYID']);

        $this->ceh->where('inv.YARD_ID', $this->yard_id);

        $this->ceh->order_by('inv.INV_DATE', 'DESC');
        $stmt = $this->ceh->get('INV_VAT inv');
        return $stmt->result_array();
    }

    public function loadInv($wheres = array()){
        $this->ceh->select('a.DISCOUNT_AMT,a.DISCOUNT_VAT,a.inv_no , c.VAT_RATE,a.inv_date,a.ShipID,a.ShipYear,a.ShipVoy, a.payer,m.VAT_CD, a.CreatedBy, a.OPR
                            , a.REF_NO, a.Remark,sum(c.amount) as amount,c.TRF_CODE ,sum(c.vat) as vat,sum(c.tamount) as tamount,c.dis_amt, b.draft_inv_no
                            , b.draft_inv_date, m.CusName,c.TRF_DESC');
        $this->ceh->join('CUSTOMERS m', 'a.payer=m.CusID', 'left');
        $this->ceh->join('INV_DFT b', 'a.inv_no=b.inv_no');
        $this->ceh->join('INV_DFT_DTL c', 'b.draft_inv_no=c.draft_inv_no');
        $this->ceh->where('a.INV_TYPE', 'CAS');
        $this->ceh->where('a.PAYMENT_STATUS', 'Y');

        if($wheres['FROM_DATE'] != '')
            $this->ceh->where('a.INV_DATE >=', $wheres['FROM_DATE']);

        if($wheres['TO_DATE'] != '')
            $this->ceh->where('a.INV_DATE <=', $wheres['TO_DATE']);

        if($wheres['ShipKey'] != '')
            $this->ceh->where('a.ShipKey', $wheres['ShipKey']);

        if($wheres['PAYER'] != '')
            $this->ceh->where('a.PAYER', $wheres['PAYER']);

        if($wheres['CreatedBy'] != '')
            $this->ceh->like('a.CreatedBy', $wheres['CreatedBy']);

        if($wheres['TRF_CODE'] != '')
            $this->ceh->where('c.TRF_CODE', $wheres['TRF_CODE']);

        if(isset($wheres['CURRENCYID']) && count($wheres['CURRENCYID']) > 0)
            $this->ceh->where_in('a.CURRENCYID', $wheres['CURRENCYID']);

        $this->ceh->group_by(array('a.DISCOUNT_AMT','a.DISCOUNT_VAT','a.inv_no ',' c.VAT_RATE','a.inv_date','a.ShipID','a.ShipYear'
                                    ,'a.ShipVoy',' a.payer','m.VAT_CD',' a.CreatedBy',' a.OPR',' a.REF_NO','a.Remark'
                                    ,'c.TRF_CODE','c.dis_amt',' b.draft_inv_no',' b.draft_inv_date','  m.CusName','c.TRF_DESC'));

        $this->ceh->where('a.YARD_ID', $this->yard_id);

        $this->ceh->order_by('a.inv_date','ASC');
        $this->ceh->order_by('a.inv_no','ASC');
        $this->ceh->order_by('a.payer', 'ASC');

        $stmt = $this->ceh->get('INV_VAT a');
        return $stmt->result_array();
    }

    //SAVE DATA
    public function saveCustomers($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $existItem = array();

            if(isset($item['CusName'])){
                $item['CusName'] = UNICODE.$item['CusName'];
            }

            if(isset($item['SHORT_NAME'])){
                $item['SHORT_NAME'] = UNICODE.$item['SHORT_NAME'];
            }

            if(isset($item['Address'])){
                $item['Address'] = UNICODE.$item['Address'];
            }

            if($rguid != ''){
                $stmt =  $this->ceh->where('rowguid', $rguid)->get('CUSTOMERS');
                $existItem = $stmt->row_array();
            }

            $item['YARD_ID'] = $this->yard_id;

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if(count($existItem) > 0)
            {
                //update database
                $this->ceh->where('rowguid', $rguid)->update('CUSTOMERS', $item);
            }
            else
            {
                $checkitem = $this->ceh->select("rowguid")->where('CusID', $item['CusID'])
                                                            ->where('YARD_ID', $item['YARD_ID'])
                                                            ->limit(1)->get('CUSTOMERS')->row_array();
                if(is_array($checkitem) && count($checkitem) > 0){
                    $this->ceh->where('rowguid', $checkitem["rowguid"])->update('CUSTOMERS', $checkitem);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('CUSTOMERS', $item);
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

    public function savePayerQuickly( $taxCode, $name, $address, &$outputMsg ){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $exitItem = $this->ceh->select('rowguid')->where( "VAT_CD", $taxCode )
                                                ->where( "CusType", "M" )
                                                ->where( "YARD_ID", $this->yard_id )
                                                ->limit(1)->get("CUSTOMERS")->row_array();
        if( is_array( $exitItem ) && count( $exitItem ) > 0 )
        {
            $updateItem = array(
                "CusName" => UNICODE.$name,
                "Address" => UNICODE.$address,
                "ModifiedBy" => $this->session->userdata("UserID"),
                'update_time' =>  date('Y-m-d H:i:s')
            );
            
            $this->ceh->where('rowguid', $exitItem["rowguid"])->update('CUSTOMERS', $updateItem);

            $outputMsg = "edit";
        }else
        {
            $newItem = array(
                'CusID' => $taxCode,
                'VAT_CD' => $taxCode,
                'CusName' => UNICODE.$name,
                'CusType' => 'M',
                'Address' => UNICODE.$address,
                'IsOwner' => 1,
                'IsActive' => 1,
                'YARD_ID' => $this->yard_id,
                'ModifiedBy' => $this->session->userdata("UserID"),
                'CreatedBy' => $this->session->userdata("UserID"),
                'update_time' =>  date('Y-m-d H:i:s')
            );

            $this->ceh->insert('CUSTOMERS', $newItem);
            $outputMsg = "add";
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            $outputMsg = $this->ceh->_error_message();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    // payment method save data function
    public function savePaymentMethod($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $existItem = array();

            if(isset($item['ACC_NO'])){
                $item['ACC_NO'] = UNICODE.$item['ACC_NO'];
            }

            if(isset($item['ACC_NAME'])){
                $item['ACC_NAME'] = UNICODE.$item['ACC_NAME'];
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            $checkitem = $this->ceh->select("rowguid")
                                    ->where('ACC_CD', $item['ACC_CD'])
                                    ->limit(1)
                                    ->get('ACCOUNTS')->result_array();
            if(count($checkitem) > 0){
                $this->ceh->where('rowguid', $checkitem["rowguid"])->update('ACCOUNTS', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('ACCOUNTS', $item);
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
    } // ------------end payment method save data function

    // payment method delete function
    public function deletePaymentMethod($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                        ->limit(1)
                                                        ->where('ACC_CD', $item)
                                                        ->get('INV_VAT')->row_array();
            if ($checkInv['COUNTEXIST'] == 0) {
                $this->ceh->where('ACC_CD', $item)
                            ->delete('ACCOUNTS');

                array_push($result['success'], 'Xóa thành công:'.$item);
            }else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh hóa đơn:'.$item);
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

    //save unit_codes
    public function saveUnitCode($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['UNIT_NM'])){
                $item['UNIT_NM'] = UNICODE.$item['UNIT_NM'];
            }

            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid")->where('UNIT_CODE', $item['UNIT_CODE'])
                                                        ->limit(1)
                                                        ->get('UNIT_CODES')->row_array();
            if( is_array($checkItem) && count($checkItem) > 0){
                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('UNIT_CODES', $item);
            }else{
                //insert database
                $item['YARD_ID'] = $this->yard_id;

                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['insert_time'] = $item['update_time'];
                $this->ceh->insert('UNIT_CODES', $item);
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
    } // ------------end unit codes save data function

    // delete unit codes
    public function deleteUnitCode($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                        ->limit(1)
                                                        ->where('INV_UNIT', $item)
                                                        ->get('INV_DFT_DTL')->row_array();

            if ($checkInv['COUNTEXIST'] == 0) {
                $this->ceh->where('UNIT_CODE', $item)
                            ->delete('UNIT_CODES');

                array_push($result['success'], 'Xóa thành công mã ĐVT: '.$item);
            }else{
                array_push($result['error'], "Không thể xóa - [$item] đã phát sinh hóa đơn!");
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

    //save delivery mode
    public function saveDeliveryModes($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['CJModeName'])){
                $item['CJModeName'] = UNICODE.$item['CJModeName'];
            }

            if( isset($item['rowguid']) ){
                unset($item['rowguid']);
            }

            $item['IsImport'] = $item['IsExport'] = $item['IsYard'] = $item['ExecTime'] = 0;

            if( !isset( $item['ischkCFS'] ) || empty( $item['ischkCFS'] ) ){
                $item['ischkCFS'] == $item['IsCFSSRV'] = 0;
            }else{
                $item['IsCFSSRV'] = 1;
            }

            if( empty($item['ExtraMode']) ){
                $item['ExtraMode'] = 0;
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid")->where('CJMode_CD', $item['CJMode_CD'])
                                                        ->limit(1)
                                                        ->get('DELIVERY_MODE')->row_array();
            if( is_array( $checkItem ) && count( $checkItem ) > 0){
                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('DELIVERY_MODE', $item);
            }else{
                //insert database
                $item['YARD_ID'] = $this->yard_id;
                
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['insert_time'] = $item['update_time'];
                $this->ceh->insert('DELIVERY_MODE', $item);
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
    } // ------------end delivery mode save data function

    // delete delivery mode
    public function deleteDeliveryModes($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                        ->limit(1)
                                                        ->where('CJMode_CD', $item)
                                                        ->get('CNTR_DETAILS')->row_array();

            if ($checkInv['COUNTEXIST'] == 0) {
                $this->ceh->where('CJMode_CD', $item)
                            ->delete('DELIVERY_MODE');

                array_push($result['success'], 'Xóa thành công mã Dịch Vụ: '.$item);
            }else{
                array_push($result['error'], "Không thể xóa - [$item] đã phát sinh dữ liệu!");
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

    //save exchange rate
    public function saveExchangeRate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['DATEOFRATE'])){
                $item['DATEOFRATE'] = $this->funcs->dbDateTime($item['DATEOFRATE']);
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid")
                                                    ->where('CURRENCYID', $item['CURRENCYID'])
                                                    ->limit(1)
                                                    ->get('EXCHANGE_RATE')->row_array();

            if(count($checkItem) > 0){
                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('EXCHANGE_RATE', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['insert_time'] = $item['update_time'];
                $this->ceh->insert('EXCHANGE_RATE', $item);
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
    } // ------------end exchange rate save data function

    // delete exchange rate
    public function deleteExchangeRate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                    ->limit(1)
                                                    ->where('CURRENCYID', $item)
                                                    ->get('INV_DFT')->row_array();

            if ($checkInv['COUNTEXIST'] == 0) {
                $this->ceh->where('CURRENCYID', $item)
                            ->delete('EXCHANGE_RATE');

                array_push($result['success'], 'Xóa thành công: '.$item);
            }else{
                array_push($result['error'], "Không thể xóa - [$item] đã phát sinh tính cước!");
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

    public function saveServiceAddon($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item["SRM_NO"] = $item["ORD_TYPE"]."_".$item["CjMode_CD"];

            if($item["Select"] == "1"){

                $item['YARD_ID'] = $this->yard_id;

                $item['ModifiedBy'] = $this->session->userdata("UserID");
                $item['update_time'] = date('Y-m-d H:i:s');

                $checkItem = $this->ceh->select("rowguid")->where("ORD_TYPE", $item["ORD_TYPE"])
                                                            ->where("CjMode_CD", $item["CjMode_CD"])
                                                            ->where('YARD_ID', $item['YARD_ID'])
                                                            ->limit(1)
                                                            ->get("SRVMORE")->row_array();
                if(count($checkItem) > 0){
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update("SRVMORE", array("chkPrint" => $item["chkPrint"]));
                }else{
                    unset($item["Select"]);
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $item['insert_time'] = $item['update_time'];
                    $this->ceh->insert('SRVMORE', $item);
                }
            }else{
                $this->ceh->where("ORD_TYPE", $item["ORD_TYPE"])
                            ->where("CjMode_CD", $item["CjMode_CD"])
                            ->where('YARD_ID', $this->yard_id)
                            ->delete("SRVMORE");
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

    public function saveTRFTempConfig($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item["ORD_TPLT_NO"] = $item["ORD_TYPE"]."_".$item["TPLT_NM"];

            if($item["IsChecked"] == "1"){

                $item['YARD_ID'] = $this->yard_id;

                $item['ModifiedBy'] = $this->session->userdata("UserID");
                $item['update_time'] = date('Y-m-d H:i:s');

                $checkItem = $this->ceh->select("rowguid")->where("ORD_TYPE", $item["ORD_TYPE"])
                                                            ->where("TPLT_NM", $item["TPLT_NM"])
                                                            ->where('YARD_ID', $item['YARD_ID'])
                                                            ->limit(1)
                                                            ->get("ORD_TPLT")->row_array();

                if(count($checkItem) == 0){
                    unset($item["IsChecked"]);
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'] = $this->session->userdata("UserID");
                    $item['insert_time'] = $item['update_time'] = date('Y-m-d H:i:s');
                    $this->ceh->insert('ORD_TPLT', $item);
                }
            }else{
                $this->ceh->where("ORD_TYPE", $item["ORD_TYPE"])
                            ->where("TPLT_NM", $item["TPLT_NM"])
                            ->where('YARD_ID', $this->yard_id)
                            ->delete("ORD_TPLT");
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

    //save RF_TPLT
    public function saveRF_TPLT($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if( isset($item['rowguid']) ){
                unset($item['rowguid']);
            }

            $item["LANE_CD"] = $item["VSL_CD"] = $item["SHIPPER"] = $item["CARGO_TYPE"] = $item["APPLY_DATE"] = $item["IsLocal"]
            = $item["RF_TYPE"] = $item["TIMEPLUGIN"] = $item["TIMEPLUGOUT"] = '*';

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid")->where('PTNR_CODE', $item['PTNR_CODE'])
                                                        ->limit(1)
                                                        ->get('RF_TPLT')->row_array();
            if($checkItem !== NULL){
                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('RF_TPLT', $item);
            }else{
                //insert database
                $item['YARD_ID'] = $this->yard_id;

                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['insert_time'] = $item['update_time'];
                $this->ceh->insert('RF_TPLT', $item);
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
    } // ------------end unit codes save data function

    // delete RF_TPLT
    public function deleteRF_TPLT($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('PTNR_CODE', $item)
                            ->delete('RF_TPLT');

            array_push( $result['success'], 'Xóa thành công cấu hình cho hãng khai thác: ['.$item .']');
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

}