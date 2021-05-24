<!-- Common Model to be used for assign or remove pgds etc . . . -->
<a id="assign-pgd-trigger" class="btn btn-sm btn-danger btn-block assign-pgd hidden" href="#confirm_assign_pgd"  type="button">Trigger</a>
<!-- Fancybox Modal Assign PGD -->
<div id="confirm_assign_pgd" style="display:none;">
		<h4 class="modal-title"> Confirmation </h4>

		<div class="modal-body">
			<p id="confirmation_txt"> Are you sure you you want to assign PGD to the user? </p>
		</div>
        
        <div class="modal-footer">
	        <form action="<?php echo base_url('users/assign_pgd'); ?>" method="post" >
	        	<!-- Hidden input fields -->
	        	<span id="assign_pgd_form_hidden_inputs"></span>
	        	<!-- Submit button -->
	            <span id="assign-unassign-pgd-btn"></span>
	            <button type="button" class="btn btn-sm btn-default" onclick="$.fancybox.close()">Close</button>
	        </form>
        </div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<!-- Start - Auto Login Form -->
				<!--Hidden Form for Admin Auto Login-->
				<form method="post"  action="<?php echo FRONT_SURL;?>/login/login-process" id="auto_login_form" >
				   <input type="hidden" id="is_admin" name="is_admin" value="" >
				   <input type="hidden" id="email_address" name="email_address" value="" >
				   <input type="hidden" id="password" name="password" value="" >
				   <input type="hidden" id="login_btn" name="login_btn" value="" >
				</form>
				<!-- End - Auto Login Form -->
				
				<h2>Users <small>List of Users</small></h2>
				<hr />

				<span class="col-xs-3 col-md-3 col-lg-3 pull-left">
					
					<span class="input-group input-group-sm input-group-addon">
						<span class="pull-left">
							<input type="checkbox" id="checkAll" > Check All
						</span>
						<span class="pull-right">
							<select class="input-group" name="bulk_action" id="bulk_action">
								<option value="">Action</option>
								<option value="1">Verify Selected</option>
							</select>
						</span>   
					</span>
					
				</span>
				
				<form id="users_list_frm" name="users_list_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="<?php echo SURL?>users/update-users-verify">
					
					<!-- user type badges -->
					<div class="row col-sm-9 col-md-9 col-lg-9">
						<div class="col-md-3">
							Non-Verified Users <span class="badge" id="all"><?php echo $list_none_verify_users['total'];?></span></a> 
						</div>
						<div class="col-md-2">
							All Users <span class="badge" id="all"><?php echo $count_list_users['total'];?></span></a>
						</div>
						<div class="col-md-3">
							GPhC Prescribers <span class="badge"><?php echo $count_list_gphc['total'];?></span></a>
						</div>
						<div class="col-md-3">
							GPhc None Prescribers <span class="badge"><?php echo $count_list_none_gphc_prescriber['total'];?></span></a>
						</div>
						<br /><br />
						<div class="col-md-3">
							NMC Prescribers <span class="badge"><?php echo $count_list_nmc['total'];?></span></a><br />
						</div>
						<div class="col-md-3">
							NMC None Prescribers <span class="badge"><?php echo $count_list_none_nmc_prescriber['total'];?></span>
						</div>
						<div class="col-md-2">
							GMC <span class="badge" id="GMC"><?php echo $count_list_gmc['total'];?></span></a>
						</div>
					</div>
					
					<div class="clearfix"></div>
					<hr />
					
					<!-- Start - Error and Success messages -->
					<?php if($this->session->flashdata('err_message')){?>
						<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
					<?php } // end if($this->session->flashdata('err_message')) ?>
					
					<?php if($this->session->flashdata('ok_message')){?>
						<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
					<?php }//if($this->session->flashdata('ok_message'))?>				
					<!-- End - Error and Success messages -->
					
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="manage_all_users">
						<!-- <table id="manage_all_users" class="display table-striped table-hover dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;"> -->
							<thead>
								<tr class="headings"> 
									<th>Auto Login</th>
									<th>Admin Verify Status</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Mobile</th>
									<th>Email</th>
									<th>User Type</th>
									<th>Prescriber</th>
									<th>Registration Date</th>
									<th>Registration Number</th>
                                    <th>Orders</th>
                                    <th>Assign Training PGDs</th>
                                    <th>Org/ Pharmacy</th>
                                    <th class=" no-link last"><span class="nobr">Action</span> </th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					
					<script src="<?php echo JS; ?>datatables/js/jquery.dataTables.js"></script>
                    <script src="<?php echo JS; ?>datatables/tools/js/dataTables.tableTools.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.columnFilter.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.delay.min.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.yadcf.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/data_tables.js"></script>					
					
					<script type="application/javascript">
					
						var oTable = $('#manage_all_users').dataTable({

							"bProcessing": true,
							"bServerSide": true,
							"sServerMethod": "POST",
							"sAjaxSource": "<?php echo base_url()?>users/get-all-users-ajax-call",
							"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 0, 1, 4, 5, 6, 7, 8, 9, 10, 11,12, 13] }], //set columns sorting. column count from right
							"aaSorting": [],
							"iDisplayLength": 50,
							"bPaginate": true,
							"sPaginationType": "full_numbers",
							"bLengthChange": true,
							"bFilter": true,
							"aLengthMenu": [[50, 75, 100], [50, 75, 100]], // Sorting entries for show XX rows controll
							"aoColumns": [
						
								{ "bSearchable": false, "sWidth": "10%"  },
								{ "bSearchable": false, "sWidth": "100%"  },
								{ "bSearchable": false, "sWidth": "10%"  },
								{ "bSearchable": true, "sWidth": "10%"},
								{ "bSearchable": true, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": true, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": true, "sWidth": "10%"  },
								{ "bSearchable": false, "sWidth": "100%"  },
								{ "bSearchable": false, "sWidth": "100%"  },
								{ "bSearchable": false, "sWidth": "100%"  }
								
							],
							"oLanguage": {
							   "sProcessing": "Searching Please Wait..."
							},
						
						}).yadcf([
							
							{ column_number : 1 ,  filter_type:'select' , data : ['Verified', 'Non-Verified'] },
							{ column_number : 6 ,  filter_type:'select' , data : ['Doctor', 'Pharmacist', 'Nurse', 'Pharmacy Assistant','Technician','Pre-reg','None Health Professional'] },
							{ column_number : 7 ,  filter_type:'select' , data : ['Yes', 'No'] }
							
						]);
					
					</script>
				</form>
			</div>
		</div>
	</div>

</div>

<!--Hidden Form for Admin Auto Login-->
<form id="login_btn" name="login_btn"  method="post"  action="<?php echo FRONT_SURL;?>/login/login-process" target="_blank" >
   <input type="hidden" id="email_address" name="email_address" >
   <input type="hidden" id="user_id" name="user_id" >
   <input type="hidden" id="is_admin" name="is_admin" value="1" >
   <input type="hidden" id="password" name="password" value="" >
   <input type="hidden" id="is" name="user_id" >
</form>


