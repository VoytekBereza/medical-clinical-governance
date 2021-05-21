<!-- Pending Transactions -->
<div class="col-md-12">

    <div class="panel panel-success">
    <div class="panel-heading"><strong> Patient "<?php echo filter_string($patient_history[0]['p_medicine_short_name']);?>" history</strong></div>
        <table id="medicine-history-table" class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
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
                    <?php if(!$is_online && $free_type == 1){ ?>
                        <th class="text-center">Repeat</th>
                    <?php } // end if(!$is_online) ?>
                </tr>
            </thead>
            <tbody class="text-center">
        <?php
                    if($patient_history){ 
                    
                        foreach($patient_history as $each){
        ?>
                            <tr>
                                <td> <?php echo filter_string($each['p_medicine_short_name']); ?> </td>
                                <td><?php echo filter_string($each['p_medicine_form']); ?></td>
                                <td><?php echo filter_string($each['p_strength_name']); ?></td>
                                <td><?php echo filter_string($each['quantity']); ?></td>
                                <td><?php echo filter_string($each['p_suggested_dose']); ?></td>
                                <td><?php echo $each['order_type'].' '.$each['medicine_class']; ?></td>
                                <td><?php echo filter_string($each['prescribed_by_name']); ?></td>
                                <td>
                                    <?php
										$date = date_create($each['created_date']);
										echo date_format($date,"d/m/Y");
                                    ?>
                                </td>
                                <?php 
									if(!$is_online && $free_type == 1){ 
									
								?>
                                    <td>
                                    	<?php 
											if($each['order_type'] == 'PMR'){
										?>
                                        <button class="btn btn-xs btn-primary" title="Repeat Medicine" onclick="select_medicine_custom('<?php echo $med_id; ?>', '<?php echo $each['p_medicine_short_name']?>', '<?php echo $each['p_strength_name']; ?>', '<?php echo $each['p_medicine_form']; ?>')" ><i class="fa fa-repeat"></i></button>
                                    </td>
                                    	<?php 
											} // end if($each['order_type'] == 'PMR')										
										?>
                                <?php 
									
									}
								?>
                            </tr>
        <?php
                        } // foreach($patient_history as $each)
                        
                    } else { // if($patient_history)
        ?>
                        <tr><td colspan="9"><span class="text-danger">No record found.</span></td></tr>
        <?php
                    }//end if($patient_history)
        ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>