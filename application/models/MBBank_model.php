<?php
defined('BASEPATH') OR exit('');

class MBBank_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = "ITC";

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
        $this->AppID = $this->config->item('APP_ID');
        $this->yard_id = $this->config->item('YARD_ID');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    /**
     * Save MB Bank transaction to database
     */
    public function saveTransaction($data)
    {
        try {
            // Ensure transaction_ref_id is never NULL or empty
            $transactionRefId = $data['transaction_ref_id'] ?? '';
            if (empty($transactionRefId)) {
                $transactionRefId = 'MBTXN_' . date('YmdHis') . '_' . uniqid();
            }
            
            $insertData = array(
                'transaction_ref_id' => $transactionRefId,
                'order_id' => $data['order_id'] ?? '',
                'booking_no' => $data['booking_no'] ?? '',
                'amount' => floatval($data['amount'] ?? 0),
                'currency' => $data['currency'] ?? 'VND',
                'description' => $data['description'] ?? '',
                'qr_code' => $data['qr_code'] ?? '',
                'qr_info' => $data['qr_info'] ?? '',
                'bank_code' => $data['bank_code'] ?? 'MB',
                'account_no' => $data['account_no'] ?? '',
                'account_name' => $data['account_name'] ?? '',
                'status' => $data['status'] ?? 'PENDING',
                'expired_time' => $data['expired_time'] ?? null,
                'payment_time' => $data['payment_time'] ?? null,
                'bank_transaction_id' => $data['bank_transaction_id'] ?? '',
                'user_id' => $data['user_id'] ?? '',
                'user_name' => $data['user_name'] ?? '',
                'ip_address' => $data['ip_address'] ?? $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $data['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->ceh->insert('mbbank_payments', $insertData);
            
            if ($this->ceh->affected_rows() > 0) {
                return array(
                    'success' => true,
                    'id' => $this->ceh->insert_id(),
                    'message' => 'Transaction saved successfully'
                );
            } else {
                return array(
                    'success' => false,
                    'message' => 'Failed to save transaction'
                );
            }
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::saveTransaction Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update transaction status by order reference ID
     */
    public function updateStatusByOrderReference($orderReference, $status, $additionalData = array())
    {
        try {
            $updateData = array(
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Add additional data if provided
            if (isset($additionalData['payment_time'])) {
                $updateData['payment_time'] = $additionalData['payment_time'];
            }
            if (isset($additionalData['bank_transaction_id'])) {
                $updateData['bank_transaction_id'] = $additionalData['bank_transaction_id'];
            }
            if (isset($additionalData['transaction_number'])) {
                $updateData['bank_transaction_id'] = $additionalData['transaction_number'];
            }
            if (isset($additionalData['paid_amount'])) {
                $updateData['paid_amount'] = $additionalData['paid_amount'];
            }

            $this->ceh->where('order_id', $orderReference);
            $this->ceh->update('mbbank_payments', $updateData);
            
            if ($this->ceh->affected_rows() > 0) {
                return array(
                    'success' => true,
                    'message' => 'Status updated successfully'
                );
            } else {
                return array(
                    'success' => false,
                    'message' => 'Transaction not found or status not changed'
                );
            }
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::updateStatusByOrderReference Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update transaction status
     */
    public function updateStatus($transactionRefId, $status, $additionalData = array())
    {
        try {
            $updateData = array(
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Add additional data if provided
            if (isset($additionalData['payment_time'])) {
                $updateData['payment_time'] = $additionalData['payment_time'];
            }
            if (isset($additionalData['bank_transaction_id'])) {
                $updateData['bank_transaction_id'] = $additionalData['bank_transaction_id'];
            }
            if (isset($additionalData['paid_amount'])) {
                $updateData['paid_amount'] = $additionalData['paid_amount'];
            }
            if (isset($additionalData['paid_amount'])) {
                $updateData['transaction_number'] = $additionalData['transaction_number'];
            }
            if (isset($additionalData['pg_issuer_txn_reference'])) {
                $updateData['pg_issuer_txn_reference'] = $additionalData['pg_issuer_txn_reference'];
            }
            $this->ceh->where('transaction_ref_id', $transactionRefId);
            $this->ceh->update('mbbank_payments', $updateData);
            
            if ($this->ceh->affected_rows() > 0) {
                return array(
                    'success' => true,
                    'message' => 'Status updated successfully'
                );
            } else {
                return array(
                    'success' => false,
                    'message' => 'Transaction not found or status not changed'
                );
            }
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::updateStatus Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get payment by transaction reference ID
     */
    public function getPayment($transactionRefId)
    {
        try {
            $this->ceh->where('transaction_ref_id', $transactionRefId);
            $query = $this->ceh->get('mbbank_payments');
            
            if ($query->num_rows() > 0) {
                return array(
                    'success' => true,
                    'data' => $query->row_array()
                );
            } else {
                return array(
                    'success' => false,
                    'message' => 'Payment not found'
                );
            }
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::getPayment Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

        public function checkPayment($EirNo = '')
    {
        try {
            $this->ceh->where('status !=', 'CANCELLED');
            $this->ceh->where('booking_no', $EirNo);
            $this->ceh->order_by('id', 'DESC');
            $this->ceh->limit(1);                         
            $query = $this->ceh->get('mbbank_payments');
            if ($query->num_rows() > 0) {
                return array(
                    'success' => true,
                    'data' => $query->row_array()
                );
            } else {
                return array(
                    'success' => false,
                    'message' => 'Payment not found'
                );
            }
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::getPayment Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }


    /**
     * Get transaction by order reference ID
     */
    public function getTransactionByOrderReference($orderReference)
    {
        try {
            $this->ceh->where('order_id', $orderReference);
            $this->ceh->order_by('created_at', 'DESC');
            $this->ceh->limit(1);
            $query = $this->ceh->get('mbbank_payments');
            
            if ($query->num_rows() > 0) {
                return array(
                    'success' => true,
                    'data' => $query->row_array()
                );
            } else {
                return array(
                    'success' => false,
                    'message' => 'Transaction not found'
                );
            }
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::getTransactionByOrderReference Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get payments by booking number
     */
    public function getPaymentsByBooking($bookingNo)
    {
        try {
            $this->ceh->where('booking_no', $bookingNo);
            $this->ceh->order_by('created_at', 'DESC');
            $query = $this->ceh->get('mbbank_payments');
            
            return array(
                'success' => true,
                'data' => $query->result_array()
            );
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::getPaymentsByBooking Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get recent payments
     */
    public function getRecentPayments($limit = 50)
    {
        try {
            $this->ceh->order_by('created_at', 'DESC');
            $this->ceh->limit($limit);
            $query = $this->ceh->get('mbbank_payments');
            
            return array(
                'success' => true,
                'data' => $query->result_array()
            );
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::getRecentPayments Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get payment statistics
     */
    public function getPaymentStats()
    {
        try {
            $stats = array();
            
            // Total transactions
            $totalQuery = $this->ceh->get('mbbank_payments');
            $stats['total_transactions'] = $totalQuery->num_rows();
            
            // Successful payments
            $this->ceh->where('status', 'SUCCESS');
            $successQuery = $this->ceh->get('mbbank_payments');
            $stats['successful_payments'] = $successQuery->num_rows();
            
            // Pending payments
            $this->ceh->reset_query();
            $this->ceh->where('status', 'PENDING');
            $pendingQuery = $this->ceh->get('mbbank_payments');
            $stats['pending_payments'] = $pendingQuery->num_rows();
            
            // Failed payments
            $this->ceh->reset_query();
            $this->ceh->where('status', 'FAILED');
            $failedQuery = $this->ceh->get('mbbank_payments');
            $stats['failed_payments'] = $failedQuery->num_rows();
            
            // Total amount (successful payments only)
            $this->ceh->reset_query();
            $this->ceh->select_sum('amount');
            $this->ceh->where('status', 'SUCCESS');
            $amountQuery = $this->ceh->get('mbbank_payments');
            $amountResult = $amountQuery->row_array();
            $stats['total_amount'] = $amountResult['amount'] ?? 0;
            
            // Today's transactions
            $this->ceh->reset_query();
            $this->ceh->where('DATE(created_at)', date('Y-m-d'));
            $todayQuery = $this->ceh->get('mbbank_payments');
            $stats['today_transactions'] = $todayQuery->num_rows();
            
            return array(
                'success' => true,
                'data' => $stats
            );
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::getPaymentStats Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Save API response for debugging
     */
    public function saveAPIResponse($data)
    {
        try {
            $insertData = array(
                'transaction_ref_id' => $data['transaction_ref_id'] ?? '',
                'api_endpoint' => $data['api_endpoint'] ?? '',
                'request_data' => isset($data['request_data']) ? json_encode($data['request_data']) : '',
                'response_data' => isset($data['response_data']) ? json_encode($data['response_data']) : '',
                'http_code' => $data['http_code'] ?? 0,
                'status' => $data['status'] ?? 'unknown',
                'error_message' => $data['error_message'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->ceh->insert('mbbank_api_logs', $insertData);
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::saveAPIResponse Error: ' . $e->getMessage());
            
        }
    }

    /**
     * Clean up expired transactions
     */
    public function cleanupExpiredTransactions()
    {
        try {
            $this->ceh->where('status', 'PENDING');
            $this->ceh->where('expired_time <', date('Y-m-d H:i:s'));
            $this->ceh->update('mbbank_payments', array(
                'status' => 'EXPIRED',
                'updated_at' => date('Y-m-d H:i:s')
            ));
            
            return array(
                'success' => true,
                'affected_rows' => $this->ceh->affected_rows()
            );
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::cleanupExpiredTransactions Error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Check if table exists and create if not
     */
    public function ensureTablesExist()
    {
        try {
            $this->createMBBankPaymentsTable();
            $this->createMBBankAPILogsTable();
            return array('success' => true, 'message' => 'Tables verified/created');
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::ensureTablesExist Error: ' . $e->getMessage());
            return array('success' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * Create mbbank_payments table if not exists
     */
    private function createMBBankPaymentsTable()
    {
        $sql = "
        IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='mbbank_payments' AND xtype='U')
        BEGIN
            CREATE TABLE [dbo].[mbbank_payments] (
                [id] [int] IDENTITY(1,1) NOT NULL,
                [transaction_ref_id] [nvarchar](100) NOT NULL,
                [order_id] [nvarchar](100) NULL,
                [booking_no] [nvarchar](50) NULL,
                [amount] [decimal](18, 2) NOT NULL DEFAULT 0,
                [paid_amount] [decimal](18, 2) NULL DEFAULT 0,
                [currency] [nvarchar](10) NOT NULL DEFAULT 'VND',
                [description] [nvarchar](500) NULL,
                [qr_code] [nvarchar](max) NULL,
                [qr_info] [nvarchar](max) NULL,
                [bank_code] [nvarchar](10) NOT NULL DEFAULT 'MB',
                [account_no] [nvarchar](50) NULL,
                [account_name] [nvarchar](200) NULL,
                [status] [nvarchar](20) NOT NULL DEFAULT 'PENDING',
                [expired_time] [datetime] NULL,
                [payment_time] [datetime] NULL,
                [bank_transaction_id] [nvarchar](100) NULL,
                [user_id] [nvarchar](50) NULL,
                [user_name] [nvarchar](100) NULL,
                [ip_address] [nvarchar](50) NULL,
                [user_agent] [nvarchar](500) NULL,
                [created_at] [datetime] NOT NULL DEFAULT GETDATE(),
                [updated_at] [datetime] NOT NULL DEFAULT GETDATE(),
                CONSTRAINT [PK_mbbank_payments] PRIMARY KEY CLUSTERED ([id] ASC),
                CONSTRAINT [UK_mbbank_payments_transaction_ref] UNIQUE ([transaction_ref_id])
            )
        END
        ";
        
        $this->ceh->query($sql);
    }

    /**
     * Create mbbank_api_logs table if not exists
     */
    private function createMBBankAPILogsTable()
    {
        $sql = "
        IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='mbbank_api_logs' AND xtype='U')
        BEGIN
            CREATE TABLE [dbo].[mbbank_api_logs] (
                [id] [int] IDENTITY(1,1) NOT NULL,
                [transaction_ref_id] [nvarchar](100) NULL,
                [api_endpoint] [nvarchar](200) NULL,
                [request_data] [nvarchar](max) NULL,
                [response_data] [nvarchar](max) NULL,
                [http_code] [int] NULL DEFAULT 0,
                [status] [nvarchar](20) NULL,
                [error_message] [nvarchar](500) NULL,
                [created_at] [datetime] NOT NULL DEFAULT GETDATE(),
                CONSTRAINT [PK_mbbank_api_logs] PRIMARY KEY CLUSTERED ([id] ASC)
            )
        END
        ";
        
        $this->ceh->query($sql);
    }
        public function getListQrPayment($page = 1)
        {
            try {
                $limit = 14;
                $offset = ($page - 1) * $limit;
                $total_rows = $this->ceh->count_all('mbbank_payments');
                $this->ceh->select('*');
                $this->ceh->from('mbbank_payments');
                $this->ceh->where('status =', 'PAID');
                $this->ceh->order_by('id', 'DESC');
                $this->ceh->limit($limit, $offset); // LIMIT 14 OFFSET (page-1)*14
                return ['data' =>$this->ceh->get()->result_array(), 'total_rows' => ceil($total_rows / $limit)];
            } catch (Exception $e) {
                log_message('error', 'MBBank_model::getListQrPayment Error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ];
            }
        }
        public function getInv($Eir){
            $this->ceh->select("InvNo"); 
            $this->ceh->from("EIR");
            $this->ceh->where("EIRNo =", $Eir);
            $this->ceh->where("InvNo IS NOT NULL");
            return $this->ceh->get()->result_array();
        }
        public function getInvSrv($Eir){
            $this->ceh->select("InvNo"); 
            $this->ceh->from("SRV_ODR");
            $this->ceh->where("SSOderNo =", $Eir);
            $this->ceh->where("InvNo IS NOT NULL");
            return $this->ceh->get()->result_array();
        }
        public function getInvFromDraft($Eir){
            $this->ceh->select("INV_NO AS InvNo"); 
            $this->ceh->from("INV_DFT");
            $this->ceh->where("DRAFT_INV_NO =", $Eir);
            $this->ceh->where("INV_NO IS NOT NULL");
            return $this->ceh->get()->result_array();
        }
        public function getDraftFromDraft($Eir){
            $this->ceh->select("DRAFT_INV_NO"); 
            $this->ceh->from("INV_DFT");
            $this->ceh->where("DRAFT_INV_NO =", $Eir);
            return $this->ceh->get()->result_array();
        }
        public function getDraftFromInv($Inv){
            $this->ceh->select("DRAFT_INV_NO"); 
            $this->ceh->from("INV_DFT");
            $this->ceh->where("INV_NO =", $Inv);
            return $this->ceh->get()->result_array();
        }
        public function getDraftInv($Eir){
            $this->ceh->select("DRAFT_INV_NO"); 
            $this->ceh->from("EIR");
            $this->ceh->where("EIRNo =", $Eir);
            return $this->ceh->get()->result_array();
        }
        public function getDraftInvSSRMore($Eir){
            $this->ceh->select("DRAFT_INV_NO"); 
            $this->ceh->from("SRV_ODR");
            $this->ceh->where("SSRMORE =", $Eir);
            return $this->ceh->get()->result_array();
        }
        public function getDraftInvDetail($Draft){
            if(empty($Draft)) {
                return [];
            }
            $this->ceh->select("*"); 
            $this->ceh->from("INV_DFT_DTL");
            $this->ceh->where_in("DRAFT_INV_NO", $Draft);
            return $this->ceh->get()->result_array();
        }
        public function getDraftInvSrv($Eir){
            $this->ceh->select("DRAFT_INV_NO"); 
            $this->ceh->from("SRV_ODR");
            $this->ceh->where("SSOderNo =", $Eir);
            return $this->ceh->get()->result_array();
        }
        public function getPayment_IPN($orderReference, $bookingNo, $order_id){
            $this->ceh->select("transaction_ref_id, booking_no, amount, currency"); 
            $this->ceh->from("mbbank_payments");
            $this->ceh->where("transaction_ref_id =", $orderReference);
            $this->ceh->where("booking_no =", $bookingNo);
            $this->ceh->where("order_id =", $order_id);
            return $this->ceh->get()->result_array();
        }
    public function updateStatusIPN($transactionRefId, $bookingNo, $order_id, $additionalData = array())
    {
        try {
            $this->ceh->where('transaction_ref_id', $transactionRefId);
            $this->ceh->where("booking_no =", $bookingNo);
            $this->ceh->where("order_id =", $order_id);
            $this->ceh->update('mbbank_payments', $additionalData);
            if ($this->ceh->affected_rows() > 0) {
                return array(
                    'success' => true,
                );
            } else {
                return array(
                    'success' => false,
                );
            }
        } catch (Exception $e) {
            log_message('error', 'MBBank_model::updateStatus Error: ' . $e->getMessage());
            return array(
                'success' => false,
            );
        }
    }

}
