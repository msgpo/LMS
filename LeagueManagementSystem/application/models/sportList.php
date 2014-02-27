<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SportList extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('sport','',TRUE);
		$this->load->library('form_validation');
		$this->load->helper('form');
    }
	
	function addSport($sportname)
	{
		$sport=$this->sport->constructor($sportname);
		if((!$sport->sportnameExist())&&(!$sport->sportnameIsBlank()))
			return $this->insert($sportname);
		else
			return ($this->invalidAddOrUpdateSport($sportname));
	}
	
	function invalidAddOrUpdateSport($sportname)
	{
		$sport=$this->sport->constructor($sportname);
		if($sport->sportnameExist())
			return "The Sportname already exist";
		else if ($sport->sportnameIsBlank())
			return "The Sportname field is required";
	}
	
	function insert($sportname)
	{
		$s=strtolower($sportname);
		$this->db->query("INSERT INTO sport(sportname) VALUES ('$s')");
		return 1;
	}
	
	function editSport($id,$newSportname)
	{
		$sport=$this->sport->constructor($newSportname);
		if((!$sport->sportnameExist())&&(!$sport->sportnameIsBlank()))
			return $this->update($id, $newSportname);
		else
			return ($this->invalidAddOrUpdateSport($newSportname));
	}
	
	function update($id, $sportname)
	{
		if($this->sport->getSportById($id)->num_rows()>0)
		{
			$sportname=strtolower($sportname);
			$this->db->query("UPDATE sport SET sportname='$sportname' WHERE sport_id='$id'");
			return 1;
		}
		else
			return "Sport id not found";
	}
	
	function getSportList()
	{
		return $this->db->query("SELECT * FROM sport WHERE accessible = 'true' ORDER BY sport_id");
	}
	
	function disableSport($id)
	{
		if($this->sport->getSportById($id)->num_rows()>0)
		{
			$this->db->query("UPDATE sport SET accessible = 'false' WHERE sport_id = '$id'");
			return 1;
		}
		else
			return "Sport id not found";
	}
}
?>
