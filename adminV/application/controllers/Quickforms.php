<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quickforms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('Quick_forms_mod','quickforms');
		
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
	
		$this->stencil->js('kod_scripts/custom.js');
	}

	public function index(){
		
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()
	
	// Function add_update_quick_forms_category
	public function add_update_quick_forms_category($category_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Quick Forms Category Listing', base_url().'quickforms/list-all-quick-forms-category');

		if($category_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Quick Forms Category', base_url().'quickforms/add-update-quick-forms-category');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Quick Forms Category', base_url().'quickforms/add-update-quick-forms-category');
			
			$get_quick_forms_category_details = $this->quickforms->get_quick_forms_category_details($category_id);
			
			$data['get_quick_forms_category_details'] = $get_quick_forms_category_details;
		}//end if($$category_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('quickforms/add_update_quick_forms_category',$data);
		
	}//end add_update_quick_forms_category()
	
	// Function  add_new_quick_fomrs_category_process
	public function add_new_quick_fomrs_category_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_category_btn')) redirect(base_url());
		
		 $add_new_quick_fomrs_cateogry = $this->quickforms->add_new_quick_forms_cateogry($this->input->post()); 
		
		if($add_new_quick_fomrs_cateogry){
			
			$category_id = $this->input->post('category_id');
			
			if($category_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New Quick Forms Category added successfully.');
				redirect(SURL.'quickforms/list-all-quick-forms-category');
				
			}else{

				$referrer_link  = $category_id;
				$this->session->set_flashdata('ok_message', 'Quick Forms Category updated successfully.');
				redirect(SURL.'quickforms/add-update-quick-forms-category/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $category_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'quickforms/add-update-quick-forms-category/'.$referrer_link);
		}

	}//end add_new_quick_fomrs_category_process()
	
	//Function  list_all_quick_forms_category 
	public function list_all_quick_forms_category(){		
		
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
		$this->breadcrumbcomponent->add('Quick Forms Category Listing', base_url().'quickforms/list-all-quick-forms-category');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Quick Forms Category
		$data['list_quick_forms_category'] = $this->quickforms->get_all_quick_forms_category();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_quick_forms_category
		$this->stencil->paint('quickforms/list_all_quick_forms_category',$data);
		
	} // End - list_all_quick_forms_category():
	
	// Function delete_quick_formsw_category
	public function delete_quick_forms_category($category_id){
		
			if($category_id!="")
			{
				$get_quick_forms_category_delete = $this->quickforms->delete_quick_forms_category($category_id);
				
				if($get_quick_forms_category_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Quick forms category deleted successfully.');
					redirect(SURL.'quickforms/list-all-quick-forms-category');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'quickforms/list-all-quick-forms-category');
					
				}//end if if($delete_page != '')
				
			}//end if($page_id!="")
			
	}//end function delete_quick_forms_category($category_id)
	
/*****************************************/

// Function add_update_quick_forms_documents
	public function add_update_quick_forms_documents($document_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));

		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Quick Forms Documents Listing', base_url().'quickforms/list-all-quick-forms-documents');
		
		// Get all category
		$data['list_quick_forms_category'] = $this->quickforms->get_all_quick_forms_category();

		if($document_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Quick Forms Document', base_url().'quickforms/add-update-quick-forms-document');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Quick Forms Category', base_url().'quickforms/add-update-quick-forms-document');
			
			$get_quick_forms_document_details = $this->quickforms->get_quick_forms_document_details($document_id);
			
			$data['get_quick_forms_document_details'] = $get_quick_forms_document_details;
		}//end if($document_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('quickforms/add_quick_forms_document',$data);
		
	}//end add_update_quick_forms_documents()
	
	// Function  add_new_quick_fomrs_documents_process
	public function add_new_quick_fomrs_documents_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_document_btn')) redirect(base_url());
		
		 $add_new_quick_fomrs_document = $this->quickforms->add_new_quick_forms_documents($this->input->post()); 
		
		if($add_new_quick_fomrs_document){
			
			$document_id = $this->input->post('document_id');
			
			if($document_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New Quick forms document added successfully.');
				redirect(SURL.'quickforms/list-all-quick-forms-documents');
				
			}else{

				$referrer_link  = $document_id;
				$this->session->set_flashdata('ok_message', 'Quick forms document updated successfully.');
				redirect(SURL.'quickforms/add-update-quick-forms-documents/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $document_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'quickforms/add-update-quick-forms-document/'.$referrer_link);
		}
			
	}//end add_new_quick_fomrs_documents_process()
	
	//Function  list_all_quick_forms_documents 
	public function list_all_quick_forms_documents(){		
		
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
		$this->breadcrumbcomponent->add('Quick Forms Documents Listing', base_url().'quickforms/list-all-quick-forms-documents');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Quick Forms documents
		$data['list_quick_forms_documents'] = $this->quickforms->get_all_quick_forms_documents();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_quick_forms_documents
		$this->stencil->paint('quickforms/list_all_quick_forms_documents',$data);
		
	} // End - list_all_quick_forms_documents():
	
	// Function delete_quick_forms_documents
	public function delete_quick_forms_document($document_id){
		
			if($document_id!="")
			{
				$get_quick_forms_documents_delete = $this->quickforms->delete_quick_forms_documents($document_id);
				
				if($get_quick_forms_documents_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Quick forms category deleted successfully.');
					redirect(SURL.'quickforms/list-all-quick-forms-documents');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'quickforms/list-all-quick-forms-documents');
					
				}//end if if($delete_page != '')
				
			}//end if($page_id!="")
			
	}//end function delete_quick_forms_documents($document_id)

}/* End of file */
