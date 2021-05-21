<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Authenticate PGDs Listing</strong></div>
      <div class="panel-body">
        <p class="align-left"></p>
        <div class="row">
          <div class="col-md-12">
           <?php if(!empty($response_signature)){?>
            <form id="" name="authenticate_frm" data-parsley-validate  method="POST" enctype="multipart/form-data" action="<?php echo SURL?>organization/unauthenticated-process">
            <?php if(!empty($list_unauthentcate_pgds_data)){?>
              	<p class="text-right"><button class="btn btn-success" type="submit" name="update_governance_btn" id="pgd_unauthenticate_btn">Authenticate</button></p>
                <?php }?>
                <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">            
                    <!-- Start - Governance tabs body -->
                    <div class="tab-content">                        
                        <div >
                            <div>
                             <?php if(!empty($list_unauthentcate_pgds_data)) { $DataTableId = "exampleunauthenticate";} else { $DataTableId; }?>
                                <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
                                   <thead>
                                    <tr class="info">
                                      <th> <input type="checkbox" id="checkAll"> Check All</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>User Type</th>
                                       <th>PGD Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($list_unauthentcate_pgds_data)) {
											  
										  	foreach($list_unauthentcate_pgds_data as $each) :
											
											$full_name = $each['first_name']." ".$each['last_name'];
									?>
                                        <tr class="even pointer">
                                        	<td> <input type="checkbox" name="unauthenticated_pgd[]" value="<?php echo $each['id'];?>"  class="inline pull-left" /></td>
                                            <td><?php echo filter_string($full_name);?></td>
                                            <td><?php echo filter_string($each['email_address']);?></td>
                                            <td><?php echo filter_string($each['user_type']);?></td>
                                            <td><?php echo filter_string($each['pgd_name']);?></td>
                                        </tr>
                                    
                                    <?php		
										  endforeach;
										} else { ?> 
                                         <tr class="">
                                            <td colspan="5"><?php echo "No record found!";?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                           </div>	
                        </div>
                    </div>
                    <!-- End - Governance tabs body -->
                </div>
              </div><!-- ./ row-->
               <?php if(!empty($list_unauthentcate_pgds_data)){?>
              <hr />
              	<p class="text-right"><button class="btn btn-success" type="submit" name="pgd_unauthenticate_btn" id="pgd_unauthenticate_btn">Authenticate</button></p>
               <?php }?> 
            </form>
            <?php } else {?>
             <div class="alert alert-danger">You need to add your Signatures from your <a href="<?php echo base_url();?>dashboard/settings">Settings</a> to Authenticate PGDS</div>
            <?php }?>
            <!-- End - Global Settings --> 
          </div>
        </div><!-- ./ row-->
      </div>
    </div>
  </div>
</div> <!-- ./ row-->