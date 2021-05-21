<div class="row" style="margin:0">
  <div class="col-md-12">
    <h1>Edit Organization</h1>
  </div>
</div>
<br />
<div class="row" style="margin:0">
  <form  data-toggle="validator" role="form" action="<?php echo base_url(); ?>organization/edit-organization-process" method="post" name="edit_org_frm" id="edit_org_frm" enctype="multipart/form-data" >
    <div class="col-sm-6 col-md-12 col-lg-12">
      <div class="form-group has-feedback">
          <label for="company_name">Company Name<span class="required">*</span></label>
          <input type="text" placeholder="Company Name" name="company_name" id="company_name"  required="required" value="<?php echo filter_string($organization_details['company_name']);?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)" maxlength="50">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
      </div>
      <div class="form-group  has-feedback">
          <label for="org_address">Address<span class="required">*</span></label>
          <input type="text" placeholder="Address" name="org_address" id="org_address" required="required" value="<?php echo filter_string($organization_details['address']);?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" >
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
          <label for="org_address">Post Code<span class="required">*</span></label>
          <input type="text" placeholder="Post Code" name="org_postcode" id="org_postcode" required="required" value="<?php echo filter_string($organization_details['postcode']);?>" class="form-control my_upper_class" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
          <label for="org_contact">Premises Phone No.<span class="required">*</span></label>
          <input type="text" placeholder="Contact Number" name="org_contact" id="org_contact" required="required" value="<?php echo filter_string($organization_details['contact_no']);?>" class="form-control" pattern="^(02|01)(?=.*[0-9])[0-9]{9,}$"  data-error="Please use allowed characters (Numbers, should start with 02 or 01 and length should be 11 numbers)"  maxlength="11">
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>
      </div>
      
      <div class="form-group has-feedback">
          <label for="org_country">Select Country<span class="required">*</span></label>
          <select name="org_country" id="org_country" class="form-control" required="required">
            <option value="" selected>Select Country</option>
            <?php
                    if(count($country_active_arr) > 0){
                        foreach($country_active_arr as $index => $country_arr){
                ?>
            <option value="<?php echo $country_arr['id']?>"  <?php if($country_arr['id'] == $organization_details['country_id']){?> selected="selected"<?php }?>><?php echo $country_arr['country_name']?></option>
            <?php			
                        }//end foreach($country_active_arr as $index => $cities_arr)
                        
                    }//end if(count($country_active_arr) > 0)
                    
                ?>
          </select>
          <div class="help-block with-errors"></div>
      </div>
      
      <div class="row" style="padding:0; margin:0">
      	<div class="col-md-6">
          <div class="form-group has-feedback">
              <label for="org_country">Upload Logo </label>
              <input type="file" name="org_logo" id="org_logo" />
              <small>	- Allowed extensions jpg, jpeg, gif, png <br />
                        - Recommended size 300 * 200 (w*h)
              </small>
              <div class="help-block with-errors"></div>
          </div>
        </div>

      	<div class="col-md-6">
        	<?php 
				if(filter_string($organization_details['org_logo'])){
			?>
            		<img src="<?php echo ORG_LOGO.filter_string($organization_details['org_logo'])?>" width="300" height="200" />
                    <br />
                    <label><input type="checkbox" name="remove_logo" id="remove_logo" value="1"> Remove Logo</label>
                    <input type="hidden" name="old_org_logo" value="<?php echo filter_string($organization_details['org_logo'])?>" readonly="readonly" />
            <?php		
				}else{
			?>
            	<img src="<?php echo IMAGES?>logo-placeholder.jpg" width="300" height="200" />
            <?php		
				}//end if(filter_string($organization_details['org_logo'])
			?>
        	
        </div>
        
      </div>
      
      <div class="form-group pull-right" style="margin-top:10px;">
        <button type="submit" class="btn btn-sm btn-success btn-block"  name="update_btn"> Update</button>
      </div>
    </div>
  </form>
</div>
<script>
$(document).ready(function(){
	
	$('#edit_org_frm').validator();
});
</script>