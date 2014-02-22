<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SportController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('table');
		$this->load->model('authentication','',TRUE);
		$this->load->model('sportList','',TRUE);
		$this->load->library('form_validation');
	}
	function index()
	{
		$this->sportlist();
	}
	function sportlist()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['headline'] = "Sport Listing";
			$data['include'] = 'sport_index';
			$data['sports_query'] = $this->sportList->getSportList();
			$data['curController'] = $this->uri->segment(1);
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
			$data['include'] = 'sport_add';
			$data['curController'] = $this->uri->segment(1);
			$this->load->view('template', $data);
		}
		else
			redirect('login');
	}
	
	function create()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$this->form_validation->set_rules('sportname','Sportname','trim|required|strtolower|xss_clean|callback_sportname_exist');
			if($this->form_validation->run()==FALSE)
			{
				$this->addSport();
			}
			else
			{
				$this->sportList->addSport($_POST['sportname']);
				$message="Sport added";
				redirect('sportController/sportlist');
			}
		}
		else
			redirect('login');
	}
	
	function remove()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$sport_id = $this->uri->segment(3);
			$this->sportList->disableSport($sport_id);
			redirect('sportController/index','refresh');
		}
		else
			redirect('login');
	}
	
	function edit()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$sport_id = $this->uri->segment(3);
			$sport_id=array('sportid'=> $sport_id);
			$this->session->set_userdata($sport_id);
			redirect('sportController/update');
		}
		else
			redirect('login');	
	}
	
	function update()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$this->form_validation->set_rules('sportname','Sportname','trim|required|strtolower|xss_clean|callback_sportname_exist');
			if($this->form_validation->run()==FALSE)
			{
				$id=$this->session->userdata('sportid');
				$data['row'] = $this->sportList->getSportById($id)->result();
				$data['title'] = "Donut Fortress League Management System: Sport Module";
				$data['headline'] = "Edit Sport Name";
				$data['include'] = 'sport_edit';
				$data['curController'] = $this->uri->segment(1);
				$this->load->view('template', $data);

			}
			else
			{
				$this->sportList->updateSport($_POST['sport_id'], $_POST);
				redirect('sportController/sportlist');
			}
		}
		else
			redirect('login');
	}
	
	function sportname_exist($sportname)
    {
		$this->form_validation->set_message('sportname_exist','Sport name already exist!'); 
		if($this->sportList->checkIfSportnameExist($sportname))
			return FALSE;
		else
			return TRUE;
    }
}