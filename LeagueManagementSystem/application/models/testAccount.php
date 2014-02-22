<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TestAccount extends CI_Model 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
				$this->load->model('account','',TRUE);
        }
        /* In this test, the valid values of the credentials are the following:
         *	 	Username: myUsername
         * 		Password: myPassword
         * We assume that this credentials has already exist in database.
		 * To pass this Test, you need to insert first this credentials in the database (Note: The query code is provided in the README text) before you run this test.
		 */
		 
        function testCorrectCredentials()
        {
			$account=$this->account->constructor("myUsername","myPassword");
			$result = $account->login();
			$test_res = $result; // matches content, the login function will return 1
			$expected_result =1;
			$test_name = 'Correct Credentials';
			$this->unit->run($test_res, $expected_result, $test_name); 
			$this->unit->result();
        }
		
		function testIncorrectCredentials()
        {
			$account=$this->account->constructor("IncorrectUsername","IncorrectPassword");
			$result = $account->login();
			$test_res = $result; 
			$expected_result ="Invalid Username or Password";
			$test_name = 'Incorrect Credentials';
			$this->unit->run($test_res, $expected_result, $test_name); 
        }
		
		 function testBlankUsername()
        {
			$account=$this->account->constructor("","CorrectOrInCorrectPassword");
			$result = $account->login();
			$test_res = $result; 
			$expected_result = "Invalid Username or Password";
			$test_name = 'Blank Username';
			$this->unit->run($test_res, $expected_result, $test_name); 
        }
		function testBlankPassword()
        {
			$account=$this->account->constructor("CorrectOrInCorrectUsername","");
			$result = $account->login();
			$test_res = $result; 
			$expected_result = "Invalid Username or Password";
			$test_name = 'Blank Password';
			$this->unit->run($test_res, $expected_result, $test_name); 
        }
}
?>