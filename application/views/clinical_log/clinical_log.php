<?php 
	$CLINICAL_LOG_BLUE_TEXT = 'CLINICAL_LOG_BLUE_TEXT';
	$clinical_log_blue_text = get_global_settings($CLINICAL_LOG_BLUE_TEXT); //Set from the Global Settings
	$clinical_log_blue_text = filter_string($clinical_log_blue_text['setting_value']);

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css" />

<style>
.nav > li > a {
	padding:10px 12px;	
}
.nav-tabs > li > a{
	margin-right:0px;
}
</style>

<?php
	$active_tab = $this->input->get('t');
	$active_tab = ($active_tab < 1 || $active_tab > 8) ? 1 : $active_tab;
?>	
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Manage Clinical Log</strong></div>
      <div class="panel-body">
        <p class="align-left"></p>
            <div class="row">
              <div class="col-md-12">
					<?php 
                        if(!$this->session->dismiss_message['clinical_log']){
					?>
                            <div class="alert alert-info in alert-dismissable">
                                <a href="#" data-pharmacy="" data-org="<?php echo $this->session->organization_id?>" data-type="clinical_log" class="close dismiss_message" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <?php echo $clinical_log_blue_text?>
                            </div>
                    <?php		
						}//end if(!$this->session->dismiss_message['clinical_log'])
					?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <!-- Stat - tabs -->
                            <ul class="nav nav-tabs">
                                <li class="<?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>"><a data-toggle="tab" href="#clinical_diary">Clinical Diary</a></li>
                                <li class="<?php echo ($active_tab == 2 ) ? 'active': '' ?>"><a data-toggle="tab" href="#errors">Errors</a></li>
                                <li class="<?php echo ($active_tab == 3 ) ? 'active': '' ?>"><a data-toggle="tab" href="#date_checking">Date Checking</a></li>
                                <li class="<?php echo ($active_tab == 4 ) ? 'active': '' ?>"><a data-toggle="tab" href="#cleaning">Cleaning</a></li>
                                <li class="<?php echo ($active_tab == 5 ) ? 'active': '' ?>"><a data-toggle="tab" href="#recalls">Recalls</a></li>
                                <li class="<?php echo ($active_tab == 6 ) ? 'active': '' ?>"><a data-toggle="tab" href="#responsible_pharmacist">Responsible Pharmacist</a></li>
                                <li class="<?php echo ($active_tab == 7 ) ? 'active': '' ?>"><a data-toggle="tab" href="#maintenance">Maintenance</a></li>
                                <li class="<?php echo ($active_tab == 8 ) ? 'active': '' ?>"><a data-toggle="tab" href="#self_care">Self Care</a></li>
                            </ul>
                            <!-- Start - tabs body -->
                            <div class="tab-content">
                           
                                <!-- First Active Tab Contents -->
                                <div id="clinical_diary" class="tab-pane fade in  <?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>">
                                	<div class="row">
                                		<div class="col-md-12">
                                			
                                			<table class="table table-hover table-bordered">
                                				<thead>
                                					<tr>
                                						<th class="text-center">Date</th>
                                						<th class="text-center">Entry creator</th>
                                						<th class="text-center">Subject</th>
                                						<th class="text-center">Details</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                                
                                                  <?php if(!empty($list_cl_diary)) {
					  										foreach($list_cl_diary as $each): 
			  										?>
                                					<tr>
                                						 <td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                                						<td class="text-center"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                                						<td class="text-center"><?php echo filter_string($each['subject']);?></td>
                                						<td class="text-center">
														<a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>clinical-log/get-clinical-diary-details/<?php echo $each['id'];?>"><button class="btn btn-sm btn-warning">View</button>
</a>
                                                        </td>
                                					</tr>
                                					 <?php 
														endforeach; // foreach
													 }  else { ?>
													 
                     									<td colspan="4"> No record found...</td>
                     
  			   										<?php } ?>	
                                					
                                				</tbody>
                                			</table>

                                			<form id="add_clinical_diary_frm"  name="add_clinical_diary_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-diary-process" autocomplete="off">
                                				<div class="row">
                                					<div class="col-md-12">
                                						<label>Date: </label>
                                						<input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                                       
                                					</div>
                                				</div>
                                				<br />
                                				<div class="form-group has-feedback">
                        						<label>Subject: </label>
                        						<input type="text" id="subject" name="subject" value="" class="form-control" />
                                                </div>
                        						<br />
												
                                                <div class="form-group has-feedback">
                        						<label>Details: </label>
                        						<textarea class="form-control" rows="4" id="details" name="details"></textarea>
                                                </div>
                                				<br />

                                				<div class="row">
	                                				<div class="col-md-12 text-right">
                                                        <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/1" style="color:#FFF">Print Log</a>
	                                					<button class="btn btn-sm btn-success" type="submit" id="add_clinical_diary_btn" name="add_clinical_diary_btn">Add New Entry</button>
	                                				</div>
                                				</div>

                                			</form>

                                		</div>
                                	</div>
                                </div>

                                <!-- Tab Contents [ errors ] -->
                                <div id="errors" class="tab-pane fade in <?php echo ($active_tab == 2 ) ? 'active': '' ?>">
                                	<table class="table table-hover table-bordered">
                        				<thead>
                        					<tr>
                        						<th class="text-center">Date</th>
                        						<th class="text-center">Entry creator</th>
                        						<th class="text-center">Error Attributed</th>
                        						<th class="text-center">NPSA Class</th>
                        						<th class="text-center">Subject</th>
                        						<th class="text-center">Details</th>
                        					</tr>
                        				</thead>
                        				<tbody>
                        					
										 <?php if(!empty($list_cl_errors)) {
                                                        foreach($list_cl_errors as $each): 
                                         ?>
                                                <tr>
                                                    <td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                                                    <td class="text-center"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                                                    <td class="text-center"><?php echo filter_string($each['error_attributed']);?></td>
                                                    <td class="text-center"><?php echo filter_string($each['npsa_class']);?></td>
                                                     <td class="text-center"><?php echo filter_string($each['subject']);?></td>
                                                    <td class="text-center">
                                                    <a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>clinical-log/get-clinical-errors-details/<?php echo $each['id'];?>"><button class="btn btn-sm btn-warning">View</button>
</a>
                                                    </td>
                                                </tr>
                                                 <?php 
                                                    endforeach; // foreach
                                                 }  else { ?>
                                                 
                                                    <td colspan="6"> No record founded..</td>
                 
                                               <?php } ?>	
                        					
                        				</tbody>
                        			</table>

                        			<form id="add_clinical_errors_frm"  name="add_clinical_errors_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-errors-process" autocomplete="off">
                        				<div class="row">
                        					<div class="col-md-12">
                        						<label>Date: </label>
                        						<input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                        					</div>
                                            <br /> <br /> <br /> <br />
                        					<div class="form-group has-feedback col-md-12">
                        						<label>Error Attributed to: </label>
                        						<input type="text" class="form-control" id="error_attributed" name="error_attributed" />
                        					</div>
                        				</div>
                        				<br />

                        				<div class="row">
                        					<div class="form-group has-feedback col-md-12">
                                                <label>NPSA Class:</label>
                        						<select class="form-control" id="npsa_class" name="npsa_class"  required>
                        							<option value="">Please select a catergory of error</option>
                        							<option value="Near Miss">Near Miss</option>
                        							<option value="No harm">No harm</option>
                        							<option value="Low">Low</option>
                        							<option value="Moderate">Moderate</option>
                        							<option value="Severe">Severe</option>
                        							<option value="Death">Death</option>
                        						</select>
                        					</div>
                        				</div>
                        				<br />
                                        
                        				<div class="row">
                                        <div class="form-group has-feedback col-md-12">
                						<label>Subject: </label>
                						<input type="text" id="subject" name="subject" value="" required="required" class="form-control" />
                                        </div>
                                        </div>
                						<br />
										
                                        <div class="row">
                                            <div class="form-group has-feedback col-md-12">
                                            <label>Details: </label>
                                            <textarea class="form-control" rows="4" id="details" name="details" required="required"></textarea>
                                            </div>
                                        </div>
                        				<br />

                        				<div class="row">
                            				<div class="col-md-12 text-right">
                            					<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/2" style="color:#FFF">Print Log</a>
                            					<button class="btn btn-sm btn-success" type="submit" id="add_clinical_errors_btn" name="add_clinical_errors_btn">Add New Entry</button>
                            				</div>
                        				</div>

                        			</form>
                                </div>

                                <!-- Tab Contents [ date_checking ] -->
                                <div id="date_checking" class="tab-pane fade in <?php echo ($active_tab == 3 ) ? 'active': '' ?>">
                                	
                                	<div class="row">
                                		<div class="col-md-12">
                                			
                                			<table class="table table-hover table-bordered">
                                				<thead>
                                					<tr>
                                						<th class="text-center">Date</th>
                                						<th class="text-center">Check performed by</th>
                                						<th class="text-center">Medicine Type</th>
                                						<th class="text-center">Notes (optional)</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					
                                			    <?php if(!empty($list_cl_date_checking)) {
                                                        foreach($list_cl_date_checking as $each): 
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                                                    <td class="text-center"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                                                    <td class="text-center"><?php echo filter_string($each['medicine_type']);?></td>
                                                    <td class="text-center"><a href="<?php echo SURL;?>clinical-log/get-date-checking-details/<?php echo $each['id'];?>" class="btn btn-sm btn-warning fancybox_view fancybox.ajax">View</a></td>
                                                </tr>
                                                 <?php 
                                                    endforeach; // foreach
                                                 }  else { ?>
                                                 
                                                    <td colspan="4"> No record founded..</td>
                 
                                               <?php } ?>	
                                					
                                				</tbody>
                                			</table>

                                			<form id="add_clinical_date_checking_frm"  name="add_clinical_date_checking_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-date-checking-process" autocomplete="off">
                                				<div class="row">
                                					<div class="col-md-12">
                                						<label>Date </label>
                                						<input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                					</div>
                                				</div>
                                				<br />
                                				
                                				<div class="row">
                                					<div class="form-group col-md-12">
                                                   <label>Medicine Type: </label>
		                        						<select class="form-control" id="medicine_type" name="medicine_type">
		                        							<option value="">Medicine type</option>
		                        							<option value="OTC">OTC</option>
		                        							<option value="GSL">GSL</option>
		                        							<option value="POM">POM</option>
		                        							<option value="P">P</option>
		                        						</select>
		                        					</div>
		                        				</div>
                        						<br />
												
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                    <label>Notes </label>
                                                    <textarea class="form-control" rows="4" id="notes" name="notes"></textarea>
                                                    </div>
                                                </div>
                                				<br />

                                				<div class="row">
	                                				<div class="col-md-12 text-right">
	                                					<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/3" style="color:#FFF">Print Log</a>
	                                					<button class="btn btn-sm btn-success" type="submit" id="add_clinical_date_checking_btn" name="add_clinical_date_checking_btn">Add New Entry</button>
	                                				</div>
                                				</div>

                                			</form>

                                		</div>
                                	</div>

                                </div>

                                <!-- Tab Contents [ cleaning ] -->
                                <div id="cleaning" class="tab-pane fade in <?php echo ($active_tab == 4 ) ? 'active': '' ?>">
                                	
                                	<div class="row">
                                		<div class="col-md-12">
                                			
                                			<table class="table table-hover table-bordered">
                                				<thead>
                                					<tr>
                                						<th class="text-center">Date</th>
                                						<th class="text-center">Cleaning performed by...</th>
                                						<th class="text-center">Location area</th>
                                						<th class="text-center">Notes (optional)</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                			    <?php if(!empty($list_cl_cleaning)) {
                                                        foreach($list_cl_cleaning as $each): 
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                                                    <td class="text-center"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                                                    <td class="text-center"><?php echo filter_string($each['location_area']);?></td>
                                                    <td class="text-center">
                                                    
                                                     <a class="btn btn-sm btn-warning  fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>clinical-log/get-cleaning-details/<?php echo $each['id'];?>">View</a>
                                                    </td>
                                                </tr>
                                                 <?php 
                                                    endforeach; // foreach
                                                 }  else { ?>
                                                 
                                                    <td colspan="4"> No record founded..</td>
                 
                                               <?php } ?>	
                                					
                                				</tbody>
                                			</table>

                                			<form id="add_clinical_cleaning_frm"  name="add_clinical_cleaning_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-cleaning-process" autocomplete="off">
                                				<div class="row">
                                					<div class="col-md-12">
                                						<label>Date </label>
														<input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                					</div>
                                				</div>
                                				<br />
												
                                                <div class="form-group">
												<label>Location area</label>
                                                <div class="input-group">
                                                <select class="form-control" id="area_id" name="area_id">
                                                         <option value="">Please select area</option>
                                                        <?php if(!empty($location_area_list)){
																foreach($location_area_list as $each) {
														?>
                                                           <option value="<?php echo $each['id'];?>"><?php echo ucfirst(filter_string($each['location_area']));?></option>
		                        							<!--<option value="Dispensary"><?php echo $each['area_name']?></option>
		                        							<option value="Counter tops">Counter tops</option>
		                        							<option value="Computer terminals">Computer terminals</option>
		                        							<option value="Controlled drugs cabinet">Controlled drugs cabinet</option>
		                        							<option value="Consultation room">Consultation room </option>
		                        							<option value="Storage room">Storage room </option>
		                        							<option value="Toilet – Male">Toilet – Male </option>
		                        							<option value="Toilet – Female">Toilet – Female </option>
		                        							<option value="Toilet">Toilet </option>
		                        							<option value="Shop area">Shop area </option>
		                        							<option value="Front windows">Front windows </option>
		                        							<option value="Front sign">Front sign </option>
		                        							<option value="Pavement">Pavement </option>
		                        							<option value="Garden">Garden </option>
		                        							<option value="Basement">Basement </option>
		                        							<option value="OTC">OTC </option>
		                        							<option value="GSL">GSL</option>
		                        							<option value="P">P </option>
		                        							<option value="POM">POM </option>-->
                                                           
                                                         <?php 
																}// end foreach
														  }//end if 
														 
														 ?>   
                                                         
		                        						</select>
                                                <span class="input-group-btn">
                                                 <a class="fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>clinical-log/add-edit-area"><button class="btn  btn-success" type="button">Add new area</button></a>
                                                </span>
                                                </div><!-- /input-group -->
                                                </div>
                                             
                                                
                                			
                        						<br />

                        						<label>Notes (optional)</label>
                        						<textarea class="form-control" rows="4" id="notes" name="notes"></textarea>
                                				<br />

                                				<div class="row">
	                                				<div class="col-md-12 text-right">
	                                					<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/4" style="color:#FFF">Print Log</a>
	                                					<button class="btn btn-sm btn-success"  type="submit" id="add_clinical_cleaning_btn" name="add_clinical_cleaning_btn">Add New Entry</button>
	                                				</div>
                                				</div>

                                			</form>

                                		</div>
                                	</div>

                                </div>

                                <!-- Tab Contents [ recalls ] -->
                                <div id="recalls" class="tab-pane fade in <?php echo ($active_tab == 5 ) ? 'active': '' ?>">
                                	
                                	<div class="row">
                                		<div class="col-md-12">
                                			
                                			<table class="table table-hover table-bordered">
                                				<thead>
                                					<tr>
                                						<th class="text-center">Date</th>
                                						<th class="text-center">Recall received by</th>
                                						<th class="text-center">Actioned by</th>
                                						<th class="text-center">Details</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					  <?php if(!empty($list_cl_recalls)) {
					  										foreach($list_cl_recalls as $each): 
			  										?>
                                					<tr>
                                						<td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                                						<td class="text-center">
														<?php if($each['status'] ==1 && $each['received_by'] !=""){
															 $get_full_name =	get_user_details_new($each['received_by']);
														?> 
                                                        <?php echo ucfirst(filter_string($get_full_name['fullname'])).'<br />'.kod_date_format(filter_string($each['received_date']));?>													<?php } else {?>
                                                        <a href="#confirm_reslove_received_by<?php echo $each['id'];?>" class="btn btn-sm btn-danger dialogue_window white_link">Action</a>
                                                        <?php } ?>
                                                        </td>
                                                        
                                                        <div id="confirm_reslove_received_by<?php echo $each['id'];?>" style="display:none">
                                                        <h4>Confirmation</h4>
                                                        <p>Are you sure you want to received action?</p>
                                                        <div class="modal-footer"> 
                                                        
                                                        <!--Tab id 5 Recalls received by 1--> 
                                                        <a class="btn btn-success" href="<?php echo SURL?>clinical-log/resolve-process/<?php echo $each['id'];?>/1/5">Yes</a>
                                                        </div>
                                                        </div>
                                                        
                                                        
														<td class="text-center">
														<?php if($each['status'] ==1 && $each['action_by'] !=""){
															 $get_full_name = get_user_details_new($each['action_by']);
														?>                                                      
                                                        <?php echo ucfirst(filter_string($get_full_name['fullname'])).'<br />'.kod_date_format(filter_string($each['action_date']));?>													<?php } else {?>
                                                        <a href="#confirm_action_by<?php echo $each['id'];?>" class="btn btn-sm btn-danger dialogue_window white_link">Action</a>
                                                        <?php } ?>
                                                        </td>
                                                        
                                                        <div id="confirm_action_by<?php echo $each['id'];?>" style="display:none">
                                                        <h4>Confirmation</h4>
                                                        <p>Are you sure you want to take action?</p>
                                                        <div class="modal-footer"> 
                                                        
                                                        <!--Tab id 5 Recalls action by 2--> 
                                                        <a class="btn btn-success" href="<?php echo SURL?>clinical-log/resolve-process/<?php echo $each['id'];?>/2/5">Yes</a>
                                                        </div>
                                                        </div>
                                                                                       						
                                                        <td class="text-center"> <a class="btn btn-sm btn-warning  fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>clinical-log/get-recalls-details/<?php echo $each['id'];?>">View</a></td>
                                					</tr>
                                					 <?php 
														endforeach; // foreach
													 }  else { ?>
													 
                     									<td colspan="4"> No record founded..</td>
                     
  			   										<?php } ?>	
                                					
                                				</tbody>
                                			</table>

                                			<form id="add_clinical_recalls_frm"  name="add_clinical_recalls_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-recalls-process" autocomplete="off">
                                				<div class="row">
                                					<div class="col-md-12">
                                						<label>Date </label>
													<input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                					</div>
                                				</div>
                                				<br />
                                				
                                             
                                                <div class="form-group">
                        						<label>Details</label>
												<textarea class="form-control" rows="4" id="details" name="details"></textarea>  
                                                </div>                              				
                                                <br />

                                				<div class="row">
	                                				<div class="col-md-12 text-right">
	                                					<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/5" style="color:#FFF">Print Log</a>
	                                					<button class="btn btn-sm btn-success" type="submit" id="add_clinical_recalls_btn" name="add_clinical_recalls_btn">Add New Entry</button>
	                                				</div>
                                				</div>

                                			</form>

                                		</div>
                                	</div>

                                </div>

                                <!-- Tab Contents [ responsible_pharmacist ] -->
                                <div id="responsible_pharmacist" class="tab-pane fade in <?php echo ($active_tab == 6 ) ? 'active': '' ?>">
                                	
                                	<div class="row">
                                		<div class="col-md-12">
                                			
                                			<table class="table table-hover table-bordered">
                                				<thead>
                                					<tr>
                                						<th class="text-center">Date</th>
                                						<th class="text-center">Check in time</th>
                                						<th class="text-center">Check out time</th>
                                						<th class="text-center">Responsible Pharmacist</th>
                                                        <th class="text-center">CD Key Transfer</th>
                                						<th class="text-center">Responsible Pharmacist Notice</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					
                                					<?php if(!empty($list_cl_responsible_pharmacist)) {
					  										foreach($list_cl_responsible_pharmacist as $each): 
			  										?>
                                					<tr>
                                                        <td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                                                        <td class="text-center"><?php echo filter_string($each['checkin_time']); ?></td>
                                                        <td class="text-center">
                                                        	<div class="col-md-7 hidden" id="checkout_time_container_<?php echo $each['id'] ?>" >
                                                                <input type="text" class="form-control input-sm timepicker_1" id="checkout_time_<?php echo $each['id'] ?>" name="checkout_time" data-format="hh:mm"  readonly="readonly" placeholder="Either enters checkin or check out, not both." />
                                                                <button class="btn btn-xxs btn-success save_checkout_btn" data-id="<?php echo $each['id'] ?>" id="save_checkout_btn_<?php echo $each['id'] ?>"><i class="fa fa-check"></i></button> 
                                                                <button class="btn cancel_checkout btn-xxs btn-danger" data-id="<?php echo $each['id'] ?>"><i class="fa fa-times"></i> </button>
                                                            </div>
															<?php 
																if(filter_string($each['checkout_time']) == '00:00:00')
																	echo "<a href='javascript:;' id='checkout_link_".$each['id']."' data-id='".$each['id']."' class='show_checkout_time' >Set Checkout Time</a>";
																else
																	echo filter_string($each['checkout_time']); 
															?>
                                                        </td>  
                                                        <td class="text-center"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>                                                       
                                                        <td class="text-center"><?php echo ucfirst(filter_string($each['pharma_first_name'])).' '.ucfirst(filter_string($each['pharma_last_name']));?></td>                                                       
                                                        <td class="text-center">
                                                         <?php if($this->session->user_type == 2){?>
                                                          <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/responsible-pdf/6" style="color:#FFF">Print</a>
                                                         <?php } ?>   
                                                         </td>
                                					</tr>
                                					 <?php 
														endforeach; // foreach
													 }  else { ?>
													 
                     									<td colspan="6"> No record found..</td>
                     
  			   										<?php } ?>	
                                					
                                				</tbody>
                                			</table>

                                			<?php 
												if($last_cl_responsible_pharmacist['checkout_time'] == '00:00:00'){
											?>
                                            		<div class="alert alert-sm alert-danger">Checkout time is missing in your last check-in entry. Please update your checkout time first. </div>
                                            <?php		
												}else{
											?>
                                                    <form id="add_clinical_responsible_pharmacist_frm"  name="add_clinical_responsible_pharmacist_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-responsible-pharmacist-process" autocomplete="off">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Date </label>
                                                                <input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                        <br />
                                                        
                                                        <div class="row">
                                                            
                                                            <div class=" form-group col-md-12">
                                                                <label>Check-in Time </label>
                                                                <input type="text" id="checkin_time" name="checkin_time"  data-format="hh:mm"  readonly="readonly" class="form-control input-small time" placeholder="Either enters checkin or check out, not both." value="09:00"/>
                                                            </div>
                                                            <br><br><br><br>
                                                            
                                                            <!--<div class="form-group col-md-12">
                                                                <label>Check Out Time </label>
                                                                <input type="text" class="form-control input-small time" id="checkout_time" name="checkout_time" data-format="hh:mm"  readonly="readonly" placeholder="Either enters checkin or check out, not both." />
                                                            </div>-->
        
                                                        </div>
                                                        
                                                        <div class="row">
                                                            
                                                            <div class=" form-group col-md-12">
                                                                <label>Controlled Drugs Cabinet Key Transferred to (optional)</label>
                                                                <select class="form-control" name="pharmacist_id" id="pharmacist_id">
                                                                	<option value="">Select Pharmacist</option>
                                                                    <?php 
																		for($i=0;$i<count($pharmacy_pharmacist_list);$i++){
																			if($pharmacy_pharmacist_list[$i]['user_id']){
																	?>
                                                                    		<option value="<?php echo $pharmacy_pharmacist_list[$i]['user_id']?>"><?php echo ucwords($pharmacy_pharmacist_list[$i]['first_name'].' '.$pharmacy_pharmacist_list[$i]['last_name']) ?></option>
                                                                    <?php	
																			}//end if($pharmacy_pharmacist_list['user_id'])
																		}//end for($i=0; $i<count($pharmacy_pharmacist_list);$i++)
																	?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <div class="row">
                                                            <div class="col-md-12 text-right">
                                                                <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/6" style="color:#FFF">Print Log</a>
                                                                <button class="btn btn-sm btn-success" type="submit" id="add_clinical_responsible_pharmacist_btn" name="add_clinical_responsible_pharmacist_btn">Add New Entry</button>
                                                            </div>
                                                        </div>
        
                                                    </form>
											<?php 
												}//end if($last_cl_responsible_pharmacist['checkout_time'] == '00:00:00')
											?>
                                		</div>
                                	</div>

                                </div>

                                <!-- Tab Contents [ maintenance ] -->
                                <div id="maintenance" class="tab-pane fade in <?php echo ($active_tab == 7 ) ? 'active': '' ?>">
                                	
                                	<div class="row">
                                		<div class="col-md-12">
                                			
                                			<table class="table table-hover table-bordered">
                                				<thead>
                                					<tr>
                                						<th class="text-center">Date identified</th>
                                						<th class="text-center">User who identified issue</th>
                                						<th class="text-center">Maintenance issue</th>
                                						<th class="text-center">Contractor name </th>
                                						<th class="text-center">Issue Resolved? </th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					<?php if(!empty($list_cl_maintenance)) {
					  										foreach($list_cl_maintenance as $each): 
															
			  										?>
                                					<tr>
                                                        <td class="text-center"><?php echo kod_date_format(filter_string($each['identified_date'])); ?></td>
                                						<td class="text-center"><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                                						<td class="text-center"><?php echo filter_string($each['maintenance_issue']); ?> </td>
                                						<td class="text-center"><?php echo filter_string($each['contractor_name_details']); ?></td>
                                						<td class="text-center">
                                                         <?php if($each['status'] ==1){
														        $get_full_name =	get_user_details_new($each['resolved_by']);
?> 
                                                         <?php echo ucfirst(filter_string($get_full_name['fullname'])).'<br />'.kod_date_format(filter_string($each['reslove_date']));?>													<?php } else {?>
                                                        <a href="#confirm_reslove<?php echo $each['id'];?>" class="btn btn-sm btn-danger dialogue_window white_link">Resolved</a>
                                                      <?php } ?>
                                                        </td>
                                                        
                                                        <div id="confirm_reslove<?php echo $each['id'];?>" style="display:none">
                                                        <h4>Confirmation</h4>
                                                        <p>Are you sure you want to resolve?</p>
                                                        <div class="modal-footer"> 
                                                        <a class="btn btn-success" href="<?php echo SURL?>clinical-log/resolve-process/<?php echo $each['id'];?>">Resolve Now</a>
                                                        </div>
                                                        </div>
                                					</tr>
                                                    <?php 
														endforeach; // foreach
													 }  else { ?>
													 
                     									<td colspan="5"> No record founded..</td>
                     
  			   										<?php } ?>	
                                					
                                				</tbody>
                                			</table>

                                		<form id="add_clinical_maintenance_frm"  name="add_clinical_maintenance_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-maintenance-process" autocomplete="off">
                                				<div class="row">
                                					<div class="col-md-12">
                                						<label>Date identified</label>
                                						<input type="text" id="identified_date" name="identified_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                					</div>
                                				</div>
                                				<br />
                                				
                        						<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>Maintenance issue</label>
                                						<input type="text" id="maintenance_issue" name="maintenance_issue"  class="form-control"/>
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>Contractor name and details </label>
                                						<input type="text" id="contractor_name_details" name="contractor_name_details"  class="form-control"/>
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
                                					<div class="col-md-12">
                                						<label>Date reported</label>
                                						<input type="text" id="reported_date" name="reported_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
	                                				<div class="col-md-12 text-right">
	                                					<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/7" style="color:#FFF">Print Log</a>
	                                					<button class="btn btn-sm btn-success" id="add_clinical_maintenace_btn" name="add_clinical_maintenace_btn" type="submit">Add New Entry</button>
	                                				</div>
                                				</div>

                                			</form>

                                		</div>
                                	</div>

                                </div>

                                <!-- Tab Contents [ self_care ] -->
                                <div id="self_care" class="tab-pane fade in <?php echo ($active_tab == 8 ) ? 'active': '' ?>">
                                	
                                	<div class="row">
                                		<div class="col-md-12">
                                			
                                			<table class="table table-hover table-bordered">
                                				<thead>
                                					<tr>
                                						<th class="text-center">Date </th>
                                						<th class="text-center">Gender </th>
                                						<th class="text-center">Approximate Age </th>
                                						<th class="text-center">Prescription item  </th>
                                						<th class="text-center">Details</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					<?php if(!empty($list_cl_self_care)) {
					  										foreach($list_cl_self_care as $each): 
															
			  										?>
                                					<tr>
                                                        <td class="text-center"><?php echo kod_date_format(filter_string($each['entry_date'])); ?></td>
                                						<td class="text-center"><?php echo filter_string($each['gender']);?></td>
                                						<td class="text-center"><?php echo filter_string($each['approximate_age']); ?> </td>
                                						<td class="text-center"><?php echo filter_string($each['prescription_item']); ?></td>
                                						<td class="text-center">
                                                         <a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>clinical-log/get-clinical-self-care-details/<?php echo $each['id'];?>"><button class="btn btn-sm btn-warning">View</button>
</a>
                                                        </td>
                                					</tr>
                                                    <?php 
														endforeach; // foreach
													 }  else { ?>
													 
                     									<td colspan="5"> No record founded..</td>
                     
  			   										<?php } ?>	
                                					
                                				</tbody>
                                			</table>

                                			<form id="add_clinical_self_care_frm"  name="add_clinical_self_care_frm"  method="post" action="<?php echo SURL?>clinical-log/clinical-self-care-process" autocomplete="off">
                                				<div class="row">
                                					<div class="col-md-12">
                                						<label>Date</label>
                                						<input type="text" id="entry_date" name="entry_date" value="<?php echo date('d/m/Y');?>" required="required" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                					</div>
                                					<div class="form-group col-md-12">
                                                    	<br />
                                						<label>Gender</label>
                                						<br />
                                						<label> <input type="radio" id="gender" name="gender" value="Male" /> Male </label>
                                						&nbsp; &nbsp; &nbsp; &nbsp;
                                						<label> <input type="radio" id="gender" name="gender" value="Female"/> Female </label>
                                					</div>
                                				</div>
                                				<br />
                                				
                        						<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>Approximate age</label>
                                						<input type="text" class="form-control" id="approximate_age" name="approximate_age" />
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>Prescription item </label>
                                						<input type="text" class="form-control" id="prescription_item" name="prescription_item" />
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>Rx advice given</label>
                                						<input type="text" class="form-control" id="rx_advice_given" name="rx_advice_given"/>
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>OTC Request</label>
                                						<input type="text" class="form-control" id="otc_request" name="otc_request"/>
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>OTC advice given</label>
                                						<input type="text" class="form-control" id="otc_advice_given" name="otc_advice_given" />
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
                                					<div class="form-group col-md-12">
                                						<label>Follow up care given</label>
                                						<input type="text" class="form-control" id="follow_up_care_given" name="follow_up_care_given"/>
                                					</div>
                                				</div>
                                				<br />

                                				<div class="row">
	                                				<div class="col-md-12 text-right">
	                                					<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>clinical-log/clinical-common-pdf/8" style="color:#FFF">Print Log</a>
	                                					<button class="btn btn-sm btn-success" type="submit" id="add_clinical_self_care_btn" name="add_clinical_self_care_btn">Add New Entry</button>
	                                				</div>
                                				</div>

                                			</form>

                                		</div>
                                	</div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<form name="checkout_save_frm" method="post" id="checkout_save_frm" action="<?php SURL?>clinical-log/update-checkout-time-process" class="hidden">
<input type="hidden" readonly="readonly" value="" name="checkout_time_fld" id="checkout_time_fld" />
<input type="hidden" readonly="readonly" value="" name="checkout_id" id="checkout_id" />
</form>
<script type="text/javascript">
 $(document).ready(function() {
	 
    $('#add_clinical_diary_frm').formValidation({
        framework: 'bootstrap',
        icon: {
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            subject: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
			 
			 details: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
			
        }
    });

$('#add_clinical_errors_frm').formValidation({
		framework: 'bootstrap',
		icon: {
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			error_attributed: {
				validators: {
					notEmpty: {
						message: 'Please fill out this fields.'
					}
				}
			},
			 
			 npsa_class: {
				validators: {
					notEmpty: {
						message: 'Please select class.'
					}
				}
			},
			 subject: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
			 
			 details: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
		}
	});
	
	$('#add_clinical_date_checking_frm').formValidation({
        framework: 'bootstrap',
        icon: {
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            subject: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            },
			 
			 medicine_type: {
                validators: {
                    notEmpty: {
                        message: 'Please select medicine type.'
                    }
                }
            },
			
			 notes: {
                validators: {
                    notEmpty: {
                          message: 'Please fill out this fields.'
                    }
                }
            },
						
        }
    });
	
$('#add_clinical_cleaning_frm').formValidation({
	framework: 'bootstrap',
	icon: {
		validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
		 location_area: {
			validators: {
				notEmpty: {
					message: 'Please select location area.'
				}
			}
		},
	}
});

$('#add_clinical_recalls_frm').formValidation({
	framework: 'bootstrap',
	icon: {
		validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
		 details: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
	}
});

$('#add_clinical_responsible_pharmacist_frm').formValidation({
	framework: 'bootstrap',
	icon: {
		validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
		 checkin_time: {
			validators: {
				notEmpty: {
					 message: 'Please select checkin time.'
				}
			}
		},
		
	}
});


  
$('#add_clinical_maintenance_frm').formValidation({
	framework: 'bootstrap',
	icon: {
		validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
		 maintenance_issue: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
		
		 contractor_name_details: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
		
		
	}
});

$('#add_clinical_self_care_frm').formValidation({
	framework: 'bootstrap',
	icon: {
		validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
		 gender: {
			validators: {
				notEmpty: {
					 message: 'Please select gender.'
				}
			}
		},
		
		 approximate_age: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
		
		 prescription_item: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
		
		
		 rx_advice_given: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
		
		otc_request: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
		
		otc_advice_given: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
		
		follow_up_care_given: {
			validators: {
				notEmpty: {
					 message: 'Please fill out this fields.'
				}
			}
		},
	
	}
});
	
	$('.show_checkout_time').click(function(){
	
		id = $(this).attr('data-id');
		$('#checkout_time_container_'+id).removeClass('hidden');
		$(this).addClass('hidden');
	
	});
	
	$('.cancel_checkout').click(function(){
		id = $(this).attr('data-id');
		$('#checkout_time_container_'+id).addClass('hidden');
		$('#checkout_link_'+id).removeClass('hidden');
		
	});

	$('.save_checkout_btn').click(function(){
		
		id = $(this).attr('data-id');
		checkout_time = $('#checkout_time_'+id).val();
		
		$('#checkout_time_fld').val(checkout_time);
		$('#checkout_id').val(id);
		$('#checkout_save_frm').submit();
		
	});
	
	

	$('.timepicker_1').timepicker({
		 minuteStep: 1,
		 disableFocus: true,
		 template: 'dropdown',
		 showInputs: false,
		 showMeridian:false,
		 maxHours: 24
	});


});

</script>
