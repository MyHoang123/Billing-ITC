<?php
defined('BASEPATH') OR exit('');

class Credit_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = "";

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item("YARD_ID");
    }

    public function generate_PinCode($digits = 8){
        $chk = array();

        do{
            $nb = rand(1, pow(10, $digits)-1);
            $nb = substr("0000000".$nb, -8);
            $chk = $this->ceh->select('COUNT(*) CountID')
                                ->where('PinCode', $nb)
                                ->where('YARD_ID', $this->yard_id)
                                ->limit(1)
                                ->get('INV_VAT')->row_array();
        }while($chk['CountID'] > 0);

        return $nb;
    }

    public function generatePinCode($prefix = '', $digits = 5)
    {
        if ($prefix == '') {
            $prefix = $this->config->item('PIN_PREFIX')['BL_CRE'];
        }

        $yearmonth = date('ym');
        $file = APPPATH . "/cache/pins_billing_$prefix" . date('Y') . ".txt";
        $fp = fopen($file, "a+");

        do {
            $getLock = flock($fp, LOCK_EX | LOCK_NB);
            if ($getLock) {
                $filesz = filesize($file);
                $content = $filesz > 0 ? fread($fp, $filesz) : $this->retrieveInMonthPinCodes($prefix, $yearmonth, $digits);
                $temps = !empty($content) ? explode(':', $content) : array();
                $isDuplicate = true;
                do {
                    $randomNum = rand(1, pow(10, $digits) - 1);
                    if (count($temps) > 0 && $temps[0] == $yearmonth) { //trong ngay
                        $checkpins = array();
                        if (isset($temps[1]) && !empty($temps[1]) && $temps[1] !== '') {
                            $listOfPin = explode('|', $temps[1]);
                            $checkpins = array_filter($listOfPin, function ($p) {
                                return !empty($p) && $p !== '';
                            });
                        }

                        $duplicatePin = array_filter($checkpins, function ($p) use ($randomNum) {
                            return (int)trim($p) === (int)$randomNum;
                        });
                        $isDuplicate = count($duplicatePin) > 0;
                    } else { //sang ngay moi
                        $content = "$yearmonth:";
                        $isDuplicate = false;
                    }
                } while ($isDuplicate);

                $content .= "$randomNum|";
                //truncate file
                ftruncate($fp, 0);
                //save to file
                fwrite($fp, $content);
                //unlock file
                flock($fp, LOCK_UN);
            }
        } while (!$getLock);

        fclose($fp);

        $result = "$prefix$yearmonth" . substr("00000000000000" . $randomNum, -$digits);
        return $result;
    }

    public function retrieveInMonthPinCodes($prefix, $yearmonth, $digits)
    {
        //[ITC2][2106][00000]
        $lenOfYearMonth = strlen($yearmonth);
        $lenOfPrefix = strlen($prefix);
        $startSubStrPin =  $lenOfPrefix + $lenOfYearMonth + 1;
        $startSubStrYM = $lenOfPrefix + 1;

        $query = <<<EOT
        select substring(pincode, $startSubStrPin, $digits) AS PIN from eir
            where substring(pincode, 1, $lenOfPrefix) = ?
            and substring(pincode, $startSubStrYM, $lenOfYearMonth) = ?
            and right(pincode, 3) = '001' and yard_id = ?
        union
        select substring(pincode, $startSubStrPin, $digits) AS PIN from srv_odr
            where substring(pincode, 1, $lenOfPrefix) = ?
            and substring(pincode, $startSubStrYM, $lenOfYearMonth) = ?
            and right(pincode, 3) = '001' and yard_id = ?
EOT;
        $params = array(
            $prefix, $yearmonth, $this->yard_id,
            $prefix, $yearmonth, $this->yard_id
        );

        $temp = $this->ceh->query($query, $params)->result_array();
        if (count($temp) == 0) {
            return '';
        }

        $pinStr = implode('|', array_unique(array_column($temp, 'PIN')));
        return $yearmonth . ":$pinStr|";
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

    public function getPayers($user = ''){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther, Email, EMAIL_DD');
        if($user != '' && $user != 'Admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function getOpr( $args = array() ){
        $this->ceh->select( "CusID, CusName" );
        $this->ceh->where( "IsOpr", 1 );
        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function getDMethods( $args = array() ){
        $this->ceh->select( "DMethod_CD, DMethod_Name" );
        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('DMethod_Name', 'ASC');
        $stmt = $this->ceh->get('DELIVERY_METHODS');
        return $stmt->result_array();
    }

    public function getTransits( $args = array() ){
        $this->ceh->select( "Transit_CD, Transit_Name" );
        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('Transit_Name', 'ASC');
        $stmt = $this->ceh->get('Transit_Mode');
        return $stmt->result_array();
    }

    public function getYardJobs( $args = array() ){
        $this->ceh->select( "CJMode_CD, CJModeName, IsYardSRV, ischkCFS" );
        $this->ceh->where('YARD_ID', $this->yard_id);
        $this->ceh->group_start();
        $this->ceh->where( 'IsYardSRV', '1' );
        $this->ceh->or_where_in( 'ischkCFS', array('1', '2') );
        $this->ceh->group_end();

        $this->ceh->order_by('CJMode_CD', 'ASC');
        $stmt = $this->ceh->get('DELIVERY_MODE');
        return $stmt->result_array();
    }

    public function getCntrClass( $args = array() ){
        $this->ceh->select( "CLASS_Code, CLASS_Name" );
        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CLASS_Code', 'ASC');
        $stmt = $this->ceh->get('CLASS_MODE');
        return $stmt->result_array();
    }

    public function getInvTemp(){
        return $this->ceh->distinct()->select( "TPLT_NM, TPLT_DESC, CURRENCYID" )
                                                ->get("INV_TPLT")
                                                ->result_array();
    }

    public function getExchangeRate( $currency ){
        $maxDateOfRate = $this->ceh->select("MAX(DATEOFRATE)")
                                    ->where( "YARD_ID", $this->yard_id )
                                    ->get_compiled_select( "EXCHANGE_RATE", TRUE );
        $this->ceh->select( "RATE" );
        $this->ceh->where( "CURRENCYID", $currency );
        $this->ceh->where( "YARD_ID", $this->yard_id );
        $this->ceh->where( "DATEOFRATE = (".$maxDateOfRate.")" );
        $this->ceh->where("YARD_ID", $this->yard_id);
        $stmt = $this->ceh->get( "EXCHANGE_RATE" );
        $stmt = $stmt->row_array();

        return count( $stmt ) > 0 ? floatval( $stmt["RATE"] ) : 1;
    }

    public function loadShipTotal( $args = array() ){

        $this->ceh->select( "QJ.rowguid, QJ.ShipKey, QJ.CntrClass, QJ.Job_Type_RF, QJ.MASTER_ROWGUID
                                , QJ.ShipID, QJ.ShipYear, QJ.ShipVoy
                                , QJ.CntrNo, QJ.OprID, QJ.ISO_SZTP, QJ.Status, QJ.BILL_CHK
                                , CASE WHEN QJ.Job_Type_RF IN ('SS', 'SD') THEN TR.CARGO_TYPE
                                       ELSE CD.CARGO_TYPE END AS CARGO_TYPE
                                , CD.IsLocal
                                , QJ.Transist
                                , CASE WHEN QJ.CntrClass = 1 THEN QJ.CJMODE_CD WHEN QJ.CntrClass = 3 THEN QJ.CJMODE_OUT_CD ELSE '' END AS CJMode_CD
                                , QJ.CJMODE_OUT_CD
                                , CASE WHEN QJ.Job_Type_RF IN ('SS', 'SD') THEN TR.DMethod_CD
                                        WHEN QJ.CntrClass = 1 THEN CD.DMethod_CD
                                        WHEN QJ.CntrClass = 3 THEN CD.DMethod_OUT_CD
                                        ELSE ''
                                        END AS DMethod_CD
                                , CL.CLASS_Name
                                , CG.Description
                                , TM.Transit_Name
                                , ISNULL( JB.NameGate, ISNULL( JB.NameYard, JB.NameQuay ) ) AS JobName");
        $this->ceh->join("CNTR_DETAILS AS CD", "CD.ShipKey=QJ.ShipKey AND CD.CntrNo=QJ.CntrNo AND CD.rowguid=QJ.MASTER_ROWGUID AND CD.YARD_ID=QJ.YARD_ID", "LEFT");
        $this->ceh->join("CTNR_THRU AS TR", "TR.ShipKey = QJ.ShipKey AND TR.CntrNo = QJ.CntrNo AND CD.YARD_ID = QJ.YARD_ID", "LEFT");
        $this->ceh->join("CLASS_MODE AS CL", "CL.CLASS_Code = QJ.CntrClass AND CL.YARD_ID = QJ.YARD_ID", "LEFT");
        $this->ceh->join("CARGO_TYPE AS CG", "CG.Code = CD.CARGO_TYPE AND CG.YARD_ID = CD.YARD_ID", "LEFT");
        $this->ceh->join("Transit_Mode AS TM", "TM.Transit_CD = QJ.Transist AND TM.YARD_ID = QJ.YARD_ID", "LEFT");
        $this->ceh->join("ALLJOB_TYPE AS JB", "JB.Code = QJ.Job_Type_RF AND JB.YARD_ID = QJ.YARD_ID", "LEFT");
        $this->ceh->where( "QJ.Fdate IS NOT NULL" );
        $this->ceh->where( "QJ.PAYMENT_TYPE", 'C' );

        $this->ceh->where( "QJ.YARD_ID", $this->yard_id);

        //where by shipkey
        if( isset( $args["shipKey"] ) && $args["shipKey"] != "" )
        {
            $this->ceh->where( "QJ.ShipKey", $args["shipKey"] );
        }

        //where by cntrClass
        if( isset( $args["cntrClass"] ) && $args["cntrClass"] != "" )
        {
            $this->ceh->where( "QJ.CntrClass", $args["cntrClass"] );
        }

        //where by dmethod
        if( isset( $args["dmethod"] ) && $args["dmethod"] != "" )
        {
            $this->ceh->where( "CD.DMethod_CD", $args["dmethod"] );
        }

        //where by isLocal
        if( isset( $args["isLocal"] ) && $args["isLocal"] != "" )
        {
            $this->ceh->where( "CD.IsLocal", $args["isLocal"] );
        }

        //where by transit
        if( isset( $args["transit"] ) && $args["transit"] != "" )
        {
            $this->ceh->where( "QJ.Transist", $args["transit"] );
        }

        //where by status
        if( isset( $args["status"] ) && $args["status"] != "" )
        {
            $this->ceh->where( "QJ.Status", $args["status"] );
        }

        //where by oprs
        if( isset( $args["oprs"] ) && $args["oprs"] != '' )
        {
            $this->ceh->where( "QJ.OprID", $args["oprs"] );
        }

        //where by oprs
        if( isset( $args["cjmode"] ) && $args["cjmode"] != '' )
        {
            $this->ceh->where_in("CASE WHEN QJ.CntrClass = '1' THEN QJ.CJMODE_CD WHEN QJ.CntrClass = '3' THEN QJ.CJMODE_OUT_CD END", $args["cjmode"]);
        }

        $this->ceh->order_by("QJ.Fdate");

        $stmt = $this->ceh->get( "QUAYJOB AS QJ" );
        $stmt = $stmt->result_array();

        $newarray = array();

        foreach ($stmt as $k => $v ) {
            $newarray[ $v[ "OprID" ]."-".$v[ "Job_Type_RF" ]."-".$v[ "CntrClass" ] ][ $k ] = $v;
        }

        $result = array();
        foreach ($newarray as $key => $value) {
            if( is_array( $value ) ){
                $bySize = array(
                    "OprID" => array_column($value, "OprID")[0],
                    "JobName" => array_column($value, "JobName")[0],
                    "CLASS_Name" => array_column($value, "CLASS_Name")[0],
                    "SZ_20F" => 0,
                    "SZ_40F" => 0,
                    "SZ_45F" => 0,
                    "SZ_20E" => 0,
                    "SZ_40E" => 0,
                    "SZ_45E" => 0
                );
                
                foreach ($value as $n => $m) {
                    $size = "SZ_".$this->getContSize( $m["ISO_SZTP"] ).$m["Status"];
                    if ( $bySize[ $size ] != 0 ){
                        $bySize[ $size ] += 1;
                    }else{
                        $bySize[ $size ] = 1;
                    }
                }
                
                array_push($result, $bySize);
            }
        }

        return array( "DETAIL" => $stmt , "SUM" => $result ) ;
    }

    public function loadContLiftTotal( $args = array() ){

        $this->ceh->select( "G.rowguid, G.EIRNo, G.CntrNo, G.OprID, G.ISO_SZTP, G.Status, G.CARGO_TYPE
                                , G.ShipKey, G.ShipID, VV.ShipVoy, VV.ShipYear
                                , G.cGateJob, G.CJMode_CD, G.DMethod_CD, G.Status, G.CntrClass, G.IsLocal, G.BILL_CHK
                                , G.CusID
                                , G.Transist
                                , CL.CLASS_Name
                                , CG.Description
                                , TM.Transit_Name
                                , ISNULL( JB.NameGate, ISNULL( JB.NameYard, JB.NameQuay ) ) AS JobName");
        $this->ceh->join("EIR AS E", "E.EIRNo = G.EIRNo AND E.CntrNo = G.CntrNo AND E.YARD_ID = G.YARD_ID", "LEFT");
        $this->ceh->join("CLASS_MODE AS CL", "CL.CLASS_Code = G.CntrClass AND CL.YARD_ID = G.YARD_ID", "LEFT");
        $this->ceh->join("CARGO_TYPE AS CG", "CG.Code = G.CARGO_TYPE AND CG.YARD_ID = G.YARD_ID", "LEFT");
        $this->ceh->join("Transit_Mode AS TM", "TM.Transit_CD = G.Transist AND TM.YARD_ID = G.YARD_ID", "LEFT");
        $this->ceh->join("ALLJOB_TYPE AS JB", "JB.Code = G.cGateJob AND JB.YARD_ID = G.YARD_ID", "LEFT");
        $this->ceh->join("VESSEL_SCHEDULE AS VV", "VV.ShipKey = G.ShipKey AND VV.ShipID = G.ShipID AND VV.YARD_ID = G.YARD_ID", "LEFT");
        $this->ceh->where_in( "G.cGateJob", array( "GO", "GF" ) );
        $this->ceh->where( "G.PAYMENT_TYPE", 'C' );
        $this->ceh->where( "E.bXNVC", '1' );

        $this->ceh->where( "G.YARD_ID", $this->yard_id);

        //where by TimeIn
        if( isset( $args["formDate"] ) && $args["formDate"] != "" )
        {
            $this->ceh->where( "G.TimeIn >=", $this->funcs->dbDateTime( $args["formDate"] ) );
        }

        if( isset( $args["toDate"] ) && $args["toDate"] != "" )
        {
            $this->ceh->where( "G.TimeIn <=", $this->funcs->dbDateTime( $args["toDate"]." 23:59:59" ) );
        }

        if( isset( $args["cusID"] ) && $args["cusID"] != "" )
        {
            $this->ceh->where( "G.CusID", $args["cusID"] );
        }

        //where by shipkey
        if( isset( $args["shipKey"] ) && $args["shipKey"] != "" )
        {
            $this->ceh->where( "G.ShipKey", $args["shipKey"] );
        }

        //where by cntrClass
        if( isset( $args["cntrClass"] ) && $args["cntrClass"] != "" )
        {
            $this->ceh->where( "G.CntrClass", $args["cntrClass"] );
        }

        //where by dmethod
        if( isset( $args["dmethod"] ) && $args["dmethod"] != "" )
        {
            $this->ceh->where( "G.DMethod_CD", $args["dmethod"] );
        }

        //where by isLocal
        if( isset( $args["isLocal"] ) && $args["isLocal"] != "" )
        {
            $this->ceh->where( "G.IsLocal", $args["isLocal"] );
        }

        //where by transit
        if( isset( $args["transit"] ) && $args["transit"] != "" )
        {
            $this->ceh->where( "G.Transist", $args["transit"] );
        }

        //where by status
        if( isset( $args["status"] ) && $args["status"] != "" )
        {
            $this->ceh->where( "G.Status", $args["status"] );
        }

        //where by oprs
        if( isset( $args["oprs"] ) && $args["oprs"] != '' )
        {
            $this->ceh->where( "G.OprID", $args["oprs"] );
        }

        //where by cjmode
        if( isset( $args["cjmode"] ) && $args["cjmode"] != '' )
        {
            $this->ceh->where_in("G.CJMode_CD", $args["cjmode"]);
        }

        $this->ceh->order_by("G.TimeIn", 'ASC');
        $this->ceh->order_by("G.CusID", 'ASC'); 

        $stmt = $this->ceh->get( "GATE_MONITOR AS G" );
        $stmt = $stmt->result_array();

        $newarray = array();

        foreach ($stmt as $k => $v ) {
            $newarray[ $v[ "OprID" ]."-".$v[ "cGateJob" ]."-".$v[ "CntrClass" ] ][ $k ] = $v;
        }

        $result = array();
        foreach ($newarray as $key => $value) {
            if( is_array( $value ) ){
                $bySize = array(
                    "OprID" => array_column($value, "OprID")[0],
                    "JobName" => array_column($value, "JobName")[0],
                    "CLASS_Name" => array_column($value, "CLASS_Name")[0],
                    "SZ_20F" => 0,
                    "SZ_40F" => 0,
                    "SZ_45F" => 0,
                    "SZ_20E" => 0,
                    "SZ_40E" => 0,
                    "SZ_45E" => 0
                );
                
                foreach ($value as $n => $m) {
                    $size = "SZ_".$this->getContSize( $m["ISO_SZTP"] ).$m["Status"];
                    if ( $bySize[ $size ] != 0 ){
                        $bySize[ $size ] += 1;
                    }else{
                        $bySize[ $size ] = 1;
                    }
                }
                
                array_push($result, $bySize);
            }
        }

        return array( "DETAIL" => $stmt , "SUM" => $result ) ;
    }

    public function loadYardServiceTotal( $args = array() ){

        $this->ceh->select( "SRV.rowguid, SRV.CntrClass, SSOderNo, CntrNo, OprID, ISO_SZTP, SRV.Status, CARGO_TYPE
                                , SRV.ShipKey, SRV.ShipID, VV.ShipVoy, VV.ShipYear
                                , SRV.CJMode_CD, SRV.IsLocal
                                , (CASE WHEN SRV.DRAFT_INV_NO IS NULL THEN 0
                                       ELSE 1 END) AS BILL_CHK
                                , DMethod_CD
                                , CusID
                                , CL.CLASS_Name
                                , CG.Description
                                , DM.CJModeName AS JobName");
        $this->ceh->join("CLASS_MODE AS CL", "CL.CLASS_Code = SRV.CntrClass AND CL.YARD_ID = SRV.YARD_ID", "LEFT");
        $this->ceh->join("CARGO_TYPE AS CG", "CG.Code = SRV.CARGO_TYPE AND CG.YARD_ID = SRV.YARD_ID", "LEFT");
        $this->ceh->join("DELIVERY_MODE AS DM", "DM.CJMode_CD = SRV.CJMode_CD AND DM.YARD_ID = SRV.YARD_ID", "LEFT");
        $this->ceh->join("VESSEL_SCHEDULE AS VV", "VV.ShipKey = SRV.ShipKey AND VV.ShipID = SRV.ShipID AND VV.YARD_ID = SRV.YARD_ID", "LEFT");
        $this->ceh->where( "SRV.FDate IS NOT NULL" );
        $this->ceh->where( "SRV.PAYMENT_TYPE", 'C' );

        $this->ceh->where( "SRV.YARD_ID", $this->yard_id);

        //where by FDate
        if( isset( $args["formDate"] ) && $args["formDate"] != "" )
        {
            $this->ceh->where( "SRV.FDate >=", $this->funcs->dbDateTime( $args["formDate"] ) );
        }

        if( isset( $args["toDate"] ) && $args["toDate"] != "" )
        {
            $this->ceh->where( "SRV.FDate <=", $this->funcs->dbDateTime( $args["toDate"]." 23:59:59" ) );
        }

        if( isset( $args["cusID"] ) && $args["cusID"] != "" )
        {
            $this->ceh->where( "SRV.CusID", $args["cusID"] );
        }

        //where by shipkey
        if( isset( $args["shipKey"] ) && $args["shipKey"] != "" )
        {
            $this->ceh->where( "SRV.ShipKey", $args["shipKey"] );
        }

        //where by cntrClass
        if( isset( $args["cntrClass"] ) && $args["cntrClass"] != "" )
        {
            $this->ceh->where( "SRV.CntrClass", $args["cntrClass"] );
        }

        //where by dmethod
        if( isset( $args["dmethod"] ) && $args["dmethod"] != "" )
        {
            $this->ceh->where( "SRV.DMethod_CD", $args["dmethod"] );
        }

        //where by isLocal
        if( isset( $args["isLocal"] ) && $args["isLocal"] != "" )
        {
            $this->ceh->where( "SRV.IsLocal", $args["isLocal"] );
        }

        //where by status
        if( isset( $args["status"] ) && $args["status"] != "" )
        {
            $this->ceh->where( "SRV.Status", $args["status"] );
        }

        //where by oprs
        if( isset( $args["oprs"] ) && count( $args["oprs"] ) > 0 )
        {
            $this->ceh->where_in( "SRV.OprID", $args["oprs"] );
        }

        //where by cjmode
        if( isset( $args["cjmode"] ) && count( $args["cjmode"] ) > 0 )
        {
            $this->ceh->where_in("SRV.CJMode_CD", $args["cjmode"]);
        }

        if( isset( $args["jobTypes"] ) && count( $args["jobTypes"] ) > 0 )
        {
            $firstJob = $args["jobTypes"][0];

            $this->ceh->group_start();

            $this->ceh->where( $firstJob["key"] , $firstJob["value"] );

            unset( $args["jobTypes"][ $firstJob["key"] ] );

            foreach ( $args["jobTypes"] as $key => $item ) {
                $this->ceh->or_where( $item["key"] , $item["value"] );
            }

            $this->ceh->group_end();
        }

        $this->ceh->order_by("SRV.FDate", 'ASC');

        $stmt = $this->ceh->get( "SRV_ODR AS SRV" );
        $stmt = $stmt->result_array();

        $newarray = array();

        foreach ($stmt as $k => $v ) {
            $newarray[ $v[ "OprID" ]."-".$v[ "CJMode_CD" ]."-".$v[ "CntrClass" ] ][ $k ] = $v;
        }

        $result = array();
        foreach ($newarray as $key => $value) {
            if( is_array( $value ) ){
                $bySize = array(
                    "OprID" => array_column($value, "OprID")[0],
                    "JobName" => array_column($value, "JobName")[0],
                    "CLASS_Name" => array_column($value, "CLASS_Name")[0],
                    "SZ_20F" => 0,
                    "SZ_40F" => 0,
                    "SZ_45F" => 0,
                    "SZ_20E" => 0,
                    "SZ_40E" => 0,
                    "SZ_45E" => 0
                );
                
                foreach ($value as $n => $m) {
                    $size = "SZ_".$this->getContSize( $m["ISO_SZTP"] ).$m["Status"];
                    if ( $bySize[ $size ] != 0 ){
                        $bySize[ $size ] += 1;
                    }else{
                        $bySize[ $size ] = 1;
                    }
                }
                
                array_push($result, $bySize);
            }
        }

        return array( "DETAIL" => $stmt , "SUM" => $result ) ;
    }

    public function loadPlugTotal( $args ){
        $this->ceh->select("rf.rowguid, ShipKey, CntrClass, CLASS_Name, CntrNo, CHUONGCAM, CHUONGRUT, ShipID, ShipYear, ShipVoy, Fdate, Job_Type_RF
                            , Status, ISO_SZTP, OprID, CBLOCK, CBAY, CROW, CTIER, CAREA, CVBAY, CVROW, CVTIER, Temperature, DateIn
                            , DateOut, DatePlugIn, DatePlugOut, BILL_CHK, TIME");
        $this->ceh->join("CLASS_MODE AS CL", "CL.CLASS_Code = rf.CntrClass AND CL.YARD_ID = rf.YARD_ID", "LEFT");

        $this->ceh->where("rf.YARD_ID", $this->yard_id);
        $this->ceh->where("DatePlugOut IS NOT NULL");
        $this->ceh->where("Status", "F");
        $this->ceh->where("payment_type", "C");

        $this->ceh->where( "DatePlugOut >=", $this->funcs->dbDateTime( $args["fromDate"] ) );
        $this->ceh->where( "DatePlugOut <=", $this->funcs->dbDateTime( $args["toDate"] ) );
        $this->ceh->where_in( "OprID", $args['oprs'] );

        if( $args['cntrClass'] != '' && $args['cntrClass'] != '*' ){
            $this->ceh->where( "OprID", $args['cntrClass'] );
        }

        $this->ceh->order_by("BILL_CHK", "DESC");
        $stmt = $this->ceh->get("RF_ONOFF rf");
        return $stmt->result_array();
    }



    private function filter_trf_dis($inputs, $fwheres, $mskey){ //$mskey là khóa (tên cột) để xác định dòng/item sẽ được remove khỏi $inputs nếu k thỏa điêu kiện
        foreach ($fwheres as $k => $v) { //$k : col name, $v : col val
            $arrcol_val = array_column($inputs, $k, $mskey);
            if(in_array($fwheres[$k], $arrcol_val)){
                foreach ($arrcol_val as $idx=>$item) {
                    if($fwheres[$k] == $item) continue; //thoa dieu kien filter
                    unset($inputs[$idx]);
                }
            }else{
                foreach ($arrcol_val as $idx=>$item) {
                    if($item == '*') continue;
                    unset($inputs[$idx]);
                }
            }
            if(count($inputs) > 1){
                unset($fwheres[$k]);
                return $this->filter_trf_dis($inputs, $fwheres, $mskey);
            }else{
                return $inputs;
            }
        }
        return array();
    }

    public function loadTariffSTD( $listeir, $invTemp ){
        $sql = 'SELECT * FROM TRF_STD WHERE ( TRF_CODE IN ( SELECT TRF_CODE FROM INV_TPLT WHERE TPLT_NM = ? ) )';
        $sql.= ' AND ((CONVERT(date, ?, 104) >= CONVERT(date, FROM_DATE, 104) and TO_DATE = \'*\') or
                    (CONVERT(date, ?, 104) between CONVERT(date, FROM_DATE, 104) AND CONVERT(date, TO_DATE, 104)))';

        $sql.= ' AND (YARD_ID = ?)';

        $wheres = array(
            $invTemp,
            date('d/m/Y'),
            date('d/m/Y'),
            $this->yard_id
        );

        $stmt = $this->ceh->query($sql, $wheres);
        $stmt = $stmt->result_array();

        $result = array();
        $final_result=array();

        if( isset( $listeir ) && is_array( $listeir ) ){
            foreach( $listeir as $item ){
                //nếu có job_type_rf -> dịch vụ tàu , ngược lại là nâng hạ
                $JOB_KIND = isset( $item["Job_Type_RF"] )
                            ? $item["Job_Type_RF"] 
                            : ( ($item['CJMode_CD'] == 'LAYN' || $item['CJMode_CD'] == 'NTAU' || $item['CJMode_CD'] == 'CAPR')
                                    ? "GO" 
                                    : ( ($item['CJMode_CD'] == 'HBAI' || $item['CJMode_CD'] == 'TRAR')
                                                ? "GF" 
                                                : "*") );

                if( count( $stmt ) > 1 ){
                    $fwhere = array(
                        'IX_CD' => $item['CntrClass'],
                        'JOB_KIND' => $JOB_KIND,
                        'CARGO_TYPE' => $item['CARGO_TYPE'],
                        'DMETHOD_CD' => isset( $item['DMethod_CD'] ) ? $item['DMethod_CD'] : "*",
                        'CNTR_JOB_TYPE' => $item['CJMode_CD'],
                        'IsLocal' =>  isset( $item['IsLocal'] ) ? $item['IsLocal'] : "*"
                    );

                    // nếu có job_type_rf -> dv tàu -> bỏ đk filter theo CNTR_JOB_TYPE
                    if( isset( $item["Job_Type_RF"] ) ){
                        unset( $fwhere["CNTR_JOB_TYPE"] );
                    }

                    //đổi key của từng row trong $stmt thành giá trị của cột rowguid
                    foreach ( $stmt as $k=>$v ) {
                        $stmt[$v['rowguid']] = $v;
                        unset($stmt[$k]);
                    }

                    $temp = $this->filter_trf_dis($stmt, $fwhere, 'rowguid');
                    if(count($temp) == 0) continue;
                    $temp = array_reverse($temp);
                    $result = array_pop($temp);
                }else{
                    if(count($stmt) == 1) {
                        $result = $stmt[0];
                    }
                }

                // $ordNo = isset($item['EIRNo']) ? $item['EIRNo'] : $item['SSOderNo'];

                if( count( $result ) > 0 ){
                    // $result['OrderNo'] = $ordNo;
                    $result['CJMode_CD'] = isset( $item['CJMode_CD'] ) ? $item['CJMode_CD'] : $result['CNTR_JOB_TYPE'];
                    $result['ISO_SZTP'] = $item['ISO_SZTP'];
                    $result['FE'] = $item['Status'];
                    $result['CntrNo'] = $item['CntrNo'];
                    $result['OprID'] = $item['OprID'];
                    $result['IssueDate'] = isset( $item['IssueDate'] ) ? $item['IssueDate'] : date("Y-m-d H:i:s");
                    
                    array_push($final_result, $result);
                }else{
                    $cjmode = isset( $item['CJMode_CD'] ) ? "[".$item['CJMode_CD']."]" : '';
                    array_push($final_result, "$cjmode không tìm thấy biểu cước phù hợp!");
                }
            }
        }

        return $final_result;
    }

    public function getTRF_unitCode($tarriffcode){
        $stmt = $this->ceh->select('INV_UNIT')
                                ->where('TRF_CODE', $tarriffcode)
                                ->where('YARD_ID', $this->yard_id)
                                ->limit(1)
                                ->get('TRF_CODES')->row_array();
        return $stmt['INV_UNIT'];
    }

    public function save_draft_invoice( $tableName, $args, &$outInfo )
    {
        //get invoice info
        $invInfo = ( isset( $args['invInfo'] ) && count( $args['invInfo'] ) > 0 ) ? $args['invInfo'] : array();

        $invContents = array();
        $pinCode = "";
        $checkDraftNo = array();
        $draftMarker = array();
        $draftNo = $this->getDraftTemp();

        if( count( $invInfo ) > 0 ){
            $pinCode = $invInfo['fkey'];
            $invContents = array(
                "INV_NO_PRE" => substr("00000000".$invInfo['invno'], -8),
                "INV_PREFIX" => $invInfo['serial'],
                "DRAFT_NO" => $draftNo,
                "PIN_CODE" => $pinCode
            );
        }
        else
        {
            //generate số pin
            $pinCode = $this->generatePinCode();

            if( isset( $args["pubType"] ) )
            {
                if( $args["pubType"] == 'm-inv' ) // trường hợp xuất hóa đơn tay
                {
                    $session_inv_info = json_decode( $this->session->userdata("invInfo"), true ); // lấy thông tin hóa đơn đc lưu trữ trong biến session
                    
                    $invContents = array(
                        "INV_NO_PRE" => substr("00000000".$session_inv_info['invno'], -8),
                        "INV_PREFIX" => $session_inv_info['serial'],
                        "DRAFT_NO" => $draftNo,
                        "PIN_CODE" => $pinCode
                    );

                    //trả về thông tin hóa đơn
                    array_push( $outInfo , [
                                            "invno" => $session_inv_info['invno'],
                                            "serial" => $session_inv_info['serial'],
                                            "fkey" => $pinCode
                                        ] );
                }
                elseif ( $args["pubType"] == 'credit' ){
                    //trả về thông tin số PIN
                    array_push( $outInfo , [ "PinCode" => $pinCode ] );
                }
            }
        }

        $updateInfos = array();
        $datas = $args["datas"];
        foreach ($datas as $key => $item)
        {
            $updItem = array(
                "rowguid" => $item["rowguid"],
                "BILL_CHK" => 1,
                "ModifiedBy" => $this->session->userdata("UserID"),
                "update_time" => date('Y-m-d H:i:s')
            );

            if( $tableName == "SRV_ODR" ){
                unset( $updItem["BILL_CHK"] );
            }

            //update inv info into
            if( count( $invContents ) > 0 ){
                $invNoColumnName = $tableName == "QUAYJOB" ? "INV_NO" : "InvNo";
                $updItem[ $invNoColumnName ] = isset( $invContents["INV_PREFIX"] ) ? $invContents["INV_PREFIX"].$invContents["INV_NO_PRE"] : NULL;
            }

            $markerKey = isset( $item["Job_Type_RF"] ) ? "Job_Type_RF" : "CJMode_CD";

            if( $args["pubType"] == 'dft' )
            {
                $updItem["DRAFT_INV_NO"] = isset( $checkDraftNo[ $item[ $markerKey ] ] ) 
                                            ? $checkDraftNo[ $item[ $markerKey ] ]
                                            : $this->getDraftTemp();

                if( in_array( $updItem["DRAFT_INV_NO"] , array_column( $draftMarker, "DRAFT_INV_NO" ) ) ){
                    $tempDft = explode( "/", $updItem["DRAFT_INV_NO"] );
                    $updItem["DRAFT_INV_NO"] = $tempDft[0]."/".$tempDft[1]."/".substr('000000'.(intval($tempDft[2]) + 1), -6);
                }
                
                $draftMarker[ $item[ $markerKey ] ] = array(
                    "DRAFT_INV_NO" => $updItem["DRAFT_INV_NO"]
                );
            }
            else
            {
                $updItem["DRAFT_INV_NO"] = $draftNo;
            }

            $checkDraftNo[ $item[ $markerKey ] ] = $updItem["DRAFT_INV_NO"];

            array_push( $updateInfos, $updItem );
            // $this->ceh->where('rowguid', $item["rowguid"])->update( $tableName, $updItem );
        }

        $continue_proccess = true;
        $outputMsg = "";
        if( $args["pubType"] == 'dft' )
        {
            //set Inv Content to args
            $args["DRAFT_MARKER"] = $draftMarker;

            //trả về thông tin phiếu tính cước
            foreach ( $draftMarker as $key => $value )
            {
                array_push( $outInfo , array(
                                        "PinCode" => $pinCode,
                                        "DRAFT_NO" => $value["DRAFT_INV_NO"]
                                    ) );
            }

            $continue_proccess = $this->saveSplitDraft( $args, $datas[0], $outputMsg );
        }
        else
        {
            if( count( $invContents ) > 0 )
            {
                //set Inv Content to args
                $args["INV_CONTENT"] = $invContents;

                $arrCntrRowguids = array_column( $datas , "MASTER_ROWGUID");
                $continue_proccess = $this->saveInvoice( $args, $datas[0], $arrCntrRowguids, $outputMsg );
            }
        }

        if( $continue_proccess ){
            $this->ceh->trans_start();
            $this->ceh->trans_strict(FALSE);
            ////////////////////////////////////////////////////

            $this->ceh->update_batch($tableName, $updateInfos, 'rowguid');

            ////////////////////////////////////////////////////
            $this->ceh->trans_complete();

            if($this->ceh->trans_status() === FALSE) {
                $this->ceh->trans_rollback();
                return $this->ceh->_error_message();
            }
            else {
                $this->ceh->trans_commit();
                return 'success';
            }
        }else{
            return $outputMsg;
        }
    }

    public function saveSplitDraft( $args, $order, &$outMsg )
    {
        if(!is_array($args) || count($args) == 0) return true;

        $draft_details = array();
        if(isset($args['draft_detail']) && count($args['draft_detail'])){
            $draft_details = $args['draft_detail'];
        }

        $draft_total = array();
        if(isset($args['draft_total']) && count($args['draft_total'])){
            $draft_total = $args['draft_total'];
        }

        $draftMarker = $args["DRAFT_MARKER"];

        $inv_draft = array();

        foreach ( $draftMarker as $key => $item ) {
            //get inv draft
            $amount = array_sum( array_map( function( $dt ) use ( $key ) {
                        return $dt["CNTR_JOB_TYPE"] == $key ? (float)str_replace(',', '', $dt['AMOUNT']) : 0; 
                    }, $draft_details ) );

            $vat = array_sum( array_map( function($dt) use ( $key ) { 
                        return $dt["CNTR_JOB_TYPE"] == $key ? (float)str_replace(',', '', $dt['VAT']) : 0; 
                    }, $draft_details));

            $disAMT = array_sum( array_map( function($dt) use ( $key ) { 
                        return $dt["CNTR_JOB_TYPE"] == $key ? (float)str_replace(',', '', $dt['extra_rate']) : 0; 
                    }, $draft_details));

            $totalAMT = array_sum( array_map( function($dt) use ( $key ) { 
                        return $dt["CNTR_JOB_TYPE"] == $key ? (float)str_replace(',', '', $dt['TAMOUNT']) : 0; 
                    }, $draft_details));

            $inv_draft_item = array(
                "DRAFT_INV_NO" => $item["DRAFT_INV_NO"],
                "INV_NO" => NULL,
                "DRAFT_INV_DATE" => date('Y-m-d H:i:s'),
                "REF_NO" => NULL,
                "ShipKey" => $order['ShipKey'],
                "ShipID" => $order['ShipID'],
                "ShipYear" => $order['ShipYear'],
                "ShipVoy" => $order['ShipVoy'],
                "PAYER_TYPE" => $order['PAYER_TYPE'],
                "PAYER" => $order['CusID'],
                "OPR" => $order['OprID'],
                "AMOUNT" => $amount,
                "VAT" => $vat,
                "DIS_AMT" => $disAMT,
                "PAYMENT_STATUS" => "U", //$order['PAYMENT_TYPE'] == "C" ? "U" : "Y",
                "REF_TYPE" => "A",
                "CURRENCYID" => $draft_details[0]["CURRENCYID"],
                "RATE" => 1,
                "INV_TYPE" => "CRE", //$order['PAYMENT_TYPE'] == "C" ? "CRE" : "CAS",
                "INV_TYPE_2" => "L",
                "TPLT_NM" => "EB",
                "TAMOUNT" => $totalAMT,

                "YARD_ID" => $this->yard_id,
                "ModifiedBy" => $this->session->userdata("UserID"),
                "update_time" => date('Y-m-d H:i:s'),
                "CreatedBy" => $this->session->userdata("UserID")
            );

            array_push( $inv_draft , $inv_draft_item);
        }

        //get inv draft details
        $inv_draft_details = array();
        foreach ($draft_details as $idx => $dd) {
            
            if( !isset( $draftMarker[ $dd["CNTR_JOB_TYPE"] ] ) ) continue;

            $draftno = $draftMarker[ $dd["CNTR_JOB_TYPE"] ]["DRAFT_INV_NO"];

            $dd['DRAFT_INV_NO'] = $draftno;
            $dd['SEQ'] = $idx;
            $dd['SZ'] =  $this->getContSize($dd['ISO_SZTP']);
            $dd['DIS_AMT'] = (float)str_replace(',', '', $dd['extra_rate']);
            $dd['standard_rate'] = (float)str_replace(',', '', $dd['standard_rate']);
            $dd['DIS_RATE'] = (float)str_replace(',', '', $dd['DIS_RATE']);
            $dd['extra_rate'] = (float)str_replace(',', '', $dd['extra_rate']);
            $dd['UNIT_RATE'] = (float)str_replace(',', '', $dd['UNIT_RATE']);
            $dd['AMOUNT'] = (float)str_replace(',', '', $dd['AMOUNT']);
            $dd['VAT'] = (float)str_replace(',', '', $dd['VAT']);
            $dd['TAMOUNT'] = (float)str_replace(',', '', $dd['TAMOUNT']);
            $dd['TRF_DESC'] = UNICODE.$dd['TRF_DESC'];

            $dd['GRT'] = 1;
            $dd['SOGIO'] = 1;
            $dd['ModifiedBy'] = $this->session->userdata("UserID");
            $dd['CreatedBy'] = $this->session->userdata("UserID");
            $dd['update_time'] =date('Y-m-d H:i:s');

            unset($dd['REF_NO'], $dd['JobMode'], $dd['ISO_SZTP'], $dd['CURRENCYID']);
            array_push($inv_draft_details, $dd);
        }

        //get inv Cont
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($inv_draft as $item)
        {
            $this->ceh->insert('INV_DFT', $item);
        }

        foreach ($inv_draft_details as $item)
        {
            $item["YARD_ID"] = $this->yard_id;
            $this->ceh->insert('INV_DFT_DTL', $item);
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $outMsg = $this->ceh->_error_message();
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function saveInvoice( $args, $order, $cntrRowguids, &$outMsg )
    {
        if(!is_array($args) || count($args) == 0) return true;

        $draft_details = array();
        if(isset($args['draft_detail']) && count($args['draft_detail'])){
            $draft_details = $args['draft_detail'];
        }

        $draft_total = array();
        if(isset($args['draft_total']) && count($args['draft_total'])){
            $draft_total = $args['draft_total'];
        }

        $invPrefix = isset( $args["INV_CONTENT"]["INV_PREFIX"] ) ? $args["INV_CONTENT"]["INV_PREFIX"] : "";
        $invNoPre = isset( $args["INV_CONTENT"]["INV_NO_PRE"] ) ? $args["INV_CONTENT"]["INV_NO_PRE"] : "";
        $draftno = $args["INV_CONTENT"]["DRAFT_NO"];
        $pincode = $args["INV_CONTENT"]["PIN_CODE"];

        //get inv draft
        $inv_draft = array(
            "DRAFT_INV_NO" => $draftno,
            "INV_NO" => $invPrefix.$invNoPre != "" ? $invPrefix.$invNoPre : NULL,
            "DRAFT_INV_DATE" => date('Y-m-d H:i:s'),
            "REF_NO" => NULL,
            "ShipKey" => $order['ShipKey'],
            "ShipID" => $order['ShipID'],
            "ShipYear" => $order['ShipYear'],
            "ShipVoy" => $order['ShipVoy'],
            "PAYER_TYPE" => $order['PAYER_TYPE'],
            "PAYER" => $order['CusID'],
            "OPR" => $order['OprID'],
            "AMOUNT" => (float)str_replace(',', '', $draft_total['AMOUNT']),
            "VAT" => (float)str_replace(',', '', $draft_total['VAT']),
            "DIS_AMT" => (float)str_replace(',', '', $draft_total['DIS_AMT']),
            "PAYMENT_STATUS" => "C", //$order['PAYMENT_TYPE'] == "C" ? "U" : "Y",
            "REF_TYPE" => "A",
            "CURRENCYID" => $draft_details[0]["CURRENCYID"],
            "RATE" => 1,
            "INV_TYPE" => "CRE", //$order['PAYMENT_TYPE'] == "C" ? "CRE" : "CAS",
            "INV_TYPE_2" => "L",
            "TPLT_NM" => "EB",
            "TAMOUNT" => (float)str_replace(',', '', $draft_total['TAMOUNT']),

            "ModifiedBy" => $this->session->userdata("UserID"),
            "update_time" => date('Y-m-d H:i:s'),
            "CreatedBy" => $this->session->userdata("UserID")
        );

        //get inv draft details
        $inv_draft_details = array();
        foreach ($draft_details as $idx => $dd) {
            $dd['DRAFT_INV_NO'] = $draftno;
            $dd['SEQ'] = $idx;
            $dd['SZ'] =  $this->getContSize($dd['ISO_SZTP']);
            $dd['DIS_AMT'] = (float)str_replace(',', '', $dd['extra_rate']);
            $dd['standard_rate'] = (float)str_replace(',', '', $dd['standard_rate']);
            $dd['DIS_RATE'] = (float)str_replace(',', '', $dd['DIS_RATE']);
            $dd['extra_rate'] = (float)str_replace(',', '', $dd['extra_rate']);
            $dd['UNIT_RATE'] = (float)str_replace(',', '', $dd['UNIT_RATE']);
            $dd['AMOUNT'] = (float)str_replace(',', '', $dd['AMOUNT']);
            $dd['VAT'] = (float)str_replace(',', '', $dd['VAT']);
            $dd['TAMOUNT'] = (float)str_replace(',', '', $dd['TAMOUNT']);
            $dd['TRF_DESC'] = UNICODE.$dd['TRF_DESC'];

            $dd['GRT'] = 1;
            $dd['SOGIO'] = 1;
            $dd['ModifiedBy'] = $this->session->userdata("UserID");
            $dd['CreatedBy'] = $this->session->userdata("UserID");
            $dd['update_time'] =date('Y-m-d H:i:s');

            unset($dd['REF_NO'], $dd['JobMode'], $dd['ISO_SZTP'], $dd['CURRENCYID']);
            array_push($inv_draft_details, $dd);
        }

        //get inv VAT
        if( $invPrefix.$invNoPre != "" ){
            $inv_vat = array(
                "INV_NO" => $invPrefix.$invNoPre,
                "INV_DATE" => date('Y-m-d H:i:s'),
                "REF_NO" => NULL,
                "ShipKey" => $order['ShipKey'],
                "ShipID" => $order['ShipID'],
                "ShipYear" => $order['ShipYear'],
                "ShipVoy" => $order['ShipVoy'],
                "PAYER_TYPE" => $order['PAYER_TYPE'],
                "PAYER" => $order['CusID'],
                "OPR" => $order['OprID'],
				"isPosted" => 0,
                "AMOUNT" => (float)str_replace(',', '', $draft_total['AMOUNT']),
                "VAT" => (float)str_replace(',', '', $draft_total['VAT']),
                "DIS_AMT" => (float)str_replace(',', '', $draft_total['DIS_AMT']),
                "PAYMENT_STATUS" => "U", //$order['PAYMENT_TYPE'] == "C" ? "U" : "Y",
                "REF_TYPE" => "A",
                "CURRENCYID" => $draft_details[0]["CURRENCYID"],
                "RATE" => 1,
                "INV_TYPE" => "CRE", //$order['PAYMENT_TYPE'] == "C" ? "CRE" : "CAS",
                "INV_TYPE_2" => "L",
                "TPLT_NM" => "EB",
                "PRINT_CHECK" => 0,
                "TAMOUNT" => (float)str_replace(',', '', $draft_total['TAMOUNT']),
                "ACC_CD" => "TM/CK", //$order['PAYMENT_TYPE'] == "C" ? "TM/CK" : "CK",
                "INV_PREFIX" => $invPrefix,
                "INV_NO_PRE" => $invNoPre,
                "PinCode" => $pincode,
                "CreatedBy" => $this->session->userdata("UserID"),
                "ModifiedBy" => $this->session->userdata("UserID"),
                "update_time" => date('Y-m-d H:i:s')
            );
        }

        //get inv Cont
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $inv_draft["YARD_ID"] = $this->yard_id;

        $this->ceh->insert('INV_DFT', $inv_draft);
        foreach ($inv_draft_details as $item) {

            $item["YARD_ID"] = $this->yard_id;

            $this->ceh->insert('INV_DFT_DTL', $item);
        }
        
        if( isset( $inv_vat ) && count( $inv_vat ) > 0 ){
            $inv_vat["YARD_ID"] = $this->yard_id;
            $this->ceh->insert('INV_VAT', $inv_vat);

            if( $this->session->userdata("invInfo") !== null && $args["pubType"] == 'm-inv' ){
                $session_inv_info = json_decode( $this->session->userdata("invInfo"), TRUE );

                //nếu đã đến số cuối cùng thì remove invInfo để user tự set lại
                if( $session_inv_info["invno"] == $session_inv_info["toNo"] ){
                    $this->session->unset_userdata('invInfo');
                }else{
                    //set laij soo hóa đơn tay tăng lên 1
                    $session_inv_info["invno"] = substr('00000000'.( intval( $session_inv_info["invno"] ) + 1 ), -8);
                    $this->session->set_userdata("invInfo", json_encode( $session_inv_info ));
                }
            }
        }

        if( count( $cntrRowguids ) > 0 ){
            $this->ceh->where('YARD_ID', $this->yard_id)
                        ->where_in('rowguid', $cntrRowguids)
                        ->update('CNTR_DETAILS', array("InvNo" => $inv_vat["INV_NO"]));
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $outMsg = $this->ceh->_error_message();
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }
    
    private function getContSize($sztype){
        switch(substr($sztype,0,1)){
            case "2":
                return 20;
            case "4":
                return 40;
            case "L":
            case "M":
            case "9":
                return 45;
        }
        return "0";
    }

    public function getDraftTemp(){
        $this->ceh->select('DRAFT_INV_NO');
        $this->ceh->where("YARD_ID", $this->yard_id);
        $this->ceh->order_by('DRAFT_INV_NO', 'DESC');
        $stmt = $this->ceh->limit(1)->get('INV_DFT');
        $stmt = $stmt->row_array();
        if($stmt['DRAFT_INV_NO'] === null){
            return 'DR/'.date('Y').'/000001';
        }else{
            $tmp = explode('/', $stmt['DRAFT_INV_NO']);
            if(count($tmp) == 0) return 'DR/'.date('Y').'/000001';
            if($tmp[1] !== date('Y')) return 'DR/'.date('Y').'/000001';

            return 'DR/'.date('Y').'/'.substr('000000'.((int)$tmp[2] + 1), -6);
        }
    }
}