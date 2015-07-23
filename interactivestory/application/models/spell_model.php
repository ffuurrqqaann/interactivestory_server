<?php
class Spell_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_interaction_spell($spell) {
		
		$data = array(
				'phrase' =>	$spell['phrase']
		);
		
		$this->db->insert('spell', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>