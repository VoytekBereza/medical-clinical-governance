<?php
class Quick_forms_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	public function get_all_quick_forms(){
		
		$this->db->dbprefix('quick_forms_documents');
		
		$this->db->select('documents.*, cat.category_name');
		$this->db->from('quick_forms_documents as documents');
		$this->db->join('quick_form_category as cat', 'cat.id = documents.category_id');
		$get = $this->db->get();
		$result_arr = $get->result_array();
		
		//echo $this->db->last_query(); exit;
		
		$quick_form_arr = array();
		for($i=0;$i<count($result_arr);$i++){
			$quick_form_arr[$result_arr[$i]['category_name']][] = $result_arr[$i];
		}//end for($i=0;$i<count();$i++)
		
		return $quick_form_arr;
		
	} // public function get_all_quick_forms()
	
}//end class Quick_forms_mod extends CI_Model
?>