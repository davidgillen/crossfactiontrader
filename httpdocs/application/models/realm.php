<?php
class Realm extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function getRealmList($region)
    {
		$query = $this->db->get_where('realm', array('region'=>$region));
		return $query->result();
	}
	
	function getRealm($region, $slug)
	{
		$where = array(
			'region'=>$region,
			'slug'=>$slug,
		);
		$query = $this->db->get_where('realm', $where);
		$rows = $query->result();
		return $rows[0];
	}
    
    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry()
    {
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}
