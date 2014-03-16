<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/match.php');
include_once(APPPATH .'models/singleEliminationTournament.php');
class TournamentInitializer  extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('leagueList','',TRUE);
		$this->load->model('teamList','',TRUE);
	}
	
	function startSingleElimination($league_id)
	{
		if($this->leagueList->getLeagueById($league_id)->num_rows()>0)
		{
			
			$team_ids = $this->getTeamIDsOfALeague($league_id);
			$tournament=new SingleEliminationTournament($team_ids);
			$result= $tournament->generateMatches();
			if($result==0)
				return "Tournament Cannot be Started, Not enough teams";
			else
			{
				$matches=$tournament->getMatches();
				foreach($matches as $match)
					$this->insertMatch($match, $league_id);
				return 1;
			}
		}
		else
			return "league not found";
	}
	
	function getTeamIDsOfALeague($league_id)
	{
		$team_ids=array();
		$teams=$this->teamList->getAllTeamsByLeague_id($league_id);
		foreach($teams->result() as $team)
		{
			array_push($team_ids, $team->team_id);
		}
		return $team_ids;
	}
	
	public function insertMatch(Match $match, $league_id)
	{
		$teamA=$match->getTeamA();
		$teamB=$match->getTeamB();
		$roundNumber= $match->getRoundNumber();
		if ($teamA && !$teamB)
		{
			// no Team B
			$this->db->query("INSERT into match(league_id, team_a, roundNumber) VALUES ($league_id, $teamA, $roundNumber)");
		}
		else if (!$teamA && $teamB)
		{
			// no Team A
			$this->db->query("INSERT into match(league_id, team_b, roundNumber) VALUES ($league_id, $teamB, $roundNumber)");
		}
		else if ($teamA && $teamB)
		{
			$this->db->query("INSERT into match(league_id, team_a, team_b, roundNumber) VALUES ($league_id, $teamA, $teamB, $roundNumber)");
		}
		else if (!$teamA && !$teamB)
		{
			$this->db->query("INSERT into match(league_id, roundNumber) VALUES ($league_id, $roundNumber)");
		}
	}
	public function getMatchesOfALeague($league_id)
	{
		return $this->db->query("SELECT * FROM match where league_id=$league_id ORDER BY roundnumber");
	}
	
	//START HERE
	
	function updateMatchListing($winnerTeam, $matchID, $leagueID)
	{
		$matchDetails=$this->getSpecificMatch($matchID);
		if($winnerTeam==$matchDetails->row()->team_a)
			$loserTeam=$matchDetails->row()->team_b;
		else
			$loserTeam=$matchDetails->row()->team_a;
		$this->updateWinner($winnerTeam, $loserTeam, $matchID);
		$nextRound=($matchDetails->row()->roundnumber)+1;
		$maxRound=$this->getNumberOfRounds($leagueID)->row()->maxround;
		if($nextRound<=$maxRound) // originally <=
		{
			$nextMatch=$this->nullTeamChecker($leagueID,$nextRound)->row();
			if (!isset($nextMatch->team_a))
				$this->updateHomeTeamNextMatch($winnerTeam,$nextMatch->match_id,$leagueID);
			else if (!isset($nextMatch->team_b))
				$this->updateVisitorTeamNextMatch($winnerTeam,$nextMatch->match_id,$leagueID);
			return 1;
		}
		else
			return 0;
	}
	
	function getSpecificMatch($matchID)
	{
		return $this->db->query("SELECT * FROM match WHERE match_id = '$matchID'");
	}
	
	function updateWinner($winnerTeam, $loserTeam, $matchID)
	{
		$this->db->query("UPDATE match SET winner = $winnerTeam, loser = $loserTeam WHERE match_id = $matchID");
	}
	
	function getMatchesOfARoundNumber($roundnumber,$league_id)
	{
		return $this->db->query("SELECT * FROM match where league_id=$league_id AND roundnumber=$roundnumber");
	}
	
	function updateHomeTeamNextMatch($winnerTeam, $match_id, $leagueID)
	{
		$this->db->query("UPDATE match SET team_a = $winnerTeam WHERE league_id = $leagueID AND match_id = $match_id");
	}
		
	function updateVisitorTeamNextMatch($winnerTeam, $match_id, $leagueID)
	{
		$this->db->query("UPDATE match SET team_b = $winnerTeam WHERE league_id = $leagueID AND match_id = $match_id");
	}
	
	public function getNumberOfRounds($league_id)
	{
		return $this->db->query("SELECT count(distinct roundnumber) as maxround from match where league_id='$league_id'");
	}
	
	function nullTeamChecker($league_id, $round)
	{
		return $this->db->query("SELECT * FROM match WHERE league_id = $league_id AND roundnumber = $round AND (team_a IS NULL OR team_b IS NULL)");
	}
	
	function setStarted($league_id)
	{
		$this->db->query("UPDATE league SET isstarted = true WHERE league_id = $league_id");
	}
	
	function resetTournament($league_id)
	{
		$this->db->query("DELETE from match WHERE league_id = $league_id");
	}
	
	// Query the winner!
	function getSpecificWinner($league_id, $maxround)
	{
		return $this->db->query("SELECT match.winner, team.teamname FROM match INNER JOIN team ON (match.winner = team.team_id) WHERE match.roundnumber = $maxround AND match.league_id = $league_id");
	}
}?>