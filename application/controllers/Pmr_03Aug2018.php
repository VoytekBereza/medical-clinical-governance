<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pmr extends MY_Organization_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load models
		$this->load->model('cms_mod', 'cms');

		// Security Check: Verify if the user still belongs to the selected pharmacy_surgery_id
        if($this->session->pmr_pharmacy_surgery_id){
            check_if_user_exist_in_pharmacy($this->session->id, $this->session->pmr_pharmacy_surgery_id);
        } // if($this->session->pharmacy_surgery_id)
		
		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
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
		
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');

		// Js file using for CMS page validation
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation_2.min.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');
        // end CMS file Validation

		if(!$this->allowed_user_menu['show_pmr']) redirect(SURL.'organization/dashboard'); //Is PMR is Disabled!

	} // public function __construct()

	public function index($show_all_records=''){
		
        // Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('PMR', base_url().'pmr');
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		if(($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3)){ 
			
			extract( $this->input->post() );
			
			///////////////////////////////////////////////////////
			// Get ORGANIZATION [ Medicine - Vaccine ] Transactions
	
			// Get PMR data from the database
	
			// $this->session->id
			// $this->session->user_type
			// $this->session->is_prescriber
			// $this->session->show_pmr
			// $this->session->organization_id
			// $this->session->pharmacy_surgery_id

			// Get PMR Organization and Pharamcies List
			//$get_default_prescriber_organization_list = $this->pmr->get_pmr_organization_pharmacy_list($this->session->id, $this->session->organization_id);
			
			//echo $this->session->pharmacy_surgery_id.' - '.$this->session->organization_id;
			//echo '<br><br><br>';
			//print_this($get_default_prescriber_organization_list);
			//exit;

			$data['default_prescriber_organization_list'] = $get_default_prescriber_organization_list;

			if($this->input->post() || $this->session->pmr_organization_id){
				
				//if( $this->input->post() ){

					// O|organization_id OR P|pharmacy_id|organization_id

					if($pmr_org_pharmacy)
						$this->session->pmr_org_pharmacy = $pmr_org_pharmacy;
					elseif($this->session->pmr_org_pharmacy)
						$pmr_org_pharmacy = $this->session->pmr_org_pharmacy;
					// if($pmr_org_pharmacy)

					$pmr_org_pharmacy_arr = explode('|', $this->session->pmr_org_pharmacy);
					
					if($pmr_org_pharmacy_arr[0] == 'O'){
						
						//User is a default prescriber in an organization
						$organization_id = $pmr_org_pharmacy_arr[1];
						$this->session->pmr_organization_id = $organization_id;

						$is_default = $this->pmr->get_default_prescriber_organization_list($this->session->id, $this->session->pmr_organization_id);

						if($is_default || $this->session->system_prescriber){

							// Pending List Online and PMR both
							$pending_transaction_list = $this->pmr->get_organization_transactions($organization_id,'','','P','', 'M','', $show_all_records);
						
							// Pending Vaccine List Online and PMR both
							$vaccine_pending_transaction_list = $this->pmr->get_organization_transactions($organization_id,'','','P','', 'V','', $show_all_records);
						} // if($is_default)

						if($this->input->post('org_pharmacy_surgery')){
							$pharmacy_surgery_id = $this->input->post('org_pharmacy_surgery');
							$this->session->pmr_pharmacy_surgery_id = $pharmacy_surgery_id;
						} // if(!$this->session->pmr_pharmacy_surgery_id)
						
					} else if ($pmr_org_pharmacy_arr[0] == 'P'){
						
						//User is a Staff Member in a Pharmacy
						$pharmacy_surgery_id = $pmr_org_pharmacy_arr[1];
						$organization_id = $pmr_org_pharmacy_arr[2];

						$this->session->pmr_organization_id = $organization_id; // Set Organization ID to session for PMR
						$this->session->pmr_pharmacy_surgery_id = $pharmacy_surgery_id; // // Set Pharmacy / Surgery ID to session for PMR
						
					}//end if($pmr_org_pharmacy_arr[0] == 'O')

				//} // if( !$this->input->post() )

				$data['pending_transaction_list'] = $pending_transaction_list;
				$data['vaccine_pending_transaction_list'] = $vaccine_pending_transaction_list;
				
				// Current pending_transaction_list_all
				$pending_transaction_list_all = $this->pmr->get_organization_transactions_all_request($this->session->pmr_organization_id,'','','P','', 'M','', $show_all_records);
				$data['pending_transaction_list_all'] = $pending_transaction_list_all;

				$vaccine_pending_transaction_list_all = $this->pmr->get_organization_transactions_all_request($this->session->pmr_organization_id,'','','P','', 'V','', $show_all_records);
				$data['vaccine_pending_transaction_list_all'] = $vaccine_pending_transaction_list_all;

				// For Pharamcist Only/ Dispense and Current + Complete Deliveries
				if($this->session->user_type == 2){
					//Dispense Deliveries
					$dispense_transaction_list = $this->pmr->get_organization_transactions($this->session->pmr_organization_id,$this->session->pmr_pharmacy_surgery_id,'','DS','', 'M','',$show_all_records);
					$data['dispense_transaction_list'] = $dispense_transaction_list;
					
					// //Dispense dispense_transaction_list_all
					$dispense_transaction_list_all = $this->pmr->get_organization_transactions_all_request($this->session->pmr_organization_id,$this->session->pmr_pharmacy_surgery_id,'','DS','', 'M','',$show_all_records);
					$data['dispense_transaction_list_all'] = $dispense_transaction_list_all;

					// Current Deliveries_all
					$current_deliveries_list_all = $this->pmr->get_organization_transactions_all_request($this->session->pmr_organization_id,$this->session->pmr_pharmacy_surgery_id,'','C','', 'M','',$show_all_records);
					$data['current_deliveries_list_all'] = $current_deliveries_list_all;
					
					// Current Deliveries
					$current_deliveries_list = $this->pmr->get_organization_transactions($this->session->pmr_organization_id,$this->session->pmr_pharmacy_surgery_id,'','C','', 'M','',$show_all_records);
					$data['current_deliveries_list'] = $current_deliveries_list;
					
				} // end if($this->session_user_type == 2)
				
			} // end if($this->input->post())

			//load main Dashbaord template for DOCTOR
			//set title
			//$page_title = $page_data['page_title'];
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));
	
			$this->stencil->layout('dashboard_template'); //dashboard_template
			$this->stencil->js('pmr_dashboard.js');

			$this->stencil->css('jquery.fancybox.css');
			$this->stencil->js('jquery.fancybox.js');

			// Script for print
			$this->stencil->js('jquery.PrintArea.js');

			$this->stencil->js('org_dashboard.js');

			if($show_all_records)
				$this->stencil->paint('pmr/pending_transactions',$data);
			else
				$this->stencil->paint('pmr/pmr',$data);
			// if($show_all_records)

		} else {
			redirect(base_url().'dashboard');	
		}

	} //end index()
	
	// Veiw all pending current and dispense request
	public function view_all_requests($order_status=''){
		
		 // Bread crumb 
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 $this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 $this->breadcrumbcomponent->add('PMR', base_url().'pmr');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		if(($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3)){ 
			
			extract( $this->input->post() );
			
			// Get PMR Organization and Pharamcies List
			$get_default_prescriber_organization_list = $this->pmr->get_pmr_organization_pharmacy_list($this->session->id);
			
			$data['default_prescriber_organization_list'] = $get_default_prescriber_organization_list;
			
			if($this->input->post() || $this->session->pmr_organization_id){

				if( $this->input->post() ){
					
					// O|organization_id OR P|pharmacy_id
					$this->session->pmr_org_pharmacy = $pmr_org_pharmacy;

				} // if( !$this->input->post() )

				$pmr_org_pharmacy_arr = explode('|',$this->session->pmr_org_pharmacy);

				if($pmr_org_pharmacy_arr[0] == 'O'){
					
					//User is a default prescriber in an organization
					$organization_id = $pmr_org_pharmacy_arr[1];
					$this->session->pmr_organization_id = $organization_id;

					//Pending List Online and PMR both
					$pending_transaction_list = $this->pmr->get_organization_transactions_all_request($organization_id,'','',$order_status,'', 'M','', $show_all_records);

					// Vaccine Pending List Online and PMR both
					$vaccine_pending_transaction_list = $this->pmr->get_organization_transactions_all_request($organization_id,'','',$order_status,'', 'V','', $show_all_records);

					$pharmacy_surgery_id = $this->input->post('org_pharmacy_surgery');
					$this->session->pmr_pharmacy_surgery_id = $pharmacy_surgery_id;

				} else if ($pmr_org_pharmacy_arr[0] == 'P'){
					
					//User is a Staff Member in a Pharmacy
					$pharmacy_surgery_id = $pmr_org_pharmacy_arr[1];
					$organization_id = $pmr_org_pharmacy_arr[2];

					$this->session->pmr_organization_id = $organization_id; // Set Organization ID to session for PMR
					$this->session->pmr_pharmacy_surgery_id = $pharmacy_surgery_id; // // Set Pharmacy / Surgery ID to session for PMR
					
				}//end if($pmr_org_pharmacy_arr[0] == 'O')

				$data['pending_transaction_list'] = $pending_transaction_list;
				//For Pharamcist Only/ Dispense and Current + Complete Deliveries
				if($order_status == 'DS'){

					//Dispense Deliveries
					$dispense_transaction_list = $this->pmr->get_organization_transactions_all_request($organization_id,$pharmacy_surgery_id,'','DS','', 'M','',$show_all_records);
					$data['dispense_transaction_list'] = $dispense_transaction_list;
				} else if($order_status=='C') {
					// Current Deliveries
					$current_deliveries_list = $this->pmr->get_organization_transactions_all_request($organization_id,$pharmacy_surgery_id,'','C','', 'M','',$show_all_records);
					$data['current_deliveries_list'] = $current_deliveries_list;
					
				} // end if($this->session_user_type == 2)
				
			} // end if($this->input->post())

			//load main Dashbaord template for DOCTOR
			//set title
			//$page_title = $page_data['page_title'];
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));
	
			$this->stencil->layout('dashboard_template'); //dashboard_template
			
			$this->stencil->js('pmr_dashboard.js');

			$this->stencil->css('jquery.fancybox.css');
			$this->stencil->js('jquery.fancybox.js');

			// Script for print
			$this->stencil->js('jquery.PrintArea.js');
	
			 // Datatables
            $this->stencil->js('datatables/js/jquery.dataTables.js');
            $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
    
            // Load custom file data_tables.js
            $this->stencil->js('kod_scripts/data_tables.js');
            $this->stencil->css('kod_css/jquery.dataTables.min.css');
			
	
		    $this->stencil->paint('pmr/view_all_requests',$data);
			// if($show_all_records)

		} else {
			redirect(base_url().'dashboard');	
		}

	} //end index()
	
	public function patient_dashboard($patient_id, $order_id='', $vaccine_type=''){
		
		// Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('PMR', base_url().'pmr');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		if($patient_id == '')
			redirect(base_url().'dashboard');

		if($order_id != ''){

			// Get patient_id and pharmacy_surgery_id by ORDER_ID
			$order_details = $this->pmr->get_patient_order_item_details($order_id, $patient_id);

			$patient_order_id = $order_details['order_id'];

			// Verify is the loggedin user is default prescriber : If yes then show pending transactions to be Approved
			// 1 - $order_details['pharmacy_surgery_id'] => 21
			// 2 - $order_details['organization_id'] => 13

			$is_default = $this->pmr->get_default_prescriber_organization_list($this->session->id, $this->session->pmr_organization_id);

			if($is_default || $this->session->system_prescriber){

				$pharmacy_surgery_id = $order_details['pharmacy_surgery_id'];

				if($order_details['order_status'] == 'P'){
					
					$data['is_online'] = 1;
					$is_online = 1;

				} // if($order_details['order_status'] == 'P')

				$data['order_status'] = $order_details['order_status'];
				$order_status = $order_details['order_status'];

			} // if($is_default)
			
		} // if($order_id != '')

		// Get patient data according
		$patient_data = $this->pmr->get_patient_details($patient_id);

		$data['patient_data'] = $patient_data;
		$this->session->previous_patient_id = filter_string($patient_data['id']);
		$this->session->previous_patient_name = ucwords(filter_string($patient_data['first_name']).' '.filter_string($patient_data['last_name']));
		
		// Verify valid Patient request
		if(!$data['patient_data'])
			redirect(base_url().'dashboard');
		
		$patient_history = $this->pmr->get_patient_grouped_history($patient_id, 'C');
		$data['patient_history'] = $patient_history;
		
		$patient_vaccine_history = $this->pmr->get_patient_grouped_vaccine_history($patient_id);
		$data['patient_vaccine_history'] = $patient_vaccine_history;
		
		if($this->session->is_prescriber && $this->session->is_prescriber == 1){
			$data['free_type'] = 1;
		} // if($this->session->is_prescriber && == $this->session->is_prescriber == 1)

		// GET Category RAF for Walkin PGD
		$data['catefory_rafs'] = $this->medicine->get_all_category_rafs();

		//print_this($data['catefory_rafs']);
		//exit;

		// Set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));

		$this->stencil->js('org_dashboard.js');
		$this->stencil->js('pmr_dashboard.js');
		$this->stencil->css('jquery.fancybox.css');
		$this->stencil->js('jquery.fancybox.js');

		// Script for print
		$this->stencil->js('jquery.PrintArea.js');
		
		if($pharmacy_surgery_id == '')
			$pharmacy_surgery_id = $this->session->pmr_pharmacy_surgery_id;
		// if($pharmacy_surgery_id == '')

		$patient_in_same_ps = $this->pmr->get_patient_pharmacies_list($patient_id, $pharmacy_surgery_id);
		$data['patient_in_same_ps'] = $patient_in_same_ps;


		if(!$patient_in_same_ps){

			$cms_data_arr = $this->cms->get_cms_page('merge-medical-record');
			
			$data['merge_error_cms'] = $cms_data_arr['cms_page_arr'];
			$data['patient_in_other_ps'] = $this->pmr->get_patient_pharmacies_list($patient_id);
		} // if(!$patient_in_same_ps)
		
		// if(!$patient_in_same_ps)

		if($is_online == 1 && $order_status == 'P'){

			//$data['patient_pending_transactions'] = $this->pmr->get_organization_transactions($this->session->pmr_organization_id, '', $patient_id, 'P', '', '', '', 'M', 1);

			// Get all Pending transactions : Group by OrderID
			// Get order_id by order_detail_id

			$data['patient_pending_transactions'] = $this->pmr->get_organization_transactions($this->session->pmr_organization_id, '', $patient_id, 'P', '', 'M', 'ONLINE', '', $patient_order_id);

		} // end if($is_online == 1)

		if($order_status == 'DS'){

			//Dispense Deliveries
			$show_all_records = 1;
			$dispense_transaction_list = $this->pmr->get_organization_transactions($this->session->pmr_organization_id, $this->session->pmr_pharmacy_surgery_id,'','DS','', 'M','',$show_all_records);
			$data['dispense_transaction_list'] = $dispense_transaction_list;

		} // if($order_status == 'DS')

		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

        // Load custom file data_tables.js
        $this->stencil->js('kod_scripts/data_tables.js');
        $this->stencil->css('kod_css/jquery.dataTables.min.css');

        // Time display
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');

       
		// Js Form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');

        // $this->stencil->js('kod_scripts/data_tables.js');

        $data['vaccine_type'] = $vaccine_type;

		$this->stencil->layout('dashboard_template'); //dashboard_template
		//load main Dashbaord template for DOCTOR
		$this->stencil->paint('pmr/patient_dashboard',$data);
		
	} // public function patient_dashboard($patient_id='')

	// Start - public function patient_medicine_history()
	public function patient_medicine_history($patient_id, $medicine_id, $order_status = '', $is_online='', $is_pmr = ''){
		
		//$data['medicine'] = $this->medicine->get_medicine_by('', $medicine_id); // Get medicine by medicine ID
		/*		
		if($is_pmr)
			$patient_grouped_history = $this->pmr->get_patient_grouped_history($patient_id, 'C', '', $medicine_id);
		else
			$patient_grouped_history = $this->pmr->get_patient_grouped_history($patient_id, 'C', $medicine_id, '');
		
		$data['medicine'] = $patient_grouped_history;
		*/
		if($this->session->is_prescriber && $this->session->is_prescriber == 1){
			$data['free_type'] = 1;
		} // if($this->session->is_prescriber && == $this->session->is_prescriber == 1)

		$data['is_online'] = $is_online;
		$patient_history = $this->pmr->get_patient_history($patient_id, $order_status, $medicine_id, $is_pmr);
		
		//print_this($patient_history); 		exit;
		
		$data['patient_history'] = $patient_history;

		$this->stencil->layout('ajax_with_scripts'); //ajax
		$this->stencil->paint('pmr/medicine_history', $data);
		
	} // End - public function patient_medicine_history()

	// Start - public function patient_vaccine_history()
	public function patient_vaccine_history($patient_id, $vaccine_cat_id){
		
		$patient_vaccine_history = $this->pmr->get_patient_vaccine_history($patient_id,$vaccine_cat_id);
		
		$data['patient_vaccine_history'] = $patient_vaccine_history;
		
		$this->stencil->layout('ajax_with_scripts'); //ajax
		$this->stencil->paint('pmr/vaccine_history', $data);
		
	} // End - public function patient_vaccine_history()
	
	// Search Patients
	public function search_patient(){
		
		//If Post is not SET
		if(!$this->input->post()) redirect(base_url());
		
		$data['list_search_patient'] = $this->pmr->search_patient($this->input->post());
		
		echo $this->load->view('pmr/auto_search_patient',$data,true);
			
	}// end search_patient();
	
	// Function add_edit_patient($last_name='')
	public function add_edit_patient($last_name=''){
		
		if($last_name){
			$last_name = urldecode($last_name);
		} // if($last_name)

		 // Bread crumb 
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 $this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 $this->breadcrumbcomponent->add('PMR', base_url().'pmr');
		 $this->breadcrumbcomponent->add('Add New Patient', base_url().'pmr/add-edit-patient');
		
		 // Bread crumb output
		 $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		//set title
		//$page_title = $page_data['page_title'];
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
		
		$this->stencil->layout('dashboard_template'); //dashboard_template
		
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		
		// Js Form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');
		
		$this->stencil->js('pmr_dashboard.js');

		$data['last_name'] = $last_name;

		//load main Dashbaord template for DOCTOR
		$this->stencil->paint('pmr/add_edit_patient',$data);

	} //end add_edit_patient($last_name='')
	
	// Start Function add_edd_patient_process
	public function add_edit_patient_process(){

		if(!$this->input->post() && !$this->input->post('add_edit_patient_btn')) redirect(base_url());
		
		$add_edit_success_patient = $this->pmr->add_edit_patient($this->input->post(), $this->session->pmr_pharmacy_surgery_id, $this->session->pmr_organization_id);
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		if($this->input->post('update_patient_id')==""){
		$this->form_validation->set_rules('email_address_patient', 'Email', 'trim|required|valid_email');
		}
		$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('postcode', 'Post Code', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('birth_date', 'Day', 'trim|required');
		$this->form_validation->set_rules('birth_month', 'Month', 'trim|required');
		$this->form_validation->set_rules('birth_year', 'Year', 'trim|required');			
		if($this->form_validation->run() == FALSE){
			
			// session set form data in fields
			$this->session->set_flashdata($this->input->post());
			// PHP Error 
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'organization/pmr/add-edit-patient');
			
		} else {

			// add_edit_success_patient
			if($add_edit_success_patient){
	
				if($this->input->post('update_patient_id')){
	
					$this->session->set_flashdata('ok_message', 'Patient record was successfully updated.');
					redirect(SURL.'pmr/patient-dashboard/'.$this->input->post('update_patient_id'));				
	
				} else {
	
					$this->session->set_flashdata('ok_message', 'Patient added successfully.');
					redirect(SURL.'pmr/patient-dashboard/'.$add_edit_success_patient);
	
				} // if($this->input->post('update_patient_id'))
	
			} else {
	
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect(SURL.'organization/pmr/add-edit-patient');
	
			} // End else - if($add_edit_success_patient)
		}
		
	} // add_edd_patient_process()
	
	// Start function: email-exist-patient(): Check if the email already exist or not.
	public function email_exist_patient(){
	
		$result = $this->pmr->verify_if_email_already_exist($this->input->post('email'));
		$response = array('exist' => $result);
		echo json_encode($response);
		
	} // End - email-exist-patient():
	
	public function search_medicine(){
		
		if(!$this->input->post() && !$this->input->post('keywords'))
			redirect(base_url().'dashboard');

		// Load medicine [ medicine_mod ]
		$this->load->model('medicine_mod', 'medicine');
		$medicine = $this->medicine->search_medicine( $this->input->post('keywords') );
		
		if($medicine)
			echo json_encode(array('error' => 0, 'data' => $medicine));
		else
			echo json_encode(array('error' => 1, 'data' => ''));
		// if($medicine)
		
	} // public function search_medicine()
	
	public function search_medicine_custom(){
		
		extract($this->input->post());
		
		$this->load->model('Pmr_mod', 'pmr');
		$medicine = $this->pmr->search_org_medicine($this->session->pmr_organization_id, $keywords);
		
		if($medicine)
			echo json_encode(array('error' => 0, 'data' => $medicine));
		else
			echo json_encode(array('error' => 1, 'data' => ''));
		// if($medicine)
		
	} // public function search_medicine_custom()
	
	public function preview_current_transaction($is_freetype = ''){

		if(!$this->input->post('transaction'))
				redirect(base_url().'dashboard');
		// if(!$this->session->show_pmr || $this->session->show_pmr != 1)

		//if($this->session->user_type == 1 || ($this->session->user_type == 2 && $this->session->is_prescriber == 1) || ($this->session->user_type == 3 && $this->session->is_prescriber == 1) )
			
		$data['is_freetype'] = $is_freetype;
		
		$data['patient_details'] = $this->pmr->get_patient_details($this->input->post('patient_id'));
		
		$order_details_id = $this->input->post('order-detail-id');
		$order_details = $this->pmr->get_patient_order_details($order_details_id);
		$data['order_details'] = $order_details;
		
		//print_this($order_details);  			exit;

		if($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3 ){
			
			if(($order_details['order_status'] == 'DS' || $order_details['order_status'] == 'C') && $order_details['order_type'] == 'ONLINE'){
				
				$get_user_details = $this->users->get_user_details($order_details['prescribed_by']);
				$data['registration_type'] = filter_string($get_user_details['registration_type']);
				$data['user_signatures'] = $this->users->get_user_signatures($get_user_details['id']);
				
				if($order_details['default_prescriber']){
					//This order is apprived by Default prescriber so we have to use the address of the default prescriber

					$prescriber_organization = $this->organization->get_my_organizations($order_details['prescribed_by']);
					$data['prescriber_organization'] = $prescriber_organization[0];
					
				}//end if($order_details['default_prescriber'])
				
			}else if(($order_details['order_status'] == 'DS' || $order_details['order_status'] == 'C') && $order_details['order_type'] == 'PMR'){
				
				$get_user_details = $this->users->get_user_details($order_details['prescribed_by']);
				$data['registration_type'] = filter_string($get_user_details['registration_type']);
				$data['user_signatures'] = $this->users->get_user_signatures($get_user_details['id']);
				
			}else{

				$data['prescriber_full_name'] = $this->session->full_name;
				$data['registration_type'] = $this->session->registration_type;
				$data['prescriber_email_address'] = $this->session->email_address;
				
				$data['registration_number'] = $this->session->registration_no;
				$data['user_signatures'] = $this->users->get_user_signatures($this->session->id);
				
			}//end if($order_details['order_status'] == 'DS' && $order_details['order_type'] == 'ONLINE')

			$data['organization_details'] = $this->organization->get_organization_details($this->session->pmr_organization_id);
			$data['pharmacy_surgery_details'] = $this->pharmacy->get_pharmacy_surgery_details($this->session->pmr_pharmacy_surgery_id);
			
		} // if($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3 )

		// Medication Details
		$data['medication_details'] = $this->input->post();
		
		// Verify if the request is from the Current transaction
		if( $this->input->post('approve-transaction') ){
			$data['show_decline'] = 1;
		} // if( $this->input->post('dispense-transaction') )

		if( $this->input->post('view-current-delivery') ){
			$data['view_current_delivery'] = 1;
		} // if( $this->input->post('view-current-delivery') )

		// Verify if the request is for dispense
		if( $this->input->post('dispense-transaction') ){
			$data['show_tracking_code'] = 1;
		} // if( $this->input->post('dispense-transaction') )

		// Verify if the request is for dispense
		if( $this->input->post('order-detail-id') ){
			$data['order_detail_id'] = $this->input->post('order-detail-id');
			$data['patient_order_details_arr'] = $this->pmr->get_patient_order_details($this->input->post('order-detail-id'));
		} // if( $this->input->post('order-detail-id') )

		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));

		$this->stencil->layout('dashboard_template'); //dashboard_template
		$this->stencil->js('pmr_dashboard.js');

		//load main Dashbaord template for DOCTOR
		//$this->stencil->paint('pmr/patient_history_preview',$data);
		
		echo $this->load->view('pmr/patient_history_preview',$data, true);
		
	} // public function preview_current_transaction()
	
	public function save_prescription(){

		if(!$this->input->post('prescription-preview-form-searialized-data'))
			redirect(base_url().'dashboard');
		
		// Parse string : unserialize the searialized data
		$prescription = array();
		parse_str($this->input->post('prescription-preview-form-searialized-data'), $prescription);
		
		if($this->input->post('save_approve_request')){
			
			// Verrify if the request is APPROVE
			// Save prescription
			$saved = $this->pmr->mark_transaction_complete($this->input->post('order_detail_id'));

			if($saved){
				$this->session->set_flashdata('ok_message', 'Prescription successfully approved.');
			} else {
				$this->session->set_flashdata('error_message', 'Oops! Something went wrong.');
			} // if($saved)

			// redirect($_SERVER['HTTP_REFERER']);
			redirect(SURL.'organization/pmr');

		} else {

			// Verify is the request is from FREE TYPE
			// Save prescription
			$saved = $this->pmr->save_prescription($this->session->pmr_pharmacy_surgery_id, $this->session->pmr_organization_id, $this->session->id, $prescription, $this->input->post('prescription_no'));

			if($saved){
				$this->session->set_flashdata('ok_message', 'Prescription successfully saved.');
			} else {
				$this->session->set_flashdata('error_message', 'Oops! Something went wrong.');
			} // if($saved)

			redirect(base_url().'pmr/patient-dashboard/'.$prescription['patient_id']);

		} // if($this->input->post('save_approve_request'))
		
	} // public function save_preview()
	
	public function merge_patient_with_pharmacy($patient_id_encoded=''){
		
		if($patient_id_encoded == '')
			redirect(base_url().'dashboard');
		else {
			
			// Decode patient_id
			$patient_id = base64_decode(urldecode($patient_id_encoded));

			// Get patient data
			$patient_data = $this->pmr->get_patient_details($patient_id);
			
			// Verify if patient exist
			if($patient_data){
				$merged = $this->pmr->merge_patient_record_with_pharmacy($patient_id, $this->session->pmr_pharmacy_surgery_id);
				
				if($merged)
					$this->session->set_flashdata('ok_message', 'Patient history successfully merged.');
				else
					$this->session->set_flashdata('error_message', 'Oops! Something went wrong.');
				// if($merged)

				redirect(base_url().'pmr/patient-dashboard/'.$patient_id);
			
			} else
				redirect(base_url().'dashboard');
			// if($patient_data)
				
		} // if($patient_id == '')
		
	} // public function $merge_patient_record_with_pharmacy()

	// Start - public function update_patient_allergies()
	public function update_patient_allergies(){

		if(!$this->input->post()) redirect(SURL);

		$allergies_text = trim($this->input->post('allergies'));
		$patient_id = trim($this->input->post('patient_id'));

		// Update Allergies text into db for this patient [ patient_id ]
		$updated = $this->pmr->update_patient_allergies($allergies_text, $patient_id);

		if($updated)
			echo true;
		else
			echo false;

	} // public function update_patient_allergies()

	// Start - public function view_raf() : Function to get RAF document to be shown on ajax based fancybox popup in Pending PMR/transactions
	public function view_raf($patient_id, $product_type, $medicine_vaccine_id){

		if($product_type == 'M'){
			$data['medicine'] = $this->medicine->get_medicine_by('', $medicine_vaccine_id); // Get medicine by medicine ID to display medicine name of top
			$data['raf'] = $this->pmr->get_patient_medicine_raf($patient_id, $medicine_vaccine_id,''); // Get RAF Document
		}
		else
			$data['raf'] = $this->pmr->get_patient_medicine_raf($patient_id, '', $medicine_vaccine_id);		
		// if($product_type == 'M')
		
		$this->stencil->layout('ajax_with_scripts'); //ajax

		$this->stencil->paint('pmr/view_raf', $data);

	} // end public function view_raf($patient_id, $medicine_vaccine_type, $medicine_vaccine_id)

	// Start - public function dispense_transaction()
	public function dispense_transaction(){

		if(!$this->input->post()) redirect(SURL.'dashboard');

		$updated = $this->pmr->dispense_transaction( $this->input->post() );
		echo $updated;

	} // end public function dispense_transaction()

	// Start - public function decline_transaction()
	public function decline_transaction(){

    	if(!$this->input->post()) redirect(SURL.'dashboard');

		$updated = $this->pmr->decline_transaction( $this->input->post() );
		echo $updated;

	} // end public function decline_transaction()

	// STart - public function download_rx($order_detail_id)
	public function download_rx($order_detail_id){
		
		// Get ORDER DETAILS
		$order_details = $this->pmr->get_order_details($order_detail_id);
		// medicine_name
		// strength
		// suggested_dose
		// quantity
		// medicine_form ----

		// GET PATIENT DETAILS
		$patient_details = $this->pmr->get_patient_details($order_details['patient_id']);
		// first_name
		// last_name
		// email_address
		// dob

		// GET PRESCRIBER DETAILS
		$prescriber_details = $this->users->get_user_details($this->session->id);
		// registration_no		
		
		// GET TEMPLATE BODY
		$preview = $this->pmr->get_rx_download_body($order_detail_id);
		
		$html = filter_string($preview['email_body']);
		
		$html = str_replace("[PRESCRIPTION_NO]", $order_details['prescription_no'], $html);
		$html = str_replace("[MEDICINE_NAME]", $order_details['p_medicine_short_name'], $html);
		$html = str_replace("[MEDICINE_STRENGTH]", $order_details['p_strength_name'], $html);
		$html = str_replace("[MEDICINE_FORM]", $order_details['p_medicine_form'], $html);
		$html = str_replace("[MEDICINE_DOSE]", $order_details['p_suggested_dose'], $html);
		$html = str_replace("[MEDICINE_QUANTITY]", $order_details['quantity'], $html);
		
		$html = str_replace("[SURL]", SURL, $html);

		$order_details = $this->pmr->get_patient_order_item_details($order_detail_id);
		
		$signed_date_and_time = 'Signed at '.date('H:i', strtotime($order_details['created_date'])).' ON '.date('m/d/Y', strtotime($order_details['created_date'])).'';

		$html = str_replace("[SIGNED_DATE_TIME]", $signed_date_and_time, $html);
		// Patient section
		$html = str_replace("[PATIENT_NAME]",ucwords($order_details['p_patient_name']), $html);
		$html = str_replace("[PATIENT_ADDRESS]", $order_details['p_patient_address'], $html);
		$html = str_replace("[PATIENT_DOB]", date("d/m/Y", strtotime(filter_string($order_details['p_patient_dob']))), $html);

		// PRESCRIBER DETAILS
		$get_user_details = $this->users->get_user_details($order_details['prescribed_by']);
		$prescriber_signatures = $this->users->get_user_signatures($get_user_details['id']);

		if($order_details['default_prescriber']){
			//This order is apprived by Default prescriber so we have to use the address of the default prescriber

			$prescriber_organization = $this->organization->get_my_organizations($order_details['prescribed_by']);
			$prescriber_organization = $prescriber_organization[0];
			
		}//end if($order_details['default_prescriber'])

		
		if(filter_string($prescriber_signatures['signature_type']) == 'svn')
			$sig = filter_string($prescriber_signatures['signature']);
		else
			$sig = "<img src='".filter_string($prescriber_signatures['signature'])."' width='200px' height='60px' />";

		$html = str_replace("[PRESCRIBER_SIGNATURE]", $sig, $html);

		$html = str_replace("[REGISTRATION_TYPE]", $get_user_details['registration_type'], $html);
		$html = str_replace("[PRESCRIBER_REGISTRATION_NO]", filter_string($order_details['p_prescriber_reg_no']), $html);
		$html = str_replace("[PRESCRIBER_EMAIL_ADDRESS]", filter_string($order_details['p_prescriber_email']), $html);

		$html = str_replace("[PRESCRIPTION_DATE]", kod_date_format($order_details['created_date']), $html);
		$html = str_replace("[PRESCRIPTION_TIME]", date_format(date_create($order_details['created_date']),"g:i"), $html);

		// [Pharmacy_Name], [Address], [POST_CODE]

		$html = str_replace("[PRESCRIBER_NAME]",ucwords(filter_string($order_details['p_prescriber_name'])), $html);
		
		if($this->session->pmr_pharmacy_surgery_id)
			$pharmacy_surgery_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pmr_pharmacy_surgery_id);
		
		// PHARMACY SURGERY DETAILS
		
		if($order_details['default_prescriber']){
			//This order is apprived by Default prescriber so we have to use the address of the default prescriber

			$html = str_replace("[ORGANIZATION_ADDRESS]", $prescriber_organization['address'].', '.$prescriber_organization['postcode'], $html);	
		}else{
			$html = str_replace("[ORGANIZATION_ADDRESS]", $order_details['p_organization_address'], $html);	
		}
		

		//echo $html; exit;
		
		$html = filter_string($html);

		if($html){

    		$file_name = 'Rx.pdf';
            //$html = '<div style="border: 3px solid green;">'. $_POST['charts_html']. '</div>';
            
            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->SetFooter('|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure
            
            $pdf->AddPage('L'); // L - P

            $pdf->WriteHTML($html); // write the HTML into the PDF
            
            $pdf->Output('Rx-'.date('Y-m-d').'.pdf','D');

    	} // if($preview && $preview['email_body'] != '')

	} // End - public function download_rx($order_detail_id)

	// Start - public function get_category_raf_data()
	public function get_category_raf_data(){

		if(!$this->input->post()) redirect(SURL.'dashboard');

		extract($this->input->post());

		$data['raf_data'] =  $this->medicine->get_medicine_category_raf($category_id); // RAF Document Lables and Questions
		$raf_data = $data['raf_data'];

		// For all RAFs except [ sRaf & tRaf ]
		if($category_id != '30' && $category_id != '33'){

			$data['medicine'] = $this->medicine->get_medicine_by($category_id, '');
			$medicine = $data['medicine'];

		} // if($category_id == '37')

		//\\\\/////////////////////////////////////////////
		//\\\\//////////// Vaccine Section \\\\\\\\\\\\\\\\

		// sRAF - Flu
		if($category_id == '30'){
		
			$data['vaccine'] = $this->medicine->get_flu_vaccine("F", "PMR"); // Flu - PMR
			$vaccine = $data['vaccine'];

			$vaccine_advices = $this->medicine->get_vaccine_advices('F'); // F -> Flue | B -> BOTH

			$data['raf_data'] =  $this->medicine->get_vaccine_raf(1); // Pass vaccine_id 2 for Travel and 1 for Flu

		} // if($category_id == '30')

		// tRAF - Travel
		if($category_id == '33'){
		
			$data['vaccine'] = $this->medicine->get_flu_vaccine("T", "PMR"); // Travel - PMR
			$vaccine = $data['vaccine'];

			$vaccine_advices = $this->medicine->get_vaccine_advices('T'); // T -> Flue | B -> BOTH
			$anti_malaria_medicine = $this->medicine->get_medicine_by(34, ''); // Anti Malaria

			// Get list of all countries selected during journey planer
			$destinations = $this->medicine->get_vaccine_destinations();

			$data['raf_data'] =  $this->medicine->get_vaccine_raf(2); // Pass vaccine_id 2 for Travel and 1 for Flu
			
		} // if($category_id == '33')

		$raf_data = $data['raf_data'];

		$category_details = $this->medicine->get_medicine_category_details($category_id, '');
		
		// Verify if request is for VACCINE [TRAVEL - Flu]
		if($is_vaccine_request && ($category_id == 30 || $category_id = 33)){

			// $is_vaccine_request
			// $vaccine_order_id
			// $pmr_patient_id

			$data['filled_raf'] = $this->pmr->get_filled_raf($is_vaccine_request, $pmr_patient_id);

			//print_this($data['filled_raf']);
			//exit;

			if($category_id == 33){
				
				$data['countries_list'] = $this->pmr->get_countries_list($vaccine_order_id);
				if($data['countries_list']){
					$destinations_table = $this->load->view('pmr/destinations', $data, true);
				} // if($countries_list)

			} // end if($category_id == 33)
			
		} // if($is_vaccine_request)

		// Varify if Weight Loss is requested : Get patient weight and height details from the patient profile table
		$data['weight_assessment'] = $this->pmr->get_patient_details($pmr_patient_id);

		// Raf
		if($raf_data){
			$raf = $this->load->view('pmr/raf_document', $data, true);
			$not_found = ''; // $not_found = 1;
		} else {
			$raf = '';
			$not_found = 1;
		} // if($raf_data)

		echo json_encode(array('not_found' => $not_found, 'destinations' => $destinations, 'raf' => $raf, 'medicine' => $medicine, 'vaccine' => $vaccine, 'anti_malaria_medicine'=> $anti_malaria_medicine,'vaccine_advices' => $vaccine_advices, 'category_details' => $category_details, 'destinations_table' => $destinations_table ));

		// echo $this->load->view('pmr/', $data, true);

	} // end public function get_category_raf_data()

	// Start - public function get_medicine_details()
	public function get_medicine_details(){

		if(!$this->input->post()) redirect(SURL.'dashboard');

		// Get medicine SENT BY POST
		$medicine_id = $this->input->post('medicine_id');
		$data['medicine'] = get_pharmacy_surgery_medicines('', $medicine_id, $this->session->pmr_pharmacy_surgery_id); // $this->medicine->get_medicine_by('', $medicine_id); // Get medicine with Medicine ID

		// search_cheap_pharmacies

		$medicine = $data['medicine'];
		$success = 1;
		
		echo json_encode( array('success' => $success, 'medicine_id' => $medicine_id, 'medicine' => $medicine) );

	} //  End - public function get_medicine_details()

	// Start - public function save_walkin_pgd() : Function to save the walking PGD (PMR) Transaction
	public function save_walkin_pgd(){

		if(!$this->input->post()) redirect(SURL.'dashboard');
		
		extract($this->input->post()); // Extract POST data
		
		if($this->session->pmr_pharmacy_surgery_id){
			
			if($request_type == 'VACCINE'){
				
				$saved = $this->pmr->save_walkin_vaccine($pmr_patient_id, $this->session->pmr_pharmacy_surgery_id, $this->session->pmr_organization_id, $this->session->id, $this->input->post());
				
			} else {
				
				// Insert RAF
				$saved = $this->pmr->save_walkin_pgd($pmr_patient_id, $this->session->pmr_pharmacy_surgery_id, $this->session->pmr_organization_id, $this->session->id, $this->input->post());
		
			}//end if($request_type == 'VACCINE')
	
			if($saved){
				
				redirect(SURL.'organization/pmr/thankyou/'.$medicine_cat_id.'/'.$pmr_patient_id);
				exit;
	
			} else {
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect($_SERVER['HTTP_REFERER']);
			} // End else - if($add_edit_success_patient)

		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect($_SERVER['HTTP_REFERER']);
			
		}

	} // End - public function save_walkin_pgd()

	// Start - public function get_vaccine_brands()
	public function get_vaccine_brands(){

		if(!$this->input->post()) redirect(SURL.'dashboard');

		$cat_id = $this->input->post('cat_id');

		$brands = $this->medicine->get_vaccine_brands($cat_id);

		echo json_encode(array('brands' => $brands));

	} // End - public function get_vaccine_brands()

	// Start - public function add_vaccine_row()
	public function add_vaccine_row(){

		print_this($_POST);
		exit;

	} // End - public function add_vaccine_row()

	// Start - public function get_medicine_raf() : Function to get the RAF document by the medicine ID
	public function get_medicine_raf(){

		if(!$this->input->post()) redirect(SURL.'dashboard');

		extract($this->input->post());

		$data['raf_data'] = $this->medicine->get_medicine_raf_by_id($medicine_id);
		$data['malaria_med_raf'] = 1;

		// Raf HTML
		if($data['raf_data']){
			$raf = $this->load->view('pmr/raf_document', $data, true);
		} // if($data['raf_data']){

		echo json_encode(array('raf' => $raf));

	} // End - public function get_medicine_raf()

	// Start - public function thankyou($raf_category_id)
	public function thankyou($raf_category_id,$patient_id){

		// Script for print
		$this->stencil->js('jquery.PrintArea.js');
		$this->stencil->js('pmr_dashboard.js');
		
		$get_patient_details = $this->pmr->get_patient_details($patient_id);
		$consent_form['patient_details'] = $get_patient_details;

		$consent_form['consent_form_data'] = $this->pmr->get_consent_form($raf_category_id);

		$this->stencil->layout('dashboard_template'); //dashboard_template
		$this->stencil->paint('pmr/thank_you', $consent_form);

	} // End - public function thankyou($raf_category_id)
	
		// Edit Patient
		public function edit_patient_info($patient_id){

		if($patient_id == '')
			redirect(SURL);

		$patient_data = $this->pmr->get_patient_details($patient_id);

		$data['patient_data'] = $patient_data;
		
		$this->stencil->js('kod_scripts/custom.js');
		 
        $this->stencil->layout('pharmacy_settings'); //pgd_detail_ajax_template
        
        //edit Patient
        $this->stencil->paint('pmr/edit_patient_info', $data);
	}

	// Start - function merge_history_send_email($patient_id, $pharmacy_surgery_id)
	public function merge_history_send_email($patient_id, $pharmacy_surgery_id, $request=''){

		if($request == 'refresh'){

			$patient_in_same_ps = $this->pmr->get_patient_pharmacies_list($patient_id, $pharmacy_surgery_id);
			if(!$patient_in_same_ps){

				// On email sent : Success
				redirect(SURL.'pmr/patient-dashboard/'.$patient_id);

			} else
				redirect(SURL.'pmr/patient-dashboard/'.$patient_id);
			// if(!$patient_in_same_ps)

		} else {

			// Patient - $patient_id
			// To which going to Merge [ Pharmacy / Surgery - $pharmacy_surgery_id ]
			$email_sent = $this->pmr->send_merge_history_email($this->session->id, $patient_id, $pharmacy_surgery_id);

			if($email_sent){

				// On email sent : Success
				$data['success'] = '1';
				if($request == 'resend-email'){
					$this->session->set_flashdata('ok_message', 'Email was successfully Resent to Patient.');
				} else {
					$this->session->set_flashdata('ok_message', 'Email was successfully sent to Patient.');
				} // if($request == 'resend-email')
				
			} else {

				// Email Send Failure
				$data['success'] = '0';
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');

			} // if($email_sent)

		} // if($request == '')

		$cms_data_arr = $this->cms->get_cms_page('email-sent');
		$data['merge_error_cms'] = $cms_data_arr['cms_page_arr'];

		$data['patient_id'] = $patient_id;
		$data['pharmacy_surgery_id'] = $pharmacy_surgery_id;

		$this->stencil->js('jquery.PrintArea.js');
		$this->stencil->js('pmr_dashboard.js');

		$this->stencil->layout('dashboard_template'); //dashboard_template
		$this->stencil->paint('pmr/patient_merge_history_success', $data);

	} // End - function merge_history_send_email($patient_id, $pharmacy_surgery_details)

	// Start => function pgd_prescription_preview($patient_order_details_id='')
	public function pgd_prescription_preview($patient_order_details_id='', $medicine_id=''){

		if(!$this->input->post('transaction'))
				redirect(base_url().'dashboard');
		// if(!$this->session->show_pmr || $this->session->show_pmr != 1)

		// Patient Details
		$data['patient_details'] = $this->pmr->get_patient_details($this->input->post('patient_id'));
		
		// Medication Details
		$data['medication_details'] = $this->input->post();

		// Supplied by
		$order_details = $this->pmr->get_patient_pgd_order_details($patient_order_details_id);
		$data['order_details'] = $order_details;

		// $data['raf_data'] = $this->medicine->get_medicine_raf_by_id($medicine_id);

		if($order_details['is_malaria'] == '1'){

			// Get RAF by category_id
			$data['raf_data'] = $this->medicine->get_medicine_raf_by_id($medicine_id);
			$data['filled_raf'] = $this->pmr->get_filled_raf('', $this->input->post('patient_id'), $medicine_id, '');

		} else {

			// Get RAF by category_id
			$data['raf_data'] = $this->medicine->get_medicine_category_raf($order_details['medicine_cat_id']);
			$data['filled_raf'] = $this->pmr->get_filled_raf('', $this->input->post('patient_id'), '', $order_details['medicine_cat_id']);

		} // if($order_details['is_malaria'] == '1')
		
		$html = $this->load->view('pmr/pgd_prescription_preview',$data, true);

		echo $html;

	} // End => function pgd_prescription_preview($patient_order_details_id='')

	// Start - function email_sent() : Function to show messages
	public function email_sent(){



	} // public function email_sent()
	
	public function add_new_medicine(){

		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('pmr/add_new_medicine',$data);
		
	}//end add_new_medicine()
	

	public function add_new_medicine_process_ajax(){
		
		extract($this->input->post());
		
		$add_new_med = $this->pmr->add_new_medicine($this->session->id, $this->session->pmr_organization_id, $this->session->pmr_pharmacy_surgery_id, $this->input->post());
		
		if($add_new_med)
			$response['success'] = '1';
		else
			$response['success'] = '0';
		
		echo json_encode($response);
		
	}//end add_new_medicine()
	


} // End - class Pmr extends MY_Organization_Controller
/* End of file */
