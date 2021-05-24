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
			success: function (data) {

				$('.overlay').addClass("hidden");

				var serealized_form = '';
				if(form_id != '')
					serealized_form = $("#prescription-preview-form-"+form_id).serialize();
				else
					serealized_form = $("#prescription-preview-form").serialize();
				// if(form_id != '')
				
				$('#prescription-preview-form-searialized-data').val( serealized_form );
				// on success, post (preview) returned data in fancybox
				$.fancybox(data, {}); // fancybox
				
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
	
	
	// update allergies in patient table
$('#input-allergies').keyup(function(){

		var allergies = $(this).val(); // Get Allergies from the input field TEXTAREA
		var patient_id = $(this).attr("rel"); // Get Patient ID from rel attribute of the TEXTAREA

		$.ajax({
			type: "POST",
			url: SURL + 'patient/update_patient_allergies',
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
	
	
	
	// print data
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
		var root_order_id = $("#root_order_id").val();
		
		// submit serealized form
		$('#searialized-prescription-form').append(' <input type="hidden" name="save_approve_request" value="1" /> ');
		$('#searialized-prescription-form').append(' <input type="hidden" name="order_detail_id" value="'+ order_detail_id +'" /> ');
		$('#searialized-prescription-form').append(' <input type="hidden" name="root_order_id" value="'+ root_order_id +'" /> ');
		$('#searialized-prescription-form').submit();

	} else if(action == "save"){
		
		// Save
		// Set action value [ save - print - save_print ]
		$('#action').val(action);
		
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
		
		// Save
		// Set action value [ save - print - save_print ]
		$('#action').val(action);
		
		// submit serealized form
		$('#searialized-prescription-form').submit();

		
	} // if(action == "print")
	
	return;
	
} // function save_print(action)


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
			url: SURL + 'patient/decline-transaction',
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

// Statistics date search for prescription
$( ".search_date" ).click(function() {
	
  $('#statistic_frm').submit();
	
}); // end Statistics date search for prescription	


/*// Statistics date search for pharmacy statistics
$( ".pharamcy_search_statistics" ).click(function() {

$('#ajax_responce_id').html('');

var pharmacy_surgery_id =  $('#pharmacy_surgery_id').val();

	if(pharmacy_surgery_id==""){
		$('.pharmacy_surgery_error').removeClass("hidden");
	} else {
		$('.pharmacy_surgery_error').addClass("hidden");
	}

if(pharmacy_surgery_id!=""){
	var path = SURL + 'patient/list-all-pharmacy-statistics-ajax';
	$.ajax({
			url: path,
			type: "POST",
			data: $("#pharmacy_statistic_frm").serialize(),
			beforeSend: function(){
				//$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
				
				//alert(data)
				 $('#ajax_responce_id').show();
				 $('#ajax_responce_id').html(data);
			}
		});
   }// end if(pharmacy_surgery_id!=""){
}); // end Statistics date search for prescription	
*/
$( ".remove_dates" ).click(function() {
	
	var csv_to_date = $('#to_date').val('');
	var csv_form_date = $('#from_date').val('');
	var csv_todate  =  $('#csv_to_date').val('');
	var csv_fromdate =  $('#csv_from_date').val('');
	
});

$( ".remove_last" ).click(function() {
	
	var csv_date_search = $('input[name=date_search]:checked').val();	
	$('input[name=date_search]').attr('checked', false); // Unchecks it
	var csv_datesearch =  $('#csv_date_search').val('');

	
});

// Auto search for Patient
$(".search_patient").keyup(function(e){

	// Accepts all the keys except [ upkey and downkey ]
	if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40){

		var search_patient = $(this).val();
		var path = SURL + 'patient/search-patient';
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
						
					} //if(data == 'not_found')
					
				} // success
			
			}); // $.ajax

	   } // if(search_patient!='' && search_patient.length >= min_length)

	} else {

		if( e.keyCode == 13 ){ // enter

			$(".selected").trigger("click");

			/*if( $('#add-new-patient').attr("href") != undefined ){

				if( $('#add-new-patient-li').hasClass("selected") )
					window.location = $('#add-new-patient').attr("href");

			} // if( $('#add-new-patient').attr("href") != undefined )*/

		} // if( e.keyCode == 13 && $('.result_patient li').hasClass("selected") == true )

	    if (e.keyCode == 38) { // up Arrow key
	    	
	    	// $("#email-list > li").removeClass("selected");

	        var selected = $(".selected");
	        $("#result_patient li").removeClass("selected");
	        if (selected.prev().length == 0) {
	            selected.siblings().last().addClass("selected");
	        } else {
	            selected.prev().addClass("selected");
	        }
	    }
	    if (e.keyCode == 40) { // Down Arrow key
	        
	        // $("#email-list > li").addClass("selected");
	        // $("#email-list").siblings().first().addClass("selected");

	        var selected = $(".selected");
	        $("#result_patient li").removeClass("selected");
	        
	        if (selected.next().length == 0){
	            selected.siblings().first().addClass("selected");
	        } else {
	            selected.next().addClass("selected");
	        } // if (selected.next().length == 0)

	    } // if( e.keyCode == 13 && $('#result_patient li').hasClass("selected") == true )

	} // if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40)
});


// display input box email 
function select_patient(patient_id,patient_name,email_address) {
	
	var csv_to_date = $('#search_patient').val(patient_name);
	var csv_to_date = $('#search_patient_email').val(email_address);
	$("#result_patient").hide();

	
} // end function select_patient(val)


// Auto search for Pharamacy
$(".search_pharmacy").keyup(function(e){

	// Accepts all the keys except [ upkey and downkey ]
	if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40){

		var search_pharmacy = $(this).val();
		var path = SURL + 'patient/search-pharmacy';
		var min_length = 3;
		
		if(search_pharmacy == ''){
			$("#result_pharmacy").html('');
		}
		
		if(search_pharmacy!='' && search_pharmacy.length >= min_length) {
			$.ajax({
				type: "POST",
				url: path,
				data: {'search_pharmacy': search_pharmacy},
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
						
						$("#result_pharmacy").show();
						
						// $("#result_patient").html('<li class="list-group-item text-primary" id="add-new-patient-li" style="padding-top:5px;"> <a id="add-new-patient" href="'+ SURL +'organization/pmr/add-edit-patient" style="color:#555555;">Add New Patient</a></strong> </li>');
						$("#result_pharmacy").html(data);
					
					} else {
						
						$("#result_pharmacy").show();
						$("#result_pharmacy").html(data);
						
					} //if(data == 'not_found')
					
				} // success
			
			}); // $.ajax

	   } // if(search_patient!='' && search_patient.length >= min_length)

	} else {

		if( e.keyCode == 13 ){ // enter

			$(".selected").trigger("click");

			/*if( $('#add-new-patient').attr("href") != undefined ){

				if( $('#add-new-patient-li').hasClass("selected") )
					window.location = $('#add-new-patient').attr("href");

			} // if( $('#add-new-patient').attr("href") != undefined )*/

		} // if( e.keyCode == 13 && $('.result_patient li').hasClass("selected") == true )

	    if (e.keyCode == 38) { // up Arrow key
	    	
	    	// $("#email-list > li").removeClass("selected");

	        var selected = $(".selected");
	        $("#result_pharmacy li").removeClass("selected");
	        if (selected.prev().length == 0) {
	            selected.siblings().last().addClass("selected");
	        } else {
	            selected.prev().addClass("selected");
	        }
	    }
	    if (e.keyCode == 40) { // Down Arrow key
	        
	        // $("#email-list > li").addClass("selected");
	        // $("#email-list").siblings().first().addClass("selected");

	        var selected = $(".selected");
	        $("#result_pharmacy li").removeClass("selected");
	        
	        if (selected.next().length == 0){
	            selected.siblings().first().addClass("selected");
	        } else {
	            selected.next().addClass("selected");
	        } // if (selected.next().length == 0)

	    } // if( e.keyCode == 13 && $('#result_patient li').hasClass("selected") == true )

	} // if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40)
});

// display input box email 
function select_pharmacy(pharmacy_id,pharmacy_name,post_code) {
	
	var search_pharmacy = $('#search_pharmacy').val(pharmacy_name);
	var search_pharmacy = $('#pharmacy_surgery_id').val(pharmacy_id);
	var csv_to_date = $('#search_pharmacy_post_code').val(post_code);
	$("#result_pharmacy").hide();

	
} // end function select_patient(val)

// Statistics date search for prescription
$( ".pharamcy_search_statistics" ).click(function() {
	
  $('#pharmacy_statistic_frm').submit();
	
}); // end Statistics date search for prescription	

function filter_stats(){
	$('#statistic_frm').submit();
}