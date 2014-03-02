<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestLeagueController extends CI_Controller 
{
		 function __construct()
        {
            parent::__construct();
			$this->load->library('unit_test');
            $this->load->model('tests/testLeague','',TRUE);
        }

        public function index()
        {
            $this->testLeague->testForValidLeagueCreation();
			$this->testLeague->testForInvalidLeagueCreation1();
			$this->testLeague->testForInvalidLeagueCreation2();
			$this->testLeague->testForInvalidLeagueCreation3();
			$this->testLeague->testForInvalidLeagueCreation4();
			$this->testLeague->testForInvalidLeagueCreation5();
			$this->testLeague->testForValidLeagueEdition();
			$this->testLeague->testForInvalidLeagueEdition1();
			$this->testLeague->testForInvalidLeagueEdition2();
			$this->testLeague->testForInvalidLeagueEdition3();
			$this->testLeague->testForInvalidLeagueEdition4();
			$this->testLeague->testForInvalidLeagueEdition5();
			$this->testLeague->testForInvalidLeagueEdition6();
			$this->testLeague->testForValidDeactivatingLeague();
			$this->testLeague->testForInvalidDeactivatingLeague();
			echo $this->unit->report();
            echo base_url();
        }
}
?>