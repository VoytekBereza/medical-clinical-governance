<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Avicenna extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		// echo '<pre>';
		// print_r($_SESSION);
		// exit;
		// Load model purchase_mod.php
		$this->load->model('purchase_mod', 'purchase');
		$this->load->model('pgd_mod', 'pgd');
		$this->load->model('login_mod', 'login');
		$this->load->model('Common_mod', 'common');
		$this->load->model('cities_mod','cities');
		$this->load->model('users_mod','users');
		$this->load->model('avicenna_mod', 'avicenna');
		$this->load->model('Governance_mod','governance');
		$this->load->model('trainings_mod', 'training');
		$this->load->model('organization_mod', 'organization');
			
		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		//Login Check for the sections defined in here.
	 	$this->login->verify_is_buying_group_user_login();
		
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
		
	   // Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		
	}

	public function index(){
		
		//Page not on used at the moment
		//redirect(SURL.'login');
		echo 'This is Avicenna - index'; 

		$this->load->library('csvreader');
		
		$this->load->model('users_mod','users');
		
		$import_user = $this->users->import_user_record($this->input->post());
        $result =   $this->csvreader->parse_file('dummy-csv.csv');
		
		echo '<pre>';
		print_r($result);

		exit;
       
		
	} //end index()
	
	public function users(){

		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Set Bread Crumb
		//$this->breadcrumbcomponent->add('Trainings', base_url().'avicenna/index');
		$this->breadcrumbcomponent->add('Avicenna', 	base_url().'avicenna/users');
		$this->breadcrumbcomponent->add('List all users', 	base_url().'avicenna/users');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Add Javascripts
        // icheck
		
		  // icheck
		  
		// Fancy Box scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
        $this->stencil->js('icheck/icheck.min.js');
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom.js');
		// end Form CMS file Validation
		
		// Load CSS for
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
	       
        // Add pgd.js : Having scripts to assign and remove pgds
        $this->stencil->js('kod_scripts/pgd.js');
		
		/*//Common datatables function
		$this->stencil->js('kod_scripts/ajax_datatables.js');
					
		//Datatables
		$this->stencil->css('dataTables.bootstrap.min.css');
		$this->stencil->js('kod_scripts/datatable_2/media/js/jquery.dataTables.min.js');
		$this->stencil->js('kod_scripts/datatables.net-bs/js/dataTables.bootstrap.min.js');
		*/
		/* // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		

		
		$users = $this->avicenna->get_buying_group_user_list(1);
		foreach($users as $key => $user){

			$users[$key]['purchases'] = $this->purchase->get_purchased_items_split_by_user($user['id']);

		} // foreach($users as $key => $user)

		$data['users'] = $users;*/
		
		
		// Load view: list_all_trainings
		$this->stencil->paint('buying_group/users',$data);

	} // 
	
	// 	avicenna_user_list
	public function avicenna_user_list(){
		
		echo $this->avicenna->get_all_avicenna_ajax_call();
		
	}//end avicenna_user_list()
	
	
	// Start function: email_exists(): Check if the email already exist or not.
	public function email_exists(){
		
		extract($this->input->post()); 
		
		$response = '';
		
		if (!filter_var($email_check, FILTER_VALIDATE_EMAIL)) {
      		$response = "Invalid";
			
			echo json_encode($response);
    	} else {
		
			$result = $this->avicenna->verify_if_email_already_exist_user($email_check,$user_id);
			$response = array('exist' => $result);
			echo json_encode($response);
			
		}
		
	} // End - email_exists():

	public function assign_pgd(){
		
		if(!$this->input->post()) redirect(SURL.'dashboard');
		// Extract POST
		extract( $this->input->post() );

		$pgd_id = ($pgd_type == "ORAL" || $pgd_type == 'P_ORAL') ? '' : $pgd_id ;

		if($action == 'assign'){
			
			$status = $this->purchase->add_pgd_to_order($pgd_id, $user_id, $pgd_type);
			$message = ($status == 1) ? 'PGD added successfully.' : 'Oops! Something went wrong. Try again later.' ;

		} else if($action == 'unassign'){

			$status = $this->purchase->remove_pgd_from_order($pgd_id, $user_id, $pgd_type);
			$message = ($status == 1) ? 'PGD successfully removed.' : 'Oops! Something went wrong. Try again later.' ;

		} // if($action == 'assign')

		if($status == 1)
			$this->session->set_flashdata('ok_message', $message);
		else
			$this->session->set_flashdata('err_message', $message);
		// if($status == 1)

		redirect($_SERVER['HTTP_REFERER']);

	} // assign_pgd

	public function view_trainings($user_type, $user_id){

		// icheck
		$this->stencil->js('icheck/icheck.min.js');
		// Datatables
		$this->stencil->js('datatables/js/jquery.dataTables.js');
		$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
	
		$this->stencil->layout('ajax_pages'); //page_template

		$data['trainings'] = $this->training->get_all_trainings($user_type, 1);
		$data['user_id'] = $user_id;

		$data['purchases'] = $this->purchase->get_purchased_items_split_by_user($user_id);
		
		$this->stencil->paint('buying_group/trainings', $data);

	} // 

	// Start - public function assign_training() : Function to assign and unassign user trainings
	public function assign_training(){

		if(!$this->input->post()) redirect(SURL.'dashboard');

		// Extract POST
		extract( $this->input->post() );

		if($action == 'assign_training'){
			
			$status = $this->purchase->add_trainings_to_order($this->input->post('trainings'), $user_id);
			$message = ($status == 1) ? 'User training(s) was added successfully.' : 'Oops! Something went wrong. Try again later.' ;

		} else if($action == 'unassign_training'){

			$status = $this->purchase->remove_trainings_from_order($this->input->post('trainings'), $user_id);
			$message = ($status == 1) ? 'User training(s) successfully removed.' : 'Oops! Something went wrong. Try again later.' ;

		} // if($action == 'assign')

		if($status == 1)
			$this->session->set_flashdata('ok_message', $message);
		else
			$this->session->set_flashdata('err_message', $message);
		// if($status == 1)

		redirect($_SERVER['HTTP_REFERER']);

	} // public function assign_training()


		//conut record user_reporting_count
		public function user_reporting() {
			
			// Add BreadCrumb Components
			$this->breadcrumbcomponent->add('User Reporting', base_url().'avicenna/user-reporting-count');
			$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
			
			// Get All Active Trainings
			$list_all_active_trainings = $this->avicenna->get_all_active_trainings();
			$data['list_all_active_trainings'] = $list_all_active_trainings;
			
			// Get All Active PGDs
			$list_all_active_pgds = $this->avicenna->count_all_active_pgds();
			$data['list_all_active_pgds'] = $list_all_active_pgds;
			
			//set title
			$users_title = DEFAULT_TITLE;
			$this->stencil->title($users_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_DESCRIPTION,
				'meta_title' => DEFAULT_TITLE
			));
		
			$this->stencil->js('custom.js');
		
			// Count all PGDs Where buying group = 2 And product_type = 'PGD'
			$data['count_list_pgds_peads_travel'] = $this->avicenna->count_all_pgds_buying_group_id_2(10);
			
			$data['count_list_pgds_adult_travel'] = $this->avicenna->count_all_pgds_buying_group_id_2(11);
		
			$data['count_list_pgds_seasonal_flu_15'] = $this->avicenna->count_all_pgds_buying_group_id_2(15);
			
			$data['count_list_pgds_seasonal_flu_16'] = $this->avicenna->count_all_pgds_buying_group_id_2(16);
		
		    $this->stencil->paint('buying_group/count_users_reporting',$data);
		
		}// end user_reporting_count
		
		// Download CSV FILE
		 public function download_csv($product_id='', $product_type ='') {
		
			$this->load->helper('url');
			
			$file_contents = $this->avicenna->download_csv_file($product_id,$product_type); 
			
			//$file_contents = load_file_from_id($_GET['id']);
			$file_name = 'user_reports'.time().'.csv';
			
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			echo $file_contents;
		
		}//end download_csv
		
		// Download CSV FILE
		 public function download_csv_file_all_pgds($product_type ='') {
		
			$this->load->helper('url');
			
			$file_contents = $this->avicenna->download_csv_file_all_pgds($product_type); 
			
			//$file_contents = load_file_from_id($_GET['id']);
			$file_name = 'user_reports'.time().'.csv';
			
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			echo $file_contents;
		
		}//end download_csv
		
		// Download CSV FILE
		 public function download_csv_file_training($product_id='') {
		   
			$this->load->helper('url');
			
			$file_contents = $this->avicenna->download_csv_file_training($product_id); 
			
			//$file_contents = load_file_from_id($_GET['id']);
			$file_name = 'user_reports'.time().'.csv';
			
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			echo $file_contents;
		
		}//end download_csv
		
	// Function list avicenna pgd
	public function list_avicenna_pgd($product_type='', $product_id =''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Avicena PGDs', base_url().'avicenna/user-reporting');		
			
			// Get All Active PGDs
			$list_all_active_pgds = $this->avicenna->count_all_active_pgds();
			$data['list_all_active_pgds'] = $list_all_active_pgds;
			
		
			// Count all PGDs Where buying group = 2 And product_type = 'PGD'
			$data['count_list_pgds_peads_travel'] = $this->avicenna->count_all_pgds_buying_group_id_2(10);
			
			$data['count_list_pgds_adult_travel'] = $this->avicenna->count_all_pgds_buying_group_id_2(11);
		
			$data['count_list_pgds_seasonal_flu_15'] = $this->avicenna->count_all_pgds_buying_group_id_2(15);
			
			$data['count_list_pgds_seasonal_flu_16'] = $this->avicenna->count_all_pgds_buying_group_id_2(16);
			
			$data['count_list_pgds_seasonal_flu_12'] = $this->avicenna->count_all_pgds_buying_group_id_2(12);
			
			$data['count_list_pgds_seasonal_flu_19'] = $this->avicenna->count_all_pgds_buying_group_id_2(19);
			
		
			// Bread crumb output
			$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
			
			$data['list_avicena_pgd'] = $this->avicenna->list_avicena_pgds($product_type,$product_id); 
			//print_this($data['list_avicena_pgd']); exit;
			
			$data['product_type'] = $product_type; 
			$data['product_id'] = $product_id; 
			
			//echo count($data['list_avicena_pgd']); exit;
			
			 // Datatables
			$this->stencil->js('datatables/js/jquery.dataTables.js');
			$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
	
			// Add pgd.js : Having scripts to assign and remove pgds
			$this->stencil->js('kod_scripts/pgd.js');

        // Fancy Box scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		$this->stencil->paint('buying_group/list_avicena_pgd',$data);
		
	}//end list_avicenna_pgd()
	
	
		// 	avicenna_pgd_user_list
	public function avicenna_pgd_user_list($product_id =''){
		
		echo $this->avicenna->get_all_avicenna_pgd_ajax_call($product_id);
		
	}//end avicenna_pgd_user_list()
	
	// Function  list_avicenna_training
	public function list_avicenna_training($product_id =''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Avicena Training', base_url().'avicenna/user-reporting');
		
	   // Get All Active Trainings
		$list_all_active_trainings = $this->avicenna->get_all_active_trainings();
		$data['list_all_active_trainings'] = $list_all_active_trainings;
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['list_avicena_training'] = $this->avicenna->list_avicena_trainging($product_id); 
		
		$data['product_id'] = $product_id; 
				
		 // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		$this->stencil->paint('buying_group/list_avicena_training',$data);
		
	}//end list_avicenna_training()
	
	
	// start avicenna user public function add_edit_avicenna_user($user_id='')
	public function add_edit_avicenna_user($user_id=''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Avicenna List all users', 	base_url().'avicenna/users');
		$this->breadcrumbcomponent->add('Add Edit Avicenna User', 	base_url().'avicenna/add-edit-avicenna-user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		//if($user_id != '') {


		//Active Organization Country List
		$country_active_arr = $this->common->get_active_countries();
		$data['country_active_arr'] = $country_active_arr;
			
			// Get All Old Users 
			$user_list = $this->avicenna->get_user_list($user_id);
			$data['user_details'] = $user_list;
			
			// Get All Old Users Type 
			$usertype_active_arr = $this->avicenna->get_user_type();
			$data['usertype_active_arr'] = $usertype_active_arr;
			
				
				//Active Locum Cities List
			$cities_active_arr = $this->users->get_active_cities();
			$data['cities_active_arr'] = $cities_active_arr;
	
			//Active Organization Country List
			$country_active_arr = $this->users->get_active_countries();
			$data['country_active_arr'] = $country_active_arr;
	
			//Active Buying Group List
			$buyinggroup_active_arr = $this->users->get_active_buyinggroups();
			$data['buyinggroup_active_arr'] = $buyinggroup_active_arr;
			
		//}
		//echo '<pre>';
		//print_r($old_user_list); exit;
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation.js');
		$this->stencil->js('kod_scripts/form_validation2/bootstrap_validator/dist/formValidation.min.js');
		$this->stencil->js('kod_scripts/form_validation2/bootstrap_validator/dist/bootstrap.min.js');
		// end CMS file Validation
		
		$this->stencil->paint('buying_group/add_edit_avicenna_user',$data);
		
	} // end public function add_edit_avicenna_user()
	
	// start public function avicenna_users_process()
	public function avicenna_users_process(){
		
		if(!$this->input->post() && !$this->input->post('old_user_btn')) redirect(base_url());
		
		 extract($this->input->post()); 
		 $postValue = $this->input->post(); 
		 
		 
	    // PHP Validation
		if($user_id ==''){
			$this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
	  	}
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		
			$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|max_length[11]');
		    $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
			
			if($user_id ==''){	
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[conf_password]');
				$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'trim|required');
				
			}else{
				if(filter_string($password) != ''){
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[conf_password]');
					$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'trim|required');
				}
			}
	 	
		if($postValue['user_type']=="1"){
	 
			$this->form_validation->set_rules('registration_no', 'GMC Number', 'required');
		
		 } else if($postValue['user_type']=="2") {
		
			$this->form_validation->set_rules('registration_no', 'GPhC Number', 'required');
	 
		 } else if($postValue['user_type']=="3") {
		
			$this->form_validation->set_rules('registration_no', 'NMC Number', 'required');
		}
		
		if($this->form_validation->run() == FALSE){
			
			// session set form data in fields
			$this->session->set_flashdata($this->input->post());
			// PHP Error
			$this->session->set_flashdata('err_message', validation_errors());
			
			if($user_id ==''){
				redirect(base_url().'avicenna/add-edit-avicenna-user');
			} else {
				redirect(base_url().'avicenna/add-edit-avicenna-user/'.$user_id);
			}
			
		} else {
			
			$verify_if_email_already = $this->avicenna->verify_if_email_already_exist_user($this->input->post('email_address'),$user_id);
			
			if($verify_if_email_already){
				
				//Email Already exist
				$this->session->set_flashdata('err_message', 'The email address you are trying to register already exist in our database. Please contact site administrator for further details.');
				
				if($user_id ==''){
					redirect(base_url().'avicenna/add-edit-avicenna-user');
				} else {
					redirect(base_url().'avicenna/add-edit-avicenna-user/'.$user_id);
				}
				
			} else {
				
					$user_register = $this->avicenna->add_edit_avicenna_user($this->input->post());
					
					if($user_register && $user_id=='') {
						
						$this->session->set_flashdata('ok_message', 'User added into database succesfully.');
						redirect(base_url().'avicenna/users');
					}else if($user_register && $user_id!='') {
						
						$this->session->set_flashdata('ok_message', 'User updated succesfully.');
						redirect(base_url().'avicenna/users');
					} else {
						$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
						redirect(base_url().'avicenna/users');
					}

				
					redirect(base_url().'avicenna/users');
					
			}//end if($verify_if_email_already)			
		}
		
	}// end public function avicenna_users_process()
	
	// assing unassing users
	public function assign_unassign_users($name='',$users_id){

		if($users_id!="")
			{
				$assign_unassign_user = $this->avicenna->assign_unassign($name,$users_id);
				
				if($assign_unassign_user == '1')
				{
					$this->session->set_flashdata('ok_message', 'User status change successfully.');
					redirect(SURL.'avicenna/users');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'avicenna/users');
					
				}//end if if($assign_unassign_users != '')
				
			}//end if($users_id!="")
			
	}//end function assign_unassign_users($name='',$users_id)

	// show all pharmacies   using list_all_ajax_pharmacy function
	public function pharmacy_list(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Pharmacy Listing', base_url().'organization/list-all-ajax-pharmacy');
	
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		  // icheck
		  
		// Fancy Box scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
        $this->stencil->js('icheck/icheck.min.js');
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom.js');
		// end Form CMS file Validation
		
		// Load CSS for
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
	       
		
		$this->stencil->paint('buying_group/list_all_pharmacy_ajax_call',$data);
		
	} // end pharmacy_list
	
	// 	pharmacy_ajax_list
	public function pharmacy_ajax_list(){
		
		echo $this->avicenna->get_all_pharmacy_ajax_call();
		
	}//end pharmacy_ajax_list()
	
	// assing unassing pharamcy
	public function assign_unassign_website($package,$pharmacy_id){

		if($pharmacy_id!=""){
			
			$assign_unassign_website = $this->organization->assign_unassign_website($package,$pharmacy_id,'1');
			
			if($assign_unassign_website){
				$this->session->set_flashdata('ok_message', 'Pharmacy setting successfully updated');
				redirect($_SERVER['HTTP_REFERER']);
				
			} else {
				
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect($_SERVER['HTTP_REFERER']);
				
			}//end if if($assign_unassign_users != '')
			
		}//end if($pharmacy_id!="")
			
	}//end function assign_unassign_website($name='',$pharmacy_id)
	
	// assing unassing pharamcy
	public function assign_unassign_pharmacy($name='',$pharmacy_id){

		if($pharmacy_id!=""){
			
			$assign_unassign_pharmacy = $this->organization->assign_unassign_pharmacy($name,$pharmacy_id);
			
			if($assign_unassign_pharmacy == '1'){
				$this->session->set_flashdata('ok_message', 'Pharmacy setting successfully updated');
				redirect($_SERVER['HTTP_REFERER']);
				
			} else {
				
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect($_SERVER['HTTP_REFERER']);
				
			}//end if if($assign_unassign_users != '')
			
		}//end if($pharmacy_id!="")
			
	}//end function assign_unassign_pharmacy($name='',$pharmacy_id)
	
	//conut record user_reporting_count
	public function all_user_reporting() {
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('User Reporting', base_url().'avicenna/user-reporting-count');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Get All Active Trainings
		//$list_all_active_trainings = $this->training->get_all_active_trainings();
		//$data['list_all_active_trainings'] = $list_all_active_trainings;
		
		// Get All Active PGDs
		$list_all_active_avicenna_pgds = $this->avicenna->count_all_active_pgds();
		$data['list_all_active_pgds'] = $list_all_active_avicenna_pgds;
		
		//  PGDs Active List
		$list_all_active_pdgs = $this->pgd->get_all_active_pdgs();
		$data['list_all_active_pdgs'] = $list_all_active_pdgs;

		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
	
		// Count all peads travel
		//$data['count_list_pgds_peads_travel'] = $this->avicenna->count_all_pgds_peads_travel();
	
	   $this->stencil->paint('buying_group/all_count_users_reporting',$data);
	
	}// end user_reporting_count

	// Download CSV FILE
	 public function download_single_avicenna_pgd_csv($product_id='', $product_type ='') {
	
		$this->load->helper('url');
		
		$file_contents = $this->avicenna->download_single_avicenna_pgd_csv($product_id,$product_type); 
		
		//$file_contents = load_file_from_id($_GET['id']);
		$file_name = 'user_reports'.time().'.csv';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $file_contents;
	
	}//end download_single_avicenna_pgd_csv

			// Download CSV FILE
	 public function download_csv_file_all_avicenna_pgds($product_type =''){
	
		$this->load->helper('url');
		
		$file_contents = $this->avicenna->download_csv_file_all_avicenna_pgds($product_type); 
		
		//$file_contents = load_file_from_id($_GET['id']);
		$file_name = 'user_reports'.time().'.csv';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $file_contents;
	
	}//end download_csv_file_all_avicenna_pgds($product_type ='')
	
	public function renew_subscription($pharmacy_id){

		if($pharmacy_id!=""){
			
			$td_renew_pharmacy_subscription = td_renew_pharmacy_subscription($pharmacy_id);
			
			if($td_renew_pharmacy_subscription){
				$renew_website = $this->organization->renew_website_subscription($pharmacy_id);

				$this->session->set_flashdata('ok_message', 'Renewal request is sent to site admin for further proceeding.');
				redirect($_SERVER['HTTP_REFERER']);
				
			}else{

				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect($_SERVER['HTTP_REFERER']);
				
			}//end if($td_renew_pharmacy_subscription)
			
			
		}//end if($pharmacy_id!="")
			
	}//end function renew_subscription($pharmacy_id)

	public function view_avicenna_user_pgds($user_id=''){

		if(!$user_id) exit('Provide user ID');

		// echo 'User ID => '.$user_id.'<br /><br />';

		$this->db->dbprefix('kod_user_order_details');
		
		$this->db->where('kod_user_order_details.user_id', $user_id);
		$this->db->where('kod_user_order_details.product_type', 'PGD');
		$this->db->where('kod_user_order_details.expiry_date !=', '0000-00-00');

		$this->db->distinct('kod_user_order_details.product_id');
		$this->db->order_by('id', 'DESC');

		$user_order_details = $this->db->get('kod_user_order_details')->result_array();

		// print_this($user_order_details); exit;

		$this->db->dbprefix('kod_users');
		$this->db->where('id', $user_id);
		$user_details = $this->db->get('kod_users')->row_array();

		echo '<h3>'.filter_string($user_details['first_name']).' '.filter_string($user_details['last_name']).'</h3>';
		echo "<p> Authenticated PGD's List </p>";

		if($user_order_details && $user_details['buying_group_id'] == '1'){

			$html = '<table class="table table-hover table-striped">';

			$html .= '<thead> <tr> <th align="left"> PGD Name </th> <th align="left"> Expiry Date </th> </tr> </thead>';

			$html .= '<tbody>';

			foreach($user_order_details as $order_details){

				// Verify if expired
				if( $order_details['expiry_date'] < date('Y-m-d') ){

					$is_expired = true;

				} else {

					$is_expired = false;

				} // if => expired

				$product_id = $order_details['product_id'];

				$this->db->dbprefix('kod_package_pgds');
				$this->db->where('id', $product_id);
				$package_details = $this->db->get('kod_package_pgds')->row_array();

				$expiry_date = ($order_details['expiry_date'] && $order_details['expiry_date'] != '0000-00-00') ? date('d/m/Y', strtotime($order_details['expiry_date'])) : '' ;

				$html .= '<tr>';

				$html .= '<td align="left">'.filter_string($package_details['pgd_name']).'</td>';

				if($is_expired){
					$html .= '<td align="left">'.$expiry_date.' <br /> <small style="color: #f00;"> Expired </small> </td>';
				} else {
					$html .= '<td align="left">'.$expiry_date.'</td>';
				} // if expired

				$html .= '</tr>';

				// print_this($order_details);

			} // foreach

			$html .= '</tbody>';

			$html .= '</table>';

			echo $html;

		} else {

			$html = '<table class="table table-hover table-striped">';

			$html .= '<thead> <tr> <th align="left" width="70%"> PGD Name </th> <th align="left" width="30%"> Expiry Date </th> </tr> </thead>';

			$html .= '<tbody>';

			$html .= '<tr> <td colspan="2" align="center" style="color: #f00; padding: 20px;"> No record found </td> </tr>';

			$html .= '</tbody>';

			$html .= '</table>';

			echo $html;

		} // if

	}

} /* End of file Ci_Controller (Trainings) */