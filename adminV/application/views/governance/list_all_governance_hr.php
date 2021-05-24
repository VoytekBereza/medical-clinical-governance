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
                <h2>Governance HR Listing <small>Governance HR Listing</small></h2> 
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
               <?php if(!empty($list_governance_hr)){ $DataTableId ="examplegovernancehr";} else { $DataTableId = '';}?>
                <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr class="headings"> 
                      <th>Pharmacy Surgery</th>
                      <th>User Name</th>
                      <th>Created  Date</th>
                      <th class=" no-link last"><span class="nobr">Action</span> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($list_governance_hr)){ ?>
                    <?php foreach($list_governance_hr as $each):  ?>
                    <tr class="even pointer"> 
                        <td class=" "><?php if($each['pharmacy_surgery']=="P") { echo "Pharmacy";} else { echo "Surgery";} ?></td>
                        <td class=" "><?php if($each['username'] !='') { echo filter_string($each['username']);} else if($each['username']=="" && $each['contract_for']=='M' && $each['user_type']==''){ echo "<b>Manager</b>";}  else if($each['username']=="" && $each['contract_for']=='SI' && $each['user_type']==''){ echo "<b>Superintendent</b>";}?></td>
                        <td class=" "><?php echo kod_date_format($each['modified_date']); ?></td>
                        <td class=" last">
                          <a href="<?php echo base_url(); ?>governance/edit-governance-hr/<?php echo $each['id']; ?>" title="Edit" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-edit"></span> </a> 
                        </td>
                    </tr
                    ><?php endforeach; ?>
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
