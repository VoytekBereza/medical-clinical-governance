<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thankyou extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// Load models
		$this->load->model('cms_mod', 'cms');
		
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

		$cms_data_arr = $this->cms->get_cms_page('',21);
		
		if($cms_data_arr['cms_page_count'] == 0){
			redirect(base_url().'page-not-found');
		} else {
			
			//set title
			$page_title = $cms_data_arr['cms_page_arr']['page_title'];
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => $cms_data_arr['cms_page_arr']['meta_description'],
				'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
				'meta_title' => $cms_data_arr['cms_page_arr']['meta_title']
			));
			
			$data['page_data'] = $cms_data_arr['cms_page_arr'];
			
		}//end if($cms_data_arr['cms_page_count'] == 0)
		
		$this->stencil->paint('pages/cms',$data);
		
	} //end index()	

	public function thank_you_survey(){
		
		$cms_data_arr = $this->cms->get_cms_page('',55);
		
		if($cms_data_arr['cms_page_count'] == 0){
			redirect(base_url().'page-not-found');
		} else {
			
			//set title
			$page_title = $cms_data_arr['cms_page_arr']['page_title'];
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => $cms_data_arr['cms_page_arr']['meta_description'],
				'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
				'meta_title' => $cms_data_arr['cms_page_arr']['meta_title']
			));
			
			$data['page_data'] = $cms_data_arr['cms_page_arr'];
			
		}//end if($cms_data_arr['cms_page_count'] == 0)
		
		$this->stencil->paint('pages/cms',$data);
		
	} //end index()
}

/* End of file */
