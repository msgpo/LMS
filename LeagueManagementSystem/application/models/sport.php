<?php 
class Sport
{
	private $sportname;
	function __construct($sportname)
	{
		$this->sportname=$sportname;
	}
	
	function getSportname()
	{
		return $this->sportname;
	}
}
?>
