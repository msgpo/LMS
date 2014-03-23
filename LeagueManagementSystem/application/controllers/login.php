<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
        function __construct()
        {
            parent::__construct();
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
		// $account=new Account($this->input->post("username"),$this->input->post("password"));
		$account = new Account($_POST['usrnme'], $_POST['pwd']);
		$result=$this->credentialModel->login($account);
		if($result==1)
		{
			$credentials = array('username' => $account->getUsername(), 'password' => $account->getPassword());
			$this->session->set_userdata($credentials);
			// redirect('home');
			echo $result;
		}
		else
		{
			// $data['message']=$result;
			// $this->load->view('login',$data);
			echo $result;
		}
	}
	
	function checkSetUsername()
	{
		$username = $this->session->userdata('username');
		if ($username)
			echo 1;
		else
			echo 0;
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		$data['message'] = null;
		//redirect('initial', $data);
		echo "success";
	}
}
?>
