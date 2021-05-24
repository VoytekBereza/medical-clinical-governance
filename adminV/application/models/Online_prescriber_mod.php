<?php

class Online_prescriber_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	public function get_prescriber_list($id = ''){
		
		$this->db->dbprefix('admin');
		$this->db->where('login_user_type','prescriber');
		
		if(trim($id) != '') $this->db->where('id',$id); 
		
		$this->db->order_by('id DESC');
		$list_arr = $this->db->get('admin');
		
		if(trim($id) != '')
			return $list_arr->row_array();
		else
			return $list_arr->result_array();
		
	}//end get_prescriber_list()
	
	public function verify_if_prescriber_exist($email_address, $exclude_self = ''){
		
		$this->db->dbprefix('admin');
		
		$this->db->where('login_user_type','prescriber'); 
		$this->db->where('email_address',$email_address); 
		
		if($exclude_self != '') $this->db->where('id != ',$exclude_self); 
		
		$list_arr = $this->db->get('admin');
		
		return $list_arr->row_array();
		
	}//end verify_if_prescriber_exist($field_name, $data)	
	
	public function add_edit_online_doctor_prescriber($data){

		extract($data);
		
		if($status == '1'){
			
			//Deactivate all the other Presc and active the curren tone 

			$status_data['status'] = $this->db->escape_str(trim('0'));

			$this->db->dbprefix('admin');
			$this->db->where('login_user_type','prescriber');
			$success = $this->db->update('admin', $status_data);
			
		}//end if($status == '1')
		
		$ins_data = array(
		
			'first_name' => $this->db->escape_str(trim($first_name)),
			'last_name' => $this->db->escape_str(trim($last_name)),
			'email_address' => $this->db->escape_str(trim($email_address)),
			
			'organization_name' => $this->db->escape_str(trim($organization_name)),
			
			'address_1' => $this->db->escape_str(trim($address_1)),
			'address_2' => $this->db->escape_str(trim($address_2)),
			'address_3' => $this->db->escape_str(trim($address_3)),
			'postcode' => $this->db->escape_str(trim($postcode)),
			'town' => $this->db->escape_str(trim($town)),
			'county' => $this->db->escape_str(trim($county)),
			
			'reg_type' => $this->db->escape_str(trim($reg_type)),
			'reg_no' => $this->db->escape_str(trim($reg_no)),
			
			'login_user_type' => $this->db->escape_str(trim('prescriber')),
			'contact_no' => $this->db->escape_str(trim($contact_no)),
			'status' => $this->db->escape_str(trim($status)),
		);

		$allowed_extension = array('gif','jpg','jpeg','png');
		
		$folder_path = '.././assets/prescriber_files/';
		
		if($_FILES['signature_file']['name'] != ''){
			
			$extension = pathinfo($_FILES['signature_file']['name'], PATHINFO_EXTENSION);

			if(in_array($extension,$allowed_extension)){
				
				$sign_file_name = date('YmdGis').rand().'.'.$extension;
				$destination_path = $folder_path.$sign_file_name;
				
				@copy($_FILES['signature_file']['tmp_name'],$destination_path);
				$ins_data['signature_file'] =  $this->db->escape_str($sign_file_name);

			}//end if(in_array($extension,$allowed_exntension))				
			
		}//end if($_FILES['signature_file']['name'] != '')
		
		if(count($_FILES['stamp_file']['name']) > 0){
			
			$extension = pathinfo($_FILES['stamp_file']['name'], PATHINFO_EXTENSION);

			if(in_array($extension,$allowed_extension)){
				
				$stamp_file_name = date('YmdGis').rand().'.'.$extension;
				$destination_path = $folder_path.$stamp_file_name;
				
				@copy($_FILES['stamp_file']['tmp_name'],$destination_path);
				$ins_data['stamp_file'] =  $this->db->escape_str($stamp_file_name);

			}//end if(in_array($extension,$allowed_exntension))				

		}//end if($_FILES['stamp_file']['name'] != '')

		if(!$pres_id){
			
			$ins_data['password'] = $this->db->escape_str(trim(md5($password)));

			$this->db->dbprefix('admin');
			$success = $this->db->insert('admin', $ins_data);
			
		}else{
			
			//Del previous imagaes
			$get_prescriber_list = $this->get_prescriber_list($pres_id);
			
			
			if($sign_file_name != '' ){
				
				if(file_exists('.././assets/prescriber_files/'.$get_prescriber_list['signature_file']))
					unlink('.././assets/prescriber_files/'.$get_prescriber_list['signature_file']);
					
			}//end if($sign_file_name != '' )
			
			if($stamp_file_name != ''){
				
				if(file_exists('.././assets/prescriber_files/'.$get_prescriber_list['stamp_file']))
					unlink('.././assets/prescriber_files/'.$get_prescriber_list['stamp_file']);

			}//end if($stamp_file_name != '')
			
			
			
			if($password)
				$ins_data['password'] = $this->db->escape_str(trim(md5($password)));

			$this->db->dbprefix('admin');
			$this->db->where('id',$pres_id);
			$success = $this->db->update('admin', $ins_data);
			
		}//end if(!$group_id)
		
		if($success)
			return true;
		else
			return false;
		
	}//end add_edit_online_doctor_prescriber($data)

}//end file
?>