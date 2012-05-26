$(function(){
	hook_validate_frm();
	
	hook_taconite_result();
	hook_loading_progress();
});

function hook_validate_frm(){
	$("#addoption").validate({
		errorPlacement: function(error, element) {
			element.parent("div").addClass('form-invalid');
		},
		rules:{
			website_name:"required"
		},
		messages:{
			website_name:"网站名称不能为空"
		},
		submitHandler: function(form) {
			$(form).ajaxSubmit();
		}
	});
}