<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MbbankPublish extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("MBBank_model", "mbbank");
          // Load MB Bank configuration
        $this->load->config('mbbank_config');
    }
    public function MbbankIPN()
    {
        header('Content-Type: application/json');
    try{
            //Input Params
          $params = [
                'pg_amount'             => $this->input->get('pg_amount'),
                'pg_currency'           => $this->input->get('pg_currency'),
                'pg_merchant_id'        => $this->input->get('pg_merchant_id'),
                'pg_order_info'         => $this->input->get('pg_order_info'),
                'pg_order_reference'    => $this->input->get('pg_order_reference'),
                'pg_payment_method'     => $this->input->get('pg_payment_method'),
                'pg_card_number'        => $this->input->get('pg_card_number'),
                'pg_card_holder_name'        => $this->input->get('pg_card_holder_name'),
                'pg_payment_channel'    => $this->input->get('pg_payment_channel'),
                'pg_issuer_txn_reference'=> $this->input->get('pg_issuer_txn_reference'),
                'pg_issuer_code'        => $this->input->get('pg_issuer_code'),
                'error_code'            => $this->input->get('error_code'),
                'pg_issuer_respose_code'=> $this->input->get('pg_issuer_respose_code'),
                'pg_paytime'            => $this->input->get('pg_paytime'),
                'pg_transaction_number' => $this->input->get('pg_transaction_number'),
                'session_id'            => $this->input->get('session_id'),
                'mac_type'              => $this->input->get('mac_type'),
                'mac'                   => $this->input->get('mac')
            ];
            $logData = [
                        'transaction_ref_id' => $params['pg_order_reference'] ?? '',
                        'api_endpoint' => 'pg-paygate-ipn',
                        'request_data' => $params,
                        'response_data' => 'SUCCESS',
                        'http_code' => '200',
                        'status' => 'success',
                    ];
             $this->mbbank->saveAPIResponse($logData);
            //Vaidate 
            if($params['pg_merchant_id'] !== $this->config->item('mbbank_merchant_id')) {
                http_response_code(400); // Bad Request
                echo json_encode([
                    "status" => "FAILED",
                    "error_code" => "01",
                    "message" => "Payment notification failed: merchant_id invalid",

                ]);
                return ;
            }
            $bookingNo = explode(' ', $params['pg_order_info'])[1];
            $checkPayment = $this->mbbank->getPayment_IPN($params['pg_order_reference'], $bookingNo, $params['session_id']);
            if(empty($checkPayment)) {
                http_response_code(400); // Bad Request
                echo json_encode([
                    "status" => "FAILED",
                    "error_code" => "01",
                    "message" => "Payment notification failed: ERR_INVALID_ORDER",

                ]);
                return ;
            }
            else {
                if($checkPayment[0]['amount'] === $params['pg_amount'])
                {   
                    $dataUpdate = [
                        'status' => 'PAID',
                        'pg_payment_method' => $params['pg_payment_method'],
                        'pg_order_info' => $params['pg_order_info'],
                        'pg_card_number' => $params['pg_card_number'],
                        'pg_card_holder_name' => $params['pg_card_holder_name'],
                        'pg_payment_channel' => $params['pg_payment_channel'],
                        'pg_issuer_txn_reference' => $params['pg_issuer_txn_reference'],
                        'transaction_ref_number' => $params['pg_transaction_number'],
                        'pg_issuer_code' => $params['pg_issuer_code'],
                        'pg_paytime' => $params['pg_paytime'],
                        'mac_type' => $params['mac_type'],
                        'mac' => $params['mac']
                    ];
                    $this->mbbank->updateStatusIPN($params['pg_order_reference'], $bookingNo, $params['session_id'], $dataUpdate);
                    http_response_code(200);
                    $this->pushStatus($bookingNo);
                    echo json_encode([
                           "status" => "SUCCESS",
                           "message" => "Payment notificationreceived and processed.",
                       ]);
                    exit;
                }
                else {
                    http_response_code(400); // Bad Request
                    echo json_encode([
                        "status" => "FAILED",
                        "error_code" => "01",
                        "message" => "Payment notification failed: ERR_FALSE_CHECKSUM",
                    ]);
                    return ;
                }
            }
    }   catch(Exception $e) {
            log_message('error', 'MBBank_model::updateStatus Error: ' . $e->getMessage());
             http_response_code(500); // Bad Request
                    echo json_encode([
                        "status" => "FAILED",
                        "error_code" => "500",
                        "message" => "INTERNAL SERVER ERROR",
                    ]);
                    return ;
    }

    }
    private function getJwtByEirNo($eirNo) {
        $eirNo = (string)$eirNo;
        $file = APPPATH . '/cache/socket_sever.json';
        if (!file_exists($file)) {
            return null;
        }

        $jsonData = file_get_contents($file);
        $data = json_decode($jsonData, true); // decode thành mảng
        if (isset($data[$eirNo])) {
            return $data[$eirNo]; // trả về token
        }

    return null; // không tìm thấy
}
      private function pushStatus($EirNo)
        {
                $url = "http://127.0.0.1:8081/pushStatus";
                $jwt = $this->getJwtByEirNo($EirNo);
                $data = [
                    "token" => $jwt,
                ];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
                // Ví dụ dùng
        }
}
