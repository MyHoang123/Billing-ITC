<?php
defined('BASEPATH') OR exit('');

class report_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item("YARD_ID");
    }

    public function searchShip($arrStatus = '', $year = '', $name = ''){
        $this->ceh->select('vs.ShipKey, vv.ShipName, vs.ShipID, vs.ShipYear, vs.ShipVoy, vs.ImVoy, vs.ExVoy, vs.ETB, vs.ETD, vs.BerthDate, vs.YARD_CLOSE');
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

    public function getPayers($user = ''){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther ');
        if($user != '' && $user != 'admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function getUserId(){
        return $this->ceh->select("UserID")->where_in("UserGroupID", ["GroupAdmin"])->where("IsActive", "1")->get("SA_USERS")->result_array();
    }

    public function rptRevenue($fromdate = '', $todate = '', $jmode = '', $sys = ''){
        $this->ceh->select('TRF_CODE, TRF_DESC, SZ, SUM(QTY) SUMQTY, SUM(idd.TAMOUNT) SUMAMOUNT');
        $this->ceh->join('INV_DFT id', 'id.DRAFT_INV_NO = idd.DRAFT_INV_NO AND id.YARD_ID = idd.YARD_ID');
        $this->ceh->join('INV_VAT iv', 'iv.INV_NO = id.INV_NO AND iv.YARD_ID = id.YARD_ID');
        $this->ceh->join('DELIVERY_MODE dm', "dm.CJMode_CD = idd.CNTR_JOB_TYPE AND dm.YARD_ID = idd.YARD_ID", "left");
        $this->ceh->where('id.INV_NO IS NOT NULL');
        $this->ceh->where('id.INV_TYPE', 'CAS');
        $this->ceh->where('SZ IS NOT NULL');
        // $this->ceh->where('CNTR_JOB_TYPE IS NOT NULL');

        $this->ceh->where('idd.YARD_ID', $this->yard_id);

        if($fromdate != ''){
            $this->ceh->where('iv.INV_DATE >=', $this->funcs->dbDateTime($fromdate));
        }
        if($todate != ''){
            $this->ceh->where('iv.INV_DATE <=', $this->funcs->dbDateTime($todate));
        }
        if( $jmode != '' && $jmode != '*' ){
            switch ( $jmode ) {
                case 'NH':
                    $this->ceh->where('dm.isLoLo', '1');
                    break;
                case 'DH':
                    $this->ceh->where('dm.ischkCFS', '1');
                    break;
                case 'RH':
                    $this->ceh->where('dm.ischkCFS', '2');
                    break;
                case 'CC':
                    $this->ceh->where('dm.ischkCFS', '3');
                    break;
                case 'DVB':
                    $this->ceh->where('dm.IsYardSRV', '1');
                    break;
            }            
        }

        if($sys != ''){
            $operator = $sys == "EP" ? "=" : "!=";
            $this->ceh->where("LEFT(id.DRAFT_INV_NO, 2) ".$operator, "TT" );
        }

        $this->ceh->group_by(array("TRF_CODE", "TRF_DESC", "SZ"));

        $stmt = $this->ceh->get("INV_DFT_DTL idd")->result_array();

        $newarray = array();
        foreach ($stmt as $key=>$val ) {
            $newarray[$val["TRF_CODE"]][!isset($newarray[$val["TRF_CODE"]]) ? 0 : count($newarray[$val["TRF_CODE"]])] = $val;
        }

        if(count($newarray) == 0) return array();

        $results = array();
        foreach ($newarray as $k=>$item) {
            $colsz = array();
            foreach ($item as $n) {
                @$colsz[$n["SZ"]] += $n['SUMQTY'];
            }

            $tamout = array_sum(array_column($item, "SUMAMOUNT"));

            $item[0]["20"] = isset($colsz["20"]) ? (int)$colsz["20"] : 0;
            $item[0]["40"] = isset($colsz["40"]) ? (int)$colsz["40"] : 0;
            $item[0]["45"] = isset($colsz['45']) ? (int)$colsz["45"] : 0;
            $item[0]['SUMAMOUNT'] = $tamout;
            array_push($results, $item[0]);
        }

        return $results;
    }

    public function rptReleasedInv($fromdate = '', $todate = '', $jmode = '*', $paymentType = '*', $currency = '*', $sys = "", $adjust_type = ''){
        $this->ceh->select('id.DRAFT_INV_NO, DRAFT_INV_DATE, INV_PREFIX, iv.INV_NO, iv.INV_DATE, iv.AMOUNT, iv.VAT, iv.TAMOUNT, iv.AdjustType');
        $this->ceh->join('INV_DFT id', 'id.INV_NO = iv.INV_NO', 'left');
        $this->ceh->join('INV_DFT_DTL idd', "idd.DRAFT_INV_NO = id.DRAFT_INV_NO AND SEQ = (SELECT TOP 1 (SEQ) FROM INV_DFT_DTL WHERE DRAFT_INV_NO = id.DRAFT_INV_NO)", 'left');
        $this->ceh->where('iv.INV_NO IS NOT NULL');

        $this->ceh->where('iv.YARD_ID', $this->yard_id);

        //edit_pin_for_cont
        if( $sys != '' ){
            $operator = $sys == "EP" ? "=" : "!=";
            $pinPrefixEport = $this->config->item('PIN_PREFIX')['EPORT'];
            $this->ceh->group_start();
            $this->ceh->where("LEFT(iv.PinCode,1)".$operator, "A" );
            if( $sys == "EP" ) {
                $this->ceh->or_where("LEFT(iv.PinCode, ". strlen($pinPrefixEport) .") ".$operator, $pinPrefixEport );
            }
            else {
                $this->ceh->where("LEFT(iv.PinCode, ". strlen($pinPrefixEport) .") ".$operator, $pinPrefixEport );
            }
            $this->ceh->group_end();
        }

        if( $fromdate != '' ){
            $this->ceh->where('iv.INV_DATE >=', $this->funcs->dbDateTime($fromdate));
        }

        if( $todate != '' ){
            $this->ceh->where('iv.INV_DATE <=', $this->funcs->dbDateTime($todate));
        }

        if( $jmode != '' && $jmode != '*' ){
            $this->ceh->where('idd.CNTR_JOB_TYPE', $jmode);
        }

        if( $paymentType != '' && $paymentType != '*' ){
            $this->ceh->where('id.INV_TYPE', $paymentType);
        }

        if( $currency != '' && $currency != '*' ){
            $this->ceh->where('id.CURRENCYID', $currency);
        }

		if( $adjust_type != '' && $adjust_type != '*' ){
			if($adjust_type == "0") {
				$this->ceh->where('iv.AdjustType IS NULL');
			}
			else {
				$this->ceh->where('iv.AdjustType', $adjust_type);
			}
        }

        $stmt = $this->ceh->order_by("iv.INV_DATE", "ASC")->get("INV_VAT iv")->result_array();

        return $stmt;
    }

    public function rptRevenueByInvoices( $args = [] ){
        $this->ceh->select('iv.INV_NO, iv.INV_DATE, id.DRAFT_INV_NO, id.REF_NO, idd.TRF_CODE, idd.TRF_DESC AS TRF_STD_DESC
                            , idd.SZ, idd.QTY, idd.AMOUNT, idd.DIS_AMT, idd.VAT_RATE, idd.VAT, idd.TAMOUNT, iv.AdjustType, iv.AdjustInvNo
                            , iv.ACC_CD, cus.CusName, cus.VAT_CD, id.CreatedBy, idd.Remark REMARK');
        $this->ceh->join('INV_DFT id', 'id.INV_NO = iv.INV_NO AND id.YARD_ID = id.YARD_ID');
        $this->ceh->join('INV_DFT_DTL idd', 'idd.DRAFT_INV_NO = id.DRAFT_INV_NO AND idd.YARD_ID = id.YARD_ID');
        $this->ceh->join('CUSTOMERS cus', 'cus.CusID = iv.PAYER AND cus.YARD_ID = iv.YARD_ID');
        $this->ceh->where('iv.INV_NO IS NOT NULL');
        $this->ceh->where('iv.PAYMENT_STATUS !=', 'C');

        if( $args["fromDate"] != '' ){
            $this->ceh->where('iv.INV_DATE >=', $this->funcs->dbDateTime($args["fromDate"]));
        }
        if( $args["toDate"] != '' ){
            $this->ceh->where('iv.INV_DATE <=', $this->funcs->dbDateTime($args["toDate"]));
        }
        if( $args["shipKey"] != '' ){
            $this->ceh->where('iv.ShipKey',$args["shipKey"]);
        }
        if( $args["createdBy"] != '' ){
            $this->ceh->where('iv.CreatedBy',$args["createdBy"]);
        }
        if( $args["currencyId"] != '' ){
            $this->ceh->where('iv.CURRENCYID',$args["currencyId"]);
        }

        if( $args["payment_type"] != '' ){
            $this->ceh->where('iv.ACC_CD',$args["payment_type"]);
        }
		
		if( $args["adjust_type"] != '' ){
			if($adjust_type == "0") {
				$this->ceh->where('iv.AdjustType IS NULL');
			}
			else {
				$this->ceh->where('iv.AdjustType', $args["adjust_type"]);
			}
        }

        if( $args["sys"] != '' ){
            //edit_pin_for_cont
            $operator = $args["sys"] == "EP" ? "=" : "!=";
            $pinPrefixEport = $this->config->item('PIN_PREFIX')['EPORT'];
            $this->ceh->group_start();
            $this->ceh->where("LEFT(iv.PinCode,1)".$operator, "A" );
            if( $args["sys"] == "EP" ) {
                $this->ceh->or_where("LEFT(iv.PinCode, ". strlen($pinPrefixEport) .") ".$operator, $pinPrefixEport );
            }
            else {
                $this->ceh->where("LEFT(iv.PinCode, ". strlen($pinPrefixEport) .") ".$operator, $pinPrefixEport );
            }
            $this->ceh->group_end();
        }

        $this->ceh->where('iv.YARD_ID', $this->yard_id);

        $stmt = $this->ceh->order_by("iv.INV_DATE", "DESC")->get("INV_VAT iv");

        $stmt = $stmt->result_array();

        return $stmt;
    }

    public function rptCancelInvoices( $args = [] ){
        $this->ceh->select('iv.INV_NO, iv.INV_DATE, iv.PAYER, cus.CusName, iv.AMOUNT, iv.VAT, iv.TAMOUNT, iv.CreatedBy
                            ,iv.CancelBy, iv.CancelDate, iv.CancelRemark');
        $this->ceh->join('CUSTOMERS cus', 'cus.CusID = iv.PAYER AND cus.YARD_ID = iv.YARD_ID');
        $this->ceh->where('iv.INV_NO IS NOT NULL');
        $this->ceh->where('iv.PAYMENT_STATUS', 'C');
        $this->ceh->where('iv.YARD_ID', $this->yard_id);

        if( $args["fromDate"] != '' ){
            $this->ceh->where('iv.INV_DATE >=', $this->funcs->dbDateTime($args["fromDate"]));
        }
        if( $args["toDate"] != '' ){
            $this->ceh->where('iv.INV_DATE <=', $this->funcs->dbDateTime($args["toDate"]));
        }
        if( $args["paymentType"] != '' ){
            $this->ceh->where('iv.INV_TYPE', $args["paymentType"]);
        }
        
        //edit_pin_for_cont
        if( $args["sys"] != '' ){
            $operator = $args["sys"] == "EP" ? "=" : "!=";
            $pinPrefixEport = $this->config->item('PIN_PREFIX')['EPORT'];
            $this->ceh->group_start();
            $this->ceh->where("LEFT(iv.PinCode,1)".$operator, "A" );
            if( $args["sys"] == "EP" ) {
                $this->ceh->or_where("LEFT(iv.PinCode, ". strlen($pinPrefixEport) .") ".$operator, $pinPrefixEport );
            }
            else {
                $this->ceh->where("LEFT(iv.PinCode, ". strlen($pinPrefixEport) .") ".$operator, $pinPrefixEport );
            }
            $this->ceh->group_end();
        }

        $stmt = $this->ceh->order_by("iv.INV_DATE", "DESC")->get("INV_VAT iv");
        return $stmt->result_array();
    }

}