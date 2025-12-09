<?php
defined('BASEPATH') OR exit('');

class database_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }

}