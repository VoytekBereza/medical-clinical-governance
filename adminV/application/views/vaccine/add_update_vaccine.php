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
         <?php if($get_vaccine_details['id']==""){?>
			<h2>Add New Vaccine <small>Add New Vaccine</small></h2>
			 <?php } else {?>
            <h2>Update Vaccine <small>Update Vaccine</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form" id="add_new_vaccine_frm" name="add_new_vaccine_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>vaccine/add-update-vaccine-process">
                 <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                 <li role="presentation" class="active"><a href="#medicine_cat_tab" id="medicine-cat-tab" role="tab" data-toggle="tab" aria-expanded="true">Vaccine CMS</a> </li>
                                 <li role="presentation" class=""><a href="#seo_tab" role="tab" id="seo-tab" data-toggle="tab" aria-expanded="false">SEO</a> </li>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                         	<div role="tabpanel" class="tab-pane fade active in" id="medicine_cat_tab" aria-labelledby="medicine-cat-tab">
                            <div class="form-group has-feedback">
                               <label>Vaccine Type
                               <span class="required">*</span> 
                              
                             </label>
                              <select name="vaccine_type" id="vaccine_type"  required="required" class="form-control">
                              		  <option value="">Select Vaccine Type</option>
                                      <option value="T" <?php if($get_vaccine_details['vaccine_type'] =="T") { ?> selected="selected"<?php } ?>><?php echo "Travel";?></option>
                                      <option value="F" <?php if($get_vaccine_details['vaccine_type'] =="F") { ?> selected="selected"<?php } ?>><?php echo "Flue";?></option>
                              </select>
                        <div class="help-block with-errors"></div>
                        </div>
                          	<div class="form-group has-feedback">
                             <label for="vaccine_name">Vaccine Title<span class="required">*</span> 
                             </label>
                            	
                           		 <input type="text" id="vaccine_title" name="vaccine_title" required="required" class="form-control" value="<?php echo filter_string($get_vaccine_details['vaccine_title'])?>">
                                 
                         	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"></div>
                           </div>
                        
                            <div class="form-group has-feedback">
                            <label for="middle-name">Short Description<span class="required" aria-required="true">*</span></label>
                            <textarea aria-required="true" class="form-control" rows="3" required="required" placeholder="Short Description" name="short_description" id="short_description"><?php echo filter_string($get_vaccine_details['short_description'])?></textarea>
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>
                        </div>
                        
                          <div class="form-group">
                          <label>Description</label>
                          <textarea class="ckeditor editor1" id="description" name="description" rows="14"><?php echo filter_string($get_vaccine_details['description'])?></textarea>
                		</div>
                         	
                          	<div class="form-group has-feedback">
								<label>Vaccine Image: </label>
							    <input type="file"   <?php if($get_vaccine_details['images_src']==""){?> required="required"<?php }?> id="images_src" name="images_src">
                                <br  />
                                <?php if($get_vaccine_details['images_src']!=""){?>
                  				<div class="form-group">
                                	 <label for="medicine_category_image">Vaccine Image:</label>
                                	<img class="img-responsive" src="<?php echo VACCINE_IMAGES_THUMB;?><?php echo filter_string($get_vaccine_details['images_src']);?>" />                    
                            	 </div>
                 				<?php }?>
                                 <div class="help-block with-errors"></div>
								<p><i>Allowed Extensions: jpg, jpeg, png, gif</i><br><i>Maximum Size Allowed: 2MB</i>
								</p>
							</div>
          				   </div>
                           <div role="tabpanel" class="tab-pane fade" id="seo_tab" aria-labelledby="seo-tab">
          				  	<div class="form-group">
                              <label for="middle-name">Meta Title:</label>
                              <input type="text" id="meta_title" name="meta_title"  class="form-control" value="<?php echo  filter_string($get_vaccine_details['meta_title'])?>">
                		</div>
                		  	<div class="form-group">
                              <label for="middle-name">Meta Keywords:</label>
                              <textarea class="form-control" rows="3" placeholder="Meta Keywords" name="meta_keywords" id="meta_keywords"><?php echo filter_string($get_vaccine_details['meta_keywords'])?></textarea>
                		 </div>
                         	<div class="form-group">
                          	<label for="middle-name">Meta Description:</label>
                          	<textarea class="form-control" rows="3" placeholder="Meta Description" name="meta_description" id="meta_description"><?php echo filter_string($get_vaccine_details['meta_description'])?></textarea>
                		</div>
                           </div>
                        </div>
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_vaccine_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_vaccine_btn" id="new_vaccine_btn">Update</button>
              							<input type="hidden" name="vaccine_id" id="vaccine_id" value="<?php echo filter_string($get_vaccine_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_vaccine_btn" id="new_vaccine_btn">Submit</button>
              				<?php }//end if($get_vaccine_details['id'])?>
            		</div>
          	  </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
