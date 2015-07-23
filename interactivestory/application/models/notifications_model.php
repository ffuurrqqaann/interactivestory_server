<?php
class Notifications_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function get_user($user) {
		if($user != FALSE) {
			$query = $this->db->get_where('users', array('username' => $user['username'], 'password' => md5($user['password'])));
			return $query->row_array();
		}
		else {
			return FALSE;
		}
	}
	
	public function create_notifications($notifications, $user_id) {
		
		$final_arr = array();
		
		for($notif_count=0; $notif_count<count($notifications); $notif_count++) {
			$notification = $notifications[$notif_count];
			
			$date_stamp 	= explode(":", $notification[1]);
			
			$start_date 	= explode(":", $notification[2]);
			$start_date		= $this->format_date($start_date[count($start_date) - 1]);
			
			$end_date 		= explode(":", $notification[3]);
			$end_date		= $this->format_date($end_date[count($end_date) - 1]);
			
			$summary 		= explode(":", $notification[4]);
			$location 		= explode(":", $notification[8]);
			$description 	= explode(":", $notification[9]);
			
			$final_arr[] = array(
									'fk_user_id'				=>	$user_id,
									'date_stamp'				=>	$date_stamp[count($date_stamp)-1],
									'start_date'				=>	$start_date,
									'end_date'					=>	$end_date,
									'summary'					=>	$summary[count($summary)-1],
									'location'					=>	$location[count($location)-1],
									'description'				=>	$description[count($description)-1],
								);
		}
		
		return $this->db->insert_batch('notifications', $final_arr);
	}
	
	public function check_user_exist($username) {
		$query = $this->db->get_where('users', array( 'username' => $username ));
		
		if(count($query->row_array()) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_gcm_registration_id($username) {
		
		$query = $this->db->get_where('users', array( 'username' => $username ));
		
		$data = array();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data['gcm_registration_id'] = $row['gcm_registration_id'];
			}
			
			return $data;
		} else {
			return false;
		}
	}
	
	private function format_date($date) {
		$seconds = strtotime($date);
		return date('Y-m-d H:i:s', $seconds);
	}
	
	public function get_notifications_for_clients() {
		
		$query = $this->db->query(
									"SELECT ntfs.notification_id, usr.user_id, usr.gcm_registration_id, ntfs.start_date, ntfs.end_date, ntfs.summary, ntfs.location, ntfs.description
									FROM notifications AS ntfs
									LEFT JOIN users AS usr ON ntfs.fk_user_id = usr.user_id
									WHERE DATEDIFF(ntfs.start_date, NOW()) = 0
									");
		
		return $query->result();
		
	}

        public function get_notifications_by_user_id( $user_id ) {
		$query = $this->db->query(
				"SELECT *
						FROM notifications AS ntfs
						WHERE fk_user_id=".$user_id);
		
		return $query->result();
	}
	
}
?>