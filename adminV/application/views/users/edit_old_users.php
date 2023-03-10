<?php 

/*echo '<pre>';
print_r($old_user_details);
exit;*/
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php
            }//end if($this->session->flashdata('err_message'))
            
            if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="x_title">
          <h2>Update Old Users <small>Update Old Users</small></h2>
          <div class="clearfix"></div>
        </div>
        
        
        <form data-toggle="validator" role="form" method="post" name="hcp_org_frm" id="hcp_org_frm"  action="<?php echo SURL?>users/old-users-process" autocomplete="off">
          <input type="hidden" name="inv_id" id="inv_id" value="<?php echo ($get_invitation_details) ? filter_string($get_invitation_details['id']) : ''?>" readonly="readonly" />
          
          <h4 class="well">Personal Details </h4>
          <div class="form-group has-feedback">
            <label for="user_type" id="user_type_label" >Select User Type<span class="required">*</span></label>
            <select name="user_type" id="user_type" class="form-control" required="required">
              <option value=""> Select User Type </option>
              <?php
				if(count($usertype_active_arr) > 0){
					foreach($usertype_active_arr as $index => $usertype_arr){
			  ?>
              <option value="<?php echo $usertype_arr['id']?>" <?php if($usertype_arr['user_type'] == 'Doctor' && $old_user_details['registeringbody']=='GMC'){?> selected="selected"<?php } else if($usertype_arr['user_type'] == 'Pharmacist' && $old_user_details['registeringbody']=='GPhC'){?> selected="selected"<?php } else if($usertype_arr['user_type'] == 'Nurse' && $old_user_details['registeringbody']=='NMC'){?> selected="selected"<?php } ?>>
              <?php echo $usertype_arr['user_type']?>
              </option>
              
              <?php			
					}//end foreach($usertype_active_arr as $index => $usertype_arr)
				
				}//end if(count($usertype_active_arr) > 0)
				
			?>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group has-feedback">
            <label for="userfirstname">First Name<span class="required">*</span></label>
            <input type="text" placeholder="First Name" value="<?php echo $old_user_details['firstname'];?>" required="required"  name="first_name" id="first_name" class="form-control"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group has-feedback">
            <label for="userlastname">Last Name<span class="required">*</span></label>
            <input type="text" placeholder="Last Name" value="<?php echo $old_user_details['lastname'];?>"  required="required" name="last_name" id="last_name" class="form-control"  pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
          <!-- For Doctor -->
          <div class="form-group has-feedback <?php if($old_user_details['registrationnumber']==""){?> hidden  <?php }?>"  id="gmc_no_div">
            <label for="gmc-gphc-nmc">
              <?php if($old_user_details['registeringbody']=='GMC'){ echo 'GMC No*';} else if($old_user_details['registeringbody']=='GPhC') { echo 'GPhC No*';} else if($old_user_details['registeringbody']=='NMC') { echo 'NMC No*';} ?>
            </label>
            <input type="text" placeholder="Enter your Number" value="<?php echo $old_user_details['registrationnumber'];?>" name="registration_no" id="registration_no" class="form-control" required="required"   pattern="^[a-zA-Z0-9 -]+$"  data-error="Please use allowed characters (Alphabets, Numbers, Hyphens)" maxlength="15">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group has-feedback">
            <label for="mobile_no">Mobile Number<span class="required">*</span></label>
            <input type="digits" placeholder="Mobile Number" name="mobile_no" id="mobile_no"  required="required" value="<?php echo $old_user_details['mobilenumber'];?>" data-error="Please use allowed characters (Numbers, should start with 07 and length should be 11 numbers)" class="form-control"  pattern="^07(?=.*[0-9])[0-9]{9,}$" maxlength="11">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group has-feedback">
            <label for="email_address">Email Address<span class="required">*</span></label>
            <input type="email" placeholder="Email address" name="email_address" id="email_address"  required="required" value="<?php echo $old_user_details['emailaddress'];?>" title="" data-placement="bottom" class="form-control" pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" autocomplete="off" maxlength="255">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
          <div id="error_msg" class="error help-block"> </div>
          <!--  <div class="form-group has-feedback">
        <label for="password">Password<span class="required">*</span></label>
        <input type="password" placeholder="Password" name="password" id="password" required="required" value="" class="form-control" data-toggle="tooltip" data-error="Password must be between 8 to 30 characters with atleast one uppercase, one lowercase and one digit. Allowed characters (Alphabet, Numbers, !@??$%^&*())" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9!@#$%^&*()]{8,30}$"  maxlength="30" autocomplete="off">
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <label for="conf_password">Confirm Password<span class="required">*</span></label>
        <input type="password" placeholder="Confirm Password" name="conf_password" id="conf_password" required="required" value="" class="form-control" data-toggle="tooltip" title="" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9!@#$%^&*()]{8,30}$" data-match="#password" data-error="Password must be between 8 to 30 characters with atleast one uppercase, one lowercase and one digit or password does not match" >
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
      </div>-->
          <div class="form-group">
            <label for="org_country">Select Buying Group</label>
            <select name="org_buying_group" id="org_buying_group" class="form-control">
              <option value="" selected>Select Buying Group</option>
              <?php
        if(count($buyinggroup_active_arr) > 0){
          foreach($buyinggroup_active_arr as $index => $buyinggroup_arr){
      ?>
              <option value="<?php echo $buyinggroup_arr['id']?>"   <?php if($buyinggroup_arr['id'] == $old_user_details['groupid']){?> selected="selected"<?php }?> ><?php echo $buyinggroup_arr['buying_groups']?></option>
              <?php     
          }//end foreach($buyinggroup_active_arr as $index => $buyinggroup_arr)
          
        }//end if(count($buyinggroup_active_arr) > 0)
        
      ?>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group <?php if($old_user_details['registeringbody']!='GPhC' && $old_user_details['registeringbody']!='NMC'){ ?> hidden <?php }?>" id="prescriber_div">
            <label for="is_prescriber">Are you a Prescriber?</label>
            <div class="radio">
              <label id="presc_radio_1">
                <input name="is_prescriber" value="1" type="radio" <?php if($old_user_details['prescribercheck']=='1'){?> checked="checked"<?php }?>>
                <span class="radio-label">Yes</span> </label>
              &nbsp;&nbsp;&nbsp;
              <label id="presc_radio_0">
                <input name="is_prescriber" value="0" type="radio" <?php if($old_user_details['prescribercheck']=='0' || $old_user_details['prescribercheck']==""){?> checked="checked"<?php }?> >
                <span class="radio-label">No</span> </label>
            </div>
          </div>
          <div class="form-group has-feedback  <?php if($old_user_details['speciality']==""){?> hidden <?php }?>" id="speciality_div">
            <label for="speciality">Speciality<span class="required">*</span></label>
            <input type="text" placeholder="Speciality" required="required" name="speciality" id="speciality" value="<?php echo $old_user_details['speciality'];?>" class="form-control">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group   <?php if($old_user_details['registeringbody']!='GMC' && $old_user_details['registeringbody']!='GPhC' && $old_user_details['registeringbody']!='NMC'){ ?> hidden <?php }?>" id="locum_div">
            <label for="is_prescriber">Are you a Locum?</label>
            <div class="radio">
              <label data-initialize="radio" id="locum_radio_1">
                <input name="is_locum" value="1" type="radio" <?php if($old_user_details['is_locum']=='1'){?> checked="checked"<?php }?>>
                <span class="radio-label">Yes</span> </label>
              &nbsp;&nbsp;&nbsp;
              <label data-initialize="radio" id="locum_radio_0">
                <input name="is_locum" value="0" type="radio"  <?php if($old_user_details['is_locum']=='0' || $old_user_details['is_locum']==''){?> checked="checked"<?php }?>>
                <span class="radio-label">No</span> </label>
            </div>
          </div>
          <div class="form-group  <?php if($old_user_details['location_arr']==""){?> hidden <?php }?>" id="location_div">
            <select data-placeholder="Choose your location..." class="chosen-location" multiple name="location_arr[]" id="location_arr">
              <option value=""></option>
              <?php
				if(count($cities_active_arr) > 0){
				
					foreach($cities_active_arr as $index => $cities_arr){
			?>
              <option value="<?php echo $cities_arr['id']?>"  <?php if($old_user_details['location_arr']!="") { if(in_array($cities_arr['id'], $old_user_details['location_arr'])){?> selected="selected"<?php } }?>><?php echo $cities_arr['city_name']?></option>
              <?php			
					}//end foreach($cities_active_arr as $index => $cities_arr)
					
				}//end if(count($usertype_active_arr) > 0)
				
			?>
            </select>
          </div>
          
          <label><input type="checkbox" name="is_owner" id="org_reg_div_1" value="1"> Is an Organisation?</label>
          
          <div class="<?php if($old_user_details['company_name']==""){?> hidden <?php }?>"  id="org_reg_div">
            <h4 class="well">Organisation Details </h4>
            <div class="form-group has-feedback">
              <label for="company_name">Company Name<span class="required">*</span></label>
              <input type="text" placeholder="Company Name" name="company_name" id="company_name"  required="required" value="<?php echo $old_user_details['address1'];?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)" maxlength="50">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label for="org_address">Address<span class="required">*</span></label>
              <input type="text" placeholder="Address" name="org_address" id="org_address" required="required" value="<?php echo $old_user_details['address2'];?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" >
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label for="org_address">Post Code<span class="required">*</span></label>
              <input type="text" placeholder="Post Code" name="org_postcode" id="org_postcode" required="required" value="<?php echo strtoupper($old_user_details['postcode']);?>" class="form-control my_upper_class" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label for="org_contact">Premises Phone No.<span class="required">*</span></label>
              <input type="text" placeholder="Contact Number" name="org_contact" id="org_contact" required="required" value="" class="form-control" pattern="^(02|01)(?=.*[0-9])[0-9]{9,}$"  data-error="Please use allowed characters (Numbers, should start with 02 or 01 and length should be 11 numbers)"  maxlength="11">
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
                <option value="<?php echo $country_arr['id']?>"  <?php if($country_arr['id'] == $old_user_details['country']){?> selected="selected"<?php }?>><?php echo $country_arr['country_name']?></option>
                <?php			
                        }//end foreach($country_active_arr as $index => $cities_arr)
                        
                    }//end if(count($country_active_arr) > 0)
                    
                ?>
              </select>
              <div class="help-block with-errors"></div>
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <button type="submit" class="btn btn-success" name="old_user_btn" id="old_user_btn">Import</button>
              <input type="hidden" name="user_id" id="user_id" value="<?php echo filter_string($old_user_details['userid'])?>" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>

//	HCP REGISTRATION - START
//This check to show additional field if Is Presriber value is 1
$('input:radio[name=is_prescriber]').click(function() {
	var val = $('input:radio[name=is_prescriber]:checked').val();
	
	if(val == 1){
		 $("#speciality_div").removeClass("hidden");
	}else{
		$("#speciality_div").addClass("hidden");
		$('#speciality').val('');
	}
});

//This check to show location fields if Is Locum value is 1
$('input:radio[name=is_locum]').click(function() {
	var val = $('input:radio[name=is_locum]:checked').val();
	
	if(val == 1){
		 $("#location_div").removeClass("hidden");
	}else{
		$("#location_div").addClass("hidden");
		$('[name=location]').val( '' );
	}
	
});

//on ever page load, reset the form values.
$( window ).load(function() {
	 //$('#hcp_org_frm')[0].reset();
});	
//This container opens the form containers depending on the option selected HCQP or organization
$(document).ready(function() {
	
	/*
	$(".reg_container").hide(); 
		$('.btn-group a').click(function(){
		var target = "#" + $(this).data("target");
		$(".reg_container").not(target).hide();
		$(target).show();
	});
	*/
	//If HCP registration is clicked, hide the organization form fields.
	$('#btn-org').click(function(){
               	
		$("#org_reg_div").removeClass("hidden");
		$('#is_owner').val(1);
		
	});

	$('#btn-hcp').click(function(){
		
		
		$("#register").removeClass("disabled");
		$("#register").prop("disabled", false); // Element(s) are now enabled.
		
		$("#org_reg_div").addClass("hidden");
		$('#is_owner').val(0);
		
	});
	
	
	$('#org_reg_div_1').change(function(){
		
		if($('#org_reg_div_1').is(":checked")){
			$("#org_reg_div").removeClass("hidden");
			
			$('#hcp_org_frm').formValidation({
				live: 'enabled',
	
	      });
		  
		}else{
			$("#org_reg_div").addClass("hidden");
		}
               	
	});
	
	
	//ToolTip
	//$('[data-toggle="tooltip"]').tooltip();
	
});  

//Some decisions on Usertype selection
$('#user_type').on('change', function() {
	
	var validate_this = '';

	//Ask for Prescriber or not just from Nurses and Pharmacist
	if(this.value == 2 || this.value == 3){
		 $("#prescriber_div").removeClass("hidden");
		 $("input[name=is_prescriber][value=0]").prop('checked', true);
		 
	}else{
		$("#prescriber_div").addClass("hidden");
	}//end if(this.value == 2 || this.value == 3)
	
	//If doc, he will always be prescriber
	if(this.value == 1){
		$("input[name=is_prescriber][value=1]").prop('checked', true);
	}
	
	//If Pre-reg, or Non Health Professionl do not ask for locum
	if(this.value == 6 || this.value == 7){
		$("#locum_div").addClass("hidden");
		$("#location_div").addClass("hidden");
		$("input[name=is_locum][value=0]").prop('checked', true);
		
	}else{
		$("#locum_div").removeClass("hidden");
	}
	
	//If Usertype = doc, ask for GMC number
	if(this.value == 1){ // gmc_no_div
	

		validate_this = 'registration_no';
		
		$("#gmc_no_div").removeClass("hidden");
		$("label[for='gmc-gphc-nmc']").text('GMC No*');
		

	} else if(this.value == 2 || this.value == 6){ 

		validate_this = 'registration_no';

		$("#gmc_no_div").removeClass("hidden");
		$("label[for='gmc-gphc-nmc']").text('GPhC No*');

	} else if(this.value == 3){ 

		validate_this = 'registration_no';

		$("#gmc_no_div").removeClass("hidden");
		$("label[for='gmc-gphc-nmc']").text('NMC No*');

	}else{
		$("#gmc_no_div").addClass("hidden");
		$('#registration_no').val('');
	}//end if(this.value == 3)
	
	// Sol 1
	//$('#'+validate_this).attr("data-required", 'true');

	// Set validator to input ID
	
    // Enable the validators of email field
  	// $('#register_form').formValidation('enableFieldValidators', validate_this, true).formValidation('resetField', validate_this);
    
    //$('#register_form').data('formValidation').enableFieldValidators(validate_this, true);

    //$('#register_form').formValidation('enableFieldValidators', validate_this, true).formValidation('resetField', validate_this);
    
    //$('#register_form').bootstrapValidator('enableFieldValidators', validate_this, true).bootstrapValidator('resetField', validate_this);
	
    
});

//Locum Multiple Selector
var config = {
	'.chosen-location' : {width:"350px"}
}

for (var selector in config) {
	$(selector).chosen(config[selector]);
}//end for

//	HCP REGISTRATION - END

//This check to show additional field if Is Presriber value is 1
/*$('.terms_check').click(function() {
	var valid = $('input:checkbox[name=terms]:checked').val();
	
	if(valid == 1){
		$("#error_msg2").addClass("hidden");
		return true;
	}else{
		$("#error_msg2").removeClass("hidden");
		return false;
		
	}
});
*/

 
$('#btn-org').click(function(){
	
	$("#register").removeClass("disabled");
	$("#register").prop("disabled", false); // Element(s) are now enabled.
		
	$('#hcp_org_frm').formValidation({
		live: 'enabled',
	
	});

});

$('#user_type').on('change', function() {
		
	var user_type = $("#user_type").val();
	
	if(user_type ==1 || user_type ==2 || user_type == 3){
		
	$("#register").removeClass("disabled");
	$("#register").prop("disabled", false); // Element(s) are now enabled.
		
	$('#hcp_org_frm').formValidation({
		live: 'enabled',
	
	});
	
   }// if
	
});


// Check Email exists			
$("#email_address").blur(function(){
						
	var baseUrl = $('#base_url').val();
	var name = $('#email_address').val();
	var path = baseUrl + 'register/email-exists';
	$.ajax({
		url: path,
		type: "POST",
		data: {'key': name},
		success: function(data){
			var obj = JSON.parse(data);
		 //alert(obj.exist);
			if(obj.exist == 1){
				
				$("#error_msg").html("Email you entered already exist please use another one!");
				$("#error_msg").css({"color":"#a94442"});
				$("#email_address").val("");
				$( "#email_address" ).focus();
				$( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
				
			} else {
				$("#error_msg").html("");
		}
			console.log(obj.exist);
			
		}
	});

});
// End Exists
</script>