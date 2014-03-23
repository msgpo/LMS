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

			if (isset($_POST['leaguename']))
				$leagues_qry = $this->leagueList->searchLeague(strtolower($_POST['leaguename']));
			else
				$leagues_qry = $this->leagueList->getAllLeagues();
			$data['leagues_query'] = $leagues_qry;
			$sportList = $this->sportList->getSportList();
			$data['sportList'] = $sportList;
			if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
			{
				// League Manager POV
				$data['title'] = "Donut Fortress League Management System: League Module";
				$data['headline'] = "League Listing";
				$data['include'] = 'league/league_index';
				$data['masthead'] = 'league/league_masthead';
				$data['nav'] = 'league/league_navigation';
				$data['sidebar'] = 'league/league_sidebar';
			}
			else
			{
				// Guest POV
				$data['title'] = "Donut Fortress League Management System: Leagues";
				$data['headline'] = "League Listing";
				$data['include'] = 'league/league_index';
				$data['masthead'] = 'league/league_masthead';
				$data['nav'] = 'initial/initial_navigation';
				$data['sidebar'] = 'league/league_sidebar';
			}
			$this->load->view('template', $data);
	}
	
	function viewLeagueInfo()
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
			if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
			{
				$data['nav'] = 'league/league_navigation';
			}
			else
			{
				$data['nav'] = 'initial/initial_navigation';
			}
			$data['sidebar'] = 'league/league_sidebar2';
			$data['tList']=$this->teamList->getAllTeamsByLeague_id($leagueID)->result();
			$this->load->view('template', $data);
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
		}
		else
			redirect('initial');
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
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				echo implode('<br />', $errors['err']);
			}
		}
		else
			redirect('initial');
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
			redirect('initial');
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
				echo $result;
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				echo implode('<br />', $errors['err']);
			}
		}
	}
	
	function deactivateLeague()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$result= $this->leagueList->deactivateLeague($_POST['league_id']);
			if($result==1)
			{
				$notif=array('notification'=> "A League has succesfully deactivated");
				$this->session->set_userdata($notif);
				echo $result;
			}
		}
		else
			redirect('initial');
	}
	
	function deactivatedLeagueList()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$deactLeagues_qry = $this->leagueList->getDeactivatedLeagues();
			$data['deactLeagues_query'] = $deactLeagues_qry;
			$data['title'] = "Donut Fortress League Management System: League Module";
			$data['headline'] = "Deactivated Leagues";
			$data['include'] = 'league/league_deactivated';
			$data['masthead'] = 'league/league_masthead';
			$data['nav'] = 'league/league_navigation';
			$data['sidebar'] = 'league/league_sidebar';
			$this->load->view('template', $data);
			$this->session->unset_userdata('err');
		}
		else
			redirect('initial');
	}
	
	function reactivateLeague()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$result= $this->leagueList->reactivateLeague($_POST['league_id']);
			if($result==1)
			{
				$notif=array('notification'=> "A League has succesfully reactivated");
				$this->session->set_userdata($notif);
				echo $result;
			}
		}
		else
			redirect('initial');
	}
	
	public function startLeague()
	{
		$leagueID = $this->uri->segment(3);
		redirect('tournamentController/startTournament/'.$leagueID);
	}
}
