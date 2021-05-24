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
				<h2>Pharmacy <small> List all Pharmacy </small></h2>
                 
				<div class="clearfix"></div>
			</div>
                    <table class="table table-striped table-bordered table-hover" id="pharmacy_ajax_list">
                        <thead>
                            <tr class="headings">
                                <th>Pharmacy Name</th>
                                <th>Organization Name</th>
                                <th>Contact No</th>
                                <th>Superintendent Name</th>
                                <th>Manager Name</th>
                                <th>Address</th>
                                <th>GPhc No</th>
                                <th>Type</th>
                                <th>Status</th>
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
					
						var oTable = $('#pharmacy_ajax_list').dataTable({

							"bProcessing": true,
							"bServerSide": true,
							"sServerMethod": "POST",
							"sAjaxSource": "<?php echo base_url()?>organization/pharmacy-ajax-list",
							"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 1, 2, 3, 4, 5, 6, 7,8,9] }], //set columns sorting. column count from right
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
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "10%" },
								{ "bSearchable": false, "sWidth": "5%" },
								{ "bSearchable": false, "sWidth": "15%" },
								
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
