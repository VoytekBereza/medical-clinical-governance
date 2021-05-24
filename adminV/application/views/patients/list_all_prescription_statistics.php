<?php // echo $search_patient; exit; ?>
<style>

#result_patient li.selected {
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
			<h2>Prescription Audit<small>Prescription Audit</small></h2> 
			<div class="clearfix"></div>
			</div>
            
              <?php $page = ($this->uri->segment(3)) ? '/'.$this->uri->segment(3) : '' ; ?>

		          <form id="statistic_frm" name="statistic_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>patient/list-all-prescription-statistics<?php echo $page; ?>">
            
                <div class="container">
                <div class="col-sm-4 col-md-4 col-lg-4">

                    <label for="is_default_doc">Search a patient:</label>
                    <input type="text" autocomplete="off" placeholder="Search a patient"  class="form-control search_patient" name="search_patient" id="search_patient" value="<?php echo  filter_string($search_patient); ?>" />
                     <input type="hidden" class="form-control search_patient" name="search_patient_email" id="search_patient_email" value="<?php echo $search_patient_hidden; ?>"  />
                    
                    
                    <div id="result_patient"></div>
                </div>

                <div class="col-md-4">
                  <div>
                  	<label>From</label>
                  	<input type='text' class="form-control date remove_last" id="from_date" name="from_date" readonly="readonly" value="<?php echo $from_date_hidden; ?>" />
                  </div>
                </div>
                        
                <div class="col-md-4">
                  <div >
                  	<label>To</label>
                  	<input type='text' class="form-control date remove_last" id="to_date" name="to_date" readonly="readonly" value="<?php echo $to_date_hidden; ?>" />
                  </div>
                </div>
                 <br /><br /> <br /><br />
                    <div class="row">
                   <div class="col-md-2"></div>
                   <div class="col-md-1" style="padding-top:10px;">
             		 	 OR
              	 </div>
                </div>   
                   <div class="row">
                       <div class="col-md-12">
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="week" <?php if($date_search_hidden!="" && $date_search_hidden =="week"){?> checked="checked"<?php }?>>Last Week</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="month" <?php if($date_search_hidden!="" && $date_search_hidden =="month"){?> checked="checked"<?php }?>>Last Month</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="three_month" <?php if($date_search_hidden!="" && $date_search_hidden =="three_month"){?> checked="checked"<?php }?>>Last 3 Months</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="six_month" <?php if($date_search_hidden!="" && $date_search_hidden =="six_month"){?> checked="checked"<?php }?>>Last 6 Months</label>
                          <label class="radio-inline remove_dates"><input type="radio"  name="date_search" id="date_search" value="year" <?php if($date_search_hidden!="" && $date_search_hidden =="year"){?> checked="checked"<?php }?>>Last 1 Year</label>
                       </div>
                   </div>    
                                    
                    <br />           
                    <div class="row pull-right">
                       <div class="col-md-12">
                        <button id="new_page_btn" name="new_page_btn" class="btn btn-success search_date" type="button" >Filter</button>
                       </div>
                    </div>
                </div>
            </form>
               
            <!--$DataTableId ="orderdetails";-->
               
            <br />
               <div class="pull-right">
                <form  id="csv_prescription_statistics_frm" name="csv_prescription_statistics_frm"  method="post" enctype="multipart/form-data" action="<?php echo SURL?>patient/download-csv-prescription-statistics">
                    <input type="hidden" name="csv_to_date" value="<?php echo $to_date_hidden; ?>" />
                    <input type='hidden' name="csv_from_date" value="<?php echo $from_date_hidden; ?>"/>
                    <input type='hidden' name="csv_date_search" value="<?php echo $date_search_hidden; ?>"/>
                     <input type='hidden' name="csv_patient_name" value="<?php echo $search_patient_hidden; ?>"/>
                    <button type="submit" class="btn btn-success" name="prescription_statics_btn" id="prescription_statics_btn">Export Csv</button>
                    
                </form>
               </div>
               <div id="ajax_responce_id">
              
                <?php if(!empty($transaction_list)){ $DataTableId ="";} else { $DataTableId = '';} //echo '<pre>'; print_r($transaction_list); exit; ?>

                  <table id="<?php echo $DataTableId; ?>" class="table table-bordered table-hover table-prices">
                      <thead>
                          <tr>
                             <th> Order date</th>
                             <th> Pharmacy Name </th>
                             <th> Patient Name </th>
                             <th> Action </th>
                             
                          </tr>
                      </thead>
                      <tbody id="price-compare-tbody">

                        <?php 
							if(!empty($transaction_list)){
								  foreach($transaction_list as $each) {	
							?>
                            <tr class="newRow">
                                <td> <?php echo kod_date_format(filter_string($each['created_date']), true); ?> </td>
                                <td> <?php echo filter_string($each['pharmacy_surgery_name']).' - '.filter_string($each['postcode']);?> </td>
                                <td> <?php echo filter_string($each['patient_name']);?> </td>
                            	  <td>
                                  
                                 <a class="btn btn-xxs btn-success preview" data-fancybox-type="ajax" href="<?php echo SURL; ?>patient/preview-current-statistics/<?php echo $each['organization_id'];?>/<?php echo $each['pharmacy_surgery_id'];?>/<?php echo $each['id'];?>" id="preview" rel="<?php echo $each['id']; ?>" > View Details </a>
                                 </td>
                            </tr>
                                                
                            <!-- Hidden forms containing data to show on preview > -->
						
                            <div class="col-md-12 hidden">

                							<form id="prescription-preview-form-<?php echo $each['id']; ?>" method="post">
                								
                								<!-- Patient id - hidden field -->
                								<input type="hidden" name="patient_id" value="<?php echo filter_string($each['patient_id']); ?>" readonly="readonly"/>
                								<input type="hidden" name="approve-transaction" value="1" readonly="readonly"/>
                								<input type="hidden" name="order-detail-id" value="<?php echo filter_string($each['id']); ?>" readonly="readonly"/>
                								
                								<input name="transaction[medicine_class][]" type="hidden" value="<?php echo filter_string($each['medicine_class']); ?>" readonly="readonly">
                								<input name="transaction[medicine_strength_id][]" type="hidden" value="<?php echo filter_string($each['strength_id']); ?>" readonly="readonly">
                								<input name="transaction[medicine_full_name][]" type="hidden" value="<?php echo filter_string($each['medicine_full_name']); ?>" readonly="readonly">
                								<input name="transaction[medicine_id][]" type="hidden" value="<?php echo filter_string($each['medicine_id']); ?>" readonly="readonly">
                								<input name="transaction[strength][]" type="hidden" value="<?php echo filter_string($each['strength']); ?>" readonly="readonly">
                								<input name="transaction[medicine_form][]" type="hidden" value="<?php echo filter_string($each['medicine_form']); ?>" readonly="readonly">
                								<input class="form-control" name="transaction[suggested_dose][]" type="hidden" value="<?php echo filter_string($each['suggested_dose']); ?>" readonly="readonly">
                								<input class="form-control" min="1" name="transaction[qty][]" placeholder="Qty" type="hidden" value="<?php echo filter_string($each['quantity']); ?>" readonly="readonly">

                							</form>

                						</div>
						                <!-- ./end hidden forms div -->
<?php 
									 			 } // end foreach loop

										  } else { ?>
                                            
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
</div>
