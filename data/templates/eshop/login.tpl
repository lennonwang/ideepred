<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>登录--{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/login.js"></script>
</head>

<body>
{smarty_include eshop.common.tophead}
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			<div class="bordor profile">
				<h2 class="ft14">登录爱深红</h2>
				
				<form method="post" action="/app/eshop/profile/do_login" name="profile" id="user_login">
					<div id="reqstatus_boxes"></div>
					<table>
						<tr>
							<th><label for="account">您的Email地址：</label></th>
							<td><input type="text" name="account" value="" class="middle-text" /></td>
						</tr>
						<tr>
							<th><label for="password">您的密码：</label></th>
							<td><input type="password" name="password" value="" class="middle-text" /></td>
						</tr>
						<tr>
							<th></th>
							<td class="remember">
								<input type="checkbox" name="remember" value="1" /> 记住我(一个月之内不再登陆)
								<br />
								<!--<a href="#" class="forgot">忘记密码？</a>-->
							</td>
						</tr>
						<tr>
							<th></th>
							<td class="a999 clearfix">
								<input type="submit" name="_submit" value="完成" class="submited" /> 
								<a href="{Common_Smarty_Url_format key=register}" class="register"/>注册一个新帐户</a>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<br />
								<p>有任何疑问请点击 <a href="#" class="hotlink">帮助中心</a> 或 <a href="#" class="hotlink">联系客服</a></p></td>
						</tr>
					</table>
				</form>
			</div>
		</div>

	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>