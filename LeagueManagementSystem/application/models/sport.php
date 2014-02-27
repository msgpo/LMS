<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sport extends CI_Model
{
	private $sportname;
	function __construct()
	{
		parent::__construct();
	}
	
	function constructor($sportname)
	{
		$this->sportname=$sportname;
		return $this;
	}
	
	function getSportname()
	{
		return $this->sportname;
	}
	
	function setSportName($sportname)
	{
		$this->db->query("UPDATE sport SET sportname='$sportname' WHERE sportname='$this->sportname'");
	}
	function sportnameIsBlank()
	{
		if(trim($this->sportname)=="")
			return TRUE;
		else
			return FALSE;
	}
	function sportnameExist()
	{
		$sportname=strtolower($this->sportname);
		$result=$this->db->query("SELECT * FROM sport where sportname='$sportname' AND accessible='true'");
		if($result->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
	
	function getSportById($id)
	{
		return $result=$this->db->get_where('sport', array('sport_id'=> $id));
	}
}
?>
