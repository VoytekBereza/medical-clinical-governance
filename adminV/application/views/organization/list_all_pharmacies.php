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
			<h2>Pharmacy <small>List Pharmacy</small></h2> 
			<div class="clearfix"></div>
			</div>
             <form id="pharmacies_frm" name="pharmacies_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>organization/embed-code-pharmacies-process">
             
              <?php if(!empty($pharmacy_list)){?>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                        <span class="input-group input-group-sm input-group-addon">
                            <span class="pull-left">
                                <input type="checkbox" id="checkAll" > Check All
                            </span>
                         </span>
                       </div>
                      <div style="padding-left:12%; height:10%;">
                        <div class="col-md-2 col-sm-2 col-xs-2">
                          <div class="form-group pull-right">
								<select class="input-group" name="embed_status" id="embed_status"  style="height:10%">
                                <option value="">Action</option>
                                <option value="1">Enabled Embed Code</option>
                                <option value="0">Disabled Embed Code</option>
                            </select>
						  </div>
                       </div>
                       </div>
                       <br />
                       <br />
                       <br />
                       <?php }?>
                   
            <?php if(!empty($pharmacy_list)){ $DataTableId ="Pharmacies";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
                        <th>Check</th>
                        <th>Embed Code </th>
						<th>Name</th>
                        <th>Manager Name </th>
                        <th>GPhc No</th>
						<th>Post Code</th>
                        <th>Contact Number</th>
						<th>Created Date</th>
                        <th>Pharmacy Type </th>
					<!--	<th>Status </th>-->
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($pharmacy_list)){?>
					<?php foreach($pharmacy_list as $each): ?>
						<tr class="even pointer">
                             <td class=""><div class="btn-group">
                            <input type="checkbox" name="embad_pharmacies[]" value="<?php echo $each['id'];?>"  />
                            </div></td> 
                            <td class=" "><?php if($each['embed_status']=='1'){ echo 'Enabled';} else { echo 'Disabled';} ?></td>
							<td class=" "><?php echo filter_string($each['pharmacy_surgery_name']); ?></td>
                            <td class=" "><?php if($each['first_name']==""){ echo "No Manager";} else { echo filter_string($each['first_name'])." ".filter_string($each['last_name']);} ?></td>
							<td class=" "><?php if($each['gphc_no']!="") { echo filter_string($each['gphc_no']);} else  { echo '--';} ?></td>
                            <td class=" "><?php echo filter_string($each['postcode']); ?></td>
                            <td class=" "><?php echo filter_string($each['contact_no']); ?></td>
							<td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                             <td class=""><span class="btn btn-xs btn-info" style="cursor:default;"><?php if($each['type']=='P'){ echo "Pharmacy";} else { echo "Surgery";}?></span></td>			
							<!--<td class=" "><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>-->
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
