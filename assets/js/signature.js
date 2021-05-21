$(function() {
	$('#setting_signature').signature({
		 change: function(event, ui) { 
        	
			var signature_svn = $('#setting_signature').signature('toSVG');
			signature_svn = signature_svn.replace('<?xml version="1.0"?>','');
			signature_svn = signature_svn.replace('<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">','');
			
			signature_svn = signature_svn.replace('<svg xmlns="http://www.w3.org/2000/svg" width="15cm" height="15cm">','<svg xmlns="http://www.w3.org/2000/svg" width="200" height="60">');
			signature_svn = signature_svn.replace('<g fill="#ffffff">','<g fill="#ffffff" fill-opacity="0.0">');

			$('#svn_signature_code').html(signature_svn);
			$('#signature_svn_txt').val(signature_svn);
    	} 	
	});
	$('#setting_clear').click(function() {
		$('#setting_signature').signature('clear');

		var old_signature = $('#old_signature_svn_txt').html();
		$('#signature_svn_txt').val(old_signature);
		$('#svn_signature_code').html(old_signature);
		
	});
});
