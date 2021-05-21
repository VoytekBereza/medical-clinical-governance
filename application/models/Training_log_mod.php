<?php
class Training_log_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

    //Add Edit contact book sign post
	public function add_edit_training_log($user_id, $data){
				
		extract($data);		
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();

		$date_completed = str_replace('/','-',$date_completed);
		$date_completed = date('Y-m-d', strtotime($date_completed));
		
		$ins_data = array(
				
			'user_id' => $this->db->escape_str(trim($user_id)),
			'date_completed' => $this->db->escape_str(trim($date_completed)),
			'course_name' => $this->db->escape_str(trim($course_name)),
			'training_provider' => $this->db->escape_str(trim($training_provider)),
			'subject_of_training' => $this->db->escape_str(trim($subject_of_training)),
			'qualification_of_training' => $this->db->escape_str(trim($qualification_of_training)),
			'notes_on_subject' => $this->db->escape_str(trim($notes_on_subject)),
			'useful_weblinks' => $this->db->escape_str(trim($useful_weblinks)),
			'performed_cpd' => $this->db->escape_str(trim($performed_cpd))
		);

		//Uploading Files
		$media_location  = './assets/training_log_files/';
		
		$allowed_exntension = array('jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'ppt', 'pptx');
		
		if($log_id == ''){
			
			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));

			$this->db->dbprefix('training_log');
			$ins_into_db = $this->db->insert('training_log', $ins_data);
			
			$recent_log_id = $this->db->insert_id();
			
			if($_FILES['useful_file1']['name'] != ''){
				
				$extension = pathinfo($_FILES['useful_file1']['name'], PATHINFO_EXTENSION);
				$file_size = ($_FILES['useful_file1']['size'] / 1024)/1024;
				
				if(in_array($extension,$allowed_exntension) && $file_size <=5){
					
					$file1_name = $recent_log_id.'_training_'.rand().'.'.$extension;
					
					$destination_path = $media_location.$file1_name;
					
					$is_copied = @copy($_FILES['useful_file1']['tmp_name'],$destination_path);
					
					if($is_copied){
						
						$file_ins_data = array(
							'file_name' =>  $this->db->escape_str($file1_name),
							'training_log_id' =>  $this->db->escape_str($recent_log_id),
							'created_date' => $this->db->escape_str(trim($created_date)),
							'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
						);

						$this->db->dbprefix('training_log_files');
						$file_ins_into_db = $this->db->insert('training_log_files', $file_ins_data);

					}//end if($is_copied)
					
				}//end if(in_array($extension,$allowed_exntension))
				
			} // end if($_FILES['theme_thumb_1']['name'] != '')
			
			if($_FILES['useful_file2']['name'] != ''){

				$extension = pathinfo($_FILES['useful_file1']['name'], PATHINFO_EXTENSION);
				
				if(in_array($extension,$allowed_exntension)  && $file_size <=5){
					
					$file2_name = $recent_log_id.'_training_'.rand().'.'.$extension;
					
					$destination_path = $media_location.$file2_name;
					
					$is_copied = @copy($_FILES['useful_file2']['tmp_name'],$destination_path);
					
					if($is_copied){
						
						$file_ins_data = array(
							'file_name' =>  $this->db->escape_str($file2_name),
							'training_log_id' =>  $this->db->escape_str($recent_log_id),
							'created_date' => $this->db->escape_str(trim($created_date)),
							'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
						);

						$this->db->dbprefix('training_log_files');
						$file_ins_into_db = $this->db->insert('training_log_files', $file_ins_data);

					}//end if($is_copied)
					
				}//end if(in_array($extension,$allowed_exntension))
				
			} // end if($_FILES['theme_thumb_1']['name'] != '')
			
			if($_FILES['useful_file3']['name'] != ''){

				$extension = pathinfo($_FILES['useful_file3']['name'], PATHINFO_EXTENSION);
				
				if(in_array($extension,$allowed_exntension)  && $file_size <=5){
					
					$file3_name = $recent_log_id.'_training_'.rand().'.'.$extension;
					
					$destination_path = $media_location.$file3_name;
					
					$is_copied = @copy($_FILES['useful_file3']['tmp_name'],$destination_path);
					
					if($is_copied){
						
						$file_ins_data = array(
							'file_name' =>  $this->db->escape_str($file3_name),
							'training_log_id' =>  $this->db->escape_str($recent_log_id),
							'created_date' => $this->db->escape_str(trim($created_date)),
							'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
						);

						$this->db->dbprefix('training_log_files');
						$file_ins_into_db = $this->db->insert('training_log_files', $file_ins_data);

					}//end if($is_copied)
					
				}//end if(in_array($extension,$allowed_exntension))
				
			} // end if($_FILES['theme_thumb_1']['name'] != '')

		}else{

			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			$ins_data['is_reflected'] = $this->db->escape_str(trim($is_reflected));

			$this->db->dbprefix('training_log');
			$this->db->where('id',$log_id);
			$ins_into_db = $this->db->update('training_log', $ins_data);
			
			if($_FILES['useful_file']['name'] != ''){

				$extension = pathinfo($_FILES['useful_file']['name'], PATHINFO_EXTENSION);
				
				if(in_array($extension,$allowed_exntension)  && $file_size <=5){
					
					$file_name = $log_id.'_training_'.rand().'.'.$extension;
					
					$destination_path = $media_location.$file_name;
					
					$is_copied = @copy($_FILES['useful_file']['tmp_name'],$destination_path);
					
					if($is_copied){
						
						$file_ins_data = array(
							'file_name' =>  $this->db->escape_str($file_name),
							'training_log_id' =>  $this->db->escape_str($log_id),
							'created_date' => $this->db->escape_str(trim($created_date)),
							'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
						);

						$this->db->dbprefix('training_log_files');
						$file_ins_into_db = $this->db->insert('training_log_files', $file_ins_data);

					}//end if($is_copied)
					
				}//end if(in_array($extension,$allowed_exntension))
				
			} // end if($_FILES['theme_thumb_1']['name'] != '')
			

			
		}//end if($log_id == '')
		
		//print_this($ins_data); exit;
		
		//Inserting clinical data into the database. 
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	} // End add_training_log($user_id, $data)
	
	public function delete_training_log_file($training_id, $file_id){
		
		$training_log_files_list = $this->get_training_log_files_list($training_id, $file_id);
		
		$media_location  = './assets/training_log_files/'.filter_string($training_log_files_list['file_name']);
		
		if(file_exists($media_location))
			@unlink($media_location);

		$this->db->dbprefix('training_log_files');
		$this->db->where('id', $file_id);
		$delete = $this->db->delete('training_log_files');
		
		return true;
		
	}//end delete_training_log_file($training_id, $file_id)
	
	//Function: get_training_log_details(): 
	public function get_training_log_details($user_id, $log_id = ''){
		
		$this->db->dbprefix('training_log');
		$this->db->where('user_id', $user_id);
		if(trim($log_id) != '') $this->db->where('id', $log_id);
		$get = $this->db->get('training_log');
		
		if(trim($log_id) != '')
			return $get->row_array();
		else
			return $get->result_array();
		
	} // End public function get_training_log_details

	//Function: get_training_log_files_list(): 
	public function get_training_log_files_list($log_id, $file_id = ''){
		
		$this->db->dbprefix('training_log_files');
		$this->db->where('training_log_id', $log_id);
		if(trim($file_id) != '') $this->db->where('id', $file_id);
		$get = $this->db->get('training_log_files');
		
		if(trim($file_id) != '')
			return $get->row_array();
		else
			return $get->result_array();
		
	} // End public function get_training_log_files_list

}//end file
?>