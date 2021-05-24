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
			<h2>Update Pharmacy <small>Update Pharmacy</small></h2> 
			<div class="clearfix"></div>
			</div>
<form  data-toggle="validator" role="form" action="<?php echo base_url(); ?>organization/add-update-pharmacy-surgery-process" method="post" name="form_pharmacy" id="form_pharmacy" >
          <div class="col-sm-6 col-md-12 col-lg-12">
            <div class="form-group has-feedback">
              <label id="pharmacy_surgery_select_label">Select Pharmacy / Surgery<span class="required">*</span></label>
              <select class="form-control pharmacy-surgery-type" name="type" required="required" <?php if($get_pharmacy_surgery_details['id']!=""){?> disabled="disabled"<?php }?> >
                <option value="">Select Pharmacy / Surgery</option>
                <option value="P" <?php if($get_pharmacy_surgery_details['type']=="P") {?> selected="selected"<?php }?>>Pharmacy</option>
                <option value="S"  <?php if($get_pharmacy_surgery_details['type']=="S") {?> selected="selected"<?php }?>>Surgery</option>
              </select>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group  has-feedback">
              <label id="pharmacy_surgery_name_label" >Pharmacy Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="pharmacy_surgery_name" id="pharmacy_surgery_name" value="<?php echo $get_pharmacy_surgery_details['pharmacy_surgery_name'];?>" required="required" pattern="[a-zA-z0-9 -]+([ '-][a-zA-Z0-9]+)*" data-error="Please use allowed characters (Alphabets, Numbers, Hyphens, Space)" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label id="pharmacy_surgery_address_label" >Pharmacy Address<span class="required">*</span></label>
              <input type="text" class="form-control" name="address" id="address" value="<?php echo $get_pharmacy_surgery_details['address'];?>" required="required" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label for"Country">Country<span class="required">*</span></label>
              <select class="form-control" name="country_id" id="country_id"  required="required" >
                <option value="">Select Country</option>
                <?php 
					
						if(!empty($get_all_country)){
							foreach($get_all_country as $value) :
					?>
				                <option value="<?php echo $value['id']?>" <?php if($value['id']==$get_pharmacy_surgery_details['country_id']) {?> selected="selected"<?php }?>><?php echo $value['country_name'];?></option>
                
				<?php 
					endforeach;
				 }?>
              </select>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label>Post Code<span class="required">*</span></label>
              <input type="text" class="form-control my_upper_class" name="postcode" id="postcode" value="<?php echo $get_pharmacy_surgery_details['postcode'];?>" required="required"  pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*"  data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label>Premises Phone Number<span class="required">*</span></label>
              <input type="text" class="form-control" name="contact_no" id="contact_no" value="<?php echo $get_pharmacy_surgery_details['contact_no'];?>" required="required"  pattern="^(02|01)(?=.*[0-9])[0-9]{9,}$"  data-error="Please use allowed characters (Numbers, should start with 02 or 01 and length should be 11 numbers)"  maxlength="11"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label>GPhC No (Optional)</label>
              <input type="text" class="form-control" name="gphc_no" value="<?php echo $get_pharmacy_surgery_details['gphc_no'];?>" pattern="^[0-9|]+[0-9|]*"  data-error="Please use only numbers" maxlength="10">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group">
              <label>F Code (Optional)</label>
              <input type="text" class="form-control" name="f_code" id="f_code" value="<?php echo $get_pharmacy_surgery_details['f_code'];?>" maxlength="10">
            </div>
            
            <div class="form-group pull-right">
              <?php if($get_pharmacy_surgery_details['id']!=""){?>
              <button type="submit" class="btn btn-sm btn-success btn-block"  name="add_update_btn"> Update</button>
              <input type="hidden" name="action" id="action" value="update" />
              <input type="hidden"  name="pharmacy_id" id="pharmacy_id" value="<?php echo $get_pharmacy_surgery_details['id'];?>"/>
              <?php } ?>
            </div>
          </div>
        </form>
        </div>
    </div>
  </div>
</div>
        