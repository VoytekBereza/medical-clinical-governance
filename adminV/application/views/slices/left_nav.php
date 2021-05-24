<?php //echo '<pre>'; print_r(get_pgd_navigation_list('1')); exit; ?>

<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;"> <a href="<?php echo SURL?>dashboard" class="site_title"><i class="fa fa-paw"></i> <span>Hubnet</span></a> </div>
    <div class="clearfix"></div>
    
    <!-- menu prile quick info -->
    <div class="profile">
      <div class="profile_pic"> <img src="<?php echo IMAGES?>img.jpg" alt="..." class="img-circle profile_img"> </div>
      <div class="profile_info"> <span>Welcome,</span>
        <h2><?php echo $this->session->userdata('admin_full_name')?></h2>
      </div>
    </div>
    <!-- /menu prile quick info --> 
    
    <br />
      
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <?php  if($this->session->userdata('login_user_type')!='prescriber' && $this->session->userdata('login_user_type')!='avicenna'){ ?>
      <div class="menu_section">
		
        <ul class="nav side-menu">
        	<li>
				<a href="<?php echo SURL?>dashboard"><i class="fa fa-home"></i> Dashboard</a>
			</li>
          <li><a><i class="fa fa-bar-chart-o"></i> Hubnet Pages<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>page/list-all-page">Edit Pages</a> </li>
              <li><a href="<?php echo SURL?>page/add-new-page">Add Pages</a> </li>
              <li><a href="<?php echo SURL?>userorders/list-all-user-orders">Payment order history</a> </li>
            </ul>
          </li>
          
            <li><a><i class="fa fa-bar-chart-o"></i> Voyager Health <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>page/list-all-page-voyager-health">Edit Pages</a> </li>
              <li><a href="<?php echo SURL?>page/add-new-page-voyager-health">Add pages</a> </li>
               <li><a href="<?php echo SURL?>vhfaq/list-all-vh-faq">Edit FAQ</a> </li>
              <li><a href="<?php echo SURL?>vhfaq/add-update-vh-faq">Add FAQ</a> </li>
            </ul>
          </li>
          
            <li><a><i class="fa fa-shopping-cart"></i> Delivery Options <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>delivery/list-all-delivery">Edit delivery method</a> </li>
              <li><a href="<?php echo SURL?>delivery/add-update-delivery">Add delivery method</a> </li>
            </ul>
          </li>
          
          <li>
          	<a><i class="fa fa-user"></i>User management<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>users/list-all-users">Edit Users</a> </li>
              <li><a href="<?php echo SURL?>users/import_users">Import Users</a> </li>
              <li><a href="<?php echo SURL?>organization/list-all-organizations">Organizations</a> </li>
              <li><a href="<?php echo SURL?>users/default-team-section-list">Assign CQC Settings</a> </li> 
              <li><a href="<?php echo SURL?>users/default-prescriber-section-list">Assign Default Prescriber</a> </li> 
              <li><a href="<?php echo base_url('users/user-reporting'); ?>">User Reporting</a></li>    
              <li><a href="<?php echo base_url('users/old-users-list'); ?>">Old User List</a></li>           
              <li><a href="<?php echo SURL; ?>users/buying-groups">Buying Groups</a></li>
            </ul>
          </li>
       
             <li>
          	<a><i class="fa fa-user"></i>PMR Section<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>patient/list-all-patients">Edit Patients</a> </li>
              <li><a href="<?php echo SURL?>patient/list-all-patients-orders">Edit Patients Orders</a> </li>
            </ul>
          </li>
         
          <li><a><i class="fa fa-edit"></i> Templates <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>emailtemplates/list-all-templates">Edit templates</a> </li>
              <li><a href="<?php echo SURL?>emailtemplates/add-new-template">Add template</a> </li>
            </ul>
          </li>
          
			<li><a href="<?php echo SURL?>settings/media"><i class="fa fa-photo"></i> Media</a></li>          
            <li><a href="<?php echo SURL?>how-to-videos"><i class="fa fa-play"></i> How to Videos</a></li>
          <li><a><i class="fa fa-desktop"></i>Governance<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
               <li><a href="<?php echo SURL?>governance/edit-governance/1">Settings</a> </li>
               <li><a href="<?php echo SURL?>governance/list-all-hr-governance">HR Contracts</a> </li>
               <!--<li><a href="< ?php echo SURL?>governance/list-all-sop-category">Edit SOP categories</a> </li>-->
               <li><a href="<?php echo SURL?>governance/list-all-sop">Edit SOP</a> </li>
              
            </ul>
          </li>          
          
           <li><a><i class="fa fa-edit"></i> Quick Links <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>quickforms/list-all-quick-forms-category">Edit categories</a> </li>
              <li><a href="<?php echo SURL?>quickforms/list-all-quick-forms-documents">Edit forms</a> </li>
            </ul>
          </li>

           <li><a><i class="fa fa-edit"></i> NHS commissioning<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>nhs-comissioning/list-all-nhs-comissioning-category">Edit categories</a> </li>
              <li><a href="<?php echo SURL?>nhs-comissioning/list-all-nhs-comissioning-documents">Edit forms</a> </li>
            </ul>
          </li>
          
           <li><a> <i class="fa fa-medkit"></i> Medicines database<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>medicine/list-all-medicine-category">Edit category</a> </li>
              <li><a href="<?php echo SURL?>medicine/add-update-medicine-category">Add category</a> </li>
              <li><a href="<?php echo SURL?>medicine/list-all-medicine"> Edit medicine</a> </li>
              <li><a href="<?php echo SURL?>medicine/add-update-medicine">Add medicine</a> </li>
            </ul>
          </li>
          
           <li><a> <i class="fa fa-medkit"></i> Pharmacy<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
               <li><a href="<?php echo SURL?>organization/list-all-ajax-pharmacy">Pharmacy List</a> </li>
               <li><a href="<?php echo SURL?>organization/list-all-pharmacies">Embed Code</a> </li>
            </ul>
          </li>
          
            <li><a> <i class="fa fa-question-circle"></i>FAQs<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo SURL?>contactfaq/list-all-contact-faq">Edit FAQ</a> </li>
              <li><a href="<?php echo SURL?>contactfaq/add-update-contact-faq">Add FAQ</a> </li>
             </ul>
          </li>
            <li>
                <a href="<?php echo SURL?>settings/online-doctor-prescribers"><strong><i class="fa fa-plus"></i>Online Doctor Prescriber</strong></a>
            </li>          
          <li><a><i class="fa fa-cog"></i>Settings<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
           
              <li><a href="<?php //echo SURL?>#">Payment details</a> </li>
              <li><a href="<?php echo SURL?>settings/list-all-settings">Global settings</a> </li>
              <li><a href="<?php echo SURL?>settings/edit-profile">Edit profile</a> </li>
			  <li><a href="<?php echo SURL?>settings/user-type-dashboar-videos"> <strong>Dashboard videos</strong></a></li>
              <li><a href="<?php echo SURL?>settings/change-password">Change admin password</a> </li>
              <li><a href="<?php echo SURL?>settings/list-all-notifications">Notifications</a> </li>
           </ul>
          </li>
          <div class="alert alert-success"><h3>Vaccines Section</h3></div>
            <li><a> <i class="fa fa-medkit"></i>Travel Vaccines<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
             <li><a href="<?php echo SURL?>vaccine/add-update-vaccine/2">Edit Page</a> </li>
             <li><a href="<?php echo SURL?>vaccine/list-all-vaccine-raf/2">RAF</a> </li>
             <li><a href="<?php echo SURL?>vaccine/list-all-travel-vaccine">Edit Vaccines</a> </li>
             <li><a href="<?php echo SURL?>vaccine/list-all-vaccine-destination">Edit Destinations </a></li>
             </ul>
          </li>
          
            <li><a> <i class="fa fa-medkit"></i>Flu Vaccines<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
             <li><a href="<?php echo SURL?>vaccine/add-update-vaccine/1">Edit Page</a> </li>
             <li><a href="<?php echo SURL?>vaccine/list-all-vaccine-raf/1">RAF</a> </li>
             </ul>
          </li>
         
        </ul>
      </div>
      
		<div class="menu_section">
			<div class="alert alert-success"><h3>PGD's Section</h3></div>
			<ul class="nav side-menu">
                <!--<li><a href="<?php echo SURL?>pgd/list-all-unauthenticated"> Unauthenticated PGDs</a> </li>-->
                <li>
                	<a><i class="fa fa-stethoscope"></i> Authenticate PGDs<span class="fa fa-chevron-down"></span></a>
                	<ul class="nav child_menu" style="display: none">
                    	<li><a href="<?php echo SURL?>pgd/list-all-unauthenticated"> Unauthenticated PGDs</a></li>
                        <li><a href="<?php echo SURL?>pgd/list-all-unauthenticated2"> Unauthenticated PGDs2 (Non Org)</a></li>
                        <li><a href="<?php echo SURL?>pgd/authentication-log"> Authentication Log</a></li>
                        
                    </ul>
                </li>
				<li>
					<a href="<?php echo SURL?>pgd/add-new-pgd"><strong><i class="fa fa-plus"></i>Add New PGD</strong></a>
				</li>
				<!--<li><a href="<?php echo SURL?>pgd/list-all-document-categories"><i class="fa fa-plus"></i>PGD Document Categories</a></li>-->
				<?php
				
					//print_r(get_pgd_navigation_list('1'));
					
					if(count(get_pgd_navigation_list('')) > 0){
						
						foreach(get_pgd_navigation_list('') as $pgd_name =>$pgd){
				?>
							<li><a><i class="fa fa-stethoscope"></i> <?php echo filter_string($pgd_name); ?><span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu" style="display: none">
									<?php 
										if(count($pgd['pgd_subpgd']) > 0){
											
											for($c=0;$c<count($pgd['pgd_subpgd']);$c++){
									?>
												<li><a href="<?php echo SURL?>pgd/add-new-subpgd/<?php echo filter_string($pgd['pgd_id'])?>/<?php echo filter_string($pgd['pgd_subpgd'][$c]['subpgd_id'])?>"><?php echo filter_string($pgd['pgd_subpgd'][$c]['subpgd_name'])?></a></li>
									<?php			
											}//end for($c=0;$c<count($pgd['pgd_subpgd']);$c++)
											
										}//end if(count($pgd['pgd_subpgd']) > 0)
									?>
									<li><a href="<?php echo SURL?>pgd/add-new-subpgd/<?php echo filter_string($pgd['pgd_id'])?>"><h3><strong>Add New Sub PGD</strong></h3></a></li>
									<li><a href="<?php echo SURL?>pgd/add-new-pgd/<?php echo filter_string($pgd['pgd_id'])?>?p=1">CMS Page</a></li>
									<li><a href="<?php echo SURL?>pgd/add-new-pgd/<?php echo filter_string($pgd['pgd_id'])?>?c=1">Certificate</a></li>
									<li><a href="<?php echo SURL?>pgd/documents-listing/<?php echo $pgd['pgd_id']; ?>">Documents</a></li>
									<li><a href="<?php echo SURL?>pgd/rafs-listing/<?php echo $pgd['pgd_id']; ?>">RAF Documents</a></li>
									<li><a href="<?php echo SURL?>pgd/videos-listing/<?php echo $pgd['pgd_id']; ?>">Videos</a></li>
									<li><a href="<?php echo SURL?>pgd/rechas/<?php echo $pgd['pgd_id']; ?>">Prerequisit</a></li>
									<li><a href="<?php echo SURL?>pgd/quizes/<?php echo $pgd['pgd_id']; ?>">Exams</a></li>
									
								</ul>
							</li>
				<?php			
						}//end foreach
						
					}//end if(count(get_pgd_navigation_list('1')) > 0)
					
				?>
			</ul>
		</div>
		
		<!-- Start Trainings Section -->
		<div class="menu_section">
            <div class="alert alert-success"><h3>Training Section</h3></div>
            <ul class="nav side-menu">
				<li>
					<a><i class="fa fa-user"></i>Training<span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="display: none">
						<!--<li><a href="<?php echo SURL?>trainings/list-all-document-categories"> <strong>Training Document Categories</strong></a></li>-->
                        <li><a href="<?php echo SURL?>trainings/list-all-trainings"> <strong>Edit Training</strong></a></li>
						<li><a href="<?php echo SURL?>trainings/add-new-training"> <strong>Add New Training</strong></a></li>
					</ul>
				</li>
            </ul>
        </div>
		<!-- End Trainings section -->
	  <?php }//end if($this->session->userdata('login_user_type')!='prescriber')?>
    
    <!-- Start Trainings Section -->
    <?php  if($this->session->userdata('login_user_type') == 'avicenna' ){ ?>

      <br/> <br/> <br/><br/> 
      
      <div class="menu_section">
        <ul class="nav side-menu">
          <li><a href="<?php echo base_url('avicenna/users'); ?>"><i class="fa fa-users"></i> Users </a></li>
          <li><a href="<?php echo base_url('avicenna/pharmacy-list'); ?>"><i class="fa fa-globe"></i> Pharmacies List</a></li>
          
            <li>
          	<a><i class="fa fa-user"></i>User Reporting<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" <?php if($this->uri->segment(1)=='avicenna' && $this->uri->segment(2)=='list-avicenna-pgd'  && $this->uri->segment(3)=='PGD'){?>style="display: block"<?php } else {?>style="display: none"<?php }?>>
              <li  <?php if($this->uri->segment(1)=='avicenna' && $this->uri->segment(2)=='list-avicenna-pgd'  && $this->uri->segment(3)=='PGD'){?>class="current-page"<?php } else {?>class=""<?php }?>><a href="<?php echo SURL?>avicenna/list-avicenna-pgd/PGD">List Users PGDs</a> </li>
              <li><a href="<?php echo SURL?>avicenna/all-user-reporting">All User PGD Report </a> </li>
              <li><a href="<?php echo SURL?>avicenna/list-avicenna-training/all">List Users Training</a> </li>
             <!-- <li><a href="<?php echo SURL?>avicenna/user-reporting">User Reporting</a> </li>-->
           </ul>
          </li>
        </ul>
      </div>

      <!-- End Trainings section -->
     <?php }//end if($this->session->userdata('login_user_type')!='prescriber')?>
     
      <?php  if($this->session->userdata('login_user_type') == 'prescriber' ){ ?>

      <br/> <br/> <br/><br/> 
     
      
      <div class="menu_section">
        <ul class="nav side-menu">
         
            <li><a href="<?php echo base_url('patient/list-all-patient-transactions'); ?>"><i class="fa fa-list"></i> Pending Transactions</a></li>
            
            <li><a href="<?php echo base_url('patient/list-all-prescription-statistics'); ?>"><i class="fa fa-file"></i> Prescription Audit </a></li>
            <li><a href="<?php echo base_url('patient/list-all-pharmacy-statistics'); ?>"><i class="fa fa-pencil-square-o"></i> Pharmacy Audit </a></li>
            <li><a href="<?php echo base_url('patient/list-all-patients-audit'); ?>"><i class="fa fa-users"></i> User Audit </a></li>
            <li><a href="https://www.bnf.org/" target="_blank"><i class="fa fa-globe"></i> BNF.org </a></li>
            <li><a href="https://www.medicines.org.uk/emc/" target="_blank"><i class="fa fa-globe"></i> eMC</a></li>
            <li><a href="https://cks.nice.org.uk/" target="_blank"><i class="fa fa-globe"></i> NICE CKS</a></li>
      
        </ul>
      </div>

      <!-- End Trainings section -->
     <?php }//end if($this->session->userdata('login_user_type')!='prescriber')?>
    </div>
    <!-- /sidebar menu --> 
   
  </div>
</div>