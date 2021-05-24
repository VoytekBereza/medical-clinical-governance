<?php
class Vh_faq_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function add_new_vh_faq(): Add new vh faq into the database
	public function add_update_vh_faq($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'faq_question' => $this->db->escape_str(trim($faq_question)),
			'faq_answer' => $this->db->escape_str(trim($faq_answer)),
			'status' => $this->db->escape_str(trim($status))
		);
		
		if($faq_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//Inserting  data into the database. 
			$this->db->dbprefix('vh_faq');
			$ins_into_db = $this->db->insert('vh_faq', $ins_data);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//update  data into the database. 
			$this->db->dbprefix('vh_faq');
			$this->db->where('id',$faq_id);
			$ins_into_db = $this->db->update('vh_faq', $ins_data);
			
		}//end if($faq_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_vh_faq($data)
	
	// Start - get_all_vh_faq(): Get all vh faq for listing
	public function get_all_vh_faq(){
		$this->db->dbprefix('vh_faq');
		$this->db->from('vh_faq');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_quick_forms_category():
	
	//Function get_vh_faq_details($faq_id): Get vh faq details  table via get_vh_faq_details id
	public function get_vh_faq_details($faq_id){

		$this->db->dbprefix('vh_faq');
		$this->db->where('id',$faq_id);
		$get_page= $this->db->get('vh_faq');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_vh_faq_details($faq_id)
	
	//Function delete_vh_faq(): Delete vh faq from  database
	public function delete_vh_faq($faq_id){
		
		$this->db->dbprefix('vh_faq');
		$this->db->where('id',$faq_id);
		$get_page = $this->db->delete('vh_faq');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_quick_forms_category($category_id)
	
}//end file
?>