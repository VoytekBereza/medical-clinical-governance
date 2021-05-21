<div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add area:</h4>
        </div>
      </div>
      
      <hr />
       
      <div class="row">
        <form data-toggle="validator" role="form"  action="<?php echo SURL?>clinical-log/add-edit-area-process" method="post" name="add_edit_area_frm" id="add_edit_area_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
             
                <div class="form-group has-feedback">
                  <label>Area Name<span class="required">*</span></label>
                  <input type="text" class="form-control" name="location_area" id="location_area" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*" 
                  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"  value=""/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                
           <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"  name="add_area_btn"> Add new area</button>
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>


<script type="text/javascript">

if($('#add_edit_area_frm').html())

	$('#add_edit_area_frm').validator();

</script>