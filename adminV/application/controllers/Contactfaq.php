<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactfaq extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('Contact_faq_mod','contactfaq');
		
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
	
	// Function add_update_contact_faq
	public function add_update_contact_faq($faq_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));

        // CK EDITOR
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Contact Faqs Listing', base_url().'contactfaq/list-all-contact-faq');

		if($faq_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Contact Faqs', base_url().'contactfaq/add-update-contact-faq');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update  Contact Faqs', base_url().'contactfaq/add-update-contact-faq');
			
			$get_contact_faq_details = $this->contactfaq->get_contact_faq_details($faq_id);
			
			$data['get_contact_faq_details'] = $get_contact_faq_details;
		}//end if($$faq_id == '')
		
	    // Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('contact_faq/add_update_contact_faq',$data);
		
	}//end add_update_contact_faq()
	
	// Function  add_new_contact_faq_process
	public function add_update_contact_faq_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_contact_faq_btn')) redirect(base_url());
		
		 // Add Update contact Faq
		 $add_update_contact_faq = $this->contactfaq->add_update_contact_faq($this->input->post()); 
		
		if($add_update_contact_faq){
			
			$faq_id = $this->input->post('faq_id');
			
			if($faq_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New  Faqs added successfully.');
				redirect(SURL.'contactfaq/list-all-contact-faq');
				
			}else{

				$referrer_link  = $faq_id;
				$this->session->set_flashdata('ok_message', 'Faqs updated successfully.');
				redirect(SURL.'contactfaq/add-update-contact-faq/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $faq_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'contactfaq/add-update-contact-faq/'.$referrer_link);
		}
	}//end add_new_contact_faq_process()
	
	//Function  list_all_contact_faq 
	public function list_all_contact_faq(){		
		
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
		$this->breadcrumbcomponent->add('Contact Faqs Listing', base_url().'contactfaq/list-all-contact-faq');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all list contact faq
		$data['list_contact_faq'] = $this->contactfaq->get_all_contact_faq();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_contact_faq
		$this->stencil->paint('contact_faq/list_all_contact_faq',$data);
		
	} // End - list_all_contact_faq():

	// Function delete_contact_faq
	public function delete_contact_faq($faq_id){
		
			if($faq_id!="")
			{
				$delete_contact_faq = $this->contactfaq->delete_contact_faq($faq_id);
				
				if($delete_contact_faq == '1')
				{
					$this->session->set_flashdata('ok_message', 'Faqs deleted successfully.');
					redirect(SURL.'contactfaq/list-all-contact-faq');
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'contactfaq/list-all-contact-faq');

				}//end if if($faq_id != '')
				
			}//end if($faq_id!="")
			
	}//end function delete_contact_faq($faq_id)

}/* End of file */
