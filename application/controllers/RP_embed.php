<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RP_embed extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('common_mod','common');
		$this->load->model('cms_mod','cms');
		$this->load->model('organization_mod','organization');
		$this->load->model('pharmacy_mod','pharmacy');
		$this->load->model('Repeat_prescription_mod','repeat_prescription');
		 
		 /* --------------- Scripts for validations ------------ */
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
	}

	public function index($pharmacy_surgery_id){
		
		if(trim($pharmacy_surgery_id) == '') redirect(base_url());
		
		$check_if_pharmacy_exist = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
		
		if($check_if_pharmacy_exist){
			
			$data['frame'] = 1;
			
			$data['pharmacy_surgery_id'] = $check_if_pharmacy_exist['id'];
			
			$data['organization_id'] = $check_if_pharmacy_exist['organization_id'];
			
			$data['get_pharmacy_surgery_details'] = $get_pharmacy_surgery_details;

			$page_title = $check_if_pharmacy_exist['pharmacy_surgery_name'].' Repeat Prescription Request';
			
			$this->stencil->title($page_title);	
			
			//Sets the variable $head to use the slice head (/views/slices/header_script.php)
			$this->stencil->slice('header_script');
			
			//load main template
			$this->stencil->layout('full_width_template'); //full_width_template template
			
			//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
			$this->stencil->slice('footer_script');
			
			// Date display
			$this->stencil->css('datepicker.css');
			$this->stencil->js('date-time/bootstrap-datepicker.js');
			$this->stencil->js('date-time/custom_datepicker.js');
			
			$this->stencil->paint('repeat_prescription/rp_embed',$data);

		}else{
			redirect(base_url());	
		}//end if($check_if_pharmacy_exist)
		
	} //end index()
	
	// add rp process
	public function add_rp_process(){
	

        if( !$this->input->post() && !$this->input->post('submit_rp_btn') )  redirect(base_url());	
        
            extract($this->input->post());
			
			$check_if_pharmacy_exist = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);

			if($check_if_pharmacy_exist)
			{
				
            $save = $this->repeat_prescription->add_repeat_prescription($this->input->post());
						
            if($save){
    
                $this->session->set_flashdata('ok_message', 'Repeat prescription form  successfully added.');
                 redirect(SURL.'rp-embed/'.$pharmacy_surgery_id);	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'rp-embed/'.$pharmacy_surgery_id);	
    
            }//end if($save)
		} else {
			
			  $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
               redirect(SURL.'rp-embed/'.$pharmacy_surgery_id);	
			
		}
       
    }//end add_rp_process()
	
}

/* End of file */
