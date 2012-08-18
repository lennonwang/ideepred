$(function(){
	hook_validate_frm();
	change_area();
});

function change_area(cityId){
	$('#choose_province').bind('change',function(){
		change_area_value();
	});
}
 

function change_area_value(){
	var cityId= $('#choose_city_id').val();   
	var id = $('#choose_province').children('option').filter(':selected').val();
	var url = $('#provice_box').attr('name');
	if(id > 0){ 
		$.get(url,{province_id: id,city_id:cityId});
	}
}
function checkout_confirm(){
	var req_uri = $(this).attr('rel');
	$.ajax({
		url:req_uri,
		dataType:'json',
		success:function(result){
			if(!result.has_error){//success dialog
				window.location.href = '/app/eshop/shopping/do_success?order_ref='+result.data.order_ref;
			}else{//error dialog
				alert(result.data.error_msg);
			}
		}
	});
}

function submit_order(){
	var form = this.name;
	$('#'+form).submit();
}

/**********************Tools**********************************/
// 手机号码验证   
jQuery.validator.addMethod("mobile", function(value, element){   
	var length = value.length;
	return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value));   
}, "请正确填写您的手机号码");

function hook_validate_frm(){
	/**
	 * 检查收货地址信息表单中填写的内容
	 */
	$('#basic_ofrm').validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent("td") );
		},
		rules: {
			name:"required",
			province:"required",
			address:{
				required:true
			},
			zip:{
				number:true
			},
			mobie:{
				required:function(element){
					return jQuery("#telephone").val() == '' || jQuery("#telephone").val() == null;
				},
				mobile:function(element){
					return jQuery("#mobie").val() != null;
				}
			},
			telephone:{
				number:function(element){
					return jQuery("#telephone").val() != null;
				}
			},
			email:{
				required:true,
				email:true
			}
		},
		messages:{
			name: '收货人姓名不能为空！',
			province:"请选择所在的省份",
			address:{
				required:'详细地址不能为空！'
			},
			zip:{
				number:'邮政编码只能填写数字!'
			},
			mobie:{
				required:'电话和手机号至少填写一项！',
				mobile:'手机号码不是合法号码!'
			},
			telephone:{
				number:'电话号码不有效的号码!'
			},
			email:{
				required:'请输入您的邮件地址!',
				email:'您输入的邮件地址不是一个合法的邮件地址!'
			}
		}
	});
	
	$('#payment_ofrm').validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent("td") );
		},
		rules: {
			payment_method:"required"
		},
		messages:{
			payment_method: '必须选择一种支付方式'
		}
	});
	
	$('#notice_ofrm').validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent("td") );
		},
		rules: {
			summary:{
				maxlength: 100
			}
		},
		messages:{
			summary: {
				maxlength: '备注必须少于100字'
			}
		}
	});
}