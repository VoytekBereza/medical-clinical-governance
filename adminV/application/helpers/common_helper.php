<?php
//Function print_this(&$array): Used for development purpose. Pritning Array or any Object with <pre>.
function print_this(&$arr){
	
	echo '<pre>';
	print_r($arr);
	
}//end print_this(&$array);

//Function filter_string():  will filter the string from unwanted characters while displaying it on teh screen.
function filter_string(&$string){
	
	$ci =& get_instance();
	$filter_txt = stripcslashes(trim($string));
	return $filter_txt;
	
}//end filter_string()

function filter_name($name){
	
	$filter_txt = ucfirst(stripcslashes(trim($name)));
	return $filter_txt;
	
}//end filter_name()

//Function filter_price():  Wil change the price formats as per the need.
function filter_price(&$price){
	
	$ci =& get_instance();
	$filter_price = number_format($price,2);
	return $filter_price;
	
}//end filter_price()

//Function get_pgd_navigation_list(): Get All list of Active/ InActive PGD's and Sub PGD's to show on the admin navigatgion
function get_pgd_navigation_list($status = ''){
	
	$ci =& get_instance();
	
	$ci->db->dbprefix('kod_package_pgds');
	$ci->db->select('kod_package_pgds.id AS pgd_id, kod_package_pgds.pgd_name, kod_pgd_subpgds.id AS subpgd_id, kod_pgd_subpgds.subpgd_name');

	if($status != '')
		$ci->db->where('package_pgds.status',$status);
		$ci->db->where('package_pgds.is_admin_deleted !=',1);
		
	
	$ci->db->join('kod_pgd_subpgds','kod_package_pgds.id = kod_pgd_subpgds.pgd_id','LEFT');
	$ci->db->order_by('pgd_id', 'DESC');
	$get_result = $ci->db->get('kod_package_pgds');
	
	$count_result = $get_result->num_rows();
	$result_arr = $get_result->result_array();
	//echo $ci->db->last_query(); exit;
	
	//echo $this->db->last_query(); 		exit;
	
	for($i=0;$i<$count_result;$i++){
		
		$pgd_nav_tree[$result_arr[$i]['pgd_name']]['pgd_id'] = $result_arr[$i]['pgd_id'];
		if($result_arr[$i]['subpgd_id'] != ''){
			
			$pgd_nav_tree[$result_arr[$i]['pgd_name']]['pgd_subpgd'][] = array('subpgd_id' => $result_arr[$i]['subpgd_id'],'subpgd_name' => $result_arr[$i]['subpgd_name']);
			
		}else{
			
			$pgd_nav_tree[$result_arr[$i]['pgd_name']]['pgd_subpgd'] = array();
			
		}//end if($result_arr[$i]['subpgd_id'] != '')

	}//end for($i=0;$i<$count_result;$i++)

	return $pgd_nav_tree;
	
}//end function get_pgd_navigation_list()

// Start - function kod_date_format($date='', $time=''): Function to return the formated (first parameter date and second is boolean true or false to get time)

if (!function_exists('kod_date_format')) {
	function kod_date_format($date = '', $time = ''){
		
		if(substr($date,0,4) != '0000'){
			
			if($date != ''){
				
				if($time == true)
					return date_format(date_create($date),"d/m/Y g:i a");
				elseif($time == false)
					return date_format(date_create($date),"d/m/Y");
					
			} else
				return $date;
				
		}else{
			return $date;
			
		}//end if(substr($date,0,4) != '0000')
		
	}//end kod_date_format($date='', $time='')

} // End - function kod_date_format($date='', $time='')


//Function filter_price():  Wil change the price formats as per the need.
function get_global_settings(&$setting_name){
	
	$ci =& get_instance();
	
	$ci->db->dbprefix('global_settings');
	$ci->db->where('setting_name',$setting_name);
	$get_result = $ci->db->get('global_settings');
	
	return $get_result->row_array();
	
}//end get_global_settings(&$setting_name)

 //  count_all_purchased PGDs 
function count_all_purchased_pgds($product_id=''){
	
	$ci =& get_instance();
	$ci->db->dbprefix('user_order_details');
	$ci->db->select('COUNT(product_id) as total');
	$ci->db->from('user_order_details');
	$ci->db->where('user_order_details.product_id ',$product_id);
	$ci->db->where('user_order_details.product_type ',"PGD");
	$ci->db->where("(user_order_details.expiry_date > '".date('Y-m-d')."' OR user_order_details.expiry_date = '0000-00-00')"); //Is not Expired
	
	$query = $ci->db->get();
	$row = $query->row_array();

	return $row['total'];
	
} // End - count_all_pgds_buying_group():

function count_all_avicenna_purchased_pgds($product_id=''){
	
	$ci =& get_instance();
	$ci->db->dbprefix('user_order_details');
	$ci->db->select('COUNT(product_id) as total');
	$ci->db->from('user_order_details');
	$ci->db->join('users', 'user_order_details.user_id = users.id','LEFT');
	$ci->db->where('user_order_details.product_id ',$product_id);
	$ci->db->where('users.buying_group_id ','1');
	$ci->db->where('user_order_details.product_type ',"PGD");
	$ci->db->where("(user_order_details.expiry_date > '".date('Y-m-d')."' OR user_order_details.expiry_date = '0000-00-00')"); //Is not Expired
	
	$query = $ci->db->get();
	$row = $query->row_array();

	return $row['total'];
	
} // End - count_all_pgds_buying_group():


function list_avicena_trainging($product_id=''){

	$ci =& get_instance();
	return $ci->avicenna->list_avicena_trainging($product_id);
	
}

//Function kod_send_email():  Send email.
function kod_send_email($from_email, $email_from_txt = '', $to_email_address,$email_subject, $email_body){
	
	$ci =& get_instance();
	// Username
	$SES_USERNAME = 'SES_USERNAME';
	$ses_username = get_global_settings($SES_USERNAME);
	$ses_username = trim($ses_username['setting_value']);

	// Password
	$SES_PASSWORD = 'SES_PASSWORD';
	$ses_password = get_global_settings($SES_PASSWORD);
	$ses_password = trim($ses_password['setting_value']);

	// Host
	$SES_HOST = 'SES_HOST';
	$ses_host = get_global_settings($SES_HOST);
	$ses_host = trim($ses_host['setting_value']);

	// Port
	$SES_PORT = 'SES_PORT';
	$ses_port = get_global_settings($SES_PORT);
	$ses_port = trim($ses_port['setting_value']);

	// Port
	$SES_SENDER = 'SES_SENDER';
	$ses_sender = get_global_settings($SES_SENDER);
	$ses_sender = trim($ses_sender['setting_value']);

	//////////////////////////////////////////////////////////////////////

	// Replace sender@example.com with your "From" address. 
	// This address must be verified with Amazon SES.
	$SENDER = $ses_sender; // $email; //'info@surveyfocus.co.uk';

	// Replace recipient@example.com with a "To" address. If your account 
	// is still in the sandbox, this address must be verified.
	$RECIPIENT = trim($to_email_address); //'twister787@gmail.com';
														  
	// Replace smtp_username with your Amazon SES SMTP user name.
	$USERNAME = $ses_username; // 'AKIAJJDSTFURI6LQWNPQ';

	// Replace smtp_password with your Amazon SES SMTP password.
	$PASSWORD = $ses_password; // 'As/vj5Eh8mLt7dYHnJWnK/6Fk5UwUGhD9qtA300O9rPL';

	// If you're using Amazon SES in a region other than US West (Oregon), 
	// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP  
	// endpoint in the appropriate region.
	
	$HOST = $ses_host; // 'email-smtp.eu-west-1.amazonaws.com'; 
	// $HOST = 'ses-smtp-user.20170116-163508';
	// ssl://email-smtp.us-east-1.amazonaws.com
	
	// The port you will connect to on the Amazon SES SMTP endpoint.
	$PORT = $ses_port; //'587';

	// Other message information                                               
	$SUBJECT = filter_string($email_subject); //'Amazon SES test (SMTP interface accessed using PHP)';
	$BODY = filter_string($email_body); //'This email was sent through the Amazon SES SMTP interface by using PHP.';

	////////////////////////////////////////
	////// CI SMTP Mail configuration //////

	$config = array(
		'protocol' => 'smtp',
		'smtp_host' => $HOST,
		'smtp_user' => $USERNAME,
		'starttls' => TRUE,
		'smtp_pass' => $PASSWORD,
		'smtp_port' => $PORT,
		'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
		'mailtype' => 'html'
	);

	$ci->load->library('email');

	$ci->email->initialize($config);

	$ci->email->from($SENDER, $email_from_txt);
	$ci->email->to($RECIPIENT);
	
	$ci->email->subject($SUBJECT);
	$ci->email->message($BODY);
	$ci->email->set_newline("\r\n");
	$sent_status = $ci->email->send();
	$ci->email->print_debugger();
	$ci->email->clear();
	
	return true;

}//end send_email($to, $from_email, $from_text, $subject, $email_body)

//Function get_longitude_latitude(): Fetch longitude, latitude by address
function get_longitude_latitude($address){
	
	$address = urlencode($address);
	$request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$address."&sensor=true";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $request_url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$xml = curl_exec($ch);
	curl_close($ch);
	
	$xml = simplexml_load_string($xml);

	$status = $xml->status;
	
	if ($status=="OK") {
		
	  $result_arr['latitude'] = $xml->result->geometry->location->lat;
	  $result_arr['longitude'] = $xml->result->geometry->location->lng;
	  
	}//end if ($status=="OK") 
	
	return $result_arr;

}//end get_longitude_latitude($address)

//Function filter_price():  Wil change the price formats as per the need.
function get_all_pharmacy($organzition_id = ''){
	
	$ci =& get_instance();
	
	$get_result = $ci->organization->get_all_pharmacy($organzition_id);
	
	return $get_result;
	
}//end get_global_settings(&$setting_name)

 function td_verify_if_pharmacy_already_purchased($hubnet_id){
		
		//Saving Lead if Exist
		$post_arr['hubnet_id'] = filter_string($hubnet_id);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'verify-if-pharmacy-already-purchased');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		foreach($post_arr as $key => $val)
			$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		return $server_output;
			
	}//end td_verify_pharmacy_already_exist()

 function td_renew_pharmacy_subscription($hubnet_id){
		
		//Saving Lead if Exist
		$post_arr['hubnet_id'] = filter_string($hubnet_id);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, TECHDEVELOPERS_API_SURL.'renew-pharmacy-subscription');
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$post_str = '';
		foreach($post_arr as $key => $val)
			$post_str .= $key.'='.$val.'&';
		
		$post_str = rtrim($post_str,'&');
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		return $server_output;
			
	}//end td_verify_pharmacy_already_exist()
	
	function count_all_users($group_id = ''){

		$ci =& get_instance();
		return $ci->users->count_all_users($group_id);
		
	}//end count_all_users($group_id = '')
	
	function verify_any_oral_package_pgd_expired($user_purchase_list){
		
		$ci =& get_instance();

		$oral_pgd_arr = $ci->pgd->get_pgd_list('O'); //List of all PGDs in Oral Package
		
		//This methods verify if any of the Oral PGD is expired within the Package if yes.. need to show the option to renew
		$any_oral_pgd_expired = 0;
		
		if(count($oral_pgd_arr) > 0){
		
			for($i=0;$i<count($oral_pgd_arr);$i++){
			
				$oral_pgd_expiry_date = $user_purchase_list['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['expiry_date'];
				$oral_pgd_is_expired = ((strtotime(date('Y-m-d')) <= strtotime($oral_pgd_expiry_date)) || $oral_pgd_expiry_date == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1 
				if($oral_pgd_is_expired){
					//echo $oral_pgd_arr[$i]['id'].'--'.$oral_pgd_expiry_date.'--'.$oral_pgd_is_expired;
					$any_oral_pgd_expired = 1;
					break;
				}//end if($oral_pgd_is_expired)
				
			}//end for($i=0;$i<count($oral_pgd_arr);$i++)
			
		}//end if(count($oral_pgd_arr) > 0)
		
		return $any_oral_pgd_expired;

	}//end verify_any_oral_package_pgd_expiring($user_purchase_list)
	
	function verify_any_oral_package_pgd_expiring($user_purchase_list){
		
		$ci =& get_instance();

		$oral_pgd_arr = $ci->pgd->get_pgd_list('O'); //List of all PGDs in Oral Package
		
		//This methods verify if any of the Oral PGD is about to expire according to the number of days set in global settings. If expiring need to show different button.
		$any_oral_pgd_expiring = 0;
		
		if(count($oral_pgd_arr) > 0){
		
			for($i=0;$i<count($oral_pgd_arr);$i++){
			
				$oral_pgd_expiry_date = $user_purchase_list['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['expiry_date'];
				$oral_pgd_is_expired = ((strtotime(date('Y-m-d')) <= strtotime($oral_pgd_expiry_date)) || $oral_pgd_expiry_date == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1 
				if($oral_pgd_expiry_date != '0000-00-00'){
					
					$current_date = new DateTime(date('Y-m-d')); // Current Date
					$expiry_date = new DateTime($oral_pgd_expiry_date); // Expiry Date
					
					$days_remaining_to_expire = $current_date->diff($expiry_date)->format("%r%a");
					
					$PGD_ADVANCE_RENEWAL_DURATION = 'PGD_ADVANCE_RENEWAL_DURATION';
					$pgd_renewal_duration_days = get_global_settings($PGD_ADVANCE_RENEWAL_DURATION); //Set from the Global Settings
					$pgd_renewal_duration_days = $pgd_renewal_duration_days['setting_value'];
					
					if($days_remaining_to_expire > 0 && $days_remaining_to_expire < $pgd_renewal_duration_days){
						$any_oral_pgd_expiring = 1;
						break;
					}//end if
					
				}//end if($oral_pgd_expiry_date != '0000-00-00')
				
			}//end for($i=0;$i<count($oral_pgd_arr);$i++)
			
		}//end if(count($oral_pgd_arr) > 0)
		
		return $any_oral_pgd_expiring;

	}//end verify_any_oral_package_pgd_expiring($user_purchase_list)

	function verify_any_premium_package_pgd_expired($user_purchase_list){
		
		$ci =& get_instance();

		$premium_oral_pgd_arr = $ci->pgd->get_pgd_list('OP'); //List of all PGDs in Premium Package
		
		//This methods verify if any of the Oral PGD is expired within the Package if yes.. need to show the option to renew
		$any_prem_pgd_expired = 0;
		
		if(count($premium_oral_pgd_arr) > 0){
		
			for($i=0;$i<count($premium_oral_pgd_arr);$i++){
			
				$prem_pgd_expiry_date = $user_purchase_list['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['expiry_date'];
				$prem_pgd_is_expired = ((strtotime(date('Y-m-d')) <= strtotime($prem_pgd_expiry_date)) || $prem_pgd_expiry_date == '0000-00-00') ? 0 : 1; //If PGD as 1 
				
				if($prem_pgd_is_expired){
					$any_prem_pgd_expired = 1;
					break;
				}//end if($prem_pgd_is_expired)
				
			}//end for($i=0;$i<count($premium_oral_pgd_arr);$i++)
			
		}//end if(count($premium_oral_pgd_arr) > 0)
		
		return $any_prem_pgd_expired;

	}//end verify_any_premium_package_pgd_expired($user_purchase_list)	
	
	function verify_any_premium_package_pgd_expiring($user_purchase_list){
		
		$ci =& get_instance();

		$premium_oral_pgd_arr = $ci->pgd->get_pgd_list('OP'); //List of all PGDs in Premium Package
		
		//This methods verify if any of the Oral PGD is about to expire according to the number of days set in global settings. If expiring need to show different button.
		$any_prem_pgd_expiring = 0;
		
		if(count($premium_oral_pgd_arr) > 0){
		
			for($i=0;$i<count($premium_oral_pgd_arr);$i++){
			
				$prem_pgd_expiry_date = $user_purchase_list['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['expiry_date'];
				$prem_pgd_is_expired = ((strtotime(date('Y-m-d')) <= strtotime($prem_pgd_expiry_date)) || $prem_pgd_expiry_date == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1 
				if($prem_pgd_expiry_date != '0000-00-00'){
					
					$current_date = new DateTime(date('Y-m-d')); // Current Date
					$expiry_date = new DateTime($prem_pgd_expiry_date); // Expiry Date
					
					$days_remaining_to_expire = $current_date->diff($expiry_date)->format("%r%a");
					
					$PGD_ADVANCE_RENEWAL_DURATION = 'PGD_ADVANCE_RENEWAL_DURATION';
					$pgd_renewal_duration_days = get_global_settings($PGD_ADVANCE_RENEWAL_DURATION); //Set from the Global Settings
					$pgd_renewal_duration_days = $pgd_renewal_duration_days['setting_value'];
					
					if($days_remaining_to_expire > 0 && $days_remaining_to_expire < $pgd_renewal_duration_days){
						$any_prem_pgd_expiring = 1;
						break;
					}//end if
					
				}//end if($prem_pgd_expiry_date != '0000-00-00')
				
			}//end for($i=0;$i<count($premium_oral_pgd_arr);$i++)
			
		}//end if(count($premium_oral_pgd_arr) > 0)
		
		return $any_prem_pgd_expiring;

	}//end verify_any_premium_package_pgd_expiring($user_purchase_list)
	
	function verify_any_pgd_expiring($pgd_id, $pgd_expiry_date){
		
		$ci =& get_instance();
		
		$pgd_expiring = 0;

		if($pgd_expiry_date != '0000-00-00'){
			
			$current_date = new DateTime(date('Y-m-d')); // Current Date
			$expiry_date = new DateTime($pgd_expiry_date); // Expiry Date
			
			$days_remaining_to_expire = $current_date->diff($expiry_date)->format("%r%a");
			
			$PGD_ADVANCE_RENEWAL_DURATION = 'PGD_ADVANCE_RENEWAL_DURATION';
			$pgd_renewal_duration_days = get_global_settings($PGD_ADVANCE_RENEWAL_DURATION); //Set from the Global Settings
			$pgd_renewal_duration_days = $pgd_renewal_duration_days['setting_value'];
			
			if($days_remaining_to_expire > 0 && $days_remaining_to_expire < $pgd_renewal_duration_days)
				$pgd_expiring = 1;
			
		}//end if($prem_pgd_expiry_date != '0000-00-00')
		
		return $pgd_expiring;

	}//end verify_any_pgd_expiring($user_purchase_list)
	
	function get_order_temp_details($user_id, $product_id = '', $package_type = '', $is_package = ''){

		$ci =& get_instance();
		return $ci->users->get_order_temp_details($user_id, $product_id, $package_type, $is_package);
		
	}//end get_order_temp_details($user_id, $pgd_id = '', $package_type = '', $is_package = '')
	
?>