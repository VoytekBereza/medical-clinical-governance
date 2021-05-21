<?php
class Organization_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	//Function verify_if_user_in_organization():
	public function verify_if_user_in_organization($user_id){

		$quiz_qry = "SELECT (
				
					EXISTS (SELECT id from kod_organization where superintendent_id = ".$user_id.") OR 
					EXISTS (SELECT id from kod_org_pharmacy_surgery where manager_id = ".$user_id." AND is_deleted = '0') OR
					EXISTS (SELECT id from kod_users where is_owner = 1 AND id = ".$user_id.") OR
					EXISTS (SELECT id from kod_pharmacy_surgery_staff where user_id = ".$user_id.") 
				
				) AS is_part_of_organization;";

		$rs  = $this->db->query($quiz_qry);
		$result = $rs->row_array();
		//echo $this->db->last_query(); 		exit;

		return $result['is_part_of_organization'];

	}//end verify_if_user_in_organization($user_id)

	public function get_my_organizations($user_id){
		
		//Organization Table
		$this->db->dbprefix('organization');
		$this->db->select('organization.id, organization.company_name, organization.address, organization.postcode');
		$this->db->where('owner_id', $user_id);
		$this->db->or_where('superintendent_id', $user_id);
		
		$get = $this->db->get('organization');
		
		$organization_arr = $get->result_array();

		//User table for Manager
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('organization.id, organization.company_name, organization.address, organization.postcode');
		
		$this->db->where('org_pharmacy_surgery.manager_id', $user_id);
		
		$this->db->join('organization','org_pharmacy_surgery.organization_id = organization.id', 'left');
		
		$get_manager = $this->db->get('org_pharmacy_surgery');
		$manager_org = $get_manager->result_array();
		
		$organization_arr = array_merge($organization_arr,$manager_org);
		
		//Staff Members

		//User table for Manager
		$this->db->dbprefix('pharmacy_surgery_staff');
		$this->db->select('organization.id, organization.company_name, organization.address, organization.postcode');
		
		$this->db->where('pharmacy_surgery_staff.user_id', $user_id);
		
		$this->db->join('organization','pharmacy_surgery_staff.organization_id = organization.id', 'left');
		
		$get_staff = $this->db->get('pharmacy_surgery_staff');
		$staff_org = $get_staff->result_array();
		
		$organization_arr = array_merge($organization_arr,$staff_org);
		
		return $organization_arr;
		
	}//end get_my_organizations($user_id)
		
	//Function user_already_superintendent(): Will check if the user ID already is a SI in any organization already.
	public function user_already_superintendent($user_id){

		$this->db->dbprefix('organization');
		$this->db->select('organization.*,org_global_settings.governance_status, org_global_settings.online_doctor_status, org_global_settings.survey_status, org_global_settings.pmr_status,	users.id AS superintendent_user_id,users.user_type AS si_user_type, users.first_name AS si_first_name, users.last_name AS si_last_name, CONCAT(first_name," ",last_name) AS superintendent_full_name, users.email_address as si_email_address, users.registration_no si_registration,  users.registration_type AS si_registration_type, users.is_prescriber AS si_is_prescriber');
		$this->db->where('organization.superintendent_id',$user_id);
		
		$this->db->join('users','users.id = organization.superintendent_id','LEFT');
		$this->db->join('org_global_settings','organization.id = org_global_settings.organization_id','LEFT');
		$get = $this->db->get('organization');
		//echo $this->db->last_query(); 		exit;
		
		return $get->row_array();
		
	}//end user_already_superintendent()

	//Function get_organization_details(): Fetch teh Organization details from organization table using Organiation_id along with SI 
	public function get_organization_details($org_id){
		
		$this->db->dbprefix('organization');
		$this->db->select('organization.*,org_global_settings.governance_status, org_global_settings.online_doctor_status, org_global_settings.survey_status, org_global_settings.pmr_status,users.id AS superintendent_user_id,users.user_type AS si_user_type, users.first_name AS si_first_name, users.last_name AS si_last_name, CONCAT(first_name," ",last_name) AS superintendent_full_name, users.email_address as si_email_address, users.registration_no si_registration, users.registration_type AS si_registration_type, users.is_prescriber AS si_is_prescriber, country.country_name');
		$this->db->where('organization.id',$org_id);
		
		$this->db->join('users','users.id = organization.superintendent_id','LEFT');
		$this->db->join('org_global_settings','organization.id = org_global_settings.organization_id','LEFT');
		$this->db->join('country','organization.country_id = country.id','LEFT');
		
		$get = $this->db->get('organization');
		$row_arr = $get->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	}//end get_organization_details
	
	// Function get_pharmacy_details(): Fetch pharmacy_surgery details from pharmacy_surgery table using pharmacy_surgery_id along with M
	public function get_pharmacy_details($pharmacy_surgery_id){
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.*,users.id AS manager_user_id,users.user_type AS m_user_type, users.first_name AS m_first_name, users.last_name AS m_last_name, CONCAT(first_name," ",last_name) AS manager_full_name, users.email_address as m_email_address, users.registration_no AS m_registration, users.registration_type AS m_registration_type, users.is_prescriber AS m_is_prescriber');
		$this->db->where('org_pharmacy_surgery.id',$pharmacy_surgery_id);
		
		$this->db->join('users','users.id = org_pharmacy_surgery.manager_id','LEFT');
		$get = $this->db->get('org_pharmacy_surgery');
		$row_arr = $get->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	} //end get_pharmacy_details
	
	// Function invitation_response($user_id, $organization_id, $invitation_data, $invitation_type, $user_org_superintendent): This function will elect SupterIntendent, will remove all the invitations and update/ overwrite the Organization table with the New Supterintendent ID
	public function invitation_response($user_id, $organization_id, $invitation_data, $invitation_type, $user_org_superintendent){
		
		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();
		$ins_data2 = array();
		
		// Get user Details
		$user_details = $this->users->get_user_details($user_id);
		$no_contract = $invitation_data['no_contract'];

		if($invitation_type == 'SI'){
			
			//Before updating the SI, we need to remove the track record like governance record of the existing SI from the database and after insertion place a new one.

			//Deleting the GOVERNANCE record of previous USER from the Governance and SOP Read table
			$get_organization_detail = $this->organization->get_organization_details($organization_id);
			
			$old_superintendent_id = $get_organization_detail['superintendent_id'];
		
			if($old_superintendent_id != 0)
				$delete_governance = $this->governance->delete_user_governance_read_record($old_superintendent_id,$organization_id,'', 'SI');

			//Record Update into database
			$upd_data = array(
			
				'superintendent_id' => $this->db->escape_str(trim($user_id)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
				'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->where('id',$organization_id);
			$this->db->dbprefix('organization');
			$upd_into_db = $this->db->update('organization', $upd_data);
			
			// Verify if the user requested as a staff is the manager in the same pharmacy_id
			$role_in_pharmacy_surgery = $this->pharmacy->get_my_role_in_pharmacy_surgery($user_id, $invitation_data['pharmacy_id']);
			
			// In case SI hr_read = 1 else 0 || If the user is the manager in the same Pharmacy / Surgery
			if($role_in_pharmacy_surgery['is_manager'] == 1 || $role_in_pharmacy_surgery['is_staff'] == 1){

				if($role_in_pharmacy_surgery['is_staff'] == 1)
					$varify_governance_as = 'ST'; // In case if is staff

				if($role_in_pharmacy_surgery['is_manager'] == 1)
					$varify_governance_as = 'M'; // In case if is manager
				// if($role_in_pharmacy_surgery['is_manager'] == 1)
					
				/////////////////////////////////////////////////////////////////////////////////
				// Merger all the pharmacies and surgeries to whome user belongs to as [ M - ST ]

				// 1- Get list of all pharmacies / surgeries to whome the user belongs as Manager
				if( $role_in_pharmacy_surgery['staff_in'] && count($role_in_pharmacy_surgery['staff_in'] > 0) )
					$staff_in_arr = $role_in_pharmacy_surgery['staff_in'];
				else
					$staff_in_arr = array();
				// if( count($role_in_pharmacy_surgery['staff_in'] > 0) )

				// 2- Get list of all pharmacies / surgeries to whome the user belongs as Manager
				if( $role_in_pharmacy_surgery['manager_in'] && count($role_in_pharmacy_surgery['manager_in'] > 0) )
					$manager_in_arr = $role_in_pharmacy_surgery['manager_in'];
				else
					$manager_in_arr = array();
				// if( count($role_in_pharmacy_surgery['manager_in'] > 0) )

				// merge both arrays [ Pharmacies / Surgeries ]
				$all_pharmacies_surgeries_user_belongs_to = array_merge($staff_in_arr, $manager_in_arr);
				$governance_purchase_status = 0; // default set to 0

				// Verify if governance is purchased for any of the pharmacy / surgery list
				foreach($all_pharmacies_surgeries_user_belongs_to as $pharmacy_surgery){
					
					$governance_purchased_status = $this->governance->get_governance_purchased_pharmacies( $organization_id, 'P', $pharmacy_surgery['pharmacy_surgery_id'] );

					if(count($governance_purchased_status) > 0){ 

						$governance_purchase_status = 1;

					} // if(count($this->governance_purchased_pharmacies) > 0)

				} // foreach($all_pharmacies_surgeries_user_belongs_to as $pharmacy_surgery)
				
				// If governance is purchased
				if($governance_purchase_status == 1){

					//Veirfy if the Governance is read by any role, first check if it is read as a STAFF if no, then will check as a MANAGAER and will pick that array and will create teh copy of that into new invitation.
					if($role_in_pharmacy_surgery['is_staff'] == 1){
						
						$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, $invitation_data['pharmacy_id'], 'ST', $user_details['user_type_id']);

					}//end if($role_in_pharmacy_surgery['is_staff'] == 1)
					
					if(!$governance_read_list && $role_in_pharmacy_surgery['is_manager']){
						
						$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, $invitation_data['pharmacy_id'], 'M', $user_details['user_type_id']);
						
					}//end if(!$governance_read_list || $role_in_pharmacy_surgery['is_staff'])

					if($governance_read_list){
						
						// Make copy of Sop's for the user 
						$org_sops = $this->governance->get_organization_sop_list($organization_id, $user_details['user_type_id']);
						
						if(!empty($governance_read_list)){
					
							foreach($governance_read_list as $sop_read){
								
								$sop = $this->governance->get_organization_sop_details($sop_read['sop_id']);
								
								// Mark sop as read as the staff member of the same Pharmacy / Surgery
								$this->governance->mark_organization_sop_read($user_id,'',$sop, $user_org_superintendent, 'SI','1','1');
								
							} // foreach($org_sops as $sop)
							
						} // if(!empty($org_sops))
							
					} // if($governance_read_list)

				} // if($governance_purchase_status == 1)
				
			} // if($role_in_pharmacy_surgery['is_manager'] == 1 || $role_in_pharmacy_surgery['is_staff'] == 1)
			
		} else if($invitation_type == 'M') {
		
			$ins_data2['pharmacy_surgery_id'] = $invitation_data['pharmacy_id'];
		
			//Before updating the M, we need to remove the track record like governance record of the existing M from the database and after insertion place a new one.

			//Deleting the GOVERNANCE record of previous USER from the Governance and SOP Read table
			
			$get_pharmacy_surgery_detail = $this->organization->get_pharmacy_details($invitation_data['pharmacy_id']);
			$old_manager_id = $get_pharmacy_surgery_detail['manager_id'];
		
			if($old_manager_id != 0)
				$delete_governance = $this->governance->delete_user_governance_read_record($old_manager_id, $organization_id, $invitation_data['pharmacy_id'], 'M');

			// Record Update into database
			$upd_data = array(
			
				'manager_id' => $this->db->escape_str(trim($user_id)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
				'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->dbprefix('org_pharmacy_surgery');
			$this->db->where('id',$invitation_data['pharmacy_id']);
			$upd_into_db = $this->db->update('org_pharmacy_surgery', $upd_data);
			
		} else { // Accept request as a staff member
			
			// Verify if the user is already added as a staff member for the same organization/pharmacy_surgery ?
			$this->db->dbprefix('pharmacy_surgery_staff');
			$this->db->where('pharmacy_surgery_id', $this->db->escape_str(trim($invitation_data['pharmacy_id'])));
			$this->db->where('user_id', $this->db->escape_str(trim($user_id)));
			$this->db->where('organization_id', $this->db->escape_str(trim($organization_id)));
			$member_already = $this->db->get('pharmacy_surgery_staff')->row_array();
			$upd_into_db=1;
			if($member_already == ''){
		
				// Add Record into database as a staff member
				$ins_data = array(
				
					'pharmacy_surgery_id' => $this->db->escape_str(trim($invitation_data['pharmacy_id'])),
					'user_id' => $this->db->escape_str(trim($user_id)),
					'organization_id' => $this->db->escape_str(trim($organization_id)),
					'created_date' => $this->db->escape_str(trim(date('Y-m-d H:i:s'))),
					'created_by_ip' => $this->db->escape_str(trim($modified_by_ip))
				);
				
				$this->db->dbprefix('pharmacy_surgery_staff');
				$upd_into_db = $this->db->insert('pharmacy_surgery_staff', $ins_data);
			
			} // if($member_already == '')
		
			$ins_data2['pharmacy_surgery_id'] = $invitation_data['pharmacy_id'];	
		
		} // if($invitation_type == 'SI') OR 'M' OR 'STAFF'
		
		
		if($invitation_type == 'M' || $invitation_type == 'ST'){

			// Verify if the user requested as a staff is the manager in the same pharmacy_id
			$role_in_pharmacy_surgery = $this->pharmacy->get_my_role_in_pharmacy_surgery($user_id, $invitation_data['pharmacy_id']);
			
			if($invitation_type == 'M'){ // If invitation is for manager : Check governance read as staff
			
				$request_for = 'ST';
				$role_in_pharmacy = $role_in_pharmacy_surgery['is_staff'];

			} else if($invitation_type == 'ST'){ // If invitation is for staff : Check governance read as manager
				
				$request_for = 'M';
				$role_in_pharmacy = $role_in_pharmacy_surgery['is_manager'];

			}// $request_for

			// In case SI hr_read = 1 else 0 || If the user is the manager in the same Pharmacy / Surgery
			if(!empty($user_org_superintendent) || $role_in_pharmacy == 1){
				
				// Varify If governance is read by the user
				if($role_in_pharmacy == 1){
					$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, $invitation_data['pharmacy_id'], $request_for, $user_details['user_type_id']);
						
					$governance_purchased_status = $this->governance->get_governance_purchased_pharmacies($organization_id, 'P', $invitation_data['pharmacy_id']);
				}

				// If superintendent then will check if the organization has purchased the governance for any pharmacy AND SI governance is read.
				if($user_org_superintendent){
					
					$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, '', 'SI', $user_details['user_type_id']);
					$governance_purchased_status = $this->governance->get_governance_purchased_pharmacies($organization_id, 'P');

				} // if($user_org_superintendent)

				if($governance_read_list && count($governance_purchased_status) > 0){
					
					// Make copy of Sop's for the user
					$org_sops = $this->governance->get_organization_sop_list($organization_id, $user_details['user_type_id']);
					
					
					if(!empty($governance_read_list)){
				
						foreach($governance_read_list as $sop_read){
							
							$sop = $this->governance->get_organization_sop_details($sop_read['sop_id']);
							
							// Mark sop as read as the staff member of the same Pharmacy / Surgery
							$this->governance->mark_organization_sop_read($user_id,$invitation_data['pharmacy_id'],$sop, $user_org_superintendent, $invitation_type,'1','1');
							
						} // foreach($governance_read_list as $sop)
						
					} // if(!empty($governance_read_list))
						
				} // if($governance_read_list)
				
			} // if(!empty($user_org_superintendent) || $role_in_pharmacy_surgery['is_manager'] == 1)
			
		} // if($invitation_type == 'M' || $invitation_type == 'ST')

		// Common for all [ SI - M - .... ]
		if($upd_into_db){

			// Deleting the INVITATIONS from the invite table
			$this->db->dbprefix('invitations');
			$this->db->where('id', $invitation_data['id']);
			$this->db->where('organization_id',$organization_id);
			//$this->db->where('invitation_type', $invitation_type);
			$delete_inv = $this->db->delete('invitations');
			
			/*--------------------------------------------------------------------------------------*/
			// INSERTING the GOVERNANCE READ Record into the database with Status as [ read - unread ]
			/*--------------------------------------------------------------------------------------*/
			
			$governance_data_arr = $this->governance->get_org_governance_details('',$organization_id);
			$governance_id = $governance_data_arr['id'];
			
			if($invitation_type != 'SI' && $invitation_type != 'M' && $invitation_type != 'ST')
				$invitation_type = 'ST';
			// if($invitation_type != 'SI' || $invitation_type != 'M' || $invitation_type != 'ST')
			
			$hr_contract_str = $invitation_data['hr_contract'];
			$hr_contract_str = str_replace('[SIGNED_DATE_TIME]','Signed at '.date('G:i').' on '.date('d/m/y').' by',$hr_contract_str);
			

			$view_code =  $this->common->random_number_generator(15);
			$view_code = strtoupper($view_code);
			
			$ins_data = array(
			
				'user_id' => $this->db->escape_str(trim($user_id)),
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'governance_id' => $this->db->escape_str(trim($governance_id)),
				'user_role' => $this->db->escape_str(trim($invitation_type)),
				'hr_read' => $this->db->escape_str(1), 
				'hr_contract' => $this->db->escape_str($hr_contract_str),
				
				'hr_contract_sent_by' => $this->db->escape_str($invitation_data['invitation_sent_by']),
				'hr_contract_sent_date' => $this->db->escape_str($invitation_data['created_date']),
				'hr_contract_sent_by_ip' => $this->db->escape_str($invitation_data['created_by_ip']),
				'view_code' => $this->db->escape_str($view_code),
				
				'hr_contract_viewed_date' => $this->db->escape_str($invitation_data['viewed_date']),
				'hr_contract_viewed_ip' => $this->db->escape_str($invitation_data['viewed_ip']),
				
				'no_contract' => $this->db->escape_str(trim($no_contract)),
				'created_date' => $this->db->escape_str(trim($modified_date)),
				'created_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$ins_data = array_merge($ins_data, $ins_data2);
			
			//Inserting User data into the database. 
			$this->db->dbprefix('governance_read_status');
			$ins_into_db = $this->db->insert('governance_read_status', $ins_data);
		
		} // End - if($upd_into_db)
		
		return true;

	} // End - invitation_response($user_id, $organization_id, $invitation_data, $invitation_type)
	
	// Start - get_governance_by_id($governance_id)
	public function get_governance_by_id($governance_id){
		
		$this->db->dbprefix('org_governance');
		$this->db->where('id', $governance_id);
		return $this->db->get('org_governance')->row_array();
		
	} // End - get_governance_by_id($governance_id)

	//Function get_organization_global_settings(): Grab the global settings of the organization table
	public function get_organization_global_settings($organization_id){
		
		$this->db->dbprefix('org_global_settings');
		$this->db->where('organization_id', $organization_id);
		$get = $this->db->get('org_global_settings');
		return $get->row_array();
		
	}//end get_organization_global_settings($organization_id)

	// Start - update_organization_settings($organization_id,$data)
	public function update_organization_settings($organization_id, $post){
		
		extract($post);
		
		$update = array("$field" => $value);
		
		if($pharmacy_surgery_id == 0){
			
			$this->db->dbprefix('org_global_settings');
			$this->db->where('organization_id', $organization_id);
			
			$upd_status = $this->db->update('org_global_settings', $update);
			
			if($upd_status){
				//Update the Local settings accordingly so all local settings reflects the new Organization Global Settings Changes
				if($field == 'governance_status'){
					
					$get_organization_pharmacies_list = $this->pharmacy->get_pharmacy_surgery_list($organization_id);
					
					for($i=0;$i<count($get_organization_pharmacies_list);$i++){
						
						//Check if Pharamcy Governance is Purchased, if Yes then set to Inactive
						$governance_purchased_pharmacy = $this->governance->get_governance_purchased_pharmacies($organization_id,'P',$get_organization_pharmacies_list[$i]['pharmacy_surgery_id']);

						if($governance_purchased_pharmacy){
							
							//Update all Local Settings of Pharmacies
							$this->db->dbprefix('pharmacy_surgery_global_settings');
							$this->db->where('organization_id', $organization_id);
							$this->db->where('pharmacy_surgery_id', $get_organization_pharmacies_list[$i]['pharmacy_surgery_id']);
							$upd_status = $this->db->update('pharmacy_surgery_global_settings', $update);
							//echo $this->db->last_query(); 		exit;
						}//end if($governance_purchased_pharmacy)
						
					}//end for($i=0;$i<count($$get_organization_pharmacies_list);$i++)
					
				}else{

					//Update all Local Settings of Pharmacies
					$this->db->dbprefix('pharmacy_surgery_global_settings');
					$this->db->where('organization_id', $organization_id);
					$upd_status = $this->db->update('pharmacy_surgery_global_settings', $update);
					//echo $this->db->last_query(); 		exit;
					
				}//end if($field == 'governance_status')
				
			}//end if($upd_status)
		
		} else {
		
			$this->db->dbprefix('pharmacy_surgery_global_settings');
			$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
			
			$upd_status = $this->db->update('pharmacy_surgery_global_settings', $update);
			
		} // End - if($pharmacy_surgery_id == 0)
		
		if($upd_status)
			return true;
		else 
			return false;
		
	} // update_organization_settings($organization_id,$data)
	
	// Start - elect_self($user_id, $pharmacy_surgery_id, $organization_id='', $invitation_type='')
	public function elect_self($user_id, $user_type, $pharmacy_surgery_id, $organization_id='', $elect_as='', $user_org_superintendent, $is_owner = '', $governance_hr=''){

		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		// Get user Details
		$user_details = $this->users->get_user_details($user_id);

		$ins_data2 = array();
		
		if($elect_as == 'SI'){
			
			$ins_data2['pharmacy_surgery_id'] = NULL;
			$ins_data2['organization_id'] = $organization_id;
			
			// Start - Elect Self as superintendent
			$get_organization_detail = $this->organization->get_organization_details($organization_id);
			
			$old_superintendent_id = $get_organization_detail['superintendent_id'];
			
			if($old_superintendent_id != 0)
				$delete_governance = $this->governance->delete_user_governance_read_record($old_superintendent_id,$organization_id,'', 'SI');
			// if($old_superintendent_id != 0)
			
			// Verify if the user requested is a staff OR is the manager in any Pharmacy / Surgery
			$role_in_pharmacy_surgery = $this->pharmacy->get_my_role_in_pharmacy_surgery($user_id, ''); // Pharmacy / Surgery ID NULL in case of SI

			// In case SI hr_read = 1 else 0 || If the user is the manager in the same Pharmacy / Surgery
			if($role_in_pharmacy_surgery['is_manager'] == 1 || $role_in_pharmacy_surgery['is_staff'] == 1){
				
				if($role_in_pharmacy_surgery['is_staff'] == 1)
					$varify_governance_as = 'ST'; // In case: if is staff

				if($role_in_pharmacy_surgery['is_manager'] == 1)
					$varify_governance_as = 'M'; // In case: if is manager
				// if($role_in_pharmacy_surgery['is_manager'] == 1)

				/////////////////////////////////////////////////////////////////////////////////
				// Merger all the pharmacies and surgeries to whome user belongs to as [ M - ST ]

				// 1- Get list of all pharmacies / surgeries to whome the user belongs as Manager
				if( count($role_in_pharmacy_surgery['staff_in'] > 0) )
					$staff_in_arr = $role_in_pharmacy_surgery['staff_in'];
				else
					$staff_in_arr = array();
				// if( count($role_in_pharmacy_surgery['staff_in'] > 0) )

				// 2- Get list of all pharmacies / surgeries to whome the user belongs as Manager
				if( count($role_in_pharmacy_surgery['manager_in'] > 0) )
					$manager_in_arr = $role_in_pharmacy_surgery['manager_in'];
				else
					$manager_in_arr = array();
				// if( count($role_in_pharmacy_surgery['manager_in'] > 0) )

				// merge both arrays [ Pharmacies / Surgeries ]
				$all_pharmacies_surgeries_user_belongs_to = array_merge($staff_in_arr, $manager_in_arr);
				$governance_purchase_status = 0; // default set to 0

				// Verify if governance is purchased for any of the pharmacy / surgery list
				foreach($all_pharmacies_surgeries_user_belongs_to as $pharmacy_surgery){
				
					$governance_purchased_status = $this->governance->get_governance_purchased_pharmacies( $organization_id, 'P', '' ); // Pharmacy / Surgery ID NULL in case of SI

					if(count($governance_purchased_status) > 0){ 

						$governance_purchase_status = 1;

					} // if(count($this->governance_purchased_pharmacies) > 0)

				} // foreach($all_pharmacies_surgeries_user_belongs_to as $pharmacy_surgery)

				// If governance is purchased
				if($governance_purchase_status == 1){
					
					//Veirfy if the Governance is read by any role, first check if it is read as a STAFF if no, then will check as a MANAGAER and will pick that array and will create teh copy of that into new invitation.
					if($role_in_pharmacy_surgery['is_staff'] == 1){
						
						$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, '', 'ST', $user_details['user_type_id']); 			// Pharmacy / Surgery ID NULL in case of SI
						
					}//end if($role_in_pharmacy_surgery['is_staff'] == 1)
					
					if(!$governance_read_list && $role_in_pharmacy_surgery['is_manager']){
						
						$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, '', 'M', $user_details['user_type_id']); 			// Pharmacy / Surgery ID NULL in case of SI
						
					}//end if(!$governance_read_list || $role_in_pharmacy_surgery['is_staff'])
					
					// Verify If governance is read by the user
					if($governance_read_list){
						
						// Make copy of Sop's for the user
						$org_sops = $this->governance->get_organization_sop_list($organization_id);
						
						if(!empty($governance_read_list)){
					
							foreach($governance_read_list as $sop_read){
							
								$sop = $this->governance->get_organization_sop_details($sop_read['sop_id']);
								
								// Mark sop as read as the staff member of the same Pharmacy / Surgery
								$this->governance->mark_organization_sop_read($user_id,'',$sop, $user_org_superintendent, 'SI','1','1');
								
							} // foreach($governance_read_list as $sop)
							
						} // if(!empty($governance_read_list))
							
					} // if($governance_read_list)

				} // if($governance_purchase_status == 1)
				
			} // if($role_in_pharmacy_surgery['is_manager'] == 1 || $role_in_pharmacy_surgery['is_staff'] == 1)

			/*
			if($is_owner==''){
			
				// Make copy of Sop's for the user
				$org_sops = $this->governance->get_organization_sop_list($organization_id, $user_type);
				
				if(!empty($org_sops)){
			
					foreach($org_sops as $sop){
						
						// Mark each ORG SOP as read [ entery into the db for each ORG SOP ]
						$this->governance->mark_organization_sop_read($user_id, '', $sop, $user_org_superintendent, $elect_as);
						
					} // foreach($org_sops as $sop)
					
				} // if(!empty($org_sops))
					
			} // if($is_owner='')
			*/
			
			//Record Update into database
			$upd_data = array(
			
				'superintendent_id' => $this->db->escape_str(trim($user_id)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
				'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->where('id',$organization_id);
			$this->db->dbprefix('organization');
			$upd_into_db = $this->db->update('organization', $upd_data);
			
			if($upd_into_db){
				// Insert Governance read status [ 1 ] for the new superintendent
				$return = true;
			} else
				$return = false;
			// if($upd_into_db)
				
			// End - Elect Self as superintendent
			
		} else if($elect_as == 'M'){
		
			$ins_data2['pharmacy_surgery_id'] = $pharmacy_surgery_id;
			
			// Start - Elect Self as a manager
			if($pharmacy_surgery_id != ''){
				
				// Delete Manager invitation for the Pharmacy / Surgery - If record exist
				$this->db->dbprefix('invitations');
				$this->db->where('invitation_type', "M");
				$this->db->where('pharmacy_id', $pharmacy_surgery_id);
				$success = $this->db->delete('invitations');
				
				// fetch old manager record
				$this->db->dbprefix('org_pharmacy_surgery');
				$this->db->select('manager_id, organization_id');
				$this->db->where('id', $pharmacy_surgery_id);
				$old_manager = $this->db->get('org_pharmacy_surgery')->row_array();
				
				// If manager Exist [ Delete Governance read status ] for old manager
				if($old_manager){
					
					// Delete Manager Governance read status
					$delete_governance = $this->governance->delete_user_governance_read_record($old_manager['manager_id'],$old_manager['organization_id'],$pharmacy_surgery_id, 'M');
					$organization_id = $old_manager['organization_id'];
					$ins_data2['organization_id'] = $organization_id;
					
				} // if(!empty($old_manager))
				
				// Insert Governance read status [ 0 ] of the new manager
				
				// Elect user loggedin [ Owner / Superintendent ] as manager of the Pharmacy / Surgery
				$manager = array('manager_id' => $user_id);
				$this->db->dbprefix('org_pharmacy_surgery');
				$this->db->where('id', $pharmacy_surgery_id);
				$success = $this->db->update('org_pharmacy_surgery', $manager);
				
				if($success){
					
					$this->db->dbprefix('users, usertype');
					$this->db->select('users.*, usertype.user_type as usertype');
					$this->db->from('users');
					$this->db->join('usertype', ' usertype.id = users.user_type ', 'inner');
					$this->db->where('users.id', $user_id);
					
					$return = $this->db->get()->row_array();
				
				} else
					$return = false;
				// if($success)
				
			} else
				$return = false;
			// End - Elect Self as a manager
			
		} else if($elect_as == 'ST'){
			
			$ins_data2['pharmacy_surgery_id'] = $pharmacy_surgery_id;
			$ins_data2['organization_id'] = $organization_id;
			
			// Start - Elect Self as Staff
			// Verify if already elected
			$this->db->dbprefix('pharmacy_surgery_staff');
			$this->db->where('user_id', $user_id);
			$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
			$this->db->where('organization_id', $organization_id);
			$exist = $this->db->get('pharmacy_surgery_staff')->row_array();
			
			if($exist)
				$return = 'exist';
			else {
				
				// Add user as the staff member of the Pharmacy / Surgery
				$insert_data = array(
				
					'pharmacy_surgery_id' => $pharmacy_surgery_id, 
					'user_id' => $user_id, 
					'organization_id' => $organization_id, 
					'created_date' => date('Y-m-d H:i:s'), 
					'created_by_ip' => $this->input->ip_address()
				
				);
					
				$this->db->dbprefix('pharmacy_surgery_staff');
				$this->db->insert('pharmacy_surgery_staff', $insert_data);
				
				// Insert Governance read status [ 0 ]
				
				$return = 'elected';
				
			} // if($exist)
		
			// End - Elect self as staff
		
		} // if($elect_as == 'ST')

		// Varify if the user requested 'elect_self' as a Manager or Staff
		if($elect_as == 'M' || $elect_as == 'ST'){
			
			// Verify if the user requested as a staff is the manager in the same pharmacy_id
			$role_in_pharmacy_surgery = $this->pharmacy->get_my_role_in_pharmacy_surgery($user_id, '');
			
			if($elect_as == 'M'){ // If invitation is for manager : Check governance read as staff
			
				$request_for = 'ST';
				$role_in_pharmacy = $role_in_pharmacy_surgery['is_staff'];

			} else if($elect_as == 'ST'){ // If invitation is for staff : Check governance read as manager
				
				$request_for = 'M';
				$role_in_pharmacy = $role_in_pharmacy_surgery['is_manager'];

			}// $request_for
			
			// In case SI hr_read = 1 else 0 || If the user is the manager in the same Pharmacy / Surgery
			if(!empty($user_org_superintendent) || $role_in_pharmacy == 1){
				
				// Varify If governance is read by the user
				if($role_in_pharmacy == 1){
					
					//Veirfy if the Governance is read by any role, first check if it is read as a STAFF if no, then will check as a MANAGAER and will pick that array and will create teh copy of that into new invitation.
					if($role_in_pharmacy_surgery['is_staff'] == 1){
						
						$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, '', 'ST', $user_details['user_type_id']);
						
					}//end if($role_in_pharmacy_surgery['is_staff'] == 1)
					
					if(!$governance_read_list && $role_in_pharmacy_surgery['is_manager']){
						
						$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, '', 'M', $user_details['user_type_id']);
						
					}//end if(!$governance_read_list || $role_in_pharmacy_surgery['is_staff'])
					
					$governance_purchased_status = $this->governance->get_governance_purchased_pharmacies($organization_id, 'P', $pharmacy_surgery_id);
					
				}//end if($role_in_pharmacy == 1)

				// If superintendent then will check if the organization has purchased the governance for any pharmacy AND SI governance is read.
				if($user_org_superintendent){
					
					$governance_read_list = $this->governance->governance_read_by_user_list($user_id, $organization_id, '', 'SI', $user_details['user_type_id']);
					$governance_purchased_status = $this->governance->get_governance_purchased_pharmacies($organization_id, 'P');

				} // if($user_org_superintendent)
				
				if($governance_read_list && count($governance_purchased_status) > 0){
					
					// Make copy of Sop's for the user
					$org_sops = $this->governance->get_organization_sop_list($organization_id, $user_details['user_type_id']);
					
					if(!empty($governance_read_list)){
				
						foreach($governance_read_list as $sop_read){
								
								$sop = $this->governance->get_organization_sop_details($sop_read['sop_id']);
							
							// Mark sop as read as the staff member of the same Pharmacy / Surgery
							$this->governance->mark_organization_sop_read($user_id,$pharmacy_surgery_id, $sop, $user_org_superintendent, $elect_as,'1','1');
							
						} // foreach($governance_read_list as $sop)
						
					} // if(!empty($governance_read_list))
						
				} // if($governance_read_list)
				
			} // if(!empty($user_org_superintendent) || $role_in_pharmacy_surgery['is_manager'] == 1)
			
		} // if($elect_as == 'M' || $elect_as == 'ST')
			
		/*--------------------------------------------------------------------------------------*/
		// INSERTING the GOVERNANCE READ Record into the database with Status as [ read - unread ]
		/*--------------------------------------------------------------------------------------*/
		
		$governance_data_arr = $this->governance->get_org_governance_details('',$organization_id);
		$governance_id = $governance_data_arr['id'];
		
		$ins_data = array(
		
			'user_id' => $this->db->escape_str(trim($user_id)),
			'governance_id' => $this->db->escape_str(trim($governance_id)),
			'user_role' => $this->db->escape_str(trim($elect_as)),
			'hr_read' => $this->db->escape_str(1), // $hr_read
			'hr_contract' => $this->db->escape_str($governance_hr),
			'created_date' => $this->db->escape_str(trim($modified_date))
		);
		
		$ins_data = array_merge($ins_data, $ins_data2);
		
		//Inserting User data into the database. 
		$this->db->dbprefix('governance_read_status');
		$ins_into_db = $this->db->insert('governance_read_status', $ins_data);
	
		return $return;
		
	} // End - elect_self($user_id, $pharmacy_surgery_id, $organization_id='', $invitation_type='')
	
	// Start - get_all_country()
	public function get_all_country(){
		
		$this->db->dbprefix('country');
		$this->db->where('status', 1);
		return $this->db->get('country')->result_array();
		
	} // End - get_all_country()
	
	// Start Funcion update_manager_staff
	public function update_manager_staff($data){
		
		extract($data);
		
		// Update Name last Name Mobile Number  
		$ins_data = array(
		
		 	'first_name' =>$this->db->escape_str(trim($first_name)),
		 	'last_name'  =>$this->db->escape_str(trim($last_name)),
		  	'mobile_no'  =>$this->db->escape_str(trim($mobile_no)),

		);
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
	
			$this->db->dbprefix('users');
			$this->db->where('id', $manager_staff_id);
			$query = $this->db->update('users', $ins_data);	
			
			if($query)
				return true;
			else
				return false;
			// if($query)
			  	
	} // End update_manager_staff
	
	//Start delete_staff_member($staff_id)
	public function delete_staff_member($staff_id){
		
		// Fetch Staff member row [ user_id, organization_id, pharmacy_surgery_id ]
		$this->db->dbprefix('pharmacy_surgery_staff');
		$this->db->select('organization_id, pharmacy_surgery_id, user_id');
		$this->db->where('id', $staff_id);
		$member = $this->db->get('pharmacy_surgery_staff')->row_array();
		
		$governance_deleted = $this->governance->delete_user_governance_read_record($member['user_id'], $member['organization_id'], $member['pharmacy_surgery_id'], 'ST');
		
		if($governance_deleted){
			
			$this->db->dbprefix('pharmacy_surgery_staff');
			$this->db->where('id', $staff_id);
			
			return $this->db->delete('pharmacy_surgery_staff');	
			
		} else 
			return false;
	
	}// end delete_staff_member($staff_id)
	
	// Start get_all_ajax_list_emails
	public function get_all_ajax_list_emails($emails, $user_type =''){
		
		if($user_type=='DO'){
			
			$usertype = '1';
		
		} else if($user_type=='PH') {
		
			$usertype = '2';
		
		} else if($user_type=='NU') {
		
			$usertype = '3';
		
		} else if($user_type=='PA') {
		
			$usertype = '4';
		
		} else if($user_type=='TE') {
		
			$usertype = '5';
		
		} else if($user_type=='PR') {
			
			$usertype = '6';
		
		} else if($user_type=='NH') {
			
			$usertype = '7';
		}
		
		if(!empty($emails) && $usertype!=""){
					
			$this->db->dbprefix("users");
			$this->db->select('email_address');
			$this->db->where("user_type", $usertype);
			$this->db->where("admin_verify_status", 1);		
			$this->db->where("email_verify_status", 1);
			$this->db->like('email_address',$emails);
			
			return $query =$this->db->get('users')->result_array();
			
		} else if(!empty($emails)) {
			
			$this->db->dbprefix("users");
			$this->db->select('email_address');
			$this->db->where("admin_verify_status", 1);	
			$this->db->where("email_verify_status", 1);	
			$this->db->like('email_address',$emails);
			
			return $query =$this->db->get('users')->result_array();
			
		} // if(!empty($emails) && $usertype!="")
		
		//echo $this->db->last_query(); exit;
	} // End get_all_ajax_list_emails
	
	// Global Settings Time  add_update_organization_settings_time()
	public function add_update_organization_settings_time($post){
		
		extract($post);
	
		$ins_data = array(
				
					'sat_open_timings' => $this->db->escape_str(trim($sat_open_timings)),
					'sat_close_timings' => $this->db->escape_str(trim($sat_close_timings)),
					'sun_open_timings' => $this->db->escape_str(trim($sun_open_timings)),
					'sun_close_timings' => $this->db->escape_str(trim($sun_close_timings)),
					'mon_open_timings' => $this->db->escape_str(trim($mon_open_timings)),
					'mon_close_timings' => $this->db->escape_str(trim($mon_close_timings)),
					'tue_open_timings' => $this->db->escape_str(trim($tue_open_timings)),
					'tue_close_timings' => $this->db->escape_str(trim($tue_close_timings)),
					'wed_open_timings' => $this->db->escape_str(trim($wed_open_timings)),
					'wed_close_timings' => $this->db->escape_str(trim($wed_close_timings)),
					'thu_open_timings' => $this->db->escape_str(trim($thu_open_timings)),
					'thu_close_timings' => $this->db->escape_str(trim($thu_close_timings)),
					'fri_open_timings' => $this->db->escape_str(trim($fri_open_timings)),
					'fri_close_timings' => $this->db->escape_str(trim($fri_close_timings)),
					'is_sat_closed' => $this->db->escape_str(trim($is_sat_closed)),
					'is_sun_closed' => $this->db->escape_str(trim($is_sun_closed)),
					'is_mon_closed' => $this->db->escape_str(trim($is_mon_closed)),
					'is_tue_closed' => $this->db->escape_str(trim($is_tue_closed)),
					'is_wed_closed' => $this->db->escape_str(trim($is_wed_closed)),
					'is_thu_closed' => $this->db->escape_str(trim($is_thu_closed)),
					'is_fri_closed' => $this->db->escape_str(trim($is_fri_closed)),
					'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_global_id))
					
				);
		
		if($pharmacy_surgery_timings_id=="")
		{		
			$ins_data['created_date'] = date('Y-m-d G:i:s');
			$ins_data['created_by_ip'] = $this->input->ip_address();
	
			$this->db->dbprefix('pharmacy_surgery_timings');
			
			return $upd_into_db = $this->db->insert('pharmacy_surgery_timings', $ins_data);
			
		} else {
			
			$ins_data['modified_date'] = date('Y-m-d G:i:s');
			$ins_data['modified_by_ip'] = $this->input->ip_address();
			
			$this->db->dbprefix('pharmacy_surgery_timings');
			$this->db->where('id', $pharmacy_surgery_timings_id);
			
			return $upd_into_db = $this->db->update('pharmacy_surgery_timings', $ins_data);
			
		} // if($pharmacy_surgery_timings_id=="")
		
	} // End Global Setting add_update_organization_settings_time();
  
	public function is_user_org_owner_si($user_id, $organization_id){
	
		$this->db->dbprefix('organization');
		$this->db->where('id', $organization_id);
		$this->db->where('owner_id', $user_id);
		
		$row = $this->db->get('organization')->row_array();
		if(!empty($row))
			return $row;
		else
			return false;
		// if(!empty($row))
	
	} // public function is_user_org_owner_si($user_id, $organization_id)
  
	// Start Function search_doctor_pharmacist()
	public function search_doctor_pharmacist($data, $organization_id){
		
		extract($data);
		
		$search = $this->db->escape_str(trim($search));
	
		//$where = "(first_name LIKE '%$search%' || last_name LIKE '%$search%')";
		if($usertype=='2'){
			
			// Superintendent check
			$this->db->dbprefix('organization');
			$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
			$this->db->from('organization');
			$this->db->join('users', 'users.id = organization.superintendent_id');
			
			$this->db->where('users.user_type', $usertype);
			$this->db->where('users.admin_verify_status','1');
			$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
			$this->db->where('organization.id', $organization_id);
			
			$as_superindentend = $this->db->get()->result_array();
			
		} // if($usertype=='2')
		
		// Manager check
		$this->db->dbprefix('org_pharmacy_surgery');		
		$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
		$this->db->from('org_pharmacy_surgery');
		$this->db->join('users', 'users.id = org_pharmacy_surgery.manager_id');
		
		$this->db->where('users.user_type',$usertype);
		$this->db->where('users.admin_verify_status','1');
		$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
		$this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
		
		$as_manager = $this->db->get()->result_array();
		
		// Staff check
		$this->db->dbprefix('pharmacy_surgery_staff');
		
		$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
		$this->db->from('pharmacy_surgery_staff');
		
		$this->db->join('users', 'users.id = pharmacy_surgery_staff.user_id');
		
		$this->db->where('users.user_type',$usertype);
		$this->db->where('users.admin_verify_status','1');
		$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
		$this->db->where('pharmacy_surgery_staff.organization_id', $organization_id);
		
		$as_staff = $this->db->get()->result_array();
		
		if($usertype != 2)
			$as_superindentend = array();
		// if($usertype != 2)
			
		$merge_array = array_merge($as_superindentend, $as_manager, $as_staff);
		
		foreach($merge_array as $each){
			$final_arr[] .= $each['id'];
		} // foreach($merge_array as $each)
		
		if(!empty($final_arr))
			$get_all_result = array_unique($final_arr);
	    // if(!empty($final_arr)) 
		
		$total = count($get_all_result);
		if(!empty($get_all_result)){
		
			for($i=0; $i<=$total;$i++){
	
				$this->db->dbprefix('users');
				$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
				$this->db->from('users');
				$this->db->where('id',$get_all_result[$i]);
				
				$as_total_member[] = $this->db->get()->row_array();
				//echo $this->db->last_query(); exit;
				
			} // for($i=0; $i<=$total;$i++)
			    
			return $as_total_member;
			
		}  else 
		   return false;
		// if(!empty($get_all_result))
		
	} // End search_doctor_pharmacist();
	
	// Function Start save_doctor_pharmacist();
	public function save_doctor_pharmacist($data, $organization_id){
		
	    extract($data);
		
		// Post Value
		$doctor_email = $this->db->escape_str(trim($doctor_email));
		$pharmacist_email = $this->db->escape_str(trim($pharmacist_email));
		
		$type_pharmacist = $this->db->escape_str(trim($type_pharmacist));
		$type_doctor = $this->db->escape_str(trim($type_doctor));
		
		// Request Type
		if($doctor_email != '' || $pharmacist_email != ''){
			
			// Case 1: Requested for both
			
			// Varification
			if($pharmacist_email != ''){
			
				// If superintendent
				/* ----------------------------------------------------- */
				$this->db->dbprefix('organization, users');
				$this->db->from('organization');
				
				$this->db->join('users', 'users.id = organization.superintendent_id');
				
				$this->db->where('organization.id', $organization_id);
				$this->db->where('users.email_address', $pharmacist_email);
				$this->db->where('users.user_type', $type_pharmacist);
				
				$is_superintendent = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
				
				// If Manager
				$this->db->dbprefix('org_pharmacy_surgery, users');
				$this->db->from('org_pharmacy_surgery');
				
				$this->db->join('users', 'users.id = org_pharmacy_surgery.manager_id');
				
				$this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
				$this->db->where('users.email_address', $pharmacist_email);
				$this->db->where('users.user_type', $type_pharmacist);
				
				$pharmacist_is_manager = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
				
				// If Staff
				$this->db->dbprefix('pharmacy_surgery_staff, users');
				$this->db->from('pharmacy_surgery_staff');
				
				$this->db->join('users', 'users.id = pharmacy_surgery_staff.user_id');
				
				$this->db->where('pharmacy_surgery_staff.organization_id', $organization_id);
				$this->db->where('users.email_address', $pharmacist_email);
				$this->db->where('users.user_type', $type_pharmacist);
				
				$pharmacist_is_staff = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
				
			} // if($pharmacist_email != '')
			
			if($doctor_email != ''){
			
				// If Manager
				$this->db->dbprefix('org_pharmacy_surgery, users');
				$this->db->from('org_pharmacy_surgery');
				
				$this->db->join('users', 'users.id = org_pharmacy_surgery.manager_id');
				
				$this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
				$this->db->where('users.email_address', $doctor_email);
				$this->db->where('users.user_type', $type_doctor);
				
				$doctor_is_manager = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
				
				// If Staff
				$this->db->dbprefix('pharmacy_surgery_staff, users');
				$this->db->from('pharmacy_surgery_staff');
				
				$this->db->join('users', 'users.id = pharmacy_surgery_staff.user_id');
				
				$this->db->where('pharmacy_surgery_staff.organization_id', $organization_id);
				$this->db->where('users.email_address', $doctor_email);
				$this->db->where('users.user_type', $type_doctor);
				
				$doctor_is_staff = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
				
			} // if($doctor_email != '')
			
		} // if($doctor_email != '' || $pharmacist_email != '')
		
		// Case 1 : Request for both [ Doctor - Pharmacist ]
		if($doctor_email != '' && $pharmacist_email != ''){
			
			// Check if both are varified
			if($pharmacist_is_manager || $pharmacist_is_staff || $is_superintendent){
				
				// Get Pharmacist ID by email_address
				$this->db->dbprefix('users');
				$this->db->select('id');
				$this->db->where('email_address', $pharmacist_email);
				$pharmacist = $this->db->get('users')->row_array();
				
			} else
				$error_message = 'Pharmacist does not exist in this Organization.';
			// if($pharmacist_is_manager || $pharmacist_is_staff || $is_superintendent)
			
			if($doctor_is_manager || $doctor_is_staff){
				
				// Get Doctor ID by email_address
				$this->db->dbprefix('users');
				$this->db->select('id');
				$this->db->where('email_address', $doctor_email);
				$doctor = $this->db->get('users')->row_array();

			} else {
				$error_message .= '<br />Doctor does not exist in this Organization.';
			} // if($doctor_is_manager || $doctor_is_staff)
				
			if($pharmacist && $doctor){
				
				// Both are verified [ Exist in the organization ]
				$set_default = array('default_doctor' => $doctor['id'], 'default_pharmacist' => $pharmacist['id']);
				
				// Update  default_doctor 1 and  default_pharmacist 1
				$this->db->dbprefix('organization');
				$this->db->where('id', $organization_id);
				$default_set = $this->db->update('organization', $set_default);
				$success_message = 'Default Doctor and default Pharmacist successfully added.';
				
			} // if($pharmacist && $doctor)
			
		} else if($doctor_email != '' || $pharmacist_email != ''){ // Case 1 : Request for [ Doctor OR Pharmacist ]
			
			if($doctor_email != ''){
				
				// Request for doctor
				// Verify if the doctor exist in this organization by $organization_id
				if($doctor_is_manager || $doctor_is_staff){
					
					// Doctor exist in this organization - change default doctor if default pharmacist is already exist
					$this->db->dbprefix('organization');
					$this->db->select('default_pharmacist');
					$this->db->where('id', $organization_id);
					$is_set = $this->db->get('organization')->row_array();
					
					if($is_set['default_pharmacist']){
						
						// Get Doctor ID by email_address
						$this->db->dbprefix('users');
						$this->db->select('id');
						$this->db->where('email_address', $doctor_email);
						$doctor = $this->db->get('users')->row_array();
						
						$set_doctor = array('default_doctor' => $doctor['id']);
						
						// Update  default_doctor 1 and  default_pharmacist 1
						$this->db->dbprefix('organization');
						$this->db->where('id', $organization_id);
						$default_set = $this->db->update('organization', $set_doctor);
						$success_message = 'Default Doctor successfully added.';
						
					} else
						$error_message = 'No default pharmacist exist for this organization';
					// if($is_set['default_pharmacist'])
					
				} else
					$error_message = 'Doctor does not exist in this organization';
				// if($doctor_is_manager || $doctor_is_staff)
				
			} else if($pharmacist_email != ''){
				
				// Request for Pharmacist
				// Verify if the Pharmacist exist in this organization by $organization_id
				if($pharmacist_is_manager || $pharmacist_is_staff || $is_superintendent){
					
					// Pharmacist exist in this organization - change default pharmacist if default doctor is already exist for the same organization
					$this->db->dbprefix('organization');
					$this->db->select('default_doctor');
					$this->db->where('id', $organization_id);
					$is_set = $this->db->get('organization')->row_array();
					
					if($is_set['default_doctor']){
						
						// Get Doctor ID by email_address
						$this->db->dbprefix('users');
						$this->db->select('id');
						$this->db->where('email_address', $pharmacist_email);
						$pharmacist = $this->db->get('users')->row_array();
						
						$set_pharmacist = array('default_pharmacist' => $pharmacist['id']);
						
						// Update  default_doctor 1 and  default_pharmacist 1
						$this->db->dbprefix('organization');
						$this->db->where('id', $organization_id);
						$default_set = $this->db->update('organization', $set_pharmacist);
						$success_message = 'Default Pharmacist successfully added.';
						
					} else
						$error_message = 'No default Doctor exist for this organization';
					// if($is_set['default_pharmacist'])
					
				} else
					$error_message = 'Pharmacist does not exist in this organization';
				// if($pharmacist_is_manager || $pharmacist_is_staff)
				
			} // if($doctor_email != '')
			
		} // if($doctor_email != '' && $pharmacist_email != '')
		
		// Return response
		if($default_set) // If succesfully set as default
			return array('error' => 0, 'response_message' => $success_message);
		else // return error : exceptions
			return array('error' => 1, 'response_message' => $error_message);
	  
	} // Function End save_doctor_pharmacist();
	
	//Function Start get_default_don_pharmacist
	public function get_default_doctor_pharmacist($organization_id){
	
		$this->db->dbprefix('organization');
		$this->db->select('default_doctor,default_pharmacist');
		$this->db->from('organization');
		$this->db->where('organization.id',$organization_id);
		$row = $this->db->get()->row_array();
		
		$doctor_id = $row['default_doctor'];
		$pharmacist_id = $row['default_pharmacist'];
		
		$this->db->dbprefix('users');
		$this->db->select('user_type,first_name,last_name');
		$this->db->from('users');
		$this->db->where("(id = '$doctor_id' OR id = '$pharmacist_id')");
		$this->db->order_by('user_type', 'ASC');
		
		return $result = $this->db->get()->result_array();
	
	} // public function is_user_org_owner_si($user_id, $organization_id)
  
	// Function Start get_default_doctor_org();
	public function get_default_doctor_org($user_login_id, $organization_id){
	
		$this->db->dbprefix('organization'); 
		$this->db->where("(default_doctor = '$user_login_id' OR default_pharmacist = '$user_login_id')");
		$this->db->where('id',$organization_id);
		
		return $this->db->get('organization')->row_array(); 
		
	} // End get_default_doctor_org()
	
	// Function Start add add_update_cqc
	public function add_update_cqc($data, $organization_id){
		
		extract($data);
		
		$upd_data = array(
			
				'cqc_pharmacy_name' => $this->db->escape_str(trim($cqc_pharmacy_name)),
				'cqc_body' => $this->db->escape_str(trim($cqc_body)),
				'cqc_manager' => $this->db->escape_str(trim($cqc_manager))
			);
			
		//Uploading Authorized_stamp Image
		if($_FILES['cqc_authorized_stamp']['name'] != ''){
			
			$authorized_stamp_folder_path = './assets/org_stamp/';
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['cqc_authorized_stamp']['name'],'.')),'.'); 			
			$authorized_stamp_file_name = 	'authorized_stamp_'.rand().'.jpg';
			

			$config['upload_path'] = $authorized_stamp_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '2000';
			$config['overwrite'] = true;
			$config['file_name'] = $authorized_stamp_file_name;
		
			$this->load->library('upload', $config);
            
			if(!$this->upload->do_upload('cqc_authorized_stamp')){
				$error_file_arr = array('error_upload' => $this->upload->display_errors());
			    return false;
				
			}else{
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				$upd_data['cqc_authorized_stamp'] = $this->db->escape_str(trim($authorized_stamp_file_name));
				
				//Creating Thumbmail 300 * 200
                //Uploading is successful now resizing the uploaded image
                $config_stamp['image_library'] = 'gd2';
                $config_stamp['source_image'] = $authorized_stamp_folder_path.$authorized_stamp_file_name;
                $config_stamp['new_image'] = $authorized_stamp_folder_path.'thumb-'.$authorized_stamp_file_name;
                $config_stamp['create_thumb'] = TRUE;
                $config_stamp['thumb_marker'] = '';
               
                $config_stamp['maintain_ratio'] = TRUE;
                $config_stamp['width'] = 300;
                $config_stamp['height'] = 200;
               
                $this->load->library('image_lib');
                $this->image_lib->initialize($config_stamp);
                $this->image_lib->resize();
                $this->image_lib->clear();
			 
				// Unlink image from Folder 	
				$this->db->dbprefix('organization');
				$this->db->select('cqc_authorized_stamp');
				$this->db->where('id', $organization_id);
				$row= $this->db->get('organization')->row_array();
				
				if($row['cqc_authorized_stamp']!= '' && file_exists($authorized_stamp_folder_path."".$row['cqc_authorized_stamp'])){
					unlink($authorized_stamp_folder_path."".$row['cqc_authorized_stamp']);
					unlink($authorized_stamp_folder_path."thumb-".$row['cqc_authorized_stamp']);
				}
			}//end if(!$this->upload->do_upload('cqc_authorized_stamp'))
			
		}//end if($_FILES['cqc_authorized_stamp']['name'] != '')

		//updating CQC data into the database. 
		$this->db->dbprefix('organization');
		$this->db->where('id',$organization_id);
		return $ins_into_db = $this->db->update('organization', $upd_data);
		//echo $this->db->last_query(); exit;
		
	}// End add_update_cqc
	
	// Function Start get_cqc_details();
	public function get_cqc_details($organization_id){
	
		$this->db->dbprefix('organization');
		$this->db->select('cqc_pharmacy_name,cqc_body,cqc_manager,cqc_authorized_stamp');
		$this->db->from('organization');
		$this->db->where('organization.id',$organization_id);
		return $row = $this->db->get()->row_array();
		
	} // End get_cqc_details();
	
	
		// Start Function search_doctor_pharmacist_prescriber()
	public function search_doctor_pharmacist_prescriber($data, $organization_id){
		
		extract($data);
		
		$search = $this->db->escape_str(trim($search));
	
		//$where = "(first_name LIKE '%$search%' || last_name LIKE '%$search%')";
		// Superintendent check
		$this->db->dbprefix('organization');
		$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
		$this->db->from('organization');
		$this->db->join('users', 'users.id = organization.superintendent_id');
		
		$this->db->where("(users.user_type=1 OR users.user_type=2)");
		$this->db->where('users.is_prescriber','1');
		$this->db->where('users.admin_verify_status','1');
		$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
		$this->db->where('organization.id', $organization_id);
		
		$as_superindentend = $this->db->get()->result_array();
			
		// Manager check
		$this->db->dbprefix('org_pharmacy_surgery');		
		$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
		$this->db->from('org_pharmacy_surgery');
		$this->db->join('users', 'users.id = org_pharmacy_surgery.manager_id');
		
		$this->db->where("(users.user_type=1 OR users.user_type=2)");
		$this->db->where('users.is_prescriber','1');
		$this->db->where('users.admin_verify_status','1');
		$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
		$this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
		
		$as_manager = $this->db->get()->result_array();
		
		// Staff check
		$this->db->dbprefix('pharmacy_surgery_staff');
		
		$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
		$this->db->from('pharmacy_surgery_staff');
		
		$this->db->join('users', 'users.id = pharmacy_surgery_staff.user_id');
		
		$this->db->where("(users.user_type=1 OR users.user_type=2)");
		$this->db->where('users.is_prescriber','1');
		$this->db->where('users.admin_verify_status','1');
		$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
		$this->db->where('pharmacy_surgery_staff.organization_id', $organization_id);
		
		$as_staff = $this->db->get()->result_array();

			
		$merge_array = array_merge($as_superindentend, $as_manager, $as_staff);
		
		foreach($merge_array as $each){
			$final_arr[] .= $each['id'];
		} // foreach($merge_array as $each)
		
		if(!empty($final_arr))
			$get_all_result = array_unique($final_arr);
	    // if(!empty($final_arr)) 
		
		$total = count($get_all_result);
		if(!empty($get_all_result)){
		
			for($i=0; $i<=$total;$i++){
	
				$this->db->dbprefix('users');
				$this->db->select('users.id, users.first_name, users.last_name,,users.email_address,users.user_type');
				$this->db->from('users');
				$this->db->where('id',$get_all_result[$i]);
				
				$as_total_member[] = $this->db->get()->row_array();
				//echo $this->db->last_query(); exit;
				
			} // for($i=0; $i<=$total;$i++)
			    
			return $as_total_member;
			
		}  else 
		   return false;
		// if(!empty($get_all_result))
		
	} // End search_doctor_pharmacist_prescriber();
	
	// Function Start save_doctor_pharmacist_prescriber();
	public function save_doctor_pharmacist_prescriber($data, $organization_id){
		
	    extract($data);
	
		// Post Value
		$prescriber_email = $this->db->escape_str(trim($prescriber_email));
		$prescriber_fees = $this->db->escape_str(trim($prescriber_fees));
	
		// Request email
		if($prescriber_email != ''){

				// If superintendent
				/* ----------------------------------------------------- */
				$this->db->dbprefix('organization, users');
				$this->db->from('organization');
				
				$this->db->join('users', 'users.id = organization.superintendent_id');
				
				$this->db->where('organization.id', $organization_id);
				$this->db->where('users.email_address', $prescriber_email);
				$this->db->where("(users.user_type=1 OR users.user_type=2)");
				$this->db->where('users.is_prescriber','1');
				
				$prescriber_is_superintendent = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
				
				// If Manager
				$this->db->dbprefix('org_pharmacy_surgery, users');
				$this->db->from('org_pharmacy_surgery');
				
				$this->db->join('users', 'users.id = org_pharmacy_surgery.manager_id');
				
				$this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
				$this->db->where('users.email_address', $prescriber_email);
				$this->db->where("(users.user_type=1 OR users.user_type=2)");
				$this->db->where('users.is_prescriber','1');
				
				$prescriber_is_manager = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
				
				// If Staff
				$this->db->dbprefix('pharmacy_surgery_staff, users');
				$this->db->from('pharmacy_surgery_staff');
				
				$this->db->join('users', 'users.id = pharmacy_surgery_staff.user_id');
				
				$this->db->where('pharmacy_surgery_staff.organization_id', $organization_id);
				$this->db->where('users.email_address', $prescriber_email);
				$this->db->where("(users.user_type=1 OR users.user_type=2)");
				$this->db->where('users.is_prescriber','1');
				
				$prescriber_is_staff = $this->db->get()->row_array();
				/* ----------------------------------------------------- */
			
		} // if($prescriber_email != '')
		
		//  Request for both [ Doctor - Pharmacist ]
		if($prescriber_email != ''){
			
			// Check if both are varified
			if($prescriber_is_manager || $prescriber_is_staff || $prescriber_is_superintendent){
				
				// Get Prescriber ID by email_address
				$this->db->dbprefix('users');
				$this->db->select('id');
				$this->db->where('email_address', $prescriber_email);
				$prescriber = $this->db->get('users')->row_array();
				
			} else
				$error_message = 'Prescriber does not exist in this Organization.';
			// if($prescriber_is_manager || $prescriber_is_staff || $prescriber_is_superintendent)
				
			if($prescriber){
				
				// Both are verified [ Exist in the organization ]
				if($prescriber['id']!="" && $prescriber_fees==""){
					$set_default = array('default_prescriber' => $prescriber['id']);
				} else {
					$set_default = array('default_prescriber' => $prescriber['id'],'prescriber_fees' => $prescriber_fees);
				}
			
				// Update  default_prescriber 1
				$this->db->dbprefix('organization');
				$this->db->where('id', $organization_id);
				$default_set = $this->db->update('organization', $set_default);
				//echo $this->db->last_query(); exit;
				$success_message = 'Default Prescriber successfully added.';
				
			} // if($prescriber)
			
		} else if($prescriber_fees!="" && $prescriber_email ==""){
			
			    $set_default = array('prescriber_fees' => $prescriber_fees);
				
			    $this->db->dbprefix('organization');
				$this->db->select('organization.default_prescriber');
				$this->db->from('organization');
				$this->db->where('organization.id', $organization_id);
				$this->db->where('default_prescriber IS NOT NULL');
				$row = $this->db->get()->row_array();
				
				// Update  default_prescriber 1
				if($row['default_prescriber']!=""){
					
				$this->db->dbprefix('organization');
				$this->db->where('id', $organization_id);
				$default_set = $this->db->update('organization', $set_default);
				//echo $this->db->last_query(); exit;
				 $success_message = 'Default Prescriber fees successfully added.';
				
				} else {
				  $error_message = 'Prescriber does not exist in this Organization.';
		
				}
		}

		if($prescriber_email!=""){
		
		// Get user details by email
			$user = $this->users->get_user_by_email($prescriber_email);
		}

		// Get prescriber fees [ by organization_id ]
				
		if($prescriber_fees == "" && $default_set){
			
			$this->db->dbprefix('organization');
		    $this->db->where('id', $organization_id);
	        $prescriber_fees_already_set = $this->db->get('organization')->row_array();
			$prescriber_fees = $prescriber_fees_already_set['prescriber_fees'];
			
		} else if ($prescriber_email=="" && $default_set){
			
			$this->db->dbprefix('organization');
		    $this->db->where('id', $organization_id);
	        $prescriber_fees_already_set = $this->db->get('organization')->row_array();
			$default_prescriber_id = $prescriber_fees_already_set['default_prescriber'];
			
			$this->db->dbprefix('users');
		    $this->db->where('id', $default_prescriber_id);
	        $prescriber_email = $this->db->get('users')->row_array();
			
			$user = $this->users->get_user_by_email($prescriber_email['email_address']); 
			
		}
	
		// Return response
		if($default_set) // If succesfully set as default
			return array('error' => 0, 'response_message' => $success_message, 'prescriber' => $user, 'prescriber_fees' => $prescriber_fees);
		else // return error : exceptions
			return array('error' => 1, 'response_message' => $error_message, 'prescriber' => '', 'prescriber_fees' => '');
	  	// if($default_set)

	} // Function End save_doctor_pharmacist_prescriber();
	
		//Function Start get_default_prescriber
	public function get_default_prescriber($organization_id){
	
		$this->db->dbprefix('organization');
		$this->db->select('default_prescriber');
		$this->db->from('organization');
		$this->db->where('organization.id',$organization_id);
		$row = $this->db->get()->row_array();
		
		$default_prescriber_id = $row['default_prescriber'];
		
		$this->db->dbprefix('users');
		$this->db->select('user_type,first_name,last_name');
		$this->db->from('users');
		$this->db->where('id',$default_prescriber_id);
		$this->db->order_by('user_type', 'ASC');
		
		return $result = $this->db->get()->row_array();
	
	} // public function get_default_prescriber()
	
	public function get_default_prescriber_fees($organization_id){
	
		$this->db->dbprefix('organization');
		$this->db->select('prescriber_fees');
		$this->db->from('organization');
		$this->db->where('organization.id',$organization_id);
		return $row = $this->db->get()->row_array();
	}
	
	public function update_pharmacy_surgery_online_doctor($organization_id,$data){
		
		extract($data);
		
		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		for($i=0;$i<count($pharmacy_chk);$i++){
			
			//Record Update into database
			$upd_data = array(
			
				'online_doctor_status' => $this->db->escape_str(trim($online_doctor)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
				'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->dbprefix('pharmacy_surgery_global_settings');
			$this->db->where('organization_id',$organization_id);
			$this->db->where('pharmacy_surgery_id',$pharmacy_chk[$i]);

			$upd_into_db = $this->db->update('pharmacy_surgery_global_settings', $upd_data);
			
			//echo $this->db->last_query(); 		exit;
			
		}//end for($i=0;$i<count();$i++)
		
		if($upd_into_db)
			return true;
		else
			return false;

	}//end update_pharmacy_surgery_online_doctor($data)

	public function update_pharmacy_surgery_embed_code($organization_id,$data){
		
		extract($data);
		
		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		for($i=0;$i<count($pharmacy_chk);$i++){
			
			//Record Update into database
			$upd_data = array(
			
				'embed_status' => $this->db->escape_str(trim($embed_status)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
				'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->dbprefix('pharmacy_surgery_global_settings');
			$this->db->where('organization_id',$organization_id);
			$this->db->where('pharmacy_surgery_id',$pharmacy_chk[$i]);

			$upd_into_db = $this->db->update('pharmacy_surgery_global_settings', $upd_data);
			
			//echo $this->db->last_query(); 		exit;
			
		}//end for($i=0;$i<count();$i++)
		
		if($upd_into_db)
			return true;
		else
			return false;

	}//end update_pharmacy_surgery_embed_code($data)
	
	//Function user_already_a_default_prescriber(): This function ensures if the user is already a default prescriber to any organization. If YES, returns the Organization ID.
	public function get_organization_default_prescriber($organization_id){
		
		$this->db->dbprefix('organization');
		$this->db->select('default_prescriber');
		$this->db->from('organization');
		$this->db->where('id',$organization_id);
		$get = $this->db->get();
		
		$row = $get->row_array();
		
		return $row['default_prescriber'];
		
	}//end user_already_a_default_prescriber($user_id)

	// Function already_staff_in_another_organization($user_id, $self_organization_id): Will return true if user belongs to organization other than the current organziation
	public function already_staff_in_another_organization($user_id, $self_organization_id){

		// Check if the user is a manager
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->where('organization_id !=', $self_organization_id);
		$this->db->where('manager_id', $user_id);
		$is_manager_arr = $this->db->get('org_pharmacy_surgery')->result_array();
		
		// Check if the user is a staff member
		$this->db->dbprefix('pharmacy_surgery_staff');
		$this->db->where('organization_id !=', $self_organization_id);
		$this->db->where('user_id', $user_id);
		$is_staff_arr = $this->db->get('pharmacy_surgery_staff')->result_array();
		
		if($is_staff_arr || $is_manager_arr)
			return true;
		else
			return false;
		
	} // end if already_staff_in_another_organization($user_id, $self_organization_id)
	
	// Start - public function remove_default_prescriber($organization_id) : Function to remove the current set default prescriber of the organization
    public function remove_default_prescriber($organization_id){

        $upd_data = array('default_prescriber' => NULL, 'prescriber_fees' => 0.00);
        $this->db->dbprefix('organization');
        $this->db->where('id', $organization_id);

        return $this->db->update('organization', $upd_data);

    } // End - public function remove_default_prescriber($organization_id)
	
	public function edit_organization($organization_id, $data){
		
		extract($data);

		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();

		//Record Update into database
		$upd_data = array(
		
			'company_name' => $this->db->escape_str(trim($company_name)),
			'address' => $this->db->escape_str(trim($org_address)),
			'postcode' => $this->db->escape_str(trim($org_postcode)),
			'contact_no' => $this->db->escape_str(trim($org_contact)),
			'country_id' => $this->db->escape_str(trim($org_country)),
			'modified_date' => $this->db->escape_str(trim($modified_date)),
			'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
		);
		
		$folder_path = './assets/images/org_logo/';

		//Uploading category_image Image
		if($_FILES['org_logo']['name'] != ''){
			
			$allowed_exntension = array('jpg', 'jpeg', 'png', 'gif');
			$extension = pathinfo($_FILES['org_logo']['name'], PATHINFO_EXTENSION);
			
			if(in_array($extension,$allowed_exntension)){
				
				$file_name = 	$organization_id.'-logo-'.rand().'.'.$extension;
				$destination_path = $folder_path.$file_name;
				
				// Unlink image from Folder 	
				if($old_org_logo != '' && file_exists($folder_path.$old_org_logo)){
					
					@unlink($folder_path.$old_org_logo);
					
				}//end if($category_id!="")
				
				@copy($_FILES['org_logo']['tmp_name'],$destination_path);
				$upd_data['org_logo'] =  $this->db->escape_str($file_name);

			}//end if(in_array($extension,$allowed_exntension))
			
		}else{
			
			if($remove_logo){
				
				$upd_data['org_logo'] =  '';

				if($old_org_logo != '' && file_exists($folder_path.$old_org_logo))
					@unlink($folder_path.$old_org_logo);
				//end if($category_id!="")
				
			}//end if($remove_logo)
			
		}//end if($_FILES['category_image']['name'] != '')
		
		$this->db->where('id',$organization_id);
		$this->db->dbprefix('organization');
		$upd_into_db = $this->db->update('organization', $upd_data);
		
		if($upd_into_db)
			return true;
		else
			return false;		
		
	}//end edit_organization($organization_id, $data)
	
	public function dismiss_message_list($organization_id){

		$this->db->dbprefix('dismiss_message');
		$this->db->where('organization_id',$organization_id);
		
		//$this->db->where('message_type',$message_type);
		//if(trim($pharmacy_id)!= '') $this->db->where('pharmacy_id',$pharmacy_id);

		$get = $this->db->get('dismiss_message');
		//echo $this->db->last_query(); 		exit;
		
		return $get->result_array();
		
	}//end dismiss_message_list($organization_id)
	
	public function dismiss_message($data){
		
		extract($data);

		$this->db->dbprefix('dismiss_message');
		$this->db->where('organization_id',$organization_id);
		$this->db->where('message_type',$message_type);
		
		if(trim($pharmacy_id)!= '') $this->db->where('pharmacy_id',$pharmacy_id);

		$get = $this->db->get('dismiss_message');
		//echo $this->db->last_query(); 		exit;
		
		$result = $get->row_array();
		
		if(!$result){

			$ins_data = array(
			
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'message_type' => $this->db->escape_str(trim($message_type)),
				'created_date' => date('Y-m-d H:i:s'), 
				'created_by_ip' => $this->input->ip_address()
	
			);
			
			if($pharmacy_id)
				$ins_data['pharmacy_id'] = $pharmacy_id;
			
			$this->db->dbprefix('dismiss_message');
			$ins_into_db = $this->db->insert('dismiss_message', $ins_data);
			
			if($ins_into_db)
				return true;
			else
				return false;

		}else{
			return true;	
		}
		
	}//end dismiss_message($data)
	
	public function update_provide_delivery($organization_id, $pharmacy_id, $provide_delivery){

		$upd_data = array(
			'online_delivery_status' => $this->db->escape_str(trim($provide_delivery))
		);
		
		$this->db->where('organization_id',$organization_id);
		$this->db->where('pharmacy_surgery_id',$pharmacy_id);
		
		$this->db->dbprefix('pharmacy_surgery_global_settings');
		$upd_into_db = $this->db->update('pharmacy_surgery_global_settings', $upd_data);
		//echo $this->db->last_query();
		return true;
		
	}//end update_provide_delivery($organization_id, $pharmacy_id, $provide_delivery)
	
}//end file

?>