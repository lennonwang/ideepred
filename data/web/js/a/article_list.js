function selected_all(){
	$('#changelist').checkCheckboxes('.chk_atc', false);
}

function selected_reverse(){
	$('#changelist').toggleCheckboxes('.chk_atc', false);
}
function selected_none(){
	$('#changelist').unCheckCheckboxes('.chk_atc', false);
}
//批量删除/审核/推荐
function done_batch(){
	var u = getUrl(this.href);
	var ids = new Array();
	$('input.chk_atc').filter(':checked').each(function(){
		var id = this.value;
		ids.push(id);
	});
	if(ids.length < 1){
		alert('请至少选择一个资讯操作!');
		return false;
	}
	$.get(u,{id:ids.join(',')});
	return false;
}

$(function(){
	$('table.widefat tr').hover(function(){
		$(this).find('div.row-actions').css({'visibility':'visible'});
	},function(){
		$(this).find('div.row-actions').css({'visibility':'hidden'});
	});
});