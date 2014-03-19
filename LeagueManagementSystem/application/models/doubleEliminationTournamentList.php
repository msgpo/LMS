<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/TournamentList.php');
include_once(APPPATH .'models/doubleEliminationTournament.php');
class DoubleEliminationTournamentList  extends TournamentList 
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
				return $this->insert($league_id,$tournament);
			}
		}
		else
			return "league not found";
	}
	
	public function insert($league_id, DoubleEliminationTournament $tournament)
	{
		$matches=$tournament->getMatches();
		foreach($matches as $match)
		{
			$this->insertMatch($match, $league_id);
		}
		$this->referenceMatches($league_id);
		return 1;
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
	//START HERE
	function referenceMatches($league_id)
	{
		$this->referenceWinnerBracket($league_id);
		$this->referenceLoserBracket($league_id);
		$this->referenceMatchOfWinnerOfWinnerBracketAndWinnerOfLoserBracket($league_id);
	}
	
	
	function getMatchOfARound($league_id,$roundnumber,$bracket)
	{
		return $this->db->query("SELECT * FROM match WHERE roundnumber=$roundnumber AND league_id=$league_id AND bracket='$bracket' AND accessible=true");
	}
	
	function referenceWinnerBracket($league_id)
	{
		$winnerBracketMatchRows= $this->db->query("SELECT * FROM match where league_id=$league_id AND accessible=true AND bracket ='w'");
		foreach($winnerBracketMatchRows->result() as $row)
		{
			$matchID=$row->match_id;
			$roundNumber=$row->roundnumber;
			$nextRound=$roundNumber+1;
			$matchIDTobeReferencedInWinner=$this->matchTobeReferencedInWinner($league_id,$nextRound);
			if(isset($matchIDTobeReferencedInWinner))
			{
				$this->db->query("UPDATE match SET nextmatch_id_for_winner=$matchIDTobeReferencedInWinner WHERE match_id =$matchID AND accessible= true");
			}
			$matchIDTobeReferencedInLoser=$this->matchTobeReferencedInLoser($league_id,1);
			if(isset($matchIDTobeReferencedInLoser))
			{
				$this->db->query("UPDATE match SET nextmatch_id_for_loser=$matchIDTobeReferencedInLoser WHERE match_id =$matchID AND accessible= true");
			}
			else
			{
				$matchIDTobeReferencedInLoser=$this->matchTobeReferencedInLoser($league_id,2);
				$this->db->query("UPDATE match SET nextmatch_id_for_loser=$matchIDTobeReferencedInLoser WHERE match_id =$matchID AND accessible= true");
			}
		}
		
	}
	
	function referenceLoserBracket($league_id)
	{
		$loserBracketMatchRows= $this->db->query("SELECT * FROM match where league_id=$league_id AND accessible=true AND bracket ='l'");
		foreach($loserBracketMatchRows->result() as $row)
		{
			$matchID=$row->match_id;
			$roundNumber=$row->roundnumber;
			$nextRound=$roundNumber+1;
			$matchIDTobeReferencedInWinner=$this->matchTobeReferencedInLoser($league_id,$nextRound);
			if(isset($matchIDTobeReferencedInWinner))
			{
				$this->db->query("UPDATE match SET nextmatch_id_for_winner=$matchIDTobeReferencedInWinner WHERE match_id =$matchID AND accessible= true");
			}
		}
	}
	
	function matchTobeReferencedInWinner($league_id, $round)
	{
		$matchRow=$this->nullTeamCheckerForWinnersBracket($league_id, $round);
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
	
	
	function nullTeamCheckerForWinnersBracket($league_id, $round)
	{
		return $this->db->query("SELECT * FROM match WHERE league_id =$league_id AND roundnumber =$round AND (team_a IS NULL OR team_b IS NULL) AND bracket ='w' AND accessible=true");
	}
	
	
	function matchTobeReferencedInLoser($league_id,$round)
	{
		$matchRow=$this->nullTeamCheckerForLosersBracket($league_id, $round);
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
	
	function nullTeamCheckerForLosersBracket($league_id, $round)
	{
		return $this->db->query("SELECT * FROM match WHERE league_id =$league_id AND roundnumber =$round AND (team_a IS NULL OR team_b IS NULL) AND bracket ='l' AND accessible=true");
	}
	
	function getNumberOfRoundsOfWinnersBracket($league_id)
	{
		$result= $this->db->query("SELECT count(distinct roundnumber) as maxround from match where league_id='$league_id' AND accessible=true AND bracket= 'w'");
		return $result->row()->maxround;
	}
	
	
	function getNumberOfRoundsOfLosersBracket($league_id)
	{
		$result= $this->db->query("SELECT count(distinct roundnumber) as maxround from match where league_id='$league_id' AND accessible=true AND bracket = 'l'");
		return $result->row()->maxround;
	}
	
	
	function referenceMatchOfWinnerOfWinnerBracketAndWinnerOfLoserBracket($league_id)
	{
		$winnerBracketMaxRound=$this->getNumberOfRoundsOfWinnersBracket($league_id);
		$loserBracketMaxRound=$this->getNumberOfRoundsOfLosersBracket($league_id);
		$MatchID_of_MaxRoundInWinnerBracket=$this->getMatchOfARound($league_id,$winnerBracketMaxRound,'w')->row()->match_id;
		$MatchID_of_MaxRoundInLoserBracket=$this->getMatchOfARound($league_id,$loserBracketMaxRound,'l')->row()->match_id;
		$matchIDOfFinalRound=$this->db->query("SELECT * FROM match WHERE league_id=$league_id AND bracket='f' AND roundnumber=1 AND accessible=true")->row()->match_id;
		$this->db->query("UPDATE match SET nextmatch_id_for_winner=$matchIDOfFinalRound WHERE match_id=$MatchID_of_MaxRoundInWinnerBracket");
		$this->db->query("UPDATE match SET nextmatch_id_for_winner=$matchIDOfFinalRound WHERE match_id=$MatchID_of_MaxRoundInLoserBracket");
	}
	
	//ENDS HERE
	
	
	//START HERE
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
		$nextMatchIDForWinner=$matchDetails->row()->nextmatch_id_for_winner;
		$nextMatchIDForLoser=$matchDetails->row()->nextmatch_id_for_loser;
		if($winner==$matchDetails->row()->team_a)
			$loser=$matchDetails->row()->team_b;
		else
			$loser=$matchDetails->row()->team_a;
		$this->db->query("UPDATE match set winner=$winner WHERE match_id=$matchID and accessible=true");
		$this->db->query("UPDATE match set loser=$loser WHERE match_id=$matchID and accessible=true");
		$this->updateTeamInNextMatch($winner, $nextMatchIDForWinner);
		$this->updateTeamInNextMatch($loser, $nextMatchIDForLoser);
		return 1;
		
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
		}
	}
	//ENDS HERE
	
	
	public function getMatchesOfALeague($league_id)
	{
		return $this->db->query("SELECT * FROM match where league_id=$league_id ORDER BY bracket DESC, roundnumber, team_a");
	}
	
	function setStarted($league_id)
	{
		$this->db->query("UPDATE league SET isstarted = true WHERE league_id = $league_id");
	}
	
	
	function getSpecificWinner($league_id)
	{
		return $this->db->query("SELECT match.winner, team.teamname FROM match INNER JOIN team ON (match.winner=team.team_id) WHERE match.bracket='f' AND match.league_id= $league_id");
	}
	
	function getMatchDetails($matchID)
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
	
	function resetTournament($league_id)
	{
		$this->db->query("DELETE from match WHERE league_id = $league_id");
	}
	
}?>