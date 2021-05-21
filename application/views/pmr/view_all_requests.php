<?php if($pending_transaction_list && $pending_transaction_list[0]['order_status'] == 'P'){ ?>
	<!-- Pending Transactions -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success"> 
                    <div class="panel-heading">
                        <strong>Pending Transactions</strong>
                        <div class="pull-right">
                            <a href="<?php echo base_url('organization/pmr'); ?>" class="btn btn-xs btn-default" > Go Back </a>
                        </div>
                        <br /> <br />
                    </div>
                    <div class="panel-body">
                    
						<?php if(!empty($pending_transaction_list)) { $DataTableId = "viewallorderrequest";} else { $DataTableId; }?>
                           
                        <table id="<?php echo $DataTableId; ?>" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>				
                            <?php foreach($pending_transaction_list as $pending_transaction){?>
                            <tr>
                                <td>
                                   <?php echo kod_date_format(filter_string($pending_transaction['created_date']), true); ?> 
                                </td>
                            <td>
                                   <?php echo filter_string($pending_transaction['medicine_name']).' '.filter_string($pending_transaction['medicine_class']); ?> : <?php echo ucwords(filter_string($pending_transaction['patient_name'])); ?> 
                            </td>
                            <td>
                                    <a href="<?php echo base_url(); ?>pmr/patient-dashboard/<?php echo filter_string($pending_transaction['patient_id']).'/'.filter_string($pending_transaction['id']); ?>" class="btn btn-xxs btn-success pull-right">
                                    
                                 <?php 
                                                    if($pending_transaction['medicine_class'] == 'Rx-PGD'){
                                                        
                                                        echo 'Convert';
                                                        
                                                    } elseif($pending_transaction['medicine_class'] == 'Rx') {
            
                                                        echo 'Start';
            
                                                    } // $pending_transaction['medicine_class'] == 'Rx-PGD' 
                ?>
                                    </a>                
                            </td>
                            </tr>
                            <?php } //foreach($pending_transaction_list as $pending_transaction) ?>
                            </tbody>
                        </table>
                    </div>
                 </div> <!-- /.panel-body -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->

<?php } else if($current_deliveries_list && $current_deliveries_list[0]['order_status'] == 'C'){
?>			  
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info"> 
                        <div class="panel-heading"><strong>Current Deliveries</strong>
                        <div class="pull-right"><a href="<?php echo base_url('organization/pmr'); ?>" class="btn btn-xs btn-default" > Go Back </a></div>
                    </div>
                        <div class="panel-body text-center">
                            <?php if(!empty($current_deliveries_list)) { $DataTableId = "viewallorderrequest";} else { $DataTableId; }?>
                       
                            <table id="<?php echo $DataTableId; ?>" class="table">
                                
                                <thead>
                                    <tr>
                                        <td class="text-left"><strong>Time</strong></td>
                                        <td class="text-left"><strong>Patient Name</strong></td>
                                        <!--<td class="text-left"><strong>Tracking Code</strong></td>-->
                                        <td class="text-left"><strong>Delivery Method</strong></td>
                                        <td class="text-left"><strong>Action</strong></td>
                                        
                                    </tr>
                                </thead>
                           
                                <tbody>
                                    <?php foreach($current_deliveries_list as $current_delivery){ // print_this($current_delivery); ?>
                                        <tr>
                                            <td class="text-left">
                                                   <?php echo kod_date_format(filter_string($current_delivery['created_date']), true); ?>
                                            </td>
                                            <td class="text-left">
                                               <?php echo ucwords(filter_string($current_delivery['patient_name'])); ?>
                                            </td>
                                            <!--<td class="text-left">< ?php echo (filter_string($current_delivery['tracking_code']) == '') ? 'Pickup' : filter_string($current_delivery['tracking_code']) ; ?></td>-->
                                            <td class="text-left">
                                              <?php echo (filter_string($current_delivery['order_type']) == 'PMR') ? 'Free Type' : 'Online'?>
                                            </td>
                                            <td class="text-left">
                                                <a class="btn btn-xxs btn-primary preview" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/preview-current-transaction" id="preview" rel="<?php echo filter_string($current_delivery['id']); ?>" > View </a>
                                                
                                            </td>
                                          <!-- Hidden forms containing data to show on preview > -->
                                            <div class="col-md-12 hidden">
                                            
                                                <form id="prescription-preview-form-<?php echo filter_string($current_delivery['id']); ?>" method="post">
                                                    
                                                    <!-- Patient id - hidden field -->
                                                    <input type="hidden" name="patient_id" value="<?php echo filter_string($current_delivery['patient_id']); ?>" />
                                                    <input type="hidden" name="view-current-delivery" value="1" />
                                                    <input type="hidden" name="order-detail-id" value="<?php echo filter_string($current_delivery['id']); ?>" />
                                                    
                                                    <input name="transaction[medicine_class][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_class']); ?>">
                                                    <input name="transaction[medicine_strength_id][]" type="hidden" value="<?php echo filter_string($current_delivery['strength_id']); ?>">
                                                    <input name="transaction[medicine_full_name][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_full_name']); ?>">
                                                    <input name="transaction[medicine_id][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_id']); ?>">
                                                    <input name="transaction[strength][]" type="hidden" value="<?php echo filter_string($current_delivery['strength']); ?>">
                                                    <input name="transaction[medicine_form][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_form']); ?>">
                                                    <input class="form-control" name="transaction[suggested_dose][]" type="hidden" value="<?php echo filter_string($current_delivery['suggested_dose']); ?>">
                                                    <input class="form-control" min="1" name="transaction[qty][]" placeholder="Qty" type="hidden" value="<?php echo filter_string($current_delivery['quantity']); ?>">
                                            
                                                </form>
                                            
                                            </div>
                                        <!-- ./end hidden forms div -->
                                        
                                         </tr>
                                    <?php } // end foreach($current_deliveries_list as $current_delivery) ?>
                                
                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
<?php
	} else if($dispense_transaction_list && $dispense_transaction_list[0]['order_status'] == 'DS'){
?>
	<!-- DIspense -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-warning"> 
				<div class="panel-heading">
					<strong> Dispense Transactions </strong>
					<div class="pull-right"> <a href="<?php echo base_url('organization/pmr'); ?>" class="btn btn-xs btn-default" > Go Back </a> </div> 
				</div>
				<div class="panel-body">
                
                 	<?php if(!empty($dispense_transaction_list)) { $DataTableId = "viewallorderrequest";} else { $DataTableId; }?>
                       
                    <table id="<?php echo $DataTableId; ?>" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>				
                        <?php foreach($dispense_transaction_list as $pending_transaction){?>
                            <tr>
                                <td>
                                    <?php echo kod_date_format(filter_string($pending_transaction['created_date']), true); ?>
                                </td>
                            <td>
                                    <?php echo filter_string($pending_transaction['medicine_name']).' '.filter_string($pending_transaction['medicine_class']); ?> : <?php echo ucwords(filter_string($pending_transaction['patient_name'])); ?> 
                            </td>
                            <td>
                                    <a href="<?php echo base_url(); ?>pmr/patient-dashboard/<?php echo filter_string($pending_transaction['patient_id']).'/'.filter_string($pending_transaction['id']); ?>" class="btn btn-xxs btn-warning pull-right" >
                                    
                                    Dispense
                                    </a>                
                            </td>
                            </tr>
                        <?php } //foreach($pending_transaction_list as $pending_transaction) ?>
                        </tbody>
                    </table>
				</div> <!-- /.panel-body -->
               
			</div> <!-- /.panel -->
			
		</div> <!-- /.col -->

	</div> <!-- /.row -->

<?php } // if($pending_transaction_list) ?>