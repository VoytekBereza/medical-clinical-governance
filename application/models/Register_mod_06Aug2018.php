<?php
class Register_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	public function verify_if_organization_exist_by_name($organization_name){
	
		$organization_name = strtolower($organization_name);
		
		$this->db->dbprefix('organization');
		$this->db->where('LOWER(company_name)', $organization_name);

		$get = $this->db->get('organization');
		
		if($get->num_rows() > 0)
			return true;	
		else
			return false;
		
	}//end verify_if_organization_exist()
	
	
	//Function add_new_user(): Add new user into the database
	public function add_new_user($data){
		
		$this->load->model('Buyinggroup_mod','buying_group');
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Generate Random code	
		 $email_activation_code = $this->common->random_number_generator(10);
		 
		 if($user_type == 1){
			$registration_type = 'GMC';
		 }elseif($user_type == 2 || $user_type == 6 ){
			$registration_type = 'GPhC';
		 }elseif($user_type == 3){
			$registration_type = 'NMC';
		 }//end if($user_type == 1)
		 
		 $get_usertype_details = $this->usertype->get_usertype_details($user_type);
		 $user_type_name = $get_usertype_details['user_type'];
		 
		$buying_group_details = $this->buying_group->get_active_buyinggroups($org_buying_group);
		$buying_group_name = filter_string($buying_group_details['buying_groups']);
		 
		//Record insert into database
		$ins_data = array(
		
			'user_type' => $this->db->escape_str(trim($user_type)),
			'first_name' => $this->db->escape_str(trim($first_name)),
			'last_name' => $this->db->escape_str(trim($last_name)),
			'mobile_no' => $this->db->escape_str(trim($mobile_no)),
			'email_address' => $this->db->escape_str(trim($email_address)),
			'password' => $this->db->escape_str(md5((trim($password)))),
			'registration_no' => $this->db->escape_str(trim($registration_no)),
			'registration_type' => $this->db->escape_str(trim($registration_type)),
			'is_locum' => $this->db->escape_str(trim($is_locum)),
			'is_prescriber' => $this->db->escape_str(trim($is_prescriber)),
			'is_owner' => $this->db->escape_str(trim($is_owner)),
			'is_new_user' => $this->db->escape_str(trim('1')),
			'email_verify_status' => $this->db->escape_str(0),
			'admin_verify_status' => $this->db->escape_str(1),
			'activation_code' => $this->db->escape_str(trim(md5($email_activation_code))),
			'buying_group_id' => $this->db->escape_str(trim($org_buying_group)),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);

		//If is_pres == 1, take the speciality field, otherwise leave it blank
		$ins_data['speciality'] = ($is_prescriber == 1) ? $this->db->escape_str(trim($speciality)) : '';
		
		//If usertype = 1 (doctor) he will always be a prescriber
		$ins_data['is_prescriber'] = ($user_type == 1) ? $this->db->escape_str(trim(1)) : $this->db->escape_str(trim($is_prescriber));
		
		//Inserting User data into the database. 
		$this->db->dbprefix('users');
		$ins_into_db = $this->db->insert('users', $ins_data);
		$new_user_id = $this->db->insert_id();
		
		if($ins_into_db){
			//Now check if there were any pending invitations waiting against the user.
			if($inv_id){

				//Record Update into database
				$upd_data = array(
					'invitation_sent_to' => $this->db->escape_str(trim($new_user_id)),
				);
				
				//Update Invitation Data into the database. 
				$this->db->where('id',$inv_id);
				$this->db->dbprefix('invitations');
				$upd_into_db = $this->db->update('invitations', $upd_data);
				
			}//end if($inv_id)

		}//end if($ins_into_db)
		
		//If Locum Selected as 1, enter the locum cities into the database.
		if($is_locum == 1){
			
			for($i=0;$i<count($location_arr);$i++){

				$ins_data = array(
				
					'user_id' => $this->db->escape_str(trim($new_user_id)),
					'city_id' => $this->db->escape_str(trim($location_arr[$i])),
					'created_date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				);
				
				//Inserting Locum cities into the database. 
				$this->db->dbprefix('locum_cities');
				$ins_into_db = $this->db->insert('locum_cities', $ins_data);
				
			}//end for($i=0;$i<count($location_arr);$i++)
			
		}//end if($is_locum == 1)
		
		//IF The User is also registring the Organization.
		if($is_owner == 1){

			//Record insert into organization database
			
			// Organization Post code remove spance
			$org_postcode = str_replace(' ', '', $org_postcode);
			
			$ins_data = array(
			
				'owner_id' => $this->db->escape_str(trim($new_user_id)),
				'company_name' => $this->db->escape_str(trim($company_name)),
				'address' => $this->db->escape_str(trim($org_address)),
				'contact_no' => $this->db->escape_str(trim($org_contact)),
				'postcode' => $this->db->escape_str(trim($org_postcode)),
				'country_id' => $this->db->escape_str(trim($org_country)),
				// 'buying_group_id' => $this->db->escape_str(trim($org_buying_group)),
				'status' => $this->db->escape_str(trim(1)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Inserting User data into the database. 
			$this->db->dbprefix('organization');
			$this->db->insert('organization', $ins_data);
		
			$organization_id = $this->db->insert_id();
			
			//Inserting Global Settings record into the Organization Global Setting Table
			$ins_data = array(
			
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'governance_status' => $this->db->escape_str('1'),
				'online_doctor_status' => $this->db->escape_str('1'),
				'survey_status' => $this->db->escape_str('1'),
				'pmr_status' => $this->db->escape_str('1'),
				'todolist_status' => $this->db->escape_str('1'),
				'ipos_status' => $this->db->escape_str('1'),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Inserting User data into the database. 
			$this->db->dbprefix('org_global_settings');
			$this->db->insert('org_global_settings', $ins_data);
			
			// Make a copy of Governance and SOPs, Get Governance
			$this->db->dbprefix('package_governance');
			$this->db->where('id', 1);
			$governance = $this->db->get('package_governance')->row_array();
			
			// Ready Organization Governance data and insert into db ( Table - org_governance )
			$insert_governance = array('organization_id' => $organization_id, 'governance_text' => $governance['governance_text'], 'sop_text' => $governance['sop_text'], 'finish_text' => $governance['finish_text']);
			
			$this->db->dbprefix('org_governance');
			$ins_into_db = $this->db->insert('org_governance', $insert_governance);
			
			//Get SOPs Categories and Make a COPY into the Organization SOP Table.

			// Get SOPs
			$this->db->dbprefix('sop_categories');
			$sop_categories = $this->db->get('sop_categories')->result_array();
			
			// Ready Organization SOP Categories data and insert into db ( Table - org_sop_categories )
			if(!empty($sop_categories)){
				
				foreach($sop_categories as $each){
					
					$insert_sop_categories = array('organization_id' => $organization_id, 
												'category_name' => $each['category_name'], 
												'status' => 1, 
												'created_date' => date('Y-m-d H:i:s'), 
												'created_ip' => $this->input->ip_address()
											);
					
					$this->db->dbprefix('org_sop_categories');
					$ins_into_db = $this->db->insert('org_sop_categories', $insert_sop_categories);
					
					$new_category_insert_id = $this->db->insert_id();
					
					//Getting LIst of default SOP's added by system and sending the copy to the Organization SOP
					$get_sops_list = $this->governance->get_sops_list('',$each['id']);
					
					for($i=0;$i<count($get_sops_list);$i++){
						
						$insert_sop = array('organization_id' => $organization_id, 
											'category_id' => $new_category_insert_id, 
											'user_types' => $get_sops_list[$i]['user_types'],
											'sop_title' => $get_sops_list[$i]['sop_title'], 
											'sop_description' => $get_sops_list[$i]['sop_description'], 
											'status' => 1, 
											'created_date' => date('Y-m-d H:i:s'), 
											'created_ip' => $this->input->ip_address()
										);

						$this->db->dbprefix('org_sops');
						$ins_into_db = $this->db->insert('org_sops', $insert_sop);
						
					}//end for($i=0$i<count($result_sop)$i++)
					
				}//end foreach($sop_categories as $each)
				
			}//end if(!empty($sop_categories))
			
		}//end if($is_owner == 1)
		
		// EMAIL SENDING CODE - START
		
		$activation_link = SURL."login/activate-account?uid=".($new_user_id)."&code=".md5($email_activation_code);
		$user_first_last_name = ucwords($first_name.' '.$last_name);
		
		$search_arr = array('[ACTIVATION_LINK]','[FIRST_LAST_NAME]','[SITE_LOGO]','[SITE_URL]');
		$replace_arr = array($activation_link,$user_first_last_name,SITE_LOGO,SURL); 
		
		$this->load->model('email_mod','email_template');
		
		$email_body_arr = $this->email_template->get_email_template(1);
		
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
		
		//Sending Notification to Admin email Address
		$email_body_arr = $this->email_template->get_email_template(24);
		$email_subject = $email_body_arr['email_subject'];
		
		$email_body = $email_body_arr['email_body'];
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
		
		$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
		$noreply_email = get_global_settings($NOREPLY_EMAIL);
		
		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
		$from = filter_string($noreply_email['setting_value']);
		$from_name = filter_string($email_from_txt['setting_value']);
		

		$NEWUSER_NOTIFICATION_EMAIL = 'NEWUSER_NOTIFICATION_EMAIL';
		$newuser_notification_email = get_global_settings($NEWUSER_NOTIFICATION_EMAIL);
		
		$to = filter_string($newuser_notification_email['setting_value']);

		$subject = filter_string($email_subject);
		
		$find_arr = array('[FIRST_NAME]','[LAST_NAME]','[USER_EMAIL]','[USER_TYPE]','[BUYING_GROUP]','[REGISTER_DATE]');
		$replace_arr = array($first_name, $last_name, $email_address,$user_type_name,$buying_group_name, date('d/m/Y G:i:s'));
		
		$email_body = filter_string($email_body);
		$email_body = str_replace($find_arr, $replace_arr, $email_body);
		
		$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	}//end add_new_user

	//Function add_new_user(): Add new user into the database
	public function add_new_organization($user_id, $data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into organization database
		
		$get_user_details = $this->users->get_user_details($user_id);
		
		
		$superintendent_id = ($is_si && $get_user_details['user_type'] == '2') ? $user_id : 0;
		
		// Organization Post code remove spance
		$org_postcode = str_replace(' ', '', $org_postcode);
		
		$ins_data = array(
		
			'owner_id' => $this->db->escape_str(trim($user_id)),
			'company_name' => $this->db->escape_str(trim($company_name)),
			'superintendent_id' => $this->db->escape_str(trim($superintendent_id)),
			'address' => $this->db->escape_str(trim($org_address)),
			'contact_no' => $this->db->escape_str(trim($org_contact)),
			'postcode' => $this->db->escape_str(trim($org_postcode)),
			'country_id' => $this->db->escape_str(trim($org_country)),
			'status' => $this->db->escape_str(trim(1)),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		
		//Inserting User data into the database. 
		$this->db->dbprefix('organization');
		$ins_org = $this->db->insert('organization', $ins_data);
		
		$organization_id = $this->db->insert_id();
		
		if($ins_org){
			
			$is_superintendent = ($is_si && $get_user_details['user_type'] == '2') ? '1' : '0';
			
			//Record Update into database
			$upd_data = array(
							'is_owner' => $this->db->escape_str(trim('1')),
							'is_superintendent' => $this->db->escape_str(trim($is_superintendent))
							);
			
			//Update Invitation Data into the database. 
			$this->db->dbprefix('users');
			$this->db->where('id',$user_id);
			$upd_into_db = $this->db->update('users', $upd_data);

		}//end if($ins_org)
		
		//Inserting Global Settings record into the Organization Global Setting Table
		$ins_data = array(
		
			'organization_id' => $this->db->escape_str(trim($organization_id)),
			'governance_status' => $this->db->escape_str('1'),
			'online_doctor_status' => $this->db->escape_str('1'),
			'survey_status' => $this->db->escape_str('1'),
			'pmr_status' => $this->db->escape_str('1'),
			'todolist_status' => $this->db->escape_str('1'),
			'ipos_status' => $this->db->escape_str('1'),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		
		//Inserting User data into the database. 
		$this->db->dbprefix('org_global_settings');
		$this->db->insert('org_global_settings', $ins_data);
		
		// Make a copy of Governance and SOPs, Get Governance
		$this->db->dbprefix('package_governance');
		$this->db->where('id', 1);
		$governance = $this->db->get('package_governance')->row_array();
		
		// Ready Organization Governance data and insert into db ( Table - org_governance )
		$insert_governance = array('organization_id' => $organization_id, 'governance_text' => $governance['governance_text'], 'sop_text' => $governance['sop_text'], 'finish_text' => $governance['finish_text']);
		
		$this->db->dbprefix('org_governance');
		$ins_into_db = $this->db->insert('org_governance', $insert_governance);
		
		//Get SOPs Categories and Make a COPY into the Organization SOP Table.
		
		// Get SOPs
		$this->db->dbprefix('sop_categories');
		$sop_categories = $this->db->get('sop_categories')->result_array();
		
		// Ready Organization SOP Categories data and insert into db ( Table - org_sop_categories )
		if(!empty($sop_categories)){
			
			foreach($sop_categories as $each){
				
				$insert_sop_categories = array('organization_id' => $organization_id, 
											'category_name' => $each['category_name'], 
											'status' => 1, 
											'created_date' => date('Y-m-d H:i:s'), 
											'created_ip' => $this->input->ip_address()
										);
				
				$this->db->dbprefix('org_sop_categories');
				$ins_into_db = $this->db->insert('org_sop_categories', $insert_sop_categories);
				
				$new_category_insert_id = $this->db->insert_id();
				
				//Getting LIst of default SOP's added by system and sending the copy to the Organization SOP
				$get_sops_list = $this->governance->get_sops_list('',$each['id']);
				
				for($i=0;$i<count($get_sops_list);$i++){
					
					$insert_sop = array('organization_id' => $organization_id, 
										'category_id' => $new_category_insert_id, 
										'user_types' => $get_sops_list[$i]['user_types'],
										'sop_title' => $get_sops_list[$i]['sop_title'], 
										'sop_description' => $get_sops_list[$i]['sop_description'], 
										'status' => 1, 
										'created_date' => date('Y-m-d H:i:s'), 
										'created_ip' => $this->input->ip_address()
									);
		
					$this->db->dbprefix('org_sops');
					$ins_into_db = $this->db->insert('org_sops', $insert_sop);
					
				}//end for($i=0$i<count($result_sop)$i++)
				
			}//end foreach($sop_categories as $each)
			
		}//end if(!empty($sop_categories))
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	}//end add_new_user
	
	//Function verify_if_email_already_exist(): Verify if the email already exist before registration.
	public function verify_if_email_already_exist($email_address){
			
		$this->db->dbprefix('users');
		$this->db->where('email_address', $email_address);

		$get = $this->db->get('users');
		
		if($get->num_rows() > 0)
			return true;	
		else
			return false;
		
	} // end verify_if_email_already_exist	
	
}//end file
?>