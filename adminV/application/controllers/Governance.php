<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Governance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('Governance_mod','governance');
		
		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');

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
		
		// Js form validation scripts
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');
	}

	public function index(){
		
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()
	
	// Start - list_all_hr_governance():
	public function list_all_hr_governance(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Pull all Governance HR Listing
		$data['list_governance_hr'] = $this->governance->get_all_governance_hr();
		
			// Set Bread Crumb
		$this->breadcrumbcomponent->add('Governance HR Listing', base_url().'governance/list-all-hr-governance');
		
		// icheck
        $this->stencil->js('icheck/icheck.min.js');

        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_hr_governance
		$this->stencil->paint('governance/list_all_governance_hr', $data);
		
	} // End - list_all_hr_governance():
	
	// Start  edit_governance_hr
	public function edit_governance_hr($governance_id = '') {
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Governance HR Listing', base_url().'governance/list-all-hr-governance');
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Edit Governance HR', base_url().'governance/edit-governannce-hr');
	
		// Get data from governace_hr table
		$data['get_governance_hr_details'] = $this->governance->get_governance_hr($governance_id);
		
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		//$chk_isvalid_user = $this->login->validate_credentials($this->input->post('email_address'),$this->input->post('password'));
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
			// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('governance/edit_governance_hr', $data);
		
	}// end edit_governance_hr
	
		// Function edit_governance_hr_process
		public function edit_governance_hr_process() {

	    $is_update_governance = $this->governance->add_update_governance_hr($this->input->post());
		
		$governance_id = $this->input->post('governance_id');
		
		if($is_update_governance){
			
			    $referrer_link  = $governance_id;
				$this->session->set_flashdata('ok_message', 'Governance HR has been successfully updated.');
			    redirect(SURL.'governance/edit-governance-hr/'.$referrer_link);
		} else {
			   
			    $referrer_link  = $governance_id;
			    $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			    redirect(SURL.'governance/edit-governannce-hr/'.$referrer_link);
		}
	} // end edit_governance_hr_process
	
	public function edit_governance($governance_id = '') {
		
		// Get data from governace table
		$data['get_governance_details'] = $this->governance->edit_governance($governance_id);
		
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Edit Governance', base_url().'governance/edit-governannce');
	
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
		
		$this->stencil->paint('governance/edit_governance',$data);
		
	}// end edit_governance
	
		// Function edit_governance_process
		public function edit_governance_process() {

	    $is_update_governance = $this->governance->update_governance($this->input->post());
		
		$governance_id = $this->input->post('governance_id');
		
		if($is_update_governance){
			    
				if($governance_id !="") 
					
					$referrer_link  = $governance_id;
				else 
					
					$referrer_link  = 1;
				
				$this->session->set_flashdata('ok_message', 'Governance has been successfully updated.');
			    redirect(SURL.'governance/edit-governance/'.$referrer_link);
		} else {
			   
			   if($governance_id !="") 
					
					$referrer_link  = $governance_id;
				else 
					
					$referrer_link  = 1;
				
			    $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			    redirect(SURL.'governance/edit-governance/'.$referrer_link);
		}
	} // end edit_governance_process
	
	// Function add_update_sop_category
	public function add_update_sop_category($category_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('SOP Category Listing', base_url().'governance/list-all-sop-category');

		if($category_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New SOP Category', base_url().'governance/add-update-sop-category');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update SOP Category', base_url().'governance/add-update-sop-category');
			
			$get_category_details = $this->governance->get_sop_category_details($category_id);
			
			$data['get_category_details'] = $get_category_details;
		}//end if($$category_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->layout('ajax_pages'); //page_template

		$this->stencil->paint('governance/add_update_sop_category',$data);
		
	}//end add_update_sop_category()
	
	// Function  add_new_sop_category_process
	public function add_new_sop_category_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_category_btn')) redirect(base_url());
		
		 $add_new_sop_cateogry = $this->governance->add_new_sop_cateogry($this->input->post()); 
		
		if($add_new_sop_cateogry){
			
			$category_id = $this->input->post('category_id');
			
			if($category_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New SOP Category added successfully.');
				redirect(SURL.'governance/list-all-sop');
				
			}else{

				/*
				$referrer_link  = $category_id;
				$this->session->set_flashdata('ok_message', 'SOP Category updated successfully.');
				redirect(SURL.'governance/add-update-sop-category/'.$referrer_link);
				*/

				$this->session->set_flashdata('ok_message', 'Sop was successfully updated.');
				redirect(SURL.'governance/list-all-sop');
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $category_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'governance/add-update-sop-category/'.$referrer_link);

		}//end if($add_new_page)
			
	}//end add_new_sop_category_process()
	
	//Function  list_all_sop_category 
	public function list_all_sop_category(){		
		
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
		$this->breadcrumbcomponent->add('SOP Catetgory Listing', base_url().'governance/list-all-sop-category');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Sop Category
		$data['list_sop_category'] = $this->governance->get_all_sop_category($category_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_sop_category
		$this->stencil->paint('governance/list_all_sop_category',$data);
		
	} // End - list_all_sop_category():
	
	// Function delete_sop_category
	public function delete_sop_category($category_id){
		
			if($category_id!="")
			{
				$get_sop_category_delete = $this->governance->delete_sop_category($category_id);
				
				if($get_sop_category_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'SOP category deleted successfully.');
					redirect(SURL.'governance/list-all-sop');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'governance/list-all-sop');
					
				}//end if if($delete_page != '')
				
			}//end if($page_id!="")
			
	}//end function delete_page($page_id)
	
	// Function add_update_sop
	public function add_update_sop($sop_id = '', $action=''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Get All Sop Categories
		$get_all_sop_categories_arr = $this->governance->get_all_sopcategories();
		$data['get_all_sop_categories_arr'] = $get_all_sop_categories_arr;
		
		//Active User Type List
		$list_user_type = $this->governance->get_active_usertypes();
		$data['list_user_type'] = $list_user_type;
		
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('SOPs Listing', base_url().'governance/list-all-sop');

		if($action == 'add') {
		
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New SOPs', base_url().'governance/add-update-sop');
			$data['category_id'] = $sop_id;

		} else if($action == 'update'){
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update SOPs', base_url().'governance/add-update-sop');
			
			$get_sop_details = $this->governance->get_sop_details($sop_id);
			
			$data['get_sop_details'] = $get_sop_details;

		}//end if($$sop_id == '')
		
		$this->stencil->js('kod_scripts/custom_validate.js');
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation.min.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//Editor Files
        $this->stencil->js('tinymce/tinymce.min.js');

		$this->stencil->layout('ajax_pages');

		$this->stencil->paint('governance/add_update_sop',$data);
		
	}//end add_update_sop()
	
	// Function  add_new_sop_process
	public function add_new_sop_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_sop_btn')) redirect(base_url());
		
		 $add_new_sop = $this->governance->add_new_sop($this->input->post()); 
		
		if($add_new_sop){
			
			$sop_id = $this->input->post('sop_id');
			
			if($sop_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New SOPs added successfully.');
				redirect(SURL.'governance/list-all-sop');
				
			}else{

				/*$referrer_link  = $sop_id;
				$this->session->set_flashdata('ok_message', 'SOPs updated successfully.');
				redirect(SURL.'governance/add-update-sop/'.$referrer_link);*/

				$this->session->set_flashdata('ok_message', 'Sop was successfully updated.');
				redirect(SURL.'governance/list-all-sop');
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			/*$referrer_link  = $sop_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'governance/add-update-sop/'.$sop_id);*/

			$this->session->set_flashdata('ok_message', 'Oops! Something went wrong.');
			redirect(SURL.'governance/list-all-sop');

		}//end if($add_new_sop_process)

	} // End - add_new_sop_category_process()
	
	//Function  list_all_sop 
	public function list_all_sop(){
		
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
		$this->breadcrumbcomponent->add('SOPs Listing', base_url().'governance/list-all-sop');
		
		//Active User Type List
		$list_user_type = $this->governance->get_active_usertypes();
		$data['list_user_type'] = $list_user_type;
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
        
		//Editor Files
        $this->stencil->js('tinymce/tinymce.min.js');

        //Fancy Box Files
        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->js('jquery.mousewheel-3.0.6.pack.js');

        $this->stencil->js('bootstrap-treeview.js');

        // Get all Sop Category
		// $data['list_sop_category'] = $this->governance->get_all_sop_category($category_id);

		// Get all Sop
		$data['list_sop'] = $this->governance->get_all_sop($sop_id);

		// Get all Sop Tress
		$data['sop_list'] = $this->governance->get_sop_tree();

		// echo '<pre>';
		// print_r($data['organization_sop_list']);
		// exit;

		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// $this->stencil->layout('page_template'); // page_template

		// Load View: list_all_sop
		$this->stencil->paint('governance/list_all_sop',$data);
		
	} // End - list_all_sop():
	
	// Function delete_sop
	public function delete_sop($sop_id){
		
			if($sop_id!="")
			{
				$get_sop_delete = $this->governance->delete_sop($sop_id);
				
				if($get_sop_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'SOPs deleted successfully.');
					redirect(SURL.'governance/list-all-sop');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'governance/list-all-sop');
					
				}//end if if($delete_sop != '')
				
			}//end if($sop_id!="")
			
	}//end function delete_sop($sop_id)
	
}/* End of file */