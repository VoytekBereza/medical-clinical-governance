<?php
class NHS_comissioning_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	public function get_all_nhs_comissioning(){
		
		$this->db->dbprefix('nhs_comissioning_documents');
		
		$this->db->select('documents.*, cat.category_name');
		$this->db->from('nhs_comissioning_documents as documents');
		$this->db->join('nhs_comissioning_category as cat', 'cat.id = documents.category_id');
		$get = $this->db->get();
		$result_arr = $get->result_array();
		
		//echo $this->db->last_query(); exit;
		
		$quick_form_arr = array();
		for($i=0;$i<count($result_arr);$i++){
			$quick_form_arr[$result_arr[$i]['category_name']][] = $result_arr[$i];
		}//end for($i=0;$i<count();$i++)
		
		return $quick_form_arr;
		
	} // public function get_all_nhs_comissioning()
	
}//end class nhs_comissioning_mod extends CI_Model
?>