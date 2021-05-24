<?php
class Trainings_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	/* --------------------------------------------------------- */
	/* --------------- Start Trainings Functions --------------- */
	/* --------------------------------------------------------- */
	
	// Start - list_all_document_categories():
	public function list_all_document_categories($training_id = ''){
		$this->db->dbprefix('training_documents_category');
		$this->db->select('training_documents_category.id AS cate_id,training_documents_category.category_name,training_documents_category.training_id');
		$this->db->from('training_documents_category');
		$this->db->where('training_documents_category.training_id', $training_id);
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
	    //echo $this->db->last_query(); exit;
	} // End - list_all_document_categories():
	
	// Start - get_training_document_category($category_id):
	public function get_training_document_category($category_id){
		
		$this->db->dbprefix('training_documents_category');
		$this->db->where('id', $category_id);
		return $this->db->get('training_documents_category')->row_array();
		
	} // End - get_training_document_category($category_id):
	
	// Start - add_update_category():
	public function add_update_category($post){
		
		extract($post);

		
		if($action == 'update'){ // Update category
			
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
			$data = array('category_name' => $category_name, 'status' => $status, 'modified_date' => $modified_date, 'modified_by_ip' => $modified_by_ip,'training_id' => $training_id);
			
			$this->db->dbprefix('training_documents_category');
			$this->db->where('id', $category_id);
			return $this->db->update('training_documents_category', $data);
			
		} else if($action == 'add'){ // Insert category
		
			$created_date = date('Y-m-d H:i:s');
			$created_ip = $this->input->ip_address();
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
		
			$data = array('category_name' => $category_name, 'status' => $status, 'created_date' => $created_date, 'created_ip' => $created_ip, 'modified_date' => $modified_date, 'modified_by_ip' => $modified_by_ip, 'training_id' => $training_id);
		
			return $this->db->insert('training_documents_category', $data);
		}
		
	} // End - add_update_category():
	
	// Start - delete_document_category($category_id):
	public function delete_document_category($category_id){
		
		$this->db->dbprefix('training_documents');
		$this->db->where('category_id', $category_id);
		$this->db->delete('training_documents');
		
		$this->db->dbprefix('training_documents_category');
		$this->db->where('id', $category_id);
		return $this->db->delete('training_documents_category');
	} // // Start - delete_document_category($category_id):
	
	// Start -  add_update_training(): Add - Update Training
	public function add_update_training($data, $action){
		
		// Extract Post Data
		extract($data);
		
		$add = array('created_date' => date('Y-m-d H:i:s'), 'created_by_ip' => $this->input->ip_address());
		$upd = array('modified_date' => date('Y-m-d H:i:s'), 'modified_by_ip' => $this->input->ip_address());
		
		$post_data = array(
		
			'user_type' 			=> $user_type,
			'course_name'			=> $course_name,
			'short_description'		=> $short_description,
			'long_description' 		=> $long_description,
			'training_certificate_body' => $training_certificate_body,
			'star_rating' 			=> $star_rating,
			'no_of_quizes'			=> $no_of_quizes,
			'author' 				=> $author,
			'course_sample_video' 	=> $course_sample_video,
			'meta_title' 			=> $meta_title,
			'meta_description' 		=> $meta_description,
			'meta_keywords' 		=> $meta_keywords,
			'price' 				=> $price,
			'discount_price' 		=> $discount_price,
			'training_pass_percentage' 	=> $this->db->escape_str(trim($training_pass_percentage)),
			'training_expiry_months' 	=> $this->db->escape_str(trim($training_expiry_months)),
			'training_number_of_attempts_allowed' => $this->db->escape_str(trim($training_number_of_attempts_allowed)),
			'training_reattempt_quiz_hours' => $this->db->escape_str(trim($training_reattempt_quiz_hours)),
			'status' 				=> $status		
		);
		
		if($action == 'add'){
			
			$add_arr = array_merge($post_data, $add);
			
			$training_course_folder_path = '../assets/training_course_images/';
			
			// Upload course images
			if($_FILES['course_image']['name'] != ''){
				
				$file_ext = ltrim(strtolower(strrchr($_FILES['course_image']['name'],'.')),'.');
				$training_course_file_name ='training_course_'.rand().'.jpg';
	
				$config['upload_path'] = $training_course_folder_path;
				$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config['max_size']	= '2000';
				$config['overwrite'] = true;
				$config['file_name'] = $training_course_file_name;
			
				$this->load->library('upload', $config);
	
				if(!$this->upload->do_upload('course_image')){
					$error_file_arr = array('error_upload' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					$add_arr['course_image'] = $this->db->escape_str(trim($training_course_file_name));
					
				} // End - if(!$this->upload->do_upload('course_image'))
				
			} // End - if($_FILES['course_image']['name'] != '')
			
			$this->db->dbprefix('package_training');
			$success = $this->db->insert('package_training', $add_arr);
			$last_insert_id = $this->db->insert_id();
			
			
			$created_date = date('Y-m-d H:i:s');
		    $created_by_ip = $this->input->ip_address();
			
			$ins_data_document_cate = array(
			
				'category_name' => $this->db->escape_str(trim('None')),
				'training_id' => $this->db->escape_str(trim($last_insert_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_ip' => $this->db->escape_str(trim($created_by_ip)),
				'status' => $this->db->escape_str('1')
			);
			
			$this->db->dbprefix('training_documents_category');
			$success = $this->db->insert('training_documents_category', $ins_data_document_cate);
			
			if($success)
				return $success;
			else
				return false;
			
		} else if($action == 'update') {
			
			$upd_arr = array_merge($post_data, $upd);
			
			$training_course_folder_path = '../assets/training_course_images/';
			
			// Uploading profile Imaage
			
			if($_FILES['course_image']['name'] != ''){
				
				$file_ext = ltrim(strtolower(strrchr($_FILES['course_image']['name'],'.')),'.'); 			
				$training_course_file_name = 'training_course_'.rand().'.jpg';
	
				$config['upload_path'] = $training_course_folder_path;
				$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config['max_size']	= '2000';
				$config['overwrite'] = true;
				$config['file_name'] = $training_course_file_name;
			
				$this->load->library('upload', $config);
	
				if(!$this->upload->do_upload('course_image')){
					$error_file_arr = array('error_upload' => $this->upload->display_errors());
					return $error_file_arr;
					
				} else {
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					$upd_arr['course_image'] = $this->db->escape_str(trim($training_course_file_name));
					
					// Unlink image from Folder 	
					$this->db->dbprefix('package_training');
					$this->db->select('course_image');
					$this->db->where('id', $training_id);
					$row= $this->db->get('package_training')->row_array();
					//echo $training_course_folder_path."".$row['course_image']; exit;
					unlink($training_course_folder_path."".$row['course_image']);
					
				} // End - if(!$this->upload->do_upload('course_image'))
				
			} // End - if($_FILES['course_image']['name'] != '')
		
			$this->db->dbprefix('package_training');
			$this->db->where('id', $training_id);
			
			return $this->db->update('package_training', $upd_arr);
			
		} // Else - Update
		
	} // End - add_update_training():
	
	// Start - get_training_details(): Update Training
	public function get_training_details($training_id){
		
		$this->db->dbprefix('package_training');
		$this->db->where('id', $training_id);
		
		return $this->db->get('package_training')->row_array();
		
	} // End - get_training_details():
	
	// Start - get_all_trainings(): Get all trainings for listing
	public function get_all_trainings($user_type, $status=''){
		
		$this->db->dbprefix('package_training, usertype');

		$this->db->select('user.user_type as user_name, training.*');
		$this->db->from('package_training as training');

		$this->db->join('usertype as user', 'user.id = training.user_type', 'inner');
		$this->db->where('training.is_admin_deleted !=', 1);

		if($status) $this->db->where('training.status', 1);

		$this->db->order_by('training.id', 'DESC');
		if($user_type != '')
			$this->db->where('user.id', $user_type);
		
		return $this->db->get()->result_array();
		
	} // End - get_all_trainings():
	
	// Start - delete_training(): Delete training by id
	public function delete_training($training_id){
				
		if($training_id!=""){
			
		/* $this->db->dbprefix('training_documents_category');
	     $this->db->where('pgd_id',$training_id);
	     $this->db->delete('training_documents_category');*/
			
		 $ins_data['is_admin_deleted'] ="1";
		
		//If is_admin_deleted equal 1 it will not showing on admin panel. 
			$this->db->dbprefix('package_training');
			$this->db->where('id',$training_id);
			$ins_into_db = $this->db->update('package_training', $ins_data);
		}
		
		if($ins_into_db)
			return true;
		else
			return false;

	} // End - delete_training():
	
	/* --------------------------------------------------------- */
	/* ------------ Start Training Document Functions ---------- */
	/* --------------------------------------------------------- */
	
	// Start - add_update_document(): Add - Edit video
	public function add_update_document($data, $action){
		
		extract($data); // Extract POST data
		
		$created_date = date('Y-m-d H:i:s');
		$created_ip = $this->input->ip_address();
		$modified_date = date('Y-m-d H:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		if($action == 'add'){
			
			// Data array to be inserted in data base - Table (training_documents)
			$post_data = array(
			
				'category_id'		=> $category_id,
				'course_id' 		=> $course_id,
				'document_title'	=> $document_title,
				'document_url'		=> $document_url,
				'document_icon'		=> $document_icon,
				'status'			=> $status,
				'created_date'		=> $created_date,
				'created_ip'		=> $created_ip
			);
			
			// Insert data into db - Table (training_documents)
			$this->db->dbprefix('training_documents');
			return $this->db->insert('training_documents', $post_data);
			
		}elseif($action == 'update'){
			
			// Data array to be inserted in data base - Table (training_documents)
			$post_data = array(
			
				'category_id'		=> $category_id,
				'course_id' 		=> $course_id,
				'document_title'	=> $document_title,
				'document_url'		=> $document_url,
				'document_icon'		=> $document_icon,
				'status'			=> $status,
				'modified_date'		=> $modified_date,
				'modified_by_ip'	=> $modified_by_ip
			);
			
			$this->db->dbprefix('training_documents');
			$this->db->where('id', $document_id);
		    return $this->db->update('training_documents', $post_data);
			
		}
		
	} // End - add_update_document():
	
	// Start - documents_listing(): List all documents by Training id
	public function documents_listing($training_id){
		
		$this->db->dbprefix('training_documents_category, training_documents');
		$this->db->select('category.category_name, doc.*');
		$this->db->from('training_documents as doc');
		$this->db->join('training_documents_category as category', ' category.id =  doc.category_id', 'inner');
		$this->db->where('doc.course_id', $training_id);
		$this->db->order_by('doc.id', 'DESC');
		
		
		return $this->db->get()->result_array();
		
	} // end - documents_listing():
	
	// Start - get_all_training_document_categories(): Get documents all categories
	public function get_all_training_document_categories($training_id){
		
		$this->db->dbprefix('training_documents_category');
		$this->db->where('training_id', $training_id);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('training_documents_category')->result_array();
		
	} // End - get_all_training_document_categories(): Get document categories
	
	// Start - get_training_document_by_document_id($document_id): 
	public function get_training_document_by_document_id($document_id){
		
		$this->db->dbprefix('training_documents');
		$this->db->where('id', $document_id);
		return $this->db->get('training_documents')->row_array();
		
	} // End - get_training_document_by_document_id($document_id): 
	
	// Start - delete_document(): Delete document by id
	public function delete_document($document_id){
		
		$this->db->dbprefix('training_documents');
		$this->db->where('id', $document_id);
		
		return $this->db->delete('training_documents');
		
	} // End - delete_document():
	
	/* --------------------------------------------------------- */
	/* ------------- Start Training Videos Functions ----------- */
	/* --------------------------------------------------------- */
	
	// Start - add_update_video(): Add - Edit video
	public function add_update_video($data, $action){
		
		extract($data); // Extract POST data
		
		
		$created_date = date('Y-m-d G:i:s');
		$created_ip = $this->input->ip_address();
		
		
		// Data array to be inserted in data base - Table (training_videos)
		$post_data = array(
		
			'course_id' 		=> $course_id,
			'video_title'		=> $video_title,
			'video_url'			=> $video_url,
			'video_id'			=> $video_id_col,
			'video_type'		=> $video_type,
			'default_video'		=> $default_video,
			'status'			=> $status
		);
		
		if($action == 'add'){
			
			$post_data['created_date'] = $this->db->escape_str(trim($created_date));
			$post_data['created_ip'] = $this->db->escape_str(trim($created_ip));
			
			if($default_video == '1'){
				
				$zero = array('default_video' => 0);
				$this->db->dbprefix('training_videos');
				$this->db->where('default_video', 1);
				$true = $this->db->update('training_videos', $zero);

			}
			
			// Insert data into db - Table (training_videos)
			$this->db->dbprefix('training_videos');
			return $this->db->insert('training_videos', $post_data);			
			
		}elseif($action == 'update'){
			
			$post_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$post_data['modified_by_ip'] = $this->db->escape_str(trim($created_ip));
			
			
			if($default_video == '1'){
				
				$zero = array('default_video' => 0);
				$this->db->dbprefix('training_videos');
				$this->db->where('default_video', 1);
				$true = $this->db->update('training_videos', $zero);
			
			}
			
			$this->db->dbprefix('training_videos');
			$this->db->where('id', $video_id);
			return $this->db->update('training_videos', $post_data);
		}
		
	} // End - add_update_video():
	
	// Start - videos_listing(): List all documents by Training id
	public function videos_listing($training_id){
		
		$this->db->dbprefix('training_videos');
		$this->db->where('course_id', $training_id);
		$this->db->where('default_video !=', 1);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('training_videos')->result_array();
		
	} // end - videos_listing(): List all documents by Training id
	
	// Start - videos_intro_listing(): 
	public function videos_intro_listing($training_id){
		
		$this->db->dbprefix('training_videos');
		$this->db->where('course_id', $training_id);
		$this->db->where('default_video', 1);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('training_videos')->result_array();
		
	} // end - videos_intro_listing(): 
	
	// Start - get_training_video_by_video_id($video_id): 
	public function get_training_video_by_video_id($video_id){
		
		$this->db->dbprefix('training_videos');
		$this->db->where('id', $video_id);
		return $this->db->get('training_videos')->row_array();
		
	} // End - get_training_video_by_video_id($video_id):
	
	// Start - delete_video(): Delete video by id
	public function delete_video($video_id){
		
		$this->db->dbprefix('training_videos');
		$this->db->where('id', $video_id);
		
		return $this->db->delete('training_videos');
		
	} // End - delete_video():
	
	// Start - set_video_as_default($video_id):
	public function set_video_as_default($video_id){
		
		$zero = array('default_video' => 0);
		
		$this->db->dbprefix('training_videos');
		$this->db->where('id !=', $video_id);
		$true = $this->db->update('training_videos', $zero);
		
		$one = array('default_video' => 1);
		
		$this->db->dbprefix('training_videos');
		$this->db->where('id', $video_id);
		$true = $this->db->update('training_videos', $one);
		
		if($true)
			return true;
		else
			return false;
		
	} // End - set_video_as_default($video_id):
	
	/* --------------------------------------------------------------- */
	/* ----------------- Start Quizes Section ------------------------ */
	/* --------------------------------------------------------------- */
	
	// Start - get_training_quizes($training_id):
	public function get_training_quizes($training_id){
		
		$this->db->dbprefix('training_quizes');
		$this->db->select('id as question_id, question, correct_option_id');
		$this->db->where('training_id', $training_id);
		$this->db->where('status', 1);
		$this->db->order_by('id', 'DESC');
		$questions = $this->db->get('training_quizes')->result_array();
		
		$quizes;
		
		foreach($questions as $key => $question):
			
			$quizes[$key] = $question;
			
			$this->db->dbprefix('training_quiz_options');
			$this->db->select('id as option_id, option');
			$this->db->where('quiz_id', $question['question_id']);
			$this->db->where('status', 1);
			$this->db->order_by('id', 'DESC');
			$quizes[$key]['options'] = $this->db->get('training_quiz_options')->result_array();
			
		endforeach;
		
		return $quizes;
		
	} // End - get_training_quizes($training_id):
	
	// Start - quiz_by_id(): For the Ajax call in (js/kod_scripts/custom.js)
	public function quiz_by_id($question_id){
		
		$this->db->dbprefix('training_quizes');
		$this->db->select('id as question_id, question, correct_option_id');
		$this->db->where('status', 1);
		$this->db->where('id', $question_id);
		$question = $this->db->get('training_quizes')->row_array();
		
		$quizes;
		
		$quizes[0] = $question;
		
		$this->db->dbprefix('training_quiz_options');
		$this->db->select('id as option_id, option');
		$this->db->where('quiz_id', $question['question_id']);
		$this->db->where('status', 1);
		$this->db->order_by('id', 'DESC');
		
		$quizes[0]['options'] = $this->db->get('training_quiz_options')->result_array();
		
		return $quizes;
		
	} // End - quiz_by_id():
	
	// Start - add_update_quiz():
	public function add_update_quiz($post_data, $training_id){
		
		extract($post_data);
		
		if($question_id != ''){ // Update Quiz requested
			
			$training_quizes_update = array(
			
				//'training_id' => $training_id,
				'question' => $question,
				'correct_option_id' => $correct_option,
				'status' => 1,
				'modified_date' => date('Y-m-d H:i:s'),
				'modified_by_ip' => $this->input->ip_address()
			);
			
			// Update Question and Correct Answer into the training_quizes table
			$this->db->dbprefix('training_quizes');
			$this->db->where('id', $question_id);
			$success = $this->db->update('training_quizes', $training_quizes_update);
			$new_added_quiz_id = $question_id; //$this->db->insert_id();
			
			//////////////////////////////////////////////////////////////
			// Update the Quiz options to the training_quiz_options table
			
			$training_quiz_options;
			foreach($options as $key => $option):
				
				$training_quiz_options = array();
				//if($option != ''){
					
					$this->db->dbprefix('training_quiz_options');
					$this->db->where('id', $key); // Varify if an option with the id is exist [$key has the original id of option]
					$option_exist = $this->db->get('training_quiz_options')->row_array();
					
					if($option_exist){ // Update
						
						$training_quiz_options = array('option' => $option, 'status' => 1, 'modified_date' => date('Y-m-d H:i:s'), 'modified_by_ip' => $this->input->ip_address());
						$this->db->dbprefix('training_quiz_options');
						$this->db->where('id', $key);
						$success = $this->db->update('training_quiz_options', $training_quiz_options);
						
					} else { // Add new added options
						
						if($option != ''){
						
							$training_quiz_options = array('quiz_id' => $question_id, 'option' => $option, 'status' => 1, 'created_date' => date('Y-m-d H:i:s'), 'created_ip' => $this->input->ip_address());
							$this->db->dbprefix('training_quiz_options');
							$this->db->insert('training_quiz_options', $training_quiz_options);
							
							/*
							if($key == $correct_option){
								$correct_option_id = $this->db->insert_id();
							}
							
							// update training_quizes for correct option id
							$update_training_quizes = array('correct_option_id' => $correct_option_id);
							
							$this->db->dbprefix('training_quizes');
							$this->db->where('id', $question_id);
							$success = $this->db->update('training_quizes', $update_training_quizes);
							*/
							
						}
					}
				//}
				
			endforeach;
			
		} else { // Add Quiz Requested
		
			$training_quizes = array(
			
				'training_id' => $training_id,
				'question' => $question,
				'correct_option_id' => $correct_option,
				'status' => 1,
				'created_date' => date('Y-m-d H:i:s'),
				'created_ip' => $this->input->ip_address()
			);
			
			// Insert Question and Correct Answer into the training_quizes table
			$this->db->dbprefix('training_quizes');
			$this->db->insert('training_quizes', $training_quizes);
			$new_added_quiz_id = $this->db->insert_id();
			
			//////////////////////////////////////////////////////////////
			// Insert the Quiz options to the training_quiz_options table
			
			$training_quiz_options;
			foreach($options as $key => $option):
				
				if($option != ''){
					
					$training_quiz_options = array('quiz_id' => $new_added_quiz_id, 'option' => $option, 'status' => 1, 'created_date' => date('Y-m-d H:i:s'), 'created_ip' => $this->input->ip_address());
					$this->db->dbprefix('training_quiz_options');
					$success = $this->db->insert('training_quiz_options', $training_quiz_options);
					
					if($key == $correct_option-1){
						$correct_option_id = $this->db->insert_id();
					}
				}
				
			endforeach;
			
			// update training_quizes for correct option id
			$update_training_quizes = array('correct_option_id' => $correct_option_id);
			
			$this->db->dbprefix('training_quizes');
			$this->db->where('id', $new_added_quiz_id);
			$success = $this->db->update('training_quizes', $update_training_quizes);
			
		} // else
			
		if($success)
			return true;
		else
			return false;
		
	} // End - add_update_quiz():
	
	// Some common functions
	
	// Start - training_name_by_id($training_id)
	public function training_name_by_id($training_id){
		
		$this->db->dbprefix('package_training');
		$this->db->select('course_name');
		$this->db->where('id', $training_id);
		$query = $this->db->get('package_training');

		if($query->num_rows() > 0){
			$row = $query->row_array();
			return $row['course_name'];
		} else
			return NULL;
		
	} // End - training_name_by_id($training_id)
	
	// Start - document_name_by_id($training_id)
	public function document_name_by_id($document_id){
		
		$this->db->dbprefix('training_documents');
		$this->db->select('document_title');
		$this->db->where('id', $document_id);
		$query = $this->db->get('training_documents');

		if($query->num_rows() > 0){
			$row = $query->row_array();
			return $row['document_title'];
		} else
			return NULL;
		
	} // End - document_name_by_id($document_id)
	
	// Start - get_all_usertypes():
	public function get_all_usertypes(){
		
		$this->db->dbprefix('usertype');
		$this->db->select('id, user_type');
		$this->db->order_by('id', 'DESC');
		return $this->db->get('usertype')->result_array();
		
	} // End - get_all_usertypes():

	// Start - get_all_active_trainings(): Get all active trainings for listing
	public function get_all_active_trainings(){
		
		$this->db->dbprefix('package_training');
		$this->db->select('package_training.*');
		$this->db->from('package_training');
		$this->db->where('package_training.is_admin_deleted !=', '1');
		$this->db->order_by('package_training.id', 'DESC');
		$get = $this->db->get();
		return $get->result_array();
		
	} // End - get_all_active_trainings():
	
	//Function download_csv_file_all_training(): 
	 public function download_csv_file_training($product_id=''){
		 
		$this->load->dbutil();
		
		if($product_id=="all"){
		  
			$qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_training.course_name AS TRAINING, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_training` ON `kod_package_training`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = 'TRAINING'  AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");
		
		} else {
		 
			$qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_training.course_name AS TRAINING, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_training` ON `kod_package_training`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = 'TRAINING' AND `product_id` = '".$product_id."'  AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");
		  
		}//end if($product_id=="all")
	 
		for($i=0; $i<count($count_all_record); $i++){
		  
			$final_arr[$i]['first_name']= $count_all_record[$i]['first_name'];
			$final_arr[$i]['last_name']= $count_all_record[$i]['last_name'];
			$final_arr[$i]['pgd_name']= $count_all_record[$i]['pgd_name'];
			$final_arr[$i]['user_type']= $count_all_record[$i]['user_type'];
			$final_arr[$i]['expiry_date']= $count_all_record[$i]['expiry_date'];
		
		}//end for($i=0; $i<count($count_all_record); $i++)
	  
		$delimiter = ",";
		$newline = "\r\n";
		
		$download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);
		
		return $download_csv;
	  
 	}//end  download_csv_file_all_training($product_id, $product_type)')
	
	
 //show all categoreies and documents against training id
  public function get_training_documents_tree($training_id = '', $category_id = ''){

		  $get_categories = $this->list_all_document_categories($training_id);
		  
		  for($i=0;$i<count($get_categories);$i++){
		
		   $this->db->dbprefix('training_documents');
		   $this->db->select('training_documents.*');
		   $this->db->where('training_documents.course_id',$training_id);
		   
		   if($get_categories[$i]['category_name'] == 'None')
		   	$this->db->where('training_documents.category_id',0);
		   else
			   $this->db->where('training_documents.category_id',$get_categories[$i]['cate_id']);
		   
		   $this->db->where('training_documents.status = 1');
		   $get_result = $this->db->get('training_documents');
		   
		   $documents_result = $get_result->result_array();
		   //echo $this->db->last_query();
		  
		   if($get_categories[$i]['category_name'] != 'None')
			$category_tree[$get_categories[$i]['cate_id'].'#'.$get_categories[$i]['category_name']] = $documents_result;
		   else
			$category_tree[$get_categories[$i]['category_name']] = $documents_result;
		   
		  }//end for($i=0;$i<count($get_org_sop_categories);$i++)
		  
		  return $category_tree;
	  
	 }//end get_training_documents_tree()

}//end file CI_Model (Trainings_mod)
?>