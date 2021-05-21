<?php 
if($this->uri->segment(3)){
 $tab_id =$this->uri->segment(3);	
}
?>

    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add new register:</h4>
        </div>
      </div>
      
      <hr />
       
      <div class="row">
        <form  data-toggle="validator" role="form" action="<?php echo base_url(); ?>registers/add-edit-drug-process" method="post" name="add_drug_frm" id="add_drug_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
            
             <div class="form-group has-feedback">
              <label>Name of Medicine<span class="required">*</span></label>
              <input type="text" class="form-control" placeholder="medicine name" name="drug_name" id="drug_name" value="" required="required" pattern="[a-zA-z0-9\s\-,\]+[a-zA-Z0-9\s\-_,.'/]*" data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma, Apostrophe, Dot, Forward Slash, Back Slash, Space)" maxlength="50" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
           
            <div class="form-group has-feedback">
              <label>Form<span class="required">*</span></label>
              <input type="text" class="form-control" placeholder="medicine form" name="drug_form" id="drug_form" value="" required="required" pattern="[a-zA-z0-9\s\-,\]+[a-zA-Z0-9\s\-_,.'/]*" data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma, Apostrophe, Dot, Forward Slash, Back Slash, Space)" maxlength="50"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group has-feedback">
              <label>Strength<span class="required">*</span></label>
              <input type="text" class="form-control" placeholder="medicine strength" name="drug_strength" id="drug_strength" value="" required="required" pattern="[a-zA-z0-9\s\-,\]+[a-zA-Z0-9\s\-_,.'/]*" data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma, Apostrophe, Dot, Forward Slash, Back Slash, Space)" maxlength="50"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <?php if($tab_id !=5){?>
             <div class="form-group has-feedback">
              <label>Opening Balance<span class="required">*</span></label>
              <input  class="form-control" placeholder="quantity" name="opening_balance" id="opening_balance" value="" type="number" min="0" required="required"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <?php } ?>
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"   name="add_update_btn"> Add new register</button>
                <input type="hidden" id="tab_id" name="tab_id" value="<?php echo $tab_id;?>">
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>
<script type="text/javascript">

if($('#add_drug_frm').html())

	$('#add_drug_frm').validator();
	
</script>