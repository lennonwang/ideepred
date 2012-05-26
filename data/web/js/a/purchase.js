function hook_validate_frm(){
	$('#purchasefrm').validate({
		rules:{
			product_size:"required",
			quantity:"required",
			type:"required"
		},
		messages:{
			product_size:"产品的型号不能为空",
			quantity:"产品的数量必须大于0",
			type:"请选择一种修改类型"
		},
		submitHandler:function(form) {
			try{
				$(form).ajaxSubmit();
			}catch(e){
				alert(e);
			}
			return false;
		}
	});
}

$(function(){
	hook_validate_frm();
});