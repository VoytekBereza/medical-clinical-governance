<?php
class Common_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	///random number generator function
	public function random_number_generator($digit){
		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789abcdefjhijklmnopqrstuvwxyz";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		return $randnumber;
	}// end random_password_generator()
	
	// General Function to Get All User Types
	public function get_all_user_types(){
		$this->db->dbprefix('usertype');
		return $this->db->get('usertype')->result_array();
	}
	
 //Function verify_seo_url(): If URL String already exist in the database table record generate new.
	public function verify_seo_url($url_string,$table_name,$field_name,$exclude_self,$cms_type = ''){
	
		$this->db->dbprefix($table_name);
		$this->db->select('id');
		$this->db->where($field_name, $url_string); 

		if(trim($cms_type) != '')  
			$this->db->where('cms_type', $cms_type); 

		if($exclude_self != '') $this->db->where('id !=', $exclude_self); 
		$rs_count_rec = $this->db->get($table_name);
		//echo $this->db->last_query(); exit;
		if($rs_count_rec->num_rows() == 0) return $url_string;
		else{
			//Add Postfix and generate concatenate.
			$generate_postfix = $this->common->random_number_generator(3);
			$new_url_string = $url_string.'-'.$generate_postfix;
			return $this->common->verify_seo_url($new_url_string,$table_name,'url_slug',$exclude_self);
		
		}//end if
	
	}//end verify_seo_url
	
	// Function generate_seo_url();
	public function generate_seo_url($url_string){

	  $str_tmp = str_replace(' ', '-', $url_string); // Replaces all spaces with hyphens.
	  return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $str_tmp)); 	// Replaces all Special characters	

  }//end generate_seo_url

	//GET All ACTIVE USER COUNTRY
	public function get_active_countries(){
		
		$this->db->dbprefix('country');
		$this->db->where('status',1);
		$this->db->order_by('display_order','ASC');
		$list_arr = $this->db->get('country');
		
		return $list_arr->result_array();
		
	}//end get_active_country()

}//end file
?>