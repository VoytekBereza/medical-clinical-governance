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
		</div>
		<div class="row">
			<div class="x_title">
				<h2><?php echo filter_string($trainings_name) ;?> List Training videos / presentations</h2>
				 <div class="nav navbar-right panel_toolbox">
					<a href="<?php echo base_url(); ?>trainings/add-edit-video/<?php echo $course_id; ?>" class="btn btn-sm btn-success">Add New</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<br>
             <?php if(!empty($videos_intro)){?>
             
             <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings">
						<th>Title</th>
						<th>Video Url</th>
						<th>Video ID</th>
						<th>Last Modified</th>
						<th>Status </th>
						<th>Default Video</th>
						<th class=" no-link last"><span class="nobr">Action</span>
						</th>
					</tr>
				</thead>

				<tbody>
					<?php if(!empty($videos_intro)){ ?>
						<?php foreach($videos_intro as $each): ?>
							<tr class="even pointer">
								<td class=" "><?php echo filter_string($each['video_title']); ?></td>
								<td class=" ">
									<a href="<?php echo $each['video_url']; ?>" title="<?php echo $each['video_url']; ?>" target="_blank" ><i class="fa fa-external-link"></i></a>
								</td>
								<td class="a-right a-right "><?php echo $each['video_id']; ?></td>
								<td class=" "><?php echo $each['modified_date']; ?></td>
								<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
								<td class=" "><?php echo ($each['default_video'] == 0) ? '<a href="'.base_url().'trainings/set-video-as-default/'.$course_id.'/'.$each['id'].'" class="btn btn-xs btn-info" title="Set this video Mark as intro" >Mark As Intro</a>' : '<a href="#" class="btn btn-xs btn-warning" title="This video is already intro" >Intro</a>' ?></td>
								<td class=" last">
									<a href="<?php echo base_url(); ?>trainings/add-edit-video/<?php echo $course_id; ?>/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Edit video" ><span class="glyphicon glyphicon-edit"></span> Edit</a>
									<a href="#" data-href="<?php echo base_url(); ?>trainings/delete-video/<?php echo $each['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" title="Delete video" > Delete</a>
									<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													Warning !
												</div>
												<div class="modal-body">
													Please select intro video first then delete this video.
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<a href="<?php echo base_url(); ?>trainings/delete-video/<?php echo $course_id; ?>/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php } else { ?>
						<tr class="">
							<td class=" " colspan="9">No videos founded.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
            
             <br  />
             <br  />
          <?php }?>
           
            
             <?php if(!empty($videos)){ $DataTableId ="exampleTrainingVideo";} else { $DataTableId = '';}?>
        
		 	 <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings">
						<th>Title</th>
						<th>Video Url</th>
						<th>Video ID</th>
						<th>Last Modified</th>
						<th>Status </th>
						<th>Default Video</th>
						<th class=" no-link last"><span class="nobr">Action</span>
						</th>
					</tr>
				</thead>

				<tbody>
					<?php if(!empty($videos)){ ?>
						<?php foreach($videos as $each): ?>
							<tr class="even pointer">
								<td class=" "><?php echo filter_string($each['video_title']); ?></td>
								<td class=" ">
									<a href="<?php echo $each['video_url']; ?>" title="<?php echo $each['video_url']; ?>" target="_blank" ><i class="fa fa-external-link"></i></a>
								</td>
								<td class="a-right a-right "><?php echo $each['video_id']; ?></td>
								<td class=" "><?php echo $each['modified_date']; ?></td>
								<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
								<td class=" "><?php echo ($each['default_video'] == 0) ? '<a href="'.base_url().'trainings/set-video-as-default/'.$course_id.'/'.$each['id'].'" class="btn btn-xs btn-info" title="Set this video Mark as intro" >Mark As Intro</a>' : '<a href="#" class="btn btn-xs btn-warning" title="This video is already intro" >Intro</a>' ?></td>
								<td class=" last">
									<a href="<?php echo base_url(); ?>trainings/add-edit-video/<?php echo $course_id; ?>/<?php echo $each['id']; ?>" class="btn btn-xs btn-success" title="Edit video" ><span class="glyphicon glyphicon-edit"></span> Edit</a>
									<a href="#" data-href="<?php echo base_url(); ?>trainings/delete-video/<?php echo $each['id']; ?>" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" title="Delete video" > Delete</a>
									<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													Warning !
												</div>
												<div class="modal-body">
													Are you sure you want to delete this video ?
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<a href="<?php echo base_url(); ?>trainings/delete-video/<?php echo $course_id; ?>/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php } else { ?>
						<tr class="">
							<td class=" " colspan="9">No videos founded.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
      </div>
    </div>
  </div>
  
</div>