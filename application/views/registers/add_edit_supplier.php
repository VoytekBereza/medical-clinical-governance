<?php 
if($this->uri->segment(3)){
 $tab_id =$this->uri->segment(3);	
}
?>

    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add supplier:</h4>
        </div>
      </div>
      
      <hr />
       
      <div class="row">
        <form  data-toggle="validator" role="form" action="<?php echo SURL?>registers/add-edit-supplier-process" method="post" name="supplier_frm" id="supplier_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
            
             <div class="form-group has-feedback">
              <label>Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="supplier_name" id="supplier_name" value="" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Address 1<span class="required">*</span></label>
              <input type="text" class="form-control" name="address" id="address"  required="required"  pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Address 2</label>
              <input type="text" class="form-control" name="address_2" id="address_2" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" value=""/>
               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            
             <div class="form-group has-feedback">
              <label>Address 3</label>
              <input type="text" class="form-control" name="address_2" id="address_2" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Postcode<span class="required">*</span></label>
              <input type="text" class="form-control my_upper_class" name="postcode" id="postcode" value="" required  pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"   name="add_update_btn"> Add new supplier</button>
                 <input type="hidden" id="tab_id" name="tab_id" value="<?php echo $tab_id;?>">
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>
<script>

if($('#supplier_frm').html())

	$('#supplier_frm').validator();
	
</script>