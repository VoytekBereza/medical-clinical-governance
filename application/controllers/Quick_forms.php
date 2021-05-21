<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quick_forms extends MY_Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();
		
		 // Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		// Add JS Scripts for using in Organization
		$this->stencil->js('kod_scripts/organization/custom.js');

		// include org_dashboard.js to view contract [ Invitations response ]
		$this->stencil->js('org_dashboard.js');
		$this->stencil->css('jquery.fancybox.css');
		$this->stencil->css('star-rating.css');
		$this->stencil->js('jquery.fancybox.js');

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

		// Load model
		$this->load->model('quick_forms_mod', 'quick');
	}

	public function index(){
		
		//verify authorized request
		if(!$this->session->id) redirect(base_url().'dashboard');
		
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 
		 $this->breadcrumbcomponent->add('Quick Links', base_url().'quick-forms');
		
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		
		$this->load->model('cms_mod','cms');
		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('quick-links');
		
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
		
		// Get all quick forms
		$data['quick_forms_arr'] = $this->quick->get_all_quick_forms();
		
		//Loading Invitations (If Any)
		$get_user_invitations_arr = $this->invitations->get_user_invitations_list($this->session->id);
		$data['user_invitations_arr'] = $get_user_invitations_arr;

		$this->stencil->js('bootstrap-treeview');
		$this->stencil->layout('dashboard_template'); //dashboard_template
		$this->stencil->paint('quick_forms/quick_forms', $data);
		
	} // public function index()
	
} // End - CI_Controller

/* End of file */
