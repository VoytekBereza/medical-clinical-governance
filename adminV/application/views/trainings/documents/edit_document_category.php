<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Edit Folder <small> Edit "<?php echo filter_string($category['category_name']); ?>" Folder</small></h2>
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
				<form  class="form-horizontal form-label-left form_validate" action="<?php echo base_url(); ?>trainings/add-update-category" method="post" id="add_update_document_form" name="add_update_document_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                            
							<div class="form-group validate_msg">
                            
                            <label for="middle-name"   title="Add folder title">
									Folder Name*  </label>
						    </label>
								<input type="text" class="form-control" name="category_name" id="category_name" required="required" value="<?php echo ($document_category['category_name'] != '') ? filter_string($document_category['category_name']) : '' ?>" />
                               
							</div>
							
							<div class="form-group validate_msg">
								<label>
									Status
								</label>
								<select class="form-control" name="status" id="status" required="required" >
                                      <option value="1" <?php echo ($document_category['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($document_category['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
								</select>
							</div>
							<br>
							<!-- Form (add_update_document_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_document_btn">update</button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="training_id" value="<?php echo $course_id; ?>" />
					<input type="hidden" name="category_id" value="<?php echo $document_category['id']; ?>" />
                
					<input type="hidden" name="action" value="update" />
				</form>
		</div>
	</div>
</div>
