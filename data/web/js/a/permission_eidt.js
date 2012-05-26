$(function(){
	hook_validate_frm();
});

function hook_validate_frm(){
	$('#edit_permission_frm').validate({
		rules:{
			title:"required",
			resource:"required",
			privilege:"required"
		},
		messages:{
			title:"权限名称不能为空",
			resource:"模块标识不能为空",
			privilege:"权限标识不能为空"
		},
		submitHandler: function(form) {
			$(form).ajaxSubmit();
		}
	});
}