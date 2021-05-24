<?php
class Page_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_page_details($page_id): Get Page details from page table via page id
	public function get_page_details($page_id){

		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$get_page= $this->db->get('pages');
		//echo $this->db->last_query(); 		exit;
		return $get_page->row_array();
		
	}//end get_page_details($page_id)
	
	//Function delete_page(): Delete Page from  database
	public function delete_page_db($page_id){
		
		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$get_page = $this->db->delete('pages');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_page_db($page_id)
	
	//Function add_new_page(): Add new Page into the database
	public function add_new_page($data){
		
		extract($data);
		
		$generate_seo_url = $this->common->generate_seo_url($page_title);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'page_title' => $this->db->escape_str(trim($page_title)),
			'page_description' => $this->db->escape_str(trim($page_description)),
			'meta_title' => $this->db->escape_str(trim($meta_title)),
			'meta_description' => $this->db->escape_str(trim($meta_description)),
			'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
			'cms_type' => $this->db->escape_str(0),
			'status' => $this->db->escape_str(trim($status))
		);
		

		if($page_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
		
			//Inserting  data into the database. 
			$this->db->dbprefix('pages');
			$ins_into_db = $this->db->insert('pages', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			$verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'pages','url_slug',$last_insert_id,'0');
			$ins_data_url['url_slug'] = $this->db->escape_str(trim($verified_seo_url));
			
			//update  data into the database. 
			$this->db->dbprefix('pages');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('pages', $ins_data_url);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
		    $verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'pages','url_slug',$page_id,'0');
			$ins_data['url_slug'] = $this->db->escape_str(trim($verified_seo_url));

			//update  data into the database. 
			$this->db->dbprefix('pages');
			$this->db->where('id',$page_id);
			$ins_into_db = $this->db->update('pages', $ins_data);
			
		}//end if($page_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_page($data)
	
	// Start - get_all_pages(): Get all pages for listing
	public function get_all_pages(){
		$this->db->dbprefix('pages');
		$this->db->from('pages');
		$this->db->where('cms_type','0');
		$this->db->order_by('id', 'DESC');
	    return  $this->db->get()->result_array();
	   //  $this->db->last_query(); exit;		
	} // End - get_all_pages():
	
		// Start - get_cms_page($url_slug): Return CMS Page by URL
	public function get_cms_page($url_slug){
		
		$this->db->dbprefix('pages');
		$this->db->where('url_slug', $url_slug);
		$query = $this->db->get('pages');
		
		$response['cms_page_count'] = $query->num_rows();
		$response['cms_page_arr'] = $query->row_array();
		
		return $response;
		
	} // End - get_cms_page($url_slug)
	
	
	/******************************************************************/
	/*			VOYGER HEALTH										  */
	/******************************************************************/
	
		// Start - get_all_pages_voyger_health(): Get all pages for listing
	public function get_all_pages_voyger_health(){
		$this->db->dbprefix('pages');
		$this->db->from('pages');
		$this->db->where('cms_type','1');
		$this->db->order_by('id', 'DESC');
	    return  $this->db->get()->result_array();
	    $this->db->last_query(); exit;		
	} // End - get_all_pages_voyger_health():
	
	
	//Function get_page_details_voyger_health($page_id): Get Page details from page table via page id
	public function get_page_details_voyger_health($page_id){

		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$get_page= $this->db->get('pages');
		//echo $this->db->last_query(); 		exit;
		return $get_page->row_array();
		
	}//end get_page_details_voyger_health($page_id)
	
	//Function delete_page(): Delete Page from  database
	public function delete_page_voyger_health($page_id){
		
		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$get_page = $this->db->delete('pages');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_page_voyger_health($page_id)
	
	//Function add_new_page(): Add new Page into the database
	public function add_new_page_voyger_health($data){
		
		extract($data);
		
		$generate_seo_url = $this->common->generate_seo_url($page_title);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'page_title' => $this->db->escape_str(trim($page_title)),
			'page_description' => $this->db->escape_str(trim($page_description)),
			'meta_title' => $this->db->escape_str(trim($meta_title)),
			'meta_description' => $this->db->escape_str(trim($meta_description)),
			'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
			'cms_type' => $this->db->escape_str(1),
			'status' => $this->db->escape_str(trim($status))
		);
		
		if($page_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
		

			//Inserting  data into the database. 
			$this->db->dbprefix('pages');
			$ins_into_db = $this->db->insert('pages', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			
			$verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'pages','url_slug',$last_insert_id,'1');
			$ins_data_url['url_slug'] = $this->db->escape_str(trim($verified_seo_url));
			
			//update  data into the database. 
			$this->db->dbprefix('pages');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('pages', $ins_data_url);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
		    $verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'pages','url_slug',$page_id,$cms_type);
			$ins_data['url_slug'] = $this->db->escape_str(trim($verified_seo_url));

			//update  data into the database. 
			$this->db->dbprefix('pages');
			$this->db->where('id',$page_id);
			$ins_into_db = $this->db->update('pages', $ins_data);
			
		}//end if($page_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_page_voyger_health($data)
	
	/******************************************************************/
	/*			END VOYGER HEALTH										  */
	/******************************************************************/

}//end file
?>