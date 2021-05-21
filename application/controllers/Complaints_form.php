<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complaints_form extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		
		$this->load->model('Complaints_mod','complaints');
		$this->load->model('Users_mod','users');
        
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
	public function index($id = ''){
			
			$page_title = 'Complaints Form';
			
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => 'Complaits Form',
				'keywords' =>'Complaits Form'
			));
			
			
			if($id !=''){
				
			   $get_users_details = $this->users->get_user_details($id);
		       $data['user_details'] = $get_users_details;
				
			}
			
			if(!$frame){
				
				//Sets the variable $head to use the slice head (/views/slices/header_top.php)
				$this->stencil->slice('header_top');

				//Sets the variable $head to use the slice head (/views/slices/footer.php)
				$this->stencil->slice('footer');
				
			}else{
				$data['frame'] = $frame;	
			}//end if(!$frame)
				
			//Sets the variable $head to use the slice head (/views/slices/header_script.php)
			$this->stencil->slice('header_script');
			
			//load main template
			$this->stencil->layout('full_width_template_complaints'); //full_width_template template
			
			//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
			$this->stencil->slice('footer_script');
			
				// Time display
			$this->stencil->css('bootstrap-datetimepicker.min.css');
			$this->stencil->js('moment-with-locales');
			$this->stencil->js('bootstrap-datetimepicker.min.js');
		
			// Date display
			$this->stencil->css('datepicker.css');
			$this->stencil->js('date-time/bootstrap-datepicker.js');
			$this->stencil->js('date-time/custom_datepicker.js');
			
			$this->stencil->paint('complaints/complaint_form',$data);

	} // End => function index()
	
	
	// Start => function index()
	public function register(){
			
			$page_title = 'Complaints Form';
			
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => 'Complaits Form',
				'keywords' =>'Complaits Form'
			));
			
		
			
			if(!$frame){
				
				//Sets the variable $head to use the slice head (/views/slices/header_top.php)
				$this->stencil->slice('header_top');

				//Sets the variable $head to use the slice head (/views/slices/footer.php)
				$this->stencil->slice('footer');
				
			}else{
				$data['frame'] = $frame;	
			}//end if(!$frame)
				
			//Sets the variable $head to use the slice head (/views/slices/header_script.php)
			$this->stencil->slice('header_script');
			
			//load main template
			$this->stencil->layout('full_width_template_complaints'); //full_width_template template
			
			//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
			$this->stencil->slice('footer_script');
			
				// Time display
			$this->stencil->css('bootstrap-datetimepicker.min.css');
			$this->stencil->js('moment-with-locales');
			$this->stencil->js('bootstrap-datetimepicker.min.js');
		
			// Date display
			$this->stencil->css('datepicker.css');
			$this->stencil->js('date-time/bootstrap-datepicker.js');
			$this->stencil->js('date-time/custom_datepicker.js');
			
			$this->stencil->paint('complaints/complaint_form',$data);

	} // End => function index()
	
		
	// complaints form process
	public function complaints_add_edit_process(){
	

        if( !$this->input->post() && !$this->input->post('submit_complaints_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			if($user_id !=""){
			
			    $get_users_details = $this->users->get_user_details($user_id);
		     	$data['user_details'] = $get_users_details;
				
			}
			
			if($get_users_details['id'] == "")
			{
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'complaints-form/register/'.$user_id);	
			}
			
			else {
            $save = $this->complaints->complaints_add_edit_form($this->input->post());
						
            if($save){
    
                $this->session->set_flashdata('ok_message', 'Complaint successfully registered.');
                 redirect(SURL.'complaints-form/register/'.$user_id);	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'complaints-form/register/'.$user_id);	
    
            }//end if($save)
		}
       
    }//end complaints_add_edit_process()
}

/* End of file */
