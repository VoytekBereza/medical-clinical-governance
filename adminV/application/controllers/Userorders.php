<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userorders extends CI_Controller {
	
	private $nav_tree;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('login_mod','login');
		$this->load->model('common_mod','common');
		$this->load->model('userorders_mod','userorders');
		
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

	// Function list_all_user_orders
	public function list_all_user_orders(){
		
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
		$this->breadcrumbcomponent->add('User Orders Listing', base_url().'userorders/list-all-userorders');
		
		$response = $this->userorders->get_all_user_orders();
		
		$data['userorders_list'] = $response;
		
        /*echo '<pre>';
		print_r($response);
		exit;
		*/
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$this->stencil->paint('userorders/users_orders_listing',$data);
		
	} // end list_all_user_orders
	
	// Function order_details
	public function order_details($id){
		
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
		
		// Get Order Details
		$list_user_order_details = $this->userorders->get_order_details($id);
		$data['list_user_order_details'] = $list_user_order_details;
		
		// Start Table
		$tablebody .='
		<h4>User order details</h4>
		<table class="table table-striped table-bordered table-hover" id="example">
				     	<thead>
									<tr class="headings"> 
										<th>User Name</th>
										
										<th>Product Type</th>
										<th>Purchase Date</th>
										<th>Expiry_Date</th>
										<th>Order Number</th>
										<th>Transaction Id</th>
										<th>Quize Passed</th>
										<th>Doctor Approval</th>
										<th>Last Quiz Date</th>
										<th>Price</th>
									 </tr>
						</thead>
								<tbody>';
								if(!empty($list_user_order_details)) {
								    $i=1;
									foreach($list_user_order_details as $each) :
									$tablebody .='<tr class="even pointer"> 
										<td class=" ">'.$each['first_name'].' '.$each['last_name'].'</td>
										<td class=" ">'.$each['product_type'].'</td>
										<td class=" ">'.kod_date_format($each['purchase_date']).'</td>
										<td class=" ">'.kod_date_format($each['expiry_date']).'</td>
										<td class=" ">'.$each['order_no'].'</td>
										<td class=" ">'.$each['paypal_transaction_id'].'</td>';
										if($each['is_quiz_passed'] ==1)
										   
										  $quize = 'Yes';
										
										else
										
										  $quize = 'No';
										  
										 if($each['doctor_approval'] ==1)
										  
										  $approval = 'Yes';
										
										 else
										
										  $approval = 'No';
																		
							$tablebody.='<td class=" ">'.$quize.'</td>
										 <td class=" ">'.$approval.'</td>
										 <td class=" ">'.kod_date_format($each['last_quiz_date']).'</td>
										 <td class=" "> &pound; '.$each['price'].'</td>
						           </tr>';
								   if(count($list_user_order_details)==$i) {
									  
									  $tablebody .='<tr class="even pointer">
									  <td class=" " colspan="9"></td>';
									   $tablebody .='<td style=font-weight:bold;>Grand Total: &pound; '.$each['grand_total'].'</td>
									 </tr>';
								   }
								   
								   
								    $i++;
								   	 endforeach; // foreach loop
								     }  else { 
									$tablebody.='<tr class="">
										<td class=" " colspan="9">No record founded.</td>
								</tr>';
					          } 
			  				$tablebody.='</tbody>
				   </table>';
			
			// end Table Body 
			
			echo $tablebody;
			
	} // End order_details
	
 }/* End of file */
