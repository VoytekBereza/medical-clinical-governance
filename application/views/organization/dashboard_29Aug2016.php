<style>
  .tooltip-arrow {background-color: #ccc;}
  .tooltip-danger + .tooltip > .tooltip-inner {background-color: #d43f3d; border: 1px solid #d43f3a;}
  .tooltip-success + .tooltip > .tooltip-inner {background-color: #5cb85c; border: 1px solid #4cae4c;}
  .tooltip-info + .tooltip > .tooltip-inner {background-color: #5bc0de; border: 1px solid #46b8da;}
  .tooltip-secondary + .tooltip > .tooltip-inner {background-color: #ddd; color: #000; border: 1px solid #000;}
  .tooltip-default + .tooltip > .tooltip-inner {background-color: #f8f8f8; color:#000; border: 1px solid #000;}
  div.tooltip-inner {
	width:250px;
	opacity: 1 !important;
	}
</style>

<!-- Fancy popup to send invite [ Update Governance HR ] -->

<a id="send_invite_fancy_trigger" href="#fancy-content-div" style="display: none;" class=" btn btn-xxs btn-danger governance_hr_fancybox"> Open Governance HR </a>
<div style="display: none" class="row col-md-12">
  <div id="fancy-content-div">
    <h4 class="modal-title">Send Contract</h4>
    <hr />
    <form id="push_invitation_form" action="#" method="POST" >
      <textarea id="governance_hr_textarea" name="governance_hr_text" class="textarea" placeholder="Enter Description" style="width: 800px; height: 400px"></textarea>
      <br />
      <!-- Hidden Input fields to send Ajax call to push_invite -->
      <input type="hidden" id="invitation_sent_to_arr" name="invitation_sent_to_arr" readonly="readonly" />
      <input type="hidden" id="invitation_method" name="invitation_method" readonly="readonly" />
      <input type="hidden" id="organization_id" name="organization_id" readonly="readonly" />
      <input type="hidden" id="pharmacy_surgery_id" name="pharmacy_surgery_id" readonly="readonly" />
      <input type="hidden" id="invitation_for" name="invitation_for" readonly="readonly" />
      <div class="col-md-12 alert alert-info">
        	<p class="text-danger"> <i class="fa fa-info-circle"></i> <strong>Need some help?</strong> <br />
            In this section, you can send Human Resources contracts to your staff. Either edit our template above (taken from <a href="https://www.gov.uk/employment-contracts" target="_blank"> https://www.gov.uk/employment-contracts </a>), create your own by copying and pasting from a file, OR if you do not want a contract or have elected yourself check the box to the left of the "Send Contract" button below. </p>
      </div>
      <span id="elect-self-staff-btn-span"></span>
      
    </form>
  </div>
</div>

<!-- Fancy popup to send invite [ Update User Contract for request change] --> 
<a id="send_contract_change_fancy_trigger" href="#fancy_contract_change_div" style="display: none;" class=" btn btn-xxs btn-danger governance_edit_inv_contract_fancybox"> Open HR Change Request </a>
<div style="display: none" class="row col-md-12">
  <div id="fancy_contract_change_div">
    <h4 class="modal-title">Edit Contract</h4>
    <hr />
    <form id="update_contract_frm" name="update_contract_frm" action="<?php echo SURL?>organization/update-invitation-contract-process" method="POST" >
      <div id="changing_notes_container" class="alert alert-info"></div>
      <textarea id="governance_edit_inv_contract_textarea" name="governance_edit_inv_contract_text" class="textarea" placeholder="Enter Description" style="width: 800px; height: 400px"></textarea>
      <br />
      <!-- Hidden Input fields to send Ajax call to push_invite -->
      <input type="hidden" id="edit_contract_invitation_id" name="edit_contract_invitation_id" value="" readonly="readonly" />
      <span id="edit_inv_contract_btn_span"></span>
    </form>
  </div>
</div>

<!-- Fancy popup to send invite [ View Contract of User] --> 
<a id="view_user_contract_fancy_trigger" href="#view_user_contract_div" style="display: none;" class=" btn btn-xxs btn-danger view_contract_fancybox"> Open Contract HR </a>
<div style="display: none" class="row col-md-12">
  <div id="view_user_contract_div">
    <h4 class="modal-title" id="contract_title">View Contract</h4>
    <hr />
    <div id="view_user_contract_container"></div>
  </div>
</div>

<!-- Fancy popup to send invite [ Resend Contract] --> 
<a id="resend_contract_fancy_trigger" href="#fancy_resend_contract_div" style="display: none;" class=" btn btn-xxs btn-danger governance_resend_contract_fancybox"> Open Resend Contract</a>
<div style="display: none" class="row col-md-12">
  <div id="fancy_resend_contract_div">
    <h4 class="modal-title">Resend Contract</h4>
    <hr />
    <form id="update_resend_contract_frm" name="update_resend_contract_frm" action="<?php echo SURL?>organization/update-contract-resend-process" method="POST" >
      <div id="renew_changing_notes_container"></div>
      <div id="contract_resend_status"></div>
      <textarea id="governance_resend_contract_textarea" name="governance_resend_contract_text" class="textarea" placeholder="Enter Description" style="width: 800px; height: 400px"></textarea>
      <br />
      <!-- Hidden Input fields to send Ajax call to push_invite -->
      <input type="hidden" id="temp_contract_id" name="temp_contract_id" value="" readonly="readonly" />
      <input type="hidden" id="resend_contract_id" name="resend_contract_id" value="" readonly="readonly" />
      <input type="hidden" id="resend_contract_to_user_id" name="resend_contract_to_user_id" value="" readonly="readonly" />
      <span id="resend_contract_btn_span"></span>
    </form>
  </div>
</div>
<?php
	if($this->session->flashdata('err_message')){
?>
<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
<?php
	}//end if($this->session->flashdata('err_message'))
	
	if($this->session->flashdata('ok_message')){
?>
<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php 
	}//if($this->session->flashdata('ok_message'))

	if($this->session->flashdata('paypal_success')){
?>
<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('paypal_success'); ?></div>
<?php 
	}//if($this->session->flashdata('paypal_success'))


##########################################
#
# Elect SupterIntendent For Owner Only
#
##########################################

	if($this->session->is_owner){
		//If User is an Owner of an Organization. 

		if($organization_details_arr['superintendent_user_id']){
			//Organization have its own SI
?>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <h3 class="no_margin"><?php echo filter_string($this->session->organization['company_name'])?></h3>
                <hr />
              </div>
            </div>
			<!-- ./ row-->
            <div class="row">
              <div class="col-sm-6 col-md-5 col-lg-6 pull-left">
                <label class="text-warning">Superintendent : <?php echo ucwords($organization_details_arr['superintendent_full_name']);?></label>
                <span class="pharmacy_setting_link">
	                <a href="javascript:;" <?php if($superintendent_invitation_arr['email_address_user'] == ''){ ?> onClick="$('#si_inv_container').toggle('fast')" <?php } ?> id="cnage_si_btn" >Change</a>
                    </span>
                <br />
                <div aria-label="..." role="group" class="btn-group">
                  <?php
                    $check_si_stats = authenticate_user_panel($this->session->organization['superintendent_id'],$this->session->organization['id']);
                  ?>
                  <!-- Manager Governance read status -->
                  <button class="btn <?php echo ($check_si_stats['governance_passed']) ? 'btn-success tooltip-success' : 'btn-danger tooltip-danger'?> btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="This person has read and signed all SOPs." > Governance </button>
                  <?php
                    if($this->session->organization['superintendent_id'] != $this->session->id){
                  ?>
                  <div role="group" class="btn-group tooltip-info" data-toggle="tooltip" data-placement="top" title="This person has read and signed the HR contract.">
                    <?php 
                            if($chk_if_si_contract_in_temp && $chk_if_si_contract_in_temp['request_changes']){
            
                                //If User have any changes requested in temp table then show seperate color and message
                        ?>
                    <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Contract Changes Received <span class="caret"></span> </button>
                    <?php		
                            }else{
                        ?>

                      		<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Contract <span class="caret"></span> </button>
                    <?php		
                            }//end if($pharmacy_surgery['manager_hr_temp_contract'])
							
                        ?>
                    <ul class="dropdown-menu mydropdown-menu">
                      <li> <a data-target="<?php echo filter_string($check_si_contract_read_status['id'])?>" class="btn btn-xxs btn-info contract_view_mode" href="javascript:;"> View Contract</a> </li>
                      <li> <a data-target="<?php echo filter_string($check_si_contract_read_status['id'])?>" class="btn btn-xxs btn-warning contract_resend_mode" href="javascript:;"> Resend Contract</a> </li>
                    </ul>
                  </div>
                    <?php 
                            }//end if($this->session->organization['superintendent_id'] != $this->session->id)
                          ?>
                </div>
              </div>
              <div class="col-sm-3 col-md-2 col-lg-2 pull-left text-right">
                &nbsp;
              </div>
            </div>
            

        <!-- ./ row-->
        
<!-- ./ row-->
        <div id="invitation_response">
        	<div class="row" id="si_inv_container" style="display:none">
            	<div class="col-md-2">
              <?php 
                if($this->session->id != filter_string($organization_details_arr['superintendent_user_id'])){
                    //Only show Self if both ID's are not same
            ?>
              <form name="elect_si_self_frm" id="elect_si_self_frm" method="post" action="<?php echo SURL?>organization/superintendent-elect-self">
                    <button type="button" class="btn btn-warning btn-sm btn-block elect-self-view-contract " rel="P" name="SI" style="margin-top:18px;" > Elect Self </button>
                  <input type="hidden" name="elect_self_hid" id="elect_self_hid" value="1" />
              </form>
            
              <?php }//end if($this->session->id != filter_string($organization_details_arr['superintendent_user_id']))?>
                	 
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1"> <h3>OR</h3></div>
                <div class="col-md-9">
                	<form name="superintendent_inv_frm" id="superintendent_inv_frm">
                        <div class="row" >
                          
                          <div class="col-sm-12 col-md-12 col-lg-12"> 
                            
                            <!-- Invite Superintendent input field -->
                            <label>Send invitation to Superintendent</label>
                            <div class="input-group">
                              <input class="form-control" required="required" type="email" placeholder="Enter email address" id="email_address_si" name="email_address" />
                              <span class="input-group-btn" id="basic-addon3">
                              <button class="btn btn-md btn-success" name="si_inv_btn" id="si_inv_btn" type="button">Invite Superintendent</button>
                              </span> </div>
                            <p><i>* Must be a Pharmacist</i></p>
                            <div class="row alert alert-danger hidden" id="error_si_inv_container"></div>
                          </div>
                          
                        </div>
                        <!-- ./ row-->
                        <div class="row <?php echo ($superintendent_invitation_arr) ? '' : 'hidden'?>" id="pending_invitation_container">
                          <div class="col-sm-1 col-md-1 col-lg-1"></div>
                          <div class="col-sm-11 col-md-11 col-lg-11">
                            <div class="col-sm-8 col-md-8 col-lg-8 pull-left">
                              <label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <?php echo (filter_string($superintendent_invitation_arr['email_address_user']) != '' ) ?filter_string($superintendent_invitation_arr['email_address_user']) : filter_string($superintendent_invitation_arr['email_address']) ;?> waiting acceptence.</label>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4 pull-left"> <a class="btn btn-xs btn-danger dialogue_window " href="#confirm_cancel_modal"  type="button">Cancel Invitation</a>
                              <?php 
                                                    if(filter_string($superintendent_invitation_arr['request_changes']) == '1'){
                                                        //Means user have requested for the changes in the Conntract
                                                ?>
                              <a class="btn btn-xs btn-warning invitation_contract_changes" data-target="<?php echo filter_string($superintendent_invitation_arr['id'])?>" href="javascript:;"  type="button">Edit Contract</a>
                              <?php
                                                    }//end if(filter_string($superintendent_invitation_arr['request_changes']) == '1')
                                               ?>
                              
                              <!-- Modal Cancel Invitation -->
                              <div id="confirm_cancel_modal" style="display:none">
                                <h4 class="modal-title">Confirmation</h4>
                                <p>Are you sure you you want to cancel the current invitation?</p>
                                <div class="modal-footer">
                                  <button class="btn btn-danger" type="button" onClick="cancel_inv_btn();" id="cancel_inv_btn" name="cancel_inv_btn">Cancel Invitation</button>
                                  <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                                </div>
                              </div>
            
                            </div>
                          </div>
                          <div class="col-sm-1 col-md-1 col-lg-1"></div>
                        </div>
			            <!-- ./ row--> 
            			<br />
			            <input type="hidden" name="inv_id" id="inv_id" value="<?php echo filter_string($superintendent_invitation_arr['id']);?>" />
          			</form>
                      <div id="overlay" class="overlay hidden">
                        <div class="col-md-12 text-center" style="margin-top:150px;"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div>
                      </div>
                </div>
            </div>
        </div>
        <div class="row"><div class="col-md-12"><hr /></div> </div>
<?php 
	if(count($pharmacies_surgeries) == 0){
?>
			<p class="alert alert-info"><i class="fa fa-info-circle"></i> Now that <strong><?php echo filter_string($this->session->organization['company_name'])?></strong> has a Superintendent (<strong><?php echo ucwords($organization_details_arr['superintendent_full_name']);?></strong>). You need to set up individual pharmacies click the blue button to the right to add your first location.</p>
<?php
		}//end if(count($pharmacies_surgeries == 0))
	} else {
			//Organization Do Not Have its own SI YET
?>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <p>
                <h3><?php echo filter_string($this->session->organization['company_name'])?></h3>
                <hr />
                </p>
              </div>
            </div>
<!-- ./ row-->
			<p class="alert alert-info"><i class="fa fa-info-circle"></i> Your organisation has been set to <strong><?php echo filter_string($this->session->organization['company_name'])?></strong>, next you need to set up a pharmacy within your organisation. To do this you first need to create your team, starting with you superintendent. You can either elect yourself by clicking the "Elect Self" button or your can invite your superintendent by entering their email address below.</p>
        <div class="row">
            <div class="col-md-12"><p><label class="text-success">Elect Superintendent: No Superintendent</label></p></div>
        </div>
        <div class="row">
          <form name="elect_si_self_frm" id="elect_si_self_frm" method="post" action="<?php echo SURL?>organization/superintendent-elect-self">
            <div class="col-sm-2 col-md-2 col-lg-2">
            <br />
              <button type="button" class="btn btn-warning btn-sm btn-block elect-self-view-contract" rel="P" name="SI" > Elect Self </button>
            </div>
            <div class="col-sm-1 col-md-1 col-lg-1"> <h3>OR</h3></div>
            <input type="hidden" name="elect_self_hid" id="elect_self_hid" value="1" />
          </form>
            <div class="col-sm-9 col-md-9 col-lg-9">
                <div id="invitation_response">
                <form name="superintendent_inv_frm" id="superintendent_inv_frm">
                    <div class="row <?php echo ($superintendent_invitation_arr) ? 'hidden' : ''?>" id="si_inv_container">
                      
                      <div class="col-sm-12 col-md-12 col-lg-12"> 
                        
                        <!-- Invite Superintendent input field -->
                        <label> Send invitation to Superintendent *</label>
                        <div class="input-group">
                          <input class="form-control" required="required" type="email" placeholder="Enter email address" id="email_address_si" name="email_address" />
                          <span class="input-group-btn" id="basic-addon3">
                          <button class="btn btn-md btn-success" name="si_inv_btn" id="si_inv_btn" type="button">Invite Superintendent </button>
                          </span> </div>
                        <p><i>* Must be a Pharmacist</i></p>
                        <div class="row alert alert-danger hidden" id="error_si_inv_container"></div>
                      </div>
                      
                    </div>
                    <div class="row <?php echo ($superintendent_invitation_arr) ? '' : 'hidden'?>" id="pending_invitation_container">
                      <div class="col-sm-1 col-md-1 col-lg-1"></div>
                      <div class="col-sm-11 col-md-11 col-lg-11">
                        <div class="col-sm-8 col-md-8 col-lg-8 pull-left">
                          <label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <?php echo (filter_string($superintendent_invitation_arr['email_address_user']) != '' ) ?filter_string($superintendent_invitation_arr['email_address_user']) : filter_string($superintendent_invitation_arr['email_address']) ;?> waiting acceptence.</label>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 pull-left"><a class="btn btn-sm btn-danger btn-block dialogue_window" href="#confirm_cancel_modal"  type="button">Cancel Invitation</a>
                          <?php 
                                                if(filter_string($superintendent_invitation_arr['request_changes']) == '1'){
                                                    //Means user have requested for the changes in the Conntract
                                            ?>
                          <a class="btn btn-xs btn-warning invitation_contract_changes" data-target="<?php echo filter_string($superintendent_invitation_arr['id'])?>" href="javascript:;"  type="button">Edit Contract</a>
                          <?php
                                                }//end if(filter_string($superintendent_invitation_arr['request_changes']) == '1')
                                           ?>
                          
                          <!-- Modal Cancel Invitation -->
                          <div id="confirm_cancel_modal" style="display:none">
                            <h4 class="modal-title">Confirmation</h4>
                            <p>Are you sure you you want to cancel the current invitation?</p>
                            <div class="modal-footer">
                              <button class="btn btn-danger"  type="button" onClick="cancel_inv_btn();" id="cancel_inv_btn" name="cancel_inv_btn">Cancel Invitation</button>
                              <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1 col-md-1 col-lg-1"></div>
                    </div>
                <!-- ./ row-->
                    <input type="hidden" name="inv_id" id="inv_id" value="<?php echo filter_string($superintendent_invitation_arr['id']);?>" />
                </form>
                    <div id="overlay" class="overlay hidden">
                        <div class="col-md-12 text-center" style="margin-top:150px;"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div>
                    </div>
                </div> 
            </div>
        </div>

<!-- ./ row-->

<div class="row">
  <p><br />
  <hr />
  <br />
  </p>
</div>
<!-- ./ row-->

<?php
		}//end if($this->session->organization['superintendent_user_id'])
		
		
	}else{
		//If User is NOT an Owner of an Organization. 
		
	}//end if($this->session->is_owner)
?>
<!-- Modal Cancel Invitation -->
<div id="confirm_si_elect_self_modal" style="display:none">
  <h4 class="modal-title">Confirmation</h4>
  <p>Are you sure you want to elect yourself as a Superintendent of an organization?</p>
  <div class="modal-footer">
    <button class="btn btn-success" type="button" data-dismiss="modal" onClick="$('#elect_si_self_frm').submit();">Ok</button>
    <button type="button" class="btn btn-default" onclick="$.fancybox.close();" >Close</button>
  </div>
</div>
<?php
	if($show_teambuilder){
		
		########################################################
		#
		# TEAM BUILDER PROCESS
		#
		########################################################

		//SHOW LIST of STAFF TO OWNER OR SI

		if($organization_details_arr['superintendent_user_id']){
			// Organization have its own SI
			
			if($this->session->owner){
?>
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <p>
    <h3><?php echo filter_string($organization_details_arr['company_name'])?></h3>
    <hr />
    </p>
  </div>
</div>
<?php
			}//end if($this->session->owner)
?>

<div class="row">
  <div class="col-sm-4 col-md-4 col-lg-4">
    <?php if($filter == 'All') { $filter_for = 'Pharmacies / Surgeries'; } else if($filter == 'P'){ $filter_for = 'Pharmacies'; } else if($filter == 'S'){ $filter_for = 'Surgeries'; } 
					if($filter!='All' && $filter!='Pharmacies / Surgeries' && $filter!='P' && $filter!='S'){?>
    <h4> Search result for: <?php echo $filter_for; ?></h4>
    <?php } else {?>
    <h4 class="no_margin" style="padding-top:5px"> Locations</h4>
    <?php } ?>
  </div>
  <div class="col-sm-2 col-md-2 col-lg-2"></div>
  <!-- Space -->
  
  <div class="col-sm-6 col-md-6 col-lg-6" style="margin-top: 5px;" >
    <div class="col-sm-4 col-md-4 col-lg-4">
      <form action="<?php echo base_url(); ?>organization/dashboard" method="post" id="list_pharmacies_surgeries_form">
        <select class="form-control" name="list_pharmacies_surgeries_filter" id="list_pharmacies_surgeries_filter">
          <option <?php echo ($filter == 'All') ? 'selected="selected"' : '' ?> value="All">All</option>
          <option <?php echo ($filter == 'P') ? 'selected="selected"' : '' ?> value="P">Pharmacies</option>
          <option <?php echo ($filter == 'S') ? 'selected="selected"' : '' ?> value="S">Surgeries</option>
        </select>
      </form>
    </div>
    <div class="col-sm-8 col-md-8 col-lg-8">
      <form action="<?php echo base_url(); ?>organization/dashboard" method="post" id="search_pharmacy_surgery_form" class="form_validate">
        <div class="input-group">
          <input id="pharmacy_surgery_search" name="pharmacy_surgery_search" type="text" placeholder="Search" class="form-control" />
          <span class="input-group-btn">
          <button class="btn btn-default" type="submit" id="search_btn" name="search_btn">Go</button>
          </span> </div>
      </form>
    </div>
  </div>
</div>
<!-- ./ row-->

<hr />
<br />
<div id="team_builder"> 
  <!-- Start - Listing ( Pharmacy / Surgery ) -->
  <?php 
if(!empty($pharmacies_surgeries)){
	$no_manager_key = array_search(0, array_column($pharmacies_surgeries, 'manager_id'));	

	if(strlen($no_manager_key) > 0){
		//One or more pharmacies DO NOT have their managers.

?>
            <p class="alert alert-info"><i class="fa fa-info-circle"></i> Now you have added a location, the last step is to add a manager of the location. This person will be in control of the day to day operations of the location's account. This will usually be a doctor, pharmacist, nurse or technician who regularly works in the location, you can also elect yourself.</p>

<?php	
	}//end if(strlen($no_manager_key) > 0)
	
	foreach($pharmacies_surgeries as $pharmacy_surgery): 
?>
  <div class="panel panel-default panel-body">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12" >
        <h4 class="text-default" style="margin:0" > 
			<?php echo ($pharmacy_surgery['pharmacy_surgery_name'] != '') ? filter_string($pharmacy_surgery['pharmacy_surgery_name']) : '' ?>, <?php echo ($pharmacy_surgery['postcode'] != '') ? filter_string($pharmacy_surgery['postcode']) : '' ?> 
            
            <span class="pharmacy_setting_link">
            <a href="<?php echo base_url(); ?>organization/edit-pharmacy-surgery/<?php echo $pharmacy_surgery['id']; ?>"  class="fancybox_view fancybox.ajax"> Edit </a>
            |
            <a type="button" class="dialogue_window" href="#myModal<?php echo $pharmacy_surgery['id']; ?>"> Delete </a>
           </span>
        </h4>
      </div>
      
    </div>
      <!-- Modal -->
      <div id="myModal<?php echo $pharmacy_surgery['id']; ?>" style="display:none">
        <h4 class="modal-title">Confirmation</h4>
        <p>Are you sure you want to delete the selected <?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> <strong><?php echo filter_string($pharmacy_surgery['pharmacy_surgery_name'])?></strong>?</p>
        <div class="modal-footer"> <a href="<?php echo base_url(); ?>organization/delete-pharmacy-surgery/<?php echo $pharmacy_surgery['id']; ?>/<?php echo $pharmacy_surgery['type'];?>" class="btn btn-danger"> Delete </a>
          <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
        </div>
      </div>
      <!-- Remove Settings -- > 
            
        <!-- ./ row-->
    <div class="row">
    	<div class="col-sm-12 col-md-12 col-lg-12"><h4 class="text-default"> Staff </h4></div>
    </div>
    
    <?php if($pharmacy_surgery['manager_id'] == 0){ 
			if(empty($pharmacy_surgery['manager_invitations'])) {
		?>
                <strong class="text-success hidden" id="self_manager_row_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> <span class="hidden" id="manager_info_span_<?php echo $pharmacy_surgery['id']; ?>"></span></strong>
                
                <div class="col-sm-10 col-md-10 col-lg-10" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
                
                	<div class="row">
                    	<div class="col-md-2 text-left" style="padding-left:0px">
                        	<button type="button" class="btn btn-sm btn-block btn-warning elect-self-view-contract" rel="<?php echo $pharmacy_surgery['type']; ?>" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" > Elect Self </button>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1" style="padding-top:2px; font-size:18px">OR</div>
                        <div class="col-md-8">
                          <div class="input-group">
                            <input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
                            <span class="input-group-btn" id="basic-addon3">
                            <button class="btn btn-sm btn-success invite-manager-staff-btn" rel="<?php echo $pharmacy_surgery['type']; ?>" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" > Invite Manager </button>
                            </span> 
                            
                            </span> </div>
                          <div id="suggesstion_box_manager<?php echo $pharmacy_surgery['id']; ?>"></div>
                        </div>
                    </div>
                </div>
                
                <!-- end row --> 
                
                <!-- Start - Manager Invitation sent DIV -->
                <div class="row hidden" id="pending_invitation_container_m_<?php echo $pharmacy_surgery['id']; ?>">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="col-sm-8 col-md-8 col-lg-8 pull-left">
                      <label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <span id="invitation_sent_to_span_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['manager_invitations'][0]['user_email_address'] != '') ? $pharmacy_surgery['manager_invitations'][0]['user_email_address'] : '' ?></span> waiting acceptence.</label>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 pull-left"> <a class="btn btn-xs btn-danger dialogue_window" href="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</a>
                      <?php 
							if(filter_string($pharmacy_surgery['manager_invitations'][0]['request_changes']) == '1'){
								//Means user have requested for the changes in the Conntract
						?>
                      <a class="btn btn-xs btn-warning invitation_contract_changes" data-target="<?php echo filter_string($pharmacy_surgery['manager_invitations'][0]['id'])?>" href="javascript:;"  type="button">Edit Contract</a>
                      <?php		
								
							}//end if($pharmacy_surgery['manager_invitations'][0]['request_changes'] == '1')
						?>
                      
                      <!-- Modal Cancel Invitation -->
                      <div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" style="display:none">
                        <h4 class="modal-title">Confirmation</h4>
                        <p>Are you sure you you want to cancel the invitation sent to manager?</p>
                        <div class="modal-footer">
                          <button class="btn btn-danger cancel-inv-btn"  type="button" data-dismiss="modal" name="" id="cancel_inv_btn_<?php echo $pharmacy_surgery['id']; ?>" value="<?php $invitation_id = 1; echo $pharmacy_surgery['id']; ?>" >Cancel Invitation</button>
                          <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-1 col-md-1 col-lg-1"></div>
                </div>
    <?php 
			} else { 
		?>
                <strong class="text-success hidden" id="self_manager_row_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> <span class="hidden" id="manager_info_span_<?php echo $pharmacy_surgery['id']; ?>"></span></strong>
                <div class="col-sm-10 col-md-10 col-lg-10 hidden" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
                	<div class="row">
                    	<div class="col-md-2 text-left" style="padding-left:0px">
                        	<button type="button" class="btn btn-warning elect-self-view-contract" rel="<?php echo $pharmacy_surgery['type']; ?>" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" > Elect Self </button>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1" style="padding-top:2px; font-size:18px">OR</div>
                        <div class="col-md-8">
                        	<div class="input-group">
                                <input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
                                
                                <span class="input-group-btn" id="basic-addon3">
                                <button class="btn btn-sm btn-success invite-manager-staff-btn" rel="<?php echo $pharmacy_surgery['type']; ?>" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite Manager</button>
                                </span>
                            </div>
                            <div id="suggesstion_box_manager<?php echo $pharmacy_surgery['id']; ?>"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Start - Manager Invitation sent DIV -->
                <div class="row" id="pending_invitation_container_m_<?php echo $pharmacy_surgery['id']; ?>">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <?php //echo '<pre>'; print_r(); ?>
                    <div class="col-sm-8 col-md-8 col-lg-8 pull-left">
                      <label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <span id="invitation_sent_to_span_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['manager_invitations'][0]['user_email_address'] != '') ? $pharmacy_surgery['manager_invitations'][0]['user_email_address'] : '' ?></span> waiting acceptence.</label>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 pull-left"><a class="btn btn-xs dialogue_window btn-danger" href="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</a>
                      <?php 
                            if(filter_string($pharmacy_surgery['manager_invitations'][0]['request_changes']) == '1'){
                                //Means user have requested for the changes in the Conntract
                        ?>
                      <a class="btn btn-xs btn-warning invitation_contract_changes" data-target="<?php echo filter_string($pharmacy_surgery['manager_invitations'][0]['id'])?>" href="javascript:;"  type="button">Edit Contract</a>
                      <?php		
                            }//end if($pharmacy_surgery['manager_invitations'][0]['request_changes'] == '1')
                        ?>
                      
                      <!-- Modal Cancel Invitation -->
                      <div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" style="display: none">
                        <h4 class="modal-title">Confirmation</h4>
                        <p>Are you sure you you want to cancel the invitation sent to manager?</p>
                        <div class="modal-footer">
                          <button class="btn btn-danger cancel-inv-btn" type="button" data-dismiss="modal" name="<?php echo $pharmacy_surgery['manager_invitations'][0]['id']; ?>" id="cancel_inv_btn_<?php echo $pharmacy_surgery['id']; ?>" value="<?php $invitation_id = 1; echo $pharmacy_surgery['id']; ?>" >Cancel Invitation</button>
                          <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-1 col-md-1 col-lg-1"></div>
                </div>
    <?php 
			} // if(!empty($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations']))
		?>
    
    <!-- Show Error Messages for the manager invitation --> 
    <span class="manager_error hidden"><br />
    <br />
    <br />
    <div class="alert alert-danger hidden" id="error_m_inv_container_<?php echo $pharmacy_surgery['id']; ?>" ></div>
    </span>
    <?php 
		} else { // if($pharmacy_surgery['manager_id'] == 0) 
	?>
    
    <!--  If manager exists -->
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12" > <strong><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> Manager (<?php echo ($pharmacy_surgery['manager_usertype'] != '') ? $pharmacy_surgery['manager_usertype'] : '' ?>) : </strong> <?php echo ($pharmacy_surgery['manager_full_name'] != '') ? ucwords($pharmacy_surgery['manager_full_name']) : '' ?> - <span class="glyphicon glyphicon-phone"></span> <?php echo ($pharmacy_surgery['manager_contact_number'] != '') ? $pharmacy_surgery['manager_contact_number'] : '' ?> - <span class="glyphicon glyphicon-envelope"></span> <?php echo ($pharmacy_surgery['manager_email'] != '') ? $pharmacy_surgery['manager_email'] : '' ?> &nbsp; &nbsp; &nbsp; <a href="<?php echo base_url();?>organization/edit-manager-staff/<?php echo $pharmacy_surgery['manager_id'];?>" class=" fancybox_view_manager fancybox.ajax"> Edit </a> | <a href="javascript:;" class="replace-manager" value="<?php echo $pharmacy_surgery['id']; ?>" > Replace </a> <br />
        <br />
        
        <!-- Start - Replace manager  -->
        <div class="row" style="display: none;" id="replace_invite_div_<?php echo $pharmacy_surgery['id']; ?>" >
          <?php if(empty($pharmacy_surgery['manager_invitations'][0])){ $invitation_response_m_class = ''; } else { $invitation_response_m_class = 'hidden'; } ?>
          <div class="row">
            <div class="col-sm-11 col-md-11 col-lg-11"> &nbsp; &nbsp; <strong class="text-success" id="self_manager_row_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['type'] == 'P') ? '' : '' ?> <span class="hidden" id="manager_info_span_<?php echo $pharmacy_surgery['id']; ?>"></span></strong> </div>
          </div>
          <div class="col-sm-10 col-md-10 col-lg-10 <?php echo $invitation_response_m_class; ?>" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
          	<div class="row">
                <div class="col-md-2 text-left">
                <button type="button" class="btn btn-warning elect-self-view-contract" rel="<?php echo $pharmacy_surgery['type']; ?>" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" > Elect Self </button>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1" style="padding-top:2px; font-size:18px">OR</div>
                <div class="col-md-8">
                    <div class="input-group">
                        <input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
                        <span class="input-group-btn" id="basic-addon3">
                        <button class="btn btn-sm btn-success invite-manager-staff-btn" rel="<?php echo $pharmacy_surgery['type']; ?>" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite Manager</button>
                        </span>  
                    </div>
                	<div id="suggesstion_box_manager<?php echo $pharmacy_surgery['id']; ?>"></div>
                </div>            	
            </div>
            
          </div>
          <?php if(!empty($pharmacy_surgery['manager_invitations'][0])){ $my_class = ''; } else { $my_class = 'hidden'; } ?>
          
          <!-- Start - Manager Invitation sent DIV -->
          <div class="row <?php echo $my_class; ?>" id="pending_invitation_container_m_<?php echo $pharmacy_surgery['id']; ?>">
            <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="col-sm-8 col-md-8 col-lg-8 pull-left">
                <label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <span id="invitation_sent_to_span_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['manager_invitations'][0]['user_email_address'] != '') ? $pharmacy_surgery['manager_invitations'][0]['user_email_address'] : '' ?></span> waiting acceptence.</label>
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4 pull-left"><a class="btn btn-xs btn-danger dialogue_window" href="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</a>
                <?php 
						if(filter_string($pharmacy_surgery['manager_invitations'][0]['request_changes']) == '1'){
							//Means user have requested for the changes in the Conntract
					?>
                <a class="btn btn-xs btn-warning invitation_contract_changes" data-target="<?php echo filter_string($pharmacy_surgery['manager_invitations'][0]['id'])?>" href="javascript:;"  type="button">Edit Contract</a>
                <?php		
						
					}//end if($pharmacy_surgery['manager_invitations'][0]['request_changes'] == '1')
				?>
                <!-- Modal Cancel Invitation -->
                <div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" style="display:none">
                  <h4 class="modal-title">Confirmation</h4>
                  <p>Are you sure you you want to cancel the invitation sent to manager?</p>
                  <div class="modal-footer">
                    <button class="btn btn-danger cancel-inv-btn" type="button" data-dismiss="modal" name="<?php echo $pharmacy_surgery['manager_invitations'][0]['id']; ?>" id="cancel_inv_btn_<?php echo $pharmacy_surgery['id']; ?>" value="<?php $invitation_id = 1; echo $pharmacy_surgery['id']; ?>" >Cancel Invitation</button>
                    <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-1 col-md-1 col-lg-1"></div>
          </div>
          <br />
          <br />
          <br />
          <div class="alert alert-danger hidden" id="error_m_inv_container_<?php echo $pharmacy_surgery['id']; ?>" ></div>
        </div>
        <!-- ./ row--> 
        <!-- End - Replace Manager --> 
        
        <!-- Manager Governance read status -->
        <div class="btn-group" role="group" aria-label="..."> 
          
          <!-- Manager Governance read status -->
          <?php if($pharmacy_surgery['governance_read_status'] == 1) { ?>
          <button type="button" class="btn btn-success btn-sm tooltip-success" data-toggle="tooltip" data-placement="top" title="This person has read and signed all SOPs." > Governance </button>

          <?php } else if($pharmacy_surgery['governance_read_status'] == 2){ // If governance is not purchased for the Pharmacy / Surgery ?>
          	<button class="btn btn-secondary btn-sm tooltip-secondary" data-toggle="tooltip" data-placement="top" title="Governance is not eligible."> Governance </button>
          <?php } else { ?>
          	<button class="btn btn-danger btn-sm tooltip-danger" data-toggle="tooltip" data-placement="top" title="This person has yet to read and sign all SOPs." > Governance </button>
          <?php } // if($pharmacy_surgery['governance_read_status'] == 1) ?>
          <div class="btn-group tooltip-info" role="group" data-toggle="tooltip" data-placement="top" title="This person has read and signed the HR contract.">
            <?php 
				if($pharmacy_surgery['manager_hr_temp_contract'] && $pharmacy_surgery['manager_hr_temp_contract']['request_changes']){
					//If User have any changes requested in temp table then show seperate color and message
			?>
            	<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Contract Changes Received <span class="caret"></span> </button>
            <?php		
				}else{
			?>
            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Contract <span class="caret"></span> </button>
         
            <?php		
				}//end if($pharmacy_surgery['manager_hr_temp_contract'])
			?>
            <ul class="dropdown-menu mydropdown-menu">
              <li> <a href="javascript:;" class="btn btn-xxs btn-info contract_view_mode" data-target="<?php echo filter_string($pharmacy_surgery['manager_hr_contract']['id'])  ?>"> View Contract</a> </li>
              <li> <a href="javascript:;" class="btn btn-xxs btn-warning contract_resend_mode" data-target="<?php echo filter_string($pharmacy_surgery['manager_hr_contract']['id']) ?>"> Resend Contract</a> </li>
            </ul>
          </div>
          
          <!-- Start - Manager [ PGDs & Trainings ]  --> 
          <!-- Start - Manager PGDs -->
          
          <?php
			$non_presriber_usertype_arr = array('2', '3');
			if($pharmacy_surgery['manager_is_prescriber'] == 0 && in_array($pharmacy_surgery['manager_usertype_id'], $non_presriber_usertype_arr)){ // if the manager is not a prescriber ?>
              <div class="btn-group tooltip-default" role="group" data-toggle="tooltip" data-placement="top" title="Here you can assign individual PGDs to staff.">
                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> PGDs <span class="caret"></span> </button>
                <ul class="dropdown-menu mydropdown-menu">
                  <?php	
					if($pharmacy_surgery['purchased_items_split_arr']['pgds']['package_purchased'] == 1 && $pharmacy_surgery['purchased_items_split_arr']['pgds']['package_expired'] == 0){
			
							if(count($oral_pgd_arr) > 0){ 
				  
								for($i=0;$i<count($oral_pgd_arr);$i++){
							
									$expiry_date = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['expiry_date'];
									$is_purchased = ($pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
									$is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
									$is_quiz_passed = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz assesment is passed marked as 1
									$doctor_approval = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after assesment
									$pharmacist_approval = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after assesment
											
									if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and assesment test is passed, doc and pharmacist have approved the PGD assesment
													
					?>
                  		<li> <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?></a> </li>
                  <?php
                                                                            
						} else {
							
							// If Purchased and not expired and assesment test is not passed
							?>
                  <li> <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?> </a> </li>
                  <?php
                                                                            
							} //end if($is_quiz_passed)
						
					} // End - for($i=0;$i<count($oral_pgd_arr);$i++) 
		   } // if(count($oral_pgd_arr) > 0)  
		
	} else { ?>
                  <li> <a href="<?php echo SURL?>organization/single-product-checkout/OP/1/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger">Oral Package <span class="glyphicon glyphicon-shopping-cart"></span></a> </li>
                  <?php
                                                
					} // End - if($pharmacy_surgery['purchased_items_split_arr']['pgds']['package_purchased'] == 1 && $pharmacy_surgery['purchased_items_split_arr']['pgds']['package_expired'] == 0)
				?>
                  <?php 	if(count($vaccine_pgd_arr) > 0){ 
                                                
									for($i=0;$i<count($vaccine_pgd_arr);$i++){
										
										$expiry_date = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['expiry_date'];
										$is_purchased = ($pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
										$is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
										$is_quiz_passed = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz assesment is passed marked as 1
										$doctor_approval = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after assesment
										$pharmacist_approval = $pharmacy_surgery['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after assesment

										if($is_purchased){
											
											if($is_expired && $expiry_date!= '0000-00-00'){
												
												if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0){ 
													//Child PGD cannot be purchased seperately they will come with the Parent PGD 
												
										?>
                 							 <li> <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a> </li>
                  <?php
												}//end if(filter_string($vaccine_pgd_arr[$i]['is_child']))
												
											}else{
                                                            
												if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and assesment test is passed, doc and pharmacist have approved the PGD assesment
												
										?>
                  <li> <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></a> </li>
                  <?php
												
											}else{
												
												// If Purchased and not expired and assesment test is not passed
									?>
                  								<li> <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></a> </li>
                  <?php
                                                                
											}//end if($is_quiz_passed)
											
										}//end if($is_expired)
										
									} else{
										//If not purchased.
										
										if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0){
											//Child PGD cannot be purchased seperately they will come with the Parent PGD 
										
									?>
                  								<li> <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a> </li>
                  <?php
                                                        
										}//end if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0)
										
									}//end if($is_purchased)
								
								} // End - for($i=0;$i<count($vaccine_pgd_arr);$i++)
								?>
                  <?php	} // if(count($vaccine_pgd_arr) > 0)  
                                        ?>
                </ul>
              </div>
          <?php	
					}
				?>
          <!-- End - Manager PGDs --> 
          <!-- Start - Manager Trainings -->
          <div class="btn-group tooltip-default" role="group" data-toggle="tooltip" data-placement="top" title="Here you can assign individual training packages to staff." >
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Training <span class="caret"></span> </button>
            <ul class="dropdown-menu mydropdown-menu">
            
              <?php	
				$training_courses_arr = $pharmacy_surgery['manager_training_courses_arr'];
				if(count($training_courses_arr) > 0){
					for($i=0;$i<count($training_courses_arr);$i++){
					
						$expiry_date = $pharmacy_surgery['purchased_items_split_arr']['training'][$training_courses_arr[$i]['id']]['expiry_date'];
						$is_purchased = ($pharmacy_surgery['purchased_items_split_arr']['training'][$training_courses_arr[$i]['id']]) ? 1 : 0; //If this Training Videos is puchased mark as 1.
						$is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If Training Videos is expired marked as 1
					
						//If Training is purchased 
						if($is_purchased){
							
							if($is_expired && $expiry_date!= '0000-00-00'){
								
								//If training is purchased but expired
					?>
									<li> <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a> </li>
					<?php
													
							} else {
								
								//If training is purchased and not expired
								
								if(filter_string($purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]['is_quiz_passed']) == 1){
					?>
									<li> <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></a> </li>
					<?php
																
								} else {
									
					?>
									<li> <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></a> </li>
					<?php
																	
								} // end if(filter_string($training_courses_arr[$i]['is_quiz_passed']) == 1)
					
							} //end if($is_expired && $expiry_date!= '0000-00-00')
								
						} else {
							
							//If training are not purchased yet	
													?>
									<li> <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a> </li>
					<?php
															
						} //end if($is_purchased)
					
					} // for($i=0;$i<count($training_courses_arr);$i++)            
				}else{
			?>
            		
            <?php		
				}//end if(count($training_courses_arr) > 0)
			?>
            </ul>
          </div>
        </div>
        <div id="overlay_addtobasket" class="overlay hidden">
          <div class="col-md-12 text-center" style="margin-top:150px;"></div>
        </div>
        
        <!-- End - Manager Trainings --> 
        <!-- Start - Manager [ PGDs & Trainings ]  --> 
        <?php 
			$count_no_of_staff = count($pharmacy_surgery['pharmacy_surgery_staff']);
		?>
        <button class="btn btn-xs btn-default expand-btn <?php echo ($count_no_of_staff > 5) ? '' : 'hidden'?>" onClick="expand_me(<?php echo $pharmacy_surgery['id']; ?>);" > + Expand </button>
        <div id="expand_pharmacy_<?php echo $pharmacy_surgery['id']; ?>" style=" <?php echo ($count_no_of_staff > 5) ? 'display: none;' : ''?> " > 
          
        <!--
            <label onClick="toggle_staff(< ?php echo $pharmacy_surgery['id']; ?>);" >
                <h4 class="text-primary">
                    <span class="glyphicon glyphicon-triangle-bottom"></span>Staff
                </h4>
            </label>
            --> 
          
          <br />
          
          <!-- Start - View Pharmacy / Surgery Staff -->
          <div id="view_staff_<?php echo $pharmacy_surgery['id']; ?>" style="display:block;"> 
            
            <!-- Staff of Pharmacy / Surgery -->
            <?php 
				if(!empty($pharmacy_surgery['pharmacy_surgery_staff'])){ 
					foreach($pharmacy_surgery['pharmacy_surgery_staff'] as $member): 
					
			?>
           		<label> <?php echo ($member['staff_member_user_type'] != '' ) ? $member['staff_member_user_type'] : '' ?> : </label>
            <?php echo ($member['staff_member_full_name'] != '' ) ? ucwords($member['staff_member_full_name']) : '' ?> - <span class="glyphicon glyphicon-phone"></span> <?php echo ($member['staff_member_contact_number'] != '' ) ? $member['staff_member_contact_number'] : '' ?> - <span class="glyphicon glyphicon-envelope"></span> <?php echo ($member['staff_member_contact_email'] != '' ) ? $member['staff_member_contact_email'] : '' ?> &nbsp; &nbsp; &nbsp; <a href="<?php echo base_url();?>organization/edit-manager-staff/<?php echo $member['staff_member_id'];?>" class=" fancybox_view_manager fancybox.ajax"> Edit </a> | <a class="dialogue_window" href="#confirm-delete-<?php echo $member['staff_member_row_id']; ?>">Delete </a> <br />
            <div id="confirm-delete-<?php echo $member['staff_member_row_id']; ?>" style="display:none" >
              <h4>Confirmation</h4>
              <h5>Are you sure you want to delete the <strong><?php echo $member['staff_member_user_type'].' '.														ucwords(filter_string($member['staff_member_full_name']))?></strong>?</h5>
              <div class="modal-footer"> <a href="<?php echo base_url(); ?>organization/delete-staff-member/<?php echo $member['staff_member_row_id']; ?>" class="btn btn-danger btn-ok">Delete</a>
                <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
              </div>
            </div>
            
            <!-- Staff Member's Governance read status -->
            <div class="btn-group" role="group" aria-label="...">
              <?php if($member['staff_member_governance_read_status'] == 1) { ?>
              <button type="button" class="btn btn-success btn-sm tooltip-success" data-toggle="tooltip" data-placement="top" title="This person has read and signed all SOPs." > Governance </button>
              <?php } else if($member['staff_member_governance_read_status'] == 2){ // If governance is not purchased for the Pharmacy / Surgery ?>
              <button class="btn btn-secondary btn-sm tooltip-secondary" data-toggle="tooltip" data-placement="top" title="Governance is not eligible."> Governance </button>
              <?php } else { ?>
              <button class="btn btn-danger btn-sm tooltip-danger" data-toggle="tooltip" data-placement="top" title="This person has yet to read and sign all SOPs." > Governance </button>
              <?php } // if($pharmacy_surgery['governance_read_status'] == 1) ?>
              <div class="btn-group tooltip-info" role="group" data-toggle="tooltip" data-placement="top" title="This person has read and signed the HR contract.">
                <?php 
						if($member['staff_member_hr_temp_contract'] && $member['staff_member_hr_temp_contract']['request_changes']){
							
							//If User have any changes requested in temp table then show seperate color and message
					?>
                <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Contract Changes Received <span class="caret"></span> </button>
                <?php		
						}else{
					?>
             
                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contract <span class="caret"></span></button>
             
                <?php		
					}//end if($pharmacy_surgery['manager_hr_temp_contract'])
				?>
                <ul class="dropdown-menu mydropdown-menu">
                  <li> <a href="javascript:;" class="btn btn-xxs btn-info contract_view_mode" data-target="<?php echo filter_string($member['staff_member_hr_contract']['id']) ?>"> View Contract</a> </li>
                  <li> <a href="javascript:;" class="btn btn-xxs btn-warning contract_resend_mode" data-target="<?php echo filter_string($member['staff_member_hr_contract']['id']) ?>"> Resend Contract</a> </li>
                </ul>
              </div>
              
              <!-- Start - Staff [ PGDs & Trainings ]  --> 
              
              <!-- Start - Staff PGDs -->
              <?php 
														
				$non_presriber_usertype_arr = array('2', '3');
				
				if($member['staff_member_is_prescriber'] == 0 && in_array($member['staff_member_user_type_id'], $non_presriber_usertype_arr)){ ?>
                  <div class="btn-group tooltip-default" role="group" data-toggle="tooltip" data-placement="top" title="Here you can assign individual PGDs to staff.">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> PGDs <span class="caret"></span> </button>
                    <ul class="dropdown-menu mydropdown-menu">
                      <?php 
						if($member['purchased_items_split_arr']['pgds']['package_purchased'] == 1 && $member['purchased_items_split_arr']['pgds']['package_expired'] == 0){
						
							if(count($oral_pgd_arr) > 0){
								
								for($i=0;$i<count($oral_pgd_arr);$i++){
								
									$expiry_date = $member['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['expiry_date'];
									$is_purchased = ($member['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
									$is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
									$is_quiz_passed = $member['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz assesment is passed marked as 1
									$doctor_approval = $member['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after assesment
									$pharmacist_approval = $member['purchased_items_split_arr']['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after assesment
											
									if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and assesment test is passed, doc and pharmacist have approved the PGD assesment
										
										?>
						<li> <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?></span></a> </li>
						<?php
										
									} else {
										
										// If Purchased and not expired and assesment test is not passed
										?>
						<li> <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?></span></a> </li>
						<?php
										
									} //end if($is_quiz_passed)
									
								} // End - for($i=0;$i<count($oral_pgd_arr);$i++) 
									
							} // if(count($oral_pgd_arr) > 0)  
								
						} else {
                                                                    
                   ?>
                      <li> <a href="<?php echo SURL?>organization/single-product-checkout/OP/1/<?php echo filter_string($member['staff_member_id']) ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger">Oral Package <span class="glyphicon glyphicon-shopping-cart"></span></a> </li>
                      <?php
                                                                    
                  	} // End - if($member['purchased_items_split_arr']['pgds']['package_purchased'] == 1 && $member['purchased_items_split_arr']['pgds']['package_expired'] == 0)
                                                                
					if(count($vaccine_pgd_arr) > 0){
						$x = 0;
						for($i=0;$i<count($vaccine_pgd_arr);$i++){
							
							$expiry_date = $member['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['expiry_date'];
							$is_purchased = ($member['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
							$is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
							$is_quiz_passed = $member['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz assesment is passed marked as 1
							$doctor_approval = $member['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after assesment
							$pharmacist_approval = $member['purchased_items_split_arr']['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after assesment

							if($is_purchased){
								
								if($is_expired && $expiry_date!= '0000-00-00'){

									if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0){
										//Child PGD cannot be purchased seperately they will come with the Parent PGD 
									
							?>
<li> <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
<?php
									}//end if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0)
									
								}else{
									
									if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and assesment test is passed, doc and pharmacist have approved the PGD assesment
									
										?>
<li> <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></span></a> </li>
<?php
										
									}else{

										// If Purchased and not expired and assesment test is not passed
										?>
<li> <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></span></a> </li>
</button>
<?php
									}//end if($is_quiz_passed)
									
								}//end if($is_expired)
								
							} else{
								//If not purchased.

									if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0){
										//Child PGD cannot be purchased seperately they will come with the Parent PGD 																		
								?>
<li> <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
<?php
									}//end if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0)
								
							}//end if($is_purchased)
							
							$x ++;
							
						} // End - for($i=0;$i<count($vaccine_pgd_arr);$i++)
						
					} // if(count($vaccine_pgd_arr) > 0)  
                ?>
                    </ul>
                  </div>
              <?php
				} // if($member['staff_member_is_prescriber'] == 0) 
				?>
              <!-- End - Staff PGDs --> 
              <!-- Start - Staff Trainings -->
              <div class="btn-group tooltip-default" role="group" data-toggle="tooltip" data-placement="top" title="Here you can assign individual training packages to staff.">
                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Training <span class="caret"></span> </button>
                <ul class="dropdown-menu mydropdown-menu">
                  <?php	
						$training_courses_arr = $member['staff_member_training_courses_arr'];				  
						if(count($training_courses_arr) > 0){
							for($i=0;$i<count($training_courses_arr);$i++){
							
								$expiry_date = $member['purchased_items_split_arr']['training'][$training_courses_arr[$i]['id']]['expiry_date'];
								$is_purchased = ($member['purchased_items_split_arr']['training'][$training_courses_arr[$i]['id']]) ? 1 : 0; //If this Training Videos is puchased mark as 1.
								$is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If Training Videos is expired marked as 1
							
								//If Training is purchased 
								if($is_purchased){
									
									if($is_expired && $expiry_date!= '0000-00-00'){
										
							//If training is purchased but expired
							?>
											<li> <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
							<?php
															
										} else {
										
										//If training is purchased and not expired
										if(filter_string($purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]['is_quiz_passed']) == 1){
									?>
											<li> <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></span></a> </li>
							<?php
										} else {
							?>
											<li> <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></span></a> </li>
							<?php
										} // end if(filter_string($training_courses_arr[$i]['is_quiz_passed']) == 1)
	
									} //end if($is_expired && $expiry_date!= '0000-00-00')
										
								} else {
									
									//If training are not purchased yet	
							?>
									<li> <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
							<?php
																	
								} //end if($is_purchased)
						 
							} // for($i=0;$i<count($training_courses_arr);$i++) 
														
						}else{
				?>
                			<li><a href="javascript:;" class="btn btn-xxs btn-danger"> No Training Purchased </a></li>
                <?php			
						}//end if(count($training_courses_arr) > 0)
				?>
                </ul>
              </div>
              
            </div>
            <div id="overlay_addtobasket" class="overlay hidden">
              <div class="col-md-12 text-center" style="margin-top:150px;"></div>
            </div>
            <!-- End - Staff Trainings --> 
            <!-- Start - Staff PGDs --> 
            <!-- End - Staff [ PGDs & Trainings ]  --><!-- End - Staff [ PGDs & Trainings ]  --> 
            <br />
            <br />
            <?php endforeach; // end - foreach($pharmacy_surgery['pharmacy_surgery_staff'] as $member): 
													
			}else{
			?>
            	<p class="alert alert-danger">No Staff Members are in this Pharmacy</p>
            <?php														
				}// end - if(!empty($pharmacy_surgery['pharmacy_surgery_staff'])) 
				
				if(!empty($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'])){ 
			?>
            <h4 class="text-info">Pending Invitations: </h4>
					<?php 
                        foreach($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'] as $pending_invitation): 
                                                                        
                            if($pending_invitation['invitation_type'] != 'M' || $pending_invitation['invitation_type'] != 'SI' ){ 
                            // : Pending Invitations 
                    ?>
            
            <!-- Start - List Pending Invitation of Staff --> 
            <span id="staff_pending_invitation_span_<?php echo $pending_invitation['id']; ?>"> 
            
            <!-- Pending Invitations of Pharmacy / Surgery Staff -->
              <?php 
			  // <label class="text-danger">Pending invitation for - if($pending_invitation['user_type'] == 'DO' ) { echo 'Doctor'; } elseif($pending_invitation['user_type'] == 'PH' ) { echo 'Pharmacist'; } elseif($pending_invitation['user_type'] == 'NU' ) { echo 'Nurse'; } elseif($pending_invitation['user_type'] == 'PA' ) { echo 'Pharmacist Assistant'; } elseif($pending_invitation['user_type'] == 'TE' ) { echo 'Technician'; } elseif($pending_invitation['user_type'] == 'PR' ) { echo 'Pre-Reg'; } elseif($pending_invitation['user_type'] == 'NH' ) { echo 'Non Health Professionals'; } echo '<span class="text-primary" > - '.$pending_invitation['user_email_address'].' </strong>';  </label> ?>
            
            
			<label class="text-danger "> Awaiting Contract Agreement - <?php echo filter_string($pending_invitation['user_email_address'])?></label>
            <a type="button" class="btn btn-danger btn-xs dialogue_window offset_left_10" id="delete_staff_btn_<?php echo $pending_invitation['id']; ?>" href="#delete_staff_modal_<?php echo $pending_invitation['id']; ?>">Delete</a> 
            <a class="btn btn-xs btn-warning dialogue_window" href="#resend_inv<?php echo $pending_invitation['id']; ?>" >Resend Invite</a>
            <!-- Modal -->
            <div id="delete_staff_modal_<?php echo $pending_invitation['id']; ?>" style="display:none" >
              <h4 class="modal-title">Confirmation</h4>
              <p>Are you sure you want to delete this invitation?</p>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-staff-invite" value="<?php echo $pending_invitation['id']; ?>" >Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$.fancybox.close()">Close</button>
              </div>
            </div>
            
            <?php 
					if(filter_string($pending_invitation['request_changes']) == '1'){
						//Means user have requested for the changes in the Conntract
				?>
                		<a class="btn btn-xs btn-info invitation_contract_changes" data-target="<?php echo filter_string($pending_invitation['id'])?>" href="javascript:;"  type="button">Edit Contract</a>
                <?php		
						
					}//end if($pharmacy_surgery['manager_invitations'][0]['request_changes'] == '1')
				?>
            
            <!-- Modal -->
            <div id="resend_inv<?php echo $pending_invitation['id']; ?>" style="display:none">
              <h4 class="modal-title">Confirmation</h4>
              <p>Are you sure you want to Resend the invitation ?</p>
              <div class="modal-footer">
                <button class="btn btn-success resend-staff-invite-btn" value="<?php echo $pending_invitation['id']; ?>" >Resend Invite</button>
                <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
              </div>
            </div>
            
            </span> 
            <!-- End - List Pending Invitation of Staff -->
            <br />
            <?php 
					}//end if($pending_invitation['invitation_type'] != 'M' || $pending_invitation['invitation_type'] != 'SI' )  
			
			endforeach; // End - foreach($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'] as $pending): 
			
			} // End - if(!empty($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'])) ?>
            
          </div>
          <!-- End - View Pharmacy / Surgery Staff -->
          
          <button class="btn btn-sm btn-success add-staff-btn pull-right  <?php echo ($count_no_of_staff > 5) ? '' : 'hidden'?>" onClick="toggle_add_staff(<?php echo $pharmacy_surgery['id']; ?>);" ><i class="fa fa-plus"></i> Add New Staff </button>
          
        </div>
      </div>
    </div>
    <!-- ./ row-->
    
    <div class="row" id="add_staff_<?php echo $pharmacy_surgery['id']; ?>" style=" <?php echo ($count_no_of_staff > 5) ? 'display: none;' : ''?>" >
    	<hr />
        <div class="col-md-12">
        	<h4 class="text-default">Add New Staff</h4>
        	<div class="row">
            	<div class="col-md-12">
                	<p class="alert alert-info"><i class="fa fa-info-circle"></i> In this section, you can invite other staff members to work within your locations team. Again, you can elect yourself to work within the location or you can select the job type of the staff member and send them an invite email. </p>

                </div>
            </div>
            <div class="row">
            	<div class="col-md-12">
                    
                    <div class="col-sm-2 col-md-2 col-lg-2" style="padding:0">
                        <button type="button" class="btn btn-warning elect-self-view-contract btn-block" rel="<?php echo $pharmacy_surgery['type']; ?>" name="ST" value="<?php echo $pharmacy_surgery['id']; ?>" > Elect Self </button>
                    </div>
                    <div class="col-sm-1 col-md-1 col-lg-1 text-right add_staff_or">OR</div>
                    <div class="col-sm-9 col-md-9 col-lg-9">
                        <div class="input-group">
                      <select id="select_invitation_type_<?php echo $pharmacy_surgery['id']; ?>" name="select_invitation_type" class="form-control" >
                        <option value="">Please select Job Type</option>
                        <option value="DO">Doctor</option>
                        <option value="PH">Pharmacist</option>
                        <option value="NU">Nurse</option>
                        <option value="PA">Pharmacy Assistant</option>
                        <option value="TE">Technician</option>
                        <option value="PR">Pre-reg</option>
                        <option value="NH">Non Health Professional</option>
                      </select>
                      <span class="input-group-addon" style="background-color: #fff;">Email</span>
                      <input type="hidden" id="pharmacy_surgery_hidden_id_<?php echo $pharmacy_surgery['id']; ?>" value="<?php echo $pharmacy_surgery['id']; ?>">
                      <input class="form-control input-md inv-email inv-input-email-address" name="ST" id="staff_email_address_<?php echo $pharmacy_surgery['id']; ?>" required="required" type="email" placeholder="Email Address" />
                      <div id="suggesstion_box_<?php echo $pharmacy_surgery['id']; ?>"></div>
                      <span class="input-group-btn" id="basic-addon3">
                      <button class="btn btn-md btn-success invite-manager-staff-btn" rel="<?php echo $pharmacy_surgery['type']; ?>" name="ST" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite</button>
                      </span>   </div>
                          
                    </div><br />
                    <div class="row" style="margin-top:10px">
                    	<br />
                    	<div class="col-sm-12 col-md-12 col-lg-12 offset_top_10 alert alert-danger alert-success pull-right hidden" id="error_message_span_<?php echo $pharmacy_surgery['id']; ?>"></div>
                          </div>
                
                </div>
            </div>
        </div>
    </div>
    <?php } // else - if($pharmacy_surgery['manager_id'] == 0) ?>
  </div>
  <?php 
	endforeach; // foreach($pharmacies_surgeries as $pharmacy_surgery) 
 } else { 
?>
  <div class="panel panel-default panel-body text-danger">No record found for <?php echo $filter_for; ?>.</div>
<?php } // else - if(!empty($pharmacies_surgeries)) ?>
</div>
<!-- /. <div id="team_builder" > --> 
<!-- End - Listing ( Pharmacy / Surgery ) --> 

<!-- Start - Add New Pharmacy / Sergery -->
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6"></div>
  <div class="col-sm-6 col-md-6 col-lg-6"> <a href="<?php echo base_url(); ?>organization/edit-pharmacy-surgery" class="btn btn-sm btn-primary pull-right fancybox_view fancybox.ajax "><i class="fa fa-plus"></i> Add Pharmacy / Surgery </a> 
    <!--<button class="btn btn-sm btn-success pull-right" type="button" id="add_pharmacy_surgery_btn" onClick="toggle_add_pharmacy_surgery_btn();" >Add Pharmacy / Surgery</button>--> 
  </div>
</div>
<!-- ./ row--> 

<!-- ////////////////////////// End /////////////////////// -->

<?php			
		}//end if($organization_details_arr['superintendent_user_id'])
		
	}elseif($show_governance){
		
		if($user_org_superintendent){
		//Governance is not passed
		
		if(!$this->session->is_owner){
?>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <p>
                <h3><?php echo filter_string($organization_details_arr['company_name'])?></h3>
                <hr />
                </p>
              </div>
            </div>
            
<?php 
		}//end if(!$this->session->owner)
?>
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12"> 
    <!-- Start - Governance tabs -->
    <h4>Governance</h4>
    <hr />
    
    <!-- Stat - Governance tabs -->
    <!--
    <ul class="nav nav-tabs">
      < ?php 
						//This is for SI, when he enforce any SOP to read again and when SI is asked to read the SOP first too, then he will see the SOP TAB first instead of Governance Tab, this will work just for once and on refresh will revert back to normal ((:
						$governance_active_tab = 'active';
						$governance_active_container = 'in active';
						$sop_active_tab = '';
						$sop_active_container = '';
						
						if($this->session->sop_tab){
							$governance_active_tab = '';
							$governance_active_container = '';
							$sop_active_tab = 'active';
							$sop_active_container = 'in active';
							
							$this->session->sop_tab = 0;
						}//end if($this->session->sop_tab)
					?>
      <li id="gov_tab" class="< ?php echo $governance_active_tab?>"><a data-toggle="tab" href="#governance">Governance</a></li>
      <li id="hr_tab"><a data-toggle="tab" href="#hr">HR</a></li>
      <li id="sop_tab" class="< ?php echo $sop_active_tab?>"><a data-toggle="tab" href="#sops">SOPs</a></li>
      <li id="fin_tab"><a data-toggle="tab" href="#finish">Finish</a></li>
     
    </ul> -->
    
    <!-- Start - Governance tabs body -->
        <div id="sops">
        <p><?php echo filter_string($organization_governance_arr['sop_text'])?></p>
        <p>
        <style>
          .tree li a{ color:#FFF }
			    .tree li{ font-weight:normal; color:#5CB85C; }
        </style>
        
        <ul id="governance_sop_read_tree" class="tree text-primary">
        <?php 
            if(count($organization_sop_list) > 0){
                foreach($organization_sop_list as $category_name =>$nodes_arr){
                    
                    $split_category_name = explode('#',$category_name);
                    
                    if($category_name != 'None'){
                        
                        if(count($nodes_arr) > 0){
?>
       							 <li id="li_cat_<?php echo $split_category_name[0]?>"><a href="#" id="cat_<?php echo $split_category_name[0]?>" style="font-weight:bold;color:#5CB85C"><?php echo filter_string($split_category_name[1]);?></a>
        <ul>
<?php		
        for($i=0;$i<count($nodes_arr);$i++){
?>
        	<li style="font-weight:normal" id="li_cat_list_<?php echo filter_string($nodes_arr[$i]['id'])?>">
<?php 					
            echo filter_string($nodes_arr[$i]['sop_title']);
        
            $index_key = array_search(filter_string($nodes_arr[$i]['id']), array_column($user_sop_read_list, 'sop_id'));
            if(is_numeric($index_key)){
              $pharmacy_surgery_id = $user_sop_read_list[$index_key]['pharmacy_surgery_id'];
?>
              <a class="btn btn-xxs btn-success" href="<?php echo SURL?>/organization/download-read-and-signed-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>/<?php echo filter_string($pharmacy_surgery_id)?>" title="Download SOP"><i class="fa fa-certificate"></i> Download</a>
<?php						
            } else {
?>
							<script>
                  //Function highlight_governance_unread_sop(cat_id): Used in governance reading section to highlight the unread SOP
                  $('#cat_<?php echo $split_category_name[0]?>').css({'color':'#F00'});
                  $('#li_cat_<?php echo $split_category_name[0]?>').css({'color':'#F00'});

            			$('#li_cat_list_<?php echo filter_string($nodes_arr[$i]['id'])?>').css({'color':'#F00'});
              </script>

              <span id="read_btn_<?php echo filter_string($nodes_arr[$i]['id'])?>"><a href="<?php echo SURL?>organization/read-and-sign-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>" class="fancybox_read_and_sign_sop fancybox.ajax" >
              <button class="btn btn-xxs btn-danger" type="button" title="Read and Sign"><i class="fa fa-book"></i> Read and Sign</button>
              </a></span>
<?php

            }//end if(array_search(filter_string($nodes_arr[$i]['id']), array_column($user_sop_read_list, 'id')))
?>
        </li>
<?php
          }//end for
?>
        </ul>
        </li>
        <?php
                        }//end if(count($nodes_arr) > 0)
                        
                    }//end if($category_name != 'None')
                }//end foreach($organization_sop_list as $category_name =>$nodes_arr)
                
                for($i=0;$i<count($organization_sop_list['None']);$i++){
            ?>
        <li style="font-weight:normal">
        <?php 
                        echo filter_string($organization_sop_list['None'][$i]['sop_title']);
                        $index_key = array_search(filter_string($organization_sop_list['None'][$i]['id']), array_column($user_sop_read_list, 'sop_id'));
                        if(is_numeric($index_key)){
                            $pharmacy_surgery_id = $user_sop_read_list[$index_key]['pharmacy_surgery_id'];
            ?>
        <a class="btn btn-xxs btn-success white_link" href="<?php echo SURL?>/organization/download-read-and-signed-sop/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>/<?php echo filter_string($pharmacy_surgery_id)?>" title="Download SOP"><i class="fa fa-certificate"></i> Download</a>
        <?php				
                        }else{
            ?>
        <span id="read_btn_<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>"><a href="<?php echo SURL?>organization/read-and-sign-sop/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>" class="fancybox_read_and_sign_sop fancybox.ajax" >
        <button class="btn btn-xxs btn-danger" type="button" title="Read and Sign"><i class="fa fa-book"></i> Read and Sign</button>
        </a></span>
        <?php				
                        }//end if(is_numeric($index_key))
                        
                }//end for
            }else{
            ?>
        <p>
        <div role="alert" class="alert alert-danger">No SOP's Available!</div>
        </p>
        <?php	
            }//end if(count($organization_sop_list) > 0)
            ?>
        </ul>
        </p>
        </div>

  </div>
  <!-- End Col--> 
</div>
<!-- End Row-->
<hr />
<?php		
		}//end if($user_org_superintendent)
		
	}//end if($show_teambuilder) : End - Show Governance

	if($this->session->is_prescriber == 0 && in_array($this->session->user_type,$non_presriber_usertype_arr) ){	
		//Need to show the intro video.
?>
<a class="fancybox-media hidden" id="non_prescribers_intro_video" href="<?php echo $this->session->dashboard_video_url?>"></a>
<?php	
	}//end if($this->session->is_prescriber == 0 && in_array($this->session->user_type,$non_presriber_usertype_arr) )
?>
<script>var activate_dashboard_fancy = <?php echo ($this->session->is_prescriber == 0 && in_array($this->session->user_type,$non_presriber_usertype_arr) && $this->session->is_intro_video_watched == 0) ? 1 : 0?>;</script> 

<!-- Script to show tooltips -->
<script>
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
  });
</script>