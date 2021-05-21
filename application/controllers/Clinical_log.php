<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clinical_log extends MY_Organization_Controller {

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
       
	    $this->load->model('Clinical_mod','clinical');
	
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
		
		$pharmacy_staff_members = $this->pharmacy->get_pharmacy_staff_members($this->session->pharmacy_surgery_id, '2');
		$data['pharmacy_pharmacist_list'] = $pharmacy_staff_members;
		
		$data['location_area_list'] = $this->clinical->get_area($this->session->pharmacy_surgery_id);

		$data['list_cl_diary'] = $this->clinical->list_cl_diary($this->session->id,$this->session->pharmacy_surgery_id);
		
		$data['list_cl_errors'] = $this->clinical->list_cl_errors($this->session->id,$this->session->pharmacy_surgery_id);
		
		$data['list_cl_date_checking'] = $this->clinical->list_cl_date_checking($this->session->id,$this->session->pharmacy_surgery_id);
		
		$data['list_cl_cleaning'] = $this->clinical->list_cl_cleaning($this->session->id,$this->session->pharmacy_surgery_id);
		
		$data['list_cl_recalls'] = $this->clinical->list_cl_recalls($this->session->id,$this->session->pharmacy_surgery_id);
		
		$list_cl_responsible_pharmacist = $this->clinical->list_cl_responsible_pharmacist($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_cl_responsible_pharmacist'] = $list_cl_responsible_pharmacist;
		//$data['last_cl_responsible_pharmacist'] = $this->clinical->last_cl_responsible_pharmacist($this->session->id,$this->session->pharmacy_surgery_id);

		
		$data['list_cl_maintenance'] = $this->clinical->list_cl_maintenance($this->session->id,$this->session->pharmacy_surgery_id);
		
		$data['list_cl_self_care'] = $this->clinical->list_cl_self_care($this->session->id,$this->session->pharmacy_surgery_id);

		// Bread crumb
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard',base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('Clinical Log',base_url().'clinical_log');

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
        
        // Include dataTables js and css
		// here
		
		// Time display
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');
    
		// Date display
		$this->stencil->css('datepicker.css');
		$this->stencil->js('date-time/bootstrap-datepicker.js');
		$this->stencil->js('date-time/custom_datepicker.js');
		
		$this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
		            

        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('clinical_log/clinical_log',$data);

	} // End => function index()
	
	// Add clinical diary process
	public function clinical_diary_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_diary_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	$add_edit_clinical_diary = $this->clinical->add_edit_clinical_diary($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
				 redirect(SURL.'clinical-log?t=1');	
			}
			
            if($add_edit_clinical_diary){
    
                $this->session->set_flashdata('ok_message', 'Clinical diary added successfully.');
                 redirect(SURL.'clinical-log?t=1');	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'clinical-log?t=1');	
    
            }//end if($add_edit_clinical_diary)
       
    }//end clinical_diary_process()
	
	// Add clinical eroors process
	public function clinical_errors_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_errors_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			    
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            $add_edit_clinical_errors = $this->clinical->add_edit_clinical_errors($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'clinical-log?t=2');	
			}	
    
            if($add_edit_clinical_errors){
    
                $this->session->set_flashdata('ok_message', 'Clinical error added successfully.');
                 redirect(SURL.'clinical-log?t=2');	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'clinical-log?t=2');	
    
            }//end if($add_edit_clinical_errors)
       
    }//end clinical_errors_process()
	
	// Add clinical date checking process
	public function clinical_date_checking_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_date_checking_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	$add_edit_clinical_date_checking = $this->clinical->add_edit_clinical_date_checking($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'clinical-log?t=3');
			}
			        
            if($add_edit_clinical_date_checking){
    
                $this->session->set_flashdata('ok_message', 'Clinical date checking added successfully.');
                redirect(SURL.'clinical-log?t=3');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'clinical-log?t=3');
    
            }//end if($add_edit_clinical_date_checking)
       
    }//end clinical_date_checking_process()
	
	// Add clinical cleaning process
	public function clinical_cleaning_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_cleaning_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_clinical_cleaning = $this->clinical->add_edit_clinical_cleaning($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'clinical-log?t=4');
			}
    
            if($add_edit_clinical_cleaning){
    
                $this->session->set_flashdata('ok_message', 'Clinical cleaning added successfully.');
                redirect(SURL.'clinical-log?t=4');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'clinical-log?t=4');
    
            }//end if($add_edit_clinical_cleaning)
       
    }//end clinical_cleaning_process()
	
	// Add clinical recalls process
	public function clinical_recalls_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_recalls_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
				
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_clinical_recalls = $this->clinical->add_edit_clinical_recalls($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'clinical-log?t=5');
			}
           
    
            if($add_edit_clinical_recalls){
    
                $this->session->set_flashdata('ok_message', 'Clinical recalls added successfully.');
                redirect(SURL.'clinical-log?t=5');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'clinical-log?t=5');
    
            }//end if($update_governance)
       
    }//end clinical_diary_process()
	
	
	// Add clinical responsible pharmacist process
	public function clinical_responsible_pharmacist_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_responsible_pharmacist_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_clinical_responsible_pharmacist = $this->clinical->add_edit_clinical_responsible_pharmacist($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'clinical-log?t=6');
			}
			    
          
    
            if($add_edit_clinical_responsible_pharmacist){
    
                $this->session->set_flashdata('ok_message', 'Clinical  responsible pharmacist added successfully.');
                redirect(SURL.'clinical-log?t=6');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'clinical-log?t=6');
    
            }//end if($update_governance)
       
    }//end clinical_responsible_pharmacist_process()
	
	// Add clinical maintenance process
	public function clinical_maintenance_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_maintenace_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	$add_edit_clinical_maintenance = $this->clinical->add_edit_clinical_maintenance($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'clinical-log?t=7');
			}
			
            if($add_edit_clinical_maintenance){
    
                $this->session->set_flashdata('ok_message', 'Clinical maintenance added successfully.');
                redirect(SURL.'clinical-log?t=7');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'clinical-log?t=7');
    
            }//end if($add_edit_clinical_diary)
       
    }//end clinical_maintenance_process()
	
	
	// Add clinical self care
	public function clinical_self_care_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_self_care_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	$add_edit_clinical_self_care = $this->clinical->add_edit_clinical_self_care($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'clinical-log?t=8');
			}
			
            if($add_edit_clinical_self_care){
    
                $this->session->set_flashdata('ok_message', 'Clinical self care added successfully.');
                redirect(SURL.'clinical-log?t=8');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'clinical-log?t=8');
    
            }//end if($add_edit_clinical_diary)
       
    }//end clinical_diary_process()
	
	
	// Start - public function get_clinical_diary_details()
	public function get_clinical_diary_details($clinical_diary_id =''){
		
		
		if($clinical_diary_id){
			$data['get_clinical_diary_details'] = $this->clinical->get_clinical_diary_details($clinical_diary_id);
			
			 //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('clinical_log/clinical_diary_details',$data);
		}

	} // End - public function get_clinical_diary_details()
	
	
	// Start - public function get_clinical_errors_details()
	public function get_clinical_errors_details($clinical_errors_id =''){
		
			if($clinical_errors_id){
				
			$data['get_clinical_errors_details'] = $this->clinical->get_clinical_errors_details($clinical_errors_id);
			
			 //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('clinical_log/clinical_error_details',$data);
		}

	} // End - public function get_clinical_errors_details()
	
	
	// Start - public function get_clinical_self_care_details()
	public function get_clinical_self_care_details($clinical_self_care_id =''){
		
		
		if($clinical_self_care_id){
			$data['get_clinical_self_care_details'] = $this->clinical->get_clinical_self_care_details($clinical_self_care_id);
			
			 //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('clinical_log/clinical_self_care_details',$data);
		}

	} // End - public function get_clinical_self_care_details()
	
	 // Start => function clinical_common_pdf()
	public function clinical_common_pdf($tab_id = ''){
		
		if($tab_id ==1){
		
			$data['list_cl_diary'] = $this->clinical->list_cl_diary($this->session->id,$this->session->pharmacy_surgery_id);
		
		} else if($tab_id ==2){
		
			$data['list_cl_errors'] = $this->clinical->list_cl_errors($this->session->id,$this->session->pharmacy_surgery_id);
		
		}else if($tab_id ==3) {
		
			$data['list_cl_date_checking'] = $this->clinical->list_cl_date_checking($this->session->id,$this->session->pharmacy_surgery_id);
		
		}  else if($tab_id ==4) {
		
			$data['list_cl_cleaning'] = $this->clinical->list_cl_cleaning($this->session->id,$this->session->pharmacy_surgery_id);
		
		} else if($tab_id ==5) {
		
			$data['list_cl_recalls'] = $this->clinical->list_cl_recalls($this->session->id,$this->session->pharmacy_surgery_id);
		
		}  else if($tab_id ==6) {
		
			$data['list_cl_responsible_pharmacist'] = $this->clinical->list_cl_responsible_pharmacist($this->session->id,$this->session->pharmacy_surgery_id);
		
		}  else if($tab_id ==7) {
		
			$data['list_cl_maintenance'] = $this->clinical->list_cl_maintenance($this->session->id,$this->session->pharmacy_surgery_id);
		
		}  else if($tab_id ==8) {
		
			$data['list_cl_self_care'] = $this->clinical->list_cl_self_care($this->session->id,$this->session->pharmacy_surgery_id);
		
		}
		
		$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pharmacy_surgery_id);
		$data['pharmacy_details'] = $get_pharmacy_details;
		
		$data['tab_id'] = $tab_id;

		$file_name = 'clinical_log.pdf';

		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		
		$html = $this->load->view('clinical_log/clinical_common_pdf',$data,true);

        $pdf->SetFooter('Voyager Medical'.'|{PAGENO}|'.date('D, d M y G:i:s')); // Add a footer for good measure            
        $pdf->AddPage('L'); // L - P

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can

	} // Start => function clinical_common_pdf()
	
	
	
	// complaints form process
	public function resolve_process($id = '',$action_by = '', $tab_id = ''){
		

            $resolve = $this->clinical->resolve_maintenance($id,$action_by, $tab_id, $this->session->id);
						
            if($resolve){
				
				if($tab_id ==5){
    
               		 $this->session->set_flashdata('ok_message', 'Action taken  successfully.');
				
				} else {
					 $this->session->set_flashdata('ok_message', 'Issue resolved  successfully.');
				}
				
				if($tab_id ==5){
					
				  redirect(SURL.'clinical-log?t=5');
					
				} else {
				  redirect(SURL.'clinical-log?t=7');	
				}
				
               
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
               if($tab_id ==5){
					
				  redirect(SURL.'clinical-log?t=5');
					
				} else {
				  redirect(SURL.'clinical-log?t=7');	
				}	
    
            }//end 
       
    }//end add_complaint_process()
	
	
	 // Start => function responsible_pdf()
	public function responsible_pdf($tab_id = ''){
		
		if($tab_id ==6){
		
			$data['get_user_details'] = $this->users->get_user_details($this->session->id);
		}
		
		$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pharmacy_surgery_id);
		$data['pharmacy_details'] = $get_pharmacy_details;
		
		$data['tab_id'] = $tab_id;

		$file_name = 'Responsible_pharmacist.pdf';

		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		
		$html = $this->load->view('clinical_log/responsible_pharmacist',$data,true);

        $pdf->SetFooter('Voyager Medical'.'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure            
        $pdf->AddPage('L'); // L - P

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can

	} // Start => function responsible_pdf()
	
	
		
	// Start - public function get_date_checking_details()
	public function get_date_checking_details($id =''){
		
		if($id){
			$data['get_date_checking_details'] = $this->clinical->get_details_date_checking($id);
			
			 //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('clinical_log/date_checking_details',$data);
		}

	} // End - public function get_date_checking_details()
	
	// Start - public function get_cleaning_details()
	public function get_cleaning_details($id =''){
		
		if($id){
			$data['get_cleaning_details'] = $this->clinical->get_cleaning_details($id);
			
			 //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('clinical_log/cleaning_details',$data);
		}

	} // End - public function get_cleaning_details()
	
	
	// Start - public function get_recalls_details()
	public function get_recalls_details($id =''){
		
		if($id){
			$data['get_recalls_details'] = $this->clinical->get_recalls_details($id);
			
			 //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('clinical_log/recalls_details',$data);
		}

	} // End - public function get_cleaning_details()
	
	public function update_checkout_time_process(){
		
		if( !$this->input->post() && !$this->input->post('checkout_id') ) redirect(SURL.'dashboard');
		
		extract($this->input->post());
		
		$update_checkout_time = $this->clinical->update_checkout_time($this->session->pharmacy_surgery_id, $this->input->post());
		
		if($update_checkout_time){
			
			$this->session->set_flashdata('ok_message', 'Checkout time udpdated successfully.');
			redirect(SURL.'clinical-log?t=6');
    
		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'clinical-log?t=6');
			
		}//end if($update_checkout_time)
		
	}//end update_checkout_time_process()
	
	
	// Start => add_edit_area()
	public function add_edit_area(){
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('clinical_log/add_edit_area',$data);
	} // End - public function add_edit_entry()
	
	// Add area process
	public function add_edit_area_process(){
		

        if( !$this->input->post() && !$this->input->post('add_area_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	$add_edit_area = $this->clinical->add_edit_area($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
				 redirect(SURL.'clinical-log?t=4');	
			}
			
            if($add_edit_area){
    
                $this->session->set_flashdata('ok_message', 'Area added successfully.');
                 redirect(SURL.'clinical-log?t=4');	
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Area already exist.Please try another one');
                 redirect(SURL.'clinical-log?t=4');	
    
            }//end if($add_edit_clinical_diary)
       
    }//end clinical_diary_process()
	
	

}/* End of file */
