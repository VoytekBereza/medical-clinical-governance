<?php if(!empty($transaction_list_ajax)){ $DataTableId ="orderdetails";} else { $DataTableId = '';}?>
                 No of Prescription = 0
                 <br />   <br />  
               <table id="<?php echo $DataTableId; ?>" class="table table-bordered table-hover table-prices">
                                    <thead>
                                        <tr>
                                           <th> Order date</th>
                                           <th> Pharmacy Name </th>
                                           <th> Patient Name </th>
                                           <th> Medicine Cost </th>
                                           <th> Delivery Cost </th>
                                          <!-- <th> Prescription Fee </th>-->
                                           <th> Pharmacy Percentage </th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-compare-tbody">
                                    <?php if(!empty($transaction_list_ajax)){
										
											   $total_medicine_cost = 0;
											   $total_shiping_cost = 0;	
											  // $total_prescription_fee = 0;
											   $total_prescription_pharmacy_percentage = 0;
											   
										       $total_record = count($transaction_list_ajax);
												foreach($transaction_list_ajax as $each) {
													
												 $medicine_cost =($each['subtotal'] - $each['prescription_fee']);
											     
												 $PRESCRIPTION_PHARMACY_PERCENTAGE = 'PRESCRIPTION_PHARMACY_PERCENTAGE';
												 $prescription_pharmacy_percentage = get_global_settings($PRESCRIPTION_PHARMACY_PERCENTAGE);
										     	 $prescription_pharmacy_percentage = filter_string($prescription_pharmacy_percentage['setting_value']);
												 
												 $percentage = (filter_string($each['prescription_fee']) / 100) * $prescription_pharmacy_percentage;
												 
												  $total_medicine_cost = $total_medicine_cost+$medicine_cost;
												  
												  $total_shiping_cost = $total_shiping_cost+filter_string($each['shipping_cost']);	
												  
												 // $total_prescription_fee = $total_prescription_fee+filter_string($each['prescription_fee']);
												  $total_prescription_pharmacy_percentage = $total_prescription_pharmacy_percentage+$percentage;
												 													
									?>
                                                <tr class="newRow">
                                                    <td> <?php echo kod_date_format(filter_string($each['created_date']), true); ?> </td>
                                                    <td> <?php echo filter_string($each['pharmacy_surgery_name']). '- '.filter_string($each['postcode']);?> </td>
                                                    <td> <?php echo filter_string($each['patient_name']);?> </td>
                                                     <td> <?php if($medicine_cost!="") {echo '&pound'.filter_string($medicine_cost);} else {  echo '&pound'."0.00";}?> </td>
                                                    
                                                    <td> <?php if($each['shipping_cost']!="") {echo '&pound'.filter_string($each['shipping_cost']);} else {  echo '&pound'."0.00";}?> </td>
                                                    <!--<td> <?php if($each['prescription_fee']!="") {echo '&pound'.filter_string($each['prescription_fee']);} else {  echo '&pound'."0.00";}?> </td>-->
                                                    <td> <?php if($percentage!="") {echo '&pound'.filter_string($percentage);} else {  echo '&pound'."0.00";}?></td>
                                                </tr>
                                              
                                     <?php 
									 			 $i++;
												
												} // end foreach loop?>
                                                
                                                 <tr class="newRow">
                                                    <td> <strong>TOTAL (<?php echo '&pound';?>)</strong> </td>
                                                    <td colspan="2"> </td>
                                                    
                                                     <td><strong> <?php if($total_medicine_cost!="") {echo filter_string($total_medicine_cost);} else {  echo "0.00";}?> </strong></td>                                                    
                                                    <td><strong> <?php if($total_shiping_cost!="") {echo filter_string($total_shiping_cost);} else {  echo "0.00";}?> </strong></td>
                                                    <!--<td><strong> <?php if($total_prescription_fee!="") {echo $total_prescription_fee;} else {  echo "0.00";}?> </strong></td>-->
                                                   <td><strong> <?php if($total_prescription_pharmacy_percentage!="") {echo $total_prescription_pharmacy_percentage;} else {  echo "0.00";}?></strong> </td>
                                                </tr>
									 	<?php 	} else { ?>
                                            
                                            	<tr class="newRow">
                                                    <td colspan="9"> No records found. </td>
                                                </tr>
												
									 <?php } // else condition ?>
                                        
                                    </tbody>
                                </table>