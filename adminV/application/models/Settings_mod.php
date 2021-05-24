<?php
class Settings_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	// Start - add_update_settings(): Add update Settingts
	public function add_update_settings($post){
		
		extract($post);
		if($action == 'update'){ // Update settings
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
			$data = array(
			'setting_value' => $this->db->escape_str(trim($setting_value)),
			'setting_description' => $this->db->escape_str(trim($setting_description)),
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			
			$this->db->dbprefix('global_settings');
			$this->db->where('id', $settings_id);
			return $this->db->update('global_settings', $data);
			
		} else if($action == 'add'){ // Insert settings
			$created_date = date('Y-m-d H:i:s');
			$created_by_ip = $this->input->ip_address();
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
		    $data = array(
			'setting_name' => $this->db->escape_str(trim($setting_name)),
			'setting_value' => $this->db->escape_str(trim($setting_value)),
			'setting_description' => $this->db->escape_str(trim($setting_description)), 
			'created_date' => $created_date,
			'created_by_ip' => $created_by_ip,
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			return $this->db->insert('global_settings', $data);
			// print_r($this->db->last_query()); exit;
		}
		
	} // End - add_update_settings():
	
	// Start - get_settings($settings_id): Get Setting detail by id
	public function get_settings($settings_id){
		
		$this->db->dbprefix('global_settings');
		$this->db->where('id', $settings_id);
		return $this->db->get('global_settings')->row_array();
		
	} // End - get_settings($settings_id):
	
	// Start - get_all_settings(): Get all Settings for listing
	public function get_all_settings(){
		
		$this->db->dbprefix('global_settings');
		$this->db->from('global_settings');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
	    //print_r($this->db->last_query()); exit;
		
	} // End - get_all_settings():
	
	//Start get_setting_name check name exists
	public function get_setting_name($setting_name){
			
			$this->db->dbprefix('global_settings');
			$this->db->where('setting_name', $setting_name);
			$row = $this->db->get('global_settings')->row_array();
			if(!empty($row)){ 
				return TRUE; 
			} else { 
				return FALSE; 
			}
			
		} // end get_setting_name	
	
	/////////////////////////////////
	// Start User Type Settings Section
	
	// Start - get_all_user_type_dashboar_videos():
	public function get_all_user_type_dashboar_videos(){
		
		$this->db->dbprefix('usertype');
		$this->db->order_by('id', 'DESC');
		return $this->db->get('usertype')->result_array();
		
	}
	// End - get_all_user_type_dashboar_videos():
	
	// Start - update_dashboard_videos($post): update dashboard videos
	public function update_dashboard_videos($post){
		
		// Extract Post Data
		extract($post);
		
		// Update data for all user types
		// Update each user type
		for($i=1; $i<=sizeof($dashboard_video_title); $i++){
			
			$update = array('dashboard_video_title' => $dashboard_video_title[$i], 'dashboard_video_url' => $dashboard_video_url[$i], 'dashboard_video_id' => $dashboard_video_id[$i], 'status' => $status[$i]);
			
			$this->db->dbprefix('usertype');
			$this->db->where('id', $user_type_id[$i-1]);
			$success = $this->db->update('usertype', $update);
		}
		if($success)
			return true;
		else
			return false;
		
	} // End - update_dashboard_videos($post):
	
	// Start Function edit_admin_profile
	public function edit_admin_profile($admin_id){ 
	
	    $this->db->dbprefix('admin');
		$this->db->select('id AS admin_id,first_name AS admin_first_name, last_name AS admin_last_name , CONCAT(first_name," ",last_name) AS admin_full_name, email_address as admin_email_address');
		$this->db->where('id', $admin_id);
		$this->db->where('status',1);
		return $row = $this->db->get('admin')->row_array();
		
		// print_r($this->db->last_query()); exit;
		
	} // end  edit_admin_profile
	
	// Start Function update_profile_admin
	public function update_profile_admin($admin_id,$post){ 
	
		extract($post);
		
		$data = array(
			'first_name' => $this->db->escape_str(trim($first_name)),
			'last_name' => $this->db->escape_str(trim($last_name)),
			'email_address' => $this->db->escape_str(trim($email_address))
			);
			
			$this->db->dbprefix('admin');
			$this->db->where('id', $admin_id);
			return $this->db->update('admin', $data);
			//print_r($this->db->last_query()); exit;
		
		// print_r($this->db->last_query()); exit;
		
	} // end  update_profile_admin
	
	// Get all notifications
	public function get_all_notifications(){ 
	   
	    $this->db->dbprefix('admin_notifications');
		$this->db->from('admin_notifications');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
	
	}// end get_all_notifications
	
	public function upload_media($data){
		
		extract($data);
		
		if($_FILES['upload_media']['name'] != ''){

			$media_location  = '.././assets/media/';

			$extension = pathinfo($_FILES['upload_media']['name'], PATHINFO_EXTENSION);
			
			$file_name = $_FILES['upload_media']['name'];
			$destination_path = $media_location.$file_name;
			
			$upload = @copy($_FILES['upload_media']['tmp_name'],$destination_path);
			
			if($upload)
				return true;
			else
				return false;
			
			//$upd_data['site_logo'] =  $this->db->escape_str($logo_file_name);
			
		}else{
			return false;	
		}//end if($_FILES['upload_media']['name'] != '')
		
	}//end upload_media($data)
	
}//end file
?>