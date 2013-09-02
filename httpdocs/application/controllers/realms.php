<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Realms extends CI_Controller {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function index()
	{
		$this->load->view('header');
		$this->load->view('region_select');
		$this->load->view('footer');
	}

	public function eu()
	{
		$this->_regionRequest('eu');
	}
	
	public function us()
	{
		$this->_regionRequest('us');
	}
	
	private function _regionRequest($region)
	{
		if( $this->uri->segment(3) != false ) {
			$this->_realmSelect($region, $this->uri->segment(3) );
		} else {
			$this->_realmList($region);
		}
	}
	
	private function _realmList($region)
	{
		$data['region'] = $region;
		$this->load->model('realm');
		$data['realms'] = $this->realm->getRealmList($region);
		$this->load->view('header');
		$this->load->view('realmList', $data);
		$this->load->view('footer');
	}
	
	private function _realmSelect($region, $slug)
	{
		$this->session->set_userdata('region', $region);
		$this->session->set_userdata('slug', $slug);
		$this->load->helper('url');
		redirect('/auctions');
	}
}
