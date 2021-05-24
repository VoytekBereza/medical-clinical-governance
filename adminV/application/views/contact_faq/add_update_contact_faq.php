<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php
            }//end if($this->session->flashdata('err_message'))
            
            if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="x_title">
         <?php if($get_contact_faq_details['id']==""){?>
			<h2>Add Contact Faqs <small>Add New Contact Faqs</small></h2>
			 <?php } else {?>
            <h2>Update Contact Faqs <small>Update Contact Faqs</small></h2>
            <?php }?>
			<div class="clearfix"></div>
			</div>
        <form  data-toggle="validator" role="form" id="add_new_contact_frm" name="add_new_contact_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>contactfaq/add-update-contact-faq-process">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          	<div class="form-group has-feedback">
                            	<label>Faqs Question<span class="required">*</span> </label>
                           		 <input type="text" id="faq_question" name="faq_question" required="required" class="form-control" value="<?php echo filter_string($get_contact_faq_details['faq_question'])?>">
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"></div>
                           </div>
                        <div class="form-group">
                            <label>Faqs Answer</label>
                            <textarea class="ckeditor editor1" id="faq_answer" name="faq_answer" rows="14"><?php echo filter_string($get_contact_faq_details['faq_answer'])?></textarea>
                		</div>
                          <div class="form-group validate_msg">
                              <label for="middle-name">Status<span class="required">*</span> </label>
                              <select name="status" id="status"  required="required" class="form-control">
                                      <option value="1" <?php echo ($get_contact_faq_details['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                                      <option value="0" <?php echo ($get_contact_faq_details['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                              </select>
                        </div>                       
                       </div>
                       <div class="row"></div>
          				 <div class="ln_solid"></div>
          				 <div class="form-group">
                         	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
             					 <?php if($get_contact_faq_details['id']){?>
             				 			<button type="submit" class="btn btn-success" name="new_contact_faq_btn" id="new_contact_faq_btn">Update</button>
              							<input type="hidden" name="faq_id" id="faq_id" value="<?php echo filter_string($get_contact_faq_details['id'])?>" />
             				 <?php }else{?>
              							<button type="submit" class="btn btn-success" name="new_contact_faq_btn" id="new_contact_faq_btn">Submit</button>
              				<?php }//end if($get_contact_faq_details['id'])?>
            		</div>
          	  </div>
          </div>          		
        </form>
      </div>
    </div>
  </div>
</div>

