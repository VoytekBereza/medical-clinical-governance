<?php
class Medicine_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	/***************************************************************
	* Medicine Category Add Update Listing And Delete Function Start 
	****************************************************************/
	
	//Function add_update_medicine_category(): Add new Medicine Catetgory into the database
	public function add_update_medicine_category($data){
		
		extract($data);
		$generate_seo_url = $this->common->generate_seo_url($category_title);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'category_title' => $this->db->escape_str(trim($category_title)),
			'category_subtitle' => $this->db->escape_str(trim($category_subtitle)),
			'raf_title' => $this->db->escape_str(trim($raf_title)),
			'description' => $this->db->escape_str(trim($description)),
			'long_description' => $this->db->escape_str(trim($long_description)),
			'meta_title' => $this->db->escape_str(trim($meta_title)),
			'meta_description' => $this->db->escape_str(trim($meta_description)),
			'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
			'parent_category_id' => $this->db->escape_str(trim($parent_category_id)),
			'show_online' => $this->db->escape_str(trim($show_online)),
			'show_popular' => $this->db->escape_str(trim($show_popular)),
			'status' => $this->db->escape_str(trim($status))
		);
		
		//Uploading category_image Image
		if($_FILES['category_image']['name'] != ''){
			
			$medicine_category_folder_path = '../assets/medicine_category_images/';
			
			//echo $name = $_FILES['category_image']['name'];
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['category_image']['name'],'.')),'.'); 	
			$medicine_category_file_name = 	'medicine_category_'.rand().'.jpg';
			
			$config['upload_path'] = $medicine_category_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '2000';
			$config['overwrite'] = true;
			$config['file_name'] = $medicine_category_file_name;
		
			$this->load->library('upload', $config);
            
			if(!$this->upload->do_upload('category_image')){
				$error_file_arr = array('error_upload' => $this->upload->display_errors());
			    return false;
				
			}else{
			
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				$ins_data['category_image'] = $this->db->escape_str(trim($medicine_category_file_name));
				
				//Creating Thumbmail 450 
                //Uploading is successful now resizing the uploaded image
                $config_medicine_category['image_library'] = 'gd2';
                $config_medicine_category['source_image'] = $medicine_category_folder_path.$medicine_category_file_name;
                $config_medicine_category['new_image'] = $medicine_category_folder_path.'thumb-'.$medicine_category_file_name;
                $config_medicine_category['create_thumb'] = TRUE;
                $config_medicine_category['thumb_marker'] = '';
               
                $config_medicine_category['maintain_ratio'] = TRUE;
                $config_medicine_category['width'] = 450;
               
                $this->load->library('image_lib');
                $this->image_lib->initialize($config_medicine_category);
                $this->image_lib->resize();
                $this->image_lib->clear();
				
				//Creating Thumbmail 250 * 160
                //Uploading is successful now resizing the uploaded image
                $config_medicine_category_thumb['image_library'] = 'gd2';
                $config_medicine_category_thumb['source_image'] = $medicine_category_folder_path.$medicine_category_file_name;
                $config_medicine_category_thumb['new_image'] = $medicine_category_folder_path.'thumb-small'.$medicine_category_file_name;
                $config_medicine_category_thumb['create_thumb'] = TRUE;
                $config_medicine_category_thumb['thumb_marker'] = '';
               
                $config_medicine_category_thumb['maintain_ratio'] = TRUE;
                $config_medicine_category_thumb['width'] = 250;
				$config_medicine_category_thumb['height'] = 160;
               
                $this->load->library('image_lib');
                $this->image_lib->initialize($config_medicine_category_thumb);
                $this->image_lib->resize();
                $this->image_lib->clear();
			 
				// Unlink image from Folder 	
				if($category_id!=""){
					$this->db->dbprefix('medicine_categories');
					$this->db->select('category_image');
					$this->db->where('id', $category_id);
					$row= $this->db->get('medicine_categories')->row_array();
					unlink($medicine_category_folder_path."".$row['category_image']);
					unlink($medicine_category_folder_path."thumb-".$row['category_image']);
				}
				
			}//end if(!$this->upload->do_upload('category_image'))
			
		}//end if($_FILES['category_image']['name'] != '')
		
		if($category_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Inserting  data into the database. 
			$this->db->dbprefix('medicine_categories');
			$ins_into_db = $this->db->insert('medicine_categories', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			$verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'medicine_categories','url_slug',$last_insert_id);
			$ins_data_url['url_slug'] = $this->db->escape_str(trim($verified_seo_url));
			
			//update  data into the database. 
			$this->db->dbprefix('medicine_categories');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('medicine_categories', $ins_data_url);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			 $verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'medicine_categories','url_slug',$category_id);
			 $ins_data['url_slug'] = $this->db->escape_str(trim($verified_seo_url));

			//update  data into the database. 
			$this->db->dbprefix('medicine_categories');
			$this->db->where('id',$category_id);
			$ins_into_db = $this->db->update('medicine_categories', $ins_data);
			
		}//end if($category_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_medicine_category($data)
	
	// Start - get_all_medicine_category(): Get all Medicine Category for listing
	public function get_all_medicine_category(){
		$this->db->dbprefix('medicine_categories,medicine_parent_categories');
		$this->db->select('medicine_categories.*,medicine_parent_categories.category_name');
		$this->db->from('medicine_categories');
		$this->db->join('medicine_parent_categories','medicine_categories.parent_category_id=medicine_parent_categories.id','inner');
		$this->db->order_by('medicine_categories.id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_medicine_category():
	
	//Function get_medicine_category_details($category_id): Get Medicine Category details
	public function get_medicine_category_details($category_id){

		$this->db->dbprefix('medicine_categories');
		$this->db->where('id',$category_id);
		$get_page= $this->db->get('medicine_categories');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end medicine_categories($category_id)
	
	//Function delete_medicine_category(): Delete Medicine Category from  database
	public function delete_medicine_category($category_id){
		
		// Delete medicine category images from folder
		$medicine_category_folder_path = '../assets/medicine_category_images/';
		
		$this->db->dbprefix('medicine_categories');
		$this->db->select('category_image');
		$this->db->where('id', $category_id);
		$row= $this->db->get('medicine_categories')->row_array();
		
		unlink($medicine_category_folder_path."".$row['category_image']);
		unlink($medicine_category_folder_path."thumb-".$row['category_image']);
		unlink($medicine_category_folder_path."thumb-small".$row['category_image']);
		
		
		$this->db->dbprefix('medicine_categories_raf');
		$this->db->where('med_category_id',$category_id);
		$get_page = $this->db->delete('medicine_categories_raf');
		
		$this->db->dbprefix('medicine_categories');
		$this->db->where('id',$category_id);
		$get_page = $this->db->delete('medicine_categories');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_medicine_category($category_id)
	
	//get all parent category listing parent_category_list
	public function parent_category_list(){
		
		$this->db->dbprefix('medicine_parent_categories');
		$this->db->from('medicine_parent_categories');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	}// end parent_category_list
	
	/***************************************************************
	* End Medicine Category Add Update Listing And Delete Function 
	****************************************************************/
	
	/***************************************************************
	* Medicine Add Update Listing And Delete Function Start 
	****************************************************************/
	
	//Function add_update_medicine(): Add update Medicine into the database
	public function add_update_medicine($data){
		
		extract($data);
		$generate_seo_url = $this->common->generate_seo_url($medicine_name);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
			
		//Record insert into database
		$ins_data = array(
		
			'brand_name' => $this->db->escape_str(trim($brand_name)),
			'medicine_name' => $this->db->escape_str(trim($medicine_name)),
			'suggested_dose' => $this->db->escape_str(trim($suggested_dose)),
			'branded_more_info' => $this->db->escape_str(trim($branded_more_info)),
			'strength_more_info' => $this->db->escape_str(trim($strength_more_info)),
			'description' => $this->db->escape_str(trim($description)),
			'short_description' => $this->db->escape_str(trim($short_description)),
			'meta_title' => $this->db->escape_str(trim($meta_title)),
			'meta_description' => $this->db->escape_str(trim($meta_description)),
			'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
			'category_id' => $this->db->escape_str(trim($category_id)),
			'medicine_form_id' => $this->db->escape_str(trim($medicine_form_id)),
			'medicine_class' => $this->db->escape_str(trim($medicine_class)),
			'legal_category' => $this->db->escape_str(trim($legal_category)),
			'is_branded' => $this->db->escape_str(trim($is_branded)),
			'status' => $this->db->escape_str(trim($status))
		);
		
		//Uploading images_src Image
		if($_FILES['images_src']['name'] != ''){
			
			$medicine_folder_path = '../assets/medicine_images/';
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['images_src']['name'],'.')),'.'); 			
			$medicine_file_name = 	'medicine_'.rand().'.jpg';
			

			$config['upload_path'] = $medicine_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '2000';
			$config['overwrite'] = true;
			$config['file_name'] = $medicine_file_name;
		
			$this->load->library('upload', $config);
            
			if(!$this->upload->do_upload('images_src')){
				$error_file_arr = array('error_upload' => $this->upload->display_errors());
			    return false;
				
			}else{
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				$ins_data['images_src'] = $this->db->escape_str(trim($medicine_file_name));
				
				//Creating Thumbmail 400 * 300
                //Uploading is successful now resizing the uploaded image
                $config_medicine['image_library'] = 'gd2';
                $config_medicine['source_image'] = $medicine_folder_path.$medicine_file_name;
                $config_medicine['new_image'] = $medicine_folder_path.'thumb-'.$medicine_file_name;
                $config_medicine['create_thumb'] = TRUE;
                $config_medicine['thumb_marker'] = '';
               
                $config_medicine['maintain_ratio'] = TRUE;
                $config_medicine['width'] = 400;
                $config_medicine['height'] = 300;
               
                $this->load->library('image_lib');
                $this->image_lib->initialize($config_medicine);
                $this->image_lib->resize();
                $this->image_lib->clear();
			 
				// Unlink image from Folder 	
				if($medicine_id!=""){
					$this->db->dbprefix('medicine');
					$this->db->select('images_src');
					$this->db->where('id', $medicine_id);
					$row= $this->db->get('medicine')->row_array();
					unlink($medicine_folder_path."".$row['images_src']);
					unlink($medicine_folder_path."thumb-".$row['images_src']);
				}
				
			}//end if(!$this->upload->do_upload('images_src'))
			
		}//end if($_FILES['images_src']['name'] != '')
		
		if($medicine_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			if($merge_with_medicine_id!=""){
			    $ins_data['merge_with_medicine_id'] = $merge_with_medicine_id;
			}	
			
			//Inserting  data into the database. 
			$this->db->dbprefix('medicine');
			$ins_into_db = $this->db->insert('medicine', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			$verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'medicine','url_slug',$last_insert_id);
			$ins_data_url['url_slug'] = $this->db->escape_str(trim($verified_seo_url));
			
			//update  data into the database. 
			$this->db->dbprefix('medicine');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('medicine', $ins_data_url);
			
			/*****************ADD STRENGHT********************/
		   
		   $total_count = count($strength);
		   
		   if(!empty($strength)){
				for($i=0;$i<$total_count; $i++){
	
					$ins_data_st = array(
					
						'strength' => $this->db->escape_str(trim($strength[$i])),
						'per_price' => $this->db->escape_str(trim($per_price[$i])),
						'strength_value' => $this->db->escape_str(trim($strength_value[$i])),
						'medicine_id' => $this->db->escape_str(trim($last_insert_id)),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database. 
					
					// if not empty
					if($strength[$i]!=""){
					
					$this->db->dbprefix('medicine_strength');
					$ins_into_st = $this->db->insert('medicine_strength', $ins_data_st);
					
					}// end	if($strength[$i]!="")
		
				}// End for Loop
		   } // End if
			
			/******************END STRENGHT******************************/
			
			/*****************ADD Quantity********************/
		
			$total_count_quantity = count($quantity);
			
		    if(!empty($quantity)){
				for($i=0;$i<$total_count_quantity; $i++){
			
					$ins_data_qt = array(
					
						'quantity' => $this->db->escape_str(trim($quantity[$i])),
						'quantity_txt' => $this->db->escape_str(trim($quantity_txt[$i])),
						'discount_precentage' => $this->db->escape_str(trim($discount_precentage[$i])),
						'medicine_id' => $this->db->escape_str(trim($last_insert_id)),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database. 
					
					// if not empty
					if($quantity[$i]!=""){
						$this->db->dbprefix('medicine_quantity');
						$ins_into_st = $this->db->insert('medicine_quantity', $ins_data_qt);
					}// end	if($strength[$i]!="") 
				} // End for Loop
		   }// End if
			
			/******************END Quantity******************************/

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			if($merge_with_medicine_id!=""){
			    $ins_data['merge_with_medicine_id'] = $merge_with_medicine_id;
			}	
			
			 $verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'medicine','url_slug',$medicine_id);
			 $ins_data['url_slug'] = $this->db->escape_str(trim($verified_seo_url));

			//update  data into the database. 
			$this->db->dbprefix('medicine');
			$this->db->where('id',$medicine_id);
			$ins_into_db = $this->db->update('medicine', $ins_data);
			
			/*****************Update STRENGHT********************/
		   
		   $total_count = count($strength);
		   
		
		   $total_count_strength_edit = count($strength_edit);
		   
		   if($total_count >0){ 
				for($i=0;$i<$total_count; $i++){
				
					$update_data_st = array(
					
						'strength' => $this->db->escape_str(trim($strength[$i])),
						'per_price' => $this->db->escape_str(trim($per_price[$i])),
						'strength_value' => $this->db->escape_str(trim($strength_value[$i])),
						'modified_date' => $this->db->escape_str(trim($created_date)),
						'modified_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database. 
					
					// if not empty
					if($strength_id[$i]!=""){
						$this->db->dbprefix('medicine_strength');
						$this->db->where('medicine_id',$medicine_id);
						$this->db->where('id',$strength_id[$i]);
						$ins_into_st = $this->db->update('medicine_strength', $update_data_st);
					} else {
						
						$ins_data_st = array(
							'strength' => $this->db->escape_str(trim($strength[$i])),
							'per_price' => $this->db->escape_str(trim($per_price[$i])),
							'strength_value' => $this->db->escape_str(trim($strength_value[$i])),
							'medicine_id' => $this->db->escape_str(trim($medicine_id)),
							'created_date' => $this->db->escape_str(trim($created_date)),
							'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					    );
						
						$this->db->dbprefix('medicine_strength');
						$ins_into_st = $this->db->insert('medicine_strength', $ins_data_st);
					}
				}// End for Loop
		   } // End if
		   
		   
		    if($total_count_strength_edit >0){
				for($i=0;$i<$total_count_strength_edit; $i++){
	
					$ins_data_st = array(
					
						'strength' => $this->db->escape_str(trim($strength_edit[$i])),
						'per_price' => $this->db->escape_str(trim($per_price_edit[$i])),
						'strength_value' => $this->db->escape_str(trim($strength_value_edit[$i])),
						'medicine_id' => $this->db->escape_str(trim($medicine_id)),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database. 
					
					// if not empty
					if($strength_edit[$i]!=""){
						$this->db->dbprefix('medicine_strength');
						$ins_into_st = $this->db->insert('medicine_strength', $ins_data_st);
					}// end $strength_edit[$i]
		
				}// End for Loop
		   } // End if
			
			/******************END STRENGHT******************************/
			
			/*****************ADD Update Quantity ********************/
				
			$total_count_quantity = count($quantity);
			$total_count_quantity_edit = count($quantity_edit);
			
		    if($total_count_quantity >0){
				for($i=0;$i<$total_count_quantity; $i++){
			
					$update_data_qt = array(
					
						'quantity' => $this->db->escape_str(trim($quantity[$i])),
						'quantity_txt' => $this->db->escape_str(trim($quantity_txt[$i])),
						'discount_precentage' => $this->db->escape_str(trim($discount_precentage[$i])),
						'modified_date' => $this->db->escape_str(trim($created_date)),
						'modified_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database. 
					
					// if not empty
					if($quantity_id[$i]!=""){
						
							$this->db->dbprefix('medicine_quantity');
							$this->db->where('medicine_id',$medicine_id);
							$this->db->where('id',$quantity_id[$i]);
							$update_into_qt = $this->db->update('medicine_quantity', $update_data_qt);
					
					} else {
						
						   $ins_data_qt = array(
							'quantity' => $this->db->escape_str(trim($quantity[$i])),
							'quantity_txt' => $this->db->escape_str(trim($quantity_txt[$i])),
							'discount_precentage' => $this->db->escape_str(trim($discount_precentage[$i])),
							'medicine_id' => $this->db->escape_str(trim($medicine_id)),
							'created_date' => $this->db->escape_str(trim($created_date)),
							'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
						 );
						
					   //Inserting  data into the database. 
						$this->db->dbprefix('medicine_quantity');
						$ins_into_qt = $this->db->insert('medicine_quantity', $ins_data_qt);
					
					} // end else
				} // End for Loop
		   }// End if
		   
		    if($total_count_quantity_edit >0){
				for($i=0;$i<$total_count_quantity_edit; $i++){
			
					$ins_data_qt = array(
					
						'quantity' => $this->db->escape_str(trim($quantity_edit[$i])),
						'quantity_txt' => $this->db->escape_str(trim($quantity_txt_edit[$i])),
						'discount_precentage' => $this->db->escape_str(trim($discount_precentage_edit[$i])),
						'medicine_id' => $this->db->escape_str(trim($medicine_id)),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database.
					
					// if not empty 
					if($quantity_edit[$i]!="") {
						$this->db->dbprefix('medicine_quantity');
				    	$ins_into_qt = $this->db->insert('medicine_quantity', $ins_data_qt);
					}// end if($quantity_edit[$i]!="")
				} // End for Loop
		   }// End if
			
			/******************END Quantity******************************/

			
		}//end if($category_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_medicine($data)
	
	// Start - get_all_medicine(): Get all Medicine for listing
	public function get_all_medicine(){
		$this->db->dbprefix('medicine,medicine_categories');
		$this->db->select('medicine.*,medicine_categories.category_title');
		$this->db->from('medicine');
		$this->db->join('medicine_categories','medicine.category_id=medicine_categories.id','inner');
		$this->db->order_by('medicine.id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_medicine():\
	
	// Start - get_all_medicine_strength(): Get all Medicine for listing
	public function get_all_medicine_strength(){
		
		$this->db->dbprefix('medicine,medicine_strength');
		$this->db->select('medicine.id,medicine_strength.strength,medicine_strength.per_price');
		$this->db->from('medicine');
		$this->db->join('medicine_strength','medicine.id=medicine_strength.medicine_id','inner');
		$this->db->order_by('medicine.id', 'DESC');
		$success = $this->db->get()->result_array();

		if($success)
			return $success;
		else 
			return false;	
		
	} // End - get_all_medicine_strength():
	
	
	// Start - get_all_medicine_quantity(): Get all Medicine Quantity for listing
	public function get_all_medicine_quantity(){
		
		$this->db->dbprefix('medicine,medicine_quantity');
		$this->db->select('medicine.id,medicine_quantity.quantity');
		$this->db->from('medicine');
		$this->db->join('medicine_quantity','medicine.id=medicine_quantity.medicine_id','inner');
		$this->db->order_by('medicine.id', 'DESC');
		$success = $this->db->get()->result_array();

		if($success)
			return $success;
		else 
			return false;	
		
	} // End - get_all_medicine_strength():
	
	//Function get_medicine_details($medicine_id): Get Medicine details
	public function get_medicine_details($medicine_id){

		$this->db->dbprefix('medicine');
		$this->db->select('medicine.*');
		$this->db->from('medicine');
		$this->db->where('medicine.id',$medicine_id);
		return $get_page= $this->db->get()->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_medicine_details($medicine_id)
	
	// Get Medicine Strenght
	public function get_medicine_strength_details($medicine_id){
	
		$this->db->dbprefix('medicine_strength');
		$this->db->select('medicine_strength.*');
		$this->db->from('medicine_strength');
		$this->db->where('medicine_id',$medicine_id);
		return $get_st= $this->db->get()->result_array();
	
	}// End Medicine Strenght

	// Get Medicine Quantity
	public function get_medicine_quantity_details($medicine_id){
	
		$this->db->dbprefix('medicine_quantity');
		$this->db->select('medicine_quantity.*');
		$this->db->from('medicine_quantity');
		$this->db->where('medicine_id',$medicine_id);
		return $get_qty= $this->db->get()->result_array();
	
	}// End Medicine Quantity
	
	//Function delete_medicine(): Delete Medicine from  database
	public function delete_medicine($medicine_id){
		
		// Delete medicine category images from folder
		/* $medicine_folder_path = '../assets/medicine_images/';
		
		$this->db->dbprefix('medicine');
		$this->db->select('images_src');
		$this->db->where('id', $medicine_id);
		$row= $this->db->get('medicine')->row_array();
		
		if($row['images_src']!=""){
			unlink($medicine_folder_path."".$row['images_src']);
			unlink($medicine_folder_path."thumb-".$row['images_src']);
		}
		
		$this->db->dbprefix('patient_order_details');
		$this->db->select('order_id');
		$this->db->where('medicine_id', $medicine_id);
		$row_order_id= $this->db->get('patient_order_details')->row_array();
		
		if($row_order_id['order_id'] != ''){
			
		$this->db->dbprefix('patient_orders');
		$this->db->where('id',$row_order_id['order_id']);
		$get_st = $this->db->delete('patient_orders');
		
		
		$this->db->dbprefix('patient_order_details');
		$this->db->where('medicine_id',$medicine_id);
		$get_st = $this->db->delete('patient_order_details');
		
		}
	
		$this->db->dbprefix('medicine_strength');
		$this->db->where('medicine_id',$medicine_id);
		$get_st = $this->db->delete('medicine_strength');
		
		$this->db->dbprefix('medicine_raf');
		$this->db->where('medicine_id',$medicine_id);
		$get_st = $this->db->delete('medicine_raf');
		
		$this->db->dbprefix('medicine_info');
		$this->db->where('medicine_id',$medicine_id);
		$get_st = $this->db->delete('medicine_info');
		
		$this->db->dbprefix('medicine_quantity');
		$this->db->where('medicine_id',$medicine_id);
		$get_qt = $this->db->delete('medicine_quantity');
		
		$this->db->dbprefix('medicine');
		$this->db->where('id',$medicine_id);
		$get_page = $this->db->delete('medicine');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		*/
		
	}//end delete_medicine($medicine_id)

	// Start - medicine_category_list(): Get all Medicine Category 
	public function medicine_category_list(){
		$this->db->dbprefix('medicine_categories');
		$this->db->select('medicine_categories.id,medicine_categories.category_title');
		$this->db->from('medicine_categories');
		$this->db->where('status', 1);
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - medicine_category_list():
	
	
	// Start - medicine_form_list(): Get all Medicine Form List 
	public function medicine_form_list(){
		$this->db->dbprefix('medicine_form');
		$this->db->select('medicine_form.id,medicine_form');
		$this->db->from('medicine_form');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - medicine_form_list():
	
	// Start - medicine_list(): Get all Medicine  List 
	public function medicine_list(){
		$this->db->dbprefix('medicine');
		$this->db->select('id,brand_name,medicine_name');
		$this->db->from('medicine');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - medicine_form_list():
	
	//Function delete_medicine_strength(): Delete Strength from  database
	public function delete_medicine_strength($strength_id){
		
		$this->db->dbprefix('medicine_strength');
		$this->db->where('id',$strength_id);
		$get_st = $this->db->delete('medicine_strength');
		//echo $this->db->last_query();exit;
		
		if($get_st)
			return true;
		else
			return false;
		
	}//end delete_medicine_strength($strength_id)
	
	//Function delete_medicine_quantity(): Delete Quantity from  database
	public function delete_medicine_quantity($quantity_id){
		
		$this->db->dbprefix('medicine_quantity');
		$this->db->where('id',$quantity_id);
		$get_qt = $this->db->delete('medicine_quantity');
		//echo $this->db->last_query();exit;
		
		if($get_qt)
			return true;
		else
			return false;
		
	}//end delete_medicine_quantity($quantity_id)
	
	/***************************************************************
	* End Medicine Add Update Listing And Delete Function  
	****************************************************************/
	
	/***************************************************************
	* Medicine Info Add Update Listing And Delete Function Start 
	****************************************************************/
	
	//Function add_update_medicine_info(): Add new Medicine info into the database
	public function add_update_medicine_info($data){
		
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
			
		//Record insert into database
		$ins_data = array(
		
			'tabs_title' => $this->db->escape_str(trim($tabs_title)),
			'tabs_description' => $this->db->escape_str(trim($tabs_description)),
			'medicine_id' => $this->db->escape_str(trim($medicine_id))
		);
		
		if($medicine_info_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Inserting  data into the database. 
			$this->db->dbprefix('medicine_info');
			$ins_into_db = $this->db->insert('medicine_info', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			$up_data['display_order'] = $last_insert_id;
			
			//update  data into the database. 
			$this->db->dbprefix('medicine_info');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('medicine_info', $up_data);
			
		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//update  data into the database. 
			$this->db->dbprefix('medicine_info');
			$this->db->where('id',$medicine_info_id);
			$ins_into_db = $this->db->update('medicine_info', $ins_data);
		  			
		  }//end if($medicine_info_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_medicine_info($data)
	
	// Start - get_all_medicine_info(): Get all Medicine info for listing
	public function get_all_medicine_info($medicine_id){
		$this->db->dbprefix('medicine_info,medicine');
		$this->db->select('medicine_info.*,medicine.brand_name,medicine.medicine_name');
		$this->db->from('medicine_info');
		$this->db->join('medicine','medicine_info.medicine_id=medicine.id','inner');
		$this->db->where('medicine.id',$medicine_id);
		$this->db->order_by('medicine_info.id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_medicine_info():
	
	//Function get_medicine_info_details($medicine_id): Get Medicine details
	public function get_medicine_info_details($medicine_info_id){

		$this->db->dbprefix('medicine_info');
		$this->db->select('medicine_info.*');
		$this->db->from('medicine_info');
		$this->db->where('id',$medicine_info_id);
		return $get_page= $this->db->get()->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_medicine_info_details($medicine_info_id)
	
	//Function delete_medicine_info(): Delete Medicine info from  database
	public function delete_medicine_info($medicine_info_id){
		
		$this->db->dbprefix('medicine_info');
		$this->db->where('id',$medicine_info_id);
		$get_page = $this->db->delete('medicine_info');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_medicine_info($medicine_info_id)
	
	public function update_medicine_info_ordering($post){
		
		 extract($post);
		  
		 $total_count = count(array_filter($order_list));
		 $total_ids   = count(array_filter($id_list));
		  
		 if($total_count == $total_ids ) {
		 
			 for($i=0;$i<$total_count; $i++) {
				
					$ins_data['display_order'] = $order_list[$i];
					
					$this->db->dbprefix("medicine_info");
					$this->db->where('id', $id_list[$i]);
					$success = $this->db->update('medicine_info',$ins_data);
				
				} //end for loop
		 } // end if
		
		if($success)
			return true;
		else
			return false;	
	}
	
	/***************************************************************
	* Medicine RAF Add Update Listing And Delete Function Start 
	****************************************************************/
	
	//Function add_update_medicine_raf(): Add new Medicine Raf into the database
	public function add_update_medicine_raf($data){
		
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
			
		//Record insert into database
		$ins_data = array(
		
			'question' => $this->db->escape_str(trim($question)),
			'required_answer' => $this->db->escape_str(trim($required_answer)),
			'error_message' => $this->db->escape_str(trim($error_message)),
			'error_type' => $this->db->escape_str(trim($error_type)),			
			'medicine_id' => $this->db->escape_str(trim($medicine_id)),
			'raf_label_id' => $this->db->escape_str(trim($raf_label_id))
			
		);
		
		if($medicine_raf_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Inserting  data into the database. 
			$this->db->dbprefix('medicine_raf');
			$ins_into_db = $this->db->insert('medicine_raf', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			$up_data['display_order'] = $last_insert_id;
			
			//update  data into the database. 
			$this->db->dbprefix('medicine_raf');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('medicine_raf', $up_data);
			
		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//update  data into the database. 
			$this->db->dbprefix('medicine_raf');
			$this->db->where('id',$medicine_raf_id);
			$ins_into_db = $this->db->update('medicine_raf', $ins_data);
		  			
		  }//end if($medicine_info_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_medicine_raf($data)
	
	// Start - get_all_medicine_raf(): Get all Medicine Raf for listing
	public function get_all_medicine_raf($medicine_id){
		$this->db->dbprefix('medicine_raf,medicine,medicine_raf_labels');
		$this->db->select('medicine_raf.*,medicine.brand_name,medicine.medicine_name,medicine_raf_labels.label');
		$this->db->from('medicine_raf');
		$this->db->join('medicine','medicine_raf.medicine_id=medicine.id','inner');
		$this->db->join('medicine_raf_labels','medicine_raf.raf_label_id=medicine_raf_labels.id','inner');
		$this->db->where('medicine.id',$medicine_id);
		$this->db->order_by('medicine_raf.id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_medicine_raf():
	
	//Function get_medicine_info_details($medicine_raf_id): Get Medicine details
	public function get_medicine_raf_details($medicine_raf_id){

		$this->db->dbprefix('medicine_raf');
		$this->db->select('medicine_raf.*');
		$this->db->from('medicine_raf');
		$this->db->where('id',$medicine_raf_id);
		return $get_page= $this->db->get()->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_medicine_raf_details($medicine_raf_id)
	
	//Function delete_medicine_raf(): Delete Medicine RAF from  database
	public function delete_medicine_raf($medicine_raf_id){
		
		$this->db->dbprefix('medicine_raf');
		$this->db->where('id',$medicine_raf_id);
		$get_page = $this->db->delete('medicine_raf');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_medicine_raf($medicine_raf_id)
	
	// List all raf lables medicine_raf_labels_list();
	public function medicine_raf_labels_list(){
		
		$this->db->dbprefix('medicine_raf_labels');
		$this->db->select('medicine_raf_labels.*');
		$this->db->from('medicine_raf_labels');
		$result = $this->db->get()->result_array();
		
		if($result)
			return $result;
		else 
			return false;	
			
	}// end medicine_raf_labels_list
		
	/***************************************************************
	* End Medicine RAF Add Update Listing And Delete Function Start 
	****************************************************************/
	
	
	/***************************************************************
	* Medicine Category RAF Add Update Listing And Delete Function Start 
	****************************************************************/
	
	//Function add_update_medicine_category_raf(): Add new Medicine Category Raf into the database
	public function add_update_medicine_category_raf($data){
		
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
			
		//Record insert into database
		$ins_data = array(
		
			'question' => $this->db->escape_str(trim($question)),
			'required_answer' => $this->db->escape_str(trim($required_answer)),
			'error_message' => $this->db->escape_str(trim($error_message)),
			'error_type' => $this->db->escape_str(trim($error_type)),			
			'med_category_id' => $this->db->escape_str(trim($category_id)),
			'raf_label_id' => $this->db->escape_str(trim($raf_label_id))
			
		);
		
		if($medicine_category_raf_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Inserting  data into the database. 
			$this->db->dbprefix('medicine_categories_raf');
			$ins_into_db = $this->db->insert('medicine_categories_raf', $ins_data);
			
		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//update  data into the database. 
			$this->db->dbprefix('medicine_categories_raf');
			$this->db->where('id',$medicine_category_raf_id);
			$ins_into_db = $this->db->update('medicine_categories_raf', $ins_data);
			
		  			
		  }//end if($medicine_info_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_medicine_category_raf($data)
	
	// Start - get_all_medicine_category_raf(): Get all Medicine Category Raf for listing
	public function get_all_medicine_category_raf($category_id){
		$this->db->dbprefix('medicine_categories_raf,medicine_categories,medicine_raf_labels');
		$this->db->select('medicine_categories_raf.*,medicine_categories.category_title,medicine_raf_labels.label');
		$this->db->from('medicine_categories_raf');
		$this->db->join('medicine_categories','medicine_categories_raf.med_category_id=medicine_categories.id','inner');
		$this->db->join('medicine_raf_labels','medicine_categories_raf.raf_label_id=medicine_raf_labels.id','inner');
		$this->db->where('medicine_categories.id',$category_id);
		$this->db->order_by('medicine_categories_raf.id', 'DESC');
		return  $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
	} // End - get_all_medicine_category_raf():
	
	//Function get_medicine_category_raf_details($medicine_category_raf_id): Get Medicine category Raf details
	public function get_medicine_category_raf_details($medicine_category_raf_id){

		$this->db->dbprefix('medicine_categories_raf');
		$this->db->select('medicine_categories_raf.*');
		$this->db->from('medicine_categories_raf');
		$this->db->where('id',$medicine_category_raf_id);
		return $get_page= $this->db->get()->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_medicine_category_raf_details($medicine_category_raf_id)
	
	//Function delete_medicine_category_raf(): Delete Medicine RAF from  database
	public function delete_medicine_category_raf($medicine_category_raf_id){
		
		$this->db->dbprefix('medicine_categories_raf');
		$this->db->where('id',$medicine_category_raf_id);
		$get_page = $this->db->delete('medicine_categories_raf');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_medicine_category_raf($medicine_category_raf_id)
	
	/***************************************************************
	* End Medicine Category RAF Add Update Listing And Delete Function Start 
	****************************************************************/
	
	public function update_medicine_raf_ordering($post){
		
		 extract($post);
		 
	
		 $total_count = count(array_filter($order_list));
		 $total_ids   = count(array_filter($id_list));
		  
		 if($total_count == $total_ids ) {
		 
			 for($i=0;$i<$total_count; $i++) {
				
					$ins_data['display_order'] = $order_list[$i];
					
					$this->db->dbprefix("medicine_raf");
					$this->db->where('id', $id_list[$i]);
					$success = $this->db->update('medicine_raf',$ins_data);
					//echo $this->db->last_query(); exit;
				
				} //end for loop
		 } // end if
		
		if($success)
			return true;
		else
			return false;	
	}
	
	// Start - get_all_medicine_raf(): Get all Medicine Raf for listing
	public function get_all_medicine_raf_label_ajax($medicine_id,$raf_label_id=''){
		
		if($raf_label_id!=""){
		$this->db->dbprefix('medicine_raf,medicine,medicine_raf_labels');
		$this->db->select('medicine_raf.*,medicine.brand_name,medicine.medicine_name,medicine_raf_labels.label');
		$this->db->from('medicine_raf');
		$this->db->join('medicine','medicine_raf.medicine_id=medicine.id','inner');
		$this->db->join('medicine_raf_labels','medicine_raf.raf_label_id=medicine_raf_labels.id','inner');
		$this->db->where('medicine.id',$medicine_id);
		$this->db->where('medicine_raf_labels.id',$raf_label_id);
		$this->db->order_by('medicine_raf.id', 'DESC');
		return $this->db->get()->result_array();
	 
	 } else {
		
		$this->db->dbprefix('medicine_raf,medicine,medicine_raf_labels');
		$this->db->select('medicine_raf.*,medicine.brand_name,medicine.medicine_name,medicine_raf_labels.label');
		$this->db->from('medicine_raf');
		$this->db->join('medicine','medicine_raf.medicine_id=medicine.id','inner');
		$this->db->join('medicine_raf_labels','medicine_raf.raf_label_id=medicine_raf_labels.id','inner');
		$this->db->where('medicine.id',$medicine_id);
		$this->db->order_by('medicine_raf.id', 'DESC');
		return $this->db->get()->result_array();
	 }
	 
	} // End - get_all_medicine_raf():
	
	// Start - get_all_medicine(): Get all Medicine for listing
	public function get_medicine_by($category_id='', $medicine_id=''){

		$this->db->dbprefix('medicine,medicine_categories');
		$this->db->select('medicine.id as medicine_id, medicine.*,medicine_categories.*');
		
		$this->db->from('medicine');
		$this->db->join('medicine_categories','medicine.category_id=medicine_categories.id','inner');
		
		if($category_id != ''){
			$this->db->where('medicine.category_id', $category_id);
			return $this->db->get()->result_array();
		} // if($category_id != '')
		
		if($medicine_id != ''){
			$this->db->where('medicine.id', $medicine_id);
			return $this->db->get()->row_array();
		} // if($medicine_id != '')
		
	} // End - get_medicine_by($category_id='', $medicine_id=''):
	
	//Function delete_patient_raf(): This will delete the existing RAF if exist of the patient againt Medicine ID or Vaccine ID
	public function get_patient_medicine_raf($patient_id, $medicine_id = '',$vaccine_id = ''){
		
		 $this->db->dbprefix('patients_raf_history');
		 $this->db->select('patients_raf_history.patient_id, patients_raf_history.medicine_id, patients_raf_history.vaccine_id, patients_raf_history.raf_id, patients_raf_history.answer');
		 
		 if(trim($medicine_id) != ''){
			 
			$this->db->select('medicine_raf.question as med_question');
		 	$this->db->where('patients_raf_history.medicine_id',$medicine_id);
			$this->db->join('medicine_raf','patients_raf_history.raf_id = medicine_raf.id');
			
		 }//end if(trim($medicine_id) != '')
		 
		 if(trim($vaccine_id) != ''){
			 
			$this->db->select('vaccine_raf.question as vaccine_question');
			$this->db->where('patients_raf_history.vaccine_id',$vaccine_id);
			$this->db->join('vaccine_raf','patients_raf_history.raf_id = vaccine_raf.id');
			
		 }//end if(trim($vaccine_id) != '')
		 
		 $this->db->from('patients_raf_history');
		 $this->db->where('patient_id',$patient_id);
		 
		 $get = $this->db->get();
		 $result = $get->result_array();
		 //echo $this->db->last_query(); exit;
		 
		 return $result;
		
	}//end delete_patient_raf($patient_id, $medicine_id = '',$vaccine_id = '')
	
}//end file
?>