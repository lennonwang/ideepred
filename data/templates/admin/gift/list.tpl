<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>礼品管理－新花样</title>
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
		{if $state eq 1}
		<h1>可兑换礼品列表</h1>
		{/if}
		{if $state eq 0}
		<h1>未审核礼品列表</h1>
		{/if}
		<div id="content-main">
			<div id="changelist">
				{foreach from=$gifts item=gift}
				<div class="product" id="gift_item_{$gift.id}">
					<img src="{$gift.thumb}" width="205" height="125" />
					<div class="picoperate">
						<input type="checkbox" name="ids[]" value="{$gift.id}" />
						<a href="/app/admin/gift/edit/id/{$gift.id}" title="modify">修改</a>
						<a class="jq_a_ajax" href="/app/admin/gift/remove/id/{$gift.id}" title="delete" >删除</a>
						{if $state eq 0}
						<a class="jq_a_ajax" href="/app/admin/gift/checking/id/{$gift.id}/state/1" title="delete" >审核</a>
						{/if}
					</div>
					<div class="picinfo">
						<h3>{$gift.title}</h3>
						<p>市场价: {$gift.price}元</p>
						<p>所需积分: {$gift.point}</p>
						<p>有效时间: {$gift.start_date}-{$gift.end_date}</p>
					</div>
				</div>
				{foreachelse}
				<p>还没有上架礼品？</p>
				{/foreach}
			</div>
			<div class="clearer"></div>
			{assign var=url_prefix value="/app/admin/gift/display"}
			{smarty_include admin.pager}
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/gift/edit" title="上架新礼品">上架新礼品</a>
			</p>
			<p>
				> <a href="/app/admin/gift/display" title="礼品列表">礼品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/gift/display/state/0" title="未审核礼品">未审核礼品</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/gift/display/state/1" title="可兑换礼品">可兑换礼品</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
	{smarty_include admin.footer}
</div>
<div id="imgPreviewWithStyles"></div>
</body>
</html>