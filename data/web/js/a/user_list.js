$(function(){
	hook_post_form();
});

function hook_post_form(){
	$('#user_search_frm').livequery(function(){
		$(this).validate({
			rules:{
				
			},
			messages:{
				
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