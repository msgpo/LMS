<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestLeague extends CI_Model 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
                $this->load->model('leagueList','',TRUE);
        }
		
		function testForValidLeagueCreation()
		{
			$league=$this->league->constructor("Palakasan 2011",15,"Double Elimination", "2014-08-14");
			$result = $this->leagueList->createLeague($league);
			$test_res=$result;
			$expected_result=1;
			$test_name = 'Valid league name, Sport name, tournament type, date of registration deadline';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		function testForInvalidLeagueCreation1()
		{
			$league=$this->league->constructor(" ",15,"Double Elimination", "2014-08-14");
			$result = $this->leagueList->createLeague($league);
			$test_res=$result[0];
			$expected_result="The Leaguename field is required";
			$test_name = 'Test of Invalid League name (league name is blank)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidLeagueCreation2()
		{
			$league=$this->league->constructor("Palakasan 2019",15," ", "2014-08-14");
			$result = $this->leagueList->createLeague($league);
			$test_res=$result[0];
			$expected_result="Invalid Tournament type";
			$test_name = 'Test of Invalid Tournament';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		
		function testForInvalidLeagueCreation3()
		{
			$league=$this->league->constructor("palakasan 2014",15,"Single Elimination", "2014-08-14");
			$result = $this->leagueList->createLeague($league);
			$test_res=$result[0];
			$expected_result="league name already exist in a given sport";
			$test_name = 'Test of Invalid League name (league name already exist within the given sport)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidLeagueCreation4()
		{
			$league=$this->league->constructor("Palakasan 2019",20,"Double Elimination", "2014-08-14");
			$result = $this->leagueList->createLeague($league);
			$test_res=$result[0];
			$expected_result="Sport id not found";
			$test_name = 'Test of Invalid Creating League(The given sport id doesnt exist in the database)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidLeagueCreation5()
		{
			$league=$this->league->constructor("Palakasan 2019",15,"Double Elimination", "2014/20/10");
			$result = $this->leagueList->createLeague($league);
			$test_res=$result[0];
			$expected_result= "Invalid date syntax. The syntax mus be yyyy-mm-dd";
			$test_name = 'Test of Invalid Creating League(Invalid syntax of date)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForValidLeagueEdition()
		{
			$league=$this->league->constructor("Palakasan 2016",15,"double Elimination", "2014-09-10"); //2016 & 2013
			$result = $this->leagueList->editLeague(2,$league);
			$test_res=$result;
			$expected_result= 1;
			$test_name = 'Test of Valid Data For Editing League';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		function testForInvalidLeagueEdition1()
		{
			$league=$this->league->constructor("Palakasan 2017",15,"double Elimination", "2014-09-10");
			$result = $this->leagueList->editLeague(4,$league);
			$test_res=$result[0];
			$expected_result= "League id not Found";
			$test_name = 'Test of Invalid Editing League (league_id not Found)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		function testForInvalidLeagueEdition2()
		{
			$league=$this->league->constructor(" ",15,"Double Elimination", "2014-08-14");
			$result = $this->leagueList->editLeague(2,$league);
			$test_res=$result[0];
			$expected_result="The Leaguename field is required";
			$test_name = 'Test of Invalid Editing League (league name is blank)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidLeagueEdition3()
		{
			$league=$this->league->constructor("Palakasan 2017",15,"myingle Elimination", "2014-08-14");
			$result = $this->leagueList->editLeague(2,$league);
			$test_res=$result[0];
			$expected_result="Invalid Tournament type";
			$test_name = 'Test for invalid Editing League (Invalid Tournament)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidLeagueEdition4()
		{
			$league=$this->league->constructor("Palakasan 2014",15,"Double Elimination", "2014-08-14");
			$result = $this->leagueList->editLeague(2,$league);
			$test_res=$result[0];
			$expected_result="league name already exist in a given sport";
			$test_name = 'Test of Invalid Editing League (The given league name has already exist within the given sport)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidLeagueEdition5()
		{
			$league=$this->league->constructor("Palakasan 2017",20,"Double Elimination", "2014-08-14");
			$result = $this->leagueList->editLeague(2,$league);
			$test_res=$result[0];
			$expected_result="Sport id not found";
			$test_name = 'Test of Invalid Editing League(The given sport id doesnt exist in the database)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		function testForInvalidLeagueEdition6()
		{
			$league=$this->league->constructor("Palakasan 2017",15,"Double Elimination", "2014/20/10");
			$result = $this->leagueList->editLeague(2,$league);
			$test_res=$result[0];
			$expected_result= "Invalid date syntax. The syntax mus be yyyy-mm-dd";
			$test_name = 'Test of Invalid Editing League(The given date format is invalid)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForValidDeactivatingLeague()
		{
			$result = $this->leagueList->deactivateLeague(7);
			$test_res=$result;
			$expected_result=1;
			$test_name = 'Test of Valid Deactivating League';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		function testForInvalidDeactivatingLeague()
		{
			$result = $this->leagueList->deactivateLeague(100);
			$test_res=$result;
			$expected_result="League id not Found";
			$test_name = 'Test of Valid Deactivating League (League id doesnt exist in database)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		/**function testIfTheLeaguHasStarted()
		{
			$result = $this->leaguelist->checkLeagueIfStartedOrEnded(3);
			$test_res=$result;
			$expected_result=true;
			$test_name = 'Test if League has started';
			$this->unit->run($test_res, $expected_result, $test_name);
		}**/
}

/* End of file testLeague.php */
/* Location: ./application/models/testLeague.php */