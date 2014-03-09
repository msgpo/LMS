<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestSearchLeague extends CI_Controller 
{
	function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');        
		$this->load->model('leagueRegister','',TRUE);
    }
	
	// Assumed League ID: 1
	
	function testForValidLeagueId()
	{
		$result = $this->leagueRegister->searchLeagueById(1);
		$expected_result = 'is_object'; //object ang result sa query
		$test_name = 'League Is Found';
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