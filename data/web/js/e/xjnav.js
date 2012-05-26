/* 导航搜索框 */
function checkSearchFormAction() {
	var val=$("#searchQuery").val();
    if ($.trim(val) == '' || $.trim(val) == '输入关键词') {
		alert('请输入搜索关键词！');
        return false;
    } else {
        return true;
    }
}
function search_kwords(str){
   $("#searchQuery").val(str);
   var searchForm = $('#searchForm');
   searchForm.submit();
}