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
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>SOPs Listing <small>SOPs Listing</small></h2>
                <div class="nav navbar-right panel_toolbox">
					     <!-- <a href="<?php echo SURL?>governance/add-update-sop" class="btn btn-sm btn-success">Add New SOPs</a> -->
				</div> 
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
               
                <!-- Start - Sop-Tree -->
                <ul id="governance_sop_read_tree">
<?php
                    if(count($sop_list) > 0){
      
                        foreach($sop_list as $category_name => $nodes_arr){
        
                            $split_category_name = explode('#',$category_name);

                            if($category_name != 'None'){
?>
                                <li><a href="#" style="font-weight:bold"><?php echo filter_string($split_category_name[1]);?></a> 
                                <span>
                                    
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a type="button" href="<?php echo SURL?>governance/add-update-sop-category/<?php echo $split_category_name[0] ?>" class="btn btn-xxs btn-success fancybox_org_sop_category_edit fancybox.ajax white_link"><i class="fa fa-pencil"></i></a>

                                    <a type="button" href="#confirm_delete_sop_category_<?php echo filter_string($split_category_name[0])?>" class="btn btn-xxs btn-danger dialogue_window white_link"><i class="fa fa-times"></i></a>

                                </span>
                                
                                <div id="confirm_delete_sop_category_<?php echo filter_string($split_category_name[0])?>" style="display:none">
                                  <h4>Confirmation</h4>
                                    <p>This will delete all the SOP's which exist in the folder listing. Are you sure you want to delete the selected folder?</p>
                                    <div class="modal-footer"> 
                                      <a class="btn btn-danger" href="<?php echo SURL?>governance/delete-sop-category/<?php echo filter_string($split_category_name[0])?>">Delete</a>
                                        <button type="button" class="btn btn-default" onclick="$.fancybox.close()" >Close</button>
                                        <br />
                                        
                                    </div>
                                </div> <!-- END COnfirmation Fancy Modal -->
                                <ul>
<?php
                            if(count($nodes_arr) > 0){

                              for($i=0;$i<count($nodes_arr);$i++){
?>
                                <li style="font-weight:normal"> <?php echo filter_string($nodes_arr[$i]['sop_title'])?>
                                  &nbsp;&nbsp;&nbsp;

                                  <a href="<?php echo SURL?>governance/add-update-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>/update" class="fancybox_org_sop_edit fancybox.ajax"><button class="btn btn-xxs btn-success" type="button" ><i class="fa fa-pencil"></i></button></a>

                                  <a class="btn btn-xxs btn-danger dialogue_window white_link" type="button" href="#confirm_delete_sop_<?php echo filter_string($nodes_arr[$i]['id'])?>"><i class="fa fa-times"></i></a>
                                  
                                  <div id="confirm_reread_enforce_sop_<?php echo filter_string($nodes_arr[$i]['id'])?>" style="display:none">
                                      
                                      <h4 class="modal-title">Confirmation</h4>
                                      <p>Are you sure you want to enforce your Staff to Read the selected SOP Again?</p>
                                      <div class="modal-footer"> 
                                                                      
                                      <a class="btn btn-success" style="color:#fff"  href="<?php echo SURL?>organization/enforce-reading-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>">Ok</a>

                                      <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
                                      <br />
                                      
                                  </div>
                                  
                                  <div id="confirm_delete_sop_<?php echo filter_string($nodes_arr[$i]['id'])?>" style="display:none" >

                                    <h4 class="modal-title">Confirmation</h4>
                                    <p>This will delete all subsequent records belong to this SOP. Are you sure you want to delete the selected SOP?</p>

                                    <div class="modal-footer">

                                      <a class="btn btn-danger" style="color:#fff"  href="<?php echo SURL?>governance/delete-sop/<?php echo filter_string($nodes_arr[$i]['id'])?>">Delete</a>
                                      <button type="button" class="btn btn-default" onclick="$.fancybox.close();">Close</button>
                                      <br />
                                      
                                    </div>
                                   
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
              <li><a style="color:#0C0" href="<?php echo SURL?>governance/add-update-sop/<?php echo filter_string($split_category_name[0])?>/add" class="fancybox_org_sop_edit fancybox.ajax"> <strong>Add New File</strong> </a></li>
                                        
          </ul>
          
          </li>
<?php
              }//end if($split_category_name != 'None')

          }//end foreach($sop_list as $category_name =>$nodes_arr)

        } else {
?>
          <p><div role="alert" class="alert alert-danger">No File Available!</div></p>  
<?php 
        }//end if(count($sop_list) > 0)
?>

      </ul>
                
      <p style="padding-left:12px;">
          <a href="<?php echo SURL?>governance/add-update-sop-category" class="fancybox_org_sop_edit fancybox.ajax text-success">
            <strong style="color:#0c0"> + Add New Folder </strong>
          </a>
      </p>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
