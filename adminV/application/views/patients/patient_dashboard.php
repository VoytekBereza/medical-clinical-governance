<!-- Style for suggesstionbox -->
<style>
	.medicine_suggessions li.selected {
	    background-color: #FFF;
	}
</style>

<div id="overlay_addtobasket" class="overlay hidden">
	<div class="col-md-12 text-center" style="margin-top:150px;"></div>
</div>

<!-- <input class="form-control filterme"  /> -->
<?php 

// Get organization id and pharamacy id from url
 $organization_id = $this->uri->segment(5);
 $pharmacy_surgery_id = $this->uri->segment(6);


if($this->uri->segment(3)){ ?>
	<input type="hidden" name="pmr_patient_id" id="pmr_patient_id" value="<?php echo $this->uri->segment(3); ?>" />
<?php } // if($this->uri->segment(3))
	
	if($this->session->flashdata('err_message')){
?>

<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
<?php
	}//end if($this->session->flashdata('err_message'))
	
	if($this->session->flashdata('ok_message')){
?>
<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php 
	}//if($this->session->flashdata('ok_message'))
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> 
	<div class="row">
    
<?php 

   if($patient_in_other_ps){
	
	// Show Merge History popup
?>


		<div class="col-sm-1 col-md-1 col-lg-1"></div>
		<div class="col-sm-10 col-md-10 col-lg-10">			
			<div class="well">
				<strong>Important! </strong> 
				<br /> <br />
				<p>
					There is no record found for the selected Patient in this Pharmacy. However, system have found multiple history in other pharmacies. 
				</p>
				
				<ul>
<?php
					if($patient_in_other_ps){
						
						foreach($patient_in_other_ps as $each){
?>
							<li> <?php echo filter_string($each['pharmacy_surgery_name']); ?> </li>
<?php
						} // foreach($patient_in_other_ps as $each)
						
					} // if($patient_in_other_ps) 
?>
				</ul>
				
				<p>In order to proceed, system need to merge the patient record with the selected Pharmacy.</p>
				
				<a href="<?php echo base_url(); ?>patient/merge-patient-with-pharmacy/<?php echo urlencode(base64_encode($patient_data['id'])); ?>" class="btn btn-sm btn-success" > MERGE History </a> <a href="<?php echo base_url(); ?>patient" class="btn btn-sm btn-danger">DO Not MERGE</a>
				
			</div>
		</div>
		<div class="col-sm-1 col-md-1 col-lg-1"></div>
	</div>
<?php
	} else {
	// Show Patient Dashboard
?>
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<h3>
				Patient History
            <div class="row">	<hr></div>
				<?php
				
				if($is_online && $is_online == 1 && $vaccine_type == ''){
					echo ''; //'PMR Online'; 
				} else if($order_status == 'DS'){ 
					echo ''; //'Dispense'; 
				} else if($free_type == 1){ 
					echo ''; //'PMR Free Type'; 
				} else if($vaccine_type){
					echo ''; //($vaccine_type == 2) ? 'Travel Vaccine' : 'Flu Vaccine' ;
				} else { 
					//echo "Walkin PGDs"; 
					$walkin_pgd = 1;
				} // if($is_online && $is_online == 1 && $vaccine_type == '')
				
				?>
			</h3>

		</div>
	</div>

	<div class="row">
    	
		<div class="col-sm-4 col-md-4 col-lg-4">
			
			<strong class="text-primary"> <?php echo filter_string($patient_data['first_name']).' '.filter_string($patient_data['last_name']);?> </strong>
			<br /> <br />
            <p><i class="glyphicon glyphicon-map-marker"></i> <?php echo filter_string($patient_data['address']).', '.filter_string($patient_data['postcode']); ?></p>
            <p><i class="glyphicon glyphicon-envelope"></i> <?php echo filter_string($patient_data['email_address']); ?></p>
            
            <br />
            <p><strong>GP Name and address:</strong><br />

				<?php 
					if(filter_string($patient_data['gp_firstname']) != ''){
						
						echo filter_string($patient_data['gp_firstname']).' '.filter_string($patient_data['lastname']).'<br />';
						echo filter_string($patient_data['gp_address']).' '.filter_string($patient_data['gp_address2']).' '.filter_string($patient_data['gp_address3']).'<br>';
						echo filter_string($patient_data['gp_postcode']).', '.filter_string($patient_data['country_name']);
					}else
						echo 'N/a';
					//end if(filter_string($patient_data['gp_firstname']))
				?>
            </p>
		</div>
        <div class="col-sm-4 col-md-4 col-lg-4">
        	<br /><br />
        	<p><i class="glyphicon glyphicon-phone"></i> <?php echo filter_string($patient_data['mobile_no']); ?></p>
			<p><i class="glyphicon glyphicon-calendar"></i> DOB: <?php echo kod_date_format(filter_string($patient_data['dob'])); ?></p>			
            <p><i class="glyphicon glyphicon-user"></i> <?php echo (filter_string($patient_data['gender']) == 'M') ? 'Male' : 'Female'; ?></p>
        </div>
        
		<div class="col-sm-4 col-md-4 col-lg-4">
			
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Allergies</strong>
					<textarea class="form-control" id="input-allergies" rel="<?php echo $patient_data['id']; ?>" cols="27" rows="5" style="font-size:12px"><?php echo str_replace('<br />', '', filter_string($patient_data['allergies'])); ?></textarea>
					<i>Note: Data will be saved immediately</i>
				</div>
			</div>
			
		</div>
	</div>


	<!-- Start - Patient Pending Transactions -->
	<?php 
		if($vaccine_type == ''){ 
	?>
		<h4> Current Transactions </h4>
		<div class="panel panel-warning panel-body">
	<?php
			if( $patient_pending_transactions ){

				foreach( $patient_pending_transactions as $transaction ){
					
					if($transaction['order_status'] == 'P'){
					
	?>
					<div class="row">

						<div class="col-sm-3 col-md-3 col-lg-3 text-center"> <strong> <?php echo kod_date_format(filter_string($transaction['created_date']), true); ?> </strong></div> 
						<div class="col-sm-3 col-md-3 col-lg-3 text-center"> <strong> <?php echo (filter_string( $transaction['medicine_name'])) ? filter_string( $transaction['medicine_name']).' - '.filter_string($transaction['medicine_class']) : 'N/A' ; ?> </strong> </div>
						<div class="col-sm-2 col-md-2 col-lg-2 text-center"> <strong> <?php echo (filter_string( $transaction['strength'])) ? filter_string( $transaction['strength']) : 'N/A' ; ?> </strong> </strong> </div>
						<div class="col-sm-2 col-md-2 col-lg-1 text-right"> <strong> <?php echo (filter_string( $transaction['quantity'])) ? filter_string( $transaction['quantity']) : 'N/A' ; ?> </strong> </div>
						<div class="col-sm-3 col-md-3 col-lg-3 text-right">

							<a href="<?php echo base_url(); ?>patient/view-raf/<?php echo filter_string($transaction['patient_id']); ?>/<?php echo filter_string($transaction['product_type']); ?>/<?php echo (filter_string($transaction['medicine_id'])) ? filter_string($transaction['medicine_id']) : filter_string($transaction['vaccine_id']) ; ?>" class="btn btn-xxs btn-info fancybox_view fancybox.ajax" >
	                        	RAF
	                    	</a>

							<a class="btn btn-xxs btn-success preview" data-fancybox-type="ajax" href="<?php echo base_url(); ?>patient/preview-current-transaction/<?php echo  $organization_id;?>/<?php echo $pharmacy_surgery_id;?>" id="preview" rel="<?php echo $transaction['id']; ?>" > <?php echo (filter_string($transaction['medicine_class']) == 'Rx') ? 'Process' : 'Convert' ; ?> </a>

						</div>

						<!-- Hidden forms containing data to show on preview > -->
						<div class="col-md-12 hidden">

							<form id="prescription-preview-form-<?php echo $transaction['id']; ?>" method="post">
								
								<!-- Patient id - hidden field -->
								<input type="hidden" name="patient_id" value="<?php echo filter_string($transaction['patient_id']); ?>" readonly="readonly"/>
								<input type="hidden" name="approve-transaction" value="1" readonly="readonly"/>
								<input type="hidden" name="order-detail-id" value="<?php echo filter_string($transaction['id']); ?>" readonly="readonly"/>
                                <input type="hidden" name="root_order_id" value="<?php echo $root_order_id; ?>" readonly="readonly"/>
								
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
	<?php 		
					}
				} // foreach( $patient_pending_transactions as $transaction ) 
				
		}else{
	?>
    	<div class="text-danger"><strong>No pending transaction found.</strong></div>
    <?php		
		}// if( $patient_pending_transactions ) 
	?>

		</div>

	<?php } // end if(!$is_online) ?>

	<!-- End - Patient Pending Transactions  -->

	<?php if(!$is_online && $order_status != 'DS' && $free_type == 1 && $vaccine_type == ''){ ?>

		<h4> Current Transaction </h4>
		<div class="panel panel-default panel-body">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<input type="text" class="form-control search-medicine" id="search-medicine" value="" placeholder="To add a new medicine to the prescription, type here." />
				</div>
			</div>

			<br />
			<!-- Start - Current transactions form -->
			<!-- <form action="<?php echo base_url(); ?>pmr/preview-current-transaction" method="post"> -->
			<form id="prescription-preview-form" method="post">
				
				<span id="current-transaction-row"></span>
				
				<!-- Patient id - hidden field -->
				<input type="hidden" name="patient_id" value="<?php echo filter_string($patient_data['id']); ?>" />
				
				<div class="row" id="preview-btn-div">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<p class="text-danger text-center">Please select the medicine.</p>
						<a class="btn btn-sm btn-success pull-right preview hidden" data-fancybox-type="ajax" href="<?php echo base_url(); ?>patient/preview-current-transaction" id="preview">Preview</a>
					</div>
				</div>
				
			</form>
			<!-- End - Current transactions form -->
			
		</div>

	<?php } // if(!$is_online && $order_status != 'DS') ?>


	<!-- Pending Transactions -->
	<div class="row" id="grouped-medicine-div">
		<div class="col-md-12">
			
			<div class="panel panel-success">
			<div class="panel-heading"><strong>Patient Medicine History</strong></div>
            <div class="panel-body">
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
						if($patient_history){ //print_this($patient_history);
							foreach($patient_history as $each){
?>
								<tr>
									<td>
										<a class="medicine-details-popup" onClick="" data-fancybox-type="ajax" href="<?php echo base_url(); ?>patient/patient-medicine-history/<?php echo $each['patient_id'];?>/<?php echo $each['medicine_id'];?>/C<?php echo ($is_online && $is_online == 1) ? '/1' : '' ; ?>" id="preview"> <?php echo $each['medicine_name']; ?> </a>
									</td>
									<td><?php echo filter_string($each['medicine_form']); ?></td>
									<td><?php echo filter_string($each['strength']); ?></td>
									<td><?php echo filter_string($each['quantity']); ?></td>
									<td><?php echo filter_string($each['suggested_dose']); ?></td>
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
							
						} else { // if($patient_history)
?>
							<tr><td colspan="9"><span class="text-danger">No record found.</span></td></tr>
<?php
						}
?>
					</tr>
				 
				</tbody>
				
			</table>
            </div>
			</div>
		
		</div>
	</div>
    
	<!-- End - Screen 3 - PMR - Free Type -->
	<form id="searialized-prescription-form" method="post" action="<?php echo base_url(); ?>patient/save-prescription" >
		<input type="hidden" name="prescription-preview-form-searialized-data" id="prescription-preview-form-searialized-data" />
		<input type="hidden" name="action" id="action" value="" />
        
        <input type="hidden" name="pmr_patient_id" id="pmr_patient_id" value="<?php echo $this->uri->segment(3); ?>" />
        <input type="hidden" name="organization_id" id="organization_id" value="<?php echo $this->uri->segment(5)?>" />
        <input type="hidden" name="pharmacy_surgery_id" id="pharmacy_surgery_id" value="<?php echo $this->uri->segment(6)?>" />
        
	</form>
	<input type="hidden" name="medicine-counter" id="medicine-counter" value="0" readonly="readonly" />
	
<?php 
	} // End - else -> if($patient_in_other_ps) 
?>

			</div>
		</div>
	</div>
</div>