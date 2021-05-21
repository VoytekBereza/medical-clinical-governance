<?php 
if(!empty($list_auto_search_emails)){ ?>

<ul id="email-list" class="list-group" style="z-index: 999; position: absolute; <?php if($type=='staff'){?> width: 40%;<?php } else{?>  width: 55%;<?php }?>overflow-y: scroll; min-height:50px; max-height:110px;">

<?php foreach($list_auto_search_emails as $each): ?>

	<li class="list-group-item text-primary" onClick="<?php if($type=='staff'){?>select_emails<?php } else {?>select_emails_manager<?php }?>('<?php echo $each["email_address"]; ?>','<?php echo $list_hidden;?>');"> <strong style="cursor:pointer;"> <?php echo $each["email_address"]; ?></strong> </li>		

<?php endforeach; // foreach($pharmacies_surgeries as $pharmacy_surgery) ?>

</ul>

<?php } else { ?>

	<!-- <div class="panel panel-default panel-body text-danger">No record found.</div> -->

<?php } // else - if(!empty($pharmacies_surgeries)) ?>
