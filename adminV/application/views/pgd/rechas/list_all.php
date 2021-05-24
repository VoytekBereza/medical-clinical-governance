<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo ($this->uri->segment(4) != '') ? 'Update' : 'Add new' ?> <?php echo filter_string($pgd_details['pgd_name']);?> Prerequisit:</h2>
				<?php if($this->uri->segment(4) != ''){ ?>
					<div class="nav navbar-right panel_toolbox">
						<a href="<?php echo base_url(); ?>pgd/rechas/<?php echo $pgd_id; ?>" class="btn btn-sm btn-info">Add New</a>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="x_content"> 
				<?php if($this->session->flashdata('err_message')){?>
					<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
				<?php } // end if($this->session->flashdata('err_message')) ?>
				<?php if($this->session->flashdata('ok_message')){?>
						<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
				<?php }//if($this->session->flashdata('ok_message'))?>
				<br />
				<form  data-toggle="validator" role="form"  class="form-horizontal form-label-left" action="<?php echo base_url(); ?>pgd/add-update-rechas/<?php echo $pgd_id?>/<?php echo $rechas['id']?>" method="post" id="add_update_document_form" name="add_update_document_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label>
									Prerequisit Description*
								</label>
								<textarea name="rechas_description" id="rechas_description" class="form-control col-md-12 col-xs-12" rows="10" required="required" ><?php echo ($rechas != '') ? filter_string($rechas['rechas_description']) : '' ?></textarea>
                             
                             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"></div>   
							</div>
							
                            <div class="form-group">
								<label>Rechas Type</label>
								<select class="form-control" name="rechas_type" id="rechas_type" required="required" >
                                      <option value="new" <?php echo ($rechas['rechas_type'] == 'new') ? 'selected="selected"' : '' ?>>New</option>
                                      <option value="renew" <?php echo ($rechas['rechas_type'] == 'renew') ? 'selected="selected"' : '' ?>>Renew</option>
								</select>
							</div>
                            
                            <div class="form-group">
								<label>
									Status
								</label>
								<select class="form-control" name="status" id="status" required="required" >
                                      <option value="1" <?php echo ($rechas['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($rechas['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
								</select>
							</div>
							<br>
							<!-- Form (add_update_category_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_category_btn"><?php echo ($this->uri->segment(4) != '') ? 'Update' : 'Add new' ?></button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="category_id" value="<?php echo $category['id']; ?>" />
					<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
		<div class="x_title">
			<h2>PGD <small>Document Categories</small></h2>
			<div class="clearfix"></div>
		</div>
		<br />
         <?php if(!empty($rechas_all)){ $DataTableId ="examplePGDDocumentCategory";} else { $DataTableId = '';}?>
		<table id=" <?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
			<thead>
				<tr class="headings">
					<th>Description</th>
                    <th>Type</th>
					<th>Status</th>
					<th>Created Date</th>
					<th class=" no-link last"><span class="nobr">Action</span>
					</th>
				</tr>
			</thead>

			<tbody>
				<?php if(!empty($rechas_all)){ ?>
					<?php foreach($rechas_all as $each): ?>
						<tr class="even pointer">
							<td>
								<?php echo substr($each['rechas_description'], 0, 80); ?> 
								<br>
								<?php echo substr($each['rechas_description'], 80, 80); ?> 
							</td>
							<td><?php echo ucwords($each['rechas_type']); ?></td>
                            <td><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
							<td class="a-right a-right "><?php echo kod_date_format($each['created_date']); ?></td>
							<td class=" last">
								<a href="<?php echo base_url(); ?>pgd/rechas/<?php echo $pgd_id; ?>/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Edit Prerequisit" ><span class="glyphicon glyphicon-edit"></span> Edit</a>
								<a href="#" data-href="<?php echo base_url(); ?>pgd/delete-rechas/<?php echo $pgd_id; ?>/<?php echo $each['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" title="Delete Prerequisit" >X</a>
								<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												Warning !
											</div>
											<div class="modal-body">
												Are you sure you want to delete this prerequisit ?
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
												<a href="<?php echo base_url(); ?>pgd/delete-rechas/<?php echo $pgd_id; ?>/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php } else { ?>
                    <tr class="">
                        <td colspan="4">No rechas founded.</td>
                    </tr>
                <?php }?>
			</tbody>
		</table>

    </div>
    </div>
  </div>
  
</div>