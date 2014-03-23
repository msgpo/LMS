<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH .'models/doubleEliminationTournament.php');
class TestDoubleEliminationTournament extends CI_Controller 
{	
	function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');        
    }
	
	public function index()
    {
		$this->testTotalNumberOfMatches();
		$this->testNumberOfMatchesInWinnersBracket();
		$this->testNumberOfMatchesInLosersBracket();
		$this->testNumberOfByesInWinnersBracket();
		$this->testNumberOfByesInLosersBracket();
		$this->testForCalculatingNumberOfMatchInFirstRoundInWinnersBracket();
		$this->testForCalculatingNumberOfMatchInFirstRoundInLosersBracket();
		$this->testForCalculatingNumberOfMatchInSecondRoundInWinnersBracket();
		$this->testForCalculatingNumberOfMatchInSecondRoundInLosersBracket();
		$this->testNumberOfByesInWinnersBracket();
		$this->testForValidGeneratingMatch();
		$this->testForInvalidGeneratingMatch();
		echo $this->unit->report();
        echo base_url();
	}
	
	function testTotalNumberOfMatches()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$doubleElimination=new DoubleEliminationTournament($team_iDs);
		$numberOfMatches=$doubleElimination->calculateNumberOfMatches();
		$expected_result = 10;
		$test_name = 'Calculating total number of match given an array of teams';
		$this->unit->run($numberOfMatches, $expected_result, $test_name); 
	}
	
	function testNumberOfMatchesInWinnersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$doubleElimination=new DoubleEliminationTournament($team_iDs);
		$numberOfMatches=$doubleElimination->calculateNumberOfMatchesInWinnerBracket();
		$expected_result = 5;
		$test_name = 'Calculating number of match in winners bracket given an array of teams';
		$this->unit->run($numberOfMatches, $expected_result, $test_name); 
	}
	function testNumberOfMatchesInLosersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$doubleElimination=new DoubleEliminationTournament($team_iDs);
		$numberOfMatches=$doubleElimination->calculateNumberOfMatchesInLoserBracket();
		$expected_result = 4;
		$test_name = 'Calculating number of match in losers bracket given an array of teams';
		$this->unit->run($numberOfMatches, $expected_result, $test_name); 
	}
	
	function testNumberOfByesInWinnersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$singleElimTournament=new DoubleEliminationTournament($team_iDs);
		$numberOfByes=$singleElimTournament->calculateNumberOfByesInWinnerBracket();
		$expected_result = 2;
		$test_name = 'Calculating number of byes in winners bracket given an array of teams';
		$this->unit->run($numberOfByes, $expected_result, $test_name); 
	}
	
	function testNumberOfByesInLosersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$singleElimTournament=new DoubleEliminationTournament($team_iDs);
		$numberOfByes=$singleElimTournament->calculateNumberOfByesInLoserBracket();
		$expected_result = 3;
		$test_name = 'Calculating number of byes in losers bracket given an array of teams';
		$this->unit->run($numberOfByes, $expected_result, $test_name); 
	}
	
	function testForCalculatingNumberOfMatchInFirstRoundInWinnersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$singleElimTournament=new DoubleEliminationTournament($team_iDs);
		$numberOfByes=$singleElimTournament->calculateNumberOfMatchInFirstRoundInWinnerBracket();
		$expected_result = 2;
		$test_name = 'Calculating number of match in first round round in winners bracket';
		$this->unit->run($numberOfByes, $expected_result, $test_name); 
	}
	
	function testForCalculatingNumberOfMatchInFirstRoundInLosersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$singleElimTournament=new DoubleEliminationTournament($team_iDs);
		$numberOfByes=$singleElimTournament->calculateNumberOfMatchInFirstRoundInLoserBracket();
		$expected_result = 1;
		$test_name = 'Calculating number of match in first round in losers bracket';
		$this->unit->run($numberOfByes, $expected_result, $test_name); 
	}
	
	
	function testForCalculatingNumberOfMatchInSecondRoundInWinnersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353,3=>345353,4=>345345,5=>342432);
		$doubleElimination=new DoubleEliminationTournament($team_iDs);
		$numberOfByes=$doubleElimination->calculateNumberOfMatchInSecondRoundInWinnerBracket();
		$expected_result = 2;
		$test_name = 'Calculating number of match in second round in winners bracket';
		$this->unit->run($numberOfByes, $expected_result, $test_name); 
	}
	
	
	function testForCalculatingNumberOfMatchInSecondRoundInLosersBracket()
	{
		$team_iDs= array(0=>342,1=>3453,2=>4353);
		$doubleElimination=new DoubleEliminationTournament($team_iDs);
		$result=$doubleElimination->calculateNumberOfMatchInSecondRoundInLoserBracket();
		$expected_result=0;
		$test_name = 'Calculating number of match in second round in losers bracket';
		$this->unit->run($result, $expected_result, $test_name); 
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
		$team_iDs= array(0=>342,1=>3453,2=>4353);
		$doubleElimination=new DoubleEliminationTournament($team_iDs);
		$result=$doubleElimination->generateMatches();
		$numberOfMatch=count($doubleElimination->getMatches());
		$expected_result=4;
		$test_name = 'Valid Generating Match';
		$this->unit->run($numberOfMatch, $expected_result, $test_name); 
	}
	
	function testForInvalidGeneratingMatch()
	{
		$team_iDs= array(0=>342,1=>3453);
		$singleElimTournament=new DoubleEliminationTournament($team_iDs);
		$result=$singleElimTournament->generateMatches();
		$expected_result =0;
		$test_name = 'Invalid Generating Match (insufficient teams)';
		$this->unit->run($result, $expected_result, $test_name); 
	}

}?>