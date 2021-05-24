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
			<h2>User Orders<small>User Orders Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
             <?php if(!empty($userorders_list)){ $DataTableId ="exampleOrderListing";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
						<th>User Name</th>
                        <th>Order Number</th>
                        <th>Transaction Id </th>
						<th>Purchase Date</th>
                        <th>Order Details</th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($userorders_list)){
					    
						foreach($userorders_list as $each):  ?>
						
                        <tr class="even pointer"> 
                        	<td class=" "><?php echo filter_string($each['first_name'])." ".filter_string($each['last_name']); ?></td>
							<td class=" "><?php echo filter_string($each['order_no']); ?></td>
                            <td class=" "><?php echo filter_string($each['paypal_transaction_id']); ?></td>
							<td class=" "><?php echo kod_date_format($each['purchase_date']); ?></td>
                            <td class=" ">
                            	 <a href="<?php echo base_url(); ?>userorders/order-details/<?php echo $each['id']; ?>" class="fancybox_view fancybox.ajax" title="" ><i class="fa fa-shopping-cart"></i></a>
						    </td>
                           
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
