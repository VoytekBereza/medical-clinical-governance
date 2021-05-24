<?php
class Vaccine_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	/***************************************************************
	* Vaccine Add Update Listing And Delete Function Start 
	****************************************************************/
	
	//Function add_update_medicine_category(): Add new Medicine Catetgory into the database
	public function add_update_vaccine($data){
		
		extract($data);
		$generate_seo_url = $this->common->generate_seo_url($vaccine_title);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'vaccine_title' => $this->db->escape_str(trim($vaccine_title)),
			'description' => $this->db->escape_str(trim($description)),
			'short_description' => $this->db->escape_str(trim($short_description)),
			'description' => $this->db->escape_str(trim($description)),
			'meta_title' => $this->db->escape_str(trim($meta_title)),
			'meta_description' => $this->db->escape_str(trim($meta_description)),
			'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
			'vaccine_type' => $this->db->escape_str(trim($vaccine_type))
		);
		
		//Uploading images_src Image
		if($_FILES['images_src']['name'] != ''){
			
			$vaccine_folder_path = '../assets/vaccine_images/';
		
			
			//echo $name = $_FILES['images_src']['name'];
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['images_src']['name'],'.')),'.'); 	
			$vaccine_file_name = 	'vaccine_images_'.rand().'.jpg';
			

			$config['upload_path'] = $vaccine_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '2000';
			$config['overwrite'] = true;
			$config['file_name'] = $vaccine_file_name;
		
			$this->load->library('upload', $config);
            
			if(!$this->upload->do_upload('images_src')){
				$error_file_arr = array('error_upload' => $this->upload->display_errors());
			    return false;
				
			}else{
				
			
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				$ins_data['images_src'] = $this->db->escape_str(trim($vaccine_file_name));
				
				//Creating Thumbmail 450 * 300
                //Uploading is successful now resizing the uploaded image
                $config_vaccine['image_library'] = 'gd2';
                $config_vaccine['source_image'] = $vaccine_folder_path.$vaccine_file_name;
                $config_vaccine['new_image'] = $vaccine_folder_path.'thumb-'.$vaccine_file_name;
                $config_vaccine['create_thumb'] = TRUE;
                $config_vaccine['thumb_marker'] = '';
               
                $config_vaccine['maintain_ratio'] = TRUE;
                $config_vaccine['width'] = 450;
               
                $this->load->library('image_lib');
                $this->image_lib->initialize($config_vaccine);
                $this->image_lib->resize();
                $this->image_lib->clear();
				
				// Unlink image from Folder 	
				if($vaccine_id!=""){
					$this->db->dbprefix('vaccines');
					$this->db->select('images_src');
					$this->db->where('id', $vaccine_id);
					$row= $this->db->get('vaccines')->row_array();
					unlink($vaccine_folder_path."".$row['images_src']);
					unlink($vaccine_folder_path."thumb-".$row['images_src']);
				}
				
			}//end if(!$this->upload->do_upload('images_src'))
			
		}//end if($_FILES['images_src']['name'] != '')
		
		if($vaccine_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Inserting  data into the database. 
			$this->db->dbprefix('vaccines');
			$ins_into_db = $this->db->insert('vaccines', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			
			$verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'vaccines','url_slug',$last_insert_id);
			$ins_data_url['url_slug'] = $this->db->escape_str(trim($verified_seo_url));
			
			//update  data into the database. 
			$this->db->dbprefix('vaccines');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('vaccines', $ins_data_url);

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			 $verified_seo_url = $this->common->verify_seo_url($generate_seo_url,'vaccines','url_slug',$vaccine_id);
			 $ins_data['url_slug'] = $this->db->escape_str(trim($verified_seo_url));

			//update  data into the database. 
			$this->db->dbprefix('vaccines');
			$this->db->where('id',$vaccine_id);
			$ins_into_db = $this->db->update('vaccines', $ins_data);
			
		}//end if($vaccine_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_medicine_category($data)
	
	// Start - get_all_vaccine(): Get all Vaccine listing
	public function get_all_vaccine(){
		$this->db->dbprefix('vaccines');
		$this->db->select('vaccines.*');
		$this->db->from('vaccines');
		$this->db->order_by('vaccines.id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_medicine_category():
	
	//Function get_vaccine_details($vaccine_id): Get vaccine details
	public function get_vaccine_details($vaccine_id){

		$this->db->dbprefix('vaccines');
		$this->db->where('id',$vaccine_id);
		$get_page= $this->db->get('vaccines');
		return $get_page->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_vaccine_details($vaccine_id)

	
	/***************************************************************
	* End Vaccine Add Update Listing  Function 
	****************************************************************/
	
	
	/***************************************************************
	* RAF Vaccine Add Update Listing  Function 
	****************************************************************/
	
	// Start - get_all_vaccine_raf(): Get all Vaccine RAF listing
	public function get_all_vaccine_raf($vaccine_id){
		$this->db->dbprefix('vaccine_raf,vaccines,medicine_raf_labels');
		$this->db->select('vaccine_raf.*,medicine_raf_labels.label');
		$this->db->from('vaccine_raf');
		$this->db->join('medicine_raf_labels','vaccine_raf.raf_label_id=medicine_raf_labels.id','inner');
		$this->db->where('vaccine_raf.vaccine_id',$vaccine_id);
		$this->db->order_by('vaccine_raf.id', 'DESC');
		return $this->db->get()->result_array();
		
	} // End - get_all_vaccine_raf():
	
	
	//Function get_vaccine_raf_details($vaccine_raf_id): Get Medicine details
	public function get_vaccine_raf_details($vaccine_raf_id){

		$this->db->dbprefix('vaccine_raf');
		$this->db->select('vaccine_raf.*');
		$this->db->from('vaccine_raf');
		$this->db->where('id',$vaccine_raf_id);
		return $get_page= $this->db->get()->row_array();
		//echo $this->db->last_query(); 		exit;
		
	}//end get_vaccine_raf_details($vaccine_raf_id)
	
	/***************************************************************
	* Vaccine RAF Add Update Listing And Delete Function Start 
	****************************************************************/
	
	//Function add_update_vaccine_raf(): Add new vaccine Raf into the database
	public function add_update_vaccine_raf($data){
		
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
			
		//Record insert into database
		$ins_data = array(
		
			'question' => $this->db->escape_str(trim($question)),
			'required_answer' => $this->db->escape_str(trim($required_answer)),
			'error_message' => $this->db->escape_str(trim($error_message)),
			'error_type' => $this->db->escape_str(trim($error_type)),			
			'vaccine_id' => $this->db->escape_str(trim($vaccine_id)),
			'raf_label_id' => $this->db->escape_str(trim($raf_label_id))
			
		);
		
		if($vaccine_raf_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//Inserting  data into the database. 
			$this->db->dbprefix('vaccine_raf');
			$ins_into_db = $this->db->insert('vaccine_raf', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			$up_data['display_order'] = $last_insert_id;
			
			//update  data into the database. 
			$this->db->dbprefix('vaccine_raf');
			$this->db->where('id',$last_insert_id);
			$ins_into_db = $this->db->update('vaccine_raf', $up_data);
			
		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
			//update  data into the database. 
			$this->db->dbprefix('vaccine_raf');
			$this->db->where('id',$vaccine_raf_id);
			$ins_into_db = $this->db->update('vaccine_raf', $ins_data);
		  			
		  }//end if($medicine_info_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_vaccine_raf($data)
	
	//Function delete_vaccine_raf(): Delete Vaccine RAF from  database
	public function delete_vaccine_raf($vaccine_raf_id){
		
		$this->db->dbprefix('vaccine_raf');
		$this->db->where('id',$vaccine_raf_id);
		$get_page = $this->db->delete('vaccine_raf');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_medicine_raf($medicine_raf_id)
	
	// Function update_vaccine_raf_ordering
	public function update_vaccine_raf_ordering($post){
		
		 extract($post);
		 
		 $total_count = count(array_filter($order_list));
		 $total_ids   = count(array_filter($id_list));
		  
		 if($total_count == $total_ids ) {
		 
			 for($i=0;$i<$total_count; $i++) {
				
					$ins_data['display_order'] = $order_list[$i];
					
					$this->db->dbprefix("vaccine_raf");
					$this->db->where('id', $id_list[$i]);
					$success = $this->db->update('vaccine_raf',$ins_data);
					//echo $this->db->last_query(); exit;
				
				} //end for loop
		 } // end if
		
		if($success)
			return true;
		else
			return false;	
	}

	// Start - get_all_vaccine_raf_label_ajax(): Get all Vaccine Raf for listing
	public function get_all_vaccine_raf_label_ajax($vaccine_id,$raf_label_id=''){
		
		if($raf_label_id!=""){
			
		$this->db->dbprefix('vaccine_raf,vaccines,medicine_raf_labels');
		$this->db->select('vaccine_raf.*,medicine_raf_labels.label');
		$this->db->from('vaccine_raf');
		$this->db->join('medicine_raf_labels','vaccine_raf.raf_label_id=medicine_raf_labels.id','inner');
		$this->db->where('vaccine_raf.vaccine_id',$vaccine_id);
		$this->db->where('medicine_raf_labels.id',$raf_label_id);
		$this->db->order_by('vaccine_raf.id', 'DESC');
		return $this->db->get()->result_array();
	 
	 } else {
		
	    $this->db->dbprefix('vaccine_raf,vaccines,medicine_raf_labels');
		$this->db->select('vaccine_raf.*,medicine_raf_labels.label');
		$this->db->from('vaccine_raf');
		$this->db->join('medicine_raf_labels','vaccine_raf.raf_label_id=medicine_raf_labels.id','inner');
		$this->db->where('vaccine_raf.vaccine_id',$vaccine_id);
		$this->db->order_by('vaccine_raf.id', 'DESC');
		return $this->db->get()->result_array();
	 }
	 
	} // End - get_all_vaccine_raf_label_ajax():
	
	// Start - add_update_travel_vaccine():
	public function add_update_travel_vaccine($post){
		
		extract($post);
		if($action == 'update'){ // Update  travel vaccine
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
			$data = array(
			'vaccine_name' => $this->db->escape_str(trim($vaccine_name)),
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			
			$this->db->dbprefix('travel_vaccines');
			$this->db->where('id', $vaccine_id);
			return $this->db->update('travel_vaccines', $data);
			
		} else if($action == 'add'){ // Insert travel vaccine
		
			$created_date = date('Y-m-d H:i:s');
			$created_by_ip = $this->input->ip_address();
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
			
		    $data = array(
			'vaccine_name' => $this->db->escape_str(trim($vaccine_name)),
			'created_date' => $created_date,
			'created_by_ip' => $created_by_ip,
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			return $this->db->insert('travel_vaccines', $data);
			// print_r($this->db->last_query()); exit;
		}
		
	} // End - add_update_travel_vaccine():
	
	// Start - get_travel_vaccine_details($vaccine_id):
	public function get_travel_vaccine_details($vaccine_id){
		
		$this->db->dbprefix('travel_vaccines');
		$this->db->where('id', $vaccine_id);
		return $this->db->get('travel_vaccines')->row_array();
		
	} // End - get_travel_vaccine_details($vaccine_id):
	
	// Start - get_all_travel_vaccine(): Get all Travel vaccine for listing
	public function get_all_travel_vaccine(){
		
		$this->db->dbprefix('travel_vaccines');
		$this->db->from('travel_vaccines');
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result_array();
	    //print_r($this->db->last_query()); exit;
		
	} // End - get_all_travel_vaccine():
	
	//Function delete_travel_vaccine(): Delete Travel Vaccine from database
	public function delete_vaccine_travel($vaccine_id){
		
		$this->db->dbprefix('travel_vaccines');
		$this->db->where('id',$vaccine_id);
		$get_page = $this->db->delete('travel_vaccines');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_medicine_raf($medicine_raf_id)
	
	// Start - get_all_destination_vaccine(): Get all Destinations vaccine for listing
	public function get_all_destination_vaccine(){
		
		$this->db->dbprefix('vaccine_destinations');
		$this->db->from('vaccine_destinations');
		$this->db->order_by('destination', 'ASC');
		return $this->db->get()->result_array();
	    //print_r($this->db->last_query()); exit;
		
	} // End - get_all_travel_vaccine():
	
	//Function add_update_vaccine_destination(): Add new Destination  into the database
	public function add_update_vaccine_destination($data){
		
		extract($data);
	
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
			
		//Record insert into database
		$ins_data = array(
		
			'destination' => $this->db->escape_str(trim($destination)),
			'certificate_code' => $this->db->escape_str(trim($certificate_code))
		);
		
		//Uploading images_src Image
		
		if($destination_id == ''){

	
		  $ins_data['created_date'] = $this->db->escape_str(trim($created_date));
		  $ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
		   $total_count = count($risk_area_season);
		   
		   if(!empty($risk_area_season)){
			
				for($i=0;$i<$total_count; $i++){
			
					if($risk_area_season[$i]!=""){
				   
				  	 	$risk_area_season_arr[] = $this->db->escape_str(trim($risk_area_season[$i]));
					}
			
				}
				
				 $ins_data['risk_area_season'] = implode("##",$risk_area_season_arr);
			}
			
			//Inserting  data into the database. 
			$this->db->dbprefix('vaccine_destinations');
			$ins_into_db = $this->db->insert('vaccine_destinations', $ins_data);
			$last_insert_id = $this->db->insert_id();
			
			/*****************ADD Vaccine********************/
		    
		   $total_count = count($vaccine_code);
		   
		   if(!empty($vaccine_code)){
				for($i=0;$i<$total_count; $i++){
	
					$ins_data_vaccine = array(
					
						'vaccine_code' => $this->db->escape_str(trim($vaccine_code[$i])),
						'destination_id' => $this->db->escape_str(trim($last_insert_id)),
						'vaccine_id' => $this->db->escape_str(trim($vaccine_id[$i])),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database. 
					
					// if not empty
					if($vaccine_code[$i]!=""){
					
					$this->db->dbprefix('destination_vaccines');
					$ins_into_vaccine = $this->db->insert('destination_vaccines', $ins_data_vaccine);
					//echo $this->db->last_query(); exit;
					
					}// end	if($vaccine_code[$i]!="")
		
				}// End for Loop
		   } // End if*/
			
			/******************END Vaccine******************************/

		}else{
			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			
		   $total_count = count($risk_area_season);
		   
		   $risk_area_season_arr = array();
		   
		   if(!empty($risk_area_season)){
			
				for($i=0;$i<$total_count; $i++){
			
					if($risk_area_season[$i]!=""){
				   
				  	 	$risk_area_season_arr[] = $this->db->escape_str(trim($risk_area_season[$i]));
					}
			
				}

				 $ins_data['risk_area_season'] = implode("##",$risk_area_season_arr);
			}

			//update  data into the database. 
			$this->db->dbprefix('vaccine_destinations');
			$this->db->where('id',$destination_id);
			$ins_into_db = $this->db->update('vaccine_destinations', $ins_data);
			
			//Function delete_travel_vaccine(): Delete Travel Vaccine from database
			$this->db->dbprefix('destination_vaccines');
			$this->db->where('destination_id',$destination_id);
			$get_page = $this->db->delete('destination_vaccines');
			//echo $this->db->last_query(); 		exit;
			
			/*****************Update Vaccine********************/
		  
		   $total_count = count($vaccine_code);
		   
		   if(!empty($vaccine_code)){
				for($i=0;$i<$total_count; $i++){
	
					$ins_data_vaccine = array(
					
						'vaccine_code' => $this->db->escape_str(trim($vaccine_code[$i])),
						'destination_id' => $this->db->escape_str(trim($destination_id)),
						'vaccine_id' => $this->db->escape_str(trim($vaccine_id[$i])),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
						'modified_date' => $this->db->escape_str(trim($created_date)),
						'modified_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);
					//Inserting  data into the database. 
					
					// if not empty
					if($vaccine_code[$i]!=""){
					
					$this->db->dbprefix('destination_vaccines');
					$ins_into_vaccine = $this->db->insert('destination_vaccines', $ins_data_vaccine);
					//echo $this->db->last_query(); exit;
					
					}// end	if($vaccine_code[$i]!="")
		
				}// End for Loop
		   } // End if*/
			
			/******************END Vaccine******************************/		
		}//end 
		
		if($ins_into_db)
			return true;
		else
			return false;

	}//end add_update_vaccine_destination($data)

	//Function delete_destination_vaccine(): Delete Destination from database
	public function delete_destination_vaccine($destination_id){
		
		$this->db->dbprefix('destination_vaccines');
		$this->db->where('destination_id',$destination_id);
		$get_page = $this->db->delete('destination_vaccines');
		
		$this->db->dbprefix('vaccine_destinations');
		$this->db->where('id',$destination_id);
		$get_page = $this->db->delete('vaccine_destinations');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_medicine_raf($destination_id)
	
	public function get_vaccine_destination_details($destination_id) {
		
	    $this->db->dbprefix('vaccine_destinations');
		$this->db->select('vaccine_destinations.*');
		$this->db->from('vaccine_destinations');
		$this->db->where('vaccine_destinations.id',$destination_id);
		$this->db->order_by('vaccine_destinations.id', 'DESC');
		return $this->db->get()->row_array();
	}

	// Start - get_all_travel_vaccine_destination(): 
	public function get_all_travel_vaccine_destination($destination_id){
		
		$this->db->dbprefix('destination_vaccines');
	    $this->db->select('destination_vaccines.id,destination_vaccines.destination_id,destination_vaccines.vaccine_id,
		destination_vaccines.vaccine_code');
		$this->db->from('destination_vaccines');
	    $this->db->where('destination_vaccines.destination_id',$destination_id);
		return $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
	} // End - get_all_travel_vaccine_destination():

	// Get all vaccines
	public function get_all_travel_vaccine_destination_add(){
		
		$this->db->dbprefix('travel_vaccines');
	    $this->db->select('travel_vaccines.id, travel_vaccines.vaccine_name');
		$this->db->from('travel_vaccines');
		$this->db->where('show_type','ONLINE');
		$this->db->or_where('show_type','BOTH');
		$this->db->order_by('travel_vaccines.id', 'DESC');
		return $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
	} // End - get_all_travel_vaccine_destination_add():
	
	//Function delete_destination_vaccine(): Delete Destination from database
	public function delete_vaccine($destination_id){
		
		$this->db->dbprefix('destination_vaccines');
		$this->db->where('id',$destination_id);
		$get_page = $this->db->delete('destination_vaccines');
		//echo $this->db->last_query(); 		exit;
		
		if($get_page)
			return true;
		else
			return false;
		
	}//end delete_vaccine($destination_id)
	
	// Get vaccine Name
	public function get_vaccine_name($vaccine_id) {
		
		$this->db->dbprefix('travel_vaccines');
		$this->db->select('travel_vaccines.vaccine_name,id');
		$this->db->where('id', $vaccine_id);
		$get_vaccine_name = $this->db->get('travel_vaccines')->row_array();
		
		if($get_vaccine_name)
			return $get_vaccine_name;
		else
			return false;
		
	}// vaccine Name
	
	// get_all_vaccine_brands
	public function get_all_vaccine_brands($vaccine_id){
		
		$this->db->dbprefix('vaccine_brands,travel_vaccines');
		$this->db->select('vaccine_brands.*,travel_vaccines.vaccine_name,travel_vaccines.id as vaccine_id');
		$this->db->from('vaccine_brands');
		$this->db->join('travel_vaccines','vaccine_brands.vaccine_cat_id=travel_vaccines.id','LEFT');
		$this->db->where('vaccine_brands.vaccine_cat_id', $vaccine_id);
		$this->db->order_by('vaccine_brands.id', 'DESC');
		return $this->db->get()->result_array();
	
	    //print_r($this->db->last_query()); exit;
		
	} // End - get_all_vaccine_brands():
	
	// Get vaccine Name
	public function get_brand_name($brand_id) {
		
		$this->db->dbprefix('vaccine_brands');
		$this->db->select('vaccine_brands.*');
		$this->db->where('id', $brand_id);
		$get_brand_name = $this->db->get('vaccine_brands')->row_array();
		
		if($get_brand_name)
			return $get_brand_name;
		else
			return false;
		
	}// vaccine Name
	
	// Start - add_update_vaccine_brand():
	public function add_update_vaccine_brand($post){
		
		extract($post);
		
		if($action == 'update'){ // Update  travel vaccine
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
			$data = array(
			'brand_name' => $this->db->escape_str(trim($brand_name)),
			'vaccine_cat_id'  => $vaccine_cat_id,
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			
			$this->db->dbprefix('vaccine_brands');
			$this->db->where('id', $brand_id);
			return $this->db->update('vaccine_brands', $data);
			
		} else if($action == 'add'){ // Insert travel vaccine
		
			$created_date = date('Y-m-d H:i:s');
			$created_by_ip = $this->input->ip_address();
			$modified_date = date('Y-m-d H:i:s');
			$modified_by_ip = $this->input->ip_address();
			
		    $data = array(
			'brand_name' => $this->db->escape_str(trim($brand_name)),
			'vaccine_cat_id'  => $vaccine_cat_id,
			'created_date' => $created_date,
			'created_by_ip' => $created_by_ip,
			'modified_date' => $modified_date, 
			'modified_by_ip' => $modified_by_ip);
			return $this->db->insert('vaccine_brands', $data);
			// print_r($this->db->last_query()); exit;
		}
		
	} // End - add_update_vaccine_brand():
}//end file
?>