<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/team.php');
class TeamList extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	public function addTeam(Team $team)
	{
		$errors=$this->collect_errors($team,"","");
		if(count($errors)>0)
			return $errors;
		else 
			return $this->insert($team);
	}
	
	public function insert(Team $team)
	{
		$teamname=($team->getTeamname()); $league_id=$team->getLeague_id();  $coachLastname=($team->getCoachLastname()); $coachFirstname=($team->getCoachFirstname());  $coachPhonenumber=($team->getCoachPhonenumber());  $teamDesc=($team->getTeamDesc());
		$this->db->query("INSERT into team(teamname,league_id, coachlastname, coachfirstname, coachphonenumber, teamdesc) VALUES ('$teamname', '$league_id', '$coachLastname', '$coachFirstname', '$coachPhonenumber', '$teamDesc')");
		return 1;
	}
	
	public function editTeam($team_id, Team $new_team)
	{
		if($this->getTeamById($team_id)->num_rows()>0)
		{
			$result=$this->getTeamById($team_id)->result();
			$errors=$this->collect_errors($new_team, $result[0]->teamname);
			if(count($errors)>0)
				return $errors;
			else
			{	
				$result=$this->update($team_id,$new_team);
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
	public function update($team_id, Team $team)
	{
		$teamname=(($team->getTeamname())); 
		$league_id=$team->getLeague_id(); 
		$coachlastname=(($team->getCoachLastname())); 
		$coachfirstname=($team->getCoachFirstname()); 
		$coachphonenumber=($team->getCoachPhonenumber());  
		$teamdesc=($team->getTeamDesc());
		$this->db->query("UPDATE team set teamname='$teamname',league_id='$league_id',coachlastname='$coachlastname',coachfirstname='$coachfirstname', coachphonenumber='$coachphonenumber', teamdesc='$teamdesc' where team_id=$team_id AND accessible='true'");
		return 1;
	}
	public function removeTeam($team_id)
	{
		$this->db->query("UPDATE team SET accessible='false' where team_id=$team_id");
		return 1;
	}
	
	function collect_errors(Team $team, $teamname)
	{
		$errors=array();
		if(!($this->teamnameIsUnchanged($team, $teamname)))
		{
			if($this->teamnameExistWithinTheLeague($team->getLeague_id(),$team->getTeamname()))
			{
				$error= "Team name already exist within the given league";
				array_push($errors,$error);
			}
		}
		
		if($this->blankfield($team->getTeamname()))
		{
			$error= "The Teamname field is required";
			array_push($errors,$error);
		}
		
		if($this->blankfield($team->getCoachLastname()))
		{
			$error= "The Lastname field is required";
			array_push($errors,$error);
		}
		
		if($this->blankfield($team->getCoachFirstname()))
		{
			$error= "The Firstname field is required";
			array_push($errors,$error);
		}
		
		if($this->invalidPhoneNumberSyntax($team->getCoachPhonenumber()))
		{
			$error= "The Phone number field is invalid";
			array_push($errors,$error);
		}
		
		if($this->leaugeIdNotFound($team->getLeague_id()))
		{
			$error= "league id not found";
			array_push($errors,$error);
		}
		return $errors;
	}
	
	public function blankfield($anyField)
	{
		if(trim($anyField)=="")
			return TRUE;
		else
			return FALSE;
	}
		
	public function invalidPhoneNumberSyntax($coachPhonenumber)
	{
		if(preg_match("/^09[0-9]{9}$/",$coachPhonenumber))
			return false;
		else
			return true;
	}
	
	public function teamNameExistWithinTheLeague($league_id, $teamname)
	{
		$teamname=($teamname);
		$result=$this->db->query("SELECT * FROM team where LOWER(teamname)=LOWER('$teamname') AND league_id= $league_id AND accessible='true'");
		if($result->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
	
	public function leaugeIdNotFound($league_id)	
	{
		$result=$this->leagueList->getLeagueById($league_id);
		if($result->num_rows()>0)
			return FALSE;
		else
			return TRUE;
	}
	
	public function teamnameIsUnchanged($team, $teamname)
	{
		if((($team->getTeamname())==($teamname)))
			return TRUE;
		else
			return FALSE;
	}
	
	
	public function getTeamById($id)
	{
		return $this->db->query("SELECT * FROM team WHERE team_id = '$id' AND accessible=true");
	}
	
	public function getAllTeamsByLeague_id($league_id)
	{
		return $this->db->query("SELECT * FROM team WHERE league_id= '$league_id' AND accessible= true ORDER by team_id");
	}
	
	// placeholder
	public function getAllTeams()
	{
		// At the time this function is written, the Teams table does not contain the column "accessible."
		return $this->db->query("SELECT * FROM team");
	}
	
	public function getTeamsByLeague($league_id)
	{
		return $this->db->query("SELECT * FROM team WHERE league_id = '$league_id'");
	}
	
	// for dropdown
	public function getRanklessTeamsOfLeague($league_id)
	{
		return $this->db->query("SELECT * FROM team WHERE league_id = '$league_id' AND rank IS NULL");
	}
	
	public function getTeamRank($rank, $league_id)
	{
		return $this->db->query("SELECT * FROM team WHERE rank = $rank AND league_id = $league_id AND accessible= true");
	}
	
	public function setTeamRank($rank, $league_id, $team_id)
	{
		$this->db->query("UPDATE team SET rank = $rank WHERE team_id = '$team_id' AND league_id = '$league_id'");
	}
	
	public function setNullRank($league_id, $team_id)
	{
		$this->db->query("UPDATE team SET rank = null WHERE team_id = '$team_id' AND league_id = '$league_id'");
	}
}?>