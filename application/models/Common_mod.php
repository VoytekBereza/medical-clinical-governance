<?php
class Common_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function random_number_generator($digit): random number generator function
	public function random_number_generator($digit){
		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789abcdefjhijklmnopqrstuvwxyz";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		return $randnumber;
		
	}// end random_password_generator()
	
	
	//Function random_password_generator($digit): random password generator function
	public function random_password_generator($digit){
		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789AabBcCdDeEfFjGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		return $randnumber;
		
	}// end random_password_generator()
	
	//Function submit_contactus_form(): Submmiting/ emailing the contact us form to the admin
	public function submit_contactus_form($data){
		
		extract($data);

		// EMAIL SENDING CODE - START
		
		$search_arr = array('[USER_EMAIL]','[COMMENTS]','[SITE_LOGO]','[SITE_URL]');
		$replace_arr = array(filter_string($email_address),filter_string($comments),SITE_LOGO,SURL); 
		
		$this->load->helper(array('email'));
		$this->load->model('email_mod','email_template');
		
		$email_body_arr = $this->email_template->get_email_template(3);
		$email_subject = $email_body_arr['email_subject'];
		
		$email_body = $email_body_arr['email_body'];
		$email_body = str_replace($search_arr,$replace_arr,$email_body);

		$CONTACTUS_FORM_EMAIL = 'CONTACTUS_FORM_EMAIL';
		$send_to_email = get_global_settings($CONTACTUS_FORM_EMAIL);
		$to_email_address = $send_to_email['setting_value'];

		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		$email_from_txt = $email_from_txt['setting_value'];

		$SES_SENDER = 'SES_SENDER';
		$ses_sender = get_global_settings($SES_SENDER);
		$ses_sender = $ses_sender['setting_value'];
		
		kod_send_email($ses_sender, $email_from_txt, $to_email_address,$email_subject, $email_body);
		
		return true;
		
	}//end submit_contactus_form($data)
	
	//get_contactus_faq_list() Returns the contact us FAQ list
	function get_contactus_faq_list(){

		$this->db->dbprefix('contact_faq');
		$this->db->where('status',1);
		$get_user= $this->db->get('contact_faq');
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_contactus_faq_list()
	
}//end file
?>