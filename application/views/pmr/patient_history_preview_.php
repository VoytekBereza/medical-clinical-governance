<!-- ./ start preview -->
<div id="preview-div">

	<div class="container" style="width: 800px;" >
	<div class="row bg-success" id="prescription_print_area">

		<div class="col-sm-12 col-md-12 col-lg-12">
			
			<br /> <br />
			
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					
					<div class="col-sm-6 col-md-6 col-lg-6">
						<strong class="text-success pull-left"><?php echo filter_string($prescriber_full_name); ?></strong>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<strong class="text-success pull-right">Private Prescription</strong>
					</div>
					
				</div>
			</div> <!-- ./row -->
			
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="col-sm-6 col-md-6 col-lg-6">
						<?php echo filter_string($registration_type); ?> Number : <?php echo filter_string($registration_number); ?>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<span class="pull-right"><?php echo kod_date_format(date('Y/m/d H:i:s')); ?></span>
					</div>
					
				</div>
			</div> <!-- ./row -->
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					
					<div class="col-sm-6 col-md-6 col-lg-6">
						<?php echo filter_string($pharmacy_surgery_details['pharmacy_surgery_name']).', '.filter_string($pharmacy_surgery_details['address']).' '.filter_string($pharmacy_surgery_details['postcode']) ; ?>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<span class="pull-right"><?php echo date('G:i'); ?></span>
					</div>
					
				</div>
			</div> <!-- ./row -->
			<br />
			
				<div class="col-sm-12 col-md-12 col-lg-12" >
					
					<div class="col-md-5" style="background:#ffffff !important;">
						
						<br /> 
						<strong class="text-success">Patient Details: </strong>
						
						<br />
						Name: <?php echo filter_string($patient_details['first_name']).' '.filter_string($patient_details['last_name']); ?>
						
						<br />
						Address: <?php echo filter_string($patient_details['address']).', '.filter_string($patient_details['postcode']); ?>
						<br /><br />
					</div>
                    <div class="col-md-3" style="background:#ffffff !important;">
                    	<br /><br />
	                    <span class="pull-right"> D.O.B: <?php echo date("d/m/Y", strtotime(filter_string($patient_details['dob']))); ?> </span>
                        <br />
                        <span class="pull-right"> Gender: <?php echo (filter_string($patient_details['gender']) == 'M') ? 'Male' : 'Female'; ?> </span>
                    	<br /><br />
                    </div>
	                
	                <div class="col-md-4" style="background:#ffffff !important; height:93px; border-left: 15px solid #dff0d8;">	
	                	<img src="<?php echo IMAGES?>logo.jpg" width="151" height="50" style="margin: 21px 0 0 -2px !important" />
	                </div>
	                
				</div>
	        
	        <div class="row">
				<br />
	            <div class="col-md-12">
	                <div class="col-md-12" style="background:#ffffff !important;">
	                <br />
	                    <strong class="text-success">Medication Details</strong>

						<?php if(count($medication_details['transaction']) > 0){ ?>
						
							<?php foreach($medication_details['transaction']['medicine_id'] as $index => $value){ ?>
								
								<p style="padding-top:20px">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $medication_details['transaction']['medicine_full_name'][$index]; ?> <br />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $medication_details['transaction']['strength'][$index]; ?> <br />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $medication_details['transaction']['medicine_form'][$index]; ?> <br />
									<?php if($medication_details['transaction']['suggested_dose'][$index]){ ?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $medication_details['transaction']['suggested_dose'][$index]; ?> <br />
									<?php } // $medication_details['transaction']['suggested_dose'][$index] ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $medication_details['transaction']['qty'][$index]; ?>
								</p>
							
							<?php } // foreach($medication_details['transaction']['medicine_id'] as $each) ?>
							
						<?php } // if($medication_details)  ?>
						
	                </div>
	            </div>
	       	</div> <!-- ./row -->
	        <div class="row">
	            <div class="col-md-12">
	            	
	            	<div class="col-md-6" style="background:#ffffff !important; min-height: 180px;">
	                	<br />
	                    <p>
	                    	<strong class="text-success">Prescriber's Signatures</strong>
	                        <br />
<?php
							if(filter_string($user_signatures['signature_type']) == 'svn')
								echo filter_string($user_signatures['signature']);
							else
								echo "<img src='".filter_string($user_signatures['signature'])."' width='200px' />";
?>
	                    </p>    
	                </div>
					
	                <div class="col-md-6" style="background:#ffffff !important; min-height: 180px;" >
						<br />
	                	<p class="pull-right">
	                        <strong class="text-success">Prescriber Details</strong>
	                        <br /> <br />
							<?php echo filter_string($registration_type); ?> Number : <?php echo filter_string($registration_number); ?>
	                        <br />
							<?php echo filter_string($pharmacy_surgery_details['pharmacy_surgery_name']).', '.filter_string($pharmacy_surgery_details['address']).' '.filter_string($pharmacy_surgery_details['postcode']) ; ?>
							
	                    </p>
	                </div>
					
	            </div>    
			</div> <!-- ./row -->
			<br />
		</div>	
	</div>
	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			
			<?php if($show_tracking_code == ''){ ?>

				<span class="pull-right">
					<?php if($show_decline && $show_decline == 1){ ?>
						<button class="btn btn-sm btn-danger" onClick=" $('#preview-div').hide(); $('#decline-div').show(); "> Decline </button>
					<?php } // if($show_decline && $show_decline == 1) ?>
					<button class="btn btn-sm btn-danger" onClick="parent.$.fancybox.close();"> Go Back </button>
					<button class="btn btn-sm btn-info" onClick="save_print('print');"> Print </button>
					
					<?php 
					if($view_current_delivery == ''){
						
						if($show_decline && $show_decline == 1){ ?>
							<button class="btn btn-sm btn-warning" onClick="save_print('save-approve');"> Save </button>
						<?php } else { ?>
							<button class="btn btn-sm btn-warning" onClick="save_print('save');"> Save </button>
						<?php } // if($show_decline && $show_decline == 1) ?>
						
						<button class="btn btn-sm btn-success" onClick="save_print('save_print');"> Save & Print </button>
					<?php } // if($view_current_delivery == '') ?>

				</span>

			<?php } else if($show_tracking_code == 1){ ?>

				<div align="right">

					<strong>Enter tracking code: </strong>
					<input type="text" class="input-sm" id="tracking_code" name="tracking_code" />

					<button class="btn btn-sm btn-success" onClick="complete_transaction(<?php echo $order_detail_id; ?>);"> Complete </button>
					<!-- <button class="btn btn-sm btn-info" onClick="download_rx(< ?php echo $order_detail_id; ?>);"> Download Rx </button> -->
					<a href="<?php echo base_url('pmr/download-rx/'.$order_detail_id); ?>" class="btn btn-sm btn-info"> Download Rx </a>

				</div>

			<?php } // if($show_tracking_code == '') ?>

		</div>
	</div>
	</div>
	<br />

</div> <!-- ./ end preview -->

<!-- ./ start - Decline Div -->
<div id="decline-div" style="display: none;" >

	<h4>Enter the reason for declining.</h4>
	<textarea class="form-control" id="decline_patient_transaction"></textarea>

	<br />
	<div align="right">
		<button class="btn btn-sm btn-success" onClick="decline_patient_transaction(<?php echo $order_detail_id; ?>);"> Send </button>
		<button class="btn btn-sm btn-danger" onClick=" $('#preview-div').show(); $('#decline-div').hide(); "> Back </button>
	</div>

</div> <!-- ./ end - Decline Div -->
<input type="hidden" name="order_detail_id_hidden" id="order_detail_id" value="<?php echo $order_detail_id; ?>" />