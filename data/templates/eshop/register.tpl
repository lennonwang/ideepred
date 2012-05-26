<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>新用户注册-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/register.js"></script>
</head>

<body>
{smarty_include eshop.common.tophead}
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		
		<div class="box">
			<div class="bordor profile">
				<h2>新用户注册</h2>
				<p class="hotlink">带*的项目为必填项</p>
				
				<form method="post" action="/app/eshop/profile/do_register" name="profile" id="user_register">
					<input type="hidden" name="id" value="" id="user_id" />
					<table>
						<tr>
							<th><label for="account"><em class="hotlink">*</em>请填写您的Email地址：</label></th>
							<td>
								<input type="text" name="account" value="" class="middle-text" />
								<br />
								<p class="desription">请填写有效的Email地址，作为下次登录的用户名</p>
							</td>
						</tr>
						<tr>
							<th><label for="password"><em class="hotlink">*</em>请设定密码：</label></th>
							<td>
								<input type="password" name="password" value="" class="middle-text" id="password" />
								<br />
								<p class="desription">密码请设为6-16位字母或数字</p>
							</td>
						</tr>
						<tr>
							<th><label for="confrimpassword"><em class="hotlink">*</em>请再次输入设定密码：</label></th>
							<td><input type="password" name="confrimpassword" value="" class="middle-text" /></td>
						</tr>
						<tr>
							<th><label for="username"><em class="hotlink">*</em>昵 称：</label></th>
							<td><input type="text" name="username" value="" class="middle-text" />
								<br />
								<p class="desription">请输入中英文、数字、下划线或它们的组合</p>
							</td>
						</tr>
						<tr>
							<th><label for="checkcode">请输入验证码：</label></th>
							<td class="a999">
								<div class="clearfix">
									<input type="text" name="checkcode" value="" class="small-text" id="input_checkcode" />
									<a href="#change_check_code" class="jq_a_ajax" id="change_checkcode">看不清，换一张</a>
								</div>
								<p class="desription">验证码区分大小写</p>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input type="submit" name="_submit" value="完成" class="submited signup" />
								<div class="clear"></div>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<br />
								<p>有任何疑问请点击 <a href="{Common_Smarty_Url_format key=helper name=register}" class="hotlink">帮助中心</a> 或 <a href="{Common_Smarty_Url_format key=introduce name=contact}" class="hotlink">联系客服</a></p></td>
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