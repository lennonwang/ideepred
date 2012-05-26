$(function(){
	$('input[@name=sort_id]').bind('change', function(){
		if (this.checked){
			$(this).next('label').addClass('selected');
		}else{
			$(this).next('label').removeClass('selected');
		}
	});
	
	hook_validate_frm();
	
	$('#uploadify_assets').fileUpload({ 
		'uploader': '/js/c/uploader.swf',
	    'script': '/app/admin/article/uploadify',
		'cancelImg': '/images/admin/cancel.png',
	    'auto':false,
		'fileDataName':'assets',
		'buttonText': 'Select Files',
		onComplete: function (evt, queueID, fileObj, response, data) {
			//alert("Successfully uploaded: "+response);
		},
		onAllComplete: function(){
			var article_id = $('#article_id').val();
			var u_f = '/app/admin/article/fetch_assets';
			$.get(u_f, {id:article_id});
		}
	 });
	//handle operate upload
	$('#uploadify_start').bind('click',function(){
		var article_id = $('#article_id').val();
		if(article_id){
			$('#uploadify_assets').fileUploadSettings('scriptData','&id='+article_id);
		}else{
			alert('请先保存基本信息～');
			return false;
		}
		$('#uploadify_assets').fileUploadStart();
	});
	
	$('#uploadify_result input.ckb_accessory').bind('change', function(){
		var id = $(this).val();
		if(this.checked){
			$('#asset_'+id).addClass('pic_slt');
		}else{
			$('#asset_'+id).removeClass('pic_slt');
		}
	});
});

//insert asset into editor
function insert_asset(){   	
    try{
		var url = getUrl(this.href);
		var ids = new Array();
		$('#uploadify_result input.ckb_accessory').filter(':checked').each(function(){
			var id = $(this).val();
			ids.push(id);
		});
		if(ids.length <= 0){
			alert('至少选定一个缩略图吧～');
			return false;
		}
		$.get(url, {asset_id: ids.join(",")}, function(data){
			//insert into editor(tinyMCE is global)
			tinyMCE.execCommand('mceInsertContent', false, data); 
		});
	}catch(e){ alert("insert asset: "+ e);}
}

//标识为缩略图
function assign_thumb(){
	var url = getUrl(this.href);
	var article_id = $('#article_id').val();
	if(!article_id){
		alert('请先保存基本信息～');
		return false;
	}
	var ids = new Array();
	$('#uploadify_result input.ckb_accessory').filter(':checked').each(function(){
		var id = $(this).val();
		ids.push(id);
	});
	if(ids.length > 1 || ids.length == 0){
		alert('缩略图只能指定一个～');
		return false;
	}
	$.get(url,{id:article_id,asset_id:ids[0]});
	return false;
}
function close_panel(){
	$('#article_other_info').hide();
}

function show_block(){
	var id = this.name;
	
	var h = $(this).parent().height();
	var w = $(this).parent().outerWidth();
	var pos = $(this).parent().position();
	pos.top += h;
	pos.left += w-200 ;
	
	$(this)
		.siblings('a').removeClass('current')
		.end().addClass('current');
		
	var targets = ['article_sorts','article_asset'];
	
	for(i=0;i<targets.length;i++){
		if(targets[i] == id){
			$('#'+id).show();
		}else{
			$('#'+targets[i]).hide();
		}
	}
	
	$('#article_other_info')
		.css(pos)
		.show();
}

function hook_validate_frm(){
	$('#edit_article_frm').validate({
		rules:{
			title:"required",
			name:"required",
			excerpt:"required"
		},
		messages:{
			title:"标题不能为空",
			name:'专题标识不能为空',
			excerpt:"简介别为空"
		},
		submitHandler: function(form) {
			try{
				//result
				var options = {
					 dataType: 'html',
					 success: function(result) {
						//<pre>{"error_code":null,"error_msg":null,"has_error":false,"data":{"user_id":"2","msg":"\u7528\u6237\u4fe1\u606f\u4fdd\u5b58\u6210\u529f!"}}</pre>
						
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
							$('#article_id').val(result.data.article_id);
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
	//update article sorts
	$('#update_art_sort').livequery(function(){
		$(this).bind('click', function(){
			var article_id = $('#article_id').val();
			if(!article_id){
				alert('请先保存基本信息～');
				return false;
			}
			var options = {
				data: {id:article_id}
			}
			$('#article_sort_frm').ajaxSubmit(options);
		});
	});
}