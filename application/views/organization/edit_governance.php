<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>ORGANISATION GOVERNANCE</strong></div>
      <div class="panel-body">
        <p class="align-left"></p>
        <div class="row">
          <div class="col-md-12">
            <form data-toggle="validator" role="form" action="<?php echo SURL?>organization/edit-governance-process" id="edit_gov_frm" name="edit_gov_frm" method="POST" enctype="multipart/form-data">
              <!-- Start - Global Settings -->
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">

                    <!-- Stat - Governance tabs -->
                    <!--
                    <ul class="nav nav-tabs">
                    
                        <li class="active"><a data-toggle="tab" href="#governance">Governance</a></li>
                        <li><a data-toggle="tab" href="#sops">SOPs</a></li>
                        <li><a data-toggle="tab" href="#finish">Finish</a></li>
                    
                    </ul>
                    -->
                    <!-- Start - Governance tabs body -->
                    <div id="sops">
                    	<p>
							In this section, as a Superintendent, you can edit the Standard Operating Procedures that your staff see once they log in to the Hubnet. We have prewritten over 150 SOPs below for you to edit as needed. You can either delete complete sections which are not needed using the red cross icon or edit the ones that are needed using the green edit icon. Lastly, you can use the orange "Read again" button to force all users to read and sign the SOP again.
						</p>
                        <p>
If you would like to add new staff to read the SOPs, go to the Team Builder section and invite them by email. Once they login they will be asked to read and sign the SOP's, subsequently this will make the icon next to their name in the Team builder go green.                        
                        </p>
                        <p><textarea class="textarea" name="sop_text" id="sop_text" placeholder="Enter SOP Description" style="width: 100%; height: 200px"><?php echo filter_string($organization_governance_arr['sop_text'])?></textarea></p>
                        
                        <style>
                            .tree li{ font-weight:normal}
                            .tree li .white_link{ color:#FFF}
                        </style>
                        <ul id="governance_sop_read_tree" class="tree text-primary">
                        
                        <?php 
                            if(count($organization_sop_list) > 0){
                                
                                foreach($organization_sop_list as $category_name =>$nodes_arr){
                                    
                                    $split_category_name = explode('#',$category_name);

                                    if($category_name != 'None'){
                            ?>	
                                        <li><a href="#" style="font-weight:bold"><?php echo filter_string($split_category_name[1]);?></a> 
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                            <a type="button" href="<?php echo SURL?>organization/edit-sop-category/<?php echo $split_category_name[0] ?>" class="btn btn-xxs btn-success fa fa-pencil fancybox_org_sop_edit fancybox.ajax white_link"></a>
                                            <a type="button" href="#confirm_delete_sop_category_<?php echo filter_string($split_category_name[0])?>" class="btn btn-xxs btn-danger fa fa-times dialogue_window white_link"></a>
                                        </span>
                                        
                                        <div id="confirm_delete_sop_category_<?php echo filter_string($split_category_name[0])?>" style="display:none">
                                            <h4>Confirmation</h4>
                                            <p>This will delete all the SOP's which exist in the folder listing. Are you sure you want to delete the selected folder?</p>
                                            <div class="modal-footer"> 
                                                <a class="btn btn-danger" href="<?php echo SURL?>organization/delete-organization-sop-category/<?php echo filter_string($split_category_name[0])?>">Delete</a>
                                                <button type="button" class="btn btn-default" onclick="$.fancybox.close()" >Close</button>
                                                <br />
                                                <em class="bg-info text-info"><i class="fa fa-info-circle"></i> This applies on all Location staff members in an Organisation.</em> 
                                            </div>
                                        </div> <!-- END COnfirmation Fancy Modal -->
                                        <ul>
                            <?php			
                                            if(count($nodes_arr) > 0){
                                                for($i=0;$i<count($nodes_arr);$i++){
                                ?>
                                                    <li style="font-weight:normal"> <?php echo filter_string($nodes_arr[$i]['sop_title'])?> 
                                                        <a href="<?php echo SURL?>organization/edit-organization-sop/<?php echo filter_string($split_category_name[0])?>/<?php echo filter_string($nodes_arr[$i]['id'])?>" class="fancybox_org_sop_edit fancybox.ajax"><button class="btn btn-xxs btn-success" type="button" ><i class="fa fa-pencil"></i></button></a>  

                                                        <a class="btn btn-xxs btn-danger dialogue_window white_link" type="button" href="#confirm_delete_sop_<?php echo filter_string($nodes_arr[$i]['id'])?>"><i class="fa fa-times"></i></a>
                                                        
                                                         
                                                        <a class="btn btn-xxs btn-warning dialogue_window white_link" type="button" href="#confirm_reread_enforce_sop_<?php echo filter_string($nodes_arr[$i]['id'])?>"><i class="fa fa-retweet"></i> Read Again</a>
                                                        <div id="confirm_reread_enforce_sop_<?php echo filter_string($nodes_arr[$i]['id'])?>" style="display:none">
                                                                <h4 class="modal-title">Confirmation</h4>
                                                                <p>Are you sure you want to enforce your Staff to Read the selected SOP Again?</p>
                                                              <div class="modal-footer"> 
                                                                <a class="btn btn-success" style="color:#fff"  href="<?php echo SURL?>organization/enforce-reading-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>">Ok</a>
                                                                <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
                                                                <br />
                                                                <em class="bg-info text-info"><i class="fa fa-info-circle"></i> This applies on all Location staff members in an Organisation.</em> </div>
                                                        </div>
                                                        
                                                        <div id="confirm_delete_sop_<?php echo filter_string($nodes_arr[$i]['id'])?>" style="display:none" >

                                                            <h4 class="modal-title">Confirmation</h4>
                                                            <p>This will delete all subsequent records belong to this SOP. Are you sure you want to delete the selected SOP?</p>
                                                          <div class="modal-footer"> 
                                                            <a class="btn btn-danger" style="color:#fff"  href="<?php echo SURL?>organization/delete-organization-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>">Delete</a>
                                                            <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
                                                            <br />
                                                            <em class="bg-info text-info"><i class="fa fa-info-circle"></i> This applies on all Location staff members in an Organisation.</em> </div>
                                                         
                                                        </div>
                                                    </li>
                                <?php
                                                }//end for($i=0;$i<count($nodes_arr);$i++)
                                            }else{
                            ?>
                                                <li style="font-weight:normal;"><span class="text-danger"><strong>No File Listed in this folder</strong></span></li>
                            <?php					
                                            }//end if(count($nodes_arr) > 0)
                            ?>
                                                <li><a style="color:#0C0" href="<?php echo SURL?>organization/edit-organization-sop/<?php echo filter_string($split_category_name[0])?>" class="fancybox_org_sop_edit fancybox.ajax"> <strong>Add New File</strong> </a></li>
                                                
                                            </ul>
                                        </li>
                            <?php
                                    }//end if($split_category_name != 'None')

                                }//end foreach($organization_sop_list as $category_name =>$nodes_arr)
                            ?>
                                <!-- Deleted -->
                                <!-- &nbsp;&nbsp;
                                <li><h4>SOP Files with No Folder</h4></li> -->
                            <?php
                                // <!-- Deleted -->
                                /*
                                for($i=0;$i<count($organization_sop_list['None']);$i++){
                            ?>
                                    <li style="font-weight:normal"> <?php echo filter_string($organization_sop_list['None'][$i]['sop_title'])?> 
                                    <a href="<?php echo SURL?>organization/edit-organization-sop/<?php echo filter_string($organization_sop_list['None'][$i]['category_id'])?>/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>" class="fancybox_org_sop_edit fancybox.ajax"><button class="btn btn-xxs btn-success" type="button" title="Edit"><i class="fa fa-pencil"></i></button></a>
                                    
                                    <button class="btn btn-xxs dialogue_window btn-danger" type="button" href="#confirm_delete_sop_<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>"><i class="fa fa-times"></i></button>
                                    
                                    <a class="btn btn-xxs btn-warning dialogue_window white_link" type="button" href="#confirm_reread_enforce_sop_<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>"><i class="fa fa-retweet"></i> Read Again</a></li>
                                    
                                    
                                    <div id="confirm_reread_enforce_sop_<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>" style="display:none">
                                        <h4 class="modal-title">Confirmation</h4>
                                        <p>Are you sure you want to enforce your Staff to Read the selected SOP Again?</p>
                                        <div class="modal-footer">
                                            <a class="btn btn-success" style="color:#fff"  href="<?php echo SURL?>organization/enforce-reading-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>">Ok</a>
                                            <button type="button" class="btn btn-default" onclick="$.fancybox.close()">Close</button><br />
                                            <em class="bg-info text-info"><i class="fa fa-info-circle"></i> This applies on all Location staff members in an Organisation.</em>
                                        </div>
                                    </div>
                                    
                                    <div id="confirm_delete_sop_<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>" style="display:none" >
                                        <h4 class="modal-title">Confirmation</h4>
                                        <p>This will delete all subsequent records belong to this SOP. Are you sure you want to delete the selected SOP?</p>
                                      <div class="modal-footer"> <a class="btn btn-danger" style="color:#fff"  href="<?php echo SURL?>organization/delete-organization-sop/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>">Delete</a>
                                        <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
                                        <br />
                                        <em class="bg-info text-info"><i class="fa fa-info-circle"></i> This applies on all Location staff members in an Organisation.</em> </div>
                                    </div>
                            <?php			
                                }//end for

                                */
                            }else{
                            ?>
                                 <p><div role="alert" class="alert alert-danger">No File Available!</div></p>  
                            <?php	
                            }//end if(count($organization_sop_list) > 0)
                            ?>
                           <!-- <a style="color:#0C0; padding-left:12px; " href="< ?php echo SURL?>organization/edit-organization-sop/< ?php echo filter_string($sop_none_category_detail['id'])?>" class="fancybox_org_sop_edit fancybox.ajax"> <strong>Add New File</strong> </a> -->
                        </ul>
                        
                        <p style="padding-left:12px;">
                            <a href="<?php echo SURL?>organization/edit-sop-category" class="fancybox_org_sop_edit fancybox.ajax text-success"> <strong style="color:#0c0">Add New Folder</strong> </a>
                        </p>
                        
                    </div>
                    <!-- End - Governance tabs body -->
                </div>
              </div>
              <hr />
              	<p class="text-right"><button class="btn btn-success marg2" type="submit" name="update_governance_btn" id="update_governance_btn">Update Governance</button></p>
            </form>
            
            
            <!-- End - Global Settings --> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>