<?php
class Settings extends CI_Controller {
	
	public function update_setting_by_user_id() {
		
		$this->load->model('settings_model');
		
		$setting = json_decode( $this->input->post("data") );
		
		$setting = $this->settings_model->update_user_setting( $setting->user_id, $setting->component_id, $setting->status );
		
		
		
		$user_arr 			= array();
		
		if( $setting )
			$user_arr['user']['status'] 	= '1';
		else 
			$user_arr['user']['status'] 	= '0';
		
		$this->load->view('users_view', $user_arr);
		
	}

        public function get_user_settings() {
		
		$this->load->model('settings_model');
		
		$settings_data = json_decode( $this->input->post("data") );
		
		$settings = $this->settings_model->get_settings_by_user_id( $settings_data->user_id );
		
		$user_arr 			= array();
		
		if( $settings ) {
			$user_arr['user'] 		= $settings;
		} else {
			$user_arr['user'] 		= array();
		}
		
		$this->load->view('users_view', $user_arr);
	}
	
}