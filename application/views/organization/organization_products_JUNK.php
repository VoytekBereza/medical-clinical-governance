<?php
	$VAT_PERCENTAGE = 'VAT_PERCENTAGE';
	$global_vat_percentage = get_global_settings($VAT_PERCENTAGE);						

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
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>ORGANISATION PRODUCTS</strong></div>
      <div class="panel-body">
        <p class="align-left"></p>
        <div class="row">
          <div class="col-md-12">
				<a href="javascript:;" onClick="toggle_me_with_arrow('governance_prod','gov_arrow')"><h4>Governance <span class="pull-right"><i id="gov_arrow" class="fa fa-angle-down"></i></span></h4></a>
              
              	<div id="governance_prod" style="display: none">

                	<p><strong><h5>Governance Purchased Pharmacies</h5></strong></p>
                    <hr />
                    <div style="max-height:400px; overflow:auto">
                        <table class="table table-striped">
                            <tr class="info">
                              <th>Sr#</th>
                              <th>Pharamcy/ Surgery</th>
                              <th>Purchased Date</th>
                              <th>Expiry Date</th>
                              <th>Purchased By</th>
                            </tr>
                            <?php
								if(count($governance_purchased_pharmacies) > 0){
									
									for($i=0;$i<count($governance_purchased_pharmacies);$i++){
							?>
                                        <tr>
                                            <td><?php echo ($i+1)?></td>
                                            <td><?php echo filter_string($governance_purchased_pharmacies[$i]['pharmacy_surgery_name']);?></td>
                                            <td><?php echo kod_date_format(filter_string($governance_purchased_pharmacies[$i]['purchase_date']),FALSE);?></td>
                                            <td><?php echo kod_date_format(filter_string($governance_purchased_pharmacies[$i]['expiry_date']),FALSE);?></td>
                                            <td><?php echo filter_string($governance_purchased_pharmacies[$i]['purchased_by_name']);?></td>
                                        </tr>
                            <?php			
									}//end for

								}else{
							?>
	                            	<tr><td colspan="5" class="error">No Pharmacies Found.</td></tr>
                            <?php		
								}//end if(count($governance_purchased_pharmacies) > 0)
							
                            ?>
                           
                        </table>
                    </div>
                    <hr /> 
                    <p>
                    	<strong><h5>Governance NON Purchased Pharmacies <span class="pull-right"><label><input type="checkbox" id="check_all_pharmacies_gov" /> SELECT ALL PHARMACIES</label></span></h5> </strong> 
                    	
                    </p>
                    <hr />
                    <form action="<?php echo SURL?>/organization/governance-checkout" method="POST" enctype="multipart/form-data">
                        <div class="row" style="max-height:200px; overflow:auto">
                            <?php 
                                if(count($governance_non_purchased_pharmacies) > 0){
                                    
                                    for($i=0;$i<count($governance_non_purchased_pharmacies);$i++){
                            ?>
                                        <div class="col-md-4"><label><input type="checkbox" class="pharm_gov" name="pharm_gov_chk[]" value="<?php echo filter_string($governance_non_purchased_pharmacies[$i]['id'])?>" aria-required="true"> <?php echo filter_string($governance_non_purchased_pharmacies[$i]['pharmacy_surgery_name'])?></label></div>
                            <?php			
                                    }//end for
    						?>
                                    <p>&nbsp;</p>
                                    <div class="row bg-info" style="margin:0" >
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"><strong>SubTotal (&pound;):</strong> </div>
                                        <div class="col-md-2 subtotal_governance">0.00</div>
                                    </div>
                                    <div class="row bg-info" style="margin:0">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"><strong>VAT (&pound;):</strong> </div>
                                        <div class="col-md-2 vat_governance">0.00 </div>
                                    </div>
                                    <div class="row bg-info" style="margin:0">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"><strong>GrandTotal (&pound;):</strong> </div>
                                        <div class="col-md-2 grandtotal_governance" >0.00 </div>
                                    </div>
                                    <div class="row bg-info" style="margin:0">
                                        <div class="col-md-12 text-right"><button type="submit" name="gov_purchase_btn" id="gov_purchase_btn" class="btn btn-xs btn-warning"><i class="fa fa-paypal"></i> Check Out</button></div>
<input type="hidden" readonly="readonly" id="governance_price" name="governance_price" value="<?php echo filter_price($governance_package_list['price'])?>" />
                                    <input type="hidden" id="vat_percentage" name="vat_percentage" value="<?php echo filter_string($global_vat_percentage['setting_value']);?>" readonly="readonly" />                                                
                                    </div>
                                                    
                            
                            <?php
                                }else{
                            ?>
                                    <div class="alert alert-danger">No Pharmacies Found!</div>
                            <?php		
                                }//end if($count($governance_non_purchased_pharmacies) > 0)
                            ?>
                        </div>
                    </form>
                </div>
             	<hr /> 
           	 <!-- End - Global Settings --> 
          </div> 
        </div><!--END ROW -->
        <div class="row">
          <div class="col-md-12">
				<a href="javascript:;" onClick="toggle_me_with_arrow('survey_prod','survey_arrow')"><h4>Survey <span class="pull-right"><i id="survey_arrow" class="fa fa-angle-down"></i></span></h4></a>
              
              	<div id="survey_prod" style="display: none ">
                	<p><strong><h5>Survey Purchased Pharmacies</h5></strong></p>
                    <hr />
                    <div style="max-height:400px; overflow:auto">
                        <table class="table table-striped">
                            <tr class="info">
                              <th>Sr#</th>
                              <th>Pharamcy/ Surgery</th>
                              <th>Purchased Date</th>
                              <th>Expiry Date</th>
                              <th>Purchased By</th>
                            </tr>
                            <?php
								if(count($survey_purchased_pharmacies) > 0){
									
									for($i=0;$i<count($survey_purchased_pharmacies);$i++){
							?>
                                        <tr>
                                            <td><?php echo ($i+1)?></td>
                                            <td><?php echo filter_string($survey_purchased_pharmacies[$i]['pharmacy_surgery_name']);?></td>
                                            <td><?php echo kod_date_format(filter_string($survey_purchased_pharmacies[$i]['purchase_date']),FALSE);?></td>
                                            <td><?php echo (kod_date_format(filter_string($survey_purchased_pharmacies[$i]['expiry_date']),FALSE) == '0000-00-00') ? 'N/A' : kod_date_format(filter_string($survey_purchased_pharmacies[$i]['expiry_date']),FALSE);?></td>
                                            <td><?php echo filter_string($survey_purchased_pharmacies[$i]['purchased_by_name']);?></td>
                                        </tr>
                            <?php			
									}//end for

								}else{
							?>
	                            	<tr><td colspan="5" class="error">No Pharmacies Found.</td></tr>
                            <?php		
								}//end if(count($survey_purchased_pharmacies) > 0)
							
                            ?>
                           
                        </table>
                    </div>
                    <hr /> 
                    <p>
                    	<strong><h5>Survey NON Purchased Pharmacies <span class="pull-right"><label><input type="checkbox" id="check_all_pharmacies_survey" /> SELECT ALL PHARMACIES</label></span></h5> </strong> 
                    	
                    </p>
                    <hr />
                    <form action="<?php echo SURL?>/organization/survey-checkout" method="POST" enctype="multipart/form-data">
                        <div class="row" style="max-height:200px; overflow:auto">
                            <?php 
                                if(count($survey_non_purchased_pharmacies) > 0){
                                    
                                    for($i=0;$i<count($survey_non_purchased_pharmacies);$i++){
                            ?>
                                        <div class="col-md-4"><label><input type="checkbox" class="pharm_survey" name="pharm_survey_chk[]" value="<?php echo filter_string($survey_non_purchased_pharmacies[$i]['id'])?>" aria-required="true"> <?php echo filter_string($survey_non_purchased_pharmacies[$i]['pharmacy_surgery_name'])?></label></div>
                            <?php			
                                    }//end for
    						?>
                                    <p>&nbsp;</p>
                                    <div class="row bg-info" style="margin:0" >
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"><strong>SubTotal (&pound;):</strong> </div>
                                        <div class="col-md-2 subtotal_survey">0.00</div>
                                    </div>
                                    <div class="row bg-info" style="margin:0">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"><strong>VAT (&pound;):</strong> </div>
                                        <div class="col-md-2 vat_survey">0.00 </div>
                                    </div>
                                    <div class="row bg-info" style="margin:0">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"><strong>GrandTotal (&pound;):</strong> </div>
                                        <div class="col-md-2 grandtotal_survey" >0.00 </div>
                                    </div>
                                    <div class="row bg-info" style="margin:0">
                                        <div class="col-md-12 text-right"><button type="submit" name="survey_purchase_btn" id="survey_purchase_btn" class="btn btn-xs btn-warning"><i class="fa fa-paypal"></i> Check Out</button></div>
									<input type="hidden" readonly="readonly" id="survey_price" name="survey_price" value="<?php echo filter_price($survey_package_list['price'])?>" />
                                                                                    
                                    </div>
                            <?php
                                }else{
                            ?>
                                    <div class="alert alert-danger">No Pharmacies Found!</div>
                            <?php		
                                }//end if($count($survey_non_purchased_pharmacies) > 0)
                            ?>
                        </div>
                    </form>
                    
                </div>
             	<hr /> 
           	 <!-- End - Global Settings --> 
          </div> 
        </div><!--END ROW -->

      </div>
    </div>
  </div>
  
</div><!-- End class="row" -->
