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
         <?php if($get_medicine_category_details['id']==""){?>
			<h2>Add New Medicine Category <small>Add New Medicine Category</small></h2>
			 <?php } else {?>
            <h2>Update Medicine Category <small>Update Medicine Category</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
        <form  data-toggle="validator" role="form" id="add_new_medicine_category_frm" name="add_new_medicine_category_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>medicine/add-update-medicine-category-process">
                 <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                 <li role="presentation" class="active"><a href="#medicine_cat_tab" id="medicine-cat-tab" role="tab" data-toggle="tab" aria-expanded="true">Medicine Category</a> </li>
                                 <li role="presentation" class=""><a href="#seo_tab" role="tab" id="seo-tab" data-toggle="tab" aria-expanded="false">SEO</a> </li>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                         	<div role="tabpanel" class="tab-pane fade active in" id="medicine_cat_tab" aria-labelledby="medicine-cat-tab">
                            <div class="form-group  has-feedback">
                              <label for="middle-name">Category<span class="required">*</span> </label>
                              <select name="parent_category_id" id="parent_category_id"  required="required" class="form-control">
                              		  <option value="">Select Category</option>
                              		<?php 
										  if(!empty($parent_category_list)){
												
												foreach($parent_category_list as $each){		  
											  
									 ?>
                                      <option value="<?php echo $each['id'];?>" <?php echo ($each['id']== $get_medicine_category_details['parent_category_id']) ? 'selected="selected"' : '' ?>><?php echo $each['category_name'];?></option>
                                      <?php 
									  			} // foreach end
										  }// If end
									  ?>
                              </select>
                             <div class="help-block with-errors"></div> 
                        </div>
                          	<div class="form-group has-feedback">
                            	<label>Category Title<span class="required">*</span> </label>
                           		 <input type="text" id="category_title" name="category_title" required="required" class="form-control" value="<?php echo filter_string($get_medicine_category_details['category_title'])?>">
                                 
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
                           </div>
                        
                            <div class="form-group">
                            <label>Category Sub Titile </label>
                            <input type="text" id="category_subtitle" name="category_subtitle"  class="form-control" value="<?php echo filter_string($get_medicine_category_details['category_subtitle'])?>">
                          </div>
                          
                          	<div class="form-group">
                            	<label>RAF Title</label>
                           		 <input type="text" id="raf_title" name="raf_title" class="form-control" value="<?php echo filter_string($get_medicine_category_details['raf_title'])?>">
                           </div>
                          	<div class="form-group">
                          <label>Description</label>
                          <textarea class="ckeditor editor1" id="description" name="description" rows="14"><?php echo filter_string($get_medicine_category_details['description'])?></textarea>
                		</div>
                        
                       		<div class="form-group">
                          <label>Long Description</label>
                          <textarea class="ckeditor editor1" id="long_description" name="long_description" rows="14"><?php echo filter_string($get_medicine_category_details['long_description'])?></textarea>
                		</div>
                            <div class="form-group">
                              <label for="middle-name">Show Online<span class="required">*</span> </label>
                              <select name="show_online" id="show_online"  required="required" class="form-control">
                                      <option value="1" <?php echo ($get_medicine_category_details['show_online'] == '1') ? 'selected="selected"' : '' ?>>Yes</option>
                                      <option value="0" <?php echo ($get_medicine_category_details['show_online'] == '0') ? 'selected="selected"' : '' ?>>No</option>
                              </select>
                        </div>
                        
                            <div class="form-group">
                              <label for="middle-name">Show Popular<span class="required">*</span> </label>
                              <select name="show_popular" id="show_popular"  required="required" class="form-control">
                                      <option value="1" <?php echo ($get_medicine_category_details['show_popular'] == '1') ? 'selected="selected"' : '' ?>>Yes</option>
                                      <option value="0" <?php echo ($get_medicine_category_details['show_popular'] == '0') ? 'selected="selected"' : '' ?>>No</option>
                              </select>
                        </div>
                         	
                            <div class="form-group">
                              <label for="middle-name">Status<span class="required">*</span> </label>
                              <select name="status" id="status"  required="required" class="form-control">
                                      <option value="1" <?php echo ($get_medicine_category_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($get_medicine_category_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                              </select>
                        </div>
                        
                            <div class="form-group has-feedback">
								<label>Category Image: </label>
							    <input type="file"   <?php if($get_medicine_category_details['category_image']==""){?> required="required"<?php }?> id="category_image" name="category_image">
                                <br  />
                                <?php if($get_medicine_category_details['category_image']!=""){?>
                  				<div class="form-group">
                                	 <label for="medicine_category_image">Medicine Category Image:</label>
                                	<img class="img-responsive" src="<?php echo MEDICINE_CATEGORY_IMAGES_THUMB;?><?php echo filter_string($get_medicine_category_details['category_image']);?>" />                    
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
                              <input type="text" id="meta_title" name="meta_title"  class="form-control" value="<?php echo  filter_string($get_medicine_category_details['meta_title'])?>">
                		</div>
                		  	<div class="form-group">
                              <label for="middle-name">Meta Keywords:</label>
                              <textarea class="form-control" rows="3" placeholder="Meta Keywords" name="meta_keywords" id="meta_keywords"><?php echo filter_string($get_medicine_category_details['meta_keywords'])?></textarea>
                		 </div>
                         	<div class="form-group">
                          	<label for="middle-name">Meta Description:</label>
                          	<textarea class="form-control" rows="3" placeholder="Meta Description" name="meta_description" id="meta_description"><?php echo filter_string($get_medicine_category_details['meta_description'])?></textarea>
                		</div>
                           </div>
                        </div>
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_medicine_category_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_category_btn" id="new_category_btn">Update</button>
              							<input type="hidden" name="category_id" id="category_id" value="<?php echo filter_string($get_medicine_category_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_category_btn" id="new_category_btn">Submit</button>
              				<?php }//end if($get_medicine_category_details['id'])?>
            		</div>
          	  </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
