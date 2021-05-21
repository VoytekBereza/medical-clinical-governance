<a class="new_change_password_fancy fancybox.ajax hidden" id="new_terms_box" href="<?php echo SURL?>dashboard/new-change-password">New terms of change password</a>
<!-- Centralized  Header TOP-->
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo SURL?>"><img src="<?php echo IMAGES?>logo.png"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo SURL?>about-us">About Us</a></li>
                    <li><a href="<?php echo SURL?>services">Services</a></li>
                    <li><a href="<?php echo SURL?>contactus">Contact Us</a></li>
                    <?php 
						if(!$this->session->id){
					?>
                        <li><a href="<?php echo SURL?>register">Register</a></li>
                        <li><a href="<?php echo SURL?>login">Login</a></li>
                    
                    <?php		
						}else{
							

					?>
                        <li><a href="<?php echo SURL?>dashboard"><?php echo ucfirst(filter_string($this->session->last_name))."'s";?> Dashboard</a></li>
                        <li><a href="<?php echo SURL?>login/logout">LogOut</a></li>
                    <?php		
						}//end  if(!$this->session->userdata('id'))
					?>
                </ul>
                
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
