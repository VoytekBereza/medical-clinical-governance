<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('Settings_mod','settings');
		
		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');

		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		//load main template
		$this->stencil->layout('page_template'); //page_template
		
		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		$this->stencil->slice('header_top');
		
		// Contents header (For Bread Crumb and flash messages)
		$this->stencil->slice('contents_header');
		
		//Sets the Left Navigation
		$this->stencil->slice('left_nav');

		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		$this->stencil->slice('footer_script');
		
		// Js form validation scripts
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');
	}

	public function index(){
		
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()
	
	//Function change_password(): Change password view mode
	public function change_password(){
		
		//Login Check
		if($this->session->admin_id == 1)
		 	$this->login->verify_is_user_login();

		if($this->session->admin_id == 2)
		 	$this->login->verify_is_prescriber_loggedin();

		if($this->session->admin_id == 3)
		 	$this->login->verify_is_buying_group_user_login();
			
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Admin Change Password', base_url().'login/change-password');

		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		$this->stencil->js('kod_scripts/custom.js');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('login/change_password',$data);
		
	} //end forgot_password()


	//Function change_password_process(): Change Pasword Process
	public function change_password_process(){

		//Login Check
		if($this->session->admin_id == 1)
		 	$this->login->verify_is_user_login();

		if($this->session->admin_id == 2)
		 	$this->login->verify_is_prescriber_loggedin();

		if($this->session->admin_id == 3)
		 	$this->login->verify_is_buying_group_user_login();

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('change_pass_btn')) redirect(base_url());		
		
		
		if($this->input->post('new_password')!=$this->input->post('confirm_password')){
			
			$this->session->set_flashdata('err_message', 'Password does not match!');
			redirect(SURL.'settings/change-password');
			exit;
			
		}
		
		// Chnage Password function login mode call to change password
		$is_password_changed = $this->login->change_password($this->input->post(),$this->session->userdata('admin_id'));

		if($is_password_changed){
			
			$this->session->set_flashdata('ok_message', 'Password successfully updated. Thank you!');
			redirect(SURL.'settings/change-password');
			
		}else{

			$this->session->set_flashdata('err_message', 'Change Password Failed, Please Try Again!');
			redirect(SURL.'settings/change-password');
			
		}//end if($chk_isvalid_user) 
		
	}//end public function change_password_process()
	
	// Start - list_all_settings():
	public function list_all_settings($settings_id = ''){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Pull all categories from db
		$data['list_settings'] = $this->settings->get_all_settings();
		
			// Set Bread Crumb
		$this->breadcrumbcomponent->add('Add new Settings', base_url().'settings/list-all-settings');
		
		if($settings_id != ''){ // If update action requested
			$data['settings'] = $this->settings->get_settings($settings_id);
			$data['form_action'] = 'update';
			
			// Bread crumb Update Settings
			$this->breadcrumbcomponent->add('Update Settings', base_url().'settings/list-all-settings');
			
		} else {
			$data['form_action'] = 'add';
		}
		
		// icheck
        $this->stencil->js('icheck/icheck.min.js');

        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
				// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: settings
		$this->stencil->paint('settings/list_all_settings', $data);
		
	} // End - list_all_settings():
	
	// Start - add_update_settings():
	public function add_update_settings(){
		
		$success = $this->settings->add_update_settings($this->input->post());
		$action = $this->input->post('action');
		if($success){
			if($action == 'add')
				$this->session->set_flashdata('ok_message_settings', 'Settings has been successfully added.');
			else
				$this->session->set_flashdata('ok_message_settings', 'Settings has been successfully updated.');
			redirect(SURL.'settings/list-all-settings');
		} else {
			$this->session->set_flashdata('err_message_settings', 'Oops! Something went wrong.');
			redirect(SURL.'settings/list-all-settings');
		}
		
	} // End - add_update_settings():
	
	// Start setting_name_exists
	public function setting_name_exists(){
		
		$result = $this->settings->get_setting_name($this->input->post('key'));
		$response = array('exist' => $result);
		echo json_encode($response);
		
	} // End - setting_name_exists():
	
	/////////////////////////////////
	// Start User Type Settings Section
	
	// Start - user_type_dashboar_videos():
	public function user_type_dashboar_videos(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Get all dashboard videos
		$data['dashboard_videos'] = $this->settings->get_all_user_type_dashboar_videos();
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Dashboard Videos', base_url().'settings/user-type-dashboard-videos');
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('settings/user_type_dashboard_videos', $data);
	}
	// End - user_type_dashboar_videos():
	
	// Start - add_update_dashboard_videos():
	public function add_update_dashboard_videos(){
		
		// Update call to model
		$updated = $this->settings->update_dashboard_videos($this->input->post());
		
		if($updated){ // On success
			
			$this->session->set_flashdata('ok_message', 'Dashboard video changes saved successfully.');
			redirect(SURL.'settings/user_type_dashboar_videos');
			
		} else { // On failure
			
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong, please try again later.');
			redirect(SURL.'settings/user_type_dashboar_videos');
		}
		
	} // End - add_update_dashboard_videos():
	
	// Start  edit_profile
	public function edit_profile () {

		//Login Check
		if($this->session->admin_id == 1)
		 	$this->login->verify_is_user_login();

		if($this->session->admin_id == 2)
		 	$this->login->verify_is_prescriber_loggedin();

		if($this->session->admin_id == 3)
		 	$this->login->verify_is_buying_group_user_login();
		
		$data['admin_edit_profile'] = $this->settings->edit_admin_profile($this->session->userdata('admin_id'));
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Admin Edit Profile', base_url().'settings/edit-profile');
	
		if(!empty($data['admin_edit_profile']))
		{
		  $this->session->set_userdata($data['admin_edit_profile']);
		}
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		//$chk_isvalid_user = $this->login->validate_credentials($this->input->post('email_address'),$this->input->post('password'));
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
	    // Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('settings/edit_profile',$data);
		
	}// end edit-profile
	
	// Function edit_profile_process
	public function edit_profile_process() {
		
		//Login Check
		if($this->session->admin_id == 1)
		 	$this->login->verify_is_user_login();

		if($this->session->admin_id == 2)
		 	$this->login->verify_is_prescriber_loggedin();

		if($this->session->admin_id == 3)
		 	$this->login->verify_is_buying_group_user_login();
	
	    $is_profile_changed = $this->settings->update_profile_admin($this->session->userdata('admin_id'),$this->input->post());
		
		if($is_profile_changed){
				$this->session->set_flashdata('ok_message', 'Profile has been successfully updated.');
			    redirect(SURL.'settings/edit-profile');
		} else {
			    $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			    redirect(SURL.'settings/edit-profile');
		}
	}// end edit_profile_process
	
	// Start - list_all_notifications():
	public function list_all_notifications(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Get all notifications from db
		$data['list_all_notifications'] = $this->settings->get_all_notifications();
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Notifications Listings', base_url().'settings/list-all-notifications');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: settings
		$this->stencil->paint('settings/list_all_notifications', $data);
		
	} // End - list_all_notifications():

	// Start - media():
	public function media(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Get all notifications from db
		//$data['media_listing'] = $this->media->media_listing();
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Media', base_url().'settings/list-all-notifications');
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: settings
		$this->stencil->paint('media/media', $data);
		
	} // End - list_all_notifications():
	
	public function upload_media_process(){
		
		if(!$this->input->post()) redirect(SURL);
		
		$media_location  = '.././assets/media/';
		$file_name = $_FILES['upload_media']['name'];
		$destination_path = $media_location.$file_name;
		
		if(file_exists($destination_path)){
			
			$this->session->set_flashdata('err_message', 'File with the same name ('.$file_name.') already exist, please use another one.');
			redirect(SURL.'settings/media');	

		}else{

			$upload_media = $this->settings->upload_media($this->input->post());
			
			if($upload_media){
				
				$this->session->set_flashdata('ok_message', 'Media Upload Successfully');
				
			}else{
				$this->session->set_flashdata('err_message', 'Media uploaing Failed');
			}//end if($upload_media)
			
			redirect(SURL.'settings/media');		
			
		}
		
	}//end upload_media_process()
	
	
	
}/* End of file */
