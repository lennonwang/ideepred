$(function(){
	hook_validate_frm();
});

function hook_validate_frm(){
	$('#edit_contest_frm').validate({
		rules:{
			title:"required",
			name:"required"
		},
		messages:{
			title:"标题不能为空",
			name:'标识不能为空'
		},
		submitHandler: function(form) {
			try{
				//result
				var options = {
					 dataType: 'html',
					 success: function(result) {						
						//html to json
						result = result.replace(/<pre\>/,'');
						result = result.replace(/<\/pre\>/,'');
						result = eval('('+result+')')
						
						//alert(result.data.msg);
						if(result.has_error){
							var html = '<div id="_jq_response_result" class="error_dialog">'+result.data.msg+'</div>'
							$('#content-main').prepend(html);
							$('#_jq_response_result').fadeOut(5000,function(){
								$(this).remove();
							});
						}else{
							$('#contest_id').val(result.data.contest_id);
							var html = '<div id="_jq_response_result" class="success_dialog">'+result.data.msg+'</div>'
						 	$('#content-main').prepend(html);
							$('#_jq_response_result').fadeOut(3000,function(){
								$(this).remove();
							});
						}
					 }
				}
				$(form).ajaxSubmit(options);
			}catch(e){
				alert(e);
			}
			return false;
		}
	});
}