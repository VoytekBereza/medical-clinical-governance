<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <?php echo chrome_frame(); ?>
    <?php echo view_port(); ?>	
    <meta name="author" content="">

    <title><?php echo $title?></title>
	
    <?php
	    echo $meta;
		echo $header_script;
		echo $css;
	?>
     <link rel="shortcut icon" href="<?php echo IMG?>favicon.ico" />

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

	<?php echo $header_top?>
    <!-- Page Content -->

    <!-- Page Content -->
    <div class="container"> 
      <br>
      <!-- Page Heading/Breadcrumbs -->
      <div class="row">
        <div class="col-lg-12">
            <?php if($breadcrum_data != NULL) { echo  $breadcrum_data; }?>
        </div>
      </div>
      <!-- /.row --> 
      
      <!-- Content Row -->
      <div class="row"> 
        <!-- Sidebar Column -->
        <div class="col-md-3">
			<?php echo $dashboard_left_pane?>
        </div>
        
        <!-- Content Column -->
        <div class="col-md-9">

		<?php
            if($this->session->flashdata('err_message')){
        ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php
            }//end if($this->session->flashdata('err_message'))
            
            if($this->session->flashdata('ok_message')){
        ?>
                <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php 
            }//if($this->session->flashdata('ok_message'))
        
            if($this->session->flashdata('paypal_success')){
        ?>
                <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('paypal_success'); ?></div>
        <?php 
            }//if($this->session->flashdata('paypal_success'))

        if($belong_to_any_organization){
			
			if($this->session->flashdata('org_first_message')){
				//This messgae will appear just once for the organization for the first time he logs in.
        ?>
        	
				<p class="alert alert-sm alert-success"><strong><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('org_first_message'); ?></strong></p>
        <?php 
			}//end if($this->session->flashdata('org_first_message'))
		?>
            <div class="alert alert-success topcurrentwork_overflowdiv" style="border: 0px; background-color:#F5F5F5; color:#555; ">
            	<ul class="topcurrentwork list-unstyled">
                    <li style="margin-top:7px"><strong>Current workplace:</strong></li>
                    <li style="margin-top:7px">Organisation</li>
                    <li>
                    	<select class="form-control input-sm" id="org_organization_list_slt" onChange="javascript:org_organization_list_slt(this);" style="width:250px">
                             	<option value=""> Select Organisation </option>
    							<?php
                                
                                    if(count($get_my_organizations) > 0){
                                        
                                        foreach($get_my_organizations as $organization){
                                ?>
                                            <option <?php echo (count($get_my_organizations) == 1) ? 'selected="selected"' : '' ; ?> <?php echo ($this->session->organization_id && $this->session->organization_id == $organization['organization_id']) ? 'selected="selected"' : '' ; ?> value="<?php echo $organization['organization_id']; ?>"> <?php echo $organization['organization_name'].' - '.$organization['postcode']; ?> </option>
                                <?php
                                        } // foreach($get_my_pharmacies_surgeries as $organization)
                                
                                    } // if($get_my_pharmacies_surgeries)
                                ?>
    						</select>
                    </li>
                    
                    <li style="margin-top:7px">Location</li>
                    <li><span id="org-pharmacies-surgeries-div"> <select class="form-control input-sm" onChange="javascript:select_si_pharmacy_surgery(this);" id="org_pharmacy_list_slt" style="width:250px"> <option value=""> Select Pharmacy / Clinic</option> </select>  </span></li>
                </ul>

                    <!-- ORG Pharmacies / Surgeries will be loaded here from jQuery onChange Organization from the dropdown -->
                    <img src="<?php echo base_url(); ?>assets/images/fancybox_loading.gif" id="loader" class="hidden" />
                    <input type="hidden" id="pharmacy_surgery_id_hidden" value="<?php echo ($this->session->pharmacy_surgery_id)? $this->session->pharmacy_surgery_id : '' ; ?>" />
    
                    <script>
                    
                    // Function to select Organization on dashboard_template : Load list pharmacy/surgery
                    function org_organization_list_slt(el){
                    
                        var organization_id = $(el).val();
                    
                        if(organization_id){
                    
                            $.ajax({
                            
                                type: "POST",
                                url: SURL + "organization/get-org-pharmacies-surgeries/",
                                data: { 'organization_id' : organization_id },
                    
                                beforeSend : function(result){
                                    $('#org_pharmacy_list_slt').html('<option value=""> Select Pharmacy / Clinic</option>');
                                    $("#loader").removeClass("hidden");
                                },
                    
                                success: function(result){
                                    
                                    $("#loader").addClass("hidden");
                    
                                    if(result){
                    
                                        var htm = '';
                    
                                        $('#org_pharmacy_list_slt').removeClass("hidden");
                                            
                                        var obj = JSON.parse(result);
                                        var obj_length = Object.keys(obj).length;
                    
                                        if(obj){
                    
                                            // Verify if the Pharmacy / Surgery is already selected : Make that pharmacy / surgery selected
                                            var verify_selected = '';
                                            var old_pharmacy_surgery_id = 0;
                                            if( $('#pharmacy_surgery_id_hidden').val() != undefined ){
                                                verify_selected = 1;
                                                old_pharmacy_surgery_id = $('#pharmacy_surgery_id_hidden').val();
                                            } // if( $('#pharmacy_surgery_id_hidden').val() != undefined )
                    
                                            // htm = '<select class="form-control input-sm" onChange="javascript:select_si_pharmacy_surgery(this);" id="org_pharmacy_list_slt">';
                                            
                                            var trigger_pharmacy = 0;

                                            $.each(obj, function(key, value){
                    
                                                if(((verify_selected && verify_selected == 1) && value.pharmacy_surgery_id == old_pharmacy_surgery_id )){
                                                    htm += '<option selected="selected" value="'+ value.pharmacy_surgery_id +'">'+ value.pharmacy_surgery_name + ' - ' +value.postcode +'</option>';

                                                } else {
                                                    htm += '<option value="'+ value.pharmacy_surgery_id +'">'+ value.pharmacy_surgery_name + ' - ' +value.postcode +'</option>';
                                                } // if(verify_selected && verify_selected == 1)
                                                
                                            }); // $.each(obj, function(key, value)
                    
                                            //htm += '</select>';
                                            $('#org_pharmacy_list_slt').append(htm);

                                           // $('#org_pharmacy_list_slt').trigger("change");
                                            //return;
                                            
                                            /*if( obj.length == 1 ){
                                                $('#org_pharmacy_list_slt').trigger("change");
                                                return false;
                                            } // if( obj.length == 1 )
                                            */

                                        } else {
                    
                                        } // if(obj)

                                    } // if(result)

                                } // success
                    
                            }); // $.ajax
                    
                        } // if(organization_id)
                    
                    } // function org_organization_list_slt()
                    $('#org_organization_list_slt').trigger('change');
                    
                    // Select Pharmacy Or Surgery FOR OWNER OR SI
                    function select_si_pharmacy_surgery(element) {
                    
                        // Set pharmacy / surgery ID assigned to the input hidden field
                        $('#pharmacy_surgery_id_hidden').val(element.value);
                    
                        if(element.value == ''){
                            window.location = SURL+"organization/select-si-pharmacy-surgery/";
                            return;
                        } else
                            window.location = SURL+"organization/select-si-pharmacy-surgery/"+element.value;
                        // if(element.value == '')
                        
                    }// End - select_si_pharmacy_surgery(element)
                    
                    </script>

					<!-- End - Organization select dropdown -->
            
            </div>        
			
            <?php } // belong to any org ?>

            <!-- Start -  Notification / Invitations -->
            <?php if(count($user_invitations_arr) > 0){?>
                <div class="alert alert-warning" role="alert">
                    <h4>Notification</h4>
                    <?php for($i=0;$i<count($user_invitations_arr);$i++){?>
                    <div class="row">
                        
                        <div class="col-md-10"><p><?php echo filter_string($user_invitations_arr[$i]['invitation_txt'])?></p></div>
                        
                        <div class="col-md-2">
                            <!-- <a href="< ?php echo SURL?>dashboard/invitation-approval/< ?php echo filter_string($user_invitations_arr[$i]['id'])?>/1"> -->
                                <button type="button" class="btn btn-xs btn-block btn-default invitation-response-btn" rel="<?php echo filter_string($user_invitations_arr[$i]['id']).'|1'; ?>" > View Contract </button>
                            <!-- </a> -->
                        </div>
                        
                        <!-- <div class="col-md-2"> -->
                            <!-- <a href="< ?php echo SURL?>dashboard/invitation-approval/< ?php echo filter_string($user_invitations_arr[$i]['id'])?>/0"> -->
                                <!-- <button type="button" class="btn btn-xs btn-block btn-danger invitation-response-btn" rel="< ?php echo filter_string($user_invitations_arr[$i]['id']).'|0'; ?>" >Reject</button> -->
                            <!-- </a> -->
                        <!-- </div> -->

                    </div>
                    <?php }//end for($i=0;$i<count($user_invitations_arr);$i++)?>
                </div>

                <!-- View Contract fancybox HTML contents -->
                <!-- Fancybox popup to view contract and [ Accept and Reject ] the invitaion on popup -->
                <a id="invite_response_fancy_trigger" href="#fancy-content-div-invitation-response" style="display:none" class=" btn btn-xxs btn-danger invitation_response_governance_hr_fancybox"> Open Governance HR </a>
                <div style="display: none" class="row col-md-12">
                    <div id="fancy-content-div-invitation-response">
                        
                        <!--
                        <h4 class="modal-title" id="view-contract-popup-title" >View Contract</h4>
                        <hr />
                        -->
                        <div class="row col-md-12">
                        	<span id="contract" style="width: 800px; height: 400px"> </span>
                            <span id="no_contract_notes" > </span>
                        </div>

                        <div class="row col-md-12">
                            <hr />
                            <span id="btn-span"></span>
                        </div>
                        <div class="row col-md-12">
                            <div id="request_change_container" style="display:none">
                                <hr>
                                <form action="<?php echo SURL?>dashboard/send-contract-changes-process" name="contract_request_for_change_frm" id="contract_request_for_change_frm" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12" style="padding:0">
                                        <p>Please specify any notes you like to notify to your Manager or Superintendent.</p>
                                        <div class="form-group">
                                            <label for="request_change_notes">Notes:</label>
                                            <textarea style="width:100%" rows="5" id="request_change_notes" name="request_change_notes" placeholder="Enter your notes here"></textarea>
                                        </div>
                                          <div class="form-group pull-right">
                                            <button type="submit" name="contract_change_sbt" id="contract_change_sbt"  class="btn btn-success btn-sm ">Submit</button>
                                            <input type="hidden" name="contract_invitation_id" id="contract_invitation_id" value="" readonly>
                                          </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php }//end if(count($user_invitations_arr) > 0)?>
            <!-- End -  Notification / Invitations -->

            <!-- Start -  New Contract Notification -->
            <?php if(count($user_new_contract_list) > 0){?>
                <div class="alert alert-info" role="alert">
                    <h4>Contract Renewal Notification</h4>
                    <?php for($i=0;$i<count($user_new_contract_list);$i++){?>
                    <div class="row">
                        
                        <div class="col-md-10"><p><?php echo filter_string($user_new_contract_list[$i]['invitation_txt'])?></p></div>
                        
                        <div class="col-md-2">
                            <!-- <a href="< ?php echo SURL?>dashboard/invitation-approval/< ?php echo filter_string($user_invitations_arr[$i]['id'])?>/1"> -->
                                <button type="button" class="btn btn-xs btn-block btn-default renew_contract_response_btn" rel="<?php echo filter_string($user_new_contract_list[$i]['id']); ?>" > View Contract </button>
                            <!-- </a> -->
                        </div>

                    </div>
                    <?php }//end for($i=0;$i<count($user_invitations_arr);$i++)?>
                </div>

                <!-- View Contract fancybox HTML contents -->
                <!-- Fancybox popup to view new contract and [ Accept and Reject ] the invitaion on popup -->
                <a id="renew_contract_response_fancy_trigger" href="#fancy-content-div-renew-contract-response" style="display:none" class=" btn btn-xxs btn-danger renew_contract_response_fancybox"> Open Contract for Renewal </a>
                
                <div style="display: none" class="row col-md-12">
                    <div id="fancy-content-div-renew-contract-response">
                        
                        <div class="row col-md-12">
                        	<span id="renew_contract" style="width: 800px; height: 400px"> </span>
                            <span id="renew_contract_no_contract_notes"> </span>
                        </div>

                        <div class="row col-md-12">
                            <hr />
                            <span id="renew_contract_btn_span"></span>
                        </div>
                        <div class="row col-md-12">
                            <div id="renew_request_change_container" style="display:none">
                                <hr>
                                <form action="<?php echo SURL?>organization/renew-contract-changes-process" name="renew_contract_request_for_change_frm" id="renew_contract_request_for_change_frm" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12" style="padding:0">
                                        <p>Please specify any notes you like to notify to your Manager or Superintendent.</p>
                                        <div class="form-group">
                                            <label for="request_change_notes">Notes:</label>
                                            <textarea rows="5" style="width:100%" id="renew_request_change_notes" name="renew_request_change_notes" placeholder="Enter your notes here"></textarea>
                                        </div>
                                          <div class="form-group pull-right">
                                            <button type="submit" name="renew_contract_change_sbt" id="renew_contract_change_sbt"  class="btn btn-success btn-sm ">Submit</button>
                                            <input type="hidden" name="renew_temp_contract_id" id="renew_temp_contract_id" value="" readonly>
                                          </div>
                                    </div>
                                </form>
                            </div>                        	
                        </div>
                    </div>
                </div>

            <?php }//end if(count($user_new_contract_list) > 0)?>
            <!-- END -  New Contract Notification -->

            <?php echo $content; ?>
        </div>
        
      </div>
      <!-- /.row -->                 
      
    </div>    
    <!-- /.container -->
    <div style="margin-top: 30px;">
    	<?php echo $footer;?>
	</div>
      <!-- Footer -->

<?php 
	//footer_script slice
	echo $footer_script;
	echo $js;
?>

</body>

</html>