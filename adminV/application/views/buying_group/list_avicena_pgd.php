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
			<h2>Avicenna  <small>List Avicenna PGDs</small></h2>
			<div class="clearfix"></div>
			</div>
            <div class="row col-sm-12 col-md-12 col-lg-12">
            <div class="col-md-2">
              <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD">All <span class="badge" id="all"><?php echo $list_all_active_pgds;?></span></a>
            </div>
             <div class="col-md-2">
              <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/10">Travel Core 3.0 <span class="badge"><?php echo $count_list_pgds_peads_travel;?></span></a>
            </div>
             <!--<div class="col-md-2">
              <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/11">Adult Travel <span class="badge"><?php echo $count_list_pgds_adult_travel;?></span></a>
            </div>-->
            
              
             <div class="col-md-2">
              <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/15">Seasonal  2017 <span class="badge"><?php echo $count_list_pgds_seasonal_flu_15;?></span></a>
            </div>
            
            <div class="col-md-3">
             <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/12">Premium Oral PGD Package (O+) <span class="badge"><?php echo $count_list_pgds_seasonal_flu_12;?></span></a>
            </div>
            
             <div class="col-md-3">
             <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/19">Standard Oral PGD Package (O) <span class="badge"><?php echo $count_list_pgds_seasonal_flu_19;?></span></a>
            </div>
            <!-- <div class="col-md-3">
              <a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD/16">Premium Oral PGD Package (O+) <span class="badge"><?php echo $count_list_pgds_seasonal_flu_16;?></span></a>
            </div>-->
   		 </div>
            <br /><br />
          
             <?php //if(!empty($list_avicena_pgd)){ $DataTableId ="avicena-pgds";} else { $DataTableId = '';}?>
			
              <br /><br />
              <?php if(!empty($list_avicena_pgd)){?>
               <!--<div class="pull-left">
                 <div class="form-group">
                 
                 <?php if($product_id =='') {?>
                 	<a href="<?php echo SURL?>avicenna/download-csv-file-all-pgds/PGD"  class="btn btn-sm btn-success">Export</a>
                    
                    <?php } else { ?>
                    
                    <a href="<?php echo SURL?>avicenna/download_csv/<?php echo $product_id;?>/PGD" class="btn btn-sm btn-success">Export</a>
                    
                    <?php }?>
                 </div>
               </div>-->
               <?php }?>
                <table class="table table-striped table-bordered table-hover" id="avicenna_user_list_pgd">
                        <thead>
                      
                            <tr class="headings">
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>PGD Name</th>
                                <th>Expiry Date</th>
                                <th>Quiz Passed</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
               
					<script src="<?php echo JS; ?>datatables/js/jquery.dataTables.js"></script>
                    <script src="<?php echo JS; ?>datatables/tools/js/dataTables.tableTools.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.columnFilter.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.delay.min.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/jquery.dataTables/1.9.4/jquery.dataTables.yadcf.js"></script>
                    <script src="<?php echo JS; ?>kod_scripts/data_tables.js"></script>					
					
					<script type="application/javascript">
					
						var oTable = $('#avicenna_user_list_pgd').dataTable({

							"bProcessing": true,
							"bServerSide": true,
							"sServerMethod": "POST",
							<?php if($this->uri->segment(4) !='' && ($this->uri->segment(4) =='10' || $this->uri->segment(4) =='12' || $this->uri->segment(4) =='15' || $this->uri->segment(4) =='19')) { ?>
							"sAjaxSource": "<?php echo base_url()?>avicenna/avicenna-pgd-user-list/<?php echo $this->uri->segment(4);?>",
							<?php } else { ?>
							"sAjaxSource": "<?php echo base_url()?>avicenna/avicenna-pgd-user-list",
							<?php }?>
							"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 1, 2, 3, 4, 5, 6] }], //set columns sorting. column count from right
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
								
							],
							"oLanguage": {
							   "sProcessing": "Searching Please Wait..."
							},
						
						}).yadcf([
							
							
						]);
					
					</script>
                    <br />
                    
                    <?php if(!empty($list_avicena_pgd)){?>
              			 <div class="pull-left">
                 <div class="form-group">
                 
                 <?php if($product_id =='') {?>
                 	<a href="<?php echo SURL?>avicenna/download-csv-file-all-pgds/PGD"  class="btn btn-sm btn-success">Export</a>
                    
                    <?php } else { ?>
                    
                    <a href="<?php echo SURL?>avicenna/download_csv/<?php echo $product_id;?>/PGD" class="btn btn-sm btn-success">Export</a>
                    
                    <?php }?>
                 </div>
               </div>
               <?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
