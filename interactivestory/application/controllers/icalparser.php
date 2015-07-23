<?php
class Icalparser extends CI_Controller {
	
	public function parse_ical_data() {
		
		$this->load->model('notifications_model');
		
		$post_data = $this->input->post('data');
		
		$post_data = json_decode($post_data);
		
		$ical_url = $post_data->ical_url;
		
		$user_id = $post_data->user_id;
		
		$ical_str = $this->get_data_by_url($ical_url);
		
		$parsed_data = $this->parse_ical_str($ical_str);
		
		$notification_arr = array();
		$notification_arr['data'] = array();
		
		if( count($parsed_data) <= 0 ) {
			
			$notification_arr['status'] = '0';
			
			$data['notifications'] = json_encode($notification_arr);
			$this->load->view('notifications_view', $data);
			
			return;
		}
		
		$parsed_data = $parsed_data[0];
		
		$notif = $this->notifications_model->create_notifications($parsed_data, $user_id);
		
		$notification_arr['status'] = '1';
		$notification_arr['data'] = json_encode($parsed_data);
		//$data = array();
		$data['notifications'] = $notification_arr;
		
		$this->load->view('notifications_view', $data);
	}
	
	private function get_data_by_url($ical_url) {
		// Open connection
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $ical_url );
		curl_setopt( $ch, CURLOPT_POST, false );
		//curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		//curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		// Execute post
		$result = curl_exec($ch);
		// Close connection
		curl_close($ch);
		
		return $result;
	}
	
	private function parse_ical_str($str) {
		
		$str = $this->getStringBetween($str, "BEGIN:VCALENDAR", "END:VCALENDAR");
		
		$main_arr = array();
		$str = explode("END:VEVENT", $str);
		
		for($arr_count=0; $arr_count<(count($str)-1); $arr_count++) {
			$main_count = 0;
			
			$arr = explode("\r\n", $this->getStringBetween($str[$arr_count], "BEGIN:VEVENT", ""));
			
			$main_arr[$main_count][] = array_filter($arr);
			
			$main_count++;
		}
		
		return $main_arr;
	}
	
	private function getStringBetween($str,$from,$to) {
		
		$sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
		
		if($to=="")
			return substr($sub,0,strlen($str));
		else 
			return substr($sub,0,strpos($sub,$to));
	}
}