<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php } // end if($this->session->flashdata('err_message')) ?>
        <?php if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
						 <h2>NHS Comissioning Document Listing <small>NHS Comissioning Document Listing </small></h2>
						 <div class="nav navbar-right panel_toolbox">
							<a href="<?php echo base_url(); ?>nhs-comissioning/add-update-nhs-comissioning-documents" class="btn btn-sm btn-success">Add New NHS Comissioning Document</a>
						</div>
						<div class="clearfix"></div>
					</div>
					<br>
                    <?php if(!empty($list_nhs_comissioning_documents)){ $DataTableId ="exampleQuickFormDocumtent";} else { $DataTableId = '';}?>
					<table id="<?php echo $DataTableId;?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
						<thead>
							<tr class="headings">
								<th>Category</th>
								<th>Title</th>
								<th>Url</th>
								<th>Created Date</th>
								<th>Status </th>
								<th class=" no-link last"><span class="nobr">Action</span>
								</th>
							</tr>
						</thead>

						<tbody>
							<?php if(!empty($list_nhs_comissioning_documents)){ ?>
								<?php foreach($list_nhs_comissioning_documents as $each): ?>
									<tr class="even pointer">
										<td class=" "><?php echo filter_string($each['category_name']); ?></td>
										<td class=" "><?php echo filter_string($each['document_title']); ?></td>
										<td class=" ">
											
											<a href="<?php echo  $each['document_url']; ?>" id="clipboard_<?php echo $each['id']; ?>" title="<?php echo $each['document_url']; ?>" target="_blank" >
												<i class="fa fa-external-link"></i>
											</a>
											&nbsp;
											<a href="#" class="copy-url-to-clipboard" data-clipboard-text="<?php echo  $each['document_url']; ?>" >
												Copylink
											</a>
											
											<script>
											// Copy to clip-board
											var clipboard = new Clipboard('.copy-url-to-clipboard');
											/*
											clipboard.on('success', function(e) {
												//console.log(e.text);
											});
											clipboard.on('error', function(e) {
												//console.log(e.text);
											});
											*/
											</script>
											
										</td>
										<td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
										<td class=" "><?php echo ($each['status'] == '1') ? 'Active' : 'InActive' ?></td>
										<td class="last">
											<a href="<?php echo base_url(); ?>nhs-comissioning/add-update-nhs-comissioning-documents/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Edit" ><span class="glyphicon glyphicon-edit"></span>Edit</a>
											<a href="#" data-href="<?php echo base_url(); ?>nhs-comissioning/delete-nhs-comissioning-document/<?php echo $each['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" title="Delete" >Delete</a>
											<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															Warning !
														</div>
														<div class="modal-body">
															Are you sure you want to delete this document ?
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
															<a href="<?php echo base_url(); ?>nhs-comissioning/delete-nhs-comissioning-document/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php } else { ?>
								<tr class="">
									<td class=" " colspan="9">No record founded.</td>
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
  
</div>