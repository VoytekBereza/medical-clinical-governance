<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <?php echo chrome_frame(); ?>
    <?php echo view_port(); ?>	
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

<body class="nav-md">

    <!-- Page Content -->
    <div class="container body">
    	 <div class="main_container">

            <!--Left Navigation -->
            <?php echo $left_nav?>

            <!-- top navigation -->
            <?php echo $header_top?>
            <!-- /top navigation -->

            <!-- Right page content -->
			<div class="right_col" role="main">
                <br />
                <?php echo $content?>
                
                <!-- footer content -->
                <?php echo $footer?>
                <!-- /footer content -->
			</div>            
            
            <!-- /Right page content -->
         
         </div>
    </div>
    
    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <!-- /.container -->

<?php 
	//footer_script slice
	echo $footer_script;
	echo $js;
?>

</body>
</html>
