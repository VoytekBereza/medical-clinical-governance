<?php 
	// Username
	$HUBNET_FOOTER_TXT = 'HUBNET_FOOTER_TXT';
	$hubnet_footer_text = get_global_settings($HUBNET_FOOTER_TXT);
	$hubnet_footer_text = trim($hubnet_footer_text['setting_value']);
?>

<!-- Footer -->
<footer>
   <div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">	
          	<img src="<?php echo IMAGES?>footer-logo.png" class="center-block" alt="Footer Logo">		
           <p class="footer-links">
            <a href="<?php echo SURL?>terms-and-conditions">Terms &amp; Conditions</a> | 
            <a href="<?php echo SURL?>disclaimer">Disclaimer</a> | 
            <a href="<?php echo SURL?>security-policy">Security Policy</a> | 
            <a href="<?php echo SURL?>contactus">Contact Us</a> | 
            <a href="<?php echo SURL?>statement-of-purpose">Statement of Purpose</a> | 
            <a href="https://hubnet.io/sitemap.xml" target="_blank">Sitemap</a></p>                
            
            <p class="footer-text"><?php echo filter_string($hubnet_footer_text);?></p>
            
            <p><img src="<?php echo IMAGES?>img-ukrlp.png" /> <img src="<?php echo IMAGES?>img-ico.png" style="margin-left:10px;" />          </p>
          </div>
			
    </div>
    </div>
    <!-- /.row -->
</footer>