<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Clinical Self Care Details</h4> 
  <hr /> 
   <br />       
  <div class="row">
      <label for="entry_date" class="col-sm-3 control-label"> <strtong>Date: </strong></label>
      <div class="form-group col-sm-9">
       <?php echo kod_date_format(filter_string($get_clinical_self_care_details['entry_date']));?>
      </div>
  </div>
  
   <div class="row">
      <label for="gender" class="col-sm-3 control-label"><strtong> Gender: </strong></label>
      <div class="form-group col-sm-9">
       <?php echo filter_string($get_clinical_self_care_details['gender']);?>
      </div>
  </div>
  
   <div class="row">
      <label for="approximate_age" class="col-sm-3 control-label"> <strtong> Approximate Age:</strong> </label>
      <div class="form-group col-sm-9">
       <?php echo filter_string($get_clinical_self_care_details['approximate_age']);?>
      </div>
  </div>
  
   <div class="row">
      <label for="prescription_item" class="col-sm-3 control-label"><strtong> Prescription item:</strong> </label>
      <div class="form-group col-sm-9">
       <?php echo filter_string($get_clinical_self_care_details['prescription_item']);?>
      </div>
  </div>
  
  <div class="row">
      <label for="rx_advice_given" class="col-sm-3 control-label"><strtong> Rx advice given:</strong> </label>
      <div class="form-group col-sm-9">
       <?php echo filter_string($get_clinical_self_care_details['rx_advice_given']);?>
      </div>
  </div>
  
  <div class="row">
      <label for="otc_request" class="col-sm-3 control-label"><strtong> OTC Request:</strong> </label>
      <div class="form-group col-sm-9">
       <?php echo filter_string($get_clinical_self_care_details['otc_request']);?>
      </div>
  </div>
  
  <div class="row">
      <label for="otc_advice_given" class="col-sm-3 control-label"><strtong> OTC advice given:</strong> </label>
      <div class="form-group col-sm-9">
       <?php echo filter_string($get_clinical_self_care_details['otc_advice_given']);?>
      </div>
  </div>
  
   <div class="row">
      <label for="follow_up_care_given" class="col-sm-3 control-label"><strtong> Follow up care given:</strong> </label>
      <div class="form-group col-sm-9">
       <?php echo filter_string($get_clinical_self_care_details['follow_up_care_given']);?>
      </div>
  </div>
    
  