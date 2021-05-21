<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_book extends MY_Organization_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// Security Check: Verify if the user still belongs to the selected pharmacy_surgery_id
        if($this->session->pharmacy_surgery_id){
            check_if_user_exist_in_pharmacy($this->session->id, $this->session->pharmacy_surgery_id);
        } // if($this->session->pharmacy_surgery_id)

		if(!$this->session->is_owner){
			
			//This section is inly allowed to owner and those who have passed the governance
						
			if(!$this->allowed_user_menu['show_contact_book']){
				$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
				redirect(SURL.'dashboard');
			}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
			
		}//end if(!$this->session->is_owner)
		
		$this->load->model('Contact_book_mod','contactbook');
        
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
		
		
		$data['list_cb_sign_post_log_private'] = $this->contactbook->list_cb_sign_post_log_private($this->session->id,$this->session->pharmacy_surgery_id);
		
		// Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('Contact Book', base_url().'organization/dashboard');
		 
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
		
		$data['contact_list'] = $this->contactbook->contact_bool_list($this->session->pharmacy_surgery_id);
        
        // Date display
		$this->stencil->css('datepicker.css');
		$this->stencil->js('date-time/bootstrap-datepicker.js');
		$this->stencil->js('date-time/custom_datepicker.js');
		
		$this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
      
        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('contact_book/contact_book',$data);

	} // End => function index()
	
	
	// Add contact book sign post process
	public function contact_book_sign_post_process(){
		

        if( !$this->input->post() && !$this->input->post('add_clinical_diary_btn') ) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
		// Pharmacy id not empty 
		if($this->session->pharmacy_surgery_id !=''){
			    
          $add_edit_contact_book_sign_post = $this->contactbook->add_edit_contact_book_sign_post($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
		
		} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
				 redirect(SURL.'contact-book?t=2');	
			}
			
            if($add_edit_contact_book_sign_post){
    
                $this->session->set_flashdata('ok_message', 'Contact book sign post log added successfully.');
                redirect(SURL.'contact-book?t=2');		
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'contact-book?t=2');		
    
            }//end if($add_edit_contact_book_sign_post)
       
    }//end contact_book_sign_post_process()
	
	// Start - function search_contacts()
	public function search_contacts(){

		// Verify : is valid request
		if(!$this->input->post())
			redirect(SURL.'dashboard');
		// if($this->input->post())

		$search_query = $this->input->post('search_query');
		 
		 //$this->session->my_pharmacy_id
		
		$response = $this->contactbook->search_contacts($search_query,$this->session->pharmacy_surgery_id);
		if($response)
			echo json_encode($response);
		else
			echo 'empty';
		// if($response)

	} // End - function search_contacts()
	
	// Start - public function add_edit()
	public function add_edit($element_id='', $contact_id=''){
		
		$c_id = explode("list-id", $contact_id);
		
		if($c_id[0] !="")
		{
			$contact_id = $c_id[0];
			
		} else if($c_id[1] !='') {
			
			$contact_id =$c_id[1];
		}
		
		$data['element_id'] = $element_id;

		// Verify : add OR edit
		if($this->input->post || $contact_id!=''){
			
			//$this->session->my_pharmacy_id, 
			
			// Update
			$data['contacts-book'] = $this->contactbook->get_contact_book_details($contact_id,$this->session->pharmacy_surgery_id);
		
			// Update New
			$this->stencil->layout('pgd_detail_ajax_template'); 
			$this->stencil->paint('contact_book/add_edit', $data);

		} else {

			// Add New
			$this->stencil->layout('pgd_detail_ajax_template'); 
			$this->stencil->paint('contact_book/add_edit', $data);

		} // if($this->input->post || $contact_id!='')

	} // End - public function add_edit()
	
	public function add_edit_contact_book_process_ajax($update_contact_id=''){
				
		if(!$this->input->post()) redirect(base_url());
		
		// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
                $add_edit_success_contact = $this->contactbook->add_edit_contact_book($this->input->post(), $update_contact_id, $this->session->pharmacy_surgery_id, $this->session->id);
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'contact-book');
			}
           
		
		// add_edit_success_contact
		if($add_edit_success_contact){
			
			if($update_contact_id){

				$response['error'] = false;
				$response['message'] = 'Contact record was successfully updated.';
				$response['data'] = $add_edit_success_contact;

			} else {

				$response['error'] = false;
				$response['message'] = 'New contact added successfully.';
				$response['data'] = $add_edit_success_contact;

			} // if($update_contact_id)

		} else {

			$response['error'] = true;
			$response['message'] = 'Oops! Something went wrong. Try again later.';
			$response['data'] = 'empty';

		} // End else - if($add_edit_success_contact)

		echo json_encode($response);

	} //end public function add_edit_contact_process_ajax($update_contact_id='')
	
	// Function to get load_search_contact_book_list
	public function load_search_contact_book_list(){
		
		if(!$this->input->post())
			redirect(SURL.'dashboard');
		// if($this->input->post())

		$search_query = $this->input->post('search_query');
		 
		 //$this->session->my_pharmacy_id
		
		if($this->session->pharmacy_surgery_id!=''){
			
			$data['contact_list'] = $this->contactbook->search_contacts($search_query,$this->session->pharmacy_surgery_id);
	    }
		
		$this->stencil->layout('contact_book_detail_ajax_template'); 
		
		echo $this->stencil->paint('contact_book/contact_book_list', $data);
		// if($response)

	} // End => function load_search_drugs_list()
	
	
	 // Start => function contact_book_sign_post_pdf()
	public function contact_book_sign_post_pdf($tab_id = ''){
		
		if($tab_id ==1){
		
			$data['list_cb_sign_post_log_private'] = $this->contactbook->list_cb_sign_post_log_private($this->session->id,$this->session->pharmacy_surgery_id);
		
		} 
		
		$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pharmacy_surgery_id);
		$data['pharmacy_details'] = $get_pharmacy_details;
		
		$data['tab_id'] = $tab_id;

		$file_name = 'contac_book_sign_post_log.pdf';

		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		
		$html = $this->load->view('contact_book/contact_book_sign_post_log_pdf',$data,true);

        $pdf->SetFooter('Voyager Medical'.'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure            
        $pdf->AddPage('L'); // L - P

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can

	} // Start => function contact_book_sign_post_pdf()
	
	// Print contact book data
	public function contact_book_pdf (){
		
		$data['contact_list'] = $this->contactbook->contact_bool_list($this->session->pharmacy_surgery_id);
		
		$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pharmacy_surgery_id);
		$data['pharmacy_details'] = $get_pharmacy_details;
		
		$file_name = 'contact_book.pdf';

		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		
		$html = $this->load->view('contact_book/contact_book_pdf',$data,true);

        $pdf->SetFooter('Voyager Medical'.'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure            
        $pdf->AddPage('L'); // L - P

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can
		
	} // end contact_book_pdf()


	
}/* End of file */
