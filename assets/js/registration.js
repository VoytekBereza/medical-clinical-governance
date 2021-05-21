
//  HCP REGISTRATION - START
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
  
  //ToolTip
  //$('[data-toggle="tooltip"]').tooltip();
  
});  

//Some decisions on Usertype selection
$('#user_type').on('change', function() {
  
  var validate_this = '';

  //Ask for Prescriber or not just from Nurses and Pharmacist
  if(this.value == 2 || this.value == 3 || this.value == 8){
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

  } else if(this.value == 8){ 

    validate_this = 'registration_no';

    $("#gmc_no_div").removeClass("hidden");
    $("label[for='gmc-gphc-nmc']").text('Registration No*');

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

//  HCP REGISTRATION - END

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