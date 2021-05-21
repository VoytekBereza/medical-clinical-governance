      	<div id="edit_patient_profile">

        	<h4 class="modal-title">Edit Profile Details</h4>

	        <div class="modal-body">
	        	
	        	<div class="col-md-12 col-lg-12">
		    		
                       <form  data-toggle="validator" role="form" action="<?php echo base_url(); ?>organization/pmr/add-edit-patient-process" method="post" 
                       name="add_edit_patient_form" id="add_edit_patient_form" >

		    		<!-- Form fields -->
		    		<div class="" > 
						<!-- Default panel contents -->
						<div class="">
						<p class="align-left"></p>
						<div class="row">
						  <div class="col-md-12">
						      <div class="row">
						        <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
						            <label for="userfirstname">First Name<span class="required">*</span></label>
						            
						            <input type="text" placeholder="First Name" value="<?php echo (filter_string($patient_data['first_name'])) ? filter_string($patient_data['first_name']) : '' ; ?>" required="required"  name="first_name" id="first_name" class="form-control" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">

						          <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
						          <div class="help-block with-errors"></div>
						        </div>
						       </div> <!-- ./row -->
						     <div class="row">
						        <div class="form-group  has-feedback  col-sm-12 col-md-12 col-lg-12">
						            <label for="userlastname">Last Name<span class="required">*</span></label>
						            
						            <input type="text" placeholder="Last Name" value="<?php echo (filter_string($patient_data['last_name'])) ? filter_string($patient_data['last_name']) : '' ; ?>"  required="required" name="last_name" id="last_name" class="form-control" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">

						          <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
						         <div class="help-block with-errors"></div>
						        </div>
						       </div> <!-- ./row -->  
						     <div class="row">
						        <div class="form-group  has-feedback  col-sm-12 col-md-12 col-lg-12">
						             <label for="mobile_no">Mobile Number<span class="required">*</span></label>
						             
						             <input type="digits" placeholder="Mobile Number" name="mobile_no" id="mobile_no" required="required" value="<?php echo (filter_string($patient_data['mobile_no'])) ? filter_string($patient_data['mobile_no']) : '' ; ?>" data-error="Mobile number should start with 07 and length should be 11 numbers." class="form-control"  pattern="^07(?=.*[0-9])[0-9]{9,}$" maxlength="11">

						          <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
						         <div class="help-block with-errors"></div>
						        </div>
						      </div> <!-- ./row -->    
						        <label>Date Of Birth<span class="required">*</span> </label>         						      
<?php
						      	$date = date("d",strtotime($patient_data['dob']));
						     	$dob_month = date("m",strtotime($patient_data['dob']));
						     	$year = date("Y",strtotime($patient_data['dob']));					     
?>
						      <div class="row">
						            <div class="form-group  has-feedback col-sm-4 col-md-4 col-lg-4">
						                <select class="form-control month_february_select" id="birth_date" name="birth_date" required="required">
						                    <option value="">Select Date</option>
						                    <?php 
												for($i=1; $i<=31;$i++){
													if($i <10){
											?>
						                    <option <?php echo ($date == '0'.$i) ? 'selected="selected"' : '' ; ?> value="<?php echo '0'.$i;?>"><?php echo '0'.$i;?></option>
						                   <?php } else {?>
						                   <option <?php echo ($date == $i) ? 'selected="selected"' : '' ; ?> value="<?php echo $i; ?>"><?php echo $i;?></option>
						                    <?php 
						                        	} // End if($i <10)
						                    	} // End for loop
						                    ?>
						               </select> 
						             <div class="help-block with-errors"></div>
						            </div>
						            <?php /*MONTH*/ $month= array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'); ?>
						             <div class="form-group  col-sm-4 col-md-4 col-lg-4">
						                <select class="form-control month_february_select" id="birth_month" name="birth_month" required="required">
						                    <option value="">Select Month</option>
						                     <?php for($i=0;$i<12;$i++){?>
						                        <option <?php echo ($dob_month == $i+1) ? 'selected="selected"' : '' ; ?> value="<?php echo $i+1;?>">
						                            <?php echo $month[$i];?>
						                        </option>
						                      <?php } ?>
						               </select> 
						            	<div class="help-block with-errors"></div>   
						            </div>
						            
						             <div class="form-group col-sm-4 col-md-4 col-lg-4">
						                <select class="form-control month_february_select" id="birth_year" name="birth_year" required="required">
						                    <option value="">Select Year</option>
						                     <?php for($i=date('Y'); $i>=date('Y')-100;$i--){?>
						                    <option <?php echo ($year == $i) ? 'selected="selected"' : '' ; ?> value="<?php echo $i;?>"><?php echo $i;?></option>
						                    <?php } ?>
						               </select> 
						             <div class="help-block with-errors"></div>  
						            </div>
						      </div> <!-- ./row -->

						    <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12" style="padding-left:0px;">
						        
						        <label for="gender"> Gender<span class="required">*</span>  </label>&nbsp;&nbsp;&nbsp;&nbsp;
						        
						        <label class="radio-inline">
						        	<input type="radio" name="gender" <?php echo ($patient_data['gender'] == 'M') ? 'checked="checked"' : '' ; ?> value="M" required="required"> Male </label>
						        
						        <label class="radio-inline">
						        	<input <?php echo ($patient_data['gender'] == 'F') ? 'checked="checked"' : '' ; ?> type="radio" name="gender" value="F" required="required"> Female </label>
						        
						     <div class="help-block with-errors"></div>
						    </div>
						     <div class="row">
						        <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
						            <label for="address">Address 1<span class="required">*</span></label>
						            <input type="text" placeholder="Address" name="address" id="address" required="required" value="<?php echo (filter_string($patient_data['address'])) ? filter_string($patient_data['address']) : '' ; ?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50">
						            <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
						            <div class="help-block with-errors"></div>
						          </div>
						     </div>   <!-- ./row -->
                             <div class="row">
                                <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
                                    <label for="address">Address 2</label>
                                    <input type="text" placeholder="Address" name="address_2" id="address_2" value="<?php echo (filter_string($patient_data['address_2'])) ? filter_string($patient_data['address_2']) : '' ; ?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50">
                                    <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
						            <div class="help-block with-errors"></div>
                                  </div>
                             </div>
                			<div class="row">
                            <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
                                <label for="address">Address 3</label>
                                <input type="text" placeholder="Address" name="address_3" id="address_3" value="<?php echo (filter_string($patient_data['address_3'])) ? filter_string($patient_data['address_3']) : '' ; ?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50">
                                <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
						            <div class="help-block with-errors"></div>
                              </div>
                            </div>
						     <div class="row">
						        <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
						             <label for="post_code">Post Code<span class="required">*</span></label>
						            <input type="text" placeholder="Post Code" name="postcode" id="postcode" required="required" value="<?php echo (filter_string($patient_data['postcode'])) ? filter_string($patient_data['postcode']) : '' ; ?>" class="form-control my_upper_class" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8" >
						          <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
						          <div class="help-block with-errors"></div>
						        </div>
						      </div>    <!-- ./row -->
						     <div class="row">
						        <div class="col-sm-12 col-md-12 col-lg-12">
						         <div class="form-group ">
						            <label for="email_address">Email Address<span class="required">*</span></label>
						            
						            <input type="email" placeholder="Email address" name="email_address_patient" id="email_address_patient"  required="required" value="<?php echo (filter_string($patient_data['email_address'])) ? filter_string($patient_data['email_address']) : '' ; ?>" title="" data-placement="bottom" class="form-control" disabled="disabled" >

						        	
						        </div>
						       	<div id="error_msg_patient" class="error help-block"> </div>
						        </div>
						       </div> <!-- ./row -->
						      	<p></p>
								<div class="modal-footer">
									<div class="col-md-12 col-lg-12">
										<button name="add_edit_patient_btn" id="add_edit_patient_btn" class="btn btn-success" type="submit">Save Changes</button>
										<button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
									</div>
								</div>
						      
						  </div>
						</div> <!-- ./row -->
						</div>
					<!-- Hidden field to track action [ Update Patient ] -->
					<input type="hidden" readonly="readonly" name="update_patient_id" value="<?php echo $patient_data['id']; ?>" />
					
					</div>
                    </form>

	        	</div>
		        	
		   	</div>
	        
      	</div>
        