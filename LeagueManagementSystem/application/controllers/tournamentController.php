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
		$this->load->model('singleElimTournamentList','',TRUE);
		$this->load->model('doubleElimTournamentList','',TRUE);
	}
	
	function startTournament()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$league=$this->leagueList->getLeagueById($leagueID)->result();
			if($league[0]->tournamenttype=="single elimination")
			{
				
				$result=$this->singleElimTournamentList->createTournament($leagueID);
				if($result==1)
				{
					$this->leagueList->setStarted($leagueID);
					redirect('tournamentController/viewTournament/'.$leagueID.'/');
				}
				else
					echo "Not enough teams";
			}
			else if($league[0]->tournamenttype=="double elimination")
			{
				$result=$this->doubleElimTournamentList->createTournament($leagueID);
				if($result==1)
				{
					$this->leagueList->setStarted($leagueID);
					redirect('tournamentController/viewTournament/'.$leagueID.'/');
				}
				else
					echo "Not enough teams";
			}
		}
		else
			redirect('login');
			
	}
	function viewTournament()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$league=$this->leagueList->getLeagueById($leagueID);
			if($league->row()->tournamenttype=="single elimination")
			{
				$maxRound = $this->singleElimTournamentList->getNumberOfRounds($leagueID)->row()->maxround;
				$data['winnerQuery'] = $this->singleElimTournamentList->getSpecificWinner($leagueID, $maxRound);
				$data['matches']=$this->singleElimTournamentList->getMatchesOfALeague($leagueID);
			}
			else if($league->row()->tournamenttype=="double elimination")
			{
				$maxRound = $this->doubleElimTournamentList->getNumberOfRounds($leagueID)->row()->maxround;
				$data['winnerQuery'] = $this->doubleElimTournamentList->getSpecificWinner($leagueID, $maxRound);
				$data['matches']=$this->doubleElimTournamentList->getMatchesOfALeague($leagueID);
			}
			$data['title'] = "Donut Fortress League Management System: League Module";
			$data['headline'] = 'Tournament Match-up';
			$data['include'] = 'tournament/tournament';
			$data['masthead'] = 'tournament/tournament_masthead';
			$data['nav'] = 'tournament/tournament_navigation';
			$data['league_id']= $leagueID;
			$data['sidebar'] = 'tournament/tournament_sidebar';
			$this->load->view('template', $data);
		}
		else
			redirect('login');		
	}
	
	function setMatch()
	{
		if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
		{
			$leagueID = $this->uri->segment(3);
			$matchID = $this->uri->segment(4);
			$matchDetails = $this->singleElimTournamentList->getSpecificMatch($matchID);
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
				$result=$this->singleElimTournamentList->updateMatchListing($_POST['winner'], $matchID, $leagueID);
				echo $result;
		//	echo print_r($_POST);
			}
			/*else if($league[0]->tournamenttype=="double elimination")
			{
				$result=$this->singleElimTournamentList->updateMatchListing($_POST['winner'], $matchID, $leagueID);
			}*/
			//redirect('tournamentController/viewTournament/' . $leagueID);
		}
	}
	
	function resetTournament()
	{
		$leagueID = $this->uri->segment(3);
		$this->singleElimTournamentList->resetTournament($leagueID);
		redirect('tournamentController/startTournament/'.$leagueID.'/');
	}
	
}?>
