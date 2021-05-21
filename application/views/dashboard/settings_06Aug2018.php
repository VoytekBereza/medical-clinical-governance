<style>.kbw-signature { width: 200px; height: 60px; }</style>

<div class="col-md-8">
  <div class="panel panel-default"> 
    <!-- Default panel contents -->
    <div class="panel-heading"><strong>EDIT PROFILE</strong></div>
    <div class="panel-body">
      <p class="align-left"></p>
      <div class="row">
        <div class="col-md-12">
          <form data-toggle="validator" role="form"  action="<?php echo SURL?>dashboard/settings-process" id="profile_frm" name="profile_frm"  method="post" enctype="multipart/form-data">
            <div class="form-group has-feedback">
              <label for="first_name">First Name<span class="required">*</span></label>
              <input type="text" required="required" class="form-control input-sm" value="<?php echo filter_string($get_user_profile['first_name'])?>" id="first_name" name="first_name" placeholder="First Name" pattern="[a-zA-z0-9\-\s]+(['-_\s][a-zA-Z0-9\s]+)*"  data-error="Allowed characters (Alphabet, Numbers, Space, Hyphens, Underscore)"  maxlength="30">
              
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		<div class="help-block with-errors"></div>  
            
            </div>
            <div class="form-group has-feedback">
              <label for="first_name">Last Name<span class="required">*</span></label>
              <input type="text" required="required" class="form-control input-sm" value="<?php echo filter_string($get_user_profile['last_name'])?>" id="last_name" name="last_name" placeholder="Last Name" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
              
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		<div class="help-block with-errors"></div>  
            
            </div>
            <div class="form-group">
              <label for="first_name">Email Address</label>
              <br />
              <i>Unfortunately, your email is your unique id and cannot be changed. If you would like to change your email you will need another account, for this you will need to contact our administration team.</i>
              <input type="text" required="" class="form-control input-sm" disabled="disabled" value="<?php echo filter_string($get_user_profile['email_address'])?>"  placeholder="Email Address">
              
            </div>
            
            <?php 
				$allowed_usertype = array('1','2','3');
				if(in_array($this->session->userdata('user_type'),$allowed_usertype)){
			?>
                <div class="form-group has-feedback">
                  <label for="registration_no">
                  	<?php 
						if($this->session->userdata('user_type') == 1)
							echo 'GMC No*';
						elseif($this->session->userdata('user_type') == 2)
							echo 'GPhc No*';
						else
							echo 'NMC No*';
					?>
                  </label>
                  <input type="text" required="required" class="form-control input-sm" value="<?php echo filter_string($get_user_profile['registration_no'])?>" id="registration_no" name="registration_no" placeholder="Registration Number"  pattern="^[a-zA-Z0-9 -]+$" data-error="Please use allowed characters (Alphabets, Numbers, Hyphens)" maxlength="15" >
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		    <div class="help-block with-errors"></div>  
                </div>
            
            <?php }//end if(in_array($this->session->userdata('user_type'),$allowed_usertype))?>
            <p class="text-right"><button id="setting_profile_btn" name="setting_profile_btn" type="submit" class="btn btn-success marg2 text-right">Update Profile</button></p>
            <input type="hidden" name="type" value="profile" readonly="readonly"  />
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <div class="panel panel-default"> 
    <!-- Default panel contents -->
    <div class="panel-heading"><strong>CHANGE PASSWORD</strong></div>
    <div class="panel-body">
      <p class="align-left"></p>
      <div class="row">
        <div class="col-md-12">
          <form  data-toggle="validator" role="form" action="<?php echo SURL?>dashboard/settings-process"  id="pass_frm" name="pass_frm" method="post" enctype="multipart/form-data">
            <div class="form-group has-feedback">
              <label for="first_name">Old Password<span class="required">*</span></label>
              <input type="password" required="required" class="form-control input-sm" value="" id="old_password" name="old_password" placeholder="Old Password">
               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		   <div class="help-block with-errors"></div>  
            </div>
            <div class="form-group has-feedback">
              <label for="first_name">New Password<span class="required">*</span></label>
              <input type="password" required="required" class="form-control input-sm" value="" id="new_password" name="new_password" placeholder="New Password" data-error="Password must be between 8 to 30 characters with atleast one uppercase, one lowercase and one digit. Allowed characters (Alphabet, Numbers, !@£$%^&*())" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9!@#$%^&*()]{8,30}$" >
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		  <div class="help-block with-errors"></div>
                
            </div>
            <div class="form-group has-feedback">
              <label for="first_name">Confirm Password<span class="required">*</span></label>
              <input type="password" required="" class="form-control input-sm" value="" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" data-error="Password must be between 8 to 30 characters with atleast one uppercase, one lowercase and one digit." data-match="#new_password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9!@#$%^&*()]{8,30}$"  maxlength="30">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     		  <div class="help-block with-errors"></div>
            </div>
            
           <p class="text-right"><button id="setting_profile_btn" name="setting_profile_btn" type="submit" class="btn btn-success marg2 text-right">Update Password</button></p>
           <input type="hidden" name="type" value="password" readonly="readonly"  />
          </form>
        </div>
      </div>
    </div>
  </div>
  <a name="sign_pane"></a>
  <div class="panel panel-default"> 
    <!-- Default panel contents -->
    <div class="panel-heading"><strong>UPDATE SIGNATURES</strong></div>
    <div class="panel-body">
      <p class="align-left"></p>
      <div class="row">
        <div class="col-md-12">
          <form action="<?php echo SURL?>dashboard/settings-process" class="form_validate_signature" id="sign_frm" name="sign_frm" method="post" enctype="multipart/form-data">
          	
            <div class="form-group validate_msg">
              <label for="default_signature">Choose your default signatures:</label>
              <select name="default_signature" id="default_signature">
              	<option>Choose your default signatures</option>
              	<option value="image" <?php echo (filter_string($get_user_profile['default_signature']) == 'image') ? 'selected="selected"' : ''?> >Upload Image Signatures</option>
                <option value="svn" <?php echo (filter_string($get_user_profile['default_signature']) == 'svn') ? 'selected="selected"' : ''?>>Draw Your Signatures</option>
              </select>
            </div>
            <?php if($get_user_profile['default_signature'] == NULL){ ?>
	            <p  id="error_text" class="alert alert-danger">You currently do not have a default signature, you can either upload or draw one online using the dropdown menu</p>
            <?php }?>
            <div class="form-group <?php echo (filter_string($get_user_profile['default_signature']) == 'image') ? '' : 'hidden' ?>" id="upload_signature">
            	<label for="image_signature">Image Signature:</label>
              <?php echo (filter_string($get_user_profile['signature_image']) == '') ? '<p class="error"></p>' : "<img src='". USER_SIGNATURE."thumb-".filter_string($get_user_profile['signature_image'])."' class='img-responsive' width='200px' height='60px' />"; ?>

              <label for="new_signature">Upload New Signature</label>
              <input type="file" class="" value="" id="new_signature" name="new_signature"><br />
              <p>
              	<i>Allowed Extensions: jpg, jpeg, png, gif</i><br />
                <i>Maximum Size Allowed: 2MB</i>
              </p>
            </div>
            
            <hr />
            <div class="form-group <?php echo (filter_string($get_user_profile['default_signature']) == 'svn') ? '' : 'hidden' ?>" id="draw_signature">
           		<label for="first_name">Draw Your Signature</label><br />
              <div id="setting_signature"></div>
              <p style="clear: both;">
                <button class="btn btn-xs btn-default" type="button" name="setting_clear" id="setting_clear">Clear Signature</button>
               </p> 
                <p id="svn_signature_code"><?php echo (filter_string($get_user_profile['signature_svn']) == '') ? '<span class="error"></span>' : filter_string($get_user_profile['signature_svn']); ?></p>
                <input type="hidden" name="signature_svn_txt" id="signature_svn_txt" value="" />
                <p name="old_signature_svn_txt" id="old_signature_svn_txt" class="hidden"><?php echo filter_string($get_user_profile['signature_svn'])?></p>
            </div>
            
            <hr />
           <p class="text-right"><button id="setting_signature_btn" name="setting_profile_btn" type="submit" class="btn btn-success marg2 text-right <?php echo ((filter_string($get_user_profile['default_signature']) == 'image') || (filter_string($get_user_profile['default_signature']) == 'svn')) ? '' : 'hidden' ?>">Update Signatures</button></p>
            <input type="hidden" name="type" value="sign" readonly="readonly"  />
          </form>
        </div>
      </div>
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
