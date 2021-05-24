<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Add New Training Documents Category:</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content"> 
				<?php if($this->session->flashdata('err_message')){?>
					<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
				<?php } // end if($this->session->flashdata('err_message')) ?>
				<?php if($this->session->flashdata('ok_message')){?>
						<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
				<?php } //if($this->session->flashdata('ok_message'))?>
				<br />
				<form  data-toggle="validator" role="form" class="form-horizontal form-label-left form_validate" action="<?php echo base_url(); ?>trainings/add-update-category" method="post" id="add_update_document_form" name="add_update_document_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                        
                            <!--<div class="form-group has-feedback">
								<label>
									Training*
								</label>
								<select class="form-control" name="training_id" id="training_id" required="required" >
                                 <option value="">Select Training</option>
                                  		<?php if(!empty($list_all_traings)){?>
                                        	<?php foreach($list_all_traings as $each) { ?>
                                      <option value="<?php echo $each['id']; ?>" <?php echo ($each['id'] == $category['training_id']) ? 'selected="selected"' : '' ?>><?php echo filter_string($each['course_name']);?></option>
                                      <?php 
									  		}// end foreach
									  	}//  end if conditions
									  ?>
								</select>
                               <div class="help-block with-errors"></div>
							</div>-->
							
                            <div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
								<label>
									Category name*
								</label>
								<input type="text" class="form-control" name="category_name" id="category_name" required="required" value="<?php echo ($category['category_name'] != '') ? filter_string($category['category_name']) : '' ?>" />
                                
                              <div class="help-block with-errors"></div>
							</div>
                            
							<div class="col-md-4 col-sm-4 col-xs-4 form-group validate_msg">
								<label>
									Status
								</label>
								<select class="form-control" name="status" id="status" required="required" >
                                      <option value="1" <?php echo ($category['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($category['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
								</select>
							</div>
							
                            <br>
							<!-- Form (add_update_category_form) - submit button -->
							<div class="col-md-4 col-sm-4 col-xs-4 form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_category_btn">Add new</button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="category_id" value="<?php echo $category['id']; ?>" />
					<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
                    <input type="hidden" name="training_id" value="<?php echo $get_training_details['id']; ?>" />
                   
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
       <div class="row">
			
			<h2>Training <small>Document Categories</small></h2>
			<!--
			<div class="nav navbar-right panel_toolbox">
				<a href="<?php echo base_url(); ?>trainings/add-new-training" class="btn btn-sm btn-success">Add New</a>
			</div> -->
			<div class="clearfix"></div>
             <?php if(!empty($categories)){ $DataTableId ="";} else { $DataTableId = '';}?>
			<table id=" <?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings">
						<th>Category Name</th>
						<th>Status</th>
						<th>Created Date</th>
						<th>Last Modified Date</th>
						</th>
					</tr>
				</thead>

				<tbody>
					<?php if(!empty($categories)){ $i = 1;?>
						<?php foreach($categories as $each): ?>
							<tr class="even pointer">
								<td class=" ">
                              
								<a data-original-title="Enter username" data-name="username" data-pk="1" data-type="text" id="username<?php echo $i;?>" href="#" class="editable editable-click"><?php echo filter_string($each['category_name']); ?></a>
                               
								</td>                            
								<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
								<td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
								<td class="a-right a-right "><?php echo kod_date_format($each['modified_date']); ?></td>
								<td class=" last">
									<!--<a href="<?php echo base_url(); ?>trainings/list-all-document-categories/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Edit document category" ><span class="glyphicon glyphicon-edit"></span> Edit</a>
									<a href="#" data-href="<?php echo base_url(); ?>trainings/delete-document-category/<?php echo $each['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" title="Delete document category" >X</a>-->
									<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													Warning !
												</div>
												<div class="modal-body">
													Are you sure you want to delete this category ?
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<a href="<?php echo base_url(); ?>trainings/delete-document-category/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						<?php $i++; endforeach; ?>
					<?php } ?>
				</tbody>
			</table>
			
			<br />
			<br />
			<br />

		</div>
      </div>
    </div>
  </div>
  
</div>