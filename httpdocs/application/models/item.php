<?php
class Item extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function getItem($itemId)
    {
    	if(strlen($itemId)==0 ) {
    		return false;
    	}
    	$tablename = $this->session->userdata('region')
    		. '_' . $this->session->userdata('slug');
    	$query = $this->db->query("SELECT * FROM item LEFT JOIN `$tablename` ON itemId = id WHERE itemId = $itemId");
    	if( $result = $query->result() ) {
    		return $this->_tidyPrices($result);
    	} else {
    		return false;
    	}
    }
    
    function findItems($str)
    {
    	if(strlen($str)==0 ) {
    		return false;
    	}
    	$str = mysql_real_escape_string(trim($str));
    	$tablename = $this->session->userdata('region')
    		. '_' . $this->session->userdata('slug');
    	$query = $this->db->query("SELECT * FROM item LEFT JOIN `$tablename` ON itemId = id WHERE name LIKE '%$str%'");
    	if ( $result = $query->result() ) {
    		return $this->_tidyPrices($result);
    	} else {
    		return false;
    	}
    }
    
    private function _tidyPrices($items)
    {
    	$tidyItems = array();
    	foreach($items as $item) {
    		$item->tidyAllianceAvg = $this->_tidyPrice($item->allianceAvg);
    		$item->tidyHordeAvg = $this->_tidyPrice($item->hordeAvg);
    		$tidyItems[] = $item;
    	}
    	return $tidyItems;
    }
    
    private function _tidyPrice($str)
    {
    	$str = str_pad($str, '0', 5, STR_PAD_LEFT);
    	$copper = substr($str, -2, 2);
    	$silver = substr($str, -4, 2);
    	$gold = substr($str, 0, strlen($str) -4);
    	
    	$output = '';
    	if ( $gold > 0 ) {
    		$output .= $gold . 'g ';
    	}
    	if ( $silver > 0 ) {
    		$output .= (int)$silver . 's ';
    	}
    	if ( $copper > 0 ) {
    		$output .= (int)$copper . 'c';
    	}
    	if ( strlen($output) == 0 ) {
    		$output = '-';
    	}
    	return $output;
    }
}