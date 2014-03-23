<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TeamController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('credentialModel','',TRUE);
		$this->load->model('teamList','',TRUE);
		$this->load->model('leagueList','',TRUE);
	}
	
	public function index()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
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
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$data['league_id'] = $leagueID;
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
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $_POST['league_id'];
			$newTeam = new Team($_POST['teamname'], $_POST['league_id'], $_POST['coachlastname'], $_POST['coachfirstname'], $_POST['coachphonenumber'], $_POST['teamdesc']);
			$result=$this->teamList->addTeam($newTeam);
			if($result==1)
			{
				$notif=array('notification'=> "A new Team has succesfully created");
				$this->session->set_userdata($notif);
			//	redirect('leagueController/viewLeagueInfo/'.$leagueID.'/');
				echo $result;
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
			//	redirect('teamController/addTeam/'.$leagueID.'/');
			//	echo $errors;
				echo implode('<br />', $errors['err']);
			}
		}
		else
			redirect('login');
	}
	function editTeam()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$data['league_id'] = $this->uri->segment(3);
			$team_id = $this->uri->segment(4);
			$data['row']=$this->teamList->getTeamById($team_id)->result();
			$leagues=$this->leagueList->getAllLeagues();
			$data['title'] = "Donut Fortress League Management System: Team Module";
			$data['headline'] = "Edit a  Team";
			$data['include'] = 'team/team_edit';
			$data['masthead'] = 'team/team_masthead';
			$data['nav'] = 'team/team_navigation';
			$data['sidebar'] = 'team/team_sidebar';
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
			$team_id=$_POST['team_id'];
			$leagueID=$_POST['league_id'];
			$team = new Team($_POST['teamname'], $leagueID, $_POST['coachlastname'], $_POST['coachfirstname'], $_POST['coachphonenumber'], $_POST['teamdesc']);
			$result=$this->teamList->editTeam($team_id,$team);
			if($result==1)
			{
				$notif=array('notification'=> "A Team has succesfully updated");
				$this->session->set_userdata($notif);
				echo $result;
				//redirect('leagueController/viewLeagueInfo/'.$leagueID.'/');
			}
			else
			{	
				$errors=array('err'=> $result);
				$this->session->set_userdata($errors);
				echo implode('<br />', $errors['err']);
				//redirect('teamController/editTeam/'.$leagueID.'/'.$team_id.'/');
			}
		}
		else
			redirect('login');
	}
	function removeTeam()
	{
		//$leagueID = $this->uri->segment(3);
		//$team_id = $this->uri->segment(4);
		$result=$this->teamList->removeTeam($_POST['team_id']);
		if($result==1)
		{
			$notif=array('notification'=> "A Team has succesfully removed");
			$this->session->set_userdata($notif);
			echo $result;
			//redirect('leagueController/viewLeagueInfo/'.$leagueID.'/');
		}
	}
}