<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/TournamentList.php');
class DoubleElimTournamentList  extends TournamentList 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function createTournament($league_id)
	{
		if($this->leagueList->getLeagueById($league_id)->num_rows()>0)
		{
			$team_ids = $this->getTeamIDsOfALeague($league_id);
			$tournament=new DoubleEliminationTournament($team_ids);
			$result= $tournament->generateMatches();
			if($result==0)
				return "Tournament Cannot be Started, Not enough teams";
			else
			{
				$matches=$tournament->getMatches();
				foreach($matches as $match)
				{
					$this->insertMatch($match, $league_id);
				}
				return 1;
			}
		}
		else
			return "league not found";
	}
	
	public function insertMatch(Match $match, $league_id)
	{
		$teamA=$match->getTeamA();
		$teamB=$match->getTeamB();
		$roundNumber= $match->getRoundNumber();
		$bracket=$match->getBracket();
		if ($teamA && !$teamB)
		{
			// no Team B
			$this->db->query("INSERT into match(league_id, team_a, roundnumber,bracket) VALUES ($league_id, $teamA, $roundNumber,'$bracket')");
		}
		else if (!$teamA && $teamB)
		{
			// no Team A
			$this->db->query("INSERT into match(league_id, team_b, roundnumber,bracket) VALUES ($league_id, $teamB, $roundNumber,'$bracket')");
		}
		else if ($teamA && $teamB)
		{
			$this->db->query("INSERT into match(league_id, team_a, team_b, roundnumber,bracket) VALUES ($league_id, $teamA, $teamB, $roundNumber,'$bracket')");
		}
		else if (!$teamA && !$teamB)
		{
			$this->db->query("INSERT into match(league_id, roundnumber,bracket) VALUES ($league_id, $roundNumber,'$bracket')");
		}
	}
	
	public function getMatchesOfALeague($league_id)
	{
		return $this->db->query("SELECT * FROM match where league_id=$league_id ORDER BY bracket DESC, roundnumber ASC, team_a ASC");
	}
	
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
		if($nextRound<=$maxRound)
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
	
	function updateWinner($winnerTeam, $loserTeam, $matchID)
	{
		$this->db->query("UPDATE match SET winner = $winnerTeam, loser = $loserTeam WHERE match_id = $matchID");
	}
	
	function getMatchesOfARoundNumber($roundnumber,$league_id)
	{
		return $this->db->query("SELECT * FROM match where league_id=$league_id AND roundnumber=$roundnumber AND bracket IS NULL");
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
		return $this->db->query("SELECT * FROM match WHERE league_id = $league_id AND roundnumber = $round AND (team_a IS NULL OR team_b IS NULL) AND bracket IS NULL");
	}
	
	function setStarted($league_id)
	{
		$this->db->query("UPDATE league SET isstarted = true WHERE league_id = $league_id");
	}
	
	function resetTournament($league_id)
	{
		$this->db->query("DELETE from match WHERE league_id = $league_id");
	}
	
	function getSpecificWinner($league_id, $maxround)
	{
		return $this->db->query("SELECT match.winner, team.teamname FROM match INNER JOIN team ON (match.winner=team.team_id) WHERE match.roundnumber=$maxround AND match.league_id= $league_id AND match.bracket IS NULL");
	}
	
	function getSpecificMatch($matchID)
	{
		return $this->db->query("SELECT * FROM match WHERE match_id = '$matchID'");
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
	
}?>