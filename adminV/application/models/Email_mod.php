<?php
class Email_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_email_template(): Fetch the email template using template_id
	public function get_email_template($t_id){
		
		$this->db->dbprefix('email_templates');
		$this->db->where('id',$t_id);
		$get_user = $this->db->get('email_templates');
		$row_arr = $get_user->row_array();
		//echo $this->db->last_query(); exit;
		return $row_arr;		
		
	}//end get_email_template

}//end file
?>