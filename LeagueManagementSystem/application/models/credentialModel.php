<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/account.php');
class CredentialModel extends CI_Model
{
		public function __construct()
		{
			parent::__construct();
		}

		function login(Account $account)
        {
			if($this->correctCredentials($account->getUsername(),$account->getPassword())==1)
			//	return null;
				return 1;
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
		function checkIfCorrectPassword($password)
		{
			$query=$this->db->query("SELECT * FROM account WHERE password='$password'");
			if($query->num_rows()>0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		function changePassword($username,$new_password)
		{
			if($this->checkIfLoggedIn($username))
				return $this->updatePassword($username, $new_password);
			else
				return 0;
		}
		function updatePassword($username, $new_password)
		{
			$this->db->query("UPDATE account SET password='$new_password' WHERE username='$username'");
			return 1;
		}
}
?>