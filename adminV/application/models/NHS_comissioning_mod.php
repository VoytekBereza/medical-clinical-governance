<?php
class NHS_comissioning_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function add_new_nhs_comissioning_cateogry(): Add new NHS Comissioning Catetgory into the database
	public function add_new_nhs_comissioning_cateogry($data){
		
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
			$this->db->dbprefix('nhs_comissioning_category');
			$ins_into_db = $this->db->insert('nhs_comissioning_category', $ins_data);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//update  data into the database. 
			$this->db->dbprefix('nhs_comissioning_category');
			$this->db->where('id',$category_id);
			$ins_into_db = $this->db->update('nhs_comissioning_category', $ins_data);
			
		}//end if($category_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_nhs_comissioning_cateogry($data)
	
	// Start - get_all_nhs_comissioning_category(): Get all NHS Comissioning Category for listing
	public function get_all_nhs_comissioning_category(){
		$this->db->dbprefix('nhs_comissioning_category');
		$this->db->from('nhs_comissioning_category');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_nhs_comissioning_category():
	
	//Function get_nhs_comissioning_category_details($category_id): Get NHS Comissioning Category details from nhs_comissioning_category table via nhs_comissioning_category id
	public function get_nhs_comissioning_category_details($category_id){

		$this->db->dbprefix('nhs_comissioning_category');
		$this->db->where('id',$category_id);
		$get_page= $this->db->get('nhs_comissioning_category');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_nhs_comissioning_category_details($category_id)
	
	//Function delete_nhs_comissioning_category(): Delete NHS Comissioning Category from  database
	public function delete_nhs_comissioning_category($category_id){
		
		$this->db->dbprefix('nhs_comissioning_documents');
		$this->db->where('category_id',$category_id);
		$get_page = $this->db->delete('nhs_comissioning_documents');
		
		$this->db->dbprefix('nhs_comissioning_category');
		$this->db->where('id',$category_id);
		$get_page = $this->db->delete('nhs_comissioning_category');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_nhs_comissioning_category($category_id)
	
	//Function add_new_nhs_comissioning_documents(): Add new NHS Comissioning Documents into the database
	public function add_new_nhs_comissioning_documents($data){
		
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
			$this->db->dbprefix('nhs_comissioning_documents');
			$ins_into_db = $this->db->insert('nhs_comissioning_documents', $ins_data);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			//update  data into the database. 
			$this->db->dbprefix('nhs_comissioning_documents');
			$this->db->where('id',$document_id);
			$ins_into_db = $this->db->update('nhs_comissioning_documents', $ins_data);
			
		}//end if($category_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_nhs_comissioning_documents($data)
	
	// Start - get_all_nhs_comissioning_documents(): Get all NHS Comissioning Documents for listing
	public function get_all_nhs_comissioning_documents(){
		$this->db->dbprefix('nhs_comissioning_documents,nhs_comissioning_category');
		$this->db->select('nhs_comissioning_documents.*,nhs_comissioning_category.category_name');
		$this->db->from('nhs_comissioning_documents');
		$this->db->join('nhs_comissioning_category ','nhs_comissioning_documents.category_id = nhs_comissioning_category.id ', 'inner');
		$this->db->order_by('nhs_comissioning_documents.id', 'desc');
		return $this->db->get()->result_array();
		
	} // End - get_all_nhs_comissioning_documents():
	
	//Function get_nhs_comissioning_document_details($document_id): Get NHS Comissioning Document details from nhs_comissioning_documents table via nhs_comissioning_documents id
	public function get_nhs_comissioning_document_details($document_id){

		$this->db->dbprefix('nhs_comissioning_documents');
		$this->db->where('id',$document_id);
		$get_page= $this->db->get('nhs_comissioning_documents');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_nhs_comissioning_document_details($document_id)
	
	//Function delete_nhs_comissioning_documents(): Delete NHS Comissioning Documents from  database
	public function delete_nhs_comissioning_documents($document_id){
		
		$this->db->dbprefix('nhs_comissioning_documents');
		$this->db->where('id',$document_id);
		$get_page = $this->db->delete('nhs_comissioning_documents');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
	}//end delete_nhs_comissioning_documents($document_id)
	
}//end file
?>