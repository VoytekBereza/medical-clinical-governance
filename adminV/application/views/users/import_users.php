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
			<h2>Users <small>Import users</small></h2> 
			<div class="clearfix"></div>
				
				<hr />

				<div class="row">
					
					<div class="col-md-6">
						<label> Download format: </label>
						<div class="well well-sm">Click <a href="<?php echo CSV; ?>dummy-csv.csv" > <strong> here </strong> </a> to download the sample format.
						</div>
					</div>

					<div class="col-md-6">
						<label> Upload List: </label>
						<div class="well well-sm">
							
							<form action="<?php echo base_url(); ?>users/save-import-users" method="post" enctype="multipart/form-data">
								<div class="col-md-6">
									<input type="file" required="required" name="csv" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
								</div>
								
								<div class="col-md-6 text-right">
									<button type="submit" class="btn btn-xs btn-primary"> Save Users </button>
								</div>
							</form>
							
						</div>
					</div>

				</div>
				
			</div>
        </div>
      </div>
    </div>
  </div>
</div>
