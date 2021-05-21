<?php
class Login_mod extends CI_Model {
	
	function __construct(){
		parent::__construct();
    }

	// Validate user credrntials if match in the DB to login
	public function validate_credentials($email_address,$password,$admin_login){

		$this->db->dbprefix('users');
		$this->db->select('users.id,users.user_type, users.first_name, users.last_name, CONCAT(first_name," ",last_name) AS full_name, users.email_address, users.registration_no, users.is_owner, users.system_prescriber,  users.no_of_logins , users.registration_type, users.is_prescriber, users.is_intro_video_watched, usertype.user_type AS user_role, usertype.dashboard_video_title, usertype.dashboard_video_url, usertype.dashboard_video_id');
		
		$this->db->where('users.email_address', strip_quotes($email_address));
		
		if($admin_login)
			$this->db->where('users.password', strip_quotes($password)); //If the request is coming from the admin side to auto login
		else
			$this->db->where('users.password', md5(strip_quotes($password)));
			
		$this->db->where('users.email_verify_status',1);
		$this->db->where('users.admin_verify_status',1);
		$this->db->join('usertype','users.user_type = usertype.id');
		
		$get = $this->db->get('users');
		//echo $this->db->last_query(); 		exit;
		$user_data_arr = $get->row_array();
		
		if($get->num_rows() > 0){
			
			$last_loggedin_date = date('Y-m-d G:i:s');
			//Update Logging			
			$update_log_query = "UPDATE `kod_users` SET `no_of_logins` = no_of_logins+1, `last_loggedin_date` = '".$last_loggedin_date."' WHERE `id` = '".$user_data_arr['id']."'";
			
			$upd_into_db = $this->db->query($update_log_query);

			//If user is the owner of the company, grab the organization details too
			$organization_arr = array();
			
			if($user_data_arr['is_owner'] == 1){
				
				$this->db->dbprefix('organization');
				$this->db->select('organization.*,users.id AS superintendent_user_id,users.user_type AS si_user_type, users.first_name AS si_first_name, users.last_name AS si_last_name, CONCAT(first_name," ",last_name) AS superintendent_full_name, users.email_address as si_email_address, users.registration_no si_registration,  users.registration_type AS si_registration_type, users.is_prescriber AS si_is_prescriber');
				$this->db->where('organization.owner_id',$user_data_arr['id']);
				
				$this->db->join('users','users.id = organization.superintendent_id','LEFT');
				$get = $this->db->get('organization');
				//echo $this->db->last_query(); 		exit;
				
				$user_data_arr['organization'] = $get->row_array();
				
			}//end if($user_data_arr['is_owner'] == 1)

		}//end if($get->num_rows() > 0)
		
		return $user_data_arr;
		
	}//end validate_credentials($email_address,$password)
	
	//Function verify_email_account($data): Function will verify the email and mark as verified  
	public function verify_email_account($data){
		
		extract($data);
		
		$this->db->dbprefix('users');
		$this->db->where('activation_code',$code);
		$this->db->where('id',$uid);
		$get = $this->db->get('users');
		
		if($get->num_rows() > 0){
			
			//Is a verified Email user

			$upd_data['email_verify_status'] = $this->db->escape_str(trim(1));
	
			//Update the record into the database.
			$this->db->dbprefix('users');
			$this->db->where('id',$uid);
			$upd_into_db = $this->db->update('users', $upd_data);
			
			return true;
		}else{
			return false;	
		}//end if($get->num_rows() > 0)
		
	}//end verify_email_account($data)

	//Function send_new_password(): Send New password to the user on forgot password
	public function send_new_password($user_arr){
		
		//User data
		$user_first_last_name = ucwords(strtolower(stripslashes($user_arr['first_name'].' '.$user_arr['last_name'])));
		//$new_password_txt = $this->common->random_number_generator(6);
		$random_number = $this->common->random_number_generator(6);
		$email_address = stripslashes(trim($user_arr['email_address']));
		$reset_code = urlencode(base64_encode($random_number.'|'.$user_arr['id']));
		
		//Updating New Password into the database

		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();

		$upd_data = array(
		   'password_reset_request' => $this->db->escape_str(trim(1)),
		   'password_request_date' => $this->db->escape_str(trim($last_modified_date)),
		   'password_reset_code' => $this->db->escape_str(trim($reset_code)),
		   'modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'modified_by_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('users');
		$this->db->where('id',$user_arr['id']);
		$upd_into_db = $this->db->update('users', $upd_data);
		
		if($upd_into_db){
			
		// EMAIL SENDING CODE - START
		
			$new_password_link = SURL.'login/reset-password/'.$reset_code;

			$search_arr = array('[FIRST_LAST_NAME]','[NEW_PASSWORD_LINK]','[SITE_LOGO]','[SITE_URL]');
			$replace_arr = array($user_first_last_name,$new_password_link,SITE_LOGO,SURL); 


			$this->load->model('email_mod','email_template');
			
			$email_body_arr = $this->email_template->get_email_template(2);
			
			$email_subject = $email_body_arr['email_subject'];

			$email_body = $email_body_arr['email_body'];
			$email_body = str_replace($search_arr,$replace_arr,$email_body);
			
			$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
			$noreply_email = get_global_settings($NOREPLY_EMAIL);
			
			$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
			$email_from_txt = get_global_settings($EMAIL_FROM_TXT);

			$from = filter_string($noreply_email['setting_value']);
			$from_name = filter_string($email_from_txt['setting_value']);
			$to = trim($email_address);
			$subject = filter_string($email_subject);
			$email_body = filter_string($email_body);
					
			// Call from Helper send_email function
			$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
			
			return true;

		}else{
			return false;	
		}//end if($upd_into_db)
		
	}//end function send_new_password	

	public function verify_reset_code($verification_code){
		
		$this->db->dbprefix('users');
		$this->db->where('password_reset_code',$verification_code);
		$this->db->where('password_reset_request','1');
		$get_user= $this->db->get('users');
		$row_arr = $get_user->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	}//end verify_reset_code($verification_code)

	public function reset_password($user_id, $data){
		
		extract($data);

		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();

		$upd_data = array(
		   'password_reset_request' => $this->db->escape_str(trim(0)),
		   'password_request_date' => NULL,
		   'password_reset_code' => NULL,
		   'password' => md5($new_password),
		   'modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'modified_by_ip' => $this->db->escape_str(trim($last_modified_ip))
		);
		
		//Update the record into the database.
		$this->db->dbprefix('users');
		$this->db->where('id',$user_id);
		$upd_into_db = $this->db->update('users', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end reset_password($pharmacy_pin, $pharmacy_id)
	
	//Function verify_is_user_login(): Verify If User is Login on the authorized Pages.
	public function verify_is_user_login(){
		
		if(!$this->session->userdata('id')){
			
			$this->session->set_flashdata('err_message', 'You have to login to access this page.');
			redirect(base_url().'login');
			exit;
			
		}//if(!$this->session->userdata('id'))
		
	}//end verify_is_user_login()
	

}//end file
?>