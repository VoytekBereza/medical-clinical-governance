<div class=""></div>
<h3><?php echo filter_string($page_data['page_title']);?></h3>
<hr />
<p> <?php echo filter_string($page_data['page_description']);?>  </p>
<br>
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

<form method="post" name="reset_pass_frm" id="reset_pass_frm" data-toggle="validator" role="form" action="<?php echo SURL?>login/reset-password-process">

  <div class="form-group has-feedback">
    <label for="emailaddress">New Password<span class="required">*</span></label>
    
    <input type="password" class="form-control input-sm" id="new_password" name="new_password" placeholder="Enter new password" data-fv-regexp="true" data-fv-regexp-regexp="^^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9]{8,20}$" data-fv-regexp-message="Password must be between 8 to 20 characters with atleast one uppercase, one lowercase and one digit. Allowed characters (Alphabet, Numbers)" maxlength="20" required="required">
    
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>
    
  </div>
  
  <div class="form-group has-feedback">
    <label for="confirm_password">Confirm Password<span class="required">*</span></label>
    
    
    <input type="password" class="form-control" placeholder="Confirm password" id="confirm_password" name="confirm_password"
                            data-fv-identical="true"
                            data-fv-identical-field="new_password"
                            data-fv-identical-message="The password and its confirm password does not match" 
                            maxlength="20" />
                            
    
  </div>
  
  
  <div class="form-group">
    <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
  </div>
  <button class="btn btn-success marg2" type="submit" name="reset_pass_btn" id="reset_pass_btn" value="1">Submit</button>
  <input type="hidden" name="verify_code" id="verify_code" readonly="readonly" value="<?php echo $reset_code?>" />
</form>
