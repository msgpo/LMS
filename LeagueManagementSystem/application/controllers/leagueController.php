<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LeagueController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		// load helpers
		$this->load->helper('url');
		$this->load->library('table');
		$this->load->model('credentialModel','',TRUE);
		$this->load->model('leagueList','',TRUE);
		// sportList model included in order to generate a drop-down list of sports in the create league function
		$this->load->model('sportList','',TRUE);
		// Included for viewing info.
		$this->load->model('teamList','',TRUE);
	}
	
	public function index()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			if (isset($_POST['leaguename']))
				$leagues_qry = $this->leagueList->searchLeague(strtolower($_POST['leaguename']));
			else
				$leagues_qry = $this->leagueList->getAllLeagues();
			$data['leagues_query'] = $leagues_qry;
			$sportList = $this->sportList->getSportList();
			$data['sportList'] = $sportList;
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
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$leagueDetails = $this->leagueList->getLeagueById($leagueID);
			$data['leagueDetails'] = $leagueDetails;
			$data['teamLists']=$this->teamList->getAllTeamsByLeague_id($leagueID);
			$data['league_id']=$leagueID;
			$sportList = $this->sportList->getSportList();
			$data['sportList'] = $sportList;
			$data['title'] = "Donut Fortress League Management System: League Module";
			$data['headline'] = "League Information";
			$data['include'] = 'league/league_info';
			$data['masthead'] = 'league/league_masthead';
			$data['nav'] = 'league/league_navigation';
			$data['sidebar'] = 'league/league_sidebar2';
			$data['tList']=$this->teamList->getAllTeamsByLeague_id($leagueID)->result();
			$this->load->view('template', $data);
		}
		else
			redirect('login');
	}
	
	function generateLeague()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
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
			$this->session->unset_userdata('err');
		}
		else
			redirect('login');
	}
	function create()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$league= new League($_POST['leaguename'], $_POST['sport_id'], $_POST['tournamenttype'], $_POST['registrationdeadline']);
			$result=$this->leagueList->createLeague($league);
			if($result==1)
			{
				$notif=array('notification'=> "A new League has succesfully created");
				$this->session->set_userdata($notif);
				echo $result;
				//redirect('leagueController/index');
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				//echo $errors;
				echo implode('<br />', $errors['err']);
				//redirect('leagueController/generateLeague');
			}
		}
		else
			redirect('login');
	}
	
	function editLeague()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			if($this->leagueList->isStarted($leagueID))
			{
				$notif=array('notification'=> "The league cannot be edited. The league has already started");
				$this->session->set_userdata($notif);
				redirect('leagueController/viewLeagueInfo/'.$leagueID.'/');
			}
			else
			{
				$data['row']=$this->leagueList->getLeagueById($leagueID)->result();
				$sportList = $this->sportList->getSportList();
				$data['sportList'] = $sportList;
				$data['title'] = "Donut Fortress League Management System: League Module";
				$data['headline'] = "League Information";
				$data['include'] = 'league/league_edit';
				$data['masthead'] = 'league/league_masthead';
				$data['nav'] = 'league/league_navigation';
				$data['sidebar'] = 'league/league_sidebar';
				$data['league_id']=$leagueID;
				$this->load->view('template', $data);
				$this->session->unset_userdata('err');
			}
		}
		else
			redirect('login');
	}

	function update()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $_POST['league_id'];
			$league=$league= new League($_POST['leaguename'], $_POST['sport_id'], $_POST['tournamenttype'], $_POST['registrationdeadline']);
			$result=$this->leagueList->editLeague($leagueID,$league);
			if($result==1)
			{
				$notif=array('notification'=> "The League Details has succesfully updated");
				$this->session->set_userdata($notif);
				//echo $result;
				redirect('leagueController/viewLeagueInfo/'.$leagueID);
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				//echo $errors;
				redirect('leagueController/editLeague/'.$leagueID.'/');
			}
		}
	}
	
	function deactivateLeague()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$result= $this->leagueList->deactivateLeague($leagueID);
			if($result==1)
			{
				$notif=array('notification'=> "A League has succesfully deactivated");
				$this->session->set_userdata($notif);
				redirect('leagueController/index');
			}
		}
		else
			redirect('login');
	}
}
