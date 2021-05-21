<?php 
if($training_access_allowed['is_quiz_passed'] == 0){
	//If Quiz is not yet passed
	if($total_hours_passed >= $training_details_arr['training_reattempt_quiz_hours']){
		//Means the last attempted time is over and is allowed to retake the test.
		
		//Now check if the number of attempts are over or not
		
		if($training_access_allowed['no_of_attempts'] >= $training_details_arr['training_number_of_attempts_allowed']){
			//He should not allowed to make any further attempts as number of allowed attempts are over.
?>
			<div class="alert alert-danger alert-dismissable"><h3>Your Number of Re-attempts are over, please contact site administrator for further assistance.</h3></div>
<?php		
		}else{
		//User is allowed to take next quiz.
		
			if(count($get_quiz_list['quiz_question']) > 0){
?>
            <div id="training_quiz_container">
                  <form action="#" method="post" enctype="multipart/form-data" name="training_quiz_frm" id="training_quiz_frm">
                    <div class="row">
                      
                      <div class="row col-md-6 pull-right">
                        
                        <div class="text-center text-primary"> <h3> Questions Remaining (<?php echo (filter_string($previous_quiz_session['quiz_data']['total_attmpted'])+1)?>/<?php echo filter_string($previous_quiz_session['quiz_data']['total_questions'])?>) </h3>
                        </div>

                      </div>

                      <div class="col-md-12">
                        <p class="page-header"><!--Question:--> <?php echo filter_string($get_quiz_list['quiz_question']['question'])?></p>
                        <p>
                        <ul id="horizontal-list">
                            <?php 
                                for($i=0;$i<count($get_quiz_list['quiz_options']);$i++){
                            ?>
                          <li type="a">
                            <label for="optionsRadios_<?php echo $i ?>">
                              <input type="radio" value="<?php echo filter_string($get_quiz_list['quiz_options'][$i]['id'])?>" id="optionsRadios_<?php echo $i ?>" name="answer_radio" required>
                              <?php echo filter_string($get_quiz_list['quiz_options'][$i]['option'])?></label>
                          </li>
                            <?php		
                                }//end for
                            ?>
                        </ul>
                            <label for="answer_radio" class="error"></label>
                        </p>
                      </div>
                        <div class="col-md-4 pull-left" >
                        
                            <?php
                                //If its a first question, do not show previous option 
                                if(count($previous_quiz_session['quiz_data']['quiz_session']) > 0){
                            ?>
                                  <!-- Previous Question -->
                                  <button type="button" name="submit_prev" id="submit_prev" class="btn btn-danger pull-right submit_quiz pull-left" >
                                    <i class="fa fa-arrow-left"></i> Previous Question
                                  </button>
                            
                            <?php		
                                }//end if(count($previous_quiz_session['quiz_data']['quiz_session']) == 0)
                            ?>
    
                     </div>                  
                      <div class="col-md-4" align="center">
                          <!-- SKIP Button -->
                          <!--<button type="button" name="submit_skip" id="submit_skip" class="btn btn-warning pull-center submit_quiz">
                            <i class="fa fa-arrows"></i>  Skip Question
                          </button>-->
                      </div>
                      <div class="col-md-4 pull-right">
                        <button type="button" name="submit_quiz" id="submit_quiz" class="btn btn-success pull-right submit_quiz">
                          Answer &amp; Continue <i class="fa fa-arrow-right"></i>
                      </button>
                      </div>
                     
                     
                      <div id="overlay_addaquiz" class="overlay hidden">
                        <div class="col-md-12 text-center" style="margin-top:150px;"> <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> </div>
                      </div>
                    </div>
                        <input type="hidden" name="quiz_id" value="<?php echo filter_string($get_quiz_list['quiz_question']['quiz_id'])?>" readonly="readonly" />
                        <input type="hidden" name="training_id" value="<?php echo filter_string($get_quiz_list['quiz_question']['training_id'])?>" readonly="readonly" />
                        <input type="hidden" name="prev_quiz_id" value="<?php echo filter_string($prev_quiz_id)?>" readonly="readonly" />
                        <input type="hidden" name="prev_quiz_id_index" value="<?php echo filter_string($prev_quiz_id_index)?>" readonly="readonly" />
                    
                  </form>
            </div>
<?php		
			}else{
?>
				<div class="alert alert-danger alert-dismissable"><h3>No Questions found in this quiz, please contact your site administrator.</h3></div>
<?php			
			}//end if(count($get_quiz_list['quiz_question']) > 0)
		
		}//end if($training_access_allowed['no_of_attempts'] >= $get_allowed_number_of_attempts['setting_value'])
	
	}else{
	//Total Hours are not yet passed to attempt the next quiz
?>
		<div class="alert alert-danger alert-dismissable"><h3>You cannot reattempt your quiz before <?php echo $training_details_arr['training_reattempt_quiz_hours'] ?> Hours. Please check back later.</h3></div>
<?php	
	}//end if($total_hours_passed >= $get_training_expiry['setting_value'])
	
}else{
?>
	<div class="alert alert-danger alert-dismissable"><h3>What You're Doing here? You already have passed your test =))</h3></div>
<?php	
}//end if($training_access_allowed['is_quiz_passed'] == 0)

?>
<style>
	#horizontal-list label {
		display:block !important;
	}
</style>