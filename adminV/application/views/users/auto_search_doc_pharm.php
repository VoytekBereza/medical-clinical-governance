<?php if(!empty($list_default_users_search)){ ?>

	<ul id="email-list" class="list-group scroll_auto_suggesion" style="z-index: 999; position: absolute; width: 90%; overflow-y: scroll; min-height:50px; max-height:110px;">

		<?php foreach($list_default_users_search as $each): ?>
    
        <li class="list-group-item text-primary" onClick="select_emails('<?php echo $each["email_address"]; ?>','<?php echo $each['user_type'];?>')">
        <strong style="cursor:pointer;"> <?php echo $each["email_address"]; ?> </strong> </li>		
    
        <?php endforeach; // foreach($pharmacies_surgeries as $pharmacy_surgery) ?>
    
       </ul>
    
       <?php } else { ?>
    
        <!-- <div class="panel panel-default panel-body text-danger">No record found.</div> -->

   <?php } // else - if(!empty($pharmacies_surgeries)) ?>   
                          
              