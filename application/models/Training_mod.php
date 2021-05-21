<?php
class Training_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//TRAINING VIDEOS SECTION
	
	//Function get_training_courses_list(): will return the list of training courses list added against the User Type.
	public function get_training_courses_list($user_type){

		$this->db->dbprefix('package_training');
		if($user_type != '')
			$this->db->where('user_type',$user_type);
			
		$this->db->where('status',1);
		$this->db->where('is_admin_deleted','0');

		$this->db->order_by('price','ASC');

		$get_user= $this->db->get('package_training');
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_training_courses_list()

	//Function get_training_course_details(): Get Single Course Detail using course_id
	public function get_training_course_details($training_id){

		$this->db->dbprefix('package_training');
		$this->db->where('id',$training_id);
		$this->db->where('is_admin_deleted','0');
		$get_user= $this->db->get('package_training');
		//echo $this->db->last_query(); 		exit;
		return $get_user->row_array();
		
	}//end get_training_course_details()

	//Function get_training_documents(): Get List of Training documents using course_id
	public function get_training_documents($training_id){


		$this->db->dbprefix('training_documents');
		$this->db->select('training_documents.*,training_documents_category.id AS category_id, 
							training_documents_category.category_name');
		$this->db->where('training_documents.course_id = '.$training_id);
		$this->db->where('training_documents.status = 1');
		$this->db->join('training_documents_category','training_documents_category.id = training_documents.category_id','LEFT');

		
		$get_result = $this->db->get('training_documents');
		//echo $this->db->last_query(); 		exit;
		
		$document_tree = array();
		foreach($get_result->result_array() as $row){

			$document_tree[$row['category_name']][] = array(
														'document_title' => $row['document_title'],
														'document_icon' => $row['document_icon'],
														'document_url' => $row['document_url']
													);
			
		}//end for($get_user->result_array() as $rows)
		
		return $document_tree;
		
	}//end get_training_videos_list()


	//Function get_training_videos_list(): Get List of Training Videos using course_id
	public function get_training_videos_list($training_id){

		$this->db->dbprefix('training_videos');
		$this->db->where('course_id',$training_id);
		$this->db->where('status',1);
		$this->db->order_by('default_video','DESC');
		$get_user= $this->db->get('training_videos');
		
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_training_videos_list()

	//Function verify_training_purchased_by_user(): Return True if the trianing is purchased by the user and is not expired
	public function verify_training_purchased_by_user($user_id,$training_id){

		$this->db->dbprefix('user_order_details');
		$this->db->where('user_id',$user_id);
		$this->db->where('product_type','TRAINING');
		$this->db->where('product_id',$training_id);
		$this->db->where('expiry_date >=',date('Y-m-d'));
		$get_result = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		return $get_result->row_array();
		
	}//end verify_training_purchased_by_user()

	//Function previous_quiz_session(): Retreive the previous session of quiz conducted, returns the array of questions attempted
	public function previous_quiz_session($user_id,$training_id){
		
		$this->db->dbprefix('training_quiz_session');
		$this->db->where('user_id',$user_id);
		$this->db->where('training_id',$training_id);
		$this->db->order_by('created_date','ASC');
		
		$get_result = $this->db->get('training_quiz_session');
		//echo $this->db->last_query(); 		exit;
		
		$quiz_arr['quiz_session_arr'] = $get_result->result_array();
		
		//Get Total True
		$this->db->dbprefix('training_quiz_session');
		$this->db->select('COUNT(id) AS total_true');
		$this->db->where('user_id',$user_id);
		$this->db->where('training_id',$training_id);
		$this->db->where('answer_status','T');
		
		$get_user = $this->db->get('training_quiz_session');
		//echo $this->db->last_query(); 		exit;
		$true_result = $get_user->row_array();
		$count_true_result = $true_result['total_true'];
		
		$quiz_arr['count_true_result'] = $count_true_result;

		//Get Total False
		$this->db->dbprefix('training_quiz_session');
		$this->db->select('COUNT(id) AS total_false');
		$this->db->where('user_id',$user_id);
		$this->db->where('training_id',$training_id);
		$this->db->where('answer_status','F');
		
		$get_user = $this->db->get('training_quiz_session');
		//echo $this->db->last_query(); 		exit;
		$false_result = $get_user->row_array();
		$count_false_result = $false_result['total_false'];
		
		$quiz_arr['count_false_result'] = $count_false_result;
		
		return $quiz_arr;
		
	}//end previous_quiz_session()
	

	/*
	Function get_quiz_questions_list() return list of questions which are not attempted by the user yet. This function will not repeat already answered question. Generate Random Results based on Action, 
	submit_quiz => Save the results into the session
	submit_skip => Skip the question and show the next question without saving anything into the database.
	submit_prev => Show the Previous attmpted questions. 
	*/
	public function get_quiz_questions_list($user_id,$training_id,$data,$action){
		
		extract($data);
		
		$skip_condition = '';
		$next_skip_condition = '';
		$prev_condition = '';
		
		
		if($action == 'submit_skip' || $action == 'submit_quiz' || $action == '')
			$next_skip_condition = "AND kod_training_quizes.id  NOT IN (SELECT `kod_training_quiz_session`.`quiz_id` FROM `kod_training_quiz_session` WHERE `kod_training_quiz_session`.user_id = '".$user_id."') ORDER BY RAND()";
			
		if($action == 'submit_skip')
			$skip_condition = "AND kod_training_quizes.id <> '".$quiz_id."'";

		//echo $action;
		if($action == 'submit_prev'){
			$prev_condition = "AND kod_training_quizes.id = '".$prev_quiz_id."'";
			$skip_condition = '';
			$next_skip_condition = '';
		}//end if($action == 'submit_prev')
		

		$quiz_qry = "SELECT `kod_training_quizes`.`id` AS `quiz_id`, `kod_training_quizes`.`training_id`, `kod_training_quizes`.`question`, `kod_training_quizes`.`correct_option_id` FROM `kod_training_quizes` WHERE `kod_training_quizes`.`training_id` = '".$training_id."' $prev_condition $skip_condition $next_skip_condition LIMIT 0,1";

		$rs_quiz_qry = $this->db->query($quiz_qry);
		$quiz_details = $rs_quiz_qry->row_array();

		//echo $this->db->last_query(); 		exit;
		$get_result_arr['quiz_question'] = $quiz_details;
		//Get Question Options

		$this->db->dbprefix('training_quiz_options');
		$this->db->where('quiz_id',$quiz_details['quiz_id']);
		$this->db->order_by('id', 'DESC');
		$get_user= $this->db->get('training_quiz_options');
		//echo $this->db->last_query(); 		exit;

		$get_result_arr['quiz_options'] = $get_user->result_array();
		
		return $get_result_arr;

	}//end get_quiz_questions_list($user_id,$training_id)


	//Get Quiz details and its options using quiz ID
	public function get_training_quiz_details($quiz_id){

		$this->db->dbprefix('training_quizes');
		$this->db->where('id',$quiz_id);
		$get_result = $this->db->get('training_quizes');
		//echo $this->db->last_query(); 		exit;
		$quiz_details = $get_result->row_array();

		$get_result_arr['quiz_question'] = $quiz_details;
		
		//Get Question Options

		$this->db->dbprefix('training_quiz_options');
		$this->db->where('quiz_id',$quiz_details['id']);
		$this->db->order_by('id', 'DESC');
		$get_user= $this->db->get('training_quiz_options');
		//echo $this->db->last_query(); 		exit;
		
		$get_result_arr['quiz_options'] = $get_user->result_array();
		
		return $get_result_arr;
		
	}//end get_training_quiz_details($quiz_id)

	//Function training_quiz_already_answered(): This will check if user have already answered the quiz or not, if yes, return true
	public function training_quiz_already_answered($user_id,$quiz_id){

		$this->db->dbprefix('training_quiz_session');
		$this->db->where('user_id',$user_id);
		$this->db->where('quiz_id',$quiz_id);
		$get_result = $this->db->get('training_quiz_session');
		//echo $this->db->last_query(); 		exit;
		$num_of_rows = $get_result->num_rows();
		
		if($num_of_rows > 0)
			return true;
		else
			return false;
		
	}//end training_quiz_already_answered($user_id,$quiz_id)
	

	//Function add_quiz_result($user_id,$data): This function will store the attempted question into the session 
	public function add_quiz_result($user_id,$data,$purchased_data){

		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$get_quiz_details = $this->get_training_quiz_details($quiz_id);
		
		$correct_answer = $get_quiz_details['quiz_question']['correct_option_id'];
		$answer_status = ($correct_answer == $answer_radio) ? 'T' : 'F';
		
		$already_answered = $this->training_quiz_already_answered($user_id,$quiz_id);
		
		if($already_answered){
			//User have already answered the quiz, update his answer	

			//Record insert into database
			$upd_data = array(
			
				'answer_id' => $this->db->escape_str(trim($answer_radio)),
				'answer_status' => $this->db->escape_str(trim($answer_status)),
			);
			
			//Inserting User data into the database. 
			$this->db->where('user_id',$user_id);
			$this->db->where('quiz_id',$quiz_id);
			$this->db->dbprefix('training_quiz_session');
			$ins_into_db = $this->db->update('training_quiz_session', $upd_data);
			
		}else{
			//User have not yet answered the quiz so insert
			
			//Record insert into database
			$ins_data = array(
			
				'user_id' => $this->db->escape_str(trim($user_id)),
				'order_id' => $this->db->escape_str(trim($purchased_data['id'])),
				'quiz_id' => $this->db->escape_str(trim($quiz_id)),
				'training_id' => $this->db->escape_str(trim($training_id)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			);
			
			//Mark and insert into the DB as Skippedif questions are marked as skip
			if($action == 'submit_skip'){
				$ins_data['is_skipped'] = $this->db->escape_str(trim('1'));
				$ins_data['answer_id'] = $this->db->escape_str(trim('0'));
				$ins_data['answer_status'] = $this->db->escape_str(trim('F'));

			}else{
				$ins_data['is_skipped'] = $this->db->escape_str(trim('0'));
				$ins_data['answer_id'] = $this->db->escape_str(trim($answer_radio));
				$ins_data['answer_status'] = $this->db->escape_str(trim($answer_status));
				
			}//end if($action == 'submit_skip')

			//Inserting User data into the database. 
			$this->db->dbprefix('training_quiz_session');
			$ins_into_db = $this->db->insert('training_quiz_session', $ins_data);
			
		}//end if($already_answered)
		
		//echo $this->db->last_query(); 		exit;
		return true;
		
	}//end add_quiz_result($user_id,$data)

	//Function quiz_evaluate_result(): This function is called when the quiz process is complete and user have completed all the required questions
	public function quiz_evaluate_result($user_id,$data,$quiz_data_arr,$training_purchased_data){
		
		extract($data);
		
		$last_attempted_date = date('Y-m-d G:i:s');
		
		//Calculating Passed Percentage;
		$correct_attempts = $quiz_data_arr['quiz_data']['total_correct'];
		$wrong_attempts = $quiz_data_arr['quiz_data']['total_wrong'];
		
		$total_questions = $quiz_data_arr['quiz_data']['total_questions'];
		$quiz_percentage = ($correct_attempts / $total_questions) * 100;
		
		//Get Passed Criteria from Training Database.
		$get_training_details = $this->get_training_course_details($training_id);
		$required_percentage = $get_training_details['training_pass_percentage'];
		
		if($quiz_percentage < $required_percentage){
			
			$is_quiz_passed = 0;
			$quiz_data['quiz_result'] = 'F';
			$implementation_date = NULL;
			
		}else{
			
			$is_quiz_passed = 1;
			$implementation_date = date('Y-m-d G:i:s');
			$quiz_data['quiz_result'] = 'P';

			//Once the Purchased user order details is updated, now its time to remove user session from session table
			$this->db->dbprefix('training_quiz_results');
			$this->db->where('user_id',$user_id);
			$this->db->where('training_id',$training_id);
			$this->db->where('order_id',$training_purchased_data['id']);
			$delate_data = $this->db->delete('training_quiz_results');
			
			//echo $this->db->last_query(); 		exit;
			
			//If the quiz is passed, save the passed quiz results into the database for future/ admin review.
			$quiz_qry = "INSERT INTO `kod_training_quiz_results` (order_id, user_id, quiz_id, training_id, answer_id, answer_status, is_skipped, created_date, created_by_ip) SELECT order_id, user_id, quiz_id, training_id, answer_id, answer_status, is_skipped, created_date, created_by_ip FROM `kod_training_quiz_session` WHERE user_id = '".$user_id."' AND training_id = '".$training_id."'";
			
			$rs_quiz_qry = $this->db->query($quiz_qry);

		}//end if($quiz_percentage < $required_percentage)

		$quiz_data['quiz_percentage'] = $quiz_percentage;
		
		//Increase number of attempts
		$no_of_attempts = $training_purchased_data['no_of_attempts'] + 1;
		$quiz_data['no_of_attempts'] = $no_of_attempts;
		
		//Record insert into database
		$upd_data = array(
		
			'last_quiz_date' => $this->db->escape_str(trim($last_attempted_date)),
			'last_quiz_percentage' => $this->db->escape_str(trim($quiz_percentage)),
			'is_quiz_passed' => $this->db->escape_str(trim($is_quiz_passed)),
			'implementation_date' => $this->db->escape_str(trim($implementation_date)),
			'no_of_attempts' => $this->db->escape_str(trim($no_of_attempts))
		);

		if($quiz_data['quiz_result'] == 'P'){
			$upd_data['quiz_pass_date']	= date('Y-m-d G:i:s');
			$upd_data['quiz_passed_by_ip']	= $this->input->ip_address();
		}//end if($quiz_data['quiz_result'] == 'P')

		//Update data into the database. 
		$this->db->dbprefix('user_order_details');
		$this->db->where('id',$training_purchased_data['id']);
		$this->db->where('user_id',$user_id);
		$this->db->where('product_id',$training_id);
		$this->db->where('product_type','TRAINING');
		
		$upd_into_db = $this->db->update('user_order_details',$upd_data);
		//echo $this->db->last_query(); 		exit;

		if($upd_into_db){
			
			//Once the Purchased user order details is updated, now its time to remove user session from session table
			$this->db->dbprefix('training_quiz_session');
			$this->db->where('user_id',$user_id);
			$this->db->where('order_id',$training_purchased_data['id']);
			$delate_date = $this->db->delete('training_quiz_session');
			
			return $quiz_data;
			
		}//end if($upd_into_db)

	}//end quiz_evaluate_result($user_id,$data,$quiz_data_arr,$training_purchased_data)
	
	//Function save_training_rating(): Save the Rating of PGD into the order detail table.
	public function save_training_rating($user_id,$data){
		
		extract($data);

		//Record insert into database
		$upd_data = array(
			'star_rating' => $this->db->escape_str(trim($rating)),
		);

		//Inserting User data into the database. 
		$this->db->where('id',$pu_id);
		$this->db->where('product_type','TRAINING');
		$this->db->where('user_id',$user_id);
		$this->db->dbprefix('user_order_details');
		$upd_into_db = $this->db->update('user_order_details', $upd_data);
		//echo $this->db->last_query(); 		exit;
		
		//Recalculating Average Rating from the order table
		$this->db->dbprefix('user_order_details');
		$this->db->select('AVG(star_rating) as average_rating');
		$this->db->where('product_id',$pid);
		$this->db->where('product_type','TRAINING');
		
		$get_result = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		$average_rating_arr = $get_result->row_array();
		$average_rating = $average_rating_arr['average_rating'];
		
		//Storing Average Rating into the database

		//Record insert into database
		$upd_data = array(
			'star_rating' => $this->db->escape_str(trim($average_rating)),
		);
		
		//Inserting User data into the database. 
		$this->db->where('id',$pid);
		$upd_into_db = $this->db->update('package_training', $upd_data);
		//echo $this->db->last_query(); 		exit;

		if($upd_into_db)
			return true;
		else
			return false;
	}//end save_training_rating()
	
	//Function get_training_certificate(): Prepare Training certificate to download as PDF
	public function get_training_certificate($user_id,$training_id){

		$get_training_details = $this->training->get_training_course_details($training_id);
		
		//Verify if user is allowed to see this TRAINING page or not. This will only possible if the TRAINING is purchased and not expired.
		$training_access_allowed = $this->training->verify_training_purchased_by_user($this->session->id,$training_id);
		
		if($training_access_allowed && $training_access_allowed['is_quiz_passed']){
			//TRAINING is purchased by the user, quiz is passed, doctor and pharmacist have approved the PGD, It means now we can preparfe the verified PGD
			
			$get_user_details = $this->users->get_user_details(filter_string($training_access_allowed['user_id']));
			
			$user_full_name = ucwords(filter_string($get_user_details['user_full_name'])); // User Full Name
			$user_registration_no = filter_string($get_user_details['registration_no']); // Reg Num
			
			//Certificate Body
			$training_certificate_body = filter_string($get_training_details['training_certificate_body']);
			
			$search_arr = array('[FULL_NAME]','[REGISTRATION_NO]','[SITE_LOGO]','[CERTIFICATE_DATE]','[TRAINING_NAME]');
			
			$replace_arr = array($user_full_name,$user_registration_no,SITE_LOGO,kod_date_format(filter_string($training_access_allowed['implementation_date'])),filter_string($get_training_details['course_name']));
			
			$training_certificate_body = str_replace($search_arr,$replace_arr,$training_certificate_body);
			
		}else{
			//User should see teh sample ceritificate now
			$training_certificate_body = filter_string($get_pgd_details['training_certificate_body']);	
			
		}//end if($training_access_allowed)
		
		//echo  $training_certificate_body;
		//exit;
		
		$training_name = filter_string($get_training_details['course_name']);
		$training_name = str_replace(' ','-',strtolower($training_name)).'-certificate.pdf';

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf->SetFooter($pgd_name.'|{PAGENO}|'.date('D, d M y G:i:s')); // Add a footer for good measure 
		$pdf->WriteHTML($training_certificate_body); // write the HTML into the PDF
		
		$pdf->Output($training_name,'D'); // save to file because we can

	}//end get_training_certificate($user_id,$training_id)

	//This will save the training reviws
	public function submit_training_review($user_id,$data){
		
		extract($data);
		$review_date = date('Y-m-d');
		
		//Record insert into database
		$upd_data = array(
			'reviews' => $this->db->escape_str(trim($reviews)),
			'review_date' => $this->db->escape_str(trim($review_date)),
		);
		
		//Inserting User data into the database. 
		$this->db->where('user_id',$user_id);
		$this->db->where('id',$order_detail_id);
		$this->db->dbprefix('user_order_details');
		$upd_into_db = $this->db->update('user_order_details', $upd_data);
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		else
			return false;

	}//end submit_training_review($user_id,$data)
	
}//end file
?>