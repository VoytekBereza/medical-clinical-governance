$(document).ready(function() { 

	var load_register = function() {
		
		var current_page = $('#current_page').val();
		var drug_id = $('#drug_id').val();
		var keyword = $('#src_keyword').val();

		var data = new Array();
		data.push({name: 'current_page', value: current_page});	
		data.push({name: 'drug_id_select_box', value: drug_id});	
		data.push({name: 'keyword', value: keyword});
	
		// Call ajax to load more Blog POST on Ready
		$.ajax({
		
		  type: "POST",
		  url: SURL + "registers/register-load-more",
		  data: data,
		  beforeSend : function(result){
			$('.overlay').removeClass('hidden');
		  },
		  success: function(data){
			$('.overlay').addClass('hidden');
			$("#load_register_data").html(data);
		  }
		}); // $.ajax
	};
	
	$('#container').on('click', '.page-item',  function() {

		var current_page = $(this).attr('data-page');
		$('#current_page').val(current_page);
		
		load_register();
		
	});
	
	if ($('#load_register_data').length)
		load_register();
		
	$('#search_reg_btn').click(function(){
		$('#current_page').val('');
		load_register();
	})

});