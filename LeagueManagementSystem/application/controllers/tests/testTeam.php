<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestTeam extends CI_Controller 
{
	function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');        
		$this->load->model('teamList','',TRUE);
		$this->load->model('team','',TRUE);
		$this->load->model('league','',TRUE);
    }
	
	public function index()
	{
		$this->testForValidAddTeam();
		echo $this->unit->report();
        echo base_url();
	}
	
	function testForValidAddTeam()
	{
		$team=$this->team->constructor("LA Lakers",1,"D-Antoni", "Mike","09271123463", "No Description");
		$result = $this->teamList->addTeam($team);
		$expected_result = 1;
		$test_name = 'Valid Adding Team Under a league';
		$this->unit->run($result, $expected_result, $test_name); 
	}
}