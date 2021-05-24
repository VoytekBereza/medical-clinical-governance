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
			<h2>Buying Group List<small>Buying Group List</small></h2> 
			<div class="clearfix"></div>
			</div>
            <div class="nav navbar-right panel_toolbox">
			 <a href="<?php echo SURL?>users/add-edit-buyinggroup" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New</a>
		   </div> 
            
             <?php if(!empty($buying_groups_list)){ $DataTableId ="example-old-user";} else { $DataTableId = '';}?>
            <table id="<?php echo $DataTableId;?>" class="display nowrap dataTable dtr-inline table-striped" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
						<th>Auto Login</th>
                        <th>Buying Groups</th>
                        <th>Affiliate Name</th>
                        <th>Members</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact No</th>
                        <th>Email</th>
						<th>Status</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>
 
				<?php 
					if(!empty($buying_groups_list)){

					  	foreach($buying_groups_list as $each){ 
				?>
						 
                        <tr class="even pointer">
                            <td width="20%">
                            	<div class='btn-group'> 
                                	<a href='#login' onclick="affiliate_login_function('<?php echo filter_string($each['email_address'])?>','<?php echo filter_string($each['id'])?>','<?php echo filter_string($each['password'])?>')" type='button' title='Click here to login this user.' class='pull-right btn btn-default btn-xs'><i class='fa fa-external-link'></i></a>
                                </div>
                            </td>
                            <td width="20%"><?php echo filter_string($each['buying_groups']);?></td>
                            <td width="20%"><?php echo filter_string($each['url_slug']);?></td>
                            <td width="20%">
								<?php 
									$count_all_users = count_all_users($each['id']);
									echo $count_all_users['total'];
								?>
                            </td>
                        	<td width="20%"><?php echo filter_string($each['first_name']);?></td>
                            <td width="20%"><?php echo filter_string($each['last_name']);?></td>
                            <td width="10%"><?php echo filter_string($each['contact_no']);?></td>
                            <td width="10%"><?php echo filter_string($each['email_address']);?></td>
                            <td width="10%"><?php echo ($each['status'] == '0') ? 'Inactive' : 'Active'; ?></td>
                            <td width="10%">
                            <a class="btn btn-info btn-xs pull-left" type="button" href="<?php echo base_url();?>users/add-edit-buyinggroup/<?php echo $each['id'];?>"><span class="glyphicon glyphicon-edit"></span></a>
						   </td>
                        </tr>
                    
				<?php 
						}//end foreach($buying_groups_list as $each)
						
					}else{ 
				?>
                        <tr class="">
                            <td class=" " colspan="7">No record founded.</td>
                        </tr>
				<?php 
					}//end if(!empty($buying_groups_list)) 
				?>
                    
           	  </tbody>
			</table>
        </div>
      </div>
    </div>
  </div>
</div>
<form id="login_btn" name="login_btn"  method="post"  action="<?php echo FRONT_SURL;?>affiliates/login/login-process" target="_blank" >
   <input type="hidden" id="email_address" name="email_address" >
   <input type="hidden" id="is_admin" name="is_admin" value="" >
   <input type="hidden" id="password" name="password" value="" >
   <input type="hidden" id="login_btn" name="login_btn" value="" >
</form>

<script>
function affiliate_login_function (email, id, password) {
	
	$('#is_admin').val(1);
	$('#email_address').val(email);
	$('#password').val(password);
	$('#login_btn').val(1);
	
	//$("#login_btn").attr('target', '_blank').submit();
	$("#login_btn")[0].submit();
	
 }

</script>