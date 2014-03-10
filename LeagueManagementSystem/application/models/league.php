<?php 
class League
{
        private $leaguename;
	private $sport_id;
	private $tournamentType;
	private $registrationDeadline;
	public function __construct($leaguename, $sport_id, $tournamentType, $registrationDeadline)
	{
		$this->leaguename=$leaguename;
		$this->sport_id=$sport_id;
		$this->tournamentType=$tournamentType;
		$this->registrationDeadline=$registrationDeadline;
	}
	
	public function getLeaguename()
	{
		return $this->leaguename;
	}
	
	public function getSport_id()
	{
		return $this->sport_id;
	}
	
	public function getTournamentType()
	{
		return $this->tournamentType;
	}
	
	public function getRegistrationDeadline()
	{
		return $this->registrationDeadline;
	}
	
	public function getTournaments()
	{
		return $this->tournaments;
	}
		
}
?>
