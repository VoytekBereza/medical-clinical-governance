<div class="row">
  
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Add Video: <small><?php echo ucfirst($form_action); ?> video</small></h2>
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
				<form data-toggle="validator" role="form" class="form-horizontal form-label-left" action="<?php echo base_url(); ?>how-to-videos/add-edit-videos-process" method="post" id="add_update_video_form" name="add_update_video_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add video title">
									Video Title* <i class="fa fa-info-circle"></i> </label>
								</label>
								<input type="text" class="form-control" name="video_title" id="video_title" required="required" value="<?php echo filter_string($video['video_title']); ?>" />
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
                            
                            <!--
                            <div class="form-group has-feedback">
								<label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="give the embed code URL for Youtube or Prezi videos, (e.g: https://www.youtube.com/embed/2ZSFnTUftgQ)">
									Video Embed *
								</label>
								<textarea class="form-control" name="video_embed" id="video_embed" required><?php echo filter_string($video['video_embed'])?></textarea>
                                <small><em>Recommended embed code size (width: 250, Height: 200)</em></small>
                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
                                
							</div>
                            
							<div class="form-group has-feedback">
								<label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add video id">
									Video ID* <i class="fa fa-info-circle"></i>
								</label>
								<input type="text" class="form-control" name="video_id_col" id="video_id_col" required="required" value="<?php echo filter_string($video['video_id'])?>" />
                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
							</div>
                            
                            <div class="form-group">
								<label>
									Prezi Embed Code
								</label>
								<textarea aria-required="true" class="form-control" rows="3" name="video_prezi_url" id="video_prezi_url"/>< ?php echo ($video['video_prezi_url'] != '') ? $video['video_prezi_url'] : '' ?></textarea>
                            </div>-->
                             <div class="form-group col-md-12 pull-left" style="padding-left:0px;"> 
                            	
                                <label class="radio-inline" style="padding-left:0px;"><strong>Video Type</strong> </label>
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                 
                            	<label class="radio-inline">
                              	<input type="radio" name="default_type" <?php if($video['default_type']=="" || $video['default_type']=="prezi"){?>checked="checked"<?php }?> value="prezi">Prezi</label>
                                
                                <label class="radio-inline"></label>
                              	<label class="radio-inline"> <input type="radio"  name="default_type" <?php if($video['default_type']=="youtube"){?>checked="checked"<?php }?> value="youtube">Youtube</label>
                              
                            </div>
                            
                            <div class="form-group"></div>
                            <div class="form-group"></div>
                             
                             <div class="form-group col-md-2">
								<label> Display Order</label>
								<input type="text" class="form-control" name="display_order" id="display_order" value="<?php echo filter_string($video['display_order'])?>" />
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
							<br>
                            <br>
                            <br>
							<!-- Form (add_update_video_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_video_btn"><?php echo ucfirst($form_action); ?></button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="package_pgd_id" value="<?php echo $pgd_id; ?>" />
					<input type="hidden" name="video_id" value="<?php echo $video['id']; ?>" />
					<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
				</form>
			</div>
		</div>
	</div>
</div>