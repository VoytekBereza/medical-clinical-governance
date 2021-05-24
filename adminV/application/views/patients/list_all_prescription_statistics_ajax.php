<?php if(!empty($transaction_list_ajax)){ $DataTableId ="orderdetails";} else { $DataTableId = '';}?>
                   
               <table id="<?php echo $DataTableId; ?>" class="table table-bordered table-hover table-prices">
                                    <thead>
                                        <tr>
                                           <th> Order date</th>
                                           <th> Pharmacy Name </th>
                                           <th> Patient Name </th>
                                           <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-compare-tbody">
                                    <?php if(!empty($transaction_list_ajax)){
												
												foreach($transaction_list_ajax as $each) {	
									?>
                                                <tr class="newRow">
                                                    <td> <?php echo kod_date_format(filter_string($each['created_date']), true); ?> </td>
                                                    <td> <?php echo filter_string($each['pharmacy_surgery_name']). '- '.filter_string($each['postcode']);?> </td>
                                                    <td> <?php echo filter_string($each['patient_name']);?> </td>
                                                	  <td>
                                                      
                                                     <a class="btn btn-xxs btn-success preview" data-fancybox-type="ajax" href="<?php echo SURL; ?>patient/preview-current-statistics/<?php echo $each['organization_id'];?>/<?php echo $each['pharmacy_surgery_id']; ?>" id="preview" rel="<?php echo $each['id']; ?>" > View Details </a>
                                                     </td>
                                                </tr>
                                                
                                                <!-- Hidden forms containing data to show on preview > -->
						<div class="col-md-12">

							<form id="prescription-preview-form-<?php echo $each['id']; ?>" method="post">
								
								<!-- Patient id - hidden field -->
								<input type="hidden" name="patient_id" value="<?php echo filter_string($each['patient_id']); ?>" readonly="readonly"/>
								<input type="hidden" name="approve-transaction" value="1" readonly="readonly"/>
								<input type="hidden" name="order-detail-id" value="<?php echo filter_string($each['id']); ?>" readonly="readonly"/>
								
								<input name="transaction[medicine_class][]" type="hidden" value="<?php echo filter_string($each['medicine_class']); ?>" readonly="readonly">
								<input name="transaction[medicine_strength_id][]" type="hidden" value="<?php echo filter_string($each['strength_id']); ?>" readonly="readonly">
								<input name="transaction[medicine_full_name][]" type="hidden" value="<?php echo filter_string($each['medicine_full_name']); ?>" readonly="readonly">
								<input name="transaction[medicine_id][]" type="hidden" value="<?php echo filter_string($each['medicine_id']); ?>" readonly="readonly">
								<input name="transaction[strength][]" type="hidden" value="<?php echo filter_string($each['strength']); ?>" readonly="readonly">
								<input name="transaction[medicine_form][]" type="" value="<?php echo filter_string($each['medicine_form']); ?>" readonly="readonly">
								<input class="form-control" name="transaction[suggested_dose][]" type="hidden" value="<?php echo filter_string($each['suggested_dose']); ?>" readonly="readonly">
								<input class="form-control" min="1" name="transaction[qty][]" placeholder="Qty" type="hidden" value="<?php echo filter_string($each['quantity']); ?>" readonly="readonly">

							</form>

						</div>
						<!-- ./end hidden forms div -->

                                     <?php 
									 			} // end foreach loop
									 		} else { ?>
                                            
                                            	<tr class="newRow">
                                                    <td colspan="9"> No records found. </td>
                                                </tr>
												
									 <?php } // else condition ?>
                                        
                                    </tbody>
                                </table>
         
          
       