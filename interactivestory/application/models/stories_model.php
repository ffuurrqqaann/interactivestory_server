<?php
class Stories_model extends CI_Model {
	public function __construct() {
		$this->load->database ();
	}
	public function create_story() {
		$data = array (
				'story_title' => 'test title',
				'story_summary' => 'test summary' 
		);
		
		$this->db->insert ( 'stories', $data );
		
		return $this->db->insert_id ();
	}
	public function add_story($story) {
		$data = array (
				'story_title' 	=> $story['story_title'],
				'story_summary' 	=> $story['story_summary'] 
		);
		
		$this->db->where ( 'story_id', $story['story_id'] );
		return $this->db->update ( 'stories', $data );
	}
	
	public function get_stories() {
		
		$stories = array();
		
		$query = $this->db->get('stories');
		$count = 0;
		foreach ($query->result() as $row) {
			$stories[$count]['story_id'] 		= $row->story_id;
			$stories[$count]['story_title'] 	= $row->story_title;
			$stories[$count]['story_summary'] 	= $row->story_summary;
			
			$count++;
		}
		
		return $stories;
	}
	
}
?>