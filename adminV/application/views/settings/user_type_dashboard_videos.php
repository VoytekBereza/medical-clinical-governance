<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Dashboard Videos: <small> Dashboard video settings by user types</small></h2>
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
				<form  data-toggle="validator" role="form"  class="form-horizontal form-label-left" action="<?php echo base_url(); ?>settings/add-update-dashboard-videos" method="post" id="add_update_dashboard_videos_form" name="add_update_dashboard_videos_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php if(!empty($dashboard_videos)){ $i=1;  echo md5("Test1234"); ?>
								<?php foreach($dashboard_videos as $each): ?>
									<h3><?php echo $i; ?>): <?php echo $each['user_type']; ?></h3><br>
									<div class="form-group has-feedback">
										<label>
											Dashboard Video Title<span class="required">*</span>
										</label>
										<input type="text" class="form-control" name="dashboard_video_title[<?php echo $each['id']; ?>]" required="required" value="<?php echo ($each['dashboard_video_title'] != '') ? filter_string($each['dashboard_video_title']) : '' ?>" />
                                        
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									  <div class="help-block with-errors"></div>   
									</div>
									<div class="form-group has-feedback">
										<label>
											Dashboard Video URL<span class="required">*</span>
										</label>
										<input type="url" class="form-control" name="dashboard_video_url[<?php echo $each['id']; ?>]" required="required" value="<?php echo ($each['dashboard_video_url'] != '') ? $each['dashboard_video_url'] : '' ?>" />
                                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									 <div class="help-block with-errors"></div>    
									</div>
									<div class="form-group has-feedback">
										<label>
											Dashboard Video ID<span class="required">*</span>
										</label>
										<input type="text" class="form-control" name="dashboard_video_id[<?php echo $each['id']; ?>]" required="required" value="<?php echo ($each['dashboard_video_id'] != '') ? $each['dashboard_video_id'] : '' ?>" />
                                        
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									 <div class="help-block with-errors"></div>       
									</div>
									<div class="form-group">
										<label>
											Status
										</label>
										<select class="form-control" name="status[<?php echo $each['id']; ?>]" required="required" >
											  <option value="1" <?php echo ($each['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
											  <option value="0" <?php echo ($each['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
										</select>
									</div>
									<br>
								<!-- Input Hidden fields -->
								<input type="hidden" name="user_type_id[]" value="<?php echo $each['id']; ?>" />
								<?php $i++; endforeach; // End - foreach($dashboard_videos as $each): ?>
								
							<?php } // End - if(!empty($dashboard_videos)): ?>
							
							<br>
							<!-- Form (add_update_document_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_document_btn">Update</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>