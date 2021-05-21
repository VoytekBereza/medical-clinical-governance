<style>

  .popover-title {
    min-width: 250px;
  }
  .popover-content {
    min-width: 250px;
  }

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

<?php 
	if($this->session->pmr_org_pharmacy){
		
		//echo $this->session->organization_id;exit;
		
		//print_this($this->session); exit; 
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Repeat Prescription Request Form</strong></div>
      <div class="panel-body">
        <p class="align-left"></p>
            <div class="row">
              <div class="col-md-12">

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                        
						
        
                            <!-- Stat - tabs -->
                            <ul class="nav nav-tabs">
                                <li class="<?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>"><a data-toggle="tab" href="#rp_list">Repeat Prescription Request Form</a></li>
                                <li class="<?php echo($active_tab == 2) ? 'active' : ''; ?>"><a data-toggle="tab" href="#embed_form">Repeat Prescription Embed Code</a></li>
                            </ul>
                            <!-- Start - tabs body -->
                            <div class="tab-content">
                                <!-- First Active Tab Contents -->
                                <div id="rp_list" class="tab-pane fade in  <?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>">
                                	<div class="row">
                                		<div class="col-md-12" style="margin-top:20px;">
                                			
                                			<?php if(!empty($repeat_prescription_list)) { $DataTableId = "rp-form-list";} else { $DataTableId; }?>
                                        		<table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
                                           		<thead>
                                                     <tr class="info">
                                                        <th>Date</th>
                                                        <th>Patient Name</th>
                                                        <th>Medicine</th>
                                                        <th>GP Name &amp; Address</th>
                                                    </tr>
                                				</thead>
                                				<tbody>
                                                
                                                  <?php if(!empty($repeat_prescription_list)) {
													  
													//  print_this($repeat_prescription_list); exit;
					  										foreach($repeat_prescription_list as $each){
																
																$get_rp_details = get_rp_details($each['id']);
																$medicine_string = '';
																
																for($i=0;$i<count($get_rp_details);$i++){
																	$medicine_string .= $get_rp_details[$i]['medicine_name'].' (Qty '.$get_rp_details[$i]['medicine_qty'].') <br />';	
																}
			  										?>
                                					<tr>
                                						<td>
															<?php echo kod_date_format(filter_string($each['created_date'])); ?><br />
                                                            <?php 
																if(filter_string($each['note'])){
															?>
                                                                    <a href="javascript:;" 
                                    
                                                                        data-toggle="popover" 
                                                                        data-html="true"
                                                                        data-trigger="focus" 
                                                                        title="Note"
                                                                        data-content="<?php echo ($each['note']) ? filter_string($each['note']) : '' ; ?>">
                                                                        <label class="btn btn-xxs btn-warning">Note</label>
                                                                    </a>
                                                            <?php		
																}//end if(filter_string($each['note']))
															?>
                                                            
                                                        </td>
                                						<td>
                                                        
                                                            <a href="javascript:;" 
                                                            
                                                            data-toggle="popover" 
                                                            data-html="true"
                                                            data-trigger="focus" 
                                                            title="<?php echo ucfirst(filter_string($each['p_first_name'])).' '.ucfirst(filter_string($each['p_last_name'])).''; ?>"
                                                            data-content="<?php
                                                            echo ($each['contact_no']) ? '<strong>Contact: </strong>'.filter_string($each['mobile_no']).'<br>' : '' ;
															echo ($each['p_dob']) ? '<strong>DOB: </strong>'.kod_date_format($each['p_dob']).'<br>' : '' ;
															echo ($each['p_gender']) ? '<strong>Gender: </strong>'.filter_string($each['p_gender']).'<br>' : '' ;
															echo ($each['p_email_address']) ? '<strong>Email: </strong>'.filter_string($each['p_email_address']).'<br>' : '' ;
                                                            echo ($each['p_address']) ? '<strong>Address: </strong>'.filter_string($each['p_address']).'<br>' : '' ;
                                                            echo ($each['p_postcode']) ? '<strong>Postcode: </strong>'.filter_string($each['p_postcode']) : '' ;
															
                                                            ?>">
                                                            	<?php echo ucfirst(filter_string($each['p_first_name'])).' '.ucfirst(filter_string($each['p_last_name']));?>
                                                            </a>
                                                        
															
                                                          </td>                                                        
                                                          <td>
															<?php 
																echo filter_string($medicine_string);
															?>
                                                        </td>
                                                        <td>
															<?php echo filter_string($each['gp_name']);?><br />
                                                            <?php echo filter_string($each['gp_address']);?><br />
                                                        </td>

                                					</tr>
                                					 <?php 
															} // foreach
													 }  else { ?>
													 
                     									<td colspan="10"> No record found.</td>
                     
  			   										<?php } ?>	
                                					
                                				</tbody>
                                			</table>
		                          		</div>
                                	</div>
                                </div>
                                
                                <div id="embed_form" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <p>
                                            <div class="input-group input-group-lg">
                                              <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-link"></i></span>
                                              <input type="text" class="form-control" value="<?php echo htmlentities("<iframe src='".SURL."rp-embed/".$this->session->pharmacy_surgery_id."' width='100%' height='100%' frameborder='0'></iframe>")?>" aria-describedby="sizing-addon1"  onfocus="$(this).select();" onclick="$(this).select();">
                                            
                                            </div>                                                        
                                        </p>
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
<?php } else {?>

<div class="row">

	<div class="col-sm-8 col-md-8 col-lg-8">
		<h3>Repeat Prescription Request Form</h3>
	</div>
</div>

<div class="well">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                 <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
            </div>
        </div>
    </div>

<?php } ?>

<script>
$(document).ready(function(){
	$('[data-toggle="popover"]').popover({ trigger: "hover", placement: 'auto right' });   
});
</script>