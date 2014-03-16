<?php 
include_once(APPPATH .'models/match.php');
include_once(APPPATH .'models/tournament.php');
class DoubleEliminationTournament extends Tournament
{
	public function __construct($team_ids)
	{
		parent::__construct($team_ids);
	}
	
	public function calculateNumberOfMatches()
	{
		return(parent::getNumberOfTeams()-1);
	}
	
	public function calculateNumberOfRounds()
	{
		$numberOfteams=parent::getNumberOfTeams();
		$n=0;
		while(pow(2,$n)<$numberOfteams)
		{
			$n=$n+1;
		}
		return $n;
	}
	
	public function calculateNumberOfByes()
	{
		$numberOfteams=parent::getNumberOfTeams();
		return ((pow(2,$this->calculateNumberOfRounds()))-$numberOfteams);
	}
	public function calculateNumberOfMatchInFirstRound()
	{
		$numberOfteams=parent::getNumberOfTeams();
		$n=0;
		while(pow(2,$n)<$numberOfteams)
		{
			$n=$n+1;
		}
		return ($numberOfteams-(pow(2,$n-1)));
	}
	
	function calculateNumberOfMatchInSecondRound()
	{
		return (($this->calculateNumberOfByes()+($this->calculateNumberOfMatchInFirstRound()))/2);
	}
	
	public function generateMatches()
	{
		if(($this->calculateNumberOfMatches())>1)
		{
			$this->populateMatch();
			return 1;
		}
		else
			return 0;
	}
	public function populateMatch()
	{
		$this->populateMatchInFirstRound();
		$indexOfTeamThatReceivedBye=(parent::getNumberOfTeams())-($this->calculateNumberOfByes());
		$this->populateMatchInSecondRound($indexOfTeamThatReceivedBye);
		$this->populateThirdToLastRound();
	}
	
	public function populateMatchInFirstRound()
	{
		$numberOfMatchInFirstRound=$this->calculateNumberOfMatchInFirstRound();
		$counter=0;
		for($i=0;$i<$numberOfMatchInFirstRound;$i++)
		{
			$match= new Match($this->team_ids[$counter], $this->team_ids[$counter+1], 1);
			array_push($this->matches,$match);
			$counter=$counter+2;
		}
	}
	
	public function populateMatchInSecondRound($indexOfTeamThatReceivedBye)
	{
		$numberOfMatchInSecondRound=$this->calculateNumberOfMatchInSecondRound();
		for($j=0; $j<$numberOfMatchInSecondRound; $j++)
		{
			if(isset($this->team_ids[$indexOfTeamThatReceivedBye]))
			{
				if(isset($this->team_ids[$indexOfTeamThatReceivedBye+1]))
				{
					$match= new Match($this->team_ids[$indexOfTeamThatReceivedBye], $this->team_ids[$indexOfTeamThatReceivedBye+1], 2);
					array_push($this->matches,$match);
				}
				else
				{
					$match= new Match($this->team_ids[$indexOfTeamThatReceivedBye], null, 2);
					array_push($this->matches,$match);
				}
			}
			else
			{
				$match= new Match(null, null, 2);
				array_push($this->matches,$match);
			}
			$indexOfTeamThatReceivedBye=$indexOfTeamThatReceivedBye+2;
		}
	}
	
	public function populateThirdToLastRound()
	{
		$numberOfMatchInSecondRound=$this->calculateNumberOfMatchInSecondRound();
		$numberOfMatchInThirdToLastRound=$numberOfMatchInSecondRound/2;
		for($k=3; $k<=($this->calculateNumberOfRounds()); $k++)
		{
			for($l=0; $l<$numberOfMatchInThirdToLastRound; $l++)
			{
				$match= new Match(null, null, $k);
				array_push($this->matches,$match);
			}
			$numberOfMatchInThirdToLastRound=$numberOfMatchInThirdToLastRound/2;
		}
	}
	
	public function getMatches()
	{
		return parent::getMatches();
	}
}
?>