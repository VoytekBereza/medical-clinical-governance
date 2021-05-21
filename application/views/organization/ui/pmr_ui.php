<a name="basket_ref" id="basket_ref"></a>

<?php
	if($this->session->flashdata('paypal_success')){
?>
	<div class="alert alert-success alert-dismissable"><h3><?php echo $this->session->flashdata('paypal_success'); ?></h3></div>
<?php 
		}//if($this->session->flashdata('ok_message'))
?>

<!-- Start - PMR UI -->

<!-- Start - Screen 1 - PMR -->
<h2 class="text-center"> Screen 1 - PMR </h2>

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>PMR</h3>
	</div>
</div>

<hr />
<br />

<!-- Patients Search -->
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<label for="is_default_doc">Search a patient:</label>
		<input type="text" autocomplete="off" placeholder="Search a patient" required="required" class="form-control search_patient" name="search_patient" id="search_patient">
		<div id="result_patient"></div>
	</div>
</div>

<br />

<!-- Pending Transactions -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading"><strong>DEFAULT TEAM SECTION</strong></div>
			<div class="panel-body">
				
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-success"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-primary"><strong>Online weight loss RX : </strong> Johny Waker</span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<button class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#myModal">Complete</button>
					</div>
				</div>
				
				<hr />
				
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-success"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-primary"><strong>Online weight loss RX : </strong> Johny Waker</span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<button class="btn btn-sm btn-success pull-right">Start</button>
					</div>
				</div>
				
				<hr />
				
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-success"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-primary"><strong>Online weight loss RX : </strong> Johny Waker</span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<button class="btn btn-sm btn-success pull-right">Start</button>
					</div>
				</div>
				
			</div>
		</div>
		
		<!-- Modal for Merge History -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">You have multiple history</h4>
					</div>
					<div class="modal-body">
						<p> <strong> Cartus pharmacy. </strong> </p>
						<p> <strong> Douglas pharmacy. </strong> </p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" >Merge History</button>
						<button type="button" class="btn btn-success" >View History</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End - Screen 1 - PMR -->

<!-- Start - Screen 2 - PMR - Online RX -->
<hr />

<h2 class="text-center">Screen 2 - PMR - Online RX</h2>

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>PMR Online RX</h3>
	</div>
</div>

<hr />
<br />

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<strong class="text-primary">William smith</strong>
		<br /> <br />
		<p>
			114 burnley Road, N11 EH
			<br /> <br />
			<span class="glyphicon glyphicon-phone"></span> 07755586586
			<br /> <br />
			<span class="glyphicon glyphicon-envelope"></span> williamsmith@gmail.com
		</p>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
	
		<div class="panel panel-success">
			<div class="panel-heading">
				<strong>Allergies</strong>
				<br /> <br /> <br /> <br /> <br />
				<p></p>
			</div>
		</div>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<div class="panel panel-warning">
		
			<div class="panel-heading">				
				<strong>Pending</strong> <br /> <br />
				<p>Online hair loss RX <br /> Online ED RX</p>
				<br />
			</div>
			
		</div>
		
	</div>
</div>

<br />

<h4>Current Transaction</h4>

<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> 27/11/2015 </strong></div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Time </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Amoxil </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Tablets </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 10mg </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 25 </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> 3p/d </strong> </div>	
	</div>
	<hr />

	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<span class="pull-right">
				<button class="btn btn-sm btn-success"> Approve </button>
				<button class="btn btn-sm btn-danger"> Decline </button>
			</span>
		</div>
	</div>
</div>

<br /> <br /> <br />

<!-- Pending Transactions -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading"><strong>Patient History</strong></div>
			<div class="panel-body">
				
				<div class="panel panel-default"> 
					<div class="panel-heading"> 
					
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Date </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Name </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Form </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Strength </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Quantity </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Does </strong>
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									<strong> Transaction Type </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> User </strong>
								</div>
							</div>
						</div>
						
					</div>
					<div class="panel-body">
						
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									27/11/2015
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									Amoxil
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Tablets
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									10mg
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									25
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									3p/d
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									Online RX
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Marty
								</div>
							</div>
						</div>
						<hr />
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- End - Screen 2 - PMR - Online RX -->

<!-- Start - Screen 3 - PMR - Free Type -->
<hr />

<h2 class="text-center">Screen 3 - PMR - Free Type</h2>

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>PMR Free Type</h3>
	</div>
</div>

<hr />
<br />

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<strong class="text-primary">William smith</strong>
		<br /> <br />
		<p>
			114 burnley Road, N11 EH
			<br /> <br />
			<span class="glyphicon glyphicon-phone"></span> 07755586586
			<br /> <br />
			<span class="glyphicon glyphicon-envelope"></span> williamsmith@gmail.com
		</p>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
	
		<div class="panel panel-success">
			<div class="panel-heading">
				<strong>Allergies</strong>
				<br /> <br /> <br /> <br /> <br />
				<p></p>
			</div>
		</div>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<div class="panel panel-warning">
		
			<div class="panel-heading">				
				<strong>Pending</strong> <br /> <br />
				<p>Online hair loss RX <br /> Online ED RX</p>
				<br />
			</div>
			
		</div>
		
	</div>
</div>

<br />

<h4>Current Transaction</h4>

<div class="panel panel-default panel-body">	
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<input type="text" class="form-control" value="Amoxil 250mg tablets" placeholder="Type here to search Medicine" />
		</div>
	</div>

	<br />
	
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-3 col-md-3 col-lg-3">
				<strong> Amoxil 250mg tablets </strong>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<input type="text" class="form-control" value="Take 3 tablets daily before meal" />
			</div>			
			<div class="col-sm-2 col-md-2 col-lg-2">
				<input type="text" class="form-control" value="25" />
			</div>
			<div class="col-sm-1 col-md-1 col-lg-1">
				<button class="btn btn-danger pull-right"> <span class="glyphicon glyphicon-trash"></span> </button>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-3 col-md-3 col-lg-3">
				<strong> Amoxil 250mg tablets </strong>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<input type="text" class="form-control" value="Take 3 tablets daily before meal" />
			</div>			
			<div class="col-sm-2 col-md-2 col-lg-2">
				<input type="text" class="form-control" value="25" />
			</div>
			<div class="col-sm-1 col-md-1 col-lg-1">
				<button class="btn btn-danger pull-right"> <span class="glyphicon glyphicon-trash"></span> </button>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-3 col-md-3 col-lg-3">
				<strong> Amoxil 250mg tablets </strong>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<input type="text" class="form-control" value="Take 3 tablets daily before meal" />
			</div>			
			<div class="col-sm-2 col-md-2 col-lg-2">
				<input type="text" class="form-control" value="25" />
			</div>
			<div class="col-sm-1 col-md-1 col-lg-1">
				<button class="btn btn-danger pull-right"> <span class="glyphicon glyphicon-trash"></span> </button>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-3 col-md-3 col-lg-3">
				<strong> Amoxil 250mg tablets </strong>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<input type="text" class="form-control" value="Take 3 tablets daily before meal" />
			</div>			
			<div class="col-sm-2 col-md-2 col-lg-2">
				<input type="text" class="form-control" value="25" />
			</div>
			<div class="col-sm-1 col-md-1 col-lg-1">
				<button class="btn btn-danger pull-right"> <span class="glyphicon glyphicon-trash"></span> </button>
			</div>
		</div>
	</div>
	
	<br />
	<hr />
	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<button class="btn btn-success pull-right"> Preview </button>
		</div>
	</div>
</div>

<br /> <br /> <br />

<!-- Pending Transactions -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading"><strong>Patient History</strong></div>
			<div class="panel-body">
				
				<div class="panel panel-default"> 
					<div class="panel-heading"> 
					
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Date </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Name </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Form </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Strength </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Quantity </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Does </strong>
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									<strong> Transaction Type </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> User </strong>
								</div>
							</div>
						</div>
						
					</div>
					<div class="panel-body">
						
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									27/11/2015
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									Amoxil
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Tablets
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									10mg
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									25
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									3p/d
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									Online RX
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Marty
								</div>
							</div>
						</div>
						<hr />
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- End - Screen 3 - PMR - Free Type -->

<!-- Start - Screen 2 - Online PGD -->
<hr />

<h2 class="text-center">Screen 2 - Online PGD</h2>

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>Online PGD</h3>
	</div>
</div>

<hr />
<br />

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<strong class="text-primary">William smith</strong>
		<br /> <br />
		<p>
			114 burnley Road, N11 EH
			<br /> <br />
			<span class="glyphicon glyphicon-phone"></span> 07755586586
			<br /> <br />
			<span class="glyphicon glyphicon-envelope"></span> williamsmith@gmail.com
		</p>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
	
		<div class="panel panel-success">
			<div class="panel-heading">
				<strong>Allergies</strong>
				<br /> <br /> <br /> <br /> <br />
				<p></p>
			</div>
		</div>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<div class="panel panel-warning">
		
			<div class="panel-heading">				
				<strong>Pending</strong> <br /> <br />
				<p>Online hair loss RX <br /> Online ED RX</p>
				<br />
			</div>
			
		</div>
		
	</div>
</div>

<br />

<h4>Current Transaction</h4>
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> 27/11/2015 </strong></div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Time </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Amoxil </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Tablets </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 10mg </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 25 </strong> </div>
		<div class="col-sm-2 col-md-1 col-lg-1"> <strong> 3p/d </strong> </div>
		<div class="col-sm-2 col-md-1 col-lg-1"> <button class="btn btn-xs btn-danger"> <span class="glyphicon glyphicon-trash"></span> </button> </div>
	</div>
	<hr />

	<br />

	<div class="row">
		<span class="col-sm-12 col-md-12 col-lg-12">
			<button class="btn btn-sm btn-success pull-right"> Complete </button>
		</span>
	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-md-10 col-lg-10"></div>
	<div class="col-sm-2 col-md-2 col-lg-2">
		<select class="form-control">
			<option value="">RAF</option>
		</select>
	</div>
</div>
<br />

<!-- Erectile Dysfunction Risk Assessment Form -->
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-8 col-md-8 col-lg-8">
				<h4>Erectile Dysfunction Risk Assessment Form</h4>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<strong class="pull-right">(Unlocked, Prefilled fields)</strong>
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-8 col-md-8 col-lg-8">
				Do you take any medicines?
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-success"> Yes </button>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-danger"> No </button>
			</div>
		</div>
	</div>
	<br />
	
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-8 col-md-8 col-lg-8">
				Can you walk 3 miles without aid?
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-success"> Yes </button>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-danger"> No </button>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-md-10 col-lg-10"></div>
	<div class="col-sm-2 col-md-2 col-lg-2">
		<button class="btn btn-xs btn-primary btn-block pull-right"> Add </button>
	</div>
</div>

<br />
<!-- Pending Transactions -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading"><strong>Patient History</strong></div>
			<div class="panel-body">
				
				<div class="panel panel-default"> 
					<div class="panel-heading"> 
					
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Date </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Name </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Form </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Strength </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Quantity </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Does </strong>
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									<strong> Transaction Type </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> User </strong>
								</div>
							</div>
						</div>
						
					</div>
					<div class="panel-body">
						
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									27/11/2015
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									Amoxil
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Tablets
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									10mg
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									25
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									3p/d
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									Online RX
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Marty
								</div>
							</div>
						</div>
						<hr />
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- End - Screen 2 - Online PGD -->

<!-- Start - Screen 3 - Walkin PGD -->
<hr />

<h2 class="text-center">Screen 3 - Walkin PGD</h2>

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>Online PGD</h3>
	</div>
</div>

<hr />
<br />

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<strong class="text-primary">William smith</strong>
		<br /> <br />
		<p>
			114 burnley Road, N11 EH
			<br /> <br />
			<span class="glyphicon glyphicon-phone"></span> 07755586586
			<br /> <br />
			<span class="glyphicon glyphicon-envelope"></span> williamsmith@gmail.com
		</p>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
	
		<div class="panel panel-success">
			<div class="panel-heading">
				<strong>Allergies</strong>
				<br /> <br /> <br /> <br /> <br />
				<p></p>
			</div>
		</div>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<div class="panel panel-warning">
		
			<div class="panel-heading">				
				<strong>Pending</strong> <br /> <br />
				<p>Online hair loss RX <br /> Online ED RX</p>
				<br />
			</div>
			
		</div>
		
	</div>
</div>

<br />

<h4>Current Transaction</h4>
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> 27/11/2015 </strong></div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Time </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Amoxil </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Tablets </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 10mg </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 25 </strong> </div>
		<div class="col-sm-2 col-md-1 col-lg-1"> <strong> 3p/d </strong> </div>
		<div class="col-sm-2 col-md-1 col-lg-1"> <button class="btn btn-xs btn-danger"> <span class="glyphicon glyphicon-trash"></span> </button> </div>
	</div>
	<hr />

	<br />

	<div class="row">
		<span class="col-sm-12 col-md-12 col-lg-12">
			<button class="btn btn-sm btn-success pull-right"> Complete </button>
		</span>
	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-md-10 col-lg-10"></div>
	<div class="col-sm-2 col-md-2 col-lg-2">
		<select class="form-control">
			<option value="">RAF</option>
		</select>
	</div>
</div>
<br />

<!-- Erectile Dysfunction Risk Assessment Form -->
<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-8 col-md-8 col-lg-8">
				<h4>Erectile Dysfunction Risk Assessment Form</h4>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<strong class="pull-right">(Unlocked fields)</strong>
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-8 col-md-8 col-lg-8">
				Do you take any medicines?
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-success"> Yes </button>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-danger"> No </button>
			</div>
		</div>
	</div>
	<br />
	
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-8 col-md-8 col-lg-8">
				Can you walk 3 miles without aid?
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-success"> Yes </button>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<button class="btn btn-xs btn-block btn-danger"> No </button>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-md-10 col-lg-10"></div>
	<div class="col-sm-2 col-md-2 col-lg-2">
		<button class="btn btn-xs btn-primary btn-block pull-right"> Add </button>
	</div>
</div>

<br />
<!-- Pending Transactions -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading"><strong>Patient History</strong></div>
			<div class="panel-body">
				
				<div class="panel panel-default"> 
					<div class="panel-heading"> 
					
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Date </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Name </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Form </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Strength </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Quantity </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Does </strong>
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									<strong> Transaction Type </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> User </strong>
								</div>
							</div>
						</div>
						
					</div>
					<div class="panel-body">
						
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									27/11/2015
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									Amoxil
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Tablets
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									10mg
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									25
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									3p/d
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									Online RX
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Marty
								</div>
							</div>
						</div>
						<hr />
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- End - Screen 3 - Walkin PGD -->

<!-- Start - Screen 1 - PMR (Non Prescriber Pharmacist - Page 1) -->
<h2 class="text-center"> Screen 1 - PMR (Non Prescriber Pharmacist - Page 1) </h2>
<br />

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>PMR</h3>
	</div>
</div>

<hr />
<br />

<!-- Patients Search -->
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<label for="is_default_doc">Search a patient:</label>
		<input type="text" autocomplete="off" placeholder="Search a patient" required="required" class="form-control search_patient" name="search_patient" id="search_patient">
		<div id="result_patient"></div>
	</div>
</div>

<br />

<!-- Start - Pending Transactions -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading"><strong>Pending Transactions</strong></div>
			<div class="panel-body">
				
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-success"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-primary"><strong>Online ED RX : </strong> Larry Skywalker </span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<button class="btn btn-xs btn-success pull-right">Dispense</button>
					</div>
				</div>
				
				<hr />
				
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-success"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<span class="text-primary"><strong>Online ED PGD : </strong> Darth Skywalker </span>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<button class="btn btn-xs btn-success pull-right">Dispense</button>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
</div>
<!-- End - Pending Transactions -->

<!-- Start - Current Deliveries -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary"> 
			<div class="panel-heading"><strong>Current Deliveries</strong></div>
			<div class="panel-body text-center">
				
				<div class="row">
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-success pull-left"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-primary"> <strong> William Brown </strong> </span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-primary"> <strong> XY5352654 </strong> </span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<button class="btn btn-xs btn-primary pull-right">View</button>
					</div>
				</div>
				
				<hr />
				
				<div class="row">
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-success pull-left"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-primary"> <strong> William Brown </strong> </span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-primary"> <strong> XY5352654 </strong> </span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<button class="btn btn-xs btn-primary pull-right">View</button>
					</div>
				</div>
				
				<hr />
				
				<div class="row">
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-success pull-left"><strong>26/11/2015 15:20</strong></span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-primary"> <strong> William Brown </strong> </span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<span class="text-primary"> <strong> XY5352654 </strong> </span>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<button class="btn btn-xs btn-primary pull-right">View</button>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
</div>
<!-- End - Screen 1 - PMR (Non Prescriber Pharmacist - Page 1) -->

<!-- Start - Screen 2 - PMR - Online RX (Non Prescriber Pharmacist) -->
<hr />

<h2 class="text-center">Screen 2 - PMR - Online RX (Non Prescriber Pharmacist)</h2>

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<h3>PMR Online RX</h3>
	</div>
</div>

<hr />
<br />

<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<strong class="text-primary">William smith</strong>
		<br /> <br />
		<p>
			114 burnley Road, N11 EH
			<br /> <br />
			<span class="glyphicon glyphicon-phone"></span> 07755586586
			<br /> <br />
			<span class="glyphicon glyphicon-envelope"></span> williamsmith@gmail.com
		</p>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
	
		<div class="panel panel-success">
			<div class="panel-heading">
				<strong>Allergies</strong>
				<br /> <br /> <br /> <br /> <br />
				<p></p>
			</div>
		</div>
		
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		
		<div class="panel panel-warning">
		
			<div class="panel-heading">				
				<strong>Pending</strong> <br /> <br />
				<p>Online hair loss RX <br /> Online ED RX</p>
				<br />
			</div>
			
		</div>
		
	</div>
</div>

<br />

<h4>Current Transaction</h4>

<div class="panel panel-default panel-body">
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> 27/11/2015 </strong></div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Time </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Amoxil </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> Tablets </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 10mg </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-1"> <strong> 25 </strong> </div>
		<div class="col-sm-2 col-md-2 col-lg-2"> <strong> 3p/d </strong> </div>	
	</div>
	<hr />

	<br />

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<span class="pull-right">
				<button class="btn btn-sm btn-primary"> Dispense </button>
				<button class="btn btn-sm btn-danger"> Report Issue </button>
			</span>
		</div>
	</div>
</div>

<br /> <br /> <br />

<!-- Patient History -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success"> 
			<div class="panel-heading"><strong>Patient History</strong></div>
			<div class="panel-body">
				
				<div class="panel panel-default"> 
					<div class="panel-heading"> 
					
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Date </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Name </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Form </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Strength </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> Quantity </strong>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									<strong> Does </strong>
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									<strong> Transaction Type </strong>
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									<strong> User </strong>
								</div>
							</div>
						</div>
						
					</div>
					<div class="panel-body">
						
						<div class="row text-center">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-1 col-md-1 col-lg-1">
									27/11/2015
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									Amoxil
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Tablets
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									10mg
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									25
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2">
									3p/d
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									Online RX
								</div>
								<div class="col-sm-1 col-md-1 col-lg-1">
									Marty
								</div>
							</div>
						</div>
						<hr />
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- End - Screen 2 - PMR - Online RX (Non Prescriber Pharmacist) -->

<!-- Start Preview Receipt -->


<!--     CUSTOM PRESCRIPTION ENDS      -->
<div class="row bg-success">

	<div class="col-sm-12 col-md-12 col-lg-12">
		
		<br /> <br />
		
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				
				<div class="col-sm-6 col-md-6 col-lg-6">
					<strong class="text-success pull-left">Prescriber Pharmacist: Wojtek Kruger</strong>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6">
					<strong class="text-success pull-right">Private Prescription</strong>
				</div>
				
			</div>
		</div> <!-- ./row -->
		
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="col-sm-6 col-md-6 col-lg-6">
					GPHC Number : 20352652
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6">
					<span class="pull-right">27 November 2015</span>
				</div>
				
			</div>
		</div> <!-- ./row -->
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				
				<div class="col-sm-6 col-md-6 col-lg-6">
					114 bumley Road, N11 1EH
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6">
					<span class="pull-right">11:42</span>
				</div>
				
			</div>
		</div> <!-- ./row -->
		<br />
		
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12" >
				
				<div class="col-md-9" style="background:#ffffff !important;">
					
					<br /> 
					<strong class="text-success">Patient Details: </strong>
					
					<br />
					Name: Alisson White
					
					<br />
					Address: 114 bumley Road, N11 1EH
					
					<span class="pull-right"> D.O.B 24/5/1986 </span>
					<br /> <br />
                    
                    
				</div>
                
                <div class="col-md-3" style="background:#ffffff !important;height:93px; padding-top:24px">	
                	<img src="<?php echo IMAGES?>logo.jpg" width="151" height="50" />
                </div>
			</div>
		</div> <!-- ./row -->
        
        <div class="row">
			<br />
            <div class="col-md-12">
                <div class="col-md-12" style="background:#ffffff !important;">
                <br />
                    <p><strong class="text-success">Medication Details</strong></p>

                    <p style="padding-top:20px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amoxicillin <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 25mg <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Caps <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21
                    </p>
                    <p style="padding-top:20px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amoxicillin <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 25mg <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Caps <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21
                    </p>

                </div>
            </div>
       	</div> <!-- ./row -->
        <div class="row">
            <div class="col-md-12">
            	
            	<div class="col-md-6" style="background:#ffffff !important;">
                	<br />
                    <p>
                    	<strong class="text-success">Doctor Signatures</strong>
                        <br />
                        <img src="<?php echo USER_SIGNATURE?>signature_37.jpg" width="200"  />
                    </p>
                    
                </div>
                <div class="col-md-6" style="background:#ffffff !important;">
                <br />
                	<p>
                        <strong class="text-success">Prescriber Details</strong>
                        <br /><br /><br />
                        GMC Number : 20352652 <br />
                        114 burnley Road, N11 1EH
                    </p>                
                </div>
            </div>    
		</div> <!-- ./row -->
		<br />
	</div>	
</div>

<!-- End Preview Receipt -->

<!-- End - PMR UI -->