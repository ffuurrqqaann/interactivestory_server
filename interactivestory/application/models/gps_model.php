<?php
class Gps_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_interaction_gps($gps) {
		
		$data = array(
				'latitude'	=>	$gps['latitude'],
				'latitude'	=>	$gps['longitude']
		);
		
		$this->db->insert('gps', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>