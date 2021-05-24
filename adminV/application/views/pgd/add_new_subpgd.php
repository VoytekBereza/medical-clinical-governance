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
        <?php if($subpgd_id==""){?>
			<h2>Add New <?php echo filter_string($pgd_details['pgd_name']);?> Sub PGD <small>Add New <?php echo filter_string($pgd_details['pgd_name']);?> Sub PGD</small></h2>
			 <?php } else {?>
             <h2>Update <?php echo filter_string($pgd_details['pgd_name']);?> Sub PGD <small>Update <?php echo filter_string($pgd_details['pgd_name']);?> Sub PGD</small></h2>
             <?php }?>
			<div class="clearfix"></div>
			</div>
        <form  data-toggle="validator" role="form" id="add_subpgd_frm" name="add_subpgd_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>pgd/add-new-subpgd-process">
          <div class="form-group has-feedback">
            <label for="last-name">Sub PGD Name<span class="required">*</span> </label>
            <div class="col-md-12 col-sm-6 col-xs-12">
              <input type="text" id="subpgd_name" name="subpgd_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo filter_string($get_subpgd_details['subpgd_name'])?>">
			 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
             <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="form-group">
            <label>PGD Body: </label>
            <textarea class="ckeditor editor1"  id="subpgd_certificate_body" name="subpgd_certificate_body" rows="14"><?php echo filter_string($get_subpgd_details['subpgd_certificate_body'])?></textarea>
          </div>
          <div class="form-group validate_msg">
            <label for="status">Status: </label>
            <select name="status" id="status" required="required" class="form-control">
                  <option value="1" <?php echo ($get_subpgd_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                  <option value="0" <?php echo ($get_subpgd_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
            </select>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
            <?php if($subpgd_id != ''){?>
            	<button type="submit" class="btn btn-success" name="new_subpgdpgd_btn" id="new_subpgdpgd_btn">Update</button>
                <input type="hidden" name="subpgd_id" id="subpgd_id" value="<?php echo $subpgd_id?>" readonly="readonly" />
            <?php }else{?>
            	<button type="submit" class="btn btn-success" name="new_subpgdpgd_btn" id="new_subpgdpgd_btn">Submit</button>
            <?php }?>
            </div>
          </div>
          <input type="hidden" name="pgd_id" id="pgd_id" value="<?php echo $pgd_id?>" readonly="readonly" />
        </form>
      </div>
    </div>
  </div>
</div>
