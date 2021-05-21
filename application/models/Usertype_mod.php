<?php
class Usertype_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//GET All ACTIVE USER TYPES
	public function get_active_usertypes(){
		
		$this->db->dbprefix('usertype');
		$this->db->where('status',1);
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('usertype');
		
		return $list_arr->result_array();
		
	}//end get_active_usertypes()
	
	public function get_usertype_details($type_id){
		
		$this->db->dbprefix('usertype');
		$this->db->where('id', $type_id);
		$list_arr = $this->db->get('usertype');
		
		return $list_arr->row_array();
		
	}//end get_usertype_details($type_id)

	//Get Users Name
	/*
	public function get_user($user_id){
		
		$this->db->dbprefix('users');
		$this->db->where('user_id',$user_id);
		$get_user= $this->db->get('users');
		//echo $this->db->last_query(); exit;
		$row_arr = $get_user->row_array();
		return $row_arr;		
		
	}//end get_Users
	*/

}//end file
?>