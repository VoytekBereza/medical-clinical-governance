<?php 
if(filter_string($page_data['url_slug']) != 'travel-core-2'){
?>
	<h3><?php echo filter_string($page_data['page_title'])?></h3><hr />
<?php }?>
<br />
<!-- Display Success Message Contents -->
<?php if($this->session->flashdata('ok_message')){ ?>
	<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php }//if($this->session->flashdata('ok_message'))?>

<!-- Display Page Contents -->
<?php 

echo filter_string($page_data['page_description']); 
?>
