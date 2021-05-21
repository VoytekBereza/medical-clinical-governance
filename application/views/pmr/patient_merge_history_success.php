<!-- Display Success Message Contents -->
<?php if($success == 1){ ?>

	<?php echo filter_string($merge_error_cms['page_description']); ?>
	<br />
	
	<div class="row">
		<div class="col-md-12 text-right">
			<a href="<?php echo base_url(); ?>pmr/merge-history-send-email/<?php echo $patient_id; ?>/<?php echo $pharmacy_surgery_id; ?>/resend-email" class="btn btn-sm btn-success"> Resend </a>
			<a href="<?php echo base_url(); ?>pmr/merge-history-send-email/<?php echo $patient_id; ?>/<?php echo $pharmacy_surgery_id; ?>/refresh" class="btn btn-sm btn-info"> Refresh </a>
			<a href="<?php echo base_url(); ?>pmr" class="btn btn-sm btn-danger"> Cancel </a>
		</div>
	</div>

<?php } else { ?>

	<h3>Email was not sent. Try again later!</h3>	

<?php } // if($success == 1) ?>