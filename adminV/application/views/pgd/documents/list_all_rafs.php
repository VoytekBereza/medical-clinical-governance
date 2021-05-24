<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo ($this->uri->segment(4) != '') ? 'Update' : 'Add new' ?> <?php echo filter_string($pgd_details['pgd_name']);?> RAFs:</h2>
				<?php if($this->uri->segment(4) != ''){ ?>
					<div class="nav navbar-right panel_toolbox">
						<a href="<?php echo base_url(); ?>pgd/rafs_listing/<?php echo $pgd_id; ?>" class="btn btn-sm btn-info">Add New</a>
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
				<form  data-toggle="validator" role="form" class="form-horizontal form-label-left form_validate" action="<?php echo base_url(); ?>pgd/add-update-rafs/<?php echo $pgd_id?>/<?php echo $raf['id']?>" method="post" id="add_update_rafs_form" name="add_update_rafs_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label>
									RAFs Title*
								</label>
								<input type="text" class="form-control" name="raf_title" id="raf_title" required="required" value="<?php echo ($raf['raf_title'] != '') ? filter_string($raf['raf_title']) : '' ?>" />
                                
                             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<label>
									RAFs Document URL*
								</label>
								<input type="url" class="form-control" name="raf_document_url" id="raf_document_url" required="required" value="<?php echo ($raf['raf_document_url'] != '') ? $raf['raf_document_url'] : '' ?>" />
                               
                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label>
									Status
								</label>
								<select class="form-control" name="status" id="status" required="required" >
                                      <option value="1" <?php echo ($raf['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($raf['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
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
					<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      
		<div class="row">
			<div class="x_title">
				<h2>List PGD RAFs Documents</h2>
				 <div class="nav navbar-right panel_toolbox">
					<a href="<?php echo base_url(); ?>pgd/rafs_listing/<?php echo $pgd_id; ?>" class="btn btn-sm btn-success">Add New RAF</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<br />
             <?php if(!empty($rafs)){ $DataTableId ="examplePGDRaf";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings">
						<th>Title</th>
						<th>Url</th>
						<th>Status </th>
						<th class=" no-link last"><span class="nobr">Action</span>
						</th>
					</tr>
				</thead>

				<tbody>
					<?php if(!empty($rafs)){ ?>
						<?php foreach($rafs as $each): ?>
							<tr class="even pointer">
								<td class=" "><?php echo $each['raf_title']; ?></td>
								<td class=" ">
									<a href="<?php echo $each['raf_document_url']; ?>" target="_blank" ><?php echo $each['raf_document_url']; ?></a>
								</td>
								<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
								<td class=" last">
									<a href="<?php echo base_url(); ?>pgd/rafs-listing/<?php echo $pgd_id; ?>/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Edit" ><span class="glyphicon glyphicon-edit"></span>Edit</a>
									<a href="#" data-href="<?php echo base_url(); ?>pgd/delete-rafs/<?php echo $pgd_id; ?>/<?php echo $each['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" title="Delete" >Delete</a>
									<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													Warning !
												</div>
												<div class="modal-body">
													Are you sure you want to delete this RAF ?
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<a href="<?php echo base_url(); ?>pgd/delete-rafs/<?php echo $pgd_id; ?>/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php } else { ?>
						<tr class="">
							<td class=" " colspan="9">No documents founded.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<br />
		</div>
      </div>
    </div>
  </div>
  
</div>