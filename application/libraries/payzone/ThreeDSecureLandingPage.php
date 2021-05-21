<?php
	require_once ("PaymentFormHelper.php");
	include ("Config.php");

	$BodyAttributes = "";
	$ErrorOccurred = false;
	$Message = "";
	$MD = "";
	$PaRES = "";
	$FormAction = "";
	$FormAttributes = "";
	$Width = 500;
	$ShoppingCartHashDigest = "";

	if (isset($_POST['MD']) == false || 
	    isset($_POST['PaRes']) == false)
	{
		$Message = "There were errors collecting the responses back from the ACS";
		$ErrorOccurred = true;
	}
	else
	{
		$BodyAttributes = " onload=\"document.Form.submit();\"";
		$MD = $_POST['MD'];
		$PaRES = $_POST['PaRes'];
		$FormAction = "PaymentForm.php";
		$FormAttributes = " target=\"_parent\"";
		$ShoppingCartHashDigest = PaymentFormHelper::calculateHashDigest(PaymentFormHelper::generateStringToHash2($PaRES, $MD, $SecretKey));
	}

	include ("Templates/FormHeader.tpl");

	if ($ErrorOccurred == true)
	{
		include ("Templates/ProcessingErrorResultsPanel.tpl");
	}
	else
	{
		include ("Templates/3DSLandingForm.tpl");
	}
	include ("Templates/FormFooter.tpl");
?>