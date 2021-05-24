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

<div id="login" class="animate form">
  <?php if($this->session->flashdata('err_message')){?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
  <?php
        }//end if($this->session->flashdata('err_message'))
        
        if($this->session->flashdata('ok_message')){?>
  <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
  <?php }//if($this->session->flashdata('ok_message'))?>
  <section class="login_content" style="width:450px;">
    <form action="<?php echo SURL?>login/forgot-password-process" method="post" enctype="multipart/form-data" class="form_validate" name="forgot_password_frm" id="forgot_password_frm">
      <h1>Forgot Password</h1>
      <p> <?php echo filter_string($page_data['page_description']);?>  </p>
     
      <div class="form-group validate_msg">
        <input type="text" class="form-control" placeholder="Email" name="email_address"  id="email_address" required="required" />
      </div>
      
      <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
      <br />
      <div class="pull-left">
        <button class="btn btn-default submit" name="forgot_password_btn" id="forgot_password_btn"> Submit </button>
       </div>
       
        <div class="pull-left">
         <a href="<?php echo SURL?>login" class="btn btn-default" style="margin:1px; height:33px;"> Back to login </a>
       </div>
      
      <div class="clearfix"></div>
      <div class="separator"></div>
      <!--<p class="change_link">New to site? <a href="#toregister" class="to_register"> Create Account </a> </p>-->
      <div class="clearfix"></div>
      <br />
      <div><?php echo $footer_login?> </div>
    </form>
    <!-- form --> 
  </section>
  <!-- content --> 
</div>
