<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{if $url}
	<meta http-equiv="refresh" content="2; url={$url}" />
	{/if}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			<div class="bordor profile">				
				<div class="system_tips">
					<p>系统提示:{$message}</p>
					<br />
					<a href="javascript:history.back();">两秒钟后自动返回到上一页</a>
				</div>
			</div>
		</div>

	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>