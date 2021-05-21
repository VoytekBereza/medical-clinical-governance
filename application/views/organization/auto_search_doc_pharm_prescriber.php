<?php if(!empty($list_default_users_prescriber_search)){  ?>

<ul id="email-list" class="list-group" style="z-index: 999; position: absolute; width: 93%; overflow-y: auto; min-height:50px; max-height:110px;">

<?php 	
		$i = 1;
		foreach($list_default_users_prescriber_search as $each){
						
			$email_address = filter_string($each["email_address"]);
			$first_name = filter_string($each["first_name"]);
			$last_name = filter_string($each["last_name"]);
			$full_name = $first_name." ".$last_name; 

			if($i == 1){
				$class = 'selected';
				$i++;
			} else {
				$class = '';
			}
			 
			 if($email_address!=""){
			 ?>
			     <li class="list-group-item text-primary<?php echo ' '.$class; ?>" style="padding-top:5px;" onClick="select_email_prescriber('<?php echo $full_name;?>','<?php echo $email_address;?>')"><strong style="cursor:pointer;"><?php echo $full_name;?></strong></li>
		 <?php  
		      }
		} // foreach($list_default_users_prescriber_search as $each) ?>

</ul>

<?php } else { ?>
<?php } // else - if(!empty($list_default_users_prescriber_search)) ?>   
                          
              