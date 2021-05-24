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
        <?php if($get_delivery_details['id']==""){?>
			<h2>Add New Delivery Method <small>Add New Delivery Method</small></h2>
			 <?php } else {?>
             <h2>Update Delivery Method <small>Update Delivery Method</small></h2>
             <?php }?>
			<div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form" id="add_new_delivery_frm" name="add_new_delivery_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>delivery/add-new-delivery-process">
                
          <div class="form-group has-feedback">
                  <label for="page-title">Delivery Method Title<span class="required">*</span> </label>
                    <input type="text" id="delivery_title" name="delivery_title" required="required" class="form-control" value="<?php echo filter_string($get_delivery_details['delivery_title'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				   <div class="help-block with-errors"></div>
                </div>
          <div class="form-group has-feedback">
                  <label for="page-title">Delivery Method Price (&pound) <span class="required">*</span> </label>
                    <input type="text" id="price" name="price" required="required" class="form-control" value="<?php echo filter_string($get_delivery_details['price'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                   <div class="help-block with-errors"></div>
          </div>
          
          <div class="form-group">
                  <label>Delivery Method Description</label>
                  <textarea class="ckeditor editor1" id="delivery_description" name="delivery_description" rows="14"><?php echo filter_string($get_delivery_details['delivery_description'])?></textarea>
                </div>    
       
          <div class="form-group">
          <label for="middle-name">Status<span class="required">*</span> </label>
          <select name="status" id="status"  required="required" class="form-control">
             <option value="1" <?php echo ($get_delivery_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
             <option value="0" <?php echo ($get_delivery_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
          </select>
          </div>     
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <?php if($get_delivery_details['id']){?>
                  <button type="submit" class="btn btn-success" name="new_delivery_btn" id="new_delivery_btn">Update</button>
                  <input type="hidden" name="delivery_id" id="delivery_id" value="<?php echo filter_string($get_delivery_details['id'])?>" />
              <?php }else{?>
	              <button type="submit" class="btn btn-success" name="new_delivery_btn" id="new_delivery_btn">Submit</button>
              <?php }//end if($get_delivery_details['id'])?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
