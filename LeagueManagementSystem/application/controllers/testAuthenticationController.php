<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestAuthenticationController extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
                $this->load->model('tests/testAuthentication','',TRUE);
        }

        public function index()
        {
                $this->testAuthentication->testCorrectCredentials();
                $this->testAuthentication->testIncorrectCredentials();
                $this->testAuthentication->testBlankUsername();
                $this->testAuthentication->testBlankPassword();
                echo $this->unit->report();
                echo base_url();
        }
}
?>