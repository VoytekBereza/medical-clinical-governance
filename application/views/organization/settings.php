<!-- Style for suggesstionbox -->
<style>
  #result_prescriber li.selected {
      background-color: #ddd;
  }

  #result2 li.selected2 {
      background-color: #ddd;
  }
  
  #result li.selected3 {
      background-color: #ddd;
  }
 

</style>


<?php
	$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
	$global_vat_percentage = get_global_settings($VAT_PERCENTAGE);						

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"><strong> Oganisation Global Settings </strong></div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#setting_tab"> Settings </a></li>
                            <li><a data-toggle="tab" href="#pgd_tab" id="pgd_tab_show"> PGDs </a></li>
                            <li><a data-toggle="tab" href="#prescriber_tab"> Default Prescribers </a></li>
                            <li><a data-toggle="tab" href="#embed_tab"> Embed Settings </a></li>
                            <li><a data-toggle="tab" href="#bulk_tab"> Bulk Purchase </a></li>
                            <li><a data-toggle="tab" href="#bank_tab"> Bank Details </a></li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div id="setting_tab" class="tab-pane fade in active">
                        
                        <br />
                        <p></p>

                        <div class="row">
                          <div class="col-md-12">
                            <form action="<?php echo SURL?>organization/settings-process" id="global_set_frm" name="global_set_frm"  method="POST" enctype="multipart/form-data">
                              <!-- Start - Global Settings -->
                              
                              <?php if(count($governance_purchased_pharmacies) > 0){ ?>
                        
                                <div class="row">
                                  <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="checkbox" class="kod-switch" name="governance_status" id="0" value="1" <?php echo ($organization_settings['governance_status']) ? 'checked="checked"' : ''?>>
                                  </div>
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                    <label>Governance</label><br />
                                    <i>(Note: This will enforce to apply changes on all Pharmacies)</i>
                                  </div>
                                </div>
                        
                                <div class="row">
                                  <p>&nbsp;</p>
                                </div>
                        
                              <?php } else { ?>
                                <div class="row">
                                  
                                  <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label>Governance</label><br />
                                    <input type="checkbox" disabled="disabled" class="kod-switch" name="" >
                                    <br />
                                    <i class="text-danger">(Governance is not purchased for any single Pharmacy/ Clinic) <br /> <br /> </i>
                        
                                  </div>
                                  
                                </div>
                              <?php } // if(count($governance_purchased_pharmacies) > 0) ?>
                        
                        
                              <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                  <input type="checkbox" name="online_doctor_status" id="0" class="kod-switch" value="1" <?php echo ($organization_settings['online_doctor_status']) ? 'checked="checked"' : ''?>>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                  <label>Online Doctor</label>
                                  <br />
                                  <i>(Note: This will enforce to apply changes on all Pharmacies)</i>
                                </div>
                              </div>
                              <div class="row">
                                <p>&nbsp;</p>
                              </div>
                              
                              <?php if(count($survey_purchased_pharmacies) > 0){ ?>
                        
                                <div class="row">
                                  <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="checkbox" name="survey_status" id="0" class="kod-switch" value="1" <?php echo ($organization_settings['survey_status']) ? 'checked="checked"' : ''?>>
                                  </div>
                                  <div class="col-sm-3 col-md-3 col-lg-3">
                                    <label>Survey</label>
                                  </div>
                                </div>
                                <div class="row">
                                  <p>&nbsp;</p>
                                </div>
                        
                              <?php } else { ?>
                        
                                <div class="row">
                                  
                                  <div class="col-sm-12 col-md-12 col-lg-12">
                                    
                                    <label>Surveys</label><br />
                                    <input type="checkbox" disabled="disabled" class="kod-switch" name="" >
                                    <br />
                                    <i class="text-danger">(Survey is not purchased for any single Pharmacy/ Clinic) <br /> <br /> </i>
                        
                                  </div>
                                  
                                </div>
                        
                              <?php } // if(count($survey_purchased_pharmacies) > 0) ?>
                        
                              <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                  <input type="checkbox" name="pmr_status" id="0" class="kod-switch" value="1" <?php echo ($organization_settings['pmr_status']) ? 'checked="checked"' : ''?>>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                  <label>PMR</label>
                                </div>
                              </div>
                              <div class="row">
                                <p>&nbsp;</p>
                              </div>
                              <!--<div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                  <input type="checkbox" name="todolist_status" id="0" class="kod-switch" value="1" < ?php echo ($organization_settings['todolist_status']) ? 'checked="checked"' : ''?>>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                  <label>To Do List</label>
                                </div>
                              </div>
                              <div class="row">
                                <p>&nbsp;</p>
                              </div>
                              <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                  <input type="checkbox" name="ipos_status" id="ipos_status" class="kod-switch" value="1" < ?php echo ($organization_settings['ipos_status']) ? 'checked="checked"' : ''?>>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                  <label>IPOS</label>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                  < ?php echo ($organization_settings['ipos_status']) ? '<label class="success">ON</label>' : '<label class="error">OFF</label>'?>
                                </div>
                              </div>-->
                              <em class="bg-info text-info"><i class="fa fa-info-circle"></i> This applies on all Pharmacy in an Organisation</em>
                              
                               </form>
                            <!-- End - Global Settings --> 
                          </div>
                        </div> <!-- /.row -->                      	
                    </div>
                    
                    <div id="pgd_tab" class="tab-pane fade">
                        
                        <br />

                        <p></p>

                        <div class="row">
                          <div class="col-md-12">
                            <form data-toggle="validator" role="form"  action="<?php echo SURL?>organization/settings-process-cqc" id="cqt_frm" name="cqt_frm"  method="POST" enctype="multipart/form-data">
                              <div class="row">
                             
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group has-feedback">
                                        <label for="cqc_pharmacy_name">CQC Pharmacy Name:</label>
                                        <input type="text" value="<?php echo filter_string($get_cqc_details['cqc_pharmacy_name']);?>" placeholder="CQC Pharmacy Name" required="required" class="form-control" name="cqc_pharmacy_name">
                                        
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <div class="help-block with-errors"></div>
                                        
                                    </div>
                                        <em class="bg-info text-info"><i class="fa fa-info-circle"></i> Applied on Superintendent and Owners</em>
                                                  
                               
                                </div>
                                
                                <div class="col-sm-6 col-md-6 col-lg-6 ">
                                    <div class="form-group has-feedback">
                                        <label for="cqc_pharmacy_name">CQC Body:</label>
                                        <input type="text" value="<?php echo filter_string($get_cqc_details['cqc_body']);?>" placeholder="CQC Body" required="required" class="form-control" name="cqc_body">
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                       <div class="help-block with-errors"></div>
                                </div>
                              </div>
                              </div>
                               <div class="row">
                                <p>&nbsp;</p>
                              </div>
                              <label for="cqc_pharmacy_name">CQC Manager:</label>
                              <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group has-feedback">
                                  <input type="text" value="<?php echo filter_string($get_cqc_details['cqc_manager']);?>"  placeholder="CQC Manager" required="required" class="form-control" name="cqc_manager">
                                   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                   <div class="help-block with-errors"></div>
                                 
                                 </div>
                                </div>
                               </div>
                                 <div class="row">
                                <p>&nbsp;</p>
                              </div>
                               <div class="row"> 
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group has-feedback">
                                
                                  <input type="file" name="cqc_authorized_stamp" id="cqc_authorized_stamp" <?php if($get_cqc_details['cqc_authorized_stamp']==""){?>required="required"<?php }?> value="" class="">
                                  
                                   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                   <div class="help-block with-errors"></div>
                                  </div>
                                  <br />
                                  <label for="cqc_authorized_stamp">Authorize Stamp:</label>
                                  <?php if($get_cqc_details['cqc_authorized_stamp']!=""){?>
                                  <div class="form-group">
                                     
                                    <img width="200px" class="img-responsive" src="<?php echo ORG_STAMP_THUMB;?><?php echo filter_string($get_cqc_details['cqc_authorized_stamp']);?>" />                    
                                 </div>
                                  <?php }?>
                                  <p>
                                    <i>Allowed Extensions: jpg, jpeg, png, gif</i><br>
                                    <i>Maximum Size Allowed: 2MB</i><br />
                                    <i>Recommended Dimensions: Width: 300px, Height: 200px </i>
                                  
                                </p>
                                </div>
                              </div>
                               <div class="row">
                                  <div class="form-group  pull-right">
                                      <div class="col-sm-6 col-md-6 col-lg-6">
                                       <button name="save_cqc_btn" id="save_cqc_btn" class="btn btn-success" type="submit">Update CQC</button>
                                      </div> 
                                 </div>
                               </div>
                              </form> 
                            <!-- End - CQC SETTINGS --> 
                          </div>
                        </div>                        
                        <br />
                        <div data-target="#myModal" data-toggle="modal" style="background-color:#f5f5f5" class="panel-heading"><strong>ASSIGN DOCTOR AND PHARMACIST FOR AUTHENTICATIONS</strong></div>
                        <br />
                        <div class="row">
                          <div class="col-md-12">
                              <!-- Start - Global Settings -->
                              
                             <div class="row">
                                <div id="error_msg_show"></div>
                                <div class="col-sm-6 col-md-6 col-lg-6 validate_msg">
                                 <label for="is_default_doc">Search Doctor:</label>
                                  <input type="text" autocomplete="off" placeholder="Search Doctor" required="required" class="form-control search_doctor_pharmacist" name="is_default_doc" id="1">
                                   <input type="hidden"  name="doctor_email" id="doctor_email">
                                   <div id="result"></div>
                                </div>
                               
                                <div class="col-sm-6 col-md-6 col-lg-6 validate_msg">
                                <label for="is_default_pharm">Search Pharmacist:</label>
                                  <input type="text" autocomplete="off" placeholder="Search Pharmacist" required="required" class="form-control search_doctor_pharmacist" name="is_default_pharm" id="2">
                                  <input type="hidden"  name="pharmacist_email" id="pharmacist_email">
                                  <div id="result2"></div>
                                </div>
                                
                              </div>
                              <br />
                              <div class="row">
                              <?php if(!empty($get_default_doctor_pharmacist)){?>
                                <?php foreach($get_default_doctor_pharmacist as $each):?>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                               
                                  <label><?php if($each['user_type']=="1"){ echo $each['first_name']." ".$each['last_name'];} else if ($each['user_type']=="2") { echo $each['first_name']." ".$each['last_name'];}?></label>
                               
                                </div>
                                <?php endforeach;?>
                                <?php }?>
                               
                              </div>                
                               <div class="row">
                                <p>&nbsp;</p>
                              </div> <!-- /.row -->
                               <div class="row">
                                  <div class="form-group pull-right">
                                      <div class="col-sm-6 col-md-6 col-lg-6">
                                       <button name="search_btn_doc_pharm" id="search_btn_doc_pharm" class="btn btn-success save_doctor_pharmacist" type="submit">Save</button>
                                      </div> 
                                 </div> 
                               </div>   <!-- /.row -->            
                        
                            <!-- End - Global Settings --> 
                          </div>
                        </div> <!-- /.row -->
                    </div>

                    <div id="prescriber_tab" class="tab-pane fade">
                        
                        <br />
                        <p></p>
                        <div class="row">
                          <div class="col-md-12">
                           <!-- <form  class="form_validate" method="POST" enctype="multipart/form-data">-->
                              <!-- Start - Global Settings -->
                              
                             <div class="row">
                                    <div id="error_msg_show_prescriber"></div>
                                <div class="col-sm-6 col-md-6 col-lg-6 validate_msg">
                                 <label for="is_default_prescriber">Search Prescriber:</label>
                                  <input type="text" autocomplete="off" placeholder="Search Prescriber" required="required" class="form-control search_doctor_pharmacist_prescriber" name="prescriber" id="is_prescriber">
                                  <input type="hidden"  name="prescriber_email" id="prescriber_email">
                                   <div id="result_prescriber"></div>
                                </div>  
                                
                                <!-- Modal Remove Default Prescriber -->
                                <div id="remove_as_prescriber_modal" style="display:none">
                                    <h4 class="modal-title">Confirmation</h4>
                                    <p>Are you sure you you want to remove the default prescriber?</p>
                                    <div class="modal-footer">
                                        <a href="<?php echo base_url(); ?>organization/remove-default-prescriber" class="btn btn-danger" >Remove</a>
                                        <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-6 col-lg-6 validate_msg">
                                 <label for="is_default_prescriber">Prescriber Fees:</label>
                                 <input type="text" autocomplete="off" placeholder="Prescriber Fees" required="required" class="form-control" name="prescriber_fees" id="prescriber_fees">
                                </div>
                              </div>
                              <br />
                              <div class="row">
                                
                                <div class="col-sm-6 col-md-6 col-lg-6" id="default_prescriber_info_div" >
                        
                                  <?php if(!empty($get_default_prescriber)) { ?>
                                    <label><?php echo $get_default_prescriber['first_name']." ".$get_default_prescriber['last_name'];?></label>
                        
                                    <!-- Remove As Prescriber Modal -->
                                    <button class="btn btn-xxs btn-secondary dialogue_window" href="#remove_as_prescriber_modal" type="button">
                                      <span data-unicode="e014" class="glyphicon glyphicon-remove"></span> Remove as Prescriber
                                    </button>
                                  <?php } ?>
                        
                                </div>
                                
                                <div class="col-sm-6 col-md-6 col-lg-6" id="default_prescriber_fees_div">
                                  
                                  <?php if($get_default_prescriber_fees['prescriber_fees']!="" && $get_default_prescriber){?>
                                    <label>&pound<?php echo $get_default_prescriber_fees['prescriber_fees'];?> </label>
                                  <?php } ?>
                        
                                </div>
                              </div>                
                               <div class="row">
                                <p>&nbsp;</p>
                              </div>
                               <div class="row">
                                  <div class="form-group pull-right">
                                      <div class="col-sm-6 col-md-6 col-lg-6">
                                       <button name="search_btn_prescriber" id="search_btn_prescriber" class="btn btn-success save_prescriber" type="submit">Save</button>
                                      </div> 
                                 </div>
                               </div>               
                           <!-- </form>-->
                            <!-- End - Global Settings --> 
                        
                          </div>
                        </div> <!-- /.row -->
                     
                    </div>
                    
                    <div id="embed_tab" class="tab-pane fade">
                    	<br />
                        <p></p>
                        <div class="row">
                          <div class="col-md-12">
                                <p>Here you can turn your Voyager Health listing ON and OFF.</p>
                                <br />
                                <div style="max-height:400px; overflow:auto">
                                     <form action="<?php echo SURL?>/organization/embed-code-pharmacies" method="POST" name="embed_codes_pharma" id="embed_codes_pharma" >
                                        <table class="table table-striped">
                                            <tr class="info">
                                              <th><input type="checkbox" id="checkAll" /></label></th>
                                              <th>Locations</th>
                                              <th>Address</th>
                                              <th>PostCode</th>
                                              <th>Embed Code</th>
                                            </tr>
                                            <?php
                                                if(count($pharamcy_surgery_list) > 0){
                                                    
                                                    for($j=0;$j<count($pharamcy_surgery_list);$j++){
                                            ?>
                                                        <tr>
                                                            <td><label><input type="checkbox" name="pharmacy_chk[]" value="<?php echo filter_string($pharamcy_surgery_list[$j]['pharmacy_surgery_id'])?>" aria-required="true"></label></td>
                                                            <td><?php echo filter_string($pharamcy_surgery_list[$j]['pharmacy_surgery_name']);?></td>
                                                            <td><?php echo filter_string($pharamcy_surgery_list[$j]['address']);?></td>
                                                            <td><?php echo filter_string($pharamcy_surgery_list[$j]['postcode']);?></td>
                                                            <td><?php echo (filter_string($pharamcy_surgery_list[$j]['embed_status']) == '1') ? '<span class="label label-success">ON</span>' : '<span class="label label-danger">OFF</span>';?></td>
                                                        </tr>
                                            <?php			
                                                    }//end for
                                            ?>
                                                    <tr>
                                                        <td colspan="5">
                                                            <select id="embed_status" name="embed_status" onChange="if(this.value!='') $('#embed_codes_pharma').submit()">
                                                                <option value=""> -- Select -- </option>
                                                                <option value="1">ON </option>
                                                                <option value="0">OFF</option>
                                                            </select>
                                                         </td>
                                                    </tr>
                                            <?php
                                                }else{
                                            ?>
                                                    <tr><td colspan="5" class="error">No Locations Found.</td></tr>
                                            <?php		
                                                }//end if(count($pharamcy_surgery_list) > 0)
                                            ?>
                                        </table>                     
                                     </form>
                                </div>
                                <hr /> 
                          </div>
                        </div> <!-- /.row -->                    
                    </div>
                    
                    <div id="bulk_tab" class="tab-pane fade">
                        <br />
                        <p> This allows you to set your online prices of the different medicines and associate a discount for multiple purchases. </p>                    
                        <div class="row">
                          <div class="col-md-12">
                                <a href="javascript:;" onClick="toggle_me_with_arrow('governance_prod','gov_arrow')"><h4>Governance <span class="pull-right"><i id="gov_arrow" class="fa fa-angle-down"></i></span></h4></a>
                              
                                <div id="governance_prod" style="display: none">
                        
                                    <p><strong><h5> Governance Purchased Locations </h5></strong></p>
                                    <hr />
                                    <div style="max-height:400px; overflow:auto">
                                        <table class="table table-striped">
                                            <tr class="info">
                                              <th>Sr#</th>
                                              <th>Locations</th>
                                              <th>Purchased Date</th>
                                              <th>Expiry Date</th>
                                              <th>Purchased By</th>
                                            </tr>
                                            <?php
                                                if(count($governance_purchased_pharmacies) > 0){
                                                    
                                                    for($i=0;$i<count($governance_purchased_pharmacies);$i++){
                                            ?>
                                                        <tr>
                                                            <td><?php echo ($i+1)?></td>
                                                            <td><?php echo filter_string($governance_purchased_pharmacies[$i]['pharmacy_surgery_name']);?></td>
                                                            <td><?php echo kod_date_format(filter_string($governance_purchased_pharmacies[$i]['purchase_date']),FALSE);?></td>
                                                            <td><?php echo kod_date_format(filter_string($governance_purchased_pharmacies[$i]['expiry_date']),FALSE);?></td>
                                                            <td><?php echo filter_string($governance_purchased_pharmacies[$i]['purchased_by_name']);?></td>
                                                        </tr>
                                            <?php			
                                                    }//end for
                        
                                                }else{
                                            ?>
                                                    <tr><td colspan="5" class="error">No Locations Found.</td></tr>
                                            <?php		
                                                }//end if(count($governance_purchased_pharmacies) > 0)
                                            
                                            ?>
                                           
                                        </table>
                                    </div>
                                    <hr /> 
                                    <p>
                                        <strong><h5>Governance NON Purchased Locations <span class="pull-right"><label><input type="checkbox" id="check_all_pharmacies_gov" /> SELECT ALL PHARMACIES</label></span></h5> </strong> 
                                        
                                    </p>
                                    <hr />
                                    <form action="<?php echo SURL?>/organization/governance-checkout" method="POST" enctype="multipart/form-data">
                                        <div class="row" style="max-height:200px; overflow:auto">
                                            <?php 
                                                if(count($governance_non_purchased_pharmacies) > 0){
                                                    
                                                    for($i=0;$i<count($governance_non_purchased_pharmacies);$i++){
                                            ?>
                                                        <div class="col-md-4"><label><input type="checkbox" class="pharm_gov" name="pharm_gov_chk[]" value="<?php echo filter_string($governance_non_purchased_pharmacies[$i]['id'])?>" aria-required="true"> <?php echo filter_string($governance_non_purchased_pharmacies[$i]['pharmacy_surgery_name'])?></label></div>
                                            <?php			
                                                    }//end for
                                            ?>
                                                    <p>&nbsp;</p>
                                                    <div class="row bg-info" style="margin:0" >
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-2"><strong>SubTotal (&pound;):</strong> </div>
                                                        <div class="col-md-2 subtotal_governance">0.00</div>
                                                    </div>
                                                    <div class="row bg-info" style="margin:0">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-2"><strong>VAT (&pound;):</strong> </div>
                                                        <div class="col-md-2 vat_governance">0.00 </div>
                                                    </div>
                                                    <div class="row bg-info" style="margin:0">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-2"><strong>GrandTotal (&pound;):</strong> </div>
                                                        <div class="col-md-2 grandtotal_governance" >0.00 </div>
                                                    </div>
                                                    <div class="row bg-info" style="margin:0">
                                                        <div class="col-md-12 text-right"><button type="submit" name="gov_purchase_btn" id="gov_purchase_btn" class="btn btn-xs btn-warning"><i class="fa fa-paypal"></i> Check Out</button></div>
                        <input type="hidden" readonly="readonly" id="governance_price" name="governance_price" value="<?php echo filter_price($governance_package_list['price'])?>" />
                                                    <input type="hidden" id="vat_percentage" name="vat_percentage" value="<?php echo filter_string($global_vat_percentage['setting_value']);?>" readonly="readonly" />                                                
                                                    </div>
                                                                    
                                            
                                            <?php
                                                }else{
                                            ?>
                                                    <div class="alert alert-danger">No Locations Found!</div>
                                            <?php		
                                                }//end if($count($governance_non_purchased_pharmacies) > 0)
                                            ?>
                                        </div>
                                    </form>
                                </div>
                                <hr /> 
                             <!-- End - Global Settings --> 
                          </div> 
                        </div><!--END ROW -->
                        <div class="row">
                          <div class="col-md-12">
                                <a href="javascript:;" onClick="toggle_me_with_arrow('survey_prod','survey_arrow')"><h4>Survey <span class="pull-right"><i id="survey_arrow" class="fa fa-angle-down"></i></span></h4></a>
                              
                                <div id="survey_prod" style="display: none ">
                                    <p><strong><h5>Survey Purchased Pharmacies</h5></strong></p>
                                    <hr />
                                    <div style="max-height:400px; overflow:auto">
                                        <table class="table table-striped">
                                            <tr class="info">
                                              <th>Sr#</th>
                                              <th>Locations</th>
                                              <th>Purchased Date</th>
                                              <th>Expiry Date</th>
                                              <th>Purchased By</th>
                                            </tr>
                                            <?php
                                                if(count($survey_purchased_pharmacies) > 0){
                                                    
                                                    for($i=0;$i<count($survey_purchased_pharmacies);$i++){
                                            ?>
                                                        <tr>
                                                            <td><?php echo ($i+1)?></td>
                                                            <td><?php echo filter_string($survey_purchased_pharmacies[$i]['pharmacy_surgery_name']);?></td>
                                                            <td><?php echo kod_date_format(filter_string($survey_purchased_pharmacies[$i]['purchase_date']),FALSE);?></td>
                                                            <td><?php echo (kod_date_format(filter_string($survey_purchased_pharmacies[$i]['expiry_date']),FALSE) == '0000-00-00') ? 'N/A' : kod_date_format(filter_string($survey_purchased_pharmacies[$i]['expiry_date']),FALSE);?></td>
                                                            <td><?php echo filter_string($survey_purchased_pharmacies[$i]['purchased_by_name']);?></td>
                                                        </tr>
                                            <?php			
                                                    }//end for
                        
                                                }else{
                                            ?>
                                                    <tr><td colspan="5" class="error">No Locations Found.</td></tr>
                                            <?php		
                                                }//end if(count($survey_purchased_pharmacies) > 0)
                                            
                                            ?>
                                           
                                        </table>
                                    </div>
                                    <hr /> 
                                    <p>
                                        <strong><h5>Survey NON Purchased Locations <span class="pull-right"><label><input type="checkbox" id="check_all_pharmacies_survey" /> SELECT ALL PHARMACIES</label></span></h5> </strong> 
                                        
                                    </p>
                                    <hr />
                                    <form action="<?php echo SURL?>/organization/survey-checkout" method="POST" enctype="multipart/form-data">
                                        <div class="row" style="max-height:200px; overflow:auto">
                                            <?php 
                                                if(count($survey_non_purchased_pharmacies) > 0){
                                                    
                                                    for($i=0;$i<count($survey_non_purchased_pharmacies);$i++){
                                            ?>
                                                        <div class="col-md-4"><label><input type="checkbox" class="pharm_survey" name="pharm_survey_chk[]" value="<?php echo filter_string($survey_non_purchased_pharmacies[$i]['id'])?>" aria-required="true"> <?php echo filter_string($survey_non_purchased_pharmacies[$i]['pharmacy_surgery_name'])?></label></div>
                                            <?php			
                                                    }//end for
                                            ?>
                                                    <p>&nbsp;</p>
                                                    <div class="row bg-info" style="margin:0" >
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-2"><strong>SubTotal (&pound;):</strong> </div>
                                                        <div class="col-md-2 subtotal_survey">0.00</div>
                                                    </div>
                                                    <div class="row bg-info" style="margin:0">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-2"><strong>VAT (&pound;):</strong> </div>
                                                        <div class="col-md-2 vat_survey">0.00 </div>
                                                    </div>
                                                    <div class="row bg-info" style="margin:0">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-2"><strong>GrandTotal (&pound;):</strong> </div>
                                                        <div class="col-md-2 grandtotal_survey" >0.00 </div>
                                                    </div>
                                                    <div class="row bg-info" style="margin:0">
                                                        <div class="col-md-12 text-right"><button type="submit" name="survey_purchase_btn" id="survey_purchase_btn" class="btn btn-xs btn-warning"><i class="fa fa-paypal"></i> Check Out</button></div>
                                                    <input type="hidden" readonly="readonly" id="survey_price" name="survey_price" value="<?php echo filter_price($survey_package_list['price'])?>" />
                                                                                                    
                                                    </div>
                                            <?php
                                                }else{
                                            ?>
                                                    <div class="alert alert-danger">No Locations Found!</div>
                                            <?php		
                                                }//end if($count($survey_non_purchased_pharmacies) > 0)
                                            ?>
                                        </div>
                                    </form>
                                    
                                </div>
                                <hr /> 
                             <!-- End - Global Settings --> 
                          </div> 
                        </div><!--END ROW -->
                        
                    </div>
                    
                    <div id="bank_tab" class="tab-pane fade"> <br />
                      <p></p>
                      <div class="row">
                        <div class="col-md-12">
                        
                          <form class="test_frm" data-toggle="validator" role="form"  action="<?php echo SURL?>organization/bank-settings-process" id="org_bank_frm" name="org_bank_frm"  method="post" enctype="multipart/form-data">
                          
                            <div class="row">
                              <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group has-feedback">
                                  <label for="cqc_pharmacy_name">Responsible Person *</label>
                                  <input type="text" value="<?php echo filter_string($organization_details['responsible_person']);?>" placeholder="Responsible Person" class="form-control" name="responsible_person">
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6 ">
                                <div class="form-group has-feedback">
                                  <label for="cqc_pharmacy_name">Account Holder Name *</label>
                                  <input type="text" value="<?php echo filter_string($organization_details['account_holder_name']);?>" placeholder="Account Holder Name"  class="form-control" name="account_holder_name">
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="row">
                              <div class="col-sm-6 col-md-6 col-lg-6">
                              	<label for="cqc_pharmacy_name">Bank Name *</label>
                                <div class="form-group has-feedback">
                                  <input type="text" value="<?php echo filter_string($organization_details['bank_name']);?>"  placeholder="Bank Name"  class="form-control" name="bank_name">
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                              
                              <div class="col-sm-6 col-md-6 col-lg-6">
                              	<label for="cqc_pharmacy_name">Account Number *</label>
                                <div class="form-group has-feedback">
                                  <input type="text" value="<?php echo filter_string($organization_details['account_no']);?>"  placeholder="Account Number"  class="form-control" name="account_no">
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                              
                              <div class="col-sm-6 col-md-6 col-lg-6">
                              	<label for="cqc_pharmacy_name">Sort Code *</label>
                                <div class="form-group has-feedback">
                                  <input type="text" value="<?php echo filter_string($organization_details['sort_code']);?>"  placeholder="Sort Code"  class="form-control" name="sort_code">
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                              
                              <div class="col-sm-6 col-md-6 col-lg-6">
                              	<label for="cqc_pharmacy_name">SWIFT/BIC Code</label>
                                <div class="form-group has-feedback">
                                  <input type="text" value="<?php echo filter_string($organization_details['swift_code']);?>"  placeholder="SWIFT/BIC Code"  class="form-control" name="swift_code">
                                </div>
                              </div>
                              
                              <div class="col-sm-6 col-md-6 col-lg-6">
                              	<label for="cqc_pharmacy_name">IBAN</label>
                                <div class="form-group has-feedback">
                                  <input type="text" value="<?php echo filter_string($organization_details['iban_no']);?>"  placeholder="IBAN"  class="form-control" name="iban_no">
                                </div>
                              </div>
                              
                              
                            </div>
                            
                            <div class="row">
                              <div class="form-group  pull-right">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                  <button name="save_cqc_btn" id="save_bank_btn" class="btn btn-success" type="submit">Update</button>
                                </div>
                              </div>
                            </div>
                          </form>
                          <!-- End - CQC SETTINGS --> 
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
	$('#org_bank_frm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            responsible_person: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
           
            account_holder_name: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
			
			bank_name: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
			
			account_no: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
			
			sort_code: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            }
        }
    });
});
</script>