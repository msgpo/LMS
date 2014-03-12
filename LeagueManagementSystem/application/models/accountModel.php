<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountModel extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function passwordCheck($password)
	{
		// TODO: Hash this.
		return $this->db->query("SELECT * FROM account WHERE password = '$password'");
	}
	
	function passwordChange($username, $newPass)
	{
		// TODO: hash these passwords
		$this->db->query("UPDATE account SET password = '$newPass' WHERE username = '$username'");
	}
}