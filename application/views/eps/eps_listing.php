
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

	$EPS_BLUE_TEXT = 'EPS_BLUE_TEXT';
	$eps_blue_text = get_global_settings($EPS_BLUE_TEXT); //Set from the Global Settings
	$eps_blue_text = filter_string($eps_blue_text['setting_value']);

	if($this->session->pmr_org_pharmacy){
		
		//echo $this->session->organization_id;exit;
		
		//print_this($this->session); exit; 
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>EPS Form</strong></div>
      <div class="panel-body">
        <p class="align-left"></p>
            <div class="row">
              <div class="col-md-12">
					<?php 
                        if(!$this->session->dismiss_message['eps']){
					?>
                            <p class="alert alert-info in alert-dismissable">
                                <a href="#" data-pharmacy="" data-org="<?php echo $this->session->organization_id?>" data-type="eps" class="close dismiss_message" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <i class="fa fa-info-circle"></i> <?php echo $eps_blue_text; ?>
                            </p>
                    <?php		
						}//end if(!$this->session->dismiss_message['eps'])
                    ?>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                                
                            <!-- Stat - tabs -->
                            <ul class="nav nav-tabs">
                                <li class="<?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>"><a data-toggle="tab" href="#eps_list">EPS Form</a></li>
                                <li class="<?php echo($active_tab == 2) ? 'active' : ''; ?>"><a data-toggle="tab" href="#embed_form">EPS Embed Code</a></li>
                            </ul>
                            <!-- Start - tabs body -->
                            <div class="tab-content">
                                <!-- First Active Tab Contents -->
                                <div id="eps_list" class="tab-pane fade in  <?php echo($active_tab == 1 || !$active_tab) ? 'active' : ''; ?>">
                                	<div class="row">
                                     <div class="col-md-12" style="margin-top:20px;">
                                			
                                	 <?php if(!empty($eps_list)) { $DataTableId = "eps-form-list";} else { $DataTableId; }?>
                                        <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
                                           <thead>
                                            <tr class="info">
                                				
                                						<th>Date</th>
                                						<th>Name</th>
                                                        <th>DOB</th>
                                                        <th>Phone</th>
                                                        <th>NHS No</th>
                                                        <th>Address</th>
                                                        <th>PostCode</th>
                                                        
                                						
                                					</tr>
                                				</thead>
                                				<tbody>
                                                
                                                  <?php if(!empty($eps_list)) {
					  										foreach($eps_list as $each): 
														
			  										?>
                                					<tr>
                                						<td><?php echo kod_date_format(filter_string($each['created_date'])); ?></td>
                                						<td><?php echo ucfirst(filter_string($each['first_name'])).' '.ucfirst(filter_string($each['last_name']));?></td>
                                						<td><?php echo kod_date_format($each['dob']);?></td>
                                						<td><?php echo filter_string($each['phone_no']);?></td>
                                                        <td><?php echo filter_string($each['nhs_no']);?></td>
                                                        <td><?php echo filter_string($each['address_1']);?></td>
                                                        <td><?php echo filter_string($each['postcode']);?></td>
                                                        
                                                        
                                					</tr>
                                					 <?php 
														endforeach; // foreach
													 }  else { ?>
													 
                     									<td colspan="5"> No record founded..</td>
                     
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
                                              <input type="text" class="form-control" value="<?php echo htmlentities("<iframe src='".SURL."eps-embed/".$this->session->pharmacy_surgery_id."' width='100%' height='100%' frameborder='0'></iframe>")?>" aria-describedby="sizing-addon1"  onfocus="$(this).select();" onclick="$(this).select();">
                                            
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
		<h3>EPS Form</h3>
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