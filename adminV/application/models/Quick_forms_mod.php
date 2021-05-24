<?php
class Quick_forms_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function add_new_quick_forms_cateogry(): Add new Quick Forms Catetgory into the database
	public function add_new_quick_forms_cateogry($data){
		
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
			$this->db->dbprefix('quick_form_category');
			$ins_into_db = $this->db->insert('quick_form_category', $ins_data);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//update  data into the database. 
			$this->db->dbprefix('quick_form_category');
			$this->db->where('id',$category_id);
			$ins_into_db = $this->db->update('quick_form_category', $ins_data);
			
		}//end if($category_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_quick_forms_cateogry($data)
	
	// Start - get_all_quick_forms_category(): Get all Quick Forms Category for listing
	public function get_all_quick_forms_category(){
		$this->db->dbprefix('quick_form_category');
		$this->db->from('quick_form_category');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_quick_forms_category():
	
	//Function get_quick_forms_category_details($category_id): Get Quick Forms Category details from quick_form_category table via quick_form_category id
	public function get_quick_forms_category_details($category_id){

		$this->db->dbprefix('quick_form_category');
		$this->db->where('id',$category_id);
		$get_page= $this->db->get('quick_form_category');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_quick_forms_category_details($category_id)
	
	//Function delete_quick_forms_category(): Delete Quick Forms Category from  database
	public function delete_quick_forms_category($category_id){
		
		$this->db->dbprefix('quick_forms_documents');
		$this->db->where('category_id',$category_id);
		$get_page = $this->db->delete('quick_forms_documents');
		
		$this->db->dbprefix('quick_form_category');
		$this->db->where('id',$category_id);
		$get_page = $this->db->delete('quick_form_category');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_quick_forms_category($category_id)
	
	//Function add_new_quick_forms_documents(): Add new Quick Forms Documents into the database
	public function add_new_quick_forms_documents($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
			
		// Data array to be inserted in data base - Table (pgd_documents)
		$ins_data = array(
			'category_id'		=>  $this->db->escape_str(trim($category_id)),
			'document_title'	=>  $this->db->escape_str(trim($document_title)),
			'document_url'		=>  $this->db->escape_str(trim($document_url)),
			'document_icon'		=>  $this->db->escape_str(trim($document_icon)),
			'status'			=> $status
		);

		if($document_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_ip'] = $this->db->escape_str(trim($created_by_ip));

			//Inserting  data into the database. 
			$this->db->dbprefix('quick_forms_documents');
			$ins_into_db = $this->db->insert('quick_forms_documents', $ins_data);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//update  data into the database. 
			$this->db->dbprefix('quick_forms_documents');
			$this->db->where('id',$document_id);
			$ins_into_db = $this->db->update('quick_forms_documents', $ins_data);
			
		}//end if($category_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_quick_forms_documents($data)
	
	// Start - get_all_quick_forms_documents(): Get all Quick Forms Documents for listing
	public function get_all_quick_forms_documents(){
		$this->db->dbprefix('quick_forms_documents,quick_form_category');
		$this->db->select('quick_forms_documents.*,quick_form_category.category_name');
		$this->db->from('quick_forms_documents');
		$this->db->join('quick_form_category ','quick_forms_documents.category_id = quick_form_category.id ', 'inner');
		$this->db->order_by('quick_forms_documents.id', 'desc');
		return $this->db->get()->result_array();
		
	} // End - get_all_quick_forms_documents():
	
	//Function get_quick_forms_document_details($document_id): Get Quick Forms Document details from quick_forms_documents table via quick_forms_documents id
	public function get_quick_forms_document_details($document_id){

		$this->db->dbprefix('quick_forms_documents');
		$this->db->where('id',$document_id);
		$get_page= $this->db->get('quick_forms_documents');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_quick_forms_document_details($document_id)
	
	//Function delete_quick_forms_documents(): Delete Quick Forms Documents from  database
	public function delete_quick_forms_documents($document_id){
		
		$this->db->dbprefix('quick_forms_documents');
		$this->db->where('id',$document_id);
		$get_page = $this->db->delete('quick_forms_documents');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
	}//end delete_quick_forms_documents($document_id)
	
}//end file
?>