<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>修改密码-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/profile.js"></script>
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			<div class="bordor profile">
				<h2>个人帐户管理</h2>
				
				<div class="box clearfix">
					<div class="leftref noborder" id="channelside">
						{smarty_include eshop.account.leftnav}
					</div>
					<div class="righttwo2" id="contentlist">
						<div class="a_item contentbox">
							<div class="contentbaby">
								
								<div class="a_item">
									<div id="ajax-response"></div>
									<form id="passwd_frm" method="post" action="/app/eshop/profile/do_passwd">
										<table class="td_child no_side">
											<tr>
												<td class="td_right">我的旧密码：</td>
												<td><input type="password" name="old_password" class="s" /></td>
											</tr>
											<tr>
												<td class="td_right">我的新密码：</td>
												<td><input type="password" name="password" class="s" id="password" /></td>
											</tr>
											<tr>
												<td class="td_right">再次输入新密码：</td>
												<td><input type="password" name="repeat_password" class="s" /></td>
											</tr>
											<tr>
												<td></td>
												<td><input type="submit" name="_submit" value="确认修改" class="sm" /></td>
											</tr>
										</table>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
	
</div>
</body>
</html>