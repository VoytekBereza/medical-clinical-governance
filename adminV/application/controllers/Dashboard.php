<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		$this->load->model('login_mod','login');
		$this->load->model('Common_mod','common');
		$this->load->model('Dashbord_mod','dashboard');
		$this->load->model('Organization_mod','organization');
		
		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		//load main template
		$this->stencil->layout('dashboard_template'); //page_template
		
		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		$this->stencil->slice('header_top');
		
		//Sets the Left Navigation
		$this->stencil->slice('left_nav');

		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		$this->stencil->slice('footer_script');
	}

	public function index(){
		//Login Check
	 	$this->login->verify_is_user_login();
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		/*
		// Count all users
		$data['count_list_users'] = $this->dashboard->count_all_users();
		
		// Count all GMC
		$data['count_list_gmc'] = $this->dashboard->count_all_gmc();
		
		// Count all GPHC
		$data['count_list_gphc'] = $this->dashboard->count_all_gphc();
		
		// Count all NMC
		$data['count_list_nmc'] = $this->dashboard->count_all_nmc();
		
		// Count all None GPHC Prescriber
		$data['count_list_none_gphc_prescriber'] = $this->dashboard->count_all_none_gphc_prescriber();
		
		// Count all None NMC Prescriber
		$data['count_list_none_nmc_prescriber'] = $this->dashboard->count_all_none_nmc_prescriber();
		
		// Count all pharmacy_assistance
		$data['count_list_pharmacy_assistance'] = $this->dashboard->count_all_pharmacy_assistance();
		
		// Count all Technician
		$data['count_list_technician'] = $this->dashboard->count_all_technician();
		
		// Count all Pre-reg
		$data['count_list_pre_reg'] = $this->dashboard->count_all_pre_reg();
		
		// Count all Health Professional
		$data['count_list_health_professional'] = $this->dashboard->count_all_health_professional();
		
		// Count all Training
		$data['count_list_training'] = $this->dashboard->count_all_training();
		
		// Count all PGDS
		$data['count_list_pgds'] = $this->dashboard->count_all_pgds();
		
		// Count all Oral PGDS
		$data['count_list_oral_pgds'] = $this->dashboard->count_all_oral_pgds();
		
		// Count all Vaccine PGDS
		$data['count_list_vaccine_pgds'] = $this->dashboard->count_all_vaccine_pgds();
		
		// Count all Orders 
		$data['count_list_orders'] = $this->dashboard->count_all_orders();
		*/
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Users', base_url().'users/list-all-users');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Include Scripts
		
		// Fancy Box Scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom.js');
		// end Form CMS file Validation
		
		// Load CSS for
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		 // Add pgd.js : Having scripts to assign and remove pgds
        $this->stencil->js('kod_scripts/pgd.js');
		
		$this->load->model('users_mod', 'users');
		
		//  All users
		$data['list_users'] = $this->users->get_all_users($type);
		// Count all users
		$data['count_list_users'] = $this->users->count_all_users();
		// Count all GMC
		$data['count_list_gmc'] = $this->users->count_all_gmc();
		// Count all GPHC
		$data['count_list_gphc'] = $this->users->count_all_gphc();
		// Count all NMC
		$data['count_list_nmc'] = $this->users->count_all_nmc();
		// Count all None GPHC Prescriber
		$data['count_list_none_gphc_prescriber'] = $this->users->count_all_none_gphc_prescriber();
		// Count all None NMC Prescriber
		$data['count_list_none_nmc_prescriber'] = $this->users->count_all_none_nmc_prescriber();
		// Count all none verify users
		$data['list_none_verify_users'] = $this->users->count_all_none_verify_users();
		
		$this->stencil->paint('dashboard/dashboard',$data);
		
	} //end index()	
} /* End of file */