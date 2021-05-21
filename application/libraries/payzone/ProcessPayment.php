<?php
	require_once ("ThePaymentGateway/PaymentSystem.php");
	include ("ISOCurrencies.php");
	include ("ISOCountries.php");

	$rgeplRequestGatewayEntryPointList = new RequestGatewayEntryPointList();
	// you need to put the correct gateway entry point urls in here
	// contact support to get the correct urls

    // The actual values to use for the entry points can be established in a number of ways
    // 1) By periodically issuing a call to GetGatewayEntryPoints
    // 2) By storing the values for the entry points returned with each transaction
    // 3) Speculatively firing transactions at https://gw1.xxx followed by gw2, gw3, gw4....
	// The lower the metric (2nd parameter) means that entry point will be attempted first,
	// EXCEPT if it is -1 - in this case that entry point will be skipped
	// NOTE: You do NOT have to add the entry points in any particular order - the list is sorted
	// by metric value before the transaction sumbitting process begins
	// The 3rd parameter is a retry attempt, so it is possible to try that entry point that number of times
	// before failing over onto the next entry point in the list
	$rgeplRequestGatewayEntryPointList->add("https://gw1.".$PaymentProcessorFullDomain, 100, 1);
	$rgeplRequestGatewayEntryPointList->add("https://gw2.".$PaymentProcessorFullDomain, 200, 1);
	$rgeplRequestGatewayEntryPointList->add("https://gw3.".$PaymentProcessorFullDomain, 300, 1);
	
	echo $PaymentProcessorFullDomain;
	
	$cdtCardDetailsTransaction = new CardDetailsTransaction($rgeplRequestGatewayEntryPointList);

	$cdtCardDetailsTransaction->getMerchantAuthentication()->setMerchantID($MerchantID);
	
	$cdtCardDetailsTransaction->getMerchantAuthentication()->setPassword($Password);

	$cdtCardDetailsTransaction->getTransactionDetails()->getMessageDetails()->setTransactionType("SALE");

	$cdtCardDetailsTransaction->getTransactionDetails()->getAmount()->setValue($Amount);

	if ($CurrencyShort != "" &&
		$iclISOCurrencyList->getISOCurrency($CurrencyShort, $icISOCurrency))
	{
		$cdtCardDetailsTransaction->getTransactionDetails()->getCurrencyCode()->setValue($icISOCurrency->getISOCode());
	}

	$cdtCardDetailsTransaction->getTransactionDetails()->setOrderID($OrderID);
	$cdtCardDetailsTransaction->getTransactionDetails()->setOrderDescription($OrderDescription);

	$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoCardType()->setValue(true);
	$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoAmountReceived()->setValue(true);
	$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoAVSCheckResult()->setValue(true);
	$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getEchoCV2CheckResult()->setValue(true);
	$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getThreeDSecureOverridePolicy()->setValue(true);
	$cdtCardDetailsTransaction->getTransactionDetails()->getTransactionControl()->getDuplicateDelay()->setValue(60);

	$cdtCardDetailsTransaction->getTransactionDetails()->getThreeDSecureBrowserDetails()->getDeviceCategory()->setValue(0);
	$cdtCardDetailsTransaction->getTransactionDetails()->getThreeDSecureBrowserDetails()->setAcceptHeaders("*/*");
	$cdtCardDetailsTransaction->getTransactionDetails()->getThreeDSecureBrowserDetails()->setUserAgent($_SERVER["HTTP_USER_AGENT"]);

	$cdtCardDetailsTransaction->getCardDetails()->setCardName($CardName);
	$cdtCardDetailsTransaction->getCardDetails()->setCardNumber($CardNumber);

	if ($ExpiryDateMonth != "")
	{
		$cdtCardDetailsTransaction->getCardDetails()->getExpiryDate()->getMonth()->setValue($ExpiryDateMonth);
	}
	if ($ExpiryDateYear != "")
	{
		$cdtCardDetailsTransaction->getCardDetails()->getExpiryDate()->getYear()->setValue($ExpiryDateYear);
	}
	if ($StartDateMonth != "")
	{
		$cdtCardDetailsTransaction->getCardDetails()->getStartDate()->getMonth()->setValue($StartDateMonth);
	}
	if ($StartDateYear != "")
	{
		$cdtCardDetailsTransaction->getCardDetails()->getStartDate()->getYear()->setValue($StartDateYear);
	}

	$cdtCardDetailsTransaction->getCardDetails()->setIssueNumber($IssueNumber);
	$cdtCardDetailsTransaction->getCardDetails()->setCV2($CV2);

	$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress1($Address1);
	$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress2($Address2);
	$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress3($Address3);
	$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setAddress4($Address4);
	$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setCity($City);
	$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setState($State);
	$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->setPostCode($PostCode);

	if ($CountryShort != "" &&
		$CountryShort != "-1" &&
		$iclISOCountryList->getISOCountry($CountryShort, $icISOCountry))
	{
		$cdtCardDetailsTransaction->getCustomerDetails()->getBillingAddress()->getCountryCode()->setValue($icISOCountry->getISOCode());
	}

	$cdtCardDetailsTransaction->getCustomerDetails()->setEmailAddress("test@test.com");
	$cdtCardDetailsTransaction->getCustomerDetails()->setPhoneNumber("123456789");
	//$cdtCardDetailsTransaction->getCustomerDetails()->setCustomerIPAddress($_SERVER["REMOTE_ADDR"]);
	$cdtCardDetailsTransaction->getCustomerDetails()->setCustomerIPAddress('127.0.0.1');
	
	//echo $_SERVER["REMOTE_ADDR"];

	$boTransactionProcessed = $cdtCardDetailsTransaction->processTransaction($cdtrCardDetailsTransactionResult, $todTransactionOutputData);
	
	if ($boTransactionProcessed == false)
	{
		// could not communicate with the payment gateway 
		$NextFormMode = "PAYMENT_FORM";
		$Message = "Couldn't communicate with payment gateway";
		PaymentFormHelper::reportTransactionResults($OrderID, 30, $Message, null);
	}
	else
	{
		
		switch ($cdtrCardDetailsTransactionResult->getStatusCode())
		{
			case 0:
				// status code of 0 - means transaction successful 
				$NextFormMode = "RESULTS";
				$Message = $cdtrCardDetailsTransactionResult->getMessage();
				$TransactionSuccessful = true;
				PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $todTransactionOutputData->getCrossReference());
				break;
			case 3:
				// status code of 3 - means 3D Secure authentication required 
				$NextFormMode = "THREE_D_SECURE";
				$PaREQ = $todTransactionOutputData->getThreeDSecureOutputData()->getPaREQ();
				$CrossReference = $todTransactionOutputData->getCrossReference();
				$BodyAttributes = " onload=\"document.Form.submit();\"";
				$FormAttributes = " target=\"ACSFrame\"";
				$FormAction = $todTransactionOutputData->getThreeDSecureOutputData()->getACSURL();
				PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $todTransactionOutputData->getCrossReference());
				break;
			case 5:
				// status code of 5 - means transaction declined 
				$NextFormMode = "RESULTS";
				$Message=$cdtrCardDetailsTransactionResult->getMessage();
				$TransactionSuccessful = false;
				PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $todTransactionOutputData->getCrossReference());
				break;
			case 20:
				// status code of 20 - means duplicate transaction 
				$NextFormMode = "RESULTS";
				$Message = $cdtrCardDetailsTransactionResult->getMessage();
				if ($cdtrCardDetailsTransactionResult->getPreviousTransactionResult()->getStatusCode()->getValue() == 0)
				{
					$TransactionSuccessful = true;
				}
				else
				{
					$TransactionSuccessful = false;
			   	}
				$PreviousTransactionMessage = $cdtrCardDetailsTransactionResult->getPreviousTransactionResult()->getMessage();
				$DuplicateTransaction = true;
				PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getPreviousTransactionResult()->getStatusCode()->getValue(), $PreviousTransactionMessage, $todTransactionOutputData->getCrossReference());
				break;
			case 30:
				// status code of 30 - means an error occurred 
				$NextFormMode = "PAYMENT_FORM";
				$Message = $cdtrCardDetailsTransactionResult->getMessage();
				if ($cdtrCardDetailsTransactionResult->getErrorMessages()->getCount() > 0)
				{
					$Message = $Message."<br /><ul>";

					for ($LoopIndex = 0; $LoopIndex < $cdtrCardDetailsTransactionResult->getErrorMessages()->getCount(); $LoopIndex++)
					{
						$Message = $Message."<li>".$cdtrCardDetailsTransactionResult->getErrorMessages()->getAt($LoopIndex)."</li>";
					}
					$Message = $Message."</ul>";
					$TransactionSuccessful = false;
				}
				if ($todTransactionOutputData == null)
				{
					$szResponseCrossReference = "";
				}
				else
				{
					$szResponseCrossReference = $todTransactionOutputData->getCrossReference();
				}
				PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $szResponseCrossReference);
				break;
			default:
				// unhandled status code  
				$NextFormMode = "PAYMENT_FORM";
				$Message = $cdtrCardDetailsTransactionResult->getMessage();
				if ($todTransactionOutputData == null)
				{
					$szResponseCrossReference = "";
				}
				else
				{
					$szResponseCrossReference = $todTransactionOutputData->getCrossReference();
				}
				PaymentFormHelper::reportTransactionResults($OrderID, $cdtrCardDetailsTransactionResult->getStatusCode(), $cdtrCardDetailsTransactionResult->getMessage(), $szResponseCrossReference);
				break;
		}
	}
?>