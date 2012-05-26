$(function(){
	hook_validate_frm();
	
	var advertise_id = $('#advertise_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	
	$("#uploadify_thumb").uploadify({
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/app/admin/asset/uploadify',
		'scriptData'     : {'parent_id':rand_sign_id,'target_id':advertise_id,'parent_type':66},
		'queueID'        : 'uploadify_goods_result',
		'auto'           : true,
		'simUploadLimit' : 1,
		'multi'          : false,
		'fileExt'        : '*.png;*.gif;*.jpg;*.bmp;*.jpeg',  
		'fileDesc'       : '图片文件(*.png;*.gif;*.jpg;*.bmp;*.jpeg)',
		'onAllComplete'  : uploadifyRequest
	});
	
});

function show_block(){
	$('#used_pos_number').toggle();
}

function put_context(){
	var varstr = $(this).text();
	var poslit = varstr.split('|');
	$('#number').val(poslit[0]);
	$('#alias').val(poslit[1]);
}

function uploadifyRequest(event,data){
	var advertise_id = $('#advertise_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	$.get('/app/admin/asset/fetchAssets', {parent_id:rand_sign_id,parent_type:66,target_id:advertise_id});
}

function hook_validate_frm(){
	$('#addoption').validate({
		rules:{
			title:"required",
			number:"required",
			link:"required"
		},
		messages:{
			title:"广告标题不能为空",
			number:"广告编号不能为空",
			link:"广告链接不能为空",
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
}