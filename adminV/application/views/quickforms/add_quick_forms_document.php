<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				 <?php if($get_quick_forms_document_details['id']==""){?>
                        <h2>Add New Quick Fomrs document <small>Add New Quick Fomrs Document</small></h2>
                         <?php } else {?>
                        <h2>Update Quick Fomrs document <small>Update Quick Fomrs Document</small></h2>
            <?php }?>
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
				<form  data-toggle="validator" role="form" class="form-horizontal form-label-left" action="<?php echo base_url(); ?>quickforms/add-new-quick-fomrs-documents-process" method="post" id="add_update_document_form" name="add_update_document_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label>
									Category
								</label>
								<select class="form-control" name="category_id" id="category_id" required="required">
                                			 <option value="">Select Category</option>
									<?php if(!empty($list_quick_forms_category)){ ?>
										<?php foreach($list_quick_forms_category as $each): ?>
											<option <?php echo ($get_quick_forms_document_details['category_id'] == $each['id']) ? 'selected="selected"' : '' ?> value="<?php echo $each['id']; ?>"><?php echo filter_string($each['category_name']); ?></option>
										<?php endforeach; ?>
									<?php } ?>
								</select>
                               <div class="help-block with-errors"></div>
							</div>
                            
                            <div class="form-group has-feedback">
								<label>
									Document Type
								</label>
								<select class="form-control" name="document_icon" id="document_icon" required="required" >
                                      <option value="">Select Document Type</option>
                                      <option value="fa fa-file-pdf-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-pdf-o') ? 'selected="selected"' : '' ?>>PDF</option>
                                      <option value="fa fa-file-word-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-word-o') ? 'selected="selected"' : '' ?>>DOC</option>
                                      <option value="fa fa-file-powerpoint-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-powerpoint-o') ? 'selected="selected"' : '' ?>>PPT</option>
                                      <option value="fa fa-file-zip-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-zip-o') ? 'selected="selected"' : '' ?>>Zip</option>
                                      <option value="fa fa-file-video-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-video-o') ? 'selected="selected"' : '' ?>>Video</option>
                                      <option value="fa fa-file-audio-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-audio-o') ? 'selected="selected"' : '' ?>>Audio</option>
                                      <option value="fa fa-file-excel-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-excel-o') ? 'selected="selected"' : '' ?>>CSV</option>
                                      <option value="fa fa-file-o" <?php echo ($get_quick_forms_document_details['document_icon'] == 'fa fa-file-o') ? 'selected="selected"' : '' ?>>General Type</option>
								</select>
                                 <div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<label>
									Quick Form Title
								</label>
								<input type="text" class="form-control" name="document_title" id="document_title" required="required" value="<?php echo ($get_quick_forms_document_details['document_title'] != '') ? filter_string($get_quick_forms_document_details['document_title']) : '' ?>" />
                                 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				   			   <div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<label>
									Quick Form Document Url
								</label>
								<input type="url" class="form-control" name="document_url" required="required" value="<?php echo ($get_quick_forms_document_details['document_url'] != '') ? $get_quick_forms_document_details['document_url'] : '' ?>" />
                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				   			 <div class="help-block with-errors"></div>   
							</div>
							<div class="form-group">
								<label>
									Status
								</label>
								<select class="form-control" name="status" id="status" required="required" >
                                      <option value="1" <?php echo ($get_quick_forms_document_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($get_quick_forms_document_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
								</select>
							</div>
							<br>
							<!-- Form (add_update_document_form) - submit button -->
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_quick_forms_document_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_document_btn" id="new_document_btn">Update</button>
              							<input type="hidden" name="document_id" id="document_id" value="<?php echo filter_string($get_quick_forms_document_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_document_btn" id="new_document_btn">Submit</button>
              				<?php }//end if($get_quick_forms_document_details['id'])?>
            		        </div>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>