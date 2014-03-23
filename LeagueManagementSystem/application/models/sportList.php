<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/sport.php');
class SportList extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }
	
	function addSport(Sport $sport)
	{
		if((!$this->sportnameExist($sport))&&(!$this->sportnameIsBlank($sport)))
			return $this->insert($sport);
		else
			return ($this->invalidAddOrUpdateSport($sport));
	}
	
	function invalidAddOrUpdateSport(Sport $sport)
	{
		if($this->sportnameExist($sport))
			return "The Sportname already exist";
		else if ($this->sportnameIsBlank($sport))
			return "The Sportname field is required";
	}
	
	function insert(Sport $sport)
	{
		$s=$sport->getSportname();
		$this->db->query("INSERT INTO sport(sportname) VALUES ('$s')");
		return 1;
	}
	
	function editSport($id, Sport $newSport)
	{
		if($this->getSportById($id)->num_rows()>0)
		{
			$sportname=$this->getSportById($id)->row()->sportname;
			if(((!$this->sportnameExist($newSport))&&(!$this->sportnameIsBlank($newSport)))||($this->sportnameIsUnchanged($newSport,$sportname)))
				return $this->update($id, $newSport);
			else
				return ($this->invalidAddOrUpdateSport($newSport));
		}
		else
			return "Sport id not found";
	}
	
	function update($id, Sport $sport)
	{
		$sportname=$sport->getSportname();
		$this->db->query("UPDATE sport SET sportname='$sportname' WHERE sport_id='$id'");
		return 1;
	}
	
	function getSportList()
	{
		return $this->db->query("SELECT * FROM sport WHERE accessible = 'true' ORDER BY sportname ASC");
	}
	
	function disableSport($id)
	{
		if($this->getSportById($id)->num_rows()>0)
		{
			if(!$this->checkIfALeagueReferencesThisSport($id))
				return $this->updateToInAccessible($id);
			else
				return "That sport cannot be removed. There are league(s) that uses that sport";
		}
		else
			return "Sport id not found";
	}
	function updateToInAccessible($sport_id)
	{
		$this->db->query("UPDATE sport SET accessible = 'false' WHERE sport_id = $sport_id");
		return 1;
	}
	function checkIfALeagueReferencesThisSport($sport_id)
	{
		$result= $this->db->query("SELECT * FROM league WHERE sport_id=$sport_id AND accessible = 'true'");
		if($result->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
	
	function sportnameIsUnchanged($sport,$sportname)
	{
		if(strcasecmp($sport->getSportname(),$sportname)==0)
			return TRUE;
		else
			return FALSE;
	}
	
	function sportnameExist($sport)
	{
		$sportname=strtolower($sport->getSportname());
		$result=$this->db->query("SELECT * FROM sport where sportname='$sportname' AND accessible='true'");
		if($result->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
	function sportnameIsBlank($sport)
	{
		if(trim($sport->getSportname())=="")
			return TRUE;
		else
			return FALSE;
	}
	
	function getSportById($id)
	{
		return $this->db->query("SELECT * FROM sport where sport_id=$id AND accessible='true'");
	}
	function countAllAvailableSports()
	{
		return $this->db->query("SELECT COUNT(*) AS record_count FROM sport WHERE accessible = 'true'");
	}
	
	function getSportListWithLimit($limit, $start)
	{
		return $this->db->query("SELECT * FROM sport WHERE accessible = 'true' ORDER BY sportname LIMIT $limit OFFSET $start");
	}
	
	function getSportListByName($name)
	{
		return $this->db->query("SELECT * FROM sport WHERE sportname = '$name' AND accessible = 'true' ORDER BY sportname ASC");
	}
}
?>
