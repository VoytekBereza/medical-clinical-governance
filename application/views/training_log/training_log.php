<div class="panel panel-default"> 
	<div class="panel-heading"><strong><?php echo 'Training Log'?></strong></div>
    <div class="panel-body">
        
        <div class="row">
          <div class="col-md-12">
            <div class="tab-content">
              <div id="introduction_tab" class="tab-pane fade in <?php if($active_tab =="") { echo 'active';} else { echo '';}?>">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">

                    <div class="panel panel-info"> 
                        <div class="panel-heading"><strong>Voyager Training</strong></div>
                        <div class="panel-body">
                            <table class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>Date Completed</th>
                                        <th>Training</th>
                                        <th>Expiry (optional)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(count($pgd_training_log) > 0){
                                            
                                            for($i=0;$i<count($pgd_training_log);$i++){
                            
                                    ?>
                                                <tr>
                                                    <td><?php echo uk_date_format($pgd_training_log[$i]['quiz_pass_date'])?></td>
                                                    <td>
                                                        <?php 
                                                            $get_pgd_details = get_pgd_details($pgd_training_log[$i]['product_id']);
                                                            echo filter_string($get_pgd_details['pgd_name']);
                                                        ?>
                                                    </td>
                                                    <td><?php echo uk_date_format($pgd_training_log[$i]['expiry_date'])?></td>
                                                </tr>                            
                                    <?php
                                            }//end for($i=0;$i<count($purchased_items_by_user);$i++)
                                        }else{
                                    ?>
                                            <tr>
                                                <td colspan="3" class="text-danger">No record found.</td>
                                            </tr>
                                    
                                    <?php		
                                        }//end if(count($pgd_training_log) > 0)
                                    ?>
                                </tbody>
                            </table>                        
                        </div>
                    </div>

                    <div class="panel panel-warning" style="border-color:#FDDF01"> 
                        <div class="panel-heading" style="background-color:#FDDF01; color:#FFF"><strong>External Training</strong></div>
                        <div class="panel-body">
                            <table class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>Date Completed</th>
                                        <th>Training</th>
                                        <th>Training Provider</th>
                                        <th>Reflection</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(count($training_log_details) > 0){
                                            
                                            for($i=0;$i<count($training_log_details); $i++){
                                    ?>
                                                <tr>
                                                    <td><?php echo uk_date_format($training_log_details[$i]['date_completed']);?></td>
                                                    <td><?php echo filter_string($training_log_details[$i]['course_name'])?></td>
                                                    <td><?php echo filter_string($training_log_details[$i]['training_provider'])?></td>
                                                    <td><a href="<?php echo SURL; ?>training-log/edit-training-log/<?php echo filter_string($training_log_details[$i]['id'])?>" class="btn btn-xs btn-primary fancybox_view fancybox.ajax"><i class="fa fa-pencil"></i> Edit</a></td>
                                                </tr>
                                    <?php
                                            }//end for($i=0;$i<count($training_log_details); $i++)
                                        }else{
                                    ?>
                                        <tr>
                                            <td colspan="3" class="text-danger">No record found.</td>
                                        </tr>
                                    <?php
                                        }//end if(count($training_log_details) > 0)
                                    ?>
                                    
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                    
                    <div class="panel panel-success"> 
                        <div class="panel-heading"><strong>Add New Training Record</strong></div>
                        <div class="panel-body">
                            <div class="row">
                            	<form data-toggle="validator" role="form" action="<?php echo SURL?>training-log/add-edit-training-log-process" method="post" name="trainig_log_frm" id="p_trainig_log_frm" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                        <div class="form-group  has-feedback">
                                              <label id="" >Date<span class="required">*</span></label>
                                             <input type="text" id="date_completed" name="date_completed" value="<?php echo date('d/m/Y');?>" class="form-control  hasDatepicker date-picker" readonly="readonly" />
                                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                              <div class="help-block with-errors"></div>
                                            </div>
                                        <div class="form-group  has-feedback">
                                          <label id="" >Training Course Name <span class="required">*</span></label>
                                          <input type="text" class="form-control" name="course_name" id="course_name" value="" required />
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group  has-feedback">
                                          <label id="" >Training Provider<span class="required">*</span></label>
                                          <input type="text" class="form-control" name="training_provider" id="training_provider" value="" required />
                                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                              <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group  has-feedback">
                                          <label id="" >Qualification of Training</label>
                                          <textarea class="form-control" name="qualification_of_training" id="qualification_of_training"></textarea>
                                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                              <div class="help-block with-errors"></div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group  has-feedback">
                                          <label id="" >Subject of Training<span class="required">*</span></label>
                                          <input type="text" class="form-control" name="subject_of_training" id="subject_of_training" value="" required />
                                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                              <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group  has-feedback">
                                          <label id="" >Notes on Subject</label>
                                          <textarea class="form-control" name="notes_on_subject" id="notes_on_subject"></textarea>
                                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                              <div class="help-block with-errors"></div>
                                        </div>
                                        
                                        <div class="form-group  has-feedback">
                                          <label id="" >Useful Weblinks</label>
                                          <textarea class="form-control" name="useful_weblinks" id="useful_weblinks" ></textarea>
                                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                              <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group has-feedback">
                                          <label id="">Have you performed a CPD cycle on this topic? </label> <br />
                                          <label style="font-weight:normal"><input type="radio" name="performed_cpd" value="yes" /> Yes</label>
                                          <label style="font-weight:normal"><input type="radio" name="performed_cpd" value="no" checked="checked" /> No</label>
                                        </div>
                                        <div class="form-group  has-feedback">
                                          <label id="" >Useful Files</label>
                                          <input class="form-control" type="file" name="useful_file1" style="padding-bottom:40px; margin-bottom:5px;" />
                                          <input class="form-control" type="file" name="useful_file2" style="padding-bottom:40px; margin-bottom:5px;"/>
                                          <input class="form-control" type="file" name="useful_file3" style="padding-bottom:40px; margin-bottom:5px;"/>
                                            <p>
                                                <i>- <strong>Allowed Extensions:</strong> jpg, jpeg, png, gif, doc, docx, xls, xlsx, pdf, ppt, pptx</i><br>
                                                <i>- <strong>Maximum Size Allowed:</strong> 5MB</i><br />
                                                <i>Invalid file format and large files will be automatically excluded</i>
                                            </p>                                          
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                          <button type="submit" class="btn btn-sm btn-success"  id="trainig_log_btn" name="trainig_log_btn"> Add New </button>
                                    </div>
                                </form>
                            </div>                                                        
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>