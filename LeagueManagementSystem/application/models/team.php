<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Model
{
        private $teamname;
		private $league_id;
		private $coachLastname;
		private $coachFirstname;
		private $coachPhonenumber;
		private $teamDesc;
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('sport','',TRUE);
		}
		
		function constructor($teamname, $league_id, $coachLastname, $coachFirstname, $coachPhonenumber, $teamDesc)
		{
			$this->teamname=$teamname;
			$this->league_id=$league_id;
			$this->coachLastname=$coachLastname;
			$this->coachFirstname=$coachFirstname;
			$this->coachPhonenumber=$coachPhonenumber;
			$this->teamDesc=$teamDesc;
			return $this;
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
		
		public function blankfield($anyField)
		{
			if(trim($anyField)=="")
				return TRUE;
			else
				return FALSE;
		}
		
		
		public function invalidPhoneNumberSyntax()
		{
			if(preg_match("/^09[0-9]{9}$/",$this->coachPhonenumber))
				return false;
			else
				return true;
		}
		
		public function teamNameExistWithinTheLeague()
		{
			$teamname=strtolower($this->teamname);
			$result=$this->db->query("SELECT * FROM team where teamname='$teamname' AND league_id= $this->league_id AND accessible='true'");
			if($result->num_rows()>0)
				return TRUE;
			else
				return FALSE;
		}
		
		public function leaugeIdNotFound()
		{
			$result=$this->league->getLeagueById($this->league_id);
			if($result->num_rows()>0)
				return FALSE;
			else
				return TRUE;
		}
		
		public function teamnameIsUnchanged($teamname)
		{
			if((strtolower($this->teamname)==strtolower($teamname)))
				return TRUE;
			else
				return FALSE;
		}
		
		/**public function getTeamById($id)
		{
			return $this->db->query("SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.league_id = '$id' AND league.accessible=true");
		}**/
		
		/**function checkIfLeagueNameExist()
		{
			$result=$this->db->query("SELECT * FROM league where leaguename='$this->leaguename'");
			if($result->num_rows()>0)
				return 1;
			else
				return 0;
		}
		function checkIfSportNameExist()
		{
			$result=$this->db->query("SELECT sportname FROM sport where sportname='$this->sportname'");
			if($result->num_rows()>0)
				return 1;
			else
				return 0;
		}**/
		
		
		
}
?>