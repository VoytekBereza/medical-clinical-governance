	<div class="row">
	  <div class="col-md-7 col-sm-7 col-xs-7">
		<div class="x_panel">
		  <div class="x_content"> <br />
		   <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><?php echo filter_string($pgd_detail['pgd_name']);?> Exam <small> <?php echo filter_string($pgd_detail['pgd_name']);?> Exam listing</small></h2>
                            
							<!--<div class="nav navbar-right panel_toolbox">
								<a href="<?php echo base_url(); ?>pgd/rechas/<?php echo $pgd_id; ?>" class="btn btn-sm btn-success">Add New</a>
							</div> -->
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<!-- Start Questions - Options -->
							<?php if(!empty($quizes)){ $question_number = 1; ?>
								
								<?php foreach($quizes as $quiz): // Quizes ?>
									<br>
									<span id="quiz_<?php echo $quiz['question_id']; ?>">

										<div align="right">
											<button class="btn btn-xs btn-default expand-btn" onClick="expandMe('<?php echo $quiz['question_id']; ?>');" >Expand</button>
										</div>

										<h4><?php echo '<strong>'.$question_number.') </strong>'; echo filter_string($quiz['question']);?></h4>
										
										<span id="expand_ol_<?php echo $quiz['question_id']; ?>" style="display: none;" >
											<br>
											<?php if(!empty($quiz['options'])){ ?>
												
													<ol type="A">
														<?php foreach($quiz['options'] as $key => $option): ?>
															<li>
																&nbsp; <input type="radio" name="q1[]" id="optionsRadios1" value="a"> &nbsp; 
																<?php if($quiz['correct_option_id'] == $option['option_id']){ ?>
																	<strong class="label label-success" style="white-space:normal;"><?php echo filter_string($option['option']); ?></strong>
																<?php } else { ?>
																	<?php echo filter_string($option['option']); ?>
																<?php } ?>
															</li>
														<?php endforeach; ?>
													</ol>
												
											<?php } // End - if(!empty($quiz['options'])): ?>
											<br>
											<a href="#quiz_add_edit_form" class="btn btn-xs btn-warning" onClick="editQuiz('<?php echo $quiz['question_id']; ?>');" >Edit question</a>
										</span>
									</span>
									<br>
								<?php 
								$question_number++;
								endforeach; // End - foreach($quizes as $quiz): ?>
								
							<?php } // End - if(!empty($quizes)): ?>
							<!-- End Questions - Options -->
							<!-- Hidden input for save the base_url() + path to send the post call - in external js script (custom.js) -->
							<input type="hidden" name="full_path" id="full_path" value="<?php echo base_url(); ?>pgd/quiz_by_id/" />
						</div>
					</div>
				</div>

				<br />
				<br />
				<br />

			</div>
		  </div>
		</div>
	</div>
	<div id="quiz_add_edit_form"></div>
	<div class="row">
		<div class="col-md-5 col-sm-5 col-xs-5">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2 class="action_name" id="add_edit_quiz_title">Add New Questions</h2>
                       
                       
						<!--<div class="nav navbar-right panel_toolbox">
							<a href="<?php echo base_url(); ?>pgd/rechas/<?php echo $pgd_id; ?>" class="btn btn-sm btn-success">Add New</a>
						</div> -->
						<div class="clearfix"></div>
					</div>
					
					<div class="x_content">
					
						<?php if($this->session->flashdata('err_message')){?>
							<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
						<?php } // end if($this->session->flashdata('err_message')) ?>
						<?php if($this->session->flashdata('ok_message')){?>
								<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
						<?php }//if($this->session->flashdata('ok_message'))?>
						<br />
                         <p  class="action_name">Please add minimum <?php echo $pgd_detail['no_of_quizes']; ?> questions.</p>
						<form data-toggle="validator" role="form" method="post" action="<?php echo base_url(); ?>pgd/add_update_quiz/<?php echo $pgd_id; ?>" >
							<!-- Input Group with Addon -->
							<!-- <label for="basic-url">Your vanity URL</label> -->
                            <div class="form-group has-feedback">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon3">Question</span>
                                    <input class="form-control"  type="text" placeholder="Add exam question" id="question" name="question" required="required">
                                </div>
                                 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                 <div class="help-block with-errors"></div>
                           </div>
                           
							<h2 class="" >Enter Options Below:</h2>
							
							<div class="form-group has-feedback">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon3">Option A</span>
                                    <input class="form-control" type="text" name="options[]" value="" id="q1_field" required="required">
                                </div>
                                 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                 <div class="help-block with-errors"></div>
                           </div>
							
                            <div class="form-group has-feedback">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon3">Option B</span>
								<input class="form-control" type="text" name="options[]" value="" id="q2_field" required="required">
							</div>
								 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                 <div class="help-block with-errors"></div>
                           </div>
                           
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon3">Option C</span>
								<input class="form-control" type="text" name="options[]" value="" id="q3_field" >
							</div>
							
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon3">Option D</span>
								<input class="form-control" type="text" name="options[]" value="" id="q4_field" >
							</div>
							
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon3">Option E</span>
								<input class="form-control" type="text" name="options[]" value="" id="q5_field" >
							</div>
							 <div class="form-group has-feedback">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon3">Correct Option</span>
    
                                    <select class="form-control" name="correct_option" id="correct_option" required="required" >
                                        <option value="">Select Correct Option</option>
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">C</option>
                                        <option value="4">D</option>
                                        <option value="5">E</option>
                                    </select>
                                    
                                </div>
                            	<div class="help-block with-errors"></div>
                            </div>
							<button type="submit" class="btn btn-success action_name pull-right">Add Question</button>
							<!-- Hidden field to store the question id in case of update -->
							<input type="hidden" name="question_id" id="question_id" value="" />
						</form>
				
					</div>
				</div>
			</div>
		</div>
	</div>
 
</div>