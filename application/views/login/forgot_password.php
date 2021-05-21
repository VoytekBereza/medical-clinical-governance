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

<form method="post" name="login_frm" id="login_frm" data-toggle="validator" role="form" action="<?php echo SURL?>login/forgot-password-process">
  <input type="hidden" value="1" name="regnow">
  <div class="form-group has-feedback">
    <label for="emailaddress">Email address<span class="required">*</span></label>
    <input type="email" placeholder="Email address" name="email_address" required="required" value="" class="form-control input-sm"  pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" maxlength="255">
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>
  </div>
  <div class="form-group">
    <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
  </div>
  <button class="btn btn-success marg2" type="submit" name="fgetpass_btn" id="fgetpass_btn">Submit</button>
</form>
