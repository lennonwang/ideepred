<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>iDeepRed管理系统</title>
	<meta name="author" content="xiaoyi">
	<link href="/csstyle/xe-mainstyle.css" type="text/css" rel="stylesheet" />
	{literal}
	<style type="text/css">
		frame{
			border-left: #ECF1F4 7px solid;
			border-right: #ECF1F4 7px solid;
			margin:0;
			overflow-x:hidden;
		}
	</style>
	<script type="text/javascript" src="/js/c/jquery-1.2.6.js"></script>
	<script type="text/javascript">
		if (window.top != window){
			window.top.location.href = document.location.href;
		}
		function out(){
			location.href='/app/admin/authorize/logout';
		}
	</script>
	{/literal}
</head>

<frameset rows="52,*" framespacing="0" border="0">
	<frame src="/app/admin/default/top" id="topFrame" name="topFrame" frameborder="no" scrolling="no">
		<frameset cols="175, 10, *" framespacing="0" border="0" id="frame-body">
			<frame src="/app/admin/default/left" id="leftFrame" name="leftFrame" frameborder="no" scrolling="no">
			<frame src="/app/admin/default/click" id="drag-frame" name="drag-frame" frameborder="no" scrolling="no">
			<frame src="/app/admin/default/main" id="mainFrame" name="mainFrame" frameborder="no" scrolling="yes">
		</frameset>
</frameset>
<frameset rows="0, 0" framespacing="0" border="0">
	<frame src="/app/admin/default/footer" id="hiddFrame" name="hiddFrame" frameborder="no" scrolling="no">
</frameset>

</html>