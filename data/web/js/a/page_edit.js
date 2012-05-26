$(function(){	
	$('#save_product_draft').click(function(){
		var state = $('#article_status').val();
		if (state != 1){
			$('#article_status').val(0);
		}
		$('#edit_article_frm').submit();
	});
	$('#submit_product').click(function(){
		$('#article_status').val(1);
		$('#edit_article_frm').submit();
	});
	
	hook_validate_frm();
	
	var article_id = $('#article_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	
	$("#uploadify_assets").uploadify({
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/app/admin/asset/uploadify',
		'scriptData'     : {'parent_id':rand_sign_id,'target_id':article_id,parent_type:8},
		'queueID'        : 'uploadify_goods_result',
		'auto'           : true,
		'simUploadLimit' : 10,
		'multi'          : true,
		'fileExt'        : '*.png;*.gif;*.jpg;*.bmp;*.jpeg',  
		'fileDesc'       : '图片文件(*.png;*.gif;*.jpg;*.bmp;*.jpeg)',
		'onAllComplete'  : uploadifyRequest
	});
	
	
	$('div.handlediv').toggle(function(){
		$(this).parent().addClass('closed');
	},function(){
		$(this).parent().removeClass('closed');
	});
	
	
	$('#addmetasub').bind('click', function(){
		var metakey = $('#metakeyselect').val();
		var metavalue = $('#metavalue').val();
		var article_id = $('#article_id').val();
		var rand_sign_id = $('#rand_sign_id').val();
		if(metakey != '#NONE#'){
			$.get('/app/admin/meta/add',{metakey:metakey,metavalue:metavalue,owner_id:article_id,rand_sign_id:rand_sign_id,tmp_id:0});
		}
	});
	
	$('input.updatemeta').livequery(function(){
		$(this).bind('click',function(){
			var target_id = $(this).attr('name');
			var metakey = $('#meta_key_'+target_id).val();
			var metavalue = $('#meta_value_'+target_id).val();
			var article_id = $('#article_id').val();
			var rand_sign_id = $('#rand_sign_id').val();
			
			$.get('/app/admin/meta/add',{id:target_id,metakey:metakey,metavalue:metavalue,owner_id:article_id,rand_sign_id:rand_sign_id});
		});
	});
	
	$('input.deletemeta').livequery(function(){
		$(this).bind('click',function(){
			var target_id = $(this).attr('name');
			
			$.get('/app/admin/meta/delete',{id:target_id});
		});
	});
});

function getNowPageContent(){
    return tinyMCE.get('cbody').getContent();
}
function setNowPageContent(c){
	tinyMCE.get('cbody').setContent(c);
}
function changeContetnHandler(inst) {
    var body = inst.getBody().innerHTML;
    $('#cbody').val(body);
}
function rebuildContent(){
	var body = inst.getBody().innerHTML;
    $('#cbody').val(body);
}

function uploadifyRequest(event,data){
	var article_id = $('#article_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	$.get('/app/admin/asset/fetch_assets', {parent_id:rand_sign_id,parent_type:8,target_id:article_id});
}

//insert asset into editor
function insert_asset(){   	
    try{
		var url = getUrl(this.href);
		$.get(url,{}, function(data){
			//insert into editor(tinyMCE is global)
			tinyMCE.execCommand('mceInsertContent', false, data); 
		});
	}catch(e){ alert("insert asset: "+ e);}
}

function hook_validate_frm(){
	$('#edit_article_frm').validate({
		rules:{
			title:"required"
		},
		messages:{
			title:"标题不能为空"
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