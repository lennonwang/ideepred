<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<meta name="author" content="xiaoyi">
	<link href="/csstyle/xe-mainstyle.css" type="text/css" rel="stylesheet" />
	{literal}
	<script type="text/javascript" src="/js/c/jquery-1.2.6.js"></script>
	<script type="text/javascript">
		function out(){
			parent.location.href='/app/admin/authorize/logout';
		}
		function back(){
	{/literal}
			parent.location.href='{Common_Smarty_Url_format key=domain}';
	{literal}
		}
	</script>
	{/literal}
</head>

<body>
	<div id="amheader">
		<h1>iDeepRed管理系统</h1>
		<div id="amhead-info">
			<div id="user_info">
				<p><a title="Edit your profile" href="/app/admin/user/edit?id={$admin_id}" target="mainFrame">{$admin_name}</a>  |  <a href="javascript:back();" title="不知道自己在哪?">← 返回 首页</a>  |  <a title="退出" href="javascript:out();">退出</a></p>
			</div>

		</div>
		<div class="clear"></div>
	</div>
</body>
</html>