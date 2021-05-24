<?php // echo '<pre>'; print_r($purchases['training']); exit; ?>
<h4 class="text-primary text-center"> Assigned Training </h4>
<form action="<?php echo base_url(); ?>users/assign-training" method="post">
	<table id="example" class="table table-hover table-bordered table-responsive bg-default text-primary" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
		
		<thead>
			<tr class="headings">
				<th> Select All <input onClick="check_all_assigned(this);" type="checkbox" /></th>
				<th class="text-left"> Name </th>
			</tr>
		</thead>
		<tbody>
<?php 
			if($trainings){
				foreach($trainings as $each){ // echo '<pre>'; print_r($each);
				
					// if in purchase list
					$index_key = array_search($each['id'], array_column($purchases['training'], 'product_id'));
					if(strlen($index_key) > 0){

						$empty = 1;
	?>
						<tr>
							<td> <input type="checkbox" class="checkbox_purchased" name="trainings[]" value="<?php echo $each['id']; ?>" /> </td>
							<td> <?php echo $each['course_name']; ?> </td>
						</tr>
		<?php 
					} // if(strlen($index_key) > 0)

				} // foreach($trainings as $each)

				if($empty != 1){ ?>

						<tr>
							<td colspan="2"> No records found </td>
						</tr>

				<?php }

			} else { ?>

				<tr>
					<td colspan="2"> No records found </td>
				</tr>

			<?php } // if($trainings) ?>

		</tbody>
	</table>

	<?php if($empty == 1){ ?>
		<input type="hidden" readonly="readonly" name="user_id" value="<?php echo $user_id; ?>" />
		<input type="hidden" readonly="readonly" name="action" value="unassign_training" />
		<button type="submit" class="btn btn-sm btn-danger pull-right"> Unassign </button>
	<?php } // if($empty != 1) ?>
</form>

<h4 class="text-danger text-center"> Not Assigned Training </h4>
<form action="<?php echo base_url(); ?>users/assign-training" method="post">

	<table id="example" class="table table-hover table-bordered table-responsive bg-default text-danger" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
		
		<thead>
			<tr class="headings">
				<th>  Select All  <input onClick="check_all_unassigned(this);" type="checkbox" /></th>
				<th class="text-left"> Name </th>
			</tr>
		</thead>
		<tbody>
<?php 
			if($trainings){
				$empty = 0;
				foreach($trainings as $each){ // echo '<pre>'; print_r($each);
				
					// if in purchase list
					$index_key = array_search($each['id'], array_column($purchases['training'], 'product_id'));
					
					if(strlen($index_key) <= 0){

						$empty = 1;
	?>
						<tr>
							<td> <input type="checkbox" class="checkbox_non_purchased" name="trainings[]" value="<?php echo $each['id']; ?>" /> </td>
							<td> <?php echo $each['course_name']; ?> </td>
						</tr>
		<?php 
					} // if(strlen($index_key) > 0)

				} // foreach($trainings as $each)

				if($empty != 1){ ?>

						<tr>
							<td colspan="2"> No records found </td>
						</tr>
				<?php }

			} else { ?>

				<tr>
					<td colspan="2"> No records found </td>
				</tr>

			<?php } // if($purchases) ?>

		</tbody>
	</table>
	<?php if($empty == 1){ ?>
		<input type="hidden" readonly="readonly" name="user_id" value="<?php echo $user_id; ?>" />
		<input type="hidden" readonly="readonly" name="action" value="assign_training" />
		<button type="submit" class="btn btn-sm btn-success pull-right"> Assign </button>
	<?php } // if($empty != 1) ?>

</form>