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
			<h2><?php echo filter_string($get_organizaiotion_company_name_pharmacy_name_for_staff['pharmacy_surgery_name']);?> <small><?php echo filter_string($get_organizaiotion_company_name_pharmacy_name_for_staff['pharmacy_surgery_name']);?> Staff Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
            <?php if(!empty($pharmacy_staff_list)){ $DataTableId ="examplePharmacyStaff";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
                     <th>Organization Name </th>
					 <th>Name</th>
                     <th>User Name</th>
                     <th>Type</th>
                     <th>User Type</th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($pharmacy_staff_list)){?>
					<?php foreach($pharmacy_staff_list as $each):  ?>
						<tr class="even pointer"> 
                        	<td class=" "><?php echo filter_string($each['company_name']); ?></td>
							<td class=" "><?php echo filter_string($each['pharmacy_surgery_name']); ?></td>
                            <td class=" "><?php echo filter_string($each['first_name'])." ".filter_string($each['last_name']); ?></td>
                            <td class=" "><?php if($each['type']=="P"){ echo "Pharmacy";} else { echo "Surgery";}?></td>
                            <td class=" "><?php echo filter_string($each['TypeName']); ?></td>
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
        </div>
      </div>
    </div>
  </div>
</div>
