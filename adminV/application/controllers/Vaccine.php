<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vaccine extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('medicine_mod','medicine');
		$this->load->model('vaccine_mod','vaccine');

		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		//Navigational Tree for Left Pan
		//$this->nav_tree = $this->pgd->get_pgd_navigation_list('1');

		//Login Check for the sections defined in here.
	 	$this->login->verify_is_user_login();
		
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
		
			// Js file using for Users  validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Users file Validation
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form CMS file Validation
	}

	public function index(){
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()

	/***********************************************************
	* Vaccine  Add Update Listing And Delete Function
	***********************************************************/
	
	// Function add_update_vaccine
	public function add_update_vaccine($vaccine_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));

		// Use for CK EDITOR
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		if($vaccine_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Vaccine', base_url().'vaccine/add-update-vaccine');
			
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Vaccine', base_url().'vaccine/add-update-vaccine');
			
			$get_vaccine_details = $this->vaccine->get_vaccine_details($vaccine_id);			
			$data['get_vaccine_details'] = $get_vaccine_details;
			
		}//end if($$vaccine_id == '')
		
		// Js file using for form validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end form file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// load view add_update_vaccine
		$this->stencil->paint('vaccine/add_update_vaccine',$data);
		
	}//end add_update_vaccine()
	
	// Function  add_update_vaccine_process
	public function add_update_vaccine_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_vaccine_btn')) redirect(base_url());
		
		 // Call add_update_vaccine function
		 $add_update_vaccine = $this->vaccine->add_update_vaccine($this->input->post()); 
		
		if($add_update_vaccine){
			
			$vaccine_id = $this->input->post('vaccine_id');
			
			if($vaccine_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Vaccine added successfully.');
				redirect(SURL.'vaccine/list-all-vaccine');
				
			}else{

				$referrer_link  = $vaccine_id;
				$this->session->set_flashdata('ok_message', 'Vaccine updated successfully.');
				redirect(SURL.'vaccine/add-update-vaccine/'.$referrer_link);
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $vaccine_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'vaccine/add-update-vaccin/'.$referrer_link);
		}

	}//end add_update_vaccine_process()
	
	//Function  list_all_vaccine 
	public function list_all_vaccine(){		
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Add Javascripts
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Vaccines Listing', base_url().'vaccine/list-all-vaccine');

        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all vaccine
		$data['list_all_vaccine'] = $this->vaccine->get_all_vaccine();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_medicine_category
		$this->stencil->paint('vaccine/list_all_vaccine',$data);
		
	} // End - list_all_vaccine():
	
	/*****************************************************
	* Vaccine End  Add Update Listing Function
	*****************************************************/
	
	/***********************************************************
	* Vaccine RAF Add Update Listing And Delete Function
	***********************************************************/
	
	// Function add_update_vaccine_raf
	public function add_update_vaccine_raf($vaccine_id,$vaccine_raf_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$vaccine_id = $vaccine_id;
		$vaccine_raf_id = $vaccine_raf_id;

		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		
		// Set Bread Crumb
		//$this->breadcrumbcomponent->add('Vaccines Listing', base_url().'vaccine/list-all-vaccine');
				
		if($vaccine_id==2){
			
		   $this->breadcrumbcomponent->add('Travel RAF Vaccines Listing', base_url().'vaccine/list-all-vaccine-raf/'.$vaccine_id);
		
		} else {
			  $this->breadcrumbcomponent->add('Flu RAF Vaccines Listing', base_url().'vaccine/list-all-vaccine-raf/'.$vaccine_id);
		}
		
		if($vaccine_raf_id == '') {
			
			if($vaccine_id == '2'){  $vaccine_type = 'Travel'; } else { $vaccine_type = 'Flu';}
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New '.$vaccine_type.' RAF Vaccine', base_url().'vaccine/add-update-vaccine-raf');
			
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update '.$vaccine_type.' RAF Vaccine', base_url().'vaccine/add-update-vaccine-raf');
			
			$get_vaccine_raf_details = $this->vaccine->get_vaccine_raf_details($vaccine_raf_id);			
			$data['get_vaccine_raf_details'] = $get_vaccine_raf_details;
			
		}//end if($$vaccine_id == '')
		
		// Medicine Raf Labels List	
		$medicine_raf_labels_list = $this->medicine->medicine_raf_labels_list();
	    $data['medicine_raf_labels_list'] = $medicine_raf_labels_list;

		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('vaccine/add_update_vaccine_raf',$data);
		
	}//end add_update_vaccine_raf()
	
	// Function  add_update_vaccine_raf_process
	public function add_update_vaccine_raf_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_vaccine_raf_btn')) redirect(base_url());
		
		// Add update Vaccine Raf
		 $add_update_vaccine_raf = $this->vaccine->add_update_vaccine_raf($this->input->post()); 
		
		 $vaccine_raf_id = $this->input->post('vaccine_raf_id');
		 $vaccine_id = $this->input->post('vaccine_id');
		 
		// if add or update succuess
		if($add_update_vaccine_raf){
			
			if($vaccine_raf_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Vaccine added successfully.');
				redirect(SURL.'vaccine/list-all-vaccine-raf/'.$vaccine_id);
				
			}else{

				$referrer_link  = $vaccine_raf_id;
				$this->session->set_flashdata('ok_message', 'Vaccine updated successfully.');
				redirect(SURL.'vaccine/add-update-vaccine-raf/'.$vaccine_id.'/'.$referrer_link);
				
			}//end if
			
		}else{
			
			$referrer_link  = $vaccine_raf_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'vaccine/add-update-vaccin-raf/'.$vaccine_id.'/'.$referrer_link);
		}
			
	}//end add_update_vaccine_raf_process()
	
	//Function  list_all_vaccine_raf 
	public function list_all_vaccine_raf($vaccine_id = ''){		
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		if($vaccine_id==2){
			
		   $this->breadcrumbcomponent->add('Travel RAF Vaccines Listing', base_url().'vaccine/list-all-vaccine-raf/'.$vaccine_id);
		
		} else {
			  $this->breadcrumbcomponent->add('Flu RAF Vaccines Listing', base_url().'vaccine/list-all-vaccine-raf/'.$vaccine_id);
		}
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		$this->stencil->js('kod_scripts/custom.js');
		
		// Get all medicine_raf_labels_list
		$medicine_raf_labels_list = $this->medicine->medicine_raf_labels_list();
	    $data['medicine_raf_labels_list'] = $medicine_raf_labels_list;
		
		// Get all vaccine
		$data['list_all_vaccine_raf'] = $this->vaccine->get_all_vaccine_raf($vaccine_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_medicine_category
		$this->stencil->paint('vaccine/list_all_vaccine_raf',$data);
		
	} // End - list_all_vaccine_raf():
	
	// Function delete_vaccine_raf
	public function delete_vaccine_raf($vaccine_id,$vaccine_raf_id){
		
			if($vaccine_raf_id!="")
			{
				// Delete vaccince raf
				$vaccine_raf_success = $this->vaccine->delete_vaccine_raf($vaccine_raf_id);
				
				if($vaccine_raf_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'RAF deleted successfully.');
					redirect(SURL.'vaccine/list-all-vaccine-raf/'.$vaccine_id);
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'vaccine/list-all-vaccine-raf/'.$vaccine_id);
					
				}//end if if($delete_vaccine_raf != '')
				
			}//end if($vaccine_raf_id!="")
			
	}//end function delete_vaccine_raf($vaccine_id,$vaccine_raf_id)

	// Function list_all_vaccine_raf_ajax
	public function list_all_vaccine_raf_ajax(){		
		
		 // POST Values
		 $raf_lable_id_ajax = $this->input->post('raf_lable_id');
		 $vaccine_id_ajax = $this->input->post('vaccine_id');
		
		// if $raf_lable_id_ajax!="" && $vaccine_id_ajax!=""
		if($raf_lable_id_ajax!="" && $vaccine_id_ajax!="")
		{
			// Get All Vaccine
			$data['list_all_vaccine_raf_labels_ajax'] = $this->vaccine->get_all_vaccine_raf_label_ajax($vaccine_id_ajax,$raf_lable_id_ajax);
			
			//echo json_encode($list_all_medicine_raf_labels_ajax);
			 // Load view: list_all_medicine_raf_ajax
			 
		  echo $this->load->view('vaccine/list_all_vaccine_raf_ajax',$data,true);
		
		} else {
			
			$data['list_all_vaccine_raf_labels_ajax'] = $this->vaccine->get_all_vaccine_raf_label_ajax($vaccine_id_ajax,'');
			
			echo $this->load->view('vaccine/list_all_vaccine_raf_ajax',$data,true);
		}
		
	} // End - list_all_vaccine_raf_ajax():

    // Function  update_vaccine_raf_order_process
	public function update_vaccine_raf_order_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('info_order_btn')) redirect(base_url());
		
		 // update vaccine raf ordering
		 $update_vaccine_raf_success = $this->vaccine->update_vaccine_raf_ordering($this->input->post()); 
		 
		 $vaccine_id = $this->input->post('vaccine_id');
		
		if($update_vaccine_raf_success=='1'){
		
			$this->session->set_flashdata('ok_message', 'RAF ordering updated successfully.');
			redirect(SURL.'vaccine/list-all-vaccine-raf/'.$vaccine_id);			
		}else{
			
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'vaccine/list-all-vaccine-raf/'.$vaccine_id);
		}
			
	}//end update_vaccine_raf_order_process()
	
	// Start - list_all_travel_vaccine():
	public function list_all_travel_vaccine($vaccine_id = ''){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Pull all travel vaccine from db
		$data['list_all_travel_vaccine'] = $this->vaccine->get_all_travel_vaccine();
		
			// Set Bread Crumb
		$this->breadcrumbcomponent->add('Add New Travel vaccine', base_url().'vaccine/list-all-travel-vaccine');
		
		if($vaccine_id != ''){ // If update action requested
			$data['vaccine'] = $this->vaccine->get_travel_vaccine_details($vaccine_id);
			$data['form_action'] = 'update';
			
			// Bread crumb Update Settings
			$this->breadcrumbcomponent->add('Update Travel vaccine', base_url().'vaccine/list-all-travel-vaccine');
			
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
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: vaccine
		$this->stencil->paint('vaccine/list_all_travel_vaccine', $data);
		
	} // End - list_all_travel_vaccine():
	
	// Start - add_update_travel_vaccine():
	public function add_update_travel_vaccine(){
		
		$success = $this->vaccine->add_update_travel_vaccine($this->input->post());
		$action = $this->input->post('action');
		if($success){
			if($action == 'add')
				$this->session->set_flashdata('ok_message_vaccine', 'Travel vaccine has been successfully added.');
			else
				$this->session->set_flashdata('ok_message_vaccine', 'Travel vaccine  has been successfully updated.');
			redirect(SURL.'vaccine/list-all-travel-vaccine');
		} else {
			$this->session->set_flashdata('err_message_vaccine', 'Oops! Something went wrong.');
			redirect(SURL.'vaccine/list-all-travel-vaccine');
		}
		
	} // End - add_update_travel_vaccine():
		
	// Function delete_travel_vaccine
	public function delete_travel_vaccine($vaccine_id){
		
			if($vaccine_id!="")
			{
				$vaccine_travel_raf_success = $this->vaccine->delete_vaccine_travel($vaccine_id);
				
				if($vaccine_travel_raf_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Vaccine deleted successfully.');
					redirect(SURL.'vaccine/list-all-travel-vaccine');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'vaccine/list-all-travel-vaccine');
					
				}//end if if($delete_vaccine_raf != '')
				
			}//end if($vaccine_raf_id!="")
			
	}//end function delete_travel_vaccine($vaccine_id)
	
	// Start - list_all_vaccine_destination():
	public function list_all_vaccine_destination(){		
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Add Javascripts
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		   $this->breadcrumbcomponent->add('Destination Listing', base_url().'vaccine/list-all-destination-vaccine');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		$this->stencil->js('kod_scripts/custom.js');
		
		// Get all vaccine
		$data['list_all_destination_vaccine'] = $this->vaccine->get_all_destination_vaccine();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_destination_vaccine
		$this->stencil->paint('vaccine/list_all_destination_vaccine',$data);
		
	} // End - list_all_vaccine_destination():
	
	// Function add_update_vaccine_destination
	public function add_update_vaccine_destination($destination_id =''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		
		// Set Bread Crumb
		//$this->breadcrumbcomponent->add('Vaccines Listing', base_url().'vaccine/list-all-vaccine');
		
		  $this->breadcrumbcomponent->add('Destination Listing', base_url().'vaccine/list-all-vaccine-destination');
		
		if($destination_id == '') {

		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Add New Destination', base_url().'vaccine/add-update-vaccine-destination');
		
		} else{
			
			$get_vaccine_destination_details = $this->vaccine->get_vaccine_destination_details($destination_id);			
			$data['get_vaccine_destination_details'] = $get_vaccine_destination_details;
			
			$country_name = filter_string($get_vaccine_destination_details['destination']);
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Destination ('.$country_name.')', base_url().'vaccine/add-update-vaccine-destination');
				
		}//end if($$vaccine_id == '')
		
			// get save vaccine in destination_vaccines
			$list_vaccines_edit = $this->vaccine->get_all_travel_vaccine_destination($destination_id);
	    	$data['list_vaccines_edit'] = $list_vaccines_edit;
		
			// Show all vacines		
			$list_vaccines = $this->vaccine->get_all_travel_vaccine_destination_add();
	    	$data['list_vaccines'] = $list_vaccines;
		
			// Js file using for CMS page validation
			$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
			$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
			// end CMS file Validation
		
			$this->stencil->js('kod_scripts/custom.js');
		
			// Bread crumb output
			$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
			$this->stencil->paint('vaccine/add_update_vaccine_destination',$data);
		
	}//end add_update_vaccine_destination()
	
	// Function  add_update_destination_vaccine_process
	
	// Function add_update_vaccine_destination_process
	public function add_update_vaccine_destination_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_destination_btn')) redirect(base_url());
		
		 $add_update_vaccine_destination= $this->vaccine->add_update_vaccine_destination($this->input->post()); 
		
		 $destination_id = $this->input->post('destination_id');
		 
		if($add_update_vaccine_destination){
						
			if($destination_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Destination added successfully.');
				redirect(SURL.'vaccine/list-all-vaccine-destination');
				
			}else{

				$referrer_link  = $destination_id;
				$this->session->set_flashdata('ok_message', 'Destination updated successfully.');
				redirect(SURL.'vaccine/add-update-vaccine-destination/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $destination_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'vaccine/add-update-vaccine-destination/'.$referrer_link);
		}
			
	}//end add_update_destination_vaccine_process()
	
	// Function delete_destination_vaccine
	public function delete_destination_vaccine($destination_id){
		
			if($destination_id!="")
			{
				$vaccine_destination_success = $this->vaccine->delete_destination_vaccine($destination_id);
				
				if($vaccine_destination_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Destination deleted successfully.');
					redirect(SURL.'vaccine/list-all-vaccine-destination');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'vaccine/list-all-vaccine-destination');
					
				}//end if if($delete_vaccine_raf != '')
				
			}//end if($vaccine_raf_id!="")
			
	}//end function delete_destination_vaccine($destination_id)
	
	// Function delete_destination_vaccine
	public function delete_vaccine($destination_id){
		
			if($destination_id!="")
			{
				$vaccine_vaccine_success = $this->vaccine->delete_vaccine($destination_id);
				
				if($vaccine_vaccine_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Vaccine Destination deleted successfully.');
					redirect(SURL.'vaccine/list-all-vaccine-destination');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'vaccine/list-all-vaccine-destination');
					
				}//end if if($delete_vaccine_raf != '')
				
			}//end if($vaccine_raf_id!="")
			
	}//end function delete_destination_vaccine($destination_id)
			
    /*****************************************************
	* Vaccine End  Add Update Listing Function
	*****************************************************/
	
	/***********************************************************
	* Vaccine Brand Add Update Listing Function
	***********************************************************/
	
	// Function  add_update_brand_vaccine_process
	public function add_update_vaccine_brand_process(){
		
		   $success = $this->vaccine->add_update_vaccine_brand($this->input->post());
		   
		   $vaccine_cat_id  = $this->input->post('vaccine_cat_id');
			$action = $this->input->post('action');
			if($success){
				if($action == 'add') {
					$this->session->set_flashdata('ok_message_vaccine', 'Vaccine Brand has been successfully added.');
					 redirect(SURL.'vaccine/list-all-vaccine-brand/'.$vaccine_cat_id);
				} else {
					$this->session->set_flashdata('ok_message_vaccine', 'Vaccine Brand  has been successfully updated.');
					 redirect(SURL.'vaccine/list-all-vaccine-brand/'.$vaccine_cat_id);
			   } 
			}else {
				$this->session->set_flashdata('err_message_vaccine', 'Oops! Something went wrong.');
				 redirect(SURL.'vaccine/list-all-vaccine-brand/'.$vaccine_cat_id);
			}

	}//end add_update_brand_vaccine_process()
	
	//Function  list_all_vaccine_brand 
	public function list_all_vaccine_brand($vaccine_id = '',$brand_id = ''){		
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Add Javascripts
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		if($brand_id != ''){ // If update action requested
			$data['vaccine'] = $this->vaccine->get_brand_name($brand_id);
			$data['form_action'] = 'update';
			
			// Bread crumb Update Settings
			$this->breadcrumbcomponent->add('Update  vaccine Brand', base_url().'vaccine/list-all-brand-vaccine');
			
		} else {
			$data['form_action'] = 'add';
		}
		// Get all vaccine
		$vaccine_name = $this->vaccine->get_vaccine_name($vaccine_id);
		$data['vaccine_name'] = $vaccine_name; 
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Travel Vaccines Listing', base_url().'vaccine/list-all-travel-vaccine');
		$this->breadcrumbcomponent->add('Vaccines Brands Listing '.filter_string($vaccine_name['vaccine_name']), base_url().'vaccine/list-all-vaccine-brand');

			// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation 
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Vaccine Brand
		$data['list_all_vaccine_brand'] = $this->vaccine->get_all_vaccine_brands($vaccine_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_medicine_category
		$this->stencil->paint('vaccine/list_all_brand_vaccine',$data);
		
	} // End - list_all_vaccine_brand():
	
	/*****************************************************
	* Vaccine Brand End  Add Update Listing Function
	*****************************************************/

}/* End of file */