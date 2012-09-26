<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>修改密码-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi"> 
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/profile.js"></script>
</head>

<body> 
	
	{smarty_include eshop.common.header}
	
	<!-- S crumbs -->
<div class="crumbs">
	<div class="c0">
  	<a href="/">首页</a>&gt;<a href="#" class="on">个人中心</a>  &gt;<a href="#" class="on">修改密码</a>  
  </div>
</div>
<!-- E crumbs -->
	


<!-- S bdy -->
<div class="bdy">
	<div class="c0 A-M">
 	
 	{smarty_include eshop.account.leftnav}

<!-- S main -->
		<div class="MAIN">
			<div class="c">
			
				<!-- S tables -->
				<div class="ap"> 
					<div class="dataTable dataTable1">
						<div id="ajax-response"></div>
								<form id="passwd_frm" method="post" action="/app/eshop/profile/do_passwd"> 
										<table >
												<tr class="tr_lin">
		<td colspan="2">修改密码</td>
	</tr>
										
											<tr>
												<td class="td_right">我的旧密码：</td>
												<td><i class="txt txt2"><input type="password" name="old_password" class="s" /></i></td>
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
				<!-- E tables -->

			</div>
		</div>
<!-- E main -->

	</div>
</div>
<!-- E bdy --> 
 

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
	
</div>
</body>
</html>