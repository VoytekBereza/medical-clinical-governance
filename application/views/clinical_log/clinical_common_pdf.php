<link rel="stylesheet" href="<?php echo SURL;?>assets/css/kod_pdf.css">

<div style="width:100%; font-family:Arial; ">
<div style="width:33%; float:left;"><h1><?php echo filter_string($pharmacy_details['pharmacy_surgery_name']);?></h1></div>
<div style="width:33%;float:left;"><h1>Clinical Log - <?php if($tab_id==1) { ?> Clinical Diary<?php } if($tab_id==2) { ?> Errors <?php }  if($tab_id==3) {?> Date Checking <?php } if($tab_id==4) {?> Cleaning <?php }?><?php if($tab_id==5) {?> Recalls <?php }?><?php if($tab_id==6) {?> Responsible Pharmacist <?php }?><?php if($tab_id==7) {?> Maintenance <?php }?><?php if($tab_id==8) {?> Self Care <?php }?></h1></div>
<!--<div style="width:33%; float:left; text-align:right"><img src="<?php echo SURL;?>assets/images/logo.jpg" width="110px;"/></div>
--></div>
<div style="width:100%; font-family:Arial; ">
<div style="width:20%; float:left;" class="font_size_data"><?php echo filter_string($pharmacy_details['address']).', '.filter_string($pharmacy_details['postcode']);?></div>
<br />
<div style="width:33%; float:right; text-align:right" class="font_size_data">Date created: <?php echo date('d/m/Y'); ?></div>
</div>

<hr />
<br />


 <table width="100%" class="tablehead" cellpadding="5" cellspacing="0"> <thead>
        
         <?php if($tab_id==1) { ?>
                <tr>
                    <th align="left">Date</th>
                    <th align="left">Entry creator</th>
                    <th align="left">Subject</th>
                    <th align="left">Details</th>
                </tr>
                
         <?php } ?>
         <?php if($tab_id==2) { ?>
        		<tr>
                    <th align="left">Date</th>
                    <th align="left">Entry creator</th>
                    <th align="left">Error Attributed</th>
                    <th align="left">NPSA Class</th>
                    <th align="left">Subject</th>
                    <th align="left">Details</th>
        		</tr>
         
         <?php } ?>
         
         <?php if($tab_id==3) { ?>
           		 <tr>
                    <th align="left">Date</th>
                    <th align="left">Check performed by</th>
                    <th align="left">Medicine Type</th>
                    <th align="left">Notes (optional)</th>
            	</tr>
          <?php } ?>
           
           <?php if($tab_id==4) { ?>
            	<tr>
                    <th align="left">Date</th>
                    <th align="left">Cleaning performed by...</th>
                    <th align="left">Location area</th>
                    <th align="left">Notes (optional)</th>
            	</tr>
            <?php } ?> 
            
              <?php if($tab_id==5) { ?>
                <tr>
                    <th align="left">Date</th>
                    <th align="left">Recall received by</th>
                    <th align="left">Actioned by</th>
                    <th align="left">Details</th>
                </tr>
            <?php } ?> 
            
              <?php if($tab_id==6) { ?>
                <tr>
                    <th align="left">Date</th>
                    <th align="left">Check in time</th>
                    <th align="left">Check out time</th>
                    <th align="left">Responsible Pharmacist</th>
                   <!-- <th>Responsible Pharmacist Notice</th>-->
                </tr>
            <?php } ?> 
            
              <?php if($tab_id==7) { ?>
                <tr>
                    <th align="left">Date identified</th>
                    <th align="left">User who identified issue</th>
                    <th align="left">Maintenance issue</th>
                    <th align="left">Contractor name </th>
                    <th align="left">Issue Resolved? </th>
                </tr>
            <?php } ?> 
            
              <?php if($tab_id==8) { ?>
                <tr>
                    <th align="left">Date </th>
                    <th align="left">Gender </th>
                    <th align="left">Approximate Age </th>
                    <th align="left">Prescription item  </th>
                    <th align="left">Rx advice given </th>
                    <th align="left">OTC Request</th>
                    <th align="left">OTC advice given</th>
                    <th align="left">Follow up care given</th>
                </tr>
            <?php } ?> 
        </thead>
   		 <tbody>
    
          
		<?php if(!empty($list_cl_diary)) {
        		foreach($list_cl_diary as $each): 
        ?>
            <tr>
                <td align="left" width="15%"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                <td align="left" width="15%"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                <td align="left" width="15%"><?php echo filter_string($each['subject']);?></td>
                <td align="left" width="55%"><?php echo filter_string($each['details']);?></td>
            </tr>
            <?php 
           	    endforeach; // foreach
            } 
        ?>
             
		<?php if(!empty($list_cl_errors)) {
                foreach($list_cl_errors as $each): 
        ?>
           <tr>
                <td align="left"  width="15%"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                <td align="left"  width="15%"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                <td align="left"  width="15%"><?php echo filter_string($each['error_attributed']);?></td>
                <td align="left"  width="15%"><?php echo filter_string($each['npsa_class']);?></td>
                <td align="left"  width="15%"><?php echo filter_string($each['subject']);?></td>
                <td align="left"  width="35%"><?php echo filter_string($each['details']);?></td>
          </tr>
        <?php 
        endforeach; // foreach
        } 
        ?>
            
			<?php 
				if(!empty($list_cl_date_checking)) { 
            		foreach($list_cl_date_checking as $each) :
            ?>
                <tr>
                        <td><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                        <td><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                        <td><?php echo filter_string($each['medicine_type']);?></td>
                        <td><?php if($each['notes'] !='') { echo filter_string($each['notes']); } else { echo 'N/A';} ?></td>
                </tr>
                
            <?php 
                   endforeach;
                }
            ?> 
            
			<?php 
				if(!empty($list_cl_cleaning)) { 
            		foreach($list_cl_cleaning as $each) :
            ?>
            
                <tr>
                    <td><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                    <td><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                    <td><?php echo filter_string($each['location_area']);?></td>
                    <td><?php if($each['notes'] !='') { echo filter_string($each['notes']); } else { echo 'N/A';} ?></td>
                </tr>
                
            
            <?php 
            	 endforeach;
            	} 
            ?>    
            
            
            <?php 
				if(!empty($list_cl_recalls)) { 
            		foreach($list_cl_recalls as $each) :
            ?>
            
                <tr>
                    <td width="10%"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                    <td width="20%">
					<?php if($each['status'] ==1 && $each['received_by'] !=""){
						  $get_full_name = get_user_details_new($each['received_by']);
						
					?>
                    <?php echo ucfirst(filter_string($get_full_name['fullname'])).'<br />'.kod_date_format(filter_string($each['received_date']));?>													<?php } else { echo 'N/A';}?></td>
                    <td width="20%"><?php if($each['status'] ==1 && $each['action_by'] !=""){
						   $get_full_name = get_user_details_new($each['action_by']);
					?>
                    <?php echo  ucfirst(filter_string($get_full_name['fullname'])).'<br />'.kod_date_format(filter_string($each['action_date']));?>													<?php } else { echo 'N/A';}?></td>                                						
                    <td width="50%"><?php echo filter_string($each['details']);?></td>
                </tr>
                
            
            <?php 
            	 endforeach;
            	} 
            ?>     
            
			<?php if(!empty($list_cl_responsible_pharmacist)) {
            		foreach($list_cl_responsible_pharmacist as $each): 
            ?>
                <tr>
                    <td><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                    <td><?php echo filter_string($each['checkin_time']); ?></td>
                    <td><?php echo filter_string($each['checkout_time']); ?></td>  
                    <td><?php echo ucfirst(filter_string($each['first_name'])).' '. ucfirst(filter_string($each['last_name']));?></td>                                                      
                </tr>
            <?php 
            		endforeach; // foreach
            	}   
			?>
            
			<?php if(!empty($list_cl_maintenance)) {
            		foreach($list_cl_maintenance as $each): 
            ?>
                <tr>
                    <td><?php echo kod_date_format(filter_string($each['identified_date'])); ?></td>
                    <td><?php echo  ucfirst(filter_string($each['first_name'])).' '. ucfirst(filter_string($each['last_name']));?></td>
                    <td><?php echo filter_string($each['maintenance_issue']); ?> </td>
                    <td><?php echo filter_string($each['contractor_name_details']); ?></td>
                    <td> <?php if($each['status'] ==1){
						  $get_full_name =	get_user_details_new($each['resolved_by']);
					?>
                    <?php echo  ucfirst(filter_string($get_full_name['fullname'])).'<br />'.kod_date_format(filter_string($each['reslove_date']));?>													<?php } else { echo 'N/A';}?> </td>
                </tr>
            <?php 
            		endforeach; // foreach
            	}
			?>	
            
			<?php if(!empty($list_cl_self_care)) {
            		foreach($list_cl_self_care as $each): 
            ?>
                <tr>
                    <td><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                    <td><?php echo filter_string($each['gender']);?></td>
                    <td><?php echo filter_string($each['approximate_age']); ?> </td>
                    <td><?php echo filter_string($each['prescription_item']); ?></td>
                    <td><?php echo filter_string($each['rx_advice_given']); ?></td>
                    <td><?php echo filter_string($each['otc_request']); ?></td>
                    <td><?php echo filter_string($each['otc_advice_given']); ?></td>
                    <td><?php echo filter_string($each['follow_up_care_given']); ?></td>
                    
                </tr>
            <?php 
            	endforeach; // foreach
              } 
			 ?>	            
    </tbody>
  </table>