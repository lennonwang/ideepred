$(function(){
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
				required:'帐号格式不对，必须是您注册的一个有效邮件地址',
				email:'请输入正确的email格式'
			},
			password:{
				required:'请输入密码(6位以上字符)',
				minlength:'密码设置的太短'
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

//check login result
function checkAuthLogin(result){
	var is_err = result['has_error'];
	if(!is_err){
		url = result.data.next_url;
		window.location.href = url;
	}else{
		var pos = $('#user_login').position();
		pos.top -= 30;
		$('#reqstatus_boxes')
			.html('登录失败：'+result.error_msg)
			.css(pos)
			.show();
	}
}