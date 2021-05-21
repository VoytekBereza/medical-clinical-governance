<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue"> <?php if($get_check_balance_details['note']!='') {?>Note<?php } else if($get_check_balance_details['reason'] !=""){?>Reason<?php }?></h4> 
  <hr /> 
   <br />   
   
  <div class="row">
      <div class="form-group col-sm-12">
     <?php if($get_check_balance_details['note']!='') { echo filter_string($get_check_balance_details['note']);}  if($get_check_balance_details['reason'] !=""){  echo filter_string($get_check_balance_details['reason']);}?>
      </div>
  </div>    

 
  
  