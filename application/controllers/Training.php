<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Training extends MY_Dashboard_Controller {

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

	public function index($training_id){
		
		redirect(SURL.'dashboard');
		
	} //end index()


	public function training_detail($training_id){
			
		//Loading Training Cours details
		$training_detail_arr = $this->training->get_training_course_details($training_id);

		//If the course does not found, redirect to 404 page
		if(!$training_detail_arr){
			redirect(SURL.'dashboard');
				
		}else{
			$data['training_detail_arr'] = $training_detail_arr;
		}
		
		//set title
		$page_title = $training_detail_arr['meta_title'];
		$this->stencil->title($page_title);	
		
		$this->stencil->js('dashboard.js');
		$this->stencil->css('star-rating.css');
		$this->stencil->js('star-rating.js');
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $training_detail_arr['meta_description'],
			'keywords' => $training_detail_arr['meta_keywords'],
			'meta_title' => $training_detail_arr['meta_title']
		));

		//load main template
		$this->stencil->layout('training_detail_ajax_template'); //course_detail_ajax_template
		$this->stencil->paint('training/training_detail',$data);
		
	} //end index()
	
	//Function training_videos(): Video Detail Page shown after the Training Videos are Paid.
	public function training_videos($training_id){
		
		//Verify if user is allowed to see this video page or not. This will only possible if the trainig is purchased and not expired.
		$training_access_allowed = $this->training->verify_training_purchased_by_user($this->session->id,$training_id);

		//Get Training Contents
		$training_detail_arr = $this->training->get_training_course_details($training_id);
		$data['training_detail_arr'] = $training_detail_arr;
		
		if(filter_string($training_detail_arr['price']) > 0.00)
			$is_free = 0;
		else
			$is_free = 1;
			
		if(!$training_access_allowed && $is_free){
			//It means the trainign is free and also not purchased so we have to make a single order entry into the database.
			
			$add_product_to_order = $this->purchase->add_training_to_order_manually($this->session->id,$training_id);
			$training_access_allowed = $this->training->verify_training_purchased_by_user($this->session->id,$training_id,'TRAINING');
				
		}//end if(!$training_access_allowed && $is_free)
		
		if(!$training_access_allowed && !$is_free){
			redirect(SURL.'dashboard');	
		}else{
			
			//Get Training Purchased Records
			$data['training_access_allowed'] = $training_access_allowed;

			//Check if there is any previous session available to resume.
			$chk_previous_quiz_session = $this->training->previous_quiz_session($this->session->id,$training_id);
			$data['chk_previous_quiz_session'] = $chk_previous_quiz_session;
			
			//Calculate the previous attempt duration of quiz
			$last_quiz_hour = 0; 
			$current_date_hour = 0;

			$last_quiz_date = new DateTime($training_access_allowed['last_quiz_date']);
			$current_date = new DateTime(date('Y-m-d G:i:s'));
			$interval = $last_quiz_date->diff($current_date);
			 
			if($interval->format('%a') > 0)
				$last_quiz_hour = $interval->format('%a')*24;
			
			if($interval->format('%h') > 0)
				$current_date_hour = $interval->format('%h');
			
			//Total Hours passed since last quiz attempted.
			$total_hours_passed = $last_quiz_hour + $current_date_hour;
			$data['total_hours_passed'] = $total_hours_passed;
			
			//Get Video List
			$video_list_arr = $this->training->get_training_videos_list($training_id);
			$data['video_list_arr'] = $video_list_arr;
			
			//Get Document List
			$document_list_arr = $this->training->get_training_documents($training_id);
			$data['document_list_arr'] = $document_list_arr;

			//Get Training Reviews
			$get_training_reviews_list = $this->purchase->get_product_reviews('TRAINING',$training_id);			
			$data['get_training_reviews_list'] = $get_training_reviews_list;
			
		}//end if($training_access_allowed == 0)

		//Fancybox Files and Scripts
		$this->stencil->css('jquery.fancybox.css');
		$this->stencil->js('jquery.fancybox.js');
		
		$this->stencil->css('star-rating.css');
		
		$this->stencil->js('bootstrap-treeview.js');
		$this->stencil->js('star-rating.js');
		$this->stencil->js('training.js');
		$this->stencil->js('org_dashboard.js');
		
		//set title
		$page_title = $training_detail_arr['meta_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $training_detail_arr['meta_description'],
			'keywords' => $training_detail_arr['meta_keywords'],
			'meta_title' => $training_detail_arr['meta_title']
		));
		
			$bread_crum .= "<ol class='breadcrumb'>";
			$bread_crum .= "<li><a href='".SURL."home'>Home</a> </li>";
			$bread_crum .= "<li><a href='".SURL."dashboard'>Dashboard</a> </li>";
			$bread_crum .= "<li class='active'>".filter_string($training_detail_arr['course_name'])."</li>";

			$bread_crum .= "</ol>";
			
			$data['bread_crum'] = $bread_crum;

		//load main template
		$this->stencil->layout('dashboard_template'); //courses_videos_template
		$this->stencil->paint('training/training_videos',$data);
		
	} //end training_videos($training_id)

	//Function take_a_quiz(): Used by the users to take teh quiz
	public function take_a_quiz($training_id){

		//Verify if user is allowed to see this video page or not. This will only possible if the trainig is purchased and not expired.
		$training_access_allowed = $this->training->verify_training_purchased_by_user($this->session->id,$training_id);
		
		if(!$training_access_allowed){
			redirect(SURL.'dashboard');	
		}else{

			//Training is purchased and not expired, now ready to go.
			$data['training_access_allowed'] = $training_access_allowed;
			
			/*
			echo '<pre>';
			print_r($training_access_allowed);
			exit;
			*/

			//Calculate the previous attempt duration
			$last_quiz_hour = 0; 
			$current_date_hour = 0;

			$last_quiz_date = new DateTime($training_access_allowed['last_quiz_date']);
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
			$chk_previous_quiz_session = $this->training->previous_quiz_session($this->session->id,$training_id);
			
			$previous_quiz_session['quiz_data']['quiz_session'] = $chk_previous_quiz_session['quiz_session_arr'];
			
			if(count($previous_quiz_session['quiz_data']['quiz_session']) > 0){
				
				//If there are one or more previous attempted questions
				
				$prev_quiz_id = $previous_quiz_session['quiz_data']['quiz_session'][count($previous_quiz_session['quiz_data']['quiz_session'])-1]['quiz_id'];
				$prev_quiz_id_index = (array_search($prev_quiz_id, array_column($previous_quiz_session['quiz_data']['quiz_session'],'quiz_id')));
							
				$data['prev_quiz_id'] = $prev_quiz_id;
				$data['prev_quiz_id_index'] = $prev_quiz_id_index;

			}//end if(count($previous_quiz_session['quiz_data']['quiz_session']) > 0)
			
			//Get Training Required Data
			$training_details_arr = $this->training->get_training_course_details($training_id);
			$data['training_details_arr'] = $training_details_arr;
			
			$previous_quiz_session['quiz_data']['total_questions'] = $training_details_arr['no_of_quizes'];
			$previous_quiz_session['quiz_data']['total_attmpted'] = count($chk_previous_quiz_session['quiz_session_arr']);
			$previous_quiz_session['quiz_data']['total_correct'] = $chk_previous_quiz_session['count_true_result'];
			$previous_quiz_session['quiz_data']['total_wrong'] = $chk_previous_quiz_session['count_false_result'];
			$data['previous_quiz_session'] = $previous_quiz_session;

			//Now Get list of Random questions, remaining_questions = 
			$get_quiz_list = $this->training->get_quiz_questions_list($this->session->id,$training_id,array(),'submit_quiz');
			$data['get_quiz_list'] = $get_quiz_list;

			//set title
			$page_title = $training_details_arr['meta_title'];
			$this->stencil->title($page_title);	
			
			//Sets the Meta data
			$this->stencil->meta(array(
				'description' => $training_details_arr['meta_description'],
				'keywords' => $training_details_arr['meta_keywords'],
			    'meta_title' => $training_detail_arr['meta_title']
			));

			$bread_crum .= "<ol class='breadcrumb'>";
			$bread_crum .= "<li><a href='".SURL."home'>Home</a> </li>";
			$bread_crum .= "<li><a href='".SURL."dashboard'>Dashboard</a> </li>";
			$bread_crum .= "<li><a href='".SURL."training/training-videos/".filter_string($training_details_arr['id'])."'>".filter_string($training_details_arr['course_name'])."</a></li>";
			$bread_crum .= "<li class='active'>Exam </li>";
			$bread_crum .= "</ol>";
			
			$data['bread_crum'] = $bread_crum;
			
			$this->stencil->js('training.js');
			
			//load main template
			$this->stencil->layout('pgd_page_template'); //pgd_page_template
			$this->stencil->paint('training/take_a_quiz',$data);

		}//end if(!$training_access_allowed)
		
	}//end take_a_quiz($training_id)

	// Function show_next_quiz_page(): Get the next question page by ajax, first insert the record into the databse for the attempted questions
	public function show_next_quiz_page(){
		
		extract($this->input->post());
		
		//Verify if user is allowed to see this video page or not. This will only possible if the trainig is purchased and not expired.
		$training_access_allowed = $this->training->verify_training_purchased_by_user($this->session->id,$training_id);
		
		
		if(!$training_access_allowed){
			redirect(SURL.'dashboard');
		}else{
			
			//If Next Question is Clicked, means user is attempting the question, save teh result into the DB, if marked as skipped again save that into DB
			if($action != 'submit_prev'){
				//If post is set and answer is received, insert that answer into the database.
				$add_quiz_result = $this->training->add_quiz_result($this->session->id,$this->input->post(),$training_access_allowed);
				
			}//end if($action != 'submit_prev')
			
			//Check if there are any next question to show or if everything is done.
			$chk_previous_quiz_session = $this->training->previous_quiz_session($this->session->id,$training_id);
			$previous_quiz_session['quiz_data']['quiz_session'] = $chk_previous_quiz_session['quiz_session_arr'];
			
			/*
			echo '<pre>';
			print_r($previous_quiz_session['quiz_data']['quiz_session']);
			
			
			if(count($previous_quiz_session['quiz_data']['quiz_session']) == 1){
				
				$prev_quiz_id = $previous_quiz_session['quiz_data']['quiz_session'][0]['quiz_id'];
				$prev_quiz_id_index = (array_search($prev_quiz_id, array_column($previous_quiz_session['quiz_data']['quiz_session'], 'quiz_id')));
				
			}else*/{

				if($action == 'submit_prev'){
				
					$prev_quiz_id_index = $prev_quiz_id_index-1;
					$prev_quiz_id = $previous_quiz_session['quiz_data']['quiz_session'][$prev_quiz_id_index]['quiz_id'];
					
				}else{
					$prev_quiz_id = $previous_quiz_session['quiz_data']['quiz_session'][count($previous_quiz_session['quiz_data']['quiz_session'])-1]['quiz_id'];
					$prev_quiz_id_index = (array_search($prev_quiz_id, array_column($previous_quiz_session['quiz_data']['quiz_session'],'quiz_id')));
					
				}//end if($action == 'submit_prev')
				
			}//end if(count($previous_quiz_session['quiz_data']['quiz_session']) == 1)
			
			$data['prev_quiz_id'] = $prev_quiz_id;
			$data['prev_quiz_id_index'] = $prev_quiz_id_index;
			$data['action'] = $action;
			

			//Get Training Required Data
			$training_details_arr = $this->training->get_training_course_details($training_id);
			$data['training_details_arr'] = $training_details_arr;
			
			$previous_quiz_session['quiz_data']['total_questions'] = $training_details_arr['no_of_quizes'];
			$previous_quiz_session['quiz_data']['total_attmpted'] = count($chk_previous_quiz_session['quiz_session_arr']);
			$previous_quiz_session['quiz_data']['total_correct'] = $chk_previous_quiz_session['count_true_result'];
			$previous_quiz_session['quiz_data']['total_wrong'] = $chk_previous_quiz_session['count_false_result'];
			$data['previous_quiz_session'] = $previous_quiz_session;

			//User have attempted all the questions now its time to calculate the results and show to user
			if($previous_quiz_session['quiz_data']['total_questions'] == $previous_quiz_session['quiz_data']['total_attmpted']){

				// All done

				$evaluate_quiz = $this->training->quiz_evaluate_result($this->session->id,$this->input->post(),$previous_quiz_session,$training_access_allowed);
				$data['evaluate_quiz'] = $evaluate_quiz;

				/*
				if($data['quiz_result'] == 'F'){


				}
				*/

				// Evaluate whole quiz

				// print_this($previous_quiz_session);
				// exit;

				/*
				Array
				(
				    [quiz_data] => Array
				        (
				            [quiz_session] => Array
				                (
				                    [0] => Array
				                        (
				                            [id] => 1
				                            [order_id] => 1181
				                            [training_id] => 8
				                            [user_id] => 43
				                            [quiz_id] => 8
				                            [answer_id] => 30
				                            [answer_status] => T
				                            [is_skipped] => 0
				                            [created_date] => 2016-07-19 17:45:33
				                            [created_by_ip] => ::1
				                        )

				                    [1] => Array
				                        (
				                            [id] => 2
				                            [order_id] => 1181
				                            [training_id] => 8
				                            [user_id] => 43
				                            [quiz_id] => 7
				                            [answer_id] => 25
				                            [answer_status] => T
				                            [is_skipped] => 0
				                            [created_date] => 2016-07-19 17:47:15
				                            [created_by_ip] => ::1
				                        )

				                    [2] => Array
				                        (
				                            [id] => 3
				                            [order_id] => 1181
				                            [training_id] => 8
				                            [user_id] => 43
				                            [quiz_id] => 10
				                            [answer_id] => 42
				                            [answer_status] => F
				                            [is_skipped] => 0
				                            [created_date] => 2016-07-19 17:48:33
				                            [created_by_ip] => ::1
				                        )

				                    [3] => Array
				                        (
				                            [id] => 4
				                            [order_id] => 1181
				                            [training_id] => 8
				                            [user_id] => 43
				                            [quiz_id] => 11
				                            [answer_id] => 47
				                            [answer_status] => F
				                            [is_skipped] => 0
				                            [created_date] => 2016-07-19 17:50:36
				                            [created_by_ip] => ::1
				                        )

				                    [4] => Array
				                        (
				                            [id] => 5
				                            [order_id] => 1181
				                            [training_id] => 8
				                            [user_id] => 43
				                            [quiz_id] => 9
				                            [answer_id] => 39
				                            [answer_status] => F
				                            [is_skipped] => 0
				                            [created_date] => 2016-07-19 17:50:40
				                            [created_by_ip] => ::1
				                        )

				                )

				            [total_questions] => 5
				            [total_attmpted] => 5
				            [total_correct] => 2
				            [total_wrong] => 3
				        )

				)
				*/
				
			}//end if
			
			//Now Get list of Random questions
			$get_quiz_list = $this->training->get_quiz_questions_list($this->session->id,$training_id,$this->input->post(),$action);
			$data['get_quiz_list'] = $get_quiz_list;
			
			$current_quiz_id_index = (array_search($get_quiz_list['quiz_question']['quiz_id'], array_column($previous_quiz_session['quiz_data']['quiz_session'],'quiz_id')));
			
			$data['current_quiz_id_index'] = $current_quiz_id_index;					
			

			$this->stencil->layout('ajax'); //ajax
			$this->stencil->paint('training/quiz_ajax.php',$data);
			
		}//end if(!$training_access_allowed)
		
	}//end show_next_quiz_page()
	
	//Submit User Given Rating and store into the database
	public function submit_training_rating(){
		
		//Verify if user is allowed to see this video page or not. This will only possible if the trainig is purchased and not expired.
		$submit_rating = $this->training->save_training_rating($this->session->id,$this->input->post());
		
		if($submit_rating)
			return true;
		else
			return false;
	}//end submit_training_rating()

	public function download_certificate($training_id){

		//Verify if user is allowed. This will only possible if the TRAINING is purchased and not expired.
		$training_access_allowed = $this->training->verify_training_purchased_by_user($this->session->id,$training_id);

		if(!$training_access_allowed){
			redirect(SURL.'dashboard');	
		}else{

			$prepare_certificate = $this->training->get_training_certificate($user_id,$training_id);
			
		}//end if(!$training_access_allowed)
		
	}//end download_pgd_certificate()


	public function training_reviews($training_id){

		$this->stencil->js('training.js');
		$this->stencil->js('star-rating.js');
		
		//Verify if user is allowed. This will only possible if the PGD is purchased and not expired.
		$training_access_allowed = $this->training->verify_training_purchased_by_user($this->session->id,$training_id);

		$training_detail_arr = $this->training->get_training_course_details($training_id);
		$data['training_detail_arr'] = $training_detail_arr;
		
		/*if(!$training_access_allowed && !$is_free)
			redirect(SURL.'dashboard');
		}*/
		if(!$training_id){
			redirect(SURL.'dashboard');
		}else{
			
			$data['training_access_allowed'] = $training_access_allowed;
			$data['training_id'] = $training_access_allowed['product_id'];
			
			//Get All PGD Reviews
			$get_training_reviews_list = $this->purchase->get_product_reviews('TRAINING',$training_id);
			
			$data['get_training_reviews_list'] = $get_training_reviews_list;

			//load main template
			$this->stencil->layout('training_detail_ajax_template'); //pgd_detail_ajax_template
			$this->stencil->paint('training/training_reviews',$data);
			
			
		}//end if(!$pgd_access_allowed)

	}//end training_reviews($training_id)
	
	public function submit_training_review_process(){
		
		if(!$this->input->post()) redirect(SURL);
		
		extract($this->input->post());
		
		$submit_training_review = $this->training->submit_training_review($this->session->id,$this->input->post());
		
		if($submit_training_review)
			return true;
		else
			return false;
		
	}//end submit_training_review_process()

	// Start - public function training_reviews_load_more($pgd_id) : Load more ajax call from Training reviews popup
	public function training_reviews_load_more($training_id, $offset){
		
		$get_training_reviews_list = $this->purchase->get_product_reviews('TRAINING',$training_id, $offset);
		
		if($get_training_reviews_list)
			echo json_encode($get_training_reviews_list);
		else
			echo 'empty';
		//$data['get_training_reviews_list'] = $get_training_reviews_list;
		
	} // End - public function training_reviews_load_more($pgd_id)
	
}//end 

/* End of file */
