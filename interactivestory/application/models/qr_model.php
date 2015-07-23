<?php
class Qr_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_interaction_qr($qr) {
		
		$data = array(
				'info'	=>	$qr['info']
		);
		
		$this->db->insert('qr', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>