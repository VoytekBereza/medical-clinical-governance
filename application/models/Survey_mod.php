<?php
class Survey_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }

	//Function get_survey_package(): Get the Record from the Package Table to treat Survey as a Product
	public function get_survey_package($survey_id = 1){

		$this->db->dbprefix('package_survey');
			
		$get = $this->db->get('package_survey');
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_survey_package($survey_id)

	//Function get_survey_questionnaire_details(): Get the Record from the Questinnair Table to get teh question record
	public function get_survey_questionnaire_details($question_id){

		$this->db->dbprefix('survey_question');
		$this->db->where('id',$question_id);
		
		$get = $this->db->get('survey_question');
		
		//echo $this->db->last_query(); 		exit;
		return $get->row_array();
		
	}//end get_survey_package($survey_id)
	
	//Function get_survey_order_details(): Get the Order details of the survey using Survey Id.
	public function get_survey_order_details($survey_ref_no){

		$this->db->dbprefix('user_order_details');
		$this->db->select('user_order_details.*,org_pharmacy_surgery.organization_id,org_pharmacy_surgery.pharmacy_surgery_name');
		
		$this->db->join('org_pharmacy_surgery','org_pharmacy_surgery.id = user_order_details.pharmacy_surgery_id');
		$this->db->where('user_order_details.survey_ref_no',$survey_ref_no);
		$get = $this->db->get('user_order_details');

		//echo $this->db->last_query(); 		exit;
		
		return $get->row_array();
		
	}//end get_survey_order_details($pharmacy_surgery_id='',$survey_ref_no = '')
	
	//Function get_survey_purchased_pharmacies(): Will return the list of purchased and/ or NON purchased Survey for Phramacies
	//P = Return List of Pharmacies Purchased
	//NP = Return List of Pharmacies NOT Purchased 
	//$pharmacy_surgery_id =  If this is specified, means we are checking expiry or existance or purchase Survey of the specific pharmacy.
	public function get_survey_purchased_pharmacies($organization_id,$purchased_non_purchased,$pharmacy_surgery_id='',$survey_ref_no = ''){
		
		if($purchased_non_purchased == 'P'){

			$this->db->dbprefix('org_pharmacy_surgery');
			$this->db->select("org_pharmacy_surgery.*,user_order_details.expiry_date, user_order_details.survey_start_date,user_order_details.survey_ref_no,user_order_details.survey_year, user_order_details.id AS survey_order_id, user_orders.purchase_date,CONCAT(first_name,' ',last_name) AS purchased_by_name");
	
			$this->db->where('org_pharmacy_surgery.organization_id',$organization_id);
			$this->db->where('org_pharmacy_surgery.is_deleted != 1');
			$this->db->where('user_order_details.product_type = "SURVEY"');
			$this->db->where('(user_order_details.expiry_date > "'.date('Y-m-d').'" OR user_order_details.expiry_date = "0000-00-00")');
			if(trim($pharmacy_surgery_id)!='')	$this->db->where('user_order_details.pharmacy_surgery_id',$pharmacy_surgery_id);
			if(trim($survey_ref_no)!='')	$this->db->where('user_order_details.survey_ref_no',$survey_ref_no);
			
			$this->db->where("org_pharmacy_surgery.id IN (SELECT pharmacy_surgery_id FROM kod_user_order_details WHERE product_type = 'SURVEY')");
	
			$this->db->join('user_order_details','org_pharmacy_surgery.id = user_order_details.pharmacy_surgery_id');
			$this->db->join('user_orders','user_orders.id = user_order_details.order_id');
			$this->db->join('users','users.id = user_orders.user_id');
			$get_result = $this->db->get('org_pharmacy_surgery');
			
			//echo $this->db->last_query(); 		
			if(trim($pharmacy_surgery_id)!='') return $get_result->row_array();
			else return $get_result->result_array();
									
		}elseif($purchased_non_purchased == 'NP'){

			//Non Purchased List
			$this->db->dbprefix('org_pharmacy_surgery');
			$this->db->where('org_pharmacy_surgery.organization_id',$organization_id);
			$this->db->where('org_pharmacy_surgery.is_deleted != 1');
			$this->db->where("id NOT IN (SELECT pharmacy_surgery_id FROM kod_user_order_details WHERE product_type = 'SURVEY' AND (expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00'))");
			
			$get_result = $this->db->get('org_pharmacy_surgery');
			//echo $this->db->last_query(); 		exit;
			return $get_result->result_array();

		}//end if($purchased_non_purchased == 'P')
		
	}//end get_survey_purchased_pharmacies($organization_id,$purchased_non_purchased,$pharmacy_surgery_id='')
	
	//Function generate_survey_reference_no(): Generate unique SURVEY REF No, by recursive call.
	public function generate_survey_reference_no(){

		$new_ref_no = strtoupper($this->common->random_number_generator(7));
		
		$this->db->dbprefix('user_order_details');
		$this->db->select('id');
		$this->db->where('survey_ref_no',$new_ref_no);
		$get = $this->db->get('user_order_details');
		//echo $this->db->last_query(); 		exit;
		
		if($get->num_rows > 0)
			$this->generate_survey_reference_no();
		else
			return $new_ref_no;
	}//end generate_survey_reference_no()
	
	//Function start_pharmacy_survey(): This function will start the survey to the current or next facial year depending on the Date/ day user is starting the survey on.
	public function start_pharmacy_survey($pharmacy_surgery_id,$start_pharmacy_survey){
		
		$current_survey_date = date('m/d');
		
		$SURVEY_END_MONTH = 'SURVEY_END_MONTH';
		$survey_end_global_value = get_global_settings($SURVEY_END_MONTH); //Set from the Global Settings
		
		$next_survey_end_date = filter_string($survey_end_global_value['setting_value']);
		
		if(strtotime($current_survey_date) >= strtotime($next_survey_end_date)){
			$next_survey_end = strtotime("$next_survey_end_date +1 year");	
		}else{
			$next_survey_end = strtotime("$next_survey_end_date +0 year");
		}//end if
		
		$expiry_date = date('Y-m-d', $next_survey_end);
		$survey_year = date('Y', $next_survey_end);
		
		$survey_start_date = date('Y-m-d');
		$survey_ref_no = $this->generate_survey_reference_no();

		//Update the Survey Purchased Order with the Survey Start date, also update the expiry date and generate the random surveynum
		$upd_data = array(
		
			'survey_ref_no' => $this->db->escape_str(trim($survey_ref_no)),
			'survey_start_date' => $this->db->escape_str(trim($survey_start_date)),
			'survey_year' => $this->db->escape_str(trim($survey_year)),
			'expiry_date' => $this->db->escape_str(trim($expiry_date)),
		);
		
		$this->db->where('id',$start_pharmacy_survey);
		$this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);
		
		$this->db->dbprefix('user_order_details');
		$upd_into_db = $this->db->update('user_order_details', $upd_data);
		//echo $this->db->last_query(); 		exit;
		if($upd_into_db)
			return true;
		else
			return false;	
		//end if($upd_into_db)
		
	}//end start_pharmacy_survey($pharmacy_surgery_id)
	
	//get_questionnaire_list() : This function will create and return the questionnaire array. The questions having sub_questions will not have the global option section
	public function get_questionnaire_list(){
		
		$this->db->dbprefix('survey_question');
		$this->db->where('status',1);
		$get = $this->db->get('survey_question');
		//echo $this->db->last_query(); 		exit;
		$question_arr = $get->result_array();
		
		//print_this($question_arr);
		
		$questionnaire_arr = array();
		for($i=0;$i<count($question_arr);$i++){
			
			//Get Questions Options 
			$this->db->dbprefix('survey_question_options');
			$this->db->where('question_id',filter_string($question_arr[$i]['id']));
			$get = $this->db->get('survey_question_options');
			//echo $this->db->last_query(); 		exit;
			$sub_options_arr = $get->result_array();
			

			if(filter_string($question_arr[$i]['parent_id']) == 0){
				//Prepar the parent array when Parent = 0
				$questionnaire[filter_string($question_arr[$i]['id'])]['question_id'] = filter_string($question_arr[$i]['id']);
				$questionnaire[filter_string($question_arr[$i]['id'])]['question'] = filter_string($question_arr[$i]['questions']);
				$questionnaire[filter_string($question_arr[$i]['id'])]['sub_notes'] = filter_string($question_arr[$i]['sub_notes']);
				
				$questionnaire[filter_string($question_arr[$i]['id'])]['sub_question'] = array();
				
				for($j=0;$j<count($sub_options_arr);$j++){
					$questionnaire[filter_string($question_arr[$i]['id'])]['options'][filter_string($sub_options_arr[$j]['id'])] = filter_string($sub_options_arr[$j]['options']);
				}//end for($j=0;$j<count($sub_options_arr);$j++)
				
			}else{
				//Question is not a Parent, but a child
				$questionnaire[filter_string($question_arr[$i]['parent_id'])]['sub_question'][filter_string($question_arr[$i]['id'])]['question'] = filter_string($question_arr[$i]['questions']);
				
				for($j=0;$j<count($sub_options_arr);$j++){
					$questionnaire[filter_string($question_arr[$i]['parent_id'])]['sub_question'][filter_string($question_arr[$i]['id'])]['options'][filter_string($sub_options_arr[$j]['id'])] = filter_string($sub_options_arr[$j]['options']);
					
					$questionnaire[filter_string($question_arr[$i]['parent_id'])]['sub_question_options'][$j] = filter_string($sub_options_arr[$j]['options']);
				}//end for($j=0;$j<count($sub_options_arr);$j++)
				
			}//end if(filter_string($question_arr[$i]['parent_id']) == 0)
			
		}//end for($i=0;$i<count($question_arr);$i++)
		
		return $questionnaire;
	}//end get_questionnaire_list()
	
	//Function submit_survey(): Submit the entries into the database against the Survey ID. This is done by the end users when submitting the form
	public function submit_survey($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		
		$ins_data = array(
		
			'pharmacy_surgery_id' => $this->db->escape_str(trim($pharmacy_surgery_id)),
			'survey_ref_no' => $this->db->escape_str(trim($survey_ref_no)),
			'survey_year' => $this->db->escape_str(trim($survey_year)),
			'created_date' => $this->db->escape_str(trim($created_date)),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);
		
		$this->db->dbprefix('surveys');
		$ins_into_db = $this->db->insert('surveys', $ins_data);
		$new_survey_id = $this->db->insert_id();
		
		
		if(count($q) > 0){
			
			foreach($q as $question_id => $option_selected){
				
				if($question_id == 1){
					
					if($option_selected != 4)
						$other_reason_txt = '';
					else
						$other_reason_txt = substr(strip_tags($other_reason_txt),0,250);
						
					$ins_array[] = 
					   array(
							'survey_id' => $this->db->escape_str(trim($new_survey_id)),
							'survey_ref_no' => $this->db->escape_str(trim($survey_ref_no)),
							'question_id' => $this->db->escape_str(trim($question_id)) ,
							'option_id' => $this->db->escape_str(trim($option_selected)) ,
							'option_txt' => $this->db->escape_str(trim($other_reason_txt)) ,
					   );
					
				}elseif($question_id == 10){
					
					$ins_array[] = 
					   array(
							'survey_id' => $this->db->escape_str(trim($new_survey_id)),
							'survey_ref_no' => $this->db->escape_str(trim($survey_ref_no)),
							'question_id' => $this->db->escape_str(trim($question_id)),
							'option_id' => NULL ,
							'option_txt' => $this->db->escape_str(trim($option_selected)),
					   );
					
				}else{
					$ins_array[] = array(
					   
							'survey_id' => $this->db->escape_str(trim($new_survey_id)),
							'survey_ref_no' => $this->db->escape_str(trim($survey_ref_no)),
							'question_id' => $this->db->escape_str(trim($question_id)),
							'option_id' => $this->db->escape_str(trim($option_selected)),
							'option_txt' => '',
					   );
				}
			}//end foreach($q as $question_id => $option_selected)
			
		} //end if(count($q) > 0)
	
		$this->db->dbprefix('surveys_details');
		$ins_data = $this->db->insert_batch('surveys_details', $ins_array); 
		//echo $this->db->last_query(); 		exit;
		
		if($ins_data)
			return true;
		else
			return false;

	}//end function submit_survey()
	
	//Function get_no_of_surveys_attempted(): Retuns count of surveys being attempted against the survey reference number.
	public function get_no_of_surveys_attempted($survey_ref_no){

		$this->db->dbprefix('surveys');
		$this->db->where('survey_ref_no',$survey_ref_no);
		$get = $this->db->get('surveys');
		//echo $this->db->last_query(); 		exit;
		return $get->num_rows();
	}//end get_no_of_surveys_attempted($survey_ref_no)
	
	//Function get_past_survey_list(): Returns the list of all Survey from the order detail page which have started and are expired
	public function get_past_survey_list($pharmacy_surgery_id){

		$current_date = date('Y-m-d');
		$this->db->dbprefix('user_order_details');
		$this->db->select('user_order_details.pharmacy_surgery_id,user_order_details.survey_ref_no,user_order_details.survey_start_date,user_order_details.survey_year,user_order_details.expiry_date,(SELECT count(id) from kod_surveys where kod_user_order_details.survey_ref_no = kod_surveys.survey_ref_no GROUP BY survey_ref_no) AS total_survey_attempt');
		$this->db->where('user_order_details.pharmacy_surgery_id',$pharmacy_surgery_id);
		$this->db->where('user_order_details.product_type','SURVEY');
		$this->db->where('user_order_details.expiry_date != ','0000-00-00');
		$this->db->where('user_order_details.expiry_date < ',$current_date);
		$this->db->group_by('kod_user_order_details.survey_ref_no');
		$this->db->order_by('user_order_details.survey_year','DESC');

		$get = $this->db->get('user_order_details');
		return $get->result_array();
		
	}//end get_past_survey_list($pharmacy_surgery_id)
	
	//Function get_survey_question_stats(): This wil return question complete statitics against the Survey ref no. How many attempts were conducted and what were the options selected. If question id is empty will return the stats of all questions!
	public function get_survey_question_stats($survey_ref_no,$question_id = ''){
		
		$this->db->dbprefix('survey_question');
		$this->db->select("survey_question.*,(SELECT count(id) from kod_surveys WHERE kod_surveys.survey_ref_no = '".$survey_ref_no."') AS total_survey_attempt");
		if($question_id)
		$this->db->where('id',$question_id);
		
		$get = $this->db->get('survey_question');
		//echo $this->db->last_query(); 		exit;
		
		$questionnaire_arr = array();
		
			if($question_id !=''){
				
				$question_arr = $get->row_array();
	
				//Get Questions Options 
				$this->db->dbprefix('survey_question_options');
				$this->db->select("survey_question_options.*,(SELECT count(id) from kod_surveys_details WHERE kod_surveys_details.option_id = kod_survey_question_options.id AND kod_surveys_details.survey_ref_no = '".$survey_ref_no."') AS total_options_attempt");
				
				$this->db->where('survey_question_options.question_id',filter_string($question_id));
				
				$get = $this->db->get('survey_question_options');
				//echo $this->db->last_query(); 		exit;
				$sub_options_arr = $get->result_array();
				
				$questionnaire['parent_id'] = filter_string($question_arr['parent_id']);
				$questionnaire['total_survey_attempt'] = filter_string($question_arr['total_survey_attempt']);
				$questionnaire['question_id'] = filter_string($question_arr['id']);
				
				if(filter_string($question_arr['parent_id']) == 0){
					//Prepar the parent array when Parent = 0
					
					$questionnaire['question_id'] = filter_string($question_arr['id']);
					$questionnaire['question'] = filter_string($question_arr['questions']);
		
					if(filter_string($question_arr['id']) != 10){
		
						$total_options_attempted = 0;
						for($j=0;$j<count($sub_options_arr);$j++){
							$total_options_attempted += filter_string($sub_options_arr[$j]['total_options_attempt']);
							$questionnaire['options_attempts'][filter_string($sub_options_arr[$j]['options'])] = filter_string($sub_options_arr[$j]['total_options_attempt']);
							
							
						}//end for($j=0;$j<count($sub_options_arr);$j++)
						$questionnaire['total_options_attempted'] = $total_options_attempted;
						
						//Get Reason of question 1, if 4th option is selected.
						if(filter_string($question_arr['id']) == 1){

							//Get Question 10, comments
							$this->db->dbprefix('surveys_details');
							$this->db->select("option_txt");
							$this->db->where('survey_ref_no',$survey_ref_no);
							$this->db->where('question_id',filter_string($question_arr['id']));
							$this->db->where('option_id = 4');
							$this->db->where('trim(option_txt) != "" ');

							$get = $this->db->get('surveys_details');
							//echo $this->db->last_query(); 		exit;
							$other_reason_result = $get->result_array();
	
							$questionnaire['other_reasons_txt_arr'] = $other_reason_result;
								
						}//end if(filter_string($question_arr['id']) == 1)
						
					}else{
						
						$comments_qry = "
						SELECT  
						(select count(id) AS commented from kod_surveys_details WHERE survey_ref_no = '".$survey_ref_no."' AND question_id = 10 AND option_txt <> '' ) AS commented,
						(select count(id) AS non_commented from kod_surveys_details WHERE survey_ref_no = '".$survey_ref_no."' AND question_id = 10  AND option_txt = '' ) AS non_commented";
		
						$rs  = $this->db->query($comments_qry);
						$result = $rs->row_array();	
						
						$questionnaire['total_commented'] = filter_string($result['commented']);			
						$questionnaire['total_non_commented'] = filter_string($result['non_commented']);			

						//Get Question 10, comments
						$this->db->dbprefix('surveys_details');
						$this->db->select("option_txt");
						$this->db->where('trim(option_txt) != "" ');
						$this->db->where('survey_ref_no',$survey_ref_no);
						
						$get = $this->db->get('surveys_details');
						//echo $this->db->last_query(); 		exit;
						$comments_result = $get->result_array();

						$questionnaire['comments'] = $comments_result;
						
					}//end if(filter_string($question_arr['id']) != 10)
					
				}else{
					
					//Question is not a Parent, but a child
					$questionnaire['question'] = filter_string($question_arr['questions']);
					
					//Get teh parent question
					$get_parent_question = $this->survey->get_survey_questionnaire_details(filter_string($question_arr['parent_id']));
					$questionnaire['parent_question'] = filter_string($get_parent_question['questions']);
					$total_options_attempted = 0;
					
					for($j=0;$j<count($sub_options_arr);$j++){
						$total_options_attempted += filter_string($sub_options_arr[$j]['total_options_attempt']);
						$questionnaire['options_attempts'][filter_string($sub_options_arr[$j]['options'])] = filter_string($sub_options_arr[$j]['total_options_attempt']);
					}//end for($j=0;$j<count($sub_options_arr);$j++)
					
					$questionnaire['total_options_attempted'] = $total_options_attempted;
					
					
				}//end if(filter_string($question_arr['parent_id']) == 0)
				
		}else{

			$question_arr = $get->result_array();	
			$skip_parent_questions_arr = array(4,5,6,7);

			for($k=0;$k<count($question_arr);$k++){
				
				$question_id = $question_arr[$k]['id'];
				
				//Get Questions Options 
				$this->db->dbprefix('survey_question_options');
				$this->db->select("survey_question_options.*,(SELECT count(id) from kod_surveys_details WHERE kod_surveys_details.option_id = kod_survey_question_options.id AND kod_surveys_details.survey_ref_no = '".$survey_ref_no."') AS total_options_attempt");
				
				$this->db->where('survey_question_options.question_id',filter_string($question_id));
				
				$get = $this->db->get('survey_question_options');
				//echo $this->db->last_query(); echo '<br><br>';
				$sub_options_arr = $get->result_array();
				
				if(!in_array($question_arr[$k]['id'],$skip_parent_questions_arr)){

					$questionnaire[$k]['parent_id'] = filter_string($question_arr[$k]['parent_id']);
					$questionnaire[$k]['total_survey_attempt'] = filter_string($question_arr[$k]['total_survey_attempt']);
					$questionnaire[$k]['question_id'] = filter_string($question_arr[$k]['id']);
					
					if(filter_string($question_arr[$k]['parent_id']) == 0){
	
						//Prepar the parent array when Parent = 0
						$questionnaire[$k]['question_id'] = filter_string($question_arr[$k]['id']);
						$questionnaire[$k]['question'] = filter_string($question_arr[$k]['questions']);
			
						if(filter_string($question_arr[$k]['id']) != 10){
			
							$total_options_attempted = 0;
							for($j=0;$j<count($sub_options_arr);$j++){
								$total_options_attempted += filter_string($sub_options_arr[$j]['total_options_attempt']);
								$questionnaire[$k]['options_attempts'][filter_string($sub_options_arr[$j]['options'])] = filter_string($sub_options_arr[$j]['total_options_attempt']);
							}//end for($j=0;$j<count($sub_options_arr);$j++)
							$questionnaire[$k]['total_options_attempted'] = $total_options_attempted;
							

							//Get Reason of question 1, if 4th option is selected.
							if(filter_string($question_arr[$k]['id']) == 1){
	
								//Get Question 10, comments
								$this->db->dbprefix('surveys_details');
								$this->db->select("option_txt");
								$this->db->where('survey_ref_no',$survey_ref_no);
								$this->db->where('question_id',filter_string($question_arr[$k]['id']));
								$this->db->where('option_id = 4');
								$this->db->where('trim(option_txt) != "" ');
	
								$get = $this->db->get('surveys_details');
								//echo $this->db->last_query(); 		exit;
								$other_reason_result = $get->result_array();
		
								$questionnaire[$k]['other_reasons_txt_arr'] = $other_reason_result;
									
							}//end if(filter_string($question_arr['id']) == 1)
						
						}else{
							
							$comments_qry = "
							SELECT  
							(select count(id) AS commented from kod_surveys_details WHERE survey_ref_no = '".$survey_ref_no."' AND question_id = 10 AND option_txt <> '' ) AS commented,
							(select count(id) AS non_commented from kod_surveys_details WHERE survey_ref_no = '".$survey_ref_no."' AND question_id = 10  AND option_txt = '' ) AS non_commented";
			
							$rs  = $this->db->query($comments_qry);
							$result = $rs->row_array();	
							
							$questionnaire[$k]['total_commented'] = filter_string($result['commented']);			
							$questionnaire[$k]['total_non_commented'] = filter_string($result['non_commented']);			

							//Get Question 10, comments
							$this->db->dbprefix('surveys_details');
							$this->db->select("option_txt");
							$this->db->where('trim(option_txt) != "" ');
							$this->db->where('survey_ref_no',$survey_ref_no);
							
							$get = $this->db->get('surveys_details');
							//echo $this->db->last_query(); 		exit;
							$comments_result = $get->result_array();
							$questionnaire[$k]['comments'] = $comments_result;
							
						}//end if(filter_string($question_arr[$k]['id']) != 10)
						
					}else{
						
						//Question is not a Parent, but a child
						$questionnaire[$k]['question'] = filter_string($question_arr[$k]['questions']);
						
						//Get teh parent question
						$get_parent_question = $this->survey->get_survey_questionnaire_details(filter_string($question_arr[$k]['parent_id']));
						$questionnaire[$k]['parent_question'] = filter_string($get_parent_question['questions']);
						$total_options_attempted = 0;
						
						for($j=0;$j<count($sub_options_arr);$j++){
							$total_options_attempted += filter_string($sub_options_arr[$j]['total_options_attempt']);
							$questionnaire[$k]['options_attempts'][filter_string($sub_options_arr[$j]['options'])] = filter_string($sub_options_arr[$j]['total_options_attempt']);
						}//end for($j=0;$j<count($sub_options_arr);$j++)
						
						$questionnaire[$k]['total_options_attempted'] = $total_options_attempted;
						
					}//end if(filter_string($question_arr[$k]['parent_id']) == 0)	
					
				}//end if(!in_array($question_arr[$k]['id'],$skip_parent_questions_arr)
				
			}//end for($k=0$k<count($question_arr);$k++)
			
		}//end if($question_id !='')
		
		//print_this($questionnaire);
		//exit;
		
		return $questionnaire;
	}//end get_survey_question_stats($survey_ref_no,$question_id)
	
	// Start - public function get_pharmacy_surgery() : Return Pharmacy Surgery [ Array ] by Survey reference Number
	public function get_pharmacy_surgery($survey_ref_no){
		
		$this->db->dbprefix('user_order_details');
		$this->db->select('org_pharmacy_surgery.*');
		
		$this->db->from('user_order_details');
		$this->db->join('org_pharmacy_surgery', 'user_order_details.pharmacy_surgery_id = org_pharmacy_surgery.id');
		
		$this->db->where('user_order_details.survey_ref_no', $survey_ref_no);
		$this->db->where('user_order_details.product_type', "SURVEY");
		
		return $this->db->get()->row_array();
		
	} // End - public function get_pharmacy_surgery()
	
	//Function: email_survey_link($data): This function send survet link to the friend email address.
	public function email_survey_link($data){
		
		extract($data);
		
		$this->load->model('email_mod','email_template');
		
		$email_body_arr = $this->email_template->get_email_template(17);
		
		$email_subject = $email_body_arr['email_subject'];
		$email_subject = str_replace('[PHARMACY_NAME]',$survey_pharmacy_name,$email_subject);
		
		$NOREPLY_EMAIL = 'NOREPLY_EMAIL';
		$noreply_email = get_global_settings($NOREPLY_EMAIL);
		
		$EMAIL_FROM_TXT = 'EMAIL_FROM_TXT';
		$email_from_txt = get_global_settings($EMAIL_FROM_TXT);
		
		$from = filter_string($noreply_email['setting_value']);
		$from_name = filter_string($email_from_txt['setting_value']);
		$to = trim($friend_email_address);
		
		$subject = filter_string($email_subject);
		$email_body = nl2br(filter_string($friend_message));
		
		// Call from Helper send_email function
		$send_email = kod_send_email($from, $from_name, $to, $subject, $email_body);
		
		return true;
		
	}//end email_survey_link($data)
	
}//end file
?>