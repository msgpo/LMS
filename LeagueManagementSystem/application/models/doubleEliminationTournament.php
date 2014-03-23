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
		return (2*(parent::getNumberOfTeams())-2);
	}
	
	public function calculateNumberOfMatchesInWinnerBracket()
	{
		return(parent::getNumberOfTeams()-1);
	}
	
	public function calculateNumberOfMatchesInLoserBracket()
	{
		return(parent::getNumberOfTeams()-2);
	}
	
	public function calculateNumberOfRoundsInWinnerBracket()
	{
		$numberOfteams=parent::getNumberOfTeams();
		$n=0;
		while(pow(2,$n)<$numberOfteams)
		{
			$n=$n+1;
		}
		return $n;
	}
	
	public function calculateNumberOfRoundsInLoserBracket()
	{
		$numberOfteams=(parent::getNumberOfTeams())-1;
		$n=0;
		while(pow(2,$n)<$numberOfteams)
		{
			$n=$n+1;
		}
		return $n;
	}
	
	public function calculateNumberOfByesInWinnerBracket()
	{
		$numberOfteams=parent::getNumberOfTeams();
		return ((pow(2,$this->calculateNumberOfRoundsInWinnerBracket()))-$numberOfteams);
	}
	
	public function calculateNumberOfByesInLoserBracket()
	{
		$numberOfteams=(parent::getNumberOfTeams())-1;
		return ((pow(2,$this->calculateNumberOfRoundsInLoserBracket()))-$numberOfteams);
	}
	
	
	public function calculateNumberOfMatchInFirstRoundInWinnerBracket()
	{
		$numberOfteams=parent::getNumberOfTeams();
		$n=0;
		while(pow(2,$n)<$numberOfteams)
		{
			$n=$n+1;
		}
		return ($numberOfteams-(pow(2,$n-1)));
	}
	
	public function calculateNumberOfMatchInFirstRoundInLoserBracket()
	{
		$numberOfteams=(parent::getNumberOfTeams())-1;
		$n=0;
		while(pow(2,$n)<$numberOfteams)
		{
			$n=$n+1;
		}
		return ($numberOfteams-(pow(2,$n-1)));
	}
	
	function calculateNumberOfMatchInSecondRoundInWinnerBracket()
	{
		return (($this->calculateNumberOfByesInWinnerBracket()+($this->calculateNumberOfMatchInFirstRoundInWinnerBracket()))/2);
	}
	
	function calculateNumberOfMatchInSecondRoundInLoserBracket()
	{
		return (floor(($this->calculateNumberOfByesInLoserBracket()+($this->calculateNumberOfMatchInFirstRoundInLoserBracket()))/2));
	}
	
	public function generateMatches()
	{
		if((parent::getNumberOfTeams())>2)
		{
			$this->populateMatchInWinnerBracket();
			$this->populateMatchInLoserBracket();
			$this->populateMatchInLoserAndWinnerBracket("f");
			return 1;
		}
		else
			return 0;
	}
	public function populateMatchInWinnerBracket()
	{
		$this->populateMatchInFirstRoundInWinnerBracket("w");
		$indexOfTeamThatReceivedBye=(parent::getNumberOfTeams())-($this->calculateNumberOfByesInWinnerBracket());
		$this->populateMatchInSecondRoundInWinnerBracket($indexOfTeamThatReceivedBye,"w");
		$this->populateThirdToLastRoundInWinnerBracket("w");
	}
	
	public function populateMatchInLoserBracket()
	{
		$this->populateMatchInFirstRoundInLoserBracket("l");
		$this->populateMatchInSecondRoundInLoserBracket("l");
		$this->populateThirdToLastRoundInLoserBracket("l");
	}
	
	public function populateMatchInFirstRoundInWinnerBracket($bracket)
	{
		$numberOfMatchInFirstRound=$this->calculateNumberOfMatchInFirstRoundInWinnerBracket();
		$counter=0;
		for($i=0;$i<$numberOfMatchInFirstRound;$i++)
		{
			$match= new Match($this->team_ids[$counter], $this->team_ids[$counter+1], 1, $bracket);
			array_push($this->matches,$match);
			$counter=$counter+2;
		}
	}
	
	public function populateMatchInFirstRoundInLoserBracket($bracket)
	{
		$numberOfMatchInFirstRound=$this->calculateNumberOfMatchInFirstRoundInLoserBracket();
		for($i=0;$i<$numberOfMatchInFirstRound;$i++)
		{
			$match= new Match(null, null, 1, $bracket);
			array_push($this->matches,$match);
		}
	}
	
	public function populateMatchInSecondRoundInLoserBracket($bracket)
	{
		$numberOfMatchInSecondRound=$this->calculateNumberOfMatchInSecondRoundInLoserBracket();
		for($j=0; $j<$numberOfMatchInSecondRound; $j++)
		{
				$match= new Match(null, null, 2, $bracket);
				array_push($this->matches,$match);
		}
	}
	
	public function populateThirdToLastRoundInLoserBracket($bracket)
	{
		$numberOfMatchInSecondRound=$this->calculateNumberOfMatchInSecondRoundInLoserBracket();
		$numberOfMatchInThirdToLastRound=$numberOfMatchInSecondRound/2;
		for($k=3; $k<=($this->calculateNumberOfRoundsInLoserBracket()); $k++)
		{
			for($l=0; $l<$numberOfMatchInThirdToLastRound; $l++)
			{
				$match= new Match(null, null, $k, $bracket);
				array_push($this->matches,$match);
			}
			$numberOfMatchInThirdToLastRound=$numberOfMatchInThirdToLastRound/2;
		}
	}
	public function populateMatchInLoserAndWinnerBracket($bracket)
	{
		$match= new Match(null, null, 1, $bracket);
		array_push($this->matches,$match);
	}
	
	
	public function populateMatchInSecondRoundInWinnerBracket($indexOfTeamThatReceivedBye, $bracket)
	{
		$numberOfMatchInSecondRound=$this->calculateNumberOfMatchInSecondRoundInWinnerBracket();
		for($j=0; $j<$numberOfMatchInSecondRound; $j++)
		{
			if(isset($this->team_ids[$indexOfTeamThatReceivedBye]))
			{
				if(isset($this->team_ids[$indexOfTeamThatReceivedBye+1]))
				{
					$match= new Match($this->team_ids[$indexOfTeamThatReceivedBye], $this->team_ids[$indexOfTeamThatReceivedBye+1], 2, $bracket);
					array_push($this->matches,$match);
				}
				else
				{
					$match= new Match($this->team_ids[$indexOfTeamThatReceivedBye], null, 2, $bracket);
					array_push($this->matches,$match);
				}
			}
			else
			{
				$match= new Match(null, null, 2, $bracket);
				array_push($this->matches,$match);
			}
			$indexOfTeamThatReceivedBye=$indexOfTeamThatReceivedBye+2;
		}
		return $this->getMatches();
	}
	
	public function populateThirdToLastRoundInWinnerBracket($bracket)
	{
		$numberOfMatchInSecondRound=$this->calculateNumberOfMatchInSecondRoundInWinnerBracket();
		$numberOfMatchInThirdToLastRound=$numberOfMatchInSecondRound/2;
		for($k=3; $k<=($this->calculateNumberOfRoundsInWinnerBracket()); $k++)
		{
			for($l=0; $l<$numberOfMatchInThirdToLastRound; $l++)
			{
				$match= new Match(null, null, $k, $bracket);
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