<?php
class Quiz_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function add_interaction_quiz($quiz) {
		
		$data = array(
				'question'			=>	$quiz['question'],
				'correct_answer'	=>	$quiz['correct_answer'],
				'answer_1'			=>	$quiz['answer_1'],
				'answer_2'			=>	$quiz['answer_2'],
				'answer_3'			=>	$quiz['answer_3']
		);
		
		$this->db->insert('quiz', $data);
		
		return $this->db->insert_id();
		
	}
	
}
?>