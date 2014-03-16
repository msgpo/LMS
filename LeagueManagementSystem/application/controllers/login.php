<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
        function __construct()
        {
            parent::__construct();
		//$this->load->model('account','',TRUE);
		$this->load->model('credentialModel','',TRUE);
        }

	function index()
	{
		$data['message']=null;
		$data['message']=null;
		$data['title'] = "Donut Fortress League Management System";
		$data['headline'] = "Welcome.";
		$data['include'] = 'login/login';
		$data['nav'] = 'login/login_navigation';
		$data['masthead'] = 'login/login_masthead';
		$data['sidebar'] = 'login/login_sidebar';
		$this->load->view('template', $data);
	}
	function logging_in()
	{
		$account=new Account($this->input->post("username"),$this->input->post("password"));
		$result=$this->credentialModel->login($account);
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
		redirect('initial', $data);
	}
}
?>
