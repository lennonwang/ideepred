$(function(){
	$('li.wp-has-submenu a.menu-top').click(function(){
		$(this).parent()
			.siblings('.am-menu-open').removeClass('am-menu-open')
			.end().addClass('am-menu-open');
		return false;
	});
});