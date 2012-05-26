$(function(){
	hook_validate_frm();
});

function hook_validate_frm(){
	$('#edit_article_frm').livequery(function(){
		$(this).validate({
			rules:{
				mailto:"required",
				subject:"required",
				body:"required"
			},
			messages:{
				mailto:"收件人不能为空",
				subject:"邮件主题不能为空",
				body:"邮件内容不能为空"
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
}