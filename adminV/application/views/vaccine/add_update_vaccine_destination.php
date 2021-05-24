<?php
	$cms_class = 'active';
	$cms_class_div = 'active in';
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php
            }//end if($this->session->flashdata('err_message'))
            
            if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="x_title">
         <?php if($get_vaccine_destination_details['id']==""){?>
			<h2>Add New Destination <small>Add New Destination</small></h2>
			 <?php } else {?>
            <h2>Update Destination <small>Update Destination</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
            
        <form data-toggle="validator" role="form"  id="add_new_destination_frm" name="add_new_destination_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>vaccine/add-update-vaccine-destination-process">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                 <li role="presentation" class="active"><a href="#general_tab" id="general-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a> </li>
                                 <li role="presentation" class=""><a href="#vaccine_tab" role="tab" id="vaccine-tab" data-toggle="tab" aria-expanded="false">Vaccines</a> </li>
                          </ul>
                        <div id="myTabContent" class="tab-content">
                         	<div role="tabpanel" class="tab-pane fade active in" id="general_tab" aria-labelledby="general-tab">
                          	<div class="form-group has-feedback">
                             <label for="destination_name">Destination Name<span class="required">*</span></label>
                            	
                           		 <input type="text" id="destination" name="destination" required="required" class="form-control" value="<?php echo filter_string($get_vaccine_destination_details['destination'])?>">
                                 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
                           </div>
                        
                            <div class="form-group">
                            <label for="certificate_code" data-toggle="tooltip" data-placement="right"  
                            title="Certificate Code Format (Use M-12 instead of M12, A-12 instead of A12)">Add Certificate Code
                             <i class="fa fa-info-circle"></i> 
                            </label>
                            <input type="text" id="certificate_code" name="certificate_code" class="form-control" value="<?php echo filter_string($get_vaccine_destination_details['certificate_code'])?>">
                          </div>
                        
                        <div class="field_wrapper">
                        <div class="form-group">
                            
                            <?php 
									$risk_reason = explode("##",$get_vaccine_destination_details['risk_area_season']);
									
									$total = count($risk_reason); 
									
							       if(!empty($get_vaccine_destination_details['risk_area_season'])){
								   
								   for($i=0;$i<$total; $i++){
									   
									   //echo 'dd'.$risk_reason[$i]; exit;
								 ?>
                                   <br/>
                                   <label for="risk_area_season" data-toggle="tooltip" data-placement="right"  title="Use multiple textarea to fill each bullet points for Risk Area/ Seasons. To Delete any make the text area blank.">Risk Area Season
                             <i class="fa fa-info-circle"></i> 
                             </label>
                            <textarea id="risk_area_season" name="risk_area_season[]" placeholder="Enter Risk Area Season" rows="3" class="form-control" aria-required="true"><?php echo filter_string($risk_reason[$i])?></textarea>
                            <?php 
									} 
							     }else {
								?>
                                <br/>
                             <label for="risk_area_season" data-toggle="tooltip" data-placement="right"  title="Use multiple textarea to fill each bullet points for Risk Area/ Seasons. To Delete any make the text area blank.">Risk Area Season <i class="fa fa-info-circle"></i> 
                             </label>
                            <textarea id="risk_area_season" name="risk_area_season[]" placeholder="Enter Risk Area Season" rows="3" class="form-control" aria-required="true"><?php echo filter_string($get_vaccine_destination_details['risk_area_season'])?></textarea>
                            <?php }?>
                        </div>
                         <div class="col-lg-3 col-md-3 col-sm-3">
                                <label for="middle-name">&nbsp; </label> <br />
                                <a title="Add field" class="btn btn-info add_button_risk_season" href="javascript:void(0);">Add More</a>
                        </div>
                        </div>
          				</div>
                        
                         	<div role="tabpanel" class="tab-pane fade" id="vaccine_tab" aria-labelledby="vaccine-tab">
                            <p>Select the codes associated with the vaccines which will be visible to the users against them.</p>
                              <div class="row">
                            <?php if(!empty($list_vaccines)){
									$i=0;
						        	foreach($list_vaccines as $each){
									
										//echo $list_vaccines_edit[$i]['vid']; exit;
						     ?>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            	<br />
                                                 <label for="vaccine_name"><?php echo filter_string($each['vaccine_name']);?></label>
                                                <select aria-required="true" class="form-control" id="vaccine_code" name="vaccine_code[]">
                                                    <option value="NULL" <?php if($list_vaccines_edit[$i]['vaccine_code']=="" && $get_vaccine_destination_details['id']!="" && $get_vaccine_destination_details['id']==$list_vaccines_edit[$i]['destination_id']){?> selected="selected"<?php }?>>None</option>
                                                    <option value="R" <?php if($list_vaccines_edit[$i]['vaccine_code']=="R" && $get_vaccine_destination_details['id']!="" && $get_vaccine_destination_details['id']==$list_vaccines_edit[$i]['destination_id']){?> selected="selected"<?php }?>>Recommended</option>
                                                    <?php if($each['id']!="1"){?>
                                                    <option  value="C" <?php if($list_vaccines_edit[$i]['vaccine_code']=="C" && $get_vaccine_destination_details['id']!="" && $get_vaccine_destination_details['id']==$list_vaccines_edit[$i]['destination_id']){?> selected="selected"<?php }?>>Considered</option>
                                                    <?php } ?>
                                                    <?php  if($each['id']=="1"){?>
                                                    <option value="RG*" <?php if($list_vaccines_edit[$i]['vaccine_code']=="RG*" && $get_vaccine_destination_details['id']!="" &&  $get_vaccine_destination_details['id']==$list_vaccines_edit[$i]['destination_id']){?> selected="selected"<?php }?>>Risk in Geographical</option>
                                                    <?php }?>
                                                </select> 
                                               
                                            </div>
                                            <input type="hidden" name="vaccine_id[]" value="<?php echo $each['id']; ?>">
											
                              <?php   
							         $i++;
									}// End fooreach Loop 
                            
                                 } // if 
							 
							 ?>
                              </div> <!-- End row-->
                              </div> 
                           </div>                          
                       </div>
                     <p></p><p></p>
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_vaccine_destination_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_destination_btn" id="new_destination_btn">Update</button>
              							<input type="hidden" name="destination_id" id="destination_id" value="<?php echo filter_string($get_vaccine_destination_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_destination_btn" id="new_destination_btn">Submit</button>
              				<?php }//end if($get_vaccine_destination_details['id'])?>
            		</div>
          	  </div>
          </div>
          </form>
      </div>
    </div>
  </div>
</div>

