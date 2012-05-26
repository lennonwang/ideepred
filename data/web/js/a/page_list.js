$(function(){
	$('table.widefat tr').hover(function(){
		$(this).find('div.row-actions').css({'visibility':'visible'});
	},function(){
		$(this).find('div.row-actions').css({'visibility':'hidden'});
	});
	
	$('input.selectscope').bind('change',function(){
		var checked = this.checked;
		if(checked){
			$('#posts-filter').checkCheckboxes('.selectscope');
			$('#posts-filter').checkCheckboxes('.xe-shid');
		}else{
			$('#posts-filter').unCheckCheckboxes('.selectscope');
			$('#posts-filter').unCheckCheckboxes('.xe-shid');
		}
	});
	
	$('input.xe-shid').bind('change',function(){
		var checked = this.checked;
		if(!checked){
			$('#posts-filter').unCheckCheckboxes('.selectscope');
		}
	});
	
	$('#doaction').click(function(){
		var action = $('select.select-action option').filter(':selected').val();
		var ids = new Array();
		$('input.xe-shid').filter(':checked').each(function(){
			var id = $(this).val();
			ids.push(id);
		});
		if(!ids.length){
			return false;
		}
		if(action == 'delete'){
			$.get('/app/admin/page/remove',{id:ids.join(',')});
		}else{
			//skip
		}
	});
	
});