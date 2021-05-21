<!-- Start - update Manager -->

<div class="nav nav-bar col-sm-12 col-md-12 col-lg-12" id="hello_div">
  <div class="row">
    <div class="col-sm-6 col-md-12 col-lg-12">
      <h4><?php echo (!$get_category_data) ? 'Add New Folder' : 'Edit Folder'?></h4>
    </div>
  </div>
  <br />
  <div class="row col-sm-6 col-md-12 col-lg-12">
    <form data-toggle="validator" role="form" action="<?php echo SURL?>organization/edit-sop-category-process" method="post"  name="add_edit_sop_cat_frm" id="add_edit_sop_cat_frm" >
      <div class="col-sm-6 col-md-12 col-lg-12">
        <div class="form-group has-feedback ">
          <label id="first_name" >Folder Name<span class="required">*</span></label>
          <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name" value="<?php echo filter_string($get_category_data['category_name']);?>" required="required"/>
          <span class="glyphicon form-control-feedback" style="width:10%" aria-hidden="true"></span>
		  <div class="help-block with-errors"></div>
        </div>
        <div class="form-group pull-right">
          <button type="submit" class="btn btn-sm btn-success btn-default "  name="update_category_btn" id="update_category_btn"> <?php echo (!$get_category_data['id']) ? 'Add New Folder' : 'Edit Folder'?></button>
          <input type="hidden" name="organization_id" id="organization_id" value="<?php echo $my_organization_id;?>" readonly="readonly"/>
          <input type="hidden" name="category_id" id="category_id" value="<?php echo filter_string($get_category_data['id']);?>" readonly="readonly"/>
        </div>
      </div>
    </form>
  </div>
</div>
<script>

if($('#add_edit_sop_cat_frm').html())
	$('#add_edit_sop_cat_frm').validator();	

</script>