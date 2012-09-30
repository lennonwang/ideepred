$(function(){
	
	$.each($("#thumblist li a"), function(i, n){  
	 $(this).attr("rel","{"+$(this).attr("o_rel")+"}")
		console.log('rel::'+$(this).attr("rel"));
	}); 
	
 
	
	if($(".buyNumber").size() > 0){
		buyNumberBindFunction();
	}
	
	if($("input.addtocart").size() > 0){
		addToCate();
	}
	
	if($("input.collect").size() > 0){
	 	addToCollect();
	}
	
	chgProductTabs();
  
	// 点击评论跳转到评论区域
	$('#commentLink').click(function(){
		window.scrollTo(0,$('#userCommentLink').offset().top-100);
		$("#userCommentLink").click();
		return false;
	});
	
	
	// 隐藏大图事件
	$("#mwMask").click(function(){
		$(this).hide();
		$("#mwPopUp").fadeOut()
	});

	$("#mwPopUp a.close").click(function(){
		$("#mwMask").hide();
		$("#mwPopUp").fadeOut()
	});

	// 点击小图 绑定事件
	$("#imgS a.imgSmall").click(function(){
		$("#imgM").hide();
		var _imgM = $(this).attr("data-imgM-url");
		bigImgUrl = $(this).attr("data-imgB-url");
		$("#imgM").attr("src",_imgM).fadeIn();
	});

	// 点击zoom查看大图 绑定事件
	$("a.zoom").click(function(){
		if(bigImgUrl == ""){
			bigImgUrl = $("#imgM").attr("data-imgB-url");
		}
		console.log('bigImgUrl:::'+bigImgUrl);
		$("#imgB").attr("src",bigImgUrl);
		showPopUp();
	});
	
	
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



var bigImgUrl = ""; 



//购买数量修改。
function buyNumberBindFunction(){
	
	var cutNumber = $(".buyNumber input.num").val()*1;
	$(".buyNumber .numUp a").click(function(){
		cutNumber += 1;
		$(".buyNumber input.num").val(cutNumber);
	});
	
	$(".buyNumber .numDown a").click(function(){
		if(cutNumber > 1){
			cutNumber -= 1;
			$(".buyNumber input.num").val(cutNumber);
		}
	});
	
}

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


//购买数量修改。
function buyNumberBindFunction(){
	
	var cutNumber = $(".buyNumber input.num").val()*1;
	$(".buyNumber .numUp a").click(function(){
		cutNumber += 1;
		$(".buyNumber input.num").val(cutNumber);
	});
	
	$(".buyNumber .numDown a").click(function(){
		if(cutNumber > 1){
			cutNumber -= 1;
			$(".buyNumber input.num").val(cutNumber);
		}
	});
	
}

// 添加到购物车
function addToCate(){
	$("input.addtocart").click(function(){
		var _top = $(this).offset().top - 10;
		var _left = $(this).offset().left - 30;
		$("#addToCateWin").css({'left':_left,'top':_top});
		$("#addToCateWin").show();
	});
	
	$("#addToCateWin a.opt").click(function(){
		$("#addToCateWin").hide();	
	});
}


// 商品详情处交互
function chgProductTabs(){
	$("#productTabs li a").click(function(){
		$("#productTabs li").removeClass("on");
		$(this).parent("li").addClass("on");
		var _id = $(this).attr("data");
		$(".prosection").hide();
		$("#"+_id).show();
	});	
}

// 排序js交互
function chgSortList(){
	var flag = true;
	$("#sortList ul li a").click(function(){
		$(this).find(".ii").toggleClass("i02");
		if($(this).find(".ii").hasClass("i02")){
			flag = true;
		}else{
			flag = false;
		}
		$("#sortList ul li").removeClass("on");
		$(this).parent("li").addClass("on");
		
		var sortType = $(this).attr("data");
		
		sortFunction(sortType,flag);
		
	});
}

// 排序方法
function sortFunction(sortType,flag){
	if(flag){
		console.log(sortType+"升序");
	}else{
		console.log(sortType+"降序");
	}
}

// 删除商品js
function cartDel(){
	$("a.cartDel").click(function(){
		var _top = $(this).offset().top - 86;
		var _left = $(this).offset().left - 65;
		$("#bubbleBox").css({'left':_left,'top':_top});
		$("#bubbleBox").show();
	});
}


// 订单页js
function cartFunc(){
	$(".ap2 .apT a").toggle(function(){
		$(this).html("[关闭]");
		$(this).parent(".apT").next(".apB").find(".userDefault").hide();
		$(this).parent(".apT").next(".apB").find(".userSet").show();;
	},
	function(){
		$(this).html("[修改]");
		$(this).parent(".apT").next(".apB").find(".userDefault").show();
		$(this).parent(".apT").next(".apB").find(".userSet").hide();;
	});	
}


//添加到收藏
function addToCollect(){
	$("input.collect").click(addToCollectFun());
}

function addToCollectFun(){
	console.log('addToCollectFun start!!');
	var _top = $('#favorite_link').offset().top - 60;
	var _left = $('#favorite_link').offset().left - 30;
	$("#bubbleBox").css({'left':_left,'top':_top}); 
	$("#bubbleBox").show(); 
	// ajax 提交收藏 
	$("#bubbleBox").fadeOut(4000);
	console.log('addToCollectFun end!!');
}
 
 
//大图弹窗提示
function showPopUp(){
	windowHeight = $(window).height();
	windowWidth = $(window).width();
	$("#mwMask").css({"height":windowHeight,"width":windowWidth,"display":"block"});
	var _height = (windowHeight -$("#mwPopUp").height())/2;
	var _width = (windowWidth -$("#mwPopUp").width())/2;
	$("#mwPopUp").css({"top":_height,"left":_width})
	$("#mwPopUp").show();
	
	//$("a.btn_min").click(function(){
	//	$("#mwMask").hide();
	//	$("#mwPopUp").hide();
	//});
}