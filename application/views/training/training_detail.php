<div class="panel panel-default"> 
  
  <!-- Default panel contents -->
  
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <?php if(filter_string($training_detail_arr['course_sample_video']) != ''){?>
            <p class="embed-responsive embed-responsive-4by3">
              <iframe width="100%" height="430" src="<?php echo filter_string($training_detail_arr['course_sample_video'])?>" frameborder="0" allowfullscreen id="video_frame"></iframe>
            </p>
            <?php }//if(filter_string($training_detail_arr['course_image']) != '')?>
          </div>
          <!--<div class="col-md-2">
            <p><img alt="" src="<?php echo TRAINING_COURSE_IMAGES.filter_string($training_detail_arr['course_image']) ?>" class="img-responsive img-hover" width="150px"></p>
          </div>-->
          <div class="col-md-6">
            <p> <strong>
              <?php 
                    echo filter_string($training_detail_arr['course_name']);
                    
                    //If  discount vlaue > 0, the diccount proce will be considered
                    if(filter_string($training_detail_arr['discount_price']) != 0.00){
                 ?>
              <span class="label label-default"><s>&pound;<?php echo filter_string($training_detail_arr['price'])?></s></span></strong> <span class="label label-warning">&pound;<?php echo filter_string($training_detail_arr['discount_price'])?></span></strong>
              <?php }else{?>
              <span class="label label-default">&pound;<?php echo filter_string($training_detail_arr['price'])?></span>
              <?php 
                    }//end if(filter_string($training_detail_arr['discount_price']) != 0.00)
                    
                ?>
              </strong> </p>
            <p>
			   <?php
                $averge_rating = get_product_ratings('TRAINING',$training_detail_arr['id']);
                $averge_rating = $averge_rating['avg_rating'];
               ?>
            
              <input id="training_rating_input" type="number" min="0" max="5" step="1" data-size="xs" value="<?php echo filter_string($averge_rating) ?>" displayOnly="1" />
              <a href="#" id="training_review_link"><?php echo number_format($averge_rating,1); ?> starred - <?php echo count($get_training_reviews_list)?> <?php echo (count($get_training_reviews_list) > 1) ? 'Reviews' : 'Review' ?></a>
            </p>
            <p class="text-justify"><?php echo filter_string($training_detail_arr['long_description'])?></p>
            <form name="training_frm" id="training_frm_popup">
                <p class="pull-left">
    
                    <a id="<?php echo filter_string($training_detail_arr['id'])?>" class="btn btn-xs btn-success add_to_basket" href="javascript:;"><i class="fa fa-cart-plus "></i> Add to Basket</a>
                <?php
                    if(filter_string($training_detail_arr['discount_price']) != 0.00){
                ?>
                        <input type="hidden" name="p_price" value="<?php echo filter_string($training_detail_arr['discount_price']) ?>" readonly="readonly" />
                <?php		
                    }else{
                ?>
                        <input type="hidden" name="p_price" value="<?php echo filter_string($training_detail_arr['price']) ?>" readonly="readonly"/>
                <?php		
                    }//end if
                ?>
                  <input type="hidden" name="p_name" value="<?php echo filter_string($training_detail_arr['course_name'])?>" readonly="readonly"/>
                  <input type="hidden" name="p_id" value="T_<?php echo filter_string($training_detail_arr['id'])?>" readonly="readonly"/>
                  <input type="hidden" name="p_type" value="TRAINING" readonly="readonly"/>
                    
                </p>
            </form>
          </div>
        </div> <!--/.row -->
      </div>
    </div>
  </div>
</div>
<script>
	//Rating Script for Trainings and PGD
	$('#training_rating_input, #pgd_rating_input').rating({
		  showClear: false,
		  showCaption: false,
		  animate: false
		 });

</script>