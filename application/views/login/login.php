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

<form method="post" data-toggle="validator" role="form" name="login_frm" id="login_frm"  action="<?php echo SURL?>login/login-process">

  <div class="form-group has-feedback">
    <label for="emailaddress">Email Address<span class="required">*</span></label>
    <input type="email" placeholder="Email address" name="email_address" id="email_address" value="" class="form-control input-sm" required="required" pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)">
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      <div class="help-block with-errors"></div>
  </div>
  
  <div class="form-group has-feedback">
    <label for="userpassword">Password<span class="required">*</span></label>
    <input type="password" placeholder="Password" name="password" id="password" value="" required class="form-control input-sm">
     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     <div class="help-block with-errors"></div>
  </div>
  <div class="form-group">
    <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
  </div>
  <button class="btn btn-success marg2" type="submit" name="login_btn2" id="login_btn2">Submit</button>
  <a href="<?php SURL?>login/forgot-password">Forgot your password?</a>
</form>
