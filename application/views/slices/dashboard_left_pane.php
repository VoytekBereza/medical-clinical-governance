<style>
	.kod-menu-bg {
		background-color: #f5f5f5;
		font-weight: bold;
	}

	.badge {
		background-color: #337ab7;
	}

	
</style>

<script>

function setCookie(e, name,value,days){

	var delete_cookie = function(name) {
	    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	};

  	if(days){
    	
    	var date = new Date();
    	date.setTime(date.getTime() + ( days * 24 * 60 * 60 * 1000 ));
    	var expires = "; expires="+date.toGMTString();

  	} // if(days)

  	else var expires = "";
  	document.cookie = name+"="+value+expires+"; path=/";

  	// alert( document.cookie );

  	// triger <a> tag href
  	window.location = $(e).attr("href");

} // function setCookie(e, name,value,days)

</script>

<?php
	if($belong_to_any_organization){
		
		if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner){
?>
        <!-- Organization Dashboard -->
        <div class="list-group">

			<a class="list-group-item top_nav_btn" href="<?php echo SURL?>organization/dashboard" ><i class="fa fa-navicon"></i> <strong>Organisation Dashboard</strong></a>

			<!-- Organization Menu item [Read Governance] is only for Manager and Staff but not for SI and Owner -->
			<?php 
				if($allowed_user_menu['show_manage_medicine']){
			?>
					<a onClick="javascript:setCookie(this, 'menu_item_number', 'Manage Online Doctor', 1); return false;" href="<?php echo SURL?>organization/medicine-management" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Manage Online Doctor") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-medkit"></i> Manage Online Doctor </a>
                    
			<?php 
				}//end if($allowed_user_menu['show_manage_medicine'])			
				
				if($allowed_user_menu['governance_passed'] == 0 && !($MY_role_in_pharmacy['is_manager'] || $user_org_superintendent || $this->session->is_owner) ){ 
			?>
            
           		<a onClick="javascript:setCookie(this, 'menu_item_number', 'Read Governance', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Read Governance') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>organization/dashboard"> <i class="fa fa-eye text-danger"></i> Read Governance </a>
                
           	<?php } // if($allowed_user_menu['governance_passed'] == 0 && !($user_org_superintendent || $this->session->is_owner) ) ?>


		<?php

			if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner){


				if($allowed_user_menu['show_manage_governance']){
		?>
        			<a onClick="javascript:setCookie(this, 'menu_item_number', 'Manage Governance', 1); return false;" href="<?php echo SURL?>organization/edit-governance" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Manage Governance") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-pencil"></i> Manage Governance </a>
        <?php 
				}//end if($allowed_user_menu['show_manage_governance'])

			} else {

        
			}//end if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner)
		    
			
			if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner){
?>
				<a onClick="javascript:setCookie(this, 'menu_item_number', 'Organisation Global Settings', 1); return false;" href="<?php echo SURL?>organization/settings" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Organisation Global Settings") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-gears"></i> Organisation Global Settings</a>
<?php				
			}//end if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner)
 ?>               
			
        </div>
<?php
		}//end if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner)
?>
		<!-- Location Dashboard -->
        <div class="list-group">
			<a class="list-group-item top_nav_btn" href="<?php echo SURL?>organization/pharmacy-record" ><i class="fa fa-navicon"></i> <strong>Location Dashboard</strong></a>

            <a onClick="javascript:setCookie(this, 'menu_item_number', 'Team Builder', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Team Builder') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>organization/dashboard"> 
            <?php 
                if($allowed_user_menu['governance_passed'] || $this->session->is_owner) { echo '<i class="fa fa-plus"></i> Team Builder'; }else{ echo '<i class="fa fa-eye"></i> Read Governance';} ?> 
            </a>

        <!-- Organization Menu item [Team Builder] is for Manager, Staff, SI and Owner -->
        <?php 
			if($user_org_superintendent || $this->session->is_owner || $MY_role_in_pharmacy['is_manager']){ 
		?>
        
        <?php 
			}else{

			}// if($user_org_superintendent || $this->session->is_owner || $MY_role_in_pharmacy['is_manager'] == 1) 

    		//Authenticate PGD's
			if($allowed_user_menu['show_authenticate_pgd']){
		?>
				<a onClick="javascript:setCookie(this, 'menu_item_number', 'Authenticate PGDs', 1); return false;" href="<?php echo SURL?>organization/list-all-unauthenticate" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Authenticate PGDs") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-lock"></i> Authenticate PGDs</a>
		<?php
			}//end if($allowed_user_menu['show_authenticate_pgd'])
			
			//PMR			
			if($allowed_user_menu['show_pmr']){
		?>
                <a onClick="javascript:setCookie(this, 'menu_item_number', 'iPMR', 1); return false;" href="<?php echo SURL?>organization/pmr" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "iPMR") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-user"></i>

                	iPMR 
                	
                	<?php if($this->session->pmr_organization_id){
                		$total = count_ipmr_pending_transactions();
                	} // if($this->session->pmr_organization_id) 

                	if($total){
?>
                		<span class="badge"><?php echo $total; ?></span>

					<?php } // if($total) ?>
               	</a>
		<?php 
			}// if($this->session->show_pmr && $this->session->show_pmr == 1)
			
			if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner){

				if($allowed_user_menu['show_nhs_data']){
		?>

                	<!--<a onClick="javascript:setCookie(this, 'menu_item_number', 'Pharmacy Record', 1); return false;" href="<?php echo SURL?>organization/pharmacy-record" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Pharmacy Record") ? 'kod-menu-bg' : '' ; ?>"><i class="glyphicon glyphicon-stats"></i> NHS Data</a>-->
        
        <?php			
				}//end if($allowed_user_menu['show_nhs_data'])
						
				if($allowed_user_menu['show_view_governance'] && !$this->session->is_owner){
?>
		                <a onClick="javascript:setCookie(this, 'menu_item_number', 'My Governance', 1); return false;" href="<?php echo SURL?>organization/my-governance" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "My Governance") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-pencil"></i> My Governance </a>
<?php
				}// end 
				
			}else{

				//Sections available for Managers Only
				if($allowed_user_menu['show_nhs_data']){
		?>
                	<!--<a onClick="javascript:setCookie(this, 'menu_item_number', 'Pharmacy Record', 1); return false;" href="<?php echo SURL?>organization/pharmacy-record" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Pharmacy Record") ? 'kod-menu-bg' : '' ; ?>"><i class="glyphicon glyphicon-stats"></i> NHS Data</a>-->

        <?php					
				}
				
				//Sections available for Managers Only
				if($allowed_user_menu['show_manage_medicine']){
        ?>
                    <a onClick="javascript:setCookie(this, 'menu_item_number', 'Manage Online Doctor', 1); return false;" href="<?php echo SURL?>organization/medicine-management" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Manage Online Doctor") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-medkit"></i> Manage Online Doctor</a>
<?php
				}//end if($am_i_manager)
				
			}//end if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner)


             if(($allowed_user_menu['show_view_governance'] && !$this->session->is_owner) && !$user_org_superintendent){
?>
				<a onClick="javascript:setCookie(this, 'menu_item_number', 'My Governance', 1); return false;" href="<?php echo SURL?>organization/my-governance" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "My Governance") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-pencil"></i> My Governance </a>
		    <?php

			}//end if($allowed_user_menu['show_view_governance'] && !$this->session->is_owner)
			
			if($allowed_user_menu['show_clinical_governance'] && $this->session->pharmacy_surgery_id){

				$uri_string_arr = array('organization/manage-surveys','clinical-log','complaints','practice-leaflet');
				
				$display_clinic_gov_menu = 'none';	
				if (in_array(uri_string(),$uri_string_arr))
					$display_clinic_gov_menu = '';
				
			?>
                <a class="list-group-item" href="javascript:;" id="clinic_gov_menu"><i class="fa fa-navicon"></i> Clinical Governance <span class="caret"></span></a>
                <div style="display:<?php echo $display_clinic_gov_menu?>" id="clinic_gov_menu_cont">
                    
                    <?php 
                        if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner){
    
                            if($allowed_user_menu['show_manage_surveys']){
                    ?>
                                <a style="background-color: #F7F7F7" onClick="javascript:setCookie(this, 'menu_item_number', 'Manage Surveys', 1); return false;" href="<?php echo SURL?>organization/manage-surveys" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Manage Surveys") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-bookmark"></i>
            
                                    Manage Surveys
            
                                    <?php if($this->session->organization_id){
                                        $survey_badge = count_surveys();
                                    } // if($this->session->organization_id) 
            
                                    if($survey_badge){
                ?>
                                        <span class="badge"><?php echo $survey_badge; ?></span>
            
                                    <?php } // if($survey_badge) ?>
            
                                </a>
                    <?php 
                            }//end if($allowed_user_menu['show_manage_surveys'])
                            
                        }else{
    
                            //Sections available for Managers Only
                            if($allowed_user_menu['show_manage_surveys']){
                    ?>
                                <a style="background-color: #F7F7F7" onClick="javascript:setCookie(this, 'menu_item_number', 'Manage Surveys', 1); return false;" href="<?php echo SURL?>organization/manage-surveys" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Manage Surveys") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-bookmark"></i> Manage Surveys</a>
                    <?php
                            }//end if($allowed_user_menu['show_manage_surveys'])
                            
                        }//end if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner)

                    ?>            
    
                    <a style="background-color: #F7F7F7" onClick="javascript:setCookie(this, 'menu_item_number', 'Clinical Log', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Clinical Log') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>clinical-log"><i class="glyphicon glyphicon-cloud-upload"></i> Clinical Log</a>
    
                    <a style="background-color: #F7F7F7" onClick="javascript:setCookie(this, 'menu_item_number', 'Complaints', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Complaints') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>complaints"><i class="glyphicon glyphicon-warning-sign"></i> Complaints</a>
    
                    <a style="background-color: #F7F7F7" onClick="javascript:setCookie(this, 'menu_item_number', 'Practice Leaflet', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Practice Leaflet') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>practice-leaflet"><i class="glyphicon glyphicon-leaf"></i> Practice Leaflet</a>
                    
                </div>
            
            <?php	
			}//end if($allowed_user_menu['show_clinical_governance'] || $this->session->is_owner)
			
			if($allowed_user_menu['show_prescription'] && $this->session->pharmacy_surgery_id){
			
				$display_presc_menu = 'none';	
				if (uri_string() == 'eps' || uri_string() == 'repeat-prescription')
					$display_presc_menu = '';

			?>
                <a class="list-group-item" href="javascript:;" id="presc_menu"><i class="fa fa-navicon"></i> Prescriptions<span class="caret"></span></a>
                <div style="display:<?php echo $display_presc_menu?>" id="presc_menu_cont">
    
                     <a style="background-color: #F7F7F7" onClick="javascript:setCookie(this, 'menu_item_number', 'EPS Form', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'EPS Form') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>eps"><i class="glyphicon glyphicon-cloud-upload"></i> EPS Form</a>
                     
                     <a style="background-color: #F7F7F7" onClick="javascript:setCookie(this, 'menu_item_number', 'Repeat Prescription Form', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Repeat Prescription Form') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>repeat-prescription"><i class="glyphicon glyphicon-cloud-upload"></i> Repeat Prescription Form</a>
                    
                </div>
            
            <?php				
			}//end if($allowed_user_menu['show_prescription'] || $this->session->is_owner)

            if(!$this->session->is_owner){
?>
		    	<a onClick="javascript:setCookie(this, 'menu_item_number', 'View Contract', 1); return false;" href="<?php echo SURL?>organization/view-contract" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "View Contract") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-eye"></i> View Contract </a>
<?php
			}//end if(!$this->session->is_owner)
			
			?>
			<!--Travel Clinic Management
            <a onClick="javascript:setCookie(this, 'menu_item_number', 'Travel Clinic Management', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Travel Clinic Management') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>organization/travel-clinic"><i class="glyphicon glyphicon-book"></i> Travel Clinic Management</a>        
             -->
            <?php

			if($allowed_user_menu['show_register'] && $this->session->pharmacy_surgery_id){
			?>
                <a onClick="javascript:setCookie(this, 'menu_item_number', 'Registers', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Registers') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>registers"><i class="glyphicon glyphicon-th-list"></i> Registers</a>
            
            <?php				
			}//end if($allowed_user_menu['show_register'] || $this->session->is_owner)
			
			if(($allowed_user_menu['show_contact_book'] || $this->session->is_owner) && $this->session->pharmacy_surgery_id){
		?>
                <a onClick="javascript:setCookie(this, 'menu_item_number', 'Contact Book', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Contact Book') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>contact-book"><i class="glyphicon glyphicon-book"></i> Contact Book</a>
        
        <?php		
			}//end if($allowed_user_menu['show_contact_book'] || $this->session->is_owner)

			if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner){
				
				if($allowed_user_menu['show_website']){
				
				
		?>
                	<a href="https://pharmafocus.co.uk/" target="_blank" class="list-group-item"><i class="fa fa-share"></i> Website</a>
        
        <?php
				}//end if($allowed_user_menu['show_website'])
				
			}else{
				
				if($allowed_user_menu['show_website']){
	?>
    				<a href="https://pharmafocus.co.uk/" target="_blank" class="list-group-item"><i class="fa fa-share"></i> Website</a>
    <?php			
				}//end if($allowed_user_menu['show_website'])
				
			}//end if(($show_teambuilder && $user_org_superintendent) || $this->session->is_owner)

			if(($allowed_user_menu['show_travel_insurance'] || $this->session->is_owner) && $this->session->pharmacy_surgery_id){

			?>
            
            	 <a onClick="javascript:setCookie(this, 'menu_item_number', 'Diagnostics', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'Diagnostics') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>diagnostics"><i class="glyphicon glyphicon-warning-sign"></i> Diagnostics</a>
             
             <?php 
			}//end if($allowed_user_menu['show_travel_insurance'] || $this->session->is_owner)
			
		?>
        
</div>

<?php		
	} //end if($belong_to_any_organization)
?>

<!-- User Dashboard -->

<div class="list-group">
    <a class="list-group-item top_nav_btn" href="<?php echo SURL?>dashboard"><i class="fa fa-navicon"></i> <strong><?php echo $this->session->user_role?> Dashboard</strong></a>
    
    <!--<a onClick="javascript:setCookie(this, 'menu_item_number', 'My Dashboard', 1); return false;" href="<?php echo SURL?>dashboard" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "My Dashboard") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-desktop"></i> My Dashboard</a>-->

        <a onClick="javascript:setCookie(this, 'menu_item_number', 'How to videos', 1); return false;" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == 'How to videos') ? 'kod-menu-bg' : '' ; ?>" href="<?php echo SURL?>how-to-videos"><i class="fa fa-play"></i> How to Videos</a>
	
    <a onClick="javascript:setCookie(this, 'menu_item_number', 'Training Log', 1); return false;" href="<?php echo SURL?>training-log" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Training Log") ? 'kod-menu-bg' : '' ; ?>"><i class="glyphicon glyphicon-check"></i> Training Log</a>
    
    <a onClick="javascript:setCookie(this, 'menu_item_number', 'Quick Forms', 1); return false;" href="<?php echo SURL?>quick-forms" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Quick Forms") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-flag"></i> Quick Links </a>

    <a onClick="javascript:setCookie(this, 'menu_item_number', 'NHS Comissioning', 1); return false;" href="<?php echo SURL?>nhs-comissioning" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "NHS Comissioning") ? 'kod-menu-bg' : '' ; ?>"><i class="glyphicon glyphicon-gbp"></i> NHS Comissioning</a>

    <a onClick="javascript:setCookie(this, 'menu_item_number', 'Settings', 1); return false;" href="<?php echo SURL?>dashboard/settings" class="list-group-item <?php echo ($_COOKIE['menu_item_number'] && $_COOKIE['menu_item_number'] == "Settings") ? 'kod-menu-bg' : '' ; ?>"><i class="fa fa-cog"></i> Settings</a>
    
    
	<?php 
	$allowed_slug_area = array('dashboard','pharmacy-surgery');
	$current_uri = explode('/',uri_string());

	if(in_array($current_uri[1],$allowed_slug_area)){
	
		// Verify session to show suggesstion buttons
		if($this->session->show_button_suggesstions && $this->session->show_button_suggesstions = 1){
	?>
            
            <br /> <br />
            <div class="alert alert-info">
                    
                <strong class="text-info">Note! Below buttons are describing the actions of each color.</strong>
                <br /><br />
                <button class="btn btn-xxs btn-danger"> <strong> Not Purchased, Not Passed </strong> </button>
                <br /><br />
                <button class="btn btn-xxs btn-success"> <strong> Purchased and Passed </strong> </button>
                <br /><br />
                <button class="btn btn-xxs btn-warning"> <strong> Purchased but not Passed </strong> </button>
                <br /><br />
                <button class="btn btn-xxs"> <strong > Not Eligible </strong> </button>
    
            </div>
<?php 
		} // end if($this->session->show_button_suggesstions && $this->session->show_button_suggesstions = 1)
		
	}//end if(in_array($current_uri[1],$allowed_slug_area))
?>
</div>