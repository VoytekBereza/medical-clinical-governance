<?php
class Invitations_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }


	//Function get_invitation_details(): Fetch the Invitation details using Invitation ID
	public function get_invitation_details($inv_id){
		
		$this->db->dbprefix('invitations');
		$this->db->select('invitations.*,organization.company_name, CONCAT(user_sent_by.first_name," ",user_sent_by.last_name) AS sent_by_fullname,CONCAT(user_sent_to.first_name," ",user_sent_to.last_name) AS sent_to_fullname, user_sent_to.user_type AS sent_to_usertype, user_sent_by.email_address AS sent_by_email ,org_pharmacy_surgery.id AS pharmacy_id, org_pharmacy_surgery.pharmacy_surgery_name');
		$this->db->where('invitations.id', $inv_id);
		
		$this->db->join('invitations','invitations.organization_id = organization.id','LEFT');
		$this->db->join('users AS user_sent_by','invitations.invitation_sent_by = user_sent_by.id','LEFT');
		$this->db->join('users AS user_sent_to','invitations.invitation_sent_to = user_sent_to.id','LEFT');
		$this->db->join('org_pharmacy_surgery','invitations.pharmacy_id = org_pharmacy_surgery.id','LEFT');
		$get = $this->db->get('organization');
		//echo $this->db->last_query(); 		exit;

		return $get->row_array();
		
	}//end get_invitation_details

	//Function get_user_invitations_list(): Returns the list if Active Invitations Available in the invitation table
	public function get_user_invitations_list($user_id){
		
		$this->db->dbprefix('invitations');
		$this->db->select('invitations.*,organization.company_name, organization.id as organization_id,users.id AS sent_by_id, CONCAT(first_name," ",last_name) AS sent_by_fullname,org_pharmacy_surgery.id AS pharmacy_id, org_pharmacy_surgery.pharmacy_surgery_name');
		$this->db->where('invitations.invitation_sent_to',$user_id);
		$this->db->where('invitations.request_changes','0');
		
		$this->db->join('invitations','invitations.organization_id = organization.id','LEFT');
		$this->db->join('users','invitations.invitation_sent_by = users.id','LEFT');
		$this->db->join('org_pharmacy_surgery','invitations.pharmacy_id = org_pharmacy_surgery.id','LEFT');
		$get = $this->db->get('organization');
		//echo $this->db->last_query(); 		exit;

		return $get->result_array();
		
	}//end get_user_invitations_list()

	//Function superintendent_invitation_found(): Will check if we have the Invitation already sent to someone in invitation table against ORG ID
	public function superintendent_invitation_found($org_id){

		$this->db->dbprefix('invitations');
		
		$this->db->select('invitations.*,users.id AS si_id, users.first_name, users.last_name, users.email_address AS email_address_user');
		
		$this->db->where('invitations.organization_id',$org_id);
		$this->db->where('invitations.invitation_type','SI');
		$this->db->join('users','users.id = invitations.invitation_sent_to','LEFT');
		$get = $this->db->get('invitations');
		//echo $this->db->last_query(); 		exit;
		$row_arr = $get->row_array();
		
		return $row_arr;

	}//end superintendent_invitation_found($org_id)

	/*
	Function push_invitation(): This function will be used to PUSH the invitation into the table and email to client
	$sender_user_id =  Sender ID
	$receiver_user_id =  Invitation Receivable User ID
	$organization_id = Organization ID
	$pharmacy_id = Pharmacy ID, will be used for manager or Staff Invitation, for SI will remain 0
	$invitation_type = Possible values are SI, M, ST
	$invitation_method = 'E', 'D' E = Email, D = DB, IF E means user do not exist in DB send notification via email. D = user exist in DB send notification by email + show invitation on dashboard.
	*/
	public function push_invitation($invitation_sent_by, $invitation_sent_to_arr = array(), $organization_id, $pharmacy_id = 0, $invitation_type, $invitation_method, $governance_hr_text, $no_contract=''){
		
		if($invitation_method == 'D'){
			
			if(is_array($invitation_sent_to_arr)){
				$user_id = $invitation_sent_to_arr['id'];
			}else
				$user_id = $invitation_sent_to_arr; // Contains User ID

			$this->db->dbprefix('users');
			$this->db->where('id', $user_id);

			$invitation_sent_to_arr = $this->db->get('users')->row_array();

		} // if($invitation_method == 'D')

		$get_organization_details = $this->organization->get_organization_details($organization_id); //Organization Details
		
		if($pharmacy_id)
			$get_pharmacy_details = $this->pharmacy->get_pharmacy_details($pharmacy_id); //Pharmacy Details
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();

		// Setting up the invitation role as per invitation_type
		
		if($invitation_type == 'SI')
			$organization_role = 'Superintendent';
		elseif($invitation_type == 'M')
			$organization_role = 'Manager';
		elseif($invitation_type == 'DO')
			$organization_role = 'Doctor';
		elseif($invitation_type == 'PH')
			$organization_role = 'Pharmacist';
		elseif($invitation_type == 'PA')
			$organization_role = 'Pharmacist Assistant';
		elseif($invitation_type == 'NU')
			$organization_role = 'Nurse';
		elseif($invitation_type == 'PR')
			$organization_role = 'Pre-Reg';
		elseif($invitation_type == 'TE')
			$organization_role = 'Technician';
		elseif($invitation_type == 'NH')
			$organization_role = 'Non Health Professional';

		$this->load->model('users_mod', 'users');
		$user_data = $this->users->get_user_details($invitation_sent_by);
			
		if($invitation_type == 'SI'){
			$invitation_txt = '<b>You have been invited by <a href="'.SURL.'dashboard/get-user-details/'.$invitation_sent_by.'" class="fancybox_view fancybox.ajax"> <strong style="text-transform:uppercase;" class="text-primary">'.$user_data['user_full_name'].'</strong> </a> to join <a href="'.SURL.'dashboard/get-organization-details/'.$organization_id.'" class="fancybox_view fancybox.ajax"> <strong style="text-transform:uppercase;" class="text-primary">'.filter_string($get_organization_details['company_name']).'</strong> </a> as a <a href="'.SURL.'dashboard/get-user-type-details/'.$invitation_type.'"  class="fancybox_view fancybox.ajax"> <strong style="text-transform:uppercase;" class="text-primary">'.$organization_role.'</strong></a>. To join this location and access location based features such as PGDs, click "View Contract" to the right and select "Request a change" or "Bypass" to proceed.</b>';
								  
		} else {
			// Prepare Invitation text
			$invitation_txt = '<b>You have been invited by <a href="'.SURL.'dashboard/get-user-details/'.$invitation_sent_by.'" class="fancybox_view fancybox.ajax"> <strong style="text-transform:uppercase;" class="text-primary">'.$user_data['user_full_name'].'</strong> </a> to join <a href="'.SURL.'dashboard/get-pharmacy-details/'.$pharmacy_id.'" class="fancybox_view fancybox.ajax"> <strong style="text-transform:uppercase;" class="text-primary">'.filter_string($get_pharmacy_details['pharmacy_surgery_name']).'</strong> </a> as a <a href="'.SURL.'dashboard/get-user-type-details/'.$invitation_type.'"  class="fancybox_view fancybox.ajax"> <strong style="text-transform:uppercase;" class="text-primary">'.$organization_role.'</strong></a>. To join this location and access location based features such as PGDs, click "View Contract" to the right and select "Request a change" or "Bypass" to proceed. </b>';
		}
		// Insert into db
		$ins_data = array(
		
			'invitation_sent_by' => $this->db->escape_str(trim($invitation_sent_by)),
			'organization_id' => $this->db->escape_str(trim($organization_id)),
			'pharmacy_id' => $this->db->escape_str(trim($pharmacy_id)),
			'invitation_txt' => $this->db->escape_str(trim($invitation_txt)),
			'invitation_type' => $this->db->escape_str(trim($invitation_type)),
			'status' => $this->db->escape_str('0'),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);

		if($invitation_method == 'D'){
			//User Exist in DB
			$ins_data['invitation_sent_to'] = $this->db->escape_str(trim($invitation_sent_to_arr['id']));

		}else{
			//User Does Not Exist in DB
			$email_address = (is_array($invitation_sent_to_arr)) ? $invitation_sent_to_arr['email_address'] : $invitation_sent_to_arr;
			$ins_data['email_address'] = $this->db->escape_str(trim($email_address)); // Email address

		} //end if($invitation_method == 'D')
		
		// HR Governance Text
		$ins_data['hr_contract'] = $governance_hr_text; //$governance_hr_text_updated;
		if($no_contract != '') $ins_data['no_contract'] = $no_contract;
		
		//Inserting User data into the database. 
		$this->db->dbprefix('invitations');
		$ins_into_db = $this->db->insert('invitations', $ins_data);

		if($ins_into_db){
			
			$new_inv_id = $this->db->insert_id();

			//Send Email Notification to the User
			// EMAIL SENDING CODE - START
			
			$this->load->helper(array('email'));
			$this->load->model('email_mod','email_template');

			if($invitation_method == 'D'){
				//User Exist in DB
				
				$user_first_last_name = ucwords($invitation_sent_to_arr['first_name'].' '.$invitation_sent_to_arr['last_name']);
				$to_email = $invitation_sent_to_arr['email_address'];
				$search_arr = array('[ORGANIZATION_NAME]','[ORGANIZATION_ROLE]','[FIRST_LAST_NAME]','[SITE_LOGO]','[SITE_URL]');
				$replace_arr = array($organization_name,$organization_role,$user_first_last_name,SITE_LOGO,SURL); 
	
				$email_body_arr = $this->email_template->get_email_template(5);

			} else {

				// User Do Not Exist in DB
				$user_first_last_name = 'User';
	
				$signup_link = SURL.'register/?ref='.urlencode(base64_encode(($new_inv_id)));
				
				//echo $signup_link;
				//exit;
				
				$search_arr = array('[REGISTER_LINK]','[ORGANIZATION_NAME]','[ORGANIZATION_ROLE]','[FIRST_LAST_NAME]','[SITE_LOGO]','[SITE_URL]');
				$replace_arr = array($signup_link,$organization_name,$organization_role,$user_first_last_name,SITE_LOGO,SURL);
				
				$email_body_arr = $this->email_template->get_email_template(8);

				$to_email = (is_array($invitation_sent_to_arr)) ? $invitation_sent_to_arr['email_address'] : $invitation_sent_to_arr;
				
			}//end if($invitation_method == 'D')
			
			$email_subject = $email_body_arr['email_subject'];
			$email_subject = str_replace($search_arr,$replace_arr,$email_subject);
			
			$email_body = $email_body_arr['email_body'];
			$email_body = str_replace($search_arr,$replace_arr,$email_body);
			//exit;
			
			$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
			$noreply_email = get_global_settings($NOREPLY_EMAIL);
			
			$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
			$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
			
			$from = filter_string($noreply_email['setting_value']);
			$from_name = filter_string($email_from_txt['setting_value']);
			$to = trim($to_email);
			$subject = filter_string($email_subject);
			$email_body = filter_string($email_body);
					
			// Call from Helper send_email function
			$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
			
			return $new_inv_id;
				
		}//end if($ins_into_db)
		
	}//end function push_invitation()
	
	//Function cancel_invitation(): Will cancel/ delete the invitation found in a database.
	public function cancel_invitation($invitation_id){

		$del_data = $this->invitations->delete_invitation($invitation_id);
		
		if($del_data)
			return true;
		else
			return false;
	}//end cancel_invitation($invitation_id)
	
	//Function process_invitation_approval(): This function will take action against the Invitation, if User Rejects, the invitation is deleted from the database. If User ACCEPTS, the invitation is deleted from the database after taking appropriate action.
	public function process_invitation_approval($user_id, $invitation_data, $invitation_status, $user_org_superintendent){
		
		$this->load->helper(array('email'));
		$this->load->model('email_mod','email_template');

		$invitation_type = $invitation_data['invitation_type'];

		if($invitation_type == 'SI'){
			$organization_role = 'Superintendent';
			
		}elseif($invitation_type == 'M'){
			$organization_role = 'Manager';
			
		}else{
			$invitation_type = 'ST';
			$organization_role = 'Staff';
			
		}//end if($invitation_type == 'ST')
		
		if($invitation_status == 1){
			
			// Do the Entry into the database for all invitation_types [ SI - M - .......... ]
			$this->organization->invitation_response($invitation_data['invitation_sent_to'], $invitation_data['organization_id'], $invitation_data, $invitation_type, $user_org_superintendent);
			
			// EMAIL SENDING CODE - START
			
			$user_first_last_name = ucwords(filter_string($invitation_data['sent_by_fullname']));
			//$organization_name = filter_string($get_organization_arr['company_name']);
			
			$search_arr = array('[INVITATION_SENT_TO]','[ORGANIZATION_ROLE]','[FIRST_LAST_NAME]','[SITE_LOGO]','[SITE_URL]');
			$replace_arr = array(ucwords(filter_string($invitation_data['sent_to_fullname'])),$organization_role,$user_first_last_name,SITE_LOGO,SURL); 
			
			$email_body_arr = $this->email_template->get_email_template(7);
			
			$email_subject = $email_body_arr['email_subject'];
			$email_subject = str_replace($search_arr,$replace_arr,$email_subject);
			
			$email_body = $email_body_arr['email_body'];
			$email_body = str_replace($search_arr,$replace_arr,$email_body);
			
			$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
			$noreply_email = get_global_settings($NOREPLY_EMAIL);
			
			$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
			$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
			$from = filter_string($noreply_email['setting_value']);
			$from_name = filter_string($email_from_txt['setting_value']);
			$to = trim($invitation_data['sent_by_email']);
			$subject = filter_string($email_subject);
			$email_body = filter_string($email_body);
					
			// Call from Helper send_email function
			$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
		
		}else{
			
			//User have rejected the requested invitation, delete the invitation and notify to admin.
			$del_data = $this->invitations->delete_invitation($invitation_data['id']);

			if($del_data){
				//Send Email Notification to Sender

				// EMAIL SENDING CODE - START
				
				$user_first_last_name = ucwords(filter_string($invitation_data['sent_by_fullname']));
				//$organization_name = filter_string($get_organization_arr['company_name']);
				
				$search_arr = array('[INVITATION_SENT_TO]','[ORGANIZATION_ROLE]','[FIRST_LAST_NAME]','[SITE_LOGO]','[SITE_URL]');
				$replace_arr = array(ucwords(filter_string($invitation_data['sent_by_fullname'])),$organization_role,$user_first_last_name,SITE_LOGO,SURL); 
				
				$email_body_arr = $this->email_template->get_email_template(6);
				
				$email_subject = $email_body_arr['email_subject'];
				$email_subject = str_replace($search_arr,$replace_arr,$email_subject);
				
				$email_body = $email_body_arr['email_body'];
				$email_body = str_replace($search_arr,$replace_arr,$email_body);
				
				$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
				$noreply_email = get_global_settings($NOREPLY_EMAIL);
				
				$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
				$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
				
				
				$from = filter_string($noreply_email['setting_value']);
				$from_name = filter_string($email_from_txt['setting_value']);
				$to = trim($invitation_data['sent_by_email']);
				$subject = filter_string($email_subject);
				$email_body = filter_string($email_body);
						
				// Call from Helper send_email function
				$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
			
					
			}//end if($del_data)
			
		}//end if($invitation_status == 1)
		
		return true;
	}//end process_invitation_approval()
	
	//Function delete_invitation($inv_id): Delete the invitations from the invitation table use inv_id
	public function delete_invitation($inv_id){
		
			$this->db->dbprefix('invitations');
			$this->db->where('id',$inv_id);
			$del_data = $this->db->delete('invitations');
			//echo $this->db->last_query();		exit;
			
			if($del_data)
				return true;
			else
				return false;
	}//end delete_invitation($inv_id)
	
	// Start - verify_invitation_sent($organization_id, $email_address, $invitation_for):
	public function verify_invitation_sent($organization_id, $pharmacy_surgery_id, $email_address, $invitation_for){
		
		// Check if the user exist with given email_address
		$this->db->dbprefix('users');
		$this->db->where('email_address', $email_address);
		$user = $this->db->get('users')->row_array();
		
		// Verify if the user been invited as the same type within the same organization
		$this->db->dbprefix('invitations');
		
		if($user) // If user exist with that email_address in the db
			
			$this->db->where('invitation_sent_to', $user['id']);
			
		else{ // if($user) : if user not belongs to db
			if($invitation_for != 'M')
				$this->db->where('email_address', $email_address);
		}
		
		$this->db->where('organization_id', $organization_id);
		$this->db->where('invitation_type', $invitation_for);
		$this->db->where('pharmacy_id', $pharmacy_surgery_id);
		
		$already_invited = $this->db->get('invitations')->row_array();
		
		if(!empty($already_invited))
			return true;
		else
			return false;
			
	} // End - verify_invitation_sent($organization_id, $email_address, $invitation_for)

	// Start - get_invitation_type($code)
	public function get_invitation_type($code){
		
		if($code == 'DO')
			return 'Doctor';
		elseif($code == 'PH')
			return 'Pharmacist';
		elseif($code == 'PA')
			return 'Pharmacist Assistant';
		elseif($code == 'NU')
			return 'Nurse';
		elseif($code == 'PR')
			return 'Pre-Reg';
		elseif($code == 'TE')
			return 'Technician';
		elseif($code == 'NH')
			return 'Non Health Professional';
		elseif($code == 'M')
			return 'Manager';
		elseif($code == 'SI')
			return 'Superintendent';
		
	} // End - get_invitation_type($code)

	// Function to get usertype ID by Tags Like [ 'DO' - 'P' - 'NU',,, ]
	public function get_usertype_by_tag($tag_name){

		if($tag_name == 'DO')
			return 1;
		elseif($tag_name == 'PH')
			return 2;
		elseif($tag_name == 'PA')
			return 4;
		elseif($tag_name == 'NU')
			return 3;
		elseif($tag_name == 'PR')
			return 6;
		elseif($tag_name == 'TE')
			return 5;
		elseif($tag_name == 'NH')
			return 7;
		elseif($tag_name == 'M')
			return 1;
		elseif($tag_name == 'SI')
			return 1;

	} // public function get_usertype_by_tag($tag_name)

	// Start - public function is_already_staff_member($organization_id, $pharmacy_surgery_id, $email_address)
	public function is_already_staff_member($organization_id, $pharmacy_surgery_id, $email_address){

		$this->db->dbprefix('users, pharmacy_surgery_staff');
		$this->db->select('users.id');

		$this->db->from('users');
		$this->db->join('pharmacy_surgery_staff', 'users.id = pharmacy_surgery_staff.user_id');

		$this->db->where('pharmacy_surgery_staff.organization_id', $organization_id);
		$this->db->where('pharmacy_surgery_staff.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->where('users.email_address', $email_address);

		return $this->db->get()->row_array();


	} // public function is_already_staff_member($organization_id, $pharmacy_surgery_id, $email_address)
	
	//Function update_invitation_for_contract(): This will update the inivitation for any changes requested by the USER in the contract sent before accepting.
	public function update_invitation_for_contract_by_user($data){
		
		extract($data);
		
		//Record insert into database
		$upd_data = array(
		
			'request_changes' => $this->db->escape_str(1),
			'request_change_notes' => $this->db->escape_str(trim($request_change_notes)),
		);
		
		//Inserting User data into the database. 
		$this->db->where('id',$contract_invitation_id);
		$this->db->dbprefix('invitations');
		$upd_into_db = $this->db->update('invitations', $upd_data);
		
		//echo $this->db->last_query(); 		exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
	}//end update_invitation_for_contract_by_user()

	//Function update_invitation_for_contract_osp(): This will update the inivitation contract DONE by OSP in the contract which will sent to user again/
	public function update_invitation_for_contract_osp($data){
		
		extract($data);
		
		$contract_txt = $governance_edit_inv_contract_text;
		
		if($no_contract){

            $this->load->model('email_mod','email_template');
            $email_body_arr = $this->email_template->get_email_template(18);
            $contract_txt = filter_string($email_body_arr['email_body']);
			
		}else{
			$no_contract = '0';	
		}//end if($no_contract)
		
		//Record insert into database
		$upd_data = array(
		
			'request_changes' => $this->db->escape_str(0),
			'request_change_notes' => $this->db->escape_str(trim('')),
			'no_contract' => $this->db->escape_str(trim($no_contract)),
			'hr_contract' => $this->db->escape_str(trim($contract_txt))
		);
		
		
		//Inserting User data into the database. 
		$this->db->where('id',$edit_contract_invitation_id);
		$this->db->dbprefix('invitations');
		$upd_into_db = $this->db->update('invitations', $upd_data);
		
		//echo $this->db->last_query(); 		exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
	}//end update_invitation_for_contract()
	
	// public function get_usert_type_description($id)
	public function get_usert_type_description($id){

		$this->db->dbprefix('usertype');
		$this->db->where('id', $id);
		return $this->db->get('usertype')->row_array();

	}	// public function get_usert_type_description($id)
	
	//Function update_contract_invitation_log(): This function store the log of the contract, about who sent it, when viewed, and completed etc. This information is temporary stored in inviation table and once the invitation is accepted the information is moved to hr contract section.
	public function update_contract_invitation_log($invitation_id, $log_type){
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();

		if($log_type == 'viewed_date'){
			
			$upd_data = array(
			
				'viewed_date' => $this->db->escape_str(trim($created_date)),
				'viewed_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
		}//end if($log_type == 'viewed_date')
		
		//Inserting User data into the database. 
		$this->db->where('id',$invitation_id);
		$this->db->dbprefix('invitations');
		$upd_into_db = $this->db->update('invitations', $upd_data);
		
	}//end update_contract_invitation_log($invitation_id)
	
}//end file
?>