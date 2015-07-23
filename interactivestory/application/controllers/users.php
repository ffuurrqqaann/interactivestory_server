<?php
class Users extends CI_Controller {

	public function login() {
		$this->load->model('users_model');
		
		$user = json_decode($this->input->post("data"));
		$user = $this->users_model->get_user($user);
		
		$user_arr = array();
		
		if(count($user) > 0) {
			$user_arr['data'] 		= $user;
			$user_arr['is_auth']	= '1';
			
			$data['user']	 	= $user_arr;
		} else {
			$user_arr['data'] 		= "";
			$user_arr['is_auth'] 	= '0';
			$data['user'] = $user_arr;
		}
		$this->load->view('users_view', $data);
	}
	
	//'0' user not created '1' user created successfully '2' user already exist
	public function signup() {
		
		$this->load->model('users_model');
		
		$user = json_decode($this->input->post("data"));
		
		$exist = $this->users_model->check_user_exist($user->username);
		
		$user_arr 			= array();
		$user_arr['data'] 	= array();
		$data 				= array();
		
		if($exist) {	
			$user_arr['status'] = '2';
			$data['user'] = $user_arr;
			
			$this->load->view('users_view', $data);
			return;
		}
		
		$user = $this->users_model->create_user($user);
		
		if($user) {
			$user_arr['status'] = '1';
			$user_arr['data'] = $user;
			$data['user'] = $user_arr;
                        $this->setup_user_components_settings($user);
		} else {
			$user_arr['status'] = '0';
			$data['user'] = $user_arr;
		}
		
		$this->load->view('users_view', $data);
	}
	
	public function get_gcm_registration_id_by_username() {
		
		$user = json_decode($this->input->post("data"));
		
		$this->load->model('users_model');
		$reg_id = $this->users_model->get_gcm_registration_id($user->username);
		
		$user_arr 			= array();
		$user_arr['data'] 	= array();
		$data 				= array();
		
		if($reg_id) {
			$user_arr['data']['gcm_registration_id'] = $reg_id['gcm_registration_id'];
			$user_arr['status'] = '1';
			
			$data['user'] = $user_arr;
		} else {
			$user_arr['status'] = '0';
			$data['user'] = $user_arr; 
		}
		$this->load->view('users_view', $data);
	}

        public function setup_user_components_settings($user_id) {
		
		$setting_ids = array();
		
		$this->load->model('settings_model');
		
		$components = array( "1", "2", "3" );
	
		for( $x=0; $x<count($components); $x++ ) {
			$setting_ids[] = $this->settings_model->insert_user_setting( $user_id, $components[$x], "1" );
		}
		
		return $setting_ids;
	}
}
?>