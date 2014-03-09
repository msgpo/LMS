<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TeamList extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('team','',TRUE);
	}
	public function addTeam($team)
	{
		$errors=$this->collect_errors($team,"","");
		if(count($errors)>0)
			return $errors;
		else 
			return $this->insert($team);
	}
	
	public function insert($team)
	{
		$teamname=strtolower($team->getTeamname()); $league_id=$team->getLeague_id();  $coachLastname=strtolower($team->getCoachLastname()); $coachFirstname=strtolower($team->getCoachFirstname());  $coachPhonenumber=strtolower($team->getCoachPhonenumber());  $teamDesc=strtolower($team->getTeamDesc());
		$this->db->query("INSERT into team(teamname,league_id, coachlastname, coachfirstname, coachphonenumber, teamdesc) VALUES ('$teamname', '$league_id', '$coachLastname', '$coachFirstname', '$coachPhonenumber', '$teamDesc')");
		return 1;
	}
	
	/**public function editLeague($league_id,$new_league)
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
	}**/
	
	function collect_errors($team,$teamname)
	{
		$errors=array();
		if(!($team->teamnameIsUnchanged($teamname)))
		{
			if($team->teamnameExistWithinTheLeague())
			{
				$error= "team name already exist within the given league";
				array_push($errors,$error);
			}
		}
		
		if($team->blankfield($team->getTeamname()))
		{
			$error= "The Teamname field is required";
			array_push($errors,$error);
		}
		
		if($team->blankfield($team->getCoachLastname()))
		{
			$error= "The Lastname field is required";
			array_push($errors,$error);
		}
		
		if($team->blankfield($team->getCoachFirstname()))
		{
			$error= "The Firstname field is required";
			array_push($errors,$error);
		}
		
		if($team->invalidPhoneNumberSyntax())
		{
			$error= "The Phone number field is invalid";
			array_push($errors,$error);
		}
		
		if($team->leaugeIdNotFound())
		{
			$error= "league id not found";
			array_push($errors,$error);
		}
		return $errors;
	}
}