<form name="import_pharmacy_process_frm" id="import_pharmacy_process_frm" action="<?php echo SURL?>organization/import-pharmacy-process" method="post">
	<div class="row" style="padding:0; margin:0">
    	<div class="col-md-12">
        	<?php 
				if(count($exist_pharmacy_arr) > 0){
					
			?>

                    <h4>Already Exist Pharmacy <small>The pharmacies with the name and postcode already exist in our system and will be ignored while importing</small></h4>
                    <table cellpadding="2" cellspacing="2" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <!--<td><strong>Location Type</strong></td>-->
                                <td><strong>Location Name</strong></td>
                                <td><strong>Location Address</strong></td>
                                <!--<td><strong>Location Country</strong></td>-->
                                <td><strong>Location Postcode</strong></td>
                                <td><strong>Location Phone Number</strong></td>
                                <td><strong>Location GPhC</strong></td>
                                <td><strong>Location ODS</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for($i=0; $i<count($exist_pharmacy_arr); $i++){
                            ?>
                                    <tr>
                                        <!--<td>< ?php echo ($exist_pharmacy_arr[$i]['LocationType'] == 'P') ? 'Pharmacy' : 'Clinic'?></td>-->
                                        <td><?php echo filter_string($exist_pharmacy_arr[$i]['LocationName'])?></td>
                                        <td><?php echo filter_string($exist_pharmacy_arr[$i]['LocationAddress'])?></td>
                                        <!--
                                        <td>
                                        	
											< ?php 
												if($exist_pharmacy_arr[$i]['LocationCountry'] == '1')
													echo 'England';
												elseif($exist_pharmacy_arr[$i]['LocationCountry'] == '2')
													echo 'Scotland';
												elseif($exist_pharmacy_arr[$i]['LocationCountry'] == '3')
													echo 'Wales';
												elseif($exist_pharmacy_arr[$i]['LocationCountry'] == '4')
													echo 'Nothern Ireland';
											?>
											
                                        </td>-->
                                        <td><?php echo filter_string($exist_pharmacy_arr[$i]['LocationPostcode'])?></td>
                                        <td><?php echo filter_string($exist_pharmacy_arr[$i]['LocationContact'])?></td>
                                        <td><?php echo filter_string($exist_pharmacy_arr[$i]['LocationGPHC'])?></td>
                                        <td><?php echo filter_string($exist_pharmacy_arr[$i]['LocationODS'])?></td>
                                    </tr>
                            <?php		
                                }//end foreach($pharmacy_data as $index => $val)
                            ?>
                        </tbody>
                    </table>        
            
            <?php					
				}//end if(count($exist_pharmacy_arr) > 0)
			?>

        	<?php 
				if(count($new_pharmacy_arr) > 0){
			?>

                    <h4>New Pharmacies</h4>
                    <table cellpadding="2" cellspacing="2" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <!--<td><strong>Location</strong></td>-->
                                <td><strong>Location Name</strong></td>
                                <td><strong>Location Address</strong></td>
                                <!--<td><strong>Location Country</strong></td>-->
                                <td><strong>Location Postcode</strong></td>
                                <td><strong>Location Contact</strong></td>
                                <td><strong>Location GPhC</strong></td>
                                <td><strong>Location ODS</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for($i=0; $i<count($new_pharmacy_arr); $i++){
                            ?>
                                    <tr>
                                        <!--<td>< ?php echo ($new_pharmacy_arr[$i]['LocationType'] == 'P') ? 'Pharmacy' : 'Clinic'?></td>-->
                                        <td><?php echo filter_string($new_pharmacy_arr[$i]['LocationName'])?></td>
                                        <td><?php echo filter_string($new_pharmacy_arr[$i]['LocationAddress'])?></td>
                                        <!--
                                        <td>
											< ?php 
												if($new_pharmacy_arr[$i]['LocationCountry'] == '1')
													echo 'England';
												elseif($new_pharmacy_arr[$i]['LocationCountry'] == '2')
													echo 'Scotland';
												elseif($new_pharmacy_arr[$i]['LocationCountry'] == '3')
													echo 'Wales';
												elseif($new_pharmacy_arr[$i]['LocationCountry'] == '4')
													echo 'Nothern Ireland';
											?>
                                        </td>
                                        -->
                                        <td><?php echo filter_string($new_pharmacy_arr[$i]['LocationPostcode'])?></td>
                                        <td><?php echo filter_string($new_pharmacy_arr[$i]['LocationPhoneNumber'])?></td>
                                        <td><?php echo filter_string($new_pharmacy_arr[$i]['LocationGPHC'])?></td>
                                        <td><?php echo filter_string($new_pharmacy_arr[$i]['LocationODS'])?></td>
                                    </tr>
                            <?php		
                                }//end foreach($new_pharmacy_arr as $index => $val)
                            ?>
                        </tbody>
                    </table>        
                    
                    <div class="row" style="padding:0; margin:0">
                        <div class="col-md-12 text-right">
                            <button type="submit" name="import_pharmacy_btn" id="import_pharmacy_btn" class="btn btn-sm btn-success">Import Pharmacy</button>
                            <textarea class="hidden" readonly="readonly" name="new_pharmacy_encode" id="new_pharmacy_encode"><?php echo $new_pharmacy_encode?></textarea>
                        </div>
                    </div>                    
            
            <?php					
				}//end if(count($new_pharmacy_arr) > 0)
			?>

        </div>
    </div>
    
    
</form>
