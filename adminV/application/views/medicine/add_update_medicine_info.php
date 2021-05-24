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
         <?php if($get_medicine_info_details['id']==""){?>
			<h2>Add New <?php echo filter_string($medicine_details['medicine_name']);?> info <small>Add New <?php echo filter_string($medicine_details['medicine_name']);?> info</small></h2>
			 <?php } else {?>
            <h2>Update <?php echo filter_string($medicine_details['medicine_name']);?> info <small>Update <?php echo filter_string($medicine_details['medicine_name']);?> info</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
        <form   id="add_new_medicine_info_frm" name="add_new_medicine_info_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>medicine/add-update-medicine-info-process">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="myTabContent" class="tab-content">
                            
                          	<div class="form-group validate_msg">
                            	<label  data-toggle="tooltip" data-placement="right"  title="Please Add medicine info title">Title<span class="required">* <i class="fa fa-info-circle"></i></span> </label>
                           		 <input type="text" id="tabs_title" name="tabs_title" required="required" class="form-control" value="<?php echo filter_string($get_medicine_info_details['tabs_title'])?>">
                           </div>
                       <!--<div class="form-group validate_msg">
                          <label for="middle-name">Medicine</label>
                          <select name="medicine_id" id="medicine_id" class="form-control" required="required">
                                  <option value="">Select Medicine</option>
                                <?php 
                                      if(!empty($medicine_list)){
                                            
                                            foreach($medicine_list as $each){		  
                                          
                                 ?>
                                  <option value="<?php echo $each['id'];?>" <?php echo ($each['id']== $get_medicine_info_details['medicine_id']) ? 'selected="selected"' : '' ?>><?php echo $each['brand_name'].' - '.$each['medicine_name'];?></option>
                                  <?php 
                                            } // foreach end
                                      }// If end
                                  ?>
                          </select>
                     </div>-->
                        <div class="form-group">
                            <label data-toggle="tooltip" data-placement="right"  title="Please Add medicine info Description">Description <i class="fa fa-info-circle"></i></label>
                            <textarea class="ckeditor editor1" id="tabs_description" name="tabs_description" rows="14"><?php echo filter_string($get_medicine_info_details['tabs_description'])?></textarea>
                		</div>
                       </div>
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_medicine_info_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_medicine_info_btn" id="new_medicine_info_btn">Update</button>
              							<input type="hidden" name="medicine_info_id" id="medicine_info_id" value="<?php echo filter_string($get_medicine_info_details['id'])?>" />
                                        <input type="hidden" name="medicine_id" id="medicine_id" value="<?php echo $this->uri->segment(3);?>" />
                                        
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_medicine_info_btn" id="new_medicine_info_btn">Submit</button>
                                        <input type="hidden" name="medicine_id" id="medicine_id" value="<?php echo $this->uri->segment(3);?>" />
              				<?php }//end if($get_medicine_info_details['id'])?>
            		</div>
          	  </div>
          </div>
          </div>
          		
        </form>
      </div>
    </div>
  </div>
</div>

