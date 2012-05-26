var product_id = $('#product_id').val();
var rand_sign_id = $('#rand_sign_id').val();

$("#uploadify_assets").uploadify({
	'uploader'       : '/js/uploadify/uploadify.swf',
	'script'         : '/app/admin/asset/uploadify',
	'scriptData'     : {'parent_id':rand_sign_id,'target_id':product_id,'parent_type':7},
	'queueID'        : 'uploadify_goods_result',
	'fileDataName'   : 'photo',
	'auto'           : true,
	'simUploadLimit' : 10,
	'multi'          : true,
	'fileExt'        : '*.png;*.gif;*.jpg;*.bmp;*.jpeg',  
	'fileDesc'       : '图片文件(*.png;*.gif;*.jpg;*.bmp;*.jpeg)',
	'onAllComplete'  : uploadifyRequest
});

function uploadifyRequest(event,data){
	var product_id = $('#product_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	$.get('/app/admin/asset/fetch_assets', {parent_id:rand_sign_id,parent_type:'4_5_7',target_id:product_id});
}