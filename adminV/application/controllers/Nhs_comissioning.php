<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nhs_comissioning extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('NHS_comissioning_mod','nhs_comissioning');
		
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
	
	// Function add_update_nhs_comissioning_category
	public function add_update_nhs_comissioning_category($category_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('NHS Comissioning Category Listing', base_url().'nhs_comissioning/list-all-nhs-comissioning-category');

		if($category_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New NHS Comissioning Category', base_url().'nhs_comissioning/add-update-nhs-comissioning-category');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update NHS Comissioning Category', base_url().'nhs_comissioning/add-update-nhs-comissioning-category');
			
			$get_nhs_comissioning_category_details = $this->nhs_comissioning->get_nhs_comissioning_category_details($category_id);
			
			$data['get_nhs_comissioning_category_details'] = $get_nhs_comissioning_category_details;
		}//end if($$category_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('nhs_comissioning/add_update_nhs_comissioning_category',$data);
		
	}//end add_update_nhs_comissioning_category()
	
	// Function  add_new_nhs_comissioning_category_process
	public function add_new_nhs_comissioning_category_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_category_btn')) redirect(base_url());
		
		 $add_new_nhs_comissioning_cateogry = $this->nhs_comissioning->add_new_nhs_comissioning_cateogry($this->input->post()); 
		
		if($add_new_nhs_comissioning_cateogry){
			
			$category_id = $this->input->post('category_id');
			
			if($category_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New NHS Comissioning Category added successfully.');
				redirect(SURL.'nhs_comissioning/list-all-nhs-comissioning-category');
				
			}else{

				$referrer_link  = $category_id;
				$this->session->set_flashdata('ok_message', 'NHS Comissioning Category updated successfully.');
				redirect(SURL.'nhs_comissioning/add-update-nhs-comissioning-category/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $category_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'nhs_comissioning/add-update-nhs-comissioning-category/'.$referrer_link);
		}

	}//end add_new_nhs_comissioning_category_process()
	
	//Function  list_all_nhs_comissioning_category 
	public function list_all_nhs_comissioning_category(){		
		
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
		$this->breadcrumbcomponent->add('NHS Comissioning Category Listing', base_url().'nhs_comissioning/list-all-nhs-comissioning-category');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all NHS Comissioning Category
		$data['list_nhs_comissioning_category'] = $this->nhs_comissioning->get_all_nhs_comissioning_category();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_nhs_comissioning_category
		$this->stencil->paint('nhs_comissioning/list_all_nhs_comissioning_category',$data);
		
	} // End - list_all_nhs_comissioning_category():
	
	// Function delete_nhs_comissioningw_category
	public function delete_nhs_comissioning_category($category_id){
		
			if($category_id!="")
			{
				$get_nhs_comissioning_category_delete = $this->nhs_comissioning->delete_nhs_comissioning_category($category_id);
				
				if($get_nhs_comissioning_category_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'NHS Comissioning category deleted successfully.');
					redirect(SURL.'nhs_comissioning/list-all-nhs-comissioning-category');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'nhs_comissioning/list-all-nhs-comissioning-category');
					
				}//end if if($delete_page != '')
				
			}//end if($page_id!="")
			
	}//end function delete_nhs_comissioning_category($category_id)
	
/*****************************************/

// Function add_update_nhs_comissioning_documents
	public function add_update_nhs_comissioning_documents($document_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));

		// Set Bread Crumb
		$this->breadcrumbcomponent->add('NHS Comissioning Documents Listing', base_url().'nhs_comissioning/list-all-nhs-comissioning-documents');
		
		// Get all category
		$data['list_nhs_comissioning_category'] = $this->nhs_comissioning->get_all_nhs_comissioning_category();

		if($document_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New NHS Comissioning Document', base_url().'nhs_comissioning/add-update-nhs-comissioning-document');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update NHS Comissioning Category', base_url().'nhs_comissioning/add-update-nhs-comissioning-document');
			
			$get_nhs_comissioning_document_details = $this->nhs_comissioning->get_nhs_comissioning_document_details($document_id);
			
			$data['get_nhs_comissioning_document_details'] = $get_nhs_comissioning_document_details;
		}//end if($document_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('nhs_comissioning/add_nhs_comissioning_document',$data);
		
	}//end add_update_nhs_comissioning_documents()
	
	// Function  add_new_nhs_comissioning_documents_process
	public function add_new_nhs_comissioning_documents_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_document_btn')) redirect(base_url());
		
		 $add_new_nhs_comissioning_document = $this->nhs_comissioning->add_new_nhs_comissioning_documents($this->input->post()); 
		
		if($add_new_nhs_comissioning_document){
			
			$document_id = $this->input->post('document_id');
			
			if($document_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New NHS Comissioning document added successfully.');
				redirect(SURL.'nhs_comissioning/list-all-nhs-comissioning-documents');
				
			}else{

				$referrer_link  = $document_id;
				$this->session->set_flashdata('ok_message', 'NHS Comissioning document updated successfully.');
				redirect(SURL.'nhs_comissioning/add-update-nhs-comissioning-documents/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $document_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'nhs_comissioning/add-update-nhs-comissioning-document/'.$referrer_link);
		}
			
	}//end add_new_nhs_comissioning_documents_process()
	
	//Function  list_all_nhs_comissioning_documents 
	public function list_all_nhs_comissioning_documents(){		
		
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
		$this->breadcrumbcomponent->add('NHS Comissioning Documents Listing', base_url().'nhs_comissioning/list-all-nhs-comissioning-documents');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all NHS Comissioning documents
		$data['list_nhs_comissioning_documents'] = $this->nhs_comissioning->get_all_nhs_comissioning_documents();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_nhs_comissioning_documents
		$this->stencil->paint('nhs_comissioning/list_all_nhs_comissioning_documents',$data);
		
	} // End - list_all_nhs_comissioning_documents():
	
	// Function delete_nhs_comissioning_documents
	public function delete_nhs_comissioning_document($document_id){
		
			if($document_id!="")
			{
				$get_nhs_comissioning_documents_delete = $this->nhs_comissioning->delete_nhs_comissioning_documents($document_id);
				
				if($get_nhs_comissioning_documents_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'NHS Comissioning category deleted successfully.');
					redirect(SURL.'nhs_comissioning/list-all-nhs-comissioning-documents');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'nhs_comissioning/list-all-nhs-comissioning-documents');
					
				}//end if if($delete_page != '')
				
			}//end if($page_id!="")
			
	}//end function delete_nhs_comissioning_documents($document_id)

}/* End of file */