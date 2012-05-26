$(function(){
	hook_validate_frm();
	
});

function hook_validate_frm(){
	$("#adduser").validate({
		rules:{
			account:{
				required:true,
				email: true
			},
			password:{
				required:true,
				minLength:6
			},
			pass2:{
				required:true,
				minLength:6,
				equalTo:"#password"
			},
			username:{
				required:true
			}
		},
		messages:{
			account:{
				required:"用户名不能为空,留个邮箱地址吧",
				email:'请输入正确的email格式'
			},
			password:{
				required:'设置一个密码吧',
				minLength:'密码设置的太短'
			},
			pass2:{
				required:'设置一个密码吧',
				minLength:'密码设置的太短',
				equalTo:"请输入相同的密码"
			},
			username:{
				required:"昵称不能为空"
			}
		},
		submitHandler: function(form) {
			$(form).ajaxSubmit();
		}
	});
}