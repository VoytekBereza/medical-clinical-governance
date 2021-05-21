<!-- Start - Listing ( Pharmacy / Surgery ) -->

    <?php 
    
    if($this->input->post('pharmacy')!='')
        $search_keyword = $this->input->post('pharmacy');
    else 
        $search_keyword = "All";
    ?>    
    <h5> <?php echo 'Search results for: '." ".$search_keyword;?><br /></h5>			
    <?php if(!empty($pharmacies_surgeries)){?>
			<?php //echo '<pre>'; print_r($pharmacies_surgeries); exit; ?>
			<?php foreach($pharmacies_surgeries as $pharmacy_surgery): ?>
					
					<div class="panel panel-default panel-body">
						<div class="row">
							<div class="col-sm-8 col-md-8 col-lg-8" >
								<label class="text-primary"> <?php echo ($pharmacy_surgery['pharmacy_surgery_name'] != '') ? $pharmacy_surgery['pharmacy_surgery_name'] : '' ?>, <?php echo ($pharmacy_surgery['postcode'] != '') ? $pharmacy_surgery['postcode'] : '' ?> </label>
							</div>
							
							<div class="col-sm-4 col-md-4 col-lg-4">
								<div class="col-sm-4 col-md-4 col-lg-4">
									 <a href="<?php echo base_url(); ?>organization/edit-pharmacy-surgery/<?php echo $pharmacy_surgery['id']; ?>" class="btn btn-xs btn-block btn-success fancybox_view fancybox.ajax"> Edit </a>
								</div>
								
								<div class="col-sm-8 col-md-8 col-lg-8">
									
									<!-- Trigger the Delete modal -->
									<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal<?php echo $pharmacy_surgery['id']; ?>">Delete</button>
			
									<!-- Modal -->
									<div id="myModal<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
									  <div class="modal-dialog">
			
										<!-- Modal content-->
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Confirm ! </h4>
										  </div>
										  <div class="modal-body">
											<p>Are you sure you want to delete ?.</p>
										  </div>
										  <div class="modal-footer">
											
											<a href="<?php echo base_url(); ?>organization/delete-pharmacy-surgery/<?php echo $pharmacy_surgery['id']; ?>/<?php echo $pharmacy_surgery['type'];?>" class="btn btn-danger"> Yes </a>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											
										  </div>
										</div>
									  </div>
									</div>
									
									<!-- Trigger the Settings Modal -->
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#pharmacy_settings<?php echo $pharmacy_surgery['id']; ?>">Settings</button>
			
									<!-- Modal -->
                                    
									<div id="pharmacy_settings<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
                                     <form action="<?php echo SURL?>organization/settings-process" class="form_validate" method="POST" enctype="multipart/form-data"> 
									 
                                      <div class="modal-dialog">
			
										<!-- Modal content-->
										<div class="modal-content">
											
											<!--
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Settings </h4>
											</div>
											-->
											
											<div class="modal-body">
												<!-- Pharmacy / Surgery Settings -->
												<div class="row">
													<div class="col-md-12">
														<div class="panel panel-default"> 
														
															<!-- Default panel contents -->
															<div class="panel-heading"><strong><?php echo ($pharmacy_surgery['type'] == 'P') ? 'PHARMACY' : 'SURGERY' ?> GLOBAL SETTINGS</strong></div>
															<div class="panel-body">
																<p class="align-left"></p>
																<div class="row">
																	<div class="col-md-12">
																		
																			<!-- Start - Global Settings -->
																			<div class="row">
																				<div class="col-sm-4 col-md-4 col-lg-4">
																					<input type="checkbox" class="kod-switch" name="governance_status" id="governance_status" value="1" <?php echo ($pharmacy_surgery['global_settings']['governance_status']) ? 'checked="checked"' : ''?>>
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-3">
																					<label>Governance</label>
																				</div>
																				<div class="col-sm-2 col-md-2 col-lg-2">
																					<?php echo ($pharmacy_surgery['global_settings']['governance_status']) ? '<label class="success">ON</label>' : '<label class="error">OFF</label>'?>
																				</div>
																			</div>
																			<div class="row">
																				<p>&nbsp;</p>
																			</div>
																			<div class="row">
																				<div class="col-sm-4 col-md-4 col-lg-4">
																					<input type="checkbox" name="online_doctor_status" id="online_doctor_status" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['global_settings']['online_doctor_status']) ? 'checked="checked"' : ''?>>
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-3">
																					<label>Online Doctor</label>
																				</div>
																				<div class="col-sm-2 col-md-2 col-lg-2">
																					<?php echo ($pharmacy_surgery['global_settings']['online_doctor_status']) ? '<label class="success">ON</label>' : '<label class="error">OFF</label>'?>
																				</div>
																			</div>
																			<div class="row">
																				<p>&nbsp;</p>
																			</div>
																			<div class="row">
																				<div class="col-sm-4 col-md-4 col-lg-4">
																					<input type="checkbox" name="survey_status" id="survey_status" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['global_settings']['survey_status']) ? 'checked="checked"' : ''?>>
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-3">
																					<label>Survey</label>
																				</div>
																				<div class="col-sm-2 col-md-2 col-lg-2">
																					<?php echo ($pharmacy_surgery['global_settings']['survey_status']) ? '<label class="success">ON</label>' : '<label class="error">OFF</label>'?>
																				</div>
																			</div>
																			<div class="row">
																				<p>&nbsp;</p>
																			</div>
																			<div class="row">
																				<div class="col-sm-4 col-md-4 col-lg-4">
																					<input type="checkbox" name="pmr_status" id="pmr_status" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['global_settings']['pmr_status']) ? 'checked="checked"' : ''?>>
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-3">
																					<label>PMR</label>
																				</div>
																				<div class="col-sm-2 col-md-2 col-lg-2">
																					<?php echo ($pharmacy_surgery['global_settings']['pmr_status']) ? '<label class="success">ON</label>' : '<label class="error">OFF</label>'?>
																				</div>
																			</div>
																			<div class="row">
																				<p>&nbsp;</p>
																			</div>
																			<div class="row">
																				<div class="col-sm-4 col-md-4 col-lg-4">
																					<input type="checkbox" name="todolist_status" id="todolist_status" class="kod-switch" value="1" <?php echo ($pharmacy_surgery['global_settings']['todolist_status']) ? 'checked="checked"' : ''?>>
																				</div>
																				<div class="col-sm-3 col-md-3 col-lg-3">
																					<label>To Do List</label>
																				</div>
																				<div class="col-sm-2 col-md-2 col-lg-2">
																					<?php echo ($pharmacy_surgery['global_settings']['todolist_status']) ? '<label class="success">ON</label>' : '<label class="error">OFF</label>'?>
																				</div>
																			</div>
																			<!-- Input field to set action as [ update settings for the pharmacy_surgery_id ] -->
																			<input type="hidden" name="update_pharmacy_surgery_settings" value="1" />
																			<input type="hidden" name="pharmacy_surgery_id" value="<?php echo $pharmacy_surgery['id']; ?>" />
																		<!-- End - Global Settings --> 
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										  
											<div class="modal-footer">
												<button id="update_setting_btn" name="update_setting_btn" type="submit" class="btn btn-success">Update Settings</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									  </div>
                                       </form>
									</div>
									
								</div>
                               
							</div>
						</div>
			
						<br />
						<?php if($pharmacy_surgery['manager_id'] == 0){ ?>
									
									<?php //echo '<pre>'; print_r( $pharmacy_surgery['manager_invitations'][0] ); exit;  ?>
									
									<?php if(empty($pharmacy_surgery['manager_invitations'])) { ?>
									
											<strong class="text-success hidden" id="self_manager_row_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> <span class="hidden" id="manager_info_span_<?php echo $pharmacy_surgery['id']; ?>"></span></strong>
											
											<div class="col-sm-8 col-md-8 col-lg-8" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
												
												<div class="input-group">
												
													<input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
													
													
													<span class="input-group-btn" id="basic-addon3">
														<button class="btn btn-sm btn-success invite-manager-staff-btn" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite Manager</button>
													</span>
													
													<span class="input-group-addon">OR</span>

													<span class="input-group-btn" id="basic-addon3">
													
														<!-- Trigger the modal with a button -->
														<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>">Elect Self</button>
								
														<!-- Modal -->
														<div id="myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
															
															<div class="modal-dialog">									
																
																<!-- Modal content-->
																<div class="modal-content">
																
																	<div class="modal-header">
																	
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Confirm ! </h4>
																		
																	</div>
																	
																	<div class="modal-body">
																		<h5>Are you sure you want to elect yourself as the manager ?. </h5>
																	</div>
																	
																	<div class="modal-footer">
																	
																		<button class="btn btn-warning manager-elect-self-btn" data-dismiss="modal" value="<?php echo $pharmacy_surgery['id']; ?>" >Yes</button>
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	
																	</div>
																</div>
																
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
												<div class="col-sm-3 col-md-3 col-lg-3 pull-left"><button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</button>

													<!-- Modal Cancel Invitation -->
													<div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
													  <div class="modal-dialog">
													
														<!-- Modal content-->
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Confirmation</h4>
														  </div>
														  <div class="modal-body">
															<p>Are you sure you you want to cancel the invitation sent to manager?</p>
														  </div>
														  <div class="modal-footer">
														  
														  <button class="btn btn-danger cancel-inv-btn"  type="button" data-dismiss="modal" name="" id="cancel_inv_btn_<?php echo $pharmacy_surgery['id']; ?>" value="<?php $invitation_id = 1; echo $pharmacy_surgery['id']; ?>" >Cancel Invitation</button>
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														  </div>
														</div>
													
													  </div>
													</div>
													
												</div>
											</div>
											<div class="col-sm-1 col-md-1 col-lg-1"></div> 
										</div>
									
									<?php } else { // else - if(empty($pharmacy_surgery['manager_invitations'])) ?>
										
										<strong class="text-success hidden" id="self_manager_row_<?php echo $pharmacy_surgery['id']; ?>"><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> <span class="hidden" id="manager_info_span_<?php echo $pharmacy_surgery['id']; ?>"></span></strong>
												
										<div class="col-sm-8 col-md-8 col-lg-8 hidden" id="invitation_response_m_<?php echo $pharmacy_surgery['id']; ?>" >
											
											<div class="input-group">
											
												<input class="form-control input-sm inv-input-email-address search-manager" required="required" type="email" name="M" id="manager_email_address_<?php echo $pharmacy_surgery['id']; ?>" placeholder="Enter manager email address" />
												
												<span class="input-group-btn" id="basic-addon3">
													<button class="btn btn-sm btn-success invite-manager-staff-btn" name="M" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite Manager</button>
												</span>
												
												<span class="input-group-addon">OR</span>

												<span class="input-group-btn" id="basic-addon3">
												
													<!-- Trigger the modal with a button -->
													<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>">Elect Self</button>
							
													<!-- Modal -->
													<div id="myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
														
														<div class="modal-dialog">									
															
															<!-- Modal content-->
															<div class="modal-content">
															
																<div class="modal-header">
																
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Confirm ! </h4>
																	
																</div>
																
																<div class="modal-body">
																	<h5>Are you sure you want to elect yourself as the manager ?. </h5>
																</div>
																
																<div class="modal-footer">
																
																	<button class="btn btn-warning manager-elect-self-btn" data-dismiss="modal" value="<?php echo $pharmacy_surgery['id']; ?>" >Yes</button>
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																
																</div>
															</div>
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
												<div class="col-sm-3 col-md-3 col-lg-3 pull-left"><button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</button>

													<!-- Modal Cancel Invitation -->
													<div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
													  <div class="modal-dialog">
													
														<!-- Modal content-->
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Confirmation</h4>
														  </div>
														  <div class="modal-body">
															<p>Are you sure you you want to cancel the invitation sent to manager?</p>
														  </div>
														  <div class="modal-footer">
														  
														  <button class="btn btn-danger cancel-inv-btn" type="button" data-dismiss="modal" name="<?php echo $pharmacy_surgery['manager_invitations'][0]['id']; ?>" id="cancel_inv_btn_<?php echo $pharmacy_surgery['id']; ?>" value="<?php $invitation_id = 1; echo $pharmacy_surgery['id']; ?>" >Cancel Invitation</button>
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														  </div>
														</div>
													
													  </div>
													</div>
													
												</div>
											</div>
											<div class="col-sm-1 col-md-1 col-lg-1"></div> 
										</div>
										
								<?php } // if(!empty($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'])): ?>
								
								<!-- Show Error Messages for the manager invitation -->
								<span class="manager_error hidden"><br /><br /><br /><div class="alert alert-danger hidden" id="error_m_inv_container_<?php echo $pharmacy_surgery['id']; ?>" ></div></span>
							
						<?php } else { // if($pharmacy_surgery['manager_id'] == 0) ?>
						
						<!--  If manager exists -->
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12" >
									
									<strong><?php echo ($pharmacy_surgery['type'] == 'P') ? 'Pharmacy' : 'Surgery' ?> Manager (<?php echo ($pharmacy_surgery['manager_usertype'] != '') ? $pharmacy_surgery['manager_usertype'] : '' ?>) : </strong> <?php echo ($pharmacy_surgery['manager_full_name'] != '') ? $pharmacy_surgery['manager_full_name'] : '' ?> - <span class="glyphicon glyphicon-phone"></span> <?php echo ($pharmacy_surgery['manager_contact_number'] != '') ? $pharmacy_surgery['manager_contact_number'] : '' ?> - <span class="glyphicon glyphicon-envelope"></span> <?php echo ($pharmacy_surgery['manager_email'] != '') ? $pharmacy_surgery['manager_email'] : '' ?> &nbsp; &nbsp; &nbsp; <a href="<?php echo base_url();?>organization/edit-manager-staff/<?php echo $pharmacy_surgery['manager_id'];?>" class=" fancybox_view_manager fancybox.ajax"> Edit </a> &nbsp; <a href="javascript:;" class="replace-manager" value="<?php echo $pharmacy_surgery['id']; ?>" > Replace </a>
									<br /><br />
									
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
													
													<span class="input-group-addon">OR</span>

													<span class="input-group-btn" id="basic-addon3">
													
														<!-- Trigger the modal with a button -->
														<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>">Elect Self</button>
								
														<!-- Modal -->
														<div id="myModalElectSelf<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
															
															<div class="modal-dialog">									
																
																<!-- Modal content-->
																<div class="modal-content">
																
																	<div class="modal-header">
																	
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Confirm ! </h4>
																		
																	</div>
																	
																	<div class="modal-body">
																		<h5>Are you sure you want to elect yourself as the manager ?. </h5>
																	</div>
																	
																	<div class="modal-footer">
																	
																		<button class="btn btn-warning manager-elect-self-btn" data-dismiss="modal" value="<?php echo $pharmacy_surgery['id']; ?>" >Yes</button>
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	
																	</div>
																</div>
																
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
													<div class="col-sm-3 col-md-3 col-lg-3 pull-left"><button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>"  type="button">Cancel Invitation</button>
												
													<!-- Modal Cancel Invitation -->
													<div id="confirm_cancel_modal_m_<?php echo $pharmacy_surgery['id']; ?>" class="modal fade" role="dialog">
													  <div class="modal-dialog">
													
														<!-- Modal content-->
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Confirmation</h4>
														  </div>
														  <div class="modal-body">
															<p>Are you sure you you want to cancel the invitation sent to manager?</p>
														  </div>
														  <div class="modal-footer">
														  
														  <button class="btn btn-danger cancel-inv-btn" type="button" data-dismiss="modal" name="<?php echo $pharmacy_surgery['manager_invitations'][0]['id']; ?>" id="cancel_inv_btn_<?php echo $pharmacy_surgery['id']; ?>" value="<?php $invitation_id = 1; echo $pharmacy_surgery['id']; ?>" >Cancel Invitation</button>
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														  </div>
														</div>
													
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
									
									<?php if($pharmacy_surgery['governance_read_status'] == 1) { ?>
										<button class="btn btn-xs btn-success"> Governance </button>
									<?php } else { ?>
										<button class="btn btn-xs btn-danger"> Governance </button>
									<?php } // if($pharmacy_surgery['governance_read_status'] == 1): ?>
									
									<br /><br />
									
									<button class="btn btn-xs btn-default expand-btn" onClick="expand_me(<?php echo $pharmacy_surgery['id']; ?>);" > + Expand </button>
									<br /><br />
									
									<span id="expand_pharmacy_<?php echo $pharmacy_surgery['id']; ?>" style="display: none;" >
			
										<?php //if($pharmacy_surgery['governance_read_status'] == 1) { ?>
									
											<label onClick="toggle_staff(<?php echo $pharmacy_surgery['id']; ?>);" ><h4 class="text-primary"><span class="glyphicon glyphicon-triangle-bottom"></span>Staff</h4></label>
											
											<br />
											
											<!-- Start - View Pharmacy / Surgery Staff -->
											<div id="view_staff_<?php echo $pharmacy_surgery['id']; ?>" style="display:none;">
											
												<!-- Staff of Pharmacy / Surgery -->
												<?php if(!empty($pharmacy_surgery['pharmacy_surgery_staff'])){ ?>
												
													<?php foreach($pharmacy_surgery['pharmacy_surgery_staff'] as $member): ?>                                                          
														
														<label> <?php echo ($member['staff_member_user_type'] != '' ) ? $member['staff_member_user_type'] : '' ?> : </label> <?php echo ($member['staff_member_full_name'] != '' ) ? $member['staff_member_full_name'] : '' ?> - <span class="glyphicon glyphicon-phone"></span> <?php echo ($member['staff_member_contact_number'] != '' ) ? $member['staff_member_contact_number'] : '' ?> - <span class="glyphicon glyphicon-envelope"></span> <?php echo ($member['staff_member_contact_email'] != '' ) ? $member['staff_member_contact_email'] : '' ?> &nbsp; &nbsp; &nbsp; <a href="<?php echo base_url();?>organization/edit-manager-staff/<?php echo $member['staff_member_id'];?>" class=" fancybox_view_manager fancybox.ajax"> Edit </a> &nbsp; 
														<a  href="#" data-href="<?php echo base_url(); ?>organization/delete-staff-member/<?php echo $member['staff_member_row_id']; ?>" title="Delete" data-toggle="modal" data-target="#confirm-delete-<?php echo $member['staff_member_row_id']; ?>">Delete </a>
														
														<br />
														<div class="modal fade" id="confirm-delete-<?php echo $member['staff_member_row_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		Confirm !
																	</div>
																	<div class="modal-body">
																		Are you sure you want to delete?
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																		<a href="<?php echo base_url(); ?>organization/delete-staff-member/<?php echo $member['staff_member_row_id']; ?>" class="btn btn-danger btn-ok">Delete</a>
																	</div>
																</div>
															</div>
														</div>
														
														<?php if($member['staff_member_governance_read_status'] == 1) { ?>
															<button class="btn btn-xs btn-success">Governance</button>
														<?php } else { ?>
															<button class="btn btn-xs btn-danger">Governance</button>
														<?php } // if($pharmacy_surgery['governance_read_status'] == 1): ?>
														
														<?php if($member['staff_member_user_type'] != "Doctor"){ ?>
														
															<button class="btn btn-xs btn-success"> Seasonal </button>
															<button class="btn btn-xs btn-success"> Anaphylex </button>
															<button class="btn btn-xs btn-danger"> Travel <span class="glyphicon glyphicon-shopping-cart"></span></button>
															<button class="btn btn-xs btn-danger"> Oral <span class="glyphicon glyphicon-shopping-cart"></span></button>
														
														<?php } // if($member['staff_member_user_type'] != "Doctor") ?>
														<br /><br />
														
													<?php endforeach; // end - foreach($pharmacy_surgery['pharmacy_surgery_staff'] as $member): ?>
													
												<?php } // end - if(!empty($pharmacy_surgery['pharmacy_surgery_staff'])) ?>
												
												<?php if(!empty($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'])){ ?>
												
													<br /><h4 class="text-info">Pending Invitations: </h4><br />
													
													<?php foreach($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'] as $pending_invitation): ?>
												
														<?php //echo '<pre>'; print_r($pending_invitation); ?>
												
														<?php if($pending_invitation['invitation_type'] != 'M' || $pending_invitation['invitation_type'] != 'SI' ){ // : Pending Invitations ?>
															
															<!-- Start - List Pending Invitation of Staff -->
															<span id="staff_pending_invitation_span_<?php echo $pending_invitation['id']; ?>">
															
																<!-- Pending Invitations of Pharmacy / Surgery Staff -->
																<?php //echo '<pre>'; print_r($pending_invitation);  ?>
																<label class="text-danger">Pending invitation for <?php if($pending_invitation['user_type'] == 'DO' ) { echo 'Doctor'; } elseif($pending_invitation['user_type'] == 'PH' ) { echo 'Pharmacist'; } elseif($pending_invitation['user_type'] == 'NU' ) { echo 'Nurse'; } elseif($pending_invitation['user_type'] == 'PA' ) { echo 'Pharmacist Assistant'; } elseif($pending_invitation['user_type'] == 'TE' ) { echo 'Technician'; } elseif($pending_invitation['user_type'] == 'PR' ) { echo 'Pre-Reg'; } elseif($pending_invitation['user_type'] == 'NH' ) { echo 'Non Health Professionals'; } echo '<span class="text-primary" > - '.$pending_invitation['user_email_address'].' </strong>';  ?> </label> 
																&nbsp; &nbsp; 
																
																<button type="button" class="btn btn-danger btn-xs" id="delete_staff_btn_<?php echo $pending_invitation['id']; ?>" data-toggle="modal" data-target="#delete_staff_modal_<?php echo $pending_invitation['id']; ?>">Delete</button>
																<!-- Modal -->
																<div id="delete_staff_modal_<?php echo $pending_invitation['id']; ?>" class="modal fade" role="dialog">
																	<div class="modal-dialog">

																		<!-- Modal content-->
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal">&times;</button>
																				<h4 class="modal-title">Confirm !</h4>
																			</div>
																			<div class="modal-body">
																				<p>Are you sure you want to delete this invitation ?</p>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-danger delete-staff-invite" data-dismiss="modal" value="<?php echo $pending_invitation['id']; ?>" >Delete</button>
																				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			</div>
																		</div>

																	</div>
																</div>
																
																<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#resend_inv<?php echo $pending_invitation['id']; ?>" >Resend Invite</button>
																<!-- Modal -->
																<div id="resend_inv<?php echo $pending_invitation['id']; ?>" class="modal fade" role="dialog">
																	<div class="modal-dialog">

																		<!-- Modal content-->
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal">&times;</button>
																				<h4 class="modal-title">Confirm !</h4>
																			</div>
																			<div class="modal-body">
																				<p>Are you sure you want to Resend the invitation ?</p>
																			</div>
																			<div class="modal-footer">
																				<button class="btn btn-warning resend-staff-invite-btn" value="<?php echo $pending_invitation['id']; ?>" data-dismiss="modal" >Resend Invite</button>
																				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			</div>
																		</div>

																	</div>
																</div>
																<br /><br />
																
															</span>
															<!-- End - List Pending Invitation of Staff -->
														
														<?php } /* else if($pending_invitation['status'] == '2'){ // : Rejected Invitations ?>
															
															<!-- Rejected Invitations of Pharmacy / Surgery Staff -->
															<label class="text-danger"> invitation was rejected for <?php echo ($pending_invitation['user_type'] != '') ? $pending_invitation['user_type'] : '' ?> </label> &nbsp; &nbsp; <button class="btn btn-xs btn-danger">Delete</button> <button class="btn btn-xs btn-warning">Resend Invite</button>
															<br /><br />
															
														<?php } // else if($pending_invitation['status'] == '2') */ ?>
														
													<?php 
													
													endforeach; // End - foreach($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'] as $pending): ?>
													
												<?php } // End - if(!empty($pharmacy_surgery['pharmacy_surgery_staff_pending_invitations'])) ?>
												
											</div>
											<!-- End - View Pharmacy / Surgery Staff -->
											
											<br /><br />
											<button class="btn btn-xs btn-primary pull-left add-staff-btn" onClick="toggle_add_staff(<?php echo $pharmacy_surgery['id']; ?>);" >Add Staff &nbsp;</button>
											<br /><br />
											
										<?php //} //if governance is read ?>
									</span>
								</div>
								
							</div>
							
							<div class="row panel panel-default panel-body" id="add_staff_<?php echo $pharmacy_surgery['id']; ?>" style="display: none;" >
								
								<div class="col-sm-1 col-md-1 col-lg-1"></div> <!-- Left empty space -->
								<div class="col-sm-10 col-md-10 col-lg-10">
									
									<div class="input-group">
										
										<span class="input-group-addon">
											
											<select id="select_invitation_type_<?php echo $pharmacy_surgery['id']; ?>" >
											
												<option value="DO">Doctor</option>
												<option value="PH">Pharmacist</option>
												<option value="NU">Nurse</option>
												<option value="PA">Pharmacy Assistant</option>
												<option value="TE">Technician</option>															
												<option value="PR">Pre-reg</option>															
												<option value="NH">Non Health Professional</option>
												
											</select>
										<div class="col-sm-1 col-md-1 col-lg-1"></div> <!-- Right empty space -->
										</span>
										<input type="hidden" id="pharmacy_surgery_hidden_id_<?php echo $pharmacy_surgery['id']; ?>" value="<?php echo $pharmacy_surgery['id']; ?>">
										<input class="form-control input-md inv-email inv-input-email-address" name="ST" id="<?php echo $pharmacy_surgery['id']; ?>" required="required" type="email" placeholder="Email Address" />
										<span class="input-group-btn" id="basic-addon3">
											<button class="btn btn-md btn-default invite-manager-staff-btn" name="ST" value="<?php echo $pharmacy_surgery['id']; ?>" >Invite</button>
                                            </span>
                                            <span class="input-group-addon">OR</span>
                                         <span class="input-group-btn" id="basic-addon3">
                                            
											<button class="btn btn-warning elect-self-staff" value="<?php echo $pharmacy_surgery['id']; ?>" >Elect Self</button>
										</span>
									</div>
									
									<div id="suggesstion_box_<?php echo $pharmacy_surgery['id']; ?>"></div>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2"></div> <!-- Right empty space -->
								<br />
                                <br />
                                <br />
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12 alert alert-danger alert-success pull-right hidden" id="error_message_span_<?php echo $pharmacy_surgery['id']; ?>"></div>
								</div>
							</div>
						<?php } // else - if($pharmacy_surgery['manager_id'] == 0) ?>
					</div>
					
			<?php endforeach; // foreach($pharmacies_surgeries as $pharmacy_surgery) ?>
			</div>
			<?php } else { ?>
	 
				<div class="panel panel-default panel-body text-danger">No record found for <?php echo $filter_for; ?>.</div>
	
			<?php } // else - if(!empty($pharmacies_surgeries)) ?>


    <!-- End - Listing ( Pharmacy / Surgery ) -->
    <!--Js File-->
    <script src="<?php echo JS;?>org_dashboard.js"></script>
    <script src="<?php echo JS;?>highlight.js"></script>
    <script src="<?php echo JS;?>bootstrap-switch.js"></script>
    <link rel="stylesheet" href="<?php echo CSS;?>highlight.css">
    <link rel="stylesheet" href="<?php echo CSS;?>bootstrap-switch.css">
       
       
            
	