<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eps extends MY_Organization_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// Security Check: Verify if the user still belongs to the selected pharmacy_surgery_id
        if($this->session->pharmacy_surgery_id){
            check_if_user_exist_in_pharmacy($this->session->id, $this->session->pharmacy_surgery_id);
        } // if($this->session->pharmacy_surgery_id)

		//This section is allowed to those who have passed the governance and the status is active for pharmacy from admin 
		if(!$this->allowed_user_menu['show_prescription']){
			$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
			redirect(SURL.'dashboard');
		}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
       
	    $this->load->model('Eps_mod','eps');
	
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
		
	}

	// Start => function index()
	public function index(){
		
		
		$data['eps_list'] = $this->eps->get_eps_listing($this->session->pharmacy_surgery_id);

		// Bread crumb
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard',base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('EPS Listing',base_url().'eps-listing');

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
        
		
	    // Datatables
		$this->stencil->js('datatables/js/jquery.dataTables.js');
		$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');

        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('eps/eps_listing',$data);

	} // End => function index()
	
}/* End of file */
