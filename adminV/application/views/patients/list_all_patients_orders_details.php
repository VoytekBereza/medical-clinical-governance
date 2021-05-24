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
			<h2>Patient Orders Details Listing<small>Patient Orders Details Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
				</span>
                 <form id="list_patient_order_frm" name="list_patient_order_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="#">

              <?php if(!empty($list_orders_details)){ $DataTableId ="orderdetails";} else { $DataTableId = '';}?>
                   
               <table id="<?php echo $DataTableId; ?>" class="table table-bordered table-hover table-prices">
                                    <thead>
                                        <tr>
                                            <th> Medicine Name</th>
                                            <th> Quantity </th>
                                            <th> Strength </th>
                                            <th> Pharmacy Name </th>
                                            <th> Shipping Cost </th>
                                            <th> Delivery Method </th>
                                            <th> Order Type </th>
                                            <th> Sub Total</th>
                                            <th> Order Status </th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-compare-tbody">
                                    <?php if(!empty($list_orders_details)){
												
												foreach($list_orders_details as $each) {	
									?>
                                                <tr class="newRow">
                                                    <td> <?php echo filter_string($each['medicine_name']);?> </td>
                                                    <td> <?php echo filter_string($each['quantity']);?> </td>
                                                    <td> <?php echo filter_string($each['strength']);?></td>
                                                    <td> <?php echo filter_string($each['pharmacy_surgery_name']);?> </td>
                                                    <td> <?php if($each['order_type']=="PMR"){ echo "-";} else { echo filter_string($each['shipping_cost']);}?> </td>
                                                    <td>
                                                     <a href="#" data-toggle="tooltip" data-placement="right"  title="<?php if($each['order_type']=="ONLINE"){ echo filter_string($each['shipping_method']);}?>" style="color:#8C87BD; text-decoration:none;">
													<?php if($each['order_type']=="PMR"){ echo "-";} else { if($each['delivery_method']=="1"){ echo 'Online Delivery';?> <i class="fa fa-info-circle"></i> <?php } else if($each['delivery_method']=="2"){ echo 'Express Collection';} else if($each['delivery_method']=="3"){ echo 'Standard Collection';}?> <?php }?> </a> </td>
                                                    <td> <?php echo filter_string($each['order_type']);?> </td>
                                                    <td> <?php echo '&pound'.filter_string($each['subtotal']);?> </td>
                                                    <td> <?php if($each['order_status']=="P") { echo "Pending";} else if($each['order_status']=="C") { echo "Complete"; } else if($each['order_status']=="DS") { echo "Dispense";} else if($each['order_status']=="DC") { echo "Decline";}?> </td>
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
