<?php
class Match
{
        private $teamA;
		private $teamB;
		private $winner;
		private $loser;
		private $roundNumber;
		private $bracket;
		
		function __construct($teamA, $teamB, $roundNumber,$bracket)
		{
			$this->teamA=$teamA;
			$this->teamB=$teamB;
			$this->roundNumber=$roundNumber;
			$this->bracket=$bracket;
		}
		public function getTeamA()
		{
			return $this->teamA;
		}
		
		public function getBracket()
		{
			return $this->bracket;
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