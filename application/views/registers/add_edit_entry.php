<?php 
if($this->uri->segment(3)){
 $tab_id =$this->uri->segment(3);	
}
?>
<style>
.selected {
	background-color: #f5f5f5;
}
</style>

<div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
  <div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6"> 
      <!-- <h4>Add entry:</h4>--> 
    </div>
  </div>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" id="stock_supplied_tab_click" href="#stock_supplied_tab">Stock Supplied</a></li>
    <li><a data-toggle="tab"  id="stock_received_tab_click" href="#stock_received_tab">Stock Recieved </a></li>
  </ul>
  <div class="row">
    <form  data-toggle="validator" role="form" action="<?php echo SURL?>registers/add-edit-register-entery-process" method="post" name="add_edit_new_script_frm" id="add_edit_new_script_frm" >
      <div class="col-sm-6 col-md-12 col-lg-12">
        <div class="tab-content">
          <div id="stock_supplied_tab" class="tab-pane fade in active"> <br />
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
                                              $('#add_edit_new_script_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#add_edit_new_script_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#patient_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
              <input type="hidden" readonly="readonly" id="patient_id" name="patient_id" value="" />
              <span class="patient_suggessions" id="patient_suggessions"></span> </div>
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
                                              $('#add_edit_new_script_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#add_edit_new_script_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#prescriber_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
              <input type="hidden" readonly="readonly" id="prescriber_id" name="prescriber_id" value="" />
              <span class="prescriber_suggessions" id="prescriber_suggessions"></span> </div>
            <div class="form-group has-feedback">
              <label>Quantity supplied<span class="required">*</span></label>
              <input  type="number" min="0" class="form-control" name="quantity_supplied"  id="quantity_supplied" value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-sm-12 col-md-12 col-lg-12" style="padding-left:0px;">
              <label for="gender"> Was proof of id requested?</label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label class="radio-inline">
                <input type="radio" name="proof_of_id" value="Yes">
                Yes </label>
              <label class="radio-inline">
                <input type="radio" name="proof_of_id" value="No" checked="checked" />
                No </label>
            </div>
            <div class="form-group col-sm-12 col-md-12 col-lg-12" style="padding-left:0px;">
              <label for="gender"> Was id confirmed?</label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label class="radio-inline">
                <input type="radio" name="proof_confirm_id" value="Yes">
                Yes </label>
              <label class="radio-inline">
                <input type="radio" name="proof_confirm_id" value="No" checked="checked" />
                No </label>
            </div>
            <div class="form-group">
              <label>Name of person collecting<span class="required">*</span></label>
              <input type="text" class="form-control" name="collecting_person_name" id="collecting_person_name"  value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label>Note</label>
              <textarea class="form-control" rows="4" id="note" name="note"></textarea>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div id="stock_received_tab" class="tab-pane fade in"> <br />
            <div class="form-group has-feedback">
              <label>Select supplier<span class="required">*</span></label>
              <input  type="text" class="form-control supplier_name" name="supplier_name_1" element="1"  id="supplier_select_id" value=""
                  onBlur=" $(document).on('click', function(evt) {
                                      
                                      var $tgt = $(evt.target);
                              
                                      // Exclude element by class
                                      if ( !$tgt.is('.suggession_item_li') || !$tgt.is('.suggession_item_li') ) {
    
                                        // Empty suggesstions [ ul => li ]
                                        $('.supplier_suggessions').html('');
    
                                        // Verify if id is not null [ id is not null ]
                                        if($('#supplier_id').val() == ''){
                                          
                                          $('#supplier_select_id').val('');
                                          
                                           $('#supplier_select_id').parent().addClass('has-error');
    
                                          if($('.help-block')){
                                            $.each( $('.help-block'), function(k, error_el){
                                              if($(error_el).attr('data-fv-for') == 'supplier_name_1'){
                                                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                                                  $(error_el).show();
                                                } else {
                                                  $(error_el).hide();
                                                }
                                              } // if( $(error_el).attr('data-fv-for') == 'supplier_name_1' )
    
                                            });
                                          } // if($('.help-block'))
                                         
                                              // Prevent form submitting
                                              $('#add_edit_new_script_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#add_edit_new_script_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#supplier_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
              <input type="hidden" readonly="readonly" id="supplier_id" name="supplier_id" value="" />
              <span class="supplier_suggessions" id="supplier_suggessions"></span> </div>
            <div class="form-group has-feedback">
              <label>Quantity received<span class="required">*</span></label>
              <input  type="number" min="0" class="form-control" name="quantity_received" id="quantity_received" value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group has-feedback">
              <label>Invoice Number</label>
              <input  type="text" class="form-control" name="invoice_no" id="invoice_no" value=""/>
            </div>
            
          </div>
        </div>
        <div class="row" style="margin:0">
          <div class="pull-right">
            <button type="submit" class="btn btn-sm btn-success  btn-default"  name="add_update_btn"> Add new entry</button>
            <input type="hidden" id="drug_id" name="drug_id" value="<?php echo $drug_id_select_box;?>" readonly="readonly">
            <input type="hidden" id="stock_received_supplied" name="stock_received_supplied" class="stock_check" value="SS" readonly="readonly">
            <input type="hidden" id="tab_id" name="tab_id" value="<?php echo $tab_id;?>" readonly="readonly">
            <input type="hidden" id="p_no" name="p_no" value="" readonly="readonly" >
            <!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>--> 
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
$('#stock_supplied_tab_click').click(function(){
	
	 	var stock = $('#stock_received_supplied').val('SS');
});

$('#stock_received_tab_click').click(function(){
	
	 	var stock = $('#stock_received_supplied').val('SR');
});

	$(document).ready(function(){
	
		if($('#add_edit_new_script_frm').html()){

		    $('#add_edit_new_script_frm').formValidation({
		        framework: 'bootstrap',
		        icon: {
		            validating: 'glyphicon glyphicon-refresh'
		        },
		        fields: {
					 
		            supplier_name_1: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please select a supplier.'
		                    }
		                }
		            },
					
					 quantity_received: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
		           
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
					
					 quantity_supplied: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
					
					 collecting_person_name: {
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
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-patient/1" class="fancybox_view fancybox.ajax"> Add new patient </a></strong></li>';
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
									   	html += '<a href="'+SURL+'registers/add-edit-patient/1" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new patient </strong></li> </a>';
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

// Prescriber
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
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-prescriber/1" class="fancybox_view fancybox.ajax"> Add new prescriber </a></strong></li>';
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
									   	html += '<a href="'+SURL+'registers/add-edit-prescriber/1" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new prescriber </strong></li> </a>';
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

// Supplier
$('.supplier_name').keydown(function(e){
	

	var _this = this;
	var my_id = $(_this).attr("id");
	var el_id = $(_this).attr("element");

	// On tab Press || Shift tab
	if( e.keyCode == 9 || (e.shiftKey && e.keyCode == 9) ){

		// Empty suggesstions [ ul => li ]
        $('.supplier_suggessions').html('');

        // Verify if id is not null [ id is not null ]
        if($('#supplier_id').val() == ''){
        
        $(this).val('');

        var form = $(this).closest('form');
		my_parent_form_id = $(form).attr('id');
		
          //$('#prescriber_select_id').val('');
          $('#'+my_id).parent().addClass('has-error');

          if($('.help-block')){
            $.each( $('.help-block'), function(k, error_el){
              if($(error_el).attr('data-fv-for') == 'supplier_name_'+el_id){
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
						url: SURL + "registers/search-supplier/",
						data: {'search_query' : search_query},
						/*dataType: "json",*/
						beforeSend : function(result){
							//$("#overlay").removeClass("hidden");
						},
						success: function(response){

							if(response != 'empty'){

								var obj = JSON.parse(response);

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="supplier-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
								var cls = 'selected'; // class selected to be used in the first sugesstion
								
								var var_stringify = '';
								var encoded = '';

								$.each(obj, function(key, node){

									var_stringify = JSON.stringify(node);
									encoded = encodeURI(var_stringify);
									
								   	html += '<li supplier-id="'+ node.id +'" class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" onclick="auto_select_supplier_class(\''+ encoded +'\', \''+my_id+'\')" ><strong style="cursor:pointer;"><a href="javascript:;"> '+node.supplier_name+' '+node.address+', '+node.postcode+' </a></strong></li>';
								   	cls = ''; // set cls = selected to null
								
								}); // $.each( obj.data, function(key, node)
								
								if($(_this).attr("kod-popup") != 'true'){
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-supplier/1" class="fancybox_view fancybox.ajax"> Add new supplier </a></strong></li>';
								} // if($(_this).attr("kod-popup") != 'true')

								html += '</ul>';

								// Place html after input field [ search prescriber ]
								$(_this).nextAll('#supplier_suggessions').html(html);
								$(_this).parent().nextAll('#supplier_suggessions').html(html);

							} else {

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="supplier-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
									var cls = 'selected'; // class selected to be used in the first sugesstion
									
									if($(_this).attr("kod-popup") != 'true'){
									   	html += '<a href="'+SURL+'registers/add-edit-supplier/1" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new supplier </strong></li> </a>';
									} // if($(_this).attr("kod-popup") != 'true')
									
								html += '</ul>';

								// Place html after input field [ search prescriber ]
								$(_this).nextAll('#supplier_suggessions').html(html);

								$(_this).nextAll('#supplier_id').val('');
								$(_this).parent().nextAll('#supplier_suggessions').html(html);
								$('#trigger_edit_supplier_'+my_id).attr("href", "javascript:;");

							} // if(response != 'empty')

						} // success

					});

				} else {

					$(_this).nextAll('#supplier_suggessions').html('');
					$(_this).parent().nextAll('#supplier_suggessions').html('');

					$('#trigger_edit_supplier_'+my_id).attr("href", 'javascript:;');
					$('#trigger_edit_supplier_'+my_id).removeClass('fancybox_view fancybox.ajax');

					$('#'+my_id).nextAll('#supplier_id').val('');

				} // if(search_query.length >= 1)

			},5); // end timeout function

		} else { // if keys up or down

			if( e.keyCode == 13 && $('.supplier_suggessions li').hasClass("selected") == true ){ // enter

				$(".selected").trigger("click");
				$(".selected a").trigger("click");

				$(".supplier_suggessions").html('');
				$(".supplier-list").remove();
				$('.search_supplier').val('');

			} // if( e.keyCode == 13 && $('.supplier_suggessions li').hasClass("selected") == true )

		    if (e.keyCode == 38) { // up Arrow key

		    	if($(".prescriber_suggessions li").length > 1){

		    		var selected = $(".selected");
			        $(".supplier_suggessions li").removeClass("selected");
			        if (selected.prev().length == 0) {
			            selected.siblings().last().addClass("selected");
			        } else {
			            selected.prev().addClass("selected");
			        }

		    	}// if($(".prescriber_suggessions li").length >= 1)

		    } // end => if up Arrow key

		    if (e.keyCode == 40) { // Down Arrow key
		        
		        if($(".supplier_suggessions li").length > 1){

			        var selected = $(".selected");
			        $(".supplier_suggessions li").removeClass("selected");
			        
			        if (selected.next().length == 0){
			            selected.siblings().first().addClass("selected");
			        } else {
			            selected.next().addClass("selected");
			        } // if (selected.next().length == 0)

			    } // if($(".supplier_suggessions li").length > 1) 

		    } // if( e.keyCode == 13 && $('.supplier_suggessions li').hasClass("selected") == true )

		} // if keys up or down

	} // end => if tab press
}); // End - .prescriber_name

// Auto Select Supplier by Class
function auto_select_supplier_class(data, el){

	var obj = JSON.parse(decodeURI(data));

	// trash suggessions
	$('#'+el).nextAll('#supplier_suggessions').html('');
	$('#'+el).parent().nextAll('#supplier_suggessions').html('');

	// place values
	$('#'+el).val(obj.supplier_name);
	$('#'+el).nextAll('#supplier_id').val(obj.id);
	
	// make edit button popup enable
	$('#trigger_edit_supplier_'+el).attr("href", SURL+'supplier/add-edit/'+el+'/'+obj.id);
	$('#trigger_edit_supplier_'+el).addClass('fancybox_view fancybox.ajax');

	$( $('#'+el) ).focusNextInputField(0);

} // function auto_select_supplier_class(data)

$('#p_no').val($('#current_page').val());
</script>