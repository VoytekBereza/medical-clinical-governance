
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
        <?php if($get_sop_details['id']==""){?>
			<h2>Add New SOPs <small>Add New SOPs</small></h2>
			 <?php } else {?>
             <h2>Update SOPs <small>Update SOPs</small></h2>
             <?php }?>
			<div class="clearfix"></div>
			</div>
        <form    id="add_new_sop_frm" name="add_new_sop_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>governance/add-new-sop-process">
                 <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="row"> 
                                	<label for="middle-name">Select User Type<span class="required">*</span> </label>      							
                                </div>
                                <?php 
									  if($get_sop_details['user_types']!=""){
											$user_types_id = explode(",",$get_sop_details['user_types']);
										}
                ?>
								<?php if(!empty($list_user_type)){
										
                        foreach($list_user_type as $each){
?>
                                    <label class="checkbox-inline"> 
                                      <input type="checkbox" name="user_types[]" id="user_types" <?php if($get_sop_details['user_types']!="") {if (in_array($each['id'], $user_types_id)){?> checked="checked"<?php } }?> value="<?php echo $each['id'];?>" ><?php echo filter_string($each['user_type']);?>
                                    </label>
<?php 
										    }// end foreach loop
                                       
                }// end if(!empty($list_user_type)){
?>
                <div class="help-block with-errors"></div>

              </div>
                           
							<br/>                        
            	<div class="form-group">
            		
                <label>SOPs Title<span class="required">*</span> </label>
            		
                <input type="text" id="sop_title" name="sop_title" class="form-control"  value="<?php echo filter_string($get_sop_details['sop_title'])?>">			
                
              </div>
                          <div class="form-group">
                              <label for="middle-name">Select SOP Category<span class="required">*</span> </label>
                              <select name="sopcategoryid" id="sopcategoryid"   class="form-control">
                                              <option value="">Select SOP Category</option>
                                  <?php
								        if(!empty($get_all_sop_categories_arr)){
								
									       if(count($get_all_sop_categories_arr) > 0){
								
										         foreach($get_all_sop_categories_arr as $index => $sopcategories_arr_val){
                                   ?>				
                            					<option value="<?php echo $sopcategories_arr_val['id'];?>" <?php if($sopcategories_arr_val['id']==$get_sop_details['category_id'] || $category_id && $category_id ==  $sopcategories_arr_val['id']) { ?> selected="selected" <?php }?>> <?php echo filter_string($sopcategories_arr_val['category_name']);?></option>  
                            				
                                   <?php			
												  }
										    }
									    }
										
                                    ?>	
                              </select>
                             <div class="help-block with-errors"></div> 
                        </div>
                         <div class="form-group ">
                  			<label>SOPs Description</label>
                  			<textarea class="ckeditor editor1" id="sop_description" name="sop_description" rows="14"><?php echo filter_string($get_sop_details['sop_description'])?></textarea>
                		</div>
                          <div class="form-group">
                              <label for="middle-name">Status<span class="required">*</span> </label>
                              <select name="status" id="status"  required="required" class="form-control">
                                      <option value="1" <?php echo ($get_sop_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($get_sop_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                              </select>
                        </div>
          
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12">
             					 <?php if($get_sop_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_sop_btn" id="new_sop_btn">Update</button>
              							<input type="hidden" name="sop_id" id="sop_id" value="<?php echo filter_string($get_sop_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success btn-default" name="new_sop_btn" id="new_sop_btn">Submit</button>
              				<?php }//end if($get_sop_details['id'])?>
            		</div>
          	  </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
