<?php
class Pharmacy_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

    // Start - public function get_org_by_id($user_id) : Function to get ORGANIZATION details by ORG-ID
    public function get_org_by_id($user_id){

    	$this->db->dbprefix('organization');
    	$this->db->select('id as organization_id, company_name as organization_name, postcode');
    	
    	$this->db->where('owner_id', $user_id);
		$this->db->or_where('superintendent_id', $user_id);

    	return $this->db->get('organization')->result_array();

    } // End - public function get_org_by_id($user_id)
	
	// get_pharmacy_surgery_list() Will return the list of pharmacies in an organization against the organizatin ID.
	public function get_pharmacy_surgery_list($organization_id = 0){
		
		$this->db->dbprefix('org_pharmacy_surgery.*');
		$this->db->select('org_pharmacy_surgery.id AS pharmacy_surgery_id, org_pharmacy_surgery.organization_id, org_pharmacy_surgery.manager_id, org_pharmacy_surgery.pharmacy_surgery_name, org_pharmacy_surgery.gphc_no,org_pharmacy_surgery.address, org_pharmacy_surgery.postcode, org_pharmacy_surgery.contact_no, org_pharmacy_surgery.country_id, org_pharmacy_surgery.type, org_pharmacy_surgery.status,pharmacy_settings.governance_status, pharmacy_settings.online_doctor_status,pharmacy_settings.survey_status,pharmacy_settings.pmr_status,pharmacy_settings.embed_status,pharmacy_settings.todolist_status,pharmacy_settings.ipos_status, organization.company_name as organization_name');
		
		$this->db->join('pharmacy_surgery_global_settings AS pharmacy_settings','org_pharmacy_surgery.id = pharmacy_settings.pharmacy_surgery_id','LEFT');
		$this->db->join('organization','org_pharmacy_surgery.organization_id = organization.id','INNER');
		
		if($organization_id != 0)  $this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
		$this->db->where('org_pharmacy_surgery.is_deleted', '0');
		
		$get = $this->db->get('org_pharmacy_surgery');
		//echo $this->db->last_query(); exit;
		
		return $get->result_array();
		
	} // End - get_pharmacy_surgery_list($organization_id = 0)
	
	public function get_pharmacy_by_name_postcode($organization_id, $pharmacy_name, $postcode){

		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('country.country_name, org_pharmacy_surgery.*,organization.company_name as organization_name, pharmacy_surgery_global_settings.governance_status, pharmacy_surgery_global_settings.online_doctor_status, pharmacy_surgery_global_settings.survey_status, pharmacy_surgery_global_settings.pmr_status, pharmacy_surgery_global_settings.todolist_status, pharmacy_surgery_global_settings.ipos_status, pharmacy_surgery_global_settings.no_of_surveys, pharmacy_surgery_global_settings.embed_status');
		
		$this->db->join('organization','org_pharmacy_surgery.organization_id = organization.id','INNER');
		$this->db->join('country','org_pharmacy_surgery.country_id = country.id','LEFT');
		$this->db->join('pharmacy_surgery_global_settings','org_pharmacy_surgery.id = pharmacy_surgery_global_settings.pharmacy_surgery_id','LEFT');
		
		$this->db->where('org_pharmacy_surgery.organization_id', filter_string($organization_id));
		$this->db->where('org_pharmacy_surgery.pharmacy_surgery_name', filter_string($pharmacy_name));
		$this->db->where('org_pharmacy_surgery.postcode', filter_string($postcode));
		
		return $this->db->get('org_pharmacy_surgery')->row_array();
		
	}//end get_pharmacy_by_name_postcode($pharmacy_name, $postcode)
	
	// Start - get_pharmacy_surgery_details($pharmacy_id)
	public function get_pharmacy_surgery_details($pharmacy_id){
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('country.country_name, org_pharmacy_surgery.*,organization.company_name as organization_name, pharmacy_surgery_global_settings.governance_status, pharmacy_surgery_global_settings.online_doctor_status, pharmacy_surgery_global_settings.survey_status, pharmacy_surgery_global_settings.pmr_status, pharmacy_surgery_global_settings.todolist_status, pharmacy_surgery_global_settings.ipos_status, pharmacy_surgery_global_settings.no_of_surveys, pharmacy_surgery_global_settings.embed_status, pharmacy_surgery_global_settings.online_delivery_status');
		
		$this->db->join('organization','org_pharmacy_surgery.organization_id = organization.id','INNER');
		$this->db->join('country','org_pharmacy_surgery.country_id = country.id','LEFT');
		$this->db->join('pharmacy_surgery_global_settings','org_pharmacy_surgery.id = pharmacy_surgery_global_settings.pharmacy_surgery_id','LEFT');
		
		$this->db->where('org_pharmacy_surgery.id', $pharmacy_id);
		
		return $this->db->get('org_pharmacy_surgery')->row_array();
		
	} // End - get_pharmacy_surgery_details($pharmacy_id)

	// Start - get_pharmacy_staff_details(): Get tehe row of the Staff Members using Staff ID.
	public function get_pharmacy_staff_details($staff_id){
		
		$this->db->dbprefix('pharmacy_surgery_staff');
		$this->db->where('id', $staff_id);
		
		$get = $this->db->get('pharmacy_surgery_staff');
		return $get->row_array();
		
	} // End - get_pharmacy_staff_details($pharmacy_id)

	// Start - get_pharmacy_staff_details(): Get tehe row of the Staff Members using Staff ID.
	public function get_pharmacy_staff_members($pharmacy_id, $user_type = ''){
		
		$get_pharmacy_details = $this->get_pharmacy_surgery_details($pharmacy_id);
		
		if($get_pharmacy_details['manager_id']){
			
			$get_user_details = $this->users->get_user_details($get_pharmacy_details['manager_id']);
			
			$manager_arr = array();
	
			if($get_user_details['user_type'] == '2'){
				
				$manager_arr['user_id'] = $get_user_details['id'];
				$manager_arr['user_type'] = $get_user_details['user_type'];
				$manager_arr['first_name'] = $get_user_details['first_name'];
				$manager_arr['last_name'] = $get_user_details['last_name'];
				
			}//end if($get_user_details['user_type'] == '2')
			
		}//end if($get_pharmacy_details['manager_id'])
		
		$this->db->dbprefix('pharmacy_surgery_staff.pharmacy_surgery_id');
		$this->db->select('users.first_name, users.last_name, users.user_type, users.id AS user_id');
		$this->db->where('pharmacy_surgery_staff.pharmacy_surgery_id', $pharmacy_id);
		
		if(trim($user_type) != '')
			$this->db->where('users.user_type', $user_type);
		
		$this->db->join('users', 'pharmacy_surgery_staff.user_id = users.id','LEFT');
		
		$get = $this->db->get('pharmacy_surgery_staff');
		
		$final_arr = $get->result_array();
		
		$final_arr[] = array($final_arr,$manager_arr);
		
		return $final_arr;
		
	} // End - get_pharmacy_staff_details($pharmacy_id)
	
	// Start - get_my_pharmacies_surgeries(): Returns List of all Pharmaices where user actually belongs too. This will create two arrays one for staff and another one for manager where it beloongs. $user_role = M will return just the list of a manager, ST will return both. 2 will return staff array
	public function get_my_pharmacies_surgeries( $user_id, $user_role = '', $organization_id = ''){
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.id AS pharmacy_surgery_id, org_pharmacy_surgery.organization_id, organization.company_name as organization_name, org_pharmacy_surgery.manager_id, org_pharmacy_surgery.pharmacy_surgery_name, org_pharmacy_surgery.email_address, org_pharmacy_surgery.address, org_pharmacy_surgery.postcode, org_pharmacy_surgery.contact_no, org_pharmacy_surgery.country_id, org_pharmacy_surgery.type, org_pharmacy_surgery.status');

		$this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id');
		$this->db->where('org_pharmacy_surgery.manager_id', $user_id);
		
		if($organization_id != '') $this->db->where('org_pharmacy_surgery.organization_id', $organization_id);

		$this->db->where('org_pharmacy_surgery.status', 1);
		$this->db->where('org_pharmacy_surgery.is_deleted', '0');
		
		$data['as_manager'] = $this->db->get('org_pharmacy_surgery')->result_array();
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.id as pharmacy_surgery_id, org_pharmacy_surgery.organization_id, organization.company_name as organization_name, org_pharmacy_surgery.pharmacy_surgery_name, org_pharmacy_surgery.postcode, org_pharmacy_surgery.type, staff.id as staff_id');
		
		$this->db->from('org_pharmacy_surgery');
		
		$this->db->join('pharmacy_surgery_staff as staff', ' staff.pharmacy_surgery_id = org_pharmacy_surgery.id ');
		$this->db->join('users', ' users.id = staff.user_id ');
		$this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id');
		
		// If Pharmacy/Surgery is not deleted
		$this->db->where('org_pharmacy_surgery.status', 1);
		$this->db->where('org_pharmacy_surgery.is_deleted', '0');

		if($organization_id != '') $this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
		
		$this->db->where('staff.user_id', $user_id);
		
		if(!empty($data['as_manager'])){
			foreach($data['as_manager'] as $each){
				
				$this->db->where('org_pharmacy_surgery.id !=', $each['pharmacy_surgery_id']);
				
			}//end foreach($data['as_manager'] as $each)
			
		}//end if(!empty($data['as_manager']))
		
		$data['as_staff'] = $this->db->get()->result_array();

		//print_this($data);
		//exit;

		//echo $this->db->last_query(); exit;
		if($user_role == 'M')
			return $data['as_manager'];
		elseif($user_role == 'ST')
			return $data['as_staff'];
		else
			return array_merge($data['as_manager'], $data['as_staff']);
		
	} // End - get_my_pharmacies_surgeries( $user_id )
	
	// Start - add_update_pharmacy_surgery($data)
	public function add_update_pharmacy_surgery($organization_id,$data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$postcode = str_replace(' ', '', $postcode);
				
		//Record insert into database
		$ins_data = array(
		
			'pharmacy_surgery_name' => $this->db->escape_str(trim($pharmacy_surgery_name)),
			'address' => $this->db->escape_str(trim($address)),
			'postcode' => $this->db->escape_str(trim($postcode)),
			'contact_no' => $this->db->escape_str(trim($contact_no)),
			'gphc_no' => $this->db->escape_str(trim($gphc_no)),
			'f_code' => $this->db->escape_str(trim($f_code)),
			'country_id' => $this->db->escape_str(trim($country_id)),
			
		);
		
		
		// Get Country Name by country id
		$this->db->dbprefix('country');
		$this->db->select('country_name');
		$this->db->from('country');
		$this->db->where('id', $country_id);
		$row = $this->db->get()->row_array();
		
		// Country Name
		$country_name =  filter_string($row['country_name']);
		
		// get latitude and longitude by address postcode and country name
		$long_lat_arr = get_longitude_latitude($address.","." ".$postcode.", ".$country_name);
		
		if($pharmacy_id==""){
			
			$ins_data['created_date']    = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip']   = $this->db->escape_str(trim($created_by_ip));
			$ins_data['latitude']        = $this->db->escape_str(trim($long_lat_arr['latitude'][0]));
			$ins_data['longitude']       = $this->db->escape_str(trim($long_lat_arr['longitude'][0]));
			$ins_data['status'] = 1;
			$ins_data['organization_id'] = $organization_id;
			$ins_data['type']            = $this->db->escape_str(trim($type));
			
			//Add  data into the database. 
			$this->db->dbprefix('org_pharmacy_surgery');
			$ins_into_db = $this->db->insert('org_pharmacy_surgery', $ins_data);
			
			$pharmacy_surgery_id = $this->db->insert_id();
			
			// Add Pharmacy / Surgery Settings copy into db [ Table - kod_pharmacy_surgery_global_settings ]
			$settings = array(
						
							'organization_id' => $organization_id,
							'pharmacy_surgery_id' => $pharmacy_surgery_id,
							'governance_status' => 0,
							'online_doctor_status' => 0,
							'survey_status' => '1',
							'pmr_status' => '1',
							'todolist_status' => 0,
							'ipos_status' => 0,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by_ip' => $this->input->ip_address()
						
						);
			$this->db->dbprefix('pharmacy_surgery_global_settings');
			$ins_into_db = $this->db->insert('pharmacy_surgery_global_settings', $settings);
			
		} else {

			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			$ins_data['latitude']        = $this->db->escape_str(trim($long_lat_arr['latitude'][0]));
			$ins_data['longitude']       = $this->db->escape_str(trim($long_lat_arr['longitude'][0]));
			
			//update  data into the database. 
			$this->db->dbprefix('org_pharmacy_surgery');
			$this->db->where('id',$pharmacy_id);
			$ins_into_db = $this->db->update('org_pharmacy_surgery', $ins_data);
			
		}//end if($pharmacy_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;
			
	} // End - add_update_pharmacy_surgery($data)
	
	// Start pharmacy_surgery_delete
	public function pharmacy_surgery_delete($pharmacy_surgery_id){
		
	    //Delete Pharmacy / Surgery Record [ CASCADE: All records referring to the Pharmacy / Surgery record will be deleted too ]
		/*$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->where('id', $pharmacy_surgery_id);
		$this->db->delete('org_pharmacy_surgery');*/
		
		
		$ins_data['is_deleted'] = 1;
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->where('id', $pharmacy_surgery_id);
		return $this->db->update('org_pharmacy_surgery',$ins_data);
		
		/* Temp queries - will be deleted
		// Delete hr Governance read status [ for all Staff and the Manager ]
		$this->db->dbprefix('governance_read_status');
		$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->delete('governance_read_status');
		
		// Delete SOP Governance read status [ for all Staff and the Manager ]
		$this->db->dbprefix('governance_sop_read_status');
		$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->delete('governance_sop_read_status');
		
		// Delete Pharmacy / Surgery Staff
		$this->db->dbprefix('pharmacy_surgery_staff');
		$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
    	$this->db->delete('pharmacy_surgery_staff');
		
		// Delete Pharmacy / Surgery [ Timings Settings ]
		$this->db->dbprefix('pharmacy_surgery_timings');
		$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->delete('pharmacy_surgery_timings');
		
		// Delete Pharmacy / Surgery [ Global Settings ]
		$this->db->dbprefix('pharmacy_surgery_global_settings');
		$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		return $this->db->delete('pharmacy_surgery_global_settings');
		*/
		
	} // pharmacy_surgery_delete($pharmacy_surgery_id)
	
	//Function get_pharmacy_details(): Returns the Pharmacy Details using Pharmacy ID
	public function get_pharmacy_details($pharmacy_id){
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.*,organization.company_name, organization.id as organization_id, CONCAT(first_name," ",last_name) AS manager_fullname');
	
		$this->db->join('users','org_pharmacy_surgery.manager_id = users.id','LEFT');
		$this->db->join('organization','org_pharmacy_surgery.organization_id = organization.id','LEFT');
		
		$this->db->where('org_pharmacy_surgery.id',$pharmacy_id);
		$this->db->where('org_pharmacy_surgery.is_deleted', '0');
		
		$get = $this->db->get('org_pharmacy_surgery');
		//echo $this->db->last_query(); 		exit;

		return $get->row_array();
		
	}//end get_pharmacy_details()

	// Start - get_all_org_pharmacies($organization_id): Governance Status [ 0 = Purchased but not read, 1 = Purchased and Read, 2 = Not Purchased ]
	public function get_all_org_pharmacies($search ='', $organization_id, $filter, $pharmacy_surgery_id='', $limit = '', $page = ''){
		
		//Loading Training Courses (For Purchase)
		//$this->load->model('training_mod', 'training');
		
		// Load purchase_mod to get the staff member's PGDs details
		//$this->load->model('purchase_mod', 'purchase');
		
		
		//USER SEARCH AREA
		
		$this->db->dbprefix('org_pharmacy_surgery');
		
		if(!empty($filter) && $filter != 'All')
			$this->db->where('type', $filter);
			
		if($organization_id != ''){
			$this->db->where('organization_id', $organization_id);
		} // if($organization_id != '')
		
		// if not empty search then 
		if($search!='') {
			$this->db->where("(pharmacy_surgery_name LIKE '%$search%' OR postcode LIKE '%$search%' )");
		} // if($search!='')
		
		if($pharmacy_surgery_id != ''){
			$this->db->where('id', $pharmacy_surgery_id);
		} // if($pharmacy_surgery_id != '')
		
		$this->db->where('is_deleted', '0');
		
		if(trim($limit)!= '') $this->db->limit($limit, $page);
		
		$this->db->order_by('id', 'desc');
		$all = $this->db->get('org_pharmacy_surgery')->result_array();
		
		
		//echo $this->db->last_query();

		// check all parmacies/surgeries :: If manager exists ? merge manager's data into the same array
		foreach($all as $key => $each){

			// Date 03 june 2016
			// Fetch Pharmacy surgery global settings
			/*$this->db->dbprefix('pharmacy_surgery_global_settings');
			$this->db->where('pharmacy_surgery_id', $each['id']);
			$all[$key]['global_settings'] = $this->db->get('pharmacy_surgery_global_settings')->row_array();
			
			// Fetch Pharmacy surgery global settings
			$this->db->dbprefix('pharmacy_surgery_timings');
			$this->db->where('pharmacy_surgery_id', $each['id']);
			$all[$key]['time_settings'] = $this->db->get('pharmacy_surgery_timings')->row_array();*/
			
			// end Date 03 june 2016
			
			$pharmacy_surgery_governance_purchased = $this->governance->get_governance_purchased_pharmacies($organization_id,'P',$each['id']);
			
			if($pharmacy_surgery_governance_purchased)
				$all[$key]['governance_purchase_status'] = 1;
			else
				$all[$key]['governance_purchase_status'] = 0;
			// $pharmacy_surgery_governance_purchased
			
			if($each['manager_id'] != 0){

				$manager = $this->users->get_user_details($each['manager_id']);
				
				if(!empty($manager)){
					
					$all[$key]['manager_full_name'] = $manager['first_name'].' '.$manager['last_name'];
					$all[$key]['manager_usertype'] = $manager['user_type_name'];
					$all[$key]['manager_usertype_id'] = $manager['user_type_id'];
					$all[$key]['manager_contact_number'] = $manager['mobile_no'];
					$all[$key]['manager_email'] = $manager['email_address'];
					$all[$key]['manager_is_prescriber'] = $manager['is_prescriber'];
					$all[$key]['manager_is_owner'] = $manager['is_owner'];

					$all[$key]['manager_training_courses_arr'] = $this->training->get_training_courses_list($manager['user_type_id']);
					
					//Get staff member's PGD purchase details
					//Get User Purchased List
					$all[$key]['purchased_items_split_arr'] = $this->purchase->get_purchased_items_split_by_user($each['manager_id']);

					//Get the Contract Record of the users.
					$check_if_contract_read = $this->governance->get_user_governance_read_status($each['manager_id'],$organization_id, $each['id'], 'M');
					$all[$key]['manager_hr_contract'] = $check_if_contract_read;
					
					if($check_if_contract_read){
						
						//If there exist the temp contract if yes.. save the array.
						
						$chk_if_contract_in_temp = $this->governance->get_governace_hr_temp_details('',$check_if_contract_read['id']);
						
						if($chk_if_contract_in_temp)
							$all[$key]['manager_hr_temp_contract'] = $chk_if_contract_in_temp;		

					}//end if($check_if_contract_read)
					
					// Varify if the member is owner
					$manager_org = $this->organization->is_user_org_owner_si($each['manager_id'], $organization_id);
					if(!empty($manager_org) && $manager_org['owner_id'] == $each['manager_id'] && $manager_org['superintent_id'] != $each['manager_id']){
						
						$all[$key]['governance_read_status'] = 1;
						
					} else {
					
						$pharmacy_surgery_governance_purchase_status  = $this->governance->get_governance_purchased_pharmacies($organization_id,'P',$each['id']);
						//$get_pharmacy_surgery_global_settings_details = $this->pharmacy->get_pharmacy_surgery_global_settings_details($each['id']);
						//$pharmacy_surgery_governance_status = $get_pharmacy_surgery_global_settings_details['governance_status'];

						// If governance is purchased and on by the pharmacy / surgery settings
						if( count($pharmacy_surgery_governance_purchase_status) > 0){

							// Governance is Purchased for this pharmacy
							// Varify if the Governance read setting is on for this Pharmacy / Surgery
							
							$is_governance_on = $this->pharmacy->is_governance_settings_on($each['id']);
							
							if($is_governance_on){
						
								$governance_read = $this->governance->is_governance_read_by_user($each['manager_id'], $organization_id, $each['id'], 'M', $manager['user_type_id']);
								
								if($governance_read){
									
									$all[$key]['governance_read_status'] = 1;
								}else{
									$all[$key]['governance_read_status'] = 0;
								} // if($governance_read)

							} else { 
							
								$all[$key]['governance_read_status'] = 2;
							
							} // if($is_governance_on)
						
						} else {
							// If not purchased
							$all[$key]['governance_read_status'] = 2;
							
						} // if(count($pharmacy_surgery_governance_purchase_status) > 0)
				
					} // if(!empty($manager_org) && $manager_org['owner_id'] == $each['manager_id'] && $manager_org['superintent_id'] != $each['manager_id'])
				
				} // if(!empty($manager))
					
			} //if($each['manager_id'] != 0)
		
			// Fetch Pharmacy / Surgery Staff Details
			$this->db->dbprefix('pharmacy_surgery_staff, users');
			$this->db->select('users.is_prescriber, users.id as member_id, users.first_name, users.last_name, usertype.id as user_type_id, usertype.user_type, users.mobile_no as contact_number, users.email_address,pharmacy_surgery_staff.id as staff_id');
			
			$this->db->from('pharmacy_surgery_staff');
			
			$this->db->join('users', ' users.id = pharmacy_surgery_staff.user_id ');
			$this->db->join('usertype', ' usertype.id = users.user_type ');
			
			$this->db->where('pharmacy_surgery_id', $each['id']);
			$this->db->where('organization_id', $organization_id);
			
			// Get all Staff
			$all_staff = $this->db->get()->result_array();
			if(!empty($all_staff)){ // If a pharmacy / surgery having the staff
				
				$index = 0;
				
				foreach($all_staff as $staff):
					
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_row_id'] = $staff['staff_id'];
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_id'] = $staff['member_id'];
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_full_name'] = $staff['first_name'].' '.$staff['last_name'];
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_user_type'] = $staff['user_type'];
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_user_type_id'] = $staff['user_type_id'];
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_contact_number'] = $staff['contact_number'];
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_contact_email'] = $staff['email_address'];
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_is_prescriber'] = $staff['is_prescriber'];
					$all[$key]['staff_member_is_owner'][$index]['staff_member_is_prescriber'] = $staff['is_owner'];
					
					$training_courses_arr = $this->training->get_training_courses_list($staff['user_type_id']);
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_training_courses_arr'] = $training_courses_arr;
					
					//Get staff member's PGD purchase details
					//Get User Purchased List
					$all[$key]['pharmacy_surgery_staff'][$index]['purchased_items_split_arr'] = $this->purchase->get_purchased_items_split_by_user($staff['member_id']);
					
					//First check if the GOVERNANCE, if have passed/ read the GOVERNANCE descriptions.
					$check_if_contract_read = $this->governance->get_user_governance_read_status($staff['member_id'],$organization_id, $each['id'], 'ST');
					$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_hr_contract'] = $check_if_contract_read;

					if($check_if_contract_read){
						
						//If there exist the temp contract if yes.. save the array.
						
						$chk_if_contract_in_temp = $this->governance->get_governace_hr_temp_details('',$check_if_contract_read['id']);
						
						if($chk_if_contract_in_temp)
							$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_hr_temp_contract'] = $chk_if_contract_in_temp;

					}//end if($check_if_contract_read)
					

					// Varify if the member is owner
					$member_org = $this->organization->is_user_org_owner_si($staff['member_id'], $organization_id);
					
					if(!empty($member_org) && $member_org['owner_id'] == $staff['member_id'] && $member_org['superintent_id'] != $staff['member_id']){
						
						$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_governance_read_status'] = 1; // 1
						
					} else {
						
						$pharmacy_surgery_governance_purchase_status  = $this->governance->get_governance_purchased_pharmacies($organization_id,'P',$each['id']);
						if(count($pharmacy_surgery_governance_purchase_status) > 0){
							
							// Governance is Purchased for this pharmacy
							// Varify if the Governance read setting is on for this Pharmacy / Surgery
							
							$is_governance_on = $this->pharmacy->is_governance_settings_on($each['id']);
							
							if($is_governance_on){
						
								$phar_id = '';

								// Governance read status of staff member
								$governance_read = $this->governance->is_governance_read_by_user($staff['member_id'], $organization_id, $each['id'], 'ST', $staff['user_type_id']);
								if($governance_read){
									
									$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_governance_read_status'] = 1; // 1
									
								}
								else{
									
									$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_governance_read_status'] = 0; // 0
								}
							
							} else {
							
								$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_governance_read_status'] = 2;
							
							} // if($is_governance_on)
						
						} else {
							
							$all[$key]['pharmacy_surgery_staff'][$index]['staff_member_governance_read_status'] = 2;
							
						} // if(count($pharmacy_surgery_governance_purchase_status) > 0)
					
					} // if(!empty($member_org) && $member_org['owner_id'] == $staff['member_id'] && $member_org['superintent_id'] != $staff['member_id'])
					
				$index++;
				endforeach; // foreach($all_staff as $staff):
				
			} else {
				
				$all[$key]['pharmacy_surgery_staff'] = NULL; // Set Staff null 
				
			} // if(!empty($all_staff))
		
			// Fetch pending invitations of staff
			$this->db->dbprefix('invitations, users');
			
			$this->db->select('users.email_address as user_email_address, invitations.*');
			
			$this->db->from('invitations');
			$this->db->join('users', ' users.id = invitations.invitation_sent_to ', 'inner');
			
			$this->db->where('invitations.organization_id', $organization_id);
			$this->db->where('invitations.pharmacy_id', $each['id']);
			$this->db->where('invitations.status != ', '1');
			
			$invitations = $this->db->get()->result_array();
			
			if(!empty($invitations)){ // If invitations founded in invitation_sent_to 
				
				$index = 0;
				
				// Pending & Rejected Invitations
				foreach($invitations as $invitation):
			
					if($invitation['invitation_type'] == 'M') // If invitation is for the manager
						$all[$key]['manager_invitations'][$index] = $invitation;
					else
						$all[$key]['pharmacy_surgery_staff_pending_invitations'][$index] = array_merge(array('user_type' => $invitation['invitation_type']), $invitation);
					
				$index++;
				endforeach;
				
			} else {
				$index = 0;
			} // if(!empty($invitations))
				
			// Check if there are any invitations for requested as Email invitation
			$this->db->dbprefix('invitations, users');
			
			$this->db->select('*');
			
			$this->db->where('organization_id', $organization_id);
			$this->db->where('pharmacy_id', $each['id']);
			$this->db->where('invitation_sent_to IS NULL');
			$this->db->where('email_address IS NOT NULL');
			$this->db->where('invitation_type !=', "SI");
			$this->db->where('status != ', '1');
			
			$email_invitations = $this->db->get('invitations')->result_array();

			if(!empty($email_invitations)){
				
				//$index = 0;
				
				foreach($email_invitations as $each):
				
					if(!empty($each['email_address'])){
						
						$each['user_email_address'] = $each['email_address'];
						unset($each['email_address']);
					} // if(!empty($each['email_address']))
					
					if($each['invitation_type'] == 'M'){ // If email invitation is for the manager
						$all[$key]['manager_invitations'][$index] = $each;
					} else if($each['invitation_type'] != 'SI'){
						unset($each['user_type']);
						$all[$key]['pharmacy_surgery_staff_pending_invitations'][$index] = array_merge(array('user_type' => $each['invitation_type']), $each);
					} //else if($each['invitation_type'] != 'SI')
					
				$index++;
				endforeach; // foreach($email_invitations as $each):
				
			} // if(!empty($email_invitations))

		} //endforeach; // foreach($all as $key => $each):
		
		// Check to show suggession buttons on the dashboard left pane
		for($i=0; $i<count($all); $i++){
			
			if($all[$i]['manager_full_name']){
				$this->session->show_button_suggesstions = 1;
			} // if($all[0]['manager_full_name'])

		} // for($i=0; $i<count($all); $i++)


		return $all;
		
	} // End - get_all_org_pharmacies($organization_id):
	
	// Start - get_my_role_in_pharmacy_surgery($user_id, $pharmacy_surgery_id)
	public function get_my_role_in_pharmacy_surgery($user_id, $pharmacy_surgery_id = ''){

		if($pharmacy_surgery_id == ''){
	
			// Check if the user is a owner
			$this->db->dbprefix('organization');
			$this->db->where('owner_id', $user_id);
			$row = $this->db->get('organization')->row_array();
			
			if(!empty($row)){
				$data['is_owner'] = 1;
			} else {
				$data['is_owner'] = 0;
			} // if(!empty($row))
				
			// Check if the user is a superintendent
			$is_si = $this->organization->user_already_superintendent($user_id);
			if($is_si){
				$data['is_si'] = 1;
			} else {
				$data['is_si'] = 0;
			} // if(!empty($row))
				
		} // if($pharmacy_surgery_id == '')
			
		// Check if the user is a manager
		$this->db->dbprefix('org_pharmacy_surgery');
		if($pharmacy_surgery_id != '') $this->db->where('id', $pharmacy_surgery_id);
		$this->db->where('manager_id', $user_id);
		$this->db->where('is_deleted', '0');
		$manager_in = $this->db->get('org_pharmacy_surgery')->result_array();
		
		if(!empty($manager_in)){
			$data['is_manager'] = 1;
			$data['manager_in'] = $manager_in;
		} else {
			$data['is_manager'] = 0;
		} // if(!empty($manager_in))
		
		// Check if the user is a staff member
		$this->db->dbprefix('pharmacy_surgery_staff');
		if($pharmacy_surgery_id != '') $this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->where('user_id', $user_id);
		$staff_in = $this->db->get('pharmacy_surgery_staff')->result_array();
		
		if(!empty($staff_in)){
			$data['is_staff'] = 1;
			$data['staff_in'] = $staff_in;
		} else {
			$data['is_staff'] = 0;
		} //if(!empty($staff_in))
	
		return $data;
		
	} // End - get_my_role_in_pharmacy_surgery($user_id, $pharmacy_surgery_id)
	
	public function is_governance_settings_on($pharmacy_surgery_id){

		// Get Pharmacy / Surgery GOVERNANCE Settings
		$this->db->dbprefix('pharmacy_surgery_global_settings');
		$this->db->select('governance_status');
		$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		
		$settings = $this->db->get('pharmacy_surgery_global_settings')->row_array();
		
		if(!empty($settings)){
			
			if($settings['governance_status'] == 1)
				return 1;
			else
				return 0;
			
		} else {
			
			return 0;
			
		} // if(!empty($settings))
		
	} // public function is_governance_settings_on($organization_id, $pharmacy_surgery_id)
	
	//Function get_pharmacy_surgery_medicine(): This function will return the medicine if it is set by the Pharamcy/ Organization and going to use the availability
	public function get_pharmacy_surgery_medicine($pharmacy_surgery_id,$medicine_id){
		
		$this->db->dbprefix('pharmacy_medicine');
		$this->db->select('pharmacy_medicine.available_status, pharmacy_medicine.pharmacy_surgery_id');
		$this->db->where('medicine_id',$medicine_id);
		$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		
		$get = $this->db->get('pharmacy_medicine');
		
		return $get->row_array();
		
	}//function get_pharmacy_surgery_medicine($pharmacy_surgery_id,$medicine_id)


	//Function get_pharmacy_surgery_medicine_strength(): This function will return the array of strength if it is set by the Pharamcy/ Organization and going to use that price in future ownwards if exist
	public function get_pharmacy_surgery_medicine_strength($pharmacy_surgery_id,$medicine_id,$strength_id = ''){
		
		$this->db->dbprefix('pharmacy_medicine_strength');
		$this->db->select('pharma_strength.strength_id, pharma_strength.per_price');
		
		$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->where('medicine_id',$medicine_id);
		if(trim($strength_id) != '') $this->db->where('strength_id',$strength_id);
		
		$get = $this->db->get('pharmacy_medicine_strength AS pharma_strength');
		
		if(trim($strength_id) != '')
			return $get->row_array();
		else
			return $get->result_array();
		
	}//function get_pharmacy_surgery_medicine_strength($pharmacy_surgery_id,$medicine_id,$strength_id)

	//Function get_pharmacy_surgery_medicine_quantities(): This function will return the array of Quantity if it is set by the Pharamcy/ Organization and going to use that disacountin future ownwards if exist
	public function get_pharmacy_surgery_medicine_quantities($pharmacy_surgery_id,$medicine_id,$quantity_id = ''){
		
		$this->db->dbprefix('pharmacy_medicine_quantity');
		$this->db->select('medicine_quantity.id AS quantity_id,pharmacy_medicine_quantity.discount_precentage,medicine_quantity.quantity,medicine_quantity.quantity_txt');
		
		$this->db->join('medicine_quantity', 'pharmacy_medicine_quantity.medicine_qty_id = medicine_quantity.id','LEFT');
		
		$this->db->where('pharmacy_medicine_quantity.pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->where('pharmacy_medicine_quantity.medicine_id',$medicine_id);
		
		if(trim($quantity_id) != '') $this->db->where('pharmacy_medicine_quantity.medicine_qty_id',$quantity_id);
		
		$get = $this->db->get('pharmacy_medicine_quantity');
		
		if(trim($quantity_id) != '') 
			return $get->row_array();
		else
			return $get->result_array();
		
	}//function get_pharmacy_surgery_medicine_quantities($pharmacy_surgery_id,$medicine_id,$strength_id)
	
	
	//Function get_pharmacy_surgery_medicine_list(): This function will return the medicine list and price sheet of a Pharamacy. 
	public function get_pharmacy_surgery_medicine_list($pharmacy_surgery_id){

		$this->db->dbprefix('medicine');
		$this->db->select('medicine.id AS medicine_id, medicine.category_id, medicine.brand_name,medicine.medicine_name, CONCAT(brand_name," ",medicine_name) AS medicine_full_name,medicine_form.medicine_form,medicine_cat.category_title,strength.id AS strength_id,strength.strength,strength.per_price');
		
		$this->db->join('pharmacy_medicine_strength AS ph_strength', 'medicine.id = ph_strength.medicine_id','LEFT');
		$this->db->join('medicine_categories AS medicine_cat', 'medicine.category_id = medicine_cat.id','LEFT');
		$this->db->join('medicine_strength AS strength', 'medicine.id = strength.medicine_id','LEFT');
		$this->db->join('medicine_form', 'medicine_form.id = medicine.medicine_form_id','LEFT');
		
		$get = $this->db->get('medicine');
		
		//echo $this->db->last_query(); exit;
		
		$result = $get->result_array();
		
		$pharma_medicine =array();
		for($i=0;$i<count($result);$i++){
			
			//Category Info Array
			$pharma_medicine[$result[$i]['category_title']]['category_info']['category_id'] = $result[$i]['category_id'];
			$pharma_medicine[$result[$i]['category_title']]['category_info']['category_title'] = $result[$i]['category_title'];
			$pharma_medicine[$result[$i]['category_title']]['category_info']['category_subtitle'] = $result[$i]['category_subtitle'];
			
			//Category Medicine Array
			$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['brand_name'] = $result[$i]['brand_name'];
			$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_name'] = $result[$i]['medicine_name'];
			$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['medicine_full_name'] = $result[$i]['medicine_full_name'];
			$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['category_id'] = $result[$i]['category_id'];
			
			$get_pharamcy_medicine_arr = $this->pharmacy->get_pharmacy_surgery_medicine($pharmacy_surgery_id,$result[$i]['medicine_id']);
			
			if($get_pharamcy_medicine_arr)
				
				$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['available_status'] = $get_pharamcy_medicine_arr['available_status'];
			
			else
				$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['medicine_info']['available_status'] = 1;
			
			//Strength Array
			$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['strength_arr'][$result[$i]['strength_id']]['strength_id'] = $result[$i]['strength_id'];
			$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['strength_arr'][$result[$i]['strength_id']]['strength'] = $result[$i]['strength'];
			
			$get_pharamcy_medicine_strength_arr = $this->pharmacy->get_pharmacy_surgery_medicine_strength($pharmacy_surgery_id,$result[$i]['medicine_id'],$result[$i]['strength_id']);
			
			if($get_pharamcy_medicine_strength_arr)
				$strength_per_price = filter_string($get_pharamcy_medicine_strength_arr['per_price']);
			else
				$strength_per_price =  filter_string($result[$i]['per_price']);
				
				$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['strength_arr'][$result[$i]['strength_id']]['per_price'] = $strength_per_price;
			
			//Category Quantity Array
			$get_pharamcy_medicine_quantities_arr = $this->pharmacy->get_pharmacy_surgery_medicine_quantities($pharmacy_surgery_id,$result[$i]['medicine_id']);
			
			if($get_pharamcy_medicine_quantities_arr)
				$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['quantity_arr'] = $get_pharamcy_medicine_quantities_arr;

			else
				$pharma_medicine[$result[$i]['category_title']]['medicine_arr'][$result[$i]['medicine_id']]['quantity_arr'] = $this->medicine->get_medicine_quantities($result[$i]['medicine_id']);
			
			//end if($get_pharamcy_medicine_quantities_arr
			
		}//end for($i=0;$i<count($result)$i++)
		
		//print_this($pharma_medicine);
		//exit;
		
		return $pharma_medicine;
		
	}//end get_pharmacy_surgery_medicine_list($pharmacy_surgery_id)
	
	//Function update_pharmacy_medicines(): Thsi functions saves the medicine data against the pharmacy into their medicine table
	public function update_pharmacy_medicines($pharmacy_surgery_id,$organization_id,$data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$available_status = (isset($available_status)) ? $available_status : 1;
		
		//Check if the medicine is availble in Pharamcy Medicine Table.
		$chk_if_med_already_exist = $this->get_pharmacy_surgery_medicine($pharmacy_surgery_id,$medicine_id);
		
		if($chk_if_med_already_exist){
			//Update Phrmacy Medicine

			$upd_data = array(
			
				'available_status' => $this->db->escape_str($available_status),
				'modified_date' => $this->db->escape_str($created_date),
				'modified_by_ip' => $this->db->escape_str($created_by_ip)
			);
			
			$this->db->dbprefix('pharmacy_medicine');
			$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
			$this->db->where('medicine_id', $medicine_id);
			$upd_into_db = $this->db->update('pharmacy_medicine', $upd_data);
		
		}else{
			//Insert Phrmacy Medicine

				$ins_data = array(
				
					'medicine_id' => $this->db->escape_str($medicine_id),
					'available_status' => $this->db->escape_str($available_status),
					'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
					'created_date' => $this->db->escape_str($created_date),
					'created_by_ip' => $this->db->escape_str($created_by_ip)
				);
				
				$this->db->dbprefix('pharmacy_medicine');
				$ins_into_db = $this->db->insert('pharmacy_medicine', $ins_data);
				
		}//end if($chk_if_med_already_exist) 

		//Check if the medicine strengtth is available in Pharamcy Medicine Strength Table.
		$chk_if_med_strength_already_exist = $this->get_pharmacy_surgery_medicine_strength($pharmacy_surgery_id,$medicine_id);
		
		if($chk_if_med_strength_already_exist){
			//Already Exist Do update

			if(count($price_per_qty) > 0){
				
				foreach($price_per_qty as $strength_id => $strength_price){

					$upd_data = array(
					
						'per_price' => $this->db->escape_str(trim($strength_price)),
						'modified_date' => $this->db->escape_str($created_date),
						'modified_by_ip' => $this->db->escape_str($created_by_ip)
					);
					
					$this->db->dbprefix('pharmacy_medicine_strength');
					$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
					$this->db->where('medicine_id', $medicine_id);
					$this->db->where('strength_id', $strength_id);
					
					$upd_into_db = $this->db->update('pharmacy_medicine_strength', $upd_data);
					
				}//end foreach($price_per_qty as $strength_id => $strength_arr)
					
			}//end if(count($price_per_qty) > 0)
			
		}else{
			//Do not Exist Do Insert
			
			if(count($price_per_qty) > 0){
				
				foreach($price_per_qty as $strength_id => $strength_price){

					$ins_data = array(
					
						'medicine_id' => $this->db->escape_str($medicine_id),
						'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
						'organization_id' => $this->db->escape_str(trim($organization_id)),
						'strength_id' => $this->db->escape_str(trim($strength_id)),
						'per_price' => $this->db->escape_str(trim($strength_price)),
						'created_date' => $this->db->escape_str($created_date),
						'created_by_ip' => $this->db->escape_str($created_by_ip)
					);
					
					$this->db->dbprefix('pharmacy_medicine_strength');
					$ins_into_db = $this->db->insert('pharmacy_medicine_strength', $ins_data);
					
				}//end foreach($price_per_qty as $strength_id => $strength_arr)
					
			}//end if(count($price_per_qty) > 0)
			
		}//end if($chk_if_med_strength_already_exist)
		
		
		//Check if the medicine quantity is available in Pharamcy Quantity Table.
		$chk_if_med_quantities_already_exist = $this->get_pharmacy_surgery_medicine_quantities($pharmacy_surgery_id,$medicine_id);
		
		if($chk_if_med_quantities_already_exist){
			//Update Quantities

			if(count($med_quantity) > 0){
				
				foreach($med_quantity as $quantity_id => $qty_discount){

					$upd_data = array(
					
						'discount_precentage' => $this->db->escape_str(trim($qty_discount)),
						'modified_date' => $this->db->escape_str($created_date),
						'modified_by_ip' => $this->db->escape_str($created_by_ip)

					);
					
					$this->db->dbprefix('pharmacy_medicine_quantity');
					$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
					$this->db->where('medicine_id', $medicine_id);
					$this->db->where('medicine_qty_id', $quantity_id);
					
					$upd_into_db = $this->db->update('pharmacy_medicine_quantity', $upd_data);
					//echo $this->db->last_query(); exit;
				}//end foreach($price_per_qty as $strength_id => $strength_arr)
			
			}//end if(count($med_quantity) > 0)
			
			
		}else{
			//Insert Quantities	

			if(count($med_quantity) > 0){
				
				foreach($med_quantity as $quantity_id => $qty_discount){

					$ins_data = array(
					
						'medicine_id' => $this->db->escape_str($medicine_id),
						'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
						'organization_id' => $this->db->escape_str(trim($organization_id)),
						'medicine_qty_id' => $this->db->escape_str(trim($quantity_id)),
						'discount_precentage' => $this->db->escape_str(trim($qty_discount)),
						'created_date' => $this->db->escape_str($created_date),
						'created_by_ip' => $this->db->escape_str($created_by_ip)
					);
					
					$this->db->dbprefix('pharmacy_medicine_quantity');
					$ins_into_db = $this->db->insert('pharmacy_medicine_quantity', $ins_data);
					
				}//end foreach($price_per_qty as $strength_id => $strength_arr)
			
			}//end if(count($med_quantity) > 0)
			
		}//end if($chk_if_med_quantities_already_exist)

		return true;
		
	}//end update_pharmacy_medicines($pharmacy_surgery_id,$organization_id,$data)
	
	// Start - get_pharmacy_surgery_time_settings_details($pharmacy_id)
	public function get_pharmacy_surgery_time_settings_details($pharmacy_id){
		
		$this->db->dbprefix('pharmacy_surgery_timings');
		$this->db->where('pharmacy_surgery_id', $pharmacy_id);
		
		return $this->db->get('pharmacy_surgery_timings')->row_array();
		
	} // End - get_pharmacy_surgery_time_settings_details($pharmacy_id)
	
	public function get_pharmacy_surgery_global_settings_details($pharmacy_id){
	// Fetch Pharmacy surgery global settings
		$this->db->dbprefix('pharmacy_surgery_global_settings');
		$this->db->where('pharmacy_surgery_id', $pharmacy_id);
		return $this->db->get('pharmacy_surgery_global_settings')->row_array();
	}

	//Function search_cheap_pharmacies(): Get the Cheap Pharamcies whose Online Doctor is YES!
	public function search_cheap_pharmacies($medicine_id,$strength_id,$quantity_id,$num_of_record = '',$pharmacy_surgery_id = '',$pharamcy_postcode = ''){
		
		if(is_array($quantity_id)) // If request is from the helper : extract quantity ID from array
			$quantity_id = $quantity_id[0]['quantity_id'];
		// if(is_array($quantity_id))

		// Remove space
		$pharamcy_postcode = str_replace(' ', '', $pharamcy_postcode);
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.id AS pharmacy_surgery_id, org_pharmacy_surgery.pharmacy_surgery_name, org_pharmacy_surgery.address, org_pharmacy_surgery.postcode, org_pharmacy_surgery.contact_no,
							pharmacy_surgery_global_settings.online_doctor_status,
							organization.prescriber_fees,
						');
		
		$this->db->join('pharmacy_surgery_global_settings', 'org_pharmacy_surgery.id = pharmacy_surgery_global_settings.pharmacy_surgery_id ','LEFT');
		$this->db->join('organization', 'organization.id = org_pharmacy_surgery.organization_id ','LEFT');
		
		// $this->db->where('pharmacy_surgery_global_settings.online_doctor_status',1);
		$this->db->where('org_pharmacy_surgery.is_deleted','0');
		
		if(trim($pharmacy_surgery_id) != '') $this->db->where('org_pharmacy_surgery.id',$pharmacy_surgery_id);
		if(trim($pharamcy_postcode) != '') $this->db->where('org_pharmacy_surgery.postcode',$pharamcy_postcode);
		
		$get = $this->db->get('org_pharmacy_surgery');
		//echo $this->db->last_query(); exit;
		
		$pharmacy_result = $get->result_array();
		$price_sort_key = array();
		$cheap_rates = array();
		$price_sort_key = array();
		
		$get_medicine_strength_arr = $this->medicine->get_medicine_strength($medicine_id, $strength_id); 
		$get_medicine_quantities = $this->medicine->get_medicine_quantities($medicine_id, $quantity_id);
		
		if($get_medicine_strength_arr && $get_medicine_quantities){
		
			for($i=0;$i<count($pharmacy_result);$i++){
				
				$pharmacy_presription_fee = ($pharmacy_result[$i]['prescriber_fees'] == NULL) ? 0.00 : $pharmacy_result[$i]['prescriber_fees'];
				
				//Check if Medicine is set to Available or not against the Pharmacy. If no result found will mark as available.
				//$get_pharamcy_medicine_arr = $this->pharmacy->get_pharmacy_surgery_medicine($pharmacy_result[$i]['pharmacy_surgery_id'],$medicine_id);
				$medicine_available_status = 1; //($get_pharamcy_medicine_arr) ? $get_pharamcy_medicine_arr['available_status'] : 1;
				
				if($medicine_available_status){
	
					//Get Pharmacy Strength Details, If found use the price else use the default price.
					$get_pharamcy_medicine_strength_arr = $this->pharmacy->get_pharmacy_surgery_medicine_strength($pharmacy_result[$i]['pharmacy_surgery_id'],$medicine_id,$strength_id);
					
					if($get_pharamcy_medicine_strength_arr){
						
						$medicine_per_price = filter_string($get_pharamcy_medicine_strength_arr['per_price']);
						
						$pharmacy_result[$i]['strength_per_price'] = $medicine_per_price;
						$pharmacy_result[$i]['strength'] = filter_string($get_pharamcy_medicine_strength_arr['strength']);
						
					}else{
						//Get Default Price.
						
						$medicine_per_price = filter_string($get_medicine_strength_arr['per_price']);
						
						$pharmacy_result[$i]['strength_per_price'] = $medicine_per_price;
						$pharmacy_result[$i]['strength'] = filter_string($get_medicine_strength_arr['strength']);
						
					}//end if($get_pharamcy_medicine_strength_arr)
					
					//Category Pharmacy Quantity to know the discount.
					$get_pharamcy_medicine_quantities_arr = $this->pharmacy->get_pharmacy_surgery_medicine_quantities($pharmacy_result[$i]['pharmacy_surgery_id'],$medicine_id,$quantity_id);

					if($get_pharamcy_medicine_quantities_arr){
						
						$medicine_discount = $get_pharamcy_medicine_quantities_arr['discount_precentage'];
						$medicine_quantity = $get_pharamcy_medicine_quantities_arr['quantity'];
						
						$pharmacy_result[$i]['quantity_id'] = $quantity_id;					
						$pharmacy_result[$i]['quantity'] = $medicine_quantity;
						$pharmacy_result[$i]['quantity_discount'] = $medicine_discount;
						
					}else{
						//Get the Default Quantities
						
						$medicine_quantity = $get_medicine_quantities['quantity'];
						$medicine_discount = $get_medicine_quantities['discount_precentage'];
						
						$pharmacy_result[$i]['quantity_id'] = $quantity_id;
						$pharmacy_result[$i]['quantity'] = $medicine_quantity;
						$pharmacy_result[$i]['quantity_discount'] = $medicine_discount;
					
					}//end if($get_pharamcy_medicine_quantities_arr
	
					$medicine_subtotal = ($medicine_per_price * $medicine_quantity); //Med Sub total
					$calc_discount_price = (($medicine_subtotal) / 100) * $medicine_discount; //Calculate Discacount
					$total_medicine_price = ($medicine_subtotal - $calc_discount_price) + $pharmacy_presription_fee; //Total Medicine Price
					
					$price_sort_key[] = filter_price($total_medicine_price); //Used for sorting
					$pharmacy_result[$i]['total_medicine_price'] = filter_price($total_medicine_price);
					
					$cheap_rates[] = $pharmacy_result[$i];
					
				}//end if($medicine_available_status)
	
			}//end for($i=0;$i<count($pharmacy_result)$i++)
		
			//Sorting for cheap Rates.
			array_multisort($price_sort_key, SORT_ASC, $cheap_rates);
			
			//Limit the number of records.
			if(trim($num_of_record) != '')
				$cheap_rates = array_slice($cheap_rates,0,$num_of_record);
		
		}//end if($get_medicine_strength_arr && $get_medicine_quantities)

		return $cheap_rates;
		
	}//end search_cheap_pharmacies()

	//Function update_pharmacy_medicines(): Thsi functions saves the medicine data against the pharmacy into their medicine table
	public function update_pharmacy_no_of_surveys($no_of_surveys, $pharmacy_surgery_id){

		$upd_data = array('no_of_surveys' => $no_of_surveys);
		//update  data into the database. 
		$this->db->dbprefix('pharmacy_surgery_global_settings');
		$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		$upd_into_db = $this->db->update('pharmacy_surgery_global_settings', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
	
	}//end update_pharmacy_no_of_surveys($no_of_surveys, $pharmacy_surgery_id)
	
	public function import_new_pharmacies($organization_id, $pharmacy_arr){
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		for($i=0;$i<count($pharmacy_arr);$i++){
		
			$postcode = str_replace(' ', '', $pharmacy_arr[$i]->LocationPostcode);
			
			$pharmacy_already_exist = $this->pharmacy->get_pharmacy_by_name_postcode($organization_id, $pharmacy_arr[$i]->LocationName, postcode);
			
			if(!$pharmacy_already_exist){
				
				//Record insert into database
				$ins_data = array(
				
					'organization_id' => $this->db->escape_str(trim($organization_id)),
					'type' => $this->db->escape_str(trim('P')),
					'pharmacy_surgery_name' => $this->db->escape_str(trim($pharmacy_arr[$i]->LocationName)),
					'address' => $this->db->escape_str(trim($pharmacy_arr[$i]->LocationAddress)),
					'postcode' => $this->db->escape_str(trim($postcode)),
					'contact_no' => $this->db->escape_str(trim($pharmacy_arr[$i]->LocationPhoneNumber)),
					'gphc_no' => $this->db->escape_str(trim($pharmacy_arr[$i]->LocationGPHC)),
					'f_code' => $this->db->escape_str(trim($pharmacy_arr[$i]->LocationODS)),
					'country_id' => $this->db->escape_str('1'),
					'created_date' => date('Y-m-d H:i:s'),
					'created_by_ip' => $this->input->ip_address()
					
				);
					
				//update  data into the database. 
				$this->db->dbprefix('org_pharmacy_surgery');
				$ins_into_db = $this->db->insert('org_pharmacy_surgery', $ins_data);

			}//end if(!$pharmacy_already_exist)
					
		
		}//end for($i=0;$i<count($pharmacy_arr);$i++)
		
		return true;
			
		//end if($ins_into_db)
		
	}//end import_new_pharmacies($organization_id, $pharmacy_arr)
	
	/*
	public function pharmacy_website_info_notification($data){
		
		extract($data);

		$upd_data = array(
			'website_info_provided' => '1'
		);
		
		//update  data into the database. 
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->where('id',$pharmacy_id);
		$upd_into_db = $this->db->update('org_pharmacy_surgery', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db){
			
			$get_pharamcy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_id);

			$email_subject = 'Hubnet New Website Registration Information Received';
			
			$email_body = '
				<table cellpadding="2" cellspacing="2" width="80%" style="font-family:Arial, Helvetica, sans-serif; font-size:14px">
				<tr>
					<td width="37%"><strong>Pharmacy ID</strong></td>
					<td width="63%">'.filter_string($get_pharamcy_details['id']).'</td>
				</tr>
				<tr>
					<td width="37%"><strong>Pharmacy/ Surgery Name</strong></td>
					<td width="63%">'.filter_string($get_pharamcy_details['pharmacy_surgery_name']).'</td>
				</tr>

				<tr>
					<td width="37%"><strong>Pharmacy Website URL</strong></td>
					<td width="63%">'.$website_url.'</td>
				</tr>

				<tr>
					<td width="37%"><strong>Template ID</strong></td>
					<td width="63%">'.$template_id.'</td>
				</tr>

				<tr>
					<td width="37%"><strong>Pharmacy Login Email</strong></td>
					<td width="63%">'.$pharmacy_email_address.'</td>
				</tr>

				<tr>
					<td width="37%"><strong>Password</strong></td>
					<td width="63%">'.$pharmacy_password.'</td>
				</tr>
				
				<tr>
					<td><strong>Request Date</strong></td>
					<td>'.date("d/m/Y G:i:s").'</td>
				</tr>
			
			</table>			
			';

			//exit;
			
			$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
			$noreply_email = get_global_settings($NOREPLY_EMAIL);
			
			$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
			$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
			
			$from = filter_string($noreply_email['setting_value']);
			$from_name = filter_string($email_from_txt['setting_value']);
			
			$to = trim('twister787@gmail.com, iwebpros@gmail.com');
			
			$subject = filter_string($email_subject);
			$email_body = filter_string($email_body);
					
			// Call from Helper send_email function
			$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
			
			return true;
			
		}else
			return false;
		
		
	}//end pharmacy_website_info_notification($data)
	*/
	
} //end file
?>