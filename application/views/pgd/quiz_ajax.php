<?php 
	if($evaluate_quiz){
		
		if($evaluate_quiz['quiz_result'] == 'P'){
?>

    <!--
			<div class="alert alert-success alert-dismissable"><h3>Congratulations! You have acheived <u>< ?php echo filter_price($evaluate_quiz['quiz_percentage'])?>%</u> marks and successfully passed the assesment test. Please wait for your assessment.</h3></div>
    -->

    <div class="">
        <h3 class="text-success">
          Congratulations! You passed the test.
        </h3>
        <br /> <br />
        <h4> Statistics: </h4>
        
        <table>

          <tbody>

            <tr> 
              <td> <strong>Total Questions:</strong> </td>
              <td> <?php echo $previous_quiz_session['quiz_data']['total_questions']; ?> </td>
            </tr>
            <tr>
              <td> <strong>You Attempted:</strong> </td>
              <td> <?php echo $previous_quiz_session['quiz_data']['total_attmpted']; ?> </td>
            </tr>
            <tr>
              <td> <strong>Correct Answers: </strong> </td>
              <td> <?php echo $previous_quiz_session['quiz_data']['total_correct']; ?> </td>
            <tr> 
              <td> <strong>Percentage:</strong> </td>

              <?php 

                  $correct = $previous_quiz_session['quiz_data']['total_correct'];
                  $total = $previous_quiz_session['quiz_data']['total_questions'];
                  
                  $percent = $correct/$total;
                  $percentage = number_format( $percent * 100, 2 );

                ?>

              <td> <button class="btn btn-xxs btn-success"> <?php echo $percentage.'%'; ?> </button> </td>
            </tr>

          </tbody>

        </table>

        <br /> <br />

        <p>
          Your result have been sent to our authorizing doctor and pharmacist and should be approved within next 24 hours.
        </p>
        <p>
          If you have any issues and if you would like to push through your authentication please do not hesitate to <a href="<?php echo SURL; ?>contactus"> Contact Us</a> or email us at <a href="mailto:info@voyagermedical.com"> info@voyagermedical.com</a>
        </p>

      </div>

<?php				
		}elseif($evaluate_quiz['quiz_result'] == 'F'){
			
?>
    <!-- 
			<div class="alert alert-danger alert-dismissable"><h3>You have acheived <u>< ?php echo filter_price($evaluate_quiz['quiz_percentage'])?>%</u> marks and unfortunately failed your assesment test, please try again after < ?php echo $pgd_details_arr['pgd_reattempt_quiz_hours'] ?> Hours.</h3></div>
    -->

    <div class="">
        <h3 class="text-danger">
          Hi unfortunately you have not passed this time.
        </h3>
        <br /> <br />
        <h4> Statistics: </h4>
        
        <table>

          <tbody>

            <tr> 
              <td> <strong>Total Questions:</strong> </td>
              <td> <?php echo $previous_quiz_session['quiz_data']['total_questions']; ?> </td>
            </tr>
            <tr>
              <td> <strong>You Attempted:</strong> </td>
              <td> <?php echo $previous_quiz_session['quiz_data']['total_attmpted']; ?> </td>
            </tr>
            <tr>
              <td> <strong>Correct Answers: </strong> </td>
              <td> <?php echo $previous_quiz_session['quiz_data']['total_correct']; ?> </td>
            <tr> 
              <td> <strong>Percentage:</strong> </td>

              <?php 

                  $correct = $previous_quiz_session['quiz_data']['total_correct'];
                  $total = $previous_quiz_session['quiz_data']['total_questions'];
                  
                  $percent = $correct/$total;
                  $percentage = number_format( $percent * 100, 2 );

                ?>

              <td> <button class="btn btn-xxs btn-danger"> <?php echo $percentage.'%'; ?> </button> </td>
            </tr>

          </tbody>

        </table>

        <br /> <br />

        <p>
          To pass and have your PGD authenticated you need to pass the MCQ questions with a minimum of <?php echo $pgd_details_arr['pgd_pass_percentage']; ?> within <?php echo $training_details_arr['training_number_of_attempts_allowed']; ?> tries. You may retry this quiz after <?php echo $pgd_details_arr['pgd_reattempt_quiz_hours']; ?>.
        </p>
        <p>
          If you are finding the questions difficult we strongly recommend that you review the material we have supplied and consult best practice documentation.
        <p>
          If you have further issues please do not hesitate to contact our admin team at <a href="mailto:info@voyagermedical.com"> info@voyagermedical.com</a>
        </p>

      </div

><?php				
		}//end if($evaluate_quiz['quiz_result'] == 'P')
		
	}else{
		
?>
		<form action="#" method="post" enctype="multipart/form-data" name="quiz_frm" id="quiz_frm">
  <div class="row">
    
    <div class="row col-md-6 pull-right">
      <div class="text-center text-primary">
        <h3> Questions Remaining (<?php echo (filter_string($previous_quiz_session['quiz_data']['total_attmpted'])+1)?>/<?php echo filter_string($previous_quiz_session['quiz_data']['total_questions'])?>) </h3>
      </div>
    </div>

    <div class="col-md-12">
      <p class="page-header"><!--<span class="text-primary"> Question:</span>--> <?php echo filter_string($get_quiz_list['quiz_question']['question'])?></p>
      <p>
      <ul id="horizontal-list">
        <?php 
                for($i=0;$i<count($get_quiz_list['quiz_options']);$i++){
            ?>
        <li type="a">
          <label for="optionsRadios_<?php echo $i ?>">
         
            <input type="radio" <?php echo ($action == 'submit_prev' && $previous_quiz_session['quiz_data']['quiz_session'][$current_quiz_id_index]['answer_id'] == $get_quiz_list['quiz_options'][$i]['id']) ? 'checked="checked"' : ''  ?>  value="<?php echo filter_string($get_quiz_list['quiz_options'][$i]['id'])?>" id="optionsRadios_<?php echo $i ?>" name="answer_radio" required>
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
            if(strlen($prev_quiz_id_index) > 0){
				if($prev_quiz_id_index != -1){
					
        ?>
              <!-- Previous Question -->
              <button type="button" name="submit_quiz" id="submit_prev" class="btn btn-danger pull-right submit_quiz pull-left" >
                <i class="fa fa-arrow-left"></i> Previous Question
              </button>
        
        <?php		
    	        }//end if($prev_quiz_id_index != -1)
				
			}//end if(strlen($prev_quiz_id_index) > 0)
        ?>

    </div>
    <div class="col-md-4" align="center">
      <!-- SKIP Button -->
      <!--<button type="button" name="submit_quiz" id="submit_skip" class="btn btn-warning pull-center submit_quiz">
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
      <input type="hidden" name="pgd_id" value="<?php echo filter_string($get_quiz_list['quiz_question']['pgd_id'])?>" readonly="readonly" />
      <input type="hidden" name="prev_quiz_id" value="<?php echo filter_string($prev_quiz_id)?>" readonly="readonly" />
      <input type="hidden" name="prev_quiz_id_index" value="<?php echo filter_string($prev_quiz_id_index)?>" readonly="readonly" />
  
</form>
<?php
	}//end if($evaluate_quiz)
?>
<style>
	#horizontal-list label {
		display:block !important;
	}
</style>