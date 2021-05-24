<?php
class Delivery_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_delivery_details($delivery_id): Get Exam details from delivery table via delivery id
	public function get_delivery_details($delivery_id){

		$this->db->dbprefix('delivery_method');
		$this->db->where('id',$delivery_id);
		$get_delivery= $this->db->get('delivery_method');
		//echo $this->db->last_query(); 		exit;
		return $get_delivery->row_array();
		
	}//end get_delivery_details($delivery_id)
	
	//Function delete_delivery_db(): Delete Exam from  database
	public function delete_delivery_db($delivery_id){
	
		$this->db->dbprefix('delivery_method');
		$this->db->where('id',$delivery_id);
		$get_delivery = $this->db->delete('delivery_method');
		//echo $this->db->last_query(); exit;
		
		if($get_delivery)
			return true;
		else
			return false;
		
	}//end delete_page_db($delivery_id)
	
	//Function add_update_delivery(): Add Update Exam Package into the database
	public function add_update_delivery($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record insert into database
		$ins_data = array(
		
			'delivery_title' => $this->db->escape_str(trim($delivery_title)),
			'price' => $this->db->escape_str(trim($price)),
			'delivery_description' => $this->db->escape_str(trim($delivery_description)),
			'status' => $this->db->escape_str(trim($status))
		);
		
		if($delivery_id == ''){

			$ins_data['created_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['created_by_ip'] = $this->db->escape_str(trim($created_by_ip));
		
			//Inserting  data into the database. 
			$this->db->dbprefix('delivery_method');
			$ins_into_db_delivery = $this->db->insert('delivery_method', $ins_data);
			$last_insert_id = $this->db->insert_id();

		}else{
			
			//update  data into the database. 
			$this->db->dbprefix('delivery_method');
			$this->db->where('id',$delivery_id);
			$ins_into_db_delivery = $this->db->update('delivery_method', $ins_data);
			
		}//end if($delivery_id == '')
		
		if($ins_into_db_delivery)
			return true;
		else
			return false;

	}//end add_update_delivery($data)
	
	// Start - get_all_delivery(): Get all delivery for listing
	public function get_all_delivery(){
		$this->db->dbprefix('delivery_method');
		$this->db->select('delivery_method.*');
		$this->db->from('delivery_method');
		$this->db->order_by('delivery_method.id', 'DESC');
	    return  $this->db->get()->result_array();
	   //  $this->db->last_query(); exit;		
	} // End - get_all_delivery():

}//end file
?>
