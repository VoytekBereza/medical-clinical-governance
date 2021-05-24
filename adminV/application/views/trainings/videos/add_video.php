<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo filter_string($trainings_name); ?> Videos: <small><?php echo ucfirst($form_action); ?> video</small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<?php if($this->session->flashdata('err_message')){?>
					<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
				<?php } // end if($this->session->flashdata('err_message')) ?>
				<?php if($this->session->flashdata('ok_message')){?>
						<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
				<?php }//if($this->session->flashdata('ok_message'))?>
				<form data-toggle="validator" role="form" class="form-horizontal form-label-left form_validate" action="<?php echo base_url(); ?>trainings/add-update-video" method="post" id="add_update_video_form" name="add_update_video_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add video title">
									Video Title* <i class="fa fa-info-circle"></i> </label>
								</label>
								<input type="text" class="form-control" name="video_title" id="video_title" required="required" value="<?php echo ($video['video_title'] != '') ? filter_string($video['video_title']) : '' ?>" />
                                
                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="give the embed code URL for Youtube or Prezi videos, (e.g: https://www.youtube.com/embed/2ZSFnTUftgQ)">
									Video Url* <i class="fa fa-info-circle"></i>
								</label>
								<input type="url" class="form-control" name="video_url" id="video_url" required="required" value="<?php echo ($video['video_url'] != '') ? $video['video_url'] : '' ?>" />
							  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
                            </div>
							<div class="form-group has-feedback">
								<label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add video id">
									Video ID* <i class="fa fa-info-circle"></i>
								</label>
								<input type="text" class="form-control" name="video_id_col" id="video_id_col" required="required" value="<?php echo ($video['video_id'] != '') ? $video['video_id'] : '' ?>" />
                                
							 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group col-md-12 pull-left" style="padding-left:0px;">
                            	
                                <label class="radio-inline" style="padding-left:0px;">Default: </label>
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                 
                            	<label class="radio-inline">
                              	<input type="radio" name="video_type" <?php if($video['video_type']=="" || $video['video_type']=="1"){?>checked="checked"<?php }?> value="1">Prezi</label>
                                
                                <label class="radio-inline"></label>
                              	<label class="radio-inline"> <input type="radio"  name="video_type" <?php if($video['video_type']=="0"){?>checked="checked"<?php }?> value="0">Youtube</label>
                              
                            </div>
                              <div class="form-group"></div>
                              <div class="form-group"></div>
                              
                                    
                            <div class="form-group col-md-2">
								<label>
									Mark as intro
								</label>
								<select class="form-control" name="default_video"  id="default_video" >
                                      <option value="0" <?php echo ($video['default_video'] == '0' || $video['default_video'] == '') ? 'selected="selected"' : '' ?>>No</option>
                                      <option value="1" <?php echo ($video['default_video'] == '1') ? 'selected="selected"' : '' ?>>Yes</option>
								</select>
							</div>
                            
							<div class="form-group col-md-2 validate_msg">
								<label>
									Status
								</label>
								<select class="form-control" name="status"  id="status" required="required" >
                                      <option value="1" <?php echo ($video['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($video['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
								</select>
							</div>
                            
                          <div class="form-group"></div>
							<br>
							<!-- Form (add_update_video_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_video_btn"><?php echo ucfirst($form_action); ?></button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
					<input type="hidden" name="video_id" value="<?php echo $video['id']; ?>" />
					<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
				</form>
			</div>
		</div>
	</div>
</div>