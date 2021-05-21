<?php 
if($pgd_access_allowed['is_quiz_passed'] == 0){
	//If Quiz is not yet passed
	
	if($total_hours_passed >= filter_string($pgd_detail_arr['pgd_reattempt_quiz_hours'])){
		//Means the last attempted time is over and is allowed to retake the test.
		
		//Now check if the number of attempts are over or not
		if($pgd_access_allowed['no_of_attempts'] >= filter_string($pgd_detail_arr['pgd_number_of_attempts_allowed'])){
			//He should not allowed to make any further attempts as number of allowed attempts are over.
?>
			<div class="alert alert-danger alert-dismissable text-center">
            	<strong>You have exhausted your number of quiz re-attempts, you are currently locked out of attempting anymore. To unlock this functionality go to your account at <a href="http://uptodate.org.uk" target="_blank">uptodate.org.uk</a>, perform a good quality CPD cycle on the PGD subject, take a screen shot and send it to <a href="mailto:info@voyagermedical.com">info@voyagermedical.com</a>. Your CPD will be assessed by our clinical team and if sufficient your account will be unlocked within 24 hours of receipt.</strong>
            </div>
<?php
		}//end if($pgd_access_allowed['no_of_attempts'] >= $get_allowed_number_of_attempts['setting_value'])
	
	}else{
	//Total Hours are not yet passed to attempt the next quiz
?>
		<div class="alert alert-danger alert-dismissable text-center"><strong>You cannot reattempt your quiz before <?php echo filter_string($pgd_detail_arr['pgd_reattempt_quiz_hours'])?> Hours. Please check back later.</strong></div>
<?php	
	}//end if($total_hours_passed >= $get_training_expiry['setting_value'])
	
}//end if($pgd_access_allowed['is_quiz_passed'] == 0)

if(filter_string($pgd_access_allowed['is_rechas_agreed']) == 0 && filter_string($pgd_detail_arr['is_rechas']) == 1 && !filter_string($pgd_access_allowed['is_quiz_passed'])){
	//If is_rechas is set to 1 in PGD and User have not read the rechas yet. Do not show anything.
?>
    <a class="fancybox_rechas hidden" href="#rechas_inline"></a>

    <div id="rechas_inline" style="display: none ;">
    
    <div class="panel panel-default">
      <div class="panel-heading"><strong>To use our online PGD, you first need to agree to the following:</strong></div>
      <div class="panel-body">
        <form action="<?php echo SURL?>pgd/rechas-submit-process" method="post" enctype="multipart/form-data" name="rechas_frm" id="rechas_frm">
            <?php 
                for($i=0;$i<count($pgd_rechas_list_arr);$i++){
            ?>
                  <div class="row">
                      <div class="col-md-11"><p><label style="font-weight:normal" for="rechas_option_<?php echo filter_string($pgd_rechas_list_arr[$i]['id']);?>"><?php echo nl2br(filter_string($pgd_rechas_list_arr[$i]['rechas_description']))?></label></p></div>
                    <div class="col-md-1"><input type="radio" name="rechas_option" required id="rechas_option_<?php echo filter_string($pgd_rechas_list_arr[$i]['id']);?>" /></div>
                    
                  </div>
            <?php		
                }//end for($i=0$i<count($pgd_rechas_list_arr);$i++)
            ?>
            <div class="row">
                <div class="col-md-12">
                    <label class="error" id="option_error"></label>
                </div>
            </div>
          <div class="row">
            <div class="col-md-11"><p><label style="font-weight:normal" for="terms_option">I agree to the Hubnet <a href="<?php echo SURL?>pages/terms--conditions" target="_blank">Terms &amp; Conditions</a>.</label></p></div>
            <div class="col-md-1"><input type="radio" name="terms_option" id="terms_option" required /></div>
          </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="error" id="error_terms"></label>
                </div>
            </div>
          
          <div class="row">
            <div class="col-md-12">
                <p class="text-right"><button type="submit" id="rechas_sbt" name="rechas_sbt" class="btn btn-success btn-xs"> Submit</button></p>        
            </div>
    
          </div>
          <input type="hidden" readonly="readonly" name="pgd_id" id="pgd_id" value="<?php echo filter_string($pgd_access_allowed['product_id'])?>" />
        </form>
      </div>
    </div>
    </div>
<script>
$(window).load(function() {
   $(".fancybox_rechas").click();
});				

</script>
<?php
	
}else{
	//User have read the rechas, show everthing.
	if($pgd_access_allowed['is_quiz_passed'] && $pgd_access_allowed['doctor_approval'] && $pgd_access_allowed['pharmacist_approval']){
		$passed = 1;
		$pgd_image = filter_string($pgd_detail_arr['pgd_green_image']);
	}else{
		$passed = 0;
		$pgd_image = filter_string($pgd_detail_arr['pgd_red_image']);
	}//end if
	
	if(count($video_list_arr) > 1){
?>
        <div class="row">
            <div class="col-md-12 video-demo">
                <div class="owl-carousel-pgd-gallery">
                    <?php 
                        for($i=0;$i<count($video_list_arr);$i++){
                    ?>
                            <div class="article-video" data-merge="2"><a class="owl-video" href="<?php echo filter_string($video_list_arr[$i]['video_url']) ?>"></a></div>
                    <?php		
                        }//end for($i=0;$i<count($video_list_arr);$i++)
                    ?>
                </div>
            </div>
            
        </div>
<?php		
	}//end if(count($video_list_arr))
?>
	<div class="row">
    	<!--<p><h3>< ?php echo filter_string($pgd_detail_arr['pgd_name'])?></h3></p>-->
    	<div class="col-md-12">
            <?php
			
                if(count($video_list_arr) == 1){
					
            ?>
					<p class=""><iframe width="100%" height="400" src="<?php echo filter_string($video_list_arr[0]['video_url'])?>" frameborder="0" allowfullscreen id="video_frame"></iframe></p>
            <?php
					
                }//end if(count($video_list_arr) > 0)
            ?>
        </div>
    </div>
    <div class="row">
    
      <div class="col-md-12">
        <div class="row" id="pgd_video_list">
          <div class="col-md-8">
            <div class="row">
                <p><img src="<?php echo PGD_IMAGES.$pgd_image?>" class="img-responsive" /></p>
                <p><?php echo filter_string($pgd_detail_arr['long_description'])?></p>
            </div>
          </div>
          <div class="col-md-4">
			<p>
			   <?php
                $averge_rating = get_product_ratings('PGD',$pgd_detail_arr['id']);
                $averge_rating = $averge_rating['avg_rating'];
               ?>
            
                <input id="pgd_rating_input_readonly" type="number" displayOnly="1" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($averge_rating); ?>" />
                
                <a href="<?php echo SURL?>pgd/pgd-reviews/<?php echo filter_string($pgd_detail_arr['id'])?>" class="fancybox_pgd_review fancybox.ajax" id="pgd_review_link">
					<?php 
						echo (filter_string($pgd_access_allowed['star_rating']) == '0') ? 'Click Here to Rate this Product <br />' : '';
						echo number_format($averge_rating,1); 
					?> starred - <?php echo count($get_pgd_reviews_list)?> <?php echo (count($get_pgd_reviews_list) > 1) ? 'Reviews' : 'Review' ?></a>
            </p>
            <p><hr /><strong>RAF Documents</strong></p>
            <?php 
                if(count($pgd_raf_list_arr) > 0){
                    for($i=0;$i<count($pgd_raf_list_arr);$i++){
            ?>
                    <p><a href="<?php echo filter_string($pgd_raf_list_arr[$i]['raf_document_url'])?>" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-stethoscope "></i> <?php echo filter_string($pgd_raf_list_arr[$i]['raf_title'])?></a></p>
            <?php		
                    }//end for($i=0$i<count($pgd_raf_list_arr);$i++)
                }else{
            ?>
                    <p><div role="alert" class="alert alert-danger">No RAF's Available!</div></p>        
            <?php			
                }//end if(count($pgd_raf_list_arr) > 0)
            ?>
            
            <p><hr /><strong>Download PGDs</strong></p>
            <?php 
				if(!$belong_to_any_organization){

					//If do not bleong to any organizatin he cannot be authenticated. Now he shuld always see RED button. with the NOTE!
					if(count($pgd_subpgds_list_arr) > 0){
						
						for($i=0;$i<count($pgd_subpgds_list_arr);$i++){
				?>
                            <p><a href="<?php echo SURL?>pgd/download-pgd-certificate/<?php echo filter_string($pgd_subpgds_list_arr[$i]['pgd_id'])?>/<?php echo filter_string($pgd_subpgds_list_arr[$i]['id'])?>"  target="_blank" class="btn btn-danger btn-xs"><i class="fa fa-certificate"></i> <?php echo filter_string($pgd_subpgds_list_arr[$i]['subpgd_name'])?></a></p>
				<?php		
						}//end for($i=0$i<count($pgd_subpgds_list_arr);$i++)

				?>
						<div class="alert alert-danger" role="alert"><strong>NOTE:</strong> <p>In order to download the PGD you first must become a member of an organisation. Please inform your manager or superintendent that you have a Hubnet Account and that they themselves need to have an account and invite yourself so that the PGDs can be used at their premises.</p></div>                
                <?php							
					}else{
            ?>
						<p><div role="alert" class="alert alert-danger">No PGDs Available!</div></p>        
            <?php			
                	}//end if(count($pgd_subpgds_list_arr) > 0)
						
				}else{
					
					//Belong to some organization
					if(!$this->session->pharmacy_surgery_id){
			?>
						<div class="alert alert-danger" role="alert"><strong>NOTE:</strong> <p> It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the dropdown above.</p>
                        
                        </div>          
			<?php				
					}else{
						
						if(count($pgd_subpgds_list_arr) > 0){
						
							for($i=0;$i<count($pgd_subpgds_list_arr);$i++){
			?>
                            	<p><a href="<?php echo SURL?>pgd/download-pgd-certificate/<?php echo filter_string($pgd_subpgds_list_arr[$i]['pgd_id'])?>/<?php echo filter_string($pgd_subpgds_list_arr[$i]['id'])?>"  target="_blank" class="btn <?php echo ($passed == 1) ? 'btn-success' : 'btn-danger'?> btn-xs"><i class="fa fa-certificate"></i> <?php echo filter_string($pgd_subpgds_list_arr[$i]['subpgd_name'])?></a></p>
			<?php		
							}//end for($i=0$i<count($pgd_subpgds_list_arr);$i++)
						
							if($passed){
							
            ?>
								<p><a href="<?php echo SURL?>pgd/download-certificate/<?php echo filter_string($pgd_detail_arr['id'])?>"  target="_blank" class="btn btn-primary"><i class="fa fa-certificate"></i> Download Certificate</a></p>
					
			<?php		
        	            	}else if($pgd_access_allowed['is_quiz_passed'] && !($pgd_access_allowed['doctor_approval'] && $pgd_access_allowed['pharmacist_approval'])){
								//If quiz passed and waiting for authorization
			?>
            					<p><div role="alert" class="alert alert-danger">Waiting Authorisation!</div></p>
            <?php					
							}//end if($passed)
                    
    	            	}else{
            ?>
                    	<p><div role="alert" class="alert alert-danger">No PGDs Available!</div></p>        
            <?php			
	                	}//end if(count($pgd_subpgds_list_arr) > 0)
					
					}//end if(!$this-session->pharmacy_surgery_id)
					
				}//if(!$belong_to_any_organization)
				
			?>
            <p><hr /><strong>Other Documents</strong></p>
				<ul id="pgd_doc">

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
    	                                <li><i class="<?php echo filter_string($nodes_arr[$i]['document_icon'])?>"></i> <a href="<?php echo filter_string($nodes_arr[$i]['document_url'])?>" target="_blank"><?php echo filter_string($nodes_arr[$i]['document_title'])?></a></li>
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
            if($pgd_access_allowed['is_quiz_passed'] == 0){
                //If Quiz is not yet passed
                
                if($total_hours_passed >= filter_string($pgd_detail_arr['pgd_reattempt_quiz_hours'])){
                    //Means the last attempted time is over and is allowed to retake the test.
                    
                    //Now check if the number of attempts are over or not
                    if($pgd_access_allowed['no_of_attempts'] <= filter_string($pgd_detail_arr['pgd_number_of_attempts_allowed'])){
                    //User is allowed to take next quiz.
            ?>
            		<hr /><br />
                    <p align="center"><a id="2" class="btn btn-success " href="<?php echo SURL ?>pgd/take-a-quiz/<?php echo filter_string($pgd_detail_arr['id'])?>"><i class="glyphicon glyphicon-education "></i> <?php echo (count($chk_previous_quiz_session['quiz_session_arr']) == 0) ? 'Take the Exam' : 'Restart Exam'?></a></p>
                    
            <?php 		
                    }//end if($pgd_access_allowed['no_of_attempts'] <= $get_allowed_number_of_attempts['setting_value'])
                
                }//end if($total_hours_passed >= $get_training_expiry['setting_value'])
                
            }else{
            ?>
            	<hr />
                <div class="alert alert-success alert-dismissable text-center"><strong>Exam Passed</strong></div>
            <?php	
            }//end if($pgd_access_allowed['is_quiz_passed'] == 0)
            
            ?>
          </div>
        </div>
      </div>
    </div>

	
<?php
}//end if(filter_string($pgd_access_allowed['is_rechas_agreed']) == 0 && filter_string($pgd_detail_arr['is_rechas']) == 1)
?>