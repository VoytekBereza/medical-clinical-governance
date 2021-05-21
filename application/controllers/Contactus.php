<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactus extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cms_mod', 'cms');
		$this->load->model('common_mod', 'common');
		
		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		//load main template
		$this->stencil->layout('frontend_template_subpage'); //frontend template
		
		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		$this->stencil->slice('header_top');
		
		//Sets the Left Navigation
		$this->stencil->slice('left_pane');

		//Sets the Right Navigation
		$this->stencil->slice('right_pane');
		
		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		$this->stencil->slice('footer_script');
	}

	public function index(){
		
		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('contact-us');
		
		//set title
		$page_title = $cms_data_arr['cms_page_arr']['page_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $cms_data_arr['cms_page_arr']['meta_description'],
			'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
		));
		
		$data['page_data'] = $cms_data_arr['cms_page_arr'];
		
		if($this->session->id){
			//If Logged in user get the FAQ for contact us
			
			$get_contact_faqs_arr = $this->common->get_contactus_faq_list();
			$data['contact_faqs_arr'] = $get_contact_faqs_arr;
			
		}//end if($this->session->id)
		
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		
		$this->stencil->js('https://www.google.com/recaptcha/api.js');
		
		$this->stencil->paint('contactus/contactus',$data);
		
	} //end index()
	
	public function contactus_process(){

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('contact_btn')) redirect(base_url());

		// Captcha Validation
		if($this->input->post('g-recaptcha-response') == ''){
			 
			$this->session->set_flashdata('err_message', 'Please verify Captcha');
			redirect(base_url().'contactus');

		}//end if($this->input->post('g-recaptcha-response') == '')
		
		$submit_contact_frm = $this->common->submit_contactus_form($this->input->post());
		
		if($submit_contact_frm){
			
			$this->session->set_flashdata('ok_message', 'Thanks for your comments, this has been sent to our administration team and they will get back to you shortly.');
			redirect(base_url().'contactus');

		}//end if($submit_contact_frm)
		
	}//end contactus_process()
}

/* End of file */
