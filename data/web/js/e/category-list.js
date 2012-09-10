 
 $(document).ready(function() {
		$(document).iFadeSlide(); 
		if($("#sortList").size() > 0){
			chgSortList();	
		}
}); 

// 排序js交互
function chgSortList(){
	var flag = true;
	$("#sortList ul li a").click(function(){
		// $(this).find(".ii").toggleClass("i02");
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
 