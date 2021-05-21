<?php
	require_once ("../ThePaymentGateway/PaymentSystem.php");

	include ("../Config.php");

	$Amount = "1000";
	$CurrencyISOCode = "826";
	$OrderID = "Order-12345";
	$OrderDescription = "A Test Order";
//>>> This will need to be changed to a valid cross reference for this script to work
	$CrossReference = "CHANGE_ME_TO_VALID_CROSSREFERENCE";
//<<<

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

	$crtCrossReferenceTransaction = new CrossReferenceTransaction($rgeplRequestGatewayEntryPointList);

	$crtCrossReferenceTransaction->getMerchantAuthentication()->setMerchantID($MerchantID);
	$crtCrossReferenceTransaction->getMerchantAuthentication()->setPassword($Password);

	$crtCrossReferenceTransaction->getTransactionDetails()->getMessageDetails()->setTransactionType("REFUND");
	$crtCrossReferenceTransaction->getTransactionDetails()->getMessageDetails()->setCrossReference($CrossReference);

	$crtCrossReferenceTransaction->getTransactionDetails()->getAmount()->setValue($Amount);
	$crtCrossReferenceTransaction->getTransactionDetails()->getCurrencyCode()->setValue($CurrencyISOCode);

	$crtCrossReferenceTransaction->getTransactionDetails()->setOrderID($OrderID);
	$crtCrossReferenceTransaction->getTransactionDetails()->setOrderDescription($OrderDescription);

	$boTransactionProcessed = $crtCrossReferenceTransaction->processTransaction($crtrCrossReferenceTransactionResult, $todTransactionOutputData);

	if ($boTransactionProcessed == false)
	{
		// could not communicate with the payment gateway 
		echo("Couldn't communicate with payment gateway");
	}
	else
	{
		echo("StatusCode: ".$crtrCrossReferenceTransactionResult->getStatusCode()."<br />");

		switch ($crtrCrossReferenceTransactionResult->getStatusCode())
		{
			case 0:
				// status code of 0 - means transaction successful 
				echo("Message: ".$crtrCrossReferenceTransactionResult->getMessage()."<br />");
				echo("CrossReference: ".$todTransactionOutputData->getCrossReference()."<br />");
				break;
			case 5:
				// status code of 5 - means transaction declined 
				echo("Message: ".$crtrCrossReferenceTransactionResult->getMessage()."<br />");
				echo("CrossReference: ".$todTransactionOutputData->getCrossReference()."<br />");
				break;
			case 20:
				// status code of 20 - means duplicate transaction 
				echo("Message: ".$crtrCrossReferenceTransactionResult->getMessage()."<br />");
				echo("PreviousTransactionStatusCode: ".$crtrCrossReferenceTransactionResult->getPreviousTransactionResult()->getStatusCode()->getValue()."<br />");
				echo("PreviousTransactionMessage: ".$crtrCrossReferenceTransactionResult->getPreviousTransactionResult()->getMessage()."<br />");
				echo("CrossReference: ".$todTransactionOutputData->getCrossReference()."<br />");
				break;
			case 30:
				// status code of 30 - means an error occurred 
				echo("Message: ".$crtrCrossReferenceTransactionResult->getMessage()."<br />");
				if ($crtrCrossReferenceTransactionResult->getErrorMessages()->getCount() > 0)
				{
					$ErrorMessages = "ErrorMessages:<ul>";

					for ($LoopIndex = 0; $LoopIndex < $crtrCrossReferenceTransactionResult->getErrorMessages()->getCount(); $LoopIndex++)
					{
						$ErrorMessages = $ErrorMessages."<li>".$crtrCrossReferenceTransactionResult->getErrorMessages()->getAt($LoopIndex)."</li>";
					}
					$ErrorMessages = $ErrorMessages."</ul>";
					echo($ErrorMessages."<br />");
				}
				break;
			default:
				// unhandled status code  
				echo("Message: ".$crtrCrossReferenceTransactionResult->getMessage()."<br />");
				break;
		}
	}
?>