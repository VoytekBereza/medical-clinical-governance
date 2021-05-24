/*
---------------------------------------------------------
-------Custon scripts - custom javascript functions--------
-----------------------------------------------------------
*/
var $= jQuery.noConflict();
$(document).ready(function() {
    $('#user_table').DataTable( {
		
		// Regular expression filter
		"search": {
			"regex": true
		},
		// Make columns definitions
		"columnDefs": [
            {
                "targets": [ 8 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 9 ],
                "visible": false,
				"searchable": true
            }
        ]
    } );
} );


/*$(".kod-validate" ).validate({
  rules: {
    new_password: "required",
    confirm_password: {
		equalTo: "#new_password"
    }
  }
});
*/

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
		
		$('.action_name').text('Update Exam');
		
		//console.log( data.quiz[0]['correct_option_id'] );
	});

	request.fail(function(jqXHR, textStatus) {
		alert( "Request failed: " + textStatus );
	});
	
}//end editQuiz(question_id)

// Checked All None verify users
$("#checkAll").change(function () {
	$("input:checkbox").prop('checked', $(this).prop("checked"));
});

// function to [ Verify all users ]
$('#bulk_action').change(function(){
	$(this).closest('form').trigger('submit');
	$('#users_list_frm').submit();
	
}); // $('#bulk_action').change(function()

 // Patient verified
 $('#patient_verify_action').change(function(){
	 $(this).closest('form').trigger('submit');
	 $('#list_patient_frm').submit();
	
});

// User login fron admin Panel

function user_login_function (email, id, password) {
	
	$('#is_admin').val(1);
	$('#email_address').val(email);
	$('#password').val(password);
	$('#login_btn').val(1);
	
	$("#auto_login_form").attr('target', '_blank').submit();
	
 }
 
// Start - get_trainings_by_user_type()
//$("#user_type_dropdown").change(function () {
function filter_users_listing(){
	var user_type = $('#user_type_dropdown').val();
	if(user_type != 'all')
		window.location = SURL + 'trainings/list-all-trainings/'+ user_type;
	else
		window.location = SURL + 'trainings/list-all-trainings';
}
//}); // End - get_trainings_by_user_type()

function user_history(user_id){
	
	var request = $.ajax({
		url: SURL + 'users/user_purchase_history_ajax_call/' + user_id,
		type: "POST",
		data: {'user_id' : user_id},
		dataType: "JSON"
	});
	
	// On Success callBack
	request.done(function(data){
		
		var trainings = data['training'];
		var pgds = data['pgds'];
		
		var package_purchased = data['package_purchased'];
		var package_expiry = data['package_expiry'];
		var package_expired = data['package_expired'];
		
		// Get All Trainings
		for(var k1_product_id in trainings){
			if(typeof trainings[k1_product_id] === 'object'){
				for(var objkey in trainings[k1_product_id]){
					//alert(objkey + ': ' + trainings[k1_product_id][objkey] );
				}
			} else {
				alert('Non object');
			}
		}
		
		// Get All PGDs
		for(var key in pgds){
			if(typeof pgds[key] !== 'function') {
				//alert("Key is " + key + ", value is" + pgds[key]);
				if(typeof pgds[key] === 'object') {
					for(var key_object in pgds[key]){
						//alert('Object founded at key: ' + key_object);
						for(var k1 in pgds[key][key_object]){
							//alert('Key: ' + k1 + ' -  Value: ' + pgds[key][key_object][k1]);
						}
					}
				}
			}
		}
		
		console.log( data );
	});
	// On failed callBack
	request.fail(function(jqXHR, textStatus) {
		alert( "Request failed: " + textStatus );
	});
	
}

// Auto search for doctor and pharmacist
$(".search").keyup(function() 
{ 

$("#result").html('');
$("#result2").html('');
var searchid = $(this).val();
var usertype = $(this).attr("id");

var dataString = 'search='+ searchid + '&usertype='+ usertype;
var path = SURL + 'users/search-doctor-pharmacist';
if(searchid!='')
{
	$.ajax({
	type: "POST",
	url: path,
	data: {'search': searchid, 'usertype' : usertype},
	cache: false,
	success: function(data)
	{

		var obj = JSON.parse(data);
		var html_data = '';

		html_data += '<ul class="list-group scroll_auto_suggesion" style="z-index: 999; position: absolute; width: 90%; overflow-y: auto; ">';
        $.each(obj, function(index, element) {
			//element.first_name
			 html_data += '<li class="list-group-item" style="cursor:pointer;" onClick="select_emails(\' '+ element.first_name + " " + element.last_name +' \', '+ usertype +' , \' '+ element.email_address +' \');">'+ element.first_name + " " + element.last_name + " " + element.registration_no + '</li>';	
		});
		
		html_data +='</ul>';
		
		
		if(usertype==1){
			
			$("#result").show();
			$("#result").html(html_data);
			
		} else if(usertype==2){
			
			$("#result2").show();
			$("#result2").html(html_data);
		}
	}
	});
}
});

$(".search_presc").keyup(function() 
{ 

$("#result_presc").html('');

var searchid = $(this).val();
var usertype = $(this).attr("id");

var dataString = 'search='+ searchid;
var path = SURL + 'users/search-prescriber';
if(searchid!='')
{
	$.ajax({
	type: "POST",
	url: path,
	data: {'search': searchid},
	cache: false,
	success: function(data)
	{

		var obj = JSON.parse(data);
		var html_data = '';

		html_data += '<ul class="list-group scroll_auto_suggesion" style="z-index: 999; position: absolute; width: 90%; overflow-y: auto; ">';
        $.each(obj, function(index, element) {
			//element.first_name
			 html_data += '<li class="list-group-item" style="cursor:pointer;" onClick="select_presc_emails(\' '+ element.first_name + " " + element.last_name +' \', \' '+ element.email_address +' \');">'+ element.first_name + " " + element.last_name + " " + element.registration_no + '</li>';	
		});
		
		html_data +='</ul>';
		
		$("#result_presc").show();
		$("#result_presc").html(html_data);
	}
	});
}
});


// select val 
// display input box email 
function select_emails(val,id,email) {
	
	$("#" + id).val(val);
	if(id == '1'){
		$("#doctor_email").val(email);
		$("#result").hide();
	} else {
		$("#pharmacist_email").val(email);
		$("#result2").hide();
	}
} // end select_emails

function select_presc_emails(val,email) {

	$("#is_default_prescriber").val(val);
	$("#prescriber_email").val(email);
	
	$("#result_presc").hide();

} // end select_presc_emails
	
	// Medicine Strength Add
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div class="row"><div class="field_wrapper  pull-left"><div class="col-lg-3 col-md-3 col-sm-3"><div class="form-group"><label for="middle-name">Strenght:</label><input type="text" id="strength" name="strength[]"  class="form-control" value=""></div></div><div class="col-lg-3 col-md-3 col-sm-3"><div class="form-group"><label for="middle-name">Price /Per Qty:</label><input type="text" id="per_price" name="per_price[]"  class="form-control" value=""></div></div><div class="col-lg-3 col-md-3 col-sm-3"><div class="form-group"><label for="middle-name">Strength Value</label><input type="text" id="strength_value" name="strength_value[]"  class="form-control" value=""></div></div><div class="col-lg-3 col-md-3 col-sm-3"><label for="middle-name">&nbsp; </label> <br /></div><a title="Remove field" class="remove_button btn btn-danger btn-xs" href="javascript:void(0);">Remove</a></div></div>'; //New input field html
	$(addButton).click(function(){ //Once add button is clicked
		$(wrapper).append(fieldHTML); // Add field html
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		//x--; //Decrement field counter
	}); //End  Medicine Strength Add
	
	
	// Medicine Strength Edit 
	var addButton_edit_strength = $('.add_button_edit_strength'); //Add button selector
	var wrapper_edit_strength = $('.field_wrapper'); //Input field wrapper
	var fieldHTML_edit_strength = '<div class="row"><div class="field_wrapper  pull-left"><div class="col-lg-3 col-md-3 col-sm-3"><div class="form-group"><label for="middle-name">Strenght:</label><input type="text" id="strength" name="strength_edit[]"  class="form-control" value=""></div></div><div class="col-lg-3 col-md-3 col-sm-3"><div class="form-group"><label for="middle-name">Price /Per Qty:</label><input type="text" id="per_price" name="per_price_edit[]"  class="form-control" value=""></div></div><div class="col-lg-3 col-md-3 col-sm-3"><div class="form-group"><label for="middle-name">Strength Value</label><input type="text" id="strength_value_edit" name="strength_value_edit[]"  class="form-control" value=""></div></div><div class="col-lg-3 col-md-3 col-sm-3"><label for="middle-name">&nbsp; </label> <br /></div><a title="Remove field" class="remove_button btn btn-danger btn-xs" href="javascript:void(0);">Remove</a></div></div>'; //New input field html
	$(addButton_edit_strength).click(function(){ //Once add button is clicked
		$(wrapper_edit_strength).append(fieldHTML_edit_strength); // Add field html
	});
	$(wrapper_edit_strength).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		//x--; //Decrement field counter
	});	// End  Medicine Strength Edit 
	
	// Medicine Quantity Add
	var addButton_quantity = $('.add_button_quantity'); //Add button selector
	var wrapper_quantity = $('.field_wrapper_quantity'); //Input field wrapper
	var fieldHTML_Qauntity = '<div class="row"><div class="field_wrapper_quantity pull-left"><div class="col-md-3 col-sm-3 col-xs-3"><div class="form-group"><label for="middle-name">Quantity:</label><input type="number" id="quantity" name="quantity[]"  class="form-control" value=""></div></div><div class="col-md-3 col-sm-3 col-xs-3"><div class="form-group"><label for="middle-name">Quantity txt:</label><input type="text" id="quantity_txt" name="quantity_txt[]"  class="form-control" value=""></div></div><div class="col-md-3 col-sm-3 col-xs-3"><div class="form-group"><label for="middle-name">Discount percentage:</label><input type="number" id="discount_precentage" name="discount_precentage[]"  class="form-control" value=""></div></div><div class="col-md-3 col-sm-3 col-xs-3"><label for="middle-name">&nbsp; </label><br /></div><a href="javascript:void(0);" class="remove_button_quantity btn btn-danger btn-xs" title="Remove field">Remove</a></div></div>'; //New input field html
	$(addButton_quantity).click(function(){ //Once add button is clicked
		$(wrapper_quantity).append(fieldHTML_Qauntity); // Add field html
	});
	$(wrapper_quantity).on('click', '.remove_button_quantity', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		//x--; //Decrement field counter
	}); // End  Medicine Quantity Add

    // Medicine Quantity Edit
	var addButton_quantity_edit = $('.add_button_quantity_edit'); //Add button selector
	var wrapper_quantity_edit = $('.field_wrapper_quantity'); //Input field wrapper
	var fieldHTML_Qauntity_edit = '<div class="row"><div class="field_wrapper_quantity pull-left"><div class="col-md-3 col-sm-3 col-xs-3"><div class="form-group"><label for="middle-name">Quantity:</label><input type="number" id="quantity" name="quantity_edit[]"  class="form-control" value=""></div></div><div class="col-md-3 col-sm-3 col-xs-3"><div class="form-group"><label for="middle-name">Quantity txt:</label><input type="text" id="quantity_txt" name="quantity_txt_edit[]"  class="form-control" value=""></div></div><div class="col-md-3 col-sm-3 col-xs-3"><div class="form-group"><label for="middle-name">Discount percentage:</label><input type="number" id="discount_precentage" name="discount_precentage_edit[]"  class="form-control" value=""></div></div><div class="col-md-3 col-sm-3 col-xs-3"><label for="middle-name">&nbsp; </label><br /></div><a href="javascript:void(0);" class="remove_button_quantity btn btn-danger btn-xs" title="Remove field">Remove</a></div></div>'; //New input field html
	$(addButton_quantity_edit).click(function(){ //Once add button is clicked
		$(wrapper_quantity_edit).append(fieldHTML_Qauntity_edit); // Add field html
	});
	$(wrapper_quantity_edit).on('click', '.remove_button_quantity', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		//x--; //Decrement field counter
	});  //End  Medicine Quantity Edit

// select_raf_lable
function  select_raf_lable(medicine_id,raf_id){
	
$("#result_ajax_raf_label").html('');

var path = SURL + 'medicine/list-all-medicine-raf-ajax';

	$.ajax({
	type: "POST",
	url: path,
	data: {'raf_lable_id': raf_id.value, 'medicine_id' : medicine_id},
	cache: false,
	success: function(data)
	{
			$("#result_ajax_raf_label").show();
			$("#result_ajax_raf_label").html(data);
	}
	});
};

// select_raf_lable
function  select_vaccine_raf_lable(vaccine_id,raf_id){
	
$("#result_ajax_raf_label").html('');

var path = SURL + 'vaccine/list-all-vaccine-raf-ajax';

	$.ajax({
	type: "POST",
	url: path,
	data: {'raf_lable_id': raf_id.value, 'vaccine_id' : vaccine_id},
	cache: false,
	success: function(data)
	{
			$("#result_ajax_raf_label").show();
			$("#result_ajax_raf_label").html(data);
	}
	});
};


// Destination risk season Add
	var addButtonrisk = $('.add_button_risk_season'); //Add button selector
	var wrapperrisk = $('.field_wrapper'); //Input field wrapper
	var fieldHTMLrisk = '<div class="field_wrapper"><div class="form-group"><label for="middle-name"></label><textarea id="risk_area_season" name="risk_area_season[]" placeholder="Enter Risk Area Season" rows="3" class="form-control" aria-required="true"></textarea></div><a title="Remove field" class="remove_button btn btn-danger btn-xs" href="javascript:void(0);">Remove</a></div>'; //New input field html
	$(addButtonrisk).click(function(){ //Once add button is clicked
		$(wrapperrisk).append(fieldHTMLrisk); // Add field html
	});
	$(wrapperrisk).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		//x--; //Decrement field counter
	}); //End  Medicine Strength Add

// Patient update if select February
$(".month_february_select").change(function(){
 
	var birth_date = $("#birth_date").val();
	var birth_month = $("#birth_month").val();
	var birth_year = $("#birth_year").val();
	
	if(birth_month==2 && (birth_date == 30 || birth_date == 31)){
		
		$("select option[value*='30']").prop('disabled',true);
		$("select option[value*='31']").prop('disabled',true);
		$('#birth_date :selected').removeAttr('selected', '');
		
	} else if(birth_month==2 && birth_date == 29){
		
		if(birth_year!=""){
			 var leap_year =  ((birth_year % 4 == 0) && (birth_year % 100 != 0)) || (birth_year % 400 == 0);
			 if(leap_year == true){
				$("select option[value*='29']").prop('disabled',false);
			 } else {
				 $("select option[value*='29']").prop('disabled',true);
				 $('#birth_date :selected').removeAttr('selected', '');
			 }
		}
	}else if(birth_month!=2){
		
  			$("select option[value*='29']").prop('disabled',false);
            $("select option[value*='30']").prop('disabled',false);
			$("select option[value*='31']").prop('disabled',false);
        
	}else if(birth_month==2) {

		if(birth_year!=""){
			 var leap_year =  ((birth_year % 4 == 0) && (birth_year % 100 != 0)) || (birth_year % 400 == 0);
			 if(leap_year == true){
				
				$("select option[value*='29']").prop('disabled',false);
			 } else {
				 $("select option[value*='29']").prop('disabled',true);
			 }
		}
		$("select option[value*='30']").prop('disabled',true);
		$("select option[value*='31']").prop('disabled',true);
	}
	
});

// function to [ embed code enabaled disabled of pharmacies ]
$('#embed_status').change(function(){

	$(this).closest('form').trigger('submit');
	$('#pharmacies_frm').submit();
	
}); // $('#embed_status').change(function()
