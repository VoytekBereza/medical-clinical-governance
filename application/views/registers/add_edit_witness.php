<?php 
if($this->uri->segment(3)){
 $tab_id =$this->uri->segment(3);	
}
?>

    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add witness entry:</h4>
        </div>
      </div>
      
      <hr />
       
      <div class="row">
        <form data-toggle="validator" role="form"  action="<?php echo SURL?>registers/add-edit-witness-process" method="post" name="add_edit_witness_frm" id="add_edit_witness_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
             
                <div class="form-group has-feedback">
                  <label>First Name<span class="required">*</span></label>
                  <input type="text" class="form-control" name="first_name" id="first_name" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*" 
                  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"  value=""/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Last Name<span class="required">*</span></label>
                  <input type="text" class="form-control" name="last_name" id="last_name"  required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*" 
                  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"  value="" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Contact no</label>
                  <input type="digits" class="form-control" name="mobile_no" id="mobile_no" 
                  data-error="Please use allowed characters (Numbers, should start with 02 and length should be 11 numbers)" pattern="^02(?=.*[0-9])[0-9]{9,}$"  maxlength="11"/>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Address<span class="required">*</span></label>
                  <input type="text" class="form-control" name="address" id="address" value="" required="required"  pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*" 
                  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group has-feedback">
                  <label>Postcode<span class="required">*</span></label>
                  <input type="text" class="form-control my_upper_class" name="postcode" id="postcode" value="" required="required" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8" />
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"  name="add_update_btn"> Add new entry</button>
                 <input type="hidden" id="tab_id" name="tab_id" value="<?php echo $tab_id;?>">
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>


<script type="text/javascript">

if($('#add_edit_witness_frm').html())

	$('#add_edit_witness_frm').validator();

</script>