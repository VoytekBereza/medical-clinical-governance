<h3 class="modal-title"> <?php echo ucwords(filter_string($user_data['user_full_name'])); ?> </h3>
<hr />
<p>
    <strong> Email: </strong> <?php echo filter_string($user_data['email_address']); ?>
    <br />

    <strong> Contact no: </strong> <?php echo filter_string($user_data['mobile_no']); ?>
    <br />

    <strong> Role: </strong> <?php if($is_si) { echo 'Superintendent, '; }elseif($is_manager){ echo 'Manager, '; }?> <?php echo filter_string($user_data['user_type_name']); ?>
    <br />

</p>

