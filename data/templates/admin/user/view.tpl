<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Users Info-新花样</title>
	<link href="/csstyle/forms.css" type="text/css" rel="stylesheet" />
	<link href="/csstyle/widgets.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
</head>

<body>
{smarty_plugin Admin_Smarty_System,system}
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>用户详细资料</h1>
		<div id="content-main">
			{assign var=metas value=$user.meta}
			<h3>帐户信息</h3>
			<p>
				<label>帐号：{$user.account}</label> <a href="/app/admin/postoffice/write_letter?email={$user.account}" target="_blank">发邮件</a>
			</p>
			<p>
				<label>昵称：{$user.username}</label>
			</p>
			<h3>扩展信息</h3>
			<p>
				<label>姓名：{$metas.real_name|default:'路人甲'}</label>
			</p>
			<p>
				<label>性别：{if $user.sex eq 'm'}男{else}女{/if}</label>
			</p>
			<p>
				<label>职业：{$metas.job|default:'无'}</label>
			</p>
			<p>
				<label>手机：{$metas.mobie|default:'无'}</label>
			</p>
			<p>
				<label>地址：{$metas.address|default:'无'}</label>
			</p>
			<p>
				<label>QQ：{$metas.qq|default:'无'}</label>
			</p>
			<p>
				<label>MSN：{$metas.msn|default:'无'}</label>
			</p>
			<h3>设备与风格</h3>
			<p>
				<label>使用设备：</label>
				{foreach from=$metas.devices item=dev}
				<label><strong>{$dev}</strong> </label>
				{/foreach}
			</p>
			<p>
				<label>喜爱风格：</label>
				{foreach from=$metas.styles item=style}
				<label><strong>{$style}</strong> </label>
				{/foreach}
			</p>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/user/edit" title="添加用户">添加用户</a>
			</p>
			<p>
				> <a href="/app/admin/user/group" title="用户列表">用户列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/user/group/state/0" title="未激活用户">未激活用户</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/user/group/state/1" title="已激活用户">已激活用户</a>
			</p>
			<p>
				> <a href="/app/admin/user/search" title="查询用户">查询用户</a>
			</p>
			<p>
				> <a href="/app/admin/user/administ" title="管理员列表">管理员列表</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
</body>
</html>