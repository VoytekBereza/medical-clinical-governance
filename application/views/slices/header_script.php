<noscript>
<div class="text-center" style="border: 1px solid purple; padding: 10px;"> <span style="color: red"> <?php echo ($noscript_text) ? $noscript_text['setting_value'] : '' ; ?> </span> </div>
</noscript>
<!--Centralized Header Script -->
<!--<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet"> -->
<?php 
	//Including all Required CSS 
	$common_css = array('bootstrap.min.css','modern-business.css','style.css',FONTS_AWSOME_CSS.'font-awesome.min.css');
	echo add_css($common_css);

	$common_js = array('jquery.min.js');
	echo add_js($common_js);

?>
<!-- BASE URL for Javascript Files -->
<script>var SURL = '<?php echo SURL?>';</script>