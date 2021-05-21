<?php 
if($this->uri->segment(3)){
 $tab_id =$this->uri->segment(3);	
}
?>
    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add prescriber:</h4>
        </div>
      </div>
      
       <hr />
       
      <div class="row">
        <form  data-toggle="validator" role="form" action="<?php echo SURL?>registers/add-edit-prescriber-process" method="post" name="prescriber_frm" id="prescriber_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
            
             <div class="form-group has-feedback">
              <label>First Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="first_name" id="first_name" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"  value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Last Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="last_name" id="last_name" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"  value="" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <label>Registering body GMC/NMC/GPhC<span class="required">*</span> </label>         
                <div class="row">
                <div class="form-group  has-feedback col-sm-6 col-md-12 col-lg-12">
                    <select class="form-control" id="register_body" name="register_body"  required="required">
                    	<option value="">Select Registering body</option>
                        <option value="GMC">GMC</option>
                        <option value="NMC">NMC</option>
                        <option value="GPhC">GPhC</option>
                    </select> 
                <div class="help-block with-errors"></div>
                </div>
                </div> <!-- ./row -->
                
            
            
             <div class="form-group has-feedback">
              <label>Registering No<span class="required">*</span></label>
              <input type="text" class="form-control" name="registering_no" id="registering_no" required="required" value="" maxlength="12"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            
             <div class="form-group has-feedback">
              <label>Address 1<span class="required">*</span></label>
              <input type="text" class="form-control" name="address" id="address" value="" required="required"  pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group has-feedback">
              <label>Address 2</label>
              <input type="text" class="form-control" name="address_2" id="address_2" value=""  pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50"/>
               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            
            <div class="form-group has-feedback">
              <label>Address 3</label>
              <input type="text" class="form-control" name="address_3" id="address_3" value="" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50"//>
               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Postcode<span class="required">*</span></label>
              <input type="text" class="form-control my_upper_class" name="postcode" id="postcode" value=""  required="required" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"   name="add_update_btn"> Add new prescriber</button>
                 <input type="hidden" id="tab_id" name="tab_id" value="<?php echo $tab_id;?>">
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>
<script type="text/javascript">

if($('#prescriber_frm').html())

	$('#prescriber_frm').validator();
	
</script>