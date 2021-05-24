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
			<h2><?php echo filter_string($get_organizaiotion_details['company_name']);?> <small> <?php echo filter_string($get_organizaiotion_details['company_name']);?> List Pharmacy</small></h2> 
			<div class="clearfix"></div>
			</div>
            <?php if(!empty($pharmacy_list)){ $DataTableId ="exampleOrganizationPharmacy";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
						<th>Name</th>
                        <th>Manager Name </th>
                        <th>GPhc No</th>
						<th>Post Code</th>
                        <th>Contact Number</th>
						<th>Created Date</th>
						<th>Status </th>
                        <th>Staff</th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($pharmacy_list)){?>
					<?php foreach($pharmacy_list as $each): ?>
						<tr class="even pointer"> 
							<td class=" "><?php echo filter_string($each['pharmacy_surgery_name']); ?></td>
                            <td class=" "><?php if($each['first_name']==""){ echo "No Manager";} else { echo filter_string($each['first_name'])." ".filter_string($each['last_name']);} ?></td>
							<td class=" "><?php if($each['gphc_no']!="") { echo filter_string($each['gphc_no']);} else  { echo '--';} ?></td>
                            <td class=" "><?php echo filter_string($each['postcode']); ?></td>
                            <td class=" "><?php echo filter_string($each['contact_no']); ?></td>
							<td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
							<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
                            <td class=" ">
                            <div class="nav navbar-right panel_toolbox">
							<a href="<?php echo SURL?>organization/list-all-pharmacy-staff/<?php echo $this->uri->segment(3);?>/<?php echo $each['id'];?>" class="btn btn-xs btn-info">Staff</a>
						    </div> </td>
							
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
