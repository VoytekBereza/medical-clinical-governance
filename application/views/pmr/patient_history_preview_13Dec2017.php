<!-- ./ start preview -->
<div id="preview-div">

	<div class="container" style="width: 800px;" >
        <div id="prescription_print_area">
            <table align="center" cellpadding="10" cellspacing="10" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#DFF0D8">
              <tbody>
                <tr>
                  
                  <td style="padding:10px"><br />
                    <br />
                    <p style="color:#3c763d"><strong><?php echo ucwords(filter_string($order_details['p_prescriber_name'])); ?></strong></p>
                    <p><strong><?php echo filter_string($registration_type); ?> Number:</strong> <?php echo filter_string($order_details['p_prescriber_reg_no']); ?><br />
                     <?php echo ($order_details['default_prescriber']) ? filter_string($prescriber_organization['address']).', '.filter_string($prescriber_organization['postcode']) : filter_string($order_details['p_organization_address']); ?>
                    </p>
                  </td>
                  
                  <td align="right" style="padding:10px">
                    <br />
                    <p style="color:#3c763d"> <strong>Private Prescription</strong></p>
                    <p>
                      <?php
                        // Purchase Date => created_date
                        if($order_details['created_date'])
                          echo kod_date_format($order_details['created_date']);
                        else
                          echo kod_date_format(date('Y-m-d H:i:s'));
                        // if($order_details['created_date'])
                        ?>
                      
                      <?php
                      if($order_details['created_date'])
                        echo date('G:i', strtotime($order_details['created_date']));
                      else
                        echo date('G:i');
                      // $order_details['created_date']
                      ?>
                    </p>
                  </td>

                </tr>
                <tr>
                  <td style="padding:10px"><table cellpadding="15" cellspacing="15" style="font-family:arial,helvetica,sans-serif; font-size:12px; width:100%; background-color:#fff;" >
                      <tbody>
                        <tr>
                          <td style="padding:10px"><p style="color:#3c763d"><strong>Patient Details: </strong></p>
                            <p><strong>Name: </strong> <?php echo ucwords(filter_string($order_details['p_patient_name'])); ?><br />
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
                            <p>????????????????????
                                    
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
                          <td style="padding:10px"><p style="color:#3c763d"><strong>Prescriber's Signature</strong></p></td>
                          <td style="padding:10px"><p style="color:#3c763d"><strong>Prescriber Details</strong></p></td>
                         </tr>
                         
                         <tr>
                          
                          <td>
                            <p>

                              <div style="width:283px; padding:0; margin:0; height:116px; background-image:url(<?php echo IMAGES; ?>/bb.png); background-repeat:no-repeat;">

                                  <div style=" margin:0; padding:4px 0px 3px 36px;">

                                    <?php

                                    // -------------------------
                                    //        Date - Time
                                    // -------------------------
                                    
                                    // Purchase Date => created_date

                                    if($order_details['created_date']){
                                      
                                      $signed_date = date('m/d/Y', strtotime($order_details['created_date']));
                                      $signed_time = date('H:i', strtotime($order_details['created_date']));

                                    } else {

                                      $signed_date = kod_date_format(date('Y-m-d H:i:s'));
                                      $signed_time = date('H:i');

                                    } // if($order_details['created_date'])

                                    ?>

                                    <strong>Signed at <?php echo $signed_time; ?> ON <?php echo $signed_date; ?></strong>
                                  </div>
                                  <div style="margin:0px 0px 0px 20px; padding:0; min-height: 64px;">
                                    
                                    <?php
                                    if(filter_string($user_signatures['signature_type']) == 'svn'){
                                        echo filter_string($user_signatures['signature']);
                                    }else if(filter_string($user_signatures['signature_type']) == 'image'){
                                        echo "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
                                    } ?>

                                  </div>
                                  <div style="padding:0px 0px 0px 36px; margin:5px 0px 0px 0px; ">
                                    
                                    <strong> <?php echo $prescription_no = strtoupper(random_number_generator(16)); ?></strong>
                                    <input type="hidden" name="prescription_no_hidden" id="prescription_no_hidden" value="<?php echo $prescription_no; ?>" />

                                  </div>

                              </div>
                              
                            </p>
                          </td>
                          
                          <td  style="padding:10px">
                            <strong><?php echo ucwords(filter_string($order_details['p_prescriber_name'])); ?></strong>
                            <p>
                            	<strong><?php echo filter_string($registration_type); ?> Number:</strong> <?php echo filter_string($order_details['p_prescriber_reg_no']); ?><br />
                                <strong>Email address:</strong> <?php echo filter_string($order_details['p_prescriber_email']); ?><br />
                                <?php echo ($order_details['default_prescriber']) ? filter_string($prescriber_organization['address']).', '.filter_string($prescriber_organization['postcode']) : filter_string($order_details['p_organization_address']); ?>
                             </p>
                          		
                          </td>

                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
    </table>
             <!-- ./row -->
                <br />
            </div>	
	</div>

<?php
    if($patient_order_details_arr && $patient_order_details_arr['order_status'] == 'C' && $patient_order_details_arr['tracking_code'] != ''){
?>	
  <div class="col-md-12">
      <div class="text-center" style="border: 8px solid yellow; padding: 4px;">
        <h4>
          <strong>DELIVERY CODE: </strong>
          <?php echo (filter_string($patient_order_details_arr['tracking_code'])) ? filter_string($patient_order_details_arr['tracking_code']) : 'N/A' ; ?>
        </h4>
      </div>
  </div>
  
<?php
    } // if($patient_order_details_arr)
?>

		<div class="col-sm-12 col-md-12 col-lg-12">
			
      <?php if(!$user_signatures['signature_type']){ ?>
        <div class="alert alert-danger">To proceed with the prescription, you first must go to your <a href="<?php echo SURL; ?>dashboard/settings#sign_pane">Settings</a> and enter your signature.</div>
      <?php } // if(!$user_signatures['signature_type']) ?>

			<?php if($show_tracking_code == ''){ ?>

				<span class="pull-right">
					<?php if($show_decline && $show_decline == 1){ ?>
						<button class="btn btn-sm btn-danger" onClick=" $('#preview-div').hide(); $('#decline-div').show(); "> Decline </button>
					<?php } // if($show_decline && $show_decline == 1) ?>
          
					<button class="btn btn-sm btn-danger" onClick="parent.$.fancybox.close();"> Go Back </button>
					<?php if($user_signatures['signature_type']){ ?>
            <button class="btn btn-sm btn-info" onClick="save_print('print');"> Print </button>
          <?php } // if($user_signatures['signature_type']){ ?>
					
					<?php 
  				
          	if($view_current_delivery == ''){
  						
              if($user_signatures['signature_type']){

    						if($show_decline && $show_decline == 1){ ?>
    							<button class="btn btn-sm btn-warning" onClick="save_print('save-approve');"> Save </button>
    						<?php } else { ?>
    							<button class="btn btn-sm btn-warning" onClick="save_print('save');"> Save </button>
    						<?php } // if($show_decline && $show_decline == 1) ?>
    					
    						<button class="btn btn-sm btn-success" onClick="save_print('save_print');"> Save & Print </button>

            <?php } // $user_signatures

					} // if($view_current_delivery == '') ?>

				</span>

			<?php } else if($show_tracking_code == 1){ ?>

				<div align="right">

					<strong>Enter tracking code: </strong>
					<input type="text" class="input-sm" id="tracking_code" name="tracking_code" />

					<button class="btn btn-sm btn-success" onClick="complete_transaction(<?php echo $order_detail_id; ?>);"> Complete </button>
					<!-- <button class="btn btn-sm btn-info" onClick="download_rx(< ?php echo $order_detail_id; ?>);"> Download Rx </button> -->
					<a href="<?php echo base_url('pmr/download-rx/'.$order_detail_id); ?>" class="btn btn-sm btn-info"> Download Rx </a>
                    &nbsp;

				</div>

			<?php } // if($show_tracking_code == '') ?>

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