<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('cms_mod','cms');
		$this->load->model('organization_mod','organization');
		$this->load->model('users_mod','users');

		$this->load->model('pharmacy_mod', 'pharmacy');
		$this->load->model('pmr_mod', 'pmr');
		
		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		//load main template
		$this->stencil->layout('frontend_template_subpage'); //frontend template
		
		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		$this->stencil->slice('header_top');
		
		//Sets the Left Navigation
		$this->stencil->slice('left_pane');

		//Sets the Right Navigation
		$this->stencil->slice('right_pane');
		
		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		$this->stencil->slice('footer_script');
	}

	public function index(){
		
		if($this->session->id) redirect(SURL.'dashboard');
		
		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('login');
		
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
		
		// Js file using for  Form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		
		$this->stencil->js('https://www.google.com/recaptcha/api.js');

		// end Form  Validation
		
		$data['noscript_text'] = $this->cms->get_noscript_text('login');
		
		// Form  Validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// End Form  Validation
			
		
		// Js Form  page form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form Validation
		
		$this->stencil->paint('login/login',$data); 
		
	} //end index()
	
	//Function login_process(): Process and authenticate the login form
	public function login_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('login_btn')) redirect(base_url());
		
		if(CAPTCHA_ENABLE == 1){
			// Captcha Validation
			if($this->input->post('g-recaptcha-response') == ''){
				 
				$this->session->set_flashdata('err_message', 'Please verify Captcha');
				redirect(base_url().'login');
	
			}//end if($this->input->post('g-recaptcha-response') == '')
			
		}//end if(CAPTCHA_ENABLE == 1)
		
		// PHP Validation 
		$this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		//Clear the cart everytime new login process
		$this->load->library('cart');
		$this->cart->destroy();
		
		//This part is used for auto-login by admin side.
		if($this->input->post('is_admin') && $this->session->admin_id)
			$admin_login = 1;
		else
			$admin_login = 0;
			
		$chk_isvalid_user = $this->login->validate_credentials($this->input->post('email_address'),$this->input->post('password'),$admin_login);
		
		if($this->form_validation->run() == FALSE){
			
			// PHP Error 
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'login');
			
		} else {
			
			if($chk_isvalid_user){
				
				// Delete cookie menu_item_number
				delete_cookie('menu_item_number');

				// Set default cookie menu_item_number to My Dashboard
				set_cookie('menu_item_number','My Dashboard',time()+86500);
				
				$this->session->set_userdata($chk_isvalid_user);
				// redirect(base_url().'dashboard');
				
				$dismiss_org_id = ($this->session->organization_id) ? $this->session->organization_id : $this->session->organization['id'];

				$dismiss_messages = $this->organization->dismiss_message_list($dismiss_org_id);
				
				$dismiss_messages_arr = array();
				
				for($i=0;$i<count($dismiss_messages);$i++){
					
					if($dismiss_messages[$i]['pharmacy_id'] == NULL || !$dismiss_messages[$i]['pharmacy_id'])
						$dismiss_messages_arr['dismiss_message'][$dismiss_messages[$i]['message_type']] = 1;
						
					else
						$dismiss_messages_arr['dismiss_message'][$dismiss_messages[$i]['pharmacy_id']][$dismiss_messages[$i]['message_type']] = 1;
					
				}//end for($i=0;$i<count($dismiss_messages);$i++)
				
				$this->session->set_userdata($dismiss_messages_arr);
				
				$belong_to_any_organization = $this->organization->verify_if_user_in_organization($this->session->id);
				$user_org_superintendent = $this->organization->user_already_superintendent($this->session->id);

				if($belong_to_any_organization){
					
					if($user_org_superintendent || ($this->session->is_owner && $this->session->is_owner == 1)){

					    if(!$this->session->is_owner){
					       $si_org_details = $this->organization->user_already_superintendent($this->session->id);
					       $my_organization_id = $si_org_details['id'];

					    } else
					       $my_organization_id = $this->session->organization['id'];
					    // if(!$this->session->is_owner)

						$pharmacies_surgeries = $this->pharmacy->get_pharmacy_surgery_list($my_organization_id);		
						
						if(count($pharmacies_surgeries) > 0){

							// Set Pharmacy / Surgery Sessions
							$this->session->pharmacy_surgery_id = $pharmacies_surgeries[0]['pharmacy_surgery_id'];
							$this->session->pmr_pharmacy_surgery_id = $pharmacies_surgeries[0]['pharmacy_surgery_id'];

							// Set Organization Sessions
							$this->session->organization_id = $my_organization_id;
							$this->session->pmr_organization_id = $my_organization_id;

							$is_default = $this->pmr->get_default_prescriber_organization_list($this->session->id, $my_organization_id);

							if($is_default){
								$this->session->pmr_org_pharmacy = 'O|'.$my_organization_id;
							} else {
								$this->session->pmr_org_pharmacy = 'P|'.$pharmacies_surgeries[0]['pharmacy_surgery_id'].'|'.$my_organization_id;
							} // if($is_default)
							
						} // if(count($pharmacies_surgeries) > 0)

					} else {

						$get_my_organizations = get_pharmacy_surgery_list($this->session->id, ''); //Get My Organizations List

						$unique_my_organizations = unique_multidim_array( $get_my_organizations, 'organization_id' );

						if(count($unique_my_organizations) == 1){

							$pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id, '', $unique_my_organizations[0]['organization_id'] );

							if(count($pharmacies_surgeries) > 0){
								
								// Set Organization Sessions
								$this->session->organization_id = $unique_my_organizations[0]['organization_id'];
								$this->session->pmr_organization_id = $this->session->organization_id;
								
								// Set Pharmacy / Surgery Sessions
								$this->session->pharmacy_surgery_id = $pharmacies_surgeries[0]['pharmacy_surgery_id'];
								$this->session->pmr_pharmacy_surgery_id = $this->session->pharmacy_surgery_id;

								$is_default = $this->pmr->get_default_prescriber_organization_list($this->session->id, $unique_my_organizations[0]['organization_id']);

								if($is_default || $this->session->system_prescriber){
									$this->session->pmr_org_pharmacy = 'O|'.$unique_my_organizations[0]['organization_id'];
								} else {
									$this->session->pmr_org_pharmacy = 'P|'.$pharmacies_surgeries[0]['pharmacy_surgery_id'].'|'.$unique_my_organizations[0]['organization_id'];
								} // if($is_default)

								$my_role_in_pharmacy_surgery_data = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $pharmacies_surgeries[0]['pharmacy_surgery_id']); // Get User role in the pharmacy / surgery [ By pharmacy_surgery_id ]
								
								if($my_role_in_pharmacy_surgery_data['is_manager'] == 1){
									$this->session->is_manager = 1;
								} // if($my_role_in_pharmacy_surgery_data['is_staff'] == 1)

							} // if(count($pharmacies_surgeries) > 0)

						} // if(count($unique_my_organizations) == 1)

					} // if($user_org_superintendent || $this->session->is_owner && $this->session->is_owner == 1)

				} // if($belong_to_any_organization)

				if($this->session->is_owner && $chk_isvalid_user['no_of_logins'] == 0){
					//$this->session->set_flashdata('org_first_message', 'To get started click on Team Builder on the left hand menu and you can start adding your locations.');

					//If owner is logged in for the first time, redirect him to the teambuilder page instead.
					redirect(base_url().'organization/dashboard');
				}else
					redirect(base_url().'dashboard');

			}else{

				$get_user_details = $this->users->get_user_by_email($this->input->post('email_address'));
				$this->session->set_flashdata('err_message', 'Invalid Username or Password. Please try again.');
						
				redirect(base_url().'login');
			
			}//end if($chk_isvalid_user)
				
		}//end if($this->form_validation->run() == FALSE)

	}//end public function login_process()
	
	//Function activation() Email activation process
	public function activate_account(){

		$verify_account = $this->login->verify_email_account($this->input->get());
		
		if($verify_account){
			
			$get_user_details = $this->users->get_user_details($this->input->get('uid'));
			
			if($get_user_details['admin_verify_status'] == 0)
				$this->session->set_flashdata('ok_message', 'Your account is successfully verified and sent for admin approval. Please try to login after sometime.');
			else
				$this->session->set_flashdata('ok_message', 'Your account is successfully verified, please login with your details.');	
			redirect(base_url().'login');

		}else{
			$this->session->set_flashdata('err_message', 'We were not able to verify your account. Please contact site administrator for firther details.');
			redirect(base_url().'login');			
		}
		
	}//end activation()
	
	public function forgot_password(){
		
		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('forgot-password');
		
		//set title
		$page_title = $cms_data_arr['cms_page_arr']['page_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $cms_data_arr['cms_page_arr']['meta_description'],
			'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
		));
		
		$data['page_data'] = $cms_data_arr['cms_page_arr'];

		// Js file using for  Form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('https://www.google.com/recaptcha/api.js');
		// end Form  Validation
		
		
		// Form  Validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// End Form  Validation
		
		// Js Form  page form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form Validation
		
		$this->stencil->paint('login/forgot_password',$data);
		
	} //end forgot_password()

	//Function forgot_password_process(): Process and authenticate the forgot password
	public function forgot_password_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('login_btn')) redirect(base_url());

		// Captcha Validation
		if($this->input->post('g-recaptcha-response') == ''){
			 
			$this->session->set_flashdata('err_message', 'Please verify Captcha');
			redirect(base_url().'login/forgot-password');

		}//end if($this->input->post('g-recaptcha-response') == '')
		
		// PHP Validation
		$this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
				
		$user_exist_arr = $this->users->get_user_by_email($this->input->post('email_address'));
		

		if($this->form_validation->run() == FALSE){
			 
			 // PHP Error 
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'login/forgot-password');
			
		} else {
				
				if($user_exist_arr){

				//Sending Email to the User
				$send_new_password = $this->login->send_new_password($user_exist_arr);
			
				if($send_new_password){
					$this->session->set_flashdata('ok_message', 'An instruction of how to reset your password has been sent to the email address you have provided. Please check your email account for further details.');
					redirect(base_url().'login/forgot-password');
				
				}else{
				
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(base_url().'login/forgot-password');

			  }//end if($send_new_password)
			
		  }else{

			$this->session->set_flashdata('err_message', 'The email address you have entered do not exist in our database. Please try again, with the correct email address');
			redirect(base_url().'login/forgot-password');
			
		}//end if($chk_isvalid_user) 
		
	 } // Else  
		
	}//end forgot_password_process
	

	public function reset_password($reset_code){
		
		$verify_reset_code = $this->login->verify_reset_code($reset_code);
		
		if(!$verify_reset_code){

			$this->session->set_flashdata('err_message', 'The reset link is either invalid or have expired. Please try again.');
			redirect(base_url().'login/forgot-password');
			
		}else{

			$start_date = new DateTime($verify_reset_code['password_request_date']);
			$since_start = $start_date->diff(new DateTime(date('Y-m-d G:i:s')));
	
			$minutes = $since_start->days * 24 * 60;
			$minutes += $since_start->h * 60;
			$minutes += $since_start->i;
	
			if($minutes >= 24){

				$this->session->set_flashdata('err_message', 'The reset link is either invalid or have expired. Please try again.');
				redirect(base_url().'login/forgot-password');
				
			}//end if($minutes >= 24)

			
		}//end if(!$verify_reset_code)
		$data['reset_code'] = $reset_code;
		
		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('reset-password');
		
		//set title
		$page_title = $cms_data_arr['cms_page_arr']['page_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $cms_data_arr['cms_page_arr']['meta_description'],
			'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
		));
		
		$data['page_data'] = $cms_data_arr['cms_page_arr'];

		// Js file using for  Form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('https://www.google.com/recaptcha/api.js');
		// end Form  Validation
		
		
		// Form  Validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// End Form  Validation
		
		// Js Form  page form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form Validation
		
		$this->stencil->paint('login/reset_password',$data);
		
	} //end reset_password($reset_code)

	public function reset_password_process(){
		
		// Extract POST
		extract($this->input->post());
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('reset_pass_btn') && !$verify_code) redirect(base_url());

		// Captcha Validation
		if($this->input->post('g-recaptcha-response') == ''){
			 
			$this->session->set_flashdata('err_message', 'Please verify Captcha');
			redirect(base_url().'login/reset-password/'.$verify_code);

		}//end if($this->input->post('g-recaptcha-response') == '')
		
		// PHP Validation
		$this->form_validation->set_rules('new_password', 'Password', 'trim|required|min_length[8]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
		
		if($this->form_validation->run() == FALSE){
			 
			// PHP Error 
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'login/reset-password/'.$verify_code);
			
		} else {
			
			$decode = base64_decode(urldecode($verify_code));
			$split_decode = explode('|',$decode);
			
			$reset_password = $this->login->reset_password($split_decode[1], $this->input->post());

			if($reset_password){
			
				$this->session->set_flashdata('ok_message', 'Your password is successfully updated, You may login to your Hubnet account with your updated credentials.');
				redirect(base_url().'login');

			} else {
					
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect(base_url().'login/reset-password/'.$verify_code);
			
			} // End - if($send_new_password)

		} // end if($this->form_validation->run() == FALSE)
		
	} // End reset_password_process()

	//Function logout(): Process the logout operation
	public function logout(){

		// Delete cookie menu_item_number
		delete_cookie('menu_item_number');
		
		//Distroy All Sessions
		$this->session->sess_destroy();

		$this->session->set_flashdata('ok_message', 'You have successfully logged out.');
		redirect(base_url().'login');

	}//end logout	
	
}

/* End of file */