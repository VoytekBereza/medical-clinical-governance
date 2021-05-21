<?php
//Function filter_price():  Wil change the price formats as per the need.
function filter_name($name){
	
	$filter_txt = ucfirst(stripcslashes(trim($name)));
	return $filter_txt;
	
}//end filter_price()

//Function print_this(&$array): Used for development purpose. Pritning Array or any Object with <pre>.
function print_this(&$arr){
	
	echo '<pre>';
	print_r($arr);
	
}//end print_this(&$array);

//Function filter_string():  will filter the string from unwanted characters while displaying it on teh screen.
function filter_string(&$string){
	
	$ci =& get_instance();
	
	$filter_txt = stripcslashes(trim($string));
	
	return $filter_txt;
	
}//end filter_string()

//Function filter_price():  Wil change the price formats as per the need.
function filter_price(&$price){
	
	$ci =& get_instance();
	
	$filter_price = number_format($price,2);
	
	return $filter_price;
	
}//end filter_price()

//Function random_number_generator($digit): random number generator function
function random_number_generator($digit){
	$randnumber = '';
	$totalChar = $digit;  //length of random number
	$salt = "0123456789abcdefjhijklmnopqrstuvwxyz";  // salt to select chars
	srand((double)microtime()*1000000); // start the random generator
	$password=""; // set the inital variable
	
	for ($i=0;$i<$totalChar;$i++)  // loop and create number
	$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
	return $randnumber;
	
}// end random_password_generator()


//Function filter_price():  Wil change the price formats as per the need.
function get_global_settings(&$setting_name){
	
	$ci =& get_instance();
	
	$ci->db->dbprefix('global_settings');
	$ci->db->where('setting_name',$setting_name);
	$get_result = $ci->db->get('global_settings');
	
	return $get_result->row_array();
	
}//end get_global_settings(&$setting_name)

// Start - function kod_date_format($date='', $time=''): Function to return the formated date (first parameter date and second is boolean true or false to get time)
if (!function_exists('kod_date_format')) {
	function kod_date_format($date = '', $time = FALSE){
		
		if(substr($date,0,4) != '0000'){
			$date1 = $date;
			if($date != ''){
				
				if($time == true)
					return date_format(date_create($date),"d/m/Y g:i a");
				elseif($time == false)
					return date_format(date_create($date),"d/m/Y");
					
			} else
				return $date;
				
		}else{
			return $date;
			
		}//end if(substr($date,0,4) != '0000')
		
	}//end kod_date_format($date='', $time='')

} // End - function kod_date_format($date='', $time='')

function uk_date_format($date = '', $time_only = FALSE, $time = FALSE){

		if(substr($date,0,4) != '0000'){
			$date1 = $date;
			if($date != ''){
				
				if($time == true)
					return date_format(date_create($date),"d/m/Y g:i a");
				elseif($time == false){

					if($time_only)
						return date_format(date_create($date),"g:i:s");
					else
						return date_format(date_create($date),"d/m/Y");
				}//end if($time == true
				
			} else
				return $date;
				
		}else{
			return $date;
			
		}//end if(substr($date,0,4) != '0000')
		
	}//end standard_date_format($date='', $time='')

//Function get_longitude_latitude(): Fetch longitude, latitude by address
function get_longitude_latitude($address){

	$address = urlencode($address);
	$request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$address."&sensor=true";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $request_url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$xml = curl_exec($ch);
	curl_close($ch);
	
	$xml = simplexml_load_string($xml);

	$status = $xml->status;

	if ($status=="OK") {
		
	  $result_arr['latitude'] = $xml->result->geometry->location->lat;
	  $result_arr['longitude'] = $xml->result->geometry->location->lng;
	  
	}//end if ($status=="OK") 
	
	return $result_arr;

}//end get_longitude_latitude($address)

//Function authenticate_user_panel(: This functin returns the menus which are open and are available. Checks if the Governance is read + then chck show the menus accoding to the designationed types of the users.
function authenticate_user_panel($user_id, $organization_id, $pharmacy_surgery_id = ''){
	
	$ci =& get_instance();
	
	if($pharmacy_surgery_id != ''){
		$global_settings_arr = get_pharmacy_surgery_global_settings($pharmacy_surgery_id);	
		$governance_purchased_arr = $ci->governance->get_governance_purchased_pharmacies($organization_id,'P',$pharmacy_surgery_id);

	}else{
		$global_settings_arr = get_organization_global_settings($organization_id);
		$governance_purchased_arr = $ci->governance->get_governance_purchased_pharmacies($organization_id,'P');
	}//end if($pharmacy_surgery_id != '')
	
	$organization_pharmacies = $ci->pharmacy->get_pharmacy_surgery_list($organization_id);
	
	//CHECK GOVERNANCE READ STATUS
	$get_my_role = $ci->pharmacy->get_my_role_in_pharmacy_surgery($user_id, $pharmacy_surgery_id); // Get User role in the pharmacy / surgery [ By pharmacy_surgery_id ]
	
	if($ci->session->is_owner){
		$governance_read = 1;		
	}else{
		
		if($get_my_role['is_si'] == 1){
				
				$verify_governance_as = 'SI'; //SI Superceeds
		
				$get_organization_details = $ci->organization->get_organization_details($organization_id);
				
				//Check Governance Status
				//Hold Governance Global setting Status
				$org_governance_global_setting = $get_organization_details['governance_status'];
				$governance_purchased_pharmacies = $ci->governance->get_governance_purchased_pharmacies($organization_id,'P');
		
				if(count($governance_purchased_pharmacies) > 0){
					
					if($org_governance_global_setting){
						
						$is_governance_passed = $ci->governance->is_governance_read_by_user($user_id, $organization_id, '', $verify_governance_as,$ci->session->user_type);
						
						if($is_governance_passed){
							//Governance is Purchased by the SI, show team builder.
							$governance_read = 1;	
						}else{
							
							//Governance is not Passed yet by the SI, show Governance
							$governance_read = 0;	
							
						}//end if($is_governance_passed)
						
					}else
						$governance_read = 1;	
				}else{
					$governance_read = 1;
				}//end if(count($governance_purchased_pharmacies) > 0)
				
			}else{
		
				if($get_my_role['is_staff'] == 1)
					$verify_governance_as = 'ST';
			
				if($get_my_role['is_manager'] == 1)
					$verify_governance_as = 'M';
			
				//Check Pharmacy Status
				$pharmacy_surgery_governance_purchase_status  = $ci->governance->get_governance_purchased_pharmacies($organization_id,'P',$pharmacy_surgery_id);
		
				if(count($pharmacy_surgery_governance_purchase_status) > 0){
		
					// Governance is Purchased for this pharmacy
					// Varify if the Governance read setting is on for this Pharmacy / Surgery
					$is_governance_on = $ci->pharmacy->is_governance_settings_on($pharmacy_surgery_id);
					
					if($is_governance_on){
				
						$governance_read = $ci->governance->is_governance_read_by_user($user_id, $organization_id, $pharmacy_surgery_id, $verify_governance_as, $ci->session->user_type);
						//print_this($governance_read); 
						
						if($governance_read){
							$governance_read = 1;	
		
						}else{
							$governance_read = 0;	
							//echo $governance_read; exit;		
						}// if($governance_read)
		
					} else{
						$governance_read = 1;
					}// if($is_governance_on)
				
				} else 
					// If not purchased
					$governance_read = 1;	
				// if(count($pharmacy_surgery_governance_purchase_status) > 0)
		
			}//end if($get_my_role['is_si'] == 1)		
			
	}//end if($ci->session->is_owner)
	
	if($governance_read == 1){

		//AUTHENTICATE PGD MENU
		$autenticate_menu = array();
		$get_default_doc_pharmacy = $ci->organization->get_default_doctor_org($user_id, $organization_id);
		
		if($get_default_doc_pharmacy){
	
			if(($user_id == $get_default_doc_pharmacy['default_doctor']) || ($user_id == $get_default_doc_pharmacy['default_pharmacist']))
				$autenticate_menu['show_authenticate_pgd'] = 1;
			else
				$autenticate_menu['show_authenticate_pgd'] = 0;
		}else{
			$autenticate_menu['show_authenticate_pgd'] = 0;
		}//end if($get_default_doc_pharmacy)
		
		if($get_my_role['is_manager'] == 1){
			$autenticate_menu['show_manage_medicine'] = ($global_settings_arr['online_doctor_status'] == '1' && count($organization_pharmacies) > 0)? '1' : '0'; //Online Doctor
			$autenticate_menu['show_nhs_data'] = 1;
			$autenticate_menu['show_website'] = 1;
			
		}//end if($get_my_role['is_manager'] == 1)

		$autenticate_menu['show_manage_surveys'] = ($global_settings_arr['survey_status'] == '1' && count($organization_pharmacies) > 0)? '1' : '0'; //Manage Surveys Menu	
		$autenticate_menu['show_view_governance'] = ($global_settings_arr['governance_status'] && $governance_purchased_arr ) ? '1' : '0'; //Show Governance;

		//Show PMR for Nurse, Pharmacist and Doctor
		if(($ci->session->user_type == 1 || $ci->session->user_type == 2 || $ci->session->user_type == 3)){
			$autenticate_menu['show_pmr'] = ($global_settings_arr['pmr_status'] && count($organization_pharmacies) > 0) ? '1' : '0';
		}else
			$autenticate_menu['show_pmr'] = 0;
		//end if(($ci->session->user_type == 1 || $ci->session->user_type == 2 || $ci->session->user_type == 3) && $ci->session->is_prescriber )
		
		//Checking Travel Dtaa
		//$get_user_details = $ci->users->get_user_details($user_id);
		
		$get_pharmacy_details =  array();
		
		if($ci->session->pharmacy_surgery_id)
			$get_pharmacy_details = $ci->pharmacy->get_pharmacy_surgery_details($ci->session->pharmacy_surgery_id);

		if($get_pharmacy_details['enable_clinical_governance'])
			$autenticate_menu['show_clinical_governance'] = 1;	

		if($get_pharmacy_details['enable_register'])
			$autenticate_menu['show_register'] = 1;	

		if($get_pharmacy_details['enable_prescription'])
			$autenticate_menu['show_prescription'] = 1;	

		$autenticate_menu['show_travel_insurance'] = 1;
		$autenticate_menu['show_contact_book'] = 1;
		
		
	}else{
		
		$autenticate_menu['show_authenticate_pgd'] = 0;
		$autenticate_menu['show_view_governance'] = 0;
		$autenticate_menu['show_manage_surveys'] = 0;
		$autenticate_menu['show_manage_medicine'] = 0;
		$autenticate_menu['show_nhs_data'] = 1;
		$autenticate_menu['show_website'] = 0;
		$autenticate_menu['show_manage_governance'] = 0;
		$autenticate_menu['show_pmr'] = 0;
		
		$autenticate_menu['show_clinical_governance'] = 0;	
		$autenticate_menu['show_register'] = 0;	
		$autenticate_menu['show_prescription'] = 0;	
		
		$autenticate_menu['show_travel_insurance'] = 0;
		$autenticate_menu['show_contact_book'] = 0;
		
	}//end if($governance_read == 1)

	if($get_my_role['is_si'] == 1 || $get_my_role['is_owner']){
		
		//if($get_my_role['is_owner'])
			//$governance_read = 1;	
			
		if($governance_read){
			
			$autenticate_menu['show_manage_governance'] = ($global_settings_arr['governance_status'] && $governance_purchased_arr) ? '1' : '0';
			$autenticate_menu['show_manage_surveys'] = ($global_settings_arr['survey_status'] && count($organization_pharmacies) > 0) ? '1' : '0';
			$autenticate_menu['show_manage_medicine'] = ($global_settings_arr['online_doctor_status'] && count($organization_pharmacies) > 0) ? '1' : '0';
			$autenticate_menu['show_nhs_data'] = 1;
			$autenticate_menu['show_website'] = 1;
			$autenticate_menu['show_pmr'] = ($global_settings_arr['pmr_status'] && count($organization_pharmacies) > 0) ? '1' : '0';
			
		}//end if($governance_read)
		
	}//end if($get_my_role['is_si'] == 1 || $get_my_role['is_owner'] == 1)
		
	//echo $governance_read; exit;
	
	//PMR MENU
	$autenticate_menu['governance_passed'] = $governance_read;
	return $autenticate_menu;
	
}//end authenticate_user_panel($user_id, $organization_id,$pharmacy_surgery_id = '')

// Start - get_pharmacy_surgery_medicines($category_id='', $medicine_id='', $pharmacy_surgery_id='')
function get_pharmacy_surgery_medicines($category_id='', $medicine_id='', $pharmacy_surgery_id=''){

		$ci =& get_instance();
	
		$ci->db->dbprefix('medicine');
		$ci->db->select('medicine.medicine_class, medicine.suggested_dose, medicine.url_slug AS medicine_url_slug, medicine.images_src, medicine.is_branded, medicine.merge_with_medicine_id, medicine.id AS medicine_id, medicine.category_id, medicine.short_description, medicine.images_src as medicine_image, medicine.description as medicine_description, medicine.brand_name,medicine.medicine_name, CONCAT(brand_name," ",medicine_name) AS medicine_full_name, medicine.meta_title as medicine_meta_title, medicine.meta_keywords as medicine_meta_keywords, medicine.meta_description as medicine_meta_description,
							medicine_form.medicine_form,
							 medicine_cat.category_title, medicine_cat.category_subtitle, medicine_cat.description as cat_description, medicine_cat.category_image, medicine_cat.meta_title, medicine_cat.meta_keywords, medicine_cat.meta_description, medicine_cat.raf_title, medicine_cat.show_online, medicine_cat.url_slug, medicine_cat.status, 
				strength.id AS strength_id,strength.strength,strength.per_price');
		
		if(trim($medicine_id) != '') $ci->db->where('medicine.id', $medicine_id);
		if(trim($category_id) != '') $ci->db->where('medicine.category_id', $category_id);
		
		$ci->db->join('pharmacy_medicine_strength AS ph_strength', 'medicine.id = ph_strength.medicine_id','LEFT');
		
		$ci->db->join('medicine_categories AS medicine_cat', 'medicine.category_id = medicine_cat.id','LEFT');
		$ci->db->join('medicine_strength AS strength', 'medicine.id = strength.medicine_id','LEFT');
		$ci->db->join('medicine_form', 'medicine_form.id = medicine.medicine_form_id','LEFT');
		
		$get = $ci->db->get('medicine');
		
		//echo $ci->db->last_query(); exit;
		
		$result = $get->result_array();
		
		//print_this($result);
		$pharma_medicine = array();
		
		for($i=0;$i<count($result);$i++){
			
			$pharma_medicine['category_info']['category_id'] = $result[$i]['category_id'];
			$pharma_medicine['category_info']['category_title'] = $result[$i]['category_title'];
			$pharma_medicine['category_info']['category_subtitle'] = $result[$i]['category_subtitle'];
			$pharma_medicine['category_info']['category_description'] = $result[$i]['cat_description'];
			$pharma_medicine['category_info']['category_image'] = $result[$i]['category_image'];
			$pharma_medicine['category_info']['meta_title'] = $result[$i]['meta_title'];
			$pharma_medicine['category_info']['meta_keywords'] = $result[$i]['meta_keywords'];
			$pharma_medicine['category_info']['meta_description'] = $result[$i]['meta_description'];
			$pharma_medicine['category_info']['raf_title'] = $result[$i]['raf_title'];
			$pharma_medicine['category_info']['show_online'] = $result[$i]['show_online'];
			$pharma_medicine['category_info']['url_slug'] = $result[$i]['url_slug'];
			$pharma_medicine['category_info']['status'] = $result[$i]['status'];
			
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_description'] = $result[$i]['medicine_description'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['brand_name'] = $result[$i]['brand_name'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_name'] = $result[$i]['medicine_name'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_class'] = $result[$i]['medicine_class'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_id'] = $result[$i]['medicine_id'];
			
			if($pharmacy_surgery_id){ // If Pharmacy / Surgery ID is set then retuern the price of the medicne in this Pharmacy / Surgery

				$quantity_arr = get_medicine_quantities($result[$i]['medicine_id']);
				$strength_arr = $result[$i]['strength_id'];

				$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_price'] = $ci->pharmacy->search_cheap_pharmacies($medicine_id, $result[0]['strength_id'], $quantity_arr, 1,$pharmacy_surgery_id, '');

				//echo $medicine_id.' - '.$result[0]['strength_id'].' - '.$quantity_arr[0]['quantity_id'].' - '.$pharmacy_surgery_id;
				//exit;

			} // if($pharmacy_surgery_id)

			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_full_name'] = $result[$i]['medicine_full_name'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_short_description'] = $result[$i]['short_description'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['images_src'] = $result[$i]['images_src'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['category_id'] = $result[$i]['category_id'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['is_branded'] = $result[$i]['is_branded'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_image'] = $result[$i]['medicine_image'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['url_slug'] = $result[$i]['medicine_url_slug'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['suggested_dose'] = $result[$i]['suggested_dose'];
			//$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['merge_with_medicine_id'] = $result[$i]['merge_with_medicine_id'];
			
			// Check if the medicine is merged with the medicine id
			if($result[$i]['merge_with_medicine_id'] != ''){
				
				$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['merge_with_medicine_arr'] = get_medicine($result[$i]['merge_with_medicine_id']);
				
			} // if($result[$i]['merge_with_medicine_id'] != '')
			
			// If request is for a single medicine - send meta tags of the medicine
			if($medicine_id != ''){
				$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['meta_title'] = $result[$i]['medicine_meta_title'];
				$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['meta_keywords'] = $result[$i]['medicine_meta_keywords'];
				$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['meta_description'] = $result[$i]['medicine_meta_description'];
			} // if($medicine_id != '')
			
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['strength_arr'][$result[$i]['strength_id']] = $result[$i]['strength'];
			//$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['strength_arr']['strength'] = $result[$i]['strength'];
			$pharma_medicine['medicine_arr'][$result[$i]['medicine_id']]['quantity_arr'] = get_medicine_quantities($result[$i]['medicine_id']);
				
		} //end for($i=0;$i<count($result)$i++)
		
		//print_r($pharma_medicine);
		//exit;

		return $pharma_medicine;
		
	}//end get_pharmacy_surgery_medicines($pharmacy_surgery_id='')

	//Function get_medicine_quantities(): This function will return list of quantities of a medicine.
	if(!function_exists('get_medicine_quantities')){
		function get_medicine_quantities($medicine_id){

			$ci = get_instance();
		
			$ci->db->dbprefix('medicine_quantity');
			$ci->db->select('id as quantity_id, quantity,quantity_txt,discount_precentage');
			$ci->db->where('medicine_id', $medicine_id);
			$get = $ci->db->get('medicine_quantity');
		
			return $get->result_array();
			
		}//end get_medicine_quantities($medicine_id)
	} // if(!function_exists('get_medicine_quantities'))

	// get_medicine($medicine_id)
	if(!function_exists('get_medicine')){
		function get_medicine($medicine_id){

			$ci = get_instance();
		
			$ci->db->dbprefix('medicine');
			//$ci->db->select('id, ,discount_precentage');
			$ci->db->where('id', $medicine_id);
			$get = $ci->db->get('medicine');
		
			return $get->row_array();
			
		}//end get_medicine($medicine_id)		
	} // if(!function_exists('get_medicine'))

	//Function kod_send_email():  Send email.
	function kod_send_email($from_email, $email_from_txt = '', $to_email_address,$email_subject, $email_body){
		
		$ci =& get_instance();
		// Username
		$SES_USERNAME = 'SES_USERNAME';
		$ses_username = get_global_settings($SES_USERNAME);
		$ses_username = trim($ses_username['setting_value']);
	
		// Password
		$SES_PASSWORD = 'SES_PASSWORD';
		$ses_password = get_global_settings($SES_PASSWORD);
		$ses_password = trim($ses_password['setting_value']);
	
		// Host
		$SES_HOST = 'SES_HOST';
		$ses_host = get_global_settings($SES_HOST);
		$ses_host = trim($ses_host['setting_value']);
	
		// Port
		$SES_PORT = 'SES_PORT';
		$ses_port = get_global_settings($SES_PORT);
		$ses_port = trim($ses_port['setting_value']);
	
		// Port
		$SES_SENDER = 'SES_SENDER';
		$ses_sender = get_global_settings($SES_SENDER);
		$ses_sender = trim($ses_sender['setting_value']);
		
		/*
		echo "Usr:".$ses_username.'<br>';
		echo "Ps:".$ses_password.'<br>';
		echo 'Ht: '.$ses_host.'<br>';
		echo 'Pt: '.$ses_port.'<br>';
		echo 'Sr: '.$ses_sender.'<br>';
		
		exit;
		*/
		//////////////////////////////////////////////////////////////////////
	
		// Replace sender@example.com with your "From" address. 
		// This address must be verified with Amazon SES.
		$SENDER = $ses_sender; // $email; //'info@surveyfocus.co.uk';
	
		// Replace recipient@example.com with a "To" address. If your account 
		// is still in the sandbox, this address must be verified.
		$RECIPIENT = trim($to_email_address); //'twister787@gmail.com';
															  
		// Replace smtp_username with your Amazon SES SMTP user name.
		$USERNAME = $ses_username; // 'AKIAJJDSTFURI6LQWNPQ';
	
		// Replace smtp_password with your Amazon SES SMTP password.
		$PASSWORD = $ses_password; // 'As/vj5Eh8mLt7dYHnJWnK/6Fk5UwUGhD9qtA300O9rPL';
	
		// If you're using Amazon SES in a region other than US West (Oregon), 
		// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP  
		// endpoint in the appropriate region.
		
		$HOST = $ses_host; // 'email-smtp.eu-west-1.amazonaws.com'; 
		// $HOST = 'ses-smtp-user.20170116-163508';
		// ssl://email-smtp.us-east-1.amazonaws.com
		
		// The port you will connect to on the Amazon SES SMTP endpoint.
		$PORT = $ses_port; //'587';
	
		// Other message information                                               
		$SUBJECT = filter_string($email_subject); //'Amazon SES test (SMTP interface accessed using PHP)';
		$BODY = filter_string($email_body); //'This email was sent through the Amazon SES SMTP interface by using PHP.';
	
		////////////////////////////////////////
		////// CI SMTP Mail configuration //////
	
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => $HOST,
			'smtp_user' => $USERNAME,
			'starttls' => TRUE,
			'smtp_pass' => $PASSWORD,
			'smtp_port' => $PORT,
			'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
			'mailtype' => 'html'
		);

		$ci->load->library('email');
	
		$ci->email->initialize($config);
	
		$ci->email->from($SENDER, $email_from_txt);
		$ci->email->to($RECIPIENT);
		
		$ci->email->subject($SUBJECT);
		$ci->email->message($BODY);
		$ci->email->set_newline("\r\n");
		$sent_status = $ci->email->send();
		
		$ci->email->print_debugger();
		$ci->email->clear();
		
		return true;
	
	}//end send_email($to, $from_email, $from_text, $subject, $email_body)
	
	function kod_send_email_old($from, $from_name = '', $to, $subject = '', $email_body ='', $attachments =''){
	
	    $ci =& get_instance();
	
	    $ci->load->helper(array('email'));		
		//Preparing Sending Email
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;			
		$config['protocol'] = 'mail';
			
		$ci->load->library('email',$config);
		$ci->email->from($from, $from_name);
		$ci->email->to(trim($to));
		$ci->email->subject($subject);
		$ci->email->message($email_body);
		
		$ci->email->send();
		$ci->email->clear();
		
		// EMAIL SENDING CODE - STOP
		
	}//end kod_send_email()	

	//Function filter_price():  Wil change the price formats as per the need.
	function get_vaccine_extra_advices($advice_id){
		
		$ci =& get_instance();
		
		$ci->db->dbprefix('vaccine_advices');
		$ci->db->select('advice_title');
		$ci->db->where('id',$advice_id);
		$get_result = $ci->db->get('vaccine_advices');
		
		return $get_result->row_array();
		
	}//end get_vaccine_extra_advices($advice_id)

	//function get_destination($countries_list)
	function get_destination($countries_list){
	
	    $ci =& get_instance();
	
		$exploded = explode('#', $countries_list['destinations_list']);

		$result;
		foreach($exploded as $id){

			if($id){
				
				$ci->db->dbprefix('vaccine_destinations');
				$ci->db->where('id', $id);
				$result[] = $ci->db->get('vaccine_destinations')->row_array();
			} // if($id)

		} // foreach($exploded as $id)

		return $result;

	} //function get_destination($countries_list)

	//Function get_organization_global_settings():  Will return Organization Global Setting List
	function get_organization_global_settings(&$organization_id = ''){
		
		$ci =& get_instance();
		
		$ci->db->dbprefix('org_global_settings');
		$ci->db->where('organization_id',$organization_id);
		$get_result = $ci->db->get('org_global_settings');

		//echo $ci->db->last_query(); exit;
		
		return $get_result->row_array();
		
	}//end get_organization_global_settings(&$setting_name)

	function get_pharmacy_surgery_global_settings(&$pharmacy_surgery_id = ''){
		
		$ci =& get_instance();
		
		$ci->db->dbprefix('pharmacy_surgery_global_settings');
		$ci->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		$get_result = $ci->db->get('pharmacy_surgery_global_settings');
		
		return $get_result->row_array();
		
	}//end get_organization_global_settings(&$setting_name)

	// function get_pharmacy_surgery_list($user_id='', $organization_id='')
	if(!function_exists('get_pharmacy_surgery_list')){
		function get_pharmacy_surgery_list($user_id='', $organization_id=''){
			
			$ci =& get_instance();

			if($organization_id && $user_id == '') return $ci->pharmacy->get_pharmacy_surgery_list($organization_id);
			if($user_id && $organization_id == '') return $ci->pharmacy->get_my_pharmacies_surgeries($user_id);

		} // function get_pharmacy_surgery_list($user_id='', $organization_id='')

	} // if(!function_exists('get_pharmacy_surgery_list'))

	//check_if_user_exist_in_pharmacy($ci->session->id,$ci->session->pharmacy_surgery_id);
	function check_if_user_exist_in_pharmacy($user_id,$pharmacy_surgery_id){
		
		$ci =& get_instance();

		if($pharmacy_surgery_id != ''){
			
			//Check if I still belong to this Pharmacy or not.
			$exist_in_pharmacy_org = $ci->pharmacy->get_my_role_in_pharmacy_surgery($user_id, $pharmacy_surgery_id);
			$is_si = $ci->organization->user_already_superintendent($ci->session->id);
			
			if(!$ci->session->is_owner && !$is_si && !$exist_in_pharmacy_org['is_manager'] && !$exist_in_pharmacy_org['is_staff']){

				$ci->session->pharmacy_surgery_id = '';
				$ci->session->pmr_pharmacy_surgery_id = '';
				
				$ci->session->organization_id = '';
				$ci->session->pmr_organization_id = '';

				redirect(SURL.'dashboard');
				
			}//end if(!$exist_in_pharmacy_org['is_owner'] && !$exist_in_pharmacy_org['is_si'] && !$exist_in_pharmacy_org['is_manager'] && !$exist_in_pharmacy_org['is_staff'])
				
		}else{
			//None
		}//end if($pharmacy_surgery_id != '')
		
	}//end check_if_user_exist_in_pharmacy($user_id,$pharmacy_surgery_id)

	// function count_ipmr_pending_transactions()
	function count_ipmr_pending_transactions(){

		$ci =& get_instance();
		$count_all_records = 1;
		$sub = 0;

		$is_default = $ci->pmr->get_default_prescriber_organization_list($ci->session->id, $ci->session->pmr_organization_id);
		if($is_default){

			// Pending Medicine List Online and PMR both
			$pending_transaction_list = $ci->pmr->get_organization_transactions($ci->session->pmr_organization_id,'','','P','', 'M','', $count_all_records);
		
			// Pending Vaccine List Online and PMR both
			$vaccine_pending_transaction_list = $ci->pmr->get_organization_transactions($ci->session->pmr_organization_id,'','','P','', 'V','', $count_all_records);
			
			$sub = count($pending_transaction_list) + count($vaccine_pending_transaction_list);

		} else {

			$pending_transaction_list_all = $ci->pmr->get_organization_transactions_all_request($ci->session->pmr_organization_id, $ci->session->pmr_pharmacy_surgery_id,'','','P','', 'M','', '');
			
			$vaccine_pending_transaction_list_all = $ci->pmr->get_organization_transactions_all_request($ci->session->pmr_organization_id, $ci->session->pmr_pharmacy_surgery_id,'','','P','', 'V','', '');
			
			$sub = $sub + count($pending_transaction_list_all) + count($vaccine_pending_transaction_list_all);
			
		} // if($is_default)
		
		// For Pharamcist Only/ Dispense and Current + Complete Deliveries
		if($ci->session->user_type == 2){

			// Dispense Deliveries
			$dispense_transaction_list = $ci->pmr->get_organization_transactions($ci->session->pmr_organization_id,$ci->session->pmr_pharmacy_surgery_id,'','DS','', 'M','',$count_all_records);

			$sub = $sub + count($dispense_transaction_list);

		} // if($ci->session->user_type == 2)

		$total = $sub;

		return $total;

	} // function count_ipmr_pending_transactions()

	// function count_surveys()
	function count_surveys(){

		$ci =& get_instance();

		//Check if Survey is purchased
	    $check_if_survey_purchased = $ci->survey->get_survey_purchased_pharmacies($ci->session->organization_id,'P',$ci->session->pharmacy_surgery_id);
		
		$get_pharmacy_details = $ci->pharmacy->get_pharmacy_surgery_details($ci->session->pharmacy_surgery_id);
		
		if($check_if_survey_purchased['survey_start_date']){

			$survey_no_of_required_attempts = filter_string($get_pharmacy_details['no_of_surveys']);
			$get_no_of_surveys_attempted = $ci->survey->get_no_of_surveys_attempted($check_if_survey_purchased['survey_ref_no']);
			
			return $get_no_of_surveys_attempted.' / '.$survey_no_of_required_attempts;
			
		}else{
			return '';
		}
		//end if($check_if_survey_purchased['survey_start_date'] && ($check_if_survey_purchased['expiry_date'] <= date('Y-m-d')))


	} // function count_surveys()


	//Function get_product_reviews(): Get product review
	function get_product_reviews($product_type,$product_id, $offset=''){
		
		$ci =& get_instance();
		
		$ci->db->dbprefix('user_order_details');
		$ci->db->select('user_order_details.reviews, user_order_details.star_rating,user_orders.purchase_date, CONCAT(first_name," ",last_name) AS review_by_name,user_order_details.review_date');
		$ci->db->join('users', 'user_order_details.user_id = users.id', 'LEFT'); 
		$ci->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'LEFT'); 
		$ci->db->where('user_order_details.reviews <> "" ');
		$ci->db->where('user_order_details.product_id',$product_id);
		$ci->db->where('user_order_details.product_type',$product_type);
		$ci->db->order_by('user_order_details.review_date','DESC');
		
		if($offset != '')
			$ci->db->limit(10, $offset);
		
		$get = $ci->db->get('user_order_details');
		//echo $ci->db->last_query(); 		exit;
		$row_arr = $get->result_array();
		
		return $row_arr;

	}//end get_purchased_items_by_details($user_id)
	
	
	// this function user for only complaints and clinical log
	function  get_user_details_new($user_id){
		
		$ci =& get_instance();
		
		$ci->db->dbprefix('users');
		
		$ci->db->select('users.*,CONCAT(first_name," ",last_name) AS fullname');
		$ci->db->where('users.id',$user_id);
		$ci->db->join('usertype','users.user_type = usertype.id','LEFT');
		$get_user= $ci->db->get('users');
		$row_arr = $get_user->row_array();
		//echo $ci->db->last_query(); 		exit;
		return $row_arr;		
	}
	
	function get_product_ratings($product_type, $product_id){
		
		$ci =& get_instance();
		
		$ci->db->dbprefix('user_order_details');
		
		$ci->db->select('AVG(star_rating) AS avg_rating');
		$ci->db->where('product_id',$product_id);
		$ci->db->where('star_rating !=','0');
		$ci->db->where('product_type',$product_type);

		$get_user= $ci->db->get('user_order_details');
		$row_arr = $get_user->row_array();
		//echo $ci->db->last_query(); 		exit;
		return $row_arr;		

	}//end get_ratings($product_type, $product_id)

	function td_get_design_templates($template_id = ''){
		
		//Saving Lead if Exist
		$post_arr['template_id'] = filter_string($template_id);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'get-design-templates');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		foreach($post_arr as $key => $val)
			$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);
		
		curl_close ($ch);
		
		return $server_output;
			
	}//end td_get_design_templates(
	
	function td_get_package_list(){
		
		//Saving Lead if Exist
		//$post_arr['template_id'] = filter_string($template_id);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'get-packages-pricing');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		//foreach($post_arr as $key => $val)
			//$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		return $server_output;
			
	}//end td_get_package_list()
	
	function td_verify_user_already_exist($email_address){
		
		//Saving Lead if Exist
		$post_arr['email_address'] = filter_string($email_address);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'verify-if-user-already-exist');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		foreach($post_arr as $key => $val)
			$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		return $server_output;
			
	}//end td_verify_user_already_exist()

	function get_website_branch_price(){
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'get-website-branch-price');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		//curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);
		
		//echo $server_output; exit;

		curl_close ($ch);
		
		return $server_output;
			
	}//end get_website_branch_price()
	
	function td_verify_if_pharmacy_already_purchased($hubnet_id){
		
		//Saving Lead if Exist
		$post_arr['hubnet_id'] = filter_string($hubnet_id);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'verify-if-pharmacy-already-purchased');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		foreach($post_arr as $key => $val)
			$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);
		
		//echo $server_output; exit;

		curl_close ($ch);
		
		return $server_output;
			
	}//end td_verify_pharmacy_already_exist()
	
	function td_add_website_to_order($user_id, $pharmacy_id, $post_data, $sub_total, $grand_total, $vat_amount, $vat_percentage, $CrossReference, $AuthCode, $payment_method){
		
		$ci = & get_instance();
		
		extract($post_data);
		
		/*
		$post_arr['b_first_name'] = filter_string($b_first_name);
		$post_arr['b_last_name'] = filter_string($b_last_name);
		$post_arr['b_address'] = filter_string($b_address);
		$post_arr['b_address2'] = filter_string($b_address2);
		$post_arr['b_address3'] = filter_string($b_address3);
		$post_arr['b_state'] = filter_string($b_state);
		$post_arr['b_post_town'] = filter_string($b_post_town);
		$post_arr['b_country_code'] = filter_string($b_country_code);

		$user_details = $ci->users->get_user_details($user_id);
		
		$post_arr['hubnet_user_contact_name'] = filter_string($user_details['user_full_name']);
		$post_arr['hubnet_user_mobile_no'] = filter_string($user_details['mobile_no']);
		
		$post_arr['hubnet_user_password'] = filter_string($user_details['password']);
		
		$post_arr['domain_name'] = filter_string($domain_name);
		
		*/
		
		$post_arr['user_first_name'] = 'F_Name1';
		$post_arr['user_last_name'] = 'L_Name1';
		$post_arr['hubnet_user_email_address'] = filter_string($email_address); //Coming from form

		$pharmacy_details = $ci->pharmacy->get_pharmacy_surgery_details($pharmacy_id);
		
		$post_arr['hubnet_pharmacy_id'] = filter_string($pharmacy_details['id']);
		$post_arr['hubnet_pharmacy_name'] = filter_string($pharmacy_details['pharmacy_surgery_name']);
		
		$post_arr['hubnet_pharmacy_contact'] = filter_string($pharmacy_details['contact_no']);
		$post_arr['hubnet_pharmacy_address'] = filter_string($pharmacy_details['address']);
		$post_arr['hubnet_pharmacy_postcode'] = filter_string($pharmacy_details['postcode']);
		
		$post_arr['template_id'] = filter_string($template_id);
		$post_arr['package_id'] = filter_string($package_id);
		$post_arr['no_of_branches'] = filter_string($no_of_branches);

		$post_arr['sub_total'] = filter_string($sub_total);
		$post_arr['grand_total'] = filter_string($grand_total);
		$post_arr['vat_amount'] = filter_string($vat_amount);
		$post_arr['vat_percentage'] = filter_string($vat_percentage);
		
		$post_arr['transaction_id'] = filter_string($CrossReference);
		$post_arr['auth_code'] = filter_string($AuthCode);
		$post_arr['hubnet_payment_method'] = filter_string($payment_method);
		$post_arr['hubnet_is_renewal'] = filter_string($is_renewal);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'add-website-to-order');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		foreach($post_arr as $key => $val)
			$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);
		
		//print_this($server_output); exit;

		curl_close ($ch);
		
		return $server_output;
			
	}//end td_add_website_to_order()

	function td_add_avicenna_website_to_order($user_id, $pharmacy_id, $post_data, $sub_total, $grand_total, $vat_amount, $vat_percentage, $CrossReference, $AuthCode, $payment_method){
		
		$ci = & get_instance();
		
		extract($post_data);
		
		$pharmacy_details = $ci->pharmacy->get_pharmacy_surgery_details($pharmacy_id);
		
		$post_arr['hubnet_pharmacy_id'] = filter_string($pharmacy_details['id']);
		$post_arr['hubnet_pharmacy_name'] = filter_string($pharmacy_details['pharmacy_surgery_name']);
		$post_arr['hubnet_pharmacy_contact'] = filter_string($pharmacy_details['contact_no']);
		$post_arr['hubnet_pharmacy_address'] = filter_string($pharmacy_details['address']);
		$post_arr['hubnet_pharmacy_postcode'] = filter_string($pharmacy_details['postcode']);
		
		$user_details = $ci->users->get_user_details($user_id);
		
		$post_arr['hubnet_user_contact_name'] = filter_string($user_details['user_full_name']);
		$post_arr['hubnet_user_mobile_no'] = filter_string($user_details['mobile_no']);
		$post_arr['hubnet_user_email_address'] = filter_string($email_address);
		$post_arr['hubnet_user_password'] = filter_string($user_details['password']);
		
		$post_arr['template_id'] = filter_string($tmp_id);
		$post_arr['package_id'] = filter_string($pkge_id);
		$post_arr['domain_name'] = filter_string($search_domain);

		$post_arr['sub_total'] = filter_string($sub_total);
		$post_arr['grand_total'] = filter_string($grand_total);
		$post_arr['vat_amount'] = filter_string($vat_amount);
		$post_arr['vat_percentage'] = filter_string($vat_percentage);
		
		$post_arr['hubnet_payment_method'] = filter_string($payment_method);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'add-avicenna-website-to-order'); 
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		foreach($post_arr as $key => $val)
			$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		return $server_output;
			
	}//end td_add_website_to_order()
	
		// Start - public function get_countries()
	function get_countries(){
		
		$ci =& get_instance();
		$ci->db->dbprefix('countries_worldwide');
		return $ci->db->get('countries_worldwide')->result_array();
		
	} // End - public function get_countries()
	
	//Function get_pgd_details($pgd_id): PGd details
	function get_pgd_details($pgd_id){
		
		$ci =& get_instance();
		return $ci->pgds->get_pgd_details($pgd_id);
	}//end get_pgd_details($pgd_id)

	function get_rp_details($rp_id){
		
		$ci =& get_instance();
		return $ci->repeat_prescription->get_rp_details($rp_id);
	}//end get_pgd_details($pgd_id)

	function get_paging_info($tot_rows,$pp,$curr_page){
		
		$pages = ceil($tot_rows / $pp); // calc pages
		
		$data = array(); // start out array
		$data['si']        = ($curr_page * $pp) - $pp; // what row to start at
		$data['pages']     = $pages;                   // add the pages
		$data['curr_page'] = $curr_page;               // Whats the current page
		
		return $data; //return the paging data
		
	}//end get_paging_info($tot_rows,$pp,$curr_page)	
	
	
?>