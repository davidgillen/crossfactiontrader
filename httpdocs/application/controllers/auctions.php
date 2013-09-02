<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auctions extends CI_Controller 
{
	var $region;
	var $slug;
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function index()
    {
    	$this->_checkSession();
    	// Get some data about the session for display purposes
    	$this->load->model('realm');
    	$data['realm'] = $this->realm->getRealm($this->region, $this->slug);
    	$this->load->view('header');
    	$data['searchTerm'] = isset($_GET['item']) ? htmlentities($_GET['item']) : '';
    	$this->load->view('itemSearch', $data);
    	$this->load->view('footer');
    }
    
    public function items()
    {
    	$this->_checkSession();
    	
    	$this->load->model('realm');
    	$data['realm'] = $this->realm->getRealm($this->region, $this->slug);
    	
    	$this->load->view('header');
    	$data['searchTerm'] = isset($_GET['item']) ? htmlentities($_GET['item']) : '';
    	$this->load->view('itemSearch', $data);
    	if( isset($_GET['item']) ) {
    		$this->load->model('item');
    		if( is_numeric($_GET['item']) ) { 
    			if ( $data['items'] = $this->item->getItem($_GET['item']) ) {
    				$this->load->view('itemDetail', $data);
    			} else {
    				$this->load->view('noResultsFound');
    			}
    		} else {
    			if ( $data['items'] = $this->item->findItems($_GET['item']) ) {
    				$this->load->view('itemDetail', $data);
    			} else {
    				$this->load->view('noResultsFound');
    			}
    		}
    	}
    	$this->load->view('footer');
    }
    
    private function _checkSession()
    {
	    $this->region = $this->session->userdata('region');
    	$this->slug = $this->session->userdata('slug');
    	
    	if( $this->region == false && $this->slug == false ) {
    		$this->load->helper('url');
    		redirect('/realms');
    	}
    }
}