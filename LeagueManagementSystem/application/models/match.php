<?php
class Match
{
        private $teamA;
		private $teamB;
		private $scoreOfA;
		private $scoreOfB;
		private $winner;
		private $loser;
		private $roundNumber;
		
		function __construct($teamA, $teamB, $roundNumber)
		{
			$this->teamA=$teamA;
			$this->teamB=$teamB;
			$this->roundNumber=$roundNumber;
		}
		public function getTeamA()
		{
			return $this->teamA;
		}
		public function getTeamB()
		{
			return $this->teamB;
		}
		public function getScoreOfA()
		{	
			return $this->scoreOfA;
		}
		public function getScoreOfB()
		{
			return $this->scoreOfB;
		}
		public function getWinner()
		{
			return $this->winner;
		}
		public function getLoser()
		{
			return $this->loser;
		}
		public function getRoundNumber()
		{
			return $this->roundNumber;
		}
}
?>