<style>
    #result_pharmacy li.selected {
        background-color: #ddd;
    }
</style>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php } // end if($this->session->flashdata('err_message')) ?>
        <?php if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="row">
			<div class="x_title">
			<h2>Pharmacy Audit<small>Pharmacy Audit</small></h2> 
			<div class="clearfix"></div>
			</div>
				<form id="pharmacy_statistic_frm" name="pharmacy_statistic_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>patient/list-all-pharmacy-statistics">
                
                    <div class="container">
                    
                    <div class="col-sm-4 col-md-4 col-lg-4">
                                    <label for="is_default_doc">Search a pharmacy:</label>
                                    <input type="text" autocomplete="off" placeholder="Search a Pharmacy"  class="form-control search_pharmacy" name="search_pharmacy" id="search_pharmacy" value="<?php echo filter_string($search_pharmacy);?>"  />
                                     <input type="hidden"  name="search_pharmacy_post_code" id="search_pharmacy_post_code" value="<?php echo $search_pharmacy_hidden_post_code; ?>" />
                                     <input type="hidden"  name="pharmacy_surgery_id" id="pharmacy_surgery_id" value="<?php echo $search_pharmacy_hidden_id; ?>" />
                                                                         
                                    <div id="result_pharmacy"></div>
                                </div>
                    
                          <div class="col-md-4">
                            <div>
                            	<label>From</label>
                            	<input type='text' class="form-control date remove_last" id="from_date" name="from_date" readonly="readonly"  value="<?php echo $from_date_hidden; ?>"/>
                            </div>
                     </div>
                      <div class="col-md-4">
                            <div >
                            	<label>To</label>
                            	<input type='text' class="form-control date remove_last" id="to_date" name="to_date" readonly="readonly"  value="<?php echo $to_date_hidden; ?>"/>
                            </div>
                          </div>
                          
                          <div class="row">
                          <div class="col-md-2"></div>
                             <div class="col-md-1" style="padding-top:10px;">
                       		 	 OR
                        	 </div>
                          </div>   
                             
                                 <div class="col-md-12">
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="week" <?php if($date_search_hidden!="" && $date_search_hidden =="week"){?> checked="checked"<?php }?>>Last Week</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="month" <?php if($date_search_hidden!="" && $date_search_hidden =="month"){?> checked="checked"<?php }?>>Last Month</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="three_month" <?php if($date_search_hidden!="" && $date_search_hidden =="three_month"){?> checked="checked"<?php }?>>Last 3 Months</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="six_month" <?php if($date_search_hidden!="" && $date_search_hidden =="six_month"){?> checked="checked"<?php }?>>Last 6 Months</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="year" <?php if($date_search_hidden!="" && $date_search_hidden =="year"){?> checked="checked"<?php }?>>Last 1 Year</label>
                       </div>
                                
                                              
                            <br />   
                            <div class="row pull-right">
                               <div class="col-md-12">
                            	<button id="new_page_btn" name="new_page_btn" class="btn btn-success pharamcy_search_statistics" type="button" >Filter</button>
                               </div>
                            </div>
                    </div>
                </form>
                <br />
                 <br />
               
               <div class="pull-right">
                <form  id="csv_pharmacy_statistics_frm" name="csv_pharmacy_statistics_frm"  method="post" enctype="multipart/form-data" action="<?php echo SURL?>patient/download-csv-pharamcy-statistics">
                 	
                    <input type="hidden" name="csv_to_date" value="<?php echo $to_date_hidden; ?>" />
                    <input type="hidden" name="csv_from_date" value="<?php echo $from_date_hidden; ?>"/>
                    <input type="hidden" name="csv_date_search" value="<?php echo $date_search_hidden; ?>"/>
                     <input type="hidden" name="csv_pharmacyt_post_code" value="<?php echo $search_pharmacy_hidden_post_code; ?>"/>
                     <input type="hidden" name="csv_pharmacy_surgery_id" value="<?php echo $search_pharmacy_hidden_id; ?>"/>
                    <button type="submit" class="btn btn-success" name="prescription_statics_btn" id="prescription_statics_btn">Export Csv</button>
                    
                </form>
               </div>
               
               <?php if(!empty($transaction_list)){?>
                 <span><strong><?php echo "No of Prescription ="." ".count($transaction_list);?></strong></span>
               <?php   }?>
                 <br />   <br />  
               <?php if(!empty($transaction_list)){ $DataTableId ="orderdetailspharmacy_statistics";} else { $DataTableId = '';} ?>
               <table id="<?php echo $DataTableId; ?>" class="table table-bordered table-hover table-prices">
                                    <thead>
                                        <tr>
                                           <th> Order date</th>
                                           <th> Pharmacy Name </th>
                                           <th> Patient Name </th>
                                           <th> Medicine Cost </th>
                                           <th> Delivery Cost </th>
                                           <th> Pharmacy Percentage </th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-compare-tbody">
                                    <?php if(!empty($transaction_list)){
										
											   $total_medicine_cost = 0;
											   $total_shiping_cost = 0;	
											  // $total_prescription_fee = 0;
											   $total_prescription_pharmacy_percentage = 0;
										        
												foreach($transaction_list as $each) {
													
												 $medicine_cost =($each['subtotal'] - $each['prescription_fee']);
											     
												 $PRESCRIPTION_PHARMACY_PERCENTAGE = 'PRESCRIPTION_PHARMACY_PERCENTAGE';
												 $prescription_pharmacy_percentage = get_global_settings($PRESCRIPTION_PHARMACY_PERCENTAGE);
										     	 $prescription_pharmacy_percentage = filter_string($prescription_pharmacy_percentage['setting_value']);
												 
												 $percentage = (filter_string($each['prescription_fee']) / 100) * $prescription_pharmacy_percentage;
												 
												  $total_medicine_cost = $total_medicine_cost+$medicine_cost;
												  
												  $total_shiping_cost = $total_shiping_cost+filter_string($each['shipping_cost']);	
												  
												 // $total_prescription_fee = $total_prescription_fee+filter_string($each['prescription_fee']);
												  $total_prescription_pharmacy_percentage = $total_prescription_pharmacy_percentage+$percentage;
												 													
									?>
                                                <tr class="newRow">
                                                    <td> <?php echo kod_date_format(filter_string($each['created_date']), true); ?> </td>
                                                    <td> <?php echo filter_string($each['pharmacy_surgery_name']). '- '.filter_string($each['postcode']);?> </td>
                                                    <td> <?php echo filter_string($each['patient_name']);?> </td>
                                                     <td> <?php if($medicine_cost!="") {echo '&pound'.filter_string($medicine_cost);} else {  echo '&pound'."0.00";}?> </td>
                                                    
                                                    <td> <?php if($each['shipping_cost']!="") {echo '&pound'.filter_string($each['shipping_cost']);} else {  echo '&pound'."0.00";}?> </td>
                                                    <td> <?php if($percentage!="") {echo '&pound'.filter_string($percentage);} else {  echo '&pound'."0.00";}?></td>
                                                </tr>
                                              
                                     <?php 
									 			 $i++;
												
												} // end foreach loop?>
                                                
                                                 <tr class="newRow">
                                                    <td> <strong>TOTAL (<?php echo '&pound';?>)</strong> </td>
                                                    <td> </td>
                                                    <td> </td>
                                                     <td><strong> <?php if($total_medicine_cost!="") {echo filter_string($total_medicine_cost);} else {  echo "0.00";}?> </strong></td>                                                    
                                                    <td><strong> <?php if($total_shiping_cost!="") {echo filter_string($total_shiping_cost);} else {  echo "0.00";}?> </strong></td>
                                                   <td><strong> <?php if($total_prescription_pharmacy_percentage!="") {echo $total_prescription_pharmacy_percentage;} else {  echo "0.00";}?></strong> </td>
                                                </tr>
									 	<?php 	} else { ?>
                                            
                                            	<tr class="newRow">
                                                    <td colspan="9"> No records found. </td>
                                                </tr>
												
									 <?php } // else condition ?>
                                        
                                    </tbody>
                                </table>
                                
                                <!-- Pagination Links -->
                                <div align="center">
                                  <ul class="pagination">
                                    <!-- Show pagination links -->
                                    <?php echo ($links) ? $links : '' ; ?>
                                  </ul>
                                </div>
    
        </div>
      </div>
    </div>
  </div>
</div>
