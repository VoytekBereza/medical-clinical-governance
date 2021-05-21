<?php
class Pgds_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_pgd_documents(): Get List of PGD documents using pgd_id
	public function get_pgd_documents($pgd_id){

		$this->db->dbprefix('pgd_documents');
		$this->db->select('pgd_documents.*,pgd_documents_category.id AS category_id, 
							pgd_documents_category.category_name');
		$this->db->where('pgd_documents.pgd_id = '.$pgd_id);
		$this->db->where('pgd_documents.status = 1');
		$this->db->join('pgd_documents_category','pgd_documents_category.id = pgd_documents.category_id','LEFT');

		
		$get_result = $this->db->get('pgd_documents');
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
		
	}//end get_pgd_documents()

	//Function get_pgd_rechas_list(): Get List of RECHAS of PGD using pgd_id
	public function get_pgd_rechas_list($pgd_id){

		$this->db->dbprefix('pgd_rechas');
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('status',1);
		$get_user= $this->db->get('pgd_rechas');
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_pgd_rafs_list()

	//Function get_pgd_rafs_list(): Get List of RAF's of PGD using pgd_id
	public function get_pgd_rafs_list($pgd_id){

		$this->db->dbprefix('pgd_raf');
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('status',1);
		$get_user= $this->db->get('pgd_raf');
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_pgd_rafs_list()

	//Function get_pgd_subpgds_list(): Get List of Sub PGDs of PGD using pgd_id or supplye subpgd_id to get the specific subpgd
	public function get_pgd_subpgds_list($pgd_id,$subpgd_id = ''){

		$this->db->dbprefix('pgd_subpgds');
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('status',1);
		
		if($subpgd_id!= ''){
			$this->db->where('id',$subpgd_id);	
			$get = $this->db->get('pgd_subpgds');
			$result_arr = $get->row_array();
			
		}else{
			$get = $this->db->get('pgd_subpgds');
			$result_arr = $get->result_array();
			
		}//end if($subpgd_id!= '')
		
		//echo $this->db->last_query(); 		exit;
		return $result_arr;
		
	}//end get_pgd_subpgds_list()

	//Function get_pgd_videos_list(): Get List of PGD Videos using pgd_id
	public function get_pgd_videos_list($pgd_id){

		$this->db->dbprefix('pgd_videos');
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('status',1);
		$get_user= $this->db->get('pgd_videos');
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_pgd_videos_list()

	//Function get_pgds_list(): will return the list of Active PGDs according to the type specified, O = Oral, V = Vaccines PGD's 
	public function get_pgds_list($pgd_type = ''){

		$this->db->dbprefix('package_pgds');
		if(!empty($pgd_type)) 
			$this->db->where('pgd_type',$pgd_type);
			
		$this->db->where('is_admin_deleted','0');	
		$this->db->where('status',1);
		
		$get_user= $this->db->get('package_pgds');
		
		//echo $this->db->last_query(); 		exit;
		return $get_user->result_array();
		
	}//end get_pgds_list()

	//Function verify_pgd_purchased_by_user(): Return True if the PGD is purchased by the user and is not expired
	public function verify_pgd_purchased_by_user($user_id,$pgd_id){

		$this->db->dbprefix('user_order_details');
		$this->db->where('user_id',$user_id);
		$this->db->where('product_type','PGD');
		$this->db->where('product_id',$pgd_id);
		$this->db->where("(expiry_date >='".date('Y-m-d')."' OR expiry_date = '0000-00-00')");
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		
		$get_user = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		return $get_user->row_array();
		
	}//end verify_pgd_purchased_by_user()

	//Function get_pgd_details(): Get Single Course Detail using pgd_id
	public function get_pgd_details($pgd_id){

		$this->db->dbprefix('package_pgds');
		$this->db->where('id',$pgd_id);
		$this->db->where('is_admin_deleted','0');
		$get_user= $this->db->get('package_pgds');
		//echo $this->db->last_query(); 		exit;
		return $get_user->row_array();
		
	}//end get_pgd_details()
	
	//Function previous_quiz_session(): Retreive the previous session of quiz conducted, returns the array of questions attempted
	public function previous_quiz_session($user_id,$pgd_id){
		
		$this->db->dbprefix('pgd_quiz_session');
		$this->db->where('user_id',$user_id);
		$this->db->where('pgd_id',$pgd_id);
		$this->db->order_by('created_date','ASC');
		
		$get_user = $this->db->get('pgd_quiz_session');
		//echo $this->db->last_query(); 		exit;
		
		$quiz_arr['quiz_session_arr'] = $get_user->result_array();
		
		//Get Total True
		$this->db->dbprefix('pgd_quiz_session');
		$this->db->select('COUNT(id) AS total_true');
		$this->db->where('user_id',$user_id);
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('answer_status','T');
		
		$get_user = $this->db->get('pgd_quiz_session');
		//echo $this->db->last_query(); 		exit;
		$true_result = $get_user->row_array();
		$count_true_result = $true_result['total_true'];
		
		$quiz_arr['count_true_result'] = $count_true_result;

		//Get Total False
		$this->db->dbprefix('pgd_quiz_session');
		$this->db->select('COUNT(id) AS total_false');
		$this->db->where('user_id',$user_id);
		$this->db->where('pgd_id',$pgd_id);
		$this->db->where('answer_status','F');
		
		$get_user = $this->db->get('pgd_quiz_session');
		//echo $this->db->last_query(); 		exit;
		$false_result = $get_user->row_array();
		$count_false_result = $false_result['total_false'];
		
		$quiz_arr['count_false_result'] = $count_false_result;
		
		return $quiz_arr;
		
	}//end previous_quiz_session()
	
	/*Function get_quiz_questions_list() return list of questions which are not attempted by the user yet. This function will not repeat already answered question. Generate Random Results based on Action, 
	submit_quiz => Save the results into the session
	submit_skip => Skip the question and show the next question without saving anything into the database.
	submit_prev => Show the Previous attmpted questions. 
	
	*/
	public function get_quiz_questions_list($user_id,$pgd_id,$data,$action){
		
		extract($data);
		
		$skip_condition = '';
		$next_skip_condition = '';
		$prev_condition = '';
		
		
		if($action == 'submit_skip' || $action == 'submit_quiz' || $action == '')
			$next_skip_condition = "AND kod_pgd_quizes.id  NOT IN (SELECT `kod_pgd_quiz_session`.`quiz_id` FROM `kod_pgd_quiz_session` WHERE `kod_pgd_quiz_session`.user_id = '".$user_id."') ORDER BY RAND()";
			
		if($action == 'submit_skip')
			$skip_condition = "AND kod_pgd_quizes.id <> '".$quiz_id."'";

		//echo $action;
		if($action == 'submit_prev'){
			$prev_condition = "AND kod_pgd_quizes.id = '".$prev_quiz_id."'";
			$skip_condition = '';
			$next_skip_condition = '';
		}//end if($action == 'submit_prev')
		

		$quiz_qry = "SELECT `kod_pgd_quizes`.`id` AS `quiz_id`, `kod_pgd_quizes`.`pgd_id`, `kod_pgd_quizes`.`question`, `kod_pgd_quizes`.`correct_option_id` 
FROM `kod_pgd_quizes` WHERE `kod_pgd_quizes`.`pgd_id` = '".$pgd_id."' $prev_condition $skip_condition $next_skip_condition LIMIT 0,1";

		//exit;

		$rs_quiz_qry = $this->db->query($quiz_qry);
		$quiz_details = $rs_quiz_qry->row_array();

		//echo $this->db->last_query(); 		exit;

		$get_result_arr['quiz_question'] = $quiz_details;
		
		//Get Question Options

		$this->db->dbprefix('pgd_quiz_options');
		$this->db->where('quiz_id',$quiz_details['quiz_id']);
		$this->db->order_by('id', 'DESC');
		$get_user= $this->db->get('pgd_quiz_options');
		//echo $this->db->last_query(); 		exit;
		
		$get_result_arr['quiz_options'] = $get_user->result_array();
		
		return $get_result_arr;

	}//end get_quiz_questions_list($user_id,$pgd_id)

	//Get Quiz details and its options using quiz ID
	public function get_quiz_details($quiz_id){

		$this->db->dbprefix('pgd_quizes');
		$this->db->where('id',$quiz_id);
		$get_result = $this->db->get('pgd_quizes');
		//echo $this->db->last_query(); 		exit;
		$quiz_details = $get_result->row_array();

		$get_result_arr['quiz_question'] = $quiz_details;
		
		//Get Question Options

		$this->db->dbprefix('pgd_quiz_options');
		$this->db->where('quiz_id',$quiz_details['id']);
		$this->db->order_by('id', 'DESC');
		$get_user= $this->db->get('pgd_quiz_options');
		//echo $this->db->last_query(); 		exit;
		
		$get_result_arr['quiz_options'] = $get_user->result_array();
		
		return $get_result_arr;
		
	}//end get_quiz_details($quiz_id)
	
	//Function quiz_already_answered(): This will check if user have already answered the quiz or not, if yes, return true
	public function quiz_already_answered($user_id,$quiz_id){

		$this->db->dbprefix('pgd_quiz_session');
		$this->db->where('user_id',$user_id);
		$this->db->where('quiz_id',$quiz_id);
		$get_result = $this->db->get('pgd_quiz_session');
		//echo $this->db->last_query(); 		exit;
		$num_of_rows = $get_result->num_rows();
		
		if($num_of_rows > 0)
			return true;
		else
			return false;
		
	}//end quiz_already_answered($user_id,$quiz_id)
	
	//Function add_quiz_result($user_id,$data): This function will store the attempted question into the session 
	public function add_quiz_result($user_id,$data,$purchased_data){

		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$get_quiz_details = $this->get_quiz_details($quiz_id);
		
		$correct_answer = $get_quiz_details['quiz_question']['correct_option_id'];
		$answer_status = ($correct_answer == $answer_radio) ? 'T' : 'F';
		
		$already_answered = $this->quiz_already_answered($user_id,$quiz_id);
		
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
			$this->db->dbprefix('pgd_quiz_session');
			$ins_into_db = $this->db->update('pgd_quiz_session', $upd_data);
			
		}else{
			//User have not yet answered the quiz so insert
			
			//Record insert into database
			$ins_data = array(
			
				'user_id' => $this->db->escape_str(trim($user_id)),
				'order_id' => $this->db->escape_str(trim($purchased_data['id'])),
				'quiz_id' => $this->db->escape_str(trim($quiz_id)),
				'pgd_id' => $this->db->escape_str(trim($pgd_id)),
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
			$this->db->dbprefix('pgd_quiz_session');
			$ins_into_db = $this->db->insert('pgd_quiz_session', $ins_data);
			
		}//end if($already_answered)
		
		//echo $this->db->last_query(); 		exit;
		return true;
		
	}//end add_quiz_result($user_id,$data)
	
	//This function is called when the quiz process is complete and user have completed all the required questions
	public function quiz_evaluate_result($user_id,$data,$quiz_data_arr,$pgd_purchased_data){
		
		extract($data);
		
		$last_attempted_date = date('Y-m-d G:i:s');
		
		//Calculating Passed Percentage;
		$correct_attempts = $quiz_data_arr['quiz_data']['total_correct'];
		$wrong_attempts = $quiz_data_arr['quiz_data']['total_wrong'];
		
		$total_questions = $quiz_data_arr['quiz_data']['total_questions'];
		$quiz_percentage = ($correct_attempts / $total_questions) * 100;
		
		//Get Passed Criteria from PGD Database.
		$get_pgd_details = $this->get_pgd_details($pgd_id);
		$required_percentage = $get_pgd_details['pgd_pass_percentage'];
		
		if($quiz_percentage < $required_percentage){
			
			$is_quiz_passed = 0;
			$quiz_data['quiz_result'] = 'F';
			
		}else{
			
			$is_quiz_passed = 1;
			$quiz_data['quiz_result'] = 'P';
			
			//Delete the previous taken survey from the table against the order_id, so in case reattempt is taken it will shw the latest record not the previous test record.

			//Once the Purchased user order details is updated, now its time to remove user session from session table
			$this->db->dbprefix('kod_pgd_quiz_results');
			$this->db->where('user_id',$user_id);
			$this->db->where('pgd_id',$pgd_id);
			$this->db->where('order_id',$pgd_purchased_data['id']);
			$delate_data = $this->db->delete('kod_pgd_quiz_results');
			
			//echo $this->db->last_query(); 		exit;
			
			//If the quiz is passed, save the passed quiz results into the database for future/ admin review.
			$quiz_qry = "INSERT INTO `kod_pgd_quiz_results` (order_id, user_id, quiz_id, pgd_id, answer_id, answer_status, is_skipped, created_date, created_by_ip) SELECT order_id, user_id, quiz_id, pgd_id, answer_id, answer_status, is_skipped, created_date, created_by_ip FROM `kod_pgd_quiz_session` WHERE user_id = '".$user_id."' AND pgd_id = '".$pgd_id."'";

			$rs_quiz_qry = $this->db->query($quiz_qry);

		}//end if($quiz_percentage < $required_percentage)

		$quiz_data['quiz_percentage'] = $quiz_percentage;
		
		//Increase number of attempts
		$no_of_attempts = $pgd_purchased_data['no_of_attempts'] + 1;
		$quiz_data['no_of_attempts'] = $no_of_attempts;
		
		//Record insert into database
		$upd_data = array(
		
			'last_quiz_date' => $this->db->escape_str(trim($last_attempted_date)),
			'last_quiz_percentage' => $this->db->escape_str(trim($quiz_percentage)),
			'is_quiz_passed' => $this->db->escape_str(trim($is_quiz_passed)),
			'no_of_attempts' => $this->db->escape_str(trim($no_of_attempts))
		);
		
		if($quiz_data['quiz_result'] == 'P'){
			
			$upd_data['quiz_pass_date']	= date('Y-m-d G:i:s');
			$upd_data['quiz_passed_by_ip']	= $this->input->ip_address();
			
		}//end if($quiz_data['quiz_result'] == 'P')

		//Update data into the database. 
		$this->db->dbprefix('user_order_details');
		$this->db->where('id',$pgd_purchased_data['id']);
		$this->db->where('user_id',$user_id);
		$this->db->where('product_id',$pgd_id);
		$this->db->where('product_type','PGD');
		
		$upd_into_db = $this->db->update('user_order_details',$upd_data);
		//echo $this->db->last_query(); 		exit;

		if($upd_into_db){
			
			//Once the Purchased user order details is updated, now its time to remove user session from session table
			$this->db->dbprefix('pgd_quiz_session');
			$this->db->where('user_id',$user_id);
			$this->db->where('order_id',$pgd_purchased_data['id']);
			$delate_date = $this->db->delete('pgd_quiz_session');
			
			return $quiz_data;
			
		}//end if($upd_into_db)

	}//end quiz_evaluate_result($user_id,$data)
	
	//function update_pgd_rechas_setting(): This will set the rechas setting to 1, against the paid PGD. If is_Rechas is set to 1
	public function update_pgd_rechas_setting($user_id,$data){

		//Record insert into database
		$upd_data = array(
			'is_rechas_agreed' => $this->db->escape_str(trim(1)),
		);
		
		//Inserting User data into the database. 
		$this->db->where('user_id',$user_id);
		$this->db->where('id',$data['id']);
		$this->db->dbprefix('user_order_details');
		$upd_into_db = $this->db->update('user_order_details', $upd_data);
		
		if($upd_into_db)
			return true;
		//echo $this->db->last_query(); 		exit;
		
	}//end update_pgd_rechas_setting($user_id,$data)

	//Function save_pgd_rating(): Save the Rating of PGD into the order detail table.
	public function save_pgd_rating($user_id,$data){
		
		extract($data);

		//Record insert into database
		$upd_data = array(
			'star_rating' => $this->db->escape_str(trim($rating)),
		);
		
		$this->db->where('id',$pu_id);
		$this->db->where('product_type','PGD');
		$this->db->where('user_id',$user_id);
		$this->db->dbprefix('user_order_details');
		$upd_into_db = $this->db->update('user_order_details', $upd_data);
		//echo $this->db->last_query(); 		exit;
		
		//Recalculating Average Rating from the order table
		$this->db->dbprefix('user_order_details');
		$this->db->select('AVG(star_rating) as average_rating');
		$this->db->where('product_id',$pid);
		$this->db->where('product_type','PGD');
		
		$get_result = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		$average_rating_arr = $get_result->row_array();
		$average_rating = $average_rating_arr['average_rating'];
		
		//Storing Average Rating into the database

		//Record insert into database
		$upd_data = array(
			'star_rating' => $this->db->escape_str(trim($average_rating)),
		);
		
		//Update User data into the database. 
		$this->db->where('id',$pid);
		$upd_into_db = $this->db->update('package_pgds', $upd_data);
		//echo $this->db->last_query(); 		exit;

		if($upd_into_db)
			return true;
		else
			return false;
	}//end save_pgd_rating()
	
	//Function get_pgd_subpgds_certificate(): Prepare PDG version of the SubPGD. This will transform the TOKENS into whatever is defined
	//$is_owner_si_org_id will contain organization ID, is selected user is teh owner or an SI. We ill use CQC Pharamcy name for him, else the selected pharmacy
	//If Pharmacy_surgery_id is set will use the pharmacy name in CQC Pharmacy
	public function get_pgd_subpgds_certificate($user_id,$pgd_id,$subpgd_id, $is_owner_si_org_id = '', $pharmacy_surgery_id = ''){
		
		$get_subpgdpgd_certificate = $this->pgds->get_pgd_subpgds_list($pgd_id,$subpgd_id);
		
		//Verify if user is allowed to see this PGD page or not. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);
		
		if($pgd_access_allowed && $pgd_access_allowed['is_quiz_passed'] && $pgd_access_allowed['doctor_approval'] && $pgd_access_allowed['pharmacist_approval']){
			
			$cqc_details = $this->get_cqc_details($pgd_access_allowed['cqc_set_id']);			
			
			//PGD is purchased by the user, quiz is passed, doctor and pharmacist have approved the PGD, It means now we can preparfe the verified PGD
			
			$get_user_details = $this->users->get_user_details(filter_string($pgd_access_allowed['user_id']));
			
			$user_full_name = ucwords(filter_string($get_user_details['user_full_name'])); // User Full Name
			$user_registration_no = filter_string($get_user_details['registration_no']); // Reg Num
			
			$pgd_expiry_date = kod_date_format(filter_string($pgd_access_allowed['expiry_date'])); //Expiry Date
			$pgd_date_of_implementation =  kod_date_format(filter_string($pgd_access_allowed['implementation_date'])); //Expiry Date
			
			$get_pharmacist_signatures = $this->users->get_user_signatures(filter_string($cqc_details['cqc_pharmacist_id']));// User Signatures
			
			if(filter_string($get_pharmacist_signatures['signature_type']) == 'svn')
				$pharmacist_signatures = filter_string($get_pharmacist_signatures['signature']);
			else
				$pharmacist_signatures = "<img src='".filter_string($get_pharmacist_signatures['signature'])."' width='200px' height='60px' />";
			
			$get_pharmacist_details = $this->users->get_user_details(filter_string($cqc_details['cqc_pharmacist_id']));
			$pharmacist_name =  filter_string($get_pharmacist_details['user_full_name']); // Pharmacist Name
			$pharmacist_approval_date = kod_date_format(filter_string($pgd_access_allowed['pharmacist_approval_date'])); //Pharmacist approved date

			$get_doctor_signatures = $this->users->get_user_signatures(filter_string($cqc_details['cqc_doctor_id'])); //Doc signatures

			if(filter_string($get_doctor_signatures['signature_type']) == 'svn')
				$doctor_signatures = filter_string($get_doctor_signatures['signature']);
			else
				$doctor_signatures = "<img src='".filter_string($get_doctor_signatures['signature'])."' width='200px' height='60px' />";
			
			$get_doctor_details = $this->users->get_user_details(filter_string($cqc_details['cqc_doctor_id']));
			$doctor_name = filter_string($get_doctor_details['user_full_name']); // Doctor Name
			$doctor_approved_date = kod_date_format(filter_string($pgd_access_allowed['doctor_approval_date'])); //Doc approved date

			//PHARMACY NAME SELECTTION
			//If this is not empty means the user is an owner or a SI of an Organization, so for Pharmacy Name we will use the Organization CQC Business Name as defined.

			if($is_owner_si_org_id!= ''){
				
				$get_organization_details = $this->organization->get_organization_details(filter_string($is_owner_si_org_id));
				$cqc_pharmacy_name = filter_string($get_organization_details['cqc_pharmacy_name']); //cqc_pharmacy_name
				
			}//end if($is_owner_si_org_id!= '')

			//If pharmacy id is not empty means user is not an owner, not SI, bt a staff member of a pharamcy. This ID will contain the current activated Pharamcy which name we will use on the CQC Pahramcy name
			if($pharmacy_surgery_id!= ''){
				
				$get_pharmacy_details = $this->pharmacy->get_pharmacy_surgery_details(filter_string($pharmacy_surgery_id));
				$cqc_pharmacy_name = filter_string($get_pharmacy_details['pharmacy_surgery_name']); //pharmacy_surgery_name
				
			}//end if($is_owner_si_org_id!= '')

			//CQC CQC_BODY Name
			$cqc_body = filter_string($cqc_details['cqc_body']); //CQC_BODY

			//CQC CQC_MANAGER Name
			$cqc_manager = filter_string($cqc_details['cqc_manager']); //CQC_MANAGER

			$authorized_stamp_path = CQC_STAMPS.filter_string($cqc_details['cqc_stamp']); // Oraganization Stamp
			
			//Certificate Body
			$subpgd_body = filter_string($get_subpgdpgd_certificate['subpgd_certificate_body']);

			//User Own Sigantures!
			$get_user_signatures = $this->users->get_user_signatures(filter_string($user_id)); //Doc signatures
			
			if($get_user_signatures['signature_type']){

				//CQC PGD_DECLARATION_TEXT Name
				$PGD_DECLARATION_TEXT = 'PGD_DECLARATION_TEXT';
				$pgd_declaration_arr = get_global_settings($PGD_DECLARATION_TEXT); //Set from the Global Settings
				$pgd_declaration = filter_string($pgd_declaration_arr['setting_value']); //PGD_DECLARATION_TEXT

				if(filter_string($get_user_signatures['signature_type']) == 'svn')
					$user_signatures = filter_string($get_user_signatures['signature']);
				else
					$user_signatures = "<img src='".filter_string($get_user_signatures['signature'])."' width='200px' height='60px' />";
			}else{
				$pgd_declaration = '';
				$user_signatures = '';
			}//end if(!$get_user_signatures)
			
			$search_arr = array('[FULL_NAME]','[REGISTRATION_NO]','[DATE_OF_IMPLEMENTATION]','[BUSINESS_ADDRESS]','[PHARMACIST_NAME]','[PHARMACIST_SIGNATURE]','[PHARMACIST_APPROVED_DATE]','[DOCTOR_NAME]','[DOCTOR_SIGNATURE]','[DOCTOR_APPROVED_DATE]','[AUTHORIZED_STAMP_PATH]','[CQC_BODY]','[CQC_MANAGER]','[PGD_DECLARATION_TEXT]','[USER_SIGNATURE]');
			$replace_arr = array($user_full_name, $user_registration_no, $pgd_date_of_implementation, $cqc_pharmacy_name, $pharmacist_name, $pharmacist_signatures, $pharmacist_approval_date,$doctor_name, $doctor_signatures, $doctor_approved_date, $authorized_stamp_path, $cqc_body, $cqc_manager, $pgd_declaration, $user_signatures);
			
			$subpgd_body = str_replace($search_arr,$replace_arr,$subpgd_body);

			$subpgd_body .='
			<pagebreak [ P ] /><div style="border:solid 1px #ccc; float: left; width:100%"><div style="float:left; width:100%; padding:10px; background-color: #D9EDF7"><table cellpadding="2" cellspacing="10" width="100%">
				<tbody>
					
					<tr>
						<td style="padding:10px"><img src="'.IMAGES.'/fa-eye.png" width="30" /></td>
						<td style="padding:10px"><strong>'.uk_date_format($pgd_access_allowed['quiz_pass_date']).'</strong><br />
						'.uk_date_format($pgd_access_allowed['quiz_pass_date'],true).'</td>
						
						<td style="padding:10px">
							Exam Completed <br />
							<strong>IP:</strong> '.filter_string($pgd_access_allowed['quiz_passed_by_ip']).'
						</td>
					</tr>
					<tr>
						<td style="padding:10px"><img src="'.IMAGES.'fa-signature.png" width="30" /></td>
						<td style="padding:10px"><strong>'.uk_date_format($pgd_access_allowed['doctor_approval_date']).'</strong><br />
						'.uk_date_format($pgd_access_allowed['doctor_approval_date'],true).'</td>
						<td style="padding:10px">Signed by Doctor: <strong>'.filter_name($doctor_name).'</strong> <br />
						<strong>IP:</strong> '.filter_string($pgd_access_allowed['approval_ip']).'</td>
					</tr>
					<tr>
						<td style="padding:10px"><img src="'.IMAGES.'fa-check.png" width="30" /></td>
						<td style="padding:10px"><strong>'.uk_date_format($pgd_access_allowed['implementation_date']).' </strong><br />
						'.uk_date_format($pgd_access_allowed['implementation_date'],true).'</td>
						<td style="padding:10px">The document has been authorised.</td>
					</tr>
				</tbody>
			</table></div>';
			
			$subpgd_body .= '
			<div style="float:left; width:100%" class="main-font">
				<div style="text-align:justify; width:70%; float:left; padding:10px 10x; color:#A3A3A3; font-size:12px;" >'.$pgd_declaration.'</div>
				<div style="text-align:right; width:20%; float:left">'.$user_signatures.'</div>
			</div> </div>';			

			//echo $subpgd_body; exit;
		}else{
			
			//User should see teh sample ceritificate now
			$subpgd_body = filter_string($get_subpgdpgd_certificate['subpgd_certificate_body']);			

			$search_arr = array('[FULL_NAME]','[REGISTRATION_NO]','[DATE_OF_IMPLEMENTATION]','[BUSINESS_ADDRESS]','[PHARMACIST_NAME]','[PHARMACIST_SIGNATURE]','[PHARMACIST_APPROVED_DATE]','[DOCTOR_NAME]','[DOCTOR_SIGNATURE]','[DOCTOR_APPROVED_DATE]','[CQC_BODY]','[CQC_MANAGER]','[PGD_DECLARATION_TEXT]','[USER_SIGNATURE]');
			$replace_arr = array('','', '', '', '', '', '','', '', '', '', '', '', '');
			
			$subpgd_body = str_replace($search_arr,$replace_arr,$subpgd_body);
			
			$authorized_stamp_path = ORG_STAMP.'default-stamp.png'; // Oraganization Default Stamp
			$subpgd_body = str_replace('[AUTHORIZED_STAMP_PATH]',$authorized_stamp_path,$subpgd_body);
			
		}//end if($pgd_access_allowed)
		
		$subpgd_name = filter_string($get_subpgdpgd_certificate['subpgd_name']);
		$subpgd_pdf_name = str_replace(' ','-',strtolower($subpgd_name)).'.pdf';

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf->SetFooter($subpgd_name.'|{PAGENO}|'.date('D, d M y G:i:s')); // Add a footer for good measure 
		$pdf->WriteHTML($subpgd_body); // write the HTML into the PDF
		
		$pdf->Output($subpgd_pdf_name,'D'); // save to file because we can

	}//end get_pgd_subpgds_certificate($user_id,$pgd_id,$subpgd_id)


	//Function get_pgd_certificate(): Prepare PDG certificate to download as PDF
	public function get_pgd_certificate($user_id,$pgd_id){

		$get_pgd_details = $this->pgds->get_pgd_details($pgd_id);
		
		//Verify if user is allowed to see this PGD page or not. This will only possible if the PGD is purchased and not expired.
		$pgd_access_allowed = $this->pgds->verify_pgd_purchased_by_user($this->session->id,$pgd_id);
		
		if($pgd_access_allowed && $pgd_access_allowed['is_quiz_passed'] && $pgd_access_allowed['doctor_approval'] && $pgd_access_allowed['pharmacist_approval']){
			
			//PGD is purchased by the user, quiz is passed, doctor and pharmacist have approved the PGD, It means now we can preparfe the verified PGD
			
			$get_user_details = $this->users->get_user_details(filter_string($pgd_access_allowed['user_id']));
			
			$user_full_name = ucwords(filter_string($get_user_details['user_full_name'])); // User Full Name
			$user_registration_no = filter_string($get_user_details['registration_no']); // Reg Num
			
			//Certificate Body
			$pgd_certificate_body = filter_string($get_pgd_details['pgd_certificate_body']);
			
			$search_arr = array('[FULL_NAME]','[REGISTRATION_NO]','[SITE_LOGO]','[CERTIFICATE_DATE]');
			
			$replace_arr = array($user_full_name,$user_registration_no,SITE_LOGO,kod_date_format(date('Y-m-d')));
			
			$pgd_certificate_body = str_replace($search_arr,$replace_arr,$pgd_certificate_body);
			
		}else{
			
			//User should see teh sample ceritificate now
			$pgd_certificate_body = filter_string($get_pgd_details['pgd_certificate_body']);	
			
		}//end if($pgd_access_allowed)
		
		$pgd_name = filter_string($get_pgd_details['pgd_name']);
		$pgd_name = str_replace(' ','-',strtolower($pgd_name)).'-certificate.pdf';

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf->SetFooter($pgd_name.'|{PAGENO}|'.date('D, d M y G:i:s')); // Add a footer for good measure 
		$pdf->WriteHTML($pgd_certificate_body); // write the HTML into the PDF
		
		$pdf->Output($pgd_name,'D'); // save to file because we can

	}//end get_pgd_certificate($user_id,$pgd_id)
	
	// Start - get_all_unauthenticated_pgds(): Get All UnAuthenticated PGDS for listing
	public function get_all_unauthenticated_pgds($organization_id,$user_type, $login_user_id){
		
		if($user_type==1)
			$where = "(default_doctor ='0' || doctor_approval ='0')";
		else
			$where = "(default_pharmacist ='0' || pharmacist_approval ='0')";
			
		//End if
		
		// Unauthetication Users which is default doctor and pharmacist = 0 and organization id != '0' and organization.default_doctor ='0' organization.default_pharmacist ='0'
		$this->db->dbprefix('user_order_details, user_orders, users,package_pgds,usertype,organization');
		$this->db->select('user_order_details.*, user_orders.purchase_date,usertype.user_type, users.first_name, users.last_name,users.email_address,package_pgds.pgd_name');
		$this->db->from('user_order_details');
		
		$this->db->join('user_orders', 'user_order_details.order_id = user_orders.id', 'inner'); 
		$this->db->join('users', 'user_order_details.user_id = users.id', 'inner'); 
		$this->db->join('package_pgds', 'user_order_details.product_id = package_pgds.id', 'inner'); 
		$this->db->join('usertype', 'users.user_type = usertype.id', 'left');
		$this->db->join('organization', 'user_order_details.organization_id = organization.id', 'inner'); 
		
		$this->db->where('user_order_details.is_quiz_passed',1);
		$this->db->where('user_order_details.product_type','PGD'); 
	    $this->db->where($where); 
		$this->db->where('user_order_details.organization_id', $organization_id);
		
		$this->db->order_by('user_order_details.id', 'DESC');
		
		//echo $this->db->last_query(); 		exit;
		return $unauthenticated_arr = $this->db->get()->result_array();			
		
	} // get_all_unauthenticated_pgds($organization_id,$user_type, $login_user_id)
	
	// Function Start unauthenticate_pgds
	public function unauthenticate_pgds($data,$organization_id,$user_type,$login_user_id){
				
		 $arr_val = $data['unauthenticated_pgd']; 
		 
		 foreach($arr_val as $id){
			 
			 $this->db->dbprefix('user_order_details','package_pgds');
			 $this->db->select('user_order_details.product_id ,user_order_details.product_type, package_pgds.pgd_expiry_months, package_pgds.pgd_type,  user_order_details.doctor_approval, user_order_details.pharmacist_approval, package_pgds.seasonal_travel, package_pgds.is_child, user_order_details.expiry_date, user_order_details.user_id, ');
			 $this->db->from('user_order_details');
			 $this->db->join('package_pgds','user_order_details.product_id=package_pgds.id');
			 $this->db->where('user_order_details.id',$id);
			 $this->db->where('user_order_details.organization_id',$organization_id);
			 
		     $db_expiry = $this->db->get()->row_array();

         	 $current_date = date('Y-m-d'); // This Date
			 $db_expiry_month = $db_expiry['pgd_expiry_months'];
			 $expiry_date = date('Y-m-d', strtotime("+$db_expiry_month month", strtotime($current_date)));
			
			 // Get Default User id of Doctor
			 $this->db->dbprefix('users');
			 $this->db->select('id,user_type');
			 $this->db->from('users');
			 $this->db->where('user_type',$user_type);
			 $this->db->where('id',$login_user_id);
		     $default_users_id = $this->db->get()->row_array();

			 if($user_type=='1'){
				 
				$ins_data['doctor_approval'] = 1;
				$ins_data['approvedby_doctor_id'] = $login_user_id;
				$ins_data['doctor_approval_date'] = date('Y-m-d H:i:s');
				
				if($db_expiry['pharmacist_approval'] == 1 && !$db_expiry['is_child']){
					
					$ins_data['implementation_date'] = date('Y-m-d');

				}//end if($db_expiry['pharmacist_approval'] == 1)
				
			 } else if($user_type=='2'){
				 
				$ins_data['pharmacist_approval'] = 1;
				$ins_data['approvedby_pharmacist_id'] = $login_user_id;
				$ins_data['pharmacist_approval_date'] = date('Y-m-d H:i:s');
				
				if($db_expiry['doctor_approval'] == 1 && !$db_expiry['is_child'])
					$ins_data['implementation_date'] = date('Y-m-d G:i:s');
					
			 }//end if($user_type=='1')

			 $this->db->dbprefix('user_order_details');
			 $this->db->where('id',$id);
			 $this->db->where('organization_id',$organization_id);
			 $ins_into_db = $this->db->update('user_order_details', $ins_data);
			// echo $this->db->last_query(); exit;
			
			//Now check if all the information is being approved by doctor as well as pharmacist, now its time to update the expiry date.
			 
			 $this->db->dbprefix('user_order_details');
			 $this->db->select('user_order_details.*');
			 $this->db->from('user_order_details');

			 $this->db->where('user_order_details.is_quiz_passed',1);
		     $this->db->where('user_order_details.product_type','PGD');
			 $this->db->where('user_order_details.doctor_approval',1);
			 $this->db->where('user_order_details.pharmacist_approval',1);
			 $this->db->where('user_order_details.approvedby_doctor_id!=','0');
			 $this->db->where('user_order_details.approvedby_pharmacist_id!=','0');

			 $this->db->where('id',$id);
			 $this->db->where('organization_id',$organization_id);
		    
			 $default_aprroved_by_all = $this->db->get()->row_array();

			if(!empty($default_aprroved_by_all)){

			   if(!$db_expiry['is_child']){
				   //If Not a Child then update the expiry date else leave as it is as the parent expiry wil be update the expiry of their child
				   $ins_data['expiry_date'] = $expiry_date;
	
				   $this->db->dbprefix('user_order_details');
				   $this->db->where('id',$id);
				   $this->db->where('organization_id',$organization_id);
				   $ins_into_db = $this->db->update('user_order_details', $ins_data);
			   }//end if(!$ins_data['is_child'])
			   
				//Selected PGD is Either Travel or Seasonal, its time to set the expiry of all grouped vaccines to be same as the selected one.
				$upd_data = array('expiry_date' => $ins_data['expiry_date'],'implementation_date' => date('Y-m-d G:i:s'), 'approval_ip' => $this->input->ip_address());

			} // end if(!empty($default_aprroved_by_all))

		}// end foreach($arr_val as $id)
		
		if($ins_into_db )
			return true;
		else
			return false;
		
	}  // Function End unauthenticate_pgds ();
	
	public function submit_pgd_review($user_id,$data){
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

	}//end submit_pgd_review($user_id,$data)
	
	public function get_cqc_details($cqc_id){

		$this->db->dbprefix('cqc_sets');
		$this->db->select('cqc_sets.*, cqc_doctor.first_name AS doc_first_name, cqc_doctor.last_name AS doc_last_name, 
							cqc_pharmacist.first_name AS pharma_first_name, cqc_pharmacist.last_name AS pharma_last_name'
						);
		$this->db->from('cqc_sets');
		$this->db->join('users AS cqc_doctor', 'cqc_doctor.id = cqc_sets.cqc_doctor_id', 'LEFT'); 
		$this->db->join('users AS cqc_pharmacist', 'cqc_pharmacist.id = cqc_sets.cqc_pharmacist_id', 'LEFT'); 
		
		$this->db->where('cqc_sets.id',$cqc_id);

		$get_cqc_list = $this->db->get();
		//echo $this->db->last_query(); 		exit;
		return $get_cqc_list->row_array();
		
	}//end get_cqc_details($cqc_id)
	
}//end file
?>