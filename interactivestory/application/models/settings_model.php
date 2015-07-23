<?php
class Settings_model extends CI_Model {

	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function update_user_setting($user_id, $component_id, $status) {
		$data = array( 'status'		=>	$status );
		
		$this->db->where('user_id', $user_id);
		$this->db->where('component_id', $component_id);
		
		return $this->db->update('settings', $data);
	}

        public function get_settings_by_user_id( $user_id ) {
		
		$query = $this->db->get_where('settings', array( 'user_id' => $user_id ));
		
		$data = array();
		
		if ( $query->num_rows() > 0 )
		{	
			return $query->result_array();
		} else {
			return false;
		}
		
	}

        public function insert_user_setting($user_id, $component_id, $status) {
	
		$data = array( "user_id" => $user_id, "component_id" => $component_id, "status" => $status );
	
		$this->db->insert("settings", $data);
	
		return $this->db->insert_id();
	}

        public function check_user_component_status( $user_id, $component_id ) {
		
		$query = $this->db->get_where('settings', array( 'user_id' => $user_id, 'component_id' => $component_id ));
		
		$data = array();
		
		if ( $query->num_rows() > 0 )
		{
			return $query->result_array();
		} else {
			return false;
		}	
	}
		
}
?>