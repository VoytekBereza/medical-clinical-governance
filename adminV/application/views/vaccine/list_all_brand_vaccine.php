<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo ($this->uri->segment(4) != '') ? 'Update '.filter_string($vaccine_name['vaccine_name']) : 'Add new '.filter_string($vaccine_name['vaccine_name']); ?>  Brand:  <small><?php echo ($this->uri->segment(4) != '') ? 'Update '.filter_string($vaccine_name['vaccine_name']) : 'Add new '.filter_string($vaccine_name['vaccine_name']) ?>  Brand</small></h2>
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
				<form data-toggle="validator" role="form"  class="form-horizontal form-label-left" action="<?php echo base_url(); ?>vaccine/add-update-vaccine-brand-process" method="post" id="add_update_travel_vaccine_form" name="add_update_travel_vaccine_form">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group has-feedback">
								<label>
									Brand Name*
								</label>
								<input type="text" class="form-control" name="brand_name" id="brand_name"  required="required"  value="<?php echo ($vaccine['brand_name'] != '') ? filter_string($vaccine['brand_name']) : '' ?>" />
                                
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<br>
							<!-- Form (add_update_vaccine_form) - submit button -->
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success" name="add_edit_travel_vaccine_brand_btn"><?php echo ($this->uri->segment(4) != '') ? 'Update' : 'Add new' ?></button>
							</div>
						</div>
					</div>
					<!-- Input Hidden Field -->
					<input type="hidden" name="brand_id" value="<?php echo $vaccine['id']; ?>" />
                    <input type="hidden" name="vaccine_cat_id" value="<?php echo $vaccine_name['id']; ?>" />
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
                <h2>Vaccine Brands <small>List vaccine Brands </small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
               <?php if(!empty($list_all_vaccine_brand)){ $DataTableId ="vaccinebrand";} else { $DataTableId = '';}?>
                <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr class="headings"> 
                      <th>Brand Name</th>
                      <th>Vaccine Name</th>
                      <th>Created  Date</th>
                      <th class=" no-link last"><span class="nobr">Action</span> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($list_all_vaccine_brand)){ ?>
                    <?php foreach($list_all_vaccine_brand as $each):  ?>
                   
                    <tr class="even pointer"> 
                        <td class=" "><?php echo filter_string($each['brand_name']); ?></td>
                         <td class=" "><?php echo filter_string($each['vaccine_name']); ?></td>
                        <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                        <td class=" last">
                      	<a href="<?php echo base_url(); ?>vaccine/list-all-vaccine-brand/<?php echo $each['vaccine_id'];?>/<?php echo $each['id']; ?>" title="Edit" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-edit"></span> </a> 
                      </td>
                      
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
