<?php
class Clinical_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }


	//Function: get_clinical_diary_details(): Get clinical diary details
	public function get_clinical_diary_details($clinical_diary_id){
		
		// Get Clinical Diary Record
		$this->db->dbprefix('cl_clinicaldiary');
		$this->db->select('cl_clinicaldiary.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_clinicaldiary.created_by','LEFT');
		$this->db->where('cl_clinicaldiary.id', $clinical_diary_id);
		$get = $this->db->get('cl_clinicaldiary');
		//echo $this->db->last_query(); exit;
		return $get->row_array();
		//echo $this->db->last_query(); exit;
		
	} // End public function get_clinical_diary_details($clinical_diary_id)
	
	
	//Function: get_clinical_errors_details(): Get clinical errors details
	public function get_clinical_errors_details($clinical_errors_id){

		$this->db->dbprefix('cl_errors');
		$this->db->select('cl_errors.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_errors.created_by','LEFT');
		$this->db->where('cl_errors.id', $clinical_errors_id);
	    return  $this->db->get('cl_errors')->row_array();
		
	} // End public function get_clinical_errors_details($clinical_errors_id)
		
	//Function: get_clinical_self_care_details(): Get clinical self care details
	public function get_clinical_self_care_details($clinical_self_care_id){
		
		// Get Patient Record
		$this->db->dbprefix('cl_self_care');
		$this->db->select('cl_self_care.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_self_care.created_by','LEFT');
		$this->db->where('cl_self_care.id', $clinical_self_care_id);
		$get = $this->db->get('cl_self_care');
		//echo $this->db->last_query(); exit;
		return $get->row_array();
		//echo $this->db->last_query(); exit;
		
	} // End public function get_clinical_diary_details($clinical_diary_id)
	
	
	
    //Add Edit Clinical Diary
	public function add_edit_clinical_diary($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($diary_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'subject' => $this->db->escape_str(trim($subject)),
				'details' => $this->db->escape_str(trim($details)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_clinicaldiary');
			$ins_into_db = $this->db->insert('cl_clinicaldiary', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'subject' => $this->db->escape_str(trim($subject)),
				'details' => $this->db->escape_str(trim($details)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_clinicaldiary');
			$this->db->where('cl_clinicaldiary.id', $diary_id);
			$ins_into_db = $this->db->update('cl_clinicaldiary', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical Diary();
	
	 //Add Edit Clinical Errors
	public function add_edit_clinical_errors($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($errors_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'error_attributed' => $this->db->escape_str(trim($error_attributed)),
				'npsa_class' => $this->db->escape_str(trim($npsa_class)),
				'subject' => $this->db->escape_str(trim($subject)),
				'details' => $this->db->escape_str(trim($details)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_errors');
			$ins_into_db = $this->db->insert('cl_errors', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'error_attributed' => $this->db->escape_str(trim($error_attributed)),
				'npsa_class' => $this->db->escape_str(trim($npsa_class)),
				'subject' => $this->db->escape_str(trim($subject)),
				'details' => $this->db->escape_str(trim($details)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_errors');
			$this->db->where('cl_errors.id', $errors_id);
			$ins_into_db = $this->db->update('cl_errors', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical Errors;
	
	
	 //Add Edit Date Checking
	public function add_edit_clinical_date_checking($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($date_checking_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'medicine_type' => $this->db->escape_str(trim($medicine_type)),
				'notes' => $this->db->escape_str(trim($notes)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_date_checking');
			$ins_into_db = $this->db->insert('cl_date_checking', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'medicine_type' => $this->db->escape_str(trim($medicine_type)),
				'notes' => $this->db->escape_str(trim($notes)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_date_checking');
			$this->db->where('cl_date_checking.id', $date_checking_id);
			$ins_into_db = $this->db->update('cl_date_checking', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical Date Checking();
	
	 //Add Edit Clinical Cleaning
	public function add_edit_clinical_cleaning($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($cleaning_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'area_id' => $this->db->escape_str(trim($area_id)),
				'notes' => $this->db->escape_str(trim($notes)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_cleaning');
			$ins_into_db = $this->db->insert('cl_cleaning', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'area_id' => $this->db->escape_str(trim($area_id)),
				'notes' => $this->db->escape_str(trim($notes)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_cleaning');
			$this->db->where('cl_cleaning.id', $cleaning_id);
			$ins_into_db = $this->db->update('cl_cleaning', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical Date Cleaning();
	
	 //Add Edit Clinical Recalls
	public function add_edit_clinical_recalls($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($recalls_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'details' => $this->db->escape_str(trim($details)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_recalls');
			$ins_into_db = $this->db->insert('cl_recalls', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'details' => $this->db->escape_str(trim($details)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_recalls');
			$this->db->where('cl_recalls.id', $recalls_id);
			$ins_into_db = $this->db->update('cl_recalls', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical  Recalls();
	
	
	 //Add Edit responsible pharmacist 
	public function add_edit_clinical_responsible_pharmacist($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($responsible_pharmacist_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'pharmacist_id' => ($pharmacist_id) ? $this->db->escape_str(trim($pharmacist_id)) : NULL,
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'checkin_time' => $this->db->escape_str(trim($checkin_time)),
				'checkout_time' => $this->db->escape_str(trim($checkout_time)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_responsible_pharmacist');
			$ins_into_db = $this->db->insert('cl_responsible_pharmacist', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'pharmacist_id' => ($pharmacist_id) ? $this->db->escape_str(trim($pharmacist_id)) : NULL,
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'checkin_time' => $this->db->escape_str(trim($checkin_time)),
				'checkout_time' => $this->db->escape_str(trim($checkout_time)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_responsible_pharmacist');
			$this->db->where('cl_responsible_pharmacist.id', $responsible_pharmacist_id);
			$ins_into_db = $this->db->update('cl_responsible_pharmacist', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical  add_edit_clinical_responsible_pharmacist();
	
	
	 //Add Edit maintenance
	public function add_edit_clinical_maintenance($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$identifieddate = str_replace('/','-',$identified_date);
		$identified_date = date('Y-m-d', strtotime($identifieddate));
		
		$reporteddate = str_replace('/','-',$reported_date);
		$reported_date = date('Y-m-d', strtotime($reporteddate));
		
		if($maintenance_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'identified_date' => $this->db->escape_str(trim($identified_date)),
				'reported_date' => $this->db->escape_str(trim($reported_date)),
				'maintenance_issue' => $this->db->escape_str(trim($maintenance_issue)),
				'contractor_name_details' => $this->db->escape_str(trim($contractor_name_details)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_maintenance');
			$ins_into_db = $this->db->insert('cl_maintenance', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'identified_date' => $this->db->escape_str(trim($identified_date)),
				'reported_date' => $this->db->escape_str(trim($reported_date)),
				'maintenance_issue' => $this->db->escape_str(trim($maintenance_issue)),
				'contractor_name_details' => $this->db->escape_str(trim($contractor_name_details)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_maintenance');
			$this->db->where('cl_maintenance.id', $maintenance_id);
			$ins_into_db = $this->db->update('cl_maintenance', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical  add_edit_clinical_maintenance();
	
	
	 //Add Edit self care
	public function add_edit_clinical_self_care($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($self_care_id ==""){

			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'gender' => $this->db->escape_str(trim($gender)),
				'approximate_age' => $this->db->escape_str(trim($approximate_age)),
				'prescription_item' => $this->db->escape_str(trim($prescription_item)),
				'rx_advice_given' => $this->db->escape_str(trim($rx_advice_given)),
				'otc_request' => $this->db->escape_str(trim($otc_request)),
				'otc_advice_given' => $this->db->escape_str(trim($otc_advice_given)),
				'follow_up_care_given' => $this->db->escape_str(trim($follow_up_care_given)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cl_self_care');
			$ins_into_db = $this->db->insert('cl_self_care', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'modified_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'gender' => $this->db->escape_str(trim($gender)),
				'approximate_age' => $this->db->escape_str(trim($approximate_age)),
				'prescription_item' => $this->db->escape_str(trim($prescription_item)),
				'rx_advice_given' => $this->db->escape_str(trim($rx_advice_given)),
				'otc_request' => $this->db->escape_str(trim($otc_request)),
				'otc_advice_given' => $this->db->escape_str(trim($otc_advice_given)),
				'follow_up_care_given' => $this->db->escape_str(trim($follow_up_care_given)),
				'modified_date' => $this->db->escape_str(trim($created_date)),
			);
			
			//Inserting clinical diary data into the database. 
			$this->db->dbprefix('cl_self_care');
			$this->db->where('cl_self_care.id', $self_care_id);
			$ins_into_db = $this->db->update('cl_self_care', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical  add_edit_clinical_self_care();
	
	// Get list_cl_diary List
	public function list_cl_diary($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_clinicaldiary');
		$this->db->select('cl_clinicaldiary.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_clinicaldiary.created_by','LEFT');
		$this->db->where('cl_clinicaldiary.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_clinicaldiary.id', 'DESC');
	    return $this->db->get('cl_clinicaldiary')->result_array();
	} // end list_cl_diary
	
	// Get list_cl_errors List
	public function list_cl_errors($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_errors');
		$this->db->select('cl_errors.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_errors.created_by','LEFT');
		$this->db->where('cl_errors.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_errors.id', 'DESC');
	    return $this->db->get('cl_errors')->result_array();
	} // end list_cl_errors
	
	// Get list_cl_date_checking List
	public function list_cl_date_checking($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_date_checking');
		$this->db->select('cl_date_checking.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_date_checking.created_by','LEFT');
		$this->db->where('cl_date_checking.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_date_checking.id', 'DESC');
	    return $this->db->get('cl_date_checking')->result_array();
	} // end list_cl_date_checking
	
	// Get list_cl_cleaning List
	public function list_cl_cleaning($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_cleaning');
		$this->db->select('cl_cleaning.*, users.first_name, users.last_name,location_area.location_area');
		$this->db->join('users','users.id = cl_cleaning.created_by','LEFT');
		$this->db->join('location_area','location_area.id = cl_cleaning.area_id','LEFT');
		$this->db->where('cl_cleaning.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_cleaning.id', 'DESC');
	    return $this->db->get('cl_cleaning')->result_array();
	} // end list_cl_cleaning
	
	// Get list_cl_recalls List
	public function list_cl_recalls($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_recalls');
		$this->db->select('cl_recalls.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_recalls.created_by','LEFT');
		$this->db->where('cl_recalls.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_recalls.id', 'DESC');
	    return $this->db->get('cl_recalls')->result_array();
	} // end list_cl_recalls
	
	// Get list_cl_responsible_pharmacist List
	public function list_cl_responsible_pharmacist($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_responsible_pharmacist');
		$this->db->select('cl_responsible_pharmacist.*, users.first_name, users.last_name, 
							pharmacist.first_name AS pharma_first_name, pharmacist.last_name AS pharma_last_name
						');
		
		$this->db->join('users','users.id = cl_responsible_pharmacist.created_by','LEFT');
		$this->db->join('users AS pharmacist','pharmacist.id = cl_responsible_pharmacist.pharmacist_id','LEFT');
		
		$this->db->where('cl_responsible_pharmacist.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_responsible_pharmacist.id', 'DESC');
	   
	    return $this->db->get('cl_responsible_pharmacist')->result_array();
	} // end list_cl_responsible_pharmacist

	// Get list_cl_responsible_pharmacist List
	public function last_cl_responsible_pharmacist($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_responsible_pharmacist');
		$this->db->select('cl_responsible_pharmacist.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_responsible_pharmacist.created_by','LEFT');
		$this->db->where('cl_responsible_pharmacist.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_responsible_pharmacist.id', 'DESC');
		$this->db->limit(0,1);
	    return $this->db->get('cl_responsible_pharmacist')->row_array();
		
	} // end last_cl_responsible_pharmacist
	
	
	// Get list_cl_maintenance List
	public function list_cl_maintenance($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_maintenance');
		$this->db->select('cl_maintenance.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_maintenance.created_by','LEFT');
		$this->db->where('cl_maintenance.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_maintenance.id', 'DESC');
	    return $this->db->get('cl_maintenance')->result_array();
	} // end list_cl_maintenance
	
	
	// Get list_cl_self_care List
	public function list_cl_self_care($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cl_self_care');
		$this->db->select('cl_self_care.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cl_self_care.created_by','LEFT');
		$this->db->where('cl_self_care.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cl_self_care.id', 'DESC');
	    return $this->db->get('cl_self_care')->result_array();
	} // end list_cl_self_care
	
	
		
		public function resolve_maintenance($id,$action_by,$tab_id,$user_id){
			
		
	    $reslove_date =  date('Y-m-d');
		
		
		if($tab_id ==5){
			
			if($action_by ==2){
				
					$ins_data = array(
						
					'action_by' => $this->db->escape_str(trim($user_id)),
					'status' => $this->db->escape_str(trim(1)),
					'action_date' => $this->db->escape_str(trim($reslove_date)),
				);
				
			} else {
			
					$ins_data = array(
						
					'received_by' => $this->db->escape_str(trim($user_id)),
					'status' => $this->db->escape_str(trim(1)),
					'received_date' => $this->db->escape_str(trim($reslove_date)),
				);
			}
			
			$this->db->dbprefix('cl_recalls');
			$this->db->where('id',$id);
			$upd_into_db = $this->db->update('cl_recalls', $ins_data);
			
		} else {
			
			
			$ins_data = array(
				
			'resolved_by' => $this->db->escape_str(trim($user_id)),
			'status' => $this->db->escape_str(trim(1)),
			'reslove_date' => $this->db->escape_str(trim($reslove_date)),
			
		);
			
		    $this->db->dbprefix('cl_maintenance');
			$this->db->where('id',$id);
			$upd_into_db = $this->db->update('cl_maintenance', $ins_data);
		
		}
			//echo $this->db->last_query(); exit;
			
			if($upd_into_db)
				return true;
			else
				return false;
				
			}// end resolve_maintenance();
			
		//Function: get_details_date_checking(): Get date checking details
		public function get_details_date_checking($id){
		
			// Get date checking details
			$this->db->dbprefix('cl_date_checking');
			$this->db->select('cl_date_checking.*, users.first_name, users.last_name');
			$this->db->join('users','users.id = cl_date_checking.created_by','LEFT');
			$this->db->where('cl_date_checking.id', $id);
			$get = $this->db->get('cl_date_checking');
			//echo $this->db->last_query(); exit;
			return $get->row_array();
			//echo $this->db->last_query(); exit;
		
		} // End public function get_details_date_checking($id)
		
			
		//Function: get_cleaning_details(): Get cleaning details
		public function get_cleaning_details($id){
		
			// Get date checking details
			$this->db->dbprefix('cl_cleaning');
			$this->db->select('cl_cleaning.*, users.first_name, users.last_name');
			$this->db->join('users','users.id = cl_cleaning.created_by','LEFT');
			$this->db->where('cl_cleaning.id', $id);
			$get = $this->db->get('cl_cleaning');
			//echo $this->db->last_query(); exit;
			return $get->row_array();
			//echo $this->db->last_query(); exit;
		
		} // End public function get_cleaning_details($id)
		
		
		//Function: get_recalls_details(): Get Recalls details
		public function get_recalls_details($id){
		
			// Get date checking details
			$this->db->dbprefix('cl_recalls');
			$this->db->select('cl_recalls.*, users.first_name, users.last_name');
			$this->db->join('users','users.id = cl_recalls.created_by','LEFT');
			$this->db->where('cl_recalls.id', $id);
			$get = $this->db->get('cl_recalls');
			//echo $this->db->last_query(); exit;
			return $get->row_array();
			//echo $this->db->last_query(); exit;
		
		} // End public function get_recalls_details($id)
		
	public function update_checkout_time($pharmacy_surgery_id, $data){
		
		extract($data);
		
		$upd_data = array(
				
			'checkout_time' => $this->db->escape_str(trim($checkout_time_fld)),
		);
		
		//Inserting clinical diary data into the database. 
		$this->db->dbprefix('cl_responsible_pharmacist');
		$this->db->where('id', $checkout_id);
		$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
		$upd_into_db = $this->db->update('cl_responsible_pharmacist', $upd_data);
		
		if($upd_into_db)
			return true;
		else
			return false;

	}//end update_checkout_time($pharmacy_surgery_id, $data)
	
	
	 //Add Edit self care
	public function add_edit_area($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
			$this->db->dbprefix('location_area');
			$this->db->where('location_area', $location_area);
			$this->db->where('pharmacy_surgery_id', $pharmacy_surgery_id);
			$exist = $this->db->get('location_area')->row_array();
					
			if($exist) {
				return false;
				exit;
				
			} else {
		
				$ins_data = array(
						
					'created_by' => $this->db->escape_str(trim($user_id)),
					'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
					'location_area' => $this->db->escape_str(trim($location_area)),
					'created_date' => $this->db->escape_str(trim($created_date)),
				);	
			
				//Inserting clinical data into the database. 
				$this->db->dbprefix('location_area');
				$ins_into_db = $this->db->insert('location_area', $ins_data);
				
			if($ins_into_db)
				return true;
			else
				return false;
	 }
	} // End  add_edit_area();
	
		
	// Get get_area List
	public function get_area($pharmacy_surgery_id){
		
		$this->db->dbprefix('location_area');
		$this->db->where('location_area.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('location_area.id', 'DESC');
	    return $this->db->get('location_area')->result_array();
	} // end get_area	

}//end file
?>