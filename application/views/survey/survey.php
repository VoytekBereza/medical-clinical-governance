
<!-- Display Success Message Contents -->
<?php if($this->session->flashdata('ok_message')){ ?>
	<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php }//if($this->session->flashdata('ok_message'))?>
<style>
	label{
		font-weight:normal;
	}
	
	#survey_container .row {
		font-size:15px;
	}

</style>

<div class="row" id="survey_container">
	<div class="col-md-12">
        <p>
            <div class="row">
                 <div class="col-md-12 text-center">
                    <h3>Community Pharmacy Patient Questionnaire</h3>
                </div>
            </div> <!-- ./row -->
            
            <hr /><br />
            <form action="<?php echo SURL?>survey/submit-survey" id="manage_survey_frm" name="manage_survey_frm" method="POST" enctype="multipart/form-data">
            
            <div class="row">
                 <div class="col-md-12 text-center">
                    <h4>This section is about why you visited the pharmacy today</h4>
                </div>
            </div>    <!-- ./row -->  
            <hr />                   
            <?php 
                foreach($questionnnair_arr as $question_id => $question_list){
                    
                    if($question_id == 4){
            ?>
                        <div class="row">
                             <div class="col-md-12 text-center">
                                <h4>This section is about the pharmacy and the staff who work there more generally, not just for today's visit</h4>
                            </div>
                        </div>    <!-- ./row -->  
                        <hr />                                  
            <?php			
                    }elseif($question_id == 11){
            ?>
                        <div class="row">
                             <div class="col-md-12 text-center">
                                <h4>These last few questions are just to help us categorise your answers</h4>
                            </div>
                        </div>   <!-- ./row -->    
                        <hr />                                  
            <?php			
                    }//end if($question_id == 4)
            ?>
                    <div class="row">
                        <div class="col-md-12"><strong>Q<?php echo $question_id?> - <?php echo filter_string($question_list['question']);?></strong> <?php echo filter_string($question_list['sub_notes']);?></strong></div>
                    </div> <!-- ./row -->
             <?php 
                    if($question_id !=10){
						
                        if(count($question_list['sub_question']) == 0){
                            
                            $total_options = count($question_list['options']);
                            $per_cell = floor(12/$total_options);
            ?>
                                <div class="row">
                                <br />
            <?php 
                                foreach($question_list['options'] as $option_id => $option_list){
            ?>
                                    <div class="col-md-<?php echo $per_cell;?>" <?php echo ($question_id == 11) ? 'style="width: 120px;"' : '' ?> >

                                            <div class="radio radio-danger radio-circle">
                                                <input type="radio" required="required" value="<?php echo filter_string($option_id)?>" id="opt_<?php echo $question_id.'_'.$option_id?>" name="q[<?php echo $question_id?>]" >
                                                <label for="opt_<?php echo $question_id.'_'.$option_id?>"><?php echo filter_string($option_list);?></label>
                                                
                                            </div>                                        
                                         </div>
            <?php		
                                }//end for($i=0;$i<$total_options;$i++)
            ?>
                                </div> <!-- ./row -->
           <?php 
                                if($question_id == 1){
           ?>                     
                                    <div class="row" id="other_reason_div">
                                        <br />
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="5" id="other_reason_txt" name="other_reason_txt" placeholder="For some other reason (please write in the reason for your visit):" maxlength="250"></textarea>
                                                <p><i>Max 250 characters allowed </i><br></p>
                                             </div>
                                        </div>
                                    </div><!-- ./row -->
                                
            <?php
                                }//end if($question_id == 1)
                        }else{
            ?>
            
                            <div class="row">
                                <br />
                                <div class="col-md-5"><strong>ANSWERS:</strong> 
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <?php 
										/*
                                            for($i=0;$i<count($question_list['sub_question_options']);$i++){
                                                $total_options = count($question_list['sub_question_options']);
                                                $per_cell = floor(12/$total_options);																			
                                        ?>
                                        
                                                    <div class="col-md-<?php echo $per_cell?>"><strong><?php echo filter_string($question_list['sub_question_options'][$i]);?></strong></div>    	
                                            
                                        <?php 
                                            }//end for($i=0$i<count($question_list['sub_question_options'])$i++)
											*/
                                        ?>
                                    </div> <!-- ./row -->
                                </div>
                            </div> <!-- ./row -->
                           
                            <?php 
                                foreach($question_list['sub_question'] as $subquestion_id =>$subquestion_list){
                            ?>
                                      <div class="row">
                                        <br />
                                        <div class="col-md-12">
                                           <?php echo filter_string($subquestion_list['question']);?><br /><br />
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                            <?php
                                                    $total_options = count($subquestion_list['options']);
                                                    $per_cell = floor(12/$total_options);
                                            
                                                    foreach($subquestion_list['options'] as $suboption_id => $suboption_list){
                                            ?>
                                                        <div class="col-md-<?php echo $per_cell?>">
                                                        
                                                            <div class="radio radio-danger radio-circle">
                                                                <input required="required" type="radio" value="<?php echo filter_string($suboption_id)?>" id="<?php echo $subquestion_id.'_'.$suboption_id?>" name="q[<?php echo filter_string($subquestion_id)?>]">
                                                                <label for="<?php echo $subquestion_id.'_'.$suboption_id?>"><?php echo $suboption_list?></label>
                                                            </div>        
                                                        </div>
                                            <?php			
                                                    }//end foreach($subquestion_list['options'] as $suboption_id => $suboption_list)
                                            ?>
                                                
                                                
                                            </div> <!-- ./row -->
                                        </div>
                                    </div> <!-- /row-->
                            <?php		
                                }//end foreach($question_list['sub_question'] as $subquestion_id =>$subquestion_list)

                        }//end if(count($question_list['sub_question']) == 0)

                    }else{
            ?>
                        <div class="row">
                            <br />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" id="comment" name="q[<?php echo $question_id?>]" placeholder="[Insert here, if required, additional questions relating to healthcare service provision]" maxlength="250" ></textarea>
                                    <p><i>Max 250 characters allowed </i><br></p>                                    
                                 </div>
                            </div>
                        </div>         <!-- ./row -->                                    
            <?php            
                    }//end if($question_id !=10)
            ?>	
                <hr />
            <?php		
                }//end foreach($questionnnair_arr as $question_id => $question_list)
            ?>
                <input type="hidden" name="survey_ref_no" id="survey_ref_no" value="<?php echo filter_string($survey_order_details['survey_ref_no'])?>" readonly="readonly"/>
                <input type="hidden" name="pharmacy_surgery_id" id="pharmacy_surgery_id" value="<?php echo filter_string($survey_order_details['pharmacy_surgery_id'])?>" readonly="readonly"/>
                <input type="hidden" id="survey_order_id" name="survey_year" value="<?php echo filter_string($survey_order_details['survey_year']);?>" readonly="readonly" >
                <div class="row">
                	<div class="col-md-8">
                    </div>
                	<div class="col-md-4">
	                	<button type="submit" name="submit_suv_btn" id="submit_suv_btn" class="btn btn-success marg2 pull-right">Submit</button>
                    </div>
                </div> <!-- ./row -->
            </form>   
        </p>
    </div>
</div> <!-- ./row -->