<?php
	// Will need to set these variables to valid a MerchantID and Password
	// These were obtained during sign up
	
	$PAYZONE_MERCHANT_ID = 'PAYZONE_MERCHANT_ID';
	$payzone_merchant_id = get_global_settings($PAYZONE_MERCHANT_ID);
	$payzone_merchant_id = filter_string($payzone_merchant_id['setting_value']);

    $MerchantID = $payzone_merchant_id;

	$PAYZONE_PASSWORD = 'PAYZONE_PASSWORD';
	$payzone_password = get_global_settings($PAYZONE_PASSWORD);
	$payzone_password = filter_string($payzone_password['setting_value']);

    $Password = $payzone_password;
    
    // This is the domain (minus any host header or port number for your payment processor
    // e.g. for "https://gwX.paymentprocessor.net:4430/", this should be "paymentprocessor.net"
    // e.g. for "https://gwX.thepaymentgateway.net/", this should be "thepaymentgateway.net"
    $PaymentProcessorDomain = "payzoneonlinepayments.com"; // paymentprocessor.net
    // This is the port that the gateway communicates on -->
    // e.g. for "https://gwX.paymentprocessor.net:4430/", this should be 4430
    // e.g. for "https://gwX.thepaymentgateway.net/", this should be 443
    $PaymentProcessorPort = 4430;

	$PAYZONE_SECRET_KEY = 'PAYZONE_SECRET_KEY';
	$payzone_secret_key = get_global_settings($PAYZONE_SECRET_KEY);
	$payzone_secret_key = filter_string($payzone_secret_key['setting_value']);

    // This is used to generate the Hash Keys that detect variable tampering
    // You should change this to something else
    $SecretKey = $payzone_secret_key;
    
	if ($PaymentProcessorPort == 443)
	{
		$PaymentProcessorFullDomain = $PaymentProcessorDomain."/";
	}
	else
	{
		$PaymentProcessorFullDomain = $PaymentProcessorDomain.":".$PaymentProcessorPort."/";
	}
