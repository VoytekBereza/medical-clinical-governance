<?php
	if($check_if_survey_purchased){
		$link_survey_no = filter_string($check_if_survey_purchased['survey_ref_no']);
		$survey_link = SURL.'survey/'.$link_survey_no;
	}//end if($check_if_survey_purchased)
?>
<style>
	#survey_container .row {
		font-size:15px;
	}

</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>MANAGE SURVEYS </strong></div>
      <div class="panel-body">
        <p class="align-left"></p>
            <div class="row">
              <div class="col-md-12">

				<?php if($pharmacy_surgery_verified != ''){?>
                	<style>
						label{
							font-weight:normal;
						}
					</style>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
        
                            <!-- Stat - Survey tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#current_survey">Current Survey</a></li>
                                <li><a data-toggle="tab" href="#previous_survey">Previous Surveys</a></li>
                                <?php 
									if($check_if_survey_purchased && ($check_if_survey_purchased['expiry_date'] != '0000-00-00' && $check_if_survey_purchased['survey_start_date'] != '')){
								?>
                                        <li><a data-toggle="tab" href="#survey_form">Live Form</a></li>
                                        <li><a data-toggle="tab" href="#email_form">Email Form</a></li>
                                        <li><a data-toggle="tab" href="#link_form">Link to Form</a></li>
                                        <li><a data-toggle="tab" href="#embed_form">Embed Form </a></li>
                                        <li><a data-toggle="tab" href="#download_tab">Download </a></li>
                                <?php		
									}//end if($check_if_survey_purchased)
								?>
                            </ul>
                            <!-- Start - Survey tabs body -->
                            <div class="tab-content">
                                
                                <div id="current_survey" class="tab-pane fade in active">
                                
                                    <?php 

                                        if(!$check_if_survey_purchased){
                                            //Survey is Expired or not yet purchased
											if($user_org_superintendent || $this->session->is_owner || $my_role_in_pharmacy['is_manager']){
												//Buying is only allowed by OSP
                                    ?>
                                            	<div class="alert alert-danger" style="margin-top:15px">You haven't purchased Survey for this Pharmacy, please click <a href="<?php echo SURL?>organization/single-product-checkout/S/1/<?php echo $this->session->id?>/<?php echo trim($pharmacy_surgery_id)?>" title="Buy Now" class="btn btn-xs btn-warning"><i class="fa fa-paypal"></i> BUY NOW</a> to Purchase now </div>
                                    <?php
											}else{
									?>
                                    			<div class="alert alert-danger" style="margin-top:15px">Survey module is not activate please contact your Superintendent</div>
                                    <?php			
											}//end if($this->user_org_superintendent || $this->session->is_owner || $my_role_in_pharmacy['is_manager'])
											
                                        }else{

                                            //Survey is Not Expired, do the rest!
											if($check_if_survey_purchased['expiry_date'] != '0000-00-00' && $check_if_survey_purchased['survey_start_date'] != ''){
												//The Survey is started and do have the expiry date and start date as well.
									?>			
                                    			<div class="row">
							                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                    	<div class="alert alert-info" style="margin-top:15px">
                                                        	<p>The current survey started on <strong><?php echo kod_date_format($survey_start_date);?></strong> and will end on <strong><?php echo kod_date_format($survey_end_date);?></strong></p>	
                                                            <p><div class="<?php echo ($no_of_surveys_attempted >= $survey_no_of_required_attempts) ? 'success' : 'error';?>">
                                                        <strong> So far you have completed <a href="#"><?php echo $no_of_surveys_attempted?> / <?php echo filter_string($survey_no_of_required_attempts)?></a> surveys. Click <a class="dialogue_window"  id="show_survey_chart"onClick="show_question1();" href="#chart-modal"> View Survey </a> for a summary of the responses you have received so far.</strong></div></p>
                                                        </div>
                                                        
                                                        <p>
                                                        	To reach your survey target, use the tabs above; there are five ways to distribute the form to patients:<br />
                                                            <ol>
                                                            	<li><strong>Live Form</strong> - The easiest way is to fill the form your self or have the patient do it themselves.<br />&nbsp;</li>
                                                                <li><strong>Email Form</strong> - The second way, is to simply click the link from "Email Form Tab" and enter the patients email address, this will send them the survey form direct to their email account. <br />&nbsp;</li>
                                                                <li><strong>Link to Form</strong> - Alternatively, copy the link from the "Link to Form Tab" and paste it directly into your Whatsapp, Facebook, Twitter etc and send it to groups or specific people.<br />&nbsp;</li>
                                                                <li><strong>Embed Form</strong> - Lastly, you can embed the survey on your website, just copy and paste the code from "Embed Form Tab" into a page (like yourpharmacy.com/survey) and then direct patients to that specific page on you website.<br />&nbsp;</li>
                                                                <li><strong>Download template</strong> - This tab allows you to download and print a version of the survey template.<br />&nbsp;</li>
                                                            </ol>
                                                        </p>
                                                    </div>
                                                </div><!-- End Row -->
												
												<!-- Start - Survey Chart Div -->
												<div id="surveys-chart"></div>
												
												<!-- Modal -->
                                                <style>
														body #chart-modal{
															/* new custom width */
															width: 780px;
															/* must be half of the width, minus scrollbar on the left (30px) */

														}												
												</style>
												<div id="chart-modal" style="display:none">
												  <div class="modal-dialog">

														<div id="chart_div_hidden" class="">
														
														<!-- View Image Button -->
														<!-- <button type="button" class="pull-right btn btn-sm btn-info" id="view-chart-png" onClick="view_chart_png();" > Image View </button> -->
														
														<h4><p id="survey-status" class="text-center text-primary pull-right"></p></h4>

                                                        <!-- Dynamic question load from ajax on ID [ survey-question ] -->
														<h6><p id="survey-question" class="text-center"></p></h6>
														
														<!-- load js google chart from ajax on ID [ chart_div ] -->
														<div id="chart_div"></div>
														
														<!-- Div to show question statistics and comments[ for question 1- 10] -->
														<div id="question-comments"></div>
														<div class="row bg-primary" id="question-statistics"></div>
														
														<!-- <div id="chart_image" class="hidden"></div> -->
														
														<!-- Start - Questions Links -->
														<div class="row" id="chart_pagination">
                                                        	<div class="col-md-12">
                                                                <nav>
                                                                    <ul class="pagination pagination-sm">
																		<?php
                                                                        $alphabet_arr = array('a','b','c','d','e','f');
            
                                                                        foreach($questionnnair_arr as $question_id => $question_list){
                                                                        
                                                                            if(count($question_list['sub_question']) == 0){
                                                                            ?>
                                                                                <li><a href="#surveys-chart" class="show-question-chart" id="q_<?php echo $question_id?>-<?php echo filter_string($check_if_survey_purchased['survey_ref_no'])?>" ><?php echo $question_id?></a></li> 
                                                                                
                                                                            <?php } else {
                                                                                
                                                                                $k = 0;
                                                                                foreach($question_list['sub_question'] as $subquestion_id =>$subquestion_list){
                                                                                ?>
                                                                                	<li><a href="#surveys-chart" class="show-question-chart" id="q_<?php echo $subquestion_id?>-<?php echo filter_string($check_if_survey_purchased['survey_ref_no'])?>" ><?php echo $question_id.$alphabet_arr[$k];?></a></li>
                                                                                     

                                                                                <?php $k++;	
                                                                                }//end foreach($question_list['sub_question'] as $subquestion_id =>$subquestion_list)
            
                                                                            }//end if(count($question_list['sub_question']) == 0)
                                                                            
                                                                        }//end foreach($questionnnair_arr as $question_id => $question_list)
                                                                        ?>
                                                                    </ul>
                                                                </nav>
                                                            </div>
														
														</div>
														<!-- End - Questions Links -->
													
													</div>
													<!-- End - Survey Chart Div -->
												</div>
                                                </div>
												
                                    <?php
											}else{
												if($user_org_superintendent || $this->session->is_owner || $my_role_in_pharmacy['is_manager']){
												//Starting survey only allowed by OSP
                                    ?>
	                                            	<p><br />Please select the average amount of prescriptions your pharmacy completes within a month.</p>
                                                    <form action="<?php echo SURL?>organization/start-survey" method="post" name="start_survey_frm" id="start_survey_frm" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered">
                                                                    <thead bgcolor="#F7F7F9">
                                                                      <th>Average Monthly Prescriptions</th>
                                                                      <th>Required Number of Surveys</th>
                                                                      <th>Select</th>
                                                                    </thead>
                                                                    <tr>
                                                                        <td>0 - 2000</td>
                                                                        <td>50</td>
                                                                        <td><input id="opt_1" name="radio_no_of_survey" value="50" class="radio_survey_class" type="radio" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2001 - 4000</td>
                                                                        <td>75</td>
                                                                        <td><input id="opt_2" name="radio_no_of_survey" value="75" class="radio_survey_class" type="radio" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4001 - 6000</td>
                                                                        <td>100</td>
                                                                        <td><input id="opt_3" name="radio_no_of_survey" value="100" class="radio_survey_class" type="radio" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>6001 - 8000</td>
                                                                        <td>125</td>
                                                                        <td><input id="opt_4" name="radio_no_of_survey" value="125" class="radio_survey_class" type="radio" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>8001 - upwards</td>
                                                                        <td>150</td>
                                                                        <td><input id="opt_5" name="radio_no_of_survey" value="150" class="radio_survey_class" type="radio" /></td>
                                                                    </tr>
                                                                </table>
                                                                <label class="error" id="option_error"></label>
                                                            </div>
                                                        </div>
                                                    
														<p><a type="button" name="start_survey_btn" id="start_survey_btn" class="btn btn-success dialogue_window" href="#survey_start_modal"><i class="fa fa-hourglass-start"></i> START <?php echo $survey_session?> SURVEY NOW</a></p>
                                                        <input type="hidden" id="pharmacy_surgery_id" name="pharmacy_surgery_id" value="<?php echo trim($pharmacy_surgery_id)?>" readonly="readonly" >
                                                        <input type="hidden" id="survey_order_id" name="survey_order_id" value="<?php echo filter_string($check_if_survey_purchased['survey_order_id']);?>" readonly="readonly" >
                                                        <input type="hidden" id="survey_year" name="survey_year" value="<?php echo date('Y', $next_survey_end)?>" readonly="readonly" >
                                                    </form>
	                                            <!-- Modal Cancel Invitation -->
                                                <div id="survey_start_modal" style="display:none" >
                                                    <h4 class="modal-title">Confirmation</h4>
                                                    <p>Are you sure you you want to start the Survey <?php echo $survey_session?> for <strong>"<?php echo filter_string($pharmacy_details['pharmacy_surgery_name']);?>"</strong>?</p>
                                                  <div class="modal-footer">
                                                  
                                                    <button class="btn btn-success" type="button" data-dismiss="modal" id="start_survey_modal_btn" name="start_survey_modal_btn" onclick="$('#start_survey_frm').submit();">Ok</button>
                                                    <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
                                                  </div>
                                                </div>                                            
                                    <?php		
												}else{
									?>
                                    				<div class="alert alert-danger" style="margin-top:15px">Survey module is not activate please contact your Superintendent</div>
                                    <?php				
												}//end if($user_org_superintendent || $this->session->is_owner || $my_role_in_pharmacy['is_manager'])
												
											}//end if($check_if_survey_purchased['expiry_date'] != '0000-00-00')
											
                                        }//end if(!$check_if_survey_purchased)
                                    ?>
                                    
                                </div>
                                
                                <div id="previous_survey" class="tab-pane fade">
								
									<!-- Download PDF Form -->
									<form method="post" action="<?php echo base_url(); ?>organization/save-chart-as-pdf">
										
										<!-- Text area having all charts_html_data to post for PDF download -->
										<textarea cols="20" class="hidden" rows="10" id="htmlContentHidden" name="charts_html" ></textarea>
										
										<!-- -->
										<input type ="hidden" id="pharmacy_surgery_name_pdf_footer" name="pharmacy_surgery_name_pdf_footer" value="" />
										<input type ="hidden" id="pharmacy_surgery_address_pdf_footer" name="pharmacy_surgery_address_pdf_footer" value="" />
										<input type ="hidden" id="pharmacy_surgery_zip_pdf_footer" name="pharmacy_surgery_zip_pdf_footer" value="" />
										<!-- -->
										
										<input type="submit" class="hidden" value="Submit" id="save-pdf-form-submit" />
									</form>
									<!-- End - Download PD Form -->
								
                                    <div class="row">
                                    	<br />
                                    	
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered">
                                                    <thead bgcolor="#F7F7F9">
                                                      <th>Survey Year</th>
                                                      <th>Previous Surveys</th>
                                                      <th>Posters</th>
                                                    </thead>
                                                    <?php 
														if(count($past_survey_list) > 0){
															
															for($j=0;$j<count($past_survey_list);$j++){

																$prev_total_survey_attempt = (filter_string($past_survey_list[$j]['total_survey_attempt']) == NULL) ? 0 : filter_string($past_survey_list[$j]['total_survey_attempt']) ;
																$current_date = date('m/d',strtotime(filter_string($past_survey_list[$j]['survey_start_date'])));

																if(strtotime($current_date) >= strtotime($next_survey_end_date))
																	$prev_survey_session = date('Y').'-'.(date('Y')+1);
																else
																	$prev_survey_session = (date('Y', $next_survey_end)-1).' - '.date('Y', $next_survey_end);
																//end if

																if($prev_total_survey_attempt < $survey_no_of_required_attempts){
													?>
                                                                    <tr><td><strong class="text-danger"><?php echo filter_string($prev_survey_session)?></strong></td>
                                                                    <td><a class="btn btn-danger btn-xxs" href="<?php echo SURL?>survey/<?php echo filter_string($past_survey_list[$j]['survey_ref_no'])?>" target="_blank"><i class="glyphicon glyphicon-link"></i> <?php echo $prev_total_survey_attempt?> / <?php echo $survey_no_of_required_attempts?> Surveys completed so far. Click to complete</a></td>
                                                                    <td>n/a</td>
                                                                    </tr>                                                    
                                                    <?php			
																}else{
													?>
                                                                    <tr><td><strong class="text-danger"><?php echo filter_string($prev_survey_session)?></strong></td>
                                                                    <td><a class="btn btn-success btn-xxs" href="#" id="download-previous-survey" name="<?php echo $past_survey_list[$j]['survey_ref_no'];?>" ><i class="fa fa-file-pdf-o"></i>&nbsp; <?php echo filter_string($prev_survey_session)?> Survey Download </a></td>
                                                                    
                                                                    <td><a class="btn btn-warning btn-xxs" href="#" id="download-poster" name="<?php echo $past_survey_list[$j]['survey_ref_no'];?>" ><i class="fa fa-file-pdf-o"></i> <?php echo filter_string($prev_survey_session)?> Poster </a></td></tr>                                                    
                                                    <?php				
																}//end if($total_survey_attempt < $survey_no_of_required_attempts)

															}//end for($j=0;$j<count($past_survey_list);$j++)

														}else{
													?>
                                                        	<tr><td colspan="3"><strong class="text-danger">No Past Surveys found</strong></td></tr>                                                    
                                                    <?php		
														}//end if(count($past_survey_list) > 0)
													?>
                                                </table>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div id="survey_form" class="tab-pane fade">
                                    <div class="row" id="survey_container">
                                        <div class="col-md-12">
                                            <p>
                                                <div class="row">
                                                     <div class="col-md-12 text-center">
                                                        <h3><?php echo ucwords(filter_string($pharmacy_details['pharmacy_surgery_name']));?> Community Pharmacy Patient Questionnaire <?php echo date('Y')?></h3>
                                                    </div>
                                                </div> <!-- ./row -->
                                                
                                                <hr /><br />
                                                <form action="<?php echo SURL?>survey/submit-survey" id="manage_survey_frm" name="manage_survey_frm" method="POST" enctype="multipart/form-data" target="_blank">
                                                            
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
                                                                                                        <label for="<?php echo $subquestion_id.'_'.$suboption_id?>">
                                                                                                           <?php echo $suboption_list?>
                                                                                                        </label>
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
                                                        <input type="hidden" name="survey_ref_no" id="survey_ref_no" value="<?php echo filter_string($check_if_survey_purchased['survey_ref_no'])?>" readonly="readonly"/>
                                                <input type="hidden" name="pharmacy_surgery_id" id="pharmacy_surgery_id" value="<?php echo trim($pharmacy_surgery_id)?>" readonly="readonly"/>
                                                <input type="hidden" id="survey_order_id" name="survey_year" value="<?php echo filter_string($check_if_survey_purchased['survey_year']);?>" readonly="readonly" >                      
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
                                    </div> <!-- /.row-->
                                </div>
                                
                                <div id="email_form" class="tab-pane fade">
                                	<div class="row">
										<div class="col-md-12">
                                            <p><br />
                                                Click the link below and enter the patients email address, this will send them an email which contains the survey which would be delivered direct to their email account.
                                            </p>
                                         </div>
                                     </div>
                                	<div class="row">
										<div class="col-md-12">
                                            <form  data-toggle="validator" role="form" id="send_survey_link_frm" name="send_survey_link_frm" method="post" action="<?php echo SURL ?>organization/send-survey-link-process">
                                            	<div class="row">
                                                    <div class="col-md-12">
                                                        <br />
                                                        <div class="form-group has-feedback">
                                                            <label for="friend_email_address"><strong>Email Address<span class="required">*</span></strong></label>
                                                            <input type="email" required="required" value="" name="friend_email_address" id="friend_email_address"   class="form-control"   pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" maxlength="30">
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		   												<div class="help-block with-errors"></div>  
                                                            
                                                        </div>
                                                        <div class="form-group has-feedback">
                                                            <label for="friend_message"><strong>Message<span class="required">*</span></strong></label>
                                                            <textarea required="required" rows="8" name="friend_message" id="friend_message" class="form-control"><?php echo str_replace('[SURVEY_LINK]',$survey_link,filter_string($email_body))?></textarea>
                                                             
                                                             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		   												<div class="help-block with-errors"></div>  
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="survey_pharmacy_name" id="survey_pharmacy_name" value="<?php echo filter_string($pharmacy_details['pharmacy_surgery_name']);?>" readonly="readonly"  />
                                                        
                                                        <button class="btn btn-success btn-default pull-right" type="submit" id="send_survey_modal_btn" name="send_survey_modal_btn" >Send</button>
                                                    </div>
                                                </div>
                                         </form>                                                   
                                        </div>
                                     </div>

                                </div>
                                
                                <div id="link_form" class="tab-pane fade">
                                	<div class="row">
										<div class="col-md-12">
                                            <p><br />
                                                Copy the link below and paste it directly into your Whatsapp, Facebook, Twitter etc and send it to groups or specific people.
                                            </p>
                                            <p>
                                                <div class="input-group input-group-lg">
                                                  <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-link"></i></span>
                                                  <input type="text" class="form-control" value="<?php echo $survey_link?>" aria-describedby="sizing-addon1"  onfocus="$(this).select();" onclick="$(this).select();">
                                                 
                                                </div>                                                        
                                            </p>                                            
                                        </div>
                                     </div>
                                     

                                </div>
                                
                                <div id="embed_form" class="tab-pane fade">
                                	<div class="row">
										<div class="col-md-12">
                                            <p><br />
                                                To embed the survey on your website, just copy and paste the code below into a page (like yourpharmacy.com/survey) and then direct patients to that specific page on you website.
                                            </p>
                                            <p>
                                                <div class="input-group input-group-lg">
                                                  <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-link"></i></span>
                                                  <input type="text" class="form-control" value="<?php echo htmlentities("<iframe src='".$survey_link."/1' width='100%' height='100%' style='min-height:1500px' frameborder='0'></iframe>")?>" aria-describedby="sizing-addon1"  onfocus="$(this).select();" onclick="$(this).select();">
                                                 
                                                </div>                                                        
                                            </p>
                                        </div>
                                     </div>

                                </div>

                                <div id="download_tab" class="tab-pane fade">

                                    <div class="row offset_top_10">
                                        <div class="col-md-12">
                                            <br />
                                            <p>
                                                I you would like to download a copy of the the CPPQ survey you can click the button below and print the pdf. Once a patient has completed the hard copy for click on the "Live form" tab and then enter the patients response.
                                            </p>
                                            <p><a href="<?php echo PDF ?>cppq__annex_a.pdf" class="btn btn-success" target="_blank">Download Survery Form</a></p>
                                                                                        
                                        </div>
                                     </div>

                                </div>

                            </div>
                            <!-- End - Survey tabs body -->
                        </div>
                      </div>
				<?php } else { ?>

                        <div class="well">
                            <div class="row">
                            
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                                     <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
                                </div>
                                
                            </div>
                        </div>
                        
                <?php }//end if($pharmacy_surgery_id) ?>
              </div>
            </div> <!--End Row -->
			<input type="hidden" name="survey_ref_no" id="survey_ref_no" value="<?php echo filter_string($check_if_survey_purchased['survey_ref_no'])?>" readonly="readonly"/>
      </div>
    </div>
  </div>
</div>

<div id="charts-for-pdf" class="hidden" ></div>

<script type="text/javascript" src="<?php echo JS?>jsapi"></script>
<script>

// Function to show question 1 on click [ first time ]
function show_question1(){
	$('#q_1-<?php echo filter_string($check_if_survey_purchased["survey_ref_no"])?>').click();
} // function show_question1()

// Load the Visualization API and the piechart package.
google.load('visualization', '1', {'packages':['corechart']});
  
// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback();

</script>