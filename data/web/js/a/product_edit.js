$(function(){
	
	hook_validate_frm();
	
	hook_taconite_result();
	hook_loading_progress();
	
	$('div.handlediv').toggle(function(){
		$(this).parent().addClass('closed');
	},function(){
		$(this).parent().removeClass('closed');
	});
	
	$('div.site_node_list input[@type=checkbox]').bind('change', function(){
		var ids = new Array();
		$('div.site_node_list input[@type=checkbox]').filter(":checked").each(function(){
			console.log('1='+$(this).val());
			ids.push($(this).val());
		})
		if(ids.length > 0){
			console.log('1='+ids);
			$.get('/app/admin/features/fetch_feature',{id:ids.join(',')});
		}
	});
	
	$('#addmetasub').bind('click', function(){
		var metakey = $('#metakeyselect').val();
		var feature_id = $('#metakeyselect option').filter(':selected').attr('name');
		var metavalue = $('#metavalue').val();
		var product_id = $('#product_id').val();
		var rand_sign_id = $('#rand_sign_id').val();
		if(metakey != '#NONE#'){
			$.get('/app/admin/meta/add',{metakey:metakey,metavalue:metavalue,owner_id:product_id,rand_sign_id:rand_sign_id,tmp_id:feature_id});
		}
	});
	
	$('input.updatemeta').livequery(function(){
		$(this).bind('click',function(){
			var target_id = $(this).attr('name');
			var metakey = $('#meta_key_'+target_id).val();
			var metavalue = $('#meta_value_'+target_id).val();
			var product_id = $('#product_id').val();
			var rand_sign_id = $('#rand_sign_id').val();
			
			$.get('/app/admin/meta/add',{id:target_id,metakey:metakey,metavalue:metavalue,owner_id:product_id,rand_sign_id:rand_sign_id});
		});
	});
	
	$('input.deletemeta').livequery(function(){
		$(this).bind('click',function(){
			var target_id = $(this).attr('name');
			
			$.get('/app/admin/meta/delete',{id:target_id});
		});
	});
	
	$('table.widefat tr').hover(function(){
		$(this).find('div.row-actions').css({'visibility':'visible'});
	},function(){
		$(this).find('div.row-actions').css({'visibility':'hidden'});
	});
	
});

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
	$('#cbody').val(getNowPageContent());
}


function hook_validate_frm(){
	$('#addproduct').validate({
		rules:{
			title:"required",
			catcode:"required",
			category_id:"required"
		},
		messages:{
			title:"产品标题不能为空",
			catcode:"请选择一个分类",
			category_id:"请选择所属的品牌"
		},
		errorClass: "invalid",
		errorLabelContainer: $("#messageBox"),
		wrapper: "li",
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