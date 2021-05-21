<?php
	if($this->session->flashdata('err_message')){
?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
<?php
	}//end if($this->session->flashdata('err_message'))
	
	if($this->session->flashdata('ok_message')){
?>
	<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php 
		}//if($this->session->flashdata('ok_message'))
?>

<h3><?php echo filter_string($page_data['page_title']);?></h3>
<hr />
<p> <?php echo filter_string($page_data['page_description']);?>  </p><br>

<?php if($contact_faqs_arr){?>
    <div class="panel-group" id="accordion">
      <?php for($i=0;$i<count($contact_faqs_arr);$i++){?>
      
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title" style="font-size:14px">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i?>"><?php echo filter_string($contact_faqs_arr[$i]['faq_question']);?>
                </a><i class="indicator glyphicon glyphicon-chevron-up  pull-right"></i>
              </h4>
            </div>
            <div id="collapse_<?php echo $i?>" class="panel-collapse collapse">
              <div class="panel-body"><?php echo filter_string($contact_faqs_arr[$i]['faq_answer']);?></div>
            </div>
          </div>
      
      <?php }//end for($i=0;$i<count($contact_faqs_arr);$i++)?>
    </div>
<?php }//end if($contact_faqs_arr)?>

<form  data-toggle="validator" role="form" method="post" name="contactus_frm" id="contactus_frm" action="<?php echo SURL?>contactus/contactus-process">
  <input type="hidden" value="1" name="regnow">
  <div class="form-group has-feedback">
    <label for="emailaddress">Email address<span class="required">*</span></label>
    <input type="email" placeholder="Email address" name="email_address" id="email_address"  required="required" value="<?php echo $session_data['email_address'];?>" title="" data-placement="bottom" class="form-control" pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" maxlength="255">
    
     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     <div class="help-block with-errors"></div>
  </div>
  <div class="form-group has-feedback">
    
    <label for="comments">Comments<span class="required">*</span></label>
    <textarea rows="3" placeholder="Comments" name="comments" id="comments" class="form-control" required="required" ></textarea>
  	
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>
    
  </div>
	<div class="form-group">
        <div class="g-recaptcha" data-sitekey="6LdasR4TAAAAAIIucnPPHLt6TNFQsPz9Kdk6q0hj"></div>
      </div>
  <button class="btn btn-success marg2" type="submit" name="contact_sbt" id="contact_sbt">Submit</button>
</form>


<script>
	function toggleChevron(e) {
		$(e.target)
			.prev('.panel-heading')
			.find("i.indicator")
			.toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}//end toggleChevron(e) 
	
	$('#accordion').on('hidden.bs.collapse', toggleChevron);
	$('#accordion').on('shown.bs.collapse', toggleChevron);
</script>

