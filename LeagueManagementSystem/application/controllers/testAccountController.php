<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestAccountController extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
                $this->load->model('testAccount','',TRUE);
        }

        public function index()
        {
                $this->testAccount->testCorrectCredentials();
                $this->testAccount->testIncorrectCredentials();
                $this->testAccount->testBlankUsername();
                $this->testAccount->testBlankPassword();
                echo $this->unit->report();
                echo base_url();
        }
}
?>