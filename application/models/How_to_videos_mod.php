<?php
class How_to_videos_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	public function get_video_listing($video_id = '', $status = ''){
		
		$this->db->dbprefix('how_to_videos');
		
		if($status!= '')
			$this->db->where('status', $status);

		$this->db->order_by('display_order', 'ASC');
		
		if($video_id != ''){
			$this->db->where('id', $video_id);
			return $this->db->get('how_to_videos')->row_array();
		}else
			return $this->db->get('how_to_videos')->result_array();
			
			
		
	} // end get_video_listing($video_id = '', $status = '')
	

}//end file
?>