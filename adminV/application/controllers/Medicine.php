<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicine extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('cities_mod','cities');
		$this->load->model('medicine_mod','medicine');

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
		
			// Js file using for Users  validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Users file Validation
		
		// Js Form  form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form  file Validation
	}

	public function index(){
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()

	/***********************************************************
	* Medicine Category Add Update Listing And Delete Function
	***********************************************************/
	
	// Function add_update_medicine_category
	public function add_update_medicine_category($category_id = ''){
	
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
		$this->breadcrumbcomponent->add('Medicine Category Listing', base_url().'medicine/list-all-medicine-category');
		
		// Get Parent Category List
		$parent_category_list = $this->medicine->parent_category_list();
	    $data['parent_category_list'] = $parent_category_list;

		if($category_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Medicine Category', base_url().'medicine/add-update-medicine-category');
			
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Medicine Category', base_url().'medicine/add-update-medicine-category');
			
			$get_medicine_category_details = $this->medicine->get_medicine_category_details($category_id);			
			$data['get_medicine_category_details'] = $get_medicine_category_details;
			
		}//end if($$category_id == '')
		
		// Js file using for CMS page validation
			$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
			$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('medicine/add_update_medicine_category',$data);
		
	}//end add_update_medicine_category()
	
	// Function  add_update_medicine_category_process
	public function add_update_medicine_category_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_category_btn')) redirect(base_url());
		
		 $add_update_medicine_category = $this->medicine->add_update_medicine_category($this->input->post()); 
		
		if($add_update_medicine_category){
			
			$category_id = $this->input->post('category_id');
			
			if($category_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Medicine Category added successfully.');
				redirect(SURL.'medicine/list-all-medicine-category');
				
			}else{

				$referrer_link  = $category_id;
				$this->session->set_flashdata('ok_message', 'Medicine Category updated successfully.');
				redirect(SURL.'medicine/add-update-medicine-category/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $category_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'medicine/add-update-medicine-category/'.$referrer_link);
		}

	}//end add_update_medicine_category_process()
	
	//Function  list_all_medicine_category 
	public function list_all_medicine_category(){		
		
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
		$this->breadcrumbcomponent->add('Medicine Category Listing', base_url().'medicine/list-all-medicine-category');

        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Medicine Category
		$data['list_all_medicine_category'] = $this->medicine->get_all_medicine_category();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_medicine_category
		$this->stencil->paint('medicine/list_all_medicine_category',$data);
		
	} // End - list_all_medicine_category():
	
	// Function delete_medicine_category
	public function delete_medicine_category($category_id){
		
			if($category_id!="")
			{
				$delete_medicine_category = $this->medicine->delete_medicine_category($category_id);
				
				if($delete_medicine_category == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Medicine category deleted successfully.');
					redirect(SURL.'medicine/list-all-medicine-category');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'medicine/list-all-medicine-category');
					
				}//end if if($delete_page != '')
				
			}//end if($category_id!="")
			
	}//end function delete_medicine_category($category_id)
	
	/*****************************************************
	* Medicine Add Update Listing And Delete Function
	*****************************************************/
	
	// Function add_update_medicine
	public function add_update_medicine($medicine_id = ''){
	
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
		$this->breadcrumbcomponent->add('Medicine Listing', base_url().'medicine/list-all-medicine');
		
		$medicine_category_list = $this->medicine->medicine_category_list();
	    $data['medicine_category_list'] = $medicine_category_list;
		
		$medicine_form_list = $this->medicine->medicine_form_list();
	    $data['medicine_form_list'] = $medicine_form_list;
		
		$medicine_list = $this->medicine->medicine_list();
	    $data['medicine_list'] = $medicine_list;

		if($medicine_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Medicine ', base_url().'medicine/add-update-medicine');
			
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Medicine', base_url().'medicine/add-update-medicine');
				
			$get_medicine_details = $this->medicine->get_medicine_details($medicine_id);			
			$data['get_medicine_details'] = $get_medicine_details;
			
			// Strength Deatail
			$get_medicine_strength_details = $this->medicine->get_medicine_strength_details($medicine_id);			
			$data['get_medicine_strength_details'] = $get_medicine_strength_details;
			
			// Quantity Details
		    $get_medicine_quantity_details = $this->medicine->get_medicine_quantity_details($medicine_id);			
			$data['get_medicine_quantity_details'] = $get_medicine_quantity_details;
		
		}//end if($$medicine_id == '')
		$this->stencil->js('kod_scripts/custom.js');
		// Js file using for form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end form file Validation
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('medicine/add_update_medicine',$data);
		
	}//end add_update_medicine()
	
	// Function  add_update_medicine_process
	public function add_update_medicine_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_medicine_btn')) redirect(base_url());
		
		 $add_update_medicine = $this->medicine->add_update_medicine($this->input->post()); 
		
		if($add_update_medicine){
			
			$medicine_id = $this->input->post('medicine_id');
			
			if($medicine_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Medicine added successfully.');
				redirect(SURL.'medicine/list-all-medicine');
				
			}else{

				$referrer_link  = $medicine_id;
				$this->session->set_flashdata('ok_message', 'Medicine updated successfully.');
				redirect(SURL.'medicine/add-update-medicine/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $medicine_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'medicine/add-update-medicine/'.$referrer_link);

		}

	}//end add_update_medicine_process()
	
	//Function  list_all_medicine
	public function list_all_medicine(){		
		
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
		$this->breadcrumbcomponent->add('Medicine Listing', base_url().'medicine/list-all-medicine');

		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Medicine
		$data['list_all_medicine'] = $this->medicine->get_all_medicine();
		
		// Get all Medicine Strength
		$data['list_all_medicine_strength'] = $this->medicine->get_all_medicine_strength();
		
			// Get all Medicine Quantity
		$data['list_all_medicine_quantity'] = $this->medicine->get_all_medicine_quantity();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_medicine
		$this->stencil->paint('medicine/list_all_medicine',$data);
		
	} // End - list_all_medicine():
	
	// Function delete_medicine
	public function delete_medicine($medicine_id){
		
			if($medicine_id!="")
			{
				$medicine_id = $this->medicine->delete_medicine($medicine_id);
				
				if($medicine_id == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Medicine deleted successfully.');
					redirect(SURL.'medicine/list-all-medicine');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'medicine/list-all-medicine');
					
				}//end if if($medicine_id != '')
				
			}//end if($medicine_id!="")
			
	}//end function delete_medicine($medicine_id)
	
	// Function delete_medicine_strength
	public function delete_medicine_strength($medicine_id,$strength_id){
		
			if($strength_id!="")
			{
				$strength_success= $this->medicine->delete_medicine_strength($strength_id);
				
				if($strength_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Strength deleted successfully.');
					redirect(SURL.'medicine/add-update-medicine/'.$medicine_id);
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'medicine/add-update-medicine/'.$medicine_id);
					
				}//end if if($strength_id != '')
				
			}//end if($strength_id!="")
			
	}//end function delete_medicine_strength($strength_id)
	
	// Function delete_medicine_quantity
	public function delete_medicine_quantity($medicine_id,$quantity_id){
		
			if($quantity_id!="")
			{
				$quantity_success= $this->medicine->delete_medicine_quantity($quantity_id);
				
				if($quantity_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Quantity deleted successfully.');
					redirect(SURL.'medicine/add-update-medicine/'.$medicine_id);
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'medicine/add-update-medicine/'.$medicine_id);
					
				}//end if if($quantity_id != '')
				
			}//end if($quantity_id!="")
			
	}//end function delete_medicine_quantity($quantity_id)
	
	/*****************************************************
	* Medicine Add Update Listing And Delete Function
	*****************************************************/
	
	// Function add_update_medicine_info
	public function add_update_medicine_info($medicine_id,$medicine_info_id = ''){
		
		// Get Medicine Details
		$medicine_details = $this->medicine->get_medicine_details($medicine_id);
		$data['medicine_details'] = $medicine_details;
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$medicine_id = $medicine_id;
		$medicine_info_id = $medicine_info_id;

		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Medicine Listing', base_url().'medicine/list-all-medicine');
		$this->breadcrumbcomponent->add(filter_string($medicine_details['medicine_name']).' info Listing', base_url().'medicine/list-all-medicine-info/'.$medicine_id);
			
		/*$medicine_list = $this->medicine->medicine_list();
	    $data['medicine_list'] = $medicine_list;*/

		if($medicine_info_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New '.filter_string($medicine_details['medicine_name']).' info ', base_url().'medicine/add-update-medicine-info');
			
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update '.filter_string($medicine_details['medicine_name']).' info', base_url().'medicine/add-update-medicine-info');
				
			$get_medicine_info_details = $this->medicine->get_medicine_info_details($medicine_info_id);			
			$data['get_medicine_info_details'] = $get_medicine_info_details;
			
		}//end if($$medicine_id == '')
		$this->stencil->js('kod_scripts/custom.js');
		// Js file using for form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end form file Validation

		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('medicine/add_update_medicine_info',$data);
		
	}//end add_update_medicine_info()
	
	// Function  add_update_medicine_info_process
	public function add_update_medicine_info_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_medicine_info_btn')) redirect(base_url());
		
		 $add_update_medicine_info = $this->medicine->add_update_medicine_info($this->input->post()); 
		 
		 $medicine_info_id = $this->input->post('medicine_info_id');
		 $medicine_id = $this->input->post('medicine_id');
			
		if($add_update_medicine_info){
			
			if($medicine_info_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Medicine info added successfully.');
				redirect(SURL.'medicine/list-all-medicine-info/'.$medicine_id );
				
			}else{

				$referrer_link  = $medicine_info_id;
				$this->session->set_flashdata('ok_message', 'Medicine info updated successfully.');
				redirect(SURL.'medicine/add-update-medicine-info/'.$medicine_id.'/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $medicine_info_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'medicine/add-update-medicine-info/'.$medicine_id.'/'.$referrer_link);

		}
			
	}//end add_update_medicine_info_process()
	
	//Function  list_all_medicine_info
	public function list_all_medicine_info($medicine_id =''){		
		
		
		// Get Medicine Details
		$medicine_details = $this->medicine->get_medicine_details($medicine_id);
		$data['medicine_details'] = $medicine_details;
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Medicine Listing', base_url().'medicine/list-all-medicine');
		$this->breadcrumbcomponent->add(filter_string($medicine_details['medicine_name']).' info Listing', base_url().'medicine/list-all-medicine-info');

        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Medicine info
		$data['list_all_medicine_info'] = $this->medicine->get_all_medicine_info($medicine_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_medicine_info
		$this->stencil->paint('medicine/list_all_medicine_info',$data);
		
	} // End - list_all_medicine_info():
	
	// Function delete_medicine_info
	public function delete_medicine_info($medicine_id,$medicine_info_id){
		
			if($medicine_info_id!="")
			{
				$medicine_info_success = $this->medicine->delete_medicine_info($medicine_info_id);
				
				if($medicine_info_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Medicine info deleted successfully.');
					redirect(SURL.'medicine/list-all-medicine-info/'.$medicine_id);
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'medicine/list-all-medicine-info/'.$medicine_id);
					
				}//end if if($medicine_info_id != '')
				
			}//end if($medicine_info_id!="")
			
	}//end function delete_medicine_info($medicine_info_id)
	
     // Function  update_medicine_info_order_process
	public function update_medicine_info_order_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('info_order_btn')) redirect(base_url());
		
		 $update_medicine_info_success = $this->medicine->update_medicine_info_ordering($this->input->post()); 
		 
		 $medicine_id = $this->input->post('medicine_id');
		
		if($update_medicine_info_success=='1'){
		
			$this->session->set_flashdata('ok_message', 'Medicine info ordering updated successfully.');
			redirect(SURL.'medicine/list-all-medicine-info/'.$medicine_id);			
		}else{
			
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'medicine/list-all-medicine-info/'.$medicine_id);
		}
			
	}//end update_medicine_info_order_process()
	
	/*****************************************************
	* Medicine RAF Add Update Listing And Delete Function
	*****************************************************/
	
	// Function add_update_medicine_raf
	public function add_update_medicine_raf($medicine_id,$medicine_raf_id = ''){
		
		
		
		$medicine_details = $this->medicine->get_medicine_details($medicine_id);
		
		$data['medicine_details'] = $medicine_details;
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$medicine_id = $medicine_id;
		$medicine_raf_id = $medicine_raf_id;

		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Medicine Listing', base_url().'medicine/list-all-medicine');
		$this->breadcrumbcomponent->add(filter_string($medicine_details['medicine_name']).' RAF Listing', base_url().'medicine/list-all-medicine-raf/'.$medicine_id);
			
		$medicine_raf_labels_list = $this->medicine->medicine_raf_labels_list();
	    $data['medicine_raf_labels_list'] = $medicine_raf_labels_list;

		if($medicine_raf_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New '.filter_string($medicine_details['medicine_name']).' RAF ', base_url().'medicine/add-update-medicine-raf');
			
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update '.filter_string($medicine_details['medicine_name']).' RAF', base_url().'medicine/add-update-medicine-raf');
				
			$get_medicine_raf_details = $this->medicine->get_medicine_raf_details($medicine_raf_id);			
			$data['get_medicine_raf_details'] = $get_medicine_raf_details;
			
		}//end if($$medicine_id == '')
		$this->stencil->js('kod_scripts/custom.js');
		// Js file using for form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end form file Validation

		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('medicine/add_update_medicine_raf',$data);
		
	}//end add_update_medicine_raf()
	
	// Function  add_update_medicine_raf_process
	public function add_update_medicine_raf_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_medicine_raf_btn')) redirect(base_url());
		
		 $add_update_medicine_raf = $this->medicine->add_update_medicine_raf($this->input->post()); 
		 
		 $medicine_raf_id = $this->input->post('medicine_raf_id');
		 $medicine_id = $this->input->post('medicine_id');
		
		if($add_update_medicine_raf){
						
			if($medicine_raf_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Medicine RAF added successfully.');
				redirect(SURL.'medicine/list-all-medicine-raf/'.$medicine_id );
				
			}else{

				$referrer_link  = $medicine_raf_id;
				$this->session->set_flashdata('ok_message', 'Medicine RAF updated successfully.');
				redirect(SURL.'medicine/add-update-medicine-raf/'.$medicine_id.'/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $medicine_raf_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'medicine/add-update-medicine-info/'.$medicine_id.'/'.$referrer_link);
		}
			
	}//end add_update_medicine_raf_process()
	
	//Function  list_all_medicine_raf
	public function list_all_medicine_raf($medicine_id =''){	
	
		// Get Medicine Details
		$medicine_details = $this->medicine->get_medicine_details($medicine_id);
		$data['medicine_details'] = $medicine_details;
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));

        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Medicine Listing', base_url().'medicine/list-all-medicine');
		$this->breadcrumbcomponent->add(filter_string($medicine_details['medicine_name']).' Raf Listing', base_url().'medicine/list-all-medicine-raf');

		
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		$this->stencil->js('kod_scripts/custom.js');
		
		// Get all Medicine info
		
		$medicine_raf_labels_list = $this->medicine->medicine_raf_labels_list();
	    $data['medicine_raf_labels_list'] = $medicine_raf_labels_list;

		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
	
		$data['list_all_medicine_raf'] = $this->medicine->get_all_medicine_raf($medicine_id);
		
			
		// Load view: list_all_medicine_info
		$this->stencil->paint('medicine/list_all_medicine_raf',$data);
		
	} // End - list_all_medicine_raf():
	
	// Function delete_medicine_raf
	public function delete_medicine_raf($medicine_id,$medicine_raf_id){
		
			if($medicine_raf_id!="")
			{
				$medicine_raf_success = $this->medicine->delete_medicine_raf($medicine_raf_id);
				
				if($medicine_raf_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Medicine RAF deleted successfully.');
					redirect(SURL.'medicine/list-all-medicine-raf/'.$medicine_id);
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'medicine/list-all-medicine-raf/'.$medicine_id);
					
				}//end if if($medicine_raf_id != '')
				
			}//end if($medicine_raf_id!="")
			
	}//end function delete_medicine_raf($medicine_id,$medicine_raf_id)

	/*****************************************************
	* Medicine RAF Add Update Listing And Delete Function
	*****************************************************/
	
	// Function add_update_medicine_category_raf
	public function add_update_medicine_category_raf($category_id,$medicine_category_raf_id = ''){
	
		// Get Category Details
		$category_details = $this->medicine->get_medicine_category_details($category_id);
		$data['category_details'] = $category_details;
    
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		$category_id = $category_id;
		$medicine_category_raf_id = $medicine_category_raf_id;

		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Medicine Category Listing', base_url().'medicine/list-all-medicine-category');
		$this->breadcrumbcomponent->add(filter_string($category_details['category_title']).' RAF Listing', base_url().'medicine/list-all-medicine-category-raf/'.$category_id);
			
		$medicine_raf_labels_list = $this->medicine->medicine_raf_labels_list();
	    $data['medicine_raf_labels_list'] = $medicine_raf_labels_list;

		if($medicine_category_raf_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New '.filter_string($category_details['category_title']).' RAF ', base_url().'medicine/add-update-medicine-category-raf');
			
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update '.filter_string($category_details['category_title']).' RAF', base_url().'medicine/add-update-medicine-category-raf');
				
			$get_medicine_category_raf_details = $this->medicine->get_medicine_category_raf_details($medicine_category_raf_id);			
			$data['get_medicine_category_raf_details'] = $get_medicine_category_raf_details;
			
		}//end if($$medicine_id == '')
		$this->stencil->js('kod_scripts/custom.js');
		// Js file using for form validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end form file Validation

		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('medicine/add_update_medicine_category_raf',$data);
		
	}//end add_update_medicine_category_raf()
	
	// Function  add_update_medicine_category_raf_process
	public function add_update_medicine_category_raf_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_medicine_category_raf_btn')) redirect(base_url());
		
		 $add_update_medicine_category_raf = $this->medicine->add_update_medicine_category_raf($this->input->post()); 
		 
		 $medicine_category_raf_id = $this->input->post('medicine_category_raf_id');
		 $category_id = $this->input->post('category_id');
			
		
		if($add_update_medicine_category_raf){
			
			if($medicine_category_raf_id == ''){
				
				$this->session->set_flashdata('ok_message', 'Medicine category RAF added successfully.');
				redirect(SURL.'medicine/list-all-medicine-category-raf/'.$category_id );
				
			}else{

				$referrer_link  = $medicine_category_raf_id;
				$this->session->set_flashdata('ok_message', 'Medicine category RAF updated successfully.');
				redirect(SURL.'medicine/add-update-medicine-category-raf/'.$category_id.'/'.$referrer_link);
				
			}//end if($this->input->post('page_id') == '')
			
		}else{
			
			$referrer_link  = $medicine_category_raf_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'medicine/add-update-medicine-info/'.$category_id.'/'.$referrer_link);
		}
	}//end add_update_medicine_category_raf_process()
	
	//Function  list_all_medicine_category_raf
	public function list_all_medicine_category_raf($category_id =''){		
		
		
		// Get Category Details
		$category_details = $this->medicine->get_medicine_category_details($category_id);
		$data['category_details'] = $category_details;

		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
				
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Medicine Category Listing', base_url().'medicine/list-all-medicine-category');
		$this->breadcrumbcomponent->add(filter_string($category_details['category_title']).' Raf Listing', base_url().'medicine/list-all-medicine-category-raf');

        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get all Medicine category RAF
		$data['list_all_medicine_category_raf'] = $this->medicine->get_all_medicine_category_raf($category_id);
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_medicine_category_raf
		$this->stencil->paint('medicine/list_all_medicine_category_raf',$data);
		
	} // End - list_all_medicine_category_raf():
	
	// Function delete_medicine_category_raf
	public function delete_medicine_category_raf($category_id,$medicine_category_raf_id){
		
			if($medicine_category_raf_id!="")
			{
				$medicine_category_raf_success = $this->medicine->delete_medicine_category_raf($medicine_category_raf_id);
				
				if($medicine_category_raf_success == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Medicine category RAF deleted successfully.');
					redirect(SURL.'medicine/list-all-medicine-category-raf/'.$category_id);
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'medicine/list-all-medicine-category-raf/'.$category_id);
					
				}//end if if($medicine_raf_id != '')
				
			}//end if($medicine_raf_id!="")
			
	}//end function delete_medicine_category_raf($category_id,$medicine_category_raf_id)
	
//Function  list_all_medicine_raf
	public function list_all_medicine_raf_ajax(){		
		
		 $raf_lable_id_ajax = $this->input->post('raf_lable_id');
		 $medicine_id_ajax = $this->input->post('medicine_id');
	
		if($raf_lable_id_ajax!="" && $medicine_id_ajax!="")
		{
		
			$data['list_all_medicine_raf_labels_ajax'] = $this->medicine->get_all_medicine_raf_label_ajax($medicine_id_ajax,$raf_lable_id_ajax);
			
			//echo json_encode($list_all_medicine_raf_labels_ajax);
			 // Load view: list_all_medicine_raf_ajax
			 
			 
		  echo $this->load->view('medicine/list_all_medicine_raf_ajax',$data,true);
		
		} else {
			
			$data['list_all_medicine_raf_labels_ajax'] = $this->medicine->get_all_medicine_raf_label_ajax($medicine_id_ajax,'');
			
			 echo $this->load->view('medicine/list_all_medicine_raf_ajax',$data,true);
		}
		
	} // End - list_all_medicine_raf():
	
	 // Function  update_medicine_raf_order_process
	public function update_medicine_raf_order_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('info_order_btn')) redirect(base_url());
		
		 $update_medicine_raf_success = $this->medicine->update_medicine_raf_ordering($this->input->post()); 
		 
		 $medicine_id = $this->input->post('medicine_id');
		
		if($update_medicine_raf_success=='1'){
		
			$this->session->set_flashdata('ok_message', 'Medicine RAF ordering updated successfully.');
			redirect(SURL.'medicine/list-all-medicine-raf/'.$medicine_id);			
		}else{
			
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'medicine/list-all-medicine-raf/'.$medicine_id);
		}
	}//end update_medicine_raf_order_process()
}/* End of file */