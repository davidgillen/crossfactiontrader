<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function maptest()
	{
		$this->load->view('maptest');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */