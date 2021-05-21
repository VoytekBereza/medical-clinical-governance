    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add new Medicine:</h4>
        </div>
      </div>
      
      <hr />
       
      <div class="row">
        <form data-toggle="validator" role="form" action="" id="add_edit_patient_frm" name="add_edit_medicine_frm" method="post">
          <div class="col-sm-6 col-md-12 col-lg-12">
            
             <div class="form-group has-feedback">
              <label>Medicine Name<span class="required">*</span></label>
              <input type="text" class="form-control medicine_name" name="medicine_name" id="medicine_name" required="required" autofocus value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Strength<span class="required">*</span></label>
              <input type="text" class="form-control" name="strength" id="strength"required="required" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Form</label>
              <input type="text" class="form-control" name="form" id="form" value="" required>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="button" class="btn btn-sm btn-success btn-block"   name="add_med_btn" id="add_med_btn"> Add new medicine</button>
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>
<script type="text/javascript">

	$(document).ready(function(){

		$('#medicine_name').val($('#search-medicine-custom').val());

	})
	
	
	
	$('#add_edit_patient_frm').validator();
	
	//$('#add_edit_medicine_frm').validator();
	
	$('#add_med_btn').click(function(){
		
		var medicine_name = $('#medicine_name').val();
		var medicine_strength = $('#strength').val();
		var medicine_form = $('#form').val();

		var data = new Array();
		data.push({name: 'medicine_name', value: medicine_name});	
		data.push({name: 'medicine_strength', value: medicine_strength});	
		data.push({name: 'medicine_form', value: medicine_form});
	
		// Call ajax to load more Blog POST on Ready
		$.ajax({
		
		  type: "POST",
		  url: SURL + "pmr/add-new-medicine-process-ajax",
		  data: data,
		  beforeSend : function(result){
			//$('.overlay_loading_custom').removeClass('hidden');
		  },
		  success: function(data){
			var obj = JSON.parse(data);
			
			if(obj.success == 1){
				$.fancybox.close();
				//$('#search-medicine-custom').keyup();
			}

		  }
		}); // $.ajax
		
		
	})
	
</script>