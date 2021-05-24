<?php

class Users_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_users_details($users_id): Get Users details from users table via user id
	public function get_users_details($users_id){

		$this->db->dbprefix('users','usertype');
		$this->db->select('users.*, usertype.user_type as user_name, buyinggroups.buying_groups AS buying_group_name');
		$this->db->from('users');
		$this->db->join('usertype', 'users.user_type = usertype.id', 'inner'); 
		$this->db->join('buyinggroups', 'users.buying_group_id = buyinggroups.id', 'left'); 
		
		$this->db->where('users.id',$users_id);
		$get_users= $this->db->get();
		//echo $this->db->last_query(); 		exit;
		return $get_users->row_array();
		
	}//end get_users_details($users_id)
	
	//Function delete_users_db(): Delete User from  database
	public function delete_users_db($users_id){
		
		// Delete City 
		$this->db->dbprefix('locum_cities');
		$this->db->where('user_id',$users_id);
		$get_users = $this->db->delete('locum_cities');
		
		$this->db->dbprefix('users');
		$this->db->where('id',$users_id);
		$get_users = $this->db->delete('users');
		//echo $this->db->last_query(); exit;
		
		if($get_users)
			return true;
		else
			return false;
		
	}//end delete_users_db($users_id)

	public function update_user_status($users_id){
		
		$get_user_data = $this->get_users_details($users_id);
		
		if($get_user_data['admin_verify_status'] == '0')
			$upd_data = array('admin_verify_status' => '1');	
		else
			$upd_data = array('admin_verify_status' => '0');	
		
		//end if($get_user_data['admin_verify_status'])
		
		
		//update  data into the database. 
		$this->db->dbprefix('users');
		$this->db->where('id',$users_id);
		$upd_into_db = $this->db->update('users', $upd_data);
		
		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end deactivate_user($users_id)
	
	
	
	//Function update_users(): update user into the database
	public function update_users($data){
		
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Record Update into database
		
			$ins_data = array(
				'first_name' => $this->db->escape_str(trim($first_name)),
				'last_name' => $this->db->escape_str(trim($last_name)),
				'mobile_no' => $this->db->escape_str(trim($mobile_no)),
				'buying_group_id' => $this->db->escape_str(trim($org_buying_group)),
				'email_address' => $this->db->escape_str(trim($email_address))
			);
			
			if($user_type_id==1)
				{
					$ins_data['registration_no'] = $this->db->escape_str(trim($gmc_no));
					$ins_data['registration_type'] = 'GMC';
					$ins_data['is_locum'] = $this->db->escape_str(trim($is_locum));
					
				} else if($user_type_id==2){
					
					$ins_data['registration_no'] = $this->db->escape_str(trim($gphc_no));
					$ins_data['registration_type'] = 'GPhC';
					$ins_data['is_locum'] = $this->db->escape_str(trim($is_locum));
					$ins_data['is_prescriber'] = $this->db->escape_str(trim($is_prescriber));
					$ins_data['speciality'] = $this->db->escape_str(trim($speciality));
					
				} else if($user_type_id==3){
					
					$ins_data['registration_no'] = $this->db->escape_str(trim($nmc_no));
					$ins_data['registration_type'] = 'NMC';
					$ins_data['is_locum'] = $this->db->escape_str(trim($is_locum));
					$ins_data['is_prescriber'] = $this->db->escape_str(trim($is_prescriber));
					$ins_data['speciality'] = $this->db->escape_str(trim($speciality));
					
				} else if($user_type_id==4){
					
				    $ins_data['is_locum'] = $this->db->escape_str(trim($is_locum));
					
				} else if($user_type_id==5){
					
					$ins_data['is_locum'] = $this->db->escape_str(trim($is_locum));
					
				}
				
	          if($users_id != ''){
				
				$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
				$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
				if($password !=''){
					$ins_data['password'] = $this->db->escape_str(md5(trim($password)));
				}
		
			
				// md5 format
				//$ins_data['password'] = $this->db->escape_str(trim(md5($password)));
				
				// check email exist Query
				$this->db->dbprefix('users');
				$this->db->select('count(id) as totalemail');
				$this->db->from('users'); 
				$this->db->where('id !=',$users_id);
				$this->db->where('email_address',$email_address);
				$query = $this->db->get();
	    		$row = $query->row_array();
				
				//echo $this->db->last_query();
				if($row['totalemail'] > 0) {
					
					return 'email_exist';
					
				} else {
				
					//update  data into the database. 
					$this->db->dbprefix('users');
					$this->db->where('id',$users_id);
					$ins_into_db = $this->db->update('users', $ins_data);
					//echo $this->db->last_query(); 		 exit;
				}
				//If Locum Selected as 1, enter the locum cities into the database.
		        if($is_locum == 1){
					
				$this->db->dbprefix('locum_cities');
				$this->db->where('user_id',$users_id);
				$get_users = $this->db->delete('locum_cities');
			
			    for($i=0;$i<count($location_arr);$i++){

				$ins_data_city = array(
				
					'user_id' => $this->db->escape_str(trim($users_id)),
					'city_id' => $this->db->escape_str(trim($location_arr[$i])),
					'created_date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				);
				
				//Inserting Locum cities into the database. 
				$this->db->dbprefix('locum_cities');
				$ins_into_db = $this->db->insert('locum_cities', $ins_data_city);
				
			}//end for
			
		}//end if($is_locum == 1)
				
			if($ins_into_db)
				  return true;
			else
				  return false;
		} 

	}//end update_users($data)
		
	// Start - get_all_selected_city(): Get all selectd city for listing
	public function get_all_selected_city($users_id){
		
	    $this->db->dbprefix('locum_cities');
		$this->db->select('city_id');
		$this->db->where('user_id',$users_id);
		$get_page= $this->db->get('locum_cities');
	    //echo $this->db->last_query(); 		exit;
		return $get_page->result_array();
			
	} // End - get_all_selected_city():
	
	// Start - get_all_users(): Get all Users for listing
	public function get_all_users($type){
		
		$where = "";
		if($type=="gmc")
		{
		 
		  $where ="registration_type ='GMC' AND users.user_type='1'";
		
		}else if ($type=="gphc1") {
			 
			   $where = "is_prescriber='1' AND users.user_type='2'";

		}else if($type=="gphc0") {
			
			  $where = "is_prescriber='0' AND users.user_type='2'";
			  
		}else if($type=="nmc1") {
			
			 $where = "is_prescriber='1' AND users.user_type='3'";
			 
		}else if($type=="nmc0") {
			
			 $where = "is_prescriber='0' AND users.user_type='3'";
			 
		}
		else if($type=="noneverify"){
			 $where = "admin_verify_status='0'";
			
		}
		else {
			 $where ='1=1';
			
		}
		$this->db->dbprefix('users, usertype');
		$this->db->select('users.*, usertype.user_type as user_name');
		$this->db->from('users');
		$this->db->join('usertype', 'users.user_type = usertype.id', 'inner'); 
		$this->db->where($where);
		$this->db->order_by('users.id', 'DESC');
		$query = $this->db->get();
	    return $query->result_array();
	   //echo $this->db->last_query();  exit;
			
	} // End - get_all_users():
	
	// Start - count_all_users(): Count all Users 
	public function count_all_users(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users'); 
		$query = $this->db->get();
	    return $query->row_array();
	   
	} // End - count_all_users():
	
	// Start - count_all_gmc(): Count all Gmc Users
	public function count_all_gmc(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('registration_type',"GMC");
		return $this->db->get()->row_array();
		
	} // End - count_all_gmc():
	
	// Start - count_all_gphc(): Count All GPHC
	public function count_all_gphc(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"1");
		$this->db->where('user_type',"2");
		return $this->db->get()->row_array();
		
	} // End - count_all_gphc():
	
	// Start - count_all_nmc(): Count all NMC Users
	public function count_all_nmc(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"1");
		$this->db->where('user_type',"3");
		return $this->db->get()->row_array();
		
	} // End - count_all_nmc():
	
	// Start - count_all_none_gphc_prescriber(): Count all count_all_none_gphc_prescriber 
	public function count_all_none_gphc_prescriber(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"0");
		$this->db->where('user_type',"2");
		return $this->db->get()->row_array();
		
	} // End - count_all_none_gphc_prescriber():
	
	// Start - count_all_none_nmc_prescriber(): Get all Users for listing
	public function count_all_none_nmc_prescriber(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('is_prescriber',"0");
		$this->db->where('user_type',"3");
		return $this->db->get()->row_array();
		
	} // End - count_all_none_nmc_prescriber():
	
		// Start - count_all_none_verify_users(): Get all Users for listing
	public function count_all_none_verify_users(){
		
		$this->db->dbprefix('users');
		$this->db->select('count(id) as total');
		$this->db->from('users');
	    $this->db->where('admin_verify_status',"0");
		return $this->db->get()->row_array();
		
	} // End - count_all_none_verify_users():
	
	// Start - update_users_verify(): Get all Users for listing
	public function update_users_verify($data){
		
		extract($data);
		
		for($i=0; $i<sizeof($admin_verify_status); $i++){
			
			$update = array('admin_verify_status' => 1, 'email_verify_status' => 1);
			
			$this->db->dbprefix('users');
			$this->db->where('id', $admin_verify_status[$i]);
			$updated = $this->db->update('users', $update);
		}
		
		if($updated)
			return true;
		else
			return false;
		
	} // End - update_users_verify():
	
	// Start - get_all_users_ajax_call
	public function get_all_users_ajax_call(){
		
        $aColumns = array('first_name','last_name', 'mobile_no','email_address','created_date');

        // DB table to use
        $sTable = 'users';
		$usertype = 'usertype';
        
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
	
        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
				/*
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
		
		$more_fields_to_search = array('CONCAT(first_name, " ", last_name)', 'registration_no', 'registration_type');
		$search_fields = array_merge($aColumns, $more_fields_to_search);
		
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($search_fields); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                //if(isset($bSearchable) && $bSearchable == 'true')
                //{
                    $this->db->or_like($search_fields[$i], $sSearch);
                //}
            }
        }
		
			/* author : mzm
		* INDIVIDUAL COLUMN FILTERING 

		* Check if individual filtering is enabled
		*/
		
		for($i=0; $i<count($search_fields); $i++)
		{
			if($this->input->get_post('sSearch_6', true) == ''){
				$sSearch = $this->input->get_post('sSearch_'.$i, true);
				
				// Individual column filtering
				if(isset($sSearch) && !empty($sSearch) && $sSearch)
				{
					$this->db->or_like($search_fields[$i], $sSearch);
				}
			}
		}
		
		$select = array('admin_verify_status', 'email_verify_status', 'first_name', 'last_name', 'mobile_no', 'email_address', 'user_type', 'is_prescriber', 'created_date', 'registration_no', 'id', 'password');

        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $select)), false);
		$this->db->dbprefix($sTable);
		
		//this->db->where('user_type','buyer');
		//join if any 
		//$this->db->join('stores','products.store_id = stores.store_id','INNER');
		
		// temp-haseeb "We can ad where clause to get the particular result "
		$user_type = $this->input->get_post('sSearch_6', true);
			
		if(!empty($user_type) ){
			
				if($user_type == 'Doctor')
					$user_type_id = 1;
				elseif($user_type == 'Pharmacist')
					$user_type_id = 2;
				elseif($user_type == 'Nurse')
					$user_type_id = 3;
				elseif($user_type == 'Pharmacy Assistant')
					$user_type_id = 4;
				elseif($user_type == 'Technician')
					$user_type_id = 5;
				elseif($user_type == 'Pre-reg')
					$user_type_id = 6;
				elseif($user_type == 'None Health Professional')
					$user_type_id = 7;
				
				$this->db->or_like('user_type', $user_type_id);
		}
		
		$admin_verify_status = $this->input->get_post('sSearch_1', true);
		
		if(!empty($admin_verify_status) ){
			if($admin_verify_status == 'Non-Verified'){
				$admin_status = 0;
			} else {
				$admin_status = 1;
			}
			$this->db->or_like('admin_verify_status', $admin_status);
		}
		
		$prescriber = $this->input->get_post('sSearch_7', true);
		
		if(!empty($prescriber) ){
			if($prescriber == 'Yes'){
				$is_prescriber = 1;
			} else {
				$is_prescriber = 0;
			}
			$this->db->or_like('is_prescriber', $is_prescriber);
		}
		 
		//$this->db->where('registration_type','GMC');
		//get data : QUERY 1 to get filtered data
        
		$this->db->order_by('id', "DESC");
		
		$rResult = $this->db->get($sTable);
		
		//mzm total get the current total from the recent query with all filters
		// Data set length after filtering
		
		$this->db->dbprefix($sTable);
        $this->db->select('FOUND_ROWS() AS found_rows');
		
        $iFilteredTotal = $this->db->get()->row()->found_rows;
		
		// Total data set length. QUERY 2 to get overall total without any filters
		//add join referernce here too if required. For total no filters
		//$this->db->join('stores','products.store_id = stores.store_id','INNER');
		
		$iTotal = $this->db->count_all_results($sTable);
		
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
		
		$data_db = $rResult->result_array();
		
        foreach( $data_db as $aRow){
			
            $row = array();
            $option_html = '';
			
			// Call Js Login action
			$login_action = 'user_login_function(\''.$aRow['email_address'].'\',\''.$aRow['id'].'\',\''.$aRow['password'].'\')';			
			$row[] = "<div class='btn-group'><input type='checkbox' name='admin_verify_status[]' value='".$aRow['id']."' class='inline pull-left' /> &nbsp; &nbsp; <a href='#login' onclick=$login_action type='button' title='Click here to login this user.' class='pull-right btn btn-default btn-xs'><i class='fa fa-external-link'></i></a><div>";
            
			foreach($select as $col)
            {
				
				$user_full_name = ucwords(filter_string($aRow['first_name']).' '.filter_string($aRow['last_name']));
				$user_purchase_list = $this->purchase->get_purchased_items_split_by_user($aRow['id']);
				$get_user_data = $this->get_users_details($aRow['id']);
					
				$pT = 0;
				$aT = 0;
				$F15 = 0;
				$F16 = 0;
				
				$arr_data = '';
				
				if($col == 'admin_verify_status'){
					if($aRow['admin_verify_status'] == '1'){
						
						if($aRow['email_verify_status'] == '1')
							$row[] = '<a href="#" class="btn btn-xs btn-success">Admin Verified</a><br>
							<a title="This user has verified the email address" href="#" class="btn btn-xs btn-success">Email Verified</a>';
						else
							$row[] = '<a title="This user is verified by the admin" href="#" class="btn btn-xs btn-success">Admin Verified</a><br>
						    <a title="This user has not verified the email address" href="#" class="btn btn-xs btn-danger">Email Not Verified</a>';
					} else {
						
						if($aRow['email_verify_status'] == '1')
							$row[] = '<a title="This user is not verified by the admin" href="#" class="btn btn-xs btn-danger">Admin Unverified</a><br>
							<a title="This user has verified the email address" href="#" class="btn btn-xs btn-success">Email Varified</a>';
						else
							$row[] = '<a title="This user is not verified by the admin" href="#" class="btn btn-xs btn-danger">Admin Unverified</a><br>
							<a title="This user has not verified the email address" href="#" class="btn btn-xs btn-danger">Email Not Verified</a>';
					}
				}elseif($col == 'first_name'){
					$row[] = $aRow['first_name'].' <br>(<strong>Buying Group: '.$get_user_data['buying_group_name'].'</strong>)';
				}elseif($col == 'last_name'){
					$row[] = $aRow['last_name'];
				}elseif($col == 'mobile_no'){
					$row[] = $aRow['mobile_no'];
				}elseif($col == 'email_address'){
					$row[] = $aRow['email_address'];
				}elseif($col == 'user_type'){
					
					if($aRow['user_type'] == '1'){
						$row[] = 'Doctor';
					}elseif($aRow['user_type'] == '2'){
						$row[] = 'Pharmacist';
					}elseif($aRow['user_type'] == '3'){
						$row[] = 'Nurse';
					}elseif($aRow['user_type'] == '4'){
						$row[] = 'Pharmacy Assistant';
					}elseif($aRow['user_type'] == '5'){
						$row[] = 'Technician';
					}elseif($aRow['user_type'] == '6'){
						$row[] = 'Pre-reg';
					}else{
						$row[] = 'None Health Professional';
					}
					
				}elseif($col == 'is_prescriber'){
					if($aRow['is_prescriber'] == '1'){
						$row[] = 'Yes';
					} else {
						$row[] = 'No';
					}
				}elseif($col == 'created_date'){
					$row[] = kod_date_format($aRow['created_date'], false);
				}elseif($col != 'id' && $col != 'password' && $col != 'email_verify_status'){
					$row[] = $aRow[$col];
				}elseif($col == 'id'){
					if($aRow['is_prescriber'] == 0){
					
					// Check for pT : ID = 10
					$index_key = array_search(10, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));
					
					if(strlen($index_key) > 0)
						$pT = 1;
					
					// Check for aT : ID = 11
					$index_key = array_search(11, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));
					
					if(strlen($index_key) > 0)
						$aT = 1;
					// if(strlen($index_key) > 0)
					
					// Check for F15 : ID = 16
					$index_key = array_search(16, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));
	
					if(strlen($index_key) > 0)
						$F15 = 1;
					// if(strlen($index_key) > 0)
					
					// Check for F16 : ID = 15
		
					$index_key = array_search(15, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

					if(strlen($index_key) > 0)
						$F16 = 1;
					
					$user_id = $aRow['id'];
				
					if($user_purchase_list['pgds']['package_purchased'] && $user_purchase_list['pgds']['package_purchased'] == 1){
						
						$arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'ORAL\', \'unassign\', \'Standard Oral PGD Package\',\''.$user_full_name.'\')" > O </button>';	
					} else {
					
						$arr_data .= '<button class="btn btn-xs btn-danger"  type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'ORAL\', \'assign\', \'Standard Oral PGD Package\',\''.$user_full_name.'\')" > O </button>';	
					
					}//end if($row[$key]['purchases']['pgds']['package_purchased'] && $row[$key]['purchases']['pgds']['package_purchased'] == 1)
					
					if($user_purchase_list['pgds']['premium_package_purchased'] && $user_purchase_list['pgds']['premium_package_purchased'] == 1){
						
						$arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'P_ORAL\', \'unassign\', \'Premium Oral PGD Package\',\''.$user_full_name.'\')" > O+ </button>';	
						
					} else {
						$arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'P_ORAL\', \'assign\', \'Premium Oral PGD Package\',\''.$user_full_name.'\')" > O+ </button>';	

					}//end if($row[$key]['purchases']['pgds']['premium_package_purchased'] && $row[$key]['purchases']['pgds']['premium_package_purchased'] == 1)
					
					if($pT && $pT == 1){
						$arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'10\', \'PGD\', \'unassign\', \'Travel Core 3.0\',\''.$user_full_name.'\')" > T </button>';
						
					} else {
						$arr_data .= '<button class="btn btn-xs btn-danger"  type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'10\', \'PGD\', \'assign\', \'Travel Core 3.0\',\''.$user_full_name.'\')" > T </button>';	
						
					}//end if($pT && $pT == 1)
					
				
					if($F16 && $F16 == 1){
					 
						$arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'15\', \'PGD\', \'unassign\', \'Seasonal 2017\',\''.$user_full_name.'\')" > F17 </button>';	
					 
					} else {
					 
						$arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'15\', \'PGD\', \'assign\', \'Seasonal 2017\',\''.$user_full_name.'\')" > F17 </button>';	
					 
					}//end if($F16 && $F16 == 1)
					 
				} // end if($row['is_prescriber'] == 0){
						
					$arr_data .='<a href="'.SURL.'users/view-trainings/'.$get_user_data['user_type'].'/'.$aRow['id'].'" class="inline btn btn-xs btn-block btn-warning pull-right trainings-admin fancybox.ajax"> Training </a>';	
					
						// Details button to view each user's history
			//$row[] = '<a onClick="user_history('.$aRow['id'].');" class="btn btn-xs btn-default" title="Click here to view PGD purchase history" >Details</a>';
			$row[] = '<a href="'.SURL.'users/purchased_items_split_by_user/'.$aRow['id'].'" class="btn btn-xs fancybox_pgd_detail fancybox.ajax"> <span class="glyphicon glyphicon-th-list" title="Purchase Details"></span></a>
			<a href="'.SURL.'users/order-details-history/'.$aRow['id'].'" class="fancybox_view fancybox.ajax" title="" ><span class="fa fa-shopping-cart" title="Order Details History"></span></a>';
					
					$row[] = $arr_data;
				}
				
            }//end of inner columns loop
			
			if($aRow['admin_verify_status'] == '1'){
				$class = 'btn-success';
				$class_icon = 'fa-unlock';
				$text = 'Deactivate';
			}else{
				$class = 'btn-danger';
				$class_icon = 'fa-lock';
				$text = 'Activate';
			}
			
			$user_id = $aRow["id"];
			$verify_if_user_in_organization = $this->organization->verify_if_user_in_organization($user_id);
			
			
			$organization_name_str = '<p style="font-size:11px">';
			if($verify_if_user_in_organization){
				
				$is_owner = $this->organization->is_user_org_owner_si($user_id);
				
				if($is_owner){
					$organization_name_str .= '<strong>Owner: </strong>'.filter_string($is_owner['company_name']);	
				}else{
	
					//Is an SI 135
					$user_already_superintendent = $this->organization->user_already_superintendent($user_id);
					
					if($user_already_superintendent){
						$organization_name_str .= '<strong>Superintendent: </strong>'.filter_string($user_already_superintendent['company_name']);	
					}else{
						
						$user_pharmacies_arr = $this->organization->get_my_pharmacies_surgeries($user_id);
						
						$organization_list_arr = array();
						
						for($i=0;$i<count($user_pharmacies_arr);$i++){
							$organization_list_arr[$user_pharmacies_arr[$i]['organization_name']][] = $user_pharmacies_arr[$i]['pharmacy_surgery_name'];	
						}//end for($i=0;$i<count($user_pharmacies_arr);$i++)
						
						foreach($organization_list_arr as $organization_name => $pharmacy_list){
							
							$organization_name_str.= '<strong>'.$organization_name.'</strong> <br>';
							
							for($i=0;$i<count($pharmacy_list);$i++){
								$organization_name_str .= '- '.filter_string($pharmacy_list[$i]).'<br>';
							}//end for($i=0;$i<count($pharmacy_list);$i++)
								
						}//end foreach
						
					}//end if($user_already_superintendent)
					
				}//end $is_owner
				
			}else{
				$organization_name_str .= "none";	
			}
			$organization_name_str .='</p>';
			
			$row[] = $organization_name_str;

			$row[] = '<a href="'.base_url().'users/update-users/'.$aRow["id"].'" target="_blank" type="button" class="btn btn-info btn-xs pull-left"><span class="glyphicon glyphicon-edit"></span></a>
			
			<a href="#" data-href="'.base_url().'users/update-user-status/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-delete-'.$aRow['id'].'" class="btn '.$class.' btn-xs" ><i class="fa '.$class_icon.'"></i></a>
			
			<div class="modal fade" id="confirm-delete-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Warning !
						</div>
						<div class="modal-body">
							Are you sure you want to '.$text.' the selected User?
						</div>
						<div class="modal-footer">
							<a href="'.base_url().'users/deactivate-users/'.$aRow["id"].'" class="btn btn-danger">'.$text.'</a>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>';


			$output['aaData'][] = $row;
			
        }
		
		header('Content-type: application/json');
        echo json_encode($output);
		
    } // End - get_all_users_ajax_call()
	
	//Function get_purchased_items_split_by_user(): This will return multiple split arrays of items/ packages purchased.
	public function get_purchased_items_split_by_user($user_id){
		
		$pgd_purchased_arr = array();
		$training_purchased_arr = array();
		
		$this->db->dbprefix('user_order_details');
		$this->db->where('user_id',$user_id);
		$this->db->order_by('id','ASC');
		$get = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;

		$oral_package_purchased = 0;
		$package_expiry = '0000-00-00';
		
		foreach ($get->result_array() as $row){
			
			if($row['product_type'] == 'TRAINING'){
				$training_purchased_arr[$row['product_id']]= $row;
			}else{
				
				if($row['is_package'] == 1){
					//ORAL Package is Purchased
					$oral_package_purchased = 1;
					$package_expiry = $row['expiry_date'];
					$is_expired = ((strtotime(date('Y-m-d')) < strtotime($package_expiry)) || $package_expiry== '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1
				}//end if($row['is_package'] == 1)
			
				// Add pgd_type into pgd rows
				$this->db->dbprefix('package_pgds');
				$this->db->select('pgd_type as type');
				$this->db->where('id', $row['product_id']);
				$pgd = $this->db->get('package_pgds')->row_array();
			
				// Add PGD type and merge row
				$new_array = array('type' => $pgd['type']);
				$row = array_merge($new_array, $row);
			
				$pgd_purchased_arr[$row['product_id']]= $row;
				
			}//end if($row['product_type'] == 'TRAINING')
			
		}//end foreach ($get->row_array() as $row)
		
		$data['training'] = $training_purchased_arr;
		$data['pgds']['pgd_list'] = $pgd_purchased_arr;
		$data['pgds']['package_purchased'] = $oral_package_purchased;
		$data['pgds']['package_expiry'] = $package_expiry;
		$data['pgds']['package_expired'] = $is_expired;
		
		return $data;

	} //end get_purchased_items($user_id)
	
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
	
	// Start - pgd_name_by_id($training_id)
	public function pgd_name_by_id($pgd_id){
		
		$this->db->dbprefix('package_pgds');
		$this->db->select('pgd_name');
		$this->db->where('id', $pgd_id);
		$query = $this->db->get('package_pgds');

		if($query->num_rows() > 0){
			$row = $query->row_array();
			return $row['pgd_name'];
		} else
			return NULL;
		
	} // End - pgd_name_by_id($training_id)
	
	// Start - get_user_quiz_results($user_id):
	public function get_user_quiz_results($user_id, $quizes_for, $order_id){
		
		if($quizes_for == 'pgd'){
			
			// For PGD Quizes
			
			$prefix_1 = 'pgd_quiz_results, pgd_quizes';
			$table_1 = 'pgd_quiz_results as result';
			$join_with_table = 'pgd_quizes as quiz';
			
			$join_with_table_2 = 'pgd_quiz_options as option';
			
			$prefix_2 = 'pgd_quiz_options';
			$table_2 = 'pgd_quiz_options';
			
		} else {
			
			// For Training Quizes
			
			$prefix_1 = 'training_quiz_results, pgd_quizes';
			$table_1 = 'training_quiz_results as result';
			$join_with_table = 'training_quizes as quiz';
			
			$join_with_table_2 = 'training_quiz_options as option';
			
			$prefix_2 = 'training_quiz_options';
			$table_2 = 'training_quiz_options';
			
		}
		
		$this->db->dbprefix($prefix_1);
		$this->db->select('quiz.question, quiz.id as quiz_id, quiz.correct_option_id, result.answer_status, result.answer_id, option.option as correct_option_name');
		
		$this->db->from($table_1);
		$this->db->join($join_with_table, ' quiz.id = result.quiz_id ');
		$this->db->join($join_with_table_2, ' quiz.correct_option_id = option.id ');
		
		$this->db->where('result.user_id', $user_id);
		$this->db->where('result.order_id', $order_id);
		
		$data['questions'] = $this->db->get()->result_array();
		
		if(!empty($data['questions'])){
			
			foreach($data['questions'] as $key => $question):
				
				$this->db->dbprefix($prefix_2);
				$this->db->select('option');
				$this->db->where('quiz_id', $question['quiz_id']);
				$data['questions'][$key][] = $this->db->get($table_2)->result_array();
				
			endforeach;
			
		} // if(!empty($data['questions']))

		return $data;
		
	} // End - get_user_quiz_results($user_id):
	
	// Start - get_order_details_history(): Get Order History for listing
	public function get_order_details_history($id){
		
		$this->db->dbprefix('user_order_history, user_orders, users');
		$this->db->select('user_order_history.*,user_orders.order_no, user_orders.purchase_date, user_orders.vat_tax, user_orders.grand_total,user_orders.paypal_transaction_id, users.first_name, users.last_name');
		$this->db->from('user_order_history');
		$this->db->join('user_orders', 'user_order_history.order_id = user_orders.id', 'inner'); 
		$this->db->join('users', 'user_order_history.user_id = users.id', 'inner'); 
		$this->db->where('user_order_history.user_id',$id); 
		return $userordershistory = $this->db->get()->result_array();	
		//echo $this->db->last_query(); exit;
		
	} //get_order_details_history
	
	// Start - get_all_default_team_users(): Get all Default Team Users listing
	public function get_all_default_team_users(){
		
	    $this->db->dbprefix('users,usertype');
		$this->db->select('users.*,usertype.user_type');
		$this->db->from('users');
	    $this->db->join('usertype', 'users.user_type = usertype.id', 'inner'); 
		$this->db->where('users.is_default','1');
		$this->db->where("(users.user_type='1' OR users.user_type='2')");
		$this->db->order_by('users.id', 'DESC');
		
		$team_users = $this->db->get()->result_array();	
		
	    $this->db->dbprefix('users,usertype');
		$this->db->select('users.*,usertype.user_type');
		$this->db->from('users');
	    $this->db->join('usertype', 'users.user_type = usertype.id', 'inner'); 
		$this->db->where('users.system_prescriber','1');
		
		$team_presc = $this->db->get()->result_array();	
		
		$final_arr = array_merge($team_users,$team_presc);
		return $final_arr;
		
		//echo $this->db->last_query(); exit;		
	} // End - get_all_default_team_users():
	
	// Start Function search_doctor_pharmacist()
	public function search_doctor_pharmacist($data){
		
		extract($data);
		//$where = "(first_name LIKE '%$search%' || last_name LIKE '%$search%')";
		$this->db->dbprefix('users');
		$this->db->select('users.first_name, users.last_name, users.email_address,users.user_type,users.id,users.registration_no');
		$this->db->from('users');
		$this->db->where('user_type',$usertype);
		$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
		$this->db->order_by('id', 'DESC');
		return $team_users = $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
	}// End search_doctor_pharmacist();

	// Start Function search_prescriber()
	public function search_prescriber($data){
		
		extract($data);
		//$where = "(first_name LIKE '%$search%' || last_name LIKE '%$search%')";
		$this->db->dbprefix('users');
		$this->db->select('users.first_name, users.last_name, users.email_address,users.user_type,users.id,users.registration_no');
		$this->db->from('users');
		$this->db->where('is_prescriber','1');
		$this->db->where('email_verify_status','1');
		$this->db->where('admin_verify_status','1');
		$this->db->where("(users.email_address LIKE '%$search%' OR users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%')");
		$this->db->order_by('id', 'DESC');
		return $team_users = $this->db->get()->result_array();
		//echo $this->db->last_query(); exit;
		
	}// End search_prescriber();
	
	// Start Function add_update_default_user();
	public function add_update_default_user($data){
		
		extract($data);
		
		if($user_type_btn=='1'){
			$email_address = $this->db->escape_str(trim($doctor_email));
		} else if($user_type_btn=='2'){
		   $email_address = $this->db->escape_str(trim($pharmacist_email));
		}
		
		if($email_address!="") {
			
			$this->db->dbprefix('users');
			$this->db->select('email_address');
			$this->db->where('user_type',$user_type_btn);
			$this->db->where('email_address',$email_address);
			$this->db->from('users');
			$user_email = $this->db->get()->row_array();
			
			// check email exist or not
			if($user_email['email_address']!="") {
			$this->db->dbprefix('users');
			$this->db->select('id,is_default');
			$this->db->where('user_type',$user_type_btn);
			$this->db->where('is_default',1);
			$this->db->from('users');
			$team_users = $this->db->get()->row_array();
			
			$id = $team_users['id'];
			$ins_data['is_default'] = '0';
			
			$this->db->dbprefix('users');
			$this->db->where('user_type',$user_type_btn);
			$this->db->where('id',$id);
			$this->db->update('users',$ins_data);
		
			$ins_data['is_default'] = '1';
			
			$this->db->dbprefix('users');
			$this->db->where('email_address',$email_address);
			$this->db->where('user_type',$user_type_btn);
			$success = $this->db->update('users',$ins_data);
		} // End if($user_email['email_address']!=""
	 } // End if($email_address!="")
			
		if($success)
			return true;
		else 
			return false;		

	}// End Function add_update_default_user();

	// Start Function add_update_default_prescriber();
	public function add_update_default_prescriber($data){
		
		extract($data);
		
		$email_address = $this->db->escape_str(trim($prescriber_email));
		
		if($email_address!="") {
			
			$this->db->dbprefix('users');
			$this->db->select('email_address');
			$this->db->where('email_address',$email_address);
			$this->db->from('users');
			$user_email = $this->db->get()->row_array();
			
			//echo $this->db->last_query(); exit;
			
			// check email exist or not
			if($user_email['email_address']!="") {

				$update_data = array('system_prescriber' => '0');
				$this->db->dbprefix('users');
				$updated = $this->db->update('users', $update_data);
				
				$update_data = array('system_prescriber' => '1');
				$this->db->dbprefix('users');
				$this->db->where('email_address', $email_address);
				$updated = $this->db->update('users', $update_data);
				
				$system_default_prescriber = $this->patient->get_system_default_prescriber();

				$update_data = array(
									'email_address' => $system_default_prescriber['email_address'],
									'first_name' => $system_default_prescriber['first_name'],
									'last_name' => $system_default_prescriber['last_name'],
								);
				$this->db->dbprefix('admin');
				$this->db->where('login_user_type', 'prescriber');
				$this->db->where('id', '2');
				$updated = $this->db->update('admin', $update_data);
				
			}//end if($user_email['email_address']!="") 
			
			return true;
		} // End if($email_address!="") 
		
	}//end add_update_default_prescriber($data)
	
	 // End Function add_update_default_prescriber();
	
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
	
	//Function get_user_details(): Fetch the user details from user table using User_id
	public function get_user_details($user_id=''){
		
		$this->db->dbprefix('users');
		
		$this->db->select('users.*,CONCAT(first_name," ",last_name) AS user_full_name,usertype.id AS user_type_id, usertype.user_type AS user_type_name');

		if(trim($user_id) !='')$this->db->where('users.id',$user_id);
		
		$this->db->join('usertype','users.user_type = usertype.id','LEFT');
		$get_user= $this->db->get('users');
		$row_arr = $get_user->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	}//end get_user_by_email()
	
	public function import_user_record($data){

		// Uploading PGD Green Image
		if($_FILES['csv']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['csv']['name'],'.')),'.'); 			
			$file_name ='import-users-ref-'.rand().'.csv';

			$config['upload_path'] = './assets/csv/';
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '2000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('csv')){
				echo $this->upload->display_errors();
			}else{
				
				//$data_image_upload = array('upload_image_data' => $this->upload->data());
				// $ins_data['csv'] = $this->db->escape_str(trim($file_name));
				
			}//end if(!$this->upload->do_upload('csv'))
			
		}//end if($_FILES['csv']['name'] != '')

		$result =  $this->csvreader->parse_file(CSV.$file_name);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$email_exist_str = array();
		
		if(count($result) > 0){
			
			foreach($result as $index => $val_arr){
				
				$verify_if_email_already = $this->verify_if_email_already_exist(trim($val_arr['Email']));
				
				if($verify_if_email_already || !filter_var(trim($val_arr['Email']), FILTER_VALIDATE_EMAIL)){
					
					$email_exist_str[] = trim($val_arr['Email']);
					
				}else{
				
					if($val_arr['User_Type'] == 1)
						$registration_type = 'GMC';
					
					elseif($val_arr['User_Type'] == 2)
						$registration_type = 'GPhC';
					 
					elseif($val_arr['User_Type'] == 3)
						$registration_type = 'NMC';
					//end if($user_type == 1)
					
					$password = ucwords(substr(trim($val_arr['First_Name']),0,1).substr(trim($val_arr['Last_Name']),0,1)).$val_arr['Reg_No'];
					$password =  md5($password);
				 
					//Record insert into database
					$ins_data = array(
					
						'user_type' => $this->db->escape_str(trim($val_arr['User_Type'])),
						'first_name' => $this->db->escape_str(trim($val_arr['First_Name'])),
						'last_name' => $this->db->escape_str(trim($val_arr['Last_Name'])),
						'mobile_no' => $this->db->escape_str(trim($val_arr['Mobile_No'])),
						'email_address' => $this->db->escape_str(trim($val_arr['Email'])),
						'password' => $this->db->escape_str(md5((trim($password)))),
						'registration_no' => $this->db->escape_str(trim($val_arr['Reg_No'])),
						'registration_type' => $this->db->escape_str(trim($registration_type)),
						'is_prescriber' => $this->db->escape_str(trim($val_arr['Is_Prescriber'])),
						'is_owner' => $this->db->escape_str(trim(0)),
						'email_verify_status' => $this->db->escape_str(1),
						'admin_verify_status' => $this->db->escape_str(1),
						'created_date' => $this->db->escape_str(trim($created_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					);
				
					//Inserting User data into the database. 
					$this->db->dbprefix('users');
					$ins_into_db = $this->db->insert('users', $ins_data);
				
				}//end if($verify_if_email_already)
				
			}//end for($i=0;$i<count($result);$i++)
		}//end if(count($result) > 0)
		
		if(count($email_exist_str) == 0)
			return true;
		else
			return $email_exist_str;
		
	}//end function import_user_record($data)

	//Function verify_if_email_already_exist(): Verify if the email already exist before registration.
	public function verify_if_email_already_exist($email_address){
			
		$this->db->dbprefix('users');
		$this->db->where('email_address', $email_address);

		$get = $this->db->get('users');
		
		if($get->num_rows() > 0)
			return true;	
		else
			return false;
		
	} // end verify_if_email_already_exist	
	
	//Function get_old_user_list($users_id): Get Users details from users table via user id
	public function get_old_user_list($users_id = ''){

		$this->db->dbprefix('old_users');
		$this->db->select('old_users.*,buyinggroups.buying_groups');
		$this->db->from('old_users');
		$this->db->join('buyinggroups', 'old_users.groupid = buyinggroups.id', 'left'); 
		if(trim($users_id) !='')$this->db->where('old_users.userid',$users_id);
		$this->db->where('old_users.save_status',1);
		//$this->db->where('old_users.groupid',1);
		$get_users= $this->db->get();
		//echo $this->db->last_query(); 		exit;
		
		if(trim($users_id) !='')
			return $get_users->row_array();
		else 
			return $get_users->result_array();
		
	}//end get_old_user_list($users_id)
	
	
	//Function get_old_user_type($users_id): Get Users details from users table via user id
	public function get_old_user_type(){

		$this->db->dbprefix('usertype');
		$this->db->select('usertype.*');
		$this->db->from('usertype');
		$get_users= $this->db->get();
		//echo $this->db->last_query(); 		exit;
	    return $get_users->result_array();
		
	}//end get_old_user_list($users_id)
	
	//GET All ACTIVE BUYING GROUP OLD USER
	public function get_active_buyinggroups(){
		
		$this->db->dbprefix('buyinggroups');
		$this->db->where('status',1);
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('buyinggroups');
		
		return $list_arr->result_array();
		
	}//end get_active_buyinggroups()
	
	//GET All ACTIVE USER COUNTRY FOR OLD USER
	public function get_active_countries(){
		
		$this->db->dbprefix('country');
		$this->db->where('status',1);
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('country');
		
		return $list_arr->result_array();
		
	}//end get_active_country()
	
	//GET All ACTIVE USER Cities For OLD user
	public function get_active_cities(){
		
		$this->db->dbprefix('cities');
		$this->db->where('status',1);
		$this->db->order_by('id ASC');
		$list_arr = $this->db->get('cities');
		
		return $list_arr->result_array();
		
	}//end get_active_cities()
	
	//Function old_user_old(): Add new user into the database
	public function old_user_old($data){
		
		extract($data);
		
		//print_this($data); exit;
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		//Generate Random code	
		 $email_activation_code = $this->common->random_number_generator(10);
		 
		 if($user_type == 1){
			 
			$registration_type = 'GMC';
		 
		 }elseif($user_type == 2 || $user_type == 6 ){
			 
			$registration_type = 'GPhC';
			 
		 }elseif($user_type == 3){
			 
			$registration_type = 'NMC';
			 
		 }//end if($user_type == 1)
		 
		$this->db->dbprefix('old_users');		
		$this->db->select('old_users.*');
		$this->db->where('old_users.userid',$user_id);
		$get_user= $this->db->get('old_users');
		$row_arr = $get_user->row_array();
		
		$is_owner = ($is_owner) ? $is_owner : '0';
		
		//Record insert into database
		$ins_data = array(
		
			'user_type' => $this->db->escape_str(trim($user_type)),
			'first_name' => $this->db->escape_str(trim($first_name)),
			'last_name' => $this->db->escape_str(trim($last_name)),
			'mobile_no' => $this->db->escape_str(trim($mobile_no)),
			'email_address' => $this->db->escape_str(trim($email_address)),
			'registration_no' => $this->db->escape_str(trim($registration_no)),
			'registration_type' => $this->db->escape_str(trim($registration_type)),
			'password' => $this->db->escape_str(((trim($row_arr['password'])))),
			'is_locum' => $this->db->escape_str(trim($is_locum)),
			'is_prescriber' => $this->db->escape_str(trim($is_prescriber)),
			'is_owner' => $this->db->escape_str(trim($is_owner)),
			'email_verify_status' => $this->db->escape_str(1),
			'admin_verify_status' => $this->db->escape_str(1),
			'activation_code' => $this->db->escape_str(trim(md5($email_activation_code))),
			'buying_group_id' => $this->db->escape_str(trim($org_buying_group)),
			'created_date' => $this->db->escape_str(trim($row_arr['dateregistered'])),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);

	
		//If is_pres == 1, take the speciality field, otherwise leave it blank
		$ins_data['speciality'] = ($is_prescriber == 1) ? $this->db->escape_str(trim($speciality)) : '';
		
		//If usertype = 1 (doctor) he will always be a prescriber
		$ins_data['is_prescriber'] = ($user_type == 1) ? $this->db->escape_str(trim(1)) : $this->db->escape_str(trim($is_prescriber));
		
		//Inserting User data into the database. 
		$this->db->dbprefix('users');
		$ins_into_db = $this->db->insert('users', $ins_data);
		
		$new_user_id = $this->db->insert_id();
		
		//If Locum Selected as 1, enter the locum cities into the database.
		if($is_locum == 1){
			
			for($i=0;$i<count($location_arr);$i++){

				$ins_data = array(
				
					'user_id' => $this->db->escape_str(trim($new_user_id)),
					'city_id' => $this->db->escape_str(trim($location_arr[$i])),
					'created_date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				);
				
				//Inserting Locum cities into the database. 
				$this->db->dbprefix('locum_cities');
				$ins_into_db = $this->db->insert('locum_cities', $ins_data);
				
			}//end for($i=0;$i<count($location_arr);$i++)
			
		}//end if($is_locum == 1)
		

		//IF The User is also registring the Organization.
		if($is_owner == 1){

			//Record insert into organization database
			
			// Organization Post code remove spance
			$org_postcode = str_replace(' ', '', $org_postcode);
			
			$ins_data = array(
			
				'owner_id' => $this->db->escape_str(trim($new_user_id)),
				'company_name' => $this->db->escape_str(trim($company_name)),
				'address' => $this->db->escape_str(trim($org_address)),
				'contact_no' => $this->db->escape_str(trim($org_contact)),
				'postcode' => $this->db->escape_str(trim($org_postcode)),
				'country_id' => $this->db->escape_str(trim($org_country)),
				// 'buying_group_id' => $this->db->escape_str(trim($org_buying_group)),
				'status' => $this->db->escape_str(trim(1)),
				'created_date' => $this->db->escape_str(trim($row_arr['dateregistered'])),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Inserting User data into the database. 
			$this->db->dbprefix('organization');
			$this->db->insert('organization', $ins_data);
		
			$organization_id = $this->db->insert_id();
			
			//Inserting Global Settings record into the Organization Global Setting Table
			$ins_data = array(
			
				'organization_id' => $this->db->escape_str(trim($organization_id)),
				'governance_status' => $this->db->escape_str('1'),
				'online_doctor_status' => $this->db->escape_str('1'),
				'survey_status' => $this->db->escape_str('1'),
				'pmr_status' => $this->db->escape_str('1'),
				'todolist_status' => $this->db->escape_str('1'),
				'ipos_status' => $this->db->escape_str('1'),
				'created_date' => $this->db->escape_str(trim($$row_arr['dateregistered'])),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			//Inserting User data into the database. 
			$this->db->dbprefix('org_global_settings');
			$this->db->insert('org_global_settings', $ins_data);
			
			// Make a copy of Governance and SOPs, Get Governance
			$this->db->dbprefix('package_governance');
			$this->db->where('id', 1);
			$governance = $this->db->get('package_governance')->row_array();
			
			// Ready Organization Governance data and insert into db ( Table - org_governance )
			$insert_governance = array('organization_id' => $organization_id, 'governance_text' => $governance['governance_text'], 'sop_text' => $governance['sop_text'], 'finish_text' => $governance['finish_text']);
			
			$this->db->dbprefix('org_governance');
			$ins_into_db = $this->db->insert('org_governance', $insert_governance);
			
			//Get SOPs Categories and Make a COPY into the Organization SOP Table.

			// Get SOPs
			$this->db->dbprefix('sop_categories');
			$sop_categories = $this->db->get('sop_categories')->result_array();
			
			// Ready Organization SOP Categories data and insert into db ( Table - org_sop_categories )
			if(!empty($sop_categories)){
				
				foreach($sop_categories as $each){
					
					$insert_sop_categories = array('organization_id' => $organization_id, 
												'category_name' => $each['category_name'], 
												'status' => 1, 
												'created_date' => date('Y-m-d H:i:s'), 
												'created_ip' => $this->input->ip_address()
											);
					
					$this->db->dbprefix('org_sop_categories');
					$ins_into_db = $this->db->insert('org_sop_categories', $insert_sop_categories);
					
					$new_category_insert_id = $this->db->insert_id();
					
					//Getting LIst of default SOP's added by system and sending the copy to the Organization SOP
					$get_sops_list = $this->governance->get_sops_list('',$each['id']);
					
					for($i=0;$i<count($get_sops_list);$i++){
						
						$insert_sop = array('organization_id' => $organization_id, 
											'category_id' => $new_category_insert_id, 
											'user_types' => $get_sops_list[$i]['user_types'],
											'sop_title' => $get_sops_list[$i]['sop_title'], 
											'sop_description' => $get_sops_list[$i]['sop_description'], 
											'status' => 1, 
											'created_date' => date('Y-m-d H:i:s'), 
											'created_ip' => $this->input->ip_address()
										);

						$this->db->dbprefix('org_sops');
						$ins_into_db = $this->db->insert('org_sops', $insert_sop);
						
					}//end for($i=0$i<count($result_sop)$i++)
					
				}//end foreach($sop_categories as $each)
				
			}//end if(!empty($sop_categories))
			
		}//end if($is_owner == 1)
		
		
		if($ins_into_db){
		
			$upd_data_old = array('save_status' => '0');	
			//update  data into the database. 
			$this->db->dbprefix('old_users');
			$this->db->where('userid',$row_arr['userid']);
			$upd_into_db = $this->db->update('old_users', $upd_data_old);
		
		}
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	}// 
	
		//Function verify_if_email_already_exist(): Verify if the email already exist before registration.
	public function verify_if_email_already_exist_old_user($email_address){
			
		$this->db->dbprefix('users');
		$this->db->where('email_address', $email_address);

		$get = $this->db->get('users');
		
		if($get->num_rows() > 0)
			return true;	
		else
			return false;
		
	} // end verify_if_email_already_exist	
	
	public function reset_quiz_attempts($purchase_id){

		$upd_data = array('no_of_attempts' => '0');	
		
		//update  data into the database. 
		$this->db->dbprefix('user_order_details');
		$this->db->where('id',$purchase_id);
		$upd_into_db = $this->db->update('user_order_details', $upd_data);
		
		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end reset_quiz_attempts($purchase_id)
	
}//end file
?>