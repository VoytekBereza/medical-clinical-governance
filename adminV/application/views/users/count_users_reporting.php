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
    
    
    <a href="<?php echo SURL?>users/download-csv-file-all-pgds/PGD">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"> </div>
        <div class="count" style="font-size:16px;"><?php echo $list_all_active_pgds;?></div>
        <h5 style="padding-left:10px;">All</h5>
      </div>
    </div>
    </a>
    
     <?php if($list_all_active_pdgs){?>
    
     <?php 	foreach($list_all_active_pdgs as $each){  ?>
     
            <a href="<?php echo SURL?>users/download_single_pgd_csv/<?php echo $each['id']?>/PGD">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><!--<i class="fa fa-users" style="font-size:30px; padding-bottom:10px; padding-left:20px;"></i> --></div>
                <div class="count" style="font-size:16px;"><?php echo count_all_purchased_pgds($each['id']);?></div>
                <h5 style="padding-left:10px;">Total <?php echo filter_string($each['pgd_name']);?></h5>
              </div>
            </div>
    </a>
      <?php 
	  			}// end foreach loop
	  		}// end if(!$empty($list_all_active_trainings))
	  ?>

        <a href="<?php echo SURL?>users/download_all_users_csv">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><!--<i class="fa fa-users" style="font-size:30px; padding-bottom:10px; padding-left:20px;"></i> --></div>
                <div class="count" style="font-size:16px;">
					<?php 
						$total_users = count_all_users();
						echo $total_users['total'];
					?>
                </div>
                <h5 style="padding-left:10px;">Total Users</h5>
              </div>
            </div>
        </a>

        <a href="<?php echo SURL?>organization/download_all_pharmacies_csv">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><!--<i class="fa fa-users" style="font-size:30px; padding-bottom:10px; padding-left:20px;"></i> --></div>
                <div class="count" style="font-size:16px;">
					<?php 
						$total_pharmacies = get_all_pharmacy();
						echo count($total_pharmacies)
					?>
                </div>
                <h5 style="padding-left:10px;">Total Pharmacies</h5>
              </div>
            </div>
        </a>
   
   
    
   <h2 class="col-md-12">TRAINING</h2>  
  
    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-6">
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

    </div>
    <form data-toggle="validator" role="form" id="change_pass_frm" name="change_pass_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>users/download-csv-file-training">
    <div class="animated flipInY my_class col-lg-4 col-md-4 col-sm-6 col-xs-6 hidden">
     <input type="hidden" name="product_id" id="product_id" value=""> 
     <button type="submit" class="btn btn-success" name="new_training_btn" id="new_training_btn">Export CSV</button>
   
    </div>
   </form>
    
    <p><div class="row"></div></p>
  </div>
  
  </div>
