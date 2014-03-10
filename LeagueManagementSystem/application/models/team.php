<?php

class Team
{
        private $teamname;
		private $league_id;
		private $coachLastname;
		private $coachFirstname;
		private $coachPhonenumber;
		private $teamDesc;
		
		function __construct($teamname, $league_id, $coachLastname, $coachFirstname, $coachPhonenumber, $teamDesc)
		{
			$this->teamname=$teamname;
			$this->league_id=$league_id;
			$this->coachLastname=$coachLastname;
			$this->coachFirstname=$coachFirstname;
			$this->coachPhonenumber=$coachPhonenumber;
			$this->teamDesc=$teamDesc;
		}
		
		public function getTeamname()
		{
			return $this->teamname;
		}
		public function getLeague_id()
		{
			return $this->league_id;
		}
		public function getCoachLastname()
		{
			return $this->coachLastname;
		}
		public function getCoachFirstname()
		{
			return $this->coachFirstname;
		}
		public function getCoachPhonenumber()
		{
			return $this->coachPhonenumber;
		}
		public function getTeamDesc()
		{
			return $this->teamDesc;
		}
}
?>
