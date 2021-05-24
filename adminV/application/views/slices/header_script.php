<!--Centralized Header Script -->
<?php 
	//Including all Required CSS 
	$common_css = array('bootstrap.min.css','../fonts/css/font-awesome.min.css','animate.min.css','custom.css','icheck/flat/green.css');
	echo add_css($common_css);
	echo jquery();
?>
<!-- BASE URL for Javascript Files -->
<script>var SURL = '<?php echo SURL?>';</script>