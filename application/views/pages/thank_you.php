<!-- Display Success Message Contents -->
<?php if($this->session->flashdata('ok_message')){ ?>
	<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php }//if($this->session->flashdata('ok_message'))?>
