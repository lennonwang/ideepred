//jquery taconite ajax
function hook_taconite_result(){
    $("a.jq_a_ajax").livequery(function(){
	    $(this).unbind()
		    .bind('click', function(){
			    var url = getUrl(this.href);
		        var hash = this.hash && this.hash.substr(1);
			    if (hash != ""){
			        eval(hash + '.call(this);');
			    }else{
				    $.get(url);
				}
				return false;
			});			
	});	
}

//get url from  href
function getUrl(href){
    var i = href.indexOf("#");
	return (i != -1) ? href.substring(0, i) : href;
}

//ajax loading status
function hook_loading_progress(){
    $("#ajax_request_progress").livequery(function(){
	    $(this).unbind()
		    .ajaxStart(function(){
			    $(this).show();
			})
			.ajaxComplete(function(){
			    $(this).hide();
			});
	});
}

function hook_history_back(){
	$('input[@name=_back]').bind('click',function(){
		window.location.href = history.back();
	});
}

function hook_go_page(){
	$('#go_page').bind('click', function(){
		var page = $('#inpt_page').val();
		var url_prefix = $('#url_prefix').attr('href');
		if(page > 0){
			window.location.href = url_prefix+'/page/'+page;
		}
	});
}

// 手机号码验证   
jQuery.validator.addMethod("mobile", function(value, element){   
	var length = value.length;
	return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/.test(value));   
}, "请正确填写您的手机号码");

//onload bind
$(function(){
	
	hook_taconite_result();
	hook_loading_progress();
	
	hook_history_back();
	
	hook_go_page();
	
	$('table.widefat tr').hover(function(){
		$(this).find('div.row-actions').css({'visibility':'visible'});
	},function(){
		$(this).find('div.row-actions').css({'visibility':'hidden'});
	});
	
	// wire the 'Loading...' indicator
    $('<div id="busy">Loading...</div>')
        .ajaxStart(function() { $(this).show(); })
        .ajaxStop(function()  { $(this).hide(); })
        .appendTo('body');
});