<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestSport extends CI_Model 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
                $this->load->model('sportRegister','',TRUE);
        }        
                /* In this Test, we assume that the sportname"football" has already exist in the database. 
				 * To pass the test, you need to insert first "football" sport name in the database(Note: The query code is provided in the README text) before you run this test.
                 */
				
       function testForValidAddSport()
		{
			$result = $this->sportRegister->addSport("basketball");
			$test_res=$result;
			$expected_result=1; //-1 return value in 'addSport' function means the given sportname is blank.
			$test_name = 'Valid Sport name for creating Sport';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidAddSport1()
        {
                $result = $this->sportRegister->addSport("football");
                $test_res = $result;
				$expected_result="The Sportname already exist"; 
                $test_name = 'Invalid Sport name for creating Sport (Sport Name Already Exist)'; 
                $this->unit->run($test_res, $expected_result, $test_name); 
        }
        
		function testForInvalidAddSport2()
		{
			$result = $this->sportRegister->addSport("");
			$test_res=$result;
			$expected_result="The Sportname is blank"; 
			$test_name = 'Invalid Sport name for creating Sport (Blank Sport Name)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		function testForSuccessDeletionOfSport()
		{
			$result = $this->sportRegister->deleteSport("soccer");
			$test_res=$result;
			$expected_result=1; 
			$test_name = 'Success Deletion of Sport(Sport Name Exists in database)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		function testForFailDeletionOfSport1()
		{
			$result = $this->sportRegister->deleteSport("dart");
			$test_res=$result;
			$expected_result="Sport not found";
			$test_name = 'Failed Deletion of Sport(Sport Name doesnt exist in database)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		function testForValidEditionOfSport()
		{
			$result = $this->sportRegister->editSport("tennis","volleyball");
			$test_res=$result;
			$expected_result=1; 
			$test_name = 'Valid Edition of Sport';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		function testForInvalidEditionOfSport1()
		{
			$result = $this->sportRegister->editSport("dart","tennis");
			$test_res=$result;
			$expected_result="Sport not found"; 
			$test_name = 'Invalid Edition of Sport(SportName doesnt exist in database)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		function testForInvalidEditionOfSport2()
		{
			$result = $this->sportRegister->editSport("volleyball","football");
			$test_res=$result;
			$expected_result="The Sportname already exist"; 
			$test_name = 'Invalid Edition of Sport(The new Sportname already exist)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		function testForInvalidEditionOfSport3()
		{
			$result = $this->sportRegister->editSport("volleyball","");
			$test_res=$result;
			$expected_result="The Sportname is blank";
			$test_name = 'Invalid Edition of Sport(The new sportname is blank)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
}

/* End of file sportTestModel.php */
/* Location: ./application/models/sportTestModel.php */