<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Practice_leaflet extends MY_Organization_Controller {

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
		$this->breadcrumbcomponent->add('Practice Leaflet', base_url().'organization/dashboard');
		
		// Get page CMS page contents
		$data['ccg_details'] = $this->cms->get_cms_page('contact-details-of-the-local-ccg');
				
		// Get page CMS page contents
		$data['other_details'] = $this->cms->get_cms_page('other-services-we-provide');
		
		// Get page CMS page contents
		$data['nhs_details'] = $this->cms->get_cms_page('nhs-services-we-provide');
		
		 
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
		
      	// Time display
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');
		// Date display
		$this->stencil->css('datepicker.css');
		$this->stencil->js('date-time/bootstrap-datepicker.js');
		$this->stencil->js('date-time/custom_datepicker.js');
		
        
        // Include dataTables js and css
		// here

        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('practice_leaflet/practice_leaflet',$data);

	} // End => function index()
	
	// Start => function download_pdf_practice_leaf_pdf()
	public function download_pdf_practice_leaf_pdf(){

		// Process : Get Practice Leaf List
		$practice_leaft_list = $this->input->post();
		
		$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pharmacy_surgery_id);
		$data['pharmacy_details'] = $get_pharmacy_details;
		
		$data['practice_leaft_list'] = $practice_leaft_list;
		$data['total'] = count($practice_leaft_list);

		$file_name = 'practice_leaf.pdf';

		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		
		$html = $this->load->view('practice_leaflet/pdf_practice_leaflet',$data,true);
		

      /* $pdf->SetFooter('Voyager Medical'.'|{PAGENO}|'.date('D, d M y G:i:s')); */// Add a footer for good measure                 
        //$pdf->AddPage('L'); // L - P

			$pdf->AddPageByArray(
					array(
						'orientation' => 'L',
						'mgl' => '20',
						'mgr' => '20',
						'mgt' => '5',
						'mgb' => '10',
						'mgh' => '0',
						'mgf' => '0', 
					)
				);
		

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can

	} // Start => function download_pdf_practice_leaf_pdf()
}

/* End of file */
