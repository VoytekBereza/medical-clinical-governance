<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		
		<!-- Text Description -->
		<div class="jumbotron">
		
			<!-- Heading -->
			<h3> <?php echo ($page_data['page_title'] != '') ? $page_data['page_title'] : '' ; ?> </h3>
			
			<!-- Description -->
			<?php echo ($page_data['page_description'] != '') ? filter_string($page_data['page_description']) : '' ; ?>
			
		</div>
		
		<style>.tree li{ font-weight:normal}</style>
		<!-- Start - List all quick forms documents -->
		
		<div class="row">
			<?php 
				if(count($nhs_comissioning_arr) > 0){ 
				
					$j = 1;
					foreach($nhs_comissioning_arr as $category_name =>$each){
			?>
                        <div class="col-md-4"> 
                            <ul class="tree" id="quick_form_doc">
                                <li>
                                    <h3 class="text-warning"> <?php echo filter_string($category_name)?></h3>
                                    <ul>
                                        <?php 
                                            
                                            for($i=0;$i<count($each);$i++){
                                        ?>
                                                <li><i class="<?php echo filter_string($each[$i]['document_icon']); ?> fa-lg"></i> <a href="<?php echo filter_string($each[$i]['document_url']); ?>" target="_blank"> <?php echo filter_string($each[$i]['document_title']); ?> </a></li>                                    
                                        <?php		
                                            }//end for($i=0$i<count($each)$i++)
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
            <?php		
						if($j%3 == 0) echo '</div><div class="row">'; 
						$j++;

					}//end foreach($nhs_comissioning_arr as $category_name =>$each)
					
				}//end if(count($nhs_comissioning_arr) > 0)
			?>
		</div>
		
	</div> <!-- end col... -->
</div> <!-- end row -->
