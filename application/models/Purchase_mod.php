<?php
class Purchase_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	//Function get_purchased_items(): This will return array of products being purchased by the user.
	public function get_order_item_details($order_item_id = '', $product_id = '', $product_type = '', $user_id = ''){
		
		$this->db->dbprefix('user_order_details');
		
		if($user_id != '')
			$this->db->where('user_id',$user_id);
		
		if($order_item_id != '')
			$this->db->where('id',$order_item_id);

		if($product_id != '')
			$this->db->where('product_id',$product_id);

		if($product_type != '')
			$this->db->where('product_type',$product_type);
			
		$get = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		
		if($order_item_id != '')
			$row_arr = $get->row_array();
		else
			$row_arr = $get->result_array();
		
		return $row_arr;

	}//end get_purchased_items($user_id)

	//Function get_purchased_items_by_type(): This will return array list of products of a provided Product type and ID.
	public function get_product_reviews($product_type,$product_id, $offset=''){
		
		$this->db->dbprefix('user_order_details');
		$this->db->select('user_order_details.reviews, user_order_details.star_rating,user_orders.purchase_date, CONCAT(first_name," ",last_name) AS review_by_name,user_order_details.review_date');
		$this->db->join('users', 'user_order_details.user_id = users.id', 'LEFT'); 
		$this->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'LEFT'); 
		$this->db->where('user_order_details.reviews <> "" ');
		$this->db->where('user_order_details.product_id',$product_id);
		$this->db->where('user_order_details.product_type',$product_type);
		$this->db->order_by('user_order_details.review_date','DESC');
		
		if($offset != '')
			$this->db->limit(10, $offset);
		
		$get = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		$row_arr = $get->result_array();
		
		return $row_arr;

	}//end get_purchased_items_by_details($user_id)

	//Function get_purchased_items(): This will return array of products being purchased by the user.
	public function get_purchased_items_by_user($user_id, $product_type = '', $sort_by_order = 'ASC'){
		
		$this->db->dbprefix('user_order_details');
		$this->db->where('user_id',$user_id);
		if(trim($product_type) != '') $this->db->where('product_type',$product_type);
		$this->db->order_by('id',$sort_by_order);
		
		$get = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		$row_arr = $get->result_array();
		
		return $row_arr;

	}//end get_purchased_items($user_id)

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
					
					$get_pgd_dtails = $this->pgds->get_pgd_details($row['product_id']);
					
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
					
					$row['pgd_type'] = $get_pgd_dtails['pgd_type'];
					
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
	
	//Function get_recent_product_purchased(): Will return tthe array of most recently the product which was purchased.
	public function get_recent_product_purchased($product_id, $product_type, $user_id = ''){

		$this->db->dbprefix('user_order_details');
		if(trim($user_id) != '')  $this->db->where('user_id',$user_id);
		
		$this->db->where('product_type',$product_type);
		$this->db->where('product_id',$product_id);
		$get = $this->db->get('user_order_details');
		
		return $get->row_array();
		
	}//end get_recent_product_purchased($product_id, $product_type, $user_id = '')

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
		
		return $get->row_array();
		
	}//end is_product_expired($product_id, $product_type, $user_id = '', $pharmacy_surgery_id = '', $organziation_id = '')

	//Function add_products_to_order(): Store the purchased products from Paypal into the order and order_deatil tables, $data will have two arrays coming from API, get_ec_return and get_ec_return
	public function add_products_to_order($data){
		
		extract($data);
		
		$purchase_date = date('Y-m-d');
		$created_by_ip = $this->input->ip_address();
		
		//Generate unique Order Number
		$order_no = $this->purchase->generate_order_number();
		$org_ins_arr = array();
		
		if($organization_id && $organization_id!='')
			$org_ins_arr['organization_id'] = $organization_id;
		 
		$subtotal = $get_ec_return['ITEMAMT'];
		$vat_tax = $get_ec_return['TAXAMT'];
		$grand_total = $get_ec_return['AMT'];
		$paypal_transaction_id = $do_ec_return['PAYMENTINFO_0_TRANSACTIONID'];
		
		//Record insert into database
		$ins_data = array(
		
			'order_no' => $this->db->escape_str(trim($order_no)),
			'paypal_transaction_id' => $this->db->escape_str(trim($paypal_transaction_id)),
			'user_id' => $this->db->escape_str(trim($user_id)),
			'purchased_by_id' => $this->db->escape_str(trim($purchased_by_id)),
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
		
		$purchased_item_str .= '<table cellpadding="2" cellspacing="2" width="100%" style="font-family:arial,helvetica,sans-serif; font-size:12px;">
					<tr align="left">
                	<th>Sr#</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>Expiry Date</th>
                    <th>Price</th>
                </tr>';
		
		for($i=0;$i<$num_of_products;$i++){
			
			$ins_data_g = array();
			
			$trim_prefix_id = array('P_','T_','G_','S_');
			$product_actual_id = trim($get_ec_return['L_NUMBER'.$i]);
			$product_id = str_replace($trim_prefix_id,'',$product_actual_id); //Governance and Surveys as purchased against the pharmacies so we will get the Pharamcy ID's appended with S_ or G_
			
			//If Product type is TRAINING, get expiry data from the training table, evaluate the expiry date and store into the purchased item
			if(($get_ec_return['L_DESC'.$i] == 'TRAINING')){
				
				$get_training_course_details = $this->training->get_training_course_details($product_id);
				$training_expiry_duration = filter_string($get_training_course_details['training_expiry_months']);
				$expiry_date = date('Y-m-d', strtotime("+$training_expiry_duration month", strtotime($purchase_date)));

				$product_name = filter_string($get_training_course_details['course_name']);
				$product_expiry = 'N/A';
				
			}elseif(trim($get_ec_return['L_DESC'.$i]) == 'PGD'){
				//If PGD do not add expiry date into the DB as expiry date will be active once the doc and pharmacist approve the PGD.
				$expiry_date = '0000-00-00';
				
				$get_pgd_details = $this->pgds->get_pgd_details(trim($product_id));
				$product_name = filter_string($get_pgd_details['pgd_name']);
				$product_expiry = $expiry_date;
				
				$is_travel = (filter_string($get_pgd_details['seasonal_travel']) == 'T') ? 1 : 0;
				$is_seasonal = (filter_string($get_pgd_details['seasonal_travel']) == 'S') ? 1 : 0;
				

			}elseif(trim($get_ec_return['L_DESC'.$i]) == 'GOVERNANCE'){
				
				$ins_data_g['pharmacy_surgery_id'] = $product_id; //For Governance it will hold the Pharmacy ID
				$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($product_id);

				$product_name = 'Governance Purchased for '.filter_string($get_pharmacy_details['pharmacy_surgery_name']);
				$product_id = 1; //For Governance we will always have 1 product so we will make it static.

				$get_governance_details = $this->governance->get_governance_package(1);
				$governance_expiry_duration = filter_string($get_governance_details['governance_expiry_months']);
				$expiry_date = date('Y-m-d', strtotime("+$governance_expiry_duration month", strtotime($purchase_date)));
				$product_expiry = $expiry_date;
				
			}elseif(trim($get_ec_return['L_DESC'.$i]) == 'SURVEY'){

				$ins_data_g['pharmacy_surgery_id'] = $product_id; //For Governance it will hold the Pharmacy ID
				
				$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($product_id);
				
				$product_name = 'Survey Purchased for '.filter_string($get_pharmacy_details['pharmacy_surgery_name']);
				$product_id = 1; //For Governance we will always have 1 product so we will make it static.

				$get_survey_details = $this->survey->get_survey_package(1);
				$expiry_date = '0000-00-00'; //Expiry will be updated once the survey is being initiated
				$product_expiry = 'N/A';
				
			}//end if(($get_ec_return['L_DESC'.$i] == 'TRAINING'))

			if($product_actual_id == 'P_0'){
				
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

				//Preparing Product List for email/ invoice
				$purchased_item_str .= "
				<tr>
                	<td>".($i+1)."</td>
                    <td>Oral PGD Package</td>
                    <td>PGD</td>
                    <td>N/A</td>
                    <td>&pound;".$package_price."</td>
                </tr>";
				
				
				//Get All List of Oral Packages
				$get_oral_pgds_list = $this->pgds->get_pgds_list('O');
				$split_price = (float) $package_price / count($get_oral_pgds_list);
				
				for($j=0;$j<count($get_oral_pgds_list);$j++){

					$ins_data = array(
							'order_id' => $this->db->escape_str(trim($order_id)),
							'user_id' => $this->db->escape_str(trim($user_id)),
							'purchased_by_id' => $this->db->escape_str(trim($purchased_by_id)),
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
							'purchased_by_id' => $this->db->escape_str(trim($purchased_by_id)),
							'product_id' => $this->db->escape_str(trim($get_oral_pgds_list[$j]['id'])),
							'paypal_transaction_id' => $this->db->escape_str(trim($paypal_transaction_id)),
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

			}elseif($product_actual_id == 'P_1'){

				//Means the PREMIUM ORAL Package is part of the shopping cart, now add all PREMIUM Oral Packages into the database.
				
				$is_package = 1;
				
				$ORAL_PGD_PACKAGE_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_PRICE';
				$global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);
				
				$ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE';
				$global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);						
				
				if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00){
					$package_price = filter_price($global_oral_packages_discount_price['setting_value']);
					
				}else{
					$package_price = filter_price($global_oral_package_price['setting_value']);
					
				}//end if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00)

				//Preparing Product List for email/ invoice
				$purchased_item_str .= "
				<tr>
                	<td>".($i+1)."</td>
                    <td>Premium Oral PGD Package</td>
                    <td>PGD</td>
                    <td>N/A</td>
                    <td>&pound;".$package_price."</td>
                </tr>";
				
				
				//Get All List of Oral Packages
				$get_premium_oral_pgds_list = $this->pgds->get_pgds_list('OP');
				$split_price = (float) $package_price / count($get_premium_oral_pgds_list);
				
				for($j=0;$j<count($get_premium_oral_pgds_list);$j++){

					$ins_data = array(
							'order_id' => $this->db->escape_str(trim($order_id)),
							'user_id' => $this->db->escape_str(trim($user_id)),
							'purchased_by_id' => $this->db->escape_str(trim($purchased_by_id)),
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
							'purchased_by_id' => $this->db->escape_str(trim($purchased_by_id)),
							'product_id' => $this->db->escape_str(trim($get_premium_oral_pgds_list[$j]['id'])),
							'paypal_transaction_id' => $this->db->escape_str(trim($paypal_transaction_id)),
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

			}else{
				
				//This section is for Rest of the PGD's other than ORAL and Premium Packages!
				
				$is_package = 0;
				
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'purchased_by_id' => $this->db->escape_str(trim($purchased_by_id)),
						'product_id' => $this->db->escape_str(trim($product_id)),
						'price' => $this->db->escape_str(trim($get_ec_return['L_AMT'.$i])),
						'product_type' => $this->db->escape_str(trim($get_ec_return['L_DESC'.$i])),
						'is_package' => $this->db->escape_str(trim($is_package)),
						'expiry_date' => $this->db->escape_str(trim($expiry_date))
				);
				
				$ins_data = array_merge($ins_data,$ins_data_g,$org_ins_arr);
				$this->db->dbprefix('user_order_details');
				$this->db->insert('user_order_details', $ins_data);

				//Inserting copy of the product purchased in the Order History for references.
				$ins_data = array(
						'order_id' => $this->db->escape_str(trim($order_id)),
						'user_id' => $this->db->escape_str(trim($user_id)),
						'purchased_by_id' => $this->db->escape_str(trim($purchased_by_id)),
						'product_id' => $this->db->escape_str(trim($product_id)),
						'paypal_transaction_id' => $this->db->escape_str(trim($paypal_transaction_id)),
						'price' => $this->db->escape_str(trim($get_ec_return['L_AMT'.$i])),
						'product_type' => $this->db->escape_str(trim($get_ec_return['L_DESC'.$i])),
						'is_package' => $this->db->escape_str(trim($is_package)),
						'expiry_date' => $this->db->escape_str(trim($expiry_date)),
						'purchase_date' => $this->db->escape_str(trim($purchase_date)),
						'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
						
				);
				
				$ins_data = array_merge($ins_data,$ins_data_g,$org_ins_arr);
				$this->db->dbprefix('user_order_history');
				$this->db->insert('user_order_history', $ins_data);
				
				$purchased_item_str .= "
				<tr>
                	<td>".($i+1)."</td>
                    <td>".$product_name."</td>
                    <td>".trim($get_ec_return['L_DESC'.$i])."</td>
                    <td>".$product_expiry."</td>
                    <td>&pound;".trim($get_ec_return['L_AMT'.$i])."</td>
                </tr>";
				
			}//end if($product_actual_id == 'P_0')
			
		}//end for($i=0;$i<$num_of_products;$i++)
		
			$purchased_item_str .= "<tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><strong>Subtotal: </strong></td>
                    <td>&pound; ".trim($subtotal)."</td>
                </tr>";

			$purchased_item_str .= "<tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><strong>VAT (&pound;): </strong></td>
                    <td>&pound; ".trim($vat_tax)."</td>
                </tr>";

			$purchased_item_str .= "<tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><strong>Grand Total: </strong></td>
                    <td>&pound; ".trim($grand_total)."</td>
                </tr>";

			$purchased_item_str .= "</table>";
			
		// EMAIL SENDING CODE - START
		
		$search_arr = array('[FIRST_LAST_NAME]','[ORDER_ID]','[PAYPAL_TRANSACTION_ID]','[ORDER_DATE]','[PURCHASED_PRODUCTS]','[SITE_LOGO]','[SITE_URL]');
		$replace_arr = array($this->session->full_name,trim($order_no),trim($paypal_transaction_id),kod_date_format(trim($purchase_date)),$purchased_item_str,SITE_LOGO,SURL); 
		
		$this->load->model('email_mod','email_template');
		
		$email_body_arr = $this->email_template->get_email_template(4);
		$email_subject = $email_body_arr['email_subject'];
		
		$email_body = $email_body_arr['email_body'];
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
		
		$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
		$noreply_email = get_global_settings($NOREPLY_EMAIL);
		
		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
		$email_address = $this->session->email_address;
		
		$from = filter_string($noreply_email['setting_value']);
		$from_name = filter_string($email_from_txt['setting_value']);
		$to = trim($email_address);
		$subject = filter_string($email_subject);
		$email_body = filter_string($email_body);
					
		// Call from Helper send_email function
		$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body, $attachments);
		
		if($ins_into_db)
			return true;
		else
			return false;
		
	}//end add_products_to_order
	
	//Function add_free_survey_to_order(): This function add the Surveys as FREE into the order table if Free Survey is turned On!
	public function add_free_survey_to_order($organization_id, $pharmacy_id, $user_id){
		
		$purchase_date = date('Y-m-d');
		$created_by_ip = $this->input->ip_address();
		
		//Generate unique Order Number
		$order_no = $this->purchase->generate_order_number();
		$org_ins_arr = array();
		
		if($organization_id && $organization_id!='')
			$org_ins_arr['organization_id'] = $organization_id;
		 
		$subtotal = 0.00;
		$vat_tax = 0.00;
		$grand_total = 0.00;
		$paypal_transaction_id = '';
		
		//Record insert into database
		$ins_data = array(
		
			'order_no' => $this->db->escape_str(trim($order_no)),
			'paypal_transaction_id' => $this->db->escape_str(trim($paypal_transaction_id)),
			'user_id' => $this->db->escape_str(trim($user_id)),
			'purchased_by_id' => $this->db->escape_str(trim($user_id)),
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
		
		$ins_data_g = array();
		
		$product_id = $pharmacy_id; //For Governance we will always have 1 product so we will make it static.
		$ins_data_g['pharmacy_surgery_id'] = $product_id; //For Governance it will hold the Pharmacy ID
		
		$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($product_id);
		
		$get_survey_details = $this->survey->get_survey_package(1);
		$expiry_date = '0000-00-00'; //Expiry will be updated once the survey is being initiated
		$product_expiry = 'N/A';
		
		//This section is for Rest of the PGD's other than ORAL Packages!
		
		$is_package = 0;
		
		$ins_data = array(
				'order_id' => $this->db->escape_str(trim($order_id)),
				'user_id' => $this->db->escape_str(trim($user_id)),
				'purchased_by_id' => $this->db->escape_str(trim($user_id)),
				'product_id' => $this->db->escape_str(trim($product_id)),
				'price' => $this->db->escape_str(trim($subtotal)),
				'product_type' => $this->db->escape_str(trim('SURVEY')),
				'is_package' => $this->db->escape_str(trim($is_package)),
				'expiry_date' => $this->db->escape_str(trim($expiry_date))
		);

		$ins_data = array_merge($ins_data,$ins_data_g,$org_ins_arr);
		$this->db->dbprefix('user_order_details');
		$this->db->insert('user_order_details', $ins_data);

		//Inserting copy of the product purchased in the Order History for references.
		$ins_data = array(
				'order_id' => $this->db->escape_str(trim($order_id)),
				'user_id' => $this->db->escape_str(trim($user_id)),
				'purchased_by_id' => $this->db->escape_str(trim($user_id)),
				'product_id' => $this->db->escape_str(trim($product_id)),
				'paypal_transaction_id' => $this->db->escape_str(trim($paypal_transaction_id)),
				'price' => $this->db->escape_str(trim($subtotal)),
				'product_type' => $this->db->escape_str(trim('SURVEY')),
				'is_package' => $this->db->escape_str(trim($is_package)),
				'expiry_date' => $this->db->escape_str(trim($expiry_date)),
				'purchase_date' => $this->db->escape_str(trim($purchase_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				
		);
		
		$ins_data = array_merge($ins_data,$ins_data_g,$org_ins_arr);
		$this->db->dbprefix('user_order_history');
		$this->db->insert('user_order_history', $ins_data);
		
		return true;
	
	}//end add_free_survey_to_order
	
	//Function add_pgd_to_order_manually(): Add PGD to order manually without any payment system 
	public function add_pgd_to_order_manually($user_id,$product_id, $pgd_type){
		
		$purchase_date = date('Y-m-d');
		$created_by_ip = $this->input->ip_address();
		
		//Generate unique Order Number
		$order_no = $this->purchase->generate_order_number();
		
		$subtotal = 0;
		$grand_total = 0;
		
		if($pgd_type == 'OP'){
			
			$is_package = '1';
			
			$ORAL_PGD_PACKAGE_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_PRICE';
			$global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);
			
			$ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE';
			$global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);						
			
			if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00){
				$package_price = filter_price($global_oral_packages_discount_price['setting_value']);
				
			}else{
				$package_price = filter_price($global_oral_package_price['setting_value']);
				
			}//end if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00)

			$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
			$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
			$vat_amount = (trim($vat_percentage['setting_value']) / 100) * $package_price;
			
			$get_premium_oral_pgds_list = $this->pgds->get_pgds_list('OP');
			
			$vat_tax = filter_price($vat_amount) / count($get_premium_oral_pgds_list);

			$subtotal = (float) $package_price / count($get_premium_oral_pgds_list);
			
			$grand_total = $subtotal + $vat_tax;
			
			$pgd_price = $subtotal;

		}else if($pgd_type == 'O'){
			
			$is_package = '1';

			$ORAL_PGD_PACKAGE_PRICE = 'ORAL_PGD_PACKAGE_PRICE';
			$global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);
			
			
			$ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
			$global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);						
			
			if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00){
				$package_price = filter_price($global_oral_packages_discount_price['setting_value']);
				
			}else{
				$package_price = filter_price($global_oral_package_price['setting_value']);
				
			}//end if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00)
			
			$get_oral_pgds_list = $this->pgds->get_pgds_list('O');
			
			$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
			$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
			$vat_amount = (trim($vat_percentage['setting_value']) / 100) * $package_price;

			$vat_tax = filter_price($vat_amount) / count($get_oral_pgds_list);

			$subtotal = (float) $package_price / count($get_oral_pgds_list);
			
			$grand_total = $subtotal + $vat_tax;
			
			$pgd_price = $subtotal;
			
		}else if($pgd_type == 'PGD'){
			
			$is_package = '0';
			
			$get_pgd_data = $this->pgds->get_pgd_details($product_id);
			
			$subtotal += ($get_pgd_data['discount_price'] != 0.00) ? $get_pgd_data['discount_price'] : $get_pgd_data['price'];

			$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
			$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
			$vat_amount = (trim($vat_percentage['setting_value']) / 100) * $subtotal;
			
			$vat_tax = filter_price($vat_amount);

			$grand_total = $subtotal+$vat_tax;
			
			$pgd_price = ($get_pgd_data['discount_price'] != 0.00) ? $get_pgd_data['discount_price'] : $get_pgd_data['price'];

		}//end if($pgd_type == 'OP')

		//Record insert into database
		$ins_data = array(
		
			'order_no' => $this->db->escape_str(trim($order_no)),
			'user_id' => $this->db->escape_str(trim($user_id)),
			'subtotal' => $this->db->escape_str(trim($subtotal)),
			'vat_tax' => $this->db->escape_str(trim($vat_tax)),
			'grand_total' => $this->db->escape_str(trim($grand_total)),
			'purchase_date' => $this->db->escape_str(trim($purchase_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);
		
		
		//Inserting User data into the database. 
		$this->db->dbprefix('user_orders');
		$ins_into_db = $this->db->insert('user_orders', $ins_data);
		$order_id = $this->db->insert_id();
		
		$expiry_date = '0000-00-00';

		//This section is for Rest of the PGD's other than ORAL Packages!
		$ins_data = array(
			'order_id' => $this->db->escape_str(trim($order_id)),
			'user_id' => $this->db->escape_str(trim($user_id)),
			'product_id' => $this->db->escape_str(trim($product_id)),
			'price' => $this->db->escape_str(trim($pgd_price)),
			'product_type' => $this->db->escape_str(trim('PGD')),
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
			'product_type' => $this->db->escape_str(trim('PGD')),
			'is_package' => $this->db->escape_str(trim($is_package)),
			'expiry_date' => $this->db->escape_str(trim($expiry_date)),
			'purchase_date' => $this->db->escape_str(trim($purchase_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);
		
		$this->db->dbprefix('user_order_history');
		$this->db->insert('user_order_history', $ins_data);
	
		return true;
		
	}//end add_pgd_to_order_manually($user_id,$product_id, $is_package = '0')

	//Function add_training_to_order_manually(): Add training to order manually without any payment system 
	public function add_training_to_order_manually($user_id,$product_id){
		
		$purchase_date = date('Y-m-d');
		$created_by_ip = $this->input->ip_address();
		$is_package = 0;
		
		//Generate unique Order Number
		$order_no = $this->purchase->generate_order_number();
		
		$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
		$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
		$subtotal = 0;

		$get_training_data = $this->training->get_training_course_details($product_id);
		$subtotal += ($get_training_data['discount_price'] != 0.00) ? $get_training_data['discount_price'] : $get_training_data['price'];

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
		
		$training_expiry_duration = filter_string($get_training_data['training_expiry_months']);
		$expiry_date = date('Y-m-d', strtotime("+$training_expiry_duration month", strtotime($purchase_date)));
		
		$training_price = ($get_training_data['discount_price'] != 0.00) ? $get_training_data['discount_price'] : $get_training_data['price'];

		//This section is for Rest of the PGD's other than ORAL Packages!
		
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
		
		return true;
		
	}//end add_product_to_order_manually($user_id,$product_id,$product_type)

}//end file
?>