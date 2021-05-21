<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading">
        <strong> View Contract </strong>
      </div>
      <div class="panel-body">
        <p class="align-left"></p>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">

					<?php 
                        if($user_org_superintendent || $this->session->pharmacy_surgery_id){ 
                    ?>
                        
                            <div class="">
                                <div id="hr">
                                    <div style="overflow-x:hidden; ">
                                            <?php 
                                            
                                                if(filter_string($user_signatures['signature_type']) == 'svn')
                                                    $signature_str = filter_string($user_signatures['signature']);
                                                elseif(filter_string($user_signatures['signature_type']) == 'image')
                                                    $signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";
                                                // if(filter_string($user_signatures['signature_type']) == 'svn')								

                                                
                                                $hr_contract = stripcslashes(filter_string($user_governance_read_data['hr_contract']));
                                                
                                                if($user_governance_read_data['no_contract'] != '1'){
                                                
                                                    // To be used below for DOWNLOAD
                                                    $hr_contract_download_html = stripcslashes($hr_contract);
                                                
                                                } // if($user_governance_read_data['no_contract'] == 1)
                                               
                                                $search_arr = array('[USER_SIGNATURE]',);
                                                $replace_arr = array($signature_str);
                                                $hr_contract = str_replace($search_arr,$replace_arr,$hr_contract);
                                                echo $hr_contract;
                                                
                                            ?>
                                    </div>
                                    
                                    <?php 
										if($user_governance_read_data['no_contract'] == '0'){
									?>
                                        <hr />
                                        <div class="bg-info" style="padding:10px;">
                                            <div class="row" style="margin-top: 10px; font-size:15px;">
                                                <div class="col-md-2 text-center"><img src="<?php echo IMAGES?>fa-share.png" width="30px"  /></div>
                                                <div class="col-md-2"><strong><?php echo uk_date_format($user_governance_read_data['hr_contract_sent_date']);?></strong> <br /> 
                                                    <?php echo uk_date_format($user_governance_read_data['hr_contract_sent_date'],true);?>
                                                </div>
                                                <div class="col-md-8">
                                                    Sent for signature to <strong><?php echo filter_name($user_governance_read_data['sent_to_f_name'].' '.$user_governance_read_data['sent_to_l_name'])?></strong> (<?php echo filter_string($user_governance_read_data['email_address'])?>)  <br />
                                                    <strong>IP:</strong> <?php echo filter_string($user_governance_read_data['hr_contract_sent_by_ip'])?>
                                                </div>
                                            </div>
                                            
                                            <div class="row" style="margin-top: 10px; font-size:15px;">
                                                <div class="col-md-2 text-center"><img src="<?php echo IMAGES?>fa-eye.png" width="30px"  /></div>
                                                <div class="col-md-2">
                                                    <strong><?php echo uk_date_format($user_governance_read_data['hr_contract_viewed_date']);?></strong> <br /> 
                                                    <?php echo uk_date_format($user_governance_read_data['hr_contract_viewed_date'],true);?>                                        
                                                </div>
                                                <div class="col-md-8">
                                                    Viewed by <strong><?php echo filter_name($user_governance_read_data['sent_to_f_name'].' '.$user_governance_read_data['sent_to_l_name'])?></strong> (<?php echo filter_string($user_governance_read_data['email_address'])?>)  <br />
                                                    <strong>IP:</strong> <?php echo filter_string($user_governance_read_data['hr_contract_viewed_ip'])?>
                                                </div>
                                            </div>
                                            
                                            <div class="row" style="margin-top: 10px; font-size:15px;">
                                                <div class="col-md-2 text-center"><img src="<?php echo IMAGES?>fa-signature.png" width="30px"  /></div>
                                                <div class="col-md-2">
                                                    <strong><?php echo uk_date_format($user_governance_read_data['created_date']);?></strong> <br /> 
                                                    <?php echo uk_date_format($user_governance_read_data['created_date'],true);?>                                        
                                                </div>
                                                <div class="col-md-8">
                                                    Signed by <strong><?php echo filter_name($user_governance_read_data['sent_to_f_name'].' '.$user_governance_read_data['sent_to_l_name'])?></strong> (<?php echo filter_string($user_governance_read_data['email_address'])?>)  <br />
                                                    <strong>IP:</strong> <?php echo filter_string($user_governance_read_data['created_by_ip'])?>
                                                </div>
                                            </div>
                                            
                                            <div class="row" style="margin-top: 10px; font-size:15px;">
                                                <div class="col-md-2 text-center"><img src="<?php echo IMAGES?>fa-check.png" width="30px"  /></div>
                                                <div class="col-md-2">
                                                    <strong><?php echo uk_date_format($user_governance_read_data['created_date']);?></strong> <br /> 
                                                    <?php echo uk_date_format($user_governance_read_data['created_date'],true);?>                                        
                                                </div>
                                                <div class="col-md-8">The document has been completed.</div>
                                            </div>
                                            
                                            <div class="row" style="margin-top: 10px; font-size:15px;">
                                                <div class="col-md-2 text-center"><img src="<?php echo IMAGES?>fa-user-id.png" width="30px"  /></div>
                                                <div class="col-md-2">
                                                    <strong>Unique ID</strong>
                                                </div>
                                                <div class="col-md-8"><?php echo filter_string($user_governance_read_data['view_code']);?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                     	<div class="col-md-9 text-justify" style="padding-top:20px;font-size:12px; color:#A3A3A3">
                                        	I have read and understood the contents of this Standard Operating Procedure; I have been appropriately trained to undergo the duties required of me; I have had the chance to ask questions to the clinical governance lead. I confirm that I will ensure that I remain up to date in all aspects of carrying out the duties listed in this Standard Operating Procedure.
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                        	<?php echo $signature_str?>
                                        </div>
                                        
                                     </div>
                                    <?php		
										}//end if($user_governance_read_data['no_contract'] == '1')
									?>
                                </div>
                            </div>
                            <hr />

                            <?php 
								if($user_governance_read_data['no_contract'] == '0'){ ?>
                                    <form action="<?php echo base_url(); ?>organization/download-hr" method="post">
                                        <textarea class="hidden" name="hr_html"><?php echo $hr_contract_download_html; ?></textarea>
                                        <div class="pull-right"> 
                                            <button type="submit" class="btn btn-sm btn-success"> Download </button> 
                                            <input type="hidden" name="contract_id"  value="<?php echo $user_governance_read_data['id']?>" readonly="readonly" />
                                        </div>
                                    </form>
                            <?php 
								} // if($user_governance_read_data['no_contract'] == 1) 
                        
                        } else {
                    ?>
                        <div class="well">
                            <div class="row">
                            
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinics. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                                     <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
                                </div>
                                
                            </div>
                        </div>                    
                    <?php
                         
                    
                        } // end $$this->session->pmr_org_pharmacy ?>
                    
                </div><!-- End Col-->
            </div><!-- End Row-->
      </div>
    </div>
  </div>
</div>