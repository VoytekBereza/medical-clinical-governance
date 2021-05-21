<!-- Pending Transactions -->
<div class="col-md-12">

    <div class="panel panel-success">
    <div class="panel-heading"><strong> Patient "<?php echo (filter_string($patient_vaccine_history[0]['vaccine_name'])) ?>" history</strong></div>
        <table id="medicine-history-table" class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="text-center">Vaccine Name</th>
                    <th class="text-center">Brand</th>
                    <th class="text-center">Batch No.</th>
                    <th class="text-center">Expiry Date</th>
                    <th class="text-center">Deltoid</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Extra Advice</th>
                    <th class="text-center">Notes</th>
                    <th class="text-center">Vaccinated Date</th>
                    <th class="text-center">User</th>
                </tr>
            </thead>
            <tbody class="text-center">
        <?php
                    if($patient_vaccine_history){ 
                    
                        foreach($patient_vaccine_history as $each){
        ?>
                            <tr>
                                <td> <?php echo filter_string($each['vaccine_name']); ?> </td>
                                <td> <?php echo filter_string($each['brand_name']); ?> </td>
                                <td><?php echo filter_string($each['batch_no']); ?></td>
                                <td><?php echo kod_date_format(filter_string($each['expiry_date'])); ?></td>
                                <td><?php echo filter_string($each['deltoid']); ?></td>
                                <td><?php echo filter_string($each['price']); ?></td>
                                <td>
                                	<?php 
										$extra_advice_arr = explode('|',filter_string($each['extra_advice']));
										$extra_advice_str = '';
										for($i=0;$i<count($extra_advice_arr);$i++){
											
											$advice_title_arr = (get_vaccine_extra_advices($extra_advice_arr[$i]));
											$extra_advice_str .= $advice_title_arr['advice_title'].', ';
											
										}//end for($i=0;$i<count($extra_advice_arr);$i++)
										
										echo rtrim($extra_advice_str,', ');
									?>
                                </td>
                                <td><?php echo filter_string($each['notes']); ?></td>
                                <td><?php echo kod_date_format(filter_string($each['created_date'])); ?></td>
                                <td><?php echo ucwords(filter_string($each['prescribed_by_name'])); ?></td>
                            </tr>
        <?php
                        } // foreach($patient_vaccine_history as $each)
                        
                    } else { 
        ?>
                        <tr><td colspan="9"><span class="text-danger">No record found.</span></td></tr>
        <?php
                    }//end if($patient_vaccine_history)
        ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>