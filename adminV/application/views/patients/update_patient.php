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
			<h2>Update patient <small>Update patient</small></h2> 
			<div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form" id="update_user_frm" name="update_user_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>patient/update-patient-process">
          <div class="" role="tabpanel">
            <div>
              <div>
               
                <div class="form-group has-feedback">
                  <label for="page-title">First Name<span class="required">*</span> </label>
                    <input type="text" id="first_name" name="first_name" required="required" class="form-control" value="<?php echo filter_string($get_patient_details['first_name'])?>"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
                   	 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      				<div class="help-block with-errors"></div>
                  </div>
               
                <div class="form-group has-feedback">
                  <label for="page-title">Last Name<span class="required">*</span> </label>
                    <input type="text" id="last_name" name="last_name" required="required" class="form-control" value="<?php echo filter_string($get_patient_details['last_name'])?>"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
                    
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      				<div class="help-block with-errors"></div>
                  </div>
                  
                <div class="form-group has-feedback">
                  <label for="page-title">Mobile Number<span class="required">*</span> </label>
                    <input type="digits" id="mobile_no" name="mobile_no" required="required" class="form-control" value="<?php echo filter_string($get_patient_details['mobile_no'])?>" data-error="Mobile number should start with 07 and length should be 11 numbers."   pattern="^07(?=.*[0-9])[0-9]{9,}$" maxlength="11">
                   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      			  <div class="help-block with-errors"></div>
                 </div>
                
                  <div class="form-group  has-feedback">
                  <label for="email_address">Email Address<span class="required">*</span></label>
                    <input type="email" id="email_address" name="email_address" required="required" class="form-control" value="<?php echo filter_string($get_patient_details['email_address'])?>" pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" maxlength="30">
                   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     			  <div class="help-block with-errors"></div>   
                  </div>
               
                  <div class="form-group has-feedback">
                  <label for="Address">Address 1<span class="required">*</span></label>
                    <input type="text" id="address" name="address" required="required" class="form-control" value="<?php echo filter_string($get_patient_details['address'])?>" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)" maxlength="50">
                   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      			   <div class="help-block with-errors"></div>
                  </div>
                  
                  <div class="form-group has-feedback">
                  <label for="Address">Address 2</label>
                    <input type="text" id="address_2" name="address_2" class="form-control" value="<?php echo filter_string($get_patient_details['address_2'])?>" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)" maxlength="50">
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      			   <div class="help-block with-errors"></div>
                  </div>
                  
                  <div class="form-group has-feedback">
                  <label for="Address">Address 3</label>
                    <input type="text" id="address_3" name="address_3" class="form-control" value="<?php echo filter_string($get_patient_details['address_3'])?>" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)" maxlength="50">
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      			   <div class="help-block with-errors"></div>
                  </div>
                
                  <div class="form-group has-feedback">
                  <label for="email_address">Post Code<span class="required">*</span></label>
                    <input type="text" id="postcode" name="postcode" required="required" class="form-control my_upper_class" value="<?php echo filter_string($get_patient_details['postcode'])?>"  pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*"  data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8" >
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      			   <div class="help-block with-errors"></div>
                </div>
                <?php 
				 	$date = date("d",strtotime($get_patient_details['dob']));
					$month = date("m",strtotime($get_patient_details['dob']));
					$year = date("Y",strtotime($get_patient_details['dob']));
					
				 ?>
                     
                <div class="row ">
                    <div class="form-group has-feedback col-sm-4 col-md-4 col-lg-4">
                     <label> Date Of Birth <span class="required">*</span></label>
                        <select class="form-control month_february_select" id="birth_date" name="birth_date" required="required">
                            <option value="">Select Date</option>
                            <?php for($i=1; $i<=31;$i++){?>
                            <?php if($i <10){?>
                            <option value="<?php echo '0'.$i;?>" <?php if($i==$date){?> selected="selected"<?php }?>><?php echo '0'.$i;?></option>
                           <?php } else {?>
                           <option value="<?php echo $i;?>" <?php if($i==$date){?> selected="selected"<?php }?>><?php echo $i;?></option>
                            <?php 
						   		} // End else
							} // End for loop
							?>
                       </select> 
      			     <div class="help-block with-errors"></div>
                    </div>
                        
                     <?php /*MONTH*/ $month_arr= array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'); ?>
                     <div class="form-group has-feedback col-sm-4 col-md-4 col-lg-4">
                     <label style="color:#FFF;"> Montth </label>
                        <select class="form-control month_february_select" id="birth_month" name="birth_month" required="required">
                            <option value="">Select Month</option>
							<?php for($i=0;$i<12;$i++){?>
                                <option value="<?php echo $i+1;?>" <?php if($i+1==$month){?> selected="selected"<?php }?>>
                                <?php echo $month_arr[$i];?>
                                </option>
                            <?php }?>
                       </select> 
                        <div class="help-block with-errors"></div>
                    </div>
                    
                     <div class="form-group has-feedback col-sm-4 col-md-4 col-lg-4">
                      <label style="color:#FFF;"> Year </label>
                        <select class="form-control month_february_select" id="birth_year" name="birth_year" required="required">
                            <option value="">Select Year</option>
                             <?php for($i=date('Y'); $i>=date('Y')-100;$i--){?>
                            <option value="<?php echo $i;?>" <?php if($i==$year){?> selected="selected"<?php }?>><?php echo $i;?></option>
                            <?php }?>
                       </select> 
                       <div class="help-block with-errors"></div>
                    </div>
             </div>
                 <div class="form-group has-feedback pull-left">
                    <label  class="radio-inline" style="padding-left:0px;"> <strong> Gender:<span class="required">*</span></strong></label>
                    <label class="radio-inline"><input type="radio" required="required" value="M" name="gender" <?php if($get_patient_details['gender']=='M'){?> checked="checked"<?php }?>> Male </label>
                    <label class="radio-inline"><input type="radio" required="required" value="F" name="gender" <?php if($get_patient_details['gender']=='F'){?> checked="checked"<?php }?>> Female </label>
                     <div class="help-block with-errors"></div>
                </div>
               </div>
             </div>
          </div>
                <div class="row"></div> 
        <div class="form-group validate_msg">
              <label for="middle-name">Status<span class="required">*</span> </label>
              <select name="status" id="status"  required="required" class="form-control">
                      <option value="1" <?php echo ($get_patient_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                      <option value="0" <?php echo ($get_patient_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
              </select>
        </div>
          <div class="row"></div> 
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <?php if($get_patient_details['id']){?>
              <button type="submit" class="btn btn-success" name="new_users_btn" id="new_patient_btn">Update</button>
              <input type="hidden" name="patient_id" id="patient_id" value="<?php echo filter_string($get_patient_details['id'])?>" />              
              <?php }//end if($get_patient_details['id'])?>
            </div>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>
