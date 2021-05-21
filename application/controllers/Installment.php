<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Installment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Verify if the user is loggedin
		if(!$this->session->uid)
			redirect(SURL.'login');
		// if(!$this->session->uid)

		$this->load->model('Drugs_mod','drugs');
		$this->load->model('Register_mod','register');
		$this->load->model('Suppliers_mod','suppliers');
		$this->load->model('Prescribers_mod','prescribers');
		$this->load->model('Users_mod','users');
		$this->load->model('Patient_mod','patients');
		$this->load->model('Installment_mod','installment');

		$this->load->library('BreadcrumbComponent');
		
		//Sets the variable $header_contents to use the slice head (/views/slices/header_contents.php)
		$this->stencil->slice('header_contents');

		//Sets the variable $header_scripts to use the slice head (/views/slices/header_scripts.php)
		$this->stencil->slice('header_scripts');

		//Sets the variable $footer_scripts_modal to use the slice head (/views/slices/footer_scripts_modal.php)
		$this->stencil->slice('footer_scripts_modal');
		
		//Sets the variable $footer_contents to use the slice head (/views/slices/footer_contents.php)
		$this->stencil->slice('footer_contents');
		
		//Sets the variable $footer_scripts to use the slice head (/views/slices/footer_scripts.php)
		$this->stencil->slice('footer_scripts');

		// left_pane
		$this->stencil->slice('left_pane');
		
		$this->stencil->js('kod_scripts/form_validation.js');
		
		// Form Validation	
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation.min.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');
		
		// end CMS file Validation
		
		// Layout
		$this->stencil->layout('page');
		
	} // public function __construct()

	public function index(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));

		// Page Heading
		$page_heading = 'Instalment RX';
		$data['page_heading'] = $page_heading;
		
		// Bread crumb
		$this->breadcrumbcomponent->add('<i class="ace-icon fa fa-home home-icon"></i> Home ', base_url().'dashboard');	
		$this->breadcrumbcomponent->add(filter_string($page_heading), base_url().'installment/installment-rx');					
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->js('kod_scripts/users.js');
		$this->stencil->js('kod_scripts/installment_rx.js');

		$this->stencil->paint('installment/installment_rx',$data);
		
	}//end index()
	
	// Show installmentrx Listings And Add Edit
	public function installment_rx(){

		$current_date = date('Y-m-d');
		//$current_date = '2016-09-19';
		$get_prescription_data = $this->installment->get_prescription_list($this->session->my_pharmacy_id, $current_date, '');
		
		//print_this($get_prescription_data); exit;
		
		$data['prescription_data'] = $get_prescription_data;

		//print_this($get_prescription_data); exit;

		$data['new_current_date'] = $current_date;
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Page Heading
		$page_heading = 'Instalment RX';
		$data['page_heading'] = $page_heading;
		
		// Bread crumb
		$this->breadcrumbcomponent->add('<i class="ace-icon fa fa-home home-icon"></i> Home ', base_url().'dashboard');	
		$this->breadcrumbcomponent->add(filter_string($page_heading), base_url().'installment/installment-rx');					
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->js('kod_scripts/users.js');
		$this->stencil->js('kod_scripts/add_users.js');
		$this->stencil->js('kod_scripts/pdf_ajax_report.js');
		$this->stencil->js('kod_scripts/installment_rx.js');
		$this->stencil->js('kod_scripts/installment_rx2.js');
		
		$this->stencil->js(JS.'tinymce/jscripts/tiny_mce/tiny_mce_dev.js');

		$this->stencil->js('kod_scripts/ajax_datatables.js');
		$this->stencil->paint('installment/installment_rx',$data);
		
	}// End installment_rx()
	
	public function run_patient_drug_schedule(){
		
		if(!in_array(27,$this->session->userdata('permissions_arr'))){
			
			redirect(base_url().'dashboard');
		}
		
		if(!$this->input->post()) return;
		
		extract($this->input->post());
		
		$get_drug_details = $this->drugs->get_pharmacy_drug_list($this->session->my_pharmacy_id,$drug_id);
		$data['drug_unit'] = $get_drug_details['drug_unit'];
		
		$data['post_data'] = $this->input->post();

		$this->stencil->layout('ajax_layout');
		$this->stencil->paint('installment/run_patient_script',$data);
		
	}//end run_patient_drug_schedule()

	public function save_rx_patient_schedule(){

		if(!$this->input->post('rx_save_script_btn')) redirect(SURL);
		extract($this->input->post());

		//Verify if the drug ID which is used is belong to the same Pharmacy.
		$get_drug_details = $this->drugs->get_pharmacy_drug_list($this->session->my_pharmacy_id,$drug_id);

		//Verify if the prescriber is valid.
		$verify_prescriber_data = $this->prescribers->get_prescriber_details($this->session->my_pharmacy_id,$prescriber_id);

		//Verify if patient is valid
		$verify_patient_data = $this->patients->get_patient_details($this->session->my_pharmacy_id,$patient_id);

		//If Prescriber or Patient is invalid
		if(!$verify_patient_data || !$verify_prescriber_data || !$get_drug_details){

			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx?t=2');
			
		}//end if(!$verify_patient_data || !$verify_prescriber_data)
		
		$save_patient_schedule = $this->installment->save_patient_schedule($this->session->uid, $this->session->my_pharmacy_id, $this->input->post());
		
		if($save_patient_schedule){
			
			$this->session->set_flashdata('ok_message', 'Patient Schedule is saved successfully.');
			redirect(base_url().'installment/installment-rx');
			
		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx?t=2');
			
		}//end if($save_patient_schedule)

	}//end save_rx_patient_schedule()
	
	public function update_rx_patient_schedule(){

		if(!$this->input->post('rx_save_script_btn')) redirect(SURL);
		
		extract($this->input->post());

		//Verify if the drug ID which is used is belong to the same Pharmacy.
		$get_drug_details = $this->drugs->get_pharmacy_drug_list($this->session->my_pharmacy_id,$drug_id);

		//Verify if the prescriber is valid.
		$verify_prescriber_data = $this->prescribers->get_prescriber_details($this->session->my_pharmacy_id,$prescriber_id);

		//Verify if patient is valid
		$verify_patient_data = $this->patients->get_patient_details($this->session->my_pharmacy_id,$patient_id);

		//If Prescriber or Patient is invalid
		if(!$verify_patient_data || !$verify_prescriber_data || !$get_drug_details){

			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx?t=2');
			
		}//end if(!$verify_patient_data || !$verify_prescriber_data)
		
		$update_patient_schedule = $this->installment->update_patient_schedule($this->session->uid, $this->session->my_pharmacy_id, $this->input->post());
		
		if($update_patient_schedule){
			
			$this->session->set_flashdata('ok_message', 'Patient Schedule is updated successfully.');
			redirect(base_url().'installment/installment-rx');
			
		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx?t=2');
			
		}//end if($update_patient_schedule)

	}//end update_rx_patient_schedule()

	public function get_next_prev_day_schedule(){
		
		if(!$this->input->post()) return;
		
		extract($this->input->post());
		
		$data['post_data'] = $this->input->post();

		if($action == 'rx_next_day')
			$new_current_date = date('Y-m-d', strtotime(str_replace('/','-',$current) . ' +1 day'));
		elseif($action == 'rx_prev_day')
			$new_current_date = date('Y-m-d', strtotime(str_replace('/','-',$current) . ' -1 day'));
		else
			$new_current_date = date('Y-m-d', strtotime(str_replace('/','-',$current) . ' 0 day'));
			
		$data['new_current_date'] = $new_current_date;
		
		$get_prescription_data = $this->installment->get_prescription_list($this->session->my_pharmacy_id, $new_current_date, '');
		$data['prescription_data'] = $get_prescription_data;

		$this->stencil->layout('ajax_layout');
		$this->stencil->paint('installment/next_prev_day_schedule',$data);
		
	}//end run_patient_drug_schedule()
	
	public function view_rx_schedule($schedule_id){
		
		if(trim($schedule_id) == '') redirect(SURL);
		
		$this->load->model('reports_mod', 'reports');
		
		$verify_if_schedule_exist = $this->installment->get_rx_schedule_data($this->session->my_pharmacy_id, $schedule_id);
		//print_this($verify_if_schedule_exist); exit;
		
		if($verify_if_schedule_exist){
			
			$get_drug_details = $this->drugs->get_pharmacy_drug_list($this->session->my_pharmacy_id,$verify_if_schedule_exist['drug_id']);
			$data['drug_unit'] = $get_drug_details['drug_unit']; 
			

			$data['schedule_data'] = $verify_if_schedule_exist;
			
			//Verify if any of the schedule is marked as MISSED or COLLECTED
			$collected_index_key = array_search('COLLECTED', array_column($verify_if_schedule_exist['dose_schedule'], 'dose_status'));
			if(is_numeric($collected_index_key))
				$is_collected = 1;
			
			$missed_index_key = array_search('MISSED', array_column($verify_if_schedule_exist['dose_schedule'], 'dose_status'));
			if(is_numeric($missed_index_key))
				$is_missed = 1;

			$cancelled_index_key = array_search('CANCELLED', array_column($verify_if_schedule_exist['dose_schedule'], 'dose_status'));
			
			if(is_numeric($cancelled_index_key)){
				$is_cancelled = 1;
				$data['is_cancelled'] = 1;
			}//end if(is_numeric($cancelled_index_key))
			
			if($is_collected || $is_missed || $is_cancelled){
				
				$already_exist = 1;
				$data['already_exist'] = $already_exist;
				
			}//end if($is_collected || $is_missed)

			$this->stencil->layout('modal_layout');
			$this->stencil->js('kod_scripts/installment_rx.js');
			
			//Need to show editable mode as all are Uncollected.
			$this->stencil->paint('installment/edit_rx_schedule',$data);
			
		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx');
			
		}//end if($verify_if_schedule_exist)
		
	}//end view_rx_schedule()
	
	public function view_rx_schedule_notes($schedule_id){

		if(trim($schedule_id) == '') redirect(SURL);
		
		$verify_if_schedule_exist = $this->installment->get_rx_schedule_data($this->session->my_pharmacy_id, $schedule_id);
		
		if($verify_if_schedule_exist){
			
			$get_rx_notes_arr = $this->installment->get_rx_notes($schedule_id);

			$data['rx_notes_arr'] = $get_rx_notes_arr;
			$data['schedule_id'] = $schedule_id;
			
		}else{
			$data['err_message'] = 'Invalid or Unauthorized Access, please contact site administrator';	
		}//end if($verify_if_schedule_exist)

		$this->stencil->js('kod_scripts/installment_rx.js'); 
		$this->stencil->js('dataTables/jquery.dataTables.js'); 

		$this->stencil->layout('modal_layout');
		$this->stencil->paint('installment/view_rx_schedule_notes',$data);
		
	}//end view_rx_schedule_notes($schedule_id)
	
	public function add_rx_schedule_notes_process(){
		
		if(!$this->input->post('rx_new_notes_btn')) redirect(SURL);
		
		extract($this->input->post());
		
		$verify_if_schedule_exist = $this->installment->get_rx_schedule_data($this->session->my_pharmacy_id, $schedule_id);
		
		if($verify_if_schedule_exist){
			
			$add_rx_schedule_note = $this->installment->add_rx_schedule_note($this->session->uid, $this->session->my_pharmacy_id,$this->input->post());
			
			if($add_rx_schedule_note){

				$this->session->set_flashdata('ok_message', 'Notes successfully added.');
				redirect(base_url().'installment/installment-rx');
				
			}else{
				
				$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
				redirect(base_url().'installment/installment-rx');

			}//end if($add_rx_schedule_note)
			
		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx');
			
		}//end if($verify_if_schedule_exist)

	}//end add_rx_schedule_notes_process()
	
	public function delete_rx_schedule_notes_process(){

		if(!$this->input->post('rx_del_notes_btn')) redirect(SURL);
		
		extract($this->input->post());
		
		$del_rx_notes = $this->installment->delete_rx_notes($this->input->post());
		
		if($del_rx_notes){
			
			$this->session->set_flashdata('ok_message', 'Notes successfully deleted.');
			redirect(base_url().'installment/installment-rx');

		}else{
			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx');
			
		}//end if($del_rx_notes)
		
	}//end delete_rx_schedule_notes_process()
	
	public function update_prescription_status($status,$rx_schedule_id){
		
		$verify_prescription_status = $this->installment->get_rx_dose_data($this->session->my_pharmacy_id, '', $rx_schedule_id);
		
		if(!$verify_prescription_status){
			$data['err_message'] = 'Invalid or Unauthorized Access, please contact site administrator';
		}else{

			$data['status'] = $status;
			$data['rx_schedule_id'] = $rx_schedule_id;
			
		}//end if($verify_prescription_status)
		
		$this->stencil->js('common.js');

		$this->stencil->layout('modal_layout');
		$this->stencil->paint('installment/update_prescription_status',$data);
		
	}//end update_prescription_status($status,$rx_schedule_id)
	
	public function update_prescription_status_process(){
		
		if(!$this->input->post('sch_status_btn')) redirect(SURL);
		
		extract($this->input->post());
		
		$verify_prescription_status = $this->installment->get_rx_dose_data($this->session->my_pharmacy_id, '', $rx_sch_id);
		
		if(!$verify_prescription_status){
			
			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx');
		}else{

			//Verify both data is correct and valid
			
			if($status == 'M'){
				
				$change_rx_schedule_status = $this->installment->change_rx_schedule_status($this->input->post());
				
				if($change_rx_schedule_status){
	
					$this->session->set_flashdata('ok_message', 'Prescription status is successfully updated.');
					redirect(base_url().'installment/installment-rx');				
					
				}else{
	
					$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
					redirect(base_url().'installment/installment-rx');
				}//end if($change_rx_schedule_status)
				
			}elseif($status == 'C'){
				
				$get_rx_schedule_data = $this->installment->get_rx_dose_data($this->session->my_pharmacy_id, '', $rx_sch_id);
				redirect(base_url().'dashboard/register/'.$get_rx_schedule_data['drug_id'].'/'.$rx_sch_id.'?t=2');
			}//end if($status == 'M')
			
		}//end if(!$verify_prescription_status)
		
	}//end update_prescription_status_process($status,$rx_schedule_id)
	
	public function cancel_rx_patient_schedule(){
		
		if(!$this->input->post('cancel_script_sbt')) redirect(SURL);

		extract($this->input->post());
		
		$verify_if_schedule_exist = $this->installment->get_rx_schedule_data($this->session->my_pharmacy_id, $sch_id);
		
		if($verify_if_schedule_exist){	
		
			$cancel_rx_schedule = $this->installment->cancel_rx_schedule($this->session->uid, $this->session->my_pharmacy_id, $this->input->post());
			
			if($cancel_rx_schedule){

				$this->session->set_flashdata('ok_message', 'Prescription succesfully cancelled.');
				redirect(base_url().'installment/installment-rx');				
				
			}else{

				$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
				redirect(base_url().'installment/installment-rx');
				
			}//end if($cancel_rx_schedule)
		
		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong while adding new entry into the register, please try again later or contact system administrator');
			redirect(base_url().'installment/installment-rx');			
			
		}//end if($verify_if_schedule_exist){
		
	}//end function cancel_rx_patient_schedule()
	
	// Delete rxd delete_rx_schedule_notes
	
	public function delete_rx_schedule_notes(){

		if($this->input->post('noteid') !=''){
				
		$response = $this->installment->delete_rx_notes_schdule($this->input->post('noteid'));
	
		if($response)
			echo json_encode($response);
		else
			echo 'empty';
		}
		
	}//end delete_rx_schedule_notes()
	
} // End => Ci => Class Installment