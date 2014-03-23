<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestTeam extends CI_Controller 
{
	function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');        
		$this->load->model('teamList','',TRUE);
		$this->load->model('leagueList','',TRUE);
    }
	
	public function index()
	{
		$this->testForValidAddTeam();
		$this->testTeamnameAlreadyExist();
		$this->testBlankname();
		$this->testLeagueNotFound();
		$this->testBlankLastname();
		$this->testBlankFirstname();
		$this->testInvalidPhonenumber();
		echo $this->unit->report();
        echo base_url();
	}
	
	function testForValidAddTeam()
	{
		$team=new Team("LA Lakers",1,"D-Antoni", "Mike","09271123463", "No Description");
		$result = $this->teamList->addTeam($team);
		$expected_result = 1;
		$test_name = 'Valid Adding Team Under a league';
		$this->unit->run($result, $expected_result, $test_name); 
	}
	
	function testTeamnameAlreadyExist()
	{
		$team=new Team("SCS Wolves",1,"Agantal", "Jalal","09271123463", "No Description");
		$result = $this->teamList->addTeam($team);
		$test_res=$result[0];
		$expected_result = "Team name already exist within the given league";
		$test_name = 'Team name already exist';
		$this->unit->run($test_res, $expected_result, $test_name); 
	}
	
	function testBlankname()
	{
		$team=new Team("",1,"D-Antoni", "Mike","09271123463", "No Description");
		$result = $this->teamList->addTeam($team);
		$test_res=$result[0];
		$expected_result = "The Teamname field is required";
		$test_name = 'Blank team name';
		$this->unit->run($test_res, $expected_result, $test_name); 
	}
	function testLeagueNotFound()
	{
		$team=new Team("Lakers",100,"D-Antoni", "Mike","09271123463", "No Description");
		$result = $this->teamList->addTeam($team);
		$test_res=$result[0];
		$expected_result =  "league id not found";
		$test_name = 'League Not Found';
		$this->unit->run($test_res, $expected_result, $test_name); 
	}
	
	function testBlankLastname()
	{
		$team=new Team("Lakers",100," ", "Mike","09271123463", "No Description");
		$result = $this->teamList->addTeam($team);
		$test_res=$result[0];
		$expected_result =  "The Lastname field is required";
		$test_name = 'Blank Last name';
		$this->unit->run($test_res, $expected_result, $test_name); 
	}
	function testBlankFirstname()
	{
		$team=new Team("Lakers",100,"D-Antoni", "","09271123463", "No Description");
		$result = $this->teamList->addTeam($team);
		$test_res=$result[0];
		$expected_result =  "The Firstname field is required";
		$test_name = 'Blank First name';
		$this->unit->run($test_res, $expected_result, $test_name); 
	}
	function testInvalidPhonenumber()
	{
		$team=new Team("Lakers",100,"D-Antoni", "Mike","12345678901", "No Description");
		$result = $this->teamList->addTeam($team);
		$test_res=$result[0];
		$expected_result =  "The Phone number field is invalid";
		$test_name = 'Invalid Phonenumber';
		$this->unit->run($test_res, $expected_result, $test_name); 
	}
	

}?>