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
	function checkIfSportnameIsBlank()
	{
		if(strlen($this->sportname)==0)
			return 1;
		else
			return 0;
	}
	function getSportById($id)
	{
		$query=$this->db->query("SELECT * FROM sport where sport_id='$id");
		foreach($query->result() as $row)
		{
			$result= $row->sportname;
		}
		return $result;
	}
}
?>