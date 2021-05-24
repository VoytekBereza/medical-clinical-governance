<!-- ./ start preview -->
<div id="preview-div">

	<div class="container" style="width: 800px;" >
        <div id="prescription_print_area">
            <table align="center" cellpadding="10" cellspacing="10" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#DFF0D8">
                  <tbody>
                    <tr>
                      <td style="padding:10px"><br />
                        <br />
                        <p style="color:#3c763d"><strong><?php echo filter_name($default_prescriber['first_name'].' '.$default_prescriber['last_name']); ?></strong></p>
                        <p>
                        	<strong><?php echo filter_string($default_prescriber['reg_type']); ?> Number:</strong> <?php echo filter_string($default_prescriber['reg_no']); ?><br />
							<?php 
								$presc_address = filter_string($default_prescriber['organization_name']).', ';
								$presc_address .= filter_string($default_prescriber['address_1']);
								$presc_address .= ($default_prescriber['address_2']) ? ', '.filter_string($default_prescriber['address_2']) : '';
								$presc_address .= ($default_prescriber['address_3']) ? ', '.filter_string($default_prescriber['address_3']) : '';
								$presc_address .= ($default_prescriber['town']) ? ', '.filter_string($default_prescriber['town']) : '';
								$presc_address .= ($default_prescriber['county']) ? ', '.filter_string($default_prescriber['county']) : '';
								$presc_address .= ', '.filter_string($default_prescriber['postcode']);
								
								echo $presc_address;
							?> 
                          </p></td>
                      <td align="right" style="padding:10px">
                        <br />
                        <p style="color:#3c763d"> <strong>Private Prescription</strong></p>
                        <p><?php echo kod_date_format(date('Y/m/d H:i:s')); ?><br />
                          <?php echo date('G:i'); ?></p></td>
                    </tr>
                    <tr>
                      <td style="padding:10px"><table cellpadding="15" cellspacing="15" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#fff;" >
                          <tbody>
                            <tr>
                              <td style="padding:10px"><p style="color:#3c763d"><strong>Patient Details: </strong></p>
                                <p><strong>Name: </strong> <?php echo ucwords($order_details['p_patient_name']); ?><br />
                                  <strong>Address: </strong><?php echo filter_string($order_details['p_patient_address']); ?></p></td>
                              <td><strong>D.O.B: </strong> <?php echo date("d/m/Y", strtotime(filter_string($order_details['p_patient_dob']))); ?><br>
                                <strong>Gender: </strong><?php echo (filter_string($order_details['p_patient_gender']) == 'M') ? 'Male' : 'Female'; ?> 
                              </td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td style="padding:10px"><table cellpadding="15" cellspacing="15" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#fff; height:90px" >
                          <tbody>
                            <tr>
                              <td align="center"><img src="<?php echo FRONT_SURL?>assets/prescriber_files/<?php echo filter_string($default_prescriber['stamp_file'])?>" width="205"  style="padding:10px;" /><!-- <img  src="< ?php echo IMAGES?>askthedoctor.png" width="250"  />--></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="padding:10px"><table cellpadding="15" cellspacing="15" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#fff" width="100%">
                          <tbody>
                            <tr>
                              <td colspan="2" style="padding:10px"><p style="color:#3c763d"><strong>Medication Details</strong></p>
                                <p>          
                                        
                                        <p style="padding-top:20px">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['p_medicine_short_name']); ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['p_strength_name']); ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['p_medicine_form']); ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo ($order_details['p_suggested_dose']) ? filter_string($order_details['p_suggested_dose']) : ''; ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['quantity']); ?>
                                        </p>
                                
                                </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="padding:10px"><br /></td>
                            </tr>
                            <tr>
                              <td style="padding:10px"><p style="color:#3c763d"><strong>Prescriber's Signature</strong></p>
                              <td style="padding:10px"><p style="color:#3c763d"><strong>Prescriber Details</strong></p>
                             </tr>
                             <tr>
                             	<td style="padding:10px">
                                <p>
                                <?php
									/*
                                    if(filter_string($user_signatures['signature_type']) == 'svn')
                                        echo filter_string($user_signatures['signature']);
                                    else if(filter_string($user_signatures['signature_type']) == 'image')
                                        echo "<img src='".filter_string($user_signatures['signature'])."' width='200px' />";
									*/
                                ?>
                                <img src="<?php echo FRONT_SURL ?>assets/prescriber_files/<?php echo filter_string($default_prescriber['signature_file'])?>" width='200px' />
                                
                                </p>
                              </td>
                              <td style="padding: 5px 10px" valign="top">
                                <p>
                                    <strong><?php echo filter_string($default_prescriber['reg_type']) ?> Number:</strong> <?php echo filter_string($default_prescriber['reg_no']) ?>
                                    <br />
                                    <strong>Email address:</strong> <?php echo filter_string($default_prescriber['email_address']) ?><br />
                                    <?php echo $presc_address ?>
                                 </p>
                                 </td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
        </table>	
        </div>
	<br />

		<div class="col-sm-12 col-md-12 col-lg-12">
			
			<?php 
				if(filter_string($default_prescriber['signature_file']) == ''){
			?>
            	<p class="alert alert-danger">Signatures are missing for the selected prescriber</p>
            <?php		
				}else{
					if($show_tracking_code == ''){ 
				?>
	
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
	
				<?php } // if($show_tracking_code == '') 
				}//end if(filter_string($user_signatures['signature_type']) == '')
			?>

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
<input type="hidden" name="root_order_id" id="root_order_id" value="<?php echo $root_order_id; ?>" readonly="readonly" />

