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
        
        <form data-toggle="validator" role="form" id="change_pass_frm" name="change_pass_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>trainings/submit-training">
        
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="<?php echo $cms_class?>"><a href="#cms_tab" id="cms-tab" role="tab" data-toggle="tab" aria-expanded="true">CMS</a> </li>
                <li role="presentation" class="<?php echo $seo_class?>"><a href="#seo_tab" role="tab" id="seo-tab" data-toggle="tab" aria-expanded="false">SEO</a> </li>
				<li role="presentation" class="<?php echo $cert_class?>"><a href="#cert_tab" role="tab" id="cert-tab" data-toggle="tab"  aria-expanded="false">Certificate</a> </li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade <?php echo $cms_class_div?>" id="cms_tab" aria-labelledby="cms-tab">
                  
                    <div class="form-group has-feedback">
                      <label for="last-name" data-toggle="tooltip" data-placement="right"  title="Add Training Course Name">Course Name<span class="required">*</span> <i class="fa fa-info-circle"></i> </label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                        <input type="text" id="course_name" name="course_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php if(filter_string($get_training_details['course_name'])!=""){ echo filter_string($get_training_details['course_name']);} else { echo $session_data['course_name'];}?>">
                         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group has-feedback">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="The Short description will appear on My Dashboard, under training section!">Short Description*: <i class="fa fa-info-circle"></i> </label>
                      <div class="col-md-12 col-sm-6 col-xs-12 validate_msg">
                       <textarea class="form-control" rows="3" required="required" placeholder="Short Description" name="short_description" id="short_description"><?php if(filter_string($get_training_details['short_description'])!=""){ echo filter_string($get_training_details['short_description']);} else { echo $session_data['short_description'];}?></textarea>
                         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors"></div>
                      </div>
                      
                    </div>
                    <div class="form-group">
                        <label data-toggle="tooltip" data-placement="right"  title="Long descriptipoion will appear on Training Main Page after purchase.">Long Description  <i class="fa fa-info-circle"></i></label>
                        <textarea class="ckeditor editor1"  id="long_description" name="long_description" rows="14"><?php if(filter_string($get_training_details['long_description'])!=""){ echo filter_string($get_training_details['long_description']);} else { echo $session_data['long_description'];}?></textarea>
                    </div>
					<div class="form-group has-feedback col-md-4">
                        <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Select the Usertype for which this Training will be available for.">User Type*: <i class="fa fa-info-circle"></i> </label>
                        <select name="user_type" id="user_type" class="form-control required"  required="required"  >
							<option value="">Choose</option>
							<?php if(!empty($user_types)){ ?>
								<?php foreach($user_types as $each): ?>
									<option <?php echo ($get_training_details['user_type'] == $each['id']) ? 'selected="selected"': '' ?> value="<?php echo $each['id']; ?>"><?php echo $each['user_type']; ?></option>
								<?php endforeach; ?>
							<?php } else { ?>
								<option value="">Empty</option>
							<?php } ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
					<?php /* ?>
					<div class="form-group validate_msg">
                        <label for="star_rating">Star Rating: </label>
                        <select name="star_rating" id="star_rating"  class="form-control"  required="required" >
							<?php for($i=1;$i<=5;$i++){ ?>
								<option <?php echo ($get_training_details['star_rating'] == $i) ? 'selected="selected"': '' ?>  value="<?php echo $i?>"><?php echo $i?> Star</option>
							<?php } //end for loop ?>
                        </select>
                    </div>
					<?php */ ?>
					<div class="form-group has-feedback col-md-4">
						<label data-toggle="tooltip" data-placement="right"  title="Author will be displayed along with the Training description.">Author*  <i class="fa fa-info-circle"></i></label>
						<input type="text" id="author" name="author" required="required" placeholder="Author Name" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['author']!="") { echo filter_string($get_training_details['author']);} else { echo $session_data['author'];}?>">
					
                    	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					  <div class="help-block with-errors"></div>
                    </div>
                    
					<div class="form-group has-feedback col-md-4">
						<label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Define No of Questions the user will have to attempt for pass the training.">No Of Questions: <i class="fa fa-info-circle"></i> </label>
						<input type="number" name="no_of_quizes" id="no_of_quizes" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['no_of_quizes']!="") { echo filter_string($get_training_details['no_of_quizes']);} else { echo $session_data['no_of_quizes'];}?>">
					
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<div class="help-block with-errors"></div>
                    </div>
					
					<!-- Start - Upload Image Row -->
					<div class="row">
						<div class="col-md-12" >
							<br />
							<div class="form-group  col-md-4 has-feedback">
								<label data-toggle="tooltip" data-placement="right"  title="Course Image, appears on the course section.">Course Image*: <i class="fa fa-info-circle"></i> </label>
								<?php if($get_training_details['course_image'] == ""){?>
									<input type="file" name="course_image" id="course_image"  required="required" />
								<?php } else { ?>
									<input type="file" name="course_image" id="course_image" />
									<span><img src="<?php echo FRONT_SURL;?>assets/training_course_images/<?php  echo $get_training_details['course_image'];?>" alt="Course Image" class="img-responsive" width="200px" style="padding-top:10px;"/></span>
							   <?php } ?>
                                <div class="help-block with-errors"></div>
								<p>
									<i>Allowed Extensions: jpg, jpeg, png, gif</i><br>
									<i>Maximum Size Allowed: 2MB</i>
								</p>
							</div>
							
							<div class="col-md-4">
								<label for="price" data-toggle="tooltip" data-placement="right"  title="The Actual Price of the Training">Price (&pound;)*:<span class="required">*</span>  <i class="fa fa-info-circle"></i></label>
								<div class="form-group has-feedback">
									<input type="number" id="price" name="price" required="required" placeholder="Price" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['price']!="") { echo filter_string($get_training_details['price']);} else if ($session_data['price']!=""){ echo $session_data['price'];} else { echo "0.00";}?>">
								  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								 <div class="help-block with-errors"></div>
                                </div>
							</div>
							
							<div class="col-md-4">
								<label for="discount_price" data-toggle="tooltip" data-placement="right"  title="Set the Discounted Price if there is any, for this training, else set 0.00 if there is no discount. (e.g. Price = (&pound) 12.00 you can set the Discount Price as (&pound) 10.00">Discount Price (&pound;)*:<span class="required">*</span>  <i class="fa fa-info-circle"></i></label>
								<div class="form-group has-feedback">
									<input type="number" id="discount_price" name="discount_price" placeholder="Discount Price" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['discount_price']!="") { echo filter_string($get_training_details['discount_price']);} else if ($session_data['discount_price']!=""){ echo $session_data['discount_price'];} else { echo '0.00';}?>">
                                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								    <div class="help-block with-errors"></div>
									<p>Set to 0.00 if there is no discount price</p>
								  
                                </div>
							</div>
							
						</div> 
					</div>
					<!-- End - Upload Image Row -->
					
					<div class="row">
						
						<div class="form-group has-feedback col-md-4">
							<label data-toggle="tooltip" data-placement="right"  title="Add training course video url">Course sample video (Url)*:  <i class="fa fa-info-circle"></i></label>
							<input type="url" id="course_sample_video" name="course_sample_video" required="required" placeholder="Video Urls" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['course_sample_video']!="") { echo filter_string($get_training_details['course_sample_video']);} else { echo $session_data['course_sample_video'];}?>">
                           
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>
						</div>
					
						<div class="form-group has-feedback col-md-4">
							<label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Set the Passing Percentage required to pass the Training">Training Pass Percentage*:  <i class="fa fa-info-circle"></i></label>
							<input type="number" name="training_pass_percentage" id="training_pass_percentage" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['training_pass_percentage']!="") { echo filter_string($get_training_details['training_pass_percentage']);} else { echo $session_data['training_pass_percentage'];}?>">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>
						</div>
					
						<div class="form-group has-feedback col-md-4">
							<label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Set the Expiry in Numbers, which will define this training will get expired in XX months (e.g 24) which means 2 years">Training Expiry Months*: <i class="fa fa-info-circle"></i></label>
							<input type="number" name="training_expiry_months" id="training_expiry_months" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['training_expiry_months']!="") { echo filter_string($get_training_details['training_expiry_months']);} else { echo $session_data['training_expiry_months'];}?>">
						 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>
                        </div>
					</div>
					
					<div class="row">
						<br />
						<div class="form-group has-feedback col-md-4">
							<label for="middle-name"  data-toggle="tooltip" data-placement="top"  title="Add training number of attempts allowed">Training Number of Attempts Allowed*: <i class="fa fa-info-circle"></i> </label>
							<input type="number" name="training_number_of_attempts_allowed" id="training_number_of_attempts_allowed" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['training_number_of_attempts_allowed']!="") { echo filter_string($get_training_details['training_number_of_attempts_allowed']);} else { echo $session_data['training_number_of_attempts_allowed'];}?>">
                           
                           <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>
						</div>
						
						<div class="form-group has-feedback col-md-4">
							<label for="middle-name" data-toggle="tooltip" data-placement="top"  title="This intimated how many attempts are allowed to make a test, after that Take the Quiz will be disabled, only admin will be able to reset it then">Training Reattempt Quiz Hours:  <i class="fa fa-info-circle"></i></label>
							<input type="number" name="training_reattempt_quiz_hours" id="training_reattempt_quiz_hours" required="required" class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['training_reattempt_quiz_hours']!="") { echo filter_string($get_training_details['training_reattempt_quiz_hours']);} else { echo $session_data['training_reattempt_quiz_hours'];}?>">
                            
						  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						 <div class="help-block with-errors"></div>
                        </div>

						<div class="validate_msg col-md-4">
							<label for="middle-name">Status: </label>
							<select name="status" id="status"  class="form-control" required="required">
								<option value="1" <?php echo ($get_training_details['status'] == '1') ? 'selected="selected"': '' ?>>Active</option>
								<option value="0" <?php echo ($get_training_details['status'] == '0') ? 'selected="selected"': '' ?>>InActive</option>
							</select>
						</div>
					
					</div>
					
                </div>
                
                <div role="tabpanel" class="tab-pane fade <?php echo $seo_class_div?>" id="seo_tab" aria-labelledby="seo-tab">
                  <div class="form-group">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Add Meta title">Meta Title: <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                      <input type="text" id="meta_title" name="meta_title"  class="form-control col-md-7 col-xs-12" value="<?php if($get_training_details['meta_title']!="") { echo filter_string($get_training_details['meta_title']);} else { echo $session_data['meta_title'];}?>">
                      </div>
                      
                    </div>
                    <div class="form-group">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Add Meta Keywords">Meta Keywords: <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                       <textarea class="form-control" rows="3" placeholder="Meta Keywords" name="meta_keywords" id="meta_keywords"><?php if($get_training_details['meta_title']!="") { echo filter_string($get_training_details['meta_title']);} else { echo $session_data['meta_title'];}?></textarea>
                      </div>
                      
                    </div>
                    <div class="form-group">
                      <label for="middle-name" data-toggle="tooltip" data-placement="right"  title="Add Meta Description">Meta Description: <i class="fa fa-info-circle"></i></label>
                      <div class="col-md-12 col-sm-6 col-xs-12">
                       <textarea class="form-control" rows="3" placeholder="Meta Description" name="meta_description" id="meta_description"><?php if($get_training_details['meta_description']!="") { echo filter_string($get_training_details['meta_description']);} else { echo $session_data['meta_description'];}?></textarea>
                      </div>
                    </div>
                </div>
				<div role="tabpanel" class="tab-pane fade <?php echo $cert_class_div?>" id="cert_tab" aria-labelledby="cert-tab">
				  <div class="form-group">
						<label data-toggle="tooltip" data-placement="right"  title="Add training certificate body">Certificate Body:  <i class="fa fa-info-circle"></i></label>
						<textarea class="ckeditor editor1"  id="training_certificate_body" name="training_certificate_body" rows="14"><?php if($get_training_details['training_certificate_body']!="") { echo filter_string($get_training_details['training_certificate_body']);} else { echo $session_data['training_certificate_body'];}?></textarea>
					</div>
				</div>
              </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              	<?php if($get_training_details['id']){?>
		                <button type="submit" class="btn btn-success" name="new_training_btn" id="new_training_btn">Update</button>
                        <input type="hidden" name="training_id" id="training_id" value="<?php echo filter_string($get_training_details['id'])?>" />
                        <input type="hidden" name="tab_id" id="tab_id" value="<?php echo $tab_id?>" />
                <?php }else{?>
                		<button type="submit" class="btn btn-success" name="new_training_btn" id="new_training_btn">Submit</button>
                <?php }//end if($get_training_details['id'])?>
              </div>
            </div>            
        </form>
      </div>
    </div>
  </div>
  
</div>
