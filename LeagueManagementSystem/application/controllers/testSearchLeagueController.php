<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestSearchLeagueController extends CI_Controller 
{
        function __construct()
        {
                parent::__construct();
                $this->load->library('unit_test');
                $this->load->model('testSearchLeague','',TRUE);
        }

        public function index()
        {
                $this->testSearchLeague->testForValidLeagueId();
                $this->testSearchLeague->testForInvalidLeagueId();
                echo $this->unit->report();
                echo base_url();
        }
}
?>