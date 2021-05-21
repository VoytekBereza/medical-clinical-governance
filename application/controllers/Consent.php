<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consent extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		

		$this->load->model('common_mod','common');
		$this->load->model('cms_mod','cms');
		$this->load->model('organization_mod','organization');
		$this->load->model('pmr_mod','pmr');
		$this->load->model('users_mod','users');
		
	}

	public function index(){
		
		redirect(SURL);
		
	} //end index()
	
	//Function concent_agreement() Email activation process
	public function consent_agreement(){
		
		extract($this->input->get());

		$get_patient_details = $this->pmr->get_patient_details($pid);
		
		if($get_patient_details){
			
			$vaccine_new_inserted_ids = base64_decode($consent);
			$update_consent_agreement = $this->pmr->consent_agreement($pid,$vaccine_new_inserted_ids,$t);
			
			if($update_consent_agreement){

				$this->session->set_flashdata('ok_message', 'Thank you for your consent agreement.');
				redirect(base_url().'pages/thank-you');				
				
			}//end if($update_consent_agreement)
			

		}else{
			$this->session->set_flashdata('err_message', 'Invalid or Unauthorized Access.');
			redirect(base_url().'login');
			
		}//end if($get_patient_details)
		
	}//end concent_agreement()
	
}

/* End of file */
