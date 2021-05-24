<div class="">
  <div class="row top_tiles">
  <br /> 
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php } // end if($this->session->flashdata('err_message')) ?>
        <?php if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
         
    <h2 class="col-md-12">PGDs</h2>
    
    
    <a href="<?php echo SURL?>avicenna/download-csv-file-all-avicenna-pgds/PGD">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"> </div>
        <div class="count" style="font-size:16px;"><?php echo $list_all_active_pgds;?></div>
        <h5 style="padding-left:10px;">All</h5>
      </div>
    </div>
    </a>
    
     <?php 
	 	if($list_all_active_pdgs){
			foreach($list_all_active_pdgs as $each){  
	?>
     
            <a href="<?php echo SURL?>avicenna/download-single-avicenna-pgd-csv/<?php echo $each['id']?>/PGD">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="tile-stats">
                    <div class="icon"><!--<i class="fa fa-users" style="font-size:30px; padding-bottom:10px; padding-left:20px;"></i> --></div>
                    <div class="count" style="font-size:16px;"><?php echo count_all_avicenna_purchased_pgds($each['id']);?></div>
                    <h5 style="padding-left:10px;">Total <?php echo filter_string($each['pgd_name']);?></h5>
                  </div>
                </div>
            </a>
    <?php 
			}// end foreach loop
		}// end if(!$empty($list_all_active_trainings))
 ?>
  </div>
  
  </div>
