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
		$sports_qry = $this->sportList->getSportList();
		$data['headline'] = "Sport Listing";
		$data['sports_query'] = $sports_qry;
		$data['masthead'] = 'sport/sport_masthead';
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			// League Manager View
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['include'] = 'sport/sport_index';
			$data['nav'] = 'sport/sport_navigation';
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
			$sport=new Sport($_POST['sportname']);
			$result=$this->sportList->addSport($sport);
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
			$data['row'] = $this->sportList->getSportById($id)->result();
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
			$newsport=new Sport($_POST['sportname']);
			$result=$this->sportList->editSport($_POST['sport_id'], $newsport);
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
	}
	
	function remove()
	{
		$sport_id = $this->uri->segment(3);
		$this->sportList->disableSport($sport_id);
		redirect('sportController/index');
	}
	
}
?>
