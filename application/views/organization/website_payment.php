<div class="row">
  <div class="col-md-8">
    <h4 style="margin-bottom: 25px;">Please select your payment method.</h4>
    <div class="tabbable pay-tabs">
      <ul class="nav nav-tabs" id="myTab">
        <li class="active"> <a href="#tab-1" data-toggle="tab"><img src="<?php echo IMAGES; ?>icon-cc.png" class="img-responsive" alt="Credit Card" /> </a> </li>
        <!--<li class=""> <a href="#tab-2" data-toggle="tab"><img src="<?php echo IMAGES; ?>icon-paypal.png" class="img-responsive" alt="PayPal" /></a> </li>-->
      </ul>
      <div class="tab-content tab-payment">
        <div class="tab-pane fade in" id="tab-1">
          <form data-toggle="validator" role="form" id="submit_cc_details_from" name="submit_cc_details_from" class="cc-form" action="<?php echo SURL; ?>organization/website-payment-process" method="post">
            <!--<h4>Billing Address</h4>
            <div class="row">
              <div class="form-group col-md-12">
                <label>Find your Postcode</label>
                <div id="postcode_lookup" class=""></div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label>First Name</label>
                <input name="b_first_name" id="b_first_name" type="text" class="form-control" value="" placeholder="First Name"  data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9]+[a-zA-Z0-9-_]{1,30}$" data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"   >
              </div>
              <div class="form-group col-md-6">
                <label>Last Name</label>
                <input name="b_last_name" id="b_last_name" type="text" class="form-control" value="" placeholder="Last Name"  data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9]+[a-zA-Z0-9-_]{1,30}$" data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"   >
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label>Address 1</label>
                <input name="b_address" id="address_1" type="text"   class="form-control" value=""  placeholder="Address" data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9\s\-,]+[a-zA-Z0-9\s-_,']{1,50}$"  data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma,Space)" maxlength="50">
              </div>
              <div class="form-group col-md-6">
                <label>Address 2</label>
                <input name="b_address2" type="text" class="form-control" value="" id="address_2" placeholder="Address2" data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9\s\-,]+[a-zA-Z0-9\s-_,']{1,50}$" data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma,Space)" maxlength="50">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label>Address 3</label>
                <input name="b_address3" type="text" value="" class="form-control" id="address_3" placeholder="Address3" data-fv-regexp="true" data-fv-regexp-regexp="^[a-zA-z0-9\s\-,]+[a-zA-Z0-9\s-_,']{1,50}$" data-fv-regexp-message="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma,Space)" maxlength="50">
              </div>
              <div class="form-group col-md-6">
                <label>State/ County</label>
                <input name="b_state" type="text" value="" class="form-control" id="county" placeholder="State/ County">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label>Post Town</label>
                <input name="b_post_town" type="text" value="" class="form-control" id="town" placeholder="Post Town">
              </div>
              <div class="form-group col-md-6">
                <label>Post Code</label>
                <input name="b_postcode" type="text"   value="" class="form-control my_upper_class" id="postcode" placeholder="Postcode" data-fv-regexp="true"  data-fv-regexp-regexp="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]{0,10}$"
                                  data-fv-regexp-message="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="10">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <label>Country</label>
                <select name="b_country_code" id="country-1" class="form-control" >
                  <option value="">Select Country</option>
                  <?php 
						if($countries){
							
							foreach($countries as $country){
					?>
<option <?php if($patient_address['b_country_code'] != '' && $country['iso3'] == $patient_address['b_country_code']) { echo 'selected="selected"'; } elseif($patient_address['b_country_code'] == '' && $country['iso3'] == 'GBR'){ echo 'selected="selected"'; }?> value="<?php echo $country['iso3']; ?>"><?php echo $country['country_name']; ?></option>
<?php
							} // foreach($countries as $country)
							
						} // if($countries)
						?>
                </select>
              </div>
            </div>-->
            <h4>Pay via Credit/Debit Card</h4>
            <div class="row">
              <div class="form-group has-feedback col-md-6">
                <label>Card Number</label>
                <input name="CardNumber" id="CardNumber" type="text" placeholder="Enter credit/ debit card number" class="form-control" autocomplete="off" required >
                  <div class="help-block with-errors"></div>
                
               </div>
                
              <div class="form-group col-md-6">
                <label>Card Holder Name</label>
                <input name="CardName" id="CardName" type="text" placeholder="Enter card holder name" class="form-control" required >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="ExpiryDateMonth">Expiration Date </label>
                <select class="form-control" id="ExpiryDateMonth" name="ExpiryDateMonth" required>
                  <option value="">Select Month</option>
                  <?php echo $lilExpiryDateMonthList?>
                </select>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="ExpiryDateYear">&nbsp;</label>
                <select class="form-control" id="ExpiryDateYear" name="ExpiryDateYear" required>
                  <option value="">Select Year</option>
                  <?php echo $lilExpiryDateYearList?>
                </select>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="StartDateMonth">Start Date</label>
                <select class="form-control" id="StartDateMonth" name="StartDateMonth" required>
                  <option value="">Select Month</option>
                  <?php echo $lilStartDateMonthList?>
                </select>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="StartDateYear">&nbsp;</label>
                <select class="form-control" id="StartDateYear" name="StartDateYear" required>
                  <option value="">Select Year</option>
                  <?php echo $lilStartDateYearList?>
                </select>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <label>CV2</label>
                <input name="CV2" id="CV2" type="text" placeholder="Enter CV2 number"  class="form-control" required>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <input class="btn btn-primary btn-lg pull-right pay_sbt_btn" type="submit" value="Proceed Payment" name="cc_submit_btn" />
                <input type="hidden" class="package_id" name="package_id" value="<?php echo $pkge_id; ?>" readonly="readonly" />
                <input type="hidden" class="template_id" name="template_id" value="<?php echo $tmp_id; ?>" readonly="readonly"/>
                <!--<input type="hidden" class="domain_name" name="domain_name" value="< ?php echo $this->input->post('search_domain'); ?>" readonly="readonly"/>-->
                <input type="hidden" class="is_renewal" name="is_renewal" value="<?php echo ($this->input->post('is_renewal')) ? 1 : 0; ?>" readonly="readonly"/>
                <input type="hidden" class="email_address" name="email_address" value="<?php echo $this->input->post('email_address'); ?>" readonly="readonly"/>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade in active " id="tab-2">
          <h4>Pay via Paypal</h4>
          <?php 
		  	if($pkge_id != 0){

		?>
              <img class="img-responsive" width="250" src="<?php echo IMAGES; ?>paypal.png" alt="Pay by Paypal" title="Image Title" /><br />
              <form class="" action="<?php echo SURL; ?>organization/website-paypal-process" method="post">
                <input class="btn btn-primary pull-right pay_sbt_btn" type="submit" value="Checkout via Paypal" name="paypal_submit_btn" id="paypal_submit_btn" onClick="" />
                <input type="hidden" class="package_id" name="package_id" value="<?php echo $pkge_id; ?>" readonly="readonly"/>
                <input type="hidden" class="no_of_branches" name="no_of_branches" id="no_of_branches_paypal" value="" readonly="readonly"/>
                <input type="hidden" class="template_id" name="template_id" value="<?php echo $tmp_id; ?>" readonly="readonly"/>
                
                <input type="hidden" class="is_renewal" name="is_renewal" value="<?php echo ($is_renewal) ? 1 : 0; ?>" readonly="readonly"/>
                <!--<input type="hidden" class="domain_name" name="domain_name" value="< ?php echo $this->input->post('search_domain'); ?>" readonly="readonly"/>-->
                <input type="hidden" class="email_address" name="email_address" value="<?php echo $this->input->post('email_address'); ?>" readonly="readonly"/>
	         </form>
        <?php	
			}else{
		?>
        	<p class="alert alert-info">Contact info@pharmafocus.co.uk</p>
        <?php		
			}//end if($pkge_id != 0)
		  ?>
         
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="payment-right">
      <header class="clearfix"> 
      	<img src="<?php echo TECHDEVELOPERS_SURL; ?>assets/images/template_images/<?php echo ($selected_template) ? $selected_template->template_icon : '' ; ?>" alt="" width="200" /> 
        <!--<h4> < ?php echo ($selected_template) ? $selected_template->template_name : '' ; ?> </h4>-->
        
        <?php 
			if($selected_template && $selected_template->template_id){ 
		?>
	        	<p>Design ID: <?php echo ($selected_template) ? $selected_template->template_id : '' ; ?></p>
        <?php 
			} else { 
		?>
    	    	<p class="text-danger">No template selected </p>
        <?php 
			} // if($template_details) 
		?>
      </header>
      <div class="offset_bottom_10">
        <h4>Package</h4>
        <select class="form-control" id="select-package">
			<option <?php echo ($pkge_id == $package_list->standard->id)  ? 'selected="selected"' : '' ; ?> value="1"> <?php echo $package_list->standard->package_name; ?> </option>
            <option <?php echo ($pkge_id == $package_list->premium->id)  ? 'selected="selected"' : '' ; ?> value="2"> <?php echo $package_list->premium->package_name; ?> </option>
            <option <?php echo ($pkge_id == $package_list->multibranch->id)  ? 'selected="selected"' : '' ; ?> value="3"> Multibranch</option>
        </select>
      </div>
      <div class="offset_bottom_10  <?php echo ($pkge_id == $package_list->multibranch->id) ? '' : 'hidden'?>" id="no_branch_container">
        <h4>No of Branches</h4>
        <select class="form-control" name="no_of_branches" id="no_of_branches">
        	<?php 
				for($i=0;$i<=10;$i++){
			?>
            		<option value="<?php echo $i?>">
						<?php 
							if($i == 0) 
								echo 'No Branch'; 
							elseif($i == 1) 
								echo $i.' Branch';
							else
								echo $i.' Branches';
						?>
                    </option>
            <?php		
				}//end for($i=0;$i<10;$i++)
			?>
        </select>
      </div>

		<?php
            
            // Calculate package pricing
        
            $currency = '&pound;';
			
			if($pkge_id == 1)
				$package_price = $package_list->standard->package_price;
			elseif($pkge_id == 2)
				$package_price = $package_list->premium->package_price;
			elseif($pkge_id == 3)
				$package_price = $package_list->multibranch->package_price;
			elseif($pkge_id == 0)
				$package_price = CUSTOM_PACKAGE_PRICE;
        
            // Package Price
            $price = ($package_price) ? $package_price : '0.00' ;
			
            // Sub total
            $sub_total = ($package_price) ? $package_price : '0.00' ;
            
            // Calculate VAT amount
            $vat_percentage = 20;
            $vat_amount = ($vat_percentage / 100) * $sub_total;
            $vat_amount = filter_price($vat_amount);
            $vat_amount = ($vat_amount) ? $vat_amount : '0.00' ;
            
            // Calculate grand total
            $grand_total = $sub_total + $vat_amount;
            $grand_total = number_format($grand_total,2);
            
            ?>
      
        <table class="table table-responsive table-bordered table-condensed payment-table">
          <tr>
            <th>Items</th>
            <th>Price</th>
          </tr>
          <tr>
            <td>Package Price</td>
            <td><span id="package-price"> <?php echo ($price) ? $currency.$price : '0.00' ; ?> </span></td>
          </tr>
          <tr>
            <td class="text-right"><strong>Sub Total</strong></td>
            <td><strong> <span id="sub-total"> <?php echo ($sub_total) ? $currency.$sub_total : '0.00' ; ?> </span> </strong></td>
          </tr>
          <tr>
            <td class="text-right"><strong>VAT</strong></td>
            <td><strong> <span id="vat-amount"> <?php echo ($vat_amount) ? $currency.$vat_amount : '0.00' ; ?> </span> </strong></td>
          </tr>
        </table>
      
      <p class="text-right" style="font-size:18px"> Total Price: <span id="grand-total"> <?php echo ($grand_total) ? $currency.$grand_total : '0.00' ; ?> </span> </p>
    </div>
  </div>
</div>


<script src="https://getaddress.io/js/jquery.getAddress-2.0.5.min.js"></script> 
<script>
<?php  
	   // Get POSTCODE API KEY
	   $POSTCODE_KEY = 'POSTCODE_KEY'; 
	   $key = get_global_settings($POSTCODE_KEY);
	   $api_postcode_key = $key['setting_value']; 
?>

(function($){
	jQuery('#postcode_lookup').getAddress({
	// api_key: 'BmiwdQp9W0q1l-EucVP_9A6735',  
	api_key: '<?php echo $api_postcode_key;?>',
	
	<!--  Or use your own endpoint - api_endpoint:https://your-web-site.com/getAddress, -->
	output_fields:{
		line_1: '#address',
		line_2: '#address_2',
		line_3: '#line3',
		post_town: '#town',
		county: '#county',
		postcode: '#postcode'
	},
<!--  Optionally register callbacks at specific stages -->                                                                                                               
    onLookupSuccess: function(data){/* Your custom code */},
    onLookupError: function(){/* Your custom code */},
    onAddressSelected: function(elem,index){}

});
})(jQuery);

  
// Function to change subtotal and grand total according to the selected package
$('#select-package, #no_of_branches').on('change', function(){

	var package_id = $('#select-package').val();
	$('.package_id').val(package_id);
	
	no_of_branches = $('#no_of_branches').val();
	$('.no_of_branches').val(no_of_branches);
	
	if(package_id == 3)
		$('#no_branch_container').removeClass('hidden');
	else
		$('#no_branch_container').addClass('hidden');

	// send ajax call to get package pricing
	$.ajax({
		
		url: SURL+'organization/update-package-pricing',
		type: "POST",
		data: {'package_id': package_id, 'no_of_branches' : no_of_branches },
		
		beforeSend: function(response){
			$('.pay_sbt_btn').attr('disabled',true);
		},
		success: function(response){

			var response_object = JSON.parse(response);
			
			if(response_object.success == 1){
				
				$('#package-price').text('£'+response_object.package_price);
				$('#sub-total').text('£'+response_object.sub_total);
				$('#vat-amount').text('£'+response_object.vat_amount);
				$('#grand-total').text('£'+response_object.grand_total);
				
				$('.pay_sbt_btn').attr('disabled',false);
				
			} // if(response_object.success == 'true')
			
		} //success

	}); // $.ajax

}); // $('#select-package').on('change', function()

// Trigger package change
$('#select-package').trigger('change');

</script>