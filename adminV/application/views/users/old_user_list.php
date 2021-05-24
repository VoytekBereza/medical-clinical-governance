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
			<h2>Old User Listing<small>Old User Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
             <?php if(!empty($old_user_list)){ $DataTableId ="example-old-user";} else { $DataTableId = '';}?>
            <table id="<?php echo $DataTableId;?>" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings"> 
						<th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
						<th>Registration Type</th>
                        <th>Registration Number</th>
                        <th>Buying Group</th>
                        <th>Action</th>
                        
					</tr>
				</thead>
				<tbody>
 
				<?php 
				
				
				
				
				/*print_this($old_user_list); exit;*/
				
				if(!empty($old_user_list)){?>
					  
                      <?php foreach($old_user_list as $each): ?>
						 
                        <tr class="even pointer">
                            <td width="10%"><?php echo filter_string($each['firstname']); ?></td>
                        	<td width="10%"><?php echo filter_string($each['lastname']);?></td>
                            <td width="10%"><?php echo filter_string($each['mobilenumber']);?></td>
                            <td width="10%"><?php echo filter_string($each['emailaddress']);?></td>
                            <td width="10%"><?php echo filter_string($each['registeringbody']); ?></td>
                            <td width="10%"><?php echo filter_string($each['registrationnumber']); ?></td>
                            <td width="10%"><?php echo filter_string($each['buying_groups']); ?></td>
                            <td width="10%">
                            <a class="btn btn-info btn-xs pull-left" type="button"  href="<?php echo base_url();?>users/edit-old-users/<?php echo $each['userid'];?>"><span class="glyphicon glyphicon-edit"></span></a>
						   </td>
                        </tr>
					<?php 
				 	endforeach; ?>
                    
				<?php }  else { ?>
								<tr class="">
									<td class=" " colspan="7">No record founded.</td>
								</tr>
					<?php } ?>
                    
           	  </tbody>
			</table>
        </div>
      </div>
    </div>
  </div>
</div>
