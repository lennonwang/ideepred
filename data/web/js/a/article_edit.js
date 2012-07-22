$(function(){
	//$('#cbody').val(ary_content.p_1);
	//createContentPage();
	//hook_page_nav();
	
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
	
	/*
	$('input[@name=sort_id]').bind('change', function(){
		if (this.checked){
			$(this).next('label').addClass('selected');
		}else{
			$(this).next('label').removeClass('selected');
		}
	});
	*/
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
		var feature_id = $('#metakeyselect option').filter(':selected').attr('name');
		var metavalue = $('#metavalue').val();
		var article_id = $('#article_id').val();
		var rand_sign_id = $('#rand_sign_id').val();
		if(metakey != '#NONE#'){
			$.get('/app/admin/meta/add',{metakey:metakey,metavalue:metavalue,owner_id:article_id,rand_sign_id:rand_sign_id,tmp_id:feature_id});
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

function uploadifyRequest(event,data){
	var article_id = $('#article_id').val();
	var rand_sign_id = $('#rand_sign_id').val();
	$.get('/app/admin/asset/fetch_assets', {parent_id:rand_sign_id,parent_type:8,target_id:article_id});
}

var j_p = 'p_1';
function createContentPage(){
	for(var i=0;i<ary_count;i++){
		if(i == 0){
			var p = '<a href="#p_'+(i+1)+'" name="'+(i+1)+'" class="p now">'+(i+1)+'</a>';
		}else{
			var p = '<a href="#p_'+(i+1)+'" name="'+(i+1)+'" class="p">'+(i+1)+'</a>';
		}
		$('#del').before(p);
	}
}
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
	ary_content[j_p] = getNowPageContent();
	var _lst = new Array();
	for(var i=0;i<ary_count;i++){
		var c = ary_content['p_'+(i+1)];
		if(c){
			_lst.push(c);
		}
	}
	var cs = _lst.join('<!-- pagebreak -->');
	$('#cbody').val(cs);
}
function changeStyles(name){
	$('#jqpage a.now').removeClass('now');
	$('#jqpage a[@name='+name+']').addClass('now');
}
function hook_page_nav(){
    $('#add').livequery(function(){
        $(this).unbind()
            .bind('click', function(){
                //保存当前页的内容
				ary_content[j_p] = getNowPageContent();
				
                //添加新一页
                ary_count += 1;
				$('#del').before('<a href="#p_'+ary_count+'" name="'+ary_count+'" class="p now">'+ary_count+'</a>');
				j_p = 'p_'+ary_count;
                changeStyles(ary_count);

                ary_content[j_p] = '';
                setNowPageContent(ary_content[j_p]);
            });
    });
	
	$('#jqpage a.p').livequery(function(){
		$(this).unbind().bind('click',function(){
			//保存当前页的内容
			ary_content[j_p] = getNowPageContent();
			
			var page = this.name;
			changeStyles(page);
			
			j_p = 'p_'+page;
			
			setNowPageContent(ary_content[j_p]);
			
			return false;
		});
	});
	
	$('#del').livequery(function(){
        $(this).unbind()
            .bind('click', function(){
                if($('#jqpage a.p').length == 1){
					alert('不允许删除所有页');
					return false;
				}
				var now = parseInt(j_p.substr(2));
				//清空自己
				$('#jqpage > a[@name='+now+']').remove();
				
				ary_content[j_p] = '';
				ary_count -= 1;
				
				if(now < ary_count){
					$('#jqpage > a:gt('+(now-1)+')').filter('.p').remove();
					
					for(var i=now;i<=ary_count;i++){
						var next = 'p_'+(i+1);
						var nc = 'p_'+i;
						ary_content[nc] = ary_content[next];
						$('#del').before('<a href="#p_'+i+'" name="'+i+'" class="p">'+i+'</a>');
					}
				}

				var prev = Math.max(1,now-1);
				j_p = 'p_'+prev;
				changeStyles(prev);
				
				setNowPageContent(ary_content[j_p]);

				return false;
            });
    });
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
			title:"required",
			excerpt:"required"
		},
		messages:{
			title:"标题不能为空",
			excerpt:"简介别为空"
		},
		submitHandler: function(form) {
			try{
				
			//	rebuildContent();
				
				$(form).ajaxSubmit();
			}catch(e){
				alert(e);
			}
			return false;
		}
	});
}