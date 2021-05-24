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
			<h2>Default Team Section Listing<small>Default Team Section Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
            <div class="row">
                <div class="col-md-12">
                     <form id="add_default_frm" name="add_default_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>users/add-update-default-user-process">
                         <div class="row">
                             <div class="col-md-6 col-sm-6 col-xs-6">
                             <div class="form-group">
                               
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" id="1" name="is_default_doc" class="form-control search" placeholder="Search Doctor" autocomplete="off">
                                <input type="hidden" id="doctor_email" name="doctor_email" value="" autocomplete="off">
                                <div id="result"></div>
                                </div>
                                
                                <div class="form-group pull-left">
                                    <button name="user_type_btn" class="btn btn-sm btn-success save_record" value="1" type="submit">Save</button>
                                </div>
                            </div>
                              
                           </div>
                           
                             <div class="col-md-6 col-sm-6 col-xs-6 pull-left">
                             <div class="form-group">
                               
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" id="2" name="is_default_pharm"  class="form-control search" placeholder="Search Pharmacist" autocomplete="off">
                                <input type="hidden" id="pharmacist_email" name="pharmacist_email" value="" autocomplete="off">
                                <div id="result2"></div>
                                </div>
                                
                                <div class="form-group pull-left">
                                    <button name="user_type_btn" class="btn btn-sm btn-success save_record" value="2" type="submit">Save</button>
                                </div>
                            </div>
                             
                           </div>
                          
                          
                         </div>
                     </form>      
                </div>
             </div>
                 <div class="row">
                    <div class="col-md-6">
                        <form id="add_default_presc_frm" name="add_default_presc_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>users/update-default-prescriber-process">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" name="is_default_prescriber" id="is_default_prescriber"  class="form-control search_presc" placeholder="Search Prescriber" autocomplete="off">
                                <input type="hidden" id="prescriber_email" name="prescriber_email" value="" autocomplete="off">
                                <div id="result_presc"></div>
                                </div>
                                
                                <div class="form-group pull-left">
                                    <button name="default_presc_btn" class="btn btn-sm btn-success save_record" value="2" type="submit">Save</button>
                                </div>
		                </form>
                    </div>
            </div>
             <?php if(!empty($list_default_users)){ $DataTableId ="exampleteamdetault";} else { $DataTableId = '';}?>
             <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="headings"> 
                        <th>Auto Login</th>
                        <th>Default User Full Name</th>
                        <th>User Type</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Registration</th>
						<th>Registration Date</th>
					</tr>
				</thead>
				<tbody>
 
				<?php if(!empty($list_default_users)){
					foreach($list_default_users as $each): ?>
						 
                        <tr class="even pointer"> 
                            <td class=""><a href="#login" onClick="user_login_function('<?php echo $each['email_address'];?>','<?php echo $each['id'];?>','<?php echo $each['password']?>');" type="button" title="Click here to login this user." class="pull-left btn btn-default btn-xs"><i class="fa fa-external-link"></i></a></td>
                            
                            <td class=" ">
								<?php 
									echo ucwords(filter_string($each['first_name'])." ".filter_string($each['last_name']));
									echo ($each['system_prescriber'] == '1') ? ' (PRESCRIBER)' : '';
								?>
                            </td>
                            <td class=" "><?php echo $each['user_type']; ?></td>
                            <td class=" "><?php echo filter_string($each['mobile_no']);?></td>
                            <td class=" "><?php echo filter_string($each['email_address']);?></td>
							<td class=" "><?php echo filter_string($each['registration_type'])." (".filter_string($each['registration_no']).")"; ?></td>
                            <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                            
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

