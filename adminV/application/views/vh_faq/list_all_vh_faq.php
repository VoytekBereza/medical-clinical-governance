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
			<h2>Voyager Health Faqs Listing<small>Voyager Health Faqs Listing</small></h2> 
            <div class="nav navbar-right panel_toolbox">
			 <a href="<?php echo SURL?>vhfaq/add-update-vh-faq" class="btn btn-sm btn-success">Add Voyager Health Faqs</a>
		   </div> 
			<div class="clearfix"></div>
			</div>
                 <form id="list_medicine_frm" name="list_medicine_frm" data-parsley-validate class="form-horizontal form-label-left form_validate" method="post" enctype="multipart/form-data" action="#">
                    
             <?php if(!empty($list_vh_faq)){ $DataTableId ="examplecontactfaq";} else { $DataTableId = '';}?>
             <table id="<?php echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="headings"> 
						<th>Question</th>
                        <th>Answer</th>
						<th>Created date</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>
 				
				<?php if(!empty($list_vh_faq)){?>
					  
                      <?php foreach($list_vh_faq as $each):
					  
					  			$faq_question = filter_string($each['faq_question']);
								$faq_answer   = filter_string($each['faq_answer']);
					   ?>
                        <tr class="even pointer"> 
                            <td class=" "><?php echo substr($faq_question,0,80); ?></td>
                            <td class=" "><?php echo substr($faq_answer,0,50); ?></td>
                            <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                            <td class=" ">
                            <a class="btn btn-info btn-xs pull-left" type="button"  href="<?php echo base_url();?>vhfaq/add-update-vh-faq/<?php echo $each['id'];?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <a class="btn btn-danger btn-xs" data-target="#confirm-delete-<?php echo $each['id'];?>" data-toggle="modal" title="Delete" data-href="<?php echo base_url();?>vhfaq/delete-vh-faq/<?php echo $each['id'];?>" href="#">X</a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirm-delete-<?php echo $each['id'];?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                Warning !
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this faq ?
                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                <a class="btn btn-danger btn-ok" href="<?php echo base_url();?>vhfaq/delete-vh-faq/<?php echo $each['id'];?>">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

