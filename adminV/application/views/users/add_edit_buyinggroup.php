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
        <?php if($buying_groups_dtails['id']==""){?>
			<h2>Add New Group<small>Add New Group</small></h2>
			 <?php } else {?>
             <h2>Update Buyning Group <small>Update Buyning Group </small></h2>
             <?php }?>
			<div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form"  id="add_new_group" name="add_new_group" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>users/add-edit-group-process">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            
                <div class="form-group has-feedback">
                  <label for="page-title">Buying Group Name<span class="required">*</span> </label>
                    <input type="text" id="buying_groups" name="buying_groups" required="required" class="form-control" value="<?php echo filter_string($buying_groups_dtails['buying_groups'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Affliate Name<span class="required">*</span> </label>
                    <input type="text" id="url_slug" name="url_slug" required="required" class="form-control" value="<?php echo filter_string($buying_groups_dtails['url_slug'])?>" <?php echo ($buying_groups_dtails['id']) ? 'disabled="disabled"' : ''?> >
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="page-title">First Name<span class="required">*</span> </label>
                    <input type="text" id="first_name" name="first_name" required="required" class="form-control" value="<?php echo filter_string($buying_groups_dtails['first_name'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="page-title">Last Name<span class="required">*</span> </label>
                    <input type="text" id="last_name" name="last_name" required="required" class="form-control" value="<?php echo filter_string($buying_groups_dtails['last_name'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback">
                  <label for="page-title">Contact No </label>
                    <input type="text" id="contact_no" name="contact_no"  class="form-control" value="<?php echo filter_string($buying_groups_dtails['contact_no'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                
                
                <div class="form-group has-feedback">
                  <label for="page-title">Email Address<span class="required">*</span> </label>
                    <input type="text" id="email_address" name="email_address" required="required" class="form-control" value="<?php echo filter_string($buying_groups_dtails['email_address'])?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="page-title">Password<span class="required">*</span> </label>
                    <input type="password" id="password" name="password" <?php ($buying_groups_dtails['id']) ? '' : 'required="required"' ?>  class="form-control" value="">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group">
                  <label for="middle-name">Status<span class="required">*</span> </label>
                  <select name="status" id="status"  required="required" class="form-control">
                 	 <option value="1" <?php echo ($buying_groups_dtails['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                 	 <option value="0" <?php echo ($buying_groups_dtails['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                  </select>
                </div>
              </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-12  col-xs-12 text-right">
            	<a class="btn btn-danger" href="<?php echo SURL?>users/buying-groups" >Back</a>
              <?php if($buying_groups_dtails['id']){?>
                  <button type="submit" class="btn btn-success" name="new_page_btn" id="new_page_btn">Update</button>
                  <input type="hidden" name="group_id" id="group_id" value="<?php echo filter_string($buying_groups_dtails['id'])?>" />
              <?php }else{?>
	              <button type="submit" class="btn btn-success" name="new_group_btn" id="new_group_btn">Submit</button>
              <?php }//end if($buying_groups_dtails['id'])?>
              
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
