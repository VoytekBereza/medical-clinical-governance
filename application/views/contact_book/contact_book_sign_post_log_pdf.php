<link rel="stylesheet" href="<?php echo SURL;?>assets/css/kod_pdf.css">

<div style="width:100%; font-family:Arial; ">
<div style="width:33%; float:left;"><h1><?php echo filter_string($pharmacy_details['pharmacy_surgery_name']);?></h1></div>
<div style="width:63%;float:left;"><h1>Contact Book - <?php if($tab_id==1) { ?> Sign Posting Log Private <?php }?></h1></div>
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
                    <th align="left">Gender</th>
                    <th align="left">Approx age</th>
                    <th align="left">Patient Request</th>
                    <th align="left">Sign post to whom</th>
                    <th align="left">Reason</th>
                    <th align="left">Advice Given</th>
                    <th align="left">Follow up advice given</th>
                    <th class="left">Company/Note</th>
                </tr>
                
         <?php } ?>

        </thead>
   		 <tbody>
    
          
		<?php if(!empty($list_cb_sign_post_log_private)) {
        		foreach($list_cb_sign_post_log_private as $each): 
        ?>
            <tr>
                  <td><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                  <td><?php echo filter_string($each['gender']);?></td>
                  <td><?php echo filter_string($each['approximate_age']); ?></td>
                  <td><?php echo filter_string($each['patient_request']); ?></td>
                  <td><?php echo filter_string($each['sign_post_to_whom']); ?></td>
                  <td><?php echo filter_string($each['reason']); ?></td>
                  <td><?php echo filter_string($each['advice_given']); ?></td>
                  <td><?php echo filter_string($each['follow_up_advice_given']); ?></td>
                  <td><?php echo filter_string($each['company_name_note']); ?></td>
            </tr>
            <?php 
           	    endforeach; // foreach
            } 
        ?>
             
    </tbody>
  </table>