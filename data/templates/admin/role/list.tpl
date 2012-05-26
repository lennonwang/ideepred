<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>用户组管理-新花样</title>
	<meta name="author" content="purpen">
	<link href="/csstyle/changelist.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/a/role_list.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>用户组</h1>
		<div id="content-main">
			<div id="changelist">
				<table cellspacing="0">
					<thead>
						<tr class="t_title">
							<th>  </th>
							<th> ID </th>
							<th> 用户组 </th>
							<th> 状态 </th>
							<th> 操作 </th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$roles item=role}
						<tr id="role_tr_{$role.id}">
							<td>
								<input type="checkbox" value="{$role.id}" />
							</td>
							<td>{$role.id}</td>
							<td>{$role.name}</td>
							<td>{$role.state}</td>
							<td>
								<a href="/app/admin/role/edit/id/{$role.id}" title="modify">修改</a>
								<a class="jq_a_ajax" href="/app/admin/role/remove/id/{$role.id}" title="delete">删除</a>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/role/edit" title="添加用户组">添加用户组</a>
			</p>
			<p>
				> <a href="/app/admin/role/group" title="用户组列表">用户组列表</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
</body>
</html>
