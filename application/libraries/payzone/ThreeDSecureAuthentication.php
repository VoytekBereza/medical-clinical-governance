<?php
	require_once ("ThePaymentGateway/PaymentSystem.php");

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

	$tdsaThreeDSecureAuthentication = new ThreeDSecureAuthentication($rgeplRequestGatewayEntryPointList);
	
	$tdsaThreeDSecureAuthentication->getMerchantAuthentication()->setMerchantID($MerchantID);
	$tdsaThreeDSecureAuthentication->getMerchantAuthentication()->setPassword($Password);

	$tdsaThreeDSecureAuthentication->getThreeDSecureInputData()->setCrossReference($CrossReference);
	$tdsaThreeDSecureAuthentication->getThreeDSecureInputData()->setPaRES($PaRES);

	$boTransactionProcessed = $tdsaThreeDSecureAuthentication->processTransaction($tdsarThreeDSecureAuthenticationResult, $todTransactionOutputData);

	if ($boTransactionProcessed == false)
	{
		// could not communicate with the payment gateway
		$NextFormMode = "RESULTS";
		$Message = "Couldn't communicate with payment gateway";
		$TransactionSuccessful = false;
		PaymentFormHelper::reportTransactionResults($CrossReference, 30, $Message, null);
	}
	else
	{
		switch ($tdsarThreeDSecureAuthenticationResult->getStatusCode())
		{
			case 0:
				// status code of 0 - means transaction successful
				$NextFormMode = "RESULTS";
				$Message = $tdsarThreeDSecureAuthenticationResult->getMessage();
				$TransactionSuccessful = true;
				PaymentFormHelper::reportTransactionResults($CrossReference, $tdsarThreeDSecureAuthenticationResult->getStatusCode(), $tdsarThreeDSecureAuthenticationResult->getMessage(), $todTransactionOutputData->getCrossReference());
				break;
			case 5:
				// status code of 5 - means transaction declined
				$NextFormMode = "RESULTS";
				$Message = $tdsarThreeDSecureAuthenticationResult->getMessage();
				$TransactionSuccessful = false;
				PaymentFormHelper::reportTransactionResults($CrossReference, $tdsarThreeDSecureAuthenticationResult->getStatusCode(), $tdsarThreeDSecureAuthenticationResult->getMessage(), $todTransactionOutputData->getCrossReference());
				break;
			case 20:
				// status code of 20 - means duplicate transaction 
				$NextFormMode = "RESULTS";
				$Message = $tdsarThreeDSecureAuthenticationResult->getMessage();
				if ($tdsarThreeDSecureAuthenticationResult->getPreviousTransactionResult()->getStatusCode()->getValue() == 0)
				{
					$TransactionSuccessful = true;
				}
				else
				{
					$TransactionSuccessful = false;
			   	}
				$PreviousTransactionMessage = $tdsarThreeDSecureAuthenticationResult->getPreviousTransactionResult()->getMessage();
				$DuplicateTransaction = true;
				PaymentFormHelper::reportTransactionResults($CrossReference, $tdsarThreeDSecureAuthenticationResult->getPreviousTransactionResult()->getStatusCode()->getValue(), $PreviousTransactionMessage, $todTransactionOutputData->getCrossReference());
				break;
			case 30:
				// status code of 30 - means an error occurred 
				$NextFormMode = "RESULTS";
				$Message = $tdsarThreeDSecureAuthenticationResult->getMessage();
				if ($tdsarThreeDSecureAuthenticationResult->getErrorMessages()->getCount() > 0)
				{
					$Message = $Message."<br /><ul>";

					for ($LoopIndex = 0; $LoopIndex < $tdsarThreeDSecureAuthenticationResult->getErrorMessages()->getCount(); $LoopIndex++)
					{
						$Message = $Message."<li>".$tdsarThreeDSecureAuthenticationResult->getErrorMessages()->getAt($LoopIndex)."</li>";
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
				PaymentFormHelper::reportTransactionResults($CrossReference, $tdsarThreeDSecureAuthenticationResult->getStatusCode(), $tdsarThreeDSecureAuthenticationResult->getMessage(), $szResponseCrossReference);
				break;
			default:
				// unhandled status code  
				$NextFormMode = "RESULTS";
				$Message=$tdsarThreeDSecureAuthenticationResult->getMessage();
				$TransactionSuccessful = false;
				if ($todTransactionOutputData == null)
				{
					$szResponseCrossReference = "";
				}
				else
				{
					$szResponseCrossReference = $todTransactionOutputData->getCrossReference();
				}
				PaymentFormHelper::reportTransactionResults($CrossReference, $tdsarThreeDSecureAuthenticationResult->getStatusCode(), $tdsarThreeDSecureAuthenticationResult->getMessage(), $szResponseCrossReference);
				break;
		}
	}
?>