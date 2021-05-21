$(function () {    //shorthand for document ready

	//Send SI Invitation Process
	$('#invitation_response').on('click', '#si_inv_btn', function () {

		var frm_id = $(this).parents('form:first')[0].id;
		$("#error_si_inv_container").addClass("hidden");
		
		$.ajax({
		
			type: "POST",
			url: SURL + "organization/invite-superintendent/",
			data: $("#"+frm_id).serialize(),
			/*dataType: "json",*/
			beforeSend : function(result){
				$("#overlay").removeClass("hidden");
			},  
			success: function(result){

				$("#overlay").addClass("hidden");

				var obj = JSON.parse(result);
				
				if(obj.error_status == 1){
					
					$("#error_si_inv_container").removeClass("hidden");
					$("#error_si_inv_container").html(obj.err_message);
					
				}else{
					
					if(obj.governance_hr.hr_text){
						
						hr_text = obj.governance_hr.hr_text; 
						//hr_text = hr_text.replace('[CONTRACT_HISTORY]','');
						//hr_text = hr_text.replace('[USER_SIGNATURE]','');

						$('#governance_hr_textarea').val(hr_text);
					}
					else
						$('#governance_hr_textarea').val('No hr text available ...');
					//

					// Initialize FancyBox
					$(".governance_hr_fancybox").fancybox({
						minWidth : '50%',
						maxWidth  : '75%',
						afterLoad: function () {
							setTimeout(function(){
								//tinymce.init({selector:'#governance_hr_textarea'});
								tinymce.init({
								selector: "#governance_hr_textarea",
								relative_urls : false,
								remove_script_host : false,
								convert_urls : true,								
								menubar: 'edit insert table tools',
								height: '300px',
								theme: "modern",
								plugins: [
									"advlist autolink lists link image charmap print preview hr anchor pagebreak",
									"searchreplace wordcount visualblocks visualchars code fullscreen",
									"insertdatetime media nonbreaking save table contextmenu directionality",
									"emoticons template paste textcolor colorpicker textpattern imagetools"
								],
								toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

								});
							}, 800);
						},
						beforeClose: function (){
							tinyMCE.remove();
						}
					});

					// generate elect self as staff btn
					$('#elect-self-staff-btn-span').html('<div class="well well-sm text-right" > <label> Check the box to the right, if the employee does not need a new contract.  <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /></label> <button type="button" onClick="push_invitation_form_btn(this);" class="btn btn-sm btn-success" > Save and Send </button> </div>');

					$("#send_invite_fancy_trigger").trigger('click');

					if(obj.invitation_method == 'D')
						$('#invitation_sent_to_arr').val(obj.invitation_sent_to_arr);
					else if(obj.invitation_method == 'E')
						$('#invitation_sent_to_arr').val(obj.invitation_sent_to_arr.email_address);

					$('#invitation_method').val(obj.invitation_method);
					$('#organization_id').val(obj.organization_id);
					$('#pharmacy_surgery_id').val(obj.pharmacy_surgery_id);
					$('#invitation_for').val(obj.invitation_for);
					
				}//end if(obj.error_status == 1)
			}
		}); 
	  	
	});

	
	/* ------------------------------------------------------------------- */
	/* ------ Start Invitation scripts for Managers / Staff Members ------ */
	/* ------------------------------------------------------------------- */
	
	$('.invitation-response-btn').click(function(){

		// invitation_id|status [ 123|1 OR 123|0 ] : 1 = Accept && 0 = Reject
		var invitation_response = $( this ).attr("rel");

		// Split invitation ID and Status
		var split_invitation_response = invitation_response.split('|');

		// Invitation ID
		var invitation_id = split_invitation_response[0];

		// Response status 1 OR 0
		var response_status = split_invitation_response[1];

		// Make last response [ error OR action buttons] html on the fancybox
		$('#btn-span').html('');

		// Get Invitation data and show on fancy box Contract HR [ by invitation ID ]
		$.ajax({
		
			type: "POST",
			url: SURL+"dashboard/get-invitation-data",
			data: {'invitation_id' : invitation_id },
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function(result){

				$("#overlay").addClass("hidden");

				var obj = JSON.parse(result);

				if(obj.error_status == 1){ // On failure
					
				} else { // On Success

					if(obj.row.hr_contract){
						//var escapedString = '\\t',   renderedString = (new Function('return "' + obj.row.hr_contract + '"'))();
						$('#contract').html( obj.row.hr_contract);
					}
					else
						$('#contract').html('<p> No hr text available ... </p>');
					// if(obj.row.hr_contract)

					// Initialize FancyBox
					$(".invitation_response_governance_hr_fancybox").fancybox({ minWidth  : '50%', maxWidth  : '75%'});

					$("#invite_response_fancy_trigger").trigger('click');

					// Check if user's signatures found					
					if(obj.row.no_contract == '0'){

						if(obj.user_signatures == ""){

							var signatures_error = '<div class="alert alert-danger">To sign this contract, you first must go to your <a href="'+ SURL +'dashboard/settings#sign_pane">Settings</a> and enter your signature.</div>';

							// generate elect self as staff btn
							if( $('#signatures-error-div').html() == undefined )
								$('#btn-span').html(signatures_error);

						} else {

							var accept_btn = '<a href="'+ SURL +'dashboard/invitation-approval/'+ invitation_id +'/1"> <button type="button" class="btn btn-sm btn-success" > Accept </button> </a>';
							var reject_btn = '<a href="'+ SURL +'dashboard/invitation-approval/'+ invitation_id +'/0"> <button type="button" class="btn btn-sm btn-danger" > Reject </button> </a>';
							var request_for_change_btn = '<a href="javascript:;" onClick="$(\'#request_change_container\').toggle();$(\'#request_change_notes\').focus();" id="come_here"> <button type="button" class="btn btn-sm btn-warning" > Request a change </button> </a>';

							// generate elect self as staff btn
							$('#btn-span').html('<div class="pull-right">'+accept_btn + reject_btn + request_for_change_btn + '</div>');

						} // if(obj.user_signatures == '')

					} else if(obj.row.no_contract == '1'){

						var request_for_change_btn = '<a href="javascript:;" onClick="$(\'#request_change_container\').toggle();$(\'#request_change_notes\').focus();$.fancybox.update()" id="come_here"> <button type="button" class="btn btn-sm btn-danger" > Request a change </button> </a>';
						
						var accept_btn = '<a href="'+ SURL +'dashboard/invitation-approval/'+ invitation_id +'/1"> <button type="button" class="btn btn-sm btn-warning" > Bypass </button> </a>';
						//var reject_btn = '<a href="'+ SURL +'dashboard/invitation-approval/'+ invitation_id +'/0"> <button type="button" class="btn btn-sm btn-danger" > Reject </button> </a>';
						var reject_btn = '';

						$('#view-contract-popup-title').html('<h4>Your employer has decided to not send you a contract.</h4>');
						$('#no_contract_notes').html('<strong>If you think this is an error please click "Request Change". To proceed otherwise, click the "Bypass" button.</strong>');
						// generate elect self as staff btn
						$('#btn-span').html('<div class="pull-right">'+request_for_change_btn + accept_btn + reject_btn + '</div>');
					}
					
					$('#contract_invitation_id').val(invitation_id);						
					$("#send_invite_fancy_trigger").trigger('click');
					
				} //end if(obj.error_status == 1)
			}

		}); // $.ajax

	}); // end - function

	$('.renew_contract_response_btn').click(function(){

		// invitation_id|status [ 123|1 OR 123|0 ] : 1 = Accept && 0 = Reject
		var temp_contract_id = $( this ).attr("rel");

		// Make last response [ error OR action buttons] html on the fancybox
		$('#renew_contract_btn_span').html('');

		// Get Invitation data and show on fancy box Contract HR [ by invitation ID ]
		$.ajax({
		
			type: "POST",
			url: SURL+"organization/get-renew-contract-data",
			data: {'temp_contract_id' : temp_contract_id },
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function(result){

				$("#overlay").addClass("hidden");

				var obj = JSON.parse(result);

				if(obj.error_status == 1){ // On failure
					$('#renew_contract').html( obj.err_message);
				} else { // On Success

					if(obj.temp_contract_data.hr_contract){
						//var escapedString = '\\t',   renderedString = (new Function('return "' + obj.row.hr_contract + '"'))();
						//alert(obj.temp_contract_data.hr_contract);
						$('#renew_contract').html( obj.temp_contract_data.hr_contract);
					}
					else
						$('#renew_contract').html('<p> No hr text available ... </p>');
					// if(obj.row.hr_contract)

					// Initialize FancyBox
					$(".renew_contract_response_fancybox").fancybox({ minWidth  : '50%', maxWidth  : '75%'});

					$("#renew_contract_response_fancy_trigger").trigger('click');

					// Check if user's signatures found					
					if(obj.temp_contract_data.no_contract == '0'){

						if(obj.user_signatures == ""){

							var signatures_error = '<div class="alert alert-danger">To sign this contract, you first must go to your <a href="'+ SURL +'dashboard/settings#sign_pane">Settings</a> and enter your signature.</div>';

							if( $('#signatures-error-div').html() == undefined )
								$('#renew_contract_btn_span').html(signatures_error);

						} else {

							var accept_dtn = '<a href="'+ SURL +'organization/renewal-contract-approval/'+ temp_contract_id +'/1"> <button type="button" class="btn btn-sm btn-success" > Accept </button> </a>';
							var reject_btn = '<a href="'+ SURL +'organization/renewal-contract-approval/'+ temp_contract_id +'/0"> <button type="button" class="btn btn-sm btn-danger" > Reject </button> </a>';
							var request_for_change_btn = '<a href="javascript:;" onClick="$(\'#renew_request_change_container\').toggle();$(\'#renew_request_change_notes\').focus();" id="come_here"> <button type="button" class="btn btn-sm btn-warning" > Request a change </button> </a>';

							// generate elect self as staff btn
							$('#renew_contract_btn_span').html('<div class="pull-right">'+accept_dtn + reject_btn + request_for_change_btn + '</div>');

						} // if(obj.user_signatures == '')

					} else if(obj.temp_contract_data.no_contract == '1'){

						var accept_btn = '<a href="'+ SURL +'organization/renewal-contract-approval/'+ temp_contract_id +'/1"> <button type="button" class="btn btn-sm btn-warning" > Bypass </button> </a>';
						//var reject_btn = '<a href="'+ SURL +'organization/renewal-contract-approval/'+ temp_contract_id +'/0"> <button type="button" class="btn btn-sm btn-danger" > Reject </button> </a>';
						
						reject_btn = '';

						var request_for_change_btn = '<a href="javascript:;" onClick="$(\'#renew_request_change_container\').toggle();$(\'#renew_request_change_notes\').focus();$.fancybox.update()" id="move_here"> <button type="button" class="btn btn-sm btn-danger" > Request a change </button> </a>';
						
						$('#renew_contract_no_contract_notes').html('<strong>If you think this is an error please click "Request Change". To proceed otherwise, click the "Bypass" button.</strong>');

						// generate elect self as staff btn
						$('#renew_contract_btn_span').html('<div class="pull-right">'+request_for_change_btn + accept_btn + reject_btn  + '</div>');
					}
					
					$('#renew_temp_contract_id').val(temp_contract_id);						
					$("#renew_contract_response_fancy_trigger").trigger('click');
					
				} //end if(obj.error_status == 1)
			}

		}); // $.ajax

	}); // end - function renew_contract_response_btn

	$('.contract_view_mode').click(function(){

		var hr_contract_id = $( this ).attr("data-target");
		
		// Get Invitation data and show on fancy box Contract HR [ by invitation ID ]
		$.ajax({
		
			type: "POST",
			url: SURL+"organization/view-user-hr-contract-data",
			data: {'contract_id' : hr_contract_id },
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function(result){

				$("#overlay").addClass("hidden");

				var obj = JSON.parse(result);

				if(obj.error_status == 1){ // On failure
					
					$('#view_user_contract_container').html( obj.err_message);
					
				} else { // On Success

					//var escapedString = '\\t',   renderedString = (new Function('return "' + obj.row.hr_contract + '"'))();
					$('#view_user_contract_container').html( obj.contract_data.hr_contract);
					// if(obj.row.hr_contract)

					// Initialize FancyBox
					$(".view_contract_fancybox").fancybox({ minWidth  : '50%', maxWidth  : '75%', minHeight: '300px' });
					$("#view_user_contract_fancy_trigger").trigger('click');
					
				} //end if(obj.error_status == 1)
				
				$('#contract_title').html("View "+obj.contract_data.user_full_name+" Contract");
			}

		}); // $.ajax

	}); // end - functioncontract_view_mode

	// Elect Self as manager view contract for manager
	$(".elect-self-view-contract").click( function() {

		// Get pharmacy_surgery_id
		var pharmacy_surgery_id = $( this ).val();
		var inv_for = $( this ).attr("name");
		var pharmacy_surgery_type = $( this ).attr("rel");
		var is_owner = $( this ).attr("data-target");
		
		if(inv_for == "ST"){
		
			// In case of staff invite
			var invitation_for = 'S';
			var invi
			// Invitation request for staff
			
		} else if(inv_for == "M"){ // In case of manager invite
			
			invitation_for = 'M';

		} else if(inv_for == "SI"){
			invitation_for = 'SI';
		}

		$.ajax({
		
			type: "POST",
			url: SURL+"organization/elect-self-view-contract/",
			data: {'invitation_for' : invitation_for, 'pharmacy_surgery_type' : pharmacy_surgery_type, 'pharmacy_surgery_id' : pharmacy_surgery_id },
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function(result){

				$("#overlay").addClass("hidden");
				var obj = JSON.parse(result);
				
				if(inv_for == "SI")
					user_role = 'Superintendent';
				else if(inv_for == "M")
					user_role = 'Manager';
				else if(inv_for == "ST")
					user_role = obj.user_role;
					
				if(is_owner == 1){
					
					$('#elect_self_textarea_container').addClass('hidden');
					$('#elect_self_title').html('Elect Self');
					$('#contract_notes_elect_self').html('Are you sure you want to elect yourself as '+user_role+' in '+obj.organization_name+'?');
					$('#contract_notes_others').addClass('hidden');
					
					// Initialize FancyBox
					$(".governance_hr_fancybox").fancybox({
						minWidth : '50%',
						maxWidth  : '75%',
						afterLoad: function () {},
						beforeClose: function (){}
					});

					if(inv_for == "ST")
						$('#elect-self-staff-btn-span').html('<div class="text-right" > <button class="btn btn-sm btn-success elect-self-staff" onClick="elect_self_staff(this, '+ pharmacy_surgery_id +');" type="button" > Elect Self </button> <button class="btn btn-sm btn-danger" type="button" data-dismiss="modal" onClick="$.fancybox.close();"> Cancel </button></div>');
					else if(inv_for == "M")
						$('#elect-self-staff-btn-span').html('<div class="text-right" > <button class="btn btn-sm btn-success manager-elect-self-btn" onClick="manager_elect_self_btn(this, '+ pharmacy_surgery_id +');" type="button" data-dismiss="modal" > Elect Self </button> <button class="btn btn-sm btn-danger" type="button" data-dismiss="modal" onClick="$.fancybox.close();"> Cancel </button></div>');
					else if(inv_for == "SI"){
						
						$('#elect-self-staff-btn-span').html('<div class="text-right" ><button class="btn btn-sm btn-success" type="button" data-dismiss="modal" onClick="elect_self_si_submit();"> Elect Self </button> <button class="btn btn-sm btn-danger" type="button" data-dismiss="modal" onClick="$.fancybox.close();"> Cancel </button> </div>');
					}//end if(inv_for == "ST")
					
					$("#send_invite_fancy_trigger").trigger('click');
					
				}else{
					
					$('#elect_self_title').html('Send Contract');
					$('#elect_self_textarea_container').removeClass('hidden');
					$('#contract_notes_elect_self').html('');
					$('#contract_notes_others').removeClass('hidden');
											
					if(obj.error_msg){
						
						if(invitation_for == 'SI'){
							
							$('#error_si_inv_container').text(obj.error_msg);
							$('#error_si_inv_container').removeClass('hidden');
						}
						
					}else{
						if(obj.governance_hr != ''){ 
							// If Governance founded
							
							if(obj.governance_hr.hr_text){

								hr_text = obj.governance_hr.hr_text; 
								//hr_text = hr_text.replace('[CONTRACT_HISTORY]','');
								//hr_text = hr_text.replace('[USER_SIGNATURE]','');
		
								$('#governance_hr_textarea').val(hr_text);
							}
							else
								$('#governance_hr_textarea').val('No hr text available ...');
							// f(obj.governance_hr.hr_text)
		
							// Initialize FancyBox
							$(".governance_hr_fancybox").fancybox({
								minWidth : '50%',
								maxWidth  : '75%',
								afterLoad: function () {
									setTimeout(function(){
										tinymce.init({
										selector: "#governance_hr_textarea",
										menubar: 'edit insert table tools',
										relative_urls : false,
										remove_script_host : false,
										convert_urls : true,								
										height: '300px',
										theme: "modern",
										plugins: [
											"advlist autolink lists link image charmap print preview hr anchor pagebreak",
											"searchreplace wordcount visualblocks visualchars code fullscreen",
											"insertdatetime media nonbreaking save table contextmenu directionality",
											"emoticons template paste textcolor colorpicker textpattern imagetools"
										],
										toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		
										});
									},800);
								},
								beforeClose: function (){
									tinyMCE.remove();
								}
							});
		
							// generate elect self as staff btn
							if(inv_for == "ST")
								$('#elect-self-staff-btn-span').html('<div class="well well-sm text-right" > <label> Check the box to the right, if the employee does not need a new contract. <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /> </label><button class="btn btn-sm btn-warning elect-self-staff" onClick="elect_self_staff(this, '+ pharmacy_surgery_id +');" type="button" > Send Contract </button> </div>');
							else if(inv_for == "M")
								$('#elect-self-staff-btn-span').html('<div class="well well-sm text-right" > <label> Check the box to the right, if the employee does not need a new contract. <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /></label> <button class="btn btn-sm btn-warning manager-elect-self-btn" onClick="manager_elect_self_btn(this, '+ pharmacy_surgery_id +');" type="button" data-dismiss="modal" > Send Contract </button> </div>');
							else if(inv_for == "SI"){
								
								$('#elect-self-staff-btn-span').html('<div class="well well-sm text-right" > <label>  Check the box to the right, if the employee does not need a new contract.  <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /> </label><button class="btn btn-sm btn-warning" type="button" data-dismiss="modal" onClick="elect_self_si_submit();"> Send Contract </button> </div>');
							}
							// if(inv_for == "ST")
	
							$("#send_invite_fancy_trigger").trigger('click');
						}//end if(obj.governance_hr != '')
						
					}//end if(result.error_msg != '' )
					
				}//end if(is_owner)
			}
		});
		
	}); // $(".elect-self-view-contract").click( function():

	// Resend New Contract to existind staff 
	$(".contract_resend_mode").click( function() {
		
		var contract_id = $( this ).attr("data-target");
		
		$.ajax({
		
			type: "POST",
			url: SURL+"organization/resend-hr-contract/",
			data: {'contract_id' : contract_id},
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function(result){

				$("#overlay").addClass("hidden");

				var obj = JSON.parse(result);
				//alert(result);
				
				if(obj.error_status == 1){ // On failure
					
					$('#view_user_contract_container').html( obj.err_message);
				}else{
					if(obj.contract_temp_data!= ''){
					
						tmp_str_hr = obj.contract_temp_data.hr_contract;
						
						//Replace Issue Date with recent one
						var start_pos = tmp_str_hr.indexOf('<id="issue_date">') + 20;
						var end_pos = tmp_str_hr.indexOf('</p>',start_pos);
						var text_to_get = tmp_str_hr.substring(start_pos,end_pos);
						replaced_txt = tmp_str_hr.replace(text_to_get,'<strong>Issued: '+date('d/m/Y G:i')+'</strong>');
						
						$('#governance_resend_contract_textarea').val(tmp_str_hr);
						$('#resend_contract_to_user_id').val(obj.contract_temp_data.user_id);
						$('#temp_contract_id').val(obj.contract_temp_data.id);
						$('#resend_contract_id').val('');
						$('#contract_resend_status').html('<div class="alert alert-danger"><p>User have NOT YET ACCEPTED this Contract</p></div>');

						if(obj.contract_temp_data.request_change_notes != ''){
							$('#renew_changing_notes_container').html("<div class='alert alert-warning'><p><strong>Notes: </strong><br />"+obj.contract_temp_data.request_change_notes+"</p></div>");
						}else
							$('#renew_changing_notes_container').html("<div class='alert alert-warning'><p><strong>Notes: </strong><br />No Notes Available</p></div>");
						
						
					}else{
						 if(obj.contract_data.hr_contract != ''){

							str_hr = obj.contract_data.hr_contract;
							
							//Replace Token
							var start_pos = str_hr.indexOf('id="signed_container" style="width: 300px; float: right;" align="right">') + 73;
							var end_pos = str_hr.indexOf('<!--END-->',start_pos);
							var text_to_get = str_hr.substring(start_pos,end_pos)
							//alert(text_to_get);
							replaced_txt = str_hr.replace(text_to_get,'<div style="width:283px; padding:0; margin:0; height:116px; background-image:url([SURL]assets/images/bb.png); background images: background-image-resize:6;">    <div style=" margin:0; backgrund-color:#000; padding:4px 0px 3px 36px; text-align:left">[SIGNED_DATE_TIME] </div>     <div style="margin:0px 0px 0px 20px; padding:0; text-align:left">[USER_SIGNATURE]  </div>      <div style="padding:0px 0px 0px 36px; margin:5px 0px 0px 0px;text-align:left ">[CONTRACT_NO]</div> </div>');

							//Replace Issue Date with recent one
							var start_pos = replaced_txt.indexOf('<id="issue_date">') + 20;
							var end_pos = replaced_txt.indexOf('</p>',start_pos);
							var text_to_get = replaced_txt.substring(start_pos,end_pos);
							replaced_txt = replaced_txt.replace(text_to_get,'<strong>Issued: '+date('d/m/Y G:i')+'</strong>');
							replaced_txt = replaced_txt.replace('[CONTRACT_NO]',generate_random(16));
							
							$('#governance_resend_contract_textarea').val(replaced_txt);
							$('#resend_contract_to_user_id').val(obj.contract_data.user_id);
							$('#temp_contract_id').val('');
							$('#resend_contract_id').val(obj.contract_data.id);
							$('#contract_resend_status').html('<div class="alert alert-success"><p>User have ACCEPTED this Contract</p></div>');
						 }//end if(obj.contract_data.hr_contract != '')
					}	
					
					// Initialize FancyBox
					$(".governance_resend_contract_fancybox").fancybox({
						minWidth : '50%',
						maxWidth  : '75%',
						afterLoad: function () {
							setTimeout(function(){
								tinymce.init({
								selector: "#governance_resend_contract_textarea",
								menubar: 'edit insert table tools',
								relative_urls : false,
								remove_script_host : false,
								convert_urls : true,								
								
								height: '300px',
								theme: "modern",
								plugins: [
									"advlist autolink lists link image charmap print preview hr anchor pagebreak",
									"searchreplace wordcount visualblocks visualchars code fullscreen",
									"insertdatetime media nonbreaking save table contextmenu directionality",
									"emoticons template paste textcolor colorpicker textpattern imagetools"
								],
								toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	
								});
							},800);
						},
						beforeClose: function (){
							tinyMCE.remove();
						}
					});
					
					$('#resend_contract_btn_span').html('<div class="well well-sm text-right" > <label> Check the box to the right, if the employee does not need a new contract.  <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /></label> <button type="submit" class="btn btn-sm btn-success" > Resend Contract</button> </div>');
					
				}//end if(obj.error_status == 1){

				$("#resend_contract_fancy_trigger").trigger('click');
			}
		});
		
	}); // $(".contract_resend_mode").click( function():

	// Send New changes of Invitation Contract
	$(".invitation_contract_changes").click( function() {
		var invitation_id = $( this ).attr("data-target");
		
		$.ajax({
		
			type: "POST",
			url: SURL+"organization/update-invitation-contract/",
			data: {'invitation_id' : invitation_id},
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function(result){
				
				$("#overlay").addClass("hidden");

				var obj = JSON.parse(result);
				
				if(obj.invitation_data.hr_contract)
					$('#governance_edit_inv_contract_textarea').val(obj.invitation_data.hr_contract);
				else
					$('#governance_edit_inv_contract_textarea').val('No hr text available ...');

					if(obj.invitation_data.request_change_notes != ''){
						
						//var escapedStringNotes = '\\t',   renderedStringNotes = (new Function('return "' + obj.invitation_data.request_change_notes + '"'))();
						
						$('#changing_notes_container').html("<p><strong>Notes: </strong><br />"+obj.invitation_data.request_change_notes+"</p>");

					}else
						$('#changing_notes_container').html("<p><strong>Notes: </strong><br />No Notes Available</p>");

				// Initialize FancyBox
				$(".governance_edit_inv_contract_fancybox").fancybox({
					minWidth : '50%',
					maxWidth  : '75%',
					afterLoad: function () {
						setTimeout(function(){
							tinymce.init({
							selector: "#governance_edit_inv_contract_textarea",
							menubar: 'edit insert table tools',
							relative_urls : false,
							remove_script_host : false,
							convert_urls : true,								
							
							height: '300px',
							theme: "modern",
							plugins: [
								"advlist autolink lists link image charmap print preview hr anchor pagebreak",
								"searchreplace wordcount visualblocks visualchars code fullscreen",
								"insertdatetime media nonbreaking save table contextmenu directionality",
								"emoticons template paste textcolor colorpicker textpattern imagetools"
							],
							toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

							});
						},800);
					},
					beforeClose: function (){
						tinyMCE.remove();
					}
				});
				$('#edit_contract_invitation_id').val(invitation_id);
				$('#edit_inv_contract_btn_span').html('<div class="well well-sm text-right" > <label> Check the box to the right, if the employee does not need a new contract.  <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /></label> <button type="submit" class="btn btn-sm btn-success" > Update and Send</button> </div>');				

				$("#send_contract_change_fancy_trigger").trigger('click');
			}
		});
		
	}); // $(".invitation_contract_changes").click( function():

	// Send Manager / Staff Invitation Process
	$(".invite-manager-staff-btn").click( function() {

		$('#elect_self_title').html('Send Contract');
		$('#elect_self_textarea_container').removeClass('hidden');
		$('#contract_notes_elect_self').html('');
		$('#contract_notes_others').removeClass('hidden');
		
		// Get pharmacy_surgery_id
		var pharmacy_surgery_id = $( this ).val();
		var inv_for = $( this ).attr("name");
		var pharmacy_surgery_type = $( this ).attr("rel");

		if(inv_for == "ST"){
		
			// In case of staff invite
			var invitation_for = $('#select_invitation_type_' + pharmacy_surgery_id ).val();
			// Invitation request for staff
			var email_address = $(this).parent().prev().prev().get( 0 ).value;
			
		} else if(inv_for == "M"){ // In case of manager invite
			
			invitation_for = 'M';
			var email_address = $('#manager_email_address_' + pharmacy_surgery_id ).val();
			
		} // if(inv_for == "ST")
		$("#error_message_span_" + pharmacy_surgery_id).addClass("hidden");
		
		$.ajax({
		
			type: "POST",
			url: SURL+"organization/invite-manager-staff/",
			data: {'email_address' : email_address, 'pharmacy_surgery_id' : pharmacy_surgery_id, 'invitation_for' : invitation_for, 'pharmacy_surgery_type' : pharmacy_surgery_type },
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function(result){
				
				$("#overlay").addClass("hidden");

				var obj = JSON.parse(result);
				
				if(obj.error_status == 1){ // On failure
					
					if(invitation_for == 'M'){
					
						$("#error_m_inv_container_" + pharmacy_surgery_id ).parents(".manager_error").removeClass("hidden");
						$("#error_m_inv_container_" + pharmacy_surgery_id ).removeClass("hidden");
						$("#error_m_inv_container_" + pharmacy_surgery_id ).html(obj.err_message);
						
					} else {

						// If staff invitation wass requested : On Failed 
						// Set error span for staff
						$("#error_message_span_" + pharmacy_surgery_id).removeClass("hidden");
						$("#error_message_span_" + pharmacy_surgery_id).addClass('alert-danger').removeClass('alert-success');
						$("#error_message_span_" + pharmacy_surgery_id).html(obj.err_message);
						
					} // Else - if(invitation_for == 'M'):
					
				} else { // On Success

					if(obj.governance_hr.hr_text){
						//var escapedString = '\\t',   renderedString = (new Function('return "' + obj.governance_hr.hr_text + '"'))();

						hr_text = obj.governance_hr.hr_text; 
						//hr_text = hr_text.replace('[CONTRACT_HISTORY]','');
						//hr_text = hr_text.replace('[USER_SIGNATURE]','');

						$('#governance_hr_textarea').val(hr_text);
						
						//$('#governance_hr_textarea').val(obj.governance_hr.hr_text);
					}
					else
						$('#governance_hr_textarea').val('No hr text available ...');
					//

					// Temp line (below) : for test
					//$('#governance_hr_textarea').val(obj.governance_hr.hr_text);

					// Initialize FancyBox
					$(".governance_hr_fancybox").fancybox({
						minWidth : '50%',
						maxWidth  : '75%',
						beforeLoad: function () {
							
							setTimeout(function(){
								//tinymce.init({selector:'#governance_hr_textarea'});
								tinymce.init({
								selector: "#governance_hr_textarea",
								menubar: 'edit insert table tools',
								height: '300px',
								relative_urls : false,
								remove_script_host : false,
								convert_urls : true,								
								
								theme: "modern",
								plugins: [
									"advlist autolink lists link image charmap print preview hr anchor pagebreak",
									"searchreplace wordcount visualblocks visualchars code fullscreen",
									"insertdatetime media nonbreaking save table contextmenu directionality",
									"emoticons template paste textcolor colorpicker textpattern imagetools"
								],
								toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

								});

							}, 800);
						},
						beforeClose: function (){
							tinyMCE.remove();
						}
					});

					// generate elect self as staff btn
					if(inv_for == "ST")
						$('#elect-self-staff-btn-span').html('<div class="well well-sm text-right" > <label> Check the box to the right, if the employee does not need a new contract. <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /> </label><button type="button" onClick="push_invitation_form_btn(this);" class="btn btn-sm btn-success" > Save and Send </button> </div>');
					else if(inv_for == "M")
						$('#elect-self-staff-btn-span').html('<div class="well well-sm text-right" > <label> Check the box to the right, if the employee does not need a new contract. <input type="checkbox" name="no_contract" value="1" style="margin: 0 1em 0 1em;" /> </label> <button type="button" onClick="push_invitation_form_btn(this);" class="btn btn-sm btn-success" > Save and Send </button> </div>');


					$("#send_invite_fancy_trigger").trigger('click');

					//////// POST DATA ////////
					// $invitation_sent_to_arr = User Email - User Info from DB
					// $invitation_method = 'D' OR 'E'
					// $organization_id = ...
					// $pharmacy_surgery_id = ...
					// $invitation_for = 'DO' - 'P' - 'NU' .....

					if(obj.invitation_method == 'D')
						$('#invitation_sent_to_arr').val(obj.invitation_sent_to_arr);
					else if(obj.invitation_method == 'E')
						$('#invitation_sent_to_arr').val(obj.invitation_sent_to_arr.email_address);

					$('#invitation_method').val(obj.invitation_method);
					$('#organization_id').val(obj.organization_id);
					$('#pharmacy_surgery_id').val(obj.pharmacy_surgery_id);
					$('#invitation_for').val(obj.invitation_for);

					return;
					
				} //end if(obj.error_status == 1)
			}
		});
		
	}); // $(".invite-manager-staff-btn").click( function():
	
	// Manager Cancel Invitation Process
	$(".cancel-inv-btn").click( function() {
		
		var pharmacy_surgery_id = $( this ).val();
		var invitation_id =  $( this ).attr("name");

		$.ajax({
		
			type: "POST",
			url: SURL+"organization/cancel-manager-invite/",
			data: {'inv_id' : invitation_id},
			beforeSend : function( result ){
				$("#overlay").removeClass("hidden");
			},
			success: function( result ){
				
				$("#overlay").addClass("hidden");
				$('#pending_invitation_container_m_' + pharmacy_surgery_id ).addClass('hidden');
				$('#invitation_response_m_' + pharmacy_surgery_id ).removeClass('hidden');
				
				$.fancybox.close();

			}
		}); 	  	
		
	});
	
	// Cancel Staff Invitation
	$(".delete-staff-invite").click( function() {
		
		var invitation_id = $( this ).val();
		
		$.ajax({
		
			type: "POST",
			url: SURL+"organization/cancel-manager-invite/",
			data: {'inv_id' : invitation_id},
			beforeSend : function( result ){
				//$("#overlay").removeClass("hidden");
			},
			success: function( result ){
				
				// on success: after record deleted - Hide the row
				$("#staff_pending_invitation_span_" + invitation_id).addClass("hidden");
				
				$.fancybox.close();

			}
		});
		
	});
	
	// resend-staff-invite
	$(".resend-staff-invite-btn").click(function(){
		
		var resend_btn = $( this );
		var invitation_id = resend_btn.val();
		
		$.ajax({
		
			type: "POST",
			url: SURL + "organization/resend-staff-invite/",
			data: {'invitation_id' : invitation_id},
			beforeSend : function( result ){
				//$("#overlay").removeClass("hidden");
				$(".resend-staff-invite-btn").attr("disabled", true);
			},
			success: function( result ){
				
				var obj = JSON.parse(result);
				
				if(obj.success_status == '1'){
					
					//$('#delete_staff_btn_' + invitation_id).hide(); // Hide the Delete button
					$.fancybox.close();
					resend_btn.val(obj.invitation_id);
					
				} // if(obj.success_status == 1)
				
			}
		}); 	  	
		
	}); // resend-staff-invite
	
	// Replace Manager : Show input email to send invite
	//$(".replace-manager").click( function()
	$('#team_builder').on('click', '.replace-manager', function () {

		var pharmacy_surgery_id = $( this ).attr("value");
		$('#replace_invite_div_' + pharmacy_surgery_id).toggle('medium');

	}); // $(".replace-manager").click( function()


	// Process Medicine Management Update
	$(".pharmacy_medicine_submit_class").click(function(){

	var frm_id = $(this).parents('form:first')[0].id;		
	var medicine_id = $(this).attr('rel');
	
	$("#medicine_frm_"+medicine_id).validate( {
	
		rules: {
			validate_msg: "required"
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
	}); // End #form_validate_medicine
	
   if(!$("#medicine_frm_"+medicine_id).valid()){
	  return false;
   }else {

		$('#response_'+medicine_id).removeClass('hidden');
				
		$.ajax({
		
			type: "POST",
			url: SURL+"organization/update-pharmacy-medicine-process/",
			data: $("#"+frm_id).serialize(),
			beforeSend : function(result){
				$('#pharmacy_medicine_sbt_'+medicine_id).prop('disabled', true);
				$('#response_'+medicine_id).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
			},
			success: function(result){
				$('#pharmacy_medicine_sbt_'+medicine_id).prop('disabled', false);
				$('#response_'+medicine_id).html('<strong class="text-success">'+result+'</strong>');
			}
		}); 
		
   }

	
});

	
}); // document ready function

// Start - add_new_patient_trigger() " Function to triger add new patient on key press [ ENTER KEY ]
function add_new_patient_trigger(){
	window.location = SURL+"organization/pmr/add-edit-patient";
} // end add_new_patient_trigger()


//Ajax function to Mark the SOP as READ
function mark_sop_as_read(sop_id,pharm_id){

	$.ajax({
	
		type: "POST",
		url: SURL+"organization/read-and-sign-sop-process/",
		data: 'sop_id='+sop_id+'&pharmacy_surgery_id='+pharm_id,

		beforeSend : function(result){
			//alert('before');
		},
		success: function(result){
			var obj = JSON.parse(result);
			
			$('#read_btn_'+sop_id).html('<a class="btn btn-xxs btn-success" href="'+SURL+'/organization/download-read-and-signed-sop/'+sop_id+'/'+pharm_id+'" title="Download SOP"><i class="fa fa-certificate"></i> Download</a>');
			
			if(obj.read_all_sop == 1){
				location.reload(); 
			}//end if(obj.read_all_sop == )
			
			
		}
	}); 	  	

	$.fancybox.close();
	
}//end mark_sop_as_read(sop_id,pharm_id)

//Ajax function to Mark the Governance HR as Read agianst the Organization ID
/*
function mark_hr_as_read(organization_id,pharmacy_surgery_id,user_type){

	$.ajax({
	
		type: "POST",
		url: SURL+"organization/read-and-sign-hr-process/",
		data: 'org_id='+organization_id+'&pharmacy_surgery_id='+pharmacy_surgery_id,

		beforeSend : function(result){
			//alert('before');
		},
		success: function(result){
			$('#hr_read_and_sign_container').html('<a href="'+SURL+'/organization/download-read-and-signed-hr/'+organization_id+'/'+user_type+'" class="btn btn-success pull-right" title="Download HR"><i class="fa fa-certificate"></i>  Download HR</a>')
		}
	}); 	  	

	$.fancybox.close();
	
}//end mark_sop_as_read(sop_id,pharm_id)
*/
// This function is applied on dashboard, this is just to check weather user is watching teh video for the first time or not. If he is logged in for the first time and watching the video for the first time, he will close the video and seen will be marked as 1.
if(typeof activate_dashboard_fancy !== 'undefined' && activate_dashboard_fancy == 1){

$(document).ready(function() {

	/*
	 Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
	*/
	$('#non_prescribers_intro_video').attr('rel', 'media-gallery').fancybox({
			openEffect : 'none',
			closeEffect : 'none',
			prevEffect : 'none',
			nextEffect : 'none',
			beforeClose : function () {
				//set cookie code
			$.ajax({
			
				type: "POST",
				url: SURL+"dashboard/update-user-setting/",
				data: {is_intro_video_watched: '1'},
				beforeSend : function(result){},
				success: function(result){
				}
			}); 	  	
				
				
			},

			arrows : false,
			helpers : {
				media : {},
				buttons : {}
			}
		});
	
	});

	$(window).load(function() {
		$("#non_prescribers_intro_video").click();
	});
}//end if(activate_dashboard_fancy == 1)

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

// Suggestion Box for staff on dashboard and member dashboard
/*$(".inv-input-email-address").keyup(function(){
	
	var baseUrl = SURL;
	var minlength = 3;
	var email = $(this).val();
	var pharmacy_surgery_id = $(this).attr("id");
	var str_id = pharmacy_surgery_id.split("staff_email_address_").join('');
	var user_type = $('#select_invitation_type_' + str_id).val();
	var pharmacy_surgery_hidden_id = $('#pharmacy_surgery_hidden_id_' + str_id).val();
	var path = baseUrl + 'organization/ajax-list-emails';
	if (email.length >= minlength ) {
	
	$.ajax({
		url: path,
		type: "POST",
		data: {'email': email, 'user_type' : user_type, 'pharmacy_surgery_id' : pharmacy_surgery_hidden_id },
		beforeSend: function(){
			//$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			
			//var email = $(this).val();
			$("#suggesstion_box_" + str_id).show();
			$("#suggesstion_box_" + str_id).html('<br /> <br /> ' + data);
		}
	});
  } else {
	$("#suggesstion_box_" + str_id).hide();  
  }

}); // End class keyup .inv-input-email-address
*/
// display input box email 
function select_emails(val,id) {
	$("#staff_email_address_" + id).val(val);
	$("#suggesstion_box_" + id).hide();

} // end select_emails


// Suggestion Box for manager on dashboard and member dashboard Search  Email Auto Load Manager		
/*$(".search-manager").keyup(function(){
	
	var baseUrl = SURL;
	var minlength = 3;
	var email = $(this).val();
	var pharmacy_surgery_id = $(this).attr("id");
	var str_id = pharmacy_surgery_id.split("manager_email_address_").join('');
	var path = baseUrl + 'organization/ajax-list-emails';
	
	if (email.length >= minlength ) {
		
	$.ajax({
		url: path,
		type: "POST",
		data: {'email': email, 'pharmacy_surgery_id' : str_id },
		beforeSend: function(){
			//$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			//var email = $(this).val();
			$("#suggesstion_box_manager" + str_id).show();
			$("#suggesstion_box_manager" + str_id).html(data);
		}
	});
  } else {
	$("#suggesstion_box_manager" + str_id).hide();  
  }

}); // end class keyup .search-manager
*/
// display auto  emails Manager
function select_emails_manager(val,id) {

	$("#manager_email_address_" + id).val(val);
	$("#suggesstion_box_manager" + id).hide();

}// end select_emails_manager

// Select Pharmacy Or Surgery
function select_pharmacy_surgery(element) {
	
	if(element.value == ''){
		window.location = SURL+"organization/member-dashboard/";
		return;
	} else
		window.location = SURL+"organization/pharmacy-surgery/"+element.value;
	// if(element.value == '')

}// End select_pharmacy_surgery

// Function for Timepicker
function timepicker_global_setting(element,pharmacy_id){

	/*var timepick_id = element.id;
	$('#' + timepick_id).timepicker();
	var time_var = element.value;*/
	var timepick_id = element.id;
	var time_var = element.value;
	
	$('#' + timepick_id).datetimepicker({
		 //pickDate: false
		 format: "hh:mm"

	});

}

// Global time functin save_time()
function save_time(pharmacy_surgery_id,pharmacy_surgery_timings_id)
{

	//var checked = $( '#is_sat_closed' + pharmacy_surgery_id ).prop( "checked", true );
		
	/*var is_sat_closed = $('#is_sat_closed' + pharmacy_surgery_id).bootstrapSwitch('state'); // true || false
	var is_sun_closed = $('#is_sun_closed' + pharmacy_surgery_id).bootstrapSwitch('state'); // true || false
	 
   /* // Saturday
   if (is_sat_closed == true) {
	is_sat_closed = 1;
   } else {
	 is_sat_closed = 0;
   } // end Saturday
   */
	
	var path = SURL + 'organization/settings-process';
	$.ajax({
		url: path,
		type: "POST",
		data: $("#pharmacy_surgery_timings_frm").serialize(),
		beforeSend: function(){
			//$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			
			$('#succes_msg_span'+ pharmacy_surgery_id).html('');
			 $('#succes_msg_span'+ pharmacy_surgery_id).show();
		    $('#succes_msg_span'+ pharmacy_surgery_id).html('<strong>SUCCESS: Timing added successfully.</strong>');
			
		}
	});
}//end save_time(pharmacy_surgery_id,pharmacy_surgery_timings_id)

// Auto search for doctor and pharmacist
$(".search_doctor_pharmacist").keyup(function(e)
{ 
	var usertype = $(this).attr("id");
	// Accepts all the keys except [ upkey and downkey ]
	if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40){

		$("#result").html('');
		$("#result2").html('');
		var searchid = $(this).val();
		var usertype = $(this).attr("id");
		
		var dataString = 'search='+ searchid + '&usertype='+ usertype;
		var path = SURL + 'organization/search-doctor-pharmacist';

		if(searchid!='')
		{
			$.ajax({
					type: "POST",
					url: path,
					data: {'search': searchid, 'usertype' : usertype},
					cache: false,
					success: function(data)
					{
					
						if(usertype==1){
							
							$("#result").show();
							$("#result").html(data);
							
						} else if(usertype==2){
							
							$("#result2").show();
							$("#result2").html(data);
						}
				  }
			});
	   }

	} else {

	 if(usertype==1){
		if( e.keyCode == 13 ){ // enter

			$(".selected3").trigger("click");

		} // if( e.keyCode == 13 && $('.result2 li').hasClass("selected") == true )
	 } else {
		 if( e.keyCode == 13 ){ // enter

			$(".selected2").trigger("click");

		} // if( e.keyCode == 13 && $('.result2 li').hasClass("selected") == true )
	 }

       if(usertype==1){
		   
	    	if (e.keyCode == 38) { // up Arrow key
	        var selected = $(".selected3");
	        $("#result li").removeClass("selected3");
	        if (selected.prev().length == 0) {
	            selected.siblings().last().addClass("selected3");
	        } else {
	            selected.prev().addClass("selected3");
	        }
	    }
	    	if (e.keyCode == 40) { // Down Arrow key
	        
	        var selected = $(".selected3");
	        $("#result li").removeClass("selected3");
	        
	        if (selected.next().length == 0){
	            selected.siblings().first().addClass("selected3");
	        } else {
	            selected.next().addClass("selected3");
	        } // if (selected.next().length == 0)

	    } // if( e.keyCode == 13 && $('#result2 li').hasClass("selected") == true )
	   } else {
		    
			if (e.keyCode == 38) { // up Arrow key
	        var selected = $(".selected2");
	        $("#result2 li").removeClass("selected2");
	        if (selected.prev().length == 0) {
	            selected.siblings().last().addClass("selected2");
	        } else {
	            selected.prev().addClass("selected2");
	        }
	    }
	    	if (e.keyCode == 40) { // Down Arrow key
	        
	        var selected = $(".selected2");
	        $("#result2 li").removeClass("selected2");
	        
	        if (selected.next().length == 0){
	            selected.siblings().first().addClass("selected2");
	        } else {
	            selected.next().addClass("selected2");
	        } // if (selected.next().length == 0)

	    } // if( e.keyCode == 13 && $('#result2 li').hasClass("selected") == true )
	   }

	}

});

// select val 
// display input box email 
function select_emails2(val,id,email) {
	
	$("#" + id).val(val);
	if(id == '1'){
		$("#doctor_email").val(email);
		$("#result").hide();
	} else {
		$("#pharmacist_email").val(email);
		$("#result2").hide();
	}
} // end select_emails

// Auto search for doctor and pharmacist
$("#search_btn_doc_pharm").click(function(){
	
	$("#error_msg_show").html('');
	var doctor = $("#1").attr("id");
	var doctor_val = $("#doctor_email").val();
	
	var pharmacist = $("#2").attr("id");
	var pharmacist_val = $("#pharmacist_email").val();
	
	if(doctor_val =='' && pharmacist_val ==""){
		$("#error_msg_show").addClass('well well-sm text-danger');
		$("#error_msg_show").html('<strong>Error: Please enter email address.</strong>');
	}
	
	// if(doctor_val!='' && pharmacist_val!="")
	if(doctor_val!='' || pharmacist_val!="")
	{
		$.ajax({
				type: "POST",
				url:SURL + 'organization/save-doctor-pharmacist',
				data: {'type_doctor': doctor, 'doctor_email' : doctor_val, 'type_pharmacist' : pharmacist, 'pharmacist_email' : pharmacist_val},
				beforeSend : function(result){
					//alert('before');
				},
				success: function(response)
				{
					var obj = JSON.parse(response);
					if(obj.error == 1){
						$("#error_msg_show").addClass('well well-sm text-danger');
						$("#error_msg_show").html('<strong>Error: '+obj.response_message+'</strong>');
					} else {
						$("#error_msg_show").removeClass('text-danger');
						$("#error_msg_show").addClass('well well-sm text-success');
						$("#error_msg_show").html('<strong>'+obj.response_message+'</strong>');
					}
				}
		  });
	 } // End if(doctor_val!='' && pharmacist_val!="")
}); // End  Auto search for doctor and pharmacist

/* ------------------------------------------------------------------- */
/* ------------------    Start - Chart Scripts  ---------------------- */
/* ------------------------------------------------------------------- */

// Function to show the Next and Previous question's Pie Charts
$(".show-question-chart").click( function(){
	
		$.ajax({
		
			type: "POST",
			url: SURL + "organization/get-survey-graph-data",
			data: { 'question_id' : $(this).attr("id") },
			beforeSend : function( result ){
				//$("#overlay").removeClass("hidden");
			},
			success: function( data ){
				
				var obj = jQuery.parseJSON(data);
				
				// Create our data table out of JSON data loaded from server.
				var data = new google.visualization.DataTable(obj.chart_data);

				var chart_div = document.getElementById('chart_div');
				
				// Instantiate and draw our chart, passing in some options.
				var chart = new google.visualization.ColumnChart(chart_div);
				
				chart.draw(data, {width: '100%', height: '100%', legend: 'none', vAxis: {  minValue: 0, maxValue: 100, format: '#\'%\''}});
				
				// Place Question
				$('#survey-status').html(obj.survey_status);

				// Place Question
				$('#survey-question').html(obj.question);
				
				// Place Question Statistics
				$('#question-statistics').html(obj.statistics);
				
				if(obj.comments != ''){
					// Place Question 1 & 10 comments
					$('#question-comments').html(obj.comments);
				} else{
					$('#question-comments').html('');
				} // if(obj.comments != '')
				
			} // success: function( data )
			
		}); // $.ajax
	
}); // function show-question-chart():

// Function to download Chart as PDF
$("#download-previous-survey").click( function(){
	
	var previous_charts = '';
	var survey_ref_no = $(this).attr("name"); //$('#survey_ref_no').val();
	
	$.ajax({
	
		type: "POST",
		url: SURL + "organization/get-survey-graph-data",
		data: { 'survey_ref_no' : survey_ref_no, 'pdf_download_all' : 1 },
		beforeSend : function( result ){
			//$("#overlay").removeClass("hidden");
		},
		success: function( data ){
			
			// Empty div [ id: charts-for-pdf ]
			jQuery("#charts-for-pdf").html('');
			
			// Parse JSON response array
			var obj = jQuery.parseJSON(data);
			
			// loop of object [ parsed json array ]
			$.each( obj, function( key, value ) {
				
				if(value.question != undefined){
				
					// Create our data table out of JSON data loaded from server.
					var data = new google.visualization.DataTable(value.chart_data);

					var charts_for_pdf = document.getElementById('charts-for-pdf');
					
					// Instantiate and draw our chart, passing in some options.
					var chart = new google.visualization.ColumnChart(charts_for_pdf);
					
					// Place Question
					$( "#charts-for-pdf" ).append( '<strong>Question: </strong>' + value.question );
					
					// Place Comments Only for Question 10 and question 10
					if(value.comments != ''){
						
						// Place Question 1 & 10 comments
						$( "#charts-for-pdf" ).append('<br /><br /> <strong> Comments: </strong> <br />' + value.comments);
						
					} // if(value.comments != '')
					
					// Place Question Statistics
					$( "#charts-for-pdf").append('<br /><br /> <strong> Statistics: </strong>' + value.statistics);
					
					// Save previous charts html
					previous_charts = jQuery("#charts-for-pdf").html();
					
					// Draw chart to div [ charts_for_pdf ]
					chart.draw(data, {width: 800, height: 400, legend: 'none', vAxis: {  minValue: 0, maxValue: 100, format: '#\'%\''}});
					
					// Append new chart with previus charts
					previous_charts += jQuery("#charts-for-pdf").html();
					
					// place all charts into the div
					jQuery("#charts-for-pdf").html(previous_charts);
					
					// Final contents
					var htmlContent = jQuery("#charts-for-pdf").html();
					
					jQuery("#htmlContentHidden").val('');
					jQuery("#htmlContentHidden").val(htmlContent);
					
				} // if(value.question != undefined)
				
			}); // $.each( obj, function( key, value )

			// Set Pharmacy / Surgery Information into the form hidden fields to be posted to the PDF download form [ to be used in footer ]
			$('#pharmacy_surgery_name_pdf_footer').val(obj[0].pharmacy_surgery_name);
			$('#pharmacy_surgery_address_pdf_footer').val(obj[0].pharmacy_surgery_address);
			$('#pharmacy_surgery_zip_pdf_footer').val(obj[0].pharmacy_surgery_zip);
			
			// Submit download pdf form
			$('#save-pdf-form-submit').click();
	
			// charts div make empty
			$( "#charts-for-pdf").html('');
	
		} // success: function( data )
		
	}); // $.ajax

}); // $("#download-previous-survey").click( function()

$("#download-poster").click( function(){
	
	var previous_charts = '';
	var survey_ref_no = $(this).attr("name"); //$('#survey_ref_no').val();
	var question_id_download = 9;

	$.ajax({
	
		type: "POST",
		url: SURL + "organization/get-survey-graph-data",
		data: { 'survey_ref_no' : survey_ref_no, 'pdf_download_all' : 1 , 'question_id_download' : question_id_download },
		beforeSend : function( result ){
			//$("#overlay").removeClass("hidden");
		},
		success: function( data ){
			
			// Empty div [ id: charts-for-pdf ]
			jQuery("#charts-for-pdf").html('');
			
			// Parse JSON response array
			var obj = jQuery.parseJSON(data);
			
			// loop of object [ parsed json array ]
			$.each( obj, function( key, value ) {
				
				if(value.question != undefined){
				
					// Create our data table out of JSON data loaded from server.
					var data = new google.visualization.DataTable(value.chart_data);

					var charts_for_pdf = document.getElementById('charts-for-pdf');
					
					// Instantiate and draw our chart, passing in some options.
					var chart = new google.visualization.PieChart(charts_for_pdf);
					
					// Place Question
					//$( "#charts-for-pdf" ).append( '<strong>Question: </strong>' + value.question );
					
					// Place Comments Only for Question 10 and question 10
					if(value.comments != ''){
						
						// Place Question 1 & 10 comments
						//$( "#charts-for-pdf" ).append('<br /><br /> <strong> Comments: </strong> <br />' + value.comments);
						
					} // if(value.comments != '')
					
					// Place Question Statistics
					$( "#charts-for-pdf").append('<div> ' + value.statistics + '<br><br><br></div>');

					// Save previous charts html
					previous_charts = jQuery("#charts-for-pdf").html();
					
					var new_width = 900; //1024; // .4 * window.innerHeight;
    				var new_height = 430; //768;  // .4 * window.innerWidth;

					// Draw chart to div [ charts_for_pdf ]
					chart.draw(data, {is3D: true, width: new_width, height: new_height, chartArea: {left:"15%", top:"1%", width:"100%", height:"100%"},  pieSliceText: 'none', legend: { position: 'labeled' } });
					
					// Append new chart with previus charts
					previous_charts += jQuery("#charts-for-pdf").html();
					
					// place all charts into the div
					jQuery("#charts-for-pdf").html(previous_charts);
					
					// Final contents
					var htmlContent = jQuery("#charts-for-pdf").html();
					jQuery("#htmlContentHidden").val('');
					jQuery("#htmlContentHidden").val(htmlContent);

					
				} // if(value.question != undefined)
				
			}); // $.each( obj, function( key, value )

			// Set Pharmacy / Surgery Information into the form hidden fields to be posted to the PDF download form [ to be used in footer ]
			$('#pharmacy_surgery_name_pdf_footer').val(obj[0].pharmacy_surgery_name);
			$('#pharmacy_surgery_address_pdf_footer').val(obj[0].pharmacy_surgery_address);
			$('#pharmacy_surgery_zip_pdf_footer').val(obj[0].pharmacy_surgery_zip);

			
			// Submit download pdf form
			$('#save-pdf-form-submit').click();
	
			// charts div make empty
			$( "#charts-for-pdf").html('');
	
		} // success: function( data )
		
	}); // $.ajax

}); // $("#download-poster").click( function()

/* ------------------------------------------------------------------- */
/* ------------------    End - Chart Scripts  ------------------------ */
/* ------------------------------------------------------------------- */

 // Checked  Unauthenticate
$("#checkAll").change(function () {
	
	$("input:checkbox").prop('checked', $(this).prop("checked"));
}); // End unauthenticate

// Auto search for doctor and pharmacist prescriber
$(".search_doctor_pharmacist_prescriber").keyup(function(e)
{
	// Accepts all the keys except [ upkey and downkey ]
	if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40){

		$("#result_prescriber").html('');
		
		var searchid = $(this).val();
		
		var dataString = 'search='+ searchid;
		var path = SURL + 'organization/search-doctor-pharmacist-prescriber';

		if(searchid!='')
		{
			$.ajax({
				type: "POST",
				url: path,
				data: {'search': searchid},
				cache: false,
				success: function(data)
				{
					$("#result_prescriber").show();
					$("#result_prescriber").html(data);

			  	} // success

			}); // $.ajax

	   } // if(searchid!='')
	
	} else {

		if( e.keyCode == 13 ){ // enter

			$(".selected").trigger("click");

		} // if( e.keyCode == 13 && $('.result_prescriber li').hasClass("selected") == true )

	    if (e.keyCode == 38) { // up Arrow key
	        var selected = $(".selected");
	        $("#result_prescriber li").removeClass("selected");
	        if (selected.prev().length == 0) {
	            selected.siblings().last().addClass("selected");
	        } else {
	            selected.prev().addClass("selected");
	        }
	    }
	    if (e.keyCode == 40) { // Down Arrow key
	        
	        var selected = $(".selected");
	        $("#result_prescriber li").removeClass("selected");
	        
	        if (selected.next().length == 0){
	            selected.siblings().first().addClass("selected");
	        } else {
	            selected.next().addClass("selected");
	        } // if (selected.next().length == 0)

	    } // if( e.keyCode == 13 && $('#result_prescriber li').hasClass("selected") == true )

	} // if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40)

});

// select val 
// display input box email 
function select_email_prescriber(val,email) {
	$("#is_prescriber").val(val);
	$("#prescriber_email").val(email);
    $("#result_prescriber").hide();
} // end select_email_prescriber

// Auto search for doctor and pharmacist prescriber
$("#search_btn_prescriber").click(function(){

	$("#error_msg_show_prescriber").html('');

	var prescriber_val = $("#prescriber_email").val();
	var prescriber_fees = $("#prescriber_fees").val();
	
	if(prescriber_val =='' && prescriber_fees == ''){
		$("#error_msg_show_prescriber").addClass('well well-sm text-danger');
		$("#error_msg_show_prescriber").html('<strong>Error: Please enter email address and Prescriber fees.</strong>');
	}
	
	// if(prescriber_val!='')
	if(prescriber_val!='' || prescriber_fees!="")
	{
		$.ajax({
				type: "POST",
				url:SURL + 'organization/save-doctor-pharmacist-prescriber',
				data: {'prescriber_email' : prescriber_val,'prescriber_fees' : prescriber_fees},
				beforeSend : function(result){
					//alert('before');
				},
				success: function(response)
				{
					var obj = JSON.parse(response);
					if(obj.error == 1){
						$("#error_msg_show_prescriber").addClass('well well-sm text-danger');
						$("#error_msg_show_prescriber").html('<strong>Error: '+obj.response_message+'</strong>');
					} else {

						var fancy_trigger_btn = '<button class="btn btn-xxs btn-secondary dialogue_window" href="#remove_as_prescriber_modal" type="button"> <span data-unicode="e014" class="glyphicon glyphicon-remove"></span> Remove as Prescriber </button>'

						$('#default_prescriber_info_div').html('');
						$('#default_prescriber_info_div').append(fancy_trigger_btn);
						$('#default_prescriber_info_div').prepend(obj.prescriber.first_name+' '+obj.prescriber.last_name+' ');

						$('#default_prescriber_fees_div').html('');
						
						if(obj.prescriber_fees != '')
							$('#default_prescriber_fees_div').append(' <label>&pound '+ obj.prescriber_fees +'</label> ');
						else 
							$('#default_prescriber_fees_div').append(' <label>&pound0.00</label> ');
						// if(obj.prescriber_fees != '')

						$("#error_msg_show_prescriber").removeClass('text-danger');
						$("#error_msg_show_prescriber").addClass('well well-sm text-success');
						$("#error_msg_show_prescriber").html('<strong>'+obj.response_message+'</strong>');
					}
				}
		  });
	 } // End if(doctor_val!='' && pharmacist_val!="")
}); // End  Auto search for doctor and pharmacist

// Elect self as a staff member
function elect_self_staff(el, pharmacy_surgery_id){
	
	//var el = this;
	
	//var pharmacy_surgery_id = $( this ).attr("value");
	var elect_self_as = 'ST';

	governance_hr_textarea = '';
	// Get HR Contract updated text
	if(!$('#elect_self_textarea_container').hasClass('hidden'))
		governance_hr_textarea = tinymce.get('governance_hr_textarea').getContent();

	$.ajax({
	
		type: "POST",
		url: SURL+"organization/elect-self/",
		data: {'pharmacy_surgery_id' : pharmacy_surgery_id, 'elect_self_as' : elect_self_as, 'governance_hr' : governance_hr_textarea },
		beforeSend : function( result ){
			//$("#overlay").removeClass("hidden");
		},
		success: function( result ){
			
			var obj = JSON.parse(result);
			
			if(obj.success == true){
				
				location.reload();
				return;
				
				//$(el).text('Elected');
				//$(el).removeClass("btn-warning").addClass("btn-success");
				
			} else {
				
				$(el).text('Already Elected');
				$(el).removeClass("btn-warning").addClass("btn-danger");
				
			}
		}
	}); // $.ajax
	
} // function elect_self_staff(el, pharmacy_surgery_id)

// Manager Cancel Invitation Process
function manager_elect_self_btn(el, pharmacy_surgery_id){
	
	//var pharmacy_surgery_id = $( this ).val();
	var elect_self_as = 'M';

	$(el).attr("disabled", "disabled");

	governance_hr_textarea = '';
	// Get HR Contract updated text
	if(!$('#elect_self_textarea_container').hasClass('hidden'))
		governance_hr_textarea = tinymce.get('governance_hr_textarea').getContent();

	$.ajax({
	
		type: "POST",
		url: SURL+"organization/elect-self/",
		data: {'pharmacy_surgery_id' : pharmacy_surgery_id, 'elect_self_as' : elect_self_as, 'governance_hr' : governance_hr_textarea },
		beforeSend : function( result ){
			//$("#overlay").removeClass("hidden");
		},
		success: function( result ){
			
			var obj = JSON.parse(result);
			if(obj.success == true){
				
				location.reload();
				return;
				
				/*
				$("#error_m_inv_container_" + pharmacy_surgery_id ).addClass("hidden");
				//$("#overlay").addClass("hidden");
				$('#manager_info_span_' + pharmacy_surgery_id ).removeClass('hidden');
				$('#self_manager_row_' +  pharmacy_surgery_id ).removeClass('hidden');
				$('#manager_info_span_' + pharmacy_surgery_id ).html('Manager (' + obj.manager_data.usertype + ') : </strong> ' + obj.manager_data.first_name + ' - <span class="glyphicon glyphicon-phone"></span> ' + obj.manager_data.mobile_no + ' - <span class="glyphicon glyphicon-envelope"></span> ' + obj.manager_data.email_address + ' <br /> &nbsp; ( You have Elected yourself as the manager. ) ');
				$('#invitation_response_m_' + pharmacy_surgery_id ).addClass('hidden');
				*/
				
			} else {
				
				$(el).text('Already Elected');
				$(el).removeClass("btn-warning").addClass("btn-danger");

			} // if(obj.success == true)
		}
	});
	
} // function manager_elect_self_btn(pharmacy_surgery_id)

// On Save and Send Invitation for Manage and Staff according to the user role
function push_invitation_form_btn(el){

	$(el).attr("disabled", "disabled");

	// Save updated changes
	tinyMCE.triggerSave();

	$.ajax({
	
		type: "POST",
		url: SURL+"organization/push-invitation",
		data: $('#push_invitation_form').serialize(),
		beforeSend : function( response ){
			//$("#overlay").removeClass("hidden");
		},
		success: function( response ){
			
			var obj = JSON.parse(response);
			
			var cancel_inv_form = '';
			var inv_for = obj.invitation_for;

			if(obj.response != undefined){

				cancel_inv_form = obj.response;

			} // if(obj.response)

			if(inv_for != "M" && inv_for != "SI"){ // If manager
				// If staff invitation wass requested : On Success
				$("#error_message_span_" + obj.pharmacy_surgery_id).removeClass("hidden");
				$("#error_message_span_" + obj.pharmacy_surgery_id).html('');
				$("#error_message_span_" + obj.pharmacy_surgery_id).addClass('alert-success').removeClass('alert-danger');
				//$("#error_message_span_" + obj.pharmacy_surgery_id).html('<strong>SUCCESS: Invitation has been successfully sent to ' + obj.email_address + '.</strong>');
				$("#error_message_span_" + obj.pharmacy_surgery_id).html('<strong>SUCCESS: Invitation has been successfully sent.</strong>');
			
			} else if(inv_for == "SI"){

				$("#invitation_response").html(cancel_inv_form);
				// Show different colors on Self Btn
				$("#elect_self_btn").removeClass('btn-success');
				$("#elect_self_btn").addClass('btn-warning');

			} else { // If staff
			
				$('#cancel_inv_btn_' + obj.pharmacy_surgery_id).attr("name", obj.invitation_id);
				
				$("#error_m_inv_container_" + obj.pharmacy_surgery_id ).html('');
				$("#error_m_inv_container_" + obj.pharmacy_surgery_id ).parents(".manager_error").addClass("hidden");
				$("#error_m_inv_container_" + obj.pharmacy_surgery_id ).addClass("hidden");
			
				$('#pending_invitation_container_m_' + obj.pharmacy_surgery_id ).removeClass('hidden');
				$('#invitation_sent_to_span_' + obj.pharmacy_surgery_id ).text(obj.email_address);
				$('#invitation_response_m_' + obj.pharmacy_surgery_id ).addClass('hidden');
			
			} //if(invitation_method != 'M')
			
			$.fancybox.close();
			//$.fn.fancybox.close();

		}
	}); // $.ajax

} // function push_invitation_form_btn()

//SI Cancel Invitation Process

function cancel_inv_btn(){

	var frm_id = 'superintendent_inv_frm'; // $(this).parents('form:first')[0].id;

	$.ajax({
	
		type: "POST",
		url: SURL+"organization/cancel-superintendent-invite/",
		data: $("#"+frm_id).serialize(),
		/*dataType: "json",*/
		beforeSend : function(result){
			$("#overlay").removeClass("hidden");
		},
		success: function(result){
			
			$("#overlay").addClass("hidden");

			$('#pending_invitation_container').addClass('hidden');
			$('#si_inv_container').removeClass('hidden');
			
			//Show different colors on Self Btn
			$("#elect_self_btn").addClass('btn-success');
			$("#elect_self_btn").removeClass('btn-warning');

			$('#cnage_si_btn').attr('onClick', "$('#si_inv_container').toggle('fast')");

		}
	}); // $.ajax

	$.fancybox.close();
	
} // function cancel_inv_btn()

// Function to submit form [ SI - Elect Self ]
function elect_self_si_submit(){

	governance_hr_textarea = '';
	// Get HR Contract updated text
	if(!$('#elect_self_textarea_container').hasClass('hidden'))
		governance_hr_textarea = tinymce.get('governance_hr_textarea').getContent();

	// Create new field [ containing HR updated text ]
	$('#elect_si_self_frm').append('<textarea name="governance_hr_text" >'+ governance_hr_textarea +'</textarea> ');

	// Submit form
	$('#elect_si_self_frm').submit();

} // function elect_self_si_submit()

// Use for add edit pharmacy form validation
if($('#form_pharmacy').html())
	$('#form_pharmacy').validator();
	
if($('#add_edit_sop_cat_frm').html())
$('#add_edit_sop_cat_frm').validator();	

if($('#form_manager_staff_edit').html())
	$('#form_manager_staff_edit').validator();


$('#pgd_tab_show').click(function(){
	
	$('#cqt_frm').formValidation({
		live: 'enabled',
	
	});

});
if($('#cqt_frm').html())
 $('#cqt_frm').validator();
	

// Use for add edit organization sop form validation
//$('#add_edit_org_sop').validator()

$(document).ready(function(){
	
		$('#cnage_si_btn').click(function(){
			//$('#si_inv_container').toggle('fast');
		});
	
		if($('#add_edit_org_sop').html()){

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

		} // end - if
	
	if($('#send_survey_link_frm').html()){

		$('#send_survey_link_frm').formValidation({
	        framework: 'bootstrap',
	        icon: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	            friend_email_address: {
	                validators: {
	                    notEmpty: {
	                        message: ''
	                    }
	                }
	            },
	           
	            friend_message: {
	                validators: {
	                    notEmpty: {
	                        message: ''
	                    }
	                }
	            }
				
	        }
	    });
	    
	} // end - if
	

	// Survey Radion validation on Survey Start
	$("#start_survey_btn").click(function(){
	
		$is_no_of_survey_checked = $("input:radio[name='radio_no_of_survey']").is(":checked")
		
		if(!$is_no_of_survey_checked){
			$('#option_error').html('Error: Please select from one of the options above to proceed!');
			return false;
		}else{
			return true;
		}//end if(!$is_rechas_checked)
	});

	// List All Pharmacies / Surgeries - type search : On change fetch records by type ( All - Surgery - Pharmacy )
	$('#list_pharmacies_surgeries_filter').change(function(){
		$('#list_pharmacies_surgeries_form').submit();
	});
	
});

function import_org_data(organization_name, address, postcode, country_id, contact_no){
				
	$('#pharmacy_surgery_name').val(organization_name);
	$('#address').val(stripslashes(address));
	$('#postcode').val(stripslashes(postcode));
	$('#country_id').val(stripslashes(country_id));
	$('#contact_no').val(stripslashes(contact_no));
	
}//end import_org_data(organization_name, address, postcode, country_id, contact_no)

$("#submit_cc_details_from").validate();