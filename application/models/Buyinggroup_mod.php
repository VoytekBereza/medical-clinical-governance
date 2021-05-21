<?php
class Buyinggroup_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//GET All ACTIVE BUYING GROUP
	public function get_active_buyinggroups($id = '', $url_slug = ''){
		
		$this->db->dbprefix('buyinggroups');
		$this->db->where('status',1);
		
		if(trim($id) != '') $this->db->where('id',$id); 
		if(trim($url_slug) != '') $this->db->where('url_slug',$url_slug); 
		
		$this->db->order_by('buying_groups ASC');
		$list_arr = $this->db->get('buyinggroups');
		
		if(trim($id) != '' || trim($url_slug) != '')
			return $list_arr->row_array();
		else
			return $list_arr->result_array();
		
	}//end get_active_buyinggroups()

}//end file
?>