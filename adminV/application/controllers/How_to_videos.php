<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class How_to_videos extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('How_to_videos_mod','how_to_videos');

		// Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		//Navigational Tree for Left Pan
		//$this->nav_tree = $this->pgd->get_pgd_navigation_list('1');

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
		
		// Js form validation scripts
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
	}

	public function index(){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Get all videos
		$videos = $this->how_to_videos->get_video_listing();
		$data['videos'] = $videos;
		
		// Datatables
		$this->stencil->js('datatables/js/jquery.dataTables.js');
		$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Set BreadCrumb Component
		$this->breadcrumbcomponent->add('How to Videos Listing', '#');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view trainings/list_all_documents
		$this->stencil->paint('how_to_videos/list_all_videos', $data);

	} // End - index():
	
	public function add_edit_videos_process(){
		
		// Form action - add or update
		$form_action = $this->input->post('action');
		
		// Send POST data to model
		$status = $this->how_to_videos->add_update_video($this->input->post(), $form_action);
		
		$video_id = $this->input->post('video_id');
		
		if($status == true){ // On success
		
			if($form_action == 'add'){

				// Success message for Add
				$this->session->set_flashdata('ok_message', 'New video added successfully.');
				redirect(SURL.'how-to-videos');
		
			}elseif($form_action == 'update'){
				
				// Success message for Update
				$this->session->set_flashdata('ok_message', 'Video updated successfully.');
				redirect(SURL.'how-to-videos');
			}
			
		} else { // On failure
		
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'how-to-videos');
		}
		
	} // End - add_update_video()
	
	public function add_edit_video($video_id = ''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('How to Videos', base_url().'how-to-videos');
		
		if($video_id != ''){ // Update
			
			// Set breadCrumb for update
			$this->breadcrumbcomponent->add('Update Video', '#');
			
			$data['form_action'] = 'update';
			$data['video'] = $this->how_to_videos->get_video_listing($video_id);
			
		} else { // else if($video_id != ''): Add New Video
			
			// Set breadCrumb for Add New
			$this->breadcrumbcomponent->add('Add New Video', '#');
			
			$data['form_action'] = 'add';
		} // else
		
		$data['pgd_id'] = $pgd_id;
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view
		$this->stencil->paint('how_to_videos/add_video', $data);
		
	} // End - add_edit_video():

	// Start - delete_video
	public function delete_video($video_id=''){
		
		if($video_id != ''){
			
			$deleted = $this->how_to_videos->delete_video($video_id);
			
			if($deleted){ // On success
				
				$this->session->set_flashdata('ok_message', 'Video has been successfully deleted.');
				redirect(SURL.'how-to-videos');
				
			} else { // In case failure
				
				$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
				redirect(SURL.'how-to-videos');
				
			} // else - db error
			
		} else { // if no id given (to be deleted)
			
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'how-to-videos');
			
		}
	} // End - delete_video():
	
}/* End of file */