$(function(){
	
	var asset_id = $('#asset_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	
	$("#uploadify_thumb").uploadify({
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/app/admin/asset/uploadify',
		'scriptData'     : {'parent_id':rand_sign_id,'target_id':asset_id,'parent_type':18},
		'queueID'        : 'uploadify_goods_result',
		'auto'           : true,
		'simUploadLimit' : 1,
		'multi'          : false,
		'fileExt'        : '*.png;*.gif;*.jpg;*.bmp;*.jpeg',  
		'fileDesc'       : '图片文件(*.png;*.gif;*.jpg;*.bmp;*.jpeg)',
		'onAllComplete'  : uploadifyRequest
	});
	
});

function uploadifyRequest(event,data){
	var asset_id = $('#asset_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	$.get('/app/admin/asset/fetchAssets', {parent_id:rand_sign_id,parent_type:18,target_id:asset_id});
}