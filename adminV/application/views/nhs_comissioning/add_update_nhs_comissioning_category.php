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
         <?php if($get_nhs_comissioning_category_details['id']==""){?>
			<h2>Add New NHS Comissioning Category <small>Add New NHS Comissioning Category</small></h2>
			 <?php } else {?>
            <h2>Update NHS Comissioning Category <small>Update NHS Comissioning Category</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
        <form  data-toggle="validator" role="form" id="add_new_nhs_comissioning_category_frm" name="add_new_nhs_comissioning_category_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>nhs-comissioning/add-new-nhs-comissioning-category-process">
                 <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          	<div class="form-group has-feedback">
                            <label>Category Name<span class="required">*</span> </label>
                            <input type="text" id="category_name" name="category_name" required="required" class="form-control" value="<?php echo filter_string($get_nhs_comissioning_category_details['category_name'])?>">
                         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				   		<div class="help-block with-errors"></div>
                        </div>
                          <div class="form-group validate_msg">
                              <label for="middle-name">Status<span class="required">*</span> </label>
                              <select name="status" id="status"  required="required" class="form-control">
                                      <option value="1" <?php echo ($get_nhs_comissioning_category_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($get_nhs_comissioning_category_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                              </select>
                        </div>
          
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_nhs_comissioning_category_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_category_btn" id="new_category_btn">Update</button>
              							<input type="hidden" name="category_id" id="category_id" value="<?php echo filter_string($get_nhs_comissioning_category_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_category_btn" id="new_category_btn">Submit</button>
              				<?php }//end if($get_nhs_comissioning_category_details['id'])?>
            		</div>
          	  </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
