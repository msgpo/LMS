<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
				$this->load->model('account','',TRUE);
				$this->load->model('authentication','',TRUE);
        }

		public function index()
        {
			$data['message']=null;
			$this->load->view('login',$data);
        }
		
		public function logging_in()
		{
			$account=$this->account->constructor($this->input->post("username"),$this->input->post("password"));
			$result=$this->authentication->login($account);
			if($result==null)
			{
				$credentials = array('username' => $account->getUsername(), 'password' => $account->getPassword());
				$this->session->set_userdata($credentials);
				redirect('home');
			}
			else
			{
				$data['message']=$result;
				$this->load->view('login',$data);
			}
		}
		
		function logout()
		{
			$this->session->sess_destroy();
			$data['message'] = null;
			redirect('login', $data);
		}
}
?>