<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestSportController extends CI_Controller 
{
        function __construct()
        {
            parent::__construct();
			$this->load->library('unit_test');
            $this->load->model('tests/testSport','',TRUE);
<<<<<<< HEAD
=======
			$this->load->library('form_validation');
>>>>>>> 22a536406f443dc265634795bfe8639019747b06
        }

        public function index()
        {
<<<<<<< HEAD
            $this->testSport->testForValidAddSport();
			$this->testSport->testForInvalidAddSport1();
            $this->testSport->testForInvalidAddSport2();
			$this->testSport->testForValidEditionOfSport();
			$this->testSport->testForInvalidEditionOfSport1();
			$this->testSport->testForInvalidEditionOfSport2();
			$this->testSport->testForInvalidEditionOfSport3();
			$this->testSport->testForSuccessDisablingOfSport();
			$this->testSport->testForFailDisablingOfSport();
            echo $this->unit->report();
            echo base_url();
=======
		$this->testSport->testForValidAddSport();
		$this->testSport->testForInvalidAddSport1();
		$this->testSport->testForInvalidAddSport2();
		$this->testSport->testForValidEditionOfSport();
		$this->testSport->testForInvalidEditionOfSport1();
		$this->testSport->testForInvalidEditionOfSport2();
		$this->testSport->testForInvalidEditionOfSport3();
		$this->testSport->testForSuccessDisablingOfSport();
		$this->testSport->testForFailDisablingOfSport();
		echo $this->unit->report();
		echo base_url();
>>>>>>> 22a536406f443dc265634795bfe8639019747b06
        }
}
?>
