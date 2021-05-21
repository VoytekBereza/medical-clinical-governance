<?php if(!empty($list_default_users_search)){  ?>

<ul id="email-list" class="list-group" style="z-index: 999; position: absolute; width: 93%; overflow-y: auto; min-height:50px; max-height:110px;">

<?php 	
		$i = 1;
		foreach($list_default_users_search as $each){
			
			$email_address = filter_string($each["email_address"]);
			$user_type = filter_string($each["user_type"]);
			$first_name = filter_string($each["first_name"]);
			$last_name = filter_string($each["last_name"]);
				
			if($i == 1 && $user_type =='1'){
				$class = 'selected3';
				$i++;
			} else if($i == 1 && $user_type =='2'){ 
			    $class = 'selected2';
				$i++;
			} else {
				$class = '';
			}			 
			 
			$full_name = $first_name." ".$last_name; 
			 
			 if($email_address!=""){
			 ?>
			     <li class="list-group-item text-primary<?php echo ' '.$class; ?>" style="padding-top:5px;" onClick="select_emails2('<?php echo $full_name;?>','<?php echo $user_type ;?>','<?php echo $email_address;?>')"><strong style="cursor:pointer;"><?php echo $full_name;?></strong></li>
		 <?php  
		      }
		} // foreach($pharmacies_surgeries as $pharmacy_surgery) ?>

</ul>

<?php } else { ?>
<?php } // else - if(!empty($pharmacies_surgeries)) ?>   
                          
              <script type="text/javascript" src="http://localhost:8000/projects/voyager-med/assets/js/jquery.autocomplete.js">