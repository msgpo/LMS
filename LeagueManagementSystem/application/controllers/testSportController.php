<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestSportController extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
                $this->load->model('testSport','',TRUE);
				$this->load->model('sport','',TRUE);
        }

        public function index()
        {
            $this->testSport->testForValidAddSport();
			$this->testSport->testForInvalidAddSport1();
            $this->testSport->testForInvalidAddSport2();
			$this->testSport->testForSuccessDeletionOfSport();
			$this->testSport->testForFailDeletionOfSport1();
			$this->testSport->testForValidEditionOfSport();
			$this->testSport->testForInvalidEditionOfSport1();
			$this->testSport->testForInvalidEditionOfSport2();
			$this->testSport->testForInvalidEditionOfSport3();
			
            echo $this->unit->report();
            echo base_url();
        }
}
?>