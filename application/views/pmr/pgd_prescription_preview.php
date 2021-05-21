<?php $index = 0; ?>
<div id="pgd_prescriptiption_table">
	<table cellpadding="2" cellspacing="2" width="100%" style="font-size:13px; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#333">
		<tr>
	    	<td width="50%">
	        	<table cellpadding="2" cellspacing="2" width="99%" style="font-size:13px; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#333">
	            	<tr><td colspan="2" bgcolor="#D9EDF7" style="padding:10px;"><strong style="font-size:16px">PATIENT</strong></td></tr>
	                <tr>
	                	<td style="padding:10px;" valign="top" width="60%">
	                    	<strong>Firstname: </strong> <?php echo (filter_string($patient_details['first_name'])) ? ucwords(filter_string($patient_details['first_name'])) : '' ; ?> <br />
	                        <strong>Surname: </strong> <?php echo (filter_string($patient_details['last_name'])) ? ucwords(filter_string($patient_details['last_name'])) : '' ; ?> <br />
	                        <strong>Address:</strong> <?php echo (filter_string($patient_details['address'])) ? ucwords(filter_string($patient_details['address'])) : '' ; echo (filter_string($patient_details['address_2'])) ? ', '.ucwords(filter_string($patient_details['address_2'])) : '' ; echo (filter_string($patient_details['address_3'])) ? ', '.ucwords(filter_string($patient_details['address_3'])) : '' ; ?> <br />
	                        <strong>Postcode:</strong> <?php echo (filter_string($patient_details['postcode'])) ? ucwords(filter_string($patient_details['postcode'])) : '' ; ?> <br />
	                	</td>
	                	<td style="padding:10px;" valign="top" width="40%"><br /></td>
	                 </tr>
	            </table>
	        </td>
	        <td width="50%">
	        	<table cellpadding="2" cellspacing="2" width="99%" style="font-size:13px; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#333">
	            	<tr><td bgcolor="#D9EDF7" style="padding:10px;" colspan="2"><strong style="font-size:16px">MEDICINE</strong></td></tr>
	                <tr>
	                	<td style="padding:10px;" width="60%">
	                    	<?php echo filter_string( $medication_details['transaction']['medicine_full_name'][$index] ); ?><br />
	                        <?php echo filter_string( $medication_details['transaction']['medicine_class'][$index] ).''.filter_string( $medication_details['transaction']['strength'][$index] ); ?> <br />
	                        <?php echo filter_string( $medication_details['transaction']['suggested_dose'][$index] ); ?> <br />
	                        <?php echo filter_string( $medication_details['transaction']['qty'][$index] ); ?> <?php echo filter_string( $medication_details['transaction']['medicine_form'][$index] ); ?>
	                	</td>
	                    <td style="padding:10px;" valign="top" width="40%">
	                    	<strong> Supplied By:</strong> <br /> <?php echo (filter_string($order_details['supplied_by_user'])) ? ucwords(filter_string($order_details['supplied_by_user'])) : '' ; ?> on <?php echo (filter_string($order_details['created_date'])) ? kod_date_format(filter_string($order_details['created_date']),true) : '' ; ?></p>
	                    </td>
	                    
	                 </tr>
	            </table>
	        </td>
	    </tr>
	    <tr><td colspan="2" style="border-top:solid 1px #D9EDF7">&nbsp;</td></tr>
	    <tr>
	    	<td colspan="2">
	        	<table cellpadding="2" cellspacing="2" width="100%" style="font-size:13px; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#333">
	            	<tr><td colspan="2" bgcolor="#D9EDF7" style="padding:10px;"><strong style="font-size:16px">RISK ASSESMENT FORM</strong></td></tr>
	                <!-- Start => Question row -->
	<?php		
					if($raf_data){
						foreach($raf_data as $label => $questions){
							foreach($questions as $question){
	?>
				                <tr>
				                	<td style="padding:10px;" width="80%">
			                    		<!-- Question -->
			                    		<?php echo filter_string($question['question']); ?>
				                    </td>
				                    <td>
				                    	<!-- Answer -->
				                    	<strong style="padding:10px; border: solid 1px #31708F; background-color:#31708F; color:#FFF">
	<?php
											if($filled_raf){
						                    	$index_key = array_search(filter_string($question['id']), array_column($filled_raf, 'raf_id'));
						                    } // if($filled_raf)

						                    if(is_numeric($index_key) && $filled_raf[$index_key]['answer'] == 'Y'){ 
						                    	echo 'YES';
						                   	} else {
						                   		echo 'NO';
						                   	} // if(is_numeric($index_key) && $filled_raf[$index_key]['answer'] == 'Y')
	?>
				                    	</strong>
				                    </td>
				                </tr>
				                <tr><td colspan="2" style="border-top:solid 1px #D9EDF7">&nbsp;</td></tr>
	<?php
							} // foreach($questions as $question)

						} // foreach($raf_data as $label => $questions)

					} // if($raf_data)
	?>
	                <!-- End => row -->
	            </table>
	        </td>
	    </tr>
	</table>
</div>
<div class="row" style="margin: 0; padding: 0;">
	<div class="col-md-12 text-right">
    	<button onclick="parent.$.fancybox.close();" class="btn btn-sm btn-danger"> Go Back </button>
		<button class="btn btn-md btn-info" onClick="print_pgd_prescription();" > Print </button>
	</div>
</div>
