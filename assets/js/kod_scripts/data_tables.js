/*$(document).ready(function () {
	$('input.tableflat').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});
});*/

var asInitVals = new Array();
 // Using Unauthenticated PGDs
  
	var oTable = $('#exampleunauthenticate').dataTable({
		"bSort": false,
		"bFilter": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [0],
					'bSortable': false,
				    'aTargets': [4]
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		//"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End Unauthenticated PGDs
   
   var oTable = $('#viewallorderrequest').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [0],
					
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		//"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End Unauthenticated PGDs
   
   
    var oTable = $('#viewalpatienthistory').dataTable({
		"bSort": false,
		"oLanguage": {
			"sSearch": "Search all columns:"
		},
		"aoColumnDefs": [
			{	
					'bSortable': false,
				    'aTargets': [0],
					
			} //disables sorting for column one
		], 
		// Sorting by default null
		"aaSorting": [],
		// End Sorting
		'iDisplayLength': 50,
		"sPaginationType": "full_numbers",
		//"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
   }); // End Unauthenticated PGDs
$(document).ready(function () {
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
		'iDisplayLength': 12,
		"sPaginationType": "full_numbers",
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "",
			"aButtons": []
			
		}
	});
	
   
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
});