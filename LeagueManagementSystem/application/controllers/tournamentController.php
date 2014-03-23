<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TournamentController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('table');
		$this->load->model('credentialModel','',TRUE);
		$this->load->model('leagueList','',TRUE);
		$this->load->model('teamList','',TRUE);
		//$this->load->model('singleEliminationTournamentList','',TRUE);
		//$this->load->model('doubleEliminationTournamentList','',TRUE);
		$this->load->model('tournamentList','',TRUE);
	}
	
	function startTournament()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$league=$this->leagueList->getLeagueById($leagueID)->result();
			if($league[0]->tournamenttype=="single elimination")
			{
				$result=$this->singleEliminationTournamentList->createTournament($leagueID);
				if($result==1)
				{
					$this->leagueList->setStarted($leagueID);
					redirect('tournamentController/viewTournament/'.$leagueID.'/');
				}
				else
				{
					$notif=array('notification'=> $result);
					$this->session->set_userdata($notif);
					redirect('leagueController/viewLeagueInfo/'.$leagueID.'/');
				}
			}
			else if($league[0]->tournamenttype=="double elimination")
			{
				$result=$this->doubleEliminationTournamentList->createTournament($leagueID);
				if($result==1)
				{
					$this->leagueList->setStarted($leagueID);
					redirect('tournamentController/viewTournament/'.$leagueID.'/');
				}
				else
				{
					$notif=array('notification'=> $result);
					$this->session->set_userdata($notif);
					redirect('leagueController/viewLeagueInfo/'.$leagueID.'/');
				}
			}
		}
		else
			redirect('login');
	}
	function viewTournament()
	{
			$leagueID = $this->uri->segment(3);
			$league=$this->leagueList->getLeagueById($leagueID);
			if($league->row()->tournamenttype=="single elimination")
			{
				$maxRound = $this->singleEliminationTournamentList->getNumberOfRounds($leagueID);
				$data['winnerQuery'] = $this->singleEliminationTournamentList->getSpecificWinner($leagueID, $maxRound);
				$data['matches']=$this->singleEliminationTournamentList->getMatchesOfALeague($leagueID);
				$data['headline'] = 'Single Elimination Tournament Match-up';
			}
			else if($league->row()->tournamenttype=="double elimination")
			{
				$data['winnerQuery'] = $this->doubleEliminationTournamentList->getSpecificWinner($leagueID);
				$data['matches']=$this->doubleEliminationTournamentList->getMatchesOfALeague($leagueID);
				$data['headline'] = 'Double Elimination Tournament Match-up';
			}
			
			$data['title'] = "Donut Fortress League Management System: League Module";
			$data['include'] = 'tournament/tournament';
			$data['masthead'] = 'tournament/tournament_masthead';
			if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
				$data['nav'] = 'tournament/tournament_navigation';
			else
				$data['nav'] = 'initial/initial_navigation';
			$data['league_id']= $leagueID;
			$data['sidebar'] = 'tournament/tournament_sidebar';
			$this->load->view('template', $data);		
	}
	
	function setMatch()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$matchID = $this->uri->segment(4);
			$matchDetails = $this->singleEliminationTournamentList->getMatchDetails($matchID);
			$data['teamAQuery'] = $this->teamList->getTeamById($matchDetails->row()->team_a);
			$data['teamBQuery'] = $this->teamList->getTeamById($matchDetails->row()->team_b);
			$data['matchDetails']=$matchDetails;
			$data['title'] = "Donut Fortress League Management System: League Module";
			$data['headline'] = 'Set the winner';
			$data['include'] = 'tournament/setMatch';
			$data['masthead'] = 'tournament/tournament_masthead';
			$data['nav'] = 'tournament/tournament_navigation';
			$data['league_id']= $leagueID;
			$data['match_id']= $matchID;
			$data['sidebar'] = 'tournament/tournament_sidebar';
			$this->load->view('template', $data);
		}
		else
		{
			redirect('login');
		}
	}
	
	
	function updateMatch()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $_POST['league_id'];
			$matchID = $_POST['match_id'];
			$league=$this->leagueList->getLeagueById($leagueID)->result();
			if($league[0]->tournamenttype=="single elimination")
			{
				$result=$this->singleEliminationTournamentList->updateMatchListing($_POST['winner'], $matchID);
			}
			else if($league[0]->tournamenttype=="double elimination")
			{
				$result=$this->doubleEliminationTournamentList->updateMatchListing($_POST['winner'], $matchID, $leagueID);
			}
		}
	}
	
	function resetTournament()
	{
		$leagueID = $this->uri->segment(3);
		$this->singleEliminationTournamentList->resetTournament($leagueID);
		redirect('tournamentController/startTournament/'.$leagueID.'/');
	}
	
	function unstartLeague()
	{
		$leagueID = $this->uri->segment(3);
		$this->tournamentList->resetTournament($leagueID);
		$this->leagueList->setUnstarted($leagueID);
		redirect('leagueController/viewLeagueInfo/'.$leagueID.'/');
	}
	function unsetMatch()
	{
		$leagueID = $this->uri->segment(3);
		$matchID = $this->uri->segment(4);
		$league=$this->leagueList->getLeagueById($leagueID)->result();
		if($league[0]->tournamenttype=="single elimination")
		{
			$this->singleEliminationTournamentList->unsetMatch($leagueID,$matchID);
		}
		else if($league[0]->tournamenttype=="double elimination")
		{
			$result=$this->doubleEliminationTournamentList->unsetMatch($leagueID, $matchID);
		}
		redirect('tournamentController/viewTournament/'.$leagueID.'/'.$matchID.'/');
	}
}?>
