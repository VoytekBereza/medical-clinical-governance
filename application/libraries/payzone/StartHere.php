<?php
	require_once ("PaymentFormHelper.php");
	include ("Config.php");
	include ("ISOCurrencies.php");

	$Width = 800;
	$BodyAttributes = "";
	$FormAttributes = "";
	$FormAction = "PaymentForm.php";
    
	include ("Templates/FormHeader.tpl");

	$Amount = "2592";
	$CurrencyShort = "GBP";
	$OrderID = "Order-1234";
	$OrderDescription = "A Test Order";

	if ($iclISOCurrencyList->getISOCurrency($CurrencyShort, $icISOCurrency))
	{
		echo ($Amount / 100).'<br>';
		
		echo $DisplayAmount = $icISOCurrency->getAmountCurrencyString($Amount, false);
		exit;
	}

	$HashDigest = PaymentFormHelper::calculateHashDigest(PaymentFormHelper::generateStringToHash($Amount,
                        $CurrencyShort,
                        $OrderID,
                        $OrderDescription,
                        $SecretKey));

	include ("Templates/StartHereForm.tpl");
	include ("Templates/FormFooter.tpl");
?>