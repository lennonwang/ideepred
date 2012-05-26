$(function(){
	hook_validate_frm();
});

function replace_to_upload(){
	var target_id = $(this).parent().attr('id');
	$('#b_'+target_id).insertAfter('#'+target_id);
	$('#'+target_id).hide();
}
function replace_to_show(){
	$(this).parent()
		.prev().show()
		.end()
		.appendTo('#bakup_area');
}
function hook_validate_frm(){
	$('#edit_gift_frm').validate({
		rules:{
			title:"required",
			point:"required",
			start_date:"required",
			end_date:"required"
		},
		messages:{
			title:"名称不能为空",
			point:"兑换积分不能为空",
			start_date:"起始时间未设定",
			end_date:"终止时间未设定"
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
							$('#gift_id').val(result.data.gift_id);
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
