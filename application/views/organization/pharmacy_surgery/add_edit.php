<?php if($get_pharmacy_surgery_details['id'] !=''){ ?>

<div class="nav nav-bar"> 
  <!-- Stat - Governance tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#pharmacysurgery">PHARMACY OR CLINIC</a></li>
    <li><a data-toggle="tab" href="#globalsettings">LOCATION SETTINGS</a></li>
    <li><a data-toggle="tab" href="#times">SET OPENING TIMES</a></li>
  </ul>
</div>

<!--Start Body--> 
<br>
<div class="tab-content">
  <div id="globalsettings" class="tab-pane fade">
    <div class="nav nav-bar">
      <div class="panel panel-default"> 
        
        <!-- Default panel contents -->
        <div class="panel-heading">
        	<strong>
				<?php 
					if($get_pharmacy_surgery_details['type'] == 'P')
						echo 'PHARMACY' ;
					elseif($get_pharmacy_surgery_details['type'] == 'S')
						echo 'CLINIC';
					elseif($get_pharmacy_surgery_details['type'] == 'W')
						echo 'WHOLE SALE DEALER';
						
				?> 
                LOCATION SETTINGS
        	</strong>
        </div>
        <div class="panel-body">
          <p class="align-left"></p>
          <div class="row">
            <div class="col-md-12"> 
              
              <!-- Start - Global Settings -->
              <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <input <?php if($governance_purchase_status == 0) { ?> disabled="disabled" <?php } ?> type="checkbox" class="kod-switch" name="governance_status" id="<?php echo $get_pharmacy_surgery_details['id'];?>" value="1" <?php echo ($pharmacy_surgery['governance_status']) ? 'checked="checked"' : ''?>>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <label>Governance</label>
                </div>
              </div>
              <div class="row">
                <p>&nbsp;</p>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <input type="checkbox" name="online_doctor_status" id="<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['online_doctor_status']) ? 'checked="checked"' : ''?>>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <label>Online Doctor</label>
                </div>
              </div>
              <div class="row">
                <p>&nbsp;</p>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <input type="checkbox" name="survey_status" id="<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['survey_status']) ? 'checked="checked"' : ''?>>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <label>Survey</label>
                </div>
              </div>
              <div class="row">
                <p>&nbsp;</p>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <input type="checkbox" name="pmr_status" id="<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['pmr_status']) ? 'checked="checked"' : ''?>>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <label>PMR</label>
                </div>
              </div>
              <div class="row">
                <p>&nbsp;</p>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <input type="checkbox" name="travel_vaccine_status" id="<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['travel_vaccine_status']) ? 'checked="checked"' : ''?>>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <label>Are you doing travel?</label>
                </div>
              </div>
              <div class="row">
                <p>&nbsp;</p>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <input type="checkbox" name="flu_vaccine_status" id="<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['flu_vaccine_status']) ? 'checked="checked"' : ''?>>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <label>Are you doing Flu?</label>
                </div>
              </div>
              <div class="row">
                <p>&nbsp;</p>
              </div>
              <!--<div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <input type="checkbox" name="todolist_status" id="< ?php echo $pharmacy_surgery['id']; ?>" class="kod-switch" value="1" < ?php echo ($pharmacy_surgery['global_settings']['todolist_status']) ? 'checked="checked"' : ''?>>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label>To Do List</label>
                                    </div>
                                    
                                </div>--> 
              <!-- Input field to set action as [ update settings for the pharmacy_surgery_id ] -->
              <input type="hidden" name="update_pharmacy_surgery_settings" value="1" />
              <input type="hidden" name="pharmacy_surgery_id" value="<?php echo $get_pharmacy_surgery_details['id'];?>" />
              <!-- End - Global Settings --> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="times" class="tab-pane fade">
    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default"> 
        
        <!-- Default panel contents -->
        <div class="panel-heading"><strong>OPENING TIMES: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<strong>CLOSING TIMES:</strong></div>
        <div class="panel-body">
          <p class="align-left"></p>
          <form name="pharmacy_surgery_timings_frm" id="pharmacy_surgery_timings_frm" action="#" method="post" class="form_validate">
            <span id="succes_msg_span<?php echo $get_pharmacy_surgery_details['id'];?>"  class="alert alert-success col-md-12" style="display:none;"></span>
            <div class="row">
              <div class="col-md-12"> 
                <!-- Start - Global Settings -->
                <div class="col-sm-12 col-md-12 col-lg-12 msg_validate">
                  <label>Saturday:</label>
                  <span class="pull-right">
                  <input type="checkbox" name="is_sat_closed" id="is_sat_closed<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch2"  value="1" <?php echo ($pharmacy_surgery_time_settings['is_sat_closed']) ? 'checked="checked"' : ''?> data-size="mini" >
                  </span> </div>
                <br />
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Opening</span> <span class="add-on">
                      <input id="sat_open_timings" data-format="hh:mm" name="sat_open_timings" type="time" value="<?php if($pharmacy_surgery_time_settings['sat_open_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['sat_open_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time_class time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Closing</span> <span class="add-on">
                      <input id="sat_close_timings" data-format="hh:mm"  name="sat_close_timings" type="time" value="<?php if($pharmacy_surgery_time_settings['sat_close_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['sat_close_timings'];?><?php } else { echo '00:00';}?>"  class="form-control input-small time_class time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br/>
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <label>Sunday:</label>
                  <span class="pull-right">
                  <input type="checkbox" name="is_sun_closed" id="is_sun_closed<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch2" value="1" <?php echo ($pharmacy_surgery_time_settings['is_sun_closed']) ? 'checked="checked"' : ''?> data-size="mini" >
                  </span> </div>
                <br />
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Opening</span> <span class="add-on">
                      <input id="sun_open_timings" data-format="hh:mm" name="sun_open_timings" value="<?php if($pharmacy_surgery_time_settings['sun_open_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['sun_open_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Closing</span> <span class="add-on">
                      <input id="sun_close_timings" data-format="hh:mm" name="sun_close_timings" value="<?php if($pharmacy_surgery_time_settings['sun_close_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['sun_close_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <label>Monday:</label>
                  <span class="pull-right">
                  <input type="checkbox" name="is_mon_closed" id="is_mon_closed<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch2" value="1"  <?php echo ($pharmacy_surgery_time_settings['is_mon_closed']) ? 'checked="checked"' : ''?> data-size="mini" >
                  </span> </div>
                <br />
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Opening</span> <span class="add-on">
                      <input id="mon_open_timings" data-format="hh:mm" name="mon_open_timings" value="<?php if($pharmacy_surgery_time_settings['mon_open_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['mon_open_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Closing</span> <span class="add-on">
                      <input id="mon_close_timings" data-format="hh:mm" name="mon_close_timings" value="<?php if($pharmacy_surgery_time_settings['mon_close_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['mon_close_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <label>Tuesday:</label>
                  <span class="pull-right">
                  <input type="checkbox" name="is_tue_closed" id="is_tue_closed<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch2" value="1"  <?php echo ($pharmacy_surgery_time_settings['is_tue_closed']) ? 'checked="checked"' : ''?>data-size="mini" >
                  </span> </div>
                <br />
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Opening</span> <span class="add-on">
                      <input id="tue_open_timings" data-format="hh:mm" name="tue_open_timings" value="<?php if($pharmacy_surgery_time_settings['tue_open_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['tue_open_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Closing</span> <span class="add-on">
                      <input id="tue_close_timings" data-format="hh:mm" name="tue_close_timings" value="<?php if($pharmacy_surgery_time_settings['tue_close_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['tue_close_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <label>Wednesday:</label>
                  <span class="pull-right">
                  <input type="checkbox" name="is_wed_closed" id="is_wed_closed<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch2" value="1"  <?php echo ($pharmacy_surgery_time_settings['is_wed_closed']) ? 'checked="checked"' : ''?> data-size="mini" >
                  </span> </div>
                <br />
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Opening</span> <span class="add-on">
                      <input id="wed_open_timings" data-format="hh:mm" name="wed_open_timings" value="<?php if($pharmacy_surgery_time_settings['wed_open_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['wed_open_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Closing</span> <span class="add-on">
                      <input id="wed_close_timings" data-format="hh:mm" name="wed_close_timings" value="<?php if($pharmacy_surgery_time_settings['wed_close_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['wed_close_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br/>
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <label>Thursday:</label>
                  <span class="pull-right">
                  <input type="checkbox" name="is_thu_closed" id="is_thu_closed<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch2" value="1"  <?php echo ($pharmacy_surgery_time_settings['is_thu_closed']) ? 'checked="checked"' : ''?> data-size="mini" >
                  </span> </div>
                <br />
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Opening</span> <span class="add-on">
                      <input id="thu_open_timings" data-format="hh:mm" name="thu_open_timings" value="<?php if($pharmacy_surgery_time_settings['thu_open_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['thu_open_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Closing</span> <span class="add-on">
                      <input id="thu_close_timings" data-format="hh:mm" name="thu_close_timings" value="<?php if($pharmacy_surgery_time_settings['thu_close_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['thu_close_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <label>Friday:</label>
                  <span class="pull-right">
                  <input type="checkbox" name="is_fri_closed" id="is_fri_closed<?php echo $get_pharmacy_surgery_details['id'];?>" class="kod-switch2" value="1"  <?php echo ($pharmacy_surgery_time_settings['is_fri_closed']) ? 'checked="checked"' : ''?> data-size="mini" >
                  </span> </div>
                <br />
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Opening</span> <span class="add-on">
                      <input id="fri_open_timings" data-format="hh:mm" name="fri_open_timings" value="<?php if($pharmacy_surgery_time_settings['fri_open_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['fri_open_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="input-group input-append"> <span class="input-group-addon">Closing</span> <span class="add-on">
                      <input id="fri_close_timings" data-format="hh:mm" name="fri_close_timings" value="<?php if($pharmacy_surgery_time_settings['fri_close_timings']!=""){?><?php echo $pharmacy_surgery_time_settings['fri_close_timings'];?><?php } else { echo '00:00';}?>" class="form-control input-small time" readonly="readonly">
                      </span> </div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <button  type="button" class="btn btn-xs btn-success  save-time-btn" onClick="save_time('<?php echo $get_pharmacy_surgery_details['id'];?>','<?php echo $pharmacy_surgery_time_settings['id']; ?>')" id="<?php echo $pharmacy_surgery_time_settings['id']; ?>">Save Timings</button>
                    <input type="hidden" id="pharmacy_surgery_global_id" name="pharmacy_surgery_global_id" value="<?php echo $get_pharmacy_surgery_details['id'];?>">
                    <input type="hidden" id="pharmacy_surgery_timings_id" name="pharmacy_surgery_timings_id" value="<?php echo  $pharmacy_surgery_time_settings['id'];?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- End - Row --> 
            <!-- End - Global Settings -->
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php }// end if($get_pharmacy_surgery_details['id'] !=''){ ?>
  <!-- Start - Add New Pharmacy / Sergery -->
  
  <div id="pharmacysurgery" class="tab-pane fade in active">
    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h1><?php echo ($get_pharmacy_surgery_details['id'] !="" ) ? 'Edit Location' : 'Add Location'?></h1>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 text-right" style="margin-top:30px;">

			<?php 
                if(count($organization_pharmacy_list) == 0){
            ?>
                <a class="btn btn-sm btn-primary" onclick="import_org_data('<?php echo $organization_data['company_name']?>','<?php echo $organization_data['address']?>','<?php echo $organization_data['postcode']?>','<?php echo $organization_data['country_id']?>','<?php echo $organization_data['contact_no']?>')">Copy organisation details</a>
            <?php }?>
        
        </div>
      </div>
      <br />
      
      <div class="row">
        <form  data-toggle="validator" role="form" action="<?php echo base_url(); ?>organization/add-update-pharmacy-surgery-process" method="post" name="form_pharmacy" id="form_pharmacy" >
          <div class="col-sm-6 col-md-12 col-lg-12">
            <div class="form-group has-feedback">
              <label id="pharmacy_surgery_select_label">Select Location<span class="required">*</span></label>
              <select class="form-control pharmacy-surgery-type" name="type" required="required" <?php if($get_pharmacy_surgery_details['id']!=""){?> disabled="disabled"<?php }?> >
                <option value="">Select Pharmacy / Clinic/ WDA</option>
                <?php 
					if($this->session->user_type == 3){

						if($get_pharmacy_surgery_details){
							//If user type is nurse but its in edit mode, shw Pharmacy in read only more only
				?>
                			<option value="P" <?php if($get_pharmacy_surgery_details['type']=="P") {?> selected="selected"<?php }?>>Pharmacy</option>
                <?php			
						}//end if($get_pharmacy_surgery_details)
						
					}else{
						//Nurses SI or owner are not allowed to add the Pharmacies, only Clinics are allowed
				?>
						<option value="P" <?php if($get_pharmacy_surgery_details['type']=="P") {?> selected="selected"<?php }?>>Pharmacy</option>
                <?php
					}//end if($this->session->user_type != 3)
                ?>
                <option value="S"  <?php if($get_pharmacy_surgery_details['type']=="S") {?> selected="selected"<?php }?>>Clinic</option>
                <option value="W" <?php if($get_pharmacy_surgery_details['type']=="W") {?> selected="selected"<?php }?>>Wholesale Dealer Authorisation</option>
              </select>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group  has-feedback">
              <label><span id="pharmacy_surgery_name_label">Pharmacy Name</span><span class="required">*</span></label>
              <input type="text" class="form-control" name="pharmacy_surgery_name" id="pharmacy_surgery_name" value="<?php echo $get_pharmacy_surgery_details['pharmacy_surgery_name'];?>" required="required" pattern="[a-zA-z0-9 -]+([ '-][a-zA-Z0-9]+)*" data-error="Please use allowed characters (Alphabets, Numbers, Hyphens, Space)" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
              <label><span id="pharmacy_surgery_address_label">Pharmacy Address</span><span class="required">*</span></label>
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
              <label><span id="premises_label">Premises Phone Number</span><span class="required">*</span></label>
              <input type="text" class="form-control" name="contact_no" id="contact_no" value="<?php echo $get_pharmacy_surgery_details['contact_no'];?>" required="required"  pattern="^(02|01)(?=.*[0-9])[0-9]{9,}$"  data-error="Please use allowed characters (Numbers, should start with 02 or 01 and length should be 11 numbers)"  maxlength="11"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label id="gphc_no_label">GPhC No (Optional)</label>
              <input type="text" class="form-control" name="gphc_no" value="<?php echo $get_pharmacy_surgery_details['gphc_no'];?>" pattern="^[0-9|]+[0-9|]*"  data-error="Please use only numbers" maxlength="10">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="form-group" id="ods_code_div">
              <label>ODS Code (Optional)</label>
              <input type="text" class="form-control" name="f_code" id="f_code" value="<?php echo $get_pharmacy_surgery_details['f_code'];?>" maxlength="10">
            </div>
            
            <div class="form-group pull-right">
              <?php if($get_pharmacy_surgery_details['id']!=""){?>
              <button type="submit" class="btn btn-sm btn-success btn-block"  name="add_update_btn"> Update</button>
              <input type="hidden" name="action" id="action" value="update" />
              <input type="hidden"  name="pharmacy_id" id="pharmacy_id" value="<?php echo $get_pharmacy_surgery_details['id'];?>"/>
              <?php } else {?>
              <button type="submit" class="btn btn-sm btn-success btn-block"   name="add_update_btn"> Add</button>
              <input type="hidden" name="action" id="action" value="add" />
              <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php if($get_pharmacy_surgery_details['id'] !=''){ ?>
</div>
<?php } ?>
<script>
	$(document).ready(function(){
	<?php 
		if($get_pharmacy_surgery_details['type'] == 'W'){
	?>
		$('#gphc_no_label').text('MHRA No (Optional)');
	<?php
		}
	?>

		
	})

</script>