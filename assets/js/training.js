//This function is used on Training Video Detail Page
$('#pgd_video_list a').click(function(e) {
	video_id = $(this).attr('id');
	video_type = $(this).attr('rel');
	if(video_type == 1)
		$('#video_frame').attr('src', "https://prezi.com/embed/"+video_id)
	else
		$('#video_frame').attr('src', "https://www.youtube.com/embed/"+video_id)
	
	
	$('html, body').animate({scrollTop: $('#video_ref').offset().top}, 500);
	
});	

$(function () {    //shorthand for document ready

	//Quiz Ajax Calls used on Take a Quiz section
	$('#training_quiz_container').on('click', '.submit_quiz', function () {
		
		btn_id = this.id;
		
		$("#overlay_addaquiz").removeClass("hidden");
		
		$.ajax({
		
			type: "POST",
			url: SURL+"training/show-next-quiz-page/",
			data: $("#training_quiz_frm").serialize()+ "&action="+btn_id,
			beforeSend : function(result){
				
				//Validation only allowed if Clicked on Next Question
				if(btn_id == 'submit_quiz'){
					$is_checked = $("input:radio[name='answer_radio']").is(":checked")
					
					if(!$is_checked){
						$("#overlay_addaquiz").addClass("hidden");	
						$('.error').html('Error: Please Select one of the option from above to proceed!');
						return false;
					}else{
						$('.error').html('');
						$("#overlay_addaquiz").removeClass("hidden");	
					}
				}else{
					//return false;	
					$("#overlay_addaquiz").removeClass("hidden");
				}//end if(btn_id == 'submit_quiz')
				
			},
			success: function(result){
				$("#overlay_addaquiz").addClass("hidden");
				$("#training_quiz_container").html(result);
			}
		}); 	  	
	});


	//Submit Review into the database
	$('#submit_review').on('click', '#submit_training_review', function () {

		review_txt = $('#reviews').val();
		review_txt = review_txt.trim();
		if(review_txt == ''){
			alert('Please enter your reviews.');	
			return false;
		}
		$.ajax({
		
			type: "POST",
			url: SURL+"training/submit-training-review-process/",
			data: $("#submit_training_review_frm").serialize(),
			beforeSend : function(result){
			},
			success: function(result){
				
				$("#submit_review_container").html('<div class="alert alert-success alert-dismissable text-center"><strong>Thank you for submitting your reviews!</strong></div>'); 
			}
		}); 	  	

	});
	

});

// Load more Reviews
$("#load-more-training-reviews").click(function(){

	// Get training-ID
	var training_id = $(this).attr("value");
	var offset = $(this).attr("rel");
	
	// Call ajax to load more training-reviews
	$.ajax({
	
		type: "POST",
		url: SURL + "training/training-reviews-load-more/"+ training_id +"/"+ offset,
		//data: ,
		beforeSend : function(result){
			//
		},
		success: function(result){
			
			if(result != 'empty'){
				
				var obj = JSON.parse(result); // Parse Json result into object
				var html = '';
				
				$.each(obj, function(key, value){ // loop for each review

					// Set Date format
					var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
					var review_date_formated = new Date(value.review_date);
					var new_date = review_date_formated.getDate() + ' ' + monthNames[review_date_formated.getMonth()] + ', ' +  review_date_formated.getFullYear();					
					
					html += '<div class="row"><div class="col-md-2"><input type="number" min="0" max="5" step="1" data-size="xxs" value="'+ value.star_rating +'" displayOnly="1" class="review_rating_style" /><p class="text-success">'+ new_date +'</p></div><div class="col-md-10"><p>'+ value.reviews +'</p><p class="text-primary"><strong>By '+ value.review_by_name +'</strong></p></div></div><hr />';
				}); // $.each(obj, function(key, value)
				
				// Append new data to training-reviews-container
				$('#training-reviews-container').append(html);
				$('#load-more-training-reviews').attr("rel", parseInt(offset) + parseInt(10) );
				
				$('.review_rating_style').rating({
					showClear: false,
					showCaption: false,
					animate: false
				});
				
			} else
				$('#no-record-found-div').removeClass("hidden");
			// if(result != 'empty')
			
		} // success: function(result)
		
	}); // $.ajax
		
}); //$("#load-more-training-reviews").click(function()