<?php
class Userorders_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	// Start - get_all_user_orders(): Get all User Orders for listing
	public function get_all_user_orders(){
		
		$this->db->dbprefix('user_orders, users');
		$this->db->select('user_orders.*, users.first_name, users.last_name');
		$this->db->from('user_orders');
		$this->db->join('users', 'user_orders.user_id = users.id', 'inner');
		$this->db->order_by('id', 'DESC'); 
		return $userorders = $this->db->get()->result_array();
			
	} // get_all_user_orders

    // Start - get_order_details(): Get Order Detail 
	public function get_order_details($id){
		
		$this->db->dbprefix('user_order_details, user_orders, users');
		$this->db->select('user_order_details.*,user_orders.order_no, user_orders.purchase_date, user_orders.vat_tax, user_orders.grand_total,user_orders.paypal_transaction_id, users.first_name, users.last_name');
		$this->db->from('user_order_details');
		$this->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'inner'); 
		$this->db->join('users', 'user_order_details.user_id = users.id', 'inner'); 
		$this->db->where('order_id',$id); 
		return $userorders = $this->db->get()->result_array();	
		//echo $this->db->last_query(); 		exit;
				
	} //get_order_details
	
}//end file

?>