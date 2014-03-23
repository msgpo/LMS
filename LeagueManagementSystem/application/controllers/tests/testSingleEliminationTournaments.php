<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/singleEliminationTournament.php');
class TestSingleEliminationTournaments extends CI_Controller 
{	
	function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');
		$this->load->model('singleEliminationTournamentList','',TRUE);
    }
	
	public function index()
    {
		$this->testNumberOfMatches();
		$this->testNumberOfByes();
		$this->testNumberOfRounds();
		$this->testNumberOfMatchInFirstRound();
		$this->testNumberOfMatchInSecondRound();
		$this->testForValidGeneratingMatch();
		$this->testForInvalidGeneratingMatch();
		$this->testforValidCreatingSingleEliminationTournament();
		$this->testforInvalidCreatingSingleEliminationTournament();
		$this->testforInvalidCreatingSingleEliminationTournament2();
		$this->testForValidUpdatingMatchInTournament();
		$this->testForInvalidUpdatingMatchInTournament();
		//$this->testForInvalidUpdatingMatchInTournament2();
		/**$this->testForInvalidUpdatingMatchInTournament3();**/
		echo $this->unit->report();
        echo base_url();
	}
	
	/**
		The first 7 tests are for the functionality of Single Elimination tournament class
		We assume an array of teams
	**/
	function testNumberOfMatches()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$singleElimTournament=new SingleEliminationTournament($team_iDs);
		$numberOfMatches=$singleElimTournament->calculateNumberOfMatches();
		$expected_result = 5;
		$test_name = 'Calculating number of match given an array of teams';
		$this->unit->run($numberOfMatches, $expected_result, $test_name); 
	}
	
	function testNumberOfByes()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$singleElimTournament=new SingleEliminationTournament($team_iDs);
		$numberOfByes=$singleElimTournament->calculateNumberOfByes();
		$expected_result = 2;
		$test_name = 'Calculating number of byes given an array of teams';
		$this->unit->run($numberOfByes, $expected_result, $test_name); 
	}
	
	function testNumberOfRounds()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432,6=>342,7=>234);
		$singleElimTournament=new SingleEliminationTournament($team_iDs);
		$numberOfRounds=$singleElimTournament->calculateNumberOfRounds();
		$expected_result = 3;
		$test_name = 'Calculating number of rounds given an array of teams';
		$this->unit->run($numberOfRounds, $expected_result, $test_name); 
	}
	
	function testNumberOfMatchInFirstRound()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432,6=>342,7=>234);
		$singleElimTournament=new SingleEliminationTournament($team_iDs);
		$numberOfMatchInFirstRound=$singleElimTournament->calculateNumberOfMatchInFirstRound();
		$expected_result = 4;
		$test_name = 'Calculating number of match in first round given an array of teams';
		$this->unit->run($numberOfMatchInFirstRound, $expected_result, $test_name); 
	}
	
	function testNumberOfMatchInSecondRound()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432,6=>342,7=>234);
		$singleElimTournament=new SingleEliminationTournament($team_iDs);
		$numberOfMatchInSecondRound=$singleElimTournament->calculateNumberOfMatchInSecondRound();
		$expected_result = 2;
		$test_name = 'Calculating number of match in second round given an array of teams';
		$this->unit->run($numberOfMatchInSecondRound, $expected_result, $test_name); 
	}
	
	function testForValidGeneratingMatch()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432,6=>342,7=>234);
		$singleElimTournament=new SingleEliminationTournament($team_iDs);
		$result=$singleElimTournament->generateMatches();
		$expected_result =1;
		$test_name = 'Valid Generating Match';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	function testForInvalidGeneratingMatch()
	{
		$team_iDs= array(0=>342,1=>3453);
		$singleElimTournament=new SingleEliminationTournament($team_iDs);
		$result=$singleElimTournament->generateMatches();
		$expected_result =0;
		$test_name = 'Invalid Generating Match';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	//Test for valid creating a single elimination tournament in the database
	function testforValidCreatingSingleEliminationTournament()
	{
		$result=$this->singleEliminationTournamentList->createTournament(30);
		$expected_result =1;
		$test_name = 'Valid Creating a Single Elimination(league_id exist in database, valid number of teams)';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	
	//Test for invalid creating a single elimination tournament in the database due to insufficient teams
	function testforInvalidCreatingSingleEliminationTournament()
	{
		$result=$this->singleEliminationTournamentList->createTournament(59);
		$expected_result = "Tournament Cannot be Started, Not enough teams";
		$test_name = 'Invalid Creating a Single Elimination (Not enough teams)';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	
	//Test for invalid creating a single elimination tournament in the database (League id doesn't exist in database)
	function testforInvalidCreatingSingleEliminationTournament2()
	{
		$result=$this->singleEliminationTournamentList->createTournament(1000);
		$expected_result = "league not found";
		$test_name = 'Invalid Creating a Single Elimination Tournament (League id doesnt exist in database)';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	//Test for valid updating match in a single elimination tournament in the database
	function testForValidUpdatingMatchInTournament()
	{
		$result=$this->singleEliminationTournamentList->updateMatchListing(53, 1797);
		$expected_result = 1;
		$test_name = 'Valid Updating Match In Single Elim Tournament';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	
	//Test For invalid updating match (Match not found)
	function testForInvalidUpdatingMatchInTournament()
	{
		$result=$this->singleEliminationTournamentList->updateMatchListing(53, 99999999);
		$expected_result = "Match not found";
		$test_name = 'Invalid Updating Match (Match not found)';
		$this->unit->run($result, $expected_result, $test_name); 
	}
}