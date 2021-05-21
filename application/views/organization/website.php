<?php
	//print_this($verify_if_pharmacy_already_purchased); 
	if($this->session->pmr_org_pharmacy){
		
		if($pharmacy_data['website_buying_group_id']){
			
			if($pharmacy_data['website_package'] == 'S')
				$package_id = '1';
				
			if($pharmacy_data['website_package'] == 'P')
				$package_id = '2';

			//Website is enabled with a buying group
			if($verify_if_pharmacy_already_purchased->pharmacy_id && $verify_if_pharmacy_already_purchased->expiry_date >= date('Y-m-d')){
				//Pharmacy Website is purchased and is not expired
?>
				<div class="row">
                    <div class="col-md-12">
                        <?php 
                            if($verify_if_pharmacy_already_purchased->is_completed){
								
                                if($verify_if_pharmacy_already_purchased->website_package_id == 1)
                                    $package_name = 'STANDARD';
                                elseif($verify_if_pharmacy_already_purchased->website_package_id == 2)
                                    $package_name = 'PREMIUM';
                                elseif($verify_if_pharmacy_already_purchased->website_package_id == 0)	
                                    $package_name = 'CUSTOM';

								$current_date = date_create(date('Y-m-d'));
								$expiry_date = date_create($verify_if_pharmacy_already_purchased->expiry_date);
								$difference_days = date_diff($current_date,$expiry_date);
								
                          ?>      
                                <h3 class="alert alert-info text-center">
                                    <p style="font-size:28px;" ><strong>Your Website Status</strong></p><br />
									
                                    <?php 
										if($difference_days->format("%a") <= 30){
											////I fone month is remaining show a notification alert
									?>
                                    		<p class="text-danger" style="font-size:28px">[<?php echo 'Your website subscription is about to expire.';?>]</p><br />
                                    <?php		
										}//end if($difference_days->format("%a") <= 30)
									?>
                                    <p>Your current website package is <?php echo $package_name?>  and expiry date is <?php echo uk_date_format($verify_if_pharmacy_already_purchased->expiry_date)?>. You can <a href="<?php echo TECHDEVELOPERS_SURL?>login" target="_blank">Click Here</a> to login to your Backend Portal
                                    </p>
                                </h3>
                        <?php		
                            }else{
                        ?>
                                <h3 class="alert alert-info text-center">
                                    <p style="font-size:28px;" ><strong>Your Website Status</strong></p><br />
                                    <p>We are setting up your website. This will take approx 48 to 72 hours.</p>
                                </h3>                               
                        <?php		
                            }
                        ?>
                    </div>
                </div>

<?php				
			}else{
				
				if(!$verify_if_pharmacy_already_purchased->pharmacy_id){
?>
                    <form name="website_avicenna_frm" id="website_avicenna_frm" method="post" action="<?php echo SURL?>organization/website-avicenna" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 offset_top_20">
                                <h3 class="text-center">Create your Website</h3>
                                <p class="text-justify">To purchase a website for your pharmacy takes less then 5 minutes. All you need to do is select which domain name you would like, which design you would like, then choose which option you would prefer either Standard, Premium or Custom, once you are happy you can purchase via Paypal immediately.</p>
                            </div>
                        </div>
                        
                        <!--<div class="row">
                            <div class="col-md-12 ">
                                <h3 class="offset_bottom_20">1. Search your Domain Name</h3>
                                <input type="" class="form-control" name="search_domain" id="search_domain" placeholder="Search your Domain Name" required />
                                <small class="pull-right">For domain availability please <a href="https://uk.godaddy.com/offers/domains?isc=goflpk04&currencytype=GBP" target="_blank"> Click Here </a></small>
                            </div>
                        </div>-->
                        
                        <div class="row">
                            <div class="col-md-12 ">
                                <h3 class="offset_bottom_20">1. Enter Email Address</h3>
                                <input type="" class="form-control" name="email_address" id="email_address" placeholder="Enter your email address" required />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 offset_top_20">
                                <h3 class="offset_bottom_20">2. Select your design from below</h3>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="owl-carousel owl-theme pull-left">
                                    <?php 
                                        if($templates){
                                            for($i=0; $i<count($templates); $i++){	
                                            
                                    ?>
                                                <div class="portfolio-overlay">
                                                    <img src="<?php echo TECHDEVELOPERS_SURL; ?>assets/images/template/<?php echo $templates[$i]->template_icon; ?>" class="img-responsive" alt="" />
                                                    <div class="ovrly"></div>
                                                    <div class="buttons">
                                                        <a href="#" data-toggle="modal" data-target="#myModal" class="fa fa-search modal_btn" data-image="<?php echo TECHDEVELOPERS_SURL; ?>assets/images/templates/<?php echo $templates[$i]->template_image; ?>"></a>
                                                    </div>
                                                    <br />
                                                </div>
                                    <?php		
                                            }//end foreach($templates as $key => $template)
                                        }//end if($templates)
                                    ?>
                                  </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 offset_top_10">
                                <button type="submit" name="website_payment_proceed_btn" id="website_payment_proceed_btn" class="btn btn-lg btn-success pull-right">Proceed <i class="fa fa-arrow-right"></i></button>
                                  <input type="hidden" name="tmp_id"  id="tmp_id" value="" readonly="readonly" />
                                  <input type="hidden" name="pkge_id"  id="pkge_id" value="<?php echo $package_id?>" readonly="readonly" />
                            </div>
                        </div>
                    </form>
<?php					
				}else{
					
					$is_expired = ($verify_if_pharmacy_already_purchased->expiry_date >= date('Y-m-d')) ? 0 : 1;
					
					if($is_expired){
?>
                        <div class="row">
                            <div class="col-md-12">
								<h3 class="alert alert-info text-center">
                                    <p style="font-size:28px;" ><strong>Your Website Status</strong></p><br />
                                    <p>Your website subscription is expired on <strong><?php echo uk_date_format($verify_if_pharmacy_already_purchased->expiry_date)?></strong>. 
                                    Please contact Avicenna for more details.</p>

                                </h3>
                            </div>
                        </div>
<?php						
					}//end if($is_expired)

				}//end if(!verify_if_pharmacy_already_purchased->pharmacy_id)
				
			}//end if($verify_if_pharmacy_already_purchased->pharmacy_id && $verify_if_pharmacy_already_purchased->expiry_date >= date('Y-m-d'))
			
			
		}else{
			
			if($verify_if_pharmacy_already_purchased->pharmacy_id && $verify_if_pharmacy_already_purchased->expiry_date >= date('Y-m-d')){
				//Pharmacy Website is purchased and is not expired
				
?>
				<div class="row">
                	<div class="col-md-12">
                    	<?php 
							if($verify_if_pharmacy_already_purchased->is_completed){
								if($verify_if_pharmacy_already_purchased->website_package_id  == 1)
									$package_name = 'STANDARD';
								elseif($verify_if_pharmacy_already_purchased->website_package_id  == 2)
									$package_name = 'PREMIUM';
								elseif($verify_if_pharmacy_already_purchased->website_package_id  == 3)	
									$package_name = 'MULTIBRANCH';

								$current_date = date_create(date('Y-m-d'));
								$expiry_date = date_create($verify_if_pharmacy_already_purchased->expiry_date);
								$difference_days = date_diff($current_date,$expiry_date);
								
                        ?>

                                <h3 class="alert alert-info text-center">
                                    <p style="font-size:28px;" ><strong>Your Website Status</strong></p><br />
                                    <?php 
										if($difference_days->format("%a") <= 30){
											////I fone month is remaining show a notification alert
									?>
                                    		<p class="text-danger" style="font-size:28px">[<?php echo 'Your website subscription is about to expire.';?>]</p><br />
                                    <?php		
										}//end if($difference_days->format("%a") <= 30)
									?>
                                    <p>Your current website package is <?php echo $package_name?>  and expiry date is <?php echo uk_date_format($verify_if_pharmacy_already_purchased->expiry_date)?>. You can <a href="<?php echo TECHDEVELOPERS_SURL?>login" target="_blank">Click Here</a> to login to your Backend Portal</p>
                                </h3>                               
                                
                        <?php		
							}else{
						?>
                                <h3 class="alert alert-info text-center">
                                	<p style="font-size:28px;" ><strong>Your Website Status</strong></p><br />
                                	<p>We are setting up your website. This will take approx 48 to 72 hours.</p>
                               </h3>
                        <?php		
							}
						?>
                    	
                        
                    </div>
                </div>
<?php				
				
			}else{

				if(!$verify_if_pharmacy_already_purchased->pharmacy_id){
?>
                    <form data-toggle="validator" role="form"  name="website_payment_frm" id="website_payment_frm" method="post" action="<?php echo SURL?>organization/website-payment" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 offset_top_20">
                                <h3 class="text-center">Create your Website</h3>
                                <p class="text-justify">To purchase a website for your pharmacy takes less then 5 minutes. All you need to do is select which domain name you would like, which design you would like, then choose which option you would prefer either Standard, Premium or Custom, once you are happy you can purchase via Paypal immediately.</p>
                            </div>
                        </div>
                        <!--
                        <div class="row">
                            <div class="col-md-12 form-group ">
                                <h3 class="offset_bottom_20">1. Search your Domain Name</h3>
                                <input type="" class="form-control" name="search_domain" id="search_domain" placeholder="Search your Domain Name" required />
                                <small class="pull-right">For domain availability please <a href="https://uk.godaddy.com/offers/domains?isc=goflpk04&currencytype=GBP" target="_blank"> Click Here </a></small>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        -->
                        
                        <div class="row">
                            <div class="col-md-12 ">
                                <h3 class="offset_bottom_20">1. Enter Email Address</h3>
                                <input type="" class="form-control" name="email_address" id="email_address" placeholder="Enter your email address" required />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 offset_top_20">
                                <h3 class="offset_bottom_20">2. Select your design from below</h3>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="owl-carousel owl-theme pull-left">
                                    <?php 
                                        if($templates){
                                            for($i=0; $i<count($templates); $i++){	
                                    ?>
                                                <div class="item text-center pull-left" >
                                                
                                                	<div class="portfolio-overlay">
                                                		<img src="<?php echo TECHDEVELOPERS_SURL; ?>assets/images/templates/<?php echo $templates[$i]->template_icon; ?>" class="img-responsive" alt="" />
	                                                    <div class="ovrly"></div>
                                                        <div class="buttons">
                                                        	<a href="#" data-toggle="modal" data-target="#myModal" class="fa fa-search modal_btn" data-image="<?php echo TECHDEVELOPERS_SURL; ?>assets/images/templates/<?php echo $templates[$i]->template_image; ?>"></a>
                                                        </div>
                                                                                                                
                                                        
                                                  </div>
                                                  <br />
                                                  <button type="button" class="btn btn-sm btn-success tmp_slt_btn" value="<?php echo $templates[$i]->id?>">Select this Design</button>
                                                  <br /><br />
                                                </div>
                                    <?php		
                                            }//end foreach($templates as $key => $template)
                                        }//end if($templates)
                                    ?>
                                    
                                  </div>
                            </div>
                        </div>
                        
                        <div class="row offset_top_20">
                            <div class="col-md-12">
                                <h3 class="offset_bottom_20">4. Select which package would you like</h3>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12"> <h4 class=""><?php echo $package_list->standard->package_name?> (&pound;<?php echo $package_list->standard->package_price?>/ Year) </h4></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="package_list">
                                            <li><i class="fa fa-check"></i> Responsive Website</li>	
                                            <li><i class="fa fa-check"></i> Free Hosting & .co.uk Domain</li>	
                                            <li><i class="fa fa-check"></i> Online Repeat Prescriptions</li>	
                                            <li><i class="fa fa-check"></i> EPS Nominations</li>	
                                            <li><i class="fa fa-check"></i> Content Management System</li>	
                                            <li><i class="fa fa-times"></i> Online Social Media Marketing</li>	
                                            <li><i class="fa fa-times"></i> Technical Support</li>	
                                            <li><i class="fa fa-times"></i> Search Engine Optimisation</li>	
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-block pkge_slt" value="1">Select this Package</button>
                                </div>
                                
                                
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12"> <h4 class=""><?php echo $package_list->premium->package_name?> (&pound;<?php echo $package_list->premium->package_price?>/ Year)</h4> </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="package_list">
                                            <li><i class="fa fa-check"></i> Responsive Website</li>	
                                            <li><i class="fa fa-check"></i> Free Hosting & .co.uk Domain</li>	
                                            <li><i class="fa fa-check"></i> Online Repeat Prescriptions</li>	
                                            <li><i class="fa fa-check"></i> EPS Nominations</li>	
                                            <li><i class="fa fa-check"></i> Content Management System</li>	
                                            <li><i class="fa fa-check"></i> Online Social Media Marketing</li>	
                                            <li><i class="fa fa-check"></i> Technical Support</li>	
                                            <li><i class="fa fa-check"></i> Search Engine Optimisation</li>	

                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-info btn-block pkge_slt" value="2">Select this Package</button>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12"> <h4 class="">Multibranch (from &pound;<?php echo $package_list->multibranch->package_price?>/ Year)</h4></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="package_list">
                                        	<li><i class="fa fa-check"></i> We charge extra £<?php echo $per_branch_price?> per branch</li>	
                                            <li><i class="fa fa-check"></i> Responsive Website & Custom Logo</li>	
                                            <li><i class="fa fa-check"></i> Free Hosting & .co.uk Domain</li>	
                                            <li><i class="fa fa-check"></i> Online Repeat Prescriptions</li>	
                                            <li><i class="fa fa-check"></i> EPS Nominations</li>	
                                            <li><i class="fa fa-check"></i> Content Management System</li>	
                                            <li><i class="fa fa-check"></i> Online Social Media Marketing</li>	
                                            <li><i class="fa fa-check"></i> Technical Support</li>	
                                            <li><i class="fa fa-check"></i> Search Engine Optimisation</li>	
                                        </ul>
                                    </div>
                                    
                                    <div class="col-md-12">

                                        <button type="button" class="btn btn-danger btn-block pkge_slt" value="3">Select this Package</button>
                                        <!--<p class="alert alert-info">For custom website please contact <br /><strong><a href="mailto:info@pharmacyfocus.co.uk">info@pharmacyfocus.co.uk</a></strong></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 offset_top_10">
                                <button type="submit" name="website_payment_proceed_btn" id="website_payment_proceed_btn" class="btn btn-lg btn-success pull-right">Proceed <i class="fa fa-arrow-right"></i></button>
                                  <input type="hidden" name="tmp_id"  id="tmp_id" value="" readonly="readonly" />
                                  <input type="hidden" name="pkge_id"  id="pkge_id" value="" readonly="readonly" />
                            </div>
                        </div>
                    </form>
<?php					
				}else{
					
					$is_expired = ($verify_if_pharmacy_already_purchased->expiry_date >= date('Y-m-d')) ? 0 : 1;
					
					if($is_expired){
						//If website subscription is expired.
?>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="alert alert-info text-center">
                                <p style="font-size:28px;" ><strong>Your Website Status</strong></p><br />
                                <p>Your website subscription is expired on <strong><?php echo uk_date_format($verify_if_pharmacy_already_purchased->expiry_date)?></strong>. Please click on Renew Now to renew your subscription.</p>

                                </h3>                               
                                
                            </div>
                        </div>
                        <div class="row">
                            <form name="website_payment_frm" id="website_payment_frm" method="post" action="<?php echo SURL?>organization/website-payment" enctype="multipart/form-data">
                                <div class="col-md-12 offset_top_10">
                                    <button type="submit" name="website_payment_proceed_btn" id="website_payment_proceed_btn" class="btn btn-lg btn-success pull-right">Renew Now <i class="fa fa-arrow-right"></i></button>
                                      <input type="hidden" name="tmp_id"  id="tmp_id" value="<?php echo $verify_if_pharmacy_already_purchased->website_template_id?>" readonly="readonly" />
                                      <input type="hidden" name="pkge_id"  id="pkge_id" value="<?php echo $verify_if_pharmacy_already_purchased->website_package_id ?>" readonly="readonly" />
                                      <input type="hidden" name="is_renewal"  id="is_renewal" value="1" readonly="readonly" />
								      <input type="hidden" name="email_address"  id="email_address" value="<?php echo $verify_if_pharmacy_already_purchased->email_address ?>" readonly="readonly" />                                      
                                      
                                      
                                </div>
                            </form>
                        </div>		
    <?php					
                    }//end if($is_expired)
					
				}//end if(!$verify_if_pharmacy_already_purchased->pharmacy_id)
				
			}//end if($verify_if_pharmacy_already_purchased->pharmacy_id && !$is_expired)
			
		}//end if($pharmacy_data['website_buying_group_id'])
?>
<div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                              
                              <div class="modal-body">
                                <p id="modal_image"></p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                        
                          </div>
                        </div>
<?php
	}else{
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
	}//end if($this->session->pmr_org_pharmacy)
?>

<script>
$(document).ready(function(){

	$('.owl-carousel').owlCarousel({
		loop:true,
		margin:10,
		nav: false,
		responsiveClass:true,
		responsive:{
		}
	})
	
	$('.modal_btn').click(function(){
		
		image_src = $(this).attr('data-image');

		$('#modal_image').html('<img src="'+image_src+'" class="img-responsive" />');
		
	})
})

$('.tmp_slt_btn').click(function(){
	
	$('.tmp_slt_btn').html('Select this Design');
	$('.tmp_slt_btn').removeClass('btn-warning');
	$('.tmp_slt_btn').addClass('btn-success');
	
	$(this).html('<i class="fa fa-check"></i> Selected');
	$(this).removeClass('btn-success');
	$(this).addClass('btn-warning');
	$('#tmp_id').val($(this).val());

})

$('.pkge_slt').click(function(){
	
	$('.pkge_slt').html('Select this Package');
	$(this).html('<i class="fa fa-check"></i> Selected');
	$('#pkge_id').val($(this).val());
})

</script>