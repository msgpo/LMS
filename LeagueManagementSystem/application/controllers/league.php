<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
				$this->load->model('authentication','',TRUE);
				
        }

		public function index()
        {
			if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
			{
				$this->load->view('home');
			}
        }
}
?>