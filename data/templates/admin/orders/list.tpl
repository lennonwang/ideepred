<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/a/order.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>订单列表</h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="post" action="/app/admin/orders/display">
				<ul class="subsubsub">
					<li><a href="/app/admin/orders">全部<span class="count">({$all_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=20">已成功订单<span class="count">({$published_records})</span></a> | </li>
					<li><a href="/app/admin/orders/display/status/1">等待付款<span class="count">({$wait_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=10">正在配货<span class="count">({$ready_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=15">已发货订单<span class="count">({$send_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=-1">过期订单<span class="count">({$expired_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=-2">已取消订单<span class="count">({$canceled_records})</span></a> | </li>
				</ul>
				
				<p class="search-box">
					<label for="post-search-input" class="screen-reader-text">搜索订单:</label>
					<input type="text" value="{$query}" name="query" id="post-search-input" gtbfieldid="220">
					<input type="submit" class="button" value="搜索订单" />
				</p>
				
				<div class="clear"></div>
				<div class="tablenav">
					<div class="alignleft actions">
						<select class="select-action" name="action" gtbfieldid="164">
							<option selected="selected" value="-1">批量动作</option>
							<option value="delete">永久删除</option>
						</select>
						<input type="submit" class="button-secondary action" id="doaction" name="doaction" value="应用">
					</div>
					<div class="alignleft actions">
						<label>开始日期:</label> <input type="text" class="fzit" name="start_date" value="{$start_date}" />
						<label>结束日期:</label> <input type="text" class="fzit" name="end_date" value="{$end_date}" />
						<input type="submit" class="button-secondary action" name="doaction" value="过滤">
					</div>
					{assign var=url_prefix value="/app/admin/orders/display?status=$status&query=$query&start_date=$start_date&end_date=$end_date"}
					{smarty_include admin.prefix-pager}
				</div>
				<table cellspacing="0" class="widefat fixed picxe">
					<thead>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="manage-column column-name"> 订单编号 </th>
							<th class="manage-column column-name"> 收货人姓名 </th>
							<th class="manage-column column-name"> 联系电话 </th>
							<th class="manage-column column-name"> 下单时间 </th>
							<th class="manage-column column-name"> 总金额 </th>
							<th class="manage-column column-name"> 快递费用 </th>
							<th class="manage-column column-name"> 状态 </th>
							<th class="manage-column column-name"> 操作 </th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="manage-column column-name"> 订单编号 </th>
							<th class="manage-column column-name"> 收货人姓名 </th>
							<th class="manage-column column-name"> 联系电话 </th>
							<th class="manage-column column-name"> 下单时间 </th>
							<th class="manage-column column-name"> 总金额 </th>
							<th class="manage-column column-name"> 快递费用 </th>
							<th class="manage-column column-name"> 状 态 </th>
							<th class="manage-column column-name"> 操 作 </th>
						</tr>
					</tfoot>
					<tbody id="category-lister">
						{foreach from=$orders item=order name="ord"}
						<tr id="order_tr_{$order.id}" class="iedit{if $smarty.foreach.ord.index%2 == 0} alternate{/if}">
							<th class="check-column" scope="row">
								<input type="checkbox" value="{$order.id}" name="delete[]" />
							</th>
							<td>
								<strong><a href="/app/admin/orders/view/id/{$order.id}" class="row-title">{$order.reference} </a></strong>
								<div class="row-actions"><span class="edit"><a href="/app/admin/orders/view/id/{$order.id}">查看</a></span> {if $order.status eq 1} | <span class="delete"><a href="/app/admin/orders/update_status?id={$order.id}&status=0&edit_step=list" class="jq_a_ajax">撤销</a></span>{/if}</div>
							</td>
							<td>{$order.name}</td>
							<td>{$order.mobie}</td>
							<td>{$order.created_on}</td>
							<td>
								<label id="pay_money_{$order.id}">{$order.pay_money}</label>
							</td>
							<td>
								<input type="text" id="freight_{$order.id}" value="{$order.freight}" class="fret" /> <input type="hidden" id="old_freight_{$order.id}" value="{$order.freight}" />
								{if $order.status eq 1}<input type="button" class="button-secondary mdyaction" name="{$order.id}" value="修改">{/if}
							</td>
							<td>{Common_Smarty_DataSet_orderStatus status=$order.status}</td>
							<td> 
								
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
				<br />
				<p class="help">备注：订单查询支持订单号、订货人姓名、手机号、起始时间限制等查询条件.</p>
			</form>
		</div>
		
	</div>
</div><!--endwrap-->
</body>
</html>