$(function(){
	 
	// initRegFunc();
	 
	hook_validate_frm();
	//输出验证图片
	$('#input_checkcode').after('<img src="/app/eshop/profile/validate_image" alt="随机验证码" id="check_imgcode"/>');
});

// 手机号码验证   
jQuery.validator.addMethod("mobile", function(value, element){   
	var length = value.length;
	return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/.test(value));   
}, "请正确填写您的手机号码");

jQuery.validator.addMethod("checkUserInfo",function(value,element,param){ 
	if(this.optional(element)){
		return true;
	}
	var cached = this.valueCache[element.name];
	if(!cached){
		this.valueCache[element.name] = cached = {
			old: null,
			valid: true,
			message: this.defaultMessage(element,"checkUserInfo")
		};
	}
	this.settings.messages[element.name].remote = typeof cached.message == "function" ? cached.message(value) : cached.message;
	if( cached.old !== value){
		cached.old = value;
		var validator = this;
		this.startRequest(element);
		jQuery('.check[@for='+element.name+']').show();
		jQuery.ajax({
            url: param,
            mode: "abort",
            port: "validate",
            dataType: "json",
            method:'post',
            data: {account: value},
            success: function(response) {
                if ( response.has_error ) {
                    var errors = {};
                    errors[element.name] =  validator.defaultMessage( element, "checkUserInfo" );
                    validator.showErrors(errors);
                }
                cached.valid = !response.has_error;
                validator.pendingRequest--;
                jQuery('.check[@for='+element.name+']').hide();
            }
        });
		return true;
	}
	return cached.valid;
}, "*该Email已经注册过");

function hook_validate_frm(){
	$('#user_register').validate({
		errorElement: "span",
		rules:{
			account:{
				required:true,
				email: true,
				checkUserInfo:'/app/eshop/profile/check_account'
			},
			username:{
				required:true,
				checkUserInfo:'/app/eshop/profile/check_username'
			},
			password:{
				required:true,
				minlength:6
			},
			confrimpassword:{
				required:true,
				minlength:6,
				equalTo:"#password"
			}
		},
		messages:{
			account:{
				required:"留个邮箱地址吧",
				email:'请输入正确的email格式',
				checkUserInfo:'该Email已经注册过'
			},
			username:{
				required:"用户名不能为空",
				checkUserInfo:'这个名字已经被注册过了'
			},
			password:{
				required:'设置一个密码吧',
				minlength:'密码设置的太短'
			},
			confrimpassword:{
				required:'设置一个密码吧',
				minlength:'密码设置的太短',
				equalTo:"请输入相同的密码"
			}
		},
		submitHandler: function(form) {
			try{
				form.submit();
			}catch(e){
				alert(e);
			}
			return false;
		}
	});
}

function change_check_code(){
	$('#check_imgcode').attr({src:'/app/eshop/profile/validate_image?nowtime='+ new Date().getTime()});
}