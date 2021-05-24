<ul id="email-list" class="list-group" style="z-index: 999; position: absolute; width: 90%;  min-height:50px; max-height:110px; overflow-y: scroll;">

	<?php if(!empty($list_search_patient)){
			$i = 1;
			foreach($list_search_patient as $each){
				 
				$email_address = filter_string($each["email_address"]);
				$full_name    = filter_string($each["first_name"]).' '.filter_string($each["last_name"]);
				$postcode      = filter_string($each["postcode"]);

				if($i == 1){
					$class = 'selected';
					$i++;
				} else {
					$class = '';
				}

	?>
				<li class="list-group-item text-primary<?php echo ' '.$class; ?>" style="padding-top:5px;" onClick="select_patient('<?php echo $each['id'];?>','<?php echo $full_name;?>','<?php echo $email_address;?>')"><strong style="cursor:pointer;"><a href="#"><?php echo $each['patient_record'];?></a></strong></li>
	<?php  
			} // foreach($list_search_patient as $each) ?>

			<!-- <li class="list-group-item text-primary" style="padding-top:5px; background-color:#F0F0F0;"><strong style="cursor:pointer;"><a href="< ?php echo base_url();?>organization/add-edit-patient" style="color:#555555;">Add new patient</a></strong></li> -->
			
	<?php } else { ?>

		
	<?php }// if(!empty($list_search_patient)) 
	?>

</ul>