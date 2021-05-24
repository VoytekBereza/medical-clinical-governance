<?php
class Organization_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function verify_if_user_in_organization():
	public function verify_if_user_in_organization($user_id){

		$quiz_qry = "SELECT (
				
					EXISTS (SELECT id from kod_organization where superintendent_id = ".$user_id.") OR 
					EXISTS (SELECT id from kod_org_pharmacy_surgery where manager_id = ".$user_id." AND is_deleted = '0') OR
					EXISTS (SELECT id from kod_users where is_owner = 1 AND id = ".$user_id.") OR
					EXISTS (SELECT id from kod_pharmacy_surgery_staff where user_id = ".$user_id.") 
				
				) AS is_part_of_organization;";

		$rs  = $this->db->query($quiz_qry);
		$result = $rs->row_array();
		//echo $this->db->last_query(); 		exit;

		return $result['is_part_of_organization'];

	}//end verify_if_user_in_organization($user_id)

	//Function user_already_superintendent(): Will check if the user ID already is a SI in any organization already.
	public function user_already_superintendent($user_id){

		$this->db->dbprefix('organization');
		$this->db->select('organization.*,org_global_settings.governance_status, org_global_settings.online_doctor_status, org_global_settings.survey_status, org_global_settings.pmr_status,	users.id AS superintendent_user_id,users.user_type AS si_user_type, users.first_name AS si_first_name, users.last_name AS si_last_name, CONCAT(first_name," ",last_name) AS superintendent_full_name, users.email_address as si_email_address, users.registration_no si_registration,  users.registration_type AS si_registration_type, users.is_prescriber AS si_is_prescriber');
		$this->db->where('organization.superintendent_id',$user_id);
		
		$this->db->join('users','users.id = organization.superintendent_id','LEFT');
		$this->db->join('org_global_settings','organization.id = org_global_settings.organization_id','LEFT');
		$get = $this->db->get('organization');
		//echo $this->db->last_query(); 		exit;
		
		return $get->row_array();
		
	}//end user_already_superintendent()

	public function is_user_org_owner_si($user_id, $organization_id = ''){
	
		$this->db->dbprefix('organization');
		if(trim($organization_id)!= '') $this->db->where('id', $organization_id);
		$this->db->where('owner_id', $user_id);
		
		$row = $this->db->get('organization')->row_array();
		if(!empty($row))
			return $row;
		else
			return false;
		// if(!empty($row))
	
	} // public function is_user_org_owner_si($user_id, $organization_id)
	
	public function get_my_organizations($user_id){
		
		//Organization Table
		$this->db->dbprefix('organization');
		$this->db->select('organization.id, organization.company_name, organization.address, organization.postcode');
		$this->db->where('owner_id', $user_id);
		$this->db->or_where('superintendent_id', $user_id);
		
		$get = $this->db->get('organization');
		
		$organization_arr = $get->result_array();

		//User table for Manager
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('organization.id, organization.company_name, organization.address, organization.postcode');
		
		$this->db->where('org_pharmacy_surgery.manager_id', $user_id);
		
		$this->db->join('organization','org_pharmacy_surgery.organization_id = organization.id', 'left');
		
		$get_manager = $this->db->get('org_pharmacy_surgery');
		$manager_org = $get_manager->result_array();
		
		$organization_arr = array_merge($organization_arr,$manager_org);
		
		//Staff Members

		//User table for Manager
		$this->db->dbprefix('pharmacy_surgery_staff');
		$this->db->select('organization.id, organization.company_name, organization.address, organization.postcode');
		
		$this->db->where('pharmacy_surgery_staff.user_id', $user_id);
		
		$this->db->join('organization','pharmacy_surgery_staff.organization_id = organization.id', 'left');
		
		$get_staff = $this->db->get('pharmacy_surgery_staff');
		$staff_org = $get_staff->result_array();
		
		$organization_arr = array_merge($organization_arr,$staff_org);
		
		return $organization_arr;
		
	}//end get_my_organizations($user_id)

	// Start - get_my_pharmacies_surgeries(): Returns List of all Pharmaices where user actually belongs too. This will create two arrays one for staff and another one for manager where it beloongs. $user_role = M will return just the list of a manager, ST will return both. 2 will return staff array
	public function get_my_pharmacies_surgeries( $user_id, $user_role = '', $organization_id = ''){
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.id AS pharmacy_surgery_id, org_pharmacy_surgery.organization_id, organization.company_name as organization_name, org_pharmacy_surgery.manager_id, org_pharmacy_surgery.pharmacy_surgery_name, org_pharmacy_surgery.email_address, org_pharmacy_surgery.address, org_pharmacy_surgery.postcode, org_pharmacy_surgery.contact_no, org_pharmacy_surgery.country_id, org_pharmacy_surgery.type, org_pharmacy_surgery.status');

		$this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id');
		$this->db->where('org_pharmacy_surgery.manager_id', $user_id);
		
		if($organization_id != '') $this->db->where('org_pharmacy_surgery.organization_id', $organization_id);

		$this->db->where('org_pharmacy_surgery.status', 1);
		$this->db->where('org_pharmacy_surgery.is_deleted', '0');
		
		$data['as_manager'] = $this->db->get('org_pharmacy_surgery')->result_array();
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.id as pharmacy_surgery_id, org_pharmacy_surgery.organization_id, organization.company_name as organization_name, 
						org_pharmacy_surgery.pharmacy_surgery_name, org_pharmacy_surgery.postcode, org_pharmacy_surgery.type, staff.id as staff_id');
		
		$this->db->from('org_pharmacy_surgery');
		
		$this->db->join('pharmacy_surgery_staff as staff', ' staff.pharmacy_surgery_id = org_pharmacy_surgery.id ');
		$this->db->join('users', ' users.id = staff.user_id ');
		$this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id');
		
		// If Pharmacy/Surgery is not deleted
		$this->db->where('org_pharmacy_surgery.status', 1);
		$this->db->where('org_pharmacy_surgery.is_deleted', '0');

		if($organization_id != '') $this->db->where('org_pharmacy_surgery.organization_id', $organization_id);
		
		$this->db->where('staff.user_id', $user_id);
		
		if(!empty($data['as_manager'])){
			foreach($data['as_manager'] as $each){
				
				$this->db->where('org_pharmacy_surgery.id !=', $each['pharmacy_surgery_id']);
				
			}//end foreach($data['as_manager'] as $each)
			
		}//end if(!empty($data['as_manager']))
		
		$data['as_staff'] = $this->db->get()->result_array();

		//print_this($data);
		//exit;

		//echo $this->db->last_query(); exit;
		if($user_role == 'M')
			return $data['as_manager'];
		elseif($user_role == 'ST')
			return $data['as_staff'];
		else
			return array_merge($data['as_manager'], $data['as_staff']);
		
	} // End - get_my_pharmacies_surgeries( $user_id )

	// Start - get_all_organizations(): Get all Organization for listing
	public function get_all_organizations(){
		
		$this->db->dbprefix('organization, users');
		$this->db->select('organization.*, users.first_name as si_first_name, users.last_name as si_last_name');
		$this->db->from('organization');
		$this->db->join('users', 'organization.superintendent_id = users.id', 'left');
		$this->db->order_by('organization.id', 'DESC'); 
		$organizations = $this->db->get()->result_array();
	
		foreach($organizations as $key => $each):
			
			$name = $this->get_user_name_by_id($each['owner_id']);
			$new_entries = array(
								'owner_first_name' => $name['first_name'], 
								'owner_last_name' => $name['last_name'], 
								'owner_email_address' => $name['email_address'], 
								'owner_password' => $name['password'],
								'org_owner_id' => $each['owner_id']
							);
								
			
			unset($each['owner_id']);
			
			$new_arr[] = array_merge($new_entries, $each);
			
		endforeach;
		    return $new_arr;
		
	} // End - get_all_organizations():
	
	// get_user_name_by_id
	private function get_user_name_by_id($user_id){
	
		$this->db->dbprefix('users');
		$this->db->select('first_name, last_name, email_address, password');
		$this->db->where('id', $user_id);
		
		return $this->db->get('users')->row_array();
			
	} // get_user_name_by_id

	// Start - get_all_pharmacy(): Get all Organization Pharmacy for listing
	public function get_all_pharmacy($organization_id = ''){
		
		$this->db->dbprefix('org_pharmacy_surgery, organization','users');
		$this->db->select('org_pharmacy_surgery.*, organization.id as OgId,users.first_name,users.last_name');
		$this->db->from('org_pharmacy_surgery');
		$this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id', 'inner'); 
		$this->db->join('users', 'org_pharmacy_surgery.manager_id = users.id', 'left');
		
		if($organization_id != '') 
			$this->db->where('organization_id',$organization_id);
			
		$this->db->where('org_pharmacy_surgery.is_deleted!=', '1');
		$this->db->order_by('org_pharmacy_surgery.id', 'DESC'); 
		return  $pharmacy = $this->db->get()->result_array();
			
	} // get_all_pharmacy
	
	// Start - get_organizaiotion_company_name(): Get all Organization Company Name
	public function get_organizaiotion_company_name($organization_id){
		
		$this->db->dbprefix('organization,org_pharmacy_surgery');
		$this->db->select('organization.company_name,org_pharmacy_surgery.pharmacy_surgery_name');
		$this->db->from('organization');
		$this->db->join('org_pharmacy_surgery', 'organization.id = org_pharmacy_surgery.organization_id', 'inner');
		$this->db->where('org_pharmacy_surgery.organization_id',$organization_id);
		$this->db->where('org_pharmacy_surgery.is_deleted!=', '1');
		return  $organization_company = $this->db->get()->row_array();
			
	} // get_organizaiotion_company_name
	
	// Start - get_organizaiotion_company_name(): Get all Organization Company Name
	public function get_organizaiotion_company_name_for_staff($organization_id,$pharmacy_id){
		
		$this->db->dbprefix('organization,org_pharmacy_surgery');
		$this->db->select('organization.company_name,org_pharmacy_surgery.pharmacy_surgery_name');
		$this->db->from('organization');
		$this->db->join('org_pharmacy_surgery', 'organization.id = org_pharmacy_surgery.organization_id', 'inner');
		$this->db->where('org_pharmacy_surgery.organization_id',$organization_id);
		$this->db->where('org_pharmacy_surgery.id',$pharmacy_id);
		$this->db->where('org_pharmacy_surgery.is_deleted!=', '1');
		return  $organization_company = $this->db->get()->row_array();
			
	} // get_organizaiotion_company_name
	
	// Start - get_all_pharmacy_staff(): Get all Organization Pharmacy Staff for listing
	public function get_all_pharmacy_staff($pharmacy_id){
		
		$this->db->dbprefix('pharmacy_surgery_staff, org_pharmacy_surgery , organization , users,usertype');
		$this->db->select('pharmacy_surgery_staff.*, org_pharmacy_surgery.pharmacy_surgery_name,org_pharmacy_surgery.type,organization.company_name, users.first_name,users.last_name,users.user_type,users.mobile_no,users.email_address,usertype.user_type as TypeName');
		$this->db->from('pharmacy_surgery_staff');
		$this->db->join('org_pharmacy_surgery', 'pharmacy_surgery_staff.pharmacy_surgery_id = org_pharmacy_surgery.id', 'inner'); 
		$this->db->join('organization', 'pharmacy_surgery_staff.organization_id = organization.id', 'inner');
		$this->db->join('users', 'pharmacy_surgery_staff.user_id = users.id', 'left');
		$this->db->join('usertype', 'users.user_type = usertype.id', 'inner');
		$this->db->where('pharmacy_surgery_staff.pharmacy_surgery_id',$pharmacy_id);
		$this->db->where('org_pharmacy_surgery.is_deleted!=', '1');
		$this->db->order_by('pharmacy_surgery_staff.id', 'DESC'); 
	    return  $pharmacy_staff = $this->db->get()->result_array();
		
		/*echo '<pre>';
		print_r($pharmacy_staff);
		exit;*/
			
	} // get_all_pharmacy_staff
	
		// Start - get_all_pharmacy(): Get all Organization Pharmacy for listing
	public function get_all_pharmacies_list(){
		
		$this->db->dbprefix('org_pharmacy_surgery, organization','users,pharmacy_surgery_global_settings');
		$this->db->select('org_pharmacy_surgery.*, organization.id as OgId,users.first_name,users.last_name,pharmacy_surgery_global_settings.embed_status');
		$this->db->from('org_pharmacy_surgery');
		$this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id', 'inner'); 
		$this->db->join('pharmacy_surgery_global_settings', 'pharmacy_surgery_global_settings.pharmacy_surgery_id = org_pharmacy_surgery.id', 'inner'); 
		$this->db->join('users', 'org_pharmacy_surgery.manager_id = users.id', 'left');
		$this->db->where('org_pharmacy_surgery.is_deleted!=', '1');
		$this->db->order_by('org_pharmacy_surgery.id', 'DESC'); 
		return  $pharmacy = $this->db->get()->result_array();
			
	} // get_all_pharmacies_list
	
	public function update_embed_code_enable_disable_pharamacies($data){
		
		extract($data);
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		// array post
		$arr_val = $data['embad_pharmacies'];
		 
		 foreach($arr_val as $id){
			 
		//Record Update into database
		
		   $ins_data['embed_status']= $embed_status;
		
			//update  data into the database. 
			$this->db->dbprefix('pharmacy_surgery_global_settings');
			$this->db->where('pharmacy_surgery_id',$id);
			$ins_into_db = $this->db->update('pharmacy_surgery_global_settings', $ins_data);
			//echo $this->db->last_query(); 		 exit;
						
		 }// end foreach loop
		 
		 if($ins_into_db)
			return true;
			else
			return false;
	
	} // end update_embed_code_enable_disable_pharamacies
	
	
	//Function get_organization_details(): Fetch teh Organization details from organization table using Organiation_id along with SI 
	public function get_organization_details($org_id){
		
		$this->db->dbprefix('organization');
		$this->db->select('organization.*,org_global_settings.governance_status, org_global_settings.online_doctor_status, org_global_settings.survey_status, org_global_settings.pmr_status,users.id AS superintendent_user_id,users.user_type AS si_user_type, users.first_name AS si_first_name, users.last_name AS si_last_name, CONCAT(first_name," ",last_name) AS superintendent_full_name, users.email_address as si_email_address, users.registration_no si_registration, users.registration_type AS si_registration_type, users.is_prescriber AS si_is_prescriber');
		$this->db->where('organization.id',$org_id);
		
		$this->db->join('users','users.id = organization.superintendent_id','LEFT');
		$this->db->join('org_global_settings','organization.id = org_global_settings.organization_id','LEFT');
		$get = $this->db->get('organization');
		$row_arr = $get->row_array();
		//echo $this->db->last_query(); 		exit;
		return $row_arr;		
		
	}//end get_organization_details
	
	
	// Start - get_pharmacy_surgery_details($pharmacy_id)
	public function get_pharmacy_surgery_details($pharmacy_id){
		
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->select('org_pharmacy_surgery.*,organization.company_name as organization_name, pharmacy_surgery_global_settings.governance_status, pharmacy_surgery_global_settings.online_doctor_status, pharmacy_surgery_global_settings.survey_status, pharmacy_surgery_global_settings.pmr_status, pharmacy_surgery_global_settings.todolist_status, pharmacy_surgery_global_settings.ipos_status, pharmacy_surgery_global_settings.no_of_surveys, pharmacy_surgery_global_settings.embed_status');
		
		$this->db->join('organization','org_pharmacy_surgery.organization_id = organization.id','INNER');
		$this->db->join('pharmacy_surgery_global_settings','org_pharmacy_surgery.id = pharmacy_surgery_global_settings.pharmacy_surgery_id','LEFT');
		
		$this->db->where('org_pharmacy_surgery.id', $pharmacy_id);
		
		return $this->db->get('org_pharmacy_surgery')->row_array();
		
	} // End - get_pharmacy_surgery_details($pharmacy_id)
	
	// Start - get_organizaiotion_company_name(): Get all Organization Company Name
	public function get_organizaiotion_detail($organization_id){
		
		$this->db->dbprefix('organization');
		$this->db->select('organization.*');
		$this->db->from('organization');
		$this->db->where('id',$organization_id);
		return  $organization_company = $this->db->get()->row_array();
			
	} // get_organizaiotion_company_name
		
	// get_all_pharmacy_ajax_call
	public function get_all_pharmacy_ajax_call(){
		
        $aColumns = array('org_pharmacy_surgery.pharmacy_surgery_name','org_pharmacy_surgery.gphc_no', 'org_pharmacy_surgery.status','org_pharmacy_surgery.contact_no','org_pharmacy_surgery.postcode','organization.company_name');

        // DB table to use
        $sTable = 'org_pharmacy_surgery';
        
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
		
		$more_fields_to_search = array('org_pharmacy_surgery.pharmacy_surgery_name','org_pharmacy_surgery.gphc_no','org_pharmacy_surgery.status','org_pharmacy_surgery.contact_no','org_pharmacy_surgery.postcode','organization.company_name');
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
		
		$select = array('pharmacy_surgery_name','organization.company_name', 'org_pharmacy_surgery.contact_no','org_pharmacy_surgery.organization_id', 'org_pharmacy_surgery.manager_id','org_pharmacy_surgery.address','org_pharmacy_surgery.postcode','org_pharmacy_surgery.gphc_no','org_pharmacy_surgery.type','org_pharmacy_surgery.status','org_pharmacy_surgery.id','org_pharmacy_surgery.is_deleted','users.id as userid','users.first_name','users.last_name','org_pharmacy_surgery.enable_clinical_governance','org_pharmacy_surgery.enable_prescription','org_pharmacy_surgery.enable_register');

        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $select)), false);
		$this->db->dbprefix($sTable);
		$this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id', 'left'); 
		$this->db->join('users', 'organization.superintendent_id = users.id', 'left');
		$this->db->where(' (kod_org_pharmacy_surgery.is_deleted = "0" )' );
		$this->db->order_by('org_pharmacy_surgery.id', "DESC");
		
		$rResult = $this->db->get($sTable);
		
		//echo $this->db->last_query(); exit;
		
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
		
		//print_this($data_db); exit;

		
        foreach( $data_db as $aRow){
			
			// is_deleted not equel to 1 is_deleted 1 mean( deleted)
			if($aRow['is_deleted'] !=1) {
			
					$row = array();
					$option_html = '';
					
					$get_user_data = $this->users->get_users_details($aRow['manager_id']);
					$get_user_supertintendent = $this->get_organizaiotion_superintendent_name($aRow['organization_id']);
					
					foreach($select as $col)
					{
						//get_users_details[]
						
						if($aRow['enable_clinical_governance'] == '1'){
							$class_c = 'btn-success';
							$text_c = 'Unassign';
						}else{
							$class_c = 'btn-danger';
							$text_c = 'Assign';
						}
						
						
						if($aRow['enable_prescription'] == '1'){
							$class_p = 'btn-success';
							$text_p = 'Unassign';
						}else{
							$class_p = 'btn-danger';
							$text_p = 'Assign';
						}
						
						if($aRow['enable_register'] == '1'){
							$class_r = 'btn-success';
							$text_r = 'Unassign';
						}else{
							$class_r = 'btn-danger';
							$text_r = 'Assign';
						}
						
						$governance_purchased = $this->governance->get_governance_purchased_pharmacies($aRow['organization_id'], 'P', $aRow['id']);

						$governance_id = '';
						if($governance_purchased){
							
							$class_g = 'btn-success';
							$text_g = 'Unassign';
							$action_g = 'unassign';
							$governance_id = $governance_purchased['order_id'];
						}else{
							$class_g = 'btn-danger';
							$text_g = 'Assign';
							$action_g = 'assign';
							
						}//end if($governance_purchased)
						
						if($col == 'pharmacy_surgery_name'){
							 if($aRow['pharmacy_surgery_name'] !=''){ $row[] = ucfirst(filter_string($aRow['pharmacy_surgery_name']));} else {$row[] ='--';}
							 
						}elseif($col == 'organization.company_name'){
							$row[] = ucfirst(filter_string($aRow['company_name']));
						
						}elseif($col == 'org_pharmacy_surgery.contact_no'){
							if($aRow['contact_no'] !=''){ $row[] = filter_string($aRow['contact_no']);} else { $row[] = '--'; }
							
						}elseif($col == 'org_pharmacy_surgery.organization_id'){
							$row[] = ucfirst(filter_string($get_user_supertintendent['first_name']).' '.filter_string($get_user_supertintendent['last_name']));
							
						}elseif($col == 'org_pharmacy_surgery.manager_id'){
							
							if($aRow['manager_id'] !='' && $aRow['manager_id']!='0'){ $row[] = ucfirst(filter_string($get_user_data['first_name']).' '.filter_string($get_user_data['last_name']));} else { $row[] = '--';}
							
							
						}elseif($col == 'org_pharmacy_surgery.address'){
							 if($aRow['address'] !=''){ $row[] = filter_string($aRow['address']).', '.filter_string($aRow['postcode']);} else { $row[] = '--'; }
							
						}elseif($col == 'org_pharmacy_surgery.gphc_no'){
							
							if($aRow['gphc_no'] !=''){ $row[] = $aRow['gphc_no'];} else { $row[] = "--";}
							
						}elseif($col == 'org_pharmacy_surgery.type'){
						
							if($aRow['type'] !='' && $aRow['type']=='P'){ 
								$row[] = "Pharmacy (ID:".$aRow['id'].")";
							}else if($aRow['type'] !='' && $aRow['type']=='S') { 
								$row[] = "Surgery (ID:".$aRow['id'].")";
							} else { 
								$row[] = '--';
							}
							
						}elseif($col == 'org_pharmacy_surgery.status'){
							if($aRow['status'] == '0') { $row[] =  'InActive';} else { $row[] =  'Active';}
							
						}elseif($col == 'org_pharmacy_surgery.id'){
					
							$row[] = '<a href="'.SURL.'organization/view-pharmacy-staff/'.$aRow['id'].'" class="btn btn-xs btn-info fancybox_view fancybox.ajax">Staff</a>
							
							<a href="'.base_url().'organization/update-pharmacy/'.$aRow["id"].'" target="_blank" type="button" class="btn btn-info btn-xs pull-rigth"><span class="glyphicon glyphicon-edit"></span></a>
							
							<a href="#" data-href="'.base_url().'organization/assign-unassign-pharmacy/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-c-'.$aRow["id"].'" class="btn '.$class_c.' btn-xs" >C</a>
							<a href="#" data-href="'.base_url().'organization/assign-unassign-pharmacy/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-p-'.$aRow["id"].'" class="btn '.$class_p.' btn-xs" >P</a>
				
							<a href="#" data-href="'.base_url().'organization/assign-unassign-pharmacy/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-r-'.$aRow["id"].'" class="btn '.$class_r.' btn-xs" >R</a>
							
							<a href="#" data-href="'.base_url().'organization/assign-unassign-governance/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-g-'.$aRow["id"].'" class="btn '.$class_g.' btn-xs" >G</a>
			
							<div class="modal fade" id="confirm-c-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<h4 class="modal-header">
											Confirmation
										</h4>
										<div class="modal-body">
											<p>Are you sure you want to '.strtolower($text_c).' the <strong>Clinical Governance</strong> for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).' '.$aRow["last_name"].'</strong>?</p>
										</div>
										<div class="modal-footer">
											<a href="'.base_url().'organization/assign-unassign-pharmacy/enable-clinical-governance/'.$aRow["id"].'" class="btn btn-danger">'.$text_c.'</a>
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										</div>
									</div>
								</div>
							</div>
							
							<div class="modal fade" id="confirm-p-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<h4 class="modal-header">
											Confirmation
										</h4>
										<div class="modal-body">
											<p>Are you sure you want to '.strtolower($text_p).' the <strong>Prescription</strong> for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).' '.$aRow["last_name"].'</strong>?</p>
										</div>
										<div class="modal-footer">
											<a href="'.base_url().'organization/assign-unassign-pharmacy/enable-prescription/'.$aRow["id"].'" class="btn btn-danger">'.$text_p.'</a>
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										</div>
									</div>
								</div>
							</div>
							
							<div class="modal fade" id="confirm-r-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<h4 class="modal-header">
											Confirmation
										</h4>
										<div class="modal-body">
											<p>Are you sure you want to '.strtolower($text_r).' the <strong>Register</strong> for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).' '.$aRow["last_name"].'</strong>?</p>
										</div>
										<div class="modal-footer">
											<a href="'.base_url().'organization/assign-unassign-pharmacy/enable-register/'.$aRow["id"].'" class="btn btn-danger">'.$text_r.'</a>
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										</div>
									</div>
								</div>
							</div>
							
							<div class="modal fade" id="confirm-g-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<h4 class="modal-header">
											Confirmation
										</h4>
										<div class="modal-body">
											<p>Are you sure you want to '.strtolower($text_g).' the <strong>Governance</strong> for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).' '.$aRow["last_name"].'</strong>?</p>
										</div>
										<div class="modal-footer">
											<a href="'.base_url().'organization/assign-unassign-governance/'.$action_g.'/'.$aRow["id"].'/'.$get_user_supertintendent['owner_id'].'/'.$governance_id.'" class="btn btn-danger">'.$text_g.'</a>
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						';
							
							
						}
						
					}//end of inner columns loop
					
					$output['aaData'][] = $row;
			
		  } // end if( $aRow['is_deleted'] !=1) 
        }
		
		header('Content-type: application/json');
        echo json_encode($output);	
	}
	
	// Start - get_organizaiotion_company_name(): Get all Organization Company Name
	public function get_organizaiotion_superintendent_name($organization_id){
		
		$this->db->dbprefix('organization,users');
		$this->db->select('organization.company_name, organization.owner_id, users.first_name,users.last_name');
		$this->db->from('organization');
		$this->db->join('users', 'users.id = organization.superintendent_id', 'left');
		$this->db->where('organization.id',$organization_id);
		return  $organization_supertintendentname = $this->db->get()->row_array();
			
	} // get_organizaiotion_company_name
	
	
	// Start - get_all_country()
	public function get_all_country(){
		
		$this->db->dbprefix('country');
		$this->db->where('status', 1);
		return $this->db->get('country')->result_array();
		
	} // End - get_all_country()
	
	
	// Start - add_update_pharmacy_surgery($data)
	public function add_update_pharmacy_surgery($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$postcode = str_replace(' ', '', $postcode);
				
		//Record insert into database
		$ins_data = array(
		
			'pharmacy_surgery_name' => $this->db->escape_str(trim($pharmacy_surgery_name)),
			'address' => $this->db->escape_str(trim($address)),
			'postcode' => $this->db->escape_str(trim($postcode)),
			'contact_no' => $this->db->escape_str(trim($contact_no)),
			'gphc_no' => $this->db->escape_str(trim($gphc_no)),
			'f_code' => $this->db->escape_str(trim($f_code)),
			'country_id' => $this->db->escape_str(trim($country_id)),
			
		);
		
		
		// Get Country Name by country id
		$this->db->dbprefix('country');
		$this->db->select('country_name');
		$this->db->from('country');
		$this->db->where('id', $country_id);
		$row = $this->db->get()->row_array();
		
		// Country Name
		$country_name =  filter_string($row['country_name']);
		
		// get latitude and longitude by address postcode and country name
		$long_lat_arr = get_longitude_latitude($address.","." ".$postcode.", ".$country_name);
		
		if($pharmacy_id !="") {

			$ins_data['modified_date'] = $this->db->escape_str(trim($created_date));
			$ins_data['modified_by_ip'] = $this->db->escape_str(trim($created_by_ip));
			$ins_data['latitude']        = $this->db->escape_str(trim($long_lat_arr['latitude'][0]));
			$ins_data['longitude']       = $this->db->escape_str(trim($long_lat_arr['longitude'][0]));
			
			//update  data into the database. 
			$this->db->dbprefix('org_pharmacy_surgery');
			$this->db->where('id',$pharmacy_id);
			$ins_into_db = $this->db->update('org_pharmacy_surgery', $ins_data);
			
		}//end if($pharmacy_id == '')
		
		if($ins_into_db)
			return true;
		else
			return false;
			
	} // End - add_update_pharmacy_surgery($data)
	

	// assign unassing Settings like register/ Prescription etc to pharamcy
	public function assign_unassign_pharmacy($name='',$pharmacy_id){
		
		$get_pharamcy_details = $this->get_pharmacy_surgery_details($pharmacy_id);
		
		if($name =='enable-clinical-governance'){
			
		if($get_pharamcy_details['enable_clinical_governance'] == '0')
			$upd_data = array('enable_clinical_governance' => '1');	
		else
			$upd_data = array('enable_clinical_governance' => '0');	
			
		} else if($name =='enable-prescription'){
			if($get_pharamcy_details['enable_prescription'] == '0')
				$upd_data = array('enable_prescription' => '1');	
		else
			$upd_data = array('enable_prescription' => '0');	
			
		}else if($name =='enable-register'){
			
			if($get_pharamcy_details['enable_register'] == '0')
				$upd_data = array('enable_register' => '1');	
		else
			$upd_data = array('enable_register' => '0');	
		}
		
		//end if($get_user_data['admin_verify_status'])
		
		//update  data into the database. 
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->where('id',$pharmacy_id);
		$upd_into_db = $this->db->update('org_pharmacy_surgery', $upd_data);
		
		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end assign_unassign($users_id)

	// assign unassing Settings like register/ Prescription etc to pharamcy
	public function assign_unassign_website($package,$pharmacy_id, $buying_group_id){
		
		$get_pharamcy_details = $this->get_pharmacy_surgery_details($pharmacy_id);

		if($package =='S'){
			
			if($get_pharamcy_details['website_package'] == 'S'){
				
				$new_package = 'REQUEST TO CANCEL STANDARD PACKAGE';

				$upd_data = array(
					'website_package' => NULL,
					'website_expiry' => NULL,
					'website_buying_group_id' => NULL
					);	//It is alreadt a Standard/ make it cancelled
				
			}elseif($get_pharamcy_details['website_package'] == 'P'){
				
				$new_package = 'STANDARD';
				
				//Previos package is already in Preimium, makeit S

				$upd_data = array(
					'website_package' => 'S',
					'website_expiry' => date('Y-m-d g:i:s', strtotime('+1 year')),
					'website_buying_group_id' => $buying_group_id
					);	//It is alreadt a Standard/ make it null
					
			}else{
				//Its already NULL make it S
				$new_package = 'STANDARD';
				$upd_data = array(
					'website_package' => 'S',
					'website_expiry' => date('Y-m-d g:i:s', strtotime('+1 year')),
					'website_buying_group_id' => $buying_group_id
					);	
				
			}
			
		}//end if($package =='S')

		if($package =='P'){
			
			if($get_pharamcy_details['website_package'] == 'P'){
				//It is already P make it null
				$new_package = 'REQUEST TO CANCEL PREIMIUM PACKAGE';
				
				$upd_data = array(
					'website_package' => NULL,
					'website_expiry' => NULL,
					'website_buying_group_id' => NULL
					);	
					
			}elseif($get_pharamcy_details['website_package'] == 'P'){
				
				//Previos package is already in Standard, makeit P
				$new_package = 'PRIMIUM';
				
				$upd_data = array(
					'website_package' => 'P',
					'website_expiry' =>date('Y-m-d g:i:s', strtotime('+1 year')),
					'website_buying_group_id' => $buying_group_id
					);	//It is alreadt a Standard/ make it null
				
			}else{
				//Its already NULL make it P
				$new_package = 'PRIMIUM';
				$upd_data = array(
					'website_package' => 'P',
					'website_expiry' => date('Y-m-d g:i:s', strtotime('+1 year')),
					'website_buying_group_id' => $buying_group_id
					);	
					
			}
			
		}//end if($package =='S')
		
		$organization_details = $this->get_organizaiotion_detail($get_pharamcy_details['organization_id']);
		$si_id = $organization_details = $organization_details['superintendent_id'];
		
		$si_details = $this->users->get_user_details($si_id);

		$pharmacy_str = '
					<table cellpadding="2" cellspacing="2" width="80%" style="font-family:Arial, Helvetica, sans-serif; font-size:14px">
				<tr>
					<td><strong>Package</strong></td>
					<td>'.$new_package.'</td>
				</tr>					
				<tr>
					<td width="37%"><strong>Pharmacy ID</strong></td>
					<td width="63%">'.filter_string($get_pharamcy_details['id']).'</td>
				</tr>
				<tr>
					<td width="37%"><strong>Pharmacy/ Surgery Name</strong></td>
					<td width="63%">'.filter_string($get_pharamcy_details['pharmacy_surgery_name']).'</td>
				</tr>
				<tr>
					<td><strong>Address</strong></td>
					<td>'.filter_string($get_pharamcy_details['address']).'</td>
				</tr>
			
				<tr>
					<td><strong>Postcode</strong></td>
					<td>'.filter_string($get_pharamcy_details['postcode']).'</td>
				</tr>
				<tr>
					<td><strong>Email Address</strong></td>
					<td>'.filter_string($si_details['email_address']).'</td>
				</tr>
			
				<tr>
					<td><strong>Premises No.</strong></td>
					<td>'.filter_string($get_pharamcy_details['contact_no']).'</td>
				</tr>
			
				<tr>
					<td><strong>GPhC No.</strong></td>
					<td>'.filter_string($get_pharamcy_details['gphc_no']).'</td>
				</tr>
			
				<tr>
					<td><strong>ODS Code</strong></td>
					<td>'.filter_string($get_pharamcy_details['f_code']).'</td>
				</tr>
			
				
				<tr>
					<td><strong>Request Date</strong></td>
					<td>'.date("d/m/Y G:i:s").'</td>
				</tr>
			
			</table>
		';
		

			$this->load->helper(array('email'));
			
			$email_body = $pharmacy_str;
			
			$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
			$noreply_email = get_global_settings($NOREPLY_EMAIL);
			
			$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
			$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
			
			$email_subject = 'Website Package Update for Pharmacy '.filter_string($get_pharamcy_details['pharmacy_surgery_name']).'';
			$email_address = 'twister787@gmail.com,iwebpros@gmail.com';
			
			$send_email = kod_send_email($noreply_email['setting_value'], $email_from_txt['setting_value'], $email_address, $email_subject, $email_body);
			
		//update  data into the database. 
		$this->db->dbprefix('org_pharmacy_surgery');
		$this->db->where('id',$pharmacy_id);
		$upd_into_db = $this->db->update('org_pharmacy_surgery', $upd_data);
		//echo $email_body; exit;
		if($upd_into_db)
			return true;
		else
			return false;
		
	}//end assign_unassign_website($users_id)

	// Renew Pharmacy Website subscription
	public function renew_website_subscription($pharmacy_id){
		
		
		$get_pharamcy_details = $this->get_pharmacy_surgery_details($pharmacy_id);

		$pharmacy_str = '
					<table cellpadding="2" cellspacing="2" width="80%" style="font-family:Arial, Helvetica, sans-serif; font-size:14px">
				<tr>
					<td colspan="2">Renewal Subscription request is received from Avicenna against Pharmacy: <strong>'.filter_string($get_pharamcy_details['id']).' - '.filter_string($get_pharamcy_details['pharmacy_surgery_name']).'</strong> on <strong>'.date('d/m/Y G:i').'</strong>. It is advised to take necessary action. 
					
					<br><br>
					
					Thank You!
					</td>
				</tr>					
			</table>
		';
		
		$this->load->helper(array('email'));
		
		$email_body = $pharmacy_str;
		
		$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
		$noreply_email = get_global_settings($NOREPLY_EMAIL);
		
		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
		$email_subject = 'Website Renewal Request from Avicenna for Pharmacy '.filter_string($get_pharamcy_details['pharmacy_surgery_name']).'';
		$email_address = 'twister787@gmail.com,iwebpros@gmail.com';
		
		$send_email = kod_send_email($noreply_email['setting_value'], $email_from_txt['setting_value'], $email_address, $email_subject, $email_body);
		
		return true;
			
		
	}//end renew_website_subscription($users_id)
	
	public function download_csv_file_pharmacies(){

		$this->load->dbutil();
	  
		$qry_user_data = $this->db->query("SELECT kod_org_pharmacy_surgery.id AS ID, kod_org_pharmacy_surgery.pharmacy_surgery_name AS PHARMACY_NAME, 
											kod_org_pharmacy_surgery.contact_no AS CONTACT_NO,kod_org_pharmacy_surgery.type AS PHARMACY_TYPE,
											kod_organization.company_name AS ORGANIZATION_NAME,
											CONCAT(kod_users.first_name,' ',kod_users.last_name) AS OWNER_NAME
											FROM `kod_org_pharmacy_surgery` 
											
											INNER JOIN `kod_organization` ON `kod_org_pharmacy_surgery`.`organization_id` = `kod_organization`.`id` 
											INNER JOIN `kod_users` ON `kod_organization`.`owner_id` = `kod_users`.`id` 

											WHERE kod_org_pharmacy_surgery.is_deleted!= '1' 
											
										");
	 
		$delimiter = ",";
		$newline = "\r\n";
		
		$download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);
		
		return $download_csv;
		
	}//end download_csv_file_users()
	
	public function unassign_governance($pharmacy_id, $order_id){
		
	}//end unassign_governance($pharmacy_id, $order_id)
	
}//end file

?>