<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestAuthentication extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
				$this->load->model('credentialModel','',TRUE);
        }
		/* In this test, the valid values of the credentials are the following:
         *	 	Username: myUsername
         * 		Password: myPassword
         * We assume that this credentials has already exist in database.
		 * To pass this Test, you need to insert first this credentials in the database (Note: The query code is provided in the README text) before you run this test.
		 */
        public function index()
        {
                $this->testCorrectCredentials();
                $this->testIncorrectCredentials();
                $this->testBlankUsername();
                $this->testBlankPassword();
                echo $this->unit->report();
                echo base_url();
        }
		 function testCorrectCredentials()
        {
			$account=new Account("myUsername","myPassword");
			$result=$this->credentialModel->login($account);
			$test_res = $result; 
			$expected_result =1;
			$test_name = 'Correct Credentials';
			$this->unit->run($test_res, $expected_result, $test_name); 
        }
		
		function testIncorrectCredentials()
        {
			$account=new Account("IncorrectUsername","IncorrectPassword");
			$result=$this->credentialModel->login($account);
			$test_res = $result; 
			$expected_result ="Invalid Username or Password";
			$test_name = 'Incorrect Credentials';
			$this->unit->run($test_res, $expected_result, $test_name); 
        }
		
		 function testBlankUsername()
        {
			$account=new Account("","CorrectOrInCorrectPassword");
			$result=$this->credentialModel->login($account);
			$test_res = $result; 
			$expected_result = "Invalid Username or Password";
			$test_name = 'Blank Username';
			$this->unit->run($test_res, $expected_result, $test_name); 
        }
		function testBlankPassword()
        {
			$account=new Account("CorrectOrInCorrectUsername","");
			$result=$this->credentialModel->login($account);
			$test_res = $result; 
			$expected_result = "Invalid Username or Password";
			$test_name = 'Blank Password';
			$this->unit->run($test_res, $expected_result, $test_name); 
        }
}
?>