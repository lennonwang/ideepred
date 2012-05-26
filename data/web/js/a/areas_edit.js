$(function(){
	hook_validate_frm();
});

function hook_validate_frm(){
	$('#edit_area_frm').validate({
		rules:{
			type:'required',
			name:"required"
		},
		messages:{
			type:'请选择类型',
			name:"地名不能为空"
		},
		submitHandler: function(form) {
			$(form).ajaxSubmit();
		}
	});
}