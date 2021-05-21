<!-- Style for suggesstionbox -->
<style>
    #result_patient li.selected {
        background-color: #ddd;
    }
</style>

<!-- Start - Screen 1 - PMR -->
<div class="row">

	<div class="col-sm-8 col-md-8 col-lg-8">
		<h3>PMR</h3>
	</div>
</div>
<input type="hidden" id="selected_pharmacy_surgery_id" value="<?php echo $this->session->pmr_pharmacy_surgery_id; ?>" readonly="readonly" />
<hr />

<?php 

	if($this->session->pmr_org_pharmacy){ 
?>
	
	<!-- Patients Search -->
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 validate_msg">
			<label for="is_default_doc">Search a patient:</label>
			<input type="text" autocomplete="off" placeholder="Search a patient" required="required" class="form-control search_patient" name="search_patient" id="search_patient" />
			<div id="result_patient"></div>
		</div>
	</div>
    <?php 
		if($this->session->previous_patient_id){
	?>
        <div class="row">
        <br />
            <div class="col-sm-12 col-md-12 col-lg-12  text-center ">
                <a href="<?php echo SURL?>pmr/patient-dashboard/<?php echo $this->session->previous_patient_id?>" type="button" class="btn btn-primary">Previous Patient: <?php echo $this->session->previous_patient_name?></a>
            </div>
        </div>
    
    <?php 
		}//end if($this->session->previous_patient_id)
	?>
	<br />
    

<?php 
	
	} else {
?>
    <div class="well">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                 <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
            </div>
        </div>
    </div>
<?php
	

	} // end $$this->session->pmr_org_pharmacy ?>

<?php 
	if($pending_transaction_list){ 
?>
	<!-- Pending Transactions -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success"> 
				<div class="panel-heading">
					<strong>Pending Transactions</strong>
                     <?php if(count($pending_transaction_list_all) > 10) {?>
					<div class="pull-right">
						<a href="<?php echo base_url('organization/pmr/view-all-requests/P'); ?>" class="btn btn-xs btn-default" > View all Pending Transactions </a>
					</div>
                    <?php }?>
					 <br />
				</div>
				<div class="panel-body">
                	<table class="table table-responsive table-hover table-striped">
                    	<thead>
                        	<th>Date</th>
                            <th>Patient Name & Address</th>
                            <th>Medicine</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
						<?php 				// print_this($pending_transaction_list);
                            foreach($pending_transaction_list as $pending_transaction){ // print_this($pending_transaction);
                        ?>
                                <tr>
                                	<td><?php echo kod_date_format(filter_string($pending_transaction['created_date']), true); ?></td>
                                    <td>
                                        <?php echo filter_name($pending_transaction['p_patient_name']); ?><br />
                                        <?php 
											echo ($pending_transaction['p_patient_delivery_address']) ? filter_string($pending_transaction['p_patient_delivery_address']) :  filter_string($pending_transaction['p_patient_address']); 
										?>
                                    </td>
                                    <td><?php echo filter_string($pending_transaction['p_medicine_name']); ?></td>
                                    <td class="text-left">
                                        <a href="<?php echo base_url(); ?>pmr/patient-dashboard/<?php echo filter_string($pending_transaction['patient_id']).'/'.filter_string($pending_transaction['id']); ?>" class="btn btn-xxs btn-success">
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
                        <?php					
                            } //foreach($pending_transaction_list as $pending_transaction)
                        ?>				
                        </tbody>
                    </table>
				</div> <!-- /.panel-body -->

			</div> <!-- /.panel -->
			
		</div> <!-- /.col -->

	</div> <!-- /.row -->

<?php 
} // if($pending_transaction_list)
?>

<?php


if($vaccine_pending_transaction_list){
?>
	<!-- Pending Transactions -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success"> 
				<div class="panel-heading">
					<strong>Vaccine: Pending Transactions</strong>
                     <?php if(count($vaccine_pending_transaction_list_all) > 10) {?>
					<div class="pull-right">
						<a href="<?php echo base_url('organization/pmr/view-all-requests/P'); ?>" class="btn btn-xs btn-default" > View all Vaccine Pending Transactions </a>
					</div>
                    <?php }?>
					<br /> <br />
				</div>
				<div class="panel-body">
	<?php 				// print_this($pending_transaction_list);
						foreach($vaccine_pending_transaction_list as $pending_transaction){ // print_this($pending_transaction);
	?>
							<div class="row">
								<div class="col-sm-4 col-md-4 col-lg-4"><?php echo kod_date_format(filter_string($pending_transaction['created_date']), true); ?></div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									 <?php echo ($pending_transaction['vaccine_id'] == 2) ? 'Travel Vaccine' : 'Flu Vaccine' ; ?> :  <?php echo filter_string($pending_transaction['patient_name']); ?>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">

									<a href="<?php echo base_url(); ?>pmr/patient-dashboard/<?php echo filter_string($pending_transaction['patient_id']).'/'.filter_string($pending_transaction['id']); ?>/<?php echo ($pending_transaction['vaccine_id'] == 1) ? 1 : 2 ; ?>" class="btn btn-xxs btn-success pull-right">
	<?php 
										if($pending_transaction['medicine_class'] == 'Rx-PGD'){
											
											echo 'Convert';
											
										} elseif($pending_transaction['medicine_class'] == 'Rx') {

											echo 'Start';

										} // $pending_transaction['medicine_class'] == 'Rx-PGD' 
	?>
									</a>

								</div>
							</div> <!-- /.row -->
							<hr />
<?php					
						} //foreach($pending_transaction_list as $pending_transaction)
?>				
				</div> <!-- /.panel-body -->

			</div> <!-- /.panel -->
			
		</div> <!-- /.col -->

	</div> <!-- /.row -->

<?php 
} // if($vaccine_pending_transaction_list)

//<!-- Start - Dispense-->
if($dispense_transaction_list){ 
?>
	<!-- DIspense -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning"> 
                <div class="panel-heading">
                    <strong> Dispense Transactions </strong>
                    <?php if(count($dispense_transaction_list_all) > 10) {?>
                    <div class="pull-right"> <a href="<?php echo base_url('organization/pmr/view-all-requests/DS'); ?>" class="btn btn-xs btn-default" > View all Dispense Transactions </a> </div> 
                    <?php }?>
                   
                </div>
                <div class="panel-body">				

                    <div class="row">

                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <strong> Date </strong>    
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <strong>Patient Name &amp; Address</strong>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <strong>Medicine</strong>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 text-center">
                            <strong>Action</strong>                          
                        </div>

                    </div>
                    <hr />
    <?php 
                        foreach($dispense_transaction_list as $transaction){

    ?>
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3"><?php echo kod_date_format(filter_string($transaction['created_date']), true); ?></div>

                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <?php echo ucwords(filter_string($transaction['p_patient_name'])); ?> <br />

                                        <?php 
											echo ($transaction['p_patient_delivery_address']) ? filter_string($transaction['p_patient_delivery_address']) :  filter_string($transaction['p_patient_address']); 
										?>
                                     
                                </div>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                     <?php echo filter_string($transaction['p_medicine_short_name']).' '.filter_string($transaction['p_strength_name']); ?> 
                                     <?php echo filter_string($transaction['quantity']); ?> 
									 <?php echo filter_string($transaction['p_medicine_form'])?>
                                </div>
                                
                                <div class="col-sm-2 col-md-2 col-lg-2 text-center">

                                    <?php /* ?>
                                        
                                    <a href="<?php echo base_url(); ?>pmr/patient-dashboard/<?php echo filter_string($transaction['patient_id']).'/'.filter_string($transaction['id']); ?>" class="btn btn-xxs btn-warning pull-right" > Dispense </a>

                                    <?php */ ?>

                                    <a class="btn btn-xxs btn-warning preview" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/preview-current-transaction" id="preview" rel="<?php echo $transaction['id']; ?>" > Dispense </a>

                                </div>
                            </div> <!-- /.row -->
                            
                            <!-- Hidden forms containing data to show on preview -->
                                <div class="col-md-12 hidden">

                                    <form id="prescription-preview-form-<?php echo $transaction['id']; ?>" method="post">
                                        
                                        <!-- Patient id - hidden field -->
                                        <input type="hidden" name="patient_id" value="<?php echo filter_string($transaction['patient_id']); ?>" readonly="readonly"/>
                                        <input type="hidden" name="order-detail-id" value="<?php echo filter_string($transaction['id']); ?>" readonly="readonly"/>
                                        <input type="hidden" name="dispense-transaction" value="1" readonly="readonly"/>
                                        
                                        <input name="transaction[medicine_class][]" type="hidden" value="<?php echo filter_string($transaction['medicine_class']); ?>" readonly="readonly">
                                        <input name="transaction[medicine_strength_id][]" type="hidden" value="<?php echo filter_string($transaction['strength_id']); ?>" readonly="readonly">
                                        <input name="transaction[medicine_full_name][]" type="hidden" value="<?php echo $transaction['medicine_full_name']; ?>" readonly="readonly">
                                        <input name="transaction[medicine_id][]" type="hidden" value="<?php echo filter_string($transaction['medicine_id']); ?>" readonly="readonly">
                                        <input name="transaction[strength][]" type="hidden" value="<?php echo filter_string($transaction['strength']); ?>" readonly="readonly">
                                        <input name="transaction[medicine_form][]" type="hidden" value="<?php echo filter_string($transaction['medicine_form']); ?>" readonly="readonly">
                                        <input class="form-control" name="transaction[suggested_dose][]" type="hidden" value="<?php echo filter_string($transaction['suggested_dose']); ?>" readonly="readonly">
                                        <input class="form-control" min="1" name="transaction[qty][]" placeholder="Qty" type="hidden" value="<?php echo filter_string($transaction['quantity']); ?>" readonly="readonly">

                                    </form>
                                    
                                </div>
                                <!-- ./end hidden forms div -->

                            <hr />

    <?php					} //foreach($pending_transaction_list as $pending_transaction)
    ?>

                </div> <!-- /.panel-body -->

            </div> <!-- /.panel -->
            
        </div> <!-- /.col -->

    </div> <!-- /.row -->

<?php 
	}// if($pending_transaction_list) 

	//<!-- Start - Current Deliveries -->
	if($current_deliveries_list ){
?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info"> 
                    <div class="panel-heading"><strong>Current Deliveries</strong>
                    <?php if(count($current_deliveries_list_all) > 10) {?>
                     <div class="pull-right">
                        <a href="<?php echo base_url('organization/pmr/view-all-requests/C'); ?>" class="btn btn-xs btn-default" > View all Current Deliveries </a>
                    </div>
                    <?php } ?>
                    
                    </div>
                   
    
                    <div class="panel-body text-center">
                    	<div class="row">
                        	<div class="col-md-3 text-left"><strong>Date</strong></div>
                            <div class="col-md-3 text-left"><strong>Patient Name & Address</strong></div>
                            <div class="col-md-3 text-left"><strong>Medicine</strong></div>
                            <!--<div class="col-sm-2 col-md-2 col-lg-2 text-left"><strong>Tracking Code</strong></div>-->
                            <div class="col-md-2 text-left"><strong>Delivery Method</strong></div>
                            <div class="col-md-1 text-center"><strong>Action</strong></div>
                        </div>
                        <hr />
                        
                        <?php foreach($current_deliveries_list as $current_delivery){ // print_this($current_delivery); ?>

                            <div class="row">

                                <div class="col-md-3 text-left"><?php echo kod_date_format(filter_string($current_delivery['created_date']), true); ?>
                                </div>
                                
                                <div class="col-md-3 text-left"> 
									<?php echo ucwords(filter_string($current_delivery['p_patient_name'])); ?> <br />
                                    <?php //echo filter_string($current_delivery['p_patient_address']); ?> 
                                    <?php 
											echo ($current_delivery['p_patient_delivery_address']) ? filter_string($current_delivery['p_patient_delivery_address']) :  filter_string($current_delivery['p_patient_address']); 
										?>
                                    
                                </div>
                                <div class="col-md-3 text-left"> 

                                     <?php echo filter_string($current_delivery['p_medicine_short_name']).' '.filter_string($current_delivery['p_strength_name']); ?> 
                                     <?php echo filter_string($current_delivery['quantity']); ?> 
									 <?php echo filter_string($current_delivery['p_medicine_form'])?>
                                    
                                </div>
                                
                                <!--<div class="col-sm-2 col-md-2 col-lg-2 text-left">< ?php echo (filter_string($current_delivery['tracking_code']) == '') ? 'Pickup' : filter_string($current_delivery['tracking_code']) ; ?>
                                </div>-->

                                <div class="col-md-2 text-left"><?php echo (filter_string($current_delivery['order_type']) == 'PMR') ? 'Free Type' : 'Online'?></div>
                                
                                <div class="col-md-1 text-center">
                                    <a class="btn btn-xxs btn-primary preview" data-fancybox-type="ajax" <?php if($current_delivery['is_pgd'] == '1'){ ?> href="<?php echo base_url(); ?>pmr/pgd-prescription-preview/<?php echo $current_delivery['id'].'/'.$current_delivery['medicine_id']; ?>" <?php } else { ?> href="<?php echo base_url(); ?>pmr/preview-current-transaction" <?php } // if => is_pgd : 1 ?> id="preview" rel="<?php echo $current_delivery['id']; ?>" > View </a>

                                    <?php /* ?>
                                    <a href="<?php echo base_url(); ?>pmr/pgd-prescription-preview/<?php echo $current_delivery['id'].'/'.$current_delivery['medicine_id']; ?>"  class="fancybox_view fancybox.ajax"> PGD </a>
                                    <?php */ ?>

                                </div>

                            </div> <!-- ./row -->
                            
                            <hr />

                            <!-- Hidden forms containing data to show on preview > -->
                            <div class="col-md-12 hidden">

                                <form id="prescription-preview-form-<?php echo $current_delivery['id']; ?>" method="post">
                                    
                                    <!-- Patient id - hidden field -->
                                    <input type="hidden" name="patient_id" value="<?php echo filter_string($current_delivery['patient_id']); ?>" readonly="readonly" />
                                    <input type="hidden" name="view-current-delivery" value="1"  readonly="readonly"/>
                                    <input type="hidden" name="order-detail-id" value="<?php echo filter_string($current_delivery['id']); ?>" readonly="readonly" />
                                    
                                    <input name="transaction[medicine_class][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_class']); ?>" readonly="readonly">
                                    <input name="transaction[medicine_strength_id][]" type="hidden" value="<?php echo filter_string($current_delivery['strength_id']); ?>" readonly="readonly">
                                    <input name="transaction[medicine_full_name][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_full_name']); ?>" readonly="readonly">
                                    <input name="transaction[medicine_id][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_id']); ?>" readonly="readonly">
                                    <input name="transaction[strength][]" type="hidden" value="<?php echo filter_string($current_delivery['strength']); ?>" readonly="readonly">
                                    <input name="transaction[medicine_form][]" type="hidden" value="<?php echo filter_string($current_delivery['medicine_form']); ?>" readonly="readonly">
                                    <input class="form-control" name="transaction[suggested_dose][]" type="hidden" value="<?php echo filter_string($current_delivery['suggested_dose']); ?>" readonly="readonly">
                                    <input class="form-control" min="1" name="transaction[qty][]" placeholder="Qty" type="hidden" value="<?php echo filter_string($current_delivery['quantity']); ?>">

                                </form>

                            </div>
                            <!-- ./end hidden forms div -->

                        <?php } // end foreach($current_deliveries_list as $current_delivery) ?>
                        
                    </div>
                </div>
            </div>
        </div>
<?php

	}// if($current_deliveries_list)
?>