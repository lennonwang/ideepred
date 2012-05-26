$(function(){
	hook_validate_frm();
});

function hook_validate_frm(){
	$('#edit_sort_frm').validate({
		rules:{
			name:"required"
		},
		messages:{
			name:"名称不能为空"
		},
		submitHandler: function(form) {
			$(form).ajaxSubmit();
		}
	});
}