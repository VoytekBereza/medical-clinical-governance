<!-- Display Success Message Contents -->
<?php 
  $user_id = $this->uri->segment(3);
?>
<style>
	label{
		font-weight:normal;
	}
</style>
<div class="row">
	<div class="col-md-12">
        <p>
            <div class="row">
                 <div class="col-md-12 text-center">
                    <h3>Complaints Form</h3>
                </div>
            </div> <!-- ./row -->
            
            <hr /><br />
             <form  data-toggle="validator" role="form" id="save_complaint_frm" name="save_complaint_frm" method="post" action="<?php echo SURL?>complaints-form/complaints-add-edit-process" autocomplete="off">
            
           <!-- <div class="row">
                 <div class="col-md-12 text-center">
                    <h4>This section is about why you visited the pharmacy today</h4>
                </div>
            </div>    
            <hr />   -->                
                    
                        <div class="row">
                            <br />
                            <div class="col-md-12">
                                 <div class="form-group  has-feedback">
                                 <label>Name:</label>
                                    <input class="form-control"  id="name" name="name" placeholder="enter your name"  required="required" maxlength="50" >
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              						<div class="help-block with-errors"></div>
                                    
                                 </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <br />
                            <div class="col-md-12">
                                <div class="form-group  has-feedback">
                                <label>Event Date: </label>
                                    <input type="text" id="event_date" name="event_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              						<div class="help-block with-errors"></div>
                                 </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <br />
                            <div class="col-md-12">
                                <div class="form-group  has-feedback">
                                 <label>Description:</label>
                                    <textarea class="form-control" rows="5" id="comment" name="description" placeholder="description"  required="required"></textarea>
                                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              						<div class="help-block with-errors"></div>
                                                                      
                                 </div>
                            </div>
                        </div>         
                        <!-- ./row -->                                    
           
           
                <div class="row">
                	<div class="col-md-8">
                    </div>
                	<div class="col-md-4">
	                	<button type="submit" name="submit_complaints_btn" id="submit_complaints_btn" class="btn btn-success marg2 pull-right">Submit</button>
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>">
                    </div>
                </div> <!-- ./row -->
            </form>   
        </p>
    </div>
</div> <!-- ./row -->