<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>信息管理系统</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="xiaoyi">
	<!-- Date: 2010-08-10 -->
	<link href="/csstyle/am-mainstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="amwrapper">
		<div id="amheader">
			{smarty_include admin.system.header}
		</div>
		<div id="ambody">
			<div id="ammenu">
				{smarty_include admin.system.menu}
			</div>
			<div id="amcontainer">
				<h1>Welcome to back!</h1>
				<div id="profile">
					<span>{$user.username}</span>
					<span>级别：{$user.role.name}</span>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
	</div>
</body>
</html>