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
		$teamname=strtolower($team->getTeamname()); $league_id=$team->getLeague_id();  $coachLastname=strtolower($team->getCoachLastname()); $coachFirstname=strtolower($team->getCoachFirstname());  $coachPhonenumber=strtolower($team->getCoachPhonenumber());  $teamDesc=strtolower($team->getTeamDesc());
		$this->db->query("INSERT into team(teamname,league_id, coachlastname, coachfirstname, coachphonenumber, teamdesc) VALUES ('$teamname', '$league_id', '$coachLastname', '$coachFirstname', '$coachPhonenumber', '$teamDesc')");
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
		$teamname=strtolower($teamname);
		$result=$this->db->query("SELECT * FROM team where teamname='$teamname' AND league_id= $league_id AND accessible='true'");
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
		if((strtolower($team->getTeamname())==strtolower($teamname)))
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
		$result= $this->db->query("SELECT * FROM team WHERE league_id= '$league_id' AND accessible= true ORDER by team_id");
	}
	
}?>