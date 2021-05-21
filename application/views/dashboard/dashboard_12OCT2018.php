<a name="basket_ref" id="basket_ref"></a>

<div class="row">
  <div class="col-md-8">
    
    <?php  if(!$belong_to_any_organization && count($user_invitations_arr)  == 0) { ?>

        <div class="alert alert-info">
            
            <p>Hi, welcome to the HubNet. </p>
            <p class="text-justify">
            You have not yet been invited by a manager of a location, so functionality is currently restricted. If you would like to access the location-based features you first must contact your organisation lead and give them your email address (<?php echo filter_string($this->session->email_address)?>) so that they can send you an invite. <br /><br />
            You can still access the  PGD online training but your PGDs will not be activated until your account is invited by a manager or superintendent of a GPhC registered pharmacy. <br> <br />
            </p>
            <p class="text-justify">
            Otherwise, if you are the owner or Superintendent you can upgrade your account to organisation level by clicking the button below.<br />
            </p>
            <p class="text-right"><a class="btn btn-warning fancybox_view fancybox.ajax" href="<?php echo SURL?>dashboard/register-organization">Convert Account to Organisation</a></p>
            
        </div>

    <?php 
		} // if(!$belong_to_any_organization) 
	
		//The PGD's Purchase are only visible to the Non Prescribers Phramcist and Nurses
		if($this->session->is_prescriber == 0 && in_array($this->session->user_type,$non_presriber_usertype_arr) ){
	?>
    		<a class="fancybox-media hidden" id="non_prescribers_intro_video" href="<?php echo $this->session->dashboard_video_url?>"></a>
    <?php		
			if($purchased_items_split_arr['pgds']['package_purchased'] == 1 && $purchased_items_split_arr['pgds']['package_expired'] == 0){
	?>
    			<!-- START Oral PGDs Panel-->
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default"> 
                    
                    <?php 
							//This methods verify if any of the Oral PGD is expired within the Package if yes.. need to show the option to renew
							$any_oral_pgd_expired = 0;
                            if(count($oral_pgd_arr) > 0){
                                
                                for($i=0;$i<count($oral_pgd_arr);$i++){

                                    $oral_pgd_expiry_date = $purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['expiry_date'];
                                    $oral_pgd_is_expired = ((strtotime(date('Y-m-d')) <= strtotime($oral_pgd_expiry_date)) || $oral_pgd_expiry_date == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1 
									
									if($oral_pgd_is_expired){
										//echo $oral_pgd_arr[$i]['id'].'--'.$oral_pgd_expiry_date.'--'.$oral_pgd_is_expired;
										$any_oral_pgd_expired = 1;
										break;
									}//end if($oral_pgd_is_expired)
									
								}//end for($i=0;$i<count($oral_pgd_arr);$i++)
								
							}//end if(count($oral_pgd_arr) > 0)
					?>
                    
                      <div class="panel-heading" ><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><strong>Standard Oral PGD Package</strong> </a> <a href="<?php echo SURL?>pgd/package-info/1" class="btn btn-xs fancybox_pgd_detail fancybox.ajax"> <span class="glyphicon glyphicon-info-sign"></span></a>
                         <?php 
						 	if($any_oral_pgd_expired){
						?>
		                        <form name="oral_pgd_frm" id="oral_pgd_frm_renew" class="pull-right" style="width:50%">
                        <?php

								//Fetching Global Setting for Oral Packages
								$ORAL_PGD_PACKAGE_PRICE = 'ORAL_PGD_PACKAGE_PRICE';
								$global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);
								
								$ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
								$global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);						
                                        
								//If  discount vlaue > 0, the diccount proce will be considered
								if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00){
							?>
	                                <input type="hidden" name="p_price" value="<?php echo filter_price($global_oral_packages_discount_price['setting_value']) ?>" readonly="readonly" />
                            <?php		
    	                        }else{
                            ?>
                                <input type="hidden" name="p_price" value="<?php echo filter_price($global_oral_package_price['setting_value']) ?>" readonly="readonly"/>
							<?php 
								}//end if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00)
							?>
		                        <span class=""><a href="javascript:;" class="add_to_basket btn btn-xs btn-warning" id=""><i class="fa fa-refresh"></i> Renew Package</a></span>
                                <input type="hidden" readonly="readonly" value="PGD" name="p_type">
                                <input type="hidden" readonly="readonly" value="STANDARD ORAL PGD PACKAGE" name="p_name">
                                <input type="hidden" readonly="readonly" value="P_0" name="p_id">  
                                <input type="hidden" readonly="readonly" value="1" name="o_package">  <!--Oral Package -->
                            
                            </form>    
    
                        <?php		
							}//end if($any_oral_pgd_expired)
						 ?>
                        
                      </div>
                      
                      <div id="collapseOne" class="panel-collapse collapse in">
                          <div class="panel-body">
                        <?php 
                            if(count($oral_pgd_arr) > 0){
                                
                                for($i=0;$i<count($oral_pgd_arr);$i++){
                                    
                                    $expiry_date = $purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['expiry_date'];
                                    $is_purchased = ($purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
                                    $is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
                                    $is_quiz_passed = $purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz Assessment is passed marked as 1
                                    $doctor_approval = $purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after Assessment
                                    $pharmacist_approval = $purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after Assessment
									$is_rechas = filter_string($oral_pgd_arr[$i]['is_rechas']); 
									$is_rechas_passed = $purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['is_rechas_agreed']; //If quiz rechas is passed
                                    
                        ?>
                            <form name="oral_pgd_frm" id="oral_pgd_frm_<?php echo filter_string($oral_pgd_arr[$i]['id'])?>">
                              <div class="row">
                                <div class="col-md-5">
                                  <p> <?php echo filter_string($oral_pgd_arr[$i]['pgd_name'])?>
                                    <a href="<?php echo SURL?>pgd/pgd-info/<?php echo $oral_pgd_arr[$i]['id'] ?>" class="btn btn-xs fancybox_pgd_detail fancybox.ajax"> <span class="glyphicon glyphicon-info-sign"></span></a><br>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                        if($is_purchased){
                                            if($is_expired  && $expiry_date!= '0000-00-00'){
                                                echo 'Expired'; // If Purchased but expired.
                                            }else{
                                                if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and Assessment test is passed, doc and pharmacist have approved the PGD Assessment
												
                                                    echo "Exp: ".date('d/m/Y',strtotime($expiry_date));
                                                }else{
                                                    if($is_quiz_passed){
														
														echo ($belong_to_any_organization) ? "Waiting Authorisation" : 'Awaiting Superintendent account'; //If Quiz is passed bt not assessed by the pharmacist or doctor
													}else
                                                        echo "Waiting Assessment"; // If Purchased and not expired and assessment test is not passed
        
                                                }//end if($is_quiz_passed)
                                            }//end if($is_expired)
                                            
                                        }else
                                            echo "Waiting Purchase"; //If not purchased.
                                        //end if($is_purchased)
                                    ?>
                                </div>
                                <div class="col-md-4 text-right">
                    				<?php
										if($is_rechas && !$is_rechas_passed && !$is_quiz_passed){
									?>
                                    	<a href="<?php echo SURL?>pgd/pgd-rechas/<?php echo $oral_pgd_arr[$i]['id']?>" class="btn btn-info btn-xs fancybox_pgd_detail fancybox.ajax" id="<?php echo $oral_pgd_arr[$i]['id']?>"><i class="fa fa-eye"></i> Access to Training</a>	
                                        
                                    <?php		
										}else{
									?>
                                    		<a href="<?php echo SURL?>pgd/pgd-certificate/<?php echo $oral_pgd_arr[$i]['id']?>" class="btn btn-info btn-xs" id="<?php echo $oral_pgd_arr[$i]['id']?>"><i class="fa fa-eye"></i> Access to Training</a>
                                    <?php		
										}//end if($is_rechas)
									?>
                                    
                                                    
                                  
                                  <p>
                                   <?php
								   	$averge_rating = get_product_ratings('PGD',$oral_pgd_arr[$i]['id']);
									$averge_rating = $averge_rating['avg_rating'];
                                   ?>
                                   
                                    <input id="pgd_rating_input_readonly" type="number" displayOnly="1" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($averge_rating); ?>" />
                                    <a href="<?php echo SURL?>pgd/pgd-reviews/<?php echo filter_string($oral_pgd_arr[$i]['id'])?>" class="fancybox_pgd_review fancybox.ajax" id="pgd_review_link">
                                    <?php 
                                        $get_pgd_reviews_list = $this->purchase->get_product_reviews('PGD', filter_string($oral_pgd_arr[$i]['id']));
                                        echo ($purchased_items_split_arr['pgds']['pgd_list'][$oral_pgd_arr[$i]['id']]['star_rating'] == '0') ? 'Rate this Product <br />' : '';
                                        echo number_format($averge_rating,1); 
                                    ?> starred - <?php echo count($get_pgd_reviews_list)?> <?php echo (count($get_pgd_reviews_list) > 1) ? 'Reviews' : 'Review' ?></a>
                                    
                                  </p>
                                </div>
                              </div>
                            </form>
                        <?php			
                                    //Dont Show <HR> after last record
                                    echo ($i < count($oral_pgd_arr)-1) ? '<hr />' : '';
                        
                                }//end for($i=0;$i<count($oral_pgd_arr);$i++)
                            }else{
                        ?>
                            <p><div role="alert" class="alert alert-danger">No Oral PGDs Listed!</div></p>
                        <?php		
                            }//end if(count($oral_pgd_arr) > 0)
                        ?>
                          
                          </div>
                      </div>
                    </div>
                </div>
	    		<!-- END Oral PGDs Panel-->

    <?php 
			}else{
	?>
    			<!-- START: Oral PGD Package-->
                <div class="panel panel-default"> 
                  <div class="panel-heading"><strong>Standard Oral PGD Package</strong> <a href="<?php echo SURL?>pgd/package-info/1" class="btn btn-xs fancybox_pgd_detail fancybox.ajax"> <span class="glyphicon glyphicon-info-sign"></span></a></div>
                  <div class="panel-body">
                  	<?php if(count($oral_pgd_arr) > 0){?>
                        <form name="oral_pgd_frm" id="oral_pgd_frm_999">
                          <div class="row">
                            <div class="col-md-3">
                                <p><i class="fa fa-medkit fa-5x text-danger"></i></p>
                                
                                 <p>
                                    <?php
                                        //Fetching Global Setting for Oral Packages
                                        $ORAL_PGD_PACKAGE_PRICE = 'ORAL_PGD_PACKAGE_PRICE';
                                        $global_oral_package_price = get_global_settings($ORAL_PGD_PACKAGE_PRICE);
                                        
                                        $ORAL_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PGD_PACKAGE_DISCOUNT_PRICE';
                                        $global_oral_packages_discount_price = get_global_settings($ORAL_PGD_PACKAGE_DISCOUNT_PRICE);						
                                        
                                        //If  discount vlaue > 0, the diccount proce will be considered
                                        if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00){
                                    ?>
                                            <span class="label label-danger"><s>&pound;<?php echo filter_price($global_oral_package_price['setting_value'])?></s></span>
                                            <span class="label label-success">&pound;<?php echo filter_price($global_oral_packages_discount_price['setting_value'])?></span>
                                            <input type="hidden" name="p_price" value="<?php echo filter_price($global_oral_packages_discount_price['setting_value']) ?>" readonly="readonly" />
                                    <?php		
                                        }else{
                                    ?>
                                            <span class="label label-success">&pound;<?php echo filter_price($global_oral_package_price['setting_value'])?></span>
                                            <input type="hidden" name="p_price" value="<?php echo filter_price($global_oral_package_price['setting_value']) ?>" readonly="readonly"/>
                                     <?php } //end if?>
                                 </p>
                            </div>
                            <div class="col-md-9">
                               <?php echo filter_string($cms_data_arr_oral_pgd_package['cms_page_arr']['page_description']);?><br /> 
                                <p class="text-right"><a href="javascript:;" class="btn btn-success btn-xs add_to_basket" id="<?php echo $oral_pgd_arr[$i]['id']?>"><i class="fa fa-cart-plus "></i> Add to Basket</a></p>
                            </div>
                          </div>
                            <input type="hidden" readonly="readonly" value="PGD" name="p_type">
                            <input type="hidden" readonly="readonly" value="STANDARD ORAL PGD PACKAGE" name="p_name">
                            <input type="hidden" readonly="readonly" value="P_0" name="p_id">  
                            <input type="hidden" readonly="readonly" value="1" name="o_package">  <!--Oral Package -->
                           
                        </form>
                    <?php }else{
					?>
                    	 <p><div role="alert" class="alert alert-danger">No Oral PGDs Available!</div></p>
                    <?php }//end if(count($oral_pgd_arr) > 0)?>
                  </div>
                </div>
        		<!-- END: Oral PGD Package-->
    <?php		
			}//end if($purchased_items_split_arr['pgds']['package_purchased'] == 1 && $purchased_items_split_arr['pgds']['package_expired'] == 0)
	?>

    <?php		
			if($purchased_items_split_arr['pgds']['premium_package_purchased'] == 1 && $purchased_items_split_arr['pgds']['premium_package_expired'] == 0){
	?>
    			<!-- START Oral PGDs Panel-->
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default"> 
                    <?php 
							//This methods verify if any of the Premium PGD is expired within the Package if yes.. need to show the option to renew
							$any_prem_pgd_expired = 0;
							
                            if(count($premium_oral_pgd_arr) > 0){
                                
                                for($i=0;$i<count($premium_oral_pgd_arr);$i++){

                                    $prem_pgd_expiry_date = $purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['expiry_date'];
                                    $prem_pgd_is_expired = ((strtotime(date('Y-m-d')) <= strtotime($prem_pgd_expiry_date)) || $prem_pgd_expiry_date == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1 
									
									if($prem_pgd_is_expired){
										//echo $oral_pgd_arr[$i]['id'].'--'.$oral_pgd_expiry_date.'--'.$oral_pgd_is_expired;
										$any_prem_pgd_expired = 1;
										break;
									}//end if($prem_pgd_is_expired)
									
								}//end for($i=0;$i<count($premium_oral_pgd_arr);$i++)
								
							}//end if(count($premium_oral_pgd_arr) > 0)
					?>
                    
                      <div class="panel-heading">
                      	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><strong>Premium Oral PGD Package</strong></a> <a href="<?php echo SURL?>pgd/package-info/2" class="btn btn-xs fancybox_pgd_detail fancybox.ajax"> <span class="glyphicon glyphicon-info-sign"></span></a>
                         <?php 
						 	if($any_prem_pgd_expired){
						?>
		                        <form name="prem_pgd_frm" id="prem_pgd_frm_renew" class="pull-right" style="width:50%">
                        <?php

								$ORAL_PREMIUM_PGD_PACKAGE_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_PRICE';
								$global_oral_prem_package_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_PRICE);
								
								$ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE';
								$global_oral_prem_packages_discount_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE);						
                                        
								//If  discount vlaue > 0, the diccount proce will be considered
								if(filter_string($global_oral_prem_packages_discount_price['setting_value']) != '0.00'){
							?>
                                    <input type="hidden" name="p_price" value="<?php echo filter_price($global_oral_prem_packages_discount_price['setting_value']) ?>" readonly="readonly" />
                            <?php		
    	                        }else{
                            ?>
                                <input type="hidden" name="p_price" value="<?php echo filter_price($global_oral_prem_packages_discount_price['setting_value']) ?>" readonly="readonly"/>
							<?php 
								}//end if(filter_string($global_oral_packages_discount_price['setting_value']) != 0.00)
							?>
		                        <span class=""><a href="javascript:;" class="add_to_basket btn btn-xs btn-warning" id=""><i class="fa fa-refresh"></i> Renew Package</a></span>
                                <input type="hidden" readonly="readonly" value="PGD" name="p_type">
                                <input type="hidden" readonly="readonly" value="PREMIUM ORAL PGD PACKAGE" name="p_name">
                                <input type="hidden" readonly="readonly" value="P_1" name="p_id">  
                                <input type="hidden" readonly="readonly" value="1" name="o_package">  <!--Oral Package -->
                            </form>    
                        <?php		
							}//end if($any_prem_pgd_expired)
						 ?>
                        
                      </div>
                       <div id="collapseTwo" class="panel-collapse collapse in">
                          <div class="panel-body">
                        <?php 
                            
                            if(count($premium_oral_pgd_arr) > 0){
                                
                                for($i=0;$i<count($premium_oral_pgd_arr);$i++){
                                    
                                    $expiry_date = $purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['expiry_date'];
                                    $is_purchased = ($purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
                                    $is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
                                    $is_quiz_passed = $purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz Assessment is passed marked as 1
                                    $doctor_approval = $purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after Assessment
                                    $pharmacist_approval = $purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after Assessment
									
									$is_rechas = filter_string($premium_oral_pgd_arr[$i]['is_rechas']); 
									$is_rechas_passed = $purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['is_rechas_agreed']; //If quiz rechas is passed
                        ?>
                            <form name="prem_oral_pgd_frm" id="prem_oral_pgd_frm_<?php echo filter_string($premium_oral_pgd_arr[$i]['id'])?>">
                              <div class="row">
                                <div class="col-md-5">
                                  <p> <?php echo filter_string($premium_oral_pgd_arr[$i]['pgd_name'])?>
                                    <a href="<?php echo SURL?>pgd/pgd-info/<?php echo $premium_oral_pgd_arr[$i]['id'] ?>" class="btn btn-xs fancybox_pgd_detail fancybox.ajax"> <span class="glyphicon glyphicon-info-sign"></span></a><br>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                        if($is_purchased){
                                            if($is_expired  && $expiry_date!= '0000-00-00'){
                                                echo 'Expired'; // If Purchased but expired.
                                            }else{
                                                if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and Assessment test is passed, doc and pharmacist have approved the PGD Assessment
                                                    echo "Exp: ".date('d/m/Y',strtotime($expiry_date));
                                                }else{
                                                    if($is_quiz_passed){
                                                        echo ($belong_to_any_organization) ? "Waiting Authorisation" : 'Awaiting Superintendent account';
													}else
                                                        echo "Waiting Assessment"; // If Purchased and not expired and Assessment test is not passed
                                                }//end if($is_quiz_passed)
                                            }//end if($is_expired)
                                            
                                        }else
                                            echo "Waiting Purchase"; //If not purchased.
                                        //end if($is_purchased)
                                    ?>
                                </div>
                                <div class="col-md-4 text-right"> 
                    				<?php
										if($is_rechas && !$is_rechas_passed && !$is_quiz_passed){
									?>
                                    	<a href="<?php echo SURL?>pgd/pgd-rechas/<?php echo $premium_oral_pgd_arr[$i]['id']?>" class="btn btn-info btn-xs fancybox_pgd_detail fancybox.ajax" id="<?php echo $premium_oral_pgd_arr[$i]['id']?>"><i class="fa fa-eye"></i> Access to Training</a>	
                                        
                                    <?php		
										}else{
									?>
                                    <a href="<?php echo SURL?>pgd/pgd-certificate/<?php echo $premium_oral_pgd_arr[$i]['id']?>" class="btn btn-info btn-xs" id="<?php echo $premium_oral_pgd_arr[$i]['id']?>"><i class="fa fa-eye"></i> Access to Training</a>                
                                  <?php		
										}//end if($is_rechas)
									?>

                    
                                    
                                  <p>
                                   
                                   <?php
								   	$averge_rating = get_product_ratings('PGD',$premium_oral_pgd_arr[$i]['id']);
									$averge_rating = $averge_rating['avg_rating'];
                                   ?>
                                    <input id="pgd_rating_input_readonly" type="number" displayOnly="1" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($averge_rating); ?>" />
                                    <a href="<?php echo SURL?>pgd/pgd-reviews/<?php echo filter_string($premium_oral_pgd_arr[$i]['id'])?>" class="fancybox_pgd_review fancybox.ajax" id="pgd_review_link">
                                    <?php 
                                        $get_pgd_reviews_list = $this->purchase->get_product_reviews('PGD', filter_string($premium_oral_pgd_arr[$i]['id']));
                                        echo ($purchased_items_split_arr['pgds']['pgd_list'][$premium_oral_pgd_arr[$i]['id']]['star_rating'] == '0') ? 'Rate this Product <br />' : '';
                                        echo number_format($averge_rating,1); 
                                    ?> starred - <?php echo count($get_pgd_reviews_list)?>  <?php echo (count($get_pgd_reviews_list) > 1) ? 'Reviews' : 'Review' ?></a>
                                    
                                  </p>
                                </div>
                              </div>
                            </form>
                        <?php			
                                    //Dont Show <HR> after last record
                                    echo ($i < count($premium_oral_pgd_arr)-1) ? '<hr />' : '';
                        
                                }//end for($i=0;$i<count(premium_oral_pgd_arr);$i++)
                            }else{
                        ?>
                            <p><div role="alert" class="alert alert-danger">No Premium Oral PGDs Listed!</div></p>
                        <?php		
                            }//end if(count($premium_oral_pgd_arr) > 0)
                        ?>
                          
                          </div>
                       </div>
                    </div>
                
                </div>
	    		<!-- END Oral PGDs Panel-->

    <?php 
			}else{
	?>
    			<!-- START: Premium Oral PGD Package-->
                <div class="panel panel-default"> 
                  <div class="panel-heading"><strong>Premium Oral PGD Package</strong> <a href="<?php echo SURL?>pgd/package-info/2>" class="btn btn-xs fancybox_pgd_detail fancybox.ajax"> <span class="glyphicon glyphicon-info-sign"></span></a></div>
                  <div class="panel-body">
                  	<?php if(count($premium_oral_pgd_arr) > 0){?>
                        <form name="prem_oral_pgd_frm" id="prem_oral_pgd_frm_999">
                          <div class="row">
                            <div class="col-md-3">
                                <p><i class="fa fa-medkit fa-5x text-danger"></i></p>
                                
                                 <p>
                                    <?php
                                        //Fetching Global Setting for Oral Packages
                                        $ORAL_PREMIUM_PGD_PACKAGE_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_PRICE';
                                        $global_oral_prem_package_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_PRICE);
                                        
                                        $ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE = 'ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE';
                                        $global_oral_prem_packages_discount_price = get_global_settings($ORAL_PREMIUM_PGD_PACKAGE_DISCOUNT_PRICE);						
                                        
                                        //If  discount vlaue > 0, the diccount proce will be considered
                                        if(filter_string($global_oral_prem_packages_discount_price['setting_value']) != '0.00'){

                                    ?>
                                            <span class="label label-danger"><s>&pound;<?php echo filter_price($global_oral_prem_package_price['setting_value'])?></s></span>
                                            <span class="label label-success">&pound;<?php echo filter_price($global_oral_prem_packages_discount_price['setting_value'])?></span>
                                   			<input type="hidden" name="p_price" value="<?php echo filter_price($global_oral_prem_packages_discount_price['setting_value']) ?>" readonly="readonly" />
                                    <?php		
                                        }else{
                                    ?>
                                            <span class="label label-success">&pound;<?php echo filter_price($global_prem_oral_package_price['setting_value'])?></span>
                                   <input type="hidden" name="p_price" value="<?php echo filter_price($global_prem_oral_package_price['setting_value']) ?>" readonly="readonly"/>
                                     <?php } //end if?>
                                 </p>
                            </div>
                            <div class="col-md-9">
                               <?php echo filter_string($cms_data_arr_premium_oral_pgd_packages['cms_page_arr']['page_description']);?>
                                <p class="text-right"><a href="javascript:;" class="btn btn-success btn-xs add_to_basket" id="<?php echo $premium_oral_pgd_arr[$i]['id']?>"><i class="fa fa-cart-plus "></i> Add to Basket</a></p>
                            </div>
                          </div>
                                <input type="hidden" readonly="readonly" value="PGD" name="p_type">
                                <input type="hidden" readonly="readonly" value="PREMIUM ORAL PGD PACKAGE" name="p_name">
                                <input type="hidden" readonly="readonly" value="P_1" name="p_id">  
                                <input type="hidden" readonly="readonly" value="1" name="o_package">  <!--Oral Package -->
                           
                        </form>
                    <?php }else{
					?>
                    	 <p><div role="alert" class="alert alert-danger">No Premium Oral PGDs Available!</div></p>
                    <?php }//end if(count($premium_oral_pgd_arr) > 0)?>
                  </div>
                </div>
        		<!-- END: Premium Oral PGD Package-->
    <?php		
			}//end if($purchased_items_split_arr['pgds']['premium_package_purchased'] == 1 && $purchased_items_split_arr['pgds']['premium_package_expired'] == 0)
	?>
    
  	<!-- START Vaccine PGDs Panel-->
    <div class="panel-group" id="accordion">
        <div class="panel panel-default"> 
          
          <div class="panel-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><strong>Vaccine PGD Packages</strong></a> </div>
          <div id="collapseThree" class="panel-collapse collapse in">
              <div class="panel-body">
        
            <?php
                if(count($vaccine_pgd_arr) > 0){
                    
                    //PARENT VACCINES LISTINGS 
                    for($i=0;$i<count($vaccine_pgd_arr);$i++){
                        
                        if(!$vaccine_pgd_arr[$i]['is_child']){
        
                            $expiry_date = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['expiry_date'];
                            $is_purchased = ($purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
                            $is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
                            $is_quiz_passed = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz Assessment is passed marked as 1
                            
                            $doctor_approval = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after Assessment
                            $pharmacist_approval = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after Assessment				
							
							//echo $is_quiz_passed.' - '.$doctor_approval.' - '.$pharmacist_approval;

							$is_rechas = filter_string($vaccine_pgd_arr[$i]['is_rechas']); 
							$is_rechas_passed = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['is_rechas_agreed']; //If quiz rechas is passed
                        
            ?>
                            <form name="vaccine_pgd_frm" id="vaccine_pgd_frm<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>">
                              <div class="row">
                                <div class="col-md-5">
                                  <p> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?>
                                    <a href="<?php echo SURL?>pgd/pgd-info/<?php echo $vaccine_pgd_arr[$i]['id'] ?>" class="btn btn-xs btn-info fancybox_pgd_detail fancybox.ajax"><i class="fa fa-info "></i> More Info</a> 
                                    <br>
                                    <?php
                                        //If not purchased only then show the prices
                                        if($is_purchased == 0){
                                    
                                            //If  discount vlaue > 0, the diccount proce will be considered
                                            if(filter_string($vaccine_pgd_arr[$i]['discount_price']) != 0.00){
                                     ?>
                                                <span class="label label-danger"><s>&pound;<?php echo filter_string($vaccine_pgd_arr[$i]['price'])?></s></span></strong> <span class="label label-warning">&pound;<?php echo filter_string($vaccine_pgd_arr[$i]['discount_price'])?></span></strong>
                                                
                                    <?php 
                                            }else{
                                    ?>
                                                <span class="label label-danger">&pound;<?php echo filter_string($vaccine_pgd_arr[$i]['price'])?></span>
                                    <?php 
                                            }//end if(filter_string($vaccine_pgd_arr[$i]['discount_price']) != 0.00)
                                            
                                        }//end if($is_purchased == 0)
                                        
                                        if(filter_string($vaccine_pgd_arr[$i]['discount_price']) != 0.00){
                                    ?>
                                            <input type="hidden" name="p_price" value="<?php echo filter_string($vaccine_pgd_arr[$i]['discount_price']) ?>" readonly="readonly" />
                                    <?php		
                                        }else{
                                    ?>
                                            <input type="hidden" name="p_price" value="<?php echo filter_string($vaccine_pgd_arr[$i]['price']) ?>" readonly="readonly"/>
                                    <?php		
                                        }
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                        if($is_purchased){
                                            if($is_expired && $expiry_date!= '0000-00-00'){
                                                echo 'Waiting Purchase'; // If Purchased but expired.
                                            }else{
                                                
                                                if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and Assessment test is passed, doc and pharmacist have approved the PGD Assessment
                                                    echo "Exp: ".date('d/m/Y',strtotime($expiry_date));
                                                }else{
                                                    if($is_quiz_passed){
                                                        
														echo ($belong_to_any_organization) ? "Waiting Authorisation" : 'Awaiting Superintendent account'; //If Quiz is passed bt not assessed by the pharmacist or doctor
													}else
                                                        echo "Waiting Assessment"; // If Purchased and not expired and Assessment test is not passed
        
                                                }//end if($is_quiz_passed)
                                                
                                            }//end if($is_expired)
                                            
                                        }else
                                            echo "Waiting Purchase"; //If not purchased.
                                        //end if($is_purchased)
                                    ?>
                                </div>
                                <div class="col-md-4 text-right"> 
                    
                                    <?php
                                        if($is_purchased){
                                            if($is_expired && $expiry_date!= '0000-00-00'){
                                                // If Purchased but expired, show Add to Basket Again
                                    ?>
                                                <a href="javascript:;" class="btn btn-success btn-xs add_to_basket" id="<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>"><i class="fa fa-cart-plus "></i> Add to Basket</a>
                                    <?php
                                            }else{
                                                //If it is not expired, either quiz passed or not show VIEW
												if($is_rechas && !$is_rechas_passed && !$is_quiz_passed){
											?>
													<a href="<?php echo SURL?>pgd/pgd-rechas/<?php echo $vaccine_pgd_arr[$i]['id']?>" class="btn btn-info btn-xs fancybox_pgd_detail fancybox.ajax" id="<?php echo $vaccine_pgd_arr[$i]['id']?>"><i class="fa fa-eye"></i> Access to Training</a>	
												
											<?php		
												}else{
											?>
													<a href="<?php echo SURL?>pgd/pgd-certificate/<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>" class="btn btn-info btn-xs" id="<?php echo $vaccine_pgd_arr[$i]['id']?>"><i class="fa fa-eye"></i> Access to Training</a>  
											<?php		
												}//end if($is_rechas)
                                            }//end if($is_expired)
                                            
                                        }else{
                                            //If not purchased.
                                    ?>
                                            <a href="javascript:;" class="btn btn-success btn-xs add_to_basket" id="<?php echo $vaccine_pgd_arr[$i]['id']?>"><i class="fa fa-cart-plus "></i> Add to Basket</a>
                                    <?php
                                        }//end if($is_purchased)

										$averge_rating = get_product_ratings('PGD',$vaccine_pgd_arr[$i]['id']);
										$averge_rating = $averge_rating['avg_rating'];
										
                                    ?>
                                
                                  <input type="hidden" name="p_type" value="PGD" readonly="readonly"/>
                                  <input type="hidden" name="p_name" value="<?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?>" readonly="readonly"/>
                                  <input type="hidden" name="p_id" value="P_<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>" readonly="readonly"/>
                                  
                                   <input id="pgd_rating_input_readonly" type="number" displayOnly="1" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($averge_rating); ?>" />
        
                                    <a href="<?php echo SURL?>pgd/pgd-reviews/<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>" class="fancybox_pgd_review fancybox.ajax" id="pgd_review_link">
                                    <?php 

                                        $get_pgd_reviews_list = $this->purchase->get_product_reviews('PGD', filter_string($vaccine_pgd_arr[$i]['id']));
										
                                        echo ($purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['star_rating'] == '0') ? 'Rate this Product <br />' : '';
                                        echo number_format($averge_rating,1); 
                                    ?> starred - <?php echo count($get_pgd_reviews_list)?> <?php echo (count($get_pgd_reviews_list) > 1) ? 'Reviews' : 'Review' ?></a>
                                   
                                </div>
                              </div>
                            </form>
            <?php			
                            //Dont Show <HR> after last record
                            echo ($i < count($vaccine_pgd_arr)-1) ? '<hr />' : '';
                            
                        }//end if(!$vaccine_pgd_arr[$i]['is_child'])
                        
                    }//end for($i=0;$i<count($vaccine_pgd_arr);$i++)
                    
                    //CHILD VACCINES LISTING
                    for($i=0;$i<count($vaccine_pgd_arr);$i++){
                        
                        if($vaccine_pgd_arr[$i]['is_child']){
                            //Vaccine is a Child
        
                            $expiry_date = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['expiry_date'];
                            $is_purchased = ($purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]) ? 1 : 0; //If this PDG is puchased mark as 1.
                            $is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If PGD is expired marked as 1
                            $is_quiz_passed = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['is_quiz_passed']; //If quiz Assessment is passed marked as 1
                            
                            $doctor_approval = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['doctor_approval']; //Have doc approved the PGD after Assessment
                            $pharmacist_approval = $purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['pharmacist_approval']; //Have pharmacist approved the PGD after Assessment				
        
                            if(!$is_expired || $expiry_date == '0000-00-00'){ //Should not be expired, if expired do not show in the listing
            ?>
                            
                                <form name="vaccine_pgd_child_frm" id="vaccine_pgd_child_frm<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>">
                                  <div class="row">
                                    <div class="col-md-5">
                                      <p> <?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?>
                                        <a href="<?php echo SURL?>pgd/pgd-info/<?php echo $vaccine_pgd_arr[$i]['id'] ?>" class="btn btn-xs btn-info fancybox_pgd_detail fancybox.ajax"><i class="fa fa-info "></i> More Info</a> 
                                        <br>
                                        <?php
                                            //If not purchased only then show the prices
                                            if($is_purchased == 0){
                                        
                                                //If  discount vlaue > 0, the diccount proce will be considered
                                                if(filter_string($vaccine_pgd_arr[$i]['discount_price']) != 0.00){
                                         ?>
                                                    <span class="label label-danger"><s>&pound;<?php echo filter_string($vaccine_pgd_arr[$i]['price'])?></s></span></strong> <span class="label label-warning">&pound;<?php echo filter_string($vaccine_pgd_arr[$i]['discount_price'])?></span></strong>
                                                    
                                        <?php 
                                                }else{
                                        ?>
                                                    <span class="label label-danger">&pound;<?php echo filter_string($vaccine_pgd_arr[$i]['price'])?></span>
                                        <?php 
                                                }//end if(filter_string($vaccine_pgd_arr[$i]['discount_price']) != 0.00)
                                                
                                            }//end if($is_purchased == 0)
                                            
                                            if(filter_string($vaccine_pgd_arr[$i]['discount_price']) != 0.00){
                                        ?>
                                                <input type="hidden" name="p_price" value="<?php echo filter_string($vaccine_pgd_arr[$i]['discount_price']) ?>" readonly="readonly" />
                                        <?php		
                                            }else{
                                        ?>
                                                <input type="hidden" name="p_price" value="<?php echo filter_string($vaccine_pgd_arr[$i]['price']) ?>" readonly="readonly"/>
                                        <?php		
                                            }
                                        ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php
                                            if($is_purchased){
                                                    
                                                if($is_quiz_passed && $doctor_approval && $pharmacist_approval){ // If Purchased and not expired and Assessment test is passed, doc and pharmacist have approved the PGD Assessment
                                                    echo "Exp: ".date('d/m/Y',strtotime($expiry_date));
                                                }else{
                                                    if($is_quiz_passed){
                                                        echo ($belong_to_any_organization) ? "Waiting Authorisation" : 'Awaiting Superintendent account'; //If Quiz is passed bt not assessed by the pharmacist or doctor
													}else
                                                        echo "Waiting Assessment"; // If Purchased and not expired and Assessment test is not passed
                                                    
                                                }//end if($is_quiz_passed)
                                                
                                            }//end if($is_purchased)
                                            
                                        ?>
                                    </div>
                                    <div class="col-md-4 text-right"> 
                        
                                        <?php
                                            if($is_purchased){
                                        ?>
                                                <a href="<?php echo SURL?>pgd/pgd-certificate/<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>" class="btn btn-info btn-xs" id="<?php echo $vaccine_pgd_arr[$i]['id']?>"><i class="fa fa-eye"></i> Access to Training</a>                
                                        <?php			
                                                
                                            }//end if($is_purchased)
                                        ?>
                                    
                                        <input type="hidden" name="p_type" value="PGD" readonly="readonly"/>
                                        <input type="hidden" name="p_name" value="<?php echo filter_string($vaccine_pgd_arr[$i]['pgd_name'])?>" readonly="readonly"/>
                                        <input type="hidden" name="p_id" value="P_<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>" readonly="readonly"/>

									   <?php
                                        $averge_rating = get_product_ratings('PGD',$vaccine_pgd_arr[$i]['id']);
                                        $averge_rating = $averge_rating['avg_rating'];
                                       ?>
                                        
                                        <input id="pgd_rating_input_readonly" type="number" displayOnly="1" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($averge_rating); ?>" />
                                       
                                    <a href="<?php echo SURL?>pgd/pgd-reviews/<?php echo filter_string($vaccine_pgd_arr[$i]['id'])?>" class="fancybox_pgd_review fancybox.ajax" id="pgd_review_link">
                                    <?php 
                                        $get_pgd_reviews_list = $this->purchase->get_product_reviews('PGD', filter_string($vaccine_pgd_arr[$i]['id']));
                                        echo ($purchased_items_split_arr['pgds']['pgd_list'][$vaccine_pgd_arr[$i]['id']]['star_rating'] == '0') ? 'Rate this Product <br />' : '';
                                        echo number_format($averge_rating,1); 
                                    ?> starred - <?php echo count($get_pgd_reviews_list)?> <?php echo (count($get_pgd_reviews_list) > 1) ? 'Reviews' : 'Review' ?></a>
                                    
                                       
                                    </div>
                                  </div>
                                </form>
            <?php			
                                //Dont Show <HR> after last record
                                echo ($i < count($vaccine_pgd_arr)-1) ? '<hr />' : '';
                            
                            }//end if(!$is_expired){
                        }//end if($vaccine_pgd_arr[$i]['is_child'])
                        
                    }//end for($i=0;$i<count($vaccine_pgd_arr);$i++)
        
                }else{
            ?>
                <p><div role="alert" class="alert alert-danger">No Vaccine PGDs Listed!</div></p>
            <?php		
                }//end if(count($vaccine_pgd_arr) > 0)
            ?>
              
              </div>
          </div>
          
        </div>
    </div>
    <!-- END Vaccine PGDs Panel-->
    <?php }else{?>

        <div class="embed-responsive embed-responsive-4by3">
            <iframe class="embed-responsive-item" src="<?php echo $this->session->dashboard_video_url?>" width="100%" height="430" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
	<?php }//end if($this->session->is_prescriber == 0 && in_array($this->session->user_type,$non_presriber_usertype_arr) )?>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default" style="min-height:430px"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong><i class="fa fa-shopping-cart fa-1x"></i> Your Basket</strong></div>
      
      <!-- Table -->
      <div id="basket_container">
        <table class="table table-responsive dashboard_cart_table">
          <tr>
            <th>Products</th>
            <th>Price</th>
          </tr>
          <?php 
				if(count($this->cart->contents()) > 0){
					
	                foreach($this->cart->contents() as $row_id => $items){
						$items['qty'] = 1;
						$sub_total+=$items['price'];
            ?>
                          <tr>
                            <td><?php echo $items['name']?></td>
                            <td>&pound;<?php echo filter_price($items['price']) ?></td>
                            <td><a href="javascript:;" class="remove_from_basket" id="<?php echo $row_id ?>"> <i class="fa fa-times-circle"></i></a></td>
                          </tr>
          <?php 
	                }//end foreach ($this->cart->contents() as $items)
            ?>
          <tr>
            <td colspan="4" class="text-right"><strong>Subtotal: </strong> &pound;<?php echo filter_price($sub_total);?></td>
          </tr>
          <tr>
            <td colspan="4" class="text-right"><strong>VAT: </strong>&pound<?php
                            $vat_amount = ($vat_percentage / 100) * $sub_total;
                            echo filter_price($vat_amount);
                        ?> </td>
          </tr>
          <tr>
            <td colspan="4" class="text-right"><strong>Grand Total: </strong> &pound;<?php 
                            $total_amount = $sub_total + $vat_amount ;
                            echo filter_price($total_amount);
                        ?></td>
          </tr>
          <tr>
            <td colspan="4" class="text-center">
                <a href="javascript:;" class="btn btn-xs btn-danger empty_basket"><i class="fa fa-times-circle"></i> Empty Basket</a>
                <a href="<?php echo SURL?>dashboard/checkout" class="btn btn-xs btn-warning checkout_btn"><i class="fa fa-paypal"></i> Check Out</a> 
	        </td>
          </tr>
          <?php
				}else{
			?>
          <tr>
            <td align="center" colspan="2"><img src="<?php echo IMAGES?>remove_from_shopping_cart.png" /><br />
              Oops! Your Cart is Empty.</td>
          </tr>
          <?php		
				}//end if(count($this->cart->contents() > 0)
			 ?>
        </table>
      </div>
      <div id="overlay_addtobasket" class="overlay hidden">
        <div class="col-md-12 text-center" style="margin-top:150px;"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div>
      </div>
    </div>
  </div>
</div>
<!-- end div class="row" -->


<div class="panel panel-default"> 
  
  <!-- Default panel contents -->
  <div class="panel-heading"><strong>Online Courses</strong></div>
  <div class="panel-body">
    <p class="align-left">Hubnet is an online pharmacy information system. We intend to provide healthcare professionals with an online ecosystem to allow for better communication between each other and their patients. Protected by law, the data you enter into this site remains your intellectual property and cannot be used by us. Our goal is to enable you to do more, if you like it you can subscribe for more! </p>
    <p>
    <hr />
    </p>
    <?php
		if(count($training_courses_arr) > 0){
			
			for($i=0;$i<count($training_courses_arr);$i++){

				$expiry_date = $purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]['expiry_date'];
				$is_purchased = ($purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]) ? 1 : 0; //If this Training Videos is puchased mark as 1.
				$is_expired = (strtotime(date('Y-m-d')) <= strtotime($expiry_date)) ? 0 : 1; //If Training Videos is expired marked as 1
	?>
                <form name="training_frm" id="training_frm_<?php echo $training_courses_arr[$i]['id']?>">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="row">
                        <div class="col-md-2">
                          <p><a href="<?php echo SURL?>training/training-detail/<?php echo $training_courses_arr[$i]['id']?>" class="fancybox_course fancybox.ajax"><img class="img-responsive img-hover" src="<?php echo TRAINING_COURSE_IMAGES.filter_string($training_courses_arr[$i]['course_image']) ?>" alt=""></a></p>
                        </div>
                        <div class="col-md-10">
                          <p> <strong>
                            <?php 
                                echo filter_string($training_courses_arr[$i]['course_name']);
            
                                //If not purchased only then show the prices
                                if($is_purchased == 0){
									
                                	if(filter_string($training_courses_arr[$i]['price']) > 0.00){
										//If  discount vlaue > 0, the diccount proce will be considered
										if(filter_string($training_courses_arr[$i]['discount_price']) != 0.00){
                             ?>
                                        <span class="label label-danger"><s>&pound;<?php echo filter_string($training_courses_arr[$i]['price'])?></s></span></strong> <span class="label label-warning">&pound;<?php echo filter_string($training_courses_arr[$i]['discount_price'])?></span></strong>
                                    
                            <?php 
	                                    }else{
                            ?>
    	                                <span class="label label-danger">&pound;<?php echo filter_string($training_courses_arr[$i]['price'])?></span>
                                    
                            <?php 
        	                            }//end if(filter_string($training_courses_arr[$i]['discount_price']) != 0.00)
									}//end if(filter_string($training_courses_arr[$i]['price']) > 0.00)
                                    
                                }//end if($is_purchased == 0)
								
								if(filter_string($training_courses_arr[$i]['price']) <= 0.00){
							?>
                            		<span class="label label-success">Free</span>
                            <?php		
								}
                            ?>
                            </strong> </p>
                          <p class="text-left"><?php echo filter_string($training_courses_arr[$i]['short_description'])?></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 text-right">
                    <?php

                        //If Training is purchased 
                        if($is_purchased){
							
                            if($is_expired && $expiry_date!= '0000-00-00'){
								
								if(filter_string($training_courses_arr[$i]['price']) <= 0.00){
									//Training is free
					?>
                    				 <a href="<?php echo SURL?>training/training-videos/<?php echo filter_string($training_courses_arr[$i]['id'])?>" class="btn btn-xs btn-info"><i class="fa fa-eye "></i> Enter Course</a>
                    <?php				
								}else{
									
									
                                //If training is purchased but expired
                    ?>
                                <a href="<?php echo SURL?>training/training-detail/<?php echo $training_courses_arr[$i]['id']?>" class="btn btn-xs btn-info fancybox_course fancybox.ajax"><i class="fa fa-info "></i> More Info</a> 
                                <a href="javascript:;" class="btn btn-xs btn-success add_to_basket" id="<?php echo $training_courses_arr[$i]['id']?>"><i class="fa fa-cart-plus "></i> Add to Basket</a>        
                    <?php			
								}//end if(filter_string($training_courses_arr[$i]['price']) <= 0.00)
							}else{
                                //If training is purchased and not expired	
                    ?>
                                <a href="<?php echo SURL?>training/training-videos/<?php echo filter_string($training_courses_arr[$i]['id'])?>" class="btn btn-xs btn-info"><i class="fa fa-eye "></i> Enter Course</a>
                                <?php 
                                    if(filter_string($purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]['is_quiz_passed']) == 1){
                                        //If Quiz is passed only then show the Exp
                                ?>
                                        <p class="small">Exp: <?php echo date('d/m/Y',strtotime($expiry_date)); ?></p>
                                <?php
                                
                                    }//end if(filter_string($training_courses_arr[$i]['is_quiz_passed']) == 1)
            
                            }//end if($is_expired && $expiry_date!= '0000-00-00')
                                
                        }else{
                            //If training are not purchased yet	
                            
                            //Check if the price of the training is 0, if yes consider it as a free training
                            if(filter_string($training_courses_arr[$i]['price']) > 0.00){
                    ?>
                                <a href="<?php echo SURL?>training/training-detail/<?php echo $training_courses_arr[$i]['id']?>" class="btn btn-xs btn-info fancybox_course fancybox.ajax"><i class="fa fa-info "></i> More Info</a>
                           
                                <a href="javascript:;" class="btn btn-xs btn-success add_to_basket" id="<?php echo $training_courses_arr[$i]['id']?>"><i class="fa fa-cart-plus "></i> Add to Basket</a>
                    
                    <?php
                            }else{
                    ?>
                                <a href="<?php echo SURL?>training/training-videos/<?php echo filter_string($training_courses_arr[$i]['id'])?>" class="btn btn-xs btn-info"><i class="fa fa-eye "></i> Enter Course</a>
                    <?php
                            }//end if(filter_string($training_courses_arr[$i]['price'] > 0.00)
                        }//end if($is_purchased)
            
                        if(filter_string($training_courses_arr[$i]['discount_price']) != 0.00){
                    ?>
                                <input type="hidden" name="p_price" value="<?php echo filter_string($training_courses_arr[$i]['discount_price']) ?>" readonly="readonly" />
                    <?php		
                        }else{
                    ?>
                                <input type="hidden" name="p_price" value="<?php echo filter_string($training_courses_arr[$i]['price']) ?>" readonly="readonly"/>
                    <?php		
                        }//end if
                        
                    ?>
                      <input type="hidden" name="p_name" value="<?php echo filter_string($training_courses_arr[$i]['course_name'])?>" readonly="readonly"/>
                      <input type="hidden" name="p_id" value="T_<?php echo filter_string($training_courses_arr[$i]['id'])?>" readonly="readonly"/>
                      <input type="hidden" name="p_type" value="TRAINING" readonly="readonly"/>
                    
                      <p class="text-right">
					   <?php
                        $averge_rating = get_product_ratings('TRAINING',$training_courses_arr[$i]['id']);
                        $averge_rating = $averge_rating['avg_rating'];
                       ?>
      
                       <input id="training_rating_input_readonly" type="number" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($averge_rating) ?>" displayOnly="1" />
                        <a href="<?php echo SURL?>training/training-reviews/<?php echo filter_string($training_courses_arr[$i]['id'])?>" class="fancybox_pgd_review fancybox.ajax" id="pgd_review_link">
                        <?php 
						
                            $get_training_reviews_list = $this->purchase->get_product_reviews('TRAINING', $training_courses_arr[$i]['id']);
                            echo ($purchased_items_split_arr['training'][$training_courses_arr[$i]['id']]['star_rating'] == '0') ? 'Rate this Product <br />' : '';
							echo number_format($averge_rating,1); 
                        ?> starred - <?php echo count($get_training_reviews_list)?> <?php echo (count($get_training_reviews_list) > 1) ? 'Reviews' : 'Review' ?></a>
                       
                      </p>
                      
                    </div>
                  </div>
                </form>
    <?php		
				//Dont Show <HR> after last record
				echo ($i < count($training_courses_arr)-1) ? '<hr />' : '';
			}//end for
			
		}else{
	?>
    <p>
    <div role="alert" class="alert alert-danger">No Courses Listed!</div>
    </p>
    <?php		
		}//end if(count($training_courses_arr) > 0)
	?>
  </div>
</div>

<!--
<script>

	var activate_dashboard_fancy = < ?php echo ($this->session->is_prescriber == 0 && in_array($this->session->user_type,$non_presriber_usertype_arr) && $this->session->is_intro_video_watched == 0) ? 1 : 0?>;
	
	activate_dashboard_fancy = 1;
</script>
-->

<style>
.panel-heading .accordion-toggle:after {
    /* symbol for "opening" panels */
    font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
    content: "\e114";    /* adjust as needed, taken from bootstrap.css */
    float: right;        /* adjust as needed */
    color: grey;         /* adjust as needed */
}
.panel-heading .accordion-toggle.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\e080";    /* adjust as needed, taken from bootstrap.css */
}

</style>

<script>

$(document).ready(function(){
    $(document).on('show','.accordion', function (e) {
         //$('.accordion-heading i').toggleClass(' ');
         $(e.target).prev('.accordion-heading').addClass('accordion-opened');
    });
    
    $(document).on('hide','.accordion', function (e) {
        $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
        //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
    });
	
	
});
    
</script>