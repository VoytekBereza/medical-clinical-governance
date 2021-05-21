<?php

if($filled_raf){

	$session_raf = $filled_raf;

} // if($filled_raf)

?>
<div itemscope="itemscope" itemtype="http://schema.org/Product">
<style>
        	
	label {
		display: inline-block;
		font-weight: 700;
		margin-bottom: 5px;
		max-width: 100%;
	}
	label {
		display: inline-block;
		font-weight: 700;
		margin-bottom: 5px;
		max-width: 100%;
	}

	.radio-btn-set input[type="radio"]:checked + label {
		background: #31708f none repeat scroll 0 0;
		border-color: #666;
		color: #fff;
		text-decoration: underline;
		z-index: 500;
	}
	.radio-btn-set label {
		border: 1px solid #31708f;
		display: block;
		float: left;
		font-weight: 400;
		margin: 0;
		min-width: 52px;
		padding: 7px 13px;
		position: relative;
		text-align: center;
		z-index: 0;
	}

</style>
  <div class="row">
    <div class="col-sm-12 col-md-12"> 
      
      <!-- <form action="<?php echo base_url(); ?>clinics/submit-raf-document" method="post" > --> 
      
      <!-- Start - Question Rows --> 
      <!-- Questions -->
<?php
	
	$raf_filled_already = 1;
	$session_raf = $filled_raf;

	if($raf_data){

		if($malaria_med_raf && $malaria_med_raf == 1){
			$post_name = 'malaria_answer_question';
		} else {
			$post_name = 'answer_question';
		} // if($malaria_med_raf && $malaria_med_raf == 1)

?>
      <div class="panel panel-info">
        <div class="panel-heading"> <strong> Risk Assesment Form </strong> </div>
      <div class="panel-body">
<?php	

		foreach($raf_data as $label => $questions){
			
			foreach($questions as $question){
?>
		      <div id="question-<?php echo $question['id']; ?>-div" class="row">
		        <div class="radio-btn-set">
		          <div class="col-md-9"> <?php echo filter_string($question['question']); ?> </div>
		          <div class="col-md-3">
		            <div class="pull-right"> 
		              <!-- Yes Radio Switch -->
		              <input required="required"

							<?php 
		                    // Validation Check for errors [ Prevent form submissions ]
		                    if($question['required_answer'] == 'Y' || $question['error_type'] == 'W')
		                        echo 'rel="1"';
		                    else
		                        echo 'rel="0"';
		                     // if($question['required_answer'] == 'N')

		                    if($session_raf){
		                    	$index_key = array_search(filter_string($question['id']), array_column($session_raf, 'raf_id'));
		                    }
		                    
		                    if(is_numeric($index_key) && $session_raf[$index_key]['answer'] == 'Y'){ echo 'checked="checked"'; }

		                   	echo (filter_string($question['error_type']) == 'E') ? 'required="required"' : '' ; ?> 
		                    required="required"

		                    type="radio" name="<?php echo $post_name; ?>[<?php echo $question['id']; ?>]" id="yes-question-<?php echo $question['id']; ?>" value="Y" class="hidden" >

		                    <?php // echo $index_key; //echo 'RAF: '.$question['id'].' - '.'Index: '.$index_key; ?>

						<label id="yes-question-<?php echo $question['id']; ?>-label" <?php if(!$session_raf){ ?> for="yes-question-<?php echo $question['id']; ?>" <?php if($question['required_answer'] == 'N'){ ?>onClick="question_error_message('<?php echo $question['id']; ?>', 'show');" <?php }elseif($question['required_answer'] == 'Y'){ ?> onClick="question_error_message('<?php echo $question['id']; ?>', 'hide');" <?php } } ?> > Yes </label>

						<!-- No Radio Switch -->
						<input 

		                <?php 
		                // Validation Check for errors [ Prevent form submissions ]
		                if($question['required_answer'] == 'N'  || $question['error_type'] == 'W')
		                    echo 'rel="1"';
		                else
		                    echo 'rel="0"';
		                // if($question['required_answer'] == 'N')
		                ?>

		                <?php if(is_numeric($index_key) && $session_raf[$index_key]['answer'] == 'N'){ echo 'checked="checked"'; } ?>

		                required="required"

		                type="radio" name="<?php echo $post_name; ?>[<?php echo $question['id']; ?>]" id="no-question-<?php echo $question['id']; ?>" value="N" class="hidden" >
		              
		              	<label id="no-question-<?php echo $question['id']; ?>-label" <?php if(!$session_raf){ ?> for="no-question-<?php echo $question['id']; ?>" <?php if($question['required_answer'] == 'Y'){ ?> onClick="question_error_message('<?php echo $question['id']; ?>', 'show');" <?php } elseif($question['required_answer'] == 'N'){ ?> onClick="question_error_message('<?php echo $question['id']; ?>', 'hide');" <?php } } ?> >
		              No
		              </label>


		            </div>
		          </div>
		        </div>

		        <!-- Errors AND warnings -->
		        <?php /* ?>
				<span <?php if($raf_filled_already == 1 && $question['error_type'] == 'W' && $session_raf['answer'][$question['id']] != $question['required_answer']) {} else { ?> class="hidden" <?php } ?> id="error-message-<?php echo $question['id']; ?>">
					
					<?php if($question['error_type'] == 'E'){ ?>
						<br /> <div class="alert alert-danger"> <span class="glyphicon glyphicon-remove"></span> &nbsp; <?php echo filter_string($question['error_message']); ?> </div>
					<?php } elseif($question['error_type'] == 'W') { // if($question['error_type'] == 'E') ?>
						<br /> <div class="alert alert-warning"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; <?php echo filter_string($question['error_message']); ?> </div>
					<?php } // if($question['error_type'] == 'E')  ?>
				</span>
				<?php */ ?>
				
		      </div>
		      <br />
		      <hr />
		      <br />
<?php 	
		} // foreach($questions as $question) 
		
	  } // foreach($raf_data as $label => $questions)
?>
	</div> <!-- End - panel-body -->
<?php
	} // if($raf_data)
?>
      <!-- End - Question Rows --> 
      <!-- </form> --> 
    </div>
  </div>
</div>
<br />
<script type="application/javascript">
        
	// Show / Hide Warnings and Error Messages for each question
	function question_error_message(question_id, action){
	
		if(action == "show")
			$('#error-message-' + question_id).removeClass("hidden");
		else if(action == "hide")
			$('#error-message-' + question_id).addClass("hidden");
		// end if(action == "show")
		
	} // function question_error_message()

</script>