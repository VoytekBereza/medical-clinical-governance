<!-- Style for suggesstionbox -->
<style>
	.medicine_suggessions li.selected {
	    background-color: #ddd;
	}
</style>

<div id="overlay_addtobasket" class="overlay hidden">
	<div class="col-md-12 text-center" style="margin-top:150px;"></div>
</div>

<!-- <input class="form-control filterme"  /> -->
<?php if($this->uri->segment(3)){ ?>
	<input type="hidden" name="pmr_patient_id" id="pmr_patient_id" value="<?php echo $this->uri->segment(3); ?>" />
<?php } // if($this->uri->segment(3))
	
if(!$patient_in_same_ps){
	
	// Show Merge History popup
?>

	<div class="row">
		<div class="col-sm-1 col-md-1 col-lg-1"></div>
		<div class="col-sm-10 col-md-10 col-lg-10">			
			<div class="well">
				
				<?php echo filter_string($merge_error_cms['page_description']); ?>
				<a href="<?php echo base_url(); ?>pmr/merge-history-send-email/<?php echo $this->uri->segment(3); ?>/<?php echo $this->session->pmr_pharmacy_surgery_id; ?>" class="btn btn-sm btn-info">Send Email</a>

			</div>
		</div>
		<div class="col-sm-1 col-md-1 col-lg-1"></div>
	</div>
<?php
	} else {
	// Show Patient Dashboard

if($vaccine_type){

	// Verify vaccine type [ Flu - Travel ]
	if($vaccine_type == 1){
		// Flu


	} else if($vaccine_type == 2){
		// Travel


	} // End - if($vaccine_type == 1)
}

?>

	<!-- Start - Screen 3 - PMR - Free Type -->
	

	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-4">
			
			<h3 class="no_margin">
				Patient History
				<?php
				
				if($is_online && $is_online == 1 && $vaccine_type == ''){
					echo ''; //'PMR Online';
					$patient_container_heading = 'Online PMR';
				} else if($order_status == 'DS'){ 
					echo ''; //'Dispense';
				} else if($free_type == 1){ 
					echo ''; //'PMR Free Type'; 
					$patient_container_heading = 'Prescription Pad';
				} else if($vaccine_type){
					echo ''; //($vaccine_type == 2) ? 'Travel Vaccine' : 'Flu Vaccine' ;
				} else { 
					//echo "Walkin PGDs"; 
					$walkin_pgd = 1;
					$patient_container_heading = 'Walk-in PGD';
				} // if($is_online && $is_online == 1 && $vaccine_type == '')
				
				?>
			</h3>

		</div>
	</div>
	<hr />
    <div class="row">
    	<div class="col-sm-12 col-md-12 col-lg-12">
        	<h3 class="text-primary"> 
				<?php echo ucwords(filter_string($patient_data['first_name'])).' '.ucwords(filter_string($patient_data['last_name'])); ?>
                <a href="<?php echo base_url(); ?>pmr/edit-patient-info/<?php echo $patient_data['id']; ?>"  class="fancybox_view fancybox.ajax" style="font-size:13px"> Edit  </a>
            </h3>
        </div>
    </div>

	<div class="row">
    	<div class="col-md-8">
        
        	<div class="row">
            	<div class="col-sm-7 col-md-7 col-lg-7" style="padding-left:25px">                    
                    <br />
                    <p><i class="glyphicon glyphicon-map-marker"></i> <?php echo filter_string($patient_data['address']).', '.filter_string($patient_data['postcode']); ?></p>
                    <p><i class="glyphicon glyphicon-envelope"></i> <?php echo filter_string($patient_data['email_address']); ?></p>
                    <p><i class="glyphicon glyphicon-home"></i> <strong>GP Name and address:</strong><br />
        
                        <?php 
                            if(filter_string($patient_data['gp_firstname']) != ''){
                                
                                echo ucwords(filter_string($patient_data['gp_firstname'])).' '.ucwords(filter_string($patient_data['lastname'])).'<br />';
                                echo filter_string($patient_data['gp_address']).' '.filter_string($patient_data['gp_address2']).' '.filter_string($patient_data['gp_address3']).'<br>';
                                echo filter_string($patient_data['gp_postcode']).', '.filter_string($patient_data['country_name']);
                            }else
                                echo 'N/a';
                            //end if(filter_string($patient_data['gp_firstname']))
                        ?>
                    </p>
                </div>
        
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <br />
                    <p><i class="glyphicon glyphicon-phone"></i> <?php echo filter_string($patient_data['mobile_no']); ?></p>
                    <p><i class="glyphicon glyphicon-calendar"></i> DOB: <?php echo kod_date_format(filter_string($patient_data['dob'])); ?></p>			
                    <p><i class="glyphicon glyphicon-user"></i> <?php echo (filter_string($patient_data['gender']) == 'M') ? 'Male' : 'Female'; ?></p>
                </div>
			</div>
        
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Notes: Allergies etc</strong>
					<textarea class="form-control" id="input-allergies" rel="<?php echo $patient_data['id']; ?>" placeholder="enter text here" cols="27" rows="5" style="font-size:12px"><?php echo str_replace('<br />', '', filter_string($patient_data['allergies'])); ?></textarea>
					<i>Note: Data will be saved immediately</i>
				</div>
			</div>
    	</div>
	</div>

    <div class="panel panel-default"> 
    <!-- Default panel contents -->
    	<div class="panel-heading"><strong> <?php echo ($patient_container_heading) ? $patient_container_heading : '' ; ?> </strong></div>
	    <div class="panel-body">
            
            <!-- KODSTART -->
            <?php 
				if($walkin_pgd == 1){
			?>

				<div class="panel panel-body">

					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-8" >
							<select class="form-control pull-right" id="select-raf" onChange="javascript:get_raf_and_medicine(this)" style="width:90%" >
								<option value=""> Please select Risk Assessment Form (RAF) you would like to use: </option>
								
								<?php if($catefory_rafs){ 
									$i = 0;
									foreach($catefory_rafs as $raf){ ?>

										<option <?php echo ($i == 3) ? '' : '' ; ?> value="<?php echo $raf['id']; ?>" > <?php echo filter_string($raf['category_title']); ?> </option>

									<?php $i++; } // foreach($catefory_rafs as $raf)

									} // if($catefory_rafs) ?>

							</select>
						</div>
					</div> <!-- /.row -->

					<!-- Start - Category RAF -->
					<div class="row" style="display: none;" id="raf-row">
						<!-- Form containing all free type walking PGD transaction (jQuery) -->
						
						<form id="validate_ajax_form" action="<?php echo base_url(); ?>organization/pmr/save-walkin-pgd" method="POST" > <!--id="walkin-pgd-form" -->
						
							<br />

							<!-- New Structure -->
							<div class="col-md-12" id="category-raf-div"></div>
							<hr />
							
							<div class="col-md-12" id="walkin-pgd-submit-div" style="display: block;" >

								<div class="pull-right">
									
									<!-- <button type="button" class="btn btn-sm btn-warning" > Print </button> -->
									<br /> <br />

									<button type="submit" class="btn btn-sm btn-success hidden" id="raf_complete_submit" onClick="validate_this_form('validate_ajax_form')" > Submit </button>

									<button type="button" class="btn btn-sm btn-success" id="raf_complete_btn" onClick="validate_this_form('validate_ajax_form')" > Submit </button>
									
								</div>

							</div>

						<input type="hidden" name="prescription_no" id="prescription_no" value="<?php echo strtoupper(random_number_generator(16)); ?>" />
						</form>
					</div>
					<!-- End - Category RAF -->

				</div>

			<?php 
				} // if($walkin_pgd == 1)
			?>

			<!-- Start - Patient Pending Transactions -->
			<?php 
				if($is_online && $order_status == 'P' && $vaccine_type == ''){ 
			?>
				<h4> Current Transactions </h4>
				<div class="panel panel-warning panel-body">
			<?php
					if( $patient_pending_transactions ){

						foreach( $patient_pending_transactions as $transaction ){
			?>
							<div class="row">

								<div class="col-sm-3 col-md-3 col-lg-3 text-center"> <strong> <?php echo kod_date_format(filter_string($transaction['created_date']), true); ?> </strong></div> 
								<div class="col-sm-3 col-md-3 col-lg-3 text-center"> <strong> <?php echo (filter_string( $transaction['medicine_name'])) ? filter_string( $transaction['medicine_name']).' - '.filter_string($transaction['medicine_class']) : 'N/A' ; ?> </strong> </div>
								<div class="col-sm-2 col-md-2 col-lg-2 text-center"> <strong> <?php echo (filter_string( $transaction['strength'])) ? filter_string( $transaction['strength']) : 'N/A' ; ?> </strong> </strong> </div>
								<div class="col-sm-2 col-md-2 col-lg-1 text-right"> <strong> <?php echo (filter_string( $transaction['quantity'])) ? filter_string( $transaction['quantity']) : 'N/A' ; ?> </strong> </div>
								<div class="col-sm-3 col-md-3 col-lg-3 text-right">

									<a href="<?php echo base_url(); ?>organization/pmr/view-raf/<?php echo filter_string($transaction['patient_id']); ?>/<?php echo filter_string($transaction['product_type']); ?>/<?php echo (filter_string($transaction['medicine_id'])) ? filter_string($transaction['medicine_id']) : filter_string($transaction['vaccine_id']) ; ?>" class="btn btn-xxs btn-info fancybox_view fancybox.ajax" >
			                        	RAF
			                    	</a>

									<a class="btn btn-xxs btn-success preview" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/preview-current-transaction" id="preview" rel="<?php echo $transaction['id']; ?>" > <?php echo (filter_string($transaction['medicine_class']) == 'Rx') ? 'Approve' : 'Convert' ; ?> </a>
								</div>

								<!-- Hidden forms containing data to show on preview > -->
								<div class="col-md-12 hidden">

									<form id="prescription-preview-form-<?php echo $transaction['id']; ?>" method="post">
										
										<!-- Patient id - hidden field -->
										<input type="hidden" name="patient_id" value="<?php echo filter_string($transaction['patient_id']); ?>" readonly="readonly"/>
										<input type="hidden" name="approve-transaction" value="1" readonly="readonly"/>
										<input type="hidden" name="order-detail-id" value="<?php echo filter_string($transaction['id']); ?>" readonly="readonly"/>
										
										<input name="transaction[medicine_class][]" type="hidden" value="<?php echo filter_string($transaction['medicine_class']); ?>" readonly="readonly">
										<input name="transaction[medicine_strength_id][]" type="hidden" value="<?php echo filter_string($transaction['strength_id']); ?>" readonly="readonly">
										<input name="transaction[medicine_full_name][]" type="hidden" value="<?php echo filter_string($transaction['medicine_full_name']); ?>" readonly="readonly">
										<input name="transaction[medicine_id][]" type="hidden" value="<?php echo filter_string($transaction['medicine_id']); ?>" readonly="readonly">
										<input name="transaction[strength][]" type="hidden" value="<?php echo filter_string($transaction['strength']); ?>" readonly="readonly">
										<input name="transaction[medicine_form][]" type="hidden" value="<?php echo filter_string($transaction['medicine_form']); ?>" readonly="readonly">
										<input class="form-control" name="transaction[suggested_dose][]" type="hidden" value="<?php echo filter_string($transaction['suggested_dose']); ?>" readonly="readonly">
										<input class="form-control" min="1" name="transaction[qty][]" placeholder="Qty" type="hidden" value="<?php echo filter_string($transaction['quantity']); ?>" readonly="readonly">

									</form>

								</div>
								<!-- ./end hidden forms div -->

							</div>

							<hr />
							<br />
			<?php 		
						} // foreach( $patient_pending_transactions as $transaction ) 
						
				} // if( $patient_pending_transactions ) 
			?>

				</div>

			<?php } // end if(!$is_online) ?>

			<!-- End - Patient Pending Transactions  -->
			<?php /* if($is_online && $order_status == 'DS' && $vaccine_type == ''){ ?>
				<h4> Current Transactions </h4>
				<div class="panel panel-warning panel-body">
			<?php
					if( $patient_dispense_transactions ){

						foreach( $patient_dispense_transactions as $transaction ){

							// print_this( $transaction );
			?>
							<div class="row">

								<div class="col-sm-3 col-md-3 col-lg-3 text-center"> <strong> <?php echo kod_date_format(filter_string($transaction['created_date']), true); ?> </strong></div>
								<div class="col-sm-3 col-md-3 col-lg-3 text-center"> <strong> <?php echo (filter_string( $transaction['medicine_name'])) ? filter_string( $transaction['medicine_name']).' - '.filter_string($transaction['medicine_class']) : 'N/A' ; ?> </strong> </div>
								<div class="col-sm-2 col-md-2 col-lg-2 text-center"> <strong> <?php echo (filter_string( $transaction['strength'])) ? filter_string( $transaction['strength']) : 'N/A' ; ?> </strong> </strong> </div>
								<div class="col-sm-2 col-md-2 col-lg-1 text-right"> <strong> <?php echo (filter_string( $transaction['quantity'])) ? filter_string( $transaction['quantity']) : 'N/A' ; ?> </strong> </div>
								<div class="col-sm-3 col-md-3 col-lg-3 text-right">

									<a href="<?php echo base_url(); ?>organization/pmr/view-raf/<?php echo filter_string($transaction['patient_id']); ?>/<?php echo filter_string($transaction['product_type']); ?>/<?php echo (filter_string($transaction['medicine_id'])) ? filter_string($transaction['medicine_id']) : filter_string($transaction['vaccine_id']) ; ?>" title="<?php echo filter_string($transaction['medicine_name']); ?>'s Risk assesment form." class="btn btn-xxs btn-info fancybox_view fancybox.ajax" >
			                        	RAF
			                    	</a>

								<button class="btn btn-xxs btn-success"> <?php echo (filter_string($transaction['medicine_class']) == 'Rx') ? 'Convert' : 'Approve' ; ?> </button>
								</div>

							</div>

							<hr />
							<br />
		<?php
						} // foreach( $patient_dispense_transactions as $transaction ) ?>

		<?php		} // if( $patient_dispense_transactions ) ?>
					
				</div>

			<?php } // end if(!$is_online && $order_status != 'DS') */ ?>

			<?php if(!$is_online && $order_status != 'DS' && $free_type == 1 && $vaccine_type == ''){ ?>

				<h4> Current Transaction </h4>
				<div class="panel panel-default panel-body">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<!--<input type="text" class="form-control search-medicine" id="search-medicine" value="" placeholder="To add a new medicine to the prescription, type here." />-->
                            <input type="text" class="form-control search-medicine-custom" autofocus id="search-medicine-custom" value="" placeholder="To add a new medicine to the prescription, type here." />
						</div>
					</div>

					<br />
					<!-- Start - Current transactions form -->
					<!-- < form action="<?php echo base_url(); ?>pmr/preview-current-transaction" method="post"> -->
					<form id="prescription-preview-form" method="post">
						
						<span id="current-transaction-row"></span>
						
						<!-- Patient id - hidden field -->
						<input type="hidden" name="patient_id" value="<?php echo filter_string($patient_data['id']); ?>" />
						
						<div class="row" id="preview-btn-div">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<p class="text-danger text-center">Please select a medicine.</p>
								<a class="btn btn-sm btn-success pull-right preview hidden" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/preview-current-transaction/1" id="preview">Preview</a>
							</div>
						</div>
						
					</form>
					<!-- End - Current transactions form -->
					
				</div>

			<?php } // if(!$is_online && $order_status != 'DS') ?>

			<?php /* if($dispense_transaction_list){ ?>
				<!-- DIspense -->
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-warning"> 
							<div class="panel-heading">
								<strong> Dispense Transactions </strong>
								<div class="pull-right"> <a href="<?php echo base_url('organization/pmr/all-pending-requests'); ?>" class="btn btn-xs btn-default" > View all Dispense Transactions </a> </div> 
								<br /> <br />
							</div>
							<div class="panel-body">				
		<?php
									foreach($dispense_transaction_list as $transaction){
										// print_this($transaction);
		?>
										<div class="row">
											<div class="col-sm-4 col-md-4 col-lg-4">

												<span class="text-success"><strong> <?php echo kod_date_format(filter_string($transaction['created_date']), true); ?> </strong></span>
											</div>
											<div class="col-sm-6 col-md-6 col-lg-6">
												<span class="text-primary"><strong> <?php echo filter_string($transaction['medicine_name']).' '.filter_string($transaction['medicine_class']); ?> : </strong> <?php echo filter_string($transaction['patient_name']); ?> </span>
											</div>
											<div class="col-sm-2 col-md-2 col-lg-2">

												<a class="btn btn-xxs btn-success pull-right preview" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/preview-current-transaction" id="preview" rel="<?php echo $transaction['id']; ?>" > Dispense </a>
												
											</div>
										</div> <!-- /.row -->

										<!-- Hidden forms containing data to show on preview -->
										<div class="col-md-12 hidden">

											< form id="prescription-preview-form-<?php echo $transaction['id']; ?>" method="post">
												
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

		<?php						} //foreach($pending_transaction_list as $transaction)
		?>
							</div> <!-- /.panel-body -->

						</div> <!-- /.panel -->
						
					</div> <!-- /.col -->

				</div> <!-- /.row -->

		<?php 
			
			} // if($pending_transaction_list)
			*/
			if($vaccine_type){
		?>
				<div class="col-md-12">
					<select class="form-control hidden" id="select-raf-hidden" onChange="javascript:get_raf_and_medicine(this)" >
						<option value="" > Choose </option>
						<option selected="selected" value="<?php echo ($vaccine_type == 1) ? 30 : 33 ; ?>" > RAF </option>
					</select>

					<!-- Start - Category RAF -->
					<div class="row" style="display: none;" id="raf-row">  
						<!-- Form containing all free type walking PGD transaction (jQuery) -->
						
						<form action="<?php echo base_url(); ?>organization/pmr/save-walkin-pgd" method="POST" id="walkin-pgd-form" >

							<!-- Start - Input hidden field to track the request is from autoload ajax contents from vaccine Travel - Flu -->
							<input type="hidden" name="is_vaccine_request" id="is_vaccine_request" value="<?php echo $vaccine_type;  ?>" />
							<input type="hidden" id="vaccine_order_id" value="<?php echo $this->uri->segment(4);  ?>" />
							<input type="hidden" name="previous_order_detail_id" id="previous_order_detail_id" value="<?php echo $this->uri->segment(4);  ?>" />
							<!-- <input type="hidden" id="pmr_patient_id" value="< ?php echo $this->uri->segment(3); ?>" /> -->
							<!-- End - Input hidden field to track the request is from autoload ajax contents from vaccine Travel - Flu -->

							<br />
							<div class="panel panel-info">
								
								<div class="panel-heading"> <strong id="raf-row-title"></strong> </div>
								<div class="panel-body">

									<!-- All ajax - jQuery contents <<div>> -->
									<div class="col-md-12" id="category-raf-div"></div>

								</div>

							</div>

							<div class="row">
								<div class="col-md-12" id="walkin-pgd-submit-div" style="display: block;" >
									<div class="pull-right">
										<!-- <button type="button" class="btn btn-sm btn-warning" > Print </button> -->
										<button type="submit" class="btn btn-sm btn-success" > Complete </button>
									</div>
									<br /><br /><br />
								</div>
							</div>

						</form>
					</div>
					<!-- End - Category RAF -->
				</div>

			<?php } // if($vaccine_type) ?>
            <!-- KODEND -->
            
            <div class="row">
                <!-- Stat - Governance tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#medicine_history_tab">Medicine History</a></li>
                    <li><a data-toggle="tab" href="#vaccine_history_tab">Vaccine History</a></li>
                </ul>
                
                <div class="tab-content">
                    <div id="medicine_history_tab" class="tab-pane fade in active">
                    	<br />
                        <!-- Pending Transactions -->
                        <div class="row" id="grouped-medicine-div">
                            <div class="col-md-12">
                                <?php if(!empty($patient_history)) { $DataTableId = "viewalpatienthistory";} else { $DataTableId; }?>
                                <table id="<?php echo $DataTableId; ?>" class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
                                
                                    <thead>
                                    
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Form</th>
                                            <th class="text-center">Strength</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Dose</th>
                                            <th class="text-center">Transaction</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Date</th>
                                            <?php if(!$is_online && $order_status != 'DS' && $free_type == 1 && $vaccine_type == ''){ ?>
                                                <th class="text-center">Repeat</th>
                                            <?php } // end if(!$is_online && $order_status != 'DS') ?>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    <?php
										//print_this($patient_history);exit;
                                        if($patient_history){ 
										
											foreach($patient_history as $medicine_name => $each){
									?>
                                    
                                                <tr>
                                                    <td>
                                                    	<?php 
															$med_id = ($each['order_type'] == 'PMR') ? $each['pmr_med_id'] : $each['medicine_id'];
															
															if($each['order_type'] == 'PMR'){
														?>
	                                                        <a class="medicine-details-popup" onClick="" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/patient-medicine-history/<?php echo $each['patient_id'];?>/<?php echo $med_id;?>/C<?php echo ($is_online && $is_online == 1) ? '/1' : '/0' ; ?>/1" id="preview"> <?php echo $each['p_medicine_short_name']; ?> </a>
                                                        
                                                        <?php																
															}else{
														?>
    	                                                    <a class="medicine-details-popup" onClick="" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/patient-medicine-history/<?php echo $each['patient_id'];?>/<?php echo $med_id;?>/C<?php echo ($is_online && $is_online == 1) ? '/1' : '/0' ; ?>" id="preview"> <?php echo $each['p_medicine_short_name']; ?> </a>
                                                        <?php 
															}
														?>
                                                    </td>
                                                    <td><?php echo filter_string($each['p_medicine_form']); ?></td>
                                                    <td><?php echo filter_string($each['p_strength_name']); ?></td>
                                                    <td><?php echo filter_string($each['quantity']); ?></td>
                                                    <td><?php echo filter_string($each['p_suggested_dose']); ?></td>
                                                    <td><?php echo filter_string($each['order_type']).' '.filter_string($each['medicine_class']); ?></td>
                                                    <td><?php echo filter_string($each['prescribed_by_name']); ?></td>
                                                    <td><?php echo kod_date_format(filter_string($each['created_date']));?>
                                                    </td>
                                                    <?php 
														if(!$is_online && $order_status != 'DS' && $free_type == 1 && $vaccine_type == ''){ ?>
                                                        <td>
                                                        	<?php 

																if($each['order_type'] == 'PMR'){
															?>
                                                        	    <button class="btn btn-xs btn-primary" title="Repeat Medicine" onclick="select_medicine_custom('<?php echo $med_id; ?>', '<?php echo $each['p_medicine_short_name']?>', '<?php echo $each['p_strength_name']; ?>', '<?php echo $each['p_medicine_form']; ?>')" ><i class="fa fa-repeat"></i></button>
                                                        </td>
                                                    <?php 
															}
														} // end if(!$is_online && $order_status != 'DS') 
													?>
                                                </tr>                                    
                                    <?php			
											}//end foreach($patient_history as $medicine_name => $med_arr)
												
										
											/*
                                            foreach($patient_history as $each){
                                    ?>
                                                <tr>
                                                    <td>
                                                        <a class="medicine-details-popup" onClick="" data-fancybox-type="ajax" href="<?php echo base_url(); ?>pmr/patient-medicine-history/<?php echo $each['patient_id'];?>/<?php echo $each['medicine_id'];?>/C<?php echo ($is_online && $is_online == 1) ? '/1' : '' ; ?>" id="preview"> <?php echo $each['p_medicine_name']; ?> </a>
                                                    </td>
                                                    <td><?php echo filter_string($each['p_medicine_form']); ?></td>
                                                    <td><?php echo filter_string($each['p_strength_name']); ?></td>
                                                    <td><?php echo filter_string($each['quantity']); ?></td>
                                                    <td><?php echo filter_string($each['p_suggested_dose']); ?></td>
                                                    <td><?php echo filter_string($each['order_type']).' '.filter_string($each['medicine_class']); ?></td>
                                                    <td><?php echo filter_string($each['prescribed_by_name']); ?></td>
                                                    <td><?php echo kod_date_format(filter_string($each['created_date']));?>
                                                    </td>
                                                    <?php if(!$is_online && $order_status != 'DS' && $free_type == 1 && $vaccine_type == ''){ ?>
                                                        <td>
                                                            <button class="btn btn-xs btn-primary" title="Repeat Medicine" onclick="select_medicine(<?php echo $each['quantity']; ?>, '<?php echo $each['medicine_class']; ?>', '<?php echo $each['strength_id']; ?>', '<?php echo $each['medicine_id']; ?>', '<?php echo $each['medicine_name']; ?>', '<?php echo $each['strength']; ?>', '<?php echo $each['medicine_form']; ?>', '<?php echo $each['suggested_dose']; ?>')" ><i class="fa fa-repeat"></i></button>
                                                        </td>
                                                    <?php } // end if(!$is_online && $order_status != 'DS') ?>
                                                </tr>
                                    <?php
                                            } // foreach($patient_history as $each)
											*/
                                            
                                        } else { // if($patient_history)
                                    ?>
                                            <tr><td colspan="9"><span class="text-danger">No record found.</span></td></tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>

                    </div>
                    <div id="vaccine_history_tab" class="tab-pane">
                    	<br />
                        <!-- Patient Vaccine Historyc -->
                        <div class="row" id="grouped-medicine-div">
                            <div class="col-md-12">
                                <?php if(!empty($patient_history)) { $DataTableId = "viewalpatienthistory";} else { $DataTableId; }?>
                             
                                <table id="<?php echo $DataTableId; ?>" class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
                                
                                    <thead>
                                    
                                        <tr>
                                            <th class="text-center">Vaccine Name</th>
                                            <th class="text-center">Brand</th>
                                            <th class="text-center">Last Vaccinated Date</th>
                                            <th class="text-center">Vaccinated By</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    <?php
                                        if($patient_vaccine_history){ 
                                            foreach($patient_vaccine_history as $each){
                                    ?>
                                                <tr>
                                                    <td>
                                    
                                                        <a class="fancybox_course fancybox.ajax" href="<?php echo base_url(); ?>pmr/patient-vaccine-history/<?php echo filter_string($each['patient_id']);?>/<?php echo filter_string($each['vaccine_cat_id']);?>"> <?php echo filter_string($each['vaccine_name']); ?> </a>
                                                    </td>
                                                    <td><?php echo filter_string($each['brand_name']); ?></td>
                                                    <td><?php echo kod_date_format(filter_string($each['recent_vaccinated_on']));?></td>
                                                    <td><?php echo filter_string($each['vaccinated_by']);?></td>
                                                    
                                                </tr>
                                    <?php
                                            } // foreach($patient_history as $each)
                                            
                                        } else { // if($patient_history)
                                    ?>
                                            <tr><td colspan="9"><span class="text-danger">No record found.</span></td></tr>
                                    <?php
                                        }
                                    ?>
                                    
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            

	    </div>
    </div>

    
	<!-- End - Screen 3 - PMR - Free Type -->
	<form id="searialized-prescription-form" method="post" action="<?php echo base_url(); ?>pmr/save-prescription" >
		<input type="hidden" name="prescription-preview-form-searialized-data" id="prescription-preview-form-searialized-data" />
		<input type="hidden" name="action" id="action" value="" />
	</form>
	<input type="hidden" name="medicine-counter" id="medicine-counter" value="0" readonly="readonly" />
	
<?php 
	} // End - else -> if($patient_in_other_ps) 
?>

<div id="vaccine-list"></div>

<script>
$(window).load(function(){

	$('#select-raf').trigger("change");
	$('#select-raf').trigger("click");

});

</script>