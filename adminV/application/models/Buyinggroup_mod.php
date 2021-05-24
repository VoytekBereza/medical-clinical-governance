<?php
class Buyinggroup_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//GET All BUYING GROUP
	public function get_buying_groups_list($id = ''){
		
		$this->db->dbprefix('buyinggroups');
		
		if(trim($id) != '') $this->db->where('id',$id); 
		
		$this->db->order_by('id DESC');
		$list_arr = $this->db->get('buyinggroups');
		
		if(trim($id) != '')
			return $list_arr->row_array();
		else
			return $list_arr->result_array();
		
	}//end get_active_buyinggroups()
	
	//GET All ACTIVE BUYING GROUP
	public function get_active_buyinggroups($id = ''){
		
		$this->db->dbprefix('buyinggroups');
		$this->db->where('status',1);
		
		if(trim($id) != '') $this->db->where('id',$id); 
		
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('buyinggroups');
		
		if(trim($id) != '')
			return $list_arr->row_array();
		else
			return $list_arr->result_array();
		
	}//end get_active_buyinggroups()
	
	public function verify_if_group_exist($field_name, $data, $exclude_self = ''){
		
		extract($data);
		
		$this->db->dbprefix('buyinggroups');
		
		if($field_name == 'name') $this->db->where('buying_groups',$buying_groups); 
		if($field_name == 'email') $this->db->where('email_address',$email_address); 
		
		if($exclude_self != '') $this->db->where('id != ',$group_id); 
		
		$list_arr = $this->db->get('buyinggroups');
		
		return $list_arr->row_array();
		
	}//end verify_if_group_exist($field_name, $data)
	
	public function add_edit_buying_group($data){
		
		extract($data);
		
		/*
		$url_slug = $this->common->generate_seo_url($buying_groups);
		if(!$group_id)
			$url_slug = $this->common->verify_seo_url($url_slug,'buyinggroups','url_slug','','');
		else
			$url_slug = $this->common->verify_seo_url($url_slug,'buyinggroups','url_slug',$group_id,'');
		*/				
		$ins_data = array(
		
			'buying_groups' => $this->db->escape_str(trim($buying_groups)),
			'first_name' => $this->db->escape_str(trim($first_name)),
			'last_name' => $this->db->escape_str(trim($last_name)),
			'email_address' => $this->db->escape_str(trim($email_address)),
			'contact_no' => $this->db->escape_str(trim($contact_no)),
			'status' => $this->db->escape_str(trim($status)),
		);
		
		//print_this($ins_data); exit;
		
		if(!$group_id){
			
			$url_slug = str_replace(' ','',strtolower($url_slug));
			
			$ins_data['password'] = $this->db->escape_str(trim(md5($password)));
			$ins_data['url_slug'] = $this->db->escape_str(trim($url_slug));
			$this->db->dbprefix('buyinggroups');
			$success = $this->db->insert('buyinggroups', $ins_data);
			
		}else{
			
			if($password)
				$ins_data['password'] = $this->db->escape_str(trim(md5($password)));

			$this->db->dbprefix('buyinggroups');
			$this->db->where('id',$group_id);
			$success = $this->db->update('buyinggroups', $ins_data);
			
		}//end if(!$group_id)
		
		if($success)
			return true;
		else
			return false;
	
	}//end add_edit_buying_group($data)

}//end file
?>