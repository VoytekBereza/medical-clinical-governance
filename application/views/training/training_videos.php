<?php 
if($training_access_allowed['is_quiz_passed'] == 0 ){
	//If Quiz is not yet passed
	if($total_hours_passed >= filter_string($training_detail_arr['training_reattempt_quiz_hours'])){
		//Means the last attempted time is over and is allowed to retake the test.
		
		//Now check if the number of attempts are over or not
		if($training_access_allowed['no_of_attempts'] >= filter_string($training_detail_arr['training_number_of_attempts_allowed'])){
			//He should not allowed to make any further attempts as number of allowed attempts are over.
?>
			<div class="alert alert-danger alert-dismissable text-center"><strong>Your Number of quiz Re-attempts are over, please contact site administrator for further assistance.</strong></div>
<?php		
		}//end if($training_access_allowed['no_of_attempts'] >= $get_allowed_number_of_attempts['setting_value'])
	
	}else{
	//Total Hours are not yet passed to attempt the next quiz
?>
		<div class="alert alert-danger alert-dismissable text-center"><strong>You cannot reattempt your quiz before <?php echo filter_string($training_detail_arr['training_reattempt_quiz_hours'])?> Hours. Please check back later.</strong></div>
<?php	
	}//end if($total_hours_passed >= $get_training_expiry['setting_value'])
	
}//end if($training_access_allowed['is_quiz_passed'] == 0)

$passed = ($training_access_allowed['is_quiz_passed'] && $training_access_allowed['doctor_approval'] && $training_access_allowed['pharmacist_approval']) ? '1' : 0;
?>
<a name="video_ref" id="video_ref"></a>
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-8">
      
		<?php
			if(count($video_list_arr) > 0){
		?>
            <p class="embed-responsive embed-responsive-4by3">
              <iframe width="100%" height="430" src="<?php echo filter_string($video_list_arr[0]['video_url'])?>" frameborder="0" allowfullscreen id="video_frame"></iframe>
            </p>
            <div class="row" id="pgd_video_list">
                <?php 
                    for($i=0;$i<count($video_list_arr);$i++){
                ?>
                        <div class="col-md-4"> 
                          <a href="javascript:;" id="<?php echo filter_string($video_list_arr[$i]['video_id'])?>" class="video_play" rel="<?php echo filter_string($video_list_arr[$i]['video_type'])?>">
                          <?php 
						  	if(filter_string($video_list_arr[$i]['video_type']) == 0){
							?>
	                          <img alt="" src="http://img.youtube.com/vi/<?php echo filter_string($video_list_arr[$i]['video_id'])?>/0.jpg" class="img-responsive img-hover"> 
                           <?php 
						   	}else{
							?>
                            	<img alt="" src="<?php echo IMAGES?>video_placeholder.jpg" class="img-responsive img-hover"> 
                            <?php	   
						   	}
						   ?>
                            <p class="video_title"><strong><?php echo filter_string($video_list_arr[$i]['video_title'])?></strong></p>
                          </a> 
                      </div>  
                <?php		
                    }//end for($i=0;$i<count($video_list_arr);$i++)
                ?>
            </div>
        
        <?php	
			}else{
		?>
            <p><div role="alert" class="alert alert-danger">No Videos Listed!</div></p>
        <?php			
			}//end if(count($video_list_arr) > 0){
		?>
        
      </div>
      <div class="col-md-4">
        <p> <strong><?php echo filter_string($training_detail_arr['course_name'])?></strong> </p>
        <p>
            
            <input id="training_rating_input_readonly" type="number" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($training_detail_arr['star_rating']) ?>" displayOnly="1" />
             <a href="<?php echo SURL?>training/training-reviews/<?php echo filter_string($training_detail_arr['id'])?>" class="fancybox_pgd_review fancybox.ajax" id="training_review_link">

            <?php
				echo (filter_string($training_access_allowed['star_rating']) == '0') ? 'Click Here to Rate this Product <br />' : '';
				echo number_format($training_detail_arr['star_rating'],1); 
			?> 
            starred - <?php echo count($get_training_reviews_list)?> Reviews</a>
        </p>
        <hr />
        <p><?php echo filter_string($training_detail_arr['long_description'])?></p>
        <hr />
        <?php 
			if($training_access_allowed['is_quiz_passed'] == 1){
		?>
                <p><a href="<?php echo SURL?>training/download-certificate/<?php echo filter_string($training_detail_arr['id']) ?>"  target="_blank" class="btn btn-primary"><i class="fa fa-certificate"></i> Download Certificate</a></p>
        <?php		
			}//end if($training_access_allowed['is_quiz_passed'] == 1)
		?>
        
        <p><hr /><strong>Other Documents </strong></p>
        <ul id="course_video_doc">
        
		<?php 
            if(count($document_list_arr) > 0){
                foreach($document_list_arr as $category_name =>$nodes_arr){
                    if($category_name != 'None'){
            ?>	
                        <li><a href="#"><?php echo $category_name?></a>
                        <ul>
            <?php		
                            for($i=0;$i<count($nodes_arr);$i++){
            ?>
                                <li><i  class="<?php echo filter_string($nodes_arr[$i]['document_icon'])?>"></i> <a href="<?php echo filter_string($nodes_arr[$i]['document_url'])?>" target="_blank"><?php echo filter_string($nodes_arr[$i]['document_title'])?></a></li>
            <?php
                            }//end for
            ?>
                        </ul>
                        </li>
            <?php
                    
                    }//end if($category_name != 'None')
                            
                }//end foreach($document_list_arr as $category_name =>$nodes_arr)
    
                for($i=0;$i<count($document_list_arr['None']);$i++){
            ?>
                        <li><i class="<?php echo filter_string($document_list_arr['None'][$i]['document_icon'])?>"></i> <a href="<?php echo filter_string($document_list_arr['None'][$i]['document_url'])?>" target="_blank"><?php echo filter_string($document_list_arr['None'][$i]['document_title'])?></a></li>
            <?php			
                }//end for
            }else{
            ?>
                 <p><div role="alert" class="alert alert-danger">No Documents Available!</div></p>  
            <?php	
            }//end if(count($document_list_arr) > 0)
            ?>

        </ul>            
        
		<?php 
        if($training_access_allowed['is_quiz_passed'] == 1){
        ?>
        	<hr />
            <div class="alert alert-success alert-dismissable text-center"><strong>Exam Passed</strong></div>
        <?php	
        }//end if($training_access_allowed['is_quiz_passed'] == 0)
        
        if($training_access_allowed['is_quiz_passed'] == 0){
            //If Quiz is not yet passed
            
            if($total_hours_passed >= filter_string($training_detail_arr['training_reattempt_quiz_hours'])){
                //Means the last attempted time is over and is allowed to retake the test.
                
                //Now check if the number of attempts are over or not
                if($training_access_allowed['no_of_attempts'] <= filter_string($training_detail_arr['training_number_of_attempts_allowed'])){
                //User is allowed to take next quiz.
        ?>
                <hr /><br /><p align="center"><a id="2" class="btn btn-success " href="<?php echo SURL ?>training/take-a-quiz/<?php echo filter_string($training_detail_arr['id'])?>"><i class="glyphicon glyphicon-education "></i>  <?php echo (count($chk_previous_quiz_session['quiz_session_arr']) == 0) ? 'Take the Exam' : 'Restart Exam'?></a></p>
                
        <?php 		
                }//end if($training_access_allowed['no_of_attempts'] >= $get_allowed_number_of_attempts['setting_value'])
            
            }//end if($total_hours_passed >= $get_training_expiry['setting_value'])
            
        }//end if($training_access_allowed['is_quiz_passed'] == 0)
        
        ?>        
      </div>
    </div>
  </div>
</div>
