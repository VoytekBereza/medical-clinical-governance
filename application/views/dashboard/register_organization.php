<div class="panel panel-default"> 
  <!-- Default panel contents -->
  <div class="panel-heading"><strong>ORGANISATION DETAILS</strong></div>
  <div class="panel-body">
    <p class="align-left"></p>
    <div class="row">
      <div class="col-md-12"> 
            <form data-toggle="validator" role="form" action="<?php echo base_url(); ?>dashboard/register-organization-process" method="post" name="form_pharmacy" id="form_pharmacy" >
                  <div class="col-sm-6 col-md-12 col-lg-12">
                    
                    <div class="form-group  has-feedback">
                      <label id="pharmacy_surgery_name_label" >Company Name<span class="required">*</span></label>
                      <input type="text" placeholder="Company Name" name="company_name" id="company_name"  required="required" value="<?php echo $session_data['company_name'];?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)" maxlength="50">
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                      <label id="pharmacy_surgery_address_label" >Address<span class="required">*</span></label>
                      <input type="text" placeholder="Address" name="org_address" id="org_address" required="required" value="<?php echo $session_data['org_address'];?>" class="form-control" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" >
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                    
                    <div class="form-group has-feedback">
                      <label>Post Code<span class="required">*</span></label>
                      <input type="text" placeholder="Post Code" name="org_postcode" id="org_postcode" required="required" value="<?php echo $session_data['org_postcode'];?>" class="form-control my_upper_class" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8">
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                    
                    <div class="form-group has-feedback">
                      <label>Premises Phone Number<span class="required">*</span></label>
                      <input type="text" placeholder="Contact Number" name="org_contact" id="org_contact" required="required" value="<?php echo $session_data['org_contact'];?>" class="form-control" pattern="^(03|02|01)(?=.*[0-9])[0-9]{9,}$"  data-error="Please use allowed characters (Numbers, should start with 03 or 02 or 01 and length should be 11 numbers)"  maxlength="11">
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                    
                    <div class="form-group has-feedback">
                      <label for"Country">Country<span class="required">*</span></label>
                      <select name="org_country" id="org_country" class="form-control" required="required">
                        <option value="" selected>Select Country</option>
                        <?php
                                if(count($country_active_arr) > 0){
                                    foreach($country_active_arr as $index => $country_arr){
                            ?>
                        <option value="<?php echo $country_arr['id']?>"  <?php if($country_arr['id'] == $session_data['org_country']){?> selected="selected"<?php }?>><?php echo $country_arr['country_name']?></option>
                        <?php			
                                    }//end foreach($country_active_arr as $index => $cities_arr)
                                    
                                }//end if(count($country_active_arr) > 0)
                                
                            ?>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                    
                    <div class="form-group">
                    	<div class="col-md-8 text-right">
                        	<?php 
								if($this->session->user_type == 2){
							?>
		                            <label><input type="checkbox" name="is_si" value="1" /> Are you Superindendent? </label>
                            <?php			
								}//end if($this->session->user_type == 2)
							?>
                        	
                        </div>
                        <div class="col-md-4 text-right">
                              <button type="submit" class="btn btn-sm btn-success btn-block"   name="add_update_btn"> Add Organisation</button>
                              <input type="hidden" name="action" id="action" value="add" />
                        </div>
                    </div>
                  </div>
                </form>
      </div>
    </div>
  </div>
</div>
<script>
// Use for add edit pharmacy form validation
$('#form_pharmacy').validator();
</script>