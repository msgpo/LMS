<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Model
{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('account','',TRUE);
		}

		function login($account)
        {
			if($this->correctCredentials($account->getUsername(),$account->getPassword())==1)
				return null;
			else
			{
				return "Invalid Username or Password";
			}
        }
		
		function correctCredentials($username,$password)
		{
			$result=$this->db->query("SELECT * FROM account where username='$username' and password='$password'");
			if($result->num_rows()>0)
				return 1;
			else 
				return 0;
		}
		
		function checkIfLoggedIn($username)
		{
			$result=$this->db->query("SELECT * FROM account where username='$username'");
			if($result->num_rows()>0)
				return TRUE;
			else 
				return FALSE;
		}
}
?>