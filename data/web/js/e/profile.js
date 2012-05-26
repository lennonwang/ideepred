$(function(){
	
	$('#euser_frm').validate({
		rules:{
			username:"required"
		},
		messages:{
			username:"您的昵称不能为空"
		},
		submitHandler: function(form){
			try{
				$(form).ajaxSubmit();
			}catch(e){alert(e);}
		}
	});
	
	$('#passwd_frm').validate({
			rules: {
				old_password:{
					required:true,
					minLength: 4
				},
				password:{
					required:true,
					minLength: 4
				},
				repeat_password:{
					required: true,
					minLength: 4,
					equalTo: "#password"
				}
			},
			messages:{
				old_password: {
					required:'请输入您的旧密码',
					minLength:'您输入的密码不对',
				},
				password: {
					required:'请输入您的密码',
					minLength:'您输入的密码太短'
				},
				repeat_password: {
					required:'请再次输入您的密码',
					minLength:'您输入的密码太短',
					equalTo:'密码与重复密码不一致'
				}
			},
			submitHandler: function(form) {
				try{
					$(form).ajaxSubmit();
				}catch(e){
					alert(e);
				}
				return false;
			}
		});

});