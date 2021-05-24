<table id="<?php //echo $DataTableId; ?>" class="table table-striped table-bordered table-hover">
             
				<thead>
					<tr class="headings"> 
                        <th>RAF Label</th>
                        <th>Question</th>
                        <th>Display Order</th>
                        <th>Required Answer</th>
						<th>Created date</th>
                        <th>Action</th>
					</tr>
				</thead>
               
				<tbody>
             
				<?php if(!empty($list_all_vaccine_raf_labels_ajax)){?>
					  
                      <?php foreach($list_all_vaccine_raf_labels_ajax as $each): ?>
						 
                        <tr class="even pointer"> 
                            <td class=" "><?php echo filter_string($each['label']); ?></td>
                            <td class=" "><?php echo filter_string($each['question']); ?></td>
                             <td class=" ">
                            <input type="text" id="order_list" name="order_list[]" value="<?php echo $each['display_order']; ?>" size="5"/>
                            <input type="hidden" id="id_list" name="id_list[]" value="<?php echo $each['id']; ?>" size="5"/>
                            </td>
                            <td class=" "><?php if($each['required_answer']=="Y") { echo "Yes";} else { echo "No";}?></td>
                            <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                            <td class=" ">
                            <a class="btn btn-info btn-xs pull-left" type="button"  href="<?php echo base_url();?>vaccine/add-update-vaccine-raf/<?php echo $each['vaccine_id'];?>/<?php echo $each['id'];?>" title="Edit RAF"><span class="glyphicon glyphicon-edit"></span></a>
                            <a class="btn btn-danger btn-xs" data-target="#confirm-delete-<?php echo $each['id'];?>" data-toggle="modal" title="Delete RAF" data-href="<?php echo base_url();?>vaccine/delete-vaccine-raf/<?php echo $this->uri->segment(3);?>/<?php echo $each['id'];?>" href="#">X</a>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirm-delete-<?php echo $each['id'];?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                Warning !
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this vaccine RAF ?
                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                <a class="btn btn-danger btn-ok" href="<?php echo base_url();?>vaccine/delete-vaccine-raf/<?php echo $each['vaccine_id'];?>/<?php echo $each['id'];?>">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
						   </td>
                        </tr>
                        
					<?php endforeach; ?>
                    
                    <tr class=""> 
                            <td class=" " colspan="7">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            </div>
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <input type="submit" class="btn btn-success" id="info_order_btn" name="info_order_btn" value="Update Order" size="5"/>
                             <input type="hidden" name="vaccine_id" id="vaccine_id" value="<?php echo $list_all_vaccine_raf_labels_ajax[0]['vaccine_id'];?>" />
                            </div>
                            </td>
                    </tr>
                                   
				<?php }  else { ?>
								<tr class="">
									<td class=" " colspan="9">No record founded.</td>
								</tr>
					<?php } ?>
                
			  </tbody>
            
			</table>