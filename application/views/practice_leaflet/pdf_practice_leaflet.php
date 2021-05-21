<?php if($practice_leaft_list){ ?>
<style>
	#leaf_container {
		font-size:12px;	
		font-family:Arial, Helvetica, sans-serif;
	}
	
	#leaf_container .column {
		width:300px; 
		padding:10px; 
		float:left;
		text-align:justify;
	}
</style>
<div style="width:1000px" id="leaf_container">
  <div class="column"><?php echo filter_string($practice_leaft_list['ccg_contact']); ?></div>
  <div class="column"><?php echo filter_string($practice_leaft_list['nhs_services']); ?></div>
    <div class="column"><?php echo filter_string($practice_leaft_list['other_services']); ?> <br />
    <br />
    <br />
    <br />
    <br />
    <br />
     <br />
     
      <br /> <br /> <br /> <br /><br /> <br />
    <div style="font-family:Arial, Helvetica, sans-serif; float:right; font-size:22px"> <strong>
      <?php if($practice_leaft_list['pharmacy_name'] !='') {echo filter_string($practice_leaft_list['pharmacy_name']);}?>
      </strong> </div>
    <br />
    <div style="float:right; font-size:22px"> <img src="<?php echo IMAGES?>pharmacy.jpg" width="300px;" /> </div>
    <br />
    <div style="font-family:Arial, Helvetica, sans-serif; float:right;">
      <?php if($practice_leaft_list['pharmacy_address'] !='') {echo filter_string($practice_leaft_list['pharmacy_address']);}?>
      <br />
      <?php if($practice_leaft_list['pharmacy_ho_address'] !='') {echo filter_string($practice_leaft_list['pharmacy_ho_address']);}?>
      <br />
      <?php if($practice_leaft_list['postcode'] !='') {echo filter_string($practice_leaft_list['postcode']);}?>
      <br />
      Telephone
      <?php if($practice_leaft_list['telephone'] !='') {echo filter_string($practice_leaft_list['telephone']);}?>
      <br />
      <?php if($practice_leaft_list['website'] !='') {echo filter_string($practice_leaft_list['website']);}?>
    </div>
    <br />
    <div style="font-family:Arial; float:right;">
      <div style="float:right;"> <strong>OPENING HOURS</strong> </div>
    </div>
    <br />
    <div style="font-family:Arial, Helvetica, sans-serif; float:right; ">
      <div style="font-family:Arial, Helvetica, sans-serif; float:right;"> <strong>Monday - Friday</strong>
        <?php if($practice_leaft_list['opening_hours'] !='') {echo filter_string($practice_leaft_list['opening_hours']);}?>
      </div>
    </div>
    <div style="font-family:Arial, Helvetica, sans-serif; float:right;"> <strong>Saturday</strong>
      <?php if($practice_leaft_list['Saturday_time'] !='') {echo filter_string($practice_leaft_list['Saturday_time']);}?>
    </div>
    <br />
     <div style="font-family:Arial, Helvetica, sans-serif; float:right;"> <strong>Access arrangemens for disabled customers</strong><br />
     <?php echo filter_string($practice_leaft_list['disabled_customers']); ?>
      
    </div>
    
    <br />
    <div style="font-family:Arial, Helvetica, sans-serif; float:right;"> <strong>Your Pharmacist:</strong> <br />
      <?php if($practice_leaft_list['pharmacist_name'] !='') {echo filter_string($practice_leaft_list['pharmacist_name']);}?>
    </div>
    <br />
    <div style="font-family:Arial, Helvetica, sans-serif; float:right;"> <strong>This pharmacy is owned by:</strong> </div>
    <br />
    <div style="font-family:Arial, Helvetica, sans-serif; float:right;">
      <?php if($pharmacy_details['pharmacy_surgery_name'] !='') {echo filter_string($pharmacy_details['pharmacy_surgery_name']);}?>
      <br />
       <?php if($pharmacy_details['address'] !='') {echo filter_string($pharmacy_details['address']);}?>
       <br />
       <?php if($pharmacy_details['postcode'] !='') {echo filter_string($pharmacy_details['postcode']);}?>
       <br /> <br />
       <div style="float:right;"> <img src="<?php echo IMAGES?>leaf.png"/> </div>
    </div>
    <br />
    </div>
  
  <!--<div style="font-family:Arial, Helvetica, sans-serif; float:left;"><?php echo filter_string($practice_leaft_list['disabled_customers']); ?></div>--> 
</div>

<?php	    
      } // if($practice_leaft_list)
 ?>
