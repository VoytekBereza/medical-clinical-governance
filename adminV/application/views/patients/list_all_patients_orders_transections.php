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
			<h2>Patient Orders Medicine Transaction Listing<small>Patient Orders Medicine Transaction Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
				</span>
                 <form id="list_patient_order_frm" name="list_patient_order_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="#">

              <?php if(!empty($transaction_list)){ $DataTableId ="orderdetails";} else { $DataTableId = '';}?>
                   
               <table id="<?php echo $DataTableId; ?>" class="table table-bordered table-hover table-prices">
                                    <thead>
                                        <tr>
                                          <!-- <th>Pmr No </th>-->
                                           <th> Order date</th>
                                           <th> Pharmacy Name </th>
                                           <th>Patient Name &amp; Address </th>
                                           <th> Medicine</th>
                                            <!-- <th> Quantity </th>
                                            <th> Strength </th>-->
                                           <!-- <th> Delivery Method </th>
                                            <th> Grand Total </th>
                                           <!-- <th> Order Type </th>-->
                                           <!-- <th> Order Status </th>-->
                                             <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-compare-tbody">
                                    <?php if(!empty($transaction_list)){
												
												foreach($transaction_list as $each) {	
												
												
									?>
                                                <tr class="newRow">
                                                    <td> <?php echo kod_date_format(filter_string($each['created_date']), true); ?> </td>
                                                    <td> <?php echo filter_string($each['p_pharmacy_name']);?> </td>
                                                    <td> 
														<?php echo ucwords(filter_string($each['p_patient_name']));?> <br />
                                                        <?php echo filter_string($each['p_patient_address']);?>
                                                        <td> 
															<?php echo filter_string($each['p_medicine_short_name']);?> 
                                                            <?php echo filter_string($each['p_strength_name']);?> 
                                                            <?php echo filter_string($each['quantity']);?> 
                                                            <?php echo filter_string($each['p_medicine_form']);?>
                                                        </td>
                                                        
                                                    </td>
                                                	<!--<td> <?php echo filter_string($each['pmr_no']);?> </td>
                                                    
                                                   <!-- <td> <?php echo filter_string($each['quantity']);?> </td>
                                                    <td> <?php echo filter_string($each['strength']);?></td>-->
                                                   
                                                    <!--<td>
                                                     <a href="#" data-toggle="tooltip" data-placement="right"  title="<?php if($each['order_type']=="ONLINE"){ echo filter_string($each['shipping_method']);}?>" style="color:#8C87BD; text-decoration:none;">
													<?php if($each['order_type']=="PMR"){ echo "-";} else { if($each['delivery_method']=="1"){ echo 'Online Delivery';?> <i class="fa fa-info-circle"></i> <?php } else if($each['delivery_method']=="2"){ echo 'Express Collection';} else if($each['delivery_method']=="3"){ echo 'Standard Collection';}?> <?php }?> </a> </td>
                                                    <td> <?php echo  '&pound'.filter_string($each['grand_total']);?> </td>
                                                     <td> <?php echo filter_string($each['order_type']);?> </td>
                                                  
                                                    <td> <?php if($each['order_status']=="P") { echo "Pending";} else if($each['order_status']=="C") { echo "Complete"; } else if($each['order_status']=="DS") { echo "Dispense";} else if($each['order_status']=="DC") { echo "Decline";}?> </td>-->
                                                    <td>
                                                    <a href="<?php echo SURL;?>patient/patient-dashboard/<?php echo filter_string($each['patient_id']).'/'.filter_string($each['id']).'/'.filter_string($each['organization_id']).'/'.filter_string($each['pharmacy_surgery_id']); ?>" 
                                                     type="button" class="btn btn-info btn-xs pull-left">View Details
                                                    </a>
                                                     </td>
                                                </tr>
                                     <?php 
									 			} // end foreach loop
									 		} else { ?>
                                            
                                            	<tr class="newRow">
                                                    <td colspan="9"> No records found. </td>
                                                </tr>
												
									 <?php } // else condition ?>
                                        
                                    </tbody>
                                </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
