<?php
class Governance_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	// Start - add_update_governance_hr():
	public function add_update_governance_hr($post){
		
		extract($post);
	
		if($governance_id !==''){ 
		
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
		
			$data = array(
			'hr_text' => $this->db->escape_str(trim($hr_text)),
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			
			if($pharmacy_surgery!=""){
				
					$data['pharmacy_surgery'] = $pharmacy_surgery;
				
			}
			
			$this->db->dbprefix('governance_hr');
			$this->db->where('id', $governance_id);
			return $this->db->update('governance_hr', $data);
		} 
		
	} // End - add_update_governance_hr():
	
	// Start - get_governance_hr($governance_id):
	public function get_governance_hr($governance_id){
		
		$this->db->dbprefix('governance_hr','usertype');
		$this->db->where('id', $governance_id);
		return $this->db->get('governance_hr')->row_array();
		
	} // End - get_governance_hr($governance_id):
	
	// Start - get_all_governance_hr(): Get all Governance HR for listing
	public function get_all_governance_hr(){
		
	
		$this->db->dbprefix('governance_hr', 'usertype');
		$this->db->select('governance_hr.*,usertype.user_type as username');
		$this->db->from('governance_hr');
		$this->db->join('usertype', 'governance_hr.user_type = usertype.id','left');
		$this->db->order_by('governance_hr.id', 'DESC');
		return $this->db->get()->result_array();
	} // End - get_all_governance_hr():
	
	// Start edit_governance
	public function edit_governance($governance_id){
		
		$this->db->dbprefix('package_governance');
		$this->db->where('id', $governance_id);
		return $this->db->get('package_governance')->row_array();
	    //echo ($this->db->last_query()); exit;
		
	} // end edit_governance
	
	
	// Start edit_governance
	public function update_governance($post){
		
		extract($post);
		$modified_date = date('Y-m-d H:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		$ins_data = array(
			
			'governance_text' => $this->db->escape_str(trim($governance_text)),
			'sop_text' => $this->db->escape_str(trim($sop_text)),
			'finish_text' => $this->db->escape_str(trim($finish_text)),
			'price' => $this->db->escape_str(trim($price)),
			'discount_price' => $this->db->escape_str(trim($discount_price)),
			'governance_expiry_months' => $this->db->escape_str(trim($governance_expiry_months)),
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			
			if($governance_id!="") {
					 	$this->db->dbprefix('package_governance');
					 	$this->db->where('id', $governance_id);
						$success = $this->db->update('package_governance',$ins_data);
	    				//echo ($this->db->last_query()); exit;
			 } else {
				        $ins_data['id'] = $this->db->escape_str(1);
			        	$this->db->dbprefix('package_governance');
			            $success = $this->db->insert('package_governance', $ins_data);
			        }	
			 
			 if($success) 
			     return true;
			else 
			    return false;
	}// end edit_governance
	
	//Function add_new_sop_cateogry(): Add new Sop Catetgory into the database
	public function add_new_sop_cateogry($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'category_name' => $this->db->escape_str(trim($category_name)),
			'status' => $this->db->escape_str(trim($status))
		);
		

		if($category_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_ip'] = $this->db->escape_str(trim($created_by_ip));

			//Inserting  data into the database. 
			$this->db->dbprefix('sop_categories');
			$ins_into_db = $this->db->insert('sop_categories', $ins_data);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//update  data into the database. 
			$this->db->dbprefix('sop_categories');
			$this->db->where('id',$category_id);
			$ins_into_db = $this->db->update('sop_categories', $ins_data);
			
		}//end if($category_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_sop_cateogry($data)
	
	// Start - get_all_sop_category(): Get all Sop Category for listing
	public function get_all_sop_category(){
		$this->db->dbprefix('sop_categories');
		$this->db->from('sop_categories');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_sop_category():
		
	//Function get_sop_category_details($category_id): Get Sop Category details from sop_categories table via sop_categories id
	public function get_sop_category_details($category_id){

		$this->db->dbprefix('sop_categories');
		$this->db->where('id',$category_id);
		$get_page= $this->db->get('sop_categories');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_sop_category_details($category_id)
	
	//Function delete_sop_category(): Delete Sop Category from  database
	public function delete_sop_category($category_id){
		
		$this->db->dbprefix('sops');
		$this->db->where('category_id',$category_id);
		$get_page = $this->db->delete('sops');
		
		$this->db->dbprefix('sop_categories');
		$this->db->where('id',$category_id);
		$get_page = $this->db->delete('sop_categories');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_sop_category($category_id)
	
	//Function add_new_sop(): Add new Sop  into the database
	public function add_new_sop($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$total_user_types  = count($user_types);
		
		$usertypes = array();
		
		for($i=0;$i<$total_user_types;$i++){
			$usertypes[] = 	$user_types[$i];
		}
		
		$users  =  implode(",",$usertypes);
		
		//Record insert into database
		$ins_data = array(
		
			'sop_title' => $this->db->escape_str(trim($sop_title)),
			'sop_description' => $this->db->escape_str(trim($sop_description)),
			'category_id' => $this->db->escape_str(trim($sopcategoryid)),
			'user_types' => $this->db->escape_str(trim($users)),
			'status' => $this->db->escape_str(trim($status))
		);
		
		
		if($sop_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_ip'] = $this->db->escape_str(trim($created_by_ip));

			//Master Copy SOPs Inserting  data into the database. 
			$this->db->dbprefix('sops');
			$ins_into_db = $this->db->insert('sops', $ins_data);
			
			/*// Get all organization id for adding new sops
			$this->db->dbprefix('org_sops');
			$this->db->distinct();
			$this->db->select('organization_id');
			$this->db->from('org_sops');
			$this->db->where('status', 1);
			$get_all_org_id = $this->db->get()->result_array();
			
			if(!empty($get_all_org_id)) 
			{
				foreach($get_all_org_id as $value) {
					
					
					$ins_data['organization_id'] = $value['organization_id'];
					
					//Copy SOPs Inserting  data into the database.
					$this->db->dbprefix('org_sops');
			        $ins_into_db = $this->db->insert('org_sops', $ins_data);
					
				}
				
			}*/
		
		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//update  data into the database. 
			$this->db->dbprefix('sops');
			$this->db->where('id',$sop_id);
			$ins_into_db = $this->db->update('sops', $ins_data);
			//echo $this->db->last_query(); 		exit;
			
		}//end if($sops == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_sop($data)
	
	// Start - get_all_sop(): Get all Sop for listing
	public function get_all_sop(){
		
		$this->db->dbprefix('sops','sop_categories');
		$this->db->select('sops.*,sop_categories.category_name as catname');
		$this->db->from('sops');
		$this->db->join('sop_categories', 'sops.category_id = sop_categories.id', 'left'); 
		$this->db->order_by('sops.id', 'DESC');
		return $this->db->get()->result_array();
		//echo $this->db->last_query(); 		exit;
		
	} // End - get_all_sop():
	
	//Function get_sop_details($sop_id): Get Sop details from sops table via sops id
	public function get_sop_details($sop_id){

		$this->db->dbprefix('sops');
		$this->db->where('id',$sop_id);
		$get_page= $this->db->get('sops');
		return $get_page->row_array();
		
	}//end get_sop_details($sop_id)
	
	// Start - get_all_sop_category(): Get All sop Category
	public function get_all_sopcategories(){
		
	    $this->db->dbprefix('sop_categories');
		$this->db->from('sop_categories');
		return $this->db->get()->result_array();
		//echo $this->db->last_query(); 		exit;
		
	} // End - get_all_selected_city():
	
	//Function delete_sop(): Delete Sop from  database
	public function delete_sop($sop_id){
		
		$this->db->dbprefix('sops');
		$this->db->where('id',$sop_id);
		$get_page = $this->db->delete('sops');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_sop($sop_id)
	
	//GET All ACTIVE USER TYPES
	public function get_active_usertypes(){
		
		$this->db->dbprefix('usertype');
		$this->db->where('status',1);
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('usertype');
		
		return $list_arr->result_array();
		
	}//end get_active_usertypes()

	// Start - Function get_sop_tree:
	public function get_sop_tree(){

		$get_org_sop_categories = $this->get_all_sop_category();
		
		for($i=0;$i<count($get_org_sop_categories);$i++){

			$this->db->dbprefix('sops');
			$this->db->select('sops.id,sops.sop_title, sops.category_id');
			
			//$this->db->where('sops.category_id',$get_org_sop_categories[$i]['id']);
			//if(trim($user_type)!= '') $this->db->like('sops.user_types',$user_type);
			$this->db->where('sops.status = 1');
			$this->db->where('category_id',$get_org_sop_categories[$i]['id']);
			$get_result = $this->db->get('sops');
			
			$sop_result = $get_result->result_array();
			//echo $this->db->last_query(); 		exit;
			if($get_org_sop_categories[$i]['category_name'] != 'None')
				$sop_tree[$get_org_sop_categories[$i]['id'].'#'.$get_org_sop_categories[$i]['category_name']] = $sop_result;
			else{
				$sop_tree[$get_org_sop_categories[$i]['category_name']] = $sop_result;
			}//end if
		}//end for($i=0;$i<count($get_org_sop_categories);$i++)
		
		return $sop_tree;
		
	} //end get_sop_tree()
	// End - Function get_sop_tree:

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
			$this->db->select("org_pharmacy_surgery.*,user_order_details.order_id , user_order_details.expiry_date, user_orders.purchase_date,CONCAT(first_name,' ',last_name) AS purchased_by_name");
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
	
	//Function get_governance_package(): Get the Record from the Package Table to treat Governance as a Product
	public function get_governance_package($governance_id = 1){

		$this->db->dbprefix('package_governance');
			
		$get = $this->db->get('package_governance');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_governance_package($organization_id)

}//end file
?>