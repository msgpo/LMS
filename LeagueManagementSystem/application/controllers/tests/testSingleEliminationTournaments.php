<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/singleEliminationTournament.php');
class TestSingleEliminationTournaments extends CI_Controller 
{	
	function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');        
		$this->load->model('leagueList','',TRUE);
		$this->load->model('tournamentInitializer','',TRUE);
    }
	
	public function index()
    {
		/**$team=array(0=>"aa",1=>"bb",2=>"cc",3=>"dd");
		$singleEliminationTournament= new SingleEliminationTournament($team);
		$singleEliminationTournament->generateMatches();
		echo count($singleEliminationTournament->getMatches());**/
		$result= $this->tournamentInitializer->startSingleElimination(24);
		echo $result;
		
	}
	
	function testForValidSingleEliminationTournament()
	{
			/**$singleEliminationTournament= new SingleEliminationTournament(2);
			$singleEliminationTournament->generateMatches();
			$result= $this->tournamentList->addTournament($singleEliminationTournament);
			$result=$this->matchList->initiateMatchInSingleElimination(2);
			$expected_result=1;
			$test_name = 'Valid for creating a single elimination tournament';
			$this->unit->run($test_res, $expected_result, $test_name);**/
	}
	
}