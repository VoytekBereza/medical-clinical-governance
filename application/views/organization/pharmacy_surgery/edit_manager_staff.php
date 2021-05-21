  <!-- Start - update Manager -->
         
         <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
            <div class="row">	
                <div class="col-sm-6 col-md-12 col-lg-12">
                    <h4>Manager / Staff</h4>
                </div>
            </div>
            <br />

            <div class="row">
                
                <form  data-toggle="validator" role="form" action="<?php echo base_url(); ?>organization/update-manager-staff-process" method="post" class="" name="form_manager_staff_edit" id="form_manager_staff_edit">
                
                    <div class="col-sm-6 col-md-12 col-lg-12">
                        
                        <div class="form-group has-feedback">
                            <label id="first_name" >First Name<span class="required">*</span></label>
                            <input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php echo $get_manager_staff_details['first_name'];?>" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"/>
                           <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     					<div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group  has-feedback">
                            <label id="Last_name" >Last Name<span class="required">*</span></label>
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php echo $get_manager_staff_details['last_name'];?>" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"/>
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     					<div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group  has-feedback">
                            <label>Mobile Number<span class="required">*</span></label>
                            <input type="digits" class="form-control" name="mobile_no" placeholder="Mobile Number" value="<?php echo $get_manager_staff_details['mobile_no'];?>" required="required" data-error="Please use allowed characters (Numbers, should start with 07 and length should be 11 numbers)" pattern="^07(?=.*[0-9])[0-9]{9,}$" maxlength="11">
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     					 <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group  has-feedback">
                            <label>Email Address</label> <em>(You do not have the permissions to edit this email address, please contact user)</em>
                            <input type="email" class="form-control" name="email_address"  disabled="disabled" value="<?php echo $get_manager_staff_details['email_address'];?>" required="required" />
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     					<div class="help-block with-errors"></div>
                        </div>
            
                        <div class="form-group pull-right">
                            <button type="submit" class="btn btn-sm btn-success btn-block"  name="update_manager_staff_btn"> Update</button>
                            <input type="hidden"  name="manager_staff_id" id="manager_staff_id" value="<?php echo $get_manager_staff_details['id'];?>"/>
                        </div>
                    
                    </div>
                
                </form>
            </div>
         
         </div> 
        
       
         <!-- // Js file using for  Form validation -->
         <script src="<?php echo JS;?>kod_scripts/jquery.validate.js" type="text/javascript"></script>
         <!-- // Js Form  page form validation -->
		 <script src="<?php echo JS;?>kod_scripts/custom_validate.js" type="text/javascript"></script>


