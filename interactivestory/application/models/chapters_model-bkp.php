<?php
class Chapters_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_story_chapter($chapter) {
		
		$data = array(
				'number'			=>	$chapter['number'],
				'title'				=>	$chapter['title'],
				'text'				=>	$chapter['text'],
				'image_url'			=>	$chapter['image_url'],
				'video_url'			=>	$chapter['video_url'],
				'audio_url'			=>	$chapter['audio_url'],
				'interaction_id'	=>	$chapter['interaction_id']
		);
		
		$this->db->insert('chapters', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>