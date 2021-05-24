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
		</div>
		<div class="row">
			<div class="x_title">
				<h2>Upload Media</h2>
				<div class="clearfix"></div>
			</div>
                <form method="post" name="upload_media_frm" id="upload_media_frm"  action="<?php echo SURL?>settings/upload-media-process" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="file" class="form-control" name="upload_media" id="upload_media"  required/>
                        </div>
                        <div class="col-md-2">
                        	<input type="submit" name="upload_media_btn" id="upload_media_btn" class="btn btn-danger" value="Upload" />
                        </div>
                        
                    </div>
                    
                </form>            
			<br>
             <table class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<thead>
					<tr class="headings">
						<th>Thumbnail</th>
                        <th>Link</th>
					</tr>
				</thead>

				<tbody>
					<?php
                    $dir = ".././assets/media/";
                    
                    if (is_dir($dir)){
						
                      if ($dh = opendir($dir)){
						  
                        while (($file = readdir($dh)) !== false){
							
							$ignore_file = array('.','..','index.php');
							
							if(!in_array($file,$ignore_file)){
					?>
                                <tr class="even pointer">
                                    <td>
                                    	<?php 
											$extension = strtolower(pathinfo($dir.$file, PATHINFO_EXTENSION));
											$image_extension = array('jpg','jpeg','gif','bmp','png');
											
											if(in_array($extension,$image_extension)){
										?>
                                        		<a href="<?php echo FRONT_SURL.'assets/media/'.$file?>" target="_blank"><img src="<?php echo FRONT_SURL.'assets/media/'.$file?>" width="200" /></a>
                                        <?php
											}else{
										?>
                                        		<a href="<?php echo FRONT_SURL.'assets/media/'.$file?>" target="_blank"><?php echo $file ?></a>
                                        <?php		
											}//end if(in_array($extension,$image_extension)
											
										?>
                                    </td>
                                    <td><?php echo FRONT_SURL.'assets/media/'.$file?></td>
                                </tr>
                    <?php
							}//end if(!in_array($file,$ignore_file))
							
                        }//end while (($file = readdir($dh)) !== false)
						
                        closedir($dh);
						
                      }//end if ($dh = opendir($dir))
					  
                    }//end if (is_dir($dir))
                    ?>            
                </tbody>
			</table>
		</div>
      </div>
    </div>
  </div>
  
</div>