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
                       
             <?php if(!empty($unauthenticated_list)){ $DataTableId ="exampleunauthenticate_2";} else { $DataTableId = '';}?>
			  <table id="<?php echo $DataTableId; ?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
                
					<tr class="headings"> 
                       <th>Autologin</th>
                       <th>Name</th>
                       <th>User Type</th>
                       <th>Buying Group</th>
                       <th>Email Address</th>
                       <th>Mobile No</th>
                       <th>PGD Name</th>
					   <th>Purchase Date</th>
                       
					</tr>
				</thead>
				<tbody>
 
				<?php 
					if(!empty($unauthenticated_list)){
					  
					  	foreach($unauthenticated_list as $each){
			  ?>
						 
                        <tr class="even pointer"> 
                       
                            <td>
                            	<div class='btn-group'>
                            		<a href='#login' onclick="user_login_function('<?php echo $each['email_address'] ?>', '<?php echo $each['id']?>', '<?php echo $each['password'] ?>')" type='button' title='Click here to login this user.' class='pull-right btn btn-default btn-xs'><i class='fa fa-external-link'></i></a>
                              	</div>
                            </td>
                            <td><?php echo filter_string($each['first_name'])." ".filter_string($each['last_name']);?></td>
                            <td><?php echo $each['user_type']; ?></td>
                            <td><?php echo $each['buying_groups']; ?></td>
                            <td><?php echo filter_string($each['email_address']); ?></td>
                            <td><?php echo ($each['mobile_no']); ?></td>
                            
                            <td><?php echo filter_string($each['pgd_name']); ?></td>
							<td><?php echo kod_date_format($each['purchase_date']); ?></td>
                            
                            <td></td>
                        </tr>
					<?php
						}
                    
					}else{ 
				?>
                            <tr class=""><td colspan="9">No record founded.</td></tr>
				<?php 
					}//end if(!empty($unauthenticated_list)) 
				?>
			  </tbody>
			</table>
          </div>
      </div>
    </div>
  </div>
</div>
    <form method="post"  action="<?php echo FRONT_SURL;?>/login/login-process" id="auto_login_form" >
       <input type="hidden" id="is_admin" name="is_admin" value="" readonly="readonly" >
       <input type="hidden" id="email_address" name="email_address" value=""  readonly="readonly">
       <input type="hidden" id="password" name="password" value=""  readonly="readonly">
       <input type="hidden" id="login_btn" name="login_btn" value="" readonly="readonly">
    </form>
