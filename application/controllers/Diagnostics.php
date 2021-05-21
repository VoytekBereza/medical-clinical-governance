<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diagnostics extends MY_Organization_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// Security Check: Verify if the user still belongs to the selected pharmacy_surgery_id
        if($this->session->pharmacy_surgery_id){
            check_if_user_exist_in_pharmacy($this->session->id, $this->session->pharmacy_surgery_id);
        } // if($this->session->pharmacy_surgery_id)

		//This section is only allowed to those passed the governance and the feature is enabled for this pharmacy
		if(!$this->allowed_user_menu['show_travel_insurance']){
			$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
			redirect(SURL.'dashboard');
		}//end if($this->show_teambuilder && !$get_user_details['enable_register'])

        
        // Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		// Add JS Scripts for using in Organization
        $this->stencil->js('kod_scripts/organization/custom.js');

        //Sets the variable $head to use the slice head (/views/slices/header_script.php)
        $this->stencil->slice('header_script');

        //Sets the variable $head to use the slice head (/views/slices/header_top.php)
        $this->stencil->slice('header_top');

        //Sets the Left Navigation
        $this->stencil->slice('dashboard_left_pane');

        //Sets the variable $head to use the slice head (/views/slices/footer.php)
        $this->stencil->slice('footer');

        //Sets the variable $head to use the slice head (/views/slices/footer_script.php)
        $this->stencil->slice('footer_script');
        
        /* --------------- Scripts for validations ------------ */
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
            
        // Js file using for CMS page validation
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation_2.min.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');

	}

	// Start => function index()
	public function index(){

		// Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('Diagnostics', base_url().'organization/dashboard');
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
		$cms_data_arr = $this->cms->get_cms_page('diagnostics');
		
		$data['cms_data_arr'] = $cms_data_arr['cms_page_arr'];
		
        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('diagnostics/diagnostics',$data);

	} // End => function index()

}/* End of file */
