<?php
	$active_tab = $this->input->get('t');
	$active_tab = ($active_tab < 1 || $active_tab > 2) ? 1 : $active_tab;
	
	$CONTACT_BOOK_BLUE_TEXT = 'CONTACT_BOOK_BLUE_TEXT';
	$contact_book_blue_text = get_global_settings($CONTACT_BOOK_BLUE_TEXT); //Set from the Global Settings
	$contact_book_blue_text = filter_string($contact_book_blue_text['setting_value']);
	
?>
<?php 
	if($this->session->pmr_org_pharmacy){ 
?>
<div class="panel panel-default"> 
<style>
  .selected{
    background-color: #f5f5f5;
  }
</style>
  <!-- Default panel contents -->
   <div class="panel-heading"><strong>Contact Book</strong></div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
      	<?php 
			if(!$this->session->dismiss_message['contact_book']){
		?>
                <p class="alert alert-info in alert-dismissable">
                    <a href="#" data-pharmacy="" data-org="<?php echo $this->session->organization_id?>" data-type="contact_book" class="close dismiss_message" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <i class="fa fa-info-circle"></i> <?php echo $contact_book_blue_text; ?>
                </p>
        <?php		
			}//end if($this->session->dismiss_message['contact_book'])
		?>
		
        <ul class="nav nav-tabs">
          <li class="<?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>"><a data-toggle="tab" href="#contact_tab">Contacts</a></li>
          <li class="<?php echo ($active_tab == 2 ) ? 'active': '' ?>"><a data-toggle="tab" href="#sign_posting_tab">Sign Posting Log Private</a></li>
        </ul>
        <div class="tab-content">
          <div id="contact_tab" class="tab-pane fade in  <?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>">
            <div class="row">
              <div class="col-md-6"> <br />
              <form action="javascript:;" method="post" id="" name="" enctype="multipart/form-data">
                <input type="text" id="search_contact" name="search_contact" 
               
                 onBlur="
                      $(document).on('click', function(evt) {

                      		var $tgt = $(evt.target);
                          
                          // Exclude element by class
                            if ( !$tgt.is('.suggession_item_li') || !$tgt.is('.suggession_item_li') ) {

                                // Empty suggesstions [ ul => li ]
                                $('.suggestion_box').html('');

                                // Verify if id is not null [ id is not null ]
                               

                            } // if ( !$tgt.is('.suggession_item_li') )

                      });"
                      
                class="form-control search_contact" placeholder="Search or Add Contact" autocomplete="off">
              	<div class="suggestion_box" id="suggestion_box"> </div>
               
              </form>
              
              </div>
           
                <div class="col-md-6"> 
                      <br />
                      <a class="btn btn-sm btn-success pull-right" href="<?php echo base_url(); ?>contact-book/contact-book-pdf" style="color:#FFF">Print</a>
               </div>
               <!-- <div class="space-7"></div>
              
                <div class="overlay hidden" id="overlay_sch">
                  <div align="center" style="margin-top:150px;"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>                
                </div>
                  
               <div id="formcontainer"></div>-->
              <div class="row">
                
                <div class="col-md-12" id="table_div">
                <br />
                <table class="table table-hover table-bordered" style="margin-left:16px; width:96%;">
				<?php if($contact_list){ $i=0; ?>
                 <?php foreach($contact_list as $each){ ?>
                    <?php if($i == 0){ ?>
                        <tr>
                    <?php } ?>
                          <td>
                            <strong><?php echo $each['first_name'].' '.$each['last_name']; ?></strong> <br />
                            <?php echo $each['contact_no']; ?><br />
                            <?php echo $each['email_address']; ?>
                            <br />
                              <?php echo $each['company_notes']; ?>
                          </td>
                    <?php if($i == 2){ ?>
                        </tr>
                    <?php } ?>
            
                    <?php if($i == 2){ $i = 0; } else { $i++; } 
                  } // foreach ?>
                <?php } else {?>
                 <tr>
                  <td>No record founded..</td>
                 </tr>
                <?php } ?>
				</table>
                </div>
                
              </div>
            </div>
          </div>
          <div id="sign_posting_tab" class="tab-pane fade in <?php echo ($active_tab == 2 ) ? 'active': '' ?>"> <br />
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12"> <br />
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">Date</th>
                      <th class="text-center">Gender</th>
                      <th class="text-center">Approx age</th>
                      <th class="text-center">Patient Request</th>
                      <th class="text-center">Sign post to whom</th>
                      <th class="text-center">Reason</th>
                      <th class="text-center">Advice Given</th>
                      <th class="text-center">Follow up advice given</th>
                      <th class="text-center">Company/Note</th>
                    </tr>
                  </thead>
                  <tbody>
                 
                    
				  <?php if(!empty($list_cb_sign_post_log_private)) {
					  
                			foreach($list_cb_sign_post_log_private as $each): 
                  ?>
                             <tr>
                              <td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                              <td class="text-center"><?php echo filter_string($each['gender']);?></td>
                              <td class="text-center"><?php echo filter_string($each['approximate_age']); ?></td>
                              <td class="text-center"><?php echo filter_string($each['patient_request']); ?></td>
                              <td class="text-center"><?php echo filter_string($each['sign_post_to_whom']); ?></td>
                              <td class="text-center"><?php echo filter_string($each['reason']); ?></td>
                              <td class="text-center"><?php echo filter_string($each['advice_given']); ?></td>
                              <td class="text-center"><?php echo filter_string($each['follow_up_advice_given']); ?></td>
                              <td class="text-center"><?php echo filter_string($each['company_name_note']); ?></td>
                            </tr>
                    
					<?php 
               				endforeach; // foreach
                		}  else { ?>
                 			 <tr>
               				 	<td colspan="9"> No record founded..</td>
                             </tr>
                
                	<?php } ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
            	<div class="col-md-12">
                	<form  action="<?php echo SURL?>contact-book/contact-book-sign-post-process" method="post" name="sign_post_log_frm" id="sign_post_log_frm">
                            <div class="row">
                            <div class="col-md-12">
                              <label id="" >Date<span class="required">*</span></label>
                             <input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <br />
                                <label>Gender</label>
                                <br />
                                
                                <label> <input type="radio" id="gender" name="gender" value="Male" /> Male </label>
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                <label> <input type="radio" id="gender" name="gender" value="Female"/> Female </label>
                                
                                </div>
                            </div>
                            <div class="form-group  has-feedback">
                              <label id="" >Approx Age</label>
                              <input type="text" class="form-control" name="approximate_age" id="approximate_age" value="" />
                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                               <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group  has-feedback">
                              <label id="" >Patient Request<span class="required">*</span></label>
                              <input type="text" class="form-control" name="patient_request" id="patient_request" value="" />
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group  has-feedback">
                              <label id="" >Sign Post to Whom <span class="required">*</span></label>
                              <input type="text" class="form-control" name="sign_post_to_whom" id="sign_post_to_whom" value="" />
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group  has-feedback">
                              <label id="" >Reason <span class="required">*</span></label>
                              <input type="text" class="form-control" name="reason" id="reason" value="" />
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group  has-feedback">
                              <label id="" >Advice Given <span class="required">*</span></label>
                              <input type="text" class="form-control" name="advice_given" id="advice_given" value="" />
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group  has-feedback">
                              <label id="" >Follw up advice given<span class="required">*</span></label>
                              <input type="text" class="form-control" name="follow_up_advice_given" id="follow_up_advice_given" value="" />
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group  has-feedback">
                              <label id="" >Company/Notes (optional)</label>
                              <textarea class="form-control" rows="4" id="company_name_note" name="company_name_note"></textarea>
                            </div>
                            
                            <div class="form-group pull-right">
                             <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>contact-book/contact-book-sign-post-pdf/1" style="color:#FFF">Print</a>
                              <button type="submit" class="btn btn-sm btn-success"  id="cb_sign_post_add_update_btn" name="cb_sign_post_add_update_btn"> Add New </button>
                              
                            </div>
        </form>
                </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<input type="hidden" id="search_query_hidden" value="" />
<?php } else { ?>

<div class="row">

	<div class="col-sm-8 col-md-8 col-lg-8">
		<h3>Contact Book</h3>
	</div>
</div>

<div class="well">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinic. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                 <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
            </div>
        </div>
    </div>

<?php } ?>
<script>

$('#search_contact').keydown(function(e){

	// On tab Press || Shift tab
	if( e.keyCode == 9 || (e.shiftKey && e.keyCode == 9) ){

		// Empty suggesstions [ ul => li ]
		$('.suggestion_box').html('');

		// Verify if id is not null [ id is not null ]
		if($('#patient_id').val() == ''){
			
			//$('#contact_name').val('');
			$('#contact_name').parent().parent().addClass('has-error');
		    
		    $(this).val('');

		    if($('.help-block')){
		        $.each( $('.help-block'), function(k, error_el){
		          if($(error_el).attr('data-fv-for') == 'contact_name'){
		            if( $(error_el).attr('data-fv-validator') == 'notEmpty' ){
		              $(error_el).show();
		            } else {
		              $(error_el).hide();
		            }
		          } // if( $(error_el).attr('data-fv-for') == 'contact_name' )
		        
		        });
		    } // if($('.help-block'))

		// Prevent form submitting
		$('#add_edit_stock_supplied_frm').attr('onsubmit','return false;');

		} else {
		  // Allow form submission
		  $('#add_edit_stock_supplied_frm').attr('onsubmit','return true;');
		} // if($('#patient_id').val() == '')

	} else {

		// Accepts all the keys except [ upkey and downkey ]
		if( e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && !e.shiftKey){
			
			var _this = this;
			var my_id = 'contact_name';
			var search_query = $(this).val();
			
			setTimeout(function(){

				search_query = $(_this).val();

				if(search_query.length >= 2){

					$.ajax({
						
						type: "POST",
						url: SURL + "contact-book/search-contacts/",
						data: {'search_query' : search_query},
						/*dataType: "json",*/
						beforeSend : function(result){
							//$("#overlay").removeClass("hidden");
						},
						success: function(response){

							if(response != 'empty'){

								var obj = JSON.parse(response);

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="contact-list" class="list-group" style="z-index: 999; position: absolute; width: 93%; overflow-y: auto; min-height:50px; max-height:910px;">';
								var cls = 'selected'; // class selected to be used in the first sugesstion
								
								var var_stringify = '';
								var encoded = '';

								$.each(obj, function(key, node){
									
									var_stringify = JSON.stringify(node);
									encoded = encodeURI(var_stringify);

								   	html += '<li class="list-group-item text-primary suggession_item_li '+ cls +'" style="padding-top:5px;" onclick="auto_select_contact(\''+ encoded +'\')" ><strong style="cursor:pointer;"><a href="javascript:;"> '+node.first_name+', '+node.last_name+'</a></strong></li>';
								   	cls = ''; // set cls = selected to null
								
								}); // $.each( obj.data, function( key, node )
								
								html += '<li class="list-group-item text-primary suggession_item_li" style="padding-top:5px;" ><strong style="cursor:pointer;"><a id="mylink" href="'+SURL+'contact-book/add-edit/'+my_id+'" class="fancybox_view fancybox.ajax"> Add new contact </a></strong></li>';

								// onClick="$(this).find(\' strong \').find( \' a \' ).trigger(\'click\');"

								html += '</ul>';

								// Place html after input field [ search patient ]
								$('#suggestion_box').html(html);
								
								$('#search_query_hidden').val(search_query);

							} else {

								$('#patient_id').val('');
								$('#patient_address').val('');
								$('#patient_town').val('');
								$('#patient_postcode').val('');

								$('#patient_edit_btn').attr("href", "javascript:;");
								$('#patient_edit_btn').removeClass("fancybox_view");
								$('#patient_edit_btn').removeClass("fancybox.ajax");

								// Prepare HTML for show suggessions as list items
								var html = '<ul id="contact-list" class="list-group" style="z-index: 999; position: absolute; width: 93%; overflow-y: auto; min-height:50px; max-height:910px;">';
									var cls = 'selected'; // class selected to be used in the first sugesstion
									   	html += '<a href="'+SURL+'contact-book/add-edit/'+my_id+'" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary suggession_item_li '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new contact </strong></li> </a>';
									   	//html += '<a href="'+SURL+'prescribers/add-edit/'+el_id+'" class="fancybox_view fancybox.ajax"> <li class="list-group-item text-primary '+ cls +'" style="padding-top:5px;" ><strong style="cursor:pointer;"> Add new prescriber </strong></li> </a>';
								html += '</ul>';

								// Place html after input field [ search patient ]
								$('#suggestion_box').html(html);

							} // if(response != 'empty')

						} // success

					}); // $.ajax

				} else {

					$('#suggestion_box').html('');

					$('#patient_id').val('');
					$('#patient_address').val('');
					$('#patient_town').val('');
					$('#patient_postcode').val('');

					// $('#patient_edit_btn').attr("href", "javascript:;");
					$('#patient_edit_btn').removeClass("fancybox_view");
					$('#patient_edit_btn').removeClass("fancybox.ajax");

				} // if(search_query.length >= 2)

			},5); // end timeout function

		} else { // if keys up or down

			if( e.keyCode == 13 && $('.suggestion_box li').hasClass("selected") == true ){ // enter

				$(".selected").trigger("click");
				$(".selected a").trigger("click");

				$(".suggestion_box").html('');
				// $(".contact-list").remove();
				$('.search_contact').val('');

				// $('#patient_edit_btn').attr("href", "javascript:;");
				// $('#patient_edit_btn').removeClass("fancybox_view");
				// $('#patient_edit_btn').removeClass("fancybox.ajax");
				
			} // if( e.keyCode == 13 && $('.suggestion_box li').hasClass("selected") == true )

		    if (e.keyCode == 38) { // up Arrow key

		    	if($(".suggestion_box li").length > 1){

			        var selected = $(".selected");
			        $(".suggestion_box li").removeClass("selected");

			        if (selected.prev().length == 0) {
			            selected.siblings().last().addClass("selected");
			        } else {
			            selected.prev().addClass("selected");
			        } // if (selected.prev().length == 0)

			    } // if($(".suggestion_box li").length > 1)

		    }
		    if (e.keyCode == 40) { // Down Arrow key
		        
		        if($(".suggestion_box li").length > 1){
			        
			        var selected = $(".selected");
			        $(".suggestion_box li").removeClass("selected");
			        
			        if (selected.next().length == 0){
			            selected.siblings().first().addClass("selected");
			        } else {
			            selected.next().addClass("selected");
			        } // if (selected.next().length == 0)

			    } // if($(".suggestion_box li").length > 1)

		    } // if( e.keyCode == 13 && $('.suggestion_box li').hasClass("selected") == true )

		} // if keys up or down

	} // end => if tab press

}); // END - Auto Suggest Patient 1

// Patient 1
function auto_select_contact(data){

	var obj = JSON.parse(decodeURI(data));
	var my_id = 'contact_name';

	$('#suggestion_box').html('');

	$('#search_contact').val(obj.first_name+ ' '+obj.last_name);	
	// $('#contact_name').val(obj.first_name+ ' '+obj.last_name);

	$('#patient_id').val(obj.id);

	$('#patient_edit_btn').attr("href", SURL+'contact-book/add-edit/'+my_id+'/'+obj.id);
	$('#patient_edit_btn').addClass("fancybox_view");
	$('#patient_edit_btn').addClass("fancybox.ajax");

//	$($('#search_contact')).focusNextInputField(0);

	var search_query_hidden = $('#search_query_hidden').val();

	//////////////////////////////////////
	$.ajax({
	
		type: "POST",
		url: SURL + "contact-book/load-search-contact-book-list",
		data: { 'search_query' : search_query_hidden },
		beforeSend : function(result){
	//			$("#overlay_sch").removeClass("hidden");
		},
		success: function(html_table){
			
			$('#table_div').html(html_table)
	
		}
	});
	////////////////////////////////

} // function auto_select_patient(data)

$(document).ready(function(){
	
		if($('#sign_post_log_frm').html()){

		    $('#sign_post_log_frm').formValidation({
		        framework: 'bootstrap',
		        icon: {
		            validating: 'glyphicon glyphicon-refresh'
		        },
		        fields: {
					 
		            gender: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please select gender.'
		                    }
		                }
		            },
					
					 approximate_age: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
		           
		            patient_request: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
					
					 sign_post_to_whom: {
		                validators: {
		                    notEmpty: {
		                         message: 'Please fill out this field.'
		                    }
		                }
		            },
					
					 reason: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
					
					 advice_given: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },					
					
					 follow_up_advice_given: {
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

</script>
