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
<!-- Start - update Manager -->

<div class="nav nav-bar col-sm-12 col-md-12 col-lg-12" id="hello_div">
  <div class="row">
    <div class="col-sm-6 col-md-12 col-lg-12">
      <h4>Edit HR Document</h4>
    </div>
  </div>
  <br />
  <div class="row col-sm-6 col-md-12 col-lg-12">
    <form action="<?php echo SURL?>organization/edit-organization-hr-process" method="post" class="form_validate" >
      <div class="col-sm-6 col-md-12 col-lg-12">
        
        <div class="form-group validate_msg">
          <label>HR Document</label>
          <p><textarea class="textarea" name="hr_edit_text" id="hr_edit_text" placeholder="Enter SOP Description" style="width: 100%; height: 200px"><?php echo filter_string($org_hr_detail_arr['hr_text'])?></textarea></p>
        </div>
        
        <div class="form-group pull-right">
          <button type="submit" class="btn btn-sm btn-success btn-block"  name="update_hr_btn" id="update_hr_btn"> Update</button>
          <input type="hidden"  name="hr_id" id="hr_id" value="<?php echo filter_string($org_hr_detail_arr['id']);?>" readonly="readonly"/>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
	//Tiny editor
	$(function() {

		tinymce.init({
			selector: "#hr_edit_text",
			menubar: 'edit insert table tools',
			theme: "modern",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern imagetools"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	
	});

	});
</script>
