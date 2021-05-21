<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"><strong> ONLINE DOCTOR </strong></div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home_tab">Voyager Health Listing</a></li>
                            <li><a data-toggle="tab" href="#embed_code">Embed code</a></li>
                            <li><a data-toggle="tab" href="#pricing_tab">Pricing</a></li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div id="home_tab" class="tab-pane fade in active">
                        
                        <br />
                        <p>This is the online doctor module. You can manage your online doctor settings using the above tabs.</p>
                        <p><strong> Pricing: </strong> This allows you to set your online prices of the different medicines and associate a discount for multiple purchases.</p>
                        <p><strong> Embed code: </strong> Your location will be listed on VoyagerHealth automatically, however you can embed the code yourself on your website.
                        </p>
                        <br />
                        <?php 
							if($user_org_superintendent || $this->session->is_owner){
						?>
                        	<div class="panel-heading" style="background-color:#f5f5f5"  data-toggle="modal" data-target="#myModal"><strong>ONLINE/ OFFLINE LOCATIONS</strong></div>
                            <div class="panel-body">
                            <p class="align-left"></p>
                            <div class="row">
                              <div class="col-md-12">
                                    <p>Here you can turn your Voyager Health listing ON and OFF</p>
                                    <hr />
                                    <div style="max-height:400px; overflow:auto">
                                         <form action="<?php echo SURL?>/organization/online-doctor-pharmacies" method="POST" name="online_doctor_frm" id="online_doctor_frm" >
                                            <table class="table table-striped">
                                                <tr class="info">
                                                  <th><input type="checkbox" id="checkAll" /></label></th>
                                                  <th>Pharamcy/ Clinic</th>
                                                  <th>Address</th>
                                                  <th>PostCode</th>
                                                  <th>Online Doctor</th>
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
                                                                <td><?php echo (filter_string($pharamcy_surgery_list[$j]['online_doctor_status']) == '1') ? '<span class="label label-success">ON</span>' : '<span class="label label-danger">OFF</span>';?></td>
                                                            </tr>
                                                <?php			
                                                        }//end for
                                                ?>
                                                        <tr>
                                                            <td colspan="5">
                                                                <select id="online_doctor" name="online_doctor" onChange="if(this.value!='') $('#online_doctor_frm').submit()">
                                                                    <option value=""> -- Select -- </option>
                                                                    <option value="1">ON </option>
                                                                    <option value="0">OFF</option>
                                                                </select>
                                                             </td>
                                                        </tr>
                                                <?php
                                                    }else{
                                                ?>
                                                        <tr><td colspan="5" class="error">No Pharmacies Found.</td></tr>
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
                      <?php 
					  		}//end if($user_org_superintendent || $this->session->is_owner)
					  ?>
                      	
                    </div>
                    <div id="pricing_tab" class="tab-pane fade">
                        
                        <br />

                        <p> This allows you to set your online prices of the different medicines and associate a discount for multiple purchases. </p>

                        <div class="row">
                            <div class="col-md-12">
                           
                                <p class="align-left"></p>
                                <?php if($this->session->pharmacy_surgery_id){
                                        
                                        foreach($pharmacy_surgery_medicine_arr as $category_name => $medicine_data){
                                            
                                ?>
                                            <!-- MEDICINE CATEGORY -->
                                            <div class="row bg-info">
                                              <div class="col-md-12">
                                                    <a href="javascript:;" onClick="toggle_me_with_arrow('medicine_cat_<?php echo filter_string($medicine_data['category_info']['category_id'])?>','medicine_cat_arrow_<?php echo filter_string($medicine_data['category_info']['category_id'])?>')"><h4><?php echo filter_string($category_name) ?><span class="pull-right"><i id="medicine_cat_arrow_<?php echo filter_string($medicine_data['category_info']['category_id'])?>" class="fa fa-angle-down"></i></span></h4></a>
                                              </div> 
                                            </div><!-- ./ row-->   
                                            
                                            <!-- MEDICINE LISTING -->
                                            <div id="medicine_cat_<?php echo filter_string($medicine_data['category_info']['category_id'])?>" style="display: none">
                                                
                                                <?php 
                                                    if(count($medicine_data['medicine_arr'])){
                                                        
                                                        $med_count = 0;
                                                        foreach($medicine_data['medicine_arr'] as $medicine_id => $medicine_arr){
                                                ?>          
                                                            <!-- MEDICINE NAME --> 
                                                            <div class="row">
                                                                <div class="col-md-1 text-right"><?php echo ($med_count+1)?></div>
                                                                <a href="javascript:;" onClick="toggle_me_with_arrow('cat_medicine_<?php echo $medicine_id?>','sub_cat_arrow_<?php echo $medicine_id?>')">
                                                                <div class="col-md-6">
                                                                    <strong><?php echo filter_string($medicine_arr['medicine_info']['medicine_full_name'])?><span class="pull-right"><i id="sub_cat_arrow_<?php echo $medicine_id?>" class="fa fa-angle-down"></i></span></strong></div></a>
                                                            </div> <!-- ./ row-->   
                                                            
                                                            <!-- MEDICINE PRICE DETAILS --> 
                                                            
                                                            <div id="cat_medicine_<?php echo $medicine_id?>" style="display: none">
                                                                <form method="post" id="medicine_frm_<?php echo $medicine_id?>">
                                                                    <div class="row">
                                                                        <div class="col-md-1">&nbsp;</div>
                                                                        <div class="col-md-11">
                                                                            <div class="row">
                                                                            <!-- STRENGTH MANAGEMENT -->
                                                                                <div class="col-md-6">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table class="table table-striped">
                                                                                                <tr>
                                                                                                    <th>Strength</th>
                                                                                                    <th>Price Per Item/ Tablet/ Capsule (&pound;)</th>
                                                                                                </tr>
                                                                                                <?php 
                                                                                                    if(count($medicine_arr['strength_arr']) > 0){
                                                                                                        foreach($medicine_arr['strength_arr'] as $strength_id => $strength_arr){
                                                                                                ?>
                                                                                                        <tr>
                                                                                                            <td><strong><?php echo filter_string($strength_arr['strength'])?></strong></td>
                                                                                                            <td><input type="number" required="required" class="form-control input-sm" value="<?php echo filter_string($strength_arr['per_price'])?>" id="" name="price_per_qty[<?php echo $strength_id?>]" placeholder="Price Per Item/ Tablet/ Capsule"></td>
                                                                                                        </tr>
                                                                                                <?php       
                                                                                                        }//end foreach($medicine_arr['strength_arr'] as $strength_id => $strength_data)
                                                                                                    }//end if(count($medicine_arr['strength_arr']) > 0)
                                                                                                ?>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div><!-- ./row -->
                                                                                </div>
                                                                                <!-- QUANTITY MANAGEMENT -->
                                                                                <div class="col-md-6">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table class="table table-striped">
                                                                                                <tr>
                                                                                                    <th>Quantity</th>
                                                                                                    <th>Discount Percentage(%)</th>
                                                                                                </tr>
                                                                                                <?php 
                                                                                                    if(count($medicine_arr['quantity_arr']) > 0){
                                                                                                        foreach($medicine_arr['quantity_arr'] as $quantity_arr){
                                                                                                ?>
                                                                                                            <tr>
                                                                                                                <td><strong><?php echo filter_string($quantity_arr['quantity_txt'])?></strong></td>
                                                                                                                <td><input type="number"  required="required" class="form-control input-sm" value="<?php echo filter_string($quantity_arr['discount_precentage'])?>" id="" name="med_quantity[<?php echo $quantity_arr['quantity_id']?>]" placeholder="Discount Percentage (%)"></td>
                                                                                                            </tr>
                                                                                                <?php           
                                                                                                        }//end foreach($medicine_arr['quantity_arr'] as $qtuantity_arr)
                                                                                                    }//end if(count($medicine_arr['quantity_arr']) > 0)
                                                                                                ?>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div><!-- ./row -->
                                                                                </div>
                                                                            </div><!-- ./ row-->
                                                                            <div class="row">
                                                                                <div class="col-md-12 text-right">
                                                                                    <label><input type="checkbox" name="available_status" value="0" <?php echo (filter_string($medicine_arr['medicine_info']['available_status']) ? '' : 'checked="checked"' )?>  /> Mark Medicine as Unavailable</label><br />
                                                                                    <input type="hidden" name="pharmacy_surgery_id" value="<?php echo $this->session->pharmacy_surgery_id; ?>" readonly="readonly" />
                                                                                    <input type="hidden" name="medicine_id" value="<?php echo $medicine_id?>" readonly="readonly" />
                                                                                    <input type="button" class="btn btn-xs btn-success pharmacy_medicine_submit_class pull-right" value="Update Prices" name="pharmacy_medicine_sbt" rel="<?php echo $medicine_id?>" id="pharmacy_medicine_sbt_<?php echo $medicine_id?>"/>
                                                                                    <p id="response_<?php echo $medicine_id?>" class="alert-info hidden"></p>
                                                                                </div>
                                                                            </div> <!-- ./ row-->
                                                                        </div>
                                                                    </div><!-- ./ row-->
                                                                </form>
                                                            </div>                          
                                                <?php   
                                                            $med_count++;
                                                        }//end foreach($medicine_data['medicine_arr'] as $medicine_id => $medicine_arr) 
                                                    }//end if(count($medicine_data['medicine_arr']))
                                                ?>
                                            </div>
                                            <hr />      

                                <?php           
                                        }//end foreach($pharmacy_surgery_medicine_arr AS $category_name => $medicine_data)
                                    
                                  } else {
                            ?>
                                        <div class="well">
                                            <div class="row">
                                            
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the top left list. </h4>
                                                     <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
                                                </div>
                                                
                                            </div>
                                        </div>
                            <?php
                                    } //end if($this->input->post('survey_pharmacy_medicine'))
                                ?>
                               
                            </div>
                            </div><!-- ./ row-->


                    </div>

                    <div id="embed_code" class="tab-pane fade">
                        
                        <br />
                        
                        <?php
							if($this->session->pharmacy_surgery_id){
								if($get_pharmacy_surgery_data['embed_status'] == '1'){
							?>
									<p> Your location will be listed on VoyagerHealth automatically, however you can embed the code yourself on your website. </p>
										
									<div class="input-group input-group-lg">
									  <span id="sizing-addon1" class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
										<input type="text" readonly="readonly" onclick="$(this).select();" onfocus="$(this).select();" aria-describedby="sizing-addon1" value="<?php echo htmlentities('<script type="text/javascript"> var phd_embed_pharmacy_id = "'.$get_pharmacy_surgery_data['id'].'"; var phd_embed_pharmacy_name = "'.filter_string($get_pharmacy_surgery_data['pharmacy_surgery_name']).'"; var phd_embed_width = "100%"; var phd_embed_height = "780px";</script><script type="text/javascript" src="'.VH_SURL.'embed/assets/js/embed.js"></script>'); ?>" class="form-control">
									</div>
							
							<?php		
								}else{
							?>
								<p class="alert alert-danger">Embed Code is not enabled for the selected pharmacy.</p>
							<?php		
								}//end if($get_pharmacy_surgery_data['embed_status'] == '1')
							}else{
						?>
                        		<div class="well">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                                             <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
                                        </div>
                                    </div>
                                </div>
                        <?php		
							}//end if($this->session->pharmacy_surgery_id)
						?>
                     
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>