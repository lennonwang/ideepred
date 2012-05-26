<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>变更产品列表</h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="get" action="/app/admin/purchase">
				<ul class="subsubsub">
					<li><a href="/app/admin/purchase">全部<span class="count">({$all_records})</span></a> |</li>
					<li><a class="current" href="/app/admin/purchase/fetch_list?status=1">未审核<span class="count">({$unpublished_records})</span></a></li>
					<li><a href="/app/admin/purchase/fetch_list?status=2">已审核<span class="count">({$published_records})</span></a> |</li>
					<li><a href="/app/admin/purchase/fetch_list?status=-1">已拒绝<span class="count">({$deny_records})</span></a> |</li>
				</ul>
				
				<div class="tablenav">
					<div class="alignleft actions">
						<select class="select-action" name="action" gtbfieldid="164">
							<option selected="selected" value="-1">批量动作</option>
							<option value="delete">永久删除</option>
						</select>
						<input type="submit" class="button-secondary action" id="doaction" name="doaction" value="应用">
					</div>
					{assign var=url_prefix value="/app/admin/purchase/fetch_list/status/$status"}
					{smarty_include admin.pager}
				</div>
				<table cellspacing="0" class="widefat fixed picxe">
					<thead>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="column-name"> 产品SKU </th>
							<th class="column-title"> 产品名称 </th>
							<th class="column-name"> 产品型号 </th>
							<th class="column-name"> 变更数量 </th>
							<th class="column-name"> 变更类型 </th>
							<th class="column-name"> 申请日期 </th>
							<th class="column-name"> 操 作 </th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="column-name"> 产品SKU </th>
							<th class="column-title"> 产品名称 </th>
							<th class="column-name"> 产品型号 </th>
							<th class="column-name"> 变更数量 </th>
							<th class="column-name"> 变更类型 </th>
							<th class="column-name"> 申请日期 </th>
							<th class="column-name"> 操 作 </th>
						</tr>
					</tfoot>
					<tbody id="category-lister">
						{foreach from=$purchase_list item=purchase name="purchase"}
						<tr id="purchase_tr_{$purchase.id}" class="iedit{if $smarty.foreach.purchase.iteration%2 } alternate{/if}">
							<th class="check-column" scope="row">
								<input type="checkbox" value="{$purchase.id}" name="delete[]" />
							</th>
							<td>
								<img height="90" width="90" class="attachment-80x60" src="{Common_Smarty_Product_photoThumb thumb_path=$purchase.product.thumb}" >
							</td>
							<td>{$purchase.product_id}</td>
							<td>
								<strong><a href="/app/admin/purchase/edit?id={$purchase.id}" class="row-title">{$purchase.product.title}</a></strong>
								{if $purchase.status eq 1}<div class="row-actions"><span class="edit"><a href="/app/admin/purchase/edit?id={$purchase.id}">编辑</a> | </span><span class="delete"><a href="/app/admin/purchase/delete?id={$purchase.id}" class="jq_a_ajax">删除</a></span></div>{/if}
							</td>
							<td>{$purchase.product_size}</td>
							<td>{$purchase.quantity}</td>
							<td>{if $purchase.type eq 1}上货{elseif $purchase.type eq 2}退货{elseif $purchase.type eq 3}补货{elseif $purchase.type eq -1}报损{/if}</td>
							<td>
								{$purchase.created_on}
							</td>
							<td>
								{if $purchase.status eq 1}
								<span class="edit"><a href="/app/admin/purchase/check?id={$purchase.id}&status=2" class="jq_a_ajax">通过</a> | </span><span class="deny"><a href="/app/admin/purchase/check?id={$purchase.id}&status=-1" class="jq_a_ajax">拒绝</a></span>
								{/if}
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