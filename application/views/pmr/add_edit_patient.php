<?php

	if($this->session->flashdata('err_message')){
?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
<?php
	}//end if($this->session->flashdata('err_message'))
	
	if($this->session->flashdata('ok_message')){
?>
	<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php 
		}//if($this->session->flashdata('ok_message'))
?>
<form data-toggle="validator" role="form" method="post" name="add_edit_patient_frm" id="add_edit_patient_frm"  action="<?php echo SURL?>organization/pmr/add-edit-patient-process">
 
    <div class="row">
    	<div class="col-md-8">
        <div class="panel panel-default"> 
          <!-- Default panel contents -->
          <div class="panel-heading"  data-toggle="modal" data-target="#myModal"><strong>Add patient</strong></div>
            <div class="panel-body">
            <p class="align-left"></p>
            <div class="row">
              <div class="col-md-12">
                  <div class="row">
                    <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
                        <label for="userfirstname">First Name<span class="required">*</span></label>
                        <input type="text" placeholder="First Name" value="" required="required"  name="first_name" id="first_name" class="form-control"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
                      <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                   </div> <!-- ./row -->
                 <div class="row">
                    <div class="form-group  has-feedback  col-sm-12 col-md-12 col-lg-12 <?php echo ($last_name) ? 'has-success' : '' ; ?>">
                        <label for="userlastname">Last Name<span class="required">*</span></label>
                        
                        <input type="text" placeholder="Last Name" value="<?php echo ($last_name) ? $last_name : '' ; ?>" required="required" name="last_name" id="last_name" class="form-control"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">

                        <script> $('#last_name').focus(); </script>

                      <span class="glyphicon form-control-feedback <?php echo ($last_name) ? 'glyphicon-ok' : '' ; ?>" style="width:10%" aria-hidden="true"></span>
                     <div class="help-block with-errors"></div>
                    </div>
                   </div> <!-- ./row -->  
                  <div class="row">
                    <div class="form-group  has-feedback  col-sm-12 col-md-12 col-lg-12">
                         <label for="mobile_no">Mobile Number<span class="required">*</span></label>
                         <input type="digits" placeholder="Mobile Number" name="mobile_no" id="mobile_no"  required="required" value="" data-error="Mobile number should start with 07 and length should be 11 numbers." class="form-control"  pattern="^07(?=.*[0-9])[0-9]{9,}$" maxlength="11">
                      <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                     <div class="help-block with-errors"></div>
                    </div>
                  </div> <!-- ./row -->    
                    <label>Date Of Birth<span class="required">*</span> </label>         
                  <div class="row">
                        <div class="form-group  has-feedback col-sm-4 col-md-4 col-lg-4">
                            <select class="form-control month_february_select" id="birth_date" name="birth_date" required="required">
                                <option value="">Select Date</option>
                                <?php 
									for($i=1; $i<=31;$i++){
										if($i <10){
								?>
                                <option value="<?php echo '0'.$i;?>"><?php echo '0'.$i;?></option>
                               <?php } else {?>
                               <option value="<?php echo $i;?>"><?php echo $i;?></option>
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
                                    <option value="<?php echo $i+1;?>">
                                        <?php echo $month[$i];?>
                                    </option>
                                  <?php }?>
                           </select> 
                        	<div class="help-block with-errors"></div>   
                        </div>
                        
                         <div class="form-group col-sm-4 col-md-4 col-lg-4">
                            <select class="form-control month_february_select" id="birth_year" name="birth_year" required="required">
                                <option value="">Select Year</option>
                                 <?php for($i=date('Y'); $i>=date('Y')-100;$i--){?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php }?>
                           </select> 
                         <div class="help-block with-errors"></div>  
                        </div>
                  </div> <!-- ./row -->
            
                <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12" style="padding-left:0px;">
                    <label for="gender"> Gender<span class="required">*</span>  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="radio-inline"><input type="radio" name="gender" value="M" required="required"> Male </label>
                    <label class="radio-inline"><input type="radio" name="gender" value="F" required="required"> Female </label>
                     <div class="help-block with-errors"></div>
                </div>
                <div class="row">
                    <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
                        <label for="address">Address 1<span class="required">*</span></label>
                        <input type="text" placeholder="Address" name="address" id="address" required="required" value="" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" >
                        <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                      </div>
                 </div>   <!-- ./row -->
                <div class="row">
                    <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
                        <label for="address">Address 2</label>
                        <input type="text" placeholder="Address" name="address_2" id="address_2" value="" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)" maxlength="50">
                           <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                      </div>
                 </div>
                <div class="row">
                    <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
                        <label for="address">Address 3</label>
                        <input type="text" placeholder="Address" name="address_3" id="address_3" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)" maxlength="50">
                           <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                      </div>
                 </div>
                 <div class="row">
                    <div class="form-group has-feedback col-sm-12 col-md-12 col-lg-12">
                         <label for="post_code">Post Code<span class="required">*</span></label>
                        <input type="text" placeholder="Post Code" name="postcode" id="postcode" required="required" value="" class="form-control my_upper_class" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8">
                      <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>    <!-- ./row -->
                 <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="form-group  has-feedback">
                        <label for="email_address">Email Address<span class="required">*</span></label>
                        <input type="email" placeholder="Email address" name="email_address_patient" id="email_address_patient"  required="required" value="" title="" data-placement="bottom" class="form-control" pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" maxlength="30">
                    	<span class="glyphicon form-control-feedback" style="width:5%" aria-hidden="true"></span>
                     	<div class="help-block with-errors"></div>
                    </div>
                   	<div id="error_msg_patient" class="error help-block"> </div>
                    </div>
                   </div> <!-- ./row -->
                <!--<p> </p> 
                 <div class="row">
                    <div class="form-group  has-feedback col-sm-12 col-md-12 col-lg-12">
                        <label for="password">Password<span class="required">*</span></label>
                        <input type="password" placeholder="Password" name="password" id="password" required="required" value="" class="form-control" data-error="Password must be between 8 to 16 characters with atleast one uppercase, one lowercase and one digit." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}" autocomplete="off">
                        <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                 </div>  
				<p> </p> 
                 <div class="row">
                    <div class="form-group  has-feedback col-sm-12 col-md-12 col-lg-12">
                        <label for="conf_password">Confirm Password<span class="required">*</span></label>
                        <input type="password" placeholder="Confirm Password" name="conf_password" id="conf_password" required="required" value="" class="form-control"pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}" data-match="#password" data-error="Password must be between 8 to 16 characters with atleast one uppercase, one lowercase and one digit or password does not match" >
        
                        <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                     </div>
                   </div> -->
                   
                  <div class="row">
                      
                      <div class="radio">
                        <label>
                          <input type="checkbox" name="discount_offers" value="1" />
                         The patient has agreed that they would like to recieve emails about potential special offers and discounts.
                        </label>
                      </div>

                     <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="radio">
                                <div class="form-group  has-feedback">
                                    <label>
                                  <input type="checkbox" name="taken_patient_cosent" value="1" required />
                                     Verbal consent has been taken from the patient and they have had the chance to read Voyager Health <a href="<?php echo VH_SURL?>term-and-conditions" target="_blank">terms and conditions</a>.
                                </label>
                                    <span class="glyphicon form-control-feedback" style="width:5%;" aria-hidden="true"></span>
                                    <div class="help-block with-errors" style="margin-left:20px;"></div>
                                </div>                      
                          </div>  
                        </div>
                     </div>
                      
                      
                      
                    </div>     
                  <div class="row">
                    <div class="form-group pull-left">
                        <div class="col-sm-6 col-md-6 col-lg-6"><button name="add_edit_patient_btn" id="add_edit_patient_btn" class="btn btn-success" type="submit">Add Patient</button></div> 
                        </div>
                    </div> <!-- ./row -->
              </div>
            </div> <!-- ./row -->
          </div>
        </div>
    </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Voyager Medical</strong></div>
                <div class="panel-body">
                  <p align="left"> Voyager medical is an online pharmacy information system. We intend to provide healthcare professionals with an online ecosystem to allow for better communication between each other and their patients. Protected by law, the data you enter into this site remains your intellectual property and cannot be used by us. Our goal is to enable you to do more, if you like it you can subscribe for more! </p>
                </div>
            </div>
        </div>
    </div> <!-- ./row -->
</form>