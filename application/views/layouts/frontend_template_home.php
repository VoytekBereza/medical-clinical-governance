<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title?></title>
	
    <?php
	    echo $meta;
		echo $header_script;
		echo $css;
	?>
    <link rel="shortcut icon" href="<?php echo IMG?>favicon.ico" />

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

	<?php echo $header_top?>
    <!-- Page Content -->
    <div class="home_container">
    	<?php echo $content; ?>
    </div>
    
	<?php echo $footer;?>    

<?php 
	//footer_script slice
	echo $footer_script;
	echo $js;
?>

</body>

</html>
