$(function(){
	hook_validate_frm();
});

function hook_validate_frm(){
	$("#addcat").validate({
		errorPlacement: function(error, element) {
			element.parent("div").addClass('form-invalid');
		},
		rules:{
			featurename:"required",
			featurekey:"required",
			category_id:"required"
		},
		messages:{
			featurename:"属性名称不能为空",
			featurekey:"属性标识不能为空",
			category_id:"请选择一个所属分类目录"
		},
		submitHandler: function(form) {
			$(form).ajaxSubmit();
		}
	});
}