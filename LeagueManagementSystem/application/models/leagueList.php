<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LeagueList extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('league','',TRUE);
	}
	public function createLeague($league)
	{
		$errors=$this->collect_errors($league,"","");
		if(count($errors)>0)
			return $errors;
		else 
			return $this->insert($league);
	}
	
	public function insert($league)
	{
		$leaguename=strtolower($league->getLeaguename()); $sport_id=$league->getSport_id(); $tournamentType=strtolower($league->getTournamentType()); $registrationDeadline=$league->getRegistrationDeadline();
		$this->db->query("INSERT into league(leaguename,sport_id,tournamenttype,registrationdeadline) VALUES ('$leaguename','$sport_id','$tournamentType','$registrationDeadline')");
		return 1;
	}
	
	public function editLeague($league_id,$new_league)
	{
		if($this->league->getLeagueById($league_id)->num_rows()>0)
		{
			$result=$this->league->getLeagueById($league_id)->result();
			$errors=$this->collect_errors($new_league,$result[0]->leaguename,$result[0]->sport_id);
			if(count($errors)>0)
				return $errors;
			else
			{	
				$result=$this->update($league_id,$new_league);
				if($result==1)
					return $result;
				array_push($errors,$result);
				return $errors;
			}
		}
		else
		{
			$errors=array();
			array_push($errors,"League id not found");
			return $errors;
		}
	}
	
	public function update($league_id,$league)
	{
		$leaguename=strtolower($league->getLeaguename()); $sport_id=$league->getSport_id(); $tournamentType=strtolower($league->getTournamentType()); $registrationDeadline=$league->getRegistrationDeadline();
		$this->db->query("UPDATE league set leaguename='$leaguename',sport_id='$sport_id',tournamenttype='$tournamentType',registrationdeadline='$registrationDeadline' where league_id=$league_id AND accessible='true'");
		return 1;
	}
	
	public function deactivateLeague($league_id)
	{
		if($this->league->getLeagueById($league_id)->num_rows()>0)
		{
			$this->db->query("UPDATE league set accessible='false' where league_id=$league_id");
			return 1;
		}
		else
			return "League id not Found";
	}

	public function searchLeague($leaguename)
	{
		return $this->db->query("SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.accessible = true AND leaguename LIKE '%$leaguename%'");
	}
	public function getAllLeagues()
	{
		return $this->db->query("SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.accessible = true ORDER BY league.league_id");
	}
	
	function collect_errors($league,$leaguename,$sport_id)
	{
		$errors=array();
		if(!($league->leaguenameandSportIsUnchanged($leaguename,$sport_id)))
		{
			if($league->leaguenameExistWithinTheSport())
			{
				$error= "league name already exist within the given sport";
				array_push($errors,$error);
			}
		}
		
		if($league->blankfield($league->getLeaguename()))
		{
			$error= "The Leaguename field is required";
			array_push($errors,$error);
		}
		
		if($league->invalidDateSyntax())
		{
			$error= "Invalid date syntax. The syntax must be yyyy-mm-dd";
			array_push($errors,$error);
		}
		
		if($league->invalidTounramentType())
		{
			$error= "The Tournament type is unspecified";
			array_push($errors,$error);
		}
		
		if($league->sportIdNotFound())
		{
			$error= "Sport id not found";
			array_push($errors,$error);
		}
		return $errors;
	}
}