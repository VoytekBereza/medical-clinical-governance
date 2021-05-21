<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Clinical Errors Details</h4> 
  <hr /> 
   <br />       
  <div class="row">
      <label for="entry_date" class="col-sm-2 control-label"> <strtong>Date: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo kod_date_format(filter_string($get_clinical_errors_details['entry_date']));?>
      </div>
  </div>
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong> Entry creator: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo ucfirst(filter_string($get_clinical_errors_details['first_name']).' '.filter_string($get_clinical_errors_details['last_name']));?>
      </div>
  </div>
  
  
   <div class="row">
      <label for="error_attributed" class="col-sm-2 control-label"><strtong> Error Attributed: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($get_clinical_errors_details['error_attributed']);?>
      </div>
  </div>
  
  
  <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong> NPSA Class: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($get_clinical_errors_details['npsa_class']);?>
      </div>
  </div>
  
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"> <strtong> Subject:</strong> </label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($get_clinical_errors_details['subject']);?>
      </div>
  </div>
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong>  Details:</strong> </label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($get_clinical_errors_details['details']);?>
      </div>
  </div>
    
  