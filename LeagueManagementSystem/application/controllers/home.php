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
				// $data['curController'] = $this->uri->segment(1);
				$data['title'] = "Donut Fortress League Management System: League Manager Panel";
				$data['headline'] = "Welcome.";
				$data['include'] = 'home/home_index';
				$data['nav'] = 'home/home_navigation';
				$data['masthead'] = 'home/home_masthead';
				$data['sidebar'] = 'home/home_sidebar';
				$this->load->view('template', $data);
			}
			else
			{
				redirect('login');
			}
		}
		
		function editPassword()
		{
			if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
			{
				$data['title'] = "Donut Fortress League Management System: League Manager Panel";
				$data['headline'] = "Edit Your Password";
				$data['include'] = 'home/home_editpass';
				$data['nav'] = 'home/home_navigation';
				$data['masthead'] = 'home/home_masthead';
				$data['sidebar'] = 'home/home_sidebar';
				$this->load->view('template', $data);
			}
			else
			{
				redirect('login');
			}
		}
}
?>