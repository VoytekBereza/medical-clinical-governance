<!-- Start - update Manager -->

<div class="nav nav-bar col-sm-12 col-md-12 col-lg-12" id="hello_div">
  <div class="row">
    <div class="col-sm-6 col-md-12 col-lg-12">
		<h4><?php echo (strlen($add_new_sop) > 0) ? 'Add New File' : 'Edit File'?></h4>
    </div>
  </div>
  <br />
  <div class="row col-sm-6 col-md-12 col-lg-12">
    <form action="<?php echo SURL?>organization/edit-organization-sop-process" method="post"  name="add_edit_org_sop" id="add_edit_org_sop" >
      <div class="col-sm-6 col-md-12 col-lg-12">
        <div class="form-group ">
          <label id="first_name" >SOP Title<span class="required">*</span></label>
          <input type="text" class="form-control" name="sop_title" id="sop_title" placeholder="SOP Title" value="<?php echo filter_string($sop_detail_arr['sop_title']);?>" required/>
        </div>
        <div class="form-group ">
          <label id="sop_category" >SOP Category<span class="required">*</span></label>
            <select name="category_id" id="sop_category_id" class="form-control" <?php echo (strlen($add_new_sop) > 0) ? 'disabled="disabled"' : '' ?>>
            	<?php 
					for($i=0;$i<count($sop_category_list);$i++){
				?>
                		<option value="<?php echo filter_string($sop_category_list[$i]['id'])?>" <?php echo ($sop_category_list[$i]['id'] == $sop_category_id) ? 'selected="selected" ' : ''?>  ><?php echo filter_string($sop_category_list[$i]['category_name'])?></option>
                <?php		
					}//end for($i=0;$i<count($sop_category_list);$i++)
				?>
            </select>
         
        </div>
        
        <div class="form-group ">
          <label id="sop_category" >Select Users<span class="required">*</span></label>
          <p>
          	<?php 
				$sop_user_type_arr = explode(',',filter_string($sop_detail_arr['user_types']));
				
				for($i=0;$i<count($usertype_active_arr);$i++){
			?>
            		<label id="user_<?php echo filter_string($usertype_active_arr[$i]['id'])?>"><input name="user_types[]" id="user_types_<?php echo filter_string($usertype_active_arr[$i]['id'])?>" value="<?php echo filter_string($usertype_active_arr[$i]['id'])?>" type="checkbox" <?php echo (in_array($usertype_active_arr[$i]['id'],$sop_user_type_arr)) ? 'checked="checked"' : '';?> > <?php echo filter_string($usertype_active_arr[$i]['user_type']);?> </span></label>&nbsp;&nbsp;&nbsp;
            <?php		
				}//end for($i=0$i<count($usertype_active_arr)$i++)
			?>
          </p>
          

        </div>
        <div class="form-group">
          <label>SOP Details (Optional)</label>
          <p><textarea class="textarea" name="sop_edit_text" id="sop_edit_text" placeholder="Enter SOP Description" style="width: 100%; height: 200px"><?php echo filter_string($sop_detail_arr['sop_description'])?></textarea></p>
        </div>
        
		<div class="form-group pull-right">
			<button type="submit" class="btn btn-sm btn-success btn-default btn-block"  name="update_sop_btn" id="update_sop_btn"> <?php echo (strlen($add_new_sop) > 0) ? 'Add SOP' : 'Update SOP'?></button>
			<input type="hidden"  name="sop_id" id="sop_id" value="<?php echo filter_string($sop_detail_arr['id']);?>" readonly="readonly"/>
            <input type="hidden"  name="organization_id" id="organization_id" value="<?php echo $my_organization_id;?>" readonly="readonly"/>
            <input type="hidden"  name="add_new_sop" id="add_new_sop" value="<?php echo $add_new_sop;?>" readonly="readonly"/>
            <input type="hidden"  name="old_usertypes" id="old_usertypes" value="<?php echo filter_string($sop_detail_arr['user_types']);?>" readonly="readonly"/>
            <input type="hidden"  name="add_new_category_id" id="add_new_category_id" value="<?php echo filter_string($sop_category_id);?>" readonly="readonly"/>
            
            
        </div>
		
      </div>
    </form>
  </div>
</div>

<script>
	if($('#add_edit_org_sop').html()){

		    $('#add_edit_org_sop').formValidation({
		        framework: 'bootstrap',
		        icon: {
		            valid: 'glyphicon glyphicon-ok',
		            invalid: 'glyphicon glyphicon-remove',
		            validating: 'glyphicon glyphicon-refresh'
		        },
		        fields: {
					 'user_types[]': {
		                validators: {
		                    notEmpty: {
		                        message: 'Please specify at least one checkbox'
		                    }
		                }
		            },
		            sop_title: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
		           
		            category_id: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please select an item in the list.'
		                    }
		                }
		            },
					sop_category_name_text: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            }
					
		        }
		    });

		} // end - if
</script>