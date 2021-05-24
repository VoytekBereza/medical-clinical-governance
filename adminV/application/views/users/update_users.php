<?php
	/*echo '<pre>';
	print_r($cities_selected_arr);
	exit;*/
	$cms_class = 'active';
	$cms_class_div = 'active in';
	
	if(!empty($cities_selected_arr)){
	
		foreach($cities_selected_arr as $index => $cities_arr_selected) {
	
		$arr_city_selected[]=$cities_arr_selected['city_id'];
	
		}
	
	}
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
			<h2>Update User <small>Update User</small></h2> 
			<div class="clearfix"></div>
			</div>
        <form  data-toggle="validator" role="form"   id="update_user_frm" name="update_user_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>users/update-users-process">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade <?php echo $cms_class_div?>" id="cms_tab" aria-labelledby="cms-tab">
               
                <div class="form-group">
                  <label for="page-title">User Type</label>
                  <div class="col-md-12 col-sm-6 col-xs-12 ">
                    <input type="text" id="usertype" name="usertype" readonly="readonly" class="form-control" value="<?php echo filter_string($get_users_details['user_name']);?>">
                  </div>
                </div>
               
                <div class="form-group has-feedback">
                  <label for="page-title">First Name<span class="required">*</span> </label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="first_name" name="first_name" required="required" class="form-control" value="<?php echo filter_string($get_users_details['first_name'])?>" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
                   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				   <div class="help-block with-errors"></div>
                  </div>
                </div>
          	     
                <div class="form-group has-feedback">
                  <label for="page-title">Last Name<span class="required">*</span> </label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="last_name" name="last_name" required="required" class="form-control" value="<?php echo filter_string($get_users_details['last_name'])?>"
                    pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     			  <div class="help-block with-errors"></div>
                  </div>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="page-title">Mobile<span class="required">*</span> </label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="digits" id="mobile_no" name="mobile_no" required="required" class="form-control" value="<?php echo filter_string($get_users_details['mobile_no'])?>"data-error="Mobile number should start with 07 and length should be 11 numbers."   pattern="^07(?=.*[0-9])[0-9]{9,}$"  maxlength="11">
                    
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     			  <div class="help-block with-errors"></div>
                  </div>
                </div>
                  <?php if($get_users_details['user_type']==1) {?>
               
                  <div class="form-group has-feedback">
                  <label for="page-title">GMC NO<span class="required">*</span> </label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="gmc_no" name="gmc_no" required="required" class="form-control" value="<?php echo filter_string($get_users_details['registration_no'])?>"   pattern="^[a-zA-Z0-9 -]+$"  data-error="Please use allowed characters (Alphabets, Numbers, Hyphens)" maxlength="15">
                    
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     			   <div class="help-block with-errors"></div>
                  </div>
                </div>
               
                 <?php } else if($get_users_details['user_type']==2){?>
                
                    <div class="form-group has-feedback">
                    <label for="page-title">GPhC NO<span class="required">*</span> </label>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="gphc_no" name="gphc_no" required="required" class="form-control" value="<?php echo filter_string($get_users_details['registration_no'])?>" pattern="^[a-zA-Z0-9 -]+$"  data-error="Please use allowed characters (Alphabets, Numbers, Hyphens)" maxlength="15"> 					
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     			     <div class="help-block with-errors"></div>
                    </div>
                    </div>
                    
                 <?php } else if($get_users_details['user_type']==3){?>    
               
                  <div class="form-group has-feedback">
                    <label for="page-title">NMC NO<span class="required">*</span> </label>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="nmc_no" name="nmc_no" required="required" class="form-control" value="<?php echo filter_string($get_users_details['registration_no'])?>"  pattern="^[a-zA-Z0-9 -]+$"  data-error="Please use allowed characters (Alphabets, Numbers, Hyphens)" maxlength="15">
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     			     <div class="help-block with-errors"></div>
                    </div>
                    </div>
                  <?php }?>  
                  
                  <div class="form-group has-feedback">
                  <label for="email_address">Email Address</label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="email" id="email_address" name="email_address" required="required" class="form-control" value="<?php echo filter_string($get_users_details['email_address'])?>"  pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" autocomplete="off" maxlength="255">
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      				<div class="help-block with-errors"></div>
                  </div>
                </div>
                
                <div class="form-group has-feedback">
                  <label for="org_country">Select Country<span class="required">*</span></label>
                  <select name="user_country" id="user_country" class="form-control" required="required">
                    <option value="" selected>Select Country</option>
                    <?php
                            if(count($country_active_arr) > 0){
                                foreach($country_active_arr as $index => $country_arr){
                        ?>
                    <option value="<?php echo $country_arr['id']?>"  <?php if($country_arr['id'] == $get_users_details['user_country']){?> selected="selected"<?php }?>><?php echo $country_arr['country_name']?></option>
                    <?php			
                                }//end foreach($country_active_arr as $index => $cities_arr)
                                
                            }//end if(count($country_active_arr) > 0)
                            
                        ?>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <label for="org_country">Select Buying Group</label>
                    <select name="org_buying_group" id="org_buying_group" class="form-control">
                      <option value="" selected>Select Buying Group</option>
                      <?php
                    if(count($buyinggroup_active_arr) > 0){
                      foreach($buyinggroup_active_arr as $index => $buyinggroup_arr){
                  ?>
                      <option value="<?php echo $buyinggroup_arr['id']?>"  <?php if($buyinggroup_arr['id'] == $get_users_details['buying_group_id']){?> selected="selected"<?php }?> ><?php echo $buyinggroup_arr['buying_groups']?></option>
                      <?php     
                      }//end foreach($buyinggroup_active_arr as $index => $buyinggroup_arr)
                      
                    }//end if(count($buyinggroup_active_arr) > 0)
                    
                  ?>
                    </select>
                    <div class="help-block with-errors"></div>
                  </div>
                
                <?php if($get_users_details['user_type']==2 || $get_users_details['user_type']==3){?>
 				
                  <div class="form-group" id="prescriber_div">
                    	<label for="is_prescriber">Are you a Prescriber?</label>
                    	<div class="radio">
                    	<label id="presc_radio_1">
                    	<input name="is_prescriber" value="1"  <?php if($get_users_details['is_prescriber']==1){?> checked="checked"<?php }?> type="radio">
                    	<span class="radio-label">Yes</span> </label>
                    	&nbsp;&nbsp;&nbsp;
                    	<label id="presc_radio_0">
                    	<input name="is_prescriber" value="0" <?php if($get_users_details['is_prescriber']==0 || $get_users_details['is_prescriber']!=1){?> checked="checked"<?php }?> type="radio">
                    	<span class="radio-label">No</span> </label>
                    	</div>
                    </div>
                    
                    <?php if($get_users_details['is_prescriber']==1) {?>
                    <div class="form-group" id="speciality_div">
                   <label for="speciality">Speciality</label>
                   <div class="col-md-12 col-sm-6 col-xs-12">
                    <input  placeholder="Speciality" name="speciality" id="speciality" value="<?php echo filter_string($get_users_details['speciality']);?>" class="form-control" type="text">
                  </div>
                </div>
                   
					<?php } else {?>
                    
                    <div class="form-group hidden" id="speciality_div">
                   <label for="speciality">Speciality</label>
                   <div class="col-md-12 col-sm-6 col-xs-12">
                    <input  placeholder="Speciality" name="speciality" id="speciality" value="" class="form-control" type="text">
                  </div>
                </div>
                <?php }?>
                <?php 
				}
				?>
             <?php if($get_users_details['user_type']!=6 && $get_users_details['user_type']!=7){?>
 				
                    <div class="form-group" id="locum_div">
                <label for="is_locum">Are you a Locum?</label>
                <div class="radio">
                <label data-initialize="radio" id="locum_radio_1">
                <input name="is_locum" value="1" <?php if($get_users_details['is_locum']==1){?> checked="checked"<?php }?> type="radio">
                <span class="radio-label">Yes</span> </label>
                &nbsp;&nbsp;&nbsp;
                <label data-initialize="radio" id="locum_radio_0">
                <input name="is_locum" value="0" <?php if($get_users_details['is_locum']==0 || $get_users_details['is_locum']!=1){?> checked="checked"<?php }?> type="radio">
                <span class="radio-label">No</span> </label>
                </div>
                </div>
                    <?php if($get_users_details['is_locum']==1){?> 
                    <div class="form-group" id="location_div">
                      <select data-placeholder="Choose your location..." class="chosen-location" multiple name="location_arr[]" id="location_arr">
                        <option value=""></option>
                            <?php
								if(!empty($cities_active_arr)){
								
									if(count($cities_active_arr) > 0){
								
										foreach($cities_active_arr as $index => $cities_arr_val){
								        if(!empty($arr_city_selected)){
                            ?>				
                            					<option value="<?php echo $cities_arr_val['id'];?>" <?php if(in_array($cities_arr_val['id'],$arr_city_selected)) {?> selected="selected" <?php }?>> <?php echo filter_string($cities_arr_val['city_name'])?></option>  
                            				
                            <?php			
										
										} else{
											?>
                                            <option value="<?php echo $cities_arr_val['id'];?>" > <?php echo filter_string($cities_arr_val['city_name'])?></option>
                                       <?php      
										}
										
                            ?>				
                            					
                            				
                            <?php			
										}
								     }//end foreach($cities_active_arr as $index => $cities_arr)
                                    
                                  }//end if(count($usertype_active_arr) > 0)
								
								
                            ?>
                      </select>
    				</div>
                    
                 	<?php } else {?>
                    
                    <div class="form-group hidden" id="location_div">
                      <select data-placeholder="Choose your location..." class="chosen-location" multiple name="location_arr[]" id="location_arr">
                        <option value=""></option>
                            <?php
                                if(count($cities_active_arr) > 0){
                                    foreach($cities_active_arr as $index => $cities_arr){
                            ?>
                                        <option value="<?php echo $cities_arr['id']?>"><?php echo filter_string($cities_arr['city_name']);?></option>
                            <?php			
                                    }//end foreach($cities_active_arr as $index => $cities_arr)
                                    
                                }//end if(count($usertype_active_arr) > 0)
                                
                            ?>
                      </select>
    				</div>

                <?php 
				     }
				}
				?>
                <div class="form-group has-feedback">
                  <label for="email_address">Password</label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="password" placeholder="Password" name="password" id="password" class="form-control" data-toggle="tooltip" data-error="Password must be between 8 to 30 characters with atleast one uppercase, one lowercase and one digit.  Allowed characters (Alphabet, Numbers, !@£$%^&*())" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9!@#$%^&*()]{8,30}$"  autocomplete="off">
        			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
       				<div class="help-block with-errors"></div>
                  </div>
                </div>
               </div>
             </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <?php if($get_users_details['id']){?>
              <button type="submit" class="btn btn-success" name="new_users_btn" id="new_users_btn">Update</button>
              <input type="hidden" name="users_id" id="users_id" value="<?php echo filter_string($get_users_details['id'])?>" />
              <input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo filter_string($get_users_details['user_type'])?>" />
              
              <?php }//end if($get_users_details['id'])?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>