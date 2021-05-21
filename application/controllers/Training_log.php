<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Training_log extends MY_Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();
        
        // Load BreadcrumbComponent Library
		$this->load->model('Training_log_mod', 'training_log');
		
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
		$this->breadcrumbcomponent->add('Training Log', base_url().'organization/dashboard');
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$get_training_log_details = $this->training_log->get_training_log_details($this->session->id);
		$data['training_log_details'] = $get_training_log_details;
		
		$purchased_items_by_user = $this->purchase->get_purchased_items_by_user($this->session->id, 'PGD');
		
		$pgd_training_log = array();
		for($i=0;$i<count($purchased_items_by_user);$i++){
			
			if($purchased_items_by_user[$i]['quiz_pass_date'])
				$pgd_training_log[] = $purchased_items_by_user[$i];
			
		}//end for($i=0;$i<count($purchased_items_by_user);$i++)
		
		$data['pgd_training_log'] = $pgd_training_log;
		
		//print_this($purchased_items_by_user); 		exit;

       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
		$cms_data_arr = $this->cms->get_cms_page('training-log');
		
		$data['cms_data_arr'] = $cms_data_arr['cms_page_arr'];
        
        // Date display
		$this->stencil->css('datepicker.css');
		$this->stencil->js('date-time/bootstrap-datepicker.js');
		$this->stencil->js('date-time/custom_datepicker.js');

        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');

        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('training_log/training_log',$data);

	} // End => function index()
	
	public function edit_training_log($training_id){
		
		$training_log_details = $this->training_log->get_training_log_details($this->session->id, $training_id);
		$data['training_log_details'] = $training_log_details;
		
		$training_log_files_list = $this->training_log->get_training_log_files_list($training_id);
		$data['training_log_files_list'] = $training_log_files_list;

        $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
        $this->stencil->paint('training_log/edit_training_log',$data);
		
	}//end edit_training_log()
	
	public function delete_file($training_id, $file_id){
		
		$training_log_details = $this->training_log->get_training_log_details($this->session->id, $training_id);
		
		if($training_log_details){
			
			$delete_file = $this->training_log->delete_training_log_file($training_id, $file_id);
			
			if($delete_file)
				$this->session->set_flashdata('ok_message', 'Training file successfully deleted.');
			else
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			
			redirect(SURL.'training-log');
			
		}else{
			redirect(SURL);
		}//end if($training_log_details)
		
	}//end delete_file($file_id)
	
	public function add_edit_training_log_process(){
		
		if( !$this->input->post() && !$this->input->post('course_name') ) redirect(SURL.'dashboard');
		
		extract($this->input->post());
		
		$add_training_log = $this->training_log->add_edit_training_log($this->session->id, $this->input->post());
		
		if($add_training_log)
			$this->session->set_flashdata('ok_message', 'New training added successfully.');
		else
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
		
		redirect(SURL.'training-log');
		
	}//end add_training_log_process()

}/* End of file */
