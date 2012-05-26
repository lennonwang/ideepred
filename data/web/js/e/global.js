function rowindex(A) {
    if (Browser.isIE) {
        return A.rowIndex
    } else {
        table = A.parentNode.parentNode;
        for (i = 0; i < table.rows.length; i++) {
            if (table.rows[i] == A) {
                return i
            }
        }
    }
}
function getPosition(C) {
    var B = C.offsetTop;
    var A = C.offsetLeft;
    while (C = C.offsetParent) {
        B += C.offsetTop;
        A += C.offsetLeft
    }
    var D = {
        top: B,
        left: A
    };
    return D
}
function cleanWhitespace(B) {
    var B = B;
    for (var A = 0; A < B.childNodes.length; A++) {
        var C = B.childNodes[A];
        if (C.nodeType == 3 && !/\S/.test(C.nodeValue)) {
            B.removeChild(C)
        }
    }
}
function isEmail(B) {
    res = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
    var A = new RegExp(res);
    return ! (B.match(A) == null)
}

function killErrors() {
    return true
}

/* 控制#textarea字符长度 */
//A 类型
//B 字符长度
//C 控制元素的id
function lentxt(A,B,C)
{
  var s_content = $(C)[0].value;

  if(A == 1 && (s_content == '评论不能超过'+B+'个字' || s_content == '字数上限'+B)){
    $(C)[0].value = '';
    return  false;
  }

  var s_num = s_content.replace(/[\r\n]/g, '').length;

  if(s_num > B)
  {
    $(C)[0].value = s_content.substring(0,B);
    return  false;
  }
  else
  {
    return  true;
  }
}
/* 收藏本站 */
function myAddBookmark(B, A) {
    if ((typeof window.sidebar == "object") && (typeof window.sidebar.addPanel == "function")) {
        window.sidebar.addPanel(B, A, "")
    } else {
        window.external.AddFavorite(A, B)
    }
}
/*列表排序*/
function filterBySort(){
	$('#filter_orderby').bind('change',function(){
		var url = $(this).children('option').filter(':selected').val();
		if(url){
			window.location.href=url;
		}
	});
}

//jquery taconite ajax
function hook_taconite_result(){
	$("a.jq_a_ajax").bind('click',function(){
	    var url = eUrl(this.href);
        var hash = this.hash && $.trim(this.hash.substr(1));
	    if (hash != ""){
	        eval(hash + '.call(this);');
	    }else{
		    $.get(url);
		}
		return false;
	});
}
//get url from  href
function eUrl(href){
    var i = href.indexOf("#");
	return (i != -1) ? href.substring(0, i) : href;
}

/*
 * ----------------------------------------------------------------------------------------------
 * Class: Carousel containerID - string - The ID of the HTML element containing
 * the carousel items options - object - rotationSpeed - the speed that the
 * carousel autorotates at animationSpeed - the speed the carousel animates at
 * ----------------------------------------------------------------------------------------------
 */
function Carousel(containerID, options) {
	// store options
	this.options = options;

	// set variables
	this.containerID = containerID
	this.container = $('#' + this.containerID);
	this.rotationSpeed = (options.rotationSpeed) ? options.rotationSpeed : 5000;
	this.animationSpeed = (options.animationSpeed) ? options.animationSpeed	: 500;
	this.currIndex = 0;
	this.maxIndex = 0;
	this.timer = null;
	this.animating = false;

	// Method: init
	this.init = function() {
		var classRef = this;

		// add event handlers to carousel nav items
		$('#' + this.containerID + ' .carousel_nav a').each(function(i) {
			$(this).bind("click", function(e) {
				//modify by purpen
				clearInterval(classRef.timer);
				
				classRef.change(i);
				
				classRef.timer = setInterval(function() {
					classRef.change(false)
				}, classRef.rotationSpeed);
				
				return false;
			});
		});

		this.maxIndex = $('#' + this.containerID + ' .carousel_item').length - 1; // find
		// number
		// of
		// carousel
		// items
		$('#' + this.containerID + ' .carousel_item:first').addClass('active')
				.css('display', 'block'); // show first carousel item
		$('#' + this.containerID + ' .carousel_nav').css('display', 'block'); // display
		// the
		// carousel
		// nav

		this.timer = setInterval(function() {
			classRef.change(false)
		}, this.rotationSpeed); // itialize the auto rotate timer
	}

	// Method: change
	this.change = function(newIndex) {
		if (!this.animating) {
			var classRef = this;
			this.animating = true;

			var newIndex = (newIndex === false) ? this.currIndex + 1 : newIndex; // determine
			// the
			// newIndex
			// if
			// auto
			// rotate
			// is
			// being
			// used
			newIndex = (newIndex > this.maxIndex) ? 0 : newIndex; // make sure
			// newIndex
			// doesn't
			// go past
			// the
			// maxIndex

			var currCarousel = $('#' + this.containerID + ' .carousel_item.active');
			var newCarousel = $('#' + this.containerID + ' .carousel_item')[newIndex];
			var currNav = $('#' + this.containerID + ' .carousel_nav li.active');
			var newNav = $('#' + this.containerID + ' .carousel_nav li')[newIndex];

			currCarousel.fadeOut(this.animationSpeed, function() {

				currNav.removeClass('active');
				$(newNav).addClass('active');

				$(newCarousel).fadeIn(this.animationSpeed, function() {
					currCarousel.removeClass('active');
					$(newCarousel).addClass('active');

					classRef.currIndex = newIndex;
					classRef.animating = false;
				});
			});
		}
	}

	this.init();
}

$(function(){
	hook_taconite_result();
	
	// wire the 'Loading...' indicator
    $('<div id="busy">Loading...</div>')
        .ajaxStart(function() { $(this).show(); })
        .ajaxStop(function()  { $(this).hide(); })
        .appendTo('body');

	filterBySort();
});