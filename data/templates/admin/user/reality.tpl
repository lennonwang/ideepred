<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>用户管理</title>
	<meta name="author" content="purpen">
	<link href="/csstyle/changelist.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>所用{if $state eq 1}已激活{else}未激活{/if}用户</h1>
		<div id="content-main">
			<div id="changelist">
				<table cellspacing="0">
					<thead>
						<tr class="t_title">
							<th>  </th>
							<th> ID </th>
							<th> 用户名 </th>
							<th> 帐 号 </th>
							<th> 姓 名 </th>
							<th> 手 机 </th>
							<th> 操 作 </th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$users item=user}
						<tr id="user_tr_{$user.id}">
							<td>
								<input type="checkbox" value="{$user.id}" />
							</td>
							<td>{$user.id}</td>
							<td>{$user.username}<span>[{$user.sex}]</span></td>
							<td>{$user.account}</td>
							<td>{$user.meta.real_name}</td>
							<td>{$user.meta.mobie}</td>
							<td>
								<a href="/app/admin/user/view/id/{$user.id}" title="view">查看</a>
								<a href="/app/admin/user/edit/id/{$user.id}" title="modify">修改</a>
								<a class="jq_a_ajax" href="/app/admin/user/remove/id/{$user.id}" title="delete" >删除</a>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
			{assign var=url_prefix value="/app/admin/user/reality_user/state/1"}
			{smarty_include admin.pager}
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
			<p class="action_second">
				> <a href="/app/admin/user/reality_user/state/1" title="实名用户">实名用户</a>
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