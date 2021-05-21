/*
---------------------------------------------------------------------------------------
 Custon scripts - custom javascript functions for Organization Front-End 
---------------------------------------------------------------------------------------
*/

// expand_me(rand): Toggle Pharmacy data
function expand_me(rand){
	
	var div = $("#expand_pharmacy_" + rand);
	var html = div.html();
	
	if( html.match ( 'Staff' ) != 'Staff'){
		div.html('You cannot add or view staff. First read the Governance to proceed!');
	}
	
	div.toggle('medium');
	
	/*
	div.animate({
		height: 'toggle'
	});
	*/
}

// toggle_add_staff(rand): Toggle Add staff invite field
function toggle_add_staff(rand){
	
	$("#add_staff_" + rand).animate({
		height: 'toggle'
	});
}

// toggle_staff(rand): Toggle staff data
function toggle_staff(rand){
	
	var div = $("#view_staff_" + rand);
	var html = div.html();
	
	if( html.match ( 'Delete' ) != 'Delete'){
		div.html('<strong class="text-danger">Staff not found.</strong>');
	}
		
	div.animate({
		height: 'toggle'
	});
}

// toggle_add_pharmacy_surgery_btn(): Toggle Add Pharmacy / Surgery Registration form
function toggle_add_pharmacy_surgery_btn(){
	$("#add_pharmacy_surgery_form").animate({
		height: 'toggle'
	});
}

// toggle_sop(rand): Toggle ER SOPs
function toggle_sop(rand){
	$("#view_er_sop_" + rand).animate({
		height: 'toggle'
	});
}

// $(".read-and-sign-btn").click(function(): On click read and sign button
$(".read-and-sign-btn").click(function() {
	
	// fetch read and sign page contents from the db (ajax) and show into the div to take signatures (Agree and Sign)
	var html = '<h4>Malairia Standard Operating Procedure</h4><br /><p>Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum, Lorem ispum,</p>';
	var div = $('#read_and_sign_div');
	
	// On Click toggle Div
	$(div).animate({
		height: 'toggle'
	});
	
	// Append Read and Sign button to div
	$(div).html(''); // Empty div data
	$(div).append(html); // Append html from db
	$(div).append('<button class="btn btn-sm btn-success pull-right">Agree and Sign</button>'); // Append Read and Sign button
	
});

// $(".expand-btn").click(function(): Change Pharmacy Expand/Collapse text
$(".expand-btn").click(function() {
	if($(this).text() == ' - Collapse '){
		$(this).text(' + Expand ');
	} else {
		$(this).text(' - Collapse ');
	}
});

$(".pharmacy-surgery-type").change(function() {
	
	slt_val = $(this).val();
	if(slt_val == 'P'){ // if Pharmacy selected
		
		$('#pharmacy_surgery_name_label').text('Pharmacy Name');
		$('#pharmacy_surgery_address_label').text('Pharmacy Address');
		$('#gphc_no_label').text('GPhC No (Optional)');

		$('#premises_label').text('Premises Phone Number');
		
		$('#ods_code_div').removeClass('hide');
				
		
	} else { // if Surgery selected
	
		if(slt_val == 'W'){

			$('#pharmacy_surgery_name_label').text('WDA Name');
			$('#pharmacy_surgery_address_label').text('WDA Address');
			$('#premises_label').text('Phone Number');
			$('#gphc_no_label').text('MHRA No (Optional)');
			
			$('#ods_code_div').addClass('hide');
			$('#f_code').val('');
			
			
		}else if(slt_val == 'S'){
			$('#pharmacy_surgery_name_label').text('Surgery Name');
			$('#pharmacy_surgery_address_label').text('Surgery Address');
			$('#gphc_no_label').text('GPhC No (Optional)');
			$('#premises_label').text('Premises Phone Number');
			
			$('#ods_code_div').removeClass('hide');
		}
	}
});


//Governance Products Scripts
//Function toggle_me() will take container which need to be toggle and a arrow ID so the arrows can be changed on toggle
function toggle_me_with_arrow(container,arrow){

	$('#'+container).toggle('medium');

	if($('#'+arrow).attr('class') == 'fa fa-angle-down')
		$('#'+arrow).attr('class','fa fa-angle-up');

	else
		$('#'+arrow).attr('class','fa fa-angle-down');
	
}//end toggle_me(container,arrow)

//Organization Governance Products Checkbox
$("#check_all_pharmacies_gov").change(function() {
	$("input[name='pharm_gov_chk[]']").prop('checked', $(this).prop("checked"));
	evaluate_governance_total();
	
});
//Organization Governance Products Checkbox
$(".pharm_gov").change(function() {
	evaluate_governance_total();
});

//Function evaluate_governance_total() Used in Organization Prodiuct section for Governance Purchase for Pharmacies
function evaluate_governance_total(){

	no_of_phramacies_selected = $('.pharm_gov:checked').size();
	price_per_governance = $('#governance_price').val();
	
	//Sub Total
	subtotal = (price_per_governance * no_of_phramacies_selected);
	$('.subtotal_governance').html(subtotal.toFixed(2));
	
	//VAT
	vat_percentage = $('#vat_percentage').val();
	vat_percentage = (vat_percentage/100) * subtotal;
	$('.vat_governance').html(vat_percentage.toFixed(2));
	
	//Grand Total
	grand_total = vat_percentage + subtotal;
	$('.grandtotal_governance').html(grand_total.toFixed(2));
	
}//end evaluate_governance_total()


//Organization Governance Products Checkbox
$("#check_all_pharmacies_survey").change(function() {
	$("input[name='pharm_survey_chk[]']").prop('checked', $(this).prop("checked"));
	evaluate_survey_total();
	
});
//Organization Governance Products Checkbox
$(".pharm_survey").change(function() {
	evaluate_survey_total();
});

//Function evaluate_survey_total() Used in Organization Prodiuct section for Survey Purchase for Pharmacies
function evaluate_survey_total(){
	
	no_of_phramacies_selected = $('.pharm_survey:checked').size();
	price_per_survey = $('#survey_price').val();

	//Sub Total
	subtotal = (price_per_survey * no_of_phramacies_selected);
	$('.subtotal_survey').html(subtotal.toFixed(2));
	
	//VAT
	vat_percentage = $('#vat_percentage').val();
	vat_percentage = (vat_percentage/100) * subtotal;
	$('.vat_survey').html(vat_percentage.toFixed(2));
	
	//Grand Total
	grand_total = vat_percentage + subtotal;
	$('.grandtotal_survey').html(grand_total.toFixed(2));
	
}//end evaluate_survey_total()

//This function used on Edit SOP Section for SI and Owner
$("#sop_category_id").change(function(){
	
	if($('#sop_category_id').val() == 'addnew')
		$('#new_category_container').removeClass('hidden');
	else
		$('#new_category_container').addClass('hidden');
		$('#sop_category_name_text').val('');
	
});		

$('#submit_cc_details_from').validator();