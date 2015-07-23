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
				'interaction_id'	=>	$chapter['interaction_id'],
				'story_id'			=>	$chapter['story_id'],
		);
		
		$this->db->insert('chapters', $data);
		
		return $this->db->insert_id();
		
	}
	
	public function get_chapter_by_story_id($story_id) {
		
		
		$this->db->select('*');
		$this->db->from('chapters');
		$this->db->join('interactions', 'chapters.interaction_id = interactions.interaction_id', 'left');
		$this->db->join('gps', 'gps.gps_id = interactions.gps_id', 'left');
		$this->db->join('nfc', 'nfc.nfc_id = interactions.nfc_id', 'left');
		$this->db->join('qr', 'qr.qr_id = interactions.qr_id', 'left');
		$this->db->join('quiz', 'quiz.quiz_id = interactions.quiz_id', 'left');
		$this->db->join('spell', 'spell.spell_id = interactions.spell_id', 'left');
		
		$this->db->where('chapters.story_id', $story_id);
		
		$query = $this->db->get();
		
		$chapters = array();
		$count = 0;
		
		foreach ($query->result() as $row)
		{
			$chapters[$count] = $row;
			$count++;
		}
		
		return $chapters;
	}
	
}
?>