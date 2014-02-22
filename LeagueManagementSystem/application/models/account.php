<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Model
{
        private $username;
		private $password;
		public function __construct()
		{
			parent::__construct();
		}
		
		function constructor($username,$password)
		{
			$this->username=$username;
			$this->password=$password;
			return $this;
		}
		
		public function getUsername()
        {
			return $this->username;
        }
		
		public function getPassword()
        {
			return $this->password;
        }
		
}
?>