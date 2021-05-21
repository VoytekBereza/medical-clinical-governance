<!-- Start - update Manager -->
<div class="nav nav-bar col-sm-12 col-md-12 col-lg-12" id="hello_div">
  <!--<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <h4><?php echo filter_string($organization_sop_detail['sop_title'])?></h4>
    </div>
  </div>-->
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <p>
	  	<?php 
			if(filter_string($user_signatures['signature_type']) == 'svn')
				$signature_str = filter_string($user_signatures['signature']);
			elseif(filter_string($user_signatures['signature_type']) == 'image')
				$signature_str = "<img src='".filter_string($user_signatures['signature'])."' width='200px' height='60px' />";

			$search_arr = array('[USER_SIGNATURE]','[CONTRACT_NO]','[SIGNED_DATE_TIME]','[SURL]');
			$replace_arr = array($signature_str,strtoupper(random_number_generator(16)),'Signed at '.date('G:i').' on '.date('d/m/y').' by',SURL);
			$sop_description = str_replace($search_arr,$replace_arr,filter_string($organization_sop_detail['sop_description']));
			echo $sop_description;
		?>
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 text-right">
      <?php if($user_signatures['signature_type']){?>
      <p>
        <button class="btn btn-warning" onClick="javascript:mark_sop_as_read('<?php echo $organization_sop_detail['id']?>','<?php echo $pharmacy_surgery_id?>');"> Agree and Sign</button>
      </p>
      <?php }else{?>
      <div class="alert alert-danger">You need to add your Signatures from your <a href="<?php echo SURL?>dashboard/settings#sign_pane">Settings</a> to Read and Sign the SOP</div>
      <?php
      }//end if
      ?>
    </div>
  </div>
  <div class="row">
      <div class="row col-sm-8 col-md-8 col-lg-8">
          <?php 
    			?>
      </div>
  </div>
</div>