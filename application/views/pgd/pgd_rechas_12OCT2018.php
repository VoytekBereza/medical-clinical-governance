<div class="panel panel-default">
  <div class="panel-heading"><strong>To use our online PGD, you first need to agree to the following:</strong></div>
  <div class="panel-body">
    <form action="<?php echo SURL?>pgd/rechas-submit-process" method="post" enctype="multipart/form-data" name="rechas_frm" id="rechas_frm">
      <?php 
                for($i=0;$i<count($pgd_rechas_list_arr);$i++){
            ?>
      <div class="row">
        <div class="col-md-11">
          <p>
            <label style="font-weight:normal" for="rechas_option_<?php echo filter_string($pgd_rechas_list_arr[$i]['id']);?>"><?php echo nl2br(filter_string($pgd_rechas_list_arr[$i]['rechas_description']))?></label>
          </p>
        </div>
        <div class="col-md-1">
          <input type="radio" name="rechas_option" required id="rechas_option_<?php echo filter_string($pgd_rechas_list_arr[$i]['id']);?>" />
        </div>
      </div>
      <?php		
                }//end for($i=0$i<count($pgd_rechas_list_arr);$i++)
            ?>
      <div class="row">
        <div class="col-md-12">
          <label class="error" id="option_error"></label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-11">
          <p>
            <label style="font-weight:normal" for="terms_option">I agree to the Hubnet <a href="<?php echo SURL?>pages/terms--conditions" target="_blank">Terms &amp; Conditions</a>.</label>
          </p>
        </div>
        <div class="col-md-1">
          <input type="radio" name="terms_option" id="terms_option" required />
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label class="error" id="error_terms"></label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p class="text-right">
            <button type="submit" id="rechas_sbt" name="rechas_sbt" class="btn btn-success btn-sm"> Submit</button>
          </p>
        </div>
      </div>
      <input type="hidden" readonly="readonly" name="pgd_id" id="pgd_id" value="<?php echo filter_string($pgd_detail_arr['id'])?>" />
      <input type="hidden" name="renew" value="<?php echo $renew?>" readonly="readonly" />
    </form>
  </div>
</div>
<script>

//Rechas Validations on PGD Certifictae
$("#rechas_sbt").click(function(){

	$is_rechas_checked = $("input:radio[name='rechas_option']").is(":checked")
	
	if(!$is_rechas_checked){
		
		$('#option_error').html('Error: Please Select one of the option from above to proceed!');
		return false;
	}else{
		$('.error').html('');
		
		$is_terms_checked = $("input:radio[name='terms_option']").is(":checked")
		
		if(!$is_terms_checked){
			$('#error_terms').html('Error: You must accept Terms and Conditions to proceed.');
			return false;
		}else{
			$('#option_error').html('');
			$('#error_terms').html('');
			return true;	
		}//end if(!$is_terms_checked)
		
	}//end if(!$is_rechas_checked)

});
</script>