<?php 

	$active_tab = $this->input->get('t');
	
    // Set if submition fiald showing data in fields which is user filled 
?>
<div class="panel panel-default"> 
	<div class="panel-heading"><strong><?php echo filter_string($cms_data_arr['page_title'])?></strong></div>
    <div class="panel-body">
        
        <div class="row">
          <div class="col-md-12">
            <div class="tab-content">
              <div id="introduction_tab" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12"> <br />
                   <?php echo filter_string($cms_data_arr['page_description'])?>
                  </div>
                </div>
                
                <div class="row">
                	<?php 
						if(count($video_listing) > 0){
							for($i=0; $i<count($video_listing); $i++){
							?>
								  <div class="col-md-6">
                                  <iframe width="350" height="300" src="<?php echo filter_string($video_listing[$i]['video_url'])?>" frameborder="0" allowfullscreen id="video_frame"></iframe>
									<br />
									<strong><?php echo filter_string($video_listing[$i]['video_title'])?></strong>
								  </div>  
							<?php		
								}//end for($i=0; $i<count($video_listing); $i++)							
						}else{
					?>
                    		<div class="col-md-12"><div class="alert alert-danger">No Videos Available</div> </div>
                    <?php		
						}//end if(count($video_listing) > 0)
						
						
					?>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>   