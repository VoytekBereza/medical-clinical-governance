<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization extends MY_Organization_Controller {

    public function __construct()
    {
        parent::__construct();

        // Security Check: Verify if the user still belongs to the selected pharmacy_surgery_id
        if($this->session->pharmacy_surgery_id){
            check_if_user_exist_in_pharmacy($this->session->id, $this->session->pharmacy_surgery_id);
        } // if($this->session->pharmacy_surgery_id)
        
        // Load BreadcrumbComponent Library
		$this->load->library('BreadcrumbComponent');
		
		// Add JS Scripts for using in Organization
        $this->stencil->js('kod_scripts/organization/custom.js');

        //Sets the variable $head to use the slice head (/views/slices/header_script.php)
        $this->stencil->slice('header_script');

        //Sets the variable $head to use the slice head (/views/slices/header_top.php)
        $this->stencil->slice('header_top');

        //Sets the Left Navigation
        $this->stencil->slice('dashboard_left_pane');

        //Sets the variable $head to use the slice head (/views/slices/footer.php)
        $this->stencil->slice('footer');

        //Sets the variable $head to use the slice head (/views/slices/footer_script.php)
        $this->stencil->slice('footer_script');
        
        /* --------------- Scripts for validations ------------ */
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
            
        // Js file using for CMS page validation
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/formValidation_2.min.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/bootstrap.min.js');

    }

    public function index(){
           
        redirect(SURL.'dashboard');

    } //end index()

    public function dashboard($page_no = ''){
		
		// Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
        if($this->belong_to_any_organization){
        
            if(!$this->user_org_superintendent && !$this->session->is_owner){

                $my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id );

                if( count($my_pharmacies_surgeries) > 1 && !$this->session->pharmacy_surgery_id )
                    redirect(SURL.'organization/member-dashboard');

                if( count($my_pharmacies_surgeries)  == 1 && !$this->session->pharmacy_surgery_id ){
                
                    $my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id );

                    // If another Pharmacy / Surgery is selected
                    $pharmacy_data = $this->pharmacy->get_pharmacy_surgery_details($my_pharmacies_surgeries[0]['pharmacy_surgery_id']);
                
                    // set session for: Organization ID
                    $this->session->organization_id = $pharmacy_data['organization_id'];
					$this->session->pmr_organization_id = $this->session->organization_id;
                    
                    // set session for: Pharmacy / Surgery ID
                    $this->session->pharmacy_surgery_id = $pharmacy_data['id'];
					$this->session->pmr_pharmacy_surgery_id = $this->session->pharmacy_surgery_id;

                } // if( count($my_pharmacies_surgeries)  == 1 && !$this->session->pharmacy_surgery_id )

                if($this->session->pharmacy_surgery_id )
                    redirect(SURL.'organization/pharmacy-surgery/'. $this->session->pharmacy_surgery_id);
                    
            } else if($this->session->is_owner || $this->user_org_superintendent) {
            } // End if(!$this->user_org_superintendent && !$this->session->is_owner)

        } else
            redirect(SURL.'dashboard');
        // if($this->belong_to_any_organization)

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = 20;

        //set title
        $page_title = $cms_data_arr['cms_page_arr']['page_title'];
        $this->stencil->title($page_title);

        // Get all country
        $get_all_country = $this->organization->get_all_country();

        $data['get_all_country'] = $get_all_country;
        
        if($this->session->is_owner || $this->user_org_superintendent){
            
            //User is an owner or a SI of an Organization
            $organization_id = $this->my_organization_id;

            $superintendent_invitation_found = $this->invitations->superintendent_invitation_found($organization_id);
            $data['superintendent_invitation_arr'] = $superintendent_invitation_found;
			
			//Organization Details for SI and Owner
            $get_organization_details = $this->organization->get_organization_details($organization_id);
            $data['organization_details_arr'] = $get_organization_details;

            if($get_organization_details['superintendent_id']) {
                //Is Owner and also have the SI assigned, Show Pharmacies Add and View Pharmacies.

                //Check if the User have passed the Governance, also is not an Owner but is an SI
                if($this->user_org_superintendent && !$this->show_teambuilder){
                    
                    //User have not passed the Governance so pick the govnernace/ sop/ hr records from the database
                    $get_organization_governance_arr = $this->governance->get_org_governance_details('',$organization_id);
                    $data['organization_governance_arr'] = $get_organization_governance_arr;
                    
                    //If user is a SI, get the HR	
                    $get_organization_sop_list = $this->governance->get_organization_sop_tree($organization_id,$this->session->user_type);
                    $data['organization_sop_list'] = $get_organization_sop_list;

                    $get_user_sop_read_list = $this->governance->get_user_sop_read_list($this->session->id,$organization_id, '');
                    $data['user_sop_read_list'] = $get_user_sop_read_list;

                    $get_user_governance_read_data = $this->governance->get_user_governance_read_status($this->session->id,$organization_id,'','SI');
                    $data['user_governance_read_data'] = $get_user_governance_read_data;

                }//end if(!$this->show_teambuilder)




                // if search Pharmacy or Surgery and $this->input->post('pharmacy_surgery_search') not empty
                if($this->input->get('is_src') != ''){
                    
                    //$filter = $this->input->post('pharmacy_surgery_search');
					$filter = $this->input->get('list_pharmacies_surgeries_filter');
                    $data['filter_for'] = $filter;

					$total_pharmacies_surgeries = $this->pharmacy->get_all_org_pharmacies($this->input->get('pharmacy_surgery_search'),$organization_id, $filter, '', '');
                    $pharmacies_surgeries = $this->pharmacy->get_all_org_pharmacies($this->input->get('pharmacy_surgery_search'),$organization_id, $filter, '', $limit, $page);
                
                } else {
                
					$filter = 'All';
					$data['filter'] = $filter;
					// end if( $this->input->post('list_pharmacies_surgeries_filter') != '')
					$total_pharmacies_surgeries = $this->pharmacy->get_all_org_pharmacies('',$organization_id, $filter, '');
					$pharmacies_surgeries = $this->pharmacy->get_all_org_pharmacies('',$organization_id, $filter, '', $limit, $page);
                    
                }// end  else

            } //end if






			$data['pharmacies_surgeries'] = $pharmacies_surgeries;
			$data['total_pharmacies_surgeries'] = count($total_pharmacies_surgeries);
			
			// Codeigniter Pagination
			$this->load->library('pagination');
			$config['base_url'] = SURL.'organization/dashboard';
			$config['total_rows'] = count($total_pharmacies_surgeries);
			$config['per_page'] = $limit;
			$config["uri_segment"] = 3;
			$config['reuse_query_string'] = TRUE;
			
			$config['full_tag_open'] = '<ul class="pagination" style="margin: 9px 6px 4px 0px">';
			$config['full_tag_close'] = '</ul> ';
			
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			
			$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
			$config['cur_tag_close'] = '</a></li>';
			
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
	
			$this->pagination->initialize($config);
			$limit = $config['per_page'];
	
			$data['pagination_links'] = $this->pagination->create_links();
			
        } else {
        
            //I am manager or STAFF, will see you soon!
            // if I am the manager or a staff member of any pharmacies / surgeries :: Get the list of my pharmacies / surgeries
            $data['get_my_pharmacies_surgeries'] = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id );
            
        } //end if($this->session->is_owner || $this->user_org_superintendent)
    	
        // set title
        $page_title = $training_detail_arr['meta_title'];
        $this->stencil->title($page_title);

        $non_presriber_usertype_arr = array('2','3');
        $data['non_presriber_usertype_arr'] = $non_presriber_usertype_arr;

        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->js('jquery.mousewheel-3.0.6.pack.js');
        $this->stencil->js('org_dashboard.js');

        // Add "JS" and "CSS" for UI element ( On/Off Switch and others )
        $this->stencil->js('highlight.js');
        $this->stencil->js('bootstrap-switch.js');
        $this->stencil->css('highlight.css');
        $this->stencil->css('bootstrap-switch.css');
        
        //Tree View Script
        $this->stencil->js('bootstrap-treeview.js');
        
        // Time display
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');
    
        //Editor Files
        $this->stencil->js('tinymce/tinymce.min.js');
		
		// My css calling for dashboard
		$this->stencil->css('kod_css/mystyle.css');

        // Js Form validation
        $this->stencil->js('kod_scripts/jquery.validate.js');
        $this->stencil->js('kod_scripts/custom_validate.js');

        // Fetch ORAL PGD's (For Purchase)
        $this->load->model('pgds_mod', 'pgds');

        $oral_pgd_arr = $this->pgds->get_pgds_list('O');
        $data['oral_pgd_arr'] = $oral_pgd_arr;

        $premium_oral_pgd_arr = $this->pgds->get_pgds_list('OP');
        $data['premium_oral_pgd_arr'] = $premium_oral_pgd_arr;

        // Fetch Vaccines PGD's (For Purchase)
        $vaccine_pgd_arr = $this->pgds->get_pgds_list('V');
        $data['vaccine_pgd_arr'] = $vaccine_pgd_arr;
		
			//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
		
        // Load main template
        $this->stencil->layout('dashboard_template'); //dashboard_template
        $this->stencil->paint('organization/dashboard',$data);

    } //dashboard() 

    //member_dashboard(): Member dashboard is for Manager and Staff members only
    public function member_dashboard(){
		
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		 
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 
		$this->breadcrumbcomponent->add('Member Dashboard', base_url().'member-dashboard');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        
        if($this->belong_to_any_organization){
        
            if($this->user_org_superintendent)
                redirect(SURL.'organization/dashboard');
            // if($this->user_org_superintendent)
            
        } else
            redirect(SURL.'dashboard');
        // if($this->belong_to_any_organization)

        if($this->session->pharmacy_surgery_id){
            redirect(SURL.'organization/pharmacy-surgery/');
        } else {
            
            // First time request -> exact after login
            
            $my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id);
            
            if(count($my_pharmacies_surgeries) > 0){
            
                if(count($my_pharmacies_surgeries) > 1){
                    // Wellcome message with drop down for select pharmacy surgery
                    $data['show_instructions'] = 1;
                    $data['member_wellcome_dashboard_view'] = 1;
                } else {
                    
                    //$this->session->pharmacy_surgery_id = $my_pharmacies_surgeries[0]['pharmacy_surgery_id'];
                    redirect(SURL.'organization/pharmacy-surgery/'.$my_pharmacies_surgeries[0]['pharmacy_surgery_id']);
                    
                } // if(count($my_pharmacies_surgeries) > 1)
                
            } // if(count($my_pharmacies_surgeries) > 0)
        }
        
        $data['get_my_pharmacies_surgeries'] = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id );

        //set title
        $page_title = $training_detail_arr['meta_title'];
        $this->stencil->title($page_title);

        $non_presriber_usertype_arr = array('2','3');
        $data['non_presriber_usertype_arr'] = $non_presriber_usertype_arr;

        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->js('jquery.mousewheel-3.0.6.pack.js');
        $this->stencil->js('org_dashboard.js');

        // Add "JS" and "CSS" for UI element ( On/Off Switch and others )
        $this->stencil->js('highlight.js');
        $this->stencil->js('bootstrap-switch.js');
        $this->stencil->css('highlight.css');
        $this->stencil->css('bootstrap-switch.css');
        $page_title = $training_detail_arr['meta_title'];
        $this->stencil->title($page_title);

       	//set title
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));

        // My css calling for member dashboard
		$this->stencil->css('kod_css/mystyle.css');
        // Js Form validation
        $this->stencil->js('kod_scripts/jquery.validate.js');
        $this->stencil->js('kod_scripts/custom_validate.js');

        // Load main template
        $this->stencil->layout('dashboard_template'); //dashboard_template
        
        $this->stencil->paint('organization/pharmacy_surgery/member_dashboard', $data);
        
    } // member_dashboard()
    
    //There is no SI asigend against Org, owner is sending invitation for SI.
    public function invite_superintendent(){

        if(!$this->input->post() && !$this->input->post('email_address')) redirect(base_url());

        extract( $this->input->post() );

        if(trim($email_address) == '' || !filter_var(trim($email_address), FILTER_VALIDATE_EMAIL) ){

            $data['error_status'] = 1;
            $data['err_message'] = '<strong>ERROR: Invalid or empty Email Address.</strong>';

        }else{

            //Check if logged user and invited email address is not same
            if($this->session->email_address != trim($this->input->post('email_address'))){

                //check if the given email address is a member of the database or not
                $chk_if_user_already_exist = $this->users->get_user_by_email($email_address);
				
                if($chk_if_user_already_exist){
                    //User exist in database
					
					$si_usertype = array('2','3');
					
                    if(!in_array($chk_if_user_already_exist['user_type'],$si_usertype)){
                        //Email address entered is not a Pharmacist nither nurse which is must to become a Superintendent

                        $data['error_status'] = 1;
                        $data['err_message'] = '<strong>ERROR: Superintendent can only be a Pharmacist or a Nurse. The email address you have entered is not a Pharmacist nor a Nurse.</strong>';

                    }else{

                        //Check if User is already a SI in someother organization
                        $check_user_si_status = $this->organization->user_already_superintendent($chk_if_user_already_exist['id']);
                        $check_user_staff_status = $this->organization->already_staff_in_another_organization($chk_if_user_already_exist['id'],$this->my_organization_id);
                        
                        if($check_user_si_status){
                            //User Already SI in some Organization
                            $data['error_status'] = 1;
                            $data['err_message'] = '<strong>ERROR: User you have selected is already a Superintendent in an Organisation.</strong>';

                        }else{

                            if($chk_if_user_already_exist['is_owner'] == 1){
                                //Selected User is already an Owner of an Organization which is not allowed

                                $data['error_status'] = 1;
                                $data['err_message'] = '<strong>ERROR: User selected is already Owner of an Organisation. </strong>';
                                
                            }elseif($check_user_staff_status){
                                //User belongs as a staff in some other organization he is not allowed to become SI

                                $data['error_status'] = 1;
                                $data['err_message'] = '<strong>ERROR: User already working as staff in one or more Organisation. </strong>';
                                
                            }else{

                                //Email Address Entered is the Pharmacist, and all the business rules are passed. Add Data invitation
                                $push_invitation_id = 1; //$this->invitations->push_invitation($this->session->id, $chk_if_user_already_exist, $this->my_organization_id, 0,'SI','D');
                                if($push_invitation_id){

                                    $data['error_status'] = 0;
                                    $data['success_status'] = 1;
                                    $data['invitation_id'] = $push_invitation_id;
                                    $data['user_detail_arr'] = $chk_if_user_already_exist;

                                    $this->stencil->layout('ajax'); //ajax
                                    $ajax_response = $this->load->view('invitations/invitation_ajax.php',$data,true);

                                    $data['response'] = $ajax_response;

                                } //end if($push_invitation_id)

                            }//end if($chk_if_user_already_exist['is_owner'] == 1)

                        }//end if($check_user_si_status)

                    }//end if($chk_if_user_already_exist['user_type'] != 2)

                }else{

                    $user_data['email_address'] = $email_address;
                    //User do not exist into the database, send invitation by email
                    $push_invitation_id = 1; //$this->invitations->push_invitation($this->session->id,$user_data,$this->my_organization_id,0,'SI','E');

                    $data['error_status'] = 0;
                    $data['success_status'] = 1;
                    //$data['invitation_id'] = $push_invitation_id;
                    $data['user_detail_arr'] = $user_data;

                    $this->stencil->layout('ajax'); //ajax
                    $ajax_response = $this->load->view('invitations/invitation_ajax.php',$data,true);
                    $data['response'] = $ajax_response;

                }//end if($chk_if_user_already_exist)

            }else{

                //Cannot send invitation to Self, generate error.
                $data['error_status'] = 1;
                $data['err_message'] = '<strong>ERROR: You cannot send an invite to self, please use ELECT SELF button to Elect Yourself as an SuperIntendent</strong>';

            }//end if($this->session->email_address != trim($this->input->post('email_address')))

        }//end if(trim($this->input->post('email_address')))

        // Send response with data for push invitation and HR to fancybox
        if($data['error_status'] == 0){

            if($chk_if_user_already_exist){

                $data['invitation_sent_to_arr'] = $chk_if_user_already_exist['id'];
                $data['invitation_method'] =  'D';
				
				$chk_if_user_already_exist = $this->users->get_user_by_email($email_address);
				$user_first_last_name = ucwords($chk_if_user_already_exist['first_name'].' '.$chk_if_user_already_exist['last_name']);
				$user_type = filter_string($chk_if_user_already_exist['user_type_name']);

            } else {
                
                $data['invitation_sent_to_arr'] = $user_data;
                $data['invitation_method'] =  'E';
				$user_first_last_name = '[USER_NAME]';
				$user_type = '[USER]';

            } // if($chk_if_user_already_exist)

            // Prepare parameters to get [ Governance HR ]
            $pharmacy_surgery_type = $this->input->post('pharmacy_surgery_type');
            $invitation_sent_to_user_type = $this->invitations->get_usertype_by_tag($invitation_for);

            $governance_hr_txt = $this->governance->get_governance_hr('', 'SI', '');
            // Updated
			
            // Get ORG details
            $get_organization_arr = $this->organization->get_organization_details($this->my_organization_id);
            $organization_name = filter_string($get_organization_arr['company_name']);
			
            $search_arr = array('[USER_NAME]','[ORGANISATION_NAME]','[PHARMACY_NAME]','[PHARMACY_ADDRESS]','[ROLE]','[ISSUE_DATE]','[CONTRACT_NO]','[USER]');
			$replace_arr = array($user_first_last_name, $organization_name,$pharmacy_surgery_details['pharmacy_surgery_name'].', '.$pharmacy_surgery_details['postcode'], $pharmacy_surgery_details['address'],filter_string($chk_if_user_already_exist['user_type_name']) ,kod_date_format(date('Y-m-d G:i:s'),true),strtoupper($this->common->random_number_generator(16)), $user_type);
			
			$governance_hr_txt['hr_text'] = stripcslashes((str_replace($search_arr, $replace_arr, $governance_hr_txt['hr_text'])));
			
			$data['governance_hr'] = $governance_hr_txt;
            // Common for Both invitation types [ Email and Database ]
            $data['organization_id'] = $this->my_organization_id;
            $data['pharmacy_surgery_id'] = 0;
            $data['invitation_for'] = 'SI';

        } // if($data['error_status'] == 0)

        echo json_encode($data);

    }//end invite_superintendent()

    //Cancel/ remove Supterintendent Request
    function cancel_superintendent_invite(){

        extract($this->input->post());

        if(!$this->input->post() && !$this->input->post('inv_id')) redirect(base_url());

        $cancel_si_invitation = $this->invitations->cancel_invitation($inv_id);

    }//end cancel_superintendent_invite()

    // Start - cancel_manager_invite(): Cancel / remove Manager Request
    function cancel_manager_invite(){

        extract($this->input->post());

        if(!$this->input->post() && !$this->input->post('inv_id')) redirect(base_url());

        $cancel_m_invitation = $this->invitations->cancel_invitation($inv_id);

    }// End - cancel_manager_invite()

    //ELECT SELF as a Superintendent
    public function superintendent_elect_self(){

        if(!$this->input->post() && !$this->input->post('elect_self_hid')) redirect(base_url());

        //Check If User Self is a Pharmacist or Nurse?
        if($this->session->user_type == 2 || $this->session->user_type == 3){

            $elect_self_as_si = $this->organization->elect_self($this->session->id, $this->session->user_type, '', $this->my_organization_id, 'SI', $this->user_org_superintendent, $this->session->is_owner, $this->input->post('governance_hr_text'));

            if($elect_self_as_si){

                //Update Session
                $get_organization_details = $this->organization->get_organization_details($this->my_organization_id);
                $organinzation_data['organization'] = $get_organization_details;
                $this->session->set_userdata($organinzation_data);

                $this->session->set_flashdata('ok_message', 'Superintendent successfully assigned to the organisation.');
                redirect(base_url().'organization/dashboard');

            }//end if($elect_self_as_si)

        } else {

            //Not a Pharmacist
            $this->session->set_flashdata('err_message', 'To become a Superintendent of an Organisation you need to be a Pharmacist or a Nurse.');
            redirect(base_url().'organization/dashboard');

        }//end if($this->session->user_type == 2)

    }//end supterintendent_elect_self()

    public function settings(){
		
        // Bread crumb 
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 $this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 $this->breadcrumbcomponent->add('Organisation Global Settings', base_url().' settings');
		
		 // Bread crumb output
		 $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
        
            // Get organization global settings
            $get_organization_settings = $this->organization->get_organization_global_settings($this->my_organization_id);

            // Get organization Governance and Surveys purchase status
            

            // Get Default Name doctor and pharmacist
            $get_default_doctor_pharmacist = $this->organization->get_default_doctor_pharmacist($this->my_organization_id);
            $data['get_default_doctor_pharmacist']=$get_default_doctor_pharmacist;
            
            // Get Default Name doctor and pharmacist Prescriber
            $get_default_prescriber = $this->organization->get_default_prescriber($this->my_organization_id);
            $data['get_default_prescriber']=$get_default_prescriber;
            
                // Get Default  Prescriber Fess
            $get_default_prescriber_fees = $this->organization->get_default_prescriber_fees($this->my_organization_id);
            $data['get_default_prescriber_fees']=$get_default_prescriber_fees;
            
            // Get CQC Details
            $get_cqc_details= $this->organization->get_cqc_details($this->my_organization_id);
            $data['get_cqc_details']= $get_cqc_details;
    
            if(!$get_organization_settings)
                redirect(SURL);
    
            $data['organization_settings'] = $get_organization_settings;

            //Get Phramacy List for Publish/ Unpublish
            $get_pharamcy_surgery_list = $this->pharmacy->get_pharmacy_surgery_list($this->my_organization_id);
            $data['pharamcy_surgery_list'] = $get_pharamcy_surgery_list;
            
			#ORGANIZATION PRODUCT LISTING
			            
            //Get Governance Package Record
            $get_governance_package_list = $this->governance->get_governance_package(1);
            $data['governance_package_list'] = $get_governance_package_list;
            
            //Get List of Pharmacies whose Governance are NOT PURCHASED by Organization or SI.
            $get_governance_non_purchased_pharmacies = $this->governance->get_governance_purchased_pharmacies($this->my_organization_id,'NP');
            $data['governance_non_purchased_pharmacies'] = $get_governance_non_purchased_pharmacies;
			
			//Get List of Pharmacies whose Governance are PURCHASED by Organization or SI.
			
            ## Purchased list coming from MY CONTROLLER

            //Get Survey Package Record
            $get_survey_package_list = $this->survey->get_survey_package(1);
            $data['survey_package_list'] = $get_survey_package_list;
            
            //Get List of Pharmacies whose Survey are NOT PURCHASED by Organization or SI.
            $get_survey_non_purchased_pharmacies = $this->survey->get_survey_purchased_pharmacies($this->my_organization_id,'NP');
            $data['survey_non_purchased_pharmacies'] = $get_survey_non_purchased_pharmacies;
            
            //Get List of Pharmacies whose Survey are PURCHASED by Organization or SI.
            ## Purchased list coming from MY CONTROLLER
    
            //set title
            //$page_title = $page_data['page_title'];
          	//set title
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));
    
            // Add "JS" and "CSS" for UI element ( On/Off Switch and others )
            // Time display
            $this->stencil->css('bootstrap-datetimepicker.min.css');
			$this->stencil->js('moment-with-locales');
            $this->stencil->js('bootstrap-datetimepicker.min.js');
            
            $this->stencil->js('org_dashboard.js');

            //Fancy Box Files
            $this->stencil->css('jquery.fancybox.css');
            $this->stencil->js('jquery.fancybox.js');
            $this->stencil->js('jquery.mousewheel-3.0.6.pack.js');
    
            $this->stencil->js('highlight.js');
            $this->stencil->js('bootstrap-switch.js');
            $this->stencil->css('highlight.css');
            $this->stencil->css('bootstrap-switch.css');
            
            // Js Form validation
            $this->stencil->js('kod_scripts/jquery.validate.js');
            $this->stencil->js('kod_scripts/custom_validate.js');

			$this->stencil->layout('dashboard_template'); //dashboard_template
		 
            //load main Dashbaord template for DOCTOR
            $this->stencil->paint('organization/settings',$data);
    
        }else{
            
            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end settings()

    public function settings_process(){
        
        if(!$this->input->post()) redirect(base_url());
        

        if($this->input->post('pharmacy_surgery_global_id')!=""){
            
            // Calling Model for time insertion
            $update_org_settings_time = $this->organization->add_update_organization_settings_time($this->input->post());
        
            if($update_org_settings_time)
                echo true;
            else 
                echo false;
        
        } else{

            //Update the Organisation Settings into the database.
            $update_org_settings = $this->organization->update_organization_settings($this->my_organization_id, $this->input->post());
    
            if($update_org_settings)
                echo true;
            else
                echo false;
        }//end if($this->input->post('pharmacy_surgery_global_id')!="")
        
    }//end settings_process()
    
    public function online_doctor_pharmacies(){
        
        if(!$this->input->post()) redirect(base_url());
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            if(count($this->input->post('pharmacy_chk')) > 0){
                
                $update_online_doc_settings = $this->organization->update_pharmacy_surgery_online_doctor($this->my_organization_id, $this->input->post());
                
                if($update_online_doc_settings){
                    $this->session->set_flashdata('ok_message', "Pharmacies Online Doctor Settings Updated Successfully");
                    redirect(SURL.'organization/medicine-management');
                }else{
                    $this->session->set_flashdata('err_message', "Oops! Something went wrong.");
                    redirect(SURL.'organization/medicine-management');
                    
                }//end if($update_online_doc_settings)
            
            }else{
                $this->session->set_flashdata('err_message', "You didn't selected any pharmacy to change Online Doctor Medicine.");
                redirect(SURL.'organization/medicine-management');
                
            } // end if(count($this->input->post('pharmacy_chk')) > 0)
        
        } // end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)
        
    } // end online_doctor_pharmacies()
	
	public function embed_code_pharmacies(){
        
        if(!$this->input->post()) redirect(base_url());
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            if(count($this->input->post('pharmacy_chk')) > 0){
                
                $update_online_doc_settings = $this->organization->update_pharmacy_surgery_embed_code($this->my_organization_id, $this->input->post());
                
                if($update_online_doc_settings){
                    $this->session->set_flashdata('ok_message', "Pharmacies Embed Code Updated Successfully");
                    redirect(SURL.'organization/settings');
                }else{
                    $this->session->set_flashdata('err_message', "Oops! Something went wrong.");
                    redirect(SURL.'organization/settings');
                    
                }//end if($update_online_doc_settings)
            
            }else{
                $this->session->set_flashdata('err_message', "You didn't selected any pharmacy to change Embed Code Status.");
                redirect(SURL.'organization/settings');
                
            } // end if(count($this->input->post('pharmacy_chk')) > 0)
        
        } // end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)
        
    } // end embed_code_pharmacies()

    //////////////////////////////////////////////////////////////////////
    /* ---------------- Start Invite Manager And Staff --------------- */
    ////////////////////////////////////////////////////////////////////

    // Start - invite_manager_staff():
    public function invite_manager_staff(){

        if(!$this->input->post() && !$this->input->post('email_address')) redirect(base_url());

        extract( $this->input->post() );

        if(trim($email_address) == '' || !filter_var(trim($email_address), FILTER_VALIDATE_EMAIL) ){

            // If email address not entered
            $data['error_status'] = 1;
            $data['err_message'] = '<strong>ERROR: Invalid or empty Email Address.</strong>';

        }else{
			
			if(trim($invitation_for) == ''){

				// If email address not entered
				$data['error_status'] = 1;
				$data['err_message'] = '<strong>ERROR: Please check Job Type for your Pharmacy.</strong>';

        	}else{

				// if organization id empty for member_dashboard 
				if($this->my_organization_id == "") {
				
					$pharmacy_id =  $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
					$this->my_organization_id = $pharmacy_id['organization_id'];
					
				} // if($this->my_organization_id == "")
	
				$organization_id = $this->my_organization_id;
				$already_invited = $this->invitations->verify_invitation_sent($organization_id, $pharmacy_surgery_id, $email_address, $invitation_for);
	
				$already_staff_member = $this->invitations->is_already_staff_member($organization_id, $pharmacy_surgery_id, $email_address);
	
				//Cannot Re-Send invitation to this user : Invitation already sent to this user
				$inv_for = $this->invitations->get_invitation_type($invitation_for);
	
				if(!$already_invited){
	
					// !$already_staff_member
					// $inv_for != 'Manager'
	
					if($invitation_for != 'M' && $already_staff_member){
						
						$data['error_status'] = 1;
						$data['err_message'] = '<strong>ERROR: The user already is a staff member as a '.$inv_for.' in this Pharmacy / Surgery.</strong>';
	
					} else {
						
						//check if the given email address is a member of the database or not
						$chk_if_user_already_exist = $this->users->get_user_by_email($email_address);

						//Check if logged user and invited email address is not same
						if($this->session->email_address != trim($this->input->post('email_address'))){
	
							$organization_id = $this->my_organization_id;
	
							if($chk_if_user_already_exist){
	
								if($chk_if_user_already_exist['is_owner'] != 1){
	
									//User exist in database
	
									//Check if User is already a SI in any organization
									$check_user_si_status = $this->organization->user_already_superintendent($chk_if_user_already_exist['id']);
	
									// Check if the user is a superintendent of any other organization
									if($check_user_si_status['id'] != '' && $check_user_si_status['id'] != $organization_id){
	
										//User Already SI in some Organization
										$data['error_status'] = 1;
										$data['err_message'] = '<strong>ERROR: User you have entered is the Superintendent in other Organisation.</strong>';
	
									} else {
	
										if($invitation_for != 'M'){
	
											if($chk_if_user_already_exist['user_type_name'] == 'Doctor')
	
												$invite_for = 'DO';
	
											 else if($chk_if_user_already_exist['user_type_name'] == 'Pharmacist')
	
												$invite_for = 'PH';
	
											 elseif($chk_if_user_already_exist['user_type_name'] == 'Nurse')
	
												$invite_for = 'NU';
	
											 else if($chk_if_user_already_exist['user_type_name'] == 'Pharmacy Assistance')
	
												$invite_for = 'PA';
	
											 else if($chk_if_user_already_exist['user_type_name'] == 'Technician')
	
												$invite_for = 'TE';
	
											else if($chk_if_user_already_exist['user_type_name'] == 'Pre-reg')
											
												$invite_for = 'PR';
												
											 else if($chk_if_user_already_exist['user_type_name'] == 'None Health Professional')
												 
												$invite_for = 'NH';
												
											if($invitation_for == $invite_for){
	
												// Email Address Entered is the Pharmacist, and all the business rules are passed. Add Data invitation
												$push_invitation_id = 1; //$this->invitations->push_invitation($this->session->id, $chk_if_user_already_exist, $organization_id, $pharmacy_surgery_id, $invitation_for, 'D');
												if($push_invitation_id){
	
													$data['error_status'] = 0;
													$data['success_status'] = 1;
													$data['invitation_id'] = $push_invitation_id;
	
												} //end if($push_invitation_id)
	
											} else {
	
												// Wrong user type selected
												$data['error_status'] = 1;
												$data['err_message'] = '<strong>ERROR: '.$email_address.' does not exist in the database as a '.$inv_for.'.</strong>';
	
											} // if($invitation_for == $invite_for)
	
										} else {
	
											// Email Address Entered is the Pharmacist, and all the business rules are passed. Add Data invitation
											$push_invitation_id = 1; //$this->invitations->push_invitation($this->session->id, $chk_if_user_already_exist, $organization_id, $pharmacy_surgery_id, $invitation_for, 'D');
											if($push_invitation_id){
	
												$data['error_status'] = 0;
												$data['success_status'] = 1;
												$data['invitation_id'] = $push_invitation_id;
	
											} //end if($push_invitation_id)
	
										} // if($invitation_for != 'M')
	
									} // End - if($check_user_si_status)
	
								} else {
	
									$data['error_status'] = 1;
									$data['err_message'] = '<strong>ERROR: You cannot send an invite to '.$email_address.', User is the owner of an organisation.</strong>';
	
								} // if($chk_if_user_already_exist['is_owner'] != 1)
	
							} else { // if user does not exist
	
								//Email Address Entered is the Pharmacist, and all the business rules are passed. Add Data invitation
	
								$user_data['email_address'] = $email_address;
								
								$push_invitation_id = 1; //$this->invitations->push_invitation($this->session->id, $user_data, $organization_id, $pharmacy_surgery_id, $invitation_for, 'E');
								if($push_invitation_id){
	
									$data['error_status'] = 0;
									$data['success_status'] = 1;
									$data['invitation_id'] = $push_invitation_id;
	
								} // if($push_invitation_id):
	
							}//end if($chk_if_user_already_exist)
	
						} else { // else - if($this->session->email_address != trim($this->input->post('email_address')))
	
							if($invitation_for == 'M'){
	
								//Cannot send invitation to Self, generate error.
								$data['error_status'] = 1;
								$data['err_message'] = '<strong>ERROR: You cannot send an invite to self, please use ELECT SELF button to Elect Yourself as the Manager for this Pharmacy / Surgery</strong>';
	
							} else {
	
								//Cannot send invitation to Self, generate error.
								$data['error_status'] = 1;
								$data['err_message'] = '<strong>ERROR: ERROR: The user already is a staff member as a '.$chk_if_user_already_exist['user_type_name'].' in this Location.</strong>';
	
							} // else
	
						}//end if($this->session->email_address != trim($this->input->post('email_address')))
	
					} // 
	
				} else { // else - if(!$already_invited)
	
					//Cannot Re-Send invitation to this user : Invitation already sent to this user
					$inv_for = $this->invitations->get_invitation_type($invitation_for);
	
					if($already_invited){
	
						$data['error_status'] = 1;
	
						$data['err_message'] = '<strong>ERROR: You cannot Re-Send the invite to '.$email_address.'. The user already invited as a '.$inv_for.'.</strong>';
					}
	
				} // if(!$already_invited)
				
			}
            

        }//end if(trim($this->input->post('email_address')))

        // Send response with data for push invitation and HR to fancybox
        if($data['error_status'] == 0){

            if($chk_if_user_already_exist){

                $data['invitation_sent_to_arr'] = $chk_if_user_already_exist['id'];
                $data['invitation_method'] =  'D';

            } else {
                
                $data['invitation_sent_to_arr'] = $user_data;
                $data['invitation_method'] =  'E';

            } // if($chk_if_user_already_exist)

            // Prepare parameters to get [ Governance HR ]
            if($invitation_for != 'M' || $invitation_for != 'SI')
                $pharmacy_surgery_type = $this->input->post('pharmacy_surgery_type');
            else
                $pharmacy_surgery_type = '';
            // if($invitation_for != 'M' || $invitation_for != 'SI')

            $invitation_sent_to_user_type = $this->invitations->get_usertype_by_tag($invitation_for);

            //echo $invitation_sent_to_user_type . ' - ' . $invitation_for . ' - ' . $pharmacy_surgery_type;
            //exit;

            // Get HR text from db to show on fancybox
            $data['governance_hr'] = $this->governance->get_governance_hr($invitation_sent_to_user_type, $invitation_for, $pharmacy_surgery_type); // 1,2,3 - M,SI,ST - P,S

            // Invitation send to user : full name
            if($chk_if_user_already_exist && is_array($chk_if_user_already_exist)){
                $user_first_last_name = ucwords(filter_string($chk_if_user_already_exist["first_name"]).' '.filter_string($chk_if_user_already_exist["last_name"]));
				$user_type = filter_string($chk_if_user_already_exist['user_type_name']);
			}else{ 
                $user_first_last_name = '[USER_NAME]';
				$user_type = '[USER]';
			}// if(is_array($invitation_sent_to_arr))

            // Get ORG details
            $get_organization_arr = $this->organization->get_organization_details($organization_id);
            $organization_name = filter_string($get_organization_arr['company_name']);

            // Pharmacy / Surgery details
            $pharmacy_surgery_details =  $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);

            // Updated
            $search_arr = array('[USER_NAME]','[ORGANISATION_NAME]','[PHARMACY_NAME]','[PHARMACY_ADDRESS]','[ROLE]','[ISSUE_DATE]','[CONTRACT_NO]','[USER]');
            $replace_arr = array($user_first_last_name, $organization_name, $pharmacy_surgery_details['pharmacy_surgery_name'].', '.$pharmacy_surgery_details['postcode'], $pharmacy_surgery_details['address'],filter_string($chk_if_user_already_exist['user_type_name']),kod_date_format(date('Y-m-d G:i:s'),true),strtoupper($this->common->random_number_generator(16)),$user_type);

            $governance_hr_text_updated = str_replace($search_arr, $replace_arr, $data['governance_hr']['hr_text']);

            $data['governance_hr']['hr_text'] = stripcslashes($governance_hr_text_updated);

            // Common for Both invitation types [ Email and Database ]
            $data['organization_id'] = $organization_id;
            $data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
            $data['invitation_for'] = $invitation_for;

        } // if($data['error_status'] == 0)

        echo json_encode($data);

    } // End - invite_manager_staff():

    // Start - public function elect_self_view_contract() : Function to get HR CONTRACT for Elect self
    public function elect_self_view_contract(){

        //print_this($this->session->user_type);
        //exit;

        //  [invitation_for] => S
        //  [invitation_for] => m

        if(!$this->input->post()) redirect(base_url());

        extract( $this->input->post());
		
		if($invitation_for == 'SI'){

			$si_usertype = array('2','3');
			
			//Must be a Pharmacist or a Nurse
			if(!in_array($this->session->user_type,$si_usertype)){
				
				$data['error_msg'] = 'To become a Superintendent of an Organisation you need to be a Pharmacist or a Nurse.';
				echo json_encode($data);
				exit;
				
			}//end if(in_array($this->session->user_type,$si_usertype))
		}//end if($invitation_for == 'SI')

        if($invitation_for != 'M'){
            $invitation_sent_to_user_type = $this->session->user_type;
        }
        else{
            $invitation_sent_to_user_type = '';
            $pharmacy_surgery_type = '';
        }
		
		if($this->my_organization_id)
			$organization_id = $this->my_organization_id;
		else
			$organization_id = $this->session->organization_id;

            // Invitation send to user : full name
            if($chk_if_user_already_exist && is_array($chk_if_user_already_exist)){
                $user_first_last_name = ucwords(filter_string($chk_if_user_already_exist["first_name"]).' '.filter_string($chk_if_user_already_exist["last_name"]));
				$user_type = filter_string($chk_if_user_already_exist['user_type_name']);
			}else{ 
                $user_first_last_name = '[USER_NAME]';
				$user_type = '[USER]';
				
			}// if(is_array($invitation_sent_to_arr))

            // Get ORG details
            $get_organization_arr = $this->organization->get_organization_details($organization_id);
            $organization_name = filter_string($get_organization_arr['company_name']);

            // Pharmacy / Surgery details
            $pharmacy_surgery_details =  $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);

        	// Get HR text from db to show on fancybox
	        $governance_hr_txt = $this->governance->get_governance_hr($invitation_sent_to_user_type, $invitation_for, $pharmacy_surgery_type);
			
            // Updated
			$user_first_last_name = $this->session->full_name;
			
            $search_arr = array('[USER_NAME]','[ORGANISATION_NAME]','[PHARMACY_NAME]','[PHARMACY_ADDRESS]','[ROLE]','[ISSUE_DATE]','[CONTRACT_NO]','[USER]');
            $replace_arr = array($user_first_last_name, $organization_name,$pharmacy_surgery_details['pharmacy_surgery_name'].', '.$pharmacy_surgery_details['postcode'], $pharmacy_surgery_details['address'],filter_string($chk_if_user_already_exist['user_type_name']) ,kod_date_format(date('Y-m-d G:i:s'),true),strtoupper($this->common->random_number_generator(16)),$user_type);
			
			$governance_hr_txt['hr_text'] = stripcslashes(str_replace($search_arr, $replace_arr, $governance_hr_txt['hr_text']));
			$data['governance_hr'] = $governance_hr_txt;
			$data['organization_name'] = $organization_name;

	        echo json_encode($data);

    } // public function elect_self_view_contract()
	
	public function view_user_hr_contract_data(){
		
		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		$get_contract_data = $this->governance->get_user_governance_data($contract_id);
		
		if($get_contract_data){
			
			$hr_contract = stripcslashes(stripcslashes($get_contract_data['hr_contract']));

			$read_time = date('G:i',strtotime(filter_string($get_contract_data['created_date'])));
			$read_date = date('d/m/y',strtotime(filter_string($get_contract_data['created_date'])));
			
			$user_signatures = $this->users->get_user_signatures(filter_string($get_contract_data['user_id']));			

			if(filter_string($user_signatures['signature_type']) == 'svn')
				$signature_str = filter_string($user_signatures['signature']);
			elseif(filter_string($user_signatures['signature_type']) == 'image')
				$signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
			// if(filter_string($user_signatures['signature_type']) == 'svn')										

			$search_arr = array('[USER_SIGNATURE]','[SIGNED_DATE_TIME]','[SURL]');
			$replace_arr = array($signature_str,'Signed at '.$read_time.' on '.$read_date.' by',SURL);
			
			$get_contract_data['hr_contract'] = str_replace($search_arr,$replace_arr,$hr_contract);
			$get_contract_data['user_full_name'] = ucwords($get_contract_data['user_full_name']);
			$data['contract_data'] = $get_contract_data;
			
		}else{
            $data['error_status'] = 1;
            $data['err_message'] = '<strong>ERROR: Invalid request, please contact site admin.</strong>';
		}
		echo json_encode($data);
		
	}//end view_user_hr_contract_data()

	//Function resend_invitation_contract(): This will open the popup window to send teh new contract by modifying the existing one
	public function resend_hr_contract(){
		
		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		//First check if we have any temporary contract in our contract table. If yes then we are going to use that.
		$chk_if_contract_in_temp = $this->governance->get_governace_hr_temp_details('',$contract_id);
		
		if(trim($contract_id) != ''){

			if($chk_if_contract_in_temp){

				$chk_if_contract_in_temp['hr_contract'] = stripcslashes($chk_if_contract_in_temp['hr_contract']);
				$request_changes_notes = stripcslashes($chk_if_contract_in_temp['request_changes_notes']);
				
				$stripped_notes = (stripcslashes($chk_if_contract_in_temp['request_change_notes']));
				$chk_if_contract_in_temp['request_change_notes'] = $stripped_notes;
				
				$data['contract_temp_data'] = $chk_if_contract_in_temp;
				$data['contract_data'] = '';
				
			}else{
				//Now check if teh record exst in the main governance hr table as teh record is not found in the temp table
				
				$data['contract_temp_data'] = '';
	
				$get_contract_data = $this->governance->get_user_governance_data($contract_id);
				
				if($get_contract_data){
					
					$hr_contract = stripcslashes($get_contract_data['hr_contract']);
					
					$read_time = date('G:i',strtotime(filter_string($get_contract_data['created_date'])));
					$read_date = date('d/m/y',strtotime(filter_string($get_contract_data['created_date'])));
					
					$get_contract_data['hr_contract'] = stripcslashes($hr_contract);
					
					$get_contract_data['user_full_name'] = ucwords($get_contract_data['user_full_name']);
					$data['contract_data'] = $get_contract_data;
					
				}else{
					$data['error_status'] = 1;
					$data['err_message'] = '<strong>ERROR: Invalid request, please contact site admin.</strong>';
				}//end if($get_contract_data)
					
			}//end if($chk_if_contract_in_temp)
		}else{

			$data['error_status'] = 1;
			$data['err_message'] = '<strong>ERROR: Invalid request, please contact site admin.</strong>';
			
		}//end if(trim($contract_id) != '')
		echo json_encode($data);
		
	}//end resend_hr_contract()
	
	//Function update_contract_resend_process(): Function to insert or update data into the temp table.
	public function update_contract_resend_process(){

		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		if(trim($resend_contract_id) == '' && trim($temp_contract_id) == ''){
			
		}else{
			if(trim($resend_contract_id)!= ''){
				
				$get_contract_data = $this->governance->get_user_governance_data($resend_contract_id);	
				
				if(!$get_contract_data){
					$this->session->set_flashdata('err_message', 'System have found an invalid request, please contact adminsitrator.');
					redirect(SURL.'organization/dashboard');
				}//end if(!$get_contract_data)
				
			}//end if(trim($resend_contract_id)!= '')
			if(trim($temp_contract_id)!= ''){
				
				$get_temp_contract_data = $this->governance->get_governace_hr_temp_details($temp_contract_id,'');
				
				if(!$get_temp_contract_data){
					$this->session->set_flashdata('err_message', 'System have found an invalid request, please contact adminsitrator.');
					redirect(SURL.'organization/dashboard');
				}//end if(!$get_temp_contract_data)
				
			}//end if(trim($temp_contract_id)!= '')
				
			$update_contract_in_temp = $this->governance->update_governace_hr_temp_contract($this->input->post(),$get_contract_data,$get_temp_contract_data);
			
			if($update_contract_in_temp){
				$get_user_details = $this->users->get_user_details($resend_contract_to_user_id);

				$this->session->set_flashdata('ok_message', "Your updated contract has now been resent to ".filter_string($get_user_details['user_full_name']).".");
				redirect(SURL.'organization/dashboard');
				
			}//end if($update_contract_in_temp)
			
		}//end if(trim($resend_contract_id) == '' && trim($temp_contract_id))
		
	}//end update_contract_resend_process()
	
	//Function get_renew_contract_data(): Will return the contract data to show to the users on their notification View Contract mode.
	public function get_renew_contract_data(){
		
		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		if(trim($temp_contract_id) == ''){

				$data['error_status'] = 1;
				$data['error_message'] = '<strong>Invalid request, please contract site admininstrator</strong>';
			
		}else{

			$get_temp_contract_data = $this->governance->get_governace_hr_temp_details($temp_contract_id,'');
			
			if(!$get_temp_contract_data){
				
				$data['error_status'] = 1;
				$data['error_message'] = '<strong>Invalid request, please contract site admininstrator</strong>';
				
			}else{
	
				$user_signatures = $this->users->get_user_signatures($get_temp_contract_data['user_id']);
				$user_signatures['signature_svn'] = stripcslashes($user_signatures['signature_svn']);
				
				if(filter_string($user_signatures['signature_type']) == 'svn')
					$signature_str = filter_string($user_signatures['signature']);
				elseif(filter_string($user_signatures['signature_type']) == 'image')
					$signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
				// if(filter_string($user_signatures['signature_type']) == 'svn')										
				
				$data['user_signatures'] = filter_string($user_signatures['signature']);
	
				$hr_contract_str = stripcslashes($get_temp_contract_data['hr_contract']);
				
				
				$search_arr = array('[USER_SIGNATURE]','[SIGNED_DATE_TIME]','[SURL]');
				$replace_arr = array($signature_str,'Signed at '.date('G:i').' on '.date('d/m/y').' by',SURL);
				
				$hr_contract_str = str_replace($search_arr,$replace_arr,$hr_contract_str);
	
				$get_temp_contract_data['hr_contract'] = $hr_contract_str;
				$data['temp_contract_data'] = $get_temp_contract_data;
			}//end if(!$get_temp_contract_data)
			
		}//end if(trim($temp_contract_id) == '')
		echo json_encode($data);
	}//end get_renew_contract_data()

	//Function renewal_contract_approval(): Will process teh action whatever user have selected Accept or Reject for renewal of the contract.
	public function renewal_contract_approval($temp_contract_id,$contract_status){
		
		if(trim($temp_contract_id) == '' || trim($contract_status) == ''){
			
			$this->session->set_flashdata('err_message', 'Invalid Request, please contact site admin.');
			redirect(SURL.'dashboard');
			
		}else{
			
			$get_temp_contract_data = $this->governance->get_governace_hr_temp_details(trim($temp_contract_id),'');

			if(!$get_temp_contract_data){
				
				$this->session->set_flashdata('err_message', 'Invalid Request, please contact site admin.');
				redirect(SURL.'dashboard');
				
			}else{

				$process_renew_contract = $this->governance->update_renewal_contract($get_temp_contract_data,$contract_status);
				
				if($process_renew_contract){

					$this->session->set_flashdata('ok_message', 'Your request is successfully sent.');
					redirect(SURL.'dashboard');
					
				}else{
					
					$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
					redirect(SURL.'dashboard');
					
				}//end if($process_renew_contract)
				
			}//end if($get_temp_contract_data)
			
		}//end if(trim($temp_contract_id) == '' || trim($contract_status) != '')
		
	}//end renewal_contract_approval($temp_contract_id,$contract_status)
	
	//Function renew_contract_changes_process(); Will send the requested changes of contract to OSP back This done by user.
	public function renew_contract_changes_process(){
		
		extract($this->input->post());

		if(!$this->input->post()) redirect(SURL.'dashboard');

		$get_temp_contract_data = $this->governance->get_governace_hr_temp_details(trim($renew_temp_contract_id),'');
		
		if(!$renew_temp_contract_id)
			redirect(SURL.'dashboard');
		else{
			$update_temp_contract = $this->governance->update_temp_contract_for_changes($this->input->post());
			
			if($update_temp_contract){
				$this->session->set_flashdata('ok_message', 'A request has been sent to your organisation lead to change your contract. This may take a few days to process. Once processed this message will be replaced, click "View Contract" again and you will see your new updated contract.');
				redirect(SURL.'dashboard');
				
			}else{
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect(SURL.'dashboard');
				
			}//end if($temp_contract_id)

		}//end if(!$get_invitation_data)
		
	}//end renew_contract_changes_process()
	

	//Function update_invitation_contract(): This will open the popup window with the data of contract changes from invitation table
	public function update_invitation_contract(){
		
		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		$get_invitation_data = $this->invitations->get_invitation_details($invitation_id);
		$get_invitation_data['hr_contract'] = stripcslashes($get_invitation_data['hr_contract']);
		$data['invitation_data'] = $get_invitation_data;

		echo json_encode($data);
		
	}//end update_invitation_contract()
	
	public function update_invitation_contract_process(){
		
		if(!$this->input->post()) redirect(SURL.'dashboard');
		extract($this->input->post());
		
		$get_invitation_data = $this->invitations->get_invitation_details($invitation_id);
		
		if(!$get_invitation_data)
			redirect(SURL.'dashboard');
		else{

			$update_invitation = $this->invitations->update_invitation_for_contract_osp($this->input->post());
			
			if($update_invitation){
				$this->session->set_flashdata('ok_message', 'Your request is successfully sent.');
				redirect(SURL.'organization/dashboard');
				
			}else{
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				redirect(SURL.'organization/dashboard');
				
			}//end if($update_invitation)
			
		}//end if(!$get_invitation_data)
		
	}//end update_invitation_contract_process()

    // Start - public function push_invitation()
    // Function to send invite to Manager And Staff [ for now ] and SI
    public function push_invitation(){

        if(!$this->input->post()) redirect(SURL);

        extract( $this->input->post() );

        //////// POST DATA ////////
        // $invitation_sent_to_arr = User Email - User Info from DB
        // $invitation_method = 'D' OR 'E'
        // $organization_id = ...
        // $pharmacy_surgery_id = ...
        // $invitation_for = 'DO' - 'P' - 'NU' .....

        if($invitation_method == 'D'){

            $user_id = $invitation_sent_to_arr; // Contains User ID

            $this->db->dbprefix('users');
            $this->db->where('id', $user_id);

            $user = $this->db->get('users')->row_array();

        } // if($invitation_method == 'D')

        if($no_contract && $no_contract == 1){

            $this->load->model('email_mod','email_template');
            $email_body_arr = $this->email_template->get_email_template(18);
            $governance_hr_text = $email_body_arr['email_body'];

        } // if($no_contract && $no_contract == 1)

        $push_invitation_id = $this->invitations->push_invitation($this->session->id, $invitation_sent_to_arr, $organization_id, $pharmacy_surgery_id, $invitation_for, $invitation_method, $governance_hr_text, $no_contract);

        if($push_invitation_id){

            $data['error_status'] = 0;
            $data['success_status'] = 1;
            $data['invitation_id'] = $push_invitation_id;
            $data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
            $data['invitation_method'] = $invitation_method;
            
            if($user && $user['email_address'])
                $data['email_address'] = $user['email_address'];
            else
                $data['email_address'] = $invitation_sent_to_arr;

            $data['invitation_for'] = $invitation_for;

            if($invitation_for == 'SI'){

                $this->stencil->layout('ajax'); //ajax
                $ajax_response = $this->load->view('invitations/invitation_ajax.php',$data,true);

                $data['response'] = $ajax_response;

            } // if($invitation_for == 'SI')

        } // if($push_invitation_id):

        // Send response to ajax call
        echo json_encode($data);

    } // public function push_invitation()

    // Start - resend_staff_invite()
    public function resend_staff_invite(){

        if( !$this->input->post() && !$this->input->post('invitation_id') ) redirect(SURL.'dashboard');

        extract( $this->input->post() );

        $inv_data = $this->invitations->get_invitation_details($invitation_id);

        if($inv_data){

            $deleted = $this->invitations->delete_invitation($invitation_id);

            if($deleted){

                if($inv_data['invitation_sent_to'] == ''){

                    $invitation_method = 'E';
                    $user_data['email_address'] = $inv_data['email_address'];

                } else {

                    $invitation_method = 'D';
                    $user = $this->users->get_user_details($inv_data['invitation_sent_to']);
                    $user_data['id'] = $inv_data['invitation_sent_to'];
                    $user_data['first_name'] = $user['first_name'];
                    $user_data['last_name'] = $user['last_name'];

                } // else if($inv_data['invitation_sent_to'] == '')

                $push_invitation_id = $this->invitations->push_invitation($this->session->id, $user_data, $inv_data['organization_id'], $inv_data['pharmacy_id'], $inv_data['invitation_type'], $invitation_method, $inv_data['hr_contract'], $inv_data['no_contract']);
                if($push_invitation_id){

                    $data['error_status'] = 0;
                    $data['success_status'] = 1;
                    $data['invitation_id'] = $push_invitation_id;

                } // if($push_invitation_id):

            } // if($deleted)

        } // if(!empty($inv_data))

        echo json_encode($data);

    } // End - resend_staff_invite()

    // Start - elect_self(): Manager and Staff
    public function elect_self(){
    
        if( !$this->input->post() && !$this->input->post('pharmacy_surgery_id') ) redirect(SURL.'dashboard');

        if($this->input->post('no_contract') && $this->input->post('no_contract') == 1){

            $this->load->model('email_mod','email_template');
            $email_body_arr = $this->email_template->get_email_template(18);
            $governance_hr = $email_body_arr['email_body'];

        } else {
            $governance_hr = $this->input->post('governance_hr');
        } // if($this->input->post('no_contract') && $this->input->post('no_contract') == 1)

        if($this->input->post('elect_self_as') && $this->input->post('elect_self_as') == 'ST'){
        
            // if organization id empty for 
            if($this->my_organization_id == ""){
                
                $pharmacy_id =  $this->pharmacy->get_pharmacy_surgery_details($this->input->post('pharmacy_surgery_id'));
                $my_organization_id = $pharmacy_id['organization_id'];
            } else {
                $my_organization_id = $this->my_organization_id;
            } // if($this->my_organization_id == "")

            $elected = $this->organization->elect_self($this->session->id, $this->session->user_type, $this->input->post('pharmacy_surgery_id'), $my_organization_id, 'ST', $this->user_org_superintendent, $this->session->is_owner, $governance_hr );
            
            if($elected == 'elected'){
                // prepare response on success : return manager all data
                $response = array('success' => true, 'message' => "Elected");
            } else {
                // prepare response : return success false
                $response = array('success' => false, 'message' => "Already elected");
            } // if($elected)

        } else if($this->input->post('elect_self_as') && $this->input->post('elect_self_as') == 'M'){
        
            $elected = $this->organization->elect_self( $this->session->id, $this->session->user_type, $this->input->post('pharmacy_surgery_id'), '', 'M', $this->user_org_superintendent, $this->session->is_owner, $governance_hr );
            if($elected){
                // prepare response on success : return manager all data
                $response = array('success' => true, 'manager_data' => $elected);
            } else {
                // prepare response : return success false
                $response = array('success' => false, 'manager_data' => 'Already elected');
            } // if($elected)

        } // elseif($this->input->post('elect_self_as') && $this->input->post('elect_self_as') == 'M')

        // send response to ajax call
        echo json_encode($response);
        
    } // End - elect_self():

    //Edit Governance, for organization owner and SI
    public function edit_governance(){
        
        // Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('Edit Governance', base_url().' edit-governance');
		
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){

            //is Owner or SI, so valid to see this page.

            $get_organization_governance_arr = $this->governance->get_org_governance_details('',$this->my_organization_id);
            $data['organization_governance_arr'] = $get_organization_governance_arr;

            $get_organization_sop_list = $this->governance->get_organization_sop_tree($this->my_organization_id);
            $data['organization_sop_list'] = $get_organization_sop_list;
			
			$get_sop_none_category_detail = $this->governance->get_sop_none_category_details($this->my_organization_id);
			$data['sop_none_category_detail'] = $get_sop_none_category_detail;

            //$get_organization_hr_arr = $this->governance->get_organization_hr_details('',$this->my_organization_id,'','');
            //$data['organization_hr_arr'] = $get_organization_hr_arr;

            $this->stencil->layout('dashboard_template'); //dashboard_template

            //set title
            //$page_title = $page_data['page_title'];
           	//set title
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));

            //Tree View Script
            $this->stencil->js('bootstrap-treeview.js');


            //Editor Files
            $this->stencil->js('tinymce/tinymce.min.js');

            //Fancy Box Files
            $this->stencil->css('jquery.fancybox.css');
            $this->stencil->js('jquery.fancybox.js');
            $this->stencil->js('jquery.mousewheel-3.0.6.pack.js');
            $this->stencil->js('org_dashboard.js');
        
            //load Paint
            $this->stencil->paint('organization/edit_governance',$data);

        }else{
			$this->session->sop_tab = 1;
            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');

        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)


    }//end edit_governance()

    public function edit_governance_process(){

        if( !$this->input->post() && !$this->input->post('update_governance_btn') ) redirect(SURL.'dashboard');
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            extract($this->input->post());
    
            $update_governance = $this->governance->edit_organization_governance($this->my_organization_id,$this->input->post());
    
            if($update_governance){
    
                $this->session->set_flashdata('ok_message', 'Governance updated successfully.');
                redirect(SURL.'organization/edit-governance');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'organization/edit-governance');
    
            }//end if($update_governance)

        }else{
            
            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end edit_governance_process()

	//Function public function add/ edit SOP Catgeory of an Organization 
	public function edit_sop_category($category_id = ''){

        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
			
			if($category_id != ''){
				
				$get_category_data = $this->governance->get_sop_category_details($this->my_organization_id,$category_id);
				
				if(!$get_category_data)
					exit('Invalid data');
				else
					$data['get_category_data'] = $get_category_data;

			}//end if($category_id != '')
            
            //$this->stencil->js('org_dashboard.js');
            
            //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
            $this->stencil->paint('organization/add_edit_sop_category',$data);
    
        }else{

            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end edit_sop_category($sop_id)

    public function edit_sop_category_process(){

        if( !$this->input->post() && !$this->input->post('update_category_btn') ) redirect(SURL.'dashboard');
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            extract($this->input->post());
			
            $update_sop_category = $this->governance->add_edit_sop_category($this->input->post());
			
            if($update_sop_category){

				if($category_id)
	                $this->session->set_flashdata('ok_message', 'Folder updated successfully.');
				else
					$this->session->set_flashdata('ok_message', 'Folder added successfully.');
				
				redirect(SURL.'organization/edit-governance');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'organization/edit-governance');
    
            }//end if($update_governance)

        }else{

            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end edit_sop_category_process()

	//Function public function edit_organization_sop($sop_id)
	public function edit_organization_sop($category_id, $sop_id = ''){

        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            //Active User Type List
            $usertype_active_arr = $this->usertype->get_active_usertypes();
            $data['usertype_active_arr'] = $usertype_active_arr;

            //SOP Category Lists
            $get_sop_category_list = $this->governance->get_organization_sop_categories($this->my_organization_id);
            $data['sop_category_list'] = $get_sop_category_list;

            if($sop_id !=''){
                
                //Loading SOP details
                $sop_detail_arr = $this->governance->get_organization_sop_details($sop_id);
            
                //If the course does not found, redirect to 404 page
                if(!$sop_detail_arr)
                    redirect(base_url().'errors/page-not-found-404');
                else
                    $data['sop_detail_arr'] = $sop_detail_arr;
    
                //end if(!$pgd_detail_arr)
                
            }else{
                $data['add_new_sop'] = 0;
            }//end if($sop_id != 0)
            
			$data['sop_category_id'] = $category_id;
    
           // $this->stencil->js('org_dashboard.js');
            
            //load main template
            $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
            $this->stencil->paint('organization/edit_organization_sop',$data);
    
        }else{

            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end edit_organization_sop($sop_id)

    public function edit_organization_sop_process(){

        if( !$this->input->post() && !$this->input->post('update_sop_btn') ) redirect(SURL.'dashboard');
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            extract($this->input->post());
    
            $update_organization_sop = $this->governance->edit_organization_sop($this->input->post());
    
            if($update_organization_sop){
    
                $this->session->set_flashdata('ok_message', 'SOP File updated successfully.');
                redirect(SURL.'organization/edit-governance');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'organization/edit-governance');
    
            }//end if($update_governance)

        }else{

            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end edit_organization_sop_process()

    //Function: function delete_organization_sop(): Delete the selected SOP of an Organization
    public function delete_organization_sop($sop_id){
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){

            //Loading SOP details
            $sop_detail_arr = $this->governance->get_organization_sop_details($sop_id);
        
            //If the course does not found, redirect to 404 page
            if(!$sop_detail_arr){
                redirect(base_url().'errors/page-not-found-404');
                
            }else{
                
                $delete_organization_sop = $this->governance->delete_organization_sop($this->my_organization_id, $sop_id);
                
                if($delete_organization_sop){
    
                    $this->session->set_flashdata('ok_message', 'File deleted successfully.');
                    redirect(SURL.'organization/edit-governance');
                    
                }else
                    redirect(base_url().'errors/page-not-found-404');
    
            }//end if(!$pgd_detail_arr)
                
        }else{
            redirect(base_url().'errors/page-not-found-404');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)
        
    }//end delete_organization_sop($sop_id)

    //Function: function delete_organization_sop
    public function delete_organization_sop_category($category_id){
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){

            //Loading SOP details
            $sop_category_detail_arr = $this->governance->get_organization_sop_categories($this->my_organization_id, $category_id);

            //If the course does not found, redirect to 404 page
            if(!$sop_category_detail_arr){
                redirect(base_url().'errors/page-not-found-404');
                
            }else{
                
                $delete_organization_sop_category = $this->governance->delete_organization_sop_category($this->my_organization_id, $category_id);
                
                if($delete_organization_sop_category){
    
                    $this->session->set_flashdata('ok_message', 'SOP Category deleted successfully.');
                    redirect(SURL.'organization/edit-governance');
                    
                }else
                    redirect(base_url().'errors/page-not-found-404');
    
            }//end if(!$pgd_detail_arr)
                
        }else{
            redirect(base_url().'errors/page-not-found-404');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)
        
    }//end delete_organdelete_organization_sop_categoryization_sop($sop_id)

    //Reset or mark the SOP read as UNREAD of an organization
    public function enforce_reading_sop($sop_id){
        
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            $get_sop_details = $this->governance->get_organization_sop_details($sop_id);
    
            if(!$get_sop_details && $this->my_organization_id != $get_sop_details['organization_id'])
                redirect(SURL.'organization/dashboard');
    
            $enforce_sop_reading = $this->governance->enforce_organization_sop_reading($this->my_organization_id,$sop_id);
    
            if($enforce_sop_reading){
    
                $this->session->set_flashdata('ok_message', 'Settings applied on all Pharmacies.');
                redirect(SURL.'organization/edit-governance');
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'organization/edit-governance');
    
            }//end if($enforce_reading_governance)

        }else{

            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end enforce_reading_sop($sop_id)

    //SOP Read and Sign Popup View, PharmacyID will be optional which will be used for the governance of a Pharmacy
    public function read_and_sign_sop($sop_id,$pharmacy_surgery_id=''){

        $get_organization_sop_detail = $this->governance->get_organization_sop_details($sop_id);
		
        if(!$get_organization_sop_detail)
            exit('Invalid Access');

		$already_sop_read = $this->governance->get_organization_sop_read_details($this->session->id,$sop_id,$get_organization_sop_detail['organization_id'],$pharmacy_surgery_id);

        // Check if SOP already read
        if(!$already_sop_read){
            
            if(!$this->session->is_owner){ // If the user is not owner then can be [ SI - M - ST ]
            
                // Get User role(s) in the pharmacy / surgery [ By pharmacy_surgery_id ]
                $user_role = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $pharmacy_surgery_id);
				
				if($user_role['is_staff'] == 1)
					$my_user_role = 'ST';

				if($user_role['is_manager'] == 1)
					$my_user_role = 'M';

				if($user_role['is_si'] == 1)
					$my_user_role = 'SI';
				
                if($user_role['is_manager'] == 0 && $user_role['is_staff'] == 0){
                    
                    // If the user in not the [ M - ST ] then must be the SI
                    
                    $user_role['is_si'] = 1;
                    $pharmacy_surgery_id = NULL; // In case of SI
                    
                } // if($user_role['is_manager'] == 0 && $user_role['is_staff'] == 0)
                    
            } else {
                // If user is the owner then make entry as SI
                $user_role = 'SI';
            } // if(!$this->session->is_owner)

            // Database Entry for Mark SOP as read against role(s) [ could be - M - SI - ST || array('is_manager' => 1, 'is_staff' => 1) ]
            $mark_sop_as_read = $this->governance->mark_organization_sop_read($this->session->id,$pharmacy_surgery_id,$get_organization_sop_detail, $this->user_org_superintendent, $user_role,'1','0');
			
        }//end if(!$already_sop_read)
        
		$data['organization_sop_detail'] = $get_organization_sop_detail;
        $data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
        $data['user_signatures'] = $this->users->get_user_signatures($this->session->id);
		
        $this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
        //load Paint
        $this->stencil->paint('organization/sop_read_and_sign',$data);

    }//end read_and_sign_sop($sop_id)

    //To Mark SOP as READ by the User!
    public function read_and_sign_sop_process(){
		

        if(!$this->input->post() && !$this->input->post('sop_id')) redirect(base_url());

        extract($this->input->post());
		
        $get_organization_sop_detail = $this->governance->get_organization_sop_details($sop_id);

        if(!$get_organization_sop_detail)
            redirect(SURL.'organization/dashboard');

	        $already_sop_read = $this->governance->get_organization_sop_read_details($this->session->id,$sop_id,$get_organization_sop_detail['organization_id'],$pharmacy_surgery_id);

        // Check if SOP already read   means thers shoould be a record in a database with is_read = 1
        if($already_sop_read){
            
            if(!$this->session->is_owner){ // If the user is not owner then can be [ SI - M - ST ]
            
                // Get User role(s) in the pharmacy / surgery [ By pharmacy_surgery_id ]
                $user_role = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $pharmacy_surgery_id);
				
				if($user_role['is_staff'] == 1)
					$my_user_role = 'ST';

				if($user_role['is_manager'] == 1)
					$my_user_role = 'M';

				if($user_role['is_si'] == 1)
					$my_user_role = 'SI';
				
                if($user_role['is_manager'] == 0 && $user_role['is_staff'] == 0){
                    
                    // If the user in not the [ M - ST ] then must be the SI
                    
                    $user_role['is_si'] = 1;
                    $pharmacy_surgery_id = NULL; // In case of SI
                    
                } // if($user_role['is_manager'] == 0 && $user_role['is_staff'] == 0)
                    
            } else {
                // If user is the owner then make entry as SI
                $user_role = 'SI';
            } // if(!$this->session->is_owner)

            // Database Entry for Mark SOP as read against role(s) [ could be - M - SI - ST || array('is_manager' => 1, 'is_staff' => 1) ]
            $mark_sop_as_read = $this->governance->mark_organization_sop_read($this->session->id,$pharmacy_surgery_id,$get_organization_sop_detail, $this->user_org_superintendent, $user_role, '1','1');
			
        }//end if(!$already_sop_read)
		
		$is_all_sop_read = $this->governance->is_governance_read_by_user($this->session->id, $get_organization_sop_detail['organization_id'], $pharmacy_surgery_id, $my_user_role, $this->session->user_type);
		
		$data['read_all_sop'] = ($is_all_sop_read) ? 1 : 0;
		$data['success'] = 1;
		echo json_encode($data);

    }//end read_and_sign_sop_process()

    //This will Create a PDF for the SOP to download for users.
    function download_read_and_signed_sop($sop_id,$pharmacy_surgery_id=''){

        $get_organization_sop_detail = $this->governance->get_organization_sop_details($sop_id);

        if(!$get_organization_sop_detail){
            redirect(SURL.'organization/dashboard');
        }else{
            //Verify If the SOP is still READ
            $chek_if_sop_read = $this->governance->get_organization_sop_read_details($this->session->id, $sop_id,$get_organization_sop_detail['organization_id'], $pharmacy_surgery_id);
			
            if($chek_if_sop_read){

                $prepare_sop_pdf = $this->governance->download_sop_signed_pdf($this->session->id,$sop_id,$pharmacy_surgery_id,$get_organization_sop_detail,$chek_if_sop_read);

            }else{

                $this->session->set_flashdata('err_message', 'You have to read the SOP again to download.');
                redirect(SURL.'organization/dashboard');

            }//end if($chek_if_sop_read)

        }//end if(!$get_organization_sop_detail)

    }//end download_read_and_signed_sop($sop_id,$pharmacy_surgery_id='')

    //To Mark HR as READ by the User!
    public function read_and_sign_hr_process(){

        if(!$this->input->post() && !$this->input->post('org_id')) redirect(base_url());

        extract($this->input->post());

        $check_if_org_governance_exist = $this->governance->get_org_governance_details('',$org_id);

        if(!$check_if_org_governance_exist)
            redirect(SURL.'organization/dashboard');

        $mark_organization_hr_read = $this->governance->mark_organization_hr_read($this->session->id,$pharmacy_surgery_id,$check_if_org_governance_exist, $this->user_org_superintendent);
            
        return true;

    }//end read_and_sign_hr_process()

    //This will Create a PDF for the HR to download for users.
    function download_read_and_signed_hr($organization_id,$user_type,$pharmacy_surgery_id=''){

        $check_if_org_governance_exist = $this->governance->get_org_governance_details('',$organization_id);
        
        if(!$check_if_org_governance_exist){
            redirect(SURL.'organization/dashboard');
        }else{
            //Verify If the HR Read record available in the Database against the user and ORG and PHARMACY
            $chek_if_hr_read_found = $this->governance->get_user_governance_read_status($this->session->id,$organization_id,$pharmacy_surgery_id);
            
            if($chek_if_hr_read_found){
                
                if($user_type != ''){

                    if($user_type != 'SI')
                        $user_type = $this->session->user_type;	
                    else
                        $user_type = 'NULL';	
                        
                }else{
                    $user_type = $this->session->user_type;		
                }//end if($user_type != '')
                
                $prepare_hr_pdf = $this->governance->download_hr_signed_pdf($this->session->id,$organization_id,$user_type);

            }else{

                $this->session->set_flashdata('err_message', 'You have to read the HR again to download.');
                redirect(SURL.'organization/dashboard');

            } //end if($chek_if_sop_read)

        }//end if(!$get_organization_sop_detail)

    }//end download_read_and_signed_hr($organization_id)

    // Start - public function download_hr() : Function to download HR-TEXT
    public function download_hr(){

        if(!$this->input->post()) redirect(SURL.'dashboard');
		
		extract($this->input->post());

        if($this->input->post('hr_html') && $this->input->post('hr_html') != ''){
			
            $file_name = 'HR Contract.pdf';
            
            $html = $this->input->post('hr_html');
            
            $user_signatures = $this->users->get_user_signatures($this->session->id);
			
            if(filter_string($user_signatures['signature_type']) == 'svn')
                $signature_str = filter_string($user_signatures['signature']);
            elseif(filter_string($user_signatures['signature_type']) == 'image')
                $signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
            // if(filter_string($user_signatures['signature_type']) == 'svn')                                       

            $search_arr = array('[USER_SIGNATURE]','[SURL]');
            $replace_arr = array($signature_str,SURL);
            $html = str_replace($search_arr,$replace_arr,$html);
			$html = '<style>.main-font {font-family:Arial, Helvetica, sans-serif;}table{font-family:Arial, Helvetica, sans-serif;}</style><div class="main-font">'.$html.'</div>';

			$user_governance_read_data = $this->governance->get_user_governance_data($contract_id);	
			
			$html .= '<pagebreak [ P ] /><div style="border:solid 1px #ccc; float: left; width:100%"><div style="float:left; width:100%; padding:10px; background-color: #D9EDF7"><table cellpadding="2" cellspacing="10" width="100%">
	<tbody>
		<tr>
			<td style="padding:10px"><img src="'.IMAGES.'fa-share.png" width="30" /></td>
			<td style="padding:10px"><strong>'.uk_date_format($user_governance_read_data['hr_contract_sent_date']).'</strong><br />
			'.uk_date_format($user_governance_read_data['hr_contract_sent_date'],true).'</td>
			<td style="padding:10px">Sent for signature to <strong>'.filter_name($user_governance_read_data['sent_to_f_name'].' '.$user_governance_read_data['sent_to_l_name']).'</strong> ('.filter_string($user_governance_read_data['email_address']).')<br />
			<strong>IP:</strong> '.filter_string($user_governance_read_data['hr_contract_sent_by_ip']).'</td>
		</tr>
		<tr>
			<td style="padding:10px"><img src="'.IMAGES.'/fa-eye.png" width="30" /></td>
			<td style="padding:10px"><strong>'.uk_date_format($user_governance_read_data['hr_contract_viewed_date']).'</strong><br />
			'.uk_date_format($user_governance_read_data['hr_contract_viewed_date'],true).'</td>
			
			<td style="padding:10px">Viewed by <strong>'.filter_name($user_governance_read_data['sent_to_f_name'].' '.$user_governance_read_data['sent_to_l_name']).'</strong> ('.filter_string($user_governance_read_data['email_address']).')<br />
			<strong>IP:</strong> '.filter_string($user_governance_read_data['hr_contract_viewed_ip']).'</td>
		</tr>
		<tr>
			<td style="padding:10px"><img src="'.IMAGES.'fa-signature.png" width="30" /></td>
			<td style="padding:10px"><strong>'.uk_date_format($user_governance_read_data['created_date']).'</strong><br />
			'.uk_date_format($user_governance_read_data['created_date'],true).'</td>
			<td style="padding:10px">Signed by <strong>'.filter_name($user_governance_read_data['sent_to_f_name'].' '.$user_governance_read_data['sent_to_l_name']).'</strong> ('.filter_string($user_governance_read_data['email_address']).')<br />
			<strong>IP:</strong> '.filter_string($user_governance_read_data['created_by_ip']).'</td>
		</tr>
		<tr>
			<td style="padding:10px"><img src="'.IMAGES.'fa-check.png" width="30" /></td>
			<td style="padding:10px"><strong>'.uk_date_format($user_governance_read_data['created_date']).' </strong><br />
			'.uk_date_format($user_governance_read_data['created_date'],true).'</td>
			<td style="padding:10px">The document has been completed.</td>
		</tr>
	<tr>
		<td style="padding:10px"><img src="'.IMAGES.'fa-user-id.png" width="30" /></td>
		<td style="padding:10px"><strong> Unique ID</strong></td>
		<td style="padding:10px">'.$user_governance_read_data['view_code'].'</td>
	</tr>
		
	</tbody>
</table></div>';


			$html .= '
			<div style="float:left; width:100%" class="main-font">
				<div style="text-align:justify; width:70%; float:left; padding:10px 10x; color:#A3A3A3; font-size:12px;" >I have read and understood the contents of this Standard Operating Procedure; I have been appropriately trained to undergo the duties required of me; I have had the chance to ask questions to the clinical governance lead. I confirm that I will ensure that I remain up to date in all aspects of carrying out the duties listed in this Standard Operating Procedure.</div>
				<div style="text-align:right; width:20%; float:left">'.$signature_str.'</div>
			</div> </div>';

            $this->load->library('pdf');
            $pdf = $this->pdf->load();

            $pdf->AddPage('L'); // L - P

            $pdf->WriteHTML($html); // write the HTML into the PDF
            
            $pdf->Output($file_name); // save to file because we can

        }//end

    } // End - public function download_hr()

    //This will show the governance passed for download/ read and view for SI and Owner
    public function my_governance(){

        if($this->allowed_user_menu['show_view_governance']){
            //Governance Passed
    
            //set title
            //$page_title = $page_data['page_title'];
          	//set title
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));
			
			if($this->session->is_owner || $this->user_org_superintendent){
				
	            $organization_id = $this->my_organization_id;

				//User have not passed the Governance so pick the govnernace/ sop/ hr records from the database
				//$get_organization_governance_arr = $this->governance->get_org_governance_details('',$organization_id);
				//$data['organization_governance_arr'] = $get_organization_governance_arr;
				
				//If user is a SI, get the HR	
				//$get_organization_hr_document = $this->governance->get_organization_hr_details('',$organization_id,'NULL','');
				//$data['organization_hr_document'] = $get_organization_hr_document;
				
				$get_organization_sop_list = $this->governance->get_organization_sop_tree($organization_id,$this->session->user_type);
				$data['organization_sop_list'] = $get_organization_sop_list;
	
				$get_user_sop_read_list = $this->governance->get_user_sop_read_list($this->session->id,$organization_id, '');
				$data['user_sop_read_list'] = $get_user_sop_read_list;

				$get_user_governance_read_data = $this->governance->get_user_governance_read_status($this->session->id,$organization_id,'','SI');
				$data['user_governance_read_data'] = $get_user_governance_read_data;				

			}else{

				//User have not passed the Governance so pick the govnernace/ sop/ hr records from the database
				//$get_organization_governance_arr = $this->governance->get_org_governance_details('',$organization_id);
				//$data['organization_governance_arr'] = $get_organization_governance_arr;
				
				//If user is a SI, get the HR	
				//$get_organization_hr_document = $this->governance->get_organization_hr_details('',$organization_id,'NULL','');
				//$data['organization_hr_document'] = $get_organization_hr_document;

				$get_organization_sop_list = $this->governance->get_organization_sop_tree($this->session->organization_id,$this->session->user_type);
				$data['organization_sop_list'] = $get_organization_sop_list;

				$my_role_in_pharmacy_surgery_data = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $this->session->pharmacy_surgery_id); // Get User role in the pharmacy / surgery [ By pharmacy_surgery_id ]				
				
				if($my_role_in_pharmacy_surgery_data['is_staff'] == 1)
					$my_role = 'ST';	
				//end if($my_role_in_pharmacy_surgery_data['is_manager'])

				//Manager Superceeds ST as Manager SOP is different
				if($my_role_in_pharmacy_surgery_data['is_manager'] == 1)
					$my_role = 'M';	
				//end if($my_role_in_pharmacy_surgery_data['is_manager'])

				$get_user_sop_read_list = $this->governance->get_user_sop_read_list($this->session->id,$this->session->organization_id, $this->session->pharmacy_surgery_id,$my_role);
				$data['user_sop_read_list'] = $get_user_sop_read_list;
	
				$get_user_governance_read_data = $this->governance->get_user_governance_read_status($this->session->id,$this->session->organization_id,$this->session->pharmacy_surgery_id,$my_role);
				
				$data['user_governance_read_data'] = $get_user_governance_read_data;				

			}//end if($this->session->is_owner || $this->user_org_superintendent)

            $data['user_signatures'] = $this->users->get_user_signatures($this->session->id);

            $data['request'] = $this->uri->segment(3);

			//Tree View Script
			$this->stencil->js('bootstrap-treeview.js');
            $this->stencil->js('org_dashboard.js');

            //Fancy Box Files
            $this->stencil->css('jquery.fancybox.css');
            $this->stencil->js('jquery.fancybox.js');

            //load main Dashbaord template for DOCTOR
            $this->stencil->layout('dashboard_template'); //dashboard_template
            
            $this->stencil->paint('organization/my_governance',$data);
                
        }else{
            //Governance not Passed
            redirect(SURL.'organization/dashboard');
        }
        
    }//end my_governance()
	
	public function view_contract(){
		
		
		// Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('View Contract', base_url().'organization/dashboard');
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		//set title
		//$page_title = $page_data['page_title'];
		//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
		
		if($this->session->is_owner || $this->user_org_superintendent){
			
			$organization_id = $this->my_organization_id;

			$get_user_governance_read_data = $this->governance->get_user_governance_read_status($this->session->id,$organization_id,'','SI');
			$data['user_governance_read_data'] = $get_user_governance_read_data;				

		}else{


			$my_role_in_pharmacy_surgery_data = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $this->session->pharmacy_surgery_id); // Get User role in the pharmacy / surgery [ By pharmacy_surgery_id ]				
			
			if($my_role_in_pharmacy_surgery_data['is_staff'] == 1)
				$my_role = 'ST';	
			//end if($my_role_in_pharmacy_surgery_data['is_manager'])

			//Manager Superceeds ST as Manager SOP is different
			if($my_role_in_pharmacy_surgery_data['is_manager'] == 1)
				$my_role = 'M';	
			//end if($my_role_in_pharmacy_surgery_data['is_manager'])

			$get_user_governance_read_data = $this->governance->get_user_governance_read_status($this->session->id,$this->session->organization_id,$this->session->pharmacy_surgery_id,$my_role);
			
			$get_user_governance_read_data['hr_contract'] = str_replace('[SURL]',SURL,$get_user_governance_read_data['hr_contract']);
			
			$data['user_governance_read_data'] = $get_user_governance_read_data;				

		}//end if($this->session->is_owner || $this->user_org_superintendent)

		$data['user_signatures'] = $this->users->get_user_signatures($this->session->id);

        //load main Dashbaord template for DOCTOR
		$this->stencil->layout('dashboard_template'); //dashboard_template
		
        //Fancy Box Files
        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');

        $this->stencil->js('org_dashboard.js');

		$this->stencil->paint('organization/my_contract',$data);
        
        
    }//end view_contract()
	
 	/*   
    public function organization_products(){
        
       
	   	 // Bread crumb 
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 $this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 $this->breadcrumbcomponent->add('Organization Products', base_url().'organization-products');
		 
		 // Bread crumb output
		 $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
			

	    if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
			
			            
            //Get Governance Package Record
            $get_governance_package_list = $this->governance->get_governance_package(1);
            $data['governance_package_list'] = $get_governance_package_list;
            
            //Get List of Pharmacies whose Governance are NOT PURCHASED by Organization or SI.
            $get_governance_non_purchased_pharmacies = $this->governance->get_governance_purchased_pharmacies($this->my_organization_id,'NP');
            $data['governance_non_purchased_pharmacies'] = $get_governance_non_purchased_pharmacies;
            
            //Get List of Pharmacies whose Governance are PURCHASED by Organization or SI.
            ## Purchased list coming from MY CONTROLLER


            //Get Survey Package Record
            $get_survey_package_list = $this->survey->get_survey_package(1);
            $data['survey_package_list'] = $get_survey_package_list;
            
            //Get List of Pharmacies whose Survey are NOT PURCHASED by Organization or SI.
            $get_survey_non_purchased_pharmacies = $this->survey->get_survey_purchased_pharmacies($this->my_organization_id,'NP');
            $data['survey_non_purchased_pharmacies'] = $get_survey_non_purchased_pharmacies;
            
            //Get List of Pharmacies whose Survey are PURCHASED by Organization or SI.
            ## Purchased list coming from MY CONTROLLER

            $this->stencil->layout('dashboard_template'); //dashboard_template
    
            //set title
            //$page_title = $page_data['page_title'];
            	//set title
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));
    
            //load main Dashbaord template for DOCTOR
            $this->stencil->paint('organization/organization_products',$data);
    
        }else{

            $this->session->set_flashdata('err_message', 'Unauthorized access.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)

    }//end organization_products()
    */
	
    //Function governance_checkout()
    public function governance_checkout(){
		
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            if(!$this->input->post() && !$this->input->post('gov_purchase_btn')) redirect(base_url());
            
            extract($this->input->post());
            $no_of_products = count($pharm_gov_chk);
            if($no_of_products > 0){

                $to_buy = array(
                    'desc' => 'Voyager Medical Governance Purchase inc VAT', 
                    'currency' => CURRENCY, 
                    'type' => PAYMENT_METHOD, 
                    'return_URL' => SURL.'organization/checkout-success/'.$no_of_products, 
                    // see below have a function for this -- function back()
                    // whatever you use, make sure the URL is live and can process
                    // the next steps
                    'cancel_URL' => SURL.'organization/settings', // this goes to this controllers index()
                    'shipping_amount' => 0.00, 
                    'get_shipping' => false
                );

                $get_governance_package = $this->governance->get_governance_package(1);
                $governance_purchase_price = filter_price($get_governance_package['price']); //Purchase price per pharmacy
                
                // Iterating through the content of your shopping cart.
                for($i=0;$i<count($pharm_gov_chk);$i++){
                    
                    $sub_total+=$governance_purchase_price;
                    
                    $get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharm_gov_chk[$i]);
                    $product_title = 'Governance Purchase for "'.filter_string($get_pharmacy_details['pharmacy_surgery_name']).'"';
                    
                    $temp_product = array(
                        'name' => $product_title,
                        'desc' => 'GOVERNANCE', 
                        'number' => 'G_'.filter_string($get_pharmacy_details['id']), 
                        'quantity' => 1, 
                        'amount' => $governance_purchase_price);
                        
                    // add product to main $to_buy array
                    $to_buy['products'][] = $temp_product;
                    
                }//end for($i=0;$i<count($pharm_gov_chk);$i++)
                
                $VAT_PERCENTAGE = 'VAT_PERCENTAGE';
                $vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
        
                $vat_amount = (trim($vat_percentage['setting_value']) / 100) * $sub_total;
                $vat_amount = filter_price($vat_amount);
                
                $to_buy['tax_amount'] = $vat_amount;
                
                // enquire Paypal API for token
                $set_ec_return = $this->paypal_ec->set_ec($to_buy);
                
                if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
                    // redirect to Paypal
                    $this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
                    // You could detect your visitor's browser and redirect to Paypal's mobile checkout
                    // if they are on a mobile device. Just add a true as the last parameter. It defaults
                    // to false
                    // $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true);
                    
                } else {
                    $this->_error($set_ec_return);
                    
                }//end if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) 
                        
                        
            }else{
                
                $this->session->set_flashdata('err_message', 'Please Select atleast One Pharmacy to purchase the Governance.');
                redirect(SURL.'organization/settings');
                
            }//end if(count($pharm_gov_chk) > 0)

        }else{

            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)
        
    }//end governance_checkout()
    
    //Function survey_checkout()
    public function survey_checkout(){
		
        if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner){
            
            if(!$this->input->post() && !$this->input->post('survey_purchase_btn')) redirect(base_url());
            
            extract($this->input->post());
            $no_of_products = count($pharm_survey_chk);
            if($no_of_products > 0){

                $to_buy = array(
                    'desc' => 'Hubnet Survey Purchase inc VAT', 
                    'currency' => CURRENCY, 
                    'type' => PAYMENT_METHOD, 
                    'return_URL' => SURL.'organization/checkout-success/'.$no_of_products, 
                    // see below have a function for this -- function back()
                    // whatever you use, make sure the URL is live and can process
                    // the next steps
                    'cancel_URL' => SURL.'organization/settings', // this goes to this controllers index()
                    'shipping_amount' => 0.00, 
                    'get_shipping' => false
                );

                $get_survey_package = $this->survey->get_survey_package(1);
                $survey_purchase_price = filter_price($get_survey_package['price']); //Purchase price per pharmacy
                
                // Iterating through the content of your shopping cart.
                for($i=0;$i<count($pharm_survey_chk);$i++){
                    
                    $sub_total+=$survey_purchase_price;
                    
                    $get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharm_survey_chk[$i]);
                    $product_title = 'Survey Purchase for "'.filter_string($get_pharmacy_details['pharmacy_surgery_name']).'"';
                    
                    $temp_product = array(
                        'name' => $product_title,
                        'desc' => 'SURVEY', 
                        'number' => 'S_'.filter_string($get_pharmacy_details['id']), 
                        'quantity' => 1, 
                        'amount' => $survey_purchase_price);
                        
                    // add product to main $to_buy array
                    $to_buy['products'][] = $temp_product;
                    
                }//end for($i=0;$i<count($pharm_survey_chk);$i++)
                
                $VAT_PERCENTAGE = 'VAT_PERCENTAGE';
                $vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
        
                $vat_amount = (trim($vat_percentage['setting_value']) / 100) * $sub_total;
                $vat_amount = filter_price($vat_amount);
                
                $to_buy['tax_amount'] = $vat_amount;
                
                // enquire Paypal API for token
                $set_ec_return = $this->paypal_ec->set_ec($to_buy);
                
                if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
                    // redirect to Paypal
                    $this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
                    // You could detect your visitor's browser and redirect to Paypal's mobile checkout
                    // if they are on a mobile device. Just add a true as the last parameter. It defaults
                    // to false
                    // $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true);
                    
                } else {
                    $this->_error($set_ec_return);
                    
                }//end if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) 
                        
                        
            }else{
                
                $this->session->set_flashdata('err_message', 'Please Select atleast One Pharmacy to purchase the Survey.');
                redirect(SURL.'organization/settings');
                
            }//end if($no_of_products > 0)

        }else{

            $this->session->set_flashdata('err_message', 'You have to read the SOP\'s again.');
            redirect(SURL.'organization/dashboard');
            
        }//end if(($this->show_teambuilder && $this->user_org_superintendent) || $this->session->is_owner)
        
    }//end survey_checkout()

    //Function checkout_success()
    public function checkout_success($no_of_products){
        
        $token = $_GET['token'];
        $payer_id = $_GET['PayerID'];
        
        $get_ec_return = $this->paypal_ec->get_ec($token);

        if(isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
            // at this point, you have all of the data for the transaction.
            // you may want to save the data for future action. what's left to
            // do is to collect the money -- you do that by call DoExpressCheckoutPayment
            // via $this->paypal_ec->do_ec();
            //
            // I suggest to save all of the details of the transaction. You get all that
            // in $get_ec_return array
            $ec_details = array(
                'token' => $token, 
                'payer_id' => $payer_id, 
                'currency' => CURRENCY, 
                'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
                'IPN_URL' => site_url('organization/ipn'), 
                // in case you want to log the IPN, and you
                // may have to in case of Pending transaction
                'type' => PAYMENT_METHOD);
                
            // DoExpressCheckoutPayment
            $do_ec_return = $this->paypal_ec->do_ec($ec_details);
            
            if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
                
                // at this point, you have collected payment from your customer
                // you may want to process the order now.

                if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] = 'Success'){
                    
                    $data['get_ec_return'] = $get_ec_return;
                    $data['do_ec_return'] = $do_ec_return;
                    $data['user_id'] = $this->session->id;
                    $data['num_of_products'] = $no_of_products;
                    $data['purchased_by_id'] = $this->session->id;

                    $add_purchase_status = $this->purchase->add_products_to_order($data);
                    
                    if($add_purchase_status){
                        
                        //Custom Message set from admin site prefrences
                        $paypal_success = 'Congratulations! You have successfully purchased your items, please check your email for the purchase receipt. Thank You!';
                        $this->session->set_flashdata('paypal_success', $paypal_success);						
                        redirect(SURL.'organization/settings');
                    }//end if($add_purchase_status)
                    
                }else{
                    echo "OOPS";exit;	
                }//end if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] = 'Success')
                
            } else {
                
                $this->_error($do_ec_return);
                
            }//end if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true))
            
        } else {
            $this->_error($get_ec_return);
        }//end if(isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) 

    }//end checkout_success()	
    
    //Function checkout(): Checkout to the PayPal with Single Product ONLY, $purchased_for contains the User ID, normally it will be the user id for whom the product is purchased normally used for Training and videos,, for G and S the logged in session id is used.
    public function single_product_checkout($product_type,$product_id,$purchased_for,$pharmacy_surgery_id = ''){
        
        //check if user is a valid user to purchse these items for that he must be a non-prescriber
        $check_is_non_prescriber = $this->users->get_user_details($purchased_for);

        if($product_type == 'P' || $product_type == 'OP' || $product_type == 'POP'){ //POP = Preimum Oral Package
            
            if($check_is_non_prescriber['is_prescriber']){
                //User is a Prescriber, Bug Off!
                redirect(SURL.'organization/dashboard');
            }//end if($check_is_non_prescriber['is_prescriber'] == 0)
            
        }//end if($product_type == 'T' || $product_type == 'P' || $product_type == 'OP' || $product_type == 'POP')

        if($pharmacy_surgery_id != ''){
            
            $get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
            $organization_id = filter_string($get_pharmacy_details['organization_id']);
            
            if(!$get_pharmacy_details)
                redirect(SURL.'organization/manage-surveys');			
        }else{
            redirect(SURL.'organization/manage-surveys');		
        }//end if($pharmacy_surgery_id != '')
        
        if($product_type == 'G'){ // Governance

            $items['p_type'] = 'GOVERNANCE';
            $to_buy['desc'] = 'Voyager Medical';
            
        }elseif($product_type == 'S'){ // Survey
        
            $items['p_type'] = 'SURVEY';
            $to_buy['desc'] = 'Voyager Medical Survey Purchase';
            
            $items['name'] = 'Survey Purchase for "'.filter_string($get_pharmacy_details['pharmacy_surgery_name']).'"';
            $items['id'] = 'S_'.$pharmacy_surgery_id;

            $get_survey_package = $this->survey->get_survey_package(1);
            
            $items['price'] = filter_price($get_survey_package['price']); //Purchase price per pharmacy
            $sub_total = $items['price'];
            
        }elseif($product_type == 'OP'){ // Oral PGD
        
            $ORAL_PGD_PACKAGE_PRICE = 'ORAL_PGD_PACKAGE_PRICE';
            $global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);
            
            $ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
            $global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);						

            $items['p_type'] = 'PGD';
            $items['name'] = 'STANDARD ORAL PGD PACKAGE';
            $items['id'] = 'P_0';
            $items['price'] = (filter_string($global_oral_packages_discount_price['setting_value']) != 0.00) ? filter_string($global_oral_packages_discount_price['setting_value']) : filter_string($global_oral_package_price['setting_value']);
            
            $sub_total = $items['price'];
            
            $to_buy['desc'] = 'Standard Oral PGD Package';

        }elseif($product_type == 'POP'){
			 // Preimumn Oral PGD
        

            $ORAL_PREMIUM_PGD_PACKAGE_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_PRICE';
            $global_oral_premium_package_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_PRICE);
            
            $ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE';
            $global_oral_premium_packages_discount_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE);						

            $items['p_type'] = 'PGD';
            $items['name'] = 'PREMIUM ORAL PGD PACKAGE';
            $items['id'] = 'P_1';
            $items['price'] = (filter_string($global_oral_premium_packages_discount_price['setting_value']) != 0.00) ? filter_string($global_oral_premium_packages_discount_price['setting_value']) : filter_string($global_oral_premium_package_price['setting_value']);
            
            $sub_total = $items['price'];
            
            $to_buy['desc'] = 'Premium Oral PGD Package';

        			
		}elseif($product_type == 'P'){ //PGD
            
            $get_pgd_details = $this->pgds->get_pgd_details($product_id);
            if(!$get_pgd_details) redirect(SURL.'organization/dashboard');
            
            $items['p_type'] = 'PGD';
            $items['name'] = filter_string($get_pgd_details['pgd_name']);
            $items['id'] = 'P_'.$product_id;
            $items['price'] = (filter_string($get_pgd_details['discount_price']) != 0.00) ? filter_string($get_pgd_details['discount_price']) : filter_string($get_pgd_details['price']);
            
            $sub_total = $items['price'];
            
            $to_buy['desc'] = '('.filter_string($get_pgd_details['pgd_name']).')';
            
        }elseif($product_type == 'T'){ //Training

            $get_training_course_details = $this->training->get_training_course_details($product_id);
            
            if(!$get_training_course_details) redirect(SURL.'organization/dashboard');
            
            //Check if the Training Selected is for the usertype. For  that Training Usertype and Users Usertype should be same.
            if($get_training_course_details['user_type'] != $check_is_non_prescriber['user_type']) redirect(SURL.'organization/dashboard');
            
            $items['p_type'] = 'TRAINING';
            $items['name'] = filter_string($get_training_course_details['course_name']);
            $items['id'] = 'T_'.$product_id;
            $items['price'] = (filter_string($get_training_course_details['discount_price']) != 0.00) ? filter_string($get_training_course_details['discount_price']) : filter_string($get_training_course_details['price']);
            
            $sub_total = $items['price'];
            
            //$to_buy['desc'] = 'Voyager Medical';
			$to_buy['desc'] = '('.filter_string($get_training_course_details['course_name']).')';
            
        }//end if($product_type == 'G')
        
        $to_buy = array(
            'currency' => CURRENCY, 
            'type' => PAYMENT_METHOD, 
            'return_URL' => SURL.'organization/single-product-checkout-success/'.$purchased_for.'/'.$organization_id, 
            // see below have a function for this -- function back()
            // whatever you use, make sure the URL is live and can process
            // the next steps
            'cancel_URL' => SURL.'organization/dashboard', // this goes to this controllers index()
            'shipping_amount' => 0.00, 
            'get_shipping' => false
        );
		
        $temp_product = array(
            'name' => $items['name'], 
            'desc' => $items['p_type'], 
            'number' => $items['id'], 
            'quantity' => 1, 
            'amount' => $items['price']);
            
        // add product to main $to_buy array
        $to_buy['products'][] = $temp_product;
		
            
        $VAT_PERCENTAGE = 'VAT_PERCENTAGE';
        $vat_percentage = get_global_settings($VAT_PERCENTAGE); //Set from the Global Settings
        
        $vat_amount = (trim($vat_percentage['setting_value']) / 100) * $sub_total;
        $vat_amount = filter_price($vat_amount);
        
        $to_buy['tax_amount'] = $vat_amount;
        
        // enquire Paypal API for token
        $set_ec_return = $this->paypal_ec->set_ec($to_buy);
        
        if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
            // redirect to Paypal
            $this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
            // You could detect your visitor's browser and redirect to Paypal's mobile checkout
            // if they are on a mobile device. Just add a true as the last parameter. It defaults
            // to false
            // $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true);
            
        } else {
            $this->_error($set_ec_return);
            
        }//end if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) 
        
    }//end single_product_checkout()
    
    public function single_product_checkout_success($purchased_for,$organization_id){
        
        $token = $_GET['token'];
        $payer_id = $_GET['PayerID'];
        
        $get_ec_return = $this->paypal_ec->get_ec($token);

        if(isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
            // at this point, you have all of the data for the transaction.
            // you may want to save the data for future action. what's left to
            // do is to collect the money -- you do that by call DoExpressCheckoutPayment
            // via $this->paypal_ec->do_ec();
            //
            // I suggest to save all of the details of the transaction. You get all that
            // in $get_ec_return array
            $ec_details = array(
                'token' => $token, 
                'payer_id' => $payer_id, 
                'currency' => CURRENCY, 
                'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
                'IPN_URL' => site_url('dashboard/ipn'), 
                // in case you want to log the IPN, and you
                // may have to in case of Pending transaction
                'type' => PAYMENT_METHOD);
                
            // DoExpressCheckoutPayment
            $do_ec_return = $this->paypal_ec->do_ec($ec_details);
            
            if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
                
                // at this point, you have collected payment from your customer
                // you may want to process the order now.

                if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] = 'Success'){
                    
                    $data['get_ec_return'] = $get_ec_return;
                    $data['do_ec_return'] = $do_ec_return;
                    $data['user_id'] = $purchased_for;
                    $data['purchased_by_id'] = $this->session->id;
                    $data['organization_id'] = $organization_id;
                    $data['num_of_products'] = 1;

                    $add_purchase_status = $this->purchase->add_products_to_order($data);
                    
                    if($add_purchase_status){
                        
                        //Custom Message set from admin site prefrences
                        $paypal_success = 'Congratulations! You have successfully purchased your items, please check your email for the purchase receipt. Thank You!';
                        $this->session->set_flashdata('paypal_success', $paypal_success);						
                        
                        // Set default cookie menu_item_number to Team Builder
                        set_cookie('menu_item_number','Team Builder',time()+86500);

                        if($this->session->is_owner || $this->user_org_superintendent){
                            redirect(SURL.'organization/dashboard');
                        } else{
                            redirect(SURL.'organization/pharmacy-surgery');
                        } // if($this->session->is_owner || $this->user_org_superintendent)

                    }//end if($add_purchase_status)
                    
                }else{
                    echo "OOPS";exit;	
                }//end if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] = 'Success')
                
            } else {
                
                $this->_error($do_ec_return);
                
            }
        } else {
            $this->_error($get_ec_return);
        }
        
    }//end single_product_checkout_success()

    public function ipn(){
        $logfile = 'ipnlog/' . uniqid() . '.html';
        $logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
        file_put_contents($logfile, $logdata);
        
    }//end ipn()

    public function _error($ecd){
        
        $erro_txt .= "<h3>error at Express Checkout<h3>";
        $erro_txt .= "<pre>" . print_r($ecd, true) . "</pre>";
        
        $data['err_msg'] = $ecd;
        $this->stencil->layout('frontend_template_subpage'); //frontend template
        $this->stencil->paint('errors/paypal_failed',$data);
    }//end _error($ecd)
    
    public function manage_surveys(){
		
		if(!$this->allowed_user_menu['show_manage_surveys']){
			redirect(SURL.'organization/dashboard');	
		}else{
			
			//This section is allowed to those who have passed the governance and the status is active for pharmacy from admin 
			if(!$this->allowed_user_menu['show_clinical_governance']){
				$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
				redirect(SURL.'organization/dashboard');
			}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
				
		}//end if(!$this->allowed_user_menu['show_manage_surveys'])
        
		// Bread crumb 
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 $this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 $this->breadcrumbcomponent->add('Manage Surveys', base_url().'manage-surveys');
		 
		 // Bread crumb output
		 $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		$this->stencil->layout('dashboard_template'); //dashboard_template

        //set title
        //$page_title = $page_data['page_title'];
       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
        if($this->user_org_superintendent || $this->session->is_owner)
            $get_my_pharmacies_surgeries = $this->pharmacy->get_pharmacy_surgery_list($this->my_organization_id);
        else
            $get_my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries($this->session->id);
			
        $data['my_pharmacies_surgeries'] = $get_my_pharmacies_surgeries;
    
        // Verify Request By : POST OR SESSION
        if($this->session->pharmacy_surgery_id){

            $pharmacy_surgery_exist = (array_search($this->session->pharmacy_surgery_id, array_column($get_my_pharmacies_surgeries,'pharmacy_surgery_id')));
			$my_role_in_pharmacy = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id,$this->session->pharmacy_surgery_id);
			
			$data['my_role_in_pharmacy'] = $my_role_in_pharmacy;
			
            if(strlen($pharmacy_surgery_exist) > 0)
                $data['pharmacy_surgery_verified'] = 1;

        } // if($this->session->pharmacy_surgery_id)

        if($this->input->post('survey_pharmacy_surgery')){

            $pharmacy_surgery_exist = (array_search($this->input->post('survey_pharmacy_surgery'), array_column($get_my_pharmacies_surgeries,'pharmacy_surgery_id')));
            
            if(strlen($pharmacy_surgery_exist) > 0)
                $data['pharmacy_surgery_verified'] = 1;
            
        } // if($this->input->post('survey_pharmacy_surgery'))

        if( $data['pharmacy_surgery_verified'] != '' ){
            
            if($this->session->pharmacy_surgery_id)
                $pharmacy_surgery_id = $this->session->pharmacy_surgery_id;
            else
                $pharmacy_surgery_id = trim($this->input->post('survey_pharmacy_surgery'));
            // if($this->session->pharmacy_surgery_id)
			
			$data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
            $get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
            $data['pharmacy_details'] = $get_pharmacy_details;

            //Check if Survey is purchased
            $check_if_survey_purchased = $this->survey->get_survey_purchased_pharmacies($get_pharmacy_details['organization_id'],'P',$pharmacy_surgery_id);
            $data['check_if_survey_purchased'] = $check_if_survey_purchased;

			/*
            $NO_OF_SURVEY_ATTEMPTS = 'NO_OF_SURVEY_ATTEMPTS';
            $survey_no_of_attempts_required = get_global_settings($NO_OF_SURVEY_ATTEMPTS); //Set from the Global Settings
            $data['survey_no_of_required_attempts'] = filter_string($survey_no_of_attempts_required['setting_value']);
			*/
			$data['survey_no_of_required_attempts'] = filter_string($get_pharmacy_details['no_of_surveys']);
			
            if($check_if_survey_purchased){
                //Survey is purchased

                if($check_if_survey_purchased['expiry_date'] != '0000-00-00' && $check_if_survey_purchased['survey_start_date'] != ''){
                    //Survey is already started it means we are building the survey of the date when it was started.
                    $current_date = date('m/d',strtotime(filter_string($check_if_survey_purchased['survey_start_date'])));
                    
                    $survey_start_date = date('Y-m-d',strtotime(filter_string($check_if_survey_purchased['survey_start_date'])));
                    
                    $get_no_of_surveys_attempted = $this->survey->get_no_of_surveys_attempted($check_if_survey_purchased['survey_ref_no']);
                    $data['no_of_surveys_attempted'] = $get_no_of_surveys_attempted;
                    
                }else{
                    //Survey is not yet started means we have to start the survey of the current one.
                    $current_date = date('m/d');	
                    $survey_start_date = date('Y-m-d');
                }//end if
                $data['survey_start_date'] = $survey_start_date;
                
                $SURVEY_END_MONTH = 'SURVEY_END_MONTH';
                $survey_end_global_value = get_global_settings($SURVEY_END_MONTH); //Set from the Global Settings
                $next_survey_end_date = filter_string($survey_end_global_value['setting_value']);

                if(strtotime($current_date) >= strtotime($next_survey_end_date)){
                    $next_survey_end = strtotime("$next_survey_end_date +1 year");	
					$survey_session = date('Y').'-'.(date('Y')+1);
                    //$survey_end_date = date('Y-m-d', $next_survey_end).'-'.(date('Y', $next_survey_end)+1); 
					$survey_end_date = date('Y-m-d', $next_survey_end);
                }else{
                    $next_survey_end = strtotime("$next_survey_end_date +0 year");
					$survey_session = (date('Y', $next_survey_end)-1).' - '.date('Y', $next_survey_end);
                   // $survey_end_date = (date('Y-m-d', $next_survey_end)-1).'-'.date('Y', $next_survey_end);
				    $survey_end_date = date('Y-m-d', $next_survey_end);
                }//end if
				
				
				//echo "hi".$survey_end_date; exit;
                $data['next_survey_end'] = $next_survey_end;
                $data['survey_session'] = $survey_session;
                $data['survey_end_date'] = $survey_end_date;
                
            }else{

				$SURVEY_PAYMENT_MODE = 'SURVEY_PAYMENT_MODE';
				$survey_payment_mode = get_global_settings($SURVEY_PAYMENT_MODE); //Set from the Global Settings
				$survey_payment_mode = filter_string($survey_payment_mode['setting_value']);
				
				if(!$survey_payment_mode){
					//Survey Payment Mode is Free
					
					//print_this($get_pharmacy_details); exit;
					$add_free_survey_to_order = $this->purchase->add_free_survey_to_order($get_pharmacy_details['organization_id'], $get_pharmacy_details['id'], $this->session->id);
					if($add_free_survey_to_order)
						redirect(SURL.'organization/manage-surveys');	
					
				}//end if(!$survey_payment_mode)
				
			}//end if($check_if_survey_purchased)
			
            //Get Past Surveys List
            $get_past_survey_list = $this->survey->get_past_survey_list($pharmacy_surgery_id);
            $data['past_survey_list'] = $get_past_survey_list;

            //Get Array of Questions
            $get_questionnnair_arr = $this->survey->get_questionnaire_list();
            $data['questionnnair_arr'] = $get_questionnnair_arr;
            
			$this->load->model('email_mod','email_template');
			$email_body_arr = $this->email_template->get_email_template(17);
			$email_body = strip_tags($email_body_arr['email_body']);
			$data['email_body'] = $email_body;

            //$get_question_stats = $this->survey->get_survey_question_stats('UFKPE3S');
            
        }//end if(!$this->input->post('survey_pharmacy_surgery'))
        $this->stencil->js('org_dashboard.js');
        
        $this->stencil->css('built.css');
		
		//Fancy Box Files
        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->js('jquery.mousewheel-3.0.6.pack.js');

        //load Paint
        $this->stencil->paint('organization/manage_surveys',$data);
        
    }//end organization_surveys()
    
    public function start_survey(){
		
		//if(!$this->allowed_user_menu['show_manage_surveys']) redirect(SURL.'organization/dashboard');

		if(!$this->allowed_user_menu['show_manage_surveys']){
			redirect(SURL.'organization/dashboard');	
		}else{
			
			if(!$this->session->is_owner){
				
				//This section is inly allowed to owner and those who have passed the governance and the status is active for this from admin for this user
				
				if(!$this->allowed_user_menu['show_clinical_governance']){
					$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
					redirect(SURL.'organization/dashboard');
				}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
				
			}//end if(!$this->session->is_owner)
			
		}//end if(!$this->allowed_user_menu['show_manage_surveys'])
		
		
        //If Post is not SET
        if(!$this->input->post() && !$this->input->post('start_survey_btn')) redirect(base_url());
        
        extract($this->input->post());

        if(trim($pharmacy_surgery_id) != ''){
            
            $start_pharmacy_survey = $this->survey->start_pharmacy_survey($pharmacy_surgery_id,$survey_order_id);
            
            if($start_pharmacy_survey){
				
				$update_pharmacy_surveys = $this->pharmacy->update_pharmacy_no_of_surveys($radio_no_of_survey, $pharmacy_surgery_id);
				
                $get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
                $pharmacy_name = filter_string($get_pharmacy_details['pharmacy_surgery_name']).', '.filter_string($get_pharmacy_details['postcode']);
				
                $this->session->set_flashdata('ok_message', "Your New Survey for <strong>$survey_year</strong> has now started for <strong>$pharmacy_name</strong>");
                redirect(SURL.'organization/manage-surveys');
                
            }//end if($start_pharmacy_survey)
            
        }else{
            redirect(base_url());			
        }//end if(trim($pharmacy_surgery_id) != '')
        
    }//end start_survey()
	
	public function send_survey_link_process(){

        //If Post is not SET
        if(!$this->input->post() && !$this->input->post('friend_email_address')) redirect(base_url());
        
        extract($this->input->post());
		
		$send_email_to_friend = $this->survey->email_survey_link($this->input->post());
		
		if($send_email_to_friend){

			$this->session->set_flashdata('ok_message', "Survey link is sent successfully to your friend.");
			redirect(SURL.'organization/manage-surveys');
			
		}//end if($send_email_to_friend)
		
	}//end send_survey_link_process()
    
    // Start edit_pharmacy_surgery():
    public function edit_pharmacy_surgery($pharmacy_id = ''){

        if($pharmacy_id!=""){
			
            $get_pharmacy_surgery_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_id);
            $data['get_pharmacy_surgery_details'] = $get_pharmacy_surgery_details;
            
            // get organization id
            $organization_id = $get_pharmacy_surgery_details['organization_id']; 
            
            $pharmacy_surgery_time_settings = $this->pharmacy->get_pharmacy_surgery_time_settings_details($pharmacy_id);
            $data['pharmacy_surgery_time_settings'] = $pharmacy_surgery_time_settings;
            
            $pharmacy_surgery = $this->pharmacy->get_pharmacy_surgery_global_settings_details($pharmacy_id);
            $data['pharmacy_surgery'] = $pharmacy_surgery;
            
            $pharmacy_surgery_governance_purchased = $this->governance->get_governance_purchased_pharmacies($organization_id,'P',$pharmacy_id);
            
            if($pharmacy_surgery_governance_purchased)
                $data['governance_purchase_status'] = 1;
            else 
                $data['governance_purchase_status'] = 0;

            // $pharmacy_surgery_governance_purchased
            
         }//end if($pharmacy_id!="")
		 
		 //This section is for first pharmacy import org data button
		 if($this->session->is_owner || $this->user_org_superintendent){
			 
			$get_organization_pharmacy_list = $this->pharmacy->get_pharmacy_surgery_list($this->my_organization_id);
			$get_organization_data = $this->organization->get_organization_details($this->my_organization_id);
			$data['organization_data'] = $get_organization_data;
			
			$data['organization_pharmacy_list'] = $get_organization_pharmacy_list;
			 
		 }//end if($this->session->is_owner || $user_org_superintendent)

		// Get all country
        $get_all_country = $this->organization->get_all_country();
        $data['get_all_country']=$get_all_country;

            
        // Add "JS" and "CSS" for UI element ( On/Off Switch and others )
        $this->stencil->js('highlight.js');
        $this->stencil->js('bootstrap-switch.js');
        $this->stencil->css('highlight.css');
        $this->stencil->css('bootstrap-switch.css');
                        
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');
        
        //$this->stencil->js('org_dashboard.js');
        $this->stencil->js('kod_scripts/custom.js');
    
        $this->stencil->layout('pharmacy_settings'); //pgd_detail_ajax_template
        
        //edit Pharmacy Surgery data
        $this->stencil->paint('organization/pharmacy_surgery/add_edit', $data);

    } // End edit_pharmacy_surgery():

    // Start - add_update_pharmacy_surgery_process
    public function add_update_pharmacy_surgery_process(){

        //If Post is not SET
        if(!$this->input->post() && !$this->input->post('add_update_btn')) redirect(base_url());

        $update_pharmacy_surgery = $this->pharmacy->add_update_pharmacy_surgery($this->my_organization_id,$this->input->post());

        if($update_pharmacy_surgery){

            // Verify if the new added location is the 1st location
            $my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( '', '', $this->my_organization_id );

            if( count($my_pharmacies_surgeries) == 1 && !$this->session->pharmacy_surgery_id ){

                $my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( '', '', $this->my_organization_id );

                // If another Pharmacy / Surgery is selected
                $pharmacy_data = $this->pharmacy->get_pharmacy_surgery_details($my_pharmacies_surgeries[0]['pharmacy_surgery_id']);
            
                // set session for: Organization ID
                $this->session->organization_id = $pharmacy_data['organization_id'];
                $this->session->pmr_organization_id = $this->session->organization_id;
                
                // set session for: Pharmacy / Surgery ID
                $this->session->pharmacy_surgery_id = $pharmacy_data['id'];
                $this->session->pmr_pharmacy_surgery_id = $this->session->pharmacy_surgery_id;

                $is_default = $this->pmr->get_default_prescriber_organization_list($this->session->id, $my_organization_id);

                if($is_default){
                    $this->session->pmr_org_pharmacy = 'O|'.$my_organization_id;
                } else {
                    $this->session->pmr_org_pharmacy = 'P|'.$pharmacies_surgeries[0]['pharmacy_surgery_id'].'|'.$my_organization_id;
                } // if($is_default)

            } // if( count($my_pharmacies_surgeries)  == 1 && !$this->session->pharmacy_surgery_id )

            $pharmacy_id = $this->input->post('pharmacy_id');
            // Get Type
            $type = $this->input->post('type');
            // Check type "P" for(pharmacy) "S" for (Surgery)
            if($type=="P")
                $type ="Location";
            else
                $type ="Location";
            // if pharmacy_id not empty
            if($pharmacy_id==""){
    
                $this->session->set_flashdata('ok_message', $type.' successfully added into your organisation.');
                if(isset($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(SURL.'organization/dashboard');
                }
                
            } else if($pharmacy_id != '') {
    
                $this->session->set_flashdata('ok_message', $type.' successfully updated into your organisation.');
                if(isset($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(SURL.'organization/dashboard');
                }
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                if(isset($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(SURL.'organization/dashboard');
                }
    
            } // End if($pharmacy_id != '')
    
        } // End $update_pharmacy_surgery
        
    } // End add_update_pharmacy_surgery_process():

    // Start Function delete_pharmacy_surgery
    public function delete_pharmacy_surgery($delete_pharmacy_surgery_id, $type) {

        // Delete pharmacy Surgery Delete
        $delete_pharmacy_surgery_id = $this->pharmacy->pharmacy_surgery_delete($delete_pharmacy_surgery_id);

        // if deleted success
        if($delete_pharmacy_surgery_id){

            // Check P for Pharmacy and S for Surgery
            if($type=="P")
                $type = 'Pharmacy';
            else
                $type = 'Surgery';
            
            // If selected pharmacy id and the requested pharmacy_id is same then unset the session_commit()

            if($this->session->pharmacy_surgery_id && $this->session->pharmacy_surgery_id == $delete_pharmacy_surgery_id ){
                $selected_org_pharmacy = array('organization_id', 'pmr_organization_id', 'pharmacy_surgery_id', 'pmr_pharmacy_surgery_id');
                $this->session->unset_userdata($selected_org_pharmacy);
            } // if($this->session->pharmacy_surgery_id && $this->session->pharmacy_surgery_id == $delete_pharmacy_surgery_id )
            
            $this->session->set_flashdata('ok_message', $type.' deleted successfully.');
            redirect(SURL.'organization/dashboard');

        }else{

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
            redirect(SURL.'organization/dashboard');

        } // End else condtion
        
    } // delete_pharmacy_surgery($delete_pharmacy_surgery_id,$type)
    
    // Function Start ajax_list_emails
    public function ajax_list_emails() {
		
        if(!$this->input->post('user_type')){

            // For manager auto search emails
            $list_auto_search_emails= $this->organization->get_all_ajax_list_emails($this->input->post('email'),'');
            $data['list_auto_search_emails'] = $list_auto_search_emails;
            
            $data['type'] = 'manager';

        //$list_auto_search_emails= $this->organization->get_all_ajax_list_emails($this->input->post('email'),'');
         } else {

             // For staff auto search emails
            $list_auto_search_emails= $this->organization->get_all_ajax_list_emails($this->input->post('email'), $this->input->post('user_type'));
            $data['list_auto_search_emails'] = $list_auto_search_emails;
            $data['type'] = 'staff';
            
        } // end - else if(!empty($this->input->post('user_type'))):

        $data['list_hidden'] =  $this->input->post('pharmacy_surgery_id');
        echo $this->load->view('organization/auto_suggestion_email',$data, true);

    } // End ajax_list_emails

    // Start edit_manager_staff():
    public function edit_manager_staff($manager_staff_id = ''){

        // Get manager Name Or Staff Name from user table call get_manager_staff_details function
        $get_manager_staff_details = $this->users->get_user_details($manager_staff_id);

        $data['get_manager_staff_details'] = $get_manager_staff_details;
		
		 //$this->stencil->js('org_dashboard.js');
        $this->stencil->js('kod_scripts/custom.js');
        
		$this->stencil->layout('pharmacy_settings'); //pgd_detail_ajax_template
		  //edit Pharmacy Surgery data
        $this->stencil->paint('organization/pharmacy_surgery/edit_manager_staff', $data);
        //edit manager_staff  data
       // echo $this->load->view('organization/pharmacy_surgery/edit_manager_staff',$data, true);

    } // End edit_manager_staff():

    // Start update_manager_process
    public function update_manager_staff_process(){

        //If Post is not SET
        if(!$this->input->post() && !$this->input->post('update_manager_staff_btn')) redirect(base_url());

        // Update Manager or Staff Name mobile number using update_manager_staff function
        $update_mamager_staff = $this->organization->update_manager_staff($this->input->post());

        if($update_mamager_staff){

            // Post manager_staff_id
            $manager_staff_id = $this->input->post('manager_staff_id');

            // if manager_staff_id not empty
            if($manager_staff_id != ''){

                $this->session->set_flashdata('ok_message', ' Manager or staff member updated successfully.');
                if(isset($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(SURL.'organization/dashboard');
                }
                
            }else{

                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                if(isset($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(SURL.'organization/dashboard');
                }
            } // End else condtion if success failed
        
      } // End $update_mamager
      
    } // End update_manager_process():

    // Start Function delete_staff_member
    public function delete_staff_member($staff_id = '') {

        // Delete User
        $delete_staff_member = $this->organization->delete_staff_member($staff_id);

        // if deleted success
        if($delete_staff_member){

            $this->session->set_flashdata('ok_message', 'Staff member deleted successfully.');
            if(isset($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(SURL.'organization/dashboard');
                }

        } else {

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
            if(isset($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(SURL.'organization/dashboard');
                }

        } // End else condtion

    } // delete_staff_member
    
    // Start - pharmacy_surgery():
    public function pharmacy_surgery($pharmacy_surgery_id=''){
		
		if(!$this->session->pharmacy_surgery_id || $pharmacy_surgery_id == '')
            redirect(SURL.'dashboard');
        // if( !$this->session->pharmacy_surgery_id )
		
		// Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		 
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        
        if($this->belong_to_any_organization){
        
            if($this->user_org_superintendent)
                redirect(SURL.'organization/dashboard');
            // if($this->user_org_superintendent)
            
        } else
            redirect(SURL.'dashboard');
        // if($this->belong_to_any_organization)

        if($pharmacy_surgery_id != ''){

            // If another Pharmacy / Surgery is selected
            $pharmacy_data = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
        
            // set session for: Organization ID
            $this->session->organization_id = $pharmacy_data['organization_id'];
            
            // set session for: Pharmacy / Surgery ID
            $this->session->pharmacy_surgery_id = $pharmacy_surgery_id;
            
        } // if($pharmacy_surgery_id != '')
    
        // If request came from the : function member_dashboard()
        if($this->session->pharmacy_surgery_id && $pharmacy_surgery_id == ''){
            
            $pharmacy_surgery_id = $this->session->pharmacy_surgery_id;
            $pharmacy_data = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
            
        } //if($this->session->pharmacy_surgery_id)
        
		$my_role_in_pharmacy_surgery_data = $this->pharmacy->get_my_role_in_pharmacy_surgery($this->session->id, $pharmacy_surgery_id); // Get User role in the pharmacy / surgery [ By pharmacy_surgery_id ]
		
		if($my_role_in_pharmacy_surgery_data['is_manager'] == 1){
			$data['is_manager'] = 1;
			$data['show_team'] = 1;
			
			// $this->session->is_manager = 1;

			$data['pharmacies_surgeries'] = $this->pharmacy->get_all_org_pharmacies('', $pharmacy_data['organization_id'], '', $pharmacy_surgery_id);
			
		}else{

			$this->session->unset_userdata('is_manager');
			if($this->session->show_button_suggesstions)
				$this->session->unset_userdata('show_button_suggesstions');
			// if($this->session->show_button_suggesstions)

		}// if($my_role_in_pharmacy_surgery_data['is_manager'] == 1)
		
		if($my_role_in_pharmacy_surgery_data['is_staff'] == 1)
			$data['is_staff'] = 1;
		// if($data['is_staff'] == 1)
		
        // Get pharmacy surgery details to get the organization_id
        $pharmacy_surgery = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
        $pharmacy_surgery_governance_purchase_status  = $this->governance->get_governance_purchased_pharmacies($pharmacy_surgery['organization_id'],'P',$pharmacy_surgery_id);
        
        //echo $pharmacy_surgery['organization_id'].' - '.$pharmacy_surgery_id;
        //exit;

        if( count($pharmacy_surgery_governance_purchase_status) > 0){
            
            // Governance is Purchased for this pharmacy
            
            // Varify if the Governance read setting is on for this Pharmacy / Surgery
            $is_governance_on = $this->pharmacy->is_governance_settings_on($pharmacy_surgery_id);
            
            if($is_governance_on){

            	if($my_role_in_pharmacy_surgery_data['is_manager'] == 0 && $my_role_in_pharmacy_surgery_data['is_staff'] == 1){
                    $my_role = 'ST';
                } // if($my_role_in_pharmacy_surgery_data['is_manager'] == 0 && $my_role_in_pharmacy_surgery_data['is_staff'] == 1)

                if($my_role_in_pharmacy_surgery_data['is_manager'] == 1){
                    $my_role = 'M';
                } // if($my_role_in_pharmacy_surgery_data['is_manager'] == 1)
        
                // Varify If governance is read by the user
                
                $governance_read = $this->governance->is_governance_read_by_user($this->session->id, $pharmacy_surgery['organization_id'], $pharmacy_surgery_id, $my_role,$this->session->user_type);
                
                if($governance_read){ // Governance is read by the user
                
                    $data['governance_read'] = 1;

                    if($my_role_in_pharmacy_surgery_data['is_staff'] == 1 && $my_role_in_pharmacy_surgery_data['is_manager'] == 0){
		            	redirect(SURL.'dashboard');
		            } // if($my_role_in_pharmacy_surgery_data['is_staff'] == 1 && $my_role_in_pharmacy_surgery_data['is_manager'] == 0)
                    
                    // Enable Authenticate PGD Menu Item

                } else { // Governance not read by the user
                
                    $data['governance_read'] = 0;

                    $get_organization_governance_arr = $this->governance->get_org_governance_details('',$pharmacy_surgery['organization_id']);
                    $data['organization_governance_arr'] = $get_organization_governance_arr;

                    // If user is a SI, get the HR
                    //$get_organization_hr_document = $this->governance->get_organization_hr_details('',$pharmacy_surgery['organization_id'], $this->session->user_type, $pharmacy_surgery['type']);
                    //$data['organization_hr_document'] = $get_organization_hr_document;
                    
                    $get_organization_sop_list = $this->governance->get_organization_sop_tree($pharmacy_surgery['organization_id'],$this->session->user_type);
                    $data['organization_sop_list'] = $get_organization_sop_list;
                    
                    $get_user_sop_read_list = $this->governance->get_user_sop_read_list($this->session->id,$pharmacy_surgery['organization_id'], $pharmacy_surgery_id);
                    $data['user_sop_read_list'] = $get_user_sop_read_list;

                    $get_user_governance_read_data = $this->governance->get_user_governance_read_status($this->session->id,$pharmacy_surgery['organization_id'],$pharmacy_surgery_id, $my_role);

                    $data['user_governance_read_data'] = $get_user_governance_read_data;
                    
                    $data['my_organization_id'] = $pharmacy_surgery['organization_id'];
                    $data['pharmacy_surgery_id'] = $pharmacy_surgery_id;
                    $data['user_type'] = $this->session->user_type;
                    
                } // if($governance_read)
            
            } else {
                
                $data['governance_read'] = 1;

                if($my_role_in_pharmacy_surgery_data['is_staff'] == 1 && $my_role_in_pharmacy_surgery_data['is_manager'] == 0){
	            	redirect(SURL.'dashboard');
	            } // if($my_role_in_pharmacy_surgery_data['is_staff'] == 1 && $my_role_in_pharmacy_surgery_data['is_manager'] == 0)
                
            } // if($is_governance_on)
                
        } else { // if(!empty($pharmacy_surgery_governance_purchase_status))
            
            // If Pharmacy / Surgery did not purchase the Governance : We assume that the govenrnance is read
            // Show team builder
            
            $data['governance_read'] = 1;

            if($my_role_in_pharmacy_surgery_data['is_staff'] == 1 && $my_role_in_pharmacy_surgery_data['is_manager'] == 0){
            	redirect(SURL.'dashboard');
            } // if($my_role_in_pharmacy_surgery_data['is_staff'] == 1 && $my_role_in_pharmacy_surgery_data['is_manager'] == 0)
            
        }

        //set title
        $page_title = $training_detail_arr['meta_title'];
        $this->stencil->title($page_title);

        $non_presriber_usertype_arr = array('2','3');
        $data['non_presriber_usertype_arr'] = $non_presriber_usertype_arr;

        $this->stencil->css('jquery.fancybox.css');
		
        $this->stencil->css('kod_css/mystyle.css');
		
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->js('jquery.mousewheel-3.0.6.pack.js');
        $this->stencil->js('org_dashboard.js');

        //Editor Files
        $this->stencil->js('tinymce/tinymce.min.js');

        //Tree View Script
        $this->stencil->js('bootstrap-treeview.js');

        // Time display
        $this->stencil->css('bootstrap-datetimepicker.min.css');
		$this->stencil->js('moment-with-locales');
        $this->stencil->js('bootstrap-datetimepicker.min.js');

		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
		'description' => DEFAULT_META_DESCRIPTION,
		'keywords' => DEFAULT_META_KEYWORDS,
		'meta_title' => DEFAULT_TITLE
		));
		
        // Js Form validation
        $this->stencil->js('kod_scripts/jquery.validate.js');
        $this->stencil->js('kod_scripts/custom_validate.js');

        // Load main template
        $this->stencil->layout('dashboard_template'); //dashboard_template
        //$this->stencil->paint('organization/pharmacy_surgery/member_dashboard',$data);
        $data['get_my_pharmacies_surgeries'] = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id );
        
        // Fetch ORAL PGD's (For Purchase)
        $this->load->model('pgds_mod', 'pgds');
        $oral_pgd_arr = $this->pgds->get_pgds_list('O');
        $data['oral_pgd_arr'] = $oral_pgd_arr;

        $premium_oral_pgd_arr = $this->pgds->get_pgds_list('OP');
        $data['premium_oral_pgd_arr'] = $premium_oral_pgd_arr;

        // Fetch Vaccines PGD's (For Purchase)
        $vaccine_pgd_arr = $this->pgds->get_pgds_list('V');
        $data['vaccine_pgd_arr'] = $vaccine_pgd_arr;
        
        $this->stencil->paint('organization/pharmacy_surgery/member_dashboard', $data);
        
    } // End - pharmacy_surgery():
    
    /* ----------------------------------------------------------------------------------------------------- */
    /*--------------------------------- Start Surveys Pie charts functions --------------------------------- */
    
    // get_survey_graph_data(): Ajax call to get survey's QUESTION json array : [ Single Question View AND Download Complete Survey ]
    public function get_survey_graph_data(){
        
        if(!$this->input->post() && !$this->input->post('question_id')) redirect(base_url());
        
        extract($this->input->post());
        
        if($question_id != ''){
            
            // Survey View [ Request for Single Question ]
            // Get Data for single question
            
            $question_survey_ids = ltrim($question_id, 'q_'); // q_1-aei0u
            
            $exploded = explode("-", $question_survey_ids);
            
            $question = $exploded[0]; // Question ID
            $survey_ref_no = $exploded[1]; // Survey Reference Number ID

            // Get pharmacy details to get pharmacy survey required attempts

            $get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pharmacy_surgery_id);
            $survey_no_of_required_attempts = filter_string($get_pharmacy_details['no_of_surveys']);

            $get_no_of_surveys_attempted = $this->survey->get_no_of_surveys_attempted($survey_ref_no);
            
            $get_question_stats = $this->survey->get_survey_question_stats($survey_ref_no, $question); // fetch Question attempts by survey reference number
            
            $chart_data = '';
            $chart_data .= '
                    {
                      "cols":
                            [
                                {"id":"","label":"","pattern":"","type":"string"},
                                {"id":"","label":"Voyager Surveys","pattern":"","type":"number"}
                            ],
                            
                      "rows":
                            [';
                                if($get_question_stats != ''){
                                    
                                    if($get_question_stats['question_id'] == 10){
                                        
                                        $chart_data .= ' {"c":[{"v":"Total Commented (%)","f":null},{"v":'.number_format( ($get_question_stats['total_commented'] / $get_question_stats['total_survey_attempt'] ) * 100, 2).',"f":null}]},';
                                        $chart_data .= ' {"c":[{"v":"Total Non-Commented (%)","f":null},{"v":'.number_format( ($get_question_stats['total_non_commented'] / $get_question_stats['total_survey_attempt'] ) * 100, 2).',"f":null}]},';
                                    
                                    } else {
                                        
                                        if($get_question_stats['total_options_attempted'] == 0){
                                            $get_question_stats['total_options_attempted'] = 1;
                                        } // if($get_question_stats['total_options_attempted'] == 0)
                                        
                                        foreach($get_question_stats['options_attempts'] as $option => $points ){

                                            if($get_question_stats['total_options_attempted'] != 0)
                                                $total_options_attempted = $get_question_stats['total_options_attempted'];
                                            else
                                                $total_options_attempted = 1;
                                            // if($get_question_stats['total_options_attempted'] != 0)

                                            $q_attempts_per = number_format( ($points / $total_options_attempted ) * 100, 2);

                                            $chart_data .= ' {"c":[{"v":"'.$option.' (%)","f":null},{"v":'.$q_attempts_per.',"f":null}]},';
                                        } // foreach($get_question_stats['options_attempts'] as $option => $points )
                                    } // if($question_id == 10)
                                        
                                } // if($get_question_stats != '')                                                                                                                                                                                                                                                                                                  
            $chart_data .= ' 	]
                    
                    } ';
        
            // Ready Question
            if($get_question_stats['parent_id'] != 0){
                
                $questions = '';
                
                // Parent Question
                $questions .= ''.$get_question_stats['parent_question'].'';
                // Sub Question
                $questions .= '<br /><br /><strong><i>(Option: '.$get_question_stats['question'].')</i></strong>';
                
                
            } else {
                $questions .= $get_question_stats['question'];
            } // if($get_question_stats['parent_id'] != 0)

            $statistics_html = "<br />";
            
            if($get_question_stats['question_id'] == 10){
                
                // Comments for Question 10
                if($get_question_stats['comments']){
                    
                    $comments = '
                                <div class="well well-xs" style="overflow-y: scroll; max-height: 80px;" >
                                <strong> Comments: </strong> <br /><br />
                                <ol>
                            ';
                    foreach($get_question_stats['comments'] as $comment){
                        
                        if($comment)
                            $comments .= '<li>'.$comment['option_txt'].'</li>';
                        // if($comment)
                            
                    } // foreach($get_question_stats['comments'] as $comment)
                    
                    $comments .= '</div><br />';
                    
                } // if($get_question_stats['comments'])
                
                $statistics_html .= "
                                
                                <div class='col-md-6'><center>
                                    <div class='number_circle'>".number_format( ($get_question_stats['total_commented'] / $get_question_stats['total_survey_attempt'] ) * 100)."%</div>
                                    <h5>Commented (%)</h5></center>
                                </div>
                                
                                <div class='col-md-6'><center>
                                    <div class='number_circle'>".number_format( ($get_question_stats['total_non_commented'] / $get_question_stats['total_survey_attempt'] ) * 100)."%</div>
                                    <h5>Non-Commented (%)</h5></center>
                                </div>
                                
                ";
                
            } else {
        
                if($get_question_stats['question_id'] == 1){
                    
                    // Comments for Question 1
                    if($get_question_stats['other_reasons_txt_arr']){
                        
                        $comments = '
                                    <div class="well well-xs" style="overflow-y: scroll; max-height: 80px;" >
                                    <strong> Comments: </strong> <br /><br />
                                    <ol>
                                ';
                        foreach($get_question_stats['other_reasons_txt_arr'] as $comment){
                            
                            if($comment)
                                $comments .= '<li>'. $comment['option_txt'].'</li>';
                            // if($comment)
                                
                        } // foreach($get_question_stats['other_reasons_txt_arr'] as $comment)
                        
                        $comments .= '</ol> </div> <br />';
                        
                    } // if($get_question_stats['other_reasons_txt_arr'])
                    
                } else
                    $comments = '';
                // if($get_question_stats['question_id'] == 1)
        
                $total_options = count($get_question_stats['options_attempts']);
                $per_cell = floor(12/$total_options);
            
                foreach($get_question_stats['options_attempts'] as $option => $points ){
                    
                    if($get_question_stats['total_options_attempted'] != 0)
                        $total_options_attempted = $get_question_stats['total_options_attempted'];
                    else
                        $total_options_attempted = 1;
                    // if($get_question_stats['total_options_attempted'] != 0)

                    $q_attempts_per = number_format( ($points / $total_options_attempted ) * 100);

                    $statistics_html .= "
                                    
                                    <div class='col-md-".$per_cell."'><center>
                                        <div class='number_circle'>".$q_attempts_per."%</div>
                                        <h5>".$option."</h5></center>
                                    </div>
                                    
                    ";
                
                } // foreach($get_question_stats['options_attempts'] as $option => $points )
                
            } // if($get_question_stats['question_id'] == 10)
    
            // Ready response : encode response to json_array
            
            $survey_status = 'Status: '.$get_no_of_surveys_attempted.' / '.$survey_no_of_required_attempts;

            $response = json_encode(array('chart_data' => $chart_data, 'question' => $questions, 'survey_status' => $survey_status, 'statistics' => $statistics_html, 'comments' => $comments));
        
            echo $response;
            
        } else if($pdf_download_all && $pdf_download_all == 1){
            
            // Survey [ Download Complete Survey is Requested ]
        
            if($survey_ref_no != ''){
                
                // Get Pharmacy / Surgery data [ by survey reference number - $survey_ref_no  ]
                $pharmacy_surgery = $this->survey->get_pharmacy_surgery($survey_ref_no);
                $response[] = array('pharmacy_surgery_name' => $pharmacy_surgery['pharmacy_surgery_name'], 'pharmacy_surgery_address' => $pharmacy_surgery['address'], 'pharmacy_surgery_zip' => $pharmacy_surgery['postcode']);
                
                $get_questions = $this->survey->get_survey_question_stats($survey_ref_no, $question_id_download); // fetch Question attempts by survey reference number

                if($question_id_download && $question_id_download != '')
                    $all_questions[0] = $get_questions;
                else
                    $all_questions = $get_questions;

                if($all_questions){
                
                    foreach($all_questions as $key => $get_question_stats){
                
                        $chart_data = '';
                        $chart_data .= '
                                {
                                  "cols":
                                        [
                                            {"id":"","label":"","pattern":"","type":"string"},
                                            {"id":"","label":"Voyager Surveys","pattern":"","type":"number"}
                                        ],
                                        
                                  "rows":
                                        [';
                                            if(isset($get_question_stats['question_id']) && $get_question_stats['question_id'] == 10){
                                                
                                                $chart_data .= ' {"c":[{"v":"Total Commented (%)","f":null},{"v":'.number_format(($get_question_stats['total_commented'] / $get_question_stats['total_survey_attempt']) * 100, 2).',"f":null}]},';
                                                $chart_data .= ' {"c":[{"v":"Total Non-Commented (%)","f":null},{"v":'.number_format(($get_question_stats['total_non_commented'] / $get_question_stats['total_survey_attempt']) * 100, 2).',"f":null}]},';
                                            
                                            } else {
                                                
                                                if(isset($get_question_stats['total_options_attempted']) && $get_question_stats['total_options_attempted'] == 0){

                                                    $total_options_attempted = 1;
                                                    
                                                } else {
                                                    if(isset($get_question_stats['total_options_attempted'])){
                                                        $total_options_attempted = $get_question_stats['total_options_attempted'];
                                                    }
                                                } // if($get_question_stats['total_options_attempted'] == 0)
                                            
                                                if(isset($get_question_stats['options_attempts']) && $get_question_stats['options_attempts'] != ''){
													
													$very_good_average = number_format(($get_question_stats['options_attempts']['Very Good'] / $total_options_attempted ) * 100, 2);
													
													$excellent_average = number_format( ($get_question_stats['options_attempts']['Excellent'] / $total_options_attempted ) * 100, 2);
													
													$good_ex_average = ($very_good_average + $excellent_average)/2;
													
                                                    foreach($get_question_stats['options_attempts'] as $option => $points ){
                                                        
                                                        $option = (strlen($option) > 20) ? substr($option, 0, 20).'...' : $option;
                                                        
                                                        $chart_data .= ' {"c":[{"v":"'.$option.' (%)","f":null},{"v":'.number_format( ($points / $total_options_attempted ) * 100, 2).',"f":null}]},';
                                                        
                                                    } // foreach($get_question_stats['options_attempts'] as $option => $points )
                                                    
                                                } // if($get_question_stats['options_attempts'])
                                                    
                                            } // if($question_id == 10)
                        $chart_data .= ' 	
                                        ]
                                } '; // End - Chart Data
                
                

                        // Ready Question
                        $questions = '';

                if($question_id_download && $question_id_download != ''){

                    $pharmacy_surgery_name = ucwords(filter_string($pharmacy_surgery['pharmacy_surgery_name']));
					
                    $statistics_html = '<div style="text-align: center; background-color: green; padding: 1em;" > <h1 style="color: #fff;"> Patient Satisfaction Survey Results '. $pharmacy_surgery_name .' </h1> </div>';
                    $statistics_html .= '<h2 style="text-align: center; color: green;"> '.number_format($good_ex_average,1).'% of our customers rate our service as very good or excellent </h2>';

                    $below_contents = 'We continue to strive to improve our service to you.';

                } else {

                        if(isset($get_question_stats['parent_id']) && $get_question_stats['parent_id'] != 0){
                            
                            // Parent Question
                            $questions .= ''.$get_question_stats['parent_question'].'';
                            // Sub Question
                            $questions .= '<br /><br /><strong><i>(Option: '.$get_question_stats['question'].')</i></strong>';
                            
                        } else {
                            if(isset($get_question_stats['question']))
                                $questions .= $get_question_stats['question'];
                        } // if($get_question_stats['parent_id'] != 0)

                        $statistics_html = '<br />
                                            <div style="background-color:#337AB7; width:100%"><br>
                                            <table cellpadding="2" cellspacing="2" width="100%">';
                    
                        if(isset($get_question_stats['question_id']) && $get_question_stats['question_id'] == 10){
                            
                            // Comments for Question 10
                            if($get_question_stats['comments']){
                                
                                $comments = '<div> <ol>';
                                foreach($get_question_stats['comments'] as $comment){
                                    
                                    if($comment)
                                        $comments .= '<li>'.$comment['option_txt'].'</li>';
                                    // if($comment)
                                        
                                } // foreach($get_question_stats['comments'] as $comment)
                                
                                $comments .= '</ol> </div>';
                                
                            } // if($get_question_stats['comments'])
                            
                            $statistics_html .= '
                                <tr style="background-color:#337AB7;">
                                    <td>
                                        <center>
                                            <div style="border-radius: 50px; width: 80px;height: 80px; padding: 16px; text-align: center; background: #fff; border: 0 solid #022360;color: #555;font: 21px Arial, sans-serif;">
                                                &nbsp; &nbsp; '.number_format( ($get_question_stats['total_commented'] / $get_question_stats['total_survey_attempt'] ) * 100).'% &nbsp; &nbsp;
                                            </div>
                                            <h5 style="color:#FFF">
                                                Commented (%)
                                            </h5>
                                        </center>
                                    </td>
                                
                                    <td>
                                        <center>
                                            <div style="border-radius: 50px; width: 80px;height: 80px; padding: 16px; text-align: center; background: #fff; border: 0px solid #022360;color: #555;font: 21px Arial, sans-serif;">
                                                &nbsp; &nbsp; '.number_format( ($get_question_stats['total_non_commented'] / $get_question_stats['total_survey_attempt'] ) * 100).'% &nbsp; &nbsp;
                                            </div>
                                            <h5 style="color:#FFF">
                                                Commented (%)
                                            </h5>
                                        </center>
                                    </td>
                                </tr>
                            ';
                        } else {
                    
                            if(isset($get_question_stats['question_id']) && $get_question_stats['question_id'] == 1){
                                
                                // Comments for Question 1
                                if($get_question_stats['other_reasons_txt_arr']){
                                    
                                    $comments = '<div> <ol>';
                                    foreach($get_question_stats['other_reasons_txt_arr'] as $key => $comment){
                                        
                                        if($comment)
                                            $comments .= '<li>'.$comment['option_txt'].'</li>';
                                        // if($comment)
                                            
                                    } // foreach($get_question_stats['other_reasons_txt_arr'] as $comment)
                                    
                                    $comments .= '</ol> </div>';
                                    
                                } // if($get_question_stats['other_reasons_txt_arr'])
                                
                            } else
                                $comments = '';
                            // if(isset($get_question_stats['question_id']) && $get_question_stats['question_id'] == 1)
                    
                            if(isset($get_question_stats['options_attempts']))
                                $total_options = count($get_question_stats['options_attempts']);
                            if(!$total_options) $total_options = 1;
                            $per_cell = floor(12/$total_options);
                        
                            if(isset($get_question_stats['options_attempts']) && $get_question_stats['options_attempts'] != ''){
                            
                                    $statistics_html .= '
                                        <tr style="background-color:#337AB7;">
                                        ';
                                        foreach($get_question_stats['options_attempts'] as $option => $points){									

                                            if($get_question_stats['total_options_attempted'] != 0)
                                                $total_options_attempted = $get_question_stats['total_options_attempted'];
                                            else
                                                $total_options_attempted = 1;
                                            // if($get_question_stats['total_options_attempted'] != 0)

                                            $q_attempts_per = number_format( ($points / $total_options_attempted ) * 100);
                                            $statistics_html .= '
                                                <td>
                                                    <center>
                                                        <div style="border-radius: 50px; width: 80px;height: 80px; padding: 16px; text-align: center; background: #fff; border: 0 solid #022360;color: #555;font: 21px Arial, sans-serif;">
                                                            &nbsp; &nbsp; '.$q_attempts_per.'% &nbsp; &nbsp;
                                                        </div>
                                                        <h5 style="color:#FFF">
                                                            '.$option.'
                                                        </h5>
                                                    </center>
                                                </td>';
                                        } //foreach($get_question_stats['options_attempts'] as $option => $points)

                                        $statistics_html .= '
                                        </tr>
                                    ';
                                
                            } // if($get_question_stats['options_attempts'])
                        
                        } // if($get_question_stats['question_id'] == 10)
            
                        $statistics_html .= '</table></div>';
						

                    } // end - if($question_id_download && $question_id_download != '')

                    // Ready response : encode response to json_array
                    $response[] = array('chart_data' => $chart_data, 'question' => $questions, 'statistics' => $statistics_html, 'below_contents' => $below_contents, 'comments' => $comments);
                    
                    } // foreach($all_questions as $get_question_stats)
                    
                    //Send response to ajax call
                    echo json_encode($response);
                
                } else {
                    echo json_encode(array('error' => true, 'message' => "No questions are founded."));
                } // if($survey_all_questions != '')
                
            } else {
                echo json_encode(array('error' => true, 'message' => "Wrong survey reference number is provided."));
            } // if($survey_ref_no != '')
            
        } // if($question_id != '') => => else if($pdf_download_all && $pdf_download_all == 1)
        
    } // End - // get_survey_graph_data():
    
    // Start - save_chart_as_pdf()
    public function save_chart_as_pdf(){

        if(isset($_POST['charts_html']) && $_POST['charts_html'] != '')
        {
            $file_name = 'Chart.pdf';
            //$html = '<div style="border: 3px solid green;">'. $_POST['charts_html']. '</div>';
            $html = $_POST['charts_html'];
         
            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->SetFooter($_POST['pharmacy_surgery_name_pdf_footer'].' - '.$_POST['pharmacy_surgery_address_pdf_footer'].' - '.$_POST['pharmacy_surgery_zip_pdf_footer'].'|{PAGENO}|'.date('D, d M y G:i:s')); // Add a footer for good measure 			
            
            $pdf->AddPage('L'); // L - P

            $pdf->WriteHTML($html); // write the HTML into the PDF
            
            $pdf->Output(str_replace(' ', '-', $_POST['pharmacy_surgery_name_pdf_footer']).'-Survey-'.date('Y').'.pdf','D'); // save to file because we can
        }//end 
        
    } // End - save_chart_as_pdf()
    
    /*--------------------------------- End Surveys Pie charts functions --------------------------------- */
    /* ----------------------------------------------------------------------------------------------------- */
    
    // Get Doctors and Pharmacist for signature search  search_doctor_pharmacist function 
    public function search_doctor_pharmacist(){
        
        //If Post is not SET
        if(!$this->input->post()) redirect(base_url());
        $usertype = $this->input->post('usertype');
        
        $data['list_default_users_search'] = $this->organization->search_doctor_pharmacist($this->input->post(),$this->my_organization_id);
    
        echo $this->load->view('organization/auto_search_doc_pharm',$data,true);
        
    }// end search_doctor_pharmacist();
    
        // Save Doctor and Pharmacist for signature  
    public function save_doctor_pharmacist(){
        
        //If Post is not SET
        if(!$this->input->post()) redirect(base_url());
        
        extract($this->input->post());
        // Send request to set default Doctor [ AND - OR ] default Pharmacist
        $response_pharmacy_doctor = $this->organization->save_doctor_pharmacist($this->input->post(), $this->my_organization_id);

        if($response_pharmacy_doctor)
            //$this->session->default_type = 
        
        // Send response to ajax call
        echo json_encode($response_pharmacy_doctor);
        
    }// end save_doctor_pharmacist();
    
     // Get Doctors and Pharmacist Prescriber  search_doctor_pharmacist_prescriber function 
    public function search_doctor_pharmacist_prescriber(){
        
        //If Post is not SET
        if(!$this->input->post()) redirect(base_url());
        
        $data['list_default_users_prescriber_search'] = $this->organization->search_doctor_pharmacist_prescriber($this->input->post(),$this->my_organization_id);
    
        echo $this->load->view('organization/auto_search_doc_pharm_prescriber',$data,true);
        
    }// end search_doctor_pharmacist_prescriber();
    
    
    // Save Prescriber  
    public function save_doctor_pharmacist_prescriber(){
        
        //If Post is not SET
        if(!$this->input->post()) redirect(base_url());
        
        // Send request to set default Prescriber 
        $response_prescriber = $this->organization->save_doctor_pharmacist_prescriber($this->input->post(), $this->my_organization_id);
        
        // Send response to ajax call
        echo json_encode($response_prescriber);
        
    }// end save_doctor_pharmacist_prescriber();
    
    // Start list_all_unauthenticate
    public function list_all_unauthenticate(){
		
		 // Bread crumb 
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 $this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 $this->breadcrumbcomponent->add('Unauthenticate PGDs', base_url().'list-all-unauthenticate');
		 
		 // Bread crumb output
		 $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        
        if($this->session->is_owner || $user_org_superintendent){
            $authenticate_organization_id = $this->my_organization_id;
            
        }else{
            $authenticate_organization_id = $this->session->organization_id;
        }//end if($this->session->is_owner || $user_org_superintendent)

        $get_default_doc_pharmacy = $this->organization->get_default_doctor_org($this->session->id, $authenticate_organization_id);
        // Unauthorized access
        if(($get_default_doc_pharmacy['default_doctor'] == $this->session->id) || ($get_default_doc_pharmacy['default_pharmacist'] == $this->session->id)){

            $list_unauthentcate_pgds = $this->pgds->get_all_unauthenticated_pgds($authenticate_organization_id,$this->session->user_type,$this->session->id);
            $response_signature = $this->users->get_user_signatures($this->session->id);
    
            $data['response_signature'] = $response_signature;
            $data['list_unauthentcate_pgds_data']  = $list_unauthentcate_pgds;
    
            //print_this($list_unauthentcate_pgds);
            $this->stencil->layout('dashboard_template'); //dashboard_template
    
            //set title
            //$page_title = $page_data['page_title'];
            	//set title
			$page_title = DEFAULT_TITLE;
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => DEFAULT_META_DESCRIPTION,
				'keywords' => DEFAULT_META_KEYWORDS,
				'meta_title' => DEFAULT_TITLE
			));
    
            // Datatables
            $this->stencil->js('datatables/js/jquery.dataTables.js');
            $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
    
            // Load custom file data_tables.js
            $this->stencil->js('kod_scripts/data_tables.js');
            $this->stencil->css('kod_css/jquery.dataTables.min.css');
            // Js Check All Box
            $this->stencil->js('org_dashboard.js');
            
            //load main Dashbaord template for DOCTOR
            $this->stencil->paint('organization/unauthenticate_listing',$data);			
        }else
            redirect(base_url().'organization/pharmacy-surgery');
            
    } // end list_all_unauthenticate

    
    // Prtocess unauthenticated_process()
    public function unauthenticated_process(){
    
    //If Post is not SET
        if(!$this->input->post() && !$this->input->post('pgd_unauthenticate_btn')) redirect(base_url());	

        if($this->session->is_owner || $user_org_superintendent){
            $authenticate_organization_id = $this->my_organization_id;
            
        }else{
            $authenticate_organization_id = $this->session->organization_id;
        }//end if($this->session->is_owner || $user_org_superintendent)

        $success = $this->pgds->unauthenticate_pgds($this->input->post(),$authenticate_organization_id,$this->session->user_type,$this->session->id);
        
        if($success) {
            
            $this->session->set_flashdata('ok_message', 'Authentication is  updated successfully.');
            redirect(SURL.'organization/list-all-unauthenticate');
            
        } else {
                
            $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
            redirect(SURL.'organization/list-all-unauthenticate');
            
        }
        
    }// End Prtocess unauthenticated_process()
    
    // Function Start settings_process_cqc();
    public function settings_process_cqc(){
    
        //If Post is not SET
        if(!$this->input->post() && !$this->input->post('save_cqc_btn')) redirect(base_url());	
        
        // return Success rocordd added in database
         $success = $this->organization->add_update_cqc($this->input->post(),$this->my_organization_id);
         
        if($success) {
        
			$this->session->set_flashdata('ok_message', 'CQC is  updated successfully.');
			redirect(SURL.'organization/settings');
        
         } else {
            
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
			redirect(SURL.'organization/settings');
        
        }// end else
                
    }//end settings_process_cqc()
    
    public function medicine_management(){
		
        if(!$this->allowed_user_menu['show_manage_medicine']) redirect(SURL.'organization/dashboard');
		
		// Bread crumb 
		 $this->breadcrumbcomponent->add('Home', base_url().'home');
		 $this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		 $this->breadcrumbcomponent->add('Medicine Management', base_url().' medicine-management');
		
		 // Bread crumb output
		 $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		 
		if($this->user_org_superintendent || $this->session->is_owner)
            $get_my_pharmacies_surgeries = $this->pharmacy->get_pharmacy_surgery_list($this->my_organization_id);
        else
            $get_my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries($this->session->id, 'M');
        
        $data['my_pharmacies_surgeries'] = $get_my_pharmacies_surgeries;
        
        if($this->input->post('pharmacy_surgery_id') || $this->session->pharmacy_surgery_id){
            
            if($this->session->pharmacy_surgery_id)
                $pharmacy_surgery_id = $this->session->pharmacy_surgery_id;
            else
                $pharmacy_surgery_id = trim($this->input->post('pharmacy_surgery_id'));
            // if($this->session->pharmacy_surgery_id)
        
            $get_pharmacy_surgery_medicine_arr = $this->pharmacy->get_pharmacy_surgery_medicine_list($pharmacy_surgery_id);
            $data['pharmacy_surgery_medicine_arr'] = $get_pharmacy_surgery_medicine_arr;
			
			// check embabed code if enabaled means 1 it will showing
		    $get_pharmacy_surgery_data = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
			$data['get_pharmacy_surgery_data'] = $get_pharmacy_surgery_data;

        } //end if($this->input->post('pharmacy_surgery_id') || $this->session->pharmacy_surgery_id)

		//Get Phramacy List for Publish/ Unpublish
		$get_pharamcy_surgery_list = $this->pharmacy->get_pharmacy_surgery_list($this->my_organization_id);
		$data['pharamcy_surgery_list'] = $get_pharamcy_surgery_list;

        // Js Form validation
        $this->stencil->js('kod_scripts/jquery.validate.js');
        $this->stencil->js('kod_scripts/custom_validate.js');

        $this->stencil->layout('dashboard_template'); //dashboard_template

        //set title
        //$page_title = $page_data['page_title'];
       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
        $this->stencil->js('org_dashboard.js');
        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');

        //load main Dashbaord template for DOCTOR
        $this->stencil->paint('organization/medicine_management',$data);
    
    } //end organization_medicine()
    
    public function update_pharmacy_medicine_process(){
        
		if(!$this->allowed_user_menu['show_manage_medicine']) redirect(SURL.'organization/dashboard');
		
        if(!$this->input->post() && !$this->input->post('pharmacy_surgery_id')) redirect(SURL);
        
        extract($this->input->post());
        
        $get_pharmacy_surgery_data = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
        
        if($get_pharmacy_surgery_data){
            
            $update_pharmacy_medicine = $this->pharmacy->update_pharmacy_medicines($pharmacy_surgery_id,$get_pharmacy_surgery_data['organization_id'],$this->input->post());
            
            if($update_pharmacy_medicine)
                echo 'Medicine Settings updated successfully.';
            else
                echo 'Oops! Something went wrong, please try again later';		
            
        }else{
            echo 'Oops! Something went wrong, please try again later';	
        }//end if($get_pharmacy_surgery_data)
        
    }//end update_pharmacy_medicine_process()

    // Start - public function get_invitation_data()
    public function get_invitation_data(){

        if(!$this->input->post()) redirect(SURL);

        $invitation_id = $this->input->post('invitation_id');
        $invitation_row = $this->invitations->get_invitation_details($invitation_id);

        // Send response to ajax call - Invitation details
        if($invitation_row)
            echo json_encode(array('error_status' => 0, 'row' => $invitation_row));
        else
            echo json_encode(array('error_status' => 1, 'row' => ''));
        // end - if($invitation_row)

    } // public function get_invitation_data()

    // Start - function get_my_org_pharmacies_surgeries() : Function to return the list of Pharmacies / Surgeries by [ user_id & organization_id ]
    public function get_my_org_pharmacies_surgeries(){

    	if(!$this->input->post()) redirect(SURL.'dashboard');

    	$pmr_org_pharmacy_arr = explode('|', $this->input->post('pmr_org_pharmacy'));

    	if($pmr_org_pharmacy_arr[0] == 'O'){
	
			//User is a default prescriber in an organization
			$organization_id = $pmr_org_pharmacy_arr[1];
			
			// Get list all pharmacies of this organization to which user belongs to
			$get_my_pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id, '', $organization_id );
			
		} //end if($pmr_org_pharmacy_arr[0] == 'O')

		// Send response to ajax call
		echo json_encode( array('organization_id' => $organization_id, 'my_pharmacies_surgeries' => $get_my_pharmacies_surgeries) );

    } // End - function get_my_org_pharmacies_surgeries()

    // Start - public function select_si_pharmacy_surgery($pharmacy_surgery_id='')
    public function select_si_pharmacy_surgery($pharmacy_surgery_id=''){

        // Verify if the pharmacy_surgery_id is not null : Update pharmacy_surgery_id
        if($pharmacy_surgery_id){

            // Set default cookie menu_item_number to My Dashboard
			set_cookie('menu_item_number','My Dashboard',time()+86500);

            $this->session->pharmacy_surgery_id = $pharmacy_surgery_id;
            $pharmacy_surgery = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
			
            $this->session->organization_id = $pharmacy_surgery['organization_id'];
			$this->session->organization_name = $pharmacy_surgery['organization_name'];
			
            // Verify if the user is a default prescriber of the organization.
            $get_default_prescriber_organization_list = $this->pmr->get_pmr_organization_pharmacy_list($this->session->id, $this->session->organization_id);
			
			$org_prescriber_index_key = array_search($this->session->organization_id, array_column($get_default_prescriber_organization_list['organization_list'], 'id'));

            /* Usman
            $index_key = array_search($this->session->organization_id, array_column($my_org_prescription_arr, 'id'));
            if(strlen($index_key) > 0){
                
                $this->session->pmr_org_pharmacy = 'O|'.$this->session->pmr_organization_id;

            } else {

                $this->session->pmr_org_pharmacy = 'P|'.$this->session->pmr_pharmacy_surgery_id;

            } // if(strlen($index_key) > 0)
            */
            if(strlen($org_prescriber_index_key) > 0){
				
				//User is a default prescriber in the selected organziation.

                // Set SESSIONS for PMR
                $this->session->pmr_pharmacy_surgery_id = $pharmacy_surgery_id;
                $this->session->pmr_organization_id = $pharmacy_surgery['organization_id'];

                $this->session->pmr_org_pharmacy = 'O|'.$this->session->pmr_organization_id;

            } else {

                $this->session->pmr_pharmacy_surgery_id = $pharmacy_surgery_id;
                $this->session->pmr_organization_id = $pharmacy_surgery['organization_id'];
                $this->session->pmr_org_pharmacy = 'P|'.$this->session->pmr_pharmacy_surgery_id.'|'.$this->session->pmr_organization_id;

            } // if($get_default_prescriber_organization_list){
            
        } // if($pharmacy_surgery_id)

         redirect(SURL.'organization/dashboard');
        //redirect($_SERVER['HTTP_REFERER']);

    } // End - public function select_si_pharmacy_surgery($pharmacy_surgery_id='')

    // Start - public save_pharmacy_survey()
    public function save_pharmacy_survey(){
		
		if(!$this->input->post('pharmacy_surgery_id')) redirect(SURL);
		
		extract($this->input->post());
		
		//Update Phamacy number of surveys in Pharamcy Global settings
		$update_pharmacy_surveys = $this->pharamcy->update_pharmacy_no_of_surveys($no_of_survey, $pharmacy_surgery_id);
		
		if($update_pharmacy_surveys)
			return true;
		else
			return false;	
		
	}//end save_pharmacy_survey()
	
    // Start - public function get_org_pharmacies_surgeries()
    public function get_org_pharmacies_surgeries(){

        if(!$this->input->post()) redirect(SURL.'dashboard');

        // Verify if loggedin user is superintendent or owner of the organization
        if($this->user_org_superintendent || $this->session->is_owner)
            $pharmacies_surgeries = $this->pharmacy->get_pharmacy_surgery_list( $this->input->post('organization_id') );
        else
            $pharmacies_surgeries = $this->pharmacy->get_my_pharmacies_surgeries( $this->session->id, '', $this->input->post('organization_id') );
        // if($user_org_superintendent || $is_owner)

        echo json_encode($pharmacies_surgeries);

    } // End - public function get_org_pharmacies_surgeries()

    // Start - public function remove_default_prescriber() : Function to remove the current set default prescriber of the organization
    public function remove_default_prescriber(){

        $removed = $this->organization->remove_default_prescriber($this->my_organization_id);
        if($removed){
            $this->session->set_flashdata('ok_message', 'Current default prescriber was successfully removed.');
        } else {
            $this->session->set_flashdata('err_message', 'Oops something went wrong! Please try again later..');
        } // if($removed)

        redirect(SURL.'organization/settings');

    } // End - public function remove_default_prescriber()

    /*--------------Test ------------- */
    public function pdf(){

        $file_name = 'Certiface.pdf';
        
        //$html = '<div style="border: 3px solid green;">'. $_POST['charts_html']. '</div>';
        $html = file_get_contents('http://localhost:8000/cbody/');
        
        /*
        $user_signatures = $this->users->get_user_signatures($this->session->id);

        if(filter_string($user_signatures['signature_type']) == 'svn')
            $signature_str = filter_string($user_signatures['signature']);
        elseif(filter_string($user_signatures['signature_type']) == 'image')
            $signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
        // if(filter_string($user_signatures['signature_type']) == 'svn')                                       
        
        $search_arr = array('[USER_SIGNATURE]');
        $replace_arr = array($signature_str);
        $html = str_replace($search_arr,$replace_arr,$html);
        
        //print_r($html);
        //exit;
        */

        $search_arr = array('[AUTHORIZATION_BODY]');
        $replace_arr = array('http://localhost:8000/projects/voyager-med/assets/org_stamp/thumb-authorized_stamp_16888.jpg');
        $html = str_replace($search_arr,$replace_arr,$html);

        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        //$pdf->SetFooter('123'.'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure            
        $pdf->AddPage('L'); // L - P

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can

    }
	
	public function comingsoon(){

		$cms_data_arr = $this->cms->get_cms_page('coming-soon');
		
		if($cms_data_arr['cms_page_count'] == 0){
			redirect(base_url().'page-not-found');
		} else {
			
			//set title
			$page_title = $cms_data_arr['cms_page_arr']['page_title'];
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => $cms_data_arr['cms_page_arr']['meta_description'],
				'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
				'meta_title' => $cms_data_arr['cms_page_arr']['meta_title']
			));
			
			$data['page_data'] = $cms_data_arr['cms_page_arr'];
			
		}//end if($cms_data_arr['cms_page_count'] == 0)

        // Load main template
        $this->stencil->layout('dashboard_template'); //dashboard_template
        $this->stencil->paint('organization/comingsoon',$data);
		
	}//end commingsoon()
	
	public function pharmacy_record(){
		
		//echo $this->session->pmr_pharmacy_surgery_id;

		if(!$this->allowed_user_menu['show_nhs_data']){
			$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
			redirect(SURL.'dashboard');
		}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
		
		$pmr_org_pharmacy_arr = explode('|', $this->session->pmr_org_pharmacy);

		if ($pmr_org_pharmacy_arr[0] == 'P') 
			$pharmacy_surgery_id = $pmr_org_pharmacy_arr[1];
		
		if($pharmacy_surgery_id){
		
			$pharmacy_data = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
			$data['pharmacy_data'] = $pharmacy_data;
		
		}//end if($this->session->pmr_pharmacy_surgery_id)
		
		$no_odc_message = $this->cms->get_cms_page('no-odc-code-message');
		$data['no_odc_message'] = $no_odc_message['cms_page_arr']; 
		
		// Bread crumb
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard',base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('NHS Data',base_url().'pharmacy-record');

		// Bread crumb output
  		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('pharmacy_record/pharmacy_record',$data);
		
	}//end pharmacy_record()
	
	public function website(){

		if(!$this->allowed_user_menu['show_nhs_data']){
			$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
			redirect(SURL.'dashboard');
		}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
		
		$pmr_org_pharmacy_arr = explode('|', $this->session->pmr_org_pharmacy);

		if ($pmr_org_pharmacy_arr[0] == 'P') 
			$pharmacy_surgery_id = $pmr_org_pharmacy_arr[1];
		
		if($pharmacy_surgery_id){
		
			$pharmacy_data = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_surgery_id);
			$data['pharmacy_data'] = $pharmacy_data;
		
		}//end if($this->session->pmr_pharmacy_surgery_id)
		
		$td_get_design_templates = td_get_design_templates();
		$td_get_design_templates = json_decode($td_get_design_templates);
		$data['templates'] = $td_get_design_templates;

		$td_get_package_list = td_get_package_list();
		$td_get_package_list = json_decode($td_get_package_list);
		$data['package_list'] = $td_get_package_list;
		
		$per_branch_price = json_decode(get_website_branch_price());
		$data['per_branch_price'] = $per_branch_price;
		
		$td_verify_if_pharmacy_already_purchased = json_decode(td_verify_if_pharmacy_already_purchased($pharmacy_surgery_id));
		//print_this($td_verify_if_pharmacy_already_purchased); exit;
		$data['verify_if_pharmacy_already_purchased'] = $td_verify_if_pharmacy_already_purchased;

		// Bread crumb
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard',base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('Website',base_url().'Website');

		// Bread crumb output
  		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$this->stencil->js('owl.carousel.js');
		$this->stencil->css('owl.carousel.css');
		$this->stencil->css('owl.theme.default.css');

       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('organization/website',$data);
	
	}
	public function website_payment(){
		
		if(!$this->input->post()) redirect(SURL.'organization/website');
		
		extract($this->input->post());
		
		if(!$this->input->post('tmp_id')){
			$this->session->set_flashdata('err_message', 'Please select the design for your website.');
			redirect(SURL.'organization/website');
		}//end if(!$this->input->post('tmp_id'))

		if(!$this->input->post('pkge_id') && strlen($this->input->post('pkge_id')) == 0){
			$this->session->set_flashdata('err_message', 'Please select the package for your website.');
			redirect(SURL.'organization/website');
		}//end if(!$this->input->post('tmp_id'))
		
		//Verify if the email address which is entered exist or not
		$td_verify_user_already_exist = td_verify_user_already_exist($email_address);
		$td_verify_user_already_exist = json_decode($td_verify_user_already_exist);
		
		if($td_verify_user_already_exist && !$is_renewal){

			$this->session->set_flashdata('err_message', "Pharmacy already registered with email address ($email_address). Please contact site admin.");
			redirect(SURL.'organization/website');
			
		}//end if($td_verify_user_already_exist && !$is_renewal)

		$data['countries'] = get_countries();
		
		$data['tmp_id'] = $tmp_id;
		$data['pkge_id'] = $pkge_id;

		$td_get_design_templates = td_get_design_templates($tmp_id);
		$td_get_design_templates = json_decode($td_get_design_templates);
		$td_get_design_templates->template_id;
		$data['selected_template'] = $td_get_design_templates;

		$td_get_package_list = td_get_package_list();
		$td_get_package_list = json_decode($td_get_package_list);

		$data['package_list'] = $td_get_package_list;
		
		require_once APPPATH."libraries/payzone/PaymentFormHelper.php";
		include APPPATH."libraries/payzone/Config.php";

		$lilExpiryDateMonthList = PaymentFormHelper::createExpiryDateMonthListItemList($ExpiryDateMonth);
		$lilExpiryDateYearList = PaymentFormHelper::createExpiryDateYearListItemList($ExpiryDateYear);
		$lilStartDateMonthList = PaymentFormHelper::createStartDateMonthListItemList($StartDateMonth);
		$lilStartDateYearList = PaymentFormHelper::createStartDateYearListItemList($StartDateYear);
		
		//$lilISOCountryList = PaymentFormHelper::createISOCountryListItemList($CountryShort, $iclISOCountryList);
		$data['lilExpiryDateMonthList'] = $lilExpiryDateMonthList->toString();
		$data['lilExpiryDateYearList'] = $lilExpiryDateYearList->toString();
		$data['lilStartDateMonthList'] = $lilStartDateMonthList->toString();
		$data['lilStartDateYearList'] = $lilStartDateYearList->toString();

		// Bread crumb
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard',base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('Website',base_url().'Website Payment');

		// Bread crumb output
  		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('organization/website_payment',$data);

	}//end website_payment()
	
	public function website_payment_process(){
		
		if(!$this->input->post()) exit;
		
		extract($this->input->post());
		
		$td_verify_user_already_exist = td_verify_user_already_exist($email_address);
		$td_verify_user_already_exist = json_decode($td_verify_user_already_exist);
		
		if($td_verify_user_already_exist && !$is_renewal){
			
			$this->session->set_flashdata('err_message', "Pharmacy already registered with email address ($email_address). Please contact site admin.");
			redirect(SURL.'organization/website');
			
		}else{

			$pharmacy_id = $this->session->pharmacy_surgery_id;
			$pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_id);
			
			$Address1 = filter_string($b_address);
			$Address2 = filter_string($b_address2);
			$Address3 = filter_string($b_address3);
			
			$City = filter_string($b_post_town);
			$State = filter_string($b_state);
			$PostCode = filter_string($b_postcode);
			
			$CountryShort = filter_string($b_country_code);
			
			$subtotal = '0.00';
			$shipping_cost = '0.00';
			$grand_total = '0.00';
	
			$td_get_design_templates = td_get_design_templates($tmp_id);
			$td_get_design_templates = json_decode($td_get_design_templates);
	
			$td_get_package_list = td_get_package_list();
			$td_get_package_list = json_decode($td_get_package_list);
	
			if($package_id == 1)
				$package_price = $td_get_package_list->standard->package_price;
			elseif($package_id == 2)
				$package_price = $td_get_package_list->premium->package_price;
			elseif($package_id == 3){
				$package_price = $td_get_package_list->multibranch->package_price;
				$per_branch_price = json_decode(get_website_branch_price());
				$branch_price = (float) $per_branch_price * (int) $no_of_branches;
				$package_price = $package_price + $branch_price;
			}elseif($package_id == 0)	
				$package_price = CUSTOM_PACKAGE_PRICE;
				
			// Package Price
			$price = $package_price ;
			
			// Sub total
			$sub_total = $package_price ;
			
			if($sub_total <= 0 ) redirect(SURL.'organization/website');
			
			// Calculate VAT amount
			$vat_percentage = 20;
			$vat_amount = ($vat_percentage / 100) * $sub_total;
			$vat_amount = filter_price($vat_amount);
			$vat_amount = ($vat_amount) ? $vat_amount : '0.00' ;
	
			// Calculate grand total
			$grand_total = $sub_total + $vat_amount;
			$grand_total = number_format($grand_total,2);
			
			$Amount = $grand_total * 100;
			
			require_once APPPATH."libraries/payzone/PaymentFormHelper.php";
			include APPPATH."libraries/payzone/Config.php";
			
			require_once APPPATH."libraries/payzone/ThePaymentGateway/PaymentSystem.php";
			include APPPATH."libraries/payzone/ISOCurrencies.php";
			include APPPATH."libraries/payzone/ISOCountries.php";
			
			$rgeplRequestGatewayEntryPointList = new RequestGatewayEntryPointList();
			// you need to put the correct gateway entry point urls in here
			// contact support to get the correct urls
			
			// The actual values to use for the entry points can be established in a number of ways
			// 1) By periodically issuing a call to GetGatewayEntryPoints
			// 2) By storing the values for the entry points returned with each transaction
			// 3) Speculatively firing transactions at https://gw1.xxx followed by gw2, gw3, gw4....
			// The lower the metric (2nd parameter) means that entry point will be attempted first,
			// EXCEPT if it is -1 - in this case that entry point will be skipped
			// NOTE: You do NOT have to add the entry points in any particular order - the list is sorted
			// by metric value before the transaction sumbitting process begins
			// The 3rd parameter is a retry attempt, so it is possible to try that entry point that number of times
			// before failing over onto the next entry point in the list
			$rgeplRequestGatewayEntryPointList->add("https://gw1.".$PaymentProcessorFullDomain, 100, 1);
			$rgeplRequestGatewayEntryPointList->add("https://gw2.".$PaymentProcessorFullDomain, 200, 1);
			$rgeplRequestGatewayEntryPointList->add("https://gw3.".$PaymentProcessorFullDomain, 300, 1);
			
			//echo $PaymentProcessorFullDomain; exit;
			$cdtCardDetailsTransaction = new CardDetailsTransaction($rgeplRequestGatewayEntryPointList);
			
			$cdtCardDetailsTransaction->getMerchantAuthentication()->setMerchantID($MerchantID);
			
			$cdtCardDetailsTransaction->getMerchantAuthentication()->setPassword($Password);
			
			$cdtCardDetailsTransaction->getTransactionDetails()->getMessageDetails()->setTransactionType("SALE");
			
			$cdtCardDetailsTransaction->getTransactionDetails()->getAmount()->setValue($Amount);
			
			$CurrencyShort = "GBP"; 
			
			if ($CurrencyShort != "" && $iclISOCurrencyList->getISOCurrency($CurrencyShort, $icISOCurrency))
				$cdtCardDetailsTransaction->getTransactionDetails()->getCurrencyCode()->setValue($icISOCurrency->getISOCode());
				//echo $DisplayAmount = $icISOCurrency->getAmountCurrencyString($Amount, false);
			
			//$OrderID = $prescription_no = $this->purchase->generate_prescription_no();	
			
			$OrderID = $prescription_no = 'INV-'.rand();
			
			$cdtCardDetailsTransaction->getTransactionDetails()->setOrderID($OrderID);
			$cdtCardDetailsTransaction->getTransactionDetails()->setOrderDescription("Techdevelopers Website Order for Pharmacy (".filter_string($pharmacy_details['pharmacy_surgery_name']).")");
			
			$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoCardType()->setValue(true);
			$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoAmountReceived()->setValue(true);
			$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoAVSCheckResult()->setValue(true);
			$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoCV2CheckResult()->setValue(true);
			$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getThreeDSecureOverridePolicy()->setValue(true);
			$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getDuplicateDelay()->setValue(60);
			
			$cdtCardDetailsTransaction->getTransactionDetails()->getThreeDSecureBrowserDetails()->getDeviceCategory()->setValue(0);
			$cdtCardDetailsTransaction->getTransactionDetails()->getThreeDSecureBrowserDetails()->setAcceptHeaders("*/*");
			$cdtCardDetailsTransaction->getTransactionDetails()->getThreeDSecureBrowserDetails()->setUserAgent($_SERVER["HTTP_USER_AGENT"]);
			
			$cdtCardDetailsTransaction->getCardDetails()->setCardName($CardName);
			$cdtCardDetailsTransaction->getCardDetails()->setCardNumber($CardNumber);
			
			if ($ExpiryDateMonth != "")
				$cdtCardDetailsTransaction->getCardDetails()->getExpiryDate()->getMonth()->setValue($ExpiryDateMonth);
			
			if ($ExpiryDateYear != "")
				$cdtCardDetailsTransaction->getCardDetails()->getExpiryDate()->getYear()->setValue($ExpiryDateYear);
	
			if ($StartDateMonth != "")
				$cdtCardDetailsTransaction->getCardDetails()->getStartDate()->getMonth()->setValue($StartDateMonth);
	
			if ($StartDateYear != "")
				$cdtCardDetailsTransaction->getCardDetails()->getStartDate()->getYear()->setValue($StartDateYear);
			
			$cdtCardDetailsTransaction->getCardDetails()->setIssueNumber($IssueNumber);
			$cdtCardDetailsTransaction->getCardDetails()->setCV2($CV2);
			
			$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress1('32 Edward Street'); //$Address1 '32 Edward Street'
			$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress2('Camborne'); //$Address2 'Camborne'
			$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress3($Address3);
			$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress4($Address4);
			$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setCity('Cornwall'); //$City 'Cornwall'
			$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setState($State);
			$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setPostCode('TR148PA'); //$PostCode  'TR148PA'
			
			if ($CountryShort != "" && $CountryShort != "-1" && $iclISOCountryList->getISOCountry($CountryShort, $icISOCountry))
			{
				$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->getCountryCode()->setValue($icISOCountry->getISOCode());
			}
			
			$cdtCardDetailsTransaction->getCustomerDetails()->setEmailAddress($this->session->email_address);
			$cdtCardDetailsTransaction->getCustomerDetails()->setPhoneNumber($this->session->mobile_no);
			//$cdtCardDetailsTransaction->getCustomerDetails()->setCustomerIPAddress($_SERVER["REMOTE_ADDR"]);
			$cdtCardDetailsTransaction->getCustomerDetails()->setCustomerIPAddress('127.0.0.1');
			
			//echo $_SERVER["REMOTE_ADDR"];
			
			$boTransactionProcessed = $cdtCardDetailsTransaction->processTransaction($cdtrCardDetailsTransactionResult, $todTransactionOutputData);
			
			if($boTransactionProcessed == false){
				
				// could not communicate with the payment gateway 
				
				$Message = "Couldn't communicate with payment gateway";
				PaymentFormHelper::reportTransactionResults($OrderID, 30, $Message, null);
			
				$this->session->set_flashdata('err_message', "Error: Couldn't communicate with payment gateway");
				redirect(SURL.'organization/website');
				
			}else{
				
				switch($cdtrCardDetailsTransactionResult->getStatusCode()){
					
					case 0:
						// status code of 0 - means transaction successful 
						$Message = $cdtrCardDetailsTransactionResult->getMessage();
						
						$AuthCode = $todTransactionOutputData->getAuthCode();
						$CrossReference = $todTransactionOutputData->getCrossReference();
						
						$TransactionSuccessful = true;
						PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $todTransactionOutputData->getCrossReference());
						
						$add_website_to_order = td_add_website_to_order($this->session->id, $pharmacy_id, $this->input->post(), $sub_total, $grand_total, $vat_amount, $vat_percentage, $CrossReference, $AuthCode, 'CARD');
						
						$decode_website_to_order = json_decode($add_website_to_order);
						
						if($decode_website_to_order->success){
							
							$this->session->set_flashdata('ok_message', 'Congratulations! Your Order is successfully completed. Please check your email for order receipt!');
							redirect(SURL.'organization/website');
							
						}else{
	
							$this->session->set_flashdata('err_message', $decode_website_to_order->err_message);
							redirect(SURL.'organization/website');
							
						}//end if($add_to_order)
						
						break;
						
					case 3:
						// status code of 3 - means 3D Secure authentication required 
						$PaREQ = $todTransactionOutputData->getThreeDSecureOutputData()->getPaREQ();
						$CrossReference = $todTransactionOutputData->getCrossReference();
						$BodyAttributes = " onload=\"document.Form.submit();\"";
						$FormAttributes = " target=\"ACSFrame\"";
						$FormAction = $todTransactionOutputData->getThreeDSecureOutputData()->getACSURL();
						PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $todTransactionOutputData->getCrossReference());
			
						$this->session->set_flashdata('err_message', "Error: Couldn't communicate with payment gateway");
						redirect(SURL.'organization/website');
						
						break;
						
					case 5:
						// status code of 5 - means transaction declined 
						$Message = $cdtrCardDetailsTransactionResult->getMessage();
						$TransactionSuccessful = false;
						PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $todTransactionOutputData->getCrossReference());
			
						$this->session->set_flashdata('err_message', "Error: $Message");
						redirect(SURL.'organization/website');
						
						break;
					case 20:
						// status code of 20 - means duplicate transaction 
			
						$Message = $cdtrCardDetailsTransactionResult->getMessage();
						if ($cdtrCardDetailsTransactionResult->getPreviousTransactionResult()->getStatusCode()->getValue() == 0)
							$TransactionSuccessful = true;
						else
							$TransactionSuccessful = false;
						
						$PreviousTransactionMessage = $cdtrCardDetailsTransactionResult->getPreviousTransactionResult()->getMessage();
						$DuplicateTransaction = true;
						
						PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getPreviousTransactionResult()->getStatusCode()->getValue(), $PreviousTransactionMessage, $todTransactionOutputData->getCrossReference());
			
						$this->session->set_flashdata('err_message', "Error: $Message");
						redirect(SURL.'organization/website');
						
						break;
						
					case 30:
						// status code of 30 - means an error occurred 
						$NextFormMode = "PAYMENT_FORM";
						$Message = $cdtrCardDetailsTransactionResult->getMessage();
						
						if ($cdtrCardDetailsTransactionResult->getErrorMessages()->getCount() > 0){
							
							$Message = $Message."<br /><ul>";
			
							for ($LoopIndex = 0; $LoopIndex < $cdtrCardDetailsTransactionResult->getErrorMessages()->getCount(); $LoopIndex++)
								$Message = $Message."<li>".$cdtrCardDetailsTransactionResult->getErrorMessages()->getAt($LoopIndex)."</li>";
			
							$Message = $Message."</ul>";
							$TransactionSuccessful = false;
			
						}//end if ($cdtrCardDetailsTransactionResult->getErrorMessages()->getCount() > 0)
						
						if ($todTransactionOutputData == null)
							$szResponseCrossReference = "";
						else
							$szResponseCrossReference = $todTransactionOutputData->getCrossReference();
			
						PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $szResponseCrossReference);
			
						$this->session->set_flashdata('err_message', "Error: $Message");
						redirect(SURL.'organization/website');
						
						break;
						
					default:
						// unhandled status code  
						$Message = $cdtrCardDetailsTransactionResult->getMessage();
						if ($todTransactionOutputData == null)
							$szResponseCrossReference = "";
						else
							$szResponseCrossReference = $todTransactionOutputData->getCrossReference();
			
						PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $szResponseCrossReference);
			
						$this->session->set_flashdata('err_message', "Error: $Message");
						redirect(SURL.'organization/website');
						
						break;
				}//end switch ($cdtrCardDetailsTransactionResult->getStatusCode()
			
			}//end if($boTransactionProcessed == false)
				
		}//end if($td_verify_user_already_exist)
		
	}//end website_payment_process()
	
    public function website_paypal_process(){

		if(!$this->input->post()) exit;
		
		extract($this->input->post());
		
		$td_verify_user_already_exist = td_verify_user_already_exist($email_address);
		$td_verify_user_already_exist = json_decode($td_verify_user_already_exist);
		
		if($td_verify_user_already_exist){
			
			$email = $this->session->email_address;
			
			$this->session->set_flashdata('err_message', "Pharmacy already registered with email address ($email). Please contact site admin.");
			redirect(SURL.'organization/website');
			
		}else{
			
			$pharmacy_id = $this->session->pharmacy_surgery_id;
			$pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($pharmacy_id);
			
			$subtotal = '0.00';
			$shipping_cost = '0.00';
			$grand_total = '0.00';
	
			$td_get_design_templates = td_get_design_templates($template_id);
			$td_get_design_templates = json_decode($td_get_design_templates);
			
			$template_name = $td_get_design_templates->template_id;
			
			//print_this($td_get_design_templates); 			exit;
			
	
			$td_get_package_list = td_get_package_list();
			$td_get_package_list = json_decode($td_get_package_list);
			
			if($package_id == 1){
				$package_price = $td_get_package_list->standard->package_price;
				$package_name = 'STANDARD';
			}elseif($package_id == 2){
				$package_price = $td_get_package_list->premium->package_price;
				$package_name = 'PREMIUM';
			}elseif($package_id == 3){
				$package_price = $td_get_package_list->multibranch->package_price;
				$per_branch_price = json_decode(get_website_branch_price());
				$branch_price = (float) $per_branch_price * (int) $no_of_branches;
				$package_price = $package_price + $branch_price;
				
				$package_name = 'MULTIBRANCH';
			}elseif($package_id == 0)
				$package_price = CUSTOM_PACKAGE_PRICE;
				
			// Package Price
			$price = $package_price ;
			
			// Sub total
			$sub_total = $package_price ;
			
			if($sub_total <= 0 ) redirect(SURL.'organization/website');
			
			// Calculate VAT amount
			$vat_percentage = 20;
			$vat_amount = ($vat_percentage / 100) * $sub_total;
			$vat_amount = filter_price($vat_amount);
			$vat_amount = ($vat_amount) ? $vat_amount : '0.00' ;
	
			// Calculate grand total
			$grand_total = $sub_total + $vat_amount;
			$grand_total = number_format($grand_total,2);
			
			$product_description = $package_name.' Pharmacy Website. Template ID: '.$template_name.' inc VAT';
			
			$to_buy = array(
				'currency' => CURRENCY, 
				'type' => PAYMENT_METHOD, 
				'return_URL' => SURL.'organization/website-paypal-checkout-success/'.$pharmacy_id.'/'.$package_id.'/'.$template_id.'/'.urlencode(base64_encode($email_address)).'/'.$no_of_branches, 
				// see below have a function for this -- function back()
				// whatever you use, make sure the URL is live and can process
				// the next steps
				'cancel_URL' => SURL.'organization/website', // this goes to this controllers index()
				'shipping_amount' => 0.00, 
				'get_shipping' => false
			);
			
			$to_buy['desc'] = $product_description;
			
			$temp_product = array(
				'name' => $product_description, 
				'desc' => $product_description, 
				'number' => 'WEB_'.$pharmacy_id, 
				'quantity' => 1, 
				'amount' => $sub_total
			);
				
			// add product to main $to_buy array
			$to_buy['products'][] = $temp_product;

			$vat_percentage = 20;
			
			$vat_amount = (trim($vat_percentage) / 100) * $sub_total;
			$vat_amount = filter_price($vat_amount);
			
			$to_buy['tax_amount'] = $vat_amount;
			//$to_buy['tax_amount'] = '2';
			
			// enquire Paypal API for token
			$set_ec_return = $this->paypal_ec->set_ec($to_buy);
			
			if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
				// redirect to Paypal
				$this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
				
			} else {
				$this->_error($set_ec_return);
				
			}//end if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) 
	
		}//end if($td_verify_user_already_exist)
        
    }//end single_product_checkout()
    
    public function website_paypal_checkout_success($pharmacy_id, $package_id, $template_id, $email_address, $no_of_branches){
        
        $token = $_GET['token'];
        $payer_id = $_GET['PayerID'];
        
        $get_ec_return = $this->paypal_ec->get_ec($token);

        if(isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
            // at this point, you have all of the data for the transaction.
            // you may want to save the data for future action. what's left to
            // do is to collect the money -- you do that by call DoExpressCheckoutPayment
            // via $this->paypal_ec->do_ec();
            //
            // I suggest to save all of the details of the transaction. You get all that
            // in $get_ec_return array
            $ec_details = array(
                'token' => $token, 
                'payer_id' => $payer_id, 
                'currency' => 'GBP', 
                'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
                'IPN_URL' => site_url('dashboard/ipn'), 
                // in case you want to log the IPN, and you
                // may have to in case of Pending transaction
                'type' => PAYMENT_METHOD);
                
            // DoExpressCheckoutPayment
            $do_ec_return = $this->paypal_ec->do_ec($ec_details);
			
            if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
                
                // at this point, you have collected payment from your customer
                // you may want to process the order now.

                if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] = 'Success'){
                    
					$post_data['template_id'] = $template_id;
					$post_data['package_id'] = $package_id;
					$post_data['no_of_branches'] = $no_of_branches;
					$email_address = base64_decode(urldecode($email_address));
					$post_data['email_address'] = $email_address;
					
					$vat_percentage = 20;
					
                    $data['num_of_products'] = 1;
					
					$sub_total = $get_ec_return['ITEMAMT'];
					$vat_amount = $get_ec_return['TAXAMT'];
					$grand_total = $get_ec_return['AMT'];
					$vat_percentage = '20';
					$paypal_transaction_id = $do_ec_return['PAYMENTINFO_0_TRANSACTIONID'];

					$td_verify_user_already_exist = td_verify_user_already_exist($email_address);
					$td_verify_user_already_exist = json_decode($td_verify_user_already_exist);
					
					if($td_verify_user_already_exist){

						$this->session->set_flashdata('err_message', "Pharmacy already registered with email address ($email_address). Please contact site admin.");
						redirect(SURL.'organization/website');
						
					}else{

						$add_website_to_order = td_add_website_to_order($this->session->id, $pharmacy_id, $post_data, $sub_total, $grand_total, $vat_amount, $vat_percentage, $paypal_transaction_id, '', 'PAYPAL');
						
						$decode_website_to_order = json_decode($add_website_to_order);
						
						//print_this($decode_website_to_order);
						
						if($decode_website_to_order->success){
							
							//Custom Message set from admin site prefrences
							$paypal_success = 'Congratulations! You have successfully purchased your items, please check your email for the purchase receipt. Thank You!';
							$this->session->set_flashdata('paypal_success', $paypal_success);
							redirect(SURL.'organization/website');
	
						}else{
							
							//echo "i am unseccessful"; exit;
							$this->session->set_flashdata('err_message', $decode_website_to_order->err_message);
							redirect(SURL.'organization/website');
							
						}//end if($add_purchase_status)
						
					}//end if($td_verify_user_already_exist)
                    
                }else{

						$this->session->set_flashdata('err_message', 'Something went wrong, please contact site admin');
						redirect(SURL.'organization/website');

                }//end if($get_ec_return['ACK'] == 'Success' && $do_ec_return['ACK'] = 'Success')
                
            } else {
                
                $this->_error($do_ec_return);
                
            }
        } else {
            $this->_error($get_ec_return);
        }
        
    }//end website_paypal_checkout_success()
	
	public function website_avicenna(){

		if(!$this->input->post()) redirect(SURL.'organization/website');
		
		extract($this->input->post());

		if(!$this->input->post('tmp_id')){
			$this->session->set_flashdata('err_message', 'Please select the design for your website.');
			redirect(SURL.'organization/website');
		}//end if(!$this->input->post('tmp_id'))
		
		$td_verify_user_already_exist = td_verify_user_already_exist($email_address);
		$td_verify_user_already_exist = json_decode($td_verify_user_already_exist);
		
		if($td_verify_user_already_exist && !$is_renewal){

			$email = $this->session->email_address;
			
			$this->session->set_flashdata('err_message', "Pharmacy already registered with email address ($email). Please contact site admin.");
			redirect(SURL.'organization/website');
			
		}else{

			$pharmacy_id = $this->session->pharmacy_surgery_id;
			
			$add_website_to_order = td_add_avicenna_website_to_order($this->session->id, $pharmacy_id, $this->input->post(), 0.00, 0.00, 0.00, 0, '', '', 'AVICENNA');
			
			$decode_website_to_order = json_decode($add_website_to_order);
			
			if($decode_website_to_order->success){
				
				$this->session->set_flashdata('ok_message', 'Congratulations! Your Website details sent to the technical team.');
				redirect(SURL.'organization/website');
				
			}else{
	
				$this->session->set_flashdata('err_message', $decode_website_to_order->err_message);
				redirect(SURL.'organization/website');
				
			}//end if($add_to_order)
			
		}//end if($td_verify_user_already_exist && !$is_renewal)
		
	}//end website_avicenna()
	
	
	public function update_package_pricing(){
		
		if(!$this->input->post()) exit;
		
		extract($this->input->post());
	
		$td_get_package_list = td_get_package_list();
		$td_get_package_list = json_decode($td_get_package_list);
	
		if($package_id == 1)
			$package_price = $td_get_package_list->standard->package_price;
		elseif($package_id == 2)
			$package_price = $td_get_package_list->premium->package_price;
		elseif($package_id == 3){
			$package_price = $td_get_package_list->multibranch->package_price;
			$per_branch_price = json_decode(get_website_branch_price());
			$branch_price = (float) $per_branch_price * (int) $no_of_branches;
			$package_price = $package_price + $branch_price;
		}elseif($package_id == 0)	
			$package_price = CUSTOM_PACKAGE_PRICE;
			
		// Package Price
		$price = ($package_price) ? $package_price : '0.00' ;
		
		// Sub total
		$sub_total = ($package_price) ? $package_price : '0.00' ;
		
		// Calculate VAT amount
		$vat_percentage = 20;
		$vat_amount = ($vat_percentage / 100) * $sub_total;
		$vat_amount = filter_price($vat_amount);
		$vat_amount = ($vat_amount) ? $vat_amount : '0.00' ;
		
		// Calculate grand total
		$grand_total = $sub_total + $vat_amount;
		$grand_total = number_format($grand_total,2);
	
		$data['package_price'] = $package_price;
		$data['sub_total'] = $sub_total;
		$data['grand_total'] = $grand_total;
		$data['vat_amount'] = $vat_amount;
		$data['success'] = 1;
		
		echo json_encode($data);
		
	}//end update_package_pricing()
	
	public function edit_organization(){
		
		$this->load->model('country_mod','country');
		
		$organization_id = $this->session->organization['id'];
		$organization_details = $this->organization->get_organization_details($organization_id);
		$data['organization_details'] = $organization_details;
		
		//Active Organization Country List
		$country_active_arr = $this->country->get_active_countries();
		$data['country_active_arr'] = $country_active_arr;
        
        //$this->stencil->js('org_dashboard.js');
        $this->stencil->js('kod_scripts/custom.js');


        // Load main template
        $this->stencil->layout('pharmacy_settings'); //dashboard_template
        $this->stencil->paint('organization/edit_organization',$data);
		
	}//end send_website_settings()
	
	public function edit_organization_process(){
		
		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		$edit_organization_process = $this->organization->edit_organization($this->session->organization_id,$this->input->post());
		
		if($edit_organization_process){
			
			$this->session->userdata['organization']['company_name'] = $company_name;
			$this->session->userdata['organization']['address'] = $org_address;
			$this->session->userdata['organization']['postcode'] = $org_postcode;
			$this->session->userdata['organization']['contact_no'] = $org_contact;
			$this->session->userdata['organization']['country_id'] = $org_country;
			
			$this->session->set_flashdata('ok_message', 'Organisation details successfully updated.');
			redirect(SURL.'organization/dashboard');
			
		}else{
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'organization/dashboard');
			
		}//end if($send_pharmacy_website_info_notification)
		
	}//end edit_organization_process()

	public function import_pharmacy_list(){
		
		set_time_limit(0);
		
		if($_FILES['import_file']['name'] != ''){

			$media_location  = './assets/csv/';

			$extension = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);
			
			if($extension == 'csv'){
			
				$file_name = $this->session->organization_id.'-import.csv';
				$destination_path = $media_location.$file_name;
				
				$copy_status = copy($_FILES['import_file']['tmp_name'],$destination_path);
				
				if($copy_status){
					
					$this->load->library('CSVReader');
					
					//$pharmacy_data = $this->pharmacy->import_pharmacy( $_FILES );
					$pharmacy_data =  $this->csvreader->parse_file(CSV.$file_name);
					
					//print_this($pharmacy_data); exit;
					
					$new_pharmacy_arr = array();
					$already_exists_pharmacy_arr = array();
					
					 for($i=1; $i<=count($pharmacy_data); $i++){
						 
						$LocationPostcode = str_replace(' ','',$pharmacy_data[$i]['LocationPostcode']);
						
						if(filter_string($pharmacy_data[$i]['LocationName']) == '') break;
						 
						$pharmacy_already_exist = $this->pharmacy->get_pharmacy_by_name_postcode($this->session->organization['id'], $pharmacy_data[$i]['LocationName'], $LocationPostcode);
						 
						if($pharmacy_already_exist)
							$already_exists_pharmacy_arr[] = $pharmacy_data[$i];
						else
							$new_pharmacy_arr[] = $pharmacy_data[$i];
						
					 }//end for($i=1; $i<=count($pharmacy_data); $i++)
					 
					$data_table['new_pharmacy_arr'] = $new_pharmacy_arr;
					$data_table['new_pharmacy_encode'] = json_encode($new_pharmacy_arr);
					$data_table['exist_pharmacy_arr'] = $already_exists_pharmacy_arr;

					$data['error'] = 0;
					
					$this->stencil->layout('ajax'); //ajax
					$pharmacy_list = $this->load->view('organization/import_pharmacy',$data_table,true);
					$data['pharmacy_list'] = $pharmacy_list;
					
				}else{
					$data['error'] = 1;
					$data['error_message'] = 'Something went wrong while uploading the file';
				}
				
			}else{
				$data['error'] = 1;
				$data['error_message'] = 'Wrong or invalid file extension';
			}
			
			echo json_encode($data);
			
		}//end if($_FILES['import_file']['name'] != '')
		
	}//end import_pharmacy_list()
	
	public function import_pharmacy_process(){
		
		if(!$this->input->post('new_pharmacy_encode')) redirect(SURL.'organization/dashboard');
		
		extract($this->input->post());
		
		$new_pharmacy_arr =  json_decode($new_pharmacy_encode);
		
		$import_pharmacies = $this->pharmacy->import_new_pharmacies($this->session->organization['id'], $new_pharmacy_arr);
		
		if($import_pharmacies){

			$this->session->set_flashdata('ok_message', 'New pharmacies successfully imported.');
			redirect(SURL.'organization/dashboard');
			
		}else{
			$this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
			redirect(SURL.'organization/dashboard');
			
		}//end if($import_pharmacies)
		
	}//end import_pharmacy_process()
	
	public function dismiss_message(){
		
		if(!$this->input->post()) exit;
		
		extract($this->input->post());
		
		$dismiss_message = $this->organization->dismiss_message($this->input->post());
		
		if($dismiss_message){
			
			$dismiss_messages = $this->organization->dismiss_message_list($organization_id);
			
			$dismiss_messages_arr = array();
			
			for($i=0;$i<count($dismiss_messages);$i++){
				
				if($dismiss_messages[$i]['pharmacy_id'] == NULL || !$dismiss_messages[$i]['pharmacy_id'])
					$dismiss_messages_arr['dismiss_message'][$dismiss_messages[$i]['message_type']] = 1;
					
				else
					$dismiss_messages_arr['dismiss_message'][$dismiss_messages[$i]['pharmacy_id']][$dismiss_messages[$i]['message_type']] = 1;
				
			}//end for($i=0;$i<count($dismiss_messages);$i++)
			
			$this->session->set_userdata($dismiss_messages_arr);
			
		}//end if($dismiss_message)
		
		//if($dismiss_message)
		
	}//end dismiss_message()
	
	public function travel_clinic(){
		
        //load main template [ Dashbaord ]
        $this->stencil->layout('travel_clinic_full_width');

        // Load view
        $this->stencil->paint('organization/travel_clinic',$data);
		
		
	}//end travel_clinic()
	
	//Function update_provide_delivery(): This fucntion is used for enabling/ disable the Onlin Delivery options from the embed side
	public function update_provide_delivery(){
		
		extract($this->input->post());

		$this->session->organization['id'];
		$this->session->pharmacy_surgery_id;
		
		$update_provide_delivery = $this->organization->update_provide_delivery($this->session->organization['id'], $this->session->pharmacy_surgery_id, $provide_delivery);
		return true;
		
	}//end update_provide_delivery()
	
} // End - CI_Controller /* End of file */