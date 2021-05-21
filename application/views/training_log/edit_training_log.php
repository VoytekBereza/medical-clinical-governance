<link rel="stylesheet" href="<?php echo CSS?>datepicker.css">
<div class="panel panel-success"> 
    <div class="panel-heading"><strong>Edit Training Log</strong></div>
    <div class="panel-body">
        <div class="row">
            <form data-toggle="validator" role="form"  action="<?php echo SURL?>training-log/add-edit-training-log-process" method="post" name="edit_trainig_log_frm" id="edit_trainig_log_frm" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="form-group  has-feedback">
                          <label id="" >Date<span class="required">*</span></label>
                         <input type="text" id="p_date_completed" name="date_completed" value="<?php echo date('d/m/Y',strtotime($training_log_details['date_completed']));?>" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                        </div>
                    <div class="form-group  has-feedback">
                      <label id="" >Training Course Name <span class="required">*</span></label>
                      <input type="text" class="form-control" name="course_name" id="course_name" value="<?php echo filter_string($training_log_details['course_name'])?>" required />
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group  has-feedback">
                      <label id="" >Training Provider<span class="required">*</span></label>
                      <input type="text" class="form-control" name="training_provider" id="p_training_provider" value="<?php echo filter_string($training_log_details['training_provider'])?>" required />
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group  has-feedback">
                      <label id="" >Qualification of Training</label>
                      <textarea class="form-control" name="qualification_of_training" id="p_qualification_of_training"><?php echo filter_string($training_log_details['qualification_of_training'])?></textarea>
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                	<div class="form-group  has-feedback">
                      <label id="" >Subject of Training<span class="required">*</span></label>
                      <input type="text" class="form-control" name="subject_of_training" id="p_subject_of_training" value="<?php echo filter_string($training_log_details['subject_of_training'])?>" required />
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                    </div>
                    
                    <div class="form-group  has-feedback">
                      <label id="" >Notes on Subject</label>
                      <textarea class="form-control" name="notes_on_subject" id="p_notes_on_subject"><?php echo filter_string($training_log_details['notes_on_subject'])?></textarea>
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                    </div>
                    
                    
                    
                    <div class="form-group  has-feedback">
                      <label id="" >Useful Weblinks</label>
                      <textarea class="form-control" name="useful_weblinks" id="useful_weblinks"><?php echo filter_string($training_log_details['useful_weblinks'])?></textarea>
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                      <label id="">Have you performed a CPD cycle on this topic?</label> <br />
                      <label style="font-weight:normal"><input type="radio" name="performed_cpd" value="yes" <?php echo ($training_log_details['performed_cpd'] == 'yes') ? ' checked="checked"' : ''?> /> Yes</label>
                      <label style="font-weight:normal"><input type="radio" name="performed_cpd" value="no" <?php echo ($training_log_details['performed_cpd'] == 'no') ? ' checked="checked"' : ''?> /> No</label>
                    </div>
                    
                    <div class="form-group has-feedback">
                      <label id="">Have you reflected it?</label> <br />
                      <label style="font-weight:normal"><input type="radio" name="is_reflected" value="yes" <?php echo ($training_log_details['is_reflected'] == 'yes') ? ' checked="checked"' : ''?> /> Yes</label>
                      <label style="font-weight:normal"><input type="radio" name="is_reflected" value="no" <?php echo ($training_log_details['is_reflected'] == 'no') ? ' checked="checked"' : ''?> <?php  echo (!$training_log_details['is_reflected'] )? 'checked="checked"' : ''  ?> /> No</label>
                    </div>
                    
                    <div class="form-group  has-feedback">
                      <label id="" >Useful Files</label>
                      <input class="form-control" type="file" name="useful_file" style="padding-bottom:40px; margin-bottom:5px;" />
                        <p>
                            <i>- <strong>Allowed Extensions:</strong> jpg, jpeg, png, gif, doc, docx, xls, xlsx, pdf, ppt, pptx</i><br>
                            <i>- <strong>Maximum Size Allowed:</strong> 5MB</i><br />
                            <i>Invalid file format and large files will be automatically excluded</i>
                        </p>                                          
                      
                    </div>
                </div>
                <div class="col-md-12">
                	<table class="table table-hover">
                    	<thead>
                        	<tr>
                            	<th>View File</th>
                                <th>View Type</th>
                                <th>Uploaded Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php 
								if(count($training_log_files_list) > 0 ){
									for($i=0;$i<count($training_log_files_list);$i++){
							?>
                                <tr>
                                    <td><a href="<?php echo TRAINING_LOG_FILES.filter_string($training_log_files_list[$i]['file_name'])?>" target="_blank"><?php echo filter_string($training_log_files_list[$i]['file_name'])?></a></td>
                                    <td>
                                        <?php 
                                            $extension = pathinfo(filter_string($training_log_files_list[$i]['file_name']), PATHINFO_EXTENSION);
                                            echo strtoupper($extension);
                                        ?>
                                    </td>
                                    <td><?php echo uk_date_format($training_log_files_list[$i]['created_date'])?></td>
                                    <td><a href="<?php echo SURL?>training-log/delete-file/<?php echo $training_log_files_list[$i]['training_log_id'] ?>/<?php echo filter_string($training_log_files_list[$i]['id'])?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a></td>
                                </tr>
                            
                            <?php 
									}//end for($i=0;$i<count($training_log_files_list);$i++)
								}else{
							?>
                            		<tr>
                                    	<td colspan="5">No Files found</td>
                                    </tr>
                            <?php		
								}
							?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 text-right">
                      <button type="submit" class="btn btn-sm btn-success"  id="p_trainig_log_btn" name="trainig_log_btn"> Update </button>
                      <input type="hidden" name="log_id" value="<?php echo $training_log_details['id']?>" readonly="readonly" />
                </div>
            </form>
        </div>                                                        
    </div>
</div>   

<script src="<?php echo JS ?>date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo JS ?>date-time/custom_datepicker.js"></script>