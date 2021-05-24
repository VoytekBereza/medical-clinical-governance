<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
			<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php } // end if($this->session->flashdata('err_message')) ?>
        <?php if($this->session->flashdata('ok_message')){?>
        		<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
       <div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>PGD <small>List All PGD's</small></h2>
						<div class="nav navbar-right panel_toolbox">
							<a href="<?php echo base_url(); ?>pgd/add-new-pgd" class="btn btn-sm btn-success">Add New</a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
                     <?php if(!empty($trainings)){ $DataTableId ="exampleAllPgds";} else { $DataTableId = '';}?>
						<table id=" <?php echo $DataTableId; ?>" class="table table-striped responsive-utilities jambo_table">
							<thead>
								<tr class="headings">
									<th>
										<input type="checkbox" class="tableflat">
									</th>
									<th>PGD Name</th>
									<th>Is-Prerequisit</th>
									<th>Star Rating </th>
									<th>Price</th>
									<th>Discount Price </th>
									<th>Status </th>
									<th class=" no-link last"><span class="nobr">Action</span>
									</th>
								</tr>
							</thead>

							<tbody>
								<?php if(!empty($trainings)){ ?>
									<?php foreach($trainings as $each): ?>
										<tr class="even pointer">
											<td class="a-center ">
												<input type="checkbox" class="tableflat">
											</td>
											<td class=" "><?php echo filter_string($each['pgd_name']); ?></td>
											<td class=" "><?php echo ($each['is_rechas'] == 1) ? 'Yes' : 'No' ?></td>
											<td class=" ">
												<?php for($i=0;$i<$each['star_rating'];$i++){ ?><i class="success fa fa-star"></i><?php } ?>
											</td>
											<td class=" ">$<?php echo $each['price']; ?></td>
											<td class="a-right a-right ">$<?php echo $each['discount_price']; ?></td>
											<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
											<td class=" last">
												<a href="<?php echo base_url(); ?>pgd/documents-listing/<?php echo $each['id']; ?>" class="btn btn-xs btn-warning" title="Training Documents" ><span class="glyphicon glyphicon-file"></span></a>
												<a href="<?php echo base_url(); ?>pgd/videos-listing/<?php echo $each['id']; ?>" class="btn btn-xs btn-info" title="Training Videos" ><span class="glyphicon glyphicon-facetime-video"></span></a>
												<a href="<?php echo base_url(); ?>pgd/add-new-pgd/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Edit Training" ><span class="glyphicon glyphicon-edit"></span></a>
												<a href="#" data-href="<?php echo base_url(); ?>trainings/delete-training/<?php echo $each['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" title="Delete Training" >X</a>
												<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																Warning !
															</div>
															<div class="modal-body">
																Are you sure you want to delete this training ?
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																<a href="<?php echo base_url(); ?>trainings/delete-training/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
															</div>
														</div>
													</div>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<br />
			<br />
			<br />

		</div>
      </div>
    </div>
  </div>
  
</div>