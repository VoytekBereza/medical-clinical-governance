<?php
class Dashbord_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	// Start - count_all_users(): Count all Users where exist into database
	public function count_all_users(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users'); 
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		//exit;
	  // echo $this->db->last_query();  exit;
		
	} // End - count_all_users():
	
	// Start - count_all_gmc(): Count all Gmc Users
	public function count_all_gmc(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('registration_type',"GMC");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_gmc():
	
	// Start - count_all_gphc(): Count All GPHC
	public function count_all_gphc(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"1");
		$this->db->where('user_type',"2");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_gphc():
	
	// Start - count_all_nmc(): Count all NMC Users
	public function count_all_nmc(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"1");
		$this->db->where('user_type',"3");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_nmc():
	
	// Start - count_all_none_gphc_prescriber(): Count all count_all_none_gphc_prescriber 
	public function count_all_none_gphc_prescriber(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"0");
		$this->db->where('user_type',"2");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_none_gphc_prescriber():
	
	// Start - count_all_none_nmc_prescriber(): 
	public function count_all_none_nmc_prescriber(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"0");
		$this->db->where('user_type',"3");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return  $row['total']; exit;
		
	} // End - count_all_none_nmc_prescriber():
	
    // Start - count_all_pharmacy_assistance(): 
	public function count_all_pharmacy_assistance(){
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('user_type',"4");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_pharmacy_assistance():
	
	// Start - count_all_technician(): 
	public function count_all_technician(){
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('user_type',"5");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		//echo $this->db->last_query();  exit;
		
	} // End - count_all_technician():
	
	// Start - count_all_pre_reg(): 
	public function count_all_pre_reg(){
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('user_type',"6");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_pre_reg():
	
	// Start - count_all_health_professional(): 
	public function count_all_health_professional(){
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('user_type',"7");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_health_professional():
	
	// Start - count_all_training(): 
	public function count_all_training(){
		$this->db->dbprefix('package_training');
		$this->db->select('count(id) as total');
		$this->db->from('package_training');
	    $this->db->where('is_admin_deleted !=',"1");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_training():
	
	// Start - count_all_pgds(): 
	public function count_all_pgds(){
		$this->db->dbprefix('package_pgds');
		$this->db->select('count(id) as total');
		$this->db->from('package_pgds');
	    $this->db->where('is_admin_deleted !=',"1");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_pgds():
	
	// Start - count_all_oral_pgds(): 
	public function count_all_oral_pgds(){
		$this->db->dbprefix('package_pgds');
		$this->db->select('count(id) as total');
		$this->db->from('package_pgds');
	    $this->db->where('is_admin_deleted !=',"1");
		$this->db->where('pgd_type', "O");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_oral_pgds():
	
	// Start - count_all_vaccine_pgds(): 
	public function count_all_vaccine_pgds(){
		$this->db->dbprefix('package_pgds');
		$this->db->select('count(id) as total');
		$this->db->from('package_pgds');
	    $this->db->where('is_admin_deleted !=',"1");
		$this->db->where('pgd_type',"V");
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_vaccine_pgds():
	
	// Start - count_all_vaccine_pgds(): 
	public function count_all_orders(){
		$this->db->dbprefix('user_orders');
		$this->db->select('count(id) as total');
		$this->db->from('user_orders');
		$query = $this->db->get();
	    $row = $query->row_array();
	    return $row['total'];
		
	} // End - count_all_vaccine_pgds():	

}//end file
?>