<?php
	require_once ("../ThePaymentGateway/PaymentSystem.php");

	include ("../Config.php");

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

	$gctGetCardType = new GetCardType($rgeplRequestGatewayEntryPointList);
	
	$gctGetCardType->getMerchantAuthentication()->setMerchantID($MerchantID);
	$gctGetCardType->getMerchantAuthentication()->setPassword($Password);

	$gctGetCardType->setCardNumber("4976000000003436");

	$boTransactionProcessed = $gctGetCardType->processTransaction($gctrGetCardTypeResult, $gctGetCardTypeOutputMessage);

	if ($boTransactionProcessed == false)
	{
		// could not communicate with the payment gateway 
		echo("Couldn't communicate with payment gateway");
	}
	else
	{
		echo("StatusCode: ".$gctrGetCardTypeResult->getStatusCode()."<br />");

		switch ($gctrGetCardTypeResult->getStatusCode())
		{
			case 0:
				// status code of 0 - means transaction successful 
				echo("Message: ".$gctrGetCardTypeResult->getMessage()."<br />");
				if ($gctGetCardTypeOutputMessage->getCardTypeData() != null)
				{
					echo("CardType: ".$gctGetCardTypeOutputMessage->getCardTypeData()->getCardType()."<br />");
					if ($gctGetCardTypeOutputMessage->getCardTypeData()->getIssuer() != null)
					{
						echo("Issuer: ".$gctGetCardTypeOutputMessage->getCardTypeData()->getIssuer()->getValue()."<br />");
						echo("IssuerCountry: ".$gctGetCardTypeOutputMessage->getCardTypeData()->getIssuer()->getISOCode()."<br />");
					}
					if ($gctGetCardTypeOutputMessage->getCardTypeData()->getLuhnCheckRequired() != null)
					{
						echo("LuhnCheckRequired: ".$gctGetCardTypeOutputMessage->getCardTypeData()->getLuhnCheckRequired()->getValue()."<br />");
					}
					echo("StartDateStatus: ".$gctGetCardTypeOutputMessage->getCardTypeData()->getStartDateStatus()."<br />");
					echo("IssueNumberStatus: ".$gctGetCardTypeOutputMessage->getCardTypeData()->getIssueNumberStatus()."<br />");
				}
				break;
			case 5:
				// invalid card type
				echo("Message: ".$gctrGetCardTypeResult->getMessage()."<br />");
				break;
			case 30:
				// status code of 30 - means an error occurred 
				echo("Message: ".$gctrGetCardTypeResult->getMessage()."<br />");
				if ($crtrCrossReferenceTransactionResult->getErrorMessages()->getCount() > 0)
				{
					$ErrorMessages = "ErrorMessages:<ul>";

					for ($LoopIndex = 0; $LoopIndex < $gctrGetCardTypeResult->getErrorMessages()->getCount(); $LoopIndex++)
					{
						$ErrorMessages = $ErrorMessages."<li>".$gctrGetCardTypeResult->getErrorMessages()->getAt($LoopIndex)."</li>";
					}
					$ErrorMessages = $ErrorMessages."</ul>";
					echo($ErrorMessages."<br />");
				}
				break;
			default:
				// unhandled status code  
				echo("Message: ".$gctrGetCardTypeResult->getMessage()."<br />");
				break;
		}
	}
?>