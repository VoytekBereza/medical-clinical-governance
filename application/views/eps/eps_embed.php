<p>
<br />
<?php
    // Set if submition fiald showing data in fields which is user filled 
	$session_data =  $this->session->flashdata();
	
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
</p>

<div class="row" style="margin-top:20px;">
  <div class="col-md-12">
    <h3>EPS Nomaination Form</h3>
    <i>To elect Bailey and Saunders as your NHS pharmacy please fill in the form below.</i> </div>
</div>
<div class="row">
  <div class="col-md-12">
    <p>
   
    <hr />
    <form  data-toggle="validator" role="form" id="add_eps_frm" name="add_eps_frm" method="post" action="<?php echo SURL?>eps_embed/add-eps-process" autocomplete="off">
      <div class="row"> <br />
        <div class="col-md-12">
          <div class="form-group  has-feedback">
            <label>First Name:</label>
            <input type="text" class="form-control"  id="first_name" name="first_name" placeholder="first name"  required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
        </div>
      </div>
      <div class="row"> 
        <div class="col-md-12">
          <div class="form-group  has-feedback">
            <label>Last Name:</label>
            <input type="text" class="form-control"  id="last_name" name="last_name" placeholder="last name"  required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group  has-feedback">
            <label>Email Address:</label>
            <input type="email" class="form-control"  id="email_address" name="email_address" placeholder="email address"  required="required" maxlength="50" >
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group  has-feedback">
            <label>Mobile No:</label>
            <input type="digits" class="form-control"  id="mobile_no" name="mobile_no" placeholder="mobile number"  required="required"  data-error="Please use allowed characters (Numbers, should start with 07 and length should be 11 numbers)" pattern="^07(?=.*[0-9])[0-9]{9,}$" maxlength="11">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group  has-feedback">
            <label>Date of Birth: </label>
            <input type="text" id="date_of_birth" name="date_of_birth" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-8"> </div>
        <div class="col-md-4">
          <button type="submit" name="submit_eps_btn" id="submit_eps_btn" class="btn btn-success marg2 pull-right">Submit</button>
          <input type="hidden" id="organization_id" name="organization_id" value="<?php echo $organization_id;?>">
          <input type="hidden" id="pharmacy_surgery_id" name="pharmacy_surgery_id" value="<?php echo $pharmacy_surgery_id;?>">
        </div>
      </div>
      <!-- ./row -->
    </form>
    </p>
  </div>
</div>
