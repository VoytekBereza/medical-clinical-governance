<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('users_mod','users');
		$this->load->model('Purchase_mod','purchase');
		$this->load->model('common_mod','common');
		$this->load->model('organization_mod','organization');
		$this->load->model('Governance_mod','governance');
		
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

	// Function list_all_organizations
	public function list_all_organizations(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Organization Listing', base_url().'organization/list-all-organizations');
		
		$response = $this->organization->get_all_organizations();
		
		$data['organization_list'] = $response;
		
        /*echo '<pre>';
		print_r($response);
		exit;
		*/
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('organization/list_all_organization',$data);
		
	} // end list_all_organizations
	
	// Function list_all_pharmacy show all pharmacy with specific organization id
	public function list_all_pharmacy($organzition_id =''){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get Organization company name and pharmacy name
		$get_organizaiotion_company_name_pharmacy_name = $this->organization->get_organizaiotion_company_name($organzition_id);
		
		// Get Organization company name
		$get_organizaiotion_company_name = $this->organization->get_organizaiotion_detail($organzition_id);
		
		$data['get_organizaiotion_details'] = $get_organizaiotion_company_name;
		
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Organization Listing', base_url().'organization/list-all-organizations');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add(filter_string($get_organizaiotion_company_name["company_name"]).' Pharmacy Listing', base_url().'organization/list-all-pharmacy');
		
		$response = $this->organization->get_all_pharmacy($organzition_id);
		
		$data['pharmacy_list'] = $response;	
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('organization/list_all_pharmacy',$data);
		
	} // end list_all_pharmacy
	
	// Function list_all_pharmacy_staff
	public function list_all_pharmacy_staff($organization_id,$pharmacy_id =''){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Get Organization company name and pharmacy name for staff
		$get_organizaiotion_company_name_pharmacy_name_for_staff = $this->organization->get_organizaiotion_company_name_for_staff($organization_id,$pharmacy_id);
		$data['get_organizaiotion_company_name_pharmacy_name_for_staff'] = $get_organizaiotion_company_name_pharmacy_name_for_staff;
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Organization Listing', base_url().'organization/list-all-organizations');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add(filter_string($get_organizaiotion_company_name_pharmacy_name_for_staff["company_name"]).' Pharmacy Listing', base_url().'organization/list-all-pharmacy/'.$organization_id);
		
		$this->breadcrumbcomponent->add(filter_string($get_organizaiotion_company_name_pharmacy_name_for_staff["pharmacy_surgery_name"]).' Staff Listing', base_url().'organization/list-all-pharmacy_staff');
		
		// Get all pharmacy staff
		$response = $this->organization->get_all_pharmacy_staff($pharmacy_id);
		
		$data['pharmacy_staff_list'] = $response;
		
       /* echo '<pre>';
		print_r($response);
		exit;*/
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('organization/list_all_pharmacy_staff',$data);
		
	} // end list_all_pharmacy_staff
	
	
	// show all pharmacies   using list_all_pharmacies function
	public function list_all_pharmacies(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Pharmacy Listing', base_url().'organization/list-all-pharmacies');
		
		$response = $this->organization->get_all_pharmacies_list();
		
		$data['pharmacy_list'] = $response;	
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('organization/list_all_pharmacies',$data);
		
	} // end list_all_pharmacies
	
	// Functon embed_code_pharmacies_process enable disable embed code of pharmacies
	public function embed_code_pharmacies_process () {
	
	//If Post is not SET
		if(!$this->input->post()) redirect(base_url());	
		
		$success = $this->organization->update_embed_code_enable_disable_pharamacies($this->input->post());
				
		if($success) {
			
			$this->session->set_flashdata('ok_message', 'Record  updated successfully.');
			redirect(SURL.'organization/list-all-pharmacies');
			
		} else {
				
			$this->session->set_flashdata('err_message', 'Something went wrong, Please checked embed code for enabled or disabled.');
			redirect(SURL.'organization/list-all-pharmacies');
		}		
	}// End Prtocess embed_code_pharmacies_process()	
	
	
	// show all pharmacies   using list_all_ajax_pharmacy function
	public function list_all_ajax_pharmacy(){
		
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Pharmacy Listing', base_url().'organization/list-all-ajax-pharmacy');
	
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		  // icheck
		  
		// Fancy Box scripts
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->css('jquery.fancybox.css');
		
        $this->stencil->js('icheck/icheck.min.js');
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom.js');
		// end Form CMS file Validation
		
		// Load CSS for
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
	       
		
		$this->stencil->paint('organization/list_all_pharmacy_ajax_call',$data);
		
	} // end list_all_ajax_pharmacy
	
	
	// 	pharmacy_ajax_list
	public function pharmacy_ajax_list(){
		
		echo $this->organization->get_all_pharmacy_ajax_call();
		
	}//end pharmacy_ajax_list()
	
	
	
	//view_pharmacy_staff
	public function view_pharmacy_staff($pharmacy_id) {
		
		// Get all pharmacy staff
		$pharmacy_staff_list = $this->organization->get_all_pharmacy_staff($pharmacy_id);
					
		// Start Table
		$tablebody_pharmacy_staff .='
		<h4>Pharmacy Staff</h4>
		<br />
		<table class="table table-striped table-bordered table-hover" id="example">
			<thead>
						<tr class="headings"> 
						<th>Organization Name </th>
						<th>Pharmacy Name</th>
						<th>User Name</th>
						<th>Mobile No</th>
						<th>Email_address</th>
						<th>Type</th>
						<th>User Type</th>
						</tr>
			</thead>
			<tbody>';
				if(!empty($pharmacy_staff_list)) 
				 {
					 foreach($pharmacy_staff_list as $key => $each)
					  {
						  
						  if($each['type']=="P"){ $pharmacy_type = "Pharmacy";} else {  $pharmacy_type = "Surgery";}
						   
							$tablebody_pharmacy_staff.='
							<tr class="even pointer"> 
							
								<td class=" ">'.ucfirst(filter_string($each['company_name'])).'</td>
								<td class=" ">'.ucfirst(filter_string($each['pharmacy_surgery_name'])).'</td>
								<td class=" ">'.filter_string($each['first_name'])." ".filter_string($each['last_name']).'</td>
								<td class=" ">'.filter_string($each['mobile_no']).'</td>
								<td class=" ">'.filter_string($each['email_address']).'</td>
								<td class=" ">'.$pharmacy_type.'</td>
								<td class=" ">'.filter_string($each['TypeName']).'</td>
							</tr>';
						 		 
					} // foreach($pharmacy_staff_list as $key => $each)
				 } else {
						   $tablebody_pharmacy_staff.=
						  '<tr class="">
							<td class=" " colspan="5">No record founded.</td>
						  </tr>';
						}

						   $tablebody_pharmacy_staff.=
			'</tbody>
							
		</table>';
			
			// end Table Body 
			
			echo $tablebody_pharmacy_staff;
			
	} // end  view_pharmacy_staff
	
	
	// Function update pharmacy
	public function update_pharmacy($pharmacy_id = ''){
	
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Pharmacy List', base_url().'organization/list-all-ajax-pharmacy');
		$this->breadcrumbcomponent->add('Update Pharmacy', '#');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		if($pharmacy_id != ''){

			$get_pharmacy_surgery_details = $this->organization->get_pharmacy_surgery_details($pharmacy_id);
            $data['get_pharmacy_surgery_details'] = $get_pharmacy_surgery_details;
			
			 $get_all_country = $this->organization->get_all_country();
             $data['get_all_country']=$get_all_country;
			
		}//end if($pharmacy_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		$this->stencil->paint('organization/edit_pharmacy',$data);
	}//end update_pharmacy()
		
		
	  // Start - add_update_pharmacy_surgery_process
    public function add_update_pharmacy_surgery_process(){

        //If Post is not SET
        if(!$this->input->post() && !$this->input->post('add_update_btn')) redirect(base_url());

        $update_pharmacy_surgery = $this->organization->add_update_pharmacy_surgery($this->input->post());

        if($update_pharmacy_surgery){
			
			$pharmacy_id = $this->input->post('pharmacy_id');
			
			if($pharmacy_id != ''){
				
					$this->session->set_flashdata('ok_message', 'Pharmacy updated successfully.');
				   redirect(SURL.'organization/list-all-ajax-pharmacy');
				
			}//end if($this->input->post('pharmacy_id') == '')
			
		}else{
			
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'organization/list-all-ajax-pharmacy');
		}//end if($add_new_page)
        
    } // End add_update_pharmacy_surgery_process():	

	// assing unassing pharamcy
	public function assign_unassign_pharmacy($name='',$pharmacy_id){

		if($pharmacy_id!=""){
			
			$assign_unassign_pharmacy = $this->organization->assign_unassign_pharmacy($name,$pharmacy_id);
			
			if($assign_unassign_pharmacy == '1'){
				$this->session->set_flashdata('ok_message', 'Pharmacy setting successfully updated');
				redirect($_SERVER['HTTP_REFERER']);
				
			} else {
				
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect($_SERVER['HTTP_REFERER']);
				
			}//end if if($assign_unassign_users != '')
			
		}//end if($pharmacy_id!="")
			
	}//end function assign_unassign_pharmacy($name='',$pharmacy_id)

	public function download_all_pharmacies_csv() {
	   
		$this->load->helper('url');
		
		$file_contents = $this->organization->download_csv_file_pharmacies(); 
		
		//$file_contents = load_file_from_id($_GET['id']);
		$file_name = 'all_pharmacies'.time().'.csv';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $file_contents;
	
	}//end download_all_users_csv
	
	public function assign_unassign_governance($type, $pharmacy_id, $org_owner_id, $order_id = ''){
		
		if($order_id){
			
			//Governance already assign, Unassign it
			$action = $this->purchase->unassign_governance($pharmacy_id, $order_id);
			
		}else{
			//Not asisgn/ Assign the Governance	
			$action = $this->purchase->assign_governance($pharmacy_id, $org_owner_id, $order_id);
		}
		
		if($action){
			
			if($order_id){

				$this->session->set_flashdata('ok_message', 'Governance settings unassigned for the selected pharmacy');
				redirect(SURL.'organization/list-all-ajax-pharmacy');

			}else{

				$this->session->set_flashdata('ok_message', 'Governance settings assigned to the selected pharmacy');
				redirect(SURL.'organization/list-all-ajax-pharmacy');
				
			}//end if($order_id)
			
		}else{

			$this->session->set_flashdata('err_message', 'Something went wrong, Please checked embed code for enabled or disabled.');
			redirect(SURL.'organization/list-all-ajax-pharmacy');
			
		}//end if($action)
		
	}//end assign_unassign_governance($pharmacy_id, $org_owner_id, $order_id = '')

} /* End of file */