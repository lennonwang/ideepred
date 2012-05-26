$(function(){
	$('input.mdyaction').bind('click',function(){
		if(confirm("快递费用一旦修改将可能无法返回，确认要修改吗？")){
			var order_id = $(this).attr('name');
	 		var old_value = parseInt($('#old_freight_'+order_id).val());
			var new_value = parseInt($('#freight_'+order_id).val());

			if(new_value == old_value){
				alert('金额没有修改,无需更新！');
				return false;
			}
			var url = '/app/admin/orders/modify_freight';
			$.get(url,{id:order_id,freight:new_value});
		}
	});
});