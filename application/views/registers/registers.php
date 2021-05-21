<?php   
	if($active_tab != ''){
	  $active_tab = $active_tab;
	} else {
	  $active_tab = $this->input->get('t');
	}

	$REGISTER_BLUE_TEXT = 'REGISTER_BLUE_TEXT';
	$register_blue_text = get_global_settings($REGISTER_BLUE_TEXT); //Set from the Global Settings
	$register_blue_text = filter_string($register_blue_text['setting_value']);

?>

<div class="panel panel-default"> 
  <!-- Default panel contents -->
  <div class="panel-heading"><strong>Registers</strong></div>
  <div class="panel-body"> 
    <div class="row">
      <div class="col-md-12">
      	<?php 
			if(!$this->session->dismiss_message['register']){
		?>
                <p class="alert alert-info in alert-dismissable">
                    <a href="#" data-pharmacy="" data-org="<?php echo $this->session->organization_id?>" data-type="register" class="close dismiss_message" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <i class="fa fa-info-circle"></i> <?php echo $register_blue_text; ?>
                </p>
        <?php		
			}//end if(!$this->session->dismiss_message['register'])
		?>
      
              
        <ul class="nav nav-tabs">
          <li class="<?php if($active_tab==1 || $active_tab =='') { ?>active<?php } ?>"><a data-toggle="tab" href="#controlled_tab">Controlled Drugs</a></li>
          <li  class="<?php if($active_tab==2) { ?>active<?php } ?>"><a data-toggle="tab" href="#return_tab">CD Returns/ Destruction</a></li>
          <li class="<?php if($active_tab==3) { ?>active<?php } ?>"><a data-toggle="tab" href="#pom_tab">POM Private</a></li>
          <li class="<?php if($active_tab==4) { ?>active<?php } ?>"><a data-toggle="tab" href="#specials_tab">Specials</a></li>
          <li class="<?php if($active_tab==5) { ?>active<?php } ?>"><a data-toggle="tab" href="#emergency_tab">Emergency Supply</a></li>
          <li class="<?php if($active_tab==6) { ?>active<?php } ?>"><a data-toggle="tab" href="#archives_tab">Archives</a></li>
        </ul>
        <div class="tab-content">
              <div id="controlled_tab" class="tab-pane fade in <?php if($active_tab==1 || $active_tab =='') { ?>active<?php } ?>">
                <br />
                <div class="row">
             
                <?php 
					if($this->session->flashdata('drug_id') !=''){
						 $drug_id_select_box = $this->session->flashdata('drug_id');
					} else if($drug_id_select_box !=''){
						$drug_id_select_box = $drug_id_select_box;
					} else if($get_drug_last_id['id'] !='') {
					   $drug_id_select_box = $get_drug_last_id['id'];
					} 
					
					
					if($this->session->flashdata('drug_id_cd_return') !=''){
						$drug_id_cd_return_select_box = $this->session->flashdata('drug_id_cd_return');
					} else if($drug_id_cd_return_select_box !=''){
						$drug_id_cd_return_select_box = $drug_id_cd_return_select_box;
					} else if($get_cd_return_last_id['id'] !='') {
						$drug_id_cd_return_select_box = $get_cd_return_last_id['id'];
					} 						
				?>
                
                    <div class="col-md-6"> 
                        <?php 
							if(!empty($list_all_drug)){
						?>
                    
                               <form data-toggle="validator" role="form" action="<?php echo SURL?>registers" method="post" name="drug_frm" id="drug_frm" >
                               
                                    <input type="hidden" id="drug_hidden_id" name="drug_hidden_id" value="<?php echo $get_drug_last_id['id'];?>" readonly="readonly">
                                    <select class="form-control input-sm" id="drug_id" name="drug_id">
                                        
                                        <?php 
											$single_item = 0;
                                            foreach($list_all_drug as $each){
                                                if($each['status'] == '1'){
													$single_item = 1;
                                        ?>
                                                    <option value="<?php echo $each['id'];?>" <?php if($drug_id_select_box ==$each['id']){?> selected="selected"<?php }?>><?php echo  filter_string($each['drug_name']).' '.filter_string($each['drug_form']).' '.filter_string($each['drug_strength']);?></option>
                                        <?php 	
                                                }//end if($each['staus'] == '1')
                                            } // End for loop
                                        ?>
                                    </select>
                                 	<button type="submit" id="submit-add-new" class="btn btn-primary hidden" formnovalidate>Just submit</button>
                                </form>
                    	<?php 
							}
						?>
                    </div>
                    <div class="col-md-6"> 
                    	Click the button to the add a new register:
                        <a class="blue fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-registers/1"><button class="btn btn-sm  btn-success pull-right">Add New Register</button></a>
                    </div>
                        <?php 
							if(!empty($list_all_drug) && $single_item == 1){
						?>
								<br /><br />                        
                                <div class="col-md-3 text-right">

                                <div class="input-group">
                                  <input type="text"  name="src_keyword" id="src_keyword" class="form-control" placeholder="Search Keyword"  aria-describedby="search_reg_btn" value="<?php echo $this->session->flashdata('src') ?>">
                                  <span class="input-group-addon" id="search_reg_btn" style="cursor:pointer" ><i class="fa fa-search"></i></span>
                                </div>                                    
                                </div>
                                <div class="col-md-9 text-right">
                                
                                    <a class="btn btn-sm btn-success fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-supplier" style="color:#FFF">Add Supplier</a>
                                
                                    <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-prescriber" style="color:#FFF">Add Prescriber</a>
                                    <a class="btn btn-sm btn-danger fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-patient" style="color:#FFF">Add Patient</a>
                                     <a class="btn btn-sm btn-primary fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/check-balance/1/<?php echo $drug_id_select_box;?>" style="color:#FFF">Balance Check</a>
                                     
                                     <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>registers/common-pdf/1/<?php echo $drug_id_select_box;?>" style="color:#FFF">Print Register</a>
                                    <a class="btn btn-sm btn-info fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-entry/1/<?php echo $drug_id_select_box;?>" style="color:#FFF">Add Entry</a>
                                </div>                        
                        <?php
							}//ed if(!empty($list_all_drug))
						?>
                </div>
                <br />
                <div class="row" id="container">
                  <div class="col-md-12">
                  	<div class="overlay hidden"></div>
                    <table class="table table-hover table-bordered" style="font-size:13px;">
                        <thead>
                        <tr>
                            <td class="text-center">Date</td>
                            <td class="text-center">User</td>
                            <td class="text-center">Supplier name and address</td>
                            <td class="text-center">Patient name and address</td>
                            <td class="text-center">Prescriber details</td>
                            <td class="text-center">Was proof of id requested?</td>
                            <td class="text-center">Was id confirmed?</td>
                            <td class="text-center">Name of person collecting</td>
                            <td class="text-center">Notes </td>
                            <td class="text-center">Quantity supplied or received</td>
                            <td class="text-center">Running balance</td>
                            
                        </tr>
                        </thead>
                        <tbody id="load_register_data">
                        </tbody>
                    </table>  
                    <input type="hidden" name="current_page" id="current_page" value="<?php echo $this->session->flashdata('p_no') ?>" readonly />
                  </div>
                  <?php 
				  	if(!empty($list_register_all_entery)){
				?>
                        <div class="col-md-12 text-right" style="margin-bottom: 10px" >
                            <div style="background-color:#F5F5F5; width:100%" class="pull-left"><?php echo $pagination_links_reg?></div>
                        </div>
                
                <?php
					}//end if(!empty($list_register_all_entery))
					
				  ?>

                </div>
              </div>
              <div id="return_tab" class="tab-pane fade <?php if($active_tab==2) { ?>active in <?php } ?>">
                    <br />
                    <div class="row">
                 
                    <div class="col-md-6"> 
                    <?php 
						if(!empty($list_all_drug_tab_2)){
					?>
                        <form  data-toggle="validator" role="form" action="<?php echo SURL?>registers" method="post" name="drug_cd_return_frm" id="drug_cd_return_frm" >
                       
                        <input type="hidden" id="drug_hidden_id_cd_return" name="drug_hidden_id_cd_return" value="<?php echo $get_cd_return_last_id['id'];?>" readonly="readonly">
                        <input type="hidden" id="tab_id" name="tab_id" value="2" readonly="readonly">
                        <select class="form-control input-sm" id="drug_id_cd_return" name="drug_id_cd_return">
							<?php 
								$single_cd = 0;
                                foreach($list_all_drug_tab_2 as $each){
                                    if($each['status'] == '1'){
										$single_cd = 1;
                            ?>
                                        <option value="<?php echo $each['id'];?>" <?php if($drug_id_cd_return_select_box ==$each['id']){?> selected="selected"<?php }?>><?php echo  filter_string($each['drug_name']).' '.filter_string($each['drug_form']).' '.filter_string($each['drug_strength']);?></option>
                            <?php 	
                                    }//end if($each['status'] == '1')
                                } // End for loop
                            ?>
                        </select> 
                        
                         <button type="submit" id="submit-add-new-cd-return" class="btn btn-primary hidden" formnovalidate>Just submit</button>
                        </form> 
                    <?php		
						}//end if(!empty($list_all_drug_tab_2))
					?>
                    </div>
                    <div class="col-md-6">
                    Click the button to the add a new register: 
                      <a class="btn btn-sm  btn-success pull-right fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-registers/2">Add New Register</a>
                      </div>
                    <?php 
						if(!empty($list_all_drug_tab_2) && $single_cd == 1){
					?>
                          <br /><br />
                        <div class="col-md-12 text-right">
                            
                            <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-witness/2">Add Witness</a>
                            <!--                     <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-registers/2">Add Medicine</a>
                            -->                      <a class="btn btn-sm btn-danger fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-patient/2">Add Patient</a>
                            <a class="btn btn-sm btn-primary fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/check-balance/2/<?php echo $drug_id_cd_return_select_box;?>" style="color:#FFF">Balance Check</a> 
                            
                            <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>registers/common-pdf/2/<?php echo $drug_id_cd_return_select_box;?>" style="color:#FFF">Print Register</a>           
                            <a class="btn btn-sm btn-info fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-cd-return/2/<?php echo $drug_id_cd_return_select_box;?>" style="color:#FFF">Add Entry</a>                        
                        </div>                  
                    
                    <?php
							
						}//end if(!empty($list_all_drug_tab_2))
					?>
                      
                </div>
                   <br />
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">User</th>
                                <th class="text-center">Patient name and address</th>
                                <th class="text-center">Name of person returning</th>
                                <th class="text-center">Role of returning patient</th>
                                <th class="text-center">Name of person collecting</th>
                                <th class="text-center">Reason</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Running balance</th>
                                <th class="text-center">Witness</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            
                            
                            
                           <?php 
						   if(!empty($list_cd_return)) { 
						   		  foreach($list_cd_return as $each) :
								 
						   ?> 
                                <tr>
                                <td class="text-center"><?php echo kod_date_format($each['created_date']);?></td>
                                <td class="text-center"><?php echo filter_string($each['fname']).' '.filter_string($each['lname']);?></td>
                               
                                <td class="text-center"><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                                <td class="text-center"><?php echo filter_string($each['person_return_name']);?></td>
                                 <td class="text-center"><?php echo filter_string($each['patient_return_name']);?></td>
                                <td class="text-center"><?php echo filter_string($each['person_collecting']);?> </td>
                                 <td class="text-center">
                                <?php if($each['reason'] !=""){?><a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/view-check-balance-cd-reason/<?php echo $each['id'];?>">View</a><?php }?>
                                
                                </td>
                                 <td class="text-center"><?php if($each['stock_return_destruction'] =='cd_return') { echo filter_string($each['quantity']);} else if($each['stock_return_destruction'] =='cd_destruction') { echo '-'.filter_string($each['quantity']);}?></td>
                                 <td class="text-center"><?php echo filter_string($each['stock_in_hand']);?></td>
 								<td class="text-center"><?php echo filter_string($each['wfname']).' <br/>'.filter_string($each['wlname']).' <br/>'.filter_string($each['witness_address']);?></td>                           
                               
                                 </tr>
                               <?php 
									endforeach;
								 } else {   ?>
                                 
                                  <tr>
                                    <td colspan="8">No record found</td>
                                  </tr>
									 
							<?php 	 
								}// end else
							?>

                            </tbody>
                        </table>  
                      </div>
                  <?php 
				  	if(!empty($list_cd_return)){
				?>
                        <div class="col-md-12 text-right" style="margin-bottom: 10px" >
                            <div style="background-color:#F5F5F5; width:100%" class="pull-left"><?php echo $pagination_links_cd?></div>
                        </div>
                
                <?php
					}//end if(!empty($list_register_all_entery))
					
				  ?>
                      
                    </div>
              </div>
              <div id="pom_tab" class="tab-pane fade <?php if($active_tab==3) { ?>active in <?php } ?>">
                    <br />
                    <div class="row text-right">
                        <div class="col-md-12">
                        <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-registers/3">Add Medicine</a>
                        <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-prescriber/3">Add Prescriber</a>
                        <a class="btn btn-sm btn-danger fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-patient/3">Add Patient</a>
                        <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>registers/common-pdf/3" style="color:#FFF">Print Register</a>
                        <a class="btn btn-sm btn-info fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-pom-private-entry/3">Add Entry</a>
                        </div>
                    </div>                    
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Date supplied</th>
                                <th class="text-center">Patient name and address</th>
                                <th class="text-center">Prescriber details</th>
                                <th class="text-center">Medicine name</th>
                                <th class="text-center">Strength</th>
                                <th class="text-center">Form</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Cost to patient(&pound;) </th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($list_all_pom_private_entry)) { 
									foreach($list_all_pom_private_entry as $each) :
							?>
                                <tr>
                                    <td class="text-center"><?php echo kod_date_format(filter_string($each['created_date']));?></td>
                                    <td class="text-center"><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                                <td class="text-center"><?php echo filter_string($each['presc_first_name']).' '.filter_string($each['presc_last_name']).' <br/>'.filter_string($each['presc_address']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_name']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_strength']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_form']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['quantity']);?></td>
                                    <td class="text-center">&pound;<?php echo filter_string($each['patient_cost']);?> </td>
                                </tr>
                                
							<?php 
									endforeach;
								 } else {   ?>
                                 
                                  <tr>
                                    <td colspan="8">No record found</td>
                                  </tr>
									 
							<?php 	 
								}// end else
							?>
                            </tbody>
                        </table>  
                      </div>
                  <?php 
				  	if(!empty($list_all_pom_private_entry)){
				?>
                        <div class="col-md-12 text-right" style="margin-bottom: 10px" >
                            <div style="background-color:#F5F5F5; width:100%" class="pull-left"><?php echo $pagination_links_pom?></div>
                        </div>
                
                <?php
					}//end if(!empty($list_register_all_entery))
					
				  ?>
                      
                    </div>
              </div>
              <div id="specials_tab" class="tab-pane fade <?php if($active_tab==4) { ?>active in <?php } ?>">
                    <br />
                    <div class="row text-right">
                        <div class="col-md-12">
                          <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-registers/4">Add Medicine</a>
                          <a class="btn btn-sm btn-danger fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-patient/4">Add Patient</a>
                          <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>registers/common-pdf/4" style="color:#FFF">Print Register</a>
                          <a class="btn btn-sm btn-info fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-special/4">Add Entry</a>
                           
                        </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Date made</th>
                                <th class="text-center">Patient name and address</th>
                               <!-- <th class="text-center">Prescriber details</th>-->
                                <th class="text-center">Medicine name</th>
                                <th class="text-center">Strength</th>
                                <th class="text-center">Form</th>
                                <th class="text-center">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($list_all_special)) { 
									foreach($list_all_special as $each) :
							    ?>
                                <tr>
                                    <td class="text-center"><?php echo kod_date_format(filter_string($each['created_date']));?></td>
                                    <td class="text-center"><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_name']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_strength']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_form']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['quantity']);?></td>
                                </tr>
                                
							<?php 
									endforeach;
								 } else {   ?>
                                 
                                  <tr>
                                    <td colspan="6">No record found</td>
                                  </tr>
									 
							<?php 	 
								}// end else
							?>
                              

                            </tbody>
                        </table>  
						  <?php 
                            if(!empty($list_all_special)){
                        ?>
                                <div class="col-md-12 text-right" style="margin-bottom: 10px" >
                                    <div style="background-color:#F5F5F5; width:100%" class="pull-left"><?php echo $pagination_links_sp?></div>
                                </div>
                        
                        <?php
                            }//end if(!empty($list_register_all_entery))
                            
                          ?>
                      </div>
                    </div>
                    
              </div>
              <div id="emergency_tab" class="tab-pane fade  <?php if($active_tab==5) { ?>active in <?php } ?>">
                    <br />
                    <div class="row text-right">
                        <div class="col-md-12">
                        
                         <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-registers/5">Add Medicine</a>
                          <a class="btn btn-sm btn-danger fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-patient/5">Add Patient</a>
                          <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>registers/common-pdf/5" style="color:#FFF">Print Register</a>
                          <a class="btn btn-sm btn-info fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/add-edit-emergency-supply/5">Add Entry</a>
                            
                        </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">Date made</th>
                                <th class="text-center">Patient name and address</th>
                                <th class="text-center">Reason for supply</th>
                                <th class="text-center">Medicine name</th>
                                <th class="text-center">Strength</th>
                                <th class="text-center">Form</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Cost to patient(&pound;)</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                              <?php if(!empty($list_all_emergency_supply)) { 
									foreach($list_all_emergency_supply as $each) :
							    ?>
                                
                                <tr>
                                    <td class="text-center"><?php echo kod_date_format(filter_string($each['created_date']));?></td>
                                    <td class="text-center"><?php echo filter_string($each['patient_first_name']).' '.filter_string($each['patient_last_name']).' <br/>'.filter_string($each['patient_address']);?></td>
                                    <td class="text-center">  <a class="btn btn-sm btn-warning fancybox_view fancybox.ajax" href="<?php echo base_url(); ?>registers/view-supply-reason/<?php echo $each['id'];?>">View</a></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_name']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_strength']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['drug_form']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['quantity']);?></td>
                                    <td class="text-center"><?php echo filter_string($each['cost_patient']);?></td>
                                    
                                </tr>
                                
                                
                                <?php 
									endforeach;
								 } else {   ?>
                                 
                                  <tr>
                                    <td colspan="7">No record found</td>
                                  </tr>
									 
							<?php 	 
								}// end else
							?>
                            </tbody>
                        </table>  
						  <?php 
                            if(!empty($list_all_emergency_supply)){
                        ?>
                                <div class="col-md-12 text-right" style="margin-bottom: 10px" >
                                    <div style="background-color:#F5F5F5; width:100%" class="pull-left"><?php echo $pagination_links_em?></div>
                                </div>
                        
                        <?php
                            }//end if(!empty($list_register_all_entery))
                            
                          ?>
                        
                      </div>
                    </div>
                    
              </div>
              <div id="archives_tab" class="tab-pane fade <?php if($active_tab==6) { ?>active in <?php } ?>">
                    <br />
                    <div class="row">
                    	<form name="archive_reg_frm" id="archive_reg_frm" method="post" action="<?php echo SURL?>registers/update-archive-status">
                        
                          <div class="col-md-6">
                                <label>Controlled Drug</label>
                                <ul style="list-style-type:none">
								<?php 
	                                foreach($list_all_drug as $each){
                                ?>
                                		<li><label style="font-weight:normal"><input type="checkbox" <?php echo (!$each['status']) ? 'checked="checked"' : '' ?>  value="<?php echo $each['id'];?>" name="contr_drug_chk[]" /> <?php echo  filter_string($each['drug_name']).' '.filter_string($each['drug_form']).' '.filter_string($each['drug_strength']);?></label></li>
                                <?php 	
									} // End for loop
                                ?>
                                </ul>
    						</div>
                            <div class="col-md-6">
                                <label>CD Returns/ Destruction</label>
                                <ul style="list-style-type:none">
									<?php 
                                        foreach($list_all_drug_tab_2 as $each){
                                    ?>
	                                        <li><label style="font-weight:normal"><input type="checkbox" <?php echo (!$each['status']) ? 'checked="checked"' : '' ?> value="<?php echo $each['id'];?>" name="contr_drug_chk[]" /> <?php echo  filter_string($each['drug_name']).' '.filter_string($each['drug_form']).' '.filter_string($each['drug_strength']);?></label></li>
                                    <?php 	
                                        } // End for loop
                                    ?>
                                </ul>
                          </div>
                          <div class="col-md-12 text-right">
                          	<input type="submit" class="btn btn-success" name="archive_reg_btn" id="archive_reg_btn" value="Update" />
                          </div>
                      </form>
                    </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
  
  $(document).ready(function(){
	  
	   $('#drug_id').change(function(){
	
	 	var drug_id = $('#drug_id').val();
	
		$('#drug_hidden_id').val(drug_id);
		$('#submit-add-new').click();
		
	});
	
	 $('#drug_id_cd_return').change(function(){
	
	 	var drug_id_cd_return = $('#drug_id_cd_return').val();
	
		$('#drug_hidden_id_cd_return').val(drug_id_cd_return);
		$('#submit-add-new-cd-return').click();
		
	});
	
	
	
	
	  
  });
 
  function add_edit_option_fancybox(value) {
	 
	  
	if( $(this).val() == 'add-edit' ){
		 $(this).fancybox({
            'autoScale': true,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'speedOut': 300,
            'autoDimensions': true,
            'centerOnScroll': true
        });
	}
}
  </script>