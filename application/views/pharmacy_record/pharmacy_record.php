<?php 
	if($this->session->pmr_org_pharmacy){ 

?>
<div class="row">
      <div class="col-md-12">
        
        <div class="row">
              <div class="col-md-12">
              <?php 
			  	if(filter_string($pharmacy_data['f_code'])){
			?>
	              	<iframe width="100%" height="800" frameborder="0" scrolling="auto" src="https://www.pharmdata.co.uk/vm_select.php?query=<?php echo filter_string($pharmacy_data['f_code'])?>"></iframe>

            <?php		
				}else{
					$no_odc_message = str_replace('[PHARMACY_NAME]',  ucwords(filter_string($pharmacy_data['pharmacy_surgery_name'])),$no_odc_message['page_description']);
					echo filter_string($no_odc_message);
				}//end if(filter_string($pharmacy_data['f_code']))
			?>
              </div>
            </div>
      </div>
    </div>

<?php } else { ?>

    <div class="row">
    
        <div class="col-sm-8 col-md-8 col-lg-8">
            <h3>NHS Data</h3>
        </div>
    </div>
    
    <div class="well">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="text-warning"> Note! It looks like you work in multiple pharmacies/ clinic. Please choose pharmacy/ clinic you want to work with from the dropdown above. </h4>
                 <p><img src="<?php echo IMAGES?>nopharmacy.gif" /></p>
            </div>
        </div>
    </div>

<?php } ?>

<script>
$("#record2_frame").load(function() {
	//alert('asdsa');
    $(this).height( $(this).contents().find("body").height() );
});
</script>