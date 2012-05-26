$(function(){
	$('#paginator a').bind('click', function(){
		var p = $(this).attr('href');
		$('input[@name=page]').val(p);
		$('#search_frm').submit();
		return false;
	});
	
	$('#select_topic li').hover(function(){
		$(this).addClass('h');
	},function(){
		$(this).removeClass('h');
	}).click(function(){
		var topic_id = $(this).attr('name');
		$('#topic_id').val(topic_id);
		$('#select_topic').slideUp();
		
		var ids = new Array();
		$('input.pro_c').filter(':checked').each(function(){
			var id = this.value;
			ids.push(id);
		});
		if(ids.length < 1){
			alert('请至少选择一个作品操作!');
			return false;
		}
		var url = '/app/admin/product/add_topic';
		$.get(url,{topic_id:topic_id,id:ids.join(',')});
		
	});
});

function choose_topic(){
	var pos = $(this).position();
	
	pos.top += 25;
	pos.left += 2;
	$('#select_topic')
		.css(pos).slideDown();
}
