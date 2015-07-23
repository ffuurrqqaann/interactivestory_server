<?php
class Notifications extends CI_Controller {

	public function send_gcm_notifications_to_clients() {
		
		$this->load->model('notifications_model');
                $this->load->model('settings_model');
		
		$notifications_arr = $this->notifications_model->get_notifications_for_clients();
		
//print_r($notifications_arr);
//die;


		$user_id_arr = array();
		for ($user_id_count=0; $user_id_count<count($notifications_arr); $user_id_count++) {
			$user_id_arr[] = $notifications_arr[$user_id_count]->user_id;
		}
		
		$user_id_arr = array_unique($user_id_arr);
		
		//categorizing the array as per user id.
		$cat_array = array();
		$cat_array_count = 0;
		foreach ($user_id_arr as $key=>$val) {
			for($notif_count=0; $notif_count<count($notifications_arr); $notif_count++) {
				if( $notifications_arr[$notif_count]->user_id==$val  ) {
					$cat_array[$cat_array_count][] = $notifications_arr[$notif_count];
				}
			}
			$cat_array_count++;
		}
		
		$temp = array();
		//sending curl nortificaitons to android clients.
		for($cat_count=0; $cat_count<count($cat_array); $cat_count++) {
			$gcm_reg_id = $cat_array[$cat_count][0]->gcm_registration_id;

                        $user_id = $cat_array[$cat_count][0]->user_id;
			
			$user_lukkari_setting_arr = $this->settings_model->check_user_component_status($user_id, '1');
			
			if( $user_lukkari_setting_arr[0]['status'] == "0" )
				continue;
			
			//$temp[] = count($cat_array[$cat_count]);
			$arr_count = count($cat_array[$cat_count]);
			 $message = "";
			for($x=0; $x<$arr_count; $x++) {
				$summary = stripslashes($cat_array[$cat_count][$x]->summary);
                                $summary = str_replace(',', '', $summary);
                                
                                $message.=$summary;
                                $message.=" ";
				$message.="starting at";
				$message.=" ";
				$message.=$cat_array[$cat_count][$x]->start_date;
				$message.=" ";
				$message.="ending at";
				$message.=" ";
				$message.=$cat_array[$cat_count][$x]->end_date;
				$message.=" ";
				$message.="at";
				$message.=" ";
				$message.=$cat_array[$cat_count][$x]->location;
				$message.=",";
			}
			$temp[] = $this->initiate_curl_request($gcm_reg_id, $message);
		}
		$data['user'] = $temp;
		$this->load->view('users_view', $data);
	}
	
	private function initiate_curl_request( $registration_id, $message ) {
		
		//return $message;
		//Setting fields for notifications.
		$fields = array(
							'registration_ids' => array($registration_id),
							'data' => array( "message" => $message, "title" => $message ),
						);
		
		//Setting headers for curl request.
		$headers = array(
				'Authorization: key=' . GCM_SERVER_API_KEY,
				'Content-Type: application/json'
		);
		
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, GCM_URL );
		curl_setopt( $ch, CURLOPT_POST, false );
		
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// Execute post
		$result = curl_exec($ch);
		// Close connection
		curl_close($ch);
		
		return $result;
	}

        public function send_optima_notifications() {
		
		$temp = array();
		$this->load->model('users_model');
		$this->load->model('settings_model');
		
		$users = $this->users_model->get_all_users();
		
		for( $x=0; $x<count($users); $x++ ) {
			
			$user_optima_setting_arr = $this->settings_model->check_user_component_status($users[$x]->user_id, '3');
			if( $user_optima_setting_arr[0]['status'] == "0" )
				continue;
			
			$temp[] = $this->initiate_curl_request($users[$x]->gcm_registration_id, "ACP lecture 1 slides are uploaded");
		}
		
		$data['user'] = $temp;
		$this->load->view('users_view', $data);
		
	}
	
	public function send_weboodi_notifications() {
		$temp = array();
		$this->load->model('users_model');
		$this->load->model('settings_model');
		
		$users = $this->users_model->get_all_users();
		
		for( $x=0; $x<count($users); $x++ ) {
				
			$user_optima_setting_arr = $this->settings_model->check_user_component_status($users[$x]->user_id, '2');
			if( $user_optima_setting_arr[0]['status'] == "0" )
				continue;
				
			$temp[] = $this->initiate_curl_request($users[$x]->gcm_registration_id, "ACP course registration is today");
		}
		
		$data['user'] = $temp;
		$this->load->view('users_view', $data);
	}
        public function get_notifications_by_user_id() {
		
		$user_id = $this->input->post("user_id");
		$this->load->model('notifications_model');
		
		$user_notifications = $this->notifications_model->get_notifications_by_user_id( $user_id );
		
		$data['notifications'] = $user_notifications;
		$this->load->view('notifications_view', $data);
		
	}
}
?>