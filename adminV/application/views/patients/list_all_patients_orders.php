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
			<h2>Patient Orders Listing<small>Patient Orders Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
			
                 <form id="list_patient_order_frm" name="list_patient_order_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="#">

              <?php if(!empty($list_patients_orders)){ $DataTableId ="orderhistory";} else { $DataTableId = '';}?>
                   
               <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> Patient Name  </th>
                                            <th> Prescription Number</th>
                                            <th> Transaction ID </th>
                                            <th> Order Date </th>
                                            <th> Sub Total </th>
                                            <th> Shipping Cost </th>
                                            <th> Grand Total</th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-compare-tbody">
                                    <?php if(!empty($list_patients_orders)){
												
												foreach($list_patients_orders as $each) {	
									?>
                                                <tr class="newRow">
                                                    <td> <?php echo filter_string($each['first_name'])." ".filter_string($each['last_name']);;?> </td>
                                                    <td> <?php echo filter_string($each['prescription_no']);?> </td>
                                                    <td> <?php echo filter_string($each['transaction_id']);?> </td>
                                                    <td> <?php echo kod_date_format($each['purchase_date']);?> </td>
                                                    <td> <?php echo '&pound'.filter_string($each['subtotal']);?> </td>
                                                    <td> <?php echo '&pound'.filter_string($each['shipping_cost']);?> </td>
                                                    <td> <?php echo '&pound'.filter_string($each['grand_total']);?> </td>
                                                    <td> 
                                                    <a href="<?php echo SURL;?>patient/list-all-patients-orders-details/<?php echo $each['patient_id'];?>/<?php echo $each['id'];?>" 
                                                     type="button" class="btn btn-info btn-xs pull-left">View Details
                                                    </a>
                                                    </td>
                                                </tr>
                                     <?php 
									 			} // end foreach loop
									 		} else { ?>
                                            
                                            	<tr class="newRow">
                                                    <td colspan="8"> No records found. </td>
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
