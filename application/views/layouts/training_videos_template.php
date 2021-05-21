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

<body>

	<?php echo $header_top?>
    <!-- Page Content -->

    <!-- Page Content -->
    <div class="container"> 
      <br>
      <!-- Page Heading/Breadcrumbs -->
      <div class="row">
        <div class="col-lg-12">
          
          <?php echo $bread_crum?>
        </div>
      </div>
      <!-- /.row --> 
      
      <!-- Content Row -->
      <div class="row"> 
        <!-- Sidebar Column -->
        <div class="col-md-3">
			<?php echo $dashboard_left_pane?>
        </div>
        
        <!-- Content Column -->
        <div class="col-md-9">
        	<?php echo $content; ?>
        </div>
        
      </div>
      <!-- /.row -->
      
      <hr>
      <?php echo $footer;?>
      <!-- Footer -->
      
    </div>    
    <!-- /.container -->

<?php 
	//footer_script slice
	echo $footer_script;
	echo $js;
?>

</body>

</html>
