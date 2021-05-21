<input name="FormMode" type="" value="<?php echo $NextFormMode ?>" />
<input name="HashDigest" type="" value="<?php echo $szHashDigest ?>" />

<div class="ContentRight">
    <div class="ContentHeader">
        Order Details
    </div>
    <div class="FormItem">
        <div class="FormLabel">Amount:</div>
        <div class="FormInputTextOnly"><?php echo $szDisplayAmount ?></div>
		<input type="hidden" name="Amount" value="<?php echo $Amount ?>" />
		<input type="hidden" name="CurrencyShort" value="<?php echo $CurrencyShort ?>" />
	</div>
	<div class="FormItem">
		<div class="FormLabel">Order Description:</div>
		<div class="FormInputTextOnly"><?php echo $OrderDescription ?></div>
		<input type="hidden" name="OrderID" value="<?php echo $OrderID ?>" />
		<input type="hidden" name="OrderDescription" value="<?php echo $OrderDescription ?>" />
	</div>
</div>
<div class="ContentRight">
    <div class="ContentHeader">
        Card Details
    </div>
    <div class="FormItem">
        <div class="FormLabel">Name On Card:</div>
        <div class="FormInput">
            <input name="CardName" value="<?php echo $CardName ?>" class="InputTextField" MaxLength="50" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">Card Number:</div>
        <div class="FormInput">            
            <input name="CardNumber" value="<?php echo $CardNumber ?>" class="InputTextField" MaxLength="20" />
        </div>
    </div>
	<div class="FormItem">
		<div class="FormLabel">
			Expiry Date:
		</div>
		<div class="FormInput">
			<select name="ExpiryDateMonth" style="width:45px">
				<option></option>
				<?php echo $lilExpiryDateMonthList->toString() ?>
			</select>
			/
			<select name="ExpiryDateYear" style="width:55px">
				<option></option>
				<?php echo $lilExpiryDateYearList->toString() ?>
			</select>
		</div>
	</div>
	<div class="FormItem">
	    <div class="FormLabel">
	        Start Date:
	    </div>
	    <div class="FormInput">
	        <select name="StartDateMonth" style="width:45px">
				<option></option>
				<?php echo $lilStartDateMonthList->toString() ?>
			</select>
			/
			<select name="StartDateYear" style="width:55px">
				<option></option>
				<?php echo $lilStartDateYearList->toString() ?>
            </select>
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">Issue Number:</div>
        <div class="FormInput">
            <input name="IssueNumber" value="<?php echo $IssueNumber ?>" class="InputTextField" MaxLength="2" style="width:50px" />
        </div>
        <div class="FormValnameationText"></div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">CV2:</div>
        <div class="FormInput">
            <input name="CV2" value="<?php echo $CV2 ?>" class="InputTextField" MaxLength="4" style="width:50px" />
        </div>
    </div>
</div>

<div class="ContentRight">
    <div class="ContentHeader">
        Customer Details
    </div>
    <div class="FormItem">
        <div class="FormLabel">Address:</div>
        <div class="FormInput">
            <input name="Address1" value="<?php echo $Address1 ?>" class="InputTextField" MaxLength="100" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">&nbsp</div>
        <div class="FormInput">
            <input name="Address2" value="<?php echo $Address2 ?>" class="InputTextField" MaxLength="50" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">&nbsp</div>
        <div class="FormInput">
            <input name="Address3" value="<?php echo $Address3 ?>" class="InputTextField" MaxLength="50" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">&nbsp</div>
        <div class="FormInput">
            <input name="Address4" value="<?php echo $Address4 ?>" class="InputTextField" MaxLength="50" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">City:</div>
        <div class="FormInput">
            <input name="City" value="<?php echo $City ?>" class="InputTextField" MaxLength="50" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">State:</div>
        <div class="FormInput">
            <input name="State" value="<?php echo $State ?>" class="InputTextField" MaxLength="50" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">Post Code:</div>
        <div class="FormInput">
            <input name="PostCode" value="<?php echo $PostCode ?>" class="InputTextField" MaxLength="50" />
        </div>
    </div>
    <div class="FormItem">
        <div class="FormLabel">
            Country:
        </div>
        <div class="FormInput">
            <select name="CountryShort" style="width:200px">
				<option value="-1"></option>
				<?php echo $lilISOCountryList->toString() ?>
			</select>
		</div>
	</div>
	<div class="FormItem">
		<div class="FormSubmit">
			<input type="submit" value="Submit For Processing" />
	    </div>
   	</div>
</div>
