	   
	    // CMS Form Validaion
		/*$.validator.setDefaults( {
			submitHandler: function () {
				alert( "submitted!" );
			}
		} );*/
		
	// Form Validaion
	// $(".form_validate").submit(function(e){
				 
    $(".form_validate").validate( {
						
					ignore: [],
             		debug: false,
					rules: {
						validate_msg: "required"
					},
					mobile_no: {
							maxlength:11
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
					
					messages: {
						
						validate_msg: "Please enter your page title"
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "help-block" );
						error.insertAfter(element);
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
					
	
	function document_form_add(id) {
		
		 $("#add_update_document_form" + id).validate( {
						
					ignore: [],
             		debug: false,
					rules: {
						validate_msg: "required"
					},
					mobile_no: {
							maxlength:11
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
					
					messages: {
						
						validate_msg: "Please enter your page title"
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "help-block" );
						error.insertAfter(element);
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
		
			}
					
	$('.active_training').on('click', function (e){
	
	var training_id = $(this).val();
	
	
	if(training_id!=""){
		
		$('#product_id').val(training_id);
		
		$('.animated').removeClass("hidden");
		
	} else {
		
		$('.my_class').addClass("hidden");
		
	}
	
}); // $('#embed_status').change(function()

					
$(".form_validate2").validate( {
						
		ignore: [],
		debug: false,
		rules: {
			validate_msg: "required"
		},
		mobile_no: {
				maxlength:11
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
		
		messages: {
			
			validate_msg: "Please enter your page title"
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter(element);
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
//}); // end Form Validation
	
$(".form_validate_sop").validate( {
						
	ignore: [],
	debug: false,
	rules: {
		validate_msg: "required"
	},
	mobile_no: {
			maxlength:11
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
	
	messages: {
		
		validate_msg: "Please enter your page title"
	},
	errorElement: "em",
	errorPlacement: function ( error, element ) {
		// Add the `help-block` class to the error element
		error.addClass( "help-block" );
		error.insertAfter(element.parents(".validate_msg"));
			//error.insertAfter(element);
	},
	highlight: function ( element, errorClass, validClass ) { // On Error
		
		$("em").css("color", "#a94442");
		
		/*e.preventDefault();
		return false;*/
	},
	unhighlight: function (element, errorClass, validClass) { // on success
		$( element ).parents( ".validate_msg" ).addClass( "has-success" ).removeClass( "has-error" );
		/*e.preventDefault();
		return false;*/
	}
	});
//}); // end Form Validation
				
						
// CK editor validation for Governance 
$(".form_validate_governance").validate(
{
	ignore: [],
	debug: false,
	rules: { 
		validate_msg: "required",
		governance_text:{
			 required: function() 
			{
			 CKEDITOR.instances.governance_text.updateElement();
			},

			 minlength:5
		},
		 hr_text:{
			 required: function() 
			{
			 CKEDITOR.instances.hr_text.updateElement();
			},

			 minlength:5
		},
		 sop_text:{
			 required: function() 
			{
			 CKEDITOR.instances.sop_text.updateElement();
			},

			 minlength:5
		},
		 finish_text:{
			 required: function() 
			{
			 CKEDITOR.instances.finish_text.updateElement();
			},

			 minlength:5
		}
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
}); // end CK editor validation for Governance 

// Check Setting Name exists			
$("#setting_name").blur(function(){
						
	var baseUrl = $('#base_url').val();
	var name = $('#setting_name').val();
	var path = baseUrl + 'settings/setting-name-exists';
	$.ajax({
		url: path,
		type: "POST",
		data: {'key': name},
		success: function(data){
			var obj = JSON.parse(data);
		 //alert(obj.exist);
			if(obj.exist == 1){
				$("#error_msg").html("Name already exist!");
				$("#error_msg").css({"color":"#a94442"});
				$("#setting_name").val("");
				$( "#setting_name" ).focus();
				$( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
				
			} else {
				$("#error_msg").html("");
		}
			console.log(obj.exist);
			
		}
	});

});
	// End Exists				
				
				
				
		$('input:radio[name=is_prescriber]').click(function() {
		var val = $('input:radio[name=is_prescriber]:checked').val();
		
		if(val == 1){
			 $("#speciality_div").removeClass("hidden");
		}else{
			$("#speciality_div").addClass("hidden");
			//$('#speciality').val('');
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


		
