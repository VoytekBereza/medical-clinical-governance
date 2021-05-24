<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
		<h2> Change Password <small> Change Password</small></h2>
		<div class="clearfix"></div>
	 </div>
      <div class="x_content"> <br />
	  <?php if($this->session->flashdata('err_message')){?>
      <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
      <?php
            }//end if($this->session->flashdata('err_message'))
            
            if($this->session->flashdata('ok_message')){?>
      <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
      <?php }//if($this->session->flashdata('ok_message'))?>
      
        <form data-toggle="validator" role="form"  id="change_pass_frm" name="change_pass_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>settings/change-password-process">
          
			<div class="form-group has-feedback">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Password<span class="required">*</span> </label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="password" id="new_password" name="new_password" data-rule-minlength="6" required="required" class="form-control col-md-7 col-xs-12">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="form-group has-feedback">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Re-enter New Password<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="confirm_password" class="form-control col-md-7 col-xs-12" required="required" data-match="#new_password"  type="password" name="confirm_password">	
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<div class="help-block with-errors"></div>			  
				</div>
			</div>
			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<button type="submit" class="btn btn-success" name="change_pass_btn" id="change_pass_btn">Submit</button>
				</div>
			</div>
        </form>
      </div>
    </div>
  </div>
</div>
