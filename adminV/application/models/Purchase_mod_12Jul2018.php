<?php
class Purchase_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

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
				
			}elseif($row['product_type'] == 'PGD'){
				
				if($row['is_package'] == 1){
					
					$get_pgd_dtails = $this->pgd->get_pgd_details($row['product_id']);

					if($get_pgd_dtails['pgd_type'] == 'O'){
						//ORAL Package is Purchased
						$oral_package_purchased = 1;
						$package_expiry = $row['expiry_date'];
						$is_expired = ((strtotime(date('Y-m-d')) < strtotime($package_expiry)) || $package_expiry== '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1
						
					}elseif($get_pgd_dtails['pgd_type'] == 'OP'){

						//ORAL Package is Purchased
						$prem_oral_package_purchased = 1;
						$prem_oral_package_expiry = $row['expiry_date'];
						$prem_oral_is_expired = ((strtotime(date('Y-m-d')) < strtotime($prem_oral_package_expiry)) || $prem_oral_package_expiry == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1
						
					}//end if($get_pgd_dtails['pgd_type'] == 'O')
				}//end if($row['is_package'] == 1)
				
				$pgd_purchased_arr[$row['product_id']]= $row;
				
			}//end if($row['product_type'] == 'TRAINING')
			
		}//end foreach ($get->row_array() as $row)
		
		$data['training'] = $training_purchased_arr;
		$data['pgds']['pgd_list'] = $pgd_purchased_arr;
		$data['pgds']['package_purchased'] = $oral_package_purchased;
		$data['pgds']['package_expiry'] = $package_expiry;
		$data['pgds']['package_expired'] = $is_expired;

		$data['pgds']['premium_package_purchased'] = $prem_oral_package_purchased;
		$data['pgds']['premium_package_expiry'] = $prem_oral_package_expiry;
		$data['pgds']['premium_package_expired'] = $prem_oral_is_expired;
		
		return $data;

	}//end get_purchased_items($user_id)

	//Function generate_order_number(): Generate unique Order number, by recursive call.
	public function generate_order_number(){
		
		$new_order_no = strtoupper(ORDER_PREFIX.$this->common->random_number_generator(5));
		
		$this->db->dbprefix('user_orders');
		$this->db->select('id');
		$this->db->where('order_no',$new_order_no);
		$get = $this->db->get('user_orders');
		//echo $this->db->last_query(); 		exit;
		
		if($get->num_rows > 0)
			$this->generate_order_number();
		else
			return $new_order_no;
		
	}//end generate_order_number()
	
	
	//Function is_product_expired(): Will return tthe array if the product is NOT EXPIRED
	public function is_product_expired($product_id, $product_type, $user_id = '', $pharmacy_surgery_id = '', $organziation_id = ''){

		$this->db->dbprefix('user_order_details');
		if(trim($user_id) != '')  $this->db->where('user_id',$user_id);
		if(trim($pharmacy_surgery_id) != '')  $this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		if(trim($organziation_id) != '')  $this->db->where('organziation_id',$organziation_id);
		
		$this->db->where('product_type',$product_type);
		$this->db->where('product_id',$product_id);
		$this->db->where("(expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')"); //Is not Expired
		$get = $this->db->get('user_order_details');

		//echo $this->db->last_query();
		
		return $get->row_array();
		
	}//end is_product_expired($product_id, $product_type, $user_id = '', $pharmacy_surgery_id = '', $organziation_id = '')

	//Function add_pgd_to_order(): Store the PGD into the database for Avacinna
	public function add_pgd_to_order($pgd_id = '',$user_id,$pgd_type){
		
		$purchase_date = date('Y-m-d');
		$created_by_ip = $this->input->ip_address();
		
		//Generate unique Order Number
		$order_no = $this->purchase->generate_order_number();
		$org_ins_arr = array();
		
		if($organization_id && $organization_id!='')
			$org_ins_arr['organization_id'] = $organization_id;

		$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
		$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings

		if($pgd_type == "PGD"){

			$get_pgd_details = $this->pgd->get_pgd_details($pgd_id);
			$subtotal = ($get_pgd_details['discount_price'] != 0.00) ? $get_pgd_details['discount_price'] : $get_pgd_details['price'];
			
		}elseif($pgd_type == "ORAL") {

			$ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
			$global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);

			$ORAL_PGD_PACKAGE_PRICE = 'ORAL_PGD_PACKAGE_PRICE';
			$global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);

			$subtotal = ($global_oral_packages_discount_price['setting_value'] != 0.00) ? $global_oral_packages_discount_price['setting_value'] : $global_oral_package_price['setting_value'];
			
		}elseif($pgd_type == "P_ORAL"){
			
			$ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
			$global_premium_oral_packages_discount_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE);

			$ORAL_PREMIUM_PGD_PACKAGE_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_PRICE';
			$global_premium_oral_package_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_PRICE);

			$subtotal = ($global_premium_oral_packages_discount_price['setting_value'] != 0.00) ? $global_premium_oral_packages_discount_price['setting_value'] : $global_premium_oral_package_price['setting_value'];
			
		}// if($pgd_type == "PGD")

		$vat_amount = (trim($vat_percentage['setting_value']) / 100) * $subtotal;
		
		$vat_tax = $vat_amount;	
		$grand_total = $vat_tax + $subtotal;
		
		//Record insert into database
		$ins_data = array(
		
			'order_no' => $this->db->escape_str(trim($order_no)),
			'user_id' => $this->db->escape_str(trim($user_id)),
			'subtotal' => $this->db->escape_str(trim($subtotal)),
			'vat_tax' => $this->db->escape_str(trim($vat_tax)),
			'grand_total' => $this->db->escape_str(trim($grand_total)),
			'purchase_date' => $this->db->escape_str(trim($purchase_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		
		//Inserting User data into the database. 
		$this->db->dbprefix('user_orders');
		$ins_into_db = $this->db->insert('user_orders', $ins_data);
		$order_id = $this->db->insert_id();
		
		$product_id = $pgd_id;
		
		//If PGD do not add expiry date into the DB as expiry date will be active once the doc and pharmacist approve the PGD.
		$expiry_date = '0000-00-00';
		
		if($pgd_type == 'ORAL'){
			
			//Means the ORAL Package is part of the shopping cart, now add all Oral Packages into the database.
			$is_package = 1;
			
			$ORAL_PGD_PACKAGE_PRICE = 'ORAL_PGD_PACKAGE_PRICE';
			$global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);
			
			$ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
			$global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);
			
			if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00){
				$package_price = filter_price($global_oral_packages_discount_price['setting_value']);
				
			}else{
				$package_price = filter_price($global_oral_package_price['setting_value']);
				
			}//end if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00)

			//Get All List of Oral Packages
			$get_oral_pgds_list = $this->pgd->get_pgd_list('O');
			$split_price = (float) $package_price / count($get_oral_pgds_list);
			
			for($j=0;$j<count($get_oral_pgds_list);$j++){

				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim($get_oral_pgds_list[$j]['id'])),
						'price' => $this->db->escape_str(trim($split_price)),
						'product_type' => $this->db->escape_str(trim('PGD')),
						'is_package' => $this->db->escape_str(trim($is_package)),
						'expiry_date' => $this->db->escape_str(trim($expiry_date))
				);
				$ins_data = array_merge($ins_data,$org_ins_arr);
				$this->db->dbprefix('user_order_details');
				$this->db->insert('user_order_details', $ins_data);
	
				//Inserting copy of the product purchased in the Order History for references.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim($get_oral_pgds_list[$j]['id'])),
						'price' => $this->db->escape_str(trim($split_price)),
						'product_type' => $this->db->escape_str(trim('PGD')),
						'is_package' => $this->db->escape_str(trim($is_package)),
						'expiry_date' => $this->db->escape_str(trim($expiry_date)),
						'purchase_date' => $this->db->escape_str(trim($purchase_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				);
				
				$ins_data = array_merge($ins_data,$org_ins_arr);
				$this->db->dbprefix('user_order_history');
				$this->db->insert('user_order_history', $ins_data);

			}//end for($i=0;$i<count($get_oral_pgds_list);$i++)

			//Check if Yellow Fever, AntiMalaria, Anaphalxus is already Purchased but not expired.
			
			//ANTI-MALARIA: 
			/*
			$is_antimalaria_expired = $this->is_product_expired(21, 'PGD', $user_id);
			
			if(!$is_antimalaria_expired){
				
				//Product is expired. Or Does not Exist make an Insertion into the database.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim('21')),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00'))
				);
				
				$this->db->dbprefix('user_order_details');
				$this->db->insert('user_order_details', $ins_data);

				//Inserting copy of the product purchased in the Order History for references.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim(21)),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00')),
						'purchase_date' => $this->db->escape_str(trim($purchase_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
						
				);
				$this->db->dbprefix('user_order_history');
				$this->db->insert('user_order_history', $ins_data);
			}//end if(!$$is_antimalaria_expired)
			*/
					
		}elseif($pgd_type == 'P_ORAL'){

			//Means the ORAL Package is part of the shopping cart, now add all Oral Packages into the database.
			$is_package = 1;
			
			$ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
			$global_premium_oral_packages_discount_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE);

			$ORAL_PREMIUM_PGD_PACKAGE_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_PRICE';
			$global_premium_oral_package_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_PRICE);
			
			if(filter_string($global_premium_oral_packages_discount_price['setting_value']) != 0.00){
				$package_price = filter_price($global_premium_oral_packages_discount_price['setting_value']);
				
			}else{
				$package_price = filter_price($global_premium_oral_package_price['setting_value']);
				
			}//end if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00)

			//Get All List of Oral Packages
			$get_premium_oral_pgds_list = $this->pgd->get_pgd_list('OP');
			$split_price = (float) $package_price / count($get_premium_oral_pgds_list);
			
			for($j=0;$j<count($get_premium_oral_pgds_list);$j++){

				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim($get_premium_oral_pgds_list[$j]['id'])),
						'price' => $this->db->escape_str(trim($split_price)),
						'product_type' => $this->db->escape_str(trim('PGD')),
						'is_package' => $this->db->escape_str(trim($is_package)),
						'expiry_date' => $this->db->escape_str(trim($expiry_date))
				);
				$ins_data = array_merge($ins_data,$org_ins_arr);
				$this->db->dbprefix('user_order_details');
				$this->db->insert('user_order_details', $ins_data);
	
				//Inserting copy of the product purchased in the Order History for references.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim($get_premium_oral_pgds_list[$j]['id'])),
						'price' => $this->db->escape_str(trim($split_price)),
						'product_type' => $this->db->escape_str(trim('PGD')),
						'is_package' => $this->db->escape_str(trim($is_package)),
						'expiry_date' => $this->db->escape_str(trim($expiry_date)),
						'purchase_date' => $this->db->escape_str(trim($purchase_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				);
				
				$ins_data = array_merge($ins_data,$org_ins_arr);
				$this->db->dbprefix('user_order_history');
				$this->db->insert('user_order_history', $ins_data);

			}//end for($i=0;$i<count($get_premium_oral_pgds_list);$i++)
			
			
		}else{

			//This section is for Rest of the PGD's other than ORAL Packages!

			$product_expiry = $expiry_date;
			
			$is_travel = (filter_string($get_pgd_details['seasonal_travel']) == 'T') ? 1 : 0;
			$is_seasonal = (filter_string($get_pgd_details['seasonal_travel']) == 'S') ? 1 : 0;
			
			$is_package = 0;
			
			$ins_data = array(
					'order_id' => $this->db->escape_str(trim($order_id)),
					'user_id' => $this->db->escape_str(trim($user_id)),
					'product_id' => $this->db->escape_str(trim($product_id)),
					'price' => $this->db->escape_str(trim($subtotal)),
					'product_type' => $this->db->escape_str(trim('PGD')),
					'is_package' => $this->db->escape_str(trim($is_package)),
					'expiry_date' => $this->db->escape_str(trim($expiry_date))
			);

			$ins_data = array_merge($ins_data);
			$this->db->dbprefix('user_order_details');
			$this->db->insert('user_order_details', $ins_data);

			//Inserting copy of the product purchased in the Order History for references.
			$ins_data = array(
					'order_id' => $this->db->escape_str(trim($order_id)),
					'user_id' => $this->db->escape_str(trim($user_id)),
					'product_id' => $this->db->escape_str(trim($product_id)),
					'price' => $this->db->escape_str(trim($subtotal)),
					'product_type' => $this->db->escape_str(trim('PGD')),
					'is_package' => $this->db->escape_str(trim($is_package)),
					'expiry_date' => $this->db->escape_str(trim($expiry_date)),
					'purchase_date' => $this->db->escape_str(trim($purchase_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			);
			
			$ins_data = array_merge($ins_data);
			$this->db->dbprefix('user_order_history');
			$this->db->insert('user_order_history', $ins_data);

		}//end if($pgd_type == 'ORAL')

		if($is_travel){
			//Have the Travel PGD in it We need to insert Yellow Fever, Inaflexed and AntiMarlia PGDs into the database.
			
			//Check if Yellow Fever, AntiMalaria, Anaphalxus is already Purchased but not expired.
			
			//ANTI-MALARIA: 
			/*
			$is_antimalaria_expired = $this->is_product_expired(21, 'PGD', $user_id);
			if(!$is_antimalaria_expired){
				
				//Product is expired. Or Does not Exist make an Insertion into the database.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim('21')),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00'))
				);
				
				$this->db->dbprefix('user_order_details');
				$this->db->insert('user_order_details', $ins_data);

				//Inserting copy of the product purchased in the Order History for references.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim(21)),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00')),
						'purchase_date' => $this->db->escape_str(trim($purchase_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
						
				);
				$this->db->dbprefix('user_order_history');
				$this->db->insert('user_order_history', $ins_data);
				
			}//end if(!$$is_antimalaria_expired)

			//YELLOW FEVER: 
			$is_yellowfever_expired = $this->is_product_expired(22, 'PGD', $user_id);
			if(!$is_yellowfever_expired){
				
				//Product is expired. Or Does not Exist make an Insertion into the database.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim('22')),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00'))
				);
				
				$this->db->dbprefix('user_order_details');
				$this->db->insert('user_order_details', $ins_data);

				//Inserting copy of the product purchased in the Order History for references.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim(22)),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00')),
						'purchase_date' => $this->db->escape_str(trim($purchase_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
						
				);
				$this->db->dbprefix('user_order_history');
				$this->db->insert('user_order_history', $ins_data);
				
			}//end if(!$is_yellowfever_expired)

			//Anaphylaxis PGD
			$is_anaphylaxis_expired = $this->is_product_expired(24, 'PGD', $user_id);
			if(!$is_anaphylaxis_expired){
				
				//Product is expired. Or Does not Exist make an Insertion into the database.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim('24')),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00'))
				);
				
				$this->db->dbprefix('user_order_details');
				$this->db->insert('user_order_details', $ins_data);

				//Inserting copy of the product purchased in the Order History for references.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'product_id' => $this->db->escape_str(trim(24)),
						'price' => $this->db->escape_str(trim(0.00)),
						'product_type' => $this->db->escape_str('PGD'),
						'is_package' => $this->db->escape_str(trim(0)),
						'expiry_date' => $this->db->escape_str(trim('0000-00-00')),
						'purchase_date' => $this->db->escape_str(trim($purchase_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
						
				);
				$this->db->dbprefix('user_order_history');
				$this->db->insert('user_order_history', $ins_data);
				
			}//end if(!$$is_anaphylaxis_expired)
			*/
		}else{
			
			if($is_seasonal){
				/*
				//Anaphylaxis PGD
				$is_anaphylaxis_expired = $this->is_product_expired(24, 'PGD', $user_id);
				if(!$is_anaphylaxis_expired){
					
					//Product is expired. Or Does not Exist make an Insertion into the database.
					$ins_data = array(
							'order_id' => $this->db->escape_str(trim($order_id)),
							'user_id' => $this->db->escape_str(trim($user_id)),
							'product_id' => $this->db->escape_str(trim('24')),
							'price' => $this->db->escape_str(trim(0.00)),
							'product_type' => $this->db->escape_str('PGD'),
							'is_package' => $this->db->escape_str(trim(0)),
							'expiry_date' => $this->db->escape_str(trim('0000-00-00'))
					);
					
					$this->db->dbprefix('user_order_details');
					$this->db->insert('user_order_details', $ins_data);
	
					//Inserting copy of the product purchased in the Order History for references.
					$ins_data = array(
							'order_id' => $this->db->escape_str(trim($order_id)),
							'user_id' => $this->db->escape_str(trim($user_id)),
							'product_id' => $this->db->escape_str(trim(24)),
							'price' => $this->db->escape_str(trim(0.00)),
							'product_type' => $this->db->escape_str('PGD'),
							'is_package' => $this->db->escape_str(trim(0)),
							'expiry_date' => $this->db->escape_str(trim('0000-00-00')),
							'purchase_date' => $this->db->escape_str(trim($purchase_date)),
							'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
							
					);
					$this->db->dbprefix('user_order_history');
					$this->db->insert('user_order_history', $ins_data);
					
				}//end if(!$$is_anaphylaxis_expired)
				*/
			}//end if($is_seasonal)
			
		}//end if($is_travel)
			
		return true;

	}//end add_pgd_to_order
	
	//Function delete_purchased_pgd(): Will delete the currently purchased PGD for the user.
	public function delete_purchased_pgd($pgd_id,$user_id){
		
		$get_recently_active_pgd = $this->is_product_expired($pgd_id, 'PGD', $user_id);
		
		$order_detail_id = $get_recently_active_pgd['id'];
		$order_id = $get_recently_active_pgd['order_id'];
		
		//Delete Record from Quiz Results 
		$this->db->dbprefix('pgd_quiz_results');
		$this->db->where('user_id',$user_id);
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('order_id',$order_detail_id);
		$delete_data = $this->db->delete('pgd_quiz_results');
		
		//Delete Record from Quiz Session
		$this->db->dbprefix('pgd_quiz_session');
		$this->db->where('user_id',$user_id);
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('order_id',$order_detail_id);
		$delete_data = $this->db->delete('pgd_quiz_session');

		//Delete Record from Order History Detail page
		$this->db->dbprefix('user_order_history');
		$this->db->where('order_id',$order_id);
		$delete_data = $this->db->delete('user_order_history');

		//Delete Record from Order Detail page
		$this->db->dbprefix('user_order_details');
		$this->db->where('id',$order_detail_id);
		$delete_data = $this->db->delete('user_order_details');

		//echo $this->db->last_query(); exit;

		return true;

	}//end delete_purchased_pgd($pgd_id,$user_id)

	//Function delete_purchased_training(): Will delete the currently purchased PGD for the user.
	public function delete_purchased_training($training_id,$user_id){
		
		$get_recently_active_training = $this->is_product_expired($training_id, 'TRAINING', $user_id);
		$order_detail_id = $get_recently_active_training['id'];
		$order_id = $get_recently_active_training['order_id'];
		
		//Delete Record from Quiz Results 
		$this->db->dbprefix('training_quiz_results');
		$this->db->where('user_id',$user_id);
		$this->db->where('training_id',$training_id);
		$this->db->where('order_id',$order_detail_id);
		$delete_data = $this->db->delete('training_quiz_results');
		
		//Delete Record from Quiz Session
		$this->db->dbprefix('training_quiz_session');
		$this->db->where('user_id',$user_id);
		$this->db->where('training_id',$training_id);
		$this->db->where('order_id',$order_detail_id);
		$delete_data = $this->db->delete('training_quiz_session');

		//Delete Record from Order History Detail page
		$this->db->dbprefix('user_order_history');
		$this->db->where('order_id',$order_id);
		$delete_data = $this->db->delete('user_order_history');

		//Delete Record from Order Detail page
		$this->db->dbprefix('user_order_details');
		$this->db->where('order_id',$order_id);
		$delete_data = $this->db->delete('user_order_details');
		
		return true;

	}//end delete_purchased_training($training_id,$user_id)

	//Function remove_pgd_from_order(): Remove Purchased PGD into the database for Avacinna
	public function remove_pgd_from_order($pgd_id,$user_id,$pgd_type){
		
		$purchased_list = $this->purchase->get_purchased_items_split_by_user($user_id);
		/*		
		// Check for aT : ID = 11
		$aT = 0; $pT = 0; $F15 = 0; $F16 = 0;
		
		$index_key = array_search(10, array_column($purchased_list['pgds']['pgd_list'], 'product_id'));
		if(strlen($index_key) > 0)
			$pT = 1;
		// if(strlen($index_key) > 0)
		
		$index_key = array_search(11, array_column($purchased_list['pgds']['pgd_list'], 'product_id'));
		if(strlen($index_key) > 0)
			$aT = 1;
		// if(strlen($index_key) > 0)

		// Check for F15 : ID = 16
		$index_key = array_search(16, array_column($purchased_list['pgds']['pgd_list'], 'product_id'));
		if(strlen($index_key) > 0)
			$F15 = 1;
		// if(strlen($index_key) > 0)

		// Check for F16 : ID = 15
		$index_key = array_search(15, array_column($purchased_list['pgds']['pgd_list'], 'product_id'));
		if(strlen($index_key) > 0)
			$F16 = 1;
		// if(strlen($index_key) > 0)
		*/
		if($pgd_type == 'PGD'){
			
			$delete_child_pgd = 1;
			
			if($pgd_id == 10 && $aT)
				$delete_child_pgd = 0;
			
			if($pgd_id == 11 && $pT)
				$delete_child_pgd = 0;

			if(!$aT && !$pT)
				$parent_delete_child_pgd = 1;

			$get_pgd_details = $this->pgd->get_pgd_details(trim($pgd_id));

			if($get_pgd_details['seasonal_travel']){
				
				if($get_pgd_details['seasonal_travel'] == 'T' && $delete_child_pgd){
					
					if(!$purchased_list['pgds']['package_purchased']){
						
						//Delete Malaria Record
						$malaria_pgd_id = 21;
						$delete_pgd = $this->delete_purchased_pgd($malaria_pgd_id,$user_id);
						
					}//end if($purchased_list['pgds']['package_purchased'] == 0)
					
					//Delete Yellow Fever Record
					$yellowfever_pgd_id = 22;
					$delete_pgd = $this->delete_purchased_pgd($yellowfever_pgd_id,$user_id);
					
				}//end if($get_pgd_details['seasonal_travel'] == 'T')
				
				if($delete_child_pgd || $parent_delete_child_pgd){
				
					$user_purchased_items = $this->purchase->get_purchased_items_split_by_user($user_id);
					$user_purchased_items = $user_purchased_items['pgds']['pgd_list'];
					
					$delete_anaphalexes = 1;
					$anaplyx_pgd_id_arr = array(10,11,15,16);
					
					for($i=0;$i<count($anaplyx_pgd_id_arr);$i++){
	
						if($anaplyx_pgd_id_arr[$i] != $pgd_id){
							
							$index_key = array_search($anaplyx_pgd_id_arr[$i], array_column($user_purchased_items, 'product_id'));
							
							if(strlen($index_key) > 0){
								$delete_anaphalexes = 0; break; 
							}
						}//end if($anaplyx_pgd_id_arr[$i] != $pgd_id)
						
					}//end for($i=0;$i<count($anaplyx_pgd_id_arr);$i++)
					
					if($delete_anaphalexes){
						
						//echo "Anayplysexes deleted"; 
						//Delete Anaplyxis Record
						$anaphylaxis_pgd_id = 24;
						$delete_pgd = $this->delete_purchased_pgd($anaphylaxis_pgd_id,$user_id);
						
					}//end if($delete_anaphalexes)
					
				}//end if($delete_child_pgd)

			}//end if($get_pgd_details['seasonal_travel'])
			
			$delete_parent_pgd = $this->delete_purchased_pgd($pgd_id,$user_id);
			
		}elseif($pgd_type == 'ORAL'){
			
			//Get list of All ORAL PGD and mark them delete

			$get_oral_pgds_list = $this->pgd->get_pgd_list('O');
			
			for($j=0;$j<count($get_oral_pgds_list);$j++){
				
				$oral_pgd_id = $get_oral_pgds_list[$j]['id'];
				$delete_pgd = $this->delete_purchased_pgd($oral_pgd_id,$user_id);
				
			}//end for($j=0;$j<count($get_oral_pgds_list);$j++)

			//Before deleting check if Travel already exist.
			/*
			if($pT || $aT){
				//Do Nothing
			}else{
				$malaria_pgd_id = 21;
				$delete_pgd = $this->delete_purchased_pgd($malaria_pgd_id,$user_id);
				
			}//end if(!$pT || !$aT)
			*/
			
		}elseif($pgd_type == 'P_ORAL'){
			
			
			//Get list of All ORAL PGD and mark them delete
			$get_premium_oral_pgds_list = $this->pgd->get_pgd_list('OP');
			
			for($j=0;$j<count($get_premium_oral_pgds_list);$j++){
				
				$oral_pgd_id = $get_premium_oral_pgds_list[$j]['id'];
				$delete_pgd = $this->delete_purchased_pgd($oral_pgd_id,$user_id);
				
			}//end for($j=0;$j<count($get_oral_pgds_list);$j++)
			
		}//end if($pgd_type == 'PGD')
		
		return true;
			
	}//end remove_pgd_from_order($pgd_id,$user_id,$pgd_type)

	//Function remove_pgd_from_order(): Remove Purchased PGD into the database for Avacinna
	public function remove_trainings_from_order($training_arr,$user_id){
		
		for($i=0;$i<count($training_arr);$i++){
			
			$delete_training = $this->delete_purchased_training($training_arr[$i],$user_id);	
			
		}//end for($i=0;$i<count($training_arr);$i++)
		return true;
		
	}//end remove_trainings_from_order($training_id,$user_id)
	
	//Function add_trainings_to_order(): Store the Training into the database for Avacinna
	public function add_trainings_to_order($training_arr,$user_id){
		
		$purchase_date = date('Y-m-d');
		$created_by_ip = $this->input->ip_address();
		
		//Generate unique Order Number
		$order_no = $this->purchase->generate_order_number();
		
		$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
		$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
		$subtotal = 0;

		for($i=0;$i<count($training_arr);$i++){
			
			$get_training_data = $this->training->get_training_details($training_arr[$i]);
			$subtotal += ($get_training_data['discount_price'] != 0.00) ? $get_training_data['discount_price'] : $get_training_data['price'];
			
		}//end for($i=0;$i<count($trainings);$i++)
		
		$vat_amount = (trim($vat_percentage['setting_value']) / 100) * $subtotal;
		$vat_tax = filter_price($vat_amount);
		$grand_total = $subtotal+$vat_tax;
		
		//Record insert into database
		$ins_data = array(
		
			'order_no' => $this->db->escape_str(trim($order_no)),
			'user_id' => $this->db->escape_str(trim($user_id)),
			'subtotal' => $this->db->escape_str(trim($subtotal)),
			'vat_tax' => $this->db->escape_str(trim($vat_tax)),
			'grand_total' => $this->db->escape_str(trim($grand_total)),
			'purchase_date' => $this->db->escape_str(trim($purchase_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		
		//Inserting User data into the database. 
		$this->db->dbprefix('user_orders');
		$ins_into_db = $this->db->insert('user_orders', $ins_data);
		$order_id = $this->db->insert_id();

		for($j=0;$j<count($training_arr);$j++){
			
			$product_id = $training_arr[$j];
			$purchase_date = date('Y-m-d');
			
			$get_training_course_details = $this->training->get_training_details($training_arr[$j]);
			
			$training_expiry_duration = filter_string($get_training_course_details['training_expiry_months']);
			$expiry_date = date('Y-m-d', strtotime("+$training_expiry_duration month", strtotime($purchase_date)));
			
			$training_price = ($get_training_course_details['discount_price'] != 0.00) ? $get_training_course_details['discount_price'] : $get_training_course_details['price'];

			//This section is for Rest of the PGD's other than ORAL Packages!
			
			$is_package = 0;
			
			$ins_data = array(
					'order_id' => $this->db->escape_str(trim($order_id)),
					'user_id' => $this->db->escape_str(trim($user_id)),
					'product_id' => $this->db->escape_str(trim($product_id)),
					'price' => $this->db->escape_str(trim($training_price)),
					'product_type' => $this->db->escape_str(trim('TRAINING')),
					'is_package' => $this->db->escape_str(trim($is_package)),
					'expiry_date' => $this->db->escape_str(trim($expiry_date))
			);
			$this->db->dbprefix('user_order_details');
			$this->db->insert('user_order_details', $ins_data);

			//Inserting copy of the product purchased in the Order History for references.
			$ins_data = array(
					'order_id' => $this->db->escape_str(trim($order_id)),
					'user_id' => $this->db->escape_str(trim($user_id)),
					'product_id' => $this->db->escape_str(trim($product_id)),
					'price' => $this->db->escape_str(trim($training_price)),
					'product_type' => $this->db->escape_str(trim('TRAINING')),
					'is_package' => $this->db->escape_str(trim($is_package)),
					'expiry_date' => $this->db->escape_str(trim($expiry_date)),
					'purchase_date' => $this->db->escape_str(trim($purchase_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					
			);
			
			$this->db->dbprefix('user_order_history');
			$this->db->insert('user_order_history', $ins_data);
			
		}//end for($i=0;$i<$training_arr;$i++)

		return true;

	}//end add_trainings_to_order

	//Function unassign_governance(): Will delete the currently Governance for the pharmacy
	public function unassign_governance($pharmacy_id,$order_id){
		
		//Delete Record from Quiz Results 
		$this->db->dbprefix('user_order_details');
		$this->db->where('pharmacy_surgery_id',$pharmacy_id);
		$this->db->where('order_id',$order_id);
		$this->db->where('product_type','GOVERNANCE');
		$delete_data = $this->db->delete('user_order_details');
		

		//Delete Record from Order History Detail page
		$this->db->dbprefix('user_order_history');
		$this->db->where('pharmacy_surgery_id',$pharmacy_id);
		$this->db->where('order_id',$order_id);
		$this->db->where('product_type','GOVERNANCE');
		$this->db->where('order_id',$order_id);
		$delete_data = $this->db->delete('user_order_history');

		//Delete Record from Order History Detail page
		$this->db->dbprefix('user_orders');
		$this->db->where('id',$order_id);
		$delete_data = $this->db->delete('user_orders');

		return true;

	}//end unassign_governance($pharmacy_id,$order_id)
	
	public function assign_governance($pharmacy_id, $org_owner_id, $order_id){

		$purchase_date = date('Y-m-d');
		$created_by_ip = $this->input->ip_address();

		$governance_package_list = $this->governance->get_governance_package(1);
		$subtotal = filter_price($governance_package_list['price']);

		$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
		$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
		$vat_amount = (trim($vat_percentage['setting_value']) / 100) * $subtotal;
		
		$vat_tax = $vat_amount;	
		$grand_total = $vat_tax + $subtotal;
		
		$order_no = $this->purchase->generate_order_number();
		
		$expiry_date = date('Y-m-d', strtotime("+12 month", strtotime($purchase_date)));

		//Record insert into database
		$ins_data = array(
		
			'order_no' => $this->db->escape_str(trim($order_no)),
			'user_id' => $this->db->escape_str(trim($org_owner_id)),
			'subtotal' => $this->db->escape_str(trim($subtotal)),
			'vat_tax' => $this->db->escape_str(trim($vat_tax)),
			'grand_total' => $this->db->escape_str(trim($grand_total)),
			'purchase_date' => $this->db->escape_str(trim($purchase_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		);
		
		//Inserting User data into the database. 
		$this->db->dbprefix('user_orders');
		$ins_into_db = $this->db->insert('user_orders', $ins_data);
		$order_id = $this->db->insert_id();

		//$expiry_date = 

		$ins_data = array(
				'order_id' => $this->db->escape_str(trim($order_id)),
				'user_id' => $this->db->escape_str(trim($org_owner_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_id)),
				'product_id' => $this->db->escape_str(trim('1')),
				'price' => $this->db->escape_str(trim($subtotal)),
				'product_type' => $this->db->escape_str(trim('GOVERNANCE')),
				'expiry_date' => $this->db->escape_str(trim($expiry_date))
		);
		$this->db->dbprefix('user_order_details');
		$this->db->insert('user_order_details', $ins_data);

		//Inserting copy of the product purchased in the Order History for references.
		$ins_data = array(
				'order_id' => $this->db->escape_str(trim($order_id)),
				'user_id' => $this->db->escape_str(trim($org_owner_id)),
				'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_id)),
				'product_id' => $this->db->escape_str(trim('1')),
				'price' => $this->db->escape_str(trim($subtotal)),
				'product_type' => $this->db->escape_str(trim('GOVERNANCE')),
				'expiry_date' => $this->db->escape_str(trim($expiry_date))
		);
			
		$this->db->dbprefix('user_order_history');
		$this->db->insert('user_order_history', $ins_data);
		
		return true;
		
	}//end assign_governance($pharmacy_id, $org_owner_id, $order_id)

}//end file
?>