<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
        function __construct()
        {               
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('credentialModel','',TRUE);
        }

		public function index()
        {
			if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
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
			if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
			{
				redirect('home/edit');
			}
			else
			{
				redirect('login');
			}
		}
		function edit()
		{
			if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
			{	
				$this->form_validation->set_rules('oldpass','Current Password','callback_incorrectoldpass|xss_clean');
				$this->form_validation->set_rules('newpass','New Password','trim|required|alpha_numeric|min_length[2]|xss_clean');
				$this->form_validation->set_rules('pass_confirm','Confirm Password','required|matches[newpass]|xss_clean');		
				if($this->form_validation->run()==FALSE)
				{
					$data['headline'] = "Edit Your Password";
					$data['include'] = 'home/home_editpass';
					$data['title'] = "Donut Fortress League Management System: League Manager Panel";
					$data['nav'] = 'home/home_navigation';
					$data['masthead'] = 'home/home_masthead';
					$data['sidebar'] = 'home/home_sidebar';	
					$this->load->view('template', $data);
				}
				else
				{
					$result=$this->credentialModel->changePassword($this->session->userdata('username'),$_POST['newpass']);
					if($result==1)
					{
						$notif=array('notification'=> "Password Successfully Changed");
						$this->session->set_userdata($notif);
						redirect('home');
						
					}
					else
						redirect('initial');
				}
			}
			else
			{
				redirect('initial');
			}
		}
		function incorrectoldpass($oldpass)
		{
			$this->form_validation->set_message('incorrectoldpass','The Current password is incorrect');  
			if($this->credentialModel->checkIfCorrectPassword($oldpass))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
}
?>