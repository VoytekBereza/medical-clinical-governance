<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo ($this->uri->segment(3) != '') ? 'Update' : 'Add new' ?> Travel vaccine:  <small><?php echo ($this->uri->segment(3) != '') ? 'Update' : 'Add new' ?> Travel vaccine</small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content"> 
				<?php if($this->session->flashdata('error_vaccine')){?>
					<div class="alert alert-danger"><?php echo $this->session->flashdata('error_vaccine'); ?></div>
				<?php } // end if($this->session->flashdata('err_message')) ?>
				<?php if($this->session->flashdata('ok_message_vaccine')){?>
						<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message_vaccine'); ?></div>
				<?php }//if($this->session->flashdata('ok_message'))?>
				<br />
				<form data-toggle="validator" role="form"  class="form-horizontal form-label-left" action="<?php echo base_url(); ?>vaccine/add-update-travel-vaccine" method="post" id="add_update_travel_vaccine_form" name="add_update_travel_vaccine_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label>
									Vaccine Name*
								</label>
								<input type="text" class="form-control" name="vaccine_name" id="vaccine_name"  required="required"  value="<?php echo ($vaccine['vaccine_name'] != '') ? filter_string($vaccine['vaccine_name']) : '' ?>" />
                                
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<br>
							<!-- Form (add_update_vaccine_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_travel_vaccine_btn"><?php echo ($this->uri->segment(3) != '') ? 'Update' : 'Add new' ?></button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="vaccine_id" value="<?php echo $vaccine['id']; ?>" />
					<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
				</form>
			</div>
		</div>
	</div>
</div>
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
                <h2>Vaccine <small>List Travel vaccine </small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
               <?php if(!empty($list_all_travel_vaccine)){ $DataTableId ="exampletavelvaccine";} else { $DataTableId = '';}?>
                <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr class="headings"> 
                      <th>Vaccine Name</th>
                      <th>Created  Date</th>
                      <th class=" no-link last"><span class="nobr">Action</span> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($list_all_travel_vaccine)){ ?>
                    <?php foreach($list_all_travel_vaccine as $each):  ?>
                   
                    <tr class="even pointer"> 
                        <td class=" "><?php echo filter_string($each['vaccine_name']); ?></td>
                        <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                        <td class=" last">
                        <a href="<?php echo base_url(); ?>vaccine/list-all-vaccine-brand/<?php echo $each['id']; ?>" class="btn btn-xs btn-success">Brand</a>
                      <a href="<?php echo base_url(); ?>vaccine/list-all-travel-vaccine/<?php echo $each['id']; ?>" title="Edit" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-edit"></span> </a> 
                      <?php if($each['id']!="1"){?>
                      <a  href="#" data-href="<?php echo base_url(); ?>vaccine/delete-travel-vaccine/<?php echo $each['id']; ?>" title="Delete" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" >X</a>
                      <?php }?>
                      </td>
                       
                      <div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Warning !
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this travel vaccine ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <a href="<?php echo base_url(); ?>vaccine/delete-travel-vaccine/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
                                    </div>
                                </div>
                            </div>
					</div>
                    </tr><?php endforeach; ?>
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
    </div>
  </div>
</div>
