<?php
class Users_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_user_details(): Fetch the user details from user table using User_id
	public function get_user_details($user_id){
		
		$this->db->dbprefix('users');
		
		$this->db->select('users.*,CONCAT(first_name," ",last_name) AS user_full_name,usertype.id AS user_type_id, usertype.user_type AS user_type_name');

		$this->db->where('users.id',$user_id);
		$this->db->join('usertype','users.user_type = usertype.id','LEFT');
		$get_user= $this->db->get('users');
		$row_arr = $get_user->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	}//end get_user_by_email()

	//Get User by Email
	public function get_user_by_email($email_address){
		
		$this->db->dbprefix('users');
		$this->db->select('users.*,usertype.user_type AS user_type_name, organization.id AS organization_id');
		$this->db->where('users.email_address',$email_address);
		$this->db->join('usertype','users.user_type = usertype.id','LEFT');
		$this->db->join('organization','users.id = organization.owner_id','LEFT');
		$get_user= $this->db->get('users');
		$row_arr = $get_user->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	}//end get_user_by_email()
	
	//Function update_user_profile($user_id,$data): Save the user Profile into the table
	public function update_user_profile($user_id,$data){
		
		extract($data);
		
		if($type == 'profile'){

			//Record insert into database
			$upd_data = array(
			
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'user_country' => $this->db->escape_str(trim($user_country)),
				'mobile_no' => $this->db->escape_str(trim($mobile_no)),
				'registration_no' => $this->db->escape_str(trim($registration_no))
			);
			
		}elseif($type == 'password'){
			//Record insert into database
			$upd_data['password'] = $this->db->escape_str(md5(trim($new_password)));
			
			if($new_terms)
				$upd_data['is_new_user'] = '1';
			
		}elseif($type == 'sign'){
			
			
			if($default_signature == 'image'){
				$user_folder_path = './assets/user_signature/';
		
				//Uploading profile Imaage
				if($_FILES['new_signature']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['new_signature']['name'],'.')),'.'); 			
				$signature_file_name = 	'signature_'.$user_id.'.jpg';
				
				$config['upload_path'] = $user_folder_path;
				$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config['max_size']	= '2000';
				$config['overwrite'] = true;
				$config['file_name'] = $signature_file_name;
				
				$this->load->library('upload', $config);
				
					if(!$this->upload->do_upload('new_signature')){
						$error_file_arr = array('error_upload' => $this->upload->display_errors());
						return $error_file_arr;
					}else{
						
						$data_image_upload = array('upload_image_data' => $this->upload->data());
						$upd_data['signature_image'] = $this->db->escape_str(trim($signature_file_name));
						
						
						//Creating Thumbmail width 200px
						//Uploading is successful now resizing the uploaded image
						$config_thumb['image_library'] = 'gd2';
						$config_thumb['source_image'] = $user_folder_path.$signature_file_name;
						$config_thumb['new_image'] = $user_folder_path.'thumb-'.$signature_file_name;
						$config_thumb['create_thumb'] = TRUE;
						$config_thumb['thumb_marker'] = '';
					   
						$config_thumb['maintain_ratio'] = TRUE;
						$config_thumb['width'] = 200;
						/*$config_thumb['height'] = 160;*/
					   
						$this->load->library('image_lib');
						$this->image_lib->initialize($config_thumb);
						$this->image_lib->resize();
						$this->image_lib->clear();
					}//end if(!$this->upload->do_upload('new_signature'))
					
				}//end if($_FILES['new_signature']['name'] != '')

			}elseif($default_signature == 'svn'){

				//Record insert into database
				$upd_data['signature_svn'] = $this->db->escape_str(trim($signature_svn_txt));
				
					
			}//end if($default_signature == 'image')
			
		}//end if
		
		if(!$new_terms)
			$upd_data['default_signature'] = $this->db->escape_str(trim($default_signature));
		
		//Inserting User data into the database. 
		$this->db->where('id',$user_id);
		$this->db->dbprefix('users');
		$upd_into_db = $this->db->update('users', $upd_data);
		
		//echo $this->db->last_query(); 		exit;
		
		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end update_user_setting($user_id,$data)

	//Function update_user_setting($user_id,$data): Save the user settings into the table
	public function update_user_setting($user_id,$data){
		
		//Record insert into database
		foreach($data as $index_field =>$val){
			$upd_data[$index_field] = $val;
			
		}//end foreach($data as $index_field =>$val)

		//Inserting User data into the database. 
		$this->db->where('id',$user_id);
		$this->db->dbprefix('users');
		$upd_into_db = $this->db->update('users', $upd_data);
		
		//echo $this->db->last_query(); 		exit;
		
		if($upd_into_db){
			$this->session->set_userdata('is_intro_video_watched', 1);	//Update session
			return true;
		}else
			return false;
		
	}//end update_user_setting($user_id,$data)
	
	//Function get_user_signatures(): Rule is if any of the signature is set, return that one, if both are uploaded return the one set as default.
	public function get_user_signatures($user_id){

		$get_user_detials = $this->users->get_user_details($user_id);
		
		$user_signature = array();
		
		if(filter_string($get_user_detials['signature_svn']) != '' &&  filter_string($get_user_detials['signature_image']) != ''){
		
			$user_signature['signature_type'] = filter_string($get_user_detials['default_signature']);
			
			if(filter_string($get_user_detials['default_signature']) == 'svn')
				
				$user_signature['signature'] = filter_string($get_user_detials['signature_svn']);
			else
				$user_signature['signature'] = USER_SIGNATURE.filter_string($get_user_detials['signature_image']);
			
			//end if($get_user_detials['default_signature'] == 'svn')

		}elseif(filter_string($get_user_detials['signature_svn']) != ''){
			
			$user_signature['signature_type'] = 'svn';
			$user_signature['signature']	= filter_string($get_user_detials['signature_svn']);
			
		}elseif(filter_string($get_user_detials['signature_image']) != ''){
			
			$user_signature['signature_type'] = 'image';
			$user_signature['signature']	= USER_SIGNATURE.filter_string($get_user_detials['signature_image']);
			
		}else{
			$user_signature = array();	
		}//end if
		
		return $user_signature;
		
	}//end get_user_signatures($user_id)

}//end file
?>