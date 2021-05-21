<?php
class Cms_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	// Start - get_cms_page($url_slug): Return CMS Page by URL
	public function get_cms_page($url_slug = '',$page_id = ''){
	
		
		$this->db->dbprefix('pages');
		
		if(trim($url_slug) != '') 		$this->db->where('url_slug', $url_slug);
		if(trim($page_id) != '') 		$this->db->where('id', $page_id);
		
		//$this->db->where('cms_type', '0');
		
		$query = $this->db->get('pages');
	
		$response['cms_page_count'] = $query->num_rows();
		$response['cms_page_arr'] = $query->row_array();
		
		return $response;
		
	} // End - get_cms_page($url_slug)
	
	// Start - function get_noscript_text()
	public function get_noscript_text(){
		
		$this->db->dbprefix('global_settings');
		$this->db->where('setting_name', "NOSCRIPT_TEXT");
		
		return $this->db->get('global_settings')->row_array();
		
	} // End - get_noscript_text()
	
}//end file
?>