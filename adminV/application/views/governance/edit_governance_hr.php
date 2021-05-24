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
             <h2>Update Governance HR <small>Update Governance HR</small></h2>
			<div class="clearfix"></div>
			</div>
        <form   id="add_new_governance_hr_frm" name="add_new_governance_hr_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>governance/edit-governance-hr-process">
                 <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group validate_msg">
                           <label for="middle-name">Select Pharmacy / Surgery </label>
                              <select required="required" class="form-control" id="pharmacy_surgery" name="pharmacy_surgery" aria-required="true"  <?php if($get_governance_hr_details['user_type']!=""){?>disabled="disabled"<?php }?>>
                                    <option selected="" value="">Select Pharmacy / Surgery</option>
        	                        <option value="P" <?php if($get_governance_hr_details['pharmacy_surgery']=='P'){?> selected="selected"<?php }?>>Pharmacy</option>
                                    <option value="S" <?php if($get_governance_hr_details['pharmacy_surgery']=='S'){?> selected="selected"<?php }?>>Surgery</option>
                                   
      						</select>
                        </div>
                        <?php if($get_governance_hr_details['user_type']!=''){?>
                           <div class="form-group validate_msg">
                           		<label for="middle-name">Select User Type </label>
                              		<select required="required" class="form-control" id="user_type" name="user_type" aria-required="true" disabled="disabled">
                                    	<option selected="" value="">Select User Type</option>
        	                        	<option value="1" <?php if($get_governance_hr_details['user_type']=='1'){?> selected="selected"<?php }?>>Doctor</option>
                                    	<option value="2" <?php if($get_governance_hr_details['user_type']=='2'){?> selected="selected"<?php }?>>Pharmacist</option>
                                    	<option value="3" <?php if($get_governance_hr_details['user_type']=='3'){?> selected="selected"<?php }?>>Nurse</option>
                                    	<option value="4" <?php if($get_governance_hr_details['user_type']=='4'){?> selected="selected"<?php }?>>Pharmacy Assistance</option>
                                    	<option value="5" <?php if($get_governance_hr_details['user_type']=='5'){?> selected="selected"<?php }?>>Technician</option>
                                    	<option value="6" <?php if($get_governance_hr_details['user_type']=='6'){?> selected="selected"<?php }?>>Pre-reg</option>
                                    	<option value="7" <?php if($get_governance_hr_details['user_type']=='7'){?> selected="selected"<?php }?>>None Health Professional</option>
      							 	</select>
                        </div>
                        <?php }?>
                         <div class="form-group validate_msg">
                  			<label>HR Description</label>
                  			<textarea class="ckeditor editor1" id="hr_text" name="hr_text" rows="14"><?php echo filter_string($get_governance_hr_details['hr_text'])?></textarea>
                		</div>
          
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             				 			<button type="submit" class="btn btn-success" name="new_governace_hr_btn" id="new_governace_hr_btn">Update</button>
              							<input type="hidden" name="governance_id" id="governance_id" value="<?php echo filter_string($get_governance_hr_details['id'])?>" />
             				</div>
          	  </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
