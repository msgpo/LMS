<?php 
include_once(APPPATH .'models/match.php');
class SingleEliminationTournament
{
		public $team_ids= array();
		private $matches=array();
		public function __construct($team_ids)
		{
			$this->team_ids=$team_ids;
		}
		public function getTeam_ids()
		{
			return $this->team_ids;
		}
		/**public function populateTeams()
		{
			$teamList=new TeamList();
			$teamList->getAllTeamsByLeague_id($this->league_id);
			foreach($teamList->result() as $team)
			{
				array_push($this->team_ids, $team->team_id);
			}
		}**/
		public function getMatches()
		{
			return $this->matches;
		}
		
		public function calculateNumberOfMatches()
		{
			return (count($this->team_ids)-1);
		}
		public function calculateNumberOfRounds()
		{
			$numberOfteams=count($this->team_ids);
			$n=0;
			while(pow(2,$n)<$numberOfteams)
			{
				$n=$n+1;
			}
			return $n;
		}
		
		public function calculateNumberOfByes()
		{
			$numberOfteams=count($this->team_ids);
			return ((pow(2,$this->calculateNumberOfRounds()))-$numberOfteams);
		}
		
		public function getNumberOfTeams()
		{
			return count($this->team_ids);
		}
		
		public function  generateMatches()
		{
			$numberOfMatchInFirstRound=$this->calculateNumberOfMatchInFirstRound();
			$numberOfMatchInSecondRound=(($this->calculateNumberOfByes()+$numberOfMatchInFirstRound)/2);
			if(($this->calculateNumberOfMatches())>1)
			{				
				$counter=0;
				for($i=0;$i<$numberOfMatchInFirstRound;$i++)
				{
					$match= new Match($this->team_ids[$counter], $this->team_ids[$counter+1], 1);
					array_push($this->matches,$match);
					$counter=$counter+2;
				}
				for($j=0; $j<$numberOfMatchInSecondRound; $j++)
				{
					if(isset($this->team_ids[$counter]))
					{
						if(isset($this->team_ids[$counter+1]))
						{
							$match= new Match($this->team_ids[$counter], $this->team_ids[$counter+1], 2);
							array_push($this->matches,$match);
						}
						else 
						{
							$match= new Match($this->team_ids[$counter], null, 2);
							array_push($this->matches,$match);
						}
					}
					else
					{
						$match= new Match(null, null, 2);
						array_push($this->matches,$match);
					}
					$counter=$counter+2;
				}
				$numberOfMatchInCurrentRound=$numberOfMatchInSecondRound/2;
				for($k=3; $k<=($this->calculateNumberOfRounds()); $k++)
				{
					for($l=0; $l<$numberOfMatchInCurrentRound; $l++)
					{
						$match= new Match(null, null, $k);
						array_push($this->matches,$match);
					}
					$numberOfMatchInCurrentRound=$numberOfMatchInCurrentRound/2;
				}
				return 1;
			}
			else
				return 0;
		}
	public function calculateNumberOfMatchInFirstRound()
	{
		$numberOfteams=count($this->team_ids);
		$n=0;
		while(pow(2,$n)<$numberOfteams)
		{
			$n=$n+1;
		}
		return ($numberOfteams-(pow(2,$n-1)));
	}	
}
?>