<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Purchase_mod', 'purchase');
		$this->load->model('Login_mod','login');
		$this->load->model('Common_mod','common');
		$this->load->model('Cities_mod','cities');
		$this->load->model('Users_mod','users');
		$this->load->model('Patient_mod','patient');
		$this->load->model('Pgd_mod','pgd');
		$this->load->model('Organization_mod','organization');
		$this->load->model('Governance_mod','governance');
		$this->load->model('Trainings_mod','training');
		$this->load->model('buyinggroup_mod','buyinggroup');

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
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		// end Form CMS file Validation
	}

	public function index(){
		//Page not on used at the moment
		redirect(SURL.'login');		
		
	} //end index()

	// Function Update user update_users($users_id = '')
	public function update_users($users_id = ''){
		
		//Active Organization Country List
		$country_active_arr = $this->common->get_active_countries();
		$data['country_active_arr'] = $country_active_arr;
		

		//Active Buying Group List
		$buyinggroup_active_arr = $this->buyinggroup->get_active_buyinggroups();
		$data['buyinggroup_active_arr'] = $buyinggroup_active_arr;
	
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Users', base_url().'users/list-all-users');
		$this->breadcrumbcomponent->add('Update', '#');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// CK EDITOR
		$this->stencil->js('editors/ckeditor/ckeditor.js'); //page_template

		if($users_id != ''){

			$get_users_details = $this->users->get_users_details($users_id);
			
			$data['get_users_details'] = $get_users_details;
		
			//Active Locum Cities List
			$cities_active_arr = $this->cities->get_active_cities();
			$data['cities_active_arr'] = $cities_active_arr;
			
			//Selected Locum Cities List
			$cities_selected_arr = $this->users->get_all_selected_city($users_id);
			$data['cities_selected_arr'] = $cities_selected_arr;
			
		}//end if($users_id == '')
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		$this->stencil->paint('users/update_users',$data);
	}//end update_users()
	
	// Function update_users_process 
	public function update_users_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('new_users_btn')) redirect(base_url());
		
		 $update_users = $this->users->update_users($this->input->post()); 
		 $users_id = $this->input->post('users_id');

		if($update_users === 'email_exist'){
			
			$referrer_link  = $users_id.'?'.$this->input->post('tab_id').'=1';
			$this->session->set_flashdata('err_message', 'Email already exist.');
		    redirect(SURL.'users/update-users/'.$referrer_link);
		}else{
			
			if($users_id != ''){
				
				$referrer_link  = $users_id.'?'.$this->input->post('tab_id').'=1';
				$this->session->set_flashdata('ok_message', 'User updated successfully.');
				redirect(SURL.'users/update-users/'.$referrer_link);
				
			}else {
				$referrer_link  = $users_id.'?'.$this->input->post('tab_id').'=1';
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect(SURL.'users/update-users/'.$referrer_link);
	
			}//end if($update_users)

		}//end if($update_users == 'email_exist')
		
	}//end update_users_process()
	
	public function delete_users($users_id){

		if($users_id!="")
			{
				$get_users_delete = $this->users->delete_users_db($users_id);
				
				if($get_users_delete == '1')
				{
					$this->session->set_flashdata('ok_message', 'User deleted successfully.');
					redirect(SURL.'users/list-all-users');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'users/list-all-users');
					
				}//end if if($get_users_delete != '')
				
			}//end if($users_id!="")
			
	}//end function delete_users($users_id)
	
	public function deactivate_users($users_id){

		if($users_id!="")
			{
				$deactivate_user = $this->users->update_user_status($users_id);
				
				if($deactivate_user == '1')
				{
					$this->session->set_flashdata('ok_message', 'User status deactivated successfully.');
					redirect(SURL.'users/list-all-users');
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'users/list-all-users');
					
				}//end if if($get_users_delete != '')
				
			}//end if($users_id!="")
			
	}//end function deactivate_users($users_id)
	
	// list_all  users
	public function list_all_users($type = ''){
		
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
		
			// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation_2.min.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');
		// end CMS file Validation
		
		
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
		
		// Load view: list_all_users
		$this->stencil->paint('users/list_all_users',$data);
		
	} // End - list_all_users():
	
	// Function update_users_verify();
	public function update_users_verify(){

		if($this->input->post() && $this->input->post('admin_verify_status') != ''){
		
			// Send post data to set admin_aerify_status = 1
			$update_users_verify = $this->users->update_users_verify($this->input->post()); 
			
			if($update_users_verify) { // On success
				
				$this->session->set_flashdata('ok_message', 'Selected users was successfully verified.');
				//redirect(SURL.'users/list-all-users');
				redirect($_SERVER['HTTP_REFERER']);
				
			} //end if($update_users_verify)
				
		} else {
			
			$this->session->set_flashdata('err_message', 'You did not select any user(s), action cannot be completed.');
			//redirect(SURL.'users/list-all-users');
			redirect($_SERVER['HTTP_REFERER']);
			
		}//end if($this->input->post() && $this->input->post('admin_verify_status') != '')
		
	}//end update_users_verify()

	// Start - get_all_users_ajax_call():
	public function get_all_users_ajax_call(){
		
		echo $this->users->get_all_users_ajax_call();
		
	} // End - get_all_users_ajax_call():
	
	// Start - purchased_items_split_by_user():
	public function purchased_items_split_by_user($user_id){
		
		// Get Purchased Items Split by the user
		$data = $this->users->get_purchased_items_split_by_user($user_id);
		
		// Start - Trainings
		$fancybox_body .= '<h3 class="pull-left">Training</h3>';
		$fancybox_body .= '<table class="table table-striped table-bordered table-hover" id="example">';
				$fancybox_body .= '<thead>
						
						<th>Training Name</th>
						<th>Price</th>
						<th>Expiry Date</th>
						<th>Doctor Approval</th>
						<th>Pharmacist Approval</th>
						<th>No of Attempts</th>
						<th>View Quiz</th>
						<th>Last Quiz Percentage</th>
						
				</thead>';
				$fancybox_body .= '<tbody>';
				
				if(!empty($data['training'])){
					foreach($data['training'] as $key => $training): // Display All Trainings Purchases
						
						// Doctor Approval Status
						if($training['doctor_approval'] == 1)
							$doctor_approval = '<button type="button" class="btn btn-success btn-xs btn-block disabled">Approved</button>';
						else
							$doctor_approval = '<button type="button" class="btn btn-danger btn-xs btn-block disabled">Not Approved</button>';
						
						// Pharmacist Approval Status
						if($training['pharmacist_approval'] == 1)
							$pharmacist_approval = '<button type="button" class="btn btn-success btn-xs btn-block disabled">Approved</button>';
						else
							$pharmacist_approval = '<button type="button" class="btn btn-danger btn-xs btn-block disabled">Not Approved</button>';
						
						// Get Training Name by ID
						$training_name = $this->users->training_name_by_id($key);
						
						$fancybox_body .= '
							<tr>
								<td class="text-center">'.$training_name.'</td>
								<td class="text-center">&pound;'.filter_string($training['price']).'</td>
								<td class="text-center">'.kod_date_format(filter_string($training['expiry_date']), false).'</td>
								<td class="text-center">'.$doctor_approval.'</td>
								<td class="text-center">'.$pharmacist_approval.'</td>
								<td class="text-center"><button type="button" class="btn btn-info btn-xs btn-block disabled">'.filter_string($training['no_of_attempts']).'</button></td>
								<td class="text-center">';
									if($training['is_quiz_passed'] == 1){
										$fancybox_body .= '<a href="'.SURL.'users/user_quiz_results/'.$user_id.'/training/'.filter_string($training['id']).'" class="btn btn-default btn-xs btn-block fancybox_pgd_detail fancybox.ajax" title="Click here to view Quiz" ><span class="glyphicon glyphicon-education"></span></a>';
									} else {
										$fancybox_body .= '<a href="#" class="btn btn-xs btn-danger" >Not-Passed</a>';
									}
								$fancybox_body .= '</td>
								<td class="text-center"><label class="bg-default text-success">'.filter_string($training['last_quiz_percentage']).' % <span class="visible-lg-block">✔ Quiz Passed</span></label></td>
							</tr>
							';
					endforeach; // End - foreach($data['training'] as $key => $training):
					
				} else { // if(!empty($data['training']))
					$fancybox_body .= '	<tr>
											<td colspan="9">No records for training.</td>
										</tr>';
				} // else if(!empty($data['training']))
					
				$fancybox_body .= '</tbody>';
			$fancybox_body .= '</table>'; // End Trainings Html Table
		
		///////////////////// End Trainings ////////////////////////
		///////////////////////////////////////////////////////////
		///////////////////// Start - PGD's ///////////////////////
		
		$fancybox_body .= '<h3 class="pull-left">PGDs</h3> 
		<br /><br /><br />
		<div class="row col-md-6">
			<div class="col-md-6">
				<button type="button" class="btn btn-success disabled btn-xs btn-block">Package Purchased: '.$data['pgds']['package_purchased'].'</button>
			</div>
			<div class="col-md-6">
				<button type="button" class="btn btn-default disabled btn-xs btn-block">Package Expiry: '.$data['pgds']['package_expiry'].'</button>
			</div>
		</div>
		<br /><br />';
		$fancybox_body .= '<table class="table table-striped table-bordered table-hover" id="example">';
				$fancybox_body .= '<thead>
						
						<th>PGD Name</th>
						<th>PGD Type</th>
						<th>Price</th>
						<th>Expiry Date</th>
						<th>Doctor Approval</th>
						<th>Pharmacist Approval</th>
						<th>No of Attempts</th>
						<th>View Quiz</th>
						<th>Last Quiz Percentage</th>
						
				</thead>';
				$fancybox_body .= '<tbody>';
				if(!empty($data['pgds']['pgd_list'])){
					foreach($data['pgds']['pgd_list'] as $key => $pgd): // Display All PGD's Purchases
					
						$pgd_id = $pgd['product_id'];
						$get_pgd_details = $this->pgd->get_pgd_details($pgd_id);
						
						// Doctor Approval Status
						if($pgd['doctor_approval'] == 1)
							$doctor_approval = '<button type="button" class="btn btn-success btn-xs btn-block disabled">Approved</button>';
						else
							$doctor_approval = '<button type="button" class="btn btn-danger btn-xs btn-block disabled">Not Approved</button>';
						
						// Pharmacist Approval Status
						if($pgd['pharmacist_approval'] == 1)
							$pharmacist_approval = '<button type="button" class="btn btn-success btn-xs btn-block disabled">Approved</button>';
						else
							$pharmacist_approval = '<button type="button" class="btn btn-danger btn-xs btn-block disabled">Not Approved</button>';
						
						// Get PGD Name by ID
						$pgd_name = filter_string($get_pgd_details['pgd_name']); //$this->users->pgd_name_by_id($key);
						// Set PGD Type
						if($pgd['type'] == 'V')
							$pgd_type = 'Vaccine PGD';
						else
							$pgd_type = 'Oral PGD';
						
						$fancybox_body .= '
							<tr>
								<td class="text-center">'.$pgd_name.'</td>
								<td class="text-center">'.$pgd_type.'</td>
								<td class="text-center">&pound;'.filter_string($pgd['price']).'</td>
								<td class="text-center">'.kod_date_format(filter_string($pgd['expiry_date']), false).'</td>
								<td class="text-center">'.$doctor_approval.'</td>
								<td class="text-center">'.$pharmacist_approval.'</td>
								<td class="text-center"><button type="button" class="btn btn-info btn-xs btn-block disabled">'.filter_string($pgd['no_of_attempts']).'</button>
								
								';
								//echo $get_pgd_details['id'].'--'.$get_pgd_details['pgd_number_of_attempts_allowed'].'<br>';
								if(filter_string($pgd['no_of_attempts']) >= $get_pgd_details['pgd_number_of_attempts_allowed']){
									$fancybox_body .= '<a href="'.SURL.'users/reset-reattempt-quiz/'.$pgd['id'].'">[Reset Attempts]</a>';	
								}
						
						$fancybox_body .= '		
								
								</td>
								<td class="text-center">';
								if($pgd['is_quiz_passed'] == 1){
									$fancybox_body .= '<a href="'.SURL.'users/user_quiz_results/'.$user_id.'/pgd/'.$pgd['id'].'" class="btn btn-default btn-xs btn-block fancybox_pgd_detail fancybox.ajax" title="Click here to view Quiz" ><span class="glyphicon glyphicon-education"></span></a>';
								} else {
									$fancybox_body .= '<a href="#" class="btn btn-xs btn-danger" >Not-Passed</a>';
								}
								$fancybox_body .= '
								</td>
								<td class="text-center">';
									if($pgd['is_quiz_passed'] == 1){
										$fancybox_body .= '<label class="bg-default text-success">'.filter_string($pgd['last_quiz_percentage']).' % <span class="visible-lg-block">✔ Quiz Passed</span></label>';
									} else {
										$fancybox_body .= '<label class="bg-default text-danger">'.filter_string($pgd['last_quiz_percentage']).' % <span class="visible-lg-block">Quiz Not Passed</span></label>';
									} // if($pgd['is_quiz_passed'] == 1)
								$fancybox_body .= '
								</td>
							</tr>
							';
							
					endforeach; // End - foreach($data['training'] as $key => $training):
				
				} else { // if(!empty($data['pgds']['pgd_list']))
					$fancybox_body .= '	<tr>
											<td colspan="10">No records for PGDs.</td>
										</tr>';
				} // else - if(!empty($data['pgds']['pgd_list']))
				
				$fancybox_body .= '</tbody>';
			$fancybox_body .= '</table>'; // End Trainings Html Table
			
		////////////////////// End - PGD's ///////////////////////////
		
		echo $fancybox_body;
		
	} // End - purchased_items_split_by_user():
	
	// Start - user_quiz_results($user_id=''):
	public function user_quiz_results($user_id='', $quizes_for='', $order_id=''){
		
		$response = $this->users->get_user_quiz_results($user_id, $quizes_for, $order_id);
		
		if($quizes_for == 'pgd'){
			$type = 'Training Quizes';
			$current = 'PGD Quizes';
			$action = 'training';
			$quiz_options_table = 'pgd_quiz_options';
		} else {
			$type = 'PGD Quizes';
			$current = 'Training Quizes';
			$action = 'pgd';
			$quiz_options_table = 'training_quiz_options';
		}
		
		$fancybox_body .= '<h3 class="pull-left">'.$current.'</h3> 
		<a href="'.SURL.'users/purchased_items_split_by_user/'.$user_id.'" class="btn btn-xs btn-danger pull-right fancybox_pgd_detail fancybox.ajax" title="Go Back to main" > Go Back</a>
		<br /><br /><br />';
		$fancybox_body .= '
			<table class="table table-striped table-bordered table-hover" id="example">
				<thead>	
					<tr>
						
						<th>Question</th>
						<th>Options</th>
						<th>Answer</th>
						<th>Correct Option</th>
						
					</tr>
				</thead>
				<tbody>';
				if(!empty($response)){
					
					foreach($response['questions'] as $each):
						$fancybox_body .= '
						<tr>
							
							<td>'.$each['question'].'</td>
							<td>';
								$i = 1;
								foreach($each[0] as $option): // Display options
									
									$fancybox_body .= '<strong> ('.$i.') </strong>'.$option['option'].'<br />';
									$i++;
									
								endforeach;
								$fancybox_body .= '
							</td>
							<td>';
							
								$this->db->dbprefix($quiz_options_table);
								$this->db->select('option');
								$this->db->where('id', $each['answer_id']);
								$answer = $this->db->get($quiz_options_table)->row_array();
								
								if($each['answer_status'] == 'T')
									$answer_option = '<button class="btn btn-xs btn-success" title="Answer is correct" >'.$answer['option'].'</button>';
								else
									$answer_option = '<button class="btn btn-xs btn-danger" title="Answer is not correct" >'.$answer['option'].'</button>';
								
								$fancybox_body .= $answer_option.'
							</td>
							<td>
								<button class="btn btn-xs btn-warning" title="This is the correct answer." > '.$each['correct_option_name'].' </button>
							</td>
							
						</tr>';
					endforeach;
				
				} // End - if(!empty($response)):
				
				$fancybox_body .= '
				</tbody>
			</table>';
		
		echo $fancybox_body;
		
	} // End - user_quiz_results($user_id=''):
	
	// Order History  Function order_details_history
	public function order_details_history($id) {
	
		// Get Order Details History
		$response_history = $this->users->get_order_details_history($id);
			
		// Start Table
		$tablebody_order_history .='
		<h4>User order history</h4>
		<br />
		<table class="table table-striped table-bordered table-hover" id="example">
			<thead>
						<tr class="headings"> 
							<th>User Name</th>
							<th>Product Type</th>
							<th>Purchase Date</th>
							<th>Expiry_Date</th>
							<th>Order Number</th>
							<th>Transaction Id</th>
							<th>Price</th>
						 </tr>
			</thead>
			<tbody>';
				if(!empty($response_history)) 
				 {
					 $i=1;
					 foreach($response_history as $key => $each)
					  {
						   
							$tablebody_order_history.='
							<tr class="even pointer"> 
								<td class=" ">'.$each['first_name'].' '.$each['last_name'].'</td>
								<td class=" ">'.$each['product_type'].'</td>
								<td class=" ">'.kod_date_format($each['purchase_date']).'</td>
								<td class=" ">'.kod_date_format($each['expiry_date']).'</td>
								<td class=" ">'.$each['order_no'].'</td>
								<td class=" ">'.$each['paypal_transaction_id'].'</td>
								<td class=" "> &pound;'.$each['price'].'</td>
							</tr>';
					   
						 if(count($response_history)==$i) {
									  
						   $tablebody_order_history .='<tr class="even pointer">
						  		<td class=" " colspan="6"></td>';
						   $tablebody_order_history .='<td style=font-weight:bold;>Grand Total: &pound; '.$each['grand_total'].'</td>
						 </tr>';
					   }
					  $i++;					 
					} // foreach($response_history as $key => $each)
				 } else {
						   $tablebody_order_history.=
						  '<tr class="">
							<td class=" " colspan="9">No record founded.</td>
						  </tr>';
						}

						   $tablebody_order_history.=
			'</tbody>
							
		</table>';
			
			// end Table Body 
			
			echo $tablebody_order_history;
			
	} // end  order_details_history
	
	// default_team_section_list  users
	public function default_prescriber_section_list(){
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Default Team Section Listing', base_url().'users/default-team-section-list');
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
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom.js');
		// end Form CMS file Validation
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		//  All Doctor or Pharmacist users
		$data['list_default_users'] = $this->users->get_all_default_team_users();
		
		// Load view: list_all_users
		$this->stencil->paint('users/default_prescriber_section_list',$data);
		
	} // End - default_prescriber_section_list():


	// default_team_section_list  users
	public function default_team_section_list(){
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Default Team Section Listing', base_url().'users/default-team-section-list');
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
		
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
		
		// Js Form Users form validation
		$this->stencil->js('kod_scripts/custom.js');
		// end Form CMS file Validation
		
		// Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->js('kod_scripts/custom.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
		
		//  All Doctor or Pharmacist users
		//$data['list_default_users'] = $this->users->get_all_default_team_users();
		
		$list_cqc_set = $this->users->get_all_list_cqc_set(1);
		//print_this($list_cqc_set); exit;
		$data['list_cqc_set'] = $list_cqc_set;
		
		// Load view: list_all_users
		$this->stencil->paint('users/default_team_section_list',$data);
		
	} // End - default_team_section_list():
	
	// search  search_doctor_pharmacist function 
	public function search_doctor_pharmacist(){
		
		//If Post is not SET
		//if(!$this->input->post() && !$this->input->post('search_btn_doc_pharm')) redirect(base_url());
		$data = $this->users->search_doctor_pharmacist($this->input->post());
		echo json_encode($data);
	   //echo json_encode($data);
	  // $this->stencil->paint('users/auto_search_doc_pharm',$data);
		
	}// end search_doctor_pharmacist();

	// search  search_prescriber function 
	public function search_prescriber(){
		
		//If Post is not SET
		//if(!$this->input->post() && !$this->input->post('search_btn_doc_pharm')) redirect(base_url());
		$data = $this->users->search_prescriber($this->input->post());
		echo json_encode($data);
		
	}// end search_prescriber();
	
	// Function add_update_default_user_process();
	public function add_update_default_user_process(){
		
		if(!$this->input->post() && !$this->input->post('user_type_btn')) redirect(base_url());
		
		$success = $this->users->add_update_default_user($this->input->post());

		if($success)
			{
				$this->session->set_flashdata('ok_message', 'Default user changed successfully.');
				redirect(SURL.'users/default-team-section-list');
				
			} else {
				
				$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
				redirect(SURL.'users/default-team-section-list');
				
			}//end else 
		
	} // End add_update_default_user_process();


	// Function add_update_default_user_process();
	public function update_default_prescriber_process(){
		
		if(!$this->input->post() && !$this->input->post('default_presc_btn')) redirect(base_url());
		
		
		$success = $this->users->add_update_default_prescriber($this->input->post());
		

		if($success)
			{
				$this->session->set_flashdata('ok_message', 'Default prescriber changed successfully.');
				redirect(SURL.'users/default-prescriber-section-list');
				
			} else {
				
				$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
				redirect(SURL.'users/default-prescriber-section-list');
				
			}//end else 
		
	} // End update_default_prescriber_process();

	// Start - public function import_users() : Function to import csv file to extract users and
	//add them into the database as system users in bulk
	public function import_users(){

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
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('users/import_users');

	} // End - public function import_users()

	// Start - public function save_import_users() : Function to read csv file and insert data into the db if user does not exist before otherwise return the list of all email addresses whixh are already registered on the system
	public function save_import_users(){

		$this->load->library('CSVReader');
		$this->load->model('users_mod','users');
		
		$import_user = $this->users->import_user_record( $_FILES );
		
		if(is_array($import_user)){

			$err_message = 'Users with the following email addresses are either exist or invalid.<br /> <br />';
			$i = 1;
			foreach($import_user as $email){

				$err_message .= '('.$i.') '.$email.'<br />';

				$i++;
			} // foreach($import_user)

			$this->session->set_flashdata('err_message', $err_message);
		}else
			$this->session->set_flashdata('ok_message', 'Users successfully imported into the database.');
		// if(is_array($import_user))

		// Redirect back to upload csv
		redirect(SURL.'users/import-users');
		

	} // End - public function save_import_users()
	
	//conut record user_reporting_count
	public function user_reporting() {
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('User Reporting', base_url().'avicenna/user-reporting-count');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		// Get All Active Trainings
		$list_all_active_trainings = $this->training->get_all_active_trainings();
		$data['list_all_active_trainings'] = $list_all_active_trainings;
		
		// Get All Active PGDs
		$list_all_active_pgds = $this->pgd->count_all_active_pgds();
		$data['list_all_active_pgds'] = $list_all_active_pgds;
		
		//  PGDs Active List
		$list_all_active_pdgs = $this->pgd->get_all_active_pdgs();
		$data['list_all_active_pdgs'] = $list_all_active_pdgs;

		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
	
		// Count all peads travel
		//$data['count_list_pgds_peads_travel'] = $this->avicenna->count_all_pgds_peads_travel();
	
	   $this->stencil->paint('users/count_users_reporting',$data);
	
	}// end user_reporting_count
		
	// Download CSV FILE
	 public function download_single_pgd_csv($product_id='', $product_type ='') {
	
		$this->load->helper('url');
		
		$file_contents = $this->pgd->download_single_pgd_csv($product_id,$product_type); 
		
		//$file_contents = load_file_from_id($_GET['id']);
		$file_name = 'user_reports'.time().'.csv';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $file_contents;
	
	}//end download_csv
		
			// Download CSV FILE
	 public function download_csv_file_all_pgds($product_type =''){
	
		$this->load->helper('url');
		
		$file_contents = $this->pgd->download_csv_file_all_pgds($product_type); 
		
		//$file_contents = load_file_from_id($_GET['id']);
		$file_name = 'user_reports'.time().'.csv';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $file_contents;
	
	}//end download_csv_file_all_pgds($product_type ='')
		
	// Download CSV FILE
	 public function download_csv_file_training() {
	   
		$this->load->helper('url');
		
		$file_contents = $this->training->download_csv_file_training($this->input->post('product_id')); 
		
		//$file_contents = load_file_from_id($_GET['id']);
		$file_name = 'user_reports'.time().'.csv';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $file_contents;
	
	}//end download_csv_file_training
	
	public function download_all_users_csv() {
	   
		$this->load->helper('url');
		
		$file_contents = $this->users->download_csv_file_users(); 
		
		//$file_contents = load_file_from_id($_GET['id']);
		$file_name = 'all_user_list'.time().'.csv';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $file_contents;
	
	}//end download_all_users_csv
	
	//conut record old_users_list
	public function old_users_list($user_id = '') {
		
		/*
		$get_all_old_user = $this->users->get_old_user_list();
		
		for($i=0;$i<count($get_all_old_user);$i++){
			
			if($get_all_old_user[$i]['groupid'] == 1){
			
				$email_add = $get_all_old_user[$i]['emailaddress'];
				$verify_if_email_already = $this->users->verify_if_email_already_exist_old_user($email_add);
			
				if(!$verify_if_email_already){
					
				//print_this($data); exit;
				$created_date = date('Y-m-d G:i:s');
				$created_by_ip = $this->input->ip_address();
				
				//Generate Random code	
				 $email_activation_code = $this->common->random_number_generator(10);
				 
				if($get_all_old_user[$i]['registeringbody'] == 'GMC'){
					$registration_type = 'GMC';
					$user_type = 1;
				}
	
				if($get_all_old_user[$i]['registeringbody'] == 'NMC'){
					$user_type = 3;
				}
	
				if($get_all_old_user[$i]['registeringbody'] == 'GPhC'){
					$user_type = 2;
				}
				 
				 
				 if($user_type == 1){
					 
					$registration_type = 'GMC';
				 
				 }elseif($user_type == 2 || $user_type == 6 ){
					 
					$registration_type = 'GPhC';
					 
				 }elseif($user_type == 3){
					 
					$registration_type = 'NMC';
					 
				 }//end if($user_type == 1)
				 
				$this->db->dbprefix('old_users');		
				$this->db->select('old_users.*');
				$this->db->where('old_users.userid',$user_id);
				$get_user= $this->db->get('old_users');
				$row_arr = $get_user->row_array();
				
				$is_owner = ($is_owner) ? $is_owner : '0';
				
				$is_locum = '0';
				
				$is_prescriber = ($get_all_old_user[$i]['prescribercheck']) ? '1' : '0';
				
				//Record insert into database
				$ins_data = array(
				
					'user_type' => $this->db->escape_str(trim($user_type)),
					'first_name' => $this->db->escape_str(trim($get_all_old_user[$i]['firstname'])),
					'last_name' => $this->db->escape_str(trim($get_all_old_user[$i]['lastname'])),
					'mobile_no' => $this->db->escape_str(trim($get_all_old_user[$i]['mobilenumber'])),
					'email_address' => $this->db->escape_str(trim($get_all_old_user[$i]['emailaddress'])),
					'registration_no' => $this->db->escape_str(trim($get_all_old_user[$i]['registrationnumber'])),
					'registration_type' => $this->db->escape_str(trim($registration_type)),
					'password' => $this->db->escape_str(((trim($get_all_old_user[$i]['password'])))),
					'is_locum' => $this->db->escape_str(trim($is_locum)),
					'is_prescriber' => $this->db->escape_str(trim($is_prescriber)),
					'is_owner' => $this->db->escape_str(trim($is_owner)),
					'email_verify_status' => $this->db->escape_str(1),
					'admin_verify_status' => $this->db->escape_str(1),
					'activation_code' => $this->db->escape_str(trim(md5($email_activation_code))),
					'buying_group_id' => $this->db->escape_str(trim($get_all_old_user[$i]['groupid'])),
					'created_date' => $this->db->escape_str(trim($get_all_old_user[$i]['dateregistered'])),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				);
		
			
				//If is_pres == 1, take the speciality field, otherwise leave it blank
				$ins_data['speciality'] = ($is_prescriber == 1) ? $this->db->escape_str(trim($speciality)) : '';
				
				//If usertype = 1 (doctor) he will always be a prescriber
				$ins_data['is_prescriber'] = ($user_type == 1) ? $this->db->escape_str(trim(1)) : $this->db->escape_str(trim($is_prescriber));
				
				//Inserting User data into the database. 
				$this->db->dbprefix('users');
				$ins_into_db = $this->db->insert('users', $ins_data);
				
				$new_user_id = $this->db->insert_id();
						
			
				}//end if(!$verify_if_email_already)
			}

		}//end for($i=0;$i<count($get_all_old_user);$i++)
		
		*/
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Old User List', base_url().'users/old-users-list');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		
		// Get All Old Users 
		$old_user_list = $this->users->get_old_user_list($user_id);
		$data['old_user_list'] = $old_user_list;
		
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
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
	
	   $this->stencil->paint('users/old_user_list',$data);
	
	}// end old_users_list
	
	// Function  edit_old_users
	public function edit_old_users($user_id = ''){
	
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Set Bread Crumb
		$this->breadcrumbcomponent->add('Old user Listing', base_url().'users/old-users-list');
		$this->breadcrumbcomponent->add('Old User List', base_url().'users/edit-old-users');

		if($user_id != '') {
			
			// Get All Old Users 
			$old_user_list = $this->users->get_old_user_list($user_id);
			$data['old_user_details'] = $old_user_list;
			
			// Get All Old Users Type 
			$usertype_active_arr = $this->users->get_old_user_type();
			$data['usertype_active_arr'] = $usertype_active_arr;
			
			
			//Active Locum Cities List
		$cities_active_arr = $this->users->get_active_cities();
		$data['cities_active_arr'] = $cities_active_arr;

		//Active Organization Country List
		$country_active_arr = $this->users->get_active_countries();
		$data['country_active_arr'] = $country_active_arr;

		//Active Buying Group List
		$buyinggroup_active_arr = $this->users->get_active_buyinggroups();
		$data['buyinggroup_active_arr'] = $buyinggroup_active_arr;

			
		}
		//echo '<pre>';
		//print_r($old_user_list); exit;
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
			// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation_2.min.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');
		// end CMS file Validation
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('users/edit_old_users',$data);
		
	}//end edit_old_users()\
	
	public function old_users_process(){
		
		if(!$this->input->post() && !$this->input->post('old_user_btn')) redirect(base_url());
		
		 extract($this->input->post()); 
		 
		 $postValue = $this->input->post(); 
	    // PHP Validation
		$this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|max_length[11]');
		/*$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[conf_password]');
		$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'trim|required');*/
		$this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
	 
	 	
		if($postValue['user_type']=="1"){
	 
			$this->form_validation->set_rules('registration_no', 'GMC Number', 'required');
		
		 } else if($postValue['user_type']=="2") {
		
			$this->form_validation->set_rules('registration_no', 'GPhC Number', 'required');
	 
		 } else if($postValue['user_type']=="3") {
		
			$this->form_validation->set_rules('registration_no', 'NMC Number', 'required');
		}
		
		if($this->form_validation->run() == FALSE){
			
			// session set form data in fields
			$this->session->set_flashdata($this->input->post());
			// PHP Error
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(base_url().'users/old-users-list');
			
		} else {
			
			$verify_if_email_already = $this->users->verify_if_email_already_exist_old_user($this->input->post('email_address'));
			
			if($verify_if_email_already){
				
				//Email Already exist
				$this->session->set_flashdata('err_message', 'The email address you are trying to register already exist in our database. Please contact site administrator for further details.');
				redirect(base_url().'users/old-users-list');
				
			} else {
				
					$user_register = $this->users->old_user_old($this->input->post());
					
					if($user_register) {
						
						$this->session->set_flashdata('ok_message', 'User imported into database succesfully.');
						redirect(base_url().'users/old-users-list');
					} else {
						$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
						redirect(base_url().'users/old-users-list');
					}

				
					redirect(base_url().'users/old-users-list');
					
			}//end if($verify_if_email_already)			
		}
		
	}// end 

	// assing unassing users
	public function assign_unassign_users($name='',$users_id){

		if($users_id!="")
			{
				$assign_unassign_user = $this->users->assign_unassign($name,$users_id);
				
				if($assign_unassign_user == '1')
				{
					$this->session->set_flashdata('ok_message', 'User status change successfully.');
					redirect($_SERVER['HTTP_REFERER']);
					
				} else {
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect($_SERVER['HTTP_REFERER']);
					
				}//end if if($assign_unassign_users != '')
				
			}//end if($users_id!="")
			
	}//end function assign_unassign_users($name='',$users_id)
	
	public function view_trainings($user_type, $user_id){

		// icheck
		$this->stencil->js('icheck/icheck.min.js');
		// Datatables
		$this->stencil->js('datatables/js/jquery.dataTables.js');
		$this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
		// Load custom file data_tables.js
		$this->stencil->js('kod_scripts/data_tables.js');
		$this->stencil->css('kod_css/jquery.dataTables.min.css');
	
		$this->stencil->layout('ajax_pages'); //page_template

		$data['trainings'] = $this->training->get_all_trainings($user_type, 1);
		$data['user_id'] = $user_id;

		$data['purchases'] = $this->purchase->get_purchased_items_split_by_user($user_id);
		
		$this->stencil->paint('users/trainings', $data);

	} // 
	
	// assign unassign pgd
	public function renew_pgd(){
		
		if(!$this->input->post()) redirect(SURL.'dashboard');
		// Extract POST
		extract( $this->input->post() );

		$pgd_id = ($pgd_type == "ORAL" || $pgd_type == 'P_ORAL') ? '' : $pgd_id ;

		if($action == 'assign'){
			
			$status = $this->purchase->add_pgd_to_temp($pgd_id, $user_id, $pgd_type);
			$message = ($status == 1) ? 'PGD added successfully.' : 'Oops! Something went wrong. Try again later.' ;
			

		} else if($action == 'unassign'){

			$status = $this->purchase->remove_pgd_from_temp($pgd_id, $user_id, $pgd_type);
			$message = ($status == 1) ? 'PGD successfully removed.' : 'Oops! Something went wrong. Try again later.' ;
			
		} // if($action == 'assign')

		if($status == 1)
			$this->session->set_flashdata('ok_message', $message);
		else
			$this->session->set_flashdata('err_message', $message);
		// if($status == 1)

		redirect($_SERVER['HTTP_REFERER']);

	} // renew_pgd

	// assign unassign pgd
	public function assign_pgd(){
		
		/*
		Array
		(
		    [user_id] => 6365
		    [pgd_id] => 28
		    [pgd_type] => PGD
		    [action] => assign
		    [assign_pgd_btn] => 1
		)
		*/

		// print_this($_POST); exit;

		if(!$this->input->post()) redirect(SURL.'dashboard');
		// Extract POST
		extract( $this->input->post() );

		$pgd_id = ($pgd_type == "ORAL" || $pgd_type == 'P_ORAL') ? '' : $pgd_id ;

		if($action == 'assign'){
			
			$status = $this->purchase->add_pgd_to_order($pgd_id, $user_id, $pgd_type);
			$message = ($status == 1) ? 'PGD added successfully.' : 'Oops! Something went wrong. Try again later.' ;
			

		} else if($action == 'unassign'){

			$status = $this->purchase->remove_pgd_from_order($pgd_id, $user_id, $pgd_type);
			$message = ($status == 1) ? 'PGD successfully removed.' : 'Oops! Something went wrong. Try again later.' ;
			
		} // if($action == 'assign')

		if($status == 1)
			$this->session->set_flashdata('ok_message', $message);
		else
			$this->session->set_flashdata('err_message', $message);
		// if($status == 1)

		redirect($_SERVER['HTTP_REFERER']);

	} // assign_pgd
	
	// Start - public function assign_training() : Function to assign and unassign user trainings
	public function assign_training(){

		if(!$this->input->post()) redirect(SURL.'dashboard');

		// Extract POST
		extract( $this->input->post() );

		if($action == 'assign_training'){
			
			$status = $this->purchase->add_trainings_to_order($this->input->post('trainings'), $user_id);
			$message = ($status == 1) ? 'User training(s) was added successfully.' : 'Oops! Something went wrong. Try again later.' ;

		} else if($action == 'unassign_training'){

			$status = $this->purchase->remove_trainings_from_order($this->input->post('trainings'), $user_id);
			$message = ($status == 1) ? 'User training(s) successfully removed.' : 'Oops! Something went wrong. Try again later.' ;

		} // if($action == 'assign')

		if($status == 1)
			$this->session->set_flashdata('ok_message', $message);
		else
			$this->session->set_flashdata('err_message', $message);
		// if($status == 1)

		redirect($_SERVER['HTTP_REFERER']);

	} // public function assign_training()
	
	public function reset_reattempt_quiz($purchase_id){
		
		if(trim($purchase_id) != ''){
			
			$reset_quiz_attempts = $this->users->reset_quiz_attempts($purchase_id);
			
			if($reset_quiz_attempts)
				$this->session->set_flashdata('ok_message', 'Quiz Attempts successfully reset.');	
			else
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');	
			//end if($reset_quiz_attempts)
			
			redirect(SURL.'users/list-all-users');
			
		}//end if(trim($purchase_id) != '')
		
	}//end reset_reattempt_quiz($purchase_id)

	public function add_cqc_set_process(){
		
		//if(!$this->input->post('doctor_email')) redirect(SURL.'users/default-team-section-list');
		
		$this->form_validation->set_rules('doctor_email', 'Default Doctor', 'trim|required');
		$this->form_validation->set_rules('pharmacist_email', 'Default Pharmacist', 'trim|required');
		$this->form_validation->set_rules('cqc_body', 'CQC Body', 'trim|required');
		$this->form_validation->set_rules('cqc_manager', 'CQC Manager', 'trim|required');

		if($this->form_validation->run() == FALSE){
			
			// session set form data in fields
			$this->session->set_flashdata($this->input->post());
			// PHP Error
			$this->session->set_flashdata('err_message', validation_errors());
			redirect(SURL.'users/default-team-section-list');
			
		} else {
			
			$add_default_cqc_set = $this->users->add_default_cqc_set($this->input->post());
			
			if($add_default_cqc_set){
				
				$this->session->set_flashdata('ok_message', 'CQC details successfully added');	
				
			}else{
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');	
			}//end if($add_default_cqc_set)
			
			redirect(SURL.'users/default-team-section-list');
			
		}//end if($this->form_validation->run() == FALSE)
		
	}//end add_cqc_set_process()
	
	public function mark_cqc_as_active(){
		
		if(!$this->input->post('set_id')) exit;
		
		extract($this->input->post());
		
		$mark_cqc_as_active = $this->users->mark_cqc_as_active($set_id);
		
		return true;
		
	}//end mark_cqc_as_active()
	
	public function buying_groups(){

		//Active Buying Group List
		$get_buying_groups_list = $this->buyinggroup->get_buying_groups_list();
		$data['buying_groups_list'] = $get_buying_groups_list;
	
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Dashboard', base_url().'/dashboard');
		$this->breadcrumbcomponent->add('Manage Buying Groups', '#');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		$this->stencil->paint('users/buying_groups',$data);
		
	}//end buying_groups()
	
	public function add_edit_buyinggroup($group_id = ''){
		
		
		if($group_id != ''){
			
			$buying_groups_dtails = $this->buyinggroup->get_buying_groups_list($group_id);
			$data['buying_groups_dtails'] = $buying_groups_dtails;
			
		}//end if($group_id != '')
		
		// Add BreadCrumb Components
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard');
		$this->breadcrumbcomponent->add('Manage Buying Groups', base_url().'users/buying-groups');
		$this->breadcrumbcomponent->add('Add/ Edit Buying Groups', base_url());
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		//set title
		$users_title = DEFAULT_TITLE;
		$this->stencil->title($users_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_DESCRIPTION,
			'meta_title' => DEFAULT_TITLE
		));
		
		// Js file using for CMS page validation
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
		$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
		// end CMS file Validation
		
		$this->stencil->paint('users/add_edit_buyinggroup',$data);
		
	}//end add_edit_buyinggroup()
	
	public function add_edit_group_process(){

		if(!$this->input->post() && !$this->input->post('buying_groups')) redirect(base_url());
		
		 extract($this->input->post());
		 
		 if($group_id == ''){

			 $verify_if_groupname_exist = $this->buyinggroup->verify_if_group_exist('name',$this->input->post());
			 $email_exist = $name_exist = 0; 
			 
			 if($verify_if_groupname_exist)
				$name_exist = 1;
	
			 $verify_if_email_exist = $this->buyinggroup->verify_if_group_exist('email',$this->input->post());
			 
			 if($verify_if_email_exist)
				$email_exist = 1;
				
				if($email_exist){
				
					$this->session->set_flashdata('err_message', 'Email ('.$email_address.') you have entered already exist. Use another one.');	
					redirect(SURL.'users/add-edit-buyinggroup');
				
				}//end if($email_exist)
				
				if($name_exist){
					
					$this->session->set_flashdata('err_message', 'Buying group name <strong>('.$buying_groups.')</strong> you have entered already exist. Use another one.');	
					redirect(SURL.'users/add-edit-buyinggroup');
					
				}//end if($name_exist)
				
				$add_edit_buying_group = $this->buyinggroup->add_edit_buying_group($this->input->post());
				
				if($add_edit_buying_group){
					$this->session->set_flashdata('ok_message', 'New buying group added successfully.');	
				}else{
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				}//end if($add_edit_buying_group)
				
				redirect(SURL.'users/buying-groups');

		 }else{
			 
			 $verify_if_groupname_exist = $this->buyinggroup->verify_if_group_exist('name',$this->input->post(), $group_id);
			 $email_exist = $name_exist = 0; 
			 
			 if($verify_if_groupname_exist)
				$name_exist = 1;
	
			 $verify_if_email_exist = $this->buyinggroup->verify_if_group_exist('email',$this->input->post(), $group_id);
			 
			 if($verify_if_email_exist)
				$email_exist = 1;
				
				if($email_exist){
				
					$this->session->set_flashdata('err_message', 'Email ('.$email_address.') you have entered already exist. Use another one.');	
					redirect(SURL.'users/add-edit-buyinggroup/'.$group_id);
				
				}//end if($email_exist)
				
				if($name_exist){
					
					$this->session->set_flashdata('err_message', 'Buying group name <strong>('.$buying_groups.')</strong> you have entered already exist. Use another one.');	
					redirect(SURL.'users/add-edit-buyinggroup'.$group_id);
					
				}//end if($name_exist)

				$add_edit_buying_group = $this->buyinggroup->add_edit_buying_group($this->input->post());
				
				if($add_edit_buying_group){
					$this->session->set_flashdata('ok_message', 'Buying group updated successfully.');	
				}else{
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				}//end if($add_edit_buying_group)
				
				redirect(SURL.'users/buying-groups');
			 
		 }//end if($group_id == '')
			
	}//end add_edit_group_process()
	
} /* End of file */