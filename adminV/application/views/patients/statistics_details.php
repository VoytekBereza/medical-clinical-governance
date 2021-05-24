<!-- ./ start preview -->
<div id="preview-div">

	<div class="container" style="width: 800px;" >
        <div id="prescription_print_area">
            <table align="center" cellpadding="10" cellspacing="10" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#DFF0D8">
                  <tbody>
                    <tr>
                      <td style="padding:10px"><br />
                        <br />
                        <p style="color:#3c763d"><strong><?php echo filter_string($order_details['p_prescriber_name']); ?></strong></p>
                        <p><strong><?php echo filter_string($registration_type); ?> Number:</strong> <?php echo filter_string($order_details['p_prescriber_reg_no']); ?><br />
                          <?php //echo filter_string($pharmacy_surgery_details['pharmacy_surgery_name']).', '.filter_string($pharmacy_surgery_details['address']).' '.filter_string($pharmacy_surgery_details['postcode']) ; ?>
                         <?php echo filter_string($order_details['p_organization_address']); ?>
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
                                <p><strong>Name: </strong> <?php echo filter_string($order_details['p_patient_name']); ?><br />
                                  <strong>Address: </strong><?php echo filter_string($order_details['p_patient_address']); ?></p></td>
                              <td><strong>D.O.B: </strong> <?php echo date("d/m/Y", strtotime(filter_string($order_details['p_patient_dob']))); ?><br>
                                <strong>Gender: </strong><?php echo (filter_string($order_details['p_gender']) == 'M') ? 'Male' : 'Female'; ?> 
                              </td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td style="padding:10px"><table cellpadding="15" cellspacing="15" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#fff; height:90px" >
                          <tbody>
                            <tr>
                              <td align="center"><img height="50" src="<?php echo IMAGES?>askthedoctor.png" width="200" /></td>
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
                                <?php if(count($medication_details['transaction']) > 0){ 
                                         foreach($medication_details['transaction']['medicine_id'] as $index => $value){ 
                                ?>
                                        
                                        <p style="padding-top:20px">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['p_medicine_short_name']); ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['p_strength_name']); ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['p_medicine_form']); ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo ($order_details['p_suggested_dose']) ? filter_string($order_details['p_suggested_dose']) : ''; ?> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo filter_string($order_details['quantity']); ?>

                                        </p>
                                    
                                    <?php 
                                        } // foreach($medication_details['transaction']['medicine_id'] as $each) 
                                     } // if($medication_details)  
                                ?>
                                
                                </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="padding:10px"><br /></td>
                            </tr>
                            <tr>
                              <td style="padding:10px"><p style="color:#3c763d"><strong>Prescriber's Signatures</strong></p>
                              <td style="padding:10px"><p style="color:#3c763d"><strong>Prescriber Details</strong></p>
                             </tr>
                             <tr><td>
                                <p>
                                <?php
                                    if(filter_string($user_signatures['signature_type']) == 'svn')
                                        echo filter_string($user_signatures['signature']);
                                    else
                                        echo "<img src='".filter_string($user_signatures['signature'])."' width='200px' />";
                                ?>
                                
                                </p></td>
                              <td  style="padding:10px">
                                <p>
                                	<strong><?php echo filter_string($registration_type); ?> Number:</strong> <?php echo filter_string($order_details['p_prescriber_reg_no']); ?><br />
                                    <strong>Email address:</strong> <?php echo filter_string($order_details['p_prescriber_email']); ?><br />
                                 	<?php echo filter_string($order_details['p_organization_address']); ?>
                                 </p></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
        </table>	
        </div>
	<br />

		<div class="col-sm-12 col-md-12 col-lg-12">
			
			<?php if($show_tracking_code == ''){ ?>

				<span class="pull-right">
					<button class="btn btn-sm btn-info" onClick="save_print('print');"> Print </button>
				</span>

			<?php }?>
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