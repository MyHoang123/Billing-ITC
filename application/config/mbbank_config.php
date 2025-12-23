<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * MB Bank Payment Gateway Configuration
 * Updated with correct endpoints from cURL example
 */

// Environment - true for sandbox, false for production
$config['mbbank_sandbox'] = true;

// OAuth2 Credentials for Client Credentials Flow
$config['mbbank_client_id'] = 'RKzfCQIZBosvPVSXbi4kL4LRg45njNjr';
$config['mbbank_client_secret1'] = '1BqcdcmSa9Pv3KcxKiIFy7DcJKcWUBvA';
$config['mbbank_client_secret'] = '6eV24s6QAysGlo8w';

// Merchant Information (from cURL example)
$config['mbbank_merchant_id'] = '203156';
$config['mbbank_access_code'] = 'NFNAOPLJLD';
$config['mbbank_secret_key'] = '9e5d9c509dd8a190e3f986d33bdc9820';

// Sandbox API URLs (corrected from cURL example)
$config['mbbank_base_url'] = 'https://api-sandbox.mbbank.com.vn';



$config['mbbank_query_v1_url'] = 'https://api-sandbox.mbbank.com.vn/private/ms/pg-paygate-authen/paygate/detail';
$config['mbbank_list_transactions_url'] = 'https://api-sandbox.mbbank.com.vn/private/ms/pg-paygate/v1/paygate/list-transactions';

//MT
$config['mbbank_ipn_url'] = 'https://api-sandbox.mbbank.com.vn/integration-paygate-cangitc/v1.0/payIpn';
$config['mbbank_token_url'] = 'https://api-sandbox.mbbank.com.vn/oauth2/v1/token';
$config['mbbank_create_order_url'] = 'https://api-sandbox.mbbank.com.vn/private/ms/pg-paygate-authen/paygate/v2/create-order';
$config['mbbank_query_url'] = 'https://api-sandbox.mbbank.com.vn/private/ms/pg-paygate-authen/v2/paygate/detail';
$config['mbbank_refund_url'] = 'https://api-sandbox.mbbank.com.vn/private/ms/pg-paygate-authen/paygate/refund/single';



// Production URLs (when mbbank_sandbox is false)
$config['mbbank_production_base_url'] = 'https://api.mbbank.com.vn';
$config['mbbank_production_token_url'] = 'https://api.mbbank.com.vn/oauth2/v1/token';
$config['mbbank_production_create_order_url'] = 'https://api.mbbank.com.vn/private/ms/pg-paygate-authen/paygate/v2/create-order';
$config['mbbank_production_query_url'] = 'https://api.mbbank.com.vn/private/ms/pg-paygate-authen/v2/paygate/detail';
$config['mbbank_production_refund_url'] = 'https://api.mbbank.com.vn/private/ms/pg-paygate-authen/paygate/refund/single';

// Payment settings
$config['mbbank_currency'] = 'vnd';
$config['mbbank_payment_method'] = 'QR';
$config['mbbank_mac_type'] = 'MD5';
$config['mbbank_timeout'] = 300; // 5 minutes

// Development settings
$config['mbbank_ssl_verify'] = false; // Set to true in production
$config['mbbank_timeout_seconds'] = 30;

/* End of file mbbank.php */
/* Location: ./application/config/mbbank.php */
