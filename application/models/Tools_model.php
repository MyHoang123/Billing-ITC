<?php
defined('BASEPATH') OR exit('');

class tools_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item("YARD_ID");
    }

    public function rptReleasedInv($fromdate = '', $todate = '', $jmode = '*', $paymentType = '*', $currency = '*', $sts = ''){
        $this->ceh->select('id.DRAFT_INV_NO, DRAFT_INV_DATE, INV_PREFIX, iv.INV_NO, iv.INV_DATE, iv.AMOUNT, iv.VAT, iv.TAMOUNT, iv.isPosted, iv.PAYER');
        $this->ceh->join('INV_DFT id', 'id.INV_NO = iv.INV_NO');
        $this->ceh->join('INV_DFT_DTL idd', 'idd.DRAFT_INV_NO = id.DRAFT_INV_NO AND SEQ = 0');
        $this->ceh->where('iv.INV_NO IS NOT NULL');
		$this->ceh->where('iv.INV_PREFIX IS NOT NULL');

        $this->ceh->where('iv.YARD_ID', $this->yard_id);
		$this->ceh->where("iv.PAYMENT_STATUS != 'C'");
		
		if( $sts != '' && $sts != '*' ){
			if($sts == 'dg') {
				$this->ceh->where('iv.isPosted', 1);
			}
			
			if($sts == 'cg') {
				$this->ceh->where("iv.isPosted = '0' OR iv.isPosted IS NULL");
			}
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

        $stmt = $this->ceh->order_by("iv.INV_DATE", "ASC")->get("INV_VAT iv");
        return $stmt->result_array();
    }

}