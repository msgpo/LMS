<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/league.php');
class LeagueList extends CI_Model 
{
	private $tournaments=array('a'=>"single elimination", 'b'=>"double elimination");
	function __construct()
	{
		parent::__construct();
	}
	
	public function createLeague(League $league)
	{
		$errors=$this->collect_errors($league,"","");
		if(count($errors)>0)
			return $errors;
		else 
			return $this->insert($league);
	}
	
	public function insert(League $league)
	{
		$leaguename=($league->getLeaguename()); $sport_id=$league->getSport_id(); $tournamentType=strtolower($league->getTournamentType()); $registrationDeadline=$league->getRegistrationDeadline();
		$this->db->query("INSERT into league(leaguename,sport_id,tournamenttype,registrationdeadline) VALUES ('$leaguename','$sport_id','$tournamentType','$registrationDeadline')");
		return 1;
	}

	public function editLeague($league_id, League $new_league)
	{
		if($this->getLeagueById($league_id)->num_rows()>0)
		{
			$result=$this->getLeagueById($league_id)->result();
			$errors=$this->collect_errors($new_league, $result[0]->leaguename,$result[0]->sport_id);
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
	
	public function update($league_id, League $league)
	{
		$leaguename=($league->getLeaguename()); $sport_id=$league->getSport_id(); $tournamentType=strtolower($league->getTournamentType()); $registrationDeadline=$league->getRegistrationDeadline();
		$this->db->query("UPDATE league set leaguename='$leaguename',sport_id='$sport_id',tournamenttype='$tournamentType',registrationdeadline='$registrationDeadline' where league_id=$league_id AND accessible='true'");
		return 1;
	}
	
	public function deactivateLeague($league_id)
	{
		if($this->getLeagueById($league_id)->num_rows()>0)
		{
			$this->db->query("UPDATE league set accessible='false' where league_id=$league_id");
			return 1;
		}
		else
			return "League id not Found";
	}
	function collect_errors(League $league, $leaguename, $sport_id)
	{
		$errors=array();
		if(!($this->leaguenameandSportIsUnchanged($league, $leaguename,$sport_id)))
		{
			if($this->leaguenameExistWithinTheSport($league->getLeaguename(), $league->getSport_id()))
			{
				$error= "league name already exist within the given sport";
				array_push($errors,$error);
			}
		}
		
		if($this->blankfield($league->getLeaguename()))
		{
			$error= "The Leaguename field is required";
			array_push($errors,$error);
		}
		
		if($this->invalidDateSyntax($league->getRegistrationDeadline()))
		{
			$error= "Invalid date syntax. The syntax must be yyyy-mm-dd";
			array_push($errors,$error);
		}
		
		if($this->invalidTounramentType($league->getTournamentType()))
		{
			$error= "The Tournament type is unspecified";
			array_push($errors,$error);
		}
		
		if($this->sportIdNotFound($league->getSport_id()))
		{
			$error= "Sport id not found";
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
		
	public function invalidTounramentType($tournamentType)
	{
		$field=true;
		foreach($this->tournaments as $t)
		{
			if(strtolower($tournamentType)==$t)
				$field=false;
		}
		return $field;
	}
	
	public function invalidDateSyntax($registrationDeadline)
	{
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$registrationDeadline))
			return false;
		else
			return true;
	}
		
	public function leaguenameExistWithinTheSport($leaguename, $sport_id)
	{
		$leaguename=($leaguename);
		$result=$this->db->query("SELECT * FROM league where LOWER(leaguename)=LOWER('$leaguename') AND sport_id= $sport_id AND accessible='true'");
		if($result->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
	
	public function isStarted($id)
	{
		$result=$this->getLeagueById($id)->result();
		if($result[0]->isstarted=="t")
			return TRUE;
	}
		
	public function sportIdNotFound($sport_id)
	{
		$result=$this->sportList->getSportById($sport_id);
		if($result->num_rows()>0)
			return FALSE;
		else
			return TRUE;
	}
		
	public function leaguenameandSportIsUnchanged($league,$leaguename,$sport_id)
	{
		if((($league->getLeaguename())==($leaguename))&&($league->getSport_id()==$sport_id))
			return TRUE;
		else
			return FALSE;
	}
		
	public function getLeagueById($id)
	{
		return $this->db->query("SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.league_id = '$id' AND league.accessible=true");
	}
	
	public function searchLeague($leaguename)
	{
		$search_query = "SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.accessible = true";
		// Extract the search keywords into an array
		$clean_search = str_replace(',', ' ', $leaguename);
		$search_words = explode(' ', $clean_search);
		$final_search_words = array();
		if (count($search_words) > 0) 
		{
			foreach ($search_words as $word) 
			{
				if (!empty($word)) 
				{
					$final_search_words[] = $word;
				}
			}
		}

    // Generate an AND clause using all of the search keywords
    $where_list = array();
    if (count($final_search_words) > 0) {
      foreach($final_search_words as $word) {
        $where_list[] = "league.leaguename LIKE '%$word%'";
      }
    }
    $where_clause = implode(' OR ', $where_list);

    // Add the keyword AND clause to the search query
    if (!empty($where_clause)) {
      $search_query .= " AND $where_clause";
    }
	
	return $this->db->query($search_query);

	
		// return $this->db->query("SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.accessible = true AND leaguename LIKE '%$leaguename%'");
	}
	public function getAllLeagues()
	{
		return $this->db->query("SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.accessible = true ORDER BY league.leaguename");
	}
	function setStarted($league_id)
	{
		$this->db->query("UPDATE league SET isstarted = true WHERE league_id = $league_id");
	}
	
	function setUnstarted($league_id) 
	{ 
		$this->db->query("UPDATE league SET isstarted = false WHERE league_id = $league_id"); 
	}
	
	function getDeactivatedLeagues()
	{
		return $this->db->query("SELECT * FROM league WHERE league.accessible = false ORDER BY leaguename");
	}
	
	public function reactivateLeague($league_id)
	{
		if($this->getLeagueById($league_id)->num_rows()>0)
		{
			$this->db->query("UPDATE league SET accessible='true' where league_id=$league_id");
			return 1;
		}
		else
			return "League id not Found";
	}
}?>
