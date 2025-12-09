<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("user_model", "user");

        $this->ceh = $this->load->database('mssql', TRUE);
        $this->data['menus'] = $this->menu->getMenu();
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

    public function cmPaymentMethod()
    {
        $access = $this->user->access('cmPaymentMethod');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = "Hình thức thanh toán";
        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->savePaymentMethod($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delACC_CDs = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delACC_CDs) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deletePaymentMethod($delACC_CDs);
                echo json_encode($this->data['result']);
                exit();
            }
        }

        $this->load->view('header', $this->data);
        $this->data['payment_method'] = $this->mdlCommon->loadPaymentMethod();
        $this->load->view('common/payment_method', $this->data);
        $this->load->view('footer');
    }

    public function generateTrigger(){
        $itc = $this->load->database('itc', TRUE);

        $tables = array('CARGO_TYPE', 'CNTR_DETAILS', 'CNTR_SZTP_MAP', 'CUSTOMERS', 'DELIVERY_MODE', 'TRF_DIS', 'DMG_CODES', 'EIR', 'EMP_BOOK'
                                    , 'INV_DFT', 'INV_DFT_DTL', 'INV_VAT'
                                    , 'LANE_FPOD', 'LANE_OPR', 'TRF_CODES', 'TRF_STD', 'VESSEL_SCHEDULE', 'VESSELS');

        foreach ($tables as $tbl) {
            $columnname = $itc->select('column_name')->where('TABLE_NAME', $tbl)
                                                    ->where_not_in('column_name', array('ID', 'rowguid', 'staff_cd', 'update_time'))
                                                    ->get('INFORMATION_SCHEMA.COLUMNS')->result_array();

            $strColumnInsert = implode(', ', array_column($columnname, 'column_name'));
            $strColumnUpdate = "";
            foreach ($columnname as $item) {
                $val = $item['column_name'];
                $strColumnUpdate .= "$val = (SELECT $val FROM inserted),\n";
            }

            $trgNameIns = "EB_".$tbl."_INSUP";
            $trgInsUp = <<<EOT
CREATE TRIGGER [dbo].[$trgNameIns] ON [dbo].[$tbl]
AFTER INSERT, UPDATE
AS

BEGIN
    BEGIN TRY
        BEGIN TRAN
        IF EXISTS (SELECT * FROM inserted) AND NOT EXISTS(SELECT * FROM deleted)
            --insert
            INSERT INTO [EBILLING].[dbo].[$tbl]
                        (
                           $strColumnInsert
                           , TOS_REF, CreatedBy, ModifiedBy, UpdateTime, CreateTime
                        )
                    SELECT $strColumnInsert
                           , rowguid, 'TOS_Sync', 'TOS_Sync', GETDATE(), GETDATE() FROM inserted
        ELSE IF EXISTS (SELECT * FROM inserted) AND EXISTS(SELECT * FROM deleted)
            -- UPDATE
            UPDATE [EBILLING].[dbo].[$tbl]
            SET
                $strColumnUpdate
                ModifiedBy = 'TOS_Sync',
                UpdateTime = GETDATE()
            WHERE TOS_REF = (select rowguid from inserted)

        IF (@@ERROR = 1) ROLLBACK TRAN
        ELSE COMMIT TRAN
    END TRY

    BEGIN CATCH
     DECLARE @ErrorMsg VARCHAR(MAX), @ErrorNumber INT, @ErrorProc sysname, @ErrorLine INT
        SELECT @ErrorMsg = ERROR_MESSAGE(), @ErrorNumber = ERROR_NUMBER(), @ErrorProc = ERROR_PROCEDURE(), @ErrorLine = ERROR_LINE();
        PRINT   @ErrorMsg;
        RollBack Tran;
    END CATCH
END
EOT;
            file_put_contents("TRIGGER_VTOS_EB_INS_UP_$tbl.sql", $trgInsUp);
            $trgNameDel = "EB_".$tbl."_DEL";
            $trgDel = <<<EOT
CREATE TRIGGER [dbo].[$trgNameDel] ON [dbo].[$tbl]
FOR DELETE
AS

BEGIN
    BEGIN TRY
        BEGIN TRAN

        IF EXISTS (SELECT * FROM deleted) AND NOT EXISTS(SELECT * FROM inserted)
            --delete
            DELETE FROM [EBILLING].[dbo].[$tbl]
            WHERE TOS_REF = (select rowguid from deleted)

        IF (@@ERROR = 1) ROLLBACK TRAN
        ELSE COMMIT TRAN
    END TRY

    BEGIN CATCH
     DECLARE @ErrorMsg VARCHAR(MAX), @ErrorNumber INT, @ErrorProc sysname, @ErrorLine INT
        SELECT @ErrorMsg = ERROR_MESSAGE(), @ErrorNumber = ERROR_NUMBER(), @ErrorProc = ERROR_PROCEDURE(), @ErrorLine = ERROR_LINE();
        PRINT   @ErrorMsg;
        RollBack Tran;
    END CATCH
END
EOT;
            file_put_contents("TRIGGER_VTOS_EB_DEL_$tbl.sql", $trgDel);
        }
    }


    public function cmCustomers()
    {
        $access = $this->user->access('cmCustomers');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Khách hàng";
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == 'view')
        {
            $customer_type = $this->input->post('cusType') ? $this->input->post('cusType') : '';
            $customer_id = $this->input->post('cusID') ? $this->input->post('cusID') : '';
            $customer_name = $this->input->post('cusName') ? $this->input->post('cusName') : '';
            $customer_taxcode = $this->input->post('cusTaxCode') ? $this->input->post('cusTaxCode') : '';
            $this->data['list'] = $this->mdlCommon->loadCustomers($customer_type, $customer_id, $customer_name, $customer_taxcode);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveCustomers($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('CUSTOMERS');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->load->view('header', $this->data);
        $this->load->view('common/customers', $this->data);
        $this->load->view('footer');
    }
    
    public function cmUnitCode()
    {
        $access = $this->user->access('cmUnitCode');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveUnitCode($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delUnits = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delUnits) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteUnitCode($delUnits);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Đơn vị tính";

        $this->load->view('header', $this->data);
        $this->data['unitcodes'] = $this->mdlCommon->loadUnitCodes();
        $this->load->view('common/unit_codes', $this->data);
        $this->load->view('footer');
    }

    public function cmExchangeRate()
    {
        $access = $this->user->access('cmExchangeRate');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveExchangeRate($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delExchange = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delExchange) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteExchangeRate($delExchange);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tỉ giá loại tiền";

        $this->load->view('header', $this->data);
        $this->data['exchange_rates'] = $this->mdlCommon->loadExchangeRate();
        $this->load->view('common/exchange_rate', $this->data);
        $this->load->view('footer');
    }

    public function cmServiceAddonConfig()
    {
        $access = $this->user->access('cmServiceAddonConfig');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        
        if($action == 'view'){
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == 'load_service_data' ){
                $this->data['services'] = $this->mdlCommon->loadDMethodInServices();
                echo json_encode( $this->data );
                exit();
            }

            if( $act == 'load_attach_temp' ){
                $this->data['attach_temp'] = $this->mdlCommon->loadServiceForAttach();
                echo json_encode( $this->data );
                exit();
            }
        }

        if( $action == 'edit' ){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveServiceAddon($saveData);
                echo json_encode($this->data);
                exit;
            }else{
                $this->data['nothing'] = "nothing";
                echo json_encode($this->data['nothing'] );
                exit();
            }
        }

        $this->data['title'] = "Cấu hình DV đính kèm";

        $this->load->view('header', $this->data);
        $this->data['attach_services'] = $this->mdlCommon->loadServiceMore();

        $this->load->view('common/service_addon_config', $this->data);
        $this->load->view('footer');
    }

    public function cmTRFTemplateConfig()
    {
        $access = $this->user->access('cmTRFTemplateConfig');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if( $action == 'view' ){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if( $act == 'load_temp_srv' ){
                echo json_encode( $this->mdlCommon->loadServiceTemplate() );
                exit;
            }

            echo true;
            exit;
        }

        if( $action == 'edit' ){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveTRFTempConfig($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['title'] = "Cấu hình tính cước";

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdlCommon->loadDMethodInServices();
        $this->load->view('common/trf_template_config', $this->data);
        $this->load->view('footer');
    }

    public function cmPlugConfig()
    {
        $access = $this->user->access('cmPlugConfig');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveRF_TPLT($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delCodes = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delCodes) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteRF_TPLT($delCodes);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Cấu hình cắm rút điện lạnh";

        $this->load->view('header', $this->data);

        $this->data['allconfigs'] = $this->mdlCommon->loadRFTplt();

        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->load->view('common/plug_config', $this->data);
        $this->load->view('footer');
    }

    public function cmTRFService()
    {
        $access = $this->user->access('cmTRFService');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Cấu hình cước bậc thang";

        $this->load->view('header', $this->data);
        $this->load->view('common/trf_service', $this->data);
        $this->load->view('footer');
    }

    public function cmFreeDays()
    {
        $access = $this->user->access('cmFreeDays');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == 'view')
        {
            $temp = $this->input->post('temp') ? $this->input->post('temp') : '';

            $this->data['list'] = $this->mdlCommon->loadFreeDayConfig($temp);
            echo json_encode($this->data);
            exit;
        }

        if( $action == 'add' || $action == 'edit' ){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            $header = array(
                'PTNR_CODE' => $this->input->post('PTNR_CODE') ? $this->input->post('PTNR_CODE') : '',
                'SHIPPER' => $this->input->post('SHIPPER') ? $this->input->post('SHIPPER') : '',
                'IsLocal' => $this->input->post('IsLocal') ? $this->input->post('IsLocal') : '',
                'APPLY_DATE' => $this->input->post('APPLY_DATE') ? $this->input->post('APPLY_DATE') : '*',
                'EXPIRE_DATE' => $this->input->post('EXPIRE_DATE') ? $this->input->post('EXPIRE_DATE') : '',
                'PAYMENT_TYPE' => $this->input->post('PAYMENT_TYPE') ? $this->input->post('PAYMENT_TYPE') : '',
            );

            if( $header['EXPIRE_DATE'] != '*' ){
                $header['EXPIRE_DATE'] = $this->funcs->dbDateTime($header['EXPIRE_DATE']);
            }
            
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveFreeDayConfig($saveData, $header);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $temp = $this->input->post('temp') ? $this->input->post('temp') : '';

            $this->data['result'] = $this->mdlCommon->deleteFreeDayConfig($temp);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Cấu hình thời gian lưu bãi";

        $this->load->view('header', $this->data);
        $this->data['temp'] = $this->mdlCommon->freeDayConfigTemplate();
        $this->data['cargoTypes'] = $this->mdlCommon->loadCargoType();
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->data['cntr_class'] = $this->mdlCommon->loadCntrClass();
        $this->load->view('common/freeday_config', $this->data);
        $this->load->view('footer');
    }

    public function cmLoLoService()
    {
        $access = $this->user->access('cmLoLoService');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        
        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveDeliveryModes($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delCJModeCD = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delCJModeCD) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteDeliveryModes($delCJModeCD);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Dịch vụ";

        $this->load->view('header', $this->data);

        $this->data["tblName"] = $this->ceh->distinct()->select("TABLE_NAME")->get("INFORMATION_SCHEMA.COLUMNS")->result_array();
        
        $this->data['services'] = $this->mdlCommon->loadDeliveryMode();
        $this->data['cntr_class'] = $this->mdlCommon->loadCntrClass();
        $this->load->view('common/lolo_services', $this->data);
        $this->load->view('footer');
    }

    public function cmEir(){
        $access = $this->user->access('cmEir');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        $actions = $this->input->post('actions') ? $this->input->post('actions') : '';
        if($actions == 'searh_ship'){
            $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
            $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
            $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

            $this->data['vsls'] = $this->mdlCommon->searchShip($arrstt, $year, $name);
            echo json_encode($this->data);
            exit;
        }
        if($action == 'view')
        {
            $frd = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $td = $this->input->post('todate') ? $this->input->post('todate') : '';
            $opr = $this->input->post('opr') ? $this->input->post('opr') : '';
            $httt = $this->input->post('httt') ? $this->input->post('httt') : '';
            $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
            $shipkey = $this->input->post('shipkey') ? $this->input->post('shipkey') : '';
            $xnvc = $this->input->post('xnvc') ? $this->input->post('xnvc') : '';
            $method = $this->input->post('method') ? $this->input->post('method') : array();

            $fromdate = $this->funcs->dbDateTime($frd);
            $todate = $this->funcs->dbDateTime($td.' 23:59:59');
            $arr_where = array(
                'FROM_DATE' => $fromdate,
                'TO_DATE' => $todate,
                'OprID' => $opr,
                'PAYMENT_TYPE' => $httt,
                'CntrNo' => $cntrNo,
                'ShipKey' => $shipkey,
                'bXNVC' => $xnvc,
                'CJMode_CD' => $method
            );
            $this->data['list'] = $this->mdlCommon->loadEir($arr_where);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Lệnh nâng hạ";

        $this->load->view('header', $this->data);
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->load->view('common/eir', $this->data);
        $this->load->view('footer');
    }

    public function cmInvDraff(){
        $access = $this->user->access('cmInvDraff');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        $actions = $this->input->post('actions') ? $this->input->post('actions') : '';
        if($actions == 'searh_payer'){
            $this->data['payers'] = $this->mdlCommon->getPayers_InvDFT();
            echo json_encode($this->data);
            exit;
        }
        if($action == 'view')
        {
            $frd = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $td = $this->input->post('todate') ? $this->input->post('todate') : '';
            $opr = $this->input->post('opr') ? $this->input->post('opr') : '';
            $cusID = $this->input->post('cusid') ? $this->input->post('cusid') : '';
            $createdBy = $this->input->post('createdby') ? $this->input->post('createdby') : '';

            $payment_status = $this->input->post('payment_status') ? $this->input->post('payment_status') : array();
            $inv_type = $this->input->post('inv_type') ? $this->input->post('inv_type') : array();
            $currencyid = $this->input->post('currencyid') ? $this->input->post('currencyid') : array();

            $fromdate = $this->funcs->dbDateTime($frd);
            $todate = $this->funcs->dbDateTime($td.' 23:59:59');
            $arr_where = array(
                'FROM_DATE' => $fromdate,
                'TO_DATE' => $todate,
                'OprID' => $opr,
                'PAYMENT_STATUS' => $payment_status,
                'CreatedBy' => $createdBy,
                'CusID' => $cusID,
                'INV_TYPE' => $inv_type,
                'CURRENCYID' => $currencyid
            );

            $this->data['list'] = $this->mdlCommon->loadInvDraff($arr_where);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Phiếu tính cước";

        $this->load->view('header', $this->data);
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->load->view('common/invoice_draff', $this->data);
        $this->load->view('footer');
    }

    public function cmInv()
    {
        $access = $this->user->access('cmInv');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        $actions = $this->input->post('actions') ? $this->input->post('actions') : '';
        if($actions == 'search-payer'){
            $this->data['results'] = $this->mdlCommon->getPayers_Inv();
            echo json_encode($this->data);
            exit;
        }
        if($actions == 'search-tariff'){
            $this->data['results'] = $this->mdlCommon->getTariff();
            echo json_encode($this->data);
            exit;
        }
        if($action == 'view')
        {
            $frd = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $td = $this->input->post('todate') ? $this->input->post('todate') : '';
            $payer = $this->input->post('payer') ? $this->input->post('payer') : '';
            $tariff = $this->input->post('tariff') ? $this->input->post('tariff') : '';
            $createdBy = $this->input->post('createdby') ? $this->input->post('createdby') : '';
            $shipkey = $this->input->post('shipkey') ? $this->input->post('shipkey') : '';
            $currencyid = $this->input->post('CURRENCYID') ? $this->input->post('CURRENCYID') : array();

            $fromdate = $this->funcs->dbDateTime($frd);
            $todate = $this->funcs->dbDateTime($td.' 23:59:59');
            $arr_where = array(
                'FROM_DATE' => $fromdate,
                'TO_DATE' => $todate,
                'PAYER' => $payer,
                'TRF_CODE' => $tariff,
                'CreatedBy' => $createdBy,
                'ShipKey' => $shipkey,
                'CURRENCYID' => $currencyid
            );

            $this->data['list'] = $this->mdlCommon->loadInv($arr_where);
            echo json_encode($this->data);
            exit;
        }
        $this->data['title'] = "Hóa đơn";

        $this->load->view('header', $this->data);
        $this->load->view('common/invoice', $this->data);
        $this->load->view('footer');
    }

}
