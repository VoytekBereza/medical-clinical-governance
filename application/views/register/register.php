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
<h3><?php echo filter_string($page_data['page_title']);?></h3>
<hr />
<p> <?php echo filter_string($page_data['page_description']);?> </p>
<!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->

<div class="row">
  <div class="col-md-6"> </div>
  <div class="col-md-6"> </div>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#hcp" id="btn-hcp" data-target="hcp_frm_contain" ><strong>Health Care Professional</strong></a></li>
    <li><a data-toggle="tab" href="#orgid" id="btn-org" data-target="org_frm_container" ><strong>Organisation</strong></a></li>
  </ul>
</div>
<div class="tab-content">
  <div id="hcp" class="tab-pane fade in active"> <br />
    <p id="tab_txt" class="text-left">Register a healthcare professional: Manager/ Employee/ Assistant/ Nurse/ Locum Pharmacists.</p>
  </div>
  <div id="orgid" class="tab-pane fade"> <br />
    <p class="text-left">Dual Registration as an Organisation and healthcare professional: Superintendent Pharmacists/ Pharmacist Owner</p>
  </div>
  <div class="reg_container" id="hcp_frm_contain"> 
    
    <!--HCP Registration form STARTS here -->
    <form data-toggle="validator" role="form" method="post" name="hcp_org_frm" id="hcp_org_frm"  action="<?php echo SURL?>register/register-process" autocomplete="off">
      <input type="hidden" name="inv_id" id="inv_id" value="<?php echo ($get_invitation_details) ? filter_string($get_invitation_details['id']) : ''?>" readonly="readonly" />
      <div class="<?php if($session_data['company_name']==""){?> hidden <?php }?>"  id="org_reg_div">
        <h4 class="well">Organisation Details </h4>
        <div class="form-group has-feedback">
          <label for="company_name">Company Name<span class="required">*</span></label>
          <input type="text" placeholder="Company Name" name="company_name" id="company_name"  required="required" value="<?php echo $session_data['company_name'];?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)" maxlength="50">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group has-feedback">
          <label for="org_address">Address<span class="required">*</span></label>
          <input type="text" placeholder="Address" name="org_address" id="org_address" required="required" value="<?php echo $session_data['org_address'];?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" >
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group has-feedback">
          <label for="org_address">Post Code<span class="required">*</span></label>
          <input type="text" placeholder="Post Code" name="org_postcode" id="org_postcode" required="required" value="<?php echo $session_data['org_postcode'];?>" class="form-control my_upper_class" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group has-feedback">
          <label for="org_contact">Premises Phone No.<span class="required">*</span></label>
          <input type="text" placeholder="Contact Number" name="org_contact" id="org_contact" required="required" value="<?php echo $session_data['org_contact'];?>" class="form-control" pattern="^(03|02|01)(?=.*[0-9])[0-9]{9,}$"  data-error="Please use allowed characters (Numbers, should start with 03 or 02 or 01 and length should be 11 numbers)"  maxlength="11">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group has-feedback">
          <label for="org_country">Select Country<span class="required">*</span></label>
          <select name="org_country" id="org_country" class="form-control" required="required">
            <option value="" selected>Select Country</option>
            <?php
                    if(count($country_active_arr) > 0){
                        foreach($country_active_arr as $index => $country_arr){
                ?>
            <option value="<?php echo $country_arr['id']?>"  <?php if($country_arr['id'] == $session_data['org_country']){?> selected="selected"<?php }?>><?php echo $country_arr['country_name']?></option>
            <?php     
                        }//end foreach($country_active_arr as $index => $cities_arr)
                        
                    }//end if(count($country_active_arr) > 0)
                    
                ?>
          </select>
          <div class="help-block with-errors"></div>
        </div>
      </div>
      <h4 class="well">Personal Details </h4>
      <div class="form-group has-feedback">
        <label for="user_type" id="user_type_label" >Select User Type<span class="required">*</span></label>
        <select name="user_type" id="user_type" class="form-control" required="required">
          <option value=""> Select User Type </option>
          <?php
        if(count($usertype_active_arr) > 0){
          foreach($usertype_active_arr as $index => $usertype_arr){
      ?>
          <option value="<?php echo $usertype_arr['id']?>" <?php if($usertype_arr['id'] == $session_data['user_type']){?> selected="selected"<?php }?>><?php echo $usertype_arr['user_type']?></option>
          <?php     
          }//end foreach($usertype_active_arr as $index => $usertype_arr)
        
        }//end if(count($usertype_active_arr) > 0)
        
      ?>
        </select>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <label for="userfirstname">First Name<span class="required">*</span></label>
        <input type="text" placeholder="First Name" value="<?php echo $session_data['first_name'];?>" required="required"  name="first_name" id="first_name" class="form-control"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <label for="userlastname">Last Name<span class="required">*</span></label>
        <input type="text" placeholder="Last Name" value="<?php echo $session_data['last_name'];?>"  required="required" name="last_name" id="last_name" class="form-control"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <!-- For Doctor -->
      <div class="form-group has-feedback <?php if($session_data['registration_no']==""){?> hidden  <?php }?>"  id="gmc_no_div">
        <label for="gmc-gphc-nmc">
          <?php if($session_data['user_type']=='1'){ echo 'GMC No*';} else if($session_data['user_type']=='2' || $session_data['user_type']=='6') { echo 'GPhC No*';} else if($session_data['user_type']=='3') { echo 'NMC No*';} else if($session_data['user_type']=='8') { echo 'Registration No*';} ?>
        </label>
        <input type="text" placeholder="Enter your Number" value="<?php echo $session_data['registration_no'];?>" name="registration_no" id="registration_no" class="form-control" required="required"   pattern="^[a-zA-Z0-9 -]+$"  data-error="Please use allowed characters (Alphabets, Numbers, Hyphens)" maxlength="15">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <label for="mobile_no">Mobile Number<span class="required">*</span></label>
        <input type="text" placeholder="Mobile Number" name="mobile_no" id="mobile_no"  required="required" value="<?php echo $session_data['mobile_no'];?>" class="form-control" maxlength="14">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <label for="email_address">Email Address<span class="required">*</span></label>
        <input type="email" placeholder="Email address" name="email_address" id="email_address"  required="required" value="<?php echo $session_data['email_address'];?>" title="" data-placement="bottom" class="form-control" pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" autocomplete="off" maxlength="255">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div id="error_msg" class="error help-block"> </div>
      <div class="form-group has-feedback">
        <label for="password">Password<span class="required">*</span></label>
        <input type="password" placeholder="Password" name="password" id="password" required="required" value="" class="form-control" data-toggle="tooltip" data-error="Password must be between 8 to 30 characters with at least one UPPERCASE, one lowercase and one digit." pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9!@#$%^&*()]{8,30}$"  maxlength="30" autocomplete="off">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <label for="conf_password">Confirm Password<span class="required">*</span></label>
        <input type="password" placeholder="Confirm Password" name="conf_password" id="conf_password" required="required" value="" class="form-control" data-toggle="tooltip" title="" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9!@#$%^&*()]{8,30}$" data-match="#password" data-error="Password must be between 8 to 30 characters with at least one UPPERCASE, one lowercase and one digit or the password you have entered does not match our records." >
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
          <label for="org_country">Select Country<span class="required">*</span></label>
          <select name="user_country" id="user_country" class="form-control" required="required">
            <option value="" selected>Select Country</option>
            <?php
                    if(count($country_active_arr) > 0){
                        foreach($country_active_arr as $index => $country_arr){
                ?>
            <option value="<?php echo $country_arr['id']?>"  <?php if($country_arr['id'] == $session_data['user_country']){?> selected="selected"<?php }?>><?php echo $country_arr['country_name']?></option>
            <?php     
                        }//end foreach($country_active_arr as $index => $cities_arr)
                        
                    }//end if(count($country_active_arr) > 0)
                    
                ?>
          </select>
          <div class="help-block with-errors"></div>
        </div>
      <?php 
      if($this->session->aff_buying_id){
  ?>
        <input type="hidden" readonly="readonly" name="org_buying_group" id="org_buying_group" value="<?php echo $this->session->aff_buying_id?>" />
    <?php     
    }else{
  ?>
            <div class="form-group">
                <label for="org_country">Select Buying Group</label>
                <select name="org_buying_group" id="org_buying_group" class="form-control">
                  <option value="" selected>Select Buying Group</option>
                  <?php
                if(count($buyinggroup_active_arr) > 0){
                  foreach($buyinggroup_active_arr as $index => $buyinggroup_arr){
              ?>
                  <option value="<?php echo $buyinggroup_arr['id']?>"  <?php if($buyinggroup_arr['id'] == 7){ echo 'selected="selected"'; }?> <?php if($buyinggroup_arr['id'] == $session_data['org_buying_group']){?> selected="selected"<?php }?> ><?php echo $buyinggroup_arr['buying_groups']?></option>
                  <?php     
                  }//end foreach($buyinggroup_active_arr as $index => $buyinggroup_arr)
                  
                }//end if(count($buyinggroup_active_arr) > 0)
                
              ?>
                </select>
                <div class="help-block with-errors"></div>
              </div>
    <?php   
    }
    ?>
      
      <div class="form-group <?php if($session_data['is_prescriber']==""){?> hidden <?php }?>" id="prescriber_div">
        <label for="is_prescriber">Are you a Prescriber?</label>
        <div class="radio">
          <label id="presc_radio_1">
            <input name="is_prescriber" value="1" type="radio" <?php if($session_data['is_prescriber']=='1'){?> checked="checked"<?php }?>>
            <span class="radio-label">Yes</span> </label>
          &nbsp;&nbsp;&nbsp;
          <label id="presc_radio_0">
            <input name="is_prescriber" value="0" type="radio" <?php if($session_data['is_prescriber']=='0' || $session_data['is_prescriber']==""){?> checked="checked"<?php }?> >
            <span class="radio-label">No</span> </label>
        </div>
      </div>
      <div class="form-group has-feedback  <?php if($session_data['speciality']==""){?> hidden <?php }?>" id="speciality_div">
        <label for="speciality">Speciality<span class="required">*</span></label>
        <input type="text" placeholder="Speciality" required="required" name="speciality" id="speciality" value="<?php echo $session_data['speciality'];?>" class="form-control">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group  <?php if($session_data['is_locum']==""){?> hidden <?php }?>" id="locum_div">
        <label for="is_prescriber">Are you a Locum?</label>
        <div class="radio">
          <label data-initialize="radio" id="locum_radio_1">
            <input name="is_locum" value="1" type="radio" <?php if($session_data['is_locum']=='1'){?> checked="checked"<?php }?>>
            <span class="radio-label">Yes</span> </label>
          &nbsp;&nbsp;&nbsp;
          <label data-initialize="radio" id="locum_radio_0">
            <input name="is_locum" value="0" type="radio"  <?php if($session_data['is_locum']=='0' || $session_data['is_locum']==''){?> checked="checked"<?php }?>>
            <span class="radio-label">No</span> </label>
        </div>
      </div>
      <div class="form-group  <?php if($session_data['location_arr']==""){?> hidden <?php }?>" id="location_div">
        <select data-placeholder="Choose your location..." class="chosen-location" multiple name="location_arr[]" id="location_arr">
          <option value=""></option>
          <?php
        if(count($cities_active_arr) > 0){
        
          foreach($cities_active_arr as $index => $cities_arr){
      ?>
          <option value="<?php echo $cities_arr['id']?>"  <?php if($session_data['location_arr']!="") { if(in_array($cities_arr['id'], $session_data['location_arr'])){?> selected="selected"<?php } }?>><?php echo $cities_arr['city_name']?></option>
          <?php     
          }//end foreach($cities_active_arr as $index => $cities_arr)
          
        }//end if(count($usertype_active_arr) > 0)
        
      ?>
        </select>
      </div>
      <div class="form-group">
        <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
      </div>
      <div class="form-group has-feedback">
        <div class="checkbox">
          <label id="term_checkbox">
            <input name="terms" id="terms" value="1" required="required" type="checkbox" <?php if($session_data['terms']=='1'){?> checked="checked"<?php }?>>
            <span class="checkbox-label" style="color:#333333;">I accept the <a href="<?php echo SURL?>pages/terms--conditions">Terms and Conditions</a>.</span> </label>
          &nbsp;&nbsp;&nbsp;</div>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group">
        <input type="hidden" id="base_url" name="base_url" value="<?php echo SURL;?>" readonly="readonly">
        <button type="submit" name="register" id="register"  class="btn btn-success">Register</button>
        <input type="hidden" name="is_owner" id="is_owner" value="0" readonly="readonly">
      </div>
    </form>
    
    <!--HCP Registration form ENDS here --> 
    
  </div>
</div>
<?php
  if($get_invitation_details){
    
    if(filter_string($get_invitation_details['invitation_type']) == 'SI') $slt_id = 2;
    elseif(filter_string($get_invitation_details['invitation_type']) == 'DO') $slt_id = 1; // Doctor
    elseif(filter_string($get_invitation_details['invitation_type']) == 'PH') $slt_id = 2; // Pharmacist
    elseif(filter_string($get_invitation_details['invitation_type']) == 'NU') $slt_id = 3; // Nurse
    elseif(filter_string($get_invitation_details['invitation_type']) == 'PA') $slt_id = 4; // Pharmacist Assistant
    elseif(filter_string($get_invitation_details['invitation_type']) == 'TE') $slt_id = 5; // Technician
    elseif(filter_string($get_invitation_details['invitation_type']) == 'PR') $slt_id = 6; // Pre-Pre-Reg
    elseif(filter_string($get_invitation_details['invitation_type']) == 'NH') $slt_id = 7; // Non Health Professional
    elseif(filter_string($get_invitation_details['invitation_type']) == 'M') $slt_id = 10; // For manager 
?>
<script>
    
    $(document).ready(function() {    
    
        $('#user_type').val(<?php echo $slt_id?>).change();
    
        if(<?php echo $slt_id?> != 10){
          $("#user_type option[value=<?php echo $slt_id?>]").attr('selected', 'selected');
          $("#user_type").attr('disabled', 'disabled');
          $("#hcp_org_frm").append('<input type="hidden" name="user_type" value="<?php echo $slt_id; ?>" />');
        }
        
        $('#user_type_label').addClass('hidden');
        //$('#user_type').addClass('hidden');
       
        $('#email_address').attr('value','<?php echo $get_invitation_details['email_address']?>');
      $('#email_address').attr('readonly','readonly');
    
    });

  </script>
<?php } // if($get_invitation_details) ?>
<script>

$(document).ready(function() {  
  $('#btn-org').click(function(e) {
    $('#tab_txt').html('Dual Registration as an Organisation and healthcare professional: Superintendent Pharmacists/ Pharmacist Owner');
  });
  $('#btn-hcp').click(function(e) {
    $('#tab_txt').html('Register a healthcare professional: Manager/ Employee/ Assistant/ Nurse/ Locum Pharmacists.');
  });

});

</script> 
