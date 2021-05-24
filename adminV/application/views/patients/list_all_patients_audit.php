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
			<h2>User Audit <small>User Audit</small></h2> 
			<div class="clearfix"></div>
			</div>
				</span>
              <?php if(!empty($transaction_list)){ $DataTableId ="user_audit";} else { $DataTableId = '';}?>
                   
               <table id="<?php echo $DataTableId; ?>" class="table table-bordered table-hover table-prices">
                                    <thead>
                                        <tr>
                                           <th> Order date</th>
                                           <th>Transaction ID</th>
                                           <th> First Name </th>
                                           <th>Last Name </th>
                                           <th>Date of Birth</th>
                                           <th>Email Address</th>
                                           <th>Home Address</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody id="price-compare-tbody">
                                    <?php if(!empty($transaction_list)){
												
												foreach($transaction_list as $each) {	
									?>
                                                <tr class="newRow">
                                                    <td> <?php echo kod_date_format(filter_string($each['created_date']), true); ?> </td>
                                                    <td> <?php echo filter_string($each['transaction_id']);?> <br />
                                                    	AUTH CODE: (<?php echo filter_string($each['auth_code']);?>)
                                                    </td>
                                                    <td> <?php echo filter_string($each['first_name']);?> </td>
                                                    <td> <?php echo filter_string($each['last_name']);?> </td>
                                                	<td> <?php echo kod_date_format(filter_string($each['dob'])); ?></td>
                                                    <td> <?php echo filter_string($each['email_address']);?> </td>
                                                    <td>
														<?php echo filter_string($each['address']);?>, 
                                                        <?php echo (filter_string($each['address_2'])) ? filter_string($each['address_2']).', ' : '';?> 
                                                        <?php echo (filter_string($each['address_3'])) ? filter_string($each['address_3']).', ' : '';?> 
                                                        <?php echo filter_string($each['postcode']);?>
                                                    	
                                                    </td>
                                                </tr>
                                     <?php 
									 			} // end foreach loop
									 		} else { ?>
                                            
                                            	<tr class="newRow">
                                                    <td colspan="9"> No records found. </td>
                                                </tr>
												
									 <?php } // else condition ?>
                                        
                                    </tbody>
                                </table>
        </div>
      </div>
    </div>
  </div>
</div>
