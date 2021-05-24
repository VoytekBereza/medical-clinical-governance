<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php 
			if($this->session->flashdata('err_message')){
		?>
        		<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php 
			} // end if($this->session->flashdata('err_message')) 

			if($this->session->flashdata('ok_message')){
		?>
		        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php 
			}//if($this->session->flashdata('ok_message'))
		?>
        <div class="row">
			<div class="x_title">
                <h2>Organization <small>List Organization</small></h2> 
                <div class="clearfix"></div>
			</div>
            <?php 
				if(!empty($organization_list)){ $DataTableId ="exampleOrganization";} else { $DataTableId = '';}
			?>
			<table id="<?php echo $DataTableId;?>" class="display dataTable " cellspacing="0" width="100%" role="grid" style="width: 100%;">
				<thead>
					<tr class="headings"> 
						<th>Auto Login</th>
                        <th>Company Name</th>
                        <th>Owner Name</th>
                        <th>Superintendent Name</th>
						<th>Post Code</th>
                        <th>Contact Number</th>
						<th>Created Date</th>
                        <th>Location</th>
						<th>Status </th>
					</tr>
				</thead>
				<tbody>
				<?php 
					if(!empty($organization_list)){

						foreach($organization_list as $each){
				?>
                            <tr class="even pointer"> 
                                <td>
                                    <a href='#login' onclick="user_login_function('<?php echo filter_string($each['owner_email_address'])?>','<?php echo filter_string($each['id'])?>','<?php echo filter_string($each['owner_password'])?>')" type='button' title='Click here to login this user.' class='pull-right btn btn-default btn-xs'><i class='fa fa-external-link'></i></a>
                                </td>
                                <td><?php echo filter_string($each['company_name']) .' - '.$each['id']; ?></td>
                                <td><?php echo filter_string($each['owner_first_name'])." ".filter_string($each['owner_last_name']).' - '.$each['org_owner_id']; ?></td>
                                <td><?php if($each['si_first_name']=="") { echo "No Superintendent Name";} else { echo filter_string($each['si_first_name'])." ".filter_string($each['si_last_name']) .' - '.$each['superintendent_id'];} ?></td>
                                <td><?php echo filter_string($each['postcode']); ?></td>
                                <td><?php echo filter_string($each['contact_no']); ?></td>
                                <td><?php echo kod_date_format($each['created_date']); ?></td>
                                <td class="pharmacy_count_td" data-org="<?php echo $each['id'];?>" style="cursor:pointer">
									<?php $get_all_pharmacy = get_all_pharmacy($each['id']);?><?php echo count($get_all_pharmacy)?></a>
                                    </td>
                                <td><?php echo ($each['status'] == 1) ? 'Active' : 'InActive' ?></td>
                            </tr>
					<?php 
							}//end foreach($organization_list as $each) 
							
						}  else { 
					?>
								<tr class=""><td colspan="9">No record founded.</td></tr>
					<?php 
						} //end if(!empty($organization_list))
					?>
			  </tbody>
			</table>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Hidden Form for Admin Auto Login-->
<form method="post"  action="<?php echo FRONT_SURL;?>/login/login-process" id="auto_login_form" >
   <input type="hidden" id="is_admin" name="is_admin" value="" >
   <input type="hidden" id="email_address" name="email_address" value="" >
   <input type="hidden" id="password" name="password" value="" >
   <input type="hidden" id="login_btn" name="login_btn" value="" >
</form>

<script>
	$('.pharmacy_count_td').click(function(){
		
		var org_id = $(this).attr('data-org');
		location.href = ""+SURL+"organization/list-all-pharmacy/"+org_id+"";
	})
</script>