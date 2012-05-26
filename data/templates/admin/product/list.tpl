<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/c/jquery.checkboxes.js"></script>
	<script type="text/javascript" src="/js/a/product.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>产品列表 <a class="button add-new-h2" title="添加新产品" href="/app/admin/product/edit">添加新产品</a></h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="get" action="/app/admin/product">
				<ul class="subsubsub">
					<li><a href="/app/admin/product">全部<span class="count">({$all_records})</span></a> |</li>
					<li><a href="/app/admin/product/fetch_list/state/1">已发布<span class="count">({$published_records})</span></a> |</li>
					<li><a class="current" href="/app/admin/product/fetch_list?state=0">草稿<span class="count">({$unpublished_records})</span></a></li>
				</ul>
				
				<p class="search-box">
					<label for="post-search-input" class="screen-reader-text">搜索产品:</label>
					<input type="text" value="" name="query" id="post-search-input" gtbfieldid="220">
					<input type="submit" class="button" value="搜索产品">
				</p>
				
				<div class="clear"></div>
				<div class="tablenav">
					<div class="alignleft actions">
						<select class="select-action" name="action" gtbfieldid="164">
							<option selected="selected" value="-1">批量动作</option>
							<option value="delete">永久删除</option>
							<option value="published">推荐</option>
						</select>
						<input type="button" class="button-secondary action" id="doaction" name="doaction" value="应用">
						
						<select class="select-action" name="catcode" gtbfieldid="164">
							<option selected="selected" value="">请选择筛选分类</option>
							{foreach from=$all_category item=category}
							<option value="{$category.code}" {if $category.code eq $catcode }selected="selected"{/if}>{if $category.classname eq 'oneblank'}---{elseif $category.classname eq 'twoblank'}------{/if}{$category.name}</option>
							{/foreach}
						</select>
						
						<select class="select-action" name="store_id" gtbfieldid="164">
							<option selected="selected" value="">请选择品牌</option>
							{foreach from=$store_list item=store}
							<option value="{$store.id}" {if $store.id eq $store_id }selected="selected"{/if}>{$store.title}</option>
							{/foreach}
						</select>
						
						<input type="submit" class="button-secondary action" name="doaction" value="过滤">
					</div>
					{assign var=url_prefix value="/app/admin/product/fetch_list?catcode=$catcode&query=$query&store_id=$store_id"}
					<div class="tablenav-pages">
						<span class="displaying-num">显示 {$start}&ndash;{$end} 共 {$records} </span>
						{if $page gt 1}
						<a href="{$url_prefix}&page={$page-1}" class="prev page-numbers">«</a>
						{/if}
						{if $page gte 6 && $total gt 8}
						<a href="{$url_prefix}&page=1" class="page-numbers">1</a>
						<span class="page-numbers dots">...</span>
						{/if}
						{foreach from=$page_list item=p}
						{if $p eq $page}
						<span class="page-numbers current">{$p}</span>
						{else}
						<a href="{$url_prefix}&page={$p}" class="page-numbers">{$p}</a>
						{/if}
						{/foreach}
						{if $page lte $total-5 && $total gt 8}
						<span class="page-numbers dots">...</span>
						<a href="{$url_prefix}&page={$total}" class="page-numbers">{$total}</a>
						{/if}
						{if $page lt $total}
						<a href="{$url_prefix}&page={$page+1}" class="next page-numbers">»</a>
						{/if}
					</div>
					
				</div>
				<table cellspacing="0" class="widefat fixed picxe">
					<thead>
						<tr>
							<th class="check-column"> <input type="checkbox" class="selectscope" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="column-title"> 产品标题 </th>
							<th class="column-name"> 产品SKU </th>
							<th class="column-name"> 市场价 </th>
							<th class="column-name"> 优惠价 </th>
							<th class="column-name"> 状 态 </th>
							<th class="column-name"> 日 期 </th>
							<th class="column-name"> 操 作 </th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"> <input type="checkbox" class="selectscope" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="column-title"> 产品标题 </th>
							<th class="column-name"> 产品SKU </th>
							<th class="column-name"> 市场价 </th>
							<th class="column-name"> 优惠价 </th>
							<th class="column-name"> 状 态 </th>
							<th class="column-name"> 日 期 </th>
							<th class="column-name"> 操 作 </th>
						</tr>
					</tfoot>
					<tbody id="category-lister">
						{foreach from=$product_list item=product name="product"}
						<tr id="product_tr_{$product.id}" class="iedit{if $smarty.foreach.product.iteration%2 } alternate{/if}">
							<th class="check-column" scope="row">
								<input type="checkbox" value="{$product.id}" name="delete[]" class="xe-shid" />
							</th>
							<td>
								<img height="90" width="90" class="attachment-80x60" src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb}" >
							</td>
							<td>
								<strong><a href="/app/admin/product/edit/id/{$product.id}" class="row-title">{$product.title} </a> {if $product.state eq 0}-草稿{/if}</strong>
								<div class="row-actions"><span class="edit"><a href="/app/admin/purchase/update_quantity/product_id/{$product.id}">变更数量</a></span> | <span class="edit"><a href="/app/admin/product/edit/id/{$product.id}">编辑</a></span> | <span class="publish"><a href="/app/admin/product/published/id/{$product.id}/stick/{if $product.stick eq 0}1{else}0{/if}" class="jq_a_ajax">{if $product.stick eq 0}推荐{else}取消推荐{/if}</a></span> | <span class="marked"><a href="/app/admin/product/marked/id/{$product.id}/markshop/{if $product.markshop eq 0}1{else}0{/if}" class="jq_a_ajax">{if $product.markshop eq 0}实体商品{else}取消实体商品{/if}</a></span> | <span class="delete"><a href="/app/admin/product/delete/id/{$product.id}" class="jq_a_ajax">删除</a></span></div>
							</td>
							<td>{$product.id}</td>
							<td>{$product.market_price}</td>
							<td>{$product.sale_price}</td>
							<td>{if $product.state eq 1}上架{elseif $product.state eq 2}展示{elseif $product.state eq -1}下架{else}默认未发布{/if}</td>
							<td>{$product.created_on}</td>
							<td> 
								<div id="done_show_{$product.id}">
								{if $product.stick eq 1}
								<img src="/images/admin/icon_editor_choice.gif" id="stick_img_{$product.id}" />
								{/if} 
								{if $product.markshop eq 1}
								<img src="/images/admin/icon_accept.gif" id="markshop_img_{$product.id}" />
								{/if}
								</div>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</form>
		</div>
		
	</div>
</div><!--endwrap-->
</body>
</html>