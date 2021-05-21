<?php 

	$active_tab = $this->input->get('t');
	
	$COMPLAINT_BLUE_TEXT = 'COMPLAINT_BLUE_TEXT';
	$complaint_blue_text = get_global_settings($COMPLAINT_BLUE_TEXT); //Set from the Global Settings
	$complaint_blue_text = filter_string($complaint_blue_text['setting_value']);


?>
<div class="panel panel-default"> 
	<div class="panel-heading"><strong>Complaints Manager</strong></div>
    <div class="panel-body">
        
        <div class="row">
          <div class="col-md-12">

			<?php 
                if(!$this->session->dismiss_message['complaint']){
			?>
                    <p class="alert alert-info in alert-dismissable">
                        <a href="#" data-pharmacy="" data-org="<?php echo $this->session->organization_id?>" data-type="complaint" class="close dismiss_message" data-dismiss="alert" aria-label="close" title="close">×</a>
                        <i class="fa fa-info-circle"></i> <?php echo $complaint_blue_text; ?>
                    </p>
            <?php			
				}//end if(!$this->session->dismiss_message['complaint'])
            ?>
          
            
          
            <ul class="nav nav-tabs">
              <li class="<?php if($active_tab =="") { echo 'active';} else { echo '';}?>"><a data-toggle="tab" href="#introduction_tab">Introduction</a></li>
              <li class="<?php if($active_tab !="" && $active_tab ==2) { echo 'active';} else { echo '';}?>"><a data-toggle="tab" href="#complaints_tab">Complaints</a></li>
              <li class="<?php if($active_tab !="" && $active_tab ==3) { echo 'active';} else { echo '';}?>"><a data-toggle="tab" href="#email_form">Email Form</a></li>
              <li><a data-toggle="tab" href="#link_form">Link to Form</a></li>
              <li><a data-toggle="tab" href="#embed_form">Embed Form </a></li>
            </ul>
            <div class="tab-content">
              <div id="introduction_tab" class="tab-pane fade in <?php if($active_tab =="") { echo 'active';} else { echo '';}?>">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12"> <br />
                    <p> If a patient would like to make a complaint you have the following options, which can be selected from the above tabs:<br />
                    
                    <ol>
                      <li><strong>Complaints</strong> - Click this link to see any previous complaints and edit their progress or add a new complaint.<br />
                        &nbsp;</li>
                      <li><strong>Email Form</strong> - The second way, is to simply click the link from "Email Form Tab" and enter the patients email address, this will send them the complaints form direct to their email account.  <br />
                        &nbsp;</li>
                      <li><strong>Link to Form</strong> - Alternatively, copy the link from the "Link to Form Tab" and paste it directly into an email sent directly from your locations official email account.<br />
                        &nbsp;</li>
                      <li><strong>Embed Form</strong> -  Lastly, you can embed the complaints form on your website, just copy and paste the code from "Embed Form Tab" into a page (like yourpharmacy.com/survey) and then direct patients to that specific page on you website.<br />
                        &nbsp;</li>
                    </ol>
                    </p>
                  </div>
                </div>
              </div>
              
              <div id="complaints_tab" class="tab-pane fade <?php if($active_tab !="" && $active_tab ==2) { echo 'active in';} else { echo '';}?>">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12"> <br />
                    <table class="table table-hover table-bordered">
                    	<thead>
                    	<tr>
                        	<th class="text-center">Received</th>
                            <th class="text-center">Acknowledge</th>
                            <th class="text-center">Investigate</th>
                            <th class="text-center">Outcome</th>
                            <th class="text-center">Resolve</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($get_complaint_list)) {
								foreach($get_complaint_list as $each): 
						?>
                            	<tr>
                                <td class="text-center"><?php echo kod_date_format(filter_string($each['recevied_date'])); ?></td>
                                <td class="text-center">
                                <?php if($each['acknowledge']=='') {?>
                                <a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>complaints/add-acknowledge/<?php echo $each['id'];?>"><button class="btn btn-sm btn-danger">Add</button>
</a>
<?php } else {?>
<a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>complaints/get-acknowledge-details/<?php echo $each['id'];?>"><button class="btn btn-sm btn-warning">View</button>
</a><?php } ?>
</td>
                                <td class="text-center">
                                 <?php if($each['investigate']=='') {?>
                                <a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>complaints/add-investigate/<?php echo $each['id'];?>"><button class="btn btn-sm btn-danger">Add</button>
</a>
<?php } else {?>
<a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>complaints/get-acknowledge-details/<?php echo $each['id'];?>"><button class="btn btn-sm btn-warning">View</button>
</a><?php } ?>
</td>
                               <td class="text-center"> <?php if($each['outcome']=='') {?>
                                <a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>complaints/add-outcome/<?php echo $each['id'];?>"><button class="btn btn-sm btn-danger">Add</button>
</a>
<?php } else {?>
<a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>complaints/get-acknowledge-details/<?php echo $each['id'];?>"><button class="btn btn-sm btn-warning">View</button>
</a><?php } ?>
</td>
                                <td class="text-center">
                                <?php if($each['status'] !='1' && ($each['acknowledge']=='' || $each['investigate']=='' || $each['outcome']=='')) {?>
                                <?php echo 'Pending';?>
                                <?php } else if($each['status']=='0' && $each['acknowledge'] !='' && $each['investigate'] !='' && $each['outcome'] !=''){?>
                                <a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>complaints/resolve-complaint/<?php echo $each['id'];?>"><button class="btn btn-sm btn-danger" name="resolve_btn">Resolve</button>
</a>
<?php } else {  
			
	 $get_full_name =	get_user_details_new($each['resolve_by']);
?>
<?php echo ucfirst($get_full_name['fullname'].'<br />'.kod_date_format(filter_string($each['reslove_date'])));?>

<?php } ?>
</td>
                            </tr>
                            
						<?php 
                        		endforeach; // foreach
                        	   }  else { ?>
                        
                        <td colspan="5"> No record founded..</td>
                        
                        <?php } ?>
                            
                        </tbody>
                       
                    </table>
                  </div>
                </div>
                <div class="row text-right">
                	<div class="col-md-12">
                        <button class="btn btn-sm btn-primary">Print Report</button>
                       <!-- <button  class="btn btn-sm btn-success">Add New Complaint</button>-->
                    </div>
                </div>
              </div>
              
              
              
              <div id="email_form" class="tab-pane fade  <?php if($active_tab !="" && $active_tab ==3) { echo 'active in';} else { echo '';}?>">
                <div class="row">
                  <div class="col-md-12">
                    <p><br />
                      Click the link below and enter the patients email address, this will send them an email which contains the survey which would be delivered direct to their email account. </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                  
                    <form  data-toggle="validator" role="form" id="send_complaints_frm" name="send_complaints_frm" method="post" action="<?php echo SURL?>complaints/complaints-form-process" autocomplete="off">
                      <div class="row">
                        <div class="col-md-12"> <br />
                          <div class="form-group has-feedback">
                            <label for="friend_email_address"><strong>Email Address<span class="required">*</span></strong></label>
                            <input type="email" required="required" value="" name="email_address" id="friend_email_address"   class="form-control" pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" maxlength="30">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group has-feedback">
                            <label for="friend_message"><strong>Message<span class="required">*</span></strong></label>
                            <textarea required="required" rows="8" name="message_body" id="message_body" class="form-control"><?php echo kod_date_format(date('Y-m-d'));?>
        

Dear Valued Customer,

I am sorry to learn that you have been dissatisfied with the service we have provided and can confirm that we will be conducting a thorough investigation into your concerns. Once we have completed this, we will write to you again.

If you would like a copy of our internal Complaints Procedure please ask and we will endeavor to give you one or visit this link: http://www.nhs.uk/NHSEngland/complaints-and-feedback/Pages/nhs-complaints.aspx. In the mean time, you can file your complaints via our system using this link.

<?php echo $complaints_link = SURL.'complaints-form/register/'.$this->session->id;?>
<br />

We will review the complaint and get back to you shortly. We will be looking at whether your questions can be answered, whether you suffered any injustice or hardship, and what remedy would be fair and proportionate in the circumstances.

Lastly, if you have any queries, please do not hesitate to contact me via <?php echo $this->session->email_address;?>

Yours sincerely,


<?php echo filter_string($get_data_user['user_full_name']);?>
<br />
<?php echo filter_string($get_data_user['user_type_name']);?>
<br />
<?php echo $this->session->organization['address'];?>
</textarea>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                          </div>
                      <div class="row">
                        <div class="col-md-12">
                          <button class="btn btn-success btn-default pull-right" type="submit" id="complaints_btn" name="complaints_btn" >Send</button>
                        </div>
                      </div>
                    </form>
                    </div>
                </div>
              </div>
        
                <div id="link_form" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12">
                            <p><br />
                                Copy the link below and paste it directly into your Whatsapp, Facebook, Twitter etc and send it to groups or specific people.
                            </p>
                            <p>
                                <div class="input-group input-group-lg">
                                  <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-link"></i></span>
                                  <input type="text" class="form-control" value="<?php echo SURL?>complaints-form/register/<?php echo $this->session->id;?>" aria-describedby="sizing-addon1"  onfocus="$(this).select();" onclick="$(this).select();">
                                 
                                </div>                                                        
                            </p>                                            
                        </div>
                     </div>
                </div>
                
                <div id="embed_form" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12">
                            <p><br />
                                To embed the survey on your website, just copy and paste the code below into a page (like yourpharmacy.com/survey) and then direct patients to that specific page on you website.
                            </p>
                            <p>
                                <div class="input-group input-group-lg">
                                  <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-link"></i></span>
                                  <input type="text" class="form-control" value="<?php echo htmlentities("<iframe src='".SURL."complaints-form/register/".$this->session->id."' width='100%' height='100%' style='min-height:1500px' frameborder='0'></iframe>")?>" aria-describedby="sizing-addon1"  onfocus="$(this).select();" onclick="$(this).select();">
                                 
                                </div>                                                        
                            </p>
                        </div>
                     </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>   

<script type="text/javascript">
 $(document).ready(function() {
    $('#send_complaints_frm').formValidation({
        framework: 'bootstrap',
        icon: {
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email_address: {
                validators: {
                    notEmpty: {
                        message: 'Please fill out this fields.'
                    }
                }
            }
        }
    });
});
</script>
