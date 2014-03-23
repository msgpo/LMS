<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SportController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('credentialModel','',TRUE);
		$this->load->model('sportList','',TRUE);
//		$this->load->library('pagination');
	}
	
	function index()
	{
		$this->sportlist();
	}
	
	function sportlist()
	{
		$config = array();
		$config["base_url"] = base_url() . "index.php/sportController/sportlist";
		$config["total_rows"] = $this->sportList->countAllAvailableSports()->row()->record_count;
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// $sports_qry = $this->sportList->getSportList();
		$sports_qry = $this->sportList->getSportListWithLimit($config["per_page"], $page);
		$data['headline'] = "Sport Listing";
		$data['sports_query'] = $sports_qry;
		$data['masthead'] = 'sport/sport_masthead';
		$data['links'] = $this->pagination->create_links();
		
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			// League Manager View
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['include'] = 'sport/sport_index';
			$data['nav'] = 'home/home_navigation';
			$data['sidebar'] = 'sport/sport_sidebar';
		}
		else
		{
			// Guest View
			$data['title'] = "Donut Fortress League Management System: Sport List";
			$data['include'] = 'sport/sport_index_guest';
			$data['nav'] = 'sport/sport_navigation_guest';
			$data['sidebar'] = 'sport/sport_sidebar_guest';
		}
		$this->load->view('template', $data);
	}
	
	function addSport()
	{	
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['headline'] = "Add a New Sport";
			$data['include'] = 'sport/sport_add';
			$data['masthead'] = 'sport/sport_masthead';
			$data['nav'] = 'home/home_navigation';
			$data['sidebar'] = 'sport/sport_sidebar';
			$this->load->view('template', $data);
			$this->session->unset_userdata('err');
		}
		else
			redirect('login');
	}
	
	function create()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$sport=new Sport($_POST['sportname']);
			$result=$this->sportList->addSport($sport);
			if($result==1)
			{
				$notif=array('notification'=> "A new Sport has been succesfully created");
				$this->session->set_userdata($notif);
				echo $result;
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				//redirect('sportController/addSport');
				echo $errors['err'];
			}
		}
		else
			redirect('login');
	}
	
	
	function edit()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$id = $this->uri->segment(3);
			$data['row'] = $this->sportList->getSportById($id)->result();
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['headline'] = "Edit Sport Name";
			$data['include'] = 'sport/sport_edit';
			$data['masthead'] = 'sport/sport_masthead';
			$data['nav'] = 'home/home_navigation';
			$data['sidebar'] = 'sport/sport_sidebar';
			$this->load->view('template', $data);
			$this->session->unset_userdata('err');
		}
		else
			redirect('login');
	}
	
	function update()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$newsport=new Sport($_POST['sname']);
			$result=$this->sportList->editSport($_POST['id'], $newsport);
			if($result==1)
			{
				$notif=array('notification'=> "A Sport has succesfully updated");
				$this->session->set_userdata($notif);
				echo $result;
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				echo $errors['err'];
			}
		}
		else
			redirect('login');
	}
	
	function remove()
	{
		//$sport_id = $this->uri->segment(3);
		$sport_id = $_POST['sport_id'];
		$result= $this->sportList->disableSport($sport_id);
		if($result==1)
		{
			$notif=array('notification'=> "A Sport has succesfully removed");
			$this->session->set_userdata($notif);
			echo $result;
		}
		else
			echo $result;
			//$notif=array('notification'=> $result);
	}
	
	function getSports()
	{
		$result = array();
		$sport_query = $this->sportList->getSportList();
		
		 echo json_encode($sport_query->result());
	}
}
?>
