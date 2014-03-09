<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestSport extends CI_Controller 
{
        function __construct()
        {
            parent::__construct();
			$this->load->library('unit_test');
			$this->load->model('sportList','',TRUE);
        }
		 /* In this Test, we assume that the sportname"football" has already exist in the database. 
		* To pass the test, you need to insert first "football" sport name in the database(Note: The query code is provided in the README text) before you run this test.
        */

        public function index()
        {
            $this->testForValidAddSport();
			$this->testForInvalidAddSport1();
            $this->testForInvalidAddSport2();
			$this->testForValidEditionOfSport();
			$this->testForInvalidEditionOfSport1();
			$this->testForInvalidEditionOfSport2();
			$this->testForInvalidEditionOfSport3();
			$this->testForSuccessDisablingOfSport();
			$this->testForFailDisablingOfSport();
            echo $this->unit->report();
            echo base_url();
        }
		function testForValidAddSport()
		{
			$result = $this->sportList->addSport("basketball");
			$test_res=$result;
			$expected_result=1; 
			$test_name = 'Valid Sport name for creating Sport';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForInvalidAddSport1()
		{
			$result = $this->sportList->addSport("volleyball");
			$test_res = $result;
			$expected_result= "The Sportname already exist"; 
            $test_name = 'Invalid Sport name for creating Sport (Sport Name Already Exist)'; 
            $this->unit->run($test_res, $expected_result, $test_name);
        }
        
		function testForInvalidAddSport2()
		{
			$result = $this->sportList->addSport(" ");
			$test_res=$result;
			$expected_result= "The Sportname field is required"; 
			$test_name = 'Invalid Sport name for creating Sport (Blank Sport Name)';
			$this->unit->run($test_res, $expected_result, $test_name); 
		}
		
		function testForValidEditionOfSport()
		{
			$result = $this->sportList->editSport(1,"archery");
			$test_res=$result;
			$expected_result=1; 
			$test_name = 'Valid Edition of Sport';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		function testForInvalidEditionOfSport1()
		{
			$result = $this->sportList->editSport(4,"bowling");
			$test_res=$result;
			$expected_result= "Sport id not found"; 
			$test_name = 'Invalid Edition of Sport(SportName doesnt exist in database)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		function testForInvalidEditionOfSport2()
		{
			$result = $this->sportList->editSport(2,"volleyball");
			$test_res=$result;
			$expected_result= "The Sportname already exist"; 
			$test_name = 'Invalid Edition of Sport(The new Sportname already exist)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		function testForInvalidEditionOfSport3()
		{
			$result = $this->sportList->editSport(2," ");
			$test_res=$result;
			$expected_result= "The Sportname field is required";
			$test_name = 'Invalid Edition of Sport(The new sportname is blank)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		function testForSuccessDisablingOfSport()
		{
			$result = $this->sportList->disableSport(2);
			$test_res=$result;
			$expected_result=1; 
			$test_name = 'Success Deletion of Sport(Sport id Exists in database)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
		
		function testForFailDisablingOfSport()
		{
			$result = $this->sportList->disableSport(4);
			$test_res=$result;
			$expected_result= "Sport id not found";
			$test_name = 'Failed Deletion of Sport(Sport id doesnt exist in database)';
			$this->unit->run($test_res, $expected_result, $test_name);
		}
		
}
?>