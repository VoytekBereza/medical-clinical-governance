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
			<h2><?php echo filter_string($medicine_details['medicine_name']);?> info Listing<small><?php echo filter_string($medicine_details['medicine_name']);?> info Listing</small></h2> 
            <div class="nav navbar-right panel_toolbox">
			 <a href="<?php echo SURL?>medicine/add-update-medicine-info/<?php echo $this->uri->segment(3);?>" class="btn btn-sm btn-success">Add Medicine info</a>
		   </div> 
			<div class="clearfix"></div>
			</div>
          
                 <form id="list_medicine_frm" name="list_medicine_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>medicine/update-medicine-info-order-process">
                    
             <?php if(!empty($list_all_medicine_info)){ $DataTableId ="examplemedicineinfo";} else { $DataTableId = '';}?>
             <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="headings"> 
						<th>Title</th>
                        <th>Medicine Name</th>
                        <th>Display Order</th>
						<th>Created date</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>
 
				<?php if(!empty($list_all_medicine_info)){?>
					  
                      <?php foreach($list_all_medicine_info as $each): ?>
						 
                        <tr class="even pointer"> 
                            <td class=" "><?php echo filter_string($each['tabs_title']); ?></td>
                            <td class=" "><?php echo filter_string($each['brand_name'])." - ".filter_string($each['medicine_name']); ?></td>
                            <td class=" ">
                            <input type="text" id="order_list" name="order_list[]" value="<?php echo $each['display_order']; ?>" size="5"/>
                            <input type="hidden" id="id_list" name="id_list[]" value="<?php echo $each['id']; ?>" size="5"/>
                            </td>
                            <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                            <td class=" ">
                            <a class="btn btn-info btn-xs pull-left" type="button"  href="<?php echo base_url();?>medicine/add-update-medicine-info/<?php echo $this->uri->segment(3);?>/<?php echo $each['id'];?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <a class="btn btn-danger btn-xs" data-target="#confirm-delete-<?php echo $each['id'];?>" data-toggle="modal" title="Delete" data-href="<?php echo base_url();?>medicine/delete-medicine-info/<?php echo $this->uri->segment(3);?>/<?php echo $each['id'];?>" href="#">X</a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirm-delete-<?php echo $each['id'];?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                Warning !
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this info ?
                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                <a class="btn btn-danger btn-ok" href="<?php echo base_url();?>medicine/delete-medicine-info/<?php echo $this->uri->segment(3);?>/<?php echo $each['id'];?>">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
						   </td>
                        </tr>
					<?php endforeach; ?>
                    <tr class="even pointer"> 
                            <td class=" " colspan="5">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            </div>
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <input type="submit" class="btn btn-success" id="info_order_btn" name="info_order_btn" value="Update Order" size="5"/>
                            <input type="hidden" name="medicine_id" id="medicine_id" value="<?php echo $this->uri->segment(3);?>" />
                            </div>
                            </td>
                    </tr>
                                   
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
