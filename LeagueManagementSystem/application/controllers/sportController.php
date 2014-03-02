<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SportController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('authentication','',TRUE);
		$this->load->model('sportList','',TRUE);
	}
	
	function index()
	{
		$this->sportlist();
	}
	
	function sportlist()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$sports_qry = $this->sportList->getSportList();
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['headline'] = "Sport Listing";
			$data['include'] = 'sport/sport_index';
			$data['sports_query'] = $sports_qry;
			$data['masthead'] = 'sport/sport_masthead';
			$data['nav'] = 'sport/sport_navigation';
			$data['sidebar'] = 'sport/sport_sidebar';
			$this->load->view('template', $data);
		}
		else
			redirect('login');
	}
	
	function addSport()
	{	
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['headline'] = "Add a New Sport";
			$data['include'] = 'sport/sport_add';
			$data['masthead'] = 'sport/sport_masthead';
			$data['nav'] = 'sport/sport_navigation';
			$data['sidebar'] = 'sport/sport_sidebar';
			$this->load->view('template', $data);
			$this->session->unset_userdata('err');
		}
		else
			redirect('login');
	}
	
	function create()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$result=$this->sportList->addSport($_POST['sportname']);
			if($result==1)
				redirect('sportController/sportlist');
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				redirect('sportController/addSport');
			}
		}
		else
			redirect('login');
	}
	
	
	function edit()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$id = $this->uri->segment(3);
			$data['row'] = $this->sport->getSportById($id)->result();
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['headline'] = "Edit Sport Name";
			$data['include'] = 'sport/sport_edit';
			$data['masthead'] = 'sport/sport_masthead';
			$data['nav'] = 'sport/sport_navigation';
			$data['sidebar'] = 'sport/sport_sidebar';
			$this->load->view('template', $data);
			$this->session->unset_userdata('err');
		}
		else
			redirect('login');
	}
	
	function update()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$result=$this->sportList->editSport($_POST['sport_id'],$_POST['sportname']);
			if($result==1)
				redirect('sportController/sportlist');
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				redirect('sportController/edit/'.$_POST['sport_id'].'/');
			}
		}
		else
			redirect('login');
<<<<<<< HEAD
	}
	
	function remove()
	{
		$sport_id = $this->uri->segment(3);
		$this->sportList->disableSport($sport_id);
		redirect('sportController/index');
	}
	
}
=======
	}
	
	function remove()
	{
		$sport_id = $this->uri->segment(3);
		$this->sportList->disableSport($sport_id);
		redirect('sportController/index');
	}
	
}
>>>>>>> 22a536406f443dc265634795bfe8639019747b06
