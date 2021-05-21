<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css" />

<script type="text/javascript" src="<?php echo JS?>tinymce/tinymce.min.js"></script>

<?php 
	if($this->session->pmr_org_pharmacy){ 
?>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Practice Leaflet</strong></div>
      <div class="panel-body"> 
      
      <form data-toggle="validator" role="form" id="contact_book_sign_post"  name="contact_book_sign_post"  method="post" action="<?php echo SURL?>practice-leaflet/download-pdf-practice-leaf-pdf" autocomplete="off">
      	
          <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6"> 
            <div class="form-group  has-feedback">
              <label id="" >Name of Pharmacy<span class="required">*</span></label>
              <input type="text" class="form-control" name="pharmacy_name" id="pharmacy_name" value=""  required="required" pattern="[a-zA-z0-9 -]+([ '-][a-zA-Z0-9]+)*" 
              data-error="Please use allowed characters (Alphabets, Numbers, Hyphens, Space)" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group  has-feedback">
              <label id="" >Address<span class="required">*</span></label>
              <input type="text" class="form-control" name="pharmacy_address" id="pharmacy_address" value="" required="required"  pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group  has-feedback">
              <label id="" >Head Office Address</label>
              <input type="text" class="form-control" name="pharmacy_ho_address" id="pharmacy_ho_address" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>

            <div class="form-group  has-feedback">
              <label id="" >Postcode<span class="required">*</span></label>
              <input type="text" class="form-control" name="postcode" id="postcode" value="" required="required"  pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
              <div class="form-group  has-feedback">
              <label id="" >Telephone<span class="required">*</span></label>
              <input type="text" class="form-control" name="telephone" id="telephone" value="" required="required"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
                         
            </div>
           
            <div class="col-sm-6 col-md-6 col-lg-6">
            
            <div class="form-group  has-feedback">
              <label id="" >Access arrangemens for disabled customers <span class="required">*</span></label>
              <input type="text" class="form-control" name="disabled_customers" id="disabled_customers" value="" required="required" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>   
            
            <div class="form-group  has-feedback">
              <label id="" >Monday - Friday <span class="required">*</span></label>
              <!-- <input type="text" class="form-control timepicker_1" id="opening_hours" name="opening_hours"  readonly="readonly" placeholder="Opening Hours" value="09:00" />-->
              <input type="text" class="form-control" name="opening_hours" id="opening_hours" placeholder="9:00 AM - 5:00 PM" value="9:00 AM - 5:00 PM" required="required" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
           <div class="form-group  has-feedback">
              <label id="" >Saturday<span class="required">*</span></label>
              <input type="text" class="form-control" name="Saturday_time" id="Saturday_time" placeholder="9:00 AM - 2:00 PM" value="9:00 AM - 2:00 PM" required="required" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
                     
             <div class="form-group  has-feedback">
              <label id="" >Website<span class="required">*</span></label>
              <input type="text" class="form-control" name="website" id="website" value="" required="required"  />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group  has-feedback">
              <label id="" >Pharmacist Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="pharmacist_name" id="pharmacist_name" value="" required="required"  />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>        
               
            </div>
            <!-- Start:Job Job Description -->
            <div class="col-md-12 form-group">
            <label>Contact details of the local CCG *</label>
            <textarea name="ccg_contact" id="ccg_contact" required class="text-field-box normal borderd smoke-white"><?php echo filter_string($ccg_details['cms_page_arr']['page_description']);?></textarea>
            
            </div>
            
            <!-- Start:Job Job Description -->
            
            <div class="col-md-12 form-group">
            <label>Other services we provide *</label>
            <textarea name="other_services" id="other_services" required class="text-field-box normal borderd smoke-white"><?php echo filter_string($other_details['cms_page_arr']['page_description']);?></textarea>
            </div>
            
            <!-- Start:Job Job Description -->
            <div class="col-md-12 form-group">
            <label>NHS services we provide *</label>
            <textarea name="nhs_services" id="nhs_services" required class="text-field-box normal borderd smoke-white"><?php echo filter_string($nhs_details['cms_page_arr']['page_description']);?></textarea>
            </div>
            
           
            <div class="col-md-12 form-group">
             <div class="form-group pull-right " style="margin-bottom:0px;">
                  <button type="submit" class="btn btn-sm btn-primary"  name="add_update_btn"> Print Practice Leaflet</button>
                </div>
                </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php } else {?>

<div class="row">

	<div class="col-sm-8 col-md-8 col-lg-8">
		<h3>Practice Leaflet</h3>
	</div>
</div>

<div class="well">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                 <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
            </div>
        </div>
    </div>

<?php } ?>

<script type="text/javascript">
	tinymce.init({
		selector: "#ccg_contact",
		menubar: 'edit insert table tools',
		theme: "modern",
		height : "200",
    cleanup : false,
    verify_html : false,
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern imagetools"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		
	});
		tinymce.init({
		selector: "#other_services",
		menubar: 'edit insert table tools',
		theme: "modern",
		height : "200",
    cleanup : false,
    verify_html : false,
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern imagetools"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		
	});
	
	tinymce.init({
		selector: "#nhs_services",
		menubar: 'edit insert table tools',
		theme: "modern",
		height : "200",
    cleanup : false,
    verify_html : false,
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern imagetools"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		
	});
	
	
</script>
<script>

$(document).ready(function(){

	$('.timepicker_1').timepicker({
		 minuteStep: 1,
		 disableFocus: true,
		 template: 'dropdown',
		 showInputs: false,
		 showMeridian:false,
		 maxHours: 24
	});
});
</script>