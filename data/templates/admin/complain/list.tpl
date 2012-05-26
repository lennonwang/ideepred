<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>客户反馈管理－新花样</title>
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
		<h1>客户反馈列表</h1>
		<div id="content-main">
			<div id="changelist">
				<table cellspacing="0">
					<thead>
						<tr class="t_title">
							<th>  </th>
							<th> ID </th>
							<th> 姓 名/联系方式 </th>
							<th> 类 别 </th>
							<th> 意 见 </th>
							<th> 更新时间 </th>
							<th> 执行操作 </th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$complains item=cpn}
						<tr id="article_tr_{$cpn.id}">
							<td>
								<input type="checkbox" value="{$cpn.id}" />
							</td>
							<td>{$cpn.id}</td>
							<td>{$cpn.name} - {$cpn.mobie} - {$cpn.email}</td>
							<td>{if $cpn.type eq 1}网站建设{elseif $cpn.type eq 2}订单发货{elseif $cpn.type eq 3}售后服务{else}其他{/if}</td>
							<td>{$cpn.summary}</td>
							<td>{$cpn.created_on}</td>
							<td>
								<a class="jq_a_ajax" href="/app/admin/complain/remove/id/{$cpn.id}" title="delete">删除</a>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
			<div class="clearer"></div>
			{assign var=url_prefix value="/app/admin/complain/display"}
			{smarty_include admin.pager}
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/complain/display" title="反馈列表">反馈列表</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
	{smarty_include admin.footer}
</div>
</body>
</html>