<?php
	
	// session set form data in fields
	$session_data =  $this->session->flashdata();
	
	if($this->input->get('c') =='1'){
		
		$tab_id = 'c';
		$cert_class = 'active';
		$cert_class_div = 'active in';
		
	}elseif($this->input->get('p') =='1'){
		
		$tab_id = 'p';
		$cms_class = 'active';
		$cms_class_div = 'active in';
		
	}elseif($this->input->get('s') =='1'){
		
		$tab_id = 's';
		$seo_class = 'active';
		$seo_class_div = 'active in';
		
	}else{
		$tab_id = 'c';
		$cms_class = 'active';
		$cms_class_div = 'active in';
		
	}//end if($this->input->get('c') =='1')
		
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
			
            <?php if(filter_string($get_pgd_details['id'])=="") {?>
           <h2>Add New PGD <small>Add New PGD</small></h2>
           <?php } else {?>
           <h2>Update <?php echo filter_string($get_pgd_details['pgd_name']) ?> <small>Update <?php echo filter_string($get_pgd_details['pgd_name']) ?></small></h2>
           <?php }?>
           <?php if(filter_string($get_pgd_details['id'])!="") {?>
            		<a href="#" data-href="<?php echo base_url(); ?>pgd/delete-pgd/<?php echo $get_pgd_details['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $get_pgd_details['id']; ?>" class="btn btn-md btn-danger pull-right" title="Delete PGDs" >Delete</a>
            <?php }?>
            <br /><br />

            <div class="modal fade" id="confirm-delete-<?php echo $get_pgd_details['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            Warning !
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this PGD ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="<?php echo base_url(); ?>pgd/delete-pgd/<?php echo $get_pgd_details['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <form data-toggle="validator" role="form"  id="change_pass_frm" name="change_pass_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>pgd/add-new-pgd-process">        
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="<?php echo $cms_class?>"><a href="#cms_tab" id="cms-tab" role="tab" data-toggle="tab" aria-expanded="true">CMS</a> </li>
                <li role="presentation" class="<?php echo $seo_class?>"><a href="#seo_tab" role="tab" id="seo-tab" data-toggle="tab" aria-expanded="false">SEO</a> </li>
                <li role="presentation" class="<?php echo $cert_class?>"><a href="#cert_tab" role="tab" id="cert-tab" data-toggle="tab"  aria-expanded="false">Certificate</a> </li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade <?php echo $cms_class_div?>" id="cms_tab" aria-labelledby="cms-tab">
                  
                    <div class="form-group has-feedback">
                      <label for="last-name"  data-toggle="tooltip" data-placement="right"  title="Add PGD Name">PGD Name <span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                        <input type="text" id="pgd_name" name="pgd_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['pgd_name'] !="") { echo filter_string($get_pgd_details['pgd_name']); } else { echo $session_data['pgd_name'];}?>">
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					 <div class="help-block with-errors"></div>
                      </div>
                      
                    </div>
                    <div class="form-group validate_msg">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="The Short description will appear on My Dashboard, under PGD section!">Short Description <i class="fa fa-info-circle"></i> </label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                       <textarea class="form-control" rows="3" placeholder="Short Description" name="short_description" id="short_description"><?php if($get_pgd_details['short_description'] !="") { echo filter_string($get_pgd_details['short_description']); } else { echo $session_data['short_description'];}?></textarea>
                      </div>
                      
                    </div>
                    <div class="form-group validate_msg">
                        <label data-toggle="tooltip" data-placement="right"  title=" Add PGD Info Description">Info Description <i class="fa fa-info-circle"></i></label>
                        <textarea class="ckeditor editor1"  id="info_description" name="info_description" rows="14"><?php if($get_pgd_details['info_description'] !="") { echo filter_string($get_pgd_details['info_description']); } else { echo $session_data['info_description'];}?></textarea>
                    </div>
                    <div class="form-group validate_msg">
                        <label data-toggle="tooltip" data-placement="right"  title="Long descriptipoion will appear on PGD Main Page after purchase.">Long Description <i class="fa fa-info-circle"></i></label>
                        <textarea class="ckeditor editor1"  id="long_description" name="long_description" rows="14"><?php if($get_pgd_details['long_description'] !="") { echo filter_string($get_pgd_details['long_description']); } else { echo $session_data['long_description'];}?></textarea>
                    </div>
                    
                    <div class="form-group has-feedback">
                      <label for="price" data-toggle="tooltip" data-placement="right"  title="he Actual Price of the PGD">Price (&pound;): <span class="required">*</span> <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                        <input type="number" id="price" name="price" required="required" placeholder="Price" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['price'] !="") { echo $get_pgd_details['price']; } else if($session_data['price']!=""){ echo $session_data['price'];} else { echo '0.00';}?>">
                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					  <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    
                    <div class="form-group has-feedback">
                      <label for="discount_price" data-toggle="tooltip" data-placement="right"  title="Set the Discounted Price if there is any, for this PGD, else set 0.00 if there is no discount. (e.g. Price = (&pound) 12.00 you can set the Discount Price as (&pound) 10.00">Discount Price (&pound;): <span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                        <input type="number" id="discount_price" name="discount_price" placeholder="Discount Price" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['discount_price'] !="") { echo $get_pgd_details['discount_price']; } else if($session_data['discount_price']!=""){ echo $session_data['discount_price'];} else { echo '0.00';}?>">
                         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					 	<div class="help-block with-errors"></div>
                        <p>Set to 0.00 if there is no discount price</p>
                      </div>
                      
                    </div>
                    
                    <div class="form-group has-feedback">
                      <label for="discount_price" data-toggle="tooltip" data-placement="right"  title="Define No of Questions the user will have to attempt for pass the PGD.">No of Questions:<span class="required">*</span> <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                        <input type="number" id="no_of_quizes" name="no_of_quizes" placeholder="No. of Questions" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['no_of_quizes'] !="") { echo filter_string($get_pgd_details['no_of_quizes']); } else { echo $session_data['no_of_quizes'];}?>">
                       	 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					 	<div class="help-block with-errors"></div>
                        <p>Set number of questions to show while attempting the Quiz</p>
                      </div>
                      
                    </div>

                    <div class="form-group has-feedback col-md-6">
                        <label data-toggle="tooltip" data-placement="right"  title="This image will show to users who have passed the PGD!">Upload PGD Green Image*: <i class="fa fa-info-circle"></i></label>
                        <?php if($get_pgd_details['pgd_green_image']==""){?>
                        <input type="file" id="pgd_green_image" name="pgd_green_image"  required="required"/>
                         <?php } else {?>
                          <input type="file" id="pgd_green_image" name="pgd_green_image"/>
                        <span><img src="<?php echo FRONT_SURL;?>assets/pgd_images/<?php  echo $get_pgd_details['pgd_green_image'];?>" alt="Green Image" class="img-responsive" width="200px" style="padding-top:10px;"/></span>
                       <?php }?>
						<div class="help-block with-errors"></div>
                        <p>
                        	<i>Allowed Extensions: jpg, jpeg, png, gif</i><br>
                       		<i>Maximum Size Allowed: 2MB</i>
                        </p>
                        <p>Visible to the users who have passed the PGD</p>
                    </div>

                    <div class="form-group has-feedback col-md-6">
                        <label data-toggle="tooltip" data-placement="right"  title="This image will show to users who have not passed the PGD!">Upload PGD Red Image*: <i class="fa fa-info-circle"></i></label>
                         <?php if($get_pgd_details['pgd_red_image']==""){?>
                        <input type="file" name="pgd_red_image" id="pgd_red_image" required="required"/>
                         <?php } else {?>
                          <input type="file" name="pgd_red_image" id="pgd_red_image"/>
                        <span><img src="<?php echo FRONT_SURL;?>assets/pgd_images/<?php  echo $get_pgd_details['pgd_red_image'];?>" alt="Red Image" class="img-responsive" width="200px" style="padding-top:10px;"/></span>
                       <?php }?>
						<div class="help-block with-errors"></div>
                        <p>
                        	<i>Allowed Extensions: jpg, jpeg, png, gif</i><br>
                       		<i>Maximum Size Allowed: 2MB</i>
                        </p>
                         <p>Visible to the users who have not yet passed the PGD</p>
                    </div>
					
                    <div class="row pull-right">
						<div class="form-group has-feedback col-md-3">
							<label for="middle-name" data-toggle="tooltip" data-placement="top"  title="Set the Passing Percentage required to pass the PGD">PGD Pass Percentage: <i class="fa fa-info-circle"></i> </label>
							<input type="number" name="pgd_pass_percentage" id="pgd_pass_percentage" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['pgd_pass_percentage'] !="") { echo filter_string($get_pgd_details['pgd_pass_percentage']); } else { echo $session_data['pgd_pass_percentage'];}?>">
						
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors"></div>
                        </div>
						
						<div class="form-group has-feedback col-md-3">
							<label for="middle-name" data-toggle="tooltip" data-placement="top"  title="Set the Expiry in Numbers, which will define this PGD will get expired in XX months (e.g 24) which means 2 years">PGD Expiry Months: <i class="fa fa-info-circle"></i></label>
							<input type="number" name="pgd_expiry_months" id="pgd_expiry_months" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['pgd_expiry_months'] !="") { echo filter_string($get_pgd_details['pgd_expiry_months']); } else { echo $session_data['pgd_expiry_months'];}?>">
						
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors"></div>
                        </div>
						
						<div class="form-group has-feedback col-md-3">
							<label for="middle-name" data-toggle="tooltip" data-placement="top"  title="This intimated how many attempts are allowed to make a test, after that Take the Quiz will be disabled, only admin will be able to reset it then">PGD Number of Attempts Allowed: <i class="fa fa-info-circle"></i> </label>
							<input type="number" name="pgd_number_of_attempts_allowed" id="pgd_number_of_attempts_allowed" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['pgd_number_of_attempts_allowed'] !="") { echo filter_string($get_pgd_details['pgd_number_of_attempts_allowed']); } else { echo $session_data['pgd_number_of_attempts_allowed'];}?>">
                            
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>   
						</div>
						
						<div class="form-group has-feedback col-md-3">
							<label for="middle-name" data-toggle="tooltip" data-placement="top"  title="This defines after how many hours user can retake the test. (e.g 24) means 24 hours">PGD Reattempt Quiz Hours: <i class="fa fa-info-circle"></i></label>
							<input type="number" name="pgd_reattempt_quiz_hours" id="pgd_reattempt_quiz_hours" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['pgd_reattempt_quiz_hours'] !="") { echo filter_string($get_pgd_details['pgd_reattempt_quiz_hours']); } else { echo $session_data['pgd_reattempt_quiz_hours'];}?>">
						 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>  
                          
                        </div>
					</div>
					<div class="row">
						<div class="form-group has-feedback col-md-4">
							<label for="pgd_type" data-toggle="tooltip" data-placement="right"  title="Add PGD type Oral PGD OR Other PGD">PGD Type: <i class="fa fa-info-circle"></i></label>
							<select class="form-control" name="pgd_type" id="pgd_type">
								<option value="O" <?php echo ($get_pgd_details['pgd_type'] == 'O') ? 'selected="selected"' : ''?> >Oral - Standard PGD Packages (O)</option>
								<option value="OP" <?php echo ($get_pgd_details['pgd_type'] == 'OP') ? 'selected="selected"' : ''?>>Oral - Premium PGD Packages (OP)</option>
                                <option value="V" <?php echo ($get_pgd_details['pgd_type'] == 'V') ? 'selected="selected"' : ''?>>Other PGD (V)</option>
							</select>
                             <div class="help-block with-errors"></div>  
						</div>
						
						<!--<div class="form-group validate_msg">
							<label for="star_rating">PGD Rating: </label>
							<select name="star_rating" id="star_rating">
								<?php 
									for($i=1;$i<=5;$i++){
								?>
										<option <?php echo ($get_pgd_details['star_rating'] == $i) ? 'selected="selected"': '' ?>  value="<?php echo $i?>"><?php echo $i?> Star</option>
								<?php
									}//end for($i=1;$i<=5$i++)
								?>
							</select>
						</div>-->
											
						
						<div class="validate_msg col-md-4">
							<label for="is_rechas" data-toggle="tooltip" data-placement="right"  title="Enable Prerequisit Option Yes Or No">Enable Prerequisit?: <i class="fa fa-info-circle"></i></label>
							<select class="form-control" name="is_rechas" id="is_rechas">
								<option value="1"  <?php echo ($get_pgd_details['is_rechas'] == 1) ? 'selected="selected"': '' ?>>Yes</option>
								<option value="0" <?php echo ($get_pgd_details['is_rechas'] == 0) ? 'selected="selected"': '' ?>>No</option>
							</select>
						</div>
						
						<div class="validate_msg col-md-4">
							<label for="middle-name">Status: </label>
							<select class="form-control" name="status" id="status">
								<option value="1" <?php echo ($get_pgd_details['status'] == '1') ? 'selected="selected"': '' ?> > Active </option>
								<option value="0" <?php echo ($get_pgd_details['status'] == '0') ? 'selected="selected"': '' ?> > InActive </option>
							</select>
						</div>
						
					</div>
                </div>
                
                <div role="tabpanel" class="tab-pane fade <?php echo $seo_class_div?>" id="seo_tab" aria-labelledby="seo-tab">
                  <div class="form-group">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Add Meta Title">Meta Title: <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                      <input type="text" id="meta_title" name="meta_title"  class="form-control col-md-7 col-xs-12" value="<?php if($get_pgd_details['meta_title'] !="") { echo filter_string($get_pgd_details['meta_title']); } else { echo $session_data['meta_title'];}?>">
                      </div>
                      
                    </div>
                    <div class="form-group">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Add Meta Keywords">Meta Keywords: <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                       <textarea class="form-control" rows="3" placeholder="Meta Keywords" name="meta_keywords" id="meta_keywords"><?php if($get_pgd_details['meta_keywords'] !="") { echo filter_string($get_pgd_details['meta_keywords']); } else { echo $session_data['meta_keywords'];}?></textarea>
                      </div>
                      
                    </div>
                    <div class="form-group">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Add Meta Description">Meta Description: <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                       <textarea class="form-control" rows="3" placeholder="Meta Description" name="meta_description" id="meta_description"><?php if($get_pgd_details['meta_description'] !="") { echo filter_string($get_pgd_details['meta_description']); } else { echo $session_data['meta_description'];}?></textarea>
                      </div>
                    </div>
                    
                </div>
                <div role="tabpanel" class="tab-pane fade <?php echo $cert_class_div?>" id="cert_tab" aria-labelledby="cert-tab">
                  <div class="form-group">
                        <label data-toggle="tooltip" data-placement="right"  title="Add PGD Certificate Body">Certificate Body: <i class="fa fa-info-circle"></i></label>
                        <textarea class="ckeditor editor1"  id="pgd_certificate_body" name="pgd_certificate_body" rows="14"><?php if($get_pgd_details['pgd_certificate_body'] !="") { echo filter_string($get_pgd_details['pgd_certificate_body']); } else { echo $session_data['pgd_certificate_body'];}?></textarea>
                    </div>
                </div>
              </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              	<?php if($get_pgd_details['id']){?>
		                <button type="submit" class="btn btn-success" name="new_pgd_btn" id="new_pgd_btn">Update</button>
                        <input type="hidden" name="pgd_id" id="pgd_id" value="<?php echo filter_string($get_pgd_details['id'])?>" />
                        <input type="hidden" name="tab_id" id="tab_id" value="<?php echo $tab_id?>" />
                <?php }else{?>
                		<button type="submit" class="btn btn-success" name="new_pgd_btn" id="new_pgd_btn">Submit</button>
                <?php }//end if($get_pgd_details['id'])?>
              </div>
            </div>            
        </form>
      </div>
    </div>
  </div>
  
</div>
