<?php 

    if(is_array($usertype)) {
?>
		<h3 class="modal-title"><?php echo filter_string($usertype['user_type']) ?></h3>
		<hr />
<?php
        echo filter_string($usertype['description']); 
    } else { 
        if($invitation_type){
            echo ($invitation_type == 'SI') ? '<h3 class="modal-title">Superintendent</h3><hr />' : '<h3 class="modal-title">Manager</h3><hr />' ;
        }
        echo filter_string($usertype); 
    } ?>