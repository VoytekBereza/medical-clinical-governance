<?php
class Template_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_template_details($template_id): Get Email Template details from email_templates table via template id
	public function get_template_details($template_id){

		$this->db->dbprefix('email_templates');
		$this->db->where('id',$template_id);
		$get_template= $this->db->get('email_templates');
		//echo $this->db->last_query(); 		exit;
		return $get_template->row_array();
		
	}//end get_template_details($template_id)
	
	//Function delete_template(): Delete Template from  database
	public function delete_template($template_id){
		
		$this->db->dbprefix('email_templates');
		$this->db->where('id',$template_id);
		$get_template = $this->db->delete('email_templates');
		//echo $this->db->last_query(); 		exit;
		
		if($get_template)
			return true;
		else
			return false;
		
	}//end delete_template($template_id)
	
	//Function add_new_template(): Add new Tempplate into the database
	public function add_new_template($data){
		
		extract($data);
	
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'email_title' => $this->db->escape_str(trim($email_title)),
			'email_subject' => $this->db->escape_str(trim($email_subject)),
			'email_body' => $this->db->escape_str(trim($email_body)),
			'status' => $this->db->escape_str(trim($status))
		);
		
		if($template_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			//Inserting  data into the database. 
			$this->db->dbprefix('email_templates');
			$ins_into_db = $this->db->insert('email_templates', $ins_data);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			//update  data into the database. 
			$this->db->dbprefix('email_templates');
			$this->db->where('id',$template_id);
			$ins_into_db = $this->db->update('email_templates', $ins_data);
			
		}//end if($template_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_page($data)
	
	// Start - get_all_template(): Get all Email Templates for listing
	public function get_all_templates(){
		$this->db->dbprefix('email_templates');
		$this->db->from('email_templates');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_template():
	
}//end file
?>