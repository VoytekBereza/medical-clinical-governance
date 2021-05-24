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
        <?php if($get_template_details['id']==""){?>
			<h2>Add New Template <small>Add New Template</small></h2>
			 <?php } else {?>
             <h2>Update Template <small>Update Template</small></h2>
             <?php }?>
			<div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form" id="add_new_template_frm" name="add_new_template_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>emailtemplates/add-new-template-process">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade <?php echo $cms_class_div?>" id="cms_tab" aria-labelledby="cms-tab">
                <div class="form-group has-feedback">
                  <label for="page-title">Email Title<span class="required">*</span> </label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="email_title" name="email_title" required="required" class="form-control" value="<?php echo filter_string($get_template_details['email_title'])?>">
                  	 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      				<div class="help-block with-errors"></div>  
                  </div>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="page-title">Email Subject<span class="required">*</span> </label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="email_subject" name="email_subject" required="required" class="form-control" value="<?php echo filter_string($get_template_details['email_subject'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      			   <div class="help-block with-errors"></div>   
                  </div>
                </div>
                
                <div class="form-group">
                  <label>Email Body</label>
                  <textarea class="ckeditor editor1" id="email_body" name="email_body" rows="14"><?php echo filter_string($get_template_details['email_body'])?></textarea>
                </div>
                <div class="form-group">
                  <label for="middle-name">Status<span class="required">*</span> </label>
                  <select name="status" id="status"  required="required" class="form-control">
                  <option value="1" <?php echo ($get_template_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                  <option value="0" <?php echo ($get_template_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <?php if($get_template_details['id']){?>
              <button type="submit" class="btn btn-success" name="new_template_btn" id="new_template_btn">Update</button>
              <input type="hidden" name="template_id" id="template_id" value="<?php echo filter_string($get_template_details['id'])?>" />
              <?php }else{?>
              <button type="submit" class="btn btn-success" name="new_template_btn" id="new_template_btn">Submit</button>
              <?php }//end if($get_template_details['id'])?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
