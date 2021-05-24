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
         <?php if($get_medicine_details['id']==""){?>
			<h2>Add New Medicine <small>Add New Medicine</small></h2>
			 <?php } else {?>
            <h2>Update Medicine <small>Update Medicine</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
        <form   id="add_new_medicine_frm" name="add_new_medicine_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>medicine/add-update-medicine-process">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#medicine_tab" id="medicine-tab" role="tab" data-toggle="tab" aria-expanded="true">Medicine</a> </li>
                                <li role="presentation" class=""><a href="#strength_tab" role="tab" id="strength-tab" data-toggle="tab" aria-expanded="false">Strength</a> </li>
                                <li role="presentation" class=""><a href="#quantity_tab" id="quantity-tab" role="tab" data-toggle="tab" aria-expanded="false">Quantity</a> </li>
                                <li role="presentation" class=""><a href="#seo_tab" role="tab" id="seo-tab" data-toggle="tab" aria-expanded="false">SEO</a> </li>
                          </ul>
                        <div id="myTabContent" class="tab-content">
                         	<div role="tabpanel" class="tab-pane fade active in" id="medicine_tab" aria-labelledby="medicine-tab">
                            <div class="form-group validate_msg">
                              <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add Medicine Category">Medicine Category<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                              <select name="category_id" id="category_id"  required="required" class="form-control">
                              		  <option value="">Select Medicine Category</option>
                              		<?php 
										  if(!empty($medicine_category_list)){
												
												foreach($medicine_category_list as $each){		  
											  
									 ?>
                                      <option value="<?php echo $each['id'];?>" <?php echo ($each['id']== $get_medicine_details['category_id']) ? 'selected="selected"' : '' ?>><?php echo $each['category_title'];?></option>
                                      <?php 
									  			} // foreach end
										  }// If end
									  ?>
                              </select>
                        </div>
                            <div class="form-group validate_msg">
                              <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add Medicine Form">Medicine Form<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                              <select name="medicine_form_id" id="medicine_form_id"  required="required" class="form-control">
                              		  <option value="">Select Medicine Form</option>
                              		<?php 
										  if(!empty($medicine_form_list)){
												
												foreach($medicine_form_list as $each){		  
											  
									 ?>
                                      <option value="<?php echo $each['id'];?>" <?php echo ($each['id']== $get_medicine_details['medicine_form_id']) ? 'selected="selected"' : '' ?>><?php echo $each['medicine_form'];?></option>
                                      <?php 
									  			} // foreach end
										  }// If end
									  ?>
                              </select>
                        </div>
                          	<div class="form-group validate_msg">
                            	<label  data-toggle="tooltip" data-placement="right"  title="Add Brand Name">Brand Name<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                           		 <input type="text" id="brand_name" name="brand_name" required="required" class="form-control" value="<?php echo filter_string($get_medicine_details['brand_name'])?>">
                           </div>
                        
                            <div class="form-group validate_msg">
                            <label  data-toggle="tooltip" data-placement="right"  title="Add Medicine Name">Medicine Name<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                            <input type="text" id="medicine_name" name="medicine_name" required="required" class="form-control" value="<?php echo filter_string($get_medicine_details['medicine_name'])?>">
                          </div>
                          
                          <div class="form-group validate_msg">
                            	<label  data-toggle="tooltip" data-placement="right"  title="Add Suggested Doze Of Medicine">Suggested Doze<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                           		 <input type="text" id="suggested_dose" name="suggested_dose" required="required" class="form-control" value="<?php echo filter_string($get_medicine_details['suggested_dose'])?>">
                           </div>
                       <div class="form-group">
                          <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Medicine Merge With Medicine ID">Medicine Merge With Medicine ID <i class="fa fa-info-circle"></i> </label>
                          <select name="merge_with_medicine_id" id="merge_with_medicine_id" class="form-control">
                                  <option value="">Select Medicine Merge With Medicine ID</option>
                                <?php 
                                      if(!empty($medicine_list)){
                                            
                                            foreach($medicine_list as $each){		  
                                          
                                 ?>
                                  <option value="<?php echo $each['id'];?>" <?php echo ($each['id']== $get_medicine_details['merge_with_medicine_id']) ? 'selected="selected"' : '' ?>><?php echo filter_string($each['brand_name']).' - '.filter_string($each['medicine_name']);?></option>
                                  <?php 
                                            } // foreach end
                                      }// If end
                                  ?>
                          </select>
                     </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4 validate_msg has-success">
                             <label for="midicinee-class"  data-toggle="tooltip" data-placement="right"  title="Add Medicine Class">Medicine Class<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                                <select required="required" name="medicine_class" id="medicine_class" class="form-control" aria-required="true">
                                <option value="">Select Medicine Class</option>
                                <option value="Rx-PGD" <?php echo ($get_medicine_details['medicine_class'] == 'Rx-PGD') ? 'selected="selected"' : '' ?>>Rx-PGD</option>
                                <option value="Rx" <?php echo ($get_medicine_details['medicine_class'] == 'Rx') ? 'selected="selected"' : '' ?>>Rx</option>
                               <!-- <option value="PGD" <?php echo ($get_medicine_details['medicine_class'] == 'PGD') ? 'selected="selected"' : '' ?>>PGD</option>-->
                                </select> 
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4 validate_msg">
                                <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add Legal Category">Legal Category<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                                <select required="required" name="legal_category" id="legal_category" class="form-control" aria-required="true">
                                <option value="">Legal Category</option>
                                <option value="POM" <?php echo ($get_medicine_details['legal_category'] == 'POM') ? 'selected="selected"' : '' ?>>POM</option>
                                <option value="P" <?php echo ($get_medicine_details['legal_category'] == 'P') ? 'selected="selected"' : '' ?>>P</option>
                                </select>
                            </div>
                            
                            <div class="col-sm-4 col-md-4 col-lg-4 validate_msg">
                                <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add Is Branded or Generic">Is Branded<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                                <select required="required" name="is_branded" id="is_branded" class="form-control" aria-required="true">
                                <option value="">Select Brand</option>
                                <option value="Branded" <?php echo ($get_medicine_details['is_branded'] == 'Branded') ? 'selected="selected"' : '' ?>>Branded</option>
                                <option value="Generic" <?php echo ($get_medicine_details['is_branded'] == 'Generic') ? 'selected="selected"' : '' ?>>Generic</option>
                                </select> 
                            </div>
                        </div>
                        <br />
                        <div class="form-group validate_msg">
                            <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add Short Description">Short Description<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                            <textarea id="short_description" name="short_description" placeholder="Short Description" required="required" rows="3" class="form-control" aria-required="true"><?php echo filter_string($get_medicine_details['short_description'])?></textarea>
                        </div>
                        <div class="form-group">
                            <label  data-toggle="tooltip" data-placement="right"  title="Add Branded More Info">Branded More Info <i class="fa fa-info-circle"></i> </label>
                            <textarea class="ckeditor editor1" id="branded_more_info" name="branded_more_info" rows="14"><?php echo filter_string($get_medicine_details['branded_more_info'])?></textarea>
                		</div>
                        
                        <div class="form-group">
                            <label  data-toggle="tooltip" data-placement="right"  title="Add Strength More Info">Strength More Info <i class="fa fa-info-circle"></i> </label>
                            <textarea class="ckeditor editor1" id="strength_more_info" name="strength_more_info" rows="14"><?php echo filter_string($get_medicine_details['strength_more_info'])?></textarea>
                		</div>
                        
                        <div class="form-group">
                            <label  data-toggle="tooltip" data-placement="right"  title="Add Medicine Description">Description <i class="fa fa-info-circle"></i> </label>
                            <textarea class="ckeditor editor1" id="description" name="description" rows="14"><?php echo filter_string($get_medicine_details['description'])?></textarea>
                		</div>
                          
                        
                        <div class="form-group validate_msg">
								<label>Medicine Image<span class="required">*</span>  </label>
							    <input type="file"  <?php if($get_medicine_details['images_src']==""){?>required="required"<?php }?> id="images_src" name="images_src" aria-required="true">
                                <br  />
                                <?php if($get_medicine_details['images_src']!=""){?>
                  				<div class="form-group ">
                                	 <label for="medicine_image">Medicine Image:</label>
                                	<img class="img-responsive" src="<?php echo MEDICINE_IMAGES_THUMB;?><?php echo filter_string($get_medicine_details['images_src']);?>" />                    
                            	 </div>
                 				<?php }?>
								<p><i>Allowed Extensions: jpg, jpeg, png, gif</i><br><i>Maximum Size Allowed: 2MB</i>
								</p>
							</div>
                            
                        <div class="form-group validate_msg">
                              <label for="middle-name">Status<span class="required">*</span> </label>
                              <select name="status" id="status"  required="required" class="form-control">
                                      <option value="1" <?php echo ($get_medicine_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($get_medicine_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                              </select>
                        </div>
          				</div>
                        
                         	<div role="tabpanel" class="tab-pane fade" id="strength_tab" aria-labelledby="strength-tab">
                            <?php if(!empty($get_medicine_strength_details)){
						        	foreach($get_medicine_strength_details as $each){
						     ?>
                              		  <div class="row pull-left">
                                                  <div class="col-lg-3 col-md-3 col-sm-3">
                                                    <div class="form-group validate_msg">
                                                        <label for="middle-name">Strenght<span class="required">*</span> </label>
                                                        <input type="text" required="required" id="strength" name="strength[]"  class="form-control" value="<?php echo filter_string($each['strength']);?>">
                                                        <input type="hidden" name="strength_id[]"  class="form-control" value="<?php echo $each['id'];?>">
                                                    </div>
                                                  </div>
                                                  
                                                   <div class="col-lg-3 col-md-3 col-sm-3">
                                                    <div class="form-group validate_msg">
                                                        <label for="middle-name">Price /Per Qty<span class="required">*</span></label>
                                                        <input type="text" required="required" id="per_price" name="per_price[]"  class="form-control" value="<?php echo filter_string($each['per_price']);?>">
                                                    </div>
                                                  </div>     
                                                  
                                                  <div class="col-lg-3 col-md-3 col-sm-3">
                                                   <div class="form-group">
                                                        <label for="middle-name">Strength Value</label>
                                                        <input type="text" id="strength_value" name="strength_value[]"  class="form-control" value="<?php echo filter_string($each['strength_value']);?>">
                                                    </div> 
                                                   </div>                                
                                                   
                                                   <div class="col-lg-3 col-md-3 col-sm-3">
                                                        <label for="middle-name">&nbsp; </label> <br />
                                                        <a class="btn btn-danger btn-xs" data-target="#confirm-delete-<?php echo $each['id'];?>" data-toggle="modal" title="Delete" data-href="<?php echo base_url();?>medicine/delete-medicine-strength/<?php echo $each['id'];?>" href="#">Remove</a>
                                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirm-delete-<?php echo $each['id'];?>" class="modal fade">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        Warning !
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this strength ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                                        <a class="btn btn-danger btn-ok" href="<?php echo base_url();?>medicine/delete-medicine-strength/<?php echo $get_medicine_details['id'];?>/<?php echo $each['id'];?>">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                					   </div>
                                                  </div>
                             		 </div> 
                             <?php }// End fooreach Loop ?>
                              <div class="row">
                            	  <div class="field_wrapper ">
                                       <div class="col-lg-12 col-md-6 col-sm-6">
                                       		<label for="middle-name">&nbsp; </label> <br />
                                       		<a title="Add field" class="btn btn-info add_button_edit_strength" href="javascript:void(0);">Add More</a>
                                      </div>
                            </div>
                              </div>
                             <?php } else {?>
                               <div class="row">
                            	  <div class="field_wrapper  pull-left">
                                      <div class="col-lg-3 col-md-3 col-sm-3">
                                      	<div class="form-group validate_msg">
                                            <label for="middle-name">Strenght<span class="required">*</span> </label>
                                            <input type="text" required="required" id="strength" name="strength[]"  class="form-control" value="">
                                      	</div>
                                      </div>
                                      
                                      <div class="col-lg-3 col-md-3 col-sm-3">
                                      	<div class="form-group validate_msg">
                                          	<label for="middle-name">Price /Per Qty<span class="required">*</span> </label>
                                            <input type="text" required="required"  id="per_price" name="per_price[]"  class="form-control" value="">
                                      	</div>
                                      </div> 
                                      
                                      <div class="col-lg-3 col-md-3 col-sm-3">
                                                   <div class="form-group">
                                                        <label for="middle-name">Strength Value</label>
                                                        <input type="text" id="strength_value" name="strength_value[]"  class="form-control" value="<?php echo filter_string($each['strength_value']);?>">
                                                    </div> 
                                                   </div>                                     
                                       
                                       <div class="col-lg-3 col-md-3 col-sm-3">
                                       		<label for="middle-name">&nbsp; </label> <br />
                                       		<a title="Add field" class="btn btn-info add_button" href="javascript:void(0);">Add More</a>
                                      </div>
                            </div>
                              </div>
                             <?php } ?> 
                           </div>
                        
                          <div role="tabpanel" class="tab-pane fade" id="quantity_tab" aria-labelledby="quantity-tab">
                           <?php if(!empty($get_medicine_quantity_details)){
						        	foreach($get_medicine_quantity_details as $each){
						     ?>
                      	    		 <div class="row pull-left">
                                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                                        <div class="form-group validate_msg">
                                                            <label for="middle-name">Quantity<span class="required">*</span></label>
                                                            <input type="number" required="required" id="quantity" name="quantity[]"  class="form-control" value="<?php echo $each['quantity'];?>">
                                                            <input type="hidden" name="quantity_id[]"  class="form-control" value="<?php echo $each['id'];?>">
                                                        </div>
                                                      </div>
                                                      
                                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                                        <div class="form-group validate_msg">
                                                            <label for="middle-name">Quantity txt<span class="required">*</span> </label>
                                                            <input type="text" id="quantity_txt" required="required" name="quantity_txt[]"  class="form-control" value="<?php echo filter_string($each['quantity_txt']);?>">
                                                        </div>
                                                      </div>
                                                      
                                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                                        <div class="form-group validate_msg">
                                                            <label for="middle-name">Discount percentage<span class="required">*</span> </label>
                                                            <input type="number" id="discount_precentage" required="required" name="discount_precentage[]"  class="form-control" value="<?php echo filter_string($each['discount_precentage']);?>">
                                                        </div>
                                                      </div>
                                                       
                                                       <div class="col-lg-3 col-md-3 col-sm-3">
                                                        <label for="middle-name">&nbsp; </label> <br />
                                                        <a class="btn btn-danger btn-xs" data-target="#confirm-delete-qt-<?php echo $each['id'];?>" data-toggle="modal" title="Delete" data-href="<?php echo base_url();?>medicine/delete-medicine-quantity/<?php echo $each['id'];?>" href="#">Remove</a>
                                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirm-delete-qt-<?php echo $each['id'];?>" class="modal fade">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        Warning !
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this quantity ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                                        <a class="btn btn-danger btn-ok" href="<?php echo base_url();?>medicine/delete-medicine-quantity/<?php echo $get_medicine_details['id'];?>/<?php echo $each['id'];?>">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                					   </div>
                                                  </div>
                                </div> 
                           <?php }// End fooreach Loop ?>
                                  <div class="row">
                                      <div class="field_wrapper_quantity">
                                               <div class="col-lg-12 col-md-6 col-sm-6">
                                                    <label for="middle-name">&nbsp; </label> <br />
                                                    <a title="Add field" class="btn btn-info add_button_quantity_edit" href="javascript:void(0);">Add More</a>
                                              </div>
                                     </div>      
                                   </div>
                             <?php } else {?>
                             		 <div class="row">
                                              <div class="field_wrapper_quantity pull-left">
                                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                                        <div class="form-group validate_msg">
                                                            <label for="middle-name">Quantity<span class="required">*</span> </label>
                                                            <input type="number" id="quantity" required="required" name="quantity[]"  class="form-control" value="">
                                                        </div>
                                                      </div>
                                                      
                                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                                        <div class="form-group validate_msg">
                                                            <label for="middle-name">Quantity txt<span class="required">*</span> </label>
                                                            <input type="text" id="quantity_txt" required="required" name="quantity_txt[]"  class="form-control" value="">
                                                        </div>
                                                      </div>
                                                      
                                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                                        <div class="form-group validate_msg">
                                                            <label for="middle-name">Discount percentage<span class="required">*</span> </label>
                                                            <input type="number" id="discount_precentage" required="required" name="discount_precentage[]"  class="form-control" value="">
                                                        </div>
                                                      </div>
                                                       
                                                       <div class="col-md-3 col-sm-3 col-xs-3">
                                                            <label for="middle-name">&nbsp; </label> <br />
                                                            <a title="Add field" class="btn btn-info add_button_quantity" href="javascript:void(0);">Add More</a>
                                                      </div>
                                            </div>      
                                </div>
                             <?php }?>
                          </div>
                         <div role="tabpanel" class="tab-pane fade" id="seo_tab" aria-labelledby="seo-tab">
          				  <div class="form-group">
                              <label for="middle-name">Meta Title:</label>
                                <input type="text" id="meta_title" name="meta_title"  class="form-control" value="<?php echo  filter_string($get_medicine_details['meta_title'])?>">
                		  </div>
                		  <div class="form-group">
                              <label for="middle-name">Meta Keywords:</label>
                                <textarea class="form-control" rows="3" placeholder="Meta Keywords" name="meta_keywords" id="meta_keywords"><?php echo filter_string($get_medicine_details['meta_keywords'])?></textarea>
                		 </div>
                         <div class="form-group">
                          <label for="middle-name">Meta Description:</label>
                           <textarea class="form-control" rows="3" placeholder="Meta Description" name="meta_description" id="meta_description"><?php echo filter_string($get_medicine_details['meta_description'])?></textarea>
                		
                        </div>
                        
                        </div>
                       </div>
                       
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_medicine_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_medicine_btn" id="new_medicine_btn">Update</button>
              							<input type="hidden" name="medicine_id" id="medicine_id" value="<?php echo filter_string($get_medicine_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_medicine_btn" id="new_medicine_btn">Submit</button>
              				<?php }//end if($get_medicine_details['id'])?>
            		</div>
          	  </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

