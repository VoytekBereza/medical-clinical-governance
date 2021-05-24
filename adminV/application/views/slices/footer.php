<?php
if($this->uri->segment(1) == 'pgd' || $this->uri->segment(2) == 'videos-listing' || $this->uri->segment(2) == 'documents-listing')
	$style = 'style="margin: 0 0 0 17%;"';
else
	$style = '';
?>
<footer <?php echo $style; ?>>
  <div class="">
    <p class="pull-right"><?php echo date('Y')?> All Rights Reserved. | <span class="lead"> <i class="fa fa-paw"></i> Hubnet</span> </p>
  </div>
  <div class="clearfix"></div>
</footer>