<?php
defined('BASEPATH') OR exit('');


// UNICODE values
define('UNICODE', 'UNICODE');

$config['YARD_ID'] = "ITC";
$config['EIR_NO_QUEUE'] = '';
$config['APP_ID'] = 'VBILLING';
$config['TEMP_DRAFT_NO'] = '4170';
$config['PIN_PREFIX'] = array(
   'VSL' => 'ITC',
   'BL_CAS' => 'ITC1',
   'BL_CRE' => 'ITC2',
   'EPORT' => 'ITC3'
);

$config["VNPT_TEST_MODE"] = "1";

$config['VNPT_SRV_ID'] = $config["VNPT_TEST_MODE"] == "0" ? 'itchcmservice11' : 'itchcmservice';
$config['VNPT_SRV_PWD'] = $config["VNPT_TEST_MODE"] == "0" ? 'Einv@oi@vn#pt2011' : 'Einv@oi@vn#pt25';
$config['VNPT_PUBLISH_INV_ID'] = $config["VNPT_TEST_MODE"] == "0" ? 'itchcmadmin11' : 'itchcmadmin';
$config['VNPT_PUBLISH_INV_PWD'] = $config["VNPT_TEST_MODE"] == "0" ? '123456aA@11' : 'Einv@oi@vn#pt25';
$config['INV_PATTERN'] = $config["VNPT_TEST_MODE"] == "0" ? '1/001' : '1/002'; //
$config['INV_SERIAL'] = $config["VNPT_TEST_MODE"] == "0" ? 'C25TSP' : 'C25TAA';
$config["SUB_DOMAIN"] = $config["VNPT_TEST_MODE"] == "0" ? "itchcm-tt78admin1" : "itchcm-tt78admindemo";
$config["VNPT_PORTAL_URL"] = "https://itchcm-tt78admindemo.vnpt-invoice.com.vn/";
//them moi lam tron so
$config['ROUND_NUM'] = array(
   'VND' => 0,
   'USD' => 2
);

//lam tron so luong+don gia theo yeu cau KT
$config['ROUND_NUM_QTY_UNIT'] = 2;

$config['xmlv1.2'] = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body>XML_BODY</soap12:Body></soap12:Envelope>';


//mail
// $config['SYS_MAIL_ADDR'] = 'no-reply@sp-itc.com.vn';
// $config['SYS_MAIL_PASS'] = 'NoSupport@123';
// $config['SYS_MAIL_HOST'] = 'mail.sp-itc.com.vn';
// $config['SYS_MAIL_PORT'] = '25';
$config['SYS_MAIL_ADDR'] = 'myth@itccorp.com.vn';
$config['SYS_MAIL_PASS'] = 'Welcome12345@';
$config['SYS_MAIL_HOST'] = 'mail.itccorp.com.vn';
$config['SYS_MAIL_PORT'] = '25';
?>
