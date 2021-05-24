<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patient extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('cities_mod','cities');
		$this->load->model('medicine_mod','medicine');
		$this->load->model('organization_mod','organization');
		$this->load->model('users_mod','users');
		$this->load->model('patient_mod','patient');
		
		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		//Navigational Tree for Left Pan
		//$this->nav_tree = $this->pgd->get_pgd_navigation_list('1');

		//Login Check for the sections defined in here.
	 	if($this->session->login_user_type == 'prescriber')
	 		$this->login->verify_is_prescriber_loggedin();
	 	else
	 		$this->login->verify_is_user_login();
	 	// if($this->session->login_user_type == 'prescriber')	
	 	
		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		//load main template
		$this->stencil->layout('page_template'); //page_template
		
		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		$this->stencil->slice('header_top');
		
		// Contents header (For Bread Crumb and flash messages)
		$this->stencil->slice('contents_header');
		
		//Sets the Left Navigation
		$this->stencil->slice('left_nav');

		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		$this->stencil->slice('footer_script');
	}

	public function index(){
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()

	// Start Function update_patient();
	public function update_patient($patient_id = ''){
	
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Patient', base_url().'patient/list-all-patients');
		$this->breadcrumbcomponent->add('Update', '#');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// load CK Editor
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template

		if($patient_id != ''){

			$get_patient_details = $this->patient->get_patient_details($patient_id);
			
			$data['get_patient_details'] = $get_patient_details;
			
		}//end if($patient_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// only call custom.js for February Month
		$this->stencil->js('kod_scripts/custom.js');
		
		$this->stencil->paint('patients/update_patient',$data);
		
	}//end update_patient()
	
	// Start Function update_patient_process();
	public function update_patient_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_patient_btn')) redirect(base_url());
		
		 $update_patient = $this->patient->update_patient($this->input->post()); 
		 $patient_id = $this->input->post('patient_id');

		if($update_patient && $update_patient['totalemail'] == 0){
			
			if($patient_id != ''){
				
				$referrer_link  = $patient_id;
				$this->session->set_flashdata('ok_message', 'Patient record updated successfully.');
				redirect(SURL.'patient/update-patient/'.$referrer_link);
				
			}//end if($this->input->post('patient_id') == '')
			
		}else if($update_patient['totalemail'] >0){
			$referrer_link  = $patient_id;
			$this->session->set_flashdata('err_message', 'Email already exist.');
		    redirect(SURL.'patient/update-patient/'.$referrer_link);
			
		} else {
			$referrer_link  = $patient_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			 redirect(SURL.'patient/update-patient/'.$referrer_link);

		}//end if($update_patient)
		
	}//end update_patient_process()
	
	// Start Function delete_patient();
	public function delete_patient($patient_id){
		
			if($patient_id!="")
			{
				$get_patient_delete = $this->patient->delete_patient($patient_id);
				
				if($get_patient_delete == '1')
				{
					$this->session->set_flashdata('ok_message', 'Patient deleted successfully.');
					redirect(SURL.'patient/list-all-patients');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'patient/list-all-patients');
					
				}//end if if($get_patient_delete != '')
				
			}//end if($patient_id!="")
			
	}//end function delete_patient($patient_id)
	
	// list_all_patients
	public function list_all_patients(){
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Patients Listing', base_url().'patient/list-all-patients');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		//  All Patients
		$data['list_patients'] = $this->patient->get_all_patients();
			
		// Load view: list_patients
		$this->stencil->paint('patients/list_patients',$data);
		
	} // End - list_all_patients():

	// search  search_doctor_pharmacist function 
	public function search_doctor_pharmacist(){
		
		//If Post is not SET
		//if(!$this->input->post() && !$this->input->post('search_btn_doc_pharm')) redirect(base_url());
		$data = $this->patient->search_doctor_pharmacist($this->input->post());
		echo json_encode($data);
	   //echo json_encode($data);
	  // $this->stencil->paint('users/auto_search_doc_pharm',$data);
		
	}// end search_doctor_pharmacist();
	
	// Function add_update_default_user_process();
	public function add_update_default_user_process(){
		
		if(!$this->input->post() && !$this->input->post('user_type_btn')) redirect(base_url());
		
		$success = $this->patient->add_update_default_user($this->input->post());
		
		if($success)
			{
				
				$this->session->set_flashdata('ok_message', 'Default user changed successfully.');
				redirect(SURL.'users/default-team-section-list');
				
			} else {
				
				$this->session->set_flashdata('err_message', 'Something went wrong, please enter valid email address.');
				redirect(SURL.'users/default-team-section-list');
				
			}//end else 
		
	} // End add_update_default_user_process();
	
	// list_patient_orders
	public function list_patient_orders($patient_id = ''){
		
		// Get Patient Full Name
	    $get_patient_full_name = $this->patient->get_patient_details($patient_id);
			
	    $Patient_full_name = filter_string($get_patient_full_name['first_name'])." ".filter_string($get_patient_full_name['last_name']);
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Patients Listing', base_url().'patient/list-all-patients');
		
		$this->breadcrumbcomponent->add('Patient Orders Listing'." (".$Patient_full_name.")", base_url().'patient/list-patient-orders');
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		//  All Patients
		$data['list_patient_orders'] = $this->patient->get_patient_order_list($patient_id);
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_patient_orders',$data);
		
	} // End - list_patient_orders():
		
	// list_patient_orders_details
	public function list_patient_orders_details($patient_id = '',$order_id = ''){
		
		// Get Patient Full Name
		$get_patient_full_name = $this->patient->get_patient_details($patient_id);
			
		$Patient_full_name = filter_string($get_patient_full_name['first_name'])." ".filter_string($get_patient_full_name['last_name']);
	    $pmr_no = $get_patient_full_name['pmr_no']; 
	
		if($get_patient_full_name['transaction_id']!=""){
		$transaction_id = $get_patient_full_name['transaction_id'];
		$transacton  = " > Transaction ID:".$transaction_id;
		}
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Patients Listing', base_url().'patient/list-all-patients');
		
		$this->breadcrumbcomponent->add('Patient Orders Listing'." (".$Patient_full_name."  > PMR No: ".$pmr_no." ".$transacton." )", base_url().'patient/list-patient-orders/'.$patient_id);
		
		$this->breadcrumbcomponent->add('Patient Orders Details Listing', base_url().'patient/list-orders-details');	
		
		// Get All Patient Orders Details Where Id $patient_id
		$list_orders_details = $this->patient->get_patient_order_detail_list($patient_id,$order_id);
		$data['list_orders_details'] = $list_orders_details;
		
		// Get patient_order_details
	
		// Get All Patient vaccine Orders Details Where Id $patient_id
		$list_orders_vaccine_details = $this->patient->get_patient_vaccine_order_detail_list($patient_id,$order_id);
		$data['list_orders_vaccine_details'] = $list_orders_vaccine_details;
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
			// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_patient_orders_details',$data);
		
	} // End - list_patient_orders_details():
	
	
	// list_patient_orders_details_prescriber_not_set
	public function list_patient_orders_details_prescriber_not_set(){
	
		$this->breadcrumbcomponent->add('Patient Orders Details Listing', base_url().'patient/list-patient-orders-details-prescriber-not-set');	
		
		// Get All Patient Orders Details Where Id $patient_id
		$list_orders_details = $this->patient->get_patient_order_detail_list_default_prescriber_not_set();
		$data['list_orders_details'] = $list_orders_details;
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
			// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_all_patients_orders_details_prescriber_not_set',$data);
		
	} // End - list_patient_orders_details_prescriber_not_set():
	
	// list_all_patients_orders
	public function list_all_patients_orders(){
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Patients Orders Listing', base_url().'patient/list-all-patients-orders');
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		//  All Patients
		$data['list_patients_orders'] = $this->patient->get_patients_orders_list();
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_all_patients_orders',$data);
		
	} // End - list_all_patients_orders():
	
	// list_all_patients_orders_details
	public function list_all_patients_orders_details($patient_id = '',$order_id = ''){
		
		// Get Patient Full Name
		$get_patient_full_name = $this->patient->get_patient_details($patient_id);
			
		$Patient_full_name = filter_string($get_patient_full_name['first_name'])." ".filter_string($get_patient_full_name['last_name']);
	    $pmr_no = $get_patient_full_name['pmr_no']; 
	
		if($get_patient_full_name['transaction_id']!=""){
		$transaction_id = $get_patient_full_name['transaction_id'];
		$transacton  = " > Transaction ID:".$transaction_id;
		}
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Patients orders Listing', base_url().'patient/list-all-patients-orders');
		
		$this->breadcrumbcomponent->add('Patient Orders Details Listing'." (".$Patient_full_name."  > PMR No: ".$pmr_no." ".$transacton." )", base_url().'patient/list-all-patients-orders-details/');
	
		// Get All Patient Orders Details Where Id $patient_id
		$list_orders_details = $this->patient->get_patient_order_detail_list($patient_id,$order_id);
		$data['list_orders_details'] = $list_orders_details;
		
		// Get patient_order_details
	
		// Get All Patient vaccine Orders Details Where Id $patient_id
		$list_orders_vaccine_details = $this->patient->get_patient_vaccine_order_detail_list($patient_id,$order_id);
		$data['list_orders_vaccine_details'] = $list_orders_vaccine_details;
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_all_patients_orders_details',$data);
		
	} // End - list_all_patients_orders_details():
	
	// list_all_patient_transactions show only Medicines order
	public function list_all_patient_transactions() {

		// Bread crumb		
		$this->breadcrumbcomponent->add('Patient Online Orders', base_url().'patient/list-all-patient-transactions/');
		
		// show those listing where product type is medicine
	    $transaction_list = $this->patient->get_organization_transactions('','','','','','P','', 'M','', '');
		
		//print_this($transaction_list); exit;
		$data['transaction_list'] = $transaction_list;
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
		 // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_all_patients_orders_transections',$data);
	}// end list_all_patient_transactions\
	
	// Start patient_dashboard function
    public function patient_dashboard($patient_id, $order_id='', $organization_id ='', $pharmacy_surgery_id =''){

		$this->session->pmr_organization_id = $organization_id;
		$this->session->pmr_pharmacy_surgery_id = $pharmacy_surgery_id;
		
		// Bread crumb		
		$this->breadcrumbcomponent->add('Patient Online Orders', base_url().'patient/list-all-patient-transactions/');
		
		// Bread crumb		
		$this->breadcrumbcomponent->add('Patient History', base_url().'patient/patient-dashboard/');
		
		if($order_id != ''){
			
			$data['root_order_id'] = $order_id;

			// Get patient_id and pharmacy_surgery_id by ORDER_ID
			$order_details = $this->patient->get_patient_order_item_details($order_id);
			$pharmacy_surgery_id = $order_details['pharmacy_surgery_id'];

			if($order_details['order_status'] == 'P'){
				
				$data['is_online'] = 1;
				$is_online = 1;

			} // if($order_details['order_status'] == 'P')

			$data['order_status'] = $order_details['order_status'];
			$order_status = $order_details['order_status'];
			
		} // if($order_id != '')
		
		// Get patient data according
		$data['patient_data'] = $this->patient->get_patient_details_country($patient_id);
	
		// Get Patient History
		$data['patient_history'] = $this->patient->get_patient_grouped_history($patient_id, '');
		
		//if($is_online == 1 && $order_status == 'P')

			//$data['patient_pending_transactions'] = $this->pmr->get_organization_transactions($this->session->pmr_organization_id, '', $patient_id, 'P', '', '', '', 'M', 1);
			$patient_pending_transactions = $this->patient->get_organization_transactions('','',$this->session->pmr_organization_id, $pharmacy_surgery_id, $patient_id, 'P', '', 'M', 'ONLINE', '');
			$data['patient_pending_transactions']  = $patient_pending_transactions;
			
			//print_this($patient_pending_transactions); exit;

		//} // end if($is_online == 1)
	
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// icheck
        $this->stencil->js('icheck/icheck.min.js');
		$this->stencil->js('pmr_dashboard.js');
		
	   // Fancy Box Scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
		// PrintArea
		$this->stencil->js('jquery.PrintArea.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_patients
		$this->stencil->paint('patients/patient_dashboard',$data);
		
	}// end 
	
	// Show all statistics where order statis = 'C' list_all_prescription_statistics
	public function list_all_prescription_statistics() {
		
		// Bread crumb		
		$this->breadcrumbcomponent->add('Prescription Audit', base_url().'patient/list-all-prescription-statistics/');
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
		 // icheck
        $this->stencil->js('icheck/icheck.min.js');
		$this->stencil->js('pmr_dashboard.js');
		
		// Fancy Box Scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
			
		// PrintArea
		$this->stencil->js('jquery.PrintArea.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Time display
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');		
		 		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
					
		// show those listing where product type is medicine
		
		// load pagination for pharmacy statistics
		$this->load->library("pagination");
		
		if($this->input->post() && ($this->input->post('to_date') != '' || $this->input->post('from_date') != '' || $this->input->post('date_search') != '' || $this->input->post('search_patient_email') != '' || $this->input->post('search_patient') != '')){
			
			$data['to_date_hidden'] = $this->input->post('to_date');
			$data['from_date_hidden'] = $this->input->post('from_date'); 
			$data['date_search_hidden'] = $this->input->post('date_search'); 
			$data['search_patient_hidden'] = $this->input->post('search_patient_email');
			$data['search_patient'] = $this->input->post('search_patient');
			
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
			$data['to_date_hidden'] = $this->input->post('to_date');
			$data['from_date_hidden'] = $this->input->post('from_date'); 
			$data['date_search_hidden'] = $this->input->post('date_search'); 
			$data['search_patient_hidden'] = $this->input->post('search_patient_email');

			$uri_string = $this->input->post('from_date')."/".$this->input->post('to_date')."/".$this->input->post('search_patient_email')."/".$this->input->post('search_patient')."/".$this->input->post('date_search');

			$base64_encoded = base64_encode($uri_string);
			$url_encoded_string = urlencode($base64_encoded);

			$config["base_url"] = base_url() . "patient/list-all-prescription-statistics/".$url_encoded_string;
		    $config["total_rows"] = count($this->patient->get_organization_transactions('', '','','','','C','', 'M','', $this->input->post()));
		    $config["per_page"] = 50;
		    $config["uri_segment"] = 3;
		    $choice = $config["total_rows"] / $config["per_page"];
		    $config["num_links"] = round($choice);

		    //config for bootstrap pagination class integration

	        $config['full_tag_open'] = '<ul class="pagination">';
	        $config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li onClick="filter_stats();">';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = 'Previous &laquo';
	        $config['prev_tag_open'] = '<li onClick="filter_stats();" class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li onClick="filter_stats();">';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li onClick="filter_stats();">';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li onClick="filter_stats();">';
	        $config['num_tag_close'] = '</li>';

		    $this->pagination->initialize($config);

		    $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
		    
		    $data["links"] = $this->pagination->create_links();

			// Show those listing where product type is medicine
	    	$data['transaction_list'] = $this->patient->get_organization_transactions($config["per_page"], $page,'','','','C','', 'M','', $this->input->post());
			
			$data['to_date_hidden'] = $this->input->post('to_date');
			$data['from_date_hidden'] = $this->input->post('from_date'); 
			$data['date_search_hidden'] = $this->input->post('date_search'); 
			$data['search_patient_hidden'] = $this->input->post('search_patient_email');
			$data['search_patient'] = $this->input->post('search_patient');
			
		} else if( $this->uri->segment(3) != '' || $this->uri->segment(4) != ''){

			// [0] => from_date
		    // [1] => to_date
		    // [2] => search_patient_email
		    // [3] => search_patient
		    // OR
		    // [4] => date_search

			$url_decoded = urldecode($this->uri->segment(3));
			$url_string = base64_decode($url_decoded);

			$data_arr = explode('/', $url_string);

			// Before passing the $data_arr to the model 
			$post_data['from_date'] = $data_arr[0];
			$post_data['to_date'] = $data_arr[1];
			$post_data['search_patient_email'] = $data_arr[2];
			$post_data['search_patient'] = $data_arr[3];
			$post_data['date_search'] = $data_arr[4];

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$uri_string = $data_arr[0]."/".$data_arr[1]."/".$data_arr[2]."/".$data_arr[3]."/".$data_arr[4];

			$base64_encoded = base64_encode($uri_string);
			$url_encoded_string = urlencode($base64_encoded);

			$config["base_url"] = base_url() . "patient/list-all-prescription-statistics/".$url_encoded_string;
		    $config["total_rows"] = count($this->patient->get_organization_transactions('', '','','','','C','', 'M','', $post_data));
		    $config["per_page"] = 50;
		    $config["uri_segment"] = 4;
		    $choice = $config["total_rows"] / $config["per_page"];
		    $config["num_links"] = round($choice);

		    //config for bootstrap pagination class integration

	        $config['full_tag_open'] = '<ul class="pagination">';
	        $config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li onClick="filter_stats();">';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = 'Previous &laquo';
	        $config['prev_tag_open'] = '<li onClick="filter_stats();" class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li onClick="filter_stats();">';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li onClick="filter_stats();">';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li onClick="filter_stats();">';
	        $config['num_tag_close'] = '</li>';

		    $this->pagination->initialize($config);

		    $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		    
		    $data["links"] = $this->pagination->create_links();

			// Show those listing where product type is medicine
	    	$data['transaction_list'] = $this->patient->get_organization_transactions($config["per_page"], $page,'','','','C','', 'M','', $post_data);
			
			//echo '<pre>';
			//print_r($data['transaction_list']);
			//exit;

			$data['to_date_hidden'] = $data_arr[1];
			$data['from_date_hidden'] = $data_arr[0]; 
			$data['date_search_hidden'] = $data_arr[4]; 
			$data['search_patient_hidden'] = $data_arr[2];
			$data['search_patient'] = $data_arr[3];

		}
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_all_prescription_statistics',$data);
				 
	 }// end list_all_prescription_statistics

	// Show all statistics Of user who have been prescribed by the default system rescribers 
	public function list_all_patients_audit() {

		// Bread crumb		
		$this->breadcrumbcomponent->add('User Audit  Orders', base_url().'patient/list-all-patient-transactions/');
		
		// show those listing where product type is medicine
	    $transaction_list = $this->patient->get_default_prescriber_prescribed_patients();
		$data['transaction_list'] = $transaction_list;
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
		 // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		 		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_all_patients_audit',$data);
		
	}// end list_all_user_audit
	 
	 
	 
	 // preview_current_statistics
	public function preview_current_statistics($organization_id = '', $pharmacy_surgery_id = '', $order_detail_id = ''){	
	
		//if($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3 ){
			
			$patient_order_details = $this->patient->get_patient_purchase_details($order_detail_id);
			$data['order_details'] = $patient_order_details;
			
			$prescriber_user = $this->users->get_user_details($patient_order_details['prescribed_by']);
			$data['registration_type']    =    filter_string($prescriber_user['registration_type']);
			
			//$data['prescriber_full_name'] = filter_string($user['user_full_name']);
			//$data['prescriber_email_address']    =    filter_string($get_default_prescriber['email_address']);
			//$data['registration_number']  = filter_string($user['registration_no']);
			//$data['organization_details'] = $this->organization->get_organization_details($organization_id);
			//$data['pharmacy_surgery_details'] = $this->organization->get_pharmacy_surgery_details($pharmacy_surgery_id);
			$data['user_signatures'] = $this->users->get_user_signatures($prescriber_user['id']);
			
		//} // if($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3 )

		$data['patient_details'] = $this->patient->get_patient_details_country($this->input->post('patient_id'));
		

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

		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		echo $this->load->view('patients/statistics_details',$data, true);
		
	} //  preview_current_statistics
	
	// Start - public function update_patient_allergies()
	public function update_patient_allergies(){

		if(!$this->input->post()) redirect(SURL);

		$allergies_text = trim($this->input->post('allergies'));
		$patient_id = trim($this->input->post('patient_id'));

		// Update Allergies text into db for this patient [ patient_id ]
		$updated = $this->patient->update_patient_allergies($allergies_text, $patient_id);

		if($updated)
			echo true;
		else
			echo false;

	} // public function update_patient_allergies()	
	
	// Start - public function patient_medicine_history()
	public function patient_medicine_history($patient_id, $medicine_id, $order_status = '', $is_online=''){
		
		$data['medicine'] = $this->medicine->get_medicine_by('', $medicine_id); // Get medicine by medicine ID
		
		if($this->session->is_prescriber && $this->session->is_prescriber == 1){
			$data['free_type'] = 1;
		} // if($this->session->is_prescriber && == $this->session->is_prescriber == 1)

		$data['is_online'] = $is_online;
		$data['patient_history'] = $this->patient->get_patient_history($patient_id, $order_status, $medicine_id);
	
		$this->stencil->layout('ajax_with_scripts'); //ajax
		$this->stencil->paint('patients/medicine_history', $data);
		
	} // End - public function patient_medicine_history()
	
	// Start - public function view_raf() : Function to get RAF document to be shown on ajax based fancybox popup in Pending PMR/transactions
	public function view_raf($patient_id, $product_type, $medicine_vaccine_id){

		if($product_type == 'M'){
			$data['medicine'] = $this->medicine->get_medicine_by('', $medicine_vaccine_id); // Get medicine by medicine ID to display medicine name of top
			$data['raf'] = $this->medicine->get_patient_medicine_raf($patient_id, $medicine_vaccine_id,''); // Get RAF Document
		}
		else
			$data['raf'] = $this->pmr->get_patient_medicine_raf($patient_id, '', $medicine_vaccine_id);		
		// if($product_type == 'M')
		
		$this->stencil->layout('ajax_with_scripts'); //ajax

		$this->stencil->paint('patients/view_raf', $data);

	} // end public function view_raf($patient_id, $medicine_vaccine_type, $medicine_vaccine_id)
	
	// preview_current_transaction
	public function preview_current_transaction($organization_id = '', $pharmacy_surgery_id = ''){
		
		//print_this($this->input->post());
		//if($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3 ){


			// Get Prescriber details from user table
			$get_default_prescriber = $this->patient->get_system_default_prescriber();
			$data['default_prescriber'] = $get_default_prescriber;
			//print_this($get_default_prescriber);
			
			/*
			
			$user = $this->users->get_user_details($get_default_prescriber['id']);
			$prescriber_organization = $this->organization->get_my_organizations($get_default_prescriber['id']);
			$data['prescriber_organization'] = $prescriber_organization[0];
			
			$data['prescriber_full_name'] = filter_string($user['user_full_name']);
			$data['prescriber_email_address'] = filter_string($get_default_prescriber['email_address']);
			$data['registration_type']    =    filter_string($user['registration_type']);
			$data['registration_number']  = filter_string($user['registration_no']);
			$data['organization_details'] = $this->organization->get_organization_details($organization_id);
			$data['pharmacy_surgery_details'] = $this->organization->get_pharmacy_surgery_details($pharmacy_surgery_id);
			$data['user_signatures'] = $this->users->get_user_signatures($user['id']);
			
			*/
			
		//} // if($this->session->user_type == 1 || $this->session->user_type == 2 || $this->session->user_type == 3 )

		$data['patient_details'] = $this->patient->get_patient_details_country($this->input->post('patient_id'));
		
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
			
			$order_detail_id = $this->input->post('order-detail-id'); 
			$data['order_detail_id'] = $order_detail_id;
			
			$patient_order_details = $this->patient->get_patient_purchase_details($order_detail_id);
			$data['order_details'] = $patient_order_details;
			
		} // if( $this->input->post('order-detail-id') )

		// Verify if the request is for dispense
		if( $this->input->post('root_order_id') ){
			$data['root_order_id'] = $this->input->post('root_order_id'); 
		} // if( $this->input->post('order-detail-id') )
			//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		//echo "i am called";
		echo $this->load->view('patients/patient_history_preview',$data, true);
		
	} //  preview_current_transaction
	
	public function decline_transaction(){

		$updated = $this->patient->decline_transaction( $this->input->post() );
		echo $updated;

	} // end public function decline_transaction()
	
	// save_prescription
	public function save_prescription(){
		
		extract($this->input->post());
		
		$patient_id = $this->input->post('pmr_patient_id');
		$organization_id =  $this->input->post('organization_id');
		$pharmacy_surgery_id =  $this->input->post('pharmacy_surgery_id');
		$order_id =  $this->input->post('order_detail_id');
		
		$get_default_prescriber = $this->patient->get_system_default_prescriber();
		
		
		// Parse string : unserialize the searialized data
		$prescription = array();
		parse_str($this->input->post('prescription-preview-form-searialized-data'), $prescription);
		
		if($this->input->post('save_approve_request')){
			
			// Verrify if the request is APPROVE
			// Save prescription
			$saved = $this->patient->mark_transaction_complete($this->input->post('order_detail_id'));

			if($saved){
				$this->session->set_flashdata('ok_message', 'Prescription successfully approved.');
			} else {
				$this->session->set_flashdata('error_message', 'Oops! Something went wrong.');
			} // if($saved)

			// redirect($_SERVER['HTTP_REFERER']);
			
		     redirect(SURL.'patient/patient-dashboard/'.$patient_id.'/'.$root_order_id.'/'.$organization_id.'/'.$pharmacy_surgery_id);

		} else {

			// Verify is the request is from FREE TYPE
			// Save prescription
			
			$saved = $this->patient->save_prescription($pharmacy_surgery_id, $organization_id, $get_default_prescriber['id'], $prescription);

			if($saved){
				$this->session->set_flashdata('ok_message', 'Prescription successfully saved.');
			} else {
				$this->session->set_flashdata('error_message', 'Oops! Something went wrong.');
			} // if($saved)

			redirect(base_url().'patient/list-all-patient-transactions');

		} // if($this->input->post('save_approve_request'))
		
	} // public function save_prescription()
	
	// Show all statistics where order statis = 'C' list_all_prescription_statistics
	 public function list_all_pharmacy_statistics () {
			
		// Bread crumb		
		$this->breadcrumbcomponent->add('Pharmacy Audit', base_url().'patient/list-all-pharmacy-statistics/');
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		 // icheck
        $this->stencil->js('icheck/icheck.min.js');		
		$this->stencil->js('pmr_dashboard.js');

		// Time display
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');		
		 		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->load->library("pagination");
		
		if($this->input->post('pharmacy_surgery_id')!=""){
			
			//echo '<pre>';
			//print_r($_POST);
			//exit;

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
			$data['from_date_hidden'] = $this->input->post('from_date');
			$data['to_date_hidden'] = $this->input->post('to_date');
			$data['date_search_hidden'] = $this->input->post('date_search'); 
			$data['search_pharmacy_hidden_post_code'] = $this->input->post('search_pharmacy_post_code');
			$data['search_pharmacy'] = $this->input->post('search_pharmacy');
			$data['search_pharmacy_hidden_id'] = $this->input->post('pharmacy_surgery_id');
			
			$uri_string = $this->input->post('from_date')."/".$this->input->post('to_date')."/".$this->input->post('search_pharmacy_post_code')."/".$this->input->post('search_pharmacy')."/".$this->input->post('date_search')."/".$this->input->post('pharmacy_surgery_id');

			$base64_encoded = base64_encode($uri_string);
			$url_encoded_string = urlencode($base64_encoded);

			$config["base_url"] = base_url() . "patient/list-all-pharmacy-statistics/".$url_encoded_string;
		    $config["total_rows"] = count($this->patient->get_organization_transactions('', '','',$this->input->post('pharmacy_surgery_id'),'','C','', 'M','', $this->input->post()));
		    $config["per_page"] = 50;
		    $config["uri_segment"] = 3;
		    $choice = $config["total_rows"] / $config["per_page"];
		    $config["num_links"] = round($choice);

		    //config for bootstrap pagination class integration

	        $config['full_tag_open'] = '<ul class="pagination">';
	        $config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li onClick="filter_stats();">';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = 'Previous &laquo';
	        $config['prev_tag_open'] = '<li onClick="filter_stats();" class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li onClick="filter_stats();">';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li onClick="filter_stats();">';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li onClick="filter_stats();">';
	        $config['num_tag_close'] = '</li>';

		    $this->pagination->initialize($config);

		    $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
		    
		    $data["links"] = $this->pagination->create_links();

			// Show those listing where product type is medicine
	    	$data['transaction_list'] = $this->patient->get_organization_transactions($config["per_page"], $page,'',$this->input->post('pharmacy_surgery_id'),'','C','', 'M','', $this->input->post());
			
			$data['to_date_hidden'] = $this->input->post('to_date');
			$data['from_date_hidden'] = $this->input->post('from_date'); 
			$data['date_search_hidden'] = $this->input->post('date_search'); 
			$data['search_pharmacy_hidden_post_code'] = $this->input->post('search_pharmacy_post_code');
			$data['search_pharmacy'] = $this->input->post('search_pharmacy');
			$data['pharmacy_surgery_id'] = $this->input->post('pharmacy_surgery_id');
			
		} else if( $this->uri->segment(3) != '' || $this->uri->segment(4) != ''){ 
		
			// [0] => from_date
		    // [1] => to_date
		    // [2] => search_patient_email
		    // [3] => search_patient
		    // OR
		    // [4] => date_search

			$url_decoded = urldecode($this->uri->segment(3));
			$url_string = base64_decode($url_decoded);

			$data_arr = explode('/', $url_string);

			// Before passing the $data_arr to the model 
			$post_data['from_date'] = $data_arr[0];
			$post_data['to_date'] = $data_arr[1];
			$post_data['search_pharmacy_post_code'] = $data_arr[2];
			$post_data['search_pharmacy'] = $data_arr[3];
			$post_data['date_search'] = $data_arr[4];
			$post_data['pharmacy_surgery_id'] = $data_arr[5];

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$uri_string = $data_arr[0]."/".$data_arr[1]."/".$data_arr[2]."/".$data_arr[3]."/".$data_arr[4]."/".$data_arr[5];

			$base64_encoded = base64_encode($uri_string);
			$url_encoded_string = urlencode($base64_encoded);
			
			//echo $uri_string; exit;

			$config["base_url"] = base_url() . "patient/list-all-pharmacy-statistics/".$url_encoded_string;
		    $config["total_rows"] = count($this->patient->get_organization_transactions('', '','',$data_arr[5],'','C','', 'M','', $post_data));
		    $config["per_page"] = 50;
		    $config["uri_segment"] = 4;
		    $choice = $config["total_rows"] / $config["per_page"];
		    $config["num_links"] = round($choice);

		    //config for bootstrap pagination class integration

	        $config['full_tag_open'] = '<ul class="pagination">';
	        $config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li onClick="filter_stats();">';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = 'Previous &laquo';
	        $config['prev_tag_open'] = '<li onClick="filter_stats();" class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li onClick="filter_stats();">';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li onClick="filter_stats();">';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li onClick="filter_stats();">';
	        $config['num_tag_close'] = '</li>';

		    $this->pagination->initialize($config);

		    $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		    
		    $data["links"] = $this->pagination->create_links();

			// Show those listing where product type is medicine
	    	$data['transaction_list'] = $this->patient->get_organization_transactions($config["per_page"], $page,'',$data_arr[5],'','C','', 'M','', $post_data);
			
			// Before passing the $data_arr to the model 
			$data['from_date_hidden'] = $data_arr[0];
			$data['to_date_hidden'] = $data_arr[1];
			$data['search_pharmacy_hidden_post_code'] = $data_arr[2];
			$data['search_pharmacy'] = $data_arr[3];
			$data['date_search_hidden'] = $data_arr[4];
			$data['search_pharmacy_hidden_id'] = $data_arr[5];

		}
		
		// Load view: list_patients
		$this->stencil->paint('patients/list_all_pharmacy_statistics',$data);
				 
	 }// end list_all_prescription_statistics
	 
	 // Download CSV FILE Prescription Statistics
     public function download_csv_prescription_statistics() {
		 
			$this->load->helper('url');
			
			$file_contents = $this->patient->download_csv_prescription_statistics('','','','C','', 'M','', $this->input->post()); 
			
			//$file_contents = load_file_from_id($_GET['id']);
			$file_name = 'user_reports'.time().'.csv';
			
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			echo $file_contents;
		
		}//end download_csv
		
	// Download CSV FILE Pharamcy Statistics
     public function download_csv_pharamcy_statistics() {
		 
			$this->load->helper('url');
			
			$file_contents = $this->patient->download_csv_pharamcy_statistics('','','','C','', 'M','', $this->input->post()); 
			
			//$file_contents = load_file_from_id($_GET['id']);
			$file_name = 'user_reports'.time().'.csv';
			
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			echo $file_contents;
		
		}//end download_csv
			
	// Search Patients
	public function search_patient(){
		
		$data['list_search_patient'] = $this->patient->search_patient($this->input->post());
		
		echo $this->load->view('patients/auto_search_patient',$data,true);
			
	}// end search_patient();
	
	// Search Pharamacy
	public function search_pharmacy(){
		
		$data['list_search_pharmacy'] = $this->patient->search_pharmacy($this->input->post());
		
		echo $this->load->view('patients/auto_search_pharmacy',$data,true);
			
	}// end search_patient();
	 
}/* End of file */