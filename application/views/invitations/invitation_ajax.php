<form name="superintendent_inv_frm" id="superintendent_inv_frm">

  <div class="row hidden" id="si_inv_container">
    <div class="col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-sm-8 col-md-8 col-lg-8"> 
      
      <!-- Invite Superintendent input field -->
      <label>Send invitation to Superintendent</label>
      <div class="input-group">
        <input class="form-control" required="required" type="email" placeholder="Enter email address" id="email_address" name="email_address" />
        <span class="input-group-btn" id="basic-addon3">
        <button class="btn btn-md btn-success" name="si_inv_btn" id="si_inv_btn" type="button">Invite Superintendent</button>
        </span> </div>
      <p><i>* Must be a Pharmacist</i></p>
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2"></div>
  </div>
  
  <div class="row" id="pending_invitation_container">
    <div class="col-sm-1 col-md-1 col-lg-1"></div>
    <div class="col-sm-11 col-md-11 col-lg-11">
      <div class="col-sm-8 col-md-8 col-lg-8 pull-left">
        <label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <?php echo filter_string($email_address); ?> waiting acceptance.</label>
      </div>
      <div class="col-sm-3 col-md-3 col-lg-3 pull-left">
        <a class="btn btn-sm btn-danger btn-block dialogue_window" href="#confirm_cancel_modal" type="button">Cancel Invitation</a>
        <!-- Modal -->
        <div id="confirm_cancel_modal" style="display:none">
            <h4 class="modal-title">Confirmation</h4>
            <p>Are you sure you you want to cancel the current invitation?</p>
            <div class="modal-footer">
                <button class="btn btn-danger"  type="button" data-dismiss="modal" onClick="cancel_inv_btn();" id="cancel_inv_btn" name="cancel_inv_btn">Cancel Invitation</button>
                <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
            </div>
        </div>
      </div>
    </div>
    <div class="col-sm-1 col-md-1 col-lg-1"></div>
  </div>

  <input type="hidden" name="inv_id" id="inv_id" value="<?php echo filter_string($invitation_id)?>" />
</form>

<div class="row alert alert-danger hidden" id="error_si_inv_container"></div>
<div id="overlay" class="overlay hidden">
<div class="col-md-12 text-center" style="margin-top:150px;"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div>
