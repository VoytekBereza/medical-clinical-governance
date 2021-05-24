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
    <!-- user type badges -->
    <div class="row col-sm-12 col-md-12 col-lg-12">
        <div class="col-md-2">
          <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD">All <span class="badge" id="all"><?php echo $list_all_active_pgds;?></span></a>
        </div>
         <div class="col-md-2">
          <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/10">Peads Travel <span class="badge"><?php echo $count_list_pgds_peads_travel;?></span></a>
        </div>
         <div class="col-md-2">
          <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/11">Adult Travel <span class="badge"><?php echo $count_list_pgds_adult_travel;?></span></a>
        </div>
         <div class="col-md-3">
          <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/15">Seasonal Flu 2015 <span class="badge"><?php echo $count_list_pgds_seasonal_flu_15;?></span></a>
        </div>
        
         <div class="col-md-3">
          <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/16">Seasonal Flu 2016 <span class="badge"><?php echo $count_list_pgds_seasonal_flu_16;?></span></a>
        </div>
    </div>
    <br /> <br /> <br /> <br />
   <h2 class="col-md-12">TRAINING</h2>  
   
    <?php if($list_all_active_trainings){
		  $i=1;	
		  $x=0;
		   $all_training  = list_avicena_trainging(); 
   ?>
      <?php 	foreach($list_all_active_trainings as $each){
		  					  
			  	 $count_traingin  = list_avicena_trainging($each['id']); 
		  		if($i ==1){
	  ?>
       	<br /> <br />         
        <div class="row col-sm-12 col-md-12 col-lg-12 pull-left">
             <?php } if($x==0){?>    
             
               <div class="col-md-3">
                  <a href="<?php echo SURL?>avicenna/list-avicenna-training/all"> All Training <span class="badge"><?php echo count($all_training);?></span></a>
                </div>
                <?php } else {?>
                
                <div class="col-md-3">
                  <a href="<?php echo SURL?>avicenna/list-avicenna-training/<?php echo $each['id'];?>"> <?php echo filter_string($each['course_name']);?> <span class="badge"><?php echo count($count_traingin);?></span></a>
                </div>
          <?php  } if($i ==4){  $i=0; ?>  
            </div>
            
             <?php } ?>
     <?php 
	  			$i++;
				$x++;
				}// end foreach loop
	  		}// end if(!$empty($list_all_active_trainings))
	  ?>
  
    <!--<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <select id="training_id" name="training_id" class="form-control active_training">
      <option value=""> Select Training </option>
      <option value="all">All</option>
      <?php if($list_all_active_trainings){?>
      
      <?php 	foreach($list_all_active_trainings as $each){?>
      
	 			<option value="<?php echo $each['id'];?>"> <?php echo filter_string($each['course_name']);?></option>
      <?php 
	  			}// end foreach loop
	  		}// end if(!$empty($list_all_active_trainings))
	  ?>
     </select>
    </div>-->
    <form data-toggle="validator" role="form" id="change_pass_frm" name="change_pass_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>avicenna/download-csv-file-training">
    <div class="animated flipInY my_class col-lg-4 col-md-4 col-sm-6 col-xs-6 hidden">
     <input type="hidden" name="product_id" id="product_id" value=""> 
     <button type="submit" class="btn btn-success" name="new_training_btn" id="new_training_btn">Export Csv</button>    
    </div>
   </form>
    <p><div class="row"></div></p>
  </div>  
</div>
