<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Add Outcome</h4> 
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
      
  <form  data-toggle="validator" role="form" id="outcome_frm" name="outcome_frm" method="post" action="<?php echo SURL?>complaints/add-complaint-process" autocomplete="off">
                      
      <div class="row">
        <div class="col-md-12" style="padding-left:0px;"> <br />
          <div class="form-group has-feedback">
            <label for="friend_email_address" class="col-md-2"><strong>Outcome<span class="required">*</span></strong></label>
             <div class="col-md-10">
            <textarea class="form-control" rows="5" id="outcome" name="outcome" placeholder="Type Outcome"></textarea>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
        </div>
      </div>
      
      <br />
      <div class="">
        <div class="col-md-12">
          <button class="btn btn-success btn-default pull-right" type="submit" id="complaints_btn" name="complaints_btn" >Save</button>
           <input type="hidden" name="complaint_id" value="<?php echo $complaints_id;?>">
        </div>
      </div>
 </form>
 
 <script type="text/javascript">
 $(document).ready(function() {
    $('#outcome_frm').formValidation({
        framework: 'bootstrap',
        icon: {
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            outcome: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            }
        }
    });
});
</script>
