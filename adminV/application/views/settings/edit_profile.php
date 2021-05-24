<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
		<h2>Edit Profile <small> Edit Profile</small></h2>
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
      
        <form data-toggle="validator" role="form" id="edit_profile_frm" name="edit_profile_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>settings/edit-profile-process">
          
			<div class="form-group has-feedback">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">First Name<span class="required">*</span> </label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="first_name" name="first_name"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo filter_string($admin_edit_profile['admin_first_name']);?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
			     <div class="help-block with-errors"></div> 
				</div>
			</div>
			<div class="form-group has-feedback">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Last Name<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="last_name" class="form-control col-md-7 col-xs-12" required="required" type="text" name="last_name" value="<?php echo filter_string($admin_edit_profile['admin_last_name']);?>">	
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
			     <div class="help-block with-errors"></div>   			  
				</div>
			</div>
            
            <div class="form-group has-feedback">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="email_address" class="form-control col-md-7 col-xs-12" required="required" type="email" name="email_address" value="<?php echo filter_string($admin_edit_profile['admin_email_address']);?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <input type="hidden" id="admin_user" name="admin_user" value="<?php echo $this->session->userdata('admin_id');?>">
				<button type="submit" class="btn btn-success" name="change_pass_btn" id="change_pass_btn">update</button>
				</div>
			</div>
        </form>
      </div>
    </div>
  </div>
</div>
