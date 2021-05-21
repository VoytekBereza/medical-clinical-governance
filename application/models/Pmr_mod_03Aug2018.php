<?php
class Pmr_mod extends CI_Model {
	
	function __construct(){
		parent::__construct();
    }

	// Start Function search_patient(): Return Patients
	public function search_patient($data){
		
		extract($data);
		
		$search_patient = $this->db->escape_str(trim($search_patient));
		
		$this->db->dbprefix('patients');
		$this->db->select("CONCAT(first_name,' ',last_name,' - ',postcode) as patient_record, id, first_name, last_name, email_address");
		$this->db->from('patients');
		$this->db->where('admin_verify_status',1);
		$this->db->where("CONCAT(first_name,' ',  last_name,' ',DATE_FORMAT(dob,'%d%m%Y')) LIKE '%$search_patient%'");
		
		return $this->db->get()->result_array();
		
	} // End - search_patient()

	// Start Function add edit patient
	public function add_edit_patient($data, $pharmacy_surgery_id, $organization_id){
	
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Generate Random code	
		$pmr_no = $this->common->random_number_generator(10);
		$email_activation_code = $this->common->random_number_generator(10);
		//Generate Random code	
		$password = $this->common->random_password_generator(10);
		
		$dob = $birth_year."-".$birth_month."-".$birth_date;
		 
		$postcode = str_replace(' ', '', $postcode); // Saving the postcode without spaces for all consistent Postcode search
		
		if(!$update_patient_id){

			$ins_data = array(
		
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'pmr_no' => $this->db->escape_str(trim($pmr_no)),
				'mobile_no' => $this->db->escape_str(trim($mobile_no)),
				'email_address' => $this->db->escape_str(trim($email_address_patient)),
				'address' => $this->db->escape_str(trim($address)),
				'address_2' => $this->db->escape_str(trim($address_2)),
				'address_3' => $this->db->escape_str(trim($address_3)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'password' => $this->db->escape_str(md5((trim($password)))),
				'email_verify_status' => $this->db->escape_str(1),
				'dob' => $this->db->escape_str($dob),
				'gender' => $this->db->escape_str($gender),
				'admin_verify_status' => $this->db->escape_str(1),
				'activation_code' => $this->db->escape_str(trim(md5($email_activation_code))),
				'discount_offers' => $this->db->escape_str($discount_offers),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);

			//Inserting Patient data into the database. 
			$this->db->dbprefix('patients');
			$ins_into_db = $this->db->insert('patients', $ins_data);
			
			$new_patient_id = $this->db->insert_id();
			
			if($ins_into_db){
				
				// Insert data into db [ Table - patient_pharmacies ]
				$insert_data = array(
				
					'patient_id' => $new_patient_id,
					'pharmacy_surgery_id' => $pharmacy_surgery_id,
					'organization_id' => $organization_id,
					'created_date' => $created_date, 
					'created_by_ip' => $created_by_ip
				);

				$this->db->dbprefix('patient_pharmacies');
				$this->db->insert('patient_pharmacies', $insert_data);
				
			} // if($ins_into_db)
			
			
			if($ins_into_db){
				
			// EMAIL SENDING CODE - START
			   
				//User data
				$user_first_last_name = ucwords(strtolower(stripslashes($first_name.' '.$last_name)));
				$email_address = stripslashes(trim($email_address_patient));

				$search_arr = array('[FIRST_LAST_NAME]','[USER_PASSWORD]','[SITE_LOGO]','[SITE_URL]');
				$replace_arr = array($user_first_last_name,$password,SITE_LOGO,SURL); 
				
				$this->load->model('email_mod','email_template');
			
			    $email_body_arr = $this->email_template->get_email_template(12);

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
				
				return $new_patient_id;

			}else{
				return false;	
			}//end if($ins_into_db)

		} else {

			//Record insert into database
		$cols = array(
		
			'first_name' => $this->db->escape_str(trim($first_name)),
			'last_name' => $this->db->escape_str(trim($last_name)),
			// 'pmr_no' => $this->db->escape_str(trim($pmr_no)),
			'mobile_no' => $this->db->escape_str(trim($mobile_no)),
			//'email_address' => $this->db->escape_str(trim($email_address_patient)),
			'address' => $this->db->escape_str(trim($address)),
			'address_2' => $this->db->escape_str(trim($address_2)),
			'address_3' => $this->db->escape_str(trim($address_3)),
			'postcode' => $this->db->escape_str(trim($postcode)),
			// 'password' => $this->db->escape_str(md5((trim($password)))),
			// 'email_verify_status' => $this->db->escape_str(1),
			'dob' => $this->db->escape_str($dob),
			'gender' => $this->db->escape_str($gender),
			//'admin_verify_status' => $this->db->escape_str(1),
			// 'activation_code' => $this->db->escape_str(trim(md5($email_activation_code))),
			'modified_date' => $this->db->escape_str(trim($created_date)),
			'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);

		//Inserting Patient data into the database. 
		$this->db->dbprefix('patients');

		$this->db->where('id', $update_patient_id);
		return $this->db->update('patients', $cols);

		}
			
	}// End add_edit_patient
	
	//Function verify_if_email_already_exist(): Verify if the email already exist before Patient registration.
	public function verify_if_email_already_exist($email_address){

		$this->db->dbprefix('patients');
		$this->db->where('email_address', filter_string($email_address));
		$get = $this->db->get('patients');
		
		if($get->num_rows() > 0)
			return true;	
		else
			return false;
		
	} // end verify_if_email_already_exist($email_address)
	
	public function get_patient_details($patient_id){
		
		// Get Patient Record
		$this->db->dbprefix('patients');
		$this->db->select('patients.*,country.country_name');
		$this->db->where('patients.id', $patient_id);
		
		$this->db->join('country', 'country.id = patients.gp_country','LEFT');
		
		return $this->db->get('patients')->row_array();
		
	} // public function get_patient_data($patient_id)

	//Function update_patient_address(): Save Patients Delivery and Billing Address
	public function get_patient_address($patient_id){

		$this->db->dbprefix('patients_addressbook');
		$this->db->where('patient_id',$patient_id);
		$get_user= $this->db->get('patients_addressbook');
		$row_arr = $get_user->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	}//end update_patient_address($patient_id,$data)
	
	//Function get_patient_pharmacies_list(): This function will return the list of pharmacies the patient already have shared the details or are part it. This will always be asked when user try to get the med or anything from a new pharamcy. 
	//$pharmacy_id is optional in case you want to check if user exist in specific pharmacy, if yes will return the row.	
	public function get_patient_pharmacies_list($patient_id,$pharmacy_surgery_id = ''){
		
		$this->db->dbprefix('patient_pharmacies');
		$this->db->select('patient_pharmacies.patient_id, org_pharmacy_surgery.organization_id,org_pharmacy_surgery.manager_id, org_pharmacy_surgery.pharmacy_surgery_name,org_pharmacy_surgery.type,org_pharmacy_surgery.id AS pharmacy_surgery_id');
		$this->db->where('patient_pharmacies.patient_id', $patient_id);
		
		if(trim($pharmacy_surgery_id) != '') {
			
			$this->db->where('patient_pharmacies.pharmacy_surgery_id', $pharmacy_surgery_id);
			$this->db->where('org_pharmacy_surgery.is_deleted', '0');
			
		}//end if(trim($pharmacy_surgery_id) != '') 
		
		$this->db->join('org_pharmacy_surgery','patient_pharmacies.pharmacy_surgery_id = org_pharmacy_surgery.id','LEFT');
		
		$get = $this->db->get('patient_pharmacies');
		//echo $this->db->last_query(); 		exit;
		
		if(trim($pharmacy_surgery_id) != '') 
			return $get->row_array();
		else
			return $get->result_array();
		
	}//end get_patient_pharmacies_list($patient_id,$pharmacy_surgery_id)
	
	//Function merge_patient_record_with_pharmacy(): This function will merge the record of a patient with 
	public function merge_patient_record_with_pharmacy($patient_id,$pharmacy_surgery_id){
		
		//Check if the record already exist in the database against patient and pharmacy.
		$check_if_patient_exist = $this->pmr->get_patient_pharmacies_list($patient_id,$pharmacy_surgery_id);
		
		if(!$check_if_patient_exist){
			//Record not found, insert	

			$created_date = date('Y-m-d G:i:s');
			$created_by_ip = $this->input->ip_address();
			
			$get_pharamcy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
			
			$organization_id = filter_string($get_pharamcy_details['organization_id']);
			
			//Record insert into database
			$ins_data = array(
			
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
				
			);
			
			//Inserting User data into the database. 
			$this->db->dbprefix('patient_pharmacies');
			$ins_into_db = $this->db->insert('patient_pharmacies', $ins_data);

		}//end if(!$check_if_patient_exist)
		
		return true;
	} //end merge_patient_record_with_pharmacy($patient_id,$pharmacy_surgery_id)
	
	//Function get_patient_history(): This function will get all the purchase Medicine (Rx, Rx-PGD, PGD) history of the patient grouped by to know what patient have bought previously. 
	//Order_status is optional, if not given will return all records. If given will return th required accoding to the order status defined. Medicine_id is optipons when given will return the record of a patient with specifix medicine!
	// P = Pending, C = Complete, DS = Dispense, DC =  Decline
	public function get_patient_history($patient_id,$order_status = '',$medicine_id = '', $is_pmr = ''){
		
		$this->db->dbprefix('patient_order_details');
		$this->db->select("patient_order_details.*, CONCAT(kod_users.first_name,' ',kod_users.last_name) as prescribed_by_name");
		$this->db->where('patient_order_details.patient_id', $patient_id);
		
		if(trim($order_status) != '')  $this->db->where('patient_order_details.order_status', $order_status);
		
		
		if(trim($medicine_id) != ''){
			
			if($is_pmr)
				$this->db->where('patient_order_details.pmr_med_id', $medicine_id);
			else
				$this->db->where('patient_order_details.medicine_id', $medicine_id);
		}
		$this->db->join('users','patient_order_details.prescribed_by = users.id','INNER');
		
		$this->db->order_by('patient_order_details.created_date', 'DESC');
		
		$get = $this->db->get('patient_order_details');
		//echo $this->db->last_query();	exit;
		
		return $get->result_array();
		
	}//end get_patient_history($patient_id,$order_status)
	
	//function get_patient_grouped_history(): Returns the groups patient (Rx, Rx-PGD, PGD) record with the most recent date when the medicine is purchased. This is used when we have to show the limited information. For detail histiry we need to use get_patient_history
	public function get_patient_grouped_history($patient_id,$order_status = '', $medicine_id = ''){

		$this->db->dbprefix('patient_order_details');
		//$this->db->distinct();
		$this->db->select("patients.first_name, patients.last_name, patient_order_details.*, CONCAT(kod_users.first_name,' ',kod_users.last_name) as prescribed_by_name");
		
		//$this->db->where('patient_order_details.patient_id', $patient_id);
		
		if(trim($order_status) != '')  $order_status_str = "AND kod_patient_order_details.order_status = '".$order_status."'";
		
		if(trim($medicine_id) != '')
			$this->db->where('medicine_id', $medicine_id);

		if(trim($patient_id) != '')
			$this->db->where('patient_order_details.patient_id', $patient_id);

		/*
		if(trim($pmr_med_id) != '')
			$this->db->where('pmr_med_id', $pmr_med_id);
		*/	
		$this->db->join('users','patient_order_details.prescribed_by = users.id','INNER');
		$this->db->join('patients','patient_order_details.patient_id = patients.id');
		
		$this->db->order_by('id','ASC');

		//$this->db->join('medicine','medicine.id = patient_order_details.medicine_id','LEFT');
		//$this->db->join('medicine_form','medicine.medicine_form_id = medicine_form.id','LEFT');
		//$this->db->join('medicine_strength','patient_order_details.strength_id = medicine_strength.id','LEFT');
		//$this->db->join('medicine_quantity','patient_order_details.qty_id = medicine_quantity.id','LEFT');
		
		//$this->db->join('(SELECT id FROM kod_patient_order_details ORDER BY id DESC) as a','patient_order_details.medicine_id = medicine.id','INNER');
		/*$this->db->where("kod_patient_order_details.id IN (
							SELECT MAX(kod_patient_order_details.id)
							FROM kod_patient_order_details
							WHERE kod_patient_order_details.patient_id = '".$patient_id."'
							$order_status_str
							GROUP BY kod_patient_order_details.medicine_id
						)");
		*/
		$get = $this->db->get('patient_order_details');
		//echo $this->db->last_query();	exit;
		
		$return = $get->result_array();
		
		//print_this($return); exit;
		
		$return_final = array();
		for($i=0 ;$i<count($return); $i++){
			
			$return_final[$return[$i]['p_medicine_short_name']]['patient_id'] = $return[$i]['patient_id'];
			$return_final[$return[$i]['p_medicine_short_name']]['medicine_id'] = $return[$i]['medicine_id'];
			$return_final[$return[$i]['p_medicine_short_name']]['pmr_med_id'] = $return[$i]['pmr_med_id'];
			
			$return_final[$return[$i]['p_medicine_short_name']]['p_medicine_name'] = $return[$i]['p_medicine_name'];
			$return_final[$return[$i]['p_medicine_short_name']]['p_medicine_short_name'] = $return[$i]['p_medicine_short_name'];
			$return_final[$return[$i]['p_medicine_short_name']]['quantity'] = $return[$i]['quantity'];
			
			$return_final[$return[$i]['p_medicine_short_name']]['p_strength_name'] = $return[$i]['p_strength_name'];
			
			$return_final[$return[$i]['p_medicine_short_name']]['p_medicine_form'] = $return[$i]['p_medicine_form'];
			$return_final[$return[$i]['p_medicine_short_name']]['p_suggested_dose'] = $return[$i]['p_suggested_dose'];
			$return_final[$return[$i]['p_medicine_short_name']]['order_type'] = $return[$i]['order_type'];
			$return_final[$return[$i]['p_medicine_short_name']]['prescribed_by_name'] = $return[$i]['prescribed_by_name'];
			$return_final[$return[$i]['p_medicine_short_name']]['created_date'] = $return[$i]['created_date'];
			$return_final[$return[$i]['p_medicine_short_name']]['med_record'][] = $return[$i];
			
		}//end for($i=0 ;$i<count($return); $i++)

		return $return_final;
		
	}//end get_patient_grouped_history($patient_id,$order_status = '')

	//Function get_patient_grouped_vaccine_history(): This function will return the list of all travel/ flu vaccines which patient have used yet.
	public function get_patient_grouped_vaccine_history($patient_id){

		$this->db->dbprefix('travel_vaccines');
		$this->db->select("travel_vaccines.vaccine_type, travel_vaccines.vaccine_name, show_type, vaccine_order_details.id, vaccine_order_details.vaccine_cat_id, vaccine_order_details.patient_id, vaccine_order_details.created_date AS recent_vaccinated_on, vaccine_brands.brand_name, CONCAT(first_name, ' ', last_name) as vaccinated_by");
		
		$this->db->where('vaccine_order_details.patient_id', $patient_id);
		$this->db->where("(travel_vaccines.show_type = 'BOTH' OR travel_vaccines.show_type = 'PMR')");
		
		$this->db->where("kod_vaccine_order_details.id IN (
							SELECT MAX(kod_vaccine_order_details.id)
							FROM kod_vaccine_order_details
							WHERE kod_vaccine_order_details.patient_id = '".$patient_id."'
							GROUP BY kod_vaccine_order_details.vaccine_cat_id
						)");

		$this->db->join('vaccine_order_details','vaccine_order_details.vaccine_cat_id = travel_vaccines.id','LEFT');
		$this->db->join('vaccine_brands','vaccine_order_details.vaccine_brand_id = vaccine_brands.id','LEFT');
		$this->db->join('users','vaccine_order_details.prescribed_by = users.id','LEFT');
		
		$get = $this->db->get('travel_vaccines');
		//echo $this->db->last_query();	exit;
		
		$result_arr = $get->result_array();
		//print_this($return);
		//exit;

		return $result_arr;
		
	}//end get_patient_grouped_vaccine_history($patient_id)

	//Function get_patient_vaccine_history(): Will return the history of a patient against specific vaccine.
	public function get_patient_vaccine_history($patient_id, $vaccine_cat_id){
		
		$this->db->dbprefix('vaccine_order_details');
		$this->db->select("vaccine_order_details.*, travel_vaccines.vaccine_name, CONCAT(kod_users.first_name,' ',kod_users.last_name) as prescribed_by_name, vaccine_brands.brand_name");
		
		$this->db->where('vaccine_order_details.patient_id', $patient_id);
		$this->db->where('vaccine_order_details.vaccine_cat_id', $vaccine_cat_id);
		
		$this->db->join('travel_vaccines','travel_vaccines.id = vaccine_order_details.vaccine_cat_id','LEFT');
		$this->db->join('vaccine_brands','vaccine_order_details.vaccine_brand_id = vaccine_brands.id','LEFT');
		$this->db->join('users','vaccine_order_details.prescribed_by = users.id','INNER');
		
		$this->db->order_by('vaccine_order_details.created_date', 'DESC');
		
		$get = $this->db->get('vaccine_order_details');
		//echo $this->db->last_query();	exit;
		
		$result = $get->result_array();
		
		return $result;
		
	}//end get_patient_vaccine_history($patient_id)
	
	// Start - public function save_prescription($prescription)
	public function save_prescription($pharmacy_surgery_id, $organization_id, $user_id, $prescription, $prescription_no){
		
		// extract POST data
		//extract($prescription);
		
		$created_date = date('Y-m-d H:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$user_details = $this->users->get_user_details($user_id);
		
		$organization_arr = $this->organization->get_organization_details($organization_id);

		$organization_address = filter_string($organization_arr['address']);
		$organization_address .= ', '.filter_string($organization_arr['postcode']);

		$pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
		
		$pharmacy_address = filter_string($pharmacy_details['address']);
		$pharmacy_address .= ', '.filter_string($pharmacy_details['postcode']);
		
		$patient_id = $prescription['patient_id'];
		
		$patient_details = $this->get_patient_details($patient_id);
		$patient_full_name = filter_name($patient_details['first_name'].' '.$patient_details['last_name']);
		
		$patient_address = filter_string($patient_details['address']).', '.filter_string($patient_details['postcode']);
		
		$get_patient_address = $this->get_patient_address($patient_id);

		$billing_address = filter_string($get_patient_address['b_address']);
		$billing_address .= (filter_string($get_patient_address['b_address2'])) ? ', '.filter_string($get_patient_address['b_address2']) : '' ;
		$billing_address .= (filter_string($get_patient_address['b_post_town'])) ? ', '.filter_string($get_patient_address['b_post_town']) : '' ;
		$billing_address .= (filter_string($get_patient_address['b_postcode'])) ? ', '.filter_string($get_patient_address['b_postcode']) : '' ;
		$billing_address .= (filter_string($get_patient_address['b_state'])) ? ', '.filter_string($get_patient_address['b_state']) : '' ;
		

		$delivery_address = filter_string($get_patient_address['d_address']);
		$delivery_address .= (filter_string($get_patient_address['d_address2'])) ? ', '.filter_string($get_patient_address['d_address2']) : '' ;
		$delivery_address .= (filter_string($get_patient_address['d_post_town'])) ? ', '.filter_string($get_patient_address['d_post_town']) : '' ;
		$delivery_address .= (filter_string($get_patient_address['d_postcode'])) ? ', '.filter_string($get_patient_address['d_postcode']) : '' ;
		$delivery_address .= (filter_string($get_patient_address['d_state'])) ? ', '.filter_string($get_patient_address['d_state']) : '' ;

		$gp_address = filter_string($patient_details['gp_address']);
		$gp_address .= (filter_string($patient_details['gp_address2'])) ? ', '.filter_string($patient_details['gp_address2']) : '' ;
		$gp_address .= (filter_string($patient_details['gp_post_town'])) ? ', '.filter_string($patient_details['gp_post_town']) : '' ;
		$gp_address .= (filter_string($patient_details['gp_postcode'])) ? ', '.filter_string($patient_details['gp_postcode']) : '' ;
		$gp_address .= (filter_string($patient_details['gp_state'])) ? ', '.filter_string($patient_details['gp_state']) : '' ;
		
		//print_this($prescription); 		exit;
		
		//Inserting Record into the Patient Order Details
		$ins_data = array(
		
			'prescription_no' => $this->db->escape_str(trim($prescription_no)),
			'patient_id' => $this->db->escape_str(trim($patient_id)),
			'purchased_by_id' => $this->db->escape_str(trim($user_id)),
			'order_type' => "PMR",
			'purchase_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);

		//Inserting User data into the database. 
		$this->db->dbprefix('patient_orders');
		$ins_into_db = $this->db->insert('patient_orders', $ins_data);
		
		$order_id = $this->db->insert_id();
		
		//foreach($prescription['transaction']['medicine_id'] as $index => $med_id)
		for($i = 0; $i<count($prescription['transaction']['medicine_id']); $i++){
			
			$med_id = $prescription['transaction']['medicine_id'][$i];
			$medicine_details = $this->medicine->get_medicine_by('', $med_id);
			
			//print_this($medicine_details); exit;
			$medicine_name = filter_string($prescription['transaction']['medicine_full_name'][$i]);
			$medicine_strength = filter_string($prescription['transaction']['strength'][$i]);
			$medicine_strength_id = filter_string($prescription['transaction']['medicine_strength_id'][$i]);
			
			$medicine_quantity = filter_string($prescription['transaction']['qty'][$i]);
			$medicine_form = filter_string($prescription['transaction']['medicine_form'][$i]);
			
			$p_medicine_name = $medicine_name.' '.$medicine_strength.' '.$medicine_quantity.' '.$medicine_form;
			
			$prescription_data = array(
			
				'prescription_no' => $this->db->escape_str(trim($prescription_no)),
				'order_id' => $this->db->escape_str(trim($order_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'pmr_med_id' => $this->db->escape_str(trim($med_id)),
				'p_medicine_name' => $this->db->escape_str(trim($p_medicine_name)),
				'p_medicine_short_name' => $this->db->escape_str(trim($medicine_name)),
				'p_medicine_form' => $this->db->escape_str(trim($medicine_form)),
				'p_suggested_dose' => $this->db->escape_str(trim($prescription['transaction']['suggested_dose'][$i])),
				'suggested_dose' => $this->db->escape_str(trim($prescription['transaction']['suggested_dose'][$i])),
				
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'p_pharmacy_name' => $this->db->escape_str(trim($pharmacy_details['pharmacy_surgery_name'])),
				'p_pharmacy_contact_no' => $this->db->escape_str(trim($pharmacy_details['contact_no'])),
				'p_pharmacy_address' => $this->db->escape_str(trim($pharmacy_address)),
				
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'p_organization_name' => $this->db->escape_str(trim($organization_arr['company_name'])),
				'p_organization_address' => $this->db->escape_str(trim($organization_address)),
				'p_organization_contact_no' => $this->db->escape_str(trim($organization_arr['contact_no'])),

				'p_patient_name' => $this->db->escape_str(trim($patient_full_name)),
				'p_patient_dob' => $this->db->escape_str(trim($patient_details['dob'])),
				'p_patient_gender' => $this->db->escape_str(trim($patient_details['gender'])),
				'p_patient_contact_no' => $this->db->escape_str(trim($patient_details['mobile_no'])),
				'p_patient_address' => $this->db->escape_str(trim($patient_address)),
				'p_patient_billing_address' => $this->db->escape_str(trim($billing_address)),
				'p_patient_delivery_address' => $this->db->escape_str(trim($delivery_address)),

				'p_gp_doctor' => $this->db->escape_str(trim($patient_details['gp_doctor'])),
				'p_gp_practice_name' => $this->db->escape_str(trim($patient_details['gp_practice_name'])),
				'p_gp_address' => $this->db->escape_str(trim($gp_address)),
				
				'prescribed_by' => $this->db->escape_str(trim($user_id)),
				'p_prescriber_name' => $this->db->escape_str(trim(filter_name($user_details['user_full_name']))),
				'p_prescriber_reg_no' => $this->db->escape_str(trim(filter_string($user_details['registration_no']))),
				'p_prescriber_email' => $this->db->escape_str(trim(filter_string($user_details['email_address']))),
				'p_prescriber_contact_no' => $this->db->escape_str(trim(filter_string($user_details['mobile_no']))),
				
				'quantity' => $medicine_quantity,
				
				/*'strength_id' => $this->db->escape_str(trim($medicine_strength_id)),*/
				'p_strength_name' => $this->db->escape_str(trim($medicine_strength)),
				
				'medicine_class' => $this->db->escape_str(trim($prescription['transaction']['medicine_class'][$i])),
				
				'order_type' => "PMR",
				'order_status' => 'C',
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			);
			
			// save prescription : Insert data into db [ Table - patient_order_details ]
			$this->db->dbprefix('patient_order_details');
			$saved = $this->db->insert('patient_order_details', $prescription_data);
			
		} // foreach($medicine_id as $index => $each)
		
		if($saved)
			return true;
		else
			return false;
		//if($saved)
			
	} // public function save_prescription($prescription)
	
	# Function get_organization_transactions(): Will return the order details/ transactions of the organization/ pharmacies depending on the order status
	#   organization_id = Organization ID of which we need the transaction record for.
	#   pharmacy_surgery_id = will always be there when there will be user_type. if it is empty will return record of complete organization
	#	patient_id = To get the record of the specific patient
	#   order_status = return results according to the transaction status, pending, dispensed, complete etc
	#   medicine_class = Empty means Both Rx and Rx-PGD, otherwise will return record according to the class defined.
	#   product_type = It can be either vaccine or medicne V or M
	#	order_type = PMR or ONLINE, empty will return both
	
	/*
		If Doctor
			PMR RX, No Dispense
		If Pharmacist/ Prescriber
			PMR RX, Dispense (RX, PGD)
		If Pharmacist/ Non Prescriber
			Walk in PGD's, Dispense (RX, PGD)
		If Nurse/ Prescriber
			PMR, No Dispense
		If Nurse/ Non Prescriber
			PMR with Walk in PGD's. No Dispense
		Default Prescriber
			Show Online PMR, Walk-In PMR RX, Dispense if is a Pharmcist, Current deliveries if Pharmacist
	*/
	
	public function get_organization_transactions($organization_id, $pharmacy_surgery_id = '', $patient_id = '', $order_status = '', $medicine_class = '', $product_type = '', $order_type = '', $show_all_records = '', $patient_order_id = ''){

		$this->db->dbprefix('patient_order_details');
		$this->db->select('patient_order_details.*, medicine.medicine_name, CONCAT("","",medicine_name) as medicine_full_name, org_pharmacy_surgery.pharmacy_surgery_name, CONCAT (first_name," ", last_name) AS patient_name, medicine_quantity.quantity_txt, medicine_strength.strength, medicine_form.medicine_form');
		
		if(trim($order_status) != '') $this->db->where('patient_order_details.order_status',$order_status);
		if(trim($medicine_class) != '') $this->db->where('patient_order_details.medicine_class',$medicine_class);  //Both

		$this->db->where('patient_order_details.organization_id',$organization_id);
		
		if(trim($pharmacy_surgery_id)!=''){
			$this->db->where('patient_order_details.pharmacy_surgery_id',$pharmacy_surgery_id);  //Pharmacy Surgery ID
			$this->db->where('org_pharmacy_surgery.is_deleted','0'); 
		}//end if(trim($pharmacy_surgery_id)!='') 
		
		if(trim($patient_id)!='') $this->db->where('patient_order_details.patient_id',$patient_id); //Patient Id
		if(trim($product_type) != '') $this->db->where('patient_order_details.product_type',$product_type);  //Product Type
		if(trim($order_type) != '') $this->db->where('patient_order_details.order_type',$order_type);  //Order type

		if(trim($patient_order_id) != '') $this->db->where('patient_order_details.order_id',$patient_order_id);  // Order ID
		
		$this->db->join('medicine','medicine.id = patient_order_details.medicine_id ','LEFT'); //Medicine
		$this->db->join('medicine_quantity','medicine_quantity.id = patient_order_details.qty_id ','LEFT'); //Medicine Quantity
		$this->db->join('medicine_strength','medicine_strength.id = patient_order_details.strength_id ','LEFT'); //Medicine Strength
		$this->db->join('medicine_form','medicine_form.id = medicine.medicine_form_id ','LEFT'); //Medicine Form
		
		$this->db->join('org_pharmacy_surgery','org_pharmacy_surgery.id = patient_order_details.pharmacy_surgery_id ','LEFT'); //Pharmacy Join
		$this->db->join('patients','patients.id = patient_order_details.patient_id ','LEFT'); //Patient Join
		
		$this->db->order_by('created_date','DESC');

		if($show_all_records == '') $this->db->limit(10);
		
		$get = $this->db->get('patient_order_details');
		
		//echo $this->db->last_query(); 		exit;

		$result_arr = $get->result_array();
		
		$final_result_arr = array();
		
		for($i=0;$i<count($result_arr);$i++){
			
			$final_result_arr[$i] = $result_arr[$i];
			
			if($result_arr[$i]['product_type'] == 'M'){
				//$final_result_arr[$i]['raf'] = $this->pmr->get_patient_medicine_raf($result_arr[$i]['patient_id'],$result_arr[$i]['medicine_id'],'');
			}else{
				//$final_result_arr[$i]['raf'] = $this->pmr->get_patient_medicine_raf($result_arr[$i]['patient_id'],'',$result_arr[$i]['vaccine_id']);
			}//end if($result_arr[$i]['product_type'] == 'M')
			
		}//end for($i=0;$i<count($result_arr)$i++)
		
		return $final_result_arr;

	}//end get_organization_transactions($organization_id,$pharmacy_surgery_id='',$order_status = 'P', $can_despense = '1',$medcine_class = '') 
	
	
		
	public function get_organization_transactions_all_request($organization_id, $pharmacy_surgery_id = '', $patient_id = '', $order_status = '', $medicine_class = '', $product_type = '', $order_type = '', $show_all_records = ''){
		
		$this->db->dbprefix('patient_order_details');
		$this->db->select('patient_order_details.*, medicine.medicine_name, CONCAT("","",medicine_name) as medicine_full_name, org_pharmacy_surgery.pharmacy_surgery_name, CONCAT (first_name," ", last_name) AS patient_name, medicine_quantity.quantity_txt, medicine_strength.strength, medicine_form.medicine_form');
		
		if(trim($order_status) != '') $this->db->where('patient_order_details.order_status',$order_status);
		if(trim($medicine_class) != '') $this->db->where('patient_order_details.medicine_class',$medicine_class);  //Both

		$this->db->where('patient_order_details.organization_id',$organization_id);
		
		if(trim($pharmacy_surgery_id)!='') {
			$this->db->where('patient_order_details.pharmacy_surgery_id',$pharmacy_surgery_id);  //Pharmacy Surgery ID
			$this->db->where('org_pharmacy_surgery.is_deleted','0'); 
		}//end if(trim($pharmacy_surgery_id)!='') 
		
		if(trim($patient_id)!='') $this->db->where('patient_order_details.patient_id',$patient_id); //Patient Id
		if(trim($product_type) != '') $this->db->where('patient_order_details.product_type',$product_type);  //Product Type
		if(trim($order_type) != '') $this->db->where('patient_order_details.order_type',$order_type);  //Order type

		$this->db->join('medicine','medicine.id = patient_order_details.medicine_id ','LEFT'); //Medicine
		$this->db->join('medicine_quantity','medicine_quantity.id = patient_order_details.qty_id ','LEFT'); //Medicine Quantity
		$this->db->join('medicine_strength','medicine_strength.id = patient_order_details.strength_id ','LEFT'); //Medicine Strength
		$this->db->join('medicine_form','medicine_form.id = medicine.medicine_form_id ','LEFT'); //Medicine Form
		
		$this->db->join('org_pharmacy_surgery','org_pharmacy_surgery.id = patient_order_details.pharmacy_surgery_id ','LEFT'); //Pharmacy Join
		$this->db->join('patients','patients.id = patient_order_details.patient_id ','LEFT'); //Patient Join
		
		$this->db->order_by('created_date','DESC');
		
		$get = $this->db->get('patient_order_details');
		//echo $this->db->last_query(); 		exit;

		$result_arr = $get->result_array();
		
		$final_result_arr = array();
		
		for($i=0;$i<count($result_arr);$i++){
			
			$final_result_arr[$i] = $result_arr[$i];
			
			if($result_arr[$i]['product_type'] == 'M'){
				//$final_result_arr[$i]['raf'] = $this->pmr->get_patient_medicine_raf($result_arr[$i]['patient_id'],$result_arr[$i]['medicine_id'],'');
			}else{
				//$final_result_arr[$i]['raf'] = $this->pmr->get_patient_medicine_raf($result_arr[$i]['patient_id'],'',$result_arr[$i]['vaccine_id']);
			}//end if($result_arr[$i]['product_type'] == 'M')
			
		}//end for($i=0;$i<count($result_arr)$i++)
		
		return $final_result_arr;

	}//end get_organization_transactions($organization_id,$pharmacy_surgery_id='',$order_status = 'P', $can_despense = '1',$medcine_class = '') 

	//Function delete_patient_raf(): This will delete the existing RAF if exist of the patient againt Medicine ID or Vaccine ID
	public function get_patient_medicine_raf($patient_id, $medicine_id = '',$vaccine_id = ''){
		
		 $this->db->dbprefix('patients_raf_history');
		 $this->db->select('patients_raf_history.patient_id, patients_raf_history.medicine_id, patients_raf_history.vaccine_id, patients_raf_history.raf_id, patients_raf_history.answer');
		 
		 if(trim($medicine_id) != ''){
			 
			$this->db->select('medicine_raf.question as med_question');
		 	$this->db->where('patients_raf_history.medicine_id',$medicine_id);
			$this->db->join('medicine_raf','patients_raf_history.raf_id = medicine_raf.id');
			
		 }//end if(trim($medicine_id) != '')
		 
		 if(trim($vaccine_id) != ''){
			 
			$this->db->select('vaccine_raf.question as vaccine_question');
			$this->db->where('patients_raf_history.vaccine_id',$vaccine_id);
			$this->db->join('vaccine_raf','patients_raf_history.raf_id = vaccine_raf.id');
			
		 }//end if(trim($vaccine_id) != '')
		 
		 $this->db->from('patients_raf_history');
		 $this->db->where('patient_id',$patient_id);
		 
		 $get = $this->db->get();
		 $result = $get->result_array();
		 //echo $this->db->last_query(); exit;
		 
		 return $result;
		
	}//end delete_patient_raf($patient_id, $medicine_id = '',$vaccine_id = '')
	
	public function generate_prescription_no(){

		$new_ref_no = strtoupper($this->common->random_number_generator(16));
		
		$this->db->dbprefix('patient_orders');
		$this->db->select('prescription_no');
		
		$this->db->where('prescription_no',$new_ref_no);
		$this->db->group_by('prescription_no');
		
		$get = $this->db->get('patient_orders');
		//echo $this->db->last_query(); 		exit;
		
		if($get->num_rows > 0)
			$this->generate_prescription_no();
		else
			return $new_ref_no;
	} //end generate_survey_reference_no()

	// Function user_already_a_default_prescriber(): This function ensures if the user is already a default prescriber to any organization. If YES, returns the Organization ID.
 	public function get_organization_default_prescriber($organization_id = '', $pharmacy_id = ''){
  
	  	if(trim($organization_id) != '') {

			$this->db->dbprefix('organization');
			$this->db->select('default_prescriber');
			$this->db->from('organization');
			$this->db->where('id',$organization_id);
			$get = $this->db->get();
			$row = $get->row_array();

		}//end if(trim($organization_id) != '' 

		if($pharmacy_id != ''){

			$get_pharamcy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_id);
			$organization_id = $get_pharamcy_details['organization_id'];

			$this->db->dbprefix('organization');
			$this->db->select('default_prescriber');
			$this->db->from('organization');
			$this->db->where('id',$organization_id);
			$get = $this->db->get();
			$row = $get->row_array();

		}//end if($pharmacy_id != '')
		  
	  	return $row['default_prescriber'];
		  
	} // End get_organization_default_prescriber($organization_id = '', $pharmacy_id = '')

	 //Function get_default_prescriber_organization_list(): This function will return the list of organization where user actuallye belongs as a default prescriber.
	 public function get_default_prescriber_organization_list($user_id, $organization_id=''){
	  
		$this->db->dbprefix('organization');
		$this->db->select('id, company_name');
		$this->db->from('organization');
		$this->db->where('default_prescriber',$user_id);
		if($organization_id) $this->db->where('id',$organization_id);
		$get = $this->db->get();
		
		$result = $get->result_array();
		
		return $result;
	  
	 }//end get_default_prescriber_organization_list($user_id)

	 // Start - public function update_patient_allergies($alleries_text)
	 public function update_patient_allergies($allergies_text, $patient_id){

	 	$this->db->dbprefix('patients');
	 	$this->db->where('id', $patient_id);
	 	
	 	return $this->db->update('patients', array('allergies' => $this->db->escape_str(nl2br(trim($allergies_text))) ));

	 } // public function update_patient_allergies($alleries_text)
	 
	 // Function get_pmr_organization_pharmacy_list: Returns the list of Organization where user belongs as default prescriber and pharmacies where act as a staff
	 public function get_pmr_organization_pharmacy_list($user_id, $organization_id=''){
		 
		$org_pharmacy_list = array();
		
		//Grab list of all Organization where this user is acting as a default Prescriber
		$default_prescriber_organization_list = $this->pmr->get_default_prescriber_organization_list($user_id, $organization_id);
		$org_pharmacy_list['organization_list'] = $default_prescriber_organization_list;
		
		//Grab List of all Pharamcies where This user is acting as a Staff Member
		$get_user_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries($user_id, '', $organization_id);
		
		//The pharamcies list should not have the list in which  they are already acting as a Default Prescriber
		
		for($i=0;$i<count($get_user_pharmacies_surgeries);$i++){
			$index_key = array_search(filter_string($get_user_pharmacies_surgeries[$i]['organization_id']), array_column($default_prescriber_organization_list, 'id'));

			if(strlen($index_key) == 0)
				$org_pharmacy_list['pharmacy_list'][] = $get_user_pharmacies_surgeries[$i];
			
		}//end for($i=0;$i<count($get_user_pharmacies_surgeries);$i++)
		return $org_pharmacy_list;
		 
	 }//end get_pmr_organization_pharamcy_list($user_id)

	//Function get_patient_order_item_details(): This will return array of products being purchased by the patient.
	public function get_patient_order_item_details($order_item_id){

	$this->db->dbprefix('patient_order_details');
	$this->db->where('id',$order_item_id);
	$get = $this->db->get('patient_order_details');
	//echo $this->db->last_query(); 	 exit;
	$row_arr = $get->row_array();

	// print_this($row_arr);
	// exit;

	return $row_arr;

	}//end get_patient_order_item_details($order_item_id)

	// Start - public function dispense_transaction($data)
	public function dispense_transaction($data){

		extract($data);
    	$upd = array('tracking_code' => $tracking_code, 'order_status' => 'C');

    	$this->db->dbprefix(patient_order_details);
    	$this->db->where('id', $order_detail_id);
    	
    	return $this->db->update('patient_order_details', $upd);

	} // End -  public function dispense_transaction($data)

	// Start - public function decline_transaction($post)
	public function decline_transaction($post){

		extract($post);
		// [decline_text] => asfd
    	// [order_detail_id] => 78

		$this_ip_address = $this->input->ip_address();
		$date_now = date('Y-m-d H:i:s');

    	// $this->session->full_name
    	// medicine name
    	// patient ID and Name
    	
    	// Prepare notification text
    	//$notification_txt = "Prescriber “Dr. Ali Khan” has declined the medicine “Viagra 25mg” for Patient “232 - Haseeb Ur Rehman” against prescription number “PJHJ7987” due to Reason below: “The patient has low blood pressure issues and is not allowed to have this medicine”";

    	$this->db->dbprefix('patient_order_details');
    	
    	$this->db->select('patient_order_details.prescription_no,  patients.id as patient_id, CONCAT(kod_patients.first_name," ",kod_patients.last_name) AS patient_name, medicine.medicine_name, medicine_strength.strength');
    	
    	$this->db->from('patient_order_details');
    	$this->db->join('patients', ' patient_order_details.patient_id = patients.id ');
    	$this->db->join('medicine', ' patient_order_details.medicine_id = medicine.id ');
    	$this->db->join('medicine_strength', ' medicine_strength.medicine_id = medicine.id ');

    	$this->db->where('patient_order_details.id', $order_detail_id);

    	$order_details = $this->db->get()->row_array();

    	// [prescription_no] => K9QBW96
    	// [patient_id] => 10
    	// [patient_name] => Haseeb Ur Rehman
    	// [medicine_name] => Spedra
    	// [strength] => 50 mg

    	$notification_txt = 'Prescriber <strong>“'.$this->session->full_name.'”</strong> has declined the medicine <strong>“'.$order_details['medicine_name'].' '.$order_details['strength'].'”</strong> for Patient <strong>“'.$order_details['patient_id'].' - '.$order_details['patient_name'].'”</strong> against prescription number <strong>“'.$order_details['prescription_no'].'”</strong> due to Reason below: <br />“'.$decline_text.'”';

    	// Insert notification
    	$insert_data = array('notification_txt' => $notification_txt, 'created_date' => $date_now, 'created_by_ip' => $this_ip_address);
    	$this->db->dbprefix('admin_notifications');
    	$this->db->insert('admin_notifications', $insert_data);

    	// Change order state to (DC - Decline) from (P - Pending)
		$update_data = array('order_status' => 'DC');
    	$this->db->dbprefix('patient_order_details');
    	$this->db->where('id', $order_detail_id);
    	
    	return $this->db->update('patient_order_details', $update_data);

	} // End - public function decline_transaction($post)

	// Start - public function get_rx_download_body($order_detail_id)
	public function get_rx_download_body($order_detail_id){

    	$this->db->dbprefix('email_templates');
    	$this->db->where('id', 11);
    	$preview = $this->db->get('email_templates')->row_array();

    	return $preview;

	} // End - public function get_rx_download_body($order_detail_id)

	// Start - public function get_order_details()
	public function get_order_details($order_detail_id){

		$this->db->dbprefix('patient_order_details');
		$this->db->from('patient_order_details');
    	$this->db->join('patients', ' patient_order_details.patient_id = patients.id ');
    	$this->db->join('medicine', ' patient_order_details.medicine_id = medicine.id ');
    	$this->db->join('medicine_form', ' medicine_form.id = medicine.medicine_form_id ');
    	$this->db->join('medicine_strength', ' medicine_strength.medicine_id = medicine.id ');
    	
    	$this->db->where('patient_order_details.id', $order_detail_id);

    	return $this->db->get()->row_array();

	} // End - public function get_order_details()

	// Start - public function mark_transaction_complete($order_id)
	public function mark_transaction_complete($order_id){

		$upd_arr = array('order_status' => "DS");

		$this->db->dbprefix('patient_order_details');
		$this->db->where('id', $order_id);
		
		return $this->db->update('patient_order_details', $upd_arr);

	} // End - public function mark_transaction_complete($order_id)

	// Start - public function save_walkin_pgd($raf_answer, $post)
	public function save_walkin_pgd($patient_id, $pharmacy_surgery_id, $organization_id, $user_id, $data){

		// Extract POST data
		extract($data);

		// print_this($data);
		// exit;
		$created_date = date('Y-m-d H:i:s');
		$created_by_ip = $this->input->ip_address();

		if($is_branded_id && $is_branded_id != '')
			$medicine_id = $is_branded_id;
		
		// if($is_branded_id && $is_branded_id != '')

		$subtotal = '0.00';
		$shipping_cost = '0.00';
		$grand_total = '0.00';

		// $prescription_no = $this->generate_prescription_no(); //Prescriptin no.

		// Inserting Record into the Patient Order Details
		$ins_data = array(
		
			'prescription_no' => $this->db->escape_str(trim($prescription_no)),
			'patient_id' => $this->db->escape_str(trim($patient_id)),
			'purchased_by_id'=> $this->db->escape_str(trim($user_id)),
			'subtotal' => $this->db->escape_str(trim(number_format($subtotal,2))),
			'shipping_cost' => $this->db->escape_str(trim($shipping_cost)),
			'grand_total' =>  $this->db->escape_str(trim($grand_total)),
			'order_type' => "PMR",
			'purchase_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),

		);

		// Inserting User data into the database.
		$this->db->dbprefix('patient_orders');
		$ins_into_db = $this->db->insert('patient_orders', $ins_data);
		
		$order_id = $this->db->insert_id();
		
		$qty_exploded = explode('|', $qty);

		$order_details = array(
		
			'prescription_no' => $this->db->escape_str(trim($prescription_no)),
			'order_id' => $this->db->escape_str(trim($order_id)),
			'patient_id' => $this->db->escape_str(trim($patient_id)),
			'medicine_id' => $this->db->escape_str(trim($medicine_id)),
			'medicine_cat_id' => $this->db->escape_str(trim($medicine_cat_id)),
			'pharmacy_surgery_id' => $this->db->escape_str($pharmacy_surgery_id),
			'organization_id' => $this->db->escape_str(trim($organization_id)), 
			'prescribed_by' => $this->db->escape_str(trim($user_id)),
			'qty_id' => $qty_exploded[0],
			'quantity' => $qty_exploded[1],
			'strength_id' => $this->db->escape_str(trim($strength_id)),
			'medicine_class' => $medicine_class,
			'order_type' => "PMR",
			'order_status' => 'C',
			'is_pgd' => $this->db->escape_str('1'),
			'suggested_dose' => $this->db->escape_str(trim($suggested_dose)),
			'notes' => $this->db->escape_str(trim($notes)),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip))

		);
		
		// save prescription : Insert data into db [ Table - patient_order_details ]
		$this->db->dbprefix('patient_order_details');
		$saved = $this->db->insert('patient_order_details', $order_details);
		
		$pgd_order_new_id = $this->db->insert_id(); //Use for Consent email

		//RAF INSERTION INTO DATABASE.
		if( count($answer_question) > 0){
			
			$delete_previous_patient_raf = $this->delete_patient_raf($patient_id,'','',$medicine_cat_id);
			
			foreach($answer_question as $raf_id => $raf_answer){

				$raf_ins_data = array(
								'patient_id' => $this->db->escape_str(trim($patient_id)),
								'medicine_id' => $this->db->escape_str(trim($medicine_id)),
								'medicine_cat_id' => $this->db->escape_str(trim($medicine_cat_id)),
								'raf_id' => $this->db->escape_str(trim($raf_id)),
								'answer' => $this->db->escape_str(trim($raf_answer)),
								'created_date' => $this->db->escape_str(trim($created_date)),
								'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
							);

				$this->db->dbprefix('patients_raf_history');
				$ins_into_db = $this->db->insert('patients_raf_history', $raf_ins_data);
				
			} // End - foreach($answer_question as $raf_id => $raf_answer)
			
		}// End - if( count($answer_question) > 0)

		//Sending Consent form in email to the Patient		
		$get_patient_details = $this->get_patient_details($patient_id);
		
		$patient_email = filter_string($get_patient_details['email_address']);

		$this->load->model('email_mod','email_template');
		
		$email_body_arr = $this->email_template->get_email_template(16);

		$email_subject = $email_body_arr['email_subject'];

		$email_body = $email_body_arr['email_body'];
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
		
		$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
		$noreply_email = get_global_settings($NOREPLY_EMAIL);
		
		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
		$from = filter_string($noreply_email['setting_value']);
		$from_name = filter_string($email_from_txt['setting_value']);
		
		$subject = filter_string($email_subject);
		$email_body = filter_string($email_body);

		$consent_link = SURL."consent/consent-agreement?pid=".($patient_id)."&t=P&consent=".base64_encode($pgd_order_new_id);

		$search_arr = array('[CONSENT_AGREE_LINK]','[SITE_LOGO]','[SITE_URL]');
		$replace_arr = array($consent_link,SITE_LOGO,SURL); 
		
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
		
		// Call from Helper send_email function
		$send_email = kod_send_email($from, $from_name, $patient_email, $subject, $email_body, '');

		return true;

	} // End - public function save_walkin_pgd($raf_answer, $post)
	
	//
	public function save_walkin_vaccine($patient_id, $pharmacy_surgery_id, $organization_id, $prescribed_by, $data){

		// Extract POST data
		extract($data);

		$created_date = date('Y-m-d H:i:s');
		$created_by_ip = $this->input->ip_address();

		$vaccine_id = ($vaccine_type == 'F') ? 1 : 2;
		
		if($vaccine_id == 2 && $medicine){

			if($is_branded_id && $is_branded_id != '')
				$medicine_id = $is_branded_id; //If medicine is marked as branded
			// if($is_branded_id && $is_branded_id != '')
			
			$qty_err = explode('|',$qty);
			
			$quantity_id = $qty_err[0]; 
			$quantity = $qty_err[1];
			
		}//end if($vaccine_id == 2 && $medicine)
		
		$extra_advice_str = (is_array($extra_advice)) ? implode('|',$extra_advice) : ''; //Extra Advise String
		
		if(!$previous_order_detail_id){
			
			//Its a PMR Request
			// $prescription_no = $this->generate_prescription_no(); //Prescriptin no.
	
			$subtotal = '0.00';
			$shipping_cost = '0.00';
			$grand_total = '0.00';
			
			$vaccine_order_new_ids =  array();
			$patient_order_ins_data = array();
			
			if($vaccine_id == 2){
				//Travel
				$destination_list = implode('#',$travel_country);
				
				for($i=0;$i<count($arrival_date);$i++)
					$arrival_dates .= date('Y-m-d',strtotime($arrival_date[$i])).'#';
				//end for($i=0;$i<count($arrival_date);$i++)
				
				$arrival_dates = rtrim($arrival_dates,'#');
				
				$patient_order_ins_data = array(
											'destinations_list' => $this->db->escape_str($destination_list),
											'arrival_dates' => $arrival_dates
										);
				
			}//end if($vaccine_id ==2)
			
			if(count($vaccine) > 0){
				
				for($i=0;$i<count($vaccine);$i++)  
					$subtotal+=$price[$i];   //Vaccine Price Subtotal
				//end foreach($medicine_purchase_arr as $key => $medicine_arr)
				
				//echo $shipping_cost;
				$grand_total =  number_format($subtotal + $shipping_cost,2);
			}//end if(count($medicine_purchase_arr) > 0)
			
			//Inserting Record into the Patient Order Details
			$ins_data = array(
			
				'prescription_no' => $this->db->escape_str(trim($prescription_no)),
				'purchased_by_id' => $this->db->escape_str(trim($prescribed_by)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'subtotal' => $this->db->escape_str(trim(number_format($subtotal,2))),
				'shipping_cost' => $this->db->escape_str(trim($shipping_cost)),
				'grand_total' =>  $this->db->escape_str(trim($grand_total)),
				'order_type' => "PMR",
				'inform_gp' => 'N',
				'purchase_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Inserting ORDER data into the database. 
			$this->db->dbprefix('patient_orders');
			$ins_into_db = $this->db->insert('patient_orders', $ins_data);
			
			$order_id = $this->db->insert_id();

			//INSERTING VACCINE Record INTO THE DATABASE
			if(count($vaccine) > 0){
				
				for($i=0;$i<count($vaccine);$i++){
					
					$prescription_ins_data = array(
	
						'prescription_no' => $this->db->escape_str(trim($prescription_no)),
						'order_id' => $this->db->escape_str(trim($order_id)),
						'patient_id' => $this->db->escape_str(trim($patient_id)),
						'pharmacy_surgery_id' => $this->db->escape_str($pharmacy_surgery_id),
						'organization_id' => $this->db->escape_str(trim($organization_id)),
						'vaccine_id' => $this->db->escape_str(trim($vaccine_id)),
						'order_type' => "PMR",
						'order_status' => 'C',
						'product_type' => $this->db->escape_str('V'),
						'subtotal' => $this->db->escape_str(trim($price[$i])),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					
					// save prescription : Insert data into db [ Table - patient_order_details ]
					$this->db->dbprefix('patient_order_details');
					
					$prescription_ins_data = array_merge($prescription_ins_data,$patient_order_ins_data);
					
					$ins_order_details = $this->db->insert('patient_order_details', $prescription_ins_data);
					
					$order_detail_id = $this->db->insert_id();
					$expiry_date = date('Y-m-d',strtotime($expiry_date[$i])); // Expiry date vaccine
					
					//Inserting Vaccine Record into Patient Vaccine Order List
					$vaccine_order_data = array(
					
						'vaccine_type' => $this->db->escape_str(trim($vaccine_type)),
						'order_detail_id' => $this->db->escape_str(trim($order_detail_id)),
						'patient_id' => $this->db->escape_str(trim($patient_id)),
						'pharmacy_surgery_id' => $this->db->escape_str($pharmacy_surgery_id),
						'organization_id' => $this->db->escape_str(trim($organization_id)),
						'prescribed_by' => $this->db->escape_str(trim($prescribed_by)),
						'vaccine_cat_id' => $this->db->escape_str(trim($vaccine[$i])),
						'vaccine_brand_id' => $this->db->escape_str(trim($brand[$i])),
						'batch_no' => $this->db->escape_str(trim($batch_no[$i])),
						'expiry_date' => $this->db->escape_str(trim($expiry_date)),
						'deltoid' => $this->db->escape_str(trim($deltoid[$i])),
						'price' => $this->db->escape_str(trim(number_format($price[$i],2))),
						'extra_advice' => $this->db->escape_str(trim($extra_advice_str)),
						'notes' => $this->db->escape_str(trim($notes)),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
	
					$this->db->dbprefix('vaccine_order_details');
					$ins_order_details = $this->db->insert('vaccine_order_details', $vaccine_order_data);
					
					$vaccine_order_new_ids[] = $this->db->insert_id(); //Will use in an email
									
				}//end for($i=0;$i<count($vaccine);$i++)
				
			}//end if(count($medicine_purchase_arr) > 0)
			
			//RAF Vaccine INSERTION INTO DATABASE.
			if(count($answer_question) > 0){
				
				$delete_previous_patient_raf = $this->delete_patient_raf($patient_id,'',$vaccine_id);
				
				foreach($answer_question as $raf_id => $raf_answer){
					
					$raf_ins_data = array(
									'patient_id' => $this->db->escape_str(trim($patient_id)),
									'vaccine_id' => $this->db->escape_str(trim($vaccine_id)),
									'raf_id' => $this->db->escape_str(trim($raf_id)),
									'answer' => $this->db->escape_str(trim($raf_answer)),
									'created_date' => $this->db->escape_str(trim($created_date)),
									'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
								);
	
					$this->db->dbprefix('patients_raf_history');
					$ins_into_db = $this->db->insert('patients_raf_history', $raf_ins_data);
					
				}//end foreach($medicine_arr['raf']['answer'] as $raf_id => $raf_answer)
	
			}//end if(count($medicine_arr['raf']['answer']) > 0)
			
			//If Malaria is set and vaccine ins Travel
			if($medicine && $vaccine_id == 2){
				//Malaria is set means make an insertion into the table as a new medicine entry
	
				$malaria_prescription_ins_data = array(
	
					'prescription_no' => $this->db->escape_str(trim($prescription_no)),
					'order_id' => $this->db->escape_str(trim($order_id)),
					'patient_id' => $this->db->escape_str(trim($patient_id)),
					'pharmacy_surgery_id' => $this->db->escape_str($pharmacy_surgery_id),
					'organization_id' => $this->db->escape_str(trim($organization_id)),
					'medicine_id' => $this->db->escape_str(trim($medicine_id)),
					'medicine_cat_id' => $this->db->escape_str(trim($medicine_cat_id)),
					'prescribed_by' => $this->db->escape_str(trim($prescribed_by)),
					'qty_id' => $this->db->escape_str(trim($quantity_id)),
					'quantity' => $this->db->escape_str(trim($quantity)),
					'strength_id' => $this->db->escape_str(trim($strength_id)),
					'medicine_class' => $this->db->escape_str(trim($medicine_class)),
					'order_type' => "PMR",
					'order_status' => 'C',
					'suggested_dose' => $this->db->escape_str(trim($suggested_dose)),
					'product_type' => $this->db->escape_str('M'),
					'is_pgd' => $this->db->escape_str('1'),
					'is_malaria' => $this->db->escape_str('1'),
					'subtotal' => $this->db->escape_str(trim($medicine_price)),
					'created_date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
				);
				
				// save prescription : Insert data into db [ Table - patient_order_details ]
				$this->db->dbprefix('patient_order_details');
				
				$ins_order_details = $this->db->insert('patient_order_details', $malaria_prescription_ins_data);
	
				//RAF Vaccine INSERTION INTO DATABASE.
				if(count($malaria_answer_question) > 0){
					
					$delete_previous_patient_raf = $this->delete_patient_raf($patient_id,$medicine_id,'');
					
					foreach($malaria_answer_question as $raf_id => $raf_answer){
						
						$raf_ins_data = array(
										'patient_id' => $this->db->escape_str(trim($patient_id)),
										'medicine_id' => $this->db->escape_str(trim($medicine_id)),
										'raf_id' => $this->db->escape_str(trim($raf_id)),
										'answer' => $this->db->escape_str(trim($raf_answer)),
										'created_date' => $this->db->escape_str(trim($created_date)),
										'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
									);
		
						$this->db->dbprefix('patients_raf_history');
						$ins_into_db = $this->db->insert('patients_raf_history', $raf_ins_data);
						
					}//end foreach($medicine_arr['raf']['answer'] as $raf_id => $raf_answer)
		
				}//end if(count($malaria_answer_question) > 0)
				
			}//end if($medicine && $vaccine_id == 2)
				
		}else{
			//Its a Online Request we need to insert data in a specific tables only.	
		
			//Get Order detail daata
			$order_detail_data = $this->get_patient_order_item_details($previous_order_detail_id);
			
			//INSERTING VACCINE Record INTO THE DATABASE
			if(count($vaccine) > 0){
				
				for($i=0;$i<count($vaccine);$i++){
					
					//Change order status from Pending to Complete.
					$order_upd_data = array('order_status' => 'C');
			
					$this->db->dbprefix('patient_order_details');
					$this->db->where('id', $previous_order_detail_id);
					$this->db->update('patient_order_details', $order_upd_data);

					$expiry_date = date('Y-m-d',strtotime($expiry_date[$i])); // Expiry date vaccine
					
					//Inserting Vaccine Record into Patient Vaccine Order List
					$vaccine_order_data = array(
					
						'vaccine_type' => $this->db->escape_str(trim($vaccine_type)),
						'order_detail_id' => $this->db->escape_str(trim($previous_order_detail_id)),
						'patient_id' => $this->db->escape_str(trim($patient_id)),
						'pharmacy_surgery_id' => $this->db->escape_str($pharmacy_surgery_id),
						'organization_id' => $this->db->escape_str(trim($organization_id)),
						'prescribed_by' => $this->db->escape_str(trim($prescribed_by)),
						'vaccine_cat_id' => $this->db->escape_str(trim($vaccine[$i])),
						'vaccine_brand_id' => $this->db->escape_str(trim($brand[$i])),
						'batch_no' => $this->db->escape_str(trim($batch_no[$i])),
						'expiry_date' => $this->db->escape_str(trim($expiry_date)),
						'deltoid' => $this->db->escape_str(trim($deltoid[$i])),
						'price' => $this->db->escape_str(trim(number_format($price[$i],2))),
						'extra_advice' => $this->db->escape_str(trim($extra_advice_str)),
						'notes' => $this->db->escape_str(trim($notes)),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					
					$this->db->dbprefix('vaccine_order_details');
					$ins_order_details = $this->db->insert('vaccine_order_details', $vaccine_order_data);
					
					$vaccine_order_new_ids[] = $this->db->insert_id(); //Will use in an email
									
				}//end for($i=0;$i<count($vaccine);$i++)
				
			}//end if(count($medicine_purchase_arr) > 0)
			
			//If Malaria is set 
			if($medicine && $vaccine_id == 2){
				
				//Malaria is set means make an insertion into the table as a new medicine entry
				$malaria_prescription_ins_data = array(
	
					'prescription_no' => $this->db->escape_str(trim($order_detail_data['prescription_no'])),
					'order_id' => $this->db->escape_str(trim($order_detail_data['order_id'])),
					'patient_id' => $this->db->escape_str(trim($patient_id)),
					'pharmacy_surgery_id' => $this->db->escape_str($pharmacy_surgery_id),
					'organization_id' => $this->db->escape_str(trim($organization_id)),
					'medicine_id' => $this->db->escape_str(trim($medicine_id)),
					'prescribed_by' => $this->db->escape_str(trim($prescribed_by)),
					'qty_id' => $this->db->escape_str(trim($quantity_id)),
					'quantity' => $this->db->escape_str(trim($quantity)),
					'strength_id' => $this->db->escape_str(trim($strength_id)),
					'medicine_class' => $this->db->escape_str(trim($medicine_class)),
					'order_type' => "PMR",
					'order_status' => 'C',
					'suggested_dose' => $this->db->escape_str(trim($suggested_dose)),
					'product_type' => $this->db->escape_str('M'),
					'subtotal' => $this->db->escape_str(trim($medicine_price)),
					'created_date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
				);
				
				// save prescription : Insert data into db [ Table - patient_order_details ]
				$this->db->dbprefix('patient_order_details');
				
				$ins_order_details = $this->db->insert('patient_order_details', $malaria_prescription_ins_data);
	
				//RAF Vaccine INSERTION INTO DATABASE.
				if(count($malaria_answer_question) > 0){
					
					$delete_previous_patient_raf = $this->delete_patient_raf($patient_id,$medicine_id,'');
					
					foreach($malaria_answer_question as $raf_id => $raf_answer){
						
						$raf_ins_data = array(
										'patient_id' => $this->db->escape_str(trim($patient_id)),
										'medicine_id' => $this->db->escape_str(trim($medicine_id)),
										'raf_id' => $this->db->escape_str(trim($raf_id)),
										'answer' => $this->db->escape_str(trim($raf_answer)),
										'created_date' => $this->db->escape_str(trim($created_date)),
										'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
									);
		
						$this->db->dbprefix('patients_raf_history');
						$ins_into_db = $this->db->insert('patients_raf_history', $raf_ins_data);
						
					}//end foreach($medicine_arr['raf']['answer'] as $raf_id => $raf_answer)
		
				}//end if(count($malaria_answer_question) > 0)
				
			}//end if($medicine && $vaccine_id == 2)
			
		}//end if(!$previous_order_detail_id)
		
		$vaccine_order_new_ids_str = implode('|',$vaccine_order_new_ids);
		//Sending Consent form in email to the Patient		
		$get_patient_details = $this->get_patient_details($patient_id);
		
		$patient_email = filter_string($get_patient_details['email_address']);

		$this->load->model('email_mod','email_template');
		
		$email_body_arr = $this->email_template->get_email_template(16);

		$email_subject = $email_body_arr['email_subject'];

		$email_body = $email_body_arr['email_body'];
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
		
		$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
		$noreply_email = get_global_settings($NOREPLY_EMAIL);
		
		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
		$from = filter_string($noreply_email['setting_value']);
		$from_name = filter_string($email_from_txt['setting_value']);
		
		$subject = filter_string($email_subject);
		$email_body = filter_string($email_body);

		$consent_link = SURL."consent/consent-agreement?pid=".($patient_id)."&t=V&consent=".base64_encode($vaccine_order_new_ids_str);

		$search_arr = array('[CONSENT_AGREE_LINK]','[SITE_LOGO]','[SITE_URL]');
		$replace_arr = array($consent_link,SITE_LOGO,SURL); 
		
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
		
		// Call from Helper send_email function
		$send_email = kod_send_email($from, $from_name, $patient_email, $subject, $email_body, '');

		return true;

	} // End - public function save_walkin_vaccine($raf_answer, $post)
	
	//Function consent_agreement(): Mark the Consent Agreement as YEs against the Vaccine Order Id and/ or PGD's $consent_type = V = Vaccine, P = PGD
	public function consent_agreement($patient_id,$consent_ids, $consent_type){
		
		$consent_ids_arr = explode('|',$consent_ids);
		
		if($consent_type == 'V'){
			
			//For Vaccines's
			for($i=0;$i<count($consent_ids_arr);$i++){

				//Change read consent from N to Yes
				$order_upd_data = array('online_consent_agreed' => 'Y');
		
				$this->db->dbprefix('vaccine_order_details');
				$this->db->where('id', $consent_ids_arr[$i]);
				$this->db->update('vaccine_order_details', $order_upd_data);
				
			}//end for($i=0;$i<count($consent_ids_arr);$i++)

		}elseif($consent_type == 'P'){
			//For PGD's
			//Change read consent from N to Yes
			$order_upd_data = array('online_consent_agreed' => 'Y');
	
			$this->db->dbprefix('patient_order_details');
			$this->db->where('id', $consent_ids_arr[0]);
			$this->db->update('patient_order_details', $order_upd_data);
			//echo $this->db->last_query(); exit;
			
		}//end if($consent_type == 'V')
		
		return true;	
	}//end function consent_agreement($patient_id,$consent_ids)

	// Function delete_patient_raf(): This will delete the existing RAF if exist of the patient againt Medicine ID or Vaccine ID or Medicine Cat Id
	public function delete_patient_raf($patient_id, $medicine_id = '',$vaccine_id = '', $medicine_cat_id = ''){
		
		 $this->db->dbprefix('patients_raf_history');
		 
		 if(trim($medicine_id) != '') $this->db->where('medicine_id',$medicine_id);
		 if(trim($vaccine_id) != '') $this->db->where('vaccine_id',$vaccine_id);
		 if(trim($medicine_cat_id) != '') $this->db->where('medicine_cat_id',$medicine_cat_id);
		 
		 $this->db->where('patient_id',$patient_id);
		 $this->db->delete('patients_raf_history');
		 
		 return true;
		
	}//end delete_patient_raf($patient_id, $medicine_id = '',$vaccine_id = '')

	// Start - public function get_patient_journy_list($category_id, $patient_id) : In case of Online
	public function get_patient_journy_list($category_id, $patient_id){



	} // End - public function get_patient_journy_list($category_id, $patient_id)

	// Start - public function get_countries_list($vaccine_order_id)
	public function get_countries_list($vaccine_order_id){

		$this->db->dbprefix('patient_order_details');
		$this->db->where('id', $vaccine_order_id);

		return $this->db->get('patient_order_details')->row_array();

	} // End - public function get_countries_list($vaccine_order_id)

	// Start - public function get_filled_raf($is_vaccine_request, $pmr_patient_id)
	public function get_filled_raf($is_vaccine_request='', $pmr_patient_id, $medicine_id='', $med_cat_id=''){
		
		$this->db->dbprefix('patients_raf_history');
		$this->db->select('patient_id, medicine_id, vaccine_id, raf_id, answer');
		 
		if(trim($medicine_id) != '') $this->db->where('medicine_id',$medicine_id);
		if(trim($is_vaccine_request) != '') $this->db->where('vaccine_id',$is_vaccine_request);
		if(trim($med_cat_id) != '') $this->db->where('medicine_cat_id',$med_cat_id);
		$this->db->from('patients_raf_history');
		$this->db->where('patient_id',$pmr_patient_id);
		 
		$get = $this->db->get();
		$result = $get->result_array();
		//echo $this->db->last_query(); exit;

		return $result;
		 
	} // End - public function get_filled_raf($is_vaccine_request, $pmr_patient_id)

	// Start - public function get_consent_form($medicine_cat_id)
	public function get_consent_form($medicine_cat_id){

		// Verify request from ? and fetch the template according

		if($medicine_cat_id == 30){

			// FLU Vaccine : get template for flu
			$this->db->dbprefix('email_templates');
			$this->db->where('id', 13);

			return $this->db->get('email_templates')->row_array();

		} else if($medicine_cat_id == 33){
			
			// Travel Vaccine : get template for Travel
			$this->db->dbprefix('email_templates');
			$this->db->where('id', 14);

			return $this->db->get('email_templates')->row_array();

		} else {

			// General for all others
			$this->db->dbprefix('email_templates');
			$this->db->where('id', 15);

			return $this->db->get('email_templates')->row_array();

		} // if($medicine_cat_id == 30)

	} // End - public function get_consent_form($medicine_cat_id)

	// Start - Function get_patient_order_details($order_id='')
	public function get_patient_order_details($order_id=''){

		$this->db->dbprefix('patient_order_details');
		$this->db->where('id', $order_id);

		return $this->db->get('patient_order_details')->row_array();

	} // End - function get_patient_order_details($order_id='')

	// Start => Function get_patient_pgd_order_details($order_details_id='')
	public function get_patient_pgd_order_details($order_details_id=''){

		$this->db->dbprefix('patient_order_details');
		$this->db->select('CONCAT(kod_users.first_name," ",kod_users.last_name) as supplied_by_user, patient_order_details.*');

		$this->db->join('patient_orders', 'patient_orders.id = patient_order_details.order_id', 'LEFT');
		$this->db->join('users', 'users.id = patient_orders.purchased_by_id', 'LEFT');

		$this->db->where('patient_order_details.id', $order_details_id);
		return $this->db->get('patient_order_details')->row_array();

	} // End => function get_patient_pgd_order_details($order_details_id='')

	// Start - function send_merge_history_email($patient_id, $pharmacy_surgery_id)
	public function send_merge_history_email($user_id, $patient_id, $pharmacy_surgery_id){

		// Get details for : {patient}
		$patient_data = $this->pmr->get_patient_details($patient_id);
		$patient_name = filter_string($patient_data['first_name']).' '.filter_string($patient_data['last_name']);

		// Get loggedin user details for : [USER TYPE] - [User]
		$user = $this->users->get_user_details($user_id);
		$user_type = filter_string($user['user_type_name']);
		$user_name = filter_string($user['user_full_name']);

		// Get details for : [location]
		$pharmacy_surgery = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
		$pharmacy_name = filter_string($pharmacy_surgery['pharmacy_surgery_name']);

		// Get details for : [location2] - [location3] - [location4] ....
		$patient_in_other_ps = $this->pmr->get_patient_pharmacies_list($patient_id);

		/*
		// Locations List
		$location_list = '';
		if($patient_in_other_ps){
		
			$location_list = '<ul>';
			
			foreach($patient_in_other_ps as $each){

				$location_list .= '<li>'.filter_string($each['pharmacy_surgery_name']).' </li>';

			} // foreach($patient_in_other_ps as $each)
					
			$location_list .= '</ul>';

		} // if($patient_in_other_ps)
		*/

		$link = '<div style="padding: 8px;border: 1px solid #ddd; width: 110px; background-color: #337ab7;"> <a href="'.VH_SURL.'clinics/merge-patient-with-pharmacy/'.urlencode(base64_encode(filter_string($patient_data['id']))).'/'.urlencode(base64_encode(filter_string($pharmacy_surgery['id']))).'" style="margin-left: 4px;text-decoration:none; font-family: arial; font-size: 13px; color: #fff;" >Share My History</a> </div>';

		//User data
		$email_address = stripslashes(trim($patient_data['email_address']));

		$search_arr = array('[PATIENT_NAME]','[USER_TYPE]', '[USER_NAME]','[PHARMACY_NAME]','[LINK]','[SITE_LOGO]','[SITE_URL]');
		$replace_arr = array($patient_name,$user_type,$user_name,$pharmacy_name,$link,SITE_LOGO,SURL); 
		
		$this->load->model('email_mod','email_template');
	
	    $email_body_arr = $this->email_template->get_email_template(21);

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

		//echo $email_body;
		//exit;

		// Call from Helper send_email function
		$sent = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);

		return 1;

	} // End - function send_merge_history_email($patient_id, $pharmacy_surgery_id)

	// Start => function get_pgd_prescription_preview_details($patient_order_details_id)
	public function get_pgd_prescription_preview_details($patient_order_details_id){



	} // End => function get_pgd_prescription_preview_details($patient_order_details_id)
	
	public function search_org_medicine($org_id, $keyword){
		
		$this->db->dbprefix('org_medicine');
		$this->db->where('organization_id',$org_id);
		$this->db->where("CONCAT(medicine_name,' ',strength) like '".$keyword."%'");

		$get_med = $this->db->get('org_medicine');
		
		//echo $this->db->last_query(); exit;

		return $get_med->result_array();
		
	}//end search_org_medicine($org_id, $keyword)
	
	public function add_new_medicine($user_id, $organization_id, $pharmacy_id, $data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();

		$ins_data = array(
	
			'organization_id' => $this->db->escape_str(trim($organization_id)),
			'pharmacy_id' => $this->db->escape_str(trim($pharmacy_id)),
			'created_by' => $this->db->escape_str(trim($user_id)),
			'medicine_name' => $this->db->escape_str($medicine_name),
			'strength' => $this->db->escape_str($medicine_strength),
			'form' => $this->db->escape_str($medicine_form),
			'status' => $this->db->escape_str(1),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);

		//Inserting Patient data into the database. 
		$this->db->dbprefix('org_medicine');
		$ins_into_db = $this->db->insert('org_medicine', $ins_data);
		
		return $ins_into_db;
		
		
	}//end add_new_medicine($user_id, $organizatation_id, $pharmacy_id, $data)

} //End - file

?>