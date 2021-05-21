<link rel="stylesheet" href="<?php echo SURL;?>assets/css/kod_pdf.css">

<div style="width:100%; font-family:Arial; ">
<div style="width:33%; float:left;"><h1><?php echo filter_string($pharmacy_details['pharmacy_surgery_name']);?></h1></div>
<div style="width:63%;float:left;"><h1>Contact Book</h1></div>
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
       
        <tr>
            <th align="left">First Name</th>
            <th align="left">Last Name</th>
            <th align="left">Contact Number</th>
            <th align="left">Email Address</th>
             <th align="left">Company/Notes</th>
            </tr>
                
        </thead>
   		 <tbody>
    
        <?php
		
		if(!empty($contact_list)) {
        		foreach($contact_list as $each): 
        ?>
            <tr>
                  <td><?php echo filter_string($each['first_name']); ?></td>
                  <td><?php echo filter_string($each['last_name']);?></td>
                  <td><?php echo filter_string($each['contact_no']); ?></td>
                  <td><?php echo filter_string($each['email_address']); ?></td>
                   <td><?php echo filter_string($each['company_notes']); ?></td>
            </tr>
            <?php 
           	    endforeach; // foreach
            } 
        ?>
             
    </tbody>
  </table>