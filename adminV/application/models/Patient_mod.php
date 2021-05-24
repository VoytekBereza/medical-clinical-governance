<?php
class Patient_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_patient_details($patients_id): Get patient details from patients table via patient id
	
	public function get_system_default_prescriber__(){

		$this->db->dbprefix('users');
		$this->db->where('system_prescriber','1');
		$get = $this->db->get('users');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_patient_details($patient_id)
	
	public function get_system_default_prescriber(){

		$this->db->dbprefix('admin');
		$this->db->where('login_user_type','prescriber');
		$this->db->where('status','1');
		$get = $this->db->get('admin');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_patient_details($patient_id)
	

	//Function get_patient_details($patients_id): Get patient details from patients table via patient id
	public function get_patient_details($patient_id){

		$this->db->dbprefix('patients');
		$this->db->select('patients.*');
		$this->db->from('patients');
		$this->db->where('patients.id',$patient_id);
		$get_patient= $this->db->get();
		//echo $this->db->last_query(); 		exit;
		return $get_patient->row_array();
		
	}//end get_patient_details($patient_id)
	
	//Function delete_patient(): Delete Patient from  database
	public function delete_patient($patient_id){
		
		$this->db->dbprefix('patients');
		$this->db->where('id',$patient_id);
		$get_patient = $this->db->delete('patients');
		//echo $this->db->last_query(); exit;
		
		if($get_patient)
			return true;
		else
			return false;
		
	}//end delete_patient($patient_id)
	
	//Function update_patient(): update patient into the database
	public function update_patient($data){
		
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		/******************************/
	
		 $dob = $birth_year."-".$birth_month."-".$birth_date;
		 
		  $postcode = str_replace(' ', '', $postcode); // Saving the postcode without spaces for all consistent Postcode search
		
		//Record Update into database
		
			$ins_data = array(
		
			'first_name' => $this->db->escape_str(trim($first_name)),
			'last_name' => $this->db->escape_str(trim($last_name)),
			'mobile_no' => $this->db->escape_str(trim($mobile_no)),
			'email_address' => $this->db->escape_str(trim($email_address)),
			'address' => $this->db->escape_str(trim($address)),
			'address_2' => $this->db->escape_str(trim($address_2)),
			'address_3' => $this->db->escape_str(trim($address_3)),
			'postcode' => $this->db->escape_str(trim($postcode)),
			'gender' => $this->db->escape_str(trim($gender)),
			'status' => $this->db->escape_str(trim($status)),
			'dob' => $this->db->escape_str($dob)
			
			);
		
	          if($patient_id != ''){
				
				$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
				$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
	
				// md5 format
				//$ins_data['password'] = $this->db->escape_str(trim(md5($password)));
				
				// check email exist Query
				$this->db->dbprefix('patients');
				$this->db->select('count(id) as totalemail');
				$this->db->from('patients'); 
				$this->db->where('id !=',$patient_id);
				$this->db->where('email_address',$email_address);
				$query = $this->db->get();
	    		$row = $query->row_array();
				//echo $this->db->last_query(); exit;
				if($row['totalemail']>0) {
					return $row['totalemail'];		
					return false;
				} else {
				
				//update  data into the database. 
				$this->db->dbprefix('patients');
				$this->db->where('id',$patient_id);
				$ins_into_db = $this->db->update('patients', $ins_data);
				//echo $this->db->last_query(); exit;		 
				}
				
			if($ins_into_db)
				  return true;
			else
				  return false;
		} 
 }//end update_patients($data)
		
	// Start - get_all_patients(): Get all Patients for listing
	public function get_all_patients(){
		
		$this->db->dbprefix('patients');
		$this->db->select('patients.*');
		$this->db->from('patients');
		$this->db->order_by('patients.id', 'DESC');
		$query = $this->db->get();
	    return $query->result_array();
	   //echo $this->db->last_query();  exit;
			
	} // End - get_all_patients():
	
	// Start - get_all_default_team_patients(): Get all Default Team Users listing
	public function get_all_default_team_patients(){
		
	    $this->db->dbprefix('patients,usertype');
		$this->db->select('patients.*,usertype.user_type');
		$this->db->from('patients');
	    $this->db->join('usertype', 'patients.user_type = usertype.id', 'inner'); 
		$this->db->where('patients.user_type',1);
		$this->db->or_where('patients.user_type',2);
		$this->db->order_by('patients.id', 'DESC');
		return $team_patients = $this->db->get()->result_array();	
		//echo $this->db->last_query(); exit;		
	} // End - get_all_default_team_patients():
	
	// Start Function search_doctor_pharmacist()
	public function search_doctor_pharmacist($data){
		
		extract($data);
		//$where = "(first_name LIKE '%$search%' || last_name LIKE '%$search%')";
		$this->db->dbprefix('patients');
		$this->db->select('patients.first_name, patients.last_name, patients.email_address,patients.user_type,patients.id');
		$this->db->from('patients');
		$this->db->where('user_type',$usertype);
		$this->db->where("(patients.email_address LIKE '%$search%' OR patients.first_name LIKE '%$search%' OR patients.last_name LIKE '%$search%')");
		$this->db->order_by('id', 'DESC');
		return $team_patients = $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
	}// End search_doctor_pharmacist();
	
	// Start Function add_update_default_user();
	public function add_update_default_user($data){
		
		extract($data);
		
		if($user_type_btn=='1'){
			$email_address = $this->db->escape_str(trim($is_default_doc));
		} else if($user_type_btn=='2'){
		   $email_address = $this->db->escape_str(trim($is_default_pharm));
		}
		
		if($email_address!="") {
			
			$this->db->dbprefix('patients');
			$this->db->select('email_address');
			$this->db->where('user_type',$user_type_btn);
			$this->db->where('email_address',$email_address);
			$this->db->from('patients');
			$user_email = $this->db->get()->row_array();
			
			// check email exist or not
			if($user_email['email_address']!="") {
			$this->db->dbprefix('patients');
			$this->db->select('id,is_default');
			$this->db->where('user_type',$user_type_btn);
			$this->db->where('is_default',1);
			$this->db->from('patients');
			$team_patients = $this->db->get()->row_array();
			
			$id = $team_patients['id'];
			$ins_data['is_default'] = '0';
			
			$this->db->dbprefix('patients');
			$this->db->where('user_type',$user_type_btn);
			$this->db->where('id',$id);
			$this->db->update('patients',$ins_data);
		
			$ins_data['is_default'] = '1';
			
			$this->db->dbprefix('patients');
			$this->db->where('email_address',$email_address);
			$this->db->where('user_type',$user_type_btn);
			$success = $this->db->update('patients',$ins_data);
		} // End if($user_email['email_address']!=""
	 } // End if($email_address!="")
			
		if($success)
			return true;
		else 
			return false;		

	}// End Function add_update_default_user();
	
	//Function get_patient_order_list(): Fetch the get_patient_order_list details from Patients and patient_orders table using Patient ID
	public function get_patient_order_list($patient_id){
		
		$this->db->dbprefix('patient_orders');
		$this->db->select('patient_orders.*');
		$this->db->from('patient_orders');
		$this->db->where('patient_orders.patient_id',$patient_id);
		$this->db->order_by('patient_orders.id','DESC');
		$get_orders= $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
		if($get_orders)
			return $get_orders;
		else
			return false;
		
	}//end get_patient_order_list()
	
	// Function get_patient_order_detail_list($patient_id, orders_details_id);
	public function get_patient_order_detail_list($patient_id,$order_id){
		
	 	$this->db->dbprefix('patient_order_details,patient_orders,medicine,org_pharmacy_surgery,medicine_strength,medicine_quantity');
	 	$this->db->select('patient_order_details.*,patient_orders.shipping_cost,org_pharmacy_surgery.pharmacy_surgery_name,medicine.medicine_name,medicine.id AS MID,medicine_strength.strength,medicine_quantity.quantity');
	 	$this->db->from('patient_order_details');
	
	 	$this->db->join('patient_orders','patient_order_details.order_id=patient_orders.id','INNER');
	 	$this->db->join('medicine','patient_order_details.medicine_id=medicine.id','INNER');
	 	$this->db->join('medicine_strength','patient_order_details.strength_id=medicine_strength.id','INNER');
	 	$this->db->join('medicine_quantity','patient_order_details.qty_id=medicine_quantity.id','INNER');
	 	$this->db->join('org_pharmacy_surgery','patient_order_details.pharmacy_surgery_id=org_pharmacy_surgery.id','INNER');
	 		
	 	$this->db->where('patient_order_details.order_id',$order_id);
	 	$this->db->where('patient_order_details.patient_id',$patient_id);
	
		$get_orders= $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
	
		if($get_orders)
			return $get_orders;
		else
			return false;
		//echo $this->db->last_query(); exit;
	
	} // end get_patient_order_detail_list
	public function get_patient_purchase_details($purchase_id){
		
		$this->db->dbprefix('patient_order_details');
		$this->db->where('patient_order_details.id',$purchase_id);
		
		$get = $this->db->get('patient_order_details');
		
		//echo $this->db->last_query(); exit;
		return $get->row_array();

	}//end get_patient_purchase_details($patient_id, $purchase_id = '')

	
	//Function patient_order_details(): Fetch the patient_order_details by ID
	public function patient_order_details($patient_id,$order_detail_id){
		
		 $this->db->dbprefix('patients,patient_orders');
		 $this->db->select('patients.*,patient_orders.purchase_date,patient_orders.transaction_id,patient_orders.order_type,patient_orders.inform_gp');
		 $this->db->from('patients');
		 $this->db->join('patient_orders','patient_orders.patient_id=patients.id','INNER');
		 $this->db->where('patients.id',$patient_id);
		 $this->db->where('patient_orders.id',$order_detail_id);
		 $patient_details= $this->db->get()->row_array();
		//echo $this->db->last_query(); exit;
		
		if($patient_details)
			return $patient_details;
		else
			return false;
		
	}//end patient_order_details()
	
	// Function get_patient_vaccine_order_detail_list($patient_id, order_id);
	public function get_patient_vaccine_order_detail_list($patient_id,$order_id){
		
		 $this->db->dbprefix('patient_order_details,patient_orders,medicine,org_pharmacy_surgery,medicine_strength,medicine_quantity');
		 $this->db->select('patient_order_details.*,patient_orders.shipping_cost,org_pharmacy_surgery.pharmacy_surgery_name');
		 $this->db->from('patient_order_details');
		 $this->db->join('patient_orders','patient_order_details.order_id=patient_orders.id','INNER');
		 $this->db->join('org_pharmacy_surgery','patient_order_details.pharmacy_surgery_id=org_pharmacy_surgery.id','INNER');
		
		/*$this->db->join('medicine','patient_order_details.medicine_id=medicine.id','LEFT');
		 $this->db->join('medicine_strength','patient_order_details.strength_id=medicine_strength.id','LEFT');
		 $this->db->join('medicine_quantity','patient_order_details.qty_id=medicine_quantity.id','LEFT');*/
		
		 $this->db->where('patient_order_details.order_id',$order_id);
		 $this->db->where('patient_order_details.patient_id',$patient_id);
		 $this->db->where('patient_order_details.vaccine_id IS NOT NULL');
		
		 $get_orders= $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
		if($get_orders)
			return $get_orders;
		else
			return false;
		//echo $this->db->last_query(); exit;
	
	} // end get_patient_vaccine_order_detail_list
		
	//Function get_patients_orders_list(): Fetch the get_patients_orders_list details from Patients and patient_orders table using Patient ID
	public function get_patients_orders_list(){
		
		$this->db->dbprefix('patient_orders,patients');
		$this->db->select('patient_orders.*,patients.first_name,patients.last_name');
		$this->db->from('patient_orders');
		$this->db->join('patients','patient_orders.patient_id=patients.id','INNER');
		$this->db->order_by('patient_orders.id','DESC');
		$get_orders= $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
		if($get_orders)
			return $get_orders;
		else
			return false;
		
	}//end get_patients_orders_list()
	
		// Function get_patient_order_detail_list_default_prescriber_not_set;
	public function get_patient_order_detail_list_default_prescriber_not_set(){
		
	 	$this->db->dbprefix('patient_order_details, patient_orders, organization, medicine, org_pharmacy_surgery, medicine_strength, medicine_quantity');
	 	$this->db->select('patient_order_details.*,
						patient_orders.shipping_cost, 
						org_pharmacy_surgery.pharmacy_surgery_name, 
						medicine.medicine_name,medicine.id AS MID, 
						medicine_strength.strength, 
						medicine_quantity.quantity');
	 	$this->db->from('patient_order_details');
	
	 	$this->db->join('patient_orders','patient_order_details.order_id=patient_orders.id','LEFT');
	 	$this->db->join('medicine','patient_order_details.medicine_id=medicine.id','LEFT');
	 	$this->db->join('medicine_strength','patient_order_details.strength_id=medicine_strength.id','LEFT');
	 	$this->db->join('medicine_quantity','patient_order_details.qty_id=medicine_quantity.id','LEFT');
	 	$this->db->join('org_pharmacy_surgery','patient_order_details.pharmacy_surgery_id=org_pharmacy_surgery.id','LEFT');
		$this->db->join('organization','organization.id=patient_order_details.organization_id','LEFT');
	    
		$this->db->where('organization.default_prescriber IS NULL');
		$this->db->where('patient_order_details.order_status', 'P');
	 	
		$this->db->order_by('patient_order_details.id', 'DESC');
	
		$get_orders= $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
	
		if($get_orders)
			return $get_orders;
		else
			return false;
		//echo $this->db->last_query(); exit;
	
	} // end get_patient_order_detail_list_default_prescriber_not_set
	
	//get_defualt_prescriber_prescribed_orders(): This function will return all those patients who were prescribed by the default/ System prescriber. This functio is intially used in User Audit
	public function get_default_prescriber_prescribed_patients(){
		
		$this->db->dbprefix('patient_order_details');
		$this->db->select('patient_order_details.*, 
						patients.first_name, patients.last_name, patients.email_address, patients.dob, patients.mobile_no, patients.address, patients.address_2, patients.address_3, patients.postcode,
						patient_orders.transaction_id, patient_orders.auth_code');
		
		$this->db->from('patient_order_details');
		
		$this->db->join('patient_orders','patient_order_details.order_id = patient_orders.id','LEFT');
		$this->db->join('patients','patient_order_details.patient_id = patients.id','LEFT');

		$this->db->where('patient_order_details.default_prescriber' , '1');
		$this->db->where('patient_order_details.order_type' , 'ONLINE');
		
		$this->db->order_by('patient_order_details.id', 'DESC');

		$get_orders = $this->db->get();
		$result = $get_orders->result_array();
		//echo $this->db->last_query(); exit;
		
		return $result;
		
		
	}//end get_defualt_prescriber_prescribed_patients()
	
	public function get_organization_transactions($limit ='', $start ='',$organization_id ='', $pharmacy_surgery_id = '', $patient_id = '', $order_status = '', $medicine_class = '', $product_type = '', $order_type = '', $data = ''){
		
		//echo $start;
		//exit;
		
		if($data!='')
		{
			extract($data);
		}
		
		 $where = "";
		 $where1  = "";
		 if($search_patient_email != ''){

			$where1 = "kod_patients.email_address = '".filter_string($search_patient_email)."'";
		 }
		 
		 if($date_search!="" && $date_search=='week'){
			
			 $where = 'kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)';
			
		} else if($date_search!="" && $date_search=='month'){
			
			 $where = 'kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)';
			 
		} else if($date_search!="" && $date_search=='three_month'){
			
			 $where = 'kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 3 MONTH)';
			 
		} else if($date_search!="" && $date_search=='six_month'){
			
			 $where = 'kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 6 MONTH)';
			 
		} else if($date_search!="" && $date_search=='year'){
			
			 $where = 'kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)';
		}
		
		//if($to_date)

		$this->db->dbprefix('patient_order_details');
		$this->db->select('patient_order_details.*, 
						medicine.medicine_name, CONCAT(brand_name," ",medicine_name) as medicine_full_name, 
						org_pharmacy_surgery.pharmacy_surgery_name,
						org_pharmacy_surgery.postcode, 
						CONCAT (first_name," ", last_name) AS patient_name,patients.pmr_no, 
						patient_orders.grand_total, 
						medicine_quantity.quantity_txt, medicine_strength.strength, medicine_form.medicine_form');
		
		$this->db->join('medicine','medicine.id = patient_order_details.medicine_id ','LEFT'); //Medicine
		$this->db->join('medicine_quantity','medicine_quantity.id = patient_order_details.qty_id ','LEFT'); //Medicine Quantity
		$this->db->join('medicine_strength','medicine_strength.id = patient_order_details.strength_id ','LEFT'); //Medicine Strength
		$this->db->join('medicine_form','medicine_form.id = medicine.medicine_form_id ','LEFT'); //Medicine Form
		
		$this->db->join('org_pharmacy_surgery','org_pharmacy_surgery.id = patient_order_details.pharmacy_surgery_id ','LEFT'); //Pharmacy Join
		$this->db->join('patients','patients.id = patient_order_details.patient_id ','LEFT'); //Patient Join
		$this->db->join('patient_orders','patient_orders.id = patient_order_details.order_id ','LEFT'); //Patient Join
		$this->db->join('organization','organization.id = patient_order_details.organization_id ','LEFT'); //Patient Join
		
		
		if(trim($order_status) != '' && trim($order_status) == 'P') $this->db->where('patient_order_details.order_status',$order_status);
		if(trim($order_status) != '' && trim($order_status) == 'C') $this->db->where('patient_order_details.default_prescriber','1');
		if(trim($medicine_class) != '') $this->db->where('patient_order_details.medicine_class',$medicine_class);  //Both
		
		if(trim($search_patient_email) != '') $this->db->where($where1);
		
		if(trim($from_date) != '' && trim($to_date)!="") $this->db->where('(kod_patient_order_details.created_date BETWEEN "'. date('Y-m-d', strtotime($from_date)). '" AND "'. date('Y-m-d', strtotime($to_date)).'" OR date(kod_patient_order_details.created_date) = "'.$to_date.'" OR date(kod_patient_order_details.created_date) = "'.$from_date.'" )');
		else if(trim($from_date) != '')  $this->db->where('date(kod_patient_order_details.created_date)',$from_date);
		else if(trim($to_date) != '') $this->db->where('date(kod_patient_order_details.created_date)',$to_date);
		else if(trim($date_search) != '') $this->db->where($where);
		
				
		//$this->db->where('date(kod_patient_order_details.created_date)',$to_date,FALSE);
		
		//if(trim($organization_id)!='') $this->db->where('patient_order_details.organization_id',$organization_id);
	    
		if(trim($pharmacy_surgery_id)!='') {
			$this->db->where('patient_order_details.pharmacy_surgery_id',$pharmacy_surgery_id);  //Pharmacy Surgery ID
			$this->db->where('org_pharmacy_surgery.is_deleted','0'); 
		}//end if(trim($pharmacy_surgery_id)!='') 

		if(trim($patient_id)!='') $this->db->where('patient_order_details.patient_id',$patient_id); //Patient Id
		if(trim($product_type) != '') $this->db->where('patient_order_details.product_type',$product_type);  //Product Type
		if(trim($order_type) != '') $this->db->where('patient_order_details.order_type',$order_type);  //Order type
		
		$this->db->where('org_pharmacy_surgery.is_deleted','0');
		
		$this->db->where('organization.default_prescriber IS NULL'); //Default user should only see the transactions whose default presciber is not defined in an organisation
		//$this->db->where('organization.default_prescriber IS NULL'); 
		$this->db->order_by('patient_order_details.created_date','DESC');
		
		$this->db->limit($limit, $start);
		
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
	
	// Get Patietn data and country
	public function get_patient_details_country($patient_id){
			
			// Get Patient Record
			$this->db->dbprefix('patients');
			$this->db->select('patients.*,country.country_name');
			$this->db->where('patients.id', $patient_id);
			
			$this->db->join('country', 'country.id = patients.gp_country','LEFT');
			
			return $this->db->get('patients')->row_array();
			
		} // public function get_patient_data($patient_id)	
		
   public function get_patient_grouped_history($patient_id,$order_status = ''){

		$this->db->dbprefix('patient_order_details');
		$this->db->distinct();
		$this->db->select("patients.first_name, patients.last_name, patient_order_details.*, CONCAT(brand_name,' ',medicine_name) AS medicine_name, medicine.id as medicine_id, medicine_form.medicine_form,medicine_quantity.quantity AS online_quantity, medicine_strength.strength, CONCAT(kod_users.first_name,' ',kod_users.last_name) as prescribed_by_name");
		
		//$this->db->where('patient_order_details.patient_id', $patient_id);
		
		if(trim($order_status) != '')  $order_status_str = "AND kod_patient_order_details.order_status = '".$order_status."'";
		
		$this->db->join('medicine','medicine.id = patient_order_details.medicine_id','LEFT');
		$this->db->join('users','patient_order_details.prescribed_by = users.id','INNER');
		$this->db->join('medicine_form','medicine.medicine_form_id = medicine_form.id','LEFT');
		$this->db->join('medicine_strength','patient_order_details.strength_id = medicine_strength.id','LEFT');
		$this->db->join('medicine_quantity','patient_order_details.qty_id = medicine_quantity.id','LEFT');
		$this->db->join('patients','patient_order_details.patient_id = patients.id');
		//$this->db->join('(SELECT id FROM kod_patient_order_details ORDER BY id DESC) as a','patient_order_details.medicine_id = medicine.id','INNER');
		$this->db->where("kod_patient_order_details.id IN (
							SELECT MAX(kod_patient_order_details.id)
							FROM kod_patient_order_details
							WHERE kod_patient_order_details.patient_id = '".$patient_id."'
							$order_status_str
							GROUP BY kod_patient_order_details.medicine_id
						)");
		
		$get = $this->db->get('patient_order_details');
		//echo $this->db->last_query();	exit;
		
		$return = $result_arr = $get->result_array();
		//print_this($return);
		//exit;

		return $return;
		
	}//end get_patient_grouped_history($patient_id,$order_status = '')	
	
	 // Start - public function update_patient_allergies($alleries_text)
	 public function update_patient_allergies($allergies_text, $patient_id){

	 	$this->db->dbprefix('patients');
	 	$this->db->where('id', $patient_id);
	 	
	 	return $this->db->update('patients', array('allergies' => $this->db->escape_str(nl2br(trim($allergies_text))) ));

	 } // public function update_patient_allergies($alleries_text)
	 
	 
	 
	 //Function get_patient_history(): This function will get all the purchase Medicine (Rx, Rx-PGD, PGD) history of the patient grouped by to know what patient have bought previously. 
	//Order_status is optional, if not given will return all records. If given will return th required accoding to the order status defined. Medicine_id is optipons when given will return the record of a patient with specifix medicine!
	// P = Pending, C = Complete, DS = Dispense, DC =  Decline
	public function get_patient_history($patient_id,$order_status = '',$medicine_id = ''){
		
		$this->db->dbprefix('patient_order_details');
		$this->db->select("patient_order_details.*, CONCAT(brand_name,' ',medicine_name) AS medicine_name,medicine_form.medicine_form,medicine_quantity.quantity AS online_quantity, medicine_strength.strength, CONCAT(kod_users.first_name,' ',kod_users.last_name) as prescribed_by_name");
		$this->db->where('patient_order_details.patient_id', $patient_id);
		
		if(trim($order_status) != '')  $this->db->where('patient_order_details.order_status', $order_status);
		if(trim($medicine_id) != '')  $this->db->where('patient_order_details.medicine_id', $medicine_id);
		
		$this->db->join('medicine','medicine.id = patient_order_details.medicine_id','LEFT');
		$this->db->join('medicine_form','medicine.medicine_form_id = medicine_form.id','LEFT');
		$this->db->join('medicine_strength','patient_order_details.strength_id = medicine_strength.id','LEFT');
		$this->db->join('medicine_quantity','patient_order_details.qty_id = medicine_quantity.id','LEFT');
		$this->db->join('users','patient_order_details.prescribed_by = users.id','INNER');
		
		$this->db->order_by('patient_order_details.created_date', 'DESC');
		
		$get = $this->db->get('patient_order_details');
		//echo $this->db->last_query();	exit;
		
		return $get->result_array();
		
	}//end get_patient_history($patient_id,$order_status)
	
		//Function get_patient_order_item_details(): This will return array of products being purchased by the patient.
	public function get_patient_order_item_details($order_item_id){

	$this->db->dbprefix('patient_order_details');
	$this->db->where('id',$order_item_id);
	$get = $this->db->get('patient_order_details');
	//echo $this->db->last_query(); 	 exit;
	$row_arr = $get->row_array();

	return $row_arr;

	}//end get_patient_order_item_details($order_item_id)
	
	
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
    	//$notification_txt = "Prescriber "Dr. Ali Khan" has declined the medicine "Viagra 25mg" for Patient "232 - Haseeb Ur Rehman" against prescription number "PJHJ7987" due to Reason below: "The patient has low blood pressure issues and is not allowed to have this medicine"";

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

		$get_default_prescriber = $this->patient->get_system_default_prescriber();
		
		$prescriber_name = filter_name($get_default_prescriber['first_name']).' '.filter_string($get_default_prescriber['last_name']);
		
    	$notification_txt = 'Prescriber <strong>"'.$prescriber_name.'"</strong> has declined the medicine <strong>"'.$order_details['medicine_name'].' '.$order_details['strength'].'"</strong> for Patient <strong>"'.$order_details['patient_id'].' - '.filter_name($order_details['patient_name']).'"</strong> against prescription number <strong>"'.$order_details['prescription_no'].'"</strong> due to Reason below: <br />"'.$decline_text.'"';

    	// Insert notification
    	$insert_data = array('notification_txt' => $notification_txt, 'created_date' => $date_now, 'created_by_ip' => $this_ip_address);
    	$this->db->dbprefix('admin_notifications');
    	$this->db->insert('admin_notifications', $insert_data);
		

    	// Change order state to (DC - Decline) from (P - Pending)
		$update_data = array('order_status' => 'DC', 'decline_reason' => $decline_text);
    	$this->db->dbprefix('patient_order_details');
    	$this->db->where('id', $order_detail_id);
    	
    	return $this->db->update('patient_order_details', $update_data);

	} // End - public function decline_transaction($post)

	// Start - public function save_prescription($prescription)
	public function save_prescription($pharmacy_surgery_id, $organization_id, $user_id, $prescription){
		
		// extract POST data
		//extract($prescription);
		
		$created_date = date('Y-m-d H:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$prescription_no = $this->generate_prescription_no();
		
		//Inserting Record into the Patient Order Details
		$ins_data = array(
		
			'prescription_no' => $this->db->escape_str(trim($prescription_no)),
			'patient_id' => $this->db->escape_str(trim($prescription['patient_id'])),
			'purchased_by_id' => $this->db->escape_str(trim($user_id)),
			'order_type' => "PMR",
			'purchase_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		

		//Inserting User data into the database. 
		$this->db->dbprefix('patient_orders');
		$ins_into_db = $this->db->insert('patient_orders', $ins_data);
		
		$order_id = $this->db->insert_id();

		foreach($prescription['transaction']['medicine_id'] as $index => $med_id){

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
				'patient_id' => $this->db->escape_str(trim($prescription['patient_id'])),
				'medicine_id' => $this->db->escape_str(trim($med_id)),
				
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'prescribed_by' => $this->db->escape_str(trim($user_id)),
				'quantity' => $prescription['transaction']['qty'][$index],
				'strength_id' => $this->db->escape_str(trim($prescription['transaction']['medicine_strength_id'][$index])),
				'medicine_class' => $this->db->escape_str(trim($prescription['transaction']['medicine_class'][$index])),
				'order_type' => "PMR",
				'order_status' => 'C',
				'suggested_dose' => $this->db->escape_str(trim($prescription['transaction']['suggested_dose'][$index])),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			);
			
			// save prescription : Insert data into db [ Table - patient_order_details ]
			$this->db->dbprefix('patient_order_details');
			$saved = $this->db->insert('patient_order_details', $prescription_data);
			//echo $this->db->last_query(); exit;
			
		} // foreach($medicine_id as $index => $each)
		
		if($saved)
			return true;
		else
			return false;
		//if($saved)
			
	} // public function save_prescription($prescription)
	
	
	// Start - public function mark_transaction_complete($order_id)
	public function mark_transaction_complete($order_id){
		
		$system_default_prescriber = $this->get_system_default_prescriber();

		//$prescriber_organization = $this->organization->get_my_organizations($system_default_prescriber['id']);
		//$prescriber_organization = $prescriber_organization[0];
		
		$upd_arr = array(
						'order_status' => "DS",
						'default_prescriber' => '1',
						'prescribed_by' => $this->db->escape_str(trim($system_default_prescriber['id'])),
						'p_prescriber_name' => $this->db->escape_str(trim(ucwords($system_default_prescriber['first_name'].' '.$system_default_prescriber['last_name']))),
						'p_prescriber_reg_no' => $this->db->escape_str(trim($system_default_prescriber['reg_no'])),
						'p_prescriber_email' => $this->db->escape_str(trim($system_default_prescriber['email_address'])),
						'p_prescriber_contact_no' => $this->db->escape_str(trim($system_default_prescriber['contact_no']))
					);

		$this->db->dbprefix('patient_order_details');
		$this->db->where('id', $order_id);
		
		$update_done = $this->db->update('patient_order_details', $upd_arr);
		
		if($update_done){
			
			$patient_order_item_details = $this->get_patient_order_item_details($order_id);
			$pharmacy_surgery = $this->organization->get_pharmacy_surgery_details($patient_order_item_details['pharmacy_surgery_id']);
			
			if($pharmacy_surgery['manager_id']){
				
				$manager_details = $this->users->get_user_details($pharmacy_surgery['manager_id']);

				$search_arr = array('[MANAGER_NAME]','[MEDICINE_NAME]','[PATIENT_NAME]','[PRESCRIBER_NAME]','[PRESCRIBED_DATE]');
				$replace_arr = array(filter_name($manager_details['first_name'].' '.$manager_details['last_name']), filter_string($patient_order_item_details['p_medicine_name']), filter_name($patient_order_item_details['p_patient_name']),filter_name($patient_order_item_details['p_prescriber_name']).' - '.filter_string($patient_order_item_details['p_prescriber_reg_no']),date('d/m/Y G:i:s')); 
				
				$this->load->model('email_mod','email_template');
				
				$email_body_arr = $this->email_template->get_email_template(27);
				$email_subject = $email_body_arr['email_subject'];
				
				$email_body = $email_body_arr['email_body'];
				$email_body = str_replace($search_arr,$replace_arr,$email_body);
				
				$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
				$noreply_email = get_global_settings($NOREPLY_EMAIL);
				
				$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
				$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
				
				//$email_address = $this->session->email_address;
				
				$from = filter_string($noreply_email['setting_value']);
				$from_name = filter_string($email_from_txt['setting_value']);
				$to = trim($manager_details['email_address']);
				$subject = filter_string($email_subject);
				$email_body = filter_string($email_body);
							
				// Call from Helper send_email function
				$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
				
				return true;
				
			}//end if($pharmacy_surgery['manager_id'])
			
		}//end if($update_done)
		

	} // End - public function mark_transaction_complete($order_id)
	
	
		public function generate_prescription_no(){

		$new_ref_no = strtoupper($this->common->random_number_generator(7));
		
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
	}//end generate_survey_reference_no()
	
	
	//Function download_csv_prescription_statistics(): 
	 public function download_csv_prescription_statistics($organization_id ='', $pharmacy_surgery_id = '', $patient_id = '', $order_status = '', $medicine_class = '', $product_type = '', $order_type = '', $data = ''){
		

		if($data!='')
		{
			extract($data);
		}
		
		 $where = "";
		 $where1  = "";
		 
		 if($csv_patient_name){
			 
			 $where1 = " AND kod_patients.email_address = '".$csv_patient_name."'";
		 }
		
		if(trim($csv_from_date) != '' && trim($csv_to_date)!=""){
			
			 		$where ='AND (kod_patient_order_details.created_date BETWEEN "'. date('Y-m-d', strtotime($csv_from_date)). '" and "'. date('Y-m-d', strtotime($csv_to_date)).'" OR date(kod_patient_order_details.created_date) = "'.$csv_to_date.'" OR date(kod_patient_order_details.created_date) = "'.$csv_from_date.'" )';
			
		} else if(trim($csv_from_date) != ''){
					$where =  "AND date(`kod_patient_order_details`.`created_date`) = '$csv_from_date'";
					
					
		} else if(trim($csv_to_date) != ''){
					$where =  "AND date(`kod_patient_order_details`.`created_date`) = '$csv_to_date'";
		} else { 
		
					if($csv_date_search!="" && $csv_date_search=='week'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)';
					} else if($csv_date_search!="" && $csv_date_search=='month'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)';
					} else if($csv_date_search!="" && $csv_date_search=='three_month'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 3 MONTH)';
					} else if($csv_date_search!="" && $csv_date_search=='six_month'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 6 MONTH)';
					} else if($csv_date_search!="" && $csv_date_search=='year'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)';
					}
		}
		
		 
	   $this->load->dbutil();
	   
		  
		$qry_user_data = $this->db->query("SELECT kod_patient_order_details.created_date AS ORDER_DATE, CONCAT(kod_org_pharmacy_surgery.pharmacy_surgery_name,' ','- ',kod_org_pharmacy_surgery.postcode)  AS PHARMACY_NAME,CONCAT(last_name,' ',first_name)  AS PATIENT_NAME  FROM `kod_patient_order_details`
		
LEFT JOIN `kod_medicine` ON `kod_medicine`.`id` = `kod_patient_order_details`.`medicine_id` 
LEFT JOIN `kod_medicine_quantity` ON `kod_medicine_quantity`.`id` = `kod_patient_order_details`.`qty_id`
LEFT JOIN `kod_medicine_strength` ON `kod_medicine_strength`.`id` = `kod_patient_order_details`.`strength_id`
LEFT JOIN `kod_medicine_form` ON `kod_medicine_form`.`id` = `kod_medicine`.`medicine_form_id`
LEFT JOIN `kod_org_pharmacy_surgery` ON `kod_org_pharmacy_surgery`.`id` = `kod_patient_order_details`.`pharmacy_surgery_id`
LEFT JOIN `kod_patients` ON `kod_patients`.`id` = `kod_patient_order_details`.`patient_id`
LEFT JOIN `kod_patient_orders` ON `kod_patient_orders`.`id` = `kod_patient_order_details`.`order_id`
LEFT JOIN `kod_organization` ON `kod_organization`.`id` = `kod_patient_order_details`.`organization_id`

WHERE kod_patient_order_details.default_prescriber = '1' AND kod_patient_order_details.product_type = 'M' AND kod_org_pharmacy_surgery.is_deleted ='0'  ".$where." ".$where1." ORDER BY kod_patient_order_details.created_date DESC ");

	  for($i=0; $i<count($count_all_record); $i++){
		  
		$final_arr[$i]['created_date']= $count_all_record[$i]['created_date'];
		$final_arr[$i]['pharmacy_surgery_name']= $count_all_record[$i]['pharmacy_surgery_name'].$count_all_record[$i]['postcode'];
		$final_arr[$i]['first_name']= $count_all_record[$i]['first_name'].$count_all_record[$i]['last_name'];
		
		
	  }//end for($i=0; $i<count($count_all_record); $i++)
	  
		$delimiter = ",";
		$newline = "\r\n";
		
		$download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);
		
		return $download_csv;
	  
 	}//end  download_csv_prescription_statistics()')
	
	
	///Function download_csv_prescription_stattics(): 
	 public function download_csv_pharamcy_statistics($organization_id ='', $pharmacy_surgery_id = '', $patient_id = '', $order_status = '', $medicine_class = '', $product_type = '', $order_type = '', $data = ''){
		

		if($data!='')
		{
			extract($data);
		}
				
		 $where = "";
		 $where1  = "";
		 
		 if($csv_patient_name){
			 
			 $where1 = " AND kod_patients.email_address = '".$csv_patient_name."'";
		 }
		 
		  if($csv_pharmacy_surgery_id){
			 
			 $where1 = " AND kod_patient_order_details.pharmacy_surgery_id = '".$csv_pharmacy_surgery_id."'";
		 }
		
		
		if(trim($csv_from_date) != '' && trim($csv_to_date)!=""){
			
			 		$where ='AND (kod_patient_order_details.created_date BETWEEN "'. date('Y-m-d', strtotime($csv_from_date)). '" and "'. date('Y-m-d', strtotime($csv_to_date)).'" OR date(kod_patient_order_details.created_date) = "'.$csv_to_date.'" OR date(kod_patient_order_details.created_date) = "'.$csv_from_date.'" )';
			
		} else if(trim($csv_from_date) != ''){
					$where =  "AND date(`kod_patient_order_details`.`created_date`) = '$csv_from_date'";
					
					
		} else if(trim($csv_to_date) != ''){
					$where =  "AND date(`kod_patient_order_details`.`created_date`) = '$csv_to_date'";
		} else { 
		
					if($csv_date_search!="" && $csv_date_search=='week'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)';
					} else if($csv_date_search!="" && $csv_date_search=='month'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)';
					} else if($csv_date_search!="" && $csv_date_search=='three_month'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 3 MONTH)';
					} else if($csv_date_search!="" && $csv_date_search=='six_month'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 6 MONTH)';
					} else if($csv_date_search!="" && $csv_date_search=='year'){
						$where = 'AND kod_patient_order_details.created_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)';
					}
		}
		
		 
	   $this->load->dbutil();
	   
	  
	   $qry_string = "SELECT kod_patient_order_details.created_date AS ORDER_DATE, CONCAT(kod_org_pharmacy_surgery.pharmacy_surgery_name,' ','- ',kod_org_pharmacy_surgery.postcode)  AS PHARMACY_NAME,CONCAT(last_name,' ',first_name)  AS PATIENT_NAME, kod_patient_order_details.subtotal AS MEDICINE_COST, kod_patient_order_details.shipping_cost AS DELIVERY_COST, kod_patient_order_details.prescription_fee AS PRESCRIPTION_FEE  FROM `kod_patient_order_details`
		
LEFT JOIN `kod_medicine` ON `kod_medicine`.`id` = `kod_patient_order_details`.`medicine_id` 
LEFT JOIN `kod_medicine_quantity` ON `kod_medicine_quantity`.`id` = `kod_patient_order_details`.`qty_id`
LEFT JOIN `kod_medicine_strength` ON `kod_medicine_strength`.`id` = `kod_patient_order_details`.`strength_id`
LEFT JOIN `kod_medicine_form` ON `kod_medicine_form`.`id` = `kod_medicine`.`medicine_form_id`
LEFT JOIN `kod_org_pharmacy_surgery` ON `kod_org_pharmacy_surgery`.`id` = `kod_patient_order_details`.`pharmacy_surgery_id`
LEFT JOIN `kod_patients` ON `kod_patients`.`id` = `kod_patient_order_details`.`patient_id`
LEFT JOIN `kod_patient_orders` ON `kod_patient_orders`.`id` = `kod_patient_order_details`.`order_id`
LEFT JOIN `kod_organization` ON `kod_organization`.`id` = `kod_patient_order_details`.`organization_id`

WHERE kod_patient_order_details.default_prescriber = '1' AND kod_patient_order_details.product_type = 'M' AND kod_org_pharmacy_surgery.is_deleted ='0'  ".$where." ".$where1." ORDER BY kod_patient_order_details.created_date DESC ";


		$qry_user_data = $this->db->query($qry_string);
	  
		$delimiter = ",";
		$newline = "\r\n";
		
		$download_csv = $this->dbutil->csv_for_pharmacy_statistics($qry_user_data, $delimiter, $newline);
		
		return $download_csv;
	  
 	}//end  download_csv_prescription_stattics()')
	
	// Start Function search_patient(): Return Patients
	public function search_patient($data){
		
		extract($data);
		
		$search_patient = $this->db->escape_str(trim($search_patient));
		
		$this->db->dbprefix('patients');
		$this->db->select("CONCAT(first_name,' ',last_name,' - ',postcode) as patient_record, id, first_name, last_name, email_address");
		$this->db->from('patients');
		$this->db->where('admin_verify_status',1);
		$this->db->where("CONCAT(first_name,' ',  last_name,' ',postcode) LIKE '%$search_patient%'");
		
		return $this->db->get()->result_array();
		
	} // End - search_patient()
	
	// Start Function search_pharmacy(): Return Pharamacy
	public function search_pharmacy($data){
		
		
		extract($data);
		
		
		//	echo $search_pharmacy; exit;
		$search_pharmacy = $this->db->escape_str(trim($search_pharmacy));
		
		$this->db->dbprefix('org_pharmacy_surgery,organization');
		$this->db->select("CONCAT(pharmacy_surgery_name,' ',' - ',kod_org_pharmacy_surgery.postcode) as pharmacy_record,org_pharmacy_surgery.*,organization.default_prescriber");
		$this->db->from('org_pharmacy_surgery');
    	$this->db->join('organization', ' organization.id = org_pharmacy_surgery.organization_id ');
		$this->db->where('org_pharmacy_surgery.is_deleted','0');
	    $this->db->where('organization.default_prescriber IS NULL');
		$this->db->where("CONCAT(kod_org_pharmacy_surgery.pharmacy_surgery_name,' ',kod_org_pharmacy_surgery.postcode) LIKE '%$search_pharmacy%'");
		
	    return $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
	
	}// end search_pharmacy
		
}//end file
?>