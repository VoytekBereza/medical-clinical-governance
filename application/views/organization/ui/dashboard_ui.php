<a name="basket_ref" id="basket_ref"></a>

<?php
	if($this->session->flashdata('paypal_success')){
?>
	<div class="alert alert-success alert-dismissable"><h3><?php echo $this->session->flashdata('paypal_success'); ?></h3></div>
<?php 
		}//if($this->session->flashdata('ok_message'))
?>


<div class="alert alert-danger" role="alert">
  <h4>Notification</h4>
  <div class="row">
    <div class="col-md-8">
      <p>Dummy Notificatins</p>
    </div>
    <div class="col-md-4"> <a href=""><span class="label label-success">Approve</span></a> <a href="../dashboard - Copy/blog-post.html"><span class="label label-danger">Reject</span></a> </div>
  </div>
</div>

<!-- Elect Selft 1 success (first elections) -->
<div class="row">
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="col-sm-5 col-md-5 col-lg-5 pul-left">
			<label class="text-success">Elect Superintendent.</label>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 pull-left">
			<button class="btn btn-xs btn-success btn-block" type="button">Elect Self</button>
		</div>
	</div>
</div>

<br />
<hr />
<br />

<!-- Elect Selft 2 danger (Re-Elections) -->
<div class="row">
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="col-sm-5 col-md-5 col-lg-5 pul-left">
			<label class="text-warning">Elect Superintendent.</label>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 pull-left">
			<button class="btn btn-xs btn-warning btn-block" type="button">Elect Self</button>
		</div>
	</div>
</div>

<br />
<hr />
<br />

<!-- if Superintendent is null -> Show Invite Superintendent input field -->
<div class="row col-sm-12 col-md-12 col-lg-12">

	<div class="col-sm-2 col-md-2 col-lg-2"></div> <!-- Empty Space on left -->
	<div class="col-sm-8 col-md-8 col-lg-8">
		
		<!-- Invite Superintendent input field -->
		<label>Send invitation to Superintendent</label>
		<div class="input-group">
			<input class="form-control" required="required" type="email" placeholder="Enter email address" id="invite_superintendent_email_field" name="email" />
			<span class="input-group-btn" id="basic-addon3"><button class="btn btn-md btn-success" type="button">Invite Superintendent</button></span>
		</div>
		
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div> <!-- Empty Space on right -->
</div>

<!-- if invitation is sent to the superintendent -> Show cancel Invitation -->
<div class="row col-sm-12 col-md-12 col-lg-12">

	<br />
	<hr />
	<br />
	
	<div class="col-sm-1 col-md-1 col-lg-1"></div> <!-- Empty Space on left -->
	
	<div class="col-sm-11 col-md-11 col-lg-11">
		<!-- Invitation pending data -->
		<div class="col-sm-8 col-md-8 col-lg-8 pul-left">
			<label class="text-danger">Invitation has been sent to johny@gmail.com waiting acceptence.</label>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 pull-left">
			<button class="btn btn-sm btn-danger btn-block" type="button">Cancel Invitation</button>
		</div>
	</div>
	
	<div class="col-sm-1 col-md-1 col-lg-1"></div> <!-- Empty Space on right -->
	
</div>

<!-- Start - Add new pharmacy and surgery form view -->
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">

		<br />
		<hr />
		<br />
	
		<div class="row">
			<div class="col-sm-8 col-md-8 col-lg-8">
				<div class="col-sm-5 col-md-5 col-lg-5 pul-left">
					<label class="text-warning">Superintendent : Wojtek bereza</label>
				</div>
				
				<div class="col-sm-2 col-md-2 col-lg-2 pull-left">
					<button class="btn btn-xs btn-success btn-block" type="button">Change</button>
				</div>
				
				<div class="col-sm-2 col-md-2 col-lg-2 pull-left">
					<button class="btn btn-xs btn-warning btn-block" type="button">Elect Self</button>
				</div>
				
			</div>
		</div>
		<hr />
	</div>
</div>

<br />
<!-- Add Pharmacy/Sergery -->
<div class="row">	
	<div class="col-sm-6 col-md-6 col-lg-6">
		<h4>Add new Pharmacy or Surgey</h4>
	</div>
	<div class="col-sm-6 col-md-6 col-lg-6">
		<button class="btn btn-sm btn-success pull-right" type="button" id="add_pharmacy_surgery_btn" onClick="toggle_add_pharmacy_surgery_btn();" >Add Pharmacy / Surgery</button>
	</div>			
</div>

<br />

<div class="row" id="add_pharmacy_surgery_form" style="display:none;">	
	<div class="col-sm-6 col-md-6 col-lg-6">
		
		<div class="form-group">
			<select class="form-control">
				<option>Select Pharmacy / Surgery</option>
			</select>
		</div>
		
		<div class="form-group">
			<label>Pharmacy name</label>
			<input type="text" class="form-control" />
		</div>
		
		<div class="form-group">
			<label>Pharmacy address</label>
			<input type="text" class="form-control" />
		</div>
		
		<div class="form-group">
			<select class="form-control">
				<option>Select Country</option>
			</select>
		</div>
		
		<div class="form-group">
			<label>Post Code</label>
			<input type="text" class="form-control" />
		</div>
		
		<div class="form-group">
			<label>Contact Number</label>
			<input type="text" class="form-control" />
		</div>
		
		<div class="form-group">
			<label>Email Address</label>
			<input type="text" class="form-control" />
		</div>

		<div class="form-group col-md-4 pull-right">
			<button type="submit" class="btn btn-sm btn-success btn-block"> Add</button>
		</div>
	
	</div>
	
</div>

<br />
<hr />
<br />
<!-- End - Add new pharmacy and surgery form view -->

<!-- Start - List Pharmacies -->
<div class="row">	
	<div class="col-sm-7 col-md-7 col-lg-7"></div>
	<div class="col-sm-5 col-md-5 col-lg-5">
	
		<div class="input-group">
			<input class="form-control" required="required" type="email" placeholder="Enter pharmacy postcode" />
			<span class="input-group-btn" id="basic-addon3"><button class="btn btn-md btn-success" >Search</button></span>
		</div>
		
	</div>			
</div>
<br />

<h4>List Pharmacies</h4>
<!-- Start - Pharmacies having manager -->
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<label class="text-primary">Carters pharmacy, N111EH</label>
		</div>
		
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-success">Edit</button>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-danger">Delete</button>
			</div>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12" >
			<strong>Pharmacy Manager (Technician) : </strong> Billy - <span class="glyphicon glyphicon-phone"></span> 07817273611 - <span class="glyphicon glyphicon-envelope"></span> plonker@gmail.com
			
			<br />
			<br />
			
			<button class="btn btn-xs btn-default expand-btn" > + Expand </button>
		</div>
		
	</div>
</div>
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<label class="text-primary">Carters pharmacy, N111EH</label>
		</div>
		
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-success">Edit</button>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-danger">Delete</button>
			</div>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12" >
			<strong>Pharmacy Manager (Technician) : </strong> Billy - <span class="glyphicon glyphicon-phone"></span> 07817273611 - <span class="glyphicon glyphicon-envelope"></span> plonker@gmail.com
			
			<br />
			<br />
			
			<button class="btn btn-xs btn-default expand-btn" > + Expand </button>
		</div>
		
	</div>
</div>
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<label class="text-primary">Carters pharmacy, N111EH</label>
		</div>
		
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-success">Edit</button>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-danger">Delete</button>
			</div>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12" >
			<strong>Pharmacy Manager (Technician) : </strong> Billy - <span class="glyphicon glyphicon-phone"></span> 07817273611 - <span class="glyphicon glyphicon-envelope"></span> plonker@gmail.com
			
			<br />
			<br />
			
			<button class="btn btn-xs btn-default expand-btn" > + Expand </button>
		</div>
		
	</div>
</div>
<!-- End - Pharmacies having manager -->

<br />
<hr />
<br />

<div class="row">	
	<div class="col-sm-7 col-md-7 col-lg-7"></div>
	<div class="col-sm-5 col-md-5 col-lg-5">
	
		<div class="input-group">
			<input class="form-control" required="required" type="email" placeholder="Enter pharmacy postcode" />
			<span class="input-group-btn" id="basic-addon3"><button class="btn btn-md btn-success" >Search</button></span>
		</div>
		
	</div>			
</div>
<br />

<h4>List Pharmacies</h4>
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<label class="text-primary">Carters pharmacy, N111EH</label>
		</div>
		
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-success">Edit</button>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-danger">Delete</button>
			</div>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12" >
			<strong>Pharmacy Manager (Technician) : </strong> Billy - <span class="glyphicon glyphicon-phone"></span> 07817273611 - <span class="glyphicon glyphicon-envelope"></span> plonker@gmail.com
			
			<br />
			<br />
			
			<button class="btn btn-xs btn-default expand-btn" onClick="expand_me(1);" > + Expand </button>
			
		</div>
		
	</div>
</div>
<div class="panel panel-default panel-body"> <!-- Start - Pharmacies having no manager -->
	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<label class="text-primary">Carters pharmacy, N111EH</label>
		</div>
		
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-success">Edit</button>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-danger">Delete</button>
			</div>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8" >
			
			<div class="input-group">
				<input class="form-control input-sm" required="required" type="email" placeholder="Email Address" />
				<span class="input-group-btn" id="basic-addon3"><button class="btn btn-sm btn-success" >invite manager</button></span>
				<span class="input-group-addon">OR</span>
				<span class="input-group-btn" id="basic-addon3"><button class="btn btn-sm btn-warning" >Elect Self</button></span>
			</div>
			
		</div>
		
	</div>
</div>
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<label class="text-primary">Carters pharmacy, N111EH</label>
		</div>
		
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-success">Edit</button>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<button class="btn btn-xs btn-block btn-danger">Delete</button>
			</div>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12" >
			
			<strong>Pharmacy Manager (Technician) : </strong> Billy - <span class="glyphicon glyphicon-phone"></span> 07817273611 - <span class="glyphicon glyphicon-envelope"></span> plonker@gmail.com &nbsp; &nbsp; &nbsp; <a href="#"> Edit </a> &nbsp; <a href="#"> Replace </a>
			<br /><br />
			
			<button class="btn btn-xs btn-danger">Governance</button>
			<br /><br />
			
			<button class="btn btn-xs btn-default expand-btn" onClick="expand_me(1);" > + Expand </button>
			<br /><br />
			
			<span id="expand_pharmacy_1" style="display: none;" >
				
				<label onClick="toggle_staff(1);" ><h4 class="text-primary"><span class="glyphicon glyphicon-triangle-bottom"></span>Staff</h4></label>
				
				<br />
				
				<div id="view_staff_1" style="display:none;">
				
					<label>Pharmacist : </label> Marty - <span class="glyphicon glyphicon-phone"></span> 07817273611 - <span class="glyphicon glyphicon-envelope"></span> plonker@gmail.com &nbsp; &nbsp; &nbsp; <a href="#"> Edit </a> &nbsp; <a href="#"> Delete </a>
					
					<br />
					
					<button class="btn btn-xs btn-danger">Governance</button>
					<button class="btn btn-xs btn-success">Seasonal</button>
					<button class="btn btn-xs btn-success">Anaphylex</button>
					<button class="btn btn-xs btn-danger">Travel <span class="glyphicon glyphicon-shopping-cart"></span></button>
					<button class="btn btn-xs btn-danger">Oral <span class="glyphicon glyphicon-shopping-cart"></span></button>
					
					<br /><br />
					<label class="text-danger">Pending invitation for Nurse </label> &nbsp; &nbsp; <button class="btn btn-xs btn-danger">Delete</button> <button class="btn btn-xs btn-warning">Resend Invite</button>
				
				</div>
				
				<br /><br />
				<button class="btn btn-xs btn-primary pull-left add-staff-btn" onClick="toggle_add_staff(1);" >Add Staff &nbsp;</button>
				<br /><br />
				
			</span>
		</div>
		
	</div>
	
	<div class="row panel panel-default panel-body" id="add_staff_1" style="display: none;" >
					
		<div class="col-sm-2 col-md-2 col-lg-2"></div> <!-- Left empty space -->
		<div class="col-sm-8 col-md-8 col-lg-8">
			
			<div class="input-group">
				<span class="input-group-addon">
					<select>
						<option value="">Users</option>
						<option value="">Pharmacist</option>
						<option value="">Nurse</option>
						<option value="">Technician</option>
						<option value="">Pre-Reg</option>
					</select>
				</span>
				<input class="form-control input-md" required="required" type="email" placeholder="Email Address" />
				<span class="input-group-btn" id="basic-addon3"><button class="btn btn-md btn-default" >Invite</button></span>
			</div>
			
		</div>
		<div class="col-sm-2 col-md-2 col-lg-2"></div> <!-- Right empty space -->
		
		<br /><br />
		
	</div>
	
</div>
<!-- End - Pharmacies having no manager -->
<hr />
<!-- Start - SOPs -->

<div class="row">
	<div class="col-sm-1 col-md-1 col-lg-1" ></div> <!-- Left empty space -->
	<div class="col-sm-10 col-md-10 col-lg-10" >
		
		<div class="row col-sm-12 col-md-12 col-lg-12">
		
			<a href="javascript:;" onClick="toggle_sop(1);" ><h4 class=""><span class="glyphicon glyphicon-folder-close"></span> &nbsp; ER SOP</h4></a>
			
			<div id="view_er_sop_1" style="display:none;">
			
				<!-- Start - list -->
				<div class="col-sm-1 col-md-1 col-lg-1" ></div> <!-- Left empty space -->
				<div class="col-sm-10 col-md-10 col-lg-10" >
					
					<a href="javascript:;"><span class="glyphicon glyphicon-file"></span> Download sop will have the user signature</a> <a href="#" class="pull-right"> Edit</a>
					<br />
					<a href="javascript:;"><span class="glyphicon glyphicon-file"></span> Download sop will have the user signature</a> <a href="#" class="pull-right"> Edit</a>
					<br />
					<a href="javascript:;"><span class="glyphicon glyphicon-file"></span> Download sop will have the user signature</a> <a href="#" class="pull-right"> Edit</a>
					<br />
					<a href="javascript:;"><span class="glyphicon glyphicon-file"></span> Download sop will have the user signature</a> <a href="#" class="pull-right"> Edit</a>
					
					
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1" ></div> <!-- Right empty space -->
				<!-- End - list -->
			
			</div>
			
		</div>
		
		<div class="row col-sm-12 col-md-12 col-lg-12">
			<a href="javascript:;" ><h4><span class="glyphicon glyphicon-folder-close"></span> &nbsp; ER SOP </h4></a>
		</div>
		
		<div class="row col-sm-12 col-md-12 col-lg-12">
			<a href="javascript:;" ><h4><span class="glyphicon glyphicon-folder-close"></span> &nbsp; ER SOP </h4></a>
		</div>
		<div class="row col-sm-12 col-md-12 col-lg-12">
			<a href="javascript:;" ><h4><span class="glyphicon glyphicon-folder-close"></span> &nbsp; ER SOP </h4></a>
		</div>
		<div class="row col-sm-12 col-md-12 col-lg-12">
			<a href="javascript:;" ><h4><span class="glyphicon glyphicon-folder-close"></span> &nbsp; ER SOP  </h4></a>
		</div>
		
	</div>
	
</div>

<br /><br /><br /><br />

<div class="row col-sm-12 col-md-12 col-lg-12 text-primary">
	I declare that I have read all the above Sops. <input type="checkbox" value="1" class="checkbox-inline" />
</div>
<br /><br />
<div class="row col-sm-2 col-md-2 col-lg-2 pull-left">
	<button class="btn btn-sm btn-success btn-block" type="button">Sign it</button>
</div>

<br /><br /><br />
<hr />
<br /><br />
<!-- End - SOPs -->

<!-- Start - Governance tabs -->
<h4>Governance</h4>
<hr />

<!-- Stat - Governance tabs -->
<ul class="nav nav-tabs">

	<li><a data-toggle="tab" href="#governance">Governance</a></li>
	<li><a data-toggle="tab" href="#hr">HR</a></li>
	<li class="active"><a data-toggle="tab" href="#sops">SOPs</a></li>
	<li><a data-toggle="tab" href="#finish">Finish</a></li>

</ul>

<!-- Start - Governance tabs body -->
<div class="tab-content">
    
	<br />
	
    <div id="governance" class="tab-pane fade">
		<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    
	<div id="hr" class="tab-pane fade">
		<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
	
	<div id="sops" class="tab-pane fade in active text-primary">
		
		<p><span class="glyphicon glyphicon-folder-close"></span> &nbsp;Travel SOPs &nbsp; <button class="btn btn-xs btn-danger read-and-sign-btn" type="button">Read and Sign</button></p>
		
		<p>&nbsp; &nbsp; &nbsp; Influenza SOP &nbsp; <button class="btn btn-xs btn-success" disabled type="button">Download</button></p>
		<p>&nbsp; &nbsp; &nbsp; Anaphlaxis SOP &nbsp; <button class="btn btn-xs btn-success" disabled type="button">Download</button></p>
		
		<p><span class="glyphicon glyphicon-folder-close"></span> &nbsp;Seasonal SOPs &nbsp; <button class="btn btn-xs btn-info read-and-sign-btn" type="button">Read and Signed</button></p>
		
		<p>&nbsp; &nbsp; &nbsp; Influenza SOP &nbsp; <button class="btn btn-xs btn-success" type="button">Download</button></p>
		<p>&nbsp; &nbsp; &nbsp; Anaphlaxis SOP &nbsp; <button class="btn btn-xs btn-success" type="button">Download</button></p>
		
    </div>
	
    <div id="finish" class="tab-pane fade">
		<p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
	
</div>
<br />

<!-- Temp Div to show the contents of (Read and Sign section) -->
<div class="row" id="read_and_sign_div" style="display:none; max-height:150px; overflow: scroll;"></div>

<!-- End - Governance tabs body -->

<br />
<hr />
<br />

<!-- Start - Global Settings -->
<h4>Global Settings</h4>
<hr />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>Governance</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>OFF</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>Online Doctor</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>OFF</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>Survey</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>ON</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>PMR</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>ON</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>To Do List</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>OFF</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>IPOS</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>OFF</label>
	</div>
	
</div>

<!-- End - Global Settings -->

<br />
<hr />
<br />

<!-- Start - Pharmacy Settings -->
<h4>Pharmacy Settings</h4>
<hr />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>Online PGDs (Free)</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>OFF</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>Online Doctor (Free)</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>OFF</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" checked>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>PMR (Free)</label>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label>ON</label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" disabled>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label><button class="btn btn-sm btn-warning">Governance <span class="glyphicon glyphicon-shopping-cart"></span></button></label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" disabled>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label><button class="btn btn-sm btn-warning">Survey Builder <span class="glyphicon glyphicon-shopping-cart"></span></button></label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" disabled>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label><button class="btn btn-sm btn-warning">IPOS <span class="glyphicon glyphicon-shopping-cart"></span></button></label>
	</div>
	
</div>
<br />

<div class="row">
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<input type="checkbox" class="kod-switch" disabled>
	</div>
	
	<div class="col-sm-2 col-md-2 col-lg-2">
		<label><button class="btn btn-sm btn-warning">To Do <span class="glyphicon glyphicon-shopping-cart"></span></button></label>
	</div>
	
</div>

<!-- End - Pharmacy Settings -->