$(function(){
	
	slideProductPhoto();
	
	var tabContainers = $('div.proservice > div.pbox');
	tabContainers.hide().filter(':first').show();

	$('div.proservice ul.tabs a').click(function () {
		tabContainers.hide();
		tabContainers.filter(this.hash).show();
		$('div.proservice ul.tabs a').removeClass('current');
		$(this).addClass('current');
		return false;
	}).filter(':first').click();
	
	$('#post-comment-frm').validate({
		rules:{
			content:{
				required:true,
				minlength:2,
				maxlength:220
			}
		},
		messages:{
			content:{
				required:'内容不能为空',
				minlength:'多说一些吧',
				maxlength:'说的太多了'
			}
		},
		submitHandler: function(form){
			try{
				$(form).ajaxSubmit();
			}catch(e){alert(e);}
		}
	});
	
});

function post_comment(){
	$('#post-comment-frm').submit();
}

function slideProductPhoto(){
	$('.slide-show a.a_ajax').bind('mouseover', function(){
		var image = this.href;
		$('#product-bigpicture').attr({src:image});
	}).bind('click',function(){
		return false;
	});
}
function noAuthLogin(){
	alert('由于您还没有登录，因此您还不能使用该功能。');
	var now_url = window.location.href;
	window.location.href = '/app/eshop/profile/login?next_url='+encodeURIComponent(now_url);
}
function view_comment(){
	$('ul.tabs a.current').removeClass('current');
	$('#product-comment').addClass('current');
	
	$('#product-detail div.pbox').hide();
	$('#reviewsbox').show();
}