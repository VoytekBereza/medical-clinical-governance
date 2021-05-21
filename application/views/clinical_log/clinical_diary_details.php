<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Clinical Diary Details</h4> 
  <hr /> 
   <br />       
  <div class="row">
      <label for="first_name" class="col-sm-2 control-label"> <strtong>Date: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo kod_date_format(filter_string($get_clinical_diary_details['entry_date']));?>
      </div>
  </div>
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong> Entry creator: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo ucfirst(filter_string($get_clinical_diary_details['first_name']).' '.filter_string($get_clinical_diary_details['last_name']));?>
      </div>
  </div>
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"> <strtong> Subject:</strong> </label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($get_clinical_diary_details['subject']);?>
      </div>
  </div>
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong>  Details:</strong> </label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($get_clinical_diary_details['details']);?>
      </div>
  </div>
    
  