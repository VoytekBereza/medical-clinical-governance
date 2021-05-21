<?php
class Register_entry_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	//Add edit drug
	public function add_edit_drug($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
	
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
				
		if($drug_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'drug_name' => $this->db->escape_str(trim($drug_name)),
				'drug_form' => $this->db->escape_str(trim($drug_form)),
				'drug_strength' => $this->db->escape_str(trim($drug_strength)),
				'opening_balance' => $this->db->escape_str(trim($opening_balance)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting suppliers data into the database. 
			$this->db->dbprefix('drug');
			$ins_into_db = $this->db->insert('drug', $ins_data);
		
			$new_insert_id = $this->db->insert_id();
			
			if($tab_id == 1){			

				$ins_new_data = array(
						
					'created_by' => $this->db->escape_str(trim($user_id)),
					'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
					'drug_id' => $this->db->escape_str(trim($new_insert_id)),
					'stock_in_hand' => $this->db->escape_str(trim($opening_balance)),
					'tab_id' => $this->db->escape_str(trim($tab_id)),
					'created_date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				);
				
				//Inserting register entry data into the database. 
				$this->db->dbprefix('register_entry');
				$ins_into_db = $this->db->insert('register_entry', $ins_new_data);
			
			} else if($tab_id == 2) {
				
				$ins_data = array(
			
			    'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'stock_in_hand' => $this->db->escape_str(trim($opening_balance)),
				'drug_id' => $this->db->escape_str(trim($new_insert_id)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
				//Inserting cd return destruction data into the database. 
				$this->db->dbprefix('kod_cd_return_destruction');
				$ins_into_db = $this->db->insert('kod_cd_return_destruction', $ins_data);
			}
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'drug_name' => $this->db->escape_str(trim($drug_name)),
				'drug_form' => $this->db->escape_str(trim($drug_form)),
				'drug_strength' => $this->db->escape_str(trim($drug_strength)),
				'opening_balance' => $this->db->escape_str(trim($opening_balance)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update suppliers data into the database. 
			$this->db->dbprefix('drug');
			$this->db->where('drug.id', $drug_id);
			$this->db->where('drug.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('drug', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_drug ();
	
	
	//Add edit suppliers
	public function add_edit_suppliers($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		$postcode = str_replace(' ', '', $postcode);
		
		if($supplier_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'supplier_name' => $this->db->escape_str(trim($supplier_name)),
				'address' => $this->db->escape_str(trim($address)),
				'address_2' => $this->db->escape_str(trim($address_2)),
				'address_3' => $this->db->escape_str(trim($address_3)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting suppliers data into the database. 
			$this->db->dbprefix('reg_suppliers');
			$ins_into_db = $this->db->insert('reg_suppliers', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'supplier_name' => $this->db->escape_str(trim($supplier_name)),
				'address' => $this->db->escape_str(trim($address)),
				'address_2' => $this->db->escape_str(trim($address_2)),
				'address_3' => $this->db->escape_str(trim($address_3)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update suppliers data into the database. 
			$this->db->dbprefix('reg_suppliers');
			$this->db->where('reg_suppliers.id', $supplier_id);
			$this->db->where('reg_suppliers.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('reg_suppliers', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_suppliers ();
	
	
	//Add edit prescriber
	public function add_edit_prescriber($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		$postcode = str_replace(' ', '', $postcode);
		
		if($prescriber_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'register_body' => $this->db->escape_str(trim($register_body)),
				'registering_no' => $this->db->escape_str(trim($registering_no)),
				'address' => $this->db->escape_str(trim($address)),
				'address_2' => $this->db->escape_str(trim($address_2)),
				'address_3' => $this->db->escape_str(trim($address_3)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting prescribers data into the database. 
			$this->db->dbprefix('reg_prescribers');
			$ins_into_db = $this->db->insert('reg_prescribers', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'register_body' => $this->db->escape_str(trim($register_body)),
				'registering_no' => $this->db->escape_str(trim($registering_no)),
				'address' => $this->db->escape_str(trim($address)),
				'address_2' => $this->db->escape_str(trim($address_2)),
				'address_3' => $this->db->escape_str(trim($address_3)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update prescribers data into the database. 
			$this->db->dbprefix('reg_prescribers');
			$this->db->where('reg_prescribers.id', $prescriber_id);
			$this->db->where('reg_prescribers.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('reg_prescribers', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_prescriber ();
	
	
	//Add edit patients
	public function add_edit_patients($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		$dob = $birth_year."-".$birth_month."-".$birth_date;
		
		$postcode = str_replace(' ', '', $postcode);
		
		if($patient_id ==""){

			$ins_data = array(
			
			    'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'mobile_no' => $this->db->escape_str(trim($mobile_no)),
				'email_address' => $this->db->escape_str(trim($email_address_patient)),
				'address' => $this->db->escape_str(trim($address)),
				'address_2' => $this->db->escape_str(trim($address_2)),
				'address_3' => $this->db->escape_str(trim($address_3)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'dob' => $this->db->escape_str($dob),
				'gender' => $this->db->escape_str($gender),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting patient data into the database. 
			$this->db->dbprefix('reg_patients');
			$ins_into_db = $this->db->insert('reg_patients', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'mobile_no' => $this->db->escape_str(trim($mobile_no)),
				'email_address' => $this->db->escape_str(trim($email_address_patient)),
				'address' => $this->db->escape_str(trim($address)),
				'address_2' => $this->db->escape_str(trim($address_2)),
				'address_3' => $this->db->escape_str(trim($address_3)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'dob' => $this->db->escape_str($dob),
				'gender' => $this->db->escape_str($gender),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update patient data into the database. 
			$this->db->dbprefix('reg_patients');
			$this->db->where('reg_patients.id', $patient_id);
			$this->db->where('reg_patients.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('reg_patients', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_prescriber ();
	
	
	//Add edit register entry
	public function add_edit_register_entery($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		$postcode = str_replace(' ', '', $postcode);
		
		if($stock_received_supplied =='SS'){
			
			$supplier_id ='';
			$quantity_received = '';
		
		} else {
			
			$quantity_supplied = '';
			$prescriber_id = '';
			$patient_id = '';
			$note = '';
		}//end if($stock_received_supplied =='SS')
		
		if($stock_received_supplied =='SR'){
			
			
			$this->db->dbprefix('register_entry');
			$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
			$this->db->where('tab_id',1);
			$this->db->where('drug_id',$drug_id);
			$this->db->order_by('id', 'Desc');
			$this->db->limit(1);
			
			$row = $this->db->get('register_entry')->row_array();
			
			$stock_in_hand = ($row['stock_in_hand']) + ($quantity_received);
			
		} else {
			
			$this->db->dbprefix('register_entry');
			$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
			$this->db->where('tab_id',1);
			$this->db->where('drug_id',$drug_id);
			$this->db->order_by('id', 'Desc');
			$this->db->limit(1);
			
			$row = $this->db->get('register_entry')->row_array();
			
			$stock_in_hand = ($row['stock_in_hand']) - ($quantity_supplied);
			
		}//end if($stock_received_supplied =='SR')
		
		if($register_entry_id ==""){
			
			if($note)
				$note = date('d/m/Y').'|'.$note.'||';

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'supplier_id' => $this->db->escape_str(trim($supplier_id)),
				'prescriber_id' => $this->db->escape_str(trim($prescriber_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'stock_in_hand' => $this->db->escape_str(trim($stock_in_hand)),
				'stock_received_supplied' => $this->db->escape_str(trim($stock_received_supplied)),
				'quantity_received' => $this->db->escape_str(trim($quantity_received)),
				'quantity_supplied' => $this->db->escape_str(trim($quantity_supplied)),
				'collecting_person_name' => $this->db->escape_str(trim($collecting_person_name)),
				'note' => $this->db->escape_str(trim($note)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
			
			if($stock_received_supplied =='SS'){
				$ins_data['proof_of_id'] = $this->db->escape_str(trim($proof_of_id));
				$ins_data['proof_confirm_id'] = $this->db->escape_str(trim($proof_confirm_id));
				
			}elseif($stock_received_supplied =='SR'){
				
				$ins_data['invoice_no'] = $this->db->escape_str(trim($invoice_no));
				
			}//end if($stock_received_supplied =='SS')
			
			//Inserting register entry data into the database. 
			$this->db->dbprefix('register_entry');
			$ins_into_db = $this->db->insert('register_entry', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'supplier_id' => $this->db->escape_str(trim($supplier_id)),
				'prescriber_id' => $this->db->escape_str(trim($prescriber_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'stock_received_supplied' => $this->db->escape_str(trim($stock_received_supplied)),
				'quantity_received' => $this->db->escape_str(trim($quantity_received)),
				'quantity_supplied' => $this->db->escape_str(trim($quantity_supplied)),
				'proof_of_id' => $this->db->escape_str(trim($proof_of_id)),
				'collecting_person_name' => $this->db->escape_str(trim($collecting_person_name)),
				'note' => $this->db->escape_str(trim($note)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			if($stock_received_supplied =='SR'){
				$ins_data['invoice_no'] = $this->db->escape_str(trim($invoice_no));
			}//end if($stock_received_supplied =='SS')
						
			//Update register entry data into the database. 
			$this->db->dbprefix('register_entry');
			$this->db->where('register_entry.id', $register_entry_id);
			$this->db->where('register_entry.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('register_entry', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_register_entery();
	
	
	public function list_all_drug($user_id, $tab_id,$pharmacy_surgery_id) {
		
		if($tab_id ==''){
			$tab_id = 1;
		}
		
		$this->db->dbprefix('drug');
		$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		if($tab_id != '') $this->db->where('tab_id',$tab_id);
		$this->db->order_by('drug_name', 'ASC');
		return $this->db->get('drug')->result_array();
		//echo $this->db->last_query(); exit;	
		
	}// end list_patient
	
	
	public function list_all_drug_tab_2($user_id, $tab_id,$pharmacy_surgery_id) {
		
	$this->db->dbprefix('drug');
	$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
	$this->db->where('tab_id',2);
	$this->db->order_by('drug_name', 'ASC');
	return $this->db->get('drug')->result_array();
	//echo $this->db->last_query(); exit;	
	}// end list_patient
	
	// Get all supplier 
	public function list_supplier($user_id,$pharmacy_surgery_id) {
		
	$this->db->dbprefix('reg_suppliers');
	$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
	$this->db->order_by('id', 'Desc');
	return $this->db->get('reg_suppliers')->result_array();
		
	}// end list_supplier
	
	
		// Get all witness 
	public function list_witness($user_id,$pharmacy_surgery_id) {
		
	$this->db->dbprefix('witness');
	$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
	$this->db->where('tab_id',2);
	$this->db->order_by('id', 'Desc');
	return $this->db->get('witness')->result_array();
		
	}// end list_supplier
	
	// Get all prescriber
	public function list_prescriber($user_id,$pharmacy_surgery_id) {
		
	$this->db->dbprefix('reg_prescribers');
	$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
	$this->db->order_by('id', 'Desc');
	return $this->db->get('reg_prescribers')->result_array();
		
	}// end list_prescriber
	
	
	public function list_patient($user_id,$pharmacy_surgery_id) {
		
	$this->db->dbprefix('reg_patients');
	$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
	$this->db->order_by('id', 'Desc');
	return $this->db->get('reg_patients')->result_array();
		
	}// end list_patient
	
	public function get_drug_last_id($user_id,$pharmacy_surgery_id) {
		
	$this->db->dbprefix('drug');
	$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
	$this->db->where('tab_id',1);
	$this->db->order_by('id', 'Desc');
	return $this->db->get('drug')->row_array();
	//echo $this->db->last_query(); exit;
		
	}// end list_patient
	
	
	public function get_drug_cd_return_last_id($user_id,$pharmacy_surgery_id) {
		
	$this->db->dbprefix('drug');
	$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
	$this->db->where('tab_id',2);
	$this->db->order_by('id', 'Desc');
	return $this->db->get('drug')->row_array();
	//echo $this->db->last_query(); exit;
		
	}// end list_patient
	
	
	public function get_register_entry($pharmacy_surgery_id, $drug_id = '', $entry_id = ''){
		
		$this->db->dbprefix('register_entry');
		$this->db->select('register_entry.*,
							reg_suppliers.supplier_name, reg_suppliers.address as sup_address,
							reg_prescribers.first_name as presc_first_name,reg_prescribers.last_name as presc_last_name,
							reg_patients.first_name as patient_first_name,reg_patients.last_name as patient_last_name
							');
		
		$this->db->where('register_entry.pharmacy_surgery_id',$pharmacy_surgery_id);

		$this->db->join('reg_suppliers', 'register_entry.supplier_id = reg_suppliers.id','LEFT');
		$this->db->join('reg_prescribers', 'register_entry.prescriber_id = reg_prescribers.id','LEFT');
		$this->db->join('reg_patients', 'register_entry.patient_id = reg_patients.id','LEFT');

		
		if($drug_id != ''){
			$this->db->where('register_entry.drug_id',$drug_id);
			return $this->db->get('register_entry')->result_array();
		}

		if($entry_id != ''){
			$this->db->where('register_entry.id',$entry_id);
			return $this->db->get('register_entry')->row_array();
		}
		
	}//end get_register_entry($drug_id, $entry_id)
	
	public function list_register_all_entery($user_id,$pharmacy_surgery_id,$drug_id, $limit = '', $page = '', $keyword = '') {
		
		$this->db->dbprefix('register_entry, reg_suppliers, reg_prescribers, reg_patients,users,drug');
		$this->db->select('register_entry.*,
							reg_suppliers.supplier_name, reg_suppliers.address as sup_address,
							reg_prescribers.first_name as presc_first_name,reg_prescribers.last_name as presc_last_name,reg_prescribers.address as presc_address,
							reg_patients.first_name as patient_first_name,reg_patients.last_name as patient_last_name,reg_patients.address as patient_address, 
							users.first_name as fname,users.last_name as lname');
		$this->db->from('register_entry');
		
		$this->db->join('reg_suppliers', 'register_entry.supplier_id = reg_suppliers.id','LEFT');
		$this->db->join('reg_prescribers', 'register_entry.prescriber_id = reg_prescribers.id','LEFT');
		$this->db->join('reg_patients', 'register_entry.patient_id = reg_patients.id','LEFT');
		$this->db->join('users', 'register_entry.created_by = users.id','LEFT');
		
		if($drug_id !='') $this->db->where('register_entry.drug_id',$drug_id);
		$this->db->where('register_entry.pharmacy_surgery_id',$pharmacy_surgery_id);
		
		if($keyword != ''){
			
			$this->db->where("(
								(kod_reg_suppliers.supplier_name LIKE '%".$keyword."%') OR
								(CONCAT(kod_reg_prescribers.first_name,' ',kod_reg_prescribers.last_name) LIKE '%".$keyword."%') OR

								(kod_reg_prescribers.first_name LIKE '%".$keyword."%') OR
								(kod_reg_prescribers.last_name LIKE '%".$keyword."%') OR
								
								(CONCAT(kod_reg_patients.first_name,' ',kod_reg_patients.last_name) LIKE '%".$keyword."%') OR
								(kod_reg_patients.first_name LIKE '%".$keyword."%') OR
								(kod_reg_patients.last_name LIKE '%".$keyword."%') OR

								(CONCAT(kod_users.first_name,' ',kod_users.last_name) LIKE '%".$keyword."%') OR
								(kod_users.first_name LIKE '%".$keyword."%') OR
								(kod_users.last_name LIKE '%".$keyword."%')
								)
							");
		}//end if($keyword != '')
		
		$this->db->order_by('register_entry.id', 'ASC');
		
		if(trim($limit)!= '') $this->db->limit($limit, $page);
		
		$get = $this->db->get();
		
		//echo $this->db->last_query().'<br> <hr><br>' ;
		
		return $get->result_array();
		
	}// end list_patient
	
	// Drug last insert record
	public function get_drug_balance($tab_id, $drug_id, $pharmacy_surgery_id) {
		
		/*$this->db->dbprefix('drug');
		$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->where('id',$drug_id);
		$this->db->order_by('id', 'Desc');
	    return $this->db->get('drug')->row_array();*/
		
		if($tab_id == 1) {
		
			$this->db->dbprefix('register_entry,drug');
			$this->db->select('register_entry.*,drug.id as drug_id,  drug.drug_name,drug.drug_form,drug.drug_strength');
			$this->db->from('register_entry');
					
			$this->db->join('drug', 'register_entry.drug_id = drug.id','LEFT');
			
			$this->db->where('register_entry.pharmacy_surgery_id',$pharmacy_surgery_id);
			$this->db->where('register_entry.drug_id',$drug_id);
			
			$this->db->order_by('register_entry.id', 'Desc');
		
		} else if($tab_id == 2){
			
			$this->db->dbprefix('cd_return_destruction,drug');
			$this->db->select('cd_return_destruction.*,drug.id as drug_id,  drug.drug_name,drug.drug_form,drug.drug_strength');
			$this->db->from('cd_return_destruction');
			
			$this->db->join('drug', 'cd_return_destruction.drug_id = drug.id','LEFT');
			
			$this->db->where('cd_return_destruction.pharmacy_surgery_id',$pharmacy_surgery_id);
			$this->db->where('cd_return_destruction.drug_id',$drug_id);
			
			$this->db->order_by('cd_return_destruction.id', 'Desc');
			
		}
			
		return $this->db->get()->row_array();
		//echo $this->db->last_query(); exit;
		
	}// end list_patient
	
	
	public function update_drug_balance($user_id, $pharmacy_surgery_id, $post) {
		
		extract($post);	
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'stock_in_hand' => $this->db->escape_str(trim($opening_balance)),
				'reason'   => $this->db->escape_str(trim($reason)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);	
					
			//Inserting register entry data into the database. 
			
		if($tab_id == 1) {
						
			$this->db->dbprefix('register_entry');
			$ins_into_db = $this->db->insert('register_entry', $ins_data);
		
		} else if($tab_id == 2){
			
			$this->db->dbprefix('cd_return_destruction');
			$ins_into_db = $this->db->insert('cd_return_destruction', $ins_data);
			
		}
				
		if($ins_into_db)
			return true;
		else
			return false;
		
	}// end update_drug_balance
	
	//Add edit drug
	public function add_edit_pom_private_entry($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
				
		if($pom_private_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'prescriber_id' => $this->db->escape_str(trim($prescriber_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'patient_cost' => $this->db->escape_str(trim($patient_cost)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting suppliers data into the database. 
			$this->db->dbprefix('reg_pom_private_entry');
			$ins_into_db = $this->db->insert('reg_pom_private_entry', $ins_data);
			
		
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'prescriber_id' => $this->db->escape_str(trim($prescriber_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'patient_cost' => $this->db->escape_str(trim($patient_cost)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update suppliers data into the database. 
			$this->db->dbprefix('reg_pom_private_entry');
			$this->db->where('reg_pom_private_entry.id', $pom_private_id);
			$this->db->where('reg_pom_private_entry.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('reg_pom_private_entry', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_drug ();
	
	
	public function list_all_pom_private_entry($user_id,$pharmacy_surgery_id, $limit = '', $page = '') {
		
		$this->db->dbprefix('reg_pom_private_entry, reg_prescribers, reg_patients,users,drug');
		$this->db->select('reg_pom_private_entry.*,reg_prescribers.first_name as presc_first_name,reg_prescribers.last_name as presc_last_name,reg_prescribers.address as presc_address,reg_patients.first_name as patient_first_name,reg_patients.last_name as patient_last_name,reg_patients.address as patient_address, users.first_name as fname,users.last_name as lname,drug.drug_name, drug.drug_form,drug.drug_strength,drug.opening_balance');
		$this->db->from('reg_pom_private_entry');
		
		$this->db->join('reg_prescribers', 'reg_pom_private_entry.prescriber_id = reg_prescribers.id','LEFT');
		$this->db->join('reg_patients', 'reg_pom_private_entry.patient_id = reg_patients.id','LEFT');
		$this->db->join('users', 'reg_pom_private_entry.created_by = users.id','LEFT');
		$this->db->join('drug', 'reg_pom_private_entry.drug_id = drug.id','LEFT');
		
		$this->db->where('reg_pom_private_entry.pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->where('reg_pom_private_entry.tab_id',3);
		$this->db->order_by('reg_pom_private_entry.id', 'Desc');
		
		if(trim($limit)!= '') $this->db->limit($limit, $page);
		
		return $this->db->get()->result_array();
		
	} // end list_all_pom_private_entry();
	
	
	//Add edit special
	public function add_edit_special($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
				
		if($special_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting suppliers data into the database. 
			$this->db->dbprefix('reg_special');
			$ins_into_db = $this->db->insert('reg_special', $ins_data);
			
		
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update special data into the database. 
			$this->db->dbprefix('reg_special');
			$this->db->where('reg_special.id', $special_id);
			$this->db->where('reg_special.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('reg_special', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_specialy ();
	
	
	public function list_all_special($user_id,$pharmacy_surgery_id, $limit = '', $page = '') {
		
		$this->db->dbprefix('reg_special, reg_prescribers, reg_patients,users,drug');
		$this->db->select('reg_special.*,reg_patients.first_name as patient_first_name,reg_patients.last_name as patient_last_name,reg_patients.address as patient_address, users.first_name as fname,users.last_name as lname,drug.drug_name, drug.drug_form,drug.drug_strength,drug.opening_balance');
		$this->db->from('reg_special');
		
		$this->db->join('reg_patients', 'reg_special.patient_id = reg_patients.id','LEFT');
		$this->db->join('users', 'reg_special.created_by = users.id','LEFT');
		$this->db->join('drug', 'reg_special.drug_id = drug.id','LEFT');
		
		$this->db->where('reg_special.pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->where('reg_special.tab_id',4);
		$this->db->order_by('reg_special.id', 'Desc');
	
		if(trim($limit)!= '') $this->db->limit($limit, $page);
		return $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;	
	
	} // end list_all_specialy();
	
	//Add edit emergency supply
	public function add_edit_emergency_supply($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
				
		if($emergency_supply_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'cost_patient' => $this->db->escape_str(trim($cost_patient)),
				'reason_supply' => $this->db->escape_str(trim($reason_supply)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting suppliers data into the database. 
			$this->db->dbprefix('reg_emergency_supply');
			$ins_into_db = $this->db->insert('reg_emergency_supply', $ins_data);
			
		
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'reason_supply' => $this->db->escape_str(trim($reason_supply)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update special data into the database. 
			$this->db->dbprefix('reg_emergency_supply');
			$this->db->where('reg_emergency_supply.id', $emergency_supply_id);
			$this->db->where('reg_emergency_supply.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('reg_emergency_supply', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_emergency_supply ();
	
	
	//Add edit witness
	public function add_edit_witness($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		$postcode = str_replace(' ', '', $postcode);
		
		if($witness_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'mobile_no' => $this->db->escape_str(trim($mobile_no)),
				'address' => $this->db->escape_str(trim($address)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting witness data into the database. 
			$this->db->dbprefix('witness');
			$ins_into_db = $this->db->insert('witness', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'mobile_no' => $this->db->escape_str(trim($mobile_no)),
				'address' => $this->db->escape_str(trim($address)),
				'postcode' => $this->db->escape_str(trim($postcode)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update prescribers data into the database. 
			$this->db->dbprefix('witness');
			$this->db->where('witness.id', $witness_id);
			$this->db->where('witness.pharmacy_surgery_id', $pharmacy_surgery_id);
			$ins_into_db = $this->db->update('witness', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_witness ();
	
	
	public function list_all_emergency_supply($user_id,$pharmacy_surgery_id,  $limit = '', $page = ''){
		
		$this->db->dbprefix('reg_emergency_supply, reg_prescribers, reg_patients,users,drug');
		$this->db->select('reg_emergency_supply.*,reg_patients.first_name as patient_first_name,reg_patients.last_name as patient_last_name,reg_patients.address as patient_address, users.first_name as fname,users.last_name as lname,drug.drug_name, drug.drug_form,drug.drug_strength,drug.opening_balance');
		$this->db->from('reg_emergency_supply');
		
		$this->db->join('reg_patients', 'reg_emergency_supply.patient_id = reg_patients.id','LEFT');
		$this->db->join('users', 'reg_emergency_supply.created_by = users.id','LEFT');
		$this->db->join('drug', 'reg_emergency_supply.drug_id = drug.id','LEFT');
		
		$this->db->where('reg_emergency_supply.pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->where('reg_emergency_supply.tab_id',5);
		$this->db->order_by('reg_emergency_supply.id', 'Desc');
		
		if(trim($limit)!= '') $this->db->limit($limit, $page);
		
		return $this->db->get()->result_array();
	
		//echo $this->db->last_query(); exit;	
	
	} // end list_all_emergency_supply();
	
    public function get_supply_reason_details($id, $pharmacy_surgery_id){
		// Get Clinical Diary Record
		$this->db->dbprefix('reg_emergency_supply');
		$this->db->select('reg_emergency_supply.*');
		$this->db->where('reg_emergency_supply.id',$id);
		$this->db->where('reg_emergency_supply.pharmacy_surgery_id',$pharmacy_surgery_id);
		$get = $this->db->get('reg_emergency_supply');
		return $get->row_array();
		//echo $this->db->last_query(); exit;
	}//
	
	
	//Add edit cd return
	public function add_edit_cd_return($user_id, $pharmacy_surgery_id, $post){
		
		extract($post);		
	
		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		
		
		if($stock_return_destruction =='cd_return'){
			
			$witness_id = '';
			$destruct_quantity = '';
		
		} else if($stock_return_destruction =='cd_destruction') {
			
			$patient_id = '';
			$person_return_name = '';
			$patient_return_name = '';
			$person_collecting = '';
			$quantity = $destruct_quantity;
		}
		
		if($stock_return_destruction =='cd_return'){
			
			
			$this->db->dbprefix('cd_return_destruction');
			$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
			$this->db->where('tab_id',2);
			$this->db->where('drug_id',$drug_id);
			$this->db->order_by('id', 'Desc');
			$this->db->limit(1);
			
			$row = $this->db->get('cd_return_destruction')->row_array();
			
			$stock_in_hand = ($row['stock_in_hand']) + ($quantity);
			
		} else {
			
			$this->db->dbprefix('cd_return_destruction');
			$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
			$this->db->where('tab_id',2);
			$this->db->where('drug_id',$drug_id);
			$this->db->order_by('id', 'Desc');
			$this->db->limit(1);
			
			$row = $this->db->get('cd_return_destruction')->row_array();
			
			$stock_in_hand = ($row['stock_in_hand']) - ($quantity);
			
			$stock_in_hand = ($stock_in_hand < 0) ? 0 : $stock_in_hand;
			
		}
		

		if($cd_return_id ==""){

			$ins_data = array(
			
			    'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'witness_id' => $this->db->escape_str(trim($witness_id)),
				'stock_return_destruction' => $this->db->escape_str(trim($stock_return_destruction)),
				'person_return_name' => $this->db->escape_str(trim($person_return_name)),
				'patient_return_name' => $this->db->escape_str(trim($patient_return_name)),
				'person_collecting' => $this->db->escape_str(trim($person_collecting)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'stock_in_hand' => $this->db->escape_str(trim($stock_in_hand)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
			);
		
			//Inserting cd return destruction data into the database. 
			$this->db->dbprefix('kod_cd_return_destruction');
			$ins_into_db = $this->db->insert('kod_cd_return_destruction', $ins_data);
			
		} else {
	
			$ins_data = array(
				
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'patient_id' => $this->db->escape_str(trim($patient_id)),
				'witness_id' => $this->db->escape_str(trim($witness_id)),
				'stock_return_destruction' => $this->db->escape_str(trim($stock_return_destruction)),
				'person_return_name' => $this->db->escape_str(trim($person_return_name)),
				'patient_return_name' => $this->db->escape_str(trim($patient_return_name)),
				'person_collecting' => $this->db->escape_str(trim($person_collecting)),
				'quantity' => $this->db->escape_str(trim($quantity)),
				'drug_id' => $this->db->escape_str(trim($drug_id)),
				'tab_id' => $this->db->escape_str(trim($tab_id)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
				'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Update patient data into the database. 
			$this->db->dbprefix('kod_cd_return_destruction');
			$this->db->where('kod_cd_return_destruction.id', $patient_id);
			$this->db->where('kod_cd_return_destruction.pharmacy_surgery_id', $cd_return_id);
			$ins_into_db = $this->db->update('kod_cd_return_destruction', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_cd_return ();
	
	
	
	
	public function list_cd_return($user_id,$pharmacy_surgery_id,$drug_id, $limit = '', $page = '') {
		
		$this->db->dbprefix('cd_return_destruction, reg_suppliers, reg_prescribers, reg_patients,users,drug');
		$this->db->select('cd_return_destruction.*,reg_patients.first_name as patient_first_name,reg_patients.last_name as patient_last_name,reg_patients.address as patient_address, users.first_name as fname,users.last_name as lname,witness.first_name as wfname,witness.last_name as wlname, witness.address as witness_address');
		$this->db->from('cd_return_destruction');
		
		$this->db->join('witness', 'cd_return_destruction.witness_id = witness.id','LEFT');
		$this->db->join('reg_patients', 'cd_return_destruction.patient_id = reg_patients.id','LEFT');
		$this->db->join('users', 'cd_return_destruction.created_by = users.id','LEFT');
		$this->db->join('drug', 'cd_return_destruction.drug_id = drug.id','LEFT');
		
		if($drug_id !='') $this->db->where('drug.id',$drug_id);
		
		$this->db->where('cd_return_destruction.pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->order_by('cd_return_destruction.id', 'Asc');
		
		if(trim($limit)!= '') $this->db->limit($limit, $page);
		
		$get = $this->db->get();
		
		//echo $this->db->last_query().'<br><br>'; 
		
		return $get->result_array();
	
	
		
	}// end list_patient
	
	 public function get_check_balance_reason_details($id, $pharmacy_surgery_id){
		// Get Clinical Diary Record
		$this->db->dbprefix('register_entry');
		$this->db->select('register_entry.*');
		$this->db->where('register_entry.id',$id);
		$this->db->where('register_entry.pharmacy_surgery_id',$pharmacy_surgery_id);
		$get = $this->db->get('register_entry');
		return $get->row_array();
		//echo $this->db->last_query(); exit;
	}//
	
	 public function get_check_balance_cd_reason_details($id, $pharmacy_surgery_id){
		// Get Clinical Diary Record
		$this->db->dbprefix('kod_cd_return_destruction');
		$this->db->select('kod_cd_return_destruction.*');
		$this->db->where('kod_cd_return_destruction.id',$id);
		$this->db->where('kod_cd_return_destruction.pharmacy_surgery_id',$pharmacy_surgery_id);
		$get = $this->db->get('kod_cd_return_destruction');
		return $get->row_array();
		//echo $this->db->last_query(); exit;
	}//
	
	// Start - public function search_patient($search_query, $my_pharmacy_id)
    public function search_patient($search_query, $pharmacy_id){

        $exploded = explode(' ',trim($search_query));

		$qry_str = '';

        if($exploded){

			$qry_str .= (count($exploded) > 1) ? " `last_name` LIKE '".$exploded[0]."%' AND (" : " `last_name` LIKE '".$exploded[0]."%'   ";
			
            for($i=0 ;$i<count($exploded);$i++){
				if($exploded[$i+1] && $exploded[$i+1]!= '')
					$qry_str .= "`first_name` LIKE '".$exploded[$i+1]."%' OR ";
				
            } // foreach($exploded as $word)
			
        } // if($exploded)
		
		$qry_str =  substr($qry_str,0,strlen($qry_str)-3); 
		$qry_str .= (count($exploded) > 1) ? ') AND' : ' AND';
		
		$qry_str = substr($qry_str,0,strlen($qry_str)-3); 
		
		$search_qry = "SELECT * FROM kod_reg_patients WHERE pharmacy_surgery_id = $pharmacy_id  AND $qry_str AND status = '1' "; 
		
		$rs_qry = $this->db->query($search_qry);

		//echo $this->db->last_query(); exit;

		$qry_result = $rs_qry->result_array();

		return $qry_result;


    } // End - public function search_patient($search_query, $pharmacy_id)
	
	
	// Start - public function search_prescriber($search_query)
    public function search_prescriber($search_query, $pharmacy_id){

		$search_query = str_replace(',','',$search_query);
        $exploded = explode(' ',$search_query);
		
		$qry_str = '';  

        if($exploded){ 
			
			$qry_str .= (count($exploded) > 1) ? " `last_name` LIKE '".$exploded[0]."%' AND (" : " `last_name` LIKE '".$exploded[0]."%'   ";
			
            for($i=0 ;$i<count($exploded);$i++){
					
				if($exploded[$i+1] && $exploded[$i+1]!= '')
					$qry_str .= "`first_name` LIKE '".$exploded[$i+1]."%' OR ";
					
				/*
				$qry_str .= "
							(`last_name` LIKE '".$word."%' OR
							`first_name` LIKE '".$word."%' OR
							`registration_no` LIKE '".$word."%' OR 
							`postcode` LIKE '".$word."%') AND";
					*/
            } // foreach($exploded as $word)
			
        } // if($exploded)

		$qry_str =  substr($qry_str,0,strlen($qry_str)-3); 
		$qry_str .= (count($exploded) > 1) ? ') AND' : ' AND';

		$qry_str = substr($qry_str,0,strlen($qry_str)-3); 
		
		//$result_arr = $this->db->get('pharmacy_drugs')->result_array();
		$search_qry = "SELECT * FROM kod_reg_prescribers WHERE pharmacy_surgery_id = $pharmacy_id AND $qry_str"; 
		
		$rs_qry = $this->db->query($search_qry);

		$qry_result = $rs_qry->result_array();

		return $qry_result;

    } // End - public  function search_prescriber($search_query, $pharmacy_id)
	
	
	// Start - public function search_supplier($search_query)
    public function search_supplier($search_query, $pharmacy_id){

		$search_query = str_replace(',','',$search_query);
        $exploded = explode(' ',$search_query);
		
		$qry_str = '';  

        if($exploded){ 
			
			$qry_str .= (count($exploded) > 1) ? " `supplier_name` LIKE '".$exploded[0]."%' AND (" : " `supplier_name` LIKE '".$exploded[0]."%'   ";
			
            for($i=0 ;$i<count($exploded);$i++){
					
				if($exploded[$i+1] && $exploded[$i+1]!= '')
					$qry_str .= "`supplier_name` LIKE '".$exploded[$i+1]."%' OR ";
					
				/*
				$qry_str .= "
							(`last_name` LIKE '".$word."%' OR
							`first_name` LIKE '".$word."%' OR
							`registration_no` LIKE '".$word."%' OR 
							`postcode` LIKE '".$word."%') AND";
					*/
            } // foreach($exploded as $word)
			
        } // if($exploded)

		$qry_str =  substr($qry_str,0,strlen($qry_str)-3); 
		$qry_str .= (count($exploded) > 1) ? ') AND' : ' AND';

		$qry_str = substr($qry_str,0,strlen($qry_str)-3); 
		
		//$result_arr = $this->db->get('pharmacy_drugs')->result_array();
		$search_qry = "SELECT * FROM kod_reg_suppliers WHERE pharmacy_surgery_id = $pharmacy_id AND $qry_str"; 
		
		$rs_qry = $this->db->query($search_qry);

		$qry_result = $rs_qry->result_array();

		return $qry_result;

    } // End - public  function search_supplier($search_query, $pharmacy_id)
	
	
	// Start - public function search_witness($search_query)
    public function search_witness($search_query, $pharmacy_id){

		$search_query = str_replace(',','',$search_query);
        $exploded = explode(' ',$search_query);
		
		$qry_str = '';  

        if($exploded){ 
			
			$qry_str .= (count($exploded) > 1) ? " `last_name` LIKE '".$exploded[0]."%' AND (" : " `last_name` LIKE '".$exploded[0]."%'   ";
			
            for($i=0 ;$i<count($exploded);$i++){
					
				if($exploded[$i+1] && $exploded[$i+1]!= '')
					$qry_str .= "`first_name` LIKE '".$exploded[$i+1]."%' OR ";
					
				/*
				$qry_str .= "
							(`last_name` LIKE '".$word."%' OR
							`first_name` LIKE '".$word."%' OR
							`registration_no` LIKE '".$word."%' OR 
							`postcode` LIKE '".$word."%') AND";
					*/
            } // foreach($exploded as $word)
			
        } // if($exploded)

		$qry_str =  substr($qry_str,0,strlen($qry_str)-3); 
		$qry_str .= (count($exploded) > 1) ? ') AND' : ' AND';

		$qry_str = substr($qry_str,0,strlen($qry_str)-3); 
		
		//$result_arr = $this->db->get('pharmacy_drugs')->result_array();
		$search_qry = "SELECT * FROM kod_witness WHERE pharmacy_surgery_id = $pharmacy_id AND $qry_str"; 
		
		$rs_qry = $this->db->query($search_qry);

		$qry_result = $rs_qry->result_array();

		return $qry_result;

    } // End - public  function search_witness($search_query, $pharmacy_id)
	
	
	// Start - public function search_medinice($search_query)
    public function search_medinice($search_query, $tab_id,$pharmacy_id){

		$search_query = str_replace(',','',$search_query);
        $exploded = explode(' ',$search_query);
		
		$qry_str = '';  

        if($exploded){ 
			
			$qry_str .= (count($exploded) > 1) ? " `drug_name` LIKE '".$exploded[0]."%' AND (" : " `drug_name` LIKE '".$exploded[0]."%'   ";
			
            for($i=0 ;$i<count($exploded);$i++){
					
				if($exploded[$i+1] && $exploded[$i+1]!= '')
					$qry_str .= "`drug_name` LIKE '".$exploded[$i+1]."%' OR ";
				
            } // foreach($exploded as $word)
			
        } // if($exploded)

		$qry_str =  substr($qry_str,0,strlen($qry_str)-3); 
		$qry_str .= (count($exploded) > 1) ? ') AND' : ' AND';

		$qry_str = substr($qry_str,0,strlen($qry_str)-3); 
		
		//$result_arr = $this->db->get('pharmacy_drugs')->result_array();
		$search_qry = "SELECT * FROM kod_drug WHERE pharmacy_surgery_id = $pharmacy_id AND $qry_str AND tab_id = $tab_id"; 
		
		$rs_qry = $this->db->query($search_qry);

		$qry_result = $rs_qry->result_array();

		return $qry_result;

    } // End - public  function search_medinice($search_query, $pharmacy_id)
	
	public function update_archieve_registers($user_id, $pharmacy_id, $data){
		
		extract($data);

		$register_arr = array();
		
		if(!is_array($contr_drug_chk))
			$contr_drug_chk = array();
			
		$control_drug_arr = $this->registers_entry->list_all_drug($user_id,'1',$pharmacy_id);
		$cdregister_arr = $this->registers_entry->list_all_drug($user_id,'2',$pharmacy_id);
		
		$register_arr = array_merge($control_drug_arr,$cdregister_arr);
		
		if(count($register_arr) > 0){
			
			for($i=0;$i<count($register_arr);$i++){
				
				if(in_array($register_arr[$i]['id'],$contr_drug_chk))
					$ins_data['status'] = $this->db->escape_str(trim('0'));
				else
					$ins_data['status'] = $this->db->escape_str(trim('1'));
				
				//Update suppliers data into the database. 
				$this->db->dbprefix('drug');
				$this->db->where('drug.id', $register_arr[$i]['id']);
				$this->db->where('drug.pharmacy_surgery_id', $pharmacy_id);
				
				$ins_into_db = $this->db->update('drug', $ins_data);
				
			}//end for($i=0;$i<count($contr_drug_chk);$i++)
			
		}//end 
		
		return true;
		
	}//end update_arhieve_registers($data)
	
	public function adjust_register_entry($pharmacy_id, $entry_id, $data){

		extract($data);

		$created_date = date('Y-m-d G:i:s');
	    $created_by_ip = $this->input->ip_address();
		
		$register_entry = $this->registers_entry->get_register_entry($pharmacy_id, '', $entry_id);
		
		//Get previous entry of the record 
		$qry_prev_entry = "SELECT * FROM `kod_register_entry` WHERE `id` = (SELECT max(`id`) FROM `kod_register_entry` WHERE `id` < '".$entry_id."' AND `pharmacy_surgery_id` = '".$pharmacy_id."' AND drug_id = '".$drug_id."' )";
		
		$get_prev_entry = $this->db->query($qry_prev_entry);
		$row_prev_entry = $get_prev_entry->row_array();
		
		//print_this($row_prev_entry); 		exit;
		
		$prev_stock = $row_prev_entry['stock_in_hand'];
		
		if($register_entry['stock_received_supplied'] == 'SR')
			$new_stock_in_hand = ($prev_stock) + ($quantity_received);
		else
			$new_stock_in_hand = ($prev_stock) - ($quantity_supplied);
			
		//Update the entry
		$ins_data = array(
				
			'supplier_id' => $this->db->escape_str(trim($supplier_id)),
			'prescriber_id' => $this->db->escape_str(trim($prescriber_id)),
			'patient_id' => $this->db->escape_str(trim($patient_id)),
			'drug_id' => $this->db->escape_str(trim($register_entry['drug_id'])),
			'stock_in_hand' => $this->db->escape_str(trim($new_stock_in_hand)),
			'stock_received_supplied' => $this->db->escape_str(trim($stock_received_supplied)),
			'quantity_received' => $this->db->escape_str(trim($quantity_received)),
			'quantity_supplied' => $this->db->escape_str(trim($quantity_supplied)),
			'collecting_person_name' => $this->db->escape_str(trim($collecting_person_name)),
			'tab_id' => $this->db->escape_str(trim('1')),
			'modified_date' => $this->db->escape_str(trim($created_date)),
			'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			
		);
		
		$note = date('d/m/Y').'|'.$note.'||';
		//$note = '<br />'.date('d/m/Y').' - '.$note;
		
		$where_note ="CONCAT_WS('',note, '','".$this->db->escape_str(trim($note))."')"; 
		$this->db->set('note', $where_note, false);

		if($stock_received_supplied =='SS'){
			$ins_data['proof_of_id'] = $this->db->escape_str(trim($proof_of_id));
			$ins_data['proof_confirm_id'] = $this->db->escape_str(trim($proof_confirm_id));
			
		}elseif($stock_received_supplied =='SR'){
			
			$ins_data['invoice_no'] = $this->db->escape_str(trim($invoice_no));
			
		}//end if($stock_received_supplied =='SS')
		
		
		//Inserting register entry data into the database. 
		$this->db->dbprefix('register_entry');
		$this->db->where('id',$entry_id);
		$this->db->where('pharmacy_surgery_id',$pharmacy_id);
		$upd_into_db = $this->db->update('register_entry', $ins_data);
		
		//All the enteries starting from entry_id till further. As all the stock in hand will be updated till we find a stock check.

		$this->db->dbprefix('register_entry');
		$this->db->where('pharmacy_surgery_id',$pharmacy_id);
		$this->db->where('id > ',$entry_id);
		$this->db->where('drug_id',$drug_id);
		$register_next_enteries = $this->db->get('register_entry')->result_array();
		
		for($i=0;$i<count($register_next_enteries);$i++){
			
			if($register_next_enteries[$i]['stock_received_supplied'] == NULL || $register_next_enteries[$i]['stock_received_supplied'] == '')
				break;
				
			if($register_next_enteries[$i]['stock_received_supplied'] == 'SR')
				$new_stock_in_hand = ($new_stock_in_hand) + ($register_next_enteries[$i]['quantity_received']);
			else
				$new_stock_in_hand = ($new_stock_in_hand) - ($register_next_enteries[$i]['quantity_supplied']);

			//Update the entry
			$upp_data = array(
				'stock_in_hand' => $this->db->escape_str(trim($new_stock_in_hand))					
			);

			//Updating rest of the enteries
			$this->db->dbprefix('register_entry');
			$this->db->where('id',$register_next_enteries[$i]['id']);
			$this->db->where('pharmacy_surgery_id',$pharmacy_id);
			$upd_into_db = $this->db->update('register_entry', $upp_data);
			
		}//end for($i=0;$i<count($register_next_enteries);$i++)

		
		return true;
		//exit;
		
	}//end adjust_register_entry($pharmacy_id, $entry_id, $data)

}//end file
?>