<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>登录爱深红管理系统</title>
	<meta name="author" content="xiaoyi">
	<link href="/csstyle/xe-mainstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="amwrapper">
		<div id="xeheader-mini">
			<p id="backto">
				<a href="{Common_Smarty_Url_format key=domain}" title="不知道自己在哪?">← 返回 首页</a>
			</p>
		</div>
		<div id="am-login">
			<h1>登录iDeepRed管理系统</h1>
			{if $error}
			<div id="ajax-response" class="warning">
				{$error}
			</div>
			{/if}
			<form id="login_frm" method="post" action="/app/admin/authorize/v_login">
				<div class="row">
					<label>用户名:</label>
					<input type="text" name="account" id="user_account" />
				</div>
				<div class="row">
					<label>密 码:</label>
					<input type="password" name="password" id="user_pass" />
				</div>
				<p class="forgetmenot">
					<label><input type="checkbox" value="1" id="rememberme" name="rememberme"> 记住我的登录信息</label>
				</p>
				<div class="row">
					<input type="submit" name="submit" value=" 点击进入> "  class="button-primary" />
				</div>
			</form>
		</div>
	</div>
</body>
</html>