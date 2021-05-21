
<h1>Thank you!</h1>
<p> Vaccine/ PGD successfully added into the system, an email is sent to the patient email address with the consent agreement link.</p>
<p>
Please ask patient to check their registered email to make an online consent agreement. If for some reason email is not received, click the “Print Form” to immediately print the consent form. </p>

<br /> <hr />
<div align="right" style="display: none">
	
	<!-- Hidden field containing CONSENT FORM -->
	<div id="consent_form"> 
	<?php 
		$search_arr = array('[PATIENT_NAME]','[CONSENT_DATE]');
		$replace_arr = array(ucwords(filter_string($patient_details['first_name']).' '.filter_string($patient_details['last_name'])), kod_date_format(date('Y-m-d')));
		
		echo str_replace($search_arr, $replace_arr, filter_string($consent_form_data['email_body'])); ?> 
   </div>

</div>
	<button type="button" class="btn btn-warning" onClick="print_consent_form(this);" > Print Form </button>
	<a href="<?php echo base_url('organization/pmr'); ?>" type="button" class="btn btn-success" > Finish </a>
