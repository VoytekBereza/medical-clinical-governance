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
                <h2>Quick Forms Category Listing <small>Quick Forms Category Listing </small></h2>
                <div class="nav navbar-right panel_toolbox">
						<a href="<?php echo SURL?>quickforms/add-update-quick-forms-category" class="btn btn-sm btn-success">Add New Quick Forms Category</a>
					</div> 
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
              <?php if(!empty($list_quick_forms_category)){ $DataTableId ="exampleQuickFormCate";} else { $DataTableId = '';}?>
                <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr class="headings"> 
                      <th>Category Name</th>
                      <th>Created  Date</th>
                      <th class=" no-link last"><span class="nobr">Action</span> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($list_quick_forms_category)){ ?>
                    <?php foreach($list_quick_forms_category as $each):  ?>
                    <tr class="even pointer"> 
                       
                        <td class=" "><?php echo filter_string($each['category_name']); ?></td>
                        <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                        <td class=" last">
                      <a href="<?php echo base_url(); ?>quickforms/add-update-quick-forms-category/<?php echo $each['id']; ?>" title="Edit" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-edit"></span> </a> 
                      <a  href="#" data-href="<?php echo base_url(); ?>quickforms/delete-quick-forms-category/<?php echo $each['id']; ?>" title="Delete" data-toggle="modal" data-target="#confirm-delete-<?php echo $each['id']; ?>" class="btn btn-xs btn-danger" >X</a></td>
                      <div class="modal fade" id="confirm-delete-<?php echo $each['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Warning !
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this Quick Forms Category ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <a href="<?php echo base_url(); ?>quickforms/delete-quick-forms-category/<?php echo $each['id']; ?>" class="btn btn-danger btn-ok">Delete</a>
                                    </div>
                                </div>
                            </div>
					</div>
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
    </div>
  </div>
</div>
