<?php
class Authors_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_story_author($author, $story_id) {
		
		$data = array(
				'first_name'	=>	$author->name,
				'last_name'		=>	$author->last_name,
				'email'			=>	$author->email,
				'website'		=>	$author->website,
				'story_id'		=>	$story_id
		);
		
		$this->db->insert('authors', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>