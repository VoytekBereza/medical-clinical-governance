<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hubnet_survey extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('common_mod','common');
		$this->load->model('cms_mod','cms');
		$this->load->model('organization_mod','organization');
		$this->load->model('purchase_mod','purchase');
		$this->load->model('survey_mod','survey');
	}

	public function index(){
		
		$frame = 1;
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
		
		$this->stencil->paint('survey/hubnet_survey',$data);
			
	}
	
}

/* End of file */
