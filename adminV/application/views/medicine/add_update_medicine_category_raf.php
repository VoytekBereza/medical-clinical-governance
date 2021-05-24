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
         <?php if($get_medicine_category_raf_details['id']==""){?>
			<h2>Add New <?php echo filter_string($category_details['category_title']);?> RAF <small>Add New <?php echo filter_string($category_details['category_title']);?> RAF</small></h2>
			 <?php } else {?>
            <h2>Update <?php echo filter_string($category_details['category_title']);?> RAF <small>Update <?php echo filter_string($category_details['category_title']);?> RAF</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
        <form   id="add_new_medicine_category_raf_frm" name="add_new_medicine_category_raf_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>medicine/add-update-medicine-category-raf-process">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="myTabContent" class="tab-content">
                            
                           <div class="form-group validate_msg">
                          <label for="middle-name">RAF Label<span class="required">*</span></label>
                          <select name="raf_label_id" id="raf_label_id" class="form-control" required="required">
                                  <option value="">Select RAF Label</option>
                                <?php
                                      if(!empty($medicine_raf_labels_list)){
                                            
                                            foreach($medicine_raf_labels_list as $each){		  
                                          
                                 ?>
                                  <option value="<?php echo $each['id'];?>" <?php echo ($each['id']== $get_medicine_category_raf_details['raf_label_id']) ? 'selected="selected"' : '' ?>><?php echo $each['label'];?></option>
                                  <?php 
                                            } // foreach end
                                      }// If end
                                  ?>
                          </select>
                     </div>
                          	<div class="form-group validate_msg">
                            	<label>Question<span class="required">*</span> </label>
                                 <textarea class="ckeditor editor1" id="question" name="question" rows="14"><?php echo filter_string($get_medicine_category_raf_details['question'])?></textarea>
                           		 <!--<input type="text" id="question" name="question" required="required" class="form-control" value="<?php echo filter_string($get_medicine_category_raf_details['question'])?>">-->
                           </div>
                           <div class="form-group validate_msg">
                          <label for="middle-name">Required Answer<span class="required">*</span></label>
                          <select name="required_answer" id="required_answer" class="form-control" required="required">
                                  <option value="">Select required answer</option>
                                  <option value="Y" <?php if($get_medicine_category_raf_details['required_answer']=='Y'){?> selected="selected"<?php }?>>Yes</option>
                                  <option value="N" <?php if($get_medicine_category_raf_details['required_answer']=='N'){?> selected="selected"<?php }?>>No</option>
                          </select>
                     </div>
                           <div class="form-group validate_msg">
                          <label for="middle-name">Error Type<span class="required">*</span></label>
                          <select name="error_type" id="error_type" class="form-control" required="required">
                                  <option value="">Select error type</option>
                                  <option value="E" <?php if($get_medicine_category_raf_details['error_type']=='E'){?> selected="selected"<?php }?>>Error</option>
                                  <option value="W" <?php if($get_medicine_category_raf_details['error_type']=='W'){?> selected="selected"<?php }?>>Warning</option>
                          </select>
                     </div>
                           
                       <div class="form-group validate_msg">
                            <label>
                               Error Message<span class="required">*</span>
                            </label>
                            <textarea id="error_message" name="error_message" placeholder="Error Message" required="required" rows="3" class="form-control" aria-required="true"><?php echo filter_string($get_medicine_category_raf_details['error_message'])?></textarea>
                        </div>
                        
                        <!--<div class="form-group">
                            <label>Details</label>
                            <textarea class="ckeditor editor1" id="details" name="details" rows="14"><?php echo filter_string($get_medicine_category_raf_details['details'])?></textarea>
                		</div>-->
                       </div>
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_medicine_category_raf_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_medicine_raf_btn" id="new_medicine_category_raf_btn">Update</button>
              							<input type="hidden" name="medicine_category_raf_id" id="medicine_category_raf_id" value="<?php echo filter_string($get_medicine_category_raf_details['id'])?>" />
                                        <input type="hidden" name="category_id" id="category_id" value="<?php echo $this->uri->segment(3);?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_medicine_raf_btn" id="new_medicine_category_raf_btn">Submit</button>
                                        <input type="hidden" name="category_id" id="category_id" value="<?php echo $this->uri->segment(3);?>" />
              				<?php }//end if($get_medicine_category_raf_details['id'])?>
            		</div>
          	  </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

