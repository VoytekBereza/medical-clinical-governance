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
        <?php if($prescriber_detail['id']==""){?>
			<h2>Add Online Doctor Prescriber <small>Add New Online Doctor Prescriber</small></h2>
			 <?php } else {?>
             <h2>Update Online Doctor Prescriber <small>Update Online Doctor Prescriber</small></h2>
             <?php }?>
			<div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form"  id="add_new_presc" name="add_new_presc" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>settings/add-edit-online-prescriber-process">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            
                <div class="form-group has-feedback">
                  <label for="page-title">First Name<span class="required">*</span> </label>
                    <input type="text" id="first_name" name="first_name" required="required" class="form-control" value="<?php echo filter_string($prescriber_detail['first_name'])?><?php echo $this->session->flashdata('post_data')['first_name']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Last Name<span class="required">*</span> </label>
                    <input type="text" id="last_name" name="last_name" required="required" class="form-control" value="<?php echo filter_string($prescriber_detail['last_name'])?><?php echo $this->session->flashdata('post_data')[last_name]; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Contact No </label>
                    <input type="text" id="contact_no" name="contact_no"  class="form-control" value="<?php echo filter_string($prescriber_detail['contact_no'])?><?php echo $this->session->flashdata('post_data')['contact_no']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Registration Type <span class="required">*</span></label>
                    <select id="reg_type" name="reg_type"  class="form-control" required>
                    	<option value="">Select</option>
                    	<option value="GMC" <?php echo ($prescriber_detail['reg_type'] == 'GMC') ? 'selected="selected"' : ''?> <?php echo ($this->session->flashdata('post_data')['reg_type'] == 'GMC') ? 'selected="selected"' : '' ?>>GMC</option>
                        <option value="GPhC" <?php echo ($prescriber_detail['reg_type'] == 'GPhC') ? 'selected="selected"' : ''?> <?php echo ($this->session->flashdata('post_data')['reg_type'] == 'GPhC') ? 'selected="selected"' : '' ?>>GPhC</option>
                        <option value="NMC" <?php echo ($prescriber_detail['reg_type'] == 'NMC') ? 'selected="selected"' : ''?> <?php echo ($this->session->flashdata('post_data')['reg_type'] == 'NMC') ? 'selected="selected"' : '' ?>>NMC</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="page-title">Registration No <span class="required">*</span></label>
                    <input type="text" id="reg_no" name="reg_no"  class="form-control" value="<?php echo filter_string($prescriber_detail['reg_no'])?><?php echo $this->session->flashdata('post_data')['reg_no']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                
                
                <div class="form-group has-feedback">
                  <label for="page-title">Email Address<span class="required">*</span> </label>
                    <input type="text" id="email_address" name="email_address" required="required" class="form-control" value="<?php echo filter_string($prescriber_detail['email_address'])?><?php echo $this->session->flashdata('post_data')['email_address']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="page-title">Password<span class="required">*</span> </label>
                    <input type="password" id="password" name="password" <?php echo ($prescriber_detail['id']) ? '' : 'required="required"' ?>  class="form-control" value="">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Organisation Name<span class="required">*</span> </label>
                    <input type="text" id="organization_name" name="organization_name" class="form-control" value="<?php echo filter_string($prescriber_detail['organization_name'])?><?php echo $this->session->flashdata('post_data')['organization_name']; ?>" required>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Address 1<span class="required">*</span> </label>
                    <input type="text" id="address_1" name="address_1" class="form-control" value="<?php echo filter_string($prescriber_detail['address_1'])?><?php echo $this->session->flashdata('post_data')['address_1']; ?>" required>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Address 2 </label>
                    <input type="text" id="address_2" name="address_2" class="form-control" value="<?php echo filter_string($prescriber_detail['address_2'])?><?php echo $this->session->flashdata('post_data')['address_2']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Address 3 </label>
                    <input type="text" id="address_3" name="address_3" class="form-control" value="<?php echo filter_string($prescriber_detail['address_3'])?><?php echo $this->session->flashdata('post_data')['address_3']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">City/ town</label>
                    <input type="text" id="town" name="town" class="form-control" value="<?php echo filter_string($prescriber_detail['town'])?><?php echo $this->session->flashdata('post_data')['town']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">County</label>
                    <input type="text" id="county" name="county" class="form-control" value="<?php echo filter_string($prescriber_detail['county'])?><?php echo $this->session->flashdata('post_data')['county']; ?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Postcode <span class="required">*</span></label>
                    <input type="text" id="postcode" name="postcode" class="form-control" value="<?php echo filter_string($prescriber_detail['postcode'])?><?php echo $this->session->flashdata('post_data')['postcode']; ?>" required>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Upload Signature <span class="required">*</span> </label>
                    <input type="file" id="signature_file" name="signature_file"  value="" <?php echo ($prescriber_detail['id']) ? '' : 'required="required"' ?> accept=".gif,.jpg,.jpeg,.png">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <?php 
						if($prescriber_detail['signature_file'] != ''){
					?>
                    <img src="<?php echo FRONT_SURL?>assets/prescriber_files/<?php echo filter_string($prescriber_detail['signature_file'])?>" width="150" />
                    <?php 
						}//end if($prescriber_detail['signature_file'] != '')
					?>
                </div>

                <div class="form-group has-feedback">
                  <label for="page-title">Upload Stamp <span class="required">*</span> </label>
                    <input type="file" id="stamp_file" name="stamp_file"  value="" <?php echo ($prescriber_detail['id']) ? '' : 'required="required"' ?> accept=".gif,.jpg,.jpeg,.png">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

                    <?php 
						if($prescriber_detail['stamp_file'] != ''){
					?>
                    <img src="<?php echo FRONT_SURL?>assets/prescriber_files/<?php echo filter_string($prescriber_detail['stamp_file'])?>" width="150" />
                    <?php 
						}//end if($prescriber_detail['signature_file'] != '')
					?>
                    
                </div>

                <div class="form-group">
                  <label for="middle-name">Status<span class="required">*</span> </label>
                  <select name="status" id="status"  required="required" class="form-control">
                 	 <option value="1" <?php echo ($prescriber_detail['status'] == '1') ? 'selected="selected"' : '' ?> <?php echo ($this->session->flashdata('post_data')['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                 	 <option value="0" <?php echo ($prescriber_detail['status'] == '0') ? 'selected="selected"' : '' ?> <?php echo ($this->session->flashdata('post_data')['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                  </select>
                </div>
              </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-12  col-xs-12 text-right">
            	<a class="btn btn-danger" href="<?php echo SURL?>settings/online-doctor-prescribers" >Back</a>
              <?php if($prescriber_detail['id']){?>
                  <button type="submit" class="btn btn-success" name="new_page_btn" id="new_page_btn">Update</button>
                  <input type="hidden" name="pres_id" id="pres_id" value="<?php echo filter_string($prescriber_detail['id'])?>" />
              <?php }else{?>
	              <button type="submit" class="btn btn-success" name="new_presc_btn" id="new_presc_btn">Submit</button>
              <?php }//end if($buying_groups_dtails['id'])?>
              
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>