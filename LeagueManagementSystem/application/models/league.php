<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class League extends CI_Model
{
        private $leaguename;
		private $sport_id;
		private $tournamentType;
		private $registrationDeadline;
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
			$tournaments=array('a'=>"single elimination", 'b'=>"double elimination", 'c'=>"round robin");
			foreach($tournaments as $t)
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
		
		public function sportIdNotFound()
		{
			$result=$this->sport->getSportById($this->sport_id);
			if($result->num_rows()>0)
				return FALSE;
			else
				return TRUE;
		}
		
		public function getLeagueById($id)
		{
			//return $result=$this->db->get_where('league', array('league_id'=> $id));
			return $result=$this->db->query("SELECT * FROM league where league_id=$id AND accessible='true'");
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