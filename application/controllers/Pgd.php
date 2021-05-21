<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pgd extends MY_Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();

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
	}

	public function index($pgd_id){
		
		redirect(SURL.'dashboard');
		
	} //end index()

	//Function  pgd_detail() // Open PGD detail in Fancy Box
	public function pgd_info($pgd_id){
		
		//Loading PGD details
		$pgd_detail_arr = $this->pgds->get_pgd_details($pgd_id);
		
		//If the course does not found, redirect to 404 page
		if(!$pgd_detail_arr){
			redirect(SURL.'dashboard');
		}else{
			$data['pgd_detail_arr'] = $pgd_detail_arr;
		}//end if(!$pgd_detail_arr)
		
		//set title
		$page_title = $pgd_detail_arr['meta_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $pgd_detail_arr['meta_description'],
			'keywords' => $pgd_detail_arr['meta_keywords'],
			'meta_title' => $pgd_detail_arr['meta_title']
		));

		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('pgd/pgd_info',$data);
		
	} //end index()
	
	public function package_info($package_id){
		
		//$package_id = 1 -. Standard 2 = Premium
		if($package_id == 1)
			$cms_data_arr = $this->cms->get_cms_page('standard-oral-pgd-package-popup');
		else if($package_id == 2)
			$cms_data_arr = $this->cms->get_cms_page('premium-oral-pgd-package-popup');
		
		$data['cms_data_arr'] = $cms_data_arr['cms_page_arr'];
		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('pgd/package_info',$data);
		
	} //end index()

	//Function pgd_certificate(): Video Detail Page shown after the PGD is Paid.
	public function pgd_certificate($pgd_id){
		
		//Verify if user is allowed to see this PGD page or not. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);

		if(!$pgd_access_allowed){
			redirect(SURL.'dashboard');	
		}else{
			
			//Get PGD Purchased Records
			$data['pgd_access_allowed'] = $pgd_access_allowed;

			//Check if there is any previous session available to resume.
			$chk_previous_quiz_session = $this->pgds->previous_quiz_session($this->session->id,$pgd_id);
			$data['chk_previous_quiz_session'] = $chk_previous_quiz_session;
			
			//Calculate the previous attempt duration
			$last_quiz_hour = 0; 
			$current_date_hour = 0;

			$last_quiz_date = new DateTime($pgd_access_allowed['last_quiz_date']);
			$current_date = new DateTime(date('Y-m-d G:i:s'));
			$interval = $last_quiz_date->diff($current_date);
			 
			if($interval->format('%a') > 0)
				$last_quiz_hour = $interval->format('%a')*24;
			
			if($interval->format('%h') > 0)
				$current_date_hour = $interval->format('%h');
			
			//Total Hours passed since last quiz attempted.
 			$total_hours_passed = $last_quiz_hour + $current_date_hour;
			$data['total_hours_passed'] = $total_hours_passed;

			//Get PGD Contents
			$pgd_detail_arr = $this->pgds->get_pgd_details($pgd_id);
			$data['pgd_detail_arr'] = $pgd_detail_arr;

			//Get Video List
			$video_list_arr = $this->pgds->get_pgd_videos_list($pgd_id);
			$data['video_list_arr'] = $video_list_arr;
			
			//Get Document List
			$document_list_arr = $this->pgds->get_pgd_documents($pgd_id);
			$data['document_list_arr'] = $document_list_arr;

			//Get PGD RAF's
			$pgd_raf_list_arr = $this->pgds->get_pgd_rafs_list($pgd_id);
			$data['pgd_raf_list_arr'] = $pgd_raf_list_arr;

			//Get PGD Sub PGDs
			$pgd_subpgds_list_arr = $this->pgds->get_pgd_subpgds_list($pgd_id);
			$data['pgd_subpgds_list_arr'] = $pgd_subpgds_list_arr;

			//Get PGD Review
			$get_pgd_reviews_list = $this->purchase->get_product_reviews('PGD',$pgd_id);			
			$data['get_pgd_reviews_list'] = $get_pgd_reviews_list;
			
			
		}//end if($training_access_allowed == 0)
		
		$order_item_details = $this->purchase->get_order_item_details('', $pgd_id, 'PGD', $this->session->id);
		
		//echo count($order_item_details); exit;
		
		//If rechas is must and user have not given the rechas yet, get the rechas of pgd from database.
		if(filter_string($pgd_access_allowed['is_rechas_agreed']) == 0 && filter_string($pgd_detail_arr['is_rechas']) == 1){
			
			$pgd_rechas_list_arr = $this->pgds->get_pgd_rechas_list($pgd_id);
			$data['pgd_rechas_list_arr'] = $pgd_rechas_list_arr;

			$order_item_details = $this->purchase->get_order_item_details('', $pgd_id, 'PGD', $this->session->id);
			
			$data['renew'] = 0; //It will only be 1 if its a pgd package and it has more than one purchases.

			if(count($order_item_details) > 1 && ($pgd_detail_arr['pgd_type'] == 'O' || $pgd_detail_arr['pgd_type'] == 'OP')){
				
				$sorted_order_item_details = array_sort_by_column($order_item_details, 'id', SORT_ASC); //sorting to ASC so that the latest purchases is in the end.

				//Verifying if in the previus purchase the user has cleared the exam of this PGD. If it is not, we need to ask for the New Rechas and also need to give an exam.
				//Check previous purchase details

				$previous_order_item_details = $sorted_order_item_details[count($sorted_order_item_details)-2];
				
				//Now verify if user has cleared the exam in previous purchase
				
				if($previous_order_item_details['is_quiz_passed'] == '1' && $previous_order_item_details['doctor_approval'] == '1' && $previous_order_item_details['pharmacist_approval'] == '1'){
					
					//Means User did cleared the exam and got the doc and pharmacist approval. Dont' ask the exam and showo repeat rechas
	
					//If more than 1 purchase and if the PDG is in a package ask the rechas of Renew Type.
					$pgd_rechas_list_arr = $this->pgds->get_pgd_rechas_list($pgd_id,'renew');
					$data['renew'] = '1';
					
				}else{
					$pgd_rechas_list_arr = $this->pgds->get_pgd_rechas_list($pgd_id); //If first purchase or in previous rechas exam was not cleated
				}
				
			}else
				$pgd_rechas_list_arr = $this->pgds->get_pgd_rechas_list($pgd_id); //If first purchase.. or the PGD is a Vaccine and not in any package.
			
			$data['pgd_rechas_list_arr'] = $pgd_rechas_list_arr;

		}//end if

		//Tree View Script
		$this->stencil->js('bootstrap-treeview.js');

		//Video Slider Script
		$this->stencil->js('owl.carousel.js');
		$this->stencil->css('owl.carousel.css');
		$this->stencil->css('owl.theme.css');
		$this->stencil->css('owl.demo.css');
		$this->stencil->css('star-rating.css');
		

		//Fancybox Files and Scripts
		$this->stencil->css('jquery.fancybox.css');
		$this->stencil->js('jquery.fancybox.js');
		$this->stencil->js('jquery.mousewheel-3.0.6.pack.js');
		$this->stencil->js('source/helpers/jquery.fancybox-media.js?v=1.0.6.js');
		
		$this->stencil->js('star-rating.js');
		$this->stencil->js('pgds.js');
		
        $this->stencil->js('org_dashboard.js');
		
		//set title
		$page_title = $pgd_detail_arr['meta_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $pgd_detail_arr['meta_description'],
			'keywords' => $pgd_detail_arr['meta_keywords'],
			'meta_title' => $pgd_detail_arr['meta_title']
		));

		$bread_crum .= "<ol class='breadcrumb'>";
		$bread_crum .= "<li><a href='".SURL."home'>Home</a> </li>";
		$bread_crum .= "<li><a href='".SURL."dashboard'>Dashboard</a> </li>";
		$bread_crum .= "<li class='active'>".filter_string($pgd_detail_arr['pgd_name'])."</li>";

		$bread_crum .= "</ol>";
		
		$data['bread_crum'] = $bread_crum;
			
		//load main template
		$this->stencil->layout('dashboard_template'); //pgd_page_template
		$this->stencil->paint('pgd/pgd_certificate',$data);
		
	} //end pgd_certificate()
	
	public function pgd_rechas($pgd_id){

		//Loading PGD details
		$pgd_detail_arr = $this->pgds->get_pgd_details($pgd_id);
		$data['pgd_detail_arr'] = $pgd_detail_arr;
		
		//If the course does not found, redirect to 404 page
		if(!$pgd_detail_arr)
			echo 'Unauthorized Access';
		
		$data['pgd_detail_arr'] = $pgd_detail_arr;
		
		$order_item_details = $this->purchase->get_order_item_details('', $pgd_id, 'PGD', $this->session->id);

		$data['renew'] = 0; //It will only be 1 if its a pgd package and it has more than one purchases.
		
		
		if(count($order_item_details) > 1 && ($pgd_detail_arr['pgd_type'] == 'O' || $pgd_detail_arr['pgd_type'] == 'OP')){
			
			$sorted_order_item_details = array_sort_by_column($order_item_details, 'id', SORT_ASC); //sorting to ASC so that the latest purchases is in the end.
			
			//Verifying if in the previus purchase the user has cleared the exam of this PGD. If it is not, we need to ask for the New Rechas and also need to give an exam.
			//Check previous purchase details
			
			$previous_order_item_details = $sorted_order_item_details[count($sorted_order_item_details)-2];
			
			//Now verify if user has cleared the exam in previous purchase
			
			if($previous_order_item_details['is_quiz_passed'] == '1' && $previous_order_item_details['doctor_approval'] == '1' && $previous_order_item_details['pharmacist_approval'] == '1'){
				//Means User did cleared the exam and got the doc and pharmacist approval. Dont' ask the exam and showo repeat rechas

				//If more than 1 purchase and if the PDG is in a package ask the rechas of Renew Type.
				$pgd_rechas_list_arr = $this->pgds->get_pgd_rechas_list($pgd_id,'renew');
				$data['renew'] = '1';
				
			}else{
				$pgd_rechas_list_arr = $this->pgds->get_pgd_rechas_list($pgd_id); //If first purchase or in previous rechas exam was not cleated
			}
			
		}else
			$pgd_rechas_list_arr = $this->pgds->get_pgd_rechas_list($pgd_id); //If first purchase.. or the PGD is a Vaccine and not in any package.
		
		$data['pgd_rechas_list_arr'] = $pgd_rechas_list_arr;

		//load main template
		$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
		$this->stencil->paint('pgd/pgd_rechas',$data);

	}//end pgd_rechas($pgd_id)
	
	//Function take_a_quiz(): Used by the users to take teh quiz
	public function take_a_quiz($pgd_id){

		//Verify if user is allowed to see this quiz page or not. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);
		
		if(!$pgd_access_allowed){
			redirect(SURL.'dashboard');	
		}else{
			//PGD is purchased and not expired, now ready to go.
			
			$data['pgd_access_allowed'] = $pgd_access_allowed;
			
			/*
			echo '<pre>';
			print_r($pgd_access_allowed);
			exit;
			*/

			//Calculate the previous attempt duration
			$last_quiz_hour = 0; 
			$current_date_hour = 0;

			$last_quiz_date = new DateTime($pgd_access_allowed['last_quiz_date']);
			$current_date = new DateTime(date('Y-m-d G:i:s'));
			$interval = $last_quiz_date->diff($current_date);
			 
			if($interval->format('%a') > 0)
				$last_quiz_hour = $interval->format('%a')*24;
			
			if($interval->format('%h') > 0)
				$current_date_hour = $interval->format('%h');
			
			//Total Hours passed since last quiz attempted.
 			$total_hours_passed = $last_quiz_hour + $current_date_hour;
			$data['total_hours_passed'] = $total_hours_passed;
			
			//Check if there is any previous session available to resume.
			$chk_previous_quiz_session = $this->pgds->previous_quiz_session($this->session->id,$pgd_id);
			
			$previous_quiz_session['quiz_data']['quiz_session'] = $chk_previous_quiz_session['quiz_session_arr'];
			
			if(count($previous_quiz_session['quiz_data']['quiz_session']) > 0){
				
				//If there are one or more previous attempted questions
				
				/*
				echo '<pre>';
				print_r($previous_quiz_session['quiz_data']['quiz_session']);
				exit;
				*/
				
				$prev_quiz_id = $previous_quiz_session['quiz_data']['quiz_session'][count($previous_quiz_session['quiz_data']['quiz_session'])-1]['quiz_id'];
				$prev_quiz_id_index = (array_search($prev_quiz_id, array_column($previous_quiz_session['quiz_data']['quiz_session'],'quiz_id')));
							
				$data['prev_quiz_id'] = $prev_quiz_id;
				$data['prev_quiz_id_index'] = $prev_quiz_id_index;

			}//end if(count($previous_quiz_session['quiz_data']['quiz_session']) > 0)
			
			//Get PGD Required Data
			$pgd_details_arr = $this->pgds->get_pgd_details($pgd_id);
			$data['pgd_details_arr'] = $pgd_details_arr;
			
			$previous_quiz_session['quiz_data']['total_questions'] = $pgd_details_arr['no_of_quizes'];
			$previous_quiz_session['quiz_data']['total_attmpted'] = count($chk_previous_quiz_session['quiz_session_arr']);
			$previous_quiz_session['quiz_data']['total_correct'] = $chk_previous_quiz_session['count_true_result'];
			$previous_quiz_session['quiz_data']['total_wrong'] = $chk_previous_quiz_session['count_false_result'];
			$data['previous_quiz_session'] = $previous_quiz_session;

			//Now Get list of Random questions, remaining_questions = 
			$get_quiz_list = $this->pgds->get_quiz_questions_list($this->session->id,$pgd_id,array(),'submit_quiz');
			$data['get_quiz_list'] = $get_quiz_list;

			//set title
			$page_title = $pgd_details_arr['pgd_name'].' Exam';
			
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => $page_title,
				'keywords' => $page_title,
			));
			
			$bread_crum .= "<ol class='breadcrumb'>";
			$bread_crum .= "<li><a href='".SURL."home'>Home</a> </li>";
			$bread_crum .= "<li><a href='".SURL."dashboard'>Dashboard</a> </li>";
			$bread_crum .= "<li><a href='".SURL."pgd/pgd-certificate/".filter_string($pgd_details_arr['id'])."'>".filter_string($pgd_details_arr['pgd_name'])."</a></li>";
			$bread_crum .= "<li class='active'>Exam </li>";
			$bread_crum .= "</ol>";
			
			$data['bread_crum'] = $bread_crum;
            
			$this->stencil->js('pgds.js');
			
			//load main template
			$this->stencil->layout('pgd_page_template'); //pgd_page_template
			$this->stencil->paint('pgd/take_a_quiz',$data);

		}//end if(!$pgd_access_allowed)
		
	}//end take_a_quiz($pgd_id)
	
	//Function show_next_quiz_page(): Get the next question page by ajax, first insert the record into the databse for the attempted questions
	public function show_next_quiz_page(){
		
		extract($this->input->post());
		
		//Verify if user is allowed to see this quiz page or not. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);
		
		if(!$pgd_access_allowed){
			redirect(SURL.'dashboard');
		}else{
			
			//If Next Question is Clicked, means user is attempting the question, save teh result into the DB, if marked as skipped again save that into DB
			if($action != 'submit_prev'){
				//If post is set and answer is received, insert that answer into the database.
				$add_quiz_result = $this->pgds->add_quiz_result($this->session->id,$this->input->post(),$pgd_access_allowed);
				
			}//end if($action != 'submit_prev')
			
			//Check if there are any next question to show or if everything is done.
			$chk_previous_quiz_session = $this->pgds->previous_quiz_session($this->session->id,$pgd_id);
			$previous_quiz_session['quiz_data']['quiz_session'] = $chk_previous_quiz_session['quiz_session_arr'];
			
			if($action == 'submit_prev'){
			
				$prev_quiz_id_index = $prev_quiz_id_index-1;
				$prev_quiz_id = $previous_quiz_session['quiz_data']['quiz_session'][$prev_quiz_id_index]['quiz_id'];
				
			}else{
				$prev_quiz_id = $previous_quiz_session['quiz_data']['quiz_session'][count($previous_quiz_session['quiz_data']['quiz_session'])-1]['quiz_id'];
				$prev_quiz_id_index = (array_search($prev_quiz_id, array_column($previous_quiz_session['quiz_data']['quiz_session'],'quiz_id')));
				
			}//end if($action == 'submit_prev')
			
			$data['prev_quiz_id'] = $prev_quiz_id;
			$data['prev_quiz_id_index'] = $prev_quiz_id_index;
			$data['action'] = $action;
			
			//Get PGD Required Data
			$pgd_details_arr = $this->pgds->get_pgd_details($pgd_id);
			$data['pgd_details_arr'] = $pgd_details_arr;
			
			$previous_quiz_session['quiz_data']['total_questions'] = $pgd_details_arr['no_of_quizes'];
			$previous_quiz_session['quiz_data']['total_attmpted'] = count($chk_previous_quiz_session['quiz_session_arr']);
			$previous_quiz_session['quiz_data']['total_correct'] = $chk_previous_quiz_session['count_true_result'];
			$previous_quiz_session['quiz_data']['total_wrong'] = $chk_previous_quiz_session['count_false_result'];
			$data['previous_quiz_session'] = $previous_quiz_session;
			
			//User have attempted all the questions now its time to calculate the results and show to user
			if($previous_quiz_session['quiz_data']['total_questions'] == $previous_quiz_session['quiz_data']['total_attmpted']){
				
				$evaluate_quiz = $this->pgds->quiz_evaluate_result($this->session->id,$this->input->post(),$previous_quiz_session,$pgd_access_allowed);
				$data['evaluate_quiz'] = $evaluate_quiz;
				
			}//end if
			
			//Now Get list of Random questions
			$get_quiz_list = $this->pgds->get_quiz_questions_list($this->session->id,$pgd_id,$this->input->post(),$action);
			$data['get_quiz_list'] = $get_quiz_list;
			
			$current_quiz_id_index = (array_search($get_quiz_list['quiz_question']['quiz_id'], array_column($previous_quiz_session['quiz_data']['quiz_session'],'quiz_id')));
			
			$data['current_quiz_id_index'] = $current_quiz_id_index;					

			$this->stencil->layout('ajax'); //ajax
			$this->stencil->paint('pgd/quiz_ajax.php',$data);
			
		}//end if(!$pgd_access_allowed)
		
	}//end show_next_quiz_page()

	//Function rechas_submit_process(): Just set the flag of rechas in user purchased table as TRUE. Means User have read the rechas 
	public function rechas_submit_process(){
		
		extract($this->input->post());

		//Verify if user is allowed to see this PGD page or not. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);
		
		//print_this($pgd_access_allowed); 		exit;
		
		if($this->input->post()){
			
			//Update the Settings into the user table
			$get_update_status = $this->pgds->update_pgd_rechas_setting($this->session->id,$pgd_access_allowed);

			if($renew == '1'){
				
				//It means the PGD is a package and has already purchased the package more than one.. So now we are skipping the exam part and marking this user as passed for all questions for this PGD and Purchase.
				
				$this->pgds->auto_quiz_submission_for_package_pgds($this->session->id, $pgd_id, $pgd_access_allowed['id']);
				
			}//end if($renew == '1')
			
			if($get_update_status)
				redirect(SURL.'pgd/pgd-certificate/'.$pgd_id);	
			
		}//end if($this->input->post())
	
	}//end rechas_submit_process()
	

	//Submit User Given Rating and store into the database
	public function submit_pgd_rating(){
		
		//Verify if user is allowed to see this video page or not. This will only possible if the trainig is purchased and not expired.
		$submit_rating = $this->pgds->save_pgd_rating($this->session->id,$this->input->post());
		
		if($submit_rating)
			return true;
		else
			return false;
	}//end submit_pgd_rating()
	
	
	//Create the PDG Certificate
	public function download_pgd_certificate($pgd_id,$subpgd_id){

		//Verify if user is allowed. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);

		if(!$pgd_access_allowed){
			redirect(SURL.'dashboard');	
		}else{
			
			if($this->session->is_owner){
				$is_owner_si_org_id = $this->my_organization_id;
				$pharmacy_surgery_id = '';
			}elseif($this->user_org_superintendent){
				$is_owner_si_org_id = $this->my_organization_id;
				$pharmacy_surgery_id = '';
			}elseif($this->session->pharmacy_surgery_id){
				$is_owner_si_org_id = '';
				$pharmacy_surgery_id = $this->session->pharmacy_surgery_id;
			}//end if($this->session->is_owner)

			if($pgd_access_allowed['organization_id']){
				//If teh PGD is purchased for STAFF by any organiation itself! Use ORG signatures/ CQC etc
				$is_owner_si_org_id = $pgd_access_allowed['organization_id'];
				
			}//end if($pgd_access_allowed['organization_id'])
			
			
			$prepare_certificate = $this->pgds->get_pgd_subpgds_certificate($this->session->id,$pgd_id,$subpgd_id, $is_owner_si_org_id, $pharmacy_surgery_id);
			
		}//end if(!$pgd_access_allowed)
		
	}//end download_pgd_certificate()

	//Download the PDG Main Certificate
	public function download_certificate($pgd_id){

		//Verify if user is allowed. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);

		if(!$pgd_access_allowed){
			redirect(SURL.'dashboard');	
		}else{

			$prepare_certificate = $this->pgds->get_pgd_certificate($user_id,$pgd_id);
			
		}//end if(!$pgd_access_allowed)
		
	}//end download_pgd_certificate()
	
	public function pgd_reviews($pgd_id){

		$this->stencil->js('pgds.js');
		$this->stencil->js('star-rating.js');
		
		//Verify if user is allowed. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);
		
		if(!$pgd_id){
			redirect(SURL.'dashboard');	
		}else{
			
			$data['pgd_access_allowed'] = $pgd_access_allowed;
			$data['pgd_id'] = $pgd_access_allowed['product_id'];
			//Get All PGD Reviews
			$get_pgd_reviews_list = $this->purchase->get_product_reviews('PGD',$pgd_id);
			$data['get_pgd_reviews_list'] = $get_pgd_reviews_list;
			
			$pgd_detail_arr = $this->pgds->get_pgd_details($pgd_id);
			$data['pgd_detail_arr'] = $pgd_detail_arr;
			
			//load main template
			$this->stencil->layout('pgd_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('pgd/pgd_reviews',$data);
			
		}//end if(!$pgd_access_allowed)

	}//end pgd_reviews($pgd_id)

	public function submit_pgd_review_process(){
		
		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		$submit_pgd_review = $this->pgds->submit_pgd_review($this->session->id,$this->input->post());
		
		if($submit_pgd_review)
			return true;
		else
			return false;
		
	}//end submit_pgd_review_process()
	
	// Start - public function pgd_reviews_load_more($pgd_id) : Load more ajax call from PGD reviews popup
	public function pgd_reviews_load_more($pgd_id, $offset){
		
		$get_pgd_reviews_list = $this->purchase->get_product_reviews('PGD',$pgd_id, $offset);
		
		if($get_pgd_reviews_list)
			echo json_encode($get_pgd_reviews_list);
		else
			echo 'empty';
		//$data['get_pgd_reviews_list'] = $get_pgd_reviews_list;
		
	} // End - public function pgd_reviews_load_more($pgd_id)
	
}//end 

/* End of file */