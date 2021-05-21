<?php 
	if(count($list_register_all_entery) > 0) {

		foreach($list_register_all_entery as $each){
		
?>
		<tr>
			<td class="text-center"><?php echo kod_date_format($each['created_date']);?> 
				<?php 
					if($each['stock_received_supplied'] == 'SS' || $each['stock_received_supplied'] == 'SR' ){
				?>
						<a href="<?php echo SURL?>registers/adjust-entry/<?php echo $each['id']?>" class="btn btn-sm btn-success fancybox_view fancybox.ajax">Adjust</a>
				<?php 
					}//end if($each['stock_received_supplied'] == 'SS' || $each['stock_received_supplied'] == 'SR' )
				?>
		   </td>
			<td class="text-center"><?php echo filter_string($each['fname']).' '.filter_string($each['lname']);?></td>
			<td class="text-center"><?php echo filter_string($each['supplier_name']).' <br/>'.filter_string($each['sup_address']);?></td>
			<td class="text-center"><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
			<td class="text-center"><?php echo filter_string($each['presc_first_name']).' '.filter_string($each['presc_last_name']).' <br/>'.filter_string($each['presc_address']);?></td>
			<td class="text-center"><?php echo filter_string($each['proof_of_id']);?></td>
			<td class="text-center"><?php echo filter_string($each['proof_confirm_id']);?></td>
			<td class="text-center"><?php echo filter_string($each['collecting_person_name']);?></td>
			<td class="text-center"><?php if($each['note'] !=""){?><a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/view-check-balance-reason/<?php echo $each['id'];?>">View</a>
			<?php } else if($each['reason'] !=""){?><a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/view-check-balance-reason/<?php echo $each['id'];?>">View</a><?php }?>
			
			</td>
			<td class="text-center"><?php if($each['supplier_name'] !='') { echo filter_string($each['quantity_received']);} else if($each['quantity_supplied'] !='') { echo '-'.filter_string($each['quantity_supplied']);}?></td>
			
			 
			<td class="text-center"><?php echo filter_string($each['stock_in_hand']);?></td>
		</tr>
		
		<?php  
			} // foreach 
			
	if($total_listing_count > $no_of_rec_per_page){
	
		if($current_page == 1)
			$disable_prev = 1;
		if($current_page == $total_num_of_pages)
			$disable_next = 1;
	?>
    	<tr>
        	<td colspan="15">
<?php 
	$paging_info = get_paging_info($total_listing_count,10,$current_page);
	//print_this($paging_info);

?>            
				<style>
                    .pagination .active{
                        background-color:#337ab7;	
                        color:#FFF;
                    }
                </style>
                    <div class="row mt-3">
                        <div class="col-md-12">
                
                            <!-- pagination -->
                            <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center pull-right">

                                <!-- If the current page is more than 1, show the First and Previous links -->
                                <?php 
									if($paging_info['curr_page'] > 1) { 
								?>
                                   
                                    <li class="page-item btn-prev <?php echo ($total_num_of_pages == 1 || $disable_prev == 1) ? 'disabled' : '' ; ?>" data-page="1"> 
                                        <a class="page-link" href="javascript:;" aria-label="Previous"> <i class="fa fa-fast-backward"></i>  </a> 
                                    </li>
                                    
                                    <li class="page-item btn-prev <?php echo ($total_num_of_pages == 1 || $disable_prev == 1) ? 'disabled' : '' ; ?>" data-page="<?php if($total_num_of_pages > 1 && $disable_prev == 0){ echo $current_page - 1; } ?>"> 
                                        <a class="page-link" href="javascript:;" aria-label="Previous"> <i class="fa fa-chevron-left"></i>   </a> 
                                    </li>
                                    <!--<li class="page-item"><a class="page-link" href="javascript:;"> .. </a> </li>-->
                                <?php 
									}//end if($paging_info['curr_page'] > 1)
								?>                              
                
                                <?php 
									
									$max = 7;
									if($paging_info['curr_page'] < $max)
										$sp = 1;
									elseif($paging_info['curr_page'] >= ($paging_info['pages'] - floor($max / 2)) )
										$sp = $paging_info['pages'] - $max + 1;
									elseif($paging_info['curr_page'] >= $max)
										$sp = $paging_info['curr_page']  - floor($max/2);	
										
									 //<!-- If the current page >= $max then show link to 1st page -->								
									 if($paging_info['curr_page'] >= $max) {
								?>
                                		<li class="page-item" data-page="1"><a class="page-link <?php echo ($current_page == '1') ? 'active' : '' ; ?>" href="javascript:;">1</a></li>
                                        <li class="page-item_no"><a class="page-link" href="javascript:;"> .. </a> </li>
                                <?php		 
									 }//end if($paging_info['curr_page'] >= $max) 
									 
									 for($i = $sp; $i <= ($sp + $max -1);$i++){

										if($i > $paging_info['pages'])
											continue;	 
											
										if($paging_info['curr_page'] == $i){
								?>
                                			<li class="page-item" data-page="<?php echo $i; ?>"><a class="page-link <?php echo ($current_page == $i) ? 'active' : '' ; ?>" href="javascript:;"><?php echo $i; ?></a></li>
                                <?php								
										}else{
								?>
			                                <li class="page-item" data-page="<?php echo $i; ?>"><a class="page-link <?php echo ($current_page == $i) ? 'active' : '' ; ?>" href="javascript:;"><?php echo $i; ?></a></li>
                                <?php		
										 }//end if($paging_info['curr_page'] == $i)
											
									 }//end for($i = $sp; $i <= ($sp + $max -1);$i++)
									 
									 //<!-- If the current page is less than say the last page minus $max pages divided by 2-->
									 if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) {
								?>
                                		<li class="page-item_no"><a class="page-link" href="javascript:;"> .. </a> </li>
                                        <li class="page-item" data-page="<?php echo $paging_info['pages']; ?>"><a class="page-link <?php echo ($current_page == $paging_info['pages']) ? 'active' : '' ; ?>" href="javascript:;"><?php echo $paging_info['pages']; ?></a></li>
                                <?php		 
									 }
									 
									 //<!-- Show last two pages if we're not near them -->
									 if($paging_info['curr_page'] < $paging_info['pages']) {
								?>
                                		<li class="page-item btn-prev <?php echo ($total_num_of_pages == 1 || $disable_next == 1) ? 'disabled' : '' ; ?>" data-page="<?php if($total_num_of_pages > 1 && $disable_next == 0){ echo $current_page + 1; }?>"> <a class="page-link" href="javascript:;" aria-label="Next"> <i class="fa fa-chevron-right"></i>   </a> </li>
                                        <li class="page-item" data-page="<?php echo $paging_info['pages']; ?>"> <a class="page-link" href="javascript:;" title="Last" aria-label="Last"> <i class="fa fa-fast-forward"></i>  </a></li>
                                <?php		 
									 }//end if($paging_info['curr_page'] < $paging_info['pages']) 
								?>		
                                
                              </ul>
                            </nav>	
                        </div>
                    </div>
            </td>
        </tr>
		<?php 
			}//end if($total_reviews_count > $no_of_rec_per_page) 
			
	} else {
?>    
        <tr>
	        <td colspan="11">No record found</td>
        </tr>

<?php 
	} //end if(count($list_register_all_entery) > 0) 
?>  