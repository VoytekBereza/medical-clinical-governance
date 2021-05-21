<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Add Contact Book</h4> 
  <hr /> 
   <br />       

  <form id="add_edit_contact_book_frm" method="post" enctype="multipart/form-data" action="javascript:;">
  <div class="col-sm-6 col-md-12 col-lg-12">
    
     <div class="form-group">
      <label id="" >First Name <span class="required">*</span></label>
      <input type="text" class="form-control error_class" name="first_name" id="first_name" value="" required="required" data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9\s\-]+[a-zA-Z0-9-_]{1,30}$" data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)" maxlength="30" />
  
    </div>
    
    
    <div class="form-group">
      <label id="" >Last Name<span class="required">*</span></label>
      <input type="text" class="form-control error_class" name="last_name" id="last_name" value="" required="required"  data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9\s\-]+[a-zA-Z0-9-_]{1,30}$" data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)" maxlength="30" />
    </div>
    
    <div class="form-group">
      <label id="" >Email (optional)</label>
      <input type="email" class="form-control error_class" name="email_address" id="email_address" value="" data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9\s\-]+[a-zA-Z0-9\s\-_.@]+$" data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" autocomplete="off" maxlength="255" />
    </div>
    
    <div class="form-group">
      <label id="" >Contact Number<span class="required">*</span></label>
      <input type="text" class="form-control error_class" name="contact_no" id="contact_no" value="" required="required" data-fv-regexp="true" data-fv-regexp-regexp="^(02|01|07)(?=.*[0-9])[0-9]{9,}$"  data-fv-regexp-message="Please use allowed characters (Numbers, should start with 02 or 01 or 07 and length should be 11 numbers)" maxlength="11"/>
    </div>
    
     <div class="form-group ">
      <label id="" > Company/Notes (optional)</label>
      <textarea class="form-control" rows="4" id="company_notes" name="company_notes"></textarea>
    </div>
    
 
   
    <div class="form-group pull-right">
      <button type="buuton" class="btn btn-sm btn-success" id="save_contact_book_popup" name="save_contact_book_popup"> Add New Contact </button>
    </div>
  </div>
        </form>
    
    <script>
	
$(document).ready(function(){
	
		$('#save_contact_book_popup').click(function(){			
		
		    $('#add_edit_contact_book_frm').formValidation({
		        framework: 'bootstrap',
		        icon: {
		            validating: 'glyphicon glyphicon-refresh'
		        },
		        fields: {
					 
		            first_name: {
		                validators: {
		                    notEmpty: {
		                       message: 'Please fill out this field.',
		                    }
		                }
		            },
					
					 last_name: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
		           					
					 contact_no: {
		                validators: {
		                    notEmpty: {
		                         message: 'Please fill out this field.'
		                    }
		                }
		            },

		        }
		    });
			
			if($('#add_edit_contact_book_frm').find('.has-error').get(0) != undefined || $('#add_edit_contact_book_frm').find('.has-success').get(0) != undefined){
			
// 				$('#add_edit_contact_book_frm').find('.has-error').get(0)
				if( $('#add_edit_contact_book_frm').find('.has-success').get(0) != undefined && $('#add_edit_contact_book_frm').find('.has-error').get(0) == undefined ){
					
					// send ajax call
						var path = SURL + 'contact-book/add-edit-contact-book-process-ajax';
						$.ajax({
							url: path,
							type: "POST",
							data: $("#add_edit_contact_book_frm").serializeArray(), 
							beforeSend: function(){
								
								//$('#invalid_login_err').addClass('hidden');
								//$('#invalid_login_err').html('');
								
							},
							success: function(data){
								
								var obj = JSON.parse(data);
								console.log(obj);
								$.fancybox.close();
								location.reload();
								
							}
							
						});
					
				} else {
				
					return;
					
				} // 
			
			}

		}); 
});
    </script>