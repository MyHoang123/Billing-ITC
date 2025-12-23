<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbbank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
        $this->load->model("MBBank_model", "mbbank");
          // Load MB Bank configuration
        $this->load->config('mbbank_config');
    }

    public function _remap($method)
    {
        $methods = get_class_methods($this);
        $skip = array("_remap", "__construct", "get_instance");
        $a_methods = array();
        
        if (($method == 'index')) {
            $method = md5('index');
        }

        foreach ($methods as $smethod) {
            if (!in_array($smethod, $skip)) {
                $a_methods[] = md5($smethod);
                if ($method == md5($smethod)) {
                    $this->$smethod();
                    break;
                }
            }
        }
    }
    public function home()
    {
            // Get booking number and amount from URL parameters or POST data
            $amount = $this->input->get('amount') ?? $this->input->post('amount') ?? 0;
            $customerName = $this->input->get('customer_name') ?? $this->input->post('customer_name') ?? '';
            $cusId = $this->input->get('cusId') ?? $this->input->post('cusId') ?? '';
            $EirNo = $this->input->get('EirNo') ?? $this->input->post('EirNo') ?? '';
            $data = [
                'title' => 'MB Bank QR Gateway',
                'amount' => $amount,
                'cusId' => $cusId,
                'EirNo' => $EirNo,
                'customer_name' => $customerName,
            ];
            // Load the dedicated payment page
            $this->load->view('mbbank/MbbankGateway', $data);
    }
    public function checkPayment()
    {
        header('Content-Type: application/json');
        $EirNo = $this->input->get('EirNo');
        $result = $this->mbbank->checkPayment($EirNo);
        echo json_encode($result);
        exit;
    }

    public function createOrder()
    {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                return [
                    'success' => false,
                    'error' => 'Dữ liệu không hợp lệ!'
                ];
            }
            $secretKey = $this->config->item('mbbank_secret_key');
            $data['order_reference'] = 'ICQR' . $this->generateShortOrderReference();
            $data['access_code'] = $this->config->item('mbbank_access_code');
            $data['merchant_id'] = $this->config->item('mbbank_merchant_id');
            $data['currency'] = $this->config->item('mbbank_currency');
            $data['pay_type'] = 'pay';
            $data['ip_address'] = $this->getClientIP(); 
            $data['payment_method'] = $this->config->item('mbbank_payment_method');
            $data['ipn_url'] =  $this->config->item('mbbank_ipn_url');
            $queryString = $this->generateMac($data);
            $data['mac'] = strtoupper(md5($secretKey . $queryString));
            $data['mac_type'] = $this->config->item('mbbank_mac_type');
            $transactionId = $this->generateUUID();
            $clientMessageId = $this->generateUUID();
            $tokenResult = $this->getAccessTokenFromMBBank();
            if (!$tokenResult['success']) {
                  return [
                    'success' => false,
                    'error' => [
                        'title' => 'Lỗi hệ thống',
                        'message' => 'Vui lòng liên hệ quản trị viên!'
                    ]
                ];
            };
            $headerRequest = [
                'ClientMessageId' => $clientMessageId,
                'transactionId' => $transactionId,
                'tokenResult' => $tokenResult['access_token'],
            ];
            
            $result = $this->CallApiCreateQrMb($data,$headerRequest);
            if($result && $result['qr_info']) {
                  // Prepare transaction data for database
                  $expired_time = null;
                    if (!empty($result['expire_time'])) {
                        $dt = DateTime::createFromFormat('d-m-Y H:i:s', $result['expire_time']);
                        $expired_time = $dt ? $dt->format('Y-m-d H:i:s') : null;
                    }
                $transactionData = [
                    'transaction_ref_id' => $result['order_reference'],
                    'order_id' => $result['session_id'] ?? '',
                    'booking_no' => explode(' ', trim($data['order_info']))[1] ?? '',
                    'amount' => floatval($data['amount']),
                    'currency' => 'VND',
                    'qr_code' => $result['qr_url'] ?? '',
                    'qr_info' => $result['qr_info'] ?? '',
                    'description' => 'Payment for ' . explode(' ', trim($data['order_info']))[1],
                    'bank_code' => 'MB',
                    'bank_name' => 'MB Bank',
                    'account_no' => '899977799979',
                    'account_name' => 'CANG SP ITC',
                    'status' => 'PENDING',
                    'expired_time' => $expired_time,
                    'service_code' => 'QR_PAYMENT',
                    'user_id' => $this->session->userdata('UserID') ?? 'andb',
                    'user_name' => $this->session->userdata('UserName') ?? 'Admin User',
                    'ip_address' =>  $data['ip_address'] ?? '',
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                    'full_response' => $input['full_response'] ?? '',
                    'pg_order_info' => $data['order_info'] ?? '',
                ];
            if ($this->mbbank) {
                $saveResult = $this->mbbank->saveTransaction($transactionData);
                if ($saveResult['success']) {
                    echo json_encode(['Status' => true, 'Data' => $result]);
                    exit;
                }
                else {
                    echo json_encode([
                        'Status' => false,
                          'error' => [
                            'title' => 'Lỗi hệ thống',  
                            'message' => 'Vui lòng liên hệ quản trị viên!'
                        ]
                    ]);
                    exit;
                }
            }
            else {
                echo json_encode([
                    'Status' => false,
                      'error' => [
                        'title' => 'Lỗi hệ thống',
                        'message' => 'Vui lòng liên hệ quản trị viên!'
                    ]
                ]);
                    exit;
            }
    }
    }
    private function CallApiCreateQrMb($data, $header)
    {
        try {
            $apiUrl = $this->config->item('mbbank_create_order_url');
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'ClientMessageId: ' . ($header['ClientMessageId'] ?? ''),
                    'transactionId: ' . ($header['transactionId'] ?? ''),
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $header['tokenResult']
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            if ($curlError) {
                 throw new Exception(
                        "CURL Error: $curlError | HTTP Code: $httpCode | Response: $response"
                    );
            }

            if ($httpCode !== 200) {
                throw new Exception(
                        "HTTP Error: $httpCode | cURL Error: $curlError | Response: $response"
                    );
            }
            $logData = [
                'transaction_ref_id' => $data['order_reference'] ?? '',
                'api_endpoint' => 'pg-paygate-create-order',
                'request_data' => $data,
                'response_data' => $response ? json_decode($response, true) : null,
                'http_code' => $httpCode,
                'status' => $curlError ? 'error' : ($httpCode === 200 ? 'success' : 'failed'),
                'error_message' => $curlError ?: ''
            ];
            $this->mbbank->saveAPIResponse($logData);
            return json_decode($response, true);
        } catch (Exception $e) {
            log_message('error', 'CallApiCreateQrMb failed: ' . $e->getMessage());
            return null;
        }
    }
        public function checkStatusWithMbbank()
    {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                return [
                    'success' => false,
                    'error' => 'Dữ liệu không hợp lệ!'
                ];
            }
            $data['merchant_id'] =  $this->config->item('mbbank_merchant_id');
            $queryString = $this->generateMac($data);
            $secretKey = $this->config->item('mbbank_secret_key');
            $data['mac'] = strtoupper(md5($secretKey . $queryString));
            $data['mac_type'] = $this->config->item('mbbank_mac_type');
            $transactionId = $this->generateUUID();
            $clientMessageId = $this->generateUUID();
            $tokenResult = $this->getAccessTokenFromMBBank();
            if (!$tokenResult['success']) {
                  return [
                    'success' => false,
                    'error' => 'Lấy token thất bại !'
                ];
            };
            $headerRequest = [
                'ClientMessageId' => $clientMessageId,
                'transactionId' => $transactionId,
                'tokenResult' => $tokenResult['access_token'],
            ];
            $result = $this->CallApiQueryV1Mb($data,$headerRequest);
            if($result) {
                $logData = [
                    'transaction_ref_id' => $data['order_reference'] ?? '',
                    'api_endpoint' => 'pg-paygate-check-status',
                    'request_data' => $data,
                    'response_data' => $result ?? null,
                    'http_code' => $httpCode,
                    'status' => $curlError ? 'error' : ($httpCode === 200 ? 'success' : 'failed'),
                    'error_message' => $curlError ?: ''
                ];
               $this->mbbank->saveAPIResponse($logData);
                $dataUpdate = [
                    'transaction_ref_number' => $result['transaction_number'],
                    'pg_issuer_txn_reference' => $result['ft_code']
                ];
                //Xem thêm dữ liệu update
                $this->mbbank->updateStatus($data['order_reference'], $result['transaction_number'], 'PAID', $dataUpdate);
                echo json_encode(['Status' => 'PAID']);
                exit;
            }
            elseif($result === 'err') {
                echo json_encode(['Status' => 'ERROR']);
            }
            else {
                echo json_encode(['Status' => 'PENDING']);
                    exit;
            }
    }
        private function CallApiQueryV1Mb($data, $header)
    {
        try {
            $apiUrl = $this->config->item('mbbank_query_url'); // nhớ khai báo URL thật
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'ClientMessageId: ' . ($header['ClientMessageId'] ?? ''),
                    'transactionId: ' . ($header['transactionId'] ?? ''),
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $header['tokenResult']
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            if ($curlError) {
                 throw new Exception(
                        "CURL Error: $curlError | HTTP Code: $httpCode | Response: $response"
                    );
            }

            if ($httpCode !== 200) {
                throw new Exception(
                        "HTTP Error: $httpCode | cURL Error: $curlError | Response: $response"
                    );
            }

            $responseApi = json_decode($response, true);
            if($responseApi['error_code'] == 00) {
                return $responseApi;
            }
            return null;
        } catch (Exception $e) {
            log_message('error', 'CallApiCreateQrMb failed: ' . $e->getMessage());
            return 'err';
        }
    }


    private function generateMac($data) {
                $keys = array_keys($data);
                sort($keys);
                $parts = [];
                foreach ($keys as $key) {
                    // Bỏ các giá trị rỗng/null/undefined và key "mac_type"
                    if ($key === "mac_type") continue;
                    if (!isset($data[$key]) || $data[$key] === "") continue;

                    $parts[] = $key . "=" . $data[$key];
                }

                // Nối lại thành chuỗi query
                return implode("&", $parts);
        }
         private function generateShortOrderReference()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $result = '';
        for ($i = 0; $i < 15; $i++) {
            $result .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $result;
    }
   private function getClientIP()
    {
        // Check for various headers that might contain the real IP
        $ipHeaders = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',            // Proxy
            'HTTP_X_FORWARDED_FOR',      // Load balancer/proxy
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR'                // Standard
        ];

        foreach ($ipHeaders as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);

                // Validate IP address
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        // Fallback to REMOTE_ADDR or default
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
      private function generateUUID()
    {
        // Generate UUID v4
        $data = random_bytes(16);

        // Set the version (4) and variant bits
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Variant 10

        // Format as UUID string
        return sprintf(
            '%08s-%04s-%04s-%04s-%12s',
            bin2hex(substr($data, 0, 4)),
            bin2hex(substr($data, 4, 2)),
            bin2hex(substr($data, 6, 2)),
            bin2hex(substr($data, 8, 2)),
            bin2hex(substr($data, 10, 6))
        );
    }
    private function getAccessTokenFromMBBank()
    {
        try {
            $clientId = $this->config->item('mbbank_client_id'); 
            $clientSecret = $this->config->item('mbbank_client_secret'); 
            $apiUrl = $this->config->item('mbbank_token_url'); 
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Accept: application/json'
                ],
                CURLOPT_USERPWD => $clientId . ':' . $clientSecret,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            if ($curlError) {
                 throw new Exception(
                        "CURL Error: $curlError | HTTP Code: $httpCode | Response: $response"
                    );
            }

            if ($httpCode !== 200) {
                throw new Exception(
                        "HTTP Error: $httpCode | cURL Error: $curlError | Response: $response"
                    );
            }
            $responseData = json_decode($response, true);
            if (!$responseData || !isset($responseData['access_token'])) {
                throw new Exception('Invalid token response');
            }
            return [
                'success' => true,
                'access_token' => $responseData['access_token'],
                'expires_in' => $responseData['expires_in']
            ];
        } catch (Exception $e) {
            log_message('error', 'MbbankGetToken Error: ' . $e->getMessage());
            return [
                'success' => false,

            ];
        }
    }
    private function CallApiRefundMb($accessToken, $formData) {
        try {
            $clientMessageId = $this->generateUUID();
            $transactionId = $this->generateUUID();
            $url = $this->config->item('mbbank_refund_url'); 
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true); // bật POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formData)); // gửi JSON body
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Bearer ' . $accessToken,
                    'clientMessageId: ' . $clientMessageId,
                    'transactionId: ' . $transactionId
            ]);
            $response = curl_exec($ch);
            $curlError = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
             if ($curlError) {
                 throw new Exception(
                        "CURL Error: $curlError | HTTP Code: $httpCode | Response: $response"
                    );
            }
            if ($httpCode !== 200) {
                throw new Exception(
                        "HTTP Error: $httpCode | cURL Error: $curlError | Response: $response"
                    );
            }
            $data = json_decode($response, true);
            $logData = [
                'transaction_ref_id' => $formData['transaction_reference_id'] ?? '',
                'api_endpoint' => 'pg-paygate-refund',
                'request_data' => $formData,
                'response_data' => $data ?? null,
                'http_code' => $httpCode,
                'status' => $curlError ? 'error' : ($httpCode === 200 ? 'success' : 'failed'),
                'error_message' => $curlError ?: ''
            ];
              $this->mbbank->saveAPIResponse($logData);
              return $data;
            } catch (Exception $e) {
                return false;
                log_message('error', 'Refund Error: ' . $e->getMessage());
            }
    }
     public function requireRefund()
    {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            $DraftId = $data['DraftId'] ?? null;
            unset($data['DraftId']);
            $secretKey = $this->config->item('mbbank_secret_key');
            $data['merchant_id'] =  $this->config->item('mbbank_merchant_id');
            $data['access_code'] = $this->config->item('mbbank_access_code');
            $queryString = $this->generateMac($data);
            $data['mac'] = strtoupper(md5($secretKey . $queryString));
            $data['mac_type'] = $this->config->item('mbbank_mac_type');
            if (!$data) {
                return [
                    'success' => false,
                    'error' => 'Dữ liệu không hợp lệ!'
                ];
            }
            $tokenResult = $this->getAccessTokenFromMBBank();
            $UpdateApi = $this->CallApiRefundMb($tokenResult['access_token'], $data);
            if($UpdateApi) {
                $result = $this->mbbank->updateRefund($UpdateApi['refund_reference_id'], $UpdateApi['refund_amount'], $DraftId);
                if($result) {
                    echo json_encode(['Status' => true, 'Message' => 'Thành công']);
                    exit;
                }
                else {
                    echo json_encode(['Status' => false, 'Message' => 'Lỗi máy chủ']);
                    exit;
                }
            }
            else {
                echo json_encode(['Status' => false, 'Message' => 'Lỗi đường truyền']);
                    exit;
            }
    }
}
