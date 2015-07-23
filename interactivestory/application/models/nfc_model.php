<?php
class Nfc_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_interaction_nfc($nfc) {
		
		$data = array(
				'info'	=>	$nfc['info']
		);
		
		$this->db->insert('nfc', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>