<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('page_mod','page');
		
		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		//load main template
		$this->stencil->layout('login_template'); //login_template
		
		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		//$this->stencil->slice('header_top');
		
		//Sets the Left Navigation
		//$this->stencil->slice('left_pane');

		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer_login');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		//$this->stencil->slice('footer_script');
	}

	public function index(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$this->stencil->js('https://www.google.com/recaptcha/api.js');
		
		$this->stencil->paint('login/login',$data);
		
	} //end index()

	//Function login_process(): Process and authenticate the login form
	public function login_process(){

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('login_btn')) redirect(base_url());

		// Captcha Validation
		if($this->input->post('g-recaptcha-response') == ''){
			 
			$this->session->set_flashdata('err_message', 'Please verify Captcha');
			redirect(base_url());

		}//end if($this->input->post('g-recaptcha-response') == '')
		
		// PHP Validation 
		$this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		$chk_isvalid_user = $this->login->validate_credentials($this->input->post('email_address'),$this->input->post('password'));
		
		if($this->form_validation->run() == FALSE){
			 
			 // PHP Error 
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'login');
			
		} else {
		
				if($chk_isvalid_user){
					
					$this->session->set_userdata($chk_isvalid_user);
					
					if($this->session->userdata('login_user_type')=='prescriber'){
						
						// if the user prescriber redirect to transaction pending
						redirect(base_url().'patient/list-all-patient-transactions');
					
					} else if($this->session->userdata('login_user_type')=='avicenna') {
					
						$this->session->buying_group_user_id = $this->session->admin_id;

						// if the user avicenna redirect to users
						redirect(base_url().'avicenna/users');
						
					} else {

						redirect(base_url().'dashboard');
					}
					
				}else{
		
					$this->session->set_flashdata('err_message', 'Invalid Username or Password. Please try again!');
					redirect(base_url().'login');
					
				}//end if($chk_isvalid_user) 
	        } // end else condition
		
	}//end public function login_process()

	//Function forgot_password(): Forgot Pasword View Page
	/*public function forgot_password(){
		
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$this->stencil->paint('login/forgot_password',$data);
		
	} //end forgot_password()
*/

	//Function logout(): Process the logout operation
	public function logout(){

		//Distroy All Sessions
		$this->session->sess_destroy();

		$this->session->set_flashdata('ok_message', 'You have successfully logged out.');
		redirect(base_url().'login');

	}//end logout	
		
	// Start Forgot Password
	public function forgot_password(){
		
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		//CMS DATA
		$cms_data_arr = $this->page->get_cms_page('forgot-password');
		
		//set title
	/*	$page_title = $cms_data_arr['cms_page_arr']['page_title'];
		$this->stencil->title($page_title);*/	
		
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
				
		$admin_arr = $this->login->get_admin_by_email($this->input->post('email_address'));

		if($this->form_validation->run() == FALSE){
			 
			 // PHP Error 
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'login/forgot-password');
			
		} else {
			
				if($admin_arr){

				//Sending Email to the User
				$send_new_password = $this->login->send_new_password($admin_arr);
			
				if($send_new_password){
					$this->session->set_flashdata('ok_message', 'New Password is sent to your Email Address. Please check your email address for your New Password');
					redirect(base_url().'login/forgot-password');
				
				}else{
				
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(base_url().'login/forgot-password');

			  }//end if($send_new_password)
			
		  }else{

			$this->session->set_flashdata('err_message', 'The Email Address do not exist in your database. Please try again, with the correct email address');
			redirect(base_url().'login/forgot-password');
			
		}//end if($chk_isvalid_user) 
		
	 } // Else  
		
	}//end forgot_password_process
	
}/* End of file */
