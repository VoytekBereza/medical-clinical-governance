<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('page_mod','page');
		
		//Navigational Tree for Left Pan
		//$this->nav_tree = $this->pgd->get_pgd_navigation_list('1');
		
		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');

		//Login Check for the sections defined in here.
	 	$this->login->verify_is_user_login();
		
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

	/*********************************************************/
	/* VOYGER MEDICAL										*/
	/********************************************************/

	// Function Add New Page
	public function add_new_page($page_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('CMS Page Listing', base_url().'page/list-all-page');

		if($page_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Page', base_url().'page/add-new-page');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Page', base_url().'page/add-new-page');
			
			$get_page_details = $this->page->get_page_details($page_id);
			
			$data['get_page_details'] = $get_page_details;
		}//end if($page_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('page/add_new_page',$data);
		
	}//end add_new_page()
	
	// Function add_new_page_process()
	public function add_new_page_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_page_btn')) redirect(base_url());
		
		 $add_new_page = $this->page->add_new_page($this->input->post()); 
		 
		 if($add_new_page){
			
			$page_id = $this->input->post('page_id');
			
			if($page_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New Page added successfully.');
				redirect(SURL.'page/list-all-page');
				
			}else{

				$referrer_link  = $page_id.'?'.$this->input->post('tab_id').'=1';
				$this->session->set_flashdata('ok_message', 'Page updated successfully.');
				redirect(SURL.'page/add-new-page/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $page_id.'?'.$this->input->post('tab_id').'=1';
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'page/add-new-page/'.$referrer_link);

		}//end if($add_new_page)

	}//end add_new_page_process()
	
	// Function delete_page
	public function delete_page($page_id){
		
			if($page_id!="")
			{
				$get_page_delete = $this->page->delete_page_db($page_id);
				
				if($get_page_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Page deleted successfully.');
					redirect(SURL.'page/list-all-page');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'page/list-all-page');
					
				}//end if if($delete_page != '')
				
			}//end if($page_id!="")
			
	}//end function delete_page($page_id)
	
	//Function list_all cms pages
	public function list_all_page(){		
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Add Javascripts
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('CMS Page Listing', base_url().'page/list-all-page');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Pages
		$data['list_page'] = $this->page->get_all_pages($page_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_pages
		$this->stencil->paint('page/list_all_page',$data);
		
	} // End - list_all_page():
	
	/*********************************************************/
	/*				END VOYAGER MEDICAL						*/
	/********************************************************/
	
	
	/*********************************************************/
	/* VOYAGER HEALTH										*/
	/********************************************************/

	// Function Add new page voyager health
	public function add_new_page_voyager_health($page_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// CK EDITOR
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Voyager Health CMS Page Listing', base_url().'page/list-all-page-voyager-health');

		if($page_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Page Voyager Health ', base_url().'page/add-new-page-voyager-health');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Page Voyager Health ', base_url().'page/add-new-page-voyager-health');
			
			$get_page_details = $this->page->get_page_details_voyger_health($page_id);
			
			$data['get_page_details_voyger_health'] = $get_page_details;
		}//end if($page_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('page/add_new_page_voyager_health',$data);
		
	}//end add_new_page_voyager_health()
	
	// Add new page voyager health
	public function add_new_page_voyager_health_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_page_btn')) redirect(base_url());
		 
		 $add_new_page = $this->page->add_new_page_voyger_health($this->input->post()); 
		
		 if($add_new_page){
			
			$page_id = $this->input->post('page_id');
			
			if($page_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New Page added successfully.');
				redirect(SURL.'page/list-all-page-voyager-health');
				
			}else{

				$referrer_link  = $page_id.'?'.$this->input->post('tab_id').'=1';
				$this->session->set_flashdata('ok_message', 'Page updated successfully.');
				redirect(SURL.'page/add-new-page-voyager-health/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $page_id.'?'.$this->input->post('tab_id').'=1';
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'page/add-new-page-voyager-health/'.$referrer_link);

		}//end if($add_new_page)
			
	}//end add_new_page_voyager_health_process()
	
	// Function delete_page_voyger_health
	public function delete_page_voyger_health($page_id){
		
			if($page_id!="")
			{
				$get_page_delete = $this->page->delete_page_voyger_health($page_id);
				
				if($get_page_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Page deleted successfully.');
					redirect(SURL.'page/list-all-page-voyager-health');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'page/list-all-page-voyager-health');
					
				}//end if if($delete_page != '')
				
			}//end if($page_id!="")
			
	}//end function delete_page_voyger_health($page_id)
	
	// list_all voyager health cms pages
	public function list_all_page_voyager_health(){		
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Add Javascripts
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Voyager Health CMS Pages Listing', base_url().'page/list-all-page-voyager-health');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Pages
		$data['list_page_voyger_health'] = $this->page->get_all_pages_voyger_health($page_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_page_voyager_health
		$this->stencil->paint('page/list_all_page_voyager_health',$data);
		
	} // End - list_all_page_voyager_health():
	
	/*********************************************************/
	/*				END VOYGER HEALTH						*/
	/********************************************************/
}/* End of file */