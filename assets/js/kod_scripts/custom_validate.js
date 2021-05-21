// For login validation
$(".form_login_validate").validate( {
	rules: {
		validate_msg: "required",
	},
	messages: {
		validate_msg: "Please enter your page title"
	},
	errorElement: "em",
	errorPlacement: function ( error, element ) {
		// Add the `help-block` class to the error element
		error.addClass( "help-block" );
			error.insertAfter( element );
	},
	highlight: function ( element, errorClass, validClass ) { // On Error
		$( element ).parents( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
		/*e.preventDefault();
		return false;*/
	},
	unhighlight: function (element, errorClass, validClass) { // on success
		$( element ).parents( ".validate_msg" ).addClass( "has-success" ).removeClass( "has-error" );
		/*e.preventDefault();
		return false;*/
	}
});
// end login validation					
					
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
	
// For dashboard Password validation			 
$(".form_validate_password").validate({
		rules: {
			validate_msg: "required",
			new_password: {
				minlength:8
			},
			confirm_password: {
				equalTo: "#new_password"
				
			},
			gmc_no: {
				maxlength:15
			},
			gphc_no: {
				maxlength:15
			},
			nmc_no: {
				maxlength:15
			},
			
		},
		messages: {
			validate_msg: "Please enter your page title"
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
				error.insertAfter( element );
		},
		highlight: function ( element, errorClass, validClass ) { // On Error
			$( element ).parents( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
			/*e.preventDefault();
			return false;*/
		},
		unhighlight: function (element, errorClass, validClass) { // on success
			$( element ).parents( ".validate_msg" ).addClass( "has-success" ).removeClass( "has-error" );
			/*e.preventDefault();
			return false;*/
		}
});
	 // end dashboard Password Form Validation	
	
	// For Signature  validation			 
$(".form_validate_signature").validate( {
	rules: {
		validate_msg: "required",
		
	},
	messages: {
		validate_msg: "Please enter your page title"
	},
	errorElement: "em",
	errorPlacement: function ( error, element ) {
		// Add the `help-block` class to the error element
		error.addClass( "help-block" );
			error.insertAfter( element );
	},
	highlight: function ( element, errorClass, validClass ) { // On Error
		$( element ).parents( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
		/*e.preventDefault();
		return false;*/
	},
	unhighlight: function (element, errorClass, validClass) { // on success
		$( element ).parents( ".validate_msg" ).addClass( "has-success" ).removeClass( "has-error" );
		/*e.preventDefault();
		return false;*/
	}
});
	// end  Signature Form Validation	
			
// Add edit pharmacy surgery form validation


$(".form_validate_pharmacy").validate( {

	rules: {
		validate_msg: "required",
	},
	messages: {
		validate_msg: "Please enter your page title"
	},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
		// Add the `help-block` class to the error element
		error.addClass( "help-block" );
		error.insertAfter( element );
	},
		highlight: function ( element, errorClass, validClass ) { // On Error
		$( element ).parents( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
		/*e.preventDefault();
		return false;*/
	},
		unhighlight: function (element, errorClass, validClass) { // on success
		$( element ).parents( ".validate_msg" ).addClass( "has-success" ).removeClass( "has-error" );
		/*e.preventDefault();
		return false;*/
	}
}); // End #form_validate_pharmacy


// form_validate_staff_manager
$(".form_validate_staff_manager").validate( {
	rules: {
		validate_msg: "required",
		mobile_no: {
			maxlength:11,
			digits:true
		},
		
	},

	messages: {
		validate_msg: "Please enter your page title"
	},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
		// Add the `help-block` class to the error element
		error.addClass( "help-block" );
		error.insertAfter( element );
	},
		highlight: function ( element, errorClass, validClass ) { // On Error
		$( element ).parents( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
		/*e.preventDefault();
		return false;*/
	},
		unhighlight: function (element, errorClass, validClass) { // on success
		$( element ).parents( ".validate_msg" ).addClass( "has-success" ).removeClass( "has-error" );
		/*e.preventDefault();
		return false;*/
	}
}); // End #form_validate_staff_manager

		
$(document).ready(function() {
    $('#add_new_sop_frm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
			 'user_types[]': {
                validators: {
                    notEmpty: {
                        message: 'Please specify at least one checkbox'
                    }
                }
            },
            sop_title: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
           
            sopcategoryid: {
                validators: {
                    notEmpty: {
                        message: 'Please select an item in the list.'
                    }
                }
            }
        }
    });
});

