<?php
class Interactions_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_chapter_interaction($interaction) {
		
		$data = array(
				'interaction_type'		=>	$interaction['interaction_type'],
				'nfc_id'				=>	$interaction['nfc_id'],
				'qr_id'					=>	$interaction['qr_id'],
				'gps_id'				=>	$interaction['gps_id'],
				'spell_id'				=>	$interaction['spell_id'],
				'quiz_id'				=>	$interaction['quiz_id'],
				'positive_feedback'		=>	$interaction['positive_feedback'],
				'negative_feedback'		=>	$interaction['negative_feedback'],
				'positive_audio_url'	=>	$interaction['positive_audio_url'],
				'negative_audio_url'	=>	$interaction['negative_audio_url'],
				'instructions'			=>	$interaction['instructions']
		);
		
		$this->db->insert('interactions', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>