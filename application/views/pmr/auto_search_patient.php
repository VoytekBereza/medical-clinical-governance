<?php
	if(!empty($list_search_patient)){
		$ul_style = 'z-index: 999; position: absolute; width: 96.5%;  min-height:50px; max-height:200px; overflow-y: auto;';
	} else {
		$ul_style = 'z-index: 999; position: absolute; width: 96.5%; overflow-y: auto;';
	} // if($list_search_patient != '')
?>
		<ul id="email-list" class="list-group" style="<?php echo $ul_style; ?>">

	<?php if(!empty($list_search_patient)){
			$i = 1;
			foreach($list_search_patient as $each){
				 
				$email_address = filter_string($each["email_address"]);
				$first_name    = filter_string($each["first_name"]);
				$last_name     = filter_string($each["last_name"]);
				$postcode      = filter_string($each["postcode"]);

				if($i == 1){
					$class = 'selected';
					$i++;
				} else {
					$class = '';
				}

	?>
				<li class="list-group-item text-primary<?php echo ' '.$class; ?>" style="padding-top:5px;" onClick="select_patient(<?php echo $each['id'];?>)"><strong style="cursor:pointer;"><a href="#"><?php echo ucwords(filter_string($each['patient_record'])); ?></a></strong></li>
	<?php  
			} // foreach($list_search_patient as $each) ?>

			<li class="list-group-item text-primary" style="padding-top:5px;" onClick="add_new_patient_trigger();"" > <a id="add-new-patient" href="<?php echo base_url();?>organization/pmr/add-edit-patient" style="color:#555555;"> <strong> Add New Patient </strong> </a></strong> </li>

	<?php } else { ?>

		<li class="list-group-item text-primary" id="add-new-patient-li" style="padding-top:5px;"> <a id="add-new-patient" href="<?php echo base_url();?>organization/pmr/add-edit-patient" style="color:#555555;"> <strong> Add New Patient </strong> </a></strong> </li>
		
		
		
	<?php }// if(!empty($list_search_patient)) 
	?>

</ul>