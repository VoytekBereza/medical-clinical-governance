<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailtemplates extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('template_mod','template');
		
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
	
	} // End  public function __construct()

	public function index(){
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()

	public function add_new_template($template_id = ''){
	
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
		$this->breadcrumbcomponent->add('Templates Listing', base_url().'emailtemplates/list-all-templates');

		if($template_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Template', base_url().'emailtemplates/add-new-template');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Template', base_url().'emailtemplates/add-new-template');
			
			$get_template_details = $this->template->get_template_details($template_id);
			
			$data['get_template_details'] = $get_template_details;
		}//end if($template_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('emailtemplates/add_new_template',$data);
		
	}//end add_new_template()
	
	public function add_new_template_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_template_btn')) redirect(base_url());
		
		// Add New Template Call add_new_template function from template_mod model
		 $add_new_template = $this->template->add_new_template($this->input->post()); 
		
		if($add_new_template){
			
			$template_id = $this->input->post('template_id');
			
			if($template_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New Email Template added successfully.');
				redirect(SURL.'emailtemplates/list-all-templates');
				
			}else{

				$referrer_link  = $template_id.'?'.$this->input->post('tab_id').'=1';
				$this->session->set_flashdata('ok_message', 'Email Template updated successfully.');
				redirect(SURL.'emailtemplates/add-new-template/'.$referrer_link);
				
			}//end if($this->input->post('template_id') == '')
			
		}else{
			
			$referrer_link  = $template_id.'?'.$this->input->post('tab_id').'=1';
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'emailtemplates/add-new-template/'.$referrer_link);

		}//end if($add_new_template)
	
	}//end add_new_template_process()
	
	public function delete_template($template_id){
		
			if($template_id!="")
			{
				// Delete Template from database call template_mod
				$get_template_delete = $this->template->delete_template($template_id);
				
				if($get_template_delete == '1')
				{
					$this->session->set_flashdata('ok_message', 'Email Template deleted successfully.');
					redirect(SURL.'emailtemplates/list-all-templates');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'emailtemplates/list-all-templates');
					
				}//end if if($get_template_delete != '')
				
			}//end if($template_id!="")
			
	}//end function delete_template($template_id)
	
	// list_all Email Templates
	public function list_all_templates(){		
		
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
		$this->breadcrumbcomponent->add('Templates Listing', base_url().'emailtemplates/list-all-templates');
		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Pages
		$data['list_templates'] = $this->template->get_all_templates($template_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_templates
		$this->stencil->paint('emailtemplates/list_all_templates',$data);
		
	} // End - list_all_template():
	
} /* End of file */
