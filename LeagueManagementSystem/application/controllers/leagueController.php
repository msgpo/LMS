<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LeagueController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		// load helpers
		$this->load->helper('url');
		$this->load->library('table');
		$this->load->model('authentication','',TRUE);
		//$this->load->model('leagueList','',TRUE);
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
			{
				$data['title'] = "Donut Fortress League Management System: League Module";
				$data['headline'] = "League Listing";
				$data['include'] = 'league/league_index';
				$data['masthead'] = 'league/league_masthead';
				$data['nav'] = 'league/league_navigation';
				$data['sidebar'] = 'league/league_sidebar';
				$this->load->view('template', $data);
			}
			else
				redirect('login');
	}
}
