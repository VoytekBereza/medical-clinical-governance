$(function () {    //shorthand for document ready

	//Quiz Ajax Calls used on Take a Quiz section
	$('#quiz_container').on('click', '.submit_quiz', function () {
		
		btn_id = this.id;
		
		$("#overlay_addaquiz").removeClass("hidden");
		
		$.ajax({
		
			type: "POST",
			url: SURL+"pgd/show-next-quiz-page/",
			data: $("#quiz_frm").serialize()+ "&action="+btn_id ,
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
				$("#quiz_container").html(result);
			}
		});	  	
	});
	
	//Submit Review into the database
	$('#submit_review').on('click', '#submit_pgd_review', function () {

		review_txt = $('#reviews').val();
		review_txt = review_txt.trim();
		if(review_txt == ''){
			alert('Please enter your reviews.');	
			return false;
		}
		$.ajax({
		
			type: "POST",
			url: SURL+"pgd/submit-pgd-review-process/",
			data: $("#submit_pgd_review_frm").serialize(),
			beforeSend : function(result){
			},
			success: function(result){
				
				$("#submit_review_container").html('<div class="alert alert-success alert-dismissable text-center"><strong>Thank you for submitting your reviews!</strong></div>'); 
			}
		}); 	  	

	});
	
});

//Rechas Validations on PGD Certifictae
$("#rechas_sbt").click(function(){

	$is_rechas_checked = $("input:radio[name='rechas_option']").is(":checked")
	
	if(!$is_rechas_checked){
		
		$('#option_error').html('Error: Please Select one of the option from above to proceed!');
		return false;
	}else{
		$('.error').html('');
		
		$is_terms_checked = $("input:radio[name='terms_option']").is(":checked")
		
		if(!$is_terms_checked){
			$('#error_terms').html('Error: You must accept Terms and Conditions to proceed.');
			return false;
		}else{
			$('#option_error').html('');
			$('#error_terms').html('');
			return true;	
		}//end if(!$is_terms_checked)
		
	}//end if(!$is_rechas_checked)

});

//Rating Script for Trainings and PGD
$('.review_rating_style').rating({
	showClear: false,
	showCaption: false,
	animate: false
});

// Load more PGD Reviews
$("#load-more-pgd-reviews").click(function(){

	// Get PGD-ID
	var pgd_id = $(this).attr("value");
	var offset = $(this).attr("rel");
	
	// Call ajax to load more pgd-reviews
	$.ajax({
	
		type: "POST",
		url: SURL + "pgd/pgd-reviews-load-more/"+ pgd_id +"/"+ offset,
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
				
				// Append new data to pgd-reviews-container
				$('#pgd-reviews-container').append(html);
				$('#load-more-pgd-reviews').attr("rel", parseInt(offset) + parseInt(10) );
				
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
		
}); //$("#load-more-pgd-reviews").click(function()