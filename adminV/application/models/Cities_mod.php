<?php
class Cities_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//GET All ACTIVE USER Cities
	public function get_active_cities(){
		
		$this->db->dbprefix('cities');
		$this->db->where('status',1);
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('cities');
		
		return $list_arr->result_array();
		
	}//end get_active_cities()

}//end file
?>