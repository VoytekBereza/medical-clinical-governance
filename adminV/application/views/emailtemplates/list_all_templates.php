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
			<h2> Templates <small>List Templates</small></h2>
			<div class="nav navbar-right panel_toolbox">
				<a href="<?php echo SURL?>emailtemplates/add-new-template" class="btn btn-sm btn-success">Add New Template</a>
			</div> 
			<div class="clearfix"></div>
			</div>
             <?php if(!empty($list_templates)){ $DataTableId ="exampleEmail";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
						<th>Email  Title</th>
						<th>Subject</th>
						<th>Created Date</th>
						<th>Status </th>
						<th class=" no-link last"><span class="nobr">Action</span> </th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($list_templates)){ ?>
					<?php foreach($list_templates as $each): 
					
					      $subject = filter_string($each['email_subject']);
					 ?>
						<tr class="even pointer"> 
							<td class=" "><?php echo filter_string($each['email_title']); ?></td>
							<td class=" "><?php echo substr($subject,0,40); ?></td>
							<td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
							<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
							<td class=" last">
							<a href="<?php echo base_url(); ?>emailtemplates/add-new-template/<?php echo $each['id']; ?>" title="Edit" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-edit"></span> </a> 
							<!--<a  href="#" data-href="< ?php echo base_url(); ?>page/delete-page/< ?php echo $each['id']; ?>" title="Delete" data-toggle="modal" data-target="#confirm-delete-< ?php echo $each['id']; ?>" class="btn btn-xs btn-danger" >X</a>--></td>
						</tr>
					<?php endforeach; ?>
				<?php } else { ?>
								<tr class="">
									<td class=" " colspan="9">No record founded.</td>
								</tr>
				<?php } ?>
			  </tbody>
			</table>
        </div>
      </div>
    </div>
  </div>
</div>
