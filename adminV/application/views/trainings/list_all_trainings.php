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
			<div class="x_title">
				<h2>Edit Training <small>List Training</small></h2>
				<div class="nav navbar-right panel_toolbox">
					<a href="<?php echo base_url(); ?>trainings/add-new-training" class="btn btn-sm btn-success">Add New</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<br>
            
              <?php if(!empty($trainings)){ $DataTableId ="exampleTraining";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings">
						<th>
							User Type
							<br />							
							<select id="user_type_dropdown" onChange="filter_users_listing();" class="form-control" name="user_type_dropdown" >
								<option value="all">View All</option>
								<?php if(!empty($user_types)){ ?>
									<?php foreach($user_types as $type): ?>
										<option <?php echo ($this->uri->segment(3) == $type['id']) ? 'selected="selected"' : '' ?> value="<?php echo $type['id']; ?>"><?php echo ucfirst($type['user_type']); ?></option>
									<?php endforeach; ?>
								<?php } // End- if(!empty($user_types)){ ?>	
								
							</select>
						</th>
						<th>Course Name</th>
						<!-- <th>Star Rating </th> -->
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
								
								<td class=" "><?php echo filter_string($each['user_name']); ?></td>
								<td class=" "><?php echo substr(strip_tags(filter_string($each['course_name'])),0,50); ?></td>
								<!--
								<td class=" ">
									<?php for($i=0;$i<$each['star_rating'];$i++){ ?><i class="success fa fa-star"></i><?php } ?>
								</td>
								-->
								<td class=" ">&pound;<?php echo $each['price']; ?></td>
								<td class="a-right a-right ">&pound;<?php echo $each['discount_price']; ?></td>
								<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
								<td class=" last">
									<a href="<?php echo base_url(); ?>trainings/documents-listing/<?php echo $each['id']; ?>" class="btn btn-xs btn-warning" title="Training Documents" ><span class="glyphicon glyphicon-file"></span></a>
									<a href="<?php echo base_url(); ?>trainings/videos-listing/<?php echo $each['id']; ?>" class="btn btn-xs btn-info" title="Training Videos" ><span class="glyphicon glyphicon-facetime-video"></span></a>
									<a href="<?php echo base_url(); ?>trainings/quizes/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Training Exam" ><span class="glyphicon glyphicon-education" aria-hidden="true"></span></a>
									<a href="<?php echo base_url(); ?>trainings/add-new-training/<?php echo $each['id']; ?>?c=1" class="btn btn-xs btn-primary" title="Training Certificate" ><span class="glyphicon glyphicon-certificate" aria-hidden="true"></span></a>
									<a href="<?php echo base_url(); ?>trainings/add-new-training/<?php echo $each['id']; ?>" class="btn btn-xs btn-default" title="Edit Training" ><span class="glyphicon glyphicon-edit"></span></a>
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
  </div>
</div>