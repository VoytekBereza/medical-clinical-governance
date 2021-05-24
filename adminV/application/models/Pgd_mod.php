<?php
class Pgd_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_subpgd_details($subpgd_id): Get Sub PGD details from subpgd table via sub pgd id
	public function get_subpgd_details($subpgd_id){

		$this->db->dbprefix('pgd_subpgds');
		$this->db->where('id',$subpgd_id);
		$get_user= $this->db->get('pgd_subpgds');
		//echo $this->db->last_query(); 		exit;
		return $get_user->row_array();
		
	}//end get_subpgd_details($subpgd_id)

	//Function get_pgd_details($pgd_id): Get PGD details from pgd table via pgd id
	public function get_pgd_details($pgd_id){

		$this->db->dbprefix('package_pgds');
		$this->db->where('id',$pgd_id);
		$get_user= $this->db->get('package_pgds');
		//echo $this->db->last_query(); 		exit;
		return $get_user->row_array();
		
	}//end get_pgd_details($pgd_id)

	//Function get_pgds_list(): will return the list of Active PGDs according to the type specified, O = Oral, V = Vaccines PGD's 
	public function get_pgd_list($pgd_type = ''){

		$this->db->dbprefix('package_pgds');
		if(!empty($pgd_type)) 
			$this->db->where('pgd_type',$pgd_type);
		$this->db->where('is_admin_deleted','0');	
		$this->db->where('status',1);
		
		$get_user= $this->db->get('package_pgds');
		
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_pgds_list()

	//Function add_new_pgd(): Add new PGD into the database
	public function add_new_pgd($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'pgd_name' => $this->db->escape_str(trim($pgd_name)),
			'info_description' => $this->db->escape_str(trim($info_description)),
			'short_description' => $this->db->escape_str(trim($short_description)),
			'long_description' => $this->db->escape_str(trim($long_description)),
			'pgd_certificate_body' => $this->db->escape_str(trim($pgd_certificate_body)),
			'no_of_quizes' => $this->db->escape_str(trim($no_of_quizes)),
			'is_rechas' => $this->db->escape_str(trim($is_rechas)),
			'pgd_type' => $this->db->escape_str(trim($pgd_type)),
			'meta_title' => $this->db->escape_str(trim($meta_title)),
			'meta_description' => $this->db->escape_str(trim($meta_description)),
			'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
			'price' => $this->db->escape_str(trim($price)),
			'discount_price' => $this->db->escape_str(trim($discount_price)),
			'star_rating' => $this->db->escape_str(trim($star_rating)),
			'pgd_pass_percentage' => $this->db->escape_str(trim($pgd_pass_percentage)),
			'pgd_expiry_months' => $this->db->escape_str(trim($pgd_expiry_months)),
			'pgd_number_of_attempts_allowed' => $this->db->escape_str(trim($pgd_number_of_attempts_allowed)),
			'pgd_reattempt_quiz_hours' => $this->db->escape_str(trim($pgd_reattempt_quiz_hours)),
			'status' => $this->db->escape_str(trim($status))
		);

		$pgd_image_folder_path = '../assets/pgd_images/';
		
		if($pgd_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Uploading PGD Green Image
			if($_FILES['pgd_green_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['pgd_green_image']['name'],'.')),'.'); 			
				$pgd_green_file_name ='pgd_images_green'.rand().'.jpg';
	
				$config_green['upload_path'] = $pgd_image_folder_path;
				$config_green['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config_green['max_size']	= '2000';
				$config_green['overwrite'] = true;
				$config_green['file_name'] = $pgd_green_file_name;
			
				$this->load->library('upload', $config_green);
	
				if(!$this->upload->do_upload('pgd_green_image')){
					$error_file_arr = array('error_upload' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					$ins_data['pgd_green_image'] = $this->db->escape_str(trim($pgd_green_file_name));
					
				}//end if(!$this->upload->do_upload('pgd_green_image'))
				
			}//end if($_FILES['pgd_green_image']['name'] != '')
			
			//Uploading PGD Red Image
			
			if($_FILES['pgd_red_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['pgd_red_image']['name'],'.')),'.'); 			
				$pgd_red_file_name = 'pgd_images_red'.rand().'.jpg';
	
				$config_red['upload_path'] = $pgd_image_folder_path;
				$config_red['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config_red['max_size']	= '2000';
				$config_red['overwrite'] = true;
				$config_red['file_name'] = $pgd_red_file_name;
				
				
				$this->load->library('upload', $config_red);
				$this->upload->initialize($config_red);
	
				if(!$this->upload->do_upload('pgd_red_image')){
					$error_file_arr = array('error_upload' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					$ins_data['pgd_red_image'] = $this->db->escape_str(trim($pgd_red_file_name));
					
				}//end if(!$this->upload->do_upload('pgd_red_image'))
				
			}//end if($_FILES['pgd_red_image']['name'] != '')
			
			
			//Inserting  data into the database. 
			$this->db->dbprefix('package_pgds');
			$ins_into_db = $this->db->insert('package_pgds', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			$created_date = date('Y-m-d H:i:s');
		    $created_by_ip = $this->input->ip_address();
			
			$ins_data_document_cate = array(
			
				'category_name' => $this->db->escape_str(trim('None')),
				'pgd_id' => $this->db->escape_str(trim($last_insert_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_ip' => $this->db->escape_str(trim($created_by_ip)),
				'status' => $this->db->escape_str('1')
			);
			
			$this->db->dbprefix('pgd_documents_category');
			$success = $this->db->insert('pgd_documents_category', $ins_data_document_cate);
			
			if($success)
				return $success;
			else
				return false;			

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Uploading PGD Green Image
			if($_FILES['pgd_green_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['pgd_green_image']['name'],'.')),'.'); 			
				$pgd_green_file_name ='pgd_images_green'.rand().'.jpg';
	
				$config_green['upload_path'] = $pgd_image_folder_path;
				$config_green['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config_green['max_size']	= '2000';
				$config_green['overwrite'] = true;
				$config_green['file_name'] = $pgd_green_file_name;
			
				$this->load->library('upload', $config_green);
	
				if(!$this->upload->do_upload('pgd_green_image')){
					$error_file_arr = array('error_upload' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					$ins_data['pgd_green_image'] = $this->db->escape_str(trim($pgd_green_file_name));
					
					// Unlink image from Folder 	
					$this->db->dbprefix('package_pgds');
					$this->db->select('pgd_green_image');
					$this->db->where('id', $pgd_id);
					$row= $this->db->get('package_pgds')->row_array();
					//echo $training_course_folder_path."".$row['course_image']; exit;
					unlink($pgd_image_folder_path."".$row['pgd_green_image']);
					
				}//end if(!$this->upload->do_upload('pgd_green_image'))
				
			}//end if($_FILES['pgd_green_image']['name'] != '')
			
			//Uploading PGD Red Image
			
			if($_FILES['pgd_red_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['pgd_red_image']['name'],'.')),'.'); 			
				$pgd_red_file_name = 'pgd_images_red'.rand().'.jpg';
	
				$config_red['upload_path'] = $pgd_image_folder_path;
				$config_red['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config_red['max_size']	= '2000';
				$config_red['overwrite'] = true;
				$config_red['file_name'] = $pgd_red_file_name;
				
				
				$this->load->library('upload', $config_red);
				$this->upload->initialize($config_red);
	
				if(!$this->upload->do_upload('pgd_red_image')){
					$error_file_arr = array('error_upload' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					$ins_data['pgd_red_image'] = $this->db->escape_str(trim($pgd_red_file_name));
					
					// Unlink image from Folder 	
					$this->db->dbprefix('package_pgds');
					$this->db->select('pgd_red_image');
					$this->db->where('id', $pgd_id);
					$row= $this->db->get('package_pgds')->row_array();
					//echo $training_course_folder_path."".$row['course_image']; exit;
					unlink($pgd_image_folder_path."".$row['pgd_red_image']);
					
				}//end if(!$this->upload->do_upload('pgd_red_image'))
				
			}//end if($_FILES['pgd_red_image']['name'] != '')
			
			//Inserting  data into the database. 
			$this->db->dbprefix('package_pgds');
			$this->db->where('id',$pgd_id);
			$ins_into_db = $this->db->update('package_pgds', $ins_data);
			
		}//end if($pgd_id == '')
		
		//echo $this->db->last_query(); exit;		
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_pgd($data)

	//Function add_new_subpgd(): Add new Sub PGD into the database
	public function add_new_subpgd($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();

		//Record insert into database
		$ins_data = array(
		
			'subpgd_name' => $this->db->escape_str(trim($subpgd_name)),
			'subpgd_certificate_body' => $this->db->escape_str(trim($subpgd_certificate_body)),
			'status' => $this->db->escape_str(trim($status)),
		);
		
		if($subpgd_id != ''){

			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Update  data into the database. 
			$this->db->dbprefix('pgd_subpgds');
			$this->db->where('id',$subpgd_id);
			$ins_into_db = $this->db->update('pgd_subpgds', $ins_data);
			
		}else{

			$ins_data['pgd_id'] = $this->db->escape_str(trim($pgd_id));
			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Inserting  data into the database. 
			$this->db->dbprefix('pgd_subpgds');
			$ins_into_db = $this->db->insert('pgd_subpgds', $ins_data);
		}
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_new_subpgd($data)
	
	// Start - Rechas
	
	// Start - get_rechas($pgd_id = ''):
	public function get_pgd_rechas($pgd_id = ''){
		
		$this->db->dbprefix('pgd_rechas');
		$this->db->where('pgd_id', $pgd_id);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('pgd_rechas')->result_array();
		
	} // End - get_rechas($pgd_id = ''):
	
	// Start - get_rechas($rechas_id):
	public function get_rechas_by_id($rechas_id){
		
		$this->db->dbprefix('pgd_rechas');
		$this->db->where('id', $rechas_id);
		return $this->db->get('pgd_rechas')->row_array();
		
	} // End - get_rechas($rechas_id):
	
	// Start - add_update_rechas($pgd_id = '', $rechas_id=''):
	public function add_update_rechas($post, $pgd_id, $rechas_id=''){
	
		extract($post);
		
		if($rechas_id != ''){ // Update
		
			$update_data = array(
		
				'rechas_description' => $this->db->escape_str(trim($rechas_description)),
				'rechas_description' => $this->db->escape_str(trim($rechas_description)),
				'rechas_type' => $this->db->escape_str(trim($rechas_type)),
				'status' => $this->db->escape_str(trim($status)),
				'modified_date' => date('Y-m-d H:i:s'),
				'modified_by_ip' => $this->input->ip_address()
			
			);
		
			$this->db->dbprefix('pgd_rechas');
			$this->db->where('id', $rechas_id);
			$true = $this->db->update('pgd_rechas', $update_data);
			
		} else { // Add New
			
			$add_data = array(
				'pgd_id' => $pgd_id,
				'rechas_description' => $this->db->escape_str(trim($rechas_description)),
				'rechas_description' => $this->db->escape_str(trim($rechas_description)),
				'rechas_type' => $this->db->escape_str(trim($rechas_type)),
				'status' => $this->db->escape_str(trim($status)),
				'created_date' => date('Y-m-d H:i:s'),
				'created_ip' => $this->input->ip_address()
			
			);
			
			$this->db->dbprefix('pgd_rechas');
			$true = $this->db->insert('pgd_rechas', $add_data);
			
		} // else -> if($rechas_id != ''):
		
		if($true)
			return true;
		else
			return false;
	
	} // End - add_update_rechas($pgd_id = '', $rechas_id=''):
	
	// Start - delete_rechas($rechas_id):
	public function delete_rechas($rechas_id){
		
		$this->db->dbprefix('pgd_rechas');
		$this->db->where('id', $rechas_id);
		return $this->db->delete('pgd_rechas');
		
	} // End - delete_rechas($rechas_id):
	
	// End - Rechas
	
	// Documents & Videos
	
	// Start - list_all_document_categories():
	public function list_all_document_categories($pgd_id = ''){
		$this->db->dbprefix('pgd_documents_category,package_pgds');
		/*$this->db->select('pgd_documents_category.*,package_pgds.pgd_name');*/
		$this->db->select('pgd_documents_category.id AS cate_id,pgd_documents_category.category_name,pgd_documents_category.pgd_id');
		$this->db->from('pgd_documents_category');
		/*$this->db->join('package_pgds','package_pgds.id=pgd_documents_category.pgd_id','left');*/
		$this->db->where('pgd_documents_category.pgd_id', $pgd_id);
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
	} // End - list_all_document_categories():
	
	// Start - get_pgd_document_category($category_id):
	public function get_pgd_document_category($category_id){
		
		$this->db->dbprefix('pgd_documents_category');
		$this->db->where('id', $category_id);
		return $this->db->get('pgd_documents_category')->row_array();
		
	} // End - get_pgd_document_category($category_id):

	// Start - add_update_category():
	public function add_update_category($post){
		
		extract($post);
		if($action == 'update'){ // Update category
			
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
			$data = array('category_name' => $category_name, 'status' => $status, 'modified_date' => $modified_date, 'modified_by_ip' => $modified_by_ip, 'pgd_id' => $pgd_id);
			
			$this->db->dbprefix('pgd_documents_category');
			$this->db->where('id', $category_id);
			return $this->db->update('pgd_documents_category', $data);
			
		} else if($action == 'add'){ // Insert category
		
			$created_date = date('Y-m-d H:i:s');
			$created_ip = $this->input->ip_address();
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
		
			$data = array('category_name' => $category_name, 'status' => $status, 'created_date' => $created_date, 'created_ip' => $created_ip, 'modified_date' => $modified_date, 'modified_by_ip' => $modified_by_ip, 'pgd_id' => $pgd_id);
		
			return $this->db->insert('pgd_documents_category', $data);
		}
		
	} // End - add_update_category():
	
	// Start - delete_document_category($category_id):
	public function delete_document_category($category_id){
		
		$this->db->dbprefix('pgd_documents');
		$this->db->where('category_id', $category_id);
		$this->db->delete('pgd_documents');
		
		$this->db->dbprefix('pgd_documents_category');
		$this->db->where('id', $category_id);
		return $this->db->delete('pgd_documents_category');
		
	} // // Start - delete_document_category($category_id):
	
	// Start - documents_listing(): List all documents by Training id
	public function documents_listing($pgd_id){
		
		$this->db->dbprefix('package_pgds, pgd_documents_category, pgd_documents');
		$this->db->select('package.pgd_name, category.category_name, doc.*');
		$this->db->from('pgd_documents as doc');
		$this->db->join('pgd_documents_category as category', ' category.id = doc.category_id ', 'inner');
		$this->db->join('package_pgds as package', ' package.id = doc.pgd_id ', 'inner');
		$this->db->where('doc.pgd_id', $pgd_id);
		$this->db->order_by('doc.id', 'DESC');
		
		return $this->db->get()->result_array();
		
	} // end - documents_listing():
	
	// Start - get_rafs_listing(): List all documents by PGD id
	public function get_rafs_listing($pgd_id){
		
		$this->db->dbprefix('pgd_raf');
		$this->db->where('pgd_id', $pgd_id);;
	    $this->db->order_by('id', 'DESC');
		return $this->db->get('pgd_raf')->result_array();
		
	} // end - get_rafs_listing():
	
	// Start - get_all_pgd_document_categories(): Get documents all categories
	public function get_all_pgd_document_categories($pgd_id){
		
		$this->db->dbprefix('pgd_documents_category');
		$this->db->where('pgd_id', $pgd_id);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('pgd_documents_category')->result_array();
		
	} // End - get_all_pgd_document_categories(): Get document categories
	
	// Start - get_pgd_document_by_document_id($document_id): 
	public function get_pgd_document_by_document_id($document_id){
		
		$this->db->dbprefix('pgd_documents');
		$this->db->where('id', $document_id);
		return $this->db->get('pgd_documents')->row_array();
		
	} // End - get_pgd_document_by_document_id($document_id): 
	
	// Start - get_pgd_raf_by_id($document_id): 
	public function get_pgd_raf_by_id($raf_id){
		
		$this->db->dbprefix('pgd_raf');
		$this->db->where('id', $raf_id);
		return $this->db->get('pgd_raf')->row_array();
		
	} // End - get_pgd_raf_by_id($document_id): 
	
	// Start - add_update_rafs($pgd_id = '', $raf_id=''):
	public function add_update_rafs($post, $pgd_id, $raf_id=''){
	
		extract($post);
		
		if($raf_id != ''){ // Update
		
			$update_data = array(
		
				'raf_title' => $raf_title,
				'raf_document_url' => $raf_document_url,
				'status' => $status,
				'modified_date' => date('Y-m-d H:i:s'),
				'modified_by_ip' => $this->input->ip_address()
			
			);
		
			$this->db->dbprefix('pgd_raf');
			$this->db->where('id', $raf_id);
			$true = $this->db->update('pgd_raf', $update_data);
			
		} else { // Add New
			
			$add_data = array(
				'pgd_id' => $pgd_id,
				'raf_title' => $raf_title,
				'raf_document_url' => $raf_document_url,
				'status' => $status,
				'created_date' => date('Y-m-d H:i:s'),
				'created_ip' => $this->input->ip_address()
			
			);
			
			$this->db->dbprefix('pgd_raf');
			$true = $this->db->insert('pgd_raf', $add_data);
			
		} // else -> if($raf_id != ''):
		
		if($true)
			return true;
		else
			return false;
	
	} // End - add_update_rafs($pgd_id = '', $raf_id=''):
	
	// Start - get_all_package_pgd();
	public function get_all_package_pgd(){
		
		$this->db->dbprefix('package_pgds');
		$this->db->where('status',1);
		$this->db->where('is_admin_deleted !=',1);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('package_pgds')->result_array();
		
	} // End - get_all_package_pgd();
	
	// Start - add_update_document(): Add - Edit video
	public function add_update_document($data, $action){
		
		extract($data); // Extract POST data
		
		$created_date = date('Y-m-d H:i:s');
		$created_ip = $this->input->ip_address();
		$modified_date = date('Y-m-d H:i:s');
		$modified_by_ip = $this->input->ip_address();
		
		// Data array to be inserted in data base - Table (pgd_documents)
		$post_data = array(
		
			'pgd_id' 			=> $package_pgd_id,
			'category_id'		=> $category_id,
			'document_title'	=> $document_title,
			'document_url'		=> $document_url,
			'document_icon'		=> $document_icon,
			'status'			=> $status,
			'created_date'		=> $created_date,
			'created_ip'		=> $created_ip,
			'modified_date'		=> $modified_date,
			'modified_by_ip'	=> $modified_by_ip
		);
		
		if($action == 'add'){
			
			// Insert data into db - Table (training_documents)
			$this->db->dbprefix('pgd_documents');
			return $this->db->insert('pgd_documents', $post_data);
			
		}elseif($action == 'update'){
			
			$this->db->dbprefix('pgd_documents');
			$this->db->where('id', $document_id);
			return $this->db->update('pgd_documents', $post_data);
		}
		
	} // End - add_update_document():
	
	// Start - delete_document(): Delete document by id
	public function delete_document($document_id){
		
		$this->db->dbprefix('pgd_documents');
		$this->db->where('id', $document_id);
		
		return $this->db->delete('pgd_documents');
		
	} // End - delete_document():
	
	// Start - delete_rafs(): Delete RAFs by id
	public function delete_rafs($raf_id){
		
		$this->db->dbprefix('pgd_raf');
		$this->db->where('id', $raf_id);
		
		return $this->db->delete('pgd_raf');
		
	} // End - delete_rafs():
	
	// Videos section
	// Start - videos_listing(): List all videos
	public function videos_listing($pgd_id){
		
		$this->db->dbprefix('pgd_videos, package_pgds');
		$this->db->select('pgd.pgd_name, videos.*');
		$this->db->from('pgd_videos as videos');
		$this->db->join('package_pgds as pgd', ' pgd.id =  videos.pgd_id', 'inner');
		$this->db->where('videos.pgd_id', $pgd_id);
		$this->db->where('default_video!=', 1);
		$this->db->order_by('videos.id', 'DESC');
		
		return $this->db->get()->result_array();
		
	} // end - videos_listing(): List all documents by Training id
	
	// Start - videos_intro_listing(): 
	public function videos_intro_listing($pgd_id){
		
		$this->db->dbprefix('pgd_videos, package_pgds');
		$this->db->select('pgd.pgd_name, videos.*');
		$this->db->from('pgd_videos as videos');
		$this->db->join('package_pgds as pgd', ' pgd.id =  videos.pgd_id', 'inner');
		$this->db->where('videos.pgd_id', $pgd_id);
		$this->db->where('default_video', 1);
		$this->db->order_by('videos.id', 'DESC');
		
		return $this->db->get()->result_array();
		
	} // end - videos_intro_listing(): 
	
	// Start - get_pgd_video_by_video_id($video_id): 
	public function get_pgd_video_by_video_id($video_id){
		
		$this->db->dbprefix('pgd_videos');
		$this->db->where('id', $video_id);
		return $this->db->get('pgd_videos')->row_array();
		
	} // End - get_pgd_video_by_video_id($video_id):
	
	// Start - add_update_video(): Add - Edit video
	public function add_update_video($data, $action){
		
		extract($data); // Extract POST data
	
		$created_date = date('Y-m-d H:i:s');
		$created_ip = $this->input->ip_address();
		
		// Data array to be inserted in data base - Table (training_videos)
		$post_data = array(
		
			'pgd_id' 			=> $package_pgd_id,
			'video_title'		=> $video_title,
			'video_url'			=> $video_url,
			'video_id'			=> $video_id_col,
			'default_type'		=> $default_type,
			'default_video'		=> $default_video,
			'status'			=> $status
		);
		
		if($action == 'add'){
			
			$post_data['created_date'] = $this->db->escape_str(trim($created_date));
			$post_data['created_ip'] = $this->db->escape_str(trim($created_ip));
			
			
			if($default_video == '1'){
				
				$zero = array('default_video' => 0);
				$this->db->dbprefix('pgd_videos');
				$this->db->where('default_video', 1);
				$true = $this->db->update('pgd_videos', $zero);

			}
			
			// Insert data into db - Table (training_videos)
			$this->db->dbprefix('pgd_videos');
			return $this->db->insert('pgd_videos', $post_data);
			
		}elseif($action == 'update'){
			
			$post_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$post_data['modified_by_ip'] = $this->db->escape_str(trim($created_ip));
			
			
			if($default_video == '1'){
				
				$zero = array('default_video' => 0);
				$this->db->dbprefix('pgd_videos');
				$this->db->where('default_video', 1);
				$true = $this->db->update('pgd_videos', $zero);

			}
			
			$this->db->dbprefix('pgd_videos');
			$this->db->where('id', $video_id);
			return $this->db->update('pgd_videos', $post_data);
		}
		
	} // End - add_update_video():
	
	// Start - delete_video(): Delete video by id
	public function delete_video($video_id){
		
		$this->db->dbprefix('pgd_videos');
		$this->db->where('id', $video_id);
		
		return $this->db->delete('pgd_videos');
		
	} // End - delete_video():
	
	// Start - set_video_as_default($video_id):
	public function set_video_as_default($video_id){
		
		$zero = array('default_video' => 0);
		
		$this->db->dbprefix('pgd_videos');
		$this->db->where('id !=', $video_id);
		$true = $this->db->update('pgd_videos', $zero);
		
		$one = array('default_video' => 1);
		
		$this->db->dbprefix('pgd_videos');
		$this->db->where('id', $video_id);
		$true = $this->db->update('pgd_videos', $one);
		
		if($true)
			return true;
		else
			return false;
		
	} // End - set_video_as_default($video_id):
	
	/* --------------------------------------------------------------- */
	/* ----------------- Start Quizes Section ------------------------ */
	/* --------------------------------------------------------------- */
	
	// Start - get_pgd_quizes($pgd_id):
	public function get_pgd_quizes($pgd_id){
		
		$this->db->dbprefix('pgd_quizes');
		$this->db->select('id as question_id, question, correct_option_id');
		$this->db->where('pgd_id', $pgd_id);
		$this->db->where('status', 1);
		$this->db->order_by('id', 'DESC');
		$questions = $this->db->get('pgd_quizes')->result_array();
		
		$quizes;
		
		foreach($questions as $key => $question):
			
			$quizes[$key] = $question;
			
			$this->db->dbprefix('pgd_quiz_options');
			$this->db->select('id as option_id, option');
			$this->db->where('quiz_id', $question['question_id']);
			$this->db->where('status', 1);
			$this->db->order_by('id', 'DESC');
			
			$quizes[$key]['options'] = $this->db->get('pgd_quiz_options')->result_array();
			
		endforeach;
		
		return $quizes;
		
	} // End - get_pgd_quizes($pgd_id):
	
	// Start - quiz_by_id(): For the Ajax call in (js/kod_scripts/custom.js)
	public function quiz_by_id($question_id){
		
		$this->db->dbprefix('pgd_quizes');
		$this->db->select('id as question_id, question, correct_option_id');
		$this->db->where('status', 1);
		$this->db->where('id', $question_id);
		$question = $this->db->get('pgd_quizes')->row_array();
		
		$quizes;
		
		$quizes[0] = $question;
		
		$this->db->dbprefix('pgd_quiz_options');
		$this->db->select('id as option_id, option');
		$this->db->where('quiz_id', $question['question_id']);
		$this->db->where('status', 1);
		$this->db->order_by('id', 'DESC');
		
		$quizes[0]['options'] = $this->db->get('pgd_quiz_options')->result_array();
		
		return $quizes;
		
	} // End - quiz_by_id():
	
	// Start - add_update_quiz():
	public function add_update_quiz($post_data, $pgd_id){
		
		extract($post_data);
		
		if($question_id != ''){ // Update Quiz requested
			
			$pgd_quizes_update = array(
			
				//'pgd_id' => $pgd_id,
				'question' => $question,
				'correct_option_id' => $correct_option,
				'status' => 1,
				'modified_date' => date('Y-m-d H:i:s'),
				'modified_by_ip' => $this->input->ip_address()
			);
			
			// Update Question and Correct Answer into the pgd_quizes table
			$this->db->dbprefix('pgd_quizes');
			$this->db->where('id', $question_id);
			$success = $this->db->update('pgd_quizes', $pgd_quizes_update);
			$new_added_quiz_id = $question_id; //$this->db->insert_id();
			
			//////////////////////////////////////////////////////////////
			// Update the Quiz options to the pgd_quiz_options table
			
			$pgd_quiz_options;
			foreach($options as $key => $option):
				
				$pgd_quiz_options = array();
				//if($option != ''){
					
					$this->db->dbprefix('pgd_quiz_options');
					$this->db->where('id', $key);
					$option_exist = $this->db->get('pgd_quiz_options')->row_array();
					
					if($option_exist){ // Update
						
						$pgd_quiz_options = array('option' => $option, 'status' => 1, 'modified_date' => date('Y-m-d H:i:s'), 'modified_by_ip' => $this->input->ip_address());
						$this->db->dbprefix('pgd_quiz_options');
						$this->db->where('id', $key);
						$success = $this->db->update('pgd_quiz_options', $pgd_quiz_options);
						
					} else { // Add new added options
						
						if($option != ''){
						
							$pgd_quiz_options = array('quiz_id' => $question_id, 'option' => $option, 'status' => 1, 'created_date' => date('Y-m-d H:i:s'), 'created_ip' => $this->input->ip_address());
							$this->db->dbprefix('pgd_quiz_options');
							$this->db->insert('pgd_quiz_options', $pgd_quiz_options);
							
							/*
							if($key == $correct_option){
								$correct_option_id = $this->db->insert_id();
							}
							
							// update pgd_quizes for correct option id
							$update_pgd_quizes = array('correct_option_id' => $correct_option_id);
							
							$this->db->dbprefix('pgd_quizes');
							$this->db->where('id', $question_id);
							$success = $this->db->update('pgd_quizes', $update_pgd_quizes);
							*/
							
						}
					}
				//}
				
			endforeach;
			
		} else { // Add Quiz Requested
		
			$pgd_quizes = array(
			
				'pgd_id' => $pgd_id,
				'question' => $question,
				'correct_option_id' => $correct_option,
				'status' => 1,
				'created_date' => date('Y-m-d H:i:s'),
				'created_ip' => $this->input->ip_address()
			);
			
			// Insert Question and Correct Answer into the pgd_quizes table
			$this->db->dbprefix('pgd_quizes');
			$this->db->insert('pgd_quizes', $pgd_quizes);
			$new_added_quiz_id = $this->db->insert_id();
			
			//////////////////////////////////////////////////////////////
			// Insert the Quiz options to the pgd_quiz_options table
			
			$pgd_quiz_options;
			foreach($options as $key => $option):
				
				if($option != ''){
					
					$pgd_quiz_options = array('quiz_id' => $new_added_quiz_id, 'option' => $option, 'status' => 1, 'created_date' => date('Y-m-d H:i:s'), 'created_ip' => $this->input->ip_address());
					$this->db->dbprefix('pgd_quiz_options');
					$success = $this->db->insert('pgd_quiz_options', $pgd_quiz_options);
					
					if($key == $correct_option-1){
						$correct_option_id = $this->db->insert_id();
					}
				}
				
			endforeach;
			
			// update pgd_quizes for correct option id
			$update_pgd_quizes = array('correct_option_id' => $correct_option_id);
			
			$this->db->dbprefix('pgd_quizes');
			$this->db->where('id', $new_added_quiz_id);
			$success = $this->db->update('pgd_quizes', $update_pgd_quizes);
			
		} // else
			
		if($success)
			return true;
		else
			return false;
		
	} // End - add_update_quiz():
	
	// Start - delete_pgd($pgd_id):
	public function delete_pgd($pgd_id){
		
		
		if($pgd_id!=""){
			
			
		/* $this->db->dbprefix('pgd_documents_category');
	     $this->db->where('pgd_id',$pgd_id);
	     $this->db->delete('pgd_documents_category');*/
			
		 $ins_data['is_admin_deleted'] ="1";
		
		//If is_admin_deleted equal 1 it will not showing on admin panel. 
			$this->db->dbprefix('package_pgds');
			$this->db->where('id',$pgd_id);
			$ins_into_db = $this->db->update('package_pgds', $ins_data);
		}
		
		if($ins_into_db)
			return true;
		else
			return false;

		
	} // End - delete_pgd($pgd_id):
	
	// Start - get_all_unauthenticated_pgds(): Get All UnAuthenticated PGDS for listing
	public function get_all_unauthenticated_pgds(){
		
		$where = "(doctor_approval ='0' || pharmacist_approval = '0')";
		
		// Unauthetication Users which is doctor_approval  and pharmacist_approval = 0 and organization id = 0
		$this->db->dbprefix('user_order_details, user_orders, users,package_pgds,usertype,organization');
		
		$this->db->select('user_order_details.*, user_orders.purchase_date,usertype.user_type, users.first_name, users.last_name,users.email_address,package_pgds.pgd_name');
		$this->db->from('user_order_details');
		
		$this->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'inner'); 
		$this->db->join('users', 'user_order_details.user_id = users.id', 'inner'); 
		$this->db->join('package_pgds', 'user_order_details.product_id = package_pgds.id', 'inner'); 
		$this->db->join('usertype', 'users.user_type = usertype.id', 'left'); 
	
		$this->db->where('user_order_details.is_quiz_passed',1);
		$this->db->where('user_order_details.product_type','PGD'); 
		$this->db->where('user_order_details.organization_id IS NULL');
	    $this->db->where($where); 
		
		$this->db->order_by('user_order_details.id', 'DESC');
		
	    $unauthenticated_arr1 = $this->db->get()->result_array();	
		//echo $this->db->last_query(); exit;
		
		// Unauthetication Users which is default doctor and pharmacist = 0 and organization id != '0' and organization.default_doctor ='0' organization.default_pharmacist ='0'
		$this->db->dbprefix('user_order_details, user_orders, users,package_pgds,usertype,organization');
		$this->db->select('user_order_details.*, user_orders.purchase_date,usertype.user_type, users.first_name, users.last_name,users.email_address,package_pgds.pgd_name');
		$this->db->from('user_order_details');
		
		$this->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'inner'); 
		$this->db->join('users', 'user_order_details.user_id = users.id', 'inner'); 
		$this->db->join('package_pgds', 'user_order_details.product_id = package_pgds.id', 'inner'); 
		$this->db->join('usertype', 'users.user_type = usertype.id', 'left');
		$this->db->join('organization', 'user_order_details.organization_id = organization.id', 'inner'); 
		
		
		$this->db->where('user_order_details.is_quiz_passed',1);
		$this->db->where('user_order_details.product_type','PGD'); 
	    $this->db->where($where); 
		$this->db->where('organization.default_doctor IS NULL OR organization.default_doctor = 0');
		$this->db->where('organization.default_pharmacist IS NULL OR organization.default_pharmacist = 0');
		$this->db->where('user_order_details.organization_id IS NOT NULL');
		
		$this->db->order_by('user_order_details.id', 'DESC');
		
	    $unauthenticated_arr2 = $this->db->get()->result_array();	
		
		$unauthenticated = array_merge($unauthenticated_arr1,$unauthenticated_arr2);

		$unauthenticated_final_arr = array();
		for($i=0;$i<count($unauthenticated);$i++){
			
			//$belong_to_organization = $this->organization->verify_if_user_in_organization($unauthenticated[$i]['user_id']);
			
			//echo $unauthenticated[$i]['user_id'];
			
			$get_user_pharmacy_list = $this->organization->get_my_pharmacies_surgeries($unauthenticated[$i]['user_id'], '', '');
			
			//print_this($get_user_pharmacy_list); 
			
			if(count($get_user_pharmacy_list) > 0)
				$unauthenticated_final_arr[] = $unauthenticated[$i];
			
		}//end for($i=0;$i<count($unauthenticated)$i++)

		return $unauthenticated_final_arr;
		//echo $this->db->last_query(); 		exit;
		
	} // get_all_unauthenticated_pgds

	public function get_all_unauthenticated_pgds2(){
		
		$where = "(doctor_approval ='0' || pharmacist_approval = '0')";
		
		// Unauthetication Users which is doctor_approval  and pharmacist_approval = 0 and organization id = 0
		$this->db->dbprefix('user_order_details, user_orders, users,package_pgds, usertype,organization');
		
		$this->db->select('user_order_details.*, user_orders.purchase_date,usertype.user_type, users.first_name, users.last_name,users.email_address, users.password, users.mobile_no, 
							package_pgds.pgd_name, 
							buyinggroups.buying_groups
							');
		$this->db->from('user_order_details');
		
		$this->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'inner'); 
		$this->db->join('users', 'user_order_details.user_id = users.id', 'inner'); 
		$this->db->join('package_pgds', 'user_order_details.product_id = package_pgds.id', 'inner'); 
		$this->db->join('usertype', 'users.user_type = usertype.id', 'left'); 
		$this->db->join('buyinggroups', 'users.buying_group_id = buyinggroups.id', 'left'); 
	
		$this->db->where('user_order_details.is_quiz_passed',1);
		$this->db->where('user_order_details.product_type','PGD'); 
		$this->db->where('user_order_details.organization_id IS NULL');
	    $this->db->where($where); 
		
		$this->db->order_by('user_order_details.id', 'DESC');
		
	    $unauthenticated_arr1 = $this->db->get()->result_array();	
		//echo $this->db->last_query(); exit;
		
		// Unauthetication Users which is default doctor and pharmacist = 0 and organization id != '0' and organization.default_doctor ='0' organization.default_pharmacist ='0'
		$this->db->dbprefix('user_order_details, user_orders, users,package_pgds,usertype,organization');
		$this->db->select('user_order_details.*, user_orders.purchase_date,usertype.user_type, users.first_name, users.last_name,users.email_address,
							buyinggroups.buying_groups,
							package_pgds.pgd_name');
							
		$this->db->from('user_order_details');
		
		$this->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'inner'); 
		$this->db->join('users', 'user_order_details.user_id = users.id', 'inner'); 
		$this->db->join('package_pgds', 'user_order_details.product_id = package_pgds.id', 'inner'); 
		$this->db->join('usertype', 'users.user_type = usertype.id', 'left');
		$this->db->join('organization', 'user_order_details.organization_id = organization.id', 'inner'); 
		$this->db->join('buyinggroups', 'users.buying_group_id = buyinggroups.id', 'left'); 
		
		
		$this->db->where('user_order_details.is_quiz_passed',1);
		$this->db->where('user_order_details.product_type','PGD'); 
	    $this->db->where($where); 
		$this->db->where('organization.default_doctor','0');
		$this->db->where('organization.default_pharmacist','0');
		$this->db->where('user_order_details.organization_id IS NOT NULL');
		
		$this->db->order_by('user_order_details.id', 'DESC');
		
	    $unauthenticated_arr2 = $this->db->get()->result_array();	
		
		$unauthenticated = array_merge($unauthenticated_arr1,$unauthenticated_arr2);
		
		$unauthenticated_final_arr = array();
		for($i=0;$i<count($unauthenticated);$i++){
			
			$belong_to_organization = $this->organization->verify_if_user_in_organization($unauthenticated[$i]['user_id']);
			
			//$get_user_pharmacy_list = $this->organization->get_my_pharmacies_surgeries( $user_id, '', '');
			
			if(!$belong_to_organization)
				$unauthenticated_final_arr[] = $unauthenticated[$i];
			
		}//end for($i=0;$i<count($unauthenticated)$i++)
		
		return $unauthenticated_final_arr;
		//echo $this->db->last_query(); 		exit;
		
	} // get_all_unauthenticated_pgds

	//Function get_recent_product_purchased(): Will return tthe array of most recently the product which was purchased.
	public function get_recent_product_purchased($product_id, $product_type, $user_id = ''){

		$this->db->dbprefix('user_order_details');
		if(trim($user_id) != '')  $this->db->where('user_id',$user_id);
		
		$this->db->where('product_type',$product_type);
		$this->db->where('product_id',$product_id);
		$get = $this->db->get('user_order_details');
		
		return $get->row_array();
		
	}//end get_recent_product_purchased($product_id, $product_type, $user_id = '')
	
	// Function Start unauthenticate_pgds
	public function unauthenticate_pgds($data){
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();

		 $arr_val = $data['unauthenticated_pgd']; 
		 
		 foreach($arr_val as $id){
			 
			 $this->db->dbprefix('user_order_details','package_pgds');
			 $this->db->select('user_order_details.id, user_order_details.product_id ,user_order_details.product_type, package_pgds.pgd_expiry_months, package_pgds.pgd_name,  package_pgds.pgd_type, user_order_details.doctor_approval, user_order_details.pharmacist_approval, package_pgds.seasonal_travel, package_pgds.is_child, user_order_details.expiry_date, user_order_details.user_id,
			 users.first_name, users.last_name, users.email_address');
			 $this->db->from('user_order_details');
			 $this->db->join('package_pgds','user_order_details.product_id=package_pgds.id');
			 $this->db->join('users','user_order_details.user_id=users.id');
			 $this->db->where('user_order_details.id',$id);
		     $db_expiry = $this->db->get()->row_array();
			 
         	 $current_date = date('Y-m-d'); // This Date
			 $db_expiry_month = $db_expiry['pgd_expiry_months'];
			 $expiry_date = date('Y-m-d', strtotime("+$db_expiry_month month", strtotime($current_date)));
			
			 // Get Default User id of Doctor
			 $this->db->dbprefix('users');
			 $this->db->select('id,is_default,user_type');
			 $this->db->from('users');
			 $this->db->where('is_default',1);
			 $this->db->where('user_type',1);
		     $default_users_doc_id= $this->db->get()->row_array();
			 
			 // Get Default User id of Pharmacist
			 $this->db->dbprefix('users');
			 $this->db->select('id,is_default,user_type');
			 $this->db->from('users');
			 $this->db->where('is_default',1);
			 $this->db->where('user_type',2);
		     $default_users_phar_id= $this->db->get()->row_array();
			 
			 $ins_data['doctor_approval'] = 1;
			 $ins_data['pharmacist_approval'] = 1;
			 
			if(!$db_expiry['is_child']){
				
				 $ins_data['expiry_date'] = $expiry_date;
				 $ins_data['implementation_date']= date('Y-m-d G:i:s');
				 
			}//end if(!$db_expiry['is_child'])
			
			 $ins_data['approvedby_doctor_id'] = $default_users_doc_id['id'];
		     $ins_data['approvedby_pharmacist_id'] = $default_users_phar_id['id'];
			 $ins_data['doctor_approval_date'] = date('Y-m-d H:i:s');
			 $ins_data['pharmacist_approval_date']= date('Y-m-d H:i:s');
			 
			 $ins_data['approved_by_default']= 1;
			 
			 if($default_users_doc_id['id']!="" && $default_users_phar_id['id']!="") {
				 
				$get_active_cqc_set = $this->users->get_all_list_cqc_set('1','1');
				$ins_data['cqc_set_id'] = $get_active_cqc_set['id'];

				$this->db->dbprefix('user_order_details');
				$this->db->where('id',$id);
				$ins_into_db = $this->db->update('user_order_details', $ins_data);

				//Selected PGD is Either Travel or Seasonal, its time to set the expiry of all grouped vaccines to be same as the selected one.
				$upd_data = array('expiry_date' => $ins_data['expiry_date'],
									'implementation_date' => date('Y-m-d G:i:s'),
									'approval_ip' => $this->input->ip_address()
								);

				//Updating Log
				$ins_log_data = array(
						'order_detail_id' => $id,
						'pgd_id' => $db_expiry['product_id'],
						'user_id' => $db_expiry['user_id'],
						'authenticated_doctor_id' => $default_users_doc_id['id'],
						'authenticated_pharmacist_id' => $default_users_phar_id['id'],
						'created_date' => $created_date,
						'created_by_ip' => $created_by_ip 
					);

				//Inserting  data into the database. 
				$this->db->dbprefix('authentication_log');
				$ins_into_db = $this->db->insert('authentication_log', $ins_log_data);
				
				$user_first_last_name = filter_string($db_expiry['first_name']).' '.filter_string($db_expiry['last_name']);
				$search_arr = array('[FIRST_LAST_NAME]','[PGD_NAME]','[AUTHENTICATED_DATE]');
				$replace_arr = array($user_first_last_name, filter_string($db_expiry['pgd_name']) , date('d/m/Y g:i:s')); 
				
				$this->load->model('email_mod','email_template');
				
				$email_body_arr = $this->email_template->get_email_template(25);
				
				$email_subject = $email_body_arr['email_subject'];
				
				$email_body = $email_body_arr['email_body'];
				$email_body = str_replace($search_arr,$replace_arr,$email_body);
				
				$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
				$noreply_email = get_global_settings($NOREPLY_EMAIL);
				
				$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
				$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
				
				$from = filter_string($noreply_email['setting_value']);
				$from_name = filter_string($email_from_txt['setting_value']);
				$to = filter_string($db_expiry['email_address']);
				$subject = filter_string($email_subject);
				$email_body = filter_string($email_body);
				
				//$to = 'twister787@gmail.com';
				$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, '');
				
			} // if condition
			
		}// end foreach loop
		
		if($ins_into_db )
			return true;
		else
			return false;
		
	} // // Function End unauthenticate_pgds ();
	
	// Function Start get_defualt_doc_signature();
	public function get_defualt_doc_signature() {
			
			$this->db->dbprefix('users');
			$this->db->where('is_default', 1);
			$this->db->where("(signature_image IS NOT NULL OR signature_svn IS NOT NULL)");
		    return	$this->db->get('users')->result_array();
	} // get_defualt_doc_signature();

	// count - count_all_active_pgds(): Get all active pgds for listing
	public function count_all_active_pgds(){
		
		$this->db->dbprefix('user_order_details,users');
		$this->db->select('COUNT(product_id) as total');
		$this->db->from('user_order_details');
		$this->db->join('users', 'users.id = user_order_details.user_id', 'inner');
		$this->db->where('user_order_details.product_type ',"PGD");
		$this->db->where("(expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')"); //Is not Expired
		
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
		
	} // End - count_all_active_pgds():
	
	//Function download_csv_file_all_pgds(): 
	 public function download_csv_file_all_pgds($product_type){
		 
		$this->load->dbutil();
	  
		$qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_pgds.pgd_name AS PGD_NAME, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_pgds` ON `kod_package_pgds`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = '".$product_type."'  AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");
	 
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
	  
 	}//end  download_csv_file_all_pgds($product_type)')
	
	 // get_all_active_pdgs
	 public function get_all_active_pdgs(){
		 
		$this->db->dbprefix('kod_package_pgds');
		$this->db->from('kod_package_pgds');
		$this->db->where('kod_package_pgds.is_admin_deleted !=', 1);
		
		return $query = $this->db->get()->result_array();	
		
	 }// get_all_active_pdgs()
	
	 //Function download_single_pgd_csv(): 
	 public function download_single_pgd_csv($product_id, $product_type){
		 
	  $this->load->dbutil();
	
	   $qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_pgds.pgd_name AS PGD_NAME, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_pgds` ON `kod_package_pgds`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = '".$product_type."' AND `product_id` = '".$product_id."'  AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");
	 
	  
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
	  
 	}//end  download_single_pgd_csv($product_id, $product_type)')
	
	//show all categoreies and documents against pgd id
   public function get_pgd_documents_tree($pgd_id = '', $category_id = ''){

		  $get_categories = $this->list_all_document_categories($pgd_id);
	
		  for($i=0;$i<count($get_categories);$i++){
		
		   $this->db->dbprefix('pgd_documents');
		   $this->db->select('pgd_documents.*');
		   $this->db->where('pgd_documents.pgd_id',$pgd_id);
		  
		   if($get_categories[$i]['category_name'] == 'None')
		   	$this->db->where('pgd_documents.category_id',0);
		   else
			    $this->db->where('pgd_documents.category_id',$get_categories[$i]['cate_id']);
		   
		   $this->db->where('pgd_documents.status = 1');
		   $get_result = $this->db->get('pgd_documents');
		   
		   $documents_result = $get_result->result_array();
		  // echo $this->db->last_query(); exit;
		  
		   if($get_categories[$i]['category_name'] != 'None')
			$category_tree[$get_categories[$i]['cate_id'].'#'.$get_categories[$i]['category_name']] = $documents_result;
		   else
			$category_tree[$get_categories[$i]['category_name']] = $documents_result;
		   
		  }//end for($i=0;$i<count($get_org_sop_categories);$i++)
		  
		  return $category_tree;
	  
	 }//end get_training_documents_tree()

	//Function get_authenticated_pgd_log() This function returs the complet oof of thse pdgs authenticated by admin
	public function get_authenticated_pgd_log(){

		$this->db->dbprefix('authentication_log');
		
		$this->db->select('authentication_log.*, users.first_name, users.last_name, package_pgds.pgd_name, usertype.user_type,
							doctor_user.first_name AS doctor_first_name, doctor_user.last_name AS doctor_last_name,
							pharmacist_user.first_name as pharmacist_first_name, pharmacist_user.last_name as pharmacist_last_name
						');
		$this->db->join('users','authentication_log.user_id = users.id','left');
		
		$this->db->join('users AS doctor_user','authentication_log.authenticated_doctor_id = doctor_user.id','left');
		$this->db->join('users AS pharmacist_user','authentication_log.authenticated_pharmacist_id = pharmacist_user.id','left');
		
		$this->db->join('package_pgds','authentication_log.pgd_id = package_pgds.id','left');
		$this->db->join('usertype','usertype.id = users.user_type','left');
		
		$this->db->order_by('id', 'DESC');
		$get_log = $this->db->get('authentication_log');
		//echo $this->db->last_query(); 		exit;
		return $get_log->result_array();
		
	}//end get_authenticated_pgd_log()

}//end file
?>