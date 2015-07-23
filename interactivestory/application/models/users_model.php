<?php
class Users_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function get_user($user) {
		if($user != FALSE) {
			$query = $this->db->get_where('users', array('username' => $user->username, 'password' => md5($user->password)));
			return $query->row_array();
		}
		else {
			return FALSE;
		}
	}
	
	public function create_user($user) {
		$data = array(
				'username'				=>	$user->username,
				'password'				=>	md5($user->password),
				'firstname'				=>	$user->firstname,
				'lastname'				=>	$user->lastname,
				'gcm_registration_id'	=>	$user->gcm_registration_id,
				'active'	=>	'1'
		);
		
		$this->db->insert('users', $data);
		
		return $this->db->insert_id();
		
		
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

        public function get_all_users() {
		
		$query = $this->db->query("SELECT * from users");
		
		return $query->result();
	}
}
?>