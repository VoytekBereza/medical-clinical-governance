<style>
        
  /* Tree View */
  .tree, .tree ul {
      margin:0;
      padding:0;
      list-style:none
  }
  .tree ul {
      margin-left:1em;
      position:relative
  }
  .tree ul ul {
      margin-left:.5em
  }
  .tree ul:before {
      content:"";
      display:block;
      width:0;
      position:absolute;
      top:0;
      bottom:0;
      left:0;
      border-left:1px solid
  }
  .tree li {
      margin:0;
      padding:0 1em;
      line-height:2em;
      color:#369;
      font-weight:700;
      position:relative
  }
  .tree ul li:before {
      content:"";
      display:block;
      width:10px;
      height:0;
      border-top:1px solid;
      margin-top:-1px;
      position:absolute;
      top:1em;
      left:0
  }
  .tree ul li:last-child:before {
      background:#fff;
      height:auto;
      top:1em;
      bottom:0
  }
  .indicator {
      margin-right:5px;
  }
  .tree li a {
      text-decoration: none;
      color:#369;
  }
  .tree li button, .tree li button:active, .tree li button:focus {
      /*text-decoration: none;
      color:#369;
      border:none;
      background:transparent;
      margin:0px 0px 0px 0px;
      padding:0px 0px 0px 0px;
      outline: 0;
    */
  }

  .btn-xxs{
      padding: 1px 10px;
      border: 0 none;
      font-weight: 700;
      letter-spacing: 0;
      font-size: 84%;
  }

</style>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
			<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php } // end if($this->session->flashdata('err_message')) ?>
        <?php if($this->session->flashdata('ok_message')){?>
        		<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }    //if($this->session->flashdata('ok_message'))  ?>
        
		</div>
		<div class="row">
			<div class="x_title">
				<h2><?php echo filter_string($pgd_arr['pgd_name']); ?> Documents</h2>
                 
				 <!--<div class="nav navbar-right panel_toolbox">
					<a href="<?php echo base_url(); ?>pgd/add_edit_document/<?php echo $package_pgd_id; ?>" class="btn btn-sm btn-success">Add New</a>
				</div>-->
				<div class="clearfix"></div>
			</div>
			<br>
            
		<style>
			.tree li{ font-weight:normal}
			.tree li .white_link{ color:#FFF}
        </style>

        <ul id="governance_sop_read_tree" class="tree text-primary list-unstyled">
                            
			<?php 
                if(count($categories_list) > 0){
					
                    foreach($categories_list as $category_name =>$nodes_arr){
                        
                        $split_category_name = explode('#',$category_name);
						
                        if($category_name != 'None'){
                ?>	
                            <li>
                                <a href="#" style="font-weight:bold">
                                    
                                    <?php echo filter_string($split_category_name[1]);?>
                                    
                                </a> 
                            <span>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="<?php echo SURL?>pgd/edit-document-category/<?php echo $get_pgd_details['id'];?>/<?php echo filter_string($split_category_name[0]);?>" class="fancybox_view_document fancybox.ajax"><button class="btn btn-xxs btn-success" type="button" title="Edit"><i class="fa fa-pencil"></i></button></a>
                                
                                <a  href="#confirm_delete_category_<?php echo filter_string($split_category_name[0])?>" data-toggle="modal" title="Delete Category" class="btn btn-xxs btn-danger  dialogue_window white_link"><i class="fa fa-times"></i>
                                </a>

                            </span>
                             
                             <!-- Strart Confirmation  Modal -->
                             <div class="modal fade" id="confirm_delete_category_<?php echo filter_string($split_category_name[0])?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4> Confirmation! </h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete "<?php echo filter_string($split_category_name[1])?>" category ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <a href="<?php echo SURL ?>pgd/delete-document-category/<?php echo $get_pgd_details['id'];?>/<?php echo filter_string($split_category_name[0])?>" class="btn btn-danger btn-ok">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>	
                            
                           <!-- END COnfirmation  Modal -->
                            <ul class="list-unstyled">
                <?php			
                                if(count($nodes_arr) > 0){
                                    for($i=0;$i<count($nodes_arr);$i++){
                    ?>
                                        <li style="font-weight:normal">

                                            <?php echo filter_string($nodes_arr[$i]['document_title'])?>
                                            &nbsp; &nbsp; &nbsp;
                                            <a href="<?php echo SURL?>pgd/edit-document/<?php echo $get_pgd_details['id'];?>/<?php echo filter_string($split_category_name[0]);?>/<?php echo filter_string($nodes_arr[$i]['id'])?>" class="fancybox_view_document fancybox.ajax">
                                                
                                                <button class="btn btn-xxs btn-success" type="button" title="Edit"><i class="fa fa-pencil"></i></button>

                                            </a>  

                                            <a class="btn btn-xxs btn-danger dialogue_window white_link" data-toggle="modal" title="Delete Document" href="#confirm_delete_document<?php echo filter_string($nodes_arr[$i]['id'])?>"><i class="fa fa-times"></i></a>
                                            
                                            <div class="modal fade" id="confirm_delete_document<?php echo filter_string($nodes_arr[$i]['id'])?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4> Confirmation! </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete "<?php echo filter_string($nodes_arr[$i]['document_title'])?>" file ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <a href="<?php echo SURL ?>pgd/delete-document/<?php echo $get_pgd_details['id'];?>/<?php echo $nodes_arr[$i]['id']?>" class="btn btn-danger btn-ok">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                                            
                                        </li>
                    <?php
                                    }//end for($i=0;$i<count($nodes_arr);$i++)
                                }else{
                ?>
                                    <li style="font-weight:normal;"><span class="text-danger"><strong>No File Listed in this Category</strong></span></li>
                <?php					
                                }//end if(count($nodes_arr) > 0)
								
                ?>
                                <li style="font-weight:normal">
                                     
                                    <a href="<?php echo SURL?>pgd/edit-document/<?php echo $get_pgd_details['id'];?>/<?php echo filter_string($split_category_name[0]);?>" class="fancybox_view_document fancybox.ajax" style="color: #26B99A;">

                                      <strong>Add New File</strong>
                                      
                                    </a>

                                    <div style="display:none" id="cate_id_<?php echo filter_string($split_category_name[0])?>"; >

                                        <form   class="form-horizontal form-label-left" action="<?php echo base_url(); ?>pgd/add-update-document" method="post" id="add_update_document_form<?php echo $split_category_name[0];?>" name="add_update_document_form<?php echo $i;?>">
                                          <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                	<div class="col-md-3 col-sm-3 col-xs-3 form-group validate_msg">
                                                        <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Select document type">
															Document Type* <i class="fa fa-info-circle"></i>
														</label>
                                                   	    <select class="form-control" name="document_icon" id="document_icon" required="required" >
                                                              <option value="">Select Document Type</option>
                                                              <option value="fa fa-file-pdf-o">PDF</option>
                                                              <option value="fa fa-file-word-o">DOC</option>
                                                              <option value="fa fa-file-powerpoint-o">PPT</option>
                                                              <option value="fa fa-file-zip-o">Zip</option>
                                                              <option value="fa fa-file-video-o">Video</option>
                                                              <option value="fa fa-file-audio-o">Audio</option>
                                                              <option value="fa fa-file-excel-o">CSV</option>
                                                              <option value="fa fa-file-o">General Type</option>
                                                        </select>
                              							 <div class="help-block with-errors"></div>
                                                    </div>
                                                    
                                                    <div class="col-md-3 col-sm-3 col-xs-3 form-group validate_msg">
                                                        <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add document title">
															Document Title* <i class="fa fa-info-circle"></i> </label>
						    							</label>
                                                   	    	<input type="text" class="form-control" name="document_title" id="document_title"  required="required"/>
                                                    	<div class="help-block with-errors"></div>
                                                    </div>
                                                    
                                                    <div class="col-md-3 col-sm-3 col-xs-3 form-group validate_msg">
                                                        <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add document url">
															Document Url* <i class="fa fa-info-circle"></i> </label>
						    							</label>
                                                   	    	<input type="url" class="form-control" name="document_url" required="required" />
                                                    	<div class="help-block with-errors"></div>
                                                    </div>
                                                
                                                	<div class="col-md-2 col-sm-2 col-xs-2 form-group validate_msg">
                                                        <label>
                                                        Status
                                                        </label>
                                                        <select class="form-control" name="status" id="status" required="required" >
                                                        <option value="1">Active</option>
                                                        <option value="0">InActive</option>
                                                        </select>
                                                	</div>
                                                
                                                <br> 
                                                <!-- Form (add_update_category_form) - submit button -->
                                                 	<div class="col-md-1 col-sm-1 col-xs-1 form-group pull-right" style="padding-top:5px;">
                                                		<button type="submit" class="btn btn-sm btn-success" name="add_edit_category_btn" onclick="document_form_add(<?php echo $split_category_name[0];?>)">Add new</button>
                                                	</div>
                                                </div>
                                          </div>
                                                <!-- Input Hidden Field -->
                                               
                                                <input type="hidden" name="package_pgd_id" value="<?php echo $get_pgd_details['id']; ?>" />
                                                <input type="hidden" name="category_id" value="<?php echo filter_string($split_category_name[0])?>" />
                                                <input type="hidden" name="action" value="add" />
                                                
                                        </form>
                                    </div>
                               </li>
                                </ul>
                            </li>
                <?php
                        }//end if($split_category_name != 'None')

                    }//end foreach($categories_list as $category_name =>$nodes_arr)
                ?>
                    
                <?php
                      for($i=0;$i<count($categories_list['None']);$i++){
                ?>
                        <li style="font-weight:normal">
                            
                            <span class="glyphicon glyphicon-file"></span>
                            <?php echo filter_string($categories_list['None'][$i]['document_title'])?>
                            &nbsp; &nbsp; &nbsp;
                            <a href="<?php echo SURL?>pgd/edit-document/<?php echo $get_pgd_details['id'];?>/None/<?php echo filter_string($categories_list['None'][$i]['id'])?>" class="fancybox_view_document fancybox.ajax"><button class="btn btn-xxs btn-success" type="button" title="Edit"><i class="fa fa-pencil"></i></button></a>
                            
                            <a class="btn btn-xxs btn-danger dialogue_window white_link" data-toggle="modal" title="Delete Document" href="#confirm_delete_document<?php echo filter_string($categories_list['None'][$i]['id'])?>"><i class="fa fa-times"></i>
                            </a>

                        </li>
                        
                             <div class="modal fade" id="confirm_delete_document<?php echo filter_string($categories_list['None'][$i]['id'])?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4> Confirmation! </h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete "<?php echo filter_string($categories_list['None'][$i]['document_title'])?>" file?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <a href="<?php echo SURL ?>pgd/delete-document/<?php echo $get_pgd_details['id'];?>/<?php echo $categories_list['None'][$i]['id']?>" class="btn btn-danger btn-ok">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php			
                    }//end for
				 }else{
                ?>
                     <p><div role="alert" class="">No File Available!</div></p>  
                <?php	
                }//end if(count($categories_list) > 0)
                ?>
                  
                  <li style="font-weight:normal">
                    
                    <a href="javascript:;" data-toggle="modal" data-target="#add_new_none_file_model" >
                        <strong style="color: #26B99A;"> + Add New File </strong>
                    </a>

                  </li>

                  <li style="font-weight:normal">
                    
                    <a href="javascript:;" data-toggle="modal" data-target="#add_new_folder_model" >
                        <strong style="color: #26B99A;" > + Add New Folder </strong>
                    </a>

                  </li>
                  
            </ul>            
		</div>
      </div>
    </div>
  </div>
</div>

<!-- Kod-Modals -->
<!-- Modal - add_new_folder_model -->
<div id="add_new_folder_model" class="modal fade" role="dialog">
  <div class="modal-dialog">

  <form  data-toggle="validator" role="form" class="form-horizontal form-label-left form_validate" action="<?php echo base_url(); ?>pgd/add-update-category" method="post" id="add_update_document_form" name="add_update_document_form">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New Folder</h4>
          </div>
          <div class="modal-body">
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <div class="col-md-6 col-sm-6 col-xs-6 form-group validate_msg">
                        <label>
                            Folder Name*
                        </label>
                        <input type="text" class="form-control" name="category_name" id="category_name" required="required" value="" />
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                        <label>
                            Status
                        </label>
                        <select class="form-control" name="status" id="status" required="required" >
                              <option value="1" <?php echo ($category['status'] == '1') ? 'selected="selected"' : '' ?>>Active</option>
                              <option value="0" <?php echo ($category['status'] == '0') ? 'selected="selected"' : '' ?>>InActive</option>
                        </select>
                    </div>
                    
                    <br> 
                    
                </div>
            </div>
            <!-- Input Hidden Field -->
            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>" />
            <input type="hidden" name="action" value="<?php echo $form_action; ?>" />
            <input type="hidden" name="pgd_id" value="<?php echo $pgd_id; ?>" />        
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="add_edit_category_btn">Add New Folder</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    
    </form>

  </div>
</div>

<!-- Modal - add_new_none_file_model -->
<div id="add_new_none_file_model" class="modal fade" role="dialog">
  <div class="modal-dialog">

  <form class="form-horizontal form-label-left form_validate2" action="<?php echo base_url(); ?>pgd/add-update-document" method="post" id="add_update_document_form" name="add_update_document_form">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New File</h4>
        </div>
        <div class="modal-body">
        
              <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group validate_msg">
                            
                            <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Select document type"> Document Type* <i class="fa fa-info-circle"></i> </label>
                            <select class="form-control" name="document_icon" id="document_icon" required="required" >
                                  <option value="">Select Document Type</option>
                                  <option value="fa fa-file-pdf-o">PDF</option>
                                  <option value="fa fa-file-word-o">DOC</option>
                                  <option value="fa fa-file-powerpoint-o">PPT</option>
                                  <option value="fa fa-file-zip-o">Zip</option>
                                  <option value="fa fa-file-video-o">Video</option>
                                  <option value="fa fa-file-audio-o">Audio</option>
                                  <option value="fa fa-file-excel-o">CSV</option>
                                  <option value="fa fa-file-o">General Type</option>
                            </select>
                            <div class="help-block with-errors"></div>

                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group validate_msg">
                            <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add document title">
            Document Title* <i class="fa fa-info-circle"></i> </label>
            </label>
                              <input type="text" class="form-control" name="document_title" id="document_title"  required="required"/>
                          <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group validate_msg">
                            <label for="middle-name"  data-toggle="tooltip" data-placement="right"  title="Add document url">
            Document Url* <i class="fa fa-info-circle"></i> </label>
            </label>
                              <input type="url" class="form-control" name="document_url" required="required" />
                          <div class="help-block with-errors"></div>
                        </div>
                    
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group validate_msg">
                            <label>
                            Status
                            </label>
                            <select class="form-control" name="status" id="status" required="required" >
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                            </select>
                      </div>

                    </div>
              </div>
              <!-- Input Hidden Field -->
              <input type="hidden" name="package_pgd_id" value="<?php echo $get_pgd_details['id']; ?>" />
              <input type="hidden" name="category_id" value="0" />
              <input type="hidden" name="action" value="add" />
            
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success" name="add_edit_category_btn">Add new</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    
    </form>

  </div>
</div>