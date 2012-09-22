$(function(){
	initRegFunc();
	$('#user_login').validate({
		errorElement: "span",
		rules:{
			account:{
				required:true,
				email:true
			},
			password:{
				required:true,
				minlength:6
			}
		},
		messages:{
			account:{
				required:'帐号格式不对',
				email:'请输入正确的email格式'
			},
			password:{
				required:'请输入密码(6位以上字符)',
				minlength:'密码太短'
			}
		},
		submitHandler: function(form){
			try{
				$(form).ajaxSubmit({
					dataType:'json',
					success:checkAuthLogin
				})
			}catch(e){alert(e);}
		}
	});
});

//邮箱校验
function initRegFunc(){
	$("#userName").focusin(function(){
		$("#userName").val("");
	});
	$("#password").focusin(function(){
		$("#password").val("");
	});
	
	$("#userName").focusout(function(){
		reg = new RegExp('^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$');
		if(reg.test($("#userName").val())){
			$("#userName").removeClass("userErr")
			return true;
		}else{
			$("#userName").addClass("userErr");
		}
	})
}

//check login result
function checkAuthLogin(result){ 
	var is_err = result['has_error'];
	console.log('result::'+result+"\t"+is_err);
	if(!is_err){
		url = result.data.next_url; 
		window.location.href = url;
	}else{
		var pos = $('#user_login').position();
		pos.top -= 30;
		console.log('result::'+result+"\t"+result.error_msg);
		$('#reqstatus_boxes')
			.html('登录失败：'+result.error_msg)
			.css(pos)
			.show();
	}
}