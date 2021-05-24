<div id="login" class="animate form">
  <?php if($this->session->flashdata('err_message')){?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
  <?php
        }//end if($this->session->flashdata('err_message'))
        
        if($this->session->flashdata('ok_message')){?>
  <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
  <?php }//if($this->session->flashdata('ok_message'))?>
  <section class="login_content">
    <form action="<?php echo SURL?>login/login-process" method="post" enctype="multipart/form-data" name="login_frm" id="login_frm">
      <h1>Login</h1>
      <div>
        <input type="text" class="form-control" placeholder="Email" name="email_address" id="email_address" required="" />
      </div>
      <div>
        <input type="password" class="form-control" placeholder="Password" required="" name="password" id="password" />
      </div>
      <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
      <br />
      <div>
        <button class="btn btn-default submit" name="login_btn" id="login_btn"> Log in </button>
       <a href="<?php SURL?>login/forgot-password">Forgot your password?</a></div>
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
<div id="register" class="animate form">
  <section class="login_content">
    <form action="<?php echo SURL?>dashboard">
      <h1>Create Account</h1>
      <div>
        <input type="text" class="form-control" placeholder="Username" required="" />
      </div>
      <div>
        <input type="email" class="form-control" placeholder="Email" required="" />
      </div>
      <div>
        <input type="password" class="form-control" placeholder="Password" required="" />
      </div>
	<div>
        <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
		</div>
      <div> <a class="btn btn-default submit">Submit</a> </div>
      <div class="clearfix"></div>
      <div class="separator">
        <p class="change_link">Already a member ? <a href="#tologin" class="to_register"> Log in </a> </p>
        <div class="clearfix"></div>
        <br />
        <div><?php echo $footer_login?> </div>
      </div>
    </form>
    <!-- form --> 
  </section>
  <!-- content --> 
</div>
