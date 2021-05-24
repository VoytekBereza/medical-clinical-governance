<?php
	//Tabs Variables
	$cms_class = 'active';
	$cms_class_div = 'active in';
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php
            }//end if($this->session->flashdata('err_message'))
            
            if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="x_title">
                 <h2>Edit Governance <small>Edit Governance</small></h2>
             <div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form" id="update_governace_frm" name="update_governace_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>governance/edit-governance-process">
        
         <div class="" role="tabpanel" data-example-id="togglable-tabs">
          
            <div id="myTabContent" class="tab-content">
            
              <div role="tabpanel" class="tab-pane fade <?php echo $cms_class_div?>" id="cms_tab" aria-labelledby="cms-tab">
                <div class="row">
                <div class="form-group has-feedback">
                <label for="price">Price (&pound;):<span class="required">*</span> </label>
                <div class="col-md-12 col-sm-6 col-xs-12">
                <input type="number" id="price" name="price" required="required" placeholder="Price" class="form-control col-md-7 col-xs-12" value="<?php echo ($get_governance_details['price']) ? $get_governance_details['price'] : '0.00' ?>">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				 <div class="help-block with-errors"></div>
                </div>
                </div>
                 <div class="form-group has-feedback">
                    <label for="discount_price">Discount Price (&pound;):<span class="required">*</span> </label>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        <input type="number" id="discount_price" name="discount_price" placeholder="Discount Price" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($get_governance_details['discount_price']) ? $get_governance_details['discount_price'] : '0.00' ?>">
                        <p>Set to 0.00 if there is no discount price</p>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors"></div>
                    </div>
                 </div>
                 <div class="form-group has-feedback">
                    <label for="governance_expiry_months">Governance Expiry Months<span class="required">*</span> </label>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        <input type="digits" id="discount_price" name="governance_expiry_months" placeholder="Governance Expiry Months" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($get_governance_details['governance_expiry_months']) ? $get_governance_details['governance_expiry_months'] : '' ?>" data-error="Please enter a valid number" pattern="^[0-9]{1,}$" >
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				     <div class="help-block with-errors"></div>
                    </div>
                 </div>
                </div>
                
                <!--<div class="form-group validate_msg">
                  <label>Governance Description</label>
                  <textarea class="ckeditor editor1" id="governance_text" name="governance_text" required="required" rows="14"><?php echo filter_string($get_governance_details['governance_text'])?></textarea>
                </div>-->
                <div class="form-group validate_msg">
                  <label>SOP Description</label>
                  <textarea class="ckeditor editor1" id="sop_text" name="sop_text" required="required" rows="14"><?php echo filter_string($get_governance_details['sop_text'])?></textarea>
                </div>
                <!--<div class="form-group validate_msg">
                  <label>Finish Description</label>
                  <textarea class="ckeditor editor1" id="finish_text" name="finish_text" required="required" rows="14"><?php echo filter_string($get_governance_details['finish_text'])?></textarea>
                </div>-->
                
               </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <button type="submit" class="btn btn-success" name="update_btn" id="update_btn">Update</button>
              <input type="hidden" name="governance_id" id="governance_id" value="<?php echo filter_string($get_governance_details['id'])?>" />
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
