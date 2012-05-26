$(function(){
	hook_quantity();
});

function hook_quantity(){
	$('input.jquantity').bind('blur',function(){
		var q = $(this).val();
		var url = $(this).prev().attr('href');
		if(q == 0){
			if(!confirm('确定不购买该商品？')){
				return false;
			}
		}
		$.get(url,{quantity:q});
	});
}