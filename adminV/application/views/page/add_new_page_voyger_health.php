<?php
	//Tabs Variables
	$cms_class = 'active';
	$cms_class_div = 'active in';
?>

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
        <?php if($get_page_details_voyger_health['id']==""){?>
			<h2>Add New Page Voyger Health <small>Add New Page Voyger Health</small></h2>
			 <?php } else {?>
             <h2>Update Page Voyger Health  <small>Update Page Voyger Health </small></h2>
             <?php }?>
			<div class="clearfix"></div>
			</div>
        <form data-toggle="validator" role="form"   id="add_new_page_frm" name="add_new_page_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>page/add-new-page-voyger-health-process">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="<?php echo $cms_class?>"><a href="#cms_tab" id="cms-tab" role="tab" data-toggle="tab" aria-expanded="true">CMS</a> </li>
              <li role="presentation" class="<?php echo $seo_class?>"><a href="#seo_tab" role="tab" id="seo-tab" data-toggle="tab" aria-expanded="false">SEO</a> </li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade <?php echo $cms_class_div?>" id="cms_tab" aria-labelledby="cms-tab">
                <div class="form-group  has-feedback">
                  <label for="page-title">Page Title<span class="required">*</span> </label>
                  <div class="col-md-12 col-sm-6 col-xs-12 validate_msg">
                    <input type="text" id="page_title" name="page_title" required="required" class="form-control" value="<?php echo filter_string($get_page_details_voyger_health['page_title'])?>">
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				   <div class="help-block with-errors"></div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label>Page Description</label>
                  <textarea class="ckeditor editor1" id="page_description" name="page_description" rows="14"><?php echo filter_string($get_page_details_voyger_health['page_description'])?></textarea>
                </div>
                <div class="form-group validate_msg">
                  <label for="middle-name">Status<span class="required">*</span> </label>
                  <select name="status" id="status"  required="required" class="form-control">
                 	 <option value="1" <?php echo ($get_page_details_voyger_health['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                 	 <option value="0" <?php echo ($get_page_details_voyger_health['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                  </select>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane fade <?php echo $seo_class_div?>" id="seo_tab" aria-labelledby="seo-tab">
                <div class="form-group">
                  <label for="middle-name">Meta Title:</label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <input type="text" id="meta_title" name="meta_title"  class="form-control col-md-7 col-xs-12" value="<?php echo  filter_string($get_page_details_voyger_health['meta_title'])?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name">Meta Keywords:</label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <textarea class="form-control" rows="3" placeholder="Meta Keywords" name="meta_keywords" id="meta_keywords"><?php echo filter_string($get_page_details_voyger_health['meta_keywords'])?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name">Meta Description:</label>
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <textarea class="form-control" rows="3" placeholder="Meta Description" name="meta_description" id="meta_description"><?php echo filter_string($get_page_details_voyger_health['meta_description'])?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <?php if($get_page_details_voyger_health['id']){?>
              <button type="submit" class="btn btn-success" name="new_page_btn" id="new_page_btn">Update</button>
              <input type="hidden" name="page_id" id="page_id" value="<?php echo filter_string($get_page_details_voyger_health['id'])?>" />
              <?php }else{?>
              <button type="submit" class="btn btn-success" name="new_page_btn" id="new_page_btn">Submit</button>
              <?php }//end if($get_page_details_voyger_health['id'])?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
