<?php 
	// Username
	$HUBNET_FOOTER_TXT = 'HUBNET_FOOTER_TXT';
	$hubnet_footer_text = get_global_settings($HUBNET_FOOTER_TXT);
	$hubnet_footer_text = trim($hubnet_footer_text['setting_value']);
?>

<!-- Footer -->
<footer>
    <div class="row">
        <div class="col-lg-12">
           <p class="text-center"><?php echo filter_string($hubnet_footer_text);?><br>
            <a href="<?php echo SURL?>terms-and-conditions">Terms &amp; Conditions</a> | 
            <a href="<?php echo SURL?>disclaimer">Disclaimer</a> | 
            <a href="<?php echo SURL?>security-policy">Security Policy</a> | 
            <a href="<?php echo SURL?>contactus">Contact Us</a> | 
            <a href="<?php echo SURL?>statement-of-purpose">Statement of Purpose</a> | 
            <a href="<?php echo SURL?>sitemap">Sitemap</a></p>                
            <p class="text-center"><img src="<?php echo IMAGES?>uklrp.png" /> <img src="<?php echo IMAGES?>logo-ico.png" style="margin-left:10px;" />          </p>
          </div>
			
    </div>
    <!-- /.row -->
</footer>
