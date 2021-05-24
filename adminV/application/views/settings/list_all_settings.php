<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo ($this->uri->segment(3) != '') ? 'Update' : 'Add new' ?> Settings:  <small><?php echo ($this->uri->segment(3) != '') ? 'Update' : 'Add new' ?> Settings</small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content"> 
				<?php if($this->session->flashdata('error_settings')){?>
					<div class="alert alert-danger"><?php echo $this->session->flashdata('error_settings'); ?></div>
				<?php } // end if($this->session->flashdata('err_message')) ?>
				<?php if($this->session->flashdata('ok_message_settings')){?>
						<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message_settings'); ?></div>
				<?php }//if($this->session->flashdata('ok_message'))?>
				<br />
				<form  data-toggle="validator" role="form"  class="form-horizontal form-label-left" action="<?php echo base_url(); ?>settings/add-update-settings" method="post" id="add_update_settings_form" name="add_update_settings_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label>
									Setting name*
								</label>
								<input type="text" class="form-control" name="setting_name" id="setting_name"  required="required" <?php if ($settings['setting_name'] != '') {?> disabled="disabled"<?php }?>  value="<?php echo ($settings['setting_name'] != '') ? filter_string($settings['setting_name']) : '' ?>" />
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"></div>
                            </div>
                           <div class="error help-block" id="error_msg"></div>
                            <div class="form-group has-feedback">
								<label>
									Setting Value*
								</label>
								<textarea class="form-control" rows="3" required="required" placeholder="Description" name="setting_value" id="setting_value"><?php echo filter_string($settings['setting_value'])?></textarea>
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							 <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group has-feedback">
                                  <label for="middle-name">Settings Description* </label>
                                   <textarea class="form-control" rows="3" required="required" placeholder="Short Description" name="setting_description" id="setting_description"><?php echo filter_string($settings['setting_description'])?></textarea>
                                 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							    <div class="help-block with-errors"></div>
                               </div>
							<br>
							<!-- Form (add_update_settings_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_settinngs_btn"><?php echo ($this->uri->segment(3) != '') ? 'Update' : 'Add new' ?></button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="settings_id" value="<?php echo $settings['id']; ?>" />
					<input type="hidden" name="action" value="<?php echo $form_action; ?>" />
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo  base_url(); ?>" />
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
                <h2>Settings <small>List Settings </small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
               <?php if(!empty($list_settings)){ $DataTableId ="exampleSetting";} else { $DataTableId = '';}?>
                <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr class="headings"> 
                      <th>Setting Name</th>
                      <th>Setting Value</th>
                      <th>Created  Date</th>
                      <th class=" no-link last"><span class="nobr">Action</span> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($list_settings)){ ?>
                    <?php foreach($list_settings as $each): 
					
					$setting_value = substr($each['setting_value'],0,80);
					 ?>
                   
                    <tr class="even pointer"> 
                        <td class=" "><?php echo filter_string($each['setting_name']); ?></td>
                        <td class=" " title="<?php echo filter_string($setting_value); ?>"><?php echo strip_tags(filter_string($setting_value)); ?></td>
                        <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                        <td class=" last">
                      <a href="<?php echo base_url(); ?>settings/list-all-settings/<?php echo $each['id']; ?>" title="Edit" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-edit"></span> </a> 
                      <!--<a  href="#" data-href="<?php echo base_url(); ?>settings/delete-settings/<?php echo $each['id']; ?>" title="Delete" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" >X</a>--></td>
                      <!--<div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Warning !
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this Setting ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <a href="<?php echo base_url(); ?>settings/delete-settings/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
                                    </div>
                                </div>
                            </div>
					</div>-->
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
