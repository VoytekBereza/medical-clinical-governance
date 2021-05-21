<?php
	$all_js = array('bootstrap.min.js','common.js');
	echo add_js($all_js);
	
?>
<!--[if IE]>
<script src="<?php JS?>excanvas.js"></script>
<![endif]-->

<script>
<?php 
	$get_user = get_user_details_new($this->session->id);
	if($get_user['is_new_user'] == '0'){
?>
		$(window).load(function() {
			$("#new_terms_box").click();
		});
<?php
	}
?>
</script>