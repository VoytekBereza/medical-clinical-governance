<?php
class Repeat_prescription_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }	
    
	// Get get_eps_listing 
		public function get_repeat_prescription_listing($pharmacy_surgery_id){
		
		$this->db->dbprefix('repeat_prescriptions');
		$this->db->select('repeat_prescriptions.*, 
							patients.first_name AS p_first_name, patients.last_name AS p_last_name, patients.email_address AS p_email_address, patients.mobile_no AS p_mobile_no, patients.address AS p_address, patients.address_2 AS p_address2, patients.postcode AS p_postcode, patients.dob AS p_dob, patients.gender AS p_gender
							
						');
		
		$this->db->join('patients','patients.id = repeat_prescriptions.patient_id','LEFT');
		$this->db->where('repeat_prescriptions.pharmacy_id', $pharmacy_surgery_id);
		$this->db->order_by('repeat_prescriptions.id', 'DESC');
	    return $this->db->get('repeat_prescriptions')->result_array();
	} // end get_eps_listing
	
	public function get_rp_details($rp_id){

		$this->db->dbprefix('repeat_prescription_details');
		$this->db->select('repeat_prescription_details.*');
		$this->db->where('prescription_id', $rp_id);

		$this->db->order_by('id', 'DESC');
	    return $this->db->get('repeat_prescription_details')->result_array();
		
	}//end get_rp_details($rp_id)
	
	
	//Add Repeat Prescription Form
	public function add_repeat_prescription($post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$date_of_birth = str_replace('/','-',$date_of_birth);
		$dob = date('Y-m-d', strtotime($date_of_birth));

			$ins_data = array(
					
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
			    'dob' => $this->db->escape_str(trim($dob)),
				'medication' => $this->db->escape_str(trim($medication)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('repeat_prescription');
			$ins_into_db = $this->db->insert('repeat_prescription', $ins_data);

		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End Clinical Diary();
			

}//end file
?>