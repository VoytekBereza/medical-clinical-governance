<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php } // end if($this->session->flashdata('err_message')) ?>
        <?php if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="row">
			<div class="x_title">
			<h2>Avicenna  <small>List Avicenna Training</small></h2>
			<div class="clearfix"></div>
			</div>
            
         <?php if($list_all_active_trainings){
		  		$i=1;	
		  		$x=0;
		   			$all_training  = list_avicena_trainging(); 
         ?>
      <?php 	foreach($list_all_active_trainings as $each){
		  					  
			  	 	$count_traingin  = list_avicena_trainging($each['id']); 
		  			if($i ==1){
	  ?>
                            
                        <div class="row col-sm-12 col-md-12 col-lg-12 pull-left">
                             <?php } if($x==0){?>    
                             
                               <div class="col-md-3">
                                  <a href="<?php echo SURL?>avicenna/list-avicenna-training/all"> All Training <span class="badge"><?php echo count($all_training);?></span></a>
                                </div>
                                <?php } else {?>
                                
                                <div class="col-md-3">
                                  <a href="<?php echo SURL?>avicenna/list-avicenna-training/<?php echo $each['id'];?>"> <?php echo substr(filter_string($each['course_name']),0,35);?> <span class="badge"><?php echo count($count_traingin);?></span></a>
                                </div>
          <?php  } if($i ==4){  $i=0; ?>  
            </div>
             <br /> <br />    
             <?php } ?>
     <?php 
	  			$i++;
				$x++;
				}// end foreach loop
	  		}// end if(!$empty($list_all_active_trainings))
	      ?>
            <br /><br />
        
             <?php if(!empty($list_avicena_training)){ $DataTableId ="avicena-pgds";} else { $DataTableId = '';}?>
			<table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Contact</th>
                        <th>Training</th>
                       <!-- <th>User Type</th>-->
                        <th>Expiry Date</th>
                        <th>Quiz Passed</th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($list_avicena_training)){ ?>
					<?php foreach($list_avicena_training as $each):  ?>
						<tr class="even pointer"> 
                            <td class=" "><?php echo filter_string($each['first_name']); ?></td>
							<td class=" "><?php echo filter_string($each['last_name']); ?></td>
							<td class=" "><?php echo filter_string($each['email_address']); ?></td>
                            <td class=" "><?php echo filter_string($each['mobile_no']); ?></td>
                            <td class=" "><?php echo substr(filter_string($each['course_name']),0,35); ?></td>
                           <!-- <td class=" "><?php echo filter_string($each['utype']); ?></td>-->
                            <td class=" "><?php echo filter_string($each['expiry_date']); ?></td>
                            <td class=" "><?php if($each['is_quiz_passed'] =='0'){ echo 'Failed'; } else { echo 'Passed';}  ?></td>                            
	                   </tr>
					<?php endforeach; ?>
				<?php }  else { ?>
								<tr class="">
									<td class=" " colspan="9">No record founded.</td>
								</tr>
					<?php } ?>
			  </tbody>
			</table>
              <br /><br />
              <?php if(!empty($list_avicena_training)){?>
               <div class="pull-left">
                 <div class="form-group">
                 
                 <?php if($product_id =='all') {?>
                    <a href="<?php echo SURL?>avicenna/download-csv-file-training/all"  class="btn btn-sm btn-success">Export</a>
                <?php } else { ?>
                    <a href="<?php echo SURL?>avicenna/download-csv-file-training/<?php echo $product_id;?>" class="btn btn-sm btn-success">Export</a>
                <?php }?>
                 </div>
               </div>
               <?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
