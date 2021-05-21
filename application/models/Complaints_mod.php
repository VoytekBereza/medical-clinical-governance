<?php
class Complaints_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function email_complaints_form(): 
	public function email_complaints_form($data,$user_id,$address){
		
		extract($data);
		
		
		$created_date = date('Y-m-d');
		//$created_date = kod_date_format(date('Y-m-d'));
		
		//Function get_user_details(): Fetch the user details from user table using User_id
	
		$this->db->dbprefix('users');
		
	    $this->db->select('users.*,CONCAT(first_name," ",last_name) AS user_full_name, usertype.user_type AS user_type_name');

		$this->db->where('users.id',$user_id);
		$this->db->join('usertype','users.user_type = usertype.id','LEFT');
		$get_user= $this->db->get('users');
		$row_arr = $get_user->row_array();
	
		// EMAIL SENDING CODE - START		
			
		$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
		$noreply_email = get_global_settings($NOREPLY_EMAIL);
		
		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
		$from = $row_arr['email_address'];
		$from_name = filter_string($email_from_txt['setting_value']);
		$to = trim($email_address);
		$subject = 'Complaints Form';
		$message_body = str_replace('<br />','',$message_body);
		
		$email_body = nl2br(filter_string($message_body)); 
					
		// Call from Helper send_email function
		$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
		
		if($row_arr)
			return $row_arr;
		else
			return false;
		
	
		
	}//end add_new_user
	
	public function complaints_add_edit_form($data){
	    
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$eventdate = str_replace('/','-',$event_date);
		$event_date = date('Y-m-d', strtotime($eventdate));
		
		$ins_data = array(
		
				'name' => $this->db->escape_str(trim($name)),
				'resolve_by' => $this->db->escape_str(trim($user_id)),
				'event_date' => $this->db->escape_str(trim($event_date)),
				'description' => $this->db->escape_str(trim($description)),
				'recevied_date' => $this->db->escape_str(trim($created_date)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);

			//Inserting Patient data into the database. 
			$this->db->dbprefix('complaints_form');
			$ins_into_db = $this->db->insert('complaints_form', $ins_data);
			
			$new_insert_id = $this->db->insert_id();
			
			if($ins_into_db)
				return true;
		    else
				return false;
			
		}// end complaints_add_edit_form();
		
		
		//Function: get_complaint_list():
	public function get_complaint_list($user_id){
		
		// Get Clinical Diary Record
		$this->db->dbprefix('complaints_form');
		$this->db->select('complaints_form.*,users.first_name,users.last_name');
		$this->db->join('users','users.id = complaints_form.resolve_by','LEFT');
	    $this->db->where('resolve_by',$user_id);
		$this->db->order_by('complaints_form.id', 'Desc');
		$get = $this->db->get('complaints_form');
		//echo $this->db->last_query(); exit;
	 	return $get->result_array();
		//echo $this->db->last_query(); exit;
		
	} // End public function get_complaint_list()
	
	
	
    public function get_complaints_details ($id,$user_id){
			// Get Clinical Diary Record
		$this->db->dbprefix('complaints_form');
		$this->db->select('complaints_form.*');
		$this->db->where('id',$id);
		$this->db->where('resolve_by',$user_id);
		$get = $this->db->get('complaints_form');
	 	return $get->row_array();
		//echo $this->db->last_query(); exit;
	}
		
	public function add_complaints($data, $user_id){
	    
		extract($data);
	
			if($acknowledge !=""){
				$ins_data['acknowledge'] = $this->db->escape_str(trim($acknowledge));
				$ins_data['resolve_by'] = $this->db->escape_str(trim($user_id));
			}
			if($investigate !=""){
				$ins_data['investigate'] = $this->db->escape_str(trim($investigate));
				$ins_data['resolve_by'] = $this->db->escape_str(trim($user_id));
			}
			if($outcome !=""){
				$ins_data['outcome'] = $this->db->escape_str(trim($outcome));
				$ins_data['resolve_by'] = $this->db->escape_str(trim($user_id));
			}
			//Inserting Patient data into the database. 
			
			$this->db->dbprefix('complaints_form');
			$this->db->where('id',$complaint_id);
			$upd_into_db = $this->db->update('complaints_form', $ins_data);
			
			//echo $this->db->last_query(); exit;
			
			if($upd_into_db)
				return true;
		    else
				return false;
			
		}// end complaints_add_edit_form();
		
		
		public function resolve_complaints($data, $user_id){
	    
		extract($data);
		
		$ins_data['status'] = 1;
		$ins_data['resolve_by'] = $user_id;
		$ins_data['reslove_date'] =  date('Y-m-d');
		
		$this->db->dbprefix('complaints_form');
		$this->db->where('id',$complaint_id);
		$upd_into_db = $this->db->update('complaints_form', $ins_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
			
		}// end complaints_add_edit_form();
		
		
	
}//end file
?>