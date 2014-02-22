<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
				$this->load->model('authentication','',TRUE);
				$this->load->model('sportList','',TRUE);
        }

		public function index()
        {
			if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
			{
			
				// display information for the view
				$data['curController'] = $this->uri->segment(1);
				$data['title'] = "Donut Fortress League Management System: League Manager Panel";
				$data['headline'] = "Welcome.";
				$data['include'] = 'home_index';
				$this->load->view('template', $data);
			}
		}
}
?>