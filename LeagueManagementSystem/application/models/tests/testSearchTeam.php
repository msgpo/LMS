<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestSearchTeam extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');        
		$this->load->model('teamRegister','',TRUE);
    }
	
	// Assumed Team ID: 1
	
	function testForValidTeamId()
	{
		$result = $this->teamRegister->searchLeagueById(1);
		$expected_result = 'is_object'; //object ang result sa query
		$test_name = 'Team Is Found';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	function testForInvalidLeagueId()
	{
		$result = $this->leagueRegister->searchLeagueById(-1);
		$expected_result = 'is_string';
		$test_name = 'League Is Not Found';
		$this->unit->run($result, $expected_result, $test_name); 
	}
}