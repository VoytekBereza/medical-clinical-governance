<?php if($raf){ ?>

	<h3 class="text-primary text-center">Patient "<?php echo ($medicine['medicine_name'] != '') ? $medicine['medicine_name'] : '' ; ?>" Risk Assesment Form. </h3>
	<br />

	<?php foreach($raf as $each){ ?>
			
		<div class="alert alert-info">

			<div class="row">
				<div class="col-md-10">
					<?php echo filter_string( $each['med_question'] ); ?>
				</div>
				<br />

				<div class="col-md-2">
					<?php echo ($each['answer'] == 'N') ? '<button class="btn btn-xs btn-danger btn-block pull-right"> No </button>' : '<button class="btn btn-xs btn-success btn-block pull-right"> Yes </button>' ; ?>
				</div>

			</div> <!-- /.row -->
			<br />

		</div>
			
	<?php } // foreach($raf as $each) ?>

<?php } // if($raf) ?>