<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $belong_to_any_organization;
	protected $user_org_superintendent;
	protected $my_organization_id;
	protected $is_governance_passed;
	protected $user_signatures;
	protected $paypal_details;
	protected $org_governance_global_setting;
	protected $governance_purchased_pharmacies;
	protected $survey_purchased_pharmacies;
	protected $show_teambuilder = 0; 
	protected $show_governance = 0;
	protected $get_my_organizations;
	protected $my_role_in_pharmacy;	
	protected $organization_pharmacies;	
	protected $user_new_contract_list;	
	protected $si_purchased_items_split_arr;
	protected $get_si_user_data;
	protected $get_user_invitations_arr;

	//protected $is_default_prescriber_org_id;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('common_mod','common');
		$this->load->model('login_mod','login');
		$this->load->model('users_mod','users');
		$this->load->model('usertype_mod','usertype');
		$this->load->model('organization_mod','organization');
		$this->load->model('governance_mod','governance');
		$this->load->model('survey_mod','survey');
		$this->load->model('training_mod','training');
		$this->load->model('pgds_mod','pgds');
		$this->load->model('purchase_mod','purchase');
		$this->load->model('cms_mod','cms');
		$this->load->model('invitations_mod','invitations');
		$this->load->model('pharmacy_mod','pharmacy');
		$this->load->model('pmr_mod','pmr');
		$this->load->model('medicine_mod','medicine');
		
		$PAYPAL_SANDBOX_STATUS = 'PAYPAL_SANDBOX_STATUS';
		$paypal_sandbox_status = get_global_settings($PAYPAL_SANDBOX_STATUS); //Set from the Global Settings
		$paypal_sandbox_status = $paypal_sandbox_status['setting_value'];
		
		if($paypal_sandbox_status == 0){

			//Sandbox Mode is OFF
			
			$PAYPAL_API_USERNAME = 'PAYPAL_API_USERNAME';
			$paypal_api_username = get_global_settings($PAYPAL_API_USERNAME); //Set from the Global Settings
			$paypal_api_username = $paypal_api_username['setting_value'];
	
			$PAYPAL_API_SIGNATURE = 'PAYPAL_API_SIGNATURE';
			$paypal_api_signature = get_global_settings($PAYPAL_API_SIGNATURE); //Set from the Global Settings
			$paypal_api_signature = $paypal_api_signature['setting_value'];
			
			$PAYPAL_API_PASSWORD = 'PAYPAL_API_PASSWORD';
			$paypal_api_password = get_global_settings($PAYPAL_API_PASSWORD); //Set from the Global Settings
			$paypal_api_password = $paypal_api_password['setting_value'];

		}elseif($paypal_sandbox_status == 1){
			
			//Sandbox Mode is On
			
			$SANDBOX_PAYPAL_API_USERNAME = 'SANDBOX_PAYPAL_API_USERNAME';
			$sandbox_paypal_api_username = get_global_settings($SANDBOX_PAYPAL_API_USERNAME); //Set from the Global Settings
			$paypal_api_username = $sandbox_paypal_api_username['setting_value'];
	
			$SANDBOX_PAYPAL_API_SIGNATURE = 'SANDBOX_PAYPAL_API_SIGNATURE';
			$sandbox_paypal_api_signature = get_global_settings($SANDBOX_PAYPAL_API_SIGNATURE); //Set from the Global Settings
			$paypal_api_signature = $sandbox_paypal_api_signature['setting_value'];
			
			$SANDBOX_PAYPAL_API_PASSWORD = 'SANDBOX_PAYPAL_API_PASSWORD';
			$sandbox_paypal_api_password = get_global_settings($SANDBOX_PAYPAL_API_PASSWORD); //Set from the Global Settings
			$paypal_api_password = $sandbox_paypal_api_password['setting_value'];
			

		}//end if($paypal_sandbox_status == 0)
		
		//Applying Paypal Settings
		$this->paypal_details = array(
			// you can get this from your Paypal account, or from your
			// test accounts in Sandbox
			'API_username' => $paypal_api_username, 
			'API_signature' => $paypal_api_signature, 
			'API_password' => $paypal_api_password,
			'sandbox_status' => ($paypal_sandbox_status == 0) ? false : true
			// Paypal_ec defaults sandbox status to true
			// Change to false if you want to go live and
			// update the API credentials above
			// 'sandbox_status' => false,
		);
		
		//print_this($this->paypal_details);  		exit;
		
		$this->load->library('paypal_ec', $this->paypal_details);

		//Login Check
		$this->login->verify_is_user_login();

		//This will keep the data if user belongs to any organization or not;
		$this->belong_to_any_organization = $this->organization->verify_if_user_in_organization($this->session->id);
		$data['belong_to_any_organization'] = $this->belong_to_any_organization;
		
		//This will Hold Superintendent record, which organzation he belongs to.
		$this->user_org_superintendent = $this->organization->user_already_superintendent($this->session->id);
		$data['user_org_superintendent'] = $this->user_org_superintendent;
		
		//This will hold the organziation ID of which user is a default prescriber.
		//$this->is_default_prescriber_org_id = $this->organization->user_already_a_default_prescriber($this->session->id);
		//$data['is_default_prescriber_org_id'] = $this->is_default_prescriber_org_id;

		//Is user assigned a Manager in any of the organization, this will return 1 | 0;
		//$is_manager_arr = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id);
		//$this->am_i_manager = $is_manager_arr['is_manager'];
		//$data['am_i_manager'] = $this->am_i_manager;
		
		//This will hold the Oraganization ID of SI and/ or Owner
		
		if($this->session->is_owner){
			
			$this->my_organization_id = $this->session->organization['id'];

			$this->is_governance_passed = $this->governance->is_governance_read_by_user($this->session->id, $this->my_organization_id, '','SI',$this->session->user_type);

			$get_organization_details = $this->organization->get_organization_details($this->my_organization_id);
			
			//Hold Governance Global setting Status
			$this->org_governance_global_setting = $get_organization_details['governance_status'];
			$data['org_governance_global_setting'] = $this->org_governance_global_setting;

			//Holds Purchase list array of Governance, this will mostly going to be used for SI, to check if he is allowed to go for governance
			$this->governance_purchased_pharmacies = $this->governance->get_governance_purchased_pharmacies($this->my_organization_id,'P');
			$data['governance_purchased_pharmacies'] = $this->governance_purchased_pharmacies;

			//Holds Purchase list array of Survey, this will mostly going to be used for SI, to check if he is allowed to go for Survey
			$this->survey_purchased_pharmacies = $this->survey->get_survey_purchased_pharmacies($this->my_organization_id,'P');
			$data['survey_purchased_pharmacies'] = $this->survey_purchased_pharmacies;

			//If Owner is also a SuperIntendent of the same organization. We need to enforce the Governance again
			/*
			//Keep this commented, its role is to ensure owner to read the organization SOP
			if($this->user_org_superintendent){

				//Is SI of an Organization
				if(count($this->governance_purchased_pharmacies) > 0){
					
					//There is atleast one Pharmacy whose governance is purchased by an organization and is not expired. So governance is applied on this Organization and SI.
					if($this->org_governance_global_setting){

						//Yes The Global Governance Settings of an Organization is turned ON.
						if($this->is_governance_passed){
							
							//Governance is Purchased by the SI, show team builder.
							$this->show_teambuilder = 1; $this->show_governance = 0;
						}else{
							
							//Governance is not Passed yet by the SI, show Governance
							$this->show_teambuilder = 0; $this->show_governance = 1;	
							
						}//end if($is_governance_passed)
						
					}else{
						
						//None pharmacies are purchased or all expired.
						$this->show_teambuilder = 1; $this->show_governance = 0;
						
					}//end if($this->org_governance_global_setting)
					
				}else{
					
					//Governance Global Setting is Off so no need to show governance
					$this->show_teambuilder = 1; $this->show_governance = 0;		
				}//end if(count($this->governance_purchased_pharmacies) > 0)
					
			}else{
				$this->show_teambuilder = 1; $this->show_governance = 0;
			}//end if($user_org_superintendent)
			*/
			$this->show_teambuilder = 1; $this->show_governance = 1; //Always On for Owner of the Organization.
			
			$this->get_my_organizations = $this->pharmacy->get_org_by_id($this->session->id);  //Get My Organizations List
			//$this->get_my_pharmacies_surgeries = get_pharmacy_surgery_list('', $this->my_organization_id); //Get My Pharmacy Surgeries List 			
			
			//If owner is also a SI
			if($get_organization_details['superintendent_id']){
				
				$check_si_contract_read_status = $this->governance->get_user_governance_read_status($get_organization_details['superintendent_id'],$this->my_organization_id,'', 'SI');
				$data['check_si_contract_read_status'] = $check_si_contract_read_status;
				
				$chk_if_si_contract_in_temp = $this->governance->get_governace_hr_temp_details('',$check_si_contract_read_status['id']);			
				$data['chk_if_si_contract_in_temp'] = $chk_if_si_contract_in_temp;
				
				$this->get_si_user_data = $this->users->get_user_details($this->session->organization['superintendent_id']);
				$data['get_si_user_data'] = $this->get_si_user_data;
				
				if(!$get_si_user_data['is_prescriber']){
					
					//Get PGD Details
					$si_purchased_items_split_arr = $this->purchase->get_purchased_items_split_by_user($this->session->organization['superintendent_id']);
					$data['si_purchased_items_split_arr'] = $si_purchased_items_split_arr;
					
				}//end if(!$get_si_user_data['is_prescriber'])
				
				$si_training_list = $this->training->get_training_courses_list($$get_si_user_data['user_type']);
				$data['si_training_list'] = $si_training_list;
				
				
			}//end if($this->session->is_owner && $this->session->organization['superintendent_id'])
		
		}elseif($this->user_org_superintendent){
			
			$this->my_organization_id = $this->user_org_superintendent['id'];
			$this->is_governance_passed = $this->governance->is_governance_read_by_user($this->session->id, $this->my_organization_id, '', 'SI',$this->session->user_type);

			//Hold Governance Global setting Status
			$this->org_governance_global_setting = $this->user_org_superintendent['governance_status'];
			$data['org_governance_global_setting'] = $this->org_governance_global_setting;
			
			//Holds Purchase list array of Governance, this will mostly going to be used for SI, to check if he is allowed to go for governance
			$this->governance_purchased_pharmacies = $this->governance->get_governance_purchased_pharmacies($this->my_organization_id,'P');
			$data['governance_purchased_pharmacies'] = $this->governance_purchased_pharmacies;

			//Holds Purchase list array of Survey, this will mostly going to be used for SI, to check if he is allowed to go for Survey
			$this->survey_purchased_pharmacies = $this->survey->get_survey_purchased_pharmacies($this->my_organization_id,'P');
			$data['survey_purchased_pharmacies'] = $this->survey_purchased_pharmacies;

			if(count($this->governance_purchased_pharmacies) > 0){
			//There is atleast one Pharmacy whose governance is purchased by an organization and is not expired. So governance is applied on this Organization and SI.
				if($this->org_governance_global_setting){
					//Yes The Global Governance Settings of an Organization is turned ON.
					
					if($this->is_governance_passed){
						//Governance is Purchased by the SI, show team builder.
						$this->show_teambuilder = 1; $this->show_governance = 0;
					}else{
						//Governance is not Passed yet by the SI, show Governance
						$this->show_teambuilder = 0; $this->show_governance = 1;	
					}//end if($is_governance_passed)
				}else{
					//None pharmacies are purchased or all expired.
					$this->show_teambuilder = 1; $this->show_governance = 0;
					
				}//end if($this->org_governance_global_setting)
				
			}else{
				//Governance Global Setting is Off so no need to show governance
				$this->show_teambuilder = 1; $this->show_governance = 0;
						
			}//end if(count($this->governance_purchased_pharmacies) > 0)
			
			$this->get_my_organizations = $this->pharmacy->get_org_by_id($this->session->id); // get_pharmacy_surgery_list($this->session->id, ''); //Get My Organizations List
			//$this->get_my_pharmacies_surgeries = get_pharmacy_surgery_list('', $this->my_organization_id); //Get My Pharmacy Surgeries List 

		}else{
			$this->get_my_organizations = get_pharmacy_surgery_list($this->session->id, ''); //Get My Organizations List
			//$this->get_my_pharmacies_surgeries = get_pharmacy_surgery_list($this->session->id, '');	 //Get My Pharmacy Surgeries List
		}//end if($this->session->is_owner)

		$data['get_my_organizations'] = unique_multidim_array( $this->get_my_organizations, 'organization_id' );

		// $data['My_get_my_pharmacies_surgeries'] = $this->get_my_pharmacies_surgeries;

		$data['show_teambuilder'] = $this->show_teambuilder;
		$data['show_governance'] = $this->show_governance;
		
		$data['my_organization_id'] = $this->my_organization_id;
		$data['is_governance_passed'] = $this->is_governance_passed;

		$this->user_signatures = $this->users->get_user_signatures($this->session->id);
		$data['user_signatures'] = $this->user_signatures;

		//Menu Managment with privilages work
		if($this->session->is_owner || $this->user_org_superintendent){
			
			$this->menu_organization_id = $this->my_organization_id;
			$this->menu_pharmacy_surgery_id = '';
			
		}else{
			
			$this->menu_organization_id = $this->session->organization_id;
			$this->menu_pharmacy_surgery_id = $this->session->pharmacy_surgery_id;

			$this->my_role_in_pharmacy = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $this->session->pharmacy_surgery_id);

		}//end if($this->session->is_owner || $user_org_superintendent)

		//Left Menu Control of users
		$this->allowed_user_menu = authenticate_user_panel($this->session->id, $this->menu_organization_id,$this->menu_pharmacy_surgery_id);
		
		//Get New/ Updated Contract List for every User.
		$this->user_new_contract_list = $this->governance->get_user_revised_contract_list($this->session->id);
		
		//Loading Invitations (If Any)
		$this->get_user_invitations_arr = $this->invitations->get_user_invitations_list($this->session->id);
		$data['user_invitations_arr'] = $this->get_user_invitations_arr;

		$data['menu_organization_id'] = $this->menu_organization_id;
		$data['menu_pharmacy_surgery_id'] = $this->menu_pharmacy_surgery_id;
		$data['allowed_user_menu'] = $this->allowed_user_menu;
		$data['MY_role_in_pharmacy'] = $this->my_role_in_pharmacy;
		$data['user_new_contract_list'] = $this->user_new_contract_list;

		$this->load->vars($data);
		
	}
	
}

class MY_Organization_Controller extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();

		if(!$this->belong_to_any_organization){

			//One who is not part of any organisation/ pharmacies will not be allowed to access Organization dashboard
			$this->session->set_flashdata('err_message', 'Your are not authorized to access this page.');
			redirect(base_url().'dashboard');	
			
		}//end if(!$this->session->show_organization)

	}
}

class MY_Dashboard_Controller extends MY_Controller {
	protected $is_organization_member;
	public function __construct()
	{
		
		parent::__construct();

		$this->is_organization_member = $this->belong_to_any_organization;
		$data['is_organization_member'] = $this->is_organization_member;
		$this->load->vars($data);
		
	}
	
}

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
	
}//end unique_multidim_array($array, $key) 