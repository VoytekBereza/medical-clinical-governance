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
	
	// Start - add_update_video(): Add - Edit video
	public function add_update_video($data, $action){
		
		extract($data); // Extract POST data
	
		$created_date = date('Y-m-d H:i:s');
		$created_ip = $this->input->ip_address();
		
		// Data array to be inserted in data base - Table (training_videos)
		$post_data = array(
		
			'video_title'		=> $this->db->escape_str(trim($video_title)),
			'video_url'			=> $this->db->escape_str(trim($video_url)),
			//'video_embed'			=> $this->db->escape_str(trim($video_embed)),
			//'video_id'			=> $this->db->escape_str(trim($video_title)),
			'default_type'		=> $this->db->escape_str(trim($default_type)),
			'display_order'		=> $this->db->escape_str(trim($display_order)),
			'status'			=> $this->db->escape_str(trim($status))
		);

		if($action == 'add'){
			
			$post_data['created_date'] = $this->db->escape_str(trim($created_date));
			$post_data['created_ip'] = $this->db->escape_str(trim($created_ip));
			
			// Insert data into db - Table (training_videos)
			$this->db->dbprefix('how_to_videos');
			return $this->db->insert('how_to_videos', $post_data);
			
		}elseif($action == 'update'){
			
			$post_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$post_data['modified_by_ip'] = $this->db->escape_str(trim($created_ip));
			
			$this->db->dbprefix('how_to_videos');
			$this->db->where('id', $video_id);
			return $this->db->update('how_to_videos', $post_data);
		}
		
	} // End - add_update_video():
	
	// Start - delete_video(): Delete video by id
	public function delete_video($video_id){
		
		$this->db->dbprefix('how_to_videos');
		$this->db->where('id', $video_id);
		
		return $this->db->delete('how_to_videos');
		
	} // End - delete_video():

}//end file
?>