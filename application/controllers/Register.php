<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('common_mod','common');
		$this->load->model('usertype_mod','usertype');
		$this->load->model('cities_mod','cities');
		$this->load->model('country_mod','country');
		$this->load->model('buyinggroup_mod','buyinggroup');
		$this->load->model('register_mod','register');
		$this->load->model('cms_mod', 'cms');
		$this->load->model('invitations_mod','invitations');
		$this->load->model('governance_mod','governance');
		
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
		
		// Js form validation scripts
		// $this->stencil->js('kod_scripts/jquery.validate.js');
		// $this->stencil->js('kod_scripts/custom_validate.js');
		
	}

	public function index(){
		
		if($this->session->id) redirect(SURL.'dashboard');
		
		if($this->input->get('ref')){
			//If User have received an invitation via email to join Voyager.
			$inv_id = base64_decode(urldecode($this->input->get('ref')));
			$get_invitation_details = $this->invitations->get_invitation_details($inv_id);
			$data['get_invitation_details'] = $get_invitation_details;
			
		}//end if($this->input->get('ref'))
		
		//Active User Type List
		$usertype_active_arr = $this->usertype->get_active_usertypes();
		$data['usertype_active_arr'] = $usertype_active_arr;

		//Active Locum Cities List
		$cities_active_arr = $this->cities->get_active_cities();
		$data['cities_active_arr'] = $cities_active_arr;

		//Active Organization Country List
		$country_active_arr = $this->country->get_active_countries();
		$data['country_active_arr'] = $country_active_arr;

		//Active Buying Group List
		$buyinggroup_active_arr = $this->buyinggroup->get_active_buyinggroups();
		$data['buyinggroup_active_arr'] = $buyinggroup_active_arr;


		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('register');
		
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
		
		// Add Additional CSS and JS 
		$this->stencil->css('chosen.css');
		$this->stencil->js('chosen.jquery.js');
		$this->stencil->js('https://www.google.com/recaptcha/api.js');
		
		
		// Js file using for  Form validation
		//$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Form  Validation
		
		// Js Form  page form validation
		//$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form Validation

		
			
		//$this->stencil->js('kod_scripts/custom_validate.js');
		//$this->stencil->js('org_dashboard.js');

		$this->stencil->js('registration.js');
		
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		
			
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation_2.min.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');
		// end CMS file Validation
		
		
		$this->stencil->paint('register/register',$data);
		
	} //end index()

	public function register_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('register')) redirect(base_url());

		// Captcha Validation
		if($this->input->post('g-recaptcha-response') == ''){
			 
			// session set form data in fields
			$this->session->set_flashdata($this->input->post());
		    // Set the required fields
			$this->session->set_flashdata('err_message', 'Please verify Captcha');
			redirect(base_url().'register');

		}//end if($this->input->post('g-recaptcha-response') == '')
		
		$postValue = $this->input->post(); 
		
		// PHP Validation
		$this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[conf_password]');
		$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('terms', 'Terms and Condition', 'trim|required');
	 
	 	
		if($postValue['user_type']=="1"){
	 
			$this->form_validation->set_rules('registration_no', 'GMC Number', 'required');
		
		 } else if($postValue['user_type']=="2") {
		
			$this->form_validation->set_rules('registration_no', 'GPhC Number', 'required');
	 
		 } else if($postValue['user_type']=="3") {
		
			$this->form_validation->set_rules('registration_no', 'NMC Number', 'required');
		}
		
		if($postValue['is_owner']=="1"){
		 
			$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
			$this->form_validation->set_rules('org_address', 'Address', 'trim|required');
			$this->form_validation->set_rules('org_postcode', 'Post Code', 'trim|required');
			$this->form_validation->set_rules('org_contact', 'Contact Number', 'trim|required');
			$this->form_validation->set_rules('org_country', 'Select Country', 'trim|required');
			// $this->form_validation->set_rules('org_buying_group', 'Select Buy Group', 'trim|required');
		} else {
			//$this->form_validation->set_rules('org_buying_group', 'Select Buy Group', 'trim|required');
		}
			
		if($this->form_validation->run() == FALSE){
			
			// session set form data in fields
			$this->session->set_flashdata($this->input->post());
			// PHP Error
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'register');
			
		} else {
			
			if($postValue['is_owner']=="1"){

				$verify_if_organization_exist_by_name = $this->register->verify_if_organization_exist_by_name($postValue['company_name']);
				
				if($verify_if_organization_exist_by_name){
					
					$this->session->set_flashdata($this->input->post());
					
					$this->session->set_flashdata('err_message', 'Please contact the owner or superintendent of this organisation for access.');
					redirect(base_url().'register');
					
				}//end if($verify_if_organization_exist_by_name)
				
			}//end if($is_owner == 1)

			$verify_if_email_already = $this->register->verify_if_email_already_exist($this->input->post('email_address'));
			
			if($verify_if_email_already){
				
				//Email Already exist
				$this->session->set_flashdata('err_message', 'The email address you are trying to register already exist in our database. Please contact site administrator for further details.');
				redirect(base_url().'register');
				
			} else {
				
					$user_register = $this->register->add_new_user($this->input->post());

					//$this->session->set_flashdata('ok_message', 'Thanks for registering with us!<br />Your account has now been successfully created. All you need to do now is check your email account for a verification email we sent you, click the link inside and you will be prompted to log in.');
					redirect(base_url().'thankyou');
					
			}//end if($verify_if_email_already)			
		}
		
	}//end public function register_process()
	
	// Start function: email_exists(): Check if the email already exist or not.
	public function email_exists(){
		
		$result = $this->register->verify_if_email_already_exist($this->input->post('key'));
		$response = array('exist' => $result);
		echo json_encode($response);
		
	} // End - email_exists():

}

/* End of file */