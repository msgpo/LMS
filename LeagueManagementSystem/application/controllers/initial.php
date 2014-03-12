<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Initial extends CI_Controller 
{
	function __construct()
    {
        parent::__construct();
    }
	
	public function index()
	{
		$data['title'] = "Donut Fortress League Management System";
		$data['headline'] = "Welcome.";
		$data['include'] = 'initial/initial_index';
		$data['nav'] = 'initial/initial_navigation';
		$data['masthead'] = 'initial/initial_masthead';
		$data['sidebar'] = 'initial/initial_sidebar';
		$this->load->view('template', $data);
	}
}