<?php
class Country_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//GET All ACTIVE USER COUNTRY
	public function get_active_countries(){
		
		$this->db->dbprefix('country');
		$this->db->where('status',1);
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('country');
		
		return $list_arr->result_array();
		
	}//end get_active_country()

}//end file
?>