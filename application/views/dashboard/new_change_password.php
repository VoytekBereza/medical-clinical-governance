<div class="panel panel-default"> 
  <!-- Default panel contents -->
  <div class="panel-heading"><strong>Please change your password…</strong></div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
      	<p class="text-justify">Data security is one of our main priorities at Voyager Medical, as such, for your protection and ours. We require you to reset your password and accept our updated terms and conditions listed below.</p>
        <form data-toggle="validator" role="form" action="<?php echo base_url(); ?>dashboard/new-change-password-process" method="post" name="new_pass_frm" id="new_pass_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
            <div class="form-group  has-feedback">
              <label id="pharmacy_surgery_name_label" >New Password <span class="required">*</span></label>
              <input type="password" class="form-control input-sm" id="new_password" name="new_password" placeholder="Enter new password" data-fv-regexp="true" data-fv-regexp-regexp="^^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9]{8,20}$" data-fv-regexp-message="Password must be between 8 to 20 characters with atleast one uppercase, one lowercase and one digit. Allowed characters (Alphabet, Numbers)" maxlength="20" required="required">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label id="pharmacy_surgery_address_label" >Confirm Password<span class="required">*</span></label>
              <input type="password" class="form-control" placeholder="Confirm password" id="confirm_password" name="confirm_password"
                            data-fv-identical="true"
                            data-fv-identical-field="new_password"
                            data-fv-identical-message="The password and its confirm password does not match" 
                            maxlength="20" required />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="col-sm-6 col-md-12 col-lg-12">
              <div class="form-group">
                    <div style="overflow:auto; height:200px; width:100%; border:solid 1px #ccc; padding:10px"><?php echo filter_string($cms_data['page_description']); ?></div>
                </div>
          </div>
        <div class="form-group">
            <div class="col-md-8 text-left">
                <label><input type="checkbox" name="accept_terms" value="1" required /> I Accept <a target="_blank" href="<?php echo SURL?>terms-and-conditions">Terms and Conditions</a>.</label>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                
            </div>
            <div class="col-md-4 text-right">
                  <button type="submit" class="btn btn-sm btn-success btn-block" name="add_update_btn">Update </button>
                  <input type="hidden" name="type" id="type" value="password" readonly="readonly"  />
                  <input type="hidden" name="new_terms" id="new_terms" value="1" readonly="readonly"  />
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
// Use for add edit pharmacy form validation
$('#new_pass_frm').validator();
</script>