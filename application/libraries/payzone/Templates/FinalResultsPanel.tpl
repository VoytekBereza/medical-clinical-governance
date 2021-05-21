<input name="FormMode" type="hidden" value="<?php echo $NextFormMode ?>" />

<div class="<?php echo $MessageClass ?>">
	<div class="TransactionResultsItem">
		<div class="TransactionResultsLabel">Payment Processor Response:</div>
		<div class="TransactionResultsText">
			<?php echo $Message ?>
		</div>
	</div>

<?php if ($DuplicateTransaction == true) { ?>
	<div style="color:#000;margin-top:10px">
		A duplicate transaction means that a transaction with these details
		has already been processed by the payment provider. The details of
		the original transaction are given below
	</div>
	<div class="TransactionResultsItem" style="margin-top:10px">
		<div class="TransactionResultsLabel">
			Previous Transaction Response:
		</div>
		<div class="TransactionResultsText">
			<?php echo $PreviousTransactionMessage ?>
		</div>
	</div>
<?php } ?>
	<div style="margin-top:10px">
		<a href="StartHere.php">Process Another</a>
	</div>
</div>
