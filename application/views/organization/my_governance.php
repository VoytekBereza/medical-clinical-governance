<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default"> 
      <!-- Default panel contents -->
      <div class="panel-heading">
        <strong> SOPs</strong>
      </div>
      <div class="panel-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div id="sops">
                        <p>
                            <style>
                                .tree li{ font-weight:normal; }
                                .tree li a { color:#fff}
                            </style>
                            <ul id="governance_sop_read_tree" class="tree text-primary">

                            <?php 
                            
                                if(count($organization_sop_list) > 0){
                                    foreach($organization_sop_list as $category_name =>$nodes_arr){
                                        
                                        $split_category_name = explode('#',$category_name);
                                        
                                        if($category_name != 'None'){
                                            
                                            if(count($nodes_arr) > 0){
                                ?>	
                                                <li><a href="#" style="font-weight:bold;color:#369"><?php echo filter_string($split_category_name[1]);?></a> 
                                                <ul>
                                    <?php		
                                                    for($i=0;$i<count($nodes_arr);$i++){
                                    ?>
                                                        <li style="font-weight:normal"> 
                                    <?php 					
                                                            echo filter_string($nodes_arr[$i]['sop_title']);
    
                                                            $index_key = array_search(filter_string($nodes_arr[$i]['id']), array_column($user_sop_read_list, 'sop_id'));
                                                            if(is_numeric($index_key)){
                                                                $pharmacy_surgery_id = $user_sop_read_list[$index_key]['pharmacy_surgery_id'];
                                    ?>
                                                                <a class="btn btn-xxs btn-success" href="<?php echo SURL?>/organization/download-read-and-signed-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>/<?php echo filter_string($pharmacy_surgery_id)?>" title="Download SOP"><i class="fa fa-certificate"></i> Download</a>
                                    <?php						
                                                            }else{
                                    ?>
                                                                <!--<span id="read_btn_< ?php echo filter_string($nodes_arr[$i]['id'])?>"><a href="<?php echo SURL?>organization/read-and-sign-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>" class="fancybox_read_and_sign_sop fancybox.ajax" ><button class="btn btn-xxs btn-danger" type="button" title="Read and Sign"><i class="fa fa-book"></i> Read and Sign</button></a></span>-->                                	
                                    <?php														
                                                            }//end if(array_search(filter_string($nodes_arr[$i]['id']), array_column($user_sop_read_list, 'id')))
                                    ?> 
                                                        </li>
                                    <?php
                                                    }//end for
                                    ?>
                                                </ul>
                                                </li>
                                <?php
                                            }//end if(count($nodes_arr) > 0)
                                            
                                        }//end if($category_name != 'None')
                                    }//end foreach($organization_sop_list as $category_name =>$nodes_arr)

                                    for($i=0;$i<count($organization_sop_list['None']);$i++){
                                ?>
                                        <li style="font-weight:normal"> 
                                <?php 
                                            echo filter_string($organization_sop_list['None'][$i]['sop_title']);
                                            $index_key = array_search(filter_string($organization_sop_list['None'][$i]['id']), array_column($user_sop_read_list, 'sop_id'));
                                            if(is_numeric($index_key)){
                                                $pharmacy_surgery_id = $user_sop_read_list[$index_key]['pharmacy_surgery_id'];
                                ?>
                                                <a class="btn btn-xxs btn-success while_link" href="<?php echo SURL?>/organization/download-read-and-signed-sop/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>/<?php echo filter_string($pharmacy_surgery_id)?>" title="Download SOP"><i class="fa fa-certificate"></i> Download</a>
                                <?php				
                                            }else{
                                ?>
                                               <!-- <span id="read_btn_<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>"><a href="<?php echo SURL?>organization/read-and-sign-sop/<?php echo filter_string($organization_sop_list['None'][$i]['id'])?>" class="fancybox_read_and_sign_sop fancybox.ajax" ><button class="btn btn-xxs btn-danger" type="button" title="Read and Sign"><i class="fa fa-book"></i> Read and Sign</button></a></span>-->
                                <?php				
                                            }//end if(is_numeric($index_key))
                                            
                                    }//end for
                                }else{
                                ?>
                                     <p><div role="alert" class="alert alert-danger">No SOP's Available!</div></p>  
                                <?php	
                                }//end if(count($organization_sop_list) > 0)
                                ?>
                            
                            </ul>
                        </p>
                    </div>
                </div>                        
                </div><!-- End Col-->
            </div><!-- End Row-->
      </div>
    </div>
  </div>
