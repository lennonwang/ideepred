$(function(){	
	$('#edit_article_frm').validate({
		rules:{
			title:{
				required:true,
				minLength:2,
				maxLength:25
			},
			url:{
				required:true,
				url:true
			}
		},
		messages:{
			title:{
				required:'名称不能为空',
				minLength: '名称不能少于2个字符',
				maxLength: '名称不能多于25个字符'
			},
			url:{
				required: '链接不能为空',
				url: '链接格式不准确'
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