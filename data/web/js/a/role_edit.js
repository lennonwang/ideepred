$(function(){
	hook_validate_frm();
});

function hook_validate_frm(){
	$('#edit_role_frm').validate({
		rules:{
			name:"required"
		},
		messages:{
			name:"用户组名称不能为空"
		},
		submitHandler: function(form) {
			try{
				//append another params
				append_conditions();
				
				$(form).ajaxSubmit();
			}catch(e){
				alert(e);
			}
			return false;
		}
	});
}

function add_premission(){
	$('#permissions_from option').filter(':selected').each(function(){
		$(this).appendTo('#permissions_to');
	});
}

function chooseall(){
	$('#permissions_from option').each(function(){
		$(this).appendTo('#permissions_to');
	});
}

function clearall(){
	$('#permissions_to option').each(function(){
		$(this).appendTo('#permissions_from');
	});
}

function remove_premission(){
	$('#permissions_to option').filter(':selected').each(function(){
		$(this).appendTo('#permissions_from');
	});
}

function append_conditions(){
	var ids = new Array();
	$('#permissions_to option').each(function(){
		ids.push($(this).val());
	});
	$('#permission_ids').val(ids.join(','));
}
