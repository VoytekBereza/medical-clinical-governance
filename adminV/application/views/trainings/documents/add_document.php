
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Documents: <small><?php echo ucfirst($form_action); ?> "<?php echo filter_string($category['category_name']); ?>" document</small></h2>
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
			<form  data-toggle="validator" role="form"  class="form-horizontal form-label-left" action="<?php echo base_url(); ?>trainings/add-update-document" method="post" id="add_update_document_form" name="add_update_document_form">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						
						<?php /* ?>
						<div class="form-group has-feedback">
							<label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Select document category">
								Category* <i class="fa fa-info-circle"></i>
							</label>
							<select class="form-control" name="category_id" id="category_id" required="required">
								<option value="">Choose</option>
                                <option <?php echo ($document['category_id'] == '0') ? 'selected="selected"' : '' ?> value="0">None</option>
								<?php if($document_categories){ ?>
									<?php foreach($document_categories as $each): ?>
										<option <?php echo ($document['category_id'] == $each['id']) ? 'selected="selected"' : '' ?> value="<?php echo $each['id']; ?>"><?php echo filter_string($each['category_name']); ?></option>
									<?php endforeach; ?>
								<?php }?>
							</select>
						  	<div class="help-block with-errors"></div>
						</div>
						<?php */ ?>

						<!-- Input hidden field to contain category_id -->
						<input type="hidden" name="category_id" id="category_id" value="<?php echo filter_string($category_id); ?>" />

                        <div class="form-group has-feedback">
                            <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Select document type">
								Document Type* <i class="fa fa-info-circle"></i>
							</label>
							<select class="form-control" name="document_icon" id="document_icon" required="required" >
                                  <option value="">Select Document Type</option>
                                  <option value="fa fa-file-pdf-o" <?php echo ($document['document_icon'] == 'fa fa-file-pdf-o') ? 'selected="selected"' : '' ?>>PDF</option>
                                  <option value="fa fa-file-word-o" <?php echo ($document['document_icon'] == 'fa fa-file-word-o') ? 'selected="selected"' : '' ?>>DOC</option>
                                  <option value="fa fa-file-powerpoint-o" <?php echo ($document['document_icon'] == 'fa fa-file-powerpoint-o') ? 'selected="selected"' : '' ?>>PPT</option>
                                  <option value="fa fa-file-zip-o" <?php echo ($document['document_icon'] == 'fa fa-file-zip-o') ? 'selected="selected"' : '' ?>>Zip</option>
                                  <option value="fa fa-file-video-o" <?php echo ($document['document_icon'] == 'fa fa-file-video-o') ? 'selected="selected"' : '' ?>>Video</option>
                                  <option value="fa fa-file-audio-o" <?php echo ($document['document_icon'] == 'fa fa-file-audio-o') ? 'selected="selected"' : '' ?>>Audio</option>
                                  <option value="fa fa-file-excel-o" <?php echo ($document['document_icon'] == 'fa fa-file-excel-o') ? 'selected="selected"' : '' ?>>CSV</option>
                                  <option value="fa fa-file-o" <?php echo ($document['document_icon'] == 'fa fa-file-o') ? 'selected="selected"' : '' ?>>General Type</option>
							</select>
                           <div class="help-block with-errors"></div>
						</div>
						<div class="form-group has-feedback">
                        
                        <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add document title">
								Document Title* <i class="fa fa-info-circle"></i> </label>
					    </label>
							<input type="text" class="form-control" name="document_title" id="document_title" required="required" value="<?php echo ($document['document_title'] != '') ? filter_string($document['document_title']) : '' ?>" />
                            
                            <div class="help-block with-errors"></div>
						</div>
						<div class="form-group  has-feedback">
                        
                         <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add document url">
								Document Url* <i class="fa fa-info-circle"></i> </label>
					    </label>
						
							<input type="url" class="form-control" name="document_url" required="required" value="<?php echo ($document['document_url'] != '') ? $document['document_url'] : '' ?>" />
						 <div class="help-block with-errors"></div>
                        </div>
						<div class="form-group validate_msg">
							<label>
								Status
							</label>
							<select class="form-control" name="status" id="status" required="required" >
                                  <option value="1" <?php echo ($document['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                  <option value="0" <?php echo ($document['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
							</select>
						</div>
						<br>
						<!-- Form (add_update_document_form) - submit button -->
						<div class="form-group pull-right">
							<button type="submit" class="btn btn-sm btn-success" name="add_edit_document_btn"><?php echo ucfirst($form_action); ?></button>
						</div>
					</div>
				</div>
				<!-- Input Hidden Field -->
				<input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
				<input type="hidden" name="document_id" value="<?php echo $document['id']; ?>" />
				<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
			</form>
		</div>
	</div>
</div>
