$(function(){
	hook_validate_frm();
	
	hook_taconite_result();
	hook_loading_progress();

	var category_id = $('#category_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	
	$("#uploadify_thumb").uploadify({
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/app/admin/asset/uploadify',
		'scriptData'     : {'parent_id':rand_sign_id,'target_id':category_id,'parent_type':33},
		'queueID'        : 'uploadify_goods_result',
		'auto'           : true,
		'simUploadLimit' : 1,
		'multi'          : false,
		'fileExt'        : '*.png;*.gif;*.jpg;*.bmp;*.jpeg',  
		'fileDesc'       : '图片文件(*.png;*.gif;*.jpg;*.bmp;*.jpeg)',
		'onAllComplete'  : uploadifyRequest
	});
	
	$('div.cate-title').hover(function(){
		$(this).find('label.row-actions').css({'visibility':'visible'});
	},function(){
		$(this).find('label.row-actions').css({'visibility':'hidden'});
	});
	
});

function uploadifyRequest(event,data){
	var category_id = $('#category_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	$.get('/app/admin/asset/fetch_assets', {parent_id:rand_sign_id,parent_type:33,target_id:category_id});
}

function hook_validate_frm(){
	$("#addcat").validate({
		errorPlacement: function(error, element) {
			element.parent("div").addClass('form-invalid');
		},
		rules:{
			name:"required"
		},
		messages:{
			name:"类别名不能为空"
		},
		submitHandler: function(form) {
			$(form).ajaxSubmit();
		}
	});
}