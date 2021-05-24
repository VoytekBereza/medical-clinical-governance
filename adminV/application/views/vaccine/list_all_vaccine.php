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
			<h2>Vaccines Listing<small>Vaccines Listing</small></h2> 
			<div class="clearfix"></div>
			</div>
          
            <form id="list_vaccine_frm" name="list_vaccine_frm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="#">
             <?php if(!empty($list_all_vaccine)){ $DataTableId ="examplevaccine";} else { $DataTableId = '';}?>
             <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="headings"> 
						<th>Vaccine Title</th>
                        <th>Vaccine Type</th>
						<th>Created date</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>
 
				<?php if(!empty($list_all_vaccine)){?>
					  
                      <?php foreach($list_all_vaccine as $each): ?>
						 
                        <tr class="even pointer"> 
                            <td class=" "><?php echo filter_string($each['vaccine_title']); ?></td>
                            <td class=" "><?php if($each['vaccine_type']=="T") { echo "Travel";} else { echo "Flu";} ?></td>
                            <td class=" "><?php echo kod_date_format($each['modified_date']); ?></td>
                            <td class=" ">
                            
                            <a class="btn btn-info btn-xs pull-left" type="button"  href="<?php echo base_url();?>vaccine/add-update-vaccine/<?php echo $each['id'];?>"><span class="glyphicon glyphicon-edit"></span></a>
                                
						   </td>
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
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

