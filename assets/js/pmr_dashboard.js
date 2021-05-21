// Auto search for Patient
$(".search_patient").keyup(function(e){
	// Accepts all the keys except [ upkey and downkey ]
	if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 37 && e.keyCode != 39 ){

		var search_patient = $(this).val();
		var path = SURL + 'pmr/search-patient';
		var min_length = 3;
		
		if(search_patient == ''){
			$("#result_patient").html('');
		}
		
		if(search_patient!='' && search_patient.length >= min_length) {

			$.ajax({
				type: "POST",
				url: path,
				data: {'search_patient': search_patient},
				cache: false,
				beforeSend: function(){
			    	// Handle the beforeSend event
			    	$('.overlay').removeClass("hidden");
			   	},
				success: function(data)
				{

					$('.overlay').addClass("hidden");

					// The below code is ok for now
					if(data == 'not_found'){
						
						$("#result_patient").show();
						// $("#result_patient").html('<li class="list-group-item text-primary" id="add-new-patient-li" style="padding-top:5px;"> <a id="add-new-patient" href="'+ SURL +'organization/pmr/add-edit-patient" style="color:#555555;">Add New Patient</a></strong> </li>');
						$("#result_patient").html(data);
					
					} else {

						$("#result_patient").show();
						$("#result_patient").html(data);

						var url = $('#add-new-patient').attr("href")+'/'+encodeURIComponent(search_patient);

						$('#add-new-patient').attr("href", url)
						
					} //if(data == 'not_found')
					
				} // success
			
			}); // $.ajax

	   } // if(search_patient!='' && search_patient.length >= min_length)

	} else {

		if( e.keyCode == 13 ){ // enter

			$(".selected").trigger("click");

			if( $('#add-new-patient').attr("href") != undefined ){

				if( $('#add-new-patient-li').hasClass("selected") )
					window.location = $('#add-new-patient').attr("href");

			} // if( $('#add-new-patient').attr("href") != undefined )

		} // if( e.keyCode == 13 && $('.result_patient li').hasClass("selected") == true )

	    if (e.keyCode == 38) { // up Arrow key
	    	
	    	// $("#email-list > li").removeClass("selected");

	        var selected = $(".selected");

	        if(selected != undefined){

		        $("#result_patient li").removeClass("selected");
		        if (selected.prev().length == 0) {
		            selected.siblings().last().addClass("selected");
		        } else {
		            selected.prev().addClass("selected");
		        }

		    } else {

		    	$("#result_patient li").removeClass("selected");

		    } // if(selected != undefined)
	    }
	    if (e.keyCode == 40) { // Down Arrow key
	        
	        // $("#email-list > li").addClass("selected");
	        // $("#email-list").siblings().first().addClass("selected");

	        var selected = $(".selected");

	        if($(selected).html() != undefined){

	        	if( $(selected).attr("id") != "add-new-patient-li" ){
	        		$("#result_patient li").removeClass("selected");
	        	}
		        
		        if (selected.next().length == 0){
		            selected.siblings().first().addClass("selected");
		        } else {
		            selected.next().addClass("selected");
		        } // if (selected.next().length == 0)

		    } else {
		    	
		    	$("#result_patient li").addClass("selected");
		    }

	    } // if( e.keyCode == 13 && $('#result_patient li').hasClass("selected") == true )

	} // if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40)
});

//$('#validate_ajax_form').on('submit', function(e){    });

// Start - validate_this_form() : KOD-Function to validate all the input fields of a  form by ID having attribute required="required"
function validate_this_form(form_id){

	var allow_submission = 1;
	var first_element = true;

	$("form#"+form_id+" :input").each(function(){
	 	
	 	var input = $(this); // This is the jquery object of the input
	 	
	 	// console.log(input.attr("type"));

	 	if(input.attr("type") == "radio"){

	 		var radio_id = input.attr("id");
		 	name = input.attr('name');
	        
	        if (!$(':radio[name="' + name + '"]:checked').length){
	            
	            $('#' + radio_id + '-label').css({'border':"1px solid #a94442"});
	            $('#' + radio_id + '-label').addClass("text-danger");

	            allow_submission = 0;

	            if(first_element == true){

			 		$('html, body').animate({ scrollTop: $('#'+input.attr("id")).parent().offset().top -60 }, 500);
			 		first_element = false;

			 	} // if(first_element == true)

	        } else {

	        	$('#' + radio_id + '-label').css({'border':"1px solid green"});
	        	$('#' + radio_id + '-label').removeClass("text-danger");
	        	$('#' + radio_id + '-label').addClass("text-success");

	        } // if (!$(':radio[name="' + name + '"]:checked').length)
			
	    }
	 	
	 	if(input.attr("required") == "required" && input.attr("type") != "hidden"){
	 		
	 		if(input.val() == ''){

	 			allow_submission = 0;

	 			input.css({'border':"1px solid #a94442"});

	 			if( $("#err-msg-"+input.attr('id')).text() == '' )
	 				input.after("<p id='err-msg-"+input.attr("id")+"' class='text-danger' style='padding: 5px;' > This field is required. </p>");

	 			if(first_element == true){

			 		$('html, body').animate({ scrollTop: $('#'+input.attr("id")).parent().offset().top -60 }, 500);

			 		first_element = false;

			 	} // if(first_element == true)

	 		} else {

	 			input.css({'border':"1px solid green"});
	 			$("#err-msg-"+input.attr('id')).remove();

	 			// $('#raf_complete_btn').click();

	 		} // if(input.val() == '')

	 	} // if(input.attr("required") == "required" && input.attr("type") != "hidden")

	});

	if(allow_submission == 1){

		if( $('#select-raf').val() == 30 || $('#select-raf').val() == 33 ){ // sRAF OR tRAF

			if( $('#select-raf').val() == 33 ){ // tRAF
				
				// Verify if atleast one vaccine is added only if the selected raf ID is [ 30 OR 33 ]
				var check_new_added_journey = $('[id^="is-new-journey-added"]');
				if( $(check_new_added_journey).val() > 0 ){
					
				} else {
					
					if($('#add-journey-row-submit-error').text() == '')
						$('#add_journey_row_btn').parent().parent().parent().append('<br /> <br /> <div class="col-md-12"> <div class="alert alert-danger" id="add-journey-row-submit-error"> Click on Add button to continue... </div> </div>');
					// if($('#vaccine-error-msg').text() == null)

					$('html, body').animate({ scrollTop: $('#country-parent-div').parent().offset().top - 100 }, 1500);
					return false;
				}

			} // if( $('#select-raf').val() == 33 )

			// Verify if atleast one vaccine is added only if the selected raf ID is [ 30 OR 33 ]
			var check_new_added_vaccine = $('[id^="is-new-vaccine-added"]');
			if( $(check_new_added_vaccine).val() > 0 ){
				$('#'+form_id).submit();
			} else {
				
				if($('#add-vaccine-row-submit-error').text() == '')
					$('#add_vaccine_row_btn').parent().parent().parent().append('<br /> <br /> <div class="col-md-12"> <div class="alert alert-danger" id="add-vaccine-row-submit-error"> Click on Add button to continue... </div> </div>');
				// if($('#vaccine-error-msg').text() == null)

				$('html, body').animate({ scrollTop: $('#vaccine-parent-div').parent().offset().top - 100 }, 500);

			}

		} else {
			$('#'+form_id).submit();
		} // if( $('#select-raf').val() == 30 || $('#select-raf').val() == 33 ){ // sRAF OR tRAF

	} // if(allow_submission == 1)

} // End - validate_this_form

// select val 
// display input box email 
function select_patient(patient_id) {
	
	window.location = SURL + 'pmr/patient-dashboard/' + patient_id;
	return;
	
} // end function select_patient(val)

// Check Email exist			
$("#email_address_patient").keyup(function(){
	
	var email = $('#email_address_patient').val();
	var path = SURL + 'pmr/email-exist-patient';
	
	$.ajax({
		url: path,
		type: "POST",
		data: {'email': email},
		beforeSend: function(){
	    	// Handle the beforeSend event
	    	$('.overlay').removeClass("hidden");
	   	},
		success: function(data){
			
			$('.overlay').addClass("hidden");

			var obj = JSON.parse(data);
		 	//alert(obj.exist);
			if(obj.exist == 1){
				$("#error_msg_patient").html("Email you entered already exist please use another one!");
				$("#error_msg_patient").css({"color":"#a94442"});
				$("#email_address_patient").val("");
				$( "#email_address_patient" ).focus();
				$( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
				
			} else {
				$("#error_msg_patient").html("");
		}
			console.log(obj.exist);
			
		}
	});

});
// End Exists

// Check Email exist			
$("#email_address_patient").blur(function(){
	
	var email = $('#email_address_patient').val();
	var path = SURL + 'pmr/email-exist-patient';
	
	$.ajax({
		url: path,
		type: "POST",
		data: {'email': email},
		beforeSend: function(){
	    	// Handle the beforeSend event
	    	$('.overlay').removeClass("hidden");
	   	},
		success: function(data){
			
			$('.overlay').addClass("hidden");

			var obj = JSON.parse(data);
		 	//alert(obj.exist);
			if(obj.exist == 1){
				$("#error_msg_patient").html("Email you entered already exist please use another one!");
				$("#error_msg_patient").css({"color":"#a94442"});
				$("#email_address_patient").val("");
				$( "#email_address_patient" ).focus();
				$( ".validate_msg" ).addClass( "has-error" ).removeClass( "has-success" );
				
			} else {
				$("#error_msg_patient").html("");
		}
			console.log(obj.exist);
			
		}
	});

});
// End Exist		

$(".medicine_suggessions li a").mouseover(function() {
    
    $(".medicine_suggessions li").removeClass("selected");
    $(this).addClass("selected");

});

// Search medicine : Get suggessions [ ul -> li ]
$('.search-medicine').keydown(function(e){
	
	// Accepts all the keys except [ upkey and downkey ]
	if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ){

		var that = this;
		
		// Search query string
		var keywords = $(this).val();
		
		if(keywords.length >= 3){
		
			$.ajax({
				url: SURL + 'pmr/search-medicine',
				type: "POST",
				data: {'keywords': keywords},
				beforeSend: function(){
			    	// Handle the beforeSend event
			    	// $('.overlay').removeClass("hidden");
				},
				success: function(data){
				
					// $('.overlay').addClass("hidden");

					var obj = $.parseJSON(data); // Parse Json array as obj
					if(obj.error == 0){
						
						// If medicine founded
						$('#medicine_suggessions').html('');
						
						// Prepare HTML for show suggessions as list items
						var html = '<ul id="medicine-list" class="list-group" style="z-index: 999; position: absolute; width: 96.5%; overflow-y: auto; min-height:50px; max-height:910px;">';
						var cls = 'selected'; // class selected to be used in the first sugesstion

						$.each( obj.data, function(key, value){
							
							if($("#current-transaction-row").find("#med_item_"+ value.strength_id +"").length <= 0){
							   html += '<li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" onclick="select_medicine('+ parseInt(1) +', \''+ value.medicine_class +'\', '+ value.strength_id +', \'' + value.medicine_id + '\', \'' + value.med_full_name + '\', \'' + value.strength + '\', \'' + value.medicine_form + '\', \'' + value.suggested_dose + '\')" ><strong style="cursor:pointer;"><a href="javascript:;">' + value.med_full_name + ' - ' + value.strength + ' - ' + value.is_branded + '</a></strong></li>';
							   cls = ''; // set cls = selected to null
							}// if($("#medicine-list #"+ value.strength_id +"").length)

						}); // $.each( obj.data, function( key, value )
						
						html += '</ul>';
						
						// Place html after input field [ search medicine ]
						$(that).after('<div class="medicine_suggessions" id="medicine_suggessions">' + html + '</div>');
						
					} else
						$('#medicine_suggessions').html('<p> No record found. </p>');
					// if(obj.error == 0)
						
				} // success: function(data)
				
			}); // $.ajax
			
		} else {
			
			$('#medicine_suggessions').html('');
			$('#medicine_suggessions').hide();
			
		} // if(keywords.length >= 3)

	} else {

		if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true ){ // enter

			$(".selected").trigger("click");

			$(".medicine_suggessions").remove();
			$(".medicine-list").remove();
			$('.search-medicine').val('');

		} // if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true )

	    if (e.keyCode == 38) { // up Arrow key
	        var selected = $(".selected");
	        $(".medicine_suggessions li").removeClass("selected");
	        if (selected.prev().length == 0) {
	            selected.siblings().last().addClass("selected");
	        } else {
	            selected.prev().addClass("selected");
	        }
	    }
	    if (e.keyCode == 40) { // Down Arrow key
	        
	        var selected = $(".selected");
	        $(".medicine_suggessions li").removeClass("selected");
	        
	        if (selected.next().length == 0){
	            selected.siblings().first().addClass("selected");
	        } else {
	            selected.next().addClass("selected");
	        } // if (selected.next().length == 0)

	    } // if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true )

	} // if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40)
	
}); // $('.search-medicine').keyup(function()


$('.search-medicine-custom').keyup(function(e){
	
	// Accepts all the keys except [ upkey and downkey ]
	if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ){

		var that = this;
		
		// Search query string
		var keywords = $(this).val();
		
		if(keywords.length >= 2){
		
			$.ajax({
				url: SURL + 'pmr/search-medicine-custom',
				type: "POST",
				data: {'keywords': keywords},
				beforeSend: function(){
			    	// Handle the beforeSend event
			    	// $('.overlay').removeClass("hidden");
				},
				success: function(data){
				
					$('#medicine_suggessions').html('');

					var obj = $.parseJSON(data); // Parse Json array as obj
					if(obj.error == 0){
						
						// If medicine founded
						$('#medicine_suggessions').html('');
						
						// Prepare HTML for show suggessions as list items
						var html = '<ul id="medicine-list" class="list-group" style="z-index: 999; position: absolute; width: 96.5%; overflow-y: auto; min-height:50px; max-height:910px;">';
						var cls = 'selected'; // class selected to be used in the first sugesstion

						$.each( obj.data, function(key, value){
							
							if($("#current-transaction-row").find("#med_item_"+ value.strength_id +"").length <= 0){
							   html += '<li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" onclick="select_medicine_custom('+ value.id +', \'' + value.medicine_name + '\', \'' + value.strength + '\', \'' + value.form + '\')" ><strong style="cursor:pointer;"><a href="javascript:;">' + value.medicine_name + ' ' + value.strength + ' ' + value.form + '</a></strong></li>';
							   cls = ''; // set cls = selected to null
							}// if($("#medicine-list #"+ value.strength_id +"").length)

						}); // $.each( obj.data, function( key, value )

							html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'pmr/add-new-medicine" class="fancybox_view fancybox.ajax"> Add new medicine </a></strong></li>';
						
						html += '</ul>';
						
						// Place html after input field [ search medicine ]
						$(that).after('<div class="medicine_suggessions" id="medicine_suggessions">' + html + '</div>');
						
					} else{
						

						var html = '<ul id="medicine-list" class="list-group" style="z-index: 999; position: absolute; width: 96.5%; overflow-y: auto; min-height:50px; max-height:910px;">';
						html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'pmr/add-new-medicine" class="fancybox_view fancybox.ajax"> Add new medicine </a></strong></li>';
						html += '</ul>';
						
						//$('#medicine_suggessions').html(html);
						$(that).after('<div class="medicine_suggessions" id="medicine_suggessions">' + html + '</div>');
						
					}
						
						
						
						
					// if(obj.error == 0)
						
				} // success: function(data)
				
			}); // $.ajax
			
		} else {
			
			$('#medicine_suggessions').html('');
			$('#medicine_suggessions').hide();
			
		} // if(keywords.length >= 3)

	} else {

		if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true ){ // enter

			$(".selected").trigger("click");

			$(".medicine_suggessions").remove();
			$(".medicine-list").remove();
			$('.search-medicine').val('');

		} // if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true )

	    if (e.keyCode == 38) { // up Arrow key
	        var selected = $(".selected");
	        $(".medicine_suggessions li").removeClass("selected");
	        if (selected.prev().length == 0) {
	            selected.siblings().last().addClass("selected");
	        } else {
	            selected.prev().addClass("selected");
	        }
	    }
	    if (e.keyCode == 40) { // Down Arrow key
	        
	        var selected = $(".selected");
	        $(".medicine_suggessions li").removeClass("selected");
	        
	        if (selected.next().length == 0){
	            selected.siblings().first().addClass("selected");
	        } else {
	            selected.next().addClass("selected");
	        } // if (selected.next().length == 0)

	    } // if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true )

	} // if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40)
	
}); // $('.search-medicine-custom').keyup(function()


// Function to add medicine row as new html element [ for current transaction ]
function select_medicine(qty, medicine_class, strength_id, medicine_id, med_full_name, strength, medicine_form, suggested_dose){
	
	$('.search-medicine').val('');
	
	if($("#current-transaction-row").find("#med_item_"+ strength_id +"").length <= 0){
	
		// Current Transaction row HTML
		var row = '<span id="med_item_'+ strength_id +'"> <input type="hidden" name="transaction[medicine_class][]" value="'+ medicine_class +'" /> <input type="hidden" name="transaction[medicine_strength_id][]" value="'+ strength_id +'" /> <input type="hidden" name="transaction[medicine_full_name][]" value="'+ med_full_name +'" /> <input type="hidden" name="transaction[medicine_id][]" value="'+ medicine_id +'" /> <input type="hidden" name="transaction[strength][]" value="'+ strength +'" /> <input type="hidden" name="transaction[medicine_form][]" value="'+ medicine_form +'" /> <div class="row"><div class="col-sm-12 col-md-12 col-lg-12"><div class="col-sm-4 col-md-4 col-lg-4"><strong> '+ med_full_name +' ' + strength + ' ' + medicine_form + ' </strong></div><div class="col-sm-5 col-md-5 col-lg-5"><input type="text" class="form-control" name="transaction[suggested_dose][]" value="' + suggested_dose + '" /></div><div class="col-sm-2 col-md-2 col-lg-2"><input type="number" min="1" class="form-control" name="transaction[qty][]" value="'+ qty +'" placeholder="Qty" /></div><div class="col-sm-1 col-md-1 col-lg-1"><button class="btn btn-danger pull-right" onClick="trash_transaction_row(this)" > <span class="glyphicon glyphicon-trash"></span> </button></div></div></div><hr /><span>';
		
		// Show preview button
		$('#preview').prev().remove();
		$('#preview').removeClass("hidden");
		
		// Append Current Transaction row
		$('#current-transaction-row').append(row);
		
		// Make suggessions div empty
		$('#medicine_suggessions').html('');
		
		// increament of 1
		var current = $('#medicine-counter').val();
		$('#medicine-counter').val( parseInt(current) + parseInt(1) );

	} // if($("#current-transaction-row").find("#med_item_"+ strength_id +"").length <= 0)
	
} // function select_medicine()

function select_medicine_custom(medicine_id, med_full_name, strength, medicine_form){
	
	suggested_dose = 'Take 1 tablet daily';
	$('.search-medicine-custom').val('');
	
	if($("#current-transaction-row").find("#med_item_"+ medicine_id +"").length <= 0){
	
		// Current Transaction row HTML
		var row = '<span id="med_item_'+ medicine_id +'"><input type="hidden" name="transaction[medicine_full_name][]" value="'+ med_full_name +'" /> <input type="hidden" name="transaction[medicine_id][]" value="'+ medicine_id +'" /> <input type="hidden" name="transaction[strength][]" value="'+ strength +'" /> <input type="hidden" name="transaction[medicine_form][]" value="'+ medicine_form +'" /> <div class="row"><div class="col-sm-12 col-md-12 col-lg-12"><div class="col-sm-4 col-md-4 col-lg-4"><strong> '+ med_full_name +' ' + strength + ' ' + medicine_form + ' </strong></div><div class="col-sm-5 col-md-5 col-lg-5"><input type="text" class="form-control" name="transaction[suggested_dose][]" value="' + suggested_dose + '" /></div><div class="col-sm-2 col-md-2 col-lg-2"><input type="number" min="1" class="form-control" name="transaction[qty][]" value="'+ parseInt(1) +'" placeholder="Qty" /></div><div class="col-sm-1 col-md-1 col-lg-1"><button class="btn btn-danger pull-right" onClick="trash_transaction_row(this)" > <span class="glyphicon glyphicon-trash"></span> </button></div></div></div><hr /><span>';

		// Show preview button
		$('#preview').prev().remove();
		$('#preview').removeClass("hidden");
		
		// Append Current Transaction row
		$('#current-transaction-row').append(row);
		
		// Make suggessions div empty
		$('#medicine_suggessions').html('');
		
		// increament of 1
		var current = $('#medicine-counter').val();
		$('#medicine-counter').val( parseInt(current) + parseInt(1) );

	} // if($("#current-transaction-row").find("#med_item_"+ strength_id +"").length <= 0)
	
} // function select_medicine()


// delete current transaction row
function trash_transaction_row(my){
	
	// Delete Main Parent Div [ Containing the whole row ]
	$(my).parent().parent().parent().parent().remove();
	
	// increament of 1
	var previous_value = $('#medicine-counter').val();
	$('#medicine-counter').val( parseInt(previous_value) - parseInt(1) );
	
	if($('#medicine-counter').val() == 0){
		$('#preview').before('<p class="text-danger text-center">Please select the medicine.</p>');
		$('#preview').addClass("hidden");
	} // if($('#medicine-counter').val() == 0)
	
} // function trash_transaction(my)

$(document).ready(function () {

	$('.preview').on('click', function (e){
		
		var form_id = '';
		// Request from Approve Current (Pending Transaction)
		if( $(this).attr('rel') != undefined ){

			form_id = $(this).attr('rel');

		} // if( $(this).attr('rel') == undefined )

		// alert(form_id);

		var serealized_arr = '';
		if(form_id != '')
			serealized_arr = $("#prescription-preview-form-"+form_id).serializeArray();
		else
			serealized_arr = $("#prescription-preview-form").serializeArray();
		// if(form_id != '')

		e.preventDefault(); // avoids calling action
		$.ajax({
			type: "POST",
			cache: false,
			url: this.href, // preview.php
			data: serealized_arr, // all form fields
			beforeSend: function(){
		    	// Handle the beforeSend event
		    	$('.overlay').removeClass("hidden");
		   	},
			success: function (data){

				$('.overlay').addClass("hidden");

				var serealized_form = '';
				if(form_id != '')
					serealized_form = $("#prescription-preview-form-"+form_id).serialize();
				else
					serealized_form = $("#prescription-preview-form").serialize();
				// if(form_id != '')
				
				$('#prescription-preview-form-searialized-data').val( serealized_form );
				// on success, post (preview) returned data in fancybox
				$.fancybox(data, {
					minWidth  : '50%',
					maxWidth  : '75%'
					
				}); // fancybox
				
			} // success

		}); // ajax
	
	}); // end preview on click function
	
	//$('.medicine-details-popup').on("click", function (e) {
	$('.medicine-details-popup').on('click', function (e){
		
		e.preventDefault(); // avoids calling action
		$.ajax({
			type: "POST",
			cache: false,
			url: this.href, // preview.php
			//data: $("#prescription-preview-form").serializeArray(), // all form fields
			beforeSend: function(){
		    	// Handle the beforeSend event
		    	$('.overlay').removeClass("hidden");
		   	},
			success: function (data) {
			
				$('.overlay').addClass("hidden");

				//$('#prescription-preview-form-searialized-data').val($("#prescription-preview-form").serialize());
				
				// on success, post (preview) returned data in fancybox
				$.fancybox(data, {}); // fancybox
				
			} // success
		}); // ajax
	
	}); // on
	
	$('#input-allergies').keyup(function(){

		var allergies = $(this).val(); // Get Allergies from the input field TEXTAREA
		var patient_id = $(this).attr("rel"); // Get Patient ID from rel attribute of the TEXTAREA

		$.ajax({
			type: "POST",
			url: SURL + 'pmr/update_patient_allergies',
			data: {'allergies': allergies, 'patient_id' : patient_id},
			cache: false,
			beforeSend: function(){
		    	// Handle the beforeSend event
		    	// $('.overlay').removeClass("hidden");
		   	},
			success: function(status)
			{
				// $('.overlay').addClass("hidden");
				
				//if(status == 1)
					//$(this).css({"display":"1px solid green"});
				//else
					//$(this).css({"border":"1px solid red"});

			} // success: function(status)
		}); // $.ajax

	}); // $('#input-allergies').keyup(function()

}); // ready

function save_print(action){
	
	if(action == "print"){
		
		var mode = 'iframe';
		var close = mode == "popup";
		var options = {
			mode: mode,
			popClose: close
		};
		$("#prescription_print_area").printArea(options);
		
	} else if(action == "save-approve"){

		// Save
		// Set action value [ save - print - save_print ]
		$('#action').val(action);
		
		var order_detail_id = $("#order_detail_id").val();

		// submit serealized form
		$('#searialized-prescription-form').append(' <input type="hidden" name="save_approve_request" value="1" /> ');
		$('#searialized-prescription-form').append(' <input type="hidden" name="order_detail_id" value="'+ order_detail_id +'" /> ');
		$('#searialized-prescription-form').submit();

	} else if(action == "save"){
		
		// Save
		// Set action value [ save - print - save_print ]
		$('#action').val(action);
		
		var new_field_prescription_no = $('#prescription_no_hidden').val();
		if(new_field_prescription_no)
			$('#searialized-prescription-form').append(' <input type="hidden" name="prescription_no" value="'+new_field_prescription_no+'" /> ');
		// if(new_field_prescription_no)

		// submit serealized form
		$('#searialized-prescription-form').submit();
		
	} else if(action == "save_print"){
		
		// Print
		var mode = 'iframe';
		var close = mode == "popup";
		var options = {
			mode: mode,
			popClose: close
		};
		$("#prescription_print_area").printArea(options);

		alert('Prescription is successfully saved and ready to be Printed. Please Click okay to Proceed.');
		
		var new_field_prescription_no = $('#prescription_no_hidden').val();
		if(new_field_prescription_no)
			$('#searialized-prescription-form').append(' <input type="hidden" name="prescription_no" value="'+new_field_prescription_no+'" /> ');
		// if(new_field_prescription_no)

		// Save
		// Set action value [ save - print - save_print ]
		$('#action').val(action);
		
		// submit serealized form
		$('#searialized-prescription-form').submit();

		
	} // if(action == "print")
	
	return;
	
} // function save_print(action)

function get_raf_and_medicine(element){

	var category_id = $(element).val();
	if(category_id){

		var html = '';
		
		if( $('#is_vaccine_request').val()  != undefined && $('#vaccine_order_id').val() != undefined && $('#pmr_patient_id').val() != undefined ){
			
			var is_vaccine_request = $('#is_vaccine_request').val();
			var vaccine_order_id = $('#vaccine_order_id').val();
			var pmr_patient_id = $('#pmr_patient_id').val();

		} else {

			var is_vaccine_request = '';
			var vaccine_order_id = '';
			var pmr_patient_id = '';

		} // if( $('#is_vaccine_request').val()  != undefined && $('#vaccine_order_id').val() != undefined && $('#pmr_patient_id').val() != undefined )
		

		// Get RAF and Medicine by categoryID
		$.ajax({
			type: "POST",
			url: SURL + 'organization/pmr/get-category-raf-data',
			data: {'category_id' : category_id, 'is_vaccine_request' : is_vaccine_request, 'vaccine_order_id' : vaccine_order_id, 'pmr_patient_id' : pmr_patient_id},
			cache: false,
			beforeSend: function(){
		    	// Handle the beforeSend event
		    	$('.overlay').removeClass("hidden");
		   	},
			success: function( response )
			{
				$('.overlay').addClass("hidden");

				var obj = JSON.parse( response );

				//console.log(obj);

				if(obj.not_found == ''){
					
					// Enable and Set Section Heading
					$('#raf-row').show();

					// Need to fix the stripcslashes for
					var escapedString = obj.category_details.category_title; // actually contains the characters \ and t
					renderedString = escapedString.replace(/\\(.)/g, function (match, char) {
					        return {'t': '\t', 'r': '\r', 'n': '\n', '0': '\0'}[char] || match;
					});

					$('#raf-row-title').text( renderedString );

					if(is_vaccine_request && obj.destinations_table != null){

						html = '<br />'+obj.destinations_table;
						$('#category-raf-div').html('<div class="col-md-12">'+ html +'</div>');
						
					} else {

						// Verify if request is for travel : Fetch List of all countries
						if(category_id == 33 && obj.destinations){
							
							html = '<br /> <div class="panel panel-info"><div class="panel-heading">';
							
							html += '<strong> Select Journey: </strong> </div> <div class="panel-body">';

							html += '<div class="row" id="country-parent-div" > <div class="col-md-6"> <label>Select Country.</label> <select class="form-control" id="country" required="required" >';
							html += '<option value=""> Choose </option>';

							$.each(obj.destinations, function(key, value){
								
								html += '<option value="'+ value.id + '|' + value.destination +'"> '+ value.destination +' </option>';

							}); // $.each(obj.destinations, function(key, value)

							html += '</select> <br /> <br /> </div> ';

							// Append Select element [ Journey Date ]
							html += '<div class="col-md-6"> <label> Arrival Date. </label> <input type="text" class="form-control" readonly="readonly" id="arrival_date" placeholder="Arrival date" /> <script> $("#arrival_date").datetimepicker({ format: "MM/DD/YYYY", ignoreReadonly: true }); </script> ';

							// Append Add button to add Destination to row
							html += '<br /> <div align="right"> <button type="button" class="btn btn-sm btn-primary" id="add_journey_row_btn" onClick="add_destination_row(this);" > Add to list </button> </div> <br /> ';

							html += '</div> </div>'; // ENd panel-body and panel

							$('#category-raf-div').html('<div class="col-md-12">'+ html +'</div>');

						} // if(category_id == 33 && obj.destinations)

					} // if(is_vaccine_request) 

					//////////////////////////////////////////////////////
					/////////////////////// RAF /////////////////////////

					// Varify if raf found
					if(obj.raf != ''){
						
						// If category selected is Travel Vaccine OR all others
						if(category_id != 33 )
							$('#category-raf-div').html('<br /> <input type="hidden" name="medicine_cat_id" value="'+ category_id +'" /> <input type="hidden" name="pmr_patient_id" value="'+ $('#pmr_patient_id').val() +'" /> <div class="col-md-12">'+ obj.raf +'</div>');
						else 
							$('#category-raf-div').append('<br /> <input type="hidden" name="medicine_cat_id" value="'+ category_id +'" /> <input type="hidden" name="pmr_patient_id" value="'+ $('#pmr_patient_id').val() +'" /> <div class="col-md-12">'+ obj.raf +'</div>');
						// if(category_id == 30)

						

					} // if(obj.raf != '')

					//////////////////////////////////////////////////////
					/////////////////////// Medicine ////////////////////
					if(obj.medicine != null){
				
						$('#walkin-pgd-submit-div').show();

						// Prepare Medicine Dropdown HTML
						
						html = '<div class="panel panel-info"><div class="panel-heading"> <strong> Select Medicine: </strong> </div> <div class="panel-body">';
						
						html += '<label>Please select the medicine.</label>';

						if(category_id != 33) // If not tRaf then must be edRaf
							html += '<select class="form-control" id="walkin-pgd-select-medicine" name="medicine" onChange="walkin_pgd_select_medicine(this);" required="required" >';
						else if(category_id == 33)
							html += '<select class="form-control" id="walkin-pgd-select-medicine" name="medicine" onChange="walkin_pgd_select_medicine(this);" >';
						// if(category_id != 33)

						html += '<option value=""> Select Medicine </option>';

						// Loop to fetch all medicine : To be shown on dropdown
						$.each(obj.medicine, function(key, value){

							html += '<option value="'+ value.medicine_id+'|'+ category_id +'|'+ value.medicine_class +'"> '+ value.medicine_name +' </option>';
						}); // End - $.each Loop

						html += '</select>';

						html += '</div> </div>'; // ENd - panel-body and panel

						$('#category-raf-div').append('<br /><div class="col-md-12"> '+html+' </div>');

					} else {
						$('#walkin-pgd-submit-div').hide();
					} // if(obj.medicine != '')

					//////////////////////////////////////////////////////////
						///////////////// vaccine //////////////////////     
					/////////////////////////////////////////////////////////
					
					if(obj.vaccine != null){
						$('#walkin-pgd-submit-div').show();

						// Prepare Medicine Dropdown HTML
						html = '';
						html = '<div class="panel panel-info"><div class="panel-heading"> <strong> Add new vaccine: </strong> </div> <div class="panel-body">';
						html += '<div class="row" id="vaccine-parent-div"> <div class="col-md-6" > <div class="form-group has-feedback"> <label> Please select the vaccine. </label> ';
						html += '<select class="form-control" id="walkin-pgd-select-vaccine" onChange="walkin_pgd_select_vaccine(this);" required="required" data-required="true" >';
						html += '<option value=""> Select vaccine </option>';

						// Loop to fetch all medicine : To be shown on dropdown
						$.each(obj.vaccine, function(key, value){
							html += '<option value="'+ value.id+'|'+ value.vaccine_name +'"> '+ value.vaccine_name +' </option>';
						}); // End - $.each Loop

						html += '</select> <div class="help-block with-errors"></div> </div> </div> </div>';
						$('#category-raf-div').append('<br /><div class="col-md-12"> '+html+'</div>');

						html = '<div id="vaccine-list-div" ></div>';

						html += '</div> </div>'; // End panel

						$('#category-raf-div').append('<br /><div class="row"> <div class="col-md-12"> '+html+'</div> </div> ');

						var vaccine_type = '';

						if(category_id == 33){

							vaccine_type = 'T';
							
							// If Travel Vaccine
							html = '';
							html += '<div class="panel panel-info"> <div class="panel-heading"> <strong> Malaria: </strong> </div> <div class="panel-body">';

							html += '<div class="row" id="vaccine-parent-div"> <div class="col-md-6" > <label> Choose Medicine. </label>';

							html += '<select class="form-control" id="walkin-pgd-select-medicine" name="medicine" onChange="walkin_pgd_select_medicine(this);" >';
							html += '<option value=""> Select Medicine </option>';

							// Loop to fetch all medicine : To be shown on dropdown
							$.each(obj.anti_malaria_medicine, function(key, value){
								//console.log(value.medicine_id);
								html += '<option value="'+ value.medicine_id+'|'+ category_id +'"> '+ value.medicine_name +' </option>';
							}); // End - $.each Loop

							html += '</select> </div> <div class="col-md-6" id="malaria_raf_div" style="display:none;"> <div class="row" id="malaria-raf-btn-row"> <div class="col-md-6"></div> <div class="col-md-6" id="view-raf-btn-div"> <label> Click to view RAF:  </label> <button type="button" onClick="show_medicine_raf(this);" class="btn btn-sm btn-primary btn-block" id="malaria-raf-btn"> RAF </button> </div> </div> </div> </div> <div class="row" id="malaria-medicine-section"></div> </div>';

							html += '</div> </div>'; // End - panel and panel-body

							$('#category-raf-div').append('<br /><div class="col-md-12"> '+html+'</div> <br /> <div class="row"> <div class="col-md-12" id="travel-vaccine-medicine"></div> </div>');

						} else {
							vaccine_type = 'F';
						} // end if(category_id == 33)

						// walkin_pgd_select_vaccine
						html = ' <br /> <div class="col-md-12" id="malaria_raf" > </div>';
						html +='&nbsp; <div class="col-md-12"> <div class="panel panel-info"><div class="panel-heading"> <strong> Extra advice: </strong> </div> ';

						html += '<div class="panel-body">';

							$.each(obj.vaccine_advices, function(key, value){
								html += '<div class="col-md-4"> <label> <input type="checkbox" name="extra_advice[]" value="' + value.id + '" /> &nbsp; ' + value.advice_title + '   </label></div>';
							}); // $.each(obj.vaccine_advices, function(key, value)
						
						html += '<div class="col-md-12"> <br /><hr /><br /> <label>Notes: </label> <textarea class="form-control" name="notes" placeholder="Enter some notes here" ></textarea> </div> </div> </div> </div> </div> <input type="hidden" readonly="readonly" name="request_type" value="VACCINE" /> <input type="hidden" readonly="readonly" name="vaccine_type" value="'+ vaccine_type +'" />';

						// <div class="col-md-4"> <label> This is a sample label text. </label> <input type="checkbox" /> </div>

			            // Prepare suggested Dose input field
						if($('#extra-advices-div').html() == undefined)
							$('#category-raf-div').append('<div id="extra-advices-div"> '+ html +' </div> ');
						else{
							$('#extra-advices-div').remove();
							$('#category-raf-div').append('<div id="extra-advices-div"> '+ html +' </div> ');
						} // if($('#extra-advices-div').html() == undefined)

					} else if(obj.vaccine == 'null') {
						$('#walkin-pgd-submit-div').hide();
					} // if(obj.medicine != '')

				} else {

					$('#category-raf-div').html('');
					$('#raf-row').hide();
					$('#walkin-pgd-submit-div').hide();
				} // if(obj.not_found == '')
				
			} // success

		}); // $.ajax

	} else {
		$('#raf-row').css({ "display" : "none" });
	} // if(category_id)

} // function get_raf_and_medicine(element)

// Select Pharmacy Or Surgery for Survey
function select_pharmacy_organization(element) {

	var select_value = element.value;

	if(select_value != ''){

		var splitted = select_value.split('|');

		if(splitted[0] != 'P' && splitted[0] != 'O' || splitted[0] == 'P'){

			// Submit the form
			$('#manage_pmr_org_pharm_frm').submit();


		} else { // if(splitted[0] == 'P')

			$.ajax({
				type: "POST",
				url: SURL + 'organization/get-my-org-pharmacies-surgeries',
				data: {'pmr_org_pharmacy': select_value},
				cache: false,
				beforeSend: function(){
			    	// Handle the beforeSend event
			    	$('.overlay').removeClass("hidden");
			   	},
				success: function(data)
				{
					$('.overlay').addClass("hidden");
					
					if(data != ''){
						var obj = JSON.parse(data);
						if(obj.my_pharmacies_surgeries != null){

							//$('#pmr_org_pharmacy').attr('name', "");
							$('#select_org_pharmacy_surgery_div').remove();
							var selected_pharmacy_surgery_id = $('#selected_pharmacy_surgery_id').val();

							var html = '<div class="col-md-12 alert alert-info" id="select_org_pharmacy_surgery_div"> <div class="col-md-8" > <label>It seems like You belong to multiple Pharmacies in an organisation, to work with the PMR, please select any one Pharmacy/ Surgery from the list.</label> </div> <div class="col-md-4"> <select class="form-control pull-right" name="org_pharmacy_surgery" id="org_pharmacy_surgery" onChange="javascript:select_pharmacy_organization(this)" >';
							html += '<option value=""> Select Pharmacy / Surgery </option>';
							$.each( obj.my_pharmacies_surgeries, function(key, value){
								if(selected_pharmacy_surgery_id == value.pharmacy_surgery_id){
									html += '<option selected="selected" value="'+ value.pharmacy_surgery_id +'"> '+ value.pharmacy_surgery_name +' </option>';
								} else {
									//html += '<option value="P|'+ value.pharmacy_surgery_id +'|'+ obj.organization_id +'"> '+ value.pharmacy_surgery_name +' </option>';
									html += '<option value="'+ value.pharmacy_surgery_id +'"> '+ value.pharmacy_surgery_name +' </option>';
								} // if(selected_pharmacy_surgery_id == value.pharmacy_surgery_id)
								
							}); // $.each( obj.data, function( key, value )

							html += '</select> </div> </div>';
							$('#manage_pmr_org_pharm_frm').append(html);

						} else {

							$('#select_org_pharmacy_surgery_div').remove();

						} // if(obj.my_pharmacies_surgeries != '')

					} // if(data != '')
					
				} // end success

			}); // $.ajax

		} // end else => if(splitted[0] == 'P')

		//$('#manage_pmr_org_pharm_frm').submit();
	}
	
}// end select_pharmacy_organization(element)

// Script only need to be executed for pmr/pmr [ Select organization / Pharmacy, Surgery ]
if($('#pmr_org_pharmacy').val() != undefined){
	var splitted = $('#pmr_org_pharmacy').val().split('|');
	if(splitted[0] != 'P')
		$('#pmr_org_pharmacy').trigger('change');
	// if(splitted[0] != 'P')

} // end if($('#pmr_org_pharmacy').val() != undefined)

function complete_transaction(order_detail_id){
		
	if($('#tracking_code').val() == ''){
		
		if($('#traching-code-error').val() == undefined){
			
			$('#tracking_code').parent().before('<div id="traching-code-error" class="alert alert-danger">Enter tracking code to continue ... </div>');
			// $('html, body').animate({ scrollTop: $('#traching-code-error').offset().top }, 100);

		} // if($('#traching-code-error').val() == undefined)

	} else {

		if($('#traching-code-error') != undefined)
			$('#traching-code-error').remove();
		// if($('#traching-code-error') != undefined)

		// $('#tracking_code').val()
		// order_detail_id
		
		$.ajax({
			type: "POST",
			url: SURL + 'organization/pmr/dispense-transaction',
			data: {'tracking_code' : $('#tracking_code').val(), 'order_detail_id' : order_detail_id},
			cache: false,
			beforeSend: function(){
		    	// Handle the beforeSend event
		    	$('.overlay').removeClass("hidden");
		   	},
			success: function(response)
			{
				$('.overlay').addClass("hidden");

				if(response == 1)
					location.reload();
			}
		}); // $.ajax

	} // if($('#tracking_code').val() == '')

} // end function complete_transaction()

// Start - function decline_patient_transaction() : Function to decline the patient
function decline_patient_transaction(order_detail_id){

	if($('#decline_patient_transaction').val() == ''){
		
		if($('#decline-text-error-msg').val() == undefined)
			$('#decline_patient_transaction').parent().after('<br /> <div id="decline-text-error-msg" class="alert alert-danger">Above field is required ... </div>');

	} else {

		if($('#decline-text-error-msg') != undefined)
			$('#decline-text-error-msg').remove();
		// if($('#traching-code-error') != undefined)

		// $('#tracking_code').val()
		// order_detail_id
		
		$.ajax({
			type: "POST",
			url: SURL + 'organization/pmr/decline-transaction',
			data: {'decline_text' : $('#decline_patient_transaction').val(), 'order_detail_id' : order_detail_id},
			cache: false,
			beforeSend: function(){
		    	// Handle the beforeSend event
		    	$('.overlay').removeClass("hidden");
		   	},
			success: function(response)
			{
				$('.overlay').addClass("hidden");

				if(response == 1)
					location.reload();
			}
		}); // $.ajax

	} // if($('#tracking_code').val() == '')

} // end function decline_patient_transaction()

// Start - function download_rx(order_detail_id) : Function to [ Download - Rx ]
function download_rx(order_detail_id){

	$.ajax({
		type: "POST",
		url: SURL + 'organization/pmr/download-rx',
		data: {'order_detail_id' : order_detail_id},
		cache: false,
		beforeSend: function(){
	    	// Handle the beforeSend event
	    	$('.overlay').removeClass("hidden");
	   	},
		success: function(response)
		{
			$('.overlay').addClass("hidden");
			//if(response == 1)
				//location.reload();
		}
	}); // $.ajax

} // End - function download_rx(order_detail_id)

// Start - function walkin_pgd_select_vaccine(element)
function walkin_pgd_select_vaccine(element){

	$(element).css({'border':"1px solid #ccc"});
	$("#err-msg-"+$(element).attr('id')).remove();

	var vaccine_id = $(element).val();	
	$.ajax({
		type: "POST",
		url: SURL + 'organization/pmr/get-vaccine-brands',
		data: {'cat_id' : vaccine_id},
		cache: false,
		beforeSend: function(){
	    	// Handle the beforeSend event
	    	$('.overlay').removeClass("hidden");
	   	},
		success: function(response)
		{
			$('.overlay').addClass("hidden");

			var obj = JSON.parse(response);
			if(obj.brands != ''){
			
				var html = '<label>Select Brand.</label>';
				html += '<select id="brand" class="form-control">';

					if(obj.brands){
						
						$.each(obj.brands, function(key, value){
							html +='<option value="'+ value.id +'|'+ value.brand_name +'"> '+ value.brand_name +' </option>';
						}); // $.each(obj.brands, function(key, value)
					
					} // if(obj.brands)

				html += '</select>';

				// Prepare Strength Dropdown
				if($('#brands-div').html() == undefined){
					
					$('#vaccine-parent-div').append('<div id="brands-div" class="col-md-6"> '+html+'</div>');

				} else {

					$('#brands-div').remove();
					$('#vaccine-parent-div').append('<div id="brands-div" class="col-md-6"> '+html+'</div>');

				} // if($('#brands-div').html() == undefined)

			} else {

				$('#vaccine-inputs-div').remove();
				$('#brands-div').remove();

				return;

			} // if(obj.brands != null)

			// Input fields
			html = '<div class="row"> <div class="col-md-12">';
			html += '<div class="col-md-3" > <br /> <label> Batch NO: </label>';
			html +='<input type="text" class="form-control" id="batch_no" placeholder="Batch number" required="required" /> </div>';

			html += '<div class="col-md-3" > <br /> <label> Expiry date: </label>';
			html +='<div id="expiry_date_div"> <input type="text" class="form-control date2" onClick="date2(this);" id="expiry_date" placeholder="Expiry date" required="required" /> <script> $("#expiry_date").datetimepicker({ format: "MM/DD/YYYY", ignoreReadonly: true }); </script> </div> </div> ';

			html += '<div class="col-md-3" > <br /> <label> Select Deltoid: </label>';
			html +=' <select id="deltoid" class="form-control" required="required" > <option value="Left"> Left </option> <option value="Right"> Right </option> </select> </div>';

			html += '<div class="col-md-3" > <br /> <label> Price: </label>';
			html +='<input type="text" class="form-control" id="price" placeholder="Price" required="required" /> </div> </div> </div>';

            // Prepare suggested Dose input field
			if($('#vaccine-inputs-div').html() == undefined)
				$('#vaccine-parent-div').append('<div id="vaccine-inputs-div"> '+html+' <div class="row"> <div class="row col-md-10"></div> <div class="col-md-2"> <p> &nbsp; </p> <button type="button" class="btn btn-sm btn-primary btn-block" id="add_vaccine_row_btn" onClick="add_vaccine_row(this);" > Add </button> </div> </div> </div> ');
			else{
				$('#vaccine-inputs-div').remove();
				$('#vaccine-parent-div').append('<div id="vaccine-inputs-div"> '+html+' <div class="row"> <div class="row col-md-10"></div> <div class="col-md-2"> <p> &nbsp; </p> <button type="button" class="btn btn-sm btn-primary btn-block" id="add_vaccine_row_btn" onClick="add_vaccine_row(this);" > Add </button> </div> </div> </div> ');
			} // if($('#vaccine-inputs-div').html() == undefined)

		} // success

	}); // $.ajax

} //  End - function walkin_pgd_select_vaccine(element)

// Start - function add_vaccine_row(el)
function add_vaccine_row(el){

	if( $('#el').val() != '' ){
		$('#walkin-pgd-select-vaccine').removeAttr('required');
	} // end if( $('#el').val() != '' )

	// Get value of Vaccine and Split [ id|name ]
	var vaccine = $('#walkin-pgd-select-vaccine').val();
	vaccine = vaccine.split('|');

	// Get value of Vaccine Brand and Split [ id|name ]
	var brand = $('#brand').val();
	brand = brand.split('|');

	// Get values of input fields
	var batch_no = $('#batch_no').val();
	var expiry_date = $('#expiry_date').val();
	var deltoid = $('#deltoid').val();
	var price = $('#price').val();
	
	if(brand && batch_no && expiry_date && deltoid && price){

		// Add new temp row to form
		if($('#vaccine-items-list-tbody').html() == undefined)
			$('#vaccine-list-div').before('&nbsp; <div class="col-md-12"> <div class="panel panel-info"><div class="panel-heading"> <strong> Vaccine List: </strong> </div> <div class="panel-body"> <table class="table table-hover table-bordered"> <thead> <tr> <th> Vaccine</th> <th> Brand </th> <th> Batch # </th> <th> Expiry </th> <th> Deltoid </th> <th> Price </th> <th> <input type="hidden" id="is-new-vaccine-added" value="0" /> </th> </tr> </thead> <tbody id="vaccine-items-list-tbody"> </tbody> </table> </div> </div> </div>');
		// if($('#vaccine-items-list-tbody').html() == undefined)

		var html_table = '<tr> <td> '+vaccine[1]+' <input type="hidden" readonly="readonly" name="vaccine[]" value="'+vaccine[0]+'" /> </td> <td> '+brand[1]+' <input type="hidden" readonly="readonly" name="brand[]" value="'+brand[0]+'" /> </td> <td> '+batch_no+' <input type="hidden" readonly="readonly" name="batch_no[]" value="'+batch_no+'" /> </td> <td> '+expiry_date+' <input type="hidden" readonly="readonly" name="expiry_date[]" value="'+expiry_date+'" /> </td> <td> '+deltoid+' <input type="hidden" readonly="readonly" name="deltoid[]" value="'+deltoid+'" /> </td> <td> '+price+' <input type="hidden" readonly="readonly" name="price[]" value="'+price+'" /> </td> <td> <button type="button" class="btn btn-xs btn-danger btn-block" onClick="remove_vaccine_item(this);" > x </button> </td> </tr>';
		$('#vaccine-items-list-tbody').append(html_table);

		$('#walkin-pgd-select-vaccine').val("");
		$('#walkin-pgd-select-vaccine').trigger("change");

		// Verify if atleast one vaccine is added only if the selected raf ID is [ 30 OR 33 ]
		var check_new_added_vaccine = $('[id^="is-new-vaccine-added"]');
		var old_count = $(check_new_added_vaccine).val();
		var new_count = parseInt(old_count) + parseInt(1);
		$(check_new_added_vaccine).val( new_count );
		
	} else {

		if($('#vaccine-error-msg').text() == '')
			$(el).parent().parent().parent().append('<br /> <br /> <div class="col-md-12"> <div class="alert alert-danger" id="vaccine-error-msg"> Fill all the fields to continue. </div> </div>');
		// if($('#vaccine-error-msg').text() == null)

	} // if(brand && batch_no && expiry_date && deltoid && price)

	//console.log(vaccine[1]+' - '+brand[1]+' - '+batch_no+' - '+expiry_date+' - '+deltoid+' - '+price);

} // End - function add_vaccine_row(el)

// Start - function walkin_pgd_select_medicine(element) : Function to trigger select medicine event on Wlakin PGD
function walkin_pgd_select_medicine( element ){

	$(element).css({'border':"1px solid #ccc"});
	$("#err-msg-"+$(element).attr('id')).remove();

	var medicine_category_id = $(element).val();

	if(medicine_category_id == ''){

		// Hide View RAF button
		$('#view-raf-btn-div').hide();

		if($('#suggested-dose-div').html() != undefined)
			$('#suggested-dose-div').remove();
		// if($('#suggested-dose-div').html() == undefined)
		
		if($('#strength-div').html() != undefined)
			$('#strength-div').remove();
		// if($('#strength-div').html() == undefined)
		
		if($('#qty-div').html() != undefined)
			$('#qty-div').remove();
		// if($('#qty-div').html() == undefined)
		
		if($('#medicine_price-div').html() != undefined)
			$('#medicine_price-div').remove();
		// if($('#medicine_price-div').html() == undefined)

		return;

	} else {
		$('#view-raf-btn-div').show();
	} // if(medicine_category_id == '')

	var splitted = medicine_category_id.split('|');
	var medicine_id = splitted[0];
	var category_id = splitted[1];

	$.ajax({
		type: "POST",
		url: SURL + 'organization/pmr/get-medicine-details',
		data: {'medicine_id' : medicine_id},
		cache: false,
		beforeSend: function(){
	    	// Handle the beforeSend event
	    	$('.overlay').removeClass("hidden");
	   	},
		success: function(response)
		{
			$('.overlay').addClass("hidden");
			
			$('#malaria_raf_div').show('');

			$('#malaria_raf').html('');
			$('#malaria-raf-btn').removeClass("btn-info");
			$('#malaria-raf-btn').addClass("btn-primary");

			var obj = JSON.parse(response);
			var med_id = obj.medicine_id;

			// console.log(obj.medicine.medicine_arr[med_id]);

			// console.log(obj.medicine.medicine_arr[med_id].medicine_info.medicine_price[0].total_medicine_price);

			if(obj.success == 1){

				var html = '';
				if(obj.medicine.medicine_arr[med_id])
					html = ' <input type="hidden" name="medicine_id" value="'+ medicine_id +'" /> <input type="hidden" name="medicine_class" value="'+ obj.medicine.medicine_arr[med_id].medicine_info.medicine_class +'" /> <br /> <label>Strength.</label>';
				// obj.medicine.medicine_arr[med_id]

				html += '<select id="select-strength" name="strength_id" class="form-control">';

					if(obj.medicine.medicine_arr[med_id]){
						
						$.each(obj.medicine.medicine_arr[med_id].strength_arr, function(key, strength){
							html +='<option value="'+ key +'"> '+ strength +' </option>';
						}); // $.each(obj.medicine.medicine_arr[med_id].strength_arr, function(key, strength))
					
					} // obj.medicine.medicine_arr[med_id].strength_arr

				html += '</select>';

				// Prepare Strength Dropdown
				if($('#strength-div').html() == undefined){
					if(category_id == 33){
						
						// Medicine - tRaf - Travel vaccine

						var new_created_element = $('[id^="malaria-medicine-section"]');
						$(new_created_element).append('<div id="strength-div"class="col-md-3"> '+html+'</div>');
						
						//$('#travel-vaccine-medicine').append('<div id="strength-div" class="col-md-4"> '+html+'</div>');

					} else {
						// Medicine - edRaf - Select Medicine
						$('#category-raf-div').append('<div id="strength-div" class="col-md-4"> '+html+'</div>');
					}
				} else{
					$('#strength-div').remove();
					
					if(category_id == 33) { // If vaccine
						
						var new_created_element = $('[id^="malaria-medicine-section"]');
						$(new_created_element).append('<div id="strength-div" class="col-md-3"> '+html+'</div>');

						//$('#travel-vaccine-medicine').append('<div id="strength-div" class="col-md-4"> '+html+'</div>');

					} else { // If medicine
						$('#category-raf-div').append('<div id="strength-div" class="col-md-4"> '+html+'</div>');
					} // if($('#travel-vaccine-medicine').text() != null)

				} // if($('#strength-div').html() == undefined)

				// Prepare Qty
				html = '';
				var html = '<br /> <label>Qty.</label>';
				html +='<select id="select-quantity" name="qty" class="form-control" >';

						if(obj.medicine.medicine_arr[med_id] != undefined && obj.medicine.medicine_arr[med_id].quantity_arr){
						
							$.each(obj.medicine.medicine_arr[med_id].quantity_arr, function(key, quantity){
								html +='<option value="'+ quantity.quantity_id +'|'+ quantity.quantity + '"> '+ quantity.quantity_txt + ' </option>';
							}); // $.each(obj.medicine.medicine_arr[med_id].strength_arr, function(key, strength))
						
						} // if(obj.medicine.medicine_arr[med_id].quantity_arr)
                
                html += '</select>';

                // Prepare Qty Dropdown
				if( $('#qty-div').html() == undefined ){
					
					if(category_id == 33){
						
						// Medicine - tRaf - Travel vaccine
						
						var new_created_element = $('[id^="malaria-medicine-section"]');
						$(new_created_element).append('<div id="qty-div" class="row col-md-3"> '+html+'</div>');

						// $('#travel-vaccine-medicine').append('<div id="qty-div" class="col-md-4"> '+html+'</div>');

					} else {
						// Medicine - edRaf - Select Medicine
						$('#category-raf-div').append('<div id="qty-div" class="col-md-4"> '+html+'</div>');
					} // if(category_id == 33)

				} else {

					$('#qty-div').remove();

					if(category_id == 33){
						// Medicine - tRaf - Travel vaccine

						var new_created_element = $('[id^="malaria-medicine-section"]');
						$(new_created_element).append('<div id="qty-div" class="col-md-3"> '+html+'</div>');

						//$('#travel-vaccine-medicine').append('<div id="qty-div" class="col-md-4"> '+html+'</div>');

					} else {
						// Medicine - edRaf - Select Medicine
						$('#category-raf-div').append('<div id="qty-div" class="col-md-4"> '+html+'</div>');
					} // if(category_id == 33)
				}

				// Prepare Merge with medicine dropdown (if the selected medicine is merged with another medicine_id)
				html = '';

				if(obj.medicine.medicine_arr[med_id] != undefined && obj.medicine.medicine_arr[med_id].medicine_info.merge_with_medicine_arr){

					html += '<br /> <label> Generic or Branded </label>';

					html += '<select id="select-generic-branded" name="is_branded_id" class="form-control" onChange="walkin_pgd_select_medicine(this);">';
					html +=		'<option value="'+obj.medicine_id+'"> '+obj.medicine.medicine_arr[med_id].medicine_info.medicine_name+' - '+ obj.medicine.medicine_arr[med_id].medicine_info.is_branded+' </option>';
					html +=		'<option value="'+obj.medicine.medicine_arr[med_id].medicine_info.merge_with_medicine_arr.id+'"> ' + obj.medicine.medicine_arr[med_id].medicine_info.merge_with_medicine_arr.medicine_name +' - '+ obj.medicine.medicine_arr[med_id].medicine_info.merge_with_medicine_arr.is_branded + '</option>';
					html += '</select>';

				} // if(obj.medicine.medicine_arr[med_id].medicine_info.merge_with_medicine_arr)
				
				// Prepare Merge Dropdown
				if($('#merge-div').html() == undefined)
					$('#category-raf-div').append('<div id="merge-div" class="col-md-4"> '+html+'</div>');
				else{
					$('#merge-div').remove();
					$('#category-raf-div').append('<div id="merge-div" class="col-md-4"> '+html+'</div>');
				} // if($('#merge-div').html() == undefined)

				if(obj.medicine.medicine_arr[med_id] != undefined && obj.medicine.medicine_arr[med_id].medicine_info.suggested_dose){

					// Prepare Suggested Dose
					html = '';
					html = '<br /> <label>Suggested Dose.</label>';
					html +='<input type="text" class="form-control" name="suggested_dose" value="'+ obj.medicine.medicine_arr[med_id].medicine_info.suggested_dose +'" />';

	                // Prepare suggested Dose input field
					if($('#suggested-dose-div').html() == undefined){

						if(category_id == 33){
							
							// Medicine - tRaf - Travel Vaccine

							var new_created_element = $('[id^="malaria-medicine-section"]');
							$(new_created_element).append('<div id="suggested-dose-div" class="col-md-3"> '+html+'</div>');

							// $('#travel-vaccine-medicine').append('<div id="suggested-dose-div" class="col-md-4"> '+html+'</div>');

						} else {
							// Medicine - edRaf - Select Medicine
							$('#category-raf-div').append('<div id="suggested-dose-div" class="col-md-6"> '+html+'</div>');
						} // if(category_id == 33)
						
					} else {

						$('#suggested-dose-div').remove();
						
						if(category_id == 33){
							
							// Medicine - tRaf - Travel Vaccine

							var new_created_element = $('[id^="malaria-medicine-section"]');
							$(new_created_element).append('<div id="suggested-dose-div" class="col-md-3"> '+html+'</div>');

							//$('#travel-vaccine-medicine').append('<div id="suggested-dose-div" class="col-md-4"> '+html+'</div>');

						} else {
							// Medicine - edRaf - Select Medicine
							$('#category-raf-div').append('<div id="suggested-dose-div" class="col-md-6"> '+html+'</div>');
						} // if(category_id == 33)

					} // if($('#suggested-dose-div').html() == undefined)

				} // if(obj.medicine.medicine_arr[med_id].medicine_info.suggested_dose)

				if(obj.medicine.medicine_arr[med_id] != undefined && obj.medicine.medicine_arr[med_id].medicine_info.medicine_price && obj.medicine.medicine_arr[med_id].medicine_info.medicine_price[0].total_medicine_price && category_id != '30' ){

					// Prepare Medicine Price
					html = '';
					html = '<br /> <label>Price.</label>';

					// return event.charCode >= 48 && event.charCode <= 57

					html +='<input class="form-control filterme" name="medicine_price" value="'+ obj.medicine.medicine_arr[med_id].medicine_info.medicine_price[0].total_medicine_price +'" required="required" />';

	                // Prepare Medicine Price input field
					if($('#medicine_price-div').html() == undefined){

						if(category_id == 33){
							
							// Medicine - tRaf - Travel vaccine

							var new_created_element = $('[id^="malaria-medicine-section"]');
							$(new_created_element).append('<div id="medicine_price-div" class="col-md-3"> '+html+'</div>');

							// $('#travel-vaccine-medicine').append('<div id="medicine_price-div" class="col-md-4"> '+html+'</div>');

						} else {
							// Medicine - edRaf - Select Medicine
							$('#category-raf-div').append('<div id="medicine_price-div" class="col-md-6"> '+html+'</div> ');
						} // if(category_id == 33)
						
					} else {

						$('#medicine_price-div').remove();
						
						if(category_id == 33){
							
							// Medicine - tRaf - Travel vaccine
							
							var new_created_element = $('[id^="malaria-medicine-section"]');
							$(new_created_element).append('<div id="medicine_price-div" class="col-md-3">'+html+'</div>');

							//$('#travel-vaccine-medicine').append('<div id="medicine_price-div" class="col-md-4"> '+html+'</div>');

						} else {
							// Medicine - edRaf - Select Medicine
							$('#category-raf-div').append('<div id="medicine_price-div" class="col-md-6"> '+html+'</div> ');
						} // if(category_id == 33)

					} // if($('#medicine_price-div').html() == undefined)

				} // if(obj.medicine.medicine_arr[med_id] != undefined && obj.medicine.medicine_arr[med_id].medicine_info.medicine_price[0].total_medicine_price)

				// Prepare Suggested Dose
				html = '';
				if(category_id != 33){
					
					html = '<br /> <label> Note: </label>';
					html +='<textarea class="form-control" name="notes" placeholder="Enter some notes here." ></textarea>';
				}//end if(category_id != 33)
				
                // Prepare suggested Dose input field
				if($('#notes-div').html() == undefined){

					if(category_id == 33){
						// Medicine - tRaf - Travel vaccine
						$('#travel-vaccine-medicine').append('<div id="notes-div" class="col-md-12"> '+html+'</div>');
					} else {
						// Medicine - edRaf - Select Medicine
						$('#category-raf-div').append('<div id="notes-div" class="col-md-12"> '+html+'</div>');
					} // if(category_id == 33)

				} else {

					$('#notes-div').remove();

					if(category_id == 33){
						// Medicine - tRaf - Travel vaccine
						$('#travel-vaccine-medicine').append('<div id="notes-div" class="col-md-12"> '+html+'</div>');
					} else {
						// Medicine - edRaf - Select Medicine
						$('#category-raf-div').append('<div id="notes-div" class="col-md-12"> '+html+'</div>');
					} // if(category_id == 33)

				} // if($('#notes-div').html() == undefined)

			} // if(obj.success == 1)
		
		} // Success

	}); // $.ajax

} // End - function walkin_pgd_select_medicine(element)

// Start - function remove_vaccine_item(element) : Function to remove selected vaccine row
function remove_vaccine_item(element){

	$(element).parent().parent().remove();

	// Verify if atleast one vaccine is added only if the selected raf ID is [ 30 OR 33 ]
	var check_new_added_vaccine = $('[id^="is-new-vaccine-added"]');
	var old_count = $(check_new_added_vaccine).val();
	var new_count = parseInt(old_count) - parseInt(1);
	$(check_new_added_vaccine).val( new_count );

} // End - function remove_vaccine_item(element)

// Start - function remove_journey_item(element) : Function to remove selected vaccine row
function remove_journey_item(element){

	$(element).parent().parent().remove();

	// Verify if atleast one vaccine is added only if the selected raf ID is [ 30 OR 33 ]
	var check_new_added_journey = $('[id^="is-new-journey-added"]');
	var old_count = $(check_new_added_journey).val();
	var new_count = parseInt(old_count) - parseInt(1);
	$(check_new_added_journey).val( new_count );

} // End - function remove_journey_item(element)

// Patient Register if select February
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

// Patient Register if select February

// Start - function show_medicine_raf(el) : Function to show RAF Document for the Anti Malaria medicine in travel vaccine
function show_medicine_raf(el){

	$(el).removeClass("btn-primary");
	$(el).addClass("btn-info");

	var medicine = $('#walkin-pgd-select-medicine').val();
	var splited = medicine.split('|');

	var medicine_id = splited[0];

	$.ajax({
		
		type: "POST",
		url: SURL+'organization/pmr/get-medicine-raf',
		data: {'medicine_id': medicine_id},
		cache: false,
		beforeSend: function(){
	    	// Handle the beforeSend event
	    	$('.overlay').removeClass("hidden");
	   	},
		success: function(data)
		{
			$('.overlay').addClass("hidden");

			var obj = JSON.parse(data);

			// RAF Document
			if(obj.raf != '')
				$('#malaria_raf').html(obj.raf);
			// if(obj.raf != '')

		} // success

	}); // $.ajax

} // End - function show_medicine_raf(el)

// Start - function arrival_date(el) : Function to get instance od Bootstrap date picker
function date2(el){
	$(el).datetimepicker({ format: "MM/DD/YYYY", ignoreReadonly: true });
} // End - function date2(el)

// Start - function add_destination_row(_this)
function add_destination_row(_this){

	$('#country').removeAttr('required');

	var country_val = $('#country').val();
	var arrival_date_val = $('#arrival_date').val();

	var country = country_val.split('|');
	var arrival_date = arrival_date_val.split('|');
	
	if(country_val && arrival_date_val){

		$('#travel-error-msg').remove();

		// Add new temp row to form
		if($('#journey-list-tbody').html() == undefined)
			$(_this).parent().parent().parent().after('&nbsp; <div class="panel panel-info"><div class="panel-heading"> <strong> Your Journey: </strong> </div> <div class="panel-body"> <table class="table table-hover table-bordered"> <thead> <tr> <th> Country</th> <th> Arrival Date </th> <th> <input type="hidden" id="is-new-journey-added" value="0" /> </th> </tr> </thead> <tbody id="journey-list-tbody"> </tbody> </table> </div> </div>');
		// if($('#journey-list-tbody').html() == undefined)

		var html_table = '<tr> <td> '+country[1]+' <input type="hidden" readonly="readonly" name="travel_country[]" value="'+country[0]+'" /> </td> <td> '+arrival_date+' <input type="hidden" readonly="readonly" name="arrival_date[]" value="'+arrival_date+'" /> </td> <td> <button type="button" class="btn btn-xxs btn-danger" onClick="remove_journey_item(this);" > x </button> </td> </tr>';
		$('#journey-list-tbody').append(html_table);

		$('#arrival_date').val("");

		//$('#country').val("");
		//$('#country').trigger("change");

		// Verify if atleast one vaccine is added only if the selected raf ID is [ 30 OR 33 ]
		var check_new_added_journey = $('[id^="is-new-journey-added"]');
		var old_count = $(check_new_added_journey).val();
		var new_count = parseInt(old_count) + parseInt(1);
		$(check_new_added_journey).val( new_count );

		$('#add-journey-row-submit-error').remove();

	} else {

		if($('#travel-error-msg').text() == '')
			$(_this).parent().parent().parent().after('<div class="alert alert-danger" id="travel-error-msg"> Fill all the fields to continue. </div>');
		// if($('#travel-error-msg').text() == null)

	} // if(country && arrival_date)

} // End - function add_destination_row(_this)

// Auto select select raf if not undefined
if($('#select-raf-hidden').val() != undefined)
	$('#select-raf-hidden').trigger('change');
// if($('#select-raf-hidden').val() != undefined)

// Start - function print_consent_form()
function print_consent_form(){

	var mode = 'iframe';
	var close = mode == "popup";
	var options = {
		mode: mode,
		popClose: close
	};
	$("#consent_form").printArea(options);

} // End - function print_consent_form()

$('.filterme').keypress(function(eve){
						
	if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
    	eve.preventDefault();
  	}
     
	// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
 	$('.filterme').keyup(function(eve) {
  		
  		if($(this).val().indexOf('.') == 0){
  			$(this).val($(this).val().substring(1));
  		}
  		
 	});

}); // $('.filterme').keypress(function(eve)

// Print table function : get table thead & tbody by table ID //
function print_pgd_prescription(){

	var mode = 'iframe';
	var close = mode == "popup";
	var options = {
		mode: mode,
		popClose: close
	};
	$('#pgd_prescriptiption_table').printArea(options);

	return;

	/*var table_contents = html;
	var printWindow = window.open('', '', '');
	//printWindow.document.write('<html><head><title> Print Reports Testing </title>');
	//printWindow.document.write('</head><body>');
	printWindow.document.write(table_contents);
	//printWindow.document.write('</body></html>');
	printWindow.document.close();
	printWindow.print();
	return;*/

  } // function print_table(table_id)