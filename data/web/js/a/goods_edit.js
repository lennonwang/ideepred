tinyMCE.init({
	// General options
	mode : "exact",
	elements: "cbody",
	theme : "advanced",
	plugins : "safari,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,|,insertdate,inserttime,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,|,cleanup,preview,code",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example content CSS (should be your site CSS)
	content_css : "css/content.css",
	
	convert_urls : false,
	remove_script_host: false,
	
	save_callback: "rebuildContent",
	onchange_callback: "changeContetnHandler",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js"
});

$(function(){
	hook_validate_frm();
	
	$('#uploadify_assets').fileUpload({ 
		'uploader': '/js/c/uploader.swf',
	    'script': '/app/admin/goods/uploadify',
		'cancelImg': '/images/admin/cancel.png',
		'multi':true,
	    'auto':false,
		'fileDataName':'assets',
		'buttonImg':'/images/admin/modify_btn.jpg',
		'width':78,
		'height':21,
		onComplete: function (evt, queueID, fileObj, response, data) {
			//alert("Successfully uploaded: "+response);
		},
		onAllComplete: function(){
			var id = $('#product_id').val();
			var u_f = '/app/admin/goods/fetch_assets';
			$.get(u_f, {id:id});
		}
	 });
	//handle operate upload
	$('#uploadify_start').bind('click',function(){
		var product_id = $('#product_id').val();
		if(product_id){
			$('#uploadify_assets').fileUploadSettings('scriptData','&id='+product_id);
		}else{
			alert('请先保存基本信息～');
			return false;
		}
		$('#uploadify_assets').fileUploadStart();
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
	$('#cbody').val(getNowPageContent());
}

function hook_validate_frm(){
	$('#edit_product_frm').validate({
		rules:{
			title:"required",
			tags:"required",
			category_id:"required",
			retail_price:'required'
		},
		messages:{
			title:"商品标题不能为空",
			tags:"标签不能为空",
			category_id:"请选择对应的类别",
			retail_price:'市场价不能为空'
		},
		submitHandler: function(form) {
			try{
				rebuildContent();
				
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
							$('#product_id').val(result.data.product_id);
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
