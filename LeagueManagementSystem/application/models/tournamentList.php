<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/match.php');
include_once(APPPATH .'models/singleEliminationTournament.php');
include_once(APPPATH .'models/doubleEliminationTournament.php');
abstract class TournamentList  extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('leagueList','',TRUE);
		$this->load->model('teamList','',TRUE);
	}
	
	//abstract protected function createTournament($league_id);
	
	//abstract protected function insertMatch(Match $match, $league_id);
	
	//abstract protected function updateMatchListing($winnerTeam, $matchID, $leagueID);
}?>