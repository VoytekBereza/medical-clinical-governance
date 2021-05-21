<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Clinical Recalls Details</h4> 
  <hr /> 
   <br />       
  <div class="row">
      <label for="first_name" class="col-sm-2 control-label"> <strtong>Date: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo kod_date_format(filter_string($get_recalls_details['entry_date']));?>
      </div>
  </div>
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong>Received By: </strong></label>
      <div class="form-group col-sm-10">
        <?php if($get_recalls_details['status'] ==1 && $get_recalls_details['received_by'] !=""){
			  
			  $get_full_name =	get_user_details_new($get_recalls_details['received_by']);
		?>
      <?php echo ucfirst($get_full_name['fullname']).'<br />'.kod_date_format(filter_string($get_recalls_details['received_date']));?>													<?php } else { echo 'N/A';}?>
      </div>
  </div>
  
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong>Action By: </strong></label>
      <div class="form-group col-sm-10">
	  <?php if($get_recalls_details['status'] ==1 && $get_recalls_details['action_by'] !=""){
	  		
			$get_full_name =	get_user_details_new($get_recalls_details['action_by']);
	  ?>
       <?php echo ucfirst($get_full_name['fullname']).'<br />'.kod_date_format(filter_string($get_recalls_details['action_date']));?>													<?php } else { echo 'N/A';}?>
      </div>
  </div>
 
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong>Details:</strong> </label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($get_recalls_details['details']);?>
      </div>
  </div>
    
  