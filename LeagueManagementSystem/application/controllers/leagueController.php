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
		$this->load->model('leagueList','',TRUE);
		// sportList model included in order to generate a drop-down list of sports in the create league function
		$this->load->model('sportList','',TRUE);
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			if (isset($_POST['leaguename']))
			{
				$leagues_qry = $this->leagueList->searchLeague(strtolower($_POST['leaguename']));
			}
			else
			{
				$leagues_qry = $this->leagueList->getNotStartedLeagues();
			}
			$data['leagues_query'] = $leagues_qry;
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
	
	function viewLeagueInfo()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$leagueDetails = $this->leagueList->getLeagueById($leagueID);
			$data['leagueDetails'] = $leagueDetails;
			$data['title'] = "Donut Fortress League Management System: League Module";
			$data['headline'] = "League Information";
			$data['include'] = 'league/league_info';
			$data['masthead'] = 'league/league_masthead';
			$data['nav'] = 'league/league_navigation';
			$data['sidebar'] = 'league/league_sidebar';
			$this->load->view('template', $data);
		}
		else
			redirect('login');
	}
	
	function createLeague()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$sportList = $this->sportList->getSportList();
			$data['sportList'] = $sportList;
			$data['title'] = "Donut Fortress League Management System: League Module";
			$data['headline'] = "League Information";
			$data['include'] = 'league/league_add';
			$data['masthead'] = 'league/league_masthead';
			$data['nav'] = 'league/league_navigation';
			$data['sidebar'] = 'league/league_sidebar';
			$this->load->view('template', $data);
		}
		else
			redirect('login');
	}
}
