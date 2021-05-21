<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Resolve</h4> 
  <hr /> 
   <br />   
   
    <div class="row">
      <label for="first_name" class="col-sm-2 control-label"> <strtong>Name: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo filter_string($complaints_details['name']);?>
      </div>
  </div>
  
   <div class="row">
      <label for="first_name" class="col-sm-2 control-label"><strtong> Event Date: </strong></label>
      <div class="form-group col-sm-10">
       <?php echo kod_date_format(filter_string($complaints_details['event_date']));?>
      </div>
  </div>
  
  <div class="row">
      <label for="description" class="col-sm-2 control-label"><strtong>  Description:</strong> </label>
      <div class="form-group col-sm-10">
     <?php echo filter_string($complaints_details['description']);?>
      </div>
  </div>    

  <?php if($complaints_details['acknowledge'] !=''){?>	
   <div class="row">
      <label for="Acknowledge" class="col-sm-2 control-label"><strtong>  Acknowledge:</strong> </label>
      <div class="form-group col-sm-10">
     <?php echo filter_string($complaints_details['acknowledge']);?>
      </div>
  </div>
  
  <?php } ?>
  
   <?php if($complaints_details['investigate'] !=''){?>	
   <div class="row">
      <label for="investigate" class="col-sm-2 control-label"><strtong>  Investegate:</strong> </label>
      <div class="form-group col-sm-10">
     <?php echo filter_string($complaints_details['investigate']);?>
      </div>
  </div>
  
  <?php } ?>
  
    <?php if($complaints_details['outcome'] !=''){?>	
   <div class="row">
      <label for="investegate" class="col-sm-2 control-label"><strtong> Outcome:</strong> </label>
      <div class="form-group col-sm-10">
     <?php echo filter_string($complaints_details['outcome']);?>
      </div>
  </div>
  
  <?php } ?>
  
  <form  data-toggle="validator" role="form" id="resolve_frm" name="resolve_frm" method="post" action="<?php echo SURL?>complaints/resolve-process" autocomplete="off">
                     
  
  <br />
  <div class="">
    <div class="col-md-12">
      <button class="btn btn-success btn-default pull-right" type="submit" id="complaints_btn" name="complaints_btn" >Resolve Now</button>
      <input type="hidden" name="complaint_id" value="<?php echo $complaints_details['id'];?>">
    </div>
  </div>
 </form>
  
  