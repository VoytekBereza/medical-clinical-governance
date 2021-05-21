<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complaints extends MY_Organization_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// Security Check: Verify if the user still belongs to the selected pharmacy_surgery_id
        if($this->session->pharmacy_surgery_id){
            check_if_user_exist_in_pharmacy($this->session->id, $this->session->pharmacy_surgery_id);
        } // if($this->session->pharmacy_surgery_id)

		//This section is allowed to those who have passed the governance and the status is active for pharmacy from admin 
		if(!$this->allowed_user_menu['show_clinical_governance']){
			$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
			redirect(SURL.'dashboard');
		}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
		
		$this->load->model('Complaints_mod','complaints');
        
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
		$this->breadcrumbcomponent->add('Complaints', base_url().'organization/dashboard');
		 
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
        
		
		$get_complaint_list = $this->complaints->get_complaint_list($this->session->id);
		
		$get_data_user = $this->complaints->email_complaints_form($this->input->post(),$this->session->id,$this->session->organization['address']);
		$data['get_data_user'] = $get_data_user;
		 
		$data['get_complaint_list']  = $get_complaint_list;
		
       	$this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');

        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('complaints/complaints',$data);

	} // End => function index()
		
	// complaints form process
	public function complaints_form_process(){
		
        if( !$this->input->post() && !$this->input->post('complaints_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			$this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('message_body', 'Message', 'trim|required');
			
		  if($this->form_validation->run() == FALSE){
			
			// PHP Error
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(SURL.'complaints?t=3');
			
		} else {
            $send_email = $this->complaints->email_complaints_form($this->input->post(),$this->session->id,$this->session->organization['address']);
			
			 if($send_email){
    
                $this->session->set_flashdata('ok_message', 'Email send successfully.');
                 redirect(SURL.'complaints?t=3');	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'complaints?t=3');	
    
            }//end if($add_edit_clinical_diary)
			
		}
       
    }//end complaints_form_process()
	
	
	// Start - public function add_acknowledge()
	public function add_acknowledge($id = ''){
		
		
		if($id !=''){
			
			$data['complaints_id']= $id;
			$complaints_details = $this->complaints->get_complaints_details($id,$this->session->id);
		    $data['complaints_details'] = $complaints_details;
			
		}
		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //get_complaints_details
		$this->stencil->paint('complaints/add_acknowledge',$data);

	} // End - public function add_acknowledge()
	
	// Start - public function add_investigate()
	public function add_investigate($id = ''){
		
		if($id !=''){
			
			$data['complaints_id']= $id;
			$complaints_details = $this->complaints->get_complaints_details($id,$this->session->id);
		    $data['complaints_details'] = $complaints_details;
			
		}
		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //get_complaints_details
		$this->stencil->paint('complaints/add_investigate',$data);

	} // End - public function add_investigate()
	
	// Start - public function add_outcome()
	public function add_outcome($id = ''){
		
		if($id !=''){
			$data['complaints_id']= $id;
			
			$complaints_details = $this->complaints->get_complaints_details($id,$this->session->id);
		    $data['complaints_details'] = $complaints_details;
		}
		
		
		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //get_complaints_details
		$this->stencil->paint('complaints/add_outcome',$data);

	} // End - public function add_acknowledge()
	
    // Start - public function get_acknowledge_details()
	public function get_acknowledge_details($id = ''){
		
		if($id !=''){
			
			$complaints_details = $this->complaints->get_complaints_details($id,$this->session->id);
		    $data['complaints_details'] = $complaints_details;
		}
		
		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //get_complaints_details
		$this->stencil->paint('complaints/acknowledge_details',$data);

	} // End - public function get_complaints_details()
	
	// complaints form process
	public function add_complaint_process(){
		
	

        if( !$this->input->post() && !$this->input->post('complaints_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
            $add_complaints = $this->complaints->add_complaints($this->input->post(),$this->session->id);
						
            if($add_complaints){
    
                $this->session->set_flashdata('ok_message', 'Recorded added successfully.');
                 redirect(SURL.'complaints?t=2');	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'complaints?t=2');	
    
            }//end 
       
    }//end add_complaint_process()
	
	
	  // Start - public function get_acknowledge_details()
	public function resolve_complaint($id = ''){
		
		if($id !=''){
			
			$complaints_details = $this->complaints->get_complaints_details($id,$this->session->id);
		    $data['complaints_details'] = $complaints_details;
		}
		
		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //get_complaints_details
		$this->stencil->paint('complaints/resolve',$data);

	} // End - public function get_complaints_details()
	
	
	// complaints form process
	public function resolve_process(){
		
	

        if($this->input->post('resolve_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
            $resolve_complaints = $this->complaints->resolve_complaints($this->input->post(),$this->session->id);
						
            if($resolve_complaints){
    
                $this->session->set_flashdata('ok_message', 'Complaints resolved  successfully.');
                 redirect(SURL.'complaints?t=2');	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'complaints?t=2');	
    
            }//end 
       
    }//end add_complaint_process()
	
	
	
}

/* End of file */
