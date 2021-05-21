<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('common_mod','common');
		$this->load->model('cms_mod','cms');
		$this->load->model('organization_mod','organization');
		$this->load->model('purchase_mod','purchase');
		$this->load->model('survey_mod','survey');
	}

	public function index($survey_ref_no,$frame = ''){
		
		if(trim($survey_ref_no) =='') redirect(base_url());
		
		$get_survey_order_details = $this->survey->get_survey_order_details($survey_ref_no);
		
		if($get_survey_order_details){
			
			$data['survey_order_details'] = $get_survey_order_details;
			
			$check_if_survey_purchased = $this->survey->get_survey_purchased_pharmacies($get_survey_order_details['organization_id'],'P',$get_survey_order_details['pharmacy_surgery_id']);

			$NO_OF_SURVEY_ATTEMPTS = 'NO_OF_SURVEY_ATTEMPTS';
			$survey_no_of_attempts = get_global_settings($NO_OF_SURVEY_ATTEMPTS); //Set from the Global Settings
			$survey_no_of_required_attempts = filter_string($survey_no_of_attempts['setting_value']);

			$no_of_surveys_attempted = $this->survey->get_no_of_surveys_attempted($check_if_survey_purchased['survey_ref_no']);
			
			if(($check_if_survey_purchased && $check_if_survey_purchased['expiry_date'] != '0000-00-00') || ($get_survey_order_details['expiry_date'] != '0000-00-00' && $no_of_surveys_attempted < $survey_no_of_required_attempts)){
				//Survey is Purchased and is Started!
				//set title
				
				$page_title = $check_if_survey_purchased['pharmacy_surgery_name'].' Survey '.$get_survey_order_details['survey_year'];
				
				$this->stencil->title($page_title);	
				
				//Sets the Meta data
				$this->stencil->meta(array(
					'description' => $check_if_survey_purchased['pharmacy_surgery_name'].' Survey '.$get_survey_order_details['survey_year'],
					'keywords' => $check_if_survey_purchased['pharmacy_surgery_name'].',survey,'.$get_survey_order_details['survey_year']
				));

				//Get Array of Questions
				$get_questionnnair_arr = $this->survey->get_questionnaire_list();
				$data['questionnnair_arr'] = $get_questionnnair_arr;
				
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
				
				$this->stencil->css('built.css'); //full_width_template template
				
				//load main template
				$this->stencil->layout('full_width_template'); //full_width_template template
				
				//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
				$this->stencil->slice('footer_script');
				
				$data['check_if_survey_purchased'] = $check_if_survey_purchased;
				$this->stencil->paint('survey/survey',$data);
				
			}else{
				redirect(SURL.'organization/dashboard');
				
			}//end if($check_if_survey_purchased && $check_if_survey_purchased['expiry_date'] != '0000-00-00')
			
		}else{

			redirect(SURL.'organization/dashboard');
			
		}//end if($get_survey_order_details)
		
	} //end index()
	
	//Function submit_survey(): Process and Survey and Submit
	public function submit_survey(){

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('submit_suv_btn')) redirect(base_url());

		extract($this->input->post());
		
		if($survey_ref_no == '' || $pharmacy_surgery_id == '') redirect(base_url());

		$get_survey_order_details = $this->survey->get_survey_order_details($survey_ref_no);
		
		if($get_survey_order_details){
			
			$check_if_survey_purchased = $this->survey->get_survey_purchased_pharmacies($get_survey_order_details['organization_id'],'P',$get_survey_order_details['pharmacy_surgery_id']);

			$NO_OF_SURVEY_ATTEMPTS = 'NO_OF_SURVEY_ATTEMPTS';
			$survey_no_of_attempts = get_global_settings($NO_OF_SURVEY_ATTEMPTS); //Set from the Global Settings
			$survey_no_of_required_attempts = filter_string($survey_no_of_attempts['setting_value']);

			$no_of_surveys_attempted = $this->survey->get_no_of_surveys_attempted($check_if_survey_purchased['survey_ref_no']);
			
			if(($check_if_survey_purchased && $check_if_survey_purchased['expiry_date'] != '0000-00-00') || ($get_survey_order_details['expiry_date'] != '0000-00-00' && $no_of_surveys_attempted < $survey_no_of_required_attempts)){

				//Survey is Purchased and is Started!

				$submit_survey = $this->survey->submit_survey($this->input->post());
				
				if($submit_survey){
					
					//$this->session->set_flashdata('ok_message', "Thank you for your precious time and submitting your survey.");
					redirect(SURL.'thankyou/thank-you-survey');
					
				}//end if($submit_survey)
				
			}else{
				redirect(SURL.'organization/dashboard');
			}//end if($check_if_survey_purchased && $check_if_survey_purchased['expiry_date'] != '0000-00-00')
		}else{
			redirect(SURL.'organization/dashboard');
		}//end if($get_survey_order_details)
		
	}//end submit_survey
	
}

/* End of file */
