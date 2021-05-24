
	$(document).ready(function() {
		// DataTable : Initialise & Send Ajax call
		var table = $('#avicenna-user-list-2').DataTable({

			"processing": true,
		  	"serverSide": true,
		  	"searching" : true,
		  	"order": false, // Set default order to DESC of colums 0
		  	"columnDefs": [

			// Column definitions : Make columns orderable, searchable => true, false
			{ "orderable": false,  "targets": 0 },
		    { "orderable": false, "targets": 1 },
		    { "orderable": false, "targets": 2 },
		    { "orderable": false, "targets": 3 },
		    { "orderable": false, "targets": 4 },
			{ "orderable": false, "targets": 5 },
			{ "orderable": false, "targets": 6 },
			{ "orderable": false, "targets": 7 },
		  ],
			"aaSorting": [],
			// End Sorting
			'iDisplayLength': 10,
			"sPaginationType": "full_numbers",
			"dom": 'T<"clear">lfrtip',
			"tableTools": {
				"sSwfPath": "",
				"aButtons": []
				
			},

		  // Send ajax call to controller
		  "ajax": {
		    
		    "url": SURL + "avicenna/avicenna-users",
		    "type" : "post",
		    "data": function(d) {

		    } // data

		  } // ajax

		}); // End -> DataTable instance
		
		}); // End -> DataTable instance

