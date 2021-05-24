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
			<h2>Authentication PGDs Listing<small>Authentication PGDs Log</small></h2> 
			<div class="clearfix"></div>
			</div>
				<?php if(!empty($authenticated_pgd_log)){ $DataTableId ="exampleauthenticatelog";} else { $DataTableId = '';}?>
                  <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                    <thead>
                        <tr class="headings"> 
                           <th>Name</th>
                           <th>User Type</th>
                           <th>PGD Name</th>
                           <th>Autenticated Doctor</th>
                           <th>Autenticated Pharmacist</th>
                           <th>Authenticated Date</th>
                        </tr>
                    </thead>
                    <tbody>
     
                    <?php 
						if(!empty($authenticated_pgd_log)){
					?>
                          
                          <?php 
						  	foreach($authenticated_pgd_log as $each){
						  ?>
                             
                            <tr class="even pointer"> 
                           
                                <td class=" "><?php echo filter_string($each['first_name'])." ".filter_string($each['last_name']);?></td>
                                <td class=" "><?php echo $each['user_type']; ?></td>
                                <td class=" "><?php echo filter_string($each['pgd_name']); ?></td>
                                <td class=" "><?php echo filter_string($each['doctor_first_name']).' '.filter_string($each['doctor_last_name']); ?></td>
                                <td class=" "><?php echo filter_string($each['pharmacist_first_name']).' '.filter_string($each['pharmacist_last_name']); ?></td>
                                <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                                <td></td>
                            </tr>
                        <?php 
								}
							}  else { 
						?>
                            <tr class="">
                                <td class=" " colspan="9">No record founded.</td>
                            </tr>
                    <?php 
						}//end if(!empty($authenticated_pgd_log)) 
					?>
                  </tbody>
                </table>
              
          </div>
      </div>
    </div>
  </div>
</div>
