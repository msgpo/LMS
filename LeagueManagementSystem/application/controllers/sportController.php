<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SportController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		// load helpers
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
		$sports_qry = $this->sportList->getSportList();

		
		
		// generate HTML table from query results
		//$sports_table = $this->table->generate($sports_qry);
	
		// display information for the view
		$data['title'] = "Donut Fortress League Management System: Sport Module";
		$data['headline'] = "Sport Listing";
		$data['include'] = 'sport_index';
		$data['sports_query'] = $sports_qry;
		$data['masthead'] = 'sport_masthead';
		$data['nav'] = 'sport_navigation';
		$data['sidebar'] = 'sport_sidebar';
		
		$this->load->view('template', $data);
		}
		else
			redirect('login');
	}
	
	function addSport()
	{
		$this->load->helper('form');
		// display information for the view
		$data['title'] = "Donut Fortress League Management System: Sport Module";
		$data['headline'] = "Add a New Sport";
		$data['include'] = 'sport_add';
		$data['masthead'] = 'sport_masthead';
		$data['nav'] = 'sport_navigation';
		$data['sidebar'] = 'sport_sidebar';
		$this->load->view('template', $data);
	}
	
	function create()
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
	
	function remove()
	{
		$sport_id = $this->uri->segment(3);
		$this->sportList->disableSport($sport_id);
		redirect('sportController/index','refresh');
	}
	function edit()
	{
		$this->load->helper('form');
		$sport_id = $this->uri->segment(3);
		$sport_id=array('sportid'=> $sport_id);
		$this->session->set_userdata($sport_id);
		redirect('sportController/update');
		
	}
	
	function update()
	{
		$this->form_validation->set_rules('sportname','Sportname','trim|required|strtolower|xss_clean|callback_sportname_exist');
		if($this->form_validation->run()==FALSE)
		{
			$id=$this->session->userdata('sportid');
			$data['row'] = $this->sportList->getSportById($id)->result();
			$data['title'] = "Donut Fortress League Management System: Sport Module";
			$data['headline'] = "Edit Sport Name";
			$data['include'] = 'sport_edit';
			$data['masthead'] = 'sport_masthead';
			$data['nav'] = 'sport_navigation';
			$data['sidebar'] = 'sport_sidebar';
			$this->load->view('template', $data);

		}
		else
		{
			$this->sportList->updateSport($_POST['sport_id'], $_POST);
			redirect('sportController/sportlist');
		}
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