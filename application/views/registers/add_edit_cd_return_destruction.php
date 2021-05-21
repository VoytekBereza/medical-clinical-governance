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
         <!-- <h4>Add CD Returns / Destructions</h4>-->
        </div>
      </div>
      
       <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" id="return_tab_click" href="#stock_reurn_tab">Return</a></li>
          <li><a data-toggle="tab"  id="destruction_tab_click" href="#stock_destruction_tab">Destruction </a></li>
        </ul>
       
      <div class="row">
        <form  data-toggle="validator" role="form" action="<?php echo SURL?>registers/add-edit-return-process" method="post" name="add_cd_retrun_frm" id="add_cd_retrun_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
          
             <div class="tab-content">
              <div id="stock_reurn_tab" class="tab-pane fade in active">
              <br />
          
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
                                              $('#add_cd_retrun_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#add_cd_retrun_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#patient_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                   <input type="hidden" readonly="readonly" id="patient_id" name="patient_id" value="" />
                   <span class="patient_suggessions" id="patient_suggessions"></span>
                </div>
               
                <div class="form-group has-feedback">
                  <label>Name of Person Returning<span class="required">*</span></label>
                  <input type="text" class="form-control" name="person_return_name" id="person_return_name" value="" required />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Role of Returning Patient<span class="required">*</span></label>
                  <input type="text" class="form-control" name="patient_return_name" id="patient_return_name" value="" required />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Name of Person Collecting<span class="required">*</span></label>
                  <input type="text" class="form-control" name="person_collecting" id="person_collecting" value="" required />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Quantity<span class="required">*</span></label>
                  <input type="number" min="0" class="form-control" name="quantity" id="quantity" value="" required />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                </div>
                
                <div id="stock_destruction_tab" class="tab-pane fade in">
                <br />
                
                <div class="form-group has-feedback">
                  <label>Select witness<span class="required">*</span></label>
                  <input  type="text" class="form-control witness_name" name="witness_name_1" element="1"  id="witness_select_id" value=""
                  onBlur=" $(document).on('click', function(evt) {
                                      
                                      var $tgt = $(evt.target);
                              
                                      // Exclude element by class
                                      if ( !$tgt.is('.suggession_item_li') || !$tgt.is('.suggession_item_li') ) {
    
                                        // Empty suggesstions [ ul => li ]
                                        $('.patient_suggessions').html('');
    
                                        // Verify if id is not null [ id is not null ]
                                        if($('#witness_id').val() == ''){
                                          
                                          $('#witness_select_id').val('');
                                          
                                           $('#witness_select_id').parent().addClass('has-error');
    
                                          if($('.help-block')){
                                            $.each( $('.help-block'), function(k, error_el){
                                              if($(error_el).attr('data-fv-for') == 'witness_name_1'){
                                                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                                                  $(error_el).show();
                                                } else {
                                                  $(error_el).hide();
                                                }
                                              } // if( $(error_el).attr('data-fv-for') == 'witness_name_1' )
    
                                            });
                                          } // if($('.help-block'))
                                         
                                              // Prevent form submitting
                                              $('#add_cd_retrun_frm').attr('onsubmit','return false;');
    
                                        } else {
                                        
                                             // Allow form submission
                                             $('#add_cd_retrun_frm').attr('onsubmit','return true;');
                                             
                                        } // if($('#witness_id').val() == '')
    
                                      } // if ( !$tgt.is('.suggession_item_li') )
    
                                  });" autocomplete="off" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                   <input type="hidden" readonly="readonly" id="witness_id" name="witness_id" value="" />
                   <span class="witness_suggessions" id="witness_suggessions"></span>
                </div>
               
                
                <div class="form-group has-feedback">
                  <label>Quantity<span class="required">*</span></label>
                  <input type="number" min="0" class="form-control" name="destruct_quantity" id="destruct_quantity" value=""  />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                </div>
               </div> 
                
               
                
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"  name="add_update_btn"> Add new entry</button>
                 <input id="drug_id" name="drug_id" value="<?php echo $drug_id_cd_return_select_box;?>" type="hidden">
                 <input type="hidden" id="tab_id" name="tab_id" value="<?php echo $tab_id;?>">
                 <input type="hidden" id="stock_return_destruction" name="stock_return_destruction" class="stock_check" value="cd_return">
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>
    
<script>
$('#return_tab_click').click(function(){
	
	 	var stock = $('#stock_return_destruction').val('cd_return');
});

$('#destruction_tab_click').click(function(){
	
	 	var stock = $('#stock_return_destruction').val('cd_destruction');
});
	
	
	$(document).ready(function(){
	
		if($('#add_cd_retrun_frm').html()){

		    $('#add_cd_retrun_frm').formValidation({
		        framework: 'bootstrap',
		        icon: {
		            validating: 'glyphicon glyphicon-refresh'
		        },
		        fields: {
					
					 witness_name_1: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please select a witness.'
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
					
					
					
					 destruct_quantity: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
					
					 person_return_name: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
					
					 patient_return_name: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
					
					 person_collecting: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
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
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-patient/2" class="fancybox_view fancybox.ajax"> Add new patient </a></strong></li>';
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
									   	html += '<a href="'+SURL+'registers/add-edit-patient/2" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new patient </strong></li> </a>';
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

$('.witness_name').keydown(function(e){
	

	var _this = this;
	var my_id = $(_this).attr("id");
	var el_id = $(_this).attr("element");

	// On tab Press || Shift tab
	if( e.keyCode == 9 || (e.shiftKey && e.keyCode == 9) ){

		// Empty suggesstions [ ul => li ]
        $('.witness_suggessions').html('');

        // Verify if id is not null [ id is not null ]
        if($('#witness_id').val() == ''){
        
        $(this).val('');

        var form = $(this).closest('form');
		my_parent_form_id = $(form).attr('id');
		
          //$('#witness_select_id').val('');
          $('#'+my_id).parent().addClass('has-error');

          if($('.help-block')){
            $.each( $('.help-block'), function(k, error_el){
              if($(error_el).attr('data-fv-for') == 'witness_name_'+el_id){
                if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
                  $(error_el).show();
                } else {
                  $(error_el).hide();
                }
              } // if( $(error_el).attr('data-fv-for') == 'witness_name_1' )

            });
          } // if($('.help-block'))

              // Prevent form submitting
              $('#'+my_parent_form_id).attr('onsubmit','return false;');

        } else {
        
        	var form = $(this).closest('form');
			my_parent_form_id = $(form).attr('id');
			

       		 // Allow form submission
             $('#'+my_parent_form_id).attr('onsubmit','return true;');
             
        } // if($('#witness_id').val() == '')

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
						url: SURL + "registers/search-witness/",
						data: {'search_query' : search_query},
						/*dataType: "json",*/
						beforeSend : function(result){
							//$("#overlay").removeClass("hidden");
						},
						success: function(response){

							if(response != 'empty'){

								var obj = JSON.parse(response);

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="witness-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
								var cls = 'selected'; // class selected to be used in the first sugesstion
								
								var var_stringify = '';
								var encoded = '';

								$.each(obj, function(key, node){

									var_stringify = JSON.stringify(node);
									encoded = encodeURI(var_stringify);
									
								   	html += '<li witness-id="'+ node.id +'" class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" onclick="auto_select_witness_class(\''+ encoded +'\', \''+my_id+'\')" ><strong style="cursor:pointer;"><a href="javascript:;"> '+node.first_name+' '+node.last_name+', '+node.address+', '+node.postcode+' </a></strong></li>';
								   	cls = ''; // set cls = selected to null
								
								}); // $.each( obj.data, function(key, node)
								
								if($(_this).attr("kod-popup") != 'true'){
									html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a href="'+SURL+'registers/add-edit-witness/2" class="fancybox_view fancybox.ajax"> Add new witness </a></strong></li>';
								} // if($(_this).attr("kod-popup") != 'true')

								html += '</ul>';

								// Place html after input field [ search witness ]
								$(_this).nextAll('#witness_suggessions').html(html);
								$(_this).parent().nextAll('#witness_suggessions').html(html);

							} else {

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="witness-list" class="list-group" style="z-index: 999; position: absolute; width: 97.4%; overflow-y: auto; min-height:50px; max-height:910px;">';
									var cls = 'selected'; // class selected to be used in the first sugesstion
									
									if($(_this).attr("kod-popup") != 'true'){
									   	html += '<a href="'+SURL+'registers/add-edit-witness/2" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new witness </strong></li> </a>';
									} // if($(_this).attr("kod-popup") != 'true')
									
								html += '</ul>';

								// Place html after input field [ search witness ]
								$(_this).nextAll('#witness_suggessions').html(html);

								$(_this).nextAll('#witness_id').val('');
								$(_this).parent().nextAll('#witness_suggessions').html(html);
								$('#trigger_edit_witness_'+my_id).attr("href", "javascript:;");

							} // if(response != 'empty')

						} // success

					});

				} else {

					$(_this).nextAll('#witness_suggessions').html('');
					$(_this).parent().nextAll('#witness_suggessions').html('');

					$('#trigger_edit_witness_'+my_id).attr("href", 'javascript:;');
					$('#trigger_edit_witness_'+my_id).removeClass('fancybox_view fancybox.ajax');

					$('#'+my_id).nextAll('#witness_id').val('');

				} // if(search_query.length >= 1)

			},5); // end timeout function

		} else { // if keys up or down

			if( e.keyCode == 13 && $('.witness_suggessions li').hasClass("selected") == true ){ // enter

				$(".selected").trigger("click");
				$(".selected a").trigger("click");

				$(".witness_suggessions").html('');
				$(".witness-list").remove();
				$('.search_witness').val('');

			} // if( e.keyCode == 13 && $('.witness_suggessions li').hasClass("selected") == true )

		    if (e.keyCode == 38) { // up Arrow key

		    	if($(".witness_suggessions li").length > 1){

		    		var selected = $(".selected");
			        $(".witness_suggessions li").removeClass("selected");
			        if (selected.prev().length == 0) {
			            selected.siblings().last().addClass("selected");
			        } else {
			            selected.prev().addClass("selected");
			        }

		    	}// if($(".witness_suggessions li").length >= 1)

		    } // end => if up Arrow key

		    if (e.keyCode == 40) { // Down Arrow key
		        
		        if($(".witness_suggessions li").length > 1){

			        var selected = $(".selected");
			        $(".witness_suggessions li").removeClass("selected");
			        
			        if (selected.next().length == 0){
			            selected.siblings().first().addClass("selected");
			        } else {
			            selected.next().addClass("selected");
			        } // if (selected.next().length == 0)

			    } // if($(".witness_suggessions li").length > 1) 

		    } // if( e.keyCode == 13 && $('.witness_suggessions li').hasClass("selected") == true )

		} // if keys up or down

	} // end => if tab press
}); // End - .witness_name
// Auto Select Patient by Class
function auto_select_witness_class(data, el){

	var obj = JSON.parse(decodeURI(data));
	
	// trash suggessions
	$('#'+el).nextAll('#witness_suggessions').html('');
	$('#'+el).parent().nextAll('#witness_suggessions').html('');

	// place values
	$('#'+el).val(obj.first_name+ ' '+obj.last_name);
	$('#'+el).nextAll('#witness_id').val(obj.id);
	
	// make edit button popup enable
	$('#trigger_edit_witness_'+el).attr("href", SURL+'witness/add-edit/'+el+'/'+obj.id);
	$('#trigger_edit_witness_'+el).addClass('fancybox_view fancybox.ajax');

	$( $('#'+el) ).focusNextInputField(0);

} // function auto_select_witness_class(data)


</script>