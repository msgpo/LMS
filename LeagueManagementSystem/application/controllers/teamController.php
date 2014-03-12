<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TeamController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('authentication','',TRUE);
		$this->load->model('teamList','',TRUE);
		$this->load->model('leagueList','',TRUE);
	}
	
	public function index()
	{
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$teamQuery = $this->teamList->getAllTeams();
			$teamListArray = $teamQuery->result();
			$data['tList'] = $teamListArray;
			$data['title'] = "Donut Fortress League Management System: Team Module";
			$data['headline'] = "Teams List";
			$data['include'] = 'team/team_index';
			$data['masthead'] = 'team/team_masthead';
			$data['nav'] = 'team/team_navigation';
			$data['sidebar'] = 'team/team_sidebar';
			$this->load->view('template', $data);
			$this->session->unset_userdata('err');
		}
		else
		{
			redirect('login');
		}
	}
	
	function addTeam()
	{	
		// todo: redirect if no league
		if ($this->authentication->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$data['leagueID'] = $leagueID;
			$data['title'] = "Donut Fortress League Management System: Team Module";
			$data['headline'] = "Add a New Team";
			$data['include'] = 'team/team_add';
			$data['masthead'] = 'team/team_masthead';
			$data['nav'] = 'team/team_navigation';
			$data['sidebar'] = 'team/team_sidebar';
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
			$newTeam = new Team($_POST['teamname'], $_POST['league_id'], $_POST['coachlastname'], $_POST['coachfirstname'], $_POST['coachphonenumber'], $_POST['teamdesc']);
			$result=$this->teamList->addTeam($newTeam);
			if($result==1)
				redirect('teamController/index');
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				redirect('teamController/addTeam');
			}
		}
		else
			redirect('login');
	}
	// MORE FUNCTIONS TO DO
}