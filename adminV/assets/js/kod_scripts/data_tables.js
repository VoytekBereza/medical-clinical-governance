$(document).ready(function () {
	$('input.tableflat').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
});

    var asInitVals = new Array();

	// For Listing sorting search and pagnition
	var oTable = $('#example').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End example
	
	// For Email Templates Listing sorting search and pagnition
	var oTable = $('#exampleEmail').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [4]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleEmail
	
	
	// For Training Listing sorting search and pagnition
	var oTable = $('#exampleTraining').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [5]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleTraining
	
	// For Training Documents Listing sorting search and pagnition
	var oTable = $('#exampleTrainingDocument').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [6]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleTrainingDocument
	
	// For Training Videos Listing sorting search and pagnition
	var oTable = $('#exampleTrainingVideo').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [6]
			} //disables sorting for column one

		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleTrainingVideo
	
	// For Training Documents Categories Listing sorting search and pagnition
	var oTable = $('#exampleTrainDocumentCategories').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [4]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleTrainDocumentCategories
	
	// PGD Start
	// For PGD Documents Categories Listing sorting search and pagnition
	var oTable = $('#examplePGDDocumtent').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [5]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End examplePGDDocumtent
	
	// For PGD Raf Listing sorting search and pagnition
	var oTable = $('#examplePGDRaf').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [3]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End examplePGDRaf
	
	// For All PGDS Listing sorting search and pagnition
	var oTable = $('#exampleAllPgds').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [6]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleAllPgds
	
	// For PGD Vedio Documents Categories Listing sorting search and pagnition
	var oTable = $('#examplePGDVedio').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [5]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End examplePGDVedio
	
	//How t Video
	var oTable = $('#how_to_videos_grid').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [5]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End how_to_videos_grid
	
	// For PGD Documents Categories Listing sorting search and pagnition
	var oTable = $('#examplePGDDocumentCategory').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [3]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End examplePGDDocumentCategory
	
	// PGD END

	// Using for only CMS Listing sorting search and pagnition
	
	var oTable = $('#exampleCMS').dataTable({
				"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{

				'bSortable': false,
				'aTargets': [4]
				
			} //disables sorting for column one
       ], 
	    // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleCMS
	
	// Using for only Settings Listing sorting search and pagnition
	
	var oTable = $('#exampleSetting').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0],
				'bSortable': false,
				'aTargets': [3]
			} //disables sorting for column one
	],
	    // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End exampleSetting
 
	// Using for only Sop Category Listing sorting search and pagnition
	var oTable = $('#exampleSopCategory').dataTable({
	"oLanguage": {
	"sSearch": "Search all columns:"
	},
	"aoColumnDefs": [
		{
			'bSortable': false,
			'aTargets': [2]
		} //disables sorting for column one
	],
	    // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
		"sSwfPath": "",
		"aButtons": []
	
	}
	}); // End exampleSopCategory
   
	// Using for only Sop  Listing sorting search and pagnition
	var oTable = $('#exampleSop').dataTable({
		
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [4]
				
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleSop
			   
   // Using for only Organization  Listing sorting search and pagnition
	var oTable = $('#exampleOrganization').dataTable({
		
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	

				bSortable: false,
				aTargets: [ 0,1,4,5,6],
				
				
			} //disables sorting for column one
		],
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrganization
   
	// Using for only Organization Pharmacy  Listing sorting search and pagnition
	var oTable = $('#exampleOrganizationPharmacy').dataTable({
		
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [7]
				
				
			} //disables sorting for column one
		],  
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrganizationPharmacy
			   
	// Using for only Organization Pharmacy staff Listing sorting search and pagnition
	var oTable = $('#examplePharmacyStaff').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [4]
				
			} //disables sorting for column one
		],
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrganizationPharmacy
            
 // Using for only Order listing sorting search and pagnition
	var oTable = $('#exampleOrderListing').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [4]
				
			} //disables sorting for column one
		],
		
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrderListing		
   
   // Using for only Quick Forms Documents listing sorting search and pagnition
	var oTable = $('#exampleQuickFormDocumtent').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [5],
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}

   }); // End exampleQuickFormDocumtent		
   
   // Using for only  Quick Forms Category search and pagnition
  
	var oTable = $('#exampleQuickFormCate').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [2]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleQuickFormCate	
   
    // Using for only Governance HR search and pagnition
  
	var oTable = $('#examplegovernancehr').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [3]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End examplegovernancehr		
   
   
   
     // Using Unauthenticated PGDs
  
	var oTable = $('#exampleunauthenticate').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [0],
					'bSortable': false,
				    'aTargets': [5]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End Unauthenticated PGDs		
   
   var oTable = $('#exampleunauthenticate_2').dataTable({

		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				bSortable: false,
				aTargets: [ 0,1,3,4,5,6],

			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End Unauthenticated PGDs		

	var oTable = $('#exampleauthenticatelog').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [0],
					'bSortable': false,
				    'aTargets': [2]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleauthenticatelog PGDs		
   
   
   	var oTable = $('#exampleteamdetault').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [3]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleteamdetault
   
    
   // Start examplepatient
   	var oTable = $('#examplepatient').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [3]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End examplepatient
   
   
      // Start examplepatient
   	var oTable = $('#examplemedicinecategory').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [2],
					'bSortable': false,
				    'aTargets': [3]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End examplepatient		
   
   
       // Start examplepatient
   	var oTable = $('#examplemedicine').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [9]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End examplepatient		
   
   
   
      // Start examplecontactfaq
   	var oTable = $('#examplecontactfaq').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [3]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End examplecontactfaq	
   
   
    // Start examplemedicineraf
   	var oTable = $('#examplemedicineraf').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					
					'bSortable': false,
				    'aTargets': [5]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End examplemedicineraf	
   
    
    // Start examplemedicineraf
   	var oTable = $('#examplevaccine').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					
					'bSortable': false,
				    'aTargets': [3]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End examplemedicineraf	
   
     // Start exampletavelvaccine
   	var oTable = $('#exampletavelvaccine').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					
					'bSortable': false,
				    'aTargets': [2]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampletavelvaccine	
   
     // Start vaccinedestinations
   	var oTable = $('#vaccinedestinations').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
					
					'bSortable': false,
				    'aTargets': [2]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End vaccinedestinations	
   
   
     // ORDER HISTORY
   var oTable = $('#orderhistory').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0]
			} //disables sorting for column one
],
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	});

// END ORDER HISTORY


   // ORDER DETAILS
   var oTable = $('#orderdetails').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0]
			} //disables sorting for column one
],
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	});

// END ORDER DETAILS

   // USER AUDIT
   var oTable = $('#user_audit').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0]
			} //disables sorting for column one
],
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	});




  // Notification
   var oTable = $('#notification').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0]
			} //disables sorting for column one
],
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	});

// END Notification

 // Notification
   var oTable = $('#vaccinebrand').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0]
			} //disables sorting for column one
],
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	});

// END Notification

// Using for only Pharmacy  Listing sorting search and pagnition
	var oTable = $('#Pharmacies').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [7]
				
				
			} //disables sorting for column one
		],  
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrganizationPharmacy
   
   
   
// Using for only Pharmacy  Listing sorting search and pagnition
	var oTable = $('#viewalpatienthistory').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [7]
				
				
			} //disables sorting for column one
		],  
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrganizationPharmacy

   
   
   // ORDER DETAILS
   var oTable = $('#orderdetailspharmacy_statistics').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [0]
			} //disables sorting for column one
],
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	});

// END ORDER DETAILS

		
	$("tfoot input").keyup(function () {
		/* Filter on the column based on the index of this element's parent <th> */
		oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
	});
	$("tfoot input").each(function (i) {
		asInitVals[i] = this.value;
	});
	$("tfoot input").focus(function () {
		if (this.className == "search_init") {
			this.className = "";
			this.value = "";
		}
	});
	$("tfoot input").blur(function (i) {
		if (this.value == "") {
			this.className = "search_init";
			this.value = asInitVals[$("tfoot input").index(this)];
		}
	});
	
	
 // Using for only Organization  Listing sorting search and pagnition
	var oTable = $('#example-old-user').dataTable({
		
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [0,1,2,3,4,5,6,7],
				
			} //disables sorting for column one
		],
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrganization
// END ORDER DETAILS


 // Using for only Organization  Listing sorting search and pagnition
	var oTable = $('#avicena-pgds').dataTable({
		
		"oLanguage": {
			"sSearch": "Search:"
		},
		
		"aoColumnDefs": [
			{	
				'bSortable': false,
				'aTargets': [0,1,2,3,4,5,6],
				
			} //disables sorting for column one
		],
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End exampleOrganization
   
   	// For Listing sorting search and pagnition
	var oTable = $('#avicenna-user-list').dataTable({
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{
				'bSortable': false,
				'aTargets': [1,2,3,4,5,6,7]
			} //disables sorting for column one
		],
		 // Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	}); // End example