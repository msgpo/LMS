<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestLeague extends CI_Model 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
                $this->load->model('leagueRegister','',TRUE);
				 $this->load->model('league','',TRUE);
        }
		function testForValidLeagueCreation()
		{
			$league=$this->league->constructor("Palakasan 2014", "basketball","Double Elimination", "2014/08/14");
			$result = $this->leagueRegister->createLeague($league);
			$test_res=$result;
			$expected_result=1;
			$test_name = 'Valid league name, Sport name, tournament type, date of registration deadline';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		function testForInvalidLeagueCreation1()
		{
			$league=$this->league->constructor("Palakasan 2012", "basketball","Double Elimination", "2014/08/14");
			$result = $this->leagueRegister->createLeague($league);
			$test_res=$result;
			$expected_result="league name already exist in a given sport";
			$test_name = 'Test of Invalid League name (league name already exist within the given sport)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		function testForInvalidLeagueCreation2()
		{
			$league=$this->league->constructor("Palakasan 2014", "dart","Double Elimination", "2014/08/14");
			$result = $this->leagueRegister->createLeague($league);
			$test_res=$result;
			$expected_result="sport name not found";
			$test_name = 'Test of Invalid Sport (sport name doesnt exist in the database)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		function testForInvalidLeagueCreation3()
		{
			$league=$this->league->constructor("", "dart","Double Elimination", "2014/08/14");
			$result = $this->leagueRegister->createLeague($league);
			$test_res=$result;
			$expected_result="sport name not found";
			$test_name = 'Test of Invalid Sport (sport name doesnt exist in the database)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
      
}

/* End of file testLeague.php */
/* Location: ./application/models/testLeague.php */