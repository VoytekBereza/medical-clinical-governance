<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pgd extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('pgd_mod','pgd');
		$this->load->model('Users_mod','users');
		$this->load->model('organization_mod','organization');

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
		
		//Page not on used at the moment
		//redirect(SURL.'login');		
		echo 'This is the index of PGD';
		
	} //end index()
	
	// Add new PGD function add_new_pgd()
	public function add_new_pgd($pgd_id = ''){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Show CK EDITOR
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template

		if($pgd_id == ''){
	
			// Set BreadCrumb Component
			$this->breadcrumbcomponent->add('Add New PGD', '#');
			
		}else{
			
			
			
			$get_pgd_details = $this->pgd->get_pgd_details($pgd_id);
			
			$data['get_pgd_details'] = $get_pgd_details;
			
			// Set BreadCrumb Component
			$this->breadcrumbcomponent->add('Update'.' '.$get_pgd_details['pgd_name'], '#');
		}//end if($pgd_id == '')
	
		// BreadCrumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$this->stencil->paint('pgd/add_new_pgd',$data);
		
	}//end add_new_pgd()
	
	//  add_new_pgd_process to adding new pgds
	public function add_new_pgd_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_pgd_btn')) redirect(base_url());
		
		$add_new_pgd = $this->pgd->add_new_pgd($this->input->post());
		
		if($add_new_pgd){
			
			$pgd_id = $this->input->post('pgd_id');

			if($pgd_id == ''){
				
				if(isset($add_new_pgd['error_upload'])){

				// if error form submision
			    $this->session->set_flashdata($this->input->post());
				$err_message = 'Image not uploaded';
				$this->session->set_flashdata('err_message', $err_message);						
				redirect(SURL.'pgd/add-new-pgd');
			} else {
				
				$this->session->set_flashdata('ok_message', 'New PGD added successfully.');
				redirect(SURL.'pgd/add-new-pgd');
			  }
				
			}else{
				
				if(isset($add_new_pgd['error_upload'])){
				
				$referrer_link  = $pgd_id.'?'.$this->input->post('tab_id').'=1';
				
				// if error form submision
			    $this->session->set_flashdata($this->input->post());
				
				$err_message = 'Image not uploaded';
				$this->session->set_flashdata('err_message', $err_message);						
			    redirect(SURL.'pgd/add-new-pgd/'.$referrer_link);
			} else {

				$referrer_link  = $pgd_id.'?'.$this->input->post('tab_id').'=1';
				$this->session->set_flashdata('ok_message', 'PGD updated successfully.');
				redirect(SURL.'pgd/add-new-pgd/'.$referrer_link);
			}
				
			}//end if($this->input->post('pgd_id') == '')
			
		}else{
			
			// if error form submision
			$this->session->set_flashdata($this->input->post());
			
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'pgd/add-new-pgd');

		}//end if($add_new_pgd)

	}//end add_new_pgd_process()
	
	// function add_new_subpgd
	public function add_new_subpgd($pgd_id, $subpgd_id = ''){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
        
		// PGD Details
		$pgd_details = $this->pgd->get_pgd_details($pgd_id);
		$data['pgd_details'] = $pgd_details;
		
		// show CK EDITOR
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template

		// Set BreadCrumb Component
		$this->breadcrumbcomponent->add('PGD', '#');
		
		if($subpgd_id == ''){
			
			// Set BreadCrumb Component
			$this->breadcrumbcomponent->add(filter_string($pgd_details['pgd_name']).' Add New Sub PGD', '#');
			
			$data['subpgd_id'] = '';
			
		}else{
			
			// Set BreadCrumb Component
			$this->breadcrumbcomponent->add(filter_string($pgd_details['pgd_name']).' Update Sub PGD', '#');
			
			$data['subpgd_id'] = $subpgd_id;
			$get_subpgd_details = $this->pgd->get_subpgd_details($subpgd_id);
			
			$data['get_subpgd_details'] = $get_subpgd_details;
		}//end if($pgd_id == '')
	
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['pgd_id'] = $pgd_id;		
		$this->stencil->paint('pgd/add_new_subpgd',$data);
		
	}//end add_new_subpgd()
	
	// Function add_new_subpgd_process to add subpgds
	public function add_new_subpgd_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_subpgdpgd_btn')) redirect(base_url());
		
		$pgd_id = $this->input->post('pgd_id');
		$subpgd_id = $this->input->post('subpgd_id');
		
		$add_new_pgd = $this->pgd->add_new_subpgd($this->input->post());
		
		if($add_new_pgd){
			
			if($subpgd_id == ''){
				$this->session->set_flashdata('ok_message', 'New Sub PGD added successfully.');
				redirect(SURL.'pgd/add-new-subpgd/'.$pgd_id);
			}else{
				$this->session->set_flashdata('ok_message', 'Sub PGD updated successfully.');
				redirect(SURL.'pgd/add-new-subpgd/'.$pgd_id.'/'.$subpgd_id);
				
			}//end if($subpgd_id == '')
			
		}else{
			
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'pgd/add-new-subpgd/'.$pgd_id);

		}//end if($add_new_pgd)

	}//end add_new_subpgd_process()
	
	// Start - rechas($pgd_id = ''):
	public function rechas($pgd_id = '', $rechas_id=''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Add Javascripts
		// chart js
		$this->stencil->js('chartjs/chart.min.js');
		// bootstrap progress js 
        $this->stencil->js('progressbar/bootstrap-progressbar.min.js');
        $this->stencil->js('nicescroll/jquery.nicescroll.min.js');
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
        //$this->stencil->js('custom.js');
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		$data['rechas_all'] = $this->pgd->get_pgd_rechas($pgd_id);
		
		$data['pgd_id'] = $pgd_id;
		
		// PGD Details
		$pgd_details = $this->pgd->get_pgd_details($pgd_id);
		$data['pgd_details'] = $pgd_details;
		
		// Set BreadCrumb Component
		$this->breadcrumbcomponent->add('PGD', '#');
		
		if($rechas_id != ''){ // Get Rechas
	
			// Set BreadCrumb Component
			$this->breadcrumbcomponent->add(filter_string($pgd_details['pgd_name']).' Edit Prerequisit', base_url().'pgd/index');
	
			$data['rechas'] = $this->pgd->get_rechas_by_id($rechas_id);			
			$data['form_action'] = 'update';
			
		} else { // else -> if($rechas_id != '')
		
			// Set BreadCrumb Component
			$this->breadcrumbcomponent->add('Prerequisit '.filter_string($pgd_details['pgd_name']), base_url().'pgd/index');
			$data['form_action'] = 'add';
		}
		
		$data['pgd_id'] = $pgd_id;
		
		// breadCrumb Output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_trainings
		$this->stencil->paint('pgd/rechas/list_all',$data);
		
	} // End - rechas($pgd_id = ''):
	
	// Start - add_update_rechas($pgd_id = '', $rechas_id=''):
	public function add_update_rechas($pgd_id = '', $rechas_id=''){
		
		$success = $this->pgd->add_update_rechas($this->input->post(), $pgd_id, $rechas_id);
		$action = $this->input->post('action');
		if($success){
			if($action == 'add')
				$this->session->set_flashdata('ok_message', 'Prerequisit successfully created.');
			else
				$this->session->set_flashdata('ok_message', 'Prerequisit has been successfully updated.');
			
			redirect(SURL.'pgd/rechas/'.$pgd_id.'/'.$rechas_id);
		} else {
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/rechas/'.$pgd_id.'/'.$rechas_id);
		}
		
	} // End - add_update_rechas($pgd_id = '', $rechas_id=''):
	
	// Start - delete_rechas($rechas_id=''):
	public function delete_rechas($pgd_id='', $rechas_id=''){
		
		$deleted = $this->pgd->delete_rechas($rechas_id);
		if($deleted)
			$this->session->set_flashdata('ok_message', 'Prerequisit successfully deleted.');
		else
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
		
		redirect(SURL.'pgd/rechas/'.$pgd_id);
	} // End - delete_rechas($rechas_id=''):
	
	// End - Rechas
	
	/* --------------------------------------------------------- */
	/* ------------- Start PGD Documents Section ---------- */
	/* --------------------------------------------------------- */
	
	// Start - list_all_document_categories():
	public function list_all_document_categories($category_id = ''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Add BreadCrumb component
		$this->breadcrumbcomponent->add('PGD', '#');
		
		// Pull all categories from db
		$data['categories'] = $this->pgd->list_all_document_categories();
		
		// Get all pgd
		$data['list_all_pgd'] = $this->pgd->get_all_package_pgd();

		if($category_id != ''){ // If update action requested
			
			// Add BreadCrumb component
			$this->breadcrumbcomponent->add('Update Document Category', base_url().'pgd/index');
			
			$data['category'] = $this->pgd->get_pgd_document_category($category_id);
			$data['form_action'] = 'update';
			
		} else {
			
			// Add BreadCrumb component
			$this->breadcrumbcomponent->add('Add New Document Category', base_url().'pgd/index');
			
			$data['form_action'] = 'add';
		}

		// Add BreadCrumb component
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// For Datatables
		$this->stencil->js('icheck/icheck.min.js');
		$this->stencil->js('datatables/js/jquery.dataTables.js');
		$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		$this->stencil->paint('pgd/pgd_document_categories', $data);
		
	} // End - list_all_document_categories():
	
	// Start - add_update_category():
	public function add_update_category(){
		
		$success = $this->pgd->add_update_category($this->input->post());

		
		if($this->input->post('pgd_id')!=""){
			$pgd_id = $this->input->post('pgd_id');
		}
		if($success){
			if($action == 'add')
				$this->session->set_flashdata('ok_message', 'Folder has been successfully added.');
			else
				$this->session->set_flashdata('ok_message', 'Folder has been successfully updated.');
			redirect(SURL.'pgd/documents-listing/'.$pgd_id);
		} else {
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/documents-listing/'.$pgd_id);
		}
		
	} // End - add_update_category():
	
	// Start - delete_document_category($category_id = ''):
	public function delete_document_category($pgd_id = '',$category_id = ''){

		if($category_id != ''){
			
			$deleted = $this->pgd->delete_document_category($category_id);
			if($deleted){
				
				// Success
				$this->session->set_flashdata('ok_message', 'Folder has been successfully deleted.');
				 redirect(SURL.'pgd/documents-listing/'.$pgd_id);
				
			} else {
				
				// Failure
				$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
				 redirect(SURL.'pgd/documents-listing/'.$pgd_id);
				
			} // else if($deleted):
			
		} else {
			
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/list-all-document-categories');
			
		} // else - if($category_id != ''):
	} // End - delete_document_category($category_id = ''):
	
	// Start - add_edit_document():
	public function add_edit_document($pgd_id = '', $document_id = ''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$data['document_categories'] = $this->pgd->get_all_pgd_document_categories($pgd_id);
		$data['pgds'] = $this->pgd->get_all_package_pgd();
		
		// Set BreadCrumb Component
		$this->breadcrumbcomponent->add('PGD', '#');
		$this->breadcrumbcomponent->add('Documents', base_url().'pgd/documents_listing/'.$pgd_id);
		
		if($document_id != ''){ // Update
		
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update', base_url().'pgd/documents_listing/'.$pgd_id);
			
			$data['form_action'] = 'update';
			$data['document'] = $this->pgd->get_pgd_document_by_document_id($document_id);
			
		} else { // Add New
		
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New', base_url().'pgd/documents_listing/'.$pgd_id);
			
			$data['form_action'] = 'add';
		}

		$data['pgd_id'] = $pgd_id;
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view
		$this->stencil->paint('pgd/documents/add_document', $data);
		
	} // End - add_edit_document():
	
	// Start - add_update_document():
	public function add_update_document(){
		
		// Form action - add or update
		$form_action = $this->input->post('action');
		
		// Send POST data to model
		$status = $this->pgd->add_update_document($this->input->post(), $form_action);
		
		$document_id = $this->input->post('document_id');
		$pgd_id = $this->input->post('package_pgd_id');
		
		if($status == true){ // On success
		
			if($form_action == 'add'){

				// Success message for Add
				$this->session->set_flashdata('ok_message', 'New document added successfully.');
				redirect(SURL.'pgd/documents-listing/'.$pgd_id);
		
			}elseif($form_action == 'update'){
				
				// Success message for Update
				$this->session->set_flashdata('ok_message', 'Document updated successfully.');
				redirect(SURL.'pgd/documents-listing/'.$pgd_id);
			}
			
		} else { // On failure
		
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/add-edit-document/'.$pgd_id);
		}
		
	} // End - add_update_document()
	
	// Start - documents_listing(): List all documents by PGD id
	public function documents_listing($pgd_id = ''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Get all documents by training id
		$documents = $this->pgd->documents_listing($pgd_id);
		
		$pgd_arr = $this->pgd->get_pgd_details($pgd_id);
		$data['pgd_arr'] = $pgd_arr;

		$this->stencil->js('bootstrap-treeview.js');
		$this->stencil->js('kod_scripts/custom.js');
		
		// Fancy Box Scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
		if(!empty($documents)){ // on success - data not empty

			$data['documents'] = $documents;

			// Load scripts
			$this->stencil->js('chartjs/chart.min.js');
			
			// bootstrap progress js 
			$this->stencil->js('progressbar/bootstrap-progressbar.min.js');
			$this->stencil->js('nicescroll/jquery.nicescroll.min.js');
			
			
		} else {
			$data['documents'] = NULL;
		}
		
		// Js file using for Users  validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Users file Validation
		
		// Js Form  form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		
		// Add scripts
		// icheck
		$this->stencil->js('icheck/icheck.min.js');
		// Datatables
		$this->stencil->js('datatables/js/jquery.dataTables.js');
		$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
				
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('PGD', '#');
		$this->breadcrumbcomponent->add($pgd_arr['pgd_name'].' Documents', base_url().'pgd/index');
		
		
	    $get_pgd_details = $this->pgd->get_pgd_details($pgd_id);
	    $data['get_pgd_details'] = $get_pgd_details;
		
		// Pull all categories from db
	    $data['categories_list'] = $this->pgd->get_pgd_documents_tree($pgd_id,$category_id);
	   
	    if($category_id != ''){ // If update action requested
			$data['form_action'] = 'update';
		} else {
			$data['form_action'] = 'add';
		}
		
		$data['pgd_id'] = $pgd_id;
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view pgd/list_all_documents
		$this->stencil->paint('pgd/documents/list_all_documents', $data);
		
	} // End - documents_listing():
	
	/////////////////////////////////////////////////////
	/////////////   Start - RAFs Section    /////////////
	
	// Start - rafs_listing(): List all documents by PGD id
	public function rafs_listing($pgd_id = '', $raf_id = ''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// PGD Details
		$pgd_details = $this->pgd->get_pgd_details($pgd_id);
		$data['pgd_details'] = $pgd_details;
		
		if($raf_id != ''){
			
			// Update RAF Requested
			$data['form_action'] = 'update';
			$data['raf'] = $this->pgd->get_pgd_raf_by_id($raf_id);
			
		} else {
			
			// Add RAF Requested
			$data['form_action'] = 'add';
			
		} // else -> if($raf_id != ''):
		
		// Get all raf_documents by traiining id
		$raf_documents = $this->pgd->get_rafs_listing($pgd_id);
		
		if(!empty($raf_documents)){ // on success - data not empty

			$data['rafs'] = $raf_documents;

			// Load scripts
			// chart js
			$this->stencil->js('chartjs/chart.min.js');
			// bootstrap progress js 
			$this->stencil->js('progressbar/bootstrap-progressbar.min.js');
			$this->stencil->js('nicescroll/jquery.nicescroll.min.js');
			// icheck
			$this->stencil->js('icheck/icheck.min.js');
			//$this->stencil->js('custom.js');
			// Datatables
			$this->stencil->js('datatables/js/jquery.dataTables.js');
			$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
			// Load custom file data_tables.js
			$this->stencil->js('kod_scripts/data_tables.js');
			$this->stencil->css('kod_css/jquery.dataTables.min.css');
			
		} else {
			$data['rafs'] = NULL;
		}
		
		// Set BreadCrumb Component
		$this->breadcrumbcomponent->add('PGD', '#');
		$this->breadcrumbcomponent->add(filter_string($pgd_details['pgd_name']).' RAFs', base_url().'pgd/index');
		
		$data['pgd_id'] = $pgd_id;
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view pgd/list_all_documents
		$this->stencil->paint('pgd/documents/list_all_rafs', $data);
		
	} // End - rafs_listing():
	
	// Start - add_update_rafs($pgd_id = '', $raf_id=''):
	public function add_update_rafs($pgd_id = '', $raf_id=''){
		
		$success = $this->pgd->add_update_rafs($this->input->post(), $pgd_id, $raf_id);
		$action = $this->input->post('action');
		if($success){
			if($action == 'add')
				$this->session->set_flashdata('ok_message', 'RAFs successfully created.');
			else
				$this->session->set_flashdata('ok_message', 'RAFs has been successfully updated.');
			
			redirect(SURL.'pgd/rafs_listing/'.$pgd_id.'/'.$raf_id);
		} else {
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/rafs_listing/'.$pgd_id.'/'.$raf_id);
		}
		
	} // End - add_update_rafs($pgd_id = '', $raf_id=''):
	
	// Start - delete_rafs
	public function delete_rafs($pgd_id='', $raf_id=''){
		
		if($raf_id != ''){
			
			$deleted = $this->pgd->delete_rafs($raf_id);
			
			if($deleted){ // On success
				
				$this->session->set_flashdata('ok_message', 'RAFs has been successfully deleted.');
				redirect(SURL.'pgd/rafs_listing/'.$pgd_id);
				
			} else { // In case failure
				
				$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
				redirect(SURL.'pgd/rafs_listing/'.$pgd_id);
				
			} // else - db error
			
		} else { // if no id given (to be deleted)
			
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/rafs_listing/'.$pgd_id);
			
		}
	} // End - delete_rafs():
	
	/////////////   End - RAFs Section    /////////////
	////////////////////////////////////////////////////
	
	// Start - delete_document
	public function delete_document($pgd_id='', $document_id=''){
		
		if($document_id != ''){
			
			$deleted = $this->pgd->delete_document($document_id);
			
			if($deleted){ // On success
				
				$this->session->set_flashdata('ok_message', 'File has been successfully deleted.');
				redirect(SURL.'pgd/documents-listing/'.$pgd_id);
				
			} else { // In case failure
				
				$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
				redirect(SURL.'trainings/documents-listing/'.$pgd_id);
				
			} // else - db error
			
		} else { // if no id given (to be deleted)
			
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/documents-listing/'.$pgd_id);
			
		}
	} // End - delete_document():
	
	/* --------------------------------------------------------- */
	/* -------------- Start PGD Videos Section ------------ */
	/* --------------------------------------------------------- */
	
	// Start - add_edit_video():
	public function add_edit_video($pgd_id = '', $video_id = ''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$data['pgds'] = $this->pgd->get_all_package_pgd();
		
		// PGD Details
		$pgd_details = $this->pgd->get_pgd_details($pgd_id);
		$data['pgd_details'] = $pgd_details;
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('PGD', '#');
		$this->breadcrumbcomponent->add(filter_string($pgd_details['pgd_name']).' Videos Listing', base_url().'pgd/videos-listing/'.$pgd_id);
		
		if($video_id != ''){ // Update
			
			// Set breadCrumb for update
			$this->breadcrumbcomponent->add('Update '.filter_string($pgd_details['pgd_name']).' Video', base_url().'pgd/index');
			
			$data['form_action'] = 'update';
			$data['video'] = $this->pgd->get_pgd_video_by_video_id($video_id);
			
		} else { // else if($video_id != ''): Add New Video
			
			// Set breadCrumb for Add New
			$this->breadcrumbcomponent->add('Add New '.filter_string($pgd_details['pgd_name']).' Video', base_url().'pgd/index');
			
			$data['form_action'] = 'add';
		} // else
		
		$data['pgd_id'] = $pgd_id;
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view
		$this->stencil->paint('pgd/videos/add_video', $data);
		
	} // End - add_edit_video():
	
	// Start - videos_listing(): List all documents by Training id
	public function videos_listing($pgd_id = ''){
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Get all videos
		$videos = $this->pgd->videos_listing($pgd_id);
		
		
		// Get all intro videos
		$videos_intro = $this->pgd->videos_intro_listing($pgd_id);
		$data['videos_intro'] = $videos_intro;
		
		// PGD Details
		$pgd_details = $this->pgd->get_pgd_details($pgd_id);
		$data['pgd_details'] = $pgd_details;
		
		if(!empty($videos)){ // on success - data not empty

			$data['videos'] = $videos;

			// Load scripts
			// chart js
			$this->stencil->js('chartjs/chart.min.js');
			// bootstrap progress js 
			$this->stencil->js('progressbar/bootstrap-progressbar.min.js');
			$this->stencil->js('nicescroll/jquery.nicescroll.min.js');
			// icheck
			$this->stencil->js('icheck/icheck.min.js');
			//$this->stencil->js('custom.js');
			// Datatables
			$this->stencil->js('datatables/js/jquery.dataTables.js');
			$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
			// Load custom file data_tables.js
			$this->stencil->js('kod_scripts/data_tables.js');
			$this->stencil->css('kod_css/jquery.dataTables.min.css');
			
		} else {
			$data['videos'] = NULL;
		}
		
		$data['pgd_id'] = $pgd_id;
		
		// Set BreadCrumb Component
		$this->breadcrumbcomponent->add('PGD', '#');
		$this->breadcrumbcomponent->add(filter_string($pgd_details['pgd_name']).' videos / presentations', base_url().'pgd/index');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view trainings/list_all_documents
		$this->stencil->paint('pgd/videos/list_all_videos', $data);

	} // End - videos_listing():
	
	// Start - add_update_video():
	public function add_update_video(){
		
		// Form action - add or update
		$form_action = $this->input->post('action');
		
		// Send POST data to model
		$status = $this->pgd->add_update_video($this->input->post(), $form_action);
		$video_id = $this->input->post('video_id');
		$pgd_id = $this->input->post('package_pgd_id');
		
		if($status == true){ // On success
		
			if($form_action == 'add'){

				// Success message for Add
				$this->session->set_flashdata('ok_message', 'New video added successfully.');
				redirect(SURL.'pgd/videos-listing/'.$pgd_id);
		
			}elseif($form_action == 'update'){
				
				// Success message for Update
				$this->session->set_flashdata('ok_message', 'Video updated successfully.');
				redirect(SURL.'pgd/add-edit-video/'.$pgd_id.'/'.$video_id);
			}
			
		} else { // On failure
		
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/videos-listing/'.$pgd_id);
		}
		
	} // End - add_update_video()
	
	// Start - delete_video
	public function delete_video($pgd_id = '', $video_id=''){
		
		if($video_id != ''){
			
			$deleted = $this->pgd->delete_video($video_id);
			
			if($deleted){ // On success
				
				$this->session->set_flashdata('ok_message', 'Video has been successfully deleted.');
				redirect(SURL.'pgd/videos-listing/'.$pgd_id);
				
			} else { // In case failure
				
				$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
				redirect(SURL.'pgd/videos-listing/'.$pgd_id);
				
			} // else - db error
			
		} else { // if no id given (to be deleted)
			
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/videos-listing/'.$pgd_id);
			
		}
	} // End - delete_video():

	// Start - set_video_as_default($pgd_id='', $video_id = ''):
	public function set_video_as_default($pgd_id = '', $video_id = ''){
		
		$success = $this->pgd->set_video_as_default($video_id);
		if($success){
			
			$this->session->set_flashdata('ok_message', 'Default video has been changed successfully.');
			redirect(SURL.'pgd/videos-listing/'.$pgd_id);
			
		} else {
			
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'pgd/videos-listing/'.$pgd_id);
		}
	} // End - set_video_as_default($pgd_id='', $video_id = ''):
	
	/* --------------------------------------------------------------- */
	/* ----------------- Start Quizes Section ------------------------ */
	/* --------------------------------------------------------------- */
	
	// Start - quizes($pgd_id=''):
	public function quizes($pgd_id=''){

		if($pgd_id != '')
			$data['quizes'] = $this->pgd->get_pgd_quizes($pgd_id);
		else
			$data['quizes'] = NULL;
		
		$data['pgd_id'] = $pgd_id;
		
		$pgd_detail = $this->pgd->get_pgd_details($pgd_id);
		$data['pgd_detail'] = $pgd_detail;
		
		// Set BreadCrumb Component
		$this->breadcrumbcomponent->add('PGD', '#');
		$this->breadcrumbcomponent->add($pgd_detail['pgd_name'].' Exam', '#');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		
		$this->stencil->js('kod_scripts/custom.js');
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Load view
		$this->stencil->paint('pgd/quizes/list_all', $data);
		
	} // End - quizes($pgd_id=''):

	// Start - quiz_by_id(): For the Ajax call in (js/kod_scripts/custom.js)
	public function quiz_by_id(){
		
		if($this->input->post('question_id')){
			$quiz = $this->pgd->quiz_by_id($this->input->post('question_id'));
		}
		else
			$quiz = NULL;
		
		echo json_encode(array('quiz' => $quiz));
		
	} // End - quiz_by_id():
	
	// Start - add_update_quiz($pgd_id=''):
	public function add_update_quiz($pgd_id=''){
		
		$success = $this->pgd->add_update_quiz($this->input->post(), $pgd_id);
			
		if($success == true){
			
			$this->session->set_flashdata('ok_message', 'Success.');
			redirect(SURL.'pgd/quizes/'.$pgd_id);
			
		} else {
			
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'pgd/quizes/'.$pgd_id);
			
		}
		
	} // End - add_update_quiz($pgd_id=''):
	
	// Start - delete_pgd($pgd_id):
	public function delete_pgd($pgd_id){	
	
	 	$deleted = $this->pgd->delete_pgd($pgd_id);
		if($deleted) {
			
			$this->session->set_flashdata('ok_message', 'PGD is deleted successfully.');
			redirect(SURL.'pgd/add-new-pgd');
			
		} else {
				
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'pgd/add-new-pgd/'.$pgd_id.'?p=1');
			
		}
	}
	
	// Start list_all_unauthenticated
	public function list_all_unauthenticated(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Fancy Box Scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');

		// Set Bread Crumb
		$this->breadcrumbcomponent->add('UnAuthenticated PGDs Listing', base_url().'pgd/unauthenticated-listing');
		
		$response = $this->pgd->get_all_unauthenticated_pgds();
		$response_signature = $this->pgd->get_defualt_doc_signature();
		
		$data['unauthenticated_list'] = $response;
		$data['response_signature'] = $response_signature;
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
				
		$this->stencil->paint('pgd/unauthenticated_listing',$data);
		
	} // end list_all_unauthenticated\
	
	
	public function list_all_unauthenticated2(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Fancy Box Scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');

		// Set Bread Crumb
		$this->breadcrumbcomponent->add('UnAuthenticated PGDs Listing', base_url().'pgd/unauthenticated-listing');
		
		$response = $this->pgd->get_all_unauthenticated_pgds2();
		$response_signature = $this->pgd->get_defualt_doc_signature();
		
		$data['unauthenticated_list'] = $response;
		$data['response_signature'] = $response_signature;
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
				
		$this->stencil->paint('pgd/unauthenticated_listing2',$data);
		
	} // end list_all_unauthenticated\

	// Start authentication-log
	public function authentication_log(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Fancy Box Scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');

		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Autentication PGDs Log', base_url().'pgd/');
		
		$authenticated_pgd_log = $this->pgd->get_authenticated_pgd_log();
		$data['authenticated_pgd_log'] = $authenticated_pgd_log;
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
				
		$this->stencil->paint('pgd/authentication_log',$data);
		
	} // end authentication_log
	
	// Prtocess unauthenticated_process()
	public function unauthenticated_process(){
	
	//If Post is not SET
		if(!$this->input->post() && !$this->input->post('pgd_unauthenticate_btn')) redirect(base_url());	
		
		$success = $this->pgd->unauthenticate_pgds($this->input->post());
		
		if($success) {
			
			$this->session->set_flashdata('ok_message', 'Authentication is  updated successfully.');
			redirect(SURL.'pgd/list-all-unauthenticated');
			
		} else {
				
			$this->session->set_flashdata('err_message', 'Something went wrong, Doctor or Pharmacist signature is required.');
			redirect(SURL.'pgd/list-all-unauthenticated');
		}		
	}// End Prtocess unauthenticated_process()	
	
	// Start edit_document
	public function edit_document($pgd_id = '', $category_id = '', $document_id = ''){
	
		$data['category'] = $this->pgd->get_pgd_document_category($category_id);

		if($document_id != ''){ // Update

            $this->breadcrumbcomponent->add('Update', base_url().'pgd/documents_listing/'.$pgd_id);

            $data['form_action'] = 'update';
			$data['pgd_id'] = $pgd_id;
			$data['category_id'] = $category_id;
            $data['document'] = $this->pgd->get_pgd_document_by_document_id($document_id);
			
        } 
		
		//load main template
        $this->stencil->layout('ajax_pages'); //page_template

        if($document_id != ''){ // Update

	       $this->stencil->paint('pgd/documents/edit_document', $data);

        } else {

            $data['category_id'] = $category_id;
            $data['pgd_id'] = $pgd_id;
            $data['form_action'] = 'add';
            $this->stencil->paint('pgd/documents/add_document', $data);

        } // if($document_id != '')
		
	} // edit_document
	
	// Start edit_document_category 
	public function edit_document_category($pgd_id = '', $category_id = ''){
		
		if($category_id != ''){ // Update

            $this->breadcrumbcomponent->add('Update', base_url().'pgd/documents-listing/'.$pgd_id);

            $data['form_action'] = 'update';
			$data['pgd_id'] = $pgd_id;
			$data['category_id'] = $category_id;
            $data['document_category'] = $this->pgd->get_pgd_document_category($category_id);
			
        } 
		
		// Js file using for Users  validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Users file Validation
		
		// Js Form  form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
 		
		//load main template
    	$this->stencil->layout('ajax_pages'); //page_template
	
		$data['category'] = $this->pgd->get_pgd_document_category($category_id);

		$this->stencil->paint('pgd/documents/edit_document_category', $data);
	
	} // edit_document_category
	
}/* End of file */
