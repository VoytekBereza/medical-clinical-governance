<?php
class Governance_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_governance_package(): Get the Record from the Package Table to treat Governance as a Product
	public function get_governance_package($governance_id = 1){

		$this->db->dbprefix('package_governance');
			
		$get = $this->db->get('package_governance');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_governance_package($organization_id)

	//Function get_sops_list(): Returns the Original/ Default SOP's added by the System/ Admin
	public function get_sops_list($sop_id = '', $category_id = ''){

		//Get All SOP's which belongs to this category
		$this->db->dbprefix('sops');
		if(trim($sop_id) != '') $this->db->where('id',$sop_id);
		if(trim($category_id) != '') $this->db->where('category_id',$category_id);
		
		$get_sop = $this->db->get('sops');
		//echo $this->db->last_query(); 		exit;
		$result_sop = $get_sop->result_array();
		
		return $result_sop;

	}//end get_sops_list($sop_id = '', $category_id = '')
	
	//Function get_governance_purchased_pharmacies(): Will return the list of purchased and/ or NON purchased Governance for Phramacies
	//P = Return List of Pharmacies Purchased
	//NP = Return List of Pharmacies NOT Purchased 
	//$pharmacy_surgery_id =  If this is specified, means we are checking expiry or existance or purchase governance of the specific pharmacy.
	public function get_governance_purchased_pharmacies($organization_id, $purchased_non_purchased, $pharmacy_surgery_id=''){
		
		if($purchased_non_purchased == 'P'){

			$this->db->dbprefix('org_pharmacy_surgery');
			$this->db->select("org_pharmacy_surgery.*,user_order_details.expiry_date, user_orders.purchase_date,CONCAT(first_name,' ',last_name) AS purchased_by_name");
			$this->db->where('user_order_details.product_type = "GOVERNANCE"');
			$this->db->where('org_pharmacy_surgery.organization_id',$organization_id);
			
			$this->db->where('org_pharmacy_surgery.is_deleted != 1');
			
			$this->db->where('user_order_details.expiry_date >= "'.date('Y-m-d').'"');
			if(trim($pharmacy_surgery_id)!='')	$this->db->where('user_order_details.pharmacy_surgery_id',$pharmacy_surgery_id);
			$this->db->where("org_pharmacy_surgery.id IN (SELECT pharmacy_surgery_id FROM kod_user_order_details WHERE product_type = 'GOVERNANCE')");
	
			$this->db->join('user_order_details','org_pharmacy_surgery.id = user_order_details.pharmacy_surgery_id');
			$this->db->join('user_orders','user_orders.id = user_order_details.order_id');
			$this->db->join('users','users.id = user_orders.user_id');
			$get_result = $this->db->get('org_pharmacy_surgery');
			
			// echo $this->db->last_query();

			if(trim($pharmacy_surgery_id)!='') return $get_result->row_array();
			else return $get_result->result_array();
									
		}elseif($purchased_non_purchased == 'NP'){

			//Non Purchased List
			$this->db->dbprefix('org_pharmacy_surgery');
			$this->db->where('org_pharmacy_surgery.organization_id',$organization_id);
			$this->db->where('org_pharmacy_surgery.is_deleted != 1');
			
			$this->db->where("id NOT IN (SELECT pharmacy_surgery_id FROM kod_user_order_details WHERE expiry_date >= '".date('Y-m-d')."' AND product_type = 'GOVERNANCE')");
			
			$get_result = $this->db->get('org_pharmacy_surgery');
			//echo $this->db->last_query(); 		exit;
			return $get_result->result_array();

		}//end if($purchased_non_purchased == 'P')
		
	}//end get_governance_purchased_pharmacies($organization_id)
	
	//Function get_organization_sop_categories(): Get List of Organizaition SOP Categories
	public function get_organization_sop_categories($organization_id,$category_id = ''){

		$this->db->dbprefix('org_sop_categories');
		$this->db->where('organization_id',$organization_id);
		if(trim($category_id)!= '') $this->db->where('id',$category_id);
		
		$get = $this->db->get('org_sop_categories');
		//echo $this->db->last_query(); 		exit;
				
		if(trim($category_id)!= '') $result_arr = $get->row_array();
		else $result_arr = $get->result_array();
		
		return $result_arr;

	}//end get_organization_sop_categories($organization_id)
	
	//Function get_organization_sop_tree(): Get List of Org SOP Tree View with category listing documents using organization_id
	//$user_type will be if we need the SOP for a specific UserType
	public function get_organization_sop_tree($organization_id, $user_type = ''){

		$get_org_sop_categories = $this->get_organization_sop_categories($organization_id);
		
		for($i=0;$i<count($get_org_sop_categories);$i++){

			$this->db->dbprefix('org_sops');
			$this->db->select('org_sops.id,org_sops.sop_title, org_sops.category_id');
			$this->db->where('org_sops.organization_id',$organization_id);
			$this->db->where('org_sops.category_id',$get_org_sop_categories[$i]['id']);
			if(trim($user_type)!= '') $this->db->like('org_sops.user_types',$user_type);
			$this->db->where('org_sops.status = 1');
			$get_result = $this->db->get('org_sops');
			
			$sop_result = $get_result->result_array();
			//echo $this->db->last_query(); 		exit;
			if($get_org_sop_categories[$i]['category_name'] != 'None')
				$sop_tree[$get_org_sop_categories[$i]['id'].'#'.$get_org_sop_categories[$i]['category_name']] = $sop_result;
			else{
				$sop_tree[$get_org_sop_categories[$i]['category_name']] = $sop_result;
			}//end if
		}//end for($i=0;$i<count($get_org_sop_categories);$i++)
		
		//print_this($sop_tree);
		//exit;

		return $sop_tree;
		
	}//end get_organization_sop_tree()
	

	public function get_sop_none_category_details($organization_id){

		$this->db->dbprefix('org_sop_categories');
		$this->db->where('organization_id',$organization_id);
		$this->db->where('category_name','None');
		$get_result = $this->db->get('org_sop_categories');
		
		$sop_none_result = $get_result->row_array();
		
		return $sop_none_result;
		
	}//end get_sop_none_details($organization_id)
	
	//Function get_org_governance_details(): Fetch teh Governance details from organization table using governance ID or Organization ID 
	public function get_org_governance_details($governance_id = '', $organization_id = ''){
		
		$this->db->dbprefix('org_governance');
		
		if($governance_id != '')
			$this->db->where('id', $governance_id);

		if($organization_id != '')
			$this->db->where('organization_id', $organization_id);
			
		$get = $this->db->get('org_governance');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_org_governance_details
	
	//Function edit_organization_governance($data): Edit/ Update the Governance Details of an Organization
	public function edit_organization_governance($organization_id,$data){
		
		extract($data);

		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();

		//Record Update into database
		$upd_data = array(
		
			'governance_text' => $this->db->escape_str(trim($governance_text)),
			'sop_text' => $this->db->escape_str(trim($sop_text)),
			'finish_text' => $this->db->escape_str(trim($finish_text)),
			'modified_date' => $this->db->escape_str(trim($modified_date)),
			'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
		);
		
		$this->db->where('organization_id',$organization_id);
		$this->db->dbprefix('org_governance');
		$upd_into_db = $this->db->update('org_governance', $upd_data);
		//echo $this->db->last_query(); 		exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end edit_organization_governance($data)
	
	//Function edit_organization_sop($data): Saving the organization SOP which are updating by the Oraganization owner or SI
	public function edit_organization_sop($data){

		extract($data);

		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		$user_types_str = implode(',',$user_types);
		
		if(strlen($add_new_sop) > 0)
			$category_id = 	$add_new_category_id;
		else
			$category_id = $category_id;
		//end if(strlen($add_new_sop) > 0)
		
		/*
		if($category_id == 'addnew'){
			//First need to add new category

			$modified_date = date('Y-m-d G:i:s');
			$modified_by_ip = $this->input->ip_address();

			$ins_data = array(
			
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'category_name' => $this->db->escape_str(trim($sop_category_name_text)),
				'status' => $this->db->escape_str(trim(1)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
				'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->dbprefix('org_sop_categories');
			$ins_into_db = $this->db->insert('org_sop_categories', $ins_data);
			
			$category_id = $this->db->insert_id();
			
		}// end if($category_id == 'addnew')
		*/
		//Record Update into database
		$upd_data = array(
		
			'organization_id' => $this->db->escape_str(trim($organization_id)),
			'category_id' => $this->db->escape_str(trim($category_id)),
			'sop_title' => $this->db->escape_str(trim($sop_title)),
			'user_types' => $this->db->escape_str(trim($user_types_str)),
			'sop_description' => $this->db->escape_str(trim($sop_edit_text)),
			'modified_date' => $this->db->escape_str(trim($modified_date)),
			'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
		);
		
		if(strlen($add_new_sop) > 0){

			$this->db->dbprefix('org_sops');
			$upd_into_db = $this->db->insert('org_sops', $upd_data);
			//echo $this->db->last_query(); 		exit;
			
		}else{

			$this->db->where('id',$sop_id);
			$this->db->dbprefix('org_sops');
			$upd_into_db = $this->db->update('org_sops', $upd_data);
			//echo $this->db->last_query(); 		exit;

			//We have to delete the SOP read record according to new checked User types, the one which are no more now will be eliminated.
			$old_user_types_arr = explode(',',$old_usertypes);
			$old_user_types_arr = ($old_usertypes == '') ? array() : $old_user_types_arr;
			
			$get_unique_usertypes = array_diff($old_user_types_arr,$user_types); //Have the array with the difference usertypes which need to be eliminated
			
			if(count($get_unique_usertypes) > 0){
				
				foreach($get_unique_usertypes as $user_type){
					
					//Get Record from ORGANIZATION GOVERNANCE  SOP Table which need to be deleted according to the unselected usertypes
					$this->db->dbprefix('governance_sop_read_status');
					$this->db->select('governance_sop_read_status.id');
					$this->db->join('users','users.id = governance_sop_read_status.user_id','INNER');

					$this->db->where('governance_sop_read_status.organization_id', $organization_id);
					$this->db->where('governance_sop_read_status.sop_id', $sop_id);
					$this->db->where('users.user_type', $user_type);
					
					$get_prev_read_governance = $this->db->get('governance_sop_read_status');
					$result = $get_prev_read_governance->result_array();
					
					for($i=0;$i<count($result);$i++){
						
						//Deleting Record from ORGANIZATION GOVERNANCE  SOP Table
						$this->db->dbprefix('governance_sop_read_status');
						$this->db->where('id', $result[$i]['id']);
						$delete_prev_read_governance = $this->db->delete('governance_sop_read_status');

					}//end for($i=0;$i<count($result);$i++)
					
				}//end for($i=0;i<count();$i++)
				
			}//end if(count($get_unique_usertypes) > 0)
				
		}//end if($add_new_sop == 0)

		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end edit_organization_sop($data)

	//Function delete_user_governance_read_record(): Deleting the Governance and SOP Record from the READ table.
	public function delete_user_governance_read_record($user_id, $organization_id, $pharmacy_surgery_id = '', $user_role){


		//Get Record from GOVERNANCE TABLE and delete record from temp contract table.
		$this->db->dbprefix('governance_read_status');
		$this->db->where('user_id', $user_id);
		$this->db->where('organization_id',$organization_id);
		$this->db->where('user_role', $user_role);
		if($pharmacy_surgery_id != '') $this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		
		$get = $this->db->get('governance_read_status');
		
		$governanuce_arr = $get->result_array();
		
		for($i=0;$i<count($governanuce_arr);$i++){
			
			$contract_id = $governanuce_arr[$i]['id']; 

			//Delete the record from the temp data.
			$this->db->dbprefix('temp_governance_hr_contract');
			$this->db->where('contract_id', $contract_id);
			$delete_data = $this->db->delete('temp_governance_hr_contract');
			
		}//end for($i=0;$i<count($governanuce_arr);$i++)

		//Deleting record from GOVERNANCE TABLE
		$this->db->dbprefix('governance_read_status');
		$this->db->where('user_id', $user_id);
		$this->db->where('organization_id',$organization_id);
		$this->db->where('user_role', $user_role);
		
		if($pharmacy_surgery_id != '') $this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		$delete_prev_read_governance = $this->db->delete('governance_read_status');
		
		//Deleting Record from ORGANIZATION GOVERNANCE  SOP Table
		$this->db->dbprefix('governance_sop_read_status');
		$this->db->where('user_id', $user_id);
		$this->db->where('organization_id', $organization_id);
		$this->db->where('user_role', $user_role);
		
		if($pharmacy_surgery_id != '') $this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		$delete_prev_read_governance = $this->db->delete('governance_sop_read_status');
		
		return true;

	}//end delete_user_governance_read_record()

	//Function get_user_governance_read_status(): Will return the governance read record using org_id, pharmacy_id and user id.
	public function get_user_governance_read_status($user_id, $organization_id, $pharmacy_surgery_id = '', $user_role = ''){

		$this->db->dbprefix('governance_read_status');
		$this->db->select('governance_read_status.*, users.is_owner, users.email_address, users.first_name AS sent_to_f_name, users.last_name AS sent_to_l_name, user_sent_by.first_name AS sent_by_f_name, user_sent_by.last_name AS sent_by_l_name');
		$this->db->where('governance_read_status.user_id', $user_id);
		$this->db->where('governance_read_status.organization_id', $organization_id);
		
		if($pharmacy_surgery_id != '')
			$this->db->where('governance_read_status.pharmacy_surgery_id', $pharmacy_surgery_id);

		if($user_role != '')
			$this->db->where('governance_read_status.user_role', $user_role);

		$this->db->join('users', 'users.id = governance_read_status.user_id','LEFT');
		$this->db->join('users AS user_sent_by', 'user_sent_by.id = governance_read_status.hr_contract_sent_by','LEFT');
		
		$get = $this->db->get('governance_read_status');
		//echo $this->db->last_query(); 		exit;
		
		return $get->row_array();
	
	}//end get_user_governance_read_status()

	//Function get_user_governance_data(): Will return the governance read record using ID
	public function get_user_governance_data($hr_contract_id){

		$this->db->dbprefix('governance_read_status');
		$this->db->select('governance_read_status.*,organization.company_name, org_pharmacy_surgery.pharmacy_surgery_name, users.first_name, users.last_name,CONCAT(kod_users.first_name," ",kod_users.last_name) as user_full_name, users.user_type AS user_type_id, users.email_address, 
		users.first_name AS sent_to_f_name, users.last_name AS sent_to_l_name, user_sent_by.first_name AS sent_by_f_name, user_sent_by.last_name AS sent_by_l_name, usertype.user_type');
		$this->db->where('governance_read_status.id', $hr_contract_id);
		
		$this->db->join('users', 'governance_read_status.user_id = users.id','LEFT');
		$this->db->join('users AS user_sent_by', 'user_sent_by.id = governance_read_status.hr_contract_sent_by','LEFT');
		
		$this->db->join('usertype', 'users.user_type = usertype.id','LEFT');
		$this->db->join('organization', 'governance_read_status.organization_id = organization.id','LEFT');
		$this->db->join('org_pharmacy_surgery', 'governance_read_status.pharmacy_surgery_id = org_pharmacy_surgery.id','LEFT');
		
		$get = $this->db->get('governance_read_status');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
	
	}//end get_user_governance_data($hr_contract_id)

	//Function get_organization_sop_details($sop_id): Get the Organization SOP details using SOP ID.
	public function get_organization_sop_details($sop_id){

		$this->db->dbprefix('org_sops');
		$this->db->where('id', $sop_id);
		$get = $this->db->get('org_sops');
		
		return $get->row_array();
		
	}//end get_organization_sop_details($sop_id)
	
	//Function get_organization_sop_list():This function will return the Organizations GOVERNANCE SOP LIST
	//$user_type: If we want to get the list of OR SOP list of a specific usertype
	//category_id = Will return list of organization SOP using category id
	public function get_organization_sop_list($organization_id, $user_type = '', $category_id = ''){

		$this->db->dbprefix('org_sops');
		$this->db->where('organization_id', $organization_id);
		if(trim($category_id) != '')	$this->db->where('category_id', $category_id);
		if(trim($user_type) != '')	$this->db->like('user_types', $user_type);
		
		$get = $this->db->get('org_sops');
		
		return $get->result_array();
		
	}//end get_organization_sop_list($organization_id)
	
	//Function get_user_sop_read_list(): return The LIST of GOVERNANCE SOP's read by the users against organziation or pharmacy and user role
	public function get_user_sop_read_list($user_id, $organization_id, $pharmacy_surgery_id = '', $user_role=''){

		$this->db->dbprefix('governance_sop_read_status');
		$this->db->where('user_id', $user_id);
		$this->db->where('organization_id', $organization_id);
		
		if($pharmacy_surgery_id != '')
			$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		
		if(!empty($user_role)){
		
			if(is_array($user_role)){
				
				if($user_role['is_manager'] == 1)
					$this->db->where('user_role', 'M');
				if($user_role['is_staff'] == 1)
					$this->db->where('user_role', 'ST');
				
			} else
				$this->db->where('user_role', $user_role);
			// if(is_array($user_role))
				
		} // if($user_role != '')
			
		$get = $this->db->get('governance_sop_read_status');
		
		//echo $this->db->last_query(); exit;
		
		return $get->result_array();
		
	}//end get_user_sop_read_list()

	
	//Function delete_organization_sop_category(): Delete the Organization READ SOPs lies in the category
	//Delete the Organization SOPs and then Delete the Category
	
	public function delete_organization_sop_category($organization_id, $catgeory_id){
		
		$get_organization_sop_list = $this->get_organization_sop_list($organization_id,'',$catgeory_id);
		
		for($i=0;$i<count($get_organization_sop_list);$i++){

			//Deleting Sub data from the User SOP read status of all the SOP's 
			$this->db->dbprefix('governance_sop_read_status');
			$this->db->where('sop_id',$get_organization_sop_list[$i]['id']);
			$this->db->where('organization_id',$organization_id);
			$delete_org_sop = $this->db->delete('governance_sop_read_status');
			//echo $this->db->last_query(); 		
			
			//Deleting Record from ORGANIZATION SOP Read Table
			$this->db->dbprefix('org_sops');
			$this->db->where('id',$get_organization_sop_list[$i]['id']);
			$this->db->where('organization_id',$organization_id);
			$delete_org_sop = $this->db->delete('org_sops');
			//echo $this->db->last_query(); 		exit;
			
		}//end for($i=0;$i<count($get_organization_sop_list)$i++)

		//Everything is deleted now delete the category from the Organization SOP Categiry Table
		$this->db->dbprefix('org_sop_categories');
		$this->db->where('id',$catgeory_id);
		$this->db->where('organization_id',$organization_id);
		$delete_org_sop_cat = $this->db->delete('org_sop_categories');
		//echo $this->db->last_query(); 		exit;
		
		if($delete_org_sop_cat)
			return true;
		else
			return false;
		
	}//end delete_organization_sop_category($organization_id, $catgeory_id)

	//Function delete_organization_sop(): Delete teh Organization SOP and all parent/ child record etc.
	public function delete_organization_sop($organization_id, $sop_id){
		
		//Deleting Sub data from the User SOP read status
		$this->db->dbprefix('governance_sop_read_status');
		$this->db->where('sop_id',$sop_id);
		$this->db->where('organization_id',$organization_id);
		$delete_org_sop = $this->db->delete('governance_sop_read_status');
		//echo $this->db->last_query(); 		exit;
		
		//Deleting Record from ORGANIZATION SOP Read Table
		$this->db->dbprefix('org_sops');
		$this->db->where('id',$sop_id);
		$this->db->where('organization_id',$organization_id);
		$delete_org_sop = $this->db->delete('org_sops');
		//echo $this->db->last_query(); 		exit;
		
		if($delete_org_sop)
			return true;
		else
			return false;
		
	}//end delete_organization_sop($sop_id)
	
	//Function governance_read_by_user_list(): Returns the list if SOP read by the user in a specifinc org or pharamcy, its a same copy of is_governance_read_by_user with some different variations. This is used when creating the copy into the governance SOP read.
	public function governance_read_by_user_list($user_id, $organization_id, $pharmacy_surgery_id = '', $user_role = '', $user_type){

		//First check if the GOVERNANCE, if have passed/ read the GOVERNANCE descriptions.
		$check_if_user_read_governance = $this->governance->get_user_governance_read_status($user_id,$organization_id, $pharmacy_surgery_id, $user_role);

		if($check_if_user_read_governance){
		
			//Record found now check if GOVERNANCE is all read.
			if($check_if_user_read_governance['hr_read']){
				## Means user have read the GOVERNANCE now its time to verify if the GOVERNANCE SOPs are read.

				//Now fect the record of user in READ SOP table to see how many SOP's are READ
				$get_user_sop_read_list = $this->governance->get_user_sop_read_list($user_id,$organization_id, $pharmacy_surgery_id, $user_role);
				
				return $get_user_sop_read_list;

			}else
				return false;
			//end if
				
		}else{
			//Record do not exist into the database
			return false;	
		}//end if($check_if_user_read_governance)
		
	}//end function governance_read_by_user_list($user_id, $organization_id, $pharmacy_surgery_id = '', $user_role = '', $user_type)
	
	//Function governance_read_by_user(): This function will return true if user have cleared the governance of an organization or a pharamcy
	public function is_governance_read_by_user($user_id, $organization_id, $pharmacy_surgery_id = '', $user_role = '', $user_type){

		//First check if the GOVERNANCE, if have passed/ read the GOVERNANCE descriptions.
		$check_if_user_read_governance = $this->governance->get_user_governance_read_status($user_id,$organization_id, $pharmacy_surgery_id, $user_role);
		
		if($check_if_user_read_governance){
		
			//Record found now check if GOVERNANCE is all read.
			if($check_if_user_read_governance['hr_read']){
				## Means user have read the GOVERNANCE now its time to verify if the GOVERNANCE SOPs are read.
				
				//Get the list of organization SOP list
				$get_org_sop_list = $this->governance->get_organization_sop_list($organization_id, $user_type);
				//$total_no_of_org_sop = $get_org_sop_list;

				//Now fect the record of user in READ SOP table to see how many SOP's are READ
				$get_user_sop_read_list = $this->governance->get_user_sop_read_list($user_id,$organization_id, $pharmacy_surgery_id, $user_role);
				
				//$total_no_of_sop_read = $get_user_sop_read_list;

				$return_sop_read_status = 1;
				// Loop on all the sops with status active : All Actiove sops by user_type
				foreach($get_org_sop_list as $sop){

					$index_key = array_search(filter_string($sop['id']), array_column($get_user_sop_read_list, 'sop_id'));

					if(!is_numeric($index_key)){
						//print_this($get_user_sop_read_list[$index_key]);
						//The SOP is not viewed not even exist in SOP read status.
						$return_sop_read_status = 0;
						break;

					}else{
						
						if($get_user_sop_read_list[$index_key]['is_signed'] == 0){
							
							//Is viewed but not yet signed. So for that record will exist into the database.
							$return_sop_read_status = 0;
							break;
							
						}//end if(($get_user_sop_read_list[$index_key]['is_signed'] == 0)
						
					}// if(is_numeric($index_key))

				} // foreach($get_org_sop_list)
				
				//echo $return_sop_read_status; exit;

				//If both are equal means number of SOP's added by org are read by the user so governance is clear.
				if( $return_sop_read_status ){
					return true;
				}else{
					return false;
				} // if( $return_sop_read_status )

			}else{
				return false;
			}//end if
				
		}else{
			//Record do not exist into the database
			return false;	
		}//end if($check_if_user_read_governance)
			
	}//end governance_read_by_user()
	
	//Function enforce_organization_sop_reading(): This function will delete the record from the read sop table, this will ensure that the number of organization SOP and read SOP are not equal and will force to read that SOP again.
	public function enforce_organization_sop_reading($organization_id,$sop_id){

		//Deleting Record from ORGANIZATION SOP Read Table
		$this->db->dbprefix('governance_sop_read_status');
		$this->db->where('sop_id',$sop_id);
		$this->db->where('organization_id',$organization_id);
		
		$delete_prev_read_sop = $this->db->delete('governance_sop_read_status');
		//echo $this->db->last_query(); 		exit;
		
		if($delete_prev_read_sop)
			return true;
		else
			return false;
		
	}//end enforce_organization_sop_reading($organization_id,$sop_id)
	
	public function get_organization_sop_read_details($user_id, $sop_id,$organization_id, $pharmacy_surgery_id = ''){
		
		$this->db->dbprefix('governance_sop_read_status');
		
		$this->db->where('user_id', $user_id);
		$this->db->where('organization_id', $organization_id);
		$this->db->where('sop_id', $sop_id);
		//if(trim($is_read) != '') $this->db->where('is_read', $is_read);
		
		if($pharmacy_surgery_id != '') $this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
			
		$get = $this->db->get('governance_sop_read_status');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
	
	}//end get_organization_sop_read_details($user_id, $organization_id, $pharmacy_surgery_id = '')
	
	
	//Function mark_organization_sop_read(): This function will mark the Oraganizaition SOP as READ. So basically will mark an entry into the database.
	function mark_organization_sop_read($user_id, $pharmacy_surgery_id='', $organization_sop_detail, $is_superintendent, $user_role='',$is_viewed = '0', $is_signed = '0'){
		
		//echo $user_role; exit;
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$ins_data = array(
			'user_id' => $this->db->escape_str(trim($user_id)),
			'organization_id' => $this->db->escape_str(trim($organization_sop_detail['organization_id'])),
			'sop_id' => $this->db->escape_str(trim($organization_sop_detail['id'])),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);

		if($is_viewed == '1'){
			
			$view_code =  $this->common->random_number_generator(15);
			$view_code = strtoupper($view_code);
			$ins_data['view_code'] = $view_code;
			$ins_data['is_read'] = $is_viewed;
			$ins_data['viewed_date'] = $this->db->escape_str($created_date);
			$ins_data['viewed_by_ip'] = $this->db->escape_str($created_by_ip);
			
		}//end if($is_viewed == '1')
		
		
		if($is_signed == '1'){
			
			//$ins_data['read_dated'] = $this->db->escape_str($created_date);
			$ins_data['is_signed'] = $this->db->escape_str('1');
			$ins_data['signed_date'] = $this->db->escape_str($created_date);
			$ins_data['signed_by_ip'] = $this->db->escape_str($created_by_ip);

			$this->db->dbprefix('governance_sop_read_status');
			$this->db->where('sop_id',$organization_sop_detail['id']);
			$this->db->where('user_id',$user_id);
			$this->db->where('is_read', '1');
			$this->db->where('viewed_date IS NOT NULL');
			$this->db->order_by('viewed_date', 'ASC');
			$this->db->limit(1);
			
			$get = $this->db->get('governance_sop_read_status');
			$row_array = $get->row_array();
			
			if($row_array){
				$prev_viewed_date = $row_array['viewed_date'];
				$prev_viewed_by_ip = $row_array['viewed_by_ip'];
			}else{
				$prev_viewed_date = $created_date;
				$prev_viewed_by_ip = $created_by_ip;
			}//end if($row_array)
			

			$ins_data['viewed_date'] = $this->db->escape_str($prev_viewed_date);
			$ins_data['viewed_by_ip'] = $this->db->escape_str($prev_viewed_by_ip);
			
			$this->db->dbprefix('governance_sop_read_status');
			$this->db->where('sop_id',$organization_sop_detail['id']);
			$this->db->where('user_id',$user_id);
			$delete_data = $this->db->delete('governance_sop_read_status');
			
		}//end if($is_signed == '1')
		
		if(is_array($user_role)){
			
			if($user_role['is_manager'] == 1 || $user_role['is_staff'] == 1 || $user_role['is_si'] && $user_role['is_si'] == 1){
				
				//if(!$is_superintendent)
					//$ins_data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
				
				if($user_role['is_manager'] == 1){
					
					if($user_role['manager_in']){
					
						foreach($user_role['manager_in'] as $pharmacy_surgery){
					
							// SOP read Entry for Manager
							$ins_data['user_role'] = 'M';
							$ins_data['pharmacy_surgery_id'] = $pharmacy_surgery['id'];
							
							$this->db->dbprefix('governance_sop_read_status');
							$ins_into_db = $this->db->insert('governance_sop_read_status', $ins_data);
							
						} // foreach($user_role['manager_in'] as $pharmacy_surgery)
						
					} // if($user_role['manager_in'])
					
				} //if($user_role['is_manager'] == 1)
					
				if($user_role['is_staff'] == 1){
					
					if($user_role['staff_in']){
					
						foreach($user_role['staff_in'] as $staff){
					
							// SOP read Entry for Staff
							$ins_data['user_role'] = 'ST';
							$ins_data['pharmacy_surgery_id'] = $staff['pharmacy_surgery_id'];
							
							$this->db->dbprefix('governance_sop_read_status');
							$ins_into_db = $this->db->insert('governance_sop_read_status', $ins_data);
							
						} // foreach($user_role['staff_in'] as $pharmacy_surgery)
						
					} // if($user_role['manager_in'])
					
				} // if($user_role['is_staff'] == 1)
				
				if($is_superintendent){
					
					if(isset($ins_data['pharmacy_surgery_id']))
						unset($ins_data['pharmacy_surgery_id']);
					
					// SOP read Entry for SI
					$ins_data['user_role'] = 'SI';
					$this->db->dbprefix('governance_sop_read_status');
					$ins_into_db = $this->db->insert('governance_sop_read_status', $ins_data);
					
				} // if($is_superintendent)
		
			} // if($user_role['is_manager'] == 1 || $user_role['is_staff'] == 1 || $user_role['is_si'] && $user_role['is_si'] == 1)
		
			if($ins_into_db)
				return true;
			else
				return false;
		
		} else { // If user_role is not an array: Must should be [ 'SI' - 'M' - 'ST' ]
		
			if($user_role != 'SI')
				$ins_data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
			// if($user_role != 'SI')
		
			$ins_data['user_role'] = $user_role;

			//Inserting User data into the database. 
			$this->db->dbprefix('governance_sop_read_status');
			$ins_into_db = $this->db->insert('governance_sop_read_status', $ins_data);
			//echo $this->db->last_query(); 		exit;
			
			if($is_superintendent){
					
				// SOP read Entry for SI
				$ins_data['user_role'] = 'SI';
				$this->db->dbprefix('governance_sop_read_status');
				$ins_into_db = $this->db->insert('governance_sop_read_status', $ins_data);
				
			} // if($is_superintendent)
			
			if($ins_into_db)
				return true;
			else
				return false;
	
		} // if(is_array($user_role))
		
	}//end mark_organization_sop_read($user_id,$sop_id)

	//Function mark_organization_sop_read(): This function will mark the Oraganizaition SOP as READ. So basically will mark an entry into the database.
	function mark_organization_hr_read($user_id,$pharmacy_surgery_id,$organization_governance_detail, $user_org_superintendent){
		
		$modified_date = date('Y-m-d G:i:s');
		$upd_data = array(
			'hr_read' => $this->db->escape_str(trim(1)),
			'read_dated' => $this->db->escape_str($modified_date),
			'modified_date' => $this->db->escape_str(trim($modified_date))
		);
		
		if($pharmacy_surgery_id!='' && !$user_org_superintendent) //&& !$user_org_superintendent means if user is a SI, he do not need to give governance if he is a Manager or a Staff member of any of his organization.
			$upd_data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
		
		//Inserting User data into the database. 
		$this->db->dbprefix('governance_read_status');
		$this->db->where('user_id',$user_id);
		$this->db->where('organization_id',$organization_governance_detail['organization_id']);
		if($pharmacy_surgery_id!='' && !$user_org_superintendent) 
			$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		
		$upd_into_db = $this->db->update('governance_read_status', $upd_data);
		//echo $this->db->last_query(); 		exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
			
	}//end mark_organization_hr_read($user_id,$pharmacy_surgery_id,$organization_governance_detail)

	//Function download_sop_signed_pdf(): Prepare PDF version of the Read SOP for the user. Also need to add the signatures in the end.
	public function download_sop_signed_pdf($user_id,$sop_id,$pharmacy_surgery_id,$sop_data,$sop_read_data){
		
		$get_user_detials = $this->users->get_user_details($user_id);
		$get_user_signature =  $this->users->get_user_signatures($user_id);

		if(filter_string($get_user_signature['signature_type']) == 'svn')
			$user_signature = filter_string($get_user_signature['signature']);
		else
			$user_signature = "<img src='".filter_string($get_user_signature['signature'])."' width='200px' height='60px' />";
		
		$sop_file_name = filter_string($sop_data['sop_title']);
		$sop_file_name = str_replace(' ','-',strtolower($sop_file_name)).'-sop.pdf';

		$sop_contents = filter_string($sop_data['sop_description']);
		
		$sop_read_time = date('G:i',strtotime(filter_string($sop_read_data['created_date'])));
		$sop_read_date = date('d/m/y',strtotime(filter_string($sop_read_data['created_date'])));

		$search_arr = array('[USER_SIGNATURE]','[CONTRACT_NO]','[SIGNED_DATE_TIME]','[SURL]');
		$replace_arr = array($user_signature,strtoupper($this->common->random_number_generator(16)),'Signed at '.$sop_read_time.' on '.$sop_read_date.' by',SURL);
		$sop_contents = str_replace($search_arr,$replace_arr,$sop_contents);
		
		$sop_contents = '<style>.main-font {font-family:Arial, Helvetica, sans-serif;}table{font-family:Arial, Helvetica, sans-serif;}</style><div class="main-font">'.$sop_contents.'</div>';
		
		$sop_contents .= '<div style="border:solid 1px #ccc; float: left; width:100%"><div style="float:left; width:100%; padding:10px; background-color: #D9EDF7"><table cellpadding="2" cellspacing="10" width="100%">
<tbody>
	<tr>
		<td style="padding:10px"><img src="'.IMAGES.'/fa-eye.png" width="30" /></td>
		<td style="padding:10px"><strong>'.uk_date_format($sop_read_data['viewed_date']).'</strong><br />
		'.uk_date_format($sop_read_data['viewed_date'],true).'</td>
		
		<td style="padding:10px">Viewed by <strong>'.filter_name($get_user_detials['first_name'].' '.$get_user_detials['last_name']).'</strong> ('.filter_string($get_user_detials['email_address']).')<br />
		<strong>IP:</strong> '.filter_string($sop_read_data['viewed_by_ip']).'</td>
	</tr>
	<tr>
		<td style="padding:10px"><img src="'.IMAGES.'fa-signature.png" width="30" /></td>
		<td style="padding:10px"><strong>'.uk_date_format($sop_read_data['signed_date']).'</strong><br />
		'.uk_date_format($sop_read_data['signed_date'],true).'</td>
		<td style="padding:10px">Signed by <strong>'.filter_name($get_user_detials['first_name'].' '.$get_user_detials['last_name']).'</strong> ('.filter_string($get_user_detials['email_address']).')<br />
		<strong>IP:</strong> '.filter_string($sop_read_data['signed_by_ip']).'</td>
	</tr>
	<tr>
		<td style="padding:10px"><img src="'.IMAGES.'fa-check.png" width="30" /></td>
		<td style="padding:10px"><strong>'.uk_date_format($sop_read_data['signed_date']).' </strong><br />
		'.uk_date_format($sop_read_data['signed_date'],true).'</td>
		<td style="padding:10px">The document has been completed.</td>
	</tr>
	<tr>
		<td style="padding:10px"><img src="'.IMAGES.'fa-user-id.png" width="30" /></td>
		<td style="padding:10px"><strong> Unique ID</strong></td>
		<td style="padding:10px">'.$sop_read_data['view_code'].'</td>
	</tr>
</tbody>
</table></div>';

		$sop_contents .= '
		<div style="float:left; width:100%" class="main-font">
			<div style="text-align:right; width:70%; float:left; padding-top:20px">Signature: </div>
			<div style="text-align:right; width:30%; float:left">'.$user_signature.'</div>
		</div> </div>';
		
	
		
		//echo $sop_contents; exit;
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure 
		$pdf->WriteHTML($sop_contents); // write the HTML into the PDF
		
		$pdf->Output($sop_file_name,'D'); // save to file because we can

	}//end download_sop_signed_pdf($user_id,$sop_id,$pharmacy_surgery_id,$sop_data)

	//Function download_hr_signed_pdf(): Prepare PDF version of the Read HR for the user. Also need to add the signatures in the end.
	public function download_hr_signed_pdf($user_id,$organization_id,$user_type){
		
		$get_user_detials = $this->users->get_user_details($user_id);
		$get_user_signature =  $this->users->get_user_signatures($user_id);

		if(filter_string($get_user_signature['signature_type']) == 'svn')
			$user_signature = filter_string($get_user_signature['signature']);
		else
			$user_signature = "<img src='".filter_string($get_user_signature['signature'])."' width='200px' height='60px' />";
		
		
		$get_organization_hr_document = $this->governance->get_organization_hr_details('',$organization_id,$user_type);
		
		$hr_file_name = filter_string($get_organization_hr_document['hr_text']);
		$hr_file_name = 'hr-agreement.pdf';

		$hr_contents = filter_string($get_organization_hr_document['hr_text']);
		$hr_contents .= '<br>';
		$hr_contents .= $user_signature;
		//$hr_contents .= '<br>';
		//$hr_contents .= "[".ucwords($get_user_detials['first_name'].' '.$get_user_detials['last_name'])."]";

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure 
		$pdf->WriteHTML($hr_contents); // write the HTML into the PDF
		
		$pdf->Output($hr_file_name,'D'); // save to file because we can

	}//end download_hr_signed_pdf($user_id,$pharmacy_surgery_id,$governance_data)

	// Start - public function get_governance_hr($invitation_sent_to_user_type, $pharmacy_surgery_type) : 
	//Function to Fetc Governance HR by [ user type and Pharmacy/Surgery Type ]
	public function get_governance_hr($invitation_sent_to_user_type='', $invitation_for, $pharmacy_surgery_type=''){

		$this->db->dbprefix('governance_hr');

		if($invitation_for == 'M' || $invitation_for == 'SI')
			$this->db->where('contract_for', $invitation_for);
		else{
			$this->db->where('user_type', $invitation_sent_to_user_type); // 1,2,3...
			if($pharmacy_surgery_type) $this->db->where('pharmacy_surgery', $pharmacy_surgery_type); // 'P' OR 'S'
		}
		
		return $this->db->get('governance_hr')->row_array(); // Return Row

	} // End - public function get_governance_hr($invitation_sent_to_user_type, $pharmacy_surgery_type)

	//Function get_governace_hr_temp_details(): Will fetch the data from the temp tabale, as when OSP will resend the contract it will remain in the temp table till users do not approve it. System will firttst try to fetch the data from temp table if not found will fetch from the governance table.
	public function get_governace_hr_temp_details($hr_temp_contract_id = '', $hr_contract_id = ''){

		$this->db->dbprefix('temp_governance_hr_contract');
		$this->db->select('temp_governance_hr_contract.*,users.first_name, users.last_name,CONCAT(first_name," ",last_name) as user_full_name');
		
		if(trim($hr_contract_id) !='')
			$this->db->where('temp_governance_hr_contract.contract_id', $hr_contract_id);

		if(trim($hr_temp_contract_id) !='')
			$this->db->where('temp_governance_hr_contract.id', $hr_temp_contract_id);
		
		$this->db->join('users', 'temp_governance_hr_contract.user_id = users.id','LEFT');
		$this->db->join('governance_read_status', 'governance_read_status.id = temp_governance_hr_contract.contract_id','LEFT');
		
		$get = $this->db->get('temp_governance_hr_contract');
		//echo $this->db->last_query(); 		exit;
		$contract_arr = $get->row_array();
		
		if($contract_arr){
		
			$get_governance_contract_data = $this->governance->get_user_governance_data($contract_arr['contract_id']);	

			$contract_arr['organization_id'] = $get_governance_contract_data['organization_id'];
			$contract_arr['company_name'] = $get_governance_contract_data['company_name'];
			
			$contract_arr['pharmacy_surgery_id'] = $get_governance_contract_data['pharmacy_surgery_id'];
			$contract_arr['pharmacy_surgery_name'] = $get_governance_contract_data['pharmacy_surgery_name'];
			
			$contract_arr['user_role'] = $get_governance_contract_data['user_role'];
			$contract_arr['user_type'] = $get_governance_contract_data['user_type'];
			$contract_arr['user_type_id'] = $get_governance_contract_data['user_type_id'];
			
		}//end if($contract_arr)
		
		return $contract_arr;
	
	}//end get_governace_hr_temp_details($hr_contract_id)

	//Function get_user_revised_contract_list(): Returns the list if Active Renew contract Available in the Temp Table 
	public function get_user_revised_contract_list($user_id){
		
		$this->db->dbprefix('temp_governance_hr_contract');
		$this->db->where('user_id',$user_id);
		$this->db->where('request_changes','0');
		$get = $this->db->get('temp_governance_hr_contract');
		//echo $this->db->last_query(); 		exit;

		return $get->result_array();
		
	}//end get_user_invitations_list()
	
	
	//Function update_governace_hr_temp_contract(): If $resend_contract_id!= '' means new record need to be stored into the temp table, if $temp_contract_id!='' it means user have sent request for changes or maybe need to edit the recently sent contract so udpate
	public function update_governace_hr_temp_contract($data,$contract_data = array(),$temp_contract_data = array()){
		
			extract($data);

			$modified_date = date('Y-m-d G:i:s');
			$modified_by_ip = $this->input->ip_address();
			
			if($resend_contract_id !=''){
				
				if($no_contract && $no_contract == 1){
		
					$this->load->model('email_mod','email_template');
					$email_body_arr = $this->email_template->get_email_template(18);
					$governance_hr_text = stripcslashes($email_body_arr['email_body']);
		
				}else{
					
					$governance_hr_text = stripcslashes($governance_resend_contract_text);
					$no_contract = '0';
					
				}// if($no_contract && $no_contract == 1)

				if($contract_data['user_role'] == 'M')
					$organization_role = 'Manager';
				if($contract_data['user_role'] == 'S')
					$organization_role = 'Superintendent';
				if($contract_data['user_role'] == 'ST')
					$organization_role = filter_string($contract_data['user_type']);
				
				$organization_name = filter_string($contract_data['company_name']);
				$pharmacy_surgery_name = filter_string($contract_data['pharmacy_surgery_name']);

				if($contract_type == 'S'){
					
					//SI  contract
					$invitation_txt = '<b>Your contract with <strong style="text-transform:uppercase;" class="text-primary">'.$organization_name.'</strong> as a <strong style="text-transform:uppercase;" class="text-primary">'.$organization_role.'</strong> is updated, please View Contract to take further action.</b>';
				} else{
					
					//Manager or Staff 
					$invitation_txt = '<b>Your contract with <strong style="text-transform:uppercase;" class="text-primary">'.$pharmacy_surgery_name.'</strong> as a <strong style="text-transform:uppercase;" class="text-primary">'.$organization_role.'</strong> is updated, please View Contract to take further action.</b>';
					
				}//end if($contract_type == 'S')
				
				$ins_data = array(
				
					'user_id' => $this->db->escape_str(trim($resend_contract_to_user_id)),
					'contract_id' => $this->db->escape_str(trim($resend_contract_id)),
					'hr_contract' => $this->db->escape_str(trim($governance_hr_text)),
					'invitation_txt' => $this->db->escape_str(trim($invitation_txt)),
					'no_contract' => $this->db->escape_str(trim($no_contract)),
					'request_changes' => $this->db->escape_str(trim('0')),
					'request_change_notes' => $this->db->escape_str(trim('')),
					'created_date' => $this->db->escape_str(trim($modified_date)),
					'created_by_ip' => $this->db->escape_str(trim($modified_by_ip))
				);
				
				$this->db->dbprefix('temp_governance_hr_contract');
				$ins_into_db = $this->db->insert('temp_governance_hr_contract', $ins_data);
	
			}//end if($resend_contract_id !='')
			if($temp_contract_id !=''){

				if($no_contract && $no_contract == 1){
		
					$this->load->model('email_mod','email_template');
					$email_body_arr = $this->email_template->get_email_template(18);
					$governance_hr_text = filter_string($email_body_arr['email_body']);
		
				}else{
					$governance_hr_text = filter_string($governance_resend_contract_text);
					$no_contract = '0';
				}// if($no_contract && $no_contract == 1)

				if($temp_contract_data['user_role'] == 'M')
					$organization_role = 'Manager';
				if($temp_contract_data['user_role'] == 'S')
					$organization_role = 'Superintendent';
				if($temp_contract_data['user_role'] == 'ST')
					$organization_role = filter_string($temp_contract_data['user_type']);
				
				$organization_name = filter_string($temp_contract_data['company_name']);
				$pharmacy_surgery_name = filter_string($temp_contract_data['pharmacy_surgery_name']);

				if($contract_type == 'S'){
					
					//SI  contract
					$invitation_txt = '<b>Your contract with <strong style="text-transform:uppercase;" class="text-primary">'.$organization_name.'</strong> as a <strong style="text-transform:uppercase;" class="text-primary">'.$organization_role.'</strong> is updated, please View Contract to take further action.</b>';
				} else{
					
					//Manager or Staff 
					$invitation_txt = '<b>Your contract with <strong style="text-transform:uppercase;" class="text-primary">'.$pharmacy_surgery_name.'</strong> as a <strong style="text-transform:uppercase;" class="text-primary">'.$organization_role.'</strong> is updated, please View Contract to take further action.</b>';
					
				}//end if($contract_type == 'S')
				
				$upd_data = array(
				
					'user_id' => $this->db->escape_str(trim($resend_contract_to_user_id)),
					'hr_contract' => $this->db->escape_str(trim($governance_hr_text)),
					'no_contract' => $this->db->escape_str(trim($no_contract)),
					'request_changes' => $this->db->escape_str(trim('0')),
					'request_change_notes' => $this->db->escape_str(trim('')),
					'created_date' => $this->db->escape_str(trim($modified_date)),
					'created_by_ip' => $this->db->escape_str(trim($modified_by_ip))
				);
				
				$this->db->dbprefix('temp_governance_hr_contract');
				$this->db->where('id',$temp_contract_id);
				$upd_into_db = $this->db->update('temp_governance_hr_contract', $upd_data);
	
			}//end if($temp_contract_id !='')

			return true;

	}//end update_governace_hr_temp_contract($resend_contract_id = '',$temp_contract_id = '')
	
	//function update_renewal_contract(): This functin take approproate action on whatever user have selected against the renewal contract request.
	public function update_renewal_contract($temp_contract_data,$contract_action){
		
		if($contract_action == '0'){
			
			//Means User have rejected the renew request, delete the temporary data.	
			
			$this->db->dbprefix('temp_governance_hr_contract');
			$this->db->where('id', $temp_contract_data['id']);
			$delete_data = $this->db->delete('temp_governance_hr_contract');
			
		}//end if($contract_action == '0')

		if($contract_action == '1'){
			
			//Means User have Accepted the renew request, update the governance read status table and then delete the temporary data.	
			$modified_date = date('Y-m-d G:i:s');
			
			$hr_contract_str = filter_string($temp_contract_data['hr_contract']);

			$user_signatures = $this->users->get_user_signatures(filter_string($temp_contract_data['user_id']));			

			if(filter_string($user_signatures['signature_type']) == 'svn')
				$signature_str = filter_string($user_signatures['signature']);
			elseif(filter_string($user_signatures['signature_type']) == 'image')
				$signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
			// if(filter_string($user_signatures['signature_type']) == 'svn')										

			$search_arr = array('[USER_SIGNATURE]','[SIGNED_DATE_TIME]');
			$replace_arr = array($signature_str,'Signed at '.date('G:i').' on '.date('d/m/y').' by');
			
			$hr_contract_str = str_replace($search_arr,$replace_arr,$hr_contract_str);
			
			//Record Update into database
			$upd_data = array(
			
				'hr_contract' => $this->db->escape_str(trim($hr_contract_str)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
			);
			
			$this->db->where('id',$temp_contract_data['contract_id']);
			$this->db->dbprefix('governance_read_status');
			$upd_into_db = $this->db->update('governance_read_status', $upd_data);
			//echo $this->db->last_query(); 		exit;
			
			if($upd_into_db){
			
				//Delete the record from the temp data.
				$this->db->dbprefix('temp_governance_hr_contract');
				$this->db->where('id', $temp_contract_data['id']);
				$delete_data = $this->db->delete('temp_governance_hr_contract');
				
			}//end if($upd_into_db)
			
		}//end if($contract_action == '1')
		
		return true;
		
	}//end update_renewal_contract($temp_contract_id,$contract_action)
	
	public function update_temp_contract_for_changes($data){

		extract($data);
		
		//Record insert into database
		$upd_data = array(
		
			'request_changes' => $this->db->escape_str(1),
			'request_change_notes' => $this->db->escape_str(trim($renew_request_change_notes)),
		);
		
		//Inserting User data into the database. 
		$this->db->where('id',$renew_temp_contract_id);
		$this->db->dbprefix('temp_governance_hr_contract');
		$upd_into_db = $this->db->update('temp_governance_hr_contract', $upd_data);
		
		//echo $this->db->last_query(); 		exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
			
	}//end update_temp_contract_for_changes($data)
	
	//Function get_sop_category_details(): Update the SOP Category of an Organization which is managed by Org in Edit governance.
	public function get_sop_category_details($organization_id,$category_id){

		$this->db->dbprefix('org_sop_categories');
		$this->db->where('organization_id',$organization_id);
		$this->db->where('id',$category_id);
			
		$get = $this->db->get('org_sop_categories');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_sop_category_details($organization_id,$category_id)
	
	public function add_edit_sop_category($data){
		
		extract($data);

		$modified_date = date('Y-m-d G:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		if($category_id){
			
			//Update the record

			$upd_data = array(
						
				'category_name' => $this->db->escape_str(trim($category_name)),
				'modified_date' => $this->db->escape_str(trim($modified_date)),
				'modified_by_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->dbprefix('org_sop_categories');
			$this->db->where('organization_id',$organization_id);
			$this->db->where('id',$category_id);
			$upd_into_db = $this->db->update('org_sop_categories', $upd_data);
			
		}else{
			//Insert the record
			
			$ins_data = array(
						
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'category_name' => $this->db->escape_str(trim($category_name)),
				'created_date' => $this->db->escape_str(trim($modified_date)),
				'created_ip' => $this->db->escape_str(trim($modified_by_ip))
			);
			
			$this->db->dbprefix('org_sop_categories');
			$ins_into_db = $this->db->insert('org_sop_categories', $ins_data);
			
		}//end if($category_id)
		
		//echo $this->db->last_query(); exit;
		
		return true;
		
	}//end add_edit_sop_category
	
}//end file
?>