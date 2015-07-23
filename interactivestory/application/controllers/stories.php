<?php
class Stories extends CI_Controller {
	public function create_new_story() {
		$this->load->model ( 'stories_model' );
		
		$data = array ();
		$story = $this->stories_model->create_story ();
		
		$story_arr = array ();
		
		if (count ( $story ) > 0) {
			$story_arr ['data'] = $story;
			
			$data ['story'] = $story_arr;
		} else {
			$story_arr ['data'] = "";
			
			$data ['story'] = $story_arr;
		}
		$this->load->view ( 'stories_view', $data );
	}
	public function add_new_story() {
		$this->load->model ( 'stories_model' );
		$this->load->model ( 'authors_model' );
		$this->load->model ( 'chapters_model' );
		$this->load->model ( 'interactions_model' );
		
		$data = json_decode ( $_POST ['data'] );
		
		// print_r( $data->chapters[0]->interaction->type );
		
		// die;
		
		// inserting author for story
		$author_id = $this->authors_model->add_story_author ( $data->author, $data->story_id );
		
		// inserting story form the json.
		$story_arr = array (
				'story_id' => $data->story_id,
				'story_title' => $data->title,
				'story_summary' => $data->summary 
		);
		$story = $this->stories_model->add_story ( $story_arr );
		
		$gps_id = "";
		$nfc_id = "";
		$qr_id = "";
		$quiz_id = "";
		$spell_id = "";
		
		//var_dump ( $data->chapters [0]->interaction );
		//die ();
		
		for($x = 0; $x < count ( $data->chapters ); $x ++) {
			
			$interaction_id = "";
			
			if ($data->chapters[$x]->interaction != null) {
				
				// inserting interactions.
				if ($data->chapters [$x]->interaction->type == '1') { // inserting gps data.
					$this->load->model ( 'gps_model' );
					
					$gps = array ();
					$gps ['latitude'] = $data->chapters [$x]->interaction->latitude;
					$gps ['longitude'] = $data->chapters [$x]->interaction->longitude;
					
					$gps_id = $this->gps_model->add_interaction_gps ( $gps );
				} elseif ($data->chapters [$x]->interaction->type == '2') { // inserting nfc data.
					$this->load->model ( 'nfc_model' );
					
					$nfc = array ();
					$nfc ['info'] = $data->chapters [$x]->interaction->secret_code;
					$nfc_id = $this->nfc_model->add_interaction_nfc ( $nfc );
				} elseif ($data->chapters [$x]->interaction->type == '3') { // inserting qr data.
					$this->load->model ( 'qr_model' );
					
					$qr = array ();
					$qr ['info'] = $data->chapters [$x]->interaction->secret_code;
					$qr_id = $this->qr_model->add_interaction_qr ( $qr );
				} elseif ($data->chapters [$x]->interaction->type == '4') { // inserting quiz data.
					$this->load->model ( 'quiz_model' );
					
					$quiz = array ();
					$quiz ['question'] = $data->chapters [$x]->interaction->question;
					$quiz ['correct_answer'] = $data->chapters [$x]->interaction->correct_answer;
					$quiz ['answer_1'] = $data->chapters [$x]->interaction->answer_1;
					$quiz ['answer_2'] = $data->chapters [$x]->interaction->answer_2;
					$quiz ['answer_3'] = $data->chapters [$x]->interaction->answer_3;
					$quiz ['answer_4'] = $data->chapters [$x]->interaction->answer_4;
					
					$quiz_id = $this->quiz_model->add_interaction_quiz ( $quiz );
				} elseif ($data->chapters [$x]->interaction->type == '5') { // inserting spell check data.
					$this->load->model ( 'spell_model' );
					
					$spell = array ();
					$spell ['phrase'] = $data->chapters [$x]->interaction->word;
					$spell_id = $this->spell_model->add_interaction_spell ( $spell );
				}
				
				// add interaction for story.
				$interaction = array ();
				$interaction ['interaction_type'] = $data->chapters [$x]->interaction->type;
				$interaction ['nfc_id'] = $nfc_id;
				$interaction ['qr_id'] = $qr_id;
				$interaction ['gps_id'] = $gps_id;
				$interaction ['spell_id'] = $spell_id;
				$interaction ['quiz_id'] = $quiz_id;
				$interaction ['positive_feedback'] = $data->chapters [$x]->interaction->positive_feedback;
				$interaction ['negative_feedback'] = $data->chapters [$x]->interaction->negative_feedback;
				$interaction ['positive_audio_url'] = $data->chapters [$x]->interaction->positive_audio_url;
				$interaction ['negative_audio_url'] = $data->chapters [$x]->interaction->negative_audio_url;
				$interaction ['instructions'] = $data->chapters [$x]->interaction->instructions;
				
				$interaction_id = $this->interactions_model->add_chapter_interaction ( $interaction );
			}
			
			$chapter = array ();
			
			$chapter ['number'] = $data->chapters [$x]->number;
			$chapter ['title'] = $data->chapters [$x]->title;
			$chapter ['text'] = $data->chapters [$x]->text;
			$chapter ['image_url'] = $data->chapters [$x]->image_url;
			$chapter ['video_url'] = $data->chapters [$x]->video_url;
			$chapter ['audio_url'] = $data->chapters [$x]->audio_url;
			$chapter ['interaction_id'] = $interaction_id;
			$chapter ['story_id'] = $data->story_id;
			
			$chapter_id = $this->chapters_model->add_story_chapter ( $chapter );
		}
		
		echo 'Story successfully created';
	}
	public function get_all_stories() {
		$stories = array ();
		// $chapters = array();
		$interactions = array ();
		
		$this->load->model ( 'stories_model' );
		$this->load->model ( 'authors_model' );
		$this->load->model ( 'chapters_model' );
		$this->load->model ( 'interactions_model' );
		
		// get all stories.
		$stories = $this->stories_model->get_stories ();
		
		for($story_count = 0; $story_count < count ( $stories ); $story_count ++) {
			
			$story_id = $stories [$story_count] ['story_id'];
			
			// get all stories's authors.
			$authors = $this->authors_model->get_author_by_story_id ( $story_id );
			$stories [$story_count] ['authors'] = $authors;
			
			// get all stories's chapters
			$chapters = $this->chapters_model->get_chapter_by_story_id ( $story_id );
			$stories [$story_count] ['chapters'] = $chapters;
		}
		
		echo json_encode ( $stories );
	}
}
?>