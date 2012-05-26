<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>栏目分类管理-新花样</title>
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
		{if $state eq 1}
		<h1>可用栏目列表</h1>
		{/if}
		{if $state eq 0}
		<h1>禁用栏目列表</h1>
		{/if}
		<div id="content-main">
			<div id="changelist">
				<table cellspacing="0">
					<thead>
						<tr class="t_title">
							<th>  </th>
							<th> ID </th>
							<th> 栏目名称 </th>
							<th> 总 数 </th>
							<th> 状 态 </th>
							<th> 操 作 </th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$sorts item=sort}
						<tr id="sort_tr_{$sort.id}">
							<td>
								<input type="checkbox" value="{$sort.id}" />
							</td>
							<td>{$sort.id}</td>
							<td>{$sort.name} {if $sort.parent_id}*{/if}</td>
							<td>{$sort.article_count}</td>
							<td>{if $sort.state eq 1}正常{/if}{if $sort.state eq 0}禁用{/if}</td>
							<td>
								{if $state eq 1}
								<a href="/app/admin/sort/edit/id/{$sort.id}" title="modify">修改</a>
								<a class="jq_a_ajax" href="/app/admin/sort/remove/id/{$sort.id}" title="delete">删除</a>
								<a class="jq_a_ajax" href="/app/admin/sort/doing/id/{$sort.id}/state/0" title="close" >禁用</a>
								{/if}
								{if $state eq 0}
								<a class="jq_a_ajax" href="/app/admin/sort/doing/id/{$sort.id}/state/1" title="open" >解禁</a>
								{/if}
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
				> <a href="/app/admin/sort/edit" title="添加栏目">添加栏目</a>
			</p>
			<p>
				> <a href="/app/admin/sort/display?state=1" title="可用栏目列表">可用栏目列表</a>
			</p>
			<p>
				> <a href="/app/admin/sort/display?state=0" title="禁用栏目列表">禁用栏目列表</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
</body>
</html>