<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registers extends MY_Organization_Controller {

	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->model('Register_entry_mod','registers_entry');
		$this->load->model('Pharmacy_mod','pharmacy');

		//This section is allowed to those who have passed the governance and the status is active for pharmacy from admin 	
		if(!$this->allowed_user_menu['show_register']){			
			$this->session->set_flashdata('err_message', 'You are not authorised to access this page.');
			redirect(SURL.'dashboard');
		}//end if($this->show_teambuilder && !$get_user_details['enable_register'])
		
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
	
	

	// Start => function index()
	public function index($drug_id = '', $page_no = ''){
		
		if($this->input->post('drug_hidden_id') !="") {
			
		 	$drug_id_select_box = $this->input->post('drug_hidden_id');
		 	$data['drug_id_select_box'] = $drug_id_select_box;
			
		} else {
			
			if($drug_id != ''){

				$drug_id_select_box = $drug_id;
				$data['drug_id_select_box'] = $drug_id_select_box;
				
			}else{

				$drug_id_select_box = $this->registers_entry->get_drug_last_id($this->session->id,$this->session->pharmacy_surgery_id);
				$data['get_drug_last_id'] = $drug_id_select_box;
				$drug_id_select_box = $drug_id_select_box['id'];
				
			}//end if($drug_id != '')
			
		}//end if($this->input->post('drug_hidden_id') !="") 

		
		if($this->input->post('drug_hidden_id_cd_return') !="") {
			
			 $data['active_tab'] = $this->input->post('tab_id');
			
		 	$drug_id_cd_return_select_box = $this->input->post('drug_hidden_id_cd_return');
		 	$data['drug_id_cd_return_select_box'] = $drug_id_cd_return_select_box;
			
		} else {
		
		  	$drug_id_cd_return_select_box = $this->registers_entry->get_drug_cd_return_last_id($this->session->id,$this->session->pharmacy_surgery_id);
			$data['get_cd_return_last_id'] = $drug_id_cd_return_select_box;
			$drug_id_cd_return_select_box = $drug_id_cd_return_select_box['id'];
		}
		
		// Bread crumb 
		$this->breadcrumbcomponent->add('Home', base_url().'home');
		$this->breadcrumbcomponent->add('Organisation Dashboard', base_url().'organization/dashboard');
		$this->breadcrumbcomponent->add('Registers', base_url().'organization/dashboard');
		 
		// Bread crumb output
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		if($this->session->flashdata('drug_id') !=''){
			 $drug_id_select_box = $this->session->flashdata('drug_id'); 
		}
		
		$this->load->library('pagination');

		//START: Pagintion for Register Enteries Controlled Drug

		$count_list_register_all_entery = $this->registers_entry->list_register_all_entery($this->session->id,$this->session->pharmacy_surgery_id,$drug_id_select_box);

		$limit_reg = 10;
		$limit_pom = 10;
		$limit_sp = 10;
		$limit_em = 10;
		$limit_cd = 10;
		
		
		if(!$this->input->get('t') || $this->input->get('t') == '1'){
			$page_reg = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$config_reg["uri_segment"] = 3;
		}else{
			$page_reg = 0;
			$config_reg["uri_segment"] = 10;
		}
		
		$list_register_all_entery = $this->registers_entry->list_register_all_entery($this->session->id,$this->session->pharmacy_surgery_id,$drug_id_select_box, $limit_reg, $page_reg);
		$data['list_register_all_entery'] = $list_register_all_entery;
		$data['total_register_all_entery'] = count($count_list_register_all_entery);
		
		$config_reg['suffix'] = '?t=1';
		
		$config_reg['base_url'] = SURL.'registers/'.$drug_id_select_box;
		$config_reg['total_rows'] = count($count_list_register_all_entery);
		
		$config_reg['per_page'] = $limit_reg;
		
		$config_reg['reuse_query_string'] = FALSE;
		
		$config_reg['first_url'] = $config_reg['base_url'].'?t=1';
		
		$config_reg['full_tag_open'] = '<ul class="pagination" style="margin: 9px 6px 4px 0px">';
		$config_reg['full_tag_close'] = '</ul> ';
		
		$config_reg['last_tag_open'] = '<li>';
		$config_reg['last_tag_close'] = '</li>';

		$config_reg['first_tag_open'] = '<li>';
		$config_reg['first_tag_close'] = '</li>';
		
		$config_reg['next_link'] = '&gt;';
		$config_reg['next_tag_open'] = '<li>';
		$config_reg['next_tag_close'] = '</li>';
		
		$config_reg['prev_link'] = '&lt;';
		$config_reg['prev_tag_open'] = '<li>';
		$config_reg['prev_tag_close'] = '</li>';
		
		$config_reg['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config_reg['cur_tag_close'] = '</a></li>';
		
		$config_reg['num_tag_open'] = '<li>';
		$config_reg['num_tag_close'] = '</li>';

		$this->pagination->initialize($config_reg);
		$limit_reg = $config_reg['per_page'];

		$data['pagination_links_reg'] = $this->pagination->create_links();
		
		//END: Pagintion for Register Enteries Controlled Drug
		
		$list_all_drug = $this->registers_entry->list_all_drug($this->session->id,$tab_id,$this->session->pharmacy_surgery_id);
		$data['list_all_drug'] = $list_all_drug;
		
		//START: Pagintion POM Enteries 
		
		$count_list_all_pom_private_entry = $this->registers_entry->list_all_pom_private_entry($this->session->id,$this->session->pharmacy_surgery_id);
		//$data['list_all_pom_private_entry'] = $list_all_pom_private_entry;
		
		if($this->input->get('t') == '3'){
			$page_pom = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$config_pom["uri_segment"] = 2;
		}else{
			$page_pom = 0;
			$config_pom["uri_segment"] = 10;
		}
		
		$list_all_pom_private_entry = $this->registers_entry->list_all_pom_private_entry($this->session->id,$this->session->pharmacy_surgery_id, $limit_pom, $page_pom);
		$data['list_all_pom_private_entry'] = $list_all_pom_private_entry;
		
		$config_pom['suffix'] = '?t=3';
		
		$config_pom['base_url'] = SURL.'registers';
		$config_pom['total_rows'] = count($count_list_all_pom_private_entry);
		
		$config_pom['per_page'] = $limit_pom;
		
		$config_pom['reuse_query_string'] = FALSE;
		
		$config_pom['first_url'] = $config_pom['base_url'].'?t=3';
		
		$config_pom['full_tag_open'] = '<ul class="pagination" style="margin: 9px 6px 4px 0px">';
		$config_pom['full_tag_close'] = '</ul> ';
		
		$config_pom['last_tag_open'] = '<li>';
		$config_pom['last_tag_close'] = '</li>';

		$config_pom['first_tag_open'] = '<li>';
		$config_pom['first_tag_close'] = '</li>';
		
		$config_pom['next_link'] = '&gt;';
		$config_pom['next_tag_open'] = '<li>';
		$config_pom['next_tag_close'] = '</li>';
		
		$config_pom['prev_link'] = '&lt;';
		$config_pom['prev_tag_open'] = '<li>';
		$config_pom['prev_tag_close'] = '</li>';
		
		$config_pom['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config_pom['cur_tag_close'] = '</a></li>';
		
		$config_pom['num_tag_open'] = '<li>';
		$config_pom['num_tag_close'] = '</li>';

		$this->pagination->initialize($config_pom);
		$limit_pom = $config_pom['per_page'];

		$data['pagination_links_pom'] = $this->pagination->create_links();
			
		
		//END: Pagintion POM Enteries 
		
		//START: Pagintion Special Enteries 
		
		$count_list_all_special = $this->registers_entry->list_all_special($this->session->id,$this->session->pharmacy_surgery_id);
		
		if($this->input->get('t') == '4'){
			$page_sp = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$config_sp["uri_segment"] = 2;
		}else{
			$page_sp = 0;
			$config_sp["uri_segment"] = 10;
		}
		
		$list_all_special = $this->registers_entry->list_all_special($this->session->id,$this->session->pharmacy_surgery_id, $limit_sp, $page_sp);
		$data['list_all_special'] = $list_all_special;
		
		$config_sp['suffix'] = '?t=4';
		
		$config_sp['base_url'] = SURL.'registers';
		$config_sp['total_rows'] = count($count_list_all_special);
		
		$config_sp['per_page'] = $limit_sp;
		
		$config_sp['reuse_query_string'] = FALSE;
		
		$config_sp['first_url'] = $config_sp['base_url'].'?t=4';
		
		$config_sp['full_tag_open'] = '<ul class="pagination" style="margin: 9px 6px 4px 0px">';
		$config_sp['full_tag_close'] = '</ul> ';
		
		$config_sp['last_tag_open'] = '<li>';
		$config_sp['last_tag_close'] = '</li>';

		$config_sp['first_tag_open'] = '<li>';
		$config_sp['first_tag_close'] = '</li>';
		
		$config_sp['next_link'] = '&gt;';
		$config_sp['next_tag_open'] = '<li>';
		$config_sp['next_tag_close'] = '</li>';
		
		$config_sp['prev_link'] = '&lt;';
		$config_sp['prev_tag_open'] = '<li>';
		$config_sp['prev_tag_close'] = '</li>';
		
		$config_sp['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config_sp['cur_tag_close'] = '</a></li>';
		
		$config_sp['num_tag_open'] = '<li>';
		$config_sp['num_tag_close'] = '</li>';

		$this->pagination->initialize($config_sp);
		$limit_sp = $config_sp['per_page'];

		$data['pagination_links_sp'] = $this->pagination->create_links();
			
		
		//END: Pagintion Special Enteries 

		//START: Pagintion Emergency Supplies Enteries 

		$count_list_all_emergency_supply = $this->registers_entry->list_all_emergency_supply($this->session->id,$this->session->pharmacy_surgery_id);

		if($this->input->get('t') == '5'){
			$page_em = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$config_em["uri_segment"] = 2;
		}else{
			$page_em = 0;
			$config_em["uri_segment"] = 10;
		}
		
		$list_all_emergency_supply = $this->registers_entry->list_all_emergency_supply($this->session->id,$this->session->pharmacy_surgery_id, $limit_em, $page_em);
		$data['list_all_emergency_supply'] = $list_all_emergency_supply;
		
		$config_em['suffix'] = '?t=5';
		
		$config_em['base_url'] = SURL.'registers';
		$config_em['total_rows'] = count($count_list_all_emergency_supply);
		
		$config_em['per_page'] = $limit_sp;
		
		$config_em['reuse_query_string'] = FALSE;
		
		$config_em['first_url'] = $config_em['base_url'].'?t=5';
		
		$config_em['full_tag_open'] = '<ul class="pagination" style="margin: 9px 6px 4px 0px">';
		$config_em['full_tag_close'] = '</ul> ';
		
		$config_em['last_tag_open'] = '<li>';
		$config_em['last_tag_close'] = '</li>';

		$config_em['first_tag_open'] = '<li>';
		$config_em['first_tag_close'] = '</li>';
		
		$config_em['next_link'] = '&gt;';
		$config_em['next_tag_open'] = '<li>';
		$config_em['next_tag_close'] = '</li>';
		
		$config_em['prev_link'] = '&lt;';
		$config_em['prev_tag_open'] = '<li>';
		$config_em['prev_tag_close'] = '</li>';
		
		$config_em['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config_em['cur_tag_close'] = '</a></li>';
		
		$config_em['num_tag_open'] = '<li>';
		$config_em['num_tag_close'] = '</li>';

		$this->pagination->initialize($config_em);
		$limit_em = $config_em['per_page'];

		$data['pagination_links_em'] = $this->pagination->create_links();
			
		
		//END: Pagintion Emergency Supplies Enteries 
		
		$list_all_drug_tab_2 = $this->registers_entry->list_all_drug_tab_2($this->session->id,$tab_id,$this->session->pharmacy_surgery_id);
		$data['list_all_drug_tab_2'] = $list_all_drug_tab_2;
		
		
		if($this->session->flashdata('drug_id_cd_return') !=''){
			 $drug_id_cd_return_select_box = $this->session->flashdata('drug_id_cd_return'); 
		}
		

		//START: Pagintion for Pagintion for CD Rerurn

		$count_list_cd_return = $this->registers_entry->list_cd_return($this->session->id,$this->session->pharmacy_surgery_id,$drug_id_cd_return_select_box);
		
		if($this->input->get('t') == '2'){
			$page_cd = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$config_cd["uri_segment"] = 3;
		}else{
			$page_cd = 0;
			$config_cd["uri_segment"] = 10;
		}//end if($this->input->get('t') == '2')

		$list_cd_return = $this->registers_entry->list_cd_return($this->session->id,$this->session->pharmacy_surgery_id,$drug_id_cd_return_select_box, $limit_cd, $page_cd);
		$data['list_cd_return'] = $list_cd_return;

		$config_cd['suffix'] = '?t=2';
		
		$config_cd['base_url'] = SURL.'registers/'.$drug_id_select_box;
		$config_cd['total_rows'] = count($count_list_cd_return);
		
		$config_cd['per_page'] = $limit_cd;
		$config_cd['reuse_query_string'] = FALSE;
		
		$config_cd['first_url'] = $config_reg['base_url'].'?t=2';
		
		$config_cd['full_tag_open'] = '<ul class="pagination" style="margin: 9px 6px 4px 0px">';
		$config_cd['full_tag_close'] = '</ul> ';
		
		$config_cd['last_tag_open'] = '<li>';
		$config_cd['last_tag_close'] = '</li>';

		$config_cd['first_tag_open'] = '<li>';
		$config_cd['first_tag_close'] = '</li>';
		
		$config_cd['next_link'] = '&gt;';
		$config_cd['next_tag_open'] = '<li>';
		$config_cd['next_tag_close'] = '</li>';
		
		$config_cd['prev_link'] = '&lt;';
		$config_cd['prev_tag_open'] = '<li>';
		$config_cd['prev_tag_close'] = '</li>';
		
		$config_cd['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config_cd['cur_tag_close'] = '</a></li>';
		
		$config_cd['num_tag_open'] = '<li>';
		$config_cd['num_tag_close'] = '</li>';

		$this->pagination->initialize($config_cd);
		$limit_cd= $config_cd['per_page'];

		$data['pagination_links_cd'] = $this->pagination->create_links();
		
		//END: Pagintion for CD Rerurn
		
       	//set title
		$page_title = DEFAULT_TITLE;
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => DEFAULT_META_DESCRIPTION,
			'keywords' => DEFAULT_META_KEYWORDS,
			'meta_title' => DEFAULT_TITLE
		));
        
        // Include dataTables js and css
		// here
		
		$this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
		   
        //load main template [ Dashbaord ]
        $this->stencil->layout('dashboard_template');

        // Load view
        $this->stencil->paint('registers/registers',$data);

	} // End => function index()
	
	// Start => add_edit_entry()
	public function add_edit_entry($tab_id ='', $drug_id_select_box = ''){
		
		if($drug_id_select_box !=''){
			
		 $data['drug_id_select_box'] = $drug_id_select_box;
		}
		
		$data['list_supplier'] = $this->registers_entry->list_supplier($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_prescriber'] = $this->registers_entry->list_prescriber($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_patient'] = $this->registers_entry->list_patient($this->session->id,$this->session->pharmacy_surgery_id);
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_entry',$data);
	} // End - public function add_edit_entry()
	
	// Start => add_edit_cd_return()
	public function add_edit_cd_return($tab_id ='', $drug_id_cd_return_select_box = ''){
		
		if($drug_id_cd_return_select_box !=''){
			
		  $data['drug_id_cd_return_select_box'] = $drug_id_cd_return_select_box;
		}
		
		$data['list_witness'] = $this->registers_entry->list_witness($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_patient'] = $this->registers_entry->list_patient($this->session->id,$this->session->pharmacy_surgery_id);
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_cd_return_destruction',$data);
	} // End - public function add_edit_cd_return()
	
	// Start => add_edit_registers()
	public function add_edit_registers($tab_id =''){
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_registers',$data);
	} // End - public function add_edit_registers()
	
	
	// Start => add_edit_supplier()
	public function add_edit_supplier(){
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_supplier',$data);
	} // End - public function add_edit_supplier()
	
	// Start => add_edit_prescriber()
	public function add_edit_prescriber(){
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_prescriber',$data);
	} // End - public function add_edit_prescriber()
	
	// Start => add_edit_patient()
	public function add_edit_patient(){
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_patient',$data);
	} // End - public function add_edit_patient()
	
	
	
	// Start => add_edit_witness()
	public function add_edit_witness(){
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_witness',$data);
	} // End - public function add_edit_witness()
	
	// Start => check_balance()
	public function check_balance($tab_id = '',  $drug_id =''){
		
		if($drug_id !=''){
			$data['get_drug_balance'] = $this->registers_entry->get_drug_balance($tab_id, $drug_id, $this->session->pharmacy_surgery_id);
		}
		$data['tab_id'] =$tab_id;
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/check_balance',$data);
	} // End - public function check_balance()
	
	
	// Add  drug process
	public function add_edit_drug_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
				
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_drug = $this->registers_entry->add_edit_drug($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'registers?t='.$tab_id);
			}
    
            if($add_edit_drug){
    
                $this->session->set_flashdata('ok_message', 'Medicine added successfully.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_suppliers)
       
    }//end clinical_diary_process()
	
	// Add  supplier process
	public function add_edit_supplier_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
				
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_suppliers = $this->registers_entry->add_edit_suppliers($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                  redirect(SURL.'registers?t='.$tab_id);
			}
           
    
            if($add_edit_suppliers){
    
                $this->session->set_flashdata('ok_message', 'Supplier added successfully.');
               redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_suppliers)
       
    }//end clinical_diary_process()
	
	
	// Add  precriber process
	public function add_edit_prescriber_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
				
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_prescriber = $this->registers_entry->add_edit_prescriber($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                  redirect(SURL.'registers?t='.$tab_id);
			}
           
    
            if($add_edit_prescriber){
    
                $this->session->set_flashdata('ok_message', 'Prescriber added successfully.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'registers');
    
            }//end if($add_edit_prescriber)
       
    }//end add_edit_prescriber()
	
	// Start Function add_edd_patient_process
	public function add_edit_patient_process(){

		if(!$this->input->post() && !$this->input->post('add_update_btn')) redirect(base_url());
		
		extract($this->input->post());
		
	    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('postcode', 'Post Code', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('birth_date', 'Day', 'trim|required');
		$this->form_validation->set_rules('birth_month', 'Month', 'trim|required');
		$this->form_validation->set_rules('birth_year', 'Year', 'trim|required');			
		if($this->form_validation->run() == FALSE){
			
			// session set form data in fields
			$this->session->set_flashdata($this->input->post());
			// PHP Error 
			$this->session->set_flashdata('err_message', validation_errors());
			   redirect(SURL.'registers?t='.$tab_id);
			
		} else {
			
			$add_edit_success_patient = $this->registers_entry->add_edit_patients($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());

			// add_edit_success_patient
			if($add_edit_success_patient){
	
				if($this->input->post('update_patient_id')){
	
					$this->session->set_flashdata('ok_message', 'Patient record was successfully updated.');
					  redirect(SURL.'registers?t='.$tab_id);		
	
				} else {
	
					$this->session->set_flashdata('ok_message', 'Patient added successfully.');
					 redirect(SURL.'registers?t='.$tab_id);
	
				} // if($this->input->post('update_patient_id'))
	
			} else {
	
				$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
				  redirect(SURL.'registers?t='.$tab_id);
	
			} // End else - if($add_edit_success_patient)
		}
		
	} // add_edd_patient_process()
	
	
	// Add  prescriber process
	public function add_edit_register_entery_process(){

        if(!$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
				
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_register_entery = $this->registers_entry->add_edit_register_entery($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
				 
				 $this->session->set_flashdata('drug_id',$drug_id);
                 redirect(SURL.'registers?t='.$tab_id);
			}
    
            if($add_edit_register_entery){
    
                 $this->session->set_flashdata('drug_id',$drug_id);
				$this->session->set_flashdata('ok_message', 'Record added successfully.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('drug_id',$drug_id);
			    $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_register_entery)
       
    }//end add_edit_supplier_process()
	
	// Add  check balance process
	public function add_edit_check_balance_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_check_balance= $this->registers_entry->update_drug_balance($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				if($tab_id == 1) {
					$this->session->set_flashdata('drug_id',$drug_id);
				} else if($tab_id == 2){
					$this->session->set_flashdata('drug_id_cd_return',$drug_id);
				}
				
				 
				  $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                  redirect(SURL.'registers?t='.$tab_id);
			}
           
    
            if($add_edit_check_balance){
				
			
				if($tab_id == 1) {
					$this->session->set_flashdata('drug_id',$drug_id);
				} else if($tab_id == 2){
					$this->session->set_flashdata('drug_id_cd_return',$drug_id);
				}                
				 $this->session->set_flashdata('ok_message', 'Quantity added successfully.');
                 redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
				 if($tab_id == 1) {
					$this->session->set_flashdata('drug_id',$drug_id);
				  } else if($tab_id == 2){
					$this->session->set_flashdata('drug_id_cd_return',$drug_id);
				 }
                  $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                  redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_suppliers)
       
    }//end clinical_diary_process()
	
	
	// Start => add_edit_pom_private_entry()
	public function add_edit_pom_private_entry($tab_id =''){
		
		$data['list_patient']    = $this->registers_entry->list_patient($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_prescriber'] = $this->registers_entry->list_prescriber($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_all_drug']   = $this->registers_entry->list_all_drug($this->session->id,$tab_id,$this->session->pharmacy_surgery_id);
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_pom_private_entry',$data);
	} // End - public function add_edit_pom_private_entry()
	
	
	// Add  check balance process
	public function add_edit_pom_private_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_check_balance= $this->registers_entry->add_edit_pom_private_entry($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'registers?t='.$tab_id);
			}
           
    
            if($add_edit_check_balance){
    
                $this->session->set_flashdata('ok_message', 'Record  added successfully.');
               redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
               redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_suppliers)
       
    }//end clinical_diary_process()
	
	
	// Start => add_edit_special()
	public function add_edit_special($tab_id =''){
		
		$data['list_patient']    = $this->registers_entry->list_patient($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_all_drug']   = $this->registers_entry->list_all_drug($this->session->id,$tab_id,$this->session->pharmacy_surgery_id);
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_special',$data);
	} // End - public function add_edit_special()
	
	
	// Add  check balance process
	public function add_edit_special_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_check_balance= $this->registers_entry->add_edit_special($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                 redirect(SURL.'registers?t='.$tab_id);
			}
           
    
            if($add_edit_check_balance){
    
                $this->session->set_flashdata('ok_message', 'Record  added successfully.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_suppliers)
       
    }//end clinical_diary_process()
	
	
		// Start => add_edit_emergency_supply()
	public function add_edit_emergency_supply($tab_id =''){
		
		$data['list_patient']    = $this->registers_entry->list_patient($this->session->id,$this->session->pharmacy_surgery_id);
		$data['list_all_drug']   = $this->registers_entry->list_all_drug($this->session->id,$tab_id,$this->session->pharmacy_surgery_id);
		
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('registers/add_edit_emergency_supply',$data);
	} // End - public function add_edit_emergency_supply()
	
	
	// Add  emergency supply process
	public function add_edit_emergency_supply_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_emergency_supply= $this->registers_entry->add_edit_emergency_supply($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                  redirect(SURL.'registers?t='.$tab_id);
			}
    
            if($add_edit_emergency_supply){
    
                $this->session->set_flashdata('ok_message', 'Record  added successfully.');
                 redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_emergency_supply)
       
    }//end add_edit_emergency_supply_process()
	
	
	// Add  witness process
	public function add_edit_witness_process(){
		

        if( !$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
				
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_witness = $this->registers_entry->add_edit_witness($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
                  redirect(SURL.'registers?t='.$tab_id);
			}
           
    
            if($add_edit_witness){
    
                $this->session->set_flashdata('ok_message', 'Witness added successfully.');
               redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
                $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                 redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_suppliers)
       
    }//end add_edit_witness_process()
	
	
	 // Start - public function view_supply_reason()
	public function view_supply_reason($id = ''){
		
		if($id !=''){
			
			$get_supply_reason_details = $this->registers_entry->get_supply_reason_details($id,$this->session->pharmacy_surgery_id);
		    $data['supply_reason_details'] = $get_supply_reason_details;
		}
		
		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template');
		$this->stencil->paint('registers/supply_reason_details',$data);

	} // End - public function view_supply_reason()
	
	
	// Add  cd return process
	public function add_edit_return_process(){

        if(!$this->input->post() && !$this->input->post('add_update_btn')) redirect(SURL.'dashboard');
        
            extract($this->input->post());
				
			
			// Pharmacy id not empty 
			if($this->session->pharmacy_surgery_id !=''){
			    
            	 $add_edit_cd_return = $this->registers_entry->add_edit_cd_return($this->session->id,$this->session->pharmacy_surgery_id,$this->input->post());
				
			} else {
				
				 $this->session->set_flashdata('err_message', 'Please select pharmacy / surgery.');
				 
				$this->session->set_flashdata('drug_id_cd_return',$drug_id);
                 redirect(SURL.'registers?t='.$tab_id);
			}
    
            if($add_edit_cd_return){
    
                $this->session->set_flashdata('drug_id_cd_return',$drug_id);
				$this->session->set_flashdata('ok_message', 'Record added successfully.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }else{
    
               $this->session->set_flashdata('drug_id_cd_return',$drug_id);
			    $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
                redirect(SURL.'registers?t='.$tab_id);
    
            }//end if($add_edit_register_entery)
       
    }//end add_edit_return_process()
	
	
    // Start => function common_pdf()
	public function common_pdf($tab_id = '', $drug_id =''){

		
		if($tab_id ==1){
		
		  	 $data['list_register_all_entery'] = $this->registers_entry->list_register_all_entery($this->session->id,$this->session->pharmacy_surgery_id, $drug_id);
			
		} else if($tab_id ==2){
		
		 	 $data['list_cd_return'] = $this->registers_entry->list_cd_return($this->session->id,$this->session->pharmacy_surgery_id,$drug_id);
			
		} else if($tab_id ==3) {
			
			 $data['list_all_pom_private_entry'] = $this->registers_entry->list_all_pom_private_entry($this->session->id,$this->session->pharmacy_surgery_id);
		}  else if($tab_id ==4) {
			
			 $data['list_all_special'] = $this->registers_entry->list_all_special($this->session->id,$this->session->pharmacy_surgery_id);
		
		} else if($tab_id ==5) {
		
			$data['list_all_emergency_supply'] = $this->registers_entry->list_all_emergency_supply($this->session->id,$this->session->pharmacy_surgery_id);
		
		}
		
		$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details($this->session->pharmacy_surgery_id);
		$data['pharmacy_details'] = $get_pharmacy_details;
		
		$data['tab_id'] = $tab_id;

		$file_name = 'registers.pdf';

		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		
		$html = $this->load->view('registers/common_pdf',$data,true);

        $pdf->SetFooter('Voyager Medical'.'|{PAGENO}|'.date('D d, M Y G:i:s')); // Add a footer for good measure            
        $pdf->AddPage('L'); // L - P

        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($file_name,'D'); // save to file because we can

	} // Start => function download_pdf_practice_leaf_pdf()
	
	
	 // Start - public function view_check_balance_reason()
	public function view_check_balance_reason($id = ''){
		
		if($id !=''){
			
			$get_check_balance_details = $this->registers_entry->get_check_balance_reason_details($id,$this->session->pharmacy_surgery_id);
		    $data['get_check_balance_details'] = $get_check_balance_details;
		}

		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template');
		$this->stencil->paint('registers/check_balance_reason_details',$data);

	} // End - public function view_check_balance_reason()
	
	 // Start - public function view_check_balance_cd_reason()
	public function view_check_balance_cd_reason($id = ''){
		
		if($id !=''){
			
			$get_check_balance_cd_reason_details = $this->registers_entry->get_check_balance_cd_reason_details($id,$this->session->pharmacy_surgery_id);
		    $data['get_check_balance_cd_reason_details'] = $get_check_balance_cd_reason_details;
		}

		
		 //load main template
		$this->stencil->layout('pgd_detail_ajax_template');
		$this->stencil->paint('registers/check_balance_cd_return_reason_details',$data);

	} // End - public function view_check_balance_cd_reason()
	
	// Start - function search_patient()
	public function search_patient(){

		// Verify : is valid request
		if(!$this->input->post())
			redirect(SURL.'dashboard');
		// if($this->input->post())

		$search_query = $this->input->post('search_query');

		$response = $this->registers_entry->search_patient($search_query, $this->session->pharmacy_surgery_id);
		if($response)
			echo json_encode($response);
		else
			echo 'empty';
		// if($response)

	} // End - function search_patient()
	
	// Start - function search_prescriber()
	public function search_prescriber(){
		
		// Verify : is valid request
		if(!$this->input->post())
			redirect(SURL.'dashboard');
		// if($this->input->post())

		$search_query = $this->input->post('search_query');
		$response = $this->registers_entry->search_prescriber($search_query, $this->session->pharmacy_surgery_id);
		if($response)
			echo json_encode($response);
		else
			echo 'empty';
		// if($response)

	} // End - function search_prescriber()
	
	
	// Start - function search_supplier()
	public function search_supplier(){
		
		// Verify : is valid request
		if(!$this->input->post())
			redirect(SURL.'dashboard');
		// if($this->input->post())

		$search_query = $this->input->post('search_query');
		$response = $this->registers_entry->search_supplier($search_query, $this->session->pharmacy_surgery_id);
		if($response)
			echo json_encode($response);
		else
			echo 'empty';
		// if($response)

	} // End - function search_supplier()
	
	
	// Start - function search_witness()
	public function search_witness(){
		
		// Verify : is valid request
		if(!$this->input->post())
			redirect(SURL.'dashboard');
		// if($this->input->post())

		$search_query = $this->input->post('search_query');
		$response = $this->registers_entry->search_witness($search_query, $this->session->pharmacy_surgery_id);
		if($response)
			echo json_encode($response);
		else
			echo 'empty';
		// if($response)

	} // End - function search_witness()
	
	// Start - function search_medicine()
	public function search_medicine(){
		
		// Verify : is valid request
		if(!$this->input->post())
			redirect(SURL.'dashboard');
		// if($this->input->post())

		$search_query = $this->input->post('search_query');
		$tab_id = $this->input->post('tab_id');
		$response = $this->registers_entry->search_medinice($search_query, $tab_id, $this->session->pharmacy_surgery_id);
		if($response)
			echo json_encode($response);
		else
			echo 'empty';
		// if($response)

	} // End - function search_medicine()
	
	public function update_archive_status(){
		
		$update_archieve_registers = $this->registers_entry->update_archieve_registers($this->session->id, $this->session->pharmacy_surgery_id, $this->input->post());
		
		if($update_archieve_registers)
			$this->session->set_flashdata('ok_message', 'Archive Registers updated successfully.');
		else
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
		
		redirect(SURL.'registers?t=6');
		
	}//end update_archive_status()
	
}/* End of file */