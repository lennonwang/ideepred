<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>产品管理－新花样</title>
	<meta name="author" content="purpen">
	<link href="/csstyle/changelist.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/c/jquery.checkboxes.js"></script>
	<script type="text/javascript" src="/js/a/product_list.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		{if $state eq 0}
		<h1>未上架商品列表</h1>
		{/if}
		{if $state eq 1}
		<h1>已发布商品列表</h1>
		{/if}
		{if $state eq -1}
		<h1>已下架商品列表</h1>
		{/if}
		<div id="content-main">
			<div class="buttons">
				<div class="aleft">选择：<a href="#selected_all" class="jq_a_ajax">全选</a> <a href="#selected_reverse" class="jq_a_ajax">反选</a> <a href="#selected_none" class="jq_a_ajax">无</a></div>
				<div class="aright">操作: {if $state eq 0}<a href="/app/admin/goods/checking/state/1#done_batch" class="jq_a_ajax">审核</a>{/if}{if $state eq 1}<a href="/app/admin/goods/checking/state/0#done_batch" class="jq_a_ajax">返回待核</a>{/if}<a href="/app/admin/goods/remove#done_batch" class="jq_a_ajax">删除</a></div>
				<div class="aright">排序: <a href="/app/admin/goods/display?orderby=1&state={$state}&category_id={$category_id}" title="上传时间" {if $order_by eq 1}class="tis"{/if}>上传时间</a> <a href="/app/admin/goods/display?orderby=2&state={$state}&category_id={$category_id}" title="查看次数" {if $order_by eq 2}class="tis"{/if}>查看次数</a> <a href="/app/admin/goods/display?orderby=3&state={$state}&category_id={$category_id}" title="购买次数" {if $order_by eq 3}class="tis"{/if}>购买次数</a></div>
				<div class="clearer"></div>
			</div>
			<div id="changelist">
				{foreach from=$products item=product}
				<div class="product {if $product.designer_id eq $product.created_by}dgrself{/if}" id="product_item_{$product.id}">
					<img src="{$product.thumb}" width="176" />
					<div class="picoperate">
						<input type="checkbox" name="ids[]" value="{$product.id}" class="pro_c" />
						<a href="/app/admin/goods/edit/id/{$product.id}" title="modify">修改</a>
						{if $state eq 0}
						<a class="jq_a_ajax" href="/app/admin/goods/remove/id/{$product.id}" title="delete" >删除</a>
						<a href="/app/admin/goods/checking/state/1/id/{$product.id}" title="审核" class="jq_a_ajax">审核</a>
						{/if}
						{if $state eq 1}
						<a href="/app/admin/goods/checking/state/0/id/{$product.id}" title="返回待核" class="jq_a_ajax">返回待核</a>
						{/if}
						{if $state neq -1}
						<a href="/app/admin/goods/checking?state=-1&id={$product.id}" title="下架" class="jq_a_ajax">下架</a>
						{/if}
						{if $state eq -1}
						<a href="/app/admin/goods/checking/state/1/id/{$product.id}" title="重新上架" class="jq_a_ajax">重新上架</a>
						{/if}
					</div>
					<div class="picinfo">
						<h3>{$product.title|stripslashes}</h3>
						<p>ID: {$product.number}</p>
						<p>市场价: {$product.retail_price}元</p>
						<p>优惠价: {$product.sale_price}元</p>
						<p>上传时间: {$product.created_on}</p>
						<p>查看数: {$product.view_count|default:0}  购买数: {$product.buy_count|default:0}</p>
					</div>
				</div>
				{/foreach}
			</div>
			<div class="clearer"></div>
			{assign var=url_prefix 	value="/app/admin/goods/display/orderby/$order_by/state/$state/category_id/$category_id"}
			{smarty_include admin.pager}
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/goods/edit" title="添加新商品">添加新商品</a>
			</p>
			<p>
				> <a href="/app/admin/goods/display" title="所有商品列表">所有商品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/goods/display/state/0" title="未上架商品列表">未上架商品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/goods/display/state/1" title="已发布商品列表">已发布商品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/goods/display?state=-1" title="已下架商品列表">已下架商品列表</a>
			</p>
			
		</div>
		<div class="clearer"></div>
	</div>
	{smarty_include admin.footer}
</div>
</body>
</html>