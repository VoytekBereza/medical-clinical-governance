<div class="panel panel-default"> 
  
    <!-- Default panel contents -->
    <div class="panel-heading"><strong>Top Customers Review</strong></div>
    <div class="panel-body">
    
    <div id="training-reviews-container">
	
<?php 
		if(count($get_training_reviews_list) > 0){
			
			for($i=0;$i<10;$i++){
				if($get_training_reviews_list[$i]['star_rating']){
		?>
					<div class="row">
					  <div class="col-md-2">
						<input id="review_rating_input" type="number" min="0" max="5" step="1" data-size="xxs" value="<?php echo filter_string($get_training_reviews_list[$i]['star_rating'])?>" displayOnly="1" class="review_rating_style" />
						<p class="text-success"><?php echo kod_date_format(filter_string($get_training_reviews_list[$i]['review_date']));?></p>
					  </div>
					  <div class="col-md-10">
						<p><?php echo filter_string($get_training_reviews_list[$i]['reviews']);?></p>
						<p class="text-primary"><strong>By <?php echo ucwords(filter_string($get_training_reviews_list[$i]['review_by_name']));?></strong></p>
					  </div>
					</div>
					<!--/.row -->
					<hr />
		
		<?php		
				} // if($get_training_reviews_list[$i]['star_rating'])
				
			}//end for($i=0;$i<count($get_training_reviews_list);$i++)
		
		}else{
			
		?>
			<div class="alert alert-danger"><strong>No Reviews Found</strong></div>
		<?php				
		}//end if(count($get_training_reviews_list) > 0)
?>
	</div>
    <?php 
		if(count($get_training_reviews_list) > 10){
	?>
	<br />
	<div id="no-record-found-div" class="text-danger text-center hidden">No more records found.</div>
	<button class="text-center btn btn-sm btn-block" id="load-more-training-reviews" value="<?php echo ($training_id) ? $training_id : '' ; ?>" rel="11" >Load More</button>
    
<?php		
		}//end if(count($get_training_reviews_list) > 10)
		
		//Check if user have already rated for the reviews.
		if(filter_string($training_access_allowed['star_rating']) == '0' && $training_access_allowed){

	?>
        <p id="rating_container">
        	<p><strong>Please hover the mouse over the stars below to rate this product.</strong></p>
            <input id="training_rating_input" type="number" min="0" max="5" step="1" data-size="xs" value="0" <?php echo (filter_string($training_access_allowed['star_rating']) == 0) ? 'hidden' : 'displayOnly="1"'?> />
            <input id="pu_id" name="pu_id" type="hidden" value="<?php echo filter_string($training_access_allowed['id']) ?>" />
            <input id="pid" name="pid" type="hidden" value="<?php echo filter_string($training_access_allowed['product_id']) ?>" />
            <div id="overlay" class="overlay hidden" style="opacity:0;height:50px;top:215px">&nbsp;</div>
        </p>
            <form name="submit_training_review_frm" id="submit_training_review_frm" action="#" method="post" class="hidden">
                <!-- Commennts-->
                <div class="row">
                    <div class="col-md-12">
                        <h4>Thank you for rating. Please submit your reviews about this product.</h4>
                    </div>
                </div> <!--/.row -->
                <hr />
            	<div id="submit_review_container">
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label for="comments">Comments</label>
                                <textarea data-validation-required-message="Please enter your message" required="" class="form-control" id="reviews" name="reviews" placeholder="Please type in your valuable comments and suggestions." rows="3" maxlength="250"></textarea>
                                <br />
                               <p><i>Max 250 characters allowed </i>
                              </div>
                        </div>
                    </div> <!--/.row -->
                    <div class="row">
                        <div class="col-md-12" id="submit_review">
                            <button id="submit_training_review" name="submit_training_review" type="button" class="btn btn-success marg2">Submit Your Reviews</button>
                            <input type="hidden" id="order_detail_id" name="order_detail_id" value="<?php echo filter_string($training_access_allowed['id']) ?>" readonly="readonly" />
                            <input type="hidden" id="training_id" name="training_id" value="<?php echo filter_string($training_access_allowed['product_id']) ?>" readonly="readonly" />
                        </div>
                    </div> <!--/.row -->
				</div>
            </form>
   <?php 
		}//end if(filter_string($training_access_allowed['reviews']) == '')
   ?>
  </div>
</div>
<script>
	//Rating Script for Trainings and PGD
	$('.review_rating_style').rating({
		  showClear: false,
		  showCaption: false,
		  animate: false
		 });



</script>