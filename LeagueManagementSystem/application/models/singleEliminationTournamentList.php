<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/TournamentList.php');
class SingleEliminationTournamentList  extends TournamentList 
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
			$tournament=new SingleEliminationTournament($team_ids);
			$result= $tournament->generateMatches();
			if($result==0)
				return "Tournament Cannot be Started, Not enough teams";
			else
			{
				return $this->insert($league_id,$tournament);
			}
		}
		else
			return "league not found";
	}
	
	public function insert($league_id, SingleEliminationTournament $tournament)
	{
		$matches=$tournament->getMatches();
		foreach($matches as $match)
		{
			$this->insertMatch($match, $league_id);
		}
		$this->referenceMatches($league_id);
		return 1;
	}
	
	
	public function updateMatchListing($winner,$matchID)
	{
		$matchDetails=$this->getMatchDetails($matchID);
		if($matchDetails->num_rows()>0)
		{
			return $this->update($winner, $matchDetails);
		}
		else
			return "Match not found";
	}
	
	public function update($winner, $matchDetails)
	{
		$matchID=$matchDetails->row()->match_id;
		$nextMatchID=$matchDetails->row()->nextmatch_id_for_winner;
		$this->db->query("UPDATE match set winner=$winner WHERE match_id=$matchID and accessible=true");
		return $this->updateTeamInNextMatch($winner, $nextMatchID);
		
	}
	
	public function updateTeamInNextMatch($newTeam, $nextMatchID)
	{
		if(isset($nextMatchID))
		{
			$nextMatchDetails=$this->getMatchDetails($nextMatchID);
			if(!isset($nextMatchDetails->row()->team_a))
				$this->db->query("UPDATE match set team_a=$newTeam WHERE match_id=$nextMatchID and accessible=true");
			else if(!isset($nextMatchDetails->row()->team_b))
				$this->db->query("UPDATE match set team_b=$newTeam WHERE match_id=$nextMatchID and accessible=true");
			return 1;
		}
		else
			return 0;
	}
	
	function getMatchDetails($matchID)
	{
		return $this->db->query("SELECT * FROM match WHERE match_id = $matchID");
	}
	
	
	public function insertMatch(Match $match, $league_id)
	{
		$teamA=$match->getTeamA();
		$teamB=$match->getTeamB();
		$roundNumber= $match->getRoundNumber();
		if ($teamA && !$teamB)
		{
			// no Team B
			$this->db->query("INSERT into match(league_id, team_a, roundnumber) VALUES ($league_id, $teamA, $roundNumber)");
		}
		else if (!$teamA && $teamB)
		{
			// no Team A
			$this->db->query("INSERT into match(league_id, team_b, roundnumber) VALUES ($league_id, $teamB, $roundNumber)");
		}
		else if ($teamA && $teamB)
		{
			$this->db->query("INSERT into match(league_id, team_a, team_b, roundnumber) VALUES ($league_id, $teamA, $teamB, $roundNumber)");
		}
		else if (!$teamA && !$teamB)
		{
			$this->db->query("INSERT into match(league_id, roundnumber) VALUES ($league_id, $roundNumber)");
		}
	}
	
	public function referenceMatches($league_id)
	{
		$matchRows= $this->db->query("SELECT * FROM match where league_id=$league_id AND accessible=true AND bracket IS NULL");
		//$maxRound=$this->getNumberOfRounds($league_id);
		foreach($matchRows->result() as $row)
		{
			$matchID=$row->match_id;
			$roundNumber=$row->roundnumber;
			$nextRound=$roundNumber+1;
			$matchIDTobeReferenced=$this->matchTobeReferenced($league_id,$nextRound);
			if(isset($matchIDTobeReferenced))
			{
				$this->db->query("UPDATE match SET nextmatch_id_for_winner=$matchIDTobeReferenced WHERE match_id =$matchID AND accessible= true");
			}
		}
	}
	
	function matchTobeReferenced($league_id, $round)
	{
		$matchRow=$this->nullTeamChecker($league_id, $round);
		foreach($matchRow->result() as $match)
		{
			$match_id=$match->match_id;
			$previousRound=$round-1;
			$result= $this->db->query("SELECT * FROM match where match_id=$match_id AND roundnumber=$previousRound AND accessible= true");
			if($result->num_rows()<2)
			{
				$resultMatch=$match_id;
				break;
			}
		}
		if(isset($resultMatch))
			return $resultMatch;
		else 
			return null;
	}
	
	function nullTeamChecker($league_id, $round)
	{
		return $this->db->query("SELECT * FROM match WHERE league_id =$league_id AND roundnumber =$round AND (team_a IS NULL OR team_b IS NULL) AND bracket IS NULL AND accessible=true");
	}
	
	public function getNumberOfRounds($league_id)
	{
		$result= $this->db->query("SELECT count(distinct roundnumber) as maxround from match where league_id='$league_id' AND accessible=true AND bracket IS NULL");
		return $result->row()->maxround;
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
	
	public function getMatchesOfALeague($league_id)
	{
		return $this->db->query("SELECT * FROM match where league_id=$league_id AND accessible=true ORDER BY roundnumber, team_a");
	}
	
	function getSpecificWinner($league_id, $maxround)
	{
		return $this->db->query("SELECT match.winner, team.teamname FROM match INNER JOIN team ON (match.winner=team.team_id) WHERE match.roundnumber=$maxround AND match.league_id= $league_id AND match.bracket IS NULL");
	}
	
	public function resetTournament($league_id)
	{
		$this->db->query("DELETE from match WHERE league_id = $league_id");
	}
}?>