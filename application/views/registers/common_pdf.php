<link rel="stylesheet" href="<?php echo SURL;?>assets/css/kod_pdf.css">

<div style="width:100%; font-family:Arial; ">
<div style="width:33%; float:left;"><h1><?php echo filter_string($pharmacy_details['pharmacy_surgery_name']);?></h1></div>
<div style="width:67%;float:left;"><h1>Registers - <?php if($tab_id==1) { ?>Controlled Drugs<?php } if($tab_id==2) { ?>CD Returns/ Destruction<?php } if($tab_id==3) { ?> POM Private <?php }  if($tab_id==4) {?> Specials <?php }  if($tab_id==5) {?> Emergency Supply <?php }?></h1></div>
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
        <tr class="rheading">
            <th align="left">Date</th>
            <th align="left">User</th>
            <th align="left">Supplier name and address</th>
            <th align="left">Patient name and address</th>
            <th align="left">Prescriber details</th>
            <th align="left">Was proof of id requested?</th>
            <th class="left">Was id confirmed?</th>
            <th align="left">Name of person collecting</th>
            <th align="left">Notes </th>
            <th align="left">Quantity supplied or received</th>
            <th align="left">Running balance</th>
            
        </tr>
         <?php } ?>
         
         <?php if($tab_id==2) { ?>
        <tr>
            <th align="left">Date</th>
            <th align="left">User</th>
            <th align="left">Patient name and address</th>
            <th align="left">Name of person returning</th>
            <th align="left">Role of returning patient</th>
            <th align="left">Name of person collecting</th>
            <th align="left">Reason</th>
            <th align="left">Quantity</th>
            <th align="left">Running balance</th>
            <th align="left">Witness</th>
        </tr>
        
         <?php } ?>
         <?php if($tab_id==3) { ?>
        <tr>
            <th align="left">Date supplied</th>
            <th align="left">Patient name and address</th>
            <th align="left">Prescriber details</th>
            <th align="left">Medicine name</th>
            <th align="left">Strength</th>
            <th align="left">Form</th>
            <th align="left">Quantity</th>
            <th align="left">Cost to patient(&pound;)</th>
        
        </tr>
         
         <?php } ?>
         
         <?php if($tab_id==4) { ?>
            <tr>
                <th align="left">Date made</th>
                <th align="left">Patient name and address</th>
                <th align="left">Medicine name</th>
                <th align="left">Strength</th>
                <th align="left">Form</th>
                <th align="left">Quantity</th>
            </tr>
          <?php } ?>
           
           <?php if($tab_id==5) { ?>
            <tr>
                <th align="left">Date made</th>
                <th align="left">Patient name and address</th>
                <th align="left">Medicine name</th>
                <th align="left">Strength</th>
                <th align="left">Form</th>
                <th align="left">Quantity</th>
                <th align="left">Cost to patient(&pound;)</th>
            </tr>
            <?php } ?> 
        </thead>
    <tbody>
    
            <?php if(!empty($list_register_all_entery)) {
						   
						     foreach($list_register_all_entery as $each){
								
						   ?>
                            <tr>
                                <td><?php echo kod_date_format($each['created_date']);?></td>
                                <td><?php echo filter_string($each['fname']).' '.filter_string($each['lname']);?></td>
                                <td><?php echo filter_string($each['supplier_name']).' <br/>'.filter_string($each['sup_address']);?></td>
                                <td><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                                <td><?php echo filter_string($each['presc_first_name']).' '.filter_string($each['presc_last_name']).' <br/>'.filter_string($each['presc_address']);?></td>
                                <td><?php echo filter_string($each['proof_of_id']);?></td>
                                <td><?php echo filter_string($each['proof_confirm_id']);?></td>
                                <td><?php echo filter_string($each['collecting_person_name']);?></td>
                                <td><?php if($each['note']!='') {?><?php echo filter_string($each['note']);?><?php } else if($each['reason'] !=""){?><?php echo filter_string($each['reason']);?><?php }?><?php echo filter_string($each['note']);?> </td>
                                <td><?php if($each['supplier_name'] !='') { echo filter_string($each['quantity_received']);} else if($each['quantity_supplied'] !='') { echo '-'. filter_string($each['quantity_supplied']);}?></td>
                                
                                 
                                <td><?php echo filter_string($each['stock_in_hand']);?></td>
                            </tr>
                            
                        <?php  
								} // foreach 
					   } 
		     ?>
             
             <?php 
						   if(!empty($list_cd_return)) { 
						   		  foreach($list_cd_return as $each) :
								 
						   ?> 
                                <tr>
                                <td><?php echo kod_date_format($each['created_date']);?></td>
                                <td><?php echo filter_string($each['fname']).' '.filter_string($each['lname']);?></td>
                               
                                <td><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                                <td><?php echo filter_string($each['person_return_name']);?></td>
                                <td><?php echo filter_string($each['patient_return_name']);?></td>
                                <td><?php echo filter_string($each['person_collecting']);?> </td>
                                <td><?php echo filter_string($each['reason']);?> </td>
                             
                                <td><?php if($each['stock_return_destruction'] =='cd_return') { echo filter_string($each['quantity']);} else if($each['stock_return_destruction'] =='cd_destruction') { echo '-'.filter_string($each['quantity']);}?></td>
                                <td><?php echo filter_string($each['stock_in_hand']);?></td>
 								<td><?php echo filter_string($each['wfname']).' <br/>'.filter_string($each['wlname']).' <br/>'.filter_string($each['witness_address']);?></td>                           
                               
                                 </tr>
                               <?php 
									endforeach;
								 }
								 ?>
             
			<?php 
				if(!empty($list_all_pom_private_entry)) { 
            		foreach($list_all_pom_private_entry as $each) :
            ?>
                    <tr>
                        <td><?php echo kod_date_format(filter_string($each['created_date']));?></td>
                        <td><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                        <td><?php echo filter_string($each['presc_first_name']).' '.filter_string($each['presc_last_name']).' <br/>'.filter_string($each['presc_address']);?></td>
                        <td><?php echo filter_string($each['drug_name']);?></td>
                        <td><?php echo filter_string($each['drug_strength']);?></td>
                        <td><?php echo filter_string($each['drug_form']);?></td>
                        <td><?php echo filter_string($each['quantity']);?></td>
                        <td>&pound;<?php echo filter_string($each['patient_cost']);?> </td>
                    </tr>
            
            <?php 
            		endforeach;
            	}
			?> 
            
			<?php 
				if(!empty($list_all_special)) { 
            		foreach($list_all_special as $each) :
            ?>
                <tr>
                    <td><?php echo kod_date_format(filter_string($each['created_date']));?></td>
                    <td><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                    <td><?php echo filter_string($each['drug_name']);?></td>
                    <td><?php echo filter_string($each['drug_strength']);?></td>
                    <td><?php echo filter_string($each['drug_form']);?></td>
                    <td><?php echo filter_string($each['quantity']);?></td>
                </tr>
                
            <?php 
                   endforeach;
                }
            ?> 
            
			<?php 
				if(!empty($list_all_emergency_supply)) { 
            		foreach($list_all_emergency_supply as $each) :
            ?>
            
                <tr>
                    <td><?php echo kod_date_format(filter_string($each['created_date']));?></td>
                    <td><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                    <td><?php echo filter_string($each['drug_name']);?></td>
                    <td><?php echo filter_string($each['drug_strength']);?></td>
                    <td><?php echo filter_string($each['drug_form']);?></td>
                    <td><?php echo filter_string($each['quantity']);?></td>
                    <td><?php echo filter_string($each['cost_patient']);?></td>
                </tr>
                
            
            <?php 
            	 endforeach;
            	} 
            ?>             
    </tbody>
  </table>