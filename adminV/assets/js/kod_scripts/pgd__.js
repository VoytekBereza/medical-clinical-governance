/*
---------------------------------------------------------
-------Custon scripts - custom javascript functions------
----------------------------------------------------------
*/

function check_all_assigned(e){
	$(".checkbox_purchased").prop('checked', $(e).prop("checked"));
}

function check_all_unassigned(e){
	$(".checkbox_non_purchased").prop('checked', $(e).prop("checked"));
}


// Start - function assign_pgd_admin(uid, pgd_id, pgd_type) : Function to send POST to assign PGD to the user
function assign_pgd_admin(uid, pgd_id, pgd_type, action, pgd_name, user_name){

	var html = '<input type="hidden" name="user_id" value="'+ uid +'" />';
	html += '<input type="hidden" name="pgd_id" value="'+ pgd_id +'" />';
	html += '<input type="hidden" name="pgd_type" value="'+ pgd_type +'" />';
	html += '<input type="hidden" name="action" value="'+ action +'" />';
	
	$('#assign_pgd_form_hidden_inputs').html(html);
	if(action == 'assign'){
		$('#assign-unassign-pgd-btn').html('<button class="btn btn-sm btn-success" type="submit" name="assign_pgd_btn" value="1" > Assign PGD </button>');
		$('#confirmation_txt').html('Are you sure you you want to assign <strong>'+pgd_name+'</strong> for <strong>'+user_name+'</strong>?');
	}else{
		$('#assign-unassign-pgd-btn').html('<button class="btn btn-sm btn-danger" type="submit" name="assign_pgd_btn" value="1" > Unassign PGD </button>');
		$('#confirmation_txt').html('Are you sure you you want to unassign <strong>'+pgd_name+'</strong> for <strong>'+user_name+'</strong>?');
	}// if(action == 'assign')

	$('#assign-pgd-trigger').trigger("click");

} // End - function assign_pgd_admin(uid, pgd_id, pgd_type)

// Start - function renew_pgd_admin(uid, pgd_id, pgd_type) : Function to send POST to assign PGD to the user
function renew_pgd_admin(uid, pgd_id, pgd_type, action, pgd_name, user_name){
	
	var html = '<input type="hidden" name="user_id" value="'+ uid +'" />';
	html += '<input type="hidden" name="pgd_id" value="'+ pgd_id +'" />';
	html += '<input type="hidden" name="pgd_type" value="'+ pgd_type +'" />';
	html += '<input type="hidden" name="action" value="'+ action +'" />';
	
	
	$('#assign_renew_pgd_form_hidden_inputs').html(html);
	if(action == 'assign'){
		$('#assign-unassign-renew-pgd-btn').html('<button class="btn btn-sm btn-success" type="submit" name="assign_pgd_btn" value="1" > Renew PGD </button>');
		$('#confirmation_renew_txt').html('Are you sure you you want to advance renew <strong>'+pgd_name+'</strong> for <strong>'+user_name+'</strong>?');
	}else{
		$('#assign-unassign-renew-pgd-btn').html('<button class="btn btn-sm btn-danger" type="submit" name="assign_pgd_btn" value="1" > Remove PGD </button>');
		$('#confirmation_renew_txt').html('Are you sure you you want to remove renew <strong>'+pgd_name+'</strong> for <strong>'+user_name+'</strong>?');
	}// if(action == 'assign')

	$('#assign-renew-pgd-trigger').trigger("click");

} // End renew_pgd_admin