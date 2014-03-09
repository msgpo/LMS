<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class League extends CI_Model
{
        private $leaguename;
		private $sport_id;
		private $tournamentType;
		private $registrationDeadline;
		private $tournaments=array('a'=>"single elimination", 'b'=>"double elimination", 'c'=>"round robin");
		public function __construct()
		{
			parent::__construct();
			$this->load->model('sport','',TRUE);
		}
		
		function constructor($leaguename, $sport_id, $tournamentType, $registrationDeadline)
		{
			$this->leaguename=$leaguename;
			$this->sport_id=$sport_id;
			$this->tournamentType=$tournamentType;
			$this->registrationDeadline=$registrationDeadline;
			return $this;
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
		
		public function blankfield($anyField)
		{
			if(trim($anyField)=="")
				return TRUE;
			else
				return FALSE;
		}
		
		public function invalidTounramentType()
		{
			$field=true;
			foreach($this->tournaments as $t)
			{
				if(strtolower($this->tournamentType)==$t)
					$field=false;
			}
			return $field;
		}
		
		public function invalidDateSyntax()
		{
			if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$this->registrationDeadline))
				return false;
			else
				return true;
		}
		
		public function leaguenameExistWithinTheSport()
		{
			$leaguename=strtolower($this->leaguename);
			$result=$this->db->query("SELECT * FROM league where leaguename='$leaguename' AND sport_id= $this->sport_id AND accessible='true'");
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
		
		public function sportIdNotFound()
		{
			$result=$this->sport->getSportById($this->sport_id);
			if($result->num_rows()>0)
				return FALSE;
			else
				return TRUE;
		}
		
		public function leaguenameandSportIsUnchanged($leaguename,$sport_id)
		{
			if((strtolower($this->leaguename)==strtolower($leaguename))&&($this->sport_id==$sport_id))
				return TRUE;
			else
				return FALSE;
		}
		public function getLeagueById($id)
		{
			return $this->db->query("SELECT sport.sportname, league.* FROM league INNER JOIN sport USING (sport_id) WHERE league.league_id = '$id' AND league.accessible=true");
		}
		
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