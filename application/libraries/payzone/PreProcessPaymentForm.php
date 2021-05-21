<?php
	require_once ("PaymentFormHelper.php");
	include ("Config.php");

	foreach ($_POST as $field => $value) 
	{
		$$field = $value;
	}

	$ResetFormVariables = false;
	$SuppressFormDisplay = false;
	$BodyAttributes = "";
	$FormAttributes = "";
	$FormAction = "PaymentForm.php";

	// Is this a postback? 
	if (!isset($FormMode))
	{
		// need to check the integrity of the variables
		// coming from the shopping cart
		if (!isset($ShoppingCartAmount) &&
			!isset($ShoppingCartCurrencyShort) &&
			!isset($ShoppingCartOrderID) &&
			!isset($ShoppingCartOrderDescription) &&
			!isset($ShoppingCartHashDigest))
		{
			$NextFormMode = "PAYMENT_FORM";
			$Message = "No input variables passed";
			$SuppressFormDisplay = true;
		}
		else
		{
			$aVariables["Amount"] = "";
			$aVariables["CurrencyShort"] = "";
			$aVariables["OrderID"] = "";
			$aVariables["OrderDescription"] = "";

			if (isset($ShoppingCartAmount))
			{
				$aVariables["Amount"] = $ShoppingCartAmount;
			}
			if (isset($ShoppingCartCurrencyShort))
			{
				$aVariables["CurrencyShort"] = $ShoppingCartCurrencyShort;
			}
			if (isset($ShoppingCartOrderID))
			{
				$aVariables["OrderID"] = $ShoppingCartOrderID;
			}
			if (isset($ShoppingCartOrderDescription))
			{
				$aVariables["OrderDescription"] = $ShoppingCartOrderDescription;
			}
			if (!isset($ShoppingCartHashDigest))
			{
				$ShoppingCartHashDigest = "";
			}

			if (PaymentFormHelper::checkIntegrityOfIncomingVariables("SHOPPING_CART_CHECKOUT", $aVariables, $ShoppingCartHashDigest, $SecretKey))
			{
				$ResetFormVariables = true;
				$NextFormMode = "PAYMENT_FORM";	
				$Amount = $ShoppingCartAmount;
				$CurrencyShort = $ShoppingCartCurrencyShort;
				$OrderID = $ShoppingCartOrderID;
				$OrderDescription = $ShoppingCartOrderDescription;
			}
			else
			{
				$NextFormMode = "PAYMENT_FORM";
				$Message = "Variable tampering detected";
				$SuppressFormDisplay = true;
			}
		}
	}
	else
	{

		// do we try to process the payment? 
		switch ($FormMode)
		{
			case "PAYMENT_FORM":
				// have just come from a payment form - try to process the payment
				// need to check the integrity of the variables coming back
				// from the payment form
				$aVariables["Amount"] = "";
				$aVariables["CurrencyShort"] = "";
				$aVariables["OrderID"] = "";
				$aVariables["OrderDescription"] = "";

				if (isset($Amount))
				{
					$aVariables["Amount"] = $Amount;
				}
				if (isset($CurrencyShort))
				{
					$aVariables["CurrencyShort"] = $CurrencyShort;
				}
				if (isset($OrderID))
				{
					$aVariables["OrderID"] = $OrderID;
				}
				if (isset($OrderDescription))
				{
					$aVariables["OrderDescription"] = $OrderDescription;
				}
				if (!isset($HashDigest))
				{
					$HashDigest = "";
				}

				if (PaymentFormHelper::checkIntegrityOfIncomingVariables("PAYMENT_FORM_POSTBACK", $aVariables, $HashDigest, $SecretKey))
				{
					include ("ProcessPayment.php");
				}
				else
				{
					$NextFormMode = "PAYMENT_FORM";
					$Message = "Variable tampering detected";
					$SuppressFormDisplay = true;
				}
				break;
			case "RESULTS":
				$ResetFormVariables = true;
				$NextFormMode = "PAYMENT_FORM";	
				break;
			case "THREE_D_SECURE":
				// have just come from a payment form - try to process the payment
				// need to check the integrity of the variables coming from the
				// 3DS form
				$aVariables["PaRES"] = "";
				$aVariables["CrossReference"] = "";

				if (isset($PaRES))
				{
					$aVariables["PaRES"] = $PaRES;
				}
				if (isset($CrossReference))
				{
					$aVariables["CrossReference"] = $CrossReference;
				}
				if (!isset($ShoppingCartHashDigest))
				{
					$ShoppingCartHashDigest = "";
				}
				if (PaymentFormHelper::checkIntegrityOfIncomingVariables("THREE_D_SECURE", $aVariables, $ShoppingCartHashDigest, $SecretKey))
				{
					include ("ThreeDSecureAuthentication.php");
				}
				else
				{
					$NextFormMode = "PAYMENT_FORM";
					$Message = "Variable tampering detected";
					$SuppressFormDisplay = true;
				}
				break;
		}
	}

	// Reset the form variables if required 
	if ($ResetFormVariables == true)
	{
		$CardName = "";
		$CardNumber = "";
		$ExpiryDateMonth = "";
		$ExpiryDateYear = "";
		$StartDateMonth = "";
		$StartDateYear = "";
		$IssueNumber = "";
		$CV2 = "";
		$Address1 = "";
		$Address2 = "";
		$Address3 = "";
		$Address4 = "";
		$City = "";
		$State = "";
		$PostCode = "";
		$CountryShort = "";
	}
?>