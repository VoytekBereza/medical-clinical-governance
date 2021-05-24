<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('delivery_mod','delivery');
		
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
	/* HAAD EXAM									*/
	/********************************************************/
	
	// Function Add New Delivery Method
	public function add_update_delivery($delivery_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
	
		$this->stencil->js('editors/ckeditor/ckeditor.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Delivery Method Listing', base_url().'delivery/list-all-delivery');
		
		if($delivery_id == '') {
		
		// Set Bread Crumb
			$this->breadcrumbcomponent->add('Add New Delivery Method', base_url().'delivery/add-update-delivery');
		} else{
			
			// Set Bread Crumb
			$this->breadcrumbcomponent->add('Update Delivery Method', base_url().'delivery/add-update-delivery');
			
			$get_delivery_details = $this->delivery->get_delivery_details($delivery_id);
			
			$data['get_delivery_details'] = $get_delivery_details;
		}//end if($delivery_id == '')
		
		// Js file using for CMS delivery validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('delivery/add_update_delivery',$data);
		
	}//end add_update_delivery()
	
	// Function add_new_delivery_process()
	public function add_new_delivery_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_delivery_btn')) redirect(base_url());
		
		 $add_update_delivery = $this->delivery->add_update_delivery($this->input->post()); 
		 
		 if($add_update_delivery){
			
			// Delivery Method Id
			$delivery_id = $this->input->post('delivery_id');
			
			if($delivery_id == ''){
				
				$this->session->set_flashdata('ok_message', 'New Delivery Method added successfully.');
				redirect(SURL.'delivery/list-all-delivery');
				
			}else{

				$referrer_link  = $delivery_id;
				$this->session->set_flashdata('ok_message', 'Delivery Method updated successfully.');
				redirect(SURL.'delivery/add-update-delivery/'.$referrer_link);
				
			}//end if($this->input->post('delivery_id') == '')
			
		}else{
			
			$referrer_link  = $delivery_id;
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'delivery/list-all-delivery/'.$referrer_link);

		}//end if($add_update_delivery)

	}//end add_new_delivery_process()
	
	// Function delete_delivery
	public function delete_delivery($delivery_id = ''){
		
			if($delivery_id!="")
			{
				$get_delivery_delete = $this->delivery->delete_delivery_db($delivery_id);
				
				if($get_delivery_delete == '1')
				{
					
					$this->session->set_flashdata('ok_message', 'Delivery Method deleted successfully.');
					redirect(SURL.'delivery/list-all-delivery');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'delivery/list-all-delivery');
					
				}//end if if($delete_delivery != '')
				
			}//end if($delivery_id!="")
			
	}//end function delete_delivery($delivery_id)
	
	//Function list_all cms delivery
	public function list_all_delivery(){		
		
		//set title
		$delivery_title = DEFAULT_TITLE;
		$this->stencil->title($delivery_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		

        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Delivery Method Listing', base_url().'delivery/list-all-delivery');
	
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Js file using for CMS delivery validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		// Get all Delivery Method
		$data['list_delivery'] = $this->delivery->get_all_delivery();
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Load view: list_all_delivery
		$this->stencil->paint('delivery/list_all_delivery',$data);
		
	} // End - list_all_delivery():
	
	/*********************************************************/
	/*				END VOYAGER MEDICAL					*/
	/********************************************************/
	
}/* End of file */
