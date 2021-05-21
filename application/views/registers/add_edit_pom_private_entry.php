<?php 
if($this->uri->segment(3)){
 $tab_id =$this->uri->segment(3);	
}
?>
<style>
  .selected{
    background-color: #f5f5f5;
  }
</style>

    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add POM Private entry:</h4>
        </div>
      </div>
      
      <hr />
       
      <div class="row">
        <form action="<?php echo SURL?>registers/add-edit-pom-private-process" method="post" name="pom_private_frm" id="pom_private_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
                    
                <div class="form-group has-feedback">
                  <label>Select patient<span class="required">*</span></label>
                  <input  type="text" class="form-control patient_name" name="patient_name_1" element="1"  id="patient_select_id" value=""
                  onBlur=" $(document).on('click', function(evt) {
                                      
                                      var $tgt = $(evt.target);
                              
                                      // Exclude element by class
                                      if ( !$tgt.is('.suggession_item_li') || !$tgt.is('.suggession_item_li') ) {
    
                                        // Empty suggesstions [ ul => li ]
                                        $('.patient_suggessions').html('');
    
                                        // Verify if id is not null [ id is not null ]
                                        if($('#patient_id').val() == ''){
                                          
                                          $('#patient_select_id').val('');
                                          
                                           $('#patient_select_id').parent().addClass('has-error');
    
                                          if($('.help-block')){
                                            $.each( $('.help-block'), function(k, error_el){
                                              if($(error_el).attr('data-fv-for') == 'patient_name_1'){
                                                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                                                  $(error_el).show();
                                                } else {
                                                  $(error_el).hide();
                                                }
                                              } // if( $(error_el).attr('data-fv-for') == 'patient_name_1' )
    
                                            });
                                          } // if($('.help-block'))
                                         
                                              // Prevent form submitting
                                              $('#pom_private_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#pom_private_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#patient_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                   <input type="hidden" readonly="readonly" id="patient_id" name="patient_id" value="" />
                   <span class="patient_suggessions" id="patient_suggessions"></span>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Select prescriber<span class="required">*</span></label>
                  <input  type="text" class="form-control prescriber_name" name="prescriber_name_1" element="1"  id="prescriber_select_id" value=""
                  onBlur=" $(document).on('click', function(evt) {
                                      
                                      var $tgt = $(evt.target);
                              
                                      // Exclude element by class
                                      if ( !$tgt.is('.suggession_item_li') || !$tgt.is('.suggession_item_li') ) {
    
                                        // Empty suggesstions [ ul => li ]
                                        $('.prescriber_suggessions').html('');
    
                                        // Verify if id is not null [ id is not null ]
                                        if($('#prescriber_id').val() == ''){
                                          
                                          $('#prescriber_select_id').val('');
                                          
                                           $('#prescriber_select_id').parent().addClass('has-error');
    
                                          if($('.help-block')){
                                            $.each( $('.help-block'), function(k, error_el){
                                              if($(error_el).attr('data-fv-for') == 'prescriber_name_1'){
                                                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                                                  $(error_el).show();
                                                } else {
                                                  $(error_el).hide();
                                                }
                                              } // if( $(error_el).attr('data-fv-for') == 'prescriber_name_1' )
    
                                            });
                                          } // if($('.help-block'))
                                         
                                              // Prevent form submitting
                                              $('#pom_private_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#pom_private_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#prescriber_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                   <input type="hidden" readonly="readonly" id="prescriber_id" name="prescriber_id" value="" />
                   <span class="prescriber_suggessions" id="prescriber_suggessions"></span>
                </div>
                
                
                
                  <div class="form-group has-feedback">
                  <label>Select medicine<span class="required">*</span></label>
                  <input  type="text" class="form-control medicine_name" name="medicine_name_1" element="1"  id="medicine_select_id" value=""
                  onBlur=" $(document).on('click', function(evt) {
                                      
                                      var $tgt = $(evt.target);
                              
                                      // Exclude element by class
                                      if ( !$tgt.is('.suggession_item_li') || !$tgt.is('.suggession_item_li') ) {
    
                                        // Empty suggesstions [ ul => li ]
                                        $('.medicine_suggessions').html('');
    
                                        // Verify if id is not null [ id is not null ]
                                        if($('#medicine_id').val() == ''){
                                          
                                          $('#medicine_select_id').val('');
                                          
                                           $('#medicine_select_id').parent().addClass('has-error');
    
                                          if($('.help-block')){
                                            $.each( $('.help-block'), function(k, error_el){
                                              if($(error_el).attr('data-fv-for') == 'medicine_name_1'){
                                                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                                                  $(error_el).show();
                                                } else {
                                                  $(error_el).hide();
                                                }
                                              } // if( $(error_el).attr('data-fv-for') == 'medicine_name_1' )
    
                                            });
                                          } // if($('.help-block'))
                                         
                                              // Prevent form submitting
                                              $('#pom_private_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#pom_private_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#medicine_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                   <input type="hidden" readonly="readonly" id="medicine_id" name="drug_id" value="" />
                   <span class="medicine_suggessions" id="medicine_suggessions"></span>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Quantity<span class="required">*</span></label>
                  <input type="number" min="0" class="form-control" name="quantity" id="quantity" value="" required />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Cost to patient (&pound;)<span class="required">*</span></label>
                  <input type="number" min="0" class="form-control" name="patient_cost" id="patient_cost" value="" required />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"  name="add_update_btn"> Add new entry</button>
                 <input type="hidden" id="tab_id_pom" name="tab_id" value="<?php echo $tab_id;?>">
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>
<script type="text/javascript">

$(document).ready(function(){
	
		if($('#pom_private_frm').html()){

		    $('#pom_private_frm').formValidation({
		        framework: 'bootstrap',
		        icon: {
		            validating: 'glyphicon glyphicon-refresh'
		        },
		        fields: {
					
					 patient_name_1: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please select a patient.'
		                    }
		                }
		            },
		           
		            prescriber_name_1: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please select a prescriber.'
		                    }
		                }
		            },
					
					  medicine_name_1: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please select a medicine.'
		                    }
		                }
		            },
					  quantity: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },

					 patient_cost: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
										
		        }
		    });

		} // end - if
	
});

$('.patient_name').keydown(function(e){
	

	var _this = this;
	var my_id = $(_this).attr("id");
	var el_id = $(_this).attr("element");

	// On tab Press || Shift tab
	if( e.keyCode == 9 || (e.shiftKey && e.keyCode == 9) ){

		// Empty suggesstions [ ul => li ]
        $('.patient_suggessions').html('');

        // Verify if id is not null [ id is not null ]
        if($('#patient_id').val() == ''){
        
        $(this).val('');

        var form = $(this).closest('form');
		my_parent_form_id = $(form).attr('id');
		
          //$('#patient_select_id').val('');
          $('#'+my_id).parent().addClass('has-error');

          if($('.help-block')){
            $.each( $('.help-block'), function(k, error_el){
              if($(error_el).attr('data-fv-for') == 'patient_name_'+el_id){
                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                  $(error_el).show();
                } else {
                  $(error_el).hide();
                }
              } // if( $(error_el).attr('data-fv-for') == 'patient_name_1' )

            });
          } // if($('.help-block'))

              // Prevent form submitting
              $('#'+my_parent_form_id).attr('onsubmit','return false;');

        } else {
        
        	var form = $(this).closest('form');
			my_parent_form_id = $(form).attr('id');
			

       		 // Allow form submission
             $('#'+my_parent_form_id).attr('onsubmit','return true;');
             
        } // if($('#patient_id').val() == '')

	} else {

		// Accepts all the keys except [ upkey and downkey ]
		if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && !e.shiftKey && !e.ctrlKey && e.keyCode != 39 && e.keyCode != 37){
			
			// Search query string
			var search_query = $(this).val();
			
			setTimeout(function(){

				search_query = $(_this).val();

				if(search_query.length >= 2){
					

					$.ajax({

						type: "POST",
						url: SURL + "registers/search-patient/",
						data: {'search_query' : search_query},
						/*dataType: "json",*/
						beforeSend : function(result){
							//$("#overlay").removeClass("hidden");
						},
						success: function(response){

							if(response != 'empty'){

								var obj = JSON.parse(response);

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="patient-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
								var cls = 'selected'; // class selected to be used in the first sugesstion
								
								var var_stringify = '';
								var encoded = '';

								$.each(obj, function(key, node){

									var_stringify = JSON.stringify(node);
									encoded = encodeURI(var_stringify);
									
								   	html += '<li patient-id="'+ node.id +'" class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" onclick="auto_select_patient_class(\''+ encoded +'\', \''+my_id+'\')" ><strong style="cursor:pointer;"><a href="javascript:;"> '+node.first_name+' '+node.last_name+', '+node.address+', '+node.postcode+' </a></strong></li>';
								   	cls = ''; // set cls = selected to null
								
								}); // $.each( obj.data, function(key, node)
								
								if($(_this).attr("kod-popup") != 'true'){
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-patient/3" class="fancybox_view fancybox.ajax"> Add new patient </a></strong></li>';
								} // if($(_this).attr("kod-popup") != 'true')

								html += '</ul>';

								// Place html after input field [ search patient ]
								$(_this).nextAll('#patient_suggessions').html(html);
								$(_this).parent().nextAll('#patient_suggessions').html(html);

							} else {

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="patient-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
									var cls = 'selected'; // class selected to be used in the first sugesstion
									
									if($(_this).attr("kod-popup") != 'true'){
									   	html += '<a href="'+SURL+'registers/add-edit-patient/3" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new patient </strong></li> </a>';
									} // if($(_this).attr("kod-popup") != 'true')
									
								html += '</ul>';

								// Place html after input field [ search patient ]
								$(_this).nextAll('#patient_suggessions').html(html);

								$(_this).nextAll('#patient_id').val('');
								$(_this).parent().nextAll('#patient_suggessions').html(html);
								$('#trigger_edit_patient_'+my_id).attr("href", "javascript:;");

							} // if(response != 'empty')

						} // success

					});

				} else {

					$(_this).nextAll('#patient_suggessions').html('');
					$(_this).parent().nextAll('#patient_suggessions').html('');

					$('#trigger_edit_patient_'+my_id).attr("href", 'javascript:;');
					$('#trigger_edit_patient_'+my_id).removeClass('fancybox_view fancybox.ajax');

					$('#'+my_id).nextAll('#patient_id').val('');

				} // if(search_query.length >= 1)

			},5); // end timeout function

		} else { // if keys up or down

			if( e.keyCode == 13 && $('.patient_suggessions li').hasClass("selected") == true ){ // enter

				$(".selected").trigger("click");
				$(".selected a").trigger("click");

				$(".patient_suggessions").html('');
				$(".patient-list").remove();
				$('.search_patient').val('');

			} // if( e.keyCode == 13 && $('.patient_suggessions li').hasClass("selected") == true )

		    if (e.keyCode == 38) { // up Arrow key

		    	if($(".patient_suggessions li").length > 1){

		    		var selected = $(".selected");
			        $(".patient_suggessions li").removeClass("selected");
			        if (selected.prev().length == 0) {
			            selected.siblings().last().addClass("selected");
			        } else {
			            selected.prev().addClass("selected");
			        }

		    	}// if($(".patient_suggessions li").length >= 1)

		    } // end => if up Arrow key

		    if (e.keyCode == 40) { // Down Arrow key
		        
		        if($(".patient_suggessions li").length > 1){

			        var selected = $(".selected");
			        $(".patient_suggessions li").removeClass("selected");
			        
			        if (selected.next().length == 0){
			            selected.siblings().first().addClass("selected");
			        } else {
			            selected.next().addClass("selected");
			        } // if (selected.next().length == 0)

			    } // if($(".patient_suggessions li").length > 1) 

		    } // if( e.keyCode == 13 && $('.patient_suggessions li').hasClass("selected") == true )

		} // if keys up or down

	} // end => if tab press
}); // End - .patient_name

// Auto Select Patient by Class
function auto_select_patient_class(data, el){

	var obj = JSON.parse(decodeURI(data));

	// trash suggessions
	$('#'+el).nextAll('#patient_suggessions').html('');
	$('#'+el).parent().nextAll('#patient_suggessions').html('');

	// place values
	$('#'+el).val(obj.first_name+ ' '+obj.last_name);
	$('#'+el).nextAll('#patient_id').val(obj.id);
	
	// make edit button popup enable
	$('#trigger_edit_patient_'+el).attr("href", SURL+'patients/add-edit/'+el+'/'+obj.id);
	$('#trigger_edit_patient_'+el).addClass('fancybox_view fancybox.ajax');

	$( $('#'+el) ).focusNextInputField(0);

} // function auto_select_patient_class(data)


$('.prescriber_name').keydown(function(e){
	

	var _this = this;
	var my_id = $(_this).attr("id");
	var el_id = $(_this).attr("element");

	// On tab Press || Shift tab
	if( e.keyCode == 9 || (e.shiftKey && e.keyCode == 9) ){

		// Empty suggesstions [ ul => li ]
        $('.prescriber_suggessions').html('');

        // Verify if id is not null [ id is not null ]
        if($('#prescriber_id').val() == ''){
        
        $(this).val('');

        var form = $(this).closest('form');
		my_parent_form_id = $(form).attr('id');
		
          //$('#prescriber_select_id').val('');
          $('#'+my_id).parent().addClass('has-error');

          if($('.help-block')){
            $.each( $('.help-block'), function(k, error_el){
              if($(error_el).attr('data-fv-for') == 'prescriber_name_'+el_id){
                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                  $(error_el).show();
                } else {
                  $(error_el).hide();
                }
              } // if( $(error_el).attr('data-fv-for') == 'prescriber_name_1' )

            });
          } // if($('.help-block'))

              // Prevent form submitting
              $('#'+my_parent_form_id).attr('onsubmit','return false;');

        } else {
        
        	var form = $(this).closest('form');
			my_parent_form_id = $(form).attr('id');
			

       		 // Allow form submission
             $('#'+my_parent_form_id).attr('onsubmit','return true;');
             
        } // if($('#prescriber_id').val() == '')

	} else {

		// Accepts all the keys except [ upkey and downkey ]
		if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && !e.shiftKey && !e.ctrlKey && e.keyCode != 39 && e.keyCode != 37){
			
			// Search query string
			var search_query = $(this).val();
			
			setTimeout(function(){

				search_query = $(_this).val();

				if(search_query.length >= 2){
					

					$.ajax({

						type: "POST",
						url: SURL + "registers/search-prescriber/",
						data: {'search_query' : search_query},
						/*dataType: "json",*/
						beforeSend : function(result){
							//$("#overlay").removeClass("hidden");
						},
						success: function(response){

							if(response != 'empty'){

								var obj = JSON.parse(response);

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="prescriber-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
								var cls = 'selected'; // class selected to be used in the first sugesstion
								
								var var_stringify = '';
								var encoded = '';

								$.each(obj, function(key, node){

									var_stringify = JSON.stringify(node);
									encoded = encodeURI(var_stringify);
									
								   	html += '<li prescriber-id="'+ node.id +'" class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" onclick="auto_select_prescriber_class(\''+ encoded +'\', \''+my_id+'\')" ><strong style="cursor:pointer;"><a href="javascript:;"> '+node.first_name+' '+node.last_name+', '+node.address+', '+node.postcode+' </a></strong></li>';
								   	cls = ''; // set cls = selected to null
								
								}); // $.each( obj.data, function(key, node)
								
								if($(_this).attr("kod-popup") != 'true'){
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-prescriber/3" class="fancybox_view fancybox.ajax"> Add new prescriber </a></strong></li>';
								} // if($(_this).attr("kod-popup") != 'true')

								html += '</ul>';

								// Place html after input field [ search prescriber ]
								$(_this).nextAll('#prescriber_suggessions').html(html);
								$(_this).parent().nextAll('#prescriber_suggessions').html(html);

							} else {

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="prescriber-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
									var cls = 'selected'; // class selected to be used in the first sugesstion
									
									if($(_this).attr("kod-popup") != 'true'){
									   	html += '<a href="'+SURL+'registers/add-edit-prescriber/3" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new prescriber </strong></li> </a>';
									} // if($(_this).attr("kod-popup") != 'true')
									
								html += '</ul>';

								// Place html after input field [ search prescriber ]
								$(_this).nextAll('#prescriber_suggessions').html(html);

								$(_this).nextAll('#prescriber_id').val('');
								$(_this).parent().nextAll('#prescriber_suggessions').html(html);
								$('#trigger_edit_prescriber_'+my_id).attr("href", "javascript:;");

							} // if(response != 'empty')

						} // success

					});

				} else {

					$(_this).nextAll('#prescriber_suggessions').html('');
					$(_this).parent().nextAll('#prescriber_suggessions').html('');

					$('#trigger_edit_prescriber_'+my_id).attr("href", 'javascript:;');
					$('#trigger_edit_prescriber_'+my_id).removeClass('fancybox_view fancybox.ajax');

					$('#'+my_id).nextAll('#prescriber_id').val('');

				} // if(search_query.length >= 1)

			},5); // end timeout function

		} else { // if keys up or down

			if( e.keyCode == 13 && $('.prescriber_suggessions li').hasClass("selected") == true ){ // enter

				$(".selected").trigger("click");
				$(".selected a").trigger("click");

				$(".prescriber_suggessions").html('');
				$(".prescriber-list").remove();
				$('.search_prescriber').val('');

			} // if( e.keyCode == 13 && $('.prescriber_suggessions li').hasClass("selected") == true )

		    if (e.keyCode == 38) { // up Arrow key

		    	if($(".prescriber_suggessions li").length > 1){

		    		var selected = $(".selected");
			        $(".prescriber_suggessions li").removeClass("selected");
			        if (selected.prev().length == 0) {
			            selected.siblings().last().addClass("selected");
			        } else {
			            selected.prev().addClass("selected");
			        }

		    	}// if($(".prescriber_suggessions li").length >= 1)

		    } // end => if up Arrow key

		    if (e.keyCode == 40) { // Down Arrow key
		        
		        if($(".prescriber_suggessions li").length > 1){

			        var selected = $(".selected");
			        $(".prescriber_suggessions li").removeClass("selected");
			        
			        if (selected.next().length == 0){
			            selected.siblings().first().addClass("selected");
			        } else {
			            selected.next().addClass("selected");
			        } // if (selected.next().length == 0)

			    } // if($(".prescriber_suggessions li").length > 1) 

		    } // if( e.keyCode == 13 && $('.prescriber_suggessions li').hasClass("selected") == true )

		} // if keys up or down

	} // end => if tab press
}); // End - .prescriber_name

// Auto Select Prescriber by Class
function auto_select_prescriber_class(data, el){

	var obj = JSON.parse(decodeURI(data));

	// trash suggessions
	$('#'+el).nextAll('#prescriber_suggessions').html('');
	$('#'+el).parent().nextAll('#prescriber_suggessions').html('');

	// place values
	$('#'+el).val(obj.first_name+ ' '+obj.last_name);
	$('#'+el).nextAll('#prescriber_id').val(obj.id);
	
	// make edit button popup enable
	$('#trigger_edit_prescriber_'+el).attr("href", SURL+'prescriber/add-edit/'+el+'/'+obj.id);
	$('#trigger_edit_prescriber_'+el).addClass('fancybox_view fancybox.ajax');

	$( $('#'+el) ).focusNextInputField(0);

} // function auto_select_prescriber_class(data)

// Medicine
$('.medicine_name').keydown(function(e){
	

	var _this = this;
	var my_id = $(_this).attr("id");
	var el_id = $(_this).attr("element");
	var tab_id = $('#tab_id_pom').val();


	// On tab Press || Shift tab
	if( e.keyCode == 9 || (e.shiftKey && e.keyCode == 9) ){

		// Empty suggesstions [ ul => li ]
        $('.medicine_suggessions').html('');

        // Verify if id is not null [ id is not null ]
        if($('#medicine_id').val() == ''){
        
        $(this).val('');

        var form = $(this).closest('form');
		my_parent_form_id = $(form).attr('id');
		
          //$('#medicine_select_id').val('');
          $('#'+my_id).parent().addClass('has-error');

          if($('.help-block')){
            $.each( $('.help-block'), function(k, error_el){
              if($(error_el).attr('data-fv-for') == 'medicine_name_'+el_id){
                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                  $(error_el).show();
                } else {
                  $(error_el).hide();
                }
              } // if( $(error_el).attr('data-fv-for') == 'medicine_name_1' )

            });
          } // if($('.help-block'))

              // Prevent form submitting
              $('#'+my_parent_form_id).attr('onsubmit','return false;');

        } else {
        
        	var form = $(this).closest('form');
			my_parent_form_id = $(form).attr('id');
			

       		 // Allow form submission
             $('#'+my_parent_form_id).attr('onsubmit','return true;');
             
        } // if($('#medicine_id').val() == '')

	} else {

		// Accepts all the keys except [ upkey and downkey ]
		if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && !e.shiftKey && !e.ctrlKey && e.keyCode != 39 && e.keyCode != 37){
			
			// Search query string
			var search_query = $(this).val();
			
			setTimeout(function(){

				search_query = $(_this).val();

				if(search_query.length >= 2){
					

					$.ajax({

						type: "POST",
						url: SURL + "registers/search-medicine/",
						data: {'search_query' : search_query, 'tab_id' : tab_id},
						/*dataType: "json",*/
						beforeSend : function(result){
							//$("#overlay").removeClass("hidden");
						},
						success: function(response){

							if(response != 'empty'){

								var obj = JSON.parse(response);

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="medicine-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
								var cls = 'selected'; // class selected to be used in the first sugesstion
								
								var var_stringify = '';
								var encoded = '';

								$.each(obj, function(key, node){

									var_stringify = JSON.stringify(node);
									encoded = encodeURI(var_stringify);
									
								   	html += '<li medicine-id="'+ node.id +'" class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" onclick="auto_select_medicine_class(\''+ encoded +'\', \''+my_id+'\')" ><strong style="cursor:pointer;"><a href="javascript:;"> '+node.drug_name+' '+node.drug_form+' '+node.drug_strength+'</a></strong></li>';
								   	cls = ''; // set cls = selected to null
								
								}); // $.each( obj.data, function(key, node)
								
								if($(_this).attr("kod-popup") != 'true'){
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-registers/3" class="fancybox_view fancybox.ajax"> Add new medicine </a></strong></li>';
								} // if($(_this).attr("kod-popup") != 'true')

								html += '</ul>';

								// Place html after input field [ search medicine ]
								$(_this).nextAll('#medicine_suggessions').html(html);
								$(_this).parent().nextAll('#medicine_suggessions').html(html);

							} else {

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="medicine-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
									var cls = 'selected'; // class selected to be used in the first sugesstion
									
									if($(_this).attr("kod-popup") != 'true'){
									   	html += '<a href="'+SURL+'registers/add-edit-registers/3" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new medicine </strong></li> </a>';
									} // if($(_this).attr("kod-popup") != 'true')
									
								html += '</ul>';

								// Place html after input field [ search medicine ]
								$(_this).nextAll('#medicine_suggessions').html(html);

								$(_this).nextAll('#medicine_id').val('');
								$(_this).parent().nextAll('#medicine_suggessions').html(html);
								$('#trigger_edit_medicine_'+my_id).attr("href", "javascript:;");

							} // if(response != 'empty')

						} // success

					});

				} else {

					$(_this).nextAll('#medicine_suggessions').html('');
					$(_this).parent().nextAll('#medicine_suggessions').html('');

					$('#trigger_edit_medicine_'+my_id).attr("href", 'javascript:;');
					$('#trigger_edit_medicine_'+my_id).removeClass('fancybox_view fancybox.ajax');

					$('#'+my_id).nextAll('#medicine_id').val('');

				} // if(search_query.length >= 1)

			},5); // end timeout function

		} else { // if keys up or down

			if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true ){ // enter

				$(".selected").trigger("click");
				$(".selected a").trigger("click");

				$(".medicine_suggessions").html('');
				$(".medicine-list").remove();
				$('.search_medicine').val('');

			} // if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true )

		    if (e.keyCode == 38) { // up Arrow key

		    	if($(".medicine_suggessions li").length > 1){

		    		var selected = $(".selected");
			        $(".medicine_suggessions li").removeClass("selected");
			        if (selected.prev().length == 0) {
			            selected.siblings().last().addClass("selected");
			        } else {
			            selected.prev().addClass("selected");
			        }

		    	}// if($(".medicine_suggessions li").length >= 1)

		    } // end => if up Arrow key

		    if (e.keyCode == 40) { // Down Arrow key
		        
		        if($(".medicine_suggessions li").length > 1){

			        var selected = $(".selected");
			        $(".medicine_suggessions li").removeClass("selected");
			        
			        if (selected.next().length == 0){
			            selected.siblings().first().addClass("selected");
			        } else {
			            selected.next().addClass("selected");
			        } // if (selected.next().length == 0)

			    } // if($(".medicine_suggessions li").length > 1) 

		    } // if( e.keyCode == 13 && $('.medicine_suggessions li').hasClass("selected") == true )

		} // if keys up or down

	} // end => if tab press
}); // End - .medicine_name

// Auto Select Prescriber by Class
function auto_select_medicine_class(data, el){

	var obj = JSON.parse(decodeURI(data));

	// trash suggessions
	$('#'+el).nextAll('#medicine_suggessions').html('');
	$('#'+el).parent().nextAll('#medicine_suggessions').html('');

	// place values
	
	
	$('#'+el).val(obj.drug_name+ ' '+obj.drug_form+ ' '+obj.drug_strength);
	$('#'+el).nextAll('#medicine_id').val(obj.id);
	
	// make edit button popup enable
	$('#trigger_edit_medicine_'+el).attr("href", SURL+'medicine/add-edit/'+el+'/'+obj.id);
	$('#trigger_edit_medicine_'+el).addClass('fancybox_view fancybox.ajax');

	$( $('#'+el) ).focusNextInputField(0);

} // function auto_select_medicine_class(data)


</script>