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
			<h2>Destination Listing<small>Destination Listing</small></h2> 
             <div class="nav navbar-right panel_toolbox">
			 <a href="<?php echo SURL?>vaccine/add-update-vaccine-destination" class="btn btn-sm btn-success">Add Destination</a>
		   </div> 
			<div class="clearfix"></div>
			</div>
          
                 <form id="list_destination_frm" name="list_destination_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="#">
                    
             <?php if(!empty($list_all_destination_vaccine)){ $DataTableId ="vaccinedestinations";} else { $DataTableId = '';}?>
             <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="headings"> 
						<th>Destination Name</th>
						<th>Modified Date</th>
                        <th>Action</th>
					</tr>
				</thead>
                
				<tbody>
 
				<?php if(!empty($list_all_destination_vaccine)){?>
					  
                      <?php foreach($list_all_destination_vaccine as $each): ?>
						 
                        <tr class="even pointer"> 
                            <td class=" "><?php echo filter_string($each['destination']); ?> </td>
                            <td class=" "><?php echo kod_date_format($each['modified_date']); ?> </td>
                            <td class=" ">
                            
                            <a class="btn btn-info btn-xs pull-left" type="button"  href="<?php echo base_url();?>vaccine/add-update-vaccine-destination/<?php echo $each['id'];?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <a  href="#" data-href="<?php echo base_url(); ?>vaccine/delete-destination-vaccine/<?php echo $each['id']; ?>" title="Delete" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" >X</a></td>
                          <div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            Warning !
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this destination?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <a href="<?php echo base_url(); ?>vaccine/delete-destination-vaccine/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </tr>
					<?php 
				 	endforeach; ?>
                    
				<?php }  else { ?>
								<tr class="">
									<td class=" " colspan="9">No record founded.</td>
								</tr>
					<?php } ?>
			  </tbody>
			</table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

