<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SportList extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('sport','',TRUE);
    }
	
	/**function addSport($sportname)
	{
		$sport=$this->sport->constructor($sportname);
		if(($this->checkIfSportnameExist()==0)&&($sport->checkIfSportnameIsBlank()==0))
		{
			$this->db->query("INSERT INTO sport(sportname) VALUES ('$sportname')");
			return null;
		}
		else
			return ($this->invalidAddOrUpdateSport($sportname));
	}
	
	function invalidAddOrUpdateSport($sportname)
	{
		$sport=$this->sport->constructor($sportname);
		if($this->checkIfSportnameExist()==1)
			return "The Sportname already exist";
		else if($sport->checkIfSportnameIsBlank()==1)
			return "The Sportname is blank";
	}
	function editSport($oldSportname,$newSportname)
	{
		$sport1=$this->sport->constructor($oldSportname);
		if($this->checkIfSportnameExist($oldSportname)==1)
		{
			$sport2=$this->sport->constructor($newSportname);
			if(($this->checkIfSportnameExist($newSportname)==0)&&($sport2->checkIfSportnameIsBlank()==0))
			{
				$this->db->query("UPDATE sport SET sportname='$newSportname' WHERE sportname='$oldSportname'");
				$sport1->setSportName($newSportname);
				return 1;
			}	
			else
				return ($this->	invalidAddOrUpdateSport($newSportname));
		}
		else
			return "Sport not found";	
	}
	function removeSport($sportname)
	{
		$sport=$this->sport->constructor($sportname);
		if($sport->checkIfSportnameExist()==1)
		{
			$this->db->query("UPDATE sport SET accessible = false where sport='$sportname'");
			return 1;
		}
		else
			return "Sport not found";
	}**/
	
	function addSport($sportname)
	{
		$this->db->query("INSERT INTO sport(sportname) VALUES ('$sportname')");
	}
	
	function getSportList()
	{
		return $this->db->query("SELECT sport_id, sportname FROM sport WHERE accessible = 'true'");
	}
	
	function getSportById($id)
	{
		return $this->db->get_where('sport', array('sport_id'=> $id));
	}
	
	function updateSport($id, $data)
	{
		$this->db->where('sport_id', $id);
		$this->db->update('sport', $data); 
	}
	
	function disableSport($id)
	{
		$this->db->query("UPDATE sport SET accessible = 'false' WHERE sport_id = '$id'");
	}
	
	function searchSport($sportname)
	{
		$this->db->query("SELECT * FROM sport WHERE sportname= '$sportname' AND accessible= 'true'");
	}
	function checkIfSportnameExist($sportname)
	{
		$result=$this->db->query("SELECT * FROM sport where sportname='$sportname' AND accessible='true'");
		if($result->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
}
?>