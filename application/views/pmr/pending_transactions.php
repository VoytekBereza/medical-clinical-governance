<!-- Start - Screen 1 - PMR -->
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>PMR</h3>
	</div>
</div>

<hr />
<br />

<!-- Patients Search -->
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4 validate_msg">
		<label for="is_default_doc">Search a patient:</label>
		<input type="text" autocomplete="off" placeholder="Search a patient" required="required" class="form-control search_patient" name="search_patient" id="search_patient" />
		<div id="result_patient"></div>
	</div>
</div>

<br />

<!-- Pending Transactions -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading">
				<strong>Pending Transactions</strong>
				
				<div class="pull-right"> 
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-sm btn-default" > Go Back </a>
				</div>

				<br /> <br />
			</div>
			<div class="panel-body">				
<?php 
				//print_this($organization_transactions);
				if($organization_transactions){

					foreach($organization_transactions as $pending_transaction){
?>
						<div class="row">
							<div class="col-sm-4 col-md-4 col-lg-4">

								<span class="text-success"><strong> <?php echo kod_date_format(filter_string($pending_transaction['created_date']), true); ?> </strong></span>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<span class="text-primary"><strong> <?php echo filter_string($pending_transaction['medicine_name']).' '.filter_string($pending_transaction['medicine_class']); ?> : </strong> <?php echo ucwords(filter_string($pending_transaction['patient_name'])); ?> </span>
							</div>
							<div class="col-sm-2 col-md-2 col-lg-2">

								<button class="btn btn-sm btn-success pull-right">
<?php 
									if($pending_transaction['medicine_class'] == 'Rx-PGD'){
										
										if($this->session->is_prescriber && $this->session->is_prescriber == 1)
											echo 'Convert';
										else
											echo 'Start';

									} elseif($pending_transaction['medicine_class'] == 'Rx') {

										if($pending_transaction['order_status'] == 'DS'){ // If Order Status is Dispense

											echo 'Dispense';

										} else {

											echo 'Start';

										} // if($pending_transaction['order_status'] == 'DS')

									} // $pending_transaction['medicine_class'] == 'Rx-PGD' 
?>
								</button>
							</div>
						</div> <!-- /.row -->
						<hr />

<?php					} //foreach($organization_transactions as $pending_transaction)

		 			} else {

?>
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 text-danger">
								No record found.
							</div>
						</div>
<?php		 				

		 			} // if($organization_transactions)

?>				
			</div> <!-- /.panel-body -->

		</div> <!-- /.panel -->
		
	</div> <!-- /.col -->

</div> <!-- /.row -->