<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>个人资料-个人帐户管理</title>
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
  	<a href="/">首页</a>&gt;<a href="#" class="on">个人中心</a>  &gt;<a href="#" class="on">编辑个人资料</a>  
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
									<form method="post" action="/app/eshop/profile/update_user" id="euser_frm">
										<input type="hidden" name="id" value="{$user.id}" />
									<table  >
										<tr class="tr_lin">
										<td colspan="2">个人信息</td>
									</tr>
										{assign var=metas value=$user.meta}
										<tr>
											<td class="td_right">昵称：</td>
											<td>
											<i class="txt txt2"><input type="text" name="username" class="s" value="{$user.username}"/></i>
											
											</td>
										</tr>
										<tr>
											<td class="td_right">居住地：</td>
											<td><input type="text" name="address" class="b" value="{$metas.address}" /> </td>
										</tr>
										<tr>
											<td class="td_right">手机：</td>
											<td><input type="text" name="mobie" class="s" value="{$metas.mobie}" /></td>
										</tr>
										<tr>
											<td class="td_right">职业：</td>
											<td><input type="text" name="job" class="s" value="{$metas.job}"/></td>
										</tr>
										<tr>
											<td class="td_right">生日：</td>
											<td>
												<input type="text" name="birthday" class="s" value="{$metas.birthday}"/><span class="s_tips" >(eg: 1978-03-24)</span>
											</td>
										</tr>
										<tr>
											<td class="td_right">博客地址：</td>
											<td><input type="text" name="blog" class="b" value="{$metas.blog}"/></td>
										</tr>
										<tr>
											<td class="td_right">自我介绍：</td>
											<td><textarea name="summary">{$metas.summary}</textarea></td>
										</tr>
										<tr class="bh">
											<td></td>
											<td><input type="submit" name="_submit" value="确认修改" class="sm" /></td>
										</tr>
									</table>
								</form>
								</div>
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