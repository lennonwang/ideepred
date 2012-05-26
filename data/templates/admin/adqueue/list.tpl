<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>广告管理-新花样</title>
	<meta name="author" content="purpen">
	<link href="/csstyle/changelist.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/a/advertise.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>广告列表</h1>
		<div id="content-main">
			<div id="changelist">
				<table cellspacing="0">
					<thead>
						<tr class="t_title">
							<th> ID </th>
							<th> 广告图 </th>
							<th> 广告位 </th>
							<th> 执行操作 </th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$queue item=ad}
						<tr id="advertise_tr_{$ad.id}">
							<td>{$ad.id}</td>
							<td>
								<img src="{$ad.thumb}" alt="{$ad.title}" width="60%" />
								<p>标 题：<a href="{$ad.link}" target="_blank">{$ad.title}</a></p>
								<p>起始日期：{$ad.start_date} -- {$ad.end_date}</p>
								
							</td>
							<td>{$ad.adp.title}-{$ad.adp.name}</td>
							<td>
								<a href="/app/admin/adqueue/edit/id/{$ad.id}" title="modify">修改</a>
								{if $ad.state eq 0}
								<a class="jq_a_ajax" href="/app/admin/adqueue/remove/id/{$ad.id}" title="delete">删除</a>
								<a class="jq_a_ajax" href="/app/admin/adqueue/checking/id/{$ad.id}/state/1" title="published">发布</a>
								{/if}
								
								{if $ad.state eq 1}
								<a class="jq_a_ajax" href="/app/admin/adqueue/checking/id/{$ad.id}/state/0" title="unpublished">返回待审</a>
								{/if}
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
			<div id="change_content_area"></div>
			{assign var=url_prefix value="/app/admin/adqueue/display/state/$state"}
			{smarty_include admin.pager}
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/advertise/display" title="广告位管理">广告位管理</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/advertise/edit" title="新建广告位">新建广告位</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/advertise/display" title="广告位列表">广告位列表</a>
			</p>
			<p>
				> <a href="/app/admin/adqueue/display" title="广告管理">广告管理</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/adqueue/edit" title="添加广告">添加广告</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/adqueue/display?state=0" title="未审核广告">未审核广告</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/adqueue/display?state=1" title="已审核广告">已审核广告</a>
			</p>
		</div>
		
		<div class="clearer"></div>
	</div>
</div>
</body>
</html>