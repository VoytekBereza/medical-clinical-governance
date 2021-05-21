<?php
class Contact_book_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	
    //Add Edit contact book sign post
	public function add_edit_contact_book_sign_post($user_id, $pharmacy_surgery_id, $post){
				
		extract($post);		
		
		$created_date = date('Y-m-d G:i:s');
		
		$entdate = str_replace('/','-',$entry_date);
		$entry_date = date('Y-m-d', strtotime($entdate));
		
		if($cb_sign_post_id ==""){

			$ins_data = array(
					
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'gender' => $this->db->escape_str(trim($gender)),
				'approximate_age' => $this->db->escape_str(trim($approximate_age)),
				'patient_request' => $this->db->escape_str(trim($patient_request)),
				'sign_post_to_whom' => $this->db->escape_str(trim($sign_post_to_whom)),
				'reason' => $this->db->escape_str(trim($reason)),
				'advice_given' => $this->db->escape_str(trim($advice_given)),
				'follow_up_advice_given' => $this->db->escape_str(trim($follow_up_advice_given)),
				'company_name_note' => $this->db->escape_str(trim($company_name_note)),
				'created_date' => $this->db->escape_str(trim($created_date))
				
			);
		
			//Inserting clinical data into the database. 
			$this->db->dbprefix('cb_sign_post_log');
			$ins_into_db = $this->db->insert('cb_sign_post_log', $ins_data);
			
		} else {
	
			$ins_data = array(
					
				'created_by' => $this->db->escape_str(trim($user_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
				'entry_date' => $this->db->escape_str(trim($entry_date)),
				'gender' => $this->db->escape_str(trim($gender)),
				'approximate_age' => $this->db->escape_str(trim($approximate_age)),
				'patient_request' => $this->db->escape_str(trim($patient_request)),
				'sign_post_to_whom' => $this->db->escape_str(trim($sign_post_to_whom)),
				'reason' => $this->db->escape_str(trim($reason)),
				'advice_given' => $this->db->escape_str(trim($advice_given)),
				'follow_up_advice_given' => $this->db->escape_str(trim($follow_up_advice_given)),
				'company_name_note' => $this->db->escape_str(trim($company_name_note)),
				'created_date' => $this->db->escape_str(trim($created_date))
			);
			
			//Inserting cb_sign_post_log  data into the database. 
			$this->db->dbprefix('cb_sign_post_log');
			$this->db->where('cb_sign_post_log.id', $cb_sign_post_id);
			$ins_into_db = $this->db->update('cb_sign_post_log', $ins_data);
			
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_edit_contact_book_sign_post ();
	
	
	// Get list_cb_sign_post_log_private List
	public function list_cb_sign_post_log_private($user_id, $pharmacy_surgery_id){
		
		$this->db->dbprefix('cb_sign_post_log');
		$this->db->select('cb_sign_post_log.*, users.first_name, users.last_name');
		$this->db->join('users','users.id = cb_sign_post_log.created_by','LEFT');
		/*$this->db->where('cb_sign_post_log.created_by', $user_id);
		$this->db->where('cb_sign_post_log.organization_id', $organization_id);*/
		$this->db->where('cb_sign_post_log.pharmacy_surgery_id', $pharmacy_surgery_id);
		$this->db->order_by('cb_sign_post_log.id', 'DESC');
	    return $this->db->get('cb_sign_post_log')->result_array();
	} // end list_cb_sign_post_log_private
	
	
	
	//Function: get_contact_book_details(): Get Contact book details
	public function get_contact_book_details($contact_id, $pharmacy_id){
		
		// Get Patient Record
		$this->db->dbprefix('contact_book');
		$this->db->select('contact_book.*');
		$this->db->where('pharmacy_surgery_id', $pharmacy_id);
		$this->db->where('contact_book.id', $contact_id);
		$get = $this->db->get('contact_book');
		
		return $get->row_array();
		
	} // End public function get_contact_book_details($patient_id)
	
	// Start - public function search_contacts($search_query)
    public function search_contacts($search_query,$pharmacy_id){

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
		
		if($qry_str !=""){
			$qry_str = $qry_str;
		}
		
		//$search_qry = "SELECT * FROM kod_contact_book WHERE pharmacy_id = $my_pharmacy_id  AND $qry_str AND status = '1' "; 
		$search_qry = "SELECT * FROM kod_contact_book WHERE $qry_str  AND pharmacy_surgery_id = $pharmacy_id"; 
		
		$rs_qry = $this->db->query($search_qry);

		//echo $this->db->last_query(); exit;

		$qry_result = $rs_qry->result_array();

		return $qry_result;


    } // End - public function search_contacts($search_query)

	
	// Start Function add_edit_contact_book
	public function add_edit_contact_book($data, $update_contact_id, $pharmacy_id, $user_id){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		if($update_contact_id == ''){

			$ins_data = array(
			    'created_by' => $this->db->escape_str(trim($user_id)),
				'first_name' => $this->db->escape_str(trim($first_name)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_id)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'contact_no' => $this->db->escape_str(trim($contact_no)),
				'company_notes' => $this->db->escape_str(trim($company_notes)),
				'email_address' => $this->db->escape_str(trim($email_address)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))			);

		} else {
			
			$ins_data = array(
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_id)),
				'company_notes' => $this->db->escape_str(trim($company_notes)),
				'contact_no' => $this->db->escape_str(trim($contact_no)),
				'email_address' => $this->db->escape_str(trim($email_address))
			);
			
	  	}//end if($update_contact_id == '')
			
	
	    if($update_contact_id == ''){
		   
			//Inserting Patient data into the database. 
			$this->db->dbprefix('contact_book');
			$ins_into_db = $this->db->insert('contact_book', $ins_data);

			$new_contact_id = $this->db->insert_id();

			$this->db->dbprefix('contact_book');
			$this->db->where('id', $new_contact_id);

			return $this->db->get('contact_book')->row_array();
			
		} else {
				
			//Record insert into database
			$ins_data['modified_date']  = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//Update Patient data into the database. 
			$this->db->dbprefix('contact_book');
			$this->db->where('id', $update_contact_id);
			$this->db->update('contact_book', $ins_data);
			//echo $this->db->last_query();exit;
			
			// Return Patient row [ retuen New Updated recoed ]
			$this->db->dbprefix('contact_book');
			$this->db->where('id', $update_contact_id);

			return $this->db->get('contact_book')->row_array();
			
		} // if($update_contact_id == '')
		
	}// End add_edit_contact_book
	
		// Start - public function search_drugs($search_query)
    public function search_drugs($pharmacy_id, $search_query){

    	$this->db->dbprefix('pharmacy_drugs');
		
		
		$search_query = str_replace(',','',$search_query);
		$str_arr = explode(' ',$search_query);
		
		$qry_str = '';
		for($i=0;$i<count($str_arr);$i++){
			
			$qry_str .= "
						(kod_contact_book.last_name LIKE '".$str_arr[$i]."%' OR
						kod_contact_book.first_name LIKE '".$str_arr[$i]."%') AND";
		}//end for($i=0;$icount($str_arr);$i++)
		
		$qry_str = substr($qry_str,0,strlen($qry_str)-3); 
		
		//$result_arr = $this->db->get('pharmacy_drugs')->result_array();
		$search_qry = "SELECT contact_book.*  WHERE $qry_str AND pharmacy_surgery_id =$pharmacy_id";

		$rs_qry = $this->db->query($search_qry);

		$qry_result = $rs_qry->result_array();
		
		return $qry_result;

    } // End - public function search_drugs($search_query)
	
	// Get all contact book list
	public function contact_bool_list($pharmacy_id){
		
		// Get Patient Record
		$this->db->dbprefix('contact_book');
		$this->db->where('pharmacy_surgery_id', $pharmacy_id);
		return $this->db->get('contact_book')->result_array();
		//echo $this->db->last_query(); exit;
	} // contact_bool_list()
	

}//end file
?>