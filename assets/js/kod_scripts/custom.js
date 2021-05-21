/*
---------------------------------------------------------
-------Custon scripts - custom javascript functions--------
-----------------------------------------------------------
*/

$( ".kod-validate" ).validate({
  rules: {
    new_password: "required",
    confirm_password: {
		equalTo: "#new_password"
    }
  }
});

function expandMe(rand){
	$("#expand_ol_" + rand).animate({
		height: 'toggle'
	});
};

$(".expand-btn").click(function() {
	if($(this).text() == 'Collapse'){
		$(this).text('Expand');
	} else {
		$(this).text('Collapse');
	}
});

function editQuiz(question_id){
	
	// Active form - Focus and set greem border to highlight the action
	//$( "#quiz_add_edit_form" ).css( "border", "2px solid green" );
	////////////////////////////////////////
	
    var div = $('#quiz_add_edit_form');
	//$( div ).css( "border", "1px solid green" );
	////////////////////////////////////////
	
	// Ajax call for getting quiz data
	
	var full_path = $('#full_path').val();
	
	var request = $.ajax({
		url: full_path,
		type: "POST",
		data: {'question_id' : question_id},
		dataType: "JSON"
	});

	request.done(function(data) {
		
		// data.quiz[0]['options'][0]['option']
		
		if(data.quiz[0]['question_id'] != ''){ // If response-data is not null
			
			// fetching the question
			var question = data.quiz[0]['question'];
			// fetching the correct option
			var correct_option_id = data.quiz[0]['correct_option_id'];
			
			// fetching the quiz options
			var option_values_array = [];
			var options_id_array = [];
			var i = 0;
			
			// Fetching the Options
			for(i=0; i<data.quiz[0]['options'].length; i++){
				
				option_values_array[i] = data.quiz[0]['options'][i]['option'];
				options_id_array[i] = data.quiz[0]['options'][i]['option_id'];
				
			} // End - for loop
			
			// Set Data Values to the form elements
			$('#question').val(question);
			$('#question_id').val(question_id);
			
			$('#q1_field').val(option_values_array[0]);
			$('#q2_field').val(option_values_array[1]);
			$('#q3_field').val(option_values_array[2]);
			$('#q4_field').val(option_values_array[3]);
			$('#q5_field').val(option_values_array[4]);
			
			var append = '';
			var opt = 'A';
			var selected = '';
			
			// Set Data to correct_option
			$('#correct_option').html('<option value="">Select Correct Option</option>');
			var q_number = 1;
			
			// Create new fields for options as correct answer select - And - Rename the input fields
			var length = options_id_array.length;
			for(i=0; i<length; i++){
				
				if(options_id_array[i] == correct_option_id){
					selected = 'selected';
				} else {
					selected = '';
				}
				append = append + '<option '+ selected +' value="'+ options_id_array[i] +'">'+ opt +' - '+ option_values_array[i] +'</option>';
				
				$('#q'+ q_number +'_field').attr('name', 'options['+ options_id_array[i] +']');
				
				opt = String.fromCharCode(opt.charCodeAt(0) + 1);
				q_number = parseInt(q_number) + 1;
			}
			
			// Rename the remaining input fields
			for(i=length; i<5; i++){
				
				$('#q'+ q_number +'_field').attr('name', 'options[extra_'+ i +']');
				
				opt = String.fromCharCode(opt.charCodeAt(0) + 1);
				q_number = parseInt(q_number) + 1;
			}
			
			$('#correct_option').append(append);
		}
		
		$('.action_name').text('Update Quiz');
		console.log( data.quiz[0]['correct_option_id'] );
	});

	request.fail(function(jqXHR, textStatus) {
		alert( "Request failed: " + textStatus );
	});
	
}//emd editQuiz(question_id)

// Checked All None verify users
$("#checkAll").change(function () {
	$("input:checkbox").prop('checked', $(this).prop("checked"));
});


 $('#bulk_action').change(function(){
	 $(this).closest('form').trigger('submit');
	 $('#users_list_frm').submit();
	 
});



// User login fron admin Panel

 function  user_login_function (email,id,password) {
	 
	 alert(password)
	 $('#email_address').val(email);
	 $('#user_id').val(id);
	 $("#login_btn").submit();
 }

// add edit pharmacy surgery on dashbaord and member dashboard 
// Change Pharmacy / Surgery Settings [ ajax calls for each setting 0n/off ]
$('.kod-switch').on('switchChange.bootstrapSwitch', function (event, state) {
  
  
	var pharmacy_surgery_id = $( this ).attr("id");
	
	if(pharmacy_surgery_id == '0'){
		
		pharmacy_surgery_id = 0;
		
	} // if(pharmacy_surgery_id == '0')
	
	var field = $(this).attr("name");
	if(state == true)
		var value = 1;
	else
		var value = 0;

	$.ajax({
		url: SURL + 'organization/settings-process',
		type: "POST",
		data: {'pharmacy_surgery_id': pharmacy_surgery_id, 'field' : field, 'value' : value },
		success: function(response){
			
		}
	});
	
});



// Use for add edit pharmacy form validation
$('#form_pharmacy').validator();

// Use for add edit pharmacy form validation
$('#add_edit_patient_form').validator();

$('#form_manager_staff_edit').validator();

// Use for add edit organization sop form validation
//$('#add_edit_org_sop').validator()

$(document).ready(function() {
    $('#add_edit_org_sop').formValidation({
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
                        message: 'Please fill out this field.'
                    }
                }
            },
           
            category_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select an item in the list.'
                    }
                }
            },
			sop_category_name_text: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this field.'
                    }
                }
            }
			
        }
    });
});


