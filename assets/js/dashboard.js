//Ajax function for AddToCart

//Add to Bastet Script used on Dashboard
$(".add_to_basket").click(function(){

	var frm_id = $(this).parents('form:first')[0].id;
	
	$.ajax({
	
		type: "POST",
		url: SURL+"dashboard/add-to-basket/",
		data: $("#"+frm_id).serialize(),
		/*dataType: "json",*/
		beforeSend : function(result){
			$("#overlay_addtobasket").removeClass("hidden");
		},
		success: function(result){

			if(frm_id == 'training_frm_popup')
				$.fancybox.close(); //Close the Fancybox once the Add to Basket is clicked!

			$('html, body').animate({scrollTop: $('#basket_ref').offset().top}, 500);
			$("#overlay_addtobasket").addClass("hidden");
			$("#basket_container").html(result);
			
		}
	}); 	  	
});

$(function () {    //shorthand for document ready
	//Remove delete items from basket
	$('#basket_container').on('click', '.remove_from_basket', function () {

		var id = $(this).attr("id");
		
		$.ajax({
		
			type: "POST",
			url: SURL+"dashboard/remove-from-basket/",
			data: {row_id: id},
			beforeSend : function(result){
				$("#overlay_addtobasket").removeClass("hidden");
			},
			success: function(result){

				$('html, body').animate({scrollTop: $('#basket_ref').offset().top}, 500);
				$("#overlay_addtobasket").addClass("hidden");
				$("#basket_container").html(result);
			}
		}); 	  	

	});
	//Empty Basket
	$('#basket_container').on('click', '.empty_basket', function () {

		$.ajax({
		
			type: "POST",
			url: SURL+"dashboard/empty-basket/",
			data: {},
			beforeSend : function(result){
				$("#overlay_addtobasket").removeClass("hidden");
			},
			success: function(result){

				$('html, body').animate({scrollTop: $('#basket_ref').offset().top}, 500);
				$("#overlay_addtobasket").addClass("hidden");
				$("#basket_container").html(result);
			}
		}); 	  	

	});
});

//This function is applied on dashboard, this is just to check weather user is watching teh video for the first time or not. If he is logged in for the first time and watching the video for the first time, he will close the video and seen will be marked as 1.
/*
if(typeof activate_dashboard_fancy !== 'undefined' && activate_dashboard_fancy == 1){

	$(document).ready(function() {
        
                $('#non_prescribers_intro_video').attr('rel', 'media-gallery').fancybox({
                        openEffect : 'none',
                        closeEffect : 'none',
                        prevEffect : 'none',
                        nextEffect : 'none',
                        beforeClose : function () {
                            //set cookie code
						$.ajax({
						
							type: "POST",
							url: SURL+"dashboard/update-user-setting/",
							data: {is_intro_video_watched: '1'},
							beforeSend : function(result){},
							success: function(result){
							}
						}); 	  	
							
                            
                        },
        
                        arrows : false,
                        helpers : {
                            media : {},
                            buttons : {}
                        }
                    });
                
            });

	$(window).load(function() {
	   $("#non_prescribers_intro_video").click();
	});				
}//end if(activate_dashboard_fancy == 1)
*/

//Setting Signature
$("#default_signature").change(function(){
	
    selected_val = ($("#default_signature").val());
	
	if(selected_val == 'svn'){
		$('#error_text').addClass('hidden');
		$('#upload_signature').addClass('hidden');
		$('#draw_signature,#setting_signature_btn').removeClass('hidden');
	}else if(selected_val == 'image'){
		$('#error_text').addClass('hidden');
		$('#upload_signature').addClass('hidden');
		$('#draw_signature').addClass('hidden');
		$('#upload_signature,#setting_signature_btn').removeClass('hidden');
	}else{
		$('#error_text').removeClass('hidden');
		$('#draw_signature,#upload_signature,#setting_signature_btn').addClass('hidden');
	}//end if(selected_val == 'svn')
	
});