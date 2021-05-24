<?php
class Login_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Validate user credrnetials if match in the DB to login
	public function validate_credentials($email_address,$password){
		
		$this->db->dbprefix('admin');
		$this->db->select('id AS admin_id,first_name AS admin_first_name, last_name AS admin_last_name , CONCAT(first_name," ",last_name) AS admin_full_name, email_address as admin_email_address, login_user_type');
		$this->db->where('email_address', strip_quotes($email_address));
		$this->db->where('password', md5(strip_quotes($password)));
		$this->db->where('status',1);

		$get = $this->db->get('admin');
		//echo $this->db->last_query(); 		exit;
		
		return $get->row_array();
		
	}//end validate_credentials($email_address,$password)

	//Function verify_is_user_login(): Verify If User is Login on the authorized Pages.
	public function verify_is_user_login(){

		if(!$this->session->admin_id){
			
			$this->session->set_flashdata('err_message', 'You have to login to access this page.');
			redirect(base_url().'login');
			exit;
			
		}//if(!$this->session->userdata('admin_id'))
		
	}//end verify_is_user_login()

	//Function verify_is_buying_group_user_login(): Verify If User is Login on the authorized Pages.
	public function verify_is_buying_group_user_login(){

		//if(!$this->session->userdata('admin_id') || !$this->session->userdata('buying_group_user_id') ){
		if(!$this->session->userdata('admin_id') || !$this->session->buying_group_user_id || $this->session->login_user_type == 'prescriber' ){
			
			$this->session->set_flashdata('err_message', 'You have to login to access this page.');
			redirect(base_url().'login');
			exit;
			
		}//if(!$this->session->userdata('admin_id'))
		
	}//end verify_is_buying_group_user_login()

	//Function verify_is_prescriber_loggedin(): Verify If User is Login on the authorized Pages.
	public function verify_is_prescriber_loggedin(){

		//if($this->session->userdata('admin_id') || $this->session->userdata('buying_group_user_id') && $this->session->login_user_type != 'prescriber' ){
		if(!$this->session->userdata('admin_id') || $this->session->buying_group_user_id || $this->session->login_user_type != 'prescriber' ){
			
			$this->session->set_flashdata('err_message', 'You have to login to access this page.');
			redirect(base_url().'login');
			exit;
			
		}//if(!$this->session->userdata('admin_id'))
		
	}//end verify_is_prescriber_loggedin()

	//Function change_password(): Change admin Password
	public function change_password($data,$admin_id){

		extract($data);
		
		$upd_data = array(
		   'password' => $this->db->escape_str(trim(md5($new_password)))
		);		

		//Update the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		//echo $this->db->last_query(); exir;
		
		if($upd_into_db)
			return true;
			
	}//end change_password()
	
	//Get Admin by Email
	public function get_admin_by_email($email_address){
		
		$this->db->dbprefix('admin');
		$this->db->select('id,first_name,last_name,email_address');
		$this->db->where('email_address ',$email_address);
		$get_user= $this->db->get('admin');
		$row_arr = $get_user->row_array();
		//echo $this->db->last_query(); exit;
		return $row_arr;		
		
	}//end get_user_by_email()
	
	//Function send_new_password(): Send New password to the Admin on forgot password
	public function send_new_password($admin_arr){
		
		//Admin data
		$user_first_last_name = ucwords(strtolower(stripslashes($admin_arr['first_name'].' '.$admin_arr['last_name'])));
		$new_password_txt = $this->common->random_number_generator(6);
		$email_address = stripslashes(trim($admin_arr['email_address']));
		
		//Updating New Password into the database

		$upd_data = array(
		   'password' => $this->db->escape_str(trim(md5($new_password_txt)))
		);

		//Update the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_arr['id']);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		if($upd_into_db){
			
		// EMAIL SENDING CODE - START

			$search_arr = array('[FIRST_LAST_NAME]','[USER_NEW_PASSWORD]','[SITE_LOGO]','[SITE_URL]');
			$replace_arr = array($user_first_last_name,$new_password_txt,SITE_LOGO,SURL); 
			
			$this->load->helper(array('email'));
			$this->load->model('email_mod','email_template');
			
			$email_body_arr = $this->email_template->get_email_template(2);
			
			$email_subject = $email_body_arr['email_subject'];

			$email_body = $email_body_arr['email_body'];
			$email_body = str_replace($search_arr,$replace_arr,$email_body);
			
			$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
			$noreply_email = get_global_settings($NOREPLY_EMAIL);
			
			$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
			$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
			
			$send_email = kod_send_email($noreply_email['setting_value'], $email_from_txt['setting_value'], $email_address, $email_subject, $email_body);
			
			/*
			//Preparing Sending Email
			$config['charset'] = 'utf-8';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;			
			$config['protocol'] = 'mail';
				
			$this->load->library('email',$config);
			$this->email->from($noreply_email['setting_value'], $email_from_txt['setting_value']);
			$this->email->to(trim($email_address));
			$this->email->subject($email_subject);
			
			$this->email->message($email_body);
			
			$this->email->send();
			$this->email->clear();
			
		// EMAIL SENDING CODE - STOP
			*/
			return true;

		}else{
			return false;	
		}//end if($upd_into_db)
		
	}//end function send_new_password	

}//end file
?>