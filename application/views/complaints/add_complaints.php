<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue">Add Complaints</h4> 
  <hr /> 
   <br />       
  <form  data-toggle="validator" role="form" id="send_survey_link_frm" name="send_survey_link_frm" method="post" action="<?php echo SURL?>complaints/complaints-form-process" autocomplete="off">
                      <div class="row">
                        <div class="col-md-12"> <br />
                          <div class="form-group has-feedback">
                            <label for="friend_email_address"><strong>Title<span class="required">*</span></strong></label>
                            <input type="text" required="required" value="" name="title" id="title"   class="form-control"  maxlength="30">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12"> <br />
                          <div class="form-group has-feedback">
                            <label for="friend_email_address"><strong>Description<span class="required">*</span></strong></label>
                            <textarea class="form-control" rows="5" id="comment" name="description" placeholder="description" maxlength="250" ></textarea>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      
                      
                      <div class="row">
                        <div class="col-md-12">
                          <button class="btn btn-success btn-default pull-right" type="submit" id="complaints_btn" name="complaints_btn" >Submit</button>
                        </div>
                      </div>
 </form>
    