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

            <textarea id="governance_hr_textarea" name="governance_hr_text" class="textarea" placeholder="Enter SOP Description" style="width: 800px; height: 400px"></textarea>
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
            <textarea id="governance_edit_inv_contract_textarea" name="governance_edit_inv_contract_text" class="textarea" placeholder="Enter SOP Description" style="width: 800px; height: 400px"></textarea>
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
	if($this->session->flashdata('err_message') || $this->session->error_message){
?>
	<div class="alert alert-danger">
		<?php echo ($this->session->flashdata('err_message')) ? $this->session->flashdata('err_message') : '' ; ?>
		<?php echo ($this->session->error_message) ? $this->session->error_message : '' ; ?>
	</div>
<?php
	
	$this->session->unset_userdata('error_message');
	}//end if($this->session->flashdata('err_message'))
	
	if($this->session->flashdata('ok_message')  || $this->session->okay_message){
?>
	<div class="alert alert-success alert-dismissable">
		<?php echo ($this->session->flashdata('ok_message')) ? $this->session->flashdata('ok_message') : '' ; ?>
		<?php echo ($this->session->okay_message) ? $this->session->okay_message : '' ; ?>
			
	</div>
<?php 
	
	$this->session->unset_userdata('okay_message');
	} //if($this->session->flashdata('ok_message'))
	
	if($member_wellcome_dashboard_view){
		
		// Instructions on default view
		if($show_instructions && $show_instructions == 1){
?>
		<div class="well">
			<div class="row">
			
				<div class="col-sm-12 col-md-12 col-lg-12">
					<h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ surgeries. Please choose pharmacy/ surgery you want to work with from the dropdown above. </h4>
				</div>
				
			</div>
		</div>
		
<?php	}
		
	} else {
	
		// Governance is read by this user of the selected Pharmacy / Surgery
		if($governance_read == 1){
			
			// echo '<br /> Governance is read by this user for this Pharmacy / Surgery [OR] Governance is not purchased for this Pharmacy / Surgery <br />';
			$show_team = 1;
			$show_governance = 0;
			
		} else {
			
			// echo '<br /> Governance is not read <br />';
			$show_team = 0;
			$show_governance = 1;
			
		} //  End - if($governance_read == 1)
		
		?>
		
		<?php if($show_governance == 1){ ?>
		
			<!--<div class="row"><div class="col-sm-12 col-md-12 col-lg-12"><p><h3><?php echo filter_string($organization_details_arr['company_name'])?></h3><hr /></p></div></div>-->
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- Start - Governance tabs -->
					<h3 class="no_margin">Governance</h3>
					<hr />
				  
					<!-- Stat - Governance tabs -->
                    <!--
					<ul class="nav nav-tabs">
					
						<li id="gov_tab" class="active"><a data-toggle="tab" href="#governance">Governance</a></li>
						<li id="hr_tab"><a data-toggle="tab" href="#hr">HR</a></li>
						<li id="sop_tab"><a data-toggle="tab" href="#sops">SOPs</a></li>
						<li id="fin_tab"><a data-toggle="tab" href="#finish">Finish</a></li>
					
					</ul>
					-->
					<!-- Start - Governance tabs body -->
					<div id="sops">
							<p><?php echo filter_string($organization_governance_arr['sop_text'])?></p>
							<p>
								<style>
									.tree li{ font-weight:normal; }
									.tree li a{ color:#FFF }
									
								</style>
								<ul id="governance_sop_read_tree" class="tree text-primary">
								
								<?php 
									if(count($organization_sop_list) > 0){
										foreach($organization_sop_list as $category_name =>$nodes_arr){
											
											$split_category_name = explode('#',$category_name);
											
											if($category_name != 'None'){
												
												if(count($nodes_arr) > 0){
?>

                                                	<li id="li_cat_<?php echo $split_category_name[0]?>"><a id="cat_<?php echo $split_category_name[0]?>" href="#" style="font-weight:bold;color:#369"><?php echo filter_string($split_category_name[1]);?></a> 
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
																	<a class="btn btn-xxs btn-success white_link" href="<?php echo SURL?>/organization/download-read-and-signed-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>/<?php echo filter_string($pharmacy_surgery_id)?>" title="Download SOP"><i class="fa fa-certificate"></i> Download</a>
<?php
																} else {
?>
<script>
																	//Function highlight_governance_unread_sop(cat_id): Used in governance reading section to highlight the unread SOP
																	$('#cat_<?php echo $split_category_name[0]?>').css({'color':'#F00'});
																	$('#li_cat_<?php echo $split_category_name[0]?>').css({'color':'#F00'});
																	$('#li_cat_list_<?php echo filter_string($nodes_arr[$i]['id'])?>').css({'color':'#F00'});
                                                                </script>
																	<span id="read_btn_<?php echo filter_string($nodes_arr[$i]['id'])?>"><a href="<?php echo SURL?>organization/read-and-sign-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>/<?php echo $pharmacy_surgery_id; ?>" class="fancybox_read_and_sign_sop fancybox.ajax" ><button class="btn btn-xxs btn-danger" type="button" title="Read and Sign"><i class="fa fa-book"></i> Read and Sign</button></a></span>
<?php
																}//end if(array_search(filter_string($nodes_arr[$i]['id']), array_column($user_sop_read_list, 'id')))
?>
															</li>
<?php
														} //end for
									?>				
												</ul>
												</li>
									<?php
												} // End -  if(count($nodes_arr) > 0){
											
											}//end if($category_name != 'None')

										}//end foreach($organization_sop_list as $category_name =>$nodes_arr)

										for($i=0;$i<count($organization_sop_list['None']);$i++){
									?>
											<li style="font-weight:normal"><i class="glyphicon glyphicon-file"></i> 
									<?php 
												echo filter_string($organization_sop_list['None'][$i]['sop_title']);
												$index_key = array_search(filter_string($organization_sop_list['None'][$i]['id']), array_column($user_sop_read_list, 'sop_id'));
												if(is_numeric($index_key)){
													$pharmacy_surgery_id = $user_sop_read_list[$index_key]['pharmacy_surgery_id'];
									?>
													<a class="btn btn-xs btn-success" href="<?php echo SURL?>/organization/download-read-and-signed-sop/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>/<?php echo filter_string($pharmacy_surgery_id)?>" title="Download SOP"><i class="fa fa-certificate"></i> Download</a>
									<?php				
												}else{
									?>
													<span id="read_btn_<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>"><a href="<?php echo SURL?>organization/read-and-sign-sop/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>" class="fancybox_read_and_sign_sop fancybox.ajax" ><button class="btn btn-xs btn-danger" type="button"><i class="fa fa-book"></i> Read and Sign</button></a></span>
									<?php				
												}//end if(is_numeric($index_key))
												
										}//end for
									}else{
									?>
										 <p><div role="alert" class="alert alert-danger">No SOP's Available!</div></p>  
									<?php	
									}//end if(count($organization_sop_list) > 0)
									?>
								</ul>
							</p>
						</div>
				</div><!-- End Col-->
			</div><!-- End Row-->
			
		
		<?php  } else if($show_team == 1){
			
				if($is_manager == 1){
					
					if(!empty($pharmacies_surgeries)){ ?>
					
					<!-- <strong>Im manager in this pharmacy/surgery</strong><br /> -->
						<?php //if($is_staff) { echo '<strong>Im staff too in this pharmacy/surgery</strong><br /><br />'; } ?>
						
						<!--
						<hr />
						<br />

						<div class="alert alert-info">

							<h4 class="text-info">Note! Below buttons are describing the actions of each color.</h4>
							<button class="btn btn-sm btn-danger"> <strong> Not Purchased </strong> </button>
							<button class="btn btn-sm btn-success"> <strong> Purchased and Passed </strong> </button>
							<button class="btn btn-sm btn-warning"> <strong> Purchased but not Passed </strong> </button>
							<button class="btn btn-sm btn-info"> <strong> Not Eligible </strong> </button>

						</div>
						-->

						
					<?php foreach($pharmacies_surgeries as $pharmacy_surgery): ?>
								
                         <div class="panel panel-default panel-body">
                            <div class="row">
                              <div class="col-sm-12 col-md-12 col-lg-12" >
                                <h4 class="text-default" style="margin:0" > 
                                    <?php echo (filter_string($pharmacy_surgery['pharmacy_surgery_name']) != '') ? filter_string($pharmacy_surgery['pharmacy_surgery_name']) : '' ?>, <?php echo ($pharmacy_surgery['postcode'] != '') ? $pharmacy_surgery['postcode'] : '' ?>
                                    
                                    <span class="pharmacy_setting_link">
                                    <a href="<?php echo base_url(); ?>organization/edit-pharmacy-surgery/<?php echo $pharmacy_surgery['id']; ?>" class=" fancybox_view fancybox.ajax"> Edit </a>
                                   </span>
                                </h4>
                              </div>
                              
                            </div>                         
                            
    
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12"><h4 class="text-default"> Staff </h4></div>
                            </div>
    
                            <?php if($pharmacy_surgery['manager_id'] == 0){ 
                                        if(empty($pharmacy_surgery['manager_invitations'])) { 
                            ?>
                                                <strong class="text-success hidden" id="self_manager_row_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> <span class="hidden" id="manager_info_span_<?php echo $pharmacy_surgery['id']; ?>"></span></strong>
                                                
                                                <div class="col-sm-8 col-md-8 col-lg-8" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
                                                    
                                                    <div class="input-group">
                                                    
                                                        <input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
                                                        
                                                        
                                                        <span class="input-group-btn" id="basic-addon3">
                                                            <button class="btn btn-sm btn-success invite-manager-staff-btn" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite Manager</button>
                                                        </span>
                                                        
                                                        <span class="input-group-addon" style="background-color: #fff;">OR</span>
    
                                                        <span class="input-group-btn" id="basic-addon3">
                                                        
                                                            <!-- Trigger the modal with a button -->
                                                            <a type="button" class="btn btn-warning btn-sm dialogue_window" href="#myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>">Elect Self</a>
                                    
                                                            <!-- Modal -->
                                                            <div id="myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>" style="display:none">
                                                                
                                                                <h4 class="modal-title">Confirmation</h4>
                                                                <h5>Are you sure you want to elect yourself as the manager ? </h5>
                                                                    
                                                                <div class="modal-footer">
                                                                
                                                                    <button class="btn btn-success manager-elect-self-btn" value="<?php echo $pharmacy_surgery['id']; ?>" >Ok</button>
                                                                    <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                                                                
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div id="suggesstion_box_manager<?php echo $pharmacy_surgery['id']; ?>"></div>
                                                </div> 
                                                
                                            <!-- end row -->
                                        
                                            <!-- Start - Manager Invitation sent DIV -->
                                            <div class="row hidden" id="pending_invitation_container_m_<?php echo $pharmacy_surgery['id']; ?>">
                                                
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    
                                                    <div class="col-sm-8 col-md-8 col-lg-8 pull-left"><label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <span id="invitation_sent_to_span_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['manager_invitations'][0]['user_email_address'] != '') ? $pharmacy_surgery['manager_invitations'][0]['user_email_address'] : '' ?></span> waiting acceptence.</label></div>
                                                    <div class="col-sm-3 col-md-3 col-lg-3 pull-left"><a class="btn btn-xs btn-danger dialogue_window" href="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</a>
    
                                                        <!-- Modal Cancel Invitation -->
                                                        <div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" style="display:none" >
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
                                                    
                                            <div class="col-sm-8 col-md-8 col-lg-8 hidden" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
                                                <div class="input-group">
                                                    <input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
                                                    <span class="input-group-btn" id="basic-addon3">
                                                        <button class="btn btn-sm btn-success invite-manager-staff-btn" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite Manager</button>
                                                    </span>
                                                    <span class="input-group-addon" style="background-color: #fff;">OR</span>
                                                    <span class="input-group-btn" id="basic-addon3">
                                                    
                                                        <!-- Trigger the modal with a button -->
                                                        <a type="button" class="btn btn-warning btn-sm dialogue_window" href="#myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>">Elect Self</a>
                                
                                                        <!-- Modal -->
                                                        <div id="myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>" style="display:none"> 
                                                            <h4 class="modal-title">Confirmation</h4>
                                                            <h5>Are you sure you want to elect yourself as the manager ? </h5>
                                                            <div class="modal-footer">
                                                        
                                                                <button class="btn btn-success manager-elect-self-btn" data-dismiss="modal" value="<?php echo $pharmacy_surgery['id']; ?>" >Ok</button>
                                                                <button type="button" class="btn btn-default" onclick="$.fancybox.close()" >Close</button>
                                                        
                                                          </div>
                                                        </div>
                                                    </span>
                                                </div>
                                                
                                                <div id="suggesstion_box_manager<?php echo $pharmacy_surgery['id']; ?>"></div>
                                            </div> 
                                                
                                            <!-- Start - Manager Invitation sent DIV -->
                                            <div class="row" id="pending_invitation_container_m_<?php echo $pharmacy_surgery['id']; ?>">
                                                
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <?php //echo '<pre>'; print_r(); ?>
                                                    <div class="col-sm-8 col-md-8 col-lg-8 pull-left"><label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <span id="invitation_sent_to_span_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['manager_invitations'][0]['user_email_address'] != '') ? $pharmacy_surgery['manager_invitations'][0]['user_email_address'] : '' ?></span> waiting acceptence.</label></div>
                                                    <div class="col-sm-3 col-md-3 col-lg-3 pull-left"><a class="btn btn-xs btn-danger dialogue_window" href="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</a>
    
                                                        <!-- Modal Cancel Invitation -->
                                                        <div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" style="display:none" >
                                                            <h4 class="modal-title">Confirmation</h4>
                                                            <p>Are you sure you you want to cancel the invitation sent to manager?</p>
                                                            <div class="modal-footer">
                                                            
                                                                <button class="btn btn-danger cancel-inv-btn" type="button" data-dismiss="modal" name="<?php echo $pharmacy_surgery['manager_invitations'][0]['id']; ?>" id="cancel_inv_btn_<?php echo $pharmacy_surgery['id']; ?>" value="<?php $invitation_id = 1; echo $pharmacy_surgery['id']; ?>" >Cancel Invitation</button>
                                                                <button type="button" class="btn btn-default" onclick="$.fancybox.close()" >Close</button>
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
                                    <span class="manager_error hidden"><br /><br /><br /><div class="alert alert-danger hidden" id="error_m_inv_container_<?php echo $pharmacy_surgery['id']; ?>" ></div></span>
                                
                            <?php 
                                } else { // if($pharmacy_surgery['manager_id'] == 0) 
                            ?>
                            
                            <!--  If manager exists -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12" >
                                        
                                        <strong><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> Manager (<?php echo ($pharmacy_surgery['manager_usertype'] != '') ? $pharmacy_surgery['manager_usertype'] : '' ?>) : </strong> <?php echo ($pharmacy_surgery['manager_full_name'] != '') ? ucwords($pharmacy_surgery['manager_full_name']) : '' ?> - <span class="glyphicon glyphicon-phone"></span> <?php echo ($pharmacy_surgery['manager_contact_number'] != '') ? $pharmacy_surgery['manager_contact_number'] : '' ?> - <span class="glyphicon glyphicon-envelope"></span> <?php echo ($pharmacy_surgery['manager_email'] != '') ? $pharmacy_surgery['manager_email'] : '' ?> &nbsp; &nbsp; &nbsp; <a href="<?php echo base_url();?>organization/edit-manager-staff/<?php echo $pharmacy_surgery['manager_id'];?>" class=" fancybox_view_manager fancybox.ajax"> Edit </a> 
    
                                            <!-- &nbsp; <a href="javascript:;" class="replace-manager" value="< ?php echo $pharmacy_surgery['id']; ?>" > Replace </a> -->
                                        <br />
                                        
                                        <!-- Start - Replace manager  -->
                                        <div class="row hidden" id="replace_invite_div_<?php echo $pharmacy_surgery['id']; ?>" >
                                            
                                            <?php if(empty($pharmacy_surgery['manager_invitations'][0])){ $invitation_response_m_class = ''; } else { $invitation_response_m_class = 'hidden'; } ?>
                                            
                                                <div class="row">
                                                    <div class="col-sm-11 col-md-11 col-lg-11">
                                                        &nbsp; &nbsp; <strong class="text-success" id="self_manager_row_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['type'] == 'P') ? '' : '' ?> <span class="hidden" id="manager_info_span_<?php echo $pharmacy_surgery['id']; ?>"></span></strong>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 col-md-8 col-lg-8 <?php echo $invitation_response_m_class; ?>" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
                                                    
                                                    <div class="input-group">
                                                    
                                                        <input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
                                                        
                                                        <span class="input-group-btn" id="basic-addon3">
                                                            <button class="btn btn-sm btn-success invite-manager-staff-btn" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite Manager</button>
                                                        </span>
                                                        
                                                        <span class="input-group-addon" style="background-color: #fff;" >OR</span>
    
                                                        <span class="input-group-btn" id="basic-addon3">
                                                        
                                                            <!-- Trigger the modal with a button -->
                                                            <a type="button" class="btn btn-warning btn-sm dialogue_window" href="#myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>">Elect Self</a>
                                    
                                                            <!-- Modal -->
                                                            <div id="myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>" style="display:none">
                                                                
                                                                <h4 class="modal-title">Confirmation</h4>
                                                                <h5>Are you sure you want to elect yourself as the manager ? </h5>
                                                                <div class="modal-footer">
                                                                
                                                                    <button class="btn btn-success manager-elect-self-btn" data-dismiss="modal" value="<?php echo $pharmacy_surgery['id']; ?>" >Ok</button>
                                                                    <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
                                                                
                                                                </div>
                                                            </div>
                                                            
                                                        </span>
                                                        
                                                    </div>
                                                    <div id="suggesstion_box_manager<?php echo $pharmacy_surgery['id']; ?>"></div>
                                                </div> 
                                                
                                            <?php if(!empty($pharmacy_surgery['manager_invitations'][0])){ $my_class = ''; } else { $my_class = 'hidden'; } ?>
                                            
                                            <!-- Start - Manager Invitation sent DIV -->
                                            <div class="row <?php echo $my_class; ?>" id="pending_invitation_container_m_<?php echo $pharmacy_surgery['id']; ?>">
                                                
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                
                                                        <div class="col-sm-8 col-md-8 col-lg-8 pull-left"><label class="text-danger" id="pending_inv_txt" >Invitation has been sent to <span id="invitation_sent_to_span_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['manager_invitations'][0]['user_email_address'] != '') ? $pharmacy_surgery['manager_invitations'][0]['user_email_address'] : '' ?></span> waiting acceptence.</label></div>
                                                        <div class="col-sm-3 col-md-3 col-lg-3 pull-left"><a class="btn btn-xs btn-danger dialogue_window" href="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</a>
                                                    
                                                        <!-- Modal Cancel Invitation -->
                                                        <div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" style="display:none" >
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
                                            
                                            <br /><br /><br />
                                            <div class="alert alert-danger hidden" id="error_m_inv_container_<?php echo $pharmacy_surgery['id']; ?>" ></div>
                                        </div>
                                        <!-- end row -->
                                        <!-- End - Replace Manager -->
                                        
                                        <!-- Manager Governance read status -->
                                        <div class="btn-group" role="group" aria-label="...">
                                            
                                                 <!-- Manager Governance read status -->
                                                <?php if($pharmacy_surgery['governance_read_status'] == 1) { ?>
                                                        <button type="button" class="btn btn-success btn-sm tooltip-success" data-toggle="tooltip" data-placement="top" title="This person has read and signed all SOPs."> Governance </button>
                                                <?php } else if($pharmacy_surgery['governance_read_status'] == 2){ // If governance is not purchased for the Pharmacy / Surgery ?> 
                                                        <button class="btn btn-secondary btn-sm toolti-secondary" data-toggle="tooltip" data-placement="top" title="The governance is not eligible."> Governance </button> 
                                                <?php } else { ?>
                                                    <button class="btn btn-danger btn-sm tooltip-danger" data-toggle="tooltip" data-placement="top" title="This person has yet to read and sign all SOPs."> Governance </button>
                                                <?php } // if($pharmacy_surgery['governance_read_status'] == 1) ?>   
                                                <div class="btn-group tooltip-info" role="group" data-toggle="tooltip" data-placement="top" title="This person has read and signed the HR contract.">
                                                    <?php 
                                                        if($pharmacy_surgery['manager_hr_temp_contract'] && $pharmacy_surgery['manager_hr_temp_contract']['request_changes']){
                                                            //If User have any changes requested in temp table then show seperate color and message
                                                    ?>
                                                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                             Contract Changes Received <span class="caret"></span>
                                                        </button>                                                
                                                    <?php		
                                                        }else{
                                                    ?>

                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                         Contract <span class="caret"></span>
                                                        </button>												
                                                    <?php		
                                                        }//end if($pharmacy_surgery['manager_hr_temp_contract'])
                                                    ?>
                                                    
                                                    <ul class="dropdown-menu mydropdown-menu">
                                                        <li>
                                                            <a href="javascript:;" class="btn btn-xxs btn-info contract_view_mode" data-target="<?php echo filter_string($pharmacy_surgery['manager_hr_contract']['id'])  ?>"> View Contract</a>
                                                        </li>
                                                         <li>
                                                            <a href="javascript:;" class="btn btn-xxs btn-warning contract_resend_mode" data-target="<?php echo filter_string($pharmacy_surgery['manager_hr_contract']['id']) ?>"> Resend Contract</a>                                                     
                                                         </li>
                                                    </ul>
                                                </div>                                                   
                                                        
                                                <!-- Start - Manager [ PGDs & Trainings ]  -->
                                                <!-- Start - Manager PGDs -->
                                        
                                                <?php
                                                        $non_presriber_usertype_arr = array('2', '3');
                                                        if($pharmacy_surgery['manager_is_prescriber'] == 0 && in_array($pharmacy_surgery['manager_usertype_id'], $non_presriber_usertype_arr)){ // if the manager is not a prescriber ?>
                                                        <div class="btn-group tooltip-default" role="group" data-toggle="tooltip" data-placement="top" title="Here you can assign individual PGDs to staff.">
                                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                PGDs <span class="caret"></span>
                                                            </button>
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
                                                                             <li>
                                                                             <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?></a>
                                                                            </li>
                                                                            <?php
                                                                            
                                                                        } else {
                                                                            
                                                                            // If Purchased and not expired and assesment test is not passed
                                                                            ?>
                                                                            <li>
                                                                             <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?> </a>
                                                                             </li>
                                                                            <?php
                                                                            
                                                                        } //end if($is_quiz_passed)
                                                                    
                                                                } // End - for($i=0;$i<count($oral_pgd_arr);$i++) 
                                                       } // if(count($oral_pgd_arr) > 0)  
                                                    
                                            } else { ?>
                                                             <li>
                                                                <a href="<?php echo SURL?>organization/single-product-checkout/OP/1/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger">Oral Package <span class="glyphicon glyphicon-shopping-cart"></span></a>
                                                            </li>
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
                                                            
                                                             <li>
                                                            <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a>
                                                            </li>
                                                    <?php
                                                            }//end if(filter_string($vaccine_pgd_arr[$i]['is_child']))
                                                            
                                                        }else{
                                                            
                                                            if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and assesment test is passed, doc and pharmacist have approved the PGD assesment
                                                            
                                                    ?>
                                                                <li>
                                                                <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></a>
                                                                </li>
                                                    <?php
                                                                
                                                            }else{
                                                                
                                                                // If Purchased and not expired and assesment test is not passed
                                                    ?>
                                                                <li>
                                                                <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></a>
                                                                </li>
                                                    <?php
                                                                
                                                            }//end if($is_quiz_passed)
                                                            
                                                        }//end if($is_expired)
                                                        
                                                    } else{
                                                        //If not purchased.
                                                        
                                                        if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0){
                                                            //Child PGD cannot be purchased seperately they will come with the Parent PGD 
                                                        
                                                    ?>
                                                            <li>
                                                            <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a>
                                                            </li>
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
                                                        <div class="btn-group tooltip-default" role="group" data-toggle="tooltip" data-placement="top" title="Here you can assign individual training packages to staff.">
                                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Training <span class="caret"></span>
                                                            </button>
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
                                                                <li>
                                                                <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a>
                                                                </li>
                                                    <?php
                                                    
                                                            } else {
                                                                
                                                                //If training is purchased and not expired
                                                                
                                                                if(filter_string($purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]['is_quiz_passed']) == 1){
                                                    ?>
                                                    
                                                                <li>
                                                                    <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></a>
                                                                </li>
                                                    <?php
                                                                
                                                                } else {
                                                                    
                                                    ?>
                                                                     <li>
                                                                    <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></a>
                                                                </li>
                                                    <?php
                                                                    
                                                                } // end if(filter_string($training_courses_arr[$i]['is_quiz_passed']) == 1)
            
                                                            } //end if($is_expired && $expiry_date!= '0000-00-00')
                                                                
                                                        } else {
                                                            
                                                            //If training are not purchased yet	
                                                    ?>
                                                             <li>
                                                            <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $pharmacy_surgery['manager_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a>
                                                            </li>
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
                                        
                                        <!-- End - Manager Trainings -->
                                        <!-- Start - Manager [ PGDs & Trainings ]  -->
                                        <br />
                                        <?php 
                                            $count_no_of_staff = count($pharmacy_surgery['pharmacy_surgery_staff']);
                                        ?>									
                                        <button class="btn btn-xs btn-default expand-btn <?php echo ($count_no_of_staff > 5) ? '' : 'hidden'?>" onClick="expand_me(<?php echo $pharmacy_surgery['id']; ?>);" > + Expand </button>
                                        
                                        <div id="expand_pharmacy_<?php echo $pharmacy_surgery['id']; ?>" style=" <?php echo ($count_no_of_staff > 5) ? 'display: none;' : ''?> " >
                
                                                <!--
                                                <label onClick="toggle_staff(< ?php echo $pharmacy_surgery['id']; ?>);" >
                                                    <h4 class="text-primary">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span> Staff
                                                    </h4>
                                                </label>
                                                -->
                                                
                                                <br />
                                                
                                                <!-- Start - View Pharmacy / Surgery Staff -->
                                                <div id="view_staff_<?php echo $pharmacy_surgery['id']; ?>" style="display:block;">
                                                
                                                    <!-- Staff of Pharmacy / Surgery -->
                                                    <?php if(!empty($pharmacy_surgery['pharmacy_surgery_staff'])){ ?>
                                                    
                                                        <?php foreach($pharmacy_surgery['pharmacy_surgery_staff'] as $member): ?>                                                          
                                                            <label> <?php echo ($member['staff_member_user_type'] != '' ) ? $member['staff_member_user_type'] : '' ?> : </label> <?php echo ($member['staff_member_full_name'] != '' ) ? ucwords($member['staff_member_full_name']) : '' ?> - <span class="glyphicon glyphicon-phone"></span> <?php echo ($member['staff_member_contact_number'] != '' ) ? $member['staff_member_contact_number'] : '' ?> - <span class="glyphicon glyphicon-envelope"></span> <?php echo ($member['staff_member_contact_email'] != '' ) ? $member['staff_member_contact_email'] : '' ?> &nbsp; &nbsp; &nbsp; <a href="<?php echo base_url();?>organization/edit-manager-staff/<?php echo $member['staff_member_id'];?>" class=" fancybox_view_manager fancybox.ajax"> Edit </a> |
                                                            <a class="dialogue_window" href="#confirm-delete-<?php echo $member['staff_member_row_id']; ?>">Delete </a>
                                                            
                                                            <br />
                                                            <div id="confirm-delete-<?php echo $member['staff_member_row_id']; ?>" style="display:none" >
                                                                <h4>Confirmation</h4>
                                                                <h5>Are you sure you want to delete the <strong><?php echo $member['staff_member_user_type'].' '.ucwords(filter_string($member['staff_member_full_name']))?></strong>?</h5>
                                                                <div class="modal-footer">
                                                                    <a href="<?php echo base_url(); ?>organization/delete-staff-member/<?php echo $member['staff_member_row_id']; ?>" class="btn btn-danger btn-ok">Delete</a>
                                                                    <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Staff Member's Governance read status -->
                                                             <div class="btn-group" role="group" aria-label="...">
                                                            <?php if($member['staff_member_governance_read_status'] == 1) { ?>
                                                                    <button type="button" class="btn btn-success btn-sm tooltip-success" data-toggle="tooltip" data-placement="top" title="This person has read and signed all SOPs."> Governance </button>
                                                            <?php } else if($member['staff_member_governance_read_status'] == 2){ // If governance is not purchased for the Pharmacy / Surgery ?> 
                                                                    <button class="btn btn-secondary btn-sm tooltip-secondary" data-toggle="tooltip" data-placement="top" title="The governance is not eligible."> Governance </button> 
                                                            <?php } else { ?>
                                                                <button class="btn btn-danger btn-sm tooltip-danger" data-toggle="tooltip" data-placement="top" title="This person has yet to read and sign all SOPs."> Governance </button>
                                                            <?php } // if($pharmacy_surgery['governance_read_status'] == 1) ?>      
                                                            <div class="btn-group tooltip-info" role="group" data-toggle="tooltip" data-placement="top" title="This person has read and signed the HR contract.">
                                                            <?php 
                                                            
                                                                if($member['staff_member_hr_temp_contract'] && $member['staff_member_hr_temp_contract']['request_changes']){
                                                                    
                                                                    //If User have any changes requested in temp table then show seperate color and message
                                                            ?>
                                                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                     Contract Changes Received <span class="caret"></span>
                                                                </button>                                                
                                                            <?php		
                                                                }else{
                                                            ?>

                                                            	    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contract <span class="caret"></span></button>
                                                                

                                                            <?php		
                                                                }//end if($pharmacy_surgery['manager_hr_temp_contract'])
                                                            ?>
    
                                                                <ul class="dropdown-menu mydropdown-menu">
                                                                    <li>
                                                                        <a href="javascript:;" class="btn btn-xxs btn-info contract_view_mode" data-target="<?php echo filter_string($member['staff_member_hr_contract']['id']) ?>"> View Contract</a>
                                                                    </li>
                                                                     <li>
                                                                        <a href="javascript:;" class="btn btn-xxs btn-warning contract_resend_mode" data-target="<?php echo filter_string($member['staff_member_hr_contract']['id']) ?>"> Resend Contract</a>
                                                                    </li>
                                                                </ul>
                                                            </div>                                                   
                                                                  
                                                            
                                                            <!-- Start - Staff [ PGDs & Trainings ]  -->
                                                            
                                                            <!-- Start - Staff PGDs -->
                                                            <?php 
                                                            
                                                            $non_presriber_usertype_arr = array('2', '3');
                                                            
                                                            if($member['staff_member_is_prescriber'] == 0 && in_array($member['staff_member_user_type_id'], $non_presriber_usertype_arr)){ ?>					<div class="btn-group tooltip-default" role="group" data-toggle="tooltip" data-placement="top" title="Here you can assign individual PGDs to staff.">
                                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                PGDs <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu mydropdown-menu">
                                                                
                                                           <?php if($member['purchased_items_split_arr']['pgds']['package_purchased'] == 1 && $member['purchased_items_split_arr']['pgds']['package_expired'] == 0){
                                                
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
                                                                                 <li>
                                                                                  <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?></span></a>
                                                                                </li>
                                                                        
                                                                                <?php
                                                                                
                                                                            } else {
                                                                                
                                                                                // If Purchased and not expired and assesment test is not passed
                                                                                ?>
                                                                                <li>
                                                                                  <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?></span></a>
                                                                                </li>
                                                                        
                                                                                <?php
                                                                                
                                                                            } //end if($is_quiz_passed)
                                                                            
                                                                        } // End - for($i=0;$i<count($oral_pgd_arr);$i++) 
                                                                            
                                                                    } // if(count($oral_pgd_arr) > 0)  
                                                                        
                                                                } else {
                                                                    
                                                                    ?>
                                                                    <li>
                                                                    <a href="<?php echo SURL?>organization/single-product-checkout/OP/1/<?php echo filter_string($member['staff_member_id']) ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger">Oral Package <span class="glyphicon glyphicon-shopping-cart"></span></a>
                                                                    </li>
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
                                                                                <li>
                                                                                <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
                                                                        <?php
                                                                                }//end if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0)
                                                                                
                                                                            }else{
                                                                                
                                                                                if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and assesment test is passed, doc and pharmacist have approved the PGD assesment
                                                                                
                                                                                    ?>
                                                                                    <li>
                                                                                    <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></span></a>
                                                                                </li>
                                                                                    <?php
                                                                                    
                                                                                }else{
    
                                                                                    // If Purchased and not expired and assesment test is not passed
                                                                                    ?>
                                                                                    <li>
                                                                                  <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?></span></a>
                                                                                </li>
                                                                                     </button>
                                                                                    <?php
                                                                                    
                                                                                }//end if($is_quiz_passed)
                                                                                
                                                                            }//end if($is_expired)
                                                                            
                                                                        } else{
                                                                            //If not purchased.
    
                                                                                if(filter_string($vaccine_pgd_arr[$i]['is_child']) == 0){
                                                                                    //Child PGD cannot be purchased seperately they will come with the Parent PGD 																		
                                                                            ?>
                                                                             <li>
                                                                            <a href="<?php echo SURL?>organization/single-product-checkout/P/<?php echo $vaccine_pgd_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
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
                                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Training <span class="caret"></span>
                                                            </button>
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
                                                                             <li>
                                                                            <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
                                                                            <?php
                                                                
                                                                        } else {
                                                                            
                                                                            //If training is purchased and not expired
                                                                            
                                                                            if(filter_string($purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]['is_quiz_passed']) == 1){
                                                                            
                                                                                ?>
                                                                                 <li>
                                                                                  <a href="javascript:;" class="btn btn-xxs btn-success"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></span></a>
                                                                                </li>
                                                                                <?php
                                                                            
                                                                            } else {
                                                                                
                                                                                ?>
                                                                                 <li>
                                                                                  <a href="javascript:;" class="btn btn-xxs btn-warning"><?php echo filter_string($training_courses_arr[$i]['course_name'])?></span></a>
                                                                                </li>
                                                                                <?php
                                                                                
                                                                            } // end if(filter_string($training_courses_arr[$i]['is_quiz_passed']) == 1)
    
                                                                        } //end if($is_expired && $expiry_date!= '0000-00-00')
                                                                            
                                                                    } else {
                                                                        
                                                                        //If training are not purchased yet	
                                                                        ?>
                                                                         <li>
                                                                        <a href="<?php echo SURL?>organization/single-product-checkout/T/<?php echo $training_courses_arr[$i]['id']?>/<?php echo $member['staff_member_id'] ?>/<?php echo $pharmacy_surgery['id'] ?>" class="btn btn-xxs btn-danger"> <?php echo filter_string($training_courses_arr[$i]['course_name'])?> <span class="glyphicon glyphicon-shopping-cart"></span> </a></li>
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
                                                            
                                                            <!-- End - Staff [ PGDs & Trainings ]  --><!-- End - Staff [ PGDs & Trainings ]  -->
                                                            <br /><br />
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
                                                                   
                                                                   <!-- <label class="text-danger">Pending invitation for < ?php if($pending_invitation['user_type'] == 'DO' ) { echo 'Doctor'; } elseif($pending_invitation['user_type'] == 'PH' ) { echo 'Pharmacist'; } elseif($pending_invitation['user_type'] == 'NU' ) { echo 'Nurse'; } elseif($pending_invitation['user_type'] == 'PA' ) { echo 'Pharmacist Assistant'; } elseif($pending_invitation['user_type'] == 'TE' ) { echo 'Technician'; } elseif($pending_invitation['user_type'] == 'PR' ) { echo 'Pre-Reg'; } elseif($pending_invitation['user_type'] == 'NH' ) { echo 'Non Health Professionals'; } echo '<span class="text-primary" > - '.$pending_invitation['user_email_address'].' </strong>';  ?> </label> -->
                                                                   <label class="text-danger "> Awaiting Contract Agreement - <?php echo filter_string($pending_invitation['user_email_address'])?></label>
                                                                    <a type="button" class="btn btn-danger btn-xs dialogue_window offset_left_10" id="delete_staff_btn_<?php echo $pending_invitation['id']; ?>" href="#delete_staff_modal_<?php echo $pending_invitation['id']; ?>">Delete</a>
                                                                    <!-- Modal -->
                                                                    <div id="delete_staff_modal_<?php echo $pending_invitation['id']; ?>" style="display:none" >
                                                                        <h4 class="modal-title">Confirmation</h4>
                                                                        <p>Are you sure you want to delete this invitation ?</p>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger delete-staff-invite" data-dismiss="modal" value="<?php echo $pending_invitation['id']; ?>" >Delete</button>
                                                                                <button type="button" class="btn btn-default" onclick="$.fancybox.close()" >Close</button>
                                                                            </div>
                                                                    </div>
                                                                    
                                                                    <a class="btn btn-xs btn-warning dialogue_window" href="#resend_inv<?php echo $pending_invitation['id']; ?>" >Resend Invite</a>
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
                                                                            <button class="btn btn-success resend-staff-invite-btn" value="<?php echo $pending_invitation['id']; ?>" data-dismiss="modal" >Resend Invite</button>
                                                                            <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                                                                        </div>
                                                                    </div>
                                                                    <br />
                                                                    
                                                                </span>
                                                                <!-- End - List Pending Invitation of Staff -->
                                                            
                                                            <?php 
                                                                }//end if($pending_invitation['invitation_type'] != 'M' || $pending_invitation['invitation_type'] != 'SI' )  
                                                            ?>
                                                            
                                                        <?php 
                                                        
                                                        endforeach; // End - foreach($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'] as $pending): ?>
                                                        
                                                    <?php } // End - if(!empty($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'])) ?>
                                                    
                                                </div>
                                                <!-- End - View Pharmacy / Surgery Staff -->
                                                
                                                <button class="btn btn-sm btn-success pull-right add-staff-btn <?php echo ($count_no_of_staff > 5) ? '' : 'hidden'?>" onClick="toggle_add_staff(<?php echo $pharmacy_surgery['id']; ?>);" ><i class="fa fa-plus"></i> Add New Staff </button>
                                                <br />
                                                
                                        </div>
    
                                    </div>
                                    
                                </div>
                                
                                <div class="row" id="add_staff_<?php echo $pharmacy_surgery['id']; ?>" style=" <?php echo ($count_no_of_staff > 5) ? 'display: none;' : ''?> " >
                                <hr />
                                	<div class="col-md-12">
                                        <h4 class="text-default">Add New Staff</h4>
                                        <div class="col-sm-2 col-md-2 col-lg-2" style="padding:0">
                                            <button type="button" class="btn btn-warning btn-block elect-self-view-contract" rel="<?php echo $pharmacy_surgery['type']; ?>" name="ST" value="<?php echo $pharmacy_surgery['id']; ?>" > Elect Self </button>
                                            <!-- Modal Cancel Invitation -->
                                            <div id="elect_self_staff_modal_<?php echo $pharmacy_surgery['id']; ?>" style="display:none">
                                                <div class="modal-title"> <h4> Confirmation </h4></div>
                                                <h5>Are you sure you you want to Elect yourself as a satff member in this Pharmacy / Surgery?</h5>
                                                  
                                                  <div class="modal-footer">
                                                    <button class="btn btn-success elect-self-staff" value="<?php echo $pharmacy_surgery['id']; ?>" >Elect Self</button>
                                                    <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button>
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-md-1 col-lg-1 text-right add_staff_or" >OR</div>
                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                            <div class="input-group">
                                                <select id="select_invitation_type_<?php echo $pharmacy_surgery['id']; ?>" name="select_invitation_type" class="form-control">
                                                    <option value="">Please select Job Type</option>
                                                    <option value="DO"> Doctor </option>
                                                    <option value="PH"> Pharmacist </option>
                                                    <option value="NU"> Nurse </option>
                                                    <option value="PA"> Pharmacy Assistant </option>
                                                    <option value="TE"> Technician </option>															
                                                    <option value="PR"> Pre-reg </option>															
                                                    <option value="NH"> Non Health Professional </option>
                                                </select>
                                                <span class="input-group-addon" style="background-color: #fff;">Email</span>
                                                <input type="hidden" id="pharmacy_surgery_hidden_id_<?php echo $pharmacy_surgery['id']; ?>" value="<?php echo $pharmacy_surgery['id']; ?>">
                                                <input class="form-control input-md inv-email inv-input-email-address" name="ST" id="staff_email_address_<?php echo $pharmacy_surgery['id']; ?>" required="required" type="email" placeholder="Enter Email Address" />
                                                <div id="suggesstion_box_<?php echo $pharmacy_surgery['id']; ?>"></div>
                                                <span class="input-group-btn" id="basic-addon3">
                                                    <button class="btn btn-success invite-manager-staff-btn" rel="<?php echo $pharmacy_surgery['type']; ?>" name="ST" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite</button>
                                                </span>
                                                    
                                                <span class="input-group-btn" id="basic-addon3">
                                                    <!-- <a class="btn btn-warning dialogue_window"  href="#elect_self_staff_modal_< ?php echo $pharmacy_surgery['id']; ?>">Elect Self</a> -->
                                                </span>
                                            </div>
                                            <br />
                                            <br />
                                            
                                        </div>
                                        <div class="row" style="margin-top:10px">
                                                <div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger alert-success pull-right hidden" id="error_message_span_<?php echo $pharmacy_surgery['id']; ?>"></div>
                                            </div>
                                    </div>
                                </div>
                            <?php } // else - if($pharmacy_surgery['manager_id'] == 0) ?>
                        </div>
								
						<?php endforeach; // foreach($pharmacies_surgeries as $pharmacy_surgery) ?>
						
						<?php } // if(!empty($pharmacies_surgeries))
			} else if($is_staff == 1){

				// if($is_staff) { echo '<strong>Im member staff in this pharmacy/surgery</strong><br /><br />'; } 
				
			} //if($is_staff == 1)
		
		} // if($show_governance == 1) 
		
	} // if(!empty($member_wellcome_dashboard_view)) ?>

<!-- Script to show tooltips -->
<script>
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
  });
</script>