<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();
		
		 // Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		$this->load->library('cart');

		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		$this->stencil->js('dashboard.js');

		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		$this->stencil->slice('header_top');
		
		//Sets the Left Navigation
		$this->stencil->slice('dashboard_left_pane');

		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		$this->stencil->slice('footer_script');
		
        /* --------------- Scripts for validations ------------ */
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
            
        // Js file using for CMS page validation
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation_2.min.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');
	}

	public function index(){
		
		// if($this->session->pmr_pharmacy_surgery_id){
			// redirect(SURL.'organization/dashboard');
		// } // if($this->session->pmr_pharmacy_surgery_id)

		// Set default cookie menu_item_number to My Dashboard
		set_cookie('menu_item_number','My Dashboard',time()+86500);
		
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 
		 $this->breadcrumbcomponent->add('My Dashboard', base_url().'dashboard');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//Loading Training Courses (For Purchase)
		$training_courses_arr = $this->training->get_training_courses_list($this->session->user_type);
		$data['training_courses_arr'] = $training_courses_arr;
		
		//Only Non-Prescribers can purchase the PGDs 
		if($this->session->is_prescriber == 0){
			
			//Loading ORAL PGD's (For Purchase)
			$oral_pgd_arr = $this->pgds->get_pgds_list('O');
			$data['oral_pgd_arr'] = $oral_pgd_arr;

			//Loading Premium ORAL PGD's (For Purchase)
			$premium_oral_pgd_arr = $this->pgds->get_pgds_list('OP');
			$data['premium_oral_pgd_arr'] = $premium_oral_pgd_arr;
	
			//Loading Vaccines PGD's (For Purchase)
			$vaccine_pgd_arr = $this->pgds->get_pgds_list('V');
			$data['vaccine_pgd_arr'] = $vaccine_pgd_arr;
			
			//$pgd_purchased_list = $this->purchase->get_purchased_items_split_by_user($this->session->id);
			//$data['pgd_purchased_list'] = $pgd_purchased_list;
			
		}//end if($this->session->is_prescriber == 0)
		
		$non_presriber_usertype_arr = array('2','3');
		$data['non_presriber_usertype_arr'] = $non_presriber_usertype_arr;
		
		//Get User Purchased List
		$purchased_items_split_arr = $this->purchase->get_purchased_items_split_by_user($this->session->id);
		
		//There are some cases when new PGD is added in Oral or Premium package, due to teh reason teh laready purchased user see the new PGD as waiting purchase.. To Avoid that we forcly add the pgd into the user list.
		
		$is_premium_package_purchased = $purchased_items_split_arr['pgds']['premium_package_purchased']; 
		if($is_premium_package_purchased){

			//I have purchased the package, now need to check which PGD is missing or not purchased.. We need to add that in a purchase list
			$get_pgds_list = $this->pgds->get_pgds_list('OP');
			
			for($i=0;$i<count($get_pgds_list);$i++){
				
				//Now check if all the OP pgds are in the purchased list, if not then add in a purchase list
				
				$pgd_key = array_search($get_pgds_list[$i]['id'], array_column($purchased_items_split_arr['pgds']['pgd_list'], 'product_id'));	
				
				if(!is_numeric($pgd_key) && $pgd_key == ''){
					$add_product_to_order = $this->purchase->add_pgd_to_order_manually($this->session->id, $get_pgds_list[$i]['id'],'OP');
				}//end if(!$pgd_key)
				
			}//end for($i=0;$i<count($get_pgds_list);$i++)
			
		}//end if($is_premium_package_purchased)

		$is_oral_package_purchased = $purchased_items_split_arr['pgds']['package_purchased']; 
		if($is_oral_package_purchased){

			//I have purchased the package, now need to check which PGD is missing or not purchased.. We need to add that in a purchase list
			$get_pgds_list = $this->pgds->get_pgds_list('O');
			
			for($i=0;$i<count($get_pgds_list);$i++){
				
				//Now check if all the OP pgds are in the purchased list, if not then add in a purchase list
				
				$pgd_key = array_search($get_pgds_list[$i]['id'], array_column($purchased_items_split_arr['pgds']['pgd_list'], 'product_id'));	
				
				if(!is_numeric($pgd_key) && $pgd_key == ''){
					$add_product_to_order = $this->purchase->add_pgd_to_order_manually($this->session->id, $get_pgds_list[$i]['id'],'O');
				}//end if(!$pgd_key)
				
			}//end for($i=0;$i<count($get_pgds_list);$i++)
			
		}//end if($is_oral_package_purchased)
		
		//Recalled the function to get the updated purchase list.
		$purchased_items_split_arr = $this->purchase->get_purchased_items_split_by_user($this->session->id);
		$data['purchased_items_split_arr'] = $purchased_items_split_arr;
		//echo $this->session->id; exit;
		//echo $this->db->last_query(); exit;
		//print_this($purchased_items_split_arr); exit;
		
		
		$VAT_PERCENTAGE = 'VAT_PERCENTAGE';	
		$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
		$data['vat_percentage'] = trim($vat_percentage['setting_value']);
		
		$data['user_data'] = $this->users->get_user_details($this->session->id);
		
		
		//Get Smaple Video
		
		//load main template for all Users
		$this->stencil->layout('dashboard_template'); //dashboard_template

		$this->stencil->css('jquery.fancybox.css');
		$this->stencil->css('star-rating.css');
		
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->js('star-rating.js');
		$this->stencil->js('jquery.mousewheel-3.0.6.pack.js');
		$this->stencil->js('source/helpers/jquery.fancybox-media.js?v=1.0.6.js');
		
		$this->stencil->js('org_dashboard.js');

		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('dashboard');
		
		//CMS DATA show On dashboard
		$cms_data_arr_oral_pgd_package = $this->cms->get_cms_page('oral-pgd-package');
		$data['cms_data_arr_oral_pgd_package'] = $cms_data_arr_oral_pgd_package;

		$cms_data_arr_premium_oral_pgd_packages = $this->cms->get_cms_page('premium-oral-pgd-packages');
		$data['cms_data_arr_premium_oral_pgd_packages'] = $cms_data_arr_premium_oral_pgd_packages;

		//set title
		$page_title = $cms_data_arr['cms_page_arr']['page_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $cms_data_arr['cms_page_arr']['meta_description'],
			'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
			'meta_title' => $cms_data_arr['cms_page_arr']['meta_title']
		));
		
		$data['page_data'] = $cms_data_arr['cms_page_arr'];

		//load main Dashbaord template for DOCTOR
		$this->stencil->paint('dashboard/dashboard',$data);
		
	} //end index()

	// Start - public function get_user_details()
	public function get_user_details($user_id=''){
		
		$my_role_in_pharmacy_surgery = $this->pharmacy->get_my_role_in_pharmacy_surgery($user_id, $pharmacy_surgery_id = '');
		
		$is_si = 0;
		$is_manager = 0;
		
		if($my_role_in_pharmacy_surgery['is_si'])
			$is_si = 1;
		elseif ($my_role_in_pharmacy_surgery['is_manager']){
			$is_manager = 1;	
		}
		
		$data['is_si'] = $is_si;
		$data['is_manager'] = $is_manager;
		
		//print_this($my_role_in_pharmacy_surgery); exit;

		if($user_id == '')
			redirect(SURL);

		$data['user_data'] = $this->users->get_user_details($user_id);

		$this->stencil->layout('ajax');
        $this->stencil->paint('dashboard/user_details', $data);

	} // End - public function get_user_details()

	//Function add_to_basket(): Add the Items into the Cart
	public function add_to_basket(){
		
		if($this->input->post()){
			
			extract($this->input->post());
			
			$data = array(
				'id'      => $p_id,
				'qty'     => 1,
				'price'   => $p_price,
				'name'    => $p_name,
				'p_type' => $p_type,
				'o_pack' => $o_package
			);
			
			
			//print_this($data);
			$this->cart->insert($data);
			
		}//end if(!$this->input->post())
		
		//echo '<pre>';
		//print_r($this->cart->contents());

		$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
		$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
		$data['vat_percentage'] = trim($vat_percentage['setting_value']);
		
		//load main template
		$this->stencil->layout('ajax'); //ajax
		$this->stencil->paint('dashboard/dashboard_basket.php',$data);

	}//end add_to_basket()
	
	//Function remove_from_basket(): Remove Single Item from the cart
	public function remove_from_basket(){
		
		if($this->input->post()){
			extract($this->input->post());
			
			$this->cart->remove($row_id);
			
		}//end if($this->input->post())

		//load main template
		$this->stencil->layout('ajax'); //ajax
		$this->stencil->paint('dashboard/dashboard_basket.php',$data);
		
	}//end remove_from_basket()

	//Function remove_from_basket(): Empty entire cart
	public function empty_basket(){
		
		$this->cart->destroy();
		//load main template
		$this->stencil->layout('ajax'); //ajax
		$this->stencil->paint('dashboard/dashboard_basket.php',$data);
		
	}//end empty_basket()

	//Function checkout(): Checkout to the PayPal
	public function checkout(){
		
		$to_buy = array(
			'desc' => 'Hubnet', 
			'currency' => CURRENCY, 
			'type' => PAYMENT_METHOD, 
			'return_URL' => SURL.'dashboard/checkout-success', 
			// see below have a function for this -- function back()
			// whatever you use, make sure the URL is live and can process
			// the next steps
			'cancel_URL' => SURL.'dashboard', // this goes to this controllers index()
			'shipping_amount' => 0.00, 
			'get_shipping' => false
		);
		
		$desc_str = '(';
		// Iterating through the content of your shopping cart.
		foreach($this->cart->contents() as $row_id => $items){
			
			$sub_total+=$items['price'];
			
			$desc_str .= substr($items['name'],0,25).', ';
			
			$temp_product = array(
				'name' => $items['name'], 
				'desc' => $items['p_type'], 
				'number' => $items['id'], 
				'quantity' => 1, 
				'amount' => $items['price']);
				
			// add product to main $to_buy array
			$to_buy['products'][] = $temp_product;
			
		}//end foreach($this->cart->contents() as $row_id => $items)
		
		$desc_str = rtrim($desc_str,', ').')';

		$desc_str.' inc VAT';
		
		//echo $desc_str; exit;
		$to_buy['desc'] = $desc_str;

		//print_this($to_buy); exit;

		$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
		$vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings

		$vat_amount = (trim($vat_percentage['setting_value']) / 100) * $sub_total;
		$vat_amount = filter_price($vat_amount);
		
		$to_buy['tax_amount'] = $vat_amount;
		
		// enquire Paypal API for token
		$set_ec_return = $this->paypal_ec->set_ec($to_buy);
		
		if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
			// redirect to Paypal
			$this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
			// You could detect your visitor's browser and redirect to Paypal's mobile checkout
			// if they are on a mobile device. Just add a true as the last parameter. It defaults
			// to false
			// $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true);
			
		} else {
			$this->_error($set_ec_return);
			
		}//end if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) 
		
	}//end checkout()
	
	public function checkout_success(){
		
		$token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
		
		$get_ec_return = $this->paypal_ec->get_ec($token);

		if(isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
			// at this point, you have all of the data for the transaction.
			// you may want to save the data for future action. what's left to
			// do is to collect the money -- you do that by call DoExpressCheckoutPayment
			// via $this->paypal_ec->do_ec();
			//
			// I suggest to save all of the details of the transaction. You get all that
			// in $get_ec_return array
			$ec_details = array(
				'token' => $token, 
				'payer_id' => $payer_id, 
				'currency' => CURRENCY, 
				'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
				'IPN_URL' => site_url('dashboard/ipn'), 
				// in case you want to log the IPN, and you
				// may have to in case of Pending transaction
				'type' => PAYMENT_METHOD);
				
			// DoExpressCheckoutPayment
			$do_ec_return = $this->paypal_ec->do_ec($ec_details);
			
			if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
				
				// at this point, you have collected payment from your customer
				// you may want to process the order now.

				if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] == 'Success'){
					
					$data['get_ec_return'] = $get_ec_return;
					$data['do_ec_return'] = $do_ec_return;
					$data['user_id'] = $this->session->id;
					$data['purchased_by_id'] = $this->session->id;
					$data['num_of_products'] = count($this->cart->contents());
					
					$add_purchase_status = $this->purchase->add_products_to_order($data);
					
					if($add_purchase_status){
						$this->cart->destroy();
						
						//Custom Message set from admin site prefrences
						$paypal_success = 'Congratulations! You have successfully purchased your items, please check your email for the purchase receipt. Thank You!';
						$this->session->set_flashdata('paypal_success', $paypal_success);						
						redirect(SURL.'dashboard');
					}//end if($add_purchase_status)
					
				}else{
					echo "OOPS";exit;	
				}//end if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] = 'Success')
				
			} else {
				
				$this->_error($do_ec_return);
				
			}
		} else {
			$this->_error($get_ec_return);
		}
		
	}//end checkout_success()

	public function ipn(){
		$logfile = 'ipnlog/' . uniqid() . '.html';
		$logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
		file_put_contents($logfile, $logdata);
		
	}//end ipn()

	public function _error($ecd){

		$erro_txt .= "<h3>error at Express Checkout<h3>";
		$erro_txt .= "<pre>" . print_r($ecd, true) . "</pre>";
		
		$data['err_msg'] = $ecd;
		$this->stencil->layout('frontend_template_subpage'); //frontend template
		$this->stencil->paint('errors/paypal_failed',$data);
	}//end _error($ecd)

	//Update user profile/ password, signatures etc
	public function settings(){

		$get_user_profile = $this->users->get_user_details($this->session->id);
		
		if(!$get_user_profile)
			redirect(SURL);	
		
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Settings', base_url().'settings');
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		$data['get_user_profile'] = $get_user_profile;

		$this->stencil->js('jquery1.8.2.min.js');
		$this->stencil->js('jquery-ui1.9.0.min.js');
		$this->stencil->css('jquery.signature.css');
		$this->stencil->js('jquery.signature.js');
		$this->stencil->js('signature.js');

		// include org_dashboard.js to view contract [ Invitations response ]
		$this->stencil->js('org_dashboard.js');

		$this->stencil->css('jquery.fancybox.css');
		$this->stencil->css('star-rating.css');
		$this->stencil->js('jquery.fancybox.js');

		$this->stencil->layout('dashboard_template'); //dashboard_template

		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Js file using for  Form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Form  Validation
		
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		
		// Js Form  page form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form Validation

		//load main Dashbaord template for DOCTOR
		$this->stencil->paint('dashboard/settings',$data);
		
		
	}//end update_setting()
	
	public function settings_process(){

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('setting_profile_btn')) redirect(base_url());
		
		// PHP Validation
		$validation_error = 0;
		if($this->input->post('type') == 'profile'){
		
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			
			$validation_error = 1;
		
		} else if ($this->input->post('type') =='password') {
			
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
			$this->form_validation->set_rules('new_password', 'Password', 'trim|required|min_length[8]|matches[confirm_password]');
		    $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required');
			
			$validation_error = 1;

		}//end if($this->input->post('type') == 'profile')
		
		if($validation_error){
			
			if($this->form_validation->run() == FALSE){
				// PHP Error 
				$this->session->set_flashdata('err_message', validation_errors());
				redirect(base_url().'dashboard/settings');
			}//end if($this->form_validation->run() == FALSE)

		}//end if($validation_error)

		if($this->input->post('type') == 'password'){
			
			$get_user_profile = $this->users->get_user_details($this->session->id);
			
			//Verify if the database password matches with the new password
			if($get_user_profile['password'] != md5(trim($this->input->post('old_password')))){

				$err_message = 'Your Old Password  donot match with our current database record. Please try again.';
				$this->session->set_flashdata('err_message', $err_message);						
				redirect(SURL.'dashboard/settings');
				
			}//end if($get_user_profile['password'] != md5(trim($this->input->post('type'))))

			//Verify if the database password matches with the new password
			if($this->input->post('new_password') != $this->input->post('confirm_password')){

				$err_message = 'Your New Password donot match with the Confirm Password. Please try again.';
				$this->session->set_flashdata('err_message', $err_message);						
				redirect(SURL.'dashboard/settings');
				
			}//end if($this->input->post('new_password') != $this->input->post('confirm_password'))
			
		}//end if($this->input->post('type') == 'pass')
		
		//Update the Settings into the user table
		$update_profile = $this->users->update_user_profile($this->session->id,$this->input->post());
		
		if($update_profile && !isset($update_profile['error_upload'])){
			
			
				$this->session->set_userdata('last_name',$this->input->post('last_name'));
				$this->session->set_userdata('registration_no',$this->input->post('registration_no'));
				$ok_message = 'Settings successfully updated.';
				$this->session->set_flashdata('ok_message', $ok_message);						
				redirect(SURL.'dashboard/settings');
			
		}else{
			
			if($update_profile['error_upload']){

				$err_message = 'Update Setting Failed: '.$update_profile['error_upload'];
				$this->session->set_flashdata('err_message', $err_message);						
				redirect(SURL.'dashboard/settings');
				
			}else{
				
				$err_message = 'Something went wrong while updating your settings, try again later or contact administrator..';
				$this->session->set_flashdata('err_message', $err_message);						
				redirect(SURL.'dashboard/settings');

			}//end if($update_profile['error_upload'])
			
		}//end if($update_profile)
		
	}//end settings_process()

	//Update Few settings against the users either onetime or someother.
	public function update_user_setting(){
		
		if($this->input->post()){
			
			//Update the Settings into the user table
			$this->users->update_user_setting($this->session->id,$this->input->post());
		}//end if($this->input->post())
		
	}//end update_setting()

	//This function will process the approval of the invitations.
	public function invitation_approval($invitation_id, $invitation_status){

		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));

		if($invitation_id != '' && $invitation_status != ''){
			//Check if the logged-in User ID and Invitation Sent For Id's are same in order to process the results.
			$get_invitation_details = $this->invitations->get_invitation_details($invitation_id);
			
			if($get_invitation_details['invitation_sent_to'] == $this->session->id){
				// Valid Request

				// Check Condition: If Already SI in other ORGANIZATION, cannot accept the SI Invitation again of any other organization
				$check_already_si = $this->organization->user_already_superintendent($this->session->id);
				
				if($get_invitation_details['invitation_type'] == 'SI'){
					//Check if the Invitation Type is SI, and the User is already a SI in any OTHER ORGANIZATION
					
					if($check_already_si){
						// User Already an SI in Other Organization, Show error
						
						// Delete the Invitation Record
						$delete_invitation = $this->invitations->delete_invitation($invitation_id);
	
						//Invalid Process
						$this->session->set_flashdata('err_message', 'ERROR: You are already a Superintendent in an Organisation, you cannot be a Superintendent in any another Organization');

						//We have a Valid Invitation Acceptence, now check if still user belongs to any organizaition, if yes redirect to ORG dashboard
						$belong_to_any_organization = $this->organization->verify_if_user_in_organization($this->session->id);
						
						/*
						if($belong_to_any_organization){
							
							redirect(base_url().'organization/dashboard');	
						}else{
							
							redirect(base_url().'dashboard');
						}//end if($belong_to_any_organization)
						*/

						redirect(base_url().'dashboard');

					}else{
						//User is not already a SI in any, so just check if he is a pharmacist or not.

						$si_usertype = array('2','3');
			
						//Must be a Pharmacist or a Nurse
						if(!in_array($get_invitation_details['sent_to_usertype'],$si_usertype)){
						
							//User is not a Pharmacist so he cannot be a SI
							$this->session->set_flashdata('err_message', 'ERROR: Superintendent can only be a Pharmacist or a Nurse. The email address you have entered is not a Pharmacist nor a nurse.');

							//We have a Valid Invitation Acceptence, now check if still user belongs to any organizaition, if yes redirect to ORG dashboard
							$belong_to_any_organization = $this->organization->verify_if_user_in_organization($this->session->id);
							
							/*if($belong_to_any_organization){
								
								redirect(base_url().'organization/dashboard');	
							}else{
								
								redirect(base_url().'dashboard');
							}//end if($belong_to_any_organization)
							*/

							redirect(base_url().'dashboard');

						}//end if($get_invitation_details['sent_to_usertype'] != 2)
							
					}//end if($check_already_si)						
					
				}else{

					// User Type is not SI, now check whatever the Invitation Type is, if user is already SI in any Organization is allowed to become any invtiation type to the same organizatgion only not any other.
					
					if( $check_already_si ) {

						//Yes, User is SI in an Organization 
						if($check_already_si['id'] != $get_invitation_details['organization_id']){
							//The Invitation received and the SI organization ID is not same, means the invitation is from other organization which is not allowed, generate error and delete the invitation

							//Delete the Invitation Record
							$delete_invitation = $this->invitations->delete_invitation($invitation_id);

							//We have a Valid Invitation Acceptence, now check if still user belongs to any organizaition, if yes redirect to ORG dashboard
							$belong_to_any_organization = $this->organization->verify_if_user_in_organization($this->session->id);
		
							//Invalid Process
							$this->session->set_flashdata('err_message', 'ERROR: You cannot be the member of any other organisation.');
							
							/*
							if($belong_to_any_organization){
								
								redirect(base_url().'organization/dashboard');	
							}else{
								
								redirect(base_url().'dashboard');	
							}//end if($belong_to_any_organization)
							*/

							redirect(base_url().'dashboard');

						}//end if($check_already_si['organization_id'] != $get_invitation_details['organization_id'])
					}//end if($check_already_si)
					
				}//end if($get_invitation_details['invitation_type'] == 'SI')
				
				
				//User is not a SI in any ORGANIZATION, all above cases passed!
				$process_invitation = $this->invitations->process_invitation_approval($get_invitation_details['invitation_sent_to'],$get_invitation_details,$invitation_status, $this->user_org_superintendent);
				
				if($process_invitation){

					if($invitation_status == 1){

						$get_my_organizations = get_pharmacy_surgery_list($this->session->id, ''); //Get My Organizations List
						$unique_my_organizations = unique_multidim_array( $get_my_organizations, 'organization_id' );

						if(count($unique_my_organizations) == 1){

							$pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id, '', $unique_my_organizations[0]['organization_id'] );

							if(count($pharmacies_surgeries) == 1){

								$count_belong_to_pharmacies = 1;

								// Set Organization Sessions
								$this->session->organization_id = $unique_my_organizations[0]['organization_id'];
								
								// Set Pharmacy / Surgery Sessions
								$this->session->pharmacy_surgery_id = $pharmacies_surgeries[0]['pharmacy_surgery_id'];

								$is_default = $this->pmr->get_default_prescriber_organization_list($this->session->id, $unique_my_organizations[0]['organization_id']);

								if($is_default){
									$this->session->pmr_org_pharmacy = 'O|'.$unique_my_organizations[0]['organization_id'];
								} else {
									$this->session->pmr_org_pharmacy = 'P|'.$pharmacies_surgeries[0]['pharmacy_surgery_id'].'|'.$unique_my_organizations[0]['organization_id'];
								} // if($is_default)

								$my_role_in_pharmacy_surgery_data = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $pharmacies_surgeries[0]['pharmacy_surgery_id']); // Get User role in the pharmacy / surgery [ By pharmacy_surgery_id ]
								
								if($my_role_in_pharmacy_surgery_data['is_manager'] == 1){
									$this->session->is_manager = 1;
								} // if($my_role_in_pharmacy_surgery_data['is_staff'] == 1)

								// If the user accepts the invitation and this is the first pharmacy/surgery the user belongs to
								// Verify if the governance is purchased and the governance is on for this pharmacy/surgery
								$global_settings_arr = get_pharmacy_surgery_global_settings($pharmacies_surgeries[0]['pharmacy_surgery_id']); 
  								$governance_purchased_arr = $this->governance->get_governance_purchased_pharmacies($pharmacies_surgeries[0]['organization_id'],'P',$pharmacies_surgeries[0]['pharmacy_surgery_id']);

  								if($global_settings_arr['governance_status'] && $governance_purchased_arr)
  									$show_governance = 1;
  								// if($global_settings_arr['governance_status'] && $governance_purchased_arr)

  								$pharmacy_surgery_name = filter_string($pharmacies_surgeries[0]['pharmacy_surgery_name']);

							} else {

								$pharmacy_surgery = $this->pharmacy->get_pharmacy_surgery_details($get_invitation_details['pharmacy_id']);
								$pharmacy_surgery_name = filter_string($pharmacy_surgery['pharmacy_surgery_name']);

							} // if(count($pharmacies_surgeries) == 1)

						}else{
							
							if(count($pharmacies_surgeries) == 0){
								//This is the conidtion for the elest SI for the first time. When there are no Pharmacies, yet added into the system we will show organization name instead.
								$organization_details = $this->organization->get_organization_details($get_invitation_details['organization_id']);
								$pharmacy_surgery_name = filter_string($organization_details['company_name']);
								
							}//end if(count($unique_my_organizations) == 0)
							
						}// if(count($unique_my_organizations) == 1)													

						// If the user accepts the invitation and this is the first pharmacy/surgery the user belongs to
						// Verify if the governance is purchased and the governance is on for this pharmacy/surgery
						if($show_governance){
							
							$this->session->set_flashdata('ok_message', "You have now accepted the contract to work within ".$pharmacy_surgery_name.". To proceed and access the locations dashboard, you will need to read and sign the Standard Operating Procedures listed below.");
							
							$this->session->okay_message = "You have now accepted the contract to work within ".$pharmacy_surgery_name.". To proceed and access the locations dashboard, you will need to read and sign the Standard Operating Procedures listed below.";

							$cookie_name = "menu_item_number";
							$cookie_value = "Read Governance";
							setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

							redirect(base_url().'organization/dashboard');

						} else {
							
							if($count_belong_to_pharmacies == 1){
								$this->session->set_flashdata('ok_message', 'You have joined '.ucfirst($pharmacy_surgery_name).'.');
								$this->session->okay_message = 'You have joined '.ucfirst($pharmacy_surgery_name).'.';
								//redirect(base_url().'organization/dashboard');
							} else {
								
								$this->session->set_flashdata('ok_message', 'You have now accepted the contract for '.$pharmacy_surgery_name.'. Please select the pharmacy from the dropdown above to read governance.');
							}
							// if($count_belong_to_pharmacies == 1)
							
						} // if($show_governance)

					} else {

						$this->session->set_flashdata('err_message', 'You have rejected the contract, the manager of your organisation will be in contact shortly.');
						$this->session->error_message = 'You have rejected the contract, the manager of your organisation will be in contact shortly.';

					} // if($invitation_status == 1)
					
					//We have a Valid Invitation Acceptence, now check if still user belongs to any organizaition, if yes redirect to ORG dashboard
					$belong_to_any_organization = $this->organization->verify_if_user_in_organization($this->session->id);

					/*
					if($belong_to_any_organization){
							
						// If the user is Owner | Superintendent
						redirect(base_url().'organization/dashboard');
						
					} else {
						
						redirect(base_url().'dashboard');	
					} //end if($belong_to_any_organization)
					*/

					redirect(base_url().'dashboard');

				} else {
					
					// Invalid Process
					$this->session->set_flashdata('err_message', 'Unauthorized Access or Invalid Request.');
					redirect(base_url().'dashboard');

				} //end if($process_invitation)
				
			} else {
				
				//Invalid Process
				$this->session->set_flashdata('err_message', 'Unauthorized Access or Invalid Request.');
				redirect(base_url().'dashboard');
				
			} //end if($get_invitation_details['invitation_sent_to'] == $this->session->id)
			
		} else {
			
			//Invalid Process
			$this->session->set_flashdata('err_message', 'Unauthorized Access or Invalid Request.');
			redirect(base_url().'dashboard');
			
		}//end if($invitation_id!='' && $invitation_status !='')
		
	} // End - invitation_approval($invitation_id,$invitation_status)

	// Start - public function get_invitation_data()
	public function get_invitation_data(){

		if(!$this->input->post()) redirect(SURL);

		$invitation_id = $this->input->post('invitation_id');
		$invitation_row = $this->invitations->get_invitation_details($invitation_id);
		
		if(!$invitation_row['viewed_date'])
			$update_contact_seen_log = $this->invitations->update_contract_invitation_log($invitation_id, 'viewed_date');

		$user_signatures = $this->users->get_user_signatures($this->session->id);
		if(filter_string($user_signatures['signature_type']) == 'svn')
			$signature_str =  filter_string($user_signatures['signature']);
		elseif(filter_string($user_signatures['signature_type']) == 'image')
			$signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";	
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));

		if($user_signatures['signature_type'])
			$signatures_arr = $user_signatures;
		else
			$signatures_arr = "";
		// if($user_signatures['signature_type'])

		// Send response to ajax call - Invitation details
		if($invitation_row){
			$search_arr = array('[USER_SIGNATURE]','[SIGNED_DATE_TIME]','[SURL]');
			$replace_arr = array($signature_str,'Signed at '.date('G:i').' on '.date('d/m/y').' by',SURL);
			$contract_txt = filter_string($invitation_row['hr_contract']);
			$contract_txt = str_replace($search_arr,$replace_arr,$contract_txt);
			$invitation_row['hr_contract'] = $contract_txt;
			
			echo json_encode(array('error_status' => 0, 'row' => $invitation_row, 'user_signatures' => $signatures_arr));
		}else
			echo json_encode(array('error_status' => 1, 'row' => '', 'user_signatures' => $signatures_arr));
		// end - if($invitation_row)

	} // public function get_invitation_data()
	
	//Function send_contract_changes_process(); Will send the requested changes of contract to OSP back This done by user.
	public function send_contract_changes_process(){
		
		extract($this->input->post());

		if(!$this->input->post()) redirect(SURL.'dashboard');

		$get_invitation_data = $this->invitations->get_invitation_details($contract_invitation_id);
		
		if(!$get_invitation_data)
			redirect(SURL.'dashboard');
		else{
			$update_invitation = $this->invitations->update_invitation_for_contract_by_user($this->input->post());
			
			if($update_invitation){
				$this->session->set_flashdata('ok_message', 'A request has been sent to your organisation lead to change your contract. This may take a few days to process. Once processed this message will be replaced, click "View Contract" again and you will see your new updated contract.');
				redirect(SURL.'dashboard');
				
			}else{
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect(SURL.'dashboard');
				
			}//end if($update_invitation)

		}//end if(!$get_invitation_data)
		
	}//end send_contract_changes_process()

	// Start - function get_pharmacy_details($pharmacy_surgery_id) : Function to show Pharmacy / Surgery details on popup
    public function get_pharmacy_details($pharmacy_surgery_id){

        $data['pharmacy'] = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);

        $this->stencil->layout('ajax');
        $this->stencil->paint('dashboard/pharmacy_details', $data);

    } // public function get_pharmacy_details($pharmacy_surgery_id)

	// Start - function get_organization_details($organization_id) : Function to show Organization details on popup
    public function get_organization_details($organization_id){

		$organization_data = $this->organization->get_organization_details($organization_id); 
		
	    $data['organization_data'] = $organization_data;

        $this->stencil->layout('ajax');
        $this->stencil->paint('dashboard/organization_details', $data);

    } // public function get_organization_details($pharmacy_surgery_id)

    // Start - function get_user_type_details($invitation_type) : Function to get the invitation user type [ user role ] details
    public function get_user_type_details($invitation_type){
    	
    	$this->load->model('invitations_mod', 'invitation');

        if($invitation_type == 'SI')
			$text = 'A superintendent is a pharmacist who ensures that the staff working within their pharmacy organisation is clinically fit for purpose. Superintendents write Standard Operating Procedures (SOPs) to communicate best practice recommendations.';
		elseif($invitation_type == 'M')
			$text = 'A manager of a location is someone who is in charge of the day to day operations within a location, this is usually a pharmacist however can be a a technician or and assistant.';

		$data['invitation_type'] = $invitation_type;

		// Verify If not SI and M
		if($text == ''){

			if($invitation_type == 'DO')
				$id = 1;
			elseif($invitation_type == 'PH')
				$id = 2;
			elseif($invitation_type == 'PA')
				$id = 4;
			elseif($invitation_type == 'NU')
				$id = 3;
			elseif($invitation_type == 'PR')
				$id = 6;
			elseif($invitation_type == 'TE')
				$id = 5;
			elseif($invitation_type == 'NH')
				$id = 7;
			// if($invitation_type == 'DO')

			$usertype_arr = $this->invitation->get_usert_type_description($id);

			$text = $usertype_arr;

		} // if($text == '')

		$data['usertype'] = $text;

        $this->stencil->layout('ajax');
        $this->stencil->paint('dashboard/user_type_details', $data);

    } // End - public function get_user_type_details($invitation_type)

    // Start - function get_user_details_popup() : Function to show user information to be shown on fancybox popup [ View Contract ]
    public function get_user_details_popup(){

    	

    } // End - function get_user_details_popup()

    ////////////////////////////////////////
    // Temp function to test the Certificate
    ////////////////////////////////////////
    public function test(){
    	
    	$this->stencil->layout('ajax');
    	
		$html = $this->load->view('dashboard/test',$data,true);
		
		echo $html; exit;
		
		//echo $html; exit;
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf->AddPage('L'); // L - P
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('test.pdf','D'); // save to file because we can
		
		exit;

    }//end test()
	
	public function test_download(){

        $file_name = 'PGD Certificate.pdf';

        // $html = '<div style="border: 3px solid green;">'. $_POST['charts_html']. '</div>';
        
        $data['abc'] = '123';
        $html = $this->load->view('dashboard/test',$data, true);
        
        echo $html;
        exit;

		$user_signatures = $this->users->get_user_signatures($this->session->id);

        if(filter_string($user_signatures['signature_type']) == 'svn')
			$signature_str = filter_string($user_signatures['signature']);
		elseif(filter_string($user_signatures['signature_type']) == 'image')
			$signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
		// if(filter_string($user_signatures['signature_type']) == 'svn')										

		$search_arr = array('[USER_SIGNATURE]');
		$replace_arr = array($signature_str);
		$html = str_replace($search_arr,$replace_arr,$html);
		
        //print_r($html);
        //exit;

        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        //$pdf->SetFooter('123'.'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure            
        $pdf->AddPage('L'); // L - P

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can
	}
	
	public function register_organization(){
		
		$this->load->model('country_mod','country');

		//Active Organization Country List
		$country_active_arr = $this->country->get_active_countries();
		$data['country_active_arr'] = $country_active_arr;

        $this->stencil->layout('pharmacy_settings'); //pgd_detail_ajax_template

		//$this->stencil->js('kod_scripts/custom.js');

		
        //edit Pharmacy Surgery data
        $this->stencil->paint('dashboard/register_organization', $data);
		
	}//end register_organization()

	public function register_organization_process(){
		
		$this->load->model('register_mod','register');
		$this->load->model('Users_mod', 'users');

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('company_name')) redirect(base_url());

		$register_org = $this->register->add_new_organization($this->session->id, $this->input->post());
		
		if($register_org){
			
			// Delete cookie menu_item_number
			delete_cookie('menu_item_number');
			
			//Distroy All Sessions
			//$this->session->sess_destroy();

			$this->session->unset_userdata('id');
			$this->session->unset_userdata('first_name');
			$this->session->unset_userdata('last_name');
			$this->session->unset_userdata('full_name');
			$this->session->unset_userdata('email_address');
			$this->session->unset_userdata('registration_no');
			$this->session->unset_userdata('is_owner');
			
			$this->session->unset_userdata('user_type');
			$this->session->unset_userdata('organization');
			
			$this->session->set_flashdata('ok_message', 'Your organisation is successfully created. Please relogin to your account to access the organisation features.');
			redirect(base_url().'login');
			
		}//end if($register_org)
					
	}//end public function register_process()
	
	public function new_change_password(){
		
		$cms_data_arr = $this->cms->get_cms_page('terms--conditions');
		$data['cms_data'] = $cms_data_arr['cms_page_arr'];

		$this->stencil->layout('ajax');
        $this->stencil->paint('dashboard/new_change_password', $data);
		
	}//end new_change_password()
	
	public function new_change_password_process(){
		
		if(!$this->input->post() && !$this->input->post('new_password')) redirect(base_url());
		
		$update_profile = $this->users->update_user_profile($this->session->id,$this->input->post());
		
		if($update_profile){
			redirect(base_url().'dashboard');
		}
		
	}//end new_change_password_process()

} //end /* End of file */