<?php 
//include_once(APPPATH .'models/match.php');
abstract class Tournament
{
	protected $team_ids= array();
	protected $matches=array();
	
	protected function __construct($team_ids)
	{
		$this->team_ids=$team_ids;
	}
	
	abstract protected function calculateNumberOfMatches();
	
	abstract protected function generateMatches();
	
	protected function getTeam_ids()
	{
		return $this->team_ids;
	}
	
	protected function getMatches()
	{
		return $this->matches;
	}
	
	protected function getNumberOfTeams()
	{
		return count($this->team_ids);
	}
	
}
?>