<!-- Common Model to be used for assign or remove pgds etc . . . -->
<a id="assign-pgd-trigger" class="btn btn-sm btn-danger btn-block assign-pgd hidden" href="#confirm_assign_pgd"  type="button">Trigger</a>
<!-- Fancybox Modal Assign PGD -->
<div id="confirm_assign_pgd" style="display:none;">
		<h4 class="modal-title"> Confirmation </h4>

		<div class="modal-body">
			<p id="confirmation_txt"> Are you sure you you want to assign PGD to the user? </p>
		</div>
        
        <div class="modal-footer">
	        <form action="<?php echo base_url('avicenna/assign_pgd'); ?>" method="post" >
	        	<!-- Hidden input fields -->
	        	<span id="assign_pgd_form_hidden_inputs"></span>
	        	<!-- Submit button -->
	            <span id="assign-unassign-pgd-btn"></span>
	            <button type="button" class="btn btn-sm btn-default" onclick="$.fancybox.close()">Close</button>
	        </form>
        </div>
</div>

<a id="assign-renew-pgd-trigger" class="btn btn-sm btn-danger btn-block assign-renew-pgd hidden" href="#confirm_assign_renew_pgd"  type="button">Trigger</a>
<!-- Fancybox Modal Assign Renew PGD -->
<div id="confirm_assign_renew_pgd" style="display:none;">
		<h4 class="modal-title"> Confirmation </h4>

		<div class="modal-body">
			<p id="confirmation_renew_txt"> </p>
		</div>
        
        <div class="modal-footer">
	        <form action="<?php echo SURL; ?>users/renew-pgd" method="post" >
	        	<!-- Hidden input fields -->
	        	<span id="assign_renew_pgd_form_hidden_inputs"></span>
	        	<!-- Submit button -->
	            <span id="assign-unassign-renew-pgd-btn"></span>
	            <button type="button" class="btn btn-sm btn-default" onclick="$.fancybox.close()">Close</button>
	        </form>
        </div>
</div>

<!-- Start Page Contents -->
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
				<h2>Avicenna <small> List all Users </small></h2>
                <div class="nav navbar-right panel_toolbox">
					<a href="<?php echo SURL?>avicenna/add-edit-avicenna-user" class="btn btn-sm btn-success">Add New User</a>
			    </div> 
				<div class="clearfix"></div>
			</div>
                    <table class="table table-striped table-bordered table-hover" id="avicenna_user_list">
                        <thead>
                            <tr class="headings">
                                <th>First Name1</th>
                                <th>Last Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Reg No</th>
                                <th>User Type</th>
                                <th>Assign Training PGDs</th>
                                <th>Actions</th>
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
					
						var oTable = $('#avicenna_user_list').dataTable({

							"bProcessing": true,
							"bServerSide": true,
							"sServerMethod": "POST",
							"sAjaxSource": "<?php echo base_url()?>avicenna/avicenna-users-list",
							"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 1, 2, 3, 4, 5, 6, 7] }], //set columns sorting. column count from right
							"aaSorting": [],
							"iDisplayLength": 50,
							"bPaginate": true,
							"sPaginationType": "full_numbers",
							"bLengthChange": true,
							"bFilter": true,
							"aLengthMenu": [[50, 75, 100], [50, 75, 100]], // Sorting entries for show XX rows controll
							"aoColumns": [
						
								{ "bSearchable": true, "sWidth": "10%"  },
								{ "bSearchable": false, "sWidth": "10%"  },
								{ "bSearchable": false, "sWidth": "10%"  },
								{ "bSearchable": false, "sWidth": "10%"},
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "20%" },
								{ "bSearchable": false, "sWidth": "10%" },
								
							],
							"oLanguage": {
							   "sProcessing": "Searching Please Wait..."
							},
						
						}).yadcf([
							
							
						]);
					
					</script>
		</div>
      </div>
    </div>
  </div>
</div>