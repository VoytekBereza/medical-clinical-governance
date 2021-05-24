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
			<h2>UnAuthenticated PGDs Listing<small>UnAuthenticated PGDs Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
                 <form id="authenticate_frm" name="authenticate_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="<?php echo SURL?>pgd/unauthenticated-process">
                        <?php if(!empty($unauthenticated_list)){?>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                        <span class="input-group input-group-sm input-group-addon">
                            <span class="pull-left">
                                <input type="checkbox" id="checkAll" > Check All
                            </span>
                         </span>
                       </div>
                      
                        <div class="col-md-2 col-sm-2 col-xs-2">
                          <div class="form-group pull-right">
								<button name="pgd_unauthenticate_btn" class="btn btn-sm btn-success" <?php if(empty($response_signature)) {?> disabled="disabled" <?php }?> type="submit">Authenticate All</button>
						  </div>
                       </div>
                       <br />
                       <br />
                       <?php }?>
                       
             <?php if(!empty($unauthenticated_list)){ $DataTableId ="exampleunauthenticate";} else { $DataTableId = '';}?>
			  <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
                
					<tr class="headings"> 
                       <th>Checkbox</th>
                       <th>Name</th>
                       <th>User Type</th>
                       <th>Email Address</th>
                       <th>PGD Name</th>
					   <th>Purchase Date</th>
                       <th>Expiry  Date</th>
					</tr>
				</thead>
				<tbody>
 
				<?php if(!empty($unauthenticated_list)){?>
					  
                      <?php foreach($unauthenticated_list as $each): ?>
						 
                        <tr class="even pointer"> 
                       
                        <td class=""><div class="btn-group">
                        <input type="checkbox" name="unauthenticated_pgd[]" value="<?php echo $each['id'];?>"  class="inline pull-left" />
                        </div></td>
                            <td class=" "><?php echo filter_string($each['first_name'])." ".filter_string($each['last_name']);?></td>
                            <td class=" "><?php echo $each['user_type']; ?></td>
                            <td class=" "><?php echo filter_string($each['email_address']); ?></td>
                            <td class=" "><?php echo filter_string($each['pgd_name']); ?></td>
							<td class=" "><?php echo kod_date_format($each['purchase_date']); ?></td>
                            <td class=" "><?php echo kod_date_format($each['expiry_date']); ?></td>
                            <td></td>
                        </tr>
					<?php 
				 	endforeach; ?>
                    
				<?php }  else { ?>
								<tr class="">
									<td class=" " colspan="9">No record founded.</td>
								</tr>
					<?php } ?>
			  </tbody>
			</table>
              <br /><br />
              <?php if(!empty($unauthenticated_list)){?>
               <div class="pull-left">
                 <div class="form-group pull-right">
                        <button name="pgd_unauthenticate_btn" class="btn btn-sm btn-success"  <?php if(empty($response_signature)) {?> disabled="disabled" <?php }?> type="submit">Authenticate All</button>
                 </div>
               </div>
               <?php }?>
             </form>
          </div>
      </div>
    </div>
  </div>
</div>
