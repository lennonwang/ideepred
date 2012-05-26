$(function(){
	//run masonry when page first loads
	$('.masonryBox').masonry({
		singleMode: true,
		itemSelector:'.box'
	});
	//run masonry when window is resized
	$(window).resize(function() {
		$('.masonryBox').masonry();
	});
});