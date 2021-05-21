<?php echo filter_string($page_data['page_description']);?>

<a href="#first_user_pop" id="open_user_pop" class="fancy_inline hidden">Open</a>

<div id="first_user_pop" style="display:none">
    <div class="col-md-12">
    
    	<?php 
                $FIRST_POPUP_TXT = 'FIRST_POPUP_TXT';
                $first_popup_txt = get_global_settings($FIRST_POPUP_TXT); //Set from the Global Settings
                $first_popup_txt = filter_string($first_popup_txt['setting_value']);
				
				echo $first_popup_txt;
		
		?>
    </div>

    <div class="col-md-12">&nbsp;</div>
    <div class="col-md-4">
    	<button class="btn btn-primary btn-lg btn-block" onclick="javascript:setCookie(this, 'first_popup', 'first popup', 1); $.fancybox.close();">Yes</button>
    </div>
    <div class="col-md-4">
        <button class="btn btn-danger btn-lg btn-block" onclick="window.location.href = 'http://google.com'">No</button> <!-- window.location.href = 'about:home'; -->
    </div>
</div>

<script>
	$(window).load(function(){
		
		<?php 
			if(!$_COOKIE['first_popup']){
		?>
				$('#open_user_pop').click();
		<?php		
			}//end if(!$_COOKIE['first_popup'])
		?>
		
	})

	function setCookie(e, name,value,days){
	
		var delete_cookie = function(name) {
			document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		};
	
		if(days){
			
			var date = new Date();
			date.setTime(date.getTime() + ( days * 24 * 60 * 60 * 1000 ));
			var expires = "; expires="+date.toGMTString();
	
		} // if(days)
	
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	
		// alert( document.cookie );
	
		// triger <a> tag href
		//window.location = $(e).attr("href");

} // function setCookie(e, name,value,days)

</script>